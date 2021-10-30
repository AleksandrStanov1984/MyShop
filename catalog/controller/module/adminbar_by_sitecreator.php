<?php
// Админ Бар для работы с изображениями (c) 2018
// разработчик - sitecreator.ru
// права принадлежат sitecreator.ru
// не разрешается распространение без разрешения автора (sitecreator.ru)
class ControllerModuleAdminbarBySitecreator extends Controller {

  private $adminvar_ver = "1.3.1";
  public function index() {

    $oc23 = (version_compare(VERSION, "2.3", ">="))? true:false;
    $data = [];

    if($oc23) $html = $this->load->view('/module/adminbar_by_sitecreator.tpl', $data);
    else $html = $this->load->view('default/template/module/adminbar_by_sitecreator.tpl', $data);
    return $html;

  }

// либо очистить кеш, либо сжать изображения по прямым ссылкам и в background CSS
  public function clear_img_cache_for_page() {
    $this->load->language('module/watermark_by_sitecreator');
    $json = [];
    $json['success'] = '';
    $compress = false;
    if(class_exists('\User'))  $user_stcrtr = new User($this->registry);
    elseif(class_exists('Cart\User')) $user_stcrtr = new Cart\User($this->registry);  // для oc23

    if ($user_stcrtr->hasPermission('modify', 'module/watermark_by_sitecreator')) {
      $token = $this->session->data['token'];
      if(isset($this->request->get['token']) && $this->request->get['token'] == $token && isset($this->request->post['imgs_src_json'])) {

        if(isset($this->request->get['compress']) && $this->request->get['compress'] == 'ok') $compress = true;

        $imgs_src = array_unique($this->request->post['imgs_src_json']);
        $count_img = 0;

        foreach ($imgs_src as $k => $src) {
          $imgs_src[$k] = urldecode($imgs_src[$k]);
          if(strpos($imgs_src[$k], HTTP_SERVER) === false && strpos($imgs_src[$k], HTTPS_SERVER) === false) unset($imgs_src[$k]);  // это не изображения?
          else {
            $imgs_src[$k] = str_replace(HTTP_SERVER, '', $imgs_src[$k]);
            $imgs_src[$k] = str_replace(HTTPS_SERVER, '', $imgs_src[$k]);
            if((strpos($imgs_src[$k], 'image/cache/') === 0)  && !$compress) { // картинки в кеше и если не выбран compress (без удаления)
              $file = dirname(DIR_IMAGE).'/'.$imgs_src[$k];
              $trim_cache_file = preg_replace('~^image/cache/~', 'image/cache/trim/', $imgs_src[$k]);
              $trim_cache_file = preg_replace('~-\d+x\d+\.(jpg|JPG|jpeg|JPEG|png|PNG)$~', '.$1', $trim_cache_file); // Обрезаннный исходник в кеше

              $trim_cache_file = dirname(DIR_IMAGE).'/'.$trim_cache_file;
              //$json['success'] .= "trim $trim_cache_file \n";
              if(is_file($file)) {
                @unlink($file);
                $count_img++;
                $json['success'] .= 'DEL '.$imgs_src[$k]."\n";
              }
              if(is_file($trim_cache_file) && !empty($this->request->get['trim_cache_clear'])) {
                @unlink($trim_cache_file);
                //$count_img++;
                $json['success'] .= '>> DEL TRIM CACHE '.$trim_cache_file."\n";
              }


            }
            elseif((strpos($imgs_src[$k], 'image/cache/') !== 0) && $compress) {// если не кеш и $compress
//              $json['success'] .= 'COMPRESS '.$imgs_src[$k]."\n";

              $quality = 80;
              if (!empty($this->request->get['quality'])) $quality = (int)$this->request->get['quality'];
              if ($quality > 100 || $quality < 1) $quality = 80;

              $extra_param = [
                'mozjpeg' => true,
                'optipng' => true,
                'optipng_level' => 3
              ];

              // проверка на index.php?route=captcha/basic_captcha/captcha  и подобные динамические
              if(preg_match('~^index\.php\?~', $imgs_src[$k]) === 1) {
                continue;  // перейдем к следующему изображению
              }

              if(preg_match('~^image/~', $imgs_src[$k]) === 1) {    // в папке DIR_IMAGE
                $imgs_src[$k] = preg_replace('~^image/~', '', $imgs_src[$k]);
                $file = DIR_IMAGE. $imgs_src[$k];
                $ext = strtolower(pathinfo($file)['extension']);
                if($ext != 'png' && $ext != 'jpg' && $ext != 'jpeg') continue;  // перейдем к следующему изображению

                $file_b = 'backup_uncompressed/'.$imgs_src[$k];
                $file_b = str_replace("\\", '/', $file_b);  // windows

                $path = '';
                $directories = explode('/', dirname(str_replace('../', '', $file_b)));
                foreach ($directories as $directory) {
                  $path = $path . '/' . $directory;
                  if (!is_dir(DIR_IMAGE . $path)) @mkdir(DIR_IMAGE . $path, 0777);
                }

                $file_b = DIR_IMAGE. $file_b;
                if(is_file($file) && !is_file($file_b)) copy($file, $file_b); // копируем если не существует копия


                // сжимаем =============== сжимаем ======================== сжимаем ===================== сжимаем ========================== сжимаем ==================

                $img = new Image($file_b); // открываем копию
                $img->save($file, $quality, true, false, $extra_param);



                if($ext == 'jpg' || $ext == 'jpeg') $json['success'] .= "q= $quality ";
                $json['success'] .= 'COMPRESS '.$imgs_src[$k]."\n";
              }
              else {  // остальные изображения не в папке image


                $file = dirname(DIR_SYSTEM).'/'.$imgs_src[$k];
                $file = str_replace("\\", '/', $file);  // windows
                $info = pathinfo($file);
                $ext = strtolower($info['extension']);
                if($ext == 'svg') continue;  // перейдем к следующему изображению
                if(is_file($file) && in_array($ext, ['jpg','jpeg','png']) ) {

                  $file_ = $info['dirname'] . '/' . $info['filename'] . '__source__.' . $info['extension'];
                  if (!file_exists($file_) && file_exists($file)) copy($file, $file_);  // если не существует копия


//                  echo "$file ++\n";
                  $img = new Image($file_); // открываем копию
                  $img->save($file, $quality, true, false, $extra_param);
//
                  if($ext == 'jpg' || $ext == 'jpeg') $json['success'] .= "q= $quality ";
                  $json['success'] .= 'COMPRESS__ '.$file."\n";
                }
              }

            }
          }

        }
        $json['success'] = "$count_img files DELETED \n".$json['success'];
//        print_r($imgs_src);
      }

      $json['success'] .= "";
    }
    else $json['error'] = $this->language->get('error_permission');

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

  // залогинен?
  public function isLogged00() {
    $json = [];
    $json['isLogged'] = false;
    if(class_exists('\User'))  $user_stcrtr = new User($this->registry);
    elseif(class_exists('Cart\User')) $user_stcrtr = new Cart\User($this->registry);  // для oc23

    if(!empty($user_stcrtr) && is_object($user_stcrtr) && method_exists(get_class($user_stcrtr), 'isLogged')
      && !empty($user_stcrtr->isLogged()) && ($user_stcrtr->hasPermission('modify', 'module/watermark_by_sitecreator'))) {
      $json['isLogged'] = true;
    }
    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }


  public function isLogged() {
    $json = [];
    $json['success'] = '';
    $json['html'] = '';
    $json['link'] = '';
    $json['isLogged'] = false;

    $oc23 = (version_compare(VERSION, "2.3", ">="))? true:false;

    if(class_exists('\User'))  $user_stcrtr = new User($this->registry);
    elseif(class_exists('Cart\User')) $user_stcrtr = new Cart\User($this->registry);  // для oc23

    if(!empty($user_stcrtr) && is_object($user_stcrtr) && method_exists(get_class($user_stcrtr), 'isLogged')) {  // немного перестраховки
      if(!empty($user_stcrtr->isLogged()) && !empty($this->session->data['token']) && ($user_stcrtr->hasPermission('modify', 'module/watermark_by_sitecreator'))
        && empty($this->config->get('watermark_by_sitecreator_disable_admin_bar'))) { // пока всегда включен, отключить можно из админки модуля
        $token = $this->session->data['token'];
        $link = '';
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
          $link = HTTPS_SERVER;
        }
        else $link = HTTP_SERVER;

        if(!empty($link)) { // если в настройках есть линк
          $link_clear_img_cache_for_page = str_replace('&amp;', '&', $link.'index.php?route=module/adminbar_by_sitecreator/clear_img_cache_for_page&token='.$token);
        }

        $json['isLogged'] = true;
        if(!empty($link_clear_img_cache_for_page)) $json['link'] = $link_clear_img_cache_for_page;

        $json['html'] = '<div id="sitecreator_bar" style="
line-height: 0;
font-size: 0;
position:fixed;
top: 0;
left: 0;
visibility: hidden;
background: rgba(249,203,112,0.97);
width:100%;
z-index: 99997;
padding: 2px 10px 2px;
border-top: double 3px #f7b263;
border-bottom: double 3px #f7b263;">
<div style="display: table; margin: 0; width: 100%">
      <div style="display: table-row; vertical-align: top; margin: 0;">
        <div style="display: table-cell; vertical-align: top; padding: 5px 8px 0 8px; margin: 0; width: 250px;"><button title="Очистить кеш изображений для этой страницы." id="sitecreator_btn_clear_cache_img"
  style="
  display: inline-block;
  position:relative;
  font-size: 12px;
  line-height: 22px;
  font-family: Arial, Helvetica, sans-serif;
  color: #f6f6f6;
  text-decoration: none;
  padding: 5px 14px;
  outline: none;
  border: 1px solid #ea8d17;
  border-bottom: 1px solid #bf7313;
  border-radius: 4px;
  background: linear-gradient(#F3AE0F, #E38916) #E38916;
  transition: 0.2s;
  box-sizing: border-box;
  margin: 0 15px 5px 0;
 "
   
  onmouseover="this.style.color=\'white\';"  onmouseout="this.style.color=\'#f6f6f6\';"">Сlear cache</button>
  <button title="Сжать на странице изображения, не попадающие в кеш (не обрабатываемые движком) " id="sitecreator_btn_compress_img"
  style="
  display: inline-block;
  position:relative;
  font-size: 12px;
  line-height: 22px;
  font-family: Arial, Helvetica, sans-serif;
  color: #f6f6f6;
  text-decoration: none;
  padding: 5px 14px;
  outline: none;
  border: 1px solid #4ac663;
  border-bottom: 1px solid #3e9c3e;
  border-radius: 4px;
  background: linear-gradient(#53de6e, #4CBD4C) #4cbd4c;
  transition: 0.2s;
  box-sizing: border-box;
  margin: 0 0px 5px 0;
 "
   
  onmouseover="this.style.color=\'white\';"  onmouseout="this.style.color=\'#f6f6f6\';"">Compress</button>
  </div>
        <div style="display: table-cell; vertical-align: top; padding:  3px 8px; margin: 0;"><input id="jpeg_q_sitecreator" name="jpeg_q_sitecreator" type="text" title="качество JPEG" value="80" style="
        font-size: 11px;
    line-height: 13px;
    color: #000;
    background: #ffeac1;
    height: 38px;
    width: 38px;
    border-radius: 3px;
    border: solid 1px #ea932a;
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
    margin: 0;
    padding: 4px 10px;
        "></div>
        <div style="display: table-cell; vertical-align: top; padding:  3px 8px; margin: 0;"><textarea id="sitecreator_bar_info" style="
    box-sizing: border-box;
    font-size: 11px;
    line-height: 13px;
    color: #000;
    background: #ffeac1;
    height: 38px;
    width: 500px;
    border-radius: 3px;
    border: solid 1px #ea932a;
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
    margin: 0;
    padding: 4px 10px;
" readonly="readonly"></textarea></div>
        <div style="display: table-cell; vertical-align: top; padding:  10px 8px; margin: 0; opacity: 0.85; text-align: right; font-size:11px;">
          <label style="margin-bottom: 5px; margin-right: 10px;" title="Очистить кеш результата обрезки источника (Обрезаннный исходник в кеше)"><input type="checkbox" id="sitecreator_bar_trim_cache_clear" name="sitecreator_bar_trim_cache_clear"> trim cache clear</label>
          <select id="sitecreator_bar_sel_pos">
          </select>
        </div>
        <div style="display: table-cell; vertical-align: top; padding:  3px 8px; margin: 0; opacity: 0.6; text-align: right; width: 156px;"><div style="font-size:11px; line-height: 12px; padding: 3px 0;">Admin IMAGE Bar ver. '.$this->adminvar_ver.'</div><img src="
           data:image/png;base64,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" style="
    width: 120px; height: 15px; margin-top: 0px;"></div>
      </div></div><div></div>
</div>';
      }
    }

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }

}
//
//
//
//<style>
//  .w {
//    background: linear-gradient(#4ac663, #4CBD4C) #3e9c3e;
//  }
//</style>
?>