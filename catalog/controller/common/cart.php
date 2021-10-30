<?php
class ControllerCommonCart extends Controller {
	public function index() {
		$this->load->language('common/cart');

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

		$data['text_empty'] = $this->language->get('text_empty');
		$data['text_cart'] = $this->language->get('text_cart');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_recurring'] = $this->language->get('text_recurring');
		$data['text_items'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_add_wishlist'] = $this->language->get('text_add_wishlist');
		$data['text_in_wishlist'] = $this->language->get('text_in_wishlist');
		$data['unit_h'] = $this->language->get('unit_h');
		$data['unit_w'] = $this->language->get('unit_w');
		$data['unit_l'] = $this->language->get('unit_l');
		$data['unit'] = $this->language->get('unit');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_continue'] = $this->language->get('button_continue');
		$this->load->model('tool/image');
		$this->load->model('tool/upload');

		$data['products'] = array();

		foreach ($this->cart->getProducts() as $product) {
			//url caterorii poslednego producta v korzine
			$category_products = $this->model_catalog_product->getGeneralCategorie($product['product_id']);
			if($category_products[0]['category_id']){
					$category_url = $this->url->link('product/category', 'path=' . $category_products[0]['category_id']);
			}else{
				$category_url = false;
			}
			// end url caterorii poslednego producta v korzine
			if ($product['image']) {
				//$image = $this->model_tool_image->resize($product['image'], $this->config->get($this->config->get('config_theme') . '_image_cart_width'), $this->config->get($this->config->get('config_theme') . '_image_cart_height'));
				$image = $this->model_tool_image->resize($product['image'], 125, 125);
			} else {
				$image = '';
			}
			$category_product = array();
			$category_product = $this->model_catalog_product->getMainCategory($product['product_id']);

			$option_data = array();

			foreach ($product['option'] as $option) {
				if ($option['type'] != 'file') {
					$value = $option['value'];
				} else {
					$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

					if ($upload_info) {
						$value = $upload_info['name'];
					} else {
						$value = '';
					}
				}

				$option_data[] = array(
					'name'  => $option['name'],
					'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value),
					'type'  => $option['type']
				);
			}

			// Display prices
			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$unit_price = $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'));
               	$total_base_price = $this->currency->format($this->tax->calculate($product['base_price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'], $this->session->data['currency']);
				$price = $this->currency->format($unit_price, $this->session->data['currency']);
				$total = $this->currency->format($unit_price * $product['quantity'], $this->session->data['currency']);
			} else {
				$price = false;
				$total = false;
				$total_base_price = false;
			}
				 // Wishlist
			   $this->load->model('account/wishlist');
			   if (!$this->customer->isLogged() && isset($this->session->data['wishlist'])) {
			    	$wishlist_pd = $this->session->data['wishlist'];
			   } else {
			    	$wishlist_pd = $this->model_account_wishlist->getWishlist();
			   }

				 $wish_pd = false;

			   if(!empty($wishlist_pd)) {
			      foreach($wishlist_pd as $product_id) {
			    		if($product_id == $product['product_id']) $wish_pd = true;
			      }
			    }


			$data['products'][] = array(
				'cart_id'   => $product['cart_id'],
				'id'       	=> $product['product_id'],
				//url caterorii poslednego producta v korzine
				'category_url' => $category_url,
				//end url caterorii poslednego producta v korzine
				'thumb'     => $image,
				'wish'         => $wish_pd,
				'name'      => $product['name'],
				'model'     => $product['model'],
				'option'    => $option_data,
				'recurring' => ($product['recurring'] ? $product['recurring']['name'] : ''),
				'quantity'  => $product['quantity'],
				'price'     => $price,
				'total_base_price' => $total_base_price,
				'total'     => $total,
				'height'		=> $product['height'],
				'width'			=> $product['width'],
				'length'		=> $product['length'],
				'diameter_of_pot'  =>   round($product['diameter_of_pot'],0),
				'depth_of_pot'  =>   round($product['depth_of_pot'],0),
				'stock'   	=> $this->config->get('config_stock_checkout'),
				'minimum'   => $product['minimum'],
				'maximum'   => $product['maximum'],
				'all'				=> $product,
				'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id'])
			);
		}
		//url caterorii poslednego producta v korzine
		$last_product= end($data['products']);
		$data['url_category_last_product']= $last_product['category_url'];
		// end url caterorii poslednego producta v korzine
		// Gift Voucher
		$data['vouchers'] = array();

		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $key => $voucher) {
				$data['vouchers'][] = array(
					'key'         => $key,
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $this->session->data['currency'])
				);
			}
		}

		$data['totals'] = array();

		foreach ($totals as $total) {

			$data['totals'][] = array(
				'title' => $total['title'],
				'text'  => $this->currency->format($total['value'], $this->session->data['currency']),
			);
		}

		$data['cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);

		return $this->load->view('common/cart', $data);
	}

	public function info() {
		$this->response->setOutput($this->index());
	}
}
