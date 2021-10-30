<?php
class ModelExtensionAnalyticsTSGoogleAnalytics extends Model {
	
	public function getGoals($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "ts_google_analytics_goal g";
		
		$sort_data = array(
			'g.goal_id',
			'g.action',
			'g.element',
			'g.event',
			'g.value',
		);
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY g.goal_id";
		}
		
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
			
			if ($data['limit'] < 1) {
				$data['limit'] = 100;
			}
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
	public function getGoal($goal_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ts_google_analytics_goal WHERE goal_id = '" . (int)$goal_id . "'");
		
		return $query->row;
	}
	
	public function getTotalGoals() {
		$sql = "SELECT COUNT(DISTINCT goal_id) AS total FROM " . DB_PREFIX . "ts_google_analytics_goal";
		
		$query = $this->db->query($sql);
		
		return $query->row['total'];
	}
	
	public function addGoal($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "ts_google_analytics_goal SET action = '" . $this->db->escape($data['action']) . "', category = '" . $this->db->escape($data['category']) . "', label = '" . $this->db->escape($data['label']) . "', element = '" . $this->db->escape($data['element']) . "', event = '" . $this->db->escape($data['event']) . "', value = '" . (int)$data['value'] . "'");
		
		$goal_id = $this->db->getLastId();
		
