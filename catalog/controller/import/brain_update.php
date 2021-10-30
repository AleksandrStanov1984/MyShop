<?php

class ControllerImportBrainUpdate extends Controller
{
    private $login = 'sm@sz.ua';
    private $password = '03330333';
    private $key = '';
    private $usd = 28.3;

    const BRAIN_ID = 18;
    const CODE_PROVIDER = 'Электроника-1';

//    public function index()
//    {
//        set_time_limit(0);
//        $start = microtime(true);
//        $this->getLogsBrain('brain_price_update.txt', 'Начало работы ' . date("m/d/Y H:i:s"));
//        if ($this->GetBrainKey()) {
//            $this->usd = $this->getBrainCurrencies();
//            $url = $this->getProductBrainFull();
//            $this->FileSave($url);
//            if (file_exists('product_brain.json')) {
//                $string = $this->FileOpen(HTTP_SERVER . 'product_brain.json');
//                $products = json_decode($string);
//
//                foreach ($products as $key => $product) {
//                    $provider_product = $this->db->query("SELECT * FROM " . DB_PREFIX . "provider_product
//                    WHERE id_provider_product = '" . (int)$product->ProductID . "' AND code_provider = '" . self::CODE_PROVIDER . "'");
//
//                    if (!empty($provider_product->rows)) {
//                        $this->db->query("UPDATE " . DB_PREFIX . "provider_product SET
//                            old_price_rrc = price_rrc,
//                            old_price_base = price_base,
//                            price_rrc = '" . (float)$product->RetailPrice . "',
//            	            price_base = '" . (float)$product->price_uah . "',
//						    status_price = '7',
//						    date_modified = NOW()
//						    WHERE id_provider_product = '" . self::BRAIN_ID . "' AND code_provider = '" . self::CODE_PROVIDER . "'");
//                    } else {
//                        $this->db->query("INSERT INTO " . DB_PREFIX . "provider_product
//                            (id_provider, code_provider, id_provider_product, code_provider_product,
//                            name_provider_product, price_base, price_rrc, status_price, date_added)
//                            values('" . self::BRAIN_ID . "', '" . self::CODE_PROVIDER . "', '" . (int)$product->ProductID . "',
//                            '" . (string)$product->product_code . "', '" . (string)$product->name . "', '" . (float)$product->price_uah . "',
//                            '" . (float)$product->retail_price_uah . "', 7, NOW())");
//                    }
//
//                }
//                $this->getLogsBrain('brain_price_update.txt', 'Время выполнения скрипта: ' . round(microtime(true) - $start, 4) . ' сек.');
//                $this->getLogsBrain('brain_price_update.txt', 'Завершение');
//            } else {
//                $this->getLogsBrain('brain_price_update.txt', 'Файл не найден!!!');
//            }
//        }
//    }

