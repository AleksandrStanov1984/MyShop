<?php
/*
 *  LICENSE
 *  Opencart
 *  image model  for OpenCart 1.5 & 2+
 *  Copyright (c) 2017-2019 sitecreator.ru
 *  version 1.10.3 (sitecreator.ru)
 *  Исключительные права на данный файл (и модуль, в сотав которого входит данный файл) принадлежат разработчику - sitecreator.ru (Малютину Р.А.)
 *  Разработчик может выступать как под своим именем (Малютин Р.А.) так и использовать свой ник, совпадающий с названием одного из сайтов разработчика -
 *  sitecreator.ru или sitecreator.pro, а также более короткий ник  - sitecreator (SiteCreator).
 *  Упоминание любого из этих ников (сайтов) в контексте защиты авторских прав и интеллектуальной собственности однозначно следует связывать с защитой
 *  исключительных прав на интеллектуальную собственность  разработчика Малютина Р.А.
 *  В таком контексте любой из указанных выше ников следует рассматривать как синоним "разработчик Малютин Р.А.".
 *
 *  Копирование и распространение без согласия разработчика (sitecreator.ru) не допускается.
 *
 * Добавлена полная совместимость с шаблоном light$hop
 *
 */

class ModelToolImageBySitecreator extends Model {
  public function resize($filename, $width, $height, $type = '', $market = '', $text_for_market = '') {

    //
    //$market = 'market' - это означает, что картинка готовится исключительно для маркета и будет помещена в свой отдельный кеш
    // $text_for_market - текст для нанесения на изображения для я-маркета
    // отдельная папка для кеша изображений яндекс-маркета (относительно DIR_IMAGE). используется по умолчанию.
    $market_cache = 'market_cache/';
    // папку кеша я-маркета можно переопределить в конфиге. Специально прописывать не нужно если использовать по умолчанию
    if(defined('DIR_MARKET_IMAGE_CACHE')) $market_cache = DIR_MARKET_IMAGE_CACHE;

    // на случай извращенного формировая псевдо SEO URL для изображения,
    // когда в URL изображения мог бы быть вставлен  product_id
    // на деле это не использовалось (да и зачем?), но полностью ломалась совместимость
    if( strpos( $filename, '::' ) !== false ) { //
      $filename = explode( '::', $filename );
      //$product_id = $filename[1];
      $filename = $filename[0];
    }



    // получим кешированные настройки если доступны (и не устарели) или создадим новый кеш
    $setting = $this->cache->get('watermark_by_sitecreator');

    if(empty($setting)) { // отсутствие файла кеша либо кеш просрочен === false
      $this->load->model('setting/setting');
      $setting = $this->model_setting_setting->getSetting('watermark_by_sitecreator');
      $this->cache->set('watermark_by_sitecreator', $setting);
    }

    $enable_no_image = (!empty($setting['watermark_by_sitecreator_no_image'])) ? true : false;  // если по указанному пути не найден исходник, то подставить no_image
    $enable_crop_by_theme = (!empty($setting['watermark_by_sitecreator_crop_by_theme'])) ? true : false;  // даем  шаблону приоритет в управлении адаптивной обрезкой


    $prefix = 'watermark_by_sitecreator_';

    $par = 'status';
    if (empty($setting[$prefix. $par])) $setting[$prefix. $par] = 0;
    $par = 'market_watermark_enable';
    if (empty($setting[$prefix. $par])) $setting[$prefix. $par] = 0;
    $par = 'market_stickers_enable';
    if (empty($setting[$prefix. $par])) $setting[$prefix. $par] = 0;
    $par = 'market_override_image_size';
    if (empty($setting[$prefix. $par])) $setting[$prefix. $par] = 0;
    $par = 'market_image_generate_disable';
    if (empty($setting[$prefix. $par])) $setting[$prefix. $par] = 0;
    $par = 'cwebp_enable';
    if (empty($setting[$prefix. $par])) $setting[$prefix. $par] = 0;
    $par = 'remove_trash_disable';
    if (empty($setting[$prefix. $par])) $setting[$prefix. $par] = 0;

    if (empty($setting['watermark_by_sitecreator_posx'])) $setting['watermark_by_sitecreator_posx'] = 0;
    if (empty($setting['watermark_by_sitecreator_posy'])) $setting['watermark_by_sitecreator_posy'] = 0;
    if (empty($setting['watermark_by_sitecreator_degree'])) $setting['watermark_by_sitecreator_degree'] = 0;
    if (empty($setting['watermark_by_sitecreator_width'])) $setting['watermark_by_sitecreator_width'] = 100;
    if (empty($setting['watermark_by_sitecreator_height'])) $setting['watermark_by_sitecreator_height'] = 100;
    if (empty($setting['watermark_by_sitecreator_opacity'])) $setting['watermark_by_sitecreator_opacity'] = 100;
    if (empty($setting['watermark_by_sitecreator_quality'])) $setting['watermark_by_sitecreator_quality'] = 80;
    if (empty($setting['watermark_by_sitecreator_market_quality'])) $setting['watermark_by_sitecreator_market_quality'] = 90;
    if (empty($setting['watermark_by_sitecreator_min_width'])) $setting['watermark_by_sitecreator_min_width'] = 101;
    if (empty($setting['watermark_by_sitecreator_max_width'])) $setting['watermark_by_sitecreator_max_width'] = 899;



    // размер изображения, которое не сжимаем и не накладываем водяной знак. Для Я-маркет (соответствие определяется размерами изобр)
    $key = $prefix.'wmarket_h'; if (empty($setting[$key])) $setting[$key] = 802;
    $key = $prefix.'market_w'; if (empty($setting[$key])) $setting[$key] = 802;
    // параметры для я-маркета, заданные отдельным блоком (плагином)
    // размер изображения , которое создается для маркета (игнорируется заданное в модуле выгрузки)
    $key = $prefix.'market_image_w'; if (empty($setting[$key])) $setting[$key] = 600;
    $key = $prefix.'market_image_h'; if (empty($setting[$key])) $setting[$key] = 600;

    if (empty($setting['watermark_by_sitecreator_dirs'])) $setting['watermark_by_sitecreator_dirs'] = [];
    if (empty($setting['watermark_by_sitecreator_dirs_noTrim'])) $setting['watermark_by_sitecreator_dirs_noTrim'] = [];
    if (empty($setting['watermark_by_sitecreator_crop_type'])) $setting['watermark_by_sitecreator_crop_type'] = ''; // $crop_type - тип обрезки: w h auto
    if (empty($setting['watermark_by_sitecreator_test_compressing'])) $setting['watermark_by_sitecreator_test_compressing'] = '';
    if (empty($setting['watermark_by_sitecreator_enable_market'])) $setting['watermark_by_sitecreator_enable_market'] = '';

    $minW = $setting['watermark_by_sitecreator_min_width'];
    $maxW = $setting['watermark_by_sitecreator_max_width'];


    $compare_file_size = (!empty($setting['watermark_by_sitecreator_test_compressing'])) ? true : false; // сравнения разных способов сжатия
//    $extra_parameters['webp_jpeg'] = (!empty($setting['watermark_by_sitecreator_webp_enable_jpeg'])) ? true : false;
    $extra_parameters['webp_jpeg'] = false;
//    $extra_parameters['webp_png'] = (!empty($setting['watermark_by_sitecreator_webp_enable_png'])) ? true : false;
    $extra_parameters['webp_png'] = false;

    $extra_parameters['mozjpeg'] = (!empty($setting['watermark_by_sitecreator_mozjpeg_enable'])) ? true : false;
    $extra_parameters['optipng'] = (!empty($setting['watermark_by_sitecreator_optipng_enable'])) ? true : false;

    $extra_parameters['white_back'] = (!empty($setting['watermark_by_sitecreator_white_back'])) ? true : false;
    $extra_parameters['imagick_disable'] = (!empty($setting['watermark_by_sitecreator_imagick_disable'])) ? true : false;

    $extra_parameters['for_popup_img_noborder'] = (!empty($setting['watermark_by_sitecreator_for_popup_img_noborder'])) ? true : false;
    $extra_parameters['for_popup_img_fit_to_width_nocrop'] = (!empty($setting['watermark_by_sitecreator_for_popup_img_fit_to_width_nocrop'])) ? true : false;
    $extra_parameters['for_popup_img_no_max_fit'] = (!empty($setting['watermark_by_sitecreator_for_popup_img_no_max_fit'])) ? true : false;
    $extra_parameters['for_popup_img_white_back'] = (!empty($setting['watermark_by_sitecreator_for_popup_img_white_back'])) ? true : false;

    $extra_parameters['for_thumb_img_noborder'] = (!empty($setting['watermark_by_sitecreator_for_thumb_img_noborder'])) ? true : false;
    $extra_parameters['for_thumb_img_fit_to_width_nocrop'] = (!empty($setting['watermark_by_sitecreator_for_thumb_img_fit_to_width_nocrop'])) ? true : false;
    $extra_parameters['for_thumb_img_no_max_fit'] = (!empty($setting['watermark_by_sitecreator_for_thumb_img_no_max_fit'])) ? true : false;
    $extra_parameters['for_thumb_img_white_back'] = (!empty($setting['watermark_by_sitecreator_for_thumb_img_white_back'])) ? true : false;

    // параметры работы с фоном исходника
    $extra_parameters['enable_trim'] = (!empty($setting['watermark_by_sitecreator_enable_trim'])) ? true : false;
    $extra_parameters['trim_cache'] = (!empty($setting['watermark_by_sitecreator_trim_cache'])) ? true : false;
    $extra_parameters['enable_multitrim'] = (!empty($setting['watermark_by_sitecreator_enable_multitrim'])) ? true : false;
    $extra_parameters['border_after_trim1'] = (!empty($setting['watermark_by_sitecreator_border_after_trim1'])) ? true : false;
    $extra_parameters['enable_color_for_fill'] = (!empty($setting['watermark_by_sitecreator_enable_color_for_fill'])) ? true : false;
    // заливка бордера цветом фона
    $extra_parameters['enable_border_fill'] = (!empty($setting['watermark_by_sitecreator_enable_border_fill'])) ? true : false;
    $extra_parameters['fuzz'] = (!empty($setting['watermark_by_sitecreator_fuzz'])) ? $setting['watermark_by_sitecreator_fuzz'] : 1000;
    $extra_parameters['trim_border'] = (!empty($setting['watermark_by_sitecreator_trim_border'])) ? $setting['watermark_by_sitecreator_trim_border'] : 1000;

    $trim_maxi_w = (!empty($setting['watermark_by_sitecreator_trim_maxi_w'])) ? $setting['watermark_by_sitecreator_trim_maxi_w'] : 800;
    $trim_maxi_h = (!empty($setting['watermark_by_sitecreator_trim_maxi_h'])) ? $setting['watermark_by_sitecreator_trim_maxi_h'] : 800;
    $trim_mini_w = (!empty($setting['watermark_by_sitecreator_trim_mini_w'])) ? $setting['watermark_by_sitecreator_trim_mini_w'] : 50;
    $trim_mini_h = (!empty($setting['watermark_by_sitecreator_trim_mini_h'])) ? $setting['watermark_by_sitecreator_trim_mini_h'] : 50;


    $extra_parameters['optipng_level'] = (!empty($setting['watermark_by_sitecreator_optipng_level'])) ? $setting['watermark_by_sitecreator_optipng_level'] : 2;
    $extra_parameters['webp_quality'] = (!empty($setting['watermark_by_sitecreator_webp_quality'])) ? $setting['watermark_by_sitecreator_webp_quality'] : 85;
    $extra_parameters['webp_png_lossless'] = (!empty($setting['watermark_by_sitecreator_webp_png_lossless'])) ? true : false;
    $extra_parameters['quality'] = (!empty($setting['watermark_by_sitecreator_quality'])) ? $setting['watermark_by_sitecreator_quality'] : 90;

    // качество для ВСЕХ маленьких изображений с размерами равными или меньше img_mini_w img_mini_h  (по ширине ИЛИ высоте)
    $extra_parameters['mini_quality'] = (!empty($setting['watermark_by_sitecreator_mini_quality'])) ? $setting['watermark_by_sitecreator_mini_quality'] : 78;
    $extra_parameters['img_mini_w'] = (!empty($setting['watermark_by_sitecreator_img_mini_w'])) ? $setting['watermark_by_sitecreator_img_mini_w'] : 90;
    $extra_parameters['img_mini_h'] = (!empty($setting['watermark_by_sitecreator_img_mini_h'])) ? $setting['watermark_by_sitecreator_img_mini_h'] : 90;
    // только при условии "И" (ширина и высота соответсвуют)
    $extra_parameters['img_mini_if_and'] = (!empty($setting['watermark_by_sitecreator_img_mini_if_and'])) ? true : false;

    // качество для ВСЕХ БОЛЬШИХ изображений с размерами равными или больше img_maxi_w img_maxi_h  (по ширине ИЛИ высоте)
    $extra_parameters['maxi_quality'] = (!empty($setting['watermark_by_sitecreator_maxi_quality'])) ? $setting['watermark_by_sitecreator_maxi_quality'] : 85;
    $extra_parameters['img_maxi_w'] = (!empty($setting['watermark_by_sitecreator_img_maxi_w'])) ? $setting['watermark_by_sitecreator_img_maxi_w'] : 800;
    $extra_parameters['img_maxi_h'] = (!empty($setting['watermark_by_sitecreator_img_maxi_h'])) ? $setting['watermark_by_sitecreator_img_maxi_h'] : 800;
    // только при условии "И" (ширина и высота соответсвуют)
    $extra_parameters['img_maxi_if_and'] = (!empty($setting['watermark_by_sitecreator_img_maxi_if_and'])) ? true : false;
    $extra_parameters['img_maxi_no_compress'] = (!empty($setting['watermark_by_sitecreator_img_maxi_no_compress'])) ? true : false;




    // проверим существование исходника
    if ($enable_no_image) {
      if (!is_file(DIR_IMAGE . $filename)) {
        if (is_file(DIR_IMAGE . 'no_image.jpg')) {
          $filename = 'no_image.jpg';
        } elseif (is_file(DIR_IMAGE . 'no_image.png')) {
          $filename = 'no_image.png';
        } else return false;
      }
    } elseif (!is_file(DIR_IMAGE . $filename)) return false;


    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $image_old = $filename;
    $image_new = utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . (int)$width . 'x' . (int)$height . '.';



  if($type == 'auto_width') {
    $image_new = utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-auto_width_' . (int)$height . '.';
  }

    $image_webp = 'cache/' . $image_new . 'webp';  // пока не будем учитывать, что расширение файла может быть jpg или JPG
    $image_new .= $extension;

  // если для я-маркета
  if(!empty($market)) {
    // если разрешено переопределить размер изображений
    if ($setting['watermark_by_sitecreator_market_override_image_size']) {
      $width = $setting['watermark_by_sitecreator_market_image_w'];
      $height = $setting['watermark_by_sitecreator_market_image_h'];
      $image_new = utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . (int)$width . 'x' . (int)$height . '.' . $extension;
    }

    $image_new = $market_cache. $image_new;  // пишем в отдельный кеш я-маркета 'market_cache'
  }
  else {  // для всех изображений кроме я-маркета
    $image_new = 'cache/' . $image_new;
  }


  $create_img = true; // создать новое изображение


    // определим секретный путь (шфрованное название файла)
    if(empty($market)) {
      if($type == 'auto_width') {
        $image_new_secret = 'cache/'. dirname($filename). '/'. md5(rawurldecode(basename ($filename))). '-auto_width_' . (int)$height . '.';
      }
      else $image_new_secret = 'cache/'. dirname($filename). '/'. md5(rawurldecode(basename ($filename))). '-' . (int)$width . 'x' . (int)$height . '.';

      $image_webp_secret = $image_new_secret . 'webp';
      $image_new_secret .= $extension;
    }
    else { // делаем секретный путь для я-маркета

      $image_new_secret = $market_cache. dirname($filename). '/'. md5(rawurldecode(basename ($filename))). '-' . (int)$width . 'x' . (int)$height . '.' . $extension;
    }


    // защита ИСХОДНИКА Не распространяется на изображения для я-маркета
//    if (!empty($setting['watermark_by_sitecreator_secretpath']) && empty($market)) {  // не даем возможности узнать путь к исходнику (раньше было так)
    if (!empty($setting['watermark_by_sitecreator_secretpath'])) {  // не даем возможности узнать путь к исходнику

      if(is_file(DIR_IMAGE . $image_new_secret)) {  // если секретный файл уже есть
        $create_img = false;  // не создаем новое изображени
      }
      // если секретный файл еще не создан
      elseif(is_file(DIR_IMAGE . $image_new)) { // если несекретный файл существует, то переименуем
        // только переименование
        @rename(DIR_IMAGE . $image_new, DIR_IMAGE . $image_new_secret);
        $create_img = false;  // не создаем новое изображени
      }

      $image_new = $image_new_secret;
    }
    // если секретный путь не нужен =================================
    else  {
      if (is_file(DIR_IMAGE . $image_new)) $create_img = false;
      // файла нет, но возможно, что остался файл с секретным названием. Такое возможно если убрали ранее установленную галочку "секретный путь"
      elseif(is_file(DIR_IMAGE . $image_new_secret)) {
        // проверим, что это не сим. ссылка
        if(!is_link(DIR_IMAGE . $image_new_secret)) {
          // только переименование
          @rename(DIR_IMAGE . $image_new_secret, DIR_IMAGE . $image_new);
          $create_img = false;  // не создаем новое изображени
        }
      }
    }







    // watermark_by_sitecreator_market_image_generate_disable - означает, что не создавать для маркета изображения на лету, но создать их позже
    // предполагается, что могут быть созданы просто сим. ссылки вместо изображений
  // если символическая ссылка, то заменим ее файлом
  // условие замены симв. ссылки на файл
    $replase_link = is_link(DIR_IMAGE . $image_new) && !$setting['watermark_by_sitecreator_market_image_generate_disable'];

    // обязательное удаление ссылки перед записью файла, иначе будет переписан файл по ссылке, а не заменена ссылка файлом
    If ($replase_link ) @unlink(DIR_IMAGE . $image_new);


    // ======= WEBP  =========== WEBP  ============== WEBP  ============== WEBP  ================ WEBP  =================
    // +++++++++++++++++++ WEBP        +++++++++++++++++++++++++++++++++++++++++++++++++


    // если задано создать WEbp Но создавать будем только если существует основное изображение.  Не оба сразу.
    // годится если изображение jpeg, png только
    // только не для я-маркета!
    if((!empty($setting['watermark_by_sitecreator_webp_enable_jpeg']) && (empty($market)) && (strtolower($extension) == 'jpg' || strtolower($extension) == 'jpeg'))
      || (!empty($setting['watermark_by_sitecreator_webp_enable_png']) && (empty($market))  && strtolower($extension) == 'png')) {


      $create_webp = true; // создать webp

      $file_to_convert = DIR_IMAGE . $image_new;    // может быть с обычным именем или с секреиным
      $file_image_webp = DIR_IMAGE . $image_webp;
      $file_image_webp_secret = DIR_IMAGE . $image_webp_secret;

      // если нужен секретный путь
      if (!empty($setting['watermark_by_sitecreator_secretpath'])) {
        // файл существует и не просрочен
        if (is_file($file_image_webp_secret) && ((filectime($file_to_convert) < filectime($file_image_webp_secret)))) {
          $create_webp = false;
          // если существует обычный (остался после засекречивания), то удалим
          // проверяем файл если не запрещено проверку
          if (empty($setting['watermark_by_sitecreator_remove_trash_disable']) && is_file($file_image_webp)) @unlink($file_image_webp);
        }
        else {
          // проверим есть ти ли файл webp с обычным именем и не просрочен ли он, т.е. не сдалан ли он раньше JPG/PNG
          if (is_file($file_image_webp) && (filectime($file_to_convert) < filectime($file_image_webp))) {
            @rename($file_image_webp, $file_image_webp_secret);// только переименование
            $create_webp = false;
          }
        }
      }
      else {
        // файл существует и не просрочен (не появился новый файл JPEG PNG)
        if (is_file($file_image_webp) && ((filectime($file_to_convert) < filectime($file_image_webp)))) {
          $create_webp = false;
          // если существует секретный (остался после возвращения), то удалим
          // проверяем файл если не запрещено проверку
          if (empty($setting['watermark_by_sitecreator_remove_trash_disable']) && is_file($file_image_webp_secret)) @unlink($file_image_webp_secret);
        } else {
          // проверим, возможно, что раньше существовал секретный файл webp и он еще не удален и не переименован
          if (is_file($file_image_webp_secret) && (filectime($file_to_convert) < filectime($file_image_webp_secret))) {
            @rename($file_image_webp_secret, $file_image_webp);// только переименование
            $create_webp = false;
          }
        }
      }

      if (!empty($setting['watermark_by_sitecreator_secretpath'])) $file_image_webp = $file_image_webp_secret;

      if($create_webp && is_file($file_to_convert)) {  // если делать webp все же нужно и есть для него входной png/jpg

        // проверим верно ли, что внутри JPG или PNG
        $info = getimagesize($file_to_convert);
        $width  = $info[0];
        $height = $info[1];
        $mime = isset($info['mime']) ? $info['mime'] : '';

        // только для настоящих PNG или JPEG внутри, что бывает не совпадает с расширением.
        if(($mime == 'image/jpeg' || $mime == 'image/png') && $width > 0 && $height > 0) {
          $image_to_convert = new Image();
          // создадим webp в дополнение к Jpeg или png
          $q = $extra_parameters['webp_quality'];
          if(strtolower($extension) == 'png' && $mime == 'image/png' && $extra_parameters['webp_png_lossless']) $q = 100;
          $image_to_convert->webp($file_to_convert, $file_image_webp, $q, $setting['watermark_by_sitecreator_cwebp_enable']); // сработает если файл для преобразования jpeg или png как по расширению, так и по mime type

        }


      }


    }
    // --------------------   WEBP     --------------------------------------------------
    // ======= WEBP  =========== WEBP  ============== WEBP  ============== WEBP  ================ WEBP  =================



    // ++++++++++++++++++ Создание JPG, PNG, GIF ++++++++++++++++++++++++++++++++++

  if ($create_img  || $replase_link || (filectime(DIR_IMAGE . $image_old) > filectime(DIR_IMAGE . $image_new))) {
    
    $image_info = getimagesize(DIR_IMAGE . $image_old);
    list($width_orig, $height_orig, $image_type) = $image_info;
    
    if (!in_array($image_type, array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF)) && strtolower($extension) != 'svg'){
       //return DIR_IMAGE . $image_old;
    }

    $path = '';
    $directories = explode('/', dirname(str_replace('../', '', $image_new)));
    foreach ($directories as $directory) {
      $path = $path . '/' . $directory;
      if (!is_dir(DIR_IMAGE . $path)) @mkdir(DIR_IMAGE . $path, 0777);
    }


    $format_jpeg = preg_match('#\.jpe?g$#i', $image_old);

    $extra_parameters['image_popup_width'] = 0;
    $extra_parameters['image_popup_height'] = 0;


    $watermark_break = false; // не запрещаем накладывать знак если он включен галочкой

    // в режиме Маркета не накладываем знак и не сжимаем
    if (!empty($setting['watermark_by_sitecreator_enable_market'])
      && $setting['watermark_by_sitecreator_market_w'] == $width
      && $setting['watermark_by_sitecreator_market_h'] == $height) {
      $watermark_break = true;
      $extra_parameters['webp_jpeg'] = false;
      $extra_parameters['webp_png'] = false;
      $extra_parameters['mozjpeg'] = false;
      $extra_parameters['optipng'] = false;
    }

    if(!defined('VERSION')) {
      $oc23 = true;
      // скорее всего пришли от "выгрузка" нео сяо
      // значит, сжатия не должно быть и водяного знака


      foreach ($extra_parameters as $k => $par) {
        $extra_parameters[$k] = false;
      }
      $setting['watermark_by_sitecreator_status'] = false;

    }
    else {
      $oc23 = (version_compare(VERSION, "2.3", ">="))? true:false;
//      $oc15 = (version_compare(VERSION, "2.0", "<"))? true:false;
    }



    


    if(!$oc23) { // 1.5 ... 2.2
      $pre_config = 'config_';
    } else { // 2.3
      $pre_config = $this->config->get('config_theme').'_'; // название темы (theme_defaul, например)
    }

    // если заданы параметры обработки всплывающих изображений
    if($extra_parameters['for_popup_img_noborder'] || $extra_parameters['for_popup_img_fit_to_width_nocrop'] ||
      $extra_parameters['for_popup_img_no_max_fit'] || $extra_parameters['for_popup_img_white_back']) // не создавать белые поля для всплывающих изображений
    {
      $extra_parameters['image_popup_width'] = $this->config->get($pre_config.'image_popup_width');
      $extra_parameters['image_popup_height'] = $this->config->get($pre_config.'image_popup_height');
    }

    // если заданы параметры обработки БОЛЬШИХ (thumb) изображений товара
    if($extra_parameters['for_thumb_img_noborder'] || $extra_parameters['for_thumb_img_fit_to_width_nocrop'] ||
      $extra_parameters['for_thumb_img_no_max_fit'] || $extra_parameters['for_thumb_img_white_back']) // не создавать белые поля для всплывающих изображений
    {
      $extra_parameters['image_thumb_width'] = $this->config->get($pre_config.'image_thumb_width');
      $extra_parameters['image_thumb_height'] = $this->config->get($pre_config.'image_thumb_height');
    }


    if (strtolower($extension) != 'svg' && !empty($width_orig) && ($width_orig != $width || $height_orig != $height || $setting['watermark_by_sitecreator_status']
      || ($format_jpeg && $extra_parameters['mozjpeg']) || (!$format_jpeg && $extra_parameters['optipng']))) {	// если watermart нужен, то всегда
      // пережмем всегда если разрешено суперсжатие для соответствующего формата, даже если размеры совпадают, иначе суперсжатие не сработает
      $image = new Image(DIR_IMAGE . $image_old);

      if (empty($crop_type)) { // по умолчанию возьмем из настроек модуля
        $crop_type = $setting['watermark_by_sitecreator_crop_type'];
      }
      if(!empty($type) && !empty($enable_crop_by_theme)) $crop_type = $type; // если есть значение на входе, то отдаем ему приоритет если разрешено

      $path_img = dirname($image_old);

      // проверить исключения для обрезки
      $dirs_noTrim = $setting['watermark_by_sitecreator_dirs_noTrim']; // список директорий для исключения обрезки исходника
      foreach($dirs_noTrim as $dir_off) {
        // является ли $dir_off  частью пути $path_img и НАЧИНАЕТСЯ с этого пути
        // либо сам файл изображения есть в списке исключения
        // регистр учитываем
        if (strpos($path_img, $dir_off) === 0 || $image_old == $dir_off) {
          $extra_parameters['enable_trim'] = false;  // запрет обрезки
          break;
        }
      }

      if(($width >= $trim_maxi_w && $height >= $trim_maxi_h) || ($width <= $trim_mini_w && $height <= $trim_mini_h)) $extra_parameters['enable_trim'] = false;  // запрет обрезки

      if(empty($market)) {
        if($type == 'auto_width') {
          $crop_type = '';  // никакой обрезки
          // никаких манипуляций с размерами
          if(!empty($extra_parameters['for_thumb_img_fit_to_width_nocrop'])) unset($extra_parameters['for_thumb_img_fit_to_width_nocrop']);
          if(!empty($extra_parameters['for_popup_img_fit_to_width_nocrop'])) unset($extra_parameters['for_popup_img_fit_to_width_nocrop']);

          // не увеличивать сверх размеров оригинала - отменяем действие этой опции
          if(!empty($extra_parameters['for_thumb_img_no_max_fit'])) unset($extra_parameters['for_thumb_img_no_max_fit']);
          if(!empty($extra_parameters['for_popup_img_no_max_fit'])) unset($extra_parameters['for_popup_img_no_max_fit']);

          // сохранен оригинальный алгоритм расчета light$hop_resize
          // "оригинальный" в данном контексте не означает уникальный и/или патентованый и/или распространяемый по лицензии,
          // следует читать как "аналогичный" или "с тем же результатом"
          // банальный метод, используемый повсеместно в миллионах приложений
          // никакой сторонний код, требующий специального разрешения на использование, не применен
          $width = round($width_orig * $height/$height_orig, 2);
        }
        $image->resize($width, $height, $crop_type, $extra_parameters); // $type - тип обрезки: w h auto
      }
      else {
        // не обрабатываем изображения если МАРКЕТ
        $image->resize($width, $height, '', []);
        if(!empty($text_for_market) && !empty($setting['watermark_by_sitecreator_market_stickers_enable'])) {  // если есть текст для стикера и разрешено наложение
          // Параметры для формирования стикеров (не нужно их редактировать!!!)
          // Редактируйте эти параметры в файле market_text_settings.php ($market_text_settings)

          // если $text_for_market является массивом, то это $product
          if(is_array($text_for_market)) {
            if(!empty($setting['watermark_by_sitecreator_ind_for_market_text'])) {
              $ind = $setting['watermark_by_sitecreator_ind_for_market_text'];
              if(!empty($text_for_market[$ind])) $text_for_market = $text_for_market[$ind];
              else $text_for_market = '';
            }
            else $text_for_market = '';
          }
          if(!empty($text_for_market)) {
            $delimetr = '|';

            $fontFamily = DIR_SYSTEM."library/sitecreator/fonts/arial.ttf";
            $fontSize = 18;
            $fontColor = '#ffffff';
            $FillColor = "#836233";  // цвет заливки стикера
            $strokeColor = '#000';
            $paddingLeft = $fontSize;
            $paddingTop = $fontSize/4;
            $marginTop = $paddingTop;

            // файл настроек для стикеров
            $market_text_settings = DIR_SYSTEM."library/sitecreator/market_text_settings.php";
            @include $market_text_settings;

            $text_settings = [
              'fontFamily' => $fontFamily,
              'fontSize' => $fontSize,
              'fontColor' => $fontColor,
              'FillColor' => $FillColor,
              'strokeColor' => $strokeColor,
              'paddingLeft' => $paddingLeft,
              'paddingTop' => $paddingTop,
              'marginTop' => $marginTop,
            ];



            $text_for_market = explode($delimetr, $text_for_market);
            $text_for_market = array_filter($text_for_market);  // пустые удалим, т. е. такие: ''
            // только при наличии Imagick
            if(class_exists('Imagick')) $image->print_text($text_for_market, $text_settings);
          }


        }
      }

      $reg = '/nowatermark|no_image/i'; // название (части) папки или часть имени в файле  для исключения watermark
      if (!preg_match($reg, $image_old) && $width >= $minW && $width <= $maxW && $height >= $minW && $height <= $maxW) {
        // исключить директории

        $dirs_off = $setting['watermark_by_sitecreator_dirs']; // список директорий для исключения watermark
        $path_img = dirname($image_old);

        foreach($dirs_off as $dir_off) {
          // является ли $dir_off  частью пути $path_img и НАЧИНАЕТСЯ с этого пути
          // либо сам файл изображения есть в списке исключения
          // регистр учитываем
          if (strpos($path_img, $dir_off) === 0 || $image_old == $dir_off) {
            $watermark_break = true;
            break;
          }
        }


        // если не отменено как исключение для категорий и есть картинка для watermark, и есть статус=включено (1)
        if ((empty($market) || $setting['watermark_by_sitecreator_market_watermark_enable'])
          && empty($watermark_break) && $setting['watermark_by_sitecreator_status'] && !empty($setting['watermark_by_sitecreator_image']))

          $image->watermark(DIR_IMAGE . $setting['watermark_by_sitecreator_image'],
            $setting['watermark_by_sitecreator_posx'],
            $setting['watermark_by_sitecreator_posy'],
            $setting['watermark_by_sitecreator_degree'],
            $setting['watermark_by_sitecreator_width'],
            $setting['watermark_by_sitecreator_height'],
            $setting['watermark_by_sitecreator_opacity']);

      }


      // запись изображения с заданным настройкой качеством
      if(empty($market)) {
        // public function save($file, $quality = 80, $clear = true, $compare_file_size = false, $extra_parameters = [])
        // $clear - очистка памяти после сохранения.  Объект будет недоступен после сохранения по умолчанию

        $image->save(DIR_IMAGE . $image_new, $setting['watermark_by_sitecreator_quality'], true, $compare_file_size, $extra_parameters);
      }
      else {
        // сохранение для я-маркета
        // если включен режим создания изображений по расписанию (фоновое задание)
        if(!empty($setting['watermark_by_sitecreator_market_image_generate_disable'])) {
          // вместо файла создадим символьную ссылку
          $dummy_file = DIR_IMAGE.$market_cache.'dummy';
          $ext_lower = strtolower($extension);  // расширение файла-исходника
          switch ($ext_lower) {
            case 'jpg':
            case 'jpeg':
            $dummy_ext = 'jpg';
              break;
            case 'png':
              $dummy_ext = 'png';
              break;
            case 'gif':
              $dummy_ext = 'gif';
              break;
              // SVG  просто полностью копируется из исходников.   Поэтому сюда перехода не будет.
            case 'svg':
              $dummy_ext = 'svg';
              break;
            default:
              $dummy_ext = 'jpg';
              break;
          }
          $dummy_file = $dummy_file.".$dummy_ext";  // заглушка-изображение в кеше я-маркета на время генерации изображений

          // если заглушки нет, то создадим ее  (copy)
          if(!is_file($dummy_file)) {
            if(!is_dir(DIR_IMAGE.$market_cache)) @mkdir(DIR_IMAGE.$market_cache, 0777);
            if (is_file(DIR_IMAGE.'sitecreator/dummy.'.$dummy_ext)) @copy(DIR_IMAGE.'sitecreator/dummy.'.$dummy_ext, $dummy_file);
            chmod($dummy_file, 0444);
          }
          if(!is_link(DIR_IMAGE . $image_new)) symlink($dummy_file, DIR_IMAGE . $image_new);

        }
        // обычное создание на лету
        else $image->save(DIR_IMAGE . $image_new, $setting['watermark_by_sitecreator_market_quality']);

      }

    } else copy(DIR_IMAGE . $image_old, DIR_IMAGE . $image_new);  // если svg, то скопируем
  }

  $imagepath_parts = explode('/', $image_new);
  // приведено к единообразию согласно
  //https://github.com/myopencart/ocStore/commit/7bc6b37c5c2fece3b3cd6d560e528539b05bd5af
  $image_new = implode('/', array_map('rawurlencode', $imagepath_parts));

  if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1')))
    $domain = (defined('HTTPS_CATALOG'))? HTTPS_CATALOG: HTTPS_SERVER;
  else $domain = (defined('HTTP_CATALOG'))? HTTP_CATALOG: HTTP_SERVER;


  return $domain . 'image/' . $image_new;
	}




}

// расширяем возможности и совместимость для работы с различными специфическими шаблонами, которые делают манипуляции с изображениями
if(defined('DIR_CATALOG')) $include_file_for_themes = DIR_CATALOG.'model/tool/';  // подключение для админки
else $include_file_for_themes = DIR_APPLICATION.'model/tool/';  // подключение для паблика

$include_file_for_themes .= 'image_sitecreator_for_themes.php';
if(is_file($include_file_for_themes)) require $include_file_for_themes;
else {
  // если нет файла с новыми  методами для класса  ModelToolImage
  class ModelToolImage extends ModelToolImageBySitecreator {

  }
}


