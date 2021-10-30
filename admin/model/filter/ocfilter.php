<?php

class ModelFilterOcfilter extends Model
{
    public function copyFilter($data = array())
    {
        $start = microtime(true);
        set_time_limit(0);
        $this->load->model('localisation/language');
        $languages = $this->model_localisation_language->getLanguages();
        $separator = ';';
        $v = 10000;

        $products = array();
        $options = array();

        $this->getLogsFilter('copyFilter.txt', 'Начало копирования');
        $this->getLogsFilter('copyFilter.txt', 'Значения Фильтра: ' . $data['option_id']);
        $this->getLogsFilter('copyFilter.txt', 'Значения Атрибута: ' . $data['attribute']);

        $this->db->query("UPDATE " . DB_PREFIX . "product_attribute SET text = TRIM(REPLACE(REPLACE(REPLACE(text, '\t', ''), '\n', ''), '\r', ''))");

        $query_category_select = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "ocfilter_option_to_category WHERE option_id  = '" . (int)$data['option_id'] . "'");

        $count_category = 0;
        foreach ($query_category_select->rows as $category_id) {
            $product_row = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE category_id  = '" . (int)$category_id['category_id'] . "'");

            foreach ($product_row->rows as $pr_id) {
                $products_cat[] = $pr_id['product_id'];
            }
            $count_category++;
        }

        $this->getLogsFilter('copyFilter.txt', 'Количество категорий в фильтре: ' . $count_category);

        foreach ($products_cat as $products_id) {
            $product_row = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$products_id . "'
           AND attribute_id ='" . $data['attribute'] . "'");
            foreach ($product_row->rows as $pr_id) {
                $products[] = $pr_id['product_id'];
            }
        }

        $this->getLogsFilter('copyFilter.txt', 'Количество продуктов: ' . count($products));

        if ($products) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "ocfilter_option_value WHERE option_id ='" . (int)$data['option_id'] . "'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "ocfilter_option_value_description WHERE option_id ='" . (int)$data['option_id'] . "'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "ocfilter_option_value_to_product WHERE option_id ='" . (int)$data['option_id'] . "'");

            $this->getLogsFilter('copyFilter.txt', 'Очистка таблиц');

            $results_products = array_unique($products);
            $v *= 4;

            foreach ($results_products as $results_products_id) {
                foreach ($languages as $language) {
                    $text_row = $this->db->query("SELECT text FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$results_products_id . "' AND attribute_id ='" . $data['attribute'] . "' 
                      AND language_id = '" . (int)$language['language_id'] . "'");

                    foreach ($text_row->rows as $text) {
                        $options[$results_products_id][] = $text['text'];
                    }
                }
            }

            $this->getLogsFilter('copyFilter.txt', 'Запись в таблицы');
            $count_rows = 0;


            foreach ($options as $key => $option) {

                $option_ex0 = preg_split('/[,;]+/', $option[0]);
                $option_ex1 = preg_split('/[,;]+/', $option[1]);


                for ($i = 0; $i < count($option_ex0); $i++) {
                    $name_query_ru = $this->db->query("SELECT name FROM " . DB_PREFIX . "ocfilter_option_value_description WHERE language_id = '1' AND name LIKE '%" . $option_ex0[$i] . "%' AND option_id = '" . (int)$data['option_id'] . "'");

                    $ru_ar = array();
                    foreach ($name_query_ru->rows as $ru) {
                        array_push($ru_ar, $ru['name']);
                    }


                    if (!(in_array($option_ex0[$i], $ru_ar))) {

                        if (isset($option[0])) {
                            $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "ocfilter_option_value (option_id, value_id) VALUES
                           ('" . (int)$data['option_id'] . "', (CRC32(CONCAT('" . $data['attribute'] . "', '" . $option_ex0[$i] . "')) + '" . (int)$v . "'))");
                        }

                        $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "ocfilter_option_value_description (option_id, value_id, language_id, name) VALUES
                        ('" . (int)$data['option_id'] . "', (CRC32(CONCAT('" . $data['attribute'] . "', '" . $option_ex0[$i] . "')) + '" . (int)$v . "'), '1', '" . $option_ex0[$i] . "')");                       

                        $count_rows++;
                    } 

                    $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "ocfilter_option_value_to_product (option_id, value_id, product_id) VALUES
                        ('" . (int)$data['option_id'] . "', (CRC32(CONCAT('" . $data['attribute'] . "', '" . $option_ex0[$i] . "')) + '" . (int)$v . "'), '" . (int)$key . "')");
                }

                for ($i = 0; $i < count($option_ex1); $i++) {
                    $name_query_ukr = $this->db->query("SELECT name FROM " . DB_PREFIX . "ocfilter_option_value_description WHERE language_id = 3 AND name LIKE '%" . $option_ex1[$i] . "%' AND option_id = '" . (int)$data['option_id'] . "'");
                    $ukr_ar = array();
                    foreach ($name_query_ukr->rows as $ukr) {
                        array_push($ukr_ar, $ukr['name']);
                    }

                    if (!(in_array($option_ex1[$i], $ukr_ar))) {
                        if (!isset($option[0])) {
                            $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "ocfilter_option_value (option_id, value_id) VALUES
                                     ('" . (int)$data['option_id'] . "', (CRC32(CONCAT('" . $data['attribute'] . "', '" . $option_ex0[$i] . "')) + '" . (int)$v . "'))");
                        }
                        $this->db->query("INSERT IGNORE INTO " . DB_PREFIX . "ocfilter_option_value_description (option_id, value_id, language_id, name) VALUES
                                  ('" . (int)$data['option_id'] . "', (CRC32(CONCAT('" . $data['attribute'] . "', '" . $option_ex0[$i] . "')) + '" . (int)$v . "'), '3', '" . $option_ex1[$i] . "')");
                        $count_rows++;
                    }
                }
            }
            $this->getLogsFilter('copyFilter.txt', 'Количество Записей ' . $count_rows);
            $this->getLogsFilter('copyFilter.txt', 'Запись завершена');

        }
        $this->cache->delete('ocfilter');
        $this->cache->delete('product');

        $this->getLogsFilter('copyFilter.txt', 'Время выполнения скрипта: ' . round(microtime(true) - $start, 4) . ' сек.');
        $this->getLogsFilter('copyFilter.txt', 'Копирование выполнено');
    }

    public function translit($string)
    {
        $replace = array(
            'а' => 'a', 'б' => 'b',
            'в' => 'v', 'г' => 'g', 'ґ' => 'g', 'д' => 'd', 'е' => 'e',
            'є' => 'je', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
            'і' => 'i', 'ї' => 'ji', 'й' => 'j', 'к' => 'k', 'л' => 'l',
            'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h',
            'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ъ' => '',
            'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'ju', 'я' => 'ja',

            ' ' => '-', '+' => 'plus'
        );

        $string = mb_strtolower($string, 'UTF-8');
        $string = strtr($string, $replace);
        $string = preg_replace('![^a-zа-яёйъ0-9]+!isu', '-', $string);
        $string = preg_replace('!\-{2,}!si', '-', $string);

        return $string;
    }

    private function utf8_ucfirst($str)
    {
        return utf8_strtoupper(utf8_substr($str, 0, 1)) . utf8_substr($str, 1);
       // return ucfirst($str);
    }

    public function getLogsFilter($file, $message)
    {
        $filename = $file;
        $handle = fopen(DIR_LOGS . $filename, 'a');
        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . print_r($message, true) . "\n");
        fclose($handle);
    }

}