		return $goal_id;
	}
	
	public function editGoal($goal_id, $data) {
		
		$this->db->query("UPDATE " . DB_PREFIX . "ts_google_analytics_goal SET action = '" . $this->db->escape($data['action']) . "', category = '" . $this->db->escape($data['category']) . "', label = '" . $this->db->escape($data['label']) . "', element = '" . $this->db->escape($data['element']) . "', event = '" . $this->db->escape($data['event']) . "', value = '" . (int)$data['value'] . "' WHERE goal_id = '" . (int)$goal_id . "'");
		
		return true;
	}
	
	public function deleteGoal($goal_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "ts_google_analytics_goal WHERE goal_id = '" . (int)$goal_id . "'");
		
		return true;
	}
	
	public function checkGoal($action) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ts_google_analytics_goal WHERE action = '" . $this->db->escape($action) . "'");
		
		return ($query->num_rows > 0) ? true : false;
	}
	
	public function install() {
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ts_google_analytics_goal` (
			`goal_id` int(11) NOT NULL, 
			`action` varchar(64) NOT NULL, 
			`category` varchar(64) NOT NULL, 
			`label` varchar(255) NOT NULL, 
			`element` varchar(255) NOT NULL, 
			`event` varchar(12) NOT NULL, 
			`value` int(7) NOT NULL DEFAULT '0', 
			`status` int(1) NOT NULL DEFAULT '1'
			) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
		);
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "ts_google_analytics_goal` ADD PRIMARY KEY (`goal_id`);");
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "ts_google_analytics_goal` MODIFY `goal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;");
		
		
		// Goals
		if ($this->language->get('code') == 'ru' || $this->language->get('code') == 'ru-ru' || $this->language->get('code') == 'ua' || $this->language->get('code') == 'uk-ua') {
		
			$this->db->query("INSERT INTO `" . DB_PREFIX . "ts_google_analytics_goal` (`action`, `category`, `label`, `element`, `event`, `value`, `status`) VALUES
				('add_to_cart', 'goals', 'Добавление товара в корзину', '.product-thumb .button-group button:nth-child(1), #button-cart', 'click', '0', 1),
				('remove_from_cart', 'goals', 'Удаление товара из корзины', '#cart .dropdown-menu li:nth-child(1) button, body.checkout-cart form table tr td:nth-child(4) .input-group-btn button.btn-danger', 'click', '0', 1),
				('update_cart', 'goals', 'Изменение кол-ва товара в корзине', 'body.checkout-cart form table tr td:nth-child(4) .input-group-btn button.btn-primary', 'click', '0', 1),
				('add_to_wishlist', 'goals', 'Добавление товара в закладки', '.product-thumb .button-group button:nth-child(2), #content .row .col-sm-4 .btn-group button:nth-child(1)', 'click', '0', 1),
				('remove_from_wishlist', 'goals', 'Удаление товара из закладок', 'body.account-wishlist table tr td:nth-child(6) a.btn-danger', 'click', '0', 1),
				('add_to_compare', 'goals', 'Добавление товара в сравнение', '.product-thumb .button-group button:nth-child(3), #content .row .col-sm-4 .btn-group button:nth-child(2)', 'click', '0', 1),
				('remove_from_compare', 'goals', 'Удаление товара из сравнения', 'body.product-compare table tbody:last-child a.btn-danger', 'click', '0', 1),
				('go_to_cart', 'goals', 'Переход в корзину', '#cart .dropdown-menu li:nth-child(2) p a:nth-child(1)', 'click', '0', 1),
				('go_to_checkout', 'goals', 'Переход к оформлению заказа', '#cart .dropdown-menu li:nth-child(2) p a:nth-child(2)', 'click', '0', 1),
				('enter_coupon', 'goals', 'Применение купона', '#button-coupon', 'click', '0', 1),
				('enter_voucher', 'goals', 'Применение сертификата (ваучер)', '#button-voucher', 'click', '0', 1),
				('filtering_in_category', 'goals', 'Применение фильтра в категории', '#button-filter', 'click', '0', 1),
				('sorting_in_category', 'goals', 'Сортировка в категории', '#input-sort', 'change', '0', 1),
				('product_search', 'goals', 'Поиск товара', '#search button, #button-search', 'click', '0', 1),
				('product_review_form', 'goals', 'Отправка отзыва', '#button-review', 'click', '0', 1),
				('contact_form', 'goals', 'Обратная связь', 'body.information-contact form', 'submit', '0', 1),
				('currency_change', 'goals', 'Изменение валюты', '#currency button.currency-select', 'click', '0', 1),
				('customer_registration_form', 'goals', 'Регистрация покупателя', 'body.account-register form', 'submit', '0', 1),
				('customer_login_form', 'goals', 'Авторизация покупателя', 'body.account-login form', 'submit', '0', 1),
				('customer_account_edit', 'goals', 'Редактирование аккаунта покупателя', 'body.account-edit form', 'submit', '0', 1),
				('customer_password_edit', 'goals', 'Редактирование пароля покупателя', 'body.account-password form', 'submit', '0', 1),
				('customer_address_edit', 'goals', 'Редактирование адреса покупателя', 'body.account-address-edit form', 'submit', '0', 1),
				('customer_address_add', 'goals', 'Добавление адреса покупателя', 'body.account-address-add form', 'submit', '0', 1),
				('customer_newsletter_form', 'goals', 'Настройка подписки на рассылку', 'body.account-newsletter form', 'submit', '0', 1),
				('return_product_form', 'goals', 'Возврат товара', 'body.account-return-add form', 'submit', '0', 1);"
			);
			
		} else {
			
			$this->db->query("INSERT INTO `" . DB_PREFIX . "ts_google_analytics_goal` (`action`, `category`, `label`, `element`, `event`, `value`, `status`) VALUES
				('add_to_cart', 'goals', 'Adding product to cart', '.product-thumb .button-group button:nth-child(1), #button-cart', 'click', '0', 1),
				('remove_from_cart', 'goals', 'Removing product from cart', '#cart .dropdown-menu li:nth-child(1) button, body.checkout-cart form table tr td:nth-child(4) .input-group-btn button.btn-danger', 'click', '0', 1),
				('update_cart', 'goals', 'Changing the product quantity in the cart', 'body.checkout-cart form table tr td:nth-child(4) .input-group-btn button.btn-primary', 'click', '0', 1),
				('add_to_wishlist', 'goals', 'Adding product to wishlist', '.product-thumb .button-group button:nth-child(2), #content .row .col-sm-4 .btn-group button:nth-child(1)', 'click', '0', 1),
				('remove_from_wishlist', 'goals', 'Removing product from wishlist', 'body.account-wishlist table tr td:nth-child(6) a.btn-danger', 'click', '0', 1),
				('add_to_compare', 'goals', 'Adding product to compare', '.product-thumb .button-group button:nth-child(3), #content .row .col-sm-4 .btn-group button:nth-child(2)', 'click', '0', 1),
				('remove_from_compare', 'goals', 'Removing product from compare', 'body.product-compare table tbody:last-child a.btn-danger', 'click', '0', 1),
				('go_to_cart', 'goals', 'Go to cart', '#cart .dropdown-menu li:nth-child(2) p a:nth-child(1)', 'click', '0', 1),
				('go_to_checkout', 'goals', 'Go to checkout', '#cart .dropdown-menu li:nth-child(2) p a:nth-child(2)', 'click', '0', 1),
				('enter_coupon', 'goals', 'Coupon entered', '#button-coupon', 'click', '0', 1),
				('enter_voucher', 'goals', 'Voucher entered', '#button-voucher', 'click', '0', 1),
				('filtering_in_category', 'goals', 'Filtering in category', '#button-filter', 'click', '0', 1),
				('sorting_in_category', 'goals', 'Sorting in category', '#input-sort', 'change', '0', 1),
				('product_search', 'goals', 'Product search', '#search button, #button-search', 'click', '0', 1),
				('product_review_form', 'goals', 'Sending product review', '#button-review', 'click', '0', 1),
				('contact_form', 'goals', 'Sent a letter to feedback', 'body.information-contact form', 'submit', '0', 1),
				('currency_change', 'goals', 'Currency changed', '#currency button.currency-select', 'click', '0', 1),
				('customer_registration_form', 'goals', 'Customer registration', 'body.account-register form', 'submit', '0', 1),
				('customer_login_form', 'goals', 'Customer login to account', 'body.account-login form', 'submit', '0', 1),
				('customer_account_edit', 'goals', 'Editing customer account', 'body.account-edit form', 'submit', '0', 1),
				('customer_password_edit', 'goals', 'Editing customer password', 'body.account-password form', 'submit', '0', 1),
				('customer_address_edit', 'goals', 'Editing customer address', 'body.account-address-edit form', 'submit', '0', 1),
				('customer_address_add', 'goals', 'Adding customer address', 'body.account-address-add form', 'submit', '0', 1),
				('customer_newsletter_form', 'goals', 'Newsletter subscription', 'body.account-newsletter form', 'submit', '0', 1),
				('return_product_form', 'goals', 'Product returning', 'body.account-return-add form', 'submit', '0', 1);"
			);
		}

		return true;
	}

	public function uninstall() {
		$query = $this->db->query("DROP TABLE `" . DB_PREFIX . "ts_google_analytics_goal`;");
		return true;
	}
}
?>