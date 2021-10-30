<?php
/*
* настраивает условия и вывод 404 ошибок
*/
if (!defined('SEOSHIELD_ROOT_PATH')) {
    define('SEOSHIELD_ROOT_PATH', rtrim(realpath(dirname(__FILE__)), '/'));
}

class SeoShieldModule_run_404 extends seoShieldModule
{
    public function run_404_rules()
    {
        // не существующие get
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['run_404_check_get'])
            && true === $GLOBALS['SEOSHIELD_CONFIG']['run_404_check_get']) {
            if (!empty($GLOBALS['SEOSHIELD_CONFIG']['allow_get'])) {
                $request_get = parse_url($GLOBALS['SEOSHIELD_CONFIG']['page_uri']);
                if (!empty($request_get['query'])) {
                    $request_get = explode('&', $request_get['query']);
                    foreach ($request_get as $g) {
                        $g = explode('=', $g);
                        if ('utm_' == substr($g[0], 0, 4)) {
                            continue;
                        }
                        if (!in_array($g[0], $GLOBALS['SEOSHIELD_CONFIG']['allow_get'])) {
                            return true;
                        }
                    }
                }
            }
        }

        // проверка на верхний регистр
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['run_404_check_strlower'])
            && true === $GLOBALS['SEOSHIELD_CONFIG']['run_404_check_strlower']) {
            $path = parse_url($GLOBALS['SEOSHIELD_CONFIG']['page_uri']);
            if (strtolower($path['path']) != $path['path']) {
                return true;
            }
        }

        // проверка на пробел
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['run_404_check_space'])
            && true === $GLOBALS['SEOSHIELD_CONFIG']['run_404_check_space']) {
            if (false !== strpos($GLOBALS['SEOSHIELD_CONFIG']['page_uri'], '%20')) {
                return true;
            }
        }

        // проверка на слеш
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['run_404_check_slash'])
            && true === $GLOBALS['SEOSHIELD_CONFIG']['run_404_check_slash']) {
            if (false !== strpos($GLOBALS['SEOSHIELD_CONFIG']['page_uri'], '//')) {
                return true;
            }
        }

        // пользовательские проверки из конфига
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['run_404_check_user_config'])
            && true === $GLOBALS['SEOSHIELD_CONFIG']['run_404_check_user_config']) {
            return true;
        }

        return false;
    }

    public function start_cms()
    {
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['run_404_start_cms'])) {
            if (true === $GLOBALS['SEOSHIELD_CONFIG']['run_404_start_cms'] && true === $this->run_404_rules()) {
                header('HTTP/1.0 404 Not Found');
                header('Content-Type: text/html; charset=utf-8');

                exit($GLOBALS['SEOSHIELD_CONFIG']['run_404_start_cms_template']);
            }
        }
    }

    public function html_out_buffer($out_html)
    {
        if (true === $this->run_404_rules()) {
            return $this->run_404($out_html);
        }

        return $out_html;
    }

    public function run_404($out_html)
    {
        if (!empty($GLOBALS['SEOSHIELD_CONFIG']['way_to_content'])) {
            if ('utf-8' != $GLOBALS['SEOSHIELD_CONFIG']['site_default_encoding']) {
                $GLOBALS['SEOSHIELD_CONFIG']['meta_title_404'] = iconv('utf-8', $GLOBALS['SEOSHIELD_CONFIG']['site_default_encoding'], $GLOBALS['SEOSHIELD_CONFIG']['meta_title_404']);
            }

            require_once SEOSHIELD_ROOT_PATH.'/core/lib/simple_html_dom.php';
            $html = str_get_html($out_html);
            $html->find($GLOBALS['SEOSHIELD_CONFIG']['way_to_content'], 0)->innertext = $GLOBALS['SEOSHIELD_CONFIG']['message_404'];

            $out_html = (string) $html;
            if ('utf-8' != $GLOBALS['SEOSHIELD_CONFIG']['site_default_encoding']) {
                $out_html = iconv('utf-8', $GLOBALS['SEOSHIELD_CONFIG']['site_default_encoding'], $out_html);
            }
        }
        $out_html = preg_replace('#<title[^>]*>[^<]*</title>#is', '<title>'.$GLOBALS['SEOSHIELD_CONFIG']['meta_title_404'].'</title>', $out_html);
        header('HTTP/1.0 404 Not Found');
        if (!empty($GLOBALS['SEOSHIELD_CONFIG']['way_to_content'])) {
            header('Content-Type: text/html; charset=utf-8');
        }

        return $out_html;
    }
}
