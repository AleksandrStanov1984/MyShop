<?php
$oc15 = (version_compare(VERSION, "2.0", "<"))? true:false;
// Heading
// Обязательно без перевода строки! Иначе в JS будет ошибка. Opencart удаляет из названия модуля теги, но не удаляет перевод строки. В итоге получается JS код с разрывом.
$_['module_ver'] = '1.10.7 beta 7';

$_['heading_title']  = '';
if(!$oc15) $_['heading_title']  = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAmCAMAAACf4xmcAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAYBQTFRF4eXvLUmb1dvpGzmSRF2l+fr5IT2VaHy1pbHSKkWZg5PBXnSxoazRl6XLvcbd2N7q5enxjZzHwMreboG4OVKf7vD1nKnOZHiz9ff5YXax3OHsqrbUPVWhTGOoyM/iFTOPztXmtb/ZiZnFSmGndoi80tnnGDaRWG6w6ezzxc7h/f387O7ywcrhJECWrbjWWm6vVmyt4ufwU2msvMXeucLaJkKX8fP3fIy/9/n5eIq+j57I7O/0mafMFjSQ0dfoNU+eV2uq/f78c4W6KEOX29/rUmisP1iiJ0KY/Pz78/X4nqzRUGepM02d3+TtJECVLEeZs73YkJ/Ifo/Ae42/L0mcJUGWL0qbUWir////Iz+V///+///9/v7+/v/9/v79/v/+2+DsKESY/f7+r7nYbH+3oKzN5+zxt8DXtsDZlKLJ/v//+/z7usPc//7+usTa6Ovy6Ov06u30W3CwiJjD+vv7R1+nxMvgytHly9TjNlCf/v78+fn70dfnJUKXsbvYgJDAoMq80wAAAtNJREFUeNp0lPlf0mAcxwfPHEOQQ+5jDTlGYsgAIRWJcgh5xDzYejZUpOhAy5KUIiv+9YYbOHA+P+y1PXs/n+d7I1B7iZOfyPTvbduZFXEl4COYKJ1vxDq+CsvVWqXdw8u8WlKl9vtzCqPYiCe61n7pBFRl/dtDtQbUmyjOs4xc3325FmedpBMXH6jhLGj/UZtTmNuj2q4JTBTDoL8vG3i/3njI3bQKE6G9GDmTLp5ar2cp4urOEVktACI2zfCFi77bMWZlS354ooWdbJIHo0sTPrD/SDKgC2X0CpYFhrHtX6e5FaotY02ToIrEUjZrycbGWRVPuzVJDjmG1ppHFhs+0qiQq3It/HxcAgvFMBSRU7hRXFaO2uxrGY6v1+vGfvRoXuaaeWfkGiInoseoxHCJABjH61pVltclMW7kloM7g4jorRAXUIkeWsYFtmsI5nieT3ab8q1uakVywaYzKMd2sOC/2X7PH0s7JK61dSxvX1JuCSsLzxXMLOhqmMUSzDmWCCPPZBTsJ7BLmB4bjDHeeOM30AL41BHusRAWljA/t6bCCOthFO0H3CrsCViXsO91jzjGdOwvvPMhauu2RpgUOMoseTqDorcjFyTDd8u9hbSdk97evpOxDmUZxq39t6wUsITxTPDQTud0PJ+jlXQN4yplAS+alWp1YgzDJAHAqgxTBW559yOfeTXMKcLSCVk+ZKDj8VQqPlypHaVXcXJOLiQHmB91+vm4UpSKF1cJXVrGQhh9rTURFLHBqMij5IYmMrR3r2QbYU+DuR481aK241RgqCB3Vo8rhbSo1TZ5JDbvuz6A7VkeUlce0rCq6voGXG4lD7xT1DOUdHgnZkgDLqIk8X5bNehebGLJg8TkqBEbsDAwUmh43uZNNGYKMbOJA/QTzWmpHzgB4NGtTMQpUIxp4QKK2kO18OWHj6hUbugoXoaPTEvFytt83tuc3v0vwACIJaTazt/ogwAAAABJRU5ErkJggg==">';
$_['heading_title'] .= '<img title="Сайт разработчика: sitecreator.ru" style="padding-right: 5px;" src="data:image/png;base64,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">';
$_['heading_title'] .= '<span class="head_wm_sitecreator">Image Compressor & Watermark & WebP etc. by Sitecreator '.$_['module_ver'].'</span>';
$_['heading_title'] .= '<img onload="$(\'.head_wm_sitecreator:eq(1)\').closest(\'tr\').hide();" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==">';

//
// Text
//$_['text_enabled']         = 'Модули';
//$_['text_success']        = 'Настройки модуля обновлены!';

$_['text_edit'] 		= 'Настройки модуля';
$_['button_save'] = 'Сохранить';
$_['button_save_and_noclose'] = 'Сохранить и остаться';
$_['button_cancel'] = 'Отменить';

