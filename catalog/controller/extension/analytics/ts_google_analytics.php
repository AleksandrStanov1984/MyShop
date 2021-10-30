<?php
class ControllerExtensionAnalyticsTSGoogleAnalytics extends Controller {
	
	public function getCounter() {
		$data = array();
		
		if ($this->config->get('ts_google_analytics_status')) {
			
			$settings = $this->config->get('ts_google_analytics_settings');
			
			$data['counter'] = array(
				'counter_id' => 			$settings['counter']['counter_id'],
				'mode' =>					(int)$settings['counter']['mode'] ? true : false,
				'pageview' =>				array(
					'status' =>					(int)$settings['counter']['pageview']['status'] ? true : false,
					'title' =>					(int)$settings['counter']['pageview']['title'] ? true : false,
					'path' =>					(int)$settings['counter']['pageview']['path'] ? true : false,
					'location' =>				(int)$settings['counter']['pageview']['location'] ? true : false,
				),
				'timing' =>					array(
					'status' =>					(int)$settings['counter']['timing']['status'] ? true : false,
					'name' =>					$settings['counter']['timing']['name'],
					'category' =>				$settings['counter']['timing']['category'] ? trim($settings['counter']['timing']['category']) : false,
					'label' =>					$settings['counter']['timing']['label'] ? trim($settings['counter']['timing']['label']) : false,
				),
				'link_attr' =>				array(
					'status' =>					(int)$settings['counter']['link_attr']['status'] ? true : false,
					'name' =>					$settings['counter']['link_attr']['name'],
					'expires' =>				(int)$settings['counter']['link_attr']['expires'] ? (int)$settings['counter']['link_attr']['expires'] : false,
				),
				'linker' =>					array(
					'status' =>					(int)$settings['counter']['linker']['status'] ? true : false,
					'incoming' =>				(int)$settings['counter']['linker']['incoming'] ? true : false,
					'domains' =>				$settings['counter']['linker']['domains'] ? $settings['counter']['linker']['domains'] : false,
				),
				'ad_features' =>			(int)$settings['counter']['ad_features'] ? true : false,
				'country' =>				$settings['counter']['country'],
				'currency' =>				$settings['counter']['currency'],
				'userId' =>					$this->customer->isLogged() ? $this->customer->getId() : $this->session->getId(),				
				'userCookies' =>			array(
					'name' =>					$settings['counter']['userCookies']['name'],
					'domain' =>					$settings['counter']['userCookies']['domain'],
					'expires' =>				(int)$settings['counter']['userCookies']['expires'] ? (int)$settings['counter']['userCookies']['expires'] : false,
					'update' =>					(int)$settings['counter']['userCookies']['update'] ? true : false,
				),
				'userParams' => 			(int)$settings['userParams']['status'] ? $this->getUserParams($settings['userParams'])['params'] : false,
				'ecommerce' => 				(int)$settings['ecommerce']['status'] ? true : false,
				'goals' => 					(int)$settings['goal']['status'] ? true : false,
			);
			
		} else {
			
			$data['error'] = true;
		}
		
		return json_encode($data);
	}
	
	
	private function getUserParams($settings) {
		$data = array();
		
		if (!$this->customer->isLogged()) {
			
			$data['params'] = array(
				'userId' =>				$this->session->getId(),
				'type' =>				(int)$settings['type'] ? 'Guest' : false,
			);
			
		} else {
			
			$this->load->model('account/customer');
			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());
			
			$this->load->model('account/customer_group');
			$customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_info['customer_group_id']);
			
			$data['params'] = array(
				'userId' =>				$this->customer->getId(),
				'type' =>				(int)$settings['type'] ? 'Registered' : false,
				'group' =>				(int)$settings['group'] ? $customer_group_info['name'] : false,
				'date_added' =>			(int)$settings['date_added'] ? date('Y-m-d', strtotime($customer_info['date_added'])) : false,
				'safe' =>				(int)$settings['safe'] ? ( $customer_info['safe'] ? true : false ) : false,
				'newsletter' =>			(int)$settings['newsletter'] ? ( $customer_info['newsletter'] ? true : false ) : false,
			);
			
			$this->load->model('account/address');
			if (!empty($customer_info['address_id'])) {
				$address = $this->model_account_address->getAddress($customer_info['address_id']);
				
				$data['params'] = array_merge($data['params'], array(
					'country' =>		(int)$settings['country'] ? $address['country'] : false,
					'zone' =>			(int)$settings['zone'] ? $address['zone'] : false,
					'city' =>			(int)$settings['city'] ? $address['city'] : false,
					'postcode' =>		(int)$settings['postcode'] ? $address['postcode'] : false,
				));
			}
			
