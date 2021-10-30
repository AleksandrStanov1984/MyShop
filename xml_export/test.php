<?php
$filepath =  __DIR__.'/rozetka.xml';
$filename = 'rozetka.xml';

// Читаем содержимое всех файло в папке xml_export/marge

$dir = __DIR__.'/marge_rozetka';

$files = scandir($dir);

foreach($files as $file) {

	if(stristr($file, '.xml') !== FALSE) {
		
		$get_file = file_get_contents('marge_rozetka/'.$file);

		if($get_file != FALSE && $get_file != '0') {
			if(!file_put_contents($filepath, $get_file, FILE_APPEND)) echo "Ошибка склеивания файлов"; 
			unlink($get_file);
		}
		
	}
}