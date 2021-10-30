<?php // for Centos correct file association ?>
<?=$header?><?=$column_left?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?=$add?>" data-toggle="tooltip" title="<?=$button_add?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="submit" id="btn-copy" form="form-product" formaction="<?=$copy?>" data-toggle="tooltip" title="<?=$button_copy?>" class="btn btn-default"><i class="fa fa-copy"></i></button>
        <button type="button" data-toggle="tooltip" title="<?=$button_delete?>" class="btn btn-danger" id="btn-delete-products" onclick="confirm('<?=$text_confirm?>') ? $('#form-product').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?=$success?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?=$text_list?></h3>
      </div>
      <div class="panel-body">
        <div class="load-bar-container">
          <div class="load-bar">
            <div class="load-bar-icon">
            <img src="<?=HTTPS_SERVER?>view/image/hpm-loading.gif" alt="loading icon" />
            </div>
            <div id="load-bar-progress"></div>
          </div>
        </div>
				<?php if (!$valid_licence) { ?>
				<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<?=$text_input_licence_list?>
				</div>
				<?php } else { ?>
				<!-- Filter . Begin -->
        <div class="well filter-container" <?=!$view_sm ? 'style="display: none; "' : ''?>>
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-name"><?=$entry_name?></label>
                <div class="input-group input-group-sm">
                  <div class="input-group-addon">
                    <img src="language/<?=$languages[$config_language]['code']?>/<?=$languages[$config_language]['code']?>.png" title="<?=$languages[$config_language]['name']?>"  />
                  </div>
                  <input type="text" name="filter_name" value="<?=$filter_name?>" placeholder="<?=$entry_name?>" id="input-name" class="form-control filter-field" />
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-default remove-filter" data-target="name"><i class="fa fa-close"></i></button>
                  </div>
                </div>
              </div>
							<div class="form-group">
                <label class="control-label" for="input-product-id"><?=$hpm_filter_entry_product_id?></label>
                <div class="input-group input-group-sm">
									<div class="input-group-addon"><i class="fa fa-square"></i></div>
                  <input type="text" name="filter_product_id" value="<?=$filter_product_id?>" placeholder="<?=$hpm_filter_entry_product_id?>" id="input-product-id" class="form-control filter-field" />
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-default remove-filter" data-target="product_id"><i class="fa fa-close"></i></button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-sku"><?=$hpm_filter_entry_sku?></label>
                <div class="input-group input-group-sm">
									<div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                  <input type="text" name="filter_sku" value="<?=$filter_sku?>" placeholder="<?=$hpm_filter_entry_sku?>" id="input-sku" class="form-control filter-field" />
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-default remove-filter" data-target="sku"><i class="fa fa-close"></i></button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-model"><?=$hpm_filter_entry_model?></label>
                <div class="input-group input-group-sm">
									<div class="input-group-addon"><i class="fa fa-play"></i></div>
                  <input type="text" name="filter_model" value="<?=$filter_model?>" placeholder="<?=$hpm_filter_entry_model?>" id="input-model" class="form-control filter-field" />
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-default remove-filter" data-target="model"><i class="fa fa-close"></i></button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-keyword"><?=$hpm_filter_entry_keyword?></label>
                <div class="input-group input-group-sm">
									<div class="input-group-addon"><i class="fa fa-link"></i></div>
                  <input type="text" name="filter_keyword" value="<?=$filter_keyword?>" placeholder="<?=$hpm_filter_entry_keyword?>" id="input-keyword" class="form-control filter-field" />
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-default remove-filter" data-target="keyword"><i class="fa fa-close"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-category-main"><?=$hpm_filter_entry_category_main?></label>
								<div class="input-group input-group-sm">
									<div class="input-group-addon"><i class="fa fa-folder"></i></div>
									<select name="filter_category_main" class="form-control input-sm filter-field" id="input-category-main" data-field="filter_category_main">
										<option value="*"<?= '*' == $filter_category_main ? ' selected="selected"' : '' ?>><?=$hpm_filter_text_none?></option>
										<option value="notset"<?= 'notset' == $filter_category_main ? ' selected="selected"' : '' ?>><?=$hpm_filter_text_notset?></option>
										<?php foreach ($all_categories as $category) { ?>
										<option value="<?=$category['category_id']?>"<?= $category['category_id'] == $filter_category_main ? ' selected="selected"' : '' ?>><?=$category['name']?></option>
										<?php } ?>
									</select>
								</div>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-category"><?=$hpm_filter_entry_category?></label>
								<div class="input-group input-group-sm">
									<div class="input-group-addon"><i class="fa fa-folder-open-o"></i></div>
										<select name="filter_category" class="form-control input-sm filter-field" id="input-category" data-field="filter_category">
											<option value="*"<?= '*' == $filter_category ? ' selected="selected"' : '' ?>><?=$hpm_filter_text_none?></option>
											<option value="notset"<?= 'notset' == $filter_category ? ' selected="selected"' : '' ?>><?=$hpm_filter_text_notset_category?></option>
											<?php foreach ($all_categories as $category) { ?>
											<option value="<?=$category['category_id']?>"<?= $category['category_id'] == $filter_category ? ' selected="selected"' : '' ?>><?=$category['name']?></option>
										<?php } ?>
									</select>
								</div>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-manufacturer"><?=$entry_manufacturer?></label>
								<div class="input-group input-group-sm">
									<!-- <div class="input-group-addon"><i class="fa fa-building"></i></div> -->
									<!-- comment --><div class="input-group-addon"><i class="fa fa-registered"></i></div>
									<select name="filter_manufacturer" class="form-control input-sm filter-field" id="input-manufacturer" data-field="filter_manufacturer">
										<option value="*"<?= '*' == $filter_manufacturer ? ' selected="selected"' : '' ?>><?=$hpm_filter_text_none?></option>
										<option value="notset"<?= 'notset' == $filter_manufacturer ? ' selected="selected"' : '' ?>><?=$hpm_filter_text_notset?></option>
										<?php foreach($manufacturers as $manufacturer) { ?>
										<option value="<?=$manufacturer['manufacturer_id']?>"<?= $manufacturer['manufacturer_id'] == $filter_manufacturer ? ' selected="selected"' : '' ?>><?=$manufacturer['name']?></option>
										<?php } ?>
									</select>
								</div>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-status"><?=$entry_status?></label>
								<div class="input-group input-group-sm">
									<div class="input-group-addon"><i class="fa fa-hand-o-right"></i></div>
									<select name="filter_status" id="input-status" class="form-control input-sm filter-field">
										<option value="*"<?= '*' == $filter_status ? ' selected="selected"' : '' ?>><?=$hpm_filter_text_none?></option>
										<option value="1"<?= '1' == $filter_status ? ' selected="selected"' : '' ?>><?=$text_enabled?></option>
										<option value="0"<?= !$filter_status && !is_null($filter_status) ? ' selected="selected"' : '' ?>><?=$text_disabled?></option>
									</select>
								</div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label" for="input-image"><?=$entry_image?></label>
								<div class="input-group input-group-sm">
									<div class="input-group-addon"><i class="fa fa-image"></i></div>
									<select name="filter_image" id="input-image" class="form-control input-sm filter-field">
										<option value="*"<?= '*' == $filter_image ? ' selected="selected"' : '' ?>><?=$hpm_filter_text_none?></option>
										<option value="1"<?= '1' == $filter_image ? ' selected="selected"' : '' ?>><?=$text_enabled?></option>
										<option value="0"<?= !$filter_image && !is_null($filter_image) ? ' selected="selected"' : '' ?>><?=$text_disabled?></option>
									</select>
								</div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-sm-6">
                    <label class="control-label" for="input-attribute"><?=$entry_attribute?></label>
										<div class="input-group input-group-sm">
											<div class="input-group-addon"><i class="fa fa-tags"></i></div>
												<select name="filter_attribute" id="input-attribute" class="form-control input-sm filter-field__complete">
													<option value="*"<?= '*' == $filter_attribute ? ' selected="selected"' : '' ?>><?=$hpm_filter_text_none?></option>
													<!--<option value="notset" <?= 'notset' == $filter_attribute ? ' selected="selected"' : '' ?>><?=$hpm_filter_text_notset2?></option>-->
													<?php foreach($attributes as $attribue) { ?>
													<option value="<?=$attribue['attribute_id']?>"<?= $attribue['attribute_id'] == $filter_attribute ? ' selected="selected"' : '' ?>><?=$attribue['attribute_group']?> -- <?=$attribue['name']?></option>
													<?php } ?>
												</select>
										</div>
                  </div>
                  <div class="col-sm-6">
                    <label class="control-label" for="input-attribute-value"><?=$hpm_filter_entry_attribute_value?></label>
                    <select name="filter_attribute_value" id="input-attribute-value" class="form-control input-sm filter-field" data-filter-attribut-value="<?= $filter_attribute_value ?>">
                      <option value="*"<?= '*' == $filter_attribute_value ? ' selected="selected"' : '' ?>><?=$hpm_filter_text_none?></option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label"><?=$entry_price?></label>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="input-group input-group-sm">
											<div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                      <input type="text" name="filter_price_min" value="<?=$filter_price_min?>" placeholder="<?=$hpm_filter_text_min?>" id="input-price-min" class="form-control filter-field" />
                      <div class="input-group-btn">
                        <button type="button" class="btn btn-default remove-filter" data-target="price_min"><i class="fa fa-close"></i></button>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="input-group input-group-sm">
											<div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                      <input type="text" name="filter_price_max" value="<?=$filter_price_max?>" placeholder="<?=$hpm_filter_text_max?>" id="input-price-max" class="form-control input-sm filter-field" />
                      <div class="input-group-btn">
                        <button type="button" class="btn btn-default remove-filter" data-target="price_max"><i class="fa fa-close"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label"><?=$entry_quantity?></label>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="input-group input-group-sm">
											<div class="input-group-addon"><i class="fa fa-clone"></i></div>
                      <input type="text" name="filter_quantity_min" value="<?=$filter_quantity_min?>" placeholder="<?=$hpm_filter_text_min?>" id="input-quantity-min" class="form-control input-sm filter-field" />
                      <div class="input-group-btn">
                        <button type="button" class="btn btn-default remove-filter" data-target="quantity_min"><i class="fa fa-close"></i></button>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="input-group input-group-sm">
											<div class="input-group-addon"><i class="fa fa-clone"></i></div>
                      <input type="text" name="filter_quantity_max" value="<?=$filter_quantity_max?>" placeholder="<?=$hpm_filter_text_max?>" id="input-quantity-max" class="form-control input-sm filter-field" />
                      <div class="input-group-btn">
                        <button type="button" class="btn btn-default remove-filter" data-target="quantity_max"><i class="fa fa-close"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> <?=$button_filter?></button>
            </div>
          </div>
        </div>
				<!-- Filter . End -->

        <!-- Upload Form Hidden -->
				<?php if (!$output) { ?>
        <form enctype="multipart/form-data" id="form-upload" class="hidden">
          <input type="file" name="photo_main" id="photo-main" />
          <input type="file" name="photo_additional[]" id="photo-additional" multiple="multiple" />
        </form>
				<?php } ?>

        <!-- Report Modal -->
        <div id="hpm_report" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-danger"></h4>
              </div>
              <div class="modal-body">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <form action="" id="form-add-products-row" class="row">
          <div class="form-group">
            <label class="control-label col-sm-1" for="add-products-row-number"><?=$hpm_entry_products_row_number?></label>
            <div class="col-sm-1">
              <input type="text" name="number" value="1" id="add-products-row-number" class="form-control input-sm" maxlength="2" />
            </div>
            <label class="control-label col-sm-1 depends-on-clone" for="add-products-row-clone-images" style="padding-top: 0;"><span data-toggle="tooltip" title="<?=$hpm_help_clone_images?>"><?=$hpm_entry_clone_images?></span></label>
            <div class="col-sm-1">
              <input type="checkbox" name="clone_images" value="1" id="add-products-row-clone-images" class="form-control depends-on-clone" />
            </div>

            <button type="button" id="btn-add-products-row" class="btn btn-sm btn-success col-sm-2"><i class="fa fa-plus"></i> <?=$hpm_text_add_new_products_row?></button>
          </div>
        </form>

        <form action="<?=$delete?>" method="post" enctype="multipart/form-data" id="form-product"></form>

        <script>
          // config data on load
          var test_mode = <?=$test_mode?>;
          var config_language_id = <?=$config_language_id?>;
          var largest_product_id = false;
					var scrollCurrentProductId;
          var trRow = 0;
        </script>

				<div id="dynamic-content">
          <?php //include DIR_APPLICATION . 'view/template/extension/module/hpm_product_list_content.tpl'; ?>
        </div>
				<!--
        <div class="dynamic-content-container">
          <div class="dynamic-content-load-bar text-center _active">
            <img src="<?=HTTPS_SERVER?>view/image/hpm-loading.gif" alt="loading icon" />
          </div>


        </div>
				-->

				<?php } ?>
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

	<div class="scroll-arrows-wrap">
		<div class="scroll-arrow prev" title="go to prev"><i class="fa fa-angle-up"></i></div>
		<div class="scroll-arrow next" title="go to next"><i class="fa fa-angle-down"></i></div>
	</div>

