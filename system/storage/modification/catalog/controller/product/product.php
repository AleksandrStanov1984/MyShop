<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/dump.php'); //for debug only
class ControllerProductProduct extends Controller
{
    private $error = array();

    public function index(){

        $callStartTimeTotal = microtime(true);

        if ($this->config->get('ts_google_analytics_status') && $this->config->get('ts_google_analytics_settings')['ecommerce']['status'] && $this->config->get('ts_google_analytics_settings')['ecommerce']['actionType']['view']) {
            if (isset($this->session->data['ts_ga_ecommerce_view']) && !is_null($this->session->data['ts_ga_ecommerce_view'])) {

                $this->load->model('catalog/product');

                $product_list = array();
                foreach ($this->session->data['ts_ga_ecommerce_view'] as $pid => $product_view) {

                    $product_list[$pid] = $this->model_catalog_product->getProduct($product_view['product_id']);
                    if ($product_list[$pid]) {
                        $product_list[$pid] = array_merge($product_list[$pid], $product_view);
                    }
                }
                unset($this->session->data['ts_ga_ecommerce_view']);

                $this->load->controller('extension/analytics/ts_google_analytics/writeecommerce', array('products' => $product_list, 'actionType' => 'view'));
            }
        }


        $data['hpmodel'] = $this->load->controller('extension/module/hpmodel/hpmodel/getForm', false);


        $this->load->language('product/product');
        $this->document->addScript('catalog/view/javascript/jquery.elevatezoom.js');

        if (isset($this->session->data['city_product'])) {
            $ipInfo['info'] = $this->session->data['city_product'];
            $data['ip_info'] = $ipInfo;
        } else {
            if (!empty($this->request->server['HTTP_CLIENT_IP'])) {
                $ip = $this->request->server['HTTP_CLIENT_IP'];
            } elseif (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
                $ip = $this->request->server['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $this->request->server['REMOTE_ADDR'];
            }
            $ipInfo = [];
            if (isset($ip)) {
                $ipl = ip2long($ip);
                $ipInfo['ip'] = $ip;
                try {
                    $ipr = $this->db->query("SELECT loc.* FROM gl2_ua_blocks_ipv4 ip LEFT JOIN gl2_ua_locations loc ON (loc.geoname_id = ip.geoname_id AND loc.locale_code = 'ru') WHERE {$ipl} BETWEEN ip.iplf AND ip.iplt");
                    $ipInfo = array_merge($ipr->row, $ipInfo);
                    $ipInfo['info'] = $ipInfo['city_name'] ?? $ipInfo['subdivision_2_name'] ?? $ipInfo['subdivision_1_name'] ?? $ipInfo['country_name'] ?? $ipInfo['continent_name'] ?? $ipInfo['ip'];

                } catch (\Throwable $e) {
                }
            }
            $data['ip_info'] = $ipInfo;
            $this->session->data['city_product'] = $data['ip_info']['info'];
        }

        //убираем ip адресс
        $a = str_split($data['ip_info']['info']);
        if(is_numeric($a[0])){
            $ipInfo['info'] = 'Киев';
            $data['ip_info'] = $ipInfo;
            $this->session->data['city_product'] = 'Киев';
        }
        //убираем ip адресс
        //убираем Украина или украина
        if($data['ip_info']['info'] == 'Украина' || $data['ip_info']['info'] == 'украина'){
            $ipInfo['info'] = 'Киев';
            $data['ip_info'] = $ipInfo;
            $this->session->data['city_product'] = 'Киев';
        }
        //убираем Украина или украина

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $this->load->model('catalog/category');

        if (isset($this->request->get['path'])) {
            $path = '';

            $parts = explode('_', (string)$this->request->get['path']);

            $category_id = (int)array_pop($parts);

            $limit = 6;
            $i = 0;
            $different = count($parts) - $limit;

            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = $path_id;
                } else {
                    $path .= '_' . $path_id;
                }

                $category_info = $this->model_catalog_category->getCategory($path_id);

                if ($category_info && $limit > 1) {

                    if ($i > $different) {
                        $data['breadcrumbs'][] = array(
                            'text' => $category_info['name'],
                            'href' => $this->url->link('product/category', 'path=' . $path)
                        );
                        $limit--;
                    }


                    $i++;
                }
            }

            // Set the last category breadcrumb
            $category_info = $this->model_catalog_category->getCategory($category_id);

            if ($category_info) {
                $url = '';

                if (isset($this->request->get['sort'])) {
                    $url .= '&sort=' . $this->request->get['sort'];
                }

                if (isset($this->request->get['order'])) {
                    $url .= '&order=' . $this->request->get['order'];
                }

                if (isset($this->request->get['page'])) {
                    $url .= '&page=' . $this->request->get['page'];
                }

                if (isset($this->request->get['limit'])) {
                    $url .= '&limit=' . $this->request->get['limit'];
                }


                $data['breadcrumbs'][] = array(
                    'text' => $category_info['name'],
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url)
                );
            }
        }

        $this->load->model('catalog/manufacturer');

        if (isset($this->request->get['manufacturer_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_brand'),
                'href' => $this->url->link('product/manufacturer')
            );

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->request->get['manufacturer_id']);

            if ($manufacturer_info) {
                $data['breadcrumbs'][] = array(
                    'text' => $manufacturer_info['name'],
                    'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url)
                );
            }
        }

        if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
            $url = '';

            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . $this->request->get['tag'];
            }

            if (isset($this->request->get['description'])) {
                $url .= '&description=' . $this->request->get['description'];
            }

            if (isset($this->request->get['category_id'])) {
                $url .= '&category_id=' . $this->request->get['category_id'];
            }

            if (isset($this->request->get['sub_category'])) {
                $url .= '&sub_category=' . $this->request->get['sub_category'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_search'),
                'href' => $this->url->link('product/search', $url)
            );
        }

        if (isset($this->request->get['product_id'])) {
            $product_id = (int)$this->request->get['product_id'];
        } else {
            $product_id = 0;
        }

        // get CURL data

        //$product_id = 23480;
        //$this->request->get['product_id'] = $product_id;

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $server_api = HTTPS_API;
        } else {
            $server_api = HTTP_API;
        }

        $request_url = $server_api . 'index.php?route=apinew/workplace/getProductCart&productId='.(int)$product_id.'&city='.(string)$this->session->data['city_product'].'&language_id='.(int)$this->config->get('config_language_id');

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request_url,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_RETURNTRANSFER => true
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $response = mb_convert_encoding($response, 'utf-8');
        $response = json_decode($response, true);

        // check server response
        if((int)$response['status'] == 200) {
            $page_status = true;
            //$product_provider = $response['data']['provider'];
            $deliveries = $response['data']['delivery'];
            $product_info = $response['data']['product'];
            $product_options = $response['data']['options'];
            $product_attributes = $response['data']['attributes'];
            $product_related = $response['data']['related'];
            $product_discounts = $response['data']['discounts'];
        } else {
            $page_status = false;
            $product_info = false;
        }

        $data['res'] = false;

        /*$data['res'][] = $request_url;
        $data['res'][] = $response;
        $data['res'][] = $product_info_r;
        $data['res'][] = file_get_contents($request_url);*/

        //$this->load->model('catalog/product');
        /*if (!isset($product_info)) {
            $product_info = $this->model_catalog_product->getProduct($product_id);
        }*/

        if ($product_info && $page_status) {

            if ($this->config->get('ts_google_analytics_status') && $this->config->get('ts_google_analytics_settings')['ecommerce']['status'] && ($this->config->get('ts_google_analytics_settings')['ecommerce']['actionType']['detail'] || $this->config->get('ts_google_analytics_settings')['ecommerce']['actionType']['click'])) {

                if (isset($this->request->get['path'])) {
                    $product_info['ts_ga_category_path'] = $this->request->get['path'];
                }

                if ($this->config->get('ts_google_analytics_settings')['ecommerce']['actionType']['click']) {
                    if (isset($this->session->data['ts_ga_ecommerce_click']) && !is_null($this->session->data['ts_ga_ecommerce_click'])) {
                        $product_info = array_merge($product_info, $this->session->data['ts_ga_ecommerce_click']);
                        unset($this->session->data['ts_ga_ecommerce_click']);

                        $this->load->controller('extension/analytics/ts_google_analytics/writeecommerce', array('products' => array($product_info), 'actionType' => 'click'));
                    }
                }

                $product_info['ts_ga_quantity'] = (int)$product_info['quantity'];

                if ($this->config->get('ts_google_analytics_settings')['ecommerce']['actionType']['detail']) {
                    $this->load->controller('extension/analytics/ts_google_analytics/writeecommerce', array('products' => array($product_info), 'actionType' => 'detail'));
                }
            }

            $url = '';

            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
            }

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['manufacturer_id'])) {
                $url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
            }

            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . $this->request->get['tag'];
            }

            if (isset($this->request->get['description'])) {
                $url .= '&description=' . $this->request->get['description'];
            }

            if (isset($this->request->get['category_id'])) {
                $url .= '&category_id=' . $this->request->get['category_id'];
            }

            if (isset($this->request->get['sub_category'])) {
                $url .= '&sub_category=' . $this->request->get['sub_category'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $data['breadcrumbs'][] = array(

                'text' => $product_info['meta_h1'],

                'href' => $this->url->link('product/product', $url . '&product_id=' . $this->request->get['product_id']),
                'self' => $this->url->link('product/product', $url . '&product_id=' . $this->request->get['product_id']),
            );

            $this->document->setName($product_info['name']);
            $this->document->setOgImage($product_info['image']);
            if($product_info['meta_title']) {
            	$this->document->setTitle($product_info['meta_title']);
            } elseif($product_info['meta_h1']) {
            	$this->document->setTitle($product_info['meta_h1']);
            } else {
            	$this->document->setTitle($product_info['name']);
            }

            $this->document->setDescription($product_info['meta_description']);
            $this->document->setKeywords($product_info['meta_keyword']);
            $this->document->addLink($this->url->link('product/product', 'product_id=' . $this->request->get['product_id']), 'canonical');

            $this->document->addStyle('catalog/view/javascript/jquery/pp_calculator/jquery-ui/jquery-ui.min.css');
            $this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
            $this->document->addScript('catalog/view/javascript/jquery/pp_calculator/jquery-ui/jquery-ui.min.js');
            $this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');
            /* gulp add */
            //$this->document->addStyle('catalog/view/theme/OPC080193_6/stylesheet/page_product.css?ver1.16');
            //$this->document->addStyle('catalog/view/theme/OPC080193_6/js/fancy/jquery.fancybox.css', 'footer');
            //$this->document->addScript('catalog/view/theme/OPC080193_6/js/fancy/jquery.fancybox.min.js', 'footer');
            //$this->document->addStyle('catalog/view/theme/OPC080193_6/css/owlcarousel/owl.carousel.min.css?ver1.0');
            $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/page_product.css');
            $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/jquery.fancybox.css', 'footer');
            $this->document->addScript('catalog/view/theme/OPC080193_6/assets/jquery.fancybox.min.js', 'footer');
            //$this->document->addStyle('catalog/view/theme/OPC080193_6/assets/owl.carousel.min.css');
            /* gulp add */




            $this->document->addStyle('catalog/view/javascript/font-awesome/css/font-awesome-selected.min.css');

            /* gulp add */
            //$this->document->addStyle('catalog/view/theme/OPC080193_6/stylesheet/hint.css');
            $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/hint.css');
            /* gulp add */
            // owl carousel
            $this->document->addStyle('catalog/view/theme/OPC080193_6/stylesheet/module_owlcarousel.css');

            /* gulp add */
            //$this->document->addStyle('catalog/view/theme/OPC080193_6/css/owlcarousel/owl.carousel.min.css?ver1.0');
              $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/owl.carousel.min.css');
            /* gulp add */

            /* gulp add */
            //$this->document->addStyle('catalog/view/theme/OPC080193_6/css/owlcarousel/owl.theme.default.min.css');
            $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/owl.theme.default.min.css');
            /* gulp add */

            /* gulp add */
            //$this->document->addScript('catalog/view/theme/OPC080193_6/js/owlcarousel/owl.carousel.min.js');
            $this->document->addScript('catalog/view/theme/OPC080193_6/assets/owl.carousel.min.js');
            /* gulp add */
            // end owl carousel

            $data['heading_title'] = $product_info['name'];

            $data['text_select'] = $this->language->get('text_select');
            $data['text_price'] = $this->language->get('text_price');
            $data['text_manufacturer'] = $this->language->get('text_manufacturer');
            $data['text_model'] = $this->language->get('text_model');
            $data['text_height'] = $this->language->get('text_height');
            $data['text_reward'] = $this->language->get('text_reward');
            $data['text_points'] = $this->language->get('text_points');
            $data['text_stock'] = $this->language->get('text_stock');
            $data['text_discount'] = $this->language->get('text_discount');
            $data['text_sku'] = $this->language->get('text_sku');
            $data['text_tax'] = $this->language->get('text_tax');
            $data['text_option'] = $this->language->get('text_option');
            $data['text_minimum'] = sprintf($this->language->get('text_minimum'), $product_info['minimum']);
            $data['text_write'] = $this->language->get('text_write');
            $data['text_login'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', true), $this->url->link('account/register', '', true));
            $data['text_note'] = $this->language->get('text_note');
            $data['text_tags'] = $this->language->get('text_tags');
            $data['text_related'] = $this->language->get('text_related');
            $data['text_payment_recurring'] = $this->language->get('text_payment_recurring');
            $data['text_loading'] = $this->language->get('text_loading');
            $data['text_oneclick'] = $this->language->get('text_oneclick');
            $data['text_oneclick_text'] = $this->language->get('text_oneclick_text');
            $data['text_wishlist'] = $this->language->get('text_wishlist');
            $data['text_sticker_new'] = $this->language->get('text_sticker_new');
            $data['text_sticker_top'] = $this->language->get('text_sticker_top');
            $data['text_sticker_free'] = $this->language->get('text_sticker_free');
            $data['text_sticker_free'] = $this->language->get('text_sticker_free');
            $data['lettering_detail'] = $this->language->get('lettering_detail');
            $data['lettering_review'] = $this->language->get('lettering_review');
            $data['text_more_link'] = $this->language->get('text_more_link');
            $data['text_shipping'] = $this->language->get('text_shipping');
            $data['text_pickup_nova_poshta'] = $this->language->get('text_pickup_nova_poshta');
            $data['text_free'] = $this->language->get('text_free');
            $data['text_from'] = $this->language->get('text_from');
            $data['text_courier_nova_poshta'] = $this->language->get('text_courier_nova_poshta');
            $data['text_courier_sz'] = $this->language->get('text_courier_sz');
            $data['text_pickup_smartzone'] = $this->language->get('text_pickup_smartzone');
            $data['text_pickup_point1'] = $this->language->get('text_pickup_point1');
            $data['text_pickup_unavailability'] = $this->language->get('text_pickup_unavailability');
            $data['text_payment'] = $this->language->get('text_payment');
            $data['text_payment_types'] = $this->language->get('text_payment_types');
            $data['text_guarantee'] = $this->language->get('text_guarantee');
            $data['text_guarantee_info'] = $this->language->get('text_guarantee_info');
            $data['text_specification_all'] = $this->language->get('text_specification_all');
            $data['text_shipping_default1'] = $this->language->get('text_shipping_default1');
            $data['text_shipping_default2'] = $this->language->get('text_shipping_default2');
            $data['text_action_delivery'] = $this->language->get('text_action_delivery');

            $data['entry_qty'] = $this->language->get('entry_qty');
            $data['entry_name'] = $this->language->get('entry_name');
            $data['entry_review'] = $this->language->get('entry_review');
            $data['entry_rating'] = $this->language->get('entry_rating');
            $data['entry_good'] = $this->language->get('entry_good');
            $data['entry_bad'] = $this->language->get('entry_bad');

            $data['button_cart'] = $this->language->get('button_cart');

              $data['button_wishlist'] = $this->language->get('button_wishlist');
              $data['button_inwishlist'] = $this->language->get('button_inwishlist');
              $data['button_cart_add'] = $this->language->get('button_cart_add');
              $data['button_incart'] = $this->language->get('button_incart');
            

            $data['button_wishlist'] = $this->language->get('button_wishlist');
            $data['button_inwishlist'] = $this->language->get('button_inwishlist');
            $data['button_cart_add'] = $this->language->get('button_cart_add');
            $data['button_incart'] = $this->language->get('button_incart');

            $data['button_compare'] = $this->language->get('button_compare');
            $data['button_upload'] = $this->language->get('button_upload');
            $data['button_continue'] = $this->language->get('button_continue');
            $data['text_expand_specifications'] = $this->language->get('text_expand_specifications');
            $data['text_collapse_specifications'] = $this->language->get('text_collapse_specifications');
            $data['text_your_city'] = $this->language->get('text_your_city');
            $data['outofstock'] = $this->language->get('outofstock');
            //$this->load->model('catalog/review');

            $data['tab_description'] = $this->language->get('tab_description');
            $data['tab_description2'] = $this->language->get('tab_description2');
            $data['tab_video'] = $this->language->get('tab_video');
            $data['text_buy'] = $this->language->get('text_buy');
            $data['text_quantity'] = $this->language->get('text_quantity');
            $data['text_oneclick'] = $this->language->get('text_oneclick');
            $data['text_discount_time'] = $this->language->get('text_discount_time');

            $data['tab_attribute'] = $this->language->get('tab_attribute');
            $data['tab_photos'] = $this->language->get('tab_photos');
            $data['tab_photos_title'] = $this->language->get('tab_photos_title');
            //$data['tab_review'] = sprintf($this->language->get('tab_review'), $product_info['reviews']);


            $data['product_id'] = (int)$this->request->get['product_id'];
            $data['manufacturer'] = $product_info['manufacturer'];

            if ($product_info['manufacturer_image'] && file_exists(DIR_IMAGE . $product_info['manufacturer_image'])) {
                $data['manufacturer_img'] = $this->model_tool_image->resize($product_info['manufacturer_image'], 80, 80);
            }


            $data['manufacturers'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
            $data['model'] = $product_info['model'];

            // Product delivery
            $data['deliveries'] = array();
            foreach($deliveries as $delivery) {

                $day_delivery = $this->setDateFormat($delivery['day_delivery']);

                if(stristr($delivery['name_shiping'], 'SMARTZONE') !== FALSE) {
                    $delivery_class = 'delivery_types_sz';
                } else {
                    $delivery_class = 'delivery_types_np';
                }

                if((int)$delivery['price'] > 0) $right_symbol = ' грн'; else $right_symbol = '';

                $data['deliveries'][] = array(
                    'class'         => $delivery_class,
                    'name_shiping'  => $delivery['name_shiping'],
                    'day_delivery'  => $day_delivery,
                    'price'         => $delivery['price']. $right_symbol
                );
            }

            $data['sku'] = $product_info['sku'];
            $data['upc'] = $product_info['upc'];
            $data['ean'] = $product_info['ean'];
            $data['jan'] = $product_info['jan'];
            $data['height'] = $product_info['height'];
            $data['length'] = $product_info['length'];
            $data['width'] = $product_info['width'];
            $data['diameter_of_pot'] = $product_info['diameter_of_pot'];
            $data['depth_of_pot'] = $product_info['depth_of_pot'];
            $data['reward'] = $product_info['reward'];
            $data['points'] = $product_info['points'];
            $data['qty'] = $product_info['quantity'];
            $data['meta_h1'] = $product_info['meta_h1'];
            $data['product_url'] = $this->url->link('product/product', 'product_id=' . $product_info['product_id']);
            $data['description'] = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');
            $data['unit_h'] = $this->language->get('unit_h');
            $data['unit_w'] = $this->language->get('unit_w');
            $data['unit_l'] = $this->language->get('unit_l');
            $data['unit_diameter'] = $this->language->get('unit_diameter');
            $data['unit_unit_depth'] = $this->language->get('unit_unit_depth');
            $data['unit'] = $this->language->get('unit');

            $data['payment_information_link'] = $this->url->link('information/information', 'information_id=19');
            $stickers_new = false;
            $stickers_free = false;
            $stickers_top = false;
            if ($product_info['mpn']) {
                $stickers = explode(',', $product_info['mpn']);
                foreach ($stickers as $sticker) {
                    if ((int)$sticker == 3) {
                        $stickers_new = true;
                    } elseif ((int)$sticker == 2) {
                        $stickers_top = true;
                    } elseif ((int)$sticker == 1) {
                        $stickers_free = true;
                    }
                }

            }
            $data['stickers_new'] = $stickers_new;
            $data['stickers_free'] = $stickers_free;
            $data['stickers_top'] = $stickers_top;

            if (in_array($product_info['stock_status_id'], array(7, 8))) {
                $data['stock'] = $this->language->get('text_instock');
            } else {
                $data['stock'] = $this->language->get('outofstock');
            }
            $data['in_stock'] = (in_array($product_info['stock_status_id'], array(7, 8)) ? 1 : 0);
            $this->load->model('tool/image');


            $product_info = $this->load->controller('extension/module/hpmodel/hpmodel/getCategoryBlock', $product_info);


        $product_info = $this->load->controller('extension/module/hpmodel/hpmodel/getCategoryBlock', $product_info);
      
            if ($product_info['image']) {
                $data['popup'] = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height'));
            } else {
                $data['popup'] = '';
            }


            $product_info = $this->load->controller('extension/module/hpmodel/hpmodel/getCategoryBlock', $product_info);


        $product_info = $this->load->controller('extension/module/hpmodel/hpmodel/getCategoryBlock', $product_info);
      
            if ($product_info['image']) {
                $data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_thumb_width'), $this->config->get($this->config->get('config_theme') . '_image_thumb_height'));
            } else {
                $data['thumb'] = '';
            }

            $product_info = $this->load->controller('extension/module/hpmodel/hpmodel/getCategoryBlock', $product_info);


        $product_info = $this->load->controller('extension/module/hpmodel/hpmodel/getCategoryBlock', $product_info);
      
            if ($product_info['image']) {
                $data['sticky_img_mini'] = $this->model_tool_image->resize($product_info['image'], 48, 48);
            } else {
                $data['sticky_img_mini'] = '';
            }

            $product_info = $this->load->controller('extension/module/hpmodel/hpmodel/getCategoryBlock', $product_info);


        $product_info = $this->load->controller('extension/module/hpmodel/hpmodel/getCategoryBlock', $product_info);
      
            if ($product_info['image']) {
                $data['sticky_img'] = $this->model_tool_image->resize($product_info['image'], 116, 116);
            } else {
                $data['sticky_img'] = '';
            }

            $data['images'] = array();
            $data['images'][] = array(
                'popup' => $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height')),
                'thumb' => $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_thumb_width'), $this->config->get($this->config->get('config_theme') . '_image_thumb_height')),
                'mini' => $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_additional_width'), $this->config->get($this->config->get('config_theme') . '_image_additional_height'))
            );


            $data['videos'] = $product_info['video'];

            foreach ($product_info['images'] as $result) {
                $data['images'][] = array(
                    'popup' => $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height')),
                    'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_thumb_width'), $this->config->get($this->config->get('config_theme') . '_image_thumb_height')),
                    'mini' => $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_additional_width'), $this->config->get($this->config->get('config_theme') . '_image_additional_height'))
                );
            }

            $data['currency_product'] = $this->session->data['currency'];
            if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                $data['price'] = $this->currency->format1($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            } else {
                $data['price'] = false;
            }

            if ((float)$product_info['special']) {
                $data['special'] = $this->currency->format1($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            } else {
                $data['special'] = false;
            }

            if ($this->config->get('config_tax')) {
                $data['tax'] = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
            } else {
                $data['tax'] = false;
            }


            // Wishlist
            $this->load->model('account/wishlist');
            if (!$this->customer->isLogged() && isset($this->session->data['wishlist'])) {
                $wishlist = $this->session->data['wishlist'];
            } else {
                $wishlist = $this->model_account_wishlist->getWishlist();
            }

            $data['wishlist'] = false;

            if (!empty($wishlist)) {
                foreach ($wishlist as $product_id) {
                    if ($product_id == $product_info['product_id']) $data['wishlist'] = true;
                }
            }

            // Cart
            $data['incart'] = false;
            if ($this->cart->hasProducts()) {
                $products_cart = $this->cart->getProducts();

                foreach ($products_cart as $product) {
                    if ($product['product_id'] == $product_info['product_id']) $data['incart'] = true;
                }
            }

            $data['discounts'] = array();

            foreach ($product_discounts as $discount) {
                $data['discounts'][] = array(
                    'quantity' => $discount['quantity'],
                    'price' => $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'])
                );
            }


            $data['price'] = str_replace(' ', '', $data['price']);
            $data['special'] = str_replace(' ', '', $data['special']);


                $data['price'] = str_replace(' ', '', $data['price']);
                $data['special'] = str_replace(' ', '', $data['special']);
            
            $data['options'] = array();

            foreach ($product_options as $option) {

                $product_option_value_data = array();

                foreach ($option['product_option_value'] as $option_value) {
                    if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
                        if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
                            $price = $this->currency->format($this->tax->calculate($option_value['price'], $product_info['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
                        } else {
                            $price = false;
                        }

                        $product_option_value_data[] = array(
                            'product_option_value_id' => $option_value['product_option_value_id'],
                            'option_value_id' => $option_value['option_value_id'],
                            'name' => $option_value['name'],
                            'image' => $this->model_tool_image->resize($option_value['image'], 50, 50),
                            'price' => $price,
                            'price_prefix' => $option_value['price_prefix']
                        );
                    }
                }

                $data['options'][] = array(
                    'product_option_id' => $option['product_option_id'],
                    'product_option_value' => $product_option_value_data,
                    'option_id' => $option['option_id'],
                    'name' => $option['name'],
                    'type' => $option['type'],
                    'value' => $option['value'],
                    'required' => $option['required']
                );
            }

            if ($product_info['minimum']) {
                $data['minimum'] = $product_info['minimum'];
            } else {
                $data['minimum'] = 1;
            }

            $data['review_status'] = $this->config->get('config_review_status');

            if ($this->config->get('config_review_guest') || $this->customer->isLogged()) {
                $data['review_guest'] = true;
            } else {
                $data['review_guest'] = false;
            }

            if ($this->customer->isLogged()) {
                $data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
            } else {
                $data['customer_name'] = '';
            }

            $data['reviews'] = sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']);
            $data['rating'] = (int)$product_info['rating'];

            // Captcha
            if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
                $data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'));
            } else {
                $data['captcha'] = '';
            }

            $data['share'] = $this->url->link('product/product', 'product_id=' . (int)$this->request->get['product_id']);

            $data['attribute_groups'] = $product_attributes;

            $attribute_groups = $data['attribute_groups'];
            $count_row_attribute = count($attribute_groups);

            foreach ($attribute_groups as $attribute_group) {
                $count_row_attribute = $count_row_attribute + count($attribute_group['attribute']);
            }
            $data['count_row_attribute'] = (int)$count_row_attribute;

            $data['products'] = array();

            foreach ($product_related as $result) {

                $result = $this->load->controller('extension/module/hpmodel/hpmodel/getCategoryBlock', $result);


                // Wishlist
                $this->load->model('account/wishlist');
                if (!$this->customer->isLogged() && isset($this->session->data['wishlist'])) {
                    $wishlist_pd = $this->session->data['wishlist'];
                } else {
                    $wishlist_pd = $this->model_account_wishlist->getWishlist();
                }

                $wish_pd = false;

                if (!empty($wishlist_pd)) {
                    foreach ($wishlist_pd as $product_id) {
                        if ($product_id == $result['product_id']) $wish_pd = true;
                    }
                }

                // Cart
                $incart = false;
                if ($this->cart->hasProducts()) {
                    $products_cart = $this->cart->getProducts();

                    foreach ($products_cart as $product) {
                        if ($product['product_id'] == $result['product_id']) $incart = true;
                    }
                }


        $result = $this->load->controller('extension/module/hpmodel/hpmodel/getCategoryBlock', $result);
      

                // Wishlist
                $this->load->model('account/wishlist');
                if (!$this->customer->isLogged() && isset($this->session->data['wishlist'])) {
                    $wishlist_pd = $this->session->data['wishlist'];        
                } else {
                    $wishlist_pd = $this->model_account_wishlist->getWishlist();
                }

                $wish_pd = false;

                if(!empty($wishlist_pd)) {
                  foreach($wishlist_pd as $product_id) {
                    if($product_id == $result['product_id']) $wish_pd = true;
                  }
                }

                // Cart
                $incart = false;
                if ($this->cart->hasProducts()) {
                  $products_cart = $this->cart->getProducts();

                  foreach ($products_cart as $product) {
                   if($product['product_id'] == $result['product_id']) $incart = true;
                  }
                }
            
                if ($result['image']) {
                    $image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));
                }

                //added for image swap
                //$images = $this->model_catalog_product->getProductImages($result['product_id']);
                $images = $result['images'];

                if (isset($images[0]['image']) && !empty($images)) {
                    $images = $images[0]['image'];
                } else {
                    $images = $image;
                }

                //

                if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $price = false;
                }

                if ((float)$result['special']) {
                    $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $special = false;
                }

                if ($this->config->get('config_tax')) {
                    $tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
                } else {
                    $tax = false;
                }

                if ($this->config->get('config_review_status')) {
                    $rating = (int)$result['rating'];
                } else {
                    $rating = false;
                }


                $currency_code = !empty($this->session->data['currency']) ? $this->session->data['currency'] : $this->config->get('config_currency');
                if ($price) {
                    $price = rtrim(preg_replace("/[^0-9\.]/", "", $price), '.') . '<span class=\'currency-value\'>' . $this->currency->getSymbolRight($currency_code) . '</span>';
                }
                if ($special) {
                    $special = rtrim(preg_replace("/[^0-9\.]/", "", $special), '.') . '<span class=\'currency-value\'>' . $this->currency->getSymbolRight($currency_code) . '</span>';
                }


                $currency_code = !empty($this->session->data['currency']) ? $this->session->data['currency'] : $this->config->get('config_currency');
                if ($price) {
                  $price = rtrim(preg_replace("/[^0-9\.]/", "", $price), '.') . '<span class=\'currency-value\'>'. $this->currency->getSymbolRight($currency_code).'</span>';
              }
              if ($special) {
                  $special = rtrim(preg_replace("/[^0-9\.]/", "", $special), '.') . '<span class=\'currency-value\'>'. $this->currency->getSymbolRight($currency_code).'</span>';
              }
            
                $data['products'][] = array(
                    'product_id' => $result['product_id'],

        'hpm_block' => !empty($result['hpm_block']) ? $result['hpm_block'] : '',
        'hpm_block_model_id' => !empty($result['model_id']) ? $result['model_id'] : '',
      

                    'hpm_block' => !empty($result['hpm_block']) ? $result['hpm_block'] : '',
                    'hpm_block_model_id' => !empty($result['model_id']) ? $result['model_id'] : '',

                    'in_stock' => (in_array($result['stock_status_id'], array(7, 8)) ? 1 : 0),
                    'thumb' => $image,
                    'thumb_swap' => $this->model_tool_image->resize($images, $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height')),
                    'name' => $result['name'],
                    'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
                    'price' => $price,

                    'incart' => $incart,
                    'wish' => $wish_pd,

                    'special' => $special,
                    'tax' => $tax,
                    'height' => round($result['height'], 0),
                    'length' => round($result['length'], 0),
                    'width' => round($result['width'], 0),
                    'diameter_of_pot' => round($result['diameter_of_pot'], 0),
                    'depth_of_pot' => round($result['depth_of_pot'], 0),
                    'minimum' => $result['minimum'] > 0 ? $result['minimum'] : 1,
                    'rating' => $rating,
                    'href' => $this->url->link('product/product', 'product_id=' . $result['product_id']),
                    'quantity' => $result['quantity'],
                );
            }

            $data['tags'] = array();

            if ($product_info['tag']) {
                $tags = explode(',', $product_info['tag']);

                foreach ($tags as $tag) {
                    $data['tags'][] = array(
                        'tag' => trim($tag),
                        'href' => $this->url->link('product/search', 'tag=' . trim($tag))
                    );
                }
            }

            $data['recurrings'] = false;


            if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
                $server_api = HTTPS_API;
            } else {
                $server_api = HTTP_API;
            }
            $request_url =  $server_api . 'index.php?route=apinew/workplace/updateViewed&productId='.(int)$product_id;

		        $curl = curl_init();
		        curl_setopt_array($curl, array(
		            CURLOPT_URL => $request_url,
		            CURLOPT_RETURNTRANSFER => true
		        ));

		        $response = curl_exec($curl);
		        curl_close($curl);

	        $data['microdata'] = $this->microdataProduct($data);
            $data['microdata_breadcrumbs'] = $this->microdataBreadcrumbs($data['breadcrumbs']);

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['productblock'] = $this->load->controller('common/productblock');
            $data['footer'] = $this->load->controller('common/footer');

            $data['credit'] = $this->load->controller('extension/module/creditprivat');

            $data['header'] = $this->load->controller('common/header');


            $template = 'product/product';

            // Custom template module
            $this->load->model('setting/setting');

            $custom_template_module = $this->model_setting_setting->getSetting('custom_template_module');

            $customer_group_id = $this->customer->getGroupId();

            if ($this->config->get('config_theme') == 'theme_default') {
                $directory = $this->config->get('theme_default_directory');
            } else {
                $directory = $this->config->get('config_theme');
            }

            if (!empty($custom_template_module['custom_template_module'])) {
                if (isset($this->request->get['path'])) {
                    foreach ($custom_template_module['custom_template_module'] as $key => $module) {
                        if (($module['type'] == 4) && !empty($module['product_categories'])) {
                            if ((isset($module['customer_groups']) && in_array($customer_group_id, $module['customer_groups'])) || !isset($module['customer_groups']) || empty($module['customer_groups'])) {

                                $category_id = explode('_', $this->request->get['path']);
                                $category_id = (int)end($category_id);
                                if (in_array($category_id, $module['product_categories'])) {
                                    if (file_exists(DIR_TEMPLATE . $directory . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . $module['template_name'] . '.tpl')) {
                                        $template = $module['template_name'];
                                    }
                                }

                            } // customer groups

                        }
                    }
                }

                foreach ($custom_template_module['custom_template_module'] as $key => $module) {
                    if (($module['type'] == 5) && !empty($module['product_manufacturers'])) {

                        if ((isset($module['customer_groups']) && in_array($customer_group_id, $module['customer_groups'])) || !isset($module['customer_groups']) || empty($module['customer_groups'])) {

                            $manufacturer_id = $product_info['manufacturer_id'];
                            if (in_array($manufacturer_id, $module['product_manufacturers'])) {
                                if (file_exists(DIR_TEMPLATE . $directory . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . $module['template_name'] . '.tpl')) {
                                    $template = $module['template_name'];
                                }
                            }

                        } // customer groups

                    }
                }

                foreach ($custom_template_module['custom_template_module'] as $key => $module) {
                    if (($module['type'] == 1) && !empty($module['products'])) {
                        if ((isset($module['customer_groups']) && in_array($customer_group_id, $module['customer_groups'])) || !isset($module['customer_groups']) || empty($module['customer_groups'])) {

                            $products = explode(',', $module['products']);
                            if (in_array($product_id, $products)) {
                                if (file_exists(DIR_TEMPLATE . $directory . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . $module['template_name'] . '.tpl')) {
                                    $template = $module['template_name'];
                                }
                            }

                        } // customer groups

                    }
                }
            }

            $template = str_replace('\\', '/', $template);

            $callEndTimeTotal = microtime(true);
            $callTimeTotal = $callEndTimeTotal - $callStartTimeTotal;
            $data['time_request'] = 'Общее время обработки страницы - '. $callTimeTotal. ' секунд';

            $this->response->setOutput($this->load->view($template, $data));
            // Custom template module

        } else {
            $url = '';

            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
            }

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['manufacturer_id'])) {
                $url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
            }

            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }

            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . $this->request->get['tag'];
            }

            if (isset($this->request->get['description'])) {
                $url .= '&description=' . $this->request->get['description'];
            }

            if (isset($this->request->get['category_id'])) {
                $url .= '&category_id=' . $this->request->get['category_id'];
            }

            if (isset($this->request->get['sub_category'])) {
                $url .= '&sub_category=' . $this->request->get['sub_category'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_error'),
                'href' => $this->url->link('product/product', $url . '&product_id=' . $product_id)
            );

            $this->document->setTitle($this->language->get('text_error'));

            $data['heading_title'] = $this->language->get('text_error');

            $data['text_error'] = $this->language->get('text_error');

            $data['button_continue'] = $this->language->get('button_continue');

            $data['continue'] = $this->url->link('common/home');

            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['productblock'] = $this->load->controller('common/productblock');
            $data['footer'] = $this->load->controller('common/footer');

            $data['credit'] = $this->load->controller('extension/module/creditprivat');

            $data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('error/not_found', $data));
        }
    }

    public function microdataProduct($data){
    	$json = array();
      $json['@context'] = 'http://schema.org';
      $json['@type'] = 'Product';
      $json['name'] = !empty($data['meta_h1']) ? $data['meta_h1'] : $data['heading_title'];
      $json['image'] = $data['thumb'];

      if($data['meta_description']) {
        $json['description'] = strip_tags($data['meta_description']);
      } else {
        $json['description'] = strip_tags($data['description']);
      }

      $json['sku'] = !empty($data['sku']) ? $data['sku'] : $data['model'];

      if ($data['manufacturer']) {
      	$json['brand'] = array(
      		'@type'	=> 'Thing',
      		'name'	=> strip_tags($data['manufacturer'])
      	);
      }

      if((int)$data['instock'] == 1) {
      	$availability = 'http://schema.org/InStock';
      } else {
      	$availability = 'http://schema.org/OutOfStock';
      }

      $currency = !empty($this->session->data['currency']) ? $this->session->data['currency'] : $this->config->get('config_currency');

      if((int)$this->config->get('config_language_id') == 1) {
      	$store_name = 'Интернет магазин SZ.UA';
      } elseif((int)$this->config->get('config_language_id') == 3) {
      	$store_name = 'Інтернет-Магазин SZ.UA';
      } else {
      	$store_name = $this->config->get('config_name');
      }



      $json['offers'] = array(
      	'@type'	=> 'Offer',
        'url' => $data['product_url'],
        'priceCurrency' => $currency,
        'price' => $data['special'] ? preg_replace("/[^0-9]/", '', $data['special']) : preg_replace("/[^0-9]/", '', $data['price']),
        'availability' => $availability,
        'priceValidUntil' => date('Y-m-d', strtotime('+1 years', strtotime(date("Y-m-d ")))),
        'itemCondition' => 'http://schema.org/NewCondition',
        'seller' => array(
          '@type' => 'Organization',
          'name' => $store_name,
        ),
      );

      $output = '<script type="application/ld+json">'.json_encode($json).'</script>'."\n";

      return $output;

    }

    public function microdataBreadcrumbs($breadcrumbs){
        $json = array();
        $json['@context'] = 'http://schema.org';
        $json['@type'] = 'BreadcrumbList';
        $json['itemListElement'] = array();
        $i=1;
        foreach($breadcrumbs as $breadcrumb) {
          $json['itemListElement'][] = array(
              '@type' => 'ListItem',
              'position' => $i,
              'name'    => $breadcrumb['text'],
              'item' => $breadcrumb['href']
          );
          $i++;
        }


        $output = '<script type="application/ld+json">'.json_encode($json).'</script>'."\n";

        return $output;

    }

    public function review()
    {
        $this->load->language('product/product');

        $this->load->model('catalog/review');
        $this->load->model('tool/image');

        $data['text_no_reviews'] = $this->language->get('text_no_reviews');

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $data['reviews'] = array();

        $review_total = $this->model_catalog_review->getTotalReviewsByProductId($this->request->get['product_id']);

        $results = $this->model_catalog_review->getReviewsByProductId($this->request->get['product_id'], ($page - 1) * 5, 5);

        foreach ($results as $result) {

            $image1 = array(
                'thumb' => $this->model_tool_image->resize($result['image1'], 140, 240),
                'popup' => HTTP_SERVER . 'image/' . $result['image1']
            );
            $image2 = array(
                'thumb' => $this->model_tool_image->resize($result['image2'], 140, 240),
                'popup' => HTTP_SERVER . 'image/' . $result['image2']
            );

            $data['reviews'][] = array(
                'author' => $result['author'],
                'text' => nl2br($result['text']),
                'image1' => $image1,
                'model' => $result['model'],
                'image2' => $image2,
                'dest' => nl2br($result['dest']),
                'rating' => (int)$result['rating'],
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
            );
        }

        $pagination = new Pagination();
        $pagination->total = $review_total;
        $pagination->page = $page;
        $pagination->limit = 5;
        $pagination->url = $this->url->link('product/product/review', 'product_id=' . $this->request->get['product_id'] . '&page={page}');

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($review_total) ? (($page - 1) * 5) + 1 : 0, ((($page - 1) * 5) > ($review_total - 5)) ? $review_total : ((($page - 1) * 5) + 5), $review_total, ceil($review_total / 5));

        $this->response->setOutput($this->load->view('product/review', $data));
    }

    public function write()
    {
        $this->load->language('product/product');

        $json = array();

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 25)) {
                $json['error'] = $this->language->get('error_name');
            }

            if ((utf8_strlen($this->request->post['text']) < 25) || (utf8_strlen($this->request->post['text']) > 1000)) {
                $json['error'] = $this->language->get('error_text');
            }

            if (empty($this->request->post['rating']) || $this->request->post['rating'] < 0 || $this->request->post['rating'] > 5) {
                $json['error'] = $this->language->get('error_rating');
            }

            // Captcha
            if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
                $captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');

                if ($captcha) {
                    $json['error'] = $captcha;
                }
            }

            if (!isset($json['error'])) {
                $this->load->model('catalog/review');

                $this->model_catalog_review->addReview($this->request->get['product_id'], $this->request->post);

                $json['success'] = $this->language->get('text_success');
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function getRecurringDescription()
    {
        $this->load->language('product/product');
        $this->load->model('catalog/product');

        if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }

        if (isset($this->request->post['recurring_id'])) {
            $recurring_id = $this->request->post['recurring_id'];
        } else {
            $recurring_id = 0;
        }

        if (isset($this->request->post['quantity'])) {
            $quantity = $this->request->post['quantity'];
        } else {
            $quantity = 1;
        }

        $product_info = $this->model_catalog_product->getProduct($product_id);
        $recurring_info = $this->model_catalog_product->getProfile($product_id, $recurring_id);

        $json = array();

        if ($product_info && $recurring_info) {
            if (!$json) {
                $frequencies = array(
                    'day' => $this->language->get('text_day'),
                    'week' => $this->language->get('text_week'),
                    'semi_month' => $this->language->get('text_semi_month'),
                    'month' => $this->language->get('text_month'),
                    'year' => $this->language->get('text_year'),
                );

                if ($recurring_info['trial_status'] == 1) {
                    $price = $this->currency->format($this->tax->calculate($recurring_info['trial_price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    $trial_text = sprintf($this->language->get('text_trial_description'), $price, $recurring_info['trial_cycle'], $frequencies[$recurring_info['trial_frequency']], $recurring_info['trial_duration']) . ' ';
                } else {
                    $trial_text = '';
                }

                $price = $this->currency->format($this->tax->calculate($recurring_info['price'] * $quantity, $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

                if ($recurring_info['duration']) {
                    $text = $trial_text . sprintf($this->language->get('text_payment_description'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
                } else {
                    $text = $trial_text . sprintf($this->language->get('text_payment_cancel'), $price, $recurring_info['cycle'], $frequencies[$recurring_info['frequency']], $recurring_info['duration']);
                }

                $json['success'] = $text;
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function setDateFormat($timestamp) {

        if(!$timestamp) return '';
        $this->load->language('product/product');

        $today = date('N');
        $delivery_date = date('N', $timestamp);

        // delivery today
        if((int)$today == (int)$delivery_date) {
            return $this->language->get('text_delivery_today');
        } elseif((int)$today == (int)$delivery_date - 1)  { //delivery tomorrow
            return $this->language->get('text_delivery_tomorrow');
        } else {

            if((int)$this->config->get('config_language_id') == 1) {
                $arr = ['в понедельник','в вторник','в среду','в четверг','в пятницу','в субботу','в воскресенье'];
            } else {
                $arr = ['в понеділок','у вівторок','в середу','в четвер','в п\'ятницю','в суботу','в неділю'];
            }

            $day = date('N', $timestamp)-1;
            $date_format = $arr[$day].' '.date('d.m', $timestamp);

            return sprintf($this->language->get('text_delivery'), $date_format);

        }

    }

    public function autocomplete()
    {
        $this->load->model('catalog/product');

        $name = $this->request->get['name'];

        if (utf8_strlen($name) < 2) {
            exit;
        }

        $this->response->setOutput(json_encode($this->model_catalog_product->getGeoListProduct($name)));
    }

    public function change_delivery()
    {
        $json = array();
        if ($this->request->post['shipping_city'] && $this->request->post['product_id']) {

            if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
                $server_api = HTTPS_API;
            } else {
                $server_api = HTTP_API;
            }

            $request_url = $server_api . 'index.php?route=apinew/workplace/getDeliveryByCity&productId='.(int)$this->request->post['product_id'].'&city='.(string)$this->request->post['shipping_city'].'&languageId='.(int)$this->config->get('config_language_id');

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $request_url,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSL_VERIFYPEER  => false,
                CURLOPT_RETURNTRANSFER => true
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $response = mb_convert_encoding($response, 'utf-8');
            $response = json_decode($response, true);

            // check server response
            if((int)$response['status'] == 200) {

                $deliveries = $response['data']['delivery'];

                $json['deliveries'] = array();

                foreach($deliveries as $delivery) {

                    $day_delivery = $this->setDateFormat($delivery['day_delivery']);

                    if(stristr($delivery['name_shiping'], 'SMARTZONE') !== FALSE) {
                        $delivery_class = 'delivery_types_sz';
                    } else {
                        $delivery_class = 'delivery_types_np';
                    }

                    if((int)$delivery['price'] > 0) $right_symbol = ' грн'; else $right_symbol = '';

                    $json['deliveries'][] = array(
                        'class'         => $delivery_class,
                        'name_shiping'  => $delivery['name_shiping'],
                        'day_delivery'  => $day_delivery,
                        'price'         => $delivery['price']. $right_symbol
                    );
                }
            } else {
                $json['error'] = "Bad request from server";
            }

            $json['success'] = $this->request->post['shipping_city'];
        } else {
            $json['error'] = "Не передано значение города либо id товара";
        }
        $this->response->setOutput(json_encode($json));
    }

    public function shipping_city()
    {
        $json = array();
        if ($this->request->post['shipping_city']) {
            unset($this->session->data['city_product']);
            $this->session->data['city_product'] = $this->request->post['shipping_city'];
            $json['success'] = $this->request->post['shipping_city'];
        }
        $this->response->setOutput(json_encode($json));
    }

/*
    public function pickup_view()
    {
        $json = array();
        $json['success'] = 0;
        if ($this->request->post['shipping_city']) {
            if ($this->request->post['product_id']) {
                $this->load->model('catalog/product');
                $query = $this->db->query("SELECT pickup FROM " . DB_PREFIX . "product WHERE product_id = '" . $this->request->post['product_id'] . "'");
                if (isset($query->row['pickup'])) {
                    if ($query->row['pickup'] == 1) {
                        $citys = $this->model_catalog_product->getProductPickupCity($this->request->post['product_id']);
                        if ($citys) {
                            foreach ($citys as $city) {
                                $product_citys[] = $city['city'];
                            }
                            if (in_array($this->request->post['shipping_city'], $product_citys)) {
                                $json['success'] = 1;
                            }
                        }
                    }
                }
            }
        }
        $this->response->setOutput(json_encode($json));
    }

    public function courier_view()
    {
        $json = array();
        $json['success'] = 0;
        if ($this->request->post['shipping_city']) {
            if ($this->request->post['product_id']) {
                $this->load->model('catalog/product');
                $query = $this->db->query("SELECT np_sz_courier, courier FROM " . DB_PREFIX . "product WHERE product_id = '" . $this->request->post['product_id'] . "'");
                if (isset($query->row['courier'])) {
                    if ($query->row['courier'] == 1) {
                        $citys = $this->model_catalog_product->getProductCourierCity($this->request->post['product_id']);
                        if ($citys) {
                            foreach ($citys as $city) {
                                $product_citys[] = $city['city'];
                            }
                            if (in_array($this->request->post['shipping_city'], $product_citys)) {
                                $json['success'] = 1;
                            }
                        }

                        if (isset($query->row['np_sz_courier'])) {
                            if ($query->row['np_sz_courier'] == '') {
                                $json['success'] = 0;
                            }
                        }
                    }
                }
            }
        }
        $this->response->setOutput(json_encode($json));
    }
*/
    /*public function providerProduct()
    {
        $json = ['success' => false, 'error' => '', 'status' => 200, 'out' => []];


        $product_id = $this->request->get['product_id'];
        $city = $this->request->get['city'];

        $maxMarga = 0;
        $minPrice = array();

//        if ($city) {
//            if ($product_id) {
//                $this->load->model('catalog/product');
//                if ($providers = $this->model_catalog_product->getProviderProduct($product_id, $status_n = 7)) {
//
//                    foreach ($providers as $provider) {
//                        if ($provider['id_provider'] != 9001) {
//                            if ($provider['marga'] > $maxMarga) {
//                                $maxMarga = $provider['marga'];
//                            }
//                            array_push($minPrice, $provider);
//                        }
//                    }
//
//                    $minP = 20;//min($minPrice['price']);
//                    $sql = "SELECT * FROM " . DB_PREFIX . "provider_kor_price WHERE min_price < '" . $minP . "' AND max_price > '" . $minP . "'";
//                    $koef = $this->db->query($sql);
////Выборка постовщиков и цен
//
//                    foreach ($providers as $provider) {
//                        if ($provider['id_provider'] == 9001) {
//                            $json['out']['provider'] = [
//                                'price' => $provider['price'],
//                                'old_price' => $provider['old_price']
//                            ];
//                        } else if ($provider['marga'] > $maxMarga * $koef['koef_mar']) {
//                            if ($provider['price'] < $minP * $koef['koef_m_pr']) {
//                                $json['out']['provider'] = [
//                                    'price' => $provider['price'],
//                                    'old_price' => $provider['old_price']
//                                ];
//                            }
//                        }
////Выборка доставки
//                        $product = $this->model_catalog_product->getProduct($provider['product_id']);
//                        if ($delivary = $this->model_catalog_product->getProductDelivery($provider['product_id'], $city, $status = 1)) {
//                            foreach ($delivary as $item) {
//                                if ($item['id_provider'] == 9001) {
//                                    $json['out']['delivery'] = [
//                                        'id_shiping' => $item['id_shiping'],
//                                        'price' => '',
//                                        'day_delivery' => $item['day_delivery'],
//                                        'id_provider' => $item['id_provider']
//                                    ];
//                                    break;
//                                } else {
//                                    if($cityProd = $this->model_catalog_product->getCityByProduct($provider['product_id'])) {
//                                        foreach ($cityProd as $c) {
//                                            if ($cityProd['city'] == $city) {
//
//                                                $json['out']['delivery'] = [
//                                                    'id_shiping' => $item['id_shiping'],
//                                                    'price' => '',
//                                                    'day_delivery' => $item['day_delivery'],
//                                                    'id_provider' => $item['id_provider']
//                                                ];
//                                            }else {
//                                                $json['out']['delivery'] = [
//                                                    'np' => $product->row['np_courier'],
//                                                    'np_courier' => 'По тарифам перевозчика'
//                                                ];
//                                            }
//                                        }
//                                    }else{
//                                        $json['out']['delivery'] = [
//                                            'np' => $product->row['np_courier'],
//                                            'np_courier' => 'По тарифам перевозчика'
//                                        ];
//                                    }
//                                }
//                            }
//                        } else {
//                            $json['out']['delivery'] = [
//                                'np' => $product->row['np_courier'],
//                                'np_courier' => 'По тарифам перевозчика'];
//                        }
//                    }
//
//                    $this->load->model('catalog/manufacturer');
//                    if ($manufacturer = $this->model_catalog_manufacturer->getManufacturer($product['manufacturer_id'])) {
//
//                        $providerProduct = new stdClass();
//                        $providerProduct->heading_title = $product->roW[''];
//                        $providerProduct->in_stock = $product->row[''];
//                        $providerProduct->special = $product->row['special'];
//                        $providerProduct->reward = $product->row['reward'];
//                        $providerProduct->product_id = $product->row['product_id'];
//                        $providerProduct->breadcrumbs = [];
//                        $providerProduct->wishlist = $product->row[''];
//                        $providerProduct->product_url = $product->row[''];
//                        $providerProduct->manufacturer = $manufacturer->row['name'];
//                        $providerProduct->manufacturer_img = $manufacturer->row['image'];
//                        $providerProduct->sku = $product->row['sku'];
//                        $providerProduct->attribute_groups = [];
//                        $providerProduct->count_row_attribute = $product->row[''];
//                        $providerProduct->stickers_new = $product->row[''];
//                        $providerProduct->stickers_top = $product->row[''];
//                        $providerProduct->stickers_free = $product->row[''];
//                        $providerProduct->thumb = $product->row[''];
//                        $providerProduct->images = [];
//                        $providerProduct->height = $product->row['height'];
//                        $providerProduct->width = $product->row['width'];
//                        $providerProduct->length = $product->row['length'];
//                        $providerProduct->diameter_of_pot = $product->row['diameter_of_pot'];
//                        $providerProduct->stock = $product->row[''];
//                        $providerProduct->discounts = [];
//                        $providerProduct->ip_info = [];
//                        $providerProduct->np_branch = $product->row[''];
//                        $providerProduct->day_delivery_str = $providers->row['day_delivery'];
//                        $providerProduct->np_courier = $product->row['np_courier'];
//                        $providerProduct->np_sz_courier = $product->row['np_sz_courier'];
//                        $providerProduct->informations = [];
//                        $providerProduct->description = $product->row['description'];
//                        $providerProduct->sticky_img = $product->row[''];
//                        $providerProduct->products = [];
//
//                        $json['out']['product'] = $providerProduct;
//                        $json['success'] = true;
//                    }
//                }
//            }
//        }

        $json['out']['$product_id'] = $product_id;
        $json['out']['city'] = $city;
        $json['success'] = true;

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }*/
}
