<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-attribute" data-toggle="tooltip" title="<?php echo $button_save; ?>"
                        class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
                   class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <img width="36" height="36" style="float:left" src="view/image/neoseo.png" alt="">
            <h1><?php echo $heading_title_raw; ?></h1>
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
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-attribute" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4"><?php echo $entry_feed_status; ?></label>
                        <div class="col-sm-8">
                            <select id="active" name="feed[status]" class="form-control">
                                <option value="0"
                                    <?php if( !$feed['status'] ) echo 'selected="selected"';?>><?php echo $text_disabled; ?></option>
                                <option value="1" <?php if( $feed['status'] ) echo 'selected="selected"';?>><?php echo $text_enabled; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4"><?php echo $entry_feed_format_name; ?></label>
                        <div class="col-sm-8">
                            <select id="active" name="feed[id_format]" class="form-control">
                                <?php foreach($formats as $id_format=>$format){ ?>
                                    <option value="<?php echo $format['product_feed_format_id'];?>"
                                        <?php echo ($id_format==$feed['id_format'])? 'selected="selected"': '';?>
                                    ><?php echo $format['feed_format_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4"><?php echo $entry_replace; ?></label>
                        <div class="col-sm-8">
                            <select id="active" name="feed[replace_break]" class="form-control">
                                <option value="0" <?php if (!$feed['replace_break']) { ?>selected="selected"<?php } ?>><?php echo $text_disabled; ?></option>
                                <option value="1" <?php if ($feed['replace_break']) { ?>selected="selected"<?php } ?>><?php echo $text_enabled; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4"><?php echo $entry_feed_name; ?></label>
                        <div class="col-sm-8">
                            <input name="feed[feed_name]" class="form-control" value="<?php echo $feed['feed_name']?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="col-sm-4"><?php echo $entry_feed_shortname; ?></span>
                        <div class="col-sm-8">
                            <input name="feed[feed_shortname]" class="form-control"
                                   value="<?php echo $feed['feed_shortname'];?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4"><?php echo $entry_store; ?></label>
                        <div class="col-sm-8">
                            <div class="well well-sm" style="height: 150px; overflow: auto; margin-bottom:0;">
                                <div class="checkbox">
                                    <label>
                                        <?php if (in_array(0, $product_feed_store)) { ?>
                                        <input type="checkbox" name="feed[product_feed_store][]" value="0" checked="checked" />
                                        <?php echo $text_default; ?>
                                        <?php } else { ?>
                                        <input type="checkbox" name="feed[product_feed_store][]" value="0" />
                                        <?php echo $text_default; ?>
                                        <?php } ?>
                                    </label>
                                </div>

                                <?php foreach ($stores as $store) { ?>
                                <div class="checkbox">
                                    <label>
                                        <?php if (in_array($store['store_id'], $product_feed_store)) { ?>
                                        <input type="checkbox" name="feed[product_feed_store][]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                                        <?php echo $store['name']; ?>
                                        <?php } else { ?>
                                        <input type="checkbox" name="feed[product_feed_store][]" value="<?php echo $store['store_id']; ?>" />
                                        <?php echo $store['name']; ?>
                                        <?php } ?>
                                    </label>
                                </div>
                                <?php } ?>
                            </div>
                            <button type="button" class="text_select_all btn btn-primary"><i class="fa fa-pencil"></i> <?php echo $text_select_all; ?></button>
                            <button type="button" class="text_unselect_all btn btn-danger"><i class="fa fa-pencil"></i> <?php echo $text_unselect_all; ?></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-sm-4"><?php echo $entry_ip_list; ?></span>
                        <div class="col-sm-8">
                            <textarea id="ip_list" rows="3" style="width:100%" name="feed[ip_list]"
                                      class="form-control"><?php echo $feed['ip_list']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="col-sm-4"><?php echo $entry_language_id; ?></span>
                        <div class="col-sm-8">
                            <select id="active" name="feed[language_id]" class="form-control">
                                <?php foreach($languages as $language_id=> $language){ ?>
                                    <option value="<?php echo $language_id;?>"
                                        <?php echo ($language_id==$feed['language_id'])? 'selected="selected"': '';?>
                                    ><?php echo $language; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="col-sm-4"><?php echo $entry_use_main_category; ?>
                            <br><?php echo $entry_use_main_category_desc; ?>
                        </span>
                        <div class="col-sm-8">
                            <select id="active" name="feed[use_main_category]" class="form-control">
                                <option value="0"
                                    <?php if( !$feed['use_main_category'] ) echo 'selected="selected"';?>
                                ><?php echo $text_disabled; ?></option>
                                <option value="1"
                                    <?php if( $feed['use_main_category'] ) echo 'selected="selected"';?>
                                ><?php echo $text_enabled; ?></option>
                            </select>
                        </div>
                    </div>
                    <!-- NeoSeo Exchange1c - begin -->
                    <?php if($use_warehouses) { ?>
                    <div class="form-group">
                        <label class="col-sm-4"><?php echo $entry_use_warehouse_quantity; ?></label>
                        <div class="col-sm-8">
                            <select name="feed[use_warehouse_quantity]" class='form-control' id="use_warehouse_quantity">
                                <option value="0"<?php if( !$feed['use_warehouse_quantity'] ) echo 'selected="selected"';?>><?php echo $text_disabled; ?></option>
                                <option value="1"<?php if( $feed['use_warehouse_quantity'] ) echo 'selected="selected"';?>><?php echo $text_enabled; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group show_warehouses">
                        <span class="col-sm-4"><?php echo $entry_warehouse; ?></span>
                        <div class="col-sm-8">
                            <div class="well well-sm" style="min-height: 150px;max-height: 400px;overflow: auto;">
                                <?php $class = 'odd'; ?>
                                <?php foreach( $warehouses as $warehouse_id => $warehouse_name) { ?>
                                    <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                    <div class="<?php echo $class; ?>">
                                        <label><input class="category" type="checkbox" name='feed[warehouses][]'
                                                      value="<?php echo $warehouse_id;?>" data="<?php echo $warehouse_name;?>"
                                                <?php if( in_array($warehouse_id, explode(',',$feed['warehouses']))) echo ' checked="checked"'; ?>
                                            />
                                            <?php echo $warehouse_name;?></label>
                                    </div>
                                <?php } ?>
                            </div>
                            <button type="button" class="text_select_all btn btn-primary"><i class="fa fa-pencil"></i> <?php echo $text_select_all; ?></button>
                            <button type="button" class="text_unselect_all btn btn-danger"><i class="fa fa-pencil"></i> <?php echo $text_unselect_all; ?></button>
                        </div>
                    </div>
                    <?php } ?>
                    <!-- NeoSeo Exchange1c - end -->
                    <div class="form-group">
                        <label class="col-sm-4"><?php echo $entry_use_categories; ?></label>
                        <div class="col-sm-8">
                            <select name="feed[use_categories]" class='form-control' id="use_categories">
                                <option value="0" selected="selected"><?php echo $text_none; ?></option>
                                <?php foreach ($feedMainCategories as $category) { ?>
                                    <?php if ($category['category_id'] == $feed['use_categories']) { ?>
                                        <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="col-sm-4"><?php echo $entry_categories; ?></span>
                        <div class="col-sm-8" id="list_categories_default">
                            <div class="well well-sm" style="min-height: 150px;max-height: 400px;overflow: auto;">
                                <?php $class = 'odd'; ?>
                                <?php foreach( $categories as $category_id=> $category) { ?>
                                    <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                    <div class="<?php echo $class; ?>">
                                        <label><input class="category" type="checkbox" name='feed[categories][]'value="<?php echo $category_id;?>" data="<?php echo $category;?>"
                                                <?php if( in_array($category_id, explode(',',$feed['categories'])) && $feed['use_categories'] == 0) echo ' checked="checked"'; ?> />
                                            <?php echo $category;?></label>
                                    </div>
                                <?php } ?>
                            </div>
                            <button type="button" class="text_select_all btn btn-primary"><i class="fa fa-pencil"></i> <?php echo $text_select_all; ?></button>
                            <button type="button" class="text_unselect_all btn btn-danger"><i class="fa fa-pencil"></i> <?php echo $text_unselect_all; ?></button>
                        </div>
                        <?php foreach ($feedMainCategories as $main_category) { ?>
                            <div class="col-sm-8" id="list_categories_<?php echo $main_category['category_id']?>">
                                <div class="well well-sm" style="min-height: 150px;max-height: 400px;overflow: auto;">
                                    <?php $class = 'odd'; ?>
                                    <?php foreach($feedCategories as $category) { ?>
                                        <?php if($category['parent_id']==$main_category['category_id']) { ?>
                                            <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                            <div class="<?php echo $class; ?>">
                                                <label><input class="category" type="checkbox" name='feed[categories][]'value="<?php echo $category['category_id'];?>" data="<?php echo $category['name'];?>"
                                                        <?php if( in_array($category['category_id'], explode(',',$feed['categories'])) && $feed['use_categories'] == $main_category['category_id']) echo ' checked="checked"'; ?> />
                                                    <?php echo $category['name'];?></label>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                                <button type="button" class="text_select_all btn btn-primary"><i class="fa fa-pencil"></i> <?php echo $text_select_all; ?></button>
                                <button type="button" class="text_unselect_all btn btn-danger"><i class="fa fa-pencil"></i> <?php echo $text_unselect_all; ?></button>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <span class="col-sm-4"><?php echo $entry_manufacturers; ?></span>
                        <div class="col-sm-8">
                            <div class="well well-sm" style="min-height: 150px;max-height: 400px;overflow: auto;">
                                <?php $class = 'odd'; ?>
                                <?php foreach( $manufacturers as $manufacturer_id=> $manufacturer) { ?>
                                    <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                                    <div class="<?php echo $class; ?>">
                                        <label><input class="category" type="checkbox" name='feed[manufacturers][]'
                                                      value="<?php echo $manufacturer_id;?>" data="<?php echo $manufacturer;?>"
                                                <?php if( in_array($manufacturer_id, explode(',',$feed['manufacturers']))) echo ' checked="checked"'; ?>
                                            />
                                            <?php echo $manufacturer;?></label>
                                    </div>
                                <?php } ?>
                            </div>
                            <button type="button" class="text_select_all btn btn-primary"><i class="fa fa-pencil"></i> <?php echo $text_select_all; ?></button>
                            <button type="button" class="text_unselect_all btn btn-danger"><i class="fa fa-pencil"></i> <?php echo $text_unselect_all; ?></button>
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="col-sm-4"><?php echo $entry_currency; ?></span>
                        <div class="col-sm-8">
                            <select id="active" name="feed[currency]" class="form-control">
                                <?php foreach($currencies as $currency_id=> $currency){ ?>
                                    <option value="<?php echo $currency_id;?>"
                                        <?php echo ($currency_id==$feed['currency'])? 'selected="selected"': '';?>
                                    ><?php echo $currency; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="col-sm-4"><?php echo $entry_use_original_images; ?></span>
                        <div class="col-sm-8">
                            <select name="feed[use_original_images]" class="form-control" id="use_original_images">
                                <option value="0"
                                    <?php if( !$feed['use_original_images'] ) echo 'selected="selected"';?>
                                ><?php echo $text_disabled; ?></option>
                                <option value="1"
                                    <?php if( $feed['use_original_images'] ) echo 'selected="selected"';?>
                                ><?php echo $text_enabled; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group show_params_image">
                        <span class="col-sm-4"><?php echo $entry_image_width; ?></span>
                        <div class="col-sm-8">
                            <input name="feed[image_width]" class="form-control"
                                   value="<?php echo $feed['image_width'];?>">
                        </div>
                    </div>
                    <div class="form-group show_params_image">
                        <span class="col-sm-4"><?php echo $entry_image_height; ?></span>
                        <div class="col-sm-8">
                            <input name="feed[image_height]" class="form-control"
                                   value="<?php echo $feed['image_height'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="col-sm-4"><?php echo $entry_pictures_limit; ?></span>
                        <div class="col-sm-8">
                            <input name="feed[pictures_limit]" class="form-control"
                                   value="<?php echo $feed['pictures_limit'];?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="col-sm-4"><?php echo $entry_sql_code; ?></span>
                        <div class="col-sm-8">
                            <textarea id="sql_code" rows="3" style="width:100%" name="feed[sql_code]"
                                      class="form-control"><?php echo $feed['sql_code']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="col-sm-4"><?php echo $entry_sql_code_before; ?></span>
                        <div class="col-sm-8">
                            <textarea id="sql_code_before" rows="3" style="width:100%" name="feed[sql_code_before]"
                                      class="form-control"><?php echo $feed['sql_code_before']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="text-align: left" class="col-sm-4 control-label" for="input-not-unload"><?php echo $entry_unload; ?></label>
                        <div class="col-sm-8">
                            <input type="text" name="not_unload" value="" placeholder="" id="input-not-unload" class="form-control" />
                            <div id="product-not-unload" class="well well-sm" style="height: 150px; overflow: auto;">
                                <?php foreach ($product_not_unload as $product) { ?>
                                <div id="product-not-unload<?php echo $product['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product['name']; ?>
                                    <input type="hidden" name="feed[product_not_unload][]" value="<?php echo $product['product_id']; ?>" />
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="<?php echo isset($feed['product_feed_id'])? 'feed[product_feed_id]': '';?>"
                           value="<?php echo isset($feed['product_feed_id'])?$feed['product_feed_id']: '';?>"/>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(".text_select_all").on("click", function (e) {
        $(this).parent().find(":checkbox").prop("checked", true);
    });
    $(".text_unselect_all").on("click", function (e) {
        $(this).parent().find(":checkbox").prop("checked", false);
    });
    $('.date').datetimepicker({
        pickTime: false
    });
    $("input[name*='feed_name']").blur(function () {
        var value = convertCyr($(this).val());
        $("input[name*='feed_shortname']").val(value);
    });
    var rus = "щ   ш  ч  ц  ю  я  ё  ж  ъ  ы  э  а б в г д е з и й к л м н о п р с т у ф х ь".split(/ +/g);
    var eng = "shh sh ch cz yu ya yo zh _ y e a b v g d e z i j k l m n o p r s t u f x _".split(/ +/g);
    function convertCyr(text) {
        var x;
        text = text.toLowerCase();
        for (x = 0; x < rus.length; x++) {
            text = text.split(rus[x]).join(eng[x]);
        }

        text = text.replace(/[^a-z0-9_\.\s]/g, "");
        text = text.replace(/\./g, "_");
        text = text.replace(/\s/g, "_");
        return text;
    }

    $(function () {
        showCategories($('#use_categories').val());
        showParamsImage($('#use_original_images').val());
    });

    $('#use_categories').change(function () {
        $('[id^=list_categories_]').find(':checkbox').prop('checked', false);
        showCategories($(this).val());
    });

    $('#use_original_images').change(function () {
        showParamsImage($(this).val());
    });
    function showCategories(value) {
        $('[id^=list_categories_]').hide();
        if (value != 0) {
            $('#list_categories_' + value).show();
        } else {
            $('#list_categories_default').show();
        }
    }

    function showParamsImage(value) {
        if (value != 0) {
            $('.show_params_image').hide();
        } else {
            $('.show_params_image').show();
        }
    }

    /* NeoSeo Exchange1c - begin */
    $('#use_warehouse_quantity').change(function () {
        showWarehouses($(this).val());
    });

    $(function () {
        showWarehouses($('#use_warehouse_quantity').val());
    });

     function showWarehouses(value) {
        if (value == 0) {
            $('.show_warehouses').hide();
        } else {
            $('.show_warehouses').show();
        }
    }
    /* NeoSeo Exchange1c - end */

    // Not Unload
    $('input[name=\'not_unload\']').autocomplete({
        'source': function(request, response) {
            $.ajax({
                url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
                dataType: 'json',
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            label: item['name'],
                            value: item['product_id']
                        }
                    }));
                }
            });
        },
        'select': function(item) {
            $('input[name=\'not_unload\']').val('');

            $('#product-not-unload' + item['value']).remove();

            $('#product-not-unload').append('<div id="product-not-unload' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="feed[product_not_unload][]" value="' + item['value'] + '" /></div>');
        }
    });

    $('#product-not-unload').delegate('.fa-minus-circle', 'click', function() {
        $(this).parent().remove();
    });

</script>
<?php echo $footer; ?>
