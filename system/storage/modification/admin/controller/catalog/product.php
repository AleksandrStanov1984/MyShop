<?php
class ControllerCatalogProduct extends Controller {

	public function filter() {
		if ((int)$this->config->get('aqe_status') && (int)$this->config->get('aqe_catalog_products_status')) {
			return $this->load->controller('catalog/aqe/product/filter');
		} else {
			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}
	}

	public function category() {
		if ((int)$this->config->get('aqe_status') && (int)$this->config->get('aqe_catalog_products_status')) {
			return $this->load->controller('catalog/aqe/product/category');
		} else {
			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}
	}

	public function load_popup() {
		if ((int)$this->config->get('aqe_status') && (int)$this->config->get('aqe_catalog_products_status')) {
			return $this->load->controller('catalog/aqe/product/load_popup');
		} else {
			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}
	}

	public function refresh_data() {
		if ((int)$this->config->get('aqe_status') && (int)$this->config->get('aqe_catalog_products_status')) {
			return $this->load->controller('catalog/aqe/product/refresh_data');
		} else {
			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}
	}

	public function quick_update() {
		if ((int)$this->config->get('aqe_status') && (int)$this->config->get('aqe_catalog_products_status')) {
			return $this->load->controller('catalog/aqe/product/quick_update');
		} else {
			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}
	}
			
	private $error = array();

