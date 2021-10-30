<?php
class ControllerExtensionModuleImportYml extends Controller {
  private $error = array();

  private $categoryMap = array();

  private $columnsUpdate = array();

  private $skuProducts = array();

  private $flushCount = 30;

  private $file;

  private $fileXML;

  private $settings = array();

  private $productsAdded = 0;

  private $productsUpdated = 0;

  private $productsNotDelete = array();

  public function index()
  {
    set_time_limit(0);
    $this->load->language('extension/module/import_yml');
    $this->document->setTitle($this->language->get('heading_title'));

    $this->load->model('extension/module/import_yml');
    $this->load->model('catalog/product');
    $this->load->model('catalog/manufacturer');
    $this->load->model('catalog/category');
    $this->load->model('catalog/attribute');
    $this->load->model('catalog/attribute_group');
    $this->load->model('localisation/language');
    $this->load->model('setting/setting');

    if(isset($this->request->get['profile_id'])) {
      $data['settings'] = $this->settings = json_decode($this->model_extension_module_import_yml->getProfile($this->request->get['profile_id']), true);
    } else {
      $data['settings'] = $this->settings = $this->request->post;
    }
    if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {

      $file = DIR_DOWNLOAD . 'import.yml';

      if ((isset( $this->request->files['import_yml_upload'] )) && (is_uploaded_file($this->request->files['import_yml_upload']['tmp_name']))) {
        move_uploaded_file($this->request->files['import_yml_upload']['tmp_name'], $file);
      } elseif (!empty($this->request->post['import_yml_url'])) {
        if (filter_var($this->request->post['import_yml_url'], FILTER_VALIDATE_URL) && $this->is_url_exist(htmlspecialchars_decode($this->request->post['import_yml_url']))){
          $file_content = file_get_contents(htmlspecialchars_decode($this->request->post['import_yml_url']));
          file_put_contents($file, $file_content);
        } else {
          $this->error['warning'] = $this->language->get('error_empty');
        }
      } else {
        $this->error['warning'] = $this->language->get('error_empty');
      }

      if (isset($this->error['warning'])) {
        $data['error_warning'] = $this->error['warning'];
      } else {

        //$force = (isset($this->request->post['import_yml_force']) && $this->request->post['import_yml_force'] == 'on');
        if (!empty($this->request->post)) {
          $this->columnsUpdate = $this->request->post;
        }

        $this->session->data['success'] = $this->language->get('text_success');

        $this->parseFile($file);

        $this->session->data['success'] = sprintf(
        $this->language->get('text_success'),
        $this->productsAdded,
        $this->productsUpdated
        );

      }
    }

    $data['heading_title'] = $this->language->get('heading_title');
    $data['entry_restore'] = $this->language->get('entry_restore');
    $data['entry_url'] = $this->language->get('entry_url');
    $data['entry_description'] = $this->language->get('entry_description');
    $data['entry_force'] = $this->language->get('entry_force');
    $data['entry_update'] = $this->language->get('entry_update');
    $data['entry_field_name'] = $this->language->get('entry_field_name');
    $data['entry_field_description'] = $this->language->get('entry_field_description');
    $data['entry_field_category'] = $this->language->get('entry_field_category');
    $data['entry_field_price'] = $this->language->get('entry_field_price');
    $data['entry_field_image'] = $this->language->get('entry_field_image');
    $data['entry_field_manufacturer'] = $this->language->get('entry_field_manufacturer');
    $data['entry_field_attribute'] = $this->language->get('entry_field_attribute');
    $data['entry_save_settings'] = $this->language->get('entry_save_settings');
    $data['button_import'] = $this->language->get('button_import');
    $data['button_save'] = $this->language->get('button_save');
    $data['tab_general'] = $this->language->get('tab_general');

    $data['save'] = $this->url->link('extension/module/import_yml/save', 'token=' . $this->session->data['token'], true);
    $data['add_profile'] =  str_replace("&amp;", "&", $this->url->link('extension/module/import_yml/addProfile', 'token=' . $this->session->data['token'], true));
    $data['update_profile'] =  str_replace("&amp;", "&", $this->url->link('extension/module/import_yml/updateProfile', 'token=' . $this->session->data['token'], true));
    $data['get_profile'] =  str_replace("&amp;", "&", $this->url->link('extension/module/import_yml/getProfile', 'token=' . $this->session->data['token'], true));
    $data['delete_profile'] =  str_replace("&amp;", "&", $this->url->link('extension/module/import_yml/deleteProfile', 'token=' . $this->session->data['token'], true));
    $data['action'] =  str_replace("&amp;", "&", $this->url->link('extension/module/import_yml', 'token=' . $this->session->data['token'], true));

    $data['profiles'] = $this->model_extension_module_import_yml->getProfiles();

    if(isset($this->request->get['profile_id'])) {
      $data['id'] = $this->request->get['profile_id'];
      $data['profile_name'] = $this->model_extension_module_import_yml->getProfileName($this->request->get['profile_id']);
    } else {
      $data['id'] = 0;
    }

     if (isset($this->error['warning'])) {
      $data['error_warning'] = $this->error['warning'];
    } else {
      $data['error_warning'] = '';
    }

    if (isset($this->session->data['success'])) {
      $data['success'] = $this->session->data['success'];

      unset($this->session->data['success']);
    } else {
      $data['success'] = '';
    }

    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
      'text'      => $this->language->get('text_home'),
      'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
    );

