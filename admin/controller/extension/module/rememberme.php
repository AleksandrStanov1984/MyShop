<?php
class ControllerExtensionModuleRememberMe extends Controller {
	private $error = array();
	public function index() {
		$this->load->language('extension/module/rememberme');
		$this->config->load('rememberme');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('rememberme', $this->request->post);		
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/module/rememberme', 'token=' . $this->session->data['token'], true));
		}
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else if (isset($this->session->data['error']) ) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		}
		else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/extension', 'type=module&token=' . $this->session->data['token'], true),
		);
	
		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_title'),
			'href'      => $this->url->link('extension/module/rememberme', 'token=' . $this->session->data['token'], true),
		);


		if (isset($this->request->post['rememberme_enable'])) {
			$data['rememberme_enable'] = $this->request->post['rememberme_enable'];
		} else {
			$data['rememberme_enable'] = $this->config->get('rememberme_enable');
		}

		if (isset($this->request->post['rememberme_expires'])) {
			$data['rememberme_expires'] = $this->request->post['rememberme_expires'];
		} else {
			$data['rememberme_expires'] = $this->config->get('rememberme_expires');
		}

		if (isset($this->request->post['rememberme_shadow'])) {
			$data['rememberme_shadow'] = $this->request->post['rememberme_shadow'];
		} else {
			$data['rememberme_shadow'] = $this->config->get('rememberme_shadow');
		}

		if (isset($this->request->post['rememberme_default'])) {
			$data['rememberme_default'] = $this->request->post['rememberme_default'];
		} else {
			$data['rememberme_default'] = $this->config->get('rememberme_default');
		}

		$data['action'] = $this->url->link('extension/module/rememberme', 'token=' . $this->session->data['token'], true);
		$data['cancel'] = $this->url->link('extension/extension', 'type=module&token=' . $this->session->data['token'], true);

		$data['heading_title']             = $this->language->get('heading_title');
		$data['yes']                       = $this->language->get('text_yes');
		$data['no']                        = $this->language->get('text_no');
		$data['entry_status']              = $this->language->get('entry_status');
		$data['entry_expires']             = $this->language->get('entry_expires');
		$data['entry_shadow']              = $this->language->get('entry_shadow');
		$data['entry_default']             = $this->language->get('entry_default');
		$data['button_save']               = $this->language->get('button_save');
		$data['button_cancel']             = $this->language->get('button_cancel');
		$data['text_edit']                 = $this->language->get('text_edit');
		$data['help_shadow']               = $this->language->get('help_shadow');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/rememberme', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/rememberme')) {
			$this->error['warning'] = $this->language->get('text_error_access');
		}
				
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

	public function install() {
		$sql = "
			CREATE TABLE IF NOT EXISTS `" .DB_PREFIX . "auth_tokens` ( 
				`id` integer(11) not null AUTO_INCREMENT, 
				`selector` char(12), 
				`token` char(64), 
				`customer_id` integer(11) not null, 
				`expires` datetime, 
				PRIMARY KEY (`id`) ) 
				ENGINE=InnoDB";
		$this->db->query($sql);
		
	}

	public function uninstall() {
		$sql = "DROP TABLE IF EXISTS `" . DB_PREFIX . "auth_tokens`";
		$this->db->query($sql);
	}
}