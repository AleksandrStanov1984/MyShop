<?php

// Heading
$_['heading_title'] = '<img width="24" height="24" src="view/image/neoseo.png" style="float: left;"><span style="margin:0;line-height 24px;">NeoSeo Мульти Экспорт</span>';
$_['heading_title_raw'] = 'NeoSeo Мульти Экспорт';

//Tab
$_['tab_general'] = 'Общие';
$_['tab_feeds'] = 'Экспорты';
$_['tab_formats'] = 'Форматы';
$_['tab_fields'] = 'Поля';
$_['tab_logs'] = 'Логи';
$_['tab_license'] = 'Лицензия';
$_['tab_support'] = 'Поддержка';

//Button
$_['button_clear_log'] = 'Очистить лог';
$_['button_save'] = 'Сохранить';
$_['button_save_and_close'] = 'Сохранить и Закрыть';
$_['button_close'] = 'Закрыть';
$_['button_recheck'] = 'Перепроверить';
$_['button_download_log'] = 'Скачать файл логов';

// Text
$_['text_module_version'] = '';
$_['text_module'] = 'Модули';
$_['text_success'] = 'Настройки модуля обновлены!';
$_['text_success_delete'] = 'Запись экспорта успешно удалена!';
$_['text_success_delete_format'] = 'Запись формата успешно удалена!';
$_['text_success_clear'] = 'Лог файл успешно очищен!';
$_['text_new_feed'] = 'Новый экспорт';
$_['text_del_feed'] = 'Удалить экспорт';
$_['button_clear_log'] = 'Очистить лог';
$_['text_feed'] = 'Каналы продвижения';
$_['text_success_options'] = 'Настройки модуля обновлены!';
$_['text_success'] = 'Настройки модуля обновлены!';
$_['text_select_all'] = 'Выделить всё';
$_['text_unselect_all'] = 'Снять выделение';
$_['text_bigmir'] = 'bigmir';
$_['text_hotline'] = 'hotline.ua';
$_['text_prom'] = 'prom.ua';
$_['text_yml'] = 'YML';
$_['text_custom'] = 'Зарезервировано';
$_['text_google'] = 'google merchant';
$_['text_link'] = 'По запросу';
$_['text_cron'] = 'По расписанию';
$_['text_description'] = '<p>Описание</p>';
$_['text_list'] = 'Список экспортов';
$_['text_list_format'] = 'Список форматов';
$_['text_edit'] = 'Редактирование экспорта';
$_['text_add'] = 'Добавление экспорта';
$_['text_edit_format'] = 'Редактирование формата';
$_['text_add_format'] = 'Добавление формата';
$_['text_none'] = 'Встроенные';

