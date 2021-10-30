<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
      <button id="btn_submit" type="submit" form="form-watermark_by_sitecreator" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <button style="border: solid 1px #c0c0c0" type="submit" onclick="$('input#noclose').val(1);" form="form-watermark_by_sitecreator" data-toggle="tooltip" title="<?php echo $button_save_and_noclose; ?>" class="btn"><i class="fa fa-save"></i></button>

        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
    <h2><?php echo $heading_title; ?></h2>
    <ul class="breadcrumb">
      <?php
      //if(empty($fast_f) || strlen($fast_f) < 256) echo '<script>document.getElementById("content").style.display = "none";</script>'
      foreach ($breadcrumbs as $breadcrumb) { ?>
      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
      <?php } ?>
    </ul>
      </div>
    </div>
    <div class="container-fluid">
      <?php if ($error_warning) { ?>
      <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
      <?php } ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
        </div>
        <ul class="nav nav-tabs scr-module" style="margin-bottom:0;">
          <li class="active"><a href="#tab-main" data-toggle="tab"><?php echo $text_tab_main; ?></a></li>
          <li class=""><a href="#tab-service" data-toggle="tab"><?php echo $text_tab_service; ?></a></li>
          <li class=""><a href="#tab-theme" data-toggle="tab"><?php echo $text_tab_theme; ?></a></li>
          <li class=""><a href="#tab-help" data-toggle="tab"><?php echo $text_tab_help; ?></a></li>
        </ul>
        <div class="panel-body tab-content">
          <div id="tab-main" class="tab-pane active">
            <form  action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-watermark_by_sitecreator" class="form-horizontal">


              <div class="form-group" style="display: none">
                <label  class="col-sm-4 control-label"><?php echo $text_imagick_disable; ?></label>
                <div class="col-sm-8">
                  <input disabled="disabled" type="checkbox" id="input-imagick_disable"  class="form-control"  name="watermark_by_sitecreator_imagick_disable" <?php if(!empty($imagick_disable)) echo 'checked'; ?>>
                </div>
              </div>
              <div class="form-group" style="">
                <div  class="col-sm-4 header_stcrtr">СЖАТИЕ включить</div><div class="col-sm-8 header2_stcrtr"></div>
              <div style="height:15px; clear: both;"></div>
              <label  class="col-sm-4 control-label"><?php echo $text_mozjpeg_enable; ?></label>
              <div class="col-sm-8">
                <input type="checkbox" id="input-mozjpeg_enable"  class="form-control"  name="watermark_by_sitecreator_mozjpeg_enable" <?php if(!empty($mozjpeg_enable)) echo 'checked'; ?>>
              </div>
          </div>
          <div class="form-group" style="">
            <label  class="col-sm-4 control-label"><?php echo $text_optipng_enable; ?></label><br>
            <div class="col-sm-8">
              <input type="checkbox" id="input-optipng_enable"  class="form-control"  name="watermark_by_sitecreator_optipng_enable" <?php if(!empty($optipng_enable)) echo 'checked'; ?>>

            </div>
            <div style="height:15px; clear: both;"></div>
            <label  class="col-sm-4 control-label"><?php echo $text_optipng_level; ?></label>
            <div class="col-sm-8">
              <select id="input-optipng_level"  class="form-control"  name="watermark_by_sitecreator_optipng_level">
                <option value=1 <?php if(empty($optipng_level) || $optipng_level == 1) echo 'selected';  ?>>1</option>
                <option value=2 <?php if($optipng_level == 2) echo 'selected';  ?>>2</option>
                <option value=3 <?php if($optipng_level == 3) echo 'selected';  ?>>3</option>
                <option value=4 <?php if($optipng_level == 4) echo 'selected';  ?>>4</option>
                <option value=5 <?php if($optipng_level == 5) echo 'selected';  ?>>5</option>
              </select>
            </div>

          </div>
          <div class="form-group" style="">
            <label  class="col-sm-4 control-label"><?php echo $text_test_compressing; ?></label>
            <div class="col-sm-8">
              <input type="checkbox" id="input-test_compressing"  class="form-control"  name="watermark_by_sitecreator_test_compressing" <?php if(!empty($test_compressing)) echo 'checked'; ?>>
            </div>
          </div>
              <div class="form-group">
                <div  class="col-sm-4 header_stcrtr header_color2">КАЧЕСТВО для ВСЕХ изображений</div><div class="col-sm-8 header2_stcrtr"></div>
              <div style="height:15px; clear: both;"></div>
                <label class="col-sm-4 control-label"><?php echo $text_img_quality; ?></label>
                <div class="col-sm-8">
                  <input style="border: 2px solid #0c942c; background: #e1f8e3; color: #000" type="text" id="input-quality" pattern="^[0-9]{1,3}$" class="form-control" name="watermark_by_sitecreator_quality" value="<?php echo $quality; ?>">
                  <br></div>
                <div style="height:15px; clear: both;"></div>
                <label class="col-sm-4 control-label"><?php echo $text_webp_quality; ?></label>
                <div class="col-sm-8">
                  <input type="text" id="input-webp_quality" pattern="^[0-9]{1,3}$" class="form-control"  name="watermark_by_sitecreator_webp_quality" value="<?php echo $webp_quality; ?>">
                </div>
              </div>

              <div class="form-group">
                <div  class="col-sm-4 header_stcrtr header_color2">КАЧЕСТВО для МАЛЕНЬКИХ изображений</div><div class="col-sm-8 header2_stcrtr"></div>
                <div style="height:15px; clear: both;"></div>
                <label class="col-sm-4 control-label"><?php echo $text_img_mini_quality; ?></label>
                <div class="col-sm-8">
                  <input style="border: 2px solid #0c942c; background: #e1f8e3; color: #000" type="text" id="input-mini_quality" pattern="^[0-9]{1,3}$" class="form-control"  name="watermark_by_sitecreator_mini_quality" value="<?php echo $mini_quality; ?>">
                  <br></div>
                <div style="height:15px; clear: both;"></div>
                <label class="col-sm-4 control-label"><?php echo $text_img_mini_w_and_h; ?></label>
                <div class="col-sm-8">
                  <input type="text" id="input-img_mini_w" pattern="^[0-9]{1,3}$" class="form-control"  name="watermark_by_sitecreator_img_mini_w" value="<?php echo $img_mini_w; ?>">
                  <input type="text" id="input-img_mini_h" pattern="^[0-9]{1,3}$" class="form-control"  name="watermark_by_sitecreator_img_mini_h" value="<?php echo $img_mini_h; ?>">
                </div>
          <div style="height:15px; clear: both;"></div>
          <label  class="col-sm-4 control-label"><?php echo $text_img_mini_if_and; ?></label>
          <div class="col-sm-8">
            <input type="checkbox" id="input-img_mini_if_and"  class="form-control"  name="watermark_by_sitecreator_img_mini_if_and" <?php if(!empty($img_mini_if_and)) echo 'checked'; ?>>
          </div>
        </div>
          <div class="form-group">
            <div  class="col-sm-4 header_stcrtr header_color2">КАЧЕСТВО для БОЛЬШИХ изображений</div><div class="col-sm-8 header2_stcrtr"></div>
          <div style="height:15px; clear: both;"></div>
          <label class="col-sm-4 control-label"><?php echo $text_img_maxi_quality; ?></label>
          <div class="col-sm-8">
            <input style="border: 2px solid #0c942c; background: #e1f8e3; color: #000" type="text" id="input-maxi_quality" pattern="^[0-9]{1,3}$" class="form-control"  name="watermark_by_sitecreator_maxi_quality" value="<?php echo $maxi_quality; ?>">
            <br></div>
          <div style="height:15px; clear: both;"></div>
          <label class="col-sm-4 control-label"><?php echo $text_img_maxi_w_and_h; ?></label>
          <div class="col-sm-8">
            <input type="text" id="input-img_maxi_w" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_img_maxi_w" value="<?php echo $img_maxi_w; ?>">
            <input type="text" id="input-img_maxi_h" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_img_maxi_h" value="<?php echo $img_maxi_h; ?>">
          </div>
        <div style="height:15px; clear: both;"></div>
        <label  class="col-sm-4 control-label"><?php echo $text_img_maxi_if_and; ?></label>
        <div class="col-sm-8">
          <input type="checkbox" id="input-img_maxi_if_and"  class="form-control"  name="watermark_by_sitecreator_img_maxi_if_and" <?php if(!empty($img_maxi_if_and)) echo 'checked'; ?>>
        </div>
        <div style="height:15px; clear: both;"></div>
        <label  class="col-sm-4 control-label"><?php echo $text_img_maxi_no_compress; ?></label>
        <div class="col-sm-8">
          <input type="checkbox" id="input-img_maxi_no_compress"  class="form-control"  name="watermark_by_sitecreator_img_maxi_no_compress" <?php if(!empty($img_maxi_no_compress)) echo 'checked'; ?>>
        </div>
        </div>
      
              <div class="form-group">
                <div  class="col-sm-4 header_stcrtr">WebP</div><div class="col-sm-8 header2_stcrtr"></div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_webp_enable_jpeg; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-webp_enable_jpeg"  class="form-control"  name="watermark_by_sitecreator_webp_enable_jpeg" <?php if(!empty($webp_enable_jpeg)) echo 'checked'; ?>>
                </div>
              </div>
              <div class="form-group">

                <label  class="col-sm-4 control-label"><?php echo $text_webp_enable_png; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-webp_enable_png"  class="form-control"  name="watermark_by_sitecreator_webp_enable_png" <?php if(!empty($webp_enable_png)) echo 'checked'; ?>><br><br>
                </div>
                <label  class="col-sm-4 control-label"><?php echo $text_webp_png_lossless; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-webp_png_lossless"  class="form-control"  name="watermark_by_sitecreator_webp_png_lossless" <?php if(!empty($webp_png_lossless)) echo 'checked'; ?>>
                </div>
              </div>

              <div class="form-group <?php if(empty($licExt1)) echo 'plugin_disable';  ?>"  <?php if(empty($licExt1)) echo 'style="background: #eaeaea;"';  ?> >
                <div  class="col-sm-4 header_stcrtr header_color3">Работа с фоном ИСХОДНИКА.<br>экспериментально ("как есть").<br>(нужен imagick)
                </div>
                <div class="col-sm-8 header2_stcrtr">
                  <a class="toggle_block" id="background_group_click" href="#" onclick="return false;">
                    <i class="fa fa-eye" aria-hidden="true"></i>&nbsp; Показать / скрыть параметры &nbsp;<i class="fa fa-eye-slash" aria-hidden="true"></i></a></div>
  <div style="height:10px; clear: both;"></div>
                <div class="lic_alert"><?php if(empty($licExt1)) echo 'Плагин <b>НЕАКТИВЕН</b>. Для активации функций необходим ключ, приобретается отдельно.';
                  else echo 'Плагин АКТИВЕН (лицензия подтверждена)'; ?></div>

              <label  class="col-sm-4 control-label"><?php echo $text_enable_trim; ?></label>
              <div class="col-sm-8">
                <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?> type="checkbox" id="input-enable_trim"  class="form-control"  name="watermark_by_sitecreator_enable_trim" <?php if(!empty($enable_trim) && !empty($licExt1)) echo 'checked'; ?>>
              </div>

              <div style="height:15px; clear: both;"></div>

              <div style="padding: 0 15px;">
              <div id="background_group_before" class="form-group half_hidden">
              <label class="col-sm-4 control-label"><?php echo $text_fuzz; ?></label>
              <div class="col-sm-8">
                <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  style="" type="text" id="input-fuzz" pattern="^[0-9]{1,6}$" class="form-control" name="watermark_by_sitecreator_fuzz" value="<?php echo $fuzz; ?>">
                <br></div>
                <div style="height:15px; clear: both;"></div>
              </div>
              </div>
                <div style="display:none;" id="background_group">
    <div class="form-group">
                <label  class="col-sm-4 control-label"><?php echo $text_trim_cache; ?></label>
                <div class="col-sm-8">
                  <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  type="checkbox" id="input-trim_cache"  class="form-control"  name="watermark_by_sitecreator_trim_cache" <?php if(!empty($trim_cache)) echo 'checked'; ?>>
                </div>


                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_enable_multitrim; ?></label>
                <div class="col-sm-8">
                  <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  type="checkbox" id="input-enable_multitrim"  class="form-control"  name="watermark_by_sitecreator_enable_multitrim" <?php if(!empty($enable_multitrim)) echo 'checked'; ?>>
                </div>
              <div style="height:15px; clear: both;"></div>
              <label class="col-sm-4 control-label"><?php echo $text_trim_border; ?></label>
              <div class="col-sm-8">
                <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  style="" type="text" id="input-trim_border" pattern="^[0-9]{1,3}$" class="form-control" name="watermark_by_sitecreator_trim_border" value="<?php echo $trim_border; ?>">
                <br></div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_border_after_trim1; ?></label>
                <div class="col-sm-8">
                  <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  type="checkbox" id="input-border_after_trim1"  class="form-control"  name="watermark_by_sitecreator_border_after_trim1" <?php if(!empty($border_after_trim1)) echo 'checked'; ?>>
                </div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_enable_color_for_fill; ?></label>
                <div class="col-sm-8">
                  <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  type="checkbox" id="input-enable_color_for_fill"  class="form-control"  name="watermark_by_sitecreator_enable_color_for_fill" <?php if(!empty($enable_color_for_fill)) echo 'checked'; ?>>
                </div>
              <div style="height:15px; clear: both;"></div>
              <label  class="col-sm-4 control-label"><?php echo $text_enable_border_fill; ?></label>
              <div class="col-sm-8">
                <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  type="checkbox" id="input-enable_border_fill"  class="form-control"  name="watermark_by_sitecreator_enable_border_fill" <?php if(!empty($enable_border_fill)) echo 'checked'; ?>>
              </div>
                <div style="height:15px; clear: both;"></div>
                <label class="col-sm-4 control-label"><?php echo $text_trim_maxi_w_and_h; ?></label>

                <div class="col-sm-8">
                  <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  type="text" id="input-trim_maxi_w" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_trim_maxi_w" value="<?php echo $trim_maxi_w; ?>">
                  <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  type="text" id="input-trim_maxi_h" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_trim_maxi_h" value="<?php echo $trim_maxi_h; ?>">
                </div>

                <div style="height:15px; clear: both;"></div>
                <label class="col-sm-4 control-label"><?php echo $text_trim_mini_w_and_h; ?></label>
                <div class="col-sm-8">
                  <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  type="text" id="input-trim_mini_w" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_trim_mini_w" value="<?php echo $trim_mini_w; ?>">
                  <input <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?>  type="text" id="input-trim_mini_h" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_trim_mini_h" value="<?php echo $trim_mini_h; ?>">
                </div>

    </div>
  <div class="form-group"  <?php if(empty($licExt1)) echo 'style="background: #eaeaea;"';  ?> >

    <div class="col-sm-4 control-label"><?php echo $text_dirs_noTrim; ?></div>
    <div class="col-sm-8">
                  <textarea class="form-control dirs" name="watermark_by_sitecreator_dirs_noTrim" id="input-dirs_noTrim" <?php if(empty($licExt1)) echo 'disabled="disabled"';  ?> ><?php
                    //echo implode("\n",$dirs_noTrim);
                    echo $dirs_noTrim_implode;
                    ?></textarea>
    </div>
  </div>
  <div class="form-group" <?php if (empty($dirs_error_noTrim) || empty($licExt1)) echo 'style="display: none;"'; ?>>
    <label class="col-sm-4 control-label"><?php echo $text_dirs_error_noTrim; ?></label>
    <div class="col-sm-8">
      <textarea disabled="disabled" class="form-control dirs dirs_error"  id="dirs_error_noTrim"><?php echo $dirs_error_noTrim_implode; ?></textarea>
    </div>
  </div>
