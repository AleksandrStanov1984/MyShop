<?php

// Heading
$_['heading_title'] = '<img width="24" height="24" src="view/image/neoseo.png" style="float: left;"><span style="margin:0;line-height 24px;">NeoSeo Multi Export</span>';
$_['heading_title_raw'] = 'NeoSeo Multi Export';

//Tab
$_['tab_general'] = 'General';
$_['tab_feeds'] = 'Exports';
$_['tab_formats'] = 'Formats';
$_['tab_fields'] = 'Fields';
$_['tab_logs'] = 'Logs';
$_['tab_license'] = 'License';
$_['tab_support'] = 'Support';

//Button
$_['button_clear_log'] = 'Clear Log';
$_['button_save'] = 'Save';
$_['button_save_and_close'] = 'Save and Close';
$_['button_close'] = 'Close';
$_['button_recheck'] = 'Recheck';
$_['button_download_log'] = 'Download log file';

// Text
$_['text_module_version'] = '';
$_['text_module'] = 'Modules';
$_['text_success'] = 'Module settings updated!';
$_['text_success_delete'] = 'The export record was successfully deleted!';
$_['text_success_delete_format'] = 'The format record was successfully deleted!';
$_['text_success_clear'] = 'The log file has been successfully cleared!';
$_['text_new_feed'] = 'New export';
$_['text_del_feed'] = 'Remove export';
$_['button_clear_log'] = 'Clear Log';
$_['text_feed'] = 'Promotion channels';
$_['text_success_options'] = 'Module settings updated!';
$_['text_success'] = 'Module settings updated!';
$_['text_select_all'] = 'Select all';
$_['text_unselect_all'] = 'Remove selection';
$_['text_bigmir'] = 'bigmir';
$_['text_hotline'] = 'hotline.ua';
$_['text_prom'] = 'prom.ua';
$_['text_yml'] = 'YML';
$_['text_custom'] = 'Reserved';
$_['text_google'] = 'google merchant';
$_['text_link'] = 'On request';
$_['text_cron'] = 'On schedule';
$_['text_description'] = '<p>Description</p>';
$_['text_list'] = 'List of exports';
$_['text_list_format'] = 'List of formats';
$_['text_edit'] = 'Export editing';
$_['text_add'] = 'Adding an Export';
$_['text_edit_format'] = 'Editing the Format';
$_['text_add_format'] = 'Adding a Format';
$_['text_none'] = 'Built-in';

