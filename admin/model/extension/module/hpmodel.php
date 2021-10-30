<?php

class ModelExtensionModuleHpmodel extends Model {
    public function getVersion() {
        return '2.0.9';
    }

    public function addType($data) {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "hpmodel_type` SET `name` = '" . $this->db->escape($data['name']) . "', `type` = '" . $this->db->escape($data['type']) . "', `description` = '" . $this->db->escape($data['description']) . "', `status` = '" . (int)$data['status'] . "', setting = '" . $this->db->escape(json_encode($data['setting'])) . "'");

        $type_id = $this->db->getLastId();

        if (isset($data['type_store'])) {
            foreach ($data['type_store'] as $store_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "hpmodel_to_store SET type_id = '" . (int)$type_id . "', store_id = '" . (int)$store_id . "'");
            }
        }

        return $type_id;
    }

    public function editType($type_id, $data) {
        $this->db->query("UPDATE `" . DB_PREFIX . "hpmodel_type` SET `name` = '" . $this->db->escape($data['name']) . "', `type` = '" . $this->db->escape($data['type']) . "', `description` = '" . $this->db->escape($data['description']) . "', `status` = '" . (int)(isset($data['status']) ? $data['status'] : 0) . "', setting = '" . $this->db->escape(json_encode($data['setting'])) . "' WHERE id = '" . (int)$type_id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "hpmodel_to_store WHERE type_id = '" . (int)$type_id . "'");

        if (isset($data['type_store'])) {
            foreach ($data['type_store'] as $store_id) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "hpmodel_to_store SET type_id = '" . (int)$type_id . "', store_id = '" . (int)$store_id . "'");
            }
        }
    }

    public function getParents() {
        $query = $this->db->query("SELECT DISTINCT `parent_id` as id FROM `" . DB_PREFIX . "hpmodel_links`");
        return $query->rows;
    }

    public function getTypes() {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "hpmodel_type` ORDER BY id");

        $type_data = array();

        foreach ($query->rows as $type) {
            $type_data[] = array (
                'id'          => $type['id'],
                'name'        => $type['name'],
                'type'        => $type['type'],
                'description' => $type['description'],
                'status'      => $type['status'],
                'setting'     => json_decode($type['setting'], true),
            );
        }

        return $type_data;
    }

    public function getTypeStores($type_id) {
        $data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "hpmodel_to_store WHERE type_id = '" . (int)$type_id . "'");

        foreach ($query->rows as $result) {
            $data[] = $result['store_id'];
        }

        return $data;
    }

    public function deleteProduct($id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "hpmodel_product_hidden WHERE pid = '" . (int)$id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "hpmodel_links WHERE product_id = '" . (int)$id . "' OR parent_id = '" . (int)$id . "'");
    }

    public function setTypeByParent($parents) {
        $this->db->query("UPDATE " . DB_PREFIX . "hpmodel_links SET type_id = '0'");
        foreach ($parents as $parent) {
            $this->db->query("UPDATE " . DB_PREFIX . "hpmodel_links SET type_id = '" . (int)$parent['type_id'] . "' WHERE parent_id = '" . (int)$parent['parent_id'] . "'");
        }
    }

    public function setProductHidden($ids) {
        $filtered_ids = array();
        foreach ($ids as $id) {
            $filtered_ids[] = (int)$id;
        }
        $this->db->query("DELETE FROM `" . DB_PREFIX . "hpmodel_product_hidden` WHERE 1");
        if($filtered_ids) $this->db->query("INSERT INTO `" . DB_PREFIX . "hpmodel_product_hidden` (`pid`) VALUES ('". implode("'),('", $filtered_ids)."')");
    }

    public function delType($id) {
        $this->db->query("DELETE FROM `" . DB_PREFIX . "hpmodel_type` WHERE id='" . (int)$id . "'");
    }

    public function getType($id) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "hpmodel_type` WHERE id = '" . (int)$id . "'");
        $query->row['setting'] = json_decode($query->row['setting'], true);
        return $query->row;
    }

    public function getParentId($product_id) {
        $parent_id = $product_id;
        $query = $this->db->query("SELECT `parent_id` FROM `" . DB_PREFIX . "hpmodel_links` WHERE `product_id` = '" . (int)$product_id . "'");
        if ($query->row) {
            $parent_id = $query->row['parent_id'];
        }
        return $parent_id;
    }

    public function getChild($parent_id) {
        $query = $this->db->query("SELECT `product_id`, `sort`, `image` FROM `" . DB_PREFIX . "hpmodel_links` WHERE `parent_id` = '" . (int)$parent_id . "' ORDER BY sort");
        return $query->rows;
    }

    public function addLinks($parent_id, $products) {
        $this->deleteProduct($parent_id);
        foreach ($products as $product) {
            $this->deleteProduct($product['id']);
        }
        foreach ($products as $product) {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "hpmodel_links` SET `parent_id` = '" . (int)$parent_id . "', `product_id` = '" . (int)$product['id'] . "', `sort` = '" . (int)$product['sort'] . "', `image` = '" . $this->db->escape(!empty($product['image']) ? $product['image'] : '') . "'");
        }
    }

    public function checkDb() {
        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "hpmodel_links` (
            `parent_id` int(10) NOT NULL,
            `product_id` int(10) unsigned NOT NULL,
            `sort` int(10) unsigned DEFAULT NULL,
            `image` varchar(255) NOT NULL DEFAULT '',
            `type_id` int(10) NOT NULL DEFAULT '0',
            PRIMARY KEY (`parent_id`, `product_id`),
            UNIQUE (`product_id`,`parent_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
        $this->db->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "hpmodel_product_hidden` (
            `pid` int(11) NOT NULL,
            PRIMARY KEY (`pid`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
        $this->db->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "hpmodel_type` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `type` varchar(255) NOT NULL DEFAULT '',
            `setting` text NOT NULL DEFAULT '',
            `name` text,
            `description` text,
            `status` tinyint(1) DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
        $this->db->query($sql);

        $result = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "hpmodel_to_store'");
        if ($result->num_rows == 0) {
            $sql = "CREATE TABLE `" . DB_PREFIX . "hpmodel_to_store` (
                `type_id` int(11) NOT NULL,
                `store_id` int(11) NOT NULL,
                PRIMARY KEY (`type_id`,`store_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
            $this->db->query($sql);

            $stores = array(0);
            $query = $this->db->query("SELECT store_id FROM " . DB_PREFIX . "store");
            foreach ($query->rows as $store) {
                $stores[] = $store['store_id'];
            }

            $query = $this->db->query("SELECT `id` AS type_id  FROM `" . DB_PREFIX . "hpmodel_type`");
            foreach ($query->rows as $type) {
                foreach ($stores as $store_id) {
                     $this->db->query("INSERT INTO `" . DB_PREFIX . "hpmodel_to_store` SET type_id = '" . (int)$type['type_id'] . "', store_id = '" . (int)$store_id . "'");
                }
            }
        }

        $result = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "hpmodel_links` LIKE 'image'");
        if ($result->num_rows == 0) $this->db->query("ALTER TABLE `" . DB_PREFIX . "hpmodel_links` ADD COLUMN `image` varchar(255) NOT NULL DEFAULT ''");
        $result = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "hpmodel_links` LIKE 'type_id'");
        if ($result->num_rows == 0) $this->db->query("ALTER TABLE `" . DB_PREFIX . "hpmodel_links` ADD COLUMN `type_id` int(10) NOT NULL DEFAULT '0'");

        $result = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "hpmodel_type` LIKE 'type'");
        if ($result->num_rows == 0) $this->db->query("ALTER TABLE `" . DB_PREFIX . "hpmodel_type` ADD COLUMN `type`  varchar(255) NOT NULL DEFAULT ''");
        $result = $this->db->query("SHOW COLUMNS FROM `" . DB_PREFIX . "hpmodel_type` LIKE 'setting'");
        if ($result->num_rows == 0) {
            $this->db->query("ALTER TABLE `" . DB_PREFIX . "hpmodel_type` ADD COLUMN `setting` text NOT NULL DEFAULT ''");

            $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "hpmodel_type_details` ORDER BY id");
            $setting = array();
            foreach ($query->rows as $type_data) {
                $setting['category'] = explode(',', $type_data['category']);
                $setting['suppler'] = explode(',', $type_data['suppler']);
                $setting['manufacturer'] = explode(',', $type_data['manufacturer']);
                $setting['product_position'] = $type_data['product_position'];
                $setting['product_selector'] = $type_data['product_selector'];
                $setting['product_columns'] = json_decode($type_data['product_columns'], true);
                $setting['custom_css'] = $type_data['custom_css'];
                $setting['custom_js'] = $type_data['custom_js'];
                $setting['links'] = $type_data['links'];
                $setting['hidden_if_null'] = $type_data['hidden_if_null'];
                $setting['hidden_if_next'] = $type_data['hidden_if_next'];
                $setting['product_variant'] = $type_data['product_variant'];
                $setting['product_name_as_title'] = $type_data['product_name_as_title'];
                $setting['product_title'] = json_decode($type_data['product_title'], true);
                $setting['product_image_width'] = $type_data['product_image_width'];
                $setting['product_image_height'] = $type_data['product_image_height'];
                $setting['replace_image'] = $type_data['replace_image'];
                $setting['replace_desc'] = $type_data['replace_desc'];
                $setting['replace_att'] = $type_data['replace_att'];
                $setting['after_title'] = $type_data['after_title'];
                $this->db->query("UPDATE `" . DB_PREFIX . "hpmodel_type` SET `type` = '" . $this->db->escape($type_data['type']) . "', setting = '" . $this->db->escape(json_encode($setting)) . "' WHERE id = '" . (int)$type_data['id'] . "'");
            }
            $this->db->query("DROP TABLE `" . DB_PREFIX . "hpmodel_type_details`");
        }
    }
}
