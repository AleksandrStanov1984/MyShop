<?php
class ControllerAccountWishList extends Controller {
	public function index() {
		$this->document->addStyle('catalog/view/theme/OPC080193_6/stylesheet/wishlist.css');
		$this->document->addStyle('catalog/view/theme/OPC080193_6/css/bootstrap-grid.min.css');
		$this->load->language('account/wishlist');

		$this->load->model('account/wishlist');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (isset($this->request->get['remove'])) {

			// Remove Wishlist
      if (!$this->customer->isLogged() && isset($this->session->data['wishlist'])) {
           $key = in_array($this->request->get['remove'], $this->session->data['wishlist']);
        	 $in_wishlist = $key && $key != false;
          if (($key = array_search($this->request->get['remove'], $this->session->data['wishlist'])) !== false) {
	            unset($this->session->data['wishlist'][$key]);
	        }
      } else {
          $this->model_account_wishlist->deleteWishlist($this->request->get['remove']);
      }


			$this->session->data['success'] = $this->language->get('text_remove');

			//$this->response->redirect($this->url->link('account/wishlist'));


		}

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		/*$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', true)
		);*/

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('account/wishlist')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_empty'] = $this->language->get('text_empty');

		$data['column_image'] = $this->language->get('column_image');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_stock'] = $this->language->get('column_stock');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_size']          = $this->language->get('column_size');
		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_cart'] = $this->language->get('button_cart');

              $data['button_wishlist'] = $this->language->get('button_wishlist');
              $data['button_inwishlist'] = $this->language->get('button_inwishlist');
              $data['button_cart_add'] = $this->language->get('button_cart_add');
              $data['button_incart'] = $this->language->get('button_incart');
            
		$data['button_remove'] = $this->language->get('button_remove');
		$data['unit_h'] = $this->language->get('unit_h');
    $data['unit_w'] = $this->language->get('unit_w');
    $data['unit_l'] = $this->language->get('unit_l');
    $data['unit'] = $this->language->get('unit');
		$data['text_btn_save_wishlist'] = $this->language->get('text_btn_save_wishlist');
		$data['info_save_wishlist'] = sprintf($this->language->get('info_save_wishlist'), $this->url->link('account/login'));
		$data['text_stock_out'] = $this->language->get('text_stock_out');
		$data['text_look_alike'] = $this->language->get('text_look_alike');
		$data['load_all_wishlist'] = $this->language->get('load_all_wishlist');
		$data['login_link'] = $this->url->link('account/login');


//var_dump($data['text-btn-save-wishlist']); die;
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['products'] = array();


    if (!$this->customer->isLogged() && isset($this->session->data['wishlist'])) {
        $results = $this->session->data['wishlist'];
        $data['loged'] = false;
    } else {
    		// Wishlist
				if (isset($this->session->data['wishlist']) && is_array($this->session->data['wishlist'])) {
					$this->load->model('account/wishlist');

					foreach ($this->session->data['wishlist'] as $key => $product_id) {
						$this->model_account_wishlist->addWishlist($product_id);

						unset($this->session->data['wishlist'][$key]);
					}
				}

    		$results = $this->model_account_wishlist->getWishlist();

    		$data['loged'] = true;
    }


