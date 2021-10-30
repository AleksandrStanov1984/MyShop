<script>
  // Админ Бар для работы с изображениями (c) 2018
  // разработчик - sitecreator.ru
  // права принадлежат sitecreator.ru
  // не разрешается распространение без разрешения автора (sitecreator.ru)

  // +++++++++++  sitecreator   ++++++++++

  $(window).load(function() {

    function wait_start_sitecreator(me) {
      me.prop('disabled', true);
      var wait = me.find('.wait_sitecreator');
      if(!wait.length) {
        $( '<span class="wait_sitecreator" style="' +
          'display: block;' +
          'position: absolute;' +
          'top:0;' +
          'left: 0;' +
          'width: 100%;' +
          'height: 100%;' +
          // крутилка (ожидание- картинка)
          'opacity: 0.3;"></span>' ).css('background', '  url("catalog/view/image/sitecreator/wait2.gif") no-repeat 50% 50%').appendTo(me);
      }
      else wait.css('display', 'block')
    }
    function wait_stop_sitecreator(me) {
      me.prop('disabled', false);
      me.find('.wait_sitecreator').css('display', 'none');
    }


    function load_script(src, callback) {
      var head = document.getElementsByTagName('head') [0];
      var script = document.createElement('script');
      script.type = 'text/javascript';
      script.src= src;
      script.onload   = callback;
      head.appendChild(script);
    }
    
    function load_script_imagesloaded() {
      if(typeof imagesLoaded == 'undefined') {  // скрипт еще никем не загружен ранее
        load_script('catalog/view/javascript/sitecreator/imagesloaded.pkgd.js', main_adminbar_sitecreator);
      }
      else if(typeof imagesLoaded == 'function') main_adminbar_sitecreator(); // скрипт УЖЕ был загружен ранее кем-то
    }


    function main_adminbar_sitecreator() {




      var CookiesStcrtr = Cookies.noConflict();

      function bar_position_sitecreator(bar, pos) {
        switch(pos) {
          case 'top':
            bar.css('top', 0).css('bottom', '').css('left', 0);
            break;
          case 'top2':
            bar.css('top', '60px').css('bottom', '').css('left', 0);
            break;
          case 'top3':
            bar.css('top', '120px').css('bottom', '').css('left', 0);
            break;
          case 'bottom':
            bar.css('top', '').css('bottom', 0).css('left', 0);
            break;
          case 'bottom2':
            bar.css('top', '').css('bottom', '60px').css('left', 0);
            break;
          case 'bottom3':
            bar.css('top', '').css('bottom', '120px').css('left', 0);
            break;
          default:
            bar.css('top', 0).css('bottom', '').css('left', 0);
        }
      }





      $.ajax({
        url: 'index.php?route=module/adminbar_by_sitecreator/isLogged',
        type: 'post',
        dataType: 'json',

        success: function(json) {
          if(json['isLogged']) {
            if (json['html'] && json['link']) {
              $('body').prepend(json['html']);
              // задание отображаемого положения в соответствии с куками
              var pos = CookiesStcrtr.get('sitecreator_bar_pos');
              var bar = $('#sitecreator_bar');
              bar.css('top', '').css('bottom', '');
              var celect_pos = $('#sitecreator_bar_sel_pos');
              celect_pos.css('background', '#fff');
              var celect_otions = {
                top: "top (верх)",
                top2: "top (верх) 2",
                top3: "top (верх) 3",
                bottom3: "bottom (низ) 3",
                bottom2: "bottom (низ) 2",
                bottom: "bottom (низ)"
              };
              // создадим эементы option в select
              for (var val in celect_otions) {
                celect_pos.append('<option value="'+ val +'">'+ celect_otions[val] +'</option>');
              }
              if(pos === undefined) {
                CookiesStcrtr.set('sitecreator_bar_pos', 'top', { expires: 30 });
              }
              else {
                bar_position_sitecreator(bar, pos);
                //Сделать выбранным элемент, value которого = pos
                var option_selected = "#sitecreator_bar_sel_pos [value='"+ pos +"']";
                $(option_selected).attr("selected", "selected");
              }
              celect_pos.on("change",
                function(){
                  var pos = $( "#sitecreator_bar_sel_pos option:selected" ).val();
                  var bar = $('#sitecreator_bar');
                  console.log(pos);
                  CookiesStcrtr.set('sitecreator_bar_pos', pos, { expires: 30 });
                  bar_position_sitecreator(bar, pos);

                });

              // checkbox "trim кеш очистить"
              var trim_cache_checkbox = $('#sitecreator_bar_trim_cache_clear'); // чекбокс
              var trim_cache_clear = CookiesStcrtr.get('sitecreator_bar_trim_cache_clear'); // значение куки
              if(trim_cache_clear === undefined) {
                trim_cache_clear = '';
                CookiesStcrtr.set('sitecreator_bar_trim_cache_clear', '', { expires: 30 });
              }
              if(trim_cache_clear != '') {
                trim_cache_checkbox.prop('checked', true);
              }

              trim_cache_checkbox.on("change",
                function(){
                var trim_cache_clear = '';
                  if ($('#sitecreator_bar_trim_cache_clear').is(":checked")) trim_cache_clear = 'on';
                  CookiesStcrtr.set('sitecreator_bar_trim_cache_clear', trim_cache_clear, { expires: 30 });

                });

              // отобразим бар (до этого момента была подготовкка всех элементов)
              bar.css('visibility', 'visible');
              //$('#sitecreator_bar').appendTo($('body'));


              function put_imgs() {
                var me = $(this);
                var link = json['link'];
                console.log('link='+link);
                if(link !='') {
//                var imgs = $("img");
//                  var imgs = obj.data;
                  var imgLoad = imagesLoaded('body',{ background: true });
                  var imgs = imgLoad.images;

                  var imgs_src = [];
                  var imgs_src_json = {};
                  var i;
                  var k = 0; // всего изображений, исключая встроенные
                  var src;
                  for (i = 0; i < imgs.length; ++i) {
                    src = imgs[i].img.src;
//                    src = imgs[i].src;
                    if (src.search(/^data:image/i) == -1) { // только если не встроенное изображение
                      imgs_src_json[i] = src;
                      console.log(imgs_src_json[i]);
                      k++;
                    }

                  }
                  console.log("^==== images ====^ " + k);
//          var imgs_src_json = JSON.stringify(imgs_src);

                  var trim_cache_clear = '';
                  if($('#sitecreator_bar_trim_cache_clear').is(":checked")) trim_cache_clear = 'on';
                  if(trim_cache_clear) link += '&trim_cache_clear=' + trim_cache_clear;


                  $.ajax({
                    url: link,
                    type: 'post',
                    data: {"imgs_src_json": imgs_src_json},
                    dataType: 'json',
                    beforeSend: function() {
                      wait_start_sitecreator(me);
                    },
                    success: function(json) {
                      var date = new Date();
                      var d = date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds() + '> ';
                      var service_result = $('#sitecreator_bar_info');

                      if (json['error']) {
                        service_result.text(d + json['error']);
                      }
                      if (json['success']) {
                        service_result.text(d + json['success']);
                      }
                      wait_stop_sitecreator(me);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                      wait_stop_sitecreator(me);
                    }
                  });
                }

              }

              function compress_imgs() {
                var me = $(this);
                var link = json['link'];
                var quality = $('#jpeg_q_sitecreator').val();

                link +='&compress=ok&quality='+quality;
                console.log('link='+link);
                if(link !='') {
//                var imgs = $("img");
//                  var imgs = obj.data;
                  var imgLoad = imagesLoaded('body',{ background: true });
                  var imgs = imgLoad.images;
                  var imgs_src = [];
                  var imgs_src_json = {};
                  var i;
                  var k = 0; // всего изображений, исключая встроенные
                  var src;
                  for (i = 0; i < imgs.length; ++i) {
                    src = imgs[i].img.src;
                    if (src.search(/^data:image/i) == -1) { // только если не встроенное изображение
                      imgs_src_json[i] = src;
                      console.log(imgs_src_json[i]);
                      console.log(imgs_src_json[i]);
                      k++;
                    }

                  }
                  console.log("^==== images ====^ " + k);
//          var imgs_src_json = JSON.stringify(imgs_src);

                  $.ajax({
                    url: link,
                    type: 'post',
                    data: {"imgs_src_json": imgs_src_json},
                    dataType: 'json',
                    beforeSend: function() {
                      wait_start_sitecreator(me);
                    },
                    success: function(json) {
                      var date = new Date();
                      var d = date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds() + '> ';
                      var service_result = $('#sitecreator_bar_info');

                      if (json['error']) {
                        service_result.text(d + json['error']);
                      }
                      if (json['success']) {
                        service_result.text(d + json['success']);
                      }
                      wait_stop_sitecreator(me);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                      wait_stop_sitecreator(me);
                    }
                  });
                }

              }

              $('#sitecreator_btn_clear_cache_img').on('click', put_imgs);
              $('#sitecreator_btn_compress_img').on('click', compress_imgs);
              $('#jpeg_q_sitecreator').on('change', function () {
                //console.log('сменили');
                var input_q = $('#jpeg_q_sitecreator');
                var jpeg_quality = input_q.val();
                jpeg_quality = parseInt(jpeg_quality);
                if(isNaN(jpeg_quality) || jpeg_quality < 1 || jpeg_quality > 100) jpeg_quality = 80;
                input_q.val(jpeg_quality);

                CookiesStcrtr.set('sitecreator_bar_jpeg_quality', jpeg_quality, { expires: 30 });
              });

              var jpeg_quality = CookiesStcrtr.get('sitecreator_bar_jpeg_quality');
              if(jpeg_quality === undefined) {
                CookiesStcrtr.set('sitecreator_bar_jpeg_quality', '80', { expires: 30 });
              }
              else {
                $('#jpeg_q_sitecreator').val(jpeg_quality);
              }
            }
          }
          else {

          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          // для отладки
          //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      });

    }


    // если не залогинен, то дополнительные скрипты даже и не подключаем
    $.ajax({
      url: 'index.php?route=module/adminbar_by_sitecreator/isLogged00',
      async: true,
      type: 'post',
      dataType: 'json',

      success: function(json) {
        if(json['isLogged']) {
          console.log('islogged =ok');
          //     если Cookies не существуеет, то загрузим
          if(typeof Cookies == 'undefined') {
            // загрузим 2-й скрипт после успешной загрузки 1-го
            load_script('catalog/view/javascript/sitecreator/js.cookie.js', load_script_imagesloaded);
          }
          else load_script_imagesloaded();

        }
        else console.log('islogged=bad');
      },
      error: function(xhr, ajaxOptions, thrownError) {
        // для отладки
        //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }

    });


  });

</script>