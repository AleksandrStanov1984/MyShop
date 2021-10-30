<?php
class ControllerCatalogAttributeColor extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/attribute_color');

		$this->document->setTitle('Палитра цветов');

		$this->load->model('catalog/attribute_color');

		$this->getList();
	}
	
	
	public function save() {
		
		$color = $this->db->escape(trim($this->request->get['color'],';').';');
		$text = $this->db->escape(trim($this->request->get['text'],';'));
		
		if(trim(trim($color),';') == ''){
			$sql = "DELETE FROM " . DB_PREFIX . "attribute_color WHERE text = '".$text."'";
		}else{
			$sql = "INSERT INTO " . DB_PREFIX . "attribute_color SET text = '".$text."',
				color = '".$color."',
				attribute_id = '".(int)$this->request->get['attribute_id']."'
				ON DUPLICATE KEY UPDATE color = '".trim($color)."'";
			//echo $sql;
		}
		$this->db->query($sql);
		
		
	}

	protected function getList() {
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Палитра цветов',
			'href' => $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/attribute_color/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/attribute_color/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['attributes'] = array();
	
		$results = $this->model_catalog_attribute_color->groupAttributeColorValue();

		foreach ($results as $result) {
			$data['attributes'][$result['value_key']][] = $result['text'];
		}
		
		foreach ($data['attributes'] as $index => $result) {
			
			$text = implode(';', $result);
			
			$data['attributes'][$index]['text'] = $text;
			$data['attributes'][$index]['color'] = $this->model_catalog_attribute_color->getColorInfo($text);
		}
		
		
		$data['token'] = $this->session->data['token'];
		
		$data['heading_title'] = 'Палитра цветов';

		$data['text_list'] = 'Список цветов';
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_attribute_group'] = $this->language->get('column_attribute_group');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . '&sort=ad.name' . $url, true);
		$data['sort_attribute_group'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . '&sort=attribute_group' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . '&sort=a.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		$pagination = new Pagination();
		$pagination->total = $attribute_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($attribute_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($attribute_total - $this->config->get('config_limit_admin'))) ? $attribute_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $attribute_total, ceil($attribute_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/attribute_color', $data));
	}

	
	
}
