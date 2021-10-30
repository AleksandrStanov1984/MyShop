<?php

require_once(DIR_SYSTEM . "/engine/neoseo_controller.php");

class ControllerExtensionFeedNeoSeoProductFeed extends NeoSeoController
{

	private $error = array();

	public function __construct($registry)
	{
		parent::__construct($registry);
		$this->_moduleSysName = "neoseo_product_feed";
		$this->_logFile = $this->_moduleSysName . ".log";
		$this->debug = $this->config->get($this->_moduleSysName . "_debug") == 1;
	}

	public function index()
	{
		$this->checkLicense();

		$data = $this->language->load('extension/feed/' . $this->_moduleSysName);

		$this->document->setTitle($this->language->get('heading_title_raw'));

		$this->load->model('setting/setting');
		$this->load->model('extension/feed/' . $this->_moduleSysName);
		$this->load->model('extension/feed/' . $this->_moduleSysName . '_formats');
		$this->load->model('extension/feed/' . $this->_moduleSysName . '_categories');
		$this->load->model('extension/feed/' . $this->_moduleSysName . '_update_relations');
		$this->load->model('tool/' . $this->_moduleSysName);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$settings_array = array();
			$settings_array[$this->_moduleSysName . "_status"] = $this->request->post[$this->_moduleSysName . "_status"];
			$settings_array[$this->_moduleSysName . "_debug"] = $this->request->post[$this->_moduleSysName . "_debug"];
			$settings_array[$this->_moduleSysName . "_type"] = $this->request->post[$this->_moduleSysName . "_type"];

			$this->model_setting_setting->editSetting($this->_moduleSysName, $settings_array);

			$this->session->data['success'] = $this->language->get('text_success_options'); //add data of saved feed

			if ($this->request->post['action'] == "save") {
				$this->response->redirect($this->url->link('extension/feed/' . $this->_moduleSysName, 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->model_extension_feed_neoseo_product_feed->upgrade();
		$this->model_extension_feed_neoseo_product_feed_formats->upgrade();
		$this->model_extension_feed_neoseo_product_feed_categories->upgrade();
		$this->model_extension_feed_neoseo_product_feed_update_relations->upgrade();

		$data = $this->initParamsList(array(
			"status",
			"debug",
			"type",
		    ), $data);

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else if (isset($this->session->data['error_warning'])) {
			$data['error_warning'] = $this->session->data['error_warning'];
			unset($this->session->data['error_warning']);
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		}

		$data = $this->initBreadcrumbs(array(
			array('extension/feed/', "text_feed"),
			array('extension/feed/' . $this->_moduleSysName, "heading_title_raw")
		    ), $data);

		$data = $this->initButtons($data);

		$data['token'] = $this->session->data['token'];
		$data["cron"] = "php " . realpath(DIR_SYSTEM . "../cron/" . $this->_moduleSysName . ".php");
		$data[$this->_moduleSysName . "_cron"] = "php " . realpath(DIR_SYSTEM . "../cron/" . $this->_moduleSysName . ".php");
		// Start formation list exports
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = '';
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

		$url = '';
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$sort_data = array('sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $this->config->get('config_limit_admin'), 'limit' => $this->config->get('config_limit_admin'));
		$feeds_total = $this->model_tool_neoseo_product_feed->getTotalFeeds();

		$results = $this->model_tool_neoseo_product_feed->getListFeeds($sort_data);

		foreach ($results as $id => $feed) {
			$item = array(
				'product_feed_id' => $feed['product_feed_id'],
				'feed_name' => $feed['feed_name'],
				'id_format' => $feed['id_format'],
				'status' => $feed['status'],
				'image_width' => $feed['image_width'],
				'use_categories' => $feed['use_categories'],
				'image_height' => $feed['image_height'],
				'feed_demand' => rtrim(HTTP_CATALOG, "/") . "/index.php?route=extension/feed/" . $this->_moduleSysName . "&name=" . $feed["feed_shortname"],
				'feed_cron' => rtrim(HTTP_CATALOG, "/") . "/system/storage/download/" . $feed["feed_shortname"] . ".xml",
				'feed_cron_file' => rtrim(DIR_DOWNLOAD, "/") . "/" . $feed["feed_shortname"] . ".xml",
				'edit' => $this->url->link('extension/feed/' . $this->_moduleSysName . '/editFeed', 'token=' . $this->session->data['token'] . '&product_feed_id=' . $feed['product_feed_id'] . $url, 'SSL'),
				'delete' => $this->url->link('extension/feed/' . $this->_moduleSysName . '/deleteFeed', 'token=' . $this->session->data['token'] . '&product_feed_id=' . $feed['product_feed_id'] . $url, 'SSL')
			);

			if (file_exists($item['feed_cron_file'])) {
				$item['feed_cron_date'] = date("Y-m-d H:i:s", filemtime($item['feed_cron_file']));
			}

			$data['feeds'][] = $item;
		}
		$getListFormats = $this->model_tool_neoseo_product_feed->getListFormats();

		foreach ($getListFormats as $key => $format) {
			$formats[$format['product_feed_format_id']] = $format;
		}

		foreach ($getListFormats as $key => $format) {
			$array_formats[$format['product_feed_format_id']] = $format['feed_format_name'];
		}

		$data["formats"] = $formats;
		$data["array_formats"] = $array_formats;
		$url = '';

		if ($order == 'DESC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['add'] = $this->url->link('extension/feed/' . $this->_moduleSysName . '/addFeed', 'token=' . $this->session->data['token'], 'SSL');
		$data['generate_url'] = $this->url->link('extension/feed/' . $this->_moduleSysName . '/generate', 'token=' . $this->session->data['token'], 'SSL');
		$data['sort_feed_name'] = $this->url->link('extension/feed/' . $this->_moduleSysName, 'token=' . $this->session->data['token'] . '&sort=feed_name' . $url, 'SSL');
		$data['sort_feed_format_name'] = $this->url->link('extension/feed/' . $this->_moduleSysName, 'token=' . $this->session->data['token'] . '&sort=id_format' . $url, 'SSL');
		$data['sort_feed_status'] = $this->url->link('extension/feed/' . $this->_moduleSysName, 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');

		$url = '';
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		$pagination = new Pagination();
		$pagination->total = $feeds_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/feed/' . $this->_moduleSysName, 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($feeds_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($feeds_total - $this->config->get('config_limit_admin'))) ? $feeds_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $feeds_total, ceil($feeds_total / $this->config->get('config_limit_admin')));
		// End formation list exports
		// Start formation list formats
		if (isset($this->request->get['sort_formats'])) {
			$sort_formats = $this->request->get['sort_formats'];
		} else {
			$sort_formats = '';
		}

		if (isset($this->request->get['order_formats'])) {
			$order_formats = $this->request->get['order_formats'];
		} else {
			$order_formats = 'ASC';
		}

		if (isset($this->request->get['page_formats'])) {
			$page_formats = $this->request->get['page_formats'];
		} else {
			$page_formats = 1;
		}

		$url_formats = '';
		if (isset($this->request->get['sort_formats'])) {
			$url_formats .= '&sort_formats=' . $this->request->get['sort_formats'];
		}
		if (isset($this->request->get['order_formats'])) {
			$url_formats .= '&order_formats=' . $this->request->get['order_formats'];
		}

		if (isset($this->request->get['page_formats'])) {
			$url_formats .= '&page_formats=' . $this->request->get['page_formats'];
		}
		$sort_data_formats = array(
			'sort' => $sort_formats,
			'order' => $order_formats,
			'start' => ($page_formats - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$formats_total = $this->model_tool_neoseo_product_feed->getTotalFormats();

		$results_formats = $this->model_tool_neoseo_product_feed->getFormats($sort_data_formats);

		foreach ($results_formats as $id => $format) {
			$data['list_formats'][] = array('product_feed_format_id' => $format['product_feed_format_id'],
				'feed_format_name' => $format['feed_format_name'],
				'format_xml' => $format['format_xml'],
				'edit' => $this->url->link('extension/feed/' . $this->_moduleSysName . '/editFormat', 'token=' . $this->session->data['token'] . '&product_feed_format_id=' . $format['product_feed_format_id'] . $url_formats, 'SSL'),
				'delete' => $this->url->link('extension/feed/' . $this->_moduleSysName . '/deleteFormat', 'token=' . $this->session->data['token'] . '&product_feed_format_id=' . $format['product_feed_format_id'] . $url_formats, 'SSL')
			);
		}

		$url_formats = '';
		if ($order_formats == 'ASC') {
			$url_formats .= '&order_formats=DESC';
		} else {
			$url_formats .= '&order_formats=ASC';
		}

		if (isset($this->request->get['page_formats'])) {
			$url_formats .= '&page_formats=' . $this->request->get['page_formats'];
		}

		$data['add_formats'] = $this->url->link('extension/feed/' . $this->_moduleSysName . '/addFormat', 'token=' . $this->session->data['token'], 'SSL');
		$data['sort_feed_format_name'] = $this->url->link('extension/feed/' . $this->_moduleSysName, 'token=' . $this->session->data['token'] . '&sort_formats=feed_format_name' . $url_formats, 'SSL');

		$url_formats = '';
		if ($order_formats == 'DESC') {
			$url_formats .= '&order_formats=DESC';
		} else {
			$url_formats .= '&order_formats=ASC';
		}

		$pagination_formats = new Pagination();
		$pagination_formats->total = $formats_total;
		$pagination_formats->page = $page_formats;
		$pagination_formats->limit = $this->config->get('config_limit_admin');
		$pagination_formats->url = $this->url->link('extension/feed/' . $this->_moduleSysName, 'token=' . $this->session->data['token'] . $url_formats . '&page_formats={page}', 'SSL');
		$data['pagination_formats'] = $pagination_formats->render();
		$data['results_formats'] = sprintf($this->language->get('text_pagination'), ($feeds_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($feeds_total - $this->config->get('config_limit_admin'))) ? $feeds_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $feeds_total, ceil($feeds_total / $this->config->get('config_limit_admin')));
		// End formation list formats


		$this->document->addStyle('view/stylesheet/' . $this->_moduleSysName . '.css');

		$data["logs"] = $this->getLogs();

		$ids = array();
		$query = $this->db->query("SELECT product_id FROM `" . DB_PREFIX . "product`");
		foreach ($query->rows as $row) {
			$ids[] = $row['product_id'];
		}
		$data['fields'] = $this->getFields();
		$data['ids'] = $ids;
		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['sort_formats'] = $sort_formats;
		$data['order_formats'] = $order_formats;
		$data['sort_formats'] = $sort_formats;
		$data['order_formats'] = $order_formats;
		$data['params'] = $data;
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/feed/' . $this->_moduleSysName . '.tpl', $data));
	}

	public function install()
	{
		$this->load->model('extension/feed/' . $this->_moduleSysName);
		$this->model_extension_feed_neoseo_product_feed->install(($this->config->get('config_store_id') ? $this->config->get('config_store_id') : 0));

		$this->load->model('extension/feed/' . $this->_moduleSysName . "_formats");
		$this->model_extension_feed_neoseo_product_feed_formats->install();

		$this->load->model('extension/feed/' . $this->_moduleSysName . "_categories");
		$this->model_extension_feed_neoseo_product_feed_categories->install();

		$this->load->model('extension/feed/' . $this->_moduleSysName . "_update_relations");
		$this->model_extension_feed_neoseo_product_feed_update_relations->install();
	}

	public function uninstall()
	{
		$this->load->model('extension/feed/' . $this->_moduleSysName);
		$this->model_extension_feed_neoseo_product_feed->uninstall();

		$this->load->model('extension/feed/' . $this->_moduleSysName . "_formats");
		$this->model_extension_feed_neoseo_product_feed_formats->uninstall();

		$this->load->model('extension/feed/' . $this->_moduleSysName . "_categories");
		$this->model_extension_feed_neoseo_product_feed_categories->uninstall();

		$this->load->model('extension/feed/' . $this->_moduleSysName . "_update_relations");
		$this->model_extension_feed_neoseo_product_feed_update_relations->uninstall();
	}

	private function validate()
	{
		if (!$this->user->hasPermission('modify', 'extension/feed/' . $this->_moduleSysName)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	protected function getForm()
	{
		$data = $this->language->load('extension/feed/' . $this->_moduleSysName);
		$this->load->model('extension/feed/' . $this->_moduleSysName);
		$this->load->model('extension/feed/' . $this->_moduleSysName . '_formats');
		$data['params'] = $data;

		$data['text_form'] = !isset($this->request->get['product_feed_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['error_url_group'])) {
			$data['error_url_group'] = $this->error['error_url_group'];
		} else {
			$data['error_url_group'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data = $this->initBreadcrumbs(array(
			array('extension/feed', "text_feed"),
			array('extension/feed/' . $this->_moduleSysName, 'heading_title_raw'),
			array('extension/feed/' . $this->_moduleSysName, 'text_list', '#tab-feeds'),
		    ), $data);

		if (!isset($this->request->get['product_feed_id'])) {
			$data['action'] = $this->url->link('extension/feed/' . $this->_moduleSysName . '/addFeed', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('extension/feed/' . $this->_moduleSysName . '/editFeed', 'token=' . $this->session->data['token'] . '&product_feed_id=' . $this->request->get['product_feed_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('extension/feed/' . $this->_moduleSysName, 'token=' . $this->session->data['token'] . $url, 'SSL');

		$getListFormats = $this->model_tool_neoseo_product_feed->getListFormats();
		foreach ($getListFormats as $key => $format) {
			$formats[$format['product_feed_format_id']] = $format;
		}

		$this->load->model('catalog/' . $this->_moduleSysName . '_categories');
		$data['feedMainCategories'] = $this->model_catalog_neoseo_product_feed_categories->getParentCategories();

		$feedCategories = array();
		foreach ($data['feedMainCategories'] as $mainCategories) {
			$feedCategories[$mainCategories['category_id']] = $this->model_catalog_neoseo_product_feed_categories->getCategoriesByParentId($mainCategories['category_id']);
		}
		foreach ($this->model_catalog_neoseo_product_feed_categories->getCategories(array('where' => 'c2.parent_id!=0')) as $category) {
			foreach ($feedCategories as $parent_id => $categories) {
				foreach ($categories as $item) {
					if ($item['category_id'] != $category['category_id'])
						continue;
					$category['parent_id'] = $parent_id;
					$data['feedCategories'][] = $category;
				}
			}
		}

        $data['token'] = $this->session->data['token'];
        $data['product_not_unload'] = array();
        $this->load->model('catalog/product');

        $result = $this->model_tool_neoseo_product_feed->getFeed($this->request->get['product_feed_id']);
        $product_not_unload = explode(',', $result['not_unload']);

        foreach ($product_not_unload  as $product) {
            $not_unload = $this->model_catalog_product->getProduct($product);

            if ($not_unload) {
                $data['product_not_unload'][] = array(
                    'product_id' => $not_unload['product_id'],
                    'name'       => $not_unload['name']
                );
            }
        }

		$data['formats'] = $formats;
		$this->load->model('localisation/language');

		$languages = array();
		foreach ($this->model_localisation_language->getLanguages() as $language) {
			$languages[$language['language_id']] = $language['name'];
		}
		$data['languages'] = $languages;
		$this->load->model('catalog/category');

		$categories = array();
		foreach ($this->model_catalog_category->getCategories(0) as $category) {
			$categories[$category['category_id']] = $category['name'];
		}
		$data['categories'] = $categories;

		$this->load->model('catalog/manufacturer');
		$manufacturers = array();
		foreach ($this->model_catalog_manufacturer->getManufacturers(0) as $manufacturer) {
			$manufacturers[$manufacturer['manufacturer_id']] = $manufacturer['name'];
		}
		$data['manufacturers'] = $manufacturers;

		$this->load->model('localisation/currency');
		$currencies = array();
		foreach ($this->model_localisation_currency->getCurrencies() as $currency) {
			$currencies[$currency['code']] = $currency['title'];
		}
		$data['currencies'] = $currencies;

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();
		$data['product_feed_store'] = array(0);

		if (isset($this->request->post['product_feed_store'])) {
			$data['product_feed_store'] = $this->request->post['product_feed_store'];
		}

		/* NeoSeo Exchange1c - begin */
		$data['warehouses'] = array();
		$data['use_warehouses'] = false;
		if (($this->config->get('neoseo_exchange1c_status') == 1 && $this->config->get('neoseo_exchange1c_use_warehouse') == 1) ||
			($this->config->get('soforp_exchange1c_status') == 1 && $this->config->get('soforp_exchange1c_use_warehouse') == 1)) {
			$warehouses = $this->model_tool_neoseo_product_feed->getWarehouses();
		} 
		if (isset($warehouses)) {
			foreach ($warehouses as $warehouse) {
				$data['warehouses'][$warehouse['warehouse_id']] = $warehouse['name'];
			}
			$data['use_warehouses'] = true;
		}
		/* NeoSeo Exchange1c - end */

		if (isset($this->request->get['product_feed_id'])) {

			$data['product_feed_id'] = $this->request->get['product_feed_id'];
			$getFeeds = $this->model_tool_neoseo_product_feed->getFeed($this->request->get['product_feed_id']);
			$getFeeds['feed_demand'] = rtrim(HTTP_CATALOG, "/") . "/index.php?route=" . $this->_route . "/" . $this->_moduleSysName . "&name=" . $getFeeds["feed_shortname"];
			$getFeeds["feed_cron"] = "php " . realpath(DIR_SYSTEM . "/../cron/" . $this->_moduleSysName . ".php");
			$data['feed'] = $getFeeds;

			$data['product_feed_store'] = $this->model_tool_neoseo_product_feed->getProductFeedStore($this->request->get['product_feed_id']);

			$data['breadcrumbs'][] = array(
				'text' => $getFeeds['feed_name'],
				'href' => $this->url->link('extension/feed/' . $this->_moduleSysName . '/editFeed', 'token=' . $this->session->data['token'] . '&product_feed_id=' . $this->request->get['product_feed_id'], 'SSL')
			);
		} else {
			$data['feed'] = array(
				'status' => 0,
				'id_format' => 1,
				'feed_name' => '',
				'feed_shortname' => '',
				'feed_demand' => rtrim(HTTP_CATALOG, "/") . "/index.php?route=" . $this->_route . "/" . $this->_moduleSysName . "&name=",
				'ip_list' => '',
				'feed_cron' => "php " . realpath(DIR_SYSTEM . "/../cron/" . $this->_moduleSysName . ".php"),
				'language_id' => 1,
				'use_main_category' => 0,
				'categories' => '',
				'manufacturers' => '',
				'currency' => 1,
				'use_original_images' => 0,
				'image_width' => '',
				'image_height' => '',
				'pictures_limit' => '',
				'sql_code' => 'p.quantity > 0',
				'sql_code_before' => '',
				'use_warehouse_quantity' => 0,
				'warehouses' => '',
			);
		}
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/feed/' . $this->_moduleSysName . '_form.tpl', $data));
	}

	protected function getFormFormat()
	{
		$data = $this->language->load('extension/feed/' . $this->_moduleSysName);
		$this->load->model('tool/' . $this->_moduleSysName);
		$data['params'] = $data;

		$data['text_form'] = !isset($this->request->get['product_feed_format_id']) ? $this->language->get('text_add_format') : $this->language->get('text_edit_format');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['error_url_group'])) {
			$data['error_url_group'] = $this->error['error_url_group'];
		} else {
			$data['error_url_group'] = '';
		}

		$url_formats = '';

		if (isset($this->request->get['sort_formats'])) {
			$url_formats .= '&sort_formats = ' . $this->request->get['sort_formats'];
		}

		if (isset($this->request->get['order_formats'])) {
			$url_formats .= '&order_format = ' . $this->request->get['order_formats'];
		}

		if (isset($this->request->get['page_formats'])) {
			$url_formats .= '&page = ' . $this->request->get['page_formats'];
		}

		$data = $this->initBreadcrumbs(array(
			array('extension/feed', "text_feed"),
			array('extension/feed/' . $this->_moduleSysName, 'heading_title_raw'),
			array('extension/feed/' . $this->_moduleSysName, 'text_list_format', '#tab-formats'),
		    ), $data);

		if (!isset($this->request->get['product_feed_format_id'])) {
			$data['action'] = $this->url->link('extension/feed/' . $this->_moduleSysName . '/addFormat', 'token=' . $this->session->data['token'] . $url_formats, 'SSL');
		} else {
			$data['action'] = $this->url->link('extension/feed/' . $this->_moduleSysName . '/editFormat', 'token=' . $this->session->data['token'] . '&product_feed_format_id = ' . $this->request->get['product_feed_format_id'] . $url_formats, 'SSL');
		}

		$data['cancel'] = $this->url->link('extension/feed/' . $this->_moduleSysName, 'token=' . $this->session->data['token'] . $url_formats, 'SSL');


		if (isset($this->request->get['product_feed_format_id'])) {

			$data['product_feed_format_id'] = $this->request->get['product_feed_format_id'];
			$data['format'] = $this->model_tool_neoseo_product_feed->getFormat($this->request->get['product_feed_format_id']);

			$data['breadcrumbs'][] = array(
				'text' => $data['format']['feed_format_name'],
				'href' => $this->url->link('extension/feed/' . $this->_moduleSysName . '/editFormat', 'token=' . $this->session->data['token'] . '&product_feed_format_id=' . $this->request->get['product_feed_format_id'], 'SSL')
			);
		} else {
			$data['format'] = array('feed_format_name' => '', 'format_xml' => '',);
		}
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/feed/' . $this->_moduleSysName . '_format_form.tpl', $data));
	}

	public function addFeed()
	{
		$this->language->load('extension/feed/' . $this->_moduleSysName);

		$this->document->setTitle($this->language->get('heading_title_raw'));

		$this->load->model('tool/' . $this->_moduleSysName);
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_tool_neoseo_product_feed->saveFeed($this->request->post['feed']);
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort = ' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order = ' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page = ' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/feed/' . $this->_moduleSysName, 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function editFeed()
	{
		$this->language->load('extension/feed/' . $this->_moduleSysName);

		$this->document->setTitle($this->language->get('heading_title_raw'));

		$this->load->model('tool/' . $this->_moduleSysName);
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_tool_neoseo_product_feed->saveFeed($this->request->post['feed']);
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';

			$url .= '#tab-feeds';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort = ' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order = ' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page = ' . $this->request->get['page'];
			}


			$this->response->redirect($this->url->link('extension/feed/' . $this->_moduleSysName, 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function deleteFeed()
	{

		$data = $this->language->load('extension/feed/' . $this->_moduleSysName);
		$data['params'] = $data;
		$this->load->model('tool/' . $this->_moduleSysName);

		if (!$this->user->hasPermission('modify', 'extension/feed/' . $this->_moduleSysName)) {
			$data['error_warning'] = $this->language->get('error_permission');

			$this->template = 'extension/feed/' . $this->_moduleSysName . '.tpl';
			$this->children = array('common/header', 'common/footer');

			$data['post'] = $this->request->post;

			$this->response->setOutput($this->render(), $this->config->get('config_compression'));
			return;
		} else {

			if (isset($this->request->get["product_feed_id"])) {
				$this->model_tool_neoseo_product_feed->deleteFeed($this->request->get);

				$this->session->data['success'] = $this->language->get('text_success_delete');
			}

			header("location:" . str_replace('&amp;', '&', $this->url->link('extension/feed/' . $this->_moduleSysName, 'token=' . $this->session->data['token'], 'SSL')));
		}
	}

	public function addFormat()
	{
		$this->language->load('extension/feed/' . $this->_moduleSysName);

		$this->document->setTitle($this->language->get('heading_title_raw'));

		$this->load->model('tool/' . $this->_moduleSysName);
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$this->model_tool_neoseo_product_feed->saveFormats($this->request->post['format']);
			$this->session->data['success'] = $this->language->get('text_success');

			$url_formats = '';

			if (isset($this->request->get['sort_formats'])) {
				$url_formats .= '&sort_formats = ' . $this->request->get['sort_formats'];
			}

			if (isset($this->request->get['order_format'])) {
				$url_formats .= '&order_format = ' . $this->request->get['order_formats'];
			}

			if (isset($this->request->get['page_format'])) {
				$url_formats .= '&page_format = ' . $this->request->get['page_formats'];
			}

			$this->response->redirect($this->url->link('extension/feed/' . $this->_moduleSysName, 'token=' . $this->session->data['token'] . $url_formats, 'SSL'));
		}

		$this->getFormFormat();
	}

	public function editFormat()
	{
		$this->language->load('extension/feed/' . $this->_moduleSysName);

		$this->document->setTitle($this->language->get('heading_title_raw'));

		$this->load->model('tool/' . $this->_moduleSysName);
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_tool_neoseo_product_feed->saveFormats($this->request->post['format']);
			$this->session->data['success'] = $this->language->get('text_success');

			$url_formats = '';
			$url_formats .= '#tab-formats';

			if (isset($this->request->get['sort_formats'])) {
				$url_formats .= '&sort_formats = ' . $this->request->get['sort_formats'];
			}

			if (isset($this->request->get['order_formats'])) {
				$url_formats .= '&order_formats = ' . $this->request->get['order_formats'];
			}

			if (isset($this->request->get['page_format'])) {
				$url_formats .= '&page_formats = ' . $this->request->get['page_formats'];
			}
			$this->response->redirect($this->url->link('extension/feed/' . $this->_moduleSysName, 'token=' . $this->session->data['token'] . $url_formats, 'SSL'));
		}

		$this->getFormFormat();
	}

	public function deleteFormat()
	{

		$data = $this->language->load('extension/feed/' . $this->_moduleSysName);
		$data['params'] = $data;
		$this->load->model('tool/' . $this->_moduleSysName);

		if (!$this->user->hasPermission('modify', 'extension/feed/' . $this->_moduleSysName)) {
			$data['error_warning'] = $this->language->get('error_permission');

			$this->template = 'extension/feed/' . $this->_moduleSysName . '.tpl';
			$this->children = array('common/header', 'common/footer');

			$data['post'] = $this->request->post;

			$this->response->setOutput($this->render(), $this->config->get('config_compression'));
			return;
		} else {

			if (isset($this->request->get["product_feed_format_id"])) {
				$this->model_tool_neoseo_product_feed->deleteFormat($this->request->get);

				$this->session->data['success'] = $this->language->get('text_success_delete');
			}

			header("location:" . str_replace('&amp;', '&', $this->url->link('extension/feed/' . $this->_moduleSysName, 'token=' . $this->session->data['token'], 'SSL')));
		}
	}

	public function generate()
	{
		$product_id = $this->request->get["id"];
		$width = $this->request->get["width"];
		$height = $this->request->get["height"];

		$count = 0;
		$this->load->model("catalog/product");
		$this->load->model("tool/image");
		$images = $this->model_catalog_product->getProductImages($product_id);
		foreach ($images as $image) {
			$this->model_tool_image->resize($image['image'], $width, $height);
			$count++;
		}

		echo json_encode(array('status' => 'OK', 'count' => $count));
	}

	protected function getFields()
	{
		$result = array();

		$result['date'] = $this->language->get("field_desc_date");
		$result['url'] = $this->language->get("field_desc_url");
		$result['currency'] = $this->language->get("field_desc_currency");
		$result['categories'] = $this->language->get("field_desc_categories");
		$result['category'] = $this->language->get("field_desc_category");
		$result['category.id'] = $this->language->get("field_desc_category.id");
		$result['category.parentId'] = $this->language->get("field_desc_category.parentId");
		$result['category.name'] = $this->language->get("field_desc_category.name");
		$result['offers'] = $this->language->get("field_desc_offers");
		$result['offer'] = $this->language->get("field_desc_offer");
		$result['offer.id'] = $this->language->get("field_desc_offer.id");
		$result['offer.url'] = $this->language->get("field_desc_offer.url");
		$result['offer.price'] = $this->language->get("field_desc_offer.price");
		$result['offer.currencyId'] = $this->language->get("offer.currencyId");
		$result['offer.categoryId'] = $this->language->get("offer.categoryId");
		$result['offer.name'] = $this->language->get("offer.name");
		$result['offer.description'] = $this->language->get("offer.description");
		$result['offer.model'] = $this->language->get("offer.model");
		$result['offer.vendor'] = $this->language->get("offer.vendor");
		$result['offer.vendorCode'] = $this->language->get("offer.vendorCode");
		$result['offer.image'] = $this->language->get("offer.image");
		$result['offer.image'] = $this->language->get("offer.image");
		$result['image'] = $this->language->get("image");
		$result['offer.options'] = $this->language->get("offer.options");
		$result['option'] = $this->language->get("option");
		$result['option.name'] = $this->language->get("option.name");
		$result['option.value'] = $this->language->get("option.value");
		$result['option.available'] = $this->language->get("option.available");
		$result['offer.attributes'] = $this->language->get("offer.attributes");
		$result['attribute'] = $this->language->get("attribute");
		$result['attributes.name'] = $this->language->get("attributes.name");
		$result['attributes.value'] = $this->language->get("attributes.value");

		return $result;
	}

}

?>
