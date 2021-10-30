<?php
class ModelExtensionTotalCreditprivat extends Model {
	public function getTotal($total) {
		if ($this->config->get('creditprivat_status')) {
			$this->load->language('extension/total/creditprivat');

			$products = $this->cart->getProducts();
			
			$priceup = 0;
			
			foreach ($products as $product) {
				$markup = 1;				
				if (isset ($this->session->data['payment_method']['code'])) {
					if ($this->session->data['payment_method']['code'] == 'privatbank_paymentparts_pp') {
						$privat_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_privat WHERE product_id = '" . (int)$product['product_id'] . "'");
						if (isset($privat_query->row)) {
							if (isset($privat_query->row['markup_pp']) && $privat_query->row['markup_pp'] != 0) {
								$markup = $privat_query->row['markup_pp'];
							} else {
								$markup = $this->config->get('privatbank_paymentparts_pp_markup');
							}
						}
						$priceup += ($product['total'] * $markup) - $product['total'];
					}
					if ($this->session->data['payment_method']['code'] == 'privatbank_paymentparts_ii') {
						$privat_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_privat WHERE product_id = '" . (int)$product['product_id'] . "'");
						if (isset($privat_query->row)) {
							if (isset($privat_query->row['markup_ii']) && $privat_query->row['markup_ii'] != 0) {
								$markup = $privat_query->row['markup_ii'];
							} else {
								$markup = $this->config->get('privatbank_paymentparts_ii_markup');
							}
						}
						$priceup += ($product['total'] * $markup) - $product['total'];
					}
				}
			}
			
			if ($priceup > 0) {
				$total['totals'][] = array(
					'code'       => 'creditprivat',
					'title'      => $this->language->get('text_credit'),
					'value'      => $priceup,
					'sort_order' => $this->config->get('creditprivat_sort_order')
				);

				$total['total'] += $priceup;
			}
			
		}
	}

}