// Entry
$_['entry_status'] = 'Статус';
$_['entry_replace'] = 'Заменять перенос строки /br на \n';
$_['entry_unload'] = 'Не выгружать товары (черный список)';
$_['entry_id_format'] = 'Формат';
$_['entry_format'] = 'Формат';
$_['entry_debug'] = 'Отладка';
$_['entry_type'] = 'Формирование экспорта';
$_['entry_cron'] = 'CRON';
$_['entry_field_list_name'] = 'Переменная шаблона';
$_['entry_field_list_desc'] = 'Описание';
$_['entry_feed_format_name'] = 'Формат';
$_['entry_format_xml'] = 'XML код';
$_['entry_feed_name'] = 'Экспорт';
$_['entry_feed_name_desc'] = 'Название экспорта, будет отображаться во вкладке экспортов';
$_['entry_feed_shortname'] = '<label class="control-label">Название файла</label><br>Будет отображаться в урле, по которому будет доступен экспорт';
$_['entry_feed_status'] = 'Статус экспорта';
$_['entry_feed_status_desc'] = 'Отключение будет блокировать экспорт как по запросу, так и по расписанию';
$_['entry_data_feed'] = 'Адрес';
$_['entry_shopname'] = 'Название магазина';
$_['entry_shopname_desc'] = 'Короткое название магазина (название, которое выводится в списке найденных товаров. Не должно содержать более 20 символов)';
$_['entry_company'] = 'Компания';
$_['entry_company_desc'] = 'Полное наименование компании, владеющей магазином. Не публикуется, используется для внутренней идентификации';
$_['entry_categories'] = '<label class="control-label">Категории</label><br>Отметьте категории из которых надо экспортировать предложения';
$_['entry_manufacturers'] = '<label class="control-label">Производители</label><br>Отметьте производителей из которых надо экспортировать предложения';
$_['entry_currency'] = '<label class="control-label">Валюта предложений</label><br>Пересчет будет выполнен по курсу, заданному в админке';
$_['entry_out_of_stock'] = 'Статус &quot;Нет в наличии&quot;';
$_['entry_out_of_stock_desc'] = 'Прайс агрегаторы требуют чтобы им выгружался только товар в наличии. И для этой цели мы отсеиваем товары, которые выключены или у которых нулевой остаток. Но иногда нулевой остаток не показатель, а реальным показателем является статус товара. В данном поле вы указываете значение этого статуса, чтобы мы понимали что если остаток 0 и статус товара вот такой как тут указан, то товара нет с вероятностью 146%';
$_['entry_ip_list'] = '<label class="control-label">Список доверенных ip-адресов</label><br>Укажите свой личный айпи и айпи сервера прайс-агрегатора, чтобы больше никто не имел доступ к вашим товарам';
$_['entry_image_width'] = '<label class="control-label">Ширина картинки товара</label><br>Измеряется в пикселях, рекомендуемое значение - 600';
$_['entry_image_height'] = '<label class="control-label">Высота картинки товара</label><br>Измеряется в пикселях, рекомендуемое значение - 600';
$_['entry_pictures_limit'] = '<label class="control-label">Макс. кол-во картинок</label><br>Чаще всего агрегаторы принимают не более 10 картинок на товар. Укажите тут ограничение чтобы прайс агрегатор не сыпал ошибками';
$_['entry_delivery_status'] = 'Доставка';
$_['entry_delivery_status_desc'] = 'Включите, если есть ваш магазин осуществляет доставку';
$_['entry_pickup_status'] = 'Самовывоз';
$_['entry_pickup_status_desc'] = 'Включите, если у вас есть точки самовывоза';
$_['entry_store_status'] = 'Магазин';
$_['entry_store_status_desc'] = 'Включите, если у вас есть оффлайн магазины';
$_['entry_language_id'] = '<label class="control-label">Язык экспорта</label><br>Укажите язык описаний товаров и категорий';
$_['entry_feed_demand'] = 'Ссылка';
$_['entry_feed_cron'] = 'Ссылка';
$_['entry_product_id'] = 'Откуда брать код продукта';
$_['entry_product_id_desc'] = 'По умолчанию - product_id.';
$_['entry_product_name'] = 'Откуда брать название продукта';
$_['entry_product_name_desc'] = 'По умолчанию - name.';
$_['entry_product_desc'] = 'Откуда брать описание продукта';
$_['entry_product_desc_desc'] = 'По умолчанию - description.';
$_['entry_product_vendor'] = 'Откуда брать код производителя';
$_['entry_product_vendor_desc'] = 'По умолчанию - sku.';
$_['entry_attribute_status'] = 'Выгружать атрибуты';
$_['entry_option_status'] = 'Выгружать с учетом опций';
$_['entry_generate'] = 'Генерация кеша изображений';
$_['entry_generate_desc'] = 'Можно ускорить формирование выгрузки если заранее сформировать все кеши изображений';
$_['entry_feed_action'] = 'Действие';
$_['entry_use_original_images'] = '<label class="control-label">Использовать оригиналы изображений</label>';
$_['entry_sql_code'] = '<label class="control-label">SQL для тонкой настройки</label><br>Укажите любое SQL выражение с использованием префикса p.<br> "Например p.price > 100 или p.price > 100 and p.quantity > 0"';
$_['entry_use_main_category'] = '<label class="control-label">Использовать главную категорию</label>';
$_['entry_use_main_category_desc'] = 'Использовать поле "Главная категория", а не "Показывать в категориях"';
$_['entry_use_categories'] = '<label class="control-label">Используемые категории</label>';
$_['entry_sql_code_before'] = '<label class="control-label">SQL для подготовки данных</label><br>Укажите серию SQL запросов, которые будут выполнены перед формированием данных. Все запросы необходимо разделять точкой с запятой  - ";"';
$_['entry_store'] = 'Магазин';
$_['entry_use_warehouse_quantity'] = 'Использовать количество товара по складам';
$_['entry_warehouse'] = '<label class="control-label">Склады</label><br>Отметьте склады из которых надо брать остаток предложения. Если выбранно несколько складов, остаток будет суммироваться.';

//Success
$_['success_update_product_feed_categories'] = 'Связи товаров с категориями мультиэкспорта обновлены!';

