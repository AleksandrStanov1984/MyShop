<?php
//служебные не удалять должны быть во всех файлах
define('VERSION', '2.3.0.2.3');

if (is_file('config.php')) {
	require_once('config.php');
}
require_once(DIR_SYSTEM . 'startup.php');
//служебные не удалять должны быть во всех файлах

//файл который будет
$file_name = 'posudograd.xml';
//файл который будет
//url  по которому получаем данные
$url = 'http://www.posudograd.com.ua/dropship/17749/yml';
//url  по которому получаем данные
//сохраняем файл у себя
file_put_contents('xml_file/' . $file_name, file_get_contents($url));
//сохраняем файл у себя

$dom_xml = new SimpleXMLElement(file_get_contents($url));
foreach ($$dom_xml->offers as $offer){
}


