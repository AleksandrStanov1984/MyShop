<?php


class ModelWorkplaceProduct extends Model
{
    public
    function getProductSmall($product_id, $language)
    {
        $language_id = $language ? $language : $this->config->get('config_language_id');
        $query = $this->db->query("SELECT DISTINCT *, cd.name AS category_name, IF(" . $language_id . " = 3, p.model, p.ukr_model) as model, pd.name AS name, p.image, p.brain_id,
		(SELECT md.name FROM " . DB_PREFIX . "manufacturer_description md WHERE md.manufacturer_id = p.manufacturer_id AND md.language_id = '" . $language_id . "') AS manufacturer,
		(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special,
		(SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . $language_id . "') AS stock_status
		FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) LEFT JOIN " . DB_PREFIX . "category c ON (c.category_id = p2c.category_id)
		LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id)
		LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
		LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)
		LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id)
		WHERE p.product_id = '" . (int)$product_id . "' 
		AND pd.language_id = '" . $language_id . "'
		AND p.status = '1' 
		AND p.date_available <= NOW() 
		AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

        $this->load->model('catalog/product');
        $video = ModelWorkplaceProduct::getProductVideos($product_id, $language_id);
        $images = $this->model_catalog_product->getProductImages($product_id);
        $manufImg = $this->db->query("SELECT image FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id = '" . $query->row['manufacturer_id'] . "'");

