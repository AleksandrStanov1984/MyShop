<?php
class ControllerExtensionModuleCreditprivat extends Controller {

	public function index() {
		 
		$this->load->language('extension/module/creditprivat');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_buycredit'] = $this->language->get('text_buycredit');

        if (isset($this->request->get['product_id'])) {
            $product_id = $this->request->get['product_id'];
        } else {
            $product_id = 0;
        }
		
		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);
		$credit_info = $this->model_catalog_product->getProductPrivat($this->request->get['product_id']);
		
		$status = false;
		
		if ($product_info) {

			if ((float)$product_info['special']) {
				$creditprice = $product_info['special'];
			} else {
				$creditprice = $product_info['price'];
			}

			if ($this->config->get('privatbank_paymentparts_pp_status') == 1) {
				if ((!$this->config->get('privatbank_paymentparts_pp_product_allowed') && ($this->config->get('privatbank_paymentparts_pp_enabled') == 0)) || ($this->config->get('privatbank_paymentparts_pp_product_allowed') && in_array($product_id, $this->config->get('privatbank_paymentparts_pp_product_allowed')))) {
					if ( ($this->config->get('privatbank_paymentparts_pp_min_total') <= $creditprice) && (($this->config->get('privatbank_paymentparts_pp_max_total')) >= $creditprice)) {
						$status = true;
					}
				}
				
				if ($credit_info) {
					if (($this->config->get('privatbank_paymentparts_pp_enabled') == 1) && $credit_info['product_pp'] !=0) {
						$status = true;
					}
				}
			}			
			
			if ($this->config->get('privatbank_paymentparts_ii_status') == 1) {
				if ((!$this->config->get('privatbank_paymentparts_ii_product_allowed') && ($this->config->get('privatbank_paymentparts_ii_enabled') == 0)) || ($this->config->get('privatbank_paymentparts_ii_product_allowed') && in_array($product_id, $this->config->get('privatbank_paymentparts_ii_product_allowed')))) {
					if ( ($this->config->get('privatbank_paymentparts_ii_min_total') <= $creditprice) && (($this->config->get('privatbank_paymentparts_ii_max_total')) >= $creditprice)) {
						$status = true;
					}
				}
				
				if ($credit_info) {
					if (($this->config->get('privatbank_paymentparts_ii_enabled') == 1) && $credit_info['product_ii'] !=0) {
						$status = true;
					}
				}
			}			
		}
		
