<?php
class ModelDesignLayout extends Model {
	public function getLayout($route) {

	    // < sha_layouts_type
        if($this->mobiledetectopencart->isMobile()) {
            // type 0-desktop, 1-mobile, 2-?
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_route_type WHERE '" . $this->db->escape($route) . "' LIKE route AND store_id = '" . (int)$this->config->get('config_store_id') . "' AND layout_type = '1' ORDER BY route DESC LIMIT 1");


		// SEO CMS code
        if (isset($query->row['layout_id'])) {
        	if ($this->registry->get('seocmslib')) {
        		$query->row['layout_id'] = $this->seocmslib->sc_getLayout($query->row['layout_id']);
        	}
        }
		// End of SEO CMS code

            if ($query->num_rows) {
                return $query->row['layout_id'];
            }
        }
        // >
					
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_route WHERE '" . $this->db->escape($route) . "' LIKE route AND store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY route DESC LIMIT 1");


		// SEO CMS code
        if (isset($query->row['layout_id'])) {
        	if ($this->registry->get('seocmslib')) {
        		$query->row['layout_id'] = $this->seocmslib->sc_getLayout($query->row['layout_id']);
        	}
        }
		// End of SEO CMS code

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}
	
	public function getLayoutModules($layout_id, $position) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "layout_module WHERE layout_id = '" . (int)$layout_id . "' AND position = '" . $this->db->escape($position) . "' ORDER BY sort_order");
		

		// SEO CMS code
        if (isset($layout_id) && isset($position)) {
       		if ($this->registry->get('seocmslib')) {
       			$query->rows = $this->seocmslib->sc_getLayoutModules($layout_id, $position, $query->rows);
       		}
        }
		// End of SEO CMS code

		return $query->rows;
	}
}