$_['text_tab_main'] 		= 'Основные настройки';

$_['text_tab_service'] 	= 'Сервис';
$_['text_tab_theme'] 		= 'Оптимизация шаблона (темы) и др. ';

$_['text_tab_help'] 		= 'Документация';

$_['text_compress_theme'] 		= '<span data-toggle="tooltip" title="Сжать все изображения всех шаблонов (тем) движка. Исходники будут скопированы, поэтому можно повторять процедуру СЖАТИЯ с разным уровнем Q (качества) без опасений (пока не удалены копии исходников).">Оптимизировать изображения шаблонов (или др. папки)</span>';
$_['text_del_copies_of_images'] 		= '<span data-toggle="tooltip" title="НЕ РЕКОМЕНДУЕТСЯ удалять! <br>'."\n".'После оптимизации к имени файла исходного изображения добавляется __source__. Такие файлы можно удалить.  Пока они не удалены можно менять уровень качества для JPEG и заново оптимизировать. Если вы обновили шаблон (тему) магазина  вместе с изображениями, то удалите копии старых исходников.">Удалить исходные (несжатые) изображения (хранятся как копии).</span>';
$_['text_compress_theme_jpeg_quality'] 		= '<span data-toggle="tooltip" title="Оптимально 80. НЕ нужно нажимать \'Сохранить\', этот параметр не сохраняется в настройках, его нужно только выбирать.">Уровень качества (0...100) JPEG шаблона/папки</span>';
$_['text_compress_theme_optipng_level'] 		= '<span data-toggle="tooltip" title="Уровень выше 3 может привести к медленной работе с PNG и редко приводит к дополнительному существенному сжатию файла. НЕ нужно нажимать \'Сохранить\', этот параметр не сохраняется в настройках, его нужно только выбирать. ">Уровень оптимизации OptiPNG для шаблона/папки</span>';




$_['text_dir_for_compress'] 		= '<span data-toggle="tooltip" title=" В этой папке (и ее подпапках) будут сжаты все найденные изображения">Выбрать папку для сжатия (отмены сжатия)</span>';
$_['text_compress_logo'] 		= 'Оптимизировать логотип';
$_['text_undu_compress_theme'] 		= '<span data-toggle="tooltip" title=" Вернуть исходники и удалить копии за ненадобностью.">Отменить сжатие изображений шаблонов (или др. выбранной папки).</span>';
$_['text_undu_compress_logo'] 		= '<span data-toggle="tooltip" title=" Вернуть исходник и удалить копию за ненадобностью.">Отменить сжатие логотипа.</span>';

$_['text_clear_cache'] 	= '<span data-toggle="tooltip" title="Memcached - системный кеш сайта в памяти. Единый для всех ваших сайтов. Принадлежность к конкретному сайту определенного ключа задана префиксом CACHE_PREFIX в конфиге сайта.">Очистить кеш</span>';
$_['text_clear_img_cache'] 	= 'ИЗОБРАЖЕНИЙ';
$_['text_clear_img_market_cache'] 	= 'ИЗОБР. для Я-Маркета';
$_['text_clear_img_no_mozjpeg_cache'] 	= 'ИЗОБРАЖЕНИЙ для ТЕСТА';
$_['text_clear_img_success'] 	= 'Кеш изображений очищен.';
$_['text_clear_market_img_success'] 	= 'Кеш изображений Я-МАРКЕТА очищен.';
$_['text_clear_no_mozjpeg_img_success'] 	= 'Кеш изображений для теста (_no_mozjpeg_, _no_optipng_) очищен.';
$_['text_clear_system_cache'] 	= 'СИСТЕМЫ (файлы)';
$_['text_clear_system_success'] 	= 'Системный кеш очищен.';
$_['text_clear_memcache'] 	= 'MEMCACHE(d) сайта';
$_['text_clear_memcache_success'] 	= 'MEMCACHE(d) очищен.';
$_['text_clear_all_memcache'] 	= 'MEMCACHE(d) ВЕСЬ (!!!)';
$_['text_confirm_clear_all_memcache'] 	= 'Будет очищен MEMCACHE(d) ВЕСЬ (!!!) для всех ваших сайтов. Продолжить?';
$_['text_clear_turbocache'] 	= 'TURBO (файлы)';
$_['text_clear_turbocache_success'] 	= 'TURBO кеш очищен.';

$_['text_clear_ocmod'] 	= 'Обновить кеш OCMOD';
$_['text_clear_ocmod_success'] 	= 'Кеш OCMOD обновлен.';

$_['text_clear_ocmod_error'] 	= 'Кеш OCMOD обновить не удалось.';
$_['text_info_ocmod'] 	= 'есть OCMOD для image.php?';