			if (isset($settings['custom_fields'])) {
				$this->load->model('account/custom_field');
				$custom_fields = $this->model_account_custom_field->getCustomFields($customer_info['customer_group_id']);
				$customer_fields = json_decode($customer_info['custom_field'], true);
				
				foreach ($settings['custom_fields'] as $custom_field_id) {
					foreach ($custom_fields as $custom_field) {
						if ($custom_field_id == $custom_field['custom_field_id'] && $customer_fields[$custom_field['custom_field_id']]) {
							$data['params'] = array_merge($data['params'], array(
								$this->translit($custom_field['name']) => $customer_fields[$custom_field['custom_field_id']],
							));
						}
					}
				}
			}
		}

		return $data;
	}
	
	
	public function writeEcommerce($data) {
		$ecommerce_array = array();
		
		if ($this->config->get('ts_google_analytics_status')) {
			
			$ecommerce_data = $this->getEcommerceData($data);
			
			if (isset($this->session->data['ts_ga_ecommerce']) && !is_null($this->session->data['ts_ga_ecommerce'])) {
				$ecommerce_array = json_decode($this->session->data['ts_ga_ecommerce'], true); 
			}
			
			$ecommerce_array[] = $ecommerce_data;
			
			$this->session->data['ts_ga_ecommerce'] = json_encode($ecommerce_array);
		}
	}
	
	
	public function trackingEcommerceClick() {
		
		if ($this->config->get('ts_google_analytics_status') && $this->config->get('ts_google_analytics_settings')['ecommerce']['status'] && $this->config->get('ts_google_analytics_settings')['ecommerce']['actionType']['click']) {
			
			if (isset($this->request->post['data'])) {
				$this->session->data['ts_ga_ecommerce_click'] = $this->request->post['data'];
			}
			$data['success'] = true;
			
		} else {
			
			$data['error'] = true;
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
	}
	
	
	public function trackingEcommerceView() {
		
		if ($this->config->get('ts_google_analytics_status') && $this->config->get('ts_google_analytics_settings')['ecommerce']['status'] && $this->config->get('ts_google_analytics_settings')['ecommerce']['actionType']['view']) {
			
			if (isset($this->request->post['data'])) {
				
				if (isset($this->session->data['ts_ga_ecommerce_view']) && !is_null($this->session->data['ts_ga_ecommerce_view'])) {
					$this->session->data['ts_ga_ecommerce_view'] = $this->multi_array_unique(array_merge($this->session->data['ts_ga_ecommerce_view'], $this->request->post['data']));
				} else {
					$this->session->data['ts_ga_ecommerce_view'] = $this->request->post['data'];
				}
			}
			$data['success'] = true;
			
		} else {
			
			$data['error'] = true;
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
	}
	
	
	public function getGoals() {
		$data = array();

		$status = true;
		if(isset($this->session->data['category_analitik'])){
            $status = false;
            unset($this->session->data['category_analitik']);
        }

		if ($this->config->get('ts_google_analytics_status') && $this->config->get('ts_google_analytics_settings')['goal']['status'] && $status) {
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ts_google_analytics_goal");
			
			foreach ($query->rows as $row) {
				$data['goals'][] = array(
					'action' =>		trim($row['action']),
					'label' =>		trim($row['label']),
					'category' =>	trim($row['category']),
					'element' =>	$row['element'],
					'event' =>		$row['event'],
					'value' =>		$row['value']
				);
			}
			
		} else {
			
			$data['error'] = true;
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($data));
	}
	
	
	private function getEcommerceData($ecommerce_data) {
		$data = array();
		
		$settings = $this->config->get('ts_google_analytics_settings');
		
		if (count($ecommerce_data['products']) > 0 && $settings['ecommerce']['status'] && $settings['ecommerce']['actionType'][$ecommerce_data['actionType']]) {
			
			$data['ecommerce']['event'] = $ecommerce_data['actionType'];
			
			if ($ecommerce_data['actionType'] == 'click') {
				$data['ecommerce']['params']['content_type'] = 'product';
			}
			
			if ($ecommerce_data['actionType'] == 'checkout' || $ecommerce_data['actionType'] == 'purchase') {
				if ((int)$settings['ecommerce']['actionField']['coupon'] && isset($this->session->data['coupon']) && $this->session->data['coupon']) {
					$data['ecommerce']['params']['coupon'] = $this->session->data['coupon'];
				}
			}

			if ($ecommerce_data['actionType'] == 'checkout') {
				$data['ecommerce']['params']['checkout_step'] = 1;
			}
			
			
			if ($ecommerce_data['actionType'] == 'purchase') {
				
				$data['ecommerce']['params']['transaction_id'] = $ecommerce_data['order_id'];
				
				if ($settings['ecommerce']['actionField']['affiliation']) {
					$data['ecommerce']['params']['affiliation'] = $this->config->get('config_name');
				}
				
				if ($settings['ecommerce']['actionField']['revenue']['status']) {
					$total = $this->getEcommerceOrderTotal(isset($settings['ecommerce']['actionField']['revenue']['codes']) ? $settings['ecommerce']['actionField']['revenue']['codes'] : array());
					if ((float)$settings['ecommerce']['actionField']['revenue']['tax']) {
						$total = number_format(($total - ($total * ((float)$settings['ecommerce']['actionField']['revenue']['tax'] / 100))), 2, '.', '');
					}
					$data['ecommerce']['params']['value'] = $total;
				}
				
				if ($settings['ecommerce']['actionField']['tax']) {
					$data['ecommerce']['params']['tax'] = array_sum($this->cart->getTaxes());
				}
				
				if ($settings['ecommerce']['actionField']['shipping'] && isset($this->session->data['shipping_method']['title'])) {
					$data['ecommerce']['params']['shipping'] = $this->session->data['shipping_method']['title'];
				}
				
				$data['ecommerce']['params']['currency'] = $this->session->data['currency'];
			}
			
			foreach ($ecommerce_data['products'] as $product) {
				
				$product_data = array();
				
				$product_data['id'] = (int)$product['product_id'];
				$product_data['name'] = $product['name'];
				
				if ((int)$settings['ecommerce']['products']['brand'] && $product['manufacturer']) {
					$product_data['brand'] = $product['manufacturer'];
				}
				
				if ((int)$settings['ecommerce']['products']['category'] && isset($product['ts_ga_category_path'])) {
					$product_data['category'] = $this->getEcommerceProductCategories($product['ts_ga_category_path']);
				}
				
				if ((int)$settings['ecommerce']['products']['variant'] && isset($product['ts_ga_options']) && !empty($product['ts_ga_options'])) {
					$product_data['variant'] = $this->getEcommerceProductOptions($product['product_id'], $product['ts_ga_options']);
				}
				
				if ((int)$settings['ecommerce']['products']['price']) {
					$product_data['price'] =  number_format($this->tax->calculate((float)$product['special'] ? $product['special'] : $product['price'], $product['tax_class_id'], $this->config->get('config_tax')), 2, '.', '');
				}
				
				if ((int)$settings['ecommerce']['products']['quantity'] && isset($product['ts_ga_quantity'])) {
					$product_data['quantity'] = ($product['ts_ga_quantity'] >= 0) ? $product['ts_ga_quantity'] : 0;
				}
				
				if ((int)$settings['ecommerce']['products']['position'] && ((isset($product['list_position']) && $product['list_position']) || $product['sort_order'])) {
					$product_data['list_position'] = ($ecommerce_data['actionType'] == 'click' || $ecommerce_data['actionType'] == 'view') ? $product['list_position'] : $product['sort_order'];
				}
				
				if ($ecommerce_data['actionType'] == 'click' || $ecommerce_data['actionType'] == 'view') {
					if ((int)$settings['ecommerce']['products']['list_name']) {
						$product_data['list_name'] = $product['list_name'];
					}
				}
				
				if ($ecommerce_data['actionType'] == 'purchase') {
					if ((int)$settings['ecommerce']['actionField']['coupon'] && isset($this->session->data['coupon']) && $this->session->data['coupon']) {
						$product_data['coupon'] = $this->session->data['coupon'];
					}
				}
				
				$data['ecommerce']['params']['items'][] = $product_data;
			}
			
			return $data;
		}
		
		return false;
	}
	
	
	private function getEcommerceProductCategories($category_path) {
		$this->load->model('catalog/category');
		
		$parts = explode('_', (string)$category_path);
		
		foreach ($parts as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);
			if ($category_info) {
				$category_name[] = $category_info['name'];
			}
		}
		return implode('/', $category_name);
	}
	
	private function getEcommerceProductOptions($product_id, $options) {
		$this->load->model('catalog/product');
		
		$option_name = array();
		
		$product_options = $this->model_catalog_product->getProductOptions($product_id);
		
		foreach ($product_options as $product_option) {
			foreach ($options as $option_id => $option_value_id) {
				if ($product_option['product_option_id'] == $option_id) {
					foreach ($product_option['product_option_value'] as $product_option_value) {
						if ($product_option_value['product_option_value_id'] == $option_value_id) {
							$option_name[] = $product_option_value['name'];
						}
					}
				}
			}
		}
		return implode(', ', $option_name);
	}
	
	private function getEcommerceOrderTotal($total_codes = array()) {

		$total_codes = array_merge($total_codes, array('sub_total', 'total'));
		$total_data = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();

		if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
			$sort_order = array();

			if (version_compare(VERSION, '3.0.0', '>=')) {
				$this->load->model('setting/extension');
				$results = $this->model_setting_extension->getExtensions('total');
			} else {
				$this->load->model('extension/extension');
				$results = $this->model_extension_extension->getExtensions('total');
			}

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get((version_compare(VERSION, '3.0.0', '>=') ? 'total_' : '') . $value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get((version_compare(VERSION, '3.0.0', '>=') ? 'total_' : '') . $result['code'] . '_status') && in_array($result['code'], $total_codes)) {
					$this->load->model('extension/total/' . $result['code']);

					$this->{'model_extension_total_' . $result['code']}->getTotal(array('totals' => &$total_data, 'total' => &$total, 'taxes' => &$taxes));
				}
			}

			$sort_order = array();

			foreach ($total_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $total_data);
		}
		return $total;
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
	
	private function multi_array_unique($array) {
		$result = array_map("unserialize", array_unique(array_map("serialize", $array)));
		foreach ($result as $key => $value) {
			if (is_array($value)) {
				$result[$key] = $this->multi_array_unique($value);
			}
		}
		return $result;
	}


}