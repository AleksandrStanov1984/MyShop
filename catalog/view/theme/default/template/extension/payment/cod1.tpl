<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" data-loading-text="<?php echo $text_loading; ?>" />
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').on('click', function() {
document.getElementById('customer_firstname').value += ' ' + document.getElementById('customer_otchestvo').value;
	$.ajax({
		type: 'get',
		url: 'index.php?route=extension/payment/cod1/confirm',
		cache: false,
		beforeSend: function() {
			$('#ajax_preloader').show();
			//$('#button-confirm').button('loading');
		},
		complete: function() {
			//$('#button-confirm').button('reset');
		},
		success: function() {
			$('#ajax_preloader').hide();
			location = '<?php echo $continue; ?>';
		}
	});
});
//--></script>