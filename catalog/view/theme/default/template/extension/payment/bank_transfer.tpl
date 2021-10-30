<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" data-loading-text="<?php echo $text_loading; ?>" />
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').on('click', function() {
	$.ajax({
		type: 'get',
		url: 'index.php?route=extension/payment/bank_transfer/confirm',
		cache: false,
		beforeSend: function() {
			$('#ajax_preloader').show();
			//$('#button-confirm').button('loading');
		},
		complete: function() {
			//$('#button-confirm').button('reset');
		},
		success: function() {
			$('#ajax_preloader').show();
			location = '<?php echo $continue; ?>';
		}
	});
});
//--></script>
