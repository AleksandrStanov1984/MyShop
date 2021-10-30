<?php // for Centos correct file association ?>
<?=$header?><?=$column_left?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form_handy_product_manager" data-toggle="tooltip" title="<?=$button_save?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?=$cancel?>" data-toggle="tooltip" title="<?=$button_cancel?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?=$heading_title?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?=$breadcrumb['href']?>"><?=$breadcrumb['text']?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?=$error_warning?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if (isset($text_success)) { ?>
    <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?=$text_success?>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-cogs"></i> <?=$text_edit?></h3>
      </div>
      <div class="panel-body">
        <form action="<?=$action?>" method="post" enctype="multipart/form-data" id="form_handy_product_manager" class="form-horizontal">
          <?php if(!$valid_licence) { ?>
          <!-- Licence Save -->
          <div class="form-group required" id="input-licence-wrapper" style="padding-top: 5px; padding-bottom: 5px;">
            <label class="col-sm-3 control-label" for="input-licence"><?=$entry_licence?></label>
            <div class="col-sm-7">
              <input type="text" name="hpm_licence" value="<?=$hpm_licence?>" placeholder="<?=$entry_licence?>" id="input-licence" class="form-control" />
              <?php if (isset($errors['licence'])) { ?><div class="text-danger"><?=$errors['licence']?></div><?php } ?>
            </div>
            <div class="col-sm-2">
              <button id="save-licence" class="btn btn-danger"><?=$button_save_licence?></button>
            </div>
          </div>
          <?php } else { ?>
          <input type="hidden" name="hpm_licence" value="<?=$hpm_licence?>" id="input-licence" />
          <?php } ?>
          <!-- module-work-area -->
          <div id="module-work-area" <?=!$valid_licence ? 'style="display: none;"' : ''?>>
						<fieldset style="border: 1px dashed #ccc; border-radius: 3px; margin-bottom: 15px; padding-top: 5px; padding-bottom: 15px;">

							<!-- status -->
							<div class="form-group" style="padding-bottom: 5px;">
								<label class="col-sm-3 control-label" for="input_status"><?=$entry_status?>:</label>
								<div class="col-sm-3">
									<select name="hpm_status" id="input_status" class="form-control">
										<?php if ($hpm_status) { ?>
										<option value="1" selected="selected"><?=$text_enabled?></option>
										<option value="0"><?=$text_disabled?></option>
										<?php } else { ?>
										<option value="1"><?=$text_enabled?></option>
										<option value="0" selected="selected"><?=$text_disabled?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<hr style="border: none; margin: 5px auto;" />

							<!-- test_mode -->
							<div class="form-group" style="padding-top: 5px; padding-bottom: 5px;">
								<label class="col-sm-3 control-label" for="input_test_mode" style="padding-top: 0px;"><span data-toggle="tooltip" title="<?=$help_test_mode?>"><?=$entry_test_mode?>:</span></label>
								<div class="col-sm-3">
									<select name="hpm_test_mode" id="input_test_mode" class="form-control">
										<?php if ($hpm_test_mode) { ?>
										<option value="1" selected="selected"><?=$text_enabled?></option>
										<option value="0"><?=$text_disabled?></option>
										<?php } else { ?>
										<option value="1"><?=$text_enabled?></option>
										<option value="0" selected="selected"><?=$text_disabled?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<hr style="border: none; margin: 5px auto;" />

							<!-- system -->
							<div class="form-group" style="padding-top: 5px; padding-bottom: 5px;">
								<label class="col-sm-3 control-label" for="input-system"><?= $entry_system ?>:</label>
								<div class="col-sm-3">
									<select name="hpm_system" id="input-system" class="form-control">
										<?php	foreach ($systems as $system) { ?>
										<option value="<?= $system ?>" <?= $hpm_system == $system ? 'selected' : '' ?>><?= $system ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<hr style="border: none; margin: 5px auto;" />

						</fieldset>

						<fieldset style="border: 1px dashed #ccc; border-radius: 3px; margin-bottom: 15px; padding-top: 5px; padding-bottom: 15px;">
							<h4 style="padding-left: 15px; padding-top: 10px;"><?=$fieldset_product_list?></h4>
							<!-- product_list_field -->
							<div class="form-group" style="padding-bottom: 0px;">
								<label style="padding-top: 0px;" class="col-sm-3 control-label"><?=$entry_product_list_field?>:</label>
								<div class="special well well-sm col-sm-3" style="height: 300px; overflow: auto;">
									<?php foreach($a_exist_product_fields as $field => $value) { ?>
									<div class="checkbox">
										<?php
										$checked = '';
										if (isset($hpm_product_list_field[$field])) {
											$checked = ' checked="checked"';
										}

										$not_editable = '';
										if (isset($a_required_product_field[$field])) {
											$checked = ' checked="checked"';
											$not_editable = ' readonly="true" disabled';
										}
										?>
										<label><input id="input_product_list_field_<?=$field?>"	type="checkbox" name="hpm_product_list_field[<?=$field?>]" style="float: left; margin-right: 7px;"<?=$checked?><?=$not_editable?> value="on" /><?=$field?></label>
									</div>
									<?php } ?>
								</div>
							</div>
							<hr />
							<!-- product_list_custom_fields -->
							<div class="form-group" style="padding-top: 0px; padding-bottom: 0px;">
								<label style="padding-top: 0px;" class="col-sm-3 control-label"><?=$entry_product_list_field_custom?>:</label>
								<div class="col-sm-9 row">
									<?php if (is_array($product_table_columns_custom_exist) && count($product_table_columns_custom_exist) > 0) { ?>
									<?php foreach ($product_table_columns_custom_exist as $field => $type) { ?>

									<div class="form-group">
										<div class="col-sm-3">
											<label class="control-label"><?=$entry_field_key?></label>
											<div class="checkbox">
												<?php
												$checked = '';
												if (isset($hpm_product_list_field_custom[$field]['status']) &&'on' == $hpm_product_list_field_custom[$field]['status']) {
													$checked = ' checked="checked"';
												}
												?>
												<label><input type="checkbox" name="hpm_product_list_field_custom[<?=$field?>][status]" style="float: left; margin-right: 7px;"<?=$checked?><?=$not_editable?> value="on" /><?=$field?> - <?=$type?></label>
											</div>
										</div>
										<div class="col-sm-6">
											<label class="control-label"><?=$entry_field_name?></label>
											<?php foreach ($languages as $language) { ?>
											<div class="input-group ">
												<span class="input-group-addon">
													<img src="language/<?=$language['code']?>/<?=$language['code']?>.png" title="<?=$language['name']?>" />
												</span>
												<input name="hpm_product_list_field_custom[<?=$field?>][description][<?=$language['language_id']?>]" value="<?=$hpm_product_list_field_custom[$field]['description'][$language['language_id']]?>" class="form-control" />
											</div>
											<?php } ?>
										</div>
										<div class="col-sm-3">
											<label for="input_field_custom_<?=$field?>" style="padding-top: 0px;" class="control-label"><?=$entry_field_type?></label>
											<select name="hpm_product_list_field_custom[<?=$field?>][field_type]" class="form-control" id="input_field_custom_<?=$field?>">
												<?php foreach($custom_fields_types_exist as $key => $text) { ?>
												<option value="<?=$key?>" <?= $hpm_product_list_field_custom[$field]['field_type'] == $key ? 'selected="selected"' : '' ?>><?=$text?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<?php } ?>
									<?php } ?>
								</div>
							</div>
							<hr />

							<!-- product_list_limit -->
							<div class="form-group" style="padding-top: 0px;">
								<label for="input_product_list_limit" style="padding-top: 0px;" class="col-sm-3 control-label"><?=$entry_product_list_limit?>:</label>
								<div class="col-sm-3">
									<input id="input_product_list_limit"	type="text" name="hpm_product_list_limit" value="<?= isset($hpm_product_list_limit) ? $hpm_product_list_limit : '' ?>" class="form-control" maxlength="4"/>
									<?php if (isset($errors['product_list_limit'])) { ?><div class="text-danger"><?=$errors['product_list_limit']?></div><?php } ?>
								</div>
							</div>
<!--							<hr />-->

							<!-- product_edit_model_require -->
<!--							<div class="form-group">
								<label class="col-sm-3 control-label" for="product_edit_model_require" style="padding-top: 0px;"><?=$entry_product_edit_model_require?>:</label>
								<div class="col-sm-3">
									<select name="hpm_product_edit_model_require" id="product_edit_model_require" class="form-control">
										<?php if ($hpm_product_edit_model_require) { ?>
										<option value="1" selected="selected"><?=$text_enabled?></option>
										<option value="0"><?=$text_disabled?></option>
										<?php } else { ?>
										<option value="1"><?=$text_enabled?></option>
										<option value="0" selected="selected"><?=$text_disabled?></option>
										<?php } ?>
									</select>
								</div>
							</div>-->
						</fieldset>
						<fieldset style="border: 1px dashed #ccc; border-radius: 3px; margin-bottom: 15px; padding-top: 5px; padding-bottom: 15px;">
							<h4 style="padding-left: 15px; padding-top: 10px;"><?=$fieldset_translit?></h4>
							<!-- language & translits -->
							<div class="form-group" style="padding-top: 5px; padding-bottom: 5px;">
								<label class="col-sm-3 control-label" for="input-language"><?=$entry_transliteration?>:</label>
								<!-- langauge ID -->
								<div class="col-sm-3">
									<?=$entry_language_id?>
									<select name="hpm_language" id="input-language" class="form-control">
										<?php foreach ($languages as $language) { ?>
										<option value="<?=$language['language_id']?>" <?= $hpm_language == $language['language_id'] ? 'selected' : '' ?>><?=$language['name']?></option><?php } ?>
									</select>
								</div>
								<!-- translit function -->
								<div class="col-sm-3">
									<?=$entry_translit_function?>
									<select name="hpm_translit_function" id="input-translit-function" class="form-control">
										<?php	foreach ($translit_functions as $key => $function) { ?>
										<option value="<?=$key?>" <?= $hpm_translit_function == $key ? 'selected' : '' ?>><?=$function?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<hr />
							<div class="form-group">
								<label for="translit_formula" style="" class="col-sm-3 control-label"><?=$entry_translit_formula?>:</label>
								<div class="col-sm-6">
									<input id="translit_formula"	type="text" name="hpm_translit_formula" value="<?= isset($hpm_translit_formula) ? $hpm_translit_formula : '' ?>" class="form-control" maxlength="50" />
									<div><i><?=$text_available_vars?></i>: [product_name], [product_id], [model], [sku]</div>
									<?php if (isset($errors['translit_formula'])) { ?><div class="text-danger"><?=$errors['translit_formula']?></div><?php } ?>
								</div>
							</div>
						</fieldset>

            <fieldset style="border: 1px dashed #ccc; border-radius: 3px;">
              <h4 style="padding-left: 15px; padding-top: 10px;"><?=$fieldset_upload?></h4>
              <!-- rename_mode -->
              <div class="form-group">
                <label class="col-sm-3 control-label" for="rename_mode"><?=$entry_upload_rename_mode?>:</label>
                <div class="col-sm-3">
                  <select name="hpm_upload_settings[rename_mode]" id="rename_mode" class="form-control">
                    <?php foreach($a_upload_rename_modes as $mode => $label) { ?>
                    <option value="<?=$mode?>" <?= $mode == $hpm_upload_settings['rename_mode'] ? 'selected="selected"' : ''?>><?=$label?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <hr />
              <!-- rename_formula -->
              <div class="form-group" style="padding-top: 0px;">
                <label for="rename_formula" style="padding-top: 0px;" class="col-sm-3 control-label"><?=$entry_upload_rename_formula?>:</label>
                <div class="col-sm-6">
                  <input id="rename_formula"	type="text" name="hpm_upload_settings[rename_formula]" value="<?= isset($hpm_upload_settings['rename_formula']) ? $hpm_upload_settings['rename_formula'] : '' ?>" class="form-control" maxlength="50" />
                  <div><i><?=$text_available_vars?></i>: [product_name], [model], [sku]</div>
                  <?php if (isset($errors['rename_formula'])) { ?><div class="text-danger"><?=$errors['rename_formula']?></div><?php } ?>
                </div>
              </div>
              <hr />
              <!-- max_size_in_mb -->
              <div class="form-group" style="padding-top: 0px;">
                <label for="max_size_in_mb" class="col-sm-3 control-label"><?=$entry_upload_max_size_in_mb?>:</label>
                <div class="col-sm-1">
                  <input id="max_size_in_mb"	type="text" name="hpm_upload_settings[max_size_in_mb]" value="<?= isset($hpm_upload_settings['max_size_in_mb']) ? $hpm_upload_settings['max_size_in_mb'] : '' ?>" class="form-control" maxlength="50" />
                  <?php if (isset($errors['max_size_in_mb'])) { ?><div class="text-danger"><?=$errors['max_size_in_mb']?></div><?php } ?>
                </div>
              </div>
							<hr />
              <!-- upload_mode -->
              <div class="form-group">
                <label class="col-sm-3 control-label" style="padding-top: 0px;" for="upload_mode"><?=$entry_upload_mode?>:</label>
                <div class="col-sm-3">
                  <select name="hpm_upload_settings[upload_mode]" id="upload_mode" class="form-control">
                    <?php foreach($a_upload_modes as $mode => $label) { ?>
                    <option value="<?=$mode?>" <?= $mode == $hpm_upload_settings['upload_mode'] ? 'selected="selected"' : ''?>><?=$label?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <hr />

            </fieldset>



          </div>
          <!-- /module-work-area -->
        </form>
      </div>
    </div>
    <div class="copywrite" style="padding: 10px 10px 0 10px; border: 1px dashed #ccc;">
    	<p>
    		&copy; <?=$text_author?>: <a href="http://sergetkach.com/link/272" target="_blank">Serge Tkach</a>
    		<br/>
				<?=$text_author_support?>: <a href="mailto:sergheitkach@gmail.com">sergheitkach@gmail.com</a>
    	</p>
    </div>
  </div>
</div>
<script type="text/javascript">
$('#save-licence').click(function(e){
  e.preventDefault();

  $('.alert').remove();

  var licence = $('#input-licence').val();

  $.ajax({
    url: 'index.php?route=extension/module/handy_product_manager/saveLicence&token=<?=$token?>',
    type: 'POST',
    dataType: 'json',
    data: "licence=" + licence,
    beforeSend: function() {

    },
    success: function(json) {
      console.log('request success');
      if (json['success']) {
         console.log('licence success');
        // success

        $('#input-licence-wrapper').parent('form').prepend('<div class="alert alert-success">'+ json['success'] +'</div>');

        $('#input-licence-wrapper').remove();
        $('#module-work-area').prepend('<input type="hidden" name="hpm_licence" value="' + licence + '" />');
        $('#module-work-area').show();
      } else {
        console.log('licence error');
        $('#input-licence-wrapper').parent('form').prepend('<div class="alert alert-danger">'+ json['error'] +'</div>');
      }
    },
    error: function( jqXHR, textStatus, errorThrown ){
      // Error ajax query
      console.log('AJAX query Error: ' + textStatus );
    },
    complete: function() {
      $('#button-review').button('reset');
    },

  });
});

</script>
<?=$footer?>
