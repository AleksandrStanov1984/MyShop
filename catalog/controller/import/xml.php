<?php

class ControllerImportXml extends Controller{
    public function afk(){
        $this->load->model('import/xml');
        $handle = fopen(DIR_LOGS . 'afk.log', 'a');
        fwrite($handle, 'Начали!' . "\n");
        $url = 'https://afk.ua/ua/price/api/buh@sz.ua/zakupki';
        $id_provider = 12;
        $code_provider = 'Игрушки-2';
        $koef_zag = 0;
        $data = $this->getDownload($url);
        $obj = simplexml_load_string($data);
        $array_xml = json_decode(json_encode($obj), true);
        foreach ($array_xml['items']['item'] as $offer) {
            $status_price = 5;
            $id_provider_product = $offer['@attributes']['id'];
            $available = $offer['availability_memo'];
            $code_provider_product = $offer['barcode'];
            $name_provider_product = $offer['name'];
            $price_base = $offer['price'];
            $price_rrc = $offer['msrp'];

            if ($available == 'yes') {
                $status_price = 7;
            }

            $product = $this->model_import_xml->getSelectProviderProduct($id_provider, $id_provider_product);

            if ($product) {
                if ($available == 'yes') {
                    $status_n = 7;
                    fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 7):' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                    $this->model_import_xml->UpdateProviderProduct($price_base, $price_rrc, $status_n, $id_provider_product, $id_provider);
                } else {
                    if ($product['status_price'] == 7) {
                        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 5) :' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                        $this->model_import_xml->UpdateProviderProductStatus($id_provider_product, $id_provider);
                    }
                }
            } else {
                if (is_array($name_provider_product)) {
                    $name_provider_product = 'ошибка!!!';
                }
                if (is_array($code_provider_product)) {
                    $code_provider_product = 'ошибка!!!';
                }
                fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Добовление продукта:' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                $this->model_import_xml->addProviderProduct($id_provider, $code_provider, $id_provider_product, $code_provider_product, $name_provider_product, $price_base, $price_rrc, $status_price);
            }
        }
        $this->UpdateProduct($id_provider);
        fwrite($handle, 'Стоп!' . "\n");
        fclose($handle);
    }


    public function atlantmarket()
    {
        $this->load->model('import/xml');
        $handle = fopen(DIR_LOGS . 'atlantmarket.log', 'a');
        fwrite($handle, 'Начали!' . "\n");
        $url = 'https://atlantmarket.com.ua/price1/prom/atlantmarketpromAtlant.xml';
        $id_provider = 50;
        $code_provider = 'Туризм-1';
        $koef_zag = 0;
        $data = $this->getDownload($url);
        $data = str_replace('&','&amp;',$data);
        $obj = simplexml_load_string($data);
        $array_xml = json_decode(json_encode($obj), true);
        foreach ($array_xml['shop']['offers']['offer'] as $offer) {
            $status_price = 5;
            $id_provider_product = $offer['@attributes']['id'];
            $available = 'true';
            $code_provider_product = $offer['barcode'];
            $name_provider_product = $offer['name'];
            $price_rrc = $offer['price'];
            $price_base = 0.00;
            if ($available == 'true') {
                $status_price = 7;
            }
            $product = $this->model_import_xml->getSelectProviderProduct($id_provider, $id_provider_product);
            if ($product) {
                if ($available =='true') {
                    $status_n = 7;
                    fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 7):' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                    $this->model_import_xml->UpdateProviderProduct($price_base, $price_rrc, $status_n, $id_provider_product, $id_provider);
                } else {
                    if ($product['status_price'] == 7) {
                        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 5) :' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                        $this->model_import_xml->UpdateProviderProductStatus($id_provider_product, $id_provider);
                    }
                }
            } else {
                fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Добовление продукта:' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                $this->model_import_xml->addProviderProduct($id_provider, $code_provider, $id_provider_product, $code_provider_product, $name_provider_product, $price_base, $price_rrc, $status_price);
            }
        }
        $this->UpdateProduct($id_provider);
        fwrite($handle, 'Стоп!' . "\n");
        fclose($handle);
    }

    public function bagland(){
        $this->load->model('import/xml');
        $handle = fopen(DIR_LOGS . 'bagland.log', 'a');
        fwrite($handle, 'Начали!' . "\n");
        $url = 'https://bagland.com.ua/marketplace/43884.xml';
        $id_provider = 4;
        $code_provider = 'Аксессуары-1';
        $koef_zag = 0;
        $data = $this->getDownload($url);
        $obj = simplexml_load_string($data);
        $array_xml = json_decode(json_encode($obj), true);

        foreach ($array_xml['shop']['offers']['offer'] as $offer) {
            $status_price = 5;
            $id_provider_product = $offer['@attributes']['id'];
            $available = $offer['@attributes']['available'];
            $code_provider_product = $offer['@attributes']['id'];
            $name_provider_product = $offer['name'];
            $price_base = $offer['price'] * 0.74;
            $price_rrc = $offer['price'];

            if ($available == 'true') {
                $status_price = 7;
            }

            $product = $this->model_import_xml->getSelectProviderProduct($id_provider, $id_provider_product);
            if ($product) {
                if ($available == 'true') {
                    $status_n = 7;
                    fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 7):' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                    $this->model_import_xml->UpdateProviderProduct($price_base, $price_rrc, $status_n, $id_provider_product, $id_provider);
                } else {
                    if ($product['status_price'] == 7) {
                        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 5) :' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                        $this->model_import_xml->UpdateProviderProductStatus($id_provider_product, $id_provider);
                    }
                }
            } else {
                if (is_array($code_provider_product)) {
                    $code_provider_product = 'ошибка!!!';
                }
                fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Добовление продукта:' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                $this->model_import_xml->addProviderProduct($id_provider, $code_provider, $id_provider_product, $code_provider_product, $name_provider_product, $price_base, $price_rrc, $status_price);
            }
        }
        $this->UpdateProduct($id_provider);
        fwrite($handle, 'Стоп!' . "\n");
        fclose($handle);
    }

    public function carrelobaby(){
        $this->load->model('import/xml');
        $handle = fopen(DIR_LOGS . 'carrelobaby.log', 'a');
        fwrite($handle, 'Начали!' . "\n");
        $url = 'https://carrellobaby.com/uk_offers.xml';
        $id_provider = 35;
        $code_provider = 'Автокресла-2';
        $koef_zag = 0;
        $data = $this->getDownload($url);
        $obj = simplexml_load_string($data);
        $array_xml = json_decode(json_encode($obj), true);
        foreach ($array_xml['shop']['offers']['offer'] as $offer) {
            $status_price = 5;
            $id_provider_product = $offer['@attributes']['id'];
            $available = $offer['@attributes']['available'];
            $code_provider_product = $offer['vendorCode'];
            $name_provider_product = $offer['name'];
            $price_rrc = $offer['price'];
            $price_base = 0.00;
            if ($available == 'true') {
                $status_price = 7;
            }
            $product = $this->model_import_xml->getSelectProviderProduct($id_provider, $id_provider_product);
            if ($product) {
                if ($available == 'true') {
                    $status_n = 7;
                    fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 7):' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                    $this->model_import_xml->UpdateProviderProduct($price_base, $price_rrc, $status_n, $id_provider_product, $id_provider);
                } else {
                    if ($product['status_price'] == 7) {
                        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 5) :' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                        $this->model_import_xml->UpdateProviderProductStatus($id_provider_product, $id_provider);
                    }
                }
            } else {
                fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Добовление продукта:' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                $this->model_import_xml->addProviderProduct($id_provider, $code_provider, $id_provider_product, $code_provider_product, $name_provider_product, $price_base, $price_rrc, $status_price);
            }
        }
        $this->UpdateProduct($id_provider);
        fwrite($handle, 'Стоп!' . "\n");
        fclose($handle);
    }

    public function distributions(){
        $this->load->model('import/xml');
        $handle = fopen(DIR_LOGS . 'distributions.log', 'a');
        fwrite($handle, 'Начали!' . "\n");
        $url = 'https://distributions.com.ua/price_list/products.xml?t=f643829ec3eaf6700a12258368495076';
        $id_provider = 22;
        $code_provider = 'Игрушки-3';
        $koef_zag = 0;
        $data = $this->getDownload($url);
        $obj = simplexml_load_string($data);
        $array_xml = json_decode(json_encode($obj), true);
        foreach ($array_xml['product'] as $offer) {
            $status_price = 5;
            $id_provider_product = $offer['@attributes']['id'];
            $available = $offer['stock'];
            $code_provider_product = $offer['barcode'];
            $name_provider_product = $offer['name'];
            $price_base = $offer['today_price_uah'];
            $price_rrc = $offer['retail_price'];
            if ($available != '0') {
                $status_price = 7;
            }
            $product = $this->model_import_xml->getSelectProviderProduct($id_provider, $id_provider_product);
            if ($product) {
                if ($available != '0') {
                    $status_n = 7;
                    fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 7):' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                    $this->model_import_xml->UpdateProviderProduct($price_base, $price_rrc, $status_n, $id_provider_product, $id_provider);
                } else {
                    if ($product['status_price'] == 7) {
                        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 5) :' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                        $this->model_import_xml->UpdateProviderProductStatus($id_provider_product, $id_provider);
                    }
                }
            } else {
                if (is_array($code_provider_product)) {
                    $code_provider_product = 'ошибка!!!';
                }
                fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Добовление продукта:' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                $this->model_import_xml->addProviderProduct($id_provider, $code_provider, $id_provider_product, $code_provider_product, $name_provider_product, $price_base, $price_rrc, $status_price);
            }
        }
        $this->UpdateProduct($id_provider);
        fwrite($handle, 'Стоп!' . "\n");
        fclose($handle);
    }

    public function eneyplus(){
        $this->load->model('import/xml');
        $handle = fopen(DIR_LOGS . 'eneyplus.log', 'a');
        fwrite($handle, 'Начали!' . "\n");
        $url = 'https://eney-plus.com.ua/xml/xmlShop.xml';
        $id_provider = 54;
        $code_provider = 'Текстиль-2';
        $koef_zag = 0;
        $data = $this->getDownload($url);
        $obj = simplexml_load_string($data);
        $array_xml = json_decode(json_encode($obj), true);

        foreach ($array_xml['shop']['offers']['offer'] as $offer) {
            $status_price = 5;
            $id_provider_product = $offer['@attributes']['id'];
            if (isset($offer['@attributes']['available'])) {
                $available = $offer['@attributes']['available'];
            } else {
                $available = 'false';
            }
            $code_provider_product = $offer['@attributes']['id'];

            if (isset($offer['model'])) {
                $name_provider_product = $offer['model'];
            } else {
                $name_provider_product = '';
            }

            $price_base = $offer['price'];
            $price_rrc = $offer['price'] / 0.9;

            if ($available == 'true') {
                $status_price = 7;
            }
            $product = $this->model_import_xml->getSelectProviderProduct($id_provider, $id_provider_product);
            if ($product) {
                if ($available == 'true') {
                    $status_n = 7;
                    fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 7):' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                    $this->model_import_xml->UpdateProviderProduct($price_base, $price_rrc, $status_n, $id_provider_product, $id_provider);
                } else {
                    if ($product['status_price'] == 7) {
                        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 5) :' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                        $this->model_import_xml->UpdateProviderProductStatus($id_provider_product, $id_provider);
                    }
                }
            } else {
                fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Добовление продукта:' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                $this->model_import_xml->addProviderProduct($id_provider, $code_provider, $id_provider_product, $code_provider_product, $name_provider_product, $price_base, $price_rrc, $status_price);
            }
        }
        $this->UpdateProduct($id_provider);
        fwrite($handle, 'Стоп!' . "\n");
        fclose($handle);
    }

    public function hozyaykindom(){
        $this->load->model('import/xml');
        $handle = fopen(DIR_LOGS . 'hozyaykindom.log', 'a');
        fwrite($handle, 'Начали!' . "\n");
        $url = 'https://hozyaykindom.in.ua/yandex_market.xml?hash_tag=45a5f549ad3f6f03736d079456baa1c0&sales_notes=&product_ids=&group_ids=38062118&label_ids=&exclude_fields=&html_description=0&yandex_cpa=&process_presence_sure=';
        $id_provider = 5;
        $code_provider = 'Пластик-3';
        $koef_zag = 0;
        $data = $this->getDownload($url);
        $obj = simplexml_load_string($data);
        $array_xml = json_decode(json_encode($obj), true);

        foreach ($array_xml['shop']['offers']['offer'] as $offer) {
            $status_price = 5;
            $id_provider_product = $offer['@attributes']['id'];
            $available = $offer['@attributes']['available'];
            $code_provider_product = $offer['vendorCode'];
            $name_provider_product = $offer['name'];
            $price_rrc = $offer['price'];
            $price_base = 0.00;

            if ($available == 'true') {
                $status_price = 7;
            }

            $product = $this->model_import_xml->getSelectProviderProduct($id_provider, $id_provider_product);
            if ($product) {
                if ($available == 'true') {
                    $status_n = 7;
                    fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 7):' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                    $this->model_import_xml->UpdateProviderProduct($price_base, $price_rrc, $status_n, $id_provider_product, $id_provider);
                } else {
                    //if ($product['status_price'] == 7) {
                        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 5) :' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                        $this->model_import_xml->UpdateProviderProductStatus($id_provider_product, $id_provider);
                    //}
                }
            } else {
                fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Добовление продукта:' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                $this->model_import_xml->addProviderProduct($id_provider, $code_provider, $id_provider_product, $code_provider_product, $name_provider_product, $price_base, $price_rrc, $status_price);
            }
        }
        $this->UpdateProduct($id_provider);
        fwrite($handle, 'Стоп!' . "\n");
        fclose($handle);
    }

    public function magitex(){
        $this->load->model('import/xml');
        $handle = fopen(DIR_LOGS . 'magitex.log', 'a');
        fwrite($handle, 'Начали!' . "\n");
        $url = 'https://magitex.com.ua/yml_feed4825.xml';
        $id_provider = 38;
        $code_provider = 'Текстиль-1';
        $koef_zag = 0;

        $data = $this->getDownload($url);

        $obj = simplexml_load_string($data);
        $array_xml = json_decode(json_encode($obj), true);

        foreach ($array_xml['shop']['offers']['offer'] as $offer) {
            $status_price = 5;
            $id_provider_product = $offer['@attributes']['id'];
            $available = $offer['@attributes']['available'];
            $code_provider_product = $offer['model'];
            $name_provider_product = $offer['name'];
            $price_rrc = $offer['price'];
            $price_base = 0.00;

            if ($available == 'true') {
                $status_price = 7;
            }

            $product = $this->model_import_xml->getSelectProviderProduct($id_provider, $id_provider_product);
            if ($product) {
                if ($available == 'true') {
                    $status_n = 7;
                    fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 7):' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                    $this->model_import_xml->UpdateProviderProduct($price_base, $price_rrc, $status_n, $id_provider_product, $id_provider);
                } else {
                    if ($product['status_price'] == 7) {
                        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 5) :' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                        $this->model_import_xml->UpdateProviderProductStatus($id_provider_product, $id_provider);
                    }
                }
            } else {
                fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Добовление продукта:' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                $this->model_import_xml->addProviderProduct($id_provider, $code_provider, $id_provider_product, $code_provider_product, $name_provider_product, $price_base, $price_rrc, $status_price);
            }
        }
        $this->UpdateProduct($id_provider);
        fwrite($handle, 'Стоп!' . "\n");
        fclose($handle);
    }

    public function posudograd(){
        $this->load->model('import/xml');
        $handle = fopen(DIR_LOGS . 'posudograd.log', 'a');
        fwrite($handle, 'Начали!' . "\n");
        $url = 'http://www.posudograd.com.ua/dropship/17749/yml';
        $id_provider = 3;
        $code_provider = 'Посуда-1';
        $koef_zag = 0;
        $data = $this->getDownload($url);
        $obj = simplexml_load_string($data);
        $array_xml = json_decode(json_encode($obj), true);

        foreach ($array_xml['shop']['offers']['offer'] as $offer) {
            $status_price = 5;
            $id_provider_product = $offer['@attributes']['id'];
            $available = $offer['@attributes']['available'];
            $code_provider_product = $offer['vendorCode'];
            $name_provider_product = $offer['name'];
            $price_base = $offer['price'] * 0.9;
            $price_rrc = $offer['price'];

            if ($available == 'true') {
                $status_price = 7;
            }

            $product = $this->model_import_xml->getSelectProviderProduct($id_provider, $id_provider_product);
            if ($product) {
                if ($available == 'true') {
                    $status_n = 7;
                    fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 7):' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                    $this->model_import_xml->UpdateProviderProduct($price_base, $price_rrc, $status_n, $id_provider_product, $id_provider);
                } else {
                    if ($product['status_price'] == 7) {
                        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 5) :' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                        $this->model_import_xml->UpdateProviderProductStatus($id_provider_product, $id_provider);
                    }
                }
            } else {
                fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Добовление продукта:' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                $this->model_import_xml->addProviderProduct($id_provider, $code_provider, $id_provider_product, $code_provider_product, $name_provider_product, $price_base, $price_rrc, $status_price);
            }
        }
        $this->UpdateProduct($id_provider);
        fwrite($handle, 'Стоп!' . "\n");
        fclose($handle);
    }

    public function premiumbike(){
        $this->load->model('import/xml');
        $handle = fopen(DIR_LOGS . 'premiumbike.log', 'a');
        fwrite($handle, 'Начали!' . "\n");
        $url = 'http://premiumbike.com.ua/market/sz_price.xml';
        $id_provider = 51;
        $code_provider = 'Велотовары-1';
        $koef_zag = 0;
        $data = $this->getDownload($url);
        $data = str_replace('<![CDATA[', '',$data);
        $data = str_replace(']]>', '',$data);
        $data = str_replace('&','&amp;',$data);
        $obj = simplexml_load_string($data);
        $array_xml = json_decode(json_encode($obj), true);

        foreach ($array_xml['shop']['offers']['offer'] as $offer) {
            $status_price = 5;
            $id_provider_product = $offer['@attributes']['id'];
            $available = $offer['@attributes']['available'];
            $code_provider_product = $offer['@attributes']['id'];
            $name_provider_product = $offer['name'];
            $price_base = $offer['price'];
            $price_rrc = $offer['price_rrp'];

            if ($available == 'true') {
                $status_price = 7;
            }

            $product = $this->model_import_xml->getSelectProviderProduct($id_provider, $id_provider_product);
            if ($product) {
                if ($available == 'true') {
                    $status_n = 7;
                    fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 7):' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                    $this->model_import_xml->UpdateProviderProduct($price_base, $price_rrc, $status_n, $id_provider_product, $id_provider);
                } else {
                    if ($product['status_price'] == 7) {
                        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 5) :' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                        $this->model_import_xml->UpdateProviderProductStatus($id_provider_product, $id_provider);
                    }
                }
            } else {
                if (is_array($name_provider_product)) {
                    $name_provider_product = 'ошибка!!!';
                }
                fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Добовление продукта:' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                $this->model_import_xml->addProviderProduct($id_provider, $code_provider, $id_provider_product, $code_provider_product, $name_provider_product, $price_base, $price_rrc, $status_price);
            }
        }
        $this->UpdateProduct($id_provider);
        fwrite($handle, 'Стоп!' . "\n");
        fclose($handle);
    }

    public function renklode(){
        $this->load->model('import/xml');
        $handle = fopen(DIR_LOGS . 'renklode.log', 'a');
        fwrite($handle, 'Начали!' . "\n");
        $url = 'https://tovary.net.ua/price/TOVARY.xml';
        $id_provider = 53;
        $code_provider = 'Бытовая-1';
        $koef_zag = 0;
        $data = $this->getDownload($url);
        $obj = simplexml_load_string($data);
        $array_xml = json_decode(json_encode($obj), true);

        foreach ($array_xml['shop']['offers']['offer'] as $offer) {
            $status_price = 5;
            $id_provider_product = $offer['@attributes']['id'];
            $available = $offer['@attributes']['available'];
            $code_provider_product = $offer['model'];
            $name_provider_product = $offer['name'];
            $price_rrc = $offer['price'];
            $price_base = 0.00;
            if ($available == 'true') {
                $status_price = 7;
            }

            $product = $this->model_import_xml->getSelectProviderProduct($id_provider, $id_provider_product);
            if ($product) {
                if ($available == 'true') {
                    $status_n = 7;
                    fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 7):' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                    $this->model_import_xml->UpdateProviderProduct($price_base, $price_rrc, $status_n, $id_provider_product, $id_provider);
                } else {
                    if ($product['status_price'] == 7) {
                        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 5) :' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                        $this->model_import_xml->UpdateProviderProductStatus($id_provider_product, $id_provider);
                    }
                }
            } else {
                fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Добовление продукта:' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                $this->model_import_xml->addProviderProduct($id_provider, $code_provider, $id_provider_product, $code_provider_product, $name_provider_product, $price_base, $price_rrc, $status_price);
            }
        }
        $this->UpdateProduct($id_provider);
        fwrite($handle, 'Стоп!' . "\n");
        fclose($handle);
    }

    public function sporttop(){
        $this->load->model('import/xml');
        $handle = fopen(DIR_LOGS . 'sporttop.log', 'a');
        fwrite($handle, 'Начали!' . "\n");
        $url = 'https://sporttop.com.ua/yml.xml';
        $id_provider = 52;
        $code_provider = 'Спорт-1';
        $koef_zag = 0;
        $data = $this->getDownload($url);
        $data = str_replace('&','&amp;',$data);
        $obj = simplexml_load_string($data);
        $array_xml = json_decode(json_encode($obj), true);

        foreach ($array_xml['shop']['offers']['offer'] as $offer) {
            $status_price = 5;
            $id_provider_product = $offer['@attributes']['id'];
            $available = $offer['@attributes']['available'];
            $code_provider_product = $offer['vendorCode'];
            $name_provider_product = $offer['name'];
            $price_base = $offer['price'] * 0.75;
            $price_rrc = $offer['price'];

            if ($available == 'true') {
                $status_price = 7;
            }

            $product = $this->model_import_xml->getSelectProviderProduct($id_provider, $id_provider_product);

            if ($product) {
                if ($available == 'true') {
                    $status_n = 7;
                    fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 7):' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                    $this->model_import_xml->UpdateProviderProduct($price_base, $price_rrc, $status_n, $id_provider_product, $id_provider);
                } else {
                    if ($product['status_price'] == 7) {
                        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 5) :' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                        $this->model_import_xml->UpdateProviderProductStatus($id_provider_product, $id_provider);
                    }
                }
            } else {
                fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Добовление продукта:' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                $this->model_import_xml->addProviderProduct($id_provider, $code_provider, $id_provider_product, $code_provider_product, $name_provider_product, $price_base, $price_rrc, $status_price);
            }
        }
        $this->UpdateProduct($id_provider);
        fwrite($handle, 'Стоп!' . "\n");
        fclose($handle);
    }

    public function tehnoshop(){
        set_time_limit(0);
        $this->load->model('import/xml');
        $handle = fopen(DIR_LOGS . 'tehnoshop.log', 'a');
        fwrite($handle, 'Начали!' . "\n");
        $url = 'https://tehnoshop.ua/xml/opt_file.xml';
        $id_provider = 32;
        $code_provider = 'Электроника-5';
        $koef_zag = 0;
        $data = $this->getDownload($url);
        $data = str_replace('<!DOCTYPE yml_catalog SYSTEM "shops.dtd">','',$data);
        $data = str_replace('&','&amp;',$data);
        $soapResponse = 'invalid_xml';
        libxml_use_internal_errors(true);
        $obj = simplexml_load_string($data,'SimpleXMLElement', LIBXML_COMPACT | LIBXML_PARSEHUGE);
        $array_xml = json_decode(json_encode($obj), true);
        foreach ($array_xml['shop']['offers']['offer'] as $offer) {
            $status_price = 5;
            $id_provider_product = $offer['@attributes']['id'];
            $available = $offer['@attributes']['available'];
            $code_provider_product = $offer['vendorCode'];
            $name_provider_product = $offer['name'];
            $price_base = $offer['price'];
            $price_rrc = 0.00;

            if ($available == 'true') {
                $status_price = 7;
            }

            $product = $this->model_import_xml->getSelectProviderProduct($id_provider, $id_provider_product);
            if ($product) {
                if ($available == 'true') {
                    $status_n = 7;
                    fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 7):' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                    $this->model_import_xml->UpdateProviderProduct($price_base, $price_rrc, $status_n, $id_provider_product, $id_provider);
                } else {
                    if ($product['status_price'] == 7) {
                        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 5) :' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                        $this->model_import_xml->UpdateProviderProductStatus($id_provider_product, $id_provider);
                    }
                }
            } else {
                fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Добовление продукта:' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                $this->model_import_xml->addProviderProduct($id_provider, $code_provider, $id_provider_product, $code_provider_product, $name_provider_product, $price_base, $price_rrc, $status_price);
            }
        }
        $this->UpdateProduct($id_provider);
        fwrite($handle, 'Стоп!' . "\n");
        fclose($handle);
    }

    public function toysi(){
        set_time_limit(0);
        $this->load->model('import/xml');
        $handle = fopen(DIR_LOGS . 'toysi.log', 'a');
        fwrite($handle, 'Начали!' . "\n");
        $url = 'https://toysi.ua/feed-products-residue.php?vendor_code=prom&vendor=yes&out_of_stock=latest&shift=9000000&key=a142873c54c5e648bf5a68cea3be37a3';
        $id_provider = 7;
        $code_provider = 'Игрушки-1';
        $koef_zag = 0;
        $data = $this->getDownload($url);
        $obj = simplexml_load_string($data);
        $array_xml = json_decode(json_encode($obj), true);

        foreach ($array_xml['shop']['offers']['offer'] as $offer) {
            $status_price = 5;
            $id_provider_product = $offer['@attributes']['id'];
            $available = $offer['@attributes']['available'];
            $code_provider_product = $offer['vendorCode'];
            $name_provider_product = $offer['name'];
            $isImport = $offer['isImport'];
            $price_base = $offer['price'];
            $price_rrc = $offer['price'];

            if ($available == 'true') {
                $status_price = 7;
            }

            if ($isImport == 'true') {
                $price_base = $offer['price'] * 0.85;
            } else {
                $price_base = $offer['price'] * 0.9;
            }

            $product = $this->model_import_xml->getSelectProviderProduct($id_provider, $id_provider_product);
            if ($product) {
                if ($available == 'true') {
                    $status_n = 7;
                    fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 7):' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                    $this->model_import_xml->UpdateProviderProduct($price_base, $price_rrc, $status_n, $id_provider_product, $id_provider);
                } else {
                    if ($product['status_price'] == 7) {
                        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 5) :' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                        $this->model_import_xml->UpdateProviderProductStatus($id_provider_product, $id_provider);
                    }
                }
            } else {
                fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Добовление продукта:' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                $this->model_import_xml->addProviderProduct($id_provider, $code_provider, $id_provider_product, $code_provider_product, $name_provider_product, $price_base, $price_rrc, $status_price);
            }
        }
        $this->UpdateProduct($id_provider);
        fwrite($handle, 'Стоп!' . "\n");
        fclose($handle);
    }

    public function uhty(){
        $this->load->model('import/xml');
        $handle = fopen(DIR_LOGS . 'uhty.log', 'a');
        fwrite($handle, 'Начали!' . "\n");
        $url = 'https://uhti.com.ua/bitrix/catalog_export/supplier_127973.php';
        $id_provider = 13;
        $code_provider = 'Посуда-2';
        $koef_zag = 0;
        $data = $this->getDownload($url);
        $obj = simplexml_load_string($data);
        $array_xml = json_decode(json_encode($obj), true);
        foreach ($array_xml['shop']['offers']['offer'] as $offer) {
            $status_price = 5;
            $id_provider_product = $offer['@attributes']['id'];
            $available = $offer['@attributes']['available'];
            $code_provider_product = $offer["param"][0][0];
            $name_provider_product = $offer['name'];
            $price_base = $offer['price'] * 0.7;
            $price_rrc = $offer['price'];

            if ($available == 'in stock') {
                $status_price = 7;
            }
            $product = $this->model_import_xml->getSelectProviderProduct($id_provider, $id_provider_product);
            if ($product) {
                if ($available == 'in stock') {
                    $status_n = 7;
                    fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 7):' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                    $this->model_import_xml->UpdateProviderProduct($price_base, $price_rrc, $status_n, $id_provider_product, $id_provider);
                } else {
                    if ($product['status_price'] == 7) {
                        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 5) :' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                        $this->model_import_xml->UpdateProviderProductStatus($id_provider_product, $id_provider);
                    }
                }
            } else {
                fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Добовление продукта:' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                $this->model_import_xml->addProviderProduct($id_provider, $code_provider, $id_provider_product, $code_provider_product, $name_provider_product, $price_base, $price_rrc, $status_price);
            }
        }
        $this->UpdateProduct($id_provider);
        fwrite($handle, 'Стоп!' . "\n");
        fclose($handle);
    }

    public function zolushka(){
        $this->load->model('import/xml');
        $handle = fopen(DIR_LOGS . 'zolushka.log', 'a');
        fwrite($handle, 'Начали!' . "\n");
        $url = 'https://zolushka.com.ua/content/export/117.xml';
        $id_provider = 24;
        $code_provider = 'Игрушки-4';
        $koef_zag = 0;
        $data = $this->getDownload($url);
        $data = str_replace('<name><![CDATA[', '<name>', $data);
        $data = str_replace(']]></name>', '</name>', $data);
        $obj = simplexml_load_string($data);
        $array_xml = json_decode(json_encode($obj), true);

        foreach ($array_xml['shop']['offers']['offer'] as $offer) {
            $status_price = 5;
            $id_provider_product = $offer['@attributes']['id'];
            $available = $offer['@attributes']['available'];
            $code_provider_product = $offer['vendorCode'];
            $name_provider_product = $offer['name'];
            $price_rrc = $offer['price'];
            $price_base = 0.00;

            if ($available == 'true') {
                $status_price = 7;
            }

            $product = $this->model_import_xml->getSelectProviderProduct($id_provider, $id_provider_product);
            if($product){
                if($available == 'true'){
                    $status_n = 7;
                    fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 7):' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                    $this->model_import_xml->UpdateProviderProduct($price_base, $price_rrc, $status_n, $id_provider_product, $id_provider);
                }else{
                    if($product['status_price'] == 7){
                        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Обновление продукта (статус == 5) :' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                        $this->model_import_xml->UpdateProviderProductStatus($id_provider_product, $id_provider);
                    }
                }
            }else{
                if(is_array($name_provider_product)){
                    $name_provider_product = 'ошибка!!!';
                }
                fwrite($handle, date('Y-m-d G:i:s') . ' - ' . ' Добовление продукта:' . $id_provider_product . ' название продукта: ' . $name_provider_product . "\n");
                $this->model_import_xml->addProviderProduct($id_provider, $code_provider, $id_provider_product, $code_provider_product, $name_provider_product, $price_base, $price_rrc, $status_price);
            }
        }
        $this->UpdateProduct($id_provider);
        fwrite($handle, 'Стоп!' . "\n");
        fclose($handle);
    }

    public function getDownload($url)
    {
        $headers = 'Content-type:text/xml; charset=utf-8';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function UpdateProduct($id_provider){
        $this->db->query("UPDATE " . DB_PREFIX . "provider_product SET
		                 status_price = '5'
		                 WHERE date_modified < DATE_SUB(NOW(), INTERVAL 5 HOUR) AND id_provider = '" . (int)$id_provider . "'");
    }
}