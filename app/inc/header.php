<?php 
$callStartTimeTotal = microtime(true);
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

/** Include PHPSpreadSheet */
require_once $file_path . '../system/PHPSpreadSheet_1.7/vendor/autoload.php';
/** Include db_connect */
require_once $file_path . 'inc/db_connect.php';
//echo date('H:i:s') , " Соединение с MySQL установлено!" . EOL;
/** Include functions */
require_once $file_path . 'inc/functions.php';

?>