// Error
$_['error_permission'] = 'У Вас нет прав для управления модулем NeoSeo Мульти Экспорт!';
$_['error_download_logs'] = 'Файл логов пустой или отсутствует!';
$_['error_ioncube_missing'] = '';
$_['error_license_missing'] = '';

//fields_desc
$_['field_desc_date'] = 'Дата экспорта. По умолчанию текущая дата';
$_['field_desc_url'] = 'URL адрес по которому доступен экспорт';
$_['field_desc_currency'] = 'Валюта предложений (устанавливается на вкладке экспорты)';
$_['field_desc_categories'] = 'Массив категорий экспорта';
$_['field_desc_category'] = 'Массив категории экспорта';
$_['field_desc_category.id'] = 'Идентификатор категории';
$_['field_desc_category.parentId'] = 'Инентификатор родительской категории';
$_['field_desc_category.name'] = 'Название категории';
$_['field_desc_offers'] = 'Массив товаров экспорта';
$_['field_desc_offer'] = 'Массив товара экспорта';
$_['field_desc_offer.id'] = 'Идентификатор экспорта';
$_['field_desc_offer.url'] = 'URL адрес товара';
$_['field_desc_offer.price'] = 'Цена товара';
$_['offer.currencyId'] = 'Валюта товара (устанавливается на вкладке экспорты)';
$_['offer.categoryId'] = 'Идентификатор категории товара';
$_['offer.name'] = 'Наименование товара';
$_['offer.description'] = 'Описание товара';
$_['offer.model'] = 'Модель товара';
$_['offer.vendor'] = 'Продавец товара';
$_['offer.vendorCode'] = 'Код продавца';
$_['offer.image'] = 'Массив ссылок на изображения товара';
$_['image'] = 'Ссылка на изображение товара';
$_['offer.options'] = 'Массив опций товаров';
$_['option'] = 'Массив опции товара';
$_['option.name'] = 'Наименование опции товара';
$_['option.value'] = 'Значение опции товара';
$_['option.available'] = 'Наличие товара';
$_['offer.attributes'] = 'Массив атрибутов товаров';
$_['attribute'] = 'Массив атрибута товара';
$_['attributes.name'] = 'Наименование атрибута';
$_['attributes.value'] = 'Значение атрибута';

$_['mail_support'] = '';
$_['module_licence'] = '';

$_['text_module_version']='59';
$_['error_license_missing']='<h3 style="color:red">Отсутствует файл с ключом!</h3>

<p>Для получения файла с ключом свяжитесь с NeoSeo по email <a href="mailto:license@neoseo.com.ua">license@neoseo.com.ua</a>, при этом укажите:</p>
<ul>
	<li>название сайта, на котором вы купили модуль, например: https://neoseo.com.ua</li>
	<li>название модуля, который вы купили, например: NeoSeo Обмен с 1С:Предприятие</li>
	<li>ваше имя пользователя (ник-нейм) на этом сайте, например, NeoSeo</li>
	<li>номер заказа на этом сайте, например, 355446</li>
	<li>основной домен сайта для которого и будет активирован файл с ключом, например, https://neoseo.ua</li>
</ul>

<p>Полученный файл с ключом положите в корень сайта, рядом с файлом robots.txt и нажмите кнопку "Проверить еще раз".</p>

<p>По любым вопросам пишите на support@neoseo.com.ua</p>';
$_['error_ioncube_missing']='<h3 style="color:red">Отсутствует IonCube Loader!</h3>

<p>Чтобы пользоваться нашим модулем, вам нужно установить IonCube Loader.</p>

<p>Для установки обратитесь в ТП Вашего хостинга</p>

