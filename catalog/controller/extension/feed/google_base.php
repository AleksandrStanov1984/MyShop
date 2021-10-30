<?php
class ControllerExtensionFeedGoogleBase extends Controller {
	public function index()
    {
        if ($this->config->get('google_base_status')) {
            set_time_limit(0);
            $this->load->model('extension/feed/google_base');
            $this->load->model('catalog/category');
            $this->load->model('catalog/product');

            $this->load->model('tool/image');

            $currencies = array(
                'USD',
                'EUR',
                'UAH',
                'GBP'
            );

            if (in_array($this->session->data['currency'], $currencies)) {
                $currency_code = $this->session->data['currency'];
                $currency_value = $this->currency->getValue($this->session->data['currency']);
            } else {
                $currency_code = 'USD';
                $currency_value = $this->currency->getValue('USD');
            }


            $products = array();

            if (!empty($this->config->get('google_base_categories'))) {
                $base_categories = explode(',', $this->config->get('google_base_categories'));
            } else {
                $base_categories = array();
            }

            $output = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            $output .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">' . "\n";
            $output .= '<channel>' . "\n";
            $output .= '<title>' . $this->config->get('config_name') . '</title>' . "\n";
            $output .= '<description>' . $this->config->get('config_meta_description') . '</description>' . "\n";
            $output .= '<link>' . $this->config->get('config_url') . '</link>' . "\n";

            for ($i = 0; $i < count($base_categories); $i++) {
                $filter_data = array(
                    'filter_category_id' => $base_categories[$i],
                    'filter_filter' => false
                );

                $products = $this->model_extension_feed_google_base->getProductsGoogleBase($filter_data);
                if ($products) {
                    foreach ($products as $product) {
                            $product_info_product = $this->model_extension_feed_google_base->getProductGoogleBaseProduct($product);
                            $product_info_description = $this->model_extension_feed_google_base->getProductGoogleBaseProductName($product);
                            if (isset($product_info_description['name']) && isset($product_info_description['description'])) {
                                $output .= '<item>' . "\n";
                                $output .= '<title><![CDATA[' . strip_tags(html_entity_decode($product_info_description['name'], ENT_QUOTES, 'UTF-8')) . ']]></title>' . "\n";
                                $link = $this->url->link('product/product', 'product_id=' . $product);
                                $output .= '<link>' . str_replace('%2F', '/', $link) . '</link>' . "\n";

                                $output .= '<description><![CDATA[' . strip_tags(html_entity_decode($product_info_description['description'], ENT_QUOTES, 'UTF-8')) . ']]></description>' . "\n";
                                $output .= '<g:brand><![CDATA[SMART ZONE]]></g:brand>' . "\n";
                                $output .= '<g:condition>new</g:condition>' . "\n";
                                $output .= '<g:id>' . $product_info_product['sku'] . '</g:id>' . "\n";

                                if ($product_info_product['image']) {
                                    $product_info_product['image'] = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $product_info_product['image']);
                                    $output .= '  <g:image_link>' . HTTPS_SERVER . 'image/' . $product_info_product['image'] . '</g:image_link>' . "\n";
                                } else {
                                    $output .= '  <g:image_link></g:image_link>' . "\n";
                                }

                                $images = $this->model_catalog_product->getProductImages($product);
                                if ($images) {
                                    foreach ($images as $image) {
                                        $image['image'] = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $image['image']);
                                        $output .= '  <g:additional_image_link>' . HTTPS_SERVER . 'image/' . $image['image'] . '</g:additional_image_link>' . "\n";
                                    }
                                }
                                $output .= '  <g:model_number>' . $product_info_product['model'] . '</g:model_number>' . "\n";

                                if ($product_info_product['mpn']) {
                                    $output .= '  <g:mpn><![CDATA[' . $product_info_product['mpn'] . ']]></g:mpn>' . "\n";
                                } else {
                                    $output .= '  <g:identifier_exists>false</g:identifier_exists>' . "\n";
                                }

                                $product_info_price = $this->model_extension_feed_google_base->getProductsGoogleBaseSpecial($product);
                                if (isset($product_info_price['price']) && (float)$product_info_price['price']) {
                                    $date_next = date("Y-m-d",strtotime('+10 days'));
                                    $output .= '<g:price>' . $this->currency->format($this->tax->calculate($product_info_product['price'], $product_info_product['tax_class_id']), $currency_code, $currency_value, false) . ' ' . $currency_code . '</g:price>' . "\n";
                                    $output .= '<g:sale_price>' . $this->currency->format($this->tax->calculate($product_info_price['price'], $product_info_product['tax_class_id']), $currency_code, $currency_value, false) . ' ' . $currency_code . '</g:sale_price>' . "\n";
                                    $output .= '<g:sale_price_effective_date>' . date("Y-m-d") . 'T13:00-0800/' . $date_next . 'T15:30-0800</g:sale_price_effective_date>' . "\n";
                                } else {
                                    $output .= '<g:price>' . $this->currency->format($this->tax->calculate($product_info_product['price'], $product_info_product['tax_class_id']), $currency_code, $currency_value, false) . ' ' . $currency_code . '</g:price>' . "\n";
                                }

                                $gb_category_id = $this->getGoogleCategoryName($base_categories[$i]);

                                $categories = $this->model_catalog_product->getCategories($product);

                                if (is_array($categories)) {

                                    foreach ($categories as $category) {
                                        $sz_category_id = $this->getSZCategoryById($category['category_id']);
                                        if ($sz_category_id) {
                                            $path = $this->getPath($sz_category_id);

                                            if ($path) {
                                                $string = '';

                                                foreach (explode('_', $path) as $path_id) {
                                                    $category_info = $this->model_catalog_category->getCategory($path_id);

                                                    if ($category_info) {
                                                        if (!$string) {
                                                            $string = $category_info['name'];
                                                        } else {
                                                            $string .= ' &gt; ' . $category_info['name'];
                                                        }
                                                    }
                                                }

                                                $string = str_replace('Каталог', '', $string);
                                                $string = trim($string, '&gt; ');

                                                if (!empty($string)) $output .= '<g:product_type><![CDATA[' . $string . ']]></g:product_type>' . "\n";


                                            }
                                        } else {

                                            $path = $this->getPath($category['category_id']);

                                            if ($path) {
                                                $string = '';

                                                foreach (explode('_', $path) as $path_id) {
                                                    $category_info = $this->model_catalog_category->getCategory($path_id);

                                                    if ($category_info) {
                                                        if (!$string) {
                                                            $string = $category_info['name'];
                                                        } else {
                                                            $string .= ' &gt; ' . $category_info['name'];
                                                        }
                                                    }
                                                }

                                                $string = str_replace('Каталог', '', $string);
                                                $string = trim($string, '&gt; ');

                                                if (!empty($string)) $output .= '<g:product_type><![CDATA[' . $string . ']]></g:product_type>' . "\n";
                                            }
                                        }
                                    }
                                }

                                $result = $this->db->query("SELECT google_base_category_id FROM " . DB_PREFIX . "google_base_category_to_category WHERE category_id = '" . (int)$base_categories[$i] . "' LIMIT 1");

                                if(isset($result->row['google_base_category_id'])){
                                    $output .= '<g:google_product_category>' . $result->row['google_base_category_id'] . '</g:google_product_category>' . "\n";
                                }

                                $output .= '<g:quantity>' . $product_info_product['quantity'] . '</g:quantity>' . "\n";
                                $output .= '<g:availability><![CDATA[' . ($product_info_product['quantity'] ? 'in stock' : 'out of stock') . ']]></g:availability>' . "\n";
                                $output .= '</item>' . "\n";
                            }
                    }
                }
            }
            $output .= '</channel>' . "\n";
            $output .= '</rss>' . "\n";

