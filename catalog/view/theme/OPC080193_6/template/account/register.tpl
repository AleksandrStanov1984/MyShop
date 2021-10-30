<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div style="padding-top: 100px" id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <p><?php echo $text_account_already; ?></p>
      <form action="<?php echo $action; ?>" id="account-form" method="post" enctype="multipart/form-data" class="form-horizontal">
        <div class="form-group required">
          <label class="col-sm-2 control-label" for="input-telephone"><?php echo $entry_telephone; ?></label>
          <div class="col-sm-10">
            <input type="tel" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="form-control" />
            <?php if ($error_telephone) { ?>
            <div class="text-danger"><?php echo $error_telephone; ?></div>
            <?php } ?>
          </div>
        </div>
        <div class="buttons">
          <div class="pull-right">
            <a id="submit-button" class="btn btn-success" href="javascript:void(0);">Отправить</a>
          </div>
        </div>
      </form>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
$('#submit-button').on('click', function() {
	$.ajax({
    url: 'index.php?route=account/register/addCustomer',
    type: 'post',
    dataType: 'json',
    data: new FormData($('#account-form')[0]),
    cache: false,
    contentType: false,
    processData: false,
    beforeSend: function() {
      //$(node).button('loading');
    },
    complete: function() {
      //$(node).button('reset');
    },
    success: function(json) {
      console.log(json);
      //$(node).parent().find('.text-danger').remove();

      if (json['error']) {
        //$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
      }

      if (json['success']) {

      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});
//--></script>
<?php echo $footer; ?>
