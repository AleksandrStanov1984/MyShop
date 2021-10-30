<?php
/** Include config file */
require_once dirname(__FILE__) . '/../../config.php';

$connect = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$connect->query("SET NAMES 'utf8'"); 
$connect->query("SET CHARACTER SET 'utf8'");
$connect->query("SET SESSION collation_connection = 'utf8_general_ci'");

if (!$connect) {
    echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
    echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

?>