<?php
class ControllerProviderProviderDelivery extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('provider/provider_delivery');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('provider/provider_delivery');

		$this->getList();
	}

	public function add() {
		$this->load->language('provider/provider_delivery');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('provider/provider_delivery');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->model_provider_provider_delivery->addDeliveryProveder($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('provider/provider_delivery', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('provider/provider_delivery');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('provider/provider_delivery');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->model_provider_provider_delivery->editDeliveryProveder($this->request->get['id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('provider/provider_delivery', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('provider/provider_delivery');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('provider/provider_delivery');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $id) {
				$this->model_provider_provider_delivery->deleteDeliveryProveder($id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('provider/provider_delivery', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        } else {
            $filter_name = null;
        }

        if (isset($this->request->get['filter_name_id'])) {
            $filter_name_id = $this->request->get['filter_name_id'];
        } else {
            $filter_name_id = null;
        }


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
			'href' => $this->url->link('provider/provider_delivery', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('provider/provider_delivery/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('provider/provider_delivery/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['provider_ships'] = array();

		$filter_data = array(
		    'filter_name_id' => $filter_name_id,
			'start'          => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'          => $this->config->get('config_limit_admin')
		);

		$provider_total = $this->model_provider_provider_delivery->getTotalDeliveryProveders($filter_data);

		$results = $this->model_provider_provider_delivery->getDeliveryProveders($filter_data);

		foreach ($results as $result) {

		    if($result['product_id'] != 0){
                $name_product = $this->model_provider_provider_delivery->getProductName($result['product_id']);
            }else{
                $name_product = 'нет продукта';
            }

            if($result['id_provider'] != 0){
                $name_provider = $this->model_provider_provider_delivery->getProvederName($result['id_provider']);
            }else{
                $name_provider = 'нет поставщика';
            }

            if($result['id_shiping'] != 0){
                $name_shiping = $this->model_provider_provider_delivery->getShipName($result['id_shiping']);
            }else{
                $name_shiping = 'нет метода доставки';
            }

            if($result['status'] == 1){
                $status = 'Включен';
            }else{
                $status = 'Выключен';
            }

            switch ($result['weekend']){
                case 0:
                    $weekend = 'Пн - Пт';
                    break;
                case 1:
                    $weekend =  "Пн - Сб";
                    break;
                case 2:
                    $weekend =  "Пн - Вс";
                    break;
            }

            if($result['status_ship']){
                $ship = 'Включен';
            }else{
                $ship = 'Отключен';
            }

			$data['provider_ships'][] = array(
				'id'             => $result['id'],
				'name_product'   => $name_product,
				'name_provider'  => $name_provider,
				'name_shiping'   => $name_shiping,
                'status_ship'    => $ship,
                'status'         => $status,
                'city'           => $result['city'],
                'day_delivery'   => $result['day_delivery'],
                'time_delivery'  => $result['time_delivery'],
                'weekend'        => $weekend,
                'day'            => $result['day'],
                'price'          => $result['price'],
				'edit'           => $this->url->link('provider/provider_delivery/edit', 'token=' . $this->session->data['token'] . '&id=' . $result['id'] . $url, true)
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
		$pagination->url = $this->url->link('provider/provider_delivery', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

        $data['filter_name'] = $filter_name;
        $data['filter_name_id'] = $filter_name_id;

        $data['token'] = $this->session->data['token'];

		$data['results'] = sprintf($this->language->get('text_pagination'), ($provider_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($provider_total - $this->config->get('config_limit_admin'))) ? $provider_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $provider_total, ceil($provider_total / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('provider/provider_delivery_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
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
			'href' => $this->url->link('provider/provider_delivery', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['id'])) {
			$data['action'] = $this->url->link('provider/provider_delivery/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('provider/provider_delivery/edit', 'token=' . $this->session->data['token'] . '&id=' . $this->request->get['id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('provider/provider_delivery', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$info = $this->model_provider_provider_delivery->getDeliveryProveder($this->request->get['id']);
		}

		$data['token'] = $this->session->data['token'];

        $data['providers'] = $this->model_provider_provider_delivery->getProveders();

        if (isset($this->request->post['product_id'])) {
            $data['product_id'] = $this->request->post['product_id'];
            $data['product_name'] = $this->model_provider_provider_delivery->getProductName($this->request->post['product_id']);
        } elseif (!empty($info)) {
            $data['product_id'] = $info['product_id'];
            $data['product_name'] = $this->model_provider_provider_delivery->getProductName($info['product_id']);
        } else {
            $data['product_id'] = 0;
            $data['product_name'] = '';
        }



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

        $this->load->model('catalog/product');
        $data['citys'] = $this->model_catalog_product->getCitys();

        $data['city_delivery'] = array();

        if (isset($this->request->post['city_delivery'])) {
            $city_delivery = $this->request->post['city_delivery'];
        } elseif (!empty($info)) {
            $city_delivery = $this->model_provider_provider_delivery->getProductCity($this->request->get['id']);
        } else {
            $city_delivery = array();
        }

        foreach($city_delivery as $city){
            $data['city_delivery'][] = $city;
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

		$this->response->setOutput($this->load->view('provider/provider_delivery_form', $data));
	}
}