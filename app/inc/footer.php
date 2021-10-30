<?php

mysqli_close($connect);

$callEndTimeTotal = microtime(true);
$callTimeTotal = $callEndTimeTotal - $callStartTimeTotal;
echo 'Общее время обработки страницы - ', $callTimeTotal, " секунд", EOL;

?>