$_['text_info_os_extra'] 	= '<span data-toggle="tooltip" title="">Информация</span>';
$_['text_block_on_off_module'] 	= '<span data-toggle="tooltip" title="За счет дезактивации ocmod для модуля \'Компрессор\' и/или админ-бара он полностью отключается  в публичной части.  Т.е. файлы не участвуют в работе движка опенкарт, настройки модуля в админке при этом ни на что  НЕ влияют, хоть админка модуля \'Компрессор\' при этом работает.">Вкл/Выкл модуль/админ-бар</span>';
$_['text_on_off_module'] 	= 'Вкл/Выкл модуль';
$_['text_on_off_adminbar'] 	= 'Вкл/Выкл админ-бар';
$_['text_on_module'] 	= '<span class="my_fa_on"></span>Включить (ON) модуль';
$_['text_off_module'] 	= '<span class="my_fa_off"></span>Выключить (OFF) модуль';
$_['text_on_adminbar'] 	= '<span class="my_fa_on"></span>Включить (ON) админ-бар';
$_['text_off_adminbar'] 	= '<span class="my_fa_off"></span>Выключить (OFF) админ-бар';


$_['text_block_on_off_ocmod_market'] = '<span data-toggle="tooltip">Вкл/Выкл ocmod для я-маркетов</span>';
$_['text_on_off_market1'] 	= 'On/Off Y.CMS 2.0';
$_['text_on_market1'] 	= '<span class="my_fa_on"></span>Включить (ON) Y.CMS 2.0';
$_['text_off_market1'] 	= '<span class="my_fa_off"></span>Выключить (OFF) Y.CMS 2.0';

$_['text_on_off_market2'] 	= 'On/Off YML by toporchillo';
$_['text_on_market2'] 	= '<span class="my_fa_on"></span>Вкл. (ON)  YML by toporchillo';
$_['text_off_market2'] 	= '<span class="my_fa_off"></span>Выкл. (OFF)  YML by toporchillo';

$_['text_ya_market_desc'] 	= '<h4>Описание (краткое) возможностей модуля Компрессор для экспорта в Я-Маркет и т.п.</h4><hr>
Поддерживаются автоматически (ocmod уже включен) модули:<br>
 1) <a href="https://github.com/yandex-money/yandex-money-cms-opencart2">Y.CMS 2.0</a><br>
 2) <a href="https://opencartforum.com/files/file/3846-yml-eksport-v-yandeksmarket-dlya-opencart-2x-3x/">YML экспорт в Яндекс.Маркет by toporchillo</a><br><br>
OCMOD для этих модулей можно включить/отключить на вкладке "Сервис". Возможно по заказу автору Компрессора добавление возможности подключения др. модулей для Я-Маркета (и т.п.). 
Вы также можете самостоятельно добавить необходимые изменения в существующие ДРУГИЕ модули. Необходимо код: <br><br>
<b>$this->model_tool_image->resize($image, $this->image_width, $this->image_height);</b><br>
заменить на:<br>
<b>$this->model_tool_image->resize($image, $this->image_width, $this->image_height, \'\', \'market\');</b><br><br>
Эта модификация кода позволит вам управлять изображениями для я-маркета кроме возможности работы со стикерами. Для стикеров нужен более сложный код 
(для указанных выше модулей он реализован и ничего делать не нужно). Для каждого товара может быть свой набор стикеров. Стикеры могут выглядеть так 
(параметры настраиваются: цвет, размер, шрифт): <br><img style="border: 1px solid #ededed;" src="view/image/sitecreator/ya_stickers.png">';





$_['text_info_os'] 	= 'Операционная система';
$_['text_info_memcache'] 	= 'Memcache(d) info & ключи';

$_['text_extra_soft'] 	= '<span data-toggle="tooltip" title="Информация / удаление сим. ссылок на (mozjpeg, optipng, webp). Инфо о константах MOZJPEG, OPTIPNG (пути к исп. файлам с подключаемыми библиотеками) в config.php.">Info о сим. ссылках и путях.</span>';

$_['text_extra_soft_install'] 	= '<span data-toggle="tooltip" title="Установка / удаление софта для суперсжатия (mozjpeg, optipng, webp) в соответствующую директорию">Установка / удаление серверного софта.</span>';


$_['text_image_manager'] 		= 'Менеджер изображений';
$_['text_watermark_img'] = '<span data-toggle="tooltip" title="Можете загрузить тестовую картинку (\'SITECREATOR\') для Watermark. <br>Не используйте анимированный GIF.">Файл-исходник водяного знака:</span>';
$_['text_watermark_posx'] = '<span data-toggle="tooltip" title="0--слева, 50--посередине, 100--справа">Позиция по оси X (0...100)</span>';
$_['text_watermark_posy'] = '<span data-toggle="tooltip" title="0--сверху, 50--посередине, 100--снизу:">Позиция по оси Y (0...100)</span>';
$_['text_watermark_degree'] = '<span data-toggle="tooltip" title="Против часовой. Линейный размер может меняться чтобы вписаться в ограничения по ширине/высоте.">Угол поворота град. (0...360)</span>';
$_['text_watermark_width'] = 'Размер не более по ШИРИНЕ (0...100)%:';
$_['text_watermark_height'] = 'Размер не более по ВЫСОТЕ (0...100)%:';
$_['text_watermark_opacity'] = '<span data-toggle="tooltip" title="0 - Watermark не виден (полная НЕпрозрачность)">Прозрачность watermark (0...100)%:</span>';
$_['text_watermark_test'] = '<span data-toggle="tooltip" title="Картинка кликабельна для увеличения.<br>  Если нет картинки, то проверьте ПРАВА группе пользователей для: module/watermark_by_sitecreator<br> и/text_watermark_testили ОБНОВИТЕ МОДИФИКАТОРЫ!<br><br> Если видите \'!\', то вы удалили изображение /image/sitecreator/watermark_by_sitecreator_test.jpg">Тест-Preview (без сохранения настроек):</span>';
$_['text_watermark_test_error'] = '<br>Если вместо изображения вы видите это сообщение, то сделайте:<br> 1) Обновите кеш модификаторов<br> 2) Выставите права доступа для группы пользователей (в админке) для  module/watermark_by_sitecreator<br> 3) Проверьте права (Linux) на файлы и папку image, image/cache<br> 4) очистите кеш<br>  image/cache/sitecreator<br>
5) устанавливайте модуль через установщик OCMOD движка, а не через FTP';


