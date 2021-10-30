<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
class ControllerCatalogFolderSearch extends Controller
{
	private $error = array();
	protected $data;

	public function index() {
	
		
		
		$this->getForm();
		/*
		echo '<pre>'."\n";
		echo 'Арнольд Шварцнеггер '.implode(' ', $this->model_catalog_folder_search->codeString('Арнольд Шварцнеггер'))."\n";
		echo 'Arnold Schwarzenegger '.implode(' ', $this->model_catalog_folder_search->codeString('Arnold Schwarzenegger'))."\n";
		echo 'Орнольд Шворцнегир '.implode(' ', $this->model_catalog_folder_search->codeString('Орнольд Шворцнегир'))."\n";
		echo 'зирнавой кофb Lavazza '.implode(' ', $this->model_catalog_folder_search->codeString('зирнавой кофе Lavazza'))."\n";
		echo 'зерновой кофе Лаваца '.implode(' ', $this->model_catalog_folder_search->codeString('зерновой кофе Лаваца'))."\n";
		echo '</pre>';
		*/
	}
	
	public function reload_product(){
		
		$this->load->model('catalog/folder_search');
		$products = $this->model_catalog_folder_search->getFirstNoCodeProduct();
		
		if($products){
			foreach($products as $row){
				$this->updatePhoneticCode($row['product_id']);
			}
		}else{
			echo 'END';
		}

	}
	
	public function clear_table(){
		$this->load->model('catalog/folder_search');
		$this->model_catalog_folder_search->deleteAllDescription();
	}

	public function install(){
		$this->load->model('catalog/folder_search');
		$this->model_catalog_folder_search->createTable();
	}
	
	public function save(){
		
		unset($this->session->data['folder_search']);
		
		$this->load->model('catalog/product');
		$this->load->model('catalog/folder_search');
		
		//$this->model_catalog_folder_search->createTable();
		
		$this->db->query("DELETE FROM `" . DB_PREFIX . "setting` WHERE store_id = '" . (int)$this->config->get('config_store_id') . "' AND `code` = 'config_folder_search'");
		
		$this->config->set('config_folder_search_active', 0);
		$this->config->set('config_folder_search_name', 0);
		$this->config->set('config_folder_search_description', 0);
		$this->config->set('config_folder_search_tag', 0);
		$this->config->set('config_folder_search_meta_title', 0);
		$this->config->set('config_folder_search_meta_description', 0);
		$this->config->set('config_folder_search_meta_keyword', 0);
		
		foreach ($this->request->post as $key => $value) {

			if($key == 'language'){
				
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET
								 store_id = '" . (int)$this->config->get('config_store_id') . "',
								 `code` = 'config_folder_search',
								 `key` = 'config_folder_search_language',
								 `value` = '" . $this->db->escape(json_encode($value, JSON_UNESCAPED_UNICODE)) . "',
								 `serialized`=1");
	
				//$this->config->set('config_folder_search_language', $this->db->escape(json_encode($value, JSON_UNESCAPED_UNICODE)));
			}else{
				$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET
								 store_id = '" . (int)$this->config->get('config_store_id') . "',
								 `code` = 'config_folder_search',
								 `key` = 'config_folder_search_" . $this->db->escape($key) . "',
								 `value` = '" . $this->db->escape($value) . "'");
				
				$this->config->set('config_folder_search_' . $this->db->escape($key) , 1);
			}
		}		
		
		
		$this->load->model('setting/setting');
		$this->model_setting_setting->getSetting('config_folder_search', (int)$this->config->get('config_store_id')) ;
		
		/*
		$products = $this->model_catalog_product->getProducts();
		foreach($products as $products){
			$this->updatePhoneticCode($products['product_id']);
		}
		*/
		if(count($this->error) > 0){
			$this->session->data['folder_search'] = $this->error;
		}
		
		//$this->response->redirect($this->url->link('catalog/folder_search', 'token=' . $this->session->data['token'], true));
		$this->getForm();
	}
	
	public function updatePhoneticCode($product_id){
		
		$this->load->model('catalog/product');
		$descriptions = $this->model_catalog_product->getProductDescriptions($product_id);
		
		$data = array();
		
		foreach($descriptions as $language_id => $row){
			
			$name = array();
			$description = array();
			$tag = array();
			$meta_title = array();
			$meta_description = array();
			$meta_keyword = array();
			
			if($this->config->get('config_folder_search_name')){
					$name = $this->model_catalog_folder_search->codeString($row['name']);
			}
			if($this->config->get('config_folder_search_description')){
				$description = $this->model_catalog_folder_search->codeString($row['description']);
			}
			if($this->config->get('config_folder_search_tag')){
				$tag = $this->model_catalog_folder_search->codeString($row['tag']);
			}
			if($this->config->get('config_folder_search_meta_title')){
				$meta_title = $this->model_catalog_folder_search->codeString($row['meta_title']);
			}
			if($this->config->get('config_folder_search_meta_description')){
				$meta_description = $this->model_catalog_folder_search->codeString($row['meta_description']);
			}
			if($this->config->get('config_folder_search_meta_keyword')){
				$meta_keyword = $this->model_catalog_folder_search->codeString($row['meta_keyword']);
			}
			
			if($name == 'error'){
				$name = array();
				$this->error[] = array('product_id' => $product_id,
									   'name' => $row['name'],
									   'target' => 'Имя',
									   'language_id' => $language_id,
									   );
			}
			
			if($description == 'error'){
				$description = array();
				$this->error[] = array('product_id' => $product_id,
									   'name' => $row['name'],
									   'target' => 'Описание',
									   'language_id' => $language_id,
									   );
			}
			
			if($tag == 'error'){
				$tag = array();
				$this->error[] = array('product_id' => $product_id,
									   'name' => $row['name'],
									   'target' => 'Теги',
									   'language_id' => $language_id,
									   );
			}
			
			if($meta_title == 'error'){
				$meta_title = array();
				$this->error[] = array('product_id' => $product_id,
									   'name' => $row['name'],
									   'target' => 'Meta Title',
									   'language_id' => $language_id,
									   );
			}
			
			if($meta_description == 'error'){
				$meta_description = array();
				$this->error[] = array('product_id' => $product_id,
									   'name' => $row['name'],
									   'target' => 'Meta Description',
									   'language_id' => $language_id,
									   );
			}
			
			if($meta_keyword == 'error'){
				$meta_keyword = array();
				$this->error[] = array('product_id' => $product_id,
									   'name' => $row['name'],
									   'target' => 'Meta Keyword',
									   'language_id' => $language_id,
									   );
			}
			
			
			$data[$language_id] = array(
										'name' => implode(' ', $name),
										'description' => implode(' ', $description),
										'meta_title' => implode(' ', $meta_title),
										'meta_description' => implode(' ', $meta_description),
										'meta_keyword' => implode(' ', $meta_keyword),
										'tag' => implode(' ', $tag),
										);
		}

		$this->model_catalog_folder_search->insertDescription($data, $product_id);
	}
	
