<?php
class ControllerExtensionModuleOwlCarousel extends Controller {
    protected $path = array();

    public function index($setting) {
        $this->document->addStyle('catalog/view/theme/OPC080193_6/stylesheet/module_owlcarousel.css');
        static $module = 0;
        $modules = array();

        if ($setting['show_tabs'] && !empty($setting['display_with']) && is_array($setting['display_with'])) {
            $this->load->model('extension/module');

            $modules[] = $setting;

            foreach ($setting['display_with'] as $id => $checked) {
                $setting_info = $this->model_extension_module->getModule($id);

                if ($setting_info && $setting_info['status']) {
                    $modules[] = $setting_info;
                }
            }
        } else {
            $modules[] = $setting;
        }

        $data['modules'] = array();

        $this->language->load('extension/module/owlcarousel');
        $this->load->model('extension/module/owlcarousel');

        if (!((isset($this->request->get['route']) && $this->request->get['route'] == 'product/product') && ($setting['category_id'] == 'viewed' && $setting['hide_module'] == 1))) {
            $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/owl.carousel.min.css');
            $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/owl.theme.default.min.css');
            $this->document->addScript('catalog/view/theme/OPC080193_6/assets/owl.carousel.min.js');
        }
        $data['unit_h'] = $this->language->get('unit_h');
        $data['unit_w'] = $this->language->get('unit_w');
        $data['unit_l'] = $this->language->get('unit_l');
        $data['unit'] = $this->language->get('unit');
        $data['text_popular'] = $this->language->get('text_popular');
        $data['text_see_all'] = $this->language->get('text_see_all');


                foreach ($modules as $key => $value) {
                     $sort_data[$key] = isset($value['sort_order_tabs']) ? $value['sort_order_tabs'] : 0;
                }

                array_multisort($sort_data, SORT_ASC, $modules);
            

              $data['button_wishlist'] = $this->language->get('button_wishlist');
              $data['button_inwishlist'] = $this->language->get('button_inwishlist');
              $data['button_cart_add'] = $this->language->get('button_cart_add');
              $data['button_incart'] = $this->language->get('button_incart');
            
        foreach ($modules as $mid => $setting) {
            $vars = array();
            $vars['subtitle'] = $setting['subtitle'][$this->config->get('config_language_id')];
            if ($setting['category_id'] !== 'featured' && $setting['category_id'] !== 'viewed') {
                if (isset($this->request->get['route']) && isset($this->request->get['path']) && ($this->request->get['route'] == 'product/category' || isset($this->request->get['route']) && $this->request->get['route'] == 'product/product') && $setting['show_current_category'] == 1) {
                    $parts = explode('_', (string)$this->request->get['path']);
                    $category_id = (int)array_pop($parts);
                } elseif (isset($this->request->get['route']) && !isset($this->request->get['path']) && $this->request->get['route'] == 'product/product' && $setting['show_current_category'] == 1) {
                     $current_product_id = isset($this->request->get['product_id']) ? $this->request->get['product_id'] : 0;
                    $category_id = $this->model_extension_module_owlcarousel->getCategoriesByProductId($current_product_id);
                } else {
                    $category_id = $setting['category_id'];
                }
                $vars['link_see_all'] = $this->url->link('product/category', 'path=' . $category_id);
            }else{
                $vars['link_see_all'] ='';
            }
            if ($setting['title']) {
                $vars['heading_title'] = $setting['title'][$this->config->get('config_language_id')];
            } else {
                $category = $this->model_catalog_category->getCategory($setting['category_id']);
                if (isset($category['name'])) {
                    $vars['heading_title'] = $category['name'];
                } else {
                    $vars['heading_title'] = $this->language->get('heading_title');
                }
            }

            $vars['visible']            = $setting['visible'];
            $vars['visible_1000']       = $setting['visible_1000'];
            $vars['visible_900']        = $setting['visible_900'];
            $vars['visible_600']        = $setting['visible_600'];
            $vars['visible_479']        = $setting['visible_479'];
            $vars['add_class_name']     = $setting['add_class_name'];
            $vars['sort']               = $setting['sort'];
            $vars['show_title']         = $setting['show_title'];
            $vars['show_name']          = $setting['show_name'];
            $vars['show_desc']          = $setting['show_desc'];
            $vars['show_price']         = $setting['show_price'];
            $vars['show_rate']          = $setting['show_rate'];
            $vars['show_cart']          = $setting['show_cart'];
            $vars['show_wishlist']      = $setting['show_wishlist'];
            $vars['show_compare']       = $setting['show_compare'];
            $vars['show_stop_on_hover'] = $setting['show_stop_on_hover'];
            $vars['show_tabs']          = $setting['show_tabs'];
            $vars['show_page']          = $setting['show_page'];
            $vars['show_loop']          = isset($setting['show_loop']) ? $setting['show_loop'] : '';
            $vars['show_nav']           = $setting['show_nav'];
            $vars['show_lazy_load']     = $setting['show_lazy_load'];
            $vars['show_mouse_drag']    = $setting['show_mouse_drag'];
            $vars['show_touch_drag']    = $setting['show_touch_drag'];
            $vars['show_per_page']      = $setting['show_per_page'];
            $vars['show_random_item']   = $setting['show_random_item'];

            if ($setting['slide_speed'] > 0) {
                $vars['slide_speed'] = $setting['slide_speed'];}
                else {$vars['slide_speed'] = 0;
            }

            if ($setting['pagination_speed'] > 0) {
                $vars['pagination_speed'] = $setting['pagination_speed'];}
                else {$vars['pagination_speed'] = 0;
            }

            if ($setting['autoscroll'] > 0) {
                $vars['autoscroll'] = $setting['autoscroll'];}
                else {$vars['autoscroll'] = 0;
            }

            if ($setting['item_prev_next'] > 0) {
                $vars['item_prev_next'] = $setting['item_prev_next'];}
                else {$vars['item_prev_next'] = 0;
            }

            if (isset($setting['rewind_speed']) && $setting['rewind_speed'] > 0) {
                $vars['rewind_speed'] = $setting['rewind_speed'];}
                else {$vars['rewind_speed'] = 0;
            }

            $this->load->model('extension/module/owlcarousel');
            $this->load->model('tool/image');

            if (isset($setting['use_cache'])) {
                $this->model_extension_module_owlcarousel->setCache($setting['use_cache'] ? 1 : 0);
            }

            if (isset($this->request->get['path'])) {
                $this->path = explode('_', $this->request->get['path']);
                $this->category_id = end($this->path);
            }

            $url = '';

            $vars['products'] = array();

            if ($setting['category_id'] == 'featured' || $setting['category_id'] == 'viewed') {
                $vars['products'] = $this->getCurrentProducts($setting);
                if($vars['show_loop'] && 4 >= count($vars['products'])) $vars['show_loop'] = 0;
            } else {
                $vars['products'] = $this->getCategoryProducts($setting);
            }

            $vars['module'] = $module;

            $module++;

            $data['modules'][$mid] = $vars;

            $data['module'] = $module++;

        }
        $sort_order = array();
        $data['button_cart']        = $this->language->get('button_cart');
        $data['button_wishlist']    = $this->language->get('button_wishlist');
        $data['button_compare']     = $this->language->get('button_compare');
        $data['text_tax']           = $this->language->get('text_tax');

        if (!((isset($this->request->get['route']) && $this->request->get['route'] == 'product/product') && ($setting['category_id'] == 'viewed' && $setting['hide_module'] == 1))) {
          if ($setting['template'] == "for_account"){
              return $this->load->view('extension/module/owlcarousel_account', $data);
          }else{
              return $this->load->view('extension/module/owlcarousel', $data);
          }
        }
    }

