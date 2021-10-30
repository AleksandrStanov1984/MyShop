<?php
class ModelProviderProviderShip extends Model {
	public function addProviderShip($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "provider_shipping SET 
		sort_order = '" . (int)$data['sort_order'] . "'");

        $id = $this->db->getLastId();

		foreach ($data['provider_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "provider_shipping_descrioption SET 
			id = '" . (int)$id . "', 
			language_id = '" . (int)$language_id . "', 
			name = '" . $this->db->escape($value['name']) . "'");
		}

		return $id;
	}

	public function editProviderShip($id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "provider_shipping SET 
		sort_order = '" . (int)$data['sort_order'] . "' 
		WHERE id = '" . (int)$id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "provider_shipping_descrioption WHERE id = '" . (int)$id . "'");

		foreach ($data['provider_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "provider_shipping_descrioption SET 
			id = '" . (int)$id . "', 
			language_id = '" . (int)$language_id . "', 
			name = '" . $this->db->escape($value['name']) . "'");
		}

	}

	public function deleteProviderShip($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "provider_shipping WHERE id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "provider_shipping_descrioption WHERE id = '" . (int)$id . "'");
	}

	public function getShipProvider($id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "provider_shipping WHERE id = '" . (int)$id . "'");
		return $query->row;
	}

	public function getShipProviderDescriptions($id) {
		$provider_description_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "provider_shipping_descrioption WHERE id = '" . (int)$id . "'");
		foreach ($query->rows as $result) {
            $provider_description_data[$result['language_id']] = array(
				'name'             => $result['name']
			);
		}
		return $provider_description_data;
	}

	public function getShipProviders($data = array()) {
		$sql = "SELECT c.id, md.name, c.sort_order 
          FROM " . DB_PREFIX . "provider_shipping c 
          LEFT JOIN " . DB_PREFIX . "provider_shipping_descrioption md ON (c.id = md.id) 
           WHERE md.language_id = '" . (int)$this->config->get('config_language_id') . "'";


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

	public function getTotalShipProviders() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "provider_shipping");

		return $query->row['total'];
	}
}