            try {
                $dom_xml = new DomDocument();
                $dom_xml->loadXML($output);
                $path = 'google_base_xml/' . "google_feed.xml";
                echo $dom_xml->save($path);
            } catch (Exception $e) {
                echo 'Выброшено исключение: ' . $e->getMessage() . "\n";
            }

            //$this->response->addHeader('Content-Type: application/rss+xml; charset=utf-8');
            //$this->response->setOutput($output);
        }
    }

	protected function getGoogleCategoryName($category_id) {
		$google_base_categories = $this->model_extension_feed_google_base->getCategories();
		$gb_category_id = false;

		foreach ($google_base_categories as $google_base_category) {
			if($google_base_category['category_id'] == $category_id) {
 					$gb_category_id = $google_base_category['google_base_category_id'];
			}
		}

		return $gb_category_id ? $gb_category_id : false;

	}

	protected function getSZCategoryById($category_id) {
		$sz_categories = $this->model_extension_feed_google_base->getCategoriesSZ();
		$sz_category_id = false;

		foreach ($sz_categories as $sz_category) {
			if($sz_category['category_id'] == $category_id) {
 					$sz_category_id = $sz_category['google_base_category_id'];
			}
		}

		return $sz_category_id ? $sz_category_id : false;

	}

	protected function getPath($parent_id, $current_path = '') {
		$category_info = $this->model_catalog_category->getCategory($parent_id);

		if ($category_info) {
			if (!$current_path) {
				$new_path = $category_info['category_id'];
			} else {
				$new_path = $category_info['category_id'] . '_' . $current_path;
			}

			$path = $this->getPath($category_info['parent_id'], $new_path);

			if ($path) {
				return $path;
			} else {
				return $new_path;
			}
		}
	}
}