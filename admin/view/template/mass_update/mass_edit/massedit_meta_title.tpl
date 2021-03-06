<div class="modal-header">
  <button type="button" class="pull-right btn btn-danger btn-sm" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
  <h4 class="modal-title"><?php echo $entry_meta_title; ?></h4>
</div>
<div class="modal-body" id="body-mass-product-meta-title">
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-mass-product-meta-title" class="form-horizontal">	
	<div class="alert alert-info"><?php echo $text_generator_info; ?></div>
	<div class="form-group">
	  <label class="col-sm-2 control-label"><?php echo $entry_generator; ?></label>
	  <div class="col-sm-10">
		<div class="input-checkbox">
		  <input type="checkbox" class="checkbox" name="meta_tile_generator" value="1" id="meta_tile_generator" />
		  <label for="meta_tile_generator"></label>
		</div>
	  </div>
	</div>
	<div class="form-group required" id="meta-title-custom">	
	  <?php foreach ($languages as $language) { ?>
		<label class="col-sm-2 control-label"><?php echo $entry_meta_title; ?></label>
		<div class="col-sm-10">
		  <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span><input type="text" name="product_description[<?php echo $language['language_id']; ?>][meta_title]" value="" placeholder="<?php echo $entry_meta_title; ?>" class="form-control" /></div><br />
		</div>
	  <?php } ?>
	</div>
	<div class="form-group hidden" id="meta-title-generator">
	  <label class="col-sm-2 control-label" for="input-meta-language"><?php echo $entry_language; ?></label>
	  <div class="col-sm-10">
		<select name="language_id" id="input-meta-language" class="form-control">
		  <?php foreach ($languages as $language) { ?>
			<option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>
		  <?php } ?>
		</select>
	  </div>
	</div>
	<div class="form-group hidden" id="meta-title-generator-2">
	  <label class="col-sm-2 control-label" for="input-meta-template"><?php echo $entry_template; ?></label>
	  <div class="col-sm-10">
		<input type="text" name="mass_update_seo_template_meta_title" value="<?php echo $mass_update_seo_template_meta_title; ?>" placeholder="<?php echo $entry_template; ?>" id="input-meta-template" class="form-control" />
		<input type="hidden" name="mass_update_seo_template_meta_h1" value="<?php echo $mass_update_seo_template_meta_h1; ?>">
		<input type="hidden" name="mass_update_seo_template_meta_description" value="<?php echo $mass_update_seo_template_meta_description; ?>">
		<input type="hidden" name="mass_update_seo_template_meta_keywords" value="<?php echo $mass_update_seo_template_meta_keywords; ?>">
		<input type="hidden" name="mass_update_seo_template_tags" value="<?php echo $mass_update_seo_template_tags; ?>">
		<br />
		<div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_meta_title_tags; ?></div>
	  </div>
	</div>
  </form>
</div>
<div class="modal-footer">
  <div class="text-center"><a data-form="form-mass-product-meta-title" class="button-save btn btn-info btn-lg"><?php echo $button_save; ?></a></div>
</div>
<script type="text/javascript"><!--
$(".button-save").on('click', function(){		
	var text_confirm = '<?php echo $text_rewrite_meta_title; ?>';
	
	if (confirm(text_confirm)) {
		$.ajax({
			url: $('#' + $(this).data('form')).attr('action'),
			type: 'post',
			dataType: 'json',
			data: $('#product-list input[type=\'checkbox\']:checked, #' + $(this).data('form') + ' input[type=\'text\'], #' + $(this).data('form') + ' input[type=\'hidden\'], #' + $(this).data('form') + ' input[type=\'checkbox\']:checked, #' + $(this).data('form') + ' select'),
			success: function(json) {
				if (json['error']) {
					$('#form-mass-product-meta-title').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
					
					$('.alert-danger').delay(1500).fadeOut(500);	
				}
									
				if (json['success']) {
					$('#form-mass-product-meta-title').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');	
					
					setTimeout(function(){
						$('#modal-product-edit').modal('hide');
					}, 1000)
				}
			 }
		});
	}
});  
//--></script>
<script type="text/javascript"><!--
$('#form-mass-product-meta-title input[id=\'meta_tile_generator\']').on('change', function() {
	if ($('#form-mass-product-meta-title input[id=\'meta_tile_generator\']:checked').val()) {
		$('#meta-title-generator').removeClass('hidden');
		$('#meta-title-generator-2').removeClass('hidden');
		$('#meta-title-custom').addClass('hidden');
	} else {
		$('#meta-title-generator').addClass('hidden');
		$('#meta-title-generator-2').addClass('hidden');
		$('#meta-title-custom').removeClass('hidden');
	}
});
//--></script>