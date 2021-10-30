<?php
/**
 * iScroller 1.2.1, September 20, 2017
 * Copyright 2014-2017 Igor Bukin / egozza88@gmail.com
 * License: Commercial. Reselling of this software or its derivatives is not allowed. You may use this software for one website ONLY including all its subdomains if the top level domain belongs to you and all subdomains are parts of the same OpenCart store.
 * Support: oc.iscroller@gmail.com
 */
?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <a href="#" data-toggle="tooltip" title="<?php echo $lang_save_and_stay; ?>" class="btn btn-success" onclick="$('#form-iscroller').submit();return false;"><i class="fa fa-save"></i></a>
                <a href="#" data-toggle="tooltip" title="<?php echo $lang_save_and_close; ?>" class="btn btn-primary" onclick="$('#form-iscroller [name=action]').val('save');$('#form-iscroller').submit();return false;"><i class="fa fa-save"></i></a>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
            </div>
        
            <h1><?php echo $lang_heading_title_adv; ?></h1>
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
        <?php if ($success) { ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $lang_text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-iscroller" class="form-horizontal">
                    <input type="hidden" name="action" value="apply" />
                    <input type="hidden" name="iscroller_module[status]" value="1" />
                    <div class="form-group">
                        <label for="container-selector" class="control-label col-sm-4 col-md-3"><?php echo $lang_module_name; ?></label>
                        <div class="col-sm-8 col-md-9">
                            <input type="text" name="iscroller_module[name]" value="" id="show-btn-after" class="form-control" />
                        </div>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#infinite-scroller" data-toggle="tab"><?php echo $lang_infinite_scroller; ?></a></li>
                        <li><a href="#scroll-to-top" data-toggle="tab"><?php echo $lang_scroll_to_top; ?></a></li>
                        <li><a href="#translation" data-toggle="tab"><?php echo $lang_translation; ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="infinite-scroller">
                            <div class="form-group">
                                <label class="control-label col-sm-4 col-md-3"><?php echo $lang_enable_infinite_scroll; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <label><input type="radio" name="iscroller_module[infScroll][enabled]" value="1" class="inf-scr-enabled" /> <?php echo $text_yes; ?></label>
                                    <label><input type="radio" name="iscroller_module[infScroll][enabled]" value="0" class="inf-scr-enabled" /> <?php echo $text_no; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-md-3 control-label" for="input-loading-mode"><?php echo $lang_loading_mode; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <select name="iscroller_module[infScroll][loadingMode]" id="input-status" class="form-control">
                                            <option value="auto"><?php echo $lang_auto; ?></option>
                                            <option value="button"><?php echo $lang_with_button; ?></option>
                                            <option value="smart"><?php echo $lang_smart; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="show-btn-after-row" style="display:none;">
                                <label for="show-btn-after" class="control-label col-sm-4 col-md-3"><?php echo $lang_show_button_after; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <input type="text" name="iscroller_module[infScroll][show_btn_after]" value="" id="show-btn-after" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 col-md-3"><?php echo $lang_stateful_scroll; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <label><input type="radio" name="iscroller_module[infScroll][statefulScroll]" value="1" class="inf-scr-stateful" /> <?php echo $text_yes; ?></label>
                                    <label><input type="radio" name="iscroller_module[infScroll][statefulScroll]" value="0" class="inf-scr-stateful" /> <?php echo $text_no; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 col-md-3"><?php echo $lang_show_page_separator; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <label><input type="radio" name="iscroller_module[infScroll][showSeparator]" value="1" /> <?php echo $text_yes; ?></label>
                                    <label><input type="radio" name="iscroller_module[infScroll][showSeparator]" value="0" /> <?php echo $text_no; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 col-md-3"><?php echo $lang_animation; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <label><input type="radio" name="iscroller_module[infScroll][animation]" value="1" /> <?php echo $text_yes; ?></label>
                                    <label><input type="radio" name="iscroller_module[infScroll][animation]" value="0" /> <?php echo $text_no; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="container-selector" class="control-label col-sm-4 col-md-3"><?php echo $lang_container_selector; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <input type="text" name="iscroller_module[infScroll][containerSelector]" value="" id="container-selector" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="paginator-selector" class="control-label col-sm-4 col-md-3"><?php echo $lang_paginator_selector; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <input type="text" name="iscroller_module[infScroll][paginatorSelector]" value="" id="paginator-selector" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="item-selector" class="control-label col-sm-4 col-md-3"><?php echo $lang_item_selector; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <input type="text" name="iscroller_module[infScroll][itemSelector]" value="" id="item-selector" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="min-dist-to-bottom" class="control-label col-sm-4 col-md-3"><?php echo $lang_min_dist_to_bottom; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <input type="text" name="iscroller_module[infScroll][minDistToBottom]" value="" id="min-dist-to-bottom" class="form-control" />
                                </div>
                            </div>

                            <div class="form-separator"></div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 col-md-3"><?php echo $lang_enhanced_compatibility; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <label><input type="radio" name="iscroller_module[infScroll][domObserverEnabled]" value="1" /> <?php echo $text_yes; ?></label>
                                    <label><input type="radio" name="iscroller_module[infScroll][domObserverEnabled]" value="0" /> <?php echo $text_no; ?></label>
                                    &nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-default btn-sm" role="button" data-toggle="collapse" href="#compatibility-notice" aria-expanded="false" aria-controls="compatibility-notice">
                                        <?php echo $lang_read_the_notice; ?>&nbsp;&nbsp;&nbsp;<i class="fa fa-chevron-down"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="collapse" id="compatibility-notice">
                                <div class="alert alert-warning" role="alert">
                                    <?php echo $lang_dom_observer_desrcription; ?>
                                </div>
                                <div class="alert alert-info" role="alert">
                                    <?php echo $lang_dom_observer_advanced; ?>
                                </div>
                            </div>
                            <div class="form-separator"></div>
                            <div class="form-group">
                                <label for="custom-js-code" class="control-label col-sm-4 col-md-3"><?php echo $lang_custom_js_code; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <textarea name="iscroller_module[infScroll][customJsCode]" id="custom-js-code" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="custom-css-code" class="control-label col-sm-4 col-md-3"><?php echo $lang_custom_css_code; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <textarea name="iscroller_module[infScroll][customCssCode]" id="custom-css-code" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 col-md-3"><?php echo $lang_custom_loading_animation; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <a id="thumb-image">
                                        <img src="<?php echo !empty($settings['infScroll']['customGif']) 
                                                ? $catalog . 'image/' . $settings['infScroll']['customGif'] 
                                                : $catalog . 'catalog/view/theme/default/image/oc-iscroller-loader.gif'; ?>" 
                                             alt="" title="" 
                                             data-placeholder="<?php echo HTTP_CATALOG . 'catalog/view/theme/default/image/oc-iscroller-loader.gif'; ?>">
                                    </a>
                                    <input name="iscroller_module[infScroll][customGif]" id="loader-img" class="form-control" type="hidden" />
                                    <button type="button" id="button-image" class="btn btn-primary"><i class="fa fa-pencil"></i></button> 
                                    <button type="button" id="button-clear" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane" id="scroll-to-top">
                            <div class="form-group">
                                <label class="control-label col-sm-4 col-md-3"><?php echo $lang_enable_sroll_to_top; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <label><input type="radio" name="iscroller_module[scrollTop][enabled]" value="1" /> <?php echo $text_yes; ?></label>
                                    <label><input type="radio" name="iscroller_module[scrollTop][enabled]" value="0" /> <?php echo $text_no; ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 col-md-3 control-label" for="scroll-top-pos"><?php echo $lang_scroll_top_pos; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <select name="iscroller_module[scrollTop][position]" id="scroll-top-pos" class="form-control">
                                            <option value="left"><?php echo $lang_left; ?></option>
                                            <option value="right"><?php echo $lang_right; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 col-md-3"><?php echo $lang_fit_to_container; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <input type="text" class="form-control" name="iscroller_module[scrollTop][fitTo]" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 col-md-3"><?php echo $lang_bar_color; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <input type="text" class="form-control colorpic" name="iscroller_module[scrollTop][barColor]" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 col-md-3"><?php echo $lang_arrow_color; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <input type="text" class="form-control colorpic" name="iscroller_module[scrollTop][arrowColor]" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 col-md-3"><?php echo $lang_scroll_bar_speed; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <input type="text" class="form-control" name="iscroller_module[scrollTop][speed]" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 col-md-3"><?php echo $lang_min_width_to_show_bar; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <input type="text" class="form-control" name="iscroller_module[scrollTop][minWidthToShow]" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-4 col-md-3"><?php echo $lang_min_width_show_bar; ?></label>
                                <div class="col-sm-8 col-md-9">
                                    <input type="text" class="form-control" name="iscroller_module[scrollTop][minWidthToShowAsBar]" value="" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane" id="translation">
                            <ul class="nav nav-tabs col-sm-8 col-md-9 col-sm-offset-4 col-md-offset-3" id="language">
                                <?php $i = 0; foreach ($languages as $language) { $i++; ?>
                                    <li<?php if ($i===1) { ?> class="active"<?php } ?>><a href="#loading-msg-lang-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                            <?php $i = 0; foreach ($languages as $language) { $i++; ?>
                                <div class="tab-pane<?php if ($i===1) { ?> active<?php } ?>" id="loading-msg-lang-<?php echo $language['language_id']; ?>">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 col-md-3"><?php echo $lang_loading_msg; ?></label>
                                        <div class="col-sm-8 col-md-9">
                                            <input type="text" class="form-control" name="iscroller_module[infScroll][loadingMsg][<?php echo $language['code']; ?>]" value="<?php echo $lang_loading_def_msg; ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 col-md-3"><?php echo $lang_finish_msg; ?></label>
                                        <div class="col-sm-8 col-md-9">
                                            <input type="text" class="form-control" name="iscroller_module[infScroll][finishMsg][<?php echo $language['code']; ?>]" value="<?php echo $lang_finish_def_msg; ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 col-md-3"><?php echo $lang_button_label; ?></label>
                                        <div class="col-sm-8 col-md-9">
                                            <input type="text" class="form-control" name="iscroller_module[infScroll][buttonLabel][<?php echo $language['code']; ?>]" value="<?php echo $lang_button_def_label; ?>" />
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
(function($){
    var convertToFormNames = function(obj) {
        var out = {};
        if (typeof obj === 'object' || typeof obj === 'array') {
            for (var k in obj) {
                var arr = convertToFormNames(obj[k]);
                for (var k2 in arr) {
                    out['['+k+']'+k2] = arr[k2];
                }
            }
        } else {
            out[''] = obj;
        }
        return out;
    };
    var fillForm = function(form, settingsObj) {
        var settings = convertToFormNames(settingsObj);
        for (var name in settings) {
            var field = form.find('[name="iscroller_module'+name+'"]');
            if (field.size()) {
                var type = field.eq(0).attr('type') ? field.eq(0).attr('type').toLowerCase() : '';
                var tag  = field.eq(0).prop('tagName').toLowerCase();
                if (type === 'text' || tag === 'select' || tag === 'textarea') {
                    field.val(settings[name]);
                } else if (type === 'radio' || type === 'checkbox') {
                    field.filter('[value="'+settings[name]+'"]').attr('checked', 'checked');
                }
            }
        }
    };
    
    fillForm($('#form-iscroller'), <?php echo json_encode($settings); ?>);
    
    $('#form-iscroller').on('submit', function(){
        var data = {
            enable : ~~$('.inf-scr-enabled:checked').val() && ~~$('.inf-scr-stateful:checked').val() ? 'true' : 'false'
        },
        url = ('<?php echo $mod_refresh_action; ?>').replace('&amp;', '&');
        $.post(url, data);
    });
    
    $('#input-status').on('change', function(){
        if ($(this).val() === 'smart') {
            $('#show-btn-after-row').slideDown(300);
        } else {
            $('#show-btn-after-row').slideUp(300);
        }
    });
    if ($('#input-status').val() === 'smart') {
        $('#show-btn-after-row').css('display', 'block');
    }
    
    $("input.colorpic").ColorPickerSliders({
        size: 'sm',
        placement: 'top',
        swatches: false,
        sliders: false,
        hsvpanel: true
    });
    
    $('#button-image').on('click', function() {
        $('#modal-image').remove();

        $.ajax({
            url: '<?php echo str_replace('&amp;', '&', $filemanager_route); ?>',
            dataType: 'html',
            beforeSend: function() {
                $('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
                $('#button-image').prop('disabled', true);
            },
            complete: function() {
                $('#button-image i').replaceWith('<i class="fa fa-pencil"></i>');
                $('#button-image').prop('disabled', false);
            },
            success: function(html) {
                $('body').append('<div id="modal-image" class="modal">' + html + '</div>');
                $('#modal-image').modal('show').on('hide.bs.modal', function(){
                    var inp = $('#thumb-image').parent().find('input');
                    if (inp.val()) {
                        $('#thumb-image').find('img').attr('src', '<?php echo $catalog; ?>image/' + inp.val());
                    } else {
                        $('#thumb-image').find('img').attr('src', $('#thumb-image').find('img').attr('data-placeholder'));
                    }
                });
            }
        });
    });

    $('#button-clear').on('click', function() {
        $('#thumb-image').find('img').attr('src', $('#thumb-image').find('img').attr('data-placeholder'));
        $('#thumb-image').parent().find('input').attr('value', '');
    });
})(jQuery);
</script>
<style>
    input[type=radio] {
        vertical-align: middle;
        margin-bottom: 5px;
    }
    .form-group .col-sm-8 {
        padding-top: 7px;
    }
    .form-separator {
        border-top: 1px solid #eee; 
        padding-top: 15px;
    }
</style>
<?php echo $footer;