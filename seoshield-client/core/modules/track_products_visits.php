<?php

if (!defined('SEOSHIELD_ROOT_PATH')) {
    define('SEOSHIELD_ROOT_PATH', rtrim(realpath(dirname(__FILE__)), '/'));
}

class SeoShieldModule_track_products_visits extends seoShieldModule
{
    private function check_and_create_table()
    {
        $queries = [];
        $main_table = $GLOBALS['SEOSHIELD_CONFIG']['mysql']->mysql_query('CREATE TABLE IF NOT EXISTS `'.$GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['table_name']."` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `product_id` int(11) DEFAULT '0',
            `url` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `category_name` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `parent_category_name` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `product_manufacturer` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `product_model` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `product_code` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `short_desc` TEXT NOT NULL COLLATE utf8_general_ci,
            `full_desc` TEXT NOT NULL COLLATE utf8_general_ci,
            `breadcrumbs` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `robots` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `seo_text` BOOLEAN NOT NULL DEFAULT FALSE,
            `title` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `description` varchar(255) NOT NULL COLLATE utf8mb4_unicode_ci,
            `h1` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `reviews_num` int(11) DEFAULT '0',
            `price` int(11) DEFAULT '0',
            `discount_price` int(11) DEFAULT '0',
            `availability` BOOLEAN NOT NULL DEFAULT FALSE,
            `visits` int(11) DEFAULT '0',
            `date_add` DATE NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `id` (`id`),
            UNIQUE KEY `product_id` (`product_id`),
            UNIQUE KEY `url` (`url`)
        )");

        $info_table = $GLOBALS['SEOSHIELD_CONFIG']['mysql']->mysql_query('CREATE TABLE IF NOT EXISTS `'.$GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['table_info_name']."` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `product_id` int(11) DEFAULT '0',
            `name` varchar(255) NOT NULL COLLATE utf8_general_ci,
            `value` varchar(255) NOT NULL COLLATE utf8_general_ci,
            PRIMARY KEY (`id`),
            UNIQUE KEY `id` (`id`)
        )");

        return $main_table && $info_table;
    }