</div>
              </div>
              <div class="form-group">
                <div style="background: #7a7a7a;"  class="col-sm-4 header_stcrtr">Разное</div><div class="col-sm-8 header2_stcrtr"></div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_disable_admin_bar; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-disable_admin_bar"  class="form-control"  name="watermark_by_sitecreator_disable_admin_bar" <?php if(!empty($disable_admin_bar)) echo 'checked'; ?>>
                </div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_white_back; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-white_back"  class="form-control"  name="watermark_by_sitecreator_white_back" <?php if(!empty($white_back)) echo 'checked'; ?>>
                </div>
              <div style="height:15px; clear: both;"></div>
              <label  class="col-sm-4 control-label"><?php echo $text_no_image; ?></label>
              <div class="col-sm-8">
                <input type="checkbox" id="input-no_image"  class="form-control"  name="watermark_by_sitecreator_no_image" <?php if(!empty($no_image)) echo 'checked'; ?>>
              </div>
              <div style="height:15px; clear: both;"></div>
              <label  class="col-sm-4 control-label"><?php echo $text_crop_by_theme; ?></label>
              <div class="col-sm-8">
                <input type="checkbox" id="input-crop_by_theme"  class="form-control"  name="watermark_by_sitecreator_crop_by_theme" <?php if(!empty($crop_by_theme)) echo 'checked'; ?>>
              </div>
              <div style="height:15px; clear: both;"></div>
              <label  class="col-sm-4 control-label"><?php echo $text_secretpath; ?></label>
              <div class="col-sm-8">
                <input type="checkbox" id="input-secretpath"  class="form-control"  name="watermark_by_sitecreator_secretpath" <?php if(!empty($secretpath)) echo 'checked'; ?>>
              </div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_remove_trash_disable; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-remove_trash_disable"  class="form-control"  name="watermark_by_sitecreator_remove_trash_disable" <?php if(!empty($remove_trash_disable)) echo 'checked'; ?>>
                </div>

              </div>
              <div class="form-group">
                <label  class="col-sm-4 control-label"><?php echo $text_enable_market; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-enable_market"  class="form-control"  name="watermark_by_sitecreator_enable_market" <?php if(!empty($enable_market)) echo 'checked'; ?>>
                </div>
                <div style="height:15px; clear: both;"></div>
                <label class="col-sm-4 control-label"><?php echo $text_market_w_and_h; ?></label>
                <div class="col-sm-8">
                  <input   type="text" id="input-market_w" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_market_w" value="<?php echo $market_w; ?>">
                  <input   type="text" id="input-market_h" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_market_h" value="<?php echo $market_h; ?>">
                </div>
              </div>
              <div class="form-group">
                <label  class="col-sm-4 control-label"><?php echo $text_crop; ?></label>
                <div class="col-sm-8">
                  <select id="input-crop"  class="form-control"  name="watermark_by_sitecreator_crop_type">
                    <option value="" <?php if(empty($crop_type) || $crop_type == 'none') echo 'selected';  ?>>none - нет</option>
                    <option value="w" <?php if($crop_type == 'w') echo 'selected';  ?>>w - уместить по ширине (обрезать по высоте)</option>
                    <option value="h" <?php if($crop_type == 'h') echo 'selected';  ?>>h - уместить по высоте (обрезать по ширине)</option>
                    <option value="auto" <?php if($crop_type == 'auto') echo 'selected';  ?>>auto - автоматически выбрать сторону обрезки</option>
                    <option value="nocrop" <?php if($crop_type == 'nocrop') echo 'selected';  ?>>no crop - НЕ обрезать, БЕЗ полей (уместить по ширине, высота не ограничена)</option>
                  </select>

                </div>
              </div>

              <div class="form-group" style="background-color: #edf6ff;">
               <div  class="col-sm-4 header_stcrtr">Для ВСПЛЫВАЮЩЕГО изображения</div><div class="col-sm-8 header2_stcrtr"><?php echo "(<span style='font-size: 12px;'>theme size/ задано в шаблоне:</span> $image_popup_width x ". $image_popup_height.')'; ?></div>
              <div style="height:15px; clear: both;"></div>
              <label  class="col-sm-4 control-label"><?php echo $text_for_popup_img_noborder; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-for_popup_img_noborder"  class="form-control"  name="watermark_by_sitecreator_for_popup_img_noborder" <?php if(!empty($for_popup_img_noborder)) echo 'checked'; ?>>
                </div>
                <div style="height:15px; clear: both;"></div>
                <label  class="col-sm-4 control-label"><?php echo $text_for_popup_img_fit_to_width_nocrop; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-for_popup_img_fit_to_width_nocrop"  class="form-control"  name="watermark_by_sitecreator_for_popup_img_fit_to_width_nocrop" <?php if(!empty($for_popup_img_fit_to_width_nocrop)) echo 'checked'; ?>>
                </div>
              <div style="height:15px; clear: both;"></div>
              <label  class="col-sm-4 control-label"><?php echo $text_for_popup_img_no_max_fit; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-for_popup_img_no_max_fit"  class="form-control"  name="watermark_by_sitecreator_for_popup_img_no_max_fit" <?php if(!empty($for_popup_img_no_max_fit)) echo 'checked'; ?>>
                </div>
              <div style="height:15px; clear: both;"></div>
              <label  class="col-sm-4 control-label"><?php echo $text_for_popup_img_white_back; ?></label>
              <div class="col-sm-8">
                <input type="checkbox" id="input-for_popup_img_white_back"  class="form-control"  name="watermark_by_sitecreator_for_popup_img_white_back" <?php if(!empty($for_popup_img_white_back)) echo 'checked'; ?>>
              </div>
              </div>
          <div class="form-group" style="background-color: #defdff;">
            <div  class="col-sm-4 header_stcrtr">Для THUMBNAIL изображения</div><div class="col-sm-8 header2_stcrtr"><?php echo "(<span style='font-size: 12px;'>theme size/ задано в шаблоне:</span> $image_thumb_width x ". $image_thumb_height.')'; ?></div>
          <div style="height:15px; clear: both;"></div>
          <label  class="col-sm-4 control-label"><?php echo $text_for_thumb_img_noborder; ?></label>
          <div class="col-sm-8">
            <input type="checkbox" id="input-for_thumb_img_noborder"  class="form-control"  name="watermark_by_sitecreator_for_thumb_img_noborder" <?php if(!empty($for_thumb_img_noborder)) echo 'checked'; ?>>
          </div>
          <div style="height:15px; clear: both;"></div>
          <label  class="col-sm-4 control-label"><?php echo $text_for_thumb_img_fit_to_width_nocrop; ?></label>
          <div class="col-sm-8">
            <input type="checkbox" id="input-for_thumb_img_fit_to_width_nocrop"  class="form-control"  name="watermark_by_sitecreator_for_thumb_img_fit_to_width_nocrop" <?php if(!empty($for_thumb_img_fit_to_width_nocrop)) echo 'checked'; ?>>
          </div>
          <div style="height:15px; clear: both;"></div>
          <label  class="col-sm-4 control-label"><?php echo $text_for_thumb_img_no_max_fit; ?></label>
          <div class="col-sm-8">
            <input type="checkbox" id="input-for_thumb_img_no_max_fit"  class="form-control"  name="watermark_by_sitecreator_for_thumb_img_no_max_fit" <?php if(!empty($for_thumb_img_no_max_fit)) echo 'checked'; ?>>
          </div>
          <div style="height:15px; clear: both;"></div>
          <label  class="col-sm-4 control-label"><?php echo $text_for_thumb_img_white_back; ?></label>
          <div class="col-sm-8">
            <input type="checkbox" id="input-for_thumb_img_white_back"  class="form-control"  name="watermark_by_sitecreator_for_thumb_img_white_back" <?php if(!empty($for_thumb_img_white_back)) echo 'checked'; ?>>
          </div>
        </div>


        <div class="form-group">
          <div  class="col-sm-4 header_stcrtr">WATERMARK: настройки</div>
          <div class="col-sm-8 header2_stcrtr"><a class="toggle_block" id="watermark_group_click" href="#" onclick="return false;">
              <i class="fa fa-eye" aria-hidden="true"></i>&nbsp; Показать / скрыть параметры &nbsp;<i class="fa fa-eye-slash" aria-hidden="true"></i></a></div>
        <div style="height:15px; clear: both;"></div>

        <label class="col-sm-4 control-label" for="input-status"><?php echo $entry_status; ?></label>
        <div class="col-sm-8">
          <input type="checkbox" id="input-status"  class="form-control"  name="watermark_by_sitecreator_status" <?php if(!empty($status)) echo 'checked'; ?>>
          <input value="0" hidden name="noclose" id="noclose">
        </div>
      </div>
      <div style="height:15px; clear: both;"></div>

              <div id="watermark_group_before" class="form-group half_hidden">
                <label class="col-sm-4 control-label"><?php echo $text_img_min_width_nowatermark; ?></label>
                <div class="col-sm-8">
                  <input type="text" id="input-min_width" pattern="^[0-9]{1,6}$" class="form-control"  name="watermark_by_sitecreator_min_width" value="<?php echo $min_width; ?>">
                </div>
              </div>
        <div style="display: none;" id="watermark_group">
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_img_max_width_nowatermark; ?></label>
                <div class="col-sm-8">
                  <input type="text" id="input-max_width" pattern="^[0-9]{1,6}$" class="form-control"  name="watermark_by_sitecreator_max_width" value="<?php echo $max_width; ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_watermark_img; ?></label>
                <div class="col-sm-8" id="div-input-image"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                  <input type="hidden" name="watermark_by_sitecreator_image" value="<?php echo $image; ?>" id="input-image" />
                  <br><button onclick="loadTestImg();" title="Загрузить тестовое изображение для водяного знака" type="button" class="btn stcrtr_btn">load test-watermark</button>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_watermark_posx; ?></label>
                <div class="col-sm-8">
                  <input type="text" pattern="^[0-9]{1,3}$" class="form-control" name="watermark_by_sitecreator_posx" value="<?php echo $posx; ?>" id="input-posx" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_watermark_posy; ?></label>
                <div class="col-sm-8">
                  <input type="text" pattern="^[0-9]{1,3}$" class="form-control" name="watermark_by_sitecreator_posy" value="<?php echo $posy; ?>" id="input-posy" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_watermark_degree; ?></label>
                <div class="col-sm-8">
                  <input type="text" pattern="^[0-9]{1,3}$" class="form-control" name="watermark_by_sitecreator_degree" value="<?php echo $degree; ?>" id="input-degree" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_watermark_width; ?></label>
                <div class="col-sm-8">
                  <input type="text" pattern="^[0-9]{1,3}$" class="form-control" name="watermark_by_sitecreator_width" value="<?php echo $width; ?>" id="input-width" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_watermark_height; ?></label>
                <div class="col-sm-8">
                  <input type="text" pattern="^[0-9]{1,3}$" class="form-control" name="watermark_by_sitecreator_height" value="<?php echo $height; ?>" id="input-height" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_watermark_opacity; ?></label>
                <div class="col-sm-8">
                  <input type="text" pattern="^[0-9]{1,3}$" class="form-control" name="watermark_by_sitecreator_opacity" value="<?php echo $opacity; ?>" id="input-opacity" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-4 control-label"><?php echo $text_watermark_test; ?></label>
                <div class="col-sm-8">
                  <div style="width:252px; height:252px; position:relative; padding: 10px;"><?php echo $text_watermark_test_error; ?><a title="Кликните для увеличения" href="" style="position: absolute; top:0; left:0;" class="watermark-big-img" id="watermark-big-img"><img src="" style="width: 250px; height: 250px; border: solid 1px #eeeeee; padding: 1px" id="watermarkTestImg"></a></div><br>
                  <button title="Если при изменении параметров не обновилась картинка, то кликните" type="button" onclick="watermarkPreview(); return false;" class="btn btn-test" >Test</button>
                  <button type="button" title="Сброс настроек WATERMARK в оптимальное состояние" onclick="watermarkReset(); return false;" class="btn btn-test" >Reset WATERMARK settings</button>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-4 control-label"><?php echo $text_watermark_dirs; ?></div>
                <div class="col-sm-8">
                  <textarea class="form-control dirs" name="watermark_by_sitecreator_dirs" id="input-dirs"><?php
                    echo $dirs_implode;
                    ?></textarea>
                </div>
              </div>
              <div class="form-group" <?php if (empty($dirs_error)) echo 'style="display: none;"'; ?>>
                <label class="col-sm-4 control-label"><?php echo $text_watermark_dirs_error; ?></label>
                <div class="col-sm-8">
                  <textarea disabled="disabled" class="form-control dirs dirs_error"  id="dirs_error"><?php echo $dirs_error_implode; ?></textarea>
                </div>
              </div>
            </div>
              <div class="form-group <?php if(empty($lic_market)) echo 'market_lite'; else echo 'market_full' ?>">
                <div  class="col-sm-4 header_stcrtr header_color4">Параметры для экспорта в Яндекс-Маркет и т.п.</div><div class="col-sm-8 header2_stcrtr">
                  <a class="toggle_block" id="market_group_click" href="#" onclick="return false;">
                    <i class="fa fa-eye" aria-hidden="true"></i>&nbsp; Показать / скрыть параметры &nbsp;<i class="fa fa-eye-slash" aria-hidden="true"></i></a></div>
                <div style="height:5px; clear: both;"></div>
                <div class="lic_alert"><?php if(empty($lic_market)) echo 'Плагин работает в режиме <b style="color: red">"Lite"</b>.<b> Возможности ограничены.</b> Для активации ВСЕХ функций необходим ключ, приобретается отдельно.';
                  else echo 'Плагин АКТИВЕН (лицензия подтверждена)'; ?></div>
                <label  class="col-sm-4 control-label market_lite"><?php echo $text_market_img_quality; ?></label>
                <div class="col-sm-8">
                  <input style="border: 2px solid #0c942c; background: #e1f8e3; color: #000" type="text" id="input-market_quality" pattern="^[0-9]{1,3}$" class="form-control" name="watermark_by_sitecreator_market_quality" value="<?php echo $market_quality; ?>">
                  <br></div>
                <div style="height:0px; clear: both;"></div>
                <div id="market_group_before" class="my-form-group">
                <label  class="col-sm-4 control-label market_lite"><?php echo $text_market_watermark_enable; ?></label>
                <div class="col-sm-8">
                  <input type="checkbox" id="input-market_watermark_enable"  class="form-control"  name="watermark_by_sitecreator_market_watermark_enable" <?php if(!empty($market_watermark_enable)) echo 'checked'; ?>>
                </div>
                </div>
                <div id="market_group">
                  <div class="form-group my-form-group">
                    <label  class="col-sm-4 control-label"><?php echo $text_market_override_image_size; ?></label>
                    <div class="col-sm-8">
                      <input type="checkbox" id="input-market_override_image_size"  class="form-control"  name="watermark_by_sitecreator_market_override_image_size" <?php if(!empty($market_override_image_size)) echo 'checked'; ?>>
                    </div>
                    <div style="height:15px; clear: both;"></div>
                    <label class="col-sm-4 control-label"><?php echo $text_market_set_image_size; ?></label>
                    <div class="col-sm-8">
                      <input   type="text" id="input-market_image_w" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_market_image_w" value="<?php echo $market_image_w; ?>">
                      <input   type="text" id="input-market_image__h" pattern="^[0-9]{1,4}$" class="form-control"  name="watermark_by_sitecreator_market_image_h" value="<?php echo $market_image_h; ?>">
                    </div>
                  </div>
                  <div class="form-group my-form-group">
                <label  class="col-sm-4 control-label"><?php echo $text_market_image_generate_disable; ?></label>
                <div class="col-sm-8">
                  <input title="ЗАРЕЗЕРВИРОВАНО ДЛЯ СЛЕДУЮЩЕЙ ВЕРСИИ" disabled="disabled" type="checkbox" id="input-market_image_generate_disable"  class="form-control"  name="watermark_by_sitecreator_market_image_generate_disable" <?php if(!empty($market_image_generate_disable)) echo 'checked'; ?>>
                </div>
                  </div>
                  <div class="form-group my-form-group" style="border-bottom:0;">
                    <label  class="col-sm-4 control-label"><?php echo $text_market_stickers_enable; ?></label>
                    <div class="col-sm-8">
                      <input type="checkbox" id="input-market_stickers_enable"  class="form-control"  name="watermark_by_sitecreator_market_stickers_enable" <?php if(!empty($market_stickers_enable)) echo 'checked'; ?>>
                    </div>
                  </div>
                  <div class="form-group my-form-group">
                    <label  class="col-sm-4 control-label"><?php echo $text_market_stickers_source_text; ?></label>
                    <div class="col-sm-8">
                      <select id="input-ind_for_market_text"  class="form-control"  name="watermark_by_sitecreator_ind_for_market_text">
                        <option value='upc' <?php if(empty($ind_for_market_text) || $ind_for_market_text == 'upc') echo 'selected';  ?>>upc</option>
                        <option value='ean' <?php if(!empty($ind_for_market_text) && $ind_for_market_text == 'ean') echo 'selected';  ?>>ean</option>
                        <option value='jan' <?php if(!empty($ind_for_market_text) && $ind_for_market_text == 'jan') echo 'selected';  ?>>jan</option>
                        <option value='isbn' <?php if(!empty($ind_for_market_text) && $ind_for_market_text == 'isbn') echo 'selected';  ?>>isbn</option>
                        <option value='mpn' <?php if(!empty($ind_for_market_text) && $ind_for_market_text == 'mpn') echo 'selected';  ?>>mpn</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group my-form-group  my_last"><div class="col-sm-12"><div class="ya_market_desc"><?php echo $text_ya_market_desc; ?></div>
                    </div>
                  </div>
              </div>
              </div>
            </form>
            <div class="infoplus">
              <?php echo $text_warning; ?>
            </div>
          </div>
          <div class="panel-body tab-pane" id="tab-service">
            <div class="form-group">
              <label class="col-sm-12 control-label"><?php echo $text_img_info; ?><br><br>
              </label>
              <div id="soft_info" class="col-sm-12" style="min-height: 230px; border: 1px solid #ebebeb; padding: 10px 15px;">
                <?php echo $soft_info; ?>
              </div>
            </div>
            <div style="clear:both;  padding-bottom:15px;"></div>
            <div id="browser_info" class="col-sm-12" style=" border: 1px solid #ebebeb; padding: 10px 15px;"></div>
            <div style="clear:both; border-bottom:1px solid #e8e8e8; padding-bottom:15px; margin-bottom:15px;"></div>

            <div class="col-sm-4" style="min-width: 270px; padding-left:0;"><br>
              <label class="control-label"><?php echo $text_info_os_extra; ?></label>
              <div class="">
                <button id="lic_activate" type="button" class="btn  stcrtr_btn btn-typeLic" data-type="lic_activate" title="Активировать лицензию / Activate license">Активировать лиц. / Activate license</button><br>

                <button id="site_path" type="button" class="btn  stcrtr_btn btn-type2" data-type="site_path"> UNIX home dir &nbsp;&nbsp;&nbsp;<i class="fa fa-user" aria-hidden="true" style="margin-right: 3px;"></i> name</button><br>
                <button id="phpinfo" type="button" class="btn  stcrtr_btn btn-type2" data-type="phpinfo"><i class="fa fa-info" aria-hidden="true"></i> php info</button><br>

                <button id="info_os" type="button" class="btn  stcrtr_btn btn-type2" data-type="info_os"><i class="fa fa-linux" aria-hidden="true"></i> <?php echo $text_info_os; ?></button><br>
                <button id="info_memcache" type="button" class="btn  stcrtr_btn btn-type2" data-type="info_memcache"><i class="fa fa-key" aria-hidden="true"></i> <?php echo $text_info_memcache; ?></button><br>
                <button id="info_ocmod" type="button" class="btn  stcrtr_btn btn-type2" data-type="info_ocmod" title="Модифицирет ли OCMOD файлы модуля? Перечислены модифицированные файлы."><i class="fa fa-file-code-o" aria-hidden="true"></i> <?php echo $text_info_ocmod; ?></button><br>
              </div>
              <br>
              <label class="control-label"><?php echo $text_block_on_off_module; ?></label>
              <div class="">
                <button id="on_off_module" type="button" class="<?php echo $btn_onoff_css; ?>" data-type="on_off_module" title=""><?php echo $btn_onoff_content; ?></button><br>
                <button id="on_off_adminbar" type="button" class="<?php echo $btn_onoff_adminbar_css; ?>" data-type="on_off_adminbar" title=""><?php echo $btn_onoff_adminbar_content; ?></button><br>

              </div>
              <br>
              <label class="control-label"><?php echo $text_block_on_off_ocmod_market; ?></label>
              <div class="">
                <button id="on_off_ocmod_market1" type="button" class="<?php echo $btn_onoff_ocmod_market1_css; ?>" data-type="on_off_ocmod_market1" title=""><?php echo $btn_on_off_ocmod_market1_content; ?></button><br>
                <button id="on_off_ocmod_market2" type="button" class="<?php echo $btn_onoff_ocmod_market2_css; ?>" data-type="on_off_ocmod_market2" title=""><?php echo $btn_on_off_ocmod_market2_content; ?></button><br>

              </div>

    </div>
            <div class="col-sm-4" style="min-width: 270px; padding-left:0;"><br>
              <label class="control-label"><?php echo $text_clear_cache; ?></label>
              <div class="">
                <button id="clear_ocmod" type="button" class="btn  stcrtr_btn btn-type2" data-type="ocmod" title="Обновить кеш модификаторов (кеш ocmod)"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo $text_clear_ocmod; ?></button><br>

                <button id="clear_img_no_mozjpeg_cache" type="button" class="btn  stcrtr_btn btn-type2" data-type="no_mozjpeg_image" title="Удалить файлы для тестирования: _no_mozjpeg_, _no_optipng_"><i class="fa fa-file-image-o"></i> <?php echo $text_clear_img_no_mozjpeg_cache; ?></button><br>
                <button id="clear_img_cache" type="button" class="btn btn-danger stcrtr_btn btn-type2" data-type="image" title="Удалить ВСЕ изображения из кеша КРОМЕ для маркета">
                  <i class="fa fa-file-image-o"></i> <?php echo $text_clear_img_cache; ?></button><br>
                <button id="clear_img_webp" type="button" class="btn btn-danger stcrtr_btn btn-type3" data-type="webp" title="Удалить ВСЕ WebP изображения из кеша">
                  <i class="fa fa-file-image-o"></i> WEBP</button><br>
                <button id="clear_img_market_cache" type="button" class="btn btn-danger stcrtr_btn btn-type2" data-type="market_image" title="Удалить только изображения для Яндекс-Маркета (из отдельной папки кеша DIR_IMAGE.'market_cache')">
                  <i class="fa fa-file-image-o"></i> <?php echo $text_clear_img_market_cache; ?></button><br>

                <button id="clear_system_cache" type="button" class="btn btn-danger stcrtr_btn btn-type2" data-type="system"><i class="fa fa-code"></i> <?php echo $text_clear_system_cache; ?></button><br>
                <button id="clear_turbocache" type="button" class="btn btn-danger stcrtr_btn btn-type2" data-type="turbo"><i class="fa fa-code"></i> <?php echo $text_clear_turbocache; ?></button><br>


                <button id="clear_memcache" type="button" class="btn btn-danger stcrtr_btn btn-type2" data-type="memcache"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo $text_clear_memcache; ?></button><br>
                <button id="clear_all_memcache" type="button" class="btn btn-danger stcrtr_btn btn-type3" data-type="all_memcache"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo $text_clear_all_memcache; ?></button><br><br>

              </div>
            </div>
            <div class="col-sm-4" style="min-width: 270px; padding-left:0;"><br>

              <div style="padding-bottom: 25px;" class="">
                <button id="start_soft_test" type="button" class="btn  stcrtr_btn btn-type2" data-type="start_soft_test" title="Test"><i class="fa fa-plug" aria-hidden="true"></i> Soft Test & Info</button><br><br>
                <label class="control-label"><?php echo $text_extra_soft; ?></label><br>
                <button id="soft_link" type="button" class="btn  stcrtr_btn btn-type2" data-type="soft_link"><i class="fa fa-link" aria-hidden="true"></i> INFO: soft config & links</button><br>
                <button id="soft_link_del" type="button" class="btn btn-danger  stcrtr_btn btn-type2" data-type="soft_link_del" title="Удалить символьные ссылки на mozjpeg, optipng."><i class="fa fa-chain-broken" aria-hidden="true"></i> DELETE soft links</button><br><br>
                <label class="control-label"><?php echo $text_extra_soft_install; ?></label>
                <select disabled="disabled" id="soft_destination" class="form-control" style="max-width: 250px;" onchange="change_destination(this.value);" title="destination: cgi-bin OR Unix User Home Dir">
                  <option selected="selected" value="cgi-bin">cgi-bin</option>

                </select>
                <button id="mozjpeg_install" type="button" class="btn  stcrtr_btn btn-type4" data-type="mozjpeg_install" data-destination="cgi-bin" title="Установить софт в директорию"><i class="fa fa-magic" aria-hidden="true"></i> install MozJPEG (cgi-bin)</button><br>
                <button id="optipng_install" type="button" class="btn  stcrtr_btn btn-type4" data-type="optipng_install" data-destination="cgi-bin" title="Установить софт в директорию"><i class="fa fa-magic" aria-hidden="true"></i> install OptiPNG (cgi-bin)</button><br>
                <button id="webp_install" type="button" class="btn  stcrtr_btn btn-type4" data-type="webp_install" data-destination="cgi-bin" title="Установить софт в директорию"><i class="fa fa-magic" aria-hidden="true"></i> install WebP soft (cgi-bin)</button><br>

                <button id="del_mozjpeg" type="button" class="btn btn-danger  stcrtr_btn btn-type2" data-type="del_mozjpeg" data-destination="cgi-bin" title="Удалить MozJPEG."><i class="fa fa-times" aria-hidden="true"></i> DELETE MozJPEG (cgi-bin)</button><br>
                <button id="del_optipng" type="button" class="btn btn-danger  stcrtr_btn btn-type2" data-type="del_optipng" data-destination="cgi-bin" title="Удалить OptiPNG."><i class="fa fa-times" aria-hidden="true"></i> DELETE OptiPNG (cgi-bin)</button><br><br>

              </div>

            </div>
            <div style="clear:both;">
              <button onclick="$('#service_result').text('');" id="clear_textarea" type="button" class="btn  stcrtr_btn btn-type2" data-type="clear_textarea" title="Очистить окно вывода" style="min-width: 30px; text-align:center;"><i class="fa fa-eraser" aria-hidden="true"></i></button><br>

              <textarea style="height: 500px;" class="form-control dirs" id="service_result" readonly="readonly">info out</textarea>
              <button onclick="$('#service_result').text('');" id="clear_textarea" type="button" class="btn  stcrtr_btn btn-type2" data-type="clear_textarea" title="Очистить окно вывода" style="min-width: 30px; text-align:center;"><i class="fa fa-eraser" aria-hidden="true"></i></button><br>

            </div>
            <div style="clear:both;"><?php echo $text_warning; ?></div>
          </div>
          <div class="panel-body tab-pane" id="tab-theme">
            <label class="control-label" style="padding-right:25px;"><?php echo $text_compress_theme_jpeg_quality; ?></label><br>
            <input pattern="^[0-9]{1,3}$" class="form-control" type="text" name="theme_jpeg_quality" id="theme_jpeg_quality" value="80" style="max-width: 110px;"><br><br>
            <label class="control-label" style="padding-right:25px;"><?php echo $text_compress_theme_optipng_level; ?></label><br>

              <select id="theme_optipng_level"  class="form-control"  name="theme_optipng_level">
                <option value=1 <?php if(empty($optipng_level) || $optipng_level == 1) echo 'selected';  ?>>1</option>
                <option value=2 <?php if($optipng_level == 2) echo 'selected';  ?>>2</option>
                <option value=3 <?php if($optipng_level == 3) echo 'selected';  ?>>3</option>
                <option value=4 <?php if($optipng_level == 4) echo 'selected';  ?>>4</option>
                <option value=5 <?php if($optipng_level == 5) echo 'selected';  ?>>5</option>
              </select>

            <div style="height:15px; clear: both;"></div>
            <label class="control-label" style="padding-right:25px;"><?php echo $text_dir_for_compress; ?></label><br>
            <select class="form-control" id="dir_for_compress" name="dir_for_compress">
              <option value="theme" selected="selected">catalog/view/theme</option>
              <option value="javascript">catalog/view/javascript</option>
            </select><br><br>
            <label class="control-label" style="padding-right:25px;"><?php echo $text_compress_theme; ?></label><br>
            <button style="margin-top:0;" id="compress_theme" type="button" class="btn  stcrtr_btn btn-type2" data-type="">Compress</button><br>
            <label class="control-label" style="padding-right:25px;"><?php echo $text_compress_logo; ?></label><br>
            <button style="margin-top:0;" id="compress_logo" type="button" class="btn  stcrtr_btn btn-type2" data-type="">Compress LOGO</button><br><br>


            <label class="control-label" style=" padding-right:25px;"><?php echo $text_undu_compress_theme; ?></label><br>
            <button style="margin-top:0;" id="undu_compress_theme" type="button" class="btn  stcrtr_btn btn-type2" data-type="">Undu</button><br>
            <label class="control-label" style=" padding-right:25px;"><?php echo $text_undu_compress_logo; ?></label><br>
            <button style="margin-top:0;" id="undu_compress_logo" type="button" class="btn  stcrtr_btn btn-type2" data-type="">Undu 'Compress LOGO'</button><br><br>

            <label class="control-label" style="padding-right:25px;"><?php echo $text_del_copies_of_images; ?></label><br>
            <button style="margin-top:0;" id="del_copies_of_images" type="button" class="btn btn-danger stcrtr_btn btn-type2" data-type="del_copies_of_images">DELETE copies of images</button><br>
            <div id="compress_theme_info"></div>

          </div>
          <div class="panel-body tab-pane" id="tab-help"><?php echo $text_watermark_infoplus; ?></div>
        </div>
        <div class="scr_opyright"><?php echo $text_module_copyright; ?></div>

      </div>
    </div>
  </div>