	public function index() {

		if ((int)$this->config->get('aqe_status') && (int)$this->config->get('aqe_catalog_products_status')) {
			return $this->load->controller('catalog/aqe/product');
		}
			
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		$this->getList();
	}
	public function getAttributeValue($attribute_id) {
		
		$this->load->model('catalog/product');
		$product_attributes = $this->model_catalog_product->getAllProductAttributes($attribute_id);
		
		return $product_attributes;
		
	}
	public function add() {
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_product->addProduct($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

                if (isset($this->request->get['filter_manufacturer'])) {
                    $url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
                }
                if (isset($this->request->get['filter_sku'])) {
                    $url .= '&filter_sku=' . $this->request->get['filter_sku'];
                }
                if (isset($this->request->get['filter_attribute'])) {
                    $url .= '&filter_attribute=' . $this->request->get['filter_attribute'];
                }
        

			if ($this->config->get('module_catalog_quick_edit_status') && $this->config->get('module_catalog_quick_edit_catalog_products_status')) {
	      foreach ($this->config->get('module_catalog_quick_edit_catalog_products') as $column => $attr) {
	        if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
	          $url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
	        }
	      }
	      if (isset($this->request->get['filter_sub_category'])) {
	        $url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
	      }
	    }


		if ($this->config->get('aqe_status') && $this->config->get('aqe_catalog_products_status')) {
			foreach ($this->config->get('aqe_catalog_products') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
			}
		}
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . urlencode(html_entity_decode($this->request->get['filter_price'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . urlencode(html_entity_decode($this->request->get['filter_quantity'], ENT_QUOTES, 'UTF-8'));
			}

      if (isset($this->request->get['filter_category'])) {
        $url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
      }

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . urlencode(html_entity_decode($this->request->get['sort'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . urlencode(html_entity_decode($this->request->get['order'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . urlencode(html_entity_decode($this->request->get['page'], ENT_QUOTES, 'UTF-8'));
			}

			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_product->editProduct($this->request->get['product_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

                if (isset($this->request->get['filter_manufacturer'])) {
                    $url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
                }
                if (isset($this->request->get['filter_sku'])) {
                    $url .= '&filter_sku=' . $this->request->get['filter_sku'];
                }
                if (isset($this->request->get['filter_attribute'])) {
                    $url .= '&filter_attribute=' . $this->request->get['filter_attribute'];
                }
        

			if ($this->config->get('module_catalog_quick_edit_status') && $this->config->get('module_catalog_quick_edit_catalog_products_status')) {
	      foreach ($this->config->get('module_catalog_quick_edit_catalog_products') as $column => $attr) {
	        if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
	          $url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
	        }
	      }
	      if (isset($this->request->get['filter_sub_category'])) {
	        $url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
	      }
	    }


		if ($this->config->get('aqe_status') && $this->config->get('aqe_catalog_products_status')) {
			foreach ($this->config->get('aqe_catalog_products') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
			}
		}
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . urlencode(html_entity_decode($this->request->get['filter_price'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . urlencode(html_entity_decode($this->request->get['filter_quantity'], ENT_QUOTES, 'UTF-8'));
			}

      if (isset($this->request->get['filter_category'])) {
        $url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
      }

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . urlencode(html_entity_decode($this->request->get['sort'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . urlencode(html_entity_decode($this->request->get['order'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . urlencode(html_entity_decode($this->request->get['page'], ENT_QUOTES, 'UTF-8'));
			}

			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {

		if ((int)$this->config->get('aqe_status') && (int)$this->config->get('aqe_catalog_products_status')) {
			return $this->load->controller('catalog/aqe/product/delete');
		}
			
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_catalog_product->deleteProduct($product_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

                if (isset($this->request->get['filter_manufacturer'])) {
                    $url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
                }
                if (isset($this->request->get['filter_sku'])) {
                    $url .= '&filter_sku=' . $this->request->get['filter_sku'];
                }
                if (isset($this->request->get['filter_attribute'])) {
                    $url .= '&filter_attribute=' . $this->request->get['filter_attribute'];
                }
        

			if ($this->config->get('module_catalog_quick_edit_status') && $this->config->get('module_catalog_quick_edit_catalog_products_status')) {
	      foreach ($this->config->get('module_catalog_quick_edit_catalog_products') as $column => $attr) {
	        if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
	          $url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
	        }
	      }
	      if (isset($this->request->get['filter_sub_category'])) {
	        $url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
	      }
	    }


		if ($this->config->get('aqe_status') && $this->config->get('aqe_catalog_products_status')) {
			foreach ($this->config->get('aqe_catalog_products') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
			}
		}
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . urlencode(html_entity_decode($this->request->get['filter_price'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . urlencode(html_entity_decode($this->request->get['filter_quantity'], ENT_QUOTES, 'UTF-8'));
			}

      if (isset($this->request->get['filter_category'])) {
        $url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
      }

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . urlencode(html_entity_decode($this->request->get['sort'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . urlencode(html_entity_decode($this->request->get['order'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . urlencode(html_entity_decode($this->request->get['page'], ENT_QUOTES, 'UTF-8'));
			}

			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	public function copy() {

		if ((int)$this->config->get('aqe_status') && (int)$this->config->get('aqe_catalog_products_status')) {
			return $this->load->controller('catalog/aqe/product/copy');
		}
			
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_catalog_product->copyProduct($product_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

                if (isset($this->request->get['filter_manufacturer'])) {
                    $url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
                }
                if (isset($this->request->get['filter_sku'])) {
                    $url .= '&filter_sku=' . $this->request->get['filter_sku'];
                }
                if (isset($this->request->get['filter_attribute'])) {
                    $url .= '&filter_attribute=' . $this->request->get['filter_attribute'];
                }
        

			if ($this->config->get('module_catalog_quick_edit_status') && $this->config->get('module_catalog_quick_edit_catalog_products_status')) {
	      foreach ($this->config->get('module_catalog_quick_edit_catalog_products') as $column => $attr) {
	        if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
	          $url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
	        }
	      }
	      if (isset($this->request->get['filter_sub_category'])) {
	        $url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
	      }
	    }


		if ($this->config->get('aqe_status') && $this->config->get('aqe_catalog_products_status')) {
			foreach ($this->config->get('aqe_catalog_products') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
			}
		}
			
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . urlencode(html_entity_decode($this->request->get['filter_price'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . urlencode(html_entity_decode($this->request->get['filter_quantity'], ENT_QUOTES, 'UTF-8'));
			}

      if (isset($this->request->get['filter_category'])) {
        $url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
      }

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . urlencode(html_entity_decode($this->request->get['sort'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . urlencode(html_entity_decode($this->request->get['order'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . urlencode(html_entity_decode($this->request->get['page'], ENT_QUOTES, 'UTF-8'));
			}

			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {

      	$this->load->model('catalog/category');

      	$filter_data = array(
			'sort'        => 'name',
			'order'       => 'ASC'
		);

      	$data['categories'] = $this->model_catalog_category->getCategories($filter_data);
      
                
                if (isset($this->request->get['filter_manufacturer'])) {
                    $filter_manufacturer = $this->request->get['filter_manufacturer'];
                } else {
                    $filter_manufacturer = NULL;
                }
                if (isset($this->request->get['filter_sku'])) {
                    $filter_sku = $this->request->get['filter_sku'];
                } else {
                    $filter_sku = NULL;
                }
                if (isset($this->request->get['filter_attribute'])) {
                    $filter_attribute = $this->request->get['filter_attribute'];
                } else {
                    $filter_attribute = NULL;
                }
        
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = null;
		}

		if (isset($this->request->get['filter_price'])) {
			$filter_price = $this->request->get['filter_price'];
		} else {
			$filter_price = null;
		}

		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = $this->request->get['filter_quantity'];
		} else {
			$filter_quantity = null;
		}

		if (isset($this->request->get['filter_category'])) {
			$filter_category = $this->request->get['filter_category'];
		} else {
			$filter_category = NULL;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['filter_image'])) {
			$filter_image = $this->request->get['filter_image'];
		} else {
			$filter_image = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.product_id'; // customized
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC'; // customized
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

                if (isset($this->request->get['filter_manufacturer'])) {
                    $url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
                }
                if (isset($this->request->get['filter_sku'])) {
                    $url .= '&filter_sku=' . $this->request->get['filter_sku'];
                }
                if (isset($this->request->get['filter_attribute'])) {
                    $url .= '&filter_attribute=' . $this->request->get['filter_attribute'];
                }
        

		if ($this->config->get('module_catalog_quick_edit_status') && $this->config->get('module_catalog_quick_edit_catalog_products_status')) {
	      foreach ($this->config->get('module_catalog_quick_edit_catalog_products') as $column => $attr) {
	        if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
	          $url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
	        }
	      }
	      if (isset($this->request->get['filter_sub_category'])) {
	        $url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
	      }
	    }


		if ($this->config->get('aqe_status') && $this->config->get('aqe_catalog_products_status')) {
			foreach ($this->config->get('aqe_catalog_products') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
			}
		}
			
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . urlencode(html_entity_decode($this->request->get['filter_price'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . urlencode(html_entity_decode($this->request->get['filter_quantity'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . urlencode(html_entity_decode($this->request->get['filter_image'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . urlencode(html_entity_decode($this->request->get['sort'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . urlencode(html_entity_decode($this->request->get['order'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . urlencode(html_entity_decode($this->request->get['page'], ENT_QUOTES, 'UTF-8'));
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/product/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['copy'] = $this->url->link('catalog/product/copy', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/product/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['products'] = array();

		$filter_data = array(

                'filter_manufacturer'   => $filter_manufacturer,
                'filter_sku'            => $filter_sku,
                'filter_attribute'      => $filter_attribute,
        
			'filter_name'     => $filter_name,

                'filter_sku' => $filter_sku,
        
			'filter_model'	  => $filter_model,
			'filter_price'	  => $filter_price,
			'filter_quantity' => $filter_quantity,
            'filter_category' => $filter_category,
			'filter_status'   => $filter_status,
			'filter_image'    => $filter_image,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

		$results = $this->model_catalog_product->getProducts($filter_data);

		$this->load->model('catalog/category');

		$filter_data = array(
			'sort'        => 'name',
			'order'       => 'ASC'
		);

		$data['categories'] = $this->model_catalog_category->getCategories($filter_data);


                $this->load->model('catalog/manufacturer');
                $data['manufacturers'][] = array(
                        'manufacturer_id' => '0',
                        'name' => $this->language->get('select_no_manufacturers'),
                        'sort_order' => '0'

                );
                $data['manufacturers'] = array_merge($data['manufacturers'], $this->model_catalog_manufacturer->getManufacturers($filter_data));

                $this->load->model('catalog/attribute');
                $results_attr = $this->model_catalog_attribute->getAttributes($filter_data);
                $data['fattributes']= array();
                foreach($results_attr as $result) {
                    $data['fattributes'][] = array(
                            'attribute_id' => $result['attribute_id'],
                            'name' => $result['name']
                    );
                }

        
		foreach ($results as $result) {

      $category =  $this->model_catalog_product->getProductCategories($result['product_id']);

			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}

			$special = false;

			$product_specials = $this->model_catalog_product->getProductSpecials($result['product_id']);

			foreach ($product_specials  as $product_special) {
				if (($product_special['date_start'] == '0000-00-00' || strtotime($product_special['date_start']) < time()) && ($product_special['date_end'] == '0000-00-00' || strtotime($product_special['date_end']) > time())) {
					$special = $product_special['price'];

					break;
				}
			}

			$data['products'][] = array(
				'product_id'   => $result['product_id'],
				'image'        => $image,
				'name'         => $result['name'],
				'sort_search'  => $result['sort_search'],
				'sort_order'   => $result['sort_order'],
				'model'        => $result['model'],
				'price'        => $result['price'],
                'price_base'   => $result['price_base'],
				'category'     => $category,
				'special'      => $special,
				'quantity'     => $result['quantity'],
				'status'       => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'         => $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');


      	$data['smallproductseditor_action'] = $this->language->get('smallproductseditor_action');
      	$data['smallproductseditor_action_active'] = $this->language->get('smallproductseditor_action_active');
      	$data['smallproductseditor_action_deactive'] = $this->language->get('smallproductseditor_action_deactive');
      	$data['smallproductseditor_action_move'] = $this->language->get('smallproductseditor_action_move');
      	$data['smallproductseditor_action_copy'] = $this->language->get('smallproductseditor_action_copy');
      	$data['smallproductseditor_action_price'] = $this->language->get('smallproductseditor_action_price');
      	$data['smallproductseditor_button'] = $this->language->get('smallproductseditor_button');
      	$data['smallproductseditor_success'] = $this->language->get('smallproductseditor_success');
      
		$data['text_list'] = $this->language->get('text_list');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_image'] = $this->language->get('column_image');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_category'] = $this->language->get('column_category');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');

                $data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
                $data['entry_attributes'] = $this->language->get('entry_attributes');
                $data['entry_sku'] = $this->language->get('entry_sku');
                $data['select_no_manufacturers'] = $this->language->get('select_no_manufacturers');
        
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_price'] = $this->language->get('entry_price');
        $data['entry_price_base'] = $this->language->get('entry_price_base');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_status'] = $this->language->get('entry_status');

                $data['entry_material_shelves'] = $this->language->get('entry_material_shelves');
								$data['entry_model_selection'] = $this->language->get('entry_model_selection');
								$data['entry_quantity_shelves'] = $this->language->get('entry_quantity_shelves');
								$data['entry_maximum_weight'] = $this->language->get('entry_maximum_weight');
						        $data['entry_maximum_weight_all'] = $this->language->get('entry_maximum_weight_all');
								$data['entry_color_shelves'] = $this->language->get('entry_color_shelves');
								$data['entry_metal_thickness'] = $this->language->get('entry_metal_thickness');
								$data['entry_type'] = $this->language->get('entry_type');
								$data['entry_series'] = $this->language->get('entry_series');
								$data['entry_brand'] = $this->language->get('entry_brand');
            
		$data['entry_image'] = $this->language->get('entry_image');

		$data['button_copy'] = $this->language->get('button_copy');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

                if (isset($this->request->get['filter_manufacturer'])) {
                    $url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
                }
                if (isset($this->request->get['filter_sku'])) {
                    $url .= '&filter_sku=' . $this->request->get['filter_sku'];
                }
                if (isset($this->request->get['filter_attribute'])) {
                    $url .= '&filter_attribute=' . $this->request->get['filter_attribute'];
                }
        

		if ($this->config->get('module_catalog_quick_edit_status') && $this->config->get('module_catalog_quick_edit_catalog_products_status')) {
	      foreach ($this->config->get('module_catalog_quick_edit_catalog_products') as $column => $attr) {
	        if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
	          $url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
	        }
	      }
	      if (isset($this->request->get['filter_sub_category'])) {
	        $url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
	      }
	    }


		if ($this->config->get('aqe_status') && $this->config->get('aqe_catalog_products_status')) {
			foreach ($this->config->get('aqe_catalog_products') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
			}
		}
			
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . urlencode(html_entity_decode($this->request->get['filter_price'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . urlencode(html_entity_decode($this->request->get['filter_quantity'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category'])) {
      $url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
    }

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . urlencode(html_entity_decode($this->request->get['filter_image'], ENT_QUOTES, 'UTF-8'));
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . urlencode(html_entity_decode($this->request->get['page'], ENT_QUOTES, 'UTF-8'));
		}

		$data['sort_name'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, true);
		$data['sort_search'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.sort_search' . $url, true);
		$data['sort_model'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, true);
		$data['sort_price'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, true);
		$data['sort_quantity'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, true);
		$data['sort_status'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, true);
		$data['sort_order'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, true);

		$url = '';

                if (isset($this->request->get['filter_manufacturer'])) {
                    $url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
                }
                if (isset($this->request->get['filter_sku'])) {
                    $url .= '&filter_sku=' . $this->request->get['filter_sku'];
                }
                if (isset($this->request->get['filter_attribute'])) {
                    $url .= '&filter_attribute=' . $this->request->get['filter_attribute'];
                }
        

		if ($this->config->get('module_catalog_quick_edit_status') && $this->config->get('module_catalog_quick_edit_catalog_products_status')) {
	      foreach ($this->config->get('module_catalog_quick_edit_catalog_products') as $column => $attr) {
	        if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
	          $url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
	        }
	      }
	      if (isset($this->request->get['filter_sub_category'])) {
	        $url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
	      }
	    }


		if ($this->config->get('aqe_status') && $this->config->get('aqe_catalog_products_status')) {
			foreach ($this->config->get('aqe_catalog_products') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
			}
		}
			
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . urlencode(html_entity_decode($this->request->get['filter_price'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . urlencode(html_entity_decode($this->request->get['filter_quantity'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . urlencode(html_entity_decode($this->request->get['filter_image'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . urlencode(html_entity_decode($this->request->get['sort'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . urlencode(html_entity_decode($this->request->get['order'], ENT_QUOTES, 'UTF-8'));
		}

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;

                $data['filter_manufacturer'] = $filter_manufacturer;
                $data['filter_sku'] = $filter_sku;
                $data['filter_attribute'] = $filter_attribute;
        
		$data['filter_model'] = $filter_model;
		$data['filter_price'] = $filter_price;
		$data['filter_quantity'] = $filter_quantity;
		$data['filter_category'] = $filter_category;
		$data['filter_status'] = $filter_status;
		$data['filter_image'] = $filter_image;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
                $data['user_group'] = $this->user->getGroupId();
		$this->response->setOutput($this->load->view('catalog/product_list', $data));
	}

	protected function getForm() {

	 // OCFilter start
         $this->document->addStyle('view/stylesheet/ocfilter/ocfilter.css?ver1.1');
         $this->document->addScript('view/javascript/ocfilter/ocfilter.js?ver1.1');
     // OCFilter end

    //CKEditor
    if ($this->config->get('config_editor_default')) {
        $this->document->addScript('view/javascript/ckeditor/ckeditor.js');
        $this->document->addScript('view/javascript/ckeditor/ckeditor_init.js');
    } else {
        $this->document->addScript('view/javascript/summernote/summernote.js');
        $this->document->addScript('view/javascript/summernote/lang/summernote-' . $this->language->get('lang') . '.js');
        $this->document->addScript('view/javascript/summernote/opencart.js');
        $this->document->addStyle('view/javascript/summernote/summernote.css');
    }

		$data['heading_title'] = $this->language->get('heading_title');
		$data['config_language_id'] = $this->config->get('config_language_id');
		$data['text_form'] = !isset($this->request->get['product_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_plus'] = $this->language->get('text_plus');
		$data['text_minus'] = $this->language->get('text_minus');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_option'] = $this->language->get('text_option');
		$data['text_option_value'] = $this->language->get('text_option_value');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_percent'] = $this->language->get('text_percent');
		$data['text_amount'] = $this->language->get('text_amount');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_h1'] = $this->language->get('entry_meta_h1');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_sku'] = $this->language->get('entry_sku');
		$data['entry_upc'] = $this->language->get('entry_upc');
		$data['entry_ean'] = $this->language->get('entry_ean');
		$data['entry_jan'] = $this->language->get('entry_jan');
		$data['entry_isbn'] = $this->language->get('entry_isbn');
		$data['entry_video_title'] = $this->language->get('entry_video_title');
    $data['entry_video_link'] = $this->language->get('entry_video_link');
    $data['tab_video'] = $this->language->get('tab_video');
    $data['help_video'] = $this->language->get('help_video');
    $data['button_video_add'] = $this->language->get('button_video_add');
    $data['entry_video'] = $this->language->get('entry_video');
    $data['help_video'] = $this->language->get('help_video');
		$data['entry_mpn'] = $this->language->get('entry_mpn');
		$data['entry_location'] = $this->language->get('entry_location');
		$data['entry_minimum'] = $this->language->get('entry_minimum');
		$data['entry_shipping'] = $this->language->get('entry_shipping');
		$data['entry_visible_carusel'] = $this->language->get('entry_visible_carusel');
		$data['entry_date_available'] = $this->language->get('entry_date_available');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_stock_status'] = $this->language->get('entry_stock_status');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_points'] = $this->language->get('entry_points');
		$data['entry_option_points'] = $this->language->get('entry_option_points');
		$data['entry_subtract'] = $this->language->get('entry_subtract');
		$data['entry_weight_class'] = $this->language->get('entry_weight_class');
		$data['entry_weight'] = $this->language->get('entry_weight');
		$data['entry_dimension'] = $this->language->get('entry_dimension');
		$data['entry_length_class'] = $this->language->get('entry_length_class');
		$data['entry_length'] = $this->language->get('entry_length');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');

		$data['entry_diameter_of_pot'] = $this->language->get('entry_diameter_of_pot');
		$data['entry_depth_of_pot'] = $this->language->get('entry_depth_of_pot');
		$data['entry_pot_size'] = $this->language->get('entry_pot_size');
		$data['entry_price_rozetka'] = $this->language->get('entry_price_rozetka');
		$data['entry_price_special_rozetka'] = $this->language->get('entry_price_special_rozetka');


                $data['entry_material_shelves'] = $this->language->get('entry_material_shelves');
								$data['entry_model_selection'] = $this->language->get('entry_model_selection');
								$data['entry_quantity_shelves'] = $this->language->get('entry_quantity_shelves');
								$data['entry_maximum_weight'] = $this->language->get('entry_maximum_weight');
						        $data['entry_maximum_weight_all'] = $this->language->get('entry_maximum_weight_all');
								$data['entry_color_shelves'] = $this->language->get('entry_color_shelves');
								$data['entry_metal_thickness'] = $this->language->get('entry_metal_thickness');
								$data['entry_type'] = $this->language->get('entry_type');
								$data['entry_series'] = $this->language->get('entry_series');
								$data['entry_brand'] = $this->language->get('entry_brand');
            
		$data['entry_image'] = $this->language->get('entry_image');
        $data['entry_image_dod'] = $this->language->get('entry_image_dod');
		$data['entry_additional_image'] = $this->language->get('entry_additional_image');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
		$data['entry_download'] = $this->language->get('entry_download');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_filter'] = $this->language->get('entry_filter');
		$data['entry_related'] = $this->language->get('entry_related');
		$data['entry_related_info'] = $this->language->get('entry_related_info');
		$data['entry_attribute'] = $this->language->get('entry_attribute');
		$data['entry_text'] = $this->language->get('entry_text');
		$data['entry_option'] = $this->language->get('entry_option');
		$data['entry_option_value'] = $this->language->get('entry_option_value');
		$data['entry_required'] = $this->language->get('entry_required');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_priority'] = $this->language->get('entry_priority');
		$data['entry_tag'] = $this->language->get('entry_tag');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_reward'] = $this->language->get('entry_reward');
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_recurring'] = $this->language->get('entry_recurring');
		$data['entry_main_category'] = $this->language->get('entry_main_category');

		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_sku'] = $this->language->get('help_sku');
		$data['help_upc'] = $this->language->get('help_upc');
		$data['help_ean'] = $this->language->get('help_ean');
		$data['help_jan'] = $this->language->get('help_jan');
		$data['help_isbn'] = $this->language->get('help_isbn');
		$data['help_mpn'] = $this->language->get('help_mpn');
		$data['help_minimum'] = $this->language->get('help_minimum');
		$data['help_manufacturer'] = $this->language->get('help_manufacturer');
		$data['help_stock_status'] = $this->language->get('help_stock_status');
		$data['help_points'] = $this->language->get('help_points');
		$data['help_category'] = $this->language->get('help_category');
		$data['help_filter'] = $this->language->get('help_filter');
		$data['help_download'] = $this->language->get('help_download');
		$data['help_related'] = $this->language->get('help_related');
		$data['help_tag'] = $this->language->get('help_tag');

		$data['button_view'] = $this->language->get('button_view');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_attribute_add'] = $this->language->get('button_attribute_add');
		$data['button_option_add'] = $this->language->get('button_option_add');
		$data['button_option_value_add'] = $this->language->get('button_option_value_add');
		$data['button_discount_add'] = $this->language->get('button_discount_add');
		$data['button_special_add'] = $this->language->get('button_special_add');
		$data['button_image_add'] = $this->language->get('button_image_add');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_recurring_add'] = $this->language->get('button_recurring_add');

		$data['tab_general'] = $this->language->get('tab_general');
        // OCFilter start
        $data['tab_ocfilter'] = $this->language->get('tab_ocfilter');
        $data['entry_values'] = $this->language->get('entry_values');
        $data['ocfilter_select_category'] = $this->language->get('ocfilter_select_category');
        // OCFilter end
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_attribute'] = $this->language->get('tab_attribute');
		$data['tab_option'] = $this->language->get('tab_option');
		$data['tab_recurring'] = $this->language->get('tab_recurring');
		$data['tab_discount'] = $this->language->get('tab_discount');
		$data['tab_special'] = $this->language->get('tab_special');
		$data['tab_image'] = $this->language->get('tab_image');
		$data['tab_links'] = $this->language->get('tab_links');
		$data['tab_reward'] = $this->language->get('tab_reward');
		$data['tab_design'] = $this->language->get('tab_design');
		$data['tab_openbay'] = $this->language->get('tab_openbay');

		//Delivery rates
        $data['tab_delivery'] = $this->language->get('tab_delivery');
        $data['entry_np_branch'] = $this->language->get('entry_np_branch');
        $data['entry_np_courier'] = $this->language->get('entry_np_courier');
        $data['entry_np_sz_courier'] = $this->language->get('entry_np_sz_courier');
        //Delivery rates

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['model'])) {
			$data['error_model'] = $this->error['model'];
		} else {
			$data['error_model'] = '';
		}

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

		$url = '';

                if (isset($this->request->get['filter_manufacturer'])) {
                    $url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
                }
                if (isset($this->request->get['filter_sku'])) {
                    $url .= '&filter_sku=' . $this->request->get['filter_sku'];
                }
                if (isset($this->request->get['filter_attribute'])) {
                    $url .= '&filter_attribute=' . $this->request->get['filter_attribute'];
                }
        

		if ($this->config->get('module_catalog_quick_edit_status') && $this->config->get('module_catalog_quick_edit_catalog_products_status')) {
	      foreach ($this->config->get('module_catalog_quick_edit_catalog_products') as $column => $attr) {
	        if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
	          $url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
	        }
	      }
	      if (isset($this->request->get['filter_sub_category'])) {
	        $url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
	      }
	    }


		if ($this->config->get('aqe_status') && $this->config->get('aqe_catalog_products_status')) {
			foreach ($this->config->get('aqe_catalog_products') as $column => $attr) {
				if ($attr['filter']['show'] && isset($this->request->get['filter_' . $column])) {
					$url .= '&filter_' . $column . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $column], ENT_QUOTES, 'UTF-8'));
				}
			}
			if (isset($this->request->get['filter_sub_category'])) {
				$url .= '&filter_sub_category=' . urlencode(html_entity_decode($this->request->get['filter_sub_category'], ENT_QUOTES, 'UTF-8'));
			}
		}
			
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . urlencode(html_entity_decode($this->request->get['filter_price'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . urlencode(html_entity_decode($this->request->get['filter_quantity'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . urlencode(html_entity_decode($this->request->get['filter_status'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . urlencode(html_entity_decode($this->request->get['filter_image'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . urlencode(html_entity_decode($this->request->get['sort'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . urlencode(html_entity_decode($this->request->get['order'], ENT_QUOTES, 'UTF-8'));
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['product_id'])) {
			$data['action'] = $this->url->link('catalog/product/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'] . $url, true);

			$data['product_page'] = HTTP_CATALOG.'index.php?route=product/product&product_id='.$this->request->get['product_id'];
		}

		$data['cancel'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true);

		// оплата частями
		if (($this->config->get('privatbank_paymentparts_pp_status') == 1) || ($this->config->get('privatbank_paymentparts_ii_status') == 1)) {
			
			$data['privatstatus'] = true;
			$data['tab_privat'] = $this->language->get('tab_privat');
			$data['credit_type'] = $this->language->get('credit_type');
			$data['credit_type_ii'] = $this->language->get('credit_type_ii');
			$data['credit_type_pp'] = $this->language->get('credit_type_pp');
			$data['partsCount'] = $this->language->get('partsCount');
			$data['markup'] = $this->language->get('markup');
			$data['help_partsCount'] = $this->language->get('help_partsCount');
			$data['help_markup'] = $this->language->get('help_markup');			
		
            if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
                $credit_info = $this->model_catalog_product->getProductPrivat($this->request->get['product_id']);
            }

			$data['partscounts'] = array();
			for($i=24;$i>=1;$i--){
				$data['partscounts'][] = $i;           
			}
			
			if (isset($this->request->post['product_pp'])) {
				$data['product_pp'] = $this->request->post['product_pp'];
			} elseif (!empty($credit_info)) {
				$data['product_pp'] = $credit_info['product_pp'];
			} else {
				$data['product_pp'] = '';
			}

			if (isset($this->request->post['product_ii'])) {
				$data['product_ii'] = $this->request->post['product_ii'];
			} elseif (!empty($credit_info)) {
				$data['product_ii'] = $credit_info['product_ii'];
			} else {
				$data['product_ii'] = '';
			}
			
			if (isset($this->request->post['partscount_pp'])) {
				$data['partscount_pp'] = $this->request->post['partscount_pp'];
			} elseif (!empty($credit_info)) {
				$data['partscount_pp'] = $credit_info['partscount_pp'];
			} else {
				$data['partscount_pp'] = '';
			}
			
			if (isset($this->request->post['partscount_ii'])) {
				$data['partscount_ii'] = $this->request->post['partscount_ii'];
			} elseif (!empty($credit_info)) {
				$data['partscount_ii'] = $credit_info['partscount_ii'];
			} else {
				$data['partscount_ii'] = '';
			}

			if (isset($this->request->post['markup_pp'])) {
				$data['markup_pp'] = $this->request->post['markup_pp'];
			} elseif (!empty($credit_info)) {
				$data['markup_pp'] = $credit_info['markup_pp'];
			} else {
				$data['markup_pp'] = '';
			}
			
			if (isset($this->request->post['markup_ii'])) {
				$data['markup_ii'] = $this->request->post['markup_ii'];
			} elseif (!empty($credit_info)) {
				$data['markup_ii'] = $credit_info['markup_ii'];
			} else {
				$data['markup_ii'] = '';
			}			
		} else {
			$data['privatstatus'] = false;
		}

		//-- оплата частями

		if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
		}

		$data['token'] = $this->session->data['token'];
		$data['ckeditor'] = $this->config->get('config_editor_default');

		$this->load->model('localisation/language');

        $data['tab_hpm'] = $this->language->get('tab_hpm');
        $data['hpm_tab'] = $this->load->controller('extension/module/hpmodel/getList');
      

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['lang'] = $this->language->get('lang');

		if (isset($this->request->post['product_description'])) {
			$data['product_description'] = $this->request->post['product_description'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_description'] = $this->model_catalog_product->getProductDescriptions($this->request->get['product_id']);
		} else {
			$data['product_description'] = array();
		}

		if (isset($this->request->post['model'])) {
			$data['model'] = $this->request->post['model'];
		} elseif (!empty($product_info)) {
			$data['model'] = $product_info['model'];
		} else {
			$data['model'] = '';
		}

		if (isset($this->request->post['sku'])) {
			$data['sku'] = $this->request->post['sku'];
		} elseif (!empty($product_info)) {
			$data['sku'] = $product_info['sku'];
		} else {
			$data['sku'] = '';
		}

		if (isset($this->request->post['upc'])) {
			$data['upc'] = $this->request->post['upc'];
		} elseif (!empty($product_info)) {
			$data['upc'] = $product_info['upc'];
		} else {
			$data['upc'] = '';
		}

		if (isset($this->request->post['ean'])) {
			$data['ean'] = $this->request->post['ean'];
		} elseif (!empty($product_info)) {
			$data['ean'] = $product_info['ean'];
		} else {
			$data['ean'] = '';
		}

		if (isset($this->request->post['jan'])) {
			$data['jan'] = $this->request->post['jan'];
		} elseif (!empty($product_info)) {
			$data['jan'] = $product_info['jan'];
		} else {
			$data['jan'] = '';
		}

        if (isset($this->request->post['video'])) {
            $data['video'] = $this->request->post['video'];
        } elseif (!empty($product_info)) {
            $data['video'] = $product_info['video'];
        } else {
            $data['video'] = '';
        }

		if (isset($this->request->post['isbn'])) {
			$data['isbn'] = $this->request->post['isbn'];
		} elseif (!empty($product_info)) {
			$data['isbn'] = $product_info['isbn'];
		} else {
			$data['isbn'] = '';
		}

		if (isset($this->request->post['mpn'])) {
			$data['mpn'] = $this->request->post['mpn'];
		} elseif (!empty($product_info)) {
			$data['mpn'] = $product_info['mpn'];
		} else {
			$data['mpn'] = '';
		}

		if (isset($this->request->post['vendor'])) {
			$data['vendor'] = $this->request->post['vendor'];
		} elseif (!empty($product_info)) {
			$data['vendor'] = $product_info['vendor'];
		} else {
			$data['vendor'] = '';
		}


		if (isset($this->request->post['location'])) {
			$data['location'] = $this->request->post['location'];
		} elseif (!empty($product_info)) {
			$data['location'] = $product_info['location'];
		} else {
			$data['location'] = '';
		}

		if ($this->config->get('config_product_upc_hide') != 0) {
			$data['hide_upc'] = true;
		} else {
			$data['hide_upc'] = false;
		}

		if ($this->config->get('config_product_ean_hide') != 0) {
			$data['hide_ean'] = true;
		} else {
			$data['hide_ean'] = false;
		}

		if ($this->config->get('config_product_jan_hide') != 0) {
			$data['hide_jan'] = true;
		} else {
			$data['hide_jan'] = false;
		}

		if ($this->config->get('config_product_isbn_hide') != 0) {
			$data['hide_isbn'] = true;
		} else {
			$data['hide_isbn'] = false;
		}

		if ($this->config->get('config_product_mpn_hide') != 0) {
			$data['hide_mpn'] = true;
		} else {
			$data['hide_mpn'] = false;
		}

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['product_store'])) {
			$data['product_store'] = $this->request->post['product_store'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_store'] = $this->model_catalog_product->getProductStores($this->request->get['product_id']);
		} else {
			$data['product_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($product_info)) {
			$data['keyword'] = $product_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['shipping'])) {
			$data['shipping'] = $this->request->post['shipping'];
		} elseif (!empty($product_info)) {
			$data['shipping'] = $product_info['shipping'];
		} else {
			$data['shipping'] = 1;
		}

		if (isset($this->request->post['visible_carusel'])) {
			$data['visible_carusel'] = $this->request->post['visible_carusel'];
		} elseif (!empty($product_info)) {
			$data['visible_carusel'] = $product_info['visible_carusel'];
		} else {
			$data['visible_carusel'] = 1;
		}

		if (isset($this->request->post['price'])) {
			$data['price'] = $this->request->post['price'];
		} elseif (!empty($product_info)) {
			$data['price'] = $product_info['price'];
		} else {
			$data['price'] = '';
		}

		$this->load->model('catalog/recurring');

		$data['recurrings'] = $this->model_catalog_recurring->getRecurrings();

		if (isset($this->request->post['product_recurrings'])) {
			$data['product_recurrings'] = $this->request->post['product_recurrings'];
		} elseif (!empty($product_info)) {
			$data['product_recurrings'] = $this->model_catalog_product->getRecurrings($product_info['product_id']);
		} else {
			$data['product_recurrings'] = array();
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['tax_class_id'])) {
			$data['tax_class_id'] = $this->request->post['tax_class_id'];
		} elseif (!empty($product_info)) {
			$data['tax_class_id'] = $product_info['tax_class_id'];
		} else {
			$data['tax_class_id'] = 0;
		}

		if (isset($this->request->post['date_available'])) {
			$data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($product_info)) {
			$data['date_available'] = ($product_info['date_available'] != '0000-00-00') ? $product_info['date_available'] : '';
		} else {
			$data['date_available'] = date('Y-m-d');
		}

		if (isset($this->request->post['quantity'])) {
			$data['quantity'] = $this->request->post['quantity'];
		} elseif (!empty($product_info)) {
			$data['quantity'] = $product_info['quantity'];
		} else {
			$data['quantity'] = 1;
		}

		if (isset($this->request->post['minimum'])) {
			$data['minimum'] = $this->request->post['minimum'];
		} elseif (!empty($product_info)) {
			$data['minimum'] = $product_info['minimum'];
		} else {
			$data['minimum'] = 1;
		}

		if (isset($this->request->post['subtract'])) {
			$data['subtract'] = $this->request->post['subtract'];
		} elseif (!empty($product_info)) {
			$data['subtract'] = $product_info['subtract'];
		} else {
			$data['subtract'] = 1;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($product_info)) {
			$data['sort_order'] = $product_info['sort_order'];
		} else {
			$data['sort_order'] = 100;
		}

		if (isset($this->request->post['sort_search'])) {
			$data['sort_search'] = $this->request->post['sort_search'];
		} elseif (!empty($product_info)) {
			$data['sort_search'] = $product_info['sort_search'];
		} else {
			$data['sort_search'] = 0;
		}

		$this->load->model('localisation/stock_status');

		$data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

		if (isset($this->request->post['stock_status_id'])) {
			$data['stock_status_id'] = $this->request->post['stock_status_id'];
		} elseif (!empty($product_info)) {
			$data['stock_status_id'] = $product_info['stock_status_id'];
		} else {
			$data['stock_status_id'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($product_info)) {
			$data['status'] = $product_info['status'];
		} else {
			$data['status'] = true;
		}

		if (isset($this->request->post['weight'])) {
			$data['weight'] = $this->request->post['weight'];
		} elseif (!empty($product_info)) {
			$data['weight'] = $product_info['weight'];
		} else {
			$data['weight'] = '';
		}

		$this->load->model('localisation/weight_class');

		$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (isset($this->request->post['weight_class_id'])) {
			$data['weight_class_id'] = $this->request->post['weight_class_id'];
		} elseif (!empty($product_info)) {
			$data['weight_class_id'] = $product_info['weight_class_id'];
		} else {
			$data['weight_class_id'] = $this->config->get('config_weight_class_id');
		}

		if (isset($this->request->post['length'])) {
			$data['length'] = $this->request->post['length'];
		} elseif (!empty($product_info)) {
			$data['length'] = $product_info['length'];
		} else {
			$data['length'] = '';
		}


                if (isset($this->request->post['quantity_shelves'])) {
									$data['quantity_shelves'] = trim($this->request->post['quantity_shelves']);
								} elseif (!empty($product_info)) {
									$data['quantity_shelves'] = $product_info['quantity_shelves'];
								} else {
									$data['quantity_shelves'] = '';
								}
							
								if (isset($this->request->post['maximum_weight'])) {
									$data['maximum_weight'] = trim($this->request->post['maximum_weight']);
								} elseif (!empty($product_info)) {
									$data['maximum_weight'] = $product_info['maximum_weight'];
								} else {
									$data['maximum_weight'] = '';
								}
								if (isset($this->request->post['maximum_weight_all'])) {
									$data['maximum_weight_all'] = trim($this->request->post['maximum_weight_all']);
								} elseif (!empty($product_info)) {
									$data['maximum_weight_all'] = $product_info['maximum_weight_all'];
								} else {
									$data['maximum_weight_all'] = '';
								}

								if (isset($this->request->post['material_shelves'])) {
									$data['material_shelves'] = trim($this->request->post['material_shelves']);
								} elseif (!empty($product_info)) {
									$data['material_shelves'] = $product_info['material_shelves'];
								} else {
									$data['material_shelves'] = '';
								}

								if (isset($this->request->post['model_selection'])) {
									$data['model_selection'] = trim($this->request->post['model_selection']);
								} elseif (!empty($product_info)) {
									$data['model_selection'] = $product_info['model_selection'];
								} else {
									$data['model_selection'] = '';
								}	

								if (isset($this->request->post['color_shelves'])) {
									$data['color_shelves'] = trim($this->request->post['color_shelves']);
								} elseif (!empty($product_info)) {
									$data['color_shelves'] = $product_info['color_shelves'];
								} else {
									$data['color_shelves'] = '';
								}

								if (isset($this->request->post['metal_thickness'])) {
									$data['metal_thickness'] = trim($this->request->post['metal_thickness']);
								} elseif (!empty($product_info)) {
									$data['metal_thickness'] = $product_info['metal_thickness'];
								} else {
									$data['metal_thickness'] = '';
								}

								if (isset($this->request->post['type'])) {
									$data['type'] = trim($this->request->post['type']);
								} elseif (!empty($product_info)) {
									$data['type'] = $product_info['type'];
								} else {
									$data['type'] = '';
								}

								if (isset($this->request->post['series'])) {
									$data['series'] = trim($this->request->post['series']);
								} elseif (!empty($product_info)) {
									$data['series'] = $product_info['series'];
								} else {
									$data['series'] = '';
								}

								if (isset($this->request->post['brand'])) {
									$data['brand'] = trim($this->request->post['brand']);
								} elseif (!empty($product_info)) {
									$data['brand'] = trim($product_info['brand']);
								} else {
									$data['brand'] = '';
								}
            
		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($product_info)) {
			$data['width'] = $product_info['width'];
		} else {
			$data['width'] = '';
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($product_info)) {
			$data['height'] = $product_info['height'];
		} else {
			$data['height'] = '';
		}

		if (isset($this->request->post['diameter_of_pot'])) {
			$data['diameter_of_pot'] = $this->request->post['diameter_of_pot']?:null;
		} elseif (!empty($product_info)) {
			$data['diameter_of_pot'] = $product_info['diameter_of_pot'];
		} else {
			$data['diameter_of_pot'] = '';
		}

		if (isset($this->request->post['depth_of_pot'])) {
			$data['depth_of_pot'] = $this->request->post['depth_of_pot']?:null;
		} elseif (!empty($product_info)) {
			$data['depth_of_pot'] = $product_info['depth_of_pot'];
		} else {
			$data['depth_of_pot'] = '';
		}

		if (isset($this->request->post['price_rozetka'])) {
			$data['price_rozetka'] = $this->request->post['price_rozetka']?:null;
		} elseif (!empty($product_info)) {
			$data['price_rozetka'] = $product_info['price_rozetka'];
		} else {
			$data['price_rozetka'] = '';
		}

		if (isset($this->request->post['price_special_rozetka'])) {
			$data['price_special_rozetka'] = $this->request->post['price_special_rozetka']?:null;
		} elseif (!empty($product_info)) {
			$data['price_special_rozetka'] = $product_info['price_special_rozetka'];
		} else {
			$data['price_special_rozetka'] = '';
		}

        if (isset($this->request->post['price_base'])) {
            $data['price_base'] = $this->request->post['price_base']?:null;
        } elseif (!empty($product_info)) {
            $data['price_base'] = $product_info['price_base'];
        } else {
            $data['price_base'] = 0;
        }

		$this->load->model('localisation/length_class');

		$data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();

		if (isset($this->request->post['length_class_id'])) {
			$data['length_class_id'] = $this->request->post['length_class_id'];
		} elseif (!empty($product_info)) {
			$data['length_class_id'] = $product_info['length_class_id'];
		} else {
			$data['length_class_id'] = $this->config->get('config_length_class_id');
		}

		$this->load->model('catalog/manufacturer');

    $data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();

		if (isset($this->request->post['manufacturer_id'])) {
			$data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		} elseif (!empty($product_info)) {
			$data['manufacturer_id'] = $product_info['manufacturer_id'];
		} else {
			$data['manufacturer_id'] = 0;
		}

        if (isset($this->request->post['brend_id'])) {
            $data['brend_id'] = $this->request->post['brend_id'];
        } elseif (!empty($product_info)) {
            $data['brend_id'] = $product_info['brend_id'];
        } else {
            $data['brend_id'] = 0;
        }


		if (isset($this->request->post['manufacturer'])) {
			$data['manufacturer'] = $this->request->post['manufacturer'];
		} elseif (!empty($product_info)) {
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($product_info['manufacturer_id']);

			if ($manufacturer_info) {
				$data['manufacturer'] = $manufacturer_info['name'];
			} else {
				$data['manufacturer'] = '';
			}
		} else {
			$data['manufacturer'] = '';
		}

		// Categories
		$this->load->model('catalog/category');

		$filter_data = array(
			'sort'        => 'name',
			'order'       => 'ASC'
		);

		$data['categories'] = $this->model_catalog_category->getCategories($filter_data);

		// Filters

		if (isset($this->request->post['main_category_id'])) {
			$data['main_category_id'] = $this->request->post['main_category_id'];
		} elseif (isset($product_info)) {
			$data['main_category_id'] = $this->model_catalog_product->getProductMainCategoryId($this->request->get['product_id']);
		} else {
			$data['main_category_id'] = 0;
		}

		if (isset($this->request->post['product_category'])) {
			$data['product_category'] = $this->request->post['product_category'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_category'] = $this->model_catalog_product->getProductCategories($this->request->get['product_id']);
		} else {
			$data['product_category'] = array();
		}

		$this->load->model('catalog/filter');

		if (isset($this->request->post['product_filter'])) {
			$filters = $this->request->post['product_filter'];
		} elseif (isset($this->request->get['product_id'])) {
			$filters = $this->model_catalog_product->getProductFilters($this->request->get['product_id']);
		} else {
			$filters = array();
		}

		$data['product_filters'] = array();

		foreach ($filters as $filter_id) {
			$filter_info = $this->model_catalog_filter->getFilter($filter_id);

			if ($filter_info) {
				$data['product_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}

		// Attributes
		$this->load->model('catalog/attribute');

		if (isset($this->request->post['product_attribute'])) {
			$product_attributes = $this->request->post['product_attribute'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_attributes = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);
		} else {
			$product_attributes = array();
		}

		$data['product_attributes'] = array();
		foreach ($product_attributes as $product_attribute) {
			$attribute_info = $this->model_catalog_attribute->getAttribute($product_attribute['attribute_id']);
			$values = array();//$this->getAttributeValue($product_attribute['attribute_id']);
			
			foreach($product_attribute['product_attribute_description'] as $index => $row){
				$values[$index] = explode(';',trim($row['text']));
			}
			
			if ($attribute_info) {
				$data['product_attributes'][] = array(
					'attribute_id'                  => $product_attribute['attribute_id'],
					'name'                          => $attribute_info['name'],
					'values'                        => $values,
					'product_attribute_description' => $product_attribute['product_attribute_description']
				);
			}
			//$attr_json[$product_attribute['attribute_id']] = $values;
		}
		//$data['attr_json'] = json_encode($attr_json);

		$results = $this->model_catalog_attribute->getAttributes();
		$data['attr_list'] = array();
			foreach ($results as $result) {
				$data['attr_list'][] = array(
					'attribute_id'    => $result['attribute_id'],
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
				);
			}

		// Options
		$this->load->model('catalog/option');

		if (isset($this->request->post['product_option'])) {
			$product_options = $this->request->post['product_option'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_options = $this->model_catalog_product->getProductOptions($this->request->get['product_id']);
		} else {
			$product_options = array();
		}

		$data['product_options'] = array();

		foreach ($product_options as $product_option) {
			$product_option_value_data = array();

			if (isset($product_option['product_option_value'])) {
				foreach ($product_option['product_option_value'] as $product_option_value) {
					$product_option_value_data[] = array(
						'product_option_value_id' => $product_option_value['product_option_value_id'],
						'option_value_id'         => $product_option_value['option_value_id'],
						'quantity'                => $product_option_value['quantity'],
						'subtract'                => $product_option_value['subtract'],
						'price'                   => $product_option_value['price'],
						'price_prefix'            => $product_option_value['price_prefix'],
						'points'                  => $product_option_value['points'],
						'points_prefix'           => $product_option_value['points_prefix'],
						'weight'                  => $product_option_value['weight'],
						'weight_prefix'           => $product_option_value['weight_prefix']
					);
				}
			}

			$data['product_options'][] = array(
				'product_option_id'    => $product_option['product_option_id'],
				'product_option_value' => $product_option_value_data,
				'option_id'            => $product_option['option_id'],
				'name'                 => $product_option['name'],
				'type'                 => $product_option['type'],
				'value'                => isset($product_option['value']) ? $product_option['value'] : '',
				'required'             => $product_option['required']
			);
		}

		$data['option_values'] = array();

		foreach ($data['product_options'] as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				if (!isset($data['option_values'][$product_option['option_id']])) {
					$data['option_values'][$product_option['option_id']] = $this->model_catalog_option->getOptionValues($product_option['option_id']);
				}
			}
		}

		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		if (isset($this->request->post['product_discount'])) {
			$product_discounts = $this->request->post['product_discount'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);
		} else {
			$product_discounts = array();
		}

		$data['product_discounts'] = array();

		foreach ($product_discounts as $product_discount) {
			$data['product_discounts'][] = array(
				'customer_group_id' => $product_discount['customer_group_id'],
				'quantity'          => $product_discount['quantity'],
				'priority'          => $product_discount['priority'],
				'price'             => $product_discount['price'],
				'date_start'        => ($product_discount['date_start'] != '0000-00-00') ? $product_discount['date_start'] : '',
				'date_end'          => ($product_discount['date_end'] != '0000-00-00') ? $product_discount['date_end'] : ''
			);
		}

		if (isset($this->request->post['product_special'])) {
			$product_specials = $this->request->post['product_special'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_specials = $this->model_catalog_product->getProductSpecials($this->request->get['product_id']);
		} else {
			$product_specials = array();
		}

		$data['product_specials'] = array();

		foreach ($product_specials as $product_special) {
			$data['product_specials'][] = array(
				'customer_group_id' => $product_special['customer_group_id'],
				'priority'          => $product_special['priority'],
				'price'             => $product_special['price'],
				'date_start'        => ($product_special['date_start'] != '0000-00-00') ? $product_special['date_start'] : '',
				'date_end'          => ($product_special['date_end'] != '0000-00-00') ? $product_special['date_end'] :  ''
			);
		}

		// Image
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($product_info)) {
			$data['image'] = $product_info['image'];
		} else {
			$data['image'] = '';
		}

        if (isset($this->request->post['image_dod'])) {
            $data['image_dod'] = $this->request->post['image_dod'];
        } elseif (!empty($product_info)) {
            $data['image_dod'] = $product_info['image_dod'];
        } else {
            $data['image_dod'] = '';
        }

		$this->load->model('tool/image');

        if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($product_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($product_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

        if (isset($this->request->post['image_dod']) && is_file(DIR_IMAGE . $this->request->post['image_dod'])) {
            $data['thumb_dod'] = $this->model_tool_image->resize($this->request->post['image_dod'], 100, 100);
        } elseif (!empty($product_info['image_dod'])) {
            $data['thumb_dod'] = $this->model_tool_image->resize($product_info['image_dod'], 100, 100);
        } else {
            $data['thumb_dod'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }


		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

    if (isset($this->request->post['videos'])) {
      $videos = $this->request->post['videos'];
    } elseif (isset($this->request->get['product_id'])) {
      $videos = $this->model_catalog_product->getProductVideos($this->request->get['product_id']);
    } else {
      $videos = array();
    }

    $data['videos'] = array();

    foreach ($videos as $key => $value) {
      foreach ($value as $video) {
        
        $data['videos'][$key][] = array(
          'id'        => $video['id'],
          'name'      => $video['name'],
          'video'       => $video['video'],
          'sort_order' => $video['sort_order']
        );
      }
    }

		// Images
		if (isset($this->request->post['product_image'])) {
			$product_images = $this->request->post['product_image'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_images = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
		} else {
			$product_images = array();
		}

		$data['product_images'] = array();

		foreach ($product_images as $product_image) {
            if (is_file(DIR_IMAGE . $product_image['image'])) {
				$image = $product_image['image'];
				$thumb = $product_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['product_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order' => $product_image['sort_order']
			);
		}

		// Downloads
		$this->load->model('catalog/download');

		if (isset($this->request->post['product_download'])) {
			$product_downloads = $this->request->post['product_download'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_downloads = $this->model_catalog_product->getProductDownloads($this->request->get['product_id']);
		} else {
			$product_downloads = array();
		}

		$data['product_downloads'] = array();

		foreach ($product_downloads as $download_id) {
			$download_info = $this->model_catalog_download->getDownload($download_id);

			if ($download_info) {
				$data['product_downloads'][] = array(
					'download_id' => $download_info['download_id'],
					'name'        => $download_info['name']
				);
			}
		}

		if (isset($this->request->post['product_related'])) {
			$products = $this->request->post['product_related'];
		} elseif (isset($this->request->get['product_id'])) {
			$products = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
		} else {
			$products = array();
		}

		$data['product_relateds'] = array();

		foreach ($products as $product_id) {
			$related_info = $this->model_catalog_product->getProduct($product_id);

			if ($related_info) {
				$data['product_relateds'][] = array(
					'product_id' => $related_info['product_id'],
					'model' 		 => $related_info['model'],
					'sku' 		 	 => $related_info['sku'],
					'height' 		 => $related_info['height'],
					'width' 		 => $related_info['width'],
					'length' 		 => $related_info['length'],
					'name'       => $related_info['name']
				);
			}
		}

		if (isset($this->request->post['points'])) {
			$data['points'] = $this->request->post['points'];
		} elseif (!empty($product_info)) {
			$data['points'] = $product_info['points'];
		} else {
			$data['points'] = '';
		}

		if (isset($this->request->post['product_reward'])) {
			$data['product_reward'] = $this->request->post['product_reward'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_reward'] = $this->model_catalog_product->getProductRewards($this->request->get['product_id']);
		} else {
			$data['product_reward'] = array();
		}

		if (isset($this->request->post['product_layout'])) {
			$data['product_layout'] = $this->request->post['product_layout'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_layout'] = $this->model_catalog_product->getProductLayouts($this->request->get['product_id']);
		} else {
			$data['product_layout'] = array();
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();



        $data['citys'] = $this->model_catalog_product->getCitys();

        //pickup
        if (isset($this->request->post['pickup'])) {
            $data['pickup'] = $this->request->post['pickup'];
        } elseif (!empty($product_info)) {
            $data['pickup'] = $product_info['pickup'];
        } else {
            $data['pickup'] = 0;
        }

        $data['product_pickup_city'] = array();

        if (isset($this->request->post['product_pickup_city'])) {
            $product_pickup_citys = $this->request->post['product_pickup_city'];
        } elseif (!empty($product_info)) {
            $product_pickup_citys = $this->model_catalog_product->getProductPickupCity($this->request->get['product_id']);
        } else {
            $product_pickup_citys = array();
        }

        foreach($product_pickup_citys as $product_city){
            $data['product_pickup_city'][] = $product_city['city'];
        }

        //pickup

        //courier
        if (isset($this->request->post['courier'])) {
            $data['courier'] = $this->request->post['courier'];
        } elseif (!empty($product_info)) {
            $data['courier'] = $product_info['courier'];
        } else {
            $data['courier'] = 0;
        }

        $data['product_courier_city'] = array();

        if (isset($this->request->post['product_courier_city'])) {
            $product_courier_citys = $this->request->post['product_courier_city'];
        } elseif (!empty($product_info)) {
            $product_courier_citys = $this->model_catalog_product->getProductCourierCity($this->request->get['product_id']);
        } else {
            $product_courier_citys = array();
        }

        foreach($product_courier_citys as $product_city){
            $data['product_courier_city'][] = $product_city['city'];
        }
        //courier

        //proveder
        $proveder = $this->model_catalog_product->getProductProveder($this->request->get['product_id']);
        $data['providers'] = array();
        $data['providers'] = $this->model_catalog_product->getProveders();

            if (isset($this->request->post['provider_product'])) {
                $data['provider_product'] = $this->request->post['provider_product'];
            } elseif (!empty($proveder)) {
                $data['provider_product'] = $proveder['id_provider'];
            } else {
                $data['provider_product'] = 0;
            }

            if (isset($this->request->post['nomer_provider_product'])) {
                $data['nomer_provider_product'] = $this->request->post['nomer_provider_product'];
            } elseif (!empty($proveder)) {
                $data['nomer_provider_product'] = $proveder['nomer_provider_product'];
            } else {
                $data['nomer_provider_product'] = '';
            }

            if (isset($this->request->post['price_base'])) {
                $data['price_base'] = $this->request->post['price_base'];
            } elseif (!empty($proveder)) {
                $data['price_base'] = $proveder['price_base'];
            } else {
                $data['price_base'] = '';
            }

            if (isset($this->request->post['price_rrc'])) {
                $data['price_rrc'] = $this->request->post['price_rrc'];
            } elseif (!empty($proveder)) {
                $data['price_rrc'] = $proveder['price_rrc'];
            } else {
                $data['price_rrc'] = '';
            }

            if (isset($this->request->post['name_provider_product'])) {
                $data['name_provider_product'] = $this->request->post['name_provider_product'];
            } elseif (!empty($proveder)) {
                $data['name_provider_product'] = $proveder['name_provider_product'];
            } else {
                $data['name_provider_product'] = '';
            }

            if (isset($this->request->post['day_delivery'])) {
                $data['day_delivery'] = $this->request->post['day_delivery'];
            } elseif (!empty($proveder)) {
                $data['day_delivery'] = $proveder['day_delivery'];
            } else {
                $data['day_delivery'] = '';
            }
        //proveder

        //Delivery rates
        if (isset($this->request->post['np_branch'])) {
            $data['np_branch'] = $this->request->post['np_branch'];
        } elseif (!empty($product_info)) {
            $data['np_branch'] = $product_info['np_branch'];
        } else {
            $data['np_branch'] = '';
        }

        if (isset($this->request->post['np_courier'])) {
            $data['np_courier'] = $this->request->post['np_courier'];
        } elseif (!empty($product_info)) {
            $data['np_courier'] = $product_info['np_courier'];
        } else {
            $data['np_courier'] = '';
        }

        if (isset($this->request->post['np_sz_courier'])) {
            $data['np_sz_courier'] = $this->request->post['np_sz_courier'];
        } elseif (!empty($product_info)) {
            $data['np_sz_courier'] = $product_info['np_sz_courier'];
        } else {
            $data['np_sz_courier'] = '';
        }
        //Delivery rates

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/product_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['product_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

		if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
			$this->error['model'] = $this->language->get('error_model');
		}

		if (utf8_strlen($this->request->post['keyword']) > 0) {
			$this->load->model('catalog/url_alias');

			$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);

			if ($url_alias_info && isset($this->request->get['product_id']) && $url_alias_info['query'] != 'product_id=' . $this->request->get['product_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($url_alias_info && !isset($this->request->get['product_id'])) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}


      	public function smallproductseditor() {
			if (isset($this->request->post['action']) && $this->validateDelete()) {
				$this->load->model('catalog/product');

				switch ($this->request->post['action']) {
				    case 'active':
						$this->model_catalog_product->editProductsStatus($this->request->post['products'], 1);
				        break;
				    case 'deactive':
						$this->model_catalog_product->editProductsStatus($this->request->post['products'], 0);
				        break;
				    case 'move':
						$this->model_catalog_product->deleteProductsCategory($this->request->post['products']);
		            case 'move':
					case 'copy':
						if ($this->request->post['category']!='*')
						$this->model_catalog_product->addProductsCategory($this->request->post['products'], $this->request->post['category']);
				        break;
					case 'price':
						$this->model_catalog_product->editProductsPrice($this->request->post['products'], str_replace(',','.',$this->request->post['coefficient']));
				        break;
				}

				$this->response->setOutput(1);
			}
			else {
				$this->response->setOutput('error post request or access to products');
			}
		}
      
	public function autocomplete() {

		if ((int)$this->config->get('aqe_status') && (int)$this->config->get('aqe_catalog_products_status')) {
			return $this->load->controller('catalog/aqe/product/autocomplete');
		}
			
		$json = array();

		
                if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_sku'])) {
        
			$this->load->model('catalog/product');
			$this->load->model('catalog/option');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}


                if (isset($this->request->get['filter_sku'])) {
                    $filter_sku = $this->request->get['filter_sku'];
                } else {
                    $filter_sku = '';
                }
        
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 5;
			}

			$filter_data = array(
				'filter_special'  => $filter_name,
				'filter_status'		=> 1,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_catalog_product->getProductsAutocomplete($filter_data);

			foreach ($results as $result) {
				$option_data = array();

				$product_options = $this->model_catalog_product->getProductOptions($result['product_id']);

				foreach ($product_options as $product_option) {
					$option_info = $this->model_catalog_option->getOption($product_option['option_id']);

					if ($option_info) {
						$product_option_value_data = array();

						foreach ($product_option['product_option_value'] as $product_option_value) {
							$option_value_info = $this->model_catalog_option->getOptionValue($product_option_value['option_value_id']);

							if ($option_value_info) {
								$product_option_value_data[] = array(
									'product_option_value_id' => $product_option_value['product_option_value_id'],
									'option_value_id'         => $product_option_value['option_value_id'],
									'name'                    => $option_value_info['name'],
									'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
									'price_prefix'            => $product_option_value['price_prefix']
								);
							}
						}

						$option_data[] = array(
							'product_option_id'    => $product_option['product_option_id'],
							'product_option_value' => $product_option_value_data,
							'option_id'            => $product_option['option_id'],
							'name'                 => $option_info['name'],
							'type'                 => $option_info['type'],
							'value'                => $product_option['value'],
							'required'             => $product_option['required']
						);
					}
				}

				$json[] = array(

                'sku' => $result['sku'],
        
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model'      => $result['model'],
					'sku'      	 => $result['sku'],
					'height'     => $result['height'],
					'width'      => $result['width'],
					'length'     => $result['length'],
					'option'     => $option_data,
					'price'      => $result['price']
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
