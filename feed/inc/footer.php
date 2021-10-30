<?php

//if(isset($connect) && $connect) mysqli_close($connect);

$callEndTimeTotal = microtime(true);
$callTimeTotal = $callEndTimeTotal - $callStartTimeTotal;
echo 'Загрузка данных завершена. Общее время обработки страницы - ', $callTimeTotal, " секунд", EOL;

?>