<?php

/**
 * @category   OpenCart
 * @package    Handy Product Manager
 * @copyright  © Serge Tkach, 2018, http://sergetkach.com/
 */

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

function hpm_log($test_mode = false, $data = '', $title = false) {
	if (!$test_mode) {
		return false;
	}

	$dir = str_replace('system/', '', DIR_SYSTEM);

	if (is_string($data)) {
		$str = '';

		if ($title) {
			$str = "$title : ";
		}

		$str .= $data;

		file_put_contents(
			$dir . "handy_product_manager.log", date("Y/m/d H:i:s") . ": \r\n"
			. $str
			. "\r\n------------------------------------------\r\n", FILE_APPEND | LOCK_EX
		);
	} else {
		ob_start();

		if ($title) {
			echo "$title:\r\n";
		} else {
			echo "Array\r\n";
		}

		print_r($data);
		$c = ob_get_contents();
		ob_clean();

		file_put_contents(
			$dir . "handy_product_manager.log", date("Y/m/d H:i:s") . ": \r\n"
			. "$c"
			. "\r\n------------------------------------------\r\n", FILE_APPEND | LOCK_EX
		);
	}
}

// Include different files for different PHP versions
if (version_compare(PHP_VERSION, '7.1') >= 0) {
	$php_v = '71';
} elseif (version_compare(PHP_VERSION, '5.6.0') >= 0) {
  $php_v = '56_70';
} else {
  echo "Sorry! Version for PHP below 5.6 is not supported.";
	exit;
}

$file = DIR_SYSTEM . 'library/hpm/admin/handy_product_manager_' . $php_v . '.php';

if (is_file($file)){
  require_once $file;
} else {
  echo "No file '$file'<br>";
  exit;
}