        if ($query->num_rows) {
            return array(
                'product_id' => $query->row['product_id'],
                'brain_id' => $query->row['brain_id'],
                'category_id' => $query->row['category_id'],
                'category_name' => $query->row['category_name'],
                'name' => $query->row['name'],
                'description' => $query->row['description'],
                'meta_title' => $query->row['meta_title'],
                'meta_h1' => $query->row['meta_h1'],
                'meta_description' => $query->row['meta_description'],
                'meta_keyword' => $query->row['meta_keyword'],
                'sku' => $query->row['sku'],
                'mpn' => $query->row['mpn'],
                'video' => $video,
                'quantity' => $query->row['quantity'],
                'stock_status_id' => $query->row['stock_status_id'],
                'stock_status' => $query->row['stock_status'],
                'image' => $query->row['image'],
                'images' => $images,
                'day_delivery' => $query->row['day_delivery'],
                'manufacturer_id' => $query->row['manufacturer_id'],
                'manufacturer_image' => $manufImg->row['image'],
                'manufacturer' => $query->row['manufacturer'],
                'price' => (int)$query->row['price'],
                'special' => (int)$query->row['special'],
                'reward' => $query->row['reward'],
                'tax_class_id' => $query->row['tax_class_id'],
                'weight' => $query->row['weight'],
                'length' => $query->row['length'],
                'width' => $query->row['width'],
                'height' => $query->row['height'],
                'diameter_of_pot' => $query->row['diameter_of_pot'],
                'depth_of_pot' => $query->row['depth_of_pot'],
                'minimum' => $query->row['minimum'],
                'pickup' => $query->row['pickup'],
            );
        } else {
            return false;
        }
    }

    public
    function getCategory(): array
    {
        $result = ['status' => 200, 'out' => []];

        $category_id = (int)$this->request->get['category_id'];
        $level = (int)$this->request->get['level'];
        $language_id = (int)$this->request->get['language_id'] ? (int)$this->request->get['language_id'] : $this->config->get('config_language_id');

        if ($category_id && $level) {
            $categoryPath = $this->db->query("SELECT * FROM oc_category_path WHERE category_id = '" . $category_id . "' AND level = '" . $level . "'");
            $category = $this->db->query("SELECT parent_id FROM oc_category WHERE category_id = '" . $category_id . "'");
            $categoryDesc = $this->db->query("SELECT name FROM oc_category_description WHERE category_id = '" . $category_id . "' AND language_id = '" . $language_id . "'");

            if (!empty($categoryPath->row) && !empty($category->row) && !empty($categoryDesc->row)) {
                $c = new stdClass();
                $c->category_id = $categoryPath->row['category_id'];
                $c->parent_id = $category->row['parent_id'];
                $c->level = $categoryPath->row['level'];
                $c->name = $categoryDesc->row['name'];

                $result['out']['category'] = $c;
                $result['success'] = true;
            } else {
                $result['error'] = 'Не найдена Категория с таким уровнем вложености';
                $result['success'] = false;
            }
        } else {
            $result['error'] = 'Данные ID category или level переданы не корректно';
            $result['success'] = false;
        }
        return $result;
    }

    public
    function getProductCart(): array
    {
        $result = ['status' => 400, 'error' => '', 'data' => []];

        $product_id = (int)$this->request->get['productId'];
        $city = (string)$this->request->get['city'];
        $language_id = (int)$this->request->get['language_id'] ? (int)$this->request->get['language_id'] : $this->config->get('config_language_id');

        $result['success'] = false;
        $result['status'] = 400;

        if (!empty($city) && $product_id != 0) {
            $product = $this->getProductSmall($product_id, $language_id);

            if (!empty($product)) {
                $related = $this->getProductRelated($product_id, $language_id);
                $options = $this->getProductOptions($product_id, $language_id);
                $this->load->model('catalog/product');

                $result['data']['delivery'] = $this->getDeliveryInCity($product_id, $city, $language_id);//$result_delivery;
                $result['data']['product'] = $product;
                $result['data']['discounts'] = $this->model_catalog_product->getProductDiscounts($product_id);
                $result['data']['related'] = $related['data'];
                $result['data']['options'] = $options['data'];
                $result['data']['attributes'] = $this->getProductAttributes($product_id, $language_id);

                $result['status'] = 200;
                $result['success'] = true;
            } else {
                $result['error'] = 'Не найден продукт ID';
            }
        } else {
            $result['error'] = 'Не правильное название города или данные продукт ID';
        }
        return $result;
    }

    public
    function getDeliveryByCity(): array
    {
        $result = ['status' => 400, 'error' => '', 'data' => []];

        $product_id = (int)$this->request->get['productId'];
        $city = (string)$this->request->get['city'];
        $language_id = (int)$this->request->get['language_id'] ? (int)$this->request->get['language_id'] : $this->config->get('config_language_id');

        $result['success'] = false;
        if (!empty($city) && $product_id != 0) {
            $res = $this->db->query("SELECT 1 FROM " . DB_PREFIX . "product WHERE product_id = '" . $product_id . "'");

            if (!empty($res->row)) {
                $result['data']['delivery'] = $this->getDeliveryInCity($product_id, $city, $language_id);
                $result['status'] = 200;
                $result['success'] = true;
            } else
                $result['error'] = 'Не найдена доставка по продукт ID ';
        } else
            $result['error'] = 'Не правильное название города или данные продукт ID ';
        return $result;
    }

    public
    function getDeliveryInCity($product_id, $city, $language): array
    {
        $language_id = (int)$language ? (int)$language : $this->config->get('config_language_id');
        $result_delivery = array();

        $status = 1;
        $warehouse = 9001;
        $date = date("Y-m-d H:i:s", time());
        //   $pr = '';

        if ($language_id == 1)
            $pr = 'По тарифам перевозчика';
        if ($language_id == 3)
            $pr = 'За тарифами перевізника';

        $delivery = $this->db->query("SELECT * FROM " . DB_PREFIX . "provider_delivery WHERE product_id = '" . $product_id . "' AND city LIKE '%" . $city . "%' AND status = '" . $status . "' ORDER BY id_provider DESC");// AND ( id_shiping > 1 AND id_shiping < 4)");
        $shipping = $this->db->query("SELECT * FROM " . DB_PREFIX . "provider_shipping_descrioption WHERE language_id = '" . $language_id . "'");

        $delivery_array = array();
        $delivery_ar = array();
        $ar_res = array();

        $cur_np = null;
        $cur_sz_price = null;
        $cur_sz = null;

        $deliv_ar = array();
        foreach ($delivery->rows as $d) {
            array_push($deliv_ar, $d);
        }
        $deliv_min_ar = array();
        foreach ($deliv_ar as $d) {
            array_push($deliv_min_ar, $d['price']);
        }
        $min = min($deliv_min_ar);

        $id = null;
        foreach ($deliv_ar as $d) {
            if ($d['price'] == $min)
                $id = $d['id_provider'];
        }

        if ($delivery->rows) {
            foreach ($delivery->rows as $deliver) {
                if ($deliver['id_provider'] == $id) {
                    foreach ($shipping->rows as $ship) {
                        if ($ship['id'] == $deliver['id_shiping']) {
                            $data = [
                                'id_provider' => $deliver['id_provider'], 'language_id' => $language_id, 'ship_id' => $ship['id'], 'ship_name' => $ship['name'], 'pr' => $pr,
                                'weekend' => $deliver['weekend'], 'day_delivery' => $deliver['day_delivery'], 'date' => $date
                            ];

                            if ($deliver['id_provider'] == $warehouse) {
                                $delivery_array = $this->makeArrayDelivery($data, $deliver['price']);
                                break;
                            } else {
                                if ($deliver['id_shiping'] == 3 && $deliver['status_ship'] == 1)
                                    $delivery_array = $this->makeArrayDelivery($data, $deliver['price']);
                                if (($deliver['id_shiping'] == 3 && $deliver['status_ship'] == 0)) {
                                    $cities = explode(",", $deliver['city']);
                                    if (in_array($city, $cities, true))
                                        $delivery_array = $this->makeArrayDelivery($data, $deliver['price']);
                                } else {
                                    if ($deliver['status_ship'] == 1) {
                                        $delivery_array = $this->makeArrayDelivery($data, $deliver['price']);
                                    } else if ($deliver['status_ship'] == 0) {
                                        $cities = explode(",", $deliver['city']);
                                        if (in_array($city, $cities, true))
                                            $delivery_array = $this->makeArrayDelivery($data, $deliver['price']);
                                    } else
                                        $delivery_array = $this->makeArrayDelivery($data);
                                }
                            }
                        }
                    }
                    array_push($delivery_ar, $delivery_array);
                }
            }
            foreach ($delivery_ar as $d) {
                if ($d['id_provider'] == $warehouse)
                    array_push($ar_res, $d);
                if ($d['ship_id'] == 2)
                    $cur_np = $d;
                if ($d['ship_id'] == 3) {
                    $cur_sz_price = $d['price'];
                    $cur_sz = $d;
                }
            }
        } else {
            $delivery_array = $this->makeArrayDefault($shipping->rows[0]['name'], $pr);
            array_push($delivery_ar, $delivery_array);
            $delivery_array = $this->makeArrayDefault($shipping->rows[1]['name'], $pr);
            array_push($delivery_ar, $delivery_array);
        }

        foreach ($ar_res ? $ar_res : $delivery_ar as $d) {
            if ($d['ship_id'] == 2 || $d['ship_id'] == 3) {
                if ($cur_np && $cur_sz) {
                    if ($d['ship_id'] == 2) {
                        if ($cur_np['price'] != $pr) {
                            if ($cur_sz_price >= $cur_np['price']) {
                                $arr_d = $this->deliveryArr($d['name_shiping'], $d['day_delivery'], $d['price']);
                                array_push($result_delivery, $arr_d);
                            }
                        }
                    }
                    if ($d['ship_id'] == 3) {
                        if ($cur_sz_price <= $cur_np['price']) {
                            $arr_d = $this->deliveryArr($d['name_shiping'], $d['day_delivery'], $d['price']);
                            array_push($result_delivery, $arr_d);
                        }
                    }
                } else {
                    $arr_d = $this->deliveryArr($d['name_shiping'], $d['day_delivery'], $d['price']);
                    array_push($result_delivery, $arr_d);
                }
            } else {
                $arr_d = $this->deliveryArr($d['name_shiping'], $d['day_delivery'], $d['price']);
                array_push($result_delivery, $arr_d);
            }
        }
        return $result_delivery;
    }

    public
    function deliveryArr($name_shiping, $day_delivery, $price): array
    {
        return [
            'name_shiping' => $name_shiping,
            'day_delivery' => $day_delivery,
            'price' => $price
        ];
    }

    public
    function makeArrayDelivery($data = array(), $price = null): array
    {
        $free = '';
        if ($data['language_id'] == 1)
            $free = 'Бесплатно';
        if ($data['language_id'] == 3)
            $free = 'Безкоштовно';

        if ($data['ship_id'] == 4) {
            return [
                'ship_id' => $data['ship_id'],
                'id_provider' => $data['id_provider'],
                'name_shiping' => $data['ship_name'],
                'day_delivery' => '',
                'price' => $free
            ];
        } else {
            if ($price == 0 && $price != null) {
                return [
                    'ship_id' => $data['ship_id'],
                    'id_provider' => $data['id_provider'],
                    'name_shiping' => $data['ship_name'],
                    'day_delivery' => $this->dayDelivery($data['weekend'], $data['day_delivery'], $data['date']),
                    'price' => $free
                    // 'price' => $price == null ? 'AAAAAAAAA' : $price
                ];
            } else {
                return [
                    'ship_id' => $data['ship_id'],
                    'id_provider' => $data['id_provider'],
                    'name_shiping' => $data['ship_name'],
                    'day_delivery' => $this->dayDelivery($data['weekend'], $data['day_delivery'], $data['date']),
                    'price' => $price == null ? $data['pr'] : $price
                ];
            }
        }
    }

    public
    function makeArrayDefault($name_shiping, $pr): array
    {
        return [
            'name_shiping' => $name_shiping,
            'day_delivery' => '',
            'price' => $pr
        ];
    }

    public
    function dayDelivery($weekend, $delivery, $date)
    {
        $day_delivery = '';

        if ($delivery != null) {
            $date1 = date("Y-m-d H:i:s", strtotime($date . '+ ' . $delivery . ' days'));
            (string)$day_name = strftime("%A", strtotime($date1));

            switch ($day_name) {
                case 'Sunday':
                    if ($weekend == 1)
                        $day_delivery = date("Y-m-d H:i:s", strtotime($date1 . '+ 1 days'));
                    else if ($weekend == 2)
                        $day_delivery = date("Y-m-d H:i:s", strtotime($date1 . '+ 1 days'));
                    else
                        $day_delivery = $date1;
                    break;
                case 'Saturday':
                    if ($weekend == 1)
                        $day_delivery = $date1;
                    else if ($weekend == 2)
                        $day_delivery = date("Y-m-d H:i:s", strtotime($date1 . '+ 2 days'));
                    else
                        $day_delivery = $date1;
                    break;
                default:
                    $day_delivery = $date1;
                    break;
            }
        }
        return $day_delivery = strtotime($day_delivery) ? strtotime($day_delivery) : '';
    }

    public
    function getProductVideos($product_id, $language_id): array
    {
        $product_video_data = array();
        $product_video_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_video WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . $language_id . "' ORDER BY sort_order ASC");

        foreach ($product_video_query->rows as $product_video) {
            $product_video_data[] = array(
                'name' => $product_video['name'],
                'video' => $product_video['video']
            );
        }
        return $product_video_data;
    }

    public
    function getProductAttributes($product_id, $language_id): array
    {
        $product_attribute_group_data = array();

        $product_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.product_id = '" . $product_id . "' AND agd.language_id = '" . $language_id . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");

        foreach ($product_attribute_group_query->rows as $product_attribute_group) {
            $product_attribute_data = array();

            $product_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . $product_id . "' AND a.attribute_group_id = '" . (int)$product_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . $language_id . "' AND pa.language_id = '" . $language_id . "' ORDER BY a.sort_order, ad.name");

            foreach ($product_attribute_query->rows as $product_attribute) {
                $product_attribute_data[] = array(
                    'attribute_id' => $product_attribute['attribute_id'],
                    'name' => $product_attribute['name'],
                    'text' => $product_attribute['text']
                );
            }

            $product_attribute_group_data[] = array(
                'attribute_group_id' => $product_attribute_group['attribute_group_id'],
                'name' => $product_attribute_group['name'],
                'attribute' => $product_attribute_data
            );
        }
        return $product_attribute_group_data;
    }

    public
    function getProductOptions($product_id, $language_id)
    {
        $result = ['status' => 400, 'data' => []];
        $product_option_data = array();

        if (gettype($product_id) == "integer" && gettype($language_id) == "integer") {
            $product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . $product_id . "' AND od.language_id = '" . $language_id . "' ORDER BY o.sort_order");

            foreach ($product_option_query->rows as $product_option) {
                $product_option_value_data = array();

                $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . $product_id . "' AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . $language_id . "' ORDER BY ov.sort_order");

                foreach ($product_option_value_query->rows as $product_option_value) {
                    $product_option_value_data[] = array(
                        'product_option_value_id' => $product_option_value['product_option_value_id'],
                        'option_value_id' => $product_option_value['option_value_id'],
                        'name' => $product_option_value['name'],
                        'image' => $product_option_value['image'],
                        'quantity' => $product_option_value['quantity'],
                        'subtract' => $product_option_value['subtract'],
                        'price' => $product_option_value['price'],
                        'price_prefix' => $product_option_value['price_prefix'],
                        'points' => $product_option_value['points'],
                        'points_prefix' => $product_option_value['points_prefix'],
                        'weight' => $product_option_value['weight'],
                        'weight_prefix' => $product_option_value['weight_prefix']
                    );
                }

                $product_option_data[] = array(
                    'product_option_id' => $product_option['product_option_id'],
                    'product_option_value' => $product_option_value_data,
                    'option_id' => $product_option['option_id'],
                    'name' => $product_option['name'],
                    'type' => $product_option['type'],
                    'value' => $product_option['value'],
                    'required' => $product_option['required']
                );
            }
            $result['data'] = $product_option_data;
            $result['success'] = true;
            $result['status'] = 200;
        } else {
            $result['error'] = "Не корректно передан ID товара или языка";
        }
        return $result;
    }

    public
    function getProductRelated($product_id, $language_id): array
    {
        $result = ['status' => 400, 'data' => []];
        $product_data = array();

        if (gettype($product_id) == "integer" && gettype($language_id) == "integer") {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related pr LEFT JOIN " . DB_PREFIX . "product p ON (pr.related_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pr.product_id = '" . (int)$product_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

            foreach ($query->rows as $result) {
                $product_data[$result['related_id']] = $this->getProductSmall($result['related_id'], $language_id);
            }
            $result['data'] = $product_data;
            $result['success'] = true;
            $result['status'] = 200;
        } else {
            $result['error'] = "Не корректно передан ID товара или языка";
        }
        return $result;
    }

    public
    function updateViewed($product_id): array
    {
        $result = ['success' => false, 'status' => 400];
        if (gettype($product_id) == "integer") {
            $res = $this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = (viewed + 1) WHERE product_id = '" . $product_id . "'");

            if ($res) {
                $result['success'] = true;
                $result['status'] = 200;
            } else {
                $result['error'] = "Не удалось обновить товар";
            }
        } else {
            $result['error'] = "Не корректно передан ID товара";
        }
        return $result;
    }

    public
    function carouselProducts(): array
    {
        $result = ['success' => false, 'status' => 400, 'data' => []];

        $product_id = (int)$this->request->get['productId'];
        $module_id = (int)$this->request->get['module_id'];
        $language_id = (int)$this->request->get['language_id'] ? (int)$this->request->get['language_id'] : $this->config->get('config_language_id');

        if ($product_id != 0) {
            $category_id = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . $product_id . "'");
            $category_products = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE category_id = '" . $category_id->row['category_id'] . "' AND product_id != '" . $product_id . "' ORDER BY RAND() LIMIT 30");

            if ($category_products->rows) {
                $products = [];
                foreach ($category_products->rows as $p) {
                    if (count($products) < 12) {
                        $product = $this->db->query("SELECT product_id, image, price, depth_of_pot, height, length, width FROM " . DB_PREFIX . "product WHERE product_id = '" . $p['product_id'] . "' AND status = 1 AND stock_status_id = 7 AND  price > 0");
                        if ($product->row)
                            array_push($products, $product->row);
                    }
                }
                if ($products) {
                    $products_arr = array();

                    foreach ($products as $product) {
                        $special = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . $product['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");
                        $desc = $this->db->query("SELECT name FROM " . DB_PREFIX . "product_description WHERE product_id = '" . $product['product_id'] . "' AND language_id = '" . $language_id . "'");

                        $this->load->model('tool/image');

                        $prod = new stdClass();
                        $prod->name = $desc->row['name'] ? $desc->row['name'] : '';
                        $prod->image = $this->model_tool_image->resize($product['image'], 400, 400);
                        $prod->href = $this->getHrefShort($product['product_id']);
                        $prod->price = (int)$product['price'];
                        $prod->special = $special->row['price'] != null ? (int)$special->row['price'] : '';
                        $prod->depth_of_pot = $product['depth_of_pot'];
                        $prod->height = $product['height'];
                        $prod->width = $product['width'];
                        $prod->length = $product['length'];

                        array_push($products_arr, $prod);
                    }

                    $result['data']['products'] = $products_arr;
                    $result['data']['settings'] = $this->getModule($module_id);
                    $result['data']['category'] = $this->getCategoryById($this->getCategoriesByProductId($product_id), $language_id);
                    $result['success'] = true;
                    $result['status'] = 200;
                } else {
                    $result['error'] = "Не получилось найти соответсвующую категорию товаров по модулю";
                }
            } else {
                $result['error'] = "Не корректно передан ID товара";
            }
        } else {
            $result['error'] = "Не корректно передан ID товара";
        }
        return $result;
    }

    public
    function carouselProductsViewed(): array
    {
        $result = ['success' => false, 'status' => 400, 'data' => []];

        $products_id = $_GET["products"];//(int)$this->request->get['products'];
        $language_id = (int)$this->request->get['language_id'] ? (int)$this->request->get['language_id'] : $this->config->get('config_language_id');
        $show_current_product = (int)$this->request->get['show_current_product'];

        if ($products_id) {
            $product_ids = explode(',', $products_id);

            $product_ids_int = [];
            foreach ($product_ids as $id) {
                array_push($product_ids_int, intval($id));
            }

            $products = array();
            foreach ($product_ids_int as $p_id) {
                if ($show_current_product != $p_id) {
                    $product = $this->db->query("SELECT product_id, image, price, depth_of_pot, height, length, width FROM " . DB_PREFIX . "product WHERE product_id = '" . $p_id . "' AND status = 1 AND stock_status_id != 5 AND  price > 0");
                    if ($product->row)
                        array_push($products, $product->row);
                }
            }

            if ($products) {
                $products_ar = array();

                foreach ($products as $product) {
                    $special = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . $product['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");
                    $desc = $this->db->query("SELECT name FROM " . DB_PREFIX . "product_description WHERE product_id = '" . $product['product_id'] . "' AND language_id = '" . $language_id . "'");

                    $this->load->model('tool/image');

                    $prod = new stdClass();
                    $prod->product_id = $product['product_id'];
                    $prod->name = $desc->row['name'] ? $desc->row['name'] : '';
                    $prod->image = $this->model_tool_image->resize($product['image'], 400, 400);
                    $prod->href = $this->getHrefShort($product['product_id']);
                    $prod->price = (int)$product['price'];
                    $prod->special = (int)$special->row['price'] != null ? (int)$special->row['price'] : '';
                    $prod->depth_of_pot = $product['depth_of_pot'];
                    $prod->height = $product['height'];
                    $prod->width = $product['width'];
                    $prod->length = $product['length'];
                    $prod->category_product = $this->getCategoryById($this->getCategoriesByProductId($product['product_id']), $language_id);

                    array_push($products_ar, $prod);
                }

                $result['data']['products'] = $products_ar;
                $result['success'] = true;
                $result['status'] = 200;
            } else {

                $result['error'] = "Не получилось найти соответсвующуй товар по ID";
            }
        } else
            $result['error'] = "Не корректно передан ID товаров";
        return $result;
    }

    public
    function getHrefShort($product_id): string
    {
        $href = explode("/", $this->url->link('product/product', 'product_id=' . $product_id));
        $count = 0;
        foreach ($href as $h) {
            $count++;
        }
        return '/' . $href[$count - 2] . '/';
    }

    public
    function getModule($module_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "module WHERE module_id = '" . (int)$module_id . "'");
        if ($query->row)
            return json_decode($query->row['setting']);
        else
            return array();
    }

    public
    function getCategoryById($category_id, $language_id)
    {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . $language_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");
        return $query->row;
    }

    public
    function getCategoriesByProductId($product_id)
    {
        if ($this->use_cache) {
            $cachename = 'owlcarousel.getcategoriesbyproductid.' . $product_id;
            $cache = $this->cache->get($cachename);
            if (!$cache || !is_array($cache)) {
                $cache = array();
            }
            if ($cache && isset($cache[$product_id])) {
                return $cache[$product_id];
            }
        }
        $category_query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . $product_id . "' LIMIT 0, 1 ");

        $category_id = false;
        if ($category_query->num_rows) {
            if ($category_query->row['category_id']) {
                $category_id = $category_query->row['category_id'];
            }
        }
        if ($this->use_cache) {
            $cache[$product_id] = $category_id;
            $this->cache->set($cachename, $cache);
        }
        return $category_id;
    }

    public
    function getSettings(): array
    {
        $setting = [];
        $query = $this->db->query("SELECT settings FROM " . DB_PREFIX . "ajax WHERE id = '1'");

        foreach ($query->rows as $result) {
            $setting = $result['settings'];
        }
        if (isset($setting)) {
            $setting = unserialize($result['settings']);
        }
        return $setting;
    }

    public
    function getProductsByCategory(): array
    {
        $res = ['status' => 400, 'error' => '', 'data' => []];
        $res['success'] = false;

        $this->load->language('product/category');
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');

        if (isset($this->request->get['filter_ocfilter']))
            $filter_ocfilter = $this->request->get['filter_ocfilter'];
        else
            $filter_ocfilter = '';

        if (isset($this->request->get['sort']))
            $sort = $this->request->get['sort'];
        else
            $sort = 'p.viewed';

        if (isset($this->request->get['order']))
            $order = $this->request->get['order'];
        else
            $order = 'DESC';

        if (isset($this->request->get['page']))
            $page = $this->request->get['page'];
        else
            $page = 1;

        if (isset($this->request->get['limit']))
            $limit = (int)$this->request->get['limit'];
        else
            $limit = $this->config->get($this->config->get('config_theme') . '_product_limit');

        $data['limit_per_page'] = $limit;

        $data['hide_subcategory_shortcut'] = false;
        if (isset($this->request->get['filter_ocfilter']))
            $data['hide_subcategory_shortcut'] = true;

        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        if (isset($this->request->get['categoryId']))
            $category_id = $this->request->get['categoryId'];
        else
            $category_id = 0;

        $category_info = $this->model_catalog_category->getCategory($category_id);

        if ($category_id > 0) {
            $this->load->model('design/layout');
            $layout_id = $this->model_catalog_category->getCategoryLayoutId($category_id);

            if (!$layout_id)
                $layout_id = $this->model_design_layout->getLayout($category_id);

            $modules = $this->model_design_layout->getLayoutModules($layout_id, 'column_left');

            $data['filter_connected'] = false;
            foreach ($modules as $module) {
                if ($module['code'] == 'ocfilter') {
                    $data['filter_connected'] = true;
                    break;
                }
            }

            if ($category_info) {
                $data['name'] = $category_info['name'];
                $data['series_name'] = $category_info['series_name'];
                $data['show_whl'] = $category_info['show_whl'];
                $data['meta_title'] = $category_info['meta_title'];
                $data['meta_description'] = $category_info['meta_description'];
                $data['meta_keyword'] = $category_info['meta_keyword'];
                $data['image'] = $category_info['image'];
                $data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
                $data['show_desc'] = $category_info['show_desc'];
                $data['breadcrumbs'][] = array(
                    'text' => $category_info['name'],
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['route'])
                );

                $url = '';
                if (isset($this->request->get['filter_ocfilter']))
                    $url .= '&filter_ocfilter=' . $this->request->get['filter_ocfilter'];

                if (isset($this->request->get['sort']))
                    $url .= '&sort=' . $this->request->get['sort'];

                if (isset($this->request->get['order']))
                    $url .= '&order=' . $this->request->get['order'];

                if (isset($this->request->get['limit']))
                    $url .= '&limit=' . $this->request->get['limit'];

                $data['categories'] = array();

                $results = $this->model_catalog_category->getCategories($category_id);

                foreach ($results as $result) {
                    $filter_data = array(
                        'filter_category_id' => $result['category_id'],
                        'filter_sub_category' => true
                    );
                    $children_data = array();

                    $children = $this->model_catalog_category->getCategories($result['category_id']);

                    foreach ($children as $child) {
                        $filter_data = array(
                            'filter_category_id' => $child['category_id'],
                            'filter_sub_category' => true
                        );

                        if ($child['image'])
                            $image_child = $child['image'];
                        else
                            $image_child = 'placeholder.png';

                        $children_data[] = array(
                            'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                            'image' => $image_child,
//                            'href' => $this->url->link('product/category', 'route=' . $result['category_id'] . '_' . $child['category_id'])
                            'href' => $child['category_id']
                        );
                    }

                    if ($result['image'])
                        $image = $result['image'];
                    else
                        $image = 'placeholder.png';

                    $data['categories'][] = array(
                        'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                        'image' => $image,
                        'category_id' => $result['category_id'],
                        'children' => $children_data,
                        'series_name' => $result['series_name'],
                        'href' => $this->url->link('product/category', 'route=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)
                    );
                }

                $data['categ_url'] = $this->url->link('product/category', 'route=' . $this->request->get['path'] . $url);

                $data['products'] = array();

                $filter_data = array(
                    'filter_category_id' => $category_id,
                    'filter_sub_category' => true,
                    'filter_ocfilter' => $filter_ocfilter,
                    'sort' => $sort,
                    'order' => $order,
                    'start' => ($page - 1) * $limit,
                    'limit' => $limit + 1
                );

                $data['total_showed'] = $page * $limit;

                $results = $this->model_catalog_product->getProducts($filter_data);

                $data['product_total'] = count($results);

                //  $product_total = $data['product_total'];

                $data['ocfilter_page_info'] = $this->load->controller('extension/module/ocfilter/getPageInfo');

                if ($data['product_total'] > $limit)
                    array_pop($results);

                foreach ($results as $result) {
                    if ($result['image_dod'])
                        $image = $result['image_dod'];
                    else {
                        if ($result['image'])
                            $image = $result['image'];
                        else
                            $image = 'placeholder.png';
                    }
                    $images = $this->model_catalog_product->getProductImages($result['product_id']);

                    $data['products'][] = array(
                        'image_dod' => $image,
                        'images' => (isset($images[0]['image']) && !empty($images)) ? $images[0]['image'] : $image,
                        'mpn' => $result['mpn'] ? explode(',', $result['mpn']) : false,
                        'special' => (int)$result['special'] ? (int)$result['special'] : false,
                        'price' => (int)$result['price'] ? (int)$result['price'] : false,
                        'rating' => $this->config->get('config_review_status') ? (int)$result['rating'] : false,
                        'stock_status_id' => (int)$result['stock_status_id'],
                        'stock_status' => (in_array($result['stock_status_id'], array(7, 8))) ? $this->language->get('text_instock') : $result['stock_status'],
                        'product_id' => $result['product_id'],
                        'date_added' => $result['date_added'],
                        'viewed' => $result['viewed'],
                        'name' => $result['name'],
                        'height' => round($result['height'], 0),
                        'length' => round($result['length'], 0),
                        'width' => round($result['width'], 0),
                        'diameter_of_pot' => round($result['diameter_of_pot'], 0),
                        'depth_of_pot' => round($result['depth_of_pot'], 0),
                        'model' => $result['model'],
                        'manufacturer' => $result['manufacturer'],
                        'minimum' => $result['minimum'] > 0 ? $result['minimum'] : 1,
                        'href' => $this->url->link('product/product', 'route=' . $this->request->get['route'] . '&product_id=' . $result['product_id'] . $url)
                    );
                }

                $url = '';
                if (isset($this->request->get['filter_ocfilter']))
                    $url .= '&filter_ocfilter=' . $this->request->get['filter_ocfilter'];

                if (isset($this->request->get['limit']))
                    $url .= '&limit=' . $this->request->get['limit'];

                if (isset($this->request->get['sort']))
                    $url .= '&sort=' . $this->request->get['sort'];

                if (isset($this->request->get['order']))
                    $url .= '&order=' . $this->request->get['order'];

                $pagination = new Pagination();
                $pagination->total = $data['product_total'];//$product_total;
                $pagination->page = $page;
                $pagination->limit = $limit;
                $pagination->url = $this->url->link('product/category', 'route=' . $this->request->get['path'] . $url . '&page={page}');

                $data['results'] = sprintf($this->language->get('text_pagination'), ($data['product_total']) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($data['product_total'] - $limit)) ? $data['product_total'] : ((($page - 1) * $limit) + $limit), $data['product_total'], ceil($data['product_total'] / $limit));
            }
        } else {
            $url = '';
            if (isset($this->request->get['path']))
                $url .= '&route=' . $this->request->get['path'];

            if (isset($this->request->get['filter_ocfilter']))
                $url .= '&filter_ocfilter=' . $this->request->get['filter_ocfilter'];

            if (isset($this->request->get['sort']))
                $url .= '&sort=' . $this->request->get['sort'];

            if (isset($this->request->get['order']))
                $url .= '&order=' . $this->request->get['order'];

            if (isset($this->request->get['page']))
                $url .= '&page=' . $this->request->get['page'];

            if (isset($this->request->get['limit']))
                $url .= '&limit=' . $this->request->get['limit'];

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_error'),
                'href' => $this->url->link('product/category', $url)
            );
        }


        if ($data) {
            $res['data']['result'] = $data;
            $res['status'] = 200;
            $res['success'] = true;
        }
        return $res;
    }

    public
    function getCategoryName(): array
    {
        $data = ['status' => 400, 'error' => '', 'data' => []];
        $data['success'] = false;

        $categoryId = (int)$this->request->get['categoryId'];
        $language_id = (int)$this->request->get['language_id'] ? (int)$this->request->get['language_id'] : $this->config->get('config_language_id');

        if (isset($categoryId)) {
            $query = $this->db->query("SELECT name FROM " . DB_PREFIX . "category_description WHERE category_id = '" . $categoryId . "' AND language_id = '" . $language_id . "'");

            if ($query->row) {
                $data['data']['category_name'] = $query->row['name'];
                $data['status'] = 200;
                $data['success'] = true;
            } else
                $data['error'] = "Не получилось найти соответсвующую категорию по ID";
        }
        return $data;
    }

