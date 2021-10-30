<?php
class ModelProviderProviderName extends Model {
	public function addProvider($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "provider SET 
		sort_order = '" . (int)$data['sort_order'] . "'");

        $id_provider = $this->db->getLastId();

		foreach ($data['provider_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "provider_descrioption SET 
			id_provider = '" . (int)$id_provider . "', 
			language_id = '" . (int)$language_id . "', 
			name = '" . $this->db->escape($value['name']) . "'");
		}

		return $id_provider;
	}

	public function editProvider($id_provider, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "provider SET 
		sort_order = '" . (int)$data['sort_order'] . "' 
		WHERE id_provider = '" . (int)$id_provider . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "provider_descrioption WHERE id_provider = '" . (int)$id_provider . "'");

		foreach ($data['provider_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "provider_descrioption SET 
			id_provider = '" . (int)$id_provider . "', 
			language_id = '" . (int)$language_id . "', 
			name = '" . $this->db->escape($value['name']) . "'");
		}

	}

	public function deleteProvider($id_provider) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "provider WHERE id_provider = '" . (int)$id_provider . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "provider_descrioption WHERE id_provider = '" . (int)$id_provider . "'");
	}

	public function getProvider($id_provider) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "provider WHERE id_provider = '" . (int)$id_provider . "'");
		return $query->row;
	}

	public function getProviderDescriptions($id_provider) {
		$provider_description_data = array();
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "provider_descrioption WHERE id_provider = '" . (int)$id_provider . "'");
		foreach ($query->rows as $result) {
            $provider_description_data[$result['language_id']] = array(
				'name'             => $result['name']
			);
		}
		return $provider_description_data;
	}

	public function getProviders($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "manufacturer";
		$sql = "SELECT c.id_provider, md.name, c.sort_order 
          FROM " . DB_PREFIX . "provider c 
          LEFT JOIN " . DB_PREFIX . "provider_descrioption md ON (c.id_provider = md.id_provider) 
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

	public function getTotalProviders() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "provider");

		return $query->row['total'];
	}

	public function getTotalProductsByProviderId($id_provider){
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "provider_product WHERE id_provider = '" . (int)$id_provider . "'");
        return $query->row['total'];
    }
}
