<?php
class ControllerProductLiveSearch extends Controller {
	public function index() {
		$json = array();
		if (isset($this->request->get['filter_name'])) {
			$search = $this->request->get['filter_name'];
		} else {
			$search = '';
		}
		if (isset($this->request->get['page_number'])) {
			$page_number = $this->request->get['page_number'];
		} else {
			$page_number = 1;
		}
		$tag           = $search;
		$description   = '';
		$category_id   = 0;
		$sub_category  = '';
		$sort          = 'p.sort_order';
		$order         = 'ASC';
		$page          = $page_number;
		$limit         = $this->config->get('live_search_limit');
		$search_result = 0;
		$error         = false;
		if (version_compare(VERSION, '2.0.0.0', '>=') && version_compare(VERSION, '2.2.0.0', '<')) {
			$currency_code = null;
		}
		elseif(version_compare(VERSION, '2.2.0.0', '>=') && version_compare(VERSION, '2.4.0.0', '<')){
			$currency_code = $this->session->data['currency'];
		}
		else{
			$error = true;
			$json[] = array(
				'product_id' => 0,
				'image'      => null,
				'name'       => 'Version Error: '.VERSION,
				'extra_info' => null,
				'price'      => 0,
				'special'    => 0,
				'url'        => '#'
			);
		}

		if(!$error){
			if (isset($this->request->get['filter_name'])) {
				$this->load->model('catalog/product');
				$this->load->model('tool/image');
				$filter_data = array(
					'filter_name'         => $search,
					'filter_tag'          => $tag,
					'filter_description'  => $description,
					'filter_category_id'  => $category_id,
					'filter_sub_category' => $sub_category,
					'sort'                => $sort,
					'order'               => $order,
					'start'               => ($page - 1) * $limit,
					'limit'               => $limit
				);
				$filter_data_all = array(
					'filter_name'         => $search,
					'filter_tag'          => $tag,
					'filter_description'  => $description,
					'filter_category_id'  => $category_id,
					'filter_sub_category' => $sub_category,
					'sort'                => $sort,
					'order'               => $order
				);

				$results = $this->model_catalog_product->getProducts($filter_data);
				$search_result = $this->model_catalog_product->getTotalProducts($filter_data);
				$search_result_all = $this->model_catalog_product->getTotalProducts($filter_data_all);
				$image_width        = $this->config->get('live_search_image_width');
				$image_height       = $this->config->get('live_search_image_height');
				$title_length       = $this->config->get('live_search_title_length');
				$description_length = $this->config->get('live_search_description_length');

				if($search_result_all) {
					$json['totalAll'] = ceil($search_result_all / $limit);
				} else {
					$json['totalAll'] = 1;
				}

				foreach ($results as $result) {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $image_width, $image_height);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $image_width, $image_height);
					}

					if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $currency_code);
						$price_value = preg_replace("/[^,.0-9]/", '', $price);
						//$price_currency = preg_replace("/[^А-Яа-я]/", '', $price);

					} else {
						$price = false;
					}

					if ((float)$result['special']) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $currency_code);
						$price_value_special = preg_replace("/[^,.0-9]/", '', $special);
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $currency_code);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = (int)$result['rating'];
					} else {
						$rating = false;
					}
					$json['total'] = (int)$search_result;
					$json['products'][] = array(
						'product_id'  => $result['product_id'],
						'image'       => $image,
						'name' => utf8_substr(strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')), 0, $title_length),
						'sku' => $result['sku'],
						'extra_info' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $description_length),
						'price'       => $price,
						'price_value'	=> (isset($price_value) ? $price_value : $price),
						'special'     => $special,
						'special_value'=> (isset($price_value_special) ? $price_value_special : $special),
						'currency'	=> 'грн',
						'url'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
					);
				}
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
