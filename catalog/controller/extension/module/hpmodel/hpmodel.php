<?php

class ControllerExtensionModuleHpmodelHpmodel extends Controller {
    private $type;

    public function getNeAttr(){
        
        $this->load->model('extension/module/hpmodel');
        $parent = $this->model_extension_module_hpmodel->getParent($product_id);
        
        $this->load->model('catalog/product');
        $this->load->model('catalog/attribute');
        
    }
    
    public function product_variant_type_table($product_id) {
        $data = array();

        $this->load->model('extension/module/hpmodel');

        $parent = $this->model_extension_module_hpmodel->getParent($product_id);
        if (!$parent) return;


        
        $this->load->model('tool/image');
        $this->load->model('catalog/product');
        $this->load->model('catalog/attribute');

        if (empty($this->types)) $this->types = $this->model_extension_module_hpmodel->getTypes();
        if (empty($parent['type_id']) || empty($this->types[$parent['type_id']]) || empty($this->types[$parent['type_id']]['setting']['category_show'])) return;

        $language_id = (int)$this->config->get('config_language_id');
        $type = $this->types[$parent['type_id']];

        $type['setting']['child_image_width'] = !empty($type['setting']['product_image_width']) ? $type['setting']['product_image_width'] : 50;
        $type['setting']['child_image_height'] = !empty($type['setting']['product_image_height']) ? $type['setting']['product_image_height'] : 50;
        $type['setting']['limit'] = 0;
        $type['setting']['product_columns'] = !empty($type['setting']['product_columns']) ? $type['setting']['product_columns'] : array();
        $type['setting']['product_attributes'] = !empty($type['setting']['product_attributes']) ? $type['setting']['product_attributes'] : array();
        $type['setting']['replace_image'] = !empty($type['setting']['replace_image']) ? $type['setting']['replace_image'] : false;

        $childs = $this->model_extension_module_hpmodel->getChilds($parent['parent_id'], 0, $parent['type_id']);

        $data['products'] = $this->prepareProducts($type['setting'], $childs);

        if (count($data['products']) <= 1) return;

        
        $data['attribute_info'] = array();
        if(isset($type['setting']['category_attributes'])){
            foreach($type['setting']['category_attributes'] as $attribute_id){
                $data['attribute_info'][(int)$attribute_id] = $this->model_catalog_attribute->getAttribute((int)$attribute_id);
            }
        }


        $data['attribute_colors'] = array();
        $data['attribute_variants'] = array();
        $data['attribute_variants_key'] = array();
        foreach($data['products'] as $product){
            
            foreach($product['view'] as $index => $view){
                $views = explode(';', trim($view, ';'));
                foreach($views as $row){
                    $data['attribute_variants'][$index][$row] = $row;
                    $data['attribute_variants_key'][$index][$row] = md5($index.'_'.$row);
                    //$data['attribute_in_product'][$product['product_id']] .= ' '.md5($index.'_'.$row);
                    $data['attribute_in_product_nc'][$product['product_id']] .= ' '.md5($index.'_'.$row);
                }
            }
            
        }
      
        
       foreach($data['attribute_variants'] as $index => $value){
            sort($value);
            $data['attribute_variants'][$index] = $value;
            
            if($index == "attribute-15"){
                foreach($value as $row){
                    $color_info = $this->model_catalog_attribute->getColorInfo($row);
                    $color = explode(';',trim($color_info['color'], ';'));
					$bg = '';	
                    if(count($color) > 1){
                        $gradient = array();
                        $step = (int)(100/count($color));
                        $count = 0;
                        
                        foreach($color as $col){
                            $gradient[] = $col.' '.(($count++)*$step).'%';
                            $gradient[] = $col.' '.(($count)*$step).'%';
                        }
                        $bg = 'style="background: linear-gradient(90deg, '.implode(',',$gradient).');"';
                    }else{
                        $bg = 'style="background-color:'.$color[0].';"';
                    }
                    $data['attribute_colors'][$row] = $bg;
                }
            }
        }

        if(isset($this->request->get['product_id']) AND (int)$this->request->get['product_id'] == 80137){
 
        }


        
        $data['product_id'] = $product_id;
        $data['selected_product_id'] = $product_id;
        $data['title_name'] = !empty($type['setting']['product_title'][$language_id]) ? html_entity_decode($type['setting']['product_title'][$language_id], ENT_QUOTES, 'UTF-8') : '';

        $data['custom_css'] = !empty($type['setting']['custom_css']) ? $type['setting']['custom_css'] : false;
        $data['custom_js'] = !empty($type['setting']['custom_js']) ? $type['setting']['custom_js'] : false;

        $data['hash'] = !empty($type['setting']['hash']) ? $type['setting']['hash'] : false;
        $data['name_as_title'] = !empty($type['setting']['product_name_as_title']) ? $type['setting']['product_name_as_title'] : false;
        $data['name_a'] = !empty($type['setting']['after_title']) ? $type['setting']['after_title'] : false;

        $data['replace_h1'] = !empty($type['setting']['replace_h1']) ? $type['setting']['replace_h1'] : false;
        $data['replace_image'] = !empty($type['setting']['replace_image']) ? $type['setting']['replace_image'] : false;
        $data['replace_desc'] = !empty($type['setting']['replace_desc']) ? $type['setting']['replace_desc'] : false;
        $data['replace_att'] = !empty($type['setting']['replace_att']) ? $type['setting']['replace_att'] : false;

        $data['path'] = !empty($this->request->get['path']) ? '&path='.$this->request->get['path'] : '';

        $result = array();

        if (floatval(VERSION) >= 2.2) {
            $data['config'] = $this->load->view('extension/module/hpmodel/config', $data);

            $result['html'] = $this->load->view('extension/module/hpmodel/hpmodel', $data);
        } else {
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/extension/module/hpmodel/config.tpl')) {
                $data['config'] = $this->load->view($this->config->get('config_template') . '/template/extension/module/hpmodel/config.tpl', $data);
            } else {
                $data['config'] = $this->load->view('default/template/extension/module/hpmodel/config.tpl', $data);
            }

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/extension/module/hpmodel/hpmodel.tpl')) {
                
                $result['html'] = $this->load->view($this->config->get('config_template') . '/template/extension/module/hpmodel/hpmodel.tpl', $data);
            } else {
                
                $result['html'] = $this->load->view('default/template/extension/module/hpmodel/hpmodel.tpl', $data);
            }
        }

        return $result;
    }

    public function getForm() {
        if (!empty($this->request->post['hpmodel_orig']) || !isset($this->request->get['product_id'])) {
            $file = DIR_APPLICATION . 'hpmodel.log';
            // Открываем файл для получения существующего содержимого
            $current = file_get_contents($file);
            // Добавляем нового человека в файл
            $current .= $this->request->get['product_id'] . '-' . $this->request->post['hpmodel_orig'] . "\n";
            // Пишем содержимое обратно в файл
            file_put_contents($file, $current);
            return $this->product_variant_type_table((int)$this->request->get['product_id']);
        }else{
            return;
        }
    }

    private function prepareProducts($setting, $childs) {
        $products = array();

        $product_ids = array();
        foreach ($childs as $child) {
            $product_ids[] = $child['product_id'];
        }
        $products_data = $this->model_extension_module_hpmodel->getProducts($product_ids);

        if (!isset($setting['product_columns'])) $setting['product_columns'] = array();

        $attributes_id = array();
        foreach ($setting['product_columns'] as $key => $column) {
            if ($column == 'attribute' && !empty($setting['product_attributes'][$key])) $attributes_id[$key] = $setting['product_attributes'][$key];
        }

        if (!empty($setting['after_title']) && $setting['after_title'] == 'attribute' && !empty($setting['after_title_attribute'])) {
            $attributes_id['at'] = $setting['after_title_attribute'];
        }

        foreach ($products_data as $product_info) {
            $view = array();

            if (!empty($setting['hidden_if_null']) && $product_info['quantity'] < 1) continue;

            if ($attributes_id) {
                $attributes = $this->model_extension_module_hpmodel->getProductAttributes($product_info['product_id'], $attributes_id);
            } else {
                $attributes = array();
            }

            foreach ($setting['product_columns'] as $key => $column) {
                if (empty($column) || $column == 'none') {
                    continue;
                }

                $value = isset($product_info[$column]) ? $product_info[$column] : '';

                switch ($column) {
                    case 'attribute':
                        if (!empty($attributes_id[$key]) && !empty($attributes[$attributes_id[$key]])) {
                            $value = $attributes[$attributes_id[$key]];
                            $column .= '-' . $attributes_id[$key];
                        } else {
                            $value = false;
                        }
                        break;
                    case 'col_weight':
                        $value = (float)$product_info['weight'];
                        break;
                    case 'col_size':
                        $value = (float)$product_info['length'].'x'.(float)$product_info['width'].'x'.(float)$product_info['height'];
                        break;
                    case 'price':
                        if ((float)$product_info['special']) {
                            $value = '<span class="hprice-old">' . $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']) . '</span><br /><span class="hprice-new">' . $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']) . '</span>';
                        } else {
                            $value = '<span class="hprice">' . $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']) . '</span>';
                        }
                        break;
                    case 'image':
                        $thumb_image = !empty($product_info['image']) ? $product_info['image'] : 'no_image.png';
                        $value = '<img src="' . $this->model_tool_image->resize($thumb_image, $setting['child_image_width'], $setting['child_image_height']) . '" />';
                        break;
                }

                if ($value) $view[$column] = $value;
            }

            if (!$view) continue;

            $product_info['after_title'] = !empty($setting['after_title']) && !empty($product_info[$setting['after_title']]) ? $product_info[$setting['after_title']] : '';

            if (!empty($attributes_id['at'])) $product_info['after_title'] = !empty($attributes[$attributes_id['at']]) ? $attributes[$attributes_id['at']] : '';

            $product_info['view'] = $view;
            $product_info['href'] = $this->url->link('product/product', 'product_id=' . $product_info['product_id'] . (!empty($this->request->get['path']) ? '&path='.$this->request->get['path'] : ''));
            $product_info['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            $product_info['special'] = (float)$product_info['special'] ? $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']) : false;

            if (!empty($setting['replace_image'])) {
                if (!$product_info['product_image']) $product_info['product_image'] = 'no_image.png';
                if (version_compare(VERSION, '3.0', '>=')) {
                    $product_info['thumb'] = $this->model_tool_image->resize($product_info['product_image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
                } else {
                    $product_info['thumb'] = $this->model_tool_image->resize($product_info['product_image'], $this->config->get($this->config->get('config_theme') . '_image_product_width') ? $this->config->get($this->config->get('config_theme') . '_image_product_width') : $this->config->get('config_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height') ? $this->config->get($this->config->get('config_theme') . '_image_product_height') : $this->config->get('config_image_product_height'));
                }
            }

            $products[] = $product_info;
            if ((int)$setting['limit'] && count($products) >= $setting['limit']) break;
        }

        return $products;
    }

    public function getCategoryBlock($product_info) {
        $data = array();

        if (!isset($product_info['product_id'])) return $product_info;
        $this->document->addScript('catalog/view/theme/OPC080193_6/js/hpm_category_block.js');
        $this->load->model('extension/module/hpmodel');

        $parent = $this->model_extension_module_hpmodel->getParent($product_info['product_id']);
        if (!$parent) return $product_info;

        $this->load->model('catalog/product');

        if (empty($this->types)) $this->types = $this->model_extension_module_hpmodel->getTypes();
        if (empty($parent['type_id']) || empty($this->types[$parent['type_id']]) || empty($this->types[$parent['type_id']]['setting']['category_show'])) return $product_info;

        $language_id = (int)$this->config->get('config_language_id');
        $type = $this->types[$parent['type_id']];
        /*if ( $_SERVER['REMOTE_ADDR'] == '92.113.85.176') {
          var_dump($parent); die;
        }*/
        $type['setting']['child_image_width'] = !empty($type['setting']['category_image_width']) ? $type['setting']['category_image_width'] : 50;
        $type['setting']['child_image_height'] = !empty($type['setting']['category_image_height']) ? $type['setting']['category_image_height'] : 50;
        $type['setting']['limit'] = !empty($type['setting']['category_limit']) ? (int)$type['setting']['category_limit'] : 0;
        $type['setting']['product_columns'] = !empty($type['setting']['category_columns']) ? $type['setting']['category_columns'] : array();
        $type['setting']['product_attributes'] = !empty($type['setting']['category_attributes']) ? $type['setting']['category_attributes'] : array();
        $type['setting']['replace_image'] = !empty($type['setting']['category_replace_image']) ? $type['setting']['category_replace_image'] : false;

        $childs = $this->model_extension_module_hpmodel->getChilds($parent['parent_id'], 0, $parent['type_id']);

        /*
        if ($parent['parent_id'] != $product_info['product_id']) {
            $product_info = $this->model_catalog_product->getProduct($parent['parent_id']);
        }
        */
        if (!empty($type['setting']['replace_image'])) {
            $image = $product_info['image'];
            if (!$image) $image = 'no_image.png';
            if (version_compare(VERSION, '3.0', '>=')) {
                $data['thumb'] = $this->model_tool_image->resize($image, $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_product_height'));
            } else {
                $data['thumb'] = $this->model_tool_image->resize($image, $this->config->get($this->config->get('config_theme') . '_image_product_width') ? $this->config->get($this->config->get('config_theme') . '_image_product_width') : $this->config->get('config_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height') ? $this->config->get($this->config->get('config_theme') . '_image_product_height') : $this->config->get('config_image_product_height'));
            }
        }

        $data['product_id'] = $product_info['product_id'];
        $data['title'] = !empty($type['setting']['category_title'][$language_id]) ? html_entity_decode($type['setting']['category_title'][$language_id], ENT_QUOTES, 'UTF-8') : '';
        $data['replace_h1'] = !empty($type['setting']['category_replace_h1']) ? $type['setting']['category_replace_h1'] : false;
        $data['replace_image'] = !empty($type['setting']['category_replace_image']) ? $type['setting']['category_replace_image'] : false;
        $data['model_id'] = $type['id'];
        $data['products'] = $this->prepareProducts($type['setting'], $childs);

        if(true or $product_info['product_id'] == 80137){
                $this->load->model('catalog/attribute');
                $data['attribute_info'] = array();
                if(isset($type['setting']['category_attributes'])){
                    foreach($type['setting']['category_attributes'] as $attribute_id){
                        $data['attribute_info'][(int)$attribute_id] = $this->model_catalog_attribute->getAttribute((int)$attribute_id);
                    }
                }
        
                
                $data['attribute_colors'] = array();
                $data['attribute_variants'] = array();
                $data['attribute_variants_key'] = array();
                foreach($data['products'] as $product){
                    
                    foreach($product['view'] as $index => $view){
                        $views = explode(';', trim($view, ';'));
                        foreach($views as $row){
                            $data['attribute_variants'][$index][$row] = $row;
                            $data['attribute_variants_key'][$index][$row] = md5($index.'_'.$row);
                            //$data['attribute_in_product'][$product['product_id']] .= ' '.md5($index.'_'.$row);
                            $data['attribute_in_product_nc'][$product['product_id']] .= ' '.md5($index.'_'.$row);
                        }
                    }
                    
                }
                
                
               foreach($data['attribute_variants'] as $index => $value){
                    sort($value);
                    $data['attribute_variants'][$index] = $value;
                    
                    if($index == "attribute-15"){
                        foreach($value as $row){
                            $color_info = $this->model_catalog_attribute->getColorInfo($row);
                            $color = explode(';',trim($color_info['color'], ';'));
                            $bg = '';	
                            if(count($color) > 1){
                                $gradient = array();
                                $step = (int)(100/count($color));
                                $count = 0;
                                
                                foreach($color as $col){
                                    $gradient[] = $col.' '.(($count++)*$step).'%';
                                    $gradient[] = $col.' '.(($count)*$step).'%';
                                }
                                $bg = 'style="background: linear-gradient(90deg, '.implode(',',$gradient).');"';
                            }else{
                                $bg = 'style="background-color:'.$color[0].';"';
                            }
                            $data['attribute_colors'][$row] = $bg;
                        }
                    }
                }
        
                if(isset($this->request->get['product_id']) AND (int)$this->request->get['product_id'] == 80137){
          
                }
        }
        
        
        if (count($data['products']) <= 1) return $product_info;

        if (floatval(VERSION) >= 2.2) {
            $product_info['hpm_block'] = $this->load->view('extension/module/hpmodel/category_block', $data);
            $product_info['model_id'] = $type['id'];
        } else {
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/extension/module/hpmodel/category_block.tpl')) {
                $product_info['hpm_block'] = $this->load->view($this->config->get('config_template') . '/template/extension/module/hpmodel/category_block.tpl', $data);
                $product_info['model_id'] = $type['id'];
            } else {
                $product_info['hpm_block'] = $this->load->view('default/template/extension/module/hpmodel/category_block.tpl', $data);
                $product_info['model_id'] = $type['id'];
            }
        }
        
        
        return $product_info;
    }


    public function get_product_data() {
        $json = array();

        $data_class = !empty($this->request->get['class']) ? explode('|', $this->request->get['class']) : array();
        $product_id = !empty($this->request->get['id']) ? $this->request->get['id'] : 0;

        if (!$product_id) return;

        if (in_array('option', $data_class)) {
            $data = array();

            $data['product_id'] = $product_id;
            $data['options'] = array();

            $this->load->model('catalog/product');
            $this->load->model('tool/image');

            foreach ($this->model_catalog_product->getProductOptions($product_id) as $option) {
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
                            'option_value_id'         => $option_value['option_value_id'],
                            'name'                    => $option_value['name'],
                            'image'                   => $option_value['image'] ? $this->model_tool_image->resize($option_value['image'], 50, 50) : '',
                            'price'                   => $price,
                            'price_prefix'            => $option_value['price_prefix']
                        );
                    }
                }

                $data['options'][] = array(
                    'product_option_id'    => $option['product_option_id'],
                    'product_option_value' => $product_option_value_data,
                    'option_id'            => $option['option_id'],
                    'name'                 => $option['name'],
                    'type'                 => $option['type'],
                    'value'                => $option['value'],
                    'required'             => $option['required']
                );
            }


            if (floatval(VERSION) >= 2.2) {
                $json['option'] = $this->load->view('extension/module/hpmodel/pd_option', $data);
            } else {
                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/extension/module/hpmodel/pd_option.tpl')) {
                    $json['option'] = $this->load->view($this->config->get('config_template') . '/template/extension/module/hpmodel/pd_option.tpl', $data);
                } else {
                    $json['option'] = $this->load->view('default/template/extension/module/hpmodel/pd_option.tpl', $data);
                }
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}
