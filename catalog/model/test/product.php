<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/dump.php'); //for debug only

class ModelTestProduct extends Model
{
    public function getProductSmall($product_id)
    {
        $query = $this->db->query("SELECT DISTINCT *, cd.name AS category_name, IF(" . (int)$this->config->get('config_language_id') . " = 1, p.model, p.ukr_model) as model, pd.name AS name, p.image, p.brain_id,
		(SELECT md.name FROM " . DB_PREFIX . "manufacturer_description md WHERE md.manufacturer_id = p.manufacturer_id AND md.language_id = '" . (int)$this->config->get('config_language_id') . "') AS manufacturer,
		(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special,
		(SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') AS reward,
		(SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status,
		(SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating,
		(SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order
		FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) LEFT JOIN " . DB_PREFIX . "category c ON (c.category_id = p2c.category_id)
		LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id)
		LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
		LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)
		LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id)
		WHERE p.product_id = '" . (int)$product_id . "'
		AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'
		AND p.status = '1'
		AND p.date_available <= NOW()
		AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

        if ($query->num_rows) {
            return array(
                'product_id' => $query->row['product_id'],
                'brain_id' => $query->row['brain_id'],
                'category_id' => $query->row['category_id'],
                'category_name' => $query->row['category_name'],
                'name' => $query->row['name'],
                'description' => $query->row['description'],
                'meta_title' => $query->row['meta_title'],
                'meta_h1' => $query->row['meta_h1'],
                'meta_description' => $query->row['meta_description'],
                'meta_keyword' => $query->row['meta_keyword'],
                'tag' => $query->row['tag'],
                'model' => $query->row['model'],
                'sku' => $query->row['sku'],
                'upc' => $query->row['upc'],
                'ean' => $query->row['ean'],
                'jan' => $query->row['jan'],
                'isbn' => $query->row['isbn'],
                'mpn' => $query->row['mpn'],
                'location' => $query->row['location'],
                'video' => $query->row['video'],
                'quantity' => $query->row['quantity'],
                'stock_status_id' => $query->row['stock_status_id'],
                'stock_status' => $query->row['stock_status'],
                'image' => $query->row['image'],
                'image_dod' => $query->row['image_dod'],
                'day_delivery' => $query->row['day_delivery'],
                'manufacturer_id' => $query->row['manufacturer_id'],
                'manufacturer' => $query->row['manufacturer'],
                'price_base' => $query->row['price_base'],
                'special' => $query->row['special'],
                'reward' => $query->row['reward'],
                'points' => $query->row['points'],
                'tax_class_id' => $query->row['tax_class_id'],
                'date_available' => $query->row['date_available'],
                'weight' => $query->row['weight'],
                // 'weight_class_id' => $query->row['weight_class_id'],
                'length' => $query->row['length'],
                'width' => $query->row['width'],
                'height' => $query->row['height'],
                //  'length_class_id' => $query->row['length_class_id'],
                'diameter_of_pot' => $query->row['diameter_of_pot'],
                'depth_of_pot' => $query->row['depth_of_pot'],
                'quantity_shelves' => $query->row['quantity_shelves'],
                'maximum_weight' => $query->row['maximum_weight'],
                'maximum_weight_all' => $query->row['maximum_weight_all'],
                'subtract' => $query->row['subtract'],
                'rating' => round($query->row['rating']),
                'reviews' => $query->row['reviews'] ? $query->row['reviews'] : 0,
                'minimum' => $query->row['minimum'],
                'sort_order' => $query->row['sort_order'],
                'visible_carusel' => $query->row['visible_carusel'],
                'status' => $query->row['status'],
                'date_added' => $query->row['date_added'],
                'date_modified' => $query->row['date_modified'],
                'viewed' => $query->row['viewed'],
                'pickup' => $query->row['pickup'],
                'courier' => $query->row['courier'],
            );
        } else {
            return false;
        }
    }


}
