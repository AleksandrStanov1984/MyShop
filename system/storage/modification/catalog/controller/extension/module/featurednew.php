<?php
class ControllerExtensionModuleFeaturedNew extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/featurednew');
		$this->document->addStyle('catalog/view/theme/OPC080193_6/stylesheet/module_featurednew.css');
		$this->document->addStyle('catalog/view/theme/OPC080193_6/css/feature_style.css');
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_tax'] = $this->language->get('text_tax');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['unit_h'] = $this->language->get('unit_h');
		$data['unit_w'] = $this->language->get('unit_w');
		$data['unit_l'] = $this->language->get('unit_l');
		$data['unit'] = $this->language->get('unit');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

        if(isset($setting['module_title'])){
            $data['heading_title'] = $setting['module_title'][$this->config->get('config_language_id')];
        }else{
            $data['heading_title'] = $this->language->get('heading_title');
        }

		$data['products'] = array();

		if (!$setting['limit']) {
			$setting['limit'] = 4;
		}

		if (!empty($setting['product'])) {
			$products = array_slice($setting['product'], 0, (int)$setting['limit']);

			foreach ($products as $product_id) {
				$product_info = $this->model_catalog_product->getProduct($product_id);

				if ($product_info) {

        $product_info = $this->load->controller('extension/module/hpmodel/hpmodel/getCategoryBlock', $product_info);
      
					if ($product_info['image']) {
						$image = $this->model_tool_image->resize($product_info['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}

					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$price = false;
					}

					if ((float)$product_info['special']) {
						$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $product_info['rating'];
					} else {
						$rating = false;
					}

					$data['products'][] = array(
						'product_id'  => $product_info['product_id'],

        'hpm_block' => !empty($product_info['hpm_block']) ? $product_info['hpm_block'] : '',
        
						'model'  => $product_info['model'],
						'thumb'       => $image,
						'name'        => $product_info['name'],
						'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
						'price'       => $price,
						'special'     => $special,
						'tax'         => $tax,
						'rating'      => $rating,
						'height'  =>    round($product_info['height'],0),
						'length'  =>   round($product_info['length'],0),
						'width'  =>   round($product_info['width'],0),
						'diameter_of_pot'  =>   round($product_info['diameter_of_pot'],0),
						'depth_of_pot'  =>   round($product_info['depth_of_pot'],0),
						'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
					);
				}
			}
		}

		if ($data['products']) {
			return $this->load->view('extension/module/featurednew', $data);
		}
	}
}
