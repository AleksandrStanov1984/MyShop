<?php 

require_once dirname(__FILE__) . '/../config.php';


$file_path = dirname(__FILE__).'/';

// подключаем шапку обработчика
include $file_path . 'inc/header.php';

// подключаем конвертер
include $file_path . 'inc/converter.php';

// подключаем футер обработчика
include $file_path . 'inc/footer.php';