$_['text_test_compressing'] = '<span data-toggle="tooltip" title="Будут созданы две картинки с почти одинаковым названием, но 2-я (\'ДО\') отличается добавкой к названию _no_mozjpeg_ (_no_optipng_ для PNG). <br>ВНИМАНИЕ: только для короткого теста, иначе кеш будет ДВОЙНОГО размера. ">Сравнение размеров файлов ДО и ПОСЛЕ Суперсжатия.</span>';
$_['text_webp_enable_jpeg'] = '<span data-toggle="tooltip" title="Кроме JPEG создать его сжатую копию в WebP. Браузеры, не поддерживающие WebP, загрузят JPEG.<br>В кеше будут два файла с одинаковым названием, но с расширениями .jpeg и .webp соответственно.">WebP создать для JPEG (WebP + JPEG)</span>';
$_['text_webp_enable_png'] = '<span data-toggle="tooltip" title="Кроме PNG создать его сжатую копию в WebP. Браузеры, не поддерживающие WebP, загрузят PNG.<br>В кеше будут два файла с одинаковым названием, но с расширениями .png и .webp соответственно.<br>
<b>Если у вас нет imagick</b>, то WebP будет создан без альфа-канала (прозрачности), но с белым фоном вместо него. GD не умеет создавать альфа-канал для WebP.">WebP создать для  PNG (WebP + PNG)</span>';
$_['text_webp_png_lossless'] = '<span data-toggle="tooltip" title="Если не выбрано, то уровень качества PNG >> WebP такой же как для JPEG >> WebP">WebP из PNG без потерь (lossless)</span>';

$_['text_mozjpeg_enable'] = '<span data-toggle="tooltip" title="Сжать JPEG максимально. Этот способ суперсжатия доступен  при наличии соответствующего софта">mozjpeg для JPEG</span>';
$_['text_optipng_enable'] = '<span data-toggle="tooltip" title="Сжать PNG максимально. Этот способ суперсжатия доступен  при наличии соответствующего софта. <br> Может работать медленно если много файлов PNG.">OptiPNG для PNG<br><b style="color: #a80a00;">Работает ДОЛГО</b> (актуально для общего хостинга)</span>';
$_['text_optipng_level'] = '<span data-toggle="tooltip" title="Уровень выше 3 может привести к медленной работе с PNG и редко приводит к дополнительному существенному сжатию файла.">Уровень оптимизации OptiPNG</span>';
$_['text_imagick_disable'] = '<span data-toggle="tooltip" title="Будет использована GD-библиотека. Для случая старой версии ImageMagick или ImageMagick с проблемами. <br><b>Не рекомендуется отключать</b> во всех остальных случаях, т. к. падает производительность.">Не использовать imagick / ImageMagick</span>';

$_['text_crop'] = '<span data-toggle="tooltip" title="Обеспечивает создание изображений (по возможности) без белых полей.<br>none - нет,<br>w - уместить по ширине (обрезать по высоте),<br>h - уместить по высоте (обрезать по ширине),<br>auto - автоматически,<br>no border - ВСЕГДА без полей и картинка целиком без обрезки (высота рассчитывается автоматически при фиксированной ширине)">Адаптивный "resize"/ Адаптивная обрезка <br>(действует для ВСЕХ изображений):</span>';

