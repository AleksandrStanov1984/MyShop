<?php
class ControllerCommonHeader extends Controller{
    public function index(){

        $this->document->addStyle('catalog/view/javascript/hpmodel/hpmodel.css?v2.2');
        $this->document->addScript('catalog/view/javascript/hpmodel/hpmodel.js?v2.2');
      

        $this->load->model('tool/home');

        $this->load->language('common/footer');
        $this->load->language('common/header');

        if (isset($this->session->data['is_mobile'])) {
            $data['is_mobile'] = $this->session->data['is_mobile'];
        }else{
            $data['is_mobile'] = $this->mobiledetectopencart->isMobile();
        }
        $data['route']            = $this->request->get['route'];
        $data['code']             = $this->session->data['language'];
        $data['text_information'] = $this->language->get('text_information');
        $data['text_contact']     = $this->language->get('text_contact');

        $data['informations'] = array();

        if($data['is_mobile'] == false) {
            $result_information_page = $this->model_tool_home->getInformations();
            foreach ($result_information_page as $result) {
                if ($result['bottom']) {
                    $data['informations'][] = array(
                        'title' => $result['title'],
                        'href' => $this->url->link('information/information', 'information_id=' . $result['information_id'])
                    );
                }
            }
        }
        $data['contact']      = $this->url->link('information/contact');
        $data['return']       = $this->url->link('account/return/add', '', true);
        $data['sitemap']      = $this->url->link('information/sitemap');
        $data['manufacturer'] = $this->url->link('product/manufacturer');
        $data['voucher']      = $this->url->link('account/voucher', '', true);
        $data['affiliate']    = $this->url->link('affiliate/account', '', true);
        $data['special']      = $this->url->link('product/special');
        $data['account']      = $this->url->link('account/account', '', true);
        $data['account_edit'] = $this->url->link('account/edit', '', true);
        $data['order']        = $this->url->link('account/order', '', true);
        $data['wishlist']     = $this->url->link('account/wishlist', '', true);
        $data['newsletter']   = $this->url->link('account/newsletter', '', true);

        $data['analytics'] = array();

        if ($this->request->server['HTTPS']) {
            $server = $this->config->get('config_ssl');
        } else {
            $server = $this->config->get('config_url');
        }

        if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
            $this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
        }

        $data['title'] = $this->document->getTitle();

        //info for openGraph
        if ($this->document->getName()) {
            $data['og_title'] = $this->document->getName();
        } else {
            $data['og_title'] = $this->document->getTitle();
        }

        if ($this->document->getName()) {
            $data['og_description'] = sprintf($this->language->get('text_og_title'), $this->document->getName());
        } else {
            $data['og_description'] = sprintf($this->language->get('text_og_title'), $this->language->get('text_og_site_name'));
        }

        $data['og_site_name'] = $this->language->get('text_og_site_name');

        if ($this->document->getOgImage() && is_file(DIR_IMAGE . $this->document->getOgImage())) {
            $data['og_image'] = $this->model_tool_image->resize($this->document->getOgImage(), $this->config->get($this->config->get('config_theme') . '_image_thumb_width'), $this->config->get($this->config->get('config_theme') . '_image_thumb_height'));
        } else {
            $data['og_image'] = HTTPS_SERVER . 'image/favicon/og_image.png';
        }

        $data['og_url'] = (($this->request->server['HTTPS']) ? 'https' : 'http') . '://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];

        //end info for openGraph
        $data['base'] = $server;
        $data['description'] = $this->document->getDescription();
        $data['keywords']    = $this->document->getKeywords();
        $data['links']       = $this->document->getLinks();

        $data['styles']  = $this->document->getStyles();
        $data['scripts'] = $this->document->getScripts();

        // OCFilter start
        if (isset($this->session->data['filter_meta'])) {
            $data['noindex'] = $this->document->isNoindex();
            unset($this->session->data['filter_meta']);
        }
        // OCFilter end

        $data['lang']      = $this->language->get('code');
        $data['direction'] = $this->language->get('direction');
        $data['name']      = $this->config->get('config_name');
        $data['name']      = $this->config->get('config_name');
        $data['open']      = $this->config->get('config_open');

