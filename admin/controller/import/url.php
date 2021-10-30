<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
class ControllerImportUrl extends Controller {
	private $error = array();

	public function index() {
		//$this->load->language('catalog/product');

		$this->document->setTitle('Модуль URL');

		$this->load->model('import/url');

		$this->getForm();
	}
	
	public function action(){
		
		if(isset($this->request->post['export'])){
			$this->export();
		}elseif(isset($this->request->post['import'])){
			$this->import();
		}

		$this->getForm();
	}

	public function manufacturer(){
		
		$this->load->model('import/url');
		
		$rows = $this->model_import_url->getManufUrl();
		$ids = array();
		foreach($rows as $row){
			$tmp = explode('=', $row['query']);
			$ids[(int)$tmp[1]] = (int)$tmp[1];
		}

		if(count($ids) > 0){
			$query = $this->db->query("SELECT manufacturer_id, name FROM " . DB_PREFIX . "manufacturer_description WHERE language_id='1' AND manufacturer_id NOT IN(".implode(',', $ids).")");
			
			foreach($query->rows as $row){

				$keyword = strtolower($this->translitArtkl($row['name']));
				$id = (int)$row['manufacturer_id'] ;
				
				//$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "'");
				$sql = "INSERT INTO " . DB_PREFIX . "url_alias SET query = 'manufacturer_id=" . (int)$id . "', keyword = '" . $this->db->escape($keyword) . "'";
				
				$this->db->query($sql);
				
			}
			
		}
		
		$this->getForm();
		
	}
	
	public function category(){
		
		$this->load->model('import/url');
		
		$rows = $this->model_import_url->getCategUrl();
		$ids = array();
		foreach($rows as $row){
			$tmp = explode('=', $row['query']);
			$ids[(int)$tmp[1]] = (int)$tmp[1];
		}
		
		if(count($ids) > 0){
			
			$query = $this->db->query("SELECT category_id, name FROM " . DB_PREFIX . "category_description WHERE language_id='1' AND category_id NOT IN(".implode(',', $ids).")");
			
			foreach($query->rows as $row){
				
				$keyword = strtolower($this->translitArtkl($row['name']));
				$id = (int)$row['category_id'] ;
				
				//$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "'");
				$sql = "INSERT INTO " . DB_PREFIX . "url_alias SET query = 'category_id=" . (int)$id . "', keyword = '" . $this->db->escape($keyword) . "'";
				
				$this->db->query($sql);
				
			}
			
		}
		
		$this->getForm();
		
	}
	public function product(){
		
		$this->load->model('import/url');
		
		$rows = $this->model_import_url->getProdUrl();
		$ids = array();
		foreach($rows as $row){
			$tmp = explode('=', $row['query']);
			$ids[(int)$tmp[1]] = (int)$tmp[1];
		}
		
		if(count($ids) > 0){
			
			$query = $this->db->query("SELECT product_id, name FROM " . DB_PREFIX . "product_description WHERE language_id='1' AND product_id NOT IN(".implode(',', $ids).")");
			
			foreach($query->rows as $row){
				
				$keyword = strtolower($this->translitArtkl($row['name']));
				$id = (int)$row['product_id'] ;
				
				//$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . (int)$product_id . "'");
				$sql = "INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product_id=" . (int)$id . "', keyword = '" . $this->db->escape($keyword) . "'";
				
				$this->db->query($sql);
				
			}
			
		}
		
		$this->getForm();
		
	}
	
	public function translitArtkl($str) {
		$rus = array('+','/',',','.','(',')','и','і','є','Є','ї','\"','\'','.',' ','А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
		$lat = array('','-','-','-','','','u','i','e','E','i','','','','-','A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
	   $str = str_replace($rus, $lat, $str);
	   return str_replace('--', '-', $str);
	}
	protected function getForm() {
  
  
		$data['breadcrumbs'] = array();
		
		$url = '';
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Модуль URL',
			'href' => $this->url->link('import/url', 'token=' . $this->session->data['token'] . $url, true)
		);
		
		
		$data['my_manufacturers']	= $this->model_import_url->getManufTotal();
		$data['url_manufacturers']	= $this->model_import_url->getManufUrlTotal();
		$data['my_categories']		= $this->model_import_url->getCategTotal();
		$data['url_categories']		= $this->model_import_url->getCategUrlTotal();
		$data['my_products']		= $this->model_import_url->getProdTotal();
		$data['url_products']		= $this->model_import_url->getProdUrlTotal();
		

		$data['action_category'] = $this->url->link('import/url/category', 'token=' . $this->session->data['token'] . $url, true);
		$data['action_manufacturer'] = $this->url->link('import/url/manufacturer', 'token=' . $this->session->data['token'] . $url, true);
		$data['action_product'] = $this->url->link('import/url/product', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('import/url', $data));
	}

}