$_['text_for_popup_img_noborder'] = '<span data-toggle="tooltip" title="Всплывающее изображение определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера.">НЕ создавать белые ПОЛЯ :</span>';
$_['text_for_popup_img_fit_to_width_nocrop'] = '<span data-toggle="tooltip" title="Всплывающее изображение определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера. Адаптивная обрезка ОТМЕНЯЕТСЯ. Поля не создаются.">Уместить по ширине, высота не ограничена:</span>';
$_['text_for_popup_img_no_max_fit'] = '<span data-toggle="tooltip" title="Всплывающее изображение определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера. <br> Позволяет избежать размытости.">НЕ увеличивать сверх размеров (геометр.) исходника:</span>';
$_['text_for_popup_img_white_back'] = '<span data-toggle="tooltip" title="Всплывающее изображение определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера. <br> Прозрачные участки будут заменены белым фоном.">Для PNG с альфа-каналом использовать БЕЛЫЙ фон:</span>';


$_['text_for_thumb_img_noborder'] = '<span data-toggle="tooltip" title="Thumbnail (основное на стр. \'Товар\') изображение определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера.">НЕ создавать белые ПОЛЯ :</span>';
$_['text_for_thumb_img_fit_to_width_nocrop'] = '<span data-toggle="tooltip" title="Thumbnail (основное на стр. \'Товар\') изображение определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера. Адаптивная обрезка ОТМЕНЯЕТСЯ. Поля не создаются.">Уместить по ширине, высота не ограничена:</span>';
$_['text_for_thumb_img_no_max_fit'] = '<span data-toggle="tooltip" title="Thumbnail (основное на стр. \'Товар\') изображение определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера. <br> Позволяет избежать размытости.">НЕ увеличивать сверх размеров (геометр.) исходника:</span>';
$_['text_for_thumb_img_white_back'] = '<span data-toggle="tooltip" title="Thumbnail (основное на стр. \'Товар\') изображение определяется по его размеру, заданному в шаблоне. Данное правило будет применено ко всем изображениям такого же размера. <br> Прозрачные участки будут заменены белым фоном.">Для PNG с альфа-каналом использовать БЕЛЫЙ фон:</span>';

$_['text_fuzz'] = '<span data-toggle="tooltip" title="Параметр, определяющий насколько близко два разных цвета могут считаться одинаковыми в фоне. От 0 до 65535 (обычно 0...1500).
  Определяется опытным путем. Справедливо для полноцветных (RGB: 8 бит/канал ) изображений.">fuzz - Диапазон одинаковости (равномерности) цвета</span>';
$_['text_enable_trim'] = '<span data-toggle="tooltip" title="Обрезать фон в соответствии с fuzz. Чем выше fuzz, то тем более разные цвета считаются в фоне одинаковыми.">ОБРЕЗАТЬ фон</span>';
$_['text_trim_cache'] = '<span data-toggle="tooltip" title="Ускоряет создание изображений разных размеров из одного исходника. Не рекомендуется выключать. Очищается вместе с обычным кешем изображений.">Кешировать результат обрезки источника</span>';

$_['text_enable_multitrim'] = '<span data-toggle="tooltip" title="Полезно в случае сложного фона с резкими переходами. Например, белые поля + серый фон. Если у картинки однородный (простой) фон,
то нет нужды включать 2-х проходный способ.  2-й проход усложняет расчет и отрисовку бордера. По сути сначала отрезается 1-й (внешний) фон, потом 2-й (внутренний).  <BR>НАГРУЗКА НА ПРОЦЕССОР ВЫШЕ чем при одинарном проходе.">Обрезать в два прохода <br><b style="color: #a80a00;">(Потребляет БОЛЬШЕ ресурсов)</b></span>';
$_['text_trim_border'] = '<span data-toggle="tooltip" title="Не обрезать фон полностью, а оставить вокруг бордер, размером в % от итогового размера после обрезки \'под корень\'.  
Бордер не рисуется кистью или цветом, и не накладывается никакое дополнительное изображение на бордер, бордер - это часть исходного изображения. И если в исходном изображении нет места для бордера нужной ширины, 
то и в конечном изображении бордер будет той максимально возможной ширины, которую может обеспечить исходное изображение, т. е. без выхода за пределы исходного. 
">Оставить вокруг border (рамку) [берется из всего исходного изображения], шириной максимум в % <br>(читайте примечание-справку!)</span>';
$_['text_border_after_trim1'] = '<span data-toggle="tooltip" title="Полезно в том случае если есть сложный исходный фон с контрастными 2-мя цветами и резким переходом, например, белый (наружный фон) + серый (внутренний фон) с резкими границами. 
В данном случае бордер будет браться только из серого фона, т.е. из внутреннего фона. Цвета фонов приведены для примера, они могут быть любыми.">Бордер берется из фона, оставшегося после 1-го прохода</span>';
$_['text_enable_color_for_fill'] = '<span data-toggle="tooltip" title="При 2-х проходном методе всегда берется цвет внутреннего фона, т. к. внешний отрезается.">Использовать цвет фона из ИСХОДНИКА вместо белого для заливки полей стандартным способом движка.</span>';
$_['text_enable_border_fill'] = '<span data-toggle="tooltip" title="Цвет заливки бордера определяется автоматически по цвету фона.">Делать бордер заливкой цветом фона если бордер нельзя взять из исходника целиком.</span>';


