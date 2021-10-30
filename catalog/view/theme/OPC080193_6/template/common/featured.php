<?php

class ControllerExtensionModuleFeatured extends Controller {
    public $featured_settings = [];
    
    public function index($setting) {
                
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
		$data['text_max_min_weight'] = $this->language->get('text_max_min_weight');
        $data['text_max_min_weight_all'] = $this->language->get('text_max_min_weight_all');
		$data['off'] = $this->language->get('off');

		$this->load->model('catalog/product');
		$this->load->model('catalog/category');

		$this->load->model('tool/image');


		$data['categories'] = array();
                 
		$results = $this->model_catalog_category->getCategories(20);
		foreach($results as $result){
		    $products = $this->model_catalog_product->getProducts1(array('filter_category_id'=>$result['category_id'],'start'=>0,'limit'=>1000,'sort'=>'p.sort_order' ));

           
			
			$prods = array();
			
			foreach ($products as $product_id) {
			
                            if (isset($setting['s_height']) && isset($setting['s_width']) && isset($setting['s_length']) && isset($setting['s_cat_id'])) {
                             
                            } elseif ($product_id['visible_carusel'] == 0) {
                         continue; 
         	 	}
			
				$product_id = $product_id['product_id'];
				$product_info = $this->model_catalog_product->getProduct($product_id);

				if ($product_info) {
					if ($product_info['image']) {
                                             
						$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}
				//added for image swap

				$images = $this->model_catalog_product->getProductImages($product_info['product_id']);

				if(isset($images[0]['image']) && !empty($images)){
				 $images = $images[0]['image'];
				   }else
				   {
				   $images = $image;
				   }

				//
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
						'product_id'  => $product_info['product_id'],
						'thumb'       => $image,
											'thumb_swap'  => $this->model_tool_image->resize($images, $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height')),
						'name'        => $product_info['name'],
						'model'       => $product_info['model'],
						'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'height' => $product_info['height'],
						'width' => $product_info['width'],
						'length' => $product_info['length'],
						'quantity_shelves' => $product_info['quantity_shelves'],
						'maximum_weight' => $product_info['maximum_weight'],
                        'maximum_weight_all' => $product_info['maximum_weight_all'],
						'color_shelves' => $product_info['color_shelves'],
						'location' => $product_info['location'],
						'quantity'    => $product_info['quantity'],
						'tax'         => $tax,
						'rating'      => $rating,
						'height'  =>    round($product_info['height'],0),
						'length'  =>   round($product_info['length'],0),
						'width'  =>   round($product_info['width'],0),

						'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
					);
				}
			}
			
            $aLength = array();
			$aWidth = array();
			$aHeight = array();
			
			foreach ($products as $product_id) { 
			
			$aLength[] .= $product_id['length'];
			$aWidth[] .= $product_id['width'];
			$aHeight[] .= $product_id['height'];
			
            }		
            
            asort($aLength);
			asort($aWidth);
			asort($aHeight);

		    //print_r($products);
		    $data['categories'][] = array(
			'category_id' 		=> $result['category_id'],
			'name'        		=> $result['name'],
            'series_name' 		=> $result['series_name'],
            'additional_input'  => $result['additional_input'],
            'additional_input2'  => $result['additional_input2'],
            'description' 		=> $result['description'],
			'aLength' 		=> array_unique($aLength),
			'aWidth' 		=> array_unique($aWidth),
			'aHeight' 		=> array_unique($aHeight),
			'products'    		=> $prods
 		    );
		}
//        $first_real = [];
//        $data['select_data_first'] = array();
//        foreach ($data['categories'] as $cat_data) {
//         
//          $sql = " SELECT  height,  width,  length  FROM oc_product WHERE  category_id = '" . $cat_data['category_id'] . "' AND  status = 1  GROUP BY category_id ORDER BY height ASC, width ASC, length ASC ";
//          $query = $this->db->query($sql);
//
//        foreach ($query->rows as $item){
//            $select_data[$item['product_id']] = array(
//                'height' => $item['height'],
//                'width' => $item['width'],
//                'length' => $item['length']
//            );
//        }
//          $first_real[] .= array_shift($select_data);
//          
//        }
//        $data['select_data_first'] .= $first_real;
        
         //$first_real = array_shift($products);
		//print_r($data);

       
		 
		$data['products'] = array();
		$data['text_home_products'] = $this->language->get('text_home_products');

		$data['text_trigger1'] = $this->language->get('text_trigger1');
		$data['text_trigger2'] = $this->language->get('text_trigger2');
		$data['text_trigger3'] = $this->language->get('text_trigger3');
		$data['text_buy'] = $this->language->get('text_buy');


		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}
		//print_r($setting);
		$data['setting_name'] = $setting['name'];

