<div class="modal-header">
  <button type="button" class="pull-right btn btn-danger btn-sm" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
  <h4 class="modal-title"><?php echo $text_mass_delete; ?></h4>
</div>
<div class="modal-body" id="body-product-setting-delete-mass">
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product-setting-delete-mass" class="form-horizontal">	
	<div class="form-group">
	  <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_delete_mass_info; ?></div>
	</div>
	<div class="table-responsive">
	  <table class="table table-striped table-hover table-bordered">
		<thead>
		  <tr>
			<td class="text-left"><?php echo $text_setting_data; ?></td>
			<td class="text-center" width="1%"><?php echo $entry_status; ?></td>
		  </tr>
		</thead>
	    <tbody>
  		  <tr>
			<td class="text-left"><?php echo $entry_name; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_name"<?php echo $mass_update_product_mass_delete_name ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_name" />
				<label for="mass_update_product_mass_delete_name"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_description; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_description"<?php echo $mass_update_product_mass_delete_description ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_description" />
				<label for="mass_update_product_mass_delete_description"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_meta_title; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_meta_title"<?php echo $mass_update_product_mass_delete_meta_title ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_meta_title" />
				<label for="mass_update_product_mass_delete_meta_title"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_meta_h1; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_meta_h1"<?php echo $mass_update_product_mass_delete_meta_h1 ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_meta_h1" />
				<label for="mass_update_product_mass_delete_meta_h1"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_meta_description; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_meta_description"<?php echo $mass_update_product_mass_delete_meta_description ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_meta_description" />
				<label for="mass_update_product_mass_delete_meta_description"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_meta_keyword; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_meta_keyword"<?php echo $mass_update_product_mass_delete_meta_keyword ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_meta_keyword" />
				<label for="mass_update_product_mass_delete_meta_keyword"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_tag; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_tag"<?php echo $mass_update_product_mass_delete_tag ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_tag" />
				<label for="mass_update_product_mass_delete_tag"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $column_image; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_image"<?php echo $mass_update_product_mass_delete_image ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_image" />
				<label for="mass_update_product_mass_delete_image"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_model; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_model"<?php echo $mass_update_product_mass_delete_model ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_model" />
				<label for="mass_update_product_mass_delete_model"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_sku; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_sku"<?php echo $mass_update_product_mass_delete_sku ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_sku" />
				<label for="mass_update_product_mass_delete_sku"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_upc; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_upc"<?php echo $mass_update_product_mass_delete_upc ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_upc" />
				<label for="mass_update_product_mass_delete_upc"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_ean; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_ean"<?php echo $mass_update_product_mass_delete_ean ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_ean" />
				<label for="mass_update_product_mass_delete_ean"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_jan; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_jan"<?php echo $mass_update_product_mass_delete_jan ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_jan" />
				<label for="mass_update_product_mass_delete_jan"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_isbn; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_isbn"<?php echo $mass_update_product_mass_delete_isbn ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_isbn" />
				<label for="mass_update_product_mass_delete_isbn"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_mpn; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_mpn"<?php echo $mass_update_product_mass_delete_mpn ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_mpn" />
				<label for="mass_update_product_mass_delete_mpn"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_location; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_location"<?php echo $mass_update_product_mass_delete_location ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_location" />
				<label for="mass_update_product_mass_delete_location"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $column_price; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_price"<?php echo $mass_update_product_mass_delete_price ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_price" />
				<label for="mass_update_product_mass_delete_price"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_tax_class; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_tax_class"<?php echo $mass_update_product_mass_delete_tax_class ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_tax_class" />
				<label for="mass_update_product_mass_delete_tax_class"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $column_quantity; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_quantity"<?php echo $mass_update_product_mass_delete_quantity ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_quantity" />
				<label for="mass_update_product_mass_delete_quantity"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_minimum; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_minimum"<?php echo $mass_update_product_mass_delete_minimum ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_minimum" />
				<label for="mass_update_product_mass_delete_minimum"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $text_seo; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_seo_url"<?php echo $mass_update_product_mass_delete_seo_url ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_seo_url" />
				<label for="mass_update_product_mass_delete_seo_url"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_date_available; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_date_available"<?php echo $mass_update_product_mass_delete_date_available ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_date_available" />
				<label for="mass_update_product_mass_delete_date_available"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_size; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_size"<?php echo $mass_update_product_mass_delete_size ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_size" />
				<label for="mass_update_product_mass_delete_size"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_weight; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_weight"<?php echo $mass_update_product_mass_delete_weight ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_weight" />
				<label for="mass_update_product_mass_delete_weight"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_sort_order; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_sort_order"<?php echo $mass_update_product_mass_delete_sort_order ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_sort_order" />
				<label for="mass_update_product_mass_delete_sort_order"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $column_manufacturer; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_manufacturer"<?php echo $mass_update_product_mass_delete_manufacturer ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_manufacturer" />
				<label for="mass_update_product_mass_delete_manufacturer"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $column_category; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_category"<?php echo $mass_update_product_mass_delete_category ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_category" />
				<label for="mass_update_product_mass_delete_category"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_filter; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_filter"<?php echo $mass_update_product_mass_delete_filter ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_filter" />
				<label for="mass_update_product_mass_delete_filter"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_store; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_store"<?php echo $mass_update_product_mass_delete_store ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_store" />
				<label for="mass_update_product_mass_delete_store"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_download; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_download"<?php echo $mass_update_product_mass_delete_download ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_download" />
				<label for="mass_update_product_mass_delete_download"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_related; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_related"<?php echo $mass_update_product_mass_delete_related ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_related" />
				<label for="mass_update_product_mass_delete_related"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $tab_attribute; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_attribute"<?php echo $mass_update_product_mass_delete_attribute ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_attribute" />
				<label for="mass_update_product_mass_delete_attribute"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $tab_option; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_option"<?php echo $mass_update_product_mass_delete_option ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_option" />
				<label for="mass_update_product_mass_delete_option"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $tab_discount; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_discount"<?php echo $mass_update_product_mass_delete_discount ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_discount" />
				<label for="mass_update_product_mass_delete_discount"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $tab_special; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_special"<?php echo $mass_update_product_mass_delete_special ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_special" />
				<label for="mass_update_product_mass_delete_special"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $text_images; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_images"<?php echo $mass_update_product_mass_delete_images ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_images" />
				<label for="mass_update_product_mass_delete_images"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $entry_reward; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_reward"<?php echo $mass_update_product_mass_delete_reward ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_reward" />
				<label for="mass_update_product_mass_delete_reward"></label>
			  </div>
			</td>
		  </tr>
		  <tr>
			<td class="text-left"><?php echo $tab_design; ?></td>
			<td class="text-center">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_mass_delete_design"<?php echo $mass_update_product_mass_delete_design ? ' checked="checked"' : '' ?> id="mass_update_product_mass_delete_design" />
				<label for="mass_update_product_mass_delete_design"></label>
			  </div>
			</td>
		  </tr>
		</tbody>
	  </table>
	</div>
  </form>