// Entry
$_['entry_status'] = 'Status';
$_['entry_id_format'] = 'Format';
$_['entry_format'] = 'Format';
$_['entry_debug'] = 'Debugging';
$_['entry_type'] = 'Export Formation';
$_['entry_cron'] = 'CRON';
$_['entry_field_list_name'] = 'Template variable';
$_['entry_field_list_desc'] = 'Description';
$_['entry_feed_format_name'] = 'Format';
$_['entry_format_xml'] = 'XML code';
$_['entry_feed_name'] = 'Export';
$_['entry_feed_name_desc'] = 'The name of the export will be displayed in the exporters';
$_['entry_feed_shortname'] = '<label class="control-label">File name</label><br>It will be displayed in the URL on which the export will be available';
$_['entry_feed_status'] = 'Export status';
$_['entry_feed_status_desc'] = 'Disabling will block export both on request and on schedule';
$_['entry_data_feed'] = 'Address';
$_['entry_shopname'] = 'Name of shop';
$_['entry_shopname_desc'] = 'Short name of the store (the name that appears in the list of found goods, it should not contain more than 20 characters)';
$_['entry_company'] = 'Company';
$_['entry_company_desc'] = 'Full name of the company owning the store. It is not published, it is used for internal identification';
$_['entry_categories'] = '<label class="control-label">Categories</label><br>Mark the categories from which you want to export sentences';
$_['entry_manufacturers'] = '<label class="control-label">Производители</label><br>Mark the producers from which you want to export the proposals';
$_['entry_currency'] = '<label class="control-label">Currency of offers</label><br>Recalculation will be performed at the rate set in the admin panel';
$_['entry_out_of_stock'] = 'Status &quot; Out of stock&quot;';
$_['entry_out_of_stock_desc'] = 'Price aggregators require that they be unloaded only the goods in stock. And for this purpose we screen out goods that are off or have zero balance. But sometimes the zero balance is not an indicator, but the real indicator is the status of the goods. In this field you specify the value of this status so that we understand that if the remainder of 0 and the status of the goods are such as indicated here, then the product is not available with a probability of 146%';
$_['entry_ip_list'] = '<label class="control-label">List of trusted ip-addresses</label><br>Specify your personal IP address and IP address server of the price-aggregator so that no one else has access to your products';
$_['entry_image_width'] = '<label class="control-label">Product picture width</label><br>Measured in pixels, the recommended value is 600';
$_['entry_image_height'] = '<label class="control-label">Item picture height</label><br>Measured in pixels, the recommended value is 600';
$_['entry_pictures_limit'] = '<label class="control-label">Max. number of pictures</label><br>Most often, aggregators take no more than 10 pictures per product. Specify here the restriction that the price aggregator does not fall into error';
$_['entry_delivery_status'] = 'Delivery';
$_['entry_delivery_status_desc'] = 'Turn on if there is your store delivering';
$_['entry_pickup_status'] = 'Pickup';
$_['entry_pickup_status_desc'] = 'Turn it on if you have self-delivery points';
$_['entry_store_status'] = 'Store';
$_['entry_store_status_desc'] = 'Enable if you have offline stores';
$_['entry_language_id'] = '<label class="control-label">Export Language </label> <br> Specify the language for the description of the goods and categories';
$_['entry_feed_demand'] = 'Link';
$_['entry_feed_cron'] = 'Link';
$_['entry_product_id'] = 'Where to get the product code';
$_['entry_product_id_desc'] = 'Default - product_id.';
$_['entry_product_name'] = 'Where to get the name of the product';
$_['entry_product_name_desc'] = 'Default - name.';
$_['entry_product_desc'] = 'Where to get the product description';
$_['entry_product_desc_desc'] = 'Default - description.';
$_['entry_product_vendor'] = 'Where to get the manufacturer\'s code';
$_['entry_product_vendor_desc'] = 'Default - sku.';
$_['entry_attribute_status'] = 'Unload attributes';
$_['entry_option_status'] = 'Unload with options';
$_['entry_generate'] = 'Image Cache Generation';
$_['entry_generate_desc'] = 'You can accelerate the formation of unloading if you pre-form all the caches of images';
$_['entry_feed_action'] = 'Action';
$_['entry_use_original_images'] = '<label class="control-label">Use Original Images</label>';
$_['entry_sql_code'] = '<label class="control-label">SQL for fine tuning</label><br>Specify any SQL expression using the p prefix. <br> "For example p.price> 100 or p.price> 100 and p.quantity> 0"';
$_['entry_use_main_category'] = '<label class="control-label">Use the main category</label>';
$_['entry_use_main_category_desc'] = 'Use the "Main Category" field instead of "Show in categories"';
$_['entry_use_categories'] = '<label class="control-label">Categories used</label>';
$_['entry_sql_code_before'] = '<label class="control-label">SQL for data preparation </label> <br> Specify a series of SQL queries that will be executed before the data is generated.';
$_['entry_store'] = 'Store';
$_['entry_use_warehouse_quantity'] = 'Use quantity of goods by warehouses';
$_['entry_warehouse'] = '<label class="control-label">Warehouses</label><br>Mark the stores from which you need to take the rest of the offer. If several warehouses are selected, the balance will be added together.';

//Success
$_['success_update_product_feed_categories'] = 'The links of the goods with the multi-export categories have been updated!';

// Error
$_['error_permission'] = 'You do not have the rights to manage the NeoSeo module Multi Export!';
$_['error_download_logs'] = 'The log file is empty or missing!';

//fields_desc
$_['field_desc_date'] = 'Date of export. By default, the current date';
$_['field_desc_url'] = 'URL address to which export is available';
$_['field_desc_currency'] = 'Offer currency (set on the exports tab)';
$_['field_desc_categories'] = 'Array of export categories';
$_['field_desc_category'] = 'Array of the export category';
$_['field_desc_category.id'] = 'Category ID';
$_['field_desc_category.parentId'] = 'Parent category ID';
$_['field_desc_category.name'] = 'Name of category';
$_['field_desc_offers'] = 'Array of export goods';
$_['field_desc_offer'] = 'The export commodity array';
$_['field_desc_offer.id'] = 'Export ID';
$_['field_desc_offer.url'] = 'Product URL';
$_['field_desc_offer.price'] = 'The price of the product';
$_['offer.currencyId'] = 'Currency of goods (set on the tab exports)';
$_['offer.categoryId'] = 'Product Category Id is';
$_['offer.name'] = 'Name of product';
$_['offer.description'] = 'Product description';
$_['offer.model'] = 'Product Model';
$_['offer.vendor'] = 'Seller of the goods';
$_['offer.vendorCode'] = 'Merchant ID';
$_['offer.image'] = 'Array of links to product images';
$_['image'] = 'Link to product image';
$_['offer.options'] = 'Array of product options';
$_['option'] = 'Array of product options';
$_['option.name'] = 'Item option name';
$_['option.value'] = 'Item option value';
$_['option.available'] = 'Product availability';
$_['offer.attributes'] = 'Array of product attributes';
$_['attribute'] = 'Array of product attribute';
$_['attributes.name'] = 'Attribute Name';
$_['attributes.value'] = 'Attribute Value';

