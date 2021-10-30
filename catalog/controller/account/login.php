<?php
class ControllerAccountLogin extends Controller {
	private $error = array();

	public function index() {
		$this->load->model('account/customer');
		$this->load->model('account/wishlist');

		$this->document->addScript('catalog/view/theme/OPC080193_6/js/maskedinput.js');
		$this->document->addStyle('ccatalog/view/theme/OPC080193_6/css/account_style.css');
		$this->document->addStyle('catalog/view/theme/OPC080193_6/css/bootstrap-grid.min.css');


		// Login override for admin users
		if (!empty($this->request->get['token'])) {
			$this->customer->logout();
			$this->cart->clear();

			unset($this->session->data['order_id']);
			unset($this->session->data['payment_address']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['shipping_address']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['comment']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);

			$customer_info = $this->model_account_customer->getCustomerByToken($this->request->get['token']);

			if ($customer_info && $this->customer->login($customer_info['email'], '', true)) {
				// Default Addresses
				$this->load->model('account/address');

				if ($this->config->get('config_tax_customer') == 'payment') {
					$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
				}

				if ($this->config->get('config_tax_customer') == 'shipping') {
					$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
				}
				//$this->response->redirect($this->url->link('account/account', '', true));
				$this->response->redirect($this->url->link('account/edit', '', true));
			}
		}

		if ($this->customer->isLogged()) {
			$this->response->redirect($this->url->link('account/edit', '', true));
		}

		$this->load->language('account/login');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			// приводим телефон к нужному формату
			if(isset($this->request->post['telephone'])) {
				$telephone = preg_replace('/[^0-9]/','',$this->request->post['telephone']);
				$telephone = preg_replace('/^(7|8)([0-9]{10})$/','7$2',$telephone);
				$telephone = preg_replace('/^(380)([0-9]{9})$/','380$2',$telephone);
			}

			if(!isset($this->session->data['verify'])) {

				$this->sendCode($telephone);

			} else {

				unset($this->session->data['verify']);

				$email = $telephone . '@localhost.ru';

				//добавляем польщователя в базу
				if(isset($this->session->data['user_register'])) {

					// записываем данные о пользователе в базу данных
					$data_customer = array(
						'telephone'				=> $telephone,
						'firstname'				=> $this->request->post['firstname'],
						'lastname'				=> '',
						'email'						=> $email,
						'fax'							=> '',
						'password'				=> time(),
						'company'					=> '',
						'address_1'				=> '',
						'address_2'				=> '',
						'city'						=> '',
						'postcode'				=> '',
						'country_id'			=> 0,
						'zone_id'					=> 0
					);

					$customer_id = $this->model_account_customer->addCustomer($data_customer);

					// удаляем данные из таблицы customers_login
					$this->model_account_customer->clearCode($telephone);

					// Clear any previous login attempts for unregistered accounts.
					$this->model_account_customer->deleteLoginAttempts($telephone);

					// выполняем вход пользователя
					$this->customer->login($email, $telephone, false, false);

					// Wishlist
					if (isset($this->session->data['wishlist']) && is_array($this->session->data['wishlist'])) {
						$this->load->model('account/wishlist');

						foreach ($this->session->data['wishlist'] as $key => $product_id) {
							$this->model_account_wishlist->addWishlist($product_id);

							unset($this->session->data['wishlist'][$key]);
						}
					}

					unset($this->session->data['guest']);

					if(isset($this->session->data['user_register'])) unset($this->session->data['user_register']);
					if(isset($this->session->data['restore_pass'])) unset($this->session->data['restore_pass']);

					// Add to activity log
					if ($this->config->get('config_customer_activity')) {
						$this->load->model('account/activity');

						$activity_data = array(
							'customer_id' => $customer_id,
							'name'        => $this->customer->getFirstName()
						);

						$this->model_account_activity->addActivity('register', $activity_data);
					}

					$this->response->redirect($this->url->link('account/edit'));

				} else { // иначе просто логинимся


					$this->customer->login($email, $telephone, false, false);

					// Unset guest
					unset($this->session->data['guest']);
					if(isset($this->session->data['user_login'])) unset($this->session->data['user_login']);
					if(isset($this->session->data['restore_pass'])) unset($this->session->data['restore_pass']);

					// удаляем данные из таблицы customers_login
					$this->model_account_customer->clearCode($telephone);

					// Default Shipping Address
					$this->load->model('account/address');

					if ($this->config->get('config_tax_customer') == 'payment') {
						$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
					}

					if ($this->config->get('config_tax_customer') == 'shipping') {
						$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
					}

					// Wishlist
					if (isset($this->session->data['wishlist']) && is_array($this->session->data['wishlist'])) {
						$this->load->model('account/wishlist');

						foreach ($this->session->data['wishlist'] as $key => $product_id) {
							$this->model_account_wishlist->addWishlist($product_id);

							unset($this->session->data['wishlist'][$key]);
						}
					}

					// Add to activity log
					if ($this->config->get('config_customer_activity')) {
						$this->load->model('account/activity');

						$activity_data = array(
							'customer_id' => $this->customer->getId(),
							'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
						);

						$this->model_account_activity->addActivity('login', $activity_data);

						// Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
						if (isset($this->request->post['redirect']) && $this->request->post['redirect'] != $this->url->link('account/logout', '', true) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {
							$this->response->redirect(str_replace('&amp;', '&', $this->request->post['redirect']));
						} else {
							//$this->response->redirect($this->url->link('account/account', '', true));
							$this->response->redirect($this->url->link('account/edit', '', true));
						}
					}
					//$this->response->redirect($this->url->link('account/account', '', true));
					$this->response->redirect($this->url->link('account/edit', '', true));

				}


			}

			/*if (!$this->customer->login($email, $telephone, false, false)) {
				$this->model_account_customer->addLoginAttempt($this->request->post['email']);
			} else {
				$this->model_account_customer->deleteLoginAttempts($this->request->post['email']);
			}*/

			if(isset($this->session->data['error_code'])) unset($this->session->data['error_code']);
			if(isset($this->session->data['warning'])) unset($this->session->data['warning']);

		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_account'),
			'href' => $this->url->link('account/account', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_login'),
			'href' => $this->url->link('account/login', '', true)
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_new_customer'] = $this->language->get('text_new_customer');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_register_account'] = $this->language->get('text_register_account');
		$data['text_returning_customer'] = $this->language->get('text_returning_customer');
		$data['text_i_am_returning_customer'] = $this->language->get('text_i_am_returning_customer');
		$data['text_forgotten'] = $this->language->get('text_forgotten');
		$data['text_error_time'] = $this->language->get('error_time_vefify');

		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_telephone_placeholder'] = $this->language->get('entry_telephone_placeholder');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['text_specify_code'] = $this->language->get('text_specify_code');
		$data['text_restore_code'] = $this->language->get('text_restore_code');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_login'] = $this->language->get('button_login');
		$data['button_register'] = $this->language->get('button_register');
		$data['button_send_sms'] = $this->language->get('button_send_sms');
		$data['entry_name'] = $this->language->get('entry_name');
		$this->load->language('account/rememberme');
		$data['text_rememberme'] = $this->language->get('text_rememberme');
		$data['rememberme_enable'] = $this->config->get('rememberme_enable');
		$data['rememberme_default'] = $this->config->get('rememberme_default');

		if (isset($this->session->data['warning'])) {
			$data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} elseif (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['error_code'])) {
			$data['error_code'] = $this->session->data['error_code'];
			unset($this->session->data['error_code']);
		} elseif (isset($this->error['error_code'])) {
			$data['error_code'] = $this->error['error_code'];
		} else {
			$data['error_code'] = '';
		}

		$data['action'] = $this->url->link('account/login', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['forgotten'] = $this->url->link('account/forgotten', '', true);

		// Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
		if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {
			$data['redirect'] = $this->request->post['redirect'];
		} elseif (isset($this->session->data['redirect'])) {
			$data['redirect'] = $this->session->data['redirect'];

			unset($this->session->data['redirect']);
		} else {
			$data['redirect'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->session->data['user_register'])) {
			$data['user_register'] = true;
			unset($this->session->data['user_register']);
		} else {
			$data['user_register'] = false;
		}

		if (isset($this->session->data['user_login'])) {
			$data['user_login'] = true;
			unset($this->session->data['user_login']);
		} else {
			$data['user_login'] = false;
		}

		if (isset($this->session->data['restore_pass']) && $this->approveSend()) {
			$data['restore_pass'] = $this->approveSend();
			/*if($this->approveSend()) {
				$data['restore_pass'] = $this->approveSend();
			} else {
				$data['restore_pass'] = 0;
			}*/

		} else {
			$data['restore_pass'] = 0;
		}


		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
			$data['text_where_number_send'] = sprintf($this->language->get('text_where_number_send'), $this->request->post['telephone']);
		} else {
			$data['telephone'] = '';
			$data['text_where_number_send'] = false;
		}

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} else {
			$data['firstname'] = '';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/login', $data));
	}