		if (!empty($setting['product'])) {
			$products = array_slice($setting['product'], 0, (int)$setting['limit']);

			foreach ($products as $product_id) {
				
				$product_info = $this->model_catalog_product->getProduct($product_id);

				if ($product_info) {
					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}
				//added for image swap

				$images = $this->model_catalog_product->getProductImages($product_info['product_id']);

				if(isset($images[0]['image']) && !empty($images)){
				 $images = $images[0]['image'];
				   }else
				   {
				   $images = $image;
				   }

				//
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


					$data['products'][] = array(
						'product_id'  => $product_info['product_id'],
						'thumb'       => $image,
						'thumb_swap'  => $this->model_tool_image->resize($images, $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height')),
						'name'        => $product_info['name'],
						'model'        => $product_info['model'],
						'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'quantity'    => $product_info['quantity'],
						'tax'         => $tax,
						'rating'      => $rating,
						'height'  =>    round($product_info['height'],0),
						'length'  =>   round($product_info['length'],0),
						'width'  =>   round($product_info['width'],0),
						
						'quantity_shelves'  => $product_info['quantity_shelves'],
						'maximum_weight'  => $product_info['maximum_weight'],
                        'maximum_weight_all'  => $product_info['maximum_weight_all'],
						'color_shelves'  => $product_info['color_shelves'],
						
						
						'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
					);
				}
			}
		}

                    $data['view_setting'] = $this->featured_settings;
                   
