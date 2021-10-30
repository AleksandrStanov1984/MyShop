<?php
class ModelExtensionFeedmultisearch extends Model {

    public function getCategories() {
        $query = $this->db->query("SELECT c.category_id, cd.name, c.parent_id  FROM " . DB_PREFIX . "category c 
		LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = c.category_id) WHERE 
         c.status = 1 AND cd.language_id = '1'");

        return $query->rows;
    }

    public function getProducts($data = array()){
        $this->db->query("UPDATE oc_product SET brend_id = manufacturer_id WHERE 1");

        $sql = "SELECT p.product_id FROM " . DB_PREFIX . "product p WHERE p.status = '1' AND p.stock_status_id = '7'";

        $product_data = array();
        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $product_data[] = $result['product_id'];
        }

        return $product_data;
    }

    public function getProductsDetails($product_id) {

        $sql = "SELECT sku, price, tax_class_id, brend_id, image
        FROM " . DB_PREFIX . "product  
        WHERE product_id = '" . (int)$product_id . "' AND status = '1' AND stock_status_id = '7'";

        $query = $this->db->query($sql);

        if ($query->num_rows) {
            return array(
                'sku'          => $query->row['sku'],
                'image'        => $query->row['image'],
                'price'        => $query->row['price'],
                'tax_class_id' => $query->row['tax_class_id'],
                'brend_id'     => $query->row['brend_id']
            );
        } else {
            return false;
        }
    }

    public function getProductCategory($product_id){
        $query = $this->db->query("SELECT category_id  FROM " . DB_PREFIX . "product_to_category  WHERE product_id = '" . (int)$product_id . "'");
        return $query->rows;
    }

    public function getProductName($product_id){
        $sql = "SELECT name FROM " . DB_PREFIX . "product_description 
        WHERE product_id = '" . (int)$product_id . "' AND language_id = '1'";
        $query = $this->db->query($sql);
        return $query->row;
    }

    public function getProductAtribute($product_id){
        $sql = "SELECT * FROM " . DB_PREFIX . "product_attribute 
        WHERE product_id = '" . (int)$product_id . "' AND language_id = '1'";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getAtribute($id){
        $sql = "SELECT name FROM " . DB_PREFIX . "attribute_description 
        WHERE attribute_id = '" . (int)$id . "' AND language_id = '1'";
        $query = $this->db->query($sql);
        return $query->row['name'];
    }

    public function getProductsBrend($id){
        $sql = "SELECT name FROM " . DB_PREFIX . "manufacturer_description 
        WHERE manufacturer_id = '" . (int)$id . "' AND language_id = '1'";
        $query = $this->db->query($sql);
        return $query->row['name'];
    }

    public function getProductsSpecial($product_id){
        $sql = "SELECT price FROM " . DB_PREFIX . "product_special  WHERE product_id = '" . (int)$product_id . "' LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row;
    }
}
