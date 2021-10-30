<?php
class ModelExtensionShippingPickup extends Model {
	function getQuote($address) {
        unset($this->session->data['shipping_order_cost']);
        unset($this->session->data['shipping_order_name']);
		$this->load->language('extension/shipping/pickup');
        $this->load->model('catalog/product');
        $wiev_ship = 1;
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('pickup_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if (!$this->config->get('pickup_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
            $this->session->data['shipping_order_name'] = $this->language->get('text_title');
			$quote_data = array();

            foreach ($this->cart->getProducts() as $product) {
                $query = $this->db->query("SELECT pickup FROM " . DB_PREFIX . "product WHERE product_id = '" . $product['product_id'] . "'");
                if (isset($query->row['pickup'])) {
                    if ($query->row['pickup'] == 0) {
                        $wiev_ship = 0;
                    }else{
                        $citys = $this->model_catalog_product->getProductPickupCity($product['product_id']);
                        if($citys) {
                            $product_citys = array();
                            foreach ($citys as $city) {
                                $product_citys[] = $city['city'];
                            }
                            if (!in_array($this->session->data['city_product'], $product_citys)) {
                                $wiev_ship = 0;
                            }
                        }
                    }
                }
            }

			$quote_data['pickup'] = array(
				'code'         => 'pickup.pickup',
				'title'        => $this->language->get('text_description'),
				'cost'         => 0.00,
				'tax_class_id' => 0,
				'text'         => $this->currency->format(0.00, $this->session->data['currency'])
			);
            $this->session->data['shipping_order_cost'] = 0.00;
			$method_data = array(
				'code'       => 'pickup',
				'title'      => $this->language->get('text_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('pickup_sort_order'),
				'error'      => false
			);
		}

        if($wiev_ship == 1){
            return $method_data;
        }
	}
}