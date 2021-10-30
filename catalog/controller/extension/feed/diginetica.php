<?php
class ControllerExtensionFeedDiginetica extends Controller {
    public function index() {
        set_time_limit(0);
        $this->load->model('extension/feed/multisearch');
        $currencies = array(
            'USD',
            'EUR',
            'UAH',
            'GBP'
        );


        if (in_array($this->session->data['currency'], $currencies)) {
            $currency_code = $this->session->data['currency'];
            $currency_value = $this->currency->getValue($this->session->data['currency']);
        } else {
            $currency_code = 'USD';
            $currency_value = $this->currency->getValue('USD');
        }

        $output  = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $output .= '<yml_catalog date="'.date("Y-m-d H:i:s").'">'."\n";
        $output .=' <shop>'."\n";
        $output .= '<name>' . $this->config->get('config_name') . '</name>'."\n";
        $output .= '<company>SMART ZONE</company>'."\n";
        $output .= '<url>' . $this->config->get('config_url') . '</url>'."\n";
        $output .= '<currencies>'."\n";
        $output .= '<currency id="'. $currency_code .'" rate="1"/>'."\n";
        $output .= '</currencies>'."\n";

        $result_categories = $this->model_extension_feed_multisearch->getCategories();
        if($result_categories) {
            $output .= '<categories>' . "\n";
            foreach($result_categories as $result_categori){
                if($result_categori['parent_id'] != 0){
                    $output .= '<category id="' . $result_categori['category_id'] . '" parentId="'. $result_categori['parent_id'] .'">' . strip_tags(html_entity_decode($result_categori['name'], ENT_QUOTES, 'UTF-8')) . '</category>' . "\n";
                }else {
                    $output .= '<category id="' . $result_categori['category_id'] . '">' . strip_tags(html_entity_decode($result_categori['name'], ENT_QUOTES, 'UTF-8')) . '</category>' . "\n";
                }
            }
            $output .= '</categories>' . "\n";
        }
        $output .= '<offers>'."\n";

        $result_products = $this->model_extension_feed_multisearch->getProducts();

        if($result_products) {
            foreach ($result_products as $result_product) {
                $result = $this->model_extension_feed_multisearch->getProductName($result_product);
                $result_info = $this->model_extension_feed_multisearch->getProductsDetails($result_product);

                $link = $this->url->link('product/product', 'product_id=' . $result_product);
                $output .= '<offer id="' . $result_product . '" available="true">' . "\n";
                $name = strip_tags($result['name']);
                $name = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $name);
                $name = html_entity_decode($name,ENT_QUOTES);
                $name = htmlspecialchars($name,ENT_QUOTES);
                $name = addslashes($name);
                $output .= '<name>'. $name .'</name>' . "\n";
                $output .= '<url>' . str_replace('%2F', '/', htmlspecialchars($link,ENT_QUOTES)) . '</url>' . "\n";

                $product_info_price = $this->model_extension_feed_multisearch->getProductsSpecial($result_product);

                if (isset($product_info_price['price']) && (float)$product_info_price['price']) {
                    $output .= '<price>' . $this->currency->format($this->tax->calculate($product_info_price['price'], $result_info['tax_class_id']), $currency_code, $currency_value, false) . '</price>' . "\n";
                    $output .= '<oldprice>' . $this->currency->format($this->tax->calculate($result_info['price'], $result_info['tax_class_id']), $currency_code, $currency_value, false) . '</oldprice>' . "\n";
                }else{
                    $output .= '<price>' . $this->currency->format($this->tax->calculate($result_info['price'], $result_info['tax_class_id']), $currency_code, $currency_value, false) . '</price>' . "\n";
                }


                if($result_info['sku']) {
                    $output .= '<vendorCode>' . $result_info['sku'] . '</vendorCode>' . "\n";
                }
                $output .= '<currencyId>'. $currency_code .'</currencyId>' . "\n";

                $result_brend = $this->model_extension_feed_multisearch->getProductsBrend($result_info['brend_id']);

                if($result_brend){
                    $output .= '<vendor>'.  $result_brend .'</vendor>' . "\n";
                }else{
                    $output .= '<vendor>SMART ZONE</vendor>' . "\n";
                }

                $result_info['image'] = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $result_info['image']);
                $output .= '<picture>'. HTTPS_SERVER . 'image/' . $result_info['image']  .'</picture>' . "\n";
                $result_category = $this->model_extension_feed_multisearch->getProductCategory($result_product);
                if($result_category) {
                    if(count($result_category) > 1){
                        $output .= '<categories>' . "\n";
                        foreach ($result_category as $result_cat) {
                            $output .= '<categoryId>' . $result_cat['category_id'] . '</categoryId>' . "\n";
                        }
                        $output .= '</categories>' . "\n";
                    }else{
                        foreach ($result_category as $result_cat) {
                            $output .= '<categoryId>' . $result_cat['category_id'] . '</categoryId>' . "\n";
                        }
                    }
                }

                $results_atribute = $this->model_extension_feed_multisearch->getProductAtribute($result_product);
                if($results_atribute){
                    foreach($results_atribute as $result_atribute) {
                        $atribute_name = explode(';', $result_atribute['text']);
                        $text_name = $this->model_extension_feed_multisearch->getAtribute($result_atribute['attribute_id']);
                        $text_name = strip_tags($text_name);
                        $text_name = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $text_name);
                        $text_name = html_entity_decode($text_name, ENT_QUOTES);
                        $text_name = htmlspecialchars($text_name, ENT_QUOTES);
                        $text_name = addslashes($text_name);
                        if(!empty($text_name)) {
                            if(count($atribute_name) > 0){
                                for ($x = 0; $x < count($atribute_name); $x++){
                                    if(strlen($atribute_name[$x]) > 0) {
                                        $text = strip_tags($atribute_name[$x]);
                                        $text = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $text);
                                        $text = html_entity_decode($text, ENT_QUOTES);
                                        $text = htmlspecialchars($text, ENT_QUOTES);
                                        $text = addslashes($text);
                                        $output .= '<param name="' . trim($text_name) . '">' . trim($text) . '</param>' . "\n";
                                    }
                                }
                            }else{
                                $text = strip_tags($atribute_name);
                                $text = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $text);
                                $text = html_entity_decode($text, ENT_QUOTES);
                                $text = htmlspecialchars($text, ENT_QUOTES);
                                $text = addslashes($text);
                                $output .= '<param name="' . trim($text_name) . '">' . trim($text) . '</param>' . "\n";
                            }
                        }
                    }
                }
                $output .= '</offer>' . "\n";
            }
        }
        $output .= '</offers>' . "\n";
        $output .= '</shop>' . "\n";
        $output .= '</yml_catalog>' . "\n";
        $dom_xml = new DomDocument();
        $dom_xml->loadXML($output);
        $path = 'google_base_xml/' . "diginetica.xml";
        echo $dom_xml->save($path);
    }
}
