<?php
class ModelImportBrain extends Model {
	
	private $is_stock = 7;
	private $no_stock = 5;
	
	public function getCategoryInfo($brain_id) {
		$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE brain_id = '" . (int)$brain_id . "' LIMIT 1");

		if($res->num_rows){
			return $res->row;
		}
		
		return false;
	}
	public function getMyTotalPriceUpdated(){
		$res = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "brain_import WHERE is_updated <> '0'");
		return (int)$res->row['total'];
	}
	
	public function getMyTotalPrice(){
		$res = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "brain_import");
		return (int)$res->row['total'];
	}
	
	public function getMyPriceRow(){
		$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "brain_import LIMIT 1");
		return $res->row;
	}
	public function getProductInfo($brain_id) {
		$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE brain_id = '" . (int)$brain_id . "' LIMIT 1");

		if($res->num_rows){
			return $res->row;
		}
		
		return false;
	}
	
	public function getMyCategories($parent_id){
		$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE parent_id = '".$parent_id."'");
		return $res->rows;
	}
	
	public function getMyTotalManufacturers(){
		$res = $this->db->query("SELECT COUNT(manufacturer_id) AS total FROM " . DB_PREFIX . "manufacturer WHERE brain_id > '0'");
		return $res->row['total'];
	}
	
	public function getCategoryByBrainID($brain_id){
		$res = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category WHERE brain_id = '".$brain_id."' LIMIT 1");
		if($res->num_rows){
			return $res->row['category_id'];
		}
		
		return false;
	}
	public function getManufacturerByBrainID($brain_id){
		$res = $this->db->query("SELECT manufacturer_id FROM " . DB_PREFIX . "manufacturer WHERE brain_id = '".$brain_id."' LIMIT 1");
		if($res->num_rows){
			return $res->row['manufacturer_id'];
		}
		
		return false;
	}
	public function getManufacturerNameByBrainID($brain_id){
		$res = $this->db->query("SELECT name FROM " . DB_PREFIX . "manufacturer WHERE brain_id = '".$brain_id."' LIMIT 1");
		if($res->num_rows){
			return $res->row['name'];
		}
		
		return '';
	}
	public function getManufacturerByName($name){
		$res = $this->db->query("SELECT manufacturer_id FROM " . DB_PREFIX . "manufacturer_description WHERE
								LCASE(name) = '" . $this->db->escape(utf8_strtolower($name)) . "' LIMIT 1");
		if($res->num_rows){
			return $res->row['manufacturer_id'];
		}
		
		return false;
	}
	
	public function updateManufacturerBrainId($manufacturer_id, $brain_id) {

		$this->db->query("UPDATE " . DB_PREFIX . "manufacturer SET brain_id = '" . (int)$brain_id . "'
						 WHERE manufacturer_id = '" . $this->db->escape($manufacturer_id) . "'");

	}
	public function addManufacturer($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer SET name = '" . $this->db->escape($data['name']) . "',brain_id = '" . (int)$data['vendorID'] . "',sort_order = '0'");

		$manufacturer_id = $this->db->getLastId();

		$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_description SET manufacturer_id = '" . (int)$manufacturer_id . "',
						 language_id = '1',
						 name = '" . $this->db->escape($data['name']) . "',
						 meta_title = '" . $this->db->escape($data['name']) . "',
						 meta_h1 = '" . $this->db->escape($data['name']) . "',
						 meta_description = '',
						 meta_keyword = '" . $this->db->escape($data['name']) . "'");

		$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_description SET manufacturer_id = '" . (int)$manufacturer_id . "',
						 language_id = '3',
						 name = '" . $this->db->escape($data['name']) . "',
						 meta_title = '" . $this->db->escape($data['name']) . "',
						 meta_h1 = '" . $this->db->escape($data['name']) . "',
						 meta_description = '',
						 meta_keyword = '" . $this->db->escape($data['name']) . "'");

						 
		$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET manufacturer_id = '" . (int)$manufacturer_id . "', store_id = '0'");

		$keyword = $this->translitArtkl($data['name']);
		$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . (int)$manufacturer_id . "', keyword = '" . $this->db->escape($keyword) . "'");

		$this->cache->delete('manufacturer');

		return $manufacturer_id;
	}
	
	
	
	public function getNullProducts(){
		$res = $this->db->query("SELECT product_id, image FROM " . DB_PREFIX . "product WHERE brain_id > '0' AND quantity = '0' AND stock_status_id='".$this->no_stock."'");
		return $res->rows;
	}
	
	
	public function deleteImageCategory($name){
		$image_full_path = DIR_IMAGE.'catalog/'.'BR/'.$name;
		
		if(file_exists($image_full_path)){ 
			rmdir($image_full_path);
		}
	}
	public function deleteImage($image){
		
		$image_full_path = DIR_IMAGE.$image;
		
		if(file_exists($image_full_path)){ 
			unlink($image_full_path);
		}
			
	}
	
	public function getProductImages($product_id){
		$res = $this->db->query("SELECT image FROM " . DB_PREFIX . "product_image WHERE product_id = '".$product_id."'");
		return $res->rows;
	}
	
	public function getMyTotalCategories(){
		$res = $this->db->query("SELECT COUNT(category_id) AS total FROM " . DB_PREFIX . "category WHERE brain_id > '0'");
		return $res->row['total'];
	}
	
	public function getMyTotalProducts(){
		$res = $this->db->query("SELECT COUNT(product_id) AS total FROM " . DB_PREFIX . "product WHERE brain_id > '0'");
		return $res->row['total'];
	}
	
	public function clearBrainPrices(){
		$this->db->query("DELETE FROM " . DB_PREFIX . "brain_import");
	}
	
	public function addBrainPrice($target_id, $data) {
	
		$this->db->query("INSERT INTO " . DB_PREFIX . "brain_import SET
						 brain_id = '" . (int)$data['ProductID'] . "',
						 target_id = '" . (int)$target_id . "',
						 stock = '" . (int)$data['Stock'] . "',
						 d_days = '" . (int)$data['DayDelivery'] . "',
						 zakup = '" . (float)$data['vendorID'] . "',
						 price = '" . (float)$data['PriceUSD'] . "',
						 date = NOW(),
						 sort_order = '0'");
		
	}

	public function updateProduct($product_id, $data, $description_ru, $description_ua){
		
		$available = 0;
		
		if(count($data['available']) > 0){
			foreach($data['available'] as $item){
				if($available < (int)$item){
					$available = (int)$item;
				}
			}
		}
		
		if($available == 2){
			$available = 5;
		}elseif($available == 3){
			$available = 10;
		}
	
		//Если товара нет, но есть массив с датами ожидания
		$stock = ((count($data['available']) > 0) ? $this->is_stock : $this->no_stock);
		if($available == 0 AND count($data['stocks_expected']) > 0){
			$stock = $this->order_stock;
		}	
		
		$sql = "UPDATE " . DB_PREFIX . "product SET
						quantity = '" . (int)$available . "',
						stock_status_id = '" . (int)$stock . "',
						price = '" . (float)$data['retail_price_uah'] . "',
						price_base = '" . (float)$data['price_uah'] . "'
						WHERE product_id = '".(int)$product_id."'
					";
		$this->db->query($sql);
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		if(isset($description_ru['options']) AND count($description_ru['options'])){
			
			foreach($description_ru['options'] as $index => $row){
				$attribute_id = $this->getAttributeIdOnName($row['name'], $description_ua['options'][$index]['name']);

				// ================================================
				$language_id = 1;	
				$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$attribute_id . "' AND language_id = '" . (int)$language_id . "' LIMIT 1");
				if($res->num_rows){
					$row['value'] = $res->row['text'].';'.$row['value'];
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$attribute_id . "' AND language_id = '" . (int)$language_id . "' LIMIT 1");
				}
			
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "',
								 attribute_id = '" . (int)$attribute_id . "',
								 language_id = '" . (int)$language_id . "',
								 text = '" .  $this->db->escape($row['value']) . "'");


				// ================================================			
				$language_id = 3;
				$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$attribute_id . "' AND language_id = '" . (int)$language_id . "' LIMIT 1");
				if($res->num_rows){
					$row['value'] = $res->row['text'].';'.$row['value'];
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$attribute_id . "' AND language_id = '" . (int)$language_id . "' LIMIT 1");
				}
			
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "',
								 attribute_id = '" . (int)$attribute_id . "',
								 language_id = '" . (int)$language_id . "',
								 text = '" .  $this->db->escape($description_ua['options'][$index]['value']) . "'");
			}
		}
		
		return $product_id;
	}
	
	public function updateImagesProduct($product_id, $images){
		
		$data = array();
		$data['image'] = array();
		$image = 'catalog/'.'BR';
		$image_full_path = DIR_IMAGE.'catalog/'.'BR';
		
		if(!file_exists($image_full_path)){ //Если нет даже папки - создадим
			mkdir($image_full_path,0777);
			chmod($image_full_path,0777);
		}
		
		$image .= '/'.$product_id;
		$image_full_path .= '/'.$product_id;
	
		foreach($images as $row){
			
			$tmp = explode('/', $row['large_image']);
			$image_name = $tmp[count($tmp)-1];
		
			if(!file_exists($image_full_path)){ //Если нет даже папки - создадим
				mkdir($image_full_path,0777);
				chmod($image_full_path,0777);
			}
			
			if(!file_exists($image_full_path.'/'.$image_name)){				
				if(!file_put_contents($image_full_path.'/'.$image_name, file_get_contents($row['large_image']))){
					//echo 'Не удалось загрузить фаил - '.$data['large_image'];
					//unset($product['images'][$index]);
				}else{
					$data['image'][] = $image.'/'.$image_name;
				}
			}else{
				$data['image'][] = $image.'/'.$image_name;
			}
		}
		
		if(count($data['image']) > 0){
			$image = array_shift($data['image']);
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($image) . "' WHERE product_id = '" . (int)$product_id . "'");
		}
		
		if(count($data['image']) > 0){
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");
			foreach($data['image'] as $image){
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET image = '" . $this->db->escape($image) . "', product_id = '" . (int)$product_id . "'");
			}
		}
		
	}
	public function addProduct($data, $description_ru, $description_ua){
		
		$available = 0;
		
		if(count($data['available']) > 0){
			foreach($data['available'] as $item){
				if($available < (int)$item){
					$available = (int)$item;
				}
			}
		}

		if($available == 2){
			$available = 5;
		}elseif($available == 3){
			$available = 10;
		}

		//Если товара нет, но есть массив с датами ожидания
		$stock = ((count($data['available']) > 0) ? $this->is_stock : $this->no_stock);
		if($available == 0 AND count($data['stocks_expected']) > 0){
			$stock = $this->order_stock;
		}
	
		$sql = "INSERT INTO " . DB_PREFIX . "product SET
						model = '" . $this->db->escape($data['product_code']) . "',
						jan = '" . $this->db->escape($data['articul']) . "',
						isbn = '" . $this->db->escape($data['productID']) . "',
						brain_id = '" . $this->db->escape($data['productID']) . "',
						
						quantity = '" . (int)$available. "',
						minimum = '1',
						subtract = '1',
						stock_status_id = '" . (int)$stock . "',
						date_available = 'NOW()',
						manufacturer_id = '" . $this->getManufacturerByBrainID($data['vendorID']) . "',
						vendor = 'Brain',
						shipping = '1',
						price = '" . (float)$data['retail_price_uah'] . "',
						price_base = '" . (float)$data['price_uah'] . "',
						points = '0',
						status = '1',
						tax_class_id = '0',
						sort_order = '0',
						visible_carusel = '0',
						date_added = NOW()";
	
	
		$this->db->query($sql);

		$product_id = $this->db->getLastId();

		$value = $description_ru;
		$language_id = 1;
		$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "',
						 language_id = '" . (int)$language_id . "',
						 name = '" . $this->db->escape($value['name']) . "',
						 description = '" . $this->db->escape($value['brief_description'].' '.$value['description']) . "',
						 tag = '" . $this->db->escape($value['name']) . "',
						 meta_title = '" . $this->db->escape($value['name']) . "',
						 meta_h1 = '" . $this->db->escape($value['name']) . "',
						 meta_description = '" . $this->db->escape($value['name']) . "',
						 meta_keyword = '" . $this->db->escape($value['name']) . "'");
		
		$value = $description_ua;
		$language_id = 3;
		$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "',
						 language_id = '" . (int)$language_id . "',
						 name = '" . $this->db->escape($value['name']) . "',
						 description = '" . $this->db->escape($value['brief_description'].' '.$value['description']) . "',
						 tag = '" . $this->db->escape($value['name']) . "',
						 meta_title = '" . $this->db->escape($value['name']) . "',
						 meta_h1 = '" . $this->db->escape($value['name']) . "',
						 meta_description = '" . $this->db->escape($value['name']) . "',
						 meta_keyword = '" . $this->db->escape($value['name']) . "'");
		
		/*
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . $this->db->escape($data['image']) . "' WHERE product_id = '" . (int)$product_id . "'");
		}
		*/

		$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '0'");
	
		$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");
		if(isset($description_ru['options']) AND count($description_ru['options'])){
			
			foreach($description_ru['options'] as $index => $row){
				$attribute_id = $this->getAttributeIdOnName($row['name'], $description_ua['options'][$index]['name']);

				// ================================================
				$language_id = 1;	
				$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$attribute_id . "' AND language_id = '" . (int)$language_id . "' LIMIT 1");
				if($res->num_rows){
					$row['value'] = $res->row['text'].';'.$row['value'];
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$attribute_id . "' AND language_id = '" . (int)$language_id . "' LIMIT 1");
				}
			
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "',
								 attribute_id = '" . (int)$attribute_id . "',
								 language_id = '" . (int)$language_id . "',
								 text = '" .  $this->db->escape($row['value']) . "'");


				// ================================================			
				$language_id = 3;
				$res = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$attribute_id . "' AND language_id = '" . (int)$language_id . "' LIMIT 1");
				if($res->num_rows){
					$row['value'] = $res->row['text'].';'.$row['value'];
					$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$attribute_id . "' AND language_id = '" . (int)$language_id . "' LIMIT 1");
				}
			
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . (int)$product_id . "',
								 attribute_id = '" . (int)$attribute_id . "',
								 language_id = '" . (int)$language_id . "',
								 text = '" .  $this->db->escape($description_ua['options'][$index]['value']) . "'");
			}
		}

	
		/*	
		if (isset($data['product_image'])) {
			foreach ($data['product_image'] as $product_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape($product_image['image']) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");
			}
		}
		*/
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', main_category = 1, 
								 category_id = '" . (int)$this->getCategoryByBrainID($data['categoryID']) . "'");

		$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_layout SET product_id = '" . (int)$product_id . "', store_id = '0', layout_id = '0'");

		$keyword = $this->translitArtkl($data['name']);
		$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($keyword) . "'");

		$this->cache->delete('product');

		return $product_id;
		
	}
	
	public function getAttributeIdOnName($name, $name_ua){
		
		$res = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "attribute_description WHERE
									LCASE(name) = '" . $this->db->escape(utf8_strtolower($name)) . "' LIMIT 1");
		
		if($res->num_rows > 0){
			return (int)$res->row['attribute_id'];
		}
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "attribute SET attribute_group_id = '8', sort_order = '0'");

		$attribute_id = $this->db->getLastId();

		$language_id = 1;
		$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($name) . "'");
		$language_id = 3;
		$this->db->query("INSERT INTO " . DB_PREFIX . "attribute_description SET attribute_id = '" . (int)$attribute_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($name_ua) . "'");

		return $attribute_id;
		
	}
	
	public function addCategory($data) {
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "category SET
						 parent_id = '" . (int)$data['parent_id'] . "',
						 brain_id = '" . (int)$data['categoryID'] . "',
						 `top` = '0',
						 `column` = '1',
						 sort_order = '0',
						 status = '1',
						 date_modified = NOW(), date_added = NOW()");

		$category_id = $this->db->getLastId();

		$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "',
						 language_id = '1',
						 name = '" . $this->db->escape($data['name']) . "',
						 meta_title = '" . $this->db->escape($data['name']) . "',
						 meta_h1 = '" . $this->db->escape($data['name']) . "',
						 meta_description = '" . $this->db->escape($data['name']) . "',
						 meta_keyword = '" . $this->db->escape($data['name']) . "'");
		$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "',
						 language_id = '3',
						 name = '" . $this->db->escape($data['name_ua']) . "',
						 meta_title = '" . $this->db->escape($data['name_ua']) . "',
						 meta_h1 = '" . $this->db->escape($data['name_ua']) . "',
						 meta_description = '" . $this->db->escape($data['name_ua']) . "',
						 meta_keyword = '" . $this->db->escape($data['name_ua']) . "'");
	
		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$data['parent_id'] . "' ORDER BY `level` ASC");

		foreach ($query->rows as $result) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$result['path_id'] . "', `level` = '" . (int)$level . "'");

			$level++;
		}
		$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET `category_id` = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', `level` = '" . (int)$level . "'");

		$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '0'");

		$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_layout SET category_id = '" . (int)$category_id . "', store_id = '0', layout_id = '18'");

		$keyword = $this->translitArtkl($data['name']);
		$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$category_id . "', keyword = '" . $this->db->escape($keyword) . "'");

		$this->cache->delete('category');

		return $category_id;
	}
	public function translitArtkl($str) {
		$rus = array('+','/',',','.','(',')','и','і','є','Є','ї','\"','\'','.',' ','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
		$lat = array('','-','-','-','','','u','i','e','E','i','','','','-','A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
	   $str = str_replace($rus, $lat, $str);
	   return str_replace('--', '-', $str);
	}
}