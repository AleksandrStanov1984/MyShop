<?php
class ModelCatalogTag extends Model {
	public function addTag($data) {
		
		if(!isset($data['status'] )) $data['status'] = 0;
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "tag SET
						 sort_order = '" . (int)$data['sort_order'] . "',
						 view = '" . (int)$data['view'] . "',
						 status = '" . (int)$data['status'] . "',
						 date_added = NOW(),
						 date_modified =  NOW(),
						 search = '" . $this->db->escape($data['search']) . "',
						 tag = '" . $this->db->escape($data['tag']) . "',
						 code = '" . implode(' ', $data['code']) . "'
						 ");

		$tag_id = $this->db->getLastId();

		return $tag_id;
	}

	public function editTag($tag_id, $data) {
		
		if(!isset($data['status'] )) $data['status'] = 0;
		
		$this->db->query("UPDATE " . DB_PREFIX . "tag SET
								sort_order = '" . (int)$data['sort_order'] . "',
								view = '" . (int)$data['view'] . "',
								status = '" . (int)$data['status'] . "',
								date_modified =  NOW(),
								search = '" . $this->db->escape($data['search']) . "',
								tag = '" . $this->db->escape($data['tag']) . "',
								code = '" . implode(' ', $data['code']) . "'
						 WHERE tag_id = '" . (int)$tag_id . "'");

		
	}

	public function deleteTag($tag_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "tag WHERE tag_id = '" . (int)$tag_id . "'");
	}

	public function getTag($tag_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tag WHERE tag_id = '" . (int)$tag_id . "'");

		return $query->row;
	}

	public function getTags($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "tag ";

		$sort_data = array(
			'tag',
			'search',
			'view',
			'sort_order',
			'status',
			'date_added',
			'date_modified',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY tag";
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

	public function getTotalTags() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tag");

		return $query->row['total'];
	}
}
