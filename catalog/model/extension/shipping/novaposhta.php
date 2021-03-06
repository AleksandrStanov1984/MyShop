<?php
class ModelShippingNovaPoshta extends Model {
    private $settings;

    public function __construct($registry) {
        parent::__construct($registry);

        require_once(DIR_SYSTEM . 'helper/novaposhta.php');

        $registry->set('novaposhta', new NovaPoshta($registry));

        if (version_compare(VERSION, '3', '>=')) {
            $this->settings = $this->config->get('shipping_novaposhta');
        } else {
            $this->settings = $this->config->get('novaposhta');
        }
    }

    function getQuote($address) {
        unset($this->session->data['shipping_order_cost']);
        unset($this->session->data['shipping_order_name']);
        if (version_compare(VERSION, '2.3', '>=')) {
            $this->load->language('extension/shipping/novaposhta');
        } else {
            $this->load->language('shipping/novaposhta');
        }

        $quote_data = array();
        $url        = $this->config->get('config_secure') ? HTTPS_SERVER : HTTP_SERVER;
        $products 	= $this->cart->getProducts();
        $total 		= $this->currency->convert($this->getTotal($products), $this->config->get('config_currency'), 'UAH');
        $departure 	= $this->novaposhta->getDeparture($products, 0);

        $this->session->data['shippingdata']['cart_weight'] = $departure['weight'];

        if (empty($address['city']) && !empty($this->session->data['shipping_address']['city'])) {
            $address['city'] = $this->session->data['shipping_address']['city'];
        }

        if (!empty($address['city'])) {
            $recipient_city_ref = $this->novaposhta->getCityRef($address['city']);
        } else {
            $recipient_city_ref = '';
        }

        if ($this->settings['calculate_volume']) {
            $volume_weight = $departure['volume'] * 250;
        } else {
            $volume_weight = 0;
        }

        if ($this->settings['autodetection_departure_type']) {
            $departure_type = $this->novaposhta->getDepartureType($departure);
        } else {
            $departure_type = $this->settings['departure_type'];
        }

        if ($this->settings['seats_amount']) {
            $seats = $this->settings['seats_amount'];
        } else {
            $seats = $this->novaposhta->getDepartureSeats($products);
        }

        if ($this->settings['pack'] && !empty($this->settings['pack_type'])) {
            if ($this->settings['autodetection_pack_type']) {
                $pack_type = $this->novaposhta->getPackType($departure);
            } else {
                $pack_type = $this->settings['pack_type'][0];
            }
        }

        foreach ((array)$this->settings['shipping_methods'] as $code => $method) {
            if (empty($method['status'])) {
                continue;
            }

            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$method['geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

            if ($method['geo_zone_id'] && !$query->num_rows) {
                $status = false;
            } elseif ($total < $method['minimum_order_amount']) {
                $status = false;
            } elseif ($method['maximum_order_amount'] && $total > $method['maximum_order_amount']) {
                $status = false;
            } else {
                $status = true;
            }

            if ($status) {
                $cost   = 0;
                $period = 0;
                $img    = '';

                if ($method['name'][$this->config->get('config_language_id')]) {
                    $description = $method['name'][$this->config->get('config_language_id')];
                } else {
                    $description = $this->language->get('text_description_' . $code);
                }

                // Cost
                if ($method['cost'] && (!$method['free_shipping'] || $total < $method['free_shipping'])) {
                    if ($method['api_calculation'] && $recipient_city_ref && $departure['weight']) {
                        $properties_cost = array (
                            'Sender'		=> $this->settings['sender'],
                            'CitySender'	=> $this->settings['sender_city'],
                            'CityRecipient'	=> $recipient_city_ref,
                            'ServiceType'	=> $this->settings['sender_address_type'] . ucfirst($code),
                            'CargoType'     => $departure_type,
                            'Weight'		=> $departure['weight'],
                            'VolumeWeight'	=> $volume_weight,
                            'SeatsAmount'   => $seats,
                            'Cost'			=> $total,
                            'DateTime' 		=> date('d.m.Y')
                        );

                        if (!empty($pack_type)) {
                            $properties_cost['PackCalculate'] = array(
                                'PackRef'   => $pack_type,
                                'PackCount' => $seats
                            );
                        }

                        $cost = $this->novaposhta->getDocumentPrice($properties_cost);
                    }

                    if ($method['tariff_calculation'] && !$cost) {
                        $cost = $this->tariffCalculation($this->settings['sender_address_type'] . ucfirst($code), lcfirst($departure_type), $address['zone_id'], $recipient_city_ref, $departure['weight'], $volume_weight, $total);
                    }

                    // Currency correcting
                    $currency_value = $this->currency->getValue('UAH');

                    if ($cost && $currency_value != 1) {
                        $cost /= $currency_value;
                    }
                }

                // Period
                if ($method['delivery_period']) {
                    if ($recipient_city_ref) {
                        $properties_period = array (
                            'CitySender'	=> $this->settings['sender_city'],
                            'CityRecipient'	=> $recipient_city_ref,
                            'ServiceType'	=> $this->settings['sender_address_type'] . ucfirst($code),
                            'CargoType'     => $departure_type,
                            'DateTime' 		=> date('d.m.Y')
                        );

                        $period = $this->novaposhta->getDocumentDeliveryDate($properties_period);
                    }

                    if (!$period) {
                        $period = $this->getDeliveryPeriod(lcfirst($departure_type), $address['zone_id'], $recipient_city_ref);
                    }
                }

                // Image
                if ($this->settings['image']) {
                    if ($this->settings['image_output_place'] == 'img_key') {
                        $img = $url . 'image/' . $this->settings['image'];
                    }
                }

                // Text
                if ($cost) {
                    $text = $this->currency->format($this->tax->calculate($cost, $method['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } elseif ($method['free_shipping'] && $total >= $method['free_shipping']) {
                    $text = $method['free_cost_text'][$this->config->get('config_language_id')];
                } else {
                    $text = '';
                }

                // Period
                if ($period) {
                    $text_period = $this->language->get('text_period') . $this->plural_tool($period, array($this->language->get('text_day_1'), $this->language->get('text_day_2'), $this->language->get('text_day_3')));
                } else {
                    $text_period = '';
                }

                if($code == 'warehouse'){
                    $this->session->data['shipping_order_name'] = '???????????????? ???? ?????????????????? ?????????? ??????????';
                    $cost = 0.00;
                    $status = true;
                    foreach ($this->cart->getProducts() as $product) {
                        if($product['np_branch'] == ''){
                            $status = false;
                        }
                        $cost += $product['np_branch'];
                    }

                    if($status){
                        $cost = $cost;
                        $text = $this->currency->format($cost, $this->session->data['currency']);
                        $this->session->data['shipping_order_cost'] = $cost;
                    }else{
                        $cost = 0.00;
                        $text = '???? ?????????????? ??????????????????????';
                        $this->session->data['shipping_order_cost'] = '???? ?????????????? ??????????????????????';
                    }

                    if($cost == 0.00 && $status){
                        $cost = 0.00;
                        $text = '??????????????????';
                        $this->session->data['shipping_order_cost'] = '??????????????????';
                    }

                }else{
                    $this->session->data['shipping_order_name'] = '???????????????? ???????????????? ?????????????? ?????????? ??????????';
                    $cost = 0.00;
                    $status = true;
                    foreach ($this->cart->getProducts() as $product) {
                        if($product['np_courier'] == ''){
                            $status = false;
                        }
                        $cost += $product['np_courier'];
                    }

                    if($status){
                        $cost = $cost;
                        $text = $this->currency->format($cost, $this->session->data['currency']);
                        $this->session->data['shipping_order_cost'] = $cost;
                    }else{
                        $cost = 0.00;
                        $text = '???? ?????????????? ??????????????????????';
                        $this->session->data['shipping_order_cost'] = '???? ?????????????? ??????????????????????';
                    }

                    if($cost == 0.00 && $status){
                        $cost = 0.00;
                        $text = '??????????????????';
                        $this->session->data['shipping_order_cost'] = '??????????????????';
                    }

                }

                $quote_data[$code] = array(
                    'code'			=> 'novaposhta.' . $code,
                    'title'			=> $description,
                    'img'			=> $img,
                    'cost'			=> $cost,
                    'tax_class_id'	=> $method['tax_class_id'],
                    'text'			=> $text,
                    'text_period'	=> $text_period
                );
            }
        }


        if ($this->settings['image'] && $this->settings['image_output_place'] == 'title') {
            $title = '<img src="' . $url . 'image/' . $this->settings['image'] . '" width="36" height="36" border="0" style="display:inline-block;margin:3px;">'. $this->language->get('text_title');
        } else {
            $title = $this->language->get('text_title');
        }

        if ($quote_data) {
            return array(
                'code'       => 'novaposhta',
                'title'      => $title,
                'quote'      => $quote_data,
                'sort_order' => $this->config->get('novaposhta_sort_order'),
                'error'      => false
            );
        }
    }

    private function getTotal($products) {
        $total  = 0;
        $totals = array();
        $taxes  = $this->cart->getTaxes();

        $total_data = array(
            'totals' => &$totals,
            'taxes'  => &$taxes,
            'total'  => &$total
        );

        foreach ($products as $product) {
            $total += $product['total'];
        }

        if (isset($this->session->data['coupon'])) {
            if (version_compare(VERSION, '2.3', '>=')) {
                $this->load->model('extension/total/coupon');

                $this->model_extension_total_coupon->getTotal($total_data);
            } elseif (version_compare(VERSION, '2.2', '>=')) {
                $this->load->model('total/coupon');

                $this->model_total_coupon->getTotal($total_data);
            } else {
                $this->load->model('total/coupon');

                $this->model_total_coupon->getTotal($totals, $total, $taxes);
            }
        }

        if (isset($this->session->data['voucher'])) {
            if (version_compare(VERSION, '2.3', '>=')) {
                $this->load->model('extension/total/voucher');

                $this->model_extension_total_voucher->getTotal($total_data);
            } elseif (version_compare(VERSION, '2.2', '>=')) {
                $this->load->model('total/voucher');

                $this->model_total_voucher->getTotal($total_data);
            } else {
                $this->load->model('total/voucher');

                $this->model_total_voucher->getTotal($totals, $total, $taxes);
            }
        }

        if (isset($this->session->data['card'])) {
            if (version_compare(VERSION, '2.3', '>=')) {
                $this->load->model('extension/total/membership_card');

                $this->model_extension_total_membership_card->getTotal($total_data);
            } elseif (version_compare(VERSION, '2.2', '>=')) {
                $this->load->model('total/membership_card');

                $this->model_total_membership_card->getTotal($total_data);
            } else {
                $this->load->model('total/membership_card');

                $this->model_total_membership_card->getTotal($totals, $total, $taxes);
            }
        }

        return $total;
    }

    private function tariffCalculation($service_type, $departure_type, $zone_id, $city, $weight, $volume_weight, $total) {
        if (!in_array($departure_type, array('parcel'))) {
            $departure_type = 'parcel';
        }

        $cost = 45;

        if ($city && $city == $this->settings['sender_city']) {
            $tariff_zone  = 'city';
        } elseif ($zone_id && $zone_id == $this->settings['sender_region']) {
            $tariff_zone  = 'region';
        } else {
            $tariff_zone  = 'Ukraine';
        }

        if ($volume_weight > $weight) {
            $weight = $volume_weight;
        }

        foreach($this->settings['tariffs'][$departure_type] as $v) {
            if (is_array($v)) {
                if ($weight <= $v['weight']) {
                    $cost = (double)$v[$tariff_zone];

                    if ($service_type == 'DoorsWarehouse' || $service_type == 'DoorsDoors') {
                        $cost += (double)$v['overpay_doors_pickup'];
                    }

                    if ($service_type == 'WarehouseDoors' || $service_type == 'DoorsDoors') {
                        $cost += (double)$v['overpay_doors_delivery'];
                    }

                    break;
                }
            }
        }

        if ($this->settings['tariffs'][$departure_type]['additional_commission'] && $total > $this->settings['tariffs'][$departure_type]['additional_commission_bottom']) {
            $cost += $total * (double)$this->settings['tariffs'][$departure_type]['additional_commission'] / 100;
        }

        if ($this->settings['tariffs'][$departure_type]['discount']) {
            $cost -= $cost * (double)$this->settings['tariffs'][$departure_type]['discount'] / 100;
        }

        return round($cost);
    }

    private function getDeliveryPeriod($departure_type, $zone_id, $city) {
        if (!in_array($departure_type, array('parcel'))) {
            $departure_type = 'parcel';
        }

        if ($city && $city == $this->settings['sender_city']) {
            $period = $this->settings['tariffs'][$departure_type]['city_delivery_period'];
        } elseif ($zone_id && $zone_id == $this->settings['sender_region']) {
            $period = $this->settings['tariffs'][$departure_type]['region_delivery_period'];
        } else {
            $period = $this->settings['tariffs'][$departure_type]['ukraine_delivery_period'];
        }

        return $period;
    }

    protected function plural_tool($number, $text) {
        $cases = array (2, 0, 1, 1, 1, 2);

        return $number . ' ' . $text[(($number % 100) > 4 && ($number % 100) < 20) ? 2 : $cases[min($number % 10, 5)]];
    }
}

class ModelExtensionShippingNovaPoshta extends ModelShippingNovaPoshta {

}