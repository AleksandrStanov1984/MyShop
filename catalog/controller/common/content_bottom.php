<?php
class ControllerCommonContentBottom extends Controller {
	public function index() {
		$this->load->model('design/layout');

		if (isset($this->request->get['route'])) {
			$route = (string)$this->request->get['route'];
		} else {
			$route = 'common/home';
		}

		$layout_id = 0;

		if ($route == 'product/category' && isset($this->request->get['path'])) {
			$this->load->model('catalog/category');

			$path = explode('_', (string)$this->request->get['path']);

			$layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));
		}

		if ($route == 'product/product' && isset($this->request->get['product_id'])) {
			$this->load->model('catalog/product');
			$product_page = true;
			$layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
		}

		if ($route == 'newsblog/category' && isset($this->request->get['newsblog_path'])) {
      $this->load->model('newsblog/category');

      $path = explode('_', (string)$this->request->get['newsblog_path']);

      $layout_id = $this->model_newsblog_category->getCategoryLayoutId(end($path));
    }

    if ($route == 'newsblog/article' && isset($this->request->get['newsblog_article_id'])) {
      $this->load->model('newsblog/article');

      $layout_id = $this->model_newsblog_article->getArticleLayoutId($this->request->get['newsblog_article_id']);
    }

		if ($route == 'information/information' && isset($this->request->get['information_id'])) {
			$this->load->model('catalog/information');

			$layout_id = $this->model_catalog_information->getInformationLayoutId($this->request->get['information_id']);
		}

		if (!$layout_id) {
			$layout_id = $this->model_design_layout->getLayout($route);
		}

		if (!$layout_id) {
			$layout_id = $this->config->get('config_layout_id');
		}

		$this->load->model('extension/module');

		$data['modules'] = array();

		$modules = $this->model_design_layout->getLayoutModules($layout_id, 'content_bottom');

		$data['owlmodules'] = array();

		foreach ($modules as $module) {
			$part = explode('.', $module['code']);

			if (isset($part[0]) && $this->config->get($part[0] . '_status')) {

				if(isset($product_page)) {

					if($part[0] != 'owlcarousel') {

						$module_data = $this->load->controller('extension/module/' . $part[0]);

						if ($module_data) {
							$data['modules'][] = $module_data;
						}

					} 

				} else {

						$module_data = $this->load->controller('extension/module/' . $part[0]);

						if ($module_data) {
							$data['modules'][] = $module_data;
						}

				}

				// исключаем вывод данных модуля по умолчанию для страницы товара
				
				
			}

			if (isset($part[1])) {

				// исключаем вывод данных модуля по умолчанию для страницы товара
				if(isset($product_page)) {

					if($part[0] != 'owlcarousel') {

						$setting_info = $this->model_extension_module->getModule($part[1]);

						if ($setting_info && $setting_info['status']) {
							$output = $this->load->controller('extension/module/' . $part[0], $setting_info);

							if ($output) {
								$data['modules'][] = $output;
							}
						}

					} else {
						// перечень module_id на странице товара
						$data['owlmodules'][] = $part[1];
					}

				} else {

					$setting_info = $this->model_extension_module->getModule($part[1]);

					if ($setting_info && $setting_info['status']) {
						$output = $this->load->controller('extension/module/' . $part[0], $setting_info);

						if ($output) {
							$data['modules'][] = $output;
						}
					}
					
				}
				
			}
		}

		// данные для запроса ajax
		if (isset($this->request->get['product_id'])) {
        $data['product_id'] = (int)$this->request->get['product_id'];
    } else {
        $data['product_id'] = 0;
    }

		return $this->load->view('common/content_bottom', $data);
	}
}
