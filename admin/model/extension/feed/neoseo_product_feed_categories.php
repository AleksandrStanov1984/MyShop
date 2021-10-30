<?php

require_once(DIR_SYSTEM . "/engine/neoseo_model.php");

class ModelExtensionFeedNeoSeoProductFeedCategories extends NeoSeoModel
{

	public function __construct($registry)
	{
		parent::__construct($registry);
		$this->_moduleSysName = 'neoseo_product_feed_categories';
		$this->_logFile = $this->_moduleSysName . '.log';
		$this->debug = $this->config->get($this->_moduleSysName . '_debug') == 1;
	}

	// Install/Uninstall
	public function install()
	{
		$sql = "
        CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_feed_categories` (
            `category_id` int(11) NOT NULL AUTO_INCREMENT,
            `parent_id` int(11) NOT NULL,
            `name` varchar(255) NOT NULL,
	    `system_category` int(11) NOT NULL,
	    `level` int(11) DEFAULT 0,
            PRIMARY KEY (`category_id`)
        ) DEFAULT CHARSET=utf8;
		";
		$this->db->query($sql);

		$sql = "
        CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_feed_categories_path` (
	     `category_id` int(11) NOT NULL,
	     `path_id` int(11) NOT NULL,
	     `level` int(11) NOT NULL,
	     PRIMARY KEY (`category_id`,`path_id`)
        ) DEFAULT CHARSET=utf8;
		";
		$this->db->query($sql);

		// Недостающие права
		$this->load->model('user/user_group');
		$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'catalog/' . $this->_moduleSysName);
		$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'catalog/' . $this->_moduleSysName);

		return TRUE;
	}

	public function upgrade()
	{
		$sql = "
        CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_feed_categories` (
            `category_id` int(11) NOT NULL AUTO_INCREMENT,
            `parent_id` int(11) NOT NULL,
            `name` varchar(255) NOT NULL,
	    `system_category` int(11) NOT NULL,
	    `level` int(11) DEFAULT 0,
            PRIMARY KEY (`category_id`)
        ) DEFAULT CHARSET=utf8;
		";
		$this->db->query($sql);

		$sql = "
        CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_feed_categories_path` (
	     `category_id` int(11) NOT NULL,
	     `path_id` int(11) NOT NULL,
	     `level` int(11) NOT NULL,
	     PRIMARY KEY (`category_id`,`path_id`)
        ) DEFAULT CHARSET=utf8;
		";
		$this->db->query($sql);

		// Недостающие права
		$this->load->model('user/user_group');
		$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'catalog/' . $this->_moduleSysName);
		$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'catalog/' . $this->_moduleSysName);

		return TRUE;
	}

	public function uninstall()
	{
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "product_feed_categories`");
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "product_feed_categories_path`");

		return TRUE;
	}

}

?>