<?php
//// Version
//define('VERSION', '2.3.0.2.3');
//// Configuration
//if (is_file('config.php')) {
//    require_once('config.php');
//}
//// Install
//if (!defined('DIR_APPLICATION')) {
//    header('Location: ../install/index.php');
//    exit;
//}
//// Startup
//require_once(DIR_SYSTEM . 'startup.php');
//// NEON
//define('DEBUG', false);
//function _xdd()
//{
//    if (isset($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'], ["93.170.4.10"])) {
//        print "<pre>";
//        var_dump(func_get_args());
//        exit;
//    }
//}
//error_reporting(E_ALL);
//ini_set('display_errors', DEBUG ? 'On' : 'Off');
//start('catalog');


// Version
define('VERSION', '2.3.0.2.3');
set_time_limit(0);
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
start('catalog');



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


start('catalog');

