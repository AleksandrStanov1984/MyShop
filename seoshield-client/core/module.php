<?php

if (!defined('SEOSHIELD_ROOT_PATH')) {
    define('SEOSHIELD_ROOT_PATH', rtrim(realpath(dirname(__FILE__)), '/'));
}

class seoShieldModule
{
    public function __construct()
    {
        $this->get_static_meta();
    }

    public function csv2array($csv_file_name, $delimiter = ';', $enclosure = '"')
    {
        $files_lines = file($csv_file_name);

        $data = [];
        foreach ($files_lines as $line) {
            // if(strpos($GLOBALS['SEOSHIELD_CONFIG']['site_default_encoding'], '1251') !== false
            // 	&& function_exists('iconv'))
            // 	$line = iconv('utf-8', $GLOBALS['SEOSHIELD_CONFIG']['site_default_encoding']."//IGNORE", $line);

            if (function_exists('str_getcsv')) {
                $data[] = str_getcsv(trim($line), $delimiter, $enclosure);
            } else {
                $data[] = explode($delimiter, trim($line));
            }
        }

        return $data;
    }

    public function get_current_h1_only_text_value($out_html)
    {
        $curr_h1 = "";
        preg_match('#<h1[^>]*?>(.*?)<\/h1>#s', $out_html, $finder);
        if (isset($finder[1]) && !empty($finder[1])){
            $curr_h1 = strip_tags($finder[1]);
            $curr_h1 = trim($curr_h1);
        }

        if (file_exists(SEOSHIELD_ROOT_PATH."/data/static_meta.cache.php")){
            if(!isset($GLOBALS['SEOSHIELD_DATA']['static_meta']))
                $this->get_static_meta();

            if (isset($GLOBALS['SEOSHIELD_DATA']['static_meta']['h1'])){
                $curr_h1 = $GLOBALS['SEOSHIELD_DATA']['static_meta']['h1'];
            }
        }

        return $curr_h1;
    }

    public function get_static_data_by_uri($uri = '')
    {
        $data = [];
        $static_data = [];
        if (!is_string($uri)) {
            return $data;
        }
        $host_part = '';
        if (isset($_SERVER['HTTP_HOST'])) {
            $curr_host = $_SERVER['HTTP_HOST'];
            if (preg_match('#(.*)(:\d)#', $curr_host)) {
                $curr_host = preg_replace('#(.*)(:\d*)#', '$1', $curr_host);
            }
            $host_part = '//'.$curr_host;
        }
        if (method_exists($this, 'get_static_meta')) {
            $static_data = $this->get_static_meta(true);
        }
        if (is_array($static_data) && isset($static_data[$host_part.$uri])) {
            $data = $static_data[$host_part.$uri];
        }

        return $data;
    }

    public function get_static_meta($return_full = false)
    {
        if (file_exists(SEOSHIELD_ROOT_PATH.'/data/static_meta.cache.php')) {
            $static_data = require SEOSHIELD_ROOT_PATH.'/data/static_meta.cache.php';

            if (true === $return_full) {
                return $static_data;
            }

            if (!is_array($static_data) || 0 == sizeof($static_data)) {
                return;
            }

            $static_res = [];
            if (isset($static_data[$GLOBALS['SEOSHIELD_CONFIG']['page_url']])) {
                $static_res = $static_data[$GLOBALS['SEOSHIELD_CONFIG']['page_url']];
            } elseif (isset($static_data[$GLOBALS['SEOSHIELD_CONFIG']['page_uri']])) {
                $static_res = $static_data[$GLOBALS['SEOSHIELD_CONFIG']['page_uri']];
            }

            $static_assoc = [
                0 => 'title',
                1 => 'meta_description',
                2 => 'h1',
                3 => 'content',
                4 => 'meta_keywords',
            ];

            $GLOBALS['SEOSHIELD_DATA']['static_meta'] = [];
            if (!isset($GLOBALS['SEOSHIELD_DATA']['static_meta_replace'])) {
                $GLOBALS['SEOSHIELD_DATA']['static_meta_replace'] = [];
            }
            foreach ($static_res as $k => $static_val) {
                if (!isset($static_assoc[$k])) {
                    continue;
                }

                $static_ttl = $static_assoc[$k];
                $static_val = trim($static_val);
                if (!empty($static_val)) {
                    if ('удалить' == $static_val) {
                        $GLOBALS['SEOSHIELD_DATA']['static_meta'][$static_ttl] = '';
                    } elseif (false !== in_array(mb_strtolower($static_val, 'utf-8'), ['генерируется по формуле', 'по формуле', 'null'])) {
                        $GLOBALS['SEOSHIELD_DATA']['static_meta'][$static_ttl] = null;
                    } else {
                        $GLOBALS['SEOSHIELD_DATA']['static_meta'][$static_ttl] = $static_val;
                    }
                } else {
                    $GLOBALS['SEOSHIELD_DATA']['static_meta'][$static_ttl] = null;
                }
            }
        }
    }

