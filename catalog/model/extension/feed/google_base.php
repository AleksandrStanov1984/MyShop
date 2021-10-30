<?php

class ModelExtensionFeedGoogleBase extends Model
{
    public function getCategories()
    {
        $query = $this->db->query("SELECT google_base_category_id, (SELECT name FROM `" . DB_PREFIX . "google_base_category` gbc WHERE gbc.google_base_category_id = gbc2c.google_base_category_id) AS google_base_category, category_id, (SELECT name FROM `" . DB_PREFIX . "category_description` cd WHERE cd.category_id = gbc2c.category_id AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS category FROM `" . DB_PREFIX . "google_base_category_to_category` gbc2c ORDER BY google_base_category ASC");

        return $query->rows;
    }

    public function getTotalCategories()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "google_base_category_to_category`");

        return $query->row['total'];
    }

    public function getCategoriesSZ()
    {
        $query = $this->db->query("SELECT google_base_category_id, category_id, (SELECT name FROM `" . DB_PREFIX . "category_description` cd WHERE cd.category_id = gbc2c.google_base_category_id AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS category FROM `" . DB_PREFIX . "google_base_category_to_category_sz` gbc2c");

        return $query->rows;
    }

    public function getTotalCategoriesSZ()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "google_base_category_to_category`");

        return $query->row['total'];
    }

    public function getProductGoogleBaseProduct($product_id)
    {

        $sql = "SELECT sku, mpn, quantity, price, tax_class_id, model, image, manufacturer_id
        FROM " . DB_PREFIX . "product  
        WHERE product_id = '" . (int)$product_id . "' AND status = '1'";

        $query = $this->db->query($sql);

        if ($query->num_rows) {
            return array(
                'model' => $query->row['model'],
                'sku' => $query->row['sku'],
                'mpn' => $query->row['mpn'],
                'quantity' => $query->row['quantity'],
                'image' => $query->row['image'],
                'price' => $query->row['price'],
                'tax_class_id' => $query->row['tax_class_id'],
                'manufacturer_id' => $query->row['manufacturer_id']
            );
        } else {
            return false;
        }
    }

    public function getProductsGoogleBase($data = array())
    {
        $sql = "SELECT p.product_id";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
            } else {
                $sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
            }
            $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
        } else {
            $sql .= " FROM " . DB_PREFIX . "product p";
        }

        $sql .= " WHERE p.status = '1'";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
            } else {
                $sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
            }
        }

        $product_data = array();
        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $product_data[] = $result['product_id'];
        }

        return $product_data;
    }

    public function getProductGoogleBaseProductName($product_id)
    {
        $sql = "SELECT name, description FROM " . DB_PREFIX . "product_description 
        WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'";
        $query = $this->db->query($sql);
        return $query->row;
    }

    public function getProductsGoogleBaseManufacturer($manufacturer_id)
    {
        $sql = "SELECT name FROM " . DB_PREFIX . "manufacturer_description
        WHERE manufacturer_id = '" . (int)$manufacturer_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'";
        $query = $this->db->query($sql);
        return $query->row;
    }

    public function getProductsGoogleBaseSpecial($product_id)
    {
//        $sql = "SELECT price FROM " . DB_PREFIX . "product_special  WHERE product_id = '" . (int)$product_id . "'
//        AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'
//        AND ((date_start = '0000-00-00' OR date_start < NOW())
//        AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1";

        $sql = "SELECT price FROM " . DB_PREFIX . "product_special  WHERE product_id = '" . (int)$product_id . "' 
        AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' 
        ORDER BY priority ASC, price ASC LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row;
    }

}
