<?php

/**
 * @category   OpenCart
 * @package    Handy Product Manager
 * @copyright  © Serge Tkach, 2018, http://sergetkach.com/
 * Base methods was cloned from model/catalog/product
 */

class ModelExtensionModuleHandyProductManager extends Model {
	/* Cloned systems methods (can be modified)
	--------------------------------------------------------------------------- */

	//////////////////////////////////////////////////////////////////////////////
	public function addProduct($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "product SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int) $data['quantity'] . "', minimum = '" . (int) $data['minimum'] . "', subtract = '" . (int) $data['subtract'] . "', stock_status_id = '" . (int) $data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int) $data['manufacturer_id'] . "', shipping = '" . (int) $data['shipping'] . "', price = '" . (float) $data['price'] . "', points = '" . (int) $data['points'] . "', weight = '" . (float) $data['weight'] . "', weight_class_id = '" . (int) $data['weight_class_id'] . "', length = '" . (float) $data['length'] . "', width = '" . (float) $data['width'] . "', height = '" . (float) $data['height'] . "', length_class_id = '" . (int) $data['length_class_id'] . "', status = '" . (int) $data['status'] . "', tax_class_id = '" . (int) $data['tax_class_id'] . "', sort_order = '" . (int) $data['sort_order'] . "', date_added = NOW()");

		$product_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($data['image']) . "' WHERE product_id = '" . (int) $product_id . "'");
		}

		foreach ($data['product_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int) $product_id . "', language_id = '" . (int) $language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['product_store'])) {
			foreach ($data['product_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int) $product_id . "', store_id = '" . (int) $store_id . "'");
			}
		}

		if (isset($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $product_attribute) {
				if ($product_attribute['attribute_id']) {
					// Removes duplicates
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int) $product_id . "' AND attribute_id = '" . (int) $product_attribute['attribute_id'] . "'");

					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
						$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int) $product_id . "' AND attribute_id = '" . (int) $product_attribute['attribute_id'] . "' AND language_id = '" . (int) $language_id . "'");

						$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int) $product_id . "', attribute_id = '" . (int) $product_attribute['attribute_id'] . "', language_id = '" . (int) $language_id . "', text = '" . $this->db->escape($product_attribute_description['text']) . "'");
					}
				}
			}
		}

		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					if (isset($product_option['product_option_value'])) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int) $product_id . "', option_id = '" . (int) $product_option['option_id'] . "', required = '" . (int) $product_option['required'] . "'");

						$product_option_id = $this->db->getLastId();

						foreach ($product_option['product_option_value'] as $product_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int) $product_option_id . "', product_id = '" . (int) $product_id . "', option_id = '" . (int) $product_option['option_id'] . "', option_value_id = '" . (int) $product_option_value['option_value_id'] . "', quantity = '" . (int) $product_option_value['quantity'] . "', subtract = '" . (int) $product_option_value['subtract'] . "', price = '" . (float) $product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int) $product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float) $product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
						}
					}
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int) $product_id . "', option_id = '" . (int) $product_option['option_id'] . "', value = '" . $this->db->escape($product_option['value']) . "', required = '" . (int) $product_option['required'] . "'");
				}
			}
		}

		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $product_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int) $product_id . "', customer_group_id = '" . (int) $product_discount['customer_group_id'] . "', quantity = '" . (int) $product_discount['quantity'] . "', priority = '" . (int) $product_discount['priority'] . "', price = '" . (float) $product_discount['price'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
			}
		}

		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $product_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int) $product_id . "', customer_group_id = '" . (int) $product_special['customer_group_id'] . "', priority = '" . (int) $product_special['priority'] . "', price = '" . (float) $product_special['price'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
			}
		}

		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int) $product_id . "', image = '" . $this->db->escape($product_image['image']) . "', sort_order = '" . (int) $product_image['sort_order'] . "'");
			}
		}

		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int) $product_id . "', download_id = '" . (int) $download_id . "'");
			}
		}

		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int) $product_id . "', category_id = '" . (int) $category_id . "'");
			}
		}

		// hpm . begin
		if (isset($data['product_main_category'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product_to_category SET main_category = 1 WHERE product_id = '" . (int) $product_id . "' AND category_id = '" . (int) $data['product_main_category'] . "'");
		}
		// hpm . end

		if (isset($data['product_filter'])) {
			foreach ($data['product_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int) $product_id . "', filter_id = '" . (int) $filter_id . "'");
			}
		}

		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int) $product_id . "' AND related_id = '" . (int) $related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int) $product_id . "', related_id = '" . (int) $related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int) $related_id . "' AND related_id = '" . (int) $product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int) $related_id . "', related_id = '" . (int) $product_id . "'");
			}
		}

		if (isset($data['product_reward'])) {
			foreach ($data['product_reward'] as $customer_group_id => $product_reward) {
				if ((int) $product_reward['points'] > 0) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int) $product_id . "', customer_group_id = '" . (int) $customer_group_id . "', points = '" . (int) $product_reward['points'] . "'");
				}
			}
		}

		if (isset($data['product_layout'])) {
			foreach ($data['product_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_layout SET product_id = '" . (int) $product_id . "', store_id = '" . (int) $store_id . "', layout_id = '" . (int) $layout_id . "'");
			}
		}

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int) $product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if (isset($data['product_recurring'])) {
			foreach ($data['product_recurring'] as $recurring) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "product_recurring` SET `product_id` = " . (int) $product_id . ", customer_group_id = " . (int) $recurring['customer_group_id'] . ", `recurring_id` = " . (int) $recurring['recurring_id']);
			}
		}

		$this->cache->delete('product');

		return $product_id;
	}

	public function editProduct($product_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "product SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int) $data['quantity'] . "', minimum = '" . (int) $data['minimum'] . "', subtract = '" . (int) $data['subtract'] . "', stock_status_id = '" . (int) $data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int) $data['manufacturer_id'] . "', shipping = '" . (int) $data['shipping'] . "', price = '" . (float) $data['price'] . "', points = '" . (int) $data['points'] . "', weight = '" . (float) $data['weight'] . "', weight_class_id = '" . (int) $data['weight_class_id'] . "', length = '" . (float) $data['length'] . "', width = '" . (float) $data['width'] . "', height = '" . (float) $data['height'] . "', length_class_id = '" . (int) $data['length_class_id'] . "', status = '" . (int) $data['status'] . "', tax_class_id = '" . (int) $data['tax_class_id'] . "', sort_order = '" . (int) $data['sort_order'] . "', date_modified = NOW() WHERE product_id = '" . (int) $product_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($data['image']) . "' WHERE product_id = '" . (int) $product_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int) $product_id . "'");

		foreach ($data['product_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int) $product_id . "', language_id = '" . (int) $language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int) $product_id . "'");

		if (isset($data['product_store'])) {
			foreach ($data['product_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int) $product_id . "', store_id = '" . (int) $store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int) $product_id . "'");

		if (!empty($data['product_attribute'])) {
			foreach ($data['product_attribute'] as $product_attribute) {
				if ($product_attribute['attribute_id']) {
					// Removes duplicates
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int) $product_id . "' AND attribute_id = '" . (int) $product_attribute['attribute_id'] . "'");

					foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int) $product_id . "', attribute_id = '" . (int) $product_attribute['attribute_id'] . "', language_id = '" . (int) $language_id . "', text = '" . $this->db->escape($product_attribute_description['text']) . "'");
					}
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int) $product_id . "'");

		if (isset($data['product_option'])) {
			foreach ($data['product_option'] as $product_option) {
				if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
					if (isset($product_option['product_option_value'])) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int) $product_option['product_option_id'] . "', product_id = '" . (int) $product_id . "', option_id = '" . (int) $product_option['option_id'] . "', required = '" . (int) $product_option['required'] . "'");

						$product_option_id = $this->db->getLastId();

						foreach ($product_option['product_option_value'] as $product_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_value_id = '" . (int) $product_option_value['product_option_value_id'] . "', product_option_id = '" . (int) $product_option_id . "', product_id = '" . (int) $product_id . "', option_id = '" . (int) $product_option['option_id'] . "', option_value_id = '" . (int) $product_option_value['option_value_id'] . "', quantity = '" . (int) $product_option_value['quantity'] . "', subtract = '" . (int) $product_option_value['subtract'] . "', price = '" . (float) $product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int) $product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float) $product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
						}
					}
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_option_id = '" . (int) $product_option['product_option_id'] . "', product_id = '" . (int) $product_id . "', option_id = '" . (int) $product_option['option_id'] . "', value = '" . $this->db->escape($product_option['value']) . "', required = '" . (int) $product_option['required'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int) $product_id . "'");

		if (isset($data['product_discount'])) {
			foreach ($data['product_discount'] as $product_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int) $product_id . "', customer_group_id = '" . (int) $product_discount['customer_group_id'] . "', quantity = '" . (int) $product_discount['quantity'] . "', priority = '" . (int) $product_discount['priority'] . "', price = '" . (float) $product_discount['price'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int) $product_id . "'");

		if (isset($data['product_special'])) {
			foreach ($data['product_special'] as $product_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int) $product_id . "', customer_group_id = '" . (int) $product_special['customer_group_id'] . "', priority = '" . (int) $product_special['priority'] . "', price = '" . (float) $product_special['price'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int) $product_id . "'");

		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int) $product_id . "', image = '" . $this->db->escape($product_image['image']) . "', sort_order = '" . (int) $product_image['sort_order'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int) $product_id . "'");

		if (isset($data['product_download'])) {
			foreach ($data['product_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_download SET product_id = '" . (int) $product_id . "', download_id = '" . (int) $download_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int) $product_id . "'");

		if (isset($data['product_category'])) {
			foreach ($data['product_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int) $product_id . "', category_id = '" . (int) $category_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int) $product_id . "'");

		if (isset($data['product_filter'])) {
			foreach ($data['product_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_filter SET product_id = '" . (int) $product_id . "', filter_id = '" . (int) $filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int) $product_id . "'");

		if (isset($data['product_related'])) {
			foreach ($data['product_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int) $product_id . "' AND related_id = '" . (int) $related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int) $product_id . "', related_id = '" . (int) $related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int) $related_id . "' AND related_id = '" . (int) $product_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_related SET product_id = '" . (int) $related_id . "', related_id = '" . (int) $product_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int) $product_id . "'");

		if (isset($data['product_reward'])) {
			foreach ($data['product_reward'] as $customer_group_id => $value) {
				if ((int) $value['points'] > 0) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int) $product_id . "', customer_group_id = '" . (int) $customer_group_id . "', points = '" . (int) $value['points'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int) $product_id . "'");

		if (isset($data['product_layout'])) {
			foreach ($data['product_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_layout SET product_id = '" . (int) $product_id . "', store_id = '" . (int) $store_id . "', layout_id = '" . (int) $layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int) $product_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int) $product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "product_recurring` WHERE product_id = " . (int) $product_id);

		if (isset($data['product_recurring'])) {
			foreach ($data['product_recurring'] as $product_recurring) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "product_recurring` SET `product_id` = " . (int) $product_id . ", customer_group_id = " . (int) $product_recurring['customer_group_id'] . ", `recurring_id` = " . (int) $product_recurring['recurring_id']);
			}
		}

		$this->cache->delete('product');
	}

	public function copyProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "product p WHERE p.product_id = '" . (int) $product_id . "'");

		if ($query->num_rows) {
			$data = $query->row;

			$data['sku']	 = '';
			$data['upc']	 = '';
			$data['viewed']	 = '0';
			$data['keyword'] = '';
			$data['status']	 = '0';

			$data['product_attribute']	 = $this->getProductAttributes($product_id);
			$data['product_description'] = $this->getProductDescriptions($product_id);
			$data['product_discount']	 = $this->getProductDiscounts($product_id);
			$data['product_filter']		 = $this->getProductFilters($product_id);
			$data['product_image']		 = $this->getProductImages($product_id);
			$data['product_option']		 = $this->getProductOptions($product_id);
			$data['product_related']	 = $this->getProductRelated($product_id);
			$data['product_reward']		 = $this->getProductRewards($product_id);
			$data['product_special']	 = $this->getProductSpecials($product_id);
			$data['product_category']	 = $this->getProductCategories($product_id);
			$data['product_download']	 = $this->getProductDownloads($product_id);
			$data['product_layout']		 = $this->getProductLayouts($product_id);
			$data['product_store']		 = $this->getProductStores($product_id);
			$data['product_recurrings']	= $this->getRecurrings($product_id);

			$this->addProduct($data);
		}
	}

	public function deleteProduct($product_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_related WHERE related_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_recurring WHERE product_id = " . (int) $product_id);
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE product_id = '" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int) $product_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "coupon_product WHERE product_id = '" . (int) $product_id . "'");

		if ($this->config->get('hpm_system') == 'OpenCart.PRO') {
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_related_article WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_tab WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_tab_desc WHERE product_id = '" . (int)$product_id . "'");
		}

		$this->cache->delete('product');
	}

	public function getProduct($product_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int) $product_id . "') AS keyword FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int) $product_id . "' AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getProducts($data = array(), $test_mode = false) {
		if ($test_mode) {
			hpm_log($test_mode, $data, "\$data in getProduct()");
		}

		if (!empty($data['filter_keyword'])) {
			$this->db->query("SET @query = (SELECT query FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($data['filter_keyword']) . "')");
		}

		// A! is different from getTotalProducts
		$sql = "SELECT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = CONCAT('product_id=', p.product_id)) AS keyword FROM " . DB_PREFIX . "product p";

		// Если выборка идет по ИД товара, то нам зависимость от категории и тому подобных связей не нужна!
		if (!empty($data['filter_product_id'])) {
			goto description;
		}

		// Цепляем категории перед текстовыми описаниями, чтобы в случаях, когда AND p2c.category_id IS NUL
		// Вместе с текстами возвращался product_id, а не NULL, как это происходит с p2c
		if (!empty($data['filter_category']) || !empty($data['filter_category_main'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";
		}

		if (isset($data['filter_attribute']) && !is_null($data['filter_attribute'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_attribute pa ON (pa.product_id = p.product_id)";
		}

		description:

		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

		$sql .= " WHERE pd.language_id = '" . (int) $this->config->get('config_language_id') . "'";

		if (!empty($data['filter_product_id'])) {
			$sql .= " AND p.product_id = '" . (int) $data['filter_product_id'] . "'";

			goto groupby; // ! is different from getTotoalProducts()
		}

		// Для фильтрации использованы оба селектора категорий
		if (!empty($data['filter_category']) && !empty($data['filter_category_main'])) {
			if ('notset' != $data['filter_category_main'] && 'notset' != $data['filter_category']) {
				### Обе категории обозначены (являются ID-шками)
				$sql .= " AND p.product_id IN ( SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE " . DB_PREFIX . "product_to_category.category_id = '" . (int) $data['filter_category_main'] . "' AND " . DB_PREFIX . "product_to_category.main_category = '1' ) AND p2c.category_id = '" . (int) $data['filter_category'] . "'";

			} elseif ('notset' != $data['filter_category_main'] && 'notset' == $data['filter_category']) {
				### Обозначена только главная (второстепенные категории не обозначены)
				// Важно!
				// Если у товара есть главная категория, то в в принципе уже есть какая-либо категория
				// Поэтому запрашивать WHERE category_id IS NULL нет смысла
				// Нужно показать товары, которые фигурируют только 1 раз (записана только главная категория)
				$sql .= " AND p.product_id IN ( SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE " . DB_PREFIX . "product_to_category.category_id = '" . (int) $data['filter_category_main'] . "' AND " . DB_PREFIX . "product_to_category.main_category = '1' )  AND (SELECT COUNT(*) FROM " . DB_PREFIX . "product_to_category WHERE product_id = p.product_id) < 2";

			} elseif ('notset' == $data['filter_category_main'] && 'notset' != $data['filter_category']) {
				### Не обозначена главная категория, хотя обозначена второстепенная
				$sql .= " AND p2c.category_id = '" . (int) $data['filter_category'] . "' AND p.product_id NOT IN (SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = p.product_id AND main_category = 1)";

			} elseif ('notset' == $data['filter_category_main'] && 'notset' == $data['filter_category']) {
				### Обе категории НЕ обозначены (Не являются ID-шками)
				// Подходит любой товар, у которого не обозначена ни одна категория
				$sql .= " AND p2c.category_id IS NULL";

			}
		} else {
			// Для фильтрации использован только один из 2 селекторов категорий
			if (!empty($data['filter_category'])) {
				if ('notset' == $data['filter_category']) {
					$sql .= " AND p2c.category_id IS NULL";
				} else {
					$sql .= " AND p2c.category_id = '" . (int) $data['filter_category'] . "'";
				}
			}

			if (!empty($data['filter_category_main'])) {
				if ('notset' == $data['filter_category_main']) {
					$sql .= " AND p.product_id NOT IN (SELECT DISTINCT " . DB_PREFIX . "product.product_id FROM " . DB_PREFIX . "product LEFT JOIN " . DB_PREFIX . "product_to_category ON (" . DB_PREFIX . "product_to_category.product_id = " . DB_PREFIX . "product.product_id ) WHERE main_category = 1)";
				} else {
					$sql .= " AND (p2c.category_id = '" . (int) $data['filter_category_main'] . "' AND p2c.main_category = '1')";
				}
			}
		}

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_sku'])) {
			$sql .= " AND p.sku = '" . $this->db->escape($data['filter_sku']) . "'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (!empty($data['filter_keyword'])) {
			$sql .= " AND p.product_id = REPLACE(@query,'product_id=','')";
		}

		if (isset($data['filter_manufacturer']) && !is_null($data['filter_manufacturer'])) {
			$sql .= " AND p.manufacturer_id = '" . (int) $data['filter_manufacturer'] . "'";
		}

		if (isset($data['filter_price_min']) && !is_null($data['filter_price_min'])) {
			$sql .= " AND p.price >= '" . (float) $data['filter_price_min'] . "'";
		}

		if (isset($data['filter_price_max']) && !is_null($data['filter_price_max'])) {
			$sql .= " AND p.price <= '" . (float) $data['filter_price_max'] . "'";
		}

		if (isset($data['filter_quantity_min']) && !is_null($data['filter_quantity_min'])) {
			$sql .= " AND p.quantity >= '" . (int) $data['filter_quantity_min'] . "'";
		}

		if (isset($data['filter_quantity_max']) && !is_null($data['filter_quantity_max'])) {
			$sql .= " AND p.quantity <= '" . (int) $data['filter_quantity_max'] . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int) $data['filter_status'] . "'";
		}

		if (isset($data['filter_image']) && !is_null($data['filter_image'])) {
			if ($data['filter_image'] == 1) {
				$sql .= " AND (p.image IS NOT NULL AND p.image <> '' AND p.image <> 'no_image.png')";
			} else {
				$sql .= " AND (p.image IS NULL OR p.image = '' OR p.image = 'no_image.png')";
			}
		}

		if (isset($data['filter_attribute']) && !is_null($data['filter_attribute'])) {
			$sql .= " AND pa.attribute_id = '" . (int) $data['filter_attribute'] . "'";
		}

		if (isset($data['filter_attribute_value']) && !empty($data['filter_attribute_value'])) {
			$sql .= " AND pa.text = '" . $this->db->escape($data['filter_attribute_value']) . "'";
		}

		groupby:

		$sql .= " GROUP BY p.product_id";

		$sort_data = array(
			'pd.name',
			'p.sku',
			'p.model',
			'p.price',
			'p.quantity',
			'p.status',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY p.product_id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} elseif (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
		}

		if ($test_mode) {
			hpm_log($test_mode, $sql, 'getProducts() $sql');
		}

		$query = $this->db->query($sql);

		if ($test_mode) {
			hpm_log($test_mode, $query, 'getProducts() $query');
		}

		return $query->rows;
	}

	public function getProductsByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) WHERE pd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int) $category_id . "' ORDER BY pd.name ASC");

		return $query->rows;
	}

	public function getProductDescriptions($product_id) {
		$h1 = $this->getH1();

		$product_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int) $product_id . "'");

		foreach ($query->rows as $result) {
			$product_description_data[$result['language_id']] = array(
				'name'						 => $result['name'],
				'description'			 => $result['description'],
				$h1								 => isset($result[$h1]) ? $result[$h1] : '',
				'meta_title'			 => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'		 => $result['meta_keyword'],
				'tag'							 => $result['tag']
			);
		}

		return $product_description_data;
	}

	public function getProductCategories($product_id) {
		$product_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int) $product_id . "'");

		foreach ($query->rows as $result) {
			$product_category_data[] = $result['category_id'];
		}

		return $product_category_data;
	}

	public function getProductFilters($product_id) {
		$product_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_filter WHERE product_id = '" . (int) $product_id . "'");

		foreach ($query->rows as $result) {
			$product_filter_data[] = $result['filter_id'];
		}

		return $product_filter_data;
	}

	public function getProductAttributes($product_id) {
		$product_attribute_data = array();

		$product_attribute_query = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int) $product_id . "' GROUP BY attribute_id");

		foreach ($product_attribute_query->rows as $product_attribute) {
			$product_attribute_description_data = array();

			$product_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int) $product_id . "' AND attribute_id = '" . (int) $product_attribute['attribute_id'] . "'");

			foreach ($product_attribute_description_query->rows as $product_attribute_description) {
				$product_attribute_description_data[$product_attribute_description['language_id']] = array('text' => $product_attribute_description['text']);
			}

			$product_attribute_data[] = array(
				'attribute_id'					 => $product_attribute['attribute_id'],
				'product_attribute_description'	 => $product_attribute_description_data
			);
		}

		return $product_attribute_data;
	}

	public function getProductOptions($product_id) {
		$product_option_data = array();

		$product_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int) $product_id . "' AND od.language_id = '" . (int) $this->config->get('config_language_id') . "'");

		foreach ($product_option_query->rows as $product_option) {
			$product_option_value_data = array();

			$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON(pov.option_value_id = ov.option_value_id) WHERE pov.product_option_id = '" . (int) $product_option['product_option_id'] . "' ORDER BY ov.sort_order ASC");

			foreach ($product_option_value_query->rows as $product_option_value) {
				$product_option_value_data[] = array(
					'product_option_value_id'	 => $product_option_value['product_option_value_id'],
					'option_value_id'			 => $product_option_value['option_value_id'],
					'quantity'					 => $product_option_value['quantity'],
					'subtract'					 => $product_option_value['subtract'],
					'price'						 => $product_option_value['price'],
					'price_prefix'				 => $product_option_value['price_prefix'],
					'points'					 => $product_option_value['points'],
					'points_prefix'				 => $product_option_value['points_prefix'],
					'weight'					 => $product_option_value['weight'],
					'weight_prefix'				 => $product_option_value['weight_prefix']
				);
			}

			$product_option_data[] = array(
				'product_option_id'		 => $product_option['product_option_id'],
				'product_option_value'	 => $product_option_value_data,
				'option_id'				 => $product_option['option_id'],
				'name'					 => $product_option['name'],
				'type'					 => $product_option['type'],
				'value'					 => $product_option['value'],
				'required'				 => $product_option['required']
			);
		}

		return $product_option_data;
	}

	public function getProductOptionValue($product_id, $product_option_value_id) {
		$query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int) $product_id . "' AND pov.product_option_value_id = '" . (int) $product_option_value_id . "' AND ovd.language_id = '" . (int) $this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getProductImages($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int) $product_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getProductDiscounts($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int) $product_id . "' ORDER BY quantity, priority, price");

		return $query->rows;
	}

	public function getProductSpecials($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int) $product_id . "' ORDER BY priority, price");

		return $query->rows;
	}

	public function getProductRewards($product_id) {
		$product_reward_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int) $product_id . "'");

		foreach ($query->rows as $result) {
			$product_reward_data[$result['customer_group_id']] = array('points' => $result['points']);
		}

		return $product_reward_data;
	}

	public function getProductDownloads($product_id) {
		$product_download_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download WHERE product_id = '" . (int) $product_id . "'");

		foreach ($query->rows as $result) {
			$product_download_data[] = $result['download_id'];
		}

		return $product_download_data;
	}

	public function getProductStores($product_id) {
		$product_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int) $product_id . "'");

		foreach ($query->rows as $result) {
			$product_store_data[] = $result['store_id'];
		}

		return $product_store_data;
	}

	public function getProductLayouts($product_id) {
		$product_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int) $product_id . "'");

		foreach ($query->rows as $result) {
			$product_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $product_layout_data;
	}

	public function getProductRelated($product_id) {
		$product_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related WHERE product_id = '" . (int) $product_id . "'");

		foreach ($query->rows as $result) {
			$product_related_data[] = $result['related_id'];
		}

		return $product_related_data;
	}

	public function getRecurrings($product_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product_recurring` WHERE product_id = '" . (int) $product_id . "'");

		return $query->rows;
	}

	public function getTotalProducts($data = array(), $test_mode = false) {
		if (!empty($data['filter_keyword'])) {
			$this->db->query("SET @query = (SELECT query FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($data['filter_keyword']) . "')");
		}

		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM " . DB_PREFIX . "product p";

		// Если выборка идет по ИД товара, то нам зависимость от категории и тому подобных связей не нужна!
		if (!empty($data['filter_product_id'])) {
			goto description;
		}

		// Цепляем категории перед текстовыми описаниями, чтобы в случаях, когда AND p2c.category_id IS NUL
		// Вместе с текстами возвращался product_id, а не NULL, как это происходит с p2c
		if (!empty($data['filter_category']) || !empty($data['filter_category_main'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id)";
		}

		if (isset($data['filter_attribute']) && !is_null($data['filter_attribute'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_attribute pa ON (pa.product_id = p.product_id)";
		}

		description:

		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";

		$sql .= " WHERE pd.language_id = '" . (int) $this->config->get('config_language_id') . "'";

		if (!empty($data['filter_product_id'])) {
			$sql .= " AND p.product_id = '" . (int) $data['filter_product_id'] . "'";

			goto query; // ! is different from getProducts()
		}

		// Для фильтрации использованы оба селектора категорий
		if (!empty($data['filter_category']) && !empty($data['filter_category_main'])) {
			if ('notset' != $data['filter_category_main'] && 'notset' != $data['filter_category']) {
				### Обе категории обозначены (являются ID-шками)
				$sql .= " AND p.product_id IN ( SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE " . DB_PREFIX . "product_to_category.category_id = '" . (int) $data['filter_category_main'] . "' AND " . DB_PREFIX . "product_to_category.main_category = '1' ) AND p2c.category_id = '" . (int) $data['filter_category'] . "'";

			} elseif ('notset' != $data['filter_category_main'] && 'notset' == $data['filter_category']) {
				### Обозначена только главная (второстепенные категории не обозначены)
				// Важно!
				// Если у товара есть главная категория, то в в принципе уже есть какая-либо категория
				// Поэтому запрашивать WHERE category_id IS NULL нет смысла
				// Нужно показать товары, которые фигурируют только 1 раз (записана только главная категория)
				$sql .= " AND p.product_id IN ( SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE " . DB_PREFIX . "product_to_category.category_id = '" . (int) $data['filter_category_main'] . "' AND " . DB_PREFIX . "product_to_category.main_category = '1' )  AND (SELECT COUNT(*) FROM " . DB_PREFIX . "product_to_category WHERE product_id = p.product_id) < 2";

			} elseif ('notset' == $data['filter_category_main'] && 'notset' != $data['filter_category']) {
				### Не обозначена главная категория, хотя обозначена второстепенная
				$sql .= " AND p2c.category_id = '" . (int) $data['filter_category'] . "' AND p.product_id NOT IN (SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = p.product_id AND main_category = 1)";

			} elseif ('notset' == $data['filter_category_main'] && 'notset' == $data['filter_category']) {
				### Обе категории НЕ обозначены (Не являются ID-шками)
				// Подходит любой товар, у которого не обозначена ни одна категория
				$sql .= " AND p2c.category_id IS NULL";

			}
		} else {
			// Для фильтрации использован только один из 2 селекторов категорий
			if (!empty($data['filter_category'])) {
				if ('notset' == $data['filter_category']) {
					$sql .= " AND p2c.category_id IS NULL";
				} else {
					$sql .= " AND p2c.category_id = '" . (int) $data['filter_category'] . "'";
				}
			}

			if (!empty($data['filter_category_main'])) {
				if ('notset' == $data['filter_category_main']) {
					$sql .= " AND p.product_id NOT IN (SELECT DISTINCT " . DB_PREFIX . "product.product_id FROM " . DB_PREFIX . "product LEFT JOIN " . DB_PREFIX . "product_to_category ON (" . DB_PREFIX . "product_to_category.product_id = " . DB_PREFIX . "product.product_id ) WHERE main_category = 1)";
				} else {
					$sql .= " AND (p2c.category_id = '" . (int) $data['filter_category_main'] . "' AND p2c.main_category = '1')";
				}
			}
		}

		if (!empty($data['filter_name'])) {
			$sql .= " AND pd.name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_sku'])) {
			$sql .= " AND p.sku = '" . $this->db->escape($data['filter_sku']) . "'";
		}

		if (!empty($data['filter_model'])) {
			$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
		}

		if (!empty($data['filter_keyword'])) {
			$sql .= " AND p.product_id = REPLACE(@query,'product_id=','')";
		}

		if (isset($data['filter_manufacturer']) && !is_null($data['filter_manufacturer'])) {
			$sql .= " AND p.manufacturer_id = '" . (int) $data['filter_manufacturer'] . "'";
		}

		if (isset($data['filter_price_min']) && !is_null($data['filter_price_min'])) {
			$sql .= " AND p.price >= '" . (float) $data['filter_price_min'] . "'";
		}

		if (isset($data['filter_price_max']) && !is_null($data['filter_price_max'])) {
			$sql .= " AND p.price <= '" . (float) $data['filter_price_max'] . "'";
		}

		if (isset($data['filter_quantity_min']) && !is_null($data['filter_quantity_min'])) {
			$sql .= " AND p.quantity >= '" . (int) $data['filter_quantity_min'] . "'";
		}

		if (isset($data['filter_quantity_max']) && !is_null($data['filter_quantity_max'])) {
			$sql .= " AND p.quantity <= '" . (int) $data['filter_quantity_max'] . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int) $data['filter_status'] . "'";
		}

		if (isset($data['filter_image']) && !is_null($data['filter_image'])) {
			if ($data['filter_image'] == 1) {
				$sql .= " AND (p.image IS NOT NULL AND p.image <> '' AND p.image <> 'no_image.png')";
			} else {
				$sql .= " AND (p.image IS NULL OR p.image = '' OR p.image = 'no_image.png')";
			}
		}

		if (isset($data['filter_attribute']) && !is_null($data['filter_attribute'])) {
			$sql .= " AND pa.attribute_id = '" . (int) $data['filter_attribute'] . "'";
		}

		if (isset($data['filter_attribute_value']) && !empty($data['filter_attribute_value'])) {
			$sql .= " AND pa.text = '" . $this->db->escape($data['filter_attribute_value']) . "'";
		}

		query:

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalProductsByTaxClassId($tax_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE tax_class_id = '" . (int) $tax_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByStockStatusId($stock_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE stock_status_id = '" . (int) $stock_status_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByWeightClassId($weight_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE weight_class_id = '" . (int) $weight_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByLengthClassId($length_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE length_class_id = '" . (int) $length_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByDownloadId($download_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_download WHERE download_id = '" . (int) $download_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByManufacturerId($manufacturer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE manufacturer_id = '" . (int) $manufacturer_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByAttributeId($attribute_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_attribute WHERE attribute_id = '" . (int) $attribute_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByOptionId($option_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_option WHERE option_id = '" . (int) $option_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByProfileId($recurring_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_recurring WHERE recurring_id = '" . (int) $recurring_id . "'");

		return $query->row['total'];
	}

	public function getTotalProductsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_to_layout WHERE layout_id = '" . (int) $layout_id . "'");

		return $query->row['total'];
	}

	public function getManufacturers($data = array()) {
		$system = $this->config->get('hpm_system'); // customized
		$prefix = '';

		$sql = "SELECT * FROM " . DB_PREFIX . "manufacturer";

		if ('OpenCart' == $system || 'OpenCart.PRO' == $system) {
			if (!empty($data['filter_name'])) {
				$sql .= " WHERE name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
			}
		}

		if ('ocStore' == $system) {
			$prefix = 'md.';

			$sql = "SELECT m.manufacturer_id, md.name, m.sort_order FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_description md ON (m.manufacturer_id = md.manufacturer_id) WHERE md.language_id = '" . (int)$this->config->get('config_language_id') . "'";

			if (!empty($data['filter_name'])) {
				$sql .= " AND md.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
			}
		}

		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY " . $prefix . "name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}




	/* Handy Prodcut Manager Methods
	--------------------------------------------------------------------------- */
	//////////////////////////////////////////////////////////////////////////////

	public function getValidFormats() {
		return array("jpg", "png", "gif", "jpeg");
	}

	public function addProductImageMain($data, $test_mode = false) {
		// Предполагается, что товар уже существует !
		// То есть, при добавлении нового ряда в списке, под товар уже создается запись!
		// Если же будет поодниночное добавление товара, то либо это будет другой метод модели, либо также будет сначала резервироваться ID товара, а потом к нему вешаться данные
		// todo...
		// Запросить, какая фотка была до этого
		//$sql = "UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($data['image']) . "' WHERE product_id = '" . (int)$data['product_id'] . "'";
		//$this->db->query($sql);
		// todo...
		// Если заменяется главная фотка, то предыдущую необходимо бы удалить
		// Но проверить перед этим, не прикрплена ли она к другим товарам в качестве главной
		// или в качестве дополнительной
	}

	public function addProductImageAdditional($data, $test_mode = false) {
		$sql = "INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int) $data['product_id'] . "', image = '" . $this->db->escape($data['image']) . "', sort_order = '" . (int) $data['image_additional_n'] . "' ";

		if ($test_mode) {
			hpm_log($test_mode, $sql, "addProductImageAdditional() \$sql");
		}

		$this->db->query($sql);
	}

	public function editProductImageMain($data, $test_mode = false) {
		$sql = "UPDATE " . DB_PREFIX . "product SET image='" . $this->db->escape($data['image']) . "' WHERE product_id = '" . (int) $data['product_id'] . "'";

		if ($test_mode) {
			hpm_log($test_mode, $sql, "editProductImageMain() \$sql UPDATE MAIN");
		}

		$this->db->query($sql);
	}

	public function editProductImageAdditional($data, $test_mode = false) {
		$sql = "UPDATE " . DB_PREFIX . "product_image SET image='" . $this->db->escape($data['image_new']) . "' WHERE product_id = '" . (int) $data['product_id'] . "' AND image='" . $this->db->escape($data['image_old']) . "' ";

		if ($test_mode) {
			hpm_log($test_mode, $sql, "editProductImageAdditional() \$sql UPDATE ADDITIONAL");
		}

		$this->db->query($sql);
	}

	public function editProductImageMainFromFirstItem($data, $test_mode = false) {
		$sql = "UPDATE " . DB_PREFIX . "product SET image='" . $this->db->escape($data['image_new']) . "' WHERE product_id = '" . (int) $data['product_id'] . "'";

		if ($test_mode) {
			hpm_log($test_mode, $sql, "editProductImageMainFromFirstItem() : UPDATE MAIN");
		}

		$this->db->query($sql);

		$this->db->query($sql);

		$sql = "DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int) $data['product_id'] . "' AND image = '" . $this->db->escape($data['image_new']) . "'";

		if ($test_mode) {
			hpm_log($test_mode, $sql, "editProductImageMainFromFirstItem() : DELETE NEW MAIN FROM ADDITITONAL WAS");
		}

		$this->db->query($sql);
	}

	public function editProductImageMainAfterSorting($data, $test_mode = false) {
		$sql = "UPDATE " . DB_PREFIX . "product SET image='" . $this->db->escape($data['image_new']) . "' WHERE product_id = '" . (int) $data['product_id'] . "'";

		if ($test_mode) {
			hpm_log($test_mode, $sql, "editProductImageMainAfterSorting() \$sql UPDATE MAIN");
		}

		$this->db->query($sql);

		$sql = "INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int) $data['product_id'] . "', image = '" . $this->db->escape($data['image_old']) . "', sort_order = '0' ";

		if ($test_mode) {
			hpm_log($test_mode, $sql, "editProductImageMain() 2 \$sql OLD MAIN INSERT AS ADDITIONAL");
		}

		$this->db->query($sql);

		$sql = "DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int) $data['product_id'] . "' AND image = '" . $this->db->escape($data['image_new']) . "'";

		if ($test_mode) {
			hpm_log($test_mode, $sql, "editProductImageMain() 3 \$sql DELETE NEW MAIN FROM ADDITITONAL");
		}

		$this->db->query($sql);
	}

	public function editProductImageSorting($data, $test_mode = false) {
		foreach ($data['images'] as $index => $image) {
			$sql = "UPDATE " . DB_PREFIX . "product_image SET sort_order = '" . (int) $index . "' WHERE product_id = '" . (int) $data['product_id'] . "' AND image='" . $this->db->escape($image) . "'";

			if ($test_mode) {
				hpm_log($test_mode, $sql, "editProductImageSorting() \$sql");
			}

			$this->db->query($sql);
		}
	}

	public function deleteProductImageMain($data, $test_mode = false) {
		$sql = "UPDATE " . DB_PREFIX . "product SET image = '' WHERE product_id = '" . (int) $data['product_id'] . "'";

		if ($test_mode) {
			hpm_log($test_mode, $sql, "deleteProductImageMain() \$sql");
		}

		$this->db->query($sql);
	}

	public function deleteProductImageAdditional($data, $test_mode = false) {
		$sql = "DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int) $data['product_id'] . "'";

		if ('*' != $data['image']) {
			$sql .= " AND image = '" . $this->db->escape($data['image']) . "'";
		}

		if ($test_mode) {
			hpm_log($test_mode, $sql, "deleteProductImageAdditional() \$sql");
		}

		$this->db->query($sql);
	}

	public function editProductMainCategory($data, $test_mode = false) {
		$sql = "UPDATE " . DB_PREFIX . "product_to_category SET main_category = '0' WHERE product_id = '" . (int) $data['product_id'] . "'";

		$query = $this->db->query($sql);

		if (0 != $data['main_category_id']) {
			$sql = "INSERT IGNORE INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int) $data['product_id'] . "', category_id = '" . (int) $data['main_category_id'] . "'";

			$query = $this->db->query($sql);

			$sql = "UPDATE " . DB_PREFIX . "product_to_category SET main_category = '1' WHERE product_id = '" . (int) $data['product_id'] . "' AND category_id = '" . (int) $data['main_category_id'] . "'";

			$query = $this->db->query($sql);

			// tmp
			$this->cache->delete('product.seopath');
			$this->cache->delete('seo_pro');
		}
	}

	public function editProductCategories($data, $test_mode = false) {
		if ('add' == $data['action']) {
			$sql = "INSERT IGNORE INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int) $data['product_id'] . "', category_id = '" . (int) $data['value'] . "'";
		} else {
			$sql = "DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int) $data['product_id'] . "' AND category_id = '" . (int) $data['value'] . "'";
		}

		$res = $this->db->query($sql);
	}

  public function editProductIdentity($data, $test_mode = false) {
		hpm_log($test_mode, 'editProductIdentity() is called');

		$sql = "UPDATE " . DB_PREFIX . "product SET " . $data['field'] . " = '" . $this->db->escape($data['value']) . "' WHERE product_id = '" . (int) $data['product_id'] . "'";

		hpm_log($test_mode, $sql, 'editProductIdentity() $sql');

		$res = $this->db->query($sql);

		hpm_log($test_mode, $res, 'editProductIdentity() $res');
	}

	// A! Points - is simple identity field!
  public function editProductReward($data, $test_mode = false) {
		hpm_log($test_mode, 'editProductReward() is called');

		// $sql = "INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int) $data['product_id'] . "', customer_group_id = '" . (int) $data['customer_group_id'] . "', points = '" . (int)$data['value'] . "' ON DUPLICATE KEY UPDATE points = '" . (int)$data['value'] . "'";
		// ON DUPLICATE KEY UPDATE work only for PRIMARY KEY...

		$sql = "SELECT points FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int) $data['product_id'] . "'";

		hpm_log($test_mode, $sql, 'editProductReward() $sql SELECT');

		$res = $this->db->query($sql);

		if ($res->num_rows > 0) {
			$sql2 = "UPDATE " . DB_PREFIX . "product_reward SET customer_group_id = '" . (int) $data['customer_group_id'] . "', points = '" . (int)$data['value'] . "' WHERE product_id = '" . (int) $data['product_id'] . "'";

			hpm_log($test_mode, $sql2, 'editProductReward() $sql2 UPDATE');

		} else {
			$sql2 = "INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int) $data['product_id'] . "', customer_group_id = '" . (int) $data['customer_group_id'] . "', points = '" . (int)$data['value'] . "'";

			hpm_log($test_mode, $sql2, 'editProductReward() $sql2 INSERT');
		}

		$res2 = $this->db->query($sql2);

		hpm_log($test_mode, $res2, 'editProductReward() $res2');
	}

  public function editProductUrl($data, $test_mode = false) {
		hpm_log($test_mode, 'editProductUrl() is called');

		// Проверка на существования такого ключа
		$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($data['value']) . "'");

		if ($res->num_rows > 0) {
			hpm_log($test_mode, 'editProductUrl() seo url already followed');
			return false;
		} else {
				$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int) $data['product_id'] . "'");

			if ($data['value']) {
				$sql = "INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int) $data['product_id'] . "', keyword = '" . $this->db->escape($data['value']) . "'";

				hpm_log($test_mode, $sql, 'editProductUrl() $sql');

				$res = $this->db->query($sql);

				hpm_log($test_mode, $res, 'editProductUrl() $res');

				return true;
			} else {
				hpm_log($test_mode, 'editProductUrl() error: $data[\'keyword\'] is empty!');
			}
		}

		return false;
	}

	public function addDiscount($data, $test_mode = false) {
		hpm_log($test_mode, 'addDiscount() is called');

		$sql = "INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int) $data['product_id'] . "', customer_group_id = '" . (int) $data['customer_group_id'] . "', quantity = '" . 0 . "', priority = '" . 0 . "', price = '" . (float) $data['price'] . "'";

		hpm_log($test_mode, $sql, 'addDiscount() $sql');

		$res = $this->db->query($sql);

		if ($res) {
			return $this->db->getLastId();
		}

		hpm_log($test_mode, $res, 'addDiscount() $res');

		return false;
	}

	public function editDiscount($data, $test_mode = false) {
		hpm_log($test_mode, 'editDiscount() is called');

		$sql = "UPDATE " . DB_PREFIX . "product_discount SET " . $data['field'] . " = '" . $this->db->escape($data['value']) . "' WHERE product_discount_id = '" . (int) $data['product_discount_id'] . "'";

		hpm_log($test_mode, $sql, 'editDiscount() $sql');

		$res = $this->db->query($sql);
	}

	public function deleteDiscount($data, $test_mode = false) {
		hpm_log($test_mode, 'deleteDiscount() is called');

		$sql = "DELETE FROM " . DB_PREFIX . "product_discount WHERE product_discount_id = '" . (int) $data['product_discount_id'] . "'";

		hpm_log($test_mode, $sql, 'deleteDiscount() $sql');

		$res = $this->db->query($sql);
	}


	public function addSpecial($data, $test_mode = false) {
		hpm_log($test_mode, 'addSpecial() is called');

		$sql = "INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int) $data['product_id'] . "', customer_group_id = '" . (int) $data['customer_group_id'] . "', priority = '" . 0 . "', price = '" . (float) $data['price'] . "'";

		hpm_log($test_mode, $sql, 'addSpecial() $sql');

		$res = $this->db->query($sql);

		if ($res) {
			return $this->db->getLastId();
		}

		hpm_log($test_mode, $res, 'addSpecial() $res');

		return false;
	}

	public function editSpecial($data, $test_mode = false) {
		hpm_log($test_mode, 'editSpecial() is called');

		$sql = "UPDATE " . DB_PREFIX . "product_special SET " . $data['field'] . " = '" . $this->db->escape($data['value']) . "' WHERE product_special_id = '" . (int) $data['product_special_id'] . "'";

		hpm_log($test_mode, $sql, 'editSpecial() $sql');

		$res = $this->db->query($sql);
	}

	public function deleteSpecial($data, $test_mode = false) {
		hpm_log($test_mode, 'deleteSpecial() is called');

		$sql = "DELETE FROM " . DB_PREFIX . "product_special WHERE product_special_id = '" . (int) $data['product_special_id'] . "'";

		hpm_log($test_mode, $sql, 'deleteSpecial() $sql');

		$res = $this->db->query($sql);
	}

  public function addProductToStore($data, $test_mode = false) {
		hpm_log($test_mode, 'addProductToStore() is called');

		$sql = "INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int) $data['product_id'] . "', store_id = '" . (int) $data['store_id'] . "'";

		hpm_log($test_mode, $sql, 'addProductToStore() $sql');

		$this->db->query($sql);
	}

	public function deleteProductFromStore($data, $test_mode = false) {
		hpm_log($test_mode, 'deleteProductFromStore() is called');

		$sql = "DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int) $data['product_id'] . "' AND store_id = '" . (int) $data['store_id'] . "'";

		hpm_log($test_mode, $sql, 'deleteProductFromStore() $sql');

		$this->db->query($sql);
	}

	public function editProductDescription($data, $test_mode = false) {
		$sql = "UPDATE " . DB_PREFIX . "product_description SET " . $data['field'] . " = '" . $this->db->escape($data['value']) . "' WHERE product_id = '" . (int) $data['product_id'] . "' AND language_id = '" . (int) $data['language_id'] . "'";

		$res = $this->db->query($sql);
	}


	public function addNewAttribute($data, $test_mode = false) {
		$sql = "INSERT INTO " . DB_PREFIX . "attribute SET attribute_group_id = '" . (int) $data['attribute_group_id'] . "'";

		$this->db->query($sql);

		$attribute_id = $this->db->getLastId();

		foreach ($data['attribute_description'] as $language_id => $value) {
			$sql = "INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int) $attribute_id . "', language_id = '" . (int) $language_id . "', name = '" . $this->db->escape($value) . "'";
			$this->db->query($sql);
		}

		return $attribute_id;
	}

	public function addProductAttribute($data, $test_mode = false) {
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		foreach ($data['languages'] as $language) {
			$sql = "INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int) $data['product_id'] . "', attribute_id = '" . (int) $data['attribute_id'] . "', language_id = '" . (int) $language['language_id'] . "' ";

			$res = $this->db->query($sql);
		}
	}

	public function deleteProductAttribute($data, $test_mode = false) {
		$sql = "DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int) $data['product_id'] . "' AND attribute_id = '" . (int) $data['attribute_id'] . "'";

		$res = $this->db->query($sql);
	}

	public function editProductAttributeValue($data, $test_mode = false) {
		hpm_log($test_mode, 'editProductAttributeValue() is called');
    $sql = "UPDATE " . DB_PREFIX . "product_attribute SET " . $data['field'] . " = '" . $this->db->escape($data['value']) . "' WHERE product_id = '" . (int)$data['product_id'] . "' AND attribute_id = '" . (int)$data['attribute_id'] . "' AND language_id = '" . (int)$data['language_id'] . "'";

    hpm_log($test_mode, $sql, 'editProductAttributeValue() $sql');

    $res = $this->db->query($sql);

    hpm_log($test_mode, $res, 'editProductAttributeValue() $res');
  }

	public function getAttributes($data = array(), $test_mode = false) {
		$sql = "SELECT "
			. "a.attribute_id, "
			. "a.attribute_group_id, "
			. "ad.language_id, "
			. "ad.name, "
			//. "pa.product_id, "
			. "(SELECT agd.name FROM " . DB_PREFIX . "attribute_group_description agd WHERE agd.attribute_group_id = a.attribute_group_id AND agd.language_id = '" . (int) $this->config->get('config_language_id') . "') AS attribute_group "
			. "FROM " . DB_PREFIX . "attribute a "
			//. "LEFT JOIN " . DB_PREFIX . "product_attribute pa ON (pa.attribute_id = a.attribute_id) "
			. "LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (ad.attribute_id = a.attribute_id) "
			. "WHERE ad.language_id = '" . (int) $this->config->get('config_language_id') . "' "
			. "AND a.attribute_id NOT IN (SELECT DISTINCT pa.attribute_id FROM " . DB_PREFIX . "product_attribute pa WHERE pa.language_id = '" . (int) $this->config->get('config_language_id') . "' AND pa.product_id = '" . (int) $data['product_id'] . "')";

		if (!empty($data['filter_name'])) {
			$sql .= " AND ad.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_attribute_group_id'])) {
			$sql .= " AND a.attribute_group_id = '" . $this->db->escape($data['filter_attribute_group_id']) . "'";
		}

		$sort_data = array(
			'ad.name',
			'attribute_group',
			'a.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY attribute_group, ad.name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getAllAttributeValues($test_mode = false) {
		hpm_log($test_mode, 'model getAllAttributeValues() is called');

		$sql = "SELECT DISTINCT text, attribute_id, language_id FROM " . DB_PREFIX . "product_attribute WHERE text != '' ORDER BY attribute_id ASC";

		hpm_log($test_mode, $sql, 'getAllAttributeValues() $sql');

		$query = $this->db->query($sql);

		hpm_log($test_mode, $query, 'getAllAttributeValues() $res');

		return $query->rows;
	}

	public function getAttributeValues($attribute_id, $language_id, $test_mode = false) {
		hpm_log($test_mode, 'model getAttributeValues() is called');

		// from Attribute select 2.0 by alex2009 [OCMOD]
		$sql = "SELECT DISTINCT `text` FROM `" . DB_PREFIX . "product_attribute` WHERE attribute_id = '" . (int) $attribute_id . "' AND language_id = '" . (int) $language_id . "' AND `text` != '' group by `text`";

		hpm_log($test_mode, $sql, 'getAttributeValues() $sql');

		$query = $this->db->query($sql);

		hpm_log($test_mode, $query, 'getAttributeValues() $res');

		return $query->rows;
	}

  public function getAllOptionValues($test_mode = false) {
    hpm_log($test_mode, 'model getAllOptionValues() is called');

		$sql = "SELECT * FROM " . DB_PREFIX . "option_value_description WHERE language_id = '" . (int) $this->config->get('config_language_id') . "'";

    hpm_log($test_mode, $sql, 'getAllOptionValues() $sql');

		$res = $this->db->query($sql);

    hpm_log($test_mode, $res, 'getProductOption() $res');

		return $res->rows;
	}

  public function getOptionsList($product_id, $test_mode = false) {
    hpm_log($test_mode, 'model getOptionsList() is called');

		$sql = "SELECT *, name FROM " . DB_PREFIX . "option o"
			. " LEFT JOIN " . DB_PREFIX . "option_description od ON od.option_id = o.option_id"
			. " WHERE o.option_id NOT IN (SELECT option_id FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int) $product_id . "')"
			. " AND od.language_id = '" . $this->config->get('config_language_id') . "'";

    hpm_log($test_mode, $sql, 'getOptionsList() get required option $sql');

		$res = $this->db->query($sql);

    hpm_log($test_mode, $res, 'getOptionsList() get required option $res');

		if ($res->num_rows) {
			return $res->rows;
		}

		return array();
	}

	public function addProductOption($data, $test_mode = false) {
		// return product_option_id
    hpm_log($test_mode, 'addProductOption() is called');

		$sql = "INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int) $data['product_id'] . "', option_id = '" . (int) $data['option_id'] . "', value = '', required = '1'";

    hpm_log($test_mode, $sql, 'addProductOption() $sql');

    $res = $this->db->query($sql);

		hpm_log($test_mode, $res, 'addProductOption() $res');

		return $this->db->getLastId();
	}

	public function editProductOption($data, $test_mode = false) {
		hpm_log($test_mode, 'editProductOption() is called');

		$sql = "UPDATE " . DB_PREFIX . "product_option SET " . $data['field'] . " = '" . $this->db->escape($data['value']) . "' WHERE product_id = '" . (int) $data['product_id'] . "' AND option_id = '" . (int) $data['option_id'] . "'";

		hpm_log($test_mode, $sql, 'editProductOption() $sql');

		$res = $this->db->query($sql);

		hpm_log($test_mode, $res, 'editProductOption() $res');
	}

  public function addProductOptionValue($data, $test_mode = false) {
    hpm_log($test_mode, 'addProductOptionValue() is called');

		$sql = "INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . $this->db->escape($data['product_option_id']) . "', product_id = '" . (int) $data['product_id'] . "', option_id = '" . (int) $data['option_id'] . "', option_value_id = '" . (int) $data['option_value_id'] . "', quantity = '0', subtract = '1', price = '0', price_prefix = '+', points = '0', points_prefix = '+', weight = '0', weight_prefix = '+' ";

    hpm_log($test_mode, $sql, 'addProductOptionValue() $sql');

    $res = $this->db->query($sql);

		hpm_log($test_mode, $res, 'addProductOptionValue() $res');

		return $this->db->getLastId();
	}

  public function editProductOptionValue($data, $test_mode = false) {
    hpm_log($test_mode, 'editProductOptionValue() is called');

    //$sql = "UPDATE " . DB_PREFIX . "product_option_value SET " . $data['field'] . " = '" . $this->db->escape($data['value']) . "' WHERE product_id = '" . (int) $data['product_id'] . "' AND option_id = '" . (int) $data['option_id'] . "' AND product_option_id = '" . (int) $data['product_option_id'] . "'";
    $sql = "UPDATE " . DB_PREFIX . "product_option_value SET " . $data['field'] . " = '" . $this->db->escape($data['value']) . "' WHERE product_option_value_id = '" . (int) $data['product_option_value_id'] . "'";

    hpm_log($test_mode, $sql, 'editProductOptionValue() $sql');

    $res = $this->db->query($sql);

		hpm_log($test_mode, $res, 'editProductOptionValue() $res');
	}

  public function deleteOptionFromProduct($data, $test_mode = false) {
    // Удаляет данные из таблиц product_option и product_option_value
    hpm_log($test_mode, 'deleteOptionFromProduct() is called');

    $this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$data['product_id'] . "' AND option_id = '" . (int)$data['option_id'] . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$data['product_id'] . "' AND option_id = '" . (int)$data['option_id'] . "'");
  }

  public function deleteProductOptionValue($data, $test_mode = false) {
    // Удаляет данные из таблицы product_option_value
    hpm_log($test_mode, 'deleteProductOptionValue() is called');

    $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$data['product_id'] . "' AND product_option_value_id = '" . (int)$data['product_option_value_id'] . "'");
  }




	// create & clone new product
	public function addNewProduct($data_input, $test_mode = false) {
		if ($test_mode) {
			hpm_log($test_mode, 'addNewProduct() is called');
			hpm_log($test_mode, $data_input, 'addNewProduct() $data_input');
		}

		$product_id = $data_input['clone_product_id'];

		if ('clone_product' == $data_input['flag'] || 'clone_product_with_image' == $data_input['flag'] || 'create_new_product_with_copy_minimum' == $data_input['flag']) {
			hpm_log($test_mode, 'addNewProduct() дошли до составления sql-запроса');

			$sql = "SELECT DISTINCT * FROM " . DB_PREFIX . "product p WHERE p.product_id = '" . (int) $product_id . "'";

			hpm_log($test_mode, $sql, 'addNewProduct() \$sql');

			$query = $this->db->query($sql);

			hpm_log($test_mode, $query, 'addNewProduct() \$query');

			if ($query->num_rows) {
				$data			 = $query->row;
				//$data['sku']	 = '';
				$data['upc']	 = '';
				$data['viewed']	 = '0';
				$data['keyword'] = '';
				$data['status']	 = '0';

				if ('clone_product' == $data_input['flag'] || 'create_new_product_with_copy_minimum' == $data_input['flag']) {
					$data['image']			 = '';
					$data['product_image']	 = array();
				} else {
					// clone_product_with_image
					$data['product_image'] = $this->getProductImages($product_id);
				}

				$data['product_description'] = $this->getProductDescriptions($product_id);
				$data['product_store']			 = $this->getProductStores($product_id);
				$data['product_attribute']	 = $this->getProductAttributes($product_id);
				$data['product_option']			 = $this->getProductOptions($product_id);
				$data['product_discount']		 = $this->getProductDiscounts($product_id);
				$data['product_special']		 = $this->getProductSpecials($product_id);
				//$data['product_image'] = $this->getProductImages($product_id);
				$data['product_download']		 = $this->getProductDownloads($product_id);
				$data['product_category']		 = $this->getProductCategories($product_id);

				$this->load->model('catalog/product');

				$data['product_main_category'] = $this->model_catalog_product->getProductMainCategoryId($product_id);	// todo - обработать главную...
				$data['product_filter']				 = $this->getProductFilters($product_id);
				$data['product_related']			 = $this->getProductRelated($product_id);
				$data['product_reward']				 = $this->getProductRewards($product_id);
				$data['product_layout']				 = $this->getProductLayouts($product_id);
				$data['product_recurrings']		 = $this->getRecurrings($product_id); // 'recurring' in addProduct() !!
			} else {
				$data = array();
			}
		} else {
			hpm_log($test_mode, 'addNewProduct() условие 1 не соблюдено');
		}

		if ('create_new_product' == $data_input['flag']) {
			// Создать новый товар вообще без копирования данных
			// Рассчитано на то, что пользователь осознанно добавил более 1 товара пустыми
			// По крайней мере, если он хотел добавить их пустыми, а мы ему впишем что-то, то ему надо будет все переопределять
			// намного дольше, чем при 1 добавленном товаре
			// Вернуть ид товара, только все остальные данные успешно склонированы

			$data = array();

			//$data['image'] = '';
			$data['model']			 = '';
			$data['sku']			 = '';
			$data['upc']			 = '';
			$data['ean']			 = '';
			$data['jan']			 = '';
			$data['isbn']			 = '';
			$data['mpn']			 = '';
			$data['location']		 = '';
			$data['quantity']		 = 0; //Q?
			$data['minimum']		 = 1;
			$data['subtract']		 = 1; //Q?
			$data['stock_status_id'] = 1; //Q? - settings??
			$data['date_available']	 = ''; //Q? - что означает?
			$data['manufacturer_id'] = 0;
			$data['shipping']		 = 1; //Q? - что означает?
			$data['price']			 = 0;
			$data['points']			 = 0;
			$data['weight']			 = 0.0;
			$data['weight_class_id'] = 0; //Q? - settings??
			$data['length']			 = 0.0;
			$data['width']			 = 0.0;
			$data['height']			 = 0.0;
			$data['length_class_id'] = 0; //Q? - settings??
			$data['status']			 = '0';
			$data['tax_class_id']	 = '0'; //Q? - settings??
			$data['sort_order']		 = 0;

			$data['product_description'] = array(); // must be

			foreach ($data_input['languages'] as $lanugage) {
				$data['product_description'][$lanugage['language_id']]['name']				 = '';
				$data['product_description'][$lanugage['language_id']]['description']		 = '';
				$data['product_description'][$lanugage['language_id']]['tag']				 = '';
				$data['product_description'][$lanugage['language_id']]['meta_title']		 = '';
				$data['product_description'][$lanugage['language_id']]['meta_description']	 = '';
				$data['product_description'][$lanugage['language_id']]['meta_keyword']		 = '';
			}

			$data['keyword'] = ''; // must be
			// Следующие данные могут отстуствовать - проверяются на isset
			//
      $data['product_store'] = array(0);
			//$data['product_attribute'] = array();
			//$data['product_option'] = array();
			//$data['product_discount'] = array();
			//$data['product_special'] = $this->getProductSpecials($product_id);
			//$data['product_image'] = array();
			//$data['product_download'] = $this->getProductDownloads($product_id);
			//$data['product_category'] = $this->getProductCategories($product_id);
			//$data['product_filter'] = array();
			//$data['product_related'] = array();
			//$data['product_reward'] = array();
			//$data['product_layout'] = $this->getProductLayouts($product_id);
			//$data['product_recurrings'] = $this->getRecurrings($product_id); // 'recurring' in addProduct() !!
		} else {
			hpm_log($test_mode, 'addNewProduct() условие 2 не соблюдено');
		}

		if ($test_mode) {
			hpm_log($test_mode, $data, 'addNewProduct() $data for addProduct()');
		}

		if (count($data) > 0) {
			return $this->addProduct($data);
		}

		return false;
	}




	/* Handy Prodcut Manager Mass Edit
	--------------------------------------------------------------------------- */
	//////////////////////////////////////////////////////////////////////////////

	public function countProductsForMassEdit($filter, $test_mode = false) {
		// A!
		// При использовании $sql = "SELECT COUNT(*) FROM " . DB_PREFIX . "product p";
		// кол-во задваивается!
		// Я могу сразу получить список товаров и там же будет указано num_rows

		hpm_log($test_mode, 'countProductsForMassEdit() : is called');

		// Prepare Data
		if (isset($filter['attribute'])) {
			foreach ($filter['attribute'] as $key => $attribute) {
				if ('*' == $attribute) {
					unset($filter['attribute'][$key]);
				}
			}
		}

		if (isset($filter['attribute_value'])) {
			foreach ($filter['attribute_value'] as $key => $attribute_value) {
				if ('*' == $attribute_value) {
					unset($filter['attribute_value'][$key]);
				}
			}
		}

		if (isset($filter['option'])) {
			foreach ($filter['option'] as $key => $option) {
				if ('*' == $option) {
					unset($filter['option'][$key]);
				}
			}
		}

		$sql = "SELECT p.product_id FROM " . DB_PREFIX . "product p";

		// Join Category
		if ((isset($filter['category']) && count($filter['category']) > 0) || (isset($filter['main_category_id']) && $filter['main_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p2c.product_id = p.product_id)";
		}

		// Join Attribute
		if (isset($filter['attribute']) && count($filter['attribute']) > 0) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_attribute pa ON (pa.product_id = p.product_id)";
		}

		// Join Option
		if (isset($filter['option']) && count($filter['option']) > 0) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_option po ON (po.product_id = p.product_id)";
		}

		$sql .= " WHERE p.product_id != '0'"; // :)

		// Where Category
		if (!isset($filter['category']) && (isset($filter['main_category_id']) && $filter['main_category_id'])) {
			$sql .= " AND p2c.category_id = '" . (int) $filter['main_category_id'] . "' AND main_category = '1'";
		}

		if (isset($filter['category']) && count($filter['category']) > 0) {
			$main_add = '';

			if (isset($filter['main_category_id']) && $filter['main_category_id']) {
				$main_add = " AND p2c.product_id IN ( SELECT product_id FROM oc_product_to_category WHERE category_id = '" . (int) $filter['main_category_id'] . "' AND main_category = '1' ) ";

				if (!in_array($filter['main_category_id'], $filter['category'])) {
					$filter['category'][] = $filter['main_category_id']; // main_category is required to category
				}
			}

			// OR
			if ('OR' == $filter['category_flag']) {
				$sql .= " AND p2c.category_id IN (";

				$i = 0;
				foreach ($filter['category'] as $category) {
					$sql .= $i ? ', ' : '';
					$sql .= (int) $category;
					$i++;
				}

				$sql .= ")";

				if ($main_add) $sql .= $main_add;
			} else {
				// AND
				$sql .= " AND p2c.product_id IN (SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE category_id IN (";

				$i = 0;
				foreach ($filter['category'] as $category) {
					$sql .= $i ? ', ' : '';
					$sql .= (int) $category;
					$i++;
				}

				$sql .= ") GROUP BY product_id HAVING (COUNT(*) = " . (int) count($filter['category']) . ") ";

				if ($main_add) $sql .= $main_add;

				$sql .=")";
			}
		}

		hpm_log($test_mode, $filter['category_flag'], 'countProductsForMassEdit():$filter[\'category_flag\']');

		// Where Manufacturer
		if (isset($filter['manufacturer']) && count($filter['manufacturer']) > 0) {
			$sql .= " AND p.manufacturer_id IN (";

			$i = 0;
			foreach ($filter['manufacturer'] as $manufacturer) {
				$sql .= $i ? ', ' : '';
				$sql .= (int) $manufacturer;
				$i++;
			}

			$sql .= ")";
		}

		// Where Attribute
		if (isset($filter['attribute']) && count($filter['attribute']) > 0) {
			$sql .= " AND pa.product_id IN (SELECT product_id FROM " . DB_PREFIX . "product_attribute WHERE language_id='" . (int) $this->config->get('config_language_id') . "' AND attribute_id IN (";

				$i = 0;
				foreach ($filter['attribute'] as $attribute) {
					$sql .= $i ? ', ' : '';
					$sql .= (int) $attribute;
					$i++;
				}

			$sql .= ") GROUP BY product_id HAVING (COUNT(*) = " . (int) count($filter['attribute']) . ") )";
		}

		// Where Attribute Value
		if (isset($filter['attribute_value']) && count($filter['attribute_value']) > 0) {
			$sql_attr_val = '';

			$i = 0;
			foreach ($filter['attribute_value'] as $attribute_value) {
				if (!empty($attribute_value)) { // A! $i
					$sql_attr_val .= $i ? ', ' : '';
					$sql_attr_val .= "'" . $this->db->escape($attribute_value) . "'";
					$i++; // A! $i
				}
			}

			if ($sql_attr_val) {
				$sql .= " AND pa.product_id IN (SELECT product_id FROM " . DB_PREFIX . "product_attribute WHERE language_id='" . (int) $this->config->get('config_language_id') . "' AND text IN ($sql_attr_val) GROUP BY product_id HAVING (COUNT(*) = " . (int) $i . ") )"; // A! $i
			}
		}

		// Where Option
		if (isset($filter['option']) && count($filter['option']) > 0) {
			$sql .= " AND po.product_id IN (SELECT product_id FROM " . DB_PREFIX . "product_option WHERE option_id IN (";

				$i = 0;
				foreach ($filter['option'] as $option) {
					$sql .= $i ? ', ' : '';
					$sql .= (int) $option;
					$i++;
				}

			$sql .= ") GROUP BY product_id HAVING (COUNT(*) = " . (int) count($filter['option']) . ") )";
		}

		// Where Status
		if ('*' != $filter['status']) {
			$sql .= " AND status = '" . (int) $filter['status'] . "'";
		}

		// Where Image
		if ('*' != $filter['image']) {
			$img_char = '=';

			if ($filter['image']) {
				$img_char = '!=';
			}

			$sql .= " AND image $img_char ''";
		}

		// Where Date Added
		if ($filter['date_from']) {
			$sql .= " AND date_added >= '" . $this->db->escape($filter['date_from']) . "'";
		}

		if ($filter['date_before']) {
			$sql .= " AND date_added <= '" . $this->db->escape($filter['date_before']) . "'";
		}

		// Where Price
		if ($filter['price_min']) {
			$sql .= " AND price >= '" . (int) $filter['price_min'] . "'";
		}

		if ($filter['price_max']) {
			$sql .= " AND price <= '" . (int) $filter['price_max']. "'";
		}

		// Where Quantity
		if ($filter['quantity_min']) {
			$sql .= " AND quantity >= '" . (int) $filter['quantity_min'] . "'";
		}

		if ($filter['quantity_max']) {
			$sql .= " AND quantity <= '" . (int) $filter['quantity_max']. "'";
		}


		$sql .= ' GROUP BY p.product_id';

		hpm_log($test_mode, $sql, 'countProductsForMassEdit() : $sql');

		$query = $this->db->query($sql);

		if ($query) {
			return $query->num_rows;
		} else {
			return false;
		}
	}

	public function getProductsForEditOnIteration($filter, $limits, $test_mode = false) {
		hpm_log($test_mode, 'getProductsForEditOnIteration() : is called');

		// Prepare Data
		if (isset($filter['attribute'])) {
			foreach ($filter['attribute'] as $key => $attribute) {
				if ('*' == $attribute) {
					unset($filter['attribute'][$key]);
				}
			}
		}

		if (isset($filter['attribute_value'])) {
			foreach ($filter['attribute_value'] as $key => $attribute_value) {
				if ('*' == $attribute_value) {
					unset($filter['attribute_value'][$key]);
				}
			}
		}

		if (isset($filter['option'])) {
			foreach ($filter['option'] as $key => $option) {
				if ('*' == $option) {
					unset($filter['option'][$key]);
				}
			}
		}

		$sql = "SELECT p.product_id FROM " . DB_PREFIX . "product p";

		// Join Category
		if ((isset($filter['category']) && count($filter['category']) > 0) || (isset($filter['main_category_id']) && $filter['main_category_id'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p2c.product_id = p.product_id)";
		}

		// Join Attribute
		if (isset($filter['attribute']) && count($filter['attribute']) > 0) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_attribute pa ON (pa.product_id = p.product_id)";
		}

		// Join Option
		if (isset($filter['option']) && count($filter['option']) > 0) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_option po ON (po.product_id = p.product_id)";
		}

		$sql .= " WHERE p.product_id != '0'"; // :)

		// Where Category
		if (!isset($filter['category']) && (isset($filter['main_category_id']) && $filter['main_category_id'])) {
			$sql .= " AND p2c.category_id = '" . (int) $filter['main_category_id'] . "' AND main_category = '1'";
		}

		if (isset($filter['category']) && count($filter['category']) > 0) {
			$main_add = '';

			if (isset($filter['main_category_id']) && $filter['main_category_id']) {
				$main_add = " AND p2c.product_id IN ( SELECT product_id FROM oc_product_to_category WHERE category_id = '" . (int) $filter['main_category_id'] . "' AND main_category = '1' ) ";

				if (!in_array($filter['main_category_id'], $filter['category'])) {
					$filter['category'][] = $filter['main_category_id']; // main_category is required to category
				}
			}

			// OR
			if ('OR' == $filter['category_flag']) {
				$sql .= " AND p2c.category_id IN (";

				$i = 0;
				foreach ($filter['category'] as $category) {
					$sql .= $i ? ', ' : '';
					$sql .= (int) $category;
					$i++;
				}

				$sql .= ")";

				if ($main_add) $sql .= $main_add;
			} else {
				// AND
				$sql .= " AND p2c.product_id IN (SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE category_id IN (";

				$i = 0;
				foreach ($filter['category'] as $category) {
					$sql .= $i ? ', ' : '';
					$sql .= (int) $category;
					$i++;
				}

				$sql .= ") GROUP BY product_id HAVING (COUNT(*) = " . (int) count($filter['category']) . ") ";

				if ($main_add) $sql .= $main_add;

				$sql .=")";
			}
		}

		// Where Manufacturer
		if (isset($filter['manufacturer']) && count($filter['manufacturer']) > 0) {
			$sql .= " AND p.manufacturer_id IN (";

			$i = 0;
			foreach ($filter['manufacturer'] as $manufacturer) {
				$sql .= $i ? ', ' : '';
				$sql .= (int) $manufacturer;
				$i++;
			}

			$sql .= ")";
		}

		// Where Attribute
		if (isset($filter['attribute']) && count($filter['attribute']) > 0) {
			$sql .= " AND pa.product_id IN (SELECT product_id FROM " . DB_PREFIX . "product_attribute WHERE language_id='" . (int)$this->config->get('config_language_id') . "' AND attribute_id IN (";

				$i = 0;
				foreach ($filter['attribute'] as $attribute) {
					$sql .= $i ? ', ' : '';
					$sql .= (int) $attribute;
					$i++;
				}

			$sql .= ") GROUP BY product_id HAVING (COUNT(*) = " . (int) count($filter['attribute']) . ") )";
		}

		// Where Attribute Value
		if (isset($filter['attribute_value']) && count($filter['attribute_value']) > 0) {
			$sql_attr_val = '';

			$i = 0;
			foreach ($filter['attribute_value'] as $attribute_value) {
				if (!empty($attribute_value)) { // A! $i
					$sql_attr_val .= $i ? ', ' : '';
					$sql_attr_val .= "'" . $this->db->escape($attribute_value) . "'";
					$i++; // A! $i
				}
			}

			if ($sql_attr_val) {
				$sql .= " AND pa.product_id IN (SELECT product_id FROM " . DB_PREFIX . "product_attribute WHERE language_id='" . (int) $this->config->get('config_language_id') . "' AND text IN ($sql_attr_val) GROUP BY product_id HAVING (COUNT(*) = " . (int) $i . ") )"; // A! $i
			}
		}

		// Where Option
		if (isset($filter['option']) && count($filter['option']) > 0) {
			$sql .= " AND po.product_id IN (SELECT product_id FROM " . DB_PREFIX . "product_option WHERE option_id IN (";

				$i = 0;
				foreach ($filter['option'] as $option) {
					$sql .= $i ? ', ' : '';
					$sql .= (int) $option;
					$i++;
				}

			$sql .= ") GROUP BY product_id HAVING (COUNT(*) = " . (int) count($filter['option']) . ") )";
		}

		// Where Status
		if ('*' != $filter['status']) {
			$sql .= " AND status = '" . (int) $filter['status'] . "'";
		}

		// Where Image
		if ('*' != $filter['image']) {
			$img_char = '=';

			if ($filter['image']) {
				$img_char = '!=';
			}

			$sql .= " AND image $img_char ''";
		}

		// Where Date Added
		if ($filter['date_from']) {
			$sql .= " AND date_added >= '" . $this->db->escape($filter['date_from']) . "'";
		}

		if ($filter['date_before']) {
			$sql .= " AND date_added <= '" . $this->db->escape($filter['date_before']) . "'";
		}

		// Where Price
		if ($filter['price_min']) {
			$sql .= " AND price >= '" . (int) $filter['price_min'] . "'";
		}

		if ($filter['price_max']) {
			$sql .= " AND price <= '" . (int) $filter['price_max']. "'";
		}

		// Where Quantity
		if ($filter['quantity_min']) {
			$sql .= " AND quantity >= '" . (int) $filter['quantity_min'] . "'";
		}

		if ($filter['quantity_max']) {
			$sql .= " AND quantity <= '" . (int) $filter['quantity_max']. "'";
		}


		$sql .= ' GROUP BY p.product_id';

		$sql .= " LIMIT " . (int) $limits['first_element'] . "," . (int) $limits['limit_n'] . ";";

		hpm_log($test_mode, $sql, 'getProductsForEditOnIteration() : $sql');

		$query = $this->db->query($sql);

//		hpm_log($test_mode, $query, 'getProductsForEditOnIteration() : $query');

		if ($query) {
			hpm_log($test_mode, $query->rows, 'getProductsForEditOnIteration() : $query->rows');

			$out = array();

			foreach ($query->rows as $value) {
				$out[] = $value['product_id'];
			}

			return $out;
		} else {
			return false;
		}
	}

	public function massEditCategory($data, $test_mode = false) {
		hpm_log($test_mode, 'massEditCategory() : is called');
		hpm_log($test_mode, $data, 'massEditCategory() : $data : ');

		// Если нужно сбросить
		if ('reset_add' == $data['category_flag']) {
			$sql = "DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int) $data['product_id'] . "'";

			hpm_log($test_mode, $sql, 'massEditCategory() : reset_add - $sql :');

			$this->db->query($sql);
		} else {
			// Что если главная категория была одной, а теперь присваивается другая?
			if ($data['main_category_id']) {
				$sql = "UPDATE " . DB_PREFIX . "product_to_category SET main_category = 0 WHERE product_id = '" . (int) $data['product_id'] . "'";

				hpm_log($test_mode, $sql, 'massEditCategory():reset main category $sql');

				$this->db->query($sql);
			}
		}

		// Потом добавляем категории, одновременно делая одну из них главной
		// Главная категория неразрывно связана с категориями
		// Может так случиться, что человек назначает главной ту категорию, которая вообще еще не отмечена для товара
		if ($data['main_category_id'] && !in_array($data['main_category_id'], $data['categories'])) {
			$data['categories'][] = $data['main_category_id'];
		}

		if (isset($data['categories'])) {
			foreach ($data['categories'] as $category) {
				$sql = "INSERT IGNORE INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int) $data['product_id'] . "', category_id = '" . (int) $category . "'";
				hpm_log($test_mode, $sql, 'massEditCategory():INSERT categories $sql ');

				$this->db->query($sql);
			}
		}

		if ($data['main_category_id']) {
			$sql = "UPDATE " . DB_PREFIX . "product_to_category SET main_category = 1 WHERE product_id = '" . (int) $data['product_id'] . "' AND category_id = '" . (int) $data['main_category_id'] . "'";

			hpm_log($test_mode, $sql, 'massEditCategory() : UPDATE MAIN CATEGORY');

			$this->db->query($sql);
		}
	}

	public function massEditManufacturer($manufacturer_id, $product_id, $test_mode = false) {
		hpm_log($test_mode, 'massEditManufacturer() : is called');
		hpm_log($test_mode, $manufacturer_id, 'massEditManufacturer() : $manufacturer_id : ');
		hpm_log($test_mode, $product_id, 'massEditManufacturer() : $product_id : ');

		$sql = "UPDATE " . DB_PREFIX . "product SET manufacturer_id = '" . (int) $manufacturer_id . "' WHERE product_id = '" . (int) $product_id . "'";

		hpm_log($test_mode, $sql, 'massEditManufacturer() : $sql : ');

		$this->db->query($sql);
	}

	public function massEditWeightField($weight, $product_id, $test_mode = false) {
		hpm_log($test_mode, 'massEditWeightField() : is called');

		hpm_log($test_mode, $weight, 'massEditWeightField() : $weight');

		if($weight) {
			$first_char = mb_substr($weight, 0, 1, 'UTF-8');

			if ('+' == $first_char || '-' == $first_char) {
				$weight = trim(mb_substr($weight, 1, mb_strlen($weight), 'UTF-8'));
			} else {
				return false; // Нельзя всем товарам назначать одинаковые значения!
			}

			$weight_value = (float) $weight;

			$weight_old = $this->getProductField('weight', $product_id, $test_mode = false);

			hpm_log($test_mode, $weight_old, 'massEditWeightField() : $weight_old');

			$weight_new = false;

			if ('+' == $first_char) {
				$weight_new = $weight_old + $weight_value;
			}

			if ('-' == $first_char) {
				$weight_new = $weight_old - $weight_value;
			}

			if ($weight_new) {
				$sql = "UPDATE " . DB_PREFIX . "product SET weight = '" . (float) $weight_new . "' WHERE product_id = '" . (int) $product_id . "'";

				hpm_log($test_mode, $sql, 'massEditWeightField() : $sql');

				$this->db->query($sql);
			}
		}
	}

	public function massEditWeightClassField($weight_class_id, $product_id, $test_mode = false) {
		hpm_log($test_mode, 'massEditWeightClassField() : is called');

		$sql = "UPDATE " . DB_PREFIX . "product SET weight_class_id = '" . (int) $weight_class_id . "' WHERE product_id = '" . (int) $product_id . "'";

		hpm_log($test_mode, $sql, 'massEditWeightClassField() : $sql');

		$this->db->query($sql);
	}

	public function massEditPriceField($field = 'price', $value = false, $product_id, $test_mode = false) {
		hpm_log($test_mode, 'massEditPriceField() : is called');

		hpm_log($test_mode, $field, 'massEditPriceField() : $field');

		hpm_log($test_mode, $value, 'massEditPriceField() : $value');

		if($value) {
			$value = trim($value);

			$first_char = mb_substr($value, 0, 1, 'UTF-8');

			if ('+' == $first_char || '-' == $first_char) {
				$value = trim(mb_substr($value, 1, mb_strlen($value), 'UTF-8'));
			} else {
				return false; // Нельзя всем товарам назначать одинаковую цену!
			}

			$percent = false;

			if (false !== strpos($value, '%')) {
				$percent = true;
			}

			$price_value = (float) $value;

			$price_old = $this->getProductField($field, $product_id, $test_mode = false);

			hpm_log($test_mode, $price_old, 'massEditPriceField() : $price_old');

			$price_new = false;

			if ('+' == $first_char) {
				if ($percent) {
					$price_new = $price_old + ($price_old * $price_value / 100);
				} else {
					$price_new = $price_old + $price_value;
				}
			}

			if ('-' == $first_char) {
				if ($percent) {
					$price_new = $price_old - ($price_old * $price_value / 100);
				} else {
					$price_new = $price_old - $price_value;
				}
			}

			if ($price_new) {
				$sql = "UPDATE " . DB_PREFIX . "product SET " . $this->db->escape($field) . " = '" . (float) $price_new . "' WHERE product_id = '" . (int) $product_id . "'";

				hpm_log($test_mode, $sql, 'massEditPriceField() : $sql');

				$this->db->query($sql);
			}
		}
	}

	public function massEditDiscount($discounts, $product_id, $test_mode = false) {
		hpm_log($test_mode, 'massEditDiscount() : is called');

		if (isset($discounts['flag_clear'])) {
			// Удалить старые скидки
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int) $product_id . "'");

			unset($discounts['flag_clear']);
		}

		// Добавляем новые
		$price_old = $this->getProductField('price', $product_id, $test_mode = false);

		if ($price_old < 0.1) return false;

		foreach ($discounts as $discount) {
			$value = trim($discount['price']);

			$first_char = mb_substr($value, 0, 1, 'UTF-8');

			if ('-' == $first_char) {
				$value = trim(mb_substr($value, 1, mb_strlen($value), 'UTF-8'));
			} else {
				return false; // Нельзя всем товарам назначать одинаковую цену!
			}

			$percent = false;

			if (false !== strpos($value, '%')) {
				$percent = true;
			}

			$price_value = (float) $value;

			$price_discount = false;

			if ('-' == $first_char) {
				if ($percent) {
					$price_discount = $price_old - ($price_old * $price_value / 100);
				} else {
					$price_discount = $price_old - $price_value;
				}
			}

			hpm_log($test_mode, $price_old, 'massEditDiscount() : $price_old');
			hpm_log($test_mode, $price_discount, 'massEditDiscount() : $price_discount');

			if ($price_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_discount SET product_id = '" . (int) $product_id . "', customer_group_id = '" . (int) $discount['customer_group_id'] . "', quantity = '" . (int) $discount['quantity'] . "', priority = '" . (int) $discount['priority'] . "', price = '" . (float) $price_discount . "', date_start = '" . $this->db->escape($discount['date_start']) . "', date_end = '" . $this->db->escape($discount['date_end']) . "'");
			}

		}
	}

	public function massEditSpecial($specials, $product_id, $test_mode = false) {
		hpm_log($test_mode, 'massEditSpecial() : is called');

		if (isset($specials['flag_clear'])) {
			// Удалить старые акции
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int) $product_id . "'");

			unset($specials['flag_clear']);
		}

		// Добавляем новые
		$price_old = $this->getProductField('price', $product_id, $test_mode = false);

		if ($price_old < 0.1) return false;

		foreach ($specials as $special) {
			$value = trim($special['price']);

			$first_char = mb_substr($value, 0, 1, 'UTF-8');

			if ('-' == $first_char) {
				$value = trim(mb_substr($value, 1, mb_strlen($value), 'UTF-8'));
			} else {
				hpm_log($test_mode, $value, 'massEditSpecial() : return false');
				return false; // Нельзя всем товарам назначать одинаковую цену!
			}

			$percent = false;

			if (false !== strpos($value, '%')) {
				$percent = true;
			}

			$price_value = (float) $value;

			$price_special = false;

			if ('-' == $first_char) {
				if ($percent) {
					$price_special = $price_old - ($price_old * $price_value / 100);
				} else {
					$price_special = $price_old - $price_value;
				}
			}

			hpm_log($test_mode, $price_old, 'massEditSpecial() : $price_old');
			hpm_log($test_mode, $price_special, 'massEditSpecial() : $price_special');

			if ($price_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int) $product_id . "', customer_group_id = '" . (int) $special['customer_group_id'] . "', priority = '" . (int) $special['priority'] . "', price = '" . (float) $price_special . "', date_start = '" . $this->db->escape($special['date_start']) . "', date_end = '" . $this->db->escape($special['date_end']) . "'");
			}

		}
	}

	public function massEditQuantityField($value = false, $product_id, $test_mode = false) {
		hpm_log($test_mode, 'massEditQuantityField() : is called');

		hpm_log($test_mode, $value, 'massEditQuantityField() : $value');

		if($value) {
			$value = trim($value);

			$first_char = mb_substr($value, 0, 1, 'UTF-8');

			if ('+' == $first_char || '-' == $first_char) {
				$value = trim(mb_substr($value, 1, mb_strlen($value), 'UTF-8'));
			}

			$value = (float) $value;

			$value_old = $this->getProductField('quantity', $product_id, $test_mode);

			$value_new = $value; // Value from form

			if ('+' == $first_char) {
				$value_new = $value_old + $value;
			}

			if ('-' == $first_char) {
				$value_new = $value_old - $value;
			}

			$sql = "UPDATE " . DB_PREFIX . "product SET quantity = '" . (float) $value_new . "' WHERE product_id = '" . (int) $product_id . "'";

			hpm_log($test_mode, $sql, 'massEditQuantityField() : $sql');

			$this->db->query($sql);
		}
	}

	public function massEditPoints($points, $product_id, $test_mode = false) {
		hpm_log($test_mode, 'massEditPoints() is called');

		$sql = "UPDATE " . DB_PREFIX . "product SET points = '" . (int) $points . "' WHERE product_id = '" . (int) $product_id . "'";

		hpm_log($test_mode, $sql, 'massEditQuantityField() : $sql');

		$this->db->query($sql);
	}

	public function massEditProductReward($product_reward, $product_id, $test_mode = false) {
		hpm_log($test_mode, 'massEditProductReward() is called');

//		hpm_log($test_mode, $product_reward, 'massEditProductReward():$product_reward');

		foreach ($product_reward as $customer_group_id => $item) {
			// $sql = "INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int) $product_id . "', customer_group_id = '" . (int) $customer_group_id . "', points = '" . (int) $item['points'] . "' ON DUPLICATE KEY UPDATE points = '" . (int) $item['points'] . "'";
			// ON DUPLICATE KEY UPDATE work only for PRIMARY KEY...

			$sql = "SELECT points FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "'";

			hpm_log($test_mode, $sql, 'editProductReward() $sql SELECT');

			$res = $this->db->query($sql);

			if ($res->num_rows > 0) {
				$sql2 = "UPDATE " . DB_PREFIX . "product_reward SET customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$item['points'] . "' WHERE product_id = '" . (int)$product_id . "'";

				hpm_log($test_mode, $sql2, 'editProductReward() $sql2 UPDATE');

			} else {
				$sql2 = "INSERT INTO " . DB_PREFIX . "product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$item['points'] . "'";

				hpm_log($test_mode, $sql2, 'editProductReward() $sql2 INSERT');
			}

			$res2 = $this->db->query($sql2);

			hpm_log($test_mode, $res2, 'editProductReward() $res2 product_id : ' . $product_id . ' : ');
		}
	}

	public function massEditMinimumField($minimum, $product_id, $test_mode = false) {
		hpm_log($test_mode, 'massEditMinimumField() : is called');

		$sql = "UPDATE " . DB_PREFIX . "product SET minimum = '" . (int) $minimum . "' WHERE product_id = '" . (int) $product_id . "'";

		hpm_log($test_mode, $sql, 'massEditMinimumField() : $sql');

		$this->db->query($sql);
	}

	public function massEditStockStatusField($stock_status_id, $product_id, $test_mode = false) {
		hpm_log($test_mode, 'massEditStockStatusField() : is called');

		$sql = "UPDATE " . DB_PREFIX . "product SET stock_status_id = '" . (int) $stock_status_id . "' WHERE product_id = '" . (int) $product_id . "'";

		hpm_log($test_mode, $sql, 'massEditStockStatusField() : $sql');

		$this->db->query($sql);
	}

	public function massEditSubtractField($subtract, $product_id, $test_mode = false) {
		hpm_log($test_mode, 'massEditSubtractField() : is called');

		$sql = "UPDATE " . DB_PREFIX . "product SET subtract = '" . (int) $subtract . "' WHERE product_id = '" . (int) $product_id . "'";

		hpm_log($test_mode, $sql, 'massEditSubtractField() : $sql');

		$this->db->query($sql);
	}

	public function massEditShippingField($shipping, $product_id, $test_mode = false) {
		hpm_log($test_mode, 'massEditShippingField() : is called');

		$sql = "UPDATE " . DB_PREFIX . "product SET shipping = '" . (int) $shipping . "' WHERE product_id = '" . (int) $product_id . "'";

		hpm_log($test_mode, $sql, 'massEditShippingField() : $sql');

		$this->db->query($sql);
	}

	public function massEditDateAvailableField($date_available, $product_id, $test_mode = false) {
		hpm_log($test_mode, 'massEditDateAvailableField() : is called');

		$sql = "UPDATE " . DB_PREFIX . "product SET date_available = '" . $this->db->escape($date_available) . "' WHERE product_id = '" . (int) $product_id . "'";

		hpm_log($test_mode, $sql, 'massEditDateAvailableField() : $sql');

		$this->db->query($sql);
	}

	public function massEditNoindexField($noindex, $product_id, $test_mode = false) {
		hpm_log($test_mode, 'massEditNoindexField() : is called');

		$sql = "UPDATE " . DB_PREFIX . "product SET noindex = '" . (int) $noindex . "' WHERE product_id = '" . (int) $product_id . "'";

		hpm_log($test_mode, $sql, 'massEditNoindexField() : $sql');

		$this->db->query($sql);
	}

	public function massEditStatusField($status, $product_id, $test_mode = false) {
		hpm_log($test_mode, 'massEditStatusField() : is called');

		$sql = "UPDATE " . DB_PREFIX . "product SET status = '" . (int) $status . "' WHERE product_id = '" . (int) $product_id . "'";

		hpm_log($test_mode, $sql, 'massEditStatusField() : $sql');

		$this->db->query($sql);
	}

	public function massEditProductStore($product_store, $product_id, $test_mode = false) {
		hpm_log($test_mode, 'massEditProductStore() : is called');

		$sql = "DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int) $product_id . "'";

			hpm_log($test_mode, $sql, 'massEditProductStore() : $sql');

			$this->db->query($sql);

		foreach ($product_store as $store_id) {
			$sql = "INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int) $product_id . "', store_id = '" . (int) $store_id . "'";

			hpm_log($test_mode, $sql, 'massEditProductStore() : $sql');

			$this->db->query($sql);
		}
	}

	public function getProductField($field, $product_id, $test_mode = false) {
		$sql = "SELECT " . $this->db->escape($field) . " FROM " . DB_PREFIX . "product WHERE product_id = '" . (int) $product_id. "'";

		hpm_log($test_mode, $sql, 'getProductField():$sql');

		$query = $this->db->query("SELECT " . $this->db->escape($field) . " FROM " . DB_PREFIX . "product WHERE product_id = '" . (int) $product_id. "'");

		return $query->row[$field];
	}

	public function massEditDescription($description, $product_id, $language_id, $test_mode = false) {
		hpm_log($test_mode, 'massEditDescription() : is called');

		// Учесть, что у нас есть пустые текстовые поля...
		foreach ($description as $key => $value) {
			if ('nofollow' == $value) {
				unset($description[$key]);
			}
		}

		if (count($description) > 0) {
			$sql = "UPDATE " . DB_PREFIX . "product_description SET";

			$i = 0;
			foreach ($description as $key => $value) {
				if ($i) $sql .= ",";
				$sql .= " " . $this->db->escape($key) ." = '" . $this->db->escape($value) . "'";
				$i++;
			}

			$sql .= " WHERE product_id = '" . (int) $product_id. "' AND language_id = '" . (int) $language_id. "'";

			hpm_log($test_mode, $sql, 'massEditDescription() : $sql');

			$this->db->query($sql);
		}
	}

	// todo...
	public function replaceVars($search, $replace, $string, $test_mode = false) {
		/*
		 *
		 * Functions:??
		 * lower_case_first -> lcfirst()
		 * upper_case_first -> ucfirst()
		 * cut($str, $cut) -> str_replace($cut, '', $str) // Причем найти совпадения в самых разных регистрах...
		 */

		 // todo: variables [text_exist] [TEXT_EXIST] // для добавления какой-то типичной фразы в начало или конец <ADD_BLOCK class="added-block-1">Likes</ADD_BLOCK>[TEXT_EXIST]

		$string = str_replace($search, $replace, $string);

		return $string;
	}

	public function massEditAttribute($data, $test_mode = false) {
		hpm_log($test_mode, 'massEditAttribute() : is called');
		hpm_log($test_mode, $data, 'massEditAttribute() : $data : ');

		// Если нужно сбросить
		if ('reset_add' == $data['attribute_flag']) {
			$sql = "DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int) $data['product_id'] . "'";

			hpm_log($test_mode, $sql, 'massEditAttribute() : reset_add - $sql :');

			$this->db->query($sql);
		}

		// Потом добавляем заявленные атрибуты
		foreach ($data['attribute'] as $attribute_key => $attribut_item) {
			if ('*' == $attribut_item) continue;

			foreach ($data['attribute_value'] as $language_id => $value) {
				$sql = "INSERT IGNORE INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int) $data['product_id'] . "', attribute_id = '" . (int) $attribut_item . "', language_id = '" . (int) $language_id . "'";

				if ('*' != $value) {
					$sql .= ", text = '" . $this->db->escape($value[$attribute_key]) . "'";
				}

				hpm_log($test_mode, $sql, 'massEditAttribute() : $sql attribute');

				$this->db->query($sql);
			}

		}
	}

	public function massEditOption($data, $test_mode = false) {
		hpm_log($test_mode, 'massEditOption() : is called');
		hpm_log($test_mode, $data, 'massEditOption() : $data : ');

		// Если нужно сбросить
		if ('reset_add' == $data['option_flag']) {
			$sql = "DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int) $data['product_id'] . "'";

			hpm_log($test_mode, $sql, 'massEditOption() : reset_add - $sql 1:');

			$this->db->query($sql);

			$sql = "DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int) $data['product_id'] . "'";

			hpm_log($test_mode, $sql, 'massEditOption() : reset_add - $sql 2:');

			$this->db->query($sql);
		}

		// Потом добавляем заявленные опции
		foreach ($data['option'] as $option_item) {
			if (is_array($option_item['option_value'])) {
				// A! $option_item['option_value'] === option_value_id !!
				// сначала вставляются записи в product_option
				// потом доставляются значения в product_option_value

				foreach ($option_item['option_value'] as $key => $value) {
					hpm_log($test_mode, $option_item, 'massEditOption() : $option_item');

					// check for each itteration !!
					$product_option_id = $this->existOptionInProductOption($data['product_id'], $option_item['option_id'], $test_mode);

					if (!$product_option_id) {
						$sql = "INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int) $data['product_id'] . "', option_id = '" . (int) $option_item['option_id'] . "', value = '', required = '" . (int) $option_item['option_require'] . "'";

						hpm_log($test_mode, $sql, 'massEditOption() : add option value array item in product_option');

						$this->db->query($sql);

						$product_option_id = $this->db->getLastId();
					} else {
						$sql = "UPDATE " . DB_PREFIX . "product_option SET product_id = '" . (int) $data['product_id'] . "', option_id = '" . (int) $option_item['option_id'] . "', value = '" . $this->db->escape($option_item['option_value'][$key]) . "', required = '" . (int) $option_item['option_require'] . "' WHERE product_option_id = '" . (int) $product_option_id . "'";

						hpm_log($test_mode, $sql, 'massEditOption() : $product_option_id was exist - UPDATE');

						$this->db->query($sql);
					}

					if ($product_option_id) {

						//$product_option_id, $product_id, $option_id, $option_value_id,
						$product_option_value_id = $this->existOptionInProductOptionValue($product_option_id, $data['product_id'], $option_item['option_id'], $value, $test_mode);

						if (!$product_option_value_id) {
							$sql = "INSERT INTO " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int) $product_option_id . "', product_id = '" . (int) $data['product_id'] . "', option_id = '" . (int) $option_item['option_id'] . "', option_value_id = '" . (int) $value . "', quantity = '" . (int) $option_item['quantity'][$key] . "', subtract = '" . (int) $option_item['subtract'][$key] . "', price = '" . (int) $option_item['price'][$key] . "', price_prefix = '" . $this->db->escape($option_item['price_prefix'][$key]) . "', points = '" . (int) $option_item['points'][$key] . "', points_prefix = '" . $this->db->escape($option_item['points_prefix'][$key]) . "', weight = '" . (int) $option_item['weight'][$key] . "', weight_prefix = '" . $this->db->escape($option_item['weight_prefix'][$key]) . "'";
							hpm_log($test_mode, $sql, 'massEditOption() : add option value array item in product_option_value INSERT');
						} else {
							$sql = "UPDATE " . DB_PREFIX . "product_option_value SET product_option_id = '" . (int) $product_option_id . "', product_id = '" . (int) $data['product_id'] . "', option_id = '" . (int) $option_item['option_id'] . "', option_value_id = '" . (int) $value . "', quantity = '" . (int) $option_item['quantity'][$key] . "', subtract = '" . (int) $option_item['subtract'][$key] . "', price = '" . (int) $option_item['price'][$key] . "', price_prefix = '" . $this->db->escape($option_item['price_prefix'][$key]) . "', points = '" . (int) $option_item['points'][$key] . "', points_prefix = '" . $this->db->escape($option_item['points_prefix'][$key]) . "', weight = '" . (int) $option_item['weight'][$key] . "', weight_prefix = '" . $this->db->escape( $option_item['weight_prefix'][$key]) . "' WHERE product_option_value_id = '" . (int) $product_option_value_id . "'";
							hpm_log($test_mode, $sql, 'massEditOption() : add option value array item in product_option_value UPDATE');
						}

						$this->db->query($sql);
					}
				}
			} else {
				// вставляются записи только в product_option

				// check separately from $option_item['option_value'] !!
				$product_option_id = $this->existOptionInProductOption($data['product_id'], $option_item['option_id'], $test_mode);

				if (!$product_option_id) {
					$sql = "INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . (int) $data['product_id'] . "', option_id = '" . (int) $option_item['option_id'] . "', value = '" . $this->db->escape($option_item['option_value']) . "', required = '" . (int) $option_item['option_require'] . "'";

					hpm_log($test_mode, $sql, 'massEditOption() : add option simple value INSERT');
				} else {
					$sql = "UPDATE " . DB_PREFIX . "product_option SET product_id = '" . (int) $data['product_id'] . "', option_id = '" . (int) $option_item['option_id'] . "', value = '" . $this->db->escape($option_item['option_value']) . "', required = '" . (int) $option_item['option_require'] . "' WHERE product_option_id = '" . (int) $product_option_id . "'";

					hpm_log($test_mode, $sql, 'massEditOption() : add option simple value UPDATE');
				}

				$this->db->query($sql);
			}
		}

	}

	public function existOptionInProductOption($product_id, $option_id, $test_mode = false) {
		$sql = "SELECT * FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int) $product_id . "' AND option_id = '" . (int) $option_id . "'";

		hpm_log($test_mode, $sql, 'existOptionInProductOption() : $sql');

		$query = $this->db->query($sql);

		hpm_log($test_mode, $query, 'existOptionInProductOption() : $query');

		if ($query->num_rows < 1) {
			return false;
		} else {
			return $query->row['product_option_id'];
		}
	}

	public function existOptionInProductOptionValue($product_option_id, $product_id, $option_id, $option_value_id, $test_mode = false) {
		$sql = "SELECT * FROM " . DB_PREFIX . "product_option_value WHERE product_option_id = '" . (int) $product_option_id . "' AND product_id = '" . (int) $product_id . "' AND option_id = '" . (int) $option_id . "' AND option_value_id = '" . (int) $option_value_id . "'";

		hpm_log($test_mode, $sql, 'existOptionInProductOptionValue() : $sql');

		$query = $this->db->query($sql);

		hpm_log($test_mode, $query, 'existOptionInProductOptionValue() : $query');

		if ($query->num_rows < 1) {
			return false;
		} else {
			return $query->row['product_option_value_id'];
		}
	}

	public function massEditDate($product_id, $test_mode = false) {
		hpm_log($test_mode, 'massEditDate() : is called');

		$sql = "UPDATE " . DB_PREFIX . "product SET date_modified = '" . $this->db->escape( date("Y-m-d H:m:s", time()) ). "'";

		hpm_log($test_mode, $sql, 'massEditDate() : $sql');

		$this->db->query($sql);
	}




	/* Handy Prodcut Manager Helpers
	--------------------------------------------------------------------------- */
	//////////////////////////////////////////////////////////////////////////////

	public function callByLiveEdit($essence, $test_mode = false) {
		// callByLiveEdit() place for customize
		// Clear Cache . begin
    $this->cache->delete('product');
    // Clear Cache . end
		return false;
	}

	public function callByMassEdit($test_mode = false) {
		// callByMassEdit() place for customize
		// Clear Cache . begin
    $this->cache->delete('product');
    // Clear Cache . end
		return false;
	}

	public function getH1() {
		$sql = "SHOW COLUMNS FROM " . DB_PREFIX . "product_description";
		$query = $this->db->query($sql);

		$result = array();

		foreach ($query->rows as $key => $field) {
			if ('meta_h1' == $field['Field']) {
				return 'meta_h1';
			}

			if ('h1' == $field['Field']) {
				return 'h1';
			}
		}

		return false;
	}

	public function getProductTableColumns() {
		$sql = "SHOW COLUMNS FROM " . DB_PREFIX . "product";
		$query = $this->db->query($sql);

		$result = array();

		foreach ($query->rows as $key => $field) {
			if (!$this->isStandartProductField($field['Field'])) {
				$result[$field['Field']] = $field['Type'];
			}
		}

		return $result;
	}

	public function isStandartProductField($field) {
		if (in_array($field, array(
			'product_id',
			'model',
			'sku',
			'upc',
			'ean',
			'jan',
			'isbn',
			'mpn',
			'location',
			'quantity',
			'stock_status_id',
			'image',
			'manufacturer_id',
			'shipping',
			'price',
			'points',
			'tax_class_id',
			'date_available',
			'weight',
			'weight_class_id',
			'length',
			'width',
			'height',
			'length_class_id',
			'subtract',
			'minimum',
			'sort_order',
			'status',
			'viewed',
			'date_added',
			'date_modified',
			'noindex', // for OpenCart PRO
			'options_buy', // for OpenCart PRO
		))) {
			return true;
		}

		return false;
	}

	public function hasMainCategoryColumn() {
		$sql = "SHOW COLUMNS FROM " . DB_PREFIX . "product_to_category;";
		$query = $this->db->query($sql);

		// Изначально в таблице 2 поля
		if ($query->num_rows > 2) {
			foreach ($query->rows as $field) {
				if ('main_category' == $field['Field']) {
					return true;
				}
			}
		}

		return false;
	}


	public function getCategoriesLevel1() {
		$array = array();

		$sql = "SELECT DISTINCT c.category_id, cd.name FROM " . DB_PREFIX . "category c"
			. " LEFT JOIN " . DB_PREFIX . "category_description cd ON cd.category_id = c.category_id"
			. " WHERE c.parent_id = '0' AND cd.language_id = '" . $this->config->get('config_language_id') . "' ORDER BY cd.name ASC";

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$array[] = $result['category_id'];
		}

		return $array;
	}

	public function getDescendantsTreeForCategory($category_id) {
		$array = array(
			'category_id' => $category_id,
			'category_name'	=> $this->getCategoryName($category_id)
		);

		// dauthers
		$sql = "SELECT category_id FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int) $category_id . "'";

		$query = $this->db->query($sql);

		if ($query->num_rows > 0) {
			$array['has_children'] = 1;

			foreach ($query->rows as $result) {
				$array['children'][] = $this->getDescendantsTreeForCategory($result['category_id']);
			}
		} else {
			$array['has_children'] = false;
		}

		return $array;
	}

	public function getDescendantsLinear($category_id) {
		$array = array();

		$sql = "SELECT category_id FROM " . DB_PREFIX . "category_path WHERE path_id = '" . (int) $category_id . "' AND category_id != '" . (int) $category_id . "'";

		$query = $this->db->query($sql);

		if ($query->num_rows > 0) {
			foreach ($query->rows as $result) {
				$array[] = $result['category_id'];
			}
		}

		return $array;
	}

	public function getCategoryName($category_id, $language_id = false) {
		if (!$language_id)
			$language_id = $this->config->get('config_language_id');

		$sql = "SELECT name FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int) $category_id . "' AND language_id = '" . (int) $language_id . "'";

		$query = $this->db->query($sql);

		if (isset($query->row['name'])) {
			return $query->row['name'];
		}

		return 'No Category Name';
	}

	private function getProductData($product_id, $test_mode = false) {
		hpm_log($test_mode, 'getProductData() is called');

    $query = $this->db->query("SELECT `sku`, `model`, `manufacturer_id` FROM `" . DB_PREFIX . "product` WHERE `product_id` = '" . (int)$product_id . "'");

    if ($query->row) {
      return $query->row;
    } else {
			hpm_log($test_mode, $query, 'getProductData() $query error');
    }

    return false;
  }

	public function getManufacturerNameById($manufacturer_id) {
		$sql		 = "SELECT name FROM " . DB_PREFIX . "manufacturer WHERE manufacturer_id='" . (int) $manufacturer_id . "'";
		$result	 = $this->db->query($sql);
		if ($result->row) {
			return $result->row['name'];
		}
		return false;
	}




	/* SEO URL
	------------------------------------------------------------ */

	public function translit($string, $setting, $test_mode = false) {
		$this->load->model('tool/translit');

		$string = html_entity_decode(mb_strtolower($string));

		$translit_function = $setting['translit_function'];

		if ($translit_function) {
			$string = $this->model_tool_translit->$translit_function($string);
		}

		$string = $this->model_tool_translit->clearWasteChars($string);

		return $string;
	}

	public function setURL($essence, $primary_key, $essence_id, $setting, $test_mode = false) {
		hpm_log($test_mode, 'setURL() is called');

		$name = $this->getEssenceName($essence, $primary_key, $essence_id, $setting, $test_mode);

		if (!$name) {
			return false;
		}

		hpm_log($test_mode, $name, '$name');

		if ($setting['translit_formula']) {
			// product

			hpm_log($test_mode, $setting, '$setting');

			$model = '';
			$sku = '';
			$manufacturer_name = '';
			//$product_id = $essence_id;

			if (false !== strstr($setting['translit_formula'], '[model]') || false !== strstr($setting['translit_formula'], '[sku]') || false !== strstr($setting['translit_formula'], '[manufacturer_name]')) {
				$product_item = $this->getProductData($essence_id, $test_mode);

				if ($product_item) {
					hpm_log($test_mode, $product_item, '$product_item');

					$model = $product_item['model'];
					$sku	 = $product_item['sku'];

					if (false !== strstr($setting['translit_formula'], '[manufacturer_name]')) {
						$manufacturer_name = $this->getManufacturerNameById($product_item['manufacturer_id'], $setting);

						hpm_log($test_mode, $manufacturer_name, '$manufacturer_name');

					}
				}
			} else {
				hpm_log($test_mode, 'Formula not contain data');
			}

			$string_to_translit = str_replace(array('[product_name]', '[product_id]', '[model]', '[sku]', '[manufacturer_name]'), array($name, $essence_id, $model, $sku, $manufacturer_name), $setting['translit_formula']);

			hpm_log($test_mode, $string_to_translit, '$string_to_translit');
		} else {
			$string_to_translit = $name;
		}

		$keyword = $this->translit(mb_strtolower($string_to_translit), $setting, $test_mode);
		$keyword = $this->getUniqueUrl($keyword);

		hpm_log($test_mode, $name, '$name');
		hpm_log($test_mode, $keyword, '$keyword');

		// if success return inserted new SEO URL
		if ($this->insertURL($essence, $essence_id, $keyword, $test_mode)) {
			return $keyword;
		} else {
			return false;
		}
	}

	public function getURL($essence, $essence_id, $test_mode = false) {
		$sql = "SELECT `keyword` FROM `" . DB_PREFIX . "url_alias` WHERE `query` = '" . $this->db->escape($essence) . "_id=" . (int) $essence_id . "'";

		hpm_log($test_mode, $sql, 'getURL() $sql');

		$res = $this->db->query($sql);

		if (isset($res->row['keyword'])) {
			return $res->row['keyword'];
		} else {
			return false;
		}
	}

	public function getUniqueUrl($url, $test_mode = false) {
		$valid = false;

		$i = 0;
		while (false === $valid) {
			$unique_url	 = $url;
			if ($i > 0)
				$unique_url	 .= "-$i";

			$sql = "SELECT `url_alias_id` FROM `" . DB_PREFIX . "url_alias` WHERE `keyword`='" . $this->db->escape($unique_url) . "'";

			hpm_log($test_mode, $sql, 'getUniqueUrl() : $sql');

			$check_url = $this->db->query($sql);

			if (0 == $check_url->num_rows) {
				$valid = true;
			}

			$i++;
		}

		return $unique_url;
	}

	private function getEssenceName($essence, $primary_key, $essence_id, $setting, $test_mode = false) {

    $column_name = 'name';

    // Warning I (!)
    if ('information' == $essence) {
      $column_name = 'title';
    }

    if ('manufacturer' == $essence) {
      return $this->getManufacturerNameById($essence_id, $setting, $test_mode);
    }

    $sql = "SELECT `$column_name` FROM `" . DB_PREFIX . $essence . "_description` WHERE `" . $primary_key . "` = '" . (int)$essence_id . "' AND `language_id` = '" . (int)$setting['language_id'] . "'";

    if ($test_mode) {
      file_put_contents(
        $this->request->server['DOCUMENT_ROOT'] . "/handy_product_manager.log", date("Y-m-d H:i:s") . " : " . PHP_EOL
        . "getEssenceName() \$sql = $sql" . PHP_EOL
        . "------------------------------------------" . PHP_EOL . PHP_EOL, 	FILE_APPEND | LOCK_EX
      );
    }

    $query = $this->db->query($sql);

    if($query) {
      return $query->row[$column_name]; // Warning I (!)
    } else {
      return false;
    }
  }


  private function insertURL($essence, $essence_id, $keyword, $test_mode = false) {
    $sql = "INSERT INTO `" . DB_PREFIX . "url_alias` SET `query` = '" . $this->db->escape($essence) . "_id=" . (int)$essence_id . "', `keyword` = '" . $this->db->escape($keyword) . "'";

    if ($test_mode) {
      file_put_contents(
        $this->request->server['DOCUMENT_ROOT'] . "/handy_product_manager.log", date("Y-m-d H:i:s") . " : " . PHP_EOL
        . "insertURL() \$sql = $sql" . PHP_EOL
        . "------------------------------------------" . PHP_EOL . PHP_EOL, 	FILE_APPEND | LOCK_EX
      );
    }

    $query = $this->db->query($sql);

    $res = $this->db->getLastId();

    if ($res > 0) {
      return true;
    }
  }

}