<?php include DIR_APPLICATION . 'view/template/extension/module/hpm_product_list_js.tpl'; ?>
<?php include DIR_APPLICATION . 'view/template/extension/module/hpm_product_list_js__dynamic_content.tpl'; ?>
<?php include DIR_APPLICATION . 'view/template/extension/module/hpm_product_list_js__attributes.tpl'; ?>
<?php include DIR_APPLICATION . 'view/template/extension/module/hpm_product_list_js__options.tpl'; ?>

<script src='view/javascript/tinymce/tinymce.min.js'></script>
<script>

function strip_tags (input, allowed) { // eslint-disable-line camelcase
  //  discuss at: http://locutus.io/php/strip_tags/
  // original by: Kevin van Zonneveld (http://kvz.io)
  // improved by: Luke Godfrey
  // improved by: Kevin van Zonneveld (http://kvz.io)
  //    input by: Pul
  //    input by: Alex
  //    input by: Marc Palau
  //    input by: Brett Zamir (http://brett-zamir.me)
  //    input by: Bobby Drake
  //    input by: Evertjan Garretsen
  // bugfixed by: Kevin van Zonneveld (http://kvz.io)
  // bugfixed by: Onno Marsman (https://twitter.com/onnomarsman)
  // bugfixed by: Kevin van Zonneveld (http://kvz.io)
  // bugfixed by: Kevin van Zonneveld (http://kvz.io)
  // bugfixed by: Eric Nagel
  // bugfixed by: Kevin van Zonneveld (http://kvz.io)
  // bugfixed by: Tomasz Wesolowski
  //  revised by: Rafał Kukawski (http://blog.kukawski.pl)
  //   example 1: strip_tags('<p>Kevin</p> <br /><b>van</b> <i>Zonneveld</i>', '<i><b>')
  //   returns 1: 'Kevin <b>van</b> <i>Zonneveld</i>'
  //   example 2: strip_tags('<p>Kevin <img src="someimage.png" onmouseover="someFunction()">van <i>Zonneveld</i></p>', '<p>')
  //   returns 2: '<p>Kevin van Zonneveld</p>'
  //   example 3: strip_tags("<a href='http://kvz.io'>Kevin van Zonneveld</a>", "<a>")
  //   returns 3: "<a href='http://kvz.io'>Kevin van Zonneveld</a>"
  //   example 4: strip_tags('1 < 5 5 > 1')
  //   returns 4: '1 < 5 5 > 1'
  //   example 5: strip_tags('1 <br/> 1')
  //   returns 5: '1  1'
  //   example 6: strip_tags('1 <br/> 1', '<br>')
  //   returns 6: '1 <br/> 1'
  //   example 7: strip_tags('1 <br/> 1', '<br><br/>')
  //   returns 7: '1 <br/> 1'

  // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
  allowed = (((allowed || '') + '').toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');

  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi
  var commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi

  return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
    return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : ''
  })
}

