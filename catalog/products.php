<?php
require "common.php";

$url = 'http://dev2.sz.ua/index.php?route=api/custom/products&token=GtULQW9ZMhhHLi3ooobDukIqTmqOZ1fJ';
$json = do_curl_request($url, $fields);
$data = json_decode($json);

var_dump($data);