        if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
            $data['logo'] = $server . 'image/' . $this->config->get('config_logo');
        } else {
            $data['logo'] = '';
        }

        $data['text_home'] = $this->language->get('text_home');

        // Wishlist
        if ($this->customer->isLogged()) {
            $this->load->model('account/wishlist');

            $data['text_wishlist']       = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
            $data['text_wishlist_total'] = $this->model_account_wishlist->getTotalWishlist();
        } else {
            $data['text_wishlist']       = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
            $data['text_wishlist_total'] = sprintf($this->language->get('text_wishlist_total'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
        }


        $data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
        $data['text_logged']        = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', true), $this->customer->getFirstName(), $this->url->link('account/logout', '', true));


        if ($this->customer->isLogged()) {
            $w_name = $this->customer->getFirstName();
            $data['text_account'] = sprintf($this->language->get('text_welcome_user'), $w_name);
        } else {
            $data['text_account'] = $this->language->get('text_account');
        }

        $data['text_register']            = $this->language->get('text_register');
        $data['text_login']               = $this->language->get('text_login');
        $data['text_order']               = $this->language->get('text_order');
        $data['text_transaction']         = $this->language->get('text_transaction');
        $data['text_download']            = $this->language->get('text_download');
        $data['text_logout']              = $this->language->get('text_logout');
        $data['text_checkout']            = $this->language->get('text_checkout');
        $data['text_category']            = $this->language->get('text_category');
        $data['text_all']                 = $this->language->get('text_all');
        $data['text_blog']                = $this->language->get('text_blog');
        $data['call_us']                  = $this->language->get('call_us');
        $data['type_us']                  = $this->language->get('type_us');
        $data['text_account_title']       = $this->language->get('text_account_title');
        $data['text_profile']             = $this->language->get('text_profile');
        $data['text_callback3']           = $this->language->get('text_callback3');
        $data['catalog']                  = $this->language->get('catalog');
        $data['text_free_ukraine']        = $this->language->get('text_free_ukraine');
        $data['text_open_dropdown_phone'] = $this->language->get('text_open_dropdown_phone');
        $data['text_stellagi']            = $this->language->get('text_stellagi');
        $data['text_safe']                = $this->language->get('text_safe');
        $data['all_blogs']                = $this->url->link('information/blogger/blogs');
        $data['text_your_city']           = $this->language->get('text_your_city');
        $data['text_yes']                 = $this->language->get('text_yes');
        $data['text_choose_another_city'] = $this->language->get('text_choose_another_city');
        $data['text_all_caterogies']      = $this->language->get('text_all_caterogies');


        $data['countcart'] = $this->cart->countProducts() ? $this->cart->countProducts() : 0;

        $include_information_page_id = array('16', '17', '18');
        if (isset($this->request->get['information_id']) &&
            in_array($this->request->get['information_id'], $include_information_page_id)) {
            $data['tongue_home'] = true;
        }
        if (isset($this->request->get['product_id'])) {
            if (isset($this->request->get['path'])) {
                $parts = explode('_', (string)$this->request->get['path']);
                $target_category = (int)array_shift($parts);
                if ($target_category != 0) {
                    $data['home'] = $this->url->link('common/home');
                }
            } else {
                $main_category = $this->model_tool_home->getMainCategory($this->request->get['product_id']);
                $data['home'] = $this->url->link('product/category', 'path=' . $main_category);
                $data['main_category'] = $this->url->link('product/category', 'path=' . $main_category);
            }
        } elseif (isset($this->request->get['path'])) {
            $parts = explode('_', (string)$this->request->get['path']);
            $target_category = (int)array_shift($parts);
            if ($target_category != 0) {
                $data['home'] = $this->url->link('common/home');

            } else {
                $data['home'] = $this->url->link('common/home');
            }

        } elseif (isset($this->request->get['information_id'])) {
            if (in_array($this->request->get['information_id'], $include_information_page_id)) {
                $data['catalog_link'] = $this->request->get['information_id'];
            } else {
                $data['home'] = $this->url->link('common/home');
            }
        } else {
            $data['home'] = $this->url->link('common/home');
        }

        if ((($this->request->get['route'] ?? false) === 'common/home') || (($this->request->get['_route_'] ?? false) === 'common/home')) {
            unset($data['home']);
        }

        // проверка на главную страницу
        $path = "common/home";
        $url = $_SERVER['REQUEST_URI'];
        if ($url == "/" or strripos($url, $path)) {
            $data['is_home'] = true;
        } else {
            $data['is_home'] = false;
        }

        $data['wishlist']           = $this->url->link('account/wishlist', '', true);
        $data['logged']             = $this->customer->isLogged();
        $data['account']            = $this->url->link('account/account', '', true);
        $data['register']           = $this->url->link('account/register', '', true);
        $data['login']              = $this->url->link('account/login', '', true);
        $data['order']              = $this->url->link('account/order', '', true);
        $data['transaction']        = $this->url->link('account/transaction', '', true);
        $data['download']           = $this->url->link('account/download', '', true);
        $data['logout']             = $this->url->link('account/logout', '', true);
        $data['shopping_cart']      = $this->url->link('checkout/cart');
        $data['checkout']           = $this->url->link('checkout/checkout', '', true);
        $data['contact']            = $this->url->link('information/contact');
        $data['telephone']          = $this->config->get('config_telephone');
        $data['fax']                = $this->config->get('config_fax');
        $data['mytemplate']         = $this->config->get('theme_default_directory');
        $data['text_question_city'] = $this->language->get('text_question_city');

        $data['blog_enable'] = 1;

        $data['categories'] = array();


        if($data['is_mobile'] == false){

            $categories = $this->model_tool_home->getCategories(0);
            foreach ($categories as $category) {
                if ($category['top']) {
                    // Level 2
                    $children_data = array();
                    $children = $this->model_tool_home->getCategories($category['category_id']);
                    foreach ($children as $child) {
                        if ($child['top']) {
                            $filter_data = array(
                                'filter_category_id'  => $child['category_id'],
                                'filter_sub_category' => true
                            );

                            /* 2 Level Sub Categories START */
                            $childs_data = array();
                            $child_2 = $this->model_tool_home->getCategories($child['category_id']);
                            foreach ($child_2 as $childs) {
                                if ($childs['top']) {
                                    $filter_data = array(
                                        'filter_category_id'  => $childs['category_id'],
                                        'filter_sub_category' => true
                                    );
                                    $childs_banners = array();
                                    $childs_banner_id = $this->model_tool_home->getBannerCategory($childs['category_id']);
                                    if ($childs_banner_id && isset($childs_banner_id['banner_status']) && $childs_banner_id['banner_status']) {
                                        $results = $this->model_tool_home->getBanner($childs_banner_id['banner_id']);
                                        foreach ($results as $result) {
                                            if (is_file(DIR_IMAGE . $result['image'])) {
                                                $childs_banners[] = array(
                                                    'title' => $result['title'],
                                                    'link'  => $result['link'],
                                                    'image' => $this->model_tool_image->resize($result['image'], $childs_banner_id['width'], $childs_banner_id['height'])
                                                );
                                            }
                                        }

                                    }
                                    $childs_data[] = array(
                                        'name'    => $childs['series_name'],
                                        'banners' => $childs_banners,
                                        'href'    => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'] . '_' . $childs['category_id'])
                                    );
                                }
                            }
                            /* 2 Level Sub Categories END */
                            if ($child['image']) {
                                $imagechild = $this->model_tool_image->resize($child['image'], 300, 300);
                            } else {
                                $imagechild = $this->model_tool_image->resize('placeholder.png', 300, 300);
                            }
                            $children_banners = array();
                            $child_banner_id = $this->model_tool_home->getBannerCategory($child['category_id']);
                            if ($child_banner_id && isset($child_banner_id['banner_status']) && $child_banner_id['banner_status']) {
                                $results = $this->model_tool_home->getBanner($child_banner_id['banner_id']);

                                foreach ($results as $result) {
                                    if (is_file(DIR_IMAGE . $result['image'])) {
                                        $children_banners[] = array(
                                            'title' => $result['title'],
                                            'link'  => $result['link'],
                                            'image' => $this->model_tool_image->resize($result['image'], $child_banner_id['width'], $child_banner_id['height'])
                                        );
                                    }
                                }
                            }

                            $children_data[] = array(
                                'name'    => $child['series_name'],
                                'childs'  => $childs_data,
                                'image'   => $imagechild,
                                'column'  => $child['column'] ? $child['column'] : 1,
                                'banners' => $children_banners,
                                'href'    => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
                            );
                        }
                    }
                    if ($category['image']) {
                        $image = $this->model_tool_image->resize($category['image'], 300, 300);
                    } else {
                        $image = $this->model_tool_image->resize('placeholder.png', 300, 300);
                    }
                    // Level 1
                    $category_banners = array();
                    $category_banner_id = $this->model_tool_home->getBannerCategory($category['category_id']);
                    if ($category_banner_id && isset($category_banner_id['banner_status']) && $category_banner_id['banner_status']) {
                        $results = $this->model_tool_home->getBanner($category_banner_id['banner_id']);
                        foreach ($results as $result) {
                            if (is_file(DIR_IMAGE . $result['image'])) {
                                $category_banners[] = array(
                                    'title' => $result['title'],
                                    'link'  => $result['link'],
                                    'image' => $this->model_tool_image->resize($result['image'], $category_banner_id['width'], $category_banner_id['height'])
                                );
                            }
                        }
                    }
                    $data['categories'][] = array(
                        'category_id' => $category['category_id'],
                        'name'        => $category['series_name'],
                        'image'       => $image,
                        'children'    => $children_data,
                        'column'      => $category['column'] ? $category['column'] : 1,
                        'banners'     => $category_banners,
                        'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
                    );
                }
            }
        }

        $data['newsblog_categories'] = array();
        if($data['is_mobile'] == false) {
            $categories = $this->model_tool_home->getCategoriesBlog(0);

            foreach ($categories as $category) {
                if ($category['settings']) {
                    $settings = unserialize($category['settings']);
                    if ($settings['show_in_top'] == 0) continue;
                }
                $articles = array();
                if ($category['settings'] && $settings['show_in_top_articles']) {
                    $filter = array('filter_category_id' => $category['category_id'], 'filter_sub_category' => true);
                    $results = $this->model_tool_home->getArticles($filter);

                    foreach ($results as $result) {
                        $articles[] = array(
                            'name' => $result['name'],
                            'href' => $this->url->link('newsblog/article', 'newsblog_path=' . $category['category_id'] . '&newsblog_article_id=' . $result['article_id'])
                        );
                    }
                }
                $data['categories'][] = array(
                    'name' => $category['name'],
                    'children' => $articles,
                    'column' => 1,
                    'href' => $this->url->link('newsblog/category', 'newsblog_path=' . $category['category_id'])
                );
            }
        }
        $data['language'] = $this->load->controller('common/language');
        $data['currency'] = $this->load->controller('common/currency');
        $data['search']   = $this->load->controller('common/search');
        $data['cart']     = $this->load->controller('common/cart');

        // For page specific css
        if (isset($this->request->get['route'])) {
            if (isset($this->request->get['product_id'])) {
                $class = '-' . $this->request->get['product_id'];
                $product_info = $this->model_tool_home->getImageProductHeader($this->request->get['product_id']);
                if ($product_info) {
                    $data['product_page'] = true;
                    if (is_file(DIR_IMAGE . $product_info)) {
                        $data['popup'] = $this->model_tool_image->resize($product_info, $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height'));
                        $data['thumb'] = $this->model_tool_image->resize($product_info, $this->config->get($this->config->get('config_theme') . '_image_thumb_width'), $this->config->get($this->config->get('config_theme') . '_image_thumb_height'));
                    } else {
                        $data['popup'] = $data['logo'];
                        $data['thumb'] = $data['logo'];
                    }
                }

            } elseif (isset($this->request->get['path'])) {
                $class = '-' . $this->request->get['path'];
            } elseif (isset($this->request->get['manufacturer_id'])) {
                $class = '-' . $this->request->get['manufacturer_id'];
            } elseif (isset($this->request->get['information_id'])) {
                $class = '-' . $this->request->get['information_id'];
            } else {
                $class = '';
            }

            $data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
            $data['class_page'] = str_replace('/', '-', $this->request->get['route']);
        } else {
            $data['class'] = 'common-home';
            $data['class_page'] = 'common-home';
        }


        $data['show_city_possible'] = true;
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
                $ipr = $this->db->query("SELECT loc.* FROM gl2_ua_blocks_ipv4 ip LEFT JOIN gl2_ua_locations loc ON (loc.geoname_id = ip.geoname_id AND loc.locale_code = 'ru') WHERE {$ipl} BETWEEN ip.iplf AND ip.iplt");
                $ipInfo = array_merge($ipr->row, $ipInfo);
                if($ipInfo['city_name']){
                    $ipInfo['info'] = $ipInfo['city_name'];
                }else{
                    $ipInfo['info'] = $ipInfo['ip'];
                }
            }
            $data['ip_info'] = $ipInfo;
            $this->session->data['city_product'] = $data['ip_info']['info'];
            $data['show_city_possible'] = true;
        }

        $a = str_split($data['ip_info']['info']);
        if (is_numeric($a[0])) {
            $ipInfo['info'] = 'Киев';
            $data['ip_info'] = $ipInfo;
            $this->session->data['city_product'] = 'Киев';
        }

        if ($data['ip_info']['info'] == 'Украина' || $data['ip_info']['info'] == 'украина') {
            $ipInfo['info'] = 'Киев';
            $data['ip_info'] = $ipInfo;
            $this->session->data['city_product'] = 'Киев';
        }

        if (!isset($data['noindex'])) {
            if (isset($this->request->get['utm']) || isset($this->request->get['sort']) || isset($this->request->get['gclid']) || isset($this->request->get['UAH']) || isset($this->request->get['RUR']) || isset($this->request->get['WMZ']) || isset($this->request->get['USD'])) {
                $data['noindex'] = true;
            }
        }

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');

        return $this->load->view('common/header', $data);
    }

    public function info(){
        $this->response->setOutput($this->index());
    }
}