//    public
//    function microdataProducts($products)
//    {
//        $json = array();
//        $json['@context'] = 'http://schema.org';
//        $json['@type'] = 'ItemList';
//        $json['itemListElement'] = array();
//        $i = 1;
//        foreach ($products as $product) {
//            if ($i <= 3) {
//                $json['itemListElement'][] = array(
//                    '@type' => 'ListItem',
//                    'position' => $i,
//                    'url' => $product['href']
//                );
//            }
//            $i++;
//        }
//        $output = '<script type="application/ld+json">' . json_encode($json) . '</script>' . "\n";
//        return $output;
//    }
//
//    public
//    function microdataBreadcrumbs($breadcrumbs)
//    {
//        $json = array();
//        $json['@context'] = 'http://schema.org';
//        $json['@type'] = 'BreadcrumbList';
//        $json['itemListElement'] = array();
//        $i = 1;
//        foreach ($breadcrumbs as $breadcrumb) {
//            $json['itemListElement'][] = array(
//                '@type' => 'ListItem',
//                'position' => $i,
//                'name' => $breadcrumb['text'],
//                'item' => $breadcrumb['href']
//            );
//            $i++;
//        }
//        $output = '<script type="application/ld+json">' . json_encode($json) . '</script>' . "\n";
//        return $output;
//    }


