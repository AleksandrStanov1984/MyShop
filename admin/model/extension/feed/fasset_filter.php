<?php
class ModelExtensionFeedFassetFilter extends Model {

    public function getFilters($category_id) {

    	$data = array();
    	$query = $this->db->query("SELECT ood.name, oo.sort_order FROM `" . DB_PREFIX . "ocfilter_option_to_category` oo2c INNER JOIN `" . DB_PREFIX . "ocfilter_option_description` ood ON(oo2c.option_id = ood.option_id) INNER JOIN `" . DB_PREFIX . "ocfilter_option` oo ON(oo.option_id = oo2c.option_id) WHERE ood.language_id = '1' AND oo2c.category_id = '".(int)$category_id."'");

    	foreach($query->rows as $row) {
    		$data[$row['name']] = $row['sort_order'];
    	}

			return $data;
    }

}
