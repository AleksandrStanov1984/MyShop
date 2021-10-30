<?php

class ControllerExtensionModuleFeatured extends Controller {
    public $setting;
    public function index($setting) {
           
              
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
                
                $s_height = $this->request->post['s_height'];
                $s_width = $this->request->post['s_width'];
                $s_length =$this->request->post['s_length'];
                $s_cat_id = $this->request->post['s_cat_id'];
		
                $results = $this->model_catalog_category->getCategories(20);
		foreach($results as $result){
		    $products = $this->model_catalog_product->getProducts1(array('filter_category_id'=>$result['category_id'],'start'=>0,'limit'=>1000,'sort'=>'p.sort_order' ));

           // obj_dump($products);
			
			$prods = array();
			
			foreach ($products as $product_id) {
				//obj_dump($product_id);
                            if (isset($setting['s_height']) && isset($setting['s_width']) && isset($setting['s_length']) && isset($setting['s_cat_id'])) {
                             
                            } elseif ($product_id['visible_carusel'] == 0) {
                         continue; 
         	 	}
				
				//obj_dump($product_id);
				$product_id = $product_id['product_id'];
				$product_info = $this->model_catalog_product->getProduct($product_id);

				if ($product_info) {

        $product_info = $this->load->controller('extension/module/hpmodel/hpmodel/getCategoryBlock', $product_info);
      
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

        'hpm_block' => !empty($product_info['hpm_block']) ? $product_info['hpm_block'] : '',
        
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
            'description' 		=> $result['description'],
			'aLength' 		=> array_unique($aLength),
			'aWidth' 		=> array_unique($aWidth),
			'aHeight' 		=> array_unique($aHeight),
			'products'    		=> $prods
 		    );


		}

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

        $product_info = $this->load->controller('extension/module/hpmodel/hpmodel/getCategoryBlock', $product_info);
      
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

        'hpm_block' => !empty($product_info['hpm_block']) ? $product_info['hpm_block'] : '',
        
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
     //obj_dump($data);
                
		if ($data['products']) {
			return $this->load->view('extension/module/featured', $data);
                        //             echo $this->load->view('extension/module/filerprods', $data);   
		}
                
	}
    
    
}