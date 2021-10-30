<?php
abstract class Model {
	protected $registry;

	public function __construct($registry) {
		$this->registry = $registry;

		if (defined('DIR_CATALOG') && defined('VERSION')) {
			if (!defined('SC_VERSION')) define('SC_VERSION', (int)substr(str_replace('.','',VERSION), 0, 2));

			if (function_exists('modification')) {
				require_once(modification(DIR_SYSTEM . 'helper/seocmsprofunc.php'));
			} else {
				require_once(DIR_SYSTEM . 'helper/seocmsprofunc.php');
			}

			$this->registry->set('admin_work', true);
			$this->registry->set('seocms_is_admin', true);
		}
		if (is_callable(array($this->response, 'seocms_setRegistry')) && $this->registry) {
			$this->response->seocms_setRegistry($this->registry);
		}
    
	}

	public function __get($key) {
		return $this->registry->get($key);
	}

	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}
}