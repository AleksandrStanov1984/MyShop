<?php
class ModelExtensionModuleBrokenLinks extends Model {

    public function __construct($registry) {
        parent::__construct($registry);
        $this->_moduleName = "Broken Links";
        $this->_moduleSysName = "broken_links";
    }

	public function clear() {
		$sql = "TRUNCATE TABLE `" . DB_PREFIX . "broken_notfound`";
		$this->db->query($sql);
		return true;
	}

	public function getTotalRecords($data=array()) {
		$sql = "SELECT COUNT(*) as total FROM `" . DB_PREFIX . "broken_notfound`";
		if (isset($data['data_filter']) && $data['data_filter']) {
		}
		
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function getRecords($data=array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "broken_notfound`";
		if (isset($data['data_filter']) && $data['data_filter']) {
		}
		
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY date_record";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'ASC')) {
			$sql .= " ASC";
		} else {
			$sql .= " DESC";
		}
	
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	

		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getBannerLinks($start = 0, $limit = 50) {

		$sql = "SELECT b.banner_id, b.name, bi.link FROM `" . DB_PREFIX . "banner_image` bi LEFT JOIN `" . DB_PREFIX . "banner` b ON(b.banner_id = bi.banner_id) WHERE b.status = '1' AND bi.link != '' AND bi.hide != '1' GROUP BY bi.link ORDER BY b.banner_id ASC";
		
		if (isset($start) || isset($limit)) {
			$sql .= " LIMIT " . (int)$start . "," . (int)$limit;
		}

		$query = $this->db->query($sql);

		$data = array();

		foreach($query->rows as $row) {

			if(stristr($row['link'], 'https://') === FALSE) {
		    $code = $this->checkUrl('https://'.$_SERVER['HTTP_HOST'].$row['link']);
		  } else {
		  	$code = $this->checkUrl($row['link']);
		  }
			

			if((int)$code == 404) {
				$data[$row['banner_id']][] = array(
					$row['name']	=> $row['link'] 
				);
			}
		
		}

		if($query->rows && empty($data)) {
			$data[0][] = array(
					'Идет проверка, ожидайте'	=> '#' 
				);
		}

		return $data;
	}

	public function getTotalBannerLinks() {

		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "banner_image` bi LEFT JOIN `" . DB_PREFIX . "banner` b ON(b.banner_id = bi.banner_id) WHERE b.status = '1' AND bi.link != '' AND bi.hide != '1' GROUP BY bi.link ORDER BY b.banner_id ASC";

		$query = $this->db->query($sql);

		return $query->num_rows;
	}


	private function checkUrl($url) {
		
		$headers = @get_headers($url);

		if (empty($headers[0])) {
		  $code = 'no response';
		} else {

		  $code = substr($headers[0], 9, 3);

		  if((int)$code == 301 || (int)$code == 302) {
		  	$link = substr($headers[5], 10);
		  	$code = $this->checkUrl($link);
		  }

		}

		return $code;
		
	}


    public function install() {

        $sql = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX ."broken_notfound` (
			`notfound_id` int(11) NOT NULL AUTO_INCREMENT,
			`ip` varchar(255) NOT NULL,
			`browser` varchar(1000) NOT NULL,
			`request_uri` varchar(1000) NOT NULL,
			`referer` varchar(1000) NOT NULL,
			`date_record` datetime NOT NULL,
			PRIMARY KEY (`notfound_id`)
			) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
        ";

        $this->db->query($sql);
        return true;
    }

    public function uninstall() {
        return true;
    }

}
?>