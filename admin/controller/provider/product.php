<?php
class ControllerProviderProduct extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('provider/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('provider/product');

		$this->getList();
	}

	public function add() {
		$this->load->language('provider/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('provider/product');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->model_provider_provider_product->addProductProveder($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('provider/product', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('provider/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('provider/product');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->model_provider_provider_product->editProductProveder($this->request->get['id_nomer'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('provider/product', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('provider/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('provider/product');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $id) {
				$this->model_provider_provider_product->deleteProductProveder($id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('provider/product', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('provider/product', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('provider/product/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('provider/product/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['provider_products'] = array();

		$filter_data = array(
			'start'          => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'          => $this->config->get('config_limit_admin')
		);

		$provider_total = $this->model_provider_product->getTotalProductProveders($filter_data);

		$results = $this->model_provider_product->getProductProveders($filter_data);

		foreach ($results as $result) {

            if($result['id_provider'] != 0){
                $name_provider = $this->model_provider_provider_product->getProvederName($result['id_provider']);
            }else{
                $name_provider = 'нет поставщика';
            }
            
			$data['provider_products'][] = array(
				'id_nomer'              => $result['id_nomer'],
				'product_id'            => $result['product_id'],
				'name_provider'         => $name_provider,
				'code_provider'         => $result['code_provider'],
                'id_provider_product'   => $result['id_provider_product'],
                'code_provider_product' => $result['code_provider_product'],
                'name_provider_product' => $result['name_provider_product'],
                'old_price_base'        => '',
                'old_price_rrc'         => '',
                'price_base'            => '',
                'price_rrc'             => '',
				'price_file'            => '',
				'old_price_file'        => '',
                'price'                 => '',
                'old_price'             => '',
                'status_price'          => $result['status_price'],
                'status_n'              => $result['status_n'],
                'isimport'	            => $result['isimport'],
                'marga'                 => '',
                'aktiv'                 => $result['isimport'],
                'date_added'            => "",
                'date_modified'         => "",
                'date_zakup'            => "",
				'edit'                  => $this->url->link('provider/product/edit', 'token=' . $this->session->data['token'] . '&id_nomer=' . $result['id_nomer'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

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

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$url = '';

		$pagination = new Pagination();
		$pagination->total = $provider_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('provider/product', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

        $data['token'] = $this->session->data['token'];

		$data['results'] = sprintf($this->language->get('text_pagination'), ($provider_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($provider_total - $this->config->get('config_limit_admin'))) ? $provider_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $provider_total, ceil($provider_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('provider/product_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['id_nomer']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('provider/product', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['id'])) {
			$data['action'] = $this->url->link('provider/product/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('provider/product/edit', 'token=' . $this->session->data['token'] . '&id_nomer=' . $this->request->get['id_nomer'] . $url, true);
		}

		$data['cancel'] = $this->url->link('provider/product', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['id_nomer']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$info = $this->model_provider_provider_product->getProductProveder($this->request->get['id_nomer']);
		}

		$data['token'] = $this->session->data['token'];

        if (isset($this->request->post['id_provider'])) {
            $data['id_provider'] = $this->request->post['id_provider'];
        } elseif (!empty($info)) {
            $data['id_provider'] = $info['id_provider'];
        } else {
            $data['id_provider'] = 0;
        }

        $data['shippings'] = $this->model_provider_provider_delivery->getShippings();

        if (isset($this->request->post['id_shiping'])) {
            $data['id_shiping'] = $this->request->post['id_shiping'];
        } elseif (!empty($info)) {
            $data['id_shiping'] = $info['id_shiping'];
        } else {
            $data['id_shiping'] = 0;
        }

        if (isset($this->request->post['status_ship'])) {
            $data['status_ship'] = $this->request->post['status_ship'];
        } elseif (!empty($info)) {
            $data['status_ship'] = $info['status_ship'];
        } else {
            $data['status_ship'] = 0;
        }

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($info)) {
            $data['status'] = $info['status'];
        } else {
            $data['status'] = 0;
        }


        if (isset($this->request->post['time_delivery'])) {
            $data['day_delivery'] = $this->request->post['day_delivery'];
        } elseif (!empty($info)) {
            $data['day_delivery'] = $info['day_delivery'];
        } else {
            $data['day_delivery'] = 0;
        }

        if (isset($this->request->post['time_delivery'])) {
            $data['time_delivery'] = $this->request->post['time_delivery'];
        } elseif (!empty($info)) {
            $data['time_delivery'] = $info['time_delivery'];
        } else {
            $data['time_delivery'] = 0;
        }

        if (isset($this->request->post['weekend'])) {
            $data['weekend'] = $this->request->post['weekend'];
        } elseif (!empty($info)) {
            $data['weekend'] = $info['weekend'];
        } else {
            $data['weekend'] = 0;
        }

        if (isset($this->request->post['day'])) {
            $data['day'] = $this->request->post['day'];
        } elseif (!empty($info)) {
            $data['day'] = $info['day'];
        } else {
            $data['day'] = 0;
        }


        if (isset($this->request->post['price'])) {
            $data['price'] = $this->request->post['price'];
        } elseif (!empty($info)) {
            $data['price'] = $info['price'];
        } else {
            $data['price'] = '';
        }

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('provider/product_form', $data));
	}
}