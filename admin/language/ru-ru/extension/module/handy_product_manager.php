<?php

/**
 * @category   OpenCart
 * @package    Handy Product Manager
 * @copyright  © Serge Tkach, 2018, http://sergetkach.com/
 */

// Heading
$_['heading_title'] = 'Handy Product Manager';

// Text
$_['text_extension']			 = 'Расширения';
$_['text_success']				 = 'Настройки модуля обновлены!';
$_['text_edit']						 = 'Настройки модуля';
$_['text_author']					 = 'Автор';
$_['text_author_support']	 = 'Поддержка';
$_['text_as_is']					 = 'Исходное название файла в транслит';
$_['text_by_formula']			 = 'По формуле в транслит';
$_['text_input_licence_list']	 = 'Для работы со списком товаров необходимо активировать лицензию на странице с настройками модуля';
$_['text_input_licence_mass']	 = 'Для работы с массовым редактированием товаров необходимо активировать лицензию на странице с настройками модуля';

$_['text_none']						 = '- Не выбрано -';

// Button
$_['button_save']					 = 'Сохранить';
$_['button_cancel']				 = 'Отмена';
$_['button_save_licence']	 = 'Сохранить лицензию';

// Entry
$_['entry_licence']										 = 'Код лицензии';
$_['entry_status']										 = 'Статус';
$_['entry_system']										 = 'Используемая сборка OpenCart';
$_['entry_test_mode']									 = 'Включить логи (только для разработчиков)';
$_['help_test_mode']									 = 'Логи могут понять, на каком этапе происходит ошибка. Логи записываются в корневую директорию сайта. Не забудьте выключить их после тестирования';

$_['fieldset_product_list']						 = 'Настройки списка товаров';
$_['entry_product_list_field']				 = 'Какие из стандартных полей<br>отображать в списке товаров';
$_['entry_product_list_field_custom']	 = 'Какие из кастомных полей<br>отображать в списке товаров';
$_['entry_product_list_limit']				 = 'Сколько товаров <br>показывать в списке товаров';
$_['entry_product_edit_model_require'] = 'Поле "Модель" (model) обязательно для заполнения (по умолчанию в системе является обязательным)';
$_['entry_product_edit_sku_require']	 = 'Сделать поле "Артикул" (по английски sku) обязательным для заполнения';

$_['fieldset_translit']				 = 'Настройки SEO URL';
$_['entry_transliteration']		 = 'Настройки транслитерации для SEO URL';
$_['entry_language_id']				 = 'Исходный язык';
$_['entry_translit_function']	 = 'Правило транслитерации';
$_['entry_translit_formula']	 = 'Формула транслитерации для SEO URL товаров';

$_['fieldset_upload']							 = 'Настройки для загрузки фото';
$_['entry_upload_rename_mode']		 = 'Принцип называния фото';
$_['entry_upload_rename_formula']	 = 'Если переназывать фото по формуле, то использовать переменные';
$_['text_available_vars']					 = 'Доступные переменные';
$_['entry_upload_max_size_in_mb']	 = 'Макс размер загружаемых фото в МБ';
$_['entry_upload_mode']						 = 'Способ распределения фото по папкам';
$_['text_branch']									 = 'Разветвлять папку products цифрами 1,2,3,..., n по 100 фото в каждой';
$_['text_dir_for_category']				 = 'Помещать фото товара в папку главной родительской категории - должен быть установлен SeoPro для определения главной категории';

// for OpenCart PRO
$_['entry_options_buy']				 = 'Заменить опции на опции с кнопкой купить';

// Success
$_['success_licence'] = 'Лицензия успешно сохранена!';

// Error
$_['error_warning']									 = 'Неправильные настройки. Проверьте все поля!';
$_['error_permission']							 = 'У Вас нет прав для управления данным модулем!';
$_['error_licence']									 = 'Код лицензии недействителен';
$_['error_licence_empty']						 = 'Введите код лицензии!';
$_['error_licence_not_valid']				 = 'Код лицензии не действителен!';
$_['error_product_list_limit']			 = 'Лимит товаров не должен быть пустым!';
$_['error_product_list_limit_small'] = 'Лимит товаров не должен быть меньше 10!';
$_['error_product_list_limit_big']	 = 'Лимит товаров не должен быть больше 500!';
$_['error_translit_formula_empry']	 = 'Заполните формулу для транслитерации!';
$_['error_rename_formula_empty']		 = 'Укажите формулу для переименования фотографий по формуле в транслит';
$_['error_formula_less_vars']				 = 'Используйте хотя бы одну переменную в формуле!';
$_['error_formula_pattern']				   = 'Не используйте в формуле другие символы, кроме названий переменных и черточки (-)';
$_['error_max_size_in_mb']					 = 'Укажите макс размер фото для загрузки в Мегабайтах';




/* For Column Left
  ----------------------------------------------------------------------------- */
$_['text_hpm_menu'] = 'Handy Product Manager';
$_['text_hpm_product'] = 'Список товаров';
$_['text_hpm_mass_edit'] = 'Массовый редакт';



