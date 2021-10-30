<?php

// если передан get параметр с кодом для защиты от роботов
if(isset($_GET['marge']) && $_GET['marge'] == 'Hkdhgsr735h@h!') {
	
	$filepath =  __DIR__.'/rozetka.xml';
	$filename = 'rozetka.xml';

	// Читаем содержимое всех файло в папке xml_export/marge

	$dir = __DIR__.'/marge_rozetka';

	$files = scandir($dir);

	if(count($files) > 4) {

		// перед склеиванием созраняем резервный файл
		if (file_exists($filepath)) {
			rename($filepath, 'rezerv_rozetka.xml');
		}

		foreach($files as $file) {

			if(stristr($file, '.xml') !== FALSE) {
				
				$get_file = file_get_contents('marge_rozetka/'.$file);

				if($get_file != FALSE && $get_file != '0') {
					if(!file_put_contents($filepath, $get_file, FILE_APPEND)) echo "Ошибка склеивания файлов"; 
				}

				unlink('marge_rozetka/'.$file);
				
			}
		}

		echo $filename.' успешно сохранен';

	} else {
		echo "Нет файлов для склеивания";
	}

	


	// переименовываем файл для забора розеткой
	/*if (file_exists($filepath)) {
		rename($filepath, $filename);
	}*/
	
}