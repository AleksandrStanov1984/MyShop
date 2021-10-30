<?php
class ModelImportXml extends Model {

    public function getSelectProviderProduct($id_provider, $id_provider_product){
        $product = $this->db->query("SELECT * FROM " . DB_PREFIX . "provider_product WHERE 
        id_provider_product = '" . $this->db->escape($id_provider_product) . "' 
        AND id_provider = '" . (int)$id_provider . "'");
        if($product->num_rows){
            return $product->row;
        }else {
            return false;
        }
    }

    public function addProviderProduct($id_provider, $code_provider, $id_provider_product, $code_provider_product, $name_provider_product, $price_base, $price_rrc, $status_price){
        $this->db->query("INSERT INTO " . DB_PREFIX . "provider_product SET 
		                  id_provider = '" . (int)$id_provider . "', 
		                  code_provider = '" . $this->db->escape($code_provider) . "', 
		                  id_provider_product = '" . $this->db->escape($id_provider_product) . "', 
		                  code_provider_product = '" . $this->db->escape($code_provider_product) . "', 
		                  name_provider_product = '" . $this->db->escape($name_provider_product) . "', 
		                  price_base = '" . (float)$price_base . "', 
		                  price_rrc = '" . (float)$price_rrc . "', 
		                  status_price = '" . $status_price . "',
		                  status_n = '" . $status_price . "', 
		                  date_added = NOW()");
    }

    public function UpdateProviderProduct($price_base, $price_rrc, $status_n, $id_provider_product, $id_provider){
        $this->db->query("UPDATE " . DB_PREFIX . "provider_product SET
		                 price_base = '" . (float)$price_base . "', 
		                 price_rrc = '" . (float)$price_rrc . "', 
		                 status_price = '7',
		                 status_n = '" . $status_n . "', 
		                 date_modified = NOW()
		                 WHERE id_provider_product = '" . $this->db->escape($id_provider_product) . "' AND id_provider = '" . (int)$id_provider . "'");
    }

    public function UpdateProviderProductStatus($id_provider_product, $id_provider){
        $this->db->query("UPDATE " . DB_PREFIX . "provider_product SET 
		                 status_price = '5',
		                 status_n = '5', 
		                 date_modified = NOW()
		                 WHERE id_provider_product = '" . $this->db->escape($id_provider_product) . "' AND id_provider = '" . (int)$id_provider . "'");
    }

}