    public function getCategoryProducts($setting) {
        $result = array();

        if (isset($this->request->get['route']) && isset($this->request->get['path']) && ($this->request->get['route'] == 'product/category' || isset($this->request->get['route']) && $this->request->get['route'] == 'product/product') && $setting['show_current_category'] == 1) {
            $parts = explode('_', (string)$this->request->get['path']);
            $category_id = (int)array_pop($parts);
        } elseif (isset($this->request->get['route']) && !isset($this->request->get['path']) && $this->request->get['route'] == 'product/product' && $setting['show_current_category'] == 1) {
            $current_product_id = isset($this->request->get['product_id']) ? $this->request->get['product_id'] : 0;
            $category_id = $this->model_extension_module_owlcarousel->getCategoriesByProductId($current_product_id);
        } else {
            $category_id = $setting['category_id'];
        }

        $data = array(
            'filter_category_id'     => $category_id,
            'filter_manufacturer_id' => $setting['manufacturer_id'],
            'filter_sub_category'    => true,
            'show_stock'             => $setting['show_stock'],
            'show_current_category'  => $setting['show_current_category'],
            'show_current_product'   => $setting['show_current_product'],
            'sort'                   => $setting['sort'],
            'order'                  => 'DESC',
            'start'                  => '0',
            'limit'                  => $setting['count']
        );

        $products = $this->model_extension_module_owlcarousel->getProducts($data);

        foreach ($products as $product) {
            if ($product['image']) {
                $image = $product['image'];
            } else {
                $image = 'placeholder.png';
            }

            if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                $price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            } else {
                $price = false;
            }

            if ((float)$product['special']) {
                $special = $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            } else {
                $special = false;
            }

            if ($this->config->get('config_tax')) {
                $tax = $this->currency->format((float)$product['special'] ? $product['special'] : $product['price'], $this->session->data['currency']);
            } else {
                $tax = false;
            }

            if ($this->config->get('config_review_status')) {
                $rating = (int)$product['rating'];
            } else {
                 $rating = false;
            }

            if (isset($this->request->get['route']) && isset($this->request->get['path']) && ($this->request->get['route'] == 'product/category' || isset($this->request->get['route']) && $this->request->get['route'] == 'product/product') && $setting['show_current_category'] == 1) {
                $url = $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $product['product_id']);
            } else {
                $url = $this->url->link('product/product', 'product_id=' . $product['product_id']);
            }

