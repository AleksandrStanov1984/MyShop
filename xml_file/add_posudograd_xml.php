<?php
set_time_limit(0);
require_once('../config.php');
require_once(DIR_SYSTEM . 'startup.php');
        $connection = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
        $url = 'http://www.posudograd.com.ua/dropship/17749/yml';
        $id_provider = 3;
        $code_provider = 'Посуда-1';
        $koef_zag = 0;
        $obj = simplexml_load_string(file_get_contents($url));
        $array_xml = json_decode(json_encode($obj), true);

        foreach ($array_xml['shop']['offers']['offer'] as $offer) {
            $status_price = 5;
            $id_provider_product = $offer['@attributes']['id'];
            $available = $offer['@attributes']['available'];
            $code_provider_product = $offer['vendorCode'];
            $name_provider_product = $offer['name'];
            $price_base = $offer['price'] * 0.9;
            $price_rrc = $offer['price'];

            if ($available == 'true') {
                $status_price = 7;
            }

            $product = $connection->query("SELECT * FROM " . DB_PREFIX . "provider_product WHERE id_provider_product = '" . $connection->real_escape_string($id_provider_product) . "' AND id_provider = '" . (int)$id_provider . "'");

            if (!isset($product->row['id_provider_product'])) {
                $connection->query("INSERT INTO " . DB_PREFIX . "provider_product SET 
		      id_provider = '" . (int)$id_provider . "', 
		      code_provider = '" . $connection->real_escape_string($code_provider) . "', 
		      id_provider_product = '" . $connection->real_escape_string($id_provider_product) . "', 
		      code_provider_product = '" . $connection->real_escape_string($code_provider_product) . "', 
		      name_provider_product = '" . $connection->real_escape_string($name_provider_product) . "', 
		      price_base = '" . (float)$price_base . "', 
		      price_rrc = '" . (float)$price_rrc . "', 
		      status_price = '" . $status_price . "',
		      status_n = '" . $status_price . "', 
		      date_added = NOW()");
            } else {

                if ($available == 'true') {
                    $status_n = 7;
                    //if($product->row['price_base'] > ($product->row['old_price_base'] * $koef_zag) || ($product->row['old_price_base'] > $product->row['price_base'] * $koef_zag) || ($product->row['price_rrc'] > $product->row['old_price_rrc'] * $koef_zag) || ($product->row['old_price_rrc'] > $product->row['price_rrc'] * $koef_zag)){
                      //  $status_n = 5;
                    //}
                    $connection->query("UPDATE " . DB_PREFIX . "provider_product SET
		                 price_base = '" . (float)$price_base . "', 
		                 price_rrc = '" . (float)$price_rrc . "', 
		                 status_price = '7',
		                 status_n = '" . $status_n . "', 
		                 date_modified = NOW()
		                 WHERE id_provider_product = '" . $connection->real_escape_string($id_provider_product) . "' AND id_provider = '" . (int)$id_provider . "'");
                }else{
                    if($product->row['status_price'] == 7){
                        $connection->query("UPDATE " . DB_PREFIX . "provider_product SET 
		                 status_price = '5',
		                 status_n = '5', 
		                 date_modified = NOW()
		                 WHERE id_provider_product = '" . $connection->real_escape_string($id_provider_product) . "' AND id_provider = '" . (int)$id_provider . "'");
                    }
                }
            }
        }
$connection->close();