$_['text_trim_maxi_w_and_h'] = '<span data-toggle="tooltip" title="Подразумевается ЗАДАННАЯ ширина или высота конечного изображения. Выполнены должны быть оба условия (по ширине и высоте).">НЕ обрабатывать фон если по ширине или высоте (БОЛЬШЕ или равно):</span>';

$_['text_trim_mini_w_and_h'] = '<span data-toggle="tooltip" title="Подразумевается ЗАДАННАЯ ширина или высота конечного изображения. Выполнены должны быть оба условия (по ширине и высоте).">НЕ обрабатывать фон если по ширине или высоте (МЕНЬШЕ или равно):</span>';


$_['text_no_image'] = '<span data-toggle="tooltip" title="По умолчанию так сделано в ocstore 2.*, в оригинальном opencart (и в сборке *.pro) этого нет.  Нет изображения - это означает, что по указанному пути не найден исходник.">Если изображения нет, то подставить no_image для вывода</span>';
$_['text_crop_by_theme'] = '<span data-toggle="tooltip" title="Адаптивный resize может производиться лишь на определенных страницах по инициативе движка.  Параметр адаптивного ресайза (обрезки),
который передает движок, имеет более высокий приоритет чем аналогичный заданный параметр в модуле.">Разрешить движку (шаблону) инициировать адаптивный resize.</span>';
$_['text_secretpath'] = '<span data-toggle="tooltip" title="Защита файла исходного изображения от скачивания. В кеше находится переименованный (зашифрованное название) файл.">Секретный путь к исходнику.</span>';
$_['text_remove_trash_disable'] = '<span data-toggle="tooltip" title="Если вы неоднократно включали/выключали режим <<Секретный путь к исходнику>>, то возможно накопление файлов-дубликатов с разными именами (обычными и секретными). Обычно это касается только WEBP. По-умолчанию производится проверка дубликатов и их удаление. Это незначительно, но забирает ресурсы.">НЕ удалять мусор после секретных изменений.</span>';

$_['text_delduplicate'] = '<span data-toggle="tooltip" title="Если ранее был создан в кеше файл с обычным (для Opencart) названием вместо зашифрованного, то его можно удалить за ненадобностью.">Удалить из кеша файл-копию с несекретным названием.</span>';

$_['text_enable_market'] = '<span data-toggle="tooltip" 
title="Для ВСЕХ изображений указанного размера не применять водяной знак и не использовать сжатие.  Полезно для изображений, подготовленных для Яндекс-маркета и т. п."
>НЕ наклыдывать watermark и НЕ сжимать.</span>';
$_['text_market_w_and_h'] = '<span data-toggle="tooltip" 
title="Для ВСЕХ изображений указанного размера не применять водяной знак и не использовать сжатие если есть соответствующая галочка.  Полезно для изображений, подготовленных для Яндекс-маркета и т. п."
>При точном совпадении размеров с указанными НЕ накладывать и НЕ сжимать.</span>';


$_['text_img_quality'] = '<span data-toggle="tooltip" title="оптимально около 80 для imagick">Качество JPEG (0...100):</span>';
$_['text_webp_quality'] = '<span data-toggle="tooltip" title="Параметр для преобразования JPEG >> WebP и PNG >> WebP.<br> оптимально около 80...85">Качество WebP (0...100):</span>';

$_['text_img_mini_quality'] = '<span data-toggle="tooltip" title="оптимально около 70...80 для imagick">Качество JPEG (0...100) для изображений, ограниченных СВЕРХУ:</span>';
$_['text_img_mini_w_and_h'] = '<span data-toggle="tooltip" title="Условие выполняется если меньше или равно хотя бы по одной стороне. В противном случае действует параметр КАЧЕСТВО, заданный для ВСЕХ изображений">по ширине и высоте (меньше или равно):</span>';
$_['text_img_mini_if_and'] = '<span data-toggle="tooltip" title="Параметр Качество для маленьких изображений будет применен только если ОБА условия по размерам одновременно выполнены.">условие "И" (ширина <= w && высота <= h):</span>';


