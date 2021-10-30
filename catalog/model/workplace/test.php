<?php


class ModelWorkplaceTest extends Model
{
    public function getTest(): array
    {
        $result = ['status' => 200, 'out' => []];

        $product_id = (int)$this->request->get['productId'];
        $city = (string)$this->request->get['city'];

        $maxMarga = 0.00;
        $minPrice = array();
        $providerMaxMarga = array();
        $status_n = 7;
        $warehouse = 9001;

        $result['success'] = false;
        $result['status'] = 400;

        if (!empty($city) && gettype($product_id) == "integer") {
            $isValid = preg_match('/^([a-zA-Zа-яА-ЯёЁ]+[-]?[a-zA-Zа-яА-ЯёЁ]*[-]?[a-zA-Zа-яА-ЯёЁ]*[-]?[a-zA-Zа-яА-ЯёЁ]*)$/i', $city);

            if ($isValid) {
                $providers = $this->db->query("SELECT * FROM " . DB_PREFIX . "provider_product WHERE product_id = '" . $product_id . "' AND status_n = '" . $status_n . "'");
                if (!$providers) {
                    $res = $this->db->query("UPDATE oc_provider_product pp SET pp.status_n = 5 WHERE pp.product_id = '" . $product_id . "'");
                    if (!$res) {
                        $result['error'] = 'Не удалось поминять статус на 5';
                    }
                }
                //Выборка постовщиков и цен
                if ($providers) {
                    foreach ($providers->rows as $provider) {
                        if ($provider['marga'] > $maxMarga) {
                            $maxMarga = $provider['marga'];
                        }
                    }
                    foreach ($providers->rows as $provider) {
                        if ($provider['marga'] == $maxMarga) {
                            array_push($minPrice, $provider['price']);
                        }
                    }
                    $minP = min($minPrice);
                    $koef = $this->db->query("SELECT * FROM " . DB_PREFIX . "provider_kor_price WHERE min_price <= '" . $minP . "' AND max_price >= '" . $minP . "'");

                    foreach ($providers->rows as $provider) {
                        if ($provider['marga'] > $maxMarga * $koef->row['koef_mar']) {
                            array_push($providerMaxMarga, $provider);
                        }
                    }
                    foreach ($providerMaxMarga as $pr) {
                        if ($pr['price'] < $minP * $koef->row['koef_m_pr']) {
                            $res = $this->db->query("UPDATE oc_provider_product pp SET pp.aktiv = 1, pp.date_modified = '" . date('Y-m-d H:i:s') . "' WHERE pp.id_provider = '" . $pr['id_provider'] . "'");
                            if (!$res) {
                                $result['error'] = 'Не удалось поминять статус aktiv на 1 ';
                                break;
                            }

                            $code_provider = $this->db->query("SELECT code_provider FROM " . DB_PREFIX . "provider WHERE id_provider = '" . $pr['id_provider'] . "'");

                            if ($pr['old_price'] == 0) {
                                $res1 = $this->db->query("UPDATE oc_product p SET p.price = '" . $pr['price'] . "', p.date_modified = '" . date('Y-m-d H:i:s') . "', p.stock_status_id = '" . $pr['status_n'] . "', p.vendor = '" . $code_provider->row['code_provider'] . "' WHERE p.product_id = '" . $product_id . "'");
                                $res2 = $this->db->query("UPDATE oc_product p SET p.price = NULL WHERE p.product_id = '" . $product_id . "'");
                                if (!$res1 || !$res2) {
                                    $result['error'] = 'Не удалось поминять статус price ';
                                    break;
                                }
                            } else {
                                $res1 = $this->db->query("UPDATE oc_product p SET p.price = '" . $pr['old_price'] . "', p.date_modified = '" . date('Y-m-d H:i:s') . "', p.stock_status_id = '" . $pr['status_n'] . "', p.vendor = '" . $code_provider->row['code_provider'] . "' WHERE p.product_id = '" . $product_id . "'");
                                $res2 = $this->db->query("UPDATE oc_product_special ps SET ps.price = '" . $pr['price'] . "' WHERE ps.product_id = '" . $product_id . "'");
                                if (!$res1 || !$res2) {
                                    $result['error'] = 'Не удалось поминять статус price';
                                    break;
                                }
                            }

                            if ($pr['id_provider'] == $warehouse) {
                                $result['out']['provider'] = [
                                    'id_provider' => $pr['id_provider'],
                                    'price' => $pr['price'],
                                    'old_price' => $pr['old_price'],
                                    'status_n' => $pr['status_n'],
                                ];
                                break;
                            } else {
                                $result['out']['provider'] = [
                                    'id_provider' => $pr['id_provider'],
                                    'price' => $minP,
                                    'old_price' => $pr['old_price'],
                                    'status_n' => $pr['status_n'],
                                ];
                            }
                        }
                    }

//Выборка доставки
                    $this->load->model('workplace/product');
                    $product = $this->model_workplace_product->getProductSmall($product_id);

                    if (empty($result['error'])) {
                        $status = 1;
                        $delivery = $this->db->query("SELECT * FROM " . DB_PREFIX . "provider_delivery WHERE product_id = '" . $product_id . "' AND city LIKE '%" . $city . "%' AND status = '" . $status . "' AND ( id_shiping > 1 AND id_shiping < 4)");

                        if (!empty($delivery->rows)) {
                            $providersDelivery = $this->db->query("SELECT * FROM " . DB_PREFIX . "provider_product WHERE product_id = '" . $product_id . "' AND aktiv = 1");

                            foreach ($providersDelivery->rows as $p) {
                                foreach ($delivery->rows as $d) {
                                    if ($d['id_provider'] == $warehouse) {
                                        $result['out']['delivery'] = [
                                            'id_provider' => $d['id_provider'],
                                            'id_shiping' => $d['id_shiping'],
                                            'day_delivery' => $d['day_delivery'],
                                            'weekend' => $d['weekend'],
                                            'price' => $d['price']
                                        ];
                                        break;
                                    } else {
                                        if ($d['id_shiping'] == 3 && $d['status_ship'] == 1) {
                                            $result['out']['delivery'] = [
                                                'id_provider' => $d['id_provider'],
                                                'id_shiping' => $d['id_shiping'],
                                                'day_delivery' => $d['day_delivery'],
                                                'weekend' => $d['weekend'],
                                                'price' => $d['price'],
                                            ];
                                          //  break;
                                        } else if ($d['id_shiping'] == 3 && $d['status_ship'] == 0) {
                                            $cities = explode(",", $d['city']);
                                            if (in_array($city, $cities, true)) {
                                                $result['out']['delivery'] = [
                                                    'id_provider' => $d['id_provider'],
                                                    'id_shiping' => $d['id_shiping'],
                                                    'day_delivery' => $d['day_delivery'],
                                                    'weekend' => $d['weekend'],
                                                    'price' => $d['price'],
                                                ];
                                            }
                                        }else {
                                            if($d['status_ship'] == 1) {
                                                $result['out']['delivery'] = [
                                                    'id_provider' => $d['id_provider'],
                                                    'id_shiping' => $d['id_shiping'],
                                                    'day_delivery' => $d['day_delivery'],
                                                    'weekend' => $d['weekend'],
                                                    'price' => $d['price'],
                                                ];
                                            }elseif ($d['status_ship'] == 0) {
                                                $cities = explode(",", $d['city']);
                                                if (in_array($city, $cities, true)) {

                                                    $result['out']['delivery'] = [
                                                        'id_provider' => $d['id_provider'],
                                                        'id_shiping' => $d['id_shiping'],
                                                        'day_delivery' => $d['day_delivery'],
                                                        'weekend' => $d['weekend'],
                                                        'price' => $d['price'],
                                                    ];
                                                }
                                            }else{
                                                $result['out']['delivery'] = [
                                                    'np' => 'Новая почта',
                                                    'np_courier' => $product['np_courier']
                                                ];
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            $result['out']['delivery'] = [
                                'np' => 'Новая почта',
                                'np_courier' => $product['np_courier']
                            ];
                        }
                    } else {
                        $result['status'] = 400;
                    }

                    $result['out']['product'] = $product;
                    $result['status'] = 200;
                    $result['success'] = true;
                } else {
                    $result['error'] = 'Не удалось получить данные постовщиков';
                }
            } else {
                $result['error'] = 'Не удалось получить название города';
            }
        } else {
            $result['error'] = 'Не правильное название города или данные продукт ID';
        }
        return $result;
    }
}