    public function get_templates()
    {
        if (file_exists(SEOSHIELD_ROOT_PATH.'/data/templates.cache.php')) {
            return require SEOSHIELD_ROOT_PATH.'/data/templates.cache.php';
        } else {
            return [];
        }
    }

    public function check_file_exists($path)
    {
        $data = [];

        $path_res = explode('/', $path);
        array_pop($path_res);
        $path_dir = implode('/', $path_res);

        if (is_dir($path_dir)) {
            if (is_writable($path_dir)) {
                $data['access'] = true;
            } else {
                chmod($path_dir, 0777);
                if (is_writable($path_dir)) {
                    $data['access'] = true;
                } else {
                    $data['error'] = 'no access to directory';
                }
            }
        } else {
            $dirs = explode('/', $path_dir);
            $dirs_path = [];
            foreach ($dirs as $dir) {
                if ((empty($dir) || '.' == $dir) && '0' !== $dir) {
                    continue;
                }

                $dirs_path[] = $dir;

                $dir_path = implode('/', $dirs_path).'/';
                $dir_path = '/' !== substr($dir_path, 1) ? '/'.$dir_path : $dir_path;
                if (!is_dir($dir_path)) {
                    mkdir($dir_path, 0777);
                    chmod($dir_path, 0777);
                }
            }

            if (!is_dir($path_dir)) {
                $data['error'] = 'cant create directory';
            }
        }

        if (!isset($data['error'])) {
            if (!is_file($path)) {
                touch($path);
            }

            if (is_file($path)) {
                if (is_writable($path)) {
                    $data['access'] = true;
                } else {
                    chmod($path, 0777);
                    if (is_writable($path)) {
                        $data['access'] = true;
                    } else {
                        $data['error'] = 'no access to file';
                    }
                }
            } else {
                $data['error'] = 'cant create file';
            }
        }

        return $data;
    }

    public function get_path_from_hash($hash, $depth = 3)
    {
        if (strlen($hash) < $depth) {
            $depth = strlen($hash);
        }
        $hash_path = '';
        for ($i = 0; $i < $depth; ++$i) {
            $hash_path .= '/'.substr($hash, $i, 1);
        }
        $hash_path .= '/'.$hash.'.php';

        return $hash_path;
    }

    /**
     * замена h1.
     */
    public function replace_page_h1($out_html, $h1)
    {
        if (false === strpos($GLOBALS['SEOSHIELD_CONFIG']['site_default_encoding'], 'utf')
            && function_exists('iconv')) {
            $h1 = iconv('utf-8', $GLOBALS['SEOSHIELD_CONFIG']['site_default_encoding'].'//IGNORE', $h1);
        }

        $new_h1 = '';
        if (isset($h1)) {
            $GLOBALS['SEOSHIELD_DATA']['static_meta_replace']['h1'] = true;

            $find = preg_match('#<h1([^>]*)>(.(?!</h1>))*?.?</h1>#is', $out_html, $current_h1_pregs);
            if (!isset($current_h1_pregs[1])) {
                $current_h1_pregs[1] = '';
            }

            if (false !== $h1) {
                $new_h1 = '<h1'.$current_h1_pregs[1].'>'.$h1.'</h1>';
            }

            if ($find) {
                $out_html = str_replace($current_h1_pregs[0], $new_h1, $out_html);
            }
        }

        return $out_html;
    }

    public function replace_page_meta_description($out_html, $description)
    {
        if (false === strpos($GLOBALS['SEOSHIELD_CONFIG']['site_default_encoding'], 'utf')
            && function_exists('iconv')) {
            $description = iconv('utf-8', $GLOBALS['SEOSHIELD_CONFIG']['site_default_encoding'].'//IGNORE', $description);
        }

        // замена description
        $new_meta_description = '';
        if (isset($description)) {
            $GLOBALS['SEOSHIELD_DATA']['static_meta_replace']['meta_description'] = true;

            if (false !== $description) {
                $new_meta_description = '<meta name="description" content="'.$description.'" />';
            }

            if (preg_match("#<meta[^>]*name *= *[\"']description[\"'][^>]*content *= *[\"']([^\"']*)[\"'][^>]*>#is", $out_html, $current_description_pregs)) {
                $out_html = str_replace($current_description_pregs[0], $new_meta_description, $out_html);
            } else {
                $out_html = str_replace('</head>', $new_meta_description.'</head>', $out_html);
            }
        }

        return $out_html;
    }