$_['text_img_maxi_quality'] = '<span data-toggle="tooltip" title="оптимально около 70...80 для imagick">Качество JPEG (0...100) для изображений, ограниченных СНИЗУ:</span>';
$_['text_img_maxi_w_and_h'] = '<span data-toggle="tooltip" title="Условие выполняется если больше или равно хотя бы по одной стороне. В противном случае действует параметр КАЧЕСТВО, заданный для ВСЕХ изображений">по ширине и высоте (больше или равно):</span>';
$_['text_img_maxi_if_and'] = '<span data-toggle="tooltip" title="Параметр Качество для больших изображений будет применен только если ОБА условия по размерам одновременно выполнены.">условие "И" (ширина >= w && высота >= h):</span>';
$_['text_img_maxi_no_compress'] = '<span data-toggle="tooltip" title="Если условия по размерам выполнены, то сжатие отключено для таких изображений.">НЕ сжимать (игнорировать параметры сжатия):</span>';

// Параметры для яндекс-маркета +++++++++++++++++++++++++++++++++ START

$_['text_market_img_quality'] = '<span data-toggle="tooltip" title="Оптимально около 80...90 (Для четкого текста лучше 90) <br>НИКОГДА НЕ СЖИМАЮТСЯ">Качество JPEG для Я-Маркета (0...100):</span>';
$_['text_market_watermark_enable'] = '<span data-toggle="tooltip" title="Дейстует только для изображений, помещаемых в отдельную папку кеша для Маркета. 
Наложение происходит с параметрами, заданными в блоке \'WATERMARK: настройки\'.  
Если в указанном блоке  не разрешено наложение watermark, то данная опция ни на что не влияет.">Накладывать watermark:</span>';
$_['text_market_stickers_enable'] = '<span data-toggle="tooltip" title="Дейстует только для изображений, помещаемых в отдельную папку кеша для Маркета">Накладывать индивидуальные СТИКЕРЫ:<br>
(<b class=\'my_warning\'>Нужен \'php imagick\'</b>)</span>';
$_['text_market_stickers_source_text'] = '<span data-toggle="tooltip" title="Используйте одно из полей при заполнении товара в качестве текста для стикеров. 
Стикеров может быть несколько (введены все в ОДНО поле). В качестве разделителя текста стикеров применяйте \'|\'">Источник текста для стикеров:</span>';

$_['text_market_override_image_size'] = '<span data-toggle="tooltip" title="Игнорировать размеры изображений, заданные в модуле выгрузки для Я-Маркета. Значения будут браться из настроек модуля \'Компрессор\'">Переопределить размеры изображений</span>';
$_['text_market_set_image_size'] = '<span data-toggle="tooltip" title="Действуют при включенной опции \'Переопределить размеры изображений\'">Размер изображения для Я-маркета</span>';
$_['text_market_image_generate_disable'] = '<span data-toggle="tooltip" title="Обычно XML генерируется с одновременным созданием изображений для выгрузки в я-маркет.  
Это вызывает долгое формирование XML и всплеск продолжительной высокой нагрузки. Алтернативой создания \'НА ЛЕТУ\' является формирование изображений в фоновом режиме по cron-у (по расписанию).">НЕ создавать изображения на лету одновременно с XML. (Снижает нагрузку благодаря запуску по расписанию)</span>';
// Параметры для яндекс-маркета --------------------------------- END

$_['text_disable_admin_bar'] = '<span data-toggle="tooltip" title="Если разрешено показывать и ocmod для админ-бара действует (можно вкл/выкл на вкладке Сервис), то в front-end отображаются элементы управления администратора. Можно очищать кеш изображений для конкретной страницы.">Admin bar (доступно ТОЛЬКО АДМИНу) НЕ показывать</span>';

$_['text_white_back'] = '<span data-toggle="tooltip" title="Прозрачные участки будут заменены белым. Альфа-канала (прозрачности) не будет<br>Если нет imagick, но есть GD с поддержкой WebP, то это способ корректно преобразовать PNG >> WebP. ">Для PNG с альфа-каналом использовать БЕЛЫЙ фон <br>(применить ко ВСЕМ изображениям):</span>';

$_['text_img_info'] = '<span data-toggle="tooltip" title="Watermark может работать при наличии разных возможностей сервера и софта. Отсутствие какого-либо софта заставляет работать модуль менее эффективно в плане сжатия, но не хуже дефолтного (используется GD). Красный цвет лишь для информации. <br>Исходя из установленных возможностей вы можете ниже выбрать нужные опция сжатия. Модуль автоматически обнаружит нужный софт и будет его использовать.">Информация об установленном софте и возможностях:</span>';

$_['text_img_min_width_nowatermark'] = '<span data-toggle="tooltip" title="Если изображение МЕНЬШЕ хотя бы по одной стороне, то watermark не накладывается.">Watermark действует при MIN ширине ИЛИ высоте и ВЫШЕ</span>';
$_['text_img_max_width_nowatermark'] = '<span data-toggle="tooltip" title="Если изображение БОЛЬШЕ хотя бы по одной стороне, то watermark не накладывается.<br>Параметр MAX не должен быть меньше параметра MIN.">Watermark действует при MAX ширине ИЛИ высоте и НИЖЕ</span>';

$_['text_module_copyright'] = '<p class="module_copyright"><a href="https://sitecreator.ru/">SiteCreator.ru &copy; 2017-2019</a>&nbsp;&nbsp;&nbsp; e-mail: <a href="mailto:opencart@sitecreator.ru">opencart@sitecreator.ru</a></p><h4>Image Compressor & Watermark & WebP etc. by Sitecreator &copy; 2017-2019</h4>';

$_['text_watermark_dirs'] = '<span data-toggle="tooltip" title="Каждая папка без кавычек с НОВОЙ строки.  Правило действует и для вложенных папок. пути указывать относительно папки image">Для этих папок/файлов Watermark НЕ действует (рекурсивно):<br><br><span class="no_bold">каждая папка/файл без кавычек с НОВОЙ строки. Путь указывать относительно папки image. Например:<br><br>
catalog/avatars<br>catalog/demo<br>placeholder.png</span></span>';

$_['text_watermark_dirs_error'] = '<span data-toggle="tooltip" title="Формально это не ошибка, а напоминание.  Несуществующие папки (файлы) не влияют на работу.">Указанные папки/файлы не найдены!<br>Проверьте правильность введенных выше данных!</span>';

$_['text_warning'] = '<h4 style="color: #fff; background: #b7b8b9; padding: 10px 15px;">Если вы устанавливали/изменяли дополнительный софт (mozjpeg, optipng и т.п.) на сервере, то нажмите "сохранить и ОСТАТЬСЯ" в данном модуле.</h4><br>
<div style="color: #fff; background: #12b975; padding: 10px 15px;">Для генерирования WebP не надо очищать кеш изображений. Но может потребоваться отчистка системного кеша и кеша вашего ускорителя (кешеровщика)</div><br>';

$_['text_dirs_noTrim'] = '<span data-toggle="tooltip" title="Каждая папка без кавычек с НОВОЙ строки.  Правило действует и для вложенных папок. пути указывать относительно папки image">Для этих папок/файлов ОБРЕЗКА ФОНА ИСХОДНИКА НЕ действует (рекурсивно):<br><br><span class="no_bold">каждая папка/файл без кавычек с НОВОЙ строки. Путь указывать относительно папки image. Например:<br><br>
catalog/avatars<br>catalog/demo<br>placeholder.png</span></span>';
$_['text_dirs_error_noTrim'] = '<span data-toggle="tooltip" title="Формально это не ошибка, а напоминание.  Несуществующие папки (файлы) не влияют на работу.">Указанные папки/файлы не найдены!<br>Проверьте правильность введенных выше данных!</span>';



$_['text_watermark_infoplus'] = '<h3>Справка</h3><br>'.$_['text_warning'].'
<b>Справка может не успевать отражать все изменения и нововведения в модуле.</b>
<br>
Читайте подсказки к каждому параметру.
<br><br>
Документация будет добавлена позже.

По вопросам (в том числе по лицензии) обращаться на <b>opencart@sitecreator.ru</b> или в личку (sitecreator) на форумах. Просьба указывать в теме обращения название домена.<br><br>';
$_['text_watermark_lic_error_header'] = '<h3>++++ Нет лицензии ++++</h3>';
$_['text_watermark_lic_error_file'] = '<br>Нет файла лицензии. Должен быть в <b>КОРНЕ</b> сайта';
$_['text_watermark_lic_error_domen'] = '<br>Невозможно корректно определить домен. Как следствие невозможно использовать лицензионный ключ.';
$_['text_watermark_lic_error_key'] = '<br>Неверный ключ.';

$_['text_module']         = 'Модули';
$_['text_success']        = 'Настройки модуля обновлены!';
$_['text_content_top']    = 'Верх страницы';
$_['text_content_bottom'] = 'Низ страницы';
$_['text_column_left']    = 'Левая колонка';
$_['text_column_right']   = 'Правая колонка';

// Entry
$_['entry_layout']        = 'Схема:';
$_['entry_position']      = 'Расположение:';
$_['entry_status']        = '<span data-toggle="tooltip" title="Настройка действует только на включение Watermark.  На СУПЕРсжатие не распростаняется, оно работает независимо от настроек Watermark.  ">Накладывать watermark:</span>';
$_['entry_sort_order']    = 'Порядок сортировки:';

// Error
$_['error_permission']    = 'У Вас нет прав для управления этим модулем!';

$_['text_compare_imgs_size'] = '<h4>Сравнение веса файлов ДО и ПОСЛЕ</h4>';

$_['all_texts'] = [];
foreach ($_ as $name => $text) $_['all_texts'][$name] = $text;
?>