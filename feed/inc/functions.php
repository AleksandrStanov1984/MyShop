<?php 
function clearTable() {

	$GLOBALS['connect']->query("TRUNCATE TABLE " . DB_PREFIX . "export_xml") or die('Запрос не удался: ' . mysql_error());	

}

function addRowValues($rozetka_id, $prom_id) {
	$query = $GLOBALS['connect']->query("INSERT IGNORE INTO `" . DB_PREFIX . "export_xml` (`rozetka_id`, `prom_id`) VALUES ('".$rozetka_id."', '".$prom_id."');") or die('Запрос не удался: ' . mysql_error());	
}