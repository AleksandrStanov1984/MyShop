<?php
class ControllerExtensionFeedTeg extends Controller{
    public function index(){
        $file = 'cat.scv';
        $datas = $this->csv_to_array($file);
        if ($datas) {
            foreach ($datas as $key => $data)
                if ($key != 0) {
                    $parts = explode('/', $data[1]);
                    if (utf8_strlen(end($parts)) == 0) {
                        array_pop($parts);
                    }
                     $kewords = $parts[count($parts)-1];
                     $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($kewords) . "'");

                    if ($query->num_rows) {
                        $url = explode('=', $query->row['query']);
                        if ($url[0] == 'category_id') {
                            //1 - RUS
                            //3 - UK
                            $this->db->query("UPDATE " . DB_PREFIX . "category_description SET 
                            meta_title = '" . $this->db->escape($data[3]) ."',
                            meta_description  = '". $this->db->escape($data[4]) ."'
                            WHERE category_id = '". (int)$url[1] ."' AND language_id = '1'");

                            $this->db->query("UPDATE " . DB_PREFIX . "category_description SET 
                            meta_h1 =  '". $this->db->escape($data[2]) ."',
                            meta_title = '" . $this->db->escape($data[5]) ."',
                            meta_description = '". $this->db->escape($data[6]) ."'
                            WHERE category_id = '". (int)$url[1] ."' AND language_id = '3'");

                        }
                    }
                }
        }
        echo "Update!!!";
    }

    public function csv_to_array($filename){
        $row = 0;
        $array = array();
        if (($handle = fopen(DIR_ROOT . "cat.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $array[$row] = $data;
                $row++;
            }
            fclose($handle);
        }
        return $array;
    }

}