<p>Если у вас не получается установить IonCube Loader самостоятельно, вы можете попросить помощи у наших специалистов по адресу <a href="mailto:support@neoseo.com.ua">support@neoseo.com.ua</a></p>';
$_['module_licence']='<h2>Условия лицензионного соглашения на использование программного обеспечения NeoSeo</h2>
<p>Благодарим вас за покупку программных продуктов нашей веб-студии.</p>
<p>Ниже приведены юридические условия, которые распространяются на всех, кто посещает наш сайт и пользуется нашими программными продуктами или услугами. Данные условия направлены на то, чтобы защитить ваши интересы и интересы ООО “НЕОСЕО” и его аффилированных структур и лиц (далее, "мы", "NeoSeo"), которые выступают в договорах от его имени.</p>
<p><strong>1. Введение</strong></p>
<p>Настоящие Условия использования NeoSeo (“Условия использования”) наряду с дополнительными условиями, которые касаются ряда конкретных услуг или программных продуктов, разработок и представлены на веб-сайте(-ах) NeoSeo, содержат условия и положения, действие которых распространяется на каждого посетителя или пользователя (“Пользователь”, “вы” или “Покупатель”) веб-сайта NeoSeo, приложений, дополнений и компонентов, предложенных нами наряду с предоставлением услуг и веб-сайта, если не указано иное (все услуги и программное обеспечение, программные модули предложенные через веб-сайт NeoSeo или вспомогательные сервисы, веб-сервисы, др. приложения от лица NeoSeo совместно именуются – “Услуги NeoSeo” или “Услуги”).</p>
<p>Условия NeoSeo являются обязательным юридическим договором между NeoSeo и вами – поэтому просим вас внимательно ознакомиться с ними.</p>
<p>Вы можете посещать и/или использовать Услуги NeoSeo только в том случае, если полностью согласны с Условиями NeoSeo: используя какую-либо из Услуг NeoSeo и/или подписываясь на неё, вы выражаете и подтверждаете своё согласие с данными Условиями использования и иными Условиями NeoSeo, например, условия предоставления услуг программирования в разрезе типичных и нетипичных задач, которые выписаны тут:   <a href="https://neoseo.com.ua/vse-chto-nujno-znat-klienty" target="_blank" class="external">https://neoseo.com.ua/vse-chto-nujno-znat-klienty</a> , (далее Условия NeoSeo).</p>
<p>Если вы не можете прочитать Условия NeoSeo, не понимаете их или не согласны с ними, вы должны незамедлительно покинуть Веб-сайт NeoSeo и не пользоваться Услугами NeoSeo.</p>
<p>Используя наши Программные продукты, Сервисы и Услуги, вы подтверждаете, что ознакомились с нашей Политикой конфиденциальности, доступной к просмотру по адресу <a href="https://neoseo.com.ua/politika-konfidencialnosti" target="_blank" class="external">https://neoseo.com.ua/politika-konfidencialnosti</a>   (“Политика конфиденциальности”).</p>
<p>Настоящий документ является лицензионным соглашением между вами и NeoSeo.</p>
<p>Принимая это соглашение или используя программное обеспечение, вы соглашаетесь со всеми настоящими условиями.</p>
<p>Настоящее соглашение относится к программному обеспечению NeoSeo, любым шрифтам, значкам, изображениям или звуковым файлам, предоставляемым в составе программного обеспечения, а также ко всем обновлениям, дополнениям или службам NeoSeo для программного обеспечения, если в их отношении не применяются иные условия. Это также касается разработанных в NeoSeo приложений и дополнений для SEO-Магазина, которые обеспечивают расширение его функциональных возможностей.</p>
<p>К использованию вами некоторых функций приложений могут применяться дополнительные условия NeoSeo и третьих лиц. Для корректной работы некоторых приложений необходимы дополнительные соглашения с отдельными условиями и политиками конфиденциальности, например с сервисами, предоставляющими услуги смс-нотификации.</p>
<p>Программное обеспечение не продается, а предоставляется по лицензии.</p>
<p>NeoSeo сохраняет за собой все права (например, права, предусмотренные законами о защите интеллектуальной собственности), которые не предоставляются явным образом в рамках настоящего соглашения. Например, эта лицензия не предоставляет вам права:</p>
<li>отдельно использовать или виртуализировать компоненты программного обеспечения;</li>
<li>публиковать или копировать (за исключением разрешенной резервной копии) программное обеспечение, предоставлять программное обеспечение в прокат, в аренду или во временное пользование;</li>
<li>передавать программное обеспечение (за исключением случаев, предусмотренных настоящим соглашением);</li>
<li>пытаться обойти технические ограничения в программном обеспечении;</li>
<li>изучать технологию, декомпилировать или деассемблировать программное обеспечение, а также предпринимать соответствующие попытки, кроме как в той мере и в тех случаях, когда это (а) разрешено применимым правом; (б) разрешено условиями лицензии на использование компонентов с открытым исходным кодом, которые могут входить в состав этого программного обеспечения; (c) необходимо для отладки изменений каких-либо библиотек, лицензируемых по малой стандартной общественной лицензии GNU, которые входят в состав программного обеспечения и связанны с ним;</li>
<p>Вы имеете право использовать данное программное обеспечение, только если у вас имеется соответствующая лицензия и программное обеспечение было должным образом активировано с использованием подлинного ключа продукта или другим разрешенным способом.</p>
<p>В стоимость лицензии SEO-Магазина не включены услуги установки, настройки и тем более его стилизации, также как и других платных/бесплатных дополнений к нему. Данные услуги являются дополнительными, стоимость зависит от количества необходимых для реализации часов, детальнее тут: <a href="https://neoseo.com.ua/vse-chto-nujno-znat-klienty" target="_blank" class="external">https://neoseo.com.ua/vse-chto-nujno-znat-klienty</a></p>
<p>С полной версией документа можно ознакомиться здесь:<a href="https://neoseo.com.ua/usloviya-licenzionnogo-soglasheniya" target="_blank" class="external">https://neoseo.com.ua/usloviya-licenzionnogo-soglasheniya</a>
</p>';
$_['mail_support']='<h2>Условия бесплатной и платной информационной и технической поддержки в <a class="external" href="https://neoseo.com.ua/" target="_blank">NeoSeo</a>.</h2>