/* For Mass Edit
  ----------------------------------------------------------------------------- */
$_['mass_edit_title'] = 'Массовое редактирование';
$_['mass_edit_heading_title'] = 'Массовое редактирование — Handy Product Manager';
$_['mass_text_none']						 = '- Не выбрано -';
$_['mass_text_notset']					 = 'A! - Не заполнено в товаре';
$_['mass_text_notset_category']	 = 'A! - Не заполнено или совпадает с главной категорией';
$_['mass_text_notset2']					 = 'A! - Не присвоено ни одного';

$_['mass_entry_category_flag'] = 'Товары должны содержать';
$_['mass_entry_category'] = 'Выбрать категории';
$_['mass_entry_select_all'] = 'Выбрать ВСЕ товары для редактирования';
$_['mass_entry_manufacturer'] = 'Производители';
$_['mass_entry_attribute'] = 'Атрибут';
$_['mass_entry_attribute_value'] = 'Значение <font class="hidden visible_lg-ib">атрибута</font>'; // span is reservet for help ic OC
$_['mass_entry_option'] = 'Опции';
$_['mass_text_date'] = 'Товар был добавлен';
$_['mass_entry_date_from'] = 'с';
$_['mass_entry_date_before'] = 'до';

$_['entry_attribute_value'] = 'Значение';
$_['entry_option'] = 'Опция';
$_['entry_flag'] = '- Выбрать действие -';
$_['entry_category_flag'] = 'Как поступить с выбранными категориями';
$_['text_flag_reset_add'] = 'Обнулить старые значения, затем добавить выбранные';
$_['text_flag_add'] = 'Добавить выбранные значения к существующим';
$_['text_flag_and'] = 'AND';
$_['text_flag_or'] = 'OR';
$_['text_flag_and_category'] = 'Все выбранные категории одновременно';
$_['text_flag_or_category'] = 'Хотя бы одну из выбранных категорий';

$_['text_available_vars'] = 'Доступные переменные';



$_['text_flag_discount_clear'] = 'Очистить предыдущие скидки';
$_['text_flag_special_clear'] = 'Очистить предыдущие акции';

$_['button_execute'] = 'Выполнить запрос';

$_['text_processing'] = 'Выполняется обработка данных...';
$_['success_item_step'] = "Шаг <b>%1\$d</b> из <b>%2\$d</b> выполнен успешно";
$_['success_item_step_finish'] = "Ура! Обновление товаров завершено успешно!";
$_['error_warning_mass'] = 'Внимание! Не верно заполненны данные для массового редактирования';
$_['error_item_step'] = 'Ошибка на шаге <b>%1\$d</b> из <b>%2\$d</b>:';
$_['error_no_count'] = 'Ошибка: Не удалось получить кол-во товаров по заданным параметрам';
$_['error_no_products'] = 'Ошибка: Нет товаров, которые отвечают выбранным фильтрам';
$_['error_ajax_response'] = 'Произошла ошибка в методе massEditProcessing()!';
$_['error_select_all_need'] = 'Вы не выбрали ни одного фильтра. Подтвердите намерение измененить ВСЕ товары на сайте! Для этого отметьте галочку "<b>Выбрать ВСЕ товары для редактирования</b>". Затем снова нажмите кнопку';
$_['error_select_all_remove'] = 'Вы выбрали фильтры и при этом нажали галочку "<b>Выбрать ВСЕ товары для редактирования</b>". Либо снимите галочку, либо откажитесь от других фильтров. Затем снова нажмите кнопку';
$_['error_edit_var_not_allowed'] = 'В поле %s обнаружена недопустимая переменная';



/* For Product List
  ----------------------------------------------------------------------------- */
$_['hpm_title']					 = 'Список товаров — Handy Product Manager';
$_['hpm_heading_title']	 = 'Список товаров';

$_['hpm_filter_text_none']						 = '- Не выбрано для фильтрации -';
$_['hpm_filter_text_notset']					 = 'A! - Не заполнено в товаре';
$_['hpm_filter_text_notset_category']	 = 'A! - Не заполнено или совпадает с главной категорией';
$_['hpm_filter_text_notset2']					 = 'A! - Не присвоено ни одного';
$_['hpm_filter_text_min']							 = 'От';
$_['hpm_filter_text_max']							 = 'До';

$_['hpm_error_report_title'] = 'Ошибка!';
$_['hpm_text_report_log']		 = 'reportModal должен был быть вызван по отсрочке';
$_['hpm_error_empty_post']	 = 'Данные, переданные для живого обновления, оказались пустыми!';
$_['hpm_success']						 = 'Данные обработаны!';

$_['hpm_upload_text_photo_main']		 = 'Загрузить главное фото';
$_['hpm_upload_text_drag_and_drop']	 = 'Для загрузки, перетащите файлы сюда.';

