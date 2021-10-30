<?php
class ControllerExtensionShippingCouriersz extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/shipping/courier_sz');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
        $this->load->model('tool/courier_sz');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('courier_sz', $this->request->post);

            $this->model_tool_courier_sz->addCiteCouriersz($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

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
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/shipping/courier_sz', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/shipping/courier_sz', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true);

        $this->load->model('catalog/product');

        $data['citys'] = $this->model_catalog_product->getCitys();

        $data['courier_sz_product_city'] = array();

       $product_citys = $this->model_tool_courier_sz->getCitesCouriersz();

        foreach($product_citys as $product_city){
            $data['courier_sz_product_city'][] = $product_city['name'];
        }

        if (isset($this->request->post['courier_sz_status'])) {
			$data['courier_sz_status'] = $this->request->post['courier_sz_status'];
		} else {
			$data['courier_sz_status'] = $this->config->get('courier_sz_status');
		}

		if (isset($this->request->post['courier_sz_sort_order'])) {
			$data['courier_sz_sort_order'] = $this->request->post['courier_sz_sort_order'];
		} else {
			$data['courier_sz_sort_order'] = $this->config->get('courier_sz_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/shipping/courier_sz', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/shipping/courier_sz')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}