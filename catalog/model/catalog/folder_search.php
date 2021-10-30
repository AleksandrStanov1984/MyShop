<?php
class ModelCatalogFolderSearch extends Model {
	

	public function createTable(){
		
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "product_description_search`;");
		
		$this->db->query("CREATE TABLE `" . DB_PREFIX . "product_description_search` (
		  `product_id` int(11) NOT NULL,
		  `language_id` int(11) NOT NULL,
		  `name` varchar(255) NOT NULL,
		  `description` text NOT NULL,
		  `tag` text NOT NULL,
		  `meta_title` varchar(255) NOT NULL,
		  `meta_description` varchar(255) NOT NULL,
		  `meta_keyword` varchar(255) NOT NULL,
		  PRIMARY KEY (`product_id`,`language_id`),
		  KEY `name` (`name`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

	
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "tag`;");
		
		$this->db->query("
				CREATE TABLE `" . DB_PREFIX . "tag` (
						`tag_id` int(11) NOT NULL AUTO_INCREMENT,
						`tag` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
						`code` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
						`search` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
						`view` int(11) NOT NULL,
						`sort_order` int(11) NOT NULL,
						`status` int(11) NOT NULL,
						`date_added` datetime NOT NULL,
						`date_modified` datetime NOT NULL,
						PRIMARY KEY (`tag_id`),
						KEY `text` (`tag`)
					  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
		
	}
	
	public function getTags($string) {
		$sql = "SELECT * FROM " . DB_PREFIX . "tag ";

		$sql .= ' WHERE `code` LIKE "%'.implode('%',$this->codeString($string)).'%" ';
		
		$sql .= " ORDER BY view DESC, sort_order ASC LIMIT 3";
		
		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function deleteDescription($product_id){
		
		$this->db->query("DELETE FROM `" . DB_PREFIX . "product_description_search` WHERE product_id='".$product_id."';");
		
	}
	
	public function insertDescription($data, $product_id){
		
		$this->deleteDescription($product_id);
		
		foreach ($data as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_description_search SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}
		
	}
	
	
	public function codeString($string){
		
		$string = trim(strip_tags(html_entity_decode($string, ENT_QUOTES, 'UTF-8')));
		
		//echo '<br><br>'.$string;
		
		if(!$string OR $string == '' OR $string == null) return array();
		
		$is_cyrillic = false;
		if (preg_match('/[А-Яа-я]/iu', $string) === 1)
		{
			$string = $this->translit($string);
			$is_cyrillic = true;
		}
	   
		$string = preg_replace(array('/[^\w\s]|\d/iu', '/\b[^\s]{1,3}\b/iu', '/\s{2,}/iu', '/^\s+|\s+$/iu'),
			array(' ', ' ', ' '), strtoupper($string));
		   
		if (!isset($string[0]))
			return array();
		   
		$matches = explode(' ', $string);
		foreach($matches as $key => $match)
			$matches[$key] = $this->dmword($match, $is_cyrillic);         
		
		return $matches;
	}

	public function translit($string){

		$language = $this->config->get('config_folder_search_language');
		
		$ru = array();
		$en = array();
		foreach($language as $index => $row){
			$ru[$index] = $row['ru'];
			$en[$index] = $row['en'];
		}
	   
		$string = str_replace($ru, $en, $string);   
		return $string;
	}

	public function dmword($string, $is_cyrillic = true){   
		static $codes = array(
			'A' =>  array(array(0, -1, -1),
				'I' =>  array(array(0, 1, -1)),
				'J' =>  array(array(0, 1, -1)),
				'Y' =>  array(array(0, 1, -1)),
				'U' =>  array(array(0, 7, -1))),
		   
			'B' =>  array(array(7, 7, 7)),
		   
			'C' =>  array(array(5, 5, 5), array(4, 4, 4),
				'Z' =>  array(array(4, 4, 4),
					'S' =>  array(array(4, 4, 4))),
				'S' =>  array(array(4, 4, 4),
					'Z' =>  array(array(4, 4, 4))),
				'K' =>  array(array(5, 5, 5), array(45, 45, 45)),
				'H' =>  array(array(5, 5, 5), array(4, 4, 4),
					'S' =>  array(array(5, 54, 54)))),
				   
			'D' =>  array(array(3, 3, 3),
				'T' =>  array(array(3, 3, 3)),
				'Z' =>  array(array(4, 4, 4),
					'H' =>  array(array(4, 4, 4)),
					'S' =>  array(array(4, 4, 4))),
				'S' =>  array(array(4, 4, 4),
					'H' =>  array(array(4, 4, 4)),
					'Z' =>  array(array(4, 4, 4))),
				'R' =>  array(
					'S' =>  array(array(4, 4, 4)),
					'Z' =>  array(array(4, 4, 4)))),
	 
			'E' =>  array(array(0, -1, -1),
				'I' =>  array(array(0, 1, -1)),
				'J' =>  array(array(0, 1, -1)),
				'Y' =>  array(array(0, 1, -1)),
				'U' =>  array(array(1, 1, -1))),
			   
			'F' =>  array(array(7, 7, 7),
				'B' =>  array(array(7, 7, 7))),
			   
			'G' =>  array(array(5, 5, 5)),
		   
			'H' =>  array(array(5, 5, -1)),
		   
			'I' =>  array(array(0, -1, -1),
				'A' =>  array(array(1, -1, -1)),
				'E' =>  array(array(1, -1, -1)),
				'O' =>  array(array(1, -1, -1)),
				'U' =>  array(array(1, -1, -1))),
			   
			'J' =>  array(array(4, 4, 4)),
		   
			'K' =>  array(array(5, 5, 5),
				'H' =>  array(array(5, 5, 5)),
				'S' =>  array(array(5, 54, 54))),
			   
			'L' =>  array(array(8, 8, 8)),
		   
			'M' =>  array(array(6, 6, 6),
				'N' =>  array(array(66, 66, 66))),
		   
			'N' =>  array(array(6, 6, 6),
				'M' =>  array(array(66, 66, 66))),
		   
			'O' =>  array(array(0, -1, -1),
				'I' =>  array(array(0, 1, -1)),
				'J' =>  array(array(0, 1, -1)),
				'Y' =>  array(array(0, 1, -1))),
			   
			'P' =>  array(array(7, 7, 7),
				'F' =>  array(array(7, 7, 7)),
				'H' =>  array(array(7, 7, 7))),
			   
			'Q' =>  array(array(5, 5, 5)),
		   
			'R' =>  array(array(9, 9, 9),
				'Z' =>  array(array(94, 94, 94), array(94, 94, 94)), // special case
				'S' =>  array(array(94, 94, 94), array(94, 94, 94))), // special case
			   
			'S' =>  array(array(4, 4, 4),
				'Z' =>  array(array(4, 4, 4),
					'T' =>  array(array(2, 43, 43)),
					'C' =>  array(
						'Z' => array(array(2, 4, 4)),
						'S' => array(array(2, 4, 4))),
					'D' =>  array(array(2, 43, 43))),
				'D' =>  array(array(2, 43, 43)),
				'T' =>  array(array(2, 43, 43),
					'R' =>  array(
						'Z' =>  array(array(2, 4, 4)),
						'S' =>  array(array(2, 4, 4))),
					'C' =>  array(
						'H' =>  array(array(2, 4, 4))),
					'S' =>  array(
						'H' =>  array(array(2, 4, 4)),
						'C' =>  array(
							'H' =>  array(array(2, 4, 4))))),
				'C' =>  array(array(2, 4, 4),
					'H' =>  array(array(4, 4, 4),
						'T' => array(array(2, 43, 43),
							'S' => array(
								'C' => array(
									'H' =>  array(array(2, 4, 4))),
								'H' => array(array(2, 4, 4))),
							'C' => array(
								'H' =>  array(array(2, 4, 4)))),
						'D' =>  array(array(2, 43, 43)))),
				'H' =>  array(array(4, 4, 4),
					'T' =>  array(array(2, 43, 43),
						'C' =>  array(
							'H' =>  array(array(2, 4, 4))),
						'S' =>  array(
							'H' =>  array(array(2, 4, 4)))),
					'C' =>  array(
						'H' =>  array(array(2, 4, 4))),
					'D' =>  array(array(2, 43, 43)))),
				   
			'T' =>  array(array(3, 3, 3),
				'C' =>  array(array(4, 4, 4),
					'H' =>  array(array(4, 4, 4))),
				'Z' =>  array(array(4, 4, 4),
					'S' =>  array(array(4, 4, 4))),
				'S' =>  array(array(4, 4, 4),
					'Z' =>  array(array(4, 4, 4)),
					'H' =>  array(array(4, 4, 4)),
					'C' =>  array(
						'H' =>  array(array(4, 4, 4)))),
				'T' =>  array(
					'S' =>  array(array(4, 4, 4),
						'Z' =>  array(array(4, 4, 4)),
						'C' =>  array(
							'H' =>  array(array(4, 4, 4)))),
					'C' =>  array(
						'H' =>  array(array(4, 4, 4))),
					'Z' =>  array(array(4, 4, 4))),
				'H' =>  array(array(3, 3, 3)),
				'R' =>  array(
					'Z' =>  array(array(4, 4, 4)),
					'S' =>  array(array(4, 4, 4)))),
				   
			'U' =>  array(array(0, -1, -1),
				'E' =>  array(array(0, -1, -1)),
				'I' =>  array(array(0, 1, -1)),
				'J' =>  array(array(0, 1, -1)),
				'Y' =>  array(array(0, 1, -1))),
			   
			'V' =>  array(array(7, 7, 7)),
		   
			'W' =>  array(array(7, 7, 7)),
		   
			'X' =>  array(array(5, 54, 54)),
		   
			'Y' =>  array(array(1, -1, -1)),
		   
			'Z' =>  array(array(4, 4, 4),
				'D' =>  array(array(2, 43, 43),
					'Z' =>  array(array(2, 4, 4),
						'H' =>  array(array(2, 4, 4)))),
				'H' =>  array(array(4, 4, 4),
					'D' => array(array(2, 43, 43),
						'Z' =>  array(
							'H' =>  array(array(2, 4, 4))))),
				'S' =>  array(array(4, 4, 4),
					'H' =>  array(array(4, 4, 4)),
					'C' =>  array(
						'H' =>  array(array(4, 4, 4))))));
					   
		$length = strlen($string);
		$output = '';
		$i = 0;
		
	   
		$previous = -1;
	   
		while ($i < $length){
			
			$current = $last = &$codes[$string[$i]];
		   
			for ($j = $k = 1; $k < 7; $k++){
				
				if (!isset($string[$i + $k]) ||
					!isset($current[$string[$i + $k]])){
					break;
				}
				   
				$current = &$current[$string[$i + $k]];                     
			   
				if (isset($current[0])){
					$last = &$current;
					$j = $k + 1;
				}
			}
		   
						   
			if ($i == 0)
				$code = $last[0][0];
			elseif (!isset($string[$i + $j]) || ($codes[$string[$i + $j]][0][0] != 0))
				$code = $is_cyrillic ? (isset($last[1]) ? $last[1][2] : $last[0][2]) : $last[0][2];
			else
				$code = $is_cyrillic ? (isset($last[1]) ? $last[1][1] : $last[0][1]) : $last[0][1];
		
			if (($code != -1) && ($code != $previous))
				$output .= $code;
			   
			$previous = $code;
		   
			$i += $j;
			   
		}
	   
		//return str_pad(substr($output, 0, 6), 6, '0');
		return substr($output, 0, 6);
	}
	
}

