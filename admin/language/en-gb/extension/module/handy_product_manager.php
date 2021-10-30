<?php

/**
 * @category   OpenCart
 * @package    Handy Product Manager
 * @copyright  © Serge Tkach, 2018, http://sergetkach.com/
 */

// Heading
$_['heading_title'] = 'Handy Product Manager';

// Text
$_['text_extension']			 = 'Extensions';
$_['text_success']				 = 'Success: You have modified module settings!';
$_['text_edit']						 = 'Edit module settings';
$_['text_author']					 = 'Author';
$_['text_author_support']	 = 'Support';
$_['text_as_is']					 = 'Original filename in translit';
$_['text_by_formula']			 = 'According to the formula in translit';
$_['text_input_licence']	 = 'To access in the products list, you must activate the license on the page with the module settings';

// Button
$_['button_save']					 = 'Save';
$_['button_cancel']				 = 'Cancel';
$_['button_save_licence']	 = 'Save licence';

// Entry
$_['entry_status']										 = 'Status';
$_['entry_licence']										 = 'Licence code';
$_['entry_test_mode']									 = 'Enable logs (for developers only)';
$_['help_test_mode']									 = 'Logs help understand errors. Logs are recorded in the root directory of the site. Do not forget to turn off them after testing';

$_['fieldset_product_list']						 = 'Settings of product list';
$_['entry_product_list_field']				 = 'Enable fileds in the product list';
$_['entry_product_list_limit']				 = 'Product list limit items';
$_['entry_product_edit_model_require'] = 'Field "Model" is required';
$_['entry_product_edit_sku_require']	 = 'Filed "Sku" set required';

$_['fieldset_translit']				 = 'Settings for SEO URL';
$_['entry_transliteration']		 = 'Translit settings for SEO URL';
$_['entry_language_id']				 = 'Source language';
$_['entry_translit_function']	 = 'Transliteration rules';
$_['entry_translit_formula']	 = 'Translit formula for SEO URL of products';

$_['fieldset_upload']							 = 'Settings for image upload';
$_['entry_upload_rename_mode']		 = 'Photo naming rules';
$_['entry_upload_rename_formula']	 = 'Formula for rename photo';
$_['text_available_vars']					 = 'Available vars';
$_['entry_upload_max_size_in_mb']	 = 'Max filesize for upload in MB';
$_['entry_upload_mode']						 = 'Put images to folders';
$_['text_branch']									 = 'Branch folder "products" with numbers subfolders (1,2,3,..., n). Each subfolder can contain 100 files';
$_['text_dir_for_category']				 = 'Put image to folder with main category - need be SeoPro installed for follow main_category';

// Success
$_['success_licence'] = 'Success!';

// Error
$_['error_warning']									 = 'Somethis went wrong. Check all fields!';
$_['error_permission']							 = 'Warning: You do not have permission to modify this module!';
$_['error_licence']									 = 'Invalid licence code!';
$_['error_licence_empty']						 = 'Type licence code!';
$_['error_licence_not_valid']				 = 'Invalid licence code!';
$_['error_product_list_limit']			 = 'Products limit can\'t be empty!';
$_['error_product_list_limit_small'] = 'Products limit can\'t be less than 10!';
$_['error_product_list_limit_big']	 = 'Products limit can\'t be more than 500!';
$_['error_translit_formula_empry']	 = 'Type formula for transliteration!';
$_['error_rename_formula_empty']		 = 'Type formula for rename images';
$_['error_formula_less_vars']				 = 'Follow even 1 var in formula!';
$_['error_formula_pattern']				   = 'Follow in formula only available vars and char -';
$_['error_max_size_in_mb']					 = 'Type max filesize for image on upload';




/* For Column Left
  ----------------------------------------------------------------------------- */
$_['hpm_product'] = 'HPM — Products List';




/* For Product List
  ----------------------------------------------------------------------------- */
$_['hpm_title']					 = 'Products List — Handy Product Manager';
$_['hpm_heading_title']	 = 'Products List';

$_['hpm_filter_text_none']						 = '--- Not selected ---';
$_['hpm_filter_text_notset']					 = 'A! - Not indicated in product';
$_['hpm_filter_text_notset_category']	 = 'A! - Not indicated or is same as main catagory';
$_['hpm_filter_text_notset2']					 = 'A! - Not specified';
$_['hpm_filter_text_min']							 = 'From';
$_['hpm_filter_text_max']							 = 'Before';

