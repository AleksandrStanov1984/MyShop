<?php echo $header; ?>
<div class="wrapper">
  <!--<div class="breadcrumb">
    <ul class="breadcrumb__list">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <li class="breadcrumb__item"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
      <?php } ?>
    </ul>
  </div>-->
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>


  <div class="row account-box"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>">
        <div>
          <?php echo $content_top; ?>
          <div class="box-page-login">
            <h3 class="title-box-page-login"><?php echo $text_login; ?></h3>
            <form id="form-login" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
              <?php if($user_register) { ?>
              <div class="form-group">
                <input type="hidden" name="telephone" value="<?php echo $telephone; ?>" />
                <label class="label-box-login" for="input-firstname"><?php echo $entry_name; ?></label>
                <div class="input-block-page-login"><input type="text" name="firstname" value="<?php echo $firstname; ?>" id="input-firstname" class="form-control" /></div>
              </div>
              <div class="form-group">
                <label class="label-box-login" for="input-code"><?php echo $text_specify_code; ?></label>
                <input type="text" name="code" value="" id="input-code" placeholder="&#x25CF;&#x25CF;&#x25CF;&#x25CF;"  class="form-control input-box-code" />
                <?php if($text_where_number_send) {?>
                  <div class="text_where_number_send"><?php echo $text_where_number_send; ?></div>
                <?php } ?>
                <a href="javascript:void(0);" class="disabled restoreCode"><?php echo $text_restore_code; ?></a>
              </div>
              <?php } elseif($user_login) { ?>
                <div class="form-group">
                  <input type="hidden" name="telephone" value="<?php echo $telephone; ?>" />
                  <label class="label-box-login" for="input-code"><?php echo $text_specify_code; ?></label>
                  <input type="text" name="code" value="" id="input-code" placeholder="&#x25CF;&#x25CF;&#x25CF;&#x25CF;" class="form-control input-box-code" />
                  <?php if($text_where_number_send) {?>
                    <div class="text_where_number_send"><?php echo $text_where_number_send; ?></div>
                  <?php } ?>
                  <a href="javascript:void(0);" class="disabled restoreCode"><?php echo $text_restore_code; ?> <span class="seconds"></span></a>
                </div>
              <?php } else { ?>
                <div class="form-group">

                  <label class="label-box-login" for="input-telephone"><?php echo $entry_telephone; ?></label><div class="input-block-page-login">
                  <input type="tel" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone_placeholder; ?>" id="input-telephone" class="form-control" />
                 </div>

                </div>
              <?php } ?>
              <div id="result-box">
                <?php if ($error_warning) { ?>
                  <div class="alert alert-danger alert-danger-box-login"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
                <?php } elseif($error_code) { ?>
                    <div class="alert alert-danger alert-danger-box-login"><i class="fa fa-exclamation-circle"></i> <?php echo $error_code; ?></div>
                <?php } ?>
              </div>
              <?php if($user_register) { ?>
                <input type="submit" class="submit-box-login" value="<?php echo $button_register; ?>" />
              <?php } elseif($user_login) { ?>
                <input type="submit" class="submit-box-login" value="<?php echo $button_login; ?>" />
              <?php } else { ?>
                <input type="submit" class="submit-box-login" value="<?php echo $button_send_sms; ?>" />
              <?php } ?>
              <?php if ($rememberme_enable) { ?>
                <input type="hidden" name="rememberme" value="1" />
              <?php } ?>
              <?php if ($redirect) { ?>
              <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
              <?php } ?>
            </form>
            <?php echo $content_bottom; ?>
          </div>

        </div>

      </div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
  countDown(<?php echo $restore_pass; ?>);
  $(document).ready(function () {

    $('input[name=telephone]').mask("+38 (999) 999-99-99");
     $('input[name=code]').mask("9999");
    $('#input-telephone, #input-code').focus();
    $('#input-code').keyup(function(){
     if($(this).val().indexOf('_') == -1){
       console.log('hello');
       $(this).blur();
     }else{
       console.log('bye');
     }
   });

    $('.restoreCode').on('click', function() {
        restoreCode();
    });

  });

  function countDown(seconds) {
      var timer = setInterval(function() {
          if (seconds > 0) {
              seconds --;
              var h = seconds/3600 ^ 0,
                  m = (seconds-h*3600)/60 ^ 0,
                  s = seconds-h*3600-m*60,
                  //time = (h<10?"0"+h:h)+" ч. "+(m<10?"0"+m:m)+" мин. "+(s<10?"0"+s:s)+" сек.";
                  time = (m<10?"0"+m:m)+":"+(s<10?"0"+s:s)+" сек.";
              $(".seconds").text("("+time+")");
          } else {
              clearInterval(timer);
              //$('.restoreCode').removeClass("disabled");
          }
      }, 1000);
  }

  function restoreCode() {
    var phone = $('input[name="telephone"]').val();
    $.ajax({
      url: 'index.php?route=account/login/restoreCode',
      type: "POST",
      data : { telephone: phone },
      dataType: 'json',
      beforeSend: function() {
       if($('#result-box > div').length) {
          $('#result-box > div').remove();
        }
      },
      success: function(json) {
        console.log(json);
        if(json['error']) {
          $('#result-box').append('<div class="alert alert-danger alert-danger-box-login">'+json['error']+'</div>');
        } else {
          $('#result-box').append('<div class="alert alert-danger alert-success-box-login">'+json['success']+'</div>');
          if(json['restore_pass']) {
            countDown(json['restore_pass']);
          }
          setTimeout(function() {
            $('#result-box > div').remove();
          },2000);

        }

        /*setTimeout(function() {
          $('#result-box > div').remove();
        },4000);*/

      },
      error: function() {
        console.log("error");
      }
    });

  }

</script>
<script>
	$(document).ready(function(){
    $.fn.setCursorPosition = function(pos) {

    if ($(this).get(0).setSelectionRange) {
      $(this).get(0).setSelectionRange(pos, pos);
    } else if ($(this).get(0).createTextRange) {
      var range = $(this).get(0).createTextRange();
      range.collapse(true);
      range.moveEnd('character', pos);
      range.moveStart('character', pos);
      range.select();
    }
  };
  $('#input-tel, #input-telephone').click(function(event){
    var k = $(this).val().indexOf('_');
    $(this).setCursorPosition(k);  // set position number
  });
  $('#input-code').click(function(event){
    var k = $(this).val().indexOf('_');
    $(this).setCursorPosition(k);  // set position number
  });
});
</script>
<?php echo $footer; ?>
