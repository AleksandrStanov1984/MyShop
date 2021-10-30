<?php
class ControllerExtensionPaymentPrivatbankPaymentpartsPp extends Controller {
    private $error = array();
    
    public function index() {
        $this->load->language('extension/payment/privatbank_paymentparts_pp');
        
        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('privatbank_paymentparts_pp', $this->request->post);                
        
            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true));
        }

        $data['heading_title'] = $this->language->get('heading_title');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['token'] = $this->session->data['token'];
        
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_paymentparts_url'] = $this->language->get('text_paymentparts_url');
		
		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_order_status'] = $this->language->get('tab_order_status');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_shop_id'] = $this->language->get('entry_shop_id');
		$data['entry_shop_password'] = $this->language->get('entry_shop_password');
		$data['entry_payment_type'] = $this->language->get('entry_payment_type');
		$data['entry_payment_type_standart'] = $this->language->get('entry_payment_type_standart');
		$data['entry_payment_type_hold'] = $this->language->get('entry_payment_type_hold');
		$data['entry_enabled'] = $this->language->get('entry_enabled');
		$data['entry_enabled_cat'] = $this->language->get('entry_enabled_cat');
		$data['entry_enabled_productcard'] = $this->language->get('entry_enabled_productcard');
		$data['entry_enabled_all'] = $this->language->get('entry_enabled_all');
		$data['entry_min_total'] = $this->language->get('entry_min_total');
		$data['entry_max_total'] = $this->language->get('entry_max_total');
		$data['entry_markup'] = $this->language->get('entry_markup');
		$data['entry_paymentquantity'] = $this->language->get('entry_paymentquantity');
		$data['entry_completed_status'] = $this->language->get('entry_completed_status');
		$data['entry_failed_status'] = $this->language->get('entry_failed_status');
		$data['entry_canceled_status'] = $this->language->get('entry_canceled_status');
		$data['entry_rejected_status'] = $this->language->get('entry_rejected_status');
		$data['entry_clientwait_status'] = $this->language->get('entry_clientwait_status');
		$data['entry_created_status'] = $this->language->get('entry_created_status');
		$data['help_paymentquantity'] = $this->language->get('help_paymentquantity');
		$data['help_markup'] = $this->language->get('help_markup');
		$data['help_enabled'] = $this->language->get('help_enabled');
		$data['help_min_total'] = $this->language->get('help_min_total');
		$data['help_max_total'] = $this->language->get('help_max_total');
		$data['help_payment_type'] = $this->language->get('help_payment_type');


        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        
        if (isset($this->error['shop_id'])) {
            $data['error_shop_id'] = $this->error['shop_id'];
        } else {
            $data['error_shop_id'] = '';
        }
        
        if (isset($this->error['shop_password'])) {
            $data['error_shop_password'] = $this->error['shop_password'];
        } else {
            $data['error_shop_password'] = '';
        }                
        
        if (isset($this->error['paymentquantity'])) {
            $data['error_paymentquantity'] = $this->error['paymentquantity'];
        } else {
            $data['error_paymentquantity'] = '';
        }  
		
        $data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true)
		);

        $data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/payment/privatbank_paymentparts_pp', 'token=' . $this->session->data['token'], 'SSL')
        );
                
        $data['action'] = $this->url->link('extension/payment/privatbank_paymentparts_pp', 'token=' . $this->session->data['token'], 'SSL');
        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=payment', true);

        if (isset($this->request->post['privatbank_paymentparts_pp_shop_id'])) {
            $data['privatbank_paymentparts_pp_shop_id'] = $this->request->post['privatbank_paymentparts_pp_shop_id'];
        } else {
            $data['privatbank_paymentparts_pp_shop_id'] = $this->config->get('privatbank_paymentparts_pp_shop_id');
        }

        if (isset($this->request->post['privatbank_paymentparts_pp_shop_password'])) {
            $data['privatbank_paymentparts_pp_shop_password'] = $this->request->post['privatbank_paymentparts_pp_shop_password'];
        } else {
            $data['privatbank_paymentparts_pp_shop_password'] = $this->config->get('privatbank_paymentparts_pp_shop_password');
        }
		
        if (isset($this->request->post['privatbank_paymentparts_pp_hold'])) {
            $data['privatbank_paymentparts_pp_hold'] = $this->request->post['privatbank_paymentparts_pp_hold'];
        } elseif ($this->config->get('privatbank_paymentparts_pp_hold')) {
            $data['privatbank_paymentparts_pp_hold'] = $this->config->get('privatbank_paymentparts_pp_hold');
        } else {
			$data['privatbank_paymentparts_pp_hold'] = 0;
		}
		
        if (isset($this->request->post['privatbank_paymentparts_pp_paymentquantity'])) {
            $data['privatbank_paymentparts_pp_paymentquantity'] = $this->request->post['privatbank_paymentparts_pp_paymentquantity'];
        } elseif  ($this->config->get('privatbank_paymentparts_pp_paymentquantity')) {
            $data['privatbank_paymentparts_pp_paymentquantity'] = $this->config->get('privatbank_paymentparts_pp_paymentquantity');
        } else {
			$data['privatbank_paymentparts_pp_paymentquantity'] = 24;
		}

        if (isset($this->request->post['privatbank_paymentparts_pp_min_total'])) {
            $data['privatbank_paymentparts_pp_min_total'] = $this->request->post['privatbank_paymentparts_pp_min_total'];
        } else {
            $data['privatbank_paymentparts_pp_min_total'] = $this->config->get('privatbank_paymentparts_pp_min_total');
        }

        if (isset($this->request->post['privatbank_paymentparts_pp_max_total'])) {
            $data['privatbank_paymentparts_pp_max_total'] = $this->request->post['privatbank_paymentparts_pp_max_total'];
        } elseif ($this->config->get('privatbank_paymentparts_pp_max_total')) {
            $data['privatbank_paymentparts_pp_max_total'] = $this->config->get('privatbank_paymentparts_pp_max_total');
        } else {
			$data['privatbank_paymentparts_pp_max_total'] = 100000;
		}
		
        if (isset($this->request->post['privatbank_paymentparts_pp_markup'])) {
            $data['privatbank_paymentparts_pp_markup'] = $this->request->post['privatbank_paymentparts_pp_markup'];
        } elseif ($this->config->get('privatbank_paymentparts_pp_markup')) {
            $data['privatbank_paymentparts_pp_markup'] = $this->config->get('privatbank_paymentparts_pp_markup');
        } else {
			$data['privatbank_paymentparts_pp_markup'] = 1.000;
		}

		if (isset($this->request->post['privatbank_paymentparts_pp_geo_zone_id'])) {
			$data['privatbank_paymentparts_pp_geo_zone_id'] = $this->request->post['privatbank_paymentparts_pp_geo_zone_id'];
		} else {
			$data['privatbank_paymentparts_pp_geo_zone_id'] = $this->config->get('privatbank_paymentparts_pp_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
        if (isset($this->request->post['privatbank_paymentparts_pp_status'])) {
            $data['privatbank_paymentparts_pp_status'] = $this->request->post['privatbank_paymentparts_pp_status'];
        } else {
            $data['privatbank_paymentparts_pp_status'] = $this->config->get('privatbank_paymentparts_pp_status');
        }

        if (isset($this->request->post['privatbank_paymentparts_pp_sort_order'])) {
            $data['privatbank_paymentparts_pp_sort_order'] = $this->request->post['privatbank_paymentparts_pp_sort_order'];
        } else {
            $data['privatbank_paymentparts_pp_sort_order'] = $this->config->get('privatbank_paymentparts_pp_sort_order');
        }
		
        if (isset($this->request->post['privatbank_paymentparts_pp_enabled'])) {
            $data['privatbank_paymentparts_pp_enabled'] = $this->request->post['privatbank_paymentparts_pp_enabled'];
        } elseif ($this->config->get('privatbank_paymentparts_pp_enabled')) {
            $data['privatbank_paymentparts_pp_enabled'] = $this->config->get('privatbank_paymentparts_pp_enabled');
        } else {
			$data['privatbank_paymentparts_pp_enabled'] = 0;
		}
		
		if (isset($this->request->post['privatbank_paymentparts_pp_product_allowed'])) {
			$data['privatbank_paymentparts_pp_product_allowed'] = $this->request->post['privatbank_paymentparts_pp_product_allowed'];
		} elseif ($this->config->get('privatbank_paymentparts_pp_product_allowed')) {
			$data['privatbank_paymentparts_pp_product_allowed'] = $this->config->get('privatbank_paymentparts_pp_product_allowed');
		} else {
			$data['privatbank_paymentparts_pp_product_allowed'] = array();
		}

        $this->load->model('catalog/product');
		$data['privatbank_paymentparts_pp_products_allowed'] = array();
		foreach ($data['privatbank_paymentparts_pp_product_allowed'] as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			if ($product_info) {
				$data['privatbank_paymentparts_pp_products_allowed'][] = array(
					'product_id' => $product_info['product_id'],
					'name'        => $product_info['name']
				);
			}
		}

        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
        if (isset($this->request->post['privatbank_paymentparts_pp_completed_status_id'])) {
            $data['privatbank_paymentparts_pp_completed_status_id'] = $this->request->post['privatbank_paymentparts_pp_completed_status_id'];
        } else {
            $data['privatbank_paymentparts_pp_completed_status_id'] = $this->config->get('privatbank_paymentparts_pp_completed_status_id');
        }

        if (isset($this->request->post['privatbank_paymentparts_pp_canceled_status_id'])) {
            $data['privatbank_paymentparts_pp_canceled_status_id'] = $this->request->post['privatbank_paymentparts_pp_canceled_status_id'];
        } else {
            $data['privatbank_paymentparts_pp_canceled_status_id'] = $this->config->get('privatbank_paymentparts_pp_canceled_status_id');
        }

        if (isset($this->request->post['privatbank_paymentparts_pp_clientwait_status_id'])) {
            $data['privatbank_paymentparts_pp_clientwait_status_id'] = $this->request->post['privatbank_paymentparts_pp_clientwait_status_id'];
        } else {
            $data['privatbank_paymentparts_pp_clientwait_status_id'] = $this->config->get('privatbank_paymentparts_pp_clientwait_status_id');
        }

        if (isset($this->request->post['privatbank_paymentparts_pp_created_status_id'])) {
            $data['privatbank_paymentparts_pp_created_status_id'] = $this->request->post['privatbank_paymentparts_pp_created_status_id'];
        } else {
            $data['privatbank_paymentparts_pp_created_status_id'] = $this->config->get('privatbank_paymentparts_pp_created_status_id');
        }

        if (isset($this->request->post['privatbank_paymentparts_pp_failed_status_id'])) {
            $data['privatbank_paymentparts_pp_failed_status_id'] = $this->request->post['privatbank_paymentparts_pp_failed_status_id'];
        } else {
            $data['privatbank_paymentparts_pp_failed_status_id'] = $this->config->get('privatbank_paymentparts_pp_failed_status_id');
        }

        if (isset($this->request->post['privatbank_paymentparts_pp_rejected_status_id'])) {
            $data['privatbank_paymentparts_pp_rejected_status_id'] = $this->request->post['privatbank_paymentparts_pp_rejected_status_id'];
        } else {
            $data['privatbank_paymentparts_pp_rejected_status_id'] = $this->config->get('privatbank_paymentparts_pp_rejected_status_id');
        }

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/privatbank_paymentparts_pp', $data));
    }
    
    public function validate() {
        if (!$this->user->hasPermission('modify', 'extension/payment/privatbank_paymentparts_pp')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['privatbank_paymentparts_pp_shop_id']) {
            $this->error['shop_id'] = $this->language->get('error_shop_id');
        }

        if (!$this->request->post['privatbank_paymentparts_pp_shop_password']) {
            $this->error['shop_password'] = $this->language->get('error_shop_password');
        }

        if ($this->request->post['privatbank_paymentparts_pp_paymentquantity'] > 24) {
            $this->error['paymentquantity'] = $this->language->get('error_paymentquantity');
        }

        return !$this->error;
    }
}