//    public
//    function getProductCart(): array
//    {
//        $result = ['status' => 400, 'error' => '', 'data' => []];
//
//        $product_id = $this->request->get['productId'];
//        $city = (string)$this->request->get['city'];
//        $language_id = (int)$this->request->get['language_id'];
////        $status = 1;
////        $warehouse = 9001;
////        $date = date("Y-m-d H:i:s", time());
////        $pr = '';
////
////        if ($language_id == 1)
////            $pr = 'По тарифам перевозчика';
////        if ($language_id == 3)
////            $pr = 'За тарифами перевізника';
//        $result['success'] = false;
//        $result['status'] = 400;
//
//        if (!empty($city) && is_int($product_id)) {
//            $product = $this->getProductSmall($product_id, $language_id);
//            if (!empty($product)) {
//                // $providers = $this->db->query("SELECT * FROM " . DB_PREFIX . "provider_product WHERE product_id = '" . $product_id . "' AND status_n = '" . $status_n . "'"); old
//                // $providers = $this->db->query("SELECT * FROM " . DB_PREFIX . "provider_product WHERE product_id = '" . $product_id . "' AND aktiv = 1");
////                    if (!$providers) {
////                        $result_delivery = $this->db->query("UPDATE oc_provider_product pp SET pp.status_n = 5 WHERE pp.product_id = '" . $product_id . "'");
////                        if (!$result_delivery) {
////                            $result['error'] = 'Не удалось поминять статус на 5';
////                        }
////                    }
//                //Выборка постовщиков и цен
//                // if (!empty($providers->rows)) {
////                        foreach ($providers->rows as $pr) {
////
////
////                        foreach ($providers->rows as $provider) {
////                            if ($provider['marga'] > $maxMarga) {
////                                $maxMarga = $provider['marga'];
////                            }
////                        }
////                        foreach ($providers->rows as $provider) {
////                            if ($provider['marga'] == $maxMarga) {
////                                array_push($minPrice, $provider['price']);
////                            }
////                        }
////                        $minP = min($minPrice);
////                        $koef = $this->db->query("SELECT * FROM " . DB_PREFIX . "provider_kor_price WHERE min_price <= '" . $minP . "' AND max_price >= '" . $minP . "'");
////
////                        foreach ($providers->rows as $provider) {
////                            if ($provider['marga'] > $maxMarga * $koef->row['koef_mar']) {
////                                array_push($providerMaxMarga, $provider);
////                            }
////                        }
////                        foreach ($providerMaxMarga as $pr) {
////                            if ($pr['price'] < $minP * $koef->row['koef_m_pr']) {
////                                $result_delivery = $this->db->query("UPDATE oc_provider_product pp SET pp.aktiv = 1, pp.date_modified = '" . date('Y-m-deliver H:i:ship') . "' WHERE pp.id_provider = '" . $pr['id_provider'] . "'");
////                                if (!$result_delivery) {
////                                    $result['error'] = 'Не удалось поминять статус aktiv на 1 ';
////                                    break;
////                                }
////
////                                $code_provider = $this->db->query("SELECT code_provider FROM " . DB_PREFIX . "provider WHERE id_provider = '" . $pr['id_provider'] . "'");
////
////                                if ($pr['old_price'] == 0) {
////                                    $res1 = $this->db->query("UPDATE oc_product p SET p.price = '" . $pr['price'] . "', p.date_modified = '" . date('Y-m-deliver H:i:ship') . "', p.stock_status_id = '" . $pr['status_n'] . "', p.vendor = '" . $code_provider->row['code_provider'] . "' WHERE p.product_id = '" . $product_id . "'");
////                                    $res2 = $this->db->query("UPDATE oc_product p SET p.price = NULL WHERE p.product_id = '" . $product_id . "'");
////                                    if (!$res1 || !$res2) {
////                                        $result['error'] = 'Не удалось поминять статус price ';
////                                        break;
////                                    }
////                                } else {
////                                    $res1 = $this->db->query("UPDATE oc_product p SET p.price = '" . $pr['old_price'] . "', p.date_modified = '" . date('Y-m-deliver H:i:ship') . "', p.stock_status_id = '" . $pr['status_n'] . "', p.vendor = '" . $code_provider->row['code_provider'] . "' WHERE p.product_id = '" . $product_id . "'");
////                                    $res2 = $this->db->query("UPDATE oc_product_special ps SET ps.price = '" . $pr['price'] . "' WHERE ps.product_id = '" . $product_id . "'");
////                                    if (!$res1 || !$res2) {
////                                        $result['error'] = 'Не удалось поминять статус price';
////                                        break;
////                                    }
////                                }
////
////                            if ($pr['id_provider'] == $warehouse) {
////                                $result['data']['provider'] = [
////                                    'id_provider' => $pr['id_provider'],
////                                    'price' => $pr['price'],
////                                    'old_price' => $pr['old_price'],
////                                    'status_n' => $pr['status_n'],
////                                ];
////                                break;
////                            } else {
////                                $result['data']['provider'] = [
////                                    'id_provider' => $pr['id_provider'],
////                                    'price' => $pr['price'],
////                                    'old_price' => $pr['old_price'],
////                                    'status_n' => $pr['status_n'],
////                                ];
////                            }
////                        }
////                        }
////Выборка доставки
////                $delivery = $this->db->query("SELECT * FROM " . DB_PREFIX . "provider_delivery WHERE product_id = '" . $product_id . "' AND city LIKE '%" . $city . "%' AND status = '" . $status . "' ORDER BY id_provider DESC");// AND ( id_shiping > 1 AND id_shiping < 4)");
////                $shipping = $this->db->query("SELECT * FROM " . DB_PREFIX . "provider_shipping_descrioption WHERE language_id = '" . $language_id . "'");
////
////                $delivery_array = array();
////                $delivery_ar = array();
////                $ar_res = array();
////
////                $cur_np = null;
////                $cur_sz_price = null;
////                $cur_sz = null;
////
////                if ($delivery->rows) {
////                    foreach ($delivery->rows as $deliver) {
////                        foreach ($shipping->rows as $ship) {
////                            if ($ship['id'] == $deliver['id_shiping']) {
////                                $data = [
////                                    'id_provider' => $deliver['id_provider'], 'language_id' => $language_id, 'ship_id' => $ship['id'], 'ship_name' => $ship['name'], 'pr' => $pr,
////                                    'weekend' => $deliver['weekend'], 'day_delivery' => $deliver['day_delivery'], 'date' => $date
////                                ];
////
////                                if ($deliver['id_provider'] == $warehouse) {
////                                    $delivery_array = $this->makeArrayDelivery($data, $deliver['price']);
////                                    break;
////                                } else {
////                                    if ($deliver['id_shiping'] == 3 && $deliver['status_ship'] == 1)
////                                        $delivery_array = $this->makeArrayDelivery($data, $deliver['price']);
////                                    if (($deliver['id_shiping'] == 3 && $deliver['status_ship'] == 0)) {
////                                        $cities = explode(",", $deliver['city']);
////
////                                        if (in_array($city, $cities, true))
////                                            $delivery_array = $this->makeArrayDelivery($data, $deliver['price']);
////                                    } else {
////                                        if ($deliver['status_ship'] == 1) {
////                                            $delivery_array = $this->makeArrayDelivery($data, $deliver['price']);
////                                        } else if ($deliver['status_ship'] == 0) {
////                                            $cities = explode(",", $deliver['city']);
////
////                                            if (in_array($city, $cities, true))
////                                                $delivery_array = $this->makeArrayDelivery($data, $deliver['price']);
////                                        } else
////                                            $delivery_array = $this->makeArrayDelivery($data);
////                                    }
////                                }
////                            }
////                        }
////                        array_push($delivery_ar, $delivery_array);
////                    }
////                    foreach ($delivery_ar as $d) {
////                        if ($d['id_provider'] == $warehouse)
////                            array_push($ar_res, $d);
////                        if ($d['ship_id'] == 2)
////                            $cur_np = $d;
////                        if ($d['ship_id'] == 3) {
////                            $cur_sz_price = $d['price'];
////                            $cur_sz = $d;
////                        }
////                    }
////                } else {
////                    $delivery_array = $this->makeArrayDefault($shipping->rows[0]['name'], $pr);
////                    array_push($delivery_ar, $delivery_array);
////
////                    $delivery_array = $this->makeArrayDefault($shipping->rows[1]['name'], $pr);
////                    array_push($delivery_ar, $delivery_array);
////                }
////
////                $result_delivery = array();
////                foreach ($ar_res ? $ar_res : $delivery_ar as $d) {
////                    if ($d['ship_id'] == 2 || $d['ship_id'] == 3) {
////                        if ($cur_np && $cur_sz) {
////                            if ($d['ship_id'] == 2) {
////                                if ($cur_np['price'] != $pr) {
////                                    if ($cur_sz_price <= $cur_np['price']) {
////                                        $arr_d = $this->deliveryArr($d['name_shiping'], $d['day_delivery'], $d['price']);
////                                        array_push($result_delivery, $arr_d);
////                                    }
////                                }
////                            }
////                            if ($d['ship_id'] == 3) {
////                                if ($cur_sz_price <= $cur_np['price']) {
////                                    $arr_d = $this->deliveryArr($d['name_shiping'], $d['day_delivery'], $d['price']);
////                                    array_push($result_delivery, $arr_d);
////                                }
////                            }
////                        } else {
////                            $arr_d = $this->deliveryArr($d['name_shiping'], $d['day_delivery'], $d['price']);
////                            array_push($result_delivery, $arr_d);
////                        }
////                    } else {
////                        $arr_d = $this->deliveryArr($d['name_shiping'], $d['day_delivery'], $d['price']);
////                        array_push($result_delivery, $arr_d);
////                    }
////                }
//                $related = $this->getProductRelated($product_id, $language_id);
//                $options = $this->getProductOptions($product_id, $language_id);
//                $this->load->model('catalog/product');
//
//                $result['data']['delivery'] = $this->getDeliveryInCity($product_id, $city, $language_id);//$result_delivery;
//                $result['data']['product'] = $product;
//                $result['data']['discounts'] = $this->model_catalog_product->getProductDiscounts($product_id);
//                $result['data']['related'] = $related['data'];
//                $result['data']['options'] = $options['data'];
//                $result['data']['attributes'] = $this->getProductAttributes($product_id, $language_id);
//
//                $result['status'] = 200;
//                $result['success'] = true;
//            } else {
//                $result['error'] = 'Не найден продукт ID';
//            }
//        } else {
//            $result['error'] = 'Не правильное название города или данные продукт ID';
//        }
//        return $result;
//    }
}