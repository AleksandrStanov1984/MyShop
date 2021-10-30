<?php
set_time_limit(0);
require_once('../config.php');
require_once(DIR_SYSTEM . 'startup.php');
$connection = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
$url = 'https://atlantmarket.com.ua/price1/prom/atlantmarketpromAtlant.xml';
$id_provider = 54;
$code_provider = 'Текстиль-2';
$koef_zag = 0;
$ch = curl_init();
curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
$data = curl_exec($ch);
curl_close($ch);
$obj = simplexml_load_string($data);
$array_xml = json_decode(json_encode($obj), true);

foreach ($array_xml['shop']['offers']['offer'] as $offer) {
    $status_price = 5;
    $id_provider_product = $offer['@attributes']['id'];
    if (isset($offer['@attributes']['available'])) {
        $available = $offer['@attributes']['available'];
    } else {
        $available = 'false';
    }
    $code_provider_product = $offer['@attributes']['id'];

    if (isset($offer['model'])) {
        $name_provider_product = $offer['model'];
    } else {
        $name_provider_product = '';
    }

    $price_base = $offer['price'];
    $price_rrc = $offer['price'] / 0.9;

    if ($available = 'true') {
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

        if ($available = 'true') {
            $status_n = 7;
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