    public function index()
    {
        set_time_limit(0);
        $start = microtime(true);
        $this->getLogsBrain('brain_price_update.txt', 'Начало работы ' . date("m/d/Y H:i:s"));
        if ($this->GetBrainKey()) {
            $this->usd = $this->getBrainCurrencies();
            $url = $this->getProductBrainFull();
            $this->FileSave($url);
            if (file_exists('product_brain.json')) {
                $string = $this->FileOpen(HTTP_SERVER . 'product_brain.json');
                $products = json_decode($string);
                $sql = '';

                foreach ($products as $key => $product) {
                    $this->db->query("UPDATE " . DB_PREFIX . "product SET
                        price_rrc = '" . (float)$product->RetailPrice . "',
                      price_base = '" . (float)$product->PriceUSD * $this->usd . "',
            stock_status_id = '7',
            date_modified = NOW()
            WHERE brain_id = '" . (int)$product->ProductID . "' AND status_api_brain = 1");

//                    $provider_product = $this->db->query("SELECT * FROM " . DB_PREFIX . "provider_product
//                    WHERE id_provider = '" . (int)$product->ProductID . "' AND id_provider_product = '" . self::CODE_PROVIDER . "'");
//
//                    if (!empty($provider_product->rows)) {
//                        $this->db->query("UPDATE " . DB_PREFIX . "provider_product SET
//                            price_rrc = '" . (float)$product->RetailPrice . "',
//                          price_base = '" . (float)$product->price_uah . "',
//                status_n = '7',
//                date_modified = NOW()
//                WHERE id_provider = '" . (int)$product->ProductID . "' AND id_provider_product = '" . self::CODE_PROVIDER . "'");
//                    } else {
//                        $this->db->query("INSERT INTO " . DB_PREFIX . "provider_product pp
//                            (pp.id_provider, pp.code_provider, pp.id_provider_product, pp.code_provider_product,
//                            pp.name_provider_product, pp.price_base, pp.price_rrc, pp.status_price, pp.date_added)
//                            values('" . self::BRAIN_ID . "', '" . self::CODE_PROVIDER . "', '" . (int)$product->product_code . "',
//                            '" . (int)$product->articul . "', '" . (string)$product->name . "', '" . (float)$product->price_uah . "',
//                            '" . (float)$product->retail_price_uah . "', 7, NOW())");
//                    }

                }
                $this->getLogsBrain('brain_price_update.txt', 'Время выполнения скрипта: ' . round(microtime(true) - $start, 4) . ' сек.');
                $this->getLogsBrain('brain_price_update.txt', 'Завершение');
            } else {
                $this->getLogsBrain('brain_price_update.txt', 'Файл не найден!!!');
            }
        }
    }

    public function UpdateStockStatusIdAdd()
    {
        set_time_limit(0);
        $start = microtime(true);
        $this->getLogsBrain('brain_price_update.txt', 'Начало работы заливаем brain_id в таблицу brain_id_product ' . date("m/d/Y H:i:s"));
        if (file_exists('product_brain.json')) {
            $this->db->query("DELETE FROM " . DB_PREFIX . "brain_id_product WHERE 1");
            $string = $this->FileOpen(HTTP_SERVER . 'product_brain.json');
            $products = json_decode($string);

            foreach ($products as $key => $product) {
                $this->db->query("INSERT INTO  " . DB_PREFIX . "brain_id_product SET brain_id = '" . (int)$product->ProductID . "'");
            }
            $this->getLogsBrain('brain_price_update.txt', 'Время выполнения скрипта: ' . round(microtime(true) - $start, 4) . ' сек.');
            $this->getLogsBrain('brain_price_update.txt', 'Завершение заливки brain_id в таблицу brain_id_product');
        }
    }

    public function CheckUpdateStockStatus()
    {
        set_time_limit(0);
        $start = microtime(true);
        $this->getLogsBrain('brain_price_update.txt', 'Начало проверки обновления stock_status_id ' . date("m/d/Y H:i:s"));

        $timeNow = date('Y-m-d H:i:s');
        $time = strtotime($timeNow);
        $stock_status_id = 5;

        $product_brain = $this->db->query("SELECT brain_id FROM " . DB_PREFIX . "product WHERE brain_id != 0 ");
        if ($product_brain->rows) {
            foreach ($product_brain->rows as $product) {
                $result = $this->db->query("SELECT brain_id FROM " . DB_PREFIX . "brain_id_product WHERE brain_id ='" . (int)$product['brain_id'] . "'");

                if (isset($result->row['brain_id'])) {
                    $time_mode = strtotime($product['date_modified']);
                    $timestamp_one_hour = $time_mode + 3600;

                    if ($product['stock_status_id'] == 7 && $timestamp_one_hour < $time) {
                        $this->db->query("UPDATE " . DB_PREFIX . "product t SET 
                        t.stock_status_id = '" . $stock_status_id . "',
                        date_modified = NOW() 
                        WHERE t.brain_id = '" . $product['brain_id'] . "'");
                    }
                }
            }
        }
        $this->getLogsBrain('brain_price_update.txt', 'Время выполнения скрипта: ' . round(microtime(true) - $start, 4) . ' сек.');
        $this->getLogsBrain('brain_price_update.txt', 'Завершение проверки обновления stock_status_id');
    }


    public
    function UpdateStatusProduct()
    {
        set_time_limit(0);
        $start = microtime(true);
        $this->getLogsBrain('brain_price_update.txt', 'Начало работы отключение продуктов ' . date("m/d/Y H:i:s"));
        $results_product = $this->db->query("SELECT brain_id FROM " . DB_PREFIX . "product WHERE brain_id != 0 ");
        if ($results_product->rows) {
            foreach ($results_product->rows as $product) {
                $result = $this->db->query("SELECT brain_id FROM " . DB_PREFIX . "brain_id_product WHERE brain_id ='" . (int)$product['brain_id'] . "'");
                if (isset($result->row['brain_id'])) {
                    $this->db->query("UPDATE " . DB_PREFIX . "product SET
						status = '1',
						date_modified = NOW()
						WHERE brain_id = '" . (int)$product['brain_id'] . "' AND status_api_brain = 1");
                }
            }
        }
        $this->getLogsBrain('brain_price_update.txt', 'Время выполнения скрипта: ' . round(microtime(true) - $start, 4) . ' сек.');
        $this->getLogsBrain('brain_price_update.txt', 'Завершение отключение продуктов');
    }

    public
    function update_day_delivery()
    {
        set_time_limit(0);
        $start = microtime(true);
        $this->getLogsBrain('brain_price_update.txt', 'Начало работы Обновление Day Delivery ' . date("m/d/Y H:i:s"));
        if (file_exists('product_brain.json')) {
            $string = $this->FileOpen(HTTP_SERVER . 'product_brain.json');
            $products = json_decode($string);
            foreach ($products as $key => $product) {
                $this->db->query("UPDATE " . DB_PREFIX . "provider_delivery b SET
                        day_delivery  = '" . (int)$product->DayDelivery . "'
						WHERE b.product_id = (
						SELECT a.product_id from " . DB_PREFIX . "provider_product a 
						WHERE a.id_provider_product = '" . (string)$product->ProductID . "' 
						AND a.id_provider = '" . self::BRAIN_ID . "') 
						AND b.id_provider = '" . self::BRAIN_ID . "'");
            }
            $this->getLogsBrain('brain_price_update.txt', 'Время выполнения скрипта: ' . round(microtime(true) - $start, 4) . ' сек.');
            $this->getLogsBrain('brain_price_update.txt', 'Завершение Day Delivery');
        } else {
            $this->getLogsBrain('brain_price_update.txt', 'Файл не найден!!!');
        }
    }//


    public
    function GetBrainKey()
    {
        if ($this->key != '') {
            return true;
        }
        $url = "http://api.brain.com.ua/auth";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'login' => $this->login,
            'password' => md5($this->password),
        ));
        curl_setopt($ch, CURLOPT_URL, $url);
        $output = curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($output, true);
        if (isset($arr['result']) and isset($arr['status']) and $arr['status'] == 1) {
            $this->key = $arr['result'];
            return true;
        }
        return false;
    }

    public
    function getBrainCurrencies()
    {
        if ($this->GetBrainKey()) {
            $url = "http://api.brain.com.ua/currencies/" . $this->key;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            $output = curl_exec($ch);
            curl_close($ch);
            $array = json_decode($output, true);
            if (isset($array['result']) and isset($array['status']) and $array['status'] == 1) {
                return $array['result'][1]['value'];
            }
            return false;
        }
    }


    public
    function getProductBrainFull()
    {

        if ($this->GetBrainKey()) {
            $url = "http://api.brain.com.ua/pricelists/8948/json/" . $this->key . "?full=1";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            curl_setopt($ch, CURLOPT_URL, $url);
            $output = curl_exec($ch);
            curl_close($ch);
            $array = json_decode($output, true);
            if (isset($array['url']) and isset($array['status']) and $array['status'] == 1) {
                return $array['url'];
            }
            return false;
        }
    }

    public
    function FileSave($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        file_put_contents('product_brain.json', $output);
    }

    public
    function FileOpen($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public
    function getLogsBrain($file, $message)
    {
        $filename = $file;
        $handle = fopen(DIR_LOGS . $filename, 'a');
        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . print_r($message, true) . "\n");
        fclose($handle);
    }
}