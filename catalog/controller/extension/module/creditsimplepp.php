<?php
class ControllerExtensionModuleCreditSimplepp extends Controller {

	public function index(){
        $this->language->load('extension/payment/privatbank_paymentparts_pp');

		$data['button_confirm'] = $this->language->get('button_confirm');
        $data['text_label_partsCount'] = $this->language->get('text_label_partsCount');
		$data['text_mounth'] = $this->language->get('text_mounth');
		$data['language'] = str_replace('ua', 'uk', substr($this->session->data['language'], 0 ,2));
		$data['text_loading'] = $this->language->get('text_loading');
		
        $partsCount = 24;
		foreach ($this->cart->getProducts() as $cart) {
			$privat_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_privat WHERE product_id = '" . (int)$cart['product_id'] . "'");
			if ($privat_query->row) {
				if ($privat_query->row['partscount_pp'] <= $partsCount && $privat_query->row['partscount_pp'] !=0) {
					$partsCount = (int)$privat_query->row['partscount_pp'];
				}
			}
		}
		if ($partsCount == 24) {
			$partsCount = $this->config->get('privatbank_paymentparts_pp_paymentquantity');
		}
		
        $data['partsCounts'] = $partsCount;
		
		if (isset ($this->session->data['privatbank_paymentparts_pp_sel'])) {
			$data['partsCountSel'] = $this->session->data['privatbank_paymentparts_pp_sel'];
		} else {
			$data['partsCountSel'] = '';
		}
		
			// Totals
			$this->load->model('extension/extension');

			$totals = array();
			$taxes = $this->cart->getTaxes();
			$total = 0;

			// Because __call can not keep var references so we put them into an array.
			$total_data = array(
				'totals' => &$totals,
				'taxes'  => &$taxes,
				'total'  => &$total
			);
				
			// Display prices
			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$sort_order = array();

				$results = $this->model_extension_extension->getExtensions('total');

				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}

				array_multisort($sort_order, SORT_ASC, $results);

				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('extension/total/' . $result['code']);

						// We have to put the totals in an array so that they pass by reference.
						$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
					}
				}

				$sort_order = array();

				foreach ($totals as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $totals);
			}


		$replace_array = array('<span class="currency">' . $this->currency->getSymbolRight($this->session->data['currency']) . '</span>',$this->currency->getSymbolLeft($this->session->data['currency']),$this->currency->getSymbolRight($this->session->data['currency']),$this->language->get('thousand_point'));
		
		$data['total'] = str_replace($replace_array,"",$this->currency->format($this->tax->calculate($total, $this->config->get('tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency']));

		$this->response->setOutput($this->load->view('extension/module/credit_simple_pp', $data));
    }
}