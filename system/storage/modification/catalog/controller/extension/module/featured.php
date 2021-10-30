<?php
ini_set("display_errors", 1);
error_reporting(-1);

class ControllerExtensionModuleFeatured extends Controller
{
    public $featured_settings = [];

    public function index($setting)
    {
        $this->document->addStyle('catalog/view/theme/OPC080193_6/stylesheet/module_featured.css');
        $this->featured_settings = $setting;
        $db_rec = serialize($setting);

        if (isset($setting)) {
            $this->db->query("UPDATE " . DB_PREFIX . "ajax SET settings = '" . $db_rec . "' WHERE id = '1'");
        }

        $this->load->language('extension/module/featured');

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_tax'] = $this->language->get('text_tax');
        $data['button_cart'] = $this->language->get('button_cart');
        $data['button_wishlist'] = $this->language->get('button_wishlist');
        $data['button_compare'] = $this->language->get('button_compare');
        $data['label_sale'] = $this->language->get('label_sale');
        $data['outofstock'] = $this->language->get('outofstock');
        $data['catalog'] = $this->language->get('catalog');
        $data['catalogmobile'] = $this->language->get('catalogmobile');
        $data['viewall'] = $this->language->get('viewall');
        $data['viewallsizes'] = $this->language->get('viewallsizes');
        $data['category1'] = $this->language->get('category1');
        $data['category2'] = $this->language->get('category2');
        $data['category3'] = $this->language->get('category3');
        $data['unit_h'] = $this->language->get('unit_h');
        $data['unit_w'] = $this->language->get('unit_w');
        $data['unit_l'] = $this->language->get('unit_l');
        $data['unit'] = $this->language->get('unit');
        $data['text_max_min_weight'] = $this->language->get('text_max_min_weight');
        $data['text_max_min_weight_all'] = $this->language->get('text_max_min_weight_all');
        $data['off'] = $this->language->get('off');
        $data['text_select_category'] = $this->language->get('text_select_category');
        $data['text_catalog_header_left'] = $this->language->get('text_catalog_header_left');
        $data['text_catalog_header_right'] = $this->language->get('text_catalog_header_right');
        $data['text_select_size'] = $this->language->get('text_select_size');
        $data['text_filter_height'] = $this->language->get('text_filter_height');
        $data['text_filter_width'] = $this->language->get('text_filter_width');
        $data['podbor_hint'] = $this->language->get('podbor_hint');
        $data['text_filter_material'] = $this->language->get('text_filter_material');
        $data['text_filter_model'] = $this->language->get('text_filter_model');
        $data['text_filter_color'] = $this->language->get('text_filter_color');
        $data['text_filter_weight'] = $this->language->get('text_filter_weight');
        $data['text_filter_thickness'] = $this->language->get('text_filter_thickness');
        $data['text_filter_type'] = $this->language->get('text_filter_type');
        $data['text_filter_series'] = $this->language->get('text_filter_series');
        $data['text_filter_brand'] = $this->language->get('text_filter_brand');
        $data['text_filter_qnt_shelv'] = $this->language->get('text_filter_qnt_shelv');
        $data['text_filter_length'] = $this->language->get('text_filter_length');
        $data['text_filter_info'] = $this->language->get('text_filter_info');
        $data['text_popular_size'] = $this->language->get('text_popular_size');
        $data['text_one_shelf'] = $this->language->get('text_one_shelf');
        $data['text_shelfs_color'] = $this->language->get('text_shelfs_color');
        $data['text_shelfs_material'] = $this->language->get('text_shelfs_material');
        $data['text_shelfs_model'] = $this->language->get('text_shelfs_model');
        $data['text_filter_prod_model'] = $this->language->get('text_filter_prod_model');
        $data['text_filter_shelf'] = $this->language->get('text_filter_shelf');
        $data['text_filter_shelfs'] = $this->language->get('text_filter_shelfs');
        $data['text_filter_shelf_for'] = $this->language->get('text_filter_shelf_for');
        $data['text_select_filter_start'] = $this->language->get('text_select_filter_start');
        $data['text_select_more'] = $this->language->get('text_select_more');
        $data['text_more_options'] = $this->language->get('text_more_options');
        $data['text_filter_reset'] = $this->language->get('text_filter_reset');
        $data['text_incompatible_combination_sizes'] = $this->language->get('text_incompatible_combination_sizes');
        $data['text_rezult'] = $this->language->get('text_rezult');
        $data['text_rezult_shelf'] = $this->language->get('text_rezult_shelf');
        $data['text_rezult_shelfs'] = $this->language->get('text_rezult_shelfs');
        $data['text_rezult_shelf_for'] = $this->language->get('text_rezult_shelf_for');


        $this->load->model('catalog/product');
        $this->load->model('catalog/category');

        $this->load->model('tool/image');

        if (isset($setting['category_id']) && !empty($setting['category_id'])) {
            $parent_category_id = $setting['category_id'];
        } else {
            $parent_category_id = 20;
        }

        $data['categories'] = array();

        $categoriesCacheName = "module.featured.category.{$parent_category_id}";
        $results = $this->cache->get($categoriesCacheName);
        if ($results === false) {
            $results = $this->model_catalog_category->getCategories($parent_category_id);
            $this->cache->set($categoriesCacheName, $results);
        }
        // $results = $this->model_catalog_category->getCategories($parent_category_id);

        foreach ($results as $result) {
            $_filter = array('filter_category_id' => $result['category_id'], 'start' => 0, 'limit' => 1000, 'sort' => 'p.sort_order');
            $productsCacheName = "module.featured.products." . md5(json_encode($_filter));
            $products = $this->cache->get($productsCacheName);
            if ($products === false) {
                $products = $this->model_catalog_product->getProducts1($_filter);
                $this->cache->set($productsCacheName, $products);
            }
            //$products = $this->model_catalog_product->getProducts1(array('filter_category_id'=>$result['category_id'],'start'=>0,'limit'=>1000,'sort'=>'p.sort_order' ));

            $prods = array();

            foreach ($products as $product_id) {

                if (isset($setting['s_height']) && isset($setting['s_width']) && isset($setting['s_length']) && isset($setting['s_cat_id'])) {

                } elseif ($product_id['visible_carusel'] == 0) {
                    continue;
                }

                $product_id = $product_id['product_id'];

                $productInfoCacheName = "module.featured.product_info.{$product_id}";
                $product_info = $this->cache->get($productInfoCacheName);
                if ($product_info === false) {
                    $product_info = $this->model_catalog_product->getProduct($product_id);
                    $this->cache->set($productInfoCacheName, $product_info);
                }
                //$product_info = $this->model_catalog_product->getProduct($product_id);

                if ($product_info) {


        $product_info = $this->load->controller('extension/module/hpmodel/hpmodel/getCategoryBlock', $product_info);
      
                    if ($product_info['image']) {
                        $image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
                    } else {
                        $image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
                    }
                    $productImagesCacheName = "module.featured.product_images.{$product_id}";
                    $images = $this->cache->get($productImagesCacheName);
                    if ($product_info === false) {
                        $images = $this->model_catalog_product->getProductImages($product_info['product_id']);
                        $this->cache->set($productImagesCacheName, $images);
                    }
                    // $images = $this->model_catalog_product->getProductImages($product_info['product_id']);

                    if (isset($images[0]['image']) && !empty($images)) {
                        $images = $images[0]['image'];
                    } else {
                        $images = $image;
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


                    $prods[] = array(
                        'product_id' => $product_info['product_id'],

        'hpm_block' => !empty($product_info['hpm_block']) ? $product_info['hpm_block'] : '',
        
                        'thumb' => $image,
                        'thumb_swap' => $this->model_tool_image->resize($images, $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height')),
                        'name' => $product_info['name'],
                        'model' => $product_info['model'],
                        'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
                        'price' => $price,
                        'special' => $special,
                        'quantity_shelves' => $product_info['quantity_shelves'],
                        'maximum_weight' => $product_info['maximum_weight'],
                        'maximum_weight_all' => $product_info['maximum_weight_all'],
                        'material_shelves' => $product_info['material_shelves'],
                        'model_selection' => $product_info['model_selection'],
                        'color_shelves' => $product_info['color_shelves'],
                        'metal_thickness' => $product_info['metal_thickness'],
                        'type' => $product_info['type'],
                        'series' => $product_info['series'],
                        'brand' => $product_info['brand'],
                        'location' => $product_info['location'],
                        'quantity' => $product_info['quantity'],
                        'tax' => $tax,
                        'rating' => $rating,
                        'height' => round($product_info['height'], 0),
                        'length' => round($product_info['length'], 0),
                        'width' => round($product_info['width'], 0),
                        'href' => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
                    );
                }
            }

            $names = array('aHeight', 'aWidth', 'aLength', 'aMaterial', 'aModel', 'aColor', 'aWeight', 'aThickness', 'aQntShelv', 'aType', 'aSeries', 'aBrand');

            foreach ($names as $name) {
                $$name = array();
            }

            /*$aLength = array();
                  $aWidth = array();
                  $aHeight = array();

                  $aMaterial = array();
                  $aModel = array();
                  $aColor = array();
                  $aWeight = array();
                  $aThickness = array();
                  $aType = array();
                  $aSeries = array();
                  $aBrand = array();
                  $aQntShelv = array();*/

            foreach ($products as $product_id) {

                $aLength[] .= $product_id['length'];
                $aWidth[] .= $product_id['width'];
                $aHeight[] .= $product_id['height'];

                if ($result['material_filter_status'] == 1) {
                    if (!empty($product_id['material_shelves'])) {
                        $aMaterial[] .= $product_id['material_shelves'];
                    }
                }

                if ($result['model_filter_status'] == 1) {
                    if (!empty($product_id['model_selection'])) {
                        $aModel[] .= $product_id['model_selection'];
                    }
                }

                if ($result['color_filter_status'] == 1) {
                    if (!empty($product_id['color_shelves'])) {
                        $aColor[] .= $product_id['color_shelves'];
                    }
                }

                if ($result['max_weight_filter_status'] == 1) {
                    if (!empty($product_id['maximum_weight'])) {
                        $aWeight[] .= $product_id['maximum_weight'];
                    }
                }

                if ($result['thickness_filter_status'] == 1) {
                    if (!empty($product_id['metal_thickness']) && $product_id['metal_thickness'] != 0) {
                        $aThickness[] .= $product_id['metal_thickness'];
                    }
                }

                if ($result['type_filter_status'] == 1) {
                    if (!empty($product_id['type'])) {
                        $aType[] .= $product_id['type'];
                    }
                }

                if ($result['series_filter_status'] == 1) {
                    if (!empty($product_id['series'])) {
                        $aSeries[] .= $product_id['series'];
                    }
                }

                if ($result['brand_filter_status'] == 1) {
                    if (!empty($product_id['brand'])) {
                        $aBrand[] .= $product_id['brand'];
                    }
                }

                if ($result['qnt_shelv_filter_status'] == 1) {
                    if (!empty($product_id['quantity_shelves']) && $product_id['quantity_shelves'] != 0) {
                        $aQntShelv[] .= $product_id['quantity_shelves'];
                    }
                }

            }

            asort($aLength);
            asort($aWidth);
            asort($aHeight);

            if ($result['material_filter_status'] == 1) {
                asort($aMaterial);
            }

            if ($result['model_filter_status'] == 1) {
                asort($aModel);
            }

            if ($result['color_filter_status'] == 1) {
                asort($aColor);
            }

            if ($result['max_weight_filter_status'] == 1) {
                asort($aWeight);
            }

            if ($result['thickness_filter_status'] == 1) {
                asort($aThickness);
            }

            if ($result['type_filter_status'] == 1) {
                asort($aType);
            }

            if ($result['series_filter_status'] == 1) {
                asort($aSeries);
            }

            if ($result['brand_filter_status'] == 1) {
                asort($aBrand);
            }

            if ($result['qnt_shelv_filter_status'] == 1) {
                asort($aQntShelv);
            }

            if (!empty($aMaterial) || !empty($aModel) || !empty($aColor) || !empty($aWeight) || !empty($aThickness) || !empty($aType) || !empty($aSeries) || !empty($aBrand) || !empty($aQntShelv)) {
                $more_filter_visible = true;
            } else {
                $more_filter_visible = false;
            }

            if ($result['material_popup_status'] == 1) {
                $material_popup_status = $result['material_popup_status'];
            }

            if ($result['model_popup_status'] == 1) {
                $model_popup_status = $result['model_popup_status'];
            }

            if ($result['color_popup_status'] == 1) {
                $color_popup_status = $result['color_popup_status'];
            }

            if ($result['max_weight_popup_status'] == 1) {
                $max_weight_popup_status = $result['max_weight_popup_status'];
            }

            if ($result['thickness_popup_status'] == 1) {
                $thickness_popup_status = $result['thickness_popup_status'];
            }

            if ($result['type_popup_status'] == 1) {
                $type_popup_status = $result['type_popup_status'];
            }

            if ($result['series_popup_status'] == 1) {
                $series_popup_status = $result['series_popup_status'];
            }

            if ($result['brand_popup_status'] == 1) {
                $brand_popup_status = $result['brand_popup_status'];
            }

            if ($result['qnt_shelv_popup_status'] == 1) {
                $qnt_shelv_popup_status = $result['qnt_shelv_popup_status'];
            }


        $result = $this->load->controller('extension/module/hpmodel/hpmodel/getCategoryBlock', $result);
      
            if ($result['image']) {
                $thumb = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_category_width'), $this->config->get($this->config->get('config_theme') . '_image_category_height'));
            } else {
                $thumb = 'image/no_image.png';
            }

            $data['categories'][] = array(
                'category_id' => $result['category_id'],
                'name' => $result['name'],
                'thumb' => $thumb,
                'series_name' => $result['series_name'],
                'additional_input' => $result['additional_input'],
                'additional_input2' => $result['additional_input2'],
                'description' => $result['description'],
                'more_filter_visible' => $more_filter_visible,
                'aLength' => array_unique($aLength),
                'aWidth' => array_unique($aWidth),
                'aHeight' => array_unique($aHeight),
                'aMaterial' => array_unique($aMaterial),
                'aModel' => array_unique($aModel),
                'aColor' => array_unique($aColor),
                'aWeight' => array_unique($aWeight),
                'aThickness' => array_unique($aThickness),
                'aType' => array_unique($aType),
                'aSeries' => array_unique($aSeries),
                'aBrand' => array_unique($aBrand),
                'aQntShelv' => array_unique($aQntShelv),
                'color_popup_status' => (isset($color_popup_status) ? $color_popup_status : 0),
                'material_popup_status' => (isset($material_popup_status) ? $material_popup_status : 0),
                'model_popup_status' => (isset($model_popup_status) ? $model_popup_status : 0),
                'max_weight_popup_status' => (isset($max_weight_popup_status) ? $max_weight_popup_status : 0),
                'thickness_popup_status' => (isset($thickness_popup_status) ? $thickness_popup_status : 0),
                'type_popup_status' => (isset($type_popup_status) ? $type_popup_status : 0),
                'series_popup_status' => (isset($series_popup_status) ? $series_popup_status : 0),
                'brand_popup_status' => (isset($brand_popup_status) ? $brand_popup_status : 0),
                'qnt_shelv_popup_status' => (isset($qnt_shelv_popup_status) ? $qnt_shelv_popup_status : 0),
                'products' => $prods
            );

            /*foreach($names as $name) {
               $data['categories'][$name] = array_unique($$name);
           }*/

        }

        if(isset($setting['module_title'])){
            $data['heading_title'] = $setting['module_title'][$this->config->get('config_language_id')];
        }else{
            $data['heading_title'] = $this->language->get('heading_title');
        }
        $data['products'] = array();
        $data['text_home_products'] = $this->language->get('text_home_products');

        $data['text_trigger1'] = $this->language->get('text_trigger1');
        $data['text_trigger2'] = $this->language->get('text_trigger2');
        $data['text_trigger3'] = $this->language->get('text_trigger3');
        $data['text_buy'] = $this->language->get('text_buy');


        $data['setting_name'] = $setting['name'];

        $data['view_setting'] = $this->featured_settings;

        return $this->load->view('extension/module/featured', $data);

    }

    public function getProds()
    {

        $setting = $this->getSettings();
        $s_height = $this->request->post['s_height'];
        $s_width = $this->request->post['s_width'];
        $s_length = $this->request->post['s_length'];
        $s_cat_id = $this->request->post['s_cat_id'];

        if (isset($this->request->post['s_material']) && !empty($this->request->post['s_material'])) $s_material = $this->request->post['s_material']; else $s_material = 0;

        if (isset($this->request->post['s_model']) && !empty($this->request->post['s_model'])) $s_model = $this->request->post['s_model']; else $s_model = 0;

        if (isset($this->request->post['s_color']) && !empty($this->request->post['s_color'])) $s_color = $this->request->post['s_color']; else $s_color = 0;

        if (isset($this->request->post['s_weight']) && !empty($this->request->post['s_weight'])) $s_weight = $this->request->post['s_weight']; else $s_weight = 0;

        if (isset($this->request->post['s_thickness']) && !empty($this->request->post['s_thickness'])) $s_thickness = $this->request->post['s_thickness']; else $s_thickness = 0;

        if (isset($this->request->post['s_type']) && !empty($this->request->post['s_type'])) $s_type = $this->request->post['s_type']; else $s_type = 0;

        if (isset($this->request->post['s_series']) && !empty($this->request->post['s_series'])) $s_series = $this->request->post['s_series']; else $s_series = 0;

        if (isset($this->request->post['s_brand']) && !empty($this->request->post['s_brand'])) $s_brand = $this->request->post['s_brand']; else $s_brand = 0;

        if (isset($this->request->post['s_qnt_shelv']) && !empty($this->request->post['s_qnt_shelv'])) $s_qnt_shelv = $this->request->post['s_qnt_shelv']; else $s_qnt_shelv = 0;

        $this->load->language('extension/module/featured');

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_tax'] = $this->language->get('text_tax');
        $data['button_cart'] = $this->language->get('button_cart');
        $data['button_wishlist'] = $this->language->get('button_wishlist');
        $data['button_compare'] = $this->language->get('button_compare');
        $data['label_sale'] = $this->language->get('label_sale');
        $data['outofstock'] = $this->language->get('outofstock');
        $data['catalog'] = $this->language->get('catalog');
        $data['catalogmobile'] = $this->language->get('catalogmobile');
        $data['viewall'] = $this->language->get('viewall');
        $data['viewallsizes'] = $this->language->get('viewallsizes');
        $data['category1'] = $this->language->get('category1');
        $data['category2'] = $this->language->get('category2');
        $data['category3'] = $this->language->get('category3');
        $data['text_max_min_weight'] = $this->language->get('text_max_min_weight');
        $data['text_max_min_weight_all'] = $this->language->get('text_max_min_weight_all');
        $data['off'] = $this->language->get('off');
        $data['text_select_category'] = $this->language->get('text_select_category');
        $data['text_select_size'] = $this->language->get('text_select_size');
        $data['text_filter_height'] = $this->language->get('text_filter_height');
        $data['text_filter_width'] = $this->language->get('text_filter_width');
        $data['text_filter_length'] = $this->language->get('text_filter_length');
        $data['text_filter_info'] = $this->language->get('text_filter_info');
        $data['text_filter_material'] = $this->language->get('text_filter_material');
        $data['text_filter_model'] = $this->language->get('text_filter_model');
        $data['text_filter_color'] = $this->language->get('text_filter_color');
        $data['text_filter_weight'] = $this->language->get('text_filter_weight');
        $data['text_filter_thickness'] = $this->language->get('text_filter_thickness');
        $data['text_filter_type'] = $this->language->get('text_filter_type');
        $data['text_filter_series'] = $this->language->get('text_filter_series');
        $data['text_filter_brand'] = $this->language->get('text_filter_brand');
        $data['text_filter_qnt_shelv'] = $this->language->get('text_filter_qnt_shelv');
        $data['text_popular_size'] = $this->language->get('text_popular_size');
        $data['text_one_shelf'] = $this->language->get('text_one_shelf');
        $data['text_shelfs_color'] = $this->language->get('text_shelfs_color');
        $data['text_shelfs_material'] = $this->language->get('text_shelfs_material');
        $data['text_shelfs_model'] = $this->language->get('text_shelfs_model');
        $data['text_filter_prod_model'] = $this->language->get('text_filter_prod_model');
        $data['text_filter_shelf'] = $this->language->get('text_filter_shelf');
        $data['text_filter_shelfs'] = $this->language->get('text_filter_shelfs');
        $data['text_filter_shelf_for'] = $this->language->get('text_filter_shelf_for');
        $data['text_select_filter_start'] = $this->language->get('text_select_filter_start');
        $data['text_incompatible_combination_sizes'] = $this->language->get('text_incompatible_combination_sizes');
        $data['text_rezult'] = $this->language->get('text_rezult');
        $data['text_rezult_shelf'] = $this->language->get('text_rezult_shelf');
        $data['text_rezult_shelfs'] = $this->language->get('text_rezult_shelfs');
        $data['text_rezult_shelf_for'] = $this->language->get('text_rezult_shelf_for');

        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        $this->load->model('tool/image');

        $data['categories'] = array();

        $category_info = $this->model_catalog_category->getCategory($s_cat_id);
        $category_parent_info = $this->model_catalog_category->getCategory($category_info['parent_id']);


        if ($category_info) {

            if ($category_info['series_name']) {
                $category_name = $category_info['series_name'];
            } else {
                $category_name = $category_info['name'];
            }

            $category_additional_input2 = $category_info['additional_input2'];


            if ($category_info['material_popup_status'] == 1) {
                $data['material_popup_status'] = $category_info['material_popup_status'];
            }

            if ($category_info['model_popup_status'] == 1) {
                $data['model_popup_status'] = $category_info['model_popup_status'];
            }

            if ($category_info['color_popup_status'] == 1) {
                $data['color_popup_status'] = $category_info['color_popup_status'];
            }

            if ($category_info['max_weight_popup_status'] == 1) {
                $data['max_weight_popup_status'] = $category_info['max_weight_popup_status'];
            }

            if ($category_info['thickness_popup_status'] == 1) {
                $data['thickness_popup_status'] = $category_info['thickness_popup_status'];
            }

            if ($category_info['type_popup_status'] == 1) {
                $data['type_popup_status'] = $category_info['type_popup_status'];
            }

            if ($category_info['series_popup_status'] == 1) {
                $data['series_popup_status'] = $category_info['series_popup_status'];
            }

            if ($category_info['brand_popup_status'] == 1) {
                $data['brand_popup_status'] = $category_info['brand_popup_status'];
            }

            if ($category_info['qnt_shelv_popup_status'] == 1) {
                $data['qnt_shelv_popup_status'] = $category_info['qnt_shelv_popup_status'];
            }
        }

        $filter_data = array(
            'filter_category_id' => $s_cat_id,
            'start' => 0,
            'limit' => 1000,
            'sort' => 'p.sort_order',
            'height' => $s_height,
            'width' => $s_width,
            'length' => $s_length,
            'material_shelves' => $s_material,
            'model_selection' => $s_model,
            'color_shelves' => $s_color,
            'maximum_weight' => $s_weight,
            'metal_thickness' => $s_thickness,
            'type' => $s_type,
            'series' => $s_series,
            'brand' => $s_brand,
            'quantity_shelves' => $s_qnt_shelv
        );

        $products = $this->model_catalog_product->getProducts1($filter_data);

        $prods = array();


        foreach ($products as $product_id) {
            $product_id = $product_id['product_id'];
            $product_info = $this->model_catalog_product->getProduct($product_id);
            if ($product_info) {

        $product_info = $this->load->controller('extension/module/hpmodel/hpmodel/getCategoryBlock', $product_info);
      
                if ($product_info['image']) {
                    //$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
                    $image = $this->model_tool_image->resize($product_info['image'], 400, 400);
                } else {
                    $image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
                }
                //added for image swap

                $images = $this->model_catalog_product->getProductImages($product_info['product_id']);

                if (isset($images[0]['image']) && !empty($images)) {
                    $images = $images[0]['image'];
                } else {
                    $images = $image;
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


                $prods[] = array(
                    'product_id' => $product_info['product_id'],

        'hpm_block' => !empty($product_info['hpm_block']) ? $product_info['hpm_block'] : '',
        
                    'thumb' => $image,
                    'thumb_swap' => $this->model_tool_image->resize($images, $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height')),
                    'name' => $product_info['name'],
                    'model' => $product_info['model'],
                    'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
                    'price' => $price,
                    'special' => $special,
                    'quantity_shelves' => $product_info['quantity_shelves'],
                    'maximum_weight' => $product_info['maximum_weight'],
                    'maximum_weight_all' => $product_info['maximum_weight_all'],
                    'material_shelves' => $product_info['material_shelves'],
                    'model_selection' => $product_info['model_selection'],
                    'color_shelves' => $product_info['color_shelves'],
                    'metal_thickness' => $product_info['metal_thickness'],
                    'type' => $product_info['type'],
                    'series' => $product_info['series'],
                    'brand' => $product_info['brand'],
                    'location' => $product_info['location'],
                    'quantity' => $product_info['quantity'],
                    'tax' => $tax,
                    'rating' => $rating,
                    'height' => round($product_info['height'], 0),
                    'length' => round($product_info['length'], 0),
                    'width' => round($product_info['width'], 0),
                    'href' => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
                );
            }
        }


        // сортировка по высоте, затем по количеству полок
        foreach ($prods as $key => $value) {
            $sort_data[$key] = $value['height'];
            $sort_data2[$key] = $value['quantity_shelves'];
        }
        $sort_data = $sort_data ?? [];
        $sort_data2 = $sort_data2 ?? [];
        $prods = $prods ?? [];
        array_multisort($sort_data, SORT_ASC, $sort_data2, SORT_ASC, $prods);

        $data['categories'][] = array(
            'category_id' => $s_cat_id,
            'series_name' => $category_name,
            'name' => $category_additional_input2,
            'parent_id' => $category_parent_info['parent_id'],
            'products' => $prods
        );

        $data['text_home_products'] = $this->language->get('text_home_products');

        $data['text_buy'] = $this->language->get('text_buy');
        $this->response->setOutput($this->load->view('extension/module/filterprod', $data));

    }

    public function getFilterProducts()
    {

        $names = array('aHeight', 'aWidth', 'aLength', 'aMaterial', 'aModel', 'aColor', 'aWeight', 'aThickness', 'aQntShelv', 'aType', 'aSeries', 'aBrand');
        $namesFull = array('aHeightFull', 'aWidthFull', 'aLengthFull', 'aMaterialFull', 'aModelFull', 'aColorFull', 'aWeightFull', 'aThicknessFull', 'aQntShelvFull', 'aTypeFull', 'aSeriesFull', 'aBrandFull');
        $sdNames = array('sdHeight', 'sdWidth', 'sdLength', 'sdMaterial', 'sdModel', 'sdColor', 'sdWeight', 'sdThickness', 'sdQntShelv', 'sdType', 'sdSeries', 'sdBrand');

        $namesWithFull = array_merge($names, $namesFull);
        $allNames = array_merge($names, $namesFull, $sdNames);

        // пролучаем отправленные данные
        $reset = $this->request->post['sd_reset'];
        $sd_cat_id = $this->request->post['sd_cat_id'];

        // удаляем данные если они сущестовали
        foreach ($allNames as $name) {
            if (isset($$name)) unset($$name);
        }
        /*if(isset($aHeight)) unset($aHeight);
          if(isset($aWidth)) unset($aWidth);
          if(isset($aLength)) unset($aLength);
          if(isset($aMaterial)) unset($aMaterial);
          if(isset($aModel)) unset($aModel);
          if(isset($aColor)) unset($aColor);
          if(isset($aWeight)) unset($aWeight);
          if(isset($aThickness)) unset($aThickness);
          if(isset($aType)) unset($aType);
          if(isset($aSeries)) unset($aSeries);
          if(isset($aBrand)) unset($aBrand);
          if(isset($aQntShelv)) unset($aQntShelv);

          if(isset($aHeightFull)) unset($aHeightFull);
          if(isset($aWidthFull)) unset($aWidthFull);
          if(isset($aLengthFull)) unset($aLengthFull);
          if(isset($aMaterialFull)) unset($aMaterialFull);
          if(isset($aModelFull)) unset($aModelFull);
          if(isset($aColorFull)) unset($aColorFull);
          if(isset($aWeightFull)) unset($aWeightFull);
          if(isset($aThicknessFull)) unset($aThicknessFull);
          if(isset($aTypeFull)) unset($aTypeFull);
          if(isset($aSeriesFull)) unset($aSeriesFull);
          if(isset($aBrandFull)) unset($aBrandFull);
          if(isset($aQntShelvFull)) unset($aQntShelvFull);*/

        /*if(isset($sdHeight)) unset($sdHeight);
        if(isset($sdWidth)) unset($sdWidth);
        if(isset($sdLength)) unset($sdLength);
        if(isset($sdMaterial)) unset($sdMaterial);
        if(isset($sdModel)) unset($sdModel);
        if(isset($sdColor)) unset($sdColor);
        if(isset($sdWeight)) unset($sdWeight);
        if(isset($sdThickness)) unset($sdThickness);
        if(isset($sdType)) unset($sdType);
        if(isset($sdSeries)) unset($sdSeries);
        if(isset($sdBrand)) unset($sdBrand);
        if(isset($sdQntShelv)) unset($sdQntShelv);*/

        // очистка по клику на кнопку очистить
        if ($reset == 1) {

            $getSizes = $this->getSizesDB($sd_cat_id);
            $i = 0;
            foreach ($namesFull as $name) {
                $$name = $getSizes[$i];
                $i++;
            }
            /*$aHeightFull = $getSizes[0];
             $aWidthFull = $getSizes[1];
             $aLengthFull = $getSizes[2];
             $aMaterialFull = $getSizes[3];
             $aModelFull = $getSizes[4];
             $aColorFull = $getSizes[5];
             $aWeightFull = $getSizes[6];
             $aThicknessFull = $getSizes[7];
             $aQntShelvFull = $getSizes[8];
             $aTypeFull = $getSizes[9];
             $aSeriesFull = $getSizes[10];
             $aBrandFull = $getSizes[11];*/

        } else { // событие изменение select


            // получаем все значения товаров категории
            $filter_data_all = array(
                'filter_category_id' => $sd_cat_id,
                'start' => 0,
                'limit' => 1000,
                'sort' => 'p.sort_order'
            );

            // товары отвечающие фильтру
            $this->load->model('catalog/product');
            $products_all = $this->model_catalog_product->getProducts1($filter_data_all);

            foreach ($namesFull as $name) {
                $$name = array();
            }
            /*$aHeightFull = array();
            $aWidthFull = array();
            $aLengthFull = array();
            $aMaterialFull = array();
            $aModelFull = array();
            $aColorFull = array();
            $aWeightFull = array();
            $aThicknessFull = array();
            $aTypeFull = array();
            $aSeriesFull = array();
            $aBrandFull = array();
            $aQntShelvFull = array();*/

            // получаем все доступные комбинации для товаров
            foreach ($products_all as $product) {
                if ($product['width'] && !empty($product['width'])) {
                    $aWidthFull[] = $product['width'];
                }
                if ($product['height'] && !empty($product['height'])) {
                    $aHeightFull[] = $product['height'];
                }
                if ($product['length'] && !empty($product['length'])) {
                    $aLengthFull[] = $product['length'];
                }
                if ($product['material_shelves'] && !empty($product['material_shelves'])) {
                    $aMaterialFull[] = $product['material_shelves'];
                }
                if ($product['model_selection'] && !empty($product['model_selection'])) {
                    $aModelFull[] = $product['model_selection'];
                }
                if ($product['color_shelves'] && !empty($product['color_shelves'])) {
                    $aColorFull[] = $product['color_shelves'];
                }
                if ($product['maximum_weight'] && !empty($product['maximum_weight'])) {
                    $aWeightFull[] = $product['maximum_weight'];
                }
                if ($product['metal_thickness'] && !empty($product['metal_thickness']) && $product['metal_thickness'] != 0) {
                    $aThicknessFull[] = $product['metal_thickness'];
                }
                if ($product['type'] && !empty($product['type'])) {
                    $aTypeFull[] = $product['type'];
                }
                if ($product['series'] && !empty($product['series'])) {
                    $aSeriesFull[] = $product['series'];
                }
                if ($product['brand'] && !empty($product['brand'])) {
                    $aBrandFull[] = $product['brand'];
                }
                if ($product['quantity_shelves'] && !empty($product['quantity_shelves']) && $product['quantity_shelves'] != 0) {
                    $aQntShelvFull[] = $product['quantity_shelves'];
                }

            }

            // проверяем на пустоту
            if (!empty($this->request->post['sdHeight'])) $sdHeight = $this->request->post['sdHeight']; else $sdHeight = 0;
            if (!empty($this->request->post['sdWidth'])) $sdWidth = $this->request->post['sdWidth']; else $sdWidth = 0;
            if (!empty($this->request->post['sdLength'])) $sdLength = $this->request->post['sdLength']; else $sdLength = 0;
            if (!empty($this->request->post['sdMaterial'])) $sdMaterial = $this->request->post['sdMaterial']; else $sdMaterial = 0;
            if (!empty($this->request->post['sdModel'])) $sdModel = $this->request->post['sdModel']; else $sdModel = 0;
            if (!empty($this->request->post['sdColor'])) $sdColor = $this->request->post['sdColor']; else $sdColor = 0;
            if (!empty($this->request->post['sdWeight'])) $sdWeight = $this->request->post['sdWeight']; else $sdWeight = 0;
            if (!empty($this->request->post['sdThickness'])) $sdThickness = $this->request->post['sdThickness']; else $sdThickness = 0;
            if (!empty($this->request->post['sdType'])) $sdType = $this->request->post['sdType']; else $sdType = 0;
            if (!empty($this->request->post['sdSeries'])) $sdSeries = $this->request->post['sdSeries']; else $sdSeries = 0;
            if (!empty($this->request->post['sdBrand'])) $sdBrand = $this->request->post['sdBrand']; else $sdBrand = 0;
            if (!empty($this->request->post['sdQntShelv'])) $sdQntShelv = $this->request->post['sdQntShelv']; else $sdQntShelv = 0;

            // получаем только совместимые с данным фильтров комбинации
            $filter_data_set = array(
                'filter_category_id' => $sd_cat_id,
                'start' => 0,
                'limit' => 1000,
                'sort' => 'p.sort_order',
                'filter_sd_param' => (isset($this->request->post['sd_param']) ? $this->request->post['sd_param'] : 0),
                'filter_sd_value' => (isset($this->request->post['sd_value']) ? $this->request->post['sd_value'] : 0),
                'height' => $sdHeight,
                'width' => $sdWidth,
                'length' => $sdLength,
                'material_shelves' => $sdMaterial,
                'model_selection' => $sdModel,
                'color_shelves' => $sdColor,
                'maximum_weight' => $sdWeight,
                'metal_thickness' => $sdThickness,
                'type' => $sdType,
                'series' => $sdSeries,
                'brand' => $sdBrand,
                'quantity_shelves' => $sdQntShelv
            );

            $products_set = $this->model_catalog_product->getProducts1($filter_data_set);

            foreach ($names as $name) {
                $$name = array();
            }
            /*$aHeight = array();
        $aWidth = array();
        $aLength = array();
        $aMaterial = array();
        $aModel = array();
        $aColor = array();
        $aWeight = array();
        $aThickness = array();
        $aType = array();
        $aSeries = array();
        $aBrand = array();
        $aQntShelv = array();*/

            // получаем все доступные комбинации для товаров
            foreach ($products_set as $product) {
                if ($product['width'] && !empty($product['width'])) {
                    $aWidth[] = $product['width'];
                }
                if ($product['height'] && !empty($product['height'])) {
                    $aHeight[] = $product['height'];
                }
                if ($product['length'] && !empty($product['length'])) {
                    $aLength[] = $product['length'];
                }
                if ($product['material_shelves'] && !empty($product['material_shelves'])) {
                    $aMaterial[] = $product['material_shelves'];
                }
                if ($product['model_selection'] && !empty($product['model_selection'])) {
                    $aModel[] = $product['model_selection'];
                }
                if ($product['color_shelves'] && !empty($product['color_shelves'])) {
                    $aColor[] = $product['color_shelves'];
                }
                if ($product['maximum_weight'] && !empty($product['maximum_weight'])) {
                    $aWeight[] = $product['maximum_weight'];
                }
                if ($product['metal_thickness'] && !empty($product['metal_thickness']) && $product['metal_thickness'] != 0) {
                    $aThickness[] = $product['metal_thickness'];
                }
                if ($product['type'] && !empty($product['type'])) {
                    $aType[] = $product['type'];
                }
                if ($product['series'] && !empty($product['series'])) {
                    $aSeries[] = $product['series'];
                }
                if ($product['brand'] && !empty($product['brand'])) {
                    $aBrand[] = $product['brand'];
                }
                if ($product['quantity_shelves'] && !empty($product['quantity_shelves']) && $product['quantity_shelves'] != 0) {
                    $aQntShelv[] = $product['quantity_shelves'];
                }

            }

        }

        foreach ($namesWithFull as $name) {
            if (isset($$name)) sort($$name);
        }


        /*if(isset($aWidth)) sort($aWidth);
        if(isset($aLength)) sort($aLength);
        if(isset($aMaterial)) sort($aMaterial);
        if(isset($aModel)) sort($aModel);
        if(isset($aColor)) sort($aColor);
        if(isset($aWeight)) sort($aWeight);
        if(isset($aThickness)) sort($aThickness);
        if(isset($aType)) sort($aType);
        if(isset($aSeries)) sort($aSeries);
        if(isset($aBrand)) sort($aBrand);
        if(isset($aQntShelv)) sort($aQntShelv);

        if(isset($aHeightFull)) sort($aHeightFull);
        if(isset($aWidthFull)) sort($aWidthFull);
        if(isset($aLengthFull)) sort($aLengthFull);
        if(isset($aMaterialFull)) sort($aMaterialFull);
        if(isset($aModelFull)) sort($aModelFull);
        if(isset($aColorFull)) sort($aColorFull);
        if(isset($aWeightFull)) sort($aWeightFull);
        if(isset($aThicknessFull)) sort($aThicknessFull);
        if(isset($aTypeFull)) sort($aTypeFull);
        if(isset($aSeriesFull)) sort($aSeriesFull);
        if(isset($aBrandFull)) sort($aBrandFull);
        if(isset($aQntShelvFull)) sort($aQntShelvFull);*/


        $json_data = array(
            'sd_cat_id' => isset($sd_cat_id) ? $sd_cat_id : '',
            'param_array' => $this->request->post,
            /*'aHeight' => isset($aHeight) ? array_unique($aHeight) : '',
            'aWidth' => isset($aWidth) ? array_unique($aWidth) : '',
            'aLength' => isset($aLength) ? array_unique($aLength) : '',
            'aMaterial' => isset($aMaterial) ? array_unique($aMaterial) : '',
            'aModel' => isset($aModel) ? array_unique($aModel) : '',
            'aColor' => isset($aColor) ? array_unique($aColor) : '',
            'aWeight' => isset($aWeight) ? array_unique($aWeight) : '',
            'aThickness' => isset($aThickness) ? array_unique($aThickness) : '',
            'aType' => isset($aType) ? array_unique($aType) : '',
            'aSeries' => isset($aSeries) ? array_unique($aSeries) : '',
            'aBrand' => isset($aBrand) ? array_unique($aBrand) : '',
            'aQntShelv' => isset($aQntShelv) ? array_unique($aQntShelv) : '',
            'aHeightFull' => isset($aHeightFull) ? array_unique($aHeightFull) : '',
            'aWidthFull' => isset($aWidthFull) ? array_unique($aWidthFull) : '',
            'aLengthFull' => isset($aLengthFull) ? array_unique($aLengthFull) : '',
            'aMaterialFull' => isset($aMaterialFull) ? array_unique($aMaterialFull) : '',
            'aModelFull' => isset($aModelFull) ? array_unique($aModelFull) : '',
            'aColorFull' => isset($aColorFull) ? array_unique($aColorFull) : '',
            'aWeightFull' => isset($aWeightFull) ? array_unique($aWeightFull) : '',
            'aThicknessFull' => isset($aThicknessFull) ? array_unique($aThicknessFull) : '',
            'aTypeFull' => isset($aTypeFull) ? array_unique($aTypeFull) : '',
            'aSeriesFull' => isset($aSeriesFull) ? array_unique($aSeriesFull) : '',
            'aBrandFull' => isset($aBrandFull) ? array_unique($aBrandFull) : '',
            'aQntShelvFull' => isset($aQntShelvFull) ? array_unique($aQntShelvFull) : ''*/
        );

        foreach ($namesWithFull as $name) {
            if (isset($$name)) {
                $json_data[$name] = array_unique($$name);
            } else {
                $json_data[$name] = '';
            }

        }

        echo json_encode($json_data);


    }

    public function getSizesDB($sd_cat_id)
    {

        $sql = "SELECT p.product_id,  p.height,  p.width,  p.length, p.material_shelves, p.model_selection, p.color_shelves, p.maximum_weight, p.metal_thickness, p.quantity_shelves, p.type, p.series, p.brand
            FROM oc_product p
            LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)
                 WHERE p.status = 1 AND p2c.category_id =  " . (int)$sd_cat_id . "  GROUP BY p.product_id ORDER BY p.height ASC, p.width ASC, p.length ASC ";

        $query = $this->db->query($sql);

        $select_data = array();

        foreach ($query->rows as $item) {
            $select_data[$item['product_id']] = array(
                'height' => $item['height'],
                'width' => $item['width'],
                'length' => $item['length'],
                'material_shelves' => $item['material_shelves'],
                'model_selection' => $item['model_selection'],
                'color_shelves' => $item['color_shelves'],
                'maximum_weight' => $item['maximum_weight'],
                'metal_thickness' => $item['metal_thickness'],
                'quantity_shelves' => $item['quantity_shelves'],
                'type' => $item['type'],
                'series' => $item['series'],
                'brand' => $item['brand']
            );
        }

        $names = array('aHeight', 'aWidth', 'aLength', 'aMaterial', 'aModel', 'aColor', 'aWeight', 'aThickness', 'aQntShelv', 'aType', 'aSeries', 'aBrand');

        foreach ($names as $name) {
            $$name = array();
        }

        /*$aLength = array();
        $aWidth = array();
        $aHeight = array();
        $aMaterial = array();
        $aModel = array();
        $aColor = array();
        $aWeight = array();
        $aThickness = array();
        $aQntShelv = array();
        $aType = array();
        $aSeries = array();
        $aBrand = array();*/

        foreach ($select_data as $data) {
            $aHeight[] .= $data['height'];
            $aWidth[] .= $data['width'];
            $aLength[] .= $data['length'];

            if (!empty($data['material_shelves'])) {
                $aMaterial[] .= $data['material_shelves'];
            }

            if (!empty($data['model_selection'])) {
                $aModel[] .= $data['model_selection'];
            }

            if (!empty($data['color_shelves'])) {
                $aColor[] .= $data['color_shelves'];
            }

            if (!empty($data['maximum_weigh'])) {
                $aWeight[] .= $data['maximum_weight'];
            }

            if ($data['metal_thickness'] != 0) {
                $aThickness[] .= $data['metal_thickness'];
            }

            if ($data['quantity_shelves'] != 0) {
                $aQntShelv[] .= $data['quantity_shelves'];
            }

            if (!empty($data['type'])) {
                $aType[] .= $data['type'];
            }
            if (!empty($data['series'])) {
                $aSeries[] .= $data['series'];
            }
            if (!empty($data['brand'])) {
                $aBrand[] .= $data['brand'];
            }


        }
        $result = array();
        foreach ($names as $name) {
            sort($$name);
            $result[] = $$name;
        }
        /*sort($aHeight);
            sort($aWidth);
            sort($aLength);
            sort($aMaterial);
            sort($aModel);
            sort($aColor);
            sort($aWeight);
            sort($aThickness);
            sort($aQntShelv);
            sort($aType);
            sort($aSeries);
            sort($aBrand);*/

        //return array($aHeight, $aWidth, $aLength, $aMaterial, $aModel, $aColor, $aWeight, $aThickness, $aQntShelv, $aType, $aSeries, $aBrand );
        return $result;

    }

    public function getCatDescriptions()
    {
        $this->load->language('extension/module/featured');
        $category_id = $this->request->post['category_id'];
        if (isset($category_id)) {
            $setting = $this->getSettings();
            $this->load->model('catalog/category');
            $data = array();
            $results = $this->model_catalog_category->getCategory($category_id);

            $data = array(
                'description' => $this->language->get('landing_desc_category_'.$category_id),
            );
            if ($data) {
                $this->response->setOutput($this->load->view('extension/module/catdescription', $data));
            }
        }
    }

    public function getSettings()
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

}
