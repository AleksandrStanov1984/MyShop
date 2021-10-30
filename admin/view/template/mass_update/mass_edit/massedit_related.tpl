<div class="modal-header">
  <button type="button" class="pull-right btn btn-danger btn-sm" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
  <h4 class="modal-title"><?php echo $entry_related; ?></h4>
</div>
<div class="modal-body" id="body-mass-product-related">
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-mass-product-related" class="form-horizontal">	
	<div class="form-group">	
	  <label class="col-sm-3 control-label" for="input-related"><?php echo $entry_related; ?></label>
	  <div class="col-sm-9">
		<input type="text" name="related" value="" placeholder="<?php echo $entry_related; ?>" id="input-related" class="form-control" />
		<div id="product-related" class="well well-sm maxy-scrollbox" style="height: 300px; overflow: auto;">
		  <input type="hidden" name="product_related[]" value="" id="product-related-value" />			
		</div>
	  </div>
	</div>
	<div class="form-group">	
	  <label class="col-sm-3 control-label" for="input-related-method"><?php echo $entry_method_edit; ?></label>
	  <div class="col-sm-9">
		<select name="related_method_edit" id="input-related-method" class="form-control">
		  <option value="all_new"><?php echo $text_all_new; ?></option>
		  <option value="add_selected"><?php echo $text_add_selected; ?></option>
		  <option value="delete_selected"><?php echo $text_delete_selected; ?></option>
		</select>
	  </div>
	</div>
  </form>
</div>
<div class="modal-footer">
  <div class="text-center"><a data-form="form-mass-product-related" class="button-save btn btn-info btn-lg"><?php echo $button_save; ?></a></div>
</div>
<script type="text/javascript"><!--
$(".button-save").on('click', function(){		
	$.ajax({
		url: $('#' + $(this).data('form')).attr('action'),
		type: 'post',
		dataType: 'json',
		data: $('#product-list input[type=\'checkbox\']:checked, #' + $(this).data('form') + ' input[type=\'hidden\'], #' + $(this).data('form') + ' select'),
		success: function(json) {				
			if (json['error']) {
				$('#form-mass-product-related').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
				
				$('.alert-danger').delay(1500).fadeOut(500);	
			}
								
			if (json['success']) {
				$('#form-mass-product-related').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');	
				
				setTimeout(function(){
					$('#modal-product-edit').modal('hide');
				}, 1000)
			}
		}
	});
});  
//--></script>
<script type="text/javascript"><!--
$('input[name=\'related\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=mass_update/mass_update/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'related\']').val('');
		
		$('#product-related' + item['value']).remove();
		
		$('#product-related').append('<div id="product-related' + item['value'] + '"><div class="btn btn-danger scr-box"><i class="fa fa-minus-circle"></i></div> ' + item['label'] + '<input type="hidden" name="product_related[]" value="' + item['value'] + '" /></div>');	
	}	
});

$('#product-related').delegate('.scr-box', 'click', function() {
	$(this).parent().remove();
});
//--></script>