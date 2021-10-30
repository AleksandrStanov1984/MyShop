<?php
// Site
$_['site_base']         = HTTP_SERVER;
$_['site_ssl']          = HTTPS_SERVER;

// Database
$_['db_autostart']      = true;
$_['db_type']           = DB_DRIVER; // mpdo, mssql, mysql, mysqli or postgre
$_['db_hostname']       = DB_HOSTNAME;
$_['db_username']       = DB_USERNAME;
$_['db_password']       = DB_PASSWORD;
$_['db_database']       = DB_DATABASE;
$_['db_port']           = DB_PORT;

// Session
$_['session_autostart'] = false;

// Actions
$_['action_pre_action'] = array(
    'startup/startup',
    'startup/error',
    'startup/event',
    'startup/sass',
    //'startup/login',
    //'startup/permission'
);

// Actions
$_['action_default'] = 'extension/module/import_yml/cron';

// Action Events
$_['action_event'] = array(
    'view/*/before' => 'event/theme'
);  

echo "Обновление цен и наличия прошло успешно!";