</div>
<div class="modal-footer">
  <div class="text-center"><a data-form="form-product-setting-delete-mass" class="button-save btn btn-info btn-lg"><?php echo $button_save; ?></a></div>
</div>
<script src="view/javascript/mass_update/custom-scrollbar/slimscroll.min.js" type="text/javascript"></script>
<script type="text/javascript"><!--
$(function(){
    $('#body-product-setting-delete-mass').slimScroll({
        height: '500px',
		borderRadius: '0',
		opacity: .2,
    });
});
//--></script>
<script type="text/javascript"><!--
$(".button-save").on('click', function(){		
	$.ajax({
		url: $('#' + $(this).data('form')).attr('action'),
		type: 'post',
		dataType: 'json',
		data: $('#product-list input[type=\'checkbox\']:checked, #' + $(this).data('form') + ' input[type=\'text\'], #' + $(this).data('form') + ' input[type=\'checkbox\']:checked, #' + $(this).data('form') + ' select'),
		success: function(json) {				
			if (json['error']) {
				$('#form-product-setting-delete-mass').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
				
				$('.alert-danger').delay(1500).fadeOut(500);
			}
								
			if (json['success']) {
				$('#form-product-setting-delete-mass').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');	
				
				setTimeout(function(){
					location.reload(true);
				}, 1000)
			}
		}
	});
});  
//--></script>