	public function verifyCode($phone, $code) {

		// сверяем проверочный код
		$this->load->model('account/customer');
		$verify_code = $this->model_account_customer->getCode($phone);
		if((int)$code == (int)$verify_code) $approve = $this->model_account_customer->approveCustomer($phone); else $approve = false;

		return $approve;
	}

	private function approveSend() {

		if(isset($this->session->data['restore_pass']) && time() - strtotime($this->session->data['restore_pass'])  <= 120 ) {

			$different_time = strtotime($this->session->data['restore_pass']) - strtotime('-2 minutes');
			return $different_time;

		} else {
			return false;
		}

	}

	public function sendCode($phone) {

		$this->load->model('account/customer');

		// генерируем случайный 4-х значный код
		$secret_code = '';
		$i=0;
		while(strlen($secret_code) < 4) {
				if($i == 0) $secret_code .= rand(1,9); else $secret_code .= rand(0,9);
		    $i++;
		}

		// записываем пароль в базу данных
		$saveCode = $this->model_account_customer->addCode($phone, $secret_code);

		// отправляем смс пользователю
		$send = $this->sendSMS($phone, $secret_code);
		$send = false;
		if($send) $this->session->data['warning'] = $send;

		// сохраняем время когда отправлен пароль
		$this->session->data['restore_pass'] = date('Y-m-d H:i:s');

		return $secret_code;
	}

