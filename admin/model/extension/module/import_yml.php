<?php
class ModelExtensionModuleImportYml extends Model {
  public function loadManufactures() {
    $manufactures = $this->db->query('SELECT * FROM `' . DB_PREFIX  . 'manufacturer`');
    
    $result = array();
    
    foreach ($manufactures->rows as $item) {
      $result[ $item['name'] ] = $item['manufacturer_id'];
    }
    
    return $result;
  }
  
  public function loadAttributes() {
    $attributes = $this->db->query('SELECT * FROM `' . DB_PREFIX  . 'attribute` INNER JOIN `' . DB_PREFIX  . 'attribute_description` ON `' . DB_PREFIX  . 'attribute_description`.attribute_id = `' . DB_PREFIX  . 'attribute`.attribute_id WHERE language_id = 1');
    
    $result = array();
    
    foreach ($attributes->rows as $item) {
      $result[ $item['name'] ] = $item['attribute_id'];
    }
    
    return $result;
  }
  
  public function loadAttributeGroup() {
    $result = $this->db->query('SELECT * FROM `' . DB_PREFIX  . 'attribute_group` ORDER BY `attribute_group_id` LIMIT 0, 1');

    return $result;
  }
  
  public function loadProducts() {
    $result = $this->db->query('SELECT product_id, isbn AS model FROM `' . DB_PREFIX . 'product` WHERE isbn != ""');

    return $result->rows;
  }

  public function loadProductsByPrefix($prefix, $filter_price = false) {
    $sql = "SELECT product_id, isbn AS model FROM `" . DB_PREFIX . "product` WHERE ean LIKE '".$prefix."' AND isbn != ''";
    if($filter_price) $sql .= " AND price > 0";
    $result = $this->db->query($sql);

    return $result->rows;
  }

  public function loadProductsByPrefixWithoutISBN($prefix) {
    $result = $this->db->query("SELECT product_id FROM `" . DB_PREFIX . "product` WHERE ean LIKE '".$prefix."' AND isbn = ''");

    return $result->rows;
  }
  
