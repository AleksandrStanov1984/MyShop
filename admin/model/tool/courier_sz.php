<?php
class ModelToolCouriersz extends Model {

    public function getCitesCouriersz() {
        $cites = $this->db->query("SELECT * FROM " . DB_PREFIX . "shipping_courier_sz WHERE 1");
        return $cites->rows;
    }

    public function addCiteCouriersz($data){
        if(isset($data['courier_sz_product_city'])){
            $this->db->query("DELETE FROM " . DB_PREFIX . "shipping_courier_sz WHERE 1");
            foreach ($data['courier_sz_product_city'] as $courier_sz_product_city) {
                $this->db->query("INSERT INTO " . DB_PREFIX . "shipping_courier_sz SET 
                 name = '" . $this->db->escape($courier_sz_product_city) . "'");
            }
        }
    }
}
