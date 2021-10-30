<?php
class ModelProviderProduct extends Model {
	public function addProductProveder($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "provider_product SET 
		 product_id            = '" . (int)$data['product_id']  . "',
         id_provider           = '" . (int)$data['id_provider']  . "',
         code_provider         = '" . $this->db->escape($data['code_provider'])  . "',
         id_provider_product   = '" . $this->db->escape($data['id_provider_product'])  . "',
         code_provider_product = '" . $this->db->escape($data['code_provider_product'])  . "',
         name_provider_product = '" . $this->db->escape($data['name_provider_product'])  . "',
         old_price_base        = '" . (float)$data['old_price_base']  . "',
         old_price_rrc         = '" . (float)$data['old_price_rrc']  . "',
         price_base            = '" . (float)$data['price_base']  . "',
         price_rrc             = '" . (float)$data['price_rrc']  . "',
         price_file            = '" . (float)$data['price_file']  . "',
         old_price_file        = '" . (float)$data['old_price_file']  . "',
         price                 = '" . (float)$data['price']  . "',
         old_price             = '" . (float)$data['old_price']  . "',
         status_price          = '" . (int)$data['status_price']  . "',
         status_n              = '" . (int)$data['status_n']  . "',
         isImport              = '" . (int)$data['isImport']  . "',
         marga                 = '" . (float)$data['marga']  . "',
         aktiv                 = '" . (int)$data['aktiv']  . "',
         date_added            = NOW(),
         date_modified         = NOW(),
         date_zakup            = '" . $this->db->escape($data['date_zakup'])  . "'");

        $id_nomer = $this->db->getLastId();

		return $id_nomer;
	}

	public function editProductProveder($id_nomer, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "provider_product SET 
		 product_id            = '" . (int)$data['product_id']  . "',
         id_provider           = '" . (int)$data['id_provider']  . "',
         code_provider         = '" . $this->db->escape($data['code_provider'])  . "',
         id_provider_product   = '" . $this->db->escape($data['id_provider_product'])  . "',
         code_provider_product = '" . $this->db->escape($data['code_provider_product'])  . "',
         name_provider_product = '" . $this->db->escape($data['name_provider_product'])  . "',
         old_price_base        = '" . (float)$data['old_price_base']  . "',
         old_price_rrc         = '" . (float)$data['old_price_rrc']  . "',
         price_base            = '" . (float)$data['price_base']  . "',
         price_rrc             = '" . (float)$data['price_rrc']  . "',
         price_file            = '" . (float)$data['price_file']  . "',
         old_price_file        = '" . (float)$data['old_price_file']  . "',
         price                 = '" . (float)$data['price']  . "',
         old_price             = '" . (float)$data['old_price']  . "',
         status_price          = '" . (int)$data['status_price']  . "',
         status_n              = '" . (int)$data['status_n']  . "',
         isImport              = '" . (int)$data['isImport']  . "',
         marga                 = '" . (float)$data['marga']  . "',
         aktiv                 = '" . (int)$data['aktiv']  . "',
         date_modified         = NOW(),
         date_zakup            = '" . $this->db->escape($data['date_zakup'])  . "'
		   WHERE id_nomer = '" . (int)$id_nomer . "'");
	}

	public function deleteProductProveder($id_nomer) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "provider_product WHERE id = '" . (int)$id_nomer . "'");
	}

	public function getProductProveder($id_nomer) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "provider_product WHERE id = '" . (int)$id_nomer . "'");
		return $query->row;
	}


	public function getProductProveders($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "provider_product WHERE 1";

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

	public function getTotalProductProveders() {

	    $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "provider_product WHERE 1";

        $query = $this->db->query($sql);

        return $query->row['total'];
	}

    public function getProveders(){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "provider_descrioption WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");
        return $query->rows;
    }

    public function getProvederName($id_provider){
        $query = $this->db->query("SELECT name FROM " . DB_PREFIX . "provider_descrioption WHERE id_provider = '". (int)$id_provider . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
        return $query->row['name'];
    }
}
