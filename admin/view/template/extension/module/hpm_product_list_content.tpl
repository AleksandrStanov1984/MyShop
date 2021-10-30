<?php // for Centos correct file association ?>
<script>
// config data redeclare on get content by ajax
largest_product_id = <?=$largest_product_id ? $largest_product_id : 0?>;
</script>
<div class="row">
  <div class="col-sm-6 text-left hpm-pagination"><?php echo $pagination; ?></div>

</div>
<br>
<table id="products-list" class="products-list le table table-bordered table-hover" >
  <!-- table head -->
  <thead>
    <tr>
      <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
      <td class="text-center"><?=$column_image?></td>
      <td class="text-left"><?=$column_identity?></td>
			<?php if (!isset($a_product_list_field['attribute']) && !isset($a_product_list_field['option'])) { ?>
			<!-- Category -->
			<?php if (isset($a_product_list_field['category'])) { ?>
			<td class="text-left"><?=$hpm_column_category?></td>
			<?php } ?>
			<?php } ?>
      <td class="text-left"><?=$hpm_column_description?></td>
      <?php if(isset($a_product_list_field['attribute'])) { ?>
      <td class="text-left"><?=$column_attribute?></td>
      <?php } ?>
      <?php if(isset($a_product_list_field['option'])) { ?>
      <td class="text-left"><?=$column_option?></td>
      <?php } ?>
      <td class="text-right"><?=$column_action?></td>
    </tr>
  </thead>
  <!-- table body -->
  <tbody>
    <?php if ($products) { ?>
    <?php foreach ($products as $product) { ?>
    <tr id="products-list-row-<?=$product['product_id']?>" class="products-list-row" data-product-id="<?=$product['product_id']?>">
      <td id="checker-<?=$product['product_id']?>" class="checker text-center <?= !isset($a_product_list_field['attribute']) && !isset($a_product_list_field['option']) ? 'prevent-wide-images__checker' : '' ?>">
        <input form="form-product" type="checkbox" name="selected[]" value="<?=$product['product_id']?>" />
      </td>
      <!-- Images -->
      <td id="images-<?=$product['product_id']?>" class="images text-center">
        <div id="image-uploader-<?=$product['product_id']?>" class="image-uploader">
          <div id="image-uploader-container-<?=$product['product_id']?>" class="image-uploader-container" data-product-id="<?=$product['product_id']?>" data-image-row="0">
            <?php $image_row = 0; ?>
            <div id="thumb-image-box-<?=$product['product_id']?>-<?=$image_row?>" class="img-thumbnail-box upload-photo-main">
              <span class="fa fa-close btn-remove-photo"></span>
              <a href="#" id="thumb-image-<?=$product['product_id']?>-<?=$image_row?>" class="img-thumbnail" data-toggle="image-upload" ><img src="<?=$product['thumb']?>" alt="" title="" data-placeholder="<?=$placeholder?>" /><input type="hidden" name="images[]" value="<?=$product['image']?>" id="input-image-<?=$product['product_id']?>-<?=$image_row?>" /></a>
            </div>
            <?php $image_row++; // after main photo ?>
            <?php if ($product['product_image']) { ?>
            <?php foreach($product['product_image'] as $image) { ?>
            <div id="thumb-image-box-<?=$product['product_id']?>-<?=$image_row?>" class="img-thumbnail-box">
              <span class="fa fa-close btn-remove-photo"></span>
              <a href="#" id="thumb-image-<?=$product['product_id']?>-<?=$image_row?>" class="img-thumbnail" data-toggle="image-upload" ><img src="<?=$image['thumb']?>" alt="" title="" data-placeholder="<?=$placeholder?>" /><input type="hidden" name="images[]" value="<?=$image['image']?>" id="input-image-<?=$product['product_id']?>-<?=$image_row?>" /></a>
            </div>
            <?php $image_row++; // after itteration ?>
            <?php } ?>
            <?php } ?>
          </div>
          <script type="text/javascript">
            $('#image-uploader-container-<?=$product['product_id']?>').attr('data-image-row', <?=$image_row?>);
          </script>
          <button type="button" class="btn btn-sm btn-success btn-add-img-thumbnail-box" data-toggle="tooltip" title="<?=$button_add?>" data-product-id="<?=$product['product_id']?>"><i class="fa fa-plus"></i></button>
          <form action="">
            <div id="upload-photo-additional-<?=$product['product_id']?>" class="dropZone upload-photo-additional" data-product-id="<?=$product['product_id']?>">
              <div class="drag-and-drop-label">Drag & Drop</div>
              <div class="drag-and-drop-help"><?=$hpm_upload_text_drag_and_drop?></div>
            </div>
          </form>
        </div>
      </td>
      <!-- Identity -->
      <td id="identity-<?=$product['product_id']?>" class="identity text-left <?= !isset($a_product_list_field['attribute']) && !isset($a_product_list_field['option']) ? 'prevent-wide-images__identity' : '' ?>">
        <!-- Product ID -->
        <div class="le-row">
          <label class="le-label product-id" data-product-id="<?=$product['product_id']?>"><?=$hpm_text_product_id?></label>
          <?=$product['product_id']?>
          <br />
        </div>
        <!-- Clone Select -->
        <div class="le-row">
          <label class="le-label" for="clone-checkbox-<?=$product['product_id']?>"><?=$hpm_entry_clone?></label>
          <input type="checkbox" id="clone-checkbox-<?=$product['product_id']?>" class="le-value clone-checkbox" value="1" data-product-id="<?=$product['product_id']?>"/>
        </div>
				<!-- SEO URL -->
				<div class="le-row" style="margin-top: 10px; ">
					<div class="le-label"><?=$entry_keyword?></div>
					<input type="text" id="keyword-<?=$product['product_id']?>" class="le-value _url-value" style="width: 100%; " value="<?=$product['keyword']?>" data-product-id="<?=$product['product_id']?>"/>
				</div>
				<div class="le-row" style="margin-bottom: 15px; margin-top: 5px;">
					<button type="button" class="btn btn-sm btn-success btn-generate-seo-url" data-product-id="<?=$product['product_id']?>"><i class="fa fa-magic"></i> <?=$hpm_btn_generate_seo_url ?></button>
				</div>
				<?php if (isset($a_product_list_field['attribute']) || isset($a_product_list_field['option'])) { ?>
        <!-- Category -->
				<?php if (isset($a_product_list_field['category'])) { ?>
        <div class="category">
          <?php if($has_main_category_column) { ?>
          <div class="le-row">
            <label class="le-label" for="input-main-category-<?=$product['product_id']?>"><?=$hpm_entry_main_category?></label>
            <select name="main_category_id" class="le-value _simple-value le-selector" id="input-main-category-<?=$product['product_id']?>" data-field="main_category_id" data-product-id="<?=$product['product_id']?>">
              <option value="0"><?=$text_none?></option>
              <?php foreach ($all_categories as $category) { ?>
              <?php if ($category['category_id'] == $product['main_category_id']) { ?>
              <option value="<?=$category['category_id']?>" selected="selected"><?=$category['name']?></option>
              <?php } else { ?>
              <option value="<?=$category['category_id']?>"><?=$category['name']?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </div>
          <br />
          <?php } ?>
          <div id="categories-selector-container-<?=$product['product_id']?>" class="categories-selector-container" >
            <label class="control-label" for="input-category"><?=$entry_category?></label>
            <div class="categories-selector" data-product-id="<?=$product['product_id']?>">
              <?= $product['category_tree'] ?>
            </div>
          </div>
        </div>
				<?php } ?>
				<?php } ?>
        <div id="identity-content-<?=$product['product_id']?>" class="identity-content" data-product-id="<?=$product['product_id']?>">
          <div class="le-row">
            <label class="le-label" for="manufacturer-<?=$product['product_id']?>"><?=$entry_manufacturer?></label>
            <select name="manufacturer_id" class="le-value _simple-value le-selector" id="manufacturer-<?=$product['product_id']?>" data-field="manufacturer_id">
              <option value=""><?=$text_none?></option>
              <?php foreach($manufacturers as $manufacturer) { ?>
              <option value="<?=$manufacturer['manufacturer_id']?>"<?=$product['manufacturer_id'] == $manufacturer['manufacturer_id'] ? ' selected="selected"' : ''?>><?=$manufacturer['name']?></option>
              <?php } ?>
            </select>
          </div>
					<div class="le-row">
            <span class="le-label"><?=$entry_model?></span>
            <input type="text" id="model-<?=$product['product_id']?>" class="le-value _simple-value" value="<?=$product['model']?>" data-field="model" />
          </div>
          <?php if (isset($a_product_list_field['sku'])) { ?>
          <div class="le-row">
            <span class="le-label"><?=$entry_sku?></span>
            <input type="text" id="sku-<?=$product['product_id']?>" class="le-value _simple-value" value="<?=$product['sku']?>" data-field="sku" />
          </div>
          <?php } ?>
          <?php if (isset($a_product_list_field['upc'])) { ?>
          <div class="le-row">
            <span class="le-label"><?=$entry_upc?></span>
            <input type="text" id="upc-<?=$product['product_id']?>" class="le-value _simple-value" value="<?=$product['upc']?>" data-field="upc" />
          </div>
          <?php } ?>
					<?php if (isset($a_product_list_field['ean'])) { ?>
          <div class="le-row">
            <span class="le-label"><?=$entry_ean?></span>
            <input type="text" id="ean-<?=$product['product_id']?>" class="le-value _simple-value" value="<?=$product['ean']?>" data-field="ean" />
          </div>
          <?php } ?>
					<?php if (isset($a_product_list_field['jan'])) { ?>
          <div class="le-row">
            <span class="le-label"><?=$entry_jan?></span>
            <input type="text" id="jan-<?=$product['product_id']?>" class="le-value _simple-value" value="<?=$product['jan']?>" data-field="jan" />
          </div>
          <?php } ?>
					<?php if (isset($a_product_list_field['isbn'])) { ?>
          <div class="le-row">
            <span class="le-label"><?=$entry_isbn?></span>
            <input type="text" id="isbn-<?=$product['product_id']?>" class="le-value _simple-value" value="<?=$product['isbn']?>" data-field="isbn" />
          </div>
          <?php } ?>
					<?php if (isset($a_product_list_field['mpn'])) { ?>
          <div class="le-row">
            <span class="le-label"><?=$entry_mpn?></span>
            <input type="text" id="mpn-<?=$product['product_id']?>" class="le-value _simple-value" value="<?=$product['mpn']?>" data-field="mpn" />
          </div>
          <?php } ?>
					<div class="box-custom box-custom__price">
						<div class="le-row">
							<span class="le-label"><?=$entry_price?></span>
							<input type="text" id="price-<?=$product['product_id']?>" class="le-value _simple-value _price" value="<?=$product['price']?>" data-field="price" />
						</div>
						<!-- Custom Fields - With Price -->
						<?php if (count($a_product_list_field_custom_price) > 0) { ?>
						<?php foreach($a_product_list_field_custom_price as $key => $value) { ?>
						<div class="le-row">
							<span class="le-label"><?=$a_product_list_field_custom_price[$key]['description'][$config_language_id]?></span>
							<input type="text" id="custom-<?=$key?>-<?=$product['product_id']?>" class="le-value _simple-value _price" value="<?=$product['custom_fields_price'][$key]?>" data-field="<?=$key?>" />
						</div>
						<?php } ?>
						<?php } ?>
					</div>

					<!-- Points -->
					<?php if (isset($a_product_list_field['points'])) { ?>

					<div class="product-reward well well-sm">
						<div class="le-row" style="border-bottom: 1px solid #ccc; padding-bottom: 10px;">
							<span class="le-label"><?=$entry_points?></span>
							<input type="text" id="input-points-<?=$product['product_id']?>" class="le-value _simple-value" value="<?=$product['points']?>" data-field="points" />
						</div>
						<!-- Product Reward -->
						<?php foreach ($customer_groups as $customer_group) { ?>
						<div class="le-row">
							<span class="le-label"><?=$customer_group['name']?></span>
							<input type="text" name="product_reward[<?=$customer_group['customer_group_id']?>][points]" id="input-product-reward-<?=$product['product_id']?>" class="le-value product-reward-value" value="<?= isset($product['product_reward'][$customer_group['customer_group_id']]['points']) ? $product['product_reward'][$customer_group['customer_group_id']]['points'] : ''?>" data-field="no" data-customer-group-id="<?=$customer_group['customer_group_id']?>" />
						</div>
						<?php } ?>
					</div>

					<?php } ?>

					<!-- Status -->
					<div class="le-row">
            <span class="le-label"><?=$entry_status?></span>
            <select name="status" id="input-status-<?=$product['product_id']?>" class="le-value _simple-value le-selector" data-field="status">
              <?php if ($product['status']) { ?>
                <option value="1" selected="selected"><?=$text_enabled?></option>
                <option value="0"><?=$text_disabled?></option>
                <?php } else { ?>
                <option value="1"><?=$text_enabled?></option>
                <option value="0" selected="selected"><?=$text_disabled?></option>
                <?php } ?>
            </select>
          </div>

					<?php if ('OpenCart.PRO' == $hpm_system) { ?>

					<div class="le-row">
						<span class="le-label"><?=$entry_noindex?></span>
						<select name="noindex" id="input-noindex-<?=$product['product_id']?>" class="le-value _simple-value le-selector" data-field="noindex">
							<?php if ($product['noindex']) { ?>
								<option value="1" selected="selected"><?=$text_enabled?></option>
								<option value="0"><?=$text_disabled?></option>
								<?php } else { ?>
								<option value="1"><?=$text_enabled?></option>
								<option value="0" selected="selected"><?=$text_disabled?></option>
								<?php } ?>
						</select>
					</div>

					<?php } ?>

					<!-- Quantity -->
					<div class="le-row">
            <span class="le-label"><?=$entry_quantity?></span>
            <input type="text" id="quantity-<?=$product['product_id']?>" class="le-value _simple-value" value="<?=$product['quantity']?>" data-field="quantity" />
          </div>

					<!-- Minimum -->
					<?php if (isset($a_product_list_field['minimum'])) { ?>
					<div class="le-row">
            <span class="le-label"><?=$entry_minimum?></span>
            <input type="text" id="minimum-<?=$product['product_id']?>" class="le-value _simple-value" value="<?=$product['minimum']?>" data-field="minimum" />
          </div>
					<?php } ?>

					<!-- Weight -->
					<?php if (isset($a_product_list_field['weight'])) { ?>
					
					<div class="le-row">
            <span class="le-label"><?=$entry_weight?></span>
            <input type="text" id="weight-<?=$product['product_id']?>" class="le-value _simple-value" value="<?=$product['weight']?>" data-field="weight" />
          </div>

					<!-- Weight Class -->
          <div class="le-row">
            <span class="le-label"><?=$entry_weight_class?></span>
            <select name="weight_class_id" id="input-weight-class-<?=$product['product_id']?>" class="le-value _simple-value le-selector" data-field="weight_class_id">
              <?php foreach ($weight_classes as $weight_class) { ?>
              <?php if ($weight_class['weight_class_id'] == $product['weight_class_id']) { ?>
              <option value="<?=$weight_class['weight_class_id']?>" selected="selected"><?=$weight_class['title']?></option>
              <?php } else { ?>
              <option value="<?=$weight_class['weight_class_id']?>"><?=$weight_class['title']?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </div>
					
					<?php } ?>
					
					<!-- Dimension -->
					<?php if (isset($a_product_list_field['dimension'])) { ?>
					
					<div class="le-row dimension">
            <span class="le-label"><?=$entry_dimension?></span>
            <input type="text" id="length-<?=$product['product_id']?>" class="le-value _simple-value" value="<?=$product['length']?>" data-field="length" placeholder="<?php echo $entry_length; ?>" />
            <input type="text" id="width-<?=$product['product_id']?>" class="le-value _simple-value" value="<?=$product['width']?>" data-field="width" placeholder="<?php echo $entry_width; ?>" />
            <input type="text" id="height-<?=$product['product_id']?>" class="le-value _simple-value" value="<?=$product['height']?>" data-field="height" placeholder="<?php echo $entry_height; ?>" />
          </div>
					
					<!-- Length Class -->
          <div class="le-row">
            <span class="le-label"><?=$entry_length_class?></span>
            <select name="length_class_id" id="input-length-class-<?=$product['product_id']?>" class="le-value _simple-value le-selector" data-field="length_class_id">
              <?php foreach ($length_classes as $length_class) { ?>
              <?php if ($length_class['length_class_id'] == $product['length_class_id']) { ?>
              <option value="<?=$length_class['length_class_id']?>" selected="selected"><?=$length_class['title']?></option>
              <?php } else { ?>
              <option value="<?=$length_class['length_class_id']?>"><?=$length_class['title']?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </div>
					
					<?php } ?>

					<!-- Stock Status -->
					<?php if (isset($a_product_list_field['stock_status'])) { ?>
          <div class="le-row">
            <span class="le-label"><?=$entry_stock_status?></span>
            <select name="stock_status_id" id="input-stock-status-<?=$product['product_id']?>" class="le-value _simple-value le-selector" data-field="stock_status_id">
              <?php foreach ($stock_statuses as $stock_status) { ?>
              <?php if ($stock_status['stock_status_id'] == $product['stock_status_id']) { ?>
              <option value="<?=$stock_status['stock_status_id']?>" selected="selected"><?=$stock_status['name']?></option>
              <?php } else { ?>
              <option value="<?=$stock_status['stock_status_id']?>"><?=$stock_status['name']?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </div>
					<?php } ?>

					<!-- Subtract -->
					<?php if (isset($a_product_list_field['subtract'])) { ?>
          <div class="le-row">
            <span class="le-label"><?=$entry_subtract?></span>
            <select name="subtract" id="input-subtract-<?=$product['product_id']?>" class="le-value _simple-value le-selector" data-field="subtract">
              <?php if ($product['subtract']) { ?>
                <option value="1" selected="selected"><?=$text_yes?></option>
                <option value="0"><?=$text_no?></option>
                <?php } else { ?>
                <option value="1"><?=$text_yes?></option>
                <option value="0" selected="selected"><?=$text_no?></option>
                <?php } ?>
            </select>
          </div>
					<?php } ?>

					<!-- Shipping -->
					<?php if (isset($a_product_list_field['shipping'])) { ?>
          <div class="le-row">
            <span class="le-label"><?=$entry_shipping?></span>
            <select name="shipping" id="input-shipping-<?=$product['product_id']?>" class="le-value _simple-value le-selector" data-field="shipping">
              <?php if ($product['shipping']) { ?>
                <option value="1" selected="selected"><?=$text_yes?></option>
                <option value="0"><?=$text_no?></option>
                <?php } else { ?>
                <option value="1"><?=$text_yes?></option>
                <option value="0" selected="selected"><?=$text_no?></option>
                <?php } ?>
            </select>
          </div>
					<?php } ?>

					<!-- Date Available -->
					<div class="le-row">
						<div class="date">
							<span class="le-label"><?=$entry_date_available?></span>
							<input type="text" id="date_available-<?=$product['product_id']?>" class="le-value _simple-value" value="<?=$product['date_available']?>" data-date-format="YYYY-MM-DD" data-field="date_available" />
							<span class="input-group-btn"><button class="btn-calendar" type="button"><i class="fa fa-calendar"></i></button></span>
						</div>
          </div>

					<!-- Sort Order -->
					<div class="le-row _date">
            <span class="le-label _date"><?=$entry_sort_order?></span>
            <input type="text" id="sort_order-<?=$product['product_id']?>" class="le-value _simple-value _date" value="<?=$product['sort_order']?>" data-field="sort_order" />
          </div>


					<?php if (isset($a_product_list_field['discount'])) { ?>
          <!-- discount -->
          <div class="le-row">
            <span class="le-label discount-price"><?=$hpm_entry_discount?></span>
            <div class="discount well well-sm">
              <?php $discount_row = 0; ?>
              <div class="discount-container" id="discount-container-<?=$product['product_id']?>">
                <?php foreach ($product['product_discounts'] as $product_discount) { ?>
                <div id="discount-row-<?=$product['product_id']?>-<?=$discount_row?>" class="discount-row" data-product-id="<?=$product['product_id']?>" data-product-discount-id="<?=$product_discount['product_discount_id']?>" data-discount-row="<?=$discount_row?>">
                  <div class="pull-right"><a type="button" class="btn-remove-discount" data-target="#discount-row-<?=$product['product_id']?>-<?=$discount_row?>" data-toggle="tooltip" title="<?=$button_remove?>"><i class="fa fa-close"></i></a></div>
                    <div class="le-row">
                      <span class="le-label _customer-group"><?=$hpm_entry_customer_group?></span>
                      <select class="le-value _discount-value le-selector discount-customer-group" data-field="customer_group_id">
                        <?php foreach ($customer_groups as $customer_group) { ?>
                        <?php if ($customer_group['customer_group_id'] == $product_discount['customer_group_id']) { ?>
                        <option value="<?=$customer_group['customer_group_id']?>" selected="selected"><?=$customer_group['name']?></option>
                        <?php } else { ?>
                        <option value="<?=$customer_group['customer_group_id']?>"><?=$customer_group['name']?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  <div class="le-row">
                    <span class="le-label _quantity"><?=$entry_quantity?></span>
                    <input type="text" value="<?=$product_discount['quantity']?>" placeholder="<?=$entry_quantity?>" class="le-value _discount-value discount-quantity" data-field="quantity" />
                  </div>
                  <div class="le-row">
                    <span class="le-label _priority"><?=$entry_priority?></span>
                    <input type="text" value="<?=$product_discount['priority']?>" placeholder="<?=$entry_priority?>" class="le-value _discount-value discount-priority" data-field="priority" />
                  </div>
                  <div class="le-row">
                    <span class="le-label"><?=$entry_price?></span>
                    <input type="text" value="<?=$product_discount['price']?>" placeholder="<?=$entry_price?>" class="le-value _discount-value discount-price" data-field="price" />
                  </div>
                  <div class="le-row _date">
                    <span class="le-label _date"><?=$hpm_entry_date_start?></span>
                    <div class="date">
                      <input type="text" value="<?=$product_discount['date_start']?>" placeholder="<?=$hpm_entry_date_start?>" data-date-format="YYYY-MM-DD" class="le-value _discount-value _date discount-date-start" data-field="date_start" />
                      <span class="input-group-btn">
                      <button class="btn-calendar" type="button"><i class="fa fa-calendar"></i></button>
                      </span></div>
                  </div>
                  <div class="le-row _date">
                    <span class="le-label _date"><?=$hpm_entry_date_end?></span>
                    <div class="date">
                      <input type="text" value="<?=$product_discount['date_end']?>" placeholder="<?=$hpm_entry_date_end?>" data-date-format="YYYY-MM-DD" class="le-value _discount-value _date discount-date-end" data-field="date_end" />
                      <span class="input-group-btn">
                      <button class="btn-calendar" type="button"><i class="fa fa-calendar"></i></button>
                      </span></div>
                  </div>
                </div>
                <?php $discount_row++ ?>
                <?php } ?>
              </div>
              <button type="button" class="btn btn-sm btn-success btn-add-discount" data-toggle="tooltip" title="<?=$button_add?>" data-target="#discount-row-<?=$product['product_id']?>-<?=$discount_row?>" data-product-id="<?=$product['product_id']?>" data-discount-row="<?=$discount_row?>"><i class="fa fa-plus"></i></button>
            </div>
          </div>
					<?php } ?>

					<?php if (isset($a_product_list_field['special'])) { ?>
          <!-- special -->
          <div class="le-row">
            <span class="le-label special-price"><?=$hpm_entry_special?></span>
            <div class="special well well-sm">
              <?php $special_row = 0; ?>
              <div class="special-container" id="special-container-<?=$product['product_id']?>">
                <?php foreach ($product['product_specials'] as $product_special) { ?>
                <div id="special-row-<?=$product['product_id']?>-<?=$special_row?>" class="special-row" data-product-id="<?=$product['product_id']?>" data-product-special-id="<?=$product_special['product_special_id']?>" data-special-row="<?=$special_row?>">
                  <div class="pull-right"><a type="button" class="btn-remove-special" data-target="#special-row-<?=$product['product_id']?>-<?=$special_row?>" data-toggle="tooltip" title="<?=$button_remove?>"><i class="fa fa-close"></i></a></div>
                    <div class="le-row">
                      <span class="le-label _customer-group"><?=$hpm_entry_customer_group?></span>
                      <select class="le-value _special-value le-selector special-customer-group" data-field="customer_group_id">
                        <?php foreach ($customer_groups as $customer_group) { ?>
                        <?php if ($customer_group['customer_group_id'] == $product_special['customer_group_id']) { ?>
                        <option value="<?=$customer_group['customer_group_id']?>" selected="selected"><?=$customer_group['name']?></option>
                        <?php } else { ?>
                        <option value="<?=$customer_group['customer_group_id']?>"><?=$customer_group['name']?></option>
                        <?php } ?>
                        <?php } ?>
                      </select>
                    </div>
                  <div class="le-row">
                    <span class="le-label _priority"><?=$entry_priority?></span>
                    <input type="text" value="<?=$product_special['priority']?>" placeholder="<?=$entry_priority?>" class="le-value _special-value special-priority" data-field="priority" />
                  </div>
                  <div class="le-row">
                    <span class="le-label"><?=$entry_price?></span>
                    <input type="text" value="<?=$product_special['price']?>" placeholder="<?=$entry_price?>" class="le-value _special-value special-price" data-field="price" />
                  </div>
                  <div class="le-row _date">
                    <span class="le-label _date"><?=$hpm_entry_date_start?></span>
                    <div class="date">
                      <input type="text" value="<?=$product_special['date_start']?>" placeholder="<?=$hpm_entry_date_start?>" data-date-format="YYYY-MM-DD" class="le-value _special-value _date special-date-start" data-field="date_start" />
                      <span class="input-group-btn">
                      <button class="btn-calendar" type="button"><i class="fa fa-calendar"></i></button>
                      </span></div>
                  </div>
                  <div class="le-row _date">
                    <span class="le-label _date"><?=$hpm_entry_date_end?></span>
                    <div class="date">
                      <input type="text" value="<?=$product_special['date_end']?>" placeholder="<?=$hpm_entry_date_end?>" data-date-format="YYYY-MM-DD" class="le-value _special-value _date special-date-end" data-field="date_end" />
                      <span class="input-group-btn">
                      <button class="btn-calendar" type="button"><i class="fa fa-calendar"></i></button>
                      </span></div>
                  </div>
                </div>
                <?php $special_row++ ?>
                <?php } ?>
              </div>
              <button type="button" class="btn btn-sm btn-success btn-add-special" data-toggle="tooltip" title="<?=$button_add?>" data-target="#special-row-<?=$product['product_id']?>-<?=$special_row?>" data-product-id="<?=$product['product_id']?>" data-special-row="<?=$special_row?>"><i class="fa fa-plus"></i></button>
            </div>
          </div>
					<?php } ?>

					<?php if (isset($a_product_list_field['store'])) { ?>
          <div id="input-store-<?=$product['product_id']?>" data-product-id="<?=$product['product_id']?>" class="input-store well well-sm" style="height: 150px; overflow: auto; margin-top: 10px;">
            <span class="le-label"><?=$entry_store?></span>
            <div class="checkbox" style="float: left; width: calc(100% - 100px); padding-top: 0; margin-top: 0; ">
              <label>
                <?php if (in_array(0, $product['product_store'])) { ?>
                <input type="checkbox" name="product_store[]" value="0" checked="checked" />
                <?=$text_default?>
                <?php } else { ?>
                <input type="checkbox" name="product_store[]" value="0" />
                <?=$text_default?>
                <?php } ?>
              </label><br>
							<?php foreach ($stores as $store) { ?>
              <label>
                <?php if (in_array($store['store_id'], $product['product_store'])) { ?>
                <input type="checkbox" name="product_store[]" value="<?=$store['store_id']?>" checked="checked" />
                <?=$store['name']?>
                <?php } else { ?>
                <input type="checkbox" name="product_store[]" value="<?=$store['store_id']?>" />
                <?=$store['name']?>
                <?php } ?>
              </label><br>
							<?php } ?>
            </div>
          </div>
					<?php } ?>

					<?php if (isset($a_product_list_field['location'])) { ?>
          <div class="le-row _location">
            <span class="le-label"><?=$entry_location?></span>
            <input type="text" id="location-<?=$product['product_id']?>" class="le-value _simple-value _location" value="<?=$product['location']?>" data-field="location" />
          </div>
          <?php } ?>

					<!-- Custom Fields - Without Price -->
					<?php if (count($a_product_list_field_custom) > 0) { ?>
					<div class="box-custom box-custom__other">
						<h4><?=$hpm_text_custom_fields?></h4>
						<?php foreach($a_product_list_field_custom as $key => $value) { ?>
						<div class="le-row">
							<span class="le-label" style="width: 100px;"><?=$a_product_list_field_custom[$key]['description'][$config_language_id]?></span>
							<input type="text" id="custom-<?=$key?>-<?=$product['product_id']?>" class="le-value _simple-value" value="<?=$product['custom_fields'][$key]?>" data-field="<?=$key?>" style="width: 250px; width: calc(100% - 100px);" />
          </div>
					<?php } ?>
					</div>
					<?php } ?>
        </div>
      </td>
			<?php if (!isset($a_product_list_field['attribute']) && !isset($a_product_list_field['option'])) { ?>
			<!-- Category -->
			<?php if (isset($a_product_list_field['category'])) { ?>
			<td id="category-<?=$product['product_id']?>" class="category-col text-left <?= !isset($a_product_list_field['attribute']) && !isset($a_product_list_field['option']) ? 'prevent-wide-images__category' : '' ?>">
				<div class="category">
          <?php if($has_main_category_column) { ?>
          <div class="le-row">
            <label class="le-label" for="input-main-category-<?=$product['product_id']?>"><?=$hpm_entry_main_category?></label>
            <select name="main_category_id" class="le-value _simple-value le-selector" id="input-main-category-<?=$product['product_id']?>" data-field="main_category_id" data-product-id="<?=$product['product_id']?>">
              <option value="0"><?=$text_none?></option>
              <?php foreach ($all_categories as $category) { ?>
              <?php if ($category['category_id'] == $product['main_category_id']) { ?>
              <option value="<?=$category['category_id']?>" selected="selected"><?=$category['name']?></option>
              <?php } else { ?>
              <option value="<?=$category['category_id']?>"><?=$category['name']?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </div>
          <br />
          <?php } ?>
          <div id="categories-selector-container-<?=$product['product_id']?>" class="categories-selector-container" >
            <label class="control-label" for="input-category"><?=$entry_category?></label>
            <div class="categories-selector" data-product-id="<?=$product['product_id']?>">
              <?= $product['category_tree'] ?>
            </div>
          </div>
        </div>
			</td>
			<?php } ?>
			<?php } ?>
      <!-- Description -->
      <td id="description-<?=$product['product_id']?>" class="description text-left <?= !isset($a_product_list_field['attribute']) && !isset($a_product_list_field['option']) ? 'prevent-wide-images__description' : '' ?>">
        <p id="product-name-label-<?=$product['product_id']?>"><b><?=$product['product_description'][$config_language_id]['name']?></b></p>
          <?php foreach ($languages as $language) { ?>
          <div class="description-language-row">
            <div class="language-icon"><img src="language/<?=$language['code']?>/<?=$language['code']?>.png" title="<?=$language['name']?>"  /></div>
            <div class="description-content" data-product-id="<?=$product['product_id']?>" data-language-id="<?=$language['language_id']?>">
              <!-- name -->
							<div class="le-row">
                <span class="le-label"><?=$entry_name?></span>
                  <textarea id="name-<?=$product['product_id']?>-<?=$language['language_id']?>" cols="5" rows="5" class="le-value <?= $config_language_id == $language['language_id'] ? '_interactive-name' : '' ?>" data-field="name"><?=$product['product_description'][$language['language_id']]['name']?></textarea>
              </div>
							<!-- H1 -->
							<?php if (isset($a_product_list_field[$h1])) { ?>
              <div class="le-row">
								<?php $eh1 = 'entry_' . $h1; ?>
                <span class="le-label"><?=$$eh1?></span>
                <textarea id="<?=$h1?>-<?=$product['product_id']?>-<?=$language['language_id']?>" cols="5" rows="5" class="le-value _<?=$h1?>" data-field="<?=$h1?>"><?=$product['product_description'][$language['language_id']][$h1]?></textarea>
              </div>
							<?php } ?>
							<!-- Meta Title -->
							<?php if (isset($a_product_list_field['meta_title'])) { ?>
              <div class="le-row">
                <span class="le-label"><?=$entry_meta_title?></span>
                <textarea id="meta-title-<?=$product['product_id']?>-<?=$language['language_id']?>" cols="5" rows="5" class="le-value _meta-title" data-field="meta_title"><?=$product['product_description'][$language['language_id']]['meta_title']?></textarea>
              </div>
							<?php } ?>
							<!-- Meta Description -->
							<?php if (isset($a_product_list_field['meta_description'])) { ?>
              <div class="le-row">
                <span class="le-label"><?=$entry_meta_description?></span>
                <textarea id="meta-description-<?=$product['product_id']?>-<?=$language['language_id']?>" cols="5" rows="5" class="le-value _meta-description" data-field="meta_description"><?=$product['product_description'][$language['language_id']]['meta_description']?></textarea>
              </div>
							<?php } ?>
							<!-- Meta Keyword -->
							<?php if (isset($a_product_list_field['meta_keyword'])) { ?>
              <div class="le-row">
                <span class="le-label"><?=$entry_meta_keyword?></span>
                <textarea id="meta-keyword-<?=$product['product_id']?>-<?=$language['language_id']?>" cols="5" rows="5" class="le-value" data-field="meta_keyword"><?=$product['product_description'][$language['language_id']]['meta_keyword']?></textarea>
              </div>
							<?php } ?>
							<!-- Tag -->
							<?php if (isset($a_product_list_field['tag'])) { ?>
              <div class="le-row">
                <span class="le-label"><?=$entry_tag?></span>
                <textarea id="tag-<?=$product['product_id']?>-<?=$language['language_id']?>" cols="5" rows="5" class="le-value" data-field="tag"><?=$product['product_description'][$language['language_id']]['tag']?></textarea>
              </div>
							<?php } ?>
							<!-- Description -->
							<?php if (isset($a_product_list_field['description'])) { ?>
              <div class="le-row">
								<span class="le-label"><?= $entry_description ?></span>
								<br>
								<textarea id="description-<?=$product['product_id']?>-<?= $language['language_id'] ?>" cols="8" rows="25" class="le-value tinymce" style="height: 400px;" data-field="description"><?=$product['product_description'][$language['language_id']]['description']?></textarea>
							</div>
							<?php } ?>
            </div>
          </div>
          <?php } ?>
      </td>

      <!-- Attribute -->
      <?php if(isset($a_product_list_field['attribute'])) { ?>
      <td id="attributes-<?=$product['product_id']?>" class="attributes">
				<?php $attribute_row = 0; ?>
				<div class="attributes-container" id="attributes-container-<?=$product['product_id']?>">
					<?php foreach ($product['product_attributes'] as $product_attribute) { ?>
					<div id="attribute-row-<?=$product['product_id']?>-<?=$attribute_row?>" class="attribute-row" data-product-id="<?=$product['product_id']?>" data-attribute-id="<?=$product_attribute['attribute_id']?>" data-attribute-row="<?=$attribute_row?>">
						<div class="pull-right"><a type="button" class="btn-remove-attribute" data-target="#attribute-row-<?=$product['product_id']?>-<?=$attribute_row?>" data-toggle="tooltip" title="<?=$button_remove?>"><i class="fa fa-close"></i></a></div>
						<div class="le-row">
							<div class="le-label"><a class="attribute-link" href="<?=$product_attribute['edit']?>" target="_blank" data-toggle="tooltip" title="<?=$hpm_text_attribute_edit?>"><?=$product_attribute['name']?></a>: </div>
							<div class="le-lang-values-container">
								<?php
								// attribute_id
								// name - not need to send
								// attribute_value[language_id] - is text in table attribute description
								?>
								<?php foreach ($languages as $language) { ?>
								<div class="le-lang-values-icon">
									<span class=""><img src="language/<?=$language['code']?>/<?=$language['code']?>.png" title="<?=$language['name']?>" /></span>
								</div>
								<div class="le-lang-values-content" data-product-id="<?=$product['product_id']?>" data-language-id="<?=$language['language_id']?>" data-attribute-id="<?=$product_attribute['attribute_id']?>">
									<input type="text" class="le-value attribute-value" value="<?=$product_attribute['product_attribute_description'][$language['language_id']]['text']?>" data-field="text" id="attribute-value-<?=$product['product_id']?>-<?=$attribute_row?>-<?=$language['language_id']?>" />
									<select class="le-selector attribute-value-selector" data-target="#attribute-value-<?=$product['product_id']?>-<?=$attribute_row?>-<?=$language['language_id']?>" data-attribute-id="<?=$product_attribute['attribute_id']?>" data-language-id="<?=$language['language_id']?>" id="attribute-value-selector-<?=$product['product_id']?>-<?=$attribute_row?>-<?=$language['language_id']?>">
										<option value="" >----</option>
									</select>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
					<?php $attribute_row++; ?>
					<?php } ?>
				</div>
				<button type="button" class="btn btn-sm btn-success btn-add-attribute" data-toggle="tooltip" title="<?=$button_add?>" data-target="#attributes-container-<?=$product['product_id']?>" data-product-id="<?=$product['product_id']?>" data-attribute-row="<?=$attribute_row?>"><i class="fa fa-plus"></i></button>
      </td>
      <?php } ?>

      <!-- Option -->
      <?php if(isset($a_product_list_field['option'])) { ?>
      <td id="options-<?=$product['product_id']?>" class="options">
				<?php $option_row = 0; ?>
				<div class="options-container" id="options-container-<?=$product['product_id']?>" data-product-id="<?=$product['product_id']?>" data-option-row="<?=$option_row?>">
					<?php foreach($product['product_options'] as $product_option) { ?>
					<!--
							A!
							data-option-row for THIS row!!
					-->
					<div id="option-row-<?=$product['product_id']?>-<?=$option_row?>" class="option-row" data-option-row="<?=$option_row?>" data-option-id="<?=$product_option['option_id']?>" data-product-option-id="<?=$product_option['product_option_id']?>" data-option-type="<?=$product_option['type']?>">
						<div class="pull-right"><a type="button" class="btn-remove-option" data-target="#option-row-<?=$product['product_id']?>-<?=$option_row?>" data-toggle="tooltip" title="<?=$button_remove?>"><i class="fa fa-close"></i></a></div>
						<div class="le-row">
							<div class="le-label _name"><a class="option-link" href="<?=$product_option['edit']?>" target="_blank" data-toggle="tooltip" title="<?=$hpm_text_option_edit?>"><?=$product_option['name']?></a></div>

							<!-- reqiure -->
							<div class="option-require le-row">
								<label class="le-label _left" for="input-required-<?=$product['product_id']?>-<?=$option_row?>"><?=$entry_required?></label>
								<select id="input-required-<?=$product['product_id']?>-<?=$option_row?>" class="le-value _simple-value le-selector _right" data-field="required">
									<?php if ($product_option['required']) { ?>
									<option value="1" selected="selected"><?=$text_yes?></option>
									<option value="0"><?=$text_no?></option>
									<?php } else { ?>
									<option value="1"><?=$text_yes?></option>
									<option value="0" selected="selected"><?=$text_no?></option>
									<?php } ?>
								</select>
							</div>

							<?php if ($product_option['type'] == 'text') { ?>
							<div class="le-row">
								<label class="le-label" for="input-value-<?=$product['product_id']?>-<?=$option_row?>"><?=$entry_option_value?></label>
								<input type="text" value="<?=$product_option['value']?>" placeholder="<?=$entry_option_value?>" id="input-value-<?=$product['product_id']?>-<?=$option_row?>" class="le-value _simple-value" data-field="value" />
							</div>
							<?php } ?>

							<?php if ($product_option['type'] == 'textarea') { ?>
							<div class="le-row">
								<label class="le-label" for="input-value-<?=$product['product_id']?>-<?=$option_row?>"><?= $entry_option_value ?></label>
								<textarea rows="5" placeholder="<?= $entry_option_value ?>" id="input-value-<?=$product['product_id']?>-<?=$option_row?>" class="le-value _simple-value _textarea" data-field="value"><?= $product_option['value'] ?></textarea>
							</div>
							<?php } ?>

							<!-- option values . begin -->
							<?php if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') { ?>
							<?php $option_value_row = 0; ?>
							<div id="option-values-<?=$product['product_id']?>-<?=$option_row?>" class="option-values" data-option-value-row="<?=$option_value_row?>">
								<?php foreach ($product_option['product_option_value'] as $product_option_value) { ?>
								<!--
									A!
									data-option-value-row for THIS row!!
								-->
								<div id="option-value-<?=$product['product_id']?>-<?=$option_row?>-<?=$option_value_row?>" class="option-value le-row" data-product-option-value-id="<?=$product_option_value['product_option_value_id']?>" data-option-value-row="<?=$option_value_row?>">
									<span class="fa fa-close btn-remove-product-option-value" data-toggle="tooltip" title="<?= $button_remove ?>"></span>

									<div class="le-row">
										<label class="le-label _left" for="input-product-option-value-<?=$product['product_id']?>-<?=$option_row?>-<?=$option_value_row?>"><?=$entry_option_value?></label>
										<select id="input-product-option-value-<?=$product['product_id']?>-<?=$option_row?>-<?=$option_value_row?>" name="" class="le-value _simple-value-2 le-selector _right" data-field="option_value_id">
											<?php if (isset($product['option_values'][$product_option['option_id']])) { ?>
											<?php foreach ($product['option_values'][$product_option['option_id']] as $option_value) { ?>
											<?php if ($option_value['option_value_id'] == $product_option_value['option_value_id']) { ?>
											<option value="<?= $option_value['option_value_id'] ?>" selected="selected"><?= $option_value['name'] ?></option>
											<?php } else { ?>
											<option value="<?= $option_value['option_value_id'] ?>"><?= $option_value['name'] ?></option>
											<?php } ?>
											<?php } ?>
											<?php } ?>
										</select>
									</div>

									<div class="le-row">
										<label class="le-label _left" for="input-quantity-<?=$product['product_id']?>-<?=$option_row?>-<?=$option_value_row?>"><?= $entry_quantity ?></label>
										<input type="text" id="input-quantity-<?=$product['product_id']?>-<?=$option_row?>-<?=$option_value_row?>" name="" value="<?= $product_option_value['quantity'] ?>" placeholder="<?= $entry_quantity ?>" class="le-value _simple-value-2 _right" data-field="quantity" />
									</div>

									<div class="le-row">
										<label class="le-label _left" for="input-subtract-<?=$product['product_id']?>-<?=$option_row?>-<?=$option_value_row?>" style="padding-top: none;"><?=$entry_subtract?></label>
										<select id="input-subtract-<?=$product['product_id']?>-<?=$option_row?>-<?=$option_value_row?>" class="le-value _simple-value-2 le-selector _right" data-field="subtract">
											<?php if ($product_option_value['subtract']) { ?>
											<option value="1" selected="selected"><?= $text_yes ?></option>
											<option value="0"><?= $text_no ?></option>
											<?php } else { ?>
											<option value="1"><?= $text_yes ?></option>
											<option value="0" selected="selected"><?= $text_no ?></option>
											<?php } ?>
										</select>
									</div>

									<div class="le-row">
										<label class="le-label _left"><?= $entry_price ?></label>
										<input id="input-price-<?=$product['product_id']?>-<?=$option_row?>-<?=$option_value_row?>" type="text" name="price" value="<?= $product_option_value['price'] ?>" placeholder="<?= $entry_price ?>" class="le-value _simple-value-2 _right-half" data-field="price" />
										<select id="input-price-prefix-<?=$product['product_id']?>-<?=$option_row?>-<?=$option_value_row?>" name="price_prefix" class="le-value _simple-value-2 le-selector _right-half" data-field="price_prefix">
											<?php if ($product_option_value['price_prefix'] == '+') { ?>
											<option value="+" selected="selected">+</option>
											<?php } else { ?>
											<option value="+">+</option>
											<?php } ?>
											<?php if ($product_option_value['price_prefix'] == '-') { ?>
											<option value="-" selected="selected">-</option>
											<?php } else { ?>
											<option value="-">-</option>
											<?php } ?>
										</select>
									</div>

									<div class="le-row">
										<label class="le-label _left"><?= $entry_option_points ?></label>
										<input id="input-points-<?=$product['product_id']?>-<?=$option_row?>-<?=$option_value_row?>" type="text" name="points" value="<?= $product_option_value['points'] ?>" placeholder="<?= $entry_option_points ?>" class="le-value _simple-value-2 _right-half" data-field="points" />
										<select id="input-points-prefix-<?=$product['product_id']?>-<?=$option_row?>-<?=$option_value_row?>" name="points_prefix" class="le-value _simple-value-2 le-selector _right-half" data-field="points_prefix">
											<?php if ($product_option_value['points_prefix'] == '+') { ?>
											<option value="+" selected="selected">+</option>
											<?php } else { ?>
											<option value="+">+</option>
											<?php } ?>
											<?php if ($product_option_value['points_prefix'] == '-') { ?>
											<option value="-" selected="selected">-</option>
											<?php } else { ?>
											<option value="-">-</option>
											<?php } ?>
										</select>
									</div>

									<div class="le-row">
										<label class="le-label _left"><?= $entry_weight ?></label>
										<input id="input-weight-<?=$product['product_id']?>-<?=$option_row?>-<?=$option_value_row?>"type="text" name="weight" value="<?php echo $product_option_value['weight']; ?>" placeholder="<?php echo $entry_weight; ?>" class="le-value _simple-value-2 _right-half" data-field="weight" />
										<select id="input-weight-prefix-<?=$product['product_id']?>-<?=$option_row?>-<?=$option_value_row?>" name="weight_prefix" class="le-value _simple-value-2 le-selector _right-half" data-field="weight_prefix">
											<?php if ($product_option_value['weight_prefix'] == '+') { ?>
											<option value="+" selected="selected">+</option>
											<?php } else { ?>
											<option value="+">+</option>
											<?php } ?>
											<?php if ($product_option_value['weight_prefix'] == '-') { ?>
											<option value="-" selected="selected">-</option>
											<?php } else { ?>
											<option value="-">-</option>
											<?php } ?>
										</select>
									</div>

								</div>
								<?php $option_value_row++; ?>
								<?php } ?>
								<script>$('#option-values-<?=$product['product_id']?>-<?=$option_row?>').attr('data-option-value-row', <?=$option_value_row?>);</script>
							</div>
							<button type="button" data-toggle="tooltip" data-target="#option-values-<?=$product['product_id']?>-<?=$option_row?>" title="<?=$button_option_value_add?>" class="btn btn-sm btn-primary btn-add-product-option-value"><i class="fa fa-plus-circle"></i></button>
							<?php } ?>
							<!-- option values . end -->
						</div>
					</div>
					<?php $option_row++ ?>
					<?php } ?>
					<script>$('#options-container-<?=$product['product_id']?>').attr('data-option-row', <?=$option_row?>);</script>
				</div>
				<button type="button" class="btn btn-sm btn-success btn-add-option" data-toggle="tooltip" title="<?=$button_add?>" data-target="#options-container-<?=$product['product_id']?>" data-product-id="<?=$product['product_id']?>" data-option-row="<?=$option_row?>"><i class="fa fa-plus"></i></button>
      </td>
      <?php } ?>

      <!-- Action -->
      <td id="action-<?=$product['product_id']?>" class="action text-right <?= !isset($a_product_list_field['attribute']) && !isset($a_product_list_field['option']) ? 'prevent-wide-images__action' : '' ?>">
				<button type="button" class="btn btn-danger btn-delete-product" data-toggle="tooltip" title="<?=$hpm_button_delete_product?>" data-product-id="<?=$product['product_id']?>"><i class="fa fa-close"></i></button>
				<br>
        <br>
				<a href="<?=$product['edit']?>" target="_blank" data-toggle="tooltip" title="<?=$button_edit?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
				<br>
        <br>
        <a href="<?=$product['view_in_catalog']?>" target="_blank"><i class="fa fa-eye"></i> <?=$hpm_text_view_product_in_catalog?></a>
				<!--
        <br>
        <br>
        <a href="<?=$product['edit_in_system_mode']?>"  target="_blank"><i class="fa fa-pencil"></i> <?=$hpm_text_edit_product_in_system_mode?></a>
				-->
      </td>

    </tr>
    <?php } ?>
    <?php } else { ?>
    <tr>
      <td class="text-center" colspan="8"><div class="alert alert-danger"><?=$text_no_results?></div></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<div class="row">
  <div class="col-sm-6 text-left hpm-pagination"><?php echo $pagination; ?></div>
  <div class="col-sm-6 text-right"><?php echo $results; ?></div>
</div>