<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

class ControllerImportBrain extends Controller {
	private $error = array();
	private $login = 'sm@sz.ua';
	private $password = 'sToObA4SzSZq';
	private $key = '';
	private $main_category = 3668; //2229

	public function index() {
		
		$this->load->model('import/brain');
		
		$url = '';
		
		//$this->import_categories();
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'API Brain',
			'href' => $this->url->link('import/brain', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		$name = 'import_brain_categories_added';
		$data[$name] = false;
		if(isset($this->session->data[$name])){
			$data[$name] = $this->session->data[$name];
		}

		$data['msg'] = array(
							 'import_brain_categories',
							 'import_brain_categories_added',
							 'import_brain_products',
							 'import_brain_products_added',
							 'import_brain_manufacturers',
							 'import_brain_manufacturers_added',
							 );
		
		foreach($data['msg'] as $msg){
		$data[$msg] = false;
			if(isset($this->session->data[$msg])){
				$data[$msg] = $this->session->data[$msg];
			}
		}
		
		
		$data['total_prices'] = $this->model_import_brain->getMyTotalPrice();
		$data['total_prices_updated'] = $this->model_import_brain->getMyTotalPriceUpdated();
		$data['prices_row'] = $this->model_import_brain->getMyPriceRow();
		$data['total_prices_updated_procent'] = (int)($data['total_prices_updated'] / ($data['total_prices'] / 100));
		
		$data['my_manufacturers'] = $this->model_import_brain->getMyTotalManufacturers();
		$data['my_categories'] = $this->model_import_brain->getMyTotalCategories();
		$data['my_products'] = $this->model_import_brain->getMyTotalProducts();
		
	
		$data['import_category'] = $this->url->link('import/brain/import_categories', 'token=' . $this->session->data['token'] . $url, true);
		$data['import_product'] = $this->url->link('import/brain/import_products', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete_product'] = $this->url->link('import/brain/delete_product', 'token=' . $this->session->data['token'] . $url, true);
		$data['import_manufacturer'] = $this->url->link('import/brain/import_manufacturers', 'token=' . $this->session->data['token'] . $url, true);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('import/brain', $data));
	}

	public function delete_product(){
		
		$this->load->model('import/brain');
		$this->load->model('catalog/product');
		
		$products = $this->model_import_brain->getNullProducts();
		
		//die('Будет удалено продуктов Брейн --'.count($products));
		
		foreach($products as $product){
			
			$images = $this->model_import_brain->getProductImages();
			if($product['image'] != '') $images[] = $product['image'];
			
			foreach($images as $image){
				$this->model_import_brain->deleteImage($image);
			}
			$this->model_import_brain->deleteImageCategory($product['product_id']);
			
			$this->model_catalog_product->deleteProduct($product['product_id']);
		}
		$url = '';
		$this->response->redirect($this->url->link('import/brain', 'token=' . $this->session->data['token'] . $url, true));

	}
	public function import_products(){
		
		$this->load->model('import/brain');
		
		$categories = $this->model_import_brain->getMyCategories($this->main_category);
	
		if(!$this->config->get('api_brain_category_count')){
			$this->config->set('api_brain_category_count', 0);
			$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '0', `code` = 'brain', `key` = 'api_brain_category_count', `value` = '0', serialized = '0'");
		}
		if(!$this->config->get('api_brain_category_offset')){
			$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '0', `code` = 'brain', `key` = 'api_brain_category_offset', `value` = '0', serialized = '0'");
			$this->config->set('api_brain_category_offset', 0);
		}
		
		$active_category = $this->config->get('api_brain_category_count');
		$start = $this->config->get('api_brain_category_offset');
		
		if(isset($categories[$active_category])){
			$category = $categories[$active_category];
		}else{
			$this->config->set('api_brain_category_count', 0);
			$category = $categories[0];
		}
	
		$products = $this->getBrainProducts($category['brain_id'], 'ru', $start);
		//$start += 100;
		$total = (int)$products['count'];
		
		if($total <= $start){
			$start = 0;
			$this->config->set('api_brain_category_count', ++$active_category);
			$this->config->set('api_brain_category_offset', $start);
		}else{
			$this->config->set('api_brain_category_offset', $start += 100);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `code` = 'brain'");
		$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '0', `code` = 'brain', `key` = 'api_brain_category_offset', `value` = '".$start."', serialized = '0'");
		$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET store_id = '0', `code` = 'brain', `key` = 'api_brain_category_count', `value` = '".$active_category."', serialized = '0'");

		
		foreach($products['list'] as $product){
			
			$images = false;
			$this->add_edit_Product($product['productID'], $product, $images);
		}

		$this->session->data['import_brain_products'] = $count;
		$this->session->data['import_brain_products_added'] = $add;
		
		$url = '';
		$this->response->redirect($this->url->link('import/brain', 'token=' . $this->session->data['token'] . $url, true));
		
		
	}
	
	public function add_edit_Product($brain_id, $product, $images){
		
		$my_product_info = $this->model_import_brain->getProductInfo($brain_id);

	
		
		if(false AND !$my_product_info){
			$description_ru = $this->getBrainProduct($brain_id, 'ru');
			$description_ua = $this->getBrainProduct($brain_id, 'ua');
			$my_product_id = $this->model_import_brain->addProduct($product, $description_ru, $description_ua);
			
			$images = $this->getBrainProductImages($product['productID']);
			$my_product_id = $this->model_import_brain->updateImagesProduct($my_product_id, $images);
			
		}else{
			$my_product_id = $this->model_import_brain->updateProduct($my_product_info['product_id'], $product, $description_ru, $description_ua);
		}
		
		
		
	}
	
	public function import_manufacturers(){
		
		$this->load->model('import/brain');
			
		$manuf = $this->getBrainManufacturers();
		
		$count = 0;
		$add = 0;
		foreach($manuf as $row){
			
			$manufacturer_id = $this->model_import_brain->getManufacturerByBrainID($row['vendorID']);
			if(!$manufacturer_id){
				$manufacturer_id = $this->model_import_brain->getManufacturerByName($row['name']);
			}
			
			if(!$manufacturer_id){
				$manufacturer_id = $this->model_import_brain->addManufacturer($row);
				$add++;
			}
			
			$this->model_import_brain->updateManufacturerBrainId($manufacturer_id, $row['vendorID']);
			
			$count++;
		}
		
		$this->session->data['import_brain_manufacturers'] = $count;
		$this->session->data['import_brain_manufacturers_added'] = $add;
		
		$url = '';
		$this->response->redirect($this->url->link('import/brain', 'token=' . $this->session->data['token'] . $url, true));
	
	}
	
	public function import_categories(){
		
		$this->load->model('import/brain');
			
		$categ_ru = $this->getBrainCategorys('ru');
		$categ_ua = $this->getBrainCategorys('ua');

		$categories = array();
		foreach($categ_ru as $index => $row){
			$categories[$row['categoryID']] = $row;
		}
		foreach($categ_ua as $index => $row){
			$categories[$row['categoryID']]['name_ua'] = $row['name'];
		}
	
		$count = 0;
		$add = 0;
		foreach($categories as $brain_id => $row){
			
			$category_info = $this->model_import_brain->getCategoryInfo($brain_id);
			$parent_info = $this->model_import_brain->getCategoryInfo($row['parentID']);
			
			//Если нет этой категории но знаем парент
			if(!$category_info and $parent_info){
				
				$row['parent_id'] = $parent_info['category_id'];
				
				$this->model_import_brain->addCategory($row);
				
				$add++;
			}
			$count++;
		}
		
		$this->session->data['import_brain_categories'] = $count;
		$this->session->data['import_brain_categories_added'] = $add;
		
		$url = '';
		$this->response->redirect($this->url->link('import/brain', 'token=' . $this->session->data['token'] . $url, true));
	
	}
	
	
	public function getBrainProducts($category_id, $lang = 'ru', $start = 0){
		if($this->GetBrainKey()){
			
			$url="http://api.brain.com.ua/products/".$category_id."/".$this->key."?lang=".$lang."&offset=".$start; 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $url);
			$output = curl_exec($ch); //ответ
			curl_close($ch);
		
			$array = json_decode($output, true);
			
			if(isset($array['result']) and isset($array['status']) AND $array['status'] == 1){
				return $array['result'];
			}
			
			return false;
		}
	}
	
	public function getBrainProduct($brain_id, $lang){
		if($this->GetBrainKey()){
			
			$url="http://api.brain.com.ua/product/".$brain_id."/".$this->key."?lang=".$lang; 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $url);
			$output = curl_exec($ch); //ответ
			curl_close($ch);
		
			$array = json_decode($output, true);
			
			if(isset($array['result']) and isset($array['status']) AND $array['status'] == 1){
				return $array['result'];
			}
			
			return false;
		}
	}
	public function getBrainProductImages($brain_id){
		if($this->GetBrainKey()){
			
			$url="http://api.brain.com.ua/product_pictures/".$brain_id."/".$this->key; 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $url);
			$output = curl_exec($ch); //ответ
			curl_close($ch);
		
			$array = json_decode($output, true);
			
			if(isset($array['result']) and isset($array['status']) AND $array['status'] == 1){
				return $array['result'];
			}
			
			return false;
		}
	}
	
	
	
	public function getBrainManufacturers(){
		if($this->GetBrainKey()){
			
			$url="http://api.brain.com.ua/vendors/".$this->key; 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $url);
			$output = curl_exec($ch); //ответ
			curl_close($ch);
		
			$array = json_decode($output, true);
			
			if(isset($array['result']) and isset($array['status']) AND $array['status'] == 1){
					return $array['result'];
			}
			
			return false;
		}
	}
	
	public function getBrainCategorys($lang){
		if($this->GetBrainKey()){
			
			$url="http://api.brain.com.ua/categories/".$this->key."?lang=".$lang; 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			
			curl_setopt($ch, CURLOPT_URL, $url);
			$output = curl_exec($ch); //ответ
			curl_close($ch);
		
			$array = json_decode($output, true);
			
			if(isset($array['result']) and isset($array['status']) AND $array['status'] == 1){
					return $array['result'];
			}
			
			return false;
		}
	}
	
	
	public function GetBrainKey() {
		
		if($this->key != ''){
			return true;
		}
		
		$url="http://api.brain.com.ua/auth"; 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array (
			'login' => $this->login,
			'password' => md5($this->password),
		)); //параметры запроса
		curl_setopt($ch, CURLOPT_URL, $url);
		$output = curl_exec($ch); //ответ
		curl_close($ch);
	
		$arr = json_decode($output, true);
	
		if(isset($arr['result']) and isset($arr['status']) AND $arr['status'] == 1){
			$this->key = $arr['result'];
			return true;
		}
		return false;
		
	}
	
	
	
}