$_['hpm_upload_error_no_category']			 = 'Сначала выберите категорию товара, а потом загружайте фото';
$_['hpm_upload_error_no_category_main']	 = 'Сначала выберите главную категорию товара, а потом загружайте фото';
$_['hpm_upload_error_no_product_name']	 = 'Название товара используется при замене названия файла. Заполните это поле!';
$_['hpm_upload_error_no_model']					 = 'Модель используется при замене названия файла. Заполните это поле!';
$_['hpm_upload_error_no_sku']						 = 'Артикул используется при замене названия файла. Заполните это поле!';
$_['hpm_upload_error_result']						 = '(!) Ошибка: Файл ([file]) не удалось переместить из временного местоположения в целевой адрес [target]!';
$_['hpm_upload_error_max_size']					 = 'Фото ([file]) превышает допустимый размер файла';
$_['hpm_upload_error_file_extenion']		 = 'Фото ([file]) имеет недопустимое расширение';

$_['hpm_filter_entry_product_id']			 = 'ID товара (! нивелирует остальные фильтры)';
$_['hpm_filter_entry_sku']						 = 'Артикул товара (! нивелирует остальные фильтры)';
$_['hpm_filter_entry_model']					 = 'Модель товара (! нивелирует остальные фильтры)';
$_['hpm_filter_entry_keyword']				 = 'SEO URL (! нивелирует остальные фильтры)';
$_['hpm_filter_entry_category']				 = 'Относится к категории';
$_['hpm_filter_entry_category_main']	 = 'Главная категория';
$_['hpm_filter_entry_attribute_value'] = 'Значение <font class="hidden visible_lg-ib">атрибута</font>'; // span is reservet for help ic OC

$_['hpm_text_select_all']							 = 'Выбрать все';
$_['hpm_text_unselect_all']						 = 'Снять выбор со всех';

$_['hpm_column_identity']			 = 'Идентичность';
$_['hpm_column_category']			 = 'Категории';
$_['hpm_btn_generate_seo_url'] = 'Сгенерировать SEO URL';

$_['hpm_text_product_id']			 = 'ID товара (product_id)';
$_['hpm_entry_main_category']	 = 'Выбрать главную категорию';
$_['hpm_text_product_new']		 = 'Новый товар';
$_['hpm_entry_discount']			 = 'Цена со скидкой';
$_['hpm_entry_special']				 = 'Акционная цена';
$_['hpm_entry_customer_group'] = 'Гр. клиента';
$_['hpm_entry_date_start']		 = 'Начало';
$_['hpm_entry_date_end']			 = 'Конец';

$_['hpm_text_custom_fields']	= 'Кастомные поля';
$_['hpm_text_custom_fields_price']	= 'Кастомные поля с ценой';
$_['hpm_text_custom_fields_description'] = 'Название поля';
$_['hpm_text_custom_fields_type_price']	= 'Поле с ценой';
$_['entry_field_key']	= 'Ключ поля в базе данных';
$_['entry_field_name']	= 'Название поля в списке товара';
$_['entry_field_type']	= 'Тип поля';
$_['hpm_text_custom_fields_type_other']	= 'Другое';


$_['hpm_column_description']					 = 'Описание товара';

$_['hpm_text_attribute_select']				 = 'Выбрать атрибут';
$_['hpm_text_attribute_edit']					 = 'Редактировать атрибут';
$_['hpm_text_attribute_new']					 = 'Новый атибут';
$_['hpm_text_attribute_group_select']	 = 'Выбрать группу атрибута';
$_['hpm_text_attribute_new_save']			 = 'Сохранить';
$_['hpm_text_attribute_values_select'] = 'Выберите значение';
$_['hpm_text_attribute_values_empty']	 = 'Значений нет';

$_['hpm_text_option_select'] = 'Выбрать опцию';
$_['hpm_text_option_edit']	 = 'Редактировать опцию';
$_['hpm_text_option_new']		 = 'Новая опция';

$_['hpm_button_delete_product'] = 'Удалить этот товар';
$_['hpm_button_delete_confirm'] = 'Подтвердите удаление';




/* Copy & Clone
  ----------------------------------------------------------------------------- */
$_['hpm_entry_products_row_number']				 = 'Кол-во';
$_['hpm_entry_clone']											 = 'Пометить для клонирования';
$_['hpm_entry_clone_images']							 = 'Клонировать изображения';
$_['hpm_help_clone_images']								 = 'Имеет значение ТОЛЬКО при клонировании конкретного выбранного товара';
$_['hpm_text_add_new_products_row']				 = 'Добавить товар';
$_['hpm_text_add_new_products_row_clone']	 = 'Клонировать товар';

$_['hpm_text_view_product_in_catalog']		 = 'Смотреть товар на сайте';
$_['hpm_text_edit_product_in_system_mode'] = 'Редактировать товар <br>в стандартном интерфейсе системы';
$_['text_success_delete']									 = 'Выбранные товары удалены!';
$_['text_error_add_new_tr']								 = 'Произошла ошибка при создании нового товара';