<p>Поскольку мы уверены в том, что любая Качественная работа должна оплачиваться, все консультации, требующие предварительной подготовки ответа у нас платные, в т.ч. и разборы по ситуациям в стиле: &quot;посмотрите, а почему тут ВАШ модуль не работает?&quot;</p>

<p>Если ответ на Ваш вопрос уже у нас готов, Вы его получите бесплатно, но если для того, чтобы ответить нужно потратить время на то, чтобы разобраться в вопросе, изучить файлы, найти ошибку и подумать, прежде, чем что-то ответить, попросим оплатить.</p>

<p>Мы помогаем бесплатно <strong>по установке</strong> и <strong>устранению ошибок при установке</strong> купленных у нас модулей в порядке общей очереди.</p>

<p>С любыми вопросами обращайтесь на support@neoseo.com.ua.</p>

<p>С полной версией лицензионного соглашения ознакомьтесь здесь:  <a class="external" href="https://neoseo.com.ua/usloviya-licenzionnogo-soglasheniya" target="_blank">https://neoseo.com.ua/usloviya-licenzionnogo-soglasheniya</a></p>

<p><strong>Бонус за написание отзыва!</strong></p>

<p>Уважаемый покупатель, чтобы мы создавали наши программные продукты еще лучше и ты получал ещё больше, пожалуйста, оставь отзыв о нашем продукте или сотрудничестве с нашей веб-студией на нашей страничке Facebook, Google, Яндекса и OpenCartForum.com.</p>

<p>- пиши как есть, нам важно услышать честную и объективную оценку нашего решения.</p>

<p>Ссылки на наши модули и профили:</p>

<ul>
    <li>Профиль компании на OpenCartForum: <a class="external" href="https://opencartforum.com/topic/41195-neoseo/?page=5" target="_blank">https://opencartforum.com/topic/41195-neoseo/?page=5</a></li>
    <li><a class="external" href="https://www.facebook.com/neoseo.com.ua/" target="_blank">Facebook</a> кликните здесь: <a class="external" href="http://prntscr.com/g67dtz" target="_blank">http://prntscr.com/g67dtz</a></li>
    <li><a class="external" href="https://goo.gl/N6t2xw" target="_blank">Google</a>, сделайте клик вот тут: <a class="external" href="http://prntscr.com/g3se6f" target="_blank">http://prntscr.com/g3se6f</a></li>
    <li><a class="external" href="https://yandex.ru/maps/org/neoseo/1835577365/" target="_blank">Профиль компании на Яндексе</a> (отзыв должен пройти модерацию сервиса)</li>
</ul>

<p>В знак благодарности за потраченное на написание отзывов время, мы подготовили для вас бонус:</p>

<ol>
    <li>за написание отзыва на любых двух площадках: скидка - 50% на любой модуль.</li>
    <li>за написание отзыва на 4-х площадках - дарим любой нужный тебе модуль, кроме модуля обмена с 1С:Предприятие в подарок!</li>
</ol>

<p>Полный список возможных функциональных решений (модулей) находится здесь: <b>&nbsp;<a href="https://neoseo.com.ua/module-prices-in-rubles" target="_blank">https://neoseo.com.ua/module-prices-in-rubles</a>&nbsp;</b></p>

<p>Еще раз, большое спасибо за то, что вы с нами!</p>

<p>Команда NeoSeo</p>';
