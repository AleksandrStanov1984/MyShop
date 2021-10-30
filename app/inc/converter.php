<?php
if(isset($_GET['lang']) && $_GET['lang'] == 'ua') {
	$lang = 'ua';
} else {
	$lang = 'ru';
}
$inputFileName = $file_path . 'for_import.xlsx';

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$reader->setReadDataOnly(true);
$spreadsheet = $reader->load($inputFileName);
$worksheet = $spreadsheet->setActiveSheetIndex(0);

$highestRow = $worksheet->getHighestRow(); 
$highestColumn = $worksheet->getHighestDataColumn(); 

// init parametrs
$i = 6; //стартовая строка
$sku_cell = 1;
$height_cell = 2;
$width_cell = 3;
$length_cell = 4;
$qnt_shelves_cell = 5;
$thickness_cell = 6;
$weight_cell = 13;
$special_cell = 16;
$price_cell = 17;
$color_cell = 18;
$load_on_shelv_cell = 20;
$load_on_rack_cell = 21;
$name_cell = 22;
$model_cell = 23;
$seo_url_cell = 24;
$material_cell = 26;
$main_image_cell = 36;
$shelves_thickness_cell = 43;

// default values
$quantity = 1000;
$main_category = 'Стеллажи';

$data = array();

do {

	$sku = $worksheet->getCellByColumnAndRow($sku_cell, $i)->getValue();

	if(!empty($sku)) {
			$height =  $worksheet->getCellByColumnAndRow($height_cell, $i)->getValue() / 10;
			$width =  $worksheet->getCellByColumnAndRow($width_cell, $i)->getValue() / 10;
			$length =  $worksheet->getCellByColumnAndRow($length_cell, $i)->getValue() / 10;
			$qnt_shelves =  $worksheet->getCellByColumnAndRow($qnt_shelves_cell, $i)->getValue();
			$weight =  ceil($worksheet->getCellByColumnAndRow($weight_cell, $i)->getValue());

			
			if( empty($worksheet->getCellByColumnAndRow($price_cell, $i)->getValue()) ) {
				$price =  round($worksheet->getCellByColumnAndRow($special_cell, $i)->getValue());
				$special = '';
			} else {
				$price =  round($worksheet->getCellByColumnAndRow($price_cell, $i)->getValue());
				$special_price =  round($worksheet->getCellByColumnAndRow($special_cell, $i)->getValue());
				$special = '1,0,'.$special_price.',0000-00-00,0000-00-00';
			}

			$thickness =  $worksheet->getCellByColumnAndRow($thickness_cell, $i)->getValue();
			$color =  $worksheet->getCellByColumnAndRow($color_cell, $i)->getValue();
			$load_on_shelv =  $worksheet->getCellByColumnAndRow($load_on_shelv_cell, $i)->getValue();
			$load_on_rack =  $worksheet->getCellByColumnAndRow($load_on_rack_cell, $i)->getValue();
			$name =  $worksheet->getCellByColumnAndRow($name_cell, $i)->getValue();
			$model =  $worksheet->getCellByColumnAndRow($model_cell, $i)->getValue();
			$seo_url =  $worksheet->getCellByColumnAndRow($seo_url_cell, $i)->getValue();
			$material =  $worksheet->getCellByColumnAndRow($material_cell, $i)->getValue();
			$image = $worksheet->getCellByColumnAndRow($main_image_cell, $i)->getValue();

			// for description
			$diametr_metall = $worksheet->getCellByColumnAndRow(6, $i)->getValue();
			$shelves_thickness = $worksheet->getCellByColumnAndRow($shelves_thickness_cell, $i)->getValue();

			$qnt_shelves_desc = $worksheet->getCellByColumnAndRow(25, $i)->getValue();
			
			if(stristr($material, 'ДСП') !== FALSE && !empty($shelves_thickness)) {
		    $material_origin = $material.' '.$shelves_thickness.' мм';
		  } else {
		  	$material_origin = $material;
		  }

			$material_full = $qnt_shelves_desc.' '.$material;
			
			$mat_polok = $worksheet->getCellByColumnAndRow(27, $i)->getValue();
			$amplifier = $worksheet->getCellByColumnAndRow(28, $i)->getValue();
			$pokritie = $worksheet->getCellByColumnAndRow(29, $i)->getValue();
			$stoyka = $worksheet->getCellByColumnAndRow(30, $i)->getValue();
			$nakladka = $worksheet->getCellByColumnAndRow(31, $i)->getValue();
			$balka_front = $worksheet->getCellByColumnAndRow(33, $i)->getValue();
			$balka_aside = $worksheet->getCellByColumnAndRow(34, $i)->getValue();
			$usilitel = $worksheet->getCellByColumnAndRow(35, $i)->getValue();
			

			if($lang == 'ua') {

				if(stristr($material, 'метал') === FALSE) {
			    $material = 'ДСП';
			  } else {
			  	$material = 'з металу';
			  }
				
				// определяем категорию товару
				if(stristr($model, 'ХАРДІ') !== FALSE) {
			    $category = $main_category.'|'.'ХАРДІ-ПРО';
			  } else {
			  	$category = $main_category;
			  }

			  $meta_name = $name.' '.$model;

			  // meta данные 
			  $title = 'Купити '.$name.' від виробника Smart Zone. '.$model;
			  $meta_desc = 'Купити '.$meta_name.' від виробника! Smart Zone это ➦ Склад у Киеві, ✈ швидка доставка по Україні ☎(050) 300 22 77, (067) 620 88 33, (093) 170 56 88. У нас завжди $ кращі ціни, ☑ гарантія якості!';

			} else {

				if(stristr($material, 'металл') === FALSE) {
			    $material = 'ДСП';
			  } else {
			  	$material = 'металл';
			  }
				
				// определяем категорию товару
				if(stristr($model, 'ХАРДИ') !== FALSE) {
			    $category = $main_category.'|'.'ХАРДИ-ПРО';
			  } else {
			  	$category = $main_category;
			  }

			  $meta_name = $name.' '.$model;

			  // meta данные 
			  $title = 'Купить '.$name.' от производителя Smart Zone. '.$model;
			  $meta_desc = 'Купить '.$meta_name.' от производителя! Smart Zone это ➦ Склад в Киеве, ✈ быстрая доставка по Украине ☎(050) 300 22 77, (067) 620 88 33, (093) 170 56 88. У нас всегда $ лучшие цены, ☑ гарантия качества!';

			}
			

		  // получаем доп изображения
		  $images = array();
		  for ($j=37; $j <= 42; $j++) { 
		  	$add_image = $worksheet->getCellByColumnAndRow($j, $i)->getValue();
		  	if(!empty($add_image)) {

		  		if(stristr($add_image, '/') === FALSE) {
				    $add_image = 'hardipro-'.$sku.'/'.$add_image;
				  } 

		  		$images[] = $add_image;
		  	}
		  }
		  $images = implode(',', $images);

		  // формируем описание
		  $description = '';

		  if($lang == 'ua') {
			  $description .= '<p><strong>'.$model.'</strong>&nbsp; Стелаж металевий ЦИНК&nbsp;'.$material_full.'</p><p><strong>+ Кріплення для стягування стелажів між собою </strong>(при замовленні кількох штук)</p><p>&nbsp;</p><p><strong>РОЗМІР СТЕЛАЖА:</strong></p><ul> <li>Висота: '.$height.' см</li> <li>Ширина: '.$width.' см</li> <li>Глибина: '.$length.'&nbsp;см</li></ul>
				<p>&nbsp;</p><p><strong>ТОВЩИНА МЕТАЛУ:</strong></p><ul> <li>'.$diametr_metall.' мм</li></ul><p>&nbsp;</p><p><strong>НАВАНТАЖЕННЯ:</strong></p><ul> <li>до '.$load_on_shelv.'&nbsp;кг на одну полицю, до '.$load_on_rack.' кг на стелаж</li></ul><p>&nbsp;</p><p><strong>ОСОБЛИВОСТІ:</strong></p><ul> <li>Збірна конструкція на зацепах - 15-30 хв на складання</li> <li>Сталевий каркас '.$pokritie.' - захист від корозії і акуратний зовнішній вигляд</li> <li>Полиці '.$material_origin.'&nbsp;';

				if(!empty($amplifier)) $description .= $amplifier.' '.$qnt_shelves.' шт';
				
				$description .= '&nbsp;регулюються по висоті. Крок регулювання - 25мм </li></ul><p>&nbsp;</p><p><strong>ВИГОДИ І ПЕРЕВАГИ:</strong></p><ul> <li><strong>Найвища якість</strong>&nbsp;виконання всіх елементів і демократична ціна</li> <li><strong>Зручність транспортування</strong>: стелаж поміщається в багажник будь-якого легкового авто.</li> <li><strong>Захист статі</strong>: пластикові накладки на стійках бережуть покриття підлоги від пошкоджень.</li> <li><strong>Модульність і універсальність:&nbsp;</strong>оптимальний розмір і модульність конструкції дозволяють гнучко і оперативно реалізувати завдання по організації зберігання, від домашньо-побутових: будинок, балкон, гараж, дача, підвал, комора, горище тощо., до бізнесових: рядні системи зберігання товарів, створення архівного простору тощо .</li> <li><strong>Накладений платіж</strong>&nbsp;- можна оплатити при отриманні.</li> <li><strong>Гарантія</strong>&nbsp;на продукцію 24 міс</li></ul><p>&nbsp;</p><p><strong>КОМПЛЕКТАЦІЯ СТЕЛАЖА '.$model.'</strong></p><ul> <li>Стійка &ndash; '.$stoyka.'&nbsp;шт</li> <li>Пластикова накладка на стійку для захисту підлоги &ndash; '.$nakladka.' шт</li> <li>Балка фронтальна &ndash; '.$balka_front.' шт</li> <li>Балка бічна &ndash; '.$balka_aside.' шт</li>';

				if(!empty($usilitel)) $description .= '<li>Підсилювач полиць &ndash; '.$usilitel.' шт</li>';

				$description .= '<li>Полиці '.$mat_polok.' &ndash; '.$qnt_shelves.' шт</li> <li>Докладна інструкція по збірці і монтажу &ndash; 1 шт</li></ul><p><br /><strong>УПАКОВКА:</strong></p><ul> <li>Стеллаж '.$model.'&nbsp; поставляється в міцній картонній коробці, вагою '.$weight.' кг.</li></ul><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p><strong>Завжди раді допомогти, і дякуємо за вибір!</strong></p>';

			} else {
				$description .= '<p><strong>'.$model.'</strong>&nbsp; Стеллаж металлический ЦИНК&nbsp;'.$material_full.'</p><p><strong>+ Крепеж для стягивания стеллажей между собой </strong>(при заказе нескольких штук)</p><p>&nbsp;</p><p><strong>РАЗМЕР СТЕЛЛАЖА:</strong></p><ul> <li>Высота: '.$height.' см</li> <li>Ширина: '.$width.' см</li> <li>Глубина: '.$length.'&nbsp;см</li></ul>
				<p>&nbsp;</p><p><strong>ТОЛЩИНА МЕТАЛЛА:</strong></p><ul> <li>'.$diametr_metall.' мм</li></ul><p>&nbsp;</p><p><strong>НАГРУЗКА:</strong></p><ul> <li>до '.$load_on_shelv.'&nbsp;кг на одну полку, до '.$load_on_rack.' кг на стеллаж</li></ul><p>&nbsp;</p><p><strong>ОСОБЕННОСТИ:</strong></p><ul> <li>Сборная конструкция&nbsp;на зацепах&nbsp; - 15-30 мин на сборку</li> <li>Стальной каркас '.$pokritie.' - защита от коррозии и аккуратный внешний вид</li> <li>Полки '.$material_origin.'&nbsp;';

				if(!empty($amplifier)) $description .= $amplifier.' '.$qnt_shelves.' шт';
				
				$description .= '&nbsp;регулируются по высоте. Шаг регулировки - 25мм </li></ul><p>&nbsp;</p><p><strong>ВЫГОДЫ И ПРЕИМУЩЕСТВА:</strong></p><ul> <li><strong>Высочайшее качество</strong>&nbsp;исполнения всех элементов и&nbsp;демократичная&nbsp;цена</li> <li><strong>Удобство транспортировки</strong>: стеллаж помещается в багажник любого легкового авто.</li> <li><strong>Защита пола</strong>: пластиковые накладки на стойках берегут покрытие пола от повреждений.</li> <li><strong>Модульность и универсальность:&nbsp;</strong>оптимальный&nbsp;размер и модульность конструкции позволяют&nbsp;гибко и оперативно реализовать задачи по организации хранения, от домашне-бытовых: дом, балкон, гараж, дача, подвал, кладовка, чердак и пр.,&nbsp;до бизнесовых: рядные системы хранения товаров, создание архивного пространства и пр.</li> <li><strong>Наложенный платеж</strong>&nbsp;- можно оплатить при получении.</li> <li><strong>Гарантия</strong>&nbsp;на продукцию 24 мес</li></ul><p>&nbsp;</p><p><strong>КОМПЛЕКТАЦИЯ СТЕЛЛАЖА '.$model.'</strong></p><ul> <li>Стойка &ndash; '.$stoyka.'&nbsp;шт</li> <li>Пластиковая накладка на стойку для защиты пола &ndash; '.$nakladka.' шт</li> <li>Балка фронтальная &ndash; '.$balka_front.' шт</li> <li>Балка боковая &ndash; '.$balka_aside.' шт</li>';

				if(!empty($usilitel)) $description .= '<li>Усилитель полок &ndash; '.$usilitel.' шт</li>';

				$description .= '<li>Полки '.$mat_polok.' &ndash; '.$qnt_shelves.' шт</li> <li>Подробная инструкция по сборке и монтажу &ndash; 1 шт</li></ul><p><br /><strong>УПАКОВКА:</strong></p><ul> <li>Стеллаж '.$model.'&nbsp; поставляется в прочной картонной коробке, весом '.$weight.' кг.</li></ul><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p><strong>Всегда рады помочь, и благодарим за выбор!</strong></p>';
			}
		  
		if($lang == 'ua') {
			$data[] = array($name,$sku,$title,$meta_name,$meta_name,$meta_desc,$description);
		} else {
			$data[] = array($main_category,$category,$name,$model,$sku,$price,$quantity,$length,$width,$height,$weight,$title,$meta_name,$meta_name,$meta_desc,$description,$image,$seo_url,$images,$qnt_shelves,$load_on_shelv,$load_on_rack,$material,$special,$thickness,$color);
		}
		
	}

	$i++;

} while ($i <= $highestRow);


// сохраняем данные в csv 
if($lang == 'ua') {
	$list_head = array (
	    $heading = array("_NAME_","_SKU_","_META_TITLE_","_META_H1_","_META_KEYWORDS_","_META_DESCRIPTION_","_DESCRIPTION_")
	);
} else {
	$list_head = array (
	    $heading = array("_MAIN_CATEGORY_","_CATEGORY_","_NAME_","_MODEL_","_SKU_","_PRICE_","_QUANTITY_","_LENGTH_","_WIDTH_","_HEIGHT_","_WEIGHT_","_META_TITLE_","_META_H1_","_META_KEYWORDS_","_META_DESCRIPTION_","_DESCRIPTION_","_IMAGE_","_SEO_KEYWORD_","_IMAGES_","_QUANTITY_SHELVES_","_MAXIMUM_WEIGHT_","_MAXIMUM_WEIGHT_ALL_","_MATERIAL_SHELVES_", "_SPECIAL_", "_METAL_THICKNESS_","_COLOR_SHELVES_")
	);
}

$fp = fopen('import.csv', 'w');

foreach ($list_head as $fields) {
    fputcsv($fp, $fields, ';');
}
foreach ($data as $fields) {
    fputcsv($fp, $fields, ';');
}

fclose($fp);
