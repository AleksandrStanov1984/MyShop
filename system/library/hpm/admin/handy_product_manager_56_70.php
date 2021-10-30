<?php

/**
 * @category   OpenCart
 * @package    Handy Product Manager
 * @copyright  © Serge Tkach, 2018, http://sergetkach.com/
 */

class ControllerExtensionModuleHandyProductManager extends Controller {
	private $error = array();
	private $hpm;

	public function __construct($registry) {
		parent::__construct($registry);

		// Different PHP versions
		if (version_compare(PHP_VERSION, '7.1') >= 0) {
			$php_v = '71';
		} elseif (version_compare(PHP_VERSION, '5.6.0') >= 0) {
			$php_v = '56_70';
		} else {
			echo "Sorry! Version for PHP 5.4 Not Supported!";
			exit;
		}

		$file = DIR_SYSTEM . 'library/hpm/hpm_' . $php_v . '.php';

		if (is_file($file)) {
			require_once $file;
		} else {
			echo "No file '$file'<br>";
			exit;
		}

		$this->hpm = new HPM($this->config->get('hpm_licence'));
	}




	public function install() {
		$this->load->model('user/user_group');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/module/handy_product_manager');
		$this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/module/handy_product_manager');
	}

	public function uninstall() {
		$this->load->model('user/user_group');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/module/handy_product_manager');
		$this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/module/handy_product_manager');

		// Delete setting because filename is not match with key hpm
		$this->load->model('setting/setting');
		$this->model_setting_setting->deleteSetting('hpm');

		// Можно вписать удаление файлов модуля...
	}




	public function index() {
		$this->load->model('setting/setting');

		$this->load->model('extension/module/handy_product_manager');

		$this->load->language('extension/module/handy_product_manager');

		$this->document->setTitle($this->language->get('heading_title'));

		// Save
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			// Сохраняем негативный статус поля без его удаления
			if (isset($this->request->post['hpm_product_list_field_custom'])) {
				foreach ($this->request->post['hpm_product_list_field_custom'] as $key => $value) {
					if (!isset($this->request->post['hpm_product_list_field_custom'][$key]['status'])) {
						$this->request->post['hpm_product_list_field_custom'][$key]['status'] = '';
					}
				}
			}

			$this->model_setting_setting->editSetting('hpm', $this->request->post);

			//$this->session->data['success'] = $this->language->get('text_success');

			//$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));

			$data['text_success'] = $this->language->get('text_success');
		}