//function tinyMCEInit() {
//	tinymce.init({
//		selector: '.tinymce',
//		skin: 'bootstrap',
//		language: 'ru',
//		height: 400,
//		plugins: [
//			'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
//			'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
//			'save table contextmenu directionality emoticons template paste textcolor colorpicker'
//		],
//		toolbar: 'bold italic sizeselect fontselect fontsizeselect | hr alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | insertfile undo redo | forecolor backcolor emoticons | code',
//		fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
//
//		paste_remove_styles: true,
//		paste_remove_spans: true,
//		paste_strip_class_attributes: 'all',
//		paste_block_drop: true,
//
//		paste_preprocess : function(pl, o) {
//			o.content = strip_tags(o.content, '<p><br><h2><h3><h4><h5><h6><ul><ol><li><strong><b><table><tbody><tr><td><img><iframe>');
//		},
//		init_instance_callback: function (editor) {
//			editor.on('blur', function (e) {
//				$('#' + e.target.id).val(editor.getContent());
//				$('#' + e.target.id).trigger('change');
//			});
//		}
//	});
//}
function tinyMCEInit(identifier) {
	tinymce.init({
		selector: identifier,
		skin: 'bootstrap',
		language: 'ru',
		height: 400,
		plugins: [
			'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
			'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
			'save table contextmenu directionality emoticons template paste textcolor colorpicker'
		],
		toolbar: 'bold italic sizeselect fontselect fontsizeselect | hr alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | insertfile undo redo | forecolor backcolor emoticons | code',
		fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",

		paste_remove_styles: true,
		paste_remove_spans: true,
		paste_strip_class_attributes: 'all',
		paste_block_drop: true,

		paste_preprocess : function(pl, o) {
			o.content = strip_tags(o.content, '<p><br><h2><h3><h4><h5><h6><ul><ol><li><strong><b><table><tbody><tr><td><img><iframe>');
		},
		init_instance_callback: function (editor) {
			editor.on('blur', function (e) {
				$('#' + e.target.id).val(editor.getContent());
				$('#' + e.target.id).trigger('change');
			});
		}
	});
}
</script>

<script type="text/javascript">
$('.date').datetimepicker({
	pickTime: false,
}).on('dp.change', function (e) {
  //var formatedValue = e.date.format("YYYY-MM-DD");
  //$(e.currentTarget).children('.le-value').val(formatedValue);
  $(e.currentTarget).children('.le-value').trigger('change');
});

$('.time').datetimepicker({
	pickDate: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

</script>
</div>
<?= $footer ?>

