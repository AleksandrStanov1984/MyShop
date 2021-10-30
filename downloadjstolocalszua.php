<?php

$scripts[] = array(
    'script' => 'https://code.jivosite.com/script/widget/7iTpEJdqJF',
    'path'   => '7iTpEJdqJF'
);


$scripts[] = array(
    'script' => 'http://www.googletagmanager.com/gtm.js?id=GTM-WZN8BFK',
    'path'   => 'gtm.js'
);

$scripts[] = array(
    'script' => 'https://google-analytics.com/analytics.js',
    'path'   => 'analytics.js'
);

$scripts[] = array(
    'script' => 'https://widgets.binotel.com/calltracking/widgets/gol9z14pud0x1ju7j463.js',
    'path'   => 'gol9z14pud0x1ju7j463.js'
);

$scripts[] = array(
    'script' => 'http://widgets.binotel.com/getcall/widgets/5o4z7wy795qvnzz9skax.js',
    'path'   => '5o4z7wy795qvnzz9skax.js'
);

foreach ($scripts as $script){
    $content = getDownload($script['script']);
    if($content) {
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/externalstaticjs/' . $script['path'], $content);
    }
}

    function getDownload($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }