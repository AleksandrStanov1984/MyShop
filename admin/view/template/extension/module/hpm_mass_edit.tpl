<?php // for Centos correct file association ?>
<?= $header ?><?= $column_left ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?= $mass_edit_title ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?= $breadcrumb['href'] ?>"><?= $breadcrumb['text'] ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?= $mass_edit_title ?></h3>
      </div>
      <div class="panel-body">
				<?php if (!$valid_licence) { ?>
				<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<?= $text_input_licence_mass ?>
				</div>
				<?php } else { ?>
				<!-- Mass Edit Filter . Begin -->
				<form action="" method="post" enctype="multipart/form-data" id="form-mass-edit" class="form-horizontal">
				<div class="well" style="">
					<div class="row">
						<div class="col-sm-3">

							<!-- Filter Select All Products -->
							<div class="col-sm-12">
								<div class="form-group">
									<label class="control-label text-warning">
										<input type="checkbox" name="mass_filter[select_all]" value="1" /> <?= $mass_entry_select_all ?>
									</label>
								</div>
							</div>

							<!-- Filter Main Category -->
							<?php if($has_main_category_column) { ?>
							<div class="le-row">
								<label class="le-label" for="mass-filter__main-category"><?= $hpm_entry_main_category ?></label>
								<select name="mass_filter[main_category_id]" class="form-control" id="mass-filter__main-category">
									<option value="0"><?= $text_none ?></option>
									<?php foreach ($all_categories as $category) { ?>
									<option value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
									<?php } ?>
								</select>
							</div>
							<br />
							<?php } ?>

							<!-- Filter Category -->
							<label class="control-label"><?= $mass_entry_category ?></label>
							<div id="mass-filter__categories-selector-container" class="categories-selector-container well well-sm" style="background: #fff; padding-top: 15px;">
								<div class="categories-selector">
									<?= $mass_filter_category_tree ?>
								</div>

								<!-- Filter Category Flag -->
								<div class="form-group">
									<div class="col-sm-12">
										<label id="mass-filter__category-flag" class="control-label"><?= $mass_entry_category_flag ?></label>
										<select name="mass_filter[category_flag]" id="mass-filter__category-flag" class="form-control">
											<option value="AND"><?= $text_flag_and_category ?></option>
											<option value="OR"><?= $text_flag_or_category ?></option>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="col-sm-2">
							<!-- Filter Manufacturer -->
							<div class="form-group" style="padding-bottom: 0;">
								<label class="control-label" for="mass-filter__manufacturer-input"><?= $mass_entry_manufacturer ?></label>
								<input type="text" name="mass_filter_manufaturer_input" value="" placeholder="<?= $mass_entry_manufacturer ?>" id="mass-filter__manufacturer-input" class="form-control" />
								<div id="mass-filter__manufacturer" class="well well-sm" style="height: 120px; overflow: auto; resize: vertical;"></div>
							</div>

							<!-- Filter Status -->
							<div class="form-group" style="border-top: none; padding-top: 0;">
                <label class="control-label" for="mass-filter__input-status"><?= $entry_status ?></label>
								<div class="input-group">
									<div class="input-group-addon"><i class="fa fa-hand-o-right"></i></div>
									<select name="mass_filter[status]" id="mass-filter__input-status" class="form-control">
										<option value="*" selected="selected"><?= $mass_text_none ?></option>
										<option value="1"><?= $text_enabled ?></option>
										<option value="0"><?= $text_disabled ?></option>
									</select>
								</div>
              </div>

							<!-- Filter Image -->
							<div class="form-group" style="border-top: none; padding-top: 0;">
                <label class="control-label" for="mass-filter__input-image"><?= $entry_image ?></label>
								<div class="input-group">
									<div class="input-group-addon"><i class="fa fa-image"></i></div>
									<select name="mass_filter[image]" id="mass-filter__input-image" class="form-control">
										<option value="*" selected="selected"><?= $mass_text_none ?></option>
										<option value="1"><?= $text_enabled ?></option>
										<option value="0"><?= $text_disabled ?></option>
									</select>
								</div>
              </div>

						</div>

						<div class="col-sm-3">
							<!-- Filter Attribute -->
							<div id="mass-filter__attributes">
								<div class="row" id="mass-filter__attribute-row-0">
									<div class="col-sm-5">
										<label class="control-label" for="mass-filter__attribute-0"><?= $mass_entry_attribute ?></label>
										<select name="mass_filter[attribute][0]" id="mass-filter__attribute-0" class="form-control mass-filter__attribute-select" data-row="0">
											<option value="*"><?= $mass_text_none ?></option>
											<?php foreach($attributes as $attribute) { ?>
											<option value="<?= $attribute['attribute_id'] ?>"><?= $attribute['attribute_group'] ?> -- <?= $attribute['name'] ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-sm-5">
										<label class="control-label" for="mass-filter__attribute-value-0"><?= $mass_entry_attribute_value ?></label>
										<select name="mass_filter[attribute_value][0]" id="mass-filter__attribute-value-0" class="form-control">
											<option value="*"><?= $mass_text_none ?></option>
										</select>
									</div>
									<div class="col-sm-2">
										<a type="button" class="mass-filter__btn-remove-attribute-row" data-parent-row="0" data-toggle="tooltip" title="<?= $button_remove ?>"><i class="fa fa-close"></i></a>
									</div>
								</div>
							</div>
							<button type="button" class="btn btn-sm btn-success mass-filter__btn-add-attribute-row" data-toggle="tooltip" title="<?= $button_add ?>" data-target-row="1" style="margin-top: 10px;"><i class="fa fa-plus"></i></button>

							<!-- Filter Option -->
							<div id="mass-filter__options">
								<div class="row" id="mass-filter__option-row-0">
									<div class="col-sm-10">
										<label class="control-label" for="mass-filter__input-option-0"><?= $mass_entry_option ?></label>
										<select name="mass_filter[option][0]" id="mass-filter__input-option-0" class="form-control mass-filter__option-select" data-row="0">
											<option value="*"><?= $mass_text_none ?></option>
											<?php foreach($options as $option) { ?>
											<option value="<?= $option['option_id'] ?>"><?= $option['name'] ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-sm-2">
										<a type="button" class="mass-filter__btn-remove-option-row" data-parent-row="0" data-toggle="tooltip" title="<?= $button_remove ?>"><i class="fa fa-close"></i></a>
									</div>
								</div>
							</div>
							<button type="button" class="btn btn-sm btn-success mass-filter__btn-add-option-row" data-toggle="tooltip" title="<?= $button_add ?>" data-target-row="1"><i class="fa fa-plus"></i></button>
						</div>

						<div class="col-sm-4">
							<!-- Filter Date -->
							<div class="form-group">
								<label><?= $mass_text_date ?></label>
								<div class="row">
									<div class="col-sm-6">
										<div class="input-group date">
											<input type="text" name="mass_filter[date_from]" value="" placeholder="<?= $mass_entry_date_from ?>" data-date-format="YYYY-MM-DD" id="mass-filter__input-date-from" class="form-control" />
											<span class="input-group-btn"><button class="btn btn-default btn-calendar" type="button"><i class="fa fa-calendar"></i></button></span>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="input-group date">
											<input type="text" name="mass_filter[date_before]" value="" placeholder="<?= $mass_entry_date_before ?>" data-date-format="YYYY-MM-DD" id="mass-filter__input-date-before" class="form-control" />
											<span class="input-group-btn"><button class="btn btn-default btn-calendar" type="button"><i class="fa fa-calendar"></i></button></span>
										</div>
									</div>
								</div>
							</div>

							<!-- Filter Price -->
							<div class="form-group" style="border-top: none; padding-top: 0;">
                <label class="control-label"><?= $entry_price ?></label>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="input-group">
											<div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                      <input type="text" name="mass_filter[price_min]" value="" placeholder="<?= $hpm_filter_text_min ?>" id="mass-filter__input-price-min" class="form-control" />
                      <div class="input-group-btn">
                        <button type="button" class="btn btn-default remove-filter" data-target="price_min"><i class="fa fa-close"></i></button>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="input-group">
											<div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                      <input type="text" name="mass_filter[price_max]" value="" placeholder="<?= $hpm_filter_text_max ?>" id="mass-filter__input-price-max" class="form-control" />
                      <div class="input-group-btn">
                        <button type="button" class="btn btn-default remove-filter" data-target="price_max"><i class="fa fa-close"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

							<!-- Filter Quantity -->
              <div class="form-group" style="border-top: none; padding-top: 0;">
                <label class="control-label"><?= $entry_quantity ?></label>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="input-group">
											<div class="input-group-addon"><i class="fa fa-clone"></i></div>
                      <input type="text" name="mass_filter[quantity_min]" value="" placeholder="<?= $hpm_filter_text_min ?>" id="mass-filter__input-quantity-min" class="form-control" />
                      <div class="input-group-btn">
                        <button type="button" class="btn btn-default remove-filter" data-target="quantity_min"><i class="fa fa-close"></i></button>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="input-group">
											<div class="input-group-addon"><i class="fa fa-clone"></i></div>
                      <input type="text" name="mass_filter[quantity_max]" value="" placeholder="<?= $hpm_filter_text_max ?>" id="mass-filter__input-quantity-max" class="form-control" />
                      <div class="input-group-btn">
                        <button type="button" class="btn btn-default remove-filter" data-target="quantity_max"><i class="fa fa-close"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

						</div>

					</div>
				</div>
				<!-- Mass Edit Filter . End -->

				<!-- Mass Edit Editor . Begin -->
				<div class="row ">
					<div class="col-sm-12">
						<table id="products-list" class="products-list le table table-bordered table-hover" >
							  <thead>
									<tr>
										<td class="text-left" style="width: 200px"><?= $hpm_column_identity ?></td>
										<td class="text-left" style="width: 500px"><?= $hpm_column_description ?></td>
										<td class="text-left"><?= $tab_attribute ?></td>
										<td class="text-left"><?= $tab_option ?></td>
									</tr>
								</thead>
								<!-- table body -->
								<tbody>
									<tr>
										<!-- Identity -->
										<td id="identity" class="identity text-left">
											<!-- Category -->
											<div class="category">
												<?php if($has_main_category_column) { ?>
												<div class="le-row">
													<label class="le-label" for="input-main-category"><?= $hpm_entry_main_category ?></label>
													<select name="main_category_id" class="le-value _simple-value le-selector" id="input-main-category">
														<option value="0"><?= $text_none ?></option>
														<?php foreach ($all_categories as $category) { ?>
														<option value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
														<?php } ?>
													</select>
												</div>
												<br />
												<?php } ?>

												<label class="control-label" for="input-category"><?= $mass_entry_category ?></label>
												<div id="categories-selector-container" class="categories-selector-container well well-sm" style="padding-top: 15px;">
													<div class="categories-selector" >
														<?= $category_tree ?>
													</div>
													<!-- Category Flag -->
													<div class="form-group">

														<div class="col-sm-12">
															<label class="control-label" for="input-category-flag"><?= $entry_category_flag ?></label>
															<select name="category_flag" id="input-category-flag" class="le-value le-selector">
																<!-- <option value="*"><?= $entry_flag ?></option> -->
																<option value="add"><?= $text_flag_add ?></option>
																<option value="reset_add"><?= $text_flag_reset_add ?></option>
															</select>
														</div>
													</div>
												</div>
											</div>
											<div id="identity-content" class="identity-content" >
												<div class="le-row">
													<label class="le-label" for="manufacturer"><?= $entry_manufacturer ?></label>
													<select name="manufacturer_id" class="le-value _simple-value le-selector" id="manufacturer">
														<option value=""><?= $text_none ?></option>
														<?php foreach($manufacturers as $manufacturer) { ?>
														<option value="<?= $manufacturer['manufacturer_id'] ?>"><?= $manufacturer['name'] ?></option>
														<?php } ?>
													</select>
												</div>

												<!-- Price -->
												<div class="box-custom box-custom__price">
													<div class="le-row">
														<span class="le-label"><?= $entry_price ?></span>
														<input type="text" name="price" id="price" class="le-value _simple-value _price" value="" />
													</div>
													<!-- Custom Fields - With Price -->
													<?php if (count($a_product_list_field_custom_price) > 0) { ?>
													<?php foreach($a_product_list_field_custom_price as $key => $value) { ?>
													<div class="le-row">
														<span class="le-label"><?= $a_product_list_field_custom_price[$key]['description'][$config_language_id] ?></span>
														<input type="text" name="<?= $key ?>" id="custom-<?= $key ?> " class="le-value _simple-value _price" value="" />
													</div>
													<?php } ?>
													<?php } ?>
												</div>

												<!-- Points -->
												<?php if (isset($a_product_list_field['points'])) { ?>

												<div class="product-reward well well-sm">
													<div class="le-row" style="border-bottom: 1px solid #ccc; padding-bottom: 10px;">
														<span class="le-label"><?= $entry_points ?></span>
														<input type="text" name="points" id="input-points" class="le-value _simple-value" value="" />
													</div>
													<!-- Product Reward -->
													<?php foreach ($customer_groups as $customer_group) { ?>
													<div class="le-row">
														<span class="le-label"><?= $customer_group['name'] ?></span>
														<input type="text" name="product_reward[<?= $customer_group['customer_group_id'] ?>][points]" id="input-product-reward-<?= $customer_group['customer_group_id']  ?>" class="le-value" value="" />
													</div>
													<?php } ?>
												</div>

												<?php } ?>

												<!-- Status -->
												<div class="le-row">
													<span class="le-label"><?= $entry_status ?></span>
													<select name="status" id="input-status" class="le-value _simple-value le-selector">
														<option value="*" selected="selected"><?= $text_none ?></option>
														<option value="1"><?= $text_enabled ?></option>
														<option value="0"><?= $text_disabled ?></option>
													</select>
												</div>

												<?php if ('OpenCart.PRO' == $hpm_system) { ?>

												<div class="le-row">
													<span class="le-label"><?= $entry_noindex ?></span>
													<select name="noindex" id="input-noindex" class="le-value _simple-value le-selector">
														<option value="*" selected="selected"><?= $text_none ?></option>
														<option value="1"><?= $text_enabled ?></option>
														<option value="0"><?= $text_disabled ?></option>
													</select>
												</div>

												<?php } ?>

												<!-- Quantity -->
												<div class="le-row">
													<span class="le-label"><?= $entry_quantity ?></span>
													<input type="text" name="quantity" id="quantity" class="le-value _simple-value" />
												</div>

												<!-- Minimum -->
												<?php if (isset($a_product_list_field['minimum'])) { ?>
												<div class="le-row">
													<span class="le-label"><?= $entry_minimum ?></span>
													<input type="text" name="minimum" id="minimum" class="le-value _simple-value" />
												</div>
												<?php } ?>

												<!-- Weight -->
												<?php if (isset($a_product_list_field['weight'])) { ?>
												<div class="le-row">
													<span class="le-label"><?=$entry_weight?></span>
													<input type="text" name="weight"class="le-value _simple-value" />
												</div>
												<?php } ?>

												<!-- Weight Class -->
												<?php if (isset($a_product_list_field['weight_class'])) { ?>
												<div class="le-row">
													<span class="le-label"><?= $entry_weight_class ?></span>
													<select name="weight_class_id" id="input-weight-class" class="le-value _simple-value le-selector">
														<option value="*" selected="selected"><?= $text_none ?></option>
														<?php foreach ($weight_classes as $weight_class) { ?>
														<option value="<?= $weight_class['weight_class_id'] ?>"><?= $weight_class['title'] ?></option>
														<?php } ?>
													</select>
												</div>
												<?php } ?>

												<!-- Stock Status -->
												<?php if (isset($a_product_list_field['stock_status'])) { ?>
												<div class="le-row">
													<span class="le-label"><?= $entry_stock_status ?></span>
													<select name="stock_status_id" id="input-stock-status" class="le-value _simple-value le-selector">
														<option value="*" selected="selected"><?= $text_none ?></option>
														<?php foreach ($stock_statuses as $stock_status) { ?>
														<option value="<?= $stock_status['stock_status_id'] ?>"><?= $stock_status['name'] ?></option>
														<?php } ?>
													</select>
												</div>
												<?php } ?>

												<!-- Subtract -->
												<div class="le-row">
													<span class="le-label"><?= $entry_subtract ?></span>
													<select name="subtract" id="input-subtract" class="le-value _simple-value le-selector">
														<option value="*" selected="selected"><?= $text_none ?></option>
														<option value="1"><?= $text_yes ?></option>
														<option value="0"><?= $text_no ?></option>
													</select>
												</div>

												<!-- Shipping -->
												<div class="le-row">
													<span class="le-label"><?= $entry_shipping ?></span>
													<select name="shipping" id="input-shipping" class="le-value _simple-value le-selector">
														<option value="*" selected="selected"><?= $text_none ?></option>
														<option value="1"><?= $text_yes ?></option>
														<option value="0"><?= $text_no ?></option>
													</select>
												</div>


												<!-- Date Available -->
												<div class="le-row">
													<div class="date">
														<span class="le-label"><?= $entry_date_available ?></span>
														<input type="text" name="date_available" id="date_available" class="le-value _simple-value" data-date-format="YYYY-MM-DD" />
														<span class="input-group-btn"><button class="btn-calendar" type="button"><i class="fa fa-calendar"></i></button></span>
													</div>
												</div>

												<?php if (isset($a_product_list_field['discount'])) { ?>
												<!-- discount -->
												<br>
												<div class="le-row">
													<span class="le-label discount-price"><?= $hpm_entry_discount ?></span>
													<label>
														<input type="checkbox" name="discount[flag_clear]" value="1" />
														<?= $text_flag_discount_clear ?>
													</label><br>
													<div class="discount well well-sm">
														<?php $discount_row = 0; ?>
														<div class="discount-container" id="discount-container">

														</div>
														<button type="button" class="btn btn-sm btn-success btn-add-discount" data-toggle="tooltip" title="<?= $button_add ?>" data-target="#discount-row-<?= $discount_row ?>" data-discount-row="<?= $discount_row ?>"><i class="fa fa-plus"></i></button>
													</div>
												</div>
												<?php } ?>

												<?php if (isset($a_product_list_field['special'])) { ?>
												<!-- special -->
												<div class="le-row">
													<span class="le-label special-price"><?= $hpm_entry_special ?></span>
													<label>
														<input type="checkbox" name="special[flag_clear]" value="1" />
														<?= $text_flag_special_clear ?>
													</label><br>
													<div class="special well well-sm">
														<?php $special_row = 0; ?>
														<div class="special-container" id="special-container">

														</div>
														<button type="button" class="btn btn-sm btn-success btn-add-special" data-toggle="tooltip" title="<?= $button_add ?>" data-target="#special-row-<?= $special_row ?>" data-special-row="<?= $special_row ?>"><i class="fa fa-plus"></i></button>
													</div>
												</div>
												<?php } ?>

												<?php if (isset($a_product_list_field['store'])) { ?>
												<div id="input-store"  class="input-store well well-sm" style="height: 150px; overflow: auto;">
													<span class="le-label"><?= $entry_store ?></span>
													<div class="checkbox" style="float: left; width: calc(100% - 100px); padding-top: 0; margin-top: 0;">
														<label>
															<input type="checkbox" name="product_store[]" value="0" />
															<?= $text_default ?>
														</label><br>
														<?php foreach ($stores as $store) { ?>
														<label>
															<input type="checkbox" name="product_store[]" value="<?=$store['store_id']?>" />
															<?= $store['name'] ?>
														</label><br>
													<?php } ?>
													</div>
												</div>
												<?php } ?>
											</div>
										</td>
										<!-- Description -->
										<td id="description" class="description text-left <?= !isset($a_product_list_field['attribute']) && !isset($a_product_list_field['option']) ? 'prevent-wide-images__description' : '' ?>">
												<?php foreach ($languages as $language) { ?>
												<div class="description-language-row">
													<div class="language-icon"><img src="language/<?= $language['code'] ?>/<?= $language['code'] ?>.png" title="<?= $language['name'] ?>"  /></div>
													<div class="description-content" data-language-id="<?= $language['language_id'] ?>">
														<!-- Name -->
														<div class="le-row">
															<span class="le-label"><?= $entry_name ?></span>
															<textarea id="name-<?= $language['language_id'] ?>" name="description[<?= $language['language_id'] ?>][name]" cols="5" rows="5" class="le-value"></textarea>
															<div class="vars"><span class="vars-label"><?= $text_available_vars ?>:</span> <span class="vars-value">[manufacturer_name] [sku] [model]</span></div>
														</div>
														<!-- H1 -->
														<?php if($h1) { ?>
														<div class="le-row">
															<?php $eh1 = 'entry_' . $h1; ?>
															<span class="le-label"><?= $$eh1 ?></span>
															<textarea id="<?= $h1 ?>-<?= $language['language_id'] ?>" name="description[<?= $language['language_id'] ?>][<?= $h1 ?>]" cols="5" rows="5" class="le-value _<?= $h1 ?>"></textarea>
															<div class="vars"><span class="vars-label"><?= $text_available_vars ?>:</span> <span class="vars-value">[product_name] [manufacturer_name] [sku] [model]</span></div>
														</div>
														<?php } ?>
														<!-- Meta Title -->
														<div class="le-row">
															<span class="le-label"><?= $entry_meta_title ?></span>
															<textarea id="meta-title-<?= $language['language_id'] ?>" name="description[<?= $language['language_id'] ?>][meta_title]" cols="5" rows="5" class="le-value _meta-title"></textarea>
															<div class="vars"><span class="vars-label"><?= $text_available_vars ?>:</span> <span class="vars-value">[product_name] [manufacturer_name] [sku] [model]</span></div>
														</div>
														<!-- Meta Description -->
														<div class="le-row">
															<span class="le-label"><?= $entry_meta_description ?></span>
															<textarea id="meta-description-<?= $language['language_id'] ?>" name="description[<?= $language['language_id'] ?>][meta_description]" cols="5" rows="5" class="le-value _meta-description"></textarea>
															<div class="vars"><span class="vars-label"><?= $text_available_vars ?>:</span> <span class="vars-value">[product_name] [manufacturer_name] [sku] [model]</span></div>
														</div>
														<!-- Meta Keyword -->
														<div class="le-row">
															<span class="le-label"><?= $entry_meta_keyword ?></span>
															<textarea id="meta-keyword-<?= $language['language_id'] ?>" name="description[<?= $language['language_id'] ?>][meta_keyword]" cols="5" rows="5" class="le-value"></textarea>
															<div class="vars"><span class="vars-label"><?= $text_available_vars ?>:</span> <span class="vars-value">[product_name] [manufacturer_name] [sku] [model]</span></div>
														</div>
														<!-- Tag -->
														<div class="le-row">
															<span class="le-label"><?= $entry_tag ?></span>
															<textarea id="tag-<?= $language['language_id'] ?>" name="description[<?= $language['language_id'] ?>][tag]" cols="5" rows="5" class="le-value _tag"></textarea>
														</div>
														<!-- Description -->
														<div class="le-row">
															<span class="le-label"><?= $entry_description ?></span>
															<textarea id="description-<?= $language['language_id'] ?>" name="description[<?= $language['language_id'] ?>][description]" cols="5" rows="25" class="le-value tinymce" style="height: 400px;"></textarea>
															<div class="vars"><span class="vars-label"><?= $text_available_vars ?>:</span> <span class="vars-value">[product_name] [manufacturer_name] [sku] [model]</span></div>
														</div>
													</div>
												</div>
												<?php } ?>
										</td>

										<!-- Attribute -->
										<td id="attributes" class="attributes">
											<!-- Attribute Flag -->
											<div class="form-group">
												<div class="col-sm-12">
													<select name="attribute_flag" id="input-attribute-flag" class="le-value le-selector">
														<option value="add"><?= $text_flag_add ?></option>
														<option value="reset_add"><?= $text_flag_reset_add ?></option>
													</select>
												</div>
											</div>

											<?php $attribute_row = 0; ?>
											<div class="attributes-container" id="attributes-container">

											</div>
											<button type="button" class="btn btn-sm btn-success btn-add-attribute" data-toggle="tooltip" title="<?= $button_add ?>" data-target="#attributes-container" data-target-row="<?= $attribute_row ?>"><i class="fa fa-plus"></i></button>
										</td>

										<!-- Option -->
										<td id="options" class="options">

											<!-- Option Flag -->
											<div class="form-group">
												<div class="col-sm-12">
													<select name="option_flag" id="input-option-flag" class="le-value le-selector">
														<option value="add"><?= $text_flag_add ?></option>
														<option value="reset_add"><?= $text_flag_reset_add ?></option>
													</select>
												</div>
											</div>

											<?php $option_row = 0; ?>
											<div class="options-container" id="options-container">

											</div>
											<button type="button" class="btn btn-sm btn-success btn-add-option" data-toggle="tooltip" title="<?= $button_add ?>" data-target="#options-container"  data-target-row="<?= $option_row ?>"><i class="fa fa-plus"></i></button>
										</td>
									</tr>
								</tbody>
						</table>
						<div id="request-answer"></div>
					</div>
				</div>
				<!-- Mass Edit Editor . End -->

				<!-- Mass Edit Button . Begin -->
				<div class="row ">
					<div class="col-sm-12">
						<div class="pull-right">
							<button id="mass-edit-submit" data-toggle="tooltip" title="<?= $button_execute ?>" class="btn btn-primary"><i class="fa fa-paper-plane-o"></i> <?= $button_execute ?></button>
						</div>
					</div>
				</div>
				<!-- Mass Edit Button . End -->
				</form>
				<?php } ?>
      </div>
    </div>
    <div class="copywrite" style="padding: 10px 10px 0 10px; border: 1px dashed #ccc;">
    	<p>
    		&copy; <?= $text_author ?>: <a href="http://sergetkach.com/link/272" target="_blank">Serge Tkach</a>
    		<br/>
				<?= $text_author_support ?>: <a href="mailto:sergheitkach@gmail.com">sergheitkach@gmail.com</a>
    	</p>
    </div>
  </div>
</div>

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
  allowed = (((allowed || '') + '').toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('')

  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi
  var commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi

  return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
    return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : ''
  })
}

tinymce.init({
	selector: '.tinymce',
	skin: 'bootstrap',
	language: 'ru',
	height:300,
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
			$('#' + e.target.id).val(editor.getContent().split('&nbsp;').join(''));
			$('#' + e.target.id).trigger('change');
		});
	}
});

</script>

<script type="text/javascript">
function initButtonCalendar() {
  $('.date').datetimepicker({
    pickTime: false,
  }).on('dp.change', function (e) {
    $(e.currentTarget).children('.le-value').trigger('change');
  });
}

initButtonCalendar();

//$('.date .btn-calendar').datetimepicker({
//	pickTime: false,
//}).on('dp.change', function (e) {
//  //var formatedValue = e.date.format("YYYY-MM-DD");
//  //$(e.currentTarget).children('.le-value').val(formatedValue);
//  $(e.currentTarget).children('.le-value').trigger('change');
//});
//
//$('.time').datetimepicker({
//	pickDate: false
//});
//
//$('.datetime').datetimepicker({
//	pickDate: true,
//	pickTime: true
//});

</script>

<?php include DIR_APPLICATION . 'view/template/extension/module/hpm_mass_edit_js.tpl'; ?>
<?= $footer ?>
