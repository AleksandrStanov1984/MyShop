<?php
header("Content-Type: text/xml");
include('config.php');
//$db_host = '116.203.179.34';
//$db_database = 'admin_szmain33';
//$db_user = 'admin_uzer33sz';
//$db_pass = '4IvFFhd(.!W-';
//$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_database);
$conn = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

if (! $conn){ echo ( "Unable to connect to host!" ); exit();};



echo('<?xml version="1.0"?>');
echo("<orders_data>");

mysqli_query($conn, "SET NAMES 'utf8'");
mysqli_query($conn, "SET CHARACTER SET 'utf8'");

// ������ �� �������

if (isset($_GET['dat'])) {
	$qdate = $_GET['dat'];
} else {
	$qdate = date('Y-m-d');
}


$query = "SELECT * FROM oc_order WHERE date_added >= '" . $qdate . "' AND order_status_id > 0";

$res = mysqli_query ($conn, $query );

$ord = array();
$cus = array();

if ( $res )
{
	echo("<orders>");

	while ( $result = mysqli_fetch_array ( $res ) )
	{

		$query_ship = "SELECT shipping_order_cost FROM oc_order_shipping WHERE order_id = '" . $result['order_id'] . "'";
		$query_shipping =  mysqli_query ($conn, $query_ship );
		$shipping_order_cost = '';
		if($query_shipping){
			$row_shipping = mysqli_fetch_assoc($query_shipping);
			$shipping_order_cost = $row_shipping['shipping_order_cost'];
		}

		echo("<order>");
		echo("<order_id>".$result['order_id']."</order_id>");
		echo("<store_name>".$result['store_name']."</store_name>");
		echo("<customer_id>".$result['customer_id']."</customer_id>");
		echo("<firstname>".$result['firstname']."</firstname>");
		echo("<lastname>".$result['lastname']."</lastname>");
		echo("<email>".$result['email']."</email>");
		echo("<telephone>".$result['telephone']."</telephone>");
		echo("<referrer>".$result['utm_source']."</referrer>");
		echo("<confirm_status>".((int)$result['confirm_status']?"1":"0")."</confirm_status>");

		$shipping_codes = array('novaposhta.doors', 'courier_sz.courier_sz');

		if(in_array($result['shipping_code'], $shipping_codes)) {
			$shipping_address = $result['shipping_address_2'];
		} else {
			$shipping_address = $result['shipping_address_1'];
		}

		echo("<shipping_city>".$shipping_address."</shipping_city>");

		echo("<shipping_country>".$result['shipping_zone']."</shipping_country>");
		echo("<shipping_zone>".$result['shipping_city']."</shipping_zone>");
		echo("<shipping_method>".strip_tags($result['shipping_method'])."</shipping_method>");
		echo("<shipping_order_cost>". $shipping_order_cost ."</shipping_order_cost>");
		echo("<payment_method>".strip_tags($result['payment_method'])."</payment_method>");
		echo("<payment_code>".$result['payment_code']."</payment_code>");
		echo("<comment>".strip_tags($result['comment'])."</comment>");
		echo("<date_added>".$result['date_added']."</date_added>");
		echo("<ga_client_id>".$result['ga_client_id']."</ga_client_id>");
		echo("</order>");

		$ord[] = $result['order_id'];
		$cus[] = $result['customer_id'];

	};

	echo("</orders>");
}

// ������ �� �������

$query = "SELECT op.order_id, op.product_id, op.name, p.sku, op.quantity, op.price FROM oc_order_product op LEFT JOIN oc_product p ON(op.product_id = p.product_id) WHERE order_id IN ('" . implode("','",$ord) . "')";
$res = mysqli_query ($conn, $query );

if ( $res )
{
	echo("<products>");

	while ( $result = mysqli_fetch_array ( $res ) )
	{
		echo("<product>");
		echo("<order_id>".$result['order_id']."</order_id>");
		echo("<product_id>".$result['product_id']."</product_id>");
		echo("<name>".$result['name']."</name>");
		echo("<model>".$result['sku']."</model>");
		echo("<quantity>".$result['quantity']."</quantity>");
		echo("<price>".$result['price']."</price>");
		echo("</product>");
	};

	echo("</products>");
}

// ������ �� �����������

$query = "SELECT * FROM oc_customer WHERE customer_id IN ('" . implode("','",$cus) . "')";
$res = mysqli_query ($conn, $query );

if ( $res )
{
	echo("<customers>");

	while ( $result = mysqli_fetch_array ( $res ) )
	{
		echo("<customer>");
		echo("<customer_id>".$result['customer_id']."</customer_id>");
		echo("<firstname>".$result['firstname']."</firstname>");
		echo("<lastname>".$result['lastname']."</lastname>");
		echo("<email>".$result['email']."</email>");
		echo("<telephone>".$result['telephone']."</telephone>");
		echo("</customer>");
	};

	echo("</customers>");
}


echo("</orders_data>");

?>