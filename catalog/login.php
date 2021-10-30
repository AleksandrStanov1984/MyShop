<?php
require "common.php";

$url = 'https://dev2.sz.ua/index.php?route=api/login';

$fields = array(
    'username' => 'SZapi',
    'key' => 'HcDcaoIuhsHvhXgC2RZkVU6E2ZVZgtbvLrwq4ERGGKLxiJnIFqziNsP6nIxdMtXmuIiEMH6rd7kODn3dpswbbgjKBGIrfMvwmEW0c6rktDtmye0BOrwXmC08543RWgh4UZ726chxVs3OcAZtLVUO1w6ZNuU2a11sYtp0GkZAOHyqs47eMRqLTCBFniCPqiGSQpUsxuKrMbMAOztRgOAouzQ2MbWwl06q7CKqFiJBre1qXxeSp6IjsJdZin24SHA5',
);

$json = do_curl_request($url, $fields);
var_dump($json);