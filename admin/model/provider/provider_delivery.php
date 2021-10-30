<?php
class ModelProviderProviderDelivery extends Model {
	public function addDeliveryProveder($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "provider_delivery SET 
		product_id = '" . (int)$data['product_id']  . "',
		id_provider = '" . (int)$data['id_provider']  . "',
		id_shiping = '" . (int)$data['id_shiping']  . "',
		status = '" . (int)$data['status']  . "',
		status_ship = '" . (int)$data['status_ship']  . "',
		day_delivery = '" . (int)$data['day_delivery']  . "',
		time_delivery = '" . (int)$data['time_delivery']  . "',
		weekend = '" . (int)$data['weekend']  . "',
		day = '" . (int)$data['day']  . "',
		price = '" . $this->db->escape($data['price'])  . "',
		date = NOW()");

        $id = $this->db->getLastId();

        if(!empty($data['city_delivery'])) {
            $city = implode(",", $data['city_delivery']);

            $this->db->query("UPDATE " . DB_PREFIX . "provider_delivery SET 
		       city = '" . $this->db->escape($city) . "' 
	 	       WHERE id = '" . (int)$id . "'");
        }

		return $id;
	}

	public function editDeliveryProveder($id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "provider_delivery SET 
		product_id = '" . (int)$data['product_id']  . "',
		id_provider = '" . (int)$data['id_provider']  . "',
		id_shiping = '" . (int)$data['id_shiping']  . "',
		status_ship = '" . (int)$data['status_ship']  . "',
		status = '" . (int)$data['status']  . "',
		day_delivery = '" . (int)$data['day_delivery']  . "',
		time_delivery = '" . (int)$data['time_delivery']  . "',
		weekend = '" . (int)$data['weekend']  . "',
		day = '" . (int)$data['day']  . "',
		price = '" . $this->db->escape($data['price'])  . "',
		date = NOW() 
		WHERE id = '" . (int)$id . "'");

        if(!empty($data['city_delivery'])) {
            $city = implode(",", $data['city_delivery']);

            $this->db->query("UPDATE " . DB_PREFIX . "provider_delivery SET 
		       city = '" . $this->db->escape($city) . "' 
	 	       WHERE id = '" . (int)$id . "'");
        }

	}

	public function deleteDeliveryProveder($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "provider_delivery WHERE id = '" . (int)$id . "'");
	}

	public function getDeliveryProveder($id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "provider_delivery WHERE id = '" . (int)$id . "'");
		return $query->row;
	}


	public function getDeliveryProveders($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "provider_delivery WHERE 1";


        if (!empty($data['filter_name_id'])) {
            $sql .= " AND product_id = '". (int)$data['filter_name_id'] . "'";
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

	public function getTotalDeliveryProveders() {

	    $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "provider_delivery WHERE 1";

        if (!empty($data['filter_name_id'])) {
            $sql .= " AND product_id = '". (int)$data['filter_name_id'] . "'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
	}

    public function getProveders(){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "provider_descrioption WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");
        return $query->rows;
    }

    public function getShippings(){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "provider_shipping_descrioption WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'");
        return $query->rows;
    }

    public function getProductName($product_id){
        $query = $this->db->query("SELECT name FROM " . DB_PREFIX . "product_description WHERE product_id = '". (int)$product_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

        if(isset($query->row['name'])){
            return $query->row['name'];
        }else{
            return false;
        }
    }

    public function getProvederName($id_provider){
        $query = $this->db->query("SELECT name FROM " . DB_PREFIX . "provider_descrioption WHERE id_provider = '". (int)$id_provider . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
        return $query->row['name'];
    }

    public function getShipName($id){
        $query = $this->db->query("SELECT name FROM " . DB_PREFIX . "provider_shipping_descrioption WHERE id = '". (int)$id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");
        return $query->row['name'];
    }

    public function getProductCity($id){
        $query = $this->db->query("SELECT city FROM " . DB_PREFIX . "provider_delivery WHERE id = '" . (int)$id . "'");
        $citys = explode(',', $query->row['city']);
        $city = array();
        for($x = 0; $x < count($citys); $x++){
            $city[] = $citys[$x];
        }
        return $city;
    }
}