            if($product['product_id']) {

                $currency_code = !empty($this->session->data['currency']) ? $this->session->data['currency'] : $this->config->get('config_currency');
                if ($price) {
                  $price = rtrim(preg_replace("/[^0-9\.]/", "", $price), '.') . '<span class=\'currency-value\'>'. $this->currency->getSymbolRight($currency_code).'</span>';
              }
              if ($special) {
                  $special = rtrim(preg_replace("/[^0-9\.]/", "", $special), '.') . '<span class=\'currency-value\'>'. $this->currency->getSymbolRight($currency_code).'</span>';
              }
            

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
                    if($product_id == $product['product_id']) $wish_pd = true;
                  }
                }

                // Cart
                $incart = false;
                if ($this->cart->hasProducts()) {
                  $products_cart = $this->cart->getProducts();

                  foreach ($products_cart as $product_cart) {
                   if($product_cart['product_id'] == $product['product_id']) $incart = true;
                  }
                }
            
                $result[] = array(
                    'product_id'       => $product['product_id'],
                    'in_stock'         => (in_array($product['stock_status_id'], array(7,8))?1:0),
                    'thumb'            => $this->model_tool_image->resize($image, $setting['image_width'], $setting['image_height']),
                    'name'             => $product['name'],
                    'description'      => utf8_substr(strip_tags(html_entity_decode($product['description'], ENT_QUOTES, 'UTF-8')), 0, $setting['description']),
                    'href'             => $url,
                    'model'            => $product['model'],
                    'price'            => $price,

               'incart'       => $incart,
               'wish'         => $wish_pd,
            
                    'height'           => round($product['height'],0),
                    'length'           => round($product['length'],0),
                    'width'            => round($product['width'],0),
                    'diameter_of_pot'  => round($product['diameter_of_pot'],0),
                    'depth_of_pot'     => round($product['depth_of_pot'],0),
                    'special'          => $special,
                    'tax'              => $tax,
                    'rating'           => $rating,
                    'reviews'          => sprintf($this->language->get('text_reviews'), (int)$product['reviews'])
                );
            }
        }

        if((int)$setting['show_random_item'] == 1) {
        	shuffle($result);
        }
        return $result;


    }

    public function getCurrentProducts($setting){
        $result = array();

        if ($setting['category_id'] == 'featured') {
            $products = explode(',', $setting['featured']);
        }

        if ($setting['category_id'] == 'viewed') {
            $products = array();

            if (isset($this->request->cookie['viewed'])) {
                $products = explode(',', $this->request->cookie['viewed']);
            } else if (isset($this->session->data['viewed'])) {
                $products = $this->session->data['viewed'];
            }

            if (isset($this->request->get['product_id'])) {
                $product_id = $this->request->get['product_id'];
                $products = array_diff($products, array($product_id));
                array_unshift($products, $product_id);

                setcookie('viewed', implode(',',$products), time() + 3600 * 24 * 30, '/', $this->request->server['HTTP_HOST']);

                if (!isset($this->session->data['viewed']) || $this->session->data['viewed'] != $products) {
                    $this->session->data['viewed'] = $products;
                }
            }
        }

        if (empty($setting['count'])) {
            $setting['count'] = 5;
        }

        $data = array(
            'show_stock'             => $setting['show_stock'],
            'show_current_product'   => $setting['show_current_product'],
            'limit'                  => $setting['count']
        );

        array_unique($products);

        $products = array_slice($products, 0, (int)$setting['count']);


        foreach ($products as $product_id) {
            $product_info = $this->model_extension_module_owlcarousel->getProduct($product_id, $data);
            if ($product_info) {

        $product_info = $this->load->controller('extension/module/hpmodel/hpmodel/getCategoryBlock', $product_info);
      
                if ($product_info['image']) {
                    $image = $product_info['image'];
                } else {
                    $image = 'placeholder.png';
                }

                if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                    $price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $price = false;
                }

                if ((float)$product_info['special']) {
                    $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $special = false;
                }

                if ($this->config->get('config_tax')) {
                    $tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
                } else {
                    $tax = false;
                }

                if ($this->config->get('config_review_status')) {
                    $rating = $product_info['rating'];
                } else {
                    $rating = false;
                }

                if($product_info['product_id']) {

                $currency_code = !empty($this->session->data['currency']) ? $this->session->data['currency'] : $this->config->get('config_currency');
                if ($price) {
                  $price = rtrim(preg_replace("/[^0-9\.]/", "", $price), '.') . '<span class=\'currency-value\'>'. $this->currency->getSymbolRight($currency_code).'</span>';
              }
              if ($special) {
                  $special = rtrim(preg_replace("/[^0-9\.]/", "", $special), '.') . '<span class=\'currency-value\'>'. $this->currency->getSymbolRight($currency_code).'</span>';
              }
            

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
                    if($product_id == $product_info['product_id']) $wish_pd = true;
                  }
                }

                // Cart
                $incart = false;
                if ($this->cart->hasProducts()) {
                  $products_cart = $this->cart->getProducts();

                  foreach ($products_cart as $product) {
                   if($product['product_id'] == $product_info['product_id']) $incart = true;
                  }
                }
            
                    $result[] = array(
                        'product_id'      => $product_info['product_id'],

        'hpm_block' => !empty($product_info['hpm_block']) ? $product_info['hpm_block'] : '',
        
                        'thumb'           => $this->model_tool_image->resize($image, $setting['image_width'], $setting['image_height']),
                        'name'            => $product_info['name'],
                        'description'     => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $setting['description']) . '..',
                        'href'            => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
                        'price'           => $price,

               'incart'       => $incart,
               'wish'         => $wish_pd,
            
                        'special'         => $special,
                        'height'          => round($product_info['height'],0),
                        'length'          => round($product_info['length'],0),
                        'width'           => round($product_info['width'],0),
                        'diameter_of_pot' => round($product_info['diameter_of_pot'],0),
                        'depth_of_pot'    => round($product_info['depth_of_pot'],0),
                        'model'           => $product_info['model'],
                        'tax'             => $tax,
                        'rating'          => $rating,
                        'reviews'         => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews'])
                    );
                }
            }
        }

        if((int)$setting['show_random_item'] == 1) {
        	shuffle($result);
        }
        return $result;
    }

    public function crossdomainRequest(){

        $json = array();

        if(!isset($this->request->get['module_id'])) $json['error'] = "bad module_id";

        if (isset($this->request->get['product_id'])) {
            $product_id = (int)$this->request->get['product_id'];
        } else {
            $product_id = 0;
        }


        // cUrl request
        $this->load->model('tool/curl');

        $request_url = 'index.php?route=apinew/workplace/carouselProducts&productId='.(int)$product_id.'&module_id='.(int)$this->request->get['module_id'].'&language_id='.(int)$this->config->get('config_language_id');

        $response = $this->model_tool_curl->request($request_url);

        // check server response
        if((int)$response['status'] == 200) {
            $products = $response['data']['products'];
            $setting = $response['data']['settings'];
            $category = $response['data']['category'];
        } else {
            $json['error'] = "error request";
        }

        if(!$json) {

    		$json['settings'] = $setting;

    		// проверяем если это модуль просмотренные то добавляем в куки
    		if($setting['category_id'] == 'viewed') {

    			// disable carousel loop
    			$setting['show_loop'] = 0;
    			$products_viewed = array();

	            if (isset($this->request->cookie['viewed'])) {
	                $products_viewed = explode(',', $this->request->cookie['viewed']);
	            } else if (isset($this->session->data['viewed'])) {
	                $products_viewed = $this->session->data['viewed'];
	            }

                $json['products_viewed'] = $products_viewed;

    			if ($product_id) {
	                $products_viewed = array_diff($products_viewed, array($product_id));
	                array_unshift($products_viewed, $product_id);
	                setcookie('viewed', implode(',',$products_viewed), time() + 3600 * 24 * 30, '/', $this->request->server['HTTP_HOST']);

	                if (!isset($this->session->data['viewed']) || $this->session->data['viewed'] != $products_viewed) {
	                    $this->session->data['viewed'] = $products_viewed;
	                }
	            }


	            // делаем запрос к серверу апи на получение товаров по куки
	            if(is_array($products_viewed)) $products_viewed = implode(',', $products_viewed);

	            $get_viewed_products_url = 'index.php?route=apinew/workplace/carouselProductsViewed&products='.(string)$products_viewed.'&language_id='.(int)$this->config->get('config_language_id');

                // исключаем текщий товар из показа
                if($setting['show_current_product'] == 1 && $product_id) $get_viewed_products_url .= "&show_current_product=".(int)$product_id;
                
	            $response_viewed = $this->model_tool_curl->request($get_viewed_products_url);

                if($response_viewed['status'] == 200) {
                    $products = $response_viewed['data']['products'];
                }

	            if($setting['show_loop'] && 4 >= count($products)) $setting['show_loop'] = 0;

    		}

            // обработка данных

            $module_api = (int)$this->request->get['module_id'];
            $modules = array();
            $modules[] = $setting;

            $data['modules'] = array();

            $this->language->load('extension/module/owlcarousel');

            $data['unit_h'] = $this->language->get('unit_h');
            $data['unit_w'] = $this->language->get('unit_w');
            $data['unit_l'] = $this->language->get('unit_l');
            $data['unit'] = $this->language->get('unit');
            $data['text_popular'] = $this->language->get('text_popular');
            $data['text_see_all'] = $this->language->get('text_see_all');
            $data['button_cart']        = $this->language->get('button_cart');
            $data['button_wishlist']    = $this->language->get('button_wishlist');
            $data['button_compare']     = $this->language->get('button_compare');
            $data['text_tax']           = $this->language->get('text_tax');

            $module_key = 0;

                foreach ($modules as $key => $value) {
                     $sort_data[$key] = isset($value['sort_order_tabs']) ? $value['sort_order_tabs'] : 0;
                }

                array_multisort($sort_data, SORT_ASC, $modules);
            

              $data['button_wishlist'] = $this->language->get('button_wishlist');
              $data['button_inwishlist'] = $this->language->get('button_inwishlist');
              $data['button_cart_add'] = $this->language->get('button_cart_add');
              $data['button_incart'] = $this->language->get('button_incart');
            
            foreach ($modules as $mid => $setting) {
                $mid += $module_api;

                $vars = array();
                $vars['subtitle'] = $setting['subtitle'][$this->config->get('config_language_id')];
                if ($setting['category_id'] !== 'featured' && $setting['category_id'] !== 'viewed') {

                    if($setting['category_id']) {
                        $category_id = $setting['category_id'];
                    } else {
                        $category_id = $category['category_id'];
                    }

                    $vars['link_see_all'] = $this->url->link('product/category', 'path=' . $category_id);
                }else{
                    $vars['link_see_all'] ='';
                }
                if ($setting['title']) {
                    $vars['heading_title'] = $setting['title'][$this->config->get('config_language_id')];
                } else {
                    if (isset($category['name'])) {
                        $vars['heading_title'] = $category['name'];
                    } else {
                        $vars['heading_title'] = $this->language->get('heading_title');
                    }
                }

                $vars['visible']            = $setting['visible'];
                $vars['visible_1000']       = $setting['visible_1000'];
                $vars['visible_900']        = $setting['visible_900'];
                $vars['visible_600']        = $setting['visible_600'];
                $vars['visible_479']        = $setting['visible_479'];
                $vars['add_class_name']     = $setting['add_class_name'];
                $vars['sort']               = $setting['sort'];
                $vars['show_title']         = $setting['show_title'];
                $vars['show_name']          = $setting['show_name'];
                $vars['show_desc']          = $setting['show_desc'];
                $vars['show_price']         = $setting['show_price'];
                $vars['show_rate']          = $setting['show_rate'];
                $vars['show_cart']          = $setting['show_cart'];
                $vars['show_wishlist']      = $setting['show_wishlist'];
                $vars['show_compare']       = $setting['show_compare'];
                $vars['show_stop_on_hover'] = $setting['show_stop_on_hover'];
                $vars['show_tabs']          = $setting['show_tabs'];
                $vars['show_page']          = $setting['show_page'];
                $vars['show_loop']          = isset($setting['show_loop']) ? $setting['show_loop'] : '';
                $vars['show_nav']           = $setting['show_nav'];
                $vars['show_lazy_load']     = $setting['show_lazy_load'];
                $vars['show_mouse_drag']    = $setting['show_mouse_drag'];
                $vars['show_touch_drag']    = $setting['show_touch_drag'];
                $vars['show_per_page']      = $setting['show_per_page'];
                $vars['show_random_item']   = $setting['show_random_item'];

                if ($setting['slide_speed'] > 0) {
                    $vars['slide_speed'] = $setting['slide_speed'];}
                    else {$vars['slide_speed'] = 0;
                }

                if ($setting['pagination_speed'] > 0) {
                    $vars['pagination_speed'] = $setting['pagination_speed'];}
                    else {$vars['pagination_speed'] = 0;
                }

                if ($setting['autoscroll'] > 0) {
                    $vars['autoscroll'] = $setting['autoscroll'];}
                    else {$vars['autoscroll'] = 0;
                }

                if ($setting['item_prev_next'] > 0) {
                    $vars['item_prev_next'] = $setting['item_prev_next'];}
                    else {$vars['item_prev_next'] = 0;
                }

                if (isset($setting['rewind_speed']) && $setting['rewind_speed'] > 0) {
                    $vars['rewind_speed'] = $setting['rewind_speed'];}
                    else {$vars['rewind_speed'] = 0;
                }

                $this->load->model('extension/module/owlcarousel');
                //$this->load->model('tool/image');

                if (isset($setting['use_cache'])) {
                    $this->model_extension_module_owlcarousel->setCache($setting['use_cache'] ? 1 : 0);
                }

                $vars['products'] = $products;

                $vars['module'] = $module_api;

                $json['module'] = $mid;
                $json['show_loop'] = ($setting['show_loop'] == 0 ? 'false' : 'true');
                $json['show_nav'] = ($setting['show_nav'] == 1 ? 'true' : 'false');
                $json['show_random_item'] = ($setting['show_random_item'] == 1 ? 'true' : 'false');

                $json['loop'] = ($setting['add_class_name'] == 'viewed-products' ? 'false' : 'true');

                $module_api++;

                $data['modules'][$module_key] = $vars;
                $module_key++;

                $data['module'] = $module_api++;

            }

            if (!($product_id && ($setting['category_id'] == 'viewed' && $setting['hide_module'] == 1))) {
              if ($setting['template'] == "for_account"){
                  $json['template_name'] = 'account';
                  $json['template'] = $this->load->view('extension/module/owlcarousel_account_api', $data);
              }else{
                  $json['template'] = $this->load->view('extension/module/owlcarousel_api', $data);
              }
            } else {
                $json['hide'] = 'hide module or hidden template';
            }

        }



        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function microdataProducts($products){
      $json = array();
      $json['@context'] = 'http://schema.org';
      $json['@type'] = 'ItemList';
      $json['itemListElement'] = array();
      $i=1;
      foreach($products as $product) {
        if($i <= 3) {
            $json['itemListElement'][] = array(
                '@type' => 'ListItem',
                'position' => $i,
                'url' => $product['href']
            );
        }

        $i++;
      }


      $output = '<script type="application/ld+json">'.json_encode($json).'</script>'."\n";

      return $output;

    }
}