<script>

  function globalPars() {
    var ini_alert = '<?php echo $ini_alert; ?>';
    var lic_activate = '<?php echo $lic_activate; ?>';
    var activated_test = '<?php echo $activated_test; ?>';
    var preview = '<?php echo $preview; ?>';
    var load_test_img = '<?php echo $load_test_img; ?>';
    var modification_refresh_permission = '<?php echo $modification_refresh_permission; ?>';
    var error_permission = '<?php echo $error_permission; ?>';
    var get_phpinfo = '<?php echo $get_phpinfo; ?>';
    var get_info_os_extra = '<?php echo $get_info_os_extra; ?>';
    var clear_ocmod = '<?php echo $clear_ocmod; ?>';
    var on_off_module = '<?php echo $on_off_module; ?>';
    var text_clear_ocmod_success = '<?php echo $text_clear_ocmod_success; ?>';
    var text_confirm_clear_all_memcache = '<?php echo $text_confirm_clear_all_memcache; ?>';
    var clear_cache = '<?php echo $clear_cache; ?>';
    var del_copies_of_images = '<?php echo $del_copies_of_images; ?>';
    var compress_logo = '<?php echo $compress_logo; ?>';
    var undu_compress_logo = '<?php echo $undu_compress_logo; ?>';
    var compress_theme = '<?php echo $compress_theme; ?>';
    var start_soft_test = '<?php echo $start_soft_test; ?>';
    var soft_extra = '<?php echo $soft_extra; ?>';
    var undu_compress_theme = '<?php echo $undu_compress_theme; ?>';

    return {
      lic_activate: lic_activate,
      activated_test: activated_test,
      preview: preview,
      load_test_img: load_test_img,
      modification_refresh_permission: modification_refresh_permission,
      error_permission: error_permission,
      get_phpinfo: get_phpinfo,
      get_info_os_extra: get_info_os_extra,
      clear_ocmod: clear_ocmod,
      on_off_module: on_off_module,
      text_clear_ocmod_success: text_clear_ocmod_success,
      text_confirm_clear_all_memcache: text_confirm_clear_all_memcache,
      clear_cache: clear_cache,
      del_copies_of_images: del_copies_of_images,
      compress_logo: compress_logo,
      undu_compress_logo: undu_compress_logo,
      compress_theme: compress_theme,
      start_soft_test: start_soft_test,
      soft_extra: soft_extra,
      undu_compress_theme: undu_compress_theme,
      ini_alert: ini_alert
    };
  }


  $(document).ready(function() {
    var lic_activated = <?php echo $lic_activated; ?>;
    var info = '<?php echo $lic_info; ?>';
    info += '<?php echo $ini_alert; ?>';
    if (!lic_activated) {
      $('#form-watermark_by_sitecreator').css('display', 'none');
      if(info != '') $('#tab-main').prepend(info);
      $("button[id!='lic_activate'][type!='submit']").prop('disabled', true);

    }
    else {
      $('#lic_activate').prop('disabled', true).text('Лицензия АКТИВИРОВАНА');
    }

    // тест браузера на webp
    (function() {
      var img = new Image();
      img.onload = function() {
        var hasWebP = !!(img.height > 0 && img.width > 0);
        if(hasWebP) {
          $("#browser_info").html("<div class=\"ok\"><span>Ваш браузер поддерживает WebP. </span> Your browser supports WebP.</div>");
        }
      };
      img.onerror = function() {
        var hasWebP = false;
        var text = "<div class=\"notice\">Ваш браузер, вероятно, НЕ поддерживает WebP.  Your browser probably does NOT support WebP.</div>";
        text += "Но без изображения не останется ни один браузер! / But without the image there will be no browser!";
        $("#browser_info").html(text);
      };
      img.src = "data:image/webp;base64,UklGRo4AAABXRUJQVlA4IIIAAADwAwCdASoUABQAPlEijUSjoiEYDAQAOAUEsoAAFzxHy8dzl714CKfwAP7+" +
        "2A9p/6ap3t7PF9R+ChO5JI6wc+BAYqPqf2pU9o1v/BSpsSPe++BIN2d4Zo8JaPWiX8U6r4z9l+Z9kDbl/6S7GfCR1F54o05F+GSpeivOJzP0NXIUAAAA";
    })();

  });


</script>

<?php echo $footer; ?>