    public function replace_page_meta_keywords($out_html, $keywords)
    {
        if (false === strpos($GLOBALS['SEOSHIELD_CONFIG']['site_default_encoding'], 'utf') && function_exists('iconv')) {
            $keywords = iconv('utf-8', $GLOBALS['SEOSHIELD_CONFIG']['site_default_encoding'].'//IGNORE', $keywords);
        }

        // замена keywords
        $new_meta_keywords = '';
        if (isset($keywords)) {
            $GLOBALS['SEOSHIELD_DATA']['static_meta_replace']['meta_keywords'] = true;

            if (false !== $keywords) {
                $new_meta_keywords = '<meta name="keywords" content="'.$keywords.'" />';
            }

            if (preg_match("#<meta[^>]*name *= *[\"']keywords[\"'][^>]*content *= *[\"']([^\"']*)[\"'][^>]*>#is", $out_html, $current_keywords_pregs)) {
                $out_html = str_replace($current_keywords_pregs[0], $new_meta_keywords, $out_html);
            } else {
                $out_html = str_replace('</head>', $new_meta_keywords.'</head>', $out_html);
            }
        }

        return $out_html;
    }

    public function replace_page_title($out_html, $title)
    {
        if (false === strpos($GLOBALS['SEOSHIELD_CONFIG']['site_default_encoding'], 'utf') && function_exists('iconv')) {
            $title = iconv('utf-8', $GLOBALS['SEOSHIELD_CONFIG']['site_default_encoding'].'//IGNORE', $title);
        }

        // замена title
        $new_title = '';
        if (isset($title)) {
            $GLOBALS['SEOSHIELD_DATA']['static_meta_replace']['title'] = true;

            $find = preg_match('#<title([^>]*)>(.*?)</title>#is', $out_html, $current_title_pregs);
            if ($find) {
                $new_title = '<title'.$current_title_pregs[1].'>'.$title.'</title>';
                $out_html = str_replace($current_title_pregs[0], $new_title, $out_html);
            } else {
                $new_title = '<title>'.$title.'</title>';
                $out_html = str_replace('</head>', $new_title.'</head>', $out_html);
            }
        }

        return $out_html;
    }

    public function replace_page_content($out_html, $content)
    {
        if (empty($content)) {
            return $out_html;
        }

        if (false === strpos($GLOBALS['SEOSHIELD_CONFIG']['site_default_encoding'], 'utf') && function_exists('iconv')) {
            $content = iconv('utf-8', $GLOBALS['SEOSHIELD_CONFIG']['site_default_encoding'].'//IGNORE', $content);
        }

        if (isset($GLOBALS['SEOSHIELD_CONFIG']['content_area_selector']) && !empty($content)) {
            if (!isset($GLOBALS['SEOSHIELD_CONFIG']['content_replace_type'])) {
                $GLOBALS['SEOSHIELD_CONFIG']['content_replace_type'] = 0;
            }

            foreach ($GLOBALS['SEOSHIELD_CONFIG']['content_area_selector'] as $selector) {
                switch ($selector['type']) {
                    case'regex':
                        if (preg_match($selector['pattern'], $out_html, $pregs)) {
                            $GLOBALS['SEOSHIELD_DATA']['static_meta_replace']['content'] = true;

                            if (4 == sizeof($pregs)) {
                                $replace_to = $pregs[1].$content.$pregs[3];
                            } else {
                                $replace_to = $content;
                            }

                            if (isset($selector['add_before']) && !empty($selector['add_before'])) {
                                $replace_to = $selector['add_before'].$replace_to;
                            }
                            if (isset($selector['add_after']) && !empty($selector['add_after'])) {
                                $replace_to = $replace_to.$selector['add_after'];
                            }

                            $out_html = str_replace($pregs[0], $replace_to, $out_html);
                            break;
                        }
                        break;
                }
            }
        }

        return $out_html;
    }

    public function httpGet($uri)
    {
        if (is_string($uri) && strlen($uri) > 0) {
            try {
                $ctx = stream_context_create(
                    [
                    'http' => [
                        'timeout' => 1,
                        ],
                    ]
                );
                $c = file_get_contents($uri, 0, $ctx);
                if (is_string($c) && 0 != strlen($c)) {
                    return strtolower(trim($c));
                } else {
                    throw new Exception('failed file_get_contents');
                }
            } catch (Exception $e) {
                try {
                    $ch = curl_init();

                    if (false === $ch) {
                        throw new Exception('failed to initialize');
                    }
                    curl_setopt($ch, CURLOPT_URL, $uri);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
                    $response = curl_exec($ch);

                    if (false === $response) {
                        throw new Exception(curl_error($ch), curl_errno($ch));
                    }

                    return strtolower(trim($response));
                } catch (Exception $e) {
                    return '';
                }
            }
        }
    }
}
