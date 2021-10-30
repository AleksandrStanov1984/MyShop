<?php
class ControllerExtensionModuleUserLog extends Controller {
	private $error = array();
	private $data = array();
	
	public function index() {
		$this->load->language('extension/module/user_log');
		$this->load->model('extension/module/user_log');
		$this->document->addStyle('view/stylesheet/user_log.css?ver=1');

		$this->document->setTitle(strip_tags($this->language->get('heading_title')));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate_()) {
			$this->model_setting_setting->editSetting('user_log', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
        	if (isset($this->request->get['apply'])) {
				$this->response->redirect($this->url->link('extension/module/user_log', 'token=' . $this->session->data['token'], true));
			} else {
				$this->response->redirect($this->url->link('extension/extension', 'type=module&token=' . $this->session->data['token'], true));
			}
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] =  $this->session->data['success'];
			unset($this->session->data['success']);
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_form'] = $this->language->get('text_form');

		$this->data['tab_settings'] = $this->language->get('tab_settings');
		$this->data['tab_help'] = $this->language->get('tab_help');

		$this->data['text_description'] = $this->language->get('text_description');
		$this->data['text_help'] = $this->language->get('text_help');

		$this->data['button_save_quit'] = $this->language->get('button_save_quit');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_clear'] = $this->language->get('button_clear');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_view_log'] = $this->language->get('button_view_log');

		$this->data['text_no_results'] = $this->language->get('text_no_results');



		$this->data['entry_user_log_enable']  = $this->language->get('entry_user_log_enable');
		$this->data['entry_user_log_enable_help']  = $this->language->get('entry_user_log_enable_help');
		$this->data['entry_user_log_login']   = $this->language->get('entry_user_log_login');
		$this->data['entry_user_log_login_help']   = $this->language->get('entry_user_log_login_help');
		$this->data['entry_user_log_logout']  = $this->language->get('entry_user_log_logout');
		$this->data['entry_user_log_logout_help']  = $this->language->get('entry_user_log_logout_help');
		$this->data['entry_user_log_failedlog']  = $this->language->get('entry_user_log_failedlog');
		$this->data['entry_user_log_failedlog_help']  = $this->language->get('entry_user_log_failedlog_help');
		$this->data['entry_user_log_access']  = $this->language->get('entry_user_log_access');
		$this->data['entry_user_log_access_help']  = $this->language->get('entry_user_log_access_help');
		$this->data['entry_user_log_modify']  = $this->language->get('entry_user_log_modify');
		$this->data['entry_user_log_modify_help']  = $this->language->get('entry_user_log_modify_help');
		$this->data['entry_user_log_allowed'] = $this->language->get('entry_user_log_allowed');
		$this->data['entry_user_log_display'] = $this->language->get('entry_user_log_display');
		$this->data['entry_log_day'] = $this->language->get('entry_log_day');

		$this->data['text_enabled']  = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');

		$this->data['text_denied']  = $this->language->get('text_denied');
		$this->data['text_allowed'] = $this->language->get('text_allowed');
		$this->data['text_all'] = $this->language->get('text_all');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');


		if (isset($this->request->post['user_log_enable'])) {
			$this->data['user_log_enable'] = $this->request->post['user_log_enable'];
		} else {
			$this->data['user_log_enable'] = $this->config->get('user_log_enable');
		}

		if (isset($this->request->post['user_log_day'])) {
			$this->data['user_log_day'] = $this->request->post['user_log_day'];
		} else {
			$this->data['user_log_day'] = $this->config->get('user_log_day');
		}
		
		if (isset($this->request->post['user_log_login'])) {
			$this->data['user_log_login'] = $this->request->post['user_log_login'];
		} else {
			$this->data['user_log_login'] = $this->config->get('user_log_login');
		}

		if (isset($this->request->post['user_log_logout'])) {
			$this->data['user_log_logout'] = $this->request->post['user_log_logout'];
		} else {
			$this->data['user_log_logout'] = $this->config->get('user_log_logout');
		}

		if (isset($this->request->post['user_log_failed'])) {
			$this->data['user_log_failed'] = $this->request->post['user_log_failed'];
		} else {
			$this->data['user_log_failed'] = $this->config->get('user_log_failed');
		}

		if (isset($this->request->post['user_log_access'])) {
			$this->data['user_log_access'] = $this->request->post['user_log_access'];
		} else {
			$this->data['user_log_access'] = $this->config->get('user_log_access');
		}

		if (isset($this->request->post['user_log_access_list'])) {
			$this->data['user_log_access_list'] = $this->request->post['user_log_access_list'];
		} elseif ($this->config->has('user_log_access_list')) {
			$this->data['user_log_access_list'] = $this->config->get('user_log_access_list');
		} else {
			$this->data['user_log_access_list'] = array();
		}
		
		if (isset($this->request->post['user_log_modify'])) {
			$this->data['user_log_modify'] = $this->request->post['user_log_modify'];
		} else {
			$this->data['user_log_modify'] = $this->config->get('user_log_modify');
		}

		if (isset($this->request->post['user_log_modify_list'])) {
			$this->data['user_log_modify_list'] = $this->request->post['user_log_modify_list'];
		} elseif ($this->config->has('user_log_modify_list')) {
			$this->data['user_log_modify_list'] = $this->config->get('user_log_modify_list');
		} else {
			$this->data['user_log_modify_list'] = array();
		}

		if (isset($this->request->post['user_log_allowed'])) {
			$this->data['user_log_allowed'] = $this->request->post['user_log_allowed'];
		} else {
			$this->data['user_log_allowed'] = $this->config->get('user_log_allowed');
		}

		if (isset($this->request->post['user_log_display'])) {
			$this->data['user_log_display'] = $this->request->post['user_log_display'];
		} elseif ($this->config->get('user_log_display')) {
			$this->data['user_log_display'] = $this->config->get('user_log_display');
		} else {
			$this->data['user_log_display'] = 50;
		}

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->load->model('user/user');
		$this->data['users'] = $this->model_user_user->getUsers(); 

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/extension', 'type=module&token=' . $this->session->data['token'], true),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/module/user_log', 'token=' . $this->session->data['token'], true),
      		'separator' => ' :: '
   		);

		$this->data['action_apply'] = $this->url->link('extension/module/user_log', 'apply=1&token=' . $this->session->data['token'], true);
		$this->data['action'] = $this->url->link('extension/module/user_log', 'token=' . $this->session->data['token'], true);
		$this->data['view_log'] = $this->url->link('tool/user_log', 'token=' . $this->session->data['token'], true);
		
		$this->data['cancel'] = $this->url->link('extension/extension', 'type=module&token=' . $this->session->data['token'], true);

		$this->template = 'extension/module/user_log.tpl';
		$this->data['header'] = $this->load->controller('common/header');
		$this->data['column_left'] = $this->load->controller('common/column_left');
		$this->data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/user_log', $this->data));
	}

	private function validate() {
		if (!$this->user->hasPermission('access', 'extension/module/user_log')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	private function validate_() {
		if (!$this->user->hasPermission('modify', 'extension/module/user_log')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function install(){
		$this->load->model('extension/module/user_log');
		$this->model_extension_module_user_log->install();
	}

	public function uninstall(){
		$this->load->model('extension/module/user_log');
		$this->model_extension_module_user_log->uninstall();
	}
}