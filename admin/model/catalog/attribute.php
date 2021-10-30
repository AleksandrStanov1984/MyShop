<?php

class ModelCatalogAttribute extends Model
{

    public function groupAttribute($main_attribute_id, $attr_list_for_del)
    {

        $sql = "SELECT * FROM " . DB_PREFIX . "product_attribute
				WHERE attribute_id IN(" . implode(',', $attr_list_for_del) . "," . $main_attribute_id . ")";

        $res = $this->db->query($sql);

        $insert = array();
        foreach ($res->rows as $row) {
            if (isset($insert[$row['product_id']][$row['language_id']])) {
                $insert[$row['product_id']][$row['language_id']] .= ';' . rtrim($row['text'], ';');
            } else {
                $insert[$row['product_id']][$row['language_id']] = rtrim($row['text'], ';');
            }
        }

        $sql = "DELETE FROM " . DB_PREFIX . "product_attribute
				WHERE attribute_id IN(" . implode(',', $attr_list_for_del) . "," . $main_attribute_id . ")";
        $this->db->query($sql);

        foreach ($insert as $product_id => $rows) {
            foreach ($rows as $language_id => $text) {
                $sql = "INSERT INTO " . DB_PREFIX . "product_attribute SET
							product_id = '" . (int)$product_id . "',
							attribute_id = '" . (int)$main_attribute_id . "',
							language_id = '" . (int)$language_id . "',
							text = '" . $this->db->escape($text) . "'";
                $this->db->query($sql);
            }
        }

    }

    public function addAttribute($data)
    {
        $this->db->query("INSERT INTO " . DB_PREFIX . "attribute SET attribute_group_id = '" . (int)$data['attribute_group_id'] . "', sort_order = '" . (int)$data['sort_order'] . "'");

        $attribute_id = $this->db->getLastId();

        foreach ($data['attribute_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
        }

        return $attribute_id;
    }

    public function editAttribute($attribute_id, $data)
    {

        $this->db->query("UPDATE " . DB_PREFIX . "attribute SET attribute_group_id = '" . (int)$data['attribute_group_id'] . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE attribute_id = '" . (int)$attribute_id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . (int)$attribute_id . "'");

        foreach ($data['attribute_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
        }

        // ===========================================
        $data['limit'] = 100;
        //$data['product_slice'] = 0;

        $sql = "SELECT count(product_id) total FROM " . DB_PREFIX . "product_attribute WHERE attribute_id = '" . (int)$attribute_id . "'";
        $total = $this->db->query($sql); //


        $sql = "SELECT distinct product_id
									 FROM " . DB_PREFIX . "product_attribute
									 WHERE attribute_id = '" . (int)$attribute_id . "'
									 ORDER BY product_id ASC ";
        if (isset($data['product_slice'])) {

        }
        if (isset($data['product_slice'])) {
            if ($data['product_slice'] < 0) {
                $data['product_slice'] = 0;
            }
            $sql .= " LIMIT " . ((int)$data['product_slice'] * (int)$data['limit']) . "," . (int)$data['limit'];
        }

        $sql2 = $sql;

        //Если это первая перезапись - обновим таблицу значений
        if ($data['product_slice'] == 0) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "attribute_value WHERE attribute_id = '" . (int)$attribute_id . "'");
            foreach ($data['attribute_value'] as $key => $values) {
                foreach ($values as $language_id => $text) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "attribute_value SET
										attribute_id = '" . (int)$attribute_id . "',
										language_id = '" . (int)$language_id . "',
										`text` = '" . $this->db->escape($text) . "',
										`value_key` = '" . $this->db->escape($key) . "'
										ON DUPLICATE KEY UPDATE `text` = '" . $this->db->escape($text) . "'
										");
                }
            }
        }


        $products = $this->db->query($sql); //

        foreach ($products->rows as $product) {
            $attribute_description = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product['product_id'] . "' AND attribute_id = '" . (int)$attribute_id . "' ORDER BY language_id");

            $sort = array();
            $product_attribute_data = array();

            foreach ($attribute_description->rows as $rows) {
                $rows2 = explode(';', $rows['text']);
                foreach ($rows2 as $row) {
                    if ($rows['language_id'] == 1) {
                        $key = $row;
                        $sort[$row] = md5($key);
                    }
                    $product_attribute_data[md5($key)][$rows['language_id']] = $row;
                }
            }

            $for_product = array();
            //Проведем замену параметров
            foreach ($product_attribute_data as $index => $row) {
                if (isset($data['attribute_value'][$index]) and trim($data['attribute_value'][$index][1]) != '') {
                    $for_product[$index] = $data['attribute_value'][$index];
                }
            }


            //Пересобирем массив с индексом языка
            $for_write = array();
            foreach ($for_product as $index => $rows) {
                foreach ($rows as $language_id => $row) {
                    $row = trim($row);
                    $for_write[$language_id][$row] = $row;
                }
            }

            //Пишем товару новое значение
            $sql = "DELETE FROM " . DB_PREFIX . "product_attribute WHERE attribute_id = '" . (int)$attribute_id . "' AND product_id = '" . (int)$product['product_id'] . "'";
            //echo '<br>'.$sql;
            $this->db->query($sql);

            foreach ($for_write as $language_id => $row) {
                $sql = "INSERT INTO " . DB_PREFIX . "product_attribute SET
							product_id = '" . (int)$product['product_id'] . "',
							attribute_id = '" . (int)$attribute_id . "',
							language_id = '" . (int)$language_id . "',
							text = '" . $this->db->escape(implode(';', $row)) . "'";
                $this->db->query($sql);
            }

        }


