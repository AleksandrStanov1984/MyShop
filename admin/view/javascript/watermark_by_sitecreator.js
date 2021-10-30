/*
sitecreator.ru (c) 2017-2018


 */

// глобальная
var CookiesStcrtr = false;

function change_destination(val) {
  var destination;
  if (val == 'cgi-bin') destination = 'cgi-bin';
  else destination = 'home';

  $('#mozjpeg_install').html('<i class="fa fa-magic" aria-hidden="true"></i> install MozJPEG (' + destination + ')').data('destination', destination);
  $('#optipng_install').html('<i class="fa fa-magic" aria-hidden="true"></i> install OptiPNG (' + destination + ')').data('destination', destination);
  $('#del_mozjpeg').html('<i class="fa fa-times" aria-hidden="true"></i> DELETE MozJPEG (' + destination + ')').data('destination', destination);
  $('#del_optipng').html('<i class="fa fa-times" aria-hidden="true"></i> DELETE OptiPNG (' + destination + ')').data('destination', destination);
}

function watermarkInputValidate() {
//    var watermarkImage = parseInt($('#input-image').val());
  var x = parseInt($('#input-posx').val());
  var y = parseInt($('#input-posy').val());
  var d = parseInt($('#input-degree').val());
  var w = parseInt($('#input-width').val());
  var h = parseInt($('#input-height').val());
  var o = parseInt($('#input-opacity').val());


  if (isNaN(x) || x < 0) x=0;
  if (x > 100) x=100;
  if (isNaN(y) || y < 0) y=0;
  if (y > 100) y=100;

  if (isNaN(d) || d < 0)  d=0;
  if (d > 360) d = 0;
  if (isNaN(w) || w < 0 || w > 100) w=100;


  if (isNaN(h) || h < 0 || h > 100) h=100;

  if (isNaN(o) || o < 0 || o > 100) o=100;


  $('#input-posx').val(x);
  $('#input-posy').val(y);
  $('#input-degree').val(d);
  $('#input-width').val(w);
  $('#input-height').val(h);
  $('#input-opacity').val(o);
}

function watermarkReset() {
  $('#input-posx').val(50);
  $('#input-posy').val(50);
  $('#input-degree').val(0);
  $('#input-width').val(80);
  $('#input-height').val(80);
  $('#input-opacity').val(100);
  watermarkInputValidate();
  watermarkPreview();
}


function wait_start(me) {
  me.prop('disabled', true);
  var wait = me.find('.wait_');
  if(!wait.length) me.append( '<span class="wait_"></span>' );
  else wait.css('display', 'block')
}
function wait_stop(me) {
  //return;
  me.prop('disabled', false);
  me.find('.wait_').css('display', 'none');
}
function error_permission(error) {
  var danger = $('.alert.alert-danger');
  if(!danger.length) $('.panel.panel-default').before('<div class="alert alert-danger" style="display: none;"><i class="fa fa-exclamation-circle"></i> ' + error + '</div>');
  else danger.html('<i class="fa fa-exclamation-circle"></i> ' + error);
  $('.alert-danger').slideDown().delay(2000).slideUp();
}


function watermarkPreview() {

  var dt = new Date();
  var ver = dt.getTime();
  var p = globalPars();
  var preview = p.preview;

  var watermarkImage = $('#input-image').val();
  var x = parseInt($('#input-posx').val());
  var y = parseInt($('#input-posy').val());
  var d = parseInt($('#input-degree').val());
  var w = parseInt($('#input-width').val());
  var h = parseInt($('#input-height').val());
  var o = parseInt($('#input-opacity').val());

  if (isNaN(x) || x < 0 || x > 100) x=0;
  if (isNaN(y) || y < 0 || y > 100) y=0;
  if (isNaN(d) || d < 0 || d > 360)  d=0;
  if (isNaN(w) || w < 0 || w > 100) w=100;
  if (isNaN(h) || h < 0 || h > 100) h=100;
  if (isNaN(o) || o < 0 || o > 100) o=100;

  var src = preview + '&image=' + watermarkImage + '&posX='
    + x + '&posY=' + y + '&degree=' + d
    + '&width=' + w + '&height=' + h + '&opacity=' + o + '&ver=' + ver;

  var src2 = preview + '&image=' + watermarkImage + '&posX='
    + x + '&posY=' + y + '&degree=' + d
    + '&width=' + w + '&height=' + h + '&opacity=' + o + '&ver=' + '&big=1' + ver;


  $('#watermarkTestImg').attr('src', src);
  $('#watermark-big-img').attr('href', src2);

}


