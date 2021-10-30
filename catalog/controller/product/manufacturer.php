<?php
class ControllerProductManufacturer extends Controller {
	public function index() {

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

                $this->load->controller('extension/analytics/ts_google_analytics/writeecommerce', array('products'=>$product_list, 'actionType'=>'view'));
            }
        }

		$this->response->redirect($this->url->link('common/home', '', true));
		
		$this->load->language('product/manufacturer');

		$this->load->model('catalog/manufacturer');

		$this->load->model('tool/image');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_index'] = $this->language->get('text_index');
		$data['text_empty'] = $this->language->get('text_empty');

		$data['button_continue'] = $this->language->get('button_continue');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_brand'),
			'href' => $this->url->link('product/manufacturer')
		);

		$data['categories'] = array();

		$results = $this->model_catalog_manufacturer->getManufacturers();

		foreach ($results as $result) {
			if (is_numeric(utf8_substr($result['name'], 0, 1))) {
				$key = '0 - 9';
			} else {
				$key = utf8_substr(utf8_strtoupper($result['name']), 0, 1);
			}

			if (!isset($data['categories'][$key])) {
				$data['categories'][$key]['name'] = $key;
			}

			$data['categories'][$key]['manufacturer'][] = array(
				'name' => $result['name'],
				'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'])
			);
		}

		$data['continue'] = $this->url->link('common/home');

		$data['microdata_breadcrumbs'] = $this->microdataBreadcrumbs($data['breadcrumbs']);

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('product/manufacturer_list', $data));
	}

	public function info() {

		$this->document->addStyle('catalog/view/theme/OPC080193_6/stylesheet/page_category.css?ver1.4');
		$this->document->addStyle('catalog/view/javascript/font-awesome/css/font-awesome-selected.min.css');
		$this->document->addScript('catalog/view/javascript/bootstrap/js/bootstrap.min.js');
		$this->document->addScript('catalog/view/theme/OPC080193_6/js/ajpag-fix.js?v=0.8');

		$data['is_mobile'] = $this->mobiledetectopencart->isMobile();

		$this->load->language('product/manufacturer');

		$this->load->model('catalog/manufacturer');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (isset($this->request->get['manufacturer_id'])) {
			$manufacturer_id = (int)$this->request->get['manufacturer_id'];
		} else {
			$manufacturer_id = 0;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = (int)$this->config->get($this->config->get('config_theme') . '_product_limit');
		}

		$data['limit_per_page'] = $limit;

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_brand'),
			'href' => $this->url->link('product/manufacturer')
		);

		$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);

		if ($manufacturer_info) {
			$this->document->setTitle($manufacturer_info['name']);

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

			$data['categ_url'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url);

			$data['breadcrumbs'][] = array(
				'text' => $manufacturer_info['name'],
				'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url)
			);

			$data['heading_title'] = $manufacturer_info['name'];

			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_quantity'] = $this->language->get('text_quantity');
			$data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_price'] = $this->language->get('text_price');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_points'] = $this->language->get('text_points');
			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
			$data['text_sort'] = $this->language->get('text_sort');
			$data['text_limit'] = $this->language->get('text_limit');

			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['button_list'] = $this->language->get('button_list');
			$data['button_grid'] = $this->language->get('button_grid');

			$data['compare'] = $this->url->link('product/compare');

			$data['products'] = array();

			$filter_data = array(
				'filter_manufacturer_id' => $manufacturer_id,
				'sort'                   => $sort,
				'order'                  => $order,
				'start'                  => ($page - 1) * $limit,
				'limit'                  => $limit
			);

			$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
				}
				
				//added for image swap
				
				$images = $this->model_catalog_product->getProductImages($result['product_id']);

				if(isset($images[0]['image']) && !empty($images)){
				 $images = $images[0]['image']; 
				   }else
				   {
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

				if (in_array($result['stock_status_id'], array(7,8))) {
					$stock_status = $this->language->get('text_instock');
				} else {
					$stock_status = $result['stock_status'];
				}

				// Stickers
				if($result['mpn']) {
					$stickers=explode(',', $result['mpn']);
				} else {
					$stickers= false;
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

				$data['products'][] = array(
						'in_stock' => (in_array($result['stock_status_id'], array(7,8))?1:0),
						'product_id'  => $result['product_id'],
						'date_added'  => $result['date_added'],
						'viewed'  => $result['viewed'],
						'thumb'       => $image,
						'thumb_swap'  => $this->model_tool_image->resize($images, $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height')),
						'name'        		=> $result['name'],
						'height'  =>    round($result['height'],0),
						'length'  =>   round($result['length'],0),
						'width'  =>   round($result['width'],0),
						'diameter_of_pot'  =>   round($result['diameter_of_pot'],0),
						'depth_of_pot'  =>   round($result['depth_of_pot'],0),
						'model'       => $result['model'],
						'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
						'price'       => $price,
						'incart'       => $incart,
						'wish'         => $wish_pd,
						'stickers' =>$stickers,
						'special'     => $special,
						'manufacturer' =>  $result['manufacturer'],
						'stock_status' =>$result['stock_status'],
						'tax'         => $tax,
						'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
						'rating'      => $result['rating'],
						'stock_status' =>$stock_status,
						'href'        => $this->url->link('product/product', 'manufacturer_id=' . $result['manufacturer_id'] . '&product_id=' . $result['product_id'] . $url)
				);
			}

			$url = '';

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$vars['microdata'] = $this->microdataProducts($vars['products']);

			$data['sorts'] = array();

			$data['sorts'][] = array(
    		'text'  => $this->language->get('text_views'),
    		'value' => 'p.viewed-DESC',
    		'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.viewed&order=DESC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=ASC' . $url)
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.price&order=DESC' . $url)
			);

			$data['sorts']['p.date_added-DESC'] = array(
				'text'  => $this->language->get('text_date_added'),
				'value' => 'p.date_added-DESC',
				'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . '&sort=p.date_added&order=DESC' . $url)
			);

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$data['limits'] = array();

			$limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url . '&limit=' . $value)
				);
			}

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] .  $url . '&page={page}');

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

			// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
			if ($page == 1) {
			    $this->document->addLink($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'], true), 'canonical');
			} elseif ($page == 2) {
			    $this->document->addLink($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'], true), 'prev');
			} else {
			    $this->document->addLink($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url . '&page='. ($page - 1), true), 'prev');
			}

			if ($limit && ceil($product_total / $limit) > $page) {
			    $this->document->addLink($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url . '&page='. ($page + 1), true), 'next');
			}

			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;

			$data['continue'] = $this->url->link('common/home');

			$data['microdata_breadcrumbs'] = $this->microdataBreadcrumbs($data['breadcrumbs']);

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$template = 'product/manufacturer_info';

      // Custom template module
      $this->load->model('setting/setting');

      $customer_group_id = $this->customer->getGroupId();

      if ($this->config->get('config_theme') == 'theme_default') {
          $directory = $this->config->get('theme_default_directory');
      } else {
          $directory = $this->config->get('config_theme');
      }

      $custom_template_module = $this->model_setting_setting->getSetting('custom_template_module');
      if(!empty($custom_template_module['custom_template_module'])){
          foreach ($custom_template_module['custom_template_module'] as $key => $module) {
              if (($module['type'] == 3) && !empty($module['manufacturers'])) {
                  if ((isset($module['customer_groups']) && in_array($customer_group_id, $module['customer_groups'])) || !isset($module['customer_groups']) || empty($module['customer_groups'])){

                      if (in_array($manufacturer_id, $module['manufacturers'])) {
                          if (file_exists(DIR_TEMPLATE . $directory . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . $module['template_name'] . '.tpl')) {
                              $template = $this->config->get('config_theme') .DIRECTORY_SEPARATOR. $module['template_name'];
                          }
                      }

                  } // customer groups

              }
          }
      }

      $template = str_replace('\\', '/', $template);

      $this->response->setOutput($this->load->view($template, $data));
      // Custom template module
		} else {
			$url = '';

			if (isset($this->request->get['manufacturer_id'])) {
				$url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
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
				'href' => $this->url->link('product/manufacturer/info', $url)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['header'] = $this->load->controller('common/header');
			$data['footer'] = $this->load->controller('common/footer');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
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
          'name'	=> $breadcrumb['text'],
          'item' => $breadcrumb['href']        
      );
      $i++;
    }
    
    
    $output = '<script type="application/ld+json">'.json_encode($json).'</script>'."\n";

    return $output;

  } 
  
}
