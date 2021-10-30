<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">

  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-owlcarousel" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>

  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $entry_tab_options; ?></h3>
      </div>

      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-owlcarousel" class="form-horizontal">

        <div id="tab-module" class="vtabs-content">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-settings" data-toggle="tab"><?php echo $entry_main; ?></a></li>
            <li><a href="#tab-product" data-toggle="tab"><?php echo $entry_product; ?></a></li>
            <li><a href="#tab-additional" data-toggle="tab"><?php echo $entry_additional; ?></a></li>
            <li><a href="#tab-display" data-toggle="tab"><?php echo $entry_display; ?></a></li>
          </ul>

          <div class="tab-content">

            <div class="tab-pane active" id="tab-settings">
              <div class="tab-pane">
                <ul class="nav nav-tabs" id="language">
                  <?php foreach ($languages as $language) { ?>
                  <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                  <?php } ?>
                </ul>

                <div class="tab-content">
                  <?php foreach ($languages as $language) { ?>
                    <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                      <div class="form-group required">
                        <label class="col-sm-2 control-label" for="title-<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                        <div class="col-sm-10">
                          <input type="text" name="owlcarousel_module[title][<?php echo $language['language_id']; ?>]" id="title-<?php echo $language['language_id']; ?>" value="<?php echo isset($module['title'][$language['language_id']]) ? $module['title'][$language['language_id']] : ''; ?>" class="form-control" />
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>

              <div class="form-group required">
                <label class="col-sm-2 control-label"><?php echo $entry_add_block_name; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="owlcarousel_module[name]" value="<?php echo $module['name']; ?>" class="form-control" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="owlcarousel_module[status]" class="form-control">
                      <?php if ($module['status']) { ?>
                      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                      <option value="0"><?php echo $text_disabled; ?></option>
                      <?php } else { ?>
                      <option value="1"><?php echo $text_enabled; ?></option>
                      <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                      <?php } ?>
                    </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_add_class_name; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="owlcarousel_module[add_class_name]" value="<?php echo $module['add_class_name']; ?>" class="form-control" />
                </div>
              </div>
            </div>

            <div class="tab-pane" id="tab-product">
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_source; ?></label>
                <div class="col-sm-10">
                  <select name="owlcarousel_module[category_id]" id="select" onchange="showhide();" class="form-control">
                    <option value="0" <?php if ($module['category_id']=='0') { ?>selected="selected"<?php } ?>><?php echo $text_all_product; ?></option>
                    <option value="viewed" <?php if ($module['category_id']=='viewed') { ?>selected="selected"<?php } ?>><?php echo $text_viewed; ?></option>
                    <option value="featured" <?php if ($module['category_id']=='featured') { ?>selected="selected"<?php } ?>><?php echo $text_featured; ?></option>
                    <?php foreach ($rootcats as $rootcat) { ?>
                    <?php if ($rootcat['category_id'] == $module['category_id']) { ?>
                    <option value="<?php echo $rootcat['category_id']; ?>" selected="selected"><?php echo $rootcat['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $rootcat['category_id']; ?>"><?php echo $rootcat['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <?php if ($module['category_id'] == 'featured') {
                $show_block = "block";
              } else {
                $show_block = "none";
              } ?>

              <div class="form-group" id="rowfeatured" style="display:<?php echo $show_block; ?>;">
                <label class="col-sm-2 control-label" for="visible"><span data-toggle="tooltip" title="<?php echo $help_category ?>"><?php echo $entry_category; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="product" value="" placeholder="<?php echo $entry_product; ?>" id="input-product" class="form-control" />

                  <br/>
                  <div class="scrollbox well well-sm" id="featured-product" style="height: 150px; overflow: auto;">
                    <?php $class = 'odd'; ?>
                    <?php foreach ($products as $product) { ?>
                        <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                        <div id="featured-product<?php echo $product['product_id']; ?>" class="<?php echo $class; ?>"><?php echo $product['name']; ?> <i class="fa fa-minus-circle"></i>
                              <input type="hidden" value="<?php echo $product['product_id']; ?>" />
                        </div>
                    <?php } ?>
                  </div>
                  <input type="hidden" name="owlcarousel_module[featured]" value="<?php echo $module['featured']; ?>" />
                </div>
              </div>

              <?php if ($module['category_id'] == 'viewed') {
                $show_block = "block";
              } else {
                $show_block = "none";
              } ?>

              <div class="form-group" id="rowviewed" style="display:<?php echo $show_block; ?>;">
                <div class="col-sm-10 col-sm-push-2">
                  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $text_hide_module; ?></div>
                </div>
              </div>

              <?php if ($module['category_id']=='featured' || $module['category_id']=='viewed') {
                $hide_block = "none";
              } else {
                $hide_block = "block";
              } ?>

              <div class="form-group" id="rowcategory" style="display:<?php echo $hide_block;?>;">
                <label class="col-sm-2 control-label"><?php echo $entry_manufacturer; ?></label>
                <div class="col-sm-10 scrollbox" id="featured-product">
                  <select name="owlcarousel_module[manufacturer_id]" id="select" class="form-control">
                    <option value="0" <?php if ($module['manufacturer_id']=='0') { ?>selected="selected"<?php } ?>><?php echo $text_all_manufacturers; ?></option>
                    <?php if (isset($manufacturers)){
                    foreach ($manufacturers as $manufacturer) { ?>
                    <?php if ($manufacturer['manufacturer_id'] == $module['manufacturer_id']) { ?>
                    <option value="<?php echo $manufacturer['manufacturer_id']; ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group" id="rowsort" style="display:<?php echo $hide_block;?>;">
                <label class="col-sm-2 control-label"><?php echo $entry_sort; ?></label>
                <div class="col-sm-10">
                  <select name="owlcarousel_module[sort]" class="form-control">
                    <?php if ($module['sort'] == 'p.date_added') { ?>
                    <option value="p.date_added" selected="selected"><?php echo $text_sort_date_added; ?></option>
                    <?php } else { ?>
                    <option value="p.date_added"><?php echo $text_sort_date_added; ?></option>
                    <?php } ?>

                    <?php if ($module['sort'] == 'rating') { ?>
                    <option value="rating" selected="selected"><?php echo $text_sort_rating; ?></option>
                    <?php } else { ?>
                    <option value="rating"><?php echo $text_sort_rating; ?></option>
                    <?php } ?>

                    <?php if ($module['sort'] == 'p.viewed') { ?>
                    <option value="p.viewed" selected="selected"><?php echo $text_sort_viewed; ?></option>
                    <?php } else { ?>
                    <option value="p.viewed"><?php echo $text_sort_viewed; ?></option>
                    <?php } ?>

                    <?php if ($module['sort'] == 'p.sort_order') { ?>
                    <option value="p.sort_order" selected="selected"><?php echo $text_sort_order; ?></option>
                    <?php } else { ?>
                    <option value="p.sort_order"><?php echo $text_sort_order; ?></option>
                    <?php } ?>

                    <?php if ($module['sort'] == 'topsellers') { ?>
                    <option value="topsellers" selected="selected"><?php echo $text_sort_bestseller; ?></option>
                    <?php } else { ?>
                    <option value="topsellers"><?php echo $text_sort_bestseller; ?></option>
                    <?php } ?>

                    <?php if ($module['sort'] == 'special') { ?>
                    <option value="special" selected="selected"><?php echo $text_sort_special; ?></option>
                    <?php } else { ?>
                    <option value="special"><?php echo $text_sort_special; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_image; ?></label>
                <div class="col-sm-5">
                  <input type="text" name="owlcarousel_module[image_width]" value="<?php echo $module['image_width']; ?>" class="form-control" />
                </div>

                <div class="col-sm-5">
                  <input type="text" name="owlcarousel_module[image_height]" value="<?php echo $module['image_height']; ?>" class="form-control" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_description; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="owlcarousel_module[description]" value="<?php echo $module['description']; ?>" class="form-control" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="count"><span data-toggle="tooltip" title="<?php echo $help_count ?>"><?php echo $entry_count; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="owlcarousel_module[count]" value="<?php echo $module['count']; ?>" class="form-control" id="count" />
                </div>
              </div>

              <div class="form-group">
                 <label class="col-sm-2 control-label" for="visible"><span data-toggle="tooltip" title="<?php echo $help_visible ?>"><?php echo $entry_visible; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="owlcarousel_module[visible]" value="<?php echo $module['visible']; ?>" class="form-control" id="visible" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="visible_1000"><span data-toggle="tooltip" title="<?php echo $help_visible_1000 ?>"><?php echo $entry_visible_1000; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="owlcarousel_module[visible_1000]" value="<?php echo $module['visible_1000']; ?>" class="form-control" id="visible_1000" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="visible_900"><span data-toggle="tooltip" title="<?php echo $help_visible_900 ?>"><?php echo $entry_visible_900; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="owlcarousel_module[visible_900]" value="<?php echo $module['visible_900']; ?>" class="form-control" id="visible_900" />
                </div>
              </div>

              <div class="form-group">
                 <label class="col-sm-2 control-label" for="visible_600"><span data-toggle="tooltip" title="<?php echo $help_visible_600 ?>"><?php echo $entry_visible_600; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="owlcarousel_module[visible_600]" value="<?php echo $module['visible_600']; ?>" class="form-control" id="visible_600" />
                </div>
              </div>

              <div class="form-group">
               <label class="col-sm-2 control-label" for="visible_479"><span data-toggle="tooltip" title="<?php echo $help_visible_479 ?>"><?php echo $entry_visible_479; ?></label>
                <div class="col-sm-10">
                 <input type="text" name="owlcarousel_module[visible_479]" value="<?php echo $module['visible_479']; ?>" class="form-control" id="visible_479" />
                </div>
              </div>
            </div>

            <div class="tab-pane" id="tab-additional">
              <div class="form-group">
               <label class="col-sm-2 control-label" for="slide_speed"><span data-toggle="tooltip" title="<?php echo $help_slide_speed; ?>"><?php echo $entry_slide_speed; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="owlcarousel_module[slide_speed]" value="<?php echo $module['slide_speed']; ?>" class="form-control" id="slide_speed" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="pagination_speed"><span data-toggle="tooltip" title="<?php echo $help_pagination_speed; ?>"><?php echo $entry_pagination_speed; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="owlcarousel_module[pagination_speed]" value="<?php echo $module['pagination_speed']; ?>" class="form-control" id="pagination_speed" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="autoscroll"><span data-toggle="tooltip" title="<?php echo $help_autoscroll; ?>"><?php echo $entry_autoscroll; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="owlcarousel_module[autoscroll]" value="<?php echo $module['autoscroll']; ?>" class="form-control" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="item_prev_next"><span data-toggle="tooltip" title="<?php echo $help_item_prev_next; ?>"><?php echo $entry_item_prev_next; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="owlcarousel_module[item_prev_next]" value="<?php echo $module['item_prev_next']; ?>" class="form-control" />
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_per_page ?>"><?php echo $entry_per_page; ?></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_per_page"></label>
                    <input id="no_per_page" type="radio" name="owlcarousel_module[show_per_page]" value="0" <?php if(isset($module['show_per_page']) && $module['show_per_page'] == '0') echo "checked='checked'"?> />
                    <label for="yes_per_page"></label>
                    <input id="yes_per_page" type="radio" name="owlcarousel_module[show_per_page]" value="1" <?php if(!isset($module['show_per_page']) || $module['show_per_page'] == '1') echo "checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_random_item; ?></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_random_item"></label>
                    <input id="no_random_item" type="radio" name="owlcarousel_module[show_random_item]" value="0" <?php if(isset($module['show_random_item']) && $module['show_random_item'] == '0') echo "checked='checked'"?> />
                    <label for="yes_random_item"></label>
                    <input id="yes_random_item" type="radio" name="owlcarousel_module[show_random_item]" value="1" <?php if(!isset($module['show_random_item']) || $module['show_random_item'] == '1') echo "checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_stock; ?></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_stock"></label>
                    <input id="no_stock" type="radio" name="owlcarousel_module[show_stock]" value="0" <?php if(isset($module['show_stock']) && $module['show_stock'] == '0') echo "checked='checked'"?> />
                    <label for="yes_stock"></label>
                    <input id="yes_stock" type="radio" name="owlcarousel_module[show_stock]" value="1" <?php if(!isset($module['show_stock']) || $module['show_stock'] == '1') echo "checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_current_category; ?>"><?php echo $entry_current_category; ?></span></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_current_category"></label>
                    <input id="no_current_category" type="radio" name="owlcarousel_module[show_current_category]" value="0" <?php if(isset($module['show_current_category']) && $module['show_current_category'] == '0') echo "checked='checked'"?> />
                    <label for="yes_current_category"></label>
                    <input id="yes_current_category" type="radio" name="owlcarousel_module[show_current_category]" value="1" <?php if(!isset($module['show_current_category']) || $module['show_current_category'] == '1') echo "checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_current_product; ?>"><?php echo $entry_current_product; ?></span></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_current_product"></label>
                    <input id="no_current_product" type="radio" name="owlcarousel_module[show_current_product]" value="0" <?php if(isset($module['show_current_product']) && $module['show_current_product'] == '0') echo "checked='checked'"?> />
                    <label for="yes_current_product"></label>
                    <input id="yes_current_product" type="radio" name="owlcarousel_module[show_current_product]" value="1" <?php if(!isset($module['show_current_product']) || $module['show_current_product'] == '1') echo "checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="hide_module"><span data-toggle="tooltip" title="<?php echo $help_hide_module; ?>"><?php echo $entry_hide_module; ?></span></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_hide_module"></label>
                    <input id="no_hide_module" type="radio" name="owlcarousel_module[hide_module]" value="0" <?php if(isset($module['hide_module']) && $module['hide_module'] == '0') echo "checked='checked'"?> />
                    <label for="yes_hide_module"></label>
                    <input id="yes_hide_module" type="radio" name="owlcarousel_module[hide_module]" value="1" <?php if(!isset($module['hide_module']) || $module['hide_module'] == '1') echo "checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="use_cache"><?php echo $entry_use_cache; ?></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_use_cache"></label>
                    <input id="no_use_cache" type="radio" name="owlcarousel_module[use_cache]" value="0" <?php if(isset($module['use_cache']) && $module['use_cache'] == '0') echo "checked='checked'"?> />
                    <label for="yes_use_cache"></label>
                    <input id="yes_use_cache" type="radio" name="owlcarousel_module[use_cache]" value="1" <?php if(!isset($module['use_cache']) || $module['use_cache'] == '1') echo "checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="tab-pane" id="tab-display">
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_show_title; ?></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_title"></label>
                    <input id="no_title" type="radio" name="owlcarousel_module[show_title]" value="0" <?php if(isset($module['show_title']) && $module['show_title'] == '0') echo " checked='checked'"?> />
                    <label for="yes_title"></label>
                    <input id="yes_title" type="radio" name="owlcarousel_module[show_title]" value="1" <?php if(!isset($module['show_title']) || $module['show_title'] == '1') echo " checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_show_name; ?></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_name"></label>
                    <input id="no_name" type="radio" name="owlcarousel_module[show_name]" value="0" <?php if(isset($module['show_name']) && $module['show_name'] == '0') echo " checked='checked'"?> />
                    <label for="yes_name"></label>
                    <input id="yes_name" type="radio" name="owlcarousel_module[show_name]" value="1" <?php if(!isset($module['show_name']) || $module['show_name'] == '1') echo " checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_show_desc; ?></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_desc"></label>
                    <input id="no_desc" type="radio" name="owlcarousel_module[show_desc]" value="0" <?php if(isset($module['show_desc']) && $module['show_desc'] == '0') echo " checked='checked'"?> />
                    <label for="yes_desc"></label>
                    <input id="yes_desc" type="radio" name="owlcarousel_module[show_desc]" value="1" <?php if(!isset($module['show_desc']) || $module['show_desc'] == '1') echo " checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_show_price; ?></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_price"></label>
                    <input id="no_price" type="radio" name="owlcarousel_module[show_price]" value="0" <?php if(isset($module['show_price']) && $module['show_price'] == '0') echo " checked='checked'"?> />
                    <label for="yes_price"></label>
                    <input id="yes_price" type="radio" name="owlcarousel_module[show_price]" value="1" <?php if(!isset($module['show_price']) || $module['show_price'] == '1') echo " checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_show_rate; ?></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_rate"></label>
                    <input id="no_rate" type="radio" name="owlcarousel_module[show_rate]" value="0" <?php if(isset($module['show_rate']) && $module['show_rate'] == '0') echo " checked='checked'"?> />
                    <label for="yes_rate"></label>
                    <input id="yes_rate" type="radio" name="owlcarousel_module[show_rate]" value="1" <?php if(!isset($module['show_rate']) || $module['show_rate'] == '1') echo " checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_show_cart; ?></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_show_cart"></label>
                    <input id="no_show_cart" type="radio" name="owlcarousel_module[show_cart]" value="0" <?php if(isset($module['show_cart']) && $module['show_cart'] == '0') echo " checked='checked'"?> />
                    <label for="yes_show_cart"></label>
                    <input id="yes_show_cart" type="radio" name="owlcarousel_module[show_cart]" value="1" <?php if(!isset($module['show_cart']) || $module['show_cart'] == '1') echo " checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_show_wishlist; ?></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_show_wishlist"></label>
                    <input id="no_show_wishlist" type="radio" name="owlcarousel_module[show_wishlist]" value="0" <?php if(isset($module['show_wishlist']) && $module['show_wishlist'] == '0') echo " checked='checked'"?> />
                    <label for="yes_show_wishlist"></label>
                    <input id="yes_show_wishlist" type="radio" name="owlcarousel_module[show_wishlist]" value="1" <?php if(!isset($module['show_wishlist']) || $module['show_wishlist'] == '1') echo " checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_show_compare; ?></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_show_compare"></label>
                    <input id="no_show_compare" type="radio" name="owlcarousel_module[show_compare]" value="0" <?php if(isset($module['show_compare']) && $module['show_compare'] == '0') echo " checked='checked'"?> />
                    <label for="yes_show_compare"></label>
                    <input id="yes_show_compare" type="radio" name="owlcarousel_module[show_compare]" value="1" <?php if(!isset($module['show_compare']) || $module['show_compare'] == '1') echo " checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_show_page; ?></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_show_page"></label>
                    <input id="no_show_page" type="radio" name="owlcarousel_module[show_page]" value="0" <?php if(isset($module['show_page']) && $module['show_page'] == '0') echo " checked='checked'"?> />
                    <label for="yes_show_page"></label>
                    <input id="yes_show_page" type="radio" name="owlcarousel_module[show_page]" value="1" <?php if(!isset($module['show_page']) || $module['show_page'] == '1') echo " checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_show_nav; ?></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_show_nav"></label>
                    <input id="no_show_nav" type="radio" name="owlcarousel_module[show_nav]" value="0" <?php if(isset($module['show_nav']) && $module['show_nav'] == '0') echo " checked='checked'"?> />
                    <label for="yes_show_page"></label>
                    <input id="yes_show_nav" type="radio" name="owlcarousel_module[show_nav]" value="1" <?php if(!isset($module['show_nav']) || $module['show_nav'] == '1') echo " checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_show_lazy_load; ?></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_show_lazy_load"></label>
                    <input id="no_show_lazy_load" type="radio" name="owlcarousel_module[show_lazy_load]" value="0" <?php if(isset($module['show_lazy_load']) && $module['show_lazy_load'] == '0') echo " checked='checked'"?> />
                    <label for="yes_show_lazy_load"></label>
                    <input id="yes_show_lazy_load" type="radio" name="owlcarousel_module[show_lazy_load]" value="1" <?php if(!isset($module['show_lazy_load']) || $module['show_lazy_load'] == '1') echo " checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_show_mouse_drag; ?></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_show_mouse_drag"></label>
                    <input id="no_show_mouse_drag" type="radio" name="owlcarousel_module[show_mouse_drag]" value="0" <?php if(isset($module['show_mouse_drag']) && $module['show_mouse_drag'] == '0') echo " checked='checked'"?> />
                    <label for="yes_show_mouse_drag"></label>
                    <input id="yes_show_mouse_drag" type="radio" name="owlcarousel_module[show_mouse_drag]" value="1" <?php if(!isset($module['show_mouse_drag']) || $module['show_mouse_drag'] == '1') echo " checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_show_touch_drag; ?></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_show_touch_drag"></label>
                    <input id="no_show_touch_drag" type="radio" name="owlcarousel_module[show_touch_drag]" value="0" <?php if(isset($module['show_touch_drag']) && $module['show_touch_drag'] == '0') echo " checked='checked'"?> />
                    <label for="yes_show_touch_drag"></label>
                    <input id="yes_show_touch_drag" type="radio" name="owlcarousel_module[show_touch_drag]" value="1" <?php if(!isset($module['show_touch_drag']) || $module['show_touch_drag'] == '1') echo " checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_stop_on_hover; ?></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_show_stop_on_hover"></label>
                    <input id="no_show_stop_on_hover" type="radio" name="owlcarousel_module[show_stop_on_hover]" value="0" <?php if(isset($module['show_stop_on_hover']) && $module['show_stop_on_hover'] == '0') echo " checked='checked'"?> />
                    <label for="yes_show_stop_on_hover"></label>
                    <input id="yes_show_stop_on_hover" type="radio" name="owlcarousel_module[show_stop_on_hover]" value="1" <?php if(!isset($module['show_stop_on_hover']) || $module['show_stop_on_hover'] == '1') echo " checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Бесконечная прокрутка</label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_show_loop"></label>
                    <input id="no_show_loop" type="radio" name="owlcarousel_module[show_loop]" value="0" <?php if(isset($module['show_loop']) && $module['show_loop'] == '0') echo " checked='checked'"?> />
                    <label for="yes_show_loop"></label>
                    <input id="yes_show_loop" type="radio" name="owlcarousel_module[show_loop]" value="1" <?php if(!isset($module['show_loop']) || $module['show_loop'] == '1') echo " checked='checked'"?> />
                    <span></span>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_show_tabs; ?></label>
                <div class="col-sm-10">
                  <div class="switch">
                    <label for="no_show_tabs"></label>
                    <input id="no_show_tabs" type="radio" name="owlcarousel_module[show_tabs]" value="0" <?php if(isset($module['show_tabs']) && $module['show_tabs'] == '0') echo " checked='checked'"?> />
                    <label for="yes_show_tabs"></label>
                    <input id="yes_show_tabs" type="radio" name="owlcarousel_module[show_tabs]" value="1" <?php if(!isset($module['show_tabs']) || $module['show_tabs'] == '1') echo " checked='checked'"?> />
                    <span></span>
                  </div>

                  <div id="other_modules">
                    <?php foreach ($other_modules as $other) { ?>
                      <div>
                        <label><input type="checkbox" value="1" name="owlcarousel_module[display_with][<?php echo $other['id'] ?>]" <?php echo isset($module['display_with'][$other['id']]) ? 'checked="checked"' : '' ?>>&nbsp;<?php echo $other['name'] ?></label>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
              <label class="col-sm-2 control-label">Шаблон</label>
              <div class="col-sm-10">
                <div class="switch">
                  <select name="owlcarousel_module[template]" id="input-template" class="form-control">
                    <?php if ($module['template'] == 'for_account' ) { ?>
                    <option value="for_account" selected="selected">For account</option>
                    <option value="default">Default</option>
                    <?php } else { ?>
                    <option value="default" selected="selected">Default</option>
                    <option value="for_account">For account</option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>

            </div>

          </div>

        </div>

        </form>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function showhide() {
    var $select = $('#select');
    var selectedValue = $select.val();
    $("#rowfeatured")[selectedValue == 'featured' ? 'show' : 'hide'] ();
    $("#rowviewed")[selectedValue == 'viewed' ? 'show' : 'hide'] ();
    $("#rowcategory")[selectedValue == 'featured' || selectedValue == 'viewed' ? 'hide' : 'show'] ();
    $("#rowsort, #rowbrand")[selectedValue == 'featured' || selectedValue == 'viewed' ? 'hide' : 'show'] ();
  }
</script>


<script type="text/javascript"><!--

  $(document).ready(function(){
    sortable_product();
  });

  function sortable_product(){
    $('#featured-product').sortable({
        cursor: 'move'
    });
    $('#featured-product').disableSelection();
  }

  $('#featured-product div img').on('click', function() {
    var modid = $(".selected").attr('modid');
    $(this).parent().remove();

    $('#featured-product'+ modid +' div:odd').attr('class', 'odd');
    $('#featured-product'+ modid +' div:even').attr('class', 'even');

    data = $.map($('#featured-product'+ modid +' input'), function(element){
      return $(element).attr('value');
    });

    $('input[name=\'owlcarousel_module[' + modid + '][featured]\']').attr('value', data.join());
  });

  $('#module-add').before('<a href="#tab-module" modid =" id="module"><?php echo $add_tab_module; ?>&nbsp;<img src="view/image/delete.png" alt="" onclick="$(\'.vtabs a:first\').trigger(\'click\'); $(\'#module\').remove(); $(\'#tab-module\').remove(); return false;" /></a>');

  //$('.vtabs a').tabs();
  $('#module').trigger('click');
//--></script>

<script type="text/javascript"><!--
  $('input[name=\'product\']').autocomplete({
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {
          response($.map(json, function(item) {
            return {
              label: item['name'],
              model: item['model'],
              sku: item['sku'],
              height: item['height'],
              width: item['width'],
              length: item['length'],
              value: item['product_id']
            }
          }));
          sortable_product()
        }
      });
    },
    select: function(item) {
        $('#featured-product' + item.value).remove();

        $('#featured-product').append('<div id="featured-product' +  item.value + '">' + item.label + '|' + item.sku + ' <i class="fa fa-minus-circle"></i><input type="hidden" value="' + item.value + '" /></div>');

        $('#featured-product div:odd').attr('class', 'odd');
        $('#featured-product div:even').attr('class', 'even');

        var data = $.map($('#featured-product input'), function(element){
          return $(element).attr('value');
        });

        $('input[name=\'owlcarousel_module[featured]\']').attr('value', data.join());

        sortable_product()
    }
  });

  $('.scrollbox').on('click', '.fa-minus-circle', function() {
    $(this).parent().remove();

    $('#featured-product div:odd').attr('class', 'odd');
    $('#featured-product div:even').attr('class', 'even');

    var data = $.map($('#featured-product input'), function(element){
      return $(element).attr('value');
    });

    $('input[name=\'owlcarousel_module[featured]\']').attr('value', data.join());
  });
//--></script>

<script type="text/javascript"><!--
  $('#language a:first').tab('show');
//-->
</script>

<script type="text/javascript"><!--
  $(function(){
    function display_other_modules() {
      if (~~$('input[name*=show_tabs]:checked').val()) {
        $('#other_modules').show();
      } else {
        $('#other_modules').hide();
      }
    }

    $('input[name*=show_tabs]').on('change', display_other_modules);

    display_other_modules();
  });
//--></script>


<style type="text/css">
.switch *,.switch:after,.switch:before{-webkit-box-sizing:border-box;box-sizing:border-box}.switch{height:30px;margin:3px auto;font-size:0;position:relative}.switch label{color:#000;opacity:.33;-webkit-transition:opacity .3s ease;transition:opacity .3s ease;cursor:pointer;display:inline-block;width:0;height:0;visibility:hidden;overflow:hidden}.switch label+input{margin-left:10px}.switch span{height:100%;border-radius:30px;padding:4px;overflow:hidden;-webkit-transition:.3s ease all;transition:.3s ease all;background:#fff;border:2px solid #e3e3e3;position:absolute;width:60px;left:0}.switch span:before{content:"";border-radius:50%;background:#fff;position:absolute;-webkit-transition:.3s ease all;transition:.3s ease all;height:30px;width:30px;top:-2px}.switch input{position:absolute;top:0;z-index:2;opacity:0;cursor:pointer;height:30px;width:60px;left:-10px;margin:0}.switch input~input:checked~span{background:#1e91cf}.switch input~input:checked~span:before{left:28px}.switch input:checked{z-index:1}.switch input:checked+label{opacity:1;cursor:default}.switch input:checked~span:before{border:2px solid #e3e3e3;left:-1px}.switch input:not(:checked)+label:hover{opacity:.5}
</style>
<?php echo $footer; ?>