		if ($status) {
			return $this->load->view('extension/module/credit_button', $data);
		}
    }
	
	public function loadpopup(){
		
		$this->load->language('extension/module/creditprivat');
		$data['credit_text'] = $this->language->get('credit_text');
		$data['button_continue'] = $this->language->get('button_continue');
		$data['language'] = substr($this->session->data['language'], 0 ,2);
		$data['status_pp'] = false;
		$data['status_ii'] = false;		 
		
		if (isset($this->request->get['product_id'])) {
			$product_id = $this->request->get['product_id'];
		} else {
			$product_id = 0;
		}
		
		$this->load->model('catalog/product');
						
		$product_info = $this->model_catalog_product->getProduct($product_id);
		$credit_info = $this->model_catalog_product->getProductPrivat($product_id);
		
		if ($product_info) {
			
			if (isset($this->request->get['quantity'])) {
				$quantity = $this->request->get['quantity'];
			} else {
				$quantity = 1;
			}
														
			if (isset($this->request->get['option'])) {
				$option = array_filter($this->request->get['option']);
			} else {
				$option = array();	
			}
			
			$creditproduct = $this->getProduct($product_id, $quantity, $option);
			
			$replace_array = array($this->currency->getSymbolLeft($this->session->data['currency']),$this->currency->getSymbolRight($this->session->data['currency']),$this->language->get('thousand_point'));

			$data['total'] = str_replace($replace_array,"",$this->currency->format($this->tax->calculate($creditproduct['total'], $creditproduct['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']));
		}

		if ($this->config->get('privatbank_paymentparts_pp_status') == 1) {
			
			if ((!$this->config->get('privatbank_paymentparts_pp_product_allowed') && ($this->config->get('privatbank_paymentparts_pp_enabled') == 0)) || ($this->config->get('privatbank_paymentparts_pp_product_allowed') && in_array($product_id, $this->config->get('privatbank_paymentparts_pp_product_allowed')))) {
			
				if ( ($this->config->get('privatbank_paymentparts_pp_min_total') <= $creditproduct['total']) && (($this->config->get('privatbank_paymentparts_pp_max_total')) >= $creditproduct['total'])) {
					$data['status_pp'] = true;
				}
			}
			
			if ($credit_info) {
				if (($this->config->get('privatbank_paymentparts_pp_enabled') == 1) && $credit_info['product_pp'] !=0) {
					$data['status_pp'] = true;
				}
			}
		}

		if ($this->config->get('privatbank_paymentparts_ii_status') == 1) {
			
			if ((!$this->config->get('privatbank_paymentparts_ii_product_allowed') && ($this->config->get('privatbank_paymentparts_ii_enabled') == 0)) || ($this->config->get('privatbank_paymentparts_ii_product_allowed') && in_array($product_id, $this->config->get('privatbank_paymentparts_ii_product_allowed')))) {
			
				if ( ($this->config->get('privatbank_paymentparts_ii_min_total') <= $creditproduct['total']) && (($this->config->get('privatbank_paymentparts_ii_max_total')) >= $creditproduct['total'])) {
					$data['status_ii'] = true;
				}
			}
			
			if ($credit_info) {
				if (($this->config->get('privatbank_paymentparts_ii_enabled') == 1) && ($credit_info['product_ii'] !=0)) {
					$data['status_ii'] = true;
				}
			}
		}

		$data['partsCountpp'] = (!$this->config->get('privatbank_paymentparts_pp_paymentquantity') ? '24' : $this->config->get('privatbank_paymentparts_pp_paymentquantity'));
		$data['partsCountii'] = (!$this->config->get('privatbank_paymentparts_ii_paymentquantity') ? '24' : $this->config->get('privatbank_paymentparts_ii_paymentquantity'));

		$data['markuppp'] = (!$this->config->get('privatbank_paymentparts_pp_markup') ? '1' : $this->config->get('privatbank_paymentparts_pp_markup'));
		$data['markupii'] = (!$this->config->get('privatbank_paymentparts_ii_markup') ? '1' : $this->config->get('privatbank_paymentparts_ii_markup'));
		
		if ($credit_info) {
			$data['partsCountpp'] = $credit_info['partscount_pp'] !=0 ? $credit_info['partscount_pp'] : $data['partsCountpp'];
			$data['partsCountii'] = $credit_info['partscount_ii'] !=0 ? $credit_info['partscount_ii'] : $data['partsCountii'];
			$data['markuppp'] = $credit_info['markup_pp'] !=0 ? $credit_info['markup_pp'] : $data['markuppp'];
			$data['markupii'] = $credit_info['markup_ii'] !=0 ? $credit_info['markup_ii'] : $data['markupii'];
		}

		$this->response->setOutput($this->load->view('extension/module/creditprivat', $data));
    }
	
    public function checkoptions() {

		$this->language->load('checkout/cart');
		
		$json = array();
		
		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}
		
		$this->load->model('catalog/product');
						
		$product_info = $this->model_catalog_product->getProduct($product_id);
		
		if ($product_info) {			
			if (isset($this->request->post['quantity'])) {
				$quantity = $this->request->post['quantity'];
			} else {
				$quantity = 1;
			}
														
			if (isset($this->request->post['option'])) {
				$option = array_filter($this->request->post['option']);
			} else {
				$option = array();	
			}
			
			$product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);
			
			foreach ($product_options as $product_option) {
				if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
					$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
				}
			}
			
			if (!$json) {
				$json['success'] = true;
			}
		}
		
		$this->response->setOutput(json_encode($json));		
    }
	
  	public function getProduct($product_id, $quantity = 1, $options) {

		$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");
		
		if ($product_query->num_rows) {
			$option_price = 0;
			$option_points = 0;
			$option_weight = 0;
			$added_product = array();
			$option_data = array();
				foreach ($options as $product_option_id => $option_value) {
					$option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");
					
					if ($option_query->num_rows) {
						if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
							$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$option_value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
							
							if ($option_value_query->num_rows) {
								if ($option_value_query->row['price_prefix'] == '+') {
									$option_price += $option_value_query->row['price'];
								} elseif ($option_value_query->row['price_prefix'] == '-') {
									$option_price -= $option_value_query->row['price'];
								}
								
								if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity))) {
									$stock = false;
								}
								
								$option_data[] = array(
									'product_option_id'       => $product_option_id,
									'product_option_value_id' => $option_value,
									'option_id'               => $option_query->row['option_id'],
									'option_value_id'         => $option_value_query->row['option_value_id'],
									'name'                    => $option_query->row['name'],
									'option_value'            => $option_value_query->row['name'],
									'type'                    => $option_query->row['type'],
									'quantity'                => $option_value_query->row['quantity'],
									'subtract'                => $option_value_query->row['subtract'],
									'price'                   => $option_value_query->row['price'],
									'price_prefix'            => $option_value_query->row['price_prefix']
								);								
							}
						} elseif ($option_query->row['type'] == 'checkbox' && is_array($option_value)) {
							foreach ($option_value as $product_option_value_id) {
								$option_value_query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
								
								if ($option_value_query->num_rows) {
									if ($option_value_query->row['price_prefix'] == '+') {
										$option_price += $option_value_query->row['price'];
									} elseif ($option_value_query->row['price_prefix'] == '-') {
										$option_price -= $option_value_query->row['price'];
									}
									
									if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $quantity))) {
										$stock = false;
									}
									
									$option_data[] = array(
										'product_option_id'       => $product_option_id,
										'product_option_value_id' => $product_option_value_id,
										'option_id'               => $option_query->row['option_id'],
										'option_value_id'         => $option_value_query->row['option_value_id'],
										'name'                    => $option_query->row['name'],
										'option_value'            => $option_value_query->row['name'],
										'type'                    => $option_query->row['type'],
										'quantity'                => $option_value_query->row['quantity'],
										'subtract'                => $option_value_query->row['subtract'],
										'price'                   => $option_value_query->row['price'],
										'price_prefix'            => $option_value_query->row['price_prefix']
									);								
								}
							}						
						}
					}
				} 
		
			if ($this->customer->isLogged()) {
					$customer_group_id = $this->customer->getGroupId();
				} else {
					$customer_group_id = $this->config->get('config_customer_group_id');
				}
			
			$price = $product_query->row['price'];
			
			// Product Discounts
			$discount_quantity = $quantity;
			
			$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND quantity <= '" . (int)$discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");
			
			if ($product_discount_query->num_rows) {
				$price = $product_discount_query->row['price'];
			}
			
			// Product Specials
			$product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");
		
			if ($product_special_query->num_rows) {
				$price = $product_special_query->row['price'];
			}						
				
			// Stock
			if (!$product_query->row['quantity'] || ($product_query->row['quantity'] < $quantity)) {
				$stock = false;
			}
			
			$added_product = array(
				'product_id'      => $product_query->row['product_id'],
				'name'            => $product_query->row['name'],
				'model'           => $product_query->row['model'],
				'shipping'        => $product_query->row['shipping'],
				'image'           => $product_query->row['image'],
				'option'          => $option_data,
				'quantity'        => $quantity,
				'minimum'         => $product_query->row['minimum'],
				'subtract'        => $product_query->row['subtract'],
				'price'           => ($price + $option_price),
				'total'           => ($price + $option_price) * $quantity,
				'tax_class_id'    => $product_query->row['tax_class_id']				
			);
		} else {
			$this->remove($key);
		}

		return $added_product;
  	}
}