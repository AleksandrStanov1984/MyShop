<?php
class ControllerExtensionModuleCategory extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/category');
		/* gulp add */
		//$this->document->addStyle('catalog/view/theme/OPC080193_6/css/category_mod_style.css');
        $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/category_mod_style.css?ver1.3');
        /* gulp add */
		$data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['category_id'] = $parts[0];
		} else {
			$data['category_id'] = 0;
		}

		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}
		$cat_id = (int)array_pop($parts);
		$data['cat_id'] = $cat_id;
		$parent_category = (int)array_pop($parts);

		$parent_category_info = $this->model_catalog_category->getCategory($parent_category);
		/*if ( $_SERVER['REMOTE_ADDR'] == '91.124.217.173') {
		var_dump($parent_category_info); die;
		}*/
		$data['parent_category_name'] = $parent_category_info['name'];
		$data['parent_category_href'] = $this->url->link('product/category', 'path=' . $parent_category);

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories($parent_category);

		foreach ($categories as $category) {
			$children_data = array();

			$children = $this->model_catalog_category->getCategories($category['category_id']);

			foreach ($children as $child) {
				$filter_data = array(
					'filter_category_id'  => $child['category_id'],
					'filter_sub_category' => true
				);

				$children_data[] = array(
					'category_id' => $child['category_id'],
					'name'        => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
					'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
				);
			}

			$filter_data = array(
				'filter_category_id'  => $category['category_id'],
				'filter_sub_category' => true
			);

			$data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
				'children'    => $children_data,
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);
		}

		return $this->load->view('extension/module/category', $data);
	}
}
