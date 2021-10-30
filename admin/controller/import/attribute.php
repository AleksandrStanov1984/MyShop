<?php
	
class ControllerImportAttribute extends Controller {
	private $error = array();
	private $success = array();

	public function index() {
		//$this->load->language('catalog/product');

		$this->document->setTitle('Атрибуты');

		$this->load->model('import/attribute');

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
	
	public function import(){
		
		if(!isset( $_FILES['import_file']['tmp_name'])){
			die('Вы забыли загрузить фаил');
		}
		
		$no_attribute = array(
							  '_MAIN_CATEGORY_',
							  '_PRODUCT_ID_',
							  '_SKU_',
							  '_NAME_',
							  );
		
		$this->load->model('import/attribute');
		
		$tmpFilename = $_FILES['import_file']['tmp_name'];
		//require_once ('docs/PHPExcel/IOFactory.php');
		require_once (DIR_SYSTEM.'PHPExcel/Classes/PHPExcel.php');
		require_once (DIR_SYSTEM.'PHPExcel/Classes/PHPExcel/IOFactory.php');
		
		$worksheet = PHPExcel_IOFactory::load($tmpFilename)->getSheet(0);

		if(!$worksheet) {die('<h2>Ошибка: лист c данными не найден</h2>');}
		$rows = $worksheet->getHighestRow();
		
		$count = 1;
		
		$column_to_attribute_id = array();
		
		while($count < $rows){
		   
			//Прочитаесм строчку
			$count++;
			$x = 0;
			$attributes = array();
			$row = array();
			while('' != $worksheet->getCellByColumnAndRow($x,1)->getValue()){
				
				$head_name = $worksheet->getCellByColumnAndRow($x,1)->getValue();
				
				$row[$head_name] = $worksheet->getCellByColumnAndRow($x,$count)->getCalculatedValue();
				
				if($count == 2 AND !in_array($head_name, $no_attribute)){
					list($attr_group_name, $attr_name) = explode('|', $head_name);
					$attribute_group_id = $this->model_import_attribute->getAttributeGroupIdOnName($attr_group_name);
					$attribute_id = $this->model_import_attribute->getAttributeIdOnName($attr_name, $attribute_group_id);
					$column_to_attribute_id[$head_name] = $attribute_id;
				}
				$x++;
			}
		
			$product_id = 0;
		
			if(isset($row['_PRODUCT_ID_']) AND (int)$row['_PRODUCT_ID_'] > 0){
				$product_id = (int)$row['_PRODUCT_ID_'];
			}elseif(isset($row['_SKU_']) AND trim($row['_SKU_']) != ''){
				$product_id = $this->model_import_attribute->getProductIdFromSku((int)$row['_SKU_']);
			}
		if($product_id > 0){
				
				foreach($row as $attr_name => $value){
					
					if(isset($column_to_attribute_id[$attr_name])){
					
						$attr_values = explode(';', $value);
						
						$product_id = $product_id;
						$attribute_id = $column_to_attribute_id[$attr_name];
	
						$rus = '';
						$ukr = '';
						foreach($attr_values as $val_rus){
							$rus .= $val_rus.';';
							$ukr .= $this->model_import_attribute->getUkrAttrValue($attribute_id, $val_rus, $product_id).';';
						}
						$this->model_import_attribute->updateAttributeValue($attribute_id, $product_id, $rus, $ukr);
						
					}
					
				}
				
			
			}else{
				$this->error[] = 'Не смог найти товар в строке '.$count;
			}
		
		
		
		}
		
		if(!$this->error){
			$this->success[] = 'Импорт завершен, импортировано '.$rows.' строк';
		}
		
		$this->getForm();
	}
	
	public function export(){
		
		$this->load->model('import/attribute');
		$this->load->model('catalog/attribute');
		$this->load->model('catalog/product');
		
		$post = $this->request->post; //product_attributes
		
		$products = array();
		
		if (isset($this->request->post['product_attributes'])) {
			$data['product_attributes'] = $this->request->post['product_attributes'];
		} else {
			$data['product_attributes'] = array();
		}

		$results = $this->model_catalog_attribute->getAttributes();
		$attr_list = array();
		foreach ($results as $result) {
			
			//if(in_array($result['attribute_id'], $post['product_attributes'])){
				$attr_list[$result['attribute_id']] = array(
					'attribute_id'    => $result['attribute_id'],
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'attribute_group'            => strip_tags(html_entity_decode($result['attribute_group'], ENT_QUOTES, 'UTF-8')),
				);
			//}
		}

		foreach($post['product_category'] as $category_id){
			$filter_data = array(
				'filter_category_id' => $category_id,
				'filter_sub_category' => true,
			);
			$results = $this->model_import_attribute->getProducts($filter_data);
			foreach($results as $row){
				$products[$row['product_id']] = $row;
			}
		}
	
		$this->load->model('catalog/category');
		$categories_tmp = $this->model_catalog_category->getCategories();
		
		$categories = array();
		foreach($categories_tmp as $row){
			$categories[$row['category_id']] = str_replace('&nbsp;&nbsp;&gt;&nbsp;&nbsp;','|',$row['name']);
		}
		
		$active_attribute = array();
		
		if(count($products) > 0){
			foreach($products as $product_id => $row){
				
				$product_attributes = $this->model_catalog_product->getProductAttributes($row['product_id']);
				
				foreach($product_attributes as $attr){
					$active_attribute[$attr['attribute_id']] = $attr['attribute_id'];
				}
				
				$products[$product_id]['attributes'] = $product_attributes;
				
			}
		
		
			require_once (DIR_SYSTEM.'PHPExcel/Classes/PHPExcel.php');
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			foreach (range('DC', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col) {
				$objPHPExcel->getActiveSheet() ->getColumnDimension($col) ->setAutoSize(true);
			} 
		
			$row = 1;
			$col = 0;
			$attr_col = 0;
			
			//$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, '_MAIN_CATEGORY_');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, '_MAIN_CATEGORY_');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, '_PRODUCT_ID_');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, '_SKU_');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, '_NAME_');
			
			$attr_col = $col;
			$attribute_id_by_collumn = array();
			
			foreach($active_attribute as $attribute_id){
				
				if(isset($post['filter_attributes']) AND in_array($attribute_id, $post['product_attributes'])){
				
					$attribute_id_by_collumn[(int)$attribute_id] = $col;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $attr_list[$attribute_id]['attribute_group'].'|'.$attr_list[$attribute_id]['name']);
					unset($attr_list[$attribute_id]);

				}elseif(!isset($post['filter_attributes'])){

					$attribute_id_by_collumn[(int)$attribute_id] = $col;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $attr_list[$attribute_id]['attribute_group'].'|'.$attr_list[$attribute_id]['name']);
					unset($attr_list[$attribute_id]);

				}
			}
	  
		/*
			foreach($attr_list as $attr){
				$attribute_id_by_collumn[(int)$attr['attribute_id']] = $col;
				//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $attr['attribute_group'].'|'.$attr['name']);
				unset($attr_list[$attribute_id]);
			}
		*/	
			foreach ($products as $product) {

				$col = 0;
				$row++;
			
				//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $product['path_id']);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, html_entity_decode($categories[$product['path_id']], ENT_QUOTES, 'UTF-8'));
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $product['product_id']);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $product['sku']);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col++, $row, $product['name']);
			
			
				foreach($product['attributes'] as $attr){
					
					if(isset($attribute_id_by_collumn[(int)$attr['attribute_id']])){
						$value = array_shift($attr['product_attribute_description']);
						
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($attribute_id_by_collumn[(int)$attr['attribute_id']], $row, $value['text']);
					}
					
				}
	  
			}
		
		
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
			
			header('Content-Type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment;filename="sz-attribute.xls"'); 
			header('Cache-Control: max-age=0'); 
	
			$objWriter->save('php://output'); 
			exit(); 
		
		}
		
	}
	
	
	
	protected function getForm() {
  
		$data['error'] = $this->error;
		$data['success'] = $this->success;
  
  		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');
  
		$data['breadcrumbs'] = array();
		
		$url = '';
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Атрибуты',
			'href' => $this->url->link('import/attribute', 'token=' . $this->session->data['token'] . $url, true)
		);

	
		// Categories
		$this->load->model('catalog/category');

		$filter_data = array(
			'sort'        => 'name',
			'order'       => 'ASC'
		);

		$data['categories'] = $this->model_catalog_category->getCategories($filter_data);

		if (isset($this->request->post['product_category'])) {
			$data['product_category'] = $this->request->post['product_category'];
		} else {
			$data['product_category'] = array();
		}

		// Attributes
		$this->load->model('catalog/attribute');

		if (isset($this->request->post['product_attributes'])) {
			$data['product_attributes'] = $this->request->post['product_attributes'];
		} else {
			$data['product_attributes'] = array();
		}

		$results = $this->model_catalog_attribute->getAttributes();
		$data['attr_list'] = array();
			foreach ($results as $result) {
				$data['attr_list'][] = array(
					'attribute_id'    => $result['attribute_id'],
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
				);
			}
		
		$data['action'] = $this->url->link('import/attribute/action', 'token=' . $this->session->data['token'] . $url, true);
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('import/attribute', $data));
	}

}
