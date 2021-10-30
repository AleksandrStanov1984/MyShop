<?php

$inputFileName = $file_path . 'ids.xlsx';

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$reader->setReadDataOnly(true);
$spreadsheet = $reader->load($inputFileName);
$worksheet = $spreadsheet->setActiveSheetIndex(0);

$highestRow = $worksheet->getHighestRow(); 
$highestColumn = $worksheet->getHighestDataColumn(); 

// init parametrs
$i = 2; //стартовая строка
$column_rozetka_id = 1;
$column_prom_id = 2;

// before update clear table
clearTable();

do {

	// записываем id
	$rozetka_id = $worksheet->getCellByColumnAndRow($column_rozetka_id, $i)->getValue();
	$prom_id =  $worksheet->getCellByColumnAndRow($column_prom_id, $i)->getValue();

	addRowValues($rozetka_id, $prom_id);

	$i++;

} while ($i <= $highestRow);
