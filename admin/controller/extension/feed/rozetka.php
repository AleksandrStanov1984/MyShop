<?php
class ControllerExtensionFeedRozetka extends Controller {

	private $error = array();

	public function index() {
		$this->load->language('extension/feed/rozetka');

		$this->document->setTitle($this->language->get('heading_title'));		

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			if (isset($this->request->post['rozetka_categories'])) {
				$this->request->post['rozetka_categories'] = implode(',', $this->request->post['rozetka_categories']);
			}

			$this->model_setting_setting->editSetting('rozetka', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=feed', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_data_feed'] = $this->language->get('entry_data_feed');
		$data['entry_shopname'] = $this->language->get('entry_shopname');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_currency'] = $this->language->get('entry_currency');
		$data['entry_in_stock'] = $this->language->get('entry_in_stock');
		$data['entry_out_of_stock'] = $this->language->get('entry_out_of_stock');
		$data['entry_delivery_name'] = $this->language->get('entry_delivery_name');
		
		$data['help_delivery_name'] = $this->language->get('help_delivery_name');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], true),
			'text'      => $this->language->get('text_home'),
			'separator' => FALSE
		);

		$data['breadcrumbs'][] = array(
			'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token']. '&type=feed', true),
			'text'      => $this->language->get('text_feed'),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'href'      => $this->url->link('extension/feed/yml', 'token=' . $this->session->data['token'], true),
			'text'      => $this->language->get('heading_title'),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link('extension/feed/rozetka', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true);
		if (isset($this->request->post['rozetka_percent_markup'])) {
		  	$data['rozetka_percent_markup'] = $this->request->post['rozetka_percent_markup'];
		} elseif (($this->config->get('rozetka_percent_markup')!== false) && !is_null($this->config->get('rozetka_percent_markup'))) {
			$data['rozetka_percent_markup'] = $this->config->get('rozetka_percent_markup');
		} else {
			$data['rozetka_percent_markup'] = 0;
		} 
		$data['hint_rozetka_percent_markup'] = $this->language->get('hint_rozetka_percent_markup');
		$data['entry_rozetka_percent_markup'] = $this->language->get('entry_rozetka_percent_markup');

		if (isset($this->request->post['rozetka_percent_special_markup'])) {
		  	$data['rozetka_percent_special_markup'] = $this->request->post['rozetka_percent_special_markup'];
		} elseif (($this->config->get('rozetka_percent_special_markup')!== false) && !is_null($this->config->get('rozetka_percent_special_markup'))) {
			$data['rozetka_percent_special_markup'] = $this->config->get('rozetka_percent_special_markup');
		} else {
			$data['rozetka_percent_special_markup'] = 0;
		} 
		$data['hint_rozetka_percent_special_markup'] = $this->language->get('hint_rozetka_percent_special_markup');
		$data['entry_rozetka_percent_special_markup'] = $this->language->get('entry_rozetka_percent_special_markup');

		if (isset($this->request->post['rozetka_markup_round_decimals'])) {
		  	$data['rozetka_markup_round_decimals'] = $this->request->post['rozetka_markup_round_decimals'];
		} elseif (($this->config->get('rozetka_markup_round_decimals')!== false) && !is_null($this->config->get('rozetka_markup_round_decimals'))) {
			$data['rozetka_markup_round_decimals'] = $this->config->get('rozetka_markup_round_decimals');
		} else {
			$data['rozetka_markup_round_decimals'] = 2;
		} 
		$data['hint_rozetka_markup_round_decimals'] = $this->language->get('hint_rozetka_markup_round_decimals');
		$data['entry_rozetka_markup_round_decimals'] = $this->language->get('entry_rozetka_markup_round_decimals');
				

		if (isset($this->request->post['rozetka_status'])) {
			$data['rozetka_status'] = $this->request->post['rozetka_status'];
		} else {
			$data['rozetka_status'] = $this->config->get('rozetka_status');
		}

		$data['entry_data_prom_feed'] = $this->language->get('entry_data_prom_feed');
		//$data['data_prom_feed'] = HTTP_CATALOG . 'index.php?route=extension/feed/prom_ua';
		//$data['data_feed'] = HTTP_CATALOG . 'index.php?route=extension/feed/rozetka';
		$data['data_prom_feed'] = HTTP_CATALOG . 'xml_export/prom.xml';
		$data['data_feed'] = HTTP_CATALOG . 'xml_export/rozetka.xml';

		if (isset($this->request->post['rozetka_shopname'])) {
			$data['rozetka_shopname'] = $this->request->post['rozetka_shopname'];
		} else {
			$data['rozetka_shopname'] = $this->config->get('rozetka_shopname');
		}

		if (isset($this->request->post['rozetka_company'])) {
			$data['rozetka_company'] = $this->request->post['rozetka_company'];
		} else {
			$data['rozetka_company'] = $this->config->get('rozetka_company');
		}

		if (isset($this->request->post['rozetka_currency'])) {
			$data['rozetka_currency'] = $this->request->post['rozetka_currency'];
		} else {
			$data['rozetka_currency'] = $this->config->get('rozetka_currency');
		}

		if (isset($this->request->post['rozetka_in_stock'])) {
			$data['rozetka_in_stock'] = $this->request->post['rozetka_in_stock'];
		} elseif ($this->config->get('rozetka_in_stock')) {
			$data['rozetka_in_stock'] = $this->config->get('rozetka_in_stock');
		} else {
			$data['rozetka_in_stock'] = 7;
		}

		if (isset($this->request->post['rozetka_out_of_stock'])) {
			$data['rozetka_out_of_stock'] = $this->request->post['rozetka_out_of_stock'];
		} elseif ($this->config->get('rozetka_in_stock')) {
			$data['rozetka_out_of_stock'] = $this->config->get('rozetka_out_of_stock');
		} else {
			$data['rozetka_out_of_stock'] = 5;
		}
		
		// rozetka_delivery_name
		if (isset($this->request->post['rozetka_delivery_desc'])) {
			$data['rozetka_delivery_desc'] = $this->request->post['rozetka_delivery_desc'];
		} else {
			$data['rozetka_delivery_desc'] = $this->config->get('rozetka_delivery_desc');
		}
		// rozetka_delivery_name

		$this->load->model('localisation/stock_status');

		$data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

		$this->load->model('catalog/category');

		$data['categories'] = $this->model_catalog_category->getCategories(0);

		if (isset($this->request->post['rozetka_categories'])) {
			$data['rozetka_categories'] = $this->request->post['rozetka_categories'];
		} elseif ($this->config->get('rozetka_categories') != '') {
			$data['rozetka_categories'] = explode(',', $this->config->get('rozetka_categories'));
		} else {
			$data['rozetka_categories'] = array();
		}

		$this->load->model('localisation/currency');
		$currencies = $this->model_localisation_currency->getCurrencies();
		// $allowed_currencies = array_flip(array('RUR', 'RUB', 'BYR', 'KZT', 'UAH', 'USD', 'EUR'));
		$allowed_currencies = array_flip(array('UAH'));
		$data['currencies'] = array_intersect_key($currencies, $allowed_currencies);
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('extension/feed/rozetka', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/feed/rozetka')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>