	public function sendSMS($phone, $code) {

		if($this->config->get('sms_notify_gatename') && $this->config->get('sms_notify_gate_username')){
        if ($phone) {
            $phone = preg_replace("/[^0-9]/", '', $phone);
        } else {
            return $this->language->get('error_sms');
        }
  	}else{
       return $this->language->get('error_sms_setting');
  	}

		$options = array(
			'to'       => $phone,
			'from'     => $this->config->get('sms_notify_from'),
			'username' => $this->config->get('sms_notify_gate_username'),
			'password' => $this->config->get('sms_notify_gate_password'),
			'message'  => sprintf($this->language->get('text_message'), $code)
		);

    $sms = new Sms($this->config->get('sms_notify_gatename'), $options);
    $sms->send();

	}

	public function restoreCode() {
		$json = array();
		$this->load->model('account/customer');
		$this->load->language('account/login');

		if($this->approveSend()) {
			$json['error'] =  $this->language->get('error_time_verify');
		} else {

			$telephone = preg_replace('/[^0-9]/','',$this->request->post['telephone']);
			$telephone = preg_replace('/^(7|8)([0-9]{10})$/','7$2',$telephone);
			$telephone = preg_replace('/^(380)([0-9]{9})$/','380$2',$telephone);

			// генерируем случайный 4-х значный код
			$secret_code = '';
			$i=0;
			while(strlen($secret_code) < 4) {
					if($i == 0) $secret_code .= rand(1,9); else $secret_code .= rand(0,9);
			    $i++;
			}

			// записываем пароль в базу данных
			$saveCode = $this->model_account_customer->addCode($telephone, $secret_code);

			// отправляем смс пользователю
			$send = $this->sendSMS($telephone, $secret_code);
			if($send) $this->session->data['warning'] = $send;
			// сохраняем время когда отправлен пароль
			$this->session->data['restore_pass'] = date('Y-m-d H:i:s');

			if(!$saveCode) {
				$json['success'] = 'Код успешно отправлен';
				$json['restore_pass'] = 120;
			} else {
				$json['error'] = 'Код не отправлен';
			}

		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	private function checkUser($login) {
		$this->load->model('account/customer');
		$check = $this->model_account_customer->getCustomerByEmailOrPhone($login);
		return $check;
	}

	protected function validate() {

		// приводим телефон к нужному формату
		$telephone = preg_replace('/[^0-9]/','',$this->request->post['telephone']);
		$telephone = preg_replace('/^(7|8)([0-9]{10})$/','7$2',$telephone);
		$telephone = preg_replace('/^(380)([0-9]{9})$/','380$2',$telephone);


		// проверяем телефон
		if(utf8_strlen($telephone) < 5) {
			$this->error['warning'] = $this->language->get('error_telephone');
			$this->session->data['warning'] = $this->language->get('error_telephone');
		} elseif(!preg_match('/^(7)([0-9]{10})$/',$telephone) && !preg_match('/^(380)([0-9]{9})$/',$telephone) || utf8_strlen($telephone) != 12){
			$this->error['warning'] = $this->language->get('error_telephone_format');
			$this->session->data['warning'] = $this->language->get('error_telephone_format');
		}

		// Проверяем количество попыток входа
		$login_info = $this->model_account_customer->getLoginAttempts($telephone);

		if (!$this->error && $login_info && ($login_info['total'] >= $this->config->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
			$this->error['warning'] = $this->language->get('error_attempts');
			$this->session->data['warning'] = $this->language->get('error_attempts');
		}

		// Проверяем есть ли данный пользоваетль в базе
		$customer_info = $this->model_account_customer->getCustomerByEmailOrPhone($telephone);

		if (!$this->error && !$customer_info || $customer_info && !$customer_info['approved']) {
			// Если пользователя нету в базе выводим форму для ввода имени
			$this->session->data['user_register'] = true;

		} elseif(!$this->error) {
			$this->session->data['user_login'] = true;
		}


		// проверяем имя пользователя если оно было отправленно
		if(isset($this->request->post['firstname'])) {

			if((utf8_strlen($this->request->post['firstname']) < 3) || (utf8_strlen($this->request->post['firstname']) > 32)) {
				$this->error['warning'] = $this->language->get('error_firstname');
				$this->session->data['warning'] = $this->language->get('error_firstname');
			}

		}

		// если нету ошибок и передан код пользователем
		if(!$this->error && isset($this->request->post['code'])) {

			if( utf8_strlen($this->request->post['code']) != 4 || utf8_strlen($this->request->post['code']) != 4 && utf8_strlen($this->request->post['code']) < 5)  {
				$this->error['error_code'] = $this->language->get('error_code');
				$this->session->data['error_code'] = $this->language->get('error_code');
			}

			// проверяем код
			$check_code = $this->verifyCode($telephone, $this->request->post['code']);
			if(!$check_code) {
				$this->error['warning'] = $this->language->get('error_code_verify');
				$this->session->data['error_warning'] = $this->language->get('error_code_verify');
				if(isset($this->session->data['verify'])) unset($this->session->data['verify']);
			} else {
				$this->session->data['verify'] = true;
			}

		} elseif(!$this->error && $this->approveSend()) {
			$this->error['warning'] = $this->language->get('error_time_verify');
			$this->session->data['warning'] = $this->language->get('error_time_verify');
		}

		return !$this->error;
	}
}
