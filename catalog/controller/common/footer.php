<?php

class ControllerCommonFooter extends Controller{
    public function index(){

        if ($this->config->get('ts_google_analytics_status')) {
            if (isset($this->session->data['ts_ga_ecommerce']) && !is_null($this->session->data['ts_ga_ecommerce'])) {
                $data['ts_google_analytics_ecommerce'] = json_decode($this->session->data['ts_ga_ecommerce'], true);
                unset($this->session->data['ts_ga_ecommerce']);
            }
        }
        if ($this->config->get('ts_google_analytics_status')) {
            $data['ts_google_analytics_counter'] = $this->load->controller('extension/analytics/ts_google_analytics/getcounter');
            $data['ts_google_analytics_counter_id'] = $this->config->get('ts_google_analytics_settings')['counter']['counter_id'];
            $data['ts_google_analytics_counter_type'] = $this->config->get('ts_google_analytics_settings')['counter']['type'];
            $data['ts_google_analytics_counter_mode'] = $this->config->get('ts_google_analytics_settings')['counter']['mode'];
            if ($this->config->get('ts_google_analytics_settings')['counter']['type'] == 'gtag') {
                $this->document->addScript('catalog/view/javascript/tramplin-studio/GoogleAnalytics/gtag.js');
            } else {
                $this->document->addScript('catalog/view/javascript/tramplin-studio/GoogleAnalytics/analytics.js');
            }
        }

        if (isset($this->session->data['is_mobile'])) {
            $data['is_mobile'] = $this->session->data['is_mobile'];
        }else{
            $data['is_mobile'] = $this->mobiledetectopencart->isMobile();
        }


        $this->load->language('common/footer');

        $this->load->model('module/referrer');
        $this->model_module_referrer->checkReferrer();

        $this->load->language('product/search');

        $data['text_empty']       = $this->language->get('text_empty');
        $data['text_column_name'] = $this->language->get('text_column_name');
        $data['text_column_size'] = $this->language->get('text_column_size');
        $data['text_sku']         = $this->language->get('text_sku');


        $data['scripts']                   = $this->document->getScripts('footer');
        $data['text_information']          = $this->language->get('text_information');
        $data['text_service']              = $this->language->get('text_service');
        $data['text_open_dropdown_phone']  = $this->language->get('text_open_dropdown_phone');
        $data['text_extra']                = $this->language->get('text_extra');
        $data['text_contact']              = $this->language->get('text_contact');
        $data['text_about']                = $this->language->get('text_about');
        $data['text_garantiya']            = $this->language->get('text_garantiya');
        $data['text_policy']               = $this->language->get('text_policy');
        $data['text_return']               = $this->language->get('text_return');
        $data['text_sitemap']              = $this->language->get('text_sitemap');
        $data['text_manufacturer']         = $this->language->get('text_manufacturer');
        $data['text_free_ukraine']         = $this->language->get('text_free_ukraine');
        $data['text_glad_to_introduce']    = $this->language->get('text_glad_to_introduce');
        $data['text_voucher']              = $this->language->get('text_voucher');
        $data['text_affiliate']            = $this->language->get('text_affiliate');
        $data['text_special']              = $this->language->get('text_special');
        $data['text_show_all_category']    = $this->language->get('text_show_all_category');

        if ($this->customer->isLogged()) {
            $w_name = $this->customer->getFirstName();
            $data['text_account'] = sprintf($this->language->get('text_welcome_user'), $w_name);
        } else {
            $data['text_account'] = $this->language->get('text_account');
        }

        $data['text_order']              = $this->language->get('text_order');
        $data['text_wishlist']           = $this->language->get('text_wishlist');
        $data['text_newsletter']         = $this->language->get('text_newsletter');
        $data['text_short_about_footer'] = $this->language->get('text_short_about_footer');
        $data['telephone']               = $this->config->get('config_telephone');
        $data['fax']                     = $this->config->get('config_fax');
        $data['email']                   = $this->config->get('config_email');
        $data['mytemplate']              = $this->config->get('theme_default_directory');
        $data['button_wishlist']         = $this->language->get('button_wishlist');
        $data['button_inwishlist']       = $this->language->get('button_inwishlist');
        $data['button_cart_add']         = $this->language->get('button_cart_add');
        $data['button_incart']           = $this->language->get('button_incart');
        $data['text_home']               = $this->language->get('text_home');
        $data['text_callback1']          = $this->language->get('text_callback1');
        $data['text_callback2']          = $this->language->get('text_callback2');
        $data['text_callback3']          = $this->language->get('text_callback3');
        $data['text_callback4']          = $this->language->get('text_callback4');
        $data['text_callback5']          = $this->language->get('text_callback5');
        $data['text_send']               = $this->language->get('text_send');

        $data['language'] = $this->load->controller('common/language');
        $data['cart']     = $this->load->controller('common/cart');

        $data['open']                     = $this->config->get('config_open');
        $data['text_open_right_footer']   = $this->language->get('text_open_right_footer');
        $data['text_catalog']             = $this->language->get('text_catalog');
        $data['text_catalog_tovarov']     = $this->language->get('text_catalog_tovarov');
        $data['text_menu']                = $this->language->get('text_menu');
        $data['text_callback_footer']     = $this->language->get('text_callback_footer');
        $data['text_taking_orders']       = $this->language->get('text_taking_orders');
        $data['text_delivery_from_stock'] = $this->language->get('text_delivery_from_stock');
        $data['subtitle_contact']         = $this->language->get('subtitle_contact');
        $data['subtitle_for_customers']   = $this->language->get('subtitle_for_customers');
        $data['subtitle_write_to_us']     = $this->language->get('subtitle_write_to_us');
        $data['subtitle_we_in_soc']       = $this->language->get('subtitle_we_in_soc');

        $data['countcart']                = $this->cart->countProducts() ? $this->cart->countProducts() : 0;

        $data['text_pickup_city_select'] = $this->language->get('text_pickup_city_select');
        $data['text_pickup_city_shop']   = $this->language->get('text_pickup_city_shop');
        $data['text_pickup_city_1']      = $this->language->get('text_pickup_city_1');
        $data['text_pickup_city_2']      = $this->language->get('text_pickup_city_2');
        $data['text_pickup_city_3']      = $this->language->get('text_pickup_city_3');
        $data['text_pickup_city_4']      = $this->language->get('text_pickup_city_4');
        $data['text_pickup_city_5']      = $this->language->get('text_pickup_city_5');
        $data['text_pickup_city_6']      = $this->language->get('text_pickup_city_6');
        $data['text_pickup_city_input']  = $this->language->get('text_pickup_city_input');

        $data['home'] = $this->url->link('common/home');

        // проверка на главную страницу
        if ($_SERVER['REQUEST_URI'] == "/index.php?route=common/home" OR $_SERVER['REQUEST_URI'] == "/" OR $_SERVER['REQUEST_URI'] == "/ua") {
            $data['is_home'] = true;
        } else {
            $data['is_home'] = false;
        }

        $this->load->model('tool/home');

        $data['informations'] = array();

        foreach ($this->model_tool_home->getInformations() as $result) {
            if ($result['bottom']) {
                $data['informations'][] = array(
                    'title' => $result['title'],
                    'href' => $this->url->link('information/information', 'information_id=' . $result['information_id'])
                );
            }
        }

        $data['contact']      = $this->url->link('information/contact');
        $data['about']        = $this->url->link('information/about');
        $data['return']       = $this->url->link('account/return/add', '', true);
        $data['garantiya']    = $this->url->link('information/information', 'information_id=21');
        $data['policy']       = $this->url->link('information/information', 'information_id=22');
        $data['sitemap']      = $this->url->link('information/sitemap');
        $data['manufacturer'] = $this->url->link('product/manufacturer');
        $data['voucher']      = $this->url->link('account/voucher', '', true);
        $data['checkout']     = $this->url->link('checkout/simplecheckout', '', true);
        $data['affiliate']    = $this->url->link('affiliate/account', '', true);
        $data['special']      = $this->url->link('product/special');
        $data['account']      = $this->url->link('account/edit', '', true);
        $data['order']        = $this->url->link('account/order', '', true);
        $data['wishlist']     = $this->url->link('account/wishlist', '', true);
        $data['newsletter']   = $this->url->link('account/newsletter', '', true);

        $data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

        $data['footertop']    = $this->load->controller('common/footertop');
        $data['footerbottom'] = $this->load->controller('common/footerbottom');
        $data['footerleft']   = $this->load->controller('common/footerleft');
        $data['footerright']  = $this->load->controller('common/footerright');
        $data['footercolumn'] = $this->load->controller('common/footercolumn');

        $data['route'] = $this->request->get['route'];

        $data['categories'] = array();

        if($data['is_mobile']) {
            $this->load->model('tool/home');
            $categories = $this->model_tool_home->getCategories(0);
            foreach ($categories as $category) {
                if ($category['top']) {
                    // Level 2
                    $children_data = array();

                    $children = $this->model_tool_home->getCategories($category['category_id']);

                    foreach ($children as $child) {
                        $filter_data = array(
                            'filter_category_id' => $child['category_id'],
                            'filter_sub_category' => true
                        );

                        /* 3 Level Sub Categories START */
                        $childs_data = array();
                        $child_2 = $this->model_tool_home->getCategories($child['category_id']);

                        foreach ($child_2 as $childs) {
                            $filter_data = array(
                                'filter_category_id'  => $childs['category_id'],
                                'filter_sub_category' => true
                            );
                            /* 4 Level Sub Categories START */
                            $great_childs_data = array();
                            $child_3 = $this->model_tool_home->getCategories($childs['category_id']);

                            foreach ($child_3 as $great_childs) {
                                $filter_data = array(
                                    'filter_category_id'  => $great_childs['category_id'],
                                    'filter_sub_category' => true
                                );

                                if ($great_childs['image']) {
                                    $imagegrandchild = $this->model_tool_image->resize($great_childs['image'], 300, 300);
                                } else {
                                    $imagegrandchild = $this->model_tool_image->resize('placeholder.png', 300, 300);
                                }

                                $great_childs_data[] = array(
                                    'name'   => $great_childs['series_name'],
                                    'image'  => $imagegrandchild,
                                    'href'   => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'] . '_' . $childs['category_id'] . '_' . $great_childs['category_id'])
                                );
                            }
                            /* 4 Level Sub Categories END */
                            if ($childs['image']) {
                                $imagegrandchild = $this->model_tool_image->resize($childs['image'], 300, 300);
                            } else {
                                $imagegrandchild = $this->model_tool_image->resize('placeholder.png', 300, 300);
                            }

                            $childs_data[] = array(
                                'name'        => $childs['series_name'],
                                'children'    => $great_childs_data,
                                'category_id' => $childs['category_id'],
                                'image'       => $imagegrandchild,
                                'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'] . '_' . $childs['category_id'])
                            );
                        }
                        /* 3 Level Sub Categories END */
                        if ($child['image']) {
                            $imagechild = $this->model_tool_image->resize($child['image'], 300, 300);
                        } else {
                            $imagechild = $this->model_tool_image->resize('placeholder.png', 300, 300);
                        }

                        $children_data[] = array(
                            'name'        => $child['series_name'],
                            'childs'      => $childs_data,
                            'category_id' => $child['category_id'],
                            'image'       => $imagechild,
                            'column'      => $child['column'] ? $child['column'] : 1,
                            'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
                        );
                    }

                    // Level 1
                    if ($category['image']) {
                        $image = $this->model_tool_image->resize($category['image'], 300, 300);
                    } else {
                        $image = $this->model_tool_image->resize('placeholder.png', 300, 300);
                    }
                    $data['categories'][] = array(
                        'name'        => $category['series_name'],
                        'category_id' => $category['category_id'],
                        'image'       => $image,
                        'children'    => $children_data,
                        'column'      => $category['column'] ? $category['column'] : 1,
                        'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
                    );
                }
            }
        }

        $data['parallax']     = $this->load->controller('common/parallax');
        $data['footertop']    = $this->load->controller('common/footertop');
        $data['footerbottom'] = $this->load->controller('common/footerbottom');
        $data['footerleft']   = $this->load->controller('common/footerleft');

        if (isset($this->session->data['city_product'])) {
            $ipInfo['info'] = $this->session->data['city_product'];
            $data['ip_info'] = $ipInfo;
        } else {
            $data['ip_info'] = '';
        }

        if (isset($this->session->data['city_product'])) {
            $data['city_product_session'] = $this->session->data['city_product'];
        }

        return $this->load->view('common/footer', $data);
    }
}
