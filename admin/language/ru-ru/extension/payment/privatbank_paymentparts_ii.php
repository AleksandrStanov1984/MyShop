<?php
// Heading
$_['heading_title']    					= 'Мгновенная рассрочка (ПриватБанк)';

//Text
$_['text_module']						= 'Оплата';
$_['text_extension']	 				= 'Платежи';
$_['text_success']						= 'Настройки модуля успешно обновлены!';
$_['text_edit']							= 'Редактирование модуля';
$_['text_privatbank_paymentparts_ii'] 	= '<a target="_BLANK" href="https://payparts2.privatbank.ua/ipp/"><img src="view/image/payment/ip_logo.png" alt="Privatbank Paymentparts" title="Privatbank Paymentparts" style="width: 35px;" /></a>';
$_['text_paymentparts_url']				= '<p for="input-shop-id">Для получения идентификатора и пароля, необходимо зарегистрировать магазин в <a target="_BLANK" href="https://payparts2.privatbank.ua/ipp/">Личном кабинете Приват банка</a></p>';

//Entry
$_['entry_shop_id']						= 'Идентификатор магазина:';
$_['entry_shop_password']				= 'Пароль магазина:';
$_['entry_payment_type']				= 'Тип платежа:';
$_['entry_payment_type_standart']		= 'Стандартный платеж';
$_['entry_payment_type_hold']			= 'Платеж с холдом';
$_['entry_paymentquantity']				= 'Максимум месяцев:';
$_['entry_markup']						= 'Коэффициент наценки:';
$_['entry_min_total']					= 'Минимальная цена:';
$_['entry_max_total']					= 'Максимальная цена:';
$_['entry_status']						= 'Статус:';
$_['entry_sort_order']					= 'Порядок сортировки:';
$_['entry_geo_zone']    				= 'Географическая зона:';

$_['entry_enabled']    					= 'Допустимые товары:';
$_['entry_enabled_cat']    				= 'Категории допустимых товаров:';
$_['entry_enabled_productcard']    		= 'Включенные в карточке товара и/или добавленные в список ниже';
$_['entry_enabled_all']    				= 'Все товары';

//Payment State order Statuses
$_['entry_completed_status']    		= 'Статус "платеж успешно совершен"';
$_['entry_failed_status']       		= 'Статус "ошибка при создании платежа"';
$_['entry_canceled_status']     		= 'Статус "платеж отменен"';
$_['entry_rejected_status']     		= 'Статус "платеж отклонен"';
$_['entry_clientwait_status']   		= 'Статус "ожидание"';
$_['entry_created_status']      		= 'Статус "платеж создан"';

//Error
$_['error_permission'] 					= 'У Вас нет прав для управления этим модулем!';
$_['error_shop_id']						= 'Необходимо ввести ID магазина!';
$_['error_shop_password']				= 'Необходимо ввести пароль магазина!';
$_['error_paymentquantity']				= 'Необходимо указать максимальное количество платежей, не более 24!';

//Payment order status tab
$_['tab_order_status']					= 'Статус Заказа';

//Help
$_['help_paymentquantity']				= 'Введите максимальный срок кредитования';
$_['help_markup']						= 'Если необходимо, установите наценку на стоимость товара, например 1.027';
$_['help_enabled']						= "Если необходимо ограничить доступные для оформления товары, выберите их тут или активируйте в карточке товара во вкладке Приватбанк";
$_['help_min_total']					= "Введите минимальную стоимость товара(ов), выше которой будет доступна рассрочка";
$_['help_max_total']					= "Введите максимальную стоимость товара(ов), ниже которой будет доступна рассрочка";
$_['help_payment_type']					= 'При выборе стандартного платежа, сумма первого платежа будет сразу переведена на Ваш счет, при выборе плажета с холдом, сумма первого платежа будет заблокирована на счете клиента до подтверждения заказа менеджером';