		if ($data['products']) {
			return $this->load->view('extension/module/featured', $data);
		}
                
	}
    public function getProds() { 
        $setting = [];
        $query = $this->db->query("SELECT settings FROM " . DB_PREFIX . "ajax WHERE id = '1'" );
      //  require_once($_SERVER['DOCUMENT_ROOT'] . '/dump.php' ); //for debug only 
        foreach ($query->rows as $result) {
         $setting = $result['settings'];
        }
        if(isset($setting)) { 
           $setting = unserialize($result['settings']);
        }
        
        // obj_dump($setting);
        $s_height = $this->request->post['s_height'];
        $s_width = $this->request->post['s_width'];
        $s_length =$this->request->post['s_length'];
        $s_cat_id = $this->request->post['s_cat_id']; 
             

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

		$this->load->model('catalog/product');
		$this->load->model('catalog/category');

		$this->load->model('tool/image');


		$data['categories'] = array();

		    $products = $this->model_catalog_product->getProducts1(array('filter_category_id'=>$s_cat_id ,'start'=>0,'limit'=>1000,'sort'=>'p.sort_order', 'height'=>$s_height, 'width'=>$s_width, 'length' =>$s_length));

                    
			
			$prods = array();
			
			foreach ($products as $product_id) {
			
                            			
				$product_id = $product_id['product_id'];
				$product_info = $this->model_catalog_product->getProduct($product_id);

				if ($product_info) {
					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}
				//added for image swap

				$images = $this->model_catalog_product->getProductImages($product_info['product_id']);

				if(isset($images[0]['image']) && !empty($images)){
				 $images = $images[0]['image'];
				   }else
				   {
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
						'product_id'  => $product_info['product_id'],
						'thumb'       => $image,
						'thumb_swap'  => $this->model_tool_image->resize($images, $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height')),
						'name'        => $product_info['name'],
						'model'       => $product_info['model'],
						'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'height' => $product_info['height'],
						'width' => $product_info['width'],
						'length' => $product_info['length'],
						'quantity_shelves' => $product_info['quantity_shelves'],
						'maximum_weight' => $product_info['maximum_weight'],
                        'maximum_weight_all' => $product_info['maximum_weight_all'],
						'color_shelves' => $product_info['color_shelves'],
						'location' => $product_info['location'],
						'quantity'    => $product_info['quantity'],
						'tax'         => $tax,
						'rating'      => $rating,
						'height'  =>    round($product_info['height'],0),
						'length'  =>   round($product_info['length'],0),
						'width'  =>   round($product_info['width'],0),

						'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
					);
				}
			}


		    //print_r($products);
		    $data['categories'][] = array(
			'category_id' 		=> $s_cat_id ,
	
			'products'    		=> $prods
 		    );
		
       
		 
		$data['products'] = array();
		$data['text_home_products'] = $this->language->get('text_home_products');

		$data['text_trigger1'] = $this->language->get('text_trigger1');
		$data['text_trigger2'] = $this->language->get('text_trigger2');
		$data['text_trigger3'] = $this->language->get('text_trigger3');
		$data['text_buy'] = $this->language->get('text_buy');


		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}
		//print_r($setting);
		$data['setting_name'] = $setting['name'];

		if (!empty($setting['product'])) {
			$products = array_slice($setting['product'], 0, (int)$setting['limit']);

			foreach ($products as $product_id) {
				
				$product_info = $this->model_catalog_product->getProduct($product_id);

				if ($product_info) {
					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}
				//added for image swap

				//$images = $this->model_catalog_product->getProductImages($product_info['product_id']);

				if(isset($images[0]['image']) && !empty($images)){
				 $images = $images[0]['image'];
				   }else
				   {
				   $images = $image;
				   }

				//
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


					$data['products'][] = array(
						'product_id'  => $product_info['product_id'],
						'thumb'       => $image,
						'thumb_swap'  => $this->model_tool_image->resize($images, $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height')),
						'name'        => $product_info['name'],
						'model'        => $product_info['model'],
						'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'quantity'    => $product_info['quantity'],
						'tax'         => $tax,
						'rating'      => $rating,
						'height'  =>    round($product_info['height'],0),
						'length'  =>   round($product_info['length'],0),
						'width'  =>   round($product_info['width'],0),
						
						'quantity_shelves'  => $product_info['quantity_shelves'],
						'maximum_weight'  => $product_info['maximum_weight'],
                        'maximum_weight_all'  => $product_info['maximum_weight_all'],
						'color_shelves'  => $product_info['color_shelves'],
						
						
						'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
					);
				}
			}
		}
               $data['test'] = $s_length;
               $this->response->setOutput($this->load->view('extension/module/filterprod', $data)); 
             
      

    }
    
     public function getAsizes() { 
       
        $Reset = $this->request->post['sd_reset']; 
        if ($Reset == 0) {
        $sd_cat_id = $this->request->post['sd_cat_id']; 
        $sd_value = $this->request->post['sd_value'];
        $ParamHWL = $this->request->post['sd_param'];
        
        $_SESSION['selector_category'] = $sd_cat_id; 
        switch ($ParamHWL) {
    case 'height':
        $_SESSION['selector_height'] = 'height';
        break;
    case 'width':
         $_SESSION['selector_width'] = 'width';
        break;
    case 'length':
        $_SESSION['selector_length'] = 'length';
        break;
    }         
        

        

         $Query_add = $ParamHWL . " = " . (int)$sd_value ;
  
     
        if ($Query_add) {
        $sql = " SELECT product_id,  height,  width,  length  FROM oc_product WHERE  " . $Query_add . " AND  status = 1  GROUP BY product_id ORDER BY height ASC, width ASC, length ASC ";


		$query = $this->db->query($sql);
        
        $select_data = array();
        foreach ($query->rows as $item){
            $select_data[$item['product_id']] = array(
                'height' => $item['height'],
                'width' => $item['width'],
                'length' => $item['length']
            );
        }
        $first_real = [];
        $first_real = array_shift($select_data); 

        $aLength = array();
        $aWidth = array();
        $aHeight = array();
     	foreach ($select_data as $data) {

			$aHeight[] .= $data['height'];
			$aWidth[] .= $data['width'];
			$aLength[] .= $data['length'];
        }
            asort($aLength);
			asort($aWidth);
			asort($aHeight);


       $json_data = array (
           'first_real_h' => $first_real['height'],
           'first_real_w' => $first_real['width'],
           'first_real_h' => $first_real['height'],
           'aHeight' => array_unique($aHeight),
           'aWidth' => array_unique($aWidth),
           'aLength' => array_unique($aLength),
           );
  
       //$this->response->setOutput($this->load->view('extension/module/filterselect', $data)); 
       echo json_encode($json_data);
       }
    } else {
      
      unset($_SESSION['selector_category']);
      unset($_SESSION['selector_height']);
      unset($_SESSION['selector_width']);
      unset($_SESSION['selector_length']);
      $json_data = array (
           'reset_answer' => 'passed');
          
      echo json_encode($json_data);
    }
  }
}