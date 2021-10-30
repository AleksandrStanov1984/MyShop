<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

class ControllerImportBrain extends Controller {
	private $error = array();
	private $login = 'sm@sz.ua';
	private $password = 'sToObA4SzSZq';
	private $key = '';
	private $main_category = 3668;
	private $USD = 28.3;

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
		
		$data['my_manufacturers'] = $this->model_import_brain->getMyTotalManufacturers();
		$data['my_categories'] = $this->model_import_brain->getMyTotalCategories();
		$data['my_products'] = $this->model_import_brain->getMyTotalProducts();
		
	
		$data['import_category'] = $this->url->link('import/brain/import_categories', 'token=' . $this->session->data['token'] . $url, true);
		$data['import_product'] = $this->url->link('import/brain/import_products', 'token=' . $this->session->data['token'] . $url, true);
		$data['import_manufacturer'] = $this->url->link('import/brain/import_manufacturers', 'token=' . $this->session->data['token'] . $url, true);
		
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('import/brain', $data));
	}

	public function import_prices($target){
		
		
		$this->load->model('import/brain');
		
		//Не будем очищать - будем обновлять
		//$this->model_import_brain->clearBrainPrices();
		
		//foreach($targets as $target){
			$products = $this->getBrainPrice($target);
			
			if($products AND count($products) > 0){
				foreach($products as $row){
					$this->model_import_brain->addBrainPrice($target, $row);
				}
			}
		//}
		
		//die('done - updatePrice');
		
	}
	
	public function update_products(){
		//$targets = array(13,14,22,29,30,44,45,46,48,50,54,55,57,58,8234,9152,9204,24017,8948);
		$targets = array(8948);
		
		
		$is_targets = $this->db->query("SELECT target_id FROM " . DB_PREFIX . "brain_import GROUP BY target_id");
		if($is_targets->num_rows > 0){
			foreach($is_targets->rows as $target){
				unset($targets[array_search($target['target_id'], $targets)]);
			}
		}
		
		
		$currency = $this->getBrainCurrencies();
		foreach($currency as $row){
			$this->USD = (float)$row['value'];
		}
		
		if(count($targets) > 0){
			$this->import_prices(array_shift($targets));
			die('done - updatePrice<script>setTimeout(function(){location.href="https://sz.ua/index.php?route=import/brain/update_products";},25000);</script>');
		}
		
		
		
		$this->load->model('import/brain');
		$products = $this->model_import_brain->getBrainProducts();
	
		if(!$products){
			
			//Обновим прайсы
			$this->import_prices();
			
		}else{
		
			foreach($products as $brain_id => $product){
				
				$this->add_edit_Product($brain_id, $product);
				
			}
		
		}
		
		die('done - Products '.$product['date'].'<script>setTimeout(function(){location.href="https://sz.ua/index.php?route=import/brain/update_products";},5000);</script>');
		
	}
	public function add_edit_Product($brain_id, $product, $images = array()){
		
		$my_product_info = $this->model_import_brain->getProductInfo($brain_id);

	
		if(!$my_product_info){
			//$description_ru = $this->getBrainProduct($brain_id, 'ru');
			//$description_ua = $this->getBrainProduct($brain_id, 'ua');
			//$my_product_id = $this->model_import_brain->addProduct($product, $description_ru, $description_ua, $this->USD);
			
			$images = $this->getBrainProductImages($brain_id);
			$my_product_id = $this->model_import_brain->updateImagesProduct($my_product_id, $images);

			
		}else{
			$my_product_id = $this->model_import_brain->updateProduct($my_product_info['product_id'], $product, $this->USD);
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
		
		
		$url = '';
		$this->response->redirect($this->url->link('import/brain', 'token=' . $this->session->data['token'] . $url, true));
	
	}
	public function getBrainTargets(){
		if($this->GetBrainKey()){
			
			$url="http://api.brain.com.ua/targets/".$this->key; 
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
	
	public function getBrainCurrencies(){
		if($this->GetBrainKey()){
			
			$url="http://api.brain.com.ua/currencies/".$this->key; 
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

	



	public function getBrainTargetsSpecial(){
		if($this->GetBrainKey()){
			
			$url="http://api.brain.com.ua/discounted_targets/".$this->key; 
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

	
	public function getBrainPrice($target_id){
		if($this->GetBrainKey()){
			
			/*
			Наличие:
			0 (только локальный склад, полный прайс);
			1 (все наличие, полный прайс);
			2 (все наличие, короткий прайс)
			по умолчанию 0
			*/
			$url="http://api.brain.com.ua/pricelists/".$target_id."/json/".$this->key."?full=2";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			
			curl_setopt($ch, CURLOPT_URL, $url);
			$output = curl_exec($ch); //ответ
			curl_close($ch);
		
			$array = json_decode($output, true);
	
			if(isset($array['url']) AND $array['url'] != ''){
				$url=$array['url'];
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				
				curl_setopt($ch, CURLOPT_URL, $url);
				$output = curl_exec($ch); //ответ
				curl_close($ch);
			
				$array = json_decode($output, true);
	
				return $array;
				
			}
			return false;
		}
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