$_['error_ioncube_missing'] = '';
$_['error_license_missing'] = '';
$_['mail_support'] = '';
$_['module_licence'] = '';
$_['text_module_version']='59';
$_['error_license_missing']='<h3 style = "color: red"> Missing file with key! </h3>

<p> To obtain a file with a key, contact NeoSeo by email <a href="mailto:license@neoseo.com.ua"> license@neoseo.com.ua </a>, with the following: </p>

<ul>
	<li> the name of the site where you purchased the module, for example, https://neoseo.com.ua </li>
	<li> the name of the module that you purchased, for example: NeoSeo Sharing with 1C: Enterprise </li>
	<li> your username (nickname) on this site, for example, NeoSeo</li>
	<li> order number on this site, e.g. 355446</li>
	<li> the main domain of the site for which the key file will be activated, for example, https://neoseo.ua</li>
</ul>

<p>Put the resulting key file at the root of the site, that is, next to the robots.txt file and click the "Check again" button.</p>';
$_['error_ioncube_missing']='<h3 style="color: red">No IonCube Loader! </h3>

<p>To use our module, you need to install the IonCube Loader.</p>

<p>For installation please contact your hosting TS</p>

<p>If you can not install IonCube Loader yourself, you can also ask for help from our specialists at <a href="mailto:support@neoseo.com.ua"> support@neoseo.com.ua </a> </p>';
$_['module_licence']='<h2>NeoSeo Software License Terms</h2>
<p>Thank you for purchasing our web studio software.</p>
<p>Below are the legal terms that apply to anyone who visits our site and uses our software products or services. These Terms and Conditions are intended to protect your interests and interests of LLC NEOSEO and its affiliated entities and individuals (hereinafter referred to as "we", "NeoSeo") acting in the agreements on its behalf.</p>
<p><strong>1. Introduction</strong></p>
<p>These Terms of Use of NeoSeo (the "Terms of Use"), along with additional terms that apply to a number of specific services or software products developed and presented on the NeoSeo website (s), contain terms and conditions that apply to each and every one of them. the visitor or user ("User", "You" or "Buyer") of the NeoSeo website, applications, add-ons and components offered by us along with the provision of services and the website, unless otherwise noted (all services and software, software Modules offered through the NeoSeo website or auxiliary servers Isa, web services, etc. Applications on behalf NeoSeo collectively referred to as - "NeoSeo Service" or "Services").</p>
<p>NeoSeo Terms are a binding contract between NeoSeo and you - so please carefully read them.</p>
<p>You may visit and/or use the NeoSeo Services only if you fully agree to the NeoSeo Terms: By using and/or signing up to any of the NeoSeo Services, you express and agree to these Terms of Use and other NeoSeo terms, for example, provide programming services in the context of typical and non-typical tasks that are outlined here: <a href = "https://neoseo.com.ua/vse-chto-nujno-znat-klienty "target ="_blank" class ="external"> https://neoseo.com.ua/vse-chto-nujno-znat-klienty </a>, (hereinafter the NeoSeo Terms).</p>
<p>If you are unable to read or agree to the NeoSeo Terms, you must immediately leave the NeoSeo Website and not use the NeoSeo Services.</p>
<p>By using our Software products, Services, and Services, you acknowledge that you have read our Privacy Policy at <a href = "https://neoseo.com.ua/policy-konfidencialnosti "target ="_blank " class ="external"> https://neoseo.com.ua/politika-konfidencialnosti </a> (" Privacy Policy ")</p>
<p>This document is a license agreement between you and NeoSeo.</p>
<p>By agreeing to this agreement or using the software, you agree to all these terms.</p>
<p>This agreement applies to the NeoSeo software, any fonts, icons, images or sound files provided as part of the software, as well as to all NeoSeo software updates, add-ons or services, if not applicable to them. miscellaneous. This also applies to NeoSeo apps and add-ons for the SEO-Store, which extend its functionality.</p>
<p>Prior to your use of some of the application features, additional NeoSeo and third party terms may apply. For the correct operation of some applications, additional agreements are required with separate terms and conditions of privacy, for example, with services that provide SMS-notification services.</p>
<p>Software is not sold, but licensed.</p>
<p>NeoSeo retains all rights (for example, the rights provided by intellectual property laws) that are not explicitly granted under this agreement. For example, this license does not entitle you to:</p>
<li> <span> </span> <span> </span> separately use or virtualize software components; </li>
<li> publish or duplicate (with the exception of a permitted backup) software, provide software for rental, lease or temporary use; </li>
<li> transfer the software (except as provided in this agreement); </li>
<li> Try to circumvent the technical limitations of the software; </li>
<li> study technology, decompile or disassemble the software, and make appropriate attempts, other than those to the extent and in cases where (a) it provides for the right; (b) authorized by the terms of the license to use the components of the open source code that may be part of this software; (c) necessary to make changes to any libraries licensed under the small GNU General Public License, which are part of the software and related; </li>
<p> You have the right to use this software only if you have the appropriate license and the software was properly activated using the genuine product key or in another permissible manner.
</p>
<p> The cost of the SEO-Shop license does not include installation services, settings, and more of its stylization, as well as other paid/free add-ons. These services are optional, the cost depends on the number of hours required for the implementation of the hours, here: <a href = "https://neoseo. com.ua/vse-chto-nujno-znat-klienty "target =" _ blank "class =" external "> https://neoseo.com.ua/vse-chto-nujno-znat-klienty </a>
</p>
<p> The complete version of the document can be found here:
</p>
<p> <a href="https://neoseo.com.ua/usloviya-licenzionnogo-soglasheniya" target="_blank" class="external"> https://neoseo.com.ua/usloviya-licenzionnogo-soglasheniya </a>
</p>';
$_['mail_support']='<h2>Terms of free and paid information and technical support in <a class="external" href="https://neoseo.com.ua/" target="_blank"> NeoSeo</a>.</h2>

