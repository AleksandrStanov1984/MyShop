<?php
class ControllerAccountRegister extends Controller {
	private $error = array();

	public function index() {
		if ($this->customer->isLogged()) {
			$this->response->redirect($this->url->link('account/account', '', true));
		}

		$this->load->language('account/register');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/locale/'.$this->session->data['language'].'.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

		$this->load->model('account/customer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			
			$json = array();

			// генерируем случайный 4-х значный код
			$secret_code = '';
			while(strlen($secret_code) < 4) {
			    $secret_code .= rand(0,9);
			}

			$password = time();

			// записываем данные о пользователе в базу данных
			$data_customer = array(
				'telephone'				=> $this->request->post['telephone'],
				'firstname'				=> '',
				'lastname'				=> '',
				'email'						=> $this->request->post['telephone'] . '@localhost.ru',
				'fax'							=> '',
				'password'				=> $password,
				'company'					=> '',
				'address_1'				=> '',
				'address_2'				=> '',
				'city'						=> '',
				'postcode'				=> '',
				'country_id'			=> 0,
				'zone_id'					=> 0
			);

			$json['data_customer'] = $data_customer;

			$data['rememberme_enable'] = $this->config->get('rememberme_enable');
			if ($data['rememberme_enable']) {
				if ($this->config->get('rememberme_shadow')) {
					$this->request->post['rememberme'] = 1;
				}
			}
			
			//$customer_id = $this->model_account_customer->addCustomer($data_customer);

			// Clear any previous login attempts for unregistered accounts.
			//$this->model_account_customer->deleteLoginAttempts($this->request->post['telephone']);

			//$this->customer->login($this->request->post['telephone'], $password, false, true);

			//unset($this->session->data['guest']);

			// Add to activity log
			/*if ($this->config->get('config_customer_activity')) {
				$this->load->model('account/activity');

				$activity_data = array(
					'customer_id' => $customer_id,
					'name'        => $this->request->post['telephone']
				);

				$this->model_account_activity->addActivity('register', $activity_data);
			}*/


			//$this->response->redirect($this->url->link('account/success'));
			//$this->response->addHeader('Content-Type: application/json');
			//$this->response->setOutput(json_encode($json));
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
			'text' => $this->language->get('text_register'),
			'href' => $this->url->link('account/register', '', true)
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_account_already'] = sprintf($this->language->get('text_account_already'), $this->url->link('account/login', '', true));
		$data['text_your_details'] = $this->language->get('text_your_details');
		$data['text_your_address'] = $this->language->get('text_your_address');
		$data['text_your_password'] = $this->language->get('text_your_password');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_fax'] = $this->language->get('entry_fax');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_address_1'] = $this->language->get('entry_address_1');
		$data['entry_address_2'] = $this->language->get('entry_address_2');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_newsletter'] = $this->language->get('entry_newsletter');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_confirm'] = $this->language->get('entry_confirm');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_upload'] = $this->language->get('button_upload');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}

		$data['action'] = $this->url->link('account/register', '', true);

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} else {
			$data['telephone'] = '';
		}			

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('register', (array)$this->config->get('config_captcha_page'))) {
			$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'), $this->error);
		} else {
			$data['captcha'] = '';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/register', $data));
	}

	private function validate() {

			// проверяем что ввел пользователь (телефон или email)
			if(stristr($this->request->post['telephone'], '@') !== FALSE) {

				if ((utf8_strlen($this->request->post['telephone']) > 96) || !preg_match($this->config->get('config_mail_regexp'), $this->request->post['telephone'])) {
					$this->error['email'] = $this->language->get('error_email');
				}

				if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['telephone'])) {
					$this->error['warning'] = $this->language->get('error_exists');
				}

			} else {

				if((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
					$this->error['telephone'] = $this->language->get('error_telephone');
				}

				$telephone = preg_replace('/[^0-9]/','',$this->request->post['telephone']);
				$telephone = preg_replace('/^(7|8)([0-9]{10})$/','7$2',$telephone);
				$telephone = preg_replace('/^(380)([0-9]{9})$/','380$2',$telephone);

				if(!preg_match('/^(7)([0-9]{10})$/',$telephone) && !preg_match('/^(380)([0-9]{9})$/',$telephone)){
					$this->error['telephone'] = $this->language->get('error_telephone_format');
				}

				$time = strtotime('-2 minutes');
				if(isset($this->session->data['restore_pass']) && date('Y-m-d H:i:s',$time) < $this->session->data['restore_pass']){
					$this->error['warning'] = 'Пожалуйста дождитесь смс, или попробуйте через 2 минуты после предыдущей попытки!';
					$this->request->post['email'] = '';
				}

				// выдает ошибку
				/*if ($this->model_account_customer->getTotalCustomersByTelephone($this->request->post['telephone'])) {
					$this->error['warning'] = $this->language->get('error_exists');
				}*/
			}

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('register', (array)$this->config->get('config_captcha_page'))) {
			$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');

			if ($captcha) {
				$this->error['captcha'] = $captcha;
			}
		}

		return !$this->error;
	}

	public function sendCode() {
		$json = array();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			// генерируем случайный 4-х значный код
			$secret_code = '';
			while(strlen($secret_code) < 4) {
			    $secret_code .= rand(0,9);
			}

			// отправляем смс пользователю

			// записываем пароль в базу данных
			// сохраняем время когда отправлен пароль
			$this->session->data['restore_pass'] = date('Y-m-d H:i:s');
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function ApproveCode($code) {
		$json = array();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			// генерируем случайный 4-х значный код
			$secret_code = '';
			while(strlen($secret_code) < 4) {
			    $secret_code .= rand(0,9);
			}

			// отправляем смс пользователю
			
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function addCustomer() {
		$json = array();

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			// генерируем случайный 4-х значный код
			$secret_code = '';
			while(strlen($secret_code) < 4) {
			    $secret_code .= rand(0,9);
			}

			$password = time();

			// записываем данные о пользователе в базу данных
			$data_customer = array(
				'telephone'				=> $this->request->post['telephone'],
				'firstname'				=> '',
				'lastname'				=> '',
				'email'						=> $this->request->post['telephone'] . '@localhost.ru',
				'fax'							=> '',
				'password'				=> $password,
				'company'					=> '',
				'address_1'				=> '',
				'address_2'				=> '',
				'city'						=> '',
				'postcode'				=> '',
				'country_id'			=> 0,
				'zone_id'					=> 0,
				'sms_code'				=> $secret_code
			);

			$json['data_customer'] = $data_customer;
			
			//$customer_id = $this->model_account_customer->addCustomer($data_customer);

			// Clear any previous login attempts for unregistered accounts.
			//$this->model_account_customer->deleteLoginAttempts($this->request->post['telephone']);

			//$this->customer->login($this->request->post['telephone'], $password, false, true);

			//unset($this->session->data['guest']);

			// Add to activity log
			/*if ($this->config->get('config_customer_activity')) {
				$this->load->model('account/activity');

				$activity_data = array(
					'customer_id' => $customer_id,
					'name'        => $this->request->post['telephone']
				);

				$this->model_account_activity->addActivity('register', $activity_data);
			}*/


			//$this->response->redirect($this->url->link('account/success'));
			//$this->response->addHeader('Content-Type: application/json');
			//$this->response->setOutput(json_encode($json));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}