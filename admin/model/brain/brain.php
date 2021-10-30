<?php

class ModelBrainBrain extends Model{

    public function delete_product_price(){
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_price WHERE 1");
    }

    public function getSearchProduct($sku){
        $result_product = $this->db->query("SELECT product_id, price, price_rrc, price_base FROM " . DB_PREFIX . "product WHERE sku = '" . $sku . "'");
        return $result_product->row;
    }

    public function addProductPrice($product_id, $sku, $price_1_file, $price_2_file, $stock_status_id, $price_base, $price_rrc, $price_1, $price_2, $price, $special){
        $this->db->query("INSERT INTO  " . DB_PREFIX . "product_price SET 
                            product_id = '" . (int)$product_id . "',
                            sku = '" . $sku . "',
                            price_1_file = '" . $price_1_file . "',
                            price_2_file = '" . $price_2_file . "',
                            stock_status_id = '" .(int)$stock_status_id ."',
                            price_base   = '" . (float)$price_base . "',
                            price_rrc   = '" . (float)$price_rrc . "',
                            price_1    = '" . (float)$price_1 . "',
                            price_2    = '" . (float)$price_2 . "',
                            price    = '" . (float)$price . "',
                            special    = '" . (float)$special . "'");
    }

    public function getUpdateProductStatus($sku){
        $this->db->query("UPDATE " . DB_PREFIX . "product SET
						status_api_brain = '0'
						WHERE sku = '" . $sku . "'");
    }

    public function getProductPrisecs($data = array()) {
        $sql = "SELECT * from " . DB_PREFIX . "product_price WHERE 1";

        if (isset($data['filter_product_id'])) {
            $sql .= " AND product_id = '" . (int)$data['filter_product_id'] . "'";
        }

        if (isset($data['filter_sku'])) {
            $sql .= " AND sku = '" . $data['filter_sku'] . "'";
        }

        $sql .= " ORDER BY product_id";
        $sql .= " ASC";


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

    public function getProductPrice($id){
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_price WHERE id = '". (int)$id  ."'");
        return $query->row;
    }


    public function getTotalProductPrisecs(){
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_price WHERE 1");
        return $query->row['total'];
    }

    public function deleteProductPrice($id){
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_price WHERE id = '".  (int)$id  ."'");
    }

    public function editProductPrice($id, $data){
        $this->db->query("UPDATE  " . DB_PREFIX . "product_price SET 
                            price_1_file = '" . $data['price_1_file'] . "',
                            price_2_file = '" . $data['price_2_file'] . "',
                            price_base   = '" . (float)$data['price_base'] . "',
                            price_rrc   = '" . (float)$data['price_rrc'] . "',
                            price_1    = '" . (float)$data['price_1'] . "',
                            price_2    = '" . (float)$data['price_2'] . "',
                            price    = '" . (float)$data['price'] . "',
                            special    = '" . (float)$data['special'] . "'
                            WHERE id = '". (int)$id."'");
    }

    public function getSelectSpecial(){
        $query = $this->db->query("SELECT product_id, special FROM " . DB_PREFIX . "product_price WHERE special != '0.0000'");
        return $query->rows;
    }

    public function getSearchSpecialProduct($product_id){
        $query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
        if(isset($query->row['product_id'])) {
            return $query->row['product_id'];
        }else{
            return false;
        }
    }

    public function getUpdateSpecialProduct($product_id, $special){
        $this->db->query("UPDATE " . DB_PREFIX . "product_special SET 
						price = '" . (float)$special . "'
						WHERE `product_id` = '" . (int)$product_id . "'");
    }

    public function getAddSpecialProduct($product_id, $special){
        $this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET 
                      product_id = '" . (int)$product_id . "', 
                      customer_group_id = '1', 
                      priority = '100', 
                      price = '" . (float)$special . "', 
                      date_start = '0000-00-00', 
                      date_end = '0000-00-00'");

    }

    public function deleteSpecial($product_id){
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id ='" . (int)$product_id . "'");
    }

    public function getProductPrices(){
        $query =  $this->db->query("SELECT product_id, price, stock_status_id FROM " . DB_PREFIX . "product_price WHERE price != '0.0000'");
        return $query->rows;
    }
    public function getUpdateProductPrices($product_id, $price, $stock_status_id){
        $this->db->query("UPDATE " . DB_PREFIX . "product SET 
						price = '" . (float)$price . "'
						WHERE product_id = '" . (int)$product_id . "'");

        if($stock_status_id != 0){
            $this->db->query("UPDATE " . DB_PREFIX . "product SET 
						stock_status_id = '" . (int)$stock_status_id . "'
						WHERE product_id = '" . (int)$product_id . "'");
        }
    }

    public function getSelectSpecialVse(){
        $query =  $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE brain_id != '0'");
        return $query->rows;
    }

    public function getProductPricesOld(){
        $query =  $this->db->query("SELECT product_id, price_rrc FROM " . DB_PREFIX . "product_price WHERE price != '0.0000'");
        return $query->rows;
    }

    public function getRestPrice(){
        $this->db->query("UPDATE " . DB_PREFIX . "product_price SET 
                            stock_status_id  = '',
                            price_base = '',
                            price_rrc  = '',
                            price_1    = '',
                            price_2    = '',
                            price      = '',
                            special    = ''
                            WHERE 1 ");
    }

    public function getPriceProduct(){
        $query =  $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product_price WHERE 1");
        return $query->rows;
    }

    public function getPriceProductUpdate($product_id){
        $result_product = $this->db->query("SELECT price, price_rrc, price_base FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
        if(isset($result_product)) {
            $this->db->query("UPDATE  " . DB_PREFIX . "product_price SET 
                            price_base   = '" . (float)$result_product->row['price_base'] . "',
                            price_rrc   = '" . (float)$result_product->row['price_rrc'] . "'
                            WHERE product_id = '" . (int)$product_id . "'");
        }
    }

    public function getSearch($product_id){
        $result_product = $this->db->query("SELECT product_id, price_1_file, price_2_file, price_rrc, price_base FROM " . DB_PREFIX . "product_price WHERE product_id = '" . (int)$product_id . "'");
        return $result_product->row;
    }

    public function updProductPrice($product_id, $stock_status_id, $price_1, $price_2, $price, $special){
        $this->db->query("UPDATE " . DB_PREFIX . "product_price SET
                            stock_status_id  = '" . (int)$stock_status_id . "',
                            price_1 = '" . (float)$price_1 . "',
                            price_2 = '" . (float)$price_2 . "',
                            price = '" . (float)$price . "',
                            special = '" . (float)$special . "'
                            WHERE  product_id = '" . (int)$product_id . "'");
    }

    public function getDeleteVse(){
        $this->db->query("DELETE FROM " . DB_PREFIX . "product_weight_volume WHERE 1");
    }

    public function getVse(){
        $query =  $this->db->query("SELECT brain_id,sku FROM " . DB_PREFIX . "product WHERE brain_id != '0'");
        return $query->rows;
    }

    public function addProductVW($sku, $volume, $weight){
        $this->db->query("INSERT INTO " . DB_PREFIX . "product_weight_volume SET 
                      sku = '" . $sku . "', 
                      volume = '". $volume . "', 
                      weight =  '". $weight ."'");
    }
}