  public function loadCategory($parent_id, $category_name) {
    $result = $this->db->query('SELECT * FROM `' . DB_PREFIX . 'category` INNER JOIN `' . DB_PREFIX . 'category_description` ON `' . DB_PREFIX . 'category_description`.category_id = `' . DB_PREFIX . 'category`.category_id WHERE parent_id = ' . (int)$parent_id . ' AND `' . DB_PREFIX . 'category_description`.name LIKE "' . $this->db->escape($category_name) . '"');

    return $result;
  }
  public function deleteCategories() {
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "category`");
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "category_description`");
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "category_to_store`");
    
    if (version_compare(VERSION, '1.5.5', '>=')) {
      $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "category_path`");
    }
  }
  
  public function deleteProducts() {
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "product`");
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "product_attribute`");
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "product_description`");
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "product_discount`");
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "product_image`");
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "product_option`");
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "product_option_value`");
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "product_related`");
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "product_reward`");
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "product_special`");
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "product_to_category`");
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "product_to_download`");
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "product_to_layout`");
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "product_to_store`");
    
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "url_alias`");
  }
  
  public function deleteManufactures() {
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "manufacturer`");
    //$this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "manufacturer_description`");
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "manufacturer_to_store`");
  }
  
  public function deleteAttributes() {
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "attribute`");
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "attribute_description`");
  }
  
  public function deleteAttributeGroups() {
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "attribute_group`");
    $this->db->query("TRUNCATE TABLE  `" . DB_PREFIX  . "attribute_group_description`");
  }

  public function addProfile($data) {
     $this->db->query("INSERT INTO `" . DB_PREFIX . "import_yml_profiles` SET name = '".$data['profile_import_name']."', setting = '".$data['setting']."', date_update = ''");
     $profile_id = $this->db->getLastId();
     return $profile_id;
  }
  public function updateProfile($data, $id) {
     $this->db->query("UPDATE `" . DB_PREFIX . "import_yml_profiles` SET name = '".$data['import_yml_profile_name']."', setting = '".$data['setting']."' WHERE id = '".$id."'");
  }
  public function deleteProfile($id) {
     $this->db->query("DELETE FROM `" . DB_PREFIX . "import_yml_profiles` WHERE id = '".$id."'");
  }
  public function getProfile($id) {
    $query = $this->db->query("SELECT setting FROM `" . DB_PREFIX  . "import_yml_profiles` WHERE id='".$id."'");
    return isset($query->row['setting']) ? $query->row['setting'] : false;
  }
  public function getProfileName($id) {
    $query = $this->db->query("SELECT name FROM `" . DB_PREFIX  . "import_yml_profiles` WHERE id='".$id."'");
    return isset($query->row['name']) ? $query->row['name'] : false;
  }
  public function getProfiles() {
     $query = $this->db->query("SELECT * FROM `" . DB_PREFIX  . "import_yml_profiles`");

    return isset($query->rows) ? $query->rows : false;
  }

  public function addTimeUpdate($profile_id) {
     $this->db->query("UPDATE `" . DB_PREFIX . "import_yml_profiles` SET date_update = NOW() WHERE id = '".(int)$profile_id."'");
  }

  public function updatePriceQuantityProducts($product_id, $data) {
    if((int)$data['quantity'] == 0) $status = 0; else $status = 1;
    $this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . (float)$data['price'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', status = '".$status."', quantity = '" . (int)$data['quantity'] . "' WHERE product_id = '" . (int)$product_id . "'");

    $this->db->query("DELETE FROM " . DB_PREFIX . "product_autoload WHERE product_id = '".$product_id."'");
    $this->db->query("INSERT INTO " . DB_PREFIX . "product_autoload SET product_id = '" . (int)$product_id . "', vendor_prefix = '" . $this->db->escape($data['vendor_prefix']) . "'");
    
    $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '".$product_id."'");

    if (isset($data['product_special'])) {
      foreach ($data['product_special'] as $product_special) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
      }
    }

  }

  public function updateQuantityProduct($product_id, $data) {
    if((int)$data['quantity'] == 0) $status = 0; else $status = 1;
    $this->db->query("UPDATE " . DB_PREFIX . "product SET stock_status_id = '" . (int)$data['stock_status_id'] . "', status = '".$status."', quantity = '" . (int)$data['quantity'] . "' WHERE product_id = '" . (int)$product_id . "'");

    $this->db->query("DELETE FROM " . DB_PREFIX . "product_autoload WHERE product_id = '".$product_id."'");
    $this->db->query("INSERT INTO " . DB_PREFIX . "product_autoload SET product_id = '" . (int)$product_id . "', vendor_prefix = '" . $this->db->escape($data['vendor_prefix']) . "'");

  }


  public function setProductStatus($product_id, $data) {

    if((int)$product_id > 0) {
      $this->db->query("UPDATE " . DB_PREFIX . "product SET status = '0', stock_status_id = '" . (int)$data['stock_status_id'] . "', quantity = '" . (int)$data['quantity'] . "' WHERE product_id = '" . (int)$product_id . "'");
      $this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "'");
    }
    

  }

  public function setProductISBN($old_isbn, $new_isbn) {

    $this->db->query("UPDATE " . DB_PREFIX . "product SET isbn = '".(string)$new_isbn."' WHERE isbn = '" . (string)$old_isbn . "'");   

  }

  public function disableProducts($product_id) {
    $this->db->query("UPDATE " . DB_PREFIX . "product SET status = '0', stock_status_id = '5', quantity = '0' WHERE product_id = '" . (int)$product_id . "'");

  }

  public function getProductIdByIsbn($isbn) {
    $query = $this->db->query("SELECT product_id FROM `" . DB_PREFIX  . "product` WHERE isbn = '".$this->db->escape($isbn)."'");
    
    return isset($query->row['product_id']) ? $query->row['product_id'] : false;
  }

  public function disableProductByVendorPrefix($vendor_prefix) {
    $this->db->query("UPDATE `" . DB_PREFIX  . "product` SET status = '0' WHERE `ean` LIKE '".$vendor_prefix."' AND price = '0' AND status = '1'");
    
  }

}