function loadTestImg() {
  $('#input-image').val('sitecreator/watermark_by_sitecreator.png');

  var dt = new Date();
  var ver = dt.getTime();
  var p = globalPars();
  var load_test_img = p.load_test_img;

  var src = load_test_img  + '&ver=' + ver;
  $('#thumb-image > img').attr('src', src);
  watermarkInputValidate();
  watermarkPreview();

}




$(document).ready(function() {
  document.title = 'Image Compressor & Watermark by Sitecreator';

  $("input[id^='input-']").on('change', function (e) {
    watermarkInputValidate();
    watermarkPreview();
  });
  $("input[id^='input-']").on('input', function (e) {
//      watermarkInputValidate();
    watermarkPreview();
  });

  $("input[id^='input-']").css('max-width', '110px');

  // выбираем целевой элемент
  var target = document.getElementById('input-image');

  // создаем экземпляр наблюдателя
  var observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
//        console.log(mutation.type);
      watermarkPreview();
    });
  });

// настраиваем наблюдатель
  var config = { attributes: true, childList: false, characterData: false };

// передаем элемент и настройки в наблюдатель
  observer.observe(target, config);

  watermarkPreview();


  // добавить кнопки
  $('#input-posx, #input-posy, #input-degree, #input-width, #input-height, #input-opacity').after('<button type="button" class="btn minus">-</button><button type="button" class="btn plus">+</button>');