<p>Since we are confident that any quality work must be paid, all consultations requiring preliminary preparation of the answer, pay, including and case studies: &quot; look, and why your module is not working here? &quot;</p>

<p>If the answer to your question is already ready, you will receive it for free. But if you need to spend time answering the question, studying files, finding a bug and analyzing it, then we&#39;ll ask you to make a payment before you can answer.</p>

<p>We are <strong>helping to install</strong> and <strong> fix bugs when installing </strong>our modules in our order.</p>

<p>For any questions, please contact support@neoseo.com.ua.</p>

<p>See the full version of the license agreement here:<strong> </strong><a class="external" href="https://neoseo.com.ua/usloviya-licenzionnogo-soglasheniya" target="_blank"> https://neoseo.com .ua/usloviya-licenzionnogo-soglasheniya</a></p>

<p><strong>A review spell bonus!</strong></p>

<p>Dear buyer, in order to make our software products even better and you get even more, please leave feedback on our product or collaboration with our web studio on our Facebook, Google, Yandex and OpenCartForum.com pages.</p>

<p>- Write as it is, it&#39;s important for us to hear an honest and relevant assessment of our decision.</p>

<p><<strong>Links to our modules and profiles:</strong></p>

<ul>
    <li>Company profile on Opencartforum <a class="external" href="https://opencartforum.com/topic/41195-neoseo/?page=5" target="_blank"> https://opencartforum.com/topic/41195-neoseo/? page = 5</a></li>
    <li><a class="external" href="https://www.facebook.com/neoseo.com.ua/" target="_blank">Facebook</a> click here: <a class="internal" href="https://word-to-html.ruhttps/word-to-html.ru/http/prntscr.com/g67dtz " target=" _blank "> http://prntscr.com/g67dtz</a></li>
    <li><a class="external" href="https://goo.gl/N6t2xw" target="_blank">Google</a>, click here: <a class="internal" href="https://word-to-html.ruhttps/word-to-html.ru/http/prntscr.com/g3se6f " target=" _blank "> http://prntscr.com/g3se6f</a></li>
    <li><a class="external" href="https://yandex.ru/maps/org/neoseo/1835577365/" target="_blank">Company profile on Yandex</a> (review must pass the moderation of the service )</li>
    <li>&nbsp;</li>
</ul>

<p>As a thank you for the time spent writing your feedback, we&#39;ve prepared a bonus for you:</p>

<ol>
    <li>for writing a review on any two sites: a discount of 50% for any module.</li>
    <li>for writing a review on 4 sites - we give you any module you need, except for the exchange module with 1C: Enterprise as a gift!</li>
</ol>

<p>A full list of possible functional solutions (modules) is available here:<b>&nbsp;<a href="https://neoseo.com.ua/module-prices-in-rubles" target="_blank">https://neoseo.com.ua/module-prices-in-rubles</a>&nbsp;</b></p>

<p>Once again, thank you very much for being with us!</p>

<p>The NeoSeo Team</p>';