$_['hpm_error_report_title'] = 'Error!';
$_['hpm_text_report_log']		 = 'reportModal should have been called on deferment';
$_['hpm_error_empty_post']	 = 'Data sent for live update turned out to be empty!';
$_['hpm_success']						 = 'Data processed successful!';

$_['hpm_upload_text_photo_main']		 = 'Upload main image';
$_['hpm_upload_text_drag_and_drop']	 = 'For uploade image, drug & drop image here';

$_['hpm_upload_error_no_category']			 = 'First select a product category, and then upload a photo';
$_['hpm_upload_error_no_category_main']	 = 'First select the main category fro product, and then upload a photo';
$_['hpm_upload_error_no_product_name']	 = 'Product name must be specified as used for rename image filename!';
$_['hpm_upload_error_no_model']					 = 'Model must be specified as used for rename image filename!';
$_['hpm_upload_error_no_sku']						 = 'Sku must be specified as used for rename image filename!';
$_['hpm_upload_error_result']						 = '(!) Error: file ([file]) could not be moved from temporary to [target]!';
$_['hpm_upload_error_max_size']					 = 'Size of ([file]) is more more than specified in the settings';
$_['hpm_upload_error_file_extenion']		 = 'File ([file]) has invalid extension';

$_['hpm_filter_entry_product_id']			 = 'Product ID (! eliminates others filters)';
$_['hpm_filter_entry_sku']						 = 'Sku (! eliminates others filters)';
$_['hpm_filter_entry_model']					 = 'Model (! eliminates others filters)';
$_['hpm_filter_entry_keyword']				 = 'SEO URL (! eliminates others filters)';
$_['hpm_filter_entry_category']				 = 'Belongs to the category';
$_['hpm_filter_entry_category_main']	 = 'Main category';
$_['hpm_filter_entry_attribute_value'] = 'Value <font class="hidden visible_lg-ib">of attribute</font>'; // span is reservet for help ic OC

$_['hpm_text_select_all']							 = 'Select All';
$_['hpm_text_unselect_all']						 = 'Unelect all';

$_['hpm_column_identity']			 = 'Identity';
$_['hpm_btn_generate_seo_url'] = 'Generate SEO URL';

$_['hpm_text_product_id']			 = 'Product ID';
$_['hpm_entry_main_category']	 = 'Select main category';
$_['hpm_text_product_new']		 = 'New item';
$_['hpm_entry_special']				 = 'Special price';
$_['hpm_entry_customer_group'] = 'Client group';
$_['hpm_entry_date_start']		 = 'Start';
$_['hpm_entry_date_end']			 = 'End';

$_['hpm_column_description']					 = 'Product Description';

$_['hpm_text_attribute_select']				 = 'Select attribute';
$_['hpm_text_attribute_edit']					 = 'Edit attribute';
$_['hpm_text_attribute_new']					 = 'New attribute';
$_['hpm_text_attribute_group_select']	 = 'Select attribute group';
$_['hpm_text_attribute_new_save']			 = 'Save';
$_['hpm_text_attribute_values_select'] = 'Select value';
$_['hpm_text_attribute_values_empty']	 = 'No values';

$_['hpm_text_option_select'] = 'Select option';
$_['hpm_text_option_edit']	 = 'Edit option';
$_['hpm_text_option_new']		 = 'New option';

$_['hpm_button_delete_product'] = 'Delete this product';
$_['hpm_button_delete_confirm'] = 'Confirm deleting';




/* Copy & Clone
  ----------------------------------------------------------------------------- */
$_['hpm_entry_products_row_number']				 = 'Quantity';
$_['hpm_entry_clone']											 = 'Mark for cloning';
$_['hpm_entry_clone_images']							 = 'Clone image also';
$_['hpm_help_clone_images']								 = 'Matter ONLY when cloning selected item';
$_['hpm_text_add_new_products_row']				 = 'Add product item';
$_['hpm_text_add_new_products_row_clone']	 = 'Clone product';

$_['hpm_text_view_product_in_catalog']		 = 'View product in catalog';
$_['hpm_text_edit_product_in_system_mode'] = 'Edit product <br>in system interface';
$_['text_success_delete']									 = 'Selected product was deleted!';
$_['text_error_add_new_tr']								 = 'Error on creating of the new product';