    $data['breadcrumbs'][] = array(
      'text'      => $this->language->get('heading_title'),
      'href'      => $this->url->link('extension/module/import_yml', 'token=' . $this->session->data['token'], true),
    );

    $data['action'] = $this->url->link('extension/module/import_yml', 'token=' . $this->session->data['token'], true);

    $data['export'] = $this->url->link('extension/module/import_yml/download', 'token=' . $this->session->data['token'], true);

    $data['header'] = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer'] = $this->load->controller('common/footer');

    $this->response->setOutput($this->load->view('extension/module/import_yml.tpl', $data));
  }

  private function is_url_exist($url){
    set_time_limit(0);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if($code == 200){
       $status = true;
    }else{
      $status = false;
    }
    curl_close($ch);
   return $status;
  }

  private function parseFile($file, $force = false, $cli = false)
  {
    set_time_limit(0);
    $this->load->model('extension/module/import_yml');

    $xmlstr = file_get_contents($file);
    $xml = new SimpleXMLElement($xmlstr, LIBXML_COMPACT | LIBXML_PARSEHUGE);

    $this->fileXML = $xml;

    $result = $this->model_extension_module_import_yml->loadProductsByPrefix($this->settings['import_yml_prefix']);
    if (!empty($result)) {
      foreach ($result as $row) {
    $this->skuProducts[ $row['model'] ] = $row['product_id'];
      }
    }

    // Prepare big file upload feature
    if (!$cli) {

      if (empty($this->settings['import_yml_file_hash']) || $this->settings['import_yml_file_hash'] != md5($this->file)) {
        $new_arr = array(
            'import_yml_file_hash' => md5($this->file),
            'import_yml_file_name' => DIR_DOWNLOAD . 'import.yml',
            'import_yml_loaded' => 0
          );
          $this->settings = array_merge($this->settings, $new_arr);
      }

      if (!empty($this->columnsUpdate['import_yml_category'])) {
        $this->addCategories($xml->shop->categories, true);
      }

    }

    $this->addProducts($xml->shop->offers, $force, $cli);

  }

  private function addCategories($categories, $use_prfix_category = false) {
    set_time_limit(0);
    $this->categoryMap[0] = array(
      'category_id'   => 0,
      'name'      => 0
    );

    $languages = $this->model_localisation_language->getLanguages();
    $categoriesList = array();

    if($use_prfix_category) {

      $prefix_category_id = 99999;

      // создаем категорию с префиксом
      $categoriesList[$prefix_category_id] = array(
          'parent_id'   => 0,
          'name'        => trim($this->settings['import_yml_prefix'])
      );

    }

    foreach ($categories->category as $category) {

        $categoriesList[ (string)$category['id'] ] = array(
            'parent_id'   => $use_prfix_category ? ($category['parentId'] == 0 ? $prefix_category_id : (int)$category['parentId']) : (int)$category['parentId'],
            'name'        => trim((string)$category)
        );
    }

    //print_r($this->settings); exit();

    // Compare categories level by level and create new one, if it doesn't exist
    while (count($categoriesList) > 0) {
      $previousCount = count($categoriesList);
      foreach ($categoriesList as $source_category_id => $item) {

        if (array_key_exists((int)$item['parent_id'], $this->categoryMap)) {

              $category = $this->model_extension_module_import_yml->loadCategory($this->categoryMap[$item['parent_id']]['category_id'], $item['name']);

            if ($category->row) {
              $this->categoryMap[(int)$source_category_id] = array(
                'category_id'   => $category->row['category_id'],
                'name'      => $item['name']
              );
            } else {

              $category_data = array (
                'sort_order' => 0,
                'parent_id' => $this->categoryMap[ (int)$item['parent_id'] ]['category_id'],
                'top' => 0,
                'status' => 1,
                'column' => '',
                'keyword' => $this->translitText($item['name']),
                'category_store' => array(0),
              );
              $iterator_cat = 1;
              foreach ($languages as $language) {
                $category_data['category_description'][ $language['language_id'] ] = array (
                  'name' => $item['name'],
                  'series_name' => $item['name'],
                  'additional_input'  => '',
                  'additional_input2'  => '',
                  'meta_title' => $item['name'],
                  'meta_h1' => $item['name'],
                  'meta_keyword' => '',
                  'meta_description' => '',
                  'description' => ''
                );
                $iterator_cat++;
              }

              if ($category_data['parent_id'] == 0) {
                $category_data['top'] = 1;
              }

              $this->categoryMap[(int)$source_category_id] = array(
                'category_id' => $this->model_catalog_category->addCategory($category_data),
                'name'      => $item['name']
              );
            }
            unset($categoriesList[$source_category_id]);
        }
      }

      if (count($categoriesList) === $previousCount) {
        break;
      }
    }
  }

  private function addProducts($offers, $force = false, $cli = false) {
    set_time_limit(0);
    $parse_log = new Log('import_yml.log');
    $parse_log->write('Start update products' . date("Y-m-d H:i:s"));


    $this->error['warning'] = "";
    $languages = $this->model_localisation_language->getLanguages();

    // get first attribute group
    $res = $this->model_extension_module_import_yml->loadAttributeGroup();
    if (!$res->row) {
      $attr_group_data = array (
        'sort_order' => 0,
      );
      foreach ($languages as $language) {
        $attr_group_data['attribute_group_description'][ $language['language_id'] ] = array (
          'name' => 'Характеристики'
        );
      }
      $attrGroupId = $this->model_catalog_attribute_group->addAttributeGroup($attr_group_data);
    } else {
      $attrGroupId = (int)$res->row['attribute_group_id'];
    }

    if (!is_dir(DIR_IMAGE . 'catalog/import_yml')) {
        mkdir(DIR_IMAGE . 'catalog/import_yml');
    }

    $vendorMap = $this->model_extension_module_import_yml->loadManufactures();

    $attrMap = $this->model_extension_module_import_yml->loadAttributes();

    if (!$cli && !empty($this->settings)) {
      $start = (int)$this->settings['import_yml_loaded'];
    } else {
      $start = 0;
    }

    if($this->settings['import_yml_separate_start'] != 0 || !empty($this->settings['import_yml_separate_start'])) {
      $start = (int)$this->settings['import_yml_separate_start'];
    }


    //Here is start adding products
    $n = count($offers->offer);
    $flushCounter = $this->flushCount;

    if($this->settings['import_yml_separate_end'] != 0 && $this->settings['import_yml_separate_end'] < $n || !empty($this->settings['import_yml_separate_end'])) {
      $n = (int)$this->settings['import_yml_separate_end'];
    }

    for ($i = $start; $i < $n; $i++) {
      $offer = $offers->offer[ $i ];

      if(!empty($offer->barcode)) $offer_id = (string)$offer->barcode; else $offer_id = (string)$offer['id'];


      $product_images = array();

      $dir_name = 'catalog/import_yml/' . $this->settings['import_yml_prefix'] .'/' . implode('/', str_split($offer_id, 20)) . '/';
      if (!is_dir(DIR_IMAGE . $dir_name)) {
        mkdir(DIR_IMAGE . $dir_name, 0777, true);
      }

      foreach ($offer->picture as $picture) {
        $picture = trim(str_replace(array("\n", "\r"), '', (string)$picture));
        $image_arr = pathinfo($picture);
        if (isset($image_arr['extension'])) {
          if (strlen($image_arr['extension']) < 5) {
            $extension = $image_arr['extension'];
          } elseif (strpos($image_arr['extension'], 'jpg') !== false) {
            $extension = 'jpg';
          } elseif (strpos($image_arr['extension'], 'jpeg') !== false) {
            $extension = 'jpeg';
          } elseif (strpos($image_arr['extension'], 'png') !== false){
            $extension = 'png';
          } elseif (strpos($image_arr['extension'], 'gif') !== false){
            $extension = 'gif';
          } elseif (strpos($image_arr['extension'], 'webm') !== false){
            $extension = 'webm';
          } else {
            continue;
          }
        } else {
          continue;
        }
        //$img_name  = $this->translitText($image_arr['filename']).rand(1,9999);
        $img_name  = $this->translitText($image_arr['filename']);
        if (!empty($img_name)) {
          $image = $this->loadImageFromHost($picture, DIR_IMAGE . $dir_name . $img_name . '.' . $extension);
          if ($image) {
            $product_images[] = array('image' => $dir_name . $img_name . '.' . $extension, 'sort_order' => count($product_images),'is_rotator'=>'','video'=>'','option_id'=>'');
          }
        }
      }

      $image_path = array_shift($product_images);
      if (is_array($image_path)) {
        $image_path = $image_path['image'];
      }

      // загружаем только изображения

      if(isset($this->settings['import_yml_load_image'])) {
        $this->productsUpdated++;
        continue;
      }

      $productName = (string)$offer->name;
      if (!$productName) {
        if (isset($offer->typePrefix)) {
          $productName = (string)$offer->typePrefix . ' ' . (string)$offer->model;
        } else {
          $productName = (string)$offer->model;
        }
      }

      $product_description  = array();
      foreach ($languages as $language) {
        $product_description[ $language['language_id'] ] = array (
          'name' => $productName,
          'meta_title' => $productName,
          'meta_h1' => $productName,
          'meta_keyword' => '',
          'meta_description' => '',
          'description' => (string)$offer->description,
          'tag' => '',
        );
      }

      $id_category = array();
      if ((int)$offer->categoryId == 0 || !isset($this->categoryMap[(int)$offer->categoryId])) {
        foreach ($this->categoryMap as $key => $cat) {
          if (in_array((string)$offer->categoryId, $cat)){
            array_push($id_category, $cat['category_id']);
          }
        }
      } else {
        $cats = $offer->categoryId;
        foreach ($cats as $cat) {
          array_push($id_category, $this->categoryMap[(int)$cat]['category_id']);
        }
      }
      $price = (float)$offer->price;
      if(isset($special)) unset($special);
      if($offer->price_old) {
        $special = array(
          'customer_group_id' => 1,
          'priority'  => '',
          'price' => (float)$offer->price,
          'date_start'  => '',
          'date_end'  => ''
        );
        $price = (float)$offer->price_old;
      }

      // ключевое поле для идентификации offer_id в yml и isbn на сайте
      $data = array(
        'product_description' => $product_description,
        'product_special' => (isset($special) ? array($special) : array()),
        'product_store' => array(0),
        'main_category_id' => isset($id_category[0]) ? $id_category[0] : 0,
        'product_category' => $id_category,
        'product_attribute' => array(),
        'model' => '1',
        'image' => $image_path,
        'sku'   => '',
        'keyword' => $this->translitText($productName),
        'upc'  => '',
        'ean'  => $this->settings['import_yml_prefix'],
        'jan'  => (!empty($offer->model)) ? (string)$offer->model : ((!empty($offer->vendorCode)) ? (string)$offer->vendorCode : (!empty($offer->barcode)) ? (string)$offer->barcode : ''),
        'isbn' => $offer_id,
        'mpn'  => '',
        'location' => '',
        'quantity' => (!empty($offer->quantity)) ? $offer->quantity : ((isset($offer->outlets->outlet['instock'])) ? (int)$offer->outlets->outlet['instock'] : (($offer['available'] == 'true') ? '999' : '0')),
        'minimum' => '',
        'subtract' => '',
        'stock_status_id' => ($offer['available'] == 'true') ? 7 : 5,
        'date_available' => date('Y-m-d'),
        'manufacturer_id' => '',
        'shipping' => 1,
        'price' => $price,
        'price_zak' => $price,
        'points' => '',
        'weight' => '',
        'weight_class_id' => '',
        'length' => '',
        'width' => '',
        'height' => '',
        'length_class_id' => '',
        'status' => '1',
        'tax_class_id' => '',
        'sort_order' => '',
        'product_image' => $product_images,
        'product_tag' => array(),
        'related_category' => isset($id_category[0]) ? $id_category[0] : array(),
        'currency_id' => '',
        'infoproduct' => '',
        'options_buy' => '',
        'video' => '',
        'short_description' => '',
        'temp_price' => (float)$offer->price,
        'maximum' => '0',
        'noindex' => '1',
        'discont' => '',
        'sticker_custom' => '',
        'option_special' => '',
        'unit_id' => '',
        'size-chart' => '',
        'quantity_shelves'  => '',
        'maximum_weight'  => '',
        'maximum_weight_all'  => '',
        'material_shelves'  => '',
        'model_selection'  => '',
        'color_shelves'  => '',
        'metal_thickness'  => '',
        'type'  => '',
        'series'  => '',
        'brand'  => '',
        'diameter_of_pot'  => '',
        'depth_of_pot'  => '',
        'visible_carusel'  => '',
        'pickup_city'  => 0,
        'pickup_city_time'  => 0,
        'videos'  => array()

      );

      if (isset($offer->param)) {
        $params = $offer->param;

        foreach ($params as $param) {
          if((string)$param['name'] == 'vendor') {
            $manufacturer_name = (string)$param;
          }
          $attr_name = (string)$param['name'];
          $attr_value = (string)$param;

          if (array_key_exists($attr_name, $attrMap) === false) {
            $attr_data = array (
              'sort_order' => 0,
              'attribute_group_id' => $attrGroupId,
            );

            foreach ($languages as $language) {
              $attr_data['attribute_description'][ $language['language_id'] ] = array (
                'name' => $attr_name
              );
            }

            $attrMap[$attr_name] = $this->model_catalog_attribute->addAttribute($attr_data);
          }

          $attr_value_data = array();
          foreach ($languages as $language) {
            $attr_value_data[ $language['language_id'] ] = array (
              'text' => $attr_value
            );
          }

          $data['product_attribute'][] = array (
            'attribute_id' => $attrMap[$attr_name],
            'product_attribute_description' => $attr_value_data
          );
        }
      }

      if (isset($offer->vendor) || isset($manufacturer_name)) {

        //$vendor_name = (string)$offer->vendor;
        $vendor_name = isset($offer->vendor) ? (string)$offer->vendor : $manufacturer_name;

        if (!isset($vendorMap[$vendor_name])) {
          $manufacturer_data = array (
            'name' => $vendor_name,
            'sort_order' => 0,
            'manufacturer_store' => array(0),
            'keyword' => $this->translitText($vendor_name),
          );

          foreach ($languages as $language) {
            $manufacturer_data['manufacturer_description'][ $language['language_id'] ] = array (
              'name' => $vendor_name,
              'description' => $vendor_name,
              'meta_title' => $vendor_name,
              'meta_h1' => $vendor_name,
              'meta_keyword' => $vendor_name,
              'meta_description' => $vendor_name,
            );
          }

          $vendorMap[$vendor_name] = $this->model_catalog_manufacturer->addManufacturer($manufacturer_data);
        }

        //$data['manufacturer_id'] = $vendorMap[(string)$offer->vendor];
        $data['manufacturer_id'] = $vendorMap[$vendor_name];
      }

      if (array_key_exists($data['isbn'], $this->skuProducts)) {
        $data = $this->changeDataByColumns($this->skuProducts[ $data['isbn'] ], $data);
          $this->model_catalog_product->editProduct($this->skuProducts[ $data['isbn'] ], $data);
          $this->productsUpdated++;
          $parse_log->write('UPADTE '. $data['isbn'].' ' . date("Y-m-d H:i:s"));
      } else {
        $this->skuProducts[ $data['isbn'] ] = $this->model_catalog_product->addProduct($data);
        $this->productsAdded++;
        $parse_log->write('ADD '. $data['isbn'].' ' . date("Y-m-d H:i:s"));
      }

      --$flushCounter;

      if ($flushCounter <= 0) {
        $loaded = $i;

        $new_arr = array(
          'import_yml_file_hash' => md5($this->file),
          'import_yml_offers' => count($offers->offer),
          'import_yml_loaded' => $loaded
        );

        $this->settings = array_merge($this->settings, $new_arr);

        $flushCounter = $this->flushCount;
      }
      // задержка переж следующим обновлением
      //if(!isset($this->settings['import_yml_cron'])) time_nanosleep(0, 700000000);
    }
  }

  private function parseFileCli($file)
  {
    set_time_limit(0);

    $xmlstr_from_url = file_get_contents($file);
    if($xmlstr_from_url) $save_file = file_put_contents(DIR_DOWNLOAD."import.yml", $xmlstr_from_url);
    $xmlstr = file_get_contents(DIR_DOWNLOAD."import.yml");
    if(!$xmlstr) exit();
    $xml = new SimpleXMLElement($xmlstr, LIBXML_PARSEHUGE);

    $this->fileXML = $xml;

    $filter_price = false;

    $result = $this->model_extension_module_import_yml->loadProductsByPrefix($this->settings['import_yml_prefix'], $filter_price);
    if (!empty($result)) {
      foreach ($result as $row) {
        $this->skuProducts[ $row['model'] ] = $row['product_id'];
      }
    }

    $this->addProductsCli($xml->shop->offers);

    // выключаем товары которых нету в файле от поставщика
    $diff = array_diff($this->skuProducts, $this->productsNotDelete);
    if (!empty($diff)) {
      foreach ($diff as $id) {
        $this->model_extension_module_import_yml->disableProducts($id);
      }
    }

    // выключаем товары у которых не заполнен vendor_id
    $result2 = $this->model_extension_module_import_yml->loadProductsByPrefixWithoutISBN($this->settings['import_yml_prefix']);
    if (!empty($result2)) {
      foreach ($result2 as $row) {
        $this->model_extension_module_import_yml->disableProducts($row['product_id']);
      }
    }

  }
  private function addProductsCli($offers) {
    set_time_limit(0);
    $cron_log = new Log('import_yml_test2.log');
    $this->error['warning'] = "";

    $start = 0;

    //Here is start adding products
    $n = count($offers->offer);
    $flushCounter = $this->flushCount;

    for ($i = $start; $i < $n; $i++) {
      $offer = $offers->offer[ $i ];

      if(!empty($offer->barcode)) $offer_id = (string)$offer->barcode; else $offer_id = (string)$offer['id'];

      // fix vendor id 34 distributions
      if($this->settings['import_yml_prefix'] == 'distributions') {
        $this->model_extension_module_import_yml->setProductISBN((string)$offer['id'], (string)$offer->barcode);
      }


      $price = (float)$offer->price;
      if(isset($special)) unset($special);
      if($offer->price_old) {
        $special = array(
          'customer_group_id' => 1,
          'priority'  => '',
          'price' => (float)$offer->price,
          'date_start'  => '',
          'date_end'  => ''
        );
        $price = (float)$offer->price_old;
      }

      if(!empty($offer->quantity)) {
        $quantity = $offer->quantity;
      } elseif(isset($offer->outlets->outlet['instock'])) {
        $quantity = (int)$offer->outlets->outlet['instock'];
      } elseif(isset($offer->stock_quantity) && (int)$offer->stock_quantity != 0) {
        $quantity = $offer->stock_quantity;
      } elseif($offer['available'] == 'true') {
        $quantity = '999';
      } else {
        $quantity = 0;
      }

      if($offer['available'] == 'false' || $offer['available'] == 'out of stock' || $offer['available'] == '') {
        $quantity = 0;
        $available = false;
      } else {
        $available = true;
      }


      $data = array(
        'isbn' => $offer_id,
        'product_special' => (isset($special) ? array($special) : array()),
        'quantity' => $quantity,
        'stock_status_id' => $available ? 7 : 5,
        'price' => $price,
        'vendor_prefix' => $this->settings['import_yml_prefix']
      );

      //$cron_log->write(print_r($data, true));

      if (array_key_exists($data['isbn'], $this->skuProducts)) {
        $this->model_extension_module_import_yml->updateQuantityProduct($this->skuProducts[ $data['isbn'] ], $data);
        $this->productsNotDelete[ $data['isbn'] ] = $this->skuProducts[ $data['isbn'] ];
        $cron_log->write('update VENDOR_ID '.$data['isbn']);
      } else {
        // выключаем товар
        $this->model_extension_module_import_yml->setProductStatus($this->model_extension_module_import_yml->getProductIdByIsbn($data['isbn']), $data);
         $cron_log->write('disable VENDOR_ID '.$offer_id);
      }

      --$flushCounter;

      if ($flushCounter <= 0) {
        $loaded = $i;

        $new_arr = array(
          'import_yml_file_hash' => md5($this->file),
          'import_yml_offers' => count($offers->offer),
          'import_yml_loaded' => $loaded
        );

        $this->settings = array_merge($this->settings, $new_arr);

        $flushCounter = $this->flushCount;
      }

    }
  }

  private function loadImageFromHost($link, $img_path)
  {
    set_time_limit(0);
    if (!file_exists($img_path) || !filesize($img_path)) {
      $link = str_replace(' ', '%20', $link);

      $ch = curl_init();

      $options = array(
        CURLOPT_URL => $link,
        CURLOPT_HEADER => 0,
        CURLOPT_BINARYTRANSFER=>1,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER  => false,
        CURLOPT_RETURNTRANSFER => true
      );

      curl_setopt_array($ch, $options);

      $content_image = curl_exec($ch);
      curl_close($ch);

      // save image
      $fp = fopen($img_path,'wb');
      fwrite($fp, $content_image);
      fclose($fp);

      return file_exists($img_path);
    }

    return true;
  }

  private function rrmdir($dir)
  {
    set_time_limit(0);
    foreach(glob($dir . '/*') as $file) {
      if(is_dir($file))
          rrmdir($file);
      else
          unlink($file);
    }
    rmdir($dir);
  }

  private function changeDataByColumns($product_id, $data)
  {
    set_time_limit(0);
    $productData = $this->model_catalog_product->getProduct($product_id);
    if (empty($this->columnsUpdate['import_yml_name'])||empty($this->columnsUpdate['import_yml_description'])) {
      $productDescrData = $this->model_catalog_product->getProductDescriptions($product_id);
      $languages = $this->model_localisation_language->getLanguages();
    }

    if (empty($this->columnsUpdate['import_yml_name'])) {
      foreach ($languages as $language) {
        $data['product_description'][ $language['language_id'] ]['name'] = $productDescrData[ $language['language_id'] ]['name'];
      }
    }

    if (empty($this->columnsUpdate['import_yml_description'])) {
      foreach ($languages as $language) {
        $data['product_description'][ $language['language_id'] ]['description'] = $productDescrData[ $language['language_id'] ]['description'];
        $data['product_description'][ $language['language_id'] ]['meta_title'] = $productDescrData[ $language['language_id'] ]['meta_title'];
        $data['product_description'][ $language['language_id'] ]['meta_description'] = $productDescrData[ $language['language_id'] ]['meta_description'];
        $data['product_description'][ $language['language_id'] ]['meta_keyword'] = $productDescrData[ $language['language_id'] ]['meta_keyword'];
        $data['product_description'][ $language['language_id'] ]['tag'] = $productDescrData[ $language['language_id'] ]['tag'];
      }
    }

    if (empty($this->columnsUpdate['import_yml_category'])) {
      $data['product_category'] = $this->model_catalog_product->getProductCategories($product_id);
      if(isset($productData['main_category_id'])) $data['main_category_id'] = $productData['main_category_id'];
    }

    if (empty($this->columnsUpdate['import_yml_price'])) {
      $data['price'] = $productData['price'];
      if (isset($productData['price_zak'])) $data['price_zak'] = $productData['price_zak'];
      if (isset($productData['currency_id'])) $data['currency_id'] = $productData['currency_id'];
      $data['product_discount'] = $this->model_catalog_product->getProductDiscounts($product_id);
      $data['product_special'] = $this->model_catalog_product->getProductSpecials($product_id);
    }

    if (empty($this->columnsUpdate['import_yml_quantity'])) {
      $data['quantity'] = $productData['quantity'];
    }

    if (empty($this->columnsUpdate['import_yml_image'])) {
      $data['image'] = $productData['image'];
      $data['product_image'] = $this->model_catalog_product->getProductImages($product_id);
    }

    if (empty($this->columnsUpdate['import_yml_manufacturer'])) {
      $data['manufacturer_id'] = $productData['manufacturer_id'];
    }

    if (empty($this->columnsUpdate['import_yml_attributes'])) {
      $data['product_attribute'] = $this->model_catalog_product->getProductAttributes($product_id);
      $data['product_option'] = $this->model_catalog_product->getProductOptions($product_id);
      $data['product_filter'] = $this->model_catalog_product->getProductFilters($product_id);
      $data['product_download'] = $this->model_catalog_product->getProductDownloads($product_id);
      $data['product_related'] = $this->model_catalog_product->getProductRelated($product_id);
    }

    $data['product_layout'] = $this->model_catalog_product->getProductLayouts($product_id);

    $data['sku'] = $this->model_catalog_product->getProductSku($product_id);

    $seoquery =  $this->db->query("SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "'");
    if (isset($seoquery->row)) $data['keyword'] = $seoquery->row['keyword'];

    return $data;
  }

  public function cron()
  {
    $this->load->language('extension/module/import_yml');
    $this->load->model('extension/module/import_yml');
    $this->load->model('catalog/product');
    $this->load->model('catalog/manufacturer');
    $this->load->model('catalog/category');
    $this->load->model('catalog/attribute');
    $this->load->model('catalog/attribute_group');
    $this->load->model('localisation/language');
    $this->load->model('setting/setting');

    $cron_log = new Log('import_yml_cron.log');

    // получить cron_key
    $cron_key = 'fiykT3jwki';
    if(!isset($this->request->get['cron_key']) || $this->request->get['cron_key'] != $cron_key) {
      exit('доступ закрыт, неправильный ключ');
    }

    if(isset($this->request->get['profile_id']) && $this->request->get['profile_id']) {
      $settings = json_decode($this->model_extension_module_import_yml->getProfile($this->request->get['profile_id']), true);

      if(isset($settings['import_yml_cron'])) {
        $this->settings = array(
          'import_yml_url'  => $settings['import_yml_url'],
          'import_yml_price'  => 'on',
          'import_yml_prefix'  => $settings['import_yml_prefix'],
          'import_yml_quantity' => 'on',
          'import_yml_separate_start'   => 0,
          'import_yml_separate_end' => 0
        );
      }
      if(isset($settings['import_yml_prefix'])) $cron_log->write('Cron profile #'.$settings['import_yml_prefix'].' init'); else $cron_log->write('Cron profile #'.$this->request->get['profile_id'].' init');


    }

    if (!empty($this->settings['import_yml_url'])) {

      if (!empty($this->settings)) {
        $this->columnsUpdate = $this->settings;
      }
      $cron_log->write('Start update');
      $this->parseFileCli(htmlspecialchars_decode($this->settings['import_yml_url']));
      $cron_log->write('End update');

      // отключение товаров с нулевой ценой
      $this->model_extension_module_import_yml->disableProductByVendorPrefix($settings['import_yml_prefix']);

      // запись даты обновления
      $this->model_extension_module_import_yml->addTimeUpdate($this->request->get['profile_id']);

    }
  }

  public function save()
  {
    $this->load->model('setting/setting');
    $this->load->language('extension/module/import_yml');

    if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {

      $this->model_setting_setting->editSetting('import_yml', $this->request->post);

      $this->session->data['success'] = $this->language->get('text_settings_success');

      $this->response->redirect($this->url->link('extension/module/import_yml', 'token=' . $this->session->data['token'], true));

     }
  }

  public function addProfile() {
    $json = array();

    $this->load->model('extension/module/import_yml');
    $this->load->language('extension/module/import_yml');

    if ($this->request->server['REQUEST_METHOD'] == 'POST') {

      if (!isset($this->request->post['profile_import_name']) || empty($this->request->post['profile_import_name'])) {
        $json['error'] = 'Укажите имя профиля!';
      }
      if (!isset($this->request->post['import_yml_prefix']) || empty($this->request->post['import_yml_prefix'])) {
        $json['error'] = 'Укажите префикс поставщика!';
      }

      if(!$json) {
        $post = array(
          'profile_import_name' => $this->request->post['profile_import_name'],
          'setting' => json_encode($this->request->post),
        );

        $json['profile_id'] = $this->model_extension_module_import_yml->addProfile($post);
        $json['success'] = 'Профиль успешно добавлен';
      }

    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function updateProfile() {
    $json = array();

    $this->load->model('extension/module/import_yml');
    $this->load->language('extension/module/import_yml');
    if (!isset($this->request->get['profile_id'])) {
      $json['error'] = 'Обновить профиль не удалось';
    }
    if ($this->request->server['REQUEST_METHOD'] == 'POST' && !$json) {

      $post = array(
        'import_yml_profile_name' => $this->request->post['import_yml_profile_name'],
        'setting' => json_encode($this->request->post),
      );

      $updateProfile = $this->model_extension_module_import_yml->updateProfile($post, $this->request->get['profile_id']);
      $json['success'] = $this->request->post;


    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function deleteProfile() {
    $json = array();

    $this->load->model('extension/module/import_yml');
    $this->load->language('extension/module/import_yml');

    if ($this->request->server['REQUEST_METHOD'] == 'POST') {

      if(isset($this->request->post['profile_id'])) {
        $this->model_extension_module_import_yml->deleteProfile($this->request->post['profile_id']);
        $json['success'] = 'Профиль успешно удален';
      } else {
        $json['error'] = 'Ошибка удаления профиля';
      }

    } else {
      $json['error'] = 'Ошибка удаления профиля';
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  public function resume()
  {
    $this->load->model('extension/module/import_yml');
    $this->load->model('setting/setting');
  }

  public function cancel()
  {
    $this->load->model('extension/module/import_yml');
    $this->load->model('setting/setting');

    unlink(DIR_DOWNLOAD . 'import.yml');

    $this->model_setting_setting->editSetting('import_yml', array());

    $this->response->redirect($this->url->link('extension/module/import_yml', 'token=' . $this->session->data['token'], true));
  }

  private function validate()
  {
    if (!$this->user->hasPermission('modify', 'extension/module/import_yml')) {
      $this->error['warning'] = $this->language->get('error_permission');
    }

    /*if (!isset($this->request->post['import_yml_prefix']) || empty($this->request->post['import_yml_prefix'])) {
      $this->error['warning'] = 'Укажите префикс поставщика!';
    }*/
    return !$this->error;
  }
  private function validateProfile() {

    if (!isset($this->request->post['import_yml_profile_name']) || empty($this->request->post['import_yml_profile_name'])) {
      $this->error['warning'] = 'Укажите имя профиля!';
    }
    if (!isset($this->request->post['import_yml_prefix']) || empty($this->request->post['import_yml_prefix'])) {
      $this->error['warning'] = 'Укажите префикс поставщика!';
    }
    return !$this->error;
  }
  private function translitText($string)
  {
    $replace = array(
      "А"=>"A","а"=>"a","Б"=>"B","б"=>"b","В"=>"V","в"=>"v","Г"=>"G","г"=>"g","Д"=>"D","д"=>"d",
      "Е"=>"E","е"=>"e","Ё"=>"E","ё"=>"e","Ж"=>"Zh","ж"=>"zh","З"=>"Z","з"=>"z",
      "И"=>"I","и"=>"i",
      "Й"=>"I","й"=>"i","К"=>"K","к"=>"k","Л"=>"L","л"=>"l","М"=>"M","м"=>"m","Н"=>"N","н"=>"n","О"=>"O","о"=>"o",
      "П"=>"P","п"=>"p","Р"=>"R","р"=>"r","С"=>"S","с"=>"s","Т"=>"T","т"=>"t","У"=>"U","у"=>"u","Ф"=>"F","ф"=>"f",
      "Х"=>"H","х"=>"h","Ц"=>"Tc","ц"=>"tc","Ч"=>"Ch","ч"=>"ch","Ш"=>"Sh","ш"=>"sh","Щ"=>"Shch","щ"=>"shch",
      "Ы"=>"Y","ы"=>"y","Э"=>"E","э"=>"e","Ю"=>"Iu","ю"=>"iu","Я"=>"Ia","я"=>"ia","ъ"=>"","ь"=>"",
      "«"=>"", "»"=>"", "„"=>"", "“"=>"", "“"=>"", "”"=>"", "\•"=>"", "%"=>"", "$"=>"", "_"=>"-", " "=>"-", "."=>"-", ","=>"-",
      "І"=>"I","і"=>"i",
      "Ї"=>"Yi","ї"=>"yi",
      "Є"=>"Ye","є"=>"ye",
    );

    $output = iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
    $output = strtolower($output);
    $output = str_replace(" ", "-", $output);
    $output = preg_replace('~[^-a-z0-9_]+~u', '', $output);
    $output = trim(trim($output, "-"));
    return $output;
  }
}
?>
