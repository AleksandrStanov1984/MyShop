<?php

class ModelImportAttribute extends Model {
	
	public function getProductIdFromSku($sku){
		$sql = "SELECT product_id FROM " . DB_PREFIX . "product WHERE sku LIKE '".$this->db->escape($sku)."'";
		$query = $this->db->query($sql);

		if($query->num_rows == 0){
			return false;
		}
		
		return $query->row['product_id'];
		
	}
	
	public function getAttributeIdOnName($name, $attribute_group_id){
		
		$res = $this->db->query("SELECT ad.attribute_id FROM " . DB_PREFIX . "attribute_description ad
									LEFT JOIN " . DB_PREFIX . "attribute a On a.attribute_id = ad.attribute_id
									WHERE LCASE(name) = '" . $this->db->escape(utf8_strtolower($name)) . "' AND
										attribute_group_id = '".$attribute_group_id."'
									LIMIT 1");
		
		if($res->num_rows > 0){
			return (int)$res->row['attribute_id'];
		}
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "attribute SET attribute_group_id = '".$attribute_group_id."', sort_order = '0'");

		$attribute_id = $this->db->getLastId();

		$language_id = 1;
		$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($name) . "'");
		$language_id = 3;
		$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($name) . "'");

		return $attribute_id;
		
	}
	
	public function getAttributeGroupIdOnName($name){
		
		$res = $this->db->query("SELECT attribute_group_id FROM " . DB_PREFIX . "attribute_group_description 
									WHERE LCASE(name) = '" . $this->db->escape(utf8_strtolower($name)) . "' LIMIT 1");
		
		if($res->num_rows > 0){
			return (int)$res->row['attribute_group_id'];
		}
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_group SET  sort_order = '0'");

		$attribute_group_id = $this->db->getLastId();

		$language_id = 1;
		$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_group_description SET attribute_group_id = '" . (int)$attribute_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($name) . "'");
		$language_id = 3;
		$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_group_description SET attribute_group_id = '" . (int)$attribute_group_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($name) . "'");

		return $attribute_group_id;
		
	}
	
	public function updateAttributeValue($attribute_id, $product_id, $rus, $ukr){
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE attribute_id = '" . (int)$attribute_id . "' AND product_id = '" . (int)$product_id . "'");
		
		$rus = trim($rus, ';');
		$ukr = trim($ukr, ';');
		
		if($rus != ''){
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET
							attribute_id = '" . (int)$attribute_id . "',
							product_id = '" . (int)$product_id . "',
							language_id = '1', text = '" . $this->db->escape($rus) . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET
							attribute_id = '" . (int)$attribute_id . "',
							product_id = '" . (int)$product_id . "',
							language_id = '3', text = '" . $this->db->escape($ukr) . "'");
		}
	}
	
	public function getUkrAttrValue($attribute_id, $val_rus, $product_id){
		$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_value WHERE LCASE(text) = '" . $this->db->escape(utf8_strtolower($val_rus)) . "' LIMIT 1");
	
	
		if($res->num_rows == 0){
			return $val_rus;
		}
		
		$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_value WHERE
								value_key = '" . $this->db->escape($res->row['value_key']) . "' AND
								text <> '' AND
								language_id = '3' LIMIT 1");
		
		if($res->num_rows == 0){
			
			$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE
								product_id='".(int)$product_id."' AND
								attribute_id='".(int)$attribute_id."' AND
								language_id = '3' LIMIT 1");
	
			if($res->num_rows == 0){	
				return $val_rus;
			}
		}
		
		return $res->row['text'];
		
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

		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)
			WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ";

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