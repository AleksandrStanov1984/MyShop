<?php
set_time_limit(0);
require_once('../config.php');
require_once(DIR_SYSTEM . 'startup.php');
$connection = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
$url = 'https://afk.ua/ua/price/api/buh@sz.ua/zakupki';
$id_provider = 12;
$code_provider = 'Игрушки-2';
$koef_zag = 0;


$ch = curl_init();
curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
curl_setopt( $ch, CURLOPT_HEADER, 0 );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
$data = curl_exec( $ch );
curl_close( $ch );

$obj = simplexml_load_string($data);

$array_xml = json_decode(json_encode($obj), true);

foreach ($array_xml['items']['item'] as $offer) {
    $status_price = 5;
    $id_provider_product = $offer['@attributes']['id'];
    $available = $offer['availability_memo'];
    $code_provider_product = $offer['barcode'];
    $name_provider_product = $offer['name'];
    $price_base = $offer['price'];
    $price_rrc = $offer['msrp'];

    if ($available == 'yes') {
        $status_price = 7;
    }

    $product = $connection->query("SELECT * FROM " . DB_PREFIX . "provider_product WHERE id_provider_product = '" . $connection->real_escape_string($id_provider_product) . "' AND id_provider = '" . (int)$id_provider . "'");

    if (!isset($product->row['id_provider_product'])) {

        if(is_array($name_provider_product)){
            $name_provider_product = 'ошибка!!!';
        }

        if(is_array($code_provider_product)){
            $code_provider_product = 'ошибка!!!';
        }

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

        if ($available == 'yes') {
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
        } else {
            if ($product->row['status_price'] == 7) {
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