    private function get_full_url()
    {
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['seoshield_config_url_key'])) {
            return 'http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? 's' : '').':'.$GLOBALS['SEOSHIELD_CONFIG'][$GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['seoshield_config_url_key']];
        }

        return 'http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? 's' : '').':'.$GLOBALS['SEOSHIELD_CONFIG']['page_url_alt'];
    }

    private function get_page_h1($out_html)
    {
        $h1 = '';
        preg_match_all('#<h1[^>]*>(.*?)<\/h1>#s', $out_html, $matches);
        if (isset($matches[0][0])) {
            $h1 = strip_tags($matches[0][0]);
        }
        $h1 = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $h1);
        return $h1;
    }

    private function get_page_title($out_html)
    {
        $title = '';
        preg_match_all('#<title>(.*?)<\/title>#s', $out_html, $matches);
        if (isset($matches[0][0])) {
            $title = strip_tags($matches[0][0]);
        }
        $title = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $title);
        return $title;
    }

    private function get_filter_info($out_html, $position)
    {
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['selected_filters_selector'])) {
            $index = $position - 1;
            preg_match_all($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['selected_filters_selector'], $out_html, $filters_matches);
            if (isset($filters_matches['filter_name']) && isset($filters_matches['filter_value'])) {
                if (isset($filters_matches['filter_name'][$index])) {
                    return $filters_matches['filter_name'][$index].': '.$filters_matches['filter_value'][$index];
                }
            }
        }

        return '';
    }

    private function get_page_description($out_html)
    {
        $ps_descr = '';
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['meta_description_selector'])) {
            preg_match($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['meta_description_selector'], $out_html, $finder);
            if (isset($finder[0]) && !empty($finder[1])) {
                $ps_descr = $finder[1];
            }
            unset($finder);
        }
        $ps_descr = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $ps_descr);
        return $ps_descr;
    }

    private function get_breadcrumbs($out_html)
    {
        $breadcrums_list = '';
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['breadcrumbs_selector'])) {
            preg_match($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['breadcrumbs_selector'], $out_html, $finder);
            if (isset($finder[0]) && !empty($finder[1])) {
                $breadcrums_list = $finder[1];
            }
            unset($finder);
        }
        $breadcrums_list = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $breadcrums_list);
        return $breadcrums_list;
    }

    private function get_category($out_html)
    {
        $breadcrums_list = '';
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['breadcrumbs_selector'])) {
            preg_match($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['breadcrumbs_selector'], $out_html, $finder);
            if (isset($finder[0]) && !empty($finder[1])) {
                $breadcrums_list = $finder[1];
            }
            unset($finder);
        }
        $category = '';
        if (!empty($breadcrums_list)){
            $breadcrums_array = explode(' >> ', $breadcrums_list);
            $category = end($breadcrums_array);
        }
        return $category;
    }

    private function get_parent_category($out_html)
    {
        $breadcrums_list = '';
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['breadcrumbs_selector'])) {
            preg_match($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['breadcrumbs_selector'], $out_html, $finder);
            if (isset($finder[0]) && !empty($finder[1])) {
                $breadcrums_list = $finder[1];
            }
            unset($finder);
        }
        $category = '';
        if (!empty($breadcrums_list)){
            $breadcrums_array = explode(' >> ', $breadcrums_list);
            array_pop($breadcrums_array);
            $category = end($breadcrums_array);
        }
        return $category;
    }


    private function get_robots_txt($out_html)
    {
        preg_match_all('#<meta[^>]*?name=[\'"]?robots[\'"]?[^>]+?>#s', $out_html, $robots_matches);
        if (isset($robots_matches[0]) && isset($robots_matches[0][0])) {
            $robots_tag = $robots_matches[0][0];
            preg_match('#content=[\'"]([^\'"]+)[\'"]#s', $robots_tag, $robots_content);
            if (isset($robots_content[1])) {
                return $robots_content[1];
            }
        }

        return '';
    }

    private function get_products_num($out_html)
    {
        return substr_count($out_html, $GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['product_selector']);
    }

    private function get_seo_text_bool($out_html)
    {
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['content_area_selector'])) {
            foreach ($GLOBALS['SEOSHIELD_CONFIG']['content_area_selector'] as $patternInfo) {
                if (isset($patternInfo['type']) && 'regex' == $patternInfo['type'] && isset($patternInfo['pattern']) && !empty($patternInfo['pattern'])) {
                    if (preg_match($patternInfo['pattern'], $out_html)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    private function get_product_id($out_html)
    {
        $product_id = '';
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['product_id'])) {
            preg_match($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['product_id'], $out_html, $finder);
            if (isset($finder[0]) && !empty($finder[1])) {
                $product_id = $finder[1];
            }
            unset($finder);
        }

        return $product_id;
    }

    private function get_product_code($out_html)
    {
        $product_code = '';
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['product_code'])) {
            preg_match($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['product_code'], $out_html, $finder);
            if (isset($finder[0]) && !empty($finder[1])) {
                $product_code = $finder[1];
            }
            unset($finder);
        }

        return $product_code;
    }

    private function get_category_name($out_html)
    {
        $category_name = '';
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['cms_category_name'])) {
            preg_match($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['cms_category_name'], $out_html, $finder);
            if (isset($finder[0]) && !empty($finder[1])) {
                $category_name = $finder[1];
            }
            unset($finder);
        }

        return $category_name;
    }

    private function get_product_manufacturer($out_html)
    {
        $product_manufacturer = '';
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['product_manufacturer'])) {
            preg_match($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['product_manufacturer'], $out_html, $finder);
            if (isset($finder[0]) && !empty($finder[1])) {
                $product_manufacturer = $finder[1];
            }
            unset($finder);
        }

        return $product_manufacturer;
    }

    private function get_product_model($out_html)
    {
        $product_model = '';
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['product_model'])) {
            preg_match($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['product_model'], $out_html, $finder);
            if (isset($finder[0]) && !empty($finder[1])) {
                $product_model = $finder[1];
            }
            unset($finder);
        }

        return $product_model;
    }

    private function get_short_desc($out_html)
    {
        $short_desc = '';
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['short_desc'])) {
            preg_match($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['short_desc'], $out_html, $finder);
            if (isset($finder[0]) && !empty($finder[1])) {
                $short_desc = $finder[1];
                $short_desc = trim($short_desc);
                $short_desc = strip_tags($short_desc);
                $short_desc = explode(' ', $short_desc);
                $short_desc = array_slice($short_desc, 0, 60);
                $short_desc = implode(' ', $short_desc);
            }
            unset($finder);
        }

        return $short_desc;
    }

    private function get_full_desc($out_html)
    {
        $full_desc = '';
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['full_desc'])) {
            preg_match($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['full_desc'], $out_html, $finder);
            if (isset($finder[0]) && !empty($finder[1])) {
                $full_desc = $finder[1];
                $full_desc = trim($full_desc);
                $full_desc = strip_tags($full_desc);
                $full_desc = explode(' ', $full_desc);
                $full_desc = array_slice($full_desc, 0, 60);
                $full_desc = implode(' ', $full_desc);
            }
            unset($finder);
        }

        return $full_desc;
    }

    private function get_review_num($out_html)
    {
        $reviews_num = 0;
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['reviews_num'])) {
            preg_match($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['reviews_num'], $out_html, $finder);
            if (isset($finder[0]) && !empty($finder[1])) {
                $reviews_num = $finder[1];
            }
            unset($finder);
        }

        return $reviews_num;
    }

    private function get_price($out_html)
    {
        $price = 0;
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['price'])) {
            preg_match($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['price'], $out_html, $finder);
            if (isset($finder[0]) && !empty($finder[1])) {
                $price = $finder[1];
            }
            unset($finder);
        }

        return $price;
    }

    private function get_discount_price($out_html)
    {
        $discount_price = 0;
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['discount_price'])) {
            preg_match($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['discount_price'], $out_html, $finder);
            if (isset($finder[0]) && !empty($finder[1])) {
                $discount_price = $finder[1];
            }
            unset($finder);
        }

        return $discount_price;
    }

    private function get_availability_bool($out_html){
        $availability = false;
        if (strpos($out_html, $GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['availability']) !== false){
            $availability = true;
        }
        return $availability;
    }

    private function get_product_info_list($out_html)
    {
        $info_list = array();
        preg_match_all($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['product_info'], $out_html, $infoMatches);
        if (isset($infoMatches['c_name']) && sizeof($infoMatches['c_name']) > 0)
        {
            foreach ($infoMatches['c_name'] as $index => $c_name) {
                $c_value = $infoMatches['c_value'][$index];
                if (empty($c_value)) continue;
                if (strpos($c_value, ',') !== false){ 
                    if (mb_strlen($c_value, 'utf-8') <= 70){
                        $info_list[$c_name] = $c_value;
                    }
                } else {
                    if (mb_strlen($c_value, 'utf-8') <= 30){
                        $info_list[$c_name] = $c_value;
                    }
                }
            }
        }
        return $info_list;
    }



    public function html_out_buffer($out_html)
    {
        if (function_exists('http_response_code')) {
            $response_code = http_response_code();
            if (404 == $response_code) {
                return $out_html;
            }
        }

        preg_match_all('#<meta[^>]*?name=[\'"]?robots[\'"]?[^>]+?>#s', $out_html, $robots_matches);
        if (isset($robots_matches[0]) && isset($robots_matches[0][0])) {
            if (false !== strpos($robots_matches[0][0], 'noindex')) {
                return $out_html;
            }
        }

        if (!isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits'])) {
            if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']) && $GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']) {
                $out_html = str_replace('</body>', '<!--SEOSHIELD_WARNING: empty track_visits module config [track_products_visits]--></body>', $out_html);
            }

            return $out_html;
        }

        if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['pagination_comment']) && false !== strpos($out_html, $GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['pagination_comment'])) {
            return $out_html;
        }

        if (!isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['selectors'])
            || empty($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['selectors'])
            || !isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['table_name'])
            || empty($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['table_name'])
            || !isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['table_info_name'])
            || empty($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['table_info_name'])
            || !isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['product_selector'])
            || empty($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['product_selector'])
        ) {
            if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']) && $GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']) {
                $out_html = str_replace('</body>', '<!--SEOSHIELD_WARNING: empty fields in track_visits module config [track_products_visits]--></body>', $out_html);
            }

            return $out_html;
        }

        if (!$GLOBALS['SEOSHIELD_CONFIG']['mysql'] instanceof seoShieldDb) {
            if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']) && $GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']) {
                $out_html = str_replace('</body>', '<!--SEOSHIELD_WARNING: problems in DB config [track_products_visits]--></body>', $out_html);
            }

            return $out_html;
        }

        if (!$this->check_and_create_table()) {
            if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']) && $GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']) {
                $out_html = str_replace('</body>', '<!--SEOSHIELD_WARNING: table in DB was not created [track_products_visits]--></body>', $out_html);
            }

            return $out_html;
        }
        $matched = false;
        foreach ($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['selectors'] as $selector) {
            if (!isset($selector['selector'])) {
                continue;
            }
            if (isset($selector['type'])) {
                if ('regex' == $selector['type']) {
                    if (preg_match($selector['selector'], $out_html)) {
                        $matched = true;
                        break;
                    }
                } elseif ('strpos' == $selector['type']) {
                    if (false !== strpos($out_html, 'strpos')) {
                        $matched = true;
                        break;
                    }
                }
            } else {
                if (false !== strpos($out_html, $selector['selector'])) {
                    $matched = true;
                    break;
                }
            }
        }

        if (!$matched) {
            if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']) && $GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']) {
                $out_html = str_replace('</body>', '<!--SEOSHIELD_WARNING: selectors not matched [track_products_visits]--></body>', $out_html);
            }

            return $out_html;
        }

        // if (false === strpos($out_html, $GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['product_selector'])) {
        //     if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']) && $GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']) {
        //         $out_html = str_replace('</body>', '<!--SEOSHIELD_WARNING: products not matched [track_products_visits]--></body>', $out_html);
        //     }

        //     return $out_html;
        // }
        // if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['filter_uri_part']) && false === strpos($GLOBALS['SEOSHIELD_CONFIG']['page_url_alt'], $GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['filter_uri_part'])) {
        //     if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']) && $GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']) {
        //         $out_html = str_replace('</body>', '<!--SEOSHIELD_WARNING: URI not matches [track_products_visits]--></body>', $out_html);
        //     }

        //     return $out_html;
        // }
        $product_id = $this->get_product_id($out_html);
        if (empty($product_id) && isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']) && $GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']){
                $out_html = str_replace('</body>', '<!--SEOSHIELD_WARNING: product_id not found [track_products_visits]--></body>', $out_html);
                return $out_html;
        }

        $row = [
            'product_id' => $product_id,
            'url' => $this->get_full_url($out_html),
            'category_name' => $this->get_category($out_html),
            'parent_category_name' => $this->get_parent_category($out_html),
            'product_manufacturer' => $this->get_product_manufacturer($out_html),
            'product_model' => $this->get_product_model($out_html),
            'product_code' => $this->get_product_code($out_html),
            'short_desc' => $this->get_short_desc($out_html),
            'full_desc' => $this->get_full_desc($out_html),
            'breadcrumbs' => $this->get_breadcrumbs($out_html),
            'robots' => $this->get_robots_txt($out_html),
            'seo_text' => $this->get_seo_text_bool($out_html),
            'title' => $this->get_page_title($out_html),
            'description' => $this->get_page_description($out_html),
            'h1' => $this->get_page_h1($out_html),
            'reviews_num' => $this->get_review_num($out_html),
            'price' => $this->get_price($out_html),
            'discount_price' => $this->get_discount_price($out_html),
            'availability' => $this->get_availability_bool($out_html),
            'visits' => 1,
            'date_add' => date('Y-m-d H:i:s'),
        ];

        $product_info = $this->get_product_info_list($out_html);
        
        //if (isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']) && $GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']) {
            $out_html = str_replace('</body>', '<!--SEOSHIELD_INFO: tracked_row:'."\n".var_export($row, true).'--></body>', $out_html);
            $out_html = str_replace('</body>', '<!--SEOSHIELD_INFO: tracked_product_info:'."\n".var_export($product_info, true).'--></body>', $out_html);
        //}

        if (!isset($GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']) || !$GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['debug']) {
            $check_exists_query = $GLOBALS['SEOSHIELD_CONFIG']['mysql']->mysql_query("SELECT id FROM ".$GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['table_name']." WHERE product_id = ".$product_id);
            $check_exists = $GLOBALS['SEOSHIELD_CONFIG']['mysql']->mysql_num_rows($check_exists_query);
            $result = $GLOBALS['SEOSHIELD_CONFIG']['mysql']->mysql_query('INSERT INTO '.$GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['table_name'].' (`'.implode('`, `', array_keys($row))."`)
                VALUES ('".implode("', '", $row)."')
                ON DUPLICATE KEY UPDATE visits = visits + 1;
            ");
            if (!$result){
                $out_html = str_replace('</body>', '<!--ERROR:'.var_export($GLOBALS['SEOSHIELD_CONFIG']['mysql']->mysql_error(), true).'--></body>', $out_html);  
            } else {
                if ($check_exists === 0){
                    $insert_rows = array();
                    foreach ($product_info as $c_name => $c_value) {
                        $insert_rows[] = '('.$product_id.', "'.$c_name.'", "'.$c_value.'")';
                    }
                    $info_result = $GLOBALS['SEOSHIELD_CONFIG']['mysql']->mysql_query('INSERT INTO '.$GLOBALS['SEOSHIELD_CONFIG']['track_products_visits']['table_info_name'].' (`product_id`, `name`, `value`)
                            VALUES '.implode(',', $insert_rows));
                    if (!$info_result){
                        $out_html = str_replace('</body>', '<!--ERROR:'.var_export($GLOBALS['SEOSHIELD_CONFIG']['mysql']->mysql_error(), true).'--></body>', $out_html);
                    }
                }
            }
        }

        return $out_html;
    }
}