		// Error
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['errors'])) {
			$data['errors'] = $this->error['errors'];
		} else {
			$data['errors'] = '';
		}

		// Text
		$a_text = array(
			'heading_title',
			'text_edit',
			'text_enabled',
			'text_disabled',
			'text_author',
			'text_author_support',
			'text_yes',
			'text_no',
			'entry_status',
			'entry_system',
			'entry_licence',
			'entry_test_mode',
			'fieldset_product_list',
			'entry_product_list_field',
			'entry_product_list_field_custom',
			'entry_field_key',
			'entry_field_name',
			'entry_field_type',
			'entry_product_list_limit',
			'entry_product_edit_model_require',
			'entry_product_edit_sku_require',
			'fieldset_translit',
			'entry_transliteration',
			'entry_language_id',
			'entry_translit_function',
			'entry_translit_formula',
			'fieldset_upload',
			'entry_upload_rename_mode',
			'entry_upload_rename_formula',
			'text_available_vars',
			'entry_upload_max_size_in_mb',
			'entry_upload_mode',
			'help_test_mode',
			'button_save',
			'button_cancel',
			'button_save_licence',
		);

		foreach ($a_text as $item) {
			$data[$item] = $this->language->get($item);
		}

		// Breadcrumbs
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/handy_product_manager', 'token=' . $this->session->data['token'], true)
		);

		// Default links
		$data['action'] = $this->url->link('extension/module/handy_product_manager', 'token=' . $this->session->data['token'], true);
		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);

		// Data
		$data['token'] = $this->session->data['token'];
		$data['valid_licence'] = $this->hpm->isValidLicence($this->config->get('hpm_licence'));

		// Languages
		$this->load->model('localisation/language');
		$data['languages']						 = $this->model_localisation_language->getLanguages();
		$data['config_language_code']	 = $this->config->get('config_language');

		$data['hpm_licence']						 = $this->standartField('hpm_licence');
		$data['hpm_status']							 = $this->standartField('hpm_status', 0);
		$data['hpm_test_mode']					 = $this->standartField('hpm_test_mode');
		$data['hpm_product_list_limit']	 = $this->standartField('hpm_product_list_limit', 20);

		$data['systems'] = array('OpenCart', 'ocStore', 'OpenCart.PRO');

    $data['hpm_system'] = '';
    if (isset($this->request->post['hpm_system'])) {
      $data['hpm_system'] = $this->request->post['hpm_system'];
    } else {
      $data['hpm_system'] = $this->config->get('hpm_system');
    }

		// Fields in product list
		$data['a_exist_product_fields'] = array(
			'image'						 => 'on',
			'name'						 => 'on',
			'model'						 => 'on',
			'sku'							 => 'on',
			'upc'							 => 'on',
			'ean'							 => 'on',
			'jan'							 => 'on',
			'isbn'						 => 'on',
			'mpn'						   => 'on',
			'category'				 => 'on',
			'manufacturer'	   => 'on',
			'location'				 => 'on',
			'quantity'				 => 'on',
			'price'						 => 'on',
			'discount'         => 'on',
			'special'					 => 'on',
			'points'					 => 'on',
			'status'					 => 'on',
			'stock_status'		 => 'on',
			'store'						 => 'on',
			'sort_order'			 => 'on',
			'shipping'			   => 'on',
			'subtract'			   => 'on',
			'minimum'			     => 'on',
			'weight'			     => 'on',
			'dimension'		     => 'on',
		);

		$h1 = $this->model_extension_module_handy_product_manager->getH1();

		if ($h1) {
			$data['a_exist_product_fields'][$h1] = 'on';
		}

		$data['a_exist_product_fields']['meta_title'] = 'on';
		$data['a_exist_product_fields']['meta_description'] = 'on';
		$data['a_exist_product_fields']['meta_keyword'] = 'on';
		$data['a_exist_product_fields']['tag'] = 'on';
		$data['a_exist_product_fields']['description'] = 'on';
		$data['a_exist_product_fields']['attribute'] = 'on';
		$data['a_exist_product_fields']['option'] = 'on';
		$data['a_exist_product_fields']['noindex'] = 'on';

		$data['a_required_product_field'] = array(
			'image'				 => 'on',
			'name'				 => 'on',
			'model'				 => 'on',
			'manufacturer' => 'on',
			'price'				 => 'on',
			'quantity'		 => 'on',
			'status'			 => 'on',
		);

		//$data['hpm_product_list_field'] = $this->standartField('hpm_product_list_field', $data['a_required_product_field']);

		if (isset($this->request->post['hpm_product_list_field'])) {
			$data['hpm_product_list_field'] = $this->request->post['hpm_product_list_field'];
		} elseif ($this->config->get('hpm_product_list_field')) {
			$data['hpm_product_list_field'] = $this->config->get('hpm_product_list_field');
		} else {
			$data['hpm_product_list_field'] = array_merge(
				$data['a_required_product_field'],
				array(
					'sku'							 => 'on',
					'category'				 => 'on',
					'quantity'				 => 'on',
					'special'					 => 'on',
					'stock_status'		 => 'on',
					'meta_title'			 => 'on',
					'meta_description' => 'on',
					'meta_keyword'		 => 'on',
					'attribute'				 => 'on',
				)
			);
		}

		foreach ($data['a_required_product_field'] as $field => $value) {
			if (!isset($data['hpm_product_list_field'][$field])) {
				$data['hpm_product_list_field'][$field] = 'on';
			}
		}

		// Fields in product list Custom
		$data['product_table_columns_custom_exist'] = $this->model_extension_module_handy_product_manager->getProductTableColumns();


		if (isset($this->request->post['hpm_product_list_field_custom'])) {
			$data['hpm_product_list_field_custom'] = $this->request->post['hpm_product_list_field_custom'];
		} elseif ($this->config->get('hpm_product_list_field_custom')) {
			$data['hpm_product_list_field_custom'] = $this->config->get('hpm_product_list_field_custom');
		} else {
			$data['hpm_product_list_field_custom'] = array();

			foreach ($data['product_table_columns_custom_exist'] as $key => $value) {
				$data['hpm_product_list_field_custom'][$key]['status'] = 0;

				foreach ($data['languages'] as $language) {
					$data['hpm_product_list_field_custom'][$key]['description'][$language['language_id']] = $this->language->get('hpm_text_custom_fields_description') . ' ' . $key . ' ' . $language['name'];
				}

				$data['hpm_product_list_field_custom'][$key]['field_type'] = 'other';
			}
		}

		$data['custom_fields_types_exist'] = array(
			'price' => $this->language->get('hpm_text_custom_fields_type_price'),
			'other' => $this->language->get('hpm_text_custom_fields_type_other'),
		);

		// Model Require
		$data['hpm_product_edit_model_require'] = $this->standartField('hpm_product_edit_model_require', true);

		// Sku Require
		$data['hpm_product_edit_sku_require'] = $this->standartField('hpm_product_edit_sku_require', false);

		$data['hpm_language']					 = $this->standartField('hpm_language');
		$data['hpm_translit_function'] = $this->standartField('hpm_translit_function');
		$data['hpm_translit_formula']	 = $this->standartField('hpm_translit_formula', '[product_name]-[product_id]');

		// translit functions
		$this->load->model('tool/translit');
		$data['translit_functions'] = $this->model_tool_translit->getFunctionsList();

		// Upload Images
		$data['a_upload_rename_modes'] = array(
			'as_is'			 => $this->language->get('text_as_is'),
			'by_formula' => $this->language->get('text_by_formula'),
		);

		$data['a_upload_modes'] = array(
			'branch'					 => $this->language->get('text_branch'),
			'dir_for_category' => $this->language->get('text_dir_for_category'),
		);

		$data['hpm_upload_settings'] = $this->standartField('hpm_upload_settings', array(
			'rename_mode'		 => 'by_formula',
			'rename_formula' => '[product_name]',
			'max_size_in_mb' => 2,
			'upload_mode'		 => 'dir_for_category',
		));

		// Parts
		$data['header']			 = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer']			 = $this->load->controller('common/footer');

		// Render view
		$this->response->setOutput($this->load->view('extension/module/hpm', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/handy_product_manager')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		// Licence
		if (isset($this->request->post['hpm_licence']) and !empty($this->request->post['hpm_licence'])) {
		  if (!$this->hpm->isValidLicence($this->request->post['hpm_licence'])) {
				$this->error['errors']['licence'] = $this->language->get('error_licence_not_valid');
		  }
		} else {
		  // Такое возможно только, если человек попытается отобразить #module-work-area, не введя лицензию
		  $this->error['errors']['licence'] = $this->language->get('error_licence_empty');
		}

		if (empty($this->request->post['hpm_product_list_limit'])) {
			$this->error['errors']['product_list_limit'] = $this->language->get('error_product_list_limit');
		} else {
			if ($this->request->post['hpm_product_list_limit'] < 10) {
				$this->error['errors']['product_list_limit'] = $this->language->get('error_product_list_limit_small');
			}

			if ($this->request->post['hpm_product_list_limit'] > 500) {
				$this->error['errors']['product_list_limit'] = $this->language->get('error_product_list_limit_big');
			}
		}

		if (empty($this->request->post['hpm_translit_formula'])) {
			$this->error['errors']['translit_formula'] = $this->language->get('error_translit_formula_empry');
		} else {
			$this->request->post['hpm_translit_formula'] = preg_replace(array('| |', '|,|'), array('-', ''), trim($this->request->post['hpm_translit_formula']));

			$this->request->post['hpm_translit_formula'] = preg_replace(array('|-+|', '|_+|'), array('-', '_'), $this->request->post['hpm_translit_formula']);

			// need be at least 1 variable
			if ( false === strstr($this->request->post['hpm_translit_formula'], '[product_name]')
				&& false === strstr($this->request->post['hpm_translit_formula'], '[product_id]')
				&& false === strstr($this->request->post['hpm_translit_formula'], '[model]')
				&& false === strstr($this->request->post['hpm_translit_formula'], '[sku]') ) {
				$this->error['errors']['translit_formula'] = $this->language->get('error_formula_less_vars');
			} else {
				$str_without_vars = str_replace(array('[product_name]', '[product_id]', '[model]', '[sku]'), array('', '', '', ''), $this->request->post['hpm_translit_formula']);

				if (!empty($str_without_vars)) {
					if (!preg_match("/^[\-_]+$/", $str_without_vars)) {
						$this->error['errors']['translit_formula'] = $this->language->get('error_formula_pattern');
					}
				}
			}
		}

		if ('by_formula' == $this->request->post['hpm_upload_settings']['rename_mode']) {
			if (empty($this->request->post['hpm_upload_settings']['rename_formula'])) {
				$this->error['errors']['rename_formula'] = $this->language->get('error_rename_formula_empty');
			} else {
				$this->request->post['hpm_upload_settings']['rename_formula'] = preg_replace(array('| |', '|,|'), array('-', ''), trim($this->request->post['hpm_upload_settings']['rename_formula']));

				$this->request->post['hpm_upload_settings']['rename_formula'] = preg_replace('|-+|', '-', $this->request->post['hpm_upload_settings']['rename_formula']);

				// need be at least 1 variable
				if ( false === strstr($this->request->post['hpm_upload_settings']['rename_formula'], '[product_name]')
					&& false === strstr($this->request->post['hpm_upload_settings']['rename_formula'], '[model]')
					&& false === strstr($this->request->post['hpm_upload_settings']['rename_formula'], '[sku]') ) {
					$this->error['errors']['rename_formula'] = $this->language->get('error_formula_less_vars');
				} else {
					$str_without_vars = str_replace(array('[product_name]', '[model]', '[sku]'), array('', '', ''), $this->request->post['hpm_upload_settings']['rename_formula']);

					if (!empty($str_without_vars)) {
						if (!preg_match("/^[\-_]+$/", $str_without_vars)) {
							$this->error['errors']['rename_formula'] = $this->language->get('error_formula_pattern');
						}
					}
				}
			}

		}

		if (empty($this->request->post['hpm_upload_settings']['max_size_in_mb'])) {
				$this->error['errors']['max_size_in_mb'] = $this->language->get('error_max_size_in_mb');
			}

		// if any errors : common warning
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	public function productListDynamicContent() {
		$this->load->language('catalog/product');
		$this->load->language('extension/module/handy_product_manager');
		$this->load->model('catalog/product');
		$this->load->model('extension/module/handy_product_manager');

		$this->document->setTitle($this->language->get('hpm_title'));

		$this->document->addScript('view/javascript/sortable/Sortable.js');
		$this->document->addStyle('view/stylesheet/hpm.css');

		// Filter
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_product_id'])) {
			$filter_product_id = $this->request->get['filter_product_id'];
		} else {
			$filter_product_id = null;
		}

		if (isset($this->request->get['filter_sku'])) {
			$filter_sku = $this->request->get['filter_sku'];
		} else {
			$filter_sku = null;
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = null;
		}

		if (isset($this->request->get['filter_keyword'])) {
			$filter_keyword = $this->request->get['filter_keyword'];
		} else {
			$filter_keyword = null;
		}

		if (isset($this->request->get['filter_category_main'])) {
			$filter_category_main = $this->request->get['filter_category_main'];
		} else {
			$filter_category_main = null;
		}

		if (isset($this->request->get['filter_category'])) {
			$filter_category = $this->request->get['filter_category'];
		} else {
			$filter_category = null;
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$filter_manufacturer = $this->request->get['filter_manufacturer'];
		} else {
			$filter_manufacturer = null;
		}

		if (isset($this->request->get['filter_price_min'])) {
			$filter_price_min = $this->request->get['filter_price_min'];
		} else {
			$filter_price_min = null;
		}

		if (isset($this->request->get['filter_price_max'])) {
			$filter_price_max = $this->request->get['filter_price_max'];
		} else {
			$filter_price_max = null;
		}

		if (isset($this->request->get['filter_quantity_min'])) {
			$filter_quantity_min = $this->request->get['filter_quantity_min'];
		} else {
			$filter_quantity_min = null;
		}

		if (isset($this->request->get['filter_quantity_max'])) {
			$filter_quantity_max = $this->request->get['filter_quantity_max'];
		} else {
			$filter_quantity_max = null;
		}

		if (isset($this->request->get['filter_attribute'])) {
			$filter_attribute = $this->request->get['filter_attribute'];
		} else {
			$filter_attribute = null;
		}

		if (isset($this->request->get['filter_attribute_value'])) {
			$filter_attribute_value = $this->request->get['filter_attribute_value'];
		} else {
			$filter_attribute_value = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['filter_image'])) {
			$filter_image = $this->request->get['filter_image'];
		} else {
			$filter_image = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.product_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product_id'])) {
			$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
		}

		if (isset($this->request->get['filter_sku'])) {
			$url .= '&filter_sku=' . urlencode(html_entity_decode($this->request->get['filter_sku'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_keyword'])) {
			$url .= '&filter_keyword=' . urlencode(html_entity_decode($this->request->get['filter_keyword'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category_main'])) {
			$url .= '&filter_category_main=' . $this->request->get['filter_category_main'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}

		if (isset($this->request->get['filter_price_min'])) {
			$url .= '&filter_price_min=' . $this->request->get['filter_price_min'];
		}

		if (isset($this->request->get['filter_price_max'])) {
			$url .= '&filter_price_max=' . $this->request->get['filter_price_max'];
		}

		if (isset($this->request->get['filter_quantity_min'])) {
			$url .= '&filter_quantity_min=' . $this->request->get['filter_quantity_min'];
		}

		if (isset($this->request->get['filter_quantity_max'])) {
			$url .= '&filter_quantity_max=' . $this->request->get['filter_quantity_max'];
		}

		if (isset($this->request->get['filter_attribute'])) {
			$url .= '&filter_attribute=' . $this->request->get['filter_attribute'];
		}

		if (isset($this->request->get['filter_attribute_value'])) {
			$url .= '&filter_attribute_value=' . $this->request->get['filter_attribute_value'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . $this->request->get['filter_image'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		// Setting
		$data['test_mode'] = $this->config->get('hpm_test_mode');

		$data['hpm_system'] = $this->config->get('hpm_system');

		// Language
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['config_language_id'] = $this->config->get('config_language_id');

		// List Fields
		$data['a_product_list_field']	 = $this->config->get('hpm_product_list_field');

		// Custom Fields
		$data['a_product_list_field_custom'] = $this->config->get('hpm_product_list_field_custom');

		if (!$data['a_product_list_field_custom']) {
			$data['a_product_list_field_custom'] = array();
		}

		// Не показывать поля, у которых не включен статус
		foreach ($data['a_product_list_field_custom'] as $field => $value) {
			if ('on' != $value['status']) {
				unset($data['a_product_list_field_custom'][$field]);
			}
		}

		// Separate Custom Fields With Price
		$data['a_product_list_field_custom_price'] = array();

		foreach ($data['a_product_list_field_custom'] as $field => $value) {
			if ('price' == $value['field_type']) {
				$data['a_product_list_field_custom_price'][$field] = $data['a_product_list_field_custom'][$field];
				unset($data['a_product_list_field_custom'][$field]);
			}
		}

		// H1
		$data['h1'] = $this->model_extension_module_handy_product_manager->getH1();

		// Store
		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		// Category
		$this->load->model('catalog/category');

		$data['categories'] = array();

		$categories = $this->model_extension_module_handy_product_manager->getCategoriesLevel1();

		foreach ($categories as $category_id) {
			$data['categories'][] = $this->model_extension_module_handy_product_manager->getDescendantsTreeForCategory($category_id);
		}

		// for main category
		$data['has_main_category_column'] = $this->model_extension_module_handy_product_manager->hasMainCategoryColumn();

		if ($data['has_main_category_column']) {
			$filter_data = array(
				'sort'	 => 'name',
				'order'	 => 'ASC',
			);

			$data['all_categories'] = $this->model_catalog_category->getCategories($filter_data);
		}

		// Image
		$this->load->model('tool/image');

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		// Weight Class
		$this->load->model('localisation/weight_class');

		$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();
		
		// Length Class
		$this->load->model('localisation/length_class');

		$data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();

		// Manufacturer
		$this->load->model('catalog/manufacturer');

		$data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();

		// Stock Status
		$this->load->model('localisation/stock_status');

		$data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

		// Attribute
		$this->load->model('catalog/attribute');

		// Option
		$this->load->model('catalog/option');

		// Customer Group
		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		// Get Product List
		$data['products'] = array();

		// Filter data for products query
		$filter_data = array(
			'filter_name'						 => $filter_name,
			'filter_product_id'			 => $filter_product_id,
			'filter_sku'						 => $filter_sku,
			'filter_model'					 => $filter_model,
			'filter_keyword'				 => $filter_keyword,
			'filter_category_main'	 => $filter_category_main,
			'filter_category'				 => $filter_category,
			'filter_manufacturer'		 => $filter_manufacturer,
			'filter_price_min'			 => $filter_price_min,
			'filter_price_max'			 => $filter_price_max,
			'filter_quantity_min'		 => $filter_quantity_min,
			'filter_quantity_max'		 => $filter_quantity_max,
			'filter_attribute'			 => $filter_attribute,
			'filter_attribute_value' => $filter_attribute_value,
			'filter_status'					 => $filter_status,
			'filter_image'					 => $filter_image,
			'sort'									 => $sort,
			'order'									 => $order,
			'start'									 => ($page - 1) * $this->config->get('hpm_product_list_limit'),
			'limit'									 => $this->config->get('hpm_product_list_limit')
		);

		$product_total = $this->model_extension_module_handy_product_manager->getTotalProducts($filter_data, $data['test_mode']);

		$results = $this->model_extension_module_handy_product_manager->getProducts($filter_data, $data['test_mode']);

		/* Product Loop . Start
		--------------------------------------------------------------------------------- */
		foreach ($results as $prodkey => $result) {
			// product list image main
			if (is_file(DIR_IMAGE . $result['image'])) {
				$main_thumb	 = $this->model_tool_image->resize($result['image'], 100, 100);
				$main_image	 = $result['image'];
			} else {
				$main_thumb	 = $this->model_tool_image->resize('no_image.png', 100, 100);
				$main_image	 = '';
			}

			// product list images additional
			$images = $this->model_extension_module_handy_product_manager->getProductImages($result['product_id']);

			$a_images = array();

			foreach ($images as $product_image) {
				if (is_file(DIR_IMAGE . $product_image['image'])) {
					$image = $product_image['image'];
					$thumb = $product_image['image'];
				} else {
					$image = '';
					$thumb = 'no_image.png';
				}

				$a_images[] = array(
					'image'			 => $image,
					'thumb'			 => $this->model_tool_image->resize($thumb, 100, 100),
					'sort_order' => $product_image['sort_order']
				);
			}

			// product list special

			$specials = $this->model_catalog_product->getProductSpecials($result['product_id']);

			$product_specials = array();

			foreach ($specials as $product_special) {
				$product_specials[] = array(
					'product_special_id' => $product_special['product_special_id'],
					'customer_group_id'	 => $product_special['customer_group_id'],
					'priority'					 => $product_special['priority'],
					'price'							 => $product_special['price'],
					'date_start'				 => ($product_special['date_start'] != '0000-00-00') ? $product_special['date_start'] : '',
					'date_end'					 => ($product_special['date_end'] != '0000-00-00') ? $product_special['date_end'] : ''
				);
			}

			// product list discount

			$discounts = $this->model_catalog_product->getProductDiscounts($result['product_id']);

			$product_discounts = array();

			foreach ($discounts as $product_discount) {
				$product_discounts[] = array(
					'product_discount_id'	 => $product_discount['product_discount_id'],
					'customer_group_id'		 => $product_discount['customer_group_id'],
					'quantity'						 => $product_discount['quantity'],
					'priority'						 => $product_discount['priority'],
					'price'								 => $product_discount['price'],
					'date_start'					 => ($product_discount['date_start'] != '0000-00-00') ? $product_discount['date_start'] : '',
					'date_end'						 => ($product_discount['date_end'] != '0000-00-00') ? $product_discount['date_end'] : ''
				);
			}

			// product list category

			$product_categories = $this->model_catalog_product->getProductCategories($result['product_id']);

			$main_category_id = 0;

			if ($data['has_main_category_column']) {
				$main_category_id = $this->model_catalog_product->getProductMainCategoryId($result['product_id']);
			}

			// product list manufacturer
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($result['manufacturer_id']);

			if ($manufacturer_info) {
				$manufacturer = $manufacturer_info['name'];
			} else {
				$manufacturer = '';
			}

			// product list attribute
			$product_attributes = $this->model_catalog_product->getProductAttributes($result['product_id']);

			$data['product_attributes'] = array();

			foreach ($product_attributes as $product_attribute) {
				$attribute_info = $this->model_catalog_attribute->getAttribute($product_attribute['attribute_id']);

				if ($attribute_info) {
					$data['product_attributes'][] = array(
						'attribute_id'									 => $product_attribute['attribute_id'],
						'name'													 => $attribute_info['name'],
						'product_attribute_description'	 => $product_attribute['product_attribute_description'],
						'edit'													 => $this->url->link('catalog/attribute/edit', 'token=' . $this->session->data['token'] . '&attribute_id=' . $product_attribute['attribute_id'], true)
					);
				}
			}

			// product list option
			$product_options = $this->model_catalog_product->getProductOptions($result['product_id']);

			$data['product_options'] = array();

			foreach ($product_options as $product_option) {
				$product_option_value_data = array();

				if (isset($product_option['product_option_value'])) {
					foreach ($product_option['product_option_value'] as $product_option_value) {
						$product_option_value_data[] = array(
							'product_option_value_id'	 => $product_option_value['product_option_value_id'],
							'option_value_id'					 => $product_option_value['option_value_id'],
							'quantity'								 => $product_option_value['quantity'],
							'subtract'								 => $product_option_value['subtract'],
							'price'										 => $product_option_value['price'],
							'price_prefix'						 => $product_option_value['price_prefix'],
							'points'									 => $product_option_value['points'],
							'points_prefix'						 => $product_option_value['points_prefix'],
							'weight'									 => $product_option_value['weight'],
							'weight_prefix'						 => $product_option_value['weight_prefix']
						);
					}
				}

				$data['product_options'][] = array(
					'product_option_id'		 => $product_option['product_option_id'],
					'product_option_value' => $product_option_value_data,
					'option_id'						 => $product_option['option_id'],
					'name'								 => $product_option['name'],
					'type'								 => $product_option['type'],
					'value'								 => isset($product_option['value']) ? $product_option['value'] : '',
					'required'						 => $product_option['required'],
					'edit'								 => $this->url->link('catalog/option/edit', 'token=' . $this->session->data['token'] . '&option_id=' . $product_option['option_id'], true)
				);
			}

			$data['option_values'] = array();

			foreach ($data['product_options'] as $product_option) {
				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					if (!isset($data['option_values'][$product_option['option_id']])) {
						$data['option_values'][$product_option['option_id']] = $this->model_catalog_option->getOptionValues($product_option['option_id']);
					}
				}
			}

			// Custom Fields
			$custom_fields = array();

			foreach($data['a_product_list_field_custom'] as $key => $value) {
				if (isset($result[$key])) {
					$custom_fields[$key] = $result[$key];
				}
			}

			$custom_fields_price = array();

			foreach($data['a_product_list_field_custom_price'] as $key => $value) {
				if (isset($result[$key])) {
					$custom_fields_price[$key] = $result[$key];
				}
			}

			$data['products'][$prodkey] = array(
				'product_id'					 => $result['product_id'],
				'keyword'							 => $result['keyword'],
				'main_category_id'		 => $main_category_id,
				'product_category'		 => $product_categories,
				'category_tree'				 => $this->hpm->getCategoriesList($data['categories'], $product_categories, $level = 1),
				'manufacturer_id'			 => $result['manufacturer_id'],
				'manufacturer'				 => $manufacturer,
				'thumb'								 => $main_thumb,
				'image'								 => $main_image,
				'product_image'				 => $a_images,
				'product_description'	 => $this->model_extension_module_handy_product_manager->getProductDescriptions($result['product_id'], $data['h1']),
				'model'								 => $result['model'],
				'sku'									 => $result['sku'],
				'upc'									 => $result['upc'],
				'ean'									 => $result['ean'],
				'jan'									 => $result['jan'],
				'isbn'								 => $result['isbn'],
				'mpn'									 => $result['mpn'],
				'location'						 => $result['location'],
				'price'								 => $result['price'],
				'product_specials'		 => $product_specials,
				'product_discounts'		 => $product_discounts,
				'points'		           => $result['points'],
				'product_reward'		   => $this->model_catalog_product->getProductRewards($result['product_id']),
				'quantity'						 => $result['quantity'],
				'stock_status_id'			 => $result['stock_status_id'],
				'status'							 => $result['status'],
				'sort_order'					 => $result['sort_order'],
				'shipping'						 => $result['shipping'],
				'subtract'						 => $result['subtract'],
				'minimum'							 => $result['minimum'],
				'weight'							 => $result['weight'],
				'weight_class_id'			 => $result['weight_class_id'] ? $result['weight_class_id'] : $this->config->get('config_weight_class_id'),
				'length'							 => $result['length'],
				'width'								 => $result['width'],
				'height'							 => $result['height'],
				'length_class_id'			 => $result['length_class_id'] ? $result['length_class_id'] : $this->config->get('config_length_class_id'),
				'date_available'			 => '0000-00-00' == $result['date_available'] ? '' : $result['date_available'],
				'noindex'							 => isset($result['noindex']) ? $result['noindex'] : '', // for OpenCart PRO
				'custom_fields'				 => $custom_fields,
				'custom_fields_price'	 => $custom_fields_price,
				'product_store'				 => $this->model_catalog_product->getProductStores($result['product_id']),
				'product_attributes'	 => $data['product_attributes'],
				'product_options'			 => $data['product_options'],
				'option_values'				 => $data['option_values'],
				'edit'								 => $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'], true),
				'edit_in_system_mode'	 => $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'] . $url, true),
				'view_in_catalog'			 => HTTPS_CATALOG . 'index.php?route=product/product&product_id=' . $result['product_id'],
			);
		}
		/* Product Loop . End
		--------------------------------------------------------------------------------- */
		$data['largest_product_id'] = false;

		if (isset($data['products'][0]['product_id'])) {
			$data['largest_product_id'] = $data['products'][0]['product_id'];
		}

		$data['heading_title'] = $this->language->get('hpm_heading_title');

		$data['text_list']		 = $this->language->get('text_list');
		$data['text_enabled']	 = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default']	 = $this->language->get('text_default');
		$data['text_none']		 = $this->language->get('text_none');

		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm']		 = $this->language->get('text_confirm');

		$data['hpm_error_report_title'] = $this->language->get('hpm_error_report_title');

		$data['column_image']											 = $this->language->get('column_image');
		$data['hpm_upload_text_photo_main']				 = $this->language->get('hpm_upload_text_photo_main');
		$data['hpm_upload_text_drag_and_drop']		 = $this->language->get('hpm_upload_text_drag_and_drop');
		$data['hpm_upload_error_no_category']			 = $this->language->get('hpm_upload_error_no_category');
		$data['hpm_upload_error_no_category_main'] = $this->language->get('hpm_upload_error_no_category_main');
		$data['hpm_upload_error_no_product_name']	 = $this->language->get('hpm_upload_error_no_product_name');
		$data['hpm_upload_error_no_model']				 = $this->language->get('hpm_upload_error_no_model');
		$data['hpm_upload_error_no_sku']					 = $this->language->get('hpm_upload_error_no_sku');
		$data['hpm_upload_error_max_size']				 = $this->language->get('hpm_upload_error_max_size');
		$data['hpm_text_report_log']							 = $this->language->get('hpm_text_report_log');

		$data['hpm_entry_clone']					 = $this->language->get('hpm_entry_clone');
		$data['hpm_btn_generate_seo_url']	 = $this->language->get('hpm_btn_generate_seo_url');

		$data['hpm_column_category']	 = $this->language->get('hpm_column_category');
		$data['hpm_text_select_all']	 = $this->language->get('hpm_text_select_all');
		$data['hpm_text_unselect_all'] = $this->language->get('hpm_text_unselect_all');

		$data['hpm_column_description']	 = $this->language->get('hpm_column_description');
		$data['column_identity']				 = $this->language->get('hpm_column_identity');
		$data['hpm_text_product_id']		 = $this->language->get('hpm_text_product_id');
		$data['hpm_text_product_new']		 = $this->language->get('hpm_text_product_new');
		$data['entry_keyword']					 = $this->language->get('entry_keyword');

		$data['column_sku']			 = $this->language->get('hpm_column_sku');
		$data['column_model']		 = $this->language->get('column_model');
		$data['column_model']		 = $this->language->get('column_model');
		$data['column_price']		 = $this->language->get('column_price');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_status']	 = $this->language->get('column_status');
		$data['column_action']	 = $this->language->get('column_action');

		$data['entry_sku']							 = $this->language->get('entry_sku');
		$data['entry_upc']							 = $this->language->get('entry_upc');
		$data['entry_ean']							 = $this->language->get('entry_ean');
		$data['entry_jan']							 = $this->language->get('entry_jan');
		$data['entry_isbn']							 = $this->language->get('entry_isbn');
		$data['entry_mpn']							 = $this->language->get('entry_mpn');

		$data['entry_name']							 = $this->language->get('entry_name');
		$data['entry_' . $data['h1']]						 = $this->language->get('entry_' . $data['h1']);
		$data['entry_meta_title']				 = $this->language->get('entry_meta_title');
		$data['entry_meta_description']	 = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword']			 = $this->language->get('entry_meta_keyword');
		$data['entry_description']			 = $this->language->get('entry_description');
		$data['entry_tag']							 = $this->language->get('entry_tag');

		$data['hpm_entry_main_category']	 = $this->language->get('hpm_entry_main_category');
		$data['entry_category']						 = $this->language->get('entry_category');
		$data['entry_manufacturer']				 = $this->language->get('entry_manufacturer');
		$data['entry_model']							 = $this->language->get('entry_model');
		$data['entry_location']						 = $this->language->get('entry_location');
		$data['entry_price']							 = $this->language->get('entry_price');
		$data['entry_points']							 = $this->language->get('entry_points');
		$data['hpm_entry_discount']				 = $this->language->get('hpm_entry_discount');
		$data['hpm_entry_special']				 = $this->language->get('hpm_entry_special');
		$data['hpm_entry_customer_group']	 = $this->language->get('hpm_entry_customer_group');
		$data['entry_priority']						 = $this->language->get('entry_priority');

		$data['hpm_entry_date_start']	 = $this->language->get('hpm_entry_date_start');
		$data['hpm_entry_date_end']		 = $this->language->get('hpm_entry_date_end');
		$data['entry_quantity']				 = $this->language->get('entry_quantity');
		$data['entry_stock_status']		 = $this->language->get('entry_stock_status');
		$data['entry_status']					 = $this->language->get('entry_status');
		$data['entry_noindex']				 = $this->language->get('entry_noindex');
		$data['entry_store']					 = $this->language->get('entry_store');
		$data['entry_minimum']				 = $this->language->get('entry_minimum');
		$data['entry_shipping']				 = $this->language->get('entry_shipping');
		$data['entry_subtract']				 = $this->language->get('entry_subtract');
		$data['entry_date_available']	 = $this->language->get('entry_date_available');
		$data['entry_sort_order']			 = $this->language->get('entry_sort_order');

		$data['entry_image']				 = $this->language->get('entry_image');
		$data['entry_weight']				 = $this->language->get('entry_weight');
		$data['entry_weight_class']	 = $this->language->get('entry_weight_class');
		$data['entry_dimension']		 = $this->language->get('entry_dimension');
		$data['entry_length_class']	 = $this->language->get('entry_length_class');
		$data['entry_length']				 = $this->language->get('entry_length');
		$data['entry_width']				 = $this->language->get('entry_width');
		$data['entry_height']				 = $this->language->get('entry_height');

		// Custom Fields
		$data['hpm_text_custom_fields']					 = $this->language->get('hpm_text_custom_fields');
		$data['hpm_text_custom_fields_price']		 = $this->language->get('hpm_text_custom_fields_price');

		// attribute
		$data['column_attribute']									 = $this->language->get('tab_attribute');
		$data['hpm_text_attribute_edit']					 = $this->language->get('hpm_text_attribute_edit');
		$data['hpm_text_attribute_select']				 = $this->language->get('hpm_text_attribute_select');
		$data['hpm_text_attribute_new']						 = $this->language->get('hpm_text_attribute_new');
		$data['hpm_text_attribute_group_select']	 = $this->language->get('hpm_text_attribute_group_select');
		$data['hpm_text_attribute_new_save']			 = $this->language->get('hpm_text_attribute_new_save');
		$data['hpm_text_attribute_values_select']	 = $this->language->get('hpm_text_attribute_values_select');
		$data['hpm_text_attribute_values_empty']	 = $this->language->get('hpm_text_attribute_values_empty');

		// option
		$data['column_option']					 = $this->language->get('tab_option');
		$data['hpm_text_option_select']	 = $this->language->get('hpm_text_option_select');
		$data['hpm_text_option_edit']		 = $this->language->get('hpm_text_option_edit');
		$data['hpm_text_option_new']		 = $this->language->get('hpm_text_option_new');
		$data['entry_option_value']			 = $this->language->get('entry_option_value');
		$data['entry_quantity']					 = $this->language->get('entry_quantity');
		$data['entry_subtract']					 = $this->language->get('entry_subtract');
		$data['entry_price']						 = $this->language->get('entry_price');
		$data['entry_option_points']		 = $this->language->get('entry_option_points');
		$data['entry_weight']						 = $this->language->get('entry_weight');
		$data['button_option_value_add'] = $this->language->get('button_option_value_add');
		$data['text_yes']								 = $this->language->get('text_yes');
		$data['text_no']								 = $this->language->get('text_no');
		$data['entry_required']					 = $this->language->get('entry_required');

		// action
		$data['hpm_text_view_product_in_catalog']			 = $this->language->get('hpm_text_view_product_in_catalog');
		$data['hpm_text_edit_product_in_system_mode']	 = $this->language->get('hpm_text_edit_product_in_system_mode');
		$data['button_edit']													 = $this->language->get('button_edit');
		$data['button_add']														 = $this->language->get('button_add');
		$data['button_remove']												 = $this->language->get('button_remove');
		$data['hpm_button_delete_product']						 = $this->language->get('hpm_button_delete_product');
		//$data['hpm_button_delete_confirm']						 = $this->language->get('hpm_button_delete_confirm');



		//$data['token'] = $this->session->data['token'];

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
			$data['selected'] = (array) $this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product_id'])) {
			$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
		}

		if (isset($this->request->get['filter_sku'])) {
			$url .= '&filter_sku=' . urlencode(html_entity_decode($this->request->get['filter_sku'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_keyword'])) {
			$url .= '&filter_keyword=' . urlencode(html_entity_decode($this->request->get['filter_keyword'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category_main'])) {
			$url .= '&filter_category_main=' . $this->request->get['filter_category_main'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}

		if (isset($this->request->get['filter_price_min'])) {
			$url .= '&filter_price_min=' . $this->request->get['filter_price_min'];
		}

		if (isset($this->request->get['filter_price_max'])) {
			$url .= '&filter_price_max=' . $this->request->get['filter_price_max'];
		}

		if (isset($this->request->get['filter_quantity_min'])) {
			$url .= '&filter_quantity_min=' . $this->request->get['filter_quantity_min'];
		}

		if (isset($this->request->get['filter_quantity_max'])) {
			$url .= '&filter_quantity_max=' . $this->request->get['filter_quantity_max'];
		}

		if (isset($this->request->get['filter_attribute'])) {
			$url .= '&filter_attribute=' . $this->request->get['filter_attribute'];
		}

		if (isset($this->request->get['filter_attribute_value'])) {
			$url .= '&filter_attribute_value=' . $this->request->get['filter_attribute_value'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . $this->request->get['filter_image'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name']		 = $this->url->link('extension/module/handy_product_manager/productList', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, true);
		$data['sort_sku']			 = $this->url->link('extension/module/handy_product_manager/productList', 'token=' . $this->session->data['token'] . '&sort=p.sku' . $url, true);
		$data['sort_model']		 = $this->url->link('extension/module/handy_product_manager/productList', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, true);
		$data['sort_price']		 = $this->url->link('extension/module/handy_product_manager/productList', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, true);
		$data['sort_quantity'] = $this->url->link('extension/module/handy_product_manager/productList', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, true);
		$data['sort_status']	 = $this->url->link('extension/module/handy_product_manager/productList', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, true);
		$data['sort_order']		 = $this->url->link('extension/module/handy_product_manager/productList', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product_id'])) {
			$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
		}

		if (isset($this->request->get['filter_sku'])) {
			$url .= '&filter_sku=' . urlencode(html_entity_decode($this->request->get['filter_sku'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_keyword'])) {
			$url .= '&filter_keyword=' . urlencode(html_entity_decode($this->request->get['filter_keyword'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category_main'])) {
			$url .= '&filter_category_main=' . $this->request->get['filter_category_main'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}

		if (isset($this->request->get['filter_price_min'])) {
			$url .= '&filter_price_min=' . $this->request->get['filter_price_min'];
		}

		if (isset($this->request->get['filter_price_max'])) {
			$url .= '&filter_price_max=' . $this->request->get['filter_price_max'];
		}

		if (isset($this->request->get['filter_quantity_min'])) {
			$url .= '&filter_quantity_min=' . $this->request->get['filter_quantity_min'];
		}

		if (isset($this->request->get['filter_quantity_max'])) {
			$url .= '&filter_quantity_max=' . $this->request->get['filter_quantity_max'];
		}

		if (isset($this->request->get['filter_attribute'])) {
			$url .= '&filter_attribute=' . $this->request->get['filter_attribute'];
		}

		if (isset($this->request->get['filter_attribute_value'])) {
			$url .= '&filter_attribute_value=' . $this->request->get['filter_attribute_value'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . $this->request->get['filter_image'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination				 = new Pagination();
		$pagination->total = $product_total;
		$pagination->page	 = $page;
		$pagination->limit = $this->config->get('hpm_product_list_limit');
		$pagination->url	 = $this->url->link('extension/module/handy_product_manager/productList', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('hpm_product_list_limit')) + 1 : 0, ((($page - 1) * $this->config->get('hpm_product_list_limit')) > ($product_total - $this->config->get('hpm_product_list_limit'))) ? $product_total : ((($page - 1) * $this->config->get('hpm_product_list_limit')) + $this->config->get('hpm_product_list_limit')), $product_total, ceil($product_total / $this->config->get('hpm_product_list_limit')));

		$data['filter_name']						 = $filter_name;
		$data['filter_product_id']			 = $filter_product_id;
		$data['filter_sku']							 = $filter_sku;
		$data['filter_model']						 = $filter_model;
		$data['filter_keyword']					 = $filter_keyword;
		$data['filter_category_main']		 = $filter_category_main;
		$data['filter_category']				 = $filter_category;
		$data['filter_manufacturer']		 = $filter_manufacturer;
		$data['filter_price_min']				 = $filter_price_min;
		$data['filter_price_max']				 = $filter_price_max;
		$data['filter_quantity_min']		 = $filter_quantity_min;
		$data['filter_quantity_max']		 = $filter_quantity_max;
		$data['filter_attribute']				 = $filter_attribute;
		$data['filter_attribute_value']	 = $filter_attribute_value;
		$data['filter_status']					 = $filter_status;
		$data['filter_image']						 = $filter_image;

		$data['sort']	 = $sort;
		$data['order'] = $order;

		$data['header']			 = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer']			 = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/hpm_product_list_content', $data));
	}

	public function productList() {
		$this->load->language('catalog/product');
		$this->load->language('extension/module/handy_product_manager');
		$this->load->model('catalog/product');
		$this->load->model('extension/module/handy_product_manager');

		$this->document->setTitle($this->language->get('hpm_title'));

		$this->document->addScript('view/javascript/sortable/Sortable.js');
		$this->document->addStyle('view/stylesheet/hpm.css');

		// Filter
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_product_id'])) {
			$filter_product_id = $this->request->get['filter_product_id'];
		} else {
			$filter_product_id = null;
		}

		if (isset($this->request->get['filter_sku'])) {
			$filter_sku = $this->request->get['filter_sku'];
		} else {
			$filter_sku = null;
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = null;
		}

		if (isset($this->request->get['filter_keyword'])) {
			$filter_keyword = $this->request->get['filter_keyword'];
		} else {
			$filter_keyword = null;
		}

		if (isset($this->request->get['filter_category_main'])) {
			$filter_category_main = $this->request->get['filter_category_main'];
		} else {
			$filter_category_main = null;
		}

		if (isset($this->request->get['filter_category'])) {
			$filter_category = $this->request->get['filter_category'];
		} else {
			$filter_category = null;
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$filter_manufacturer = $this->request->get['filter_manufacturer'];
		} else {
			$filter_manufacturer = null;
		}

		if (isset($this->request->get['filter_price_min'])) {
			$filter_price_min = $this->request->get['filter_price_min'];
		} else {
			$filter_price_min = null;
		}

		if (isset($this->request->get['filter_price_max'])) {
			$filter_price_max = $this->request->get['filter_price_max'];
		} else {
			$filter_price_max = null;
		}

		if (isset($this->request->get['filter_quantity_min'])) {
			$filter_quantity_min = $this->request->get['filter_quantity_min'];
		} else {
			$filter_quantity_min = null;
		}

		if (isset($this->request->get['filter_quantity_max'])) {
			$filter_quantity_max = $this->request->get['filter_quantity_max'];
		} else {
			$filter_quantity_max = null;
		}

		if (isset($this->request->get['filter_attribute'])) {
			$filter_attribute = $this->request->get['filter_attribute'];
		} else {
			$filter_attribute = null;
		}

		if (isset($this->request->get['filter_attribute_value'])) {
			$filter_attribute_value = $this->request->get['filter_attribute_value'];
		} else {
			$filter_attribute_value = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['filter_image'])) {
			$filter_image = $this->request->get['filter_image'];
		} else {
			$filter_image = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.product_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['page'] = $page;

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product_id'])) {
			$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
		}

		if (isset($this->request->get['filter_sku'])) {
			$url .= '&filter_sku=' . urlencode(html_entity_decode($this->request->get['filter_sku'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_keyword'])) {
			$url .= '&filter_keyword=' . urlencode(html_entity_decode($this->request->get['filter_keyword'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category_main'])) {
			$url .= '&filter_category_main=' . $this->request->get['filter_category_main'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}

		if (isset($this->request->get['filter_price_min'])) {
			$url .= '&filter_price_min=' . $this->request->get['filter_price_min'];
		}

		if (isset($this->request->get['filter_price_max'])) {
			$url .= '&filter_price_max=' . $this->request->get['filter_price_max'];
		}

		if (isset($this->request->get['filter_quantity_min'])) {
			$url .= '&filter_quantity_min=' . $this->request->get['filter_quantity_min'];
		}

		if (isset($this->request->get['filter_quantity_max'])) {
			$url .= '&filter_quantity_max=' . $this->request->get['filter_quantity_max'];
		}

		if (isset($this->request->get['filter_attribute'])) {
			$url .= '&filter_attribute=' . $this->request->get['filter_attribute'];
		}

		if (isset($this->request->get['filter_attribute_value'])) {
			$url .= '&filter_attribute_value=' . $this->request->get['filter_attribute_value'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . $this->request->get['filter_image'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		// Breadcrumbs
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/handy_product_manager', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('hpm_heading_title'),
			'href' => $this->url->link('extension/module/handy_product_manager/productList', 'token=' . $this->session->data['token'], true)
		);

		$data['add']		 = $this->url->link('catalog/product/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['copy']		 = $this->url->link('extension/module/handy_product_manager/copy', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete']	 = $this->url->link('extension/module/handy_product_manager/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['valid_licence'] = $this->hpm->isValidLicence($this->config->get('hpm_licence')) ? true : false;

		// Setting
		$data['test_mode']						 = $this->config->get('hpm_test_mode');
		$data['a_product_list_field']	 = $this->config->get('hpm_product_list_field');
		$data['upload_settings']			 = $this->config->get('hpm_upload_settings');
		$data['source_language']			 = $this->config->get('hpm_language');
		$data['file_upload']					 = $this->hpm->getKeyValue('file_upload');

		$data['view_sm'] = true;
		$data['output'] = false;

		// Language
		$this->load->model('localisation/language');
		$data['languages']					 = $this->model_localisation_language->getLanguages();
		$data['config_language_id']	 = $this->config->get('config_language_id');
		$data['config_language']		 = $this->config->get('config_language'); // check versions

		// Store
		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		// Category
		$this->load->model('catalog/category');

		$filter_data = array(
			'sort'	 => 'name',
			'order'	 => 'ASC'
		);

		$data['all_categories'] = $this->model_catalog_category->getCategories($filter_data);

		$data['has_main_category_column'] = $this->model_extension_module_handy_product_manager->hasMainCategoryColumn();

		// Category Tree for js included in hpm_product_list_frame.tpl
		$data['categories'] = array();

		$categories = $this->model_extension_module_handy_product_manager->getCategoriesLevel1();

		foreach ($categories as $category_id) {
			$data['categories'][] = $this->model_extension_module_handy_product_manager->getDescendantsTreeForCategory($category_id);
		}

		$data['category_tree'] = $this->hpm->getCategoriesList($data['categories'], array(), $level = 1);

		// Image
		$this->load->model('tool/image');

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['upload_settings'] = $this->config->get('hpm_upload_settings');
		$data['source_language'] = $this->config->get('hpm_language');

		$data['upload_function'] = $this->hpm->getKeyValue('upload_function');
		$data_mod = $data['file_upload'];

		$upload_function = $this->hpm->$data_mod($this->config->get($data['upload_function']));

		if (!$upload_function) {
			$data['view_sm'] = false;
			$data['output'] = true;
		}

		// Manufacturer
		$this->load->model('catalog/manufacturer');

		$data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();

		// Stock Status
		$this->load->model('localisation/stock_status');

		$data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

		// Attributes
		$this->load->model('catalog/attribute');

		$data['attributes'] = $this->model_catalog_attribute->getAttributes();

		// Customer Group
		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		// Get Product List
		$data['products'] = array();

		$data['heading_title'] = $this->language->get('hpm_heading_title');

		$data['text_list']					 = $this->language->get('text_list');
		$data['text_author']				 = $this->language->get('text_author');
		$data['text_author_support'] = $this->language->get('text_author_support');
		$data['text_enabled']				 = $this->language->get('text_enabled');
		$data['text_disabled']			 = $this->language->get('text_disabled');
		$data['text_default']				 = $this->language->get('text_default');
		$data['text_none']					 = $this->language->get('text_none');
		$data['text_confirm']				 = $this->language->get('text_confirm');
		$data['text_input_licence_list']	 = $this->language->get('text_input_licence_list');

		$data['hpm_filter_entry_product_id'] = $this->language->get('hpm_filter_entry_product_id');
		$data['hpm_filter_entry_sku'] = $this->language->get('hpm_filter_entry_sku');
		$data['hpm_filter_entry_model'] = $this->language->get('hpm_filter_entry_model');
		$data['hpm_filter_entry_keyword'] = $this->language->get('hpm_filter_entry_keyword');
		$data['hpm_filter_text_none']				 = $this->language->get('hpm_filter_text_none');
		$data['hpm_filter_text_notset']			 = $this->language->get('hpm_filter_text_notset');
		if ($data['has_main_category_column']) {
			$data['hpm_filter_text_notset_category'] = $this->language->get('hpm_filter_text_notset_category');
		} else {
			$data['hpm_filter_text_notset_category'] = $this->language->get('hpm_filter_text_notset');
		}
		$data['hpm_filter_text_notset2']				 = $this->language->get('hpm_filter_text_notset2');
		$data['hpm_filter_text_min']							 = $this->language->get('hpm_filter_text_min');
		$data['hpm_filter_text_max']							 = $this->language->get('hpm_filter_text_max');
		$data['hpm_filter_entry_category']				 = $this->language->get('hpm_filter_entry_category');
		$data['hpm_filter_entry_category_main']		 = $this->language->get('hpm_filter_entry_category_main');
		$data['entry_price']											 = $this->language->get('entry_price');
		$data['entry_attribute']									 = $this->language->get('entry_attribute');
		$data['hpm_filter_entry_attribute_value']	 = $this->language->get('hpm_filter_entry_attribute_value');

		$data['button_copy']	 = $this->language->get('button_copy');
		$data['button_add']		 = $this->language->get('button_add');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['hpm_error_report_title'] = $this->language->get('hpm_error_report_title');

		$data['column_image']											 = $this->language->get('column_image');
		$data['hpm_upload_text_photo_main']				 = $this->language->get('hpm_upload_text_photo_main');
		$data['hpm_upload_text_drag_and_drop']		 = $this->language->get('hpm_upload_text_drag_and_drop');
		$data['hpm_upload_error_no_category']			 = $this->language->get('hpm_upload_error_no_category');
		$data['hpm_upload_error_no_category_main'] = $this->language->get('hpm_upload_error_no_category_main');
		$data['hpm_upload_error_no_product_name']	 = $this->language->get('hpm_upload_error_no_product_name');
		$data['hpm_upload_error_no_model']				 = $this->language->get('hpm_upload_error_no_model');
		$data['hpm_upload_error_no_sku']					 = $this->language->get('hpm_upload_error_no_sku');
		$data['hpm_upload_error_max_size']				 = $this->language->get('hpm_upload_error_max_size');
		$data['hpm_text_report_log']							 = $this->language->get('hpm_text_report_log');

		$data['hpm_entry_clone'] = $this->language->get('hpm_entry_clone');

		$data['hpm_column_category']			 = $this->language->get('hpm_column_category');
		$data['hpm_text_select_all']	 = $this->language->get('hpm_text_select_all');
		$data['hpm_text_unselect_all'] = $this->language->get('hpm_text_unselect_all');

		$data['hpm_column_description']					 = $this->language->get('hpm_column_description');
		$data['column_identity']			 = $this->language->get('hpm_column_identity');
		$data['hpm_text_product_id']	 = $this->language->get('hpm_text_product_id');
		$data['hpm_text_product_new']	 = $this->language->get('hpm_text_product_new');

		$data['column_sku']			 = $this->language->get('hpm_column_sku');
		$data['column_model']		 = $this->language->get('column_model');
		$data['column_price']		 = $this->language->get('column_price');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_status']	 = $this->language->get('column_status');
		$data['column_action']	 = $this->language->get('column_action');

		$data['entry_name']							 = $this->language->get('entry_name');
		$data['entry_meta_title']				 = $this->language->get('entry_meta_title');
		$data['entry_meta_description']	 = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword']			 = $this->language->get('entry_meta_keyword');
		$data['entry_sku']							 = $this->language->get('entry_sku');
		$data['entry_keyword']					 = $this->language->get('entry_keyword');

		$data['hpm_entry_main_category'] = $this->language->get('hpm_entry_main_category');
		$data['entry_category']					 = $this->language->get('entry_category');
		$data['entry_manufacturer']			 = $this->language->get('entry_manufacturer');
		$data['entry_model']						 = $this->language->get('entry_model');

		$data['hpm_entry_special']				 = $this->language->get('hpm_entry_special');
		$data['hpm_entry_customer_group']	 = $this->language->get('hpm_entry_customer_group');
		$data['entry_priority']						 = $this->language->get('entry_priority');

		$data['hpm_entry_date_start']	 = $this->language->get('hpm_entry_date_start');
		$data['hpm_entry_date_end']		 = $this->language->get('hpm_entry_date_end');
		$data['entry_quantity']				 = $this->language->get('entry_quantity');
		$data['entry_stock_status']		 = $this->language->get('entry_stock_status');
		$data['entry_status']					 = $this->language->get('entry_status');
		$data['entry_store']					 = $this->language->get('entry_store');
		$data['entry_image']					 = $this->language->get('entry_image');
		$data['entry_weight']					 = $this->language->get('entry_weight');
		$data['entry_weight_class']		 = $this->language->get('entry_weight_class');

		// attributes
		$data['column_attribute']									 = $this->language->get('tab_attribute');
		$data['hpm_text_attribute_edit']					 = $this->language->get('hpm_text_attribute_edit');
		$data['hpm_text_attribute_select']				 = $this->language->get('hpm_text_attribute_select');
		$data['hpm_text_attribute_new']						 = $this->language->get('hpm_text_attribute_new');
		$data['hpm_text_attribute_group_select']	 = $this->language->get('hpm_text_attribute_group_select');
		$data['hpm_text_attribute_new_save']			 = $this->language->get('hpm_text_attribute_new_save');
		$data['hpm_text_attribute_values_select']	 = $this->language->get('hpm_text_attribute_values_select');
		$data['hpm_text_attribute_values_empty']	 = $this->language->get('hpm_text_attribute_values_empty');

		// option
		$data['hpm_text_option_select']	 = $this->language->get('hpm_text_option_select');
		$data['hpm_text_option_edit']		 = $this->language->get('hpm_text_option_edit');
		$data['hpm_text_option_new']		 = $this->language->get('hpm_text_option_new');
		$data['entry_option_value']			 = $this->language->get('entry_option_value');
		$data['entry_quantity']					 = $this->language->get('entry_quantity');
		$data['entry_subtract']					 = $this->language->get('entry_subtract');
		$data['entry_price']						 = $this->language->get('entry_price');
		$data['entry_option_points']		 = $this->language->get('entry_option_points');
		$data['entry_weight']						 = $this->language->get('entry_weight');
		$data['button_option_value_add'] = $this->language->get('button_option_value_add');
		$data['text_yes']								 = $this->language->get('text_yes');
		$data['text_no']								 = $this->language->get('text_no');
		$data['entry_required']					 = $this->language->get('entry_required');

		// clone
		$data['hpm_entry_products_row_number']			 = $this->language->get('hpm_entry_products_row_number');
		$data['hpm_entry_clone_images']							 = $this->language->get('hpm_entry_clone_images');
		$data['hpm_help_clone_images']							 = $this->language->get('hpm_help_clone_images');
		$data['hpm_text_add_new_products_row']			 = $this->language->get('hpm_text_add_new_products_row');
		$data['hpm_text_add_new_products_row_clone'] = $this->language->get('hpm_text_add_new_products_row_clone');
		$data['text_error_add_new_tr']							 = $this->language->get('text_error_add_new_tr');

		// action
		$data['hpm_text_view_product_in_catalog']			 = $this->language->get('hpm_text_view_product_in_catalog');
		$data['hpm_text_edit_product_in_system_mode']	 = $this->language->get('hpm_text_edit_product_in_system_mode');
		$data['button_edit']													 = $this->language->get('button_edit');
		$data['button_remove']												 = $this->language->get('button_remove');
		$data['hpm_button_delete_product']						 = $this->language->get('hpm_button_delete_product');
		$data['hpm_button_delete_confirm']						 = $this->language->get('hpm_button_delete_confirm');

		$data['token'] = $this->session->data['token'];

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
			$data['selected'] = (array) $this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product_id'])) {
			$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
		}

		if (isset($this->request->get['filter_sku'])) {
			$url .= '&filter_sku=' . urlencode(html_entity_decode($this->request->get['filter_sku'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_keyword'])) {
			$url .= '&filter_keyword=' . urlencode(html_entity_decode($this->request->get['filter_keyword'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category_main'])) {
			$url .= '&filter_category_main=' . $this->request->get['filter_category_main'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}

		if (isset($this->request->get['filter_price_min'])) {
			$url .= '&filter_price_min=' . $this->request->get['filter_price_min'];
		}

		if (isset($this->request->get['filter_price_max'])) {
			$url .= '&filter_price_max=' . $this->request->get['filter_price_max'];
		}

		if (isset($this->request->get['filter_quantity_min'])) {
			$url .= '&filter_quantity_min=' . $this->request->get['filter_quantity_min'];
		}

		if (isset($this->request->get['filter_quantity_max'])) {
			$url .= '&filter_quantity_max=' . $this->request->get['filter_quantity_max'];
		}

		if (isset($this->request->get['filter_attribute'])) {
			$url .= '&filter_attribute=' . $this->request->get['filter_attribute'];
		}

		if (isset($this->request->get['filter_attribute_value'])) {
			$url .= '&filter_attribute_value=' . $this->request->get['filter_attribute_value'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . $this->request->get['filter_image'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name']		 = $this->url->link('extension/module/handy_product_manager/productList', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, true);
		$data['sort_sku']			 = $this->url->link('extension/module/handy_product_manager/productList', 'token=' . $this->session->data['token'] . '&sort=p.sku' . $url, true);
		$data['sort_model']		 = $this->url->link('extension/module/handy_product_manager/productList', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, true);
		$data['sort_price']		 = $this->url->link('extension/module/handy_product_manager/productList', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, true);
		$data['sort_quantity'] = $this->url->link('extension/module/handy_product_manager/productList', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, true);
		$data['sort_status']	 = $this->url->link('extension/module/handy_product_manager/productList', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, true);
		$data['sort_order']		 = $this->url->link('extension/module/handy_product_manager/productList', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product_id'])) {
			$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
		}

		if (isset($this->request->get['filter_sku'])) {
			$url .= '&filter_sku=' . urlencode(html_entity_decode($this->request->get['filter_sku'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_keyword'])) {
			$url .= '&filter_keyword=' . urlencode(html_entity_decode($this->request->get['filter_keyword'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_category_main'])) {
			$url .= '&filter_category_main=' . $this->request->get['filter_category_main'];
		}

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . $this->request->get['filter_category'];
		}

		if (isset($this->request->get['filter_manufacturer'])) {
			$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
		}

		if (isset($this->request->get['filter_price_min'])) {
			$url .= '&filter_price_min=' . $this->request->get['filter_price_min'];
		}

		if (isset($this->request->get['filter_price_max'])) {
			$url .= '&filter_price_max=' . $this->request->get['filter_price_max'];
		}

		if (isset($this->request->get['filter_quantity_min'])) {
			$url .= '&filter_quantity_min=' . $this->request->get['filter_quantity_min'];
		}

		if (isset($this->request->get['filter_quantity_max'])) {
			$url .= '&filter_quantity_max=' . $this->request->get['filter_quantity_max'];
		}

		if (isset($this->request->get['filter_attribute'])) {
			$url .= '&filter_attribute=' . $this->request->get['filter_attribute'];
		}

		if (isset($this->request->get['filter_attribute_value'])) {
			$url .= '&filter_attribute_value=' . $this->request->get['filter_attribute_value'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . $this->request->get['filter_image'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['filter_name']						 = $filter_name;
		$data['filter_product_id']			 = $filter_product_id;
		$data['filter_sku']							 = $filter_sku;
		$data['filter_model']						 = $filter_model;
		$data['filter_keyword']					 = $filter_keyword;
		$data['filter_category_main']		 = $filter_category_main;
		$data['filter_category']				 = $filter_category;
		$data['filter_manufacturer']		 = $filter_manufacturer;
		$data['filter_price_min']				 = $filter_price_min;
		$data['filter_price_max']				 = $filter_price_max;
		$data['filter_quantity_min']		 = $filter_quantity_min;
		$data['filter_quantity_max']		 = $filter_quantity_max;
		$data['filter_attribute']				 = $filter_attribute;
		$data['filter_attribute_value']	 = $filter_attribute_value;
		$data['filter_status']					 = $filter_status;
		$data['filter_attribute']				 = $filter_attribute;
		$data['filter_attribute_value']	 = $filter_attribute_value;
		$data['filter_image']						 = $filter_image;

		$data['sort']	 = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer']			 = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/hpm_product_list_frame', $data));
	}

	public function productListLiveEdit() {
		$json = array();

		$this->load->language('extension/module/handy_product_manager');

		$this->load->model('extension/module/handy_product_manager');

		$test_mode = $this->config->get('hpm_test_mode');

		if (!$this->hpm->isValidLicence($this->config->get('hpm_licence'))) {
			$json['status']	 = 'error';
			$json['msg'] = $this->language->get('text_input_licence_mass');

			$this->response->addHeader('Content-Type: application/json');
			$this->response->setOutput(json_encode($json));
		}

		if ($test_mode) {
			hpm_log($test_mode, $this->request->post, "\$this->request->post in productListLiveEdit()");
		}

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			if ('add_image_additional' == $this->request->post['essence']) {
				$this->model_extension_module_handy_product_manager->addProductImageAdditional($this->request->post, $test_mode);
			}

			if ('edit_image_main' == $this->request->post['essence']) {
				$this->model_extension_module_handy_product_manager->editProductImageMain($this->request->post, $test_mode);
			}

			if ('edit_image_additional' == $this->request->post['essence']) {
				$this->model_extension_module_handy_product_manager->editProductImageAdditional($this->request->post, $test_mode);
			}

			if ('edit_image_sorting' == $this->request->post['essence']) {
				$this->model_extension_module_handy_product_manager->editProductImageSorting($this->request->post, $test_mode);
			}

			if ('edit_image_main_from_first_item' == $this->request->post['essence']) {
				$this->model_extension_module_handy_product_manager->editProductImageMainFromFirstItem($this->request->post, $test_mode);
			}

			if ('edit_image_main_after_sorting' == $this->request->post['essence']) {
				$this->model_extension_module_handy_product_manager->editProductImageMainAfterSorting($this->request->post, $test_mode);
			}

			if ('delete_image_main' == $this->request->post['essence']) {
				$this->model_extension_module_handy_product_manager->deleteProductImageMain($this->request->post, $test_mode);
			}

			if ('delete_image_additional' == $this->request->post['essence']) {
				$this->model_extension_module_handy_product_manager->deleteProductImageAdditional($this->request->post, $test_mode);
			}

			if ('edit_url' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->editProductUrl($this->request->post, $test_mode);

				$this->cache->delete('product.seopath');
				$this->cache->delete('seo_pro');
			}

			if ('edit_categories' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->editProductCategories($this->request->post, $test_mode);
			}

			if ('edit_main_category' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->editProductMainCategory($this->request->post, $test_mode);

				$this->cache->delete('product.seopath');
				$this->cache->delete('seo_pro');
			}

			if ('edit_identity' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->editProductIdentity($this->request->post, $test_mode);
			}

			if ('edit_product_reward' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->editProductReward($this->request->post, $test_mode);
			}

			if ('add_product_to_store' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->addProductToStore($this->request->post, $test_mode);
			}

			if ('delete_product_from_store' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->deleteProductFromStore($this->request->post, $test_mode);
			}

			if ('add_discount' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->addDiscount($this->request->post, $test_mode);
			}

			if ('edit_discount' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->editDiscount($this->request->post, $test_mode);
			}

			if ('delete_discount' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->deleteDiscount($this->request->post, $test_mode);
			}

			if ('add_special' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->addSpecial($this->request->post, $test_mode);
			}

			if ('edit_special' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->editSpecial($this->request->post, $test_mode);
			}

			if ('delete_special' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->deleteSpecial($this->request->post, $test_mode);
			}

			if ('edit_description' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->editProductDescription($this->request->post, $test_mode);
			}

			if ('add_new_attribute' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->addNewAttribute($this->request->post, $test_mode);
			}

			if ('edit_attribute_value' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->editProductAttributeValue($this->request->post, $test_mode);
			}

			if ('add_attribute_to_product' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->addProductAttribute($this->request->post, $test_mode);
			}

			if ('delete_attribute_from_product' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->deleteProductAttribute($this->request->post, $test_mode);
			}

			if ('edit_product_option' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->editProductOption($this->request->post, $test_mode);
			}

			if ('delete_option_from_product' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->deleteOptionFromProduct($this->request->post, $test_mode);
			}

			if ('add_product_option' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->addProductOption($this->request->post, $test_mode);
			}

			if ('add_product_option_value' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->addProductOptionValue($this->request->post, $test_mode);
			}

			if ('edit_product_option_value' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->editProductOptionValue($this->request->post, $test_mode);
			}

			if ('delete_product_option_value' == $this->request->post['essence']) {
				$res = $this->model_extension_module_handy_product_manager->deleteProductOptionValue($this->request->post, $test_mode);
			}

			// create & clone new product
			if ('add_new_product' == $this->request->post['essence']) {
				$data_input = $this->request->post;

				$this->load->model('localisation/language');
				$data_input['languages'] = $this->model_localisation_language->getLanguages();

				$res = $this->model_extension_module_handy_product_manager->addNewProduct($data_input, $test_mode);
			}

			if ('delete_product' == $this->request->post['essence']) {
				// system method!
				$this->model_extension_module_handy_product_manager->deleteProduct($this->request->post['product_id']);
			}

		} else {
			$json['status']	 = 'error';
			$json['msg']		 = $this->language->get('hpm_error_empty_post');
		}

		$json['status'] = 'success';

		$this->model_extension_module_handy_product_manager->callByLiveEdit($this->request->post['essence'], $test_mode);

		if (isset($res)) {
			$json['result'] = $res;
		}

		//$json['msg'] = $this->language->get('hpm_success');// пока что нигде не используется в js

		if ($test_mode) {
			hpm_log($test_mode, $json, 'productListLiveEdit() $json');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function copy() {
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_catalog_product->copyProduct($product_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_product_id'])) {
				$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
			}

			if (isset($this->request->get['filter_sku'])) {
				$url .= '&filter_sku=' . urlencode(html_entity_decode($this->request->get['filter_sku'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_keyword'])) {
				$url .= '&filter_keyword=' . urlencode(html_entity_decode($this->request->get['filter_keyword'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_category_main'])) {
				$url .= '&filter_category_main=' . $this->request->get['filter_category_main'];
			}

			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}

			if (isset($this->request->get['filter_manufacturer'])) {
				$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
			}

			if (isset($this->request->get['filter_price_min'])) {
				$url .= '&filter_price_min=' . $this->request->get['filter_price_min'];
			}

			if (isset($this->request->get['filter_price_max'])) {
				$url .= '&filter_price_max=' . $this->request->get['filter_price_max'];
			}

			if (isset($this->request->get['filter_quantity_min'])) {
				$url .= '&filter_quantity_min=' . $this->request->get['filter_quantity_min'];
			}

			if (isset($this->request->get['filter_quantity_max'])) {
				$url .= '&filter_quantity_max=' . $this->request->get['filter_quantity_max'];
			}

			if (isset($this->request->get['filter_attribute'])) {
				$url .= '&filter_attribute=' . $this->request->get['filter_attribute'];
			}

			if (isset($this->request->get['filter_attribute_value'])) {
				$url .= '&filter_attribute_value=' . $this->request->get['filter_attribute_value'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/module/handy_product_manager/productList', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->productList();
	}

	public function delete() {
		$test_mode = $this->config->get('hpm_test_mode');

		if ($test_mode) {
			hpm_log($test_mode, $this->request->get, 'delete() $this->request->get');
		}

		$this->load->language('extension/module/handy_product_manager');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_catalog_product->deleteProduct($product_id);
			}

			$this->session->data['success'] = $this->language->get('text_success_delete');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_product_id'])) {
				$url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
			}

			if (isset($this->request->get['filter_sku'])) {
				$url .= '&filter_sku=' . urlencode(html_entity_decode($this->request->get['filter_sku'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_keyword'])) {
				$url .= '&filter_keyword=' . urlencode(html_entity_decode($this->request->get['filter_keyword'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_category_main'])) {
				$url .= '&filter_category_main=' . $this->request->get['filter_category_main'];
			}

			if (isset($this->request->get['filter_category'])) {
				$url .= '&filter_category=' . $this->request->get['filter_category'];
			}

			if (isset($this->request->get['filter_manufacturer'])) {
				$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
			}

			if (isset($this->request->get['filter_price_min'])) {
				$url .= '&filter_price_min=' . $this->request->get['filter_price_min'];
			}

			if (isset($this->request->get['filter_price_max'])) {
				$url .= '&filter_price_max=' . $this->request->get['filter_price_max'];
			}

			if (isset($this->request->get['filter_quantity_min'])) {
				$url .= '&filter_quantity_min=' . $this->request->get['filter_quantity_min'];
			}

			if (isset($this->request->get['filter_quantity_max'])) {
				$url .= '&filter_quantity_max=' . $this->request->get['filter_quantity_max'];
			}

			if (isset($this->request->get['filter_attribute'])) {
				$url .= '&filter_attribute=' . $this->request->get['filter_attribute'];
			}

			if (isset($this->request->get['filter_attribute_value'])) {
				$url .= '&filter_attribute_value=' . $this->request->get['filter_attribute_value'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('extension/module/handy_product_manager/productList', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->productList();
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module/handy_product_manager')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}




	/* Upload
	-------------------------------------------------------------------------- */
	public function upload() {
		$data						 = array();
		$data['answer']	 = 'error';

		$test_mode = $this->config->get('hpm_test_mode');

		hpm_log($test_mode, 'upload() function is called');

		$settings = $this->config->get('hpm_upload_settings');

		// for future ?
		if (!array_key_exists('resize', $settings)) {
			$settings['resize']		 = 'no';
			$settings['resize_w']	 = 1280;
			$settings['resize_h']	 = 1000;
		}

		if ('by_formula' == $settings['rename_mode']) {
			$product_info = array(
				'name'	 => isset($this->request->get['name']) ? $this->request->get['name'] : '',
				'model'	 => isset($this->request->get['model']) ? $this->request->get['model'] : '',
				'sku'		 => isset($this->request->get['sku']) ? $this->request->get['sku'] : '',
			);
		}

		$translit_function = $this->config->get('hpm_translit_function');

		$lang_id = $this->config->get('hpm_language');

		hpm_log($test_mode, $this->request->post, '\$this->request->post in upload()');
		hpm_log($test_mode, $this->request->get, '\$this->request->get in upload()');
		hpm_log($test_mode, $_FILES, '\$_FILES in upload()');

		$this->load->model('extension/module/handy_product_manager');
		$this->load->model('tool/image'); // for resize
		$this->load->model('tool/translit'); // for translit
		$this->load->language('extension/module/handy_product_manager');

		$valid_formats = $this->model_extension_module_handy_product_manager->getValidFormats();

		if ('dir_for_category' == $settings['upload_mode']) {
			$category_name = $this->model_extension_module_handy_product_manager->getCategoryName($this->request->get['category_id'], $lang_id);
			hpm_log($test_mode, "\$category_name : " . $category_name);

			$category_dir = $this->model_tool_translit->$translit_function($category_name);
			hpm_log($test_mode, "\$category_dir after translit() : " . $category_dir);

			$category_dir = $this->model_tool_translit->clearWasteChars($category_dir);
			hpm_log($test_mode, "\$category_dir after clearWasteChars() : " . $category_dir);

			$uploaddir												 = DIR_IMAGE . 'catalog/' . $this->request->get['dir'] . '/' . $category_dir . '/';
			$target_dir_without_document_root	 = 'catalog/' . $this->request->get['dir'] . '/' . $category_dir . "/"; // for url

			if (!is_dir($uploaddir)) {
				// error
				hpm_log($test_mode = true, "Error: no dir $uploaddir");
			}
		} else {
			$subdir = $this->hpm->branchFolders(DIR_IMAGE . 'catalog/' . $this->request->get['dir'], $test_mode);

			if ($subdir) {
				$target_dir_without_document_root	 = 'catalog/' . $this->request->get['dir'] . "/" . basename($subdir) . "/"; // for url
				$uploaddir = $subdir . "/";
			} else {
				// error
				hpm_log($test_mode, "Error: no subdir");
			}
		}

		if (!is_dir($uploaddir)) {
			$this->hpm->createFolder($uploaddir);
		}

		if (is_dir($uploaddir)) {
			$data['answer'] = 'success';

			foreach ($_FILES as $file) {
				if ('as_is' == $settings['rename_mode']) {
					$filename = pathinfo(stripslashes($file['name']), PATHINFO_FILENAME);
				}

				if ('by_formula' == $settings['rename_mode']) {
					$filename = $this->hpm->getFileNameByFormula($product_info, $settings['rename_formula'], $test_mode);
				}

				$filename = $this->model_tool_translit->$translit_function($filename);

				$filename = $this->model_tool_translit->clearWasteChars($filename);

				$size = filesize($file['tmp_name']);
				//get the extension of the file in a lower case format

				$ext = strtolower(pathinfo(stripslashes($file['name']), PATHINFO_EXTENSION));

				if (in_array($ext, $valid_formats)) {
					// max file size
					if ($size < ($settings['max_size_in_mb'] * 1024 * 1024)) {
						// Проверка на уникальность названия фотографии + предотвращение перезаписи
						//if (is_file($uploaddir . $filename ." . " . $ext)) {
						$image_new_name = $this->hpm->getUniqueName($uploaddir, $filename, $ext, $test_mode);
						//}

						if (move_uploaded_file($file['tmp_name'], $uploaddir . $image_new_name)) {
							$image			 = $target_dir_without_document_root . $image_new_name;
							$image_thumb = htmlspecialchars($this->model_tool_image->resize($image, 100, 100));

							$data['file']['thumb'] = $image_thumb;
							$data['file']['image'] = $image;

							// for future ?
							/*
							  if ('yes' == $settings['resize']) {
							  $this->model_tool_image->resize_proportionately($image, $settings['resize_w'], $settings['resize_h']);
							  }
							 *
							 */
							$image_data = array(
								'product_id'				 => $this->request->get['product_id'],
								'image'							 => $image,
								'image_additional_n' => isset($this->request->get['image_additional_n']) ? $this->request->get['image_additional_n'] : 0,
							);

							// todo - main & additional!!
							if ('main' == $this->request->get['photo_type']) {
								hpm_log($test_mode, "upload() \$this->request->get['photo_type'] : main");
								$this->model_extension_module_handy_product_manager->addProductImageMain($image_data, $test_mode);
							} else {
								hpm_log($test_mode, "upload() \$this->request->get['photo_type'] : additional");
								$this->model_extension_module_handy_product_manager->addProductImageAdditional($image_data, $test_mode);
							}
						} else {
							$data['answer']							 = 'error';
							$data['answer_description']	 = str_replace(array('[file]', '[target]'), array($file['name'], $image), $this->language->get('hpm_upload_error_result'));
						}
					} else {
						$data['answer']							 = 'error';
						$data['answer_description']	 = str_replace('[file]', $file['name'], $this->language->get('hpm_upload_error_max_size'));
					}
				} else {
					$data['answer']							 = 'error';
					$data['answer_description']	 = str_replace('[file]', $file['name'], $this->language->get('hpm_upload_error_file_extenion'));
				}
			}
		} else {
			$data['answer']							 = 'error';
			$data['answer_description']	 = $this->language->get('error_dir');
		}


		header('Content-type:application/json;charset=utf-8');
		echo json_encode($data);
		hpm_log($test_mode, $data, 'upload() result json-$data');
		exit;
	}




	/* Ajax actions
	-------------------------------------------------------------------------- */
	public function productAutocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_sku'])) {
			$this->load->model('catalog/product');
			$this->load->model('catalog/option');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_sku'])) {
				$filter_sku = $this->request->get['filter_sku'];
			} else {
				$filter_sku = '';
			}

			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 25;
			}

			$filter_data = array(
				'filter_name'	 => $filter_name,
				'filter_sku'	 => $filter_sku,
				'filter_model' => $filter_model,
				'start'				 => 0,
				'limit'				 => $limit
			);

			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {
				$option_data = array();

				$product_options = $this->model_catalog_product->getProductOptions($result['product_id']);

				foreach ($product_options as $product_option) {
					$option_info = $this->model_catalog_option->getOption($product_option['option_id']);

					if ($option_info) {
						$product_option_value_data = array();

						foreach ($product_option['product_option_value'] as $product_option_value) {
							$option_value_info = $this->model_catalog_option->getOptionValue($product_option_value['option_value_id']);

							if ($option_value_info) {
								$product_option_value_data[] = array(
									'product_option_value_id'	 => $product_option_value['product_option_value_id'],
									'option_value_id'					 => $product_option_value['option_value_id'],
									'name'										 => $option_value_info['name'],
									'price'										 => (float) $product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
									'price_prefix'						 => $product_option_value['price_prefix']
								);
							}
						}

						$option_data[] = array(
							'product_option_id'		 => $product_option['product_option_id'],
							'product_option_value' => $product_option_value_data,
							'option_id'						 => $product_option['option_id'],
							'name'								 => $option_info['name'],
							'type'								 => $option_info['type'],
							'value'								 => $product_option['value'],
							'required'						 => $product_option['required']
						);
					}
				}

				$json[] = array(
					'product_id' => $result['product_id'],
					'name'			 => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'sku'				 => $result['sku'] ? $result['sku'] : '--',
					'model'			 => $result['model'],
					'option'		 => $option_data,
					'price'			 => $result['price']
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function getAttributeGroupList() {
		$test_mode = $this->config->get('hpm_test_mode');

		hpm_log($test_mode, 'getAttributeGroupList() is called');

		$json = array();

		//$this->load->model('extension/module/handy_product_manager');

		$this->load->model('catalog/attribute_group');

		$filter_data = array(
			//'product_id' => $this->request->get['product_id'],
		);

		//$results = $this->model_extension_module_handy_product_manager->getAttributeGroups($filter_data, $test_mode);
		$results = $this->model_catalog_attribute_group->getAttributeGroups($filter_data);

		$attribute_gorup_list = array();

		foreach ($results as $result) {
			$attribute_gorup_list[] = array(
				'attribute_group_id' => $result['attribute_group_id'],
				'name'							 => $result['name'],
				'sort_order'				 => $result['sort_order'],
			);
		}

		$json['status']	 = 'success';
		$json['data']		 = $attribute_gorup_list;

		hpm_log($test_mode, $json, '$json');

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function getAttributeList() {
		$test_mode = $this->config->get('hpm_test_mode');

		hpm_log($test_mode, 'getAttributeList() is called');

		$json = array();

		$this->load->model('extension/module/handy_product_manager');

		//$this->load->model('catalog/attribute');

		$filter_data = array(
			'product_id' => $this->request->get['product_id'],
		);

		$results = $this->model_extension_module_handy_product_manager->getAttributes($filter_data, $test_mode);

		$attribute_list = array();

		foreach ($results as $result) {
			$attribute_list[] = array(
				'attribute_id' => $result['attribute_id'],
				'name'				 => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')) . ' (' . $result['attribute_group'] . ')',
				//'attribute_group' => $result['attribute_group']
			);
		}

		$json['status']	 = 'success';
		$json['data']		 = $attribute_list;

		hpm_log($test_mode, $json, '$json');

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function getAllAttributeValues() {
		$test_mode = $this->config->get('hpm_test_mode');

		hpm_log($test_mode, 'getAllAttributeValues() is called');

		$this->load->model('extension/module/handy_product_manager');

		$json = array();

		$attribute_all_values = array();

		$attribute_all_values = $this->model_extension_module_handy_product_manager->getAllAttributeValues($test_mode);

		$attribute_values = array();

		foreach ($attribute_all_values as $item) {
			$attribute_values[$item['attribute_id']][$item['language_id']][] = strip_tags(html_entity_decode($item['text'], ENT_QUOTES, 'UTF-8'));
		}

		$json['status']	 = 'success';
		$json['data']		 = $attribute_values;

		hpm_log($test_mode, $json, 'getAttributeValues() : $json');

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function getAttributeValues() {
		$test_mode = $this->config->get('hpm_test_mode');

		hpm_log($test_mode, 'getAttributeValues() is called');

		$json = array();

		$language_id = isset($this->request->get['language_id']) && $this->request->get['language_id'] ? $this->request->get['language_id'] : $this->config->get('config_language_id');

		$this->load->model('extension/module/handy_product_manager');

		$attribute_all_values = array();

		$attribute_all_values = $this->model_extension_module_handy_product_manager->getAttributeValues($this->request->get['attribute_id'], $language_id, $test_mode);

		$attribute_values = array();

		foreach ($attribute_all_values as $attribute_all_value) {
			$attribute_values[] = array(
				'text' => strip_tags(html_entity_decode($attribute_all_value['text'], ENT_QUOTES, 'UTF-8')),
			);
		}

		$json['status']	 = 'success';
		$json['data']		 = $attribute_values;

		hpm_log($test_mode, $json, 'getAttributeValues() : $json');

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function getAllOptionValues() {
		$test_mode = $this->config->get('hpm_test_mode');

		hpm_log($test_mode, 'getAllOptionValues() is called');

		$json = array();

		$this->load->model('extension/module/handy_product_manager');

		$option_values = $this->model_extension_module_handy_product_manager->getAllOptionValues($test_mode);

		$json['status'] = 'success';

		hpm_log($test_mode, $option_values, 'getAllOptionValues() $option_values');

		// Option values array with option_id keys
		foreach ($option_values as $key => $value) {
			$json['data'][$value['option_id']][] = array(
				'option_value_id'	 => $value['option_value_id'],
				'name'						 => $value['name'],
			);
		}

		hpm_log($test_mode, $json, 'getAllOptionValues() $json');

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function getOptionsList() {
		$test_mode = $this->config->get('hpm_test_mode');

		hpm_log($test_mode, 'getOptionsList() is called');

		$json = array();

		$this->load->model('extension/module/handy_product_manager');

		$a_options = $this->model_extension_module_handy_product_manager->getOptionsList($this->request->get['product_id'], $test_mode);

		// Option array with option_id keys
		$json['data'] = array();

		foreach ($a_options as $key => $value) {
			$json['data'][$value['option_id']] = array(
				'option_id'	 => $value['option_id'],
				'name'			 => $value['name'],
				'type'			 => $value['type'],
			);
		}

		$json['status'] = 'success';

		hpm_log($test_mode, $json['data'], 'getOptionsList() $json[\'data\']');

		hpm_log($test_mode, $json, 'getOptionsList() $json');

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}




	/* Helper
	--------------------------------------------------------------------------- */
	private function standartField($key, $default_value = '') {
		if (!$key) {
			return false;
		}

		if (false === strpos($key, 'hpm_')) {
			$key = 'hpm_' . $key;
		}

		if (isset($this->request->post[$key])) {
			return $this->request->post[$key];
		} elseif ($this->config->get($key)) {
			return $this->config->get($key);
		} else {
			return $default_value;
		}

		return false;
	}



	/* Autocomplete
  --------------------------------------------------------------------------- */
	public function autocompleteManufacturer() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('extension/module/handy_product_manager');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 5,
			);

			$results = $this->model_extension_module_handy_product_manager->getManufacturers($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'manufacturer_id' => $result['manufacturer_id'],
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}




	/* SEO URL
  --------------------------------------------------------------------------- */
  public function getSeoUrlByAjax() {
    $test_mode = $this->config->get('hpm_test_mode');

		hpm_log($test_mode, $this->request->post, 'getSeoUrlByAjax() : $this->request->post');

		if (!isset($this->request->post)) return false;

    $data = array('result' => '');

		$formula = $this->config->get('hpm_translit_formula');

		// Check data for formula
		$data['errors'] = array();

		if (false !== strpos($formula, '[product_name]')) {
			// A! name VS product_name
			if (!$this->request->post['name']) {
				$data['result'] = 'ERROR';
				$data['errors'][] = 'name';
			}
		}

		if (false !== strpos($formula, '[model]')) {
			if (!$this->request->post['model']) {
				$data['result'] = 'ERROR';
				$data['errors'][] = 'model';
			}
		}

		if (false !== strpos($formula, '[sku]')) {
			if (!$this->request->post['sku']) {
				$data['result'] = 'ERROR';
				$data['errors'][] = 'sku';
			}
		}

		if ('ERROR' != $data['result']) {
			unset($data['errors']);

			$result = $this->getSeoUrl($this->request->post, $test_mode);

			if ($result) {
				$data['result'] = $result;
			}
		}

    header('Content-type:application/json;charset=utf-8');
    echo json_encode($data);
    exit;
  }

	public function getSeoUrl($a_data, $test_mode = false) {
    /* Определить сущность
     * Определить, какие переменные есть в формуле
     * Вырезать из формулы лишние - (транслит сам это сделает)
     * Транлитировать
     * Запросить уникальность
     * Если URL не уникален, то использовать индекс N - причем, это не зависит от того, есть ли в формуле генерации доп переменные или нет
     */
		hpm_log($test_mode, $a_data, 'getSeoUrl() : $a_data');

    $keyword = '';

    $this->load->model('extension/module/handy_product_manager');

    $setting = array(
      'language_id' => $this->config->get('hpm_language'),
      'translit_function' => $this->config->get('hpm_translit_function'),
      'translit_formula' => $this->config->get('hpm_translit_formula'),
    );

		hpm_log($test_mode, $setting, 'getSeoUrl() : $setting');

    if ($a_data['essence']) {
      if ('product' == $a_data['essence']) {
        $keyword = $this->hpm->getProductKeywordByForumla($a_data, $setting, $test_mode);
      } else {
        $keyword = trim($a_data['name']);
      }
    }

    $keyword = $this->model_extension_module_handy_product_manager->translit($keyword, $setting, $test_mode);

		hpm_log($test_mode, $keyword, 'getSeoUrl() : $keyword after translit');

    // Unique
    $keyword = $this->model_extension_module_handy_product_manager->getUniqueUrl($keyword, $test_mode);

		hpm_log($test_mode, $keyword, 'getSeoUrl() : $keyword after unique');

    return $keyword;
  }




	/* Mass Edit
  --------------------------------------------------------------------------- */
	public function massEdit() {
		$this->load->model('setting/setting');

		$this->load->model('extension/module/handy_product_manager');

		$this->load->language('catalog/product');

		$this->load->language('extension/module/handy_product_manager');

//		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
//			echo "----------------------------------------------------------------------"
//			. "</br>\$this->request->post</br>";
//			echo "<pre>";
//			print_r($this->request->post);
//			echo "</pre></br>";
//			exit;
//		}

		$this->document->addStyle('view/stylesheet/hpm.css');
		$this->document->setTitle($this->language->get('mass_edit_heading_title'));

		// Text
		$a_text = array(
			'mass_edit_title',
			'text_edit',
			'text_author',
			'text_author_support',

			'text_enabled',
			'text_disabled',

			'hpm_text_attribute_values_empty',
			'hpm_text_attribute_values_select',
			'hpm_text_option_edit',
			'entry_option_value',
			'entry_required',
			'text_yes',
			'text_no',
			'text_none',
			'text_enabled',
			'text_disabled',
			'text_input_licence_mass',

			'mass_entry_category_flag',
			'mass_entry_category',
			'mass_entry_select_all',
			'mass_entry_manufacturer',
			'mass_text_none',
			'entry_image',
			'mass_entry_attribute',
			'mass_entry_attribute_value',
			'mass_entry_option',
			'mass_text_date',
			'mass_entry_date_from',
			'mass_entry_date_before',

			'hpm_filter_text_min',
			'hpm_filter_text_max',

			'entry_attribute_value',
			'hpm_text_option_select',
			'button_option_value_add',
			'entry_subtract',
			'entry_option_points',
			'entry_weight',
			'entry_weight_class',
			'entry_dimension',
			'entry_length_class',
			'entry_length',
			'entry_width',
			'entry_height',

			'button_add',
			'button_remove',
			'button_execute',

			'hpm_column_identity',
			'hpm_column_description',
			'column_attribute',
			'column_option',

			'entry_keyword',
			'hpm_entry_main_category',
			'entry_category',
			'entry_manufacturer',
			'entry_sku',
			'entry_model',
			'entry_price',
			'entry_points',

			'hpm_entry_discount',
			'hpm_entry_special',
			'hpm_entry_customer_group',
			'entry_priority',
			'hpm_entry_date_start',
			'hpm_entry_date_end',
			'entry_quantity',
			'entry_stock_status',
			'entry_status',
			'entry_noindex',
			'entry_store',
			'entry_minimum',
			'entry_shipping',
			'entry_subtract',
			'entry_date_available',

			'text_default',
			'entry_flag',
			'entry_category_flag',
			'text_flag_reset_add',
			'text_flag_add',
			'text_flag_and',
			'text_flag_or',
			'text_flag_and_category',
			'text_flag_or_category',
			'text_flag_discount_clear',
			'text_flag_special_clear',

			'text_available_vars',
			'entry_name',
			'entry_meta_title',
			'entry_meta_description',
			'entry_meta_keyword',
			'entry_tag',
			'entry_description',

			'tab_attribute',
			'tab_option',

			'text_processing',
			'error_ajax_response',
		);

		foreach ($a_text as $item) {
			$data[$item] = $this->language->get($item);
		}

		// H1
		$data['h1'] = $this->model_extension_module_handy_product_manager->getH1();
		$data['entry_' . $data['h1']]	= $this->language->get('entry_' . $data['h1']);

		// Breadcrumbs
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/handy_product_manager', 'token=' . $this->session->data['token'], true)
		);

		// Data
		$data['token'] = $this->session->data['token'];

		$data['test_mode'] = $this->config->get('hpm_test_mode');
		$data['a_product_list_field']	= $this->config->get('hpm_product_list_field');
		$data['hpm_system'] = $this->config->get('hpm_system');

		// todo ??
		$data['valid_licence'] = $this->hpm->isValidLicence($this->config->get('hpm_licence'));

		// Language
		$this->load->model('localisation/language');

		$data['languages']					 = $this->model_localisation_language->getLanguages();
		$data['config_language_id']	 = $this->config->get('config_language_id');
		$data['config_language']		 = $this->config->get('config_language'); // check versions

//		$data['a_languages_for_js'] = array();
//
//		foreach ($data['languages'] as $key => $value) {
//			$data['a_languages_for_js'][] = $value['language_id'];
//		}
//
//		$data['a_languages_for_js'] = json_encode($data['a_languages_for_js']);

		// Store
		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		// Category
		$this->load->model('catalog/category');

		$filter_data = array(
			'sort'	 => 'name',
			'order'	 => 'ASC'
		);

		$data['all_categories'] = $this->model_catalog_category->getCategories($filter_data);

		$data['has_main_category_column'] = $this->model_extension_module_handy_product_manager->hasMainCategoryColumn();

		// Category Tree for js
		$data['categories'] = array();

		$categories = $this->model_extension_module_handy_product_manager->getCategoriesLevel1();

		foreach ($categories as $category_id) {
			$data['categories'][] = $this->model_extension_module_handy_product_manager->getDescendantsTreeForCategory($category_id);
		}

		$mass_filter_categories_selected = array();

		if (isset($this->request->post['mass_filter']['category'])) {
			$mass_filter_categories_selected = $this->request->post['mass_filter']['category'];
		}

		$data['mass_filter_category_tree'] = $this->hpm->getCategoriesList($data['categories'], $mass_filter_categories_selected, $level = 1, 'mass_filter[category]');

		$categories_selected = array();

		if (isset($this->request->post['categories'])) {
			$categories_selected = $this->request->post['categories'];
		}

		$data['category_tree'] = $this->hpm->getCategoriesList($data['categories'], $categories_selected, $level = 1, 'categories');

		// List Fields
		$data['a_product_list_field']	 = $this->config->get('hpm_product_list_field');

		// Custom Fields
		$data['a_product_list_field_custom'] = $this->config->get('hpm_product_list_field_custom');

		if (!$data['a_product_list_field_custom']) {
			$data['a_product_list_field_custom'] = array();
		}

		// Не показывать поля, у которых не включен статус
		foreach ($data['a_product_list_field_custom'] as $field => $value) {
			if ('on' != $value['status']) {
				unset($data['a_product_list_field_custom'][$field]);
			}
		}

		// Separate Custom Fields With Price
		$data['a_product_list_field_custom_price'] = array();

		foreach ($data['a_product_list_field_custom'] as $field => $value) {
			if ('price' == $value['field_type']) {
				$data['a_product_list_field_custom_price'][$field] = $data['a_product_list_field_custom'][$field];
				unset($data['a_product_list_field_custom'][$field]);
			}
		}

		// Weight Class
		$this->load->model('localisation/weight_class');

		$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();
		
		// Length Class
		$this->load->model('localisation/length_class');

		$data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();

		// Manufacturer
		$this->load->model('catalog/manufacturer');

		$data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();

		// Stock Status
		$this->load->model('localisation/stock_status');

		$data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

		// Attributes
		$this->load->model('catalog/attribute');

		$data['attributes'] = $this->model_catalog_attribute->getAttributes();

		// Option
		$this->load->model('catalog/option');

		$data['options'] = $this->model_catalog_option->getOptions();

		// for js
		$data['optionsExist'] = array();

		foreach ($data['options'] as $key => $value) {
			$data['optionsExist'][$value['option_id']] = $value;
		}

		$data['optionsExist'] = json_encode($data['optionsExist']);

		// Customer Group
		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		// Parts
		$data['header']			 = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer']			 = $this->load->controller('common/footer');

		// Render view
		$this->response->setOutput($this->load->view('extension/module/hpm_mass_edit', $data));
	}


	public function massEditProcessing() {
		// Делаю сложный запрос, в котором есть подзапрос на поиск товаров по заданному фильтру
		// Так как запросы не односложные (переменные в описаниях), необходимость затирать и доавлять фильтры, опции и категории,
		// то варинат с одним запросом отпадает!
		// Шаг 1: Обрабатываю полученные данные
		// Шаг 2: Получаю список товаров
		// Шаг 3: Поочередно выполняю запросы
		// - Описания - поочередно для каждого товара (или замена подстрок прямо в SQL - если только такое возможно)
		// - Данные таблицы товаров + опять же плюсация к цене - в php или MySQL?
		// - Доп данные, вроде скидки, категории, магазины,

		//sleep(1);

		$json = array();

		$this->load->model('setting/setting');

		$this->load->model('extension/module/handy_product_manager');

		$this->load->language('extension/module/handy_product_manager');

		if (!$this->hpm->isValidLicence($this->config->get('hpm_licence'))) {
			$json['error'] = true;
			$json['answer'] = $this->language->get('text_input_licence_mass');

			goto block_finish;
		}

		$test_mode = $this->config->get('hpm_test_mode');

		hpm_log($test_mode, $this->request->post, 'massEditProcessing() : $this->request->post');

		// H1
		$h1 = $this->model_extension_module_handy_product_manager->getH1();

		if ('POST' === $this->request->server['REQUEST_METHOD'] && $this->validateMassEdit()) {

			hpm_log($test_mode, $this->request->post['description'], 'Description POST in begin: $this->request->post[\'description\']');
			$step = $this->request->post['step'];

			// limit
			//$limit_n = $this->config->get('hpm_limit');
			$limit_n = 200;

			// default 200
			if (!$limit_n) {
				$limit_n = 200;
			}

			$setting = array(
				'language_id'	=> $this->config->get('hpm_language'),
				'translit_function' => $this->config->get('hpm_translit_function'),
				'translit_formula' => $this->config->get('hpm_translit_formula'),
				'system' => $this->config->get('hpm_system'), // ?? if need
			);

			$filter = array_merge($this->request->post['mass_filter'], array(
				'limit' => $limit_n,
			));

			// Get products number
			$n_products = $this->model_extension_module_handy_product_manager->countProductsForMassEdit($filter, $test_mode);



			if (false === $n_products) {
				$json['error']= true;
				$json['answer']	= $this->language->get('error_no_count');
				goto block_finish;
			}

			if (0 == $n_products) {
				$json['error']= true;
				$json['answer']	= $this->language->get('error_no_products');
				goto block_finish;
			}

			$steps_all = ceil($n_products / $limit_n);

			$limits = array(
				'first_element'	 => $limit_n * $step - $limit_n,
				'limit_n' => $limit_n
			);

	//		if ($test_mode) {
	//			file_put_contents(
	//				$this->request->server['DOCUMENT_ROOT'] . "/handy_product_manager.log", date("Y-m-d H:i:s") . " : " . PHP_EOL
	//				. "DATA:" . PHP_EOL
	//				. "\$n_products = $n_products" . PHP_EOL
	//				. "\$steps_all       = $steps_all" . PHP_EOL
	//				. "\$first_element = " . ($limit_n * $step - $limit_n) . PHP_EOL
	//				. "\$limit_n = $limit_n" . PHP_EOL
	//				. "------------------------------------------" . PHP_EOL . PHP_EOL, FILE_APPEND | LOCK_EX
	//			);
	//		}

			// Products list
			$products = $this->model_extension_module_handy_product_manager->getProductsForEditOnIteration($filter, $limits, $test_mode);

			if (count($products) > 0) {
				hpm_log($test_mode, $products, '$products');

				### Поодиночное редактирование отдельно взятого товара
				foreach ($products as $product_id) {
					hpm_log($test_mode, $product_id, '$product_id');

					$product_was_edit = false;

					// SEO URL
					// Генерим только пустые!! Редиректов не будет, поэтому либо так, либо модуль SEO URL Generator PRO
					$generate_url_for_item = false;

					$keyword_old = $this->model_extension_module_handy_product_manager->getURL('product', $product_id, $test_mode);

					if (!$keyword_old) {
						$generate_url_for_item = true;
					}

					if ($generate_url_for_item) {
						$keyword_new_res = $this->model_extension_module_handy_product_manager->setURL('product', 'product_id', $product_id, $setting, $test_mode);
					}

					// Category
					hpm_log($test_mode, 'Prepare Category');

					if (isset($this->request->post['categories']) || (isset($this->request->post['main_category_id']) && $this->request->post['main_category_id'])) {
						$data = array(
							'product_id' => $product_id,
							'main_category_id' => $this->request->post['main_category_id'],
							'category_flag' => $this->request->post['category_flag'],
							'categories' => isset($this->request->post['categories']) ? $this->request->post['categories'] : array(),
						);

						$this->model_extension_module_handy_product_manager->massEditCategory($data, $test_mode);
					}

					// Manufacturer
					hpm_log($test_mode, 'Prepare Manufacturer');

					// is required
					if($this->request->post['manufacturer_id']) {
						$this->model_extension_module_handy_product_manager->massEditManufacturer($this->request->post['manufacturer_id'], $product_id, $test_mode);

						$product_was_edit = true;
					}

					// Weight
					hpm_log($test_mode, 'Prepare Weight');

					if(isset($this->request->post['weight']) && $this->request->post['weight']) {
						$this->model_extension_module_handy_product_manager->massEditWeightField(trim($this->request->post['weight']), $product_id, $test_mode);

						$product_was_edit = true;
					}

					// Weight Class
					hpm_log($test_mode, 'Prepare Weight Class');

					if (isset($this->request->post['weight_class_id']) && '*' != $this->request->post['weight_class_id']) {
						$this->model_extension_module_handy_product_manager->massEditWeightClassField($this->request->post['weight_class_id'], $product_id, $test_mode);
					}

					// Price
					hpm_log($test_mode, 'Prepare Price');

					// is required
					if($this->request->post['price']) {
						$this->model_extension_module_handy_product_manager->massEditPriceField('price', $this->request->post['price'], $product_id, $test_mode);

						$product_was_edit = true;
					}

					// Custom Fields With Price
					hpm_log($test_mode, 'Prepare Custom Fields With Price');

					$data['a_product_list_field_custom'] = $this->config->get('hpm_product_list_field_custom');

					if (!$data['a_product_list_field_custom']) {
						$data['a_product_list_field_custom'] = array();
					}

					foreach ($data['a_product_list_field_custom'] as $field => $value) {
						if ('on' != $value['status']) {
							unset($data['a_product_list_field_custom'][$field]);
						}
					}

					$data['a_product_list_field_custom_price'] = array();

					foreach ($data['a_product_list_field_custom'] as $field => $value) {
						if ('price' == $value['field_type']) {
							$data['a_product_list_field_custom_price'][$field] = $data['a_product_list_field_custom'][$field];
							unset($data['a_product_list_field_custom'][$field]);
						}
					}

					foreach ($data['a_product_list_field_custom_price'] as $field => $item) {
						if (isset($this->request->post[$field]) && $this->request->post[$field]) {
							$this->model_extension_module_handy_product_manager->massEditPriceField($field, $this->request->post[$field], $product_id, $test_mode);

							$product_was_edit = true;
						}
					}

					// Discount
					hpm_log($test_mode, 'Prepare Discount');

					if (isset($this->request->post['discount'])) {
						$this->model_extension_module_handy_product_manager->massEditDiscount($this->request->post['discount'], $product_id, $test_mode);
					}

					// Special
					hpm_log($test_mode, 'Prepare Special');

					if (isset($this->request->post['special'])) {
						$this->model_extension_module_handy_product_manager->massEditSpecial($this->request->post['special'], $product_id, $test_mode);

						$product_was_edit = true;
					}

					// Points
					hpm_log($test_mode, 'Prepare Points');

					if (isset($this->request->post['points']) && $this->request->post['points']) {
						$this->model_extension_module_handy_product_manager->massEditPoints($this->request->post['points'], $product_id, $test_mode);

						$product_was_edit = true;
					}

					// Product Reward
					hpm_log($test_mode, 'Prepare Product Reward');

					if (isset($this->request->post['product_reward'])) {
						$this->model_extension_module_handy_product_manager->massEditProductReward($this->request->post['product_reward'], $product_id, $test_mode);

						$product_was_edit = true;
					}

					// Quantity
					hpm_log($test_mode, 'Prepare Quantity');

					$this->request->post['quantity'] = trim($this->request->post['quantity']);

					if (isset($this->request->post['quantity']) && !empty($this->request->post['quantity'])) {
						$this->model_extension_module_handy_product_manager->massEditQuantityField($this->request->post['quantity'], $product_id, $test_mode);

						$product_was_edit = true;
					}

					// Minimum
					hpm_log($test_mode, 'Prepare Minimum');

					if (isset($this->request->post['minimum'])) {
						$this->request->post['minimum'] = trim($this->request->post['minimum']);

						if (!empty($this->request->post['minimum'])) {
							$this->model_extension_module_handy_product_manager->massEditMinimumField($this->request->post['minimum'], $product_id, $test_mode);

							$product_was_edit = true;
						}
					}

					// Stock Status
					hpm_log($test_mode, 'Prepare Stock Status');

					if (isset($this->request->post['stock_status_id']) && '*' != $this->request->post['stock_status_id']) {
						$this->model_extension_module_handy_product_manager->massEditStockStatusField($this->request->post['stock_status_id'], $product_id, $test_mode);
					}

					// Status
					hpm_log($test_mode, 'Prepare Status');

					if (isset($this->request->post['status']) && '*' != $this->request->post['status']) {
						$this->model_extension_module_handy_product_manager->massEditStatusField($this->request->post['status'], $product_id, $test_mode);

						$product_was_edit = true;
					}

					// Noindex
					hpm_log($test_mode, 'Prepare Noindex');

					if (isset($this->request->post['noindex']) && '*' != $this->request->post['noindex']) {
						$this->model_extension_module_handy_product_manager->massEditNoindexField($this->request->post['noindex'], $product_id, $test_mode);
					}

					// Subtract
					hpm_log($test_mode, 'Prepare Subtract');

					if (isset($this->request->post['subtract']) && '*' != $this->request->post['subtract']) {
						$this->model_extension_module_handy_product_manager->massEditSubtractField($this->request->post['subtract'], $product_id, $test_mode);

						$product_was_edit = true;
					}

					// Shipping
					hpm_log($test_mode, 'Prepare Shipping');

					if (isset($this->request->post['shipping']) && '*' != $this->request->post['shipping']) {
						$this->model_extension_module_handy_product_manager->massEditShippingField($this->request->post['shipping'], $product_id, $test_mode);

						$product_was_edit = true;
					}

					// Date Available
					hpm_log($test_mode, 'Prepare Date Available');

					$this->request->post['date_available'] = trim($this->request->post['date_available']);

					if (isset($this->request->post['date_available']) && !empty($this->request->post['date_available'])) {
						$this->model_extension_module_handy_product_manager->massEditDateAvailableField($this->request->post['date_available'], $product_id, $test_mode);

						$product_was_edit = true;
					}

					// Product Store
					hpm_log($test_mode, 'Prepare Product Store');

					if (isset($this->request->post['product_store'])) {
						$this->model_extension_module_handy_product_manager->massEditProductStore($this->request->post['product_store'], $product_id, $test_mode);
					}

					// Description
					if (isset($this->request->post['description'])) {
						hpm_log($test_mode, 'Prepare Description');

						require_once DIR_SYSTEM . 'library/hpm/TextRandomizer.php';

						// Внимание!
						// Попытка вывести рандомизацию в модель была провалена...
						// Если передавать $tRand как свойство, он не работает, как надо
						// И даже использование одного экземпляра класса оборачивается багом...

						$this->load->model('catalog/product');

						$product_info = $this->model_catalog_product->getProduct($product_id);

						$product_description = $this->model_catalog_product->getProductDescriptions($product_id);// for old text require text-blocks

						hpm_log($test_mode, $product_description, 'Description : $product_description');

						hpm_log($test_mode, $this->request->post['description'], 'Description POST: $this->request->post[\'description\']');

						$manufacturer = $this->model_extension_module_handy_product_manager->getManufacturerNameById($product_info['manufacturer_id']);

						foreach	($this->request->post['description'] as $language_id => $value) {
							// language_id появляется только здесь, не раньше
							$search = array('&nbsp;', '[product_name]', '[manufacturer]', '[manufacturer_name]', '[sku]', '[model]');

							$replace = array('', $product_description[$language_id]['name'], $manufacturer, $manufacturer, $product_info['sku'], $product_info['model']);
							$tmp = array();

							// Name
							//
							// Не генерировать рандом и не превращат переменную [product_name]
							// Внимание!
							// Значение данного поля должно попадать в другие тексты!!

							if (!empty(strip_tags(html_entity_decode($value['name'])))) {
								$tmp['name'] = $this->model_extension_module_handy_product_manager->replaceVars($search, $replace, $value['name'], $test_mode);

								// update name for other text fields!
								$replace = array('', $tmp['name'], $manufacturer, $manufacturer, $product_info['sku'], $product_info['model']);

								$product_was_edit = true;

							} else {
								$tmp['name'] = 'nofollow';
							}

							// h1
							if ($h1 && isset($value[$h1]) && !empty(strip_tags(html_entity_decode($value[$h1])))) {
								$tRand = new Natty_TextRandomizer();

								$tRand->setText($this->model_extension_module_handy_product_manager->replaceVars($search, $replace, $value[$h1], $test_mode));

								$tmp[$h1] = $tRand->getText();

								$product_was_edit = true;

							} else {
								$tmp[$h1] = 'nofollow';
							}

							// Meta Title
							if (!empty(strip_tags(html_entity_decode($value['meta_title'])))) {
								$tRand = new Natty_TextRandomizer();

								$tRand->setText($this->model_extension_module_handy_product_manager->replaceVars($search, $replace, $value['meta_title'], $test_mode));

								$tmp['meta_title'] = $tRand->getText();

								$product_was_edit = true;

							} else {
								$tmp['meta_title'] = 'nofollow';
							}

							// Meta Description
							if (!empty(strip_tags(html_entity_decode($value['meta_description'])))) {
								$tRand = new Natty_TextRandomizer();

								$tRand->setText($this->model_extension_module_handy_product_manager->replaceVars($search, $replace, $value['meta_description'], $test_mode));

								$tmp['meta_description'] = $tRand->getText();

								$product_was_edit = true;

							} else {
								$tmp['meta_description'] = 'nofollow';
							}

							// Meta Keyword
							if (!empty(strip_tags(html_entity_decode($value['meta_keyword'])))) {
								$tRand = new Natty_TextRandomizer();

								$tRand->setText($this->model_extension_module_handy_product_manager->replaceVars($search, $replace, $value['meta_keyword'], $test_mode));

								$tmp['meta_keyword'] = $tRand->getText();

								$product_was_edit = true;

							} else {
								$tmp['meta_keyword'] = 'nofollow';
							}

							// Description

							$description0 = html_entity_decode($value['description']);
//							hpm_log($test_mode, $description0, '$description0:html_entity_decode');

							$description0 = strip_tags($description0);
//							hpm_log($test_mode, $description0, '$description0:strip_tags');

							$description0 = preg_replace(array('/&nbsp;/', '/\s+/'), array('', ''), $description0);

//							hpm_log($test_mode, $description0, '$description0:str_replace');

							if (!empty($description0)) {

								hpm_log($test_mode, $description0, 'if (!empty($description0)) {');
								$tRand = new Natty_TextRandomizer();

								$tRand->setText($this->model_extension_module_handy_product_manager->replaceVars($search, $replace, $value['description'], $test_mode));

								$tmp['description'] = $tRand->getText();

								$product_was_edit = true;

							} else {
								$tmp['description'] = 'nofollow';
							}

							// Tag
							if (!empty(strip_tags(html_entity_decode($value['tag'])))) {
								$tRand = new Natty_TextRandomizer();

								$tRand->setText($this->model_extension_module_handy_product_manager->replaceVars($search, $replace, $value['tag'], $test_mode));

								$product_was_edit = true;

							} else {
								$tmp['tag'] = 'nofollow';
							}

							hpm_log($test_mode, $tmp, 'massEditDescription() : $tmp description');

							// Запрос в базу для каждого языка по отдельности
							$this->model_extension_module_handy_product_manager->massEditDescription($tmp, $product_id, $language_id, $test_mode);

							unset($tmp);
							unset($tRand);
						}
					}

					// Attribute
					if (isset($this->request->post['attribute'])) {
						$data = array(
							'product_id' => $product_id,
							'attribute_flag' => $this->request->post['attribute_flag'],
							'attribute' => $this->request->post['attribute'],
							'attribute_value' => $this->request->post['attribute_value'],
						);

						$this->model_extension_module_handy_product_manager->massEditAttribute($data, $test_mode);

						$product_was_edit = true;

						unset($data);
					}

					// Option
					if (isset($this->request->post['option'])) {
						$data = array(
							'product_id' => $product_id,
							'option_flag' => $this->request->post['option_flag'],
							'option' => $this->request->post['option'],
						);

						$this->model_extension_module_handy_product_manager->massEditOption($data, $test_mode);

						$product_was_edit = true;

						unset($data);
					}

					if ($product_was_edit) {
						$this->model_extension_module_handy_product_manager->massEditDate($product_id, $test_mode);
					}

				}
			}

			if (!isset($json['error'])) {
				// success

				if ($step == $steps_all) {
					$json['answer'] = $this->language->get('success_item_step_finish');

					$this->cache->delete('seo_pro');
					$this->cache->delete('product.seopath');

					$this->model_extension_module_handy_product_manager->callByMassEdit($test_mode);

				} else {
					$json['answer'] = sprintf($this->language->get('success_item_step'), $step, $steps_all);
				}

			} else {
				$json['answer'] = sprintf($this->language->get('error_item_step'), $step, $steps_all);
			}

			hpm_log($test_mode, $json, '$json');

			$json['step'] = $step++;

			$json['steps_all'] = $steps_all;
		} else {
			// Error
			if (isset($this->error['errors'])) {
				$json['error'] = true;
				$json['answer'] = '';

				$i = 0;
				foreach ($this->error['errors'] as $error) {
					$json['answer'] .= $i ? '<br>' : '';
					// description is array error...
					if (is_string($error)) {
						$json['answer'] .= $error;
					} elseif(is_array($error)) {
						foreach ($error as $error_item) {
							$n = 0;
							foreach ($error_item as $item) {
								$json['answer'] .= $n ? '<br>' : '';
								$json['answer'] .= $item;
							}
						}
					}

					$i++;
				}
			}
		}

		block_finish:

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function validateMassEdit() {
		$this->load->model('extension/module/handy_product_manager');

		$this->load->language('extension/module/handy_product_manager');

		$this->load->model('localisation/language');

		$test_mode = $this->config->get('hpm_test_mode');

		hpm_log($test_mode, 'validateMassEdit() is called');
		hpm_log($test_mode, $this->error, 'validateMassEdit():$this->error');
		hpm_log($test_mode, !$this->error, 'validateMassEdit():!$this->error');

		$languages = $this->model_localisation_language->getLanguages();

		$languages2 = array();

		foreach ($languages as $language) {
			$languages2[$language['language_id']] = $language;
		}

		// Приготовить ключи массивов для проверки - ведь не всегда будет с нуля, так как пользователь может удалить нулевой элемент,
		// а потом добавить новый
		$attribute_first_key = 0;
		if (isset($this->request->post['mass_filter']['attribute'])) {
			foreach ($this->request->post['mass_filter']['attribute'] as $key => $value) {
				$attribute_first_key = $key;
			}
		}

		$option_first_key = 0;
		if (isset($this->request->post['mass_filter']['option'])) {
			foreach ($this->request->post['mass_filter']['option'] as $key => $value) {
				$option_first_key = $key;
			}
		}

		// Если не выбрано ничего в фильтре, то обязательно наличие галочки, которая подтверждает, что человек хочет изменить ВСЕ товары
		if (!isset($this->request->post['mass_filter']['category'])
			&& ( !isset($this->request->post['mass_filter']['main_category_id']) || (isset($this->request->post['mass_filter']['main_category_id']) && !$this->request->post['mass_filter']['main_category_id']))
			&& !isset($this->request->post['mass_filter']['manufacturer'])
			&& '*' == $this->request->post['mass_filter']['status']
			&& '*' == $this->request->post['mass_filter']['image']
			&& !$this->request->post['mass_filter']['date_from']
			&& !$this->request->post['mass_filter']['date_before']
			&& !$this->request->post['mass_filter']['price_min']
			&& !$this->request->post['mass_filter']['price_max']
			&& !$this->request->post['mass_filter']['quantity_min']
			&& !$this->request->post['mass_filter']['quantity_max']
			&& (!isset($this->request->post['mass_filter']['attribute']) || isset($this->request->post['mass_filter']['attribute'][$attribute_first_key]) == '*' )
			&& (!isset($this->request->post['mass_filter']['option']) || isset($this->request->post['mass_filter']['option'][$option_first_key]) == '*' )
			&& !isset($this->request->post['mass_filter']['select_all'])) {

			$this->error['errors']['error_select_all_need'] = $this->language->get('error_select_all_need');
		}

		// Если выбрана галочка всех товаров, но есть и другие фильтры
		if ((
			isset($this->request->post['mass_filter']['category'])
			|| (isset($this->request->post['mass_filter']['main_category_id']) && $this->request->post['mass_filter']['main_category_id'])
			|| isset($this->request->post['mass_filter']['manufacturer'])
			|| '*' != $this->request->post['mass_filter']['status']
			|| '*' != $this->request->post['mass_filter']['image']
			|| $this->request->post['mass_filter']['date_from']
			|| $this->request->post['mass_filter']['date_before']
			|| $this->request->post['mass_filter']['price_min']
			|| $this->request->post['mass_filter']['price_max']
			|| $this->request->post['mass_filter']['quantity_min']
			|| $this->request->post['mass_filter']['quantity_max']
			|| (isset($this->request->post['mass_filter']['attribute'][$attribute_first_key]) && $this->request->post['mass_filter']['attribute'][$attribute_first_key] != '*')
			|| (isset($this->request->post['mass_filter']['option'][$option_first_key]) && $this->request->post['mass_filter']['option'][$option_first_key] != '*')
			) && isset($this->request->post['mass_filter']['select_all'])) {

			$this->error['errors']['error_select_all_remove'] = $this->language->get('error_select_all_remove');
		}

		// ?? Что это значит ??
		// Проверка на незаполненность данных для редактирования...

		foreach ($this->request->post['description'] as $language_id => $value) {
			if (!empty(strip_tags(html_entity_decode($value['name'])))) {
				// Ловим наличие [product_name]
				if (false !== strpos($value['name'], '[product_name]')) {
					$this->error['errors']['description'][$language_id]['name'] = sprintf($this->language->get('error_edit_var_not_allowed'), '"name ' . $languages2[$language_id]['name'] . '"');

				}
			}
		}

		if (isset($this->error['errors'])) {
			hpm_log($test_mode, $this->error['errors'], 'validateMassEdit():$this->error[\'errors\']');
		}


		return !$this->error;
	}





	/* Licence
  --------------------------------------------------------------------------- */
  public function saveLicence() {
    $this->load->model('setting/setting');

    $this->load->language('extension/module/handy_product_manager');

    $json = array();

    $licence = trim($this->request->post['licence']);

    if ($this->hpm->isValidLicence($licence)) {
      $this->model_setting_setting->editSetting('hpm', array('hpm_licence' => $licence));
      $json['success'] = $this->language->get('success_licence');
    } else {
      $json['error'] = $this->language->get('error_licence');
    }

    header("Content-type: application/json; charset=UTF-8");
    echo json_encode($json);
    exit;
  }


}
