<?php
class ModelExportAllFeed extends Model {
	public function getCategory($categories = '') {
		$sql = "SELECT cd.name, c.category_id, c.parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' AND c.sort_order <> '-1'";

		if(!empty($categories)) {
			$sql .= " AND c.category_id IN (".$categories.")";
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getCategoriesHotline() {

		$query = $this->db->query("SELECT DISTINCT hotline_category_id AS category_id, hotline_category_name AS name FROM `" . DB_PREFIX . "export_xml` WHERE hotline_category_id IS NOT NULL GROUP BY hotline_category_id");

		return $query->rows;
	}

	public function getProduct($out_of_stock_id, $vendor_required = true, $type) {
		$sql = "SELECT p.*, ex.*, pd.name, pd.description, m.name AS manufacturer, p2c.category_id, ps.price AS special_price, pds.price AS discount_price, pds.quantity AS discount_quantity, pd.meta_h1 FROM " . DB_PREFIX . "export_xml ex JOIN " . DB_PREFIX . "product_to_category AS p2c ON (ex.".$type."_id = p2c.product_id) JOIN " . DB_PREFIX . "product p ON (p.product_id = ex.".(string)$type."_id) " . ($vendor_required ? '' : 'LEFT ') . "JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "product_special ps ON (p.product_id = ps.product_id) AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ps.date_start < NOW() AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()) LEFT JOIN " . DB_PREFIX . "product_discount pds ON ( p.product_id = pds.product_id ) AND pds.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pds.date_start < NOW( ) AND ( pds.date_end = '0000-00-00' OR pds.date_end > NOW( ))  WHERE ex.".$type."_id > '0' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'"; 

		if($type == 'prom' || $type == 'hotline') {
			$sql .= " AND p.stock_status_id = '7'";
		} else {
			$sql .= " AND (p.quantity > '0' OR p.stock_status_id != '" . (int)$out_of_stock_id . "')";
		}

		$sql .= " GROUP BY p.product_id";

		if($separate) {
			$sql .= " LIMIT ".$offset.", ".$limit;
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getProductCategories($out_of_stock_id, $vendor_required = true, $type) {
		$categories = array();
		$sql = "SELECT p2c.category_id FROM " . DB_PREFIX . "export_xml ex JOIN " . DB_PREFIX . "product_to_category AS p2c ON (ex.".(string)$type."_id = p2c.product_id) JOIN " . DB_PREFIX . "product p ON (p.product_id = ex.".(string)$type."_id) " . ($vendor_required ? '' : 'LEFT ') . "JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p.date_available <= NOW() AND p.status = '1' AND (p.quantity > '0' OR p.stock_status_id != '" . (int)$out_of_stock_id . "')"; 

		$sql .= " GROUP BY p2c.category_id";

		$query = $this->db->query($sql);

		foreach ($query->rows as $row) {
			if($this->getParentCategory($row['category_id'])) $categories[] = $this->getParentCategory($row['category_id']);
			$categories[] = $row['category_id'];
		}

		$categories = array_unique($categories);

		return $categories;
	}
	public function getParentCategory($category_id) {
		$query = $this->db->query("SELECT cp.path_id AS category_id FROM " . DB_PREFIX . "category_path cp WHERE cp.category_id = '" . (int)$category_id . "' AND cp.level = '0'"); 
		return isset($query->row['category_id']) ? $query->row['category_id'] : false;
	}
}
?>
