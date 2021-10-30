<?php
//// Version
//define('VERSION', '2.3.0.2.3');
//
//// Configuration
//if (is_file('config.php')) {
//    require_once('config.php');
//}
//
//// Install
//if (!defined('DIR_APPLICATION')) {
//    header('Location: ../install/index.php');
//    exit;
//}
//
//// Startup
//require_once(DIR_SYSTEM . 'startup.php');
//
//// NEON
////define('DEBUG', false);
////error_reporting(E_ALL);
////ini_set('display_errors', DEBUG ? 'On' : 'Off');
//
//start('admin');
//$cache = new Cache('database');


// Version
define('VERSION', '2.3.0.2.3');

// Configuration
if (is_file('config.php')) {
    require_once('config.php');
}

// Install
if (!defined('DIR_APPLICATION')) {
    header('Location: ../install/index.php');
    exit;
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');

start('admin');
$cache = new Cache('database');

