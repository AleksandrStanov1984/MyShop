<?php
class ControllerExtensionAnalyticsTSGoogleAnalytics extends Controller {
	private $error = array();
	
	public function index() {
		$extension_path = version_compare(VERSION, '3.0.0', '>=') ? "marketplace" : "extension";
		$token_var_name = version_compare(VERSION, '3.0.0', '>=') ? "user_token" : "token";

		$this->load->language('extension/analytics/ts_google_analytics');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_setting_setting->editSetting('ts_google_analytics', $this->request->post, $this->request->get['store_id']);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link($extension_path . '/extension', $token_var_name . '=' . $this->session->data[$token_var_name] . '&type=analytics', true));
		}
		
		
		$this->document->addScript('view/javascript/tramplin-studio/GoogleAnalytics/GoogleAnalytics.js');
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$data['text_goal_modal'] = $this->language->get('text_goal_modal');
		$data['text_goal_event'] = $this->language->get('text_goal_event');
		$data['text_counter'] = $this->language->get('text_counter');
		
		$data['text_title'] = $this->language->get('text_title');
		$data['text_seconds'] = $this->language->get('text_seconds');
		$data['text_help'] = $this->language->get('text_help');
		$data['text_author'] = $this->language->get('text_author');
		$data['text_copy_to_clipboard'] = $this->language->get('text_copy_to_clipboard');

		$data['tab_main_settings'] = $this->language->get('tab_main_settings');
		$data['tab_userParams'] = $this->language->get('tab_userParams');
		$data['tab_ecommerce'] = $this->language->get('tab_ecommerce');
		$data['tab_goals'] = $this->language->get('tab_goals');
		$data['tab_help'] = $this->language->get('tab_help');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_counter'] = $this->language->get('entry_counter');
		$data['entry_userParams'] = $this->language->get('entry_userParams');
		$data['entry_ecommerce'] = $this->language->get('entry_ecommerce');
		$data['entry_goal'] = $this->language->get('entry_goal');
		
		$data['help_counter'] = $this->language->get('help_counter');
		$data['help_userParams'] = $this->language->get('help_userParams');
		$data['help_ecommerce'] = $this->language->get('help_ecommerce');
		$data['help_goal'] = $this->language->get('help_goal');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_remove'] = $this->language->get('button_remove');

		$data[$token_var_name] = $this->session->data[$token_var_name];
		
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['counter_id'])) {
			$data['error_counter_id'] = $this->error['counter_id'];
		} else {
			$data['error_counter_id'] = '';
		}
		
		if (isset($this->error['timing_name'])) {
			$data['error_timing_name'] = $this->error['timing_name'];
		} else {
			$data['error_timing_name'] = '';
		}
		
		if (isset($this->error['timing_category'])) {
			$data['error_timing_category'] = $this->error['timing_category'];
		} else {
			$data['error_timing_category'] = '';
		}
		
		if (isset($this->error['timing_label'])) {
			$data['error_timing_label'] = $this->error['timing_label'];
		} else {
			$data['error_timing_label'] = '';
		}
		
		if (isset($this->error['link_attr_name'])) {
			$data['error_link_attr_name'] = $this->error['link_attr_name'];
		} else {
			$data['error_link_attr_name'] = '';
		}
		
		if (isset($this->error['link_attr_expires'])) {
			$data['error_link_attr_expires'] = $this->error['link_attr_expires'];
		} else {
			$data['error_link_attr_expires'] = '';
		}
		
		if (isset($this->error['linker_domains'])) {
			$data['error_linker_domains'] = $this->error['linker_domains'];
		} else {
			$data['error_linker_domains'] = array();
		}		
		
		if (isset($this->error['cookie_name'])) {
			$data['error_cookie_name'] = $this->error['cookie_name'];
		} else {
			$data['error_cookie_name'] = '';
		}
		
		if (isset($this->error['cookie_domain'])) {
			$data['error_cookie_domain'] = $this->error['cookie_domain'];
		} else {
			$data['error_cookie_domain'] = '';
		}
		
		if (isset($this->error['cookie_expires'])) {
			$data['error_cookie_expires'] = $this->error['cookie_expires'];
		} else {
			$data['error_cookie_expires'] = '';
		}
		
		if (isset($this->error['ecommerce_revenue_tax'])) {
			$data['error_ecommerce_revenue_tax'] = $this->error['ecommerce_revenue_tax'];
		} else {
			$data['error_ecommerce_revenue_tax'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', $token_var_name . '=' . $this->session->data[$token_var_name], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link($extension_path . '/extension', $token_var_name . '=' . $this->session->data[$token_var_name] . '&type=analytics', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/analytics/ts_google_analytics', $token_var_name . '=' . $this->session->data[$token_var_name] . '&store_id=' . $this->request->get['store_id'], true)
		);

		$data['action'] = $this->url->link('extension/analytics/ts_google_analytics', $token_var_name . '=' . $this->session->data[$token_var_name] . '&store_id=' . $this->request->get['store_id'], true);

		$data['cancel'] = $this->url->link($extension_path . '/extension', $token_var_name . '=' . $this->session->data[$token_var_name] . '&type=analytics', true);

		
		
		if (isset($this->request->post['ts_google_analytics_status'])) {
			$data['ts_google_analytics_status'] = $this->request->post['ts_google_analytics_status'];
		} elseif (!empty($this->config->get('ts_google_analytics_status'))) {
			$data['ts_google_analytics_status'] = $this->model_setting_setting->getSettingValue('ts_google_analytics_status', $this->request->get['store_id']);
		} else {
			$data['ts_google_analytics_status'] = 0;
		}
		
		
		// Main Settings
		
		if (isset($this->request->post['ts_google_analytics_settings'])) {
			$data['ts_google_analytics_settings'] = $this->request->post['ts_google_analytics_settings'];
		} elseif (!empty($this->config->get('ts_google_analytics_settings'))) {
			$data['ts_google_analytics_settings'] = json_decode($this->model_setting_setting->getSettingValue('ts_google_analytics_settings', $this->request->get['store_id']), true);
		} else {
			$data['ts_google_analytics_settings'] = array(
				'counter'				=> array(
					'counter_id'			=> '',
					'type'					=> 'gtag',
					'mode'					=> 0,
					'pageview'				=> array(
						'status'				=> 1,
						'title'					=> 1,
						'path'					=> 1,
						'location'				=> 1,
					),
					'timing'				=> array(
						'status'				=> 1,
						'name'					=> 'load',
						'category'				=> 'JS Dependencies',
						'label'					=> 'Google CDN',
					),
					'link_attr'				=> array(
						'status'				=> 1,
						'name'					=> '_gaela',
						'expires'				=> 120,
					),
					'linker'				=> array(
						'status'				=> 0,
						'incoming'				=> 1,
						'domains'				=> array(''),
					),
					'ad_features'			=> 1,
					'country'				=> 'RU',
					'currency'				=> $this->config->get('config_currency'),
					'userCookies'				=> array(
						'name'					=> '_ga',
						'domain'				=> parse_url(HTTP_SERVER, PHP_URL_HOST),
						'expires'				=> 63072000,
						'update'				=> 1,
					),
				),
				'userParams'			=> array(
					'status'				=> 0,
					'type'					=> 1,
					'group'					=> 1,
					'date_added'			=> 1,
					'safe'					=> 1,
					'newsletter'			=> 1,
					'country'				=> 1,
					'zone'					=> 1,
					'city'					=> 1,
					'postcode'				=> 1,
					'custom_fields'			=> array(),
				),
				'ecommerce'				=> array(
					'status'				=> 0,
					'actionType'			=> array(
						'view'					=> 1,
						'click'					=> 1,
						'detail'				=> 1,
						'add'					=> 1,
						'remove'				=> 1,
						'checkout'				=> 1,
						'purchase'				=> 1,
					),
					'products'				=> array(
						'brand'					=> 1,
						'category'				=> 1,
						'list_name'				=> 1,
						'position'				=> 1,
						'price'					=> 1,
						'quantity'				=> 1,
						'variant'				=> 1,
					),
					'actionField'			=> array(
						'affiliation'			=> 1,
						'revenue'				=> array(
							'status'				=> 1,
							'tax'					=> '',
							'codes'					=> array(),
						),
						'tax'					=> 1,
						'shipping'				=> 1,
						'coupon'				=> 1,
					),
				),
				'goal'			=> array(
					'status'				=> 0
				)
			);
		}
		
		
		// Custom fields
		
		$data['custom_fields'] = array();
		$custom_fields_param_id = 11;
		
		$this->load->language('customer/custom_field');
		$this->load->model('customer/custom_field');
		$results = $this->model_customer_custom_field->getCustomFields( array('sort'  => 'cfd.name', 'order' => 'ASC') );
		
		foreach ($results as $result) {
			if($result['type'] != 'text' && $result['type'] != 'textarea' && $result['type'] != 'file') {
				switch ($result['type']) {
					case 'select':
						$type = $this->language->get('text_select');
						break;
					case 'radio':
						$type = $this->language->get('text_radio');
						break;
					case 'checkbox':
						$type = $this->language->get('text_checkbox');
						break;
					case 'input':
						$type = $this->language->get('text_input');
						break;
					case 'date':
						$type = $this->language->get('text_date');
						break;
					case 'datetime':
						$type = $this->language->get('text_datetime');
						break;
					case 'time':
						$type = $this->language->get('text_time');
						break;
				}
				$data['custom_fields'][] = array(
					'custom_field_id' => $result['custom_field_id'],
					'name'            => $result['name'],
					'type'            => $type,
					'status'          => $result['status'],
					'param_id'        => 'dimension' . $custom_fields_param_id,
					'param_name'      => $this->translit($result['name']),
				);
				$custom_fields_param_id++;
			}
		}
		
		
		// Total codes
		
		$data['total_codes'] = array();
		$files = glob(DIR_APPLICATION . 'controller/extension/total/*.php');
		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');
				$this->load->language('extension/total/' . $extension);
				if ($this->config->get((version_compare(VERSION, '3.0.0', '>=') ? 'total_' : '') . $extension . '_status') && $extension != 'sub_total' && $extension != 'total') {
					$data['total_codes'][] = array(
						'code'       => $extension,
						'name'       => $this->language->get('heading_title'),
					);
				}
			}
		}
		
		
		// Currencies

		$data['currencies'] = array();
		$this->load->model('localisation/currency');
		$results = $this->model_localisation_currency->getCurrencies( array('sort'  => 'code', 'order' => 'ASC') );
		foreach ($results as $result) {
			$data['currencies'][] = $result['code'];
		}
		

		// Countries
		
		$data['countries'] = array();
		$this->load->model('localisation/country');
		$results = $this->model_localisation_country->getCountries( array('sort'  => 'name', 'order' => 'ASC') );
		foreach ($results as $result) {
			$data['countries'][] = array(
				'country_id' => $result['country_id'],
				'name'       => $result['name'],
				'iso_code_2' => $result['iso_code_2'],
				'iso_code_3' => $result['iso_code_3'],
			);
		}		
		
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/analytics/ts_google_analytics', $data));
	}

	public function goals() {
		
		$this->load->model('extension/analytics/ts_google_analytics');
		$this->load->language('extension/analytics/ts_google_analytics');
		
		$this->goalsList();
		
	}

	public function goalAdd() {
		
		$this->load->model('extension/analytics/ts_google_analytics');
		$this->load->language('extension/analytics/ts_google_analytics');
		
		$this->request->post['data'] = json_decode(htmlspecialchars_decode(stripslashes($this->request->post['data'])), true);
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateGoal()) {
			$data['goal_id'] = $this->model_extension_analytics_ts_google_analytics->addGoal($this->request->post['data']);
		}
		
		if (isset($this->error['error'])) {
			$data['error'] = $this->error['error'];
		} else {
			$data['success'] = $this->language->get('success_goal')['add'];
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
	}

	public function goalEdit() {
		
		$this->load->model('extension/analytics/ts_google_analytics');
		$this->load->language('extension/analytics/ts_google_analytics');
		
		$this->request->post['data'] = json_decode(htmlspecialchars_decode(stripslashes($this->request->post['data'])), true);
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateGoal() && isset($this->request->get['goal_id'])) {
			$this->model_extension_analytics_ts_google_analytics->editGoal($this->request->get['goal_id'], $this->request->post['data']);
		}
		
		if (isset($this->error['error'])) {
			$data['error'] = $this->error['error'];
		} else {
			$data['success'] = $this->language->get('success_goal')['edit'];
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
	}

	public function goalDelete() {
		
		$this->load->model('extension/analytics/ts_google_analytics');
		$this->load->language('extension/analytics/ts_google_analytics');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateGoalDelete() && isset($this->request->get['goal_id'])) {
			$this->model_extension_analytics_ts_google_analytics->deleteGoal($this->request->get['goal_id']);
			
			$data['pages'] = ceil($this->model_extension_analytics_ts_google_analytics->getTotalGoals() / $this->config->get('config_limit_admin'));
		}
		
		if (isset($this->error['error'])) {
			$data['error'] = $this->error['error'];
		} else {
			$data['success'] = $this->language->get('success_goal')['delete'];
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
	}

	private function goalsList() {
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'g.goal_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$total_goals = $this->model_extension_analytics_ts_google_analytics->getTotalGoals();
		$pages = ceil($total_goals / $this->config->get('config_limit_admin'));
		$page = ($page > $pages) ? $pages : $page;
		
		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin'),
		);
		
		$results = $this->model_extension_analytics_ts_google_analytics->getGoals($filter_data);
		
		foreach ($results as $result) {
			$data['goals'][] = array(
				'goal_id'		=> $result['goal_id'],
				'action'		=> $result['action'],
				'category'		=> $result['category'],
				'label'			=> $result['label'],
				'element'		=> $result['element'],
				'event'			=> $result['event'],
				'value'			=> $result['value'],
			);
		}
		
		$data['goals_pages'] = $pages;
		$data['goals_page'] = $page;
		
		$data['results'] = sprintf($this->language->get('text_pagination'), ($total_goals) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($total_goals - $this->config->get('config_limit_admin'))) ? $total_goals : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $total_goals, ceil($total_goals / $this->config->get('config_limit_admin')));

		$data['currency_default'] = !empty($this->config->get('ts_google_analytics_settings')['counter']['currency']) ? $this->config->get('ts_google_analytics_settings')['counter']['currency'] : $this->config->get('config_currency');
		
		$data['text_goal'] = $this->language->get('text_goal');
		$data['text_copy_to_clipboard'] = $this->language->get('text_copy_to_clipboard');
		
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_remove'] = $this->language->get('button_remove');
				
		$this->response->setOutput($this->load->view('extension/analytics/ts_google_analytics_goals', $data));
	}

	public function install() {
		if ($this->validate()) {
			$this->load->model('extension/analytics/ts_google_analytics');
			$this->model_extension_analytics_ts_google_analytics->install();
		}
	}
	
	public function uninstall() {
		if ($this->validate()) {
			$this->load->model('extension/analytics/ts_google_analytics');
			$this->model_extension_analytics_ts_google_analytics->uninstall();
		}
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/analytics/ts_google_analytics')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		return !$this->error;
	}
	
	protected function validateForm() {
		$error_warning = '';
		
		if (!$this->user->hasPermission('modify', 'extension/analytics/ts_google_analytics')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!preg_match('/[A-Z]{2}-[0-9]+(-|)[0-9]{0,2}/', $this->request->post['ts_google_analytics_settings']['counter']['counter_id'])) {
			$this->error['counter_id'] = $this->language->get('error_counter_id');
			$error_warning .= ($error_warning ? '<br><i class="fa fa-exclamation-circle"></i> ' : '') . $this->language->get('error_counter_id');
		}
		
		if ((int)$this->request->post['ts_google_analytics_settings']['counter']['timing']['status']) {
			if ((utf8_strlen($this->request->post['ts_google_analytics_settings']['counter']['timing']['name']) < 3) || (utf8_strlen($this->request->post['ts_google_analytics_settings']['counter']['timing']['name']) > 32)) {
				$this->error['timing_name'] = $this->language->get('error_timing_name');
				$error_warning .= ($error_warning ? '<br><i class="fa fa-exclamation-circle"></i> ' : '') . $this->language->get('error_timing_name');
			}
			if ((utf8_strlen($this->request->post['ts_google_analytics_settings']['counter']['timing']['category']) > 0) && ((utf8_strlen($this->request->post['ts_google_analytics_settings']['counter']['timing']['category']) < 3) || (utf8_strlen($this->request->post['ts_google_analytics_settings']['counter']['timing']['category']) > 64))) {
				$this->error['timing_category'] = $this->language->get('error_timing_category');
				$error_warning .= ($error_warning ? '<br><i class="fa fa-exclamation-circle"></i> ' : '') . $this->language->get('error_timing_category');
			}
			if ((utf8_strlen($this->request->post['ts_google_analytics_settings']['counter']['timing']['label']) > 0) && ((utf8_strlen($this->request->post['ts_google_analytics_settings']['counter']['timing']['label']) < 3) || (utf8_strlen($this->request->post['ts_google_analytics_settings']['counter']['timing']['label']) > 255))) {
				$this->error['timing_label'] = $this->language->get('error_timing_label');
				$error_warning .= ($error_warning ? '<br><i class="fa fa-exclamation-circle"></i> ' : '') . $this->language->get('error_timing_label');
			}
		}
		if ((int)$this->request->post['ts_google_analytics_settings']['counter']['link_attr']['status']) {
			if ((utf8_strlen($this->request->post['ts_google_analytics_settings']['counter']['link_attr']['name']) < 3) || (utf8_strlen($this->request->post['ts_google_analytics_settings']['counter']['link_attr']['name']) > 32)) {
				$this->error['link_attr_name'] = $this->language->get('error_link_attr_name');
				$error_warning .= ($error_warning ? '<br><i class="fa fa-exclamation-circle"></i> ' : '') . $this->language->get('error_link_attr_name');
			}
			if ((int)$this->request->post['ts_google_analytics_settings']['counter']['link_attr']['expires'] < 0) {
				$this->error['link_attr_expires'] = $this->language->get('error_link_attr_expires');
				$error_warning .= ($error_warning ? '<br><i class="fa fa-exclamation-circle"></i> ' : '') . $this->language->get('error_link_attr_expires');
			}
		}
		
		if ((int)$this->request->post['ts_google_analytics_settings']['counter']['linker']['status']) {
			$this->request->post['ts_google_analytics_settings']['counter']['linker']['domains'] = $this->parseLinkerDomains($this->request->post['ts_google_analytics_settings']['counter']['linker']['domains']);
			foreach ($this->request->post['ts_google_analytics_settings']['counter']['linker']['domains'] as $did => $domain) {
				if ($domain && (!preg_match('/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i', $domain) || !preg_match('/^[^\.]{2,63}(\.[^\.]{2,63})*$/', $domain))) {
					$this->error['linker_domains'][$did] = $this->language->get('error_linker_domains');
					$error_warning .= ($error_warning ? '<br><i class="fa fa-exclamation-circle"></i> ' : '') . $this->language->get('error_linker_domains') . ' - "' . $domain . '"';
				}
			}
		}
		
		if ((utf8_strlen($this->request->post['ts_google_analytics_settings']['counter']['userCookies']['name']) < 3) || (utf8_strlen($this->request->post['ts_google_analytics_settings']['counter']['userCookies']['name']) > 32)) {
			$this->error['cookie_name'] = $this->language->get('error_cookie_name');
			$error_warning .= ($error_warning ? '<br><i class="fa fa-exclamation-circle"></i> ' : '') . $this->language->get('error_cookie_name');
		}
		
		if (utf8_strlen($this->request->post['ts_google_analytics_settings']['counter']['userCookies']['domain'])) {
			$this->request->post['ts_google_analytics_settings']['counter']['userCookies']['domain'] = trim($this->request->post['ts_google_analytics_settings']['counter']['userCookies']['domain']);
			if (!preg_match('/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i', $this->request->post['ts_google_analytics_settings']['counter']['userCookies']['domain']) || !preg_match('/^[^\.]{2,63}(\.[^\.]{2,63})*$/', $this->request->post['ts_google_analytics_settings']['counter']['userCookies']['domain']) || strpos(HTTP_SERVER, $this->request->post['ts_google_analytics_settings']['counter']['userCookies']['domain'])===false) {
				$this->error['cookie_domain'] = $this->language->get('error_cookie_domain');
				$error_warning .= ($error_warning ? '<br><i class="fa fa-exclamation-circle"></i> ' : '') . $this->language->get('error_cookie_domain');
			}
		}
		if ((int)$this->request->post['ts_google_analytics_settings']['counter']['userCookies']['expires'] < 0) {
			$this->error['cookie_expires'] = $this->language->get('error_cookie_expires');
			$error_warning .= ($error_warning ? '<br><i class="fa fa-exclamation-circle"></i> ' : '') . $this->language->get('error_cookie_expires');
		}
		
		if (((float)$this->request->post['ts_google_analytics_settings']['ecommerce']['actionField']['revenue']['tax'] < 0) || ((float)$this->request->post['ts_google_analytics_settings']['ecommerce']['actionField']['revenue']['tax'] > 99)) {
			$this->error['ecommerce_revenue_tax'] = $this->language->get('error_ecommerce_revenue_tax');
			$error_warning .= ($error_warning ? '<br><i class="fa fa-exclamation-circle"></i> ' : '') . $this->language->get('error_ecommerce_revenue_tax');
		}
		
		if ($error_warning) {
			$this->error['warning'] = $error_warning;
		}
		
		return !$this->error;
	}
	
	protected function validateGoal() {
		if (!$this->user->hasPermission('modify', 'extension/analytics/ts_google_analytics')) {
			$this->error['error'] = $this->language->get('error_permission');
		}
		
		if ((float)$this->request->post['data']['value'] < 0) {
			$this->error['error'] = $this->language->get('error_goal')['value'];
		}
		
		if ((utf8_strlen($this->request->post['data']['element']) < 2) || (utf8_strlen($this->request->post['data']['element']) > 255)) {
			$this->error['error'] = $this->language->get('error_goal')['element'];
		}
		
		if ((utf8_strlen($this->request->post['data']['label']) > 0) && ((utf8_strlen($this->request->post['data']['label']) < 3) || (utf8_strlen($this->request->post['data']['label']) > 255))) {
			$this->error['error'] = $this->language->get('error_goal')['label'];
		}
		
		if ((utf8_strlen($this->request->post['data']['category']) > 0) && ((utf8_strlen($this->request->post['data']['category']) < 3) || (utf8_strlen($this->request->post['data']['category']) > 64))) {
			$this->error['error'] = $this->language->get('error_goal')['category'];
		}
		
		if ((utf8_strlen($this->request->post['data']['action']) < 3) || (utf8_strlen($this->request->post['data']['action']) > 64)) {
			$this->error['error'] = $this->language->get('error_goal')['action_size'];
		}
		
		if (preg_match('/[^0-9a-z_]/i', $this->request->post['data']['action'])) {
			$this->error['error'] = $this->language->get('error_goal')['action_format'];
		}
		
		if ($this->model_extension_analytics_ts_google_analytics->checkGoal($this->request->post['data']['action']) && strtolower($this->request->post['data']['goal_action']) == 'add') {
			$this->error['error'] = $this->language->get('error_goal')['action_exists'];
		}
		
		return !$this->error;
	}
	
	protected function validateGoalDelete() {
		if (!$this->user->hasPermission('modify', 'extension/analytics/ts_google_analytics')) {
			$this->error['error'] = $this->language->get('error_permission');
		}
		
		return !$this->error;
	}
	
	protected function parseLinkerDomains($domains) {
		foreach ($domains as $did => $domain) {
			if (substr($domain, 0, 4) == 'http') {
				$domains[$did] = parse_url($domain, PHP_URL_HOST);
			}
			$domains[$did] = trim($domains[$did]);
			if ($domains[$did] == '') {
				unset($domains[$did]);
			}
		}
		if (!$domains) {
			$domains = array('');
		}
		$domains = array_values($domains);
		
		return $domains;
	}
	
	private function translit($s) {
		$s = trim($s);
		$s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s);
		$s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
		$s = preg_replace('/[^0-9a-z_ ]/i', '', $s);
		$s = preg_replace('/\s+/', ' ', $s);
		$s = preg_replace('/\s/', '_', $s);
		
		return $s;
	}
	
}