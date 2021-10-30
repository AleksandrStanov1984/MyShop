<div class="modal-header">
  <button type="button" class="pull-right btn btn-danger btn-sm" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
  <h4 class="modal-title"><?php echo $text_edit_items; ?></h4>
</div>
<div class="modal-body" id="body-product-setting-edit-items">
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product-setting-edit-items" class="form-horizontal">	
	<div class="col-md-3">
	  <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="#tab-setting-general" data-toggle="tab"><?php echo $text_edit_items; ?></a></li>
		<li><a href="#tab-setting-button" data-toggle="tab"><?php echo $text_setting_data; ?></a></li>
		<li><a href="#tab-setting-hidden" data-toggle="tab"><?php echo $text_setting_hidden; ?></a></li>
      </ul>
	</div>
	<div class="col-md-9">
	  <div class="tab-content">
		<div class="tab-pane active" id="tab-setting-general">
		  <div class="form-group">
			<label class="col-sm-6 control-label" for="input-default-add-filter"><?php echo $text_add_filter; ?></label>
			<div class="col-sm-6">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_add_filter"<?php echo $mass_update_product_add_filter ? ' checked="checked"' : '' ?> id="mass_update_product_add_filter" />
				<label for="mass_update_product_add_filter"></label>
			  </div>
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-6 control-label"><?php echo $entry_product_model_required; ?></label>
			<div class="col-sm-6">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_model_required"<?php echo $mass_update_product_model_required ? ' checked="checked"' : '' ?> id="mass_update_product_model_required" />
				<label for="mass_update_product_model_required"></label>
			  </div>
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-6 control-label"><span data-toggle="tooltip" title="<?php echo $help_default_stock; ?>"><?php echo $entry_default_stock; ?></span></label>
			<div class="col-sm-6">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_default_stock"<?php echo $mass_update_product_default_stock ? ' checked="checked"' : '' ?> id="mass_update_product_default_stock" />
				<label for="mass_update_product_default_stock"></label>
			  </div>
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-6 control-label" for="input-default-shipping"><span data-toggle="tooltip" title="<?php echo $help_default_shipping; ?>"><?php echo $entry_default_shipping; ?></span></label>
			<div class="col-sm-6">
			  <div class="input-checkbox">
				<input type="checkbox" class="checkbox" name="mass_update_product_default_shipping"<?php echo $mass_update_product_default_shipping ? ' checked="checked"' : '' ?> id="mass_update_product_default_shipping" />
				<label for="mass_update_product_default_shipping"></label>
			  </div>
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-6 control-label" for="input-default-quantity"><span data-toggle="tooltip" title="<?php echo $help_default_quantity; ?>"><?php echo $entry_default_quantity; ?></span></label>
			<div class="col-sm-6">
			  <input type="text" name="mass_update_product_default_quantity" value="<?php echo $mass_update_product_default_quantity; ?>" placeholder="<?php echo $entry_default_quantity; ?>" id="input-default-quantity" class="form-control" />
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-6 control-label" for="input-default-min-quantity"><span data-toggle="tooltip" title="<?php echo $help_default_min_quantity; ?>"><?php echo $entry_default_min_quantity; ?></span></label>
			<div class="col-sm-6">
			  <input type="text" name="mass_update_product_default_min_quantity" value="<?php echo $mass_update_product_default_min_quantity; ?>" placeholder="<?php echo $entry_default_min_quantity; ?>" id="input-default-min-quantity" class="form-control" />
			</div>
		  </div>
		  <div class="form-group">
			<label class="col-sm-6 control-label" for="input-limit"><span data-toggle="tooltip" title="<?php echo $help_default_limit; ?>"><?php echo $entry_default_limit; ?></span></label>
			<div class="col-sm-6">
			  <input type="text" name="mass_update_product_default_limit" value="<?php echo $mass_update_product_default_limit; ?>" placeholder="<?php echo $entry_default_limit; ?>" id="input-limit" class="form-control" />
			</div>
		  </div>
		</div>
		<div class="tab-pane" id="tab-setting-button">
		  <div class="form-group">
			<div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_edit_items_info; ?></div>
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
				  <td class="text-left"><?php echo $entry_image; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_image"<?php echo $mass_update_product_image ? ' checked="checked"' : '' ?> id="mass_update_product_image" />
					  <label for="mass_update_product_image"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $entry_product_name; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_name"<?php echo $mass_update_product_name ? ' checked="checked"' : '' ?> id="mass_update_product_name" />
					  <label for="mass_update_product_name"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $entry_product_category; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_category"<?php echo $mass_update_product_category ? ' checked="checked"' : '' ?> id="mass_update_product_category" />
					  <label for="mass_update_product_category"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $entry_product_manufacturer; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_manufacturer"<?php echo $mass_update_product_manufacturer ? ' checked="checked"' : '' ?> id="mass_update_product_manufacturer" />
					  <label for="mass_update_product_manufacturer"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $entry_product_model; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_model"<?php echo $mass_update_product_model ? ' checked="checked"' : '' ?> id="mass_update_product_model" />
					  <label for="mass_update_product_model"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $entry_product_price; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_price"<?php echo $mass_update_product_price ? ' checked="checked"' : '' ?> id="mass_update_product_price" />
					  <label for="mass_update_product_price"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $entry_product_quantity; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_quantity"<?php echo $mass_update_product_quantity ? ' checked="checked"' : '' ?> id="mass_update_product_quantity" />
					  <label for="mass_update_product_quantity"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $entry_sort_order; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_sort_order"<?php echo $mass_update_product_sort_order ? ' checked="checked"' : '' ?> id="mass_update_product_sort_order" />
					  <label for="mass_update_product_sort_order"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $entry_status; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_status"<?php echo $mass_update_product_status ? ' checked="checked"' : '' ?> id="mass_update_product_status" />
					  <label for="mass_update_product_status"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $text_general; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_general"<?php echo $mass_update_product_general ? ' checked="checked"' : '' ?> id="mass_update_product_general" />
					  <label for="mass_update_product_general"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $text_code; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_code"<?php echo $mass_update_product_code ? ' checked="checked"' : '' ?> id="mass_update_product_code" />
					  <label for="mass_update_product_code"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $text_tax; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_tax"<?php echo $mass_update_product_tax ? ' checked="checked"' : '' ?> id="mass_update_product_tax" />
					  <label for="mass_update_product_tax"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $text_stock; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_stock"<?php echo $mass_update_product_stock ? ' checked="checked"' : '' ?> id="mass_update_product_stock" />
					  <label for="mass_update_product_stock"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $text_seo; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_seo"<?php echo $mass_update_product_seo ? ' checked="checked"' : '' ?> id="mass_update_product_seo" />
					  <label for="mass_update_product_seo"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $entry_date_available; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_date"<?php echo $mass_update_product_date ? ' checked="checked"' : '' ?> id="mass_update_product_date" />
					  <label for="mass_update_product_date"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $text_size; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_weight"<?php echo $mass_update_product_weight ? ' checked="checked"' : '' ?> id="mass_update_product_weight" />
					  <label for="mass_update_product_weight"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $entry_filter; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_filter"<?php echo $mass_update_product_filter ? ' checked="checked"' : '' ?> id="mass_update_product_filter" />
					  <label for="mass_update_product_filter"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $entry_store; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_store"<?php echo $mass_update_product_store ? ' checked="checked"' : '' ?> id="mass_update_product_store" />
					  <label for="mass_update_product_store"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $entry_download; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_download"<?php echo $mass_update_product_download ? ' checked="checked"' : '' ?> id="mass_update_product_download" />
					  <label for="mass_update_product_download"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $entry_related; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_related"<?php echo $mass_update_product_related ? ' checked="checked"' : '' ?> id="mass_update_product_related" />
					  <label for="mass_update_product_related"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $entry_attribute; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_attribute"<?php echo $mass_update_product_attribute ? ' checked="checked"' : '' ?> id="mass_update_product_attribute" />
					  <label for="mass_update_product_attribute"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $tab_option; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_option"<?php echo $mass_update_product_option ? ' checked="checked"' : '' ?> id="mass_update_product_option" />
					  <label for="mass_update_product_option"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $tab_discount; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_discount"<?php echo $mass_update_product_discount ? ' checked="checked"' : '' ?> id="mass_update_product_discount" />
					  <label for="mass_update_product_discount"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $tab_special; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_special"<?php echo $mass_update_product_special ? ' checked="checked"' : '' ?> id="mass_update_product_special" />
					  <label for="mass_update_product_special"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $tab_image; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_images"<?php echo $mass_update_product_images ? ' checked="checked"' : '' ?> id="mass_update_product_images" />
					  <label for="mass_update_product_images"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $entry_reward; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_reward"<?php echo $mass_update_product_reward ? ' checked="checked"' : '' ?> id="mass_update_product_reward" />
					  <label for="mass_update_product_reward"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $tab_design; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_design"<?php echo $mass_update_product_design ? ' checked="checked"' : '' ?> id="mass_update_product_design" />
					  <label for="mass_update_product_design"></label>
				    </div>
				  </td>
			    </tr>
			    <tr>
				  <td class="text-left"><?php echo $entry_product_view; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
					  <input type="checkbox" class="checkbox" name="mass_update_product_view"<?php echo $mass_update_product_view ? ' checked="checked"' : '' ?> id="mass_update_product_view" />
					  <label for="mass_update_product_view"></label>
				    </div>
				  </td>
			    </tr>
			  </tbody>
		    </table>
		  </div>
		</div>
		<div class="tab-pane" id="tab-setting-hidden">
		  <div class="form-group">
			<div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_hide_data; ?></div>
		  </div>
		  <div class="table-responsive">
		    <table class="table table-striped table-hover table-bordered">
			  <thead>
			    <tr>
				  <td class="text-left"><?php echo $text_setting_data; ?></td>
				  <td class="text-center" width="1%"><?php echo $entry_hide; ?></td>
			    </tr>
			  </thead>
			  <tbody>
  			    <tr>
				  <td class="text-left"><?php echo $text_code; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_codes"<?php echo $mass_update_product_hide_codes ? ' checked="checked"' : '' ?> id="mass_update_product_hide_codes" />
					  <label for="mass_update_product_hide_codes"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_product_model; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_model"<?php echo $mass_update_product_hide_model ? ' checked="checked"' : '' ?> id="mass_update_product_hide_model" />
					  <label for="mass_update_product_hide_model"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_product_price; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_price"<?php echo $mass_update_product_hide_price ? ' checked="checked"' : '' ?> id="mass_update_product_hide_price" />
					  <label for="mass_update_product_hide_price"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_tax_class; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_tax"<?php echo $mass_update_product_hide_tax ? ' checked="checked"' : '' ?> id="mass_update_product_hide_tax" />
					  <label for="mass_update_product_hide_tax"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_quantity; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_quantity"<?php echo $mass_update_product_hide_quantity ? ' checked="checked"' : '' ?> id="mass_update_product_hide_quantity" />
					  <label for="mass_update_product_hide_quantity"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_minimum; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_minimum"<?php echo $mass_update_product_hide_minimum ? ' checked="checked"' : '' ?> id="mass_update_product_hide_minimum" />
					  <label for="mass_update_product_hide_minimum"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_subtract; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_subtract"<?php echo $mass_update_product_hide_subtract ? ' checked="checked"' : '' ?> id="mass_update_product_hide_subtract" />
					  <label for="mass_update_product_hide_subtract"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_stock_status; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_stock_status"<?php echo $mass_update_product_hide_stock_status ? ' checked="checked"' : '' ?> id="mass_update_product_hide_stock_status" />
					  <label for="mass_update_product_hide_stock_status"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_shipping; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_shipping"<?php echo $mass_update_product_hide_shipping ? ' checked="checked"' : '' ?> id="mass_update_product_hide_shipping" />
					  <label for="mass_update_product_hide_shipping"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_keyword; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_seo_keyword"<?php echo $mass_update_product_hide_seo_keyword ? ' checked="checked"' : '' ?> id="mass_update_product_hide_seo_keyword" />
					  <label for="mass_update_product_hide_seo_keyword"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_date_available; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_date_available"<?php echo $mass_update_product_hide_date_available ? ' checked="checked"' : '' ?> id="mass_update_product_hide_date_available" />
					  <label for="mass_update_product_hide_date_available"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_dimension; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_dimension"<?php echo $mass_update_product_hide_dimension ? ' checked="checked"' : '' ?> id="mass_update_product_hide_dimension" />
					  <label for="mass_update_product_hide_dimension"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_length_class; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_length_class"<?php echo $mass_update_product_hide_length_class ? ' checked="checked"' : '' ?> id="mass_update_product_hide_length_class" />
					  <label for="mass_update_product_hide_length_class"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_weight; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_weight"<?php echo $mass_update_product_hide_weight ? ' checked="checked"' : '' ?> id="mass_update_product_hide_weight" />
					  <label for="mass_update_product_hide_weight"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_weight_class; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_weight_class"<?php echo $mass_update_product_hide_weight_class ? ' checked="checked"' : '' ?> id="mass_update_product_hide_weight_class" />
					  <label for="mass_update_product_hide_weight_class"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_status; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_status"<?php echo $mass_update_product_hide_status ? ' checked="checked"' : '' ?> id="mass_update_product_hide_status" />
					  <label for="mass_update_product_hide_status"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_sort_order; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_sort_order"<?php echo $mass_update_product_hide_sort_order ? ' checked="checked"' : '' ?> id="mass_update_product_hide_sort_order" />
					  <label for="mass_update_product_hide_sort_order"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_manufacturer; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_manufacturer"<?php echo $mass_update_product_hide_manufacturer ? ' checked="checked"' : '' ?> id="mass_update_product_hide_manufacturer" />
					  <label for="mass_update_product_hide_manufacturer"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_filter; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_filter"<?php echo $mass_update_product_hide_filter ? ' checked="checked"' : '' ?> id="mass_update_product_hide_filter" />
					  <label for="mass_update_product_hide_filter"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_store; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_store"<?php echo $mass_update_product_hide_store ? ' checked="checked"' : '' ?> id="mass_update_product_hide_store" />
					  <label for="mass_update_product_hide_store"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_download; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_download"<?php echo $mass_update_product_hide_download ? ' checked="checked"' : '' ?> id="mass_update_product_hide_download" />
					  <label for="mass_update_product_hide_download"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_related; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_related"<?php echo $mass_update_product_hide_related ? ' checked="checked"' : '' ?> id="mass_update_product_hide_related" />
					  <label for="mass_update_product_hide_related"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $tab_attribute; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_attribute"<?php echo $mass_update_product_hide_attribute ? ' checked="checked"' : '' ?> id="mass_update_product_hide_attribute" />
					  <label for="mass_update_product_hide_attribute"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $tab_option; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_option"<?php echo $mass_update_product_hide_option ? ' checked="checked"' : '' ?> id="mass_update_product_hide_option" />
					  <label for="mass_update_product_hide_option"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_recurring; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_recurring"<?php echo $mass_update_product_hide_recurring ? ' checked="checked"' : '' ?> id="mass_update_product_hide_recurring" />
					  <label for="mass_update_product_hide_recurring"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $tab_discount; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_discount"<?php echo $mass_update_product_hide_discount ? ' checked="checked"' : '' ?> id="mass_update_product_hide_discount" />
					  <label for="mass_update_product_hide_discount"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $tab_special; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_special"<?php echo $mass_update_product_hide_special ? ' checked="checked"' : '' ?> id="mass_update_product_hide_special" />
					  <label for="mass_update_product_hide_special"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $tab_image; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_image"<?php echo $mass_update_product_hide_image ? ' checked="checked"' : '' ?> id="mass_update_product_hide_image" />
					  <label for="mass_update_product_hide_image"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $entry_reward; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_reward"<?php echo $mass_update_product_hide_reward ? ' checked="checked"' : '' ?> id="mass_update_product_hide_reward" />
					  <label for="mass_update_product_hide_reward"></label>
				    </div>
				  </td>
			    </tr>
				<tr>
				  <td class="text-left"><?php echo $tab_design; ?></td>
				  <td class="text-center">
				    <div class="input-checkbox">
				  	  <input type="checkbox" class="checkbox" name="mass_update_product_hide_design"<?php echo $mass_update_product_hide_design ? ' checked="checked"' : '' ?> id="mass_update_product_hide_design" />
					  <label for="mass_update_product_hide_design"></label>
				    </div>
				  </td>
			    </tr>
			  </body>
			</table>
		  </div>
		</div>
	  </div>
	</div>
  </form>
</div>
<div class="modal-footer">
  <div class="text-center"><a data-form="form-product-setting-edit-items" class="button-save btn btn-info btn-lg"><?php echo $button_save; ?></a></div>
</div>
<script src="view/javascript/mass_update/custom-scrollbar/slimscroll.min.js" type="text/javascript"></script>
<script type="text/javascript"><!--
$(function(){
    $('#body-product-setting-edit-items').slimScroll({
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
				$('#form-product-setting-edit-items').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
				
				$('.alert-danger').delay(1500).fadeOut(500);
			}
								
			if (json['success']) {
				$('#form-product-setting-edit-items').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');	
				
				setTimeout(function(){
					location.reload(true);
				}, 1000)
			}
		}
	});
});  
//--></script>