		foreach ($results as $result) {

      if (!$this->customer->isLogged() && isset($this->session->data['wishlist'])) {
          $product_info = $this->model_catalog_product->getProduct($result);
      } else {
          $product_info = $this->model_catalog_product->getProduct($result['product_id']);
      }


			if ($product_info) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_wishlist_width'), $this->config->get($this->config->get('config_theme') . '_image_wishlist_height'));
				} else {
					$image = false;
				}
			/*$category_product = $this->model_catalog_product->getCategories($result);
			if ( $_SERVER['REMOTE_ADDR'] == '94.178.62.80') {
				var_dump($category_product); die;
			}*/
					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_wishlist_width'), $this->config->get($this->config->get('config_theme') . '_image_wishlist_height'));
					} else {
						$image = false;
					}


				if ($product_info['quantity'] <= 0) {
					$stock = $product_info['stock_status'];
				} elseif ($this->config->get('config_stock_display')) {
					$stock = $product_info['quantity'];
				} else {
					$stock = $this->language->get('text_instock');
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
				$category_products = $this->model_catalog_product->getGeneralCategorie($product_info['product_id']);
				if($category_products[0]['category_id']){
						$category_url = $this->url->link('product/category', 'path=' . $category_products[0]['category_id']);
				}else{
					$category_url = false;
				}

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
            
				$data['products'][] = array(
					'product_id' => $product_info['product_id'],
					'category_url' => $category_url,
				//	'category_id' => $this->url->link('product/category', 'path=' . $category_product['category_id']),
					'thumb'      => $image,
					'name'       => $product_info['name'],
					'model'      => $product_info['model'],
					'height'  =>    round($product_info['height'],0),
					'length'  =>   round($product_info['length'],0),
          'width'  =>   round($product_info['width'],0),
          'diameter_of_pot'  =>   round($product_info['diameter_of_pot'],0),
          'depth_of_pot'  =>   round($product_info['depth_of_pot'],0),
					'stock'      => $stock,
					'price'      => $price,

               'incart'       => $incart,
               'wish'         => $wish_pd,
            
					'special'    => $special,
					'quantity' 		=>  $product_info['quantity'],
					'href'       => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
					'remove'     => $this->url->link('account/wishlist', 'remove=' . $product_info['product_id'])
				);

			} else {

        if (!$this->customer->isLogged() && isset($this->session->data['wishlist'])) {
            for($i=0; $i<=count($this->session->data['wishlist']);$i++) {
                if($this->session->data['wishlist'][$i] == $this->request->get['remove']) unset($this->session->data['wishlist'][$i]);
            }
        } else {
            $this->model_account_wishlist->deleteWishlist($result['product_id']);
        }

			}
		}

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/wishlist', $data));
	}

	public function add() {
		$this->load->language('account/wishlist');

		$json = array();

		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');
		$this->load->model('account/wishlist');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		// Wishlist
    if ($this->customer->isLogged()) {
        $in_wishlist = $this->model_account_wishlist->hasWishlist($product_info['product_id']);
    } else {
        if(isset($this->session->data['wishlist'])) {
    			$key = in_array($product_info['product_id'], $this->session->data['wishlist']);
        	$in_wishlist = $key && $key != false;
    		} else {
    			$in_wishlist = false;
    		}
    }

    if ($product_info && !$in_wishlist) {
			if ($this->customer->isLogged()) {
				// Edit customers cart

				$this->model_account_wishlist->addWishlist($this->request->post['product_id']);

				$json['success'] = 'add';
				$json['success_message'] = $this->language->get('text_success_add');
				$json['text_total'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
				$json['total'] = $this->model_account_wishlist->getTotalWishlist();
			} else {
				if (!isset($this->session->data['wishlist'])) {
					$this->session->data['wishlist'] = array();
				}

				$this->session->data['wishlist'][] = $this->request->post['product_id'];

				$this->session->data['wishlist'] = array_unique($this->session->data['wishlist']);

				$json['success'] = 'add';
				$json['success_message'] = $this->language->get('text_success_add');
				$json['text_total'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
				$json['total'] = (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0);
			}
		} else {
        if (($key = array_search($product_id, $this->session->data['wishlist'])) !== false) {
            unset($this->session->data['wishlist'][$key]);
        }

        $this->model_account_wishlist->deleteWishlist($product_id);

        $json['success'] = 'remove';
        $json['success_message'] = $this->language->get('text_success_remove');
        if(!$this->customer->isLogged()) {
        	$json['text_total'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
					$json['total'] = (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0);
        } else {
        	$json['text_total'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
					$json['total'] = $this->model_account_wishlist->getTotalWishlist();
        }

    }

    $json['session'] = $this->session->data;
    $json['is_logged'] = (bool)$this->customer->isLogged();

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function get() {

		$json = array();

		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');
		$this->load->model('account/wishlist');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		// Wishlist
    if ($this->customer->isLogged()) {
        $json['in_wishlist'] = $this->model_account_wishlist->hasWishlist($product_info['product_id']);
    } else {
        if(isset($this->session->data['wishlist'])) {
    			$key = in_array($product_info['product_id'], $this->session->data['wishlist']);
        	$in_wishlist = $key && $key != false;
        	$json['in_wishlist'] = $in_wishlist;
    		} else {
    			$in_wishlist = false;
    		}
    }

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
