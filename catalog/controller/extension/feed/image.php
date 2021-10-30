<?php

class ControllerExtensionFeedImage extends Controller
{
    public function index()
    {
        set_time_limit(0);
        $dir = DIR_IMAGE . 'catalog/new/';
        $foolders = scandir($dir, 1);
        foreach ($foolders as $foolder) {
            $query = $this->db->query("SELECT product_id, image, image_dod FROM " . DB_PREFIX . "product WHERE sku = '" . $this->db->escape($foolder) . "' LIMIT 1");

            if (isset($query->row['product_id'])) {
                if (strlen($query->row['image_dod']) == 0) {
                    $this->db->query("UPDATE " . DB_PREFIX . "product SET image_dod = '" . $this->db->escape($query->row['image']) . "' WHERE 
                         product_id = '" . (int)$query->row['product_id'] . "'");

                    $image = 'catalog/new/' . $foolder . '/1.jpg';
                    $this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($image) . "' WHERE 
                         product_id = '" . (int)$query->row['product_id'] . "'");

                }
            }
        }
    }

    public function imagesize()
    {
        $query = $this->db->query("SELECT image FROM " . DB_PREFIX . "product WHERE status = 1");
        foreach ($query->rows as $image) {
            $file_name = 'image/' . $image['image'];
            if (file_exists($file_name)) {
                $bytes = filesize($file_name);
                $byte = number_format($bytes / 1024, 2) . ',KB';
                echo $file_name . ':,' . $byte . '<br>';
            }
        }
    }

    public function imagefile()
    {
        set_time_limit(0);
        $file = 'google_base_xml/image.csv';
        $f = fopen($file, "rt") or die("Ошибка!");
        for ($i = 0; ($data = fgetcsv($f, 1000, ";")) !== false; $i++) {
            $num = count($data);
            for ($c = 0; $c < $num; $c++) {
                $string = explode(',', $data[$c]);
                $sku = trim($string[0]);
                $image_str = trim($string[1]);
                $image = str_replace('/var/www/sz.ua/image/', '', $image_str);
                $query = $this->db->query("SELECT product_id, image, image_dod FROM " . DB_PREFIX . "product WHERE sku = '" . $this->db->escape($sku) . "' LIMIT 1");

                if (isset($query->row['product_id'])) {
                    if (strlen($query->row['image_dod']) == 0) {
                        $this->db->query("UPDATE " . DB_PREFIX . "product SET image_dod = '" . $this->db->escape($query->row['image']) . "' WHERE 
                         product_id = '" . (int)$query->row['product_id'] . "'");
                        $this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($image) . "' WHERE 
                         product_id = '" . (int)$query->row['product_id'] . "'");
                    }
                }
            }
        }
    }

    public function image_searh()
    {
        $query = $this->db->query("SELECT product_id, sku, image FROM " . DB_PREFIX . "product WHERE status = 1");
        foreach ($query->rows as $image) {
            $file_name = 'image/' . $image['image'];
            if (file_exists($file_name)) {

            } else {
                echo 'Product: ' . $image['product_id'] . '  SKU: ' . $image['sku'] . '<br>';
            }
        }
    }
}
