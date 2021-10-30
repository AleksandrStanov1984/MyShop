<?php
class ControllerExtensionFeedFassetFilter extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/feed/fasset_filter');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('fasset_filter', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=feed', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_data_feed'] = $this->language->get('entry_data_feed');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_generate'] = $this->language->get('button_generate');

		$data['tab_general'] = $this->language->get('tab_general');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=feed', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/feed/fasset_filter', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/feed/fasset_filter', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=feed', true);

		if (isset($this->request->post['fasset_filter_status'])) {
			$data['fasset_filter_status'] = $this->request->post['fasset_filter_status'];
		} else {
			$data['fasset_filter_status'] = $this->config->get('fasset_filter_status');
		}

		//$data['data_feed'] = HTTP_CATALOG . 'index.php?route=extension/feed/fasset_filter&key=secure27u56';
		$data['data_feed'] = HTTP_CATALOG . 'anyqueryfacets.csv';

		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/feed/fasset_filter', $data));
	}

	public function generateFilters() {
    $json = array();

    $this->load->language('extension/feed/fasset_filter');

    if ($this->request->server['REQUEST_METHOD'] == 'POST') {
    	$this->load->model('catalog/category');
      $this->load->model('extension/feed/fasset_filter');

      $fp = fopen(DIR_ROOT.'anyqueryfacets.csv', 'w');

      $heading = array('categoryId','attribute','type','order');
      fputcsv($fp, $heading, ';');

      //получаем список категорий
      $categories = $this->model_catalog_category->getCategories();
      foreach($categories as $category) {
      		$filters = $this->model_extension_feed_fasset_filter->getFilters($category['category_id']);

      		foreach ($filters as $key => $value) {
      			fputcsv($fp, array($category['category_id'], $key, 'DISTINCT', $value), ';','"','"');
      		}  		

      }

      fclose($fp);   

      $file = DIR_ROOT.'anyqueryfacets.csv';
			$output = '';
			if (file_exists($file)) {
				$output .= preg_replace('/(?<=^|;)"(.+)"(?=;)/','$1',file_get_contents($file));
			}   

			file_put_contents($file, $output);

      $json['success'] = $this->language->get('text_complete');
    }

		$this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/feed/fasset_filter')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}