//    $("input[id^='input-'][id!='input-image'][id!='input-quality'][id!='input-min_width'][id!='input-max_width'][id!='input-dirs'][id!='input-test_compressing'][id!='input-webp_enable_jpeg'][id!='input-webp_enable_png']").after('<button type="button" class="btn minus">-</button><button type="button" class="btn plus">+</button>');
  $('.btn.minus').on('click', function () {
    var input = $(this).siblings('input');

    watermarkInputValidate();
    input.val(parseInt(input.val()) - 5);
    watermarkInputValidate();
    watermarkPreview();

  });
  $('.btn.plus').on('click', function () {
    var input = $(this).siblings('input');

    watermarkInputValidate();
    input.val(parseInt(input.val()) + 5);
    watermarkInputValidate();
    watermarkPreview();

  });


  $('#watermark-big-img').magnificPopup({
    type: 'image'
    // other options
  });


  $('#info_memcache').on('click', function() {
    var me = $(this);
    var get_info_os_extra = globalPars().get_info_os_extra;

      $.ajax({
      url: get_info_os_extra + '&type=' + $(this).data('type'),
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      },
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) {
          var service_result = $('#service_result');
          service_result.text(service_result.text() + '\n' + json['success']);
          service_result.scrollTop(service_result.prop('scrollHeight'));
        }
        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });


  $('#on_off_module, #on_off_adminbar, #on_off_ocmod_market1, #on_off_ocmod_market2').on('click', function() {
    var me = $(this);
    var p = globalPars();
    var get_info_os_extra = p.get_info_os_extra;
    var text_clear_ocmod_success = p.text_clear_ocmod_success;


    $.ajax({
      url: p.on_off_module + '&type=' + $(this).data('type'),
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      },
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) {
          var service_result = $('#service_result');
          service_result.text(service_result.text() + '\n' + json['success']);
          service_result.scrollTop(service_result.prop('scrollHeight'));
          if(json['btn_content'] && json['btn_id']) {
            var btn = $('#' + json['btn_id']);
            btn.html(json['btn_content']);
            if(json['btn_css']) {
              if(json['btn_css'] == 'on') btn.removeClass().addClass('btn  stcrtr_btn btn-type4');
              if(json['btn_css'] == 'off') btn.removeClass().addClass('btn btn-danger  stcrtr_btn btn-type2');
            }
          }
        }


        console.log('start clear_ocmod'); // не убирать этот код. он важен для правильной последовательности

        $.ajax({
          url: p.clear_ocmod,
          dataType: 'html',
          beforeSend: function() {
            wait_start(me);
            wait_start($('#clear_ocmod'));
          },
          success: function(content) {
            if (content) {


              var permission_error = p.modification_refresh_permission;
              if(permission_error != '') { //error
                var danger = $('.alert.alert-danger');
                if(!danger.length) $('.panel.panel-default').before('<div class="alert alert-danger" style="display: none;"><i class="fa fa-exclamation-circle"></i> ' + p.error_permission + '</div>');
                else danger.html('<i class="fa fa-exclamation-circle"></i> ' + p.error_permission);
                $('.alert-danger').slideDown().delay(2000).slideUp();
              } else {
                var service_result = $('#service_result');
                service_result.text(service_result.text() + '\n' + text_clear_ocmod_success);
                service_result.scrollTop(service_result.prop('scrollHeight'));
              }
            }
            wait_stop(me);
            wait_stop($('#clear_ocmod'));
          },
          error: function(content) {
            var service_result = $('#service_result');
            service_result.text(service_result.text() + '\n' + text_clear_ocmod_success);
            service_result.scrollTop(service_result.prop('scrollHeight'));
            wait_stop(me);
            wait_stop($('#clear_ocmod'));
          }
        });
        return false;
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });


  });


  $('#clear_ocmod').on('click', function() {
    var me = $(this);
    var p = globalPars();
    var get_info_os_extra = p.get_info_os_extra;
    var text_clear_ocmod_success = p.text_clear_ocmod_success;

    $.ajax({
      url: p.clear_ocmod,
      dataType: 'html',
      beforeSend: function() {
        wait_start(me);
      },
      success: function(content) {
        if (content) {


          var permission_error = p.modification_refresh_permission;
          if(permission_error != '') { //error
            var danger = $('.alert.alert-danger');
            if(!danger.length) $('.panel.panel-default').before('<div class="alert alert-danger" style="display: none;"><i class="fa fa-exclamation-circle"></i> ' + p.error_permission + '</div>');
            else danger.html('<i class="fa fa-exclamation-circle"></i> ' + p.error_permission);
            $('.alert-danger').slideDown().delay(2000).slideUp();
          } else {
            var service_result = $('#service_result');
            service_result.text(service_result.text() + '\n' + text_clear_ocmod_success);
            service_result.scrollTop(service_result.prop('scrollHeight'));
          }
        }
        wait_stop(me);
      },
      error: function(content) {
        var service_result = $('#service_result');
        service_result.text(service_result.text() + '\n' + text_clear_ocmod_success);
        service_result.scrollTop(service_result.prop('scrollHeight'));
        wait_stop(me);
      }
    });
    return false;
  });


  $('#clear_img_cache, #clear_img_webp, #clear_img_market_cache, #clear_img_no_mozjpeg_cache, #clear_system_cache, #clear_memcache, #clear_all_memcache, #clear_turbocache').on('click', function() {
    var me = $(this);
    var type = $(this).data('type');
    var p = globalPars();
    var text_confirm_clear_all_memcache = p.text_confirm_clear_all_memcache;
    var text_confirm_clear_all_memcache = p.text_confirm_clear_all_memcache;
    if( type == 'all_memcache') {
      if(!confirm(text_confirm_clear_all_memcache)) return;
    }
    $.ajax({
      url: p.clear_cache + '&type=' + type,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      },
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) {
          var service_result = $('#service_result');
          service_result.text(service_result.text() + '\n' + json['success']);
          service_result.scrollTop(service_result.prop('scrollHeight'));
        }
        wait_stop($(me));
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop($(me));
      }
    });
  });


  $('#start_soft_test, #del_mozjpeg, #del_optipng').on('click', function() {
    var me = $(this);
    var p = globalPars();
    var info_type = me.data('type');
    var destination = me.data('destination');
    var soft_info = $('#soft_info');

    if(info_type == 'del_mozjpeg' || info_type == 'del_optipng') {
      if(!confirm("Are you sure? \n Вы уверены?")) return;
    }

    $.ajax({
      url: p.start_soft_test + '&type=' + info_type + '&destination=' + destination,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      },
      success: function(json) {
        if (json['error']) {
          error_permission(json['error']);
        }
        if (json['success']) {
          var service_result = $('#service_result');
          service_result.text(service_result.text() + '\n' + json['success']);
          service_result.scrollTop(service_result.prop('scrollHeight'));
        }
        if (json['info']) {
//            soft_info.css('backgroundColor', '#fff');
          soft_info.html(json['info']);
          soft_info.css('backgroundColor', '#f9f8c1');
          setTimeout (function(){
            $('#soft_info').css('backgroundColor', '#fff');
          }, 500);
        }
        wait_stop(me);
      },

      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });

  $('#soft_link_del, #mozjpeg_install, #optipng_install, #webp_install').on('click', function() {
    var me = $(this);
    var p = globalPars();
    var info_type = me.data('type');
    var destination = me.data('destination');
    var soft_info = $('#soft_info');

    var ini_alert = p.ini_alert.replace(/<\/?[^>]+>/g,'');

    if(ini_alert != '' && (info_type == 'mozjpeg_install' || info_type == 'optipng_install')) {
      alert(ini_alert);
      var service_result = $('#service_result');
      {
        service_result.text(service_result.text() + '\n' + ini_alert);
        service_result.scrollTop(service_result.prop('scrollHeight'));
      }
      return;
    }


    // $.ajax({
    //   url: p.activated_test,
    //   type: 'post',
    //   dataType: 'json',
    //   success: function(json) {
    //     if (json['error']) {
    //       error_permission(json['error']);
    //       return;
    //     }
    //     if (json['success']) {
    //
    //     }
    //   },
    //   error: function(xhr, ajaxOptions, thrownError) {
    //     alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    //   }
    // });

    $.ajax({
      url: p.soft_extra + '&type=' + info_type + '&destination=' + destination,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      },
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) {
          var service_result = $('#service_result');
          service_result.text(service_result.text() + '\n' + json['success']);
          service_result.scrollTop(service_result.prop('scrollHeight'));
        }
        if (json['info']) {
//            soft_info.css('backgroundColor', '#fff');
          soft_info.html(json['info']);
          soft_info.css('backgroundColor', '#f9f8c1');
          setTimeout (function(){
            $('#soft_info').css('backgroundColor', '#fff');
          }, 500);
        }
        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });



  $('#lic_activate').on('click', function() {
    var me = $(this);
    var p = globalPars();

    var ini_alert = p.ini_alert.replace(/<\/?[^>]+>/g,'');
    if(ini_alert != '') {
      alert(ini_alert);
      var service_result = $('#service_result');
      {
        service_result.text(service_result.text() + '\n' + ini_alert);
        service_result.scrollTop(service_result.prop('scrollHeight'));
      }

      return;
    }






    $.ajax({
      url: p.lic_activate + '&type=' + 'true',
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      },
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) {
          var service_result = $('#service_result');
           {
            service_result.text(service_result.text() + '\n' + json['success']);
            service_result.scrollTop(service_result.prop('scrollHeight'));
          }

        }
        wait_stop(me);
        if(json['lic'] == 'ok') {
          me.text('License is active.');
          me.prop('disabled', true);
          $('input#noclose').val(1);
          $('#form-watermark_by_sitecreator').submit();
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert("*** ОШИБКА!  ***  ERROR! ***\n\n" +
          "Установите  ПРАВА (\"разрешить просмотр\" и \"разрешить редактирование\") пользователю (\"группе пользователей\") для дополнений:\n" +
          "" +
          "Edit User Group. Edit 'Access Permission' and 'Modify Permission' for this Extensions:\n\n\n" +
          "extension/module/watermark_by_sitecreator \n" +
          "module/watermark_by_sitecreator \n\n" +
          "-------------------------------------------\n" +
          "Смотрите подробнее об ошибке в console.log. (Это в браузере в панели разработчика: Ctrl+Shift+K)\n" +
          "See more about the error in the console.log. (Ctrl+Shift+K)");
        console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });


  $('#phpinfo, #info_os, #site_path, #info_ocmod, #soft_link').on('click', function() {
    var me = $(this);
    var info_type = $(this).data('type');
    var p = globalPars();
      //console.log(p.get_phpinfo + '&type=' + info_type);

    $.ajax({
      url: p.get_phpinfo + '&type=' + info_type,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
      },
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) {
          var service_result = $('#service_result');
          if(info_type == 'phpinfo') {
            var pattern = /<td class="e">System <\/td><td class="v">(.+?)<\/td>/;
            var info_part = json['success'].match(pattern);
            if (info_part.length >= 2){
              var system = '# phpinfo: ' + info_part[1];
              service_result.text(service_result.text() + '\n' + system);
              service_result.scrollTop(service_result.prop('scrollHeight'));
            }

            var win_phpinfo = window.open('about:blank', 'win_phpinfo', '', false);
            if (win_phpinfo) {
              win_phpinfo.close();
              win_phpinfo = window.open('about:blank', 'win_phpinfo', '', false);
              win_phpinfo.document.write(json['success']);
              win_phpinfo.document.close();
              win_phpinfo.focus();
            } else {  // если браузер блокирует создание окна/вкладки
              if (!$('iframe').is('#phpinfo_frame')) {
                $('#service_result').after('<iframe id="phpinfo_frame" name="phpinfo_frame"  width="100%" height="600" align="left">===</iframe>');
              }

              window.frames.phpinfo_frame.document.write(json['success']);
              window.frames.phpinfo_frame.document.close();
              window.location.hash = '#phpinfo_frame';

            }



          } else if(info_type == 'info_os' || info_type == 'site_path'  || info_type == 'info_ocmod' || info_type == 'soft_link') {
            service_result.text(service_result.text() + '\n' + json['success']);
            service_result.scrollTop(service_result.prop('scrollHeight'));
          }

        }
        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });

  });



  $('#del_copies_of_images').on('click', function() {
    var me = $(this);
    var p = globalPars();

    $.ajax({
      url: p.del_copies_of_images,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
        $('#compress_theme_info').html('');

      } ,
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) $('#compress_theme_info').html(json['success']);
        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });

  $('#compress_logo').on('click', function() {
    var me = $(this);
    var p = globalPars();
    var theme_jpeg_quality = parseInt($('#theme_jpeg_quality').val());
    if (isNaN(theme_jpeg_quality) || theme_jpeg_quality < 1 || theme_jpeg_quality > 100) {
      alert("проверьте значение качества JPEG!\nРазрешено: 0...100");
      $('#theme_jpeg_quality').val(80);
      return;
    }
    $.ajax({
      url: p.compress_logo + '&theme_jpeg_quality=' + theme_jpeg_quality,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
        $('#compress_theme_info').html('');
      } ,
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) $('#compress_theme_info').html(json['success']);
        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });


  $('#undu_compress_theme').on('click', function() {
    var me = $(this);
    var p = globalPars();
    var dir_for_compress = $('#dir_for_compress').val();
    $.ajax({
      url: p.undu_compress_theme + '&dir=' + dir_for_compress,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
        $('#compress_theme_info').html('');
      } ,
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) $('#compress_theme_info').html(json['success']);
        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });

  $('#undu_compress_logo').on('click', function() {
    var me = $(this);
    var p = globalPars();

    $.ajax({
      url: p.undu_compress_logo,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
        $('#compress_theme_info').html('');
      } ,
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) $('#compress_theme_info').html(json['success']);
        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });


  $('#compress_theme').on('click', function() {
    var me = $(this);
    var p = globalPars();
    var theme_jpeg_quality = parseInt($('#theme_jpeg_quality').val());
    if (isNaN(theme_jpeg_quality) || theme_jpeg_quality < 1 || theme_jpeg_quality > 100) {
      alert("проверьте значение качества JPEG!\nРазрешено: 0...100");
      $('#theme_jpeg_quality').val(80);
      return;
    }
    var theme_optipng_level = parseInt($('#theme_optipng_level').val());
    var dir_for_compress = $('#dir_for_compress').val();
    $.ajax({
      url: p.compress_theme + '&theme_jpeg_quality=' + theme_jpeg_quality + '&theme_optipng_level=' + theme_optipng_level + '&dir=' + dir_for_compress,
      type: 'post',
      dataType: 'json',
      beforeSend: function() {
        wait_start(me);
        $('#compress_theme_info').html('');
      } ,
      success: function(json) {
        if (json['error']) error_permission(json['error']);
        if (json['success']) $('#compress_theme_info').html(json['success']);
        wait_stop(me);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        wait_stop(me);
      }
    });
  });

  // Кнопки "показать/скрыть"
  // У кнопки должен id="market_group_click"  для соответствующего блока id="market_group"
  // можут быть также блок id="market_group_before"

  $('.toggle_block').on('click', function () {
    console.log("развернуть/свернуть");
    var id = this.id.replace('_click', '');
    toggle_and_cookies('#' + id);
    return false; // не позволить переход по ссылке
  });


  // переключить элемент и сохранить состояние в куки
  function toggle_and_cookies(id) {
    // CookiesStcrtr - глобальная
    if (CookiesStcrtr !== undefined && CookiesStcrtr !== false ) {  // если есть куки-функционал
      if ($(id).is(':visible')) {
        CookiesStcrtr.set('sitecreator.compressor.' + id + '.disp', 'off', { expires: 30 });
      }
      else {
        CookiesStcrtr.set('sitecreator.compressor.' + id + '.disp', 'on', { expires: 30 });
      }
    }
    $(id + '_before').toggleClass('half_hidden half_hidden_false');
    $(id).toggle("slow", function() {
    });
  }

  // Получить куки для id элнмента, если нет кук, то установить в off (не показывать). И в соответствии с куками показать или нет.
  // id
  function get_cookies_disp(id) {
    var cookies = 'sitecreator.compressor.' + id + '.disp'; // имя куки
    var disp = CookiesStcrtr.get(cookies);  // значение куки on/off

    if (disp  === undefined) {
      CookiesStcrtr.set(cookies, 'off', { expires: 30 });// по умолчанию свернуто
      $(id).hide();
      $(id + '_before').removeClass('half_hidden_false').addClass('half_hidden');
    }
    else if (disp == 'on') {
      $(id + '_before').removeClass('half_hidden').addClass('half_hidden_false');
      $(id).fadeIn("slow");
    }
    else if (disp == 'off') {
      $(id).fadeOut("slow");
      $(id + '_before').removeClass('half_hidden_false').addClass('half_hidden');
    }
  }

  // получить куки для всех нужных элементов и применить действия к элементам согласно кукишам
  function get_cookies_disp_array() {
    // глобальная
    CookiesStcrtr = Cookies.noConflict(); // глобальная
    get_cookies_disp('#watermark_group');
    get_cookies_disp('#background_group');
    get_cookies_disp('#market_group');
  }

  // загружаем скрипт кукишей если еще не загружен
  if (typeof(Cookies) == 'undefined') {
    console.log("не загружен скрипт кукишей");
    $.getScript('../../../admin/view/javascript/sitecreator/js.cookie.js', function(){
      console.log('js.cookie.js loaded');
      // получить куки для всех нужных элементов и применить действия к элементам согласно кукишам
      get_cookies_disp_array();
    });
  }
  else {
    console.log("уже загружен скрипт кукишей");
    // получить куки для всех нужных элементов и применить действия к элементам согласно кукишам
    get_cookies_disp_array();
  }


  var text_plugin_limitation = "Ограничено. Необходимо приобрести лицензионный ключ для плагина";
  $('.plugin_disable input').attr('title', text_plugin_limitation);
  // маркет
  $("div.market_lite input[id!='input-market_quality'][id!='input-market_watermark_enable']").prop('disabled', true).attr('title', text_plugin_limitation);


});
