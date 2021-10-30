<?php
class ModelExtensionShippingCourierSZ extends Model {
    function getQuote($address) {
        unset($this->session->data['shipping_order_cost']);
        unset($this->session->data['shipping_order_name']);
        $this->load->model('catalog/product');
        $cost = 0.00;
        $status = true;
        $view_ship = 1;

        $this->session->data['shipping_order_name'] ='Курьер SZ';

        foreach ($this->cart->getProducts() as $product) {
            if($product['np_sz_courier'] == ''){
                $status = false;
                $view_ship = 0;
            }else {
                $cost += $product['np_sz_courier'];
                $text = $this->currency->format($cost, $this->session->data['currency']);
            }

            $query = $this->db->query("SELECT courier FROM " . DB_PREFIX . "product WHERE product_id = '" . $product['product_id'] . "'");

            if (isset($query->row['courier'])) {
                if ($query->row['courier'] == 0) {
                    $view_ship = 0;
                }else{
                    $citys = $this->model_catalog_product->getProductCourierCity($product['product_id']);
                    if($citys) {
                        $product_citys = array();
                        foreach ($citys as $city) {
                            $product_citys[] = $city['city'];
                        }
                        if (!in_array($this->session->data['city_product'], $product_citys)) {
                            $view_ship = 0;
                        }
                    }
                }
            }
        }


        if($status){
            $quote_data['courier_sz'] = array(
                'code'         => 'courier_sz.courier_sz',
                'title'        => 'Курьер SZ',
                'cost'         => $cost,
                'tax_class_id' => 0,
                'text'         => $text
            );
            $this->session->data['shipping_order_cost'] = $cost;
        }else {
            $quote_data['courier_sz'] = array(
                'code'         => 'courier_sz.courier_sz',
                'title'        => 'Курьер SZ',
                'cost'         => 0.00,
                'tax_class_id' => 0,
                'text'         => 'По тарифам перевозчика'
            );
            $this->session->data['shipping_order_cost'] = 'По тарифам перевозчика';
        }

        if($cost == 0.00 && $status){
            $quote_data['courier_sz'] = array(
                'code'         => 'courier_sz.courier_sz',
                'title'        => 'Курьер SZ',
                'cost'         => 0.00,
                'tax_class_id' => 0,
                'text'         => 'Бесплатно'
            );
            $this->session->data['shipping_order_cost'] = 'Бесплатно';
        }


        $method_data = array(
            'code'       => 'courier_sz',
            'title'      => 'Курьер SZ',
            'quote'      => $quote_data,
            'sort_order' => $this->config->get('courier_sz_sort_order'),
            'error'      => false
        );

        if($view_ship == 1){
            return $method_data;
        }

    }

    public function getProductShip($sku){
        $query = $this->db->query("SELECT np_branch, np_courier, np_sz_courier FROM " . DB_PREFIX . "product WHERE sku = '". $sku ."'");
        return $query->row;
    }

    public function getCitySZ(){
        $cites = $this->db->query("SELECT * FROM " . DB_PREFIX . "shipping_courier_sz WHERE 1");
        return $cites->rows;
    }

}