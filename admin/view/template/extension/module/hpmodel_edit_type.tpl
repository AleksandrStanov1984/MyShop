<?php echo $header; ?><?php echo $column_left; ?>
<div id="content" class="hpm-series hpm-edit">
<div class="page-header">
  <div class="container-fluid">
    <h1><?php echo $heading_title; ?><span>by AM</span></h1>
    <div class="version" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo $hpm_version;?>"><span>v</span><?php echo $version_numb;?></div>
    <div form="help_modals" class="btn-help" data-toggle="modal" data-target="#Hpmodel_Modal">
      <div class="btn-helpers" data-toggle="tooltip" title="Info" data-placement="bottom">
        <i class="fa fa-info-circle"></i>
      </div>
    </div>
    <div class="pull-right">
      <a target="_blank" href="https://open-cart.dev" class="btn btn-sm btn-success hpm-mods"><i class="fa fa-puzzle-piece fa-fw"></i> <?php echo $url_module; ?></a>
      <button type="submit" form="form-hpmodel-add-type" data-placement="bottom"  data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-sm btn-primary"><i class="fa fa-save"></i></button>
      <a href="<?php echo $cancel; ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $button_cancel; ?>" class="btn btn-sm btn-default"><i class="fa fa-reply"></i></a>
    </div>
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
      <h3><i class="fa fa-pencil"></i> <?php echo $name_series;?></h3>
      <button form="help_modals" class="pull-right hm-help btn btn-primary btn-sm" data-toggle="modal" data-target="#Series_Modal"><i class="fa fa-info"></i> - HELPER</button>
    </div>
    <div class="panel-body">
      <form action="<?php echo $action; ?>" method="post"  id="form-hpmodel-add-type" class="form-horizontal">
        <input type="hidden" name="type" value="" />
        <table class='table table-hover table-bordered table-responsive'>
          <thead>
            <tr>
              <td class="title-start">
                <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_name_title;?>"><?php echo $text_name;?></span></label>
              </td>
              <td class="text-center status">
                <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $entry_store; ?>"><i class="fa fa-shopping-cart"></i></span></label>
              </td>
              <td class="text-center switcher-editors">
                <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $entry_type_title;?>"><?php echo $entry_type;?></span></label>
              </td>
              <td class="text-center edit-links">
                <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $entry_links_title;?>"><?php echo $entry_links;?></span></label>
              </td>
              <td class="text-center status">
                <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $entry_view_title;?>"><i class="fa fa-exclamation-triangle"></i></span></label>
              </td>
              <td class="text-center status">
                <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $hpm_next_title;?>"><i class="fa fa-crosshairs"></i></span></label>
              </td>
              <td>
                <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_comment;?>"><?php echo $text_comment;?></span></label>
              </td>
              <td class="text-center status">
                <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $button_on_off;?>"><i class="fa fa-power-off"></i></span></label>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="title-start">
                <input type="text" name="name" value="<?php echo $name;?>" class="form-control" />
              </td>
              <td class="text-center switcher-edits">
                <button form="help_modals" class="hm-links btn btn-primary btn-md" data-toggle="modal" data-target="#Store_Form_Modal"><i class="fa fa-server" aria-hidden="true"></i></button>
              </td>
              <td class="text-center switcher-edits edit-group">
                <div class="input-group" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo $group_title;?>">
                  <input class="bootstrap-switcher form-control" type="checkbox" value="1" name="setting[group]" data-size="small" data-on-color="success" <?php echo $setting['group'] ? 'checked="checked"' : ''; ?> data-on-text="YES" data-off-text="NO" />
                </div>

                <div class="-hidden input-group" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo $redirect_title;?>">
                  <input class="bootstrap-switcher form-control" type="checkbox" value="1" name="setting[redirect]" data-size="small" data-on-color="success" <?php echo $setting['redirect'] ? 'checked="checked"' : ''; ?> data-on-text="YES" data-off-text="NO" />
                </div>

                <div class="input-group" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo $hash_title;?>">
                  <input class="bootstrap-switcher form-control" type="checkbox" value="1" name="setting[hash]" data-size="small" data-on-color="success" <?php echo $setting['hash'] ? 'checked="checked"' : ''; ?> data-on-text="YES" data-off-text="NO" />
                </div>
              </td>
              <td class="text-center switcher-edit">
                <div class="input-group pull-left">
                  <input class="bootstrap-switcher form-control" type="checkbox" value="1" name="setting[links]" data-size="small" data-on-color="success" <?php echo $setting['links'] ? 'checked="checked"' : ''; ?> data-on-text="ALL" data-off-text="EDIT" />
                </div>
                <button form="help_modals" class="hm-links btn btn-primary btn-md" data-toggle="modal" data-target="#Links_Form_Modal"><i class="fa fa-indent" aria-hidden="true"></i></button>
              </td>
              <td class="text-center switcher-edits">
                <div class="input-group pull-left">
                  <input class="bootstrap-switcher form-control" type="checkbox" value="1" name="setting[hidden_if_null]" data-size="small" data-on-color="success" <?php echo $setting['hidden_if_null'] ? 'checked="checked"' : ''; ?> data-on-text="YES" data-off-text="NO" />
                </div>
              </td>
              <td class="text-center switcher-edits">
                <div class="input-group pull-left">
                  <input class="bootstrap-switcher form-control" type="checkbox" value="1" name="setting[hidden_if_next]" data-size="small" data-on-color="success" <?php echo $setting['hidden_if_next'] ? 'checked="checked"' : ''; ?> data-on-text="YES" data-off-text="NO" />
                </div>
              </td>
              <td>
                <textarea style="resize: vertical;" class='form-control' name='description'><?php echo $description;?></textarea>
              </td>
              <td class="text-center switcher-edits">
                <input class="bootstrap-switcher form-control" type="checkbox" value="1" name="status" data-size="small" data-on-color="success" <?php echo $status ? 'checked="checked"' : ''; ?> data-on-text="ON" data-off-text="OFF" />
              </td>
            </tr>
          </tbody>
          <tfoot></tfoot>
        </table>
        <div class="kt-hpm">
            <legend>
                <?php echo $hpm_set_category; ?>
                <button form="help_modals" class="pull-right hm-help btn btn-primary btn-sm" data-toggle="modal" data-target="#Type_Lists"><i class="fa fa-info" aria-hidden="true"></i> - <?php echo $help_name; ?></button>
            </legend>
            <table class="table table-hover table-bordered table-responsive <?php echo !$setting['category_show'] ? 'off' : ''; ?>">
                <thead>
                <tr>
                    <td class="text-center status">
                        <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $button_on_off;?>"><i class="fa fa-power-off"></i></span></label>
                    </td>
                    <td class="title-start">
                        <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $title_cat_html;?>"><?php echo $title_name;?></span></label>
                    </td>
                    <td class="edit-links">
                        <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $entry_types_title;?>"><?php echo $entry_types;?></span></label>
                    </td>
                    <?php for($i=0;$i<3;$i++) { ?>
                        <td class="edit-type">
                            <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $kit_fields_title;?>"><?php echo $kit_fields;?></span></label>
                        </td>
                    <?php } ?>
                    <td class="edit-links">
                        <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $entry_width_lists;?>"><?php echo $entry_width;?></span></label>
                    </td>
                    <td class="text-center status">
                        <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $entry_ltd_title;?>"><?php echo $entry_ltd;?></span></label>
                    </td>
                    <td class="-hidden text-center status">
                        <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $cat_column_h;?>">H1</span></label>
                    </td>
                    <td class="text-center status">
                        <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $kit_column_img;?>"><i class="fa fa-picture-o"></i></span></label>
                    </td>
                    <td></td>                
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="text-center switcher-edits">
                        <input class="bootstrap-switcher form-control" type="checkbox" value="1" name="setting[category_show]" data-size="small" data-on-color="success" <?php echo $setting['category_show'] ? 'checked="checked"' : ''; ?> data-on-text="ON" data-off-text="OFF" onchange="if ($(this).prop('checked')) { $(this).closest('table').removeClass('off'); } else { $(this).closest('table').addClass('off'); }" />
                    </td>
                    <td class="name-text">
                        <?php foreach ($languages as $language) { ?>
                            <div class="input-group">
                                <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                                <input type="text" name="setting[category_title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($setting['category_title'][$language['language_id']]) ? $setting['category_title'][$language['language_id']] : ''; ?>" class="form-control" />
                            </div>
                        <?php } ?>
                    </td>
                    <td class="edit-links">
                        <select name="setting[category_variant]" class="form-control">
                            <?php foreach ($array_variants as $variant_key => $variant_value) { ?>
                                <?php if ($setting['category_variant'] == $variant_key) { ?>
                                    <option value="<?php echo $variant_key;?>" selected="selected"><?php echo $variant_value; ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $variant_key;?>" ><?php echo $variant_value; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </td>
                    <?php for($i = 0; $i < 3; $i++) { ?>
                    <td class="form-tables">
                        <select name="setting[category_columns][<?php echo $i;?>]" class="form-control select-col">
                            <?php foreach ($array_columns as $columns_key => $columns_value) { ?>
                                <?php if (isset($setting['category_columns'][$i]) && $setting['category_columns'][$i] == $columns_key) { ?>
                                    <option value="<?php echo $columns_key;?>" selected="selected" class="hpm-select"><?php echo $columns_value; ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $columns_key;?>" class="hpm-select"><?php echo $columns_value; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                        <div class="prop prop-attribute" style="display:none;">
                          <input type="hidden" name="setting[category_attributes][<?php echo $i;?>]" value="<?php echo $setting['category_attributes'][$i]; ?>" />
                          <input class="form-control" type="text" value="<?php echo $setting['category_attributes_text'][$i]; ?>" />
                        </div>
                    </td>
                    <?php } ?>
                    <td class="edit-links">
                        <div class="form-set">
                            <input class="form-control" type="text" value="<?php echo $setting['category_image_width'];?>" name="setting[category_image_width]" />
                        </div>
                        <div class="form-set">
                            <input class="form-control" type="text" value="<?php echo $setting['category_image_height'];?>" name="setting[category_image_height]" />
                        </div>
                    </td>
                    <td class="status">
                        <div class="form-set">
                            <input class="form-control" type="text" value="<?php echo $setting['category_limit'];?>" name="setting[category_limit]" />
                        </div>
                    </td>
                    <td class="-hidden text-center switcher-edits">
                        <input class="bootstrap-switcher form-control" type="checkbox" value="1" name="setting[category_replace_h1]" data-size="small" data-on-color="success" <?php echo $setting['category_replace_h1'] ? 'checked="checked"' : ''; ?> data-on-text="YES" data-off-text="NO" />
                    </td>
                    <td class="text-center switcher-edits">
                        <input class="bootstrap-switcher form-control" type="checkbox" value="1" name="setting[category_replace_image]" data-size="small" data-on-color="success" <?php echo $setting['category_replace_image'] ? 'checked="checked"' : ''; ?> data-on-text="YES" data-off-text="NO" />
                    </td>
                    <td></td>                
                </tr>
                </tbody>
            </table>
        </div>
        <legend>
            <?php echo $kit_set_product; ?>
            <button form="help_modals" class="pull-right hm-help btn btn-primary btn-sm" data-toggle="modal" data-target="#Type_Modal"><i class="fa fa-info" aria-hidden="true"></i> - <?php echo $help_name; ?></button>
        </legend>
        <table class='table table-hover table-bordered table-responsive'>
            <thead>
              <tr>
                <td class="title-start">
                  <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $title_prod_html;?>"><?php echo $title_name;?></span></label>
                </td>
                <td class="edit-type">
                  <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $entry_column_title;?>"><?php echo $kit_fields;?></span></label>
                </td>
                <td class="text-center status">
                  <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $entry_status_name;?>"><i class="fa fa-paperclip"></i></span></label>
                </td>
                <td class="edit-links">
                  <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $entry_types_title;?>"><?php echo $entry_types;?></span></label>
                </td>
                <td class="edit-links">
                  <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $entry_position_title;?>"><?php echo $entry_position;?></span></label>
                </td>
                <td>
                  <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $entry_selector_title;?>"><?php echo $entry_selector;?></span></label>
                </td>
                <td class="-hidden text-center status">
                  <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $kit_column_h;?>">H1</span></label>
                </td>
                <td class="text-center status">
                  <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $kit_column_img;?>"><i class="fa fa-picture-o"></i></span></label>
                </td>
                <td class="text-center status">
                  <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $kit_column_desc;?>"><i class="fa fa-align-justify"></i></span></label>
                </td>
                <td class="text-center status">
                  <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $kit_column_attr;?>"><i class="fa fa-list"></i></span></label>
                </td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="name-text">
                  <?php foreach ($languages as $language) { ?>
                  <div class="input-group">
                    <span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
                    <input type="text" name="setting[product_title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($setting['product_title'][$language['language_id']]) ? $setting['product_title'][$language['language_id']] : ''; ?>" class="form-control" />
                  </div>
                  <?php } ?>
                </td>
                <td class="form-tables">
                  <select name="setting[after_title]" class="form-control select-col">
                    <?php foreach ($array_h_titles as $h_titles_key => $h_titles_value) { ?>
                    <?php if ($setting['after_title'] == $h_titles_key) { ?>
                    <option value="<?php echo $h_titles_key;?>" selected="selected" class="hpm-select"><?php echo $h_titles_value; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $h_titles_key;?>" class="hpm-select"><?php echo $h_titles_value; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                  <div class="prop prop-attribute" style="display:none;">
                    <input type="hidden" name="setting[after_title_attribute]" value="<?php echo $setting['after_title_attribute']; ?>" />
                    <input class="form-control" type="text" value="<?php echo $setting['after_title_attribute_text']; ?>" />
                  </div>
                </td>
                <td class="text-center switcher-edits">
                  <input class="bootstrap-switcher form-control" type="checkbox" value="1" name="setting[product_name_as_title]" data-size="small" data-on-color="success" <?php echo $setting['product_name_as_title'] ? 'checked="checked"' : ''; ?> data-on-text="YES" data-off-text="NO" />
                </td>
                <td class="edit-links">
                  <select name="setting[product_variant]" class="form-control">
                    <?php foreach ($array_variants as $variant_key => $variant_value) { ?>
                    <?php if ($setting['product_variant'] == $variant_key) { ?>
                    <option value="<?php echo $variant_key;?>" selected="selected"><?php echo $variant_value; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $variant_key;?>" ><?php echo $variant_value; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </td>
                <td class="edit-links">
                  <select name="setting[product_position]" class="form-control">
                    <?php foreach ($array_positions as $positions_key => $positions_value) { ?>
                    <?php if ($setting['product_position'] == $positions_key) { ?>
                    <option value="<?php echo $positions_key;?>" selected="selected"><?php echo $positions_value; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $positions_key;?>" ><?php echo $positions_value; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </td>
                <td class="">
                  <input class="form-control" type="text" value="<?php echo $setting['product_selector'];?>" name="setting[product_selector]" />
                </td>
                <td class="-hidden text-center switcher-edits">
                  <input class="bootstrap-switcher form-control" type="checkbox" value="1" name="setting[replace_h1]" data-size="small" data-on-color="success" <?php echo $setting['replace_h1'] ? 'checked="checked"' : ''; ?> data-on-text="YES" data-off-text="NO" />
                </td>
                <td class="text-center switcher-edits">
                  <input class="bootstrap-switcher form-control" type="checkbox" value="1" name="setting[replace_image]" data-size="small" data-on-color="success" <?php echo $setting['replace_image'] ? 'checked="checked"' : ''; ?> data-on-text="YES" data-off-text="NO" />
                </td>
                <td class="text-center switcher-edits">
                  <input class="bootstrap-switcher form-control" type="checkbox" value="1" name="setting[replace_desc]" data-size="small" data-on-color="success" <?php echo $setting['replace_desc'] ? 'checked="checked"' : ''; ?> data-on-text="YES" data-off-text="NO" />
                </td>
                <td class="text-center switcher-edits">
                  <input class="bootstrap-switcher form-control" type="checkbox" value="1" name="setting[replace_att]" data-size="small" data-on-color="success" <?php echo $setting['replace_att'] ? 'checked="checked"' : ''; ?> data-on-text="YES" data-off-text="NO" />
                </td>
              </tr>
            </tbody>
        </table>
        <div class="kt-hpm">
          <legend class=''>
              <?php echo $hpm_fields_block; ?>
              <button form="help_modals" class="pull-right hm-help btn btn-primary btn-sm" data-toggle="modal" data-target="#Column_Modal"><i class="fa fa-info" aria-hidden="true"></i> - <?php echo $help_name; ?></button>
          </legend>
          <table class=' table table-hover table-bordered table-responsive'>
            <thead>
            <tr>
              <?php for($i=0;$i<3;$i++) { ?>
              <td class="edit-type">
                <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $kit_fields_title;?>"><?php echo $kit_fields;?></span></label>
              </td>
              <?php } ?>
              <td class="edit-links">
                <label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $entry_width_title;?>"><?php echo $entry_width;?></span></label>
              </td>
               <td></td>
            </tr>
            </thead>
            <tbody>
            <tr>
              <?php for($i = 0; $i < 3; $i++) { ?>
              <td class="form-tables">
                <select name="setting[product_columns][<?php echo $i;?>]" class="form-control select-col">
                  <?php foreach ($array_columns as $columns_key => $columns_value) { ?>
                  <?php if (isset($setting['product_columns'][$i]) && $setting['product_columns'][$i] == $columns_key) { ?>
                  <option value="<?php echo $columns_key;?>" selected="selected" class="hpm-select"><?php echo $columns_value; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $columns_key;?>" class="hpm-select"><?php echo $columns_value; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
                <div class="prop prop-attribute" style="display:none;">
                  <input type="hidden" name="setting[product_attributes][<?php echo $i;?>]" value="<?php echo $setting['product_attributes'][$i]; ?>" />
                  <input class="form-control" type="text" value="<?php echo $setting['product_attributes_text'][$i]; ?>" />
                </div>
              </td>
              <?php } ?>
              <td class="edit-links">
                <div class="form-set">
                  <input class="form-control" type="text" value="<?php echo $setting['product_image_width'];?>" name="setting[product_image_width]" />
                </div>
                <div class="form-set">
                  <input class="form-control" type="text" value="<?php echo $setting['product_image_height'];?>" name="setting[product_image_height]" />
                </div>
              </td>
              <td></td>
            </tr>
            </tbody>
            <tfoot></tfoot>
          </table>
        </div>
        <legend>
          <?php echo $kit_css; ?>
          <button form="help_modals" class="pull-right hm-help btn btn-primary btn-sm" data-toggle="modal" data-target="#CSS_JS_Modal">
          <i class="fa fa-info" aria-hidden="true"></i> - <?php echo $help_name; ?>
          </button>
        </legend>
        <table class='table table-hover table-bordered table-responsive'>
          <thead>
            <tr>
              <td>CSS</td>
              <td>JS</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <textarea style="resize: vertical;" class="form-control" name="setting[custom_css]"><?php echo $setting['custom_css'];?></textarea>
              </td>
              <td>
                <textarea style="resize: vertical;" class="form-control" name="setting[custom_js]"><?php echo $setting['custom_js'];?></textarea>
              </td>
            </tr>
          </tbody>
        </table>

        <div class="modal fade" id="Store_Form_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-cogs"></i> <?php echo $help_name_store; ?></h4>
                    </div>
                    <div class="modal-body">
                        <p><?php echo $top_store_text; ?></p>
                        <div class="well well-sm" style="height: 300px; overflow: auto;">
                            <div class="checkbox">
                                <label>
                                    <?php if (in_array(0, $type_store)) { ?>
                                        <input type="checkbox" name="type_store[]" value="0" checked="checked" />
                                        <?php echo $text_default; ?>
                                    <?php } else { ?>
                                        <input type="checkbox" name="type_store[]" value="0" />
                                        <?php echo $text_default; ?>
                                    <?php } ?>
                                </label>
                            </div>
                            <?php foreach ($stores as $store) { ?>
                                <div class="checkbox">
                                    <label>
                                        <?php if (in_array($store['store_id'], $type_store)) { ?>
                                            <input type="checkbox" name="type_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                                            <?php echo $store['name']; ?>
                                        <?php } else { ?>
                                            <input type="checkbox" name="type_store[]" value="<?php echo $store['store_id']; ?>" />
                                            <?php echo $store['name']; ?>
                                        <?php } ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal"> <?php echo $help_ok; ?></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="Links_Form_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-cogs"></i> <?php echo $help_name_links; ?></h4>
              </div>
              <div class="modal-body">
                <p><?php echo $top_links_text; ?></p>
                <div class="links-table">
                  <table class='table table-bordered table-responsive'>
                    <thead>
                      <tr>
                        <td><?php echo $entry_suppler; ?></td>
                        <td><?php echo $entry_brand; ?></td>
                        <td><?php echo $entry_category; ?></td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div class='h5-scroll'>
                            <?php if ($supplers) { ?>
                            <?php foreach ($supplers as $k => $suppler) { ?>
                            <input type="checkbox" name="setting[suppler][]" value="<?php $c=$suppler['suppler_id'];if($c<10){$c='0'.$c;}echo $c;?>" <?php if(array_search($c,$setting['suppler'])!==FALSE) { ?> checked <?php } ?>> <?php echo $suppler['name'];?><br>
                            <?php } ?>
                            <?php } ?>
                          </div>
                        </td>
                        <td>
                          <div class='h5-scroll'>
                            <?php foreach ($manufacturers as $m) { ?>
                            <input type="checkbox" name="setting[manufacturer][]" <?php if(array_search($m['manufacturer_id'],$setting['manufacturer'])!==FALSE) { ?> checked <?php } ?> value="<?php echo $m['manufacturer_id'];?>">
                            <?php echo $m['name'];?><br>
                            <?php } ?>
                        </td>
                        <td>
                        <div class='h5-scroll'>
                        <?php foreach($categories as $c) { ?>
                        <input type="checkbox" name="setting[category][]" <?php if(array_search($c['category_id'],$setting['category'])!==FALSE) { ?> checked <?php } ?> value="<?php echo $c['category_id'];?>">
                        <?php echo $c['name'];?><br>
                        <?php } ?>
                        </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  </div>
                  <hr>
                  <p><?php echo $bottom_links_text; ?></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal"> <?php echo $help_ok; ?></button>
                </div>
              </div>
            </div>
        </div>
      </form>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="panel-heading text-center copy">
          <button form="help_modals" class="hm-info btn btn-primary btn-sm" data-toggle="modal" data-target="#Authors_Modal">
          <?php echo $desc_author_start; ?>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Start Series Modal INFO -->
<div class="modal fade" id="Hpmodel_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-cogs"></i> <?php echo $name_kit_series; ?></h4>
      </div>
      <div class="modal-body">
        <div class="help-text"><?php echo $help_first_kit_series; ?></div>
      </div>
      <div class="modal-footer">
        <div class="text-center"><?php echo $copy_label; ?></div>
      </div>
    </div>
  </div>
</div>
<!--// END Series Modal INFO -->
<!-- Start Series Modal INFO -->
<div class="modal fade" id="Series_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-cogs"></i> <?php echo $name_series; ?></h4>
      </div>
      <div class="modal-body">
        <div class="help-text"><?php echo $help_first_series; ?></div>
        <div class="text-center"><?php echo $help_second_series; ?></div>
        <div class="help-text"><?php echo $help_third_series; ?></div>
        <div class="text-center"><?php echo $help_second_store; ?></div>
        <div class="help-text"><?php echo $help_third_store; ?></div>
        <div class="text-center"><?php echo $help_fourth_series; ?></div>
        <div class="help-text"><?php echo $help_fifth_series; ?></div>
        <div class="text-center"><?php echo $help_sixth_series; ?></div>
        <div class="help-text"><?php echo $help_seventh_series; ?></div>
        <div class="text-center"><?php echo $help_eighth_series; ?></div>
        <div class="help-text"><?php echo $help_ninth_series; ?></div>
        <div class="text-center"><?php echo $help_first_next; ?></div>
        <div class="help-text"><?php echo $help_second_next; ?></div>
        <div class="text-center"><?php echo $help_tenth_series; ?></div>
        <div class="help-text"><?php echo $help_eleventh_series; ?></div>
        <div class="text-center"><?php echo $help_twelfth_series; ?></div>
        <div class="help-text"><?php echo $help_thirteenth_series; ?></div>
      </div>
      <div class="modal-footer">
        <div class="text-center"><?php echo $copy_label; ?></div>
      </div>
    </div>
  </div>
</div>
<!--// END Series Modal INFO -->
<!-- Start Type_Lists_Modal -->
<div class="modal fade" id="Type_Lists" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-cogs"></i> <?php echo $help_name_lists; ?></h4>
            </div>
            <div class="modal-body">
                <div class="text-center"><?php echo $help_on_lists; ?></div>
                <div class="help-text"><?php echo $help_on_off_lists; ?></div>
                <div class="text-center"><?php echo $help_first_lists; ?></div>
                <div class="help-text"><?php echo $help_second_lists; ?></div>
                <div class="text-center"><?php echo $help_third_lists; ?></div>
                <div class="help-text"><?php echo $help_fourth_lists; ?></div>
                <div class="text-center"><?php echo $help_fifth_lists; ?></div>
                <div class="help-text"><?php echo $help_sixth_lists; ?></div>
                <div class="text-center"><?php echo $help_fifth_type; ?></div>
                <div class="help-text"><?php echo $help_sixth_type; ?></div>
                <div class="text-center"><?php echo $help_seventh_lists; ?></div>
                <div class="help-text"><?php echo $help_eighth_lists; ?></div>
                <div class="text-center"><?php echo $help_ninth_lists; ?></div>
                <div class="help-text"><?php echo $help_tenth_lists; ?></div><hr>
                <div class="text-center"><?php echo $helper_list; ?></div>
                <div class="help-text"><?php echo $helper_lists; ?></div>
            </div>
            <div class="modal-footer">
                <div class="text-center"><?php echo $copy_label; ?></div>
            </div>
        </div>
    </div>
</div>
<!--// END Type_Lists__Modal -->
<!-- Start Type_Product_Modal -->
<div class="modal fade" id="Type_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-cogs"></i> <?php echo $help_name_type; ?></h4>
      </div>
      <div class="modal-body">
        <div class="text-center"><?php echo $help_first_type; ?></div>
        <div class="help-text"><?php echo $help_second_type; ?></div>
        <div class="text-center"><?php echo $help_third_type; ?></div>
        <div class="help-text"><?php echo $help_fourth_type; ?></div>
        <div class="text-center"><?php echo $help_seventh_type; ?></div>
        <div class="help-text"><?php echo $help_eighth_type; ?></div>
        <div class="text-center"><?php echo $help_ninth_type; ?></div>
        <div class="help-text"><?php echo $help_tenth_type; ?></div>
        <div class="text-center"><?php echo $help_first_column; ?></div>
        <div class="help-text"><?php echo $help_second_column; ?></div>
        <div class="text-center"><?php echo $help_third_column; ?></div>
        <div class="help-text"><?php echo $help_fourth_column; ?></div>
        <div class="text-center"><?php echo $help_fifth_column; ?></div>
        <div class="help-text"><?php echo $help_sixth_column; ?></div>
        <div class="text-center"><?php echo $help_seventh_column; ?></div>
        <div class="help-text"><?php echo $help_eighth_column; ?></div>
      </div>
      <div class="modal-footer">
        <div class="text-center"><?php echo $copy_label; ?></div>
      </div>
    </div>
  </div>
</div>
<!--// END Type_Product__Modal -->
<!-- Start Column_Modal -->
<div class="modal fade" id="Column_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-cogs"></i> <?php echo $hpm_fields_block; ?></h4>
      </div>
      <div class="modal-body">
        <div class="text-center"><?php echo $help_fifth_type; ?></div>
        <div class="help-text"><?php echo $help_sixth_type; ?></div>
      </div>
      <div class="modal-footer">
        <div class="text-center"><?php echo $copy_label; ?></div>
      </div>
    </div>
  </div>
</div>
<!--// END Column_Modal -->
<!-- Start CSS_JS_Modal -->
<div class="modal fade" id="CSS_JS_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-cogs"></i> <?php echo $help_name_js; ?></h4>
      </div>
      <div class="modal-body">
        <div class="text-center"><?php echo $help_first_js; ?></div>
        <div class="help-text"><?php echo $help_second_js; ?></div>
        <div class="text-center"><?php echo $help_third_js; ?></div>
        <div class="help-text"><?php echo $help_fourth_js; ?></div>
      </div>
      <div class="modal-footer">
        <div class="text-center"><?php echo $copy_label; ?></div>
      </div>
    </div>
  </div>
</div>
<!--// END CSS_JS_Modal -->
<!-- Start Modal Authors -->
<div class="modal fade" id="Authors_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-copyright"></i> <?php echo $desc_author; ?></h4>
      </div>
      <div class="modal-body authors">
        <legend class="text-center"><?php echo $desc_copy; ?></legend>
        <div class="text-center"><?php echo $desc_author_copy; ?></div>
        <br>
      </div>
      <div class="modal-footer">
        <div class="text-center"><?php echo $copy_label; ?></div>
      </div>
    </div>
  </div>
</div>
<!-- END Modal Authors -->
<script>
$('.bootstrap-switcher').bootstrapSwitch();
$('.select-col').on('change', function(){var $c=$(this).closest('td');$c.find('.prop').hide();$c.find('.prop-'+$(this).val()).show();});
$('.select-col').trigger('change');
$('.prop-attribute input[type="text"]').autocomplete({
    'source': function(request, response) {
        var t = this;
        $.ajax({
            url: 'index.php?route=catalog/attribute/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
            dataType: 'json',
            success: function(json) {
                response($.map(json, function(item) {
                    return {
                        category: item.attribute_group,
                        label: item.name,
                        value: item.attribute_id,
                        t: t
                    }
                }));
            }
        });
    },
    'select': function(item) {
        $(item.t).val(item['label']);
        $(item.t).prev().val(item['value']);
    }
});
</script>
<?php echo $footer; ?>