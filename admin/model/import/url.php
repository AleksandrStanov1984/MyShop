<?php
class ModelImportUrl extends Model {
	
	public function getProdTotal() {
		$sql = "SELECT COUNT(product_id) AS total FROM " . DB_PREFIX . "product";
		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function getManufTotal() {
		$sql = "SELECT COUNT(manufacturer_id) AS total FROM " . DB_PREFIX . "manufacturer";
		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function getCategTotal() {
		$sql = "SELECT COUNT(category_id) AS total FROM " . DB_PREFIX . "category";
		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getProdUrlTotal() {
		$sql = "SELECT COUNT(query) AS total FROM " . DB_PREFIX . "url_alias WHERE `query` LIKE 'product_id=%'";
		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	public function getCategUrlTotal() {
		$sql = "SELECT COUNT(query) AS total FROM " . DB_PREFIX . "url_alias WHERE `query` LIKE 'category_id=%'";
		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	public function getManufUrlTotal() {
		$sql = "SELECT COUNT(query) AS total FROM " . DB_PREFIX . "url_alias WHERE `query` LIKE 'manufacturer_id=%'";
		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function getProdUrl() {
		$sql = "SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` LIKE 'product_id=%'";
		$query = $this->db->query($sql);

		return $query->rows;
	}
	public function getCategUrl() {
		$sql = "SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` LIKE 'category_id=%'";
		$query = $this->db->query($sql);

		return $query->rows;
	}
	public function getManufUrl() {
		$sql = "SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` LIKE 'manufacturer_id=%'";
		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	
	
	public function getProducts($data = array()) {
		$sql = "SELECT p.product_id, p.model, p.sku, pd.name, cp.path_id ";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
			}

				$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
		} else {
			$sql .= " FROM " . DB_PREFIX . "product p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$search_sql = '';
				if(is_numeric($data['filter_name'])){
					$search_sql .= " OR LCASE(p.sku) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				}else{
					//$search_sql .= " OR LCASE(p.sku) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";

					$search_sql .= " OR LCASE(pd.name) LIKE '% " . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
					$search_sql .= " OR LCASE(pd.name) LIKE '%-" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
					$search_sql .= " OR LCASE(pd.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";

					$search_sql .= " OR LCASE(pd.tag) LIKE '%;" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
					$search_sql .= " OR LCASE(pd.tag) LIKE '% " . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
					$search_sql .= " OR LCASE(pd.tag) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
				}
			
			$sql .=  " AND (" . ltrim($search_sql, ' OR').")";

		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		$sql .= " GROUP BY p.product_id";

		$sql .= " ORDER BY p.product_id";

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
}