        return array('total' => (int)$total->row['total'],
            'sql' => $sql2,
            'slice' => $data['product_slice'] + 1,
            'END' => (($data['product_slice'] * (int)$data['limit']) > (int)$total->row['total']) ? 'END' : (($data['product_slice'] + 1) * (int)$data['limit']),
        );
    }

    public function deleteAttributeValues($attribute_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "attribute_value WHERE attribute_id = '" . (int)$attribute_id . "'");
    }

    public function deleteAttributeProductValues($attribute_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE attribute_id = '" . (int)$attribute_id . "'");
    }

    public function updateAttributeValues($attribute_id, $data)
    {

        $this->deleteAttributeValues($attribute_id);

        foreach ($data as $key => $values) {
            foreach ($values as $language_id => $text) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "attribute_value SET
									attribute_id = '" . (int)$attribute_id . "',
									language_id = '" . (int)$language_id . "',
									`text` = '" . $this->db->escape($text) . "',
									`value_key` = '" . $this->db->escape($key) . "'
									ON DUPLICATE KEY UPDATE `text` = '" . $this->db->escape($text) . "'
									");
            }
        }
    }


    public function getAttributeValues($attribute_id, $name = '')
    {
        $sql = "SELECT value_key FROM " . DB_PREFIX . "attribute_value WHERE attribute_id = '" . (int)$attribute_id . "'";

        if ($name != '') {
            $sql .= " AND LCASE(text) LIKE '%" . $this->db->escape(utf8_strtolower($name)) . "%'";
        }

        $res = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_value WHERE value_key IN (" . $sql . ") AND attribute_id = '" . (int)$attribute_id . "'
								ORDER BY language_id, `text`");
        return $res->rows;
    }

    public function getAttributeValuesTotal($attribute_id)
    {
        $sql = "SELECT COUNT(attribute_id) as total FROM " . DB_PREFIX . "attribute_value WHERE attribute_id = '" . (int)$attribute_id . "'";
        $res = $this->db->query($sql);
        return $res->row['total'];
    }

    public function deleteAttribute($attribute_id)
    {
        $this->db->query("DELETE FROM " . DB_PREFIX . "attribute WHERE attribute_id = '" . (int)$attribute_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . (int)$attribute_id . "'");
    }

    public function getAttribute($attribute_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE a.attribute_id = '" . (int)$attribute_id . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->row;
    }

    public function getAttributes($data = array())
    {
        $sql = "SELECT *, (SELECT agd.name FROM " . DB_PREFIX . "attribute_group_description agd WHERE agd.attribute_group_id = a.attribute_group_id AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS attribute_group FROM " . DB_PREFIX . "attribute a LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "'";

        if (!empty($data['filter_name'])) {

            $names = explode('&&', htmlspecialchars_decode($data['filter_name'], ENT_QUOTES));

            $sql .= " AND ( ";
            foreach ($names as $name) {
                $sql .= " LOWER(ad.name) LIKE '%" . $this->db->escape(strtolower($name)) . "%' OR";
            }
            $sql = rtrim($sql, 'OR');
            $sql .= " )";
        }

        if (!empty($data['filter_attribute_group_id'])) {
            $sql .= " AND a.attribute_group_id = '" . $this->db->escape($data['filter_attribute_group_id']) . "'";
        }

        $sort_data = array(
            'ad.name',
            'attribute_group',
            'a.sort_order'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY attribute_group, ad.name";
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

    public function getAttributeDescriptions($attribute_id)
    {
        $attribute_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . (int)$attribute_id . "'");

        foreach ($query->rows as $result) {
            $attribute_data[$result['language_id']] = array('name' => $result['name']);
        }

        return $attribute_data;
    }

    public function getTotalAttributes($data = array())
    {

        $sql = "SELECT COUNT(a.attribute_id) AS total FROM " . DB_PREFIX . "attribute a";

        if (!empty($data['filter_name'])) {
            $sql .= " LEFT JOIN  " . DB_PREFIX . "attribute_description ad ON ad.attribute_id = a.attribute_id WHERE LOWER(ad.name) LIKE '%" . $this->db->escape(strtolower($data['filter_name'])) . "%'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getTotalAttributesByAttributeGroupId($attribute_group_id)
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attribute WHERE attribute_group_id = '" . (int)$attribute_group_id . "'");

        return $query->row['total'];
    }

    public function removingNonProductSpecificAttributes(): array
    {
        $attributes_count = [];
        $attributes_all_count = $this->db->query("SELECT COUNT(attribute_id) AS total FROM " . DB_PREFIX . "attribute ");
        $attributes_in_product_count = $this->db->query("SELECT COUNT(DISTINCT attribute_id) AS total FROM " . DB_PREFIX . "product_attribute ");
        $count = 0;

        if ($attributes_all_count->row['total'] > $attributes_in_product_count->row['total']) {

            $attributes_all = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "attribute ");
            $attributes_in_product = $this->db->query("SELECT DISTINCT attribute_id FROM " . DB_PREFIX . "product_attribute ");

            $ar_prod = [];// атрибуты в подуктах
            foreach ($attributes_in_product->rows as $attribute) {
                array_push($ar_prod, $attribute['attribute_id']);
            }

            $ar_atr = [];// все атрибуты
            foreach ($attributes_all->rows as $attribute) {
                array_push($ar_atr, $attribute['attribute_id']);
            }

            foreach ($ar_atr as $attribute_id => $value) {
                if (!in_array($value, $ar_prod, true)) {
                    $this->db->query("DELETE FROM " . DB_PREFIX . "attribute_color WHERE attribute_id = '" . $value . "'");
                    $this->db->query("DELETE FROM " . DB_PREFIX . "attribute_description WHERE attribute_id = '" . $value. "'");
                    $this->db->query("DELETE FROM " . DB_PREFIX . "attribute_value WHERE attribute_id = '" . $value . "'");
                    $this->db->query("DELETE FROM " . DB_PREFIX . "attribute WHERE attribute_id = '" . $value . "'");
                    $count++;
                }
            }
        }
        $attributes_count['count_del'] = $count;
        return $attributes_count;
    }
}
