<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-category-mgr" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category-mgr" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $text_add_subcategories ?></label>
                        <div class="col-sm-10">
                            <label><input type="radio" name="category_mgr_add_subcategories" value="1" <?php echo $category_mgr_add_subcategories ? 'checked="checked"' : '' ?>><?php echo $text_yes; ?></label>
                            <label><input type="radio" name="category_mgr_add_subcategories" value="0" <?php echo !$category_mgr_add_subcategories ? 'checked="checked"' : '' ?>><?php echo $text_no; ?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $text_unlinked_products_only ?></label>
                        <div class="col-sm-10">
                            <label><input type="radio" name="category_mgr_unlinked_products_only" value="1" <?php echo $category_mgr_unlinked_products_only ? 'checked="checked"' : '' ?>><?php echo $text_yes; ?></label>
                            <label><input type="radio" name="category_mgr_unlinked_products_only" value="0" <?php echo !$category_mgr_unlinked_products_only ? 'checked="checked"' : '' ?>><?php echo $text_no; ?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $text_store_language_only; ?></label>
                        <div class="col-sm-10">
                            <label><input type="radio" name="category_mgr_product_name_one_line" value="1" <?php echo $category_mgr_product_name_one_line ? 'checked="checked"' : '' ?>><?php echo $text_yes; ?></label>
                            <label><input type="radio" name="category_mgr_product_name_one_line" value="0" <?php echo !$category_mgr_product_name_one_line ? 'checked="checked"' : '' ?>><?php echo $text_no; ?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $text_process_main_category; ?></label>
                        <div class="col-sm-10">
                            <label><input type="radio" name="category_mgr_process_main_category" value="1" <?php echo $category_mgr_process_main_category ? 'checked="checked"' : '' ?>><?php echo $text_yes; ?></label>
                            <label><input type="radio" name="category_mgr_process_main_category" value="0" <?php echo !$category_mgr_process_main_category ? 'checked="checked"' : '' ?>><?php echo $text_no; ?></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $text_smart_show_on_touch; ?></label>
                        <div class="col-sm-10">
                            <select name="category_mgr_smart_show_on_touch">
                                <option value="0" <?php echo $category_mgr_smart_show_on_touch == 0 ? 'selected="selected"' : '' ?>><?php echo $item_touch_auto; ?></option>
                                <option value="1" <?php echo $category_mgr_smart_show_on_touch == 1 ? 'selected="selected"' : '' ?>><?php echo $item_touch_always_show; ?></option>
                                <option value="2" <?php echo $category_mgr_smart_show_on_touch == 2 ? 'selected="selected"' : '' ?>><?php echo $item_touch_always_hide; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $text_img_size ?></label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="category_mgr_img_size" value="<?php echo $category_mgr_img_size; ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $text_window_ratio ?></label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" name="category_mgr_edit_window_ratio" size="4" value="<?php echo $category_mgr_edit_window_ratio; ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $text_license_name; ?></label>
                        <div class="col-sm-10">
                            <input class="form-control" onchange="gen_license_id(); return false;" type="text" name="category_mgr_license_name" id="license_name" value="<?php echo $category_mgr_license_name; ?>"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $text_license_id; ?></label>
                        <div class="col-sm-10">
                            <input class="form-control" id="license_id" type="text" onclick="this.setSelectionRange(0, this.value.length);" readonly name="category_mgr_license_id"/><br><?php echo $text_license_id_hint; ?><a style="font-size: 150%; color=blue; margin-top: 5px; float: left; cursor: pointer" onclick="$('#onlineActivationModal').modal('show'); return false;"><?php echo $button_online_activation; ?></a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="license_info"><?php echo $text_license_info; ?></label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="license_info" rows="7" name="category_mgr_license_info"><?php echo $category_mgr_license_info; ?></textarea><br><?php echo $text_license_info_hint; ?>
                        </div>
                    </div>
                    <a style="display:none;" id="btnOpen" onclick="$('#form-category-mgr').submit();" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="<?php echo $button_open; ?>"><?php echo $button_open; ?><i class="fa fa-magic"></i></a>
                    <a href="<?php echo $check_updates_url; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $text_check_updates_url; ?>" class="btn btn-success"><?php echo $button_check_updates_url; ?> <i class="fa fa-spin fa-cog"></i></a>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="onlineActivationModal" tabindex="-1" role="dialog" aria-labelledby="onlineActivationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="X"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="onlineActivationModalLabel"><?php echo $text_online_activation_dlg; ?></h4>
            </div>
            <div class="modal-body">
                <div id="parent_caption" class="form-group"></div>
                <div class="form-group">
                    <label for="serial_key" class="control-label"><?php echo $text_provide_serial_key; ?></label>
                    <input type="text" class="form-control" id="serial_key"/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal" onclick="online_activation(); return false;"><?php echo $button_activate; ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript"><!--
    function validate_license_fields() {
        entered = ($("#license_info").val());
        if (entered) $("#btnOpen").show();
    }

    function online_activation() {

        if ($('#license_name').val() != '' && $('#serial_key').val() != '' ) {
            $.ajax({
                type:  'POST',
                cache:  false ,
                dataType: 'json',
                url:  'https://acuteopencart.ru/lics/index.php/order/activate',
                data:  { 'license_name' : $("#license_name").val(), 'license_id' :  $("#license_id").val(), 'serial_key': $("#serial_key").val().trim(), 'hash' : '<?php echo $hash; ?>'},
                success: function(json) {
                    if (typeof json.error != 'undefined') {
                        alert(json.error);
                    }
                    else
                        $("#license_info").val(json.license);
                    validate_license_fields();
                }
            });
        }
    }

    function gen_license_id() {
        $.ajax({
            type:  'POST',
            cache:  false ,
            dataType: 'json',
            url:  'index.php?route=<?php echo $route; ?>/license&token=<?php echo $token; ?>',
            data:  { 'license_name' : $("#license_name").val()},
            success: function(json) {
                $("#license_id").val(json.id);
                $("#license_name").val(json.name);
                validate_license_fields();
            }
        });
    }
    $(function() {
        validate_license_fields();
        gen_license_id();
        $('#onlineActivationModal').on('shown.bs.modal', function () {
            $(this).find('#serial_key').focus();
            if (window.acm_serial) {
                $(this).find('#serial_key').val(window.acm_serial);
                window.acm_serial = "";
            }
        });

        $('#license_info').on('change keyup paste', function() {
            window.acm_serial = "";
            var dat = $(this).val().trim();
            if (dat != '') {
                if (dat.match(/[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}/)) {
                    window.acm_serial = dat;
                    $('#license_info').off('change keyup paste');
                    $('#onlineActivationModal').modal('show');
                }
            }
        });

    });
    //--></script>
<?php echo $footer; ?>