	public function getForm(){
		
		$data = array();
		
		$this->load->model('catalog/folder_search');
		$url = '';
		
		//Резервная копия алфавита	
		$data['ru'] = array(
			'А', 'а', 'Б', 'б', 'В', 'в', 'Г', 'г', 'Д', 'д', 'Е', 'е', 'Ё', 'ё', 'Ж', 'ж', 'З', 'з',
			'И', 'и', 'Й', 'й', 'К', 'к', 'Л', 'л', 'М', 'м', 'Н', 'н', 'О', 'о', 'П', 'п', 'Р', 'р',
			'С', 'с', 'Т', 'т', 'У', 'у', 'Ф', 'ф', 'Х', 'х', 'Ц', 'ц', 'Ч', 'ч', 'Ш', 'ш', 'Щ', 'щ',
			'Ъ', 'ъ', 'Ы', 'ы', 'Ь', 'ь', 'Э', 'э', 'Ю', 'ю', 'Я', 'я', 'і', 'І','Ї', 'ї', 'Ґ', 'ґ', 'Є', 'є', '&nbsp;', '–',
			'Ś', 'ś', 'ł', 'ę', 'Ę', 'É', 'é', 'Ć', 'ć',
			'M', 'I', 'W', 'H', 
			'  '
		);
	 	$data['en'] = array(
			'A', 'a', 'B', 'b', 'V', 'v', 'G', 'g', 'D', 'd', 'E', 'e', 'E', 'e', 'Zh', 'zh', 'Z', 'z',
			'I', 'i', 'J', 'j', 'K', 'k', 'L', 'l', 'M', 'm', 'N', 'n', 'O', 'o', 'P', 'p', 'R', 'r',
			'S', 's', 'T', 't', 'U', 'u', 'F', 'f', 'H', 'h', 'C', 'c', 'Ch', 'ch', 'Sh', 'sh', 'Sch', 'sch',
			'\'', '\'', 'Y', 'y',  '\'', '\'', 'E', 'e', 'Ju', 'ju', 'Ja', 'ja', 'i', 'I', 'J', 'j', 'G', 'g', 'E', 'e', '', '',
			'Ch', 'ch', 'l', 'e', 'E', 'E', 'e', 'Sh', 'sh',
			'M', 'I', 'W', 'H', 
			''
		);
		$data['language'] = array();
		foreach($data['ru'] as $index => $row){
			$data['language'][] = array(
										'ru' => $row,
										'en' => $data['en'][$index],
										);
		}

		//Если у нас уже есть сохраненная - берем ее
		//$language = json_decode(str_replace('\\','', $this->config->get('config_folder_search_language')));
		$language = $this->config->get('config_folder_search_language');
		if(count($language) > 1){
			$data['language'] = $language;
		}
		
		$data['error_warning'] = false;
		if(isset($this->session->data['folder_search'])){
			$data['error_warning'] = $this->session->data['folder_search'];
		}
		
		$this->load->model('localisation/language');
		$languages = $this->model_localisation_language->getLanguages();
		
		$data['languages'] = array();
		foreach($languages as $row){
			$data['languages'][$row['language_id']] = $row;
		}
		
		
		$data['active'] = (int)$this->config->get('config_folder_search_active');
		$data['name'] = (int)$this->config->get('config_folder_search_name');
		$data['description'] = (int)$this->config->get('config_folder_search_description');
		$data['tag'] = (int)$this->config->get('config_folder_search_tag');
		$data['meta_title'] = (int)$this->config->get('config_folder_search_meta_title');
		$data['meta_description'] = (int)$this->config->get('config_folder_search_meta_description');
		$data['meta_keyword'] = (int)$this->config->get('config_folder_search_meta_keyword');
		
		
		$data['action'] = $this->url->link('catalog/folder_search/save', 'token=' . $this->session->data['token'] . $url, true);
		$data['reload_product'] = $this->url->link('catalog/folder_search/reload_product', 'token=' . $this->session->data['token'] . $url, true);
		$data['clear_table'] = $this->url->link('catalog/folder_search/clear_table', 'token=' . $this->session->data['token'] . $url, true);
		$data['token'] = $this->request->get['token'];
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/folder_search', $data));
	}
	
}
