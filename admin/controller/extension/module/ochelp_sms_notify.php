<?php
class ControllerExtensionModuleOchelpSmsNotify extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/ochelp_sms_notify');

		$this->document->setTitle($this->language->get('heading_main_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('sms_notify', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$data['action'] = $this->url->link('extension/module/ochelp_sms_notify', 'token=' . $this->session->data['token'], true);
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		$data['token'] = $this->session->data['token'];

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_loading'] = $this->language->get('text_loading');
        $data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_phone_placeholder'] = $this->language->get('text_phone_placeholder');

		$data['tab_sms'] = $this->language->get('tab_sms');
		$data['tab_setting'] = $this->language->get('tab_setting');
		$data['tab_gate_setting'] = $this->language->get('tab_gate_setting');
		$data['tab_template'] = $this->language->get('tab_template');
        $data['tab_log'] = $this->language->get('tab_log');
        $data['tab_support'] = $this->language->get('tab_support');

		$data['entry_template'] = $this->language->get('entry_template');
		$data['entry_sms_template'] = $this->language->get('entry_sms_template');
		$data['entry_order_status'] = $this->language->get('entry_order_status');
		$data['entry_admin_alert'] = $this->language->get('entry_admin_alert');
		$data['entry_client_alert'] = $this->language->get('entry_client_alert');
		$data['entry_order_alert'] = $this->language->get('entry_order_alert');

		$data['entry_sms_gatename'] = $this->language->get('entry_sms_gatename');
		$data['entry_sms_from'] = $this->language->get('entry_sms_from');
		$data['entry_sms_to'] = $this->language->get('entry_sms_to');
		$data['entry_sms_copy'] = $this->language->get('entry_sms_copy');
		$data['entry_sms_gate_username'] = $this->language->get('entry_sms_gate_username');
		$data['entry_sms_gate_password'] = $this->language->get('entry_sms_gate_password');
        $data['entry_sms_log'] = $this->language->get('entry_sms_log');

		$data['entry_admin_template'] = $this->language->get('entry_admin_template');
		$data['entry_client_template'] = $this->language->get('entry_client_template');
		$data['entry_order_status_template'] = $this->language->get('entry_order_status_template');
		$data['entry_client_phone'] = $this->language->get('entry_client_phone');
		$data['entry_client_sms'] = $this->language->get('entry_client_sms');

        $data['help_support'] = $this->language->get('help_support');
		$data['help_sms_from'] = $this->language->get('help_sms_from');
		$data['help_sms_copy'] = $this->language->get('help_sms_copy');
		$data['help_phone'] = $this->language->get('help_phone');
		$data['help_admin_template'] = $this->language->get('help_admin_template');
		$data['help_client_template'] = $this->language->get('help_client_template');
		$data['help_order_status'] = $this->language->get('help_order_status');
		$data['help_template'] = $this->language->get('help_template');

		$data['button_send'] = $this->language->get('button_send');
		$data['button_save'] = $this->language->get('button_save');
        $data['button_clear'] = $this->language->get('button_clear');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/ochelp_sms_notify', 'token=' . $this->session->data['token'], true)
		);

		$data['sms_gatenames'] = array();

		$files = glob(DIR_SYSTEM . 'smsgate/*.php');

		foreach ($files as $file) {
			$data['sms_gatenames'][] =  basename($file, '.php');
		}

	    if (isset($this->request->post['sms_notify_gatename'])) {
	      $data['sms_notify_gatename'] = $this->request->post['sms_notify_gatename'];
	    } else {
	      $data['sms_notify_gatename'] = $this->config->get('sms_notify_gatename');
	    }

	    if (isset($this->request->post['sms_notify_to'])) {
	      $data['sms_notify_to'] = $this->request->post['sms_notify_to'];
	    } else {
	      $data['sms_notify_to'] = $this->config->get('sms_notify_to');
	    }

	    if (isset($this->request->post['sms_notify_from'])) {
	      $data['sms_notify_from'] = $this->request->post['sms_notify_from'];
	    } else {
	      $data['sms_notify_from'] = $this->config->get('sms_notify_from');
	    }

	    if (isset($this->request->post['sms_notify_message'])) {
	      $data['sms_notify_message'] = $this->request->post['sms_notify_message'];
	    } else {
	      $data['sms_notify_message'] = $this->config->get('sms_notify_message');
	    }

	    if (isset($this->request->post['sms_notify_gate_username'])) {
	      $data['sms_notify_gate_username'] = $this->request->post['sms_notify_gate_username'];
	    } else {
	      $data['sms_notify_gate_username'] = $this->config->get('sms_notify_gate_username');
	    }

	    if (isset($this->request->post['sms_notify_gate_password'])) {
	      $data['sms_notify_gate_password'] = $this->request->post['sms_notify_gate_password'];
	    } else {
	      $data['sms_notify_gate_password'] = $this->config->get('sms_notify_gate_password');
	    }

	    if (isset($this->request->post['sms_notify_alert'])) {
	      $data['sms_notify_alert'] = $this->request->post['sms_notify_alert'];
	    } else {
	      $data['sms_notify_alert'] = $this->config->get('sms_notify_alert');
	    }

	    if (isset($this->request->post['sms_notify_copy'])) {
	      $data['sms_notify_copy'] = $this->request->post['sms_notify_copy'];
	    } else {
	      $data['sms_notify_copy'] = $this->config->get('sms_notify_copy');
	    }

	    if (isset($this->request->post['sms_notify_admin_alert'])) {
	      $data['admin_alert'] = $this->request->post['sms_notify_admin_alert'];
	    } elseif ($this->config->get('sms_notify_admin_alert')) {
	      $data['admin_alert'] = $this->config->get('sms_notify_admin_alert');
	    } else {
	      $data['admin_alert'] = '';
	    }
	    
	    if (isset($this->request->post['sms_notify_client_alert'])) {
	      $data['client_alert'] = $this->request->post['sms_notify_client_alert'];
	    } elseif ($this->config->get('sms_notify_client_alert')) {
	      $data['client_alert'] = $this->config->get('sms_notify_client_alert');
	    } else {
	      $data['client_alert'] = '';
	    }

	    if (isset($this->request->post['sms_notify_order_alert'])) {
	      $data['order_alert'] = $this->request->post['sms_notify_order_alert'];
	    } elseif ($this->config->get('sms_notify_order_alert')) {
	      $data['order_alert'] = $this->config->get('sms_notify_order_alert');
	    } else {
	      $data['order_alert'] = '';
	    }

		if (isset($this->request->post['sms_notify_admin_template'])) {
			$data['admin_template'] = $this->request->post['sms_notify_admin_template'];
		} elseif ($this->config->get('sms_notify_admin_template')) {
			$data['admin_template'] = $this->config->get('sms_notify_admin_template');
		} else {
			$data['admin_template'] = '';
		}

		if (isset($this->request->post['sms_notify_client_template'])) {
			$data['client_template'] = $this->request->post['sms_notify_client_template'];
		} elseif ($this->config->get('sms_notify_client_template')) {
			$data['client_template'] = $this->config->get('sms_notify_client_template');
		} else {
			$data['client_template'] = '';
		}

	    //CKEditor
	    if ($this->config->get('config_editor_default')) {
	        $this->document->addScript('view/javascript/ckeditor/ckeditor.js');
	        $this->document->addScript('view/javascript/ckeditor/ckeditor_init.js');
	    }

		$data['ckeditor'] = $this->config->get('config_editor_default');

		$data['lang'] = $this->language->get('lang');

		if (isset($this->request->post['sms_notify_sms_template'])) {
			$data['sms_template'] = $this->request->post['sms_notify_sms_template'];
		} elseif ($this->config->get('sms_notify_sms_template')) {
			$data['sms_template'] = html_entity_decode($this->config->get('sms_notify_sms_template'), ENT_QUOTES, 'UTF-8');
		} else {
			$data['sms_template'] = '';
		}

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['sms_notify_status_template'])) {
			$data['order_status_template'] = $this->request->post['sms_notify_status_template'];
		} elseif ($this->config->get('sms_notify_status_template')) {
			$data['order_status_template'] = $this->config->get('sms_notify_status_template');
		} else {
			$data['order_status_template'] = array();
		}

		if (isset($this->request->post['sms_notify_order_status'])) {
			$data['sms_order_status'] = $this->request->post['sms_notify_order_status'];
		} elseif ($this->config->get('sms_notify_order_status')) {
			$data['sms_order_status'] = $this->config->get('sms_notify_order_status');
		} else {
			$data['sms_order_status'] = array();
		}

        if (isset($this->request->post['sms_notify_log'])) {
            $data['sms_notify_log'] = $this->request->post['sms_notify_log'];
        } elseif ($this->config->get('sms_notify_log')) {
            $data['sms_notify_log'] = $this->config->get('sms_notify_log');
        } else {
            $data['sms_notify_log'] = '';
        }

        $data['sms_log'] = '';

        $data['sms_log_filname'] = 'sms_log.log';

		if($this->config->get('sms_notify_log')){
	        $file = DIR_LOGS . $data['sms_log_filname'];

	        if (file_exists($file)) {
	            $size = filesize($file);

	            if ($size >= 5242880) {
	                $suffix = array(
	                    'B',
	                    'KB',
	                    'MB',
	                    'GB',
	                    'TB',
	                    'PB',
	                    'EB',
	                    'ZB',
	                    'YB'
	                );

	                $i = 0;

	                while (($size / 1024) > 1) {
	                    $size = $size / 1024;
	                    $i++;
	                }

	                $data['error_warning'] = sprintf($this->language->get('error_warning'), basename($file), round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i]);
	            } else {
	                $data['sms_log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
	            }
	        }
        }else{
        	$this->clearLog();
        }

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/ochelp_sms_notify', $data));

	}

	public function sendSms() {

			$json = array();


			$this->load->language('extension/module/ochelp_sms_notify');

			$this->load->model('sale/order');
				
			if(isset($this->request->get['order_id'])){
				$order_info = $this->model_sale_order->getOrder($this->request->get['order_id']);
			}else{
				$order_info = array();
			}

			if ((utf8_strlen($this->request->post['sms_message']) < 3)) {
				$json['error'] = $this->language->get('error_sms');
			}

	        if($this->config->get('sms_notify_gatename') && $this->config->get('sms_notify_gate_username')){
		        if ($order_info) {
		            $phone = preg_replace("/[^0-9]/", '', $order_info['telephone']);
		        } elseif ($this->request->post['phone']) {
		            $phone = preg_replace("/[^0-9]/", '', $this->request->post['phone']);
		        } else {
		            $phone = false;
		            $json['error'] = $this->language->get('error_sms');
		        }
	    	}else{
		        $json['error'] = $this->language->get('error_sms_setting');
	    	}
			
			if (!isset($json['error'])) {
				$options = array(
					'to'       => $phone,
					'from'     => $this->config->get('sms_notify_from'),
					'username' => $this->config->get('sms_notify_gate_username'),
					'password' => $this->config->get('sms_notify_gate_password'),
					'message'  => $this->request->post['sms_message']
				);

               $sms = new Sms($this->config->get('sms_notify_gatename'), $options);
                $sms->send();
					
				$json['success'] = $this->language->get('text_success_sms');
			}

		$this->response->setOutput(json_encode($json));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/ochelp_sms_notify')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

    public function clearLog() {

        $json = array();
        
        $this->load->language('extension/module/ochelp_sms_notify');

        if (!$this->user->hasPermission('modify', 'extension/module/ochelp_sms_notify')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
                $file = DIR_LOGS . 'sms_log.log';

                $handle = fopen($file, 'w+');

                fclose($handle);

                $json['success'] = $this->language->get('text_success_log');
        }

        $this->response->setOutput(json_encode($json));
    }
}