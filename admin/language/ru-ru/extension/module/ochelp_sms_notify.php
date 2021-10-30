<?php
$_['lang']                        = 'ru-RU';
// Heading
$_['heading_title']               = '<span class="text-danger">OC-HELP.com</span> - <i class="fa fa-commenting"></i> Смс уведомления';
$_['heading_main_title']          = 'OC-HELP.com - Смс уведомления';

// Text
$_['text_extension']              = 'Модули';
$_['text_success']                = 'Настройки модуля обновлены!';
$_['text_success_sms']            = 'Смс Успешно отправлено!';
$_['text_success_log']            = 'Лог очищен!';
$_['text_edit']                   = 'Редактирование модуля';
$_['text_phone_placeholder']      = '+38(012)1234567';

//Tabs
$_['tab_sms']                     = 'Произвольное смс';
$_['tab_template']                = 'Шаблоны смс';
$_['tab_setting']                 = 'Настройки уведомлений';
$_['tab_gate_setting']            = 'Настройки шлюза';
$_['tab_log']                     = 'Логи шлюза';
$_['tab_support']                 = 'Служба поддержки';

// Entry
$_['entry_template']              = 'Шаблон сообщения </br>';
$_['entry_sms_template']          = 'Заготовки для произвольных смс';
$_['entry_order_status']          = 'Смс для статусов:';
$_['entry_admin_alert']           = 'Отправить смс админу';
$_['entry_client_alert']          = 'Отправить смс покупателю';
$_['entry_order_alert']           = 'Смс при смене статуса заказа';

$_['entry_sms_gatename']          = 'SMS шлюз:';
$_['entry_sms_from']              = 'Отправитель';
$_['entry_sms_to']                = 'Номер телефона администратора';
$_['entry_sms_copy']              = 'Дополнительные номера';
$_['entry_sms_gate_username']     = 'Логин на SMS шлюз (или api_id)';
$_['entry_sms_gate_password']     = 'Пароль на SMS шлюз';
$_['entry_sms_log']               = 'Включить логи';

$_['entry_client_phone']          = 'Номер телефона:';
$_['entry_client_sms']            = 'Текст сообщения:';

$_['entry_admin_template']        = 'Шаблон смс администратору';
$_['entry_client_template']       = 'Шаблон смс покупателю';
$_['entry_order_status_template'] = 'Шаблон сообщений для статусов заказ';

//Button
$_['button_send']                 = 'Отправить смс';

$_['help_sms_from']               = 'Номер телефона или aлфавитно-цифровой отправитель';
$_['help_sms_copy']               = 'Введите номера через запятую (без пробелов) в международном формате +38(код оператора) или +7(код оператора) 1234567';
$_['help_phone']                  = 'Введите телефон в международном формате +38(код оператора) или +7(код оператора) 1234567';
$_['help_admin_template']         = 'Разрешенные теги:<br/>{ID} - Номер заказа<br/> {DATE} - Дата заказа<br/>{TIME} - Время заказа<br/>{SUM} - Сумма заказа<br/>{PHONE} - Телефон клиента';
$_['help_client_template']        = 'Разрешенные теги:<br/>{ID} - Номер заказа<br/>{DATE} - Дата заказа<br/>{TIME} - Время заказа<br/>{SUM} - Сумма заказа<br/>{PHONE} - Телефон клиента';
$_['help_order_status']           = 'Отправлять смс при смене статусов заказа';
$_['help_template']               = 'Разрешенные теги:<br/>{ID} - Номер заказа<br/>{DATE} - Дата заказа<br/>{TIME} - Время заказа<br/>{COMMENT} - Комментарий к заказу<br/>{SUM} - Сумма заказа<br/>{PHONE} - Телефон клиента<br/>{STATUS} - Статус заказа';

// Error
$_['error_permission']            = 'У Вас нет прав для управления этим модулем!';
$_['error_sms_setting']           = 'Ошибка: Пожалуйста сперва задайте настройки смс шлюза!';
$_['error_sms']                   = 'Ошибка: Смс не отправлено!';
$_['error_warning']               = 'Внимание: Файл логов %s занимает %s!';

$_['help_support']                = '<h2>Спасибо за покупку!</h2><h4>Тех.поддержка <a href="mailto:support@oc-help.com"><b>support@oc-help.com <img alt="OC-HELP.com" src="https://oc-help.com/icons/maillogo.png"></b></a></h4>';
$_['help_support']                .= '<div class="alert bg-success"><h4>Гарантирую работу на стандартных шаблонах (<b>Под нестандарт пишите, допилим!</b>).</p>';
$_['help_support']                .= '<p>Всем покупателям предоставляются консультации и бесплатная поддержка по работе модулей через e-mail.</p>';
$_['help_support']                .= '<p>Наиболее частые вопросы, ошибки и обновления можно найти на странице модуля (в зависимости от места покупки)<p><b>Мои модули в продаже только на opencartforum.com и liveopencart.ru</b></p></h4></div>';
$_['help_support']                .= '<p>Разработка и поддержка интернет-магазинов на Opencart <a href="https://oc-help.com" target="_blank">OC-HELP.COM <img alt="ochelplogo.png" src="https://oc-help.com/icons/ochelplogo.png" style="width:32px;height:auto;"></a></p>';
