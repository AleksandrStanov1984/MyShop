<?php
class ModelExtensionPaymentPrivatbankPaymentpartsPp extends Model {
	public function getMethod($address, $total) {
		$this->load->language('extension/payment/privatbank_paymentparts_pp');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('privatbank_paymentparts_pp_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		$status = false;
		
		$this->load->model('catalog/product');
		$products = $this->cart->getProducts();
		
		$i = 0;
		$k = 0;
		
		if (!$this->config->get('privatbank_paymentparts_pp_geo_zone_id') || $query->num_rows) {
			foreach ($products as $product) {
				$temp_status = false;
				if ((!$this->config->get('privatbank_paymentparts_pp_product_allowed') && ($this->config->get('privatbank_paymentparts_pp_enabled') == 0)) || ($this->config->get('privatbank_paymentparts_pp_product_allowed') && in_array($product['product_id'], $this->config->get('privatbank_paymentparts_pp_product_allowed')))) {
					if ( ($this->config->get('privatbank_paymentparts_pp_min_total') <= $total) && (($this->config->get('privatbank_paymentparts_pp_max_total')) >= $total)) {
						$status = true; $i++; $temp_status = true;
					}
				}
				$credit_info = $this->model_catalog_product->getProductPrivat($product['product_id']);
				if ($credit_info) {
					if (($this->config->get('privatbank_paymentparts_pp_enabled') == 1) && $credit_info['product_pp'] ==1) {
						$status = true;
						if ($temp_status == false) {
							$i++; 
						}
					}
				}
				$k++;
			}
		}
		
		if ($k > $i) {
			$status = false;
		}
		
		$method_data = array();

		if ($status) {
			$method_data = array(
				'code'       => 'privatbank_paymentparts_pp',
				'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'sort_order' => $this->config->get('privatbank_paymentparts_pp_sort_order')
			);
		}
        
		return $method_data;
	}
}
