<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>

                <li><a href="#tab-filter" data-toggle="tab"><?php echo $tab_filter; ?></a></li>
            
            <li><a href="#tab-design" data-toggle="tab"><?php echo $tab_design; ?></a></li>
            <li><a href="#tab-banner" data-toggle="tab"><?php echo $tab_banner; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="category_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_name[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
				 <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-series_name<?php echo $language['language_id']; ?>"><?php echo $entry_series_name; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="category_description[<?php echo $language['language_id']; ?>][series_name]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['series_name'] : ''; ?>" placeholder="<?php echo $entry_series_name; ?>" id="input-series_name<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_name[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
	              <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-additional_input<?php echo $language['language_id']; ?>"><?php echo $entry_additional_input; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="category_description[<?php echo $language['language_id']; ?>][additional_input]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['additional_input'] : ''; ?>" placeholder="<?php echo $entry_additional_input; ?>" id="input-additional_input<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_name[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                           <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-additional_input2<?php echo $language['language_id']; ?>"><?php echo $entry_additional_input2; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="category_description[<?php echo $language['language_id']; ?>][additional_input2]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['additional_input2'] : ''; ?>" placeholder="<?php echo $entry_additional_input2; ?>" id="input-additional_input2<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_name[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="category_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" data-lang="<?php echo $lang; ?>" class="form-control summernote"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['description'] : ''; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="category_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-h1<?php echo $language['language_id']; ?>"><?php echo $entry_meta_h1; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="category_description[<?php echo $language['language_id']; ?>][meta_h1]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_h1'] : ''; ?>" placeholder="<?php echo $entry_meta_h1; ?>" id="input-meta-h1<?php echo $language['language_id']; ?>" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="category_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                    <div class="col-sm-10">
                      <textarea name="category_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="tab-pane" id="tab-data">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-parent"><?php echo $entry_parent; ?></label>
                <div class="col-sm-10">
                  <select name="parent_id" class="form-control">
                    <option value="0" selected="selected"><?php echo $text_none; ?></option>
                    <?php foreach ($categories as $category) { ?>
                    <?php if ($category['category_id'] == $parent_id) { ?>
                    <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-filter"><span data-toggle="tooltip" title="<?php echo $help_filter; ?>"><?php echo $entry_filter; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="filter" value="" placeholder="<?php echo $entry_filter; ?>" id="input-filter" class="form-control" />
                  <div id="category-filter" class="well well-sm" style="height: 150px; overflow: auto;">
                    <?php foreach ($category_filters as $category_filter) { ?>
                    <div id="category-filter<?php echo $category_filter['filter_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $category_filter['name']; ?>
                      <input type="hidden" name="category_filter[]" value="<?php echo $category_filter['filter_id']; ?>" />
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <div class="checkbox">
                      <label>
                        <?php if (in_array(0, $category_store)) { ?>
                        <input type="checkbox" name="category_store[]" value="0" checked="checked" />
                        <?php echo $text_default; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="category_store[]" value="0" />
                        <?php echo $text_default; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php foreach ($stores as $store) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($store['store_id'], $category_store)) { ?>
                        <input type="checkbox" name="category_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                        <?php echo $store['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="category_store[]" value="<?php echo $store['store_id']; ?>" />
                        <?php echo $store['name']; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
                  <?php if ($error_keyword) { ?>
                  <div class="text-danger"><?php echo $error_keyword; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_image; ?></label>
                <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                  <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-top"><span data-toggle="tooltip" title="<?php echo $help_top; ?>"><?php echo $entry_top; ?></span></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <?php if ($top) { ?>
                      <input type="checkbox" name="top" value="1" checked="checked" id="input-top" />
                      <?php } else { ?>
                      <input type="checkbox" name="top" value="1" id="input-top" />
                      <?php } ?>
                      &nbsp; </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-show_desc"><?php echo $entry_show_desc; ?></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <?php if ($show_desc) { ?>
                      <input type="checkbox" name="show_desc" value="1" checked="checked" id="input-show_desc" />
                      <?php } else { ?>
                      <input type="checkbox" name="show_desc" value="1" id="input-show_desc" />
                      <?php } ?>
                      &nbsp; </label>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-show_whl">Скрыть ВШГ</label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <?php if ($show_whl) { ?>
                      <input type="checkbox" name="show_whl" value="1" checked="checked" id="input-show_whl" />
                      <?php } else { ?>
                      <input type="checkbox" name="show_whl" value="1" id="input-show_whl" />
                      <?php } ?>
                      &nbsp; </label>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-column"><span data-toggle="tooltip" title="<?php echo $help_column; ?>"><?php echo $entry_column; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="column" value="<?php echo $column; ?>" placeholder="<?php echo $entry_column; ?>" id="input-column" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>

                <div class="tab-pane" id="tab-filter">
                    <fieldset>
                        <legend><?php echo $text_setting_filter; ?></legend>
                        <div class="form-group">
                          <label class="col-sm-2 control-label"><?php echo $entry_material_filter; ?></label>
                          <div class="col-sm-10">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th><?php echo $entry_filter_status; ?></th>
                                  <th><?php echo $entry_popup_status; ?></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <div class="checkbox">
                                      <label>
                                        <?php if ($material_filter_status) { ?>
                                        <input type="checkbox" name="material_filter_status" value="1" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="material_filter_status" value="1" />
                                        <?php } ?>
                                        &nbsp; </label>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="checkbox">
                                      <label>
                                        <?php if ($material_popup_status) { ?>
                                        <input type="checkbox" name="material_popup_status" value="1" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="material_popup_status" value="1" />
                                        <?php } ?>
                                        &nbsp; </label>
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label"><?php echo $entry_model_filter; ?></label>
                          <div class="col-sm-10">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th><?php echo $entry_filter_status; ?></th>
                                  <th><?php echo $entry_popup_status; ?></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <div class="checkbox">
                                      <label>
                                        <?php if ($model_filter_status) { ?>
                                        <input type="checkbox" name="model_filter_status" value="1" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="model_filter_status" value="1" />
                                        <?php } ?>
                                        &nbsp; </label>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="checkbox">
                                      <label>
                                        <?php if ($model_popup_status) { ?>
                                        <input type="checkbox" name="model_popup_status" value="1" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="model_popup_status" value="1" />
                                        <?php } ?>
                                        &nbsp; </label>
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label"><?php echo $entry_color_filter; ?></label>
                          <div class="col-sm-10">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th><?php echo $entry_filter_status; ?></th>
                                  <th><?php echo $entry_popup_status; ?></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <div class="checkbox">
                                      <label>
                                        <?php if ($color_filter_status) { ?>
                                        <input type="checkbox" name="color_filter_status" value="1" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="color_filter_status" value="1" />
                                        <?php } ?>
                                        &nbsp; </label>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="checkbox">
                                      <label>
                                        <?php if ($color_popup_status) { ?>
                                        <input type="checkbox" name="color_popup_status" value="1" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="color_popup_status" value="1" />
                                        <?php } ?>
                                        &nbsp; </label>
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label"><?php echo $entry_max_weight_filter; ?></label>
                          <div class="col-sm-10">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th><?php echo $entry_filter_status; ?></th>
                                  <th><?php echo $entry_popup_status; ?></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <div class="checkbox">
                                      <label>
                                        <?php if ($max_weight_filter_status) { ?>
                                        <input type="checkbox" name="max_weight_filter_status" value="1" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="max_weight_filter_status" value="1" />
                                        <?php } ?>
                                        &nbsp; </label>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="checkbox">
                                      <label>
                                        <?php if ($max_weight_popup_status) { ?>
                                        <input type="checkbox" name="max_weight_popup_status" value="1" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="max_weight_popup_status" value="1" />
                                        <?php } ?>
                                        &nbsp; </label>
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label"><?php echo $entry_thickness_filter; ?></label>
                          <div class="col-sm-10">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th><?php echo $entry_filter_status; ?></th>
                                  <th><?php echo $entry_popup_status; ?></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <div class="checkbox">
                                      <label>
                                        <?php if ($thickness_filter_status) { ?>
                                        <input type="checkbox" name="thickness_filter_status" value="1" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="thickness_filter_status" value="1" />
                                        <?php } ?>
                                        &nbsp; </label>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="checkbox">
                                      <label>
                                        <?php if ($thickness_popup_status) { ?>
                                        <input type="checkbox" name="thickness_popup_status" value="1" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="thickness_popup_status" value="1" />
                                        <?php } ?>
                                        &nbsp; </label>
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label"><?php echo $entry_qnt_shelv_filter; ?></label>
                          <div class="col-sm-10">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th><?php echo $entry_filter_status; ?></th>
                                  <th><?php echo $entry_popup_status; ?></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <div class="checkbox">
                                      <label>
                                        <?php if ($qnt_shelv_filter_status) { ?>
                                        <input type="checkbox" name="qnt_shelv_filter_status" value="1" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="qnt_shelv_filter_status" value="1" />
                                        <?php } ?>
                                        &nbsp; </label>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="checkbox">
                                      <label>
                                        <?php if ($qnt_shelv_popup_status) { ?>
                                        <input type="checkbox" name="qnt_shelv_popup_status" value="1" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="qnt_shelv_popup_status" value="1" />
                                        <?php } ?>
                                        &nbsp; </label>
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label"><?php echo $entry_type_filter; ?></label>
                          <div class="col-sm-10">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th><?php echo $entry_filter_status; ?></th>
                                  <th><?php echo $entry_popup_status; ?></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <div class="checkbox">
                                      <label>
                                        <?php if ($type_filter_status) { ?>
                                        <input type="checkbox" name="type_filter_status" value="1" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="type_filter_status" value="1" />
                                        <?php } ?>
                                        &nbsp; </label>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="checkbox">
                                      <label>
                                        <?php if ($type_popup_status) { ?>
                                        <input type="checkbox" name="type_popup_status" value="1" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="type_popup_status" value="1" />
                                        <?php } ?>
                                        &nbsp; </label>
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label"><?php echo $entry_series_filter; ?></label>
                          <div class="col-sm-10">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th><?php echo $entry_filter_status; ?></th>
                                  <th><?php echo $entry_popup_status; ?></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <div class="checkbox">
                                      <label>
                                        <?php if ($series_filter_status) { ?>
                                        <input type="checkbox" name="series_filter_status" value="1" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="series_filter_status" value="1" />
                                        <?php } ?>
                                        &nbsp; </label>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="checkbox">
                                      <label>
                                        <?php if ($series_popup_status) { ?>
                                        <input type="checkbox" name="series_popup_status" value="1" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="series_popup_status" value="1" />
                                        <?php } ?>
                                        &nbsp; </label>
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label"><?php echo $entry_brand_filter; ?></label>
                          <div class="col-sm-10">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th><?php echo $entry_filter_status; ?></th>
                                  <th><?php echo $entry_popup_status; ?></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <div class="checkbox">
                                      <label>
                                        <?php if ($brand_filter_status) { ?>
                                        <input type="checkbox" name="brand_filter_status" value="1" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="brand_filter_status" value="1" />
                                        <?php } ?>
                                        &nbsp; </label>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="checkbox">
                                      <label>
                                        <?php if ($brand_popup_status) { ?>
                                        <input type="checkbox" name="brand_popup_status" value="1" checked="checked" />
                                        <?php } else { ?>
                                        <input type="checkbox" name="brand_popup_status" value="1" />
                                        <?php } ?>
                                        &nbsp; </label>
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                    </fieldset>
                </div>
            
            <div class="tab-pane" id="tab-design">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left"><?php echo $entry_store; ?></td>
                      <td class="text-left"><?php echo $entry_layout; ?></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-left"><?php echo $text_default; ?></td>
                      <td class="text-left"><select name="category_layout[0]" class="form-control">
                          <option value=""></option>
                          <?php foreach ($layouts as $layout) { ?>
                          <?php if (isset($category_layout[0]) && $category_layout[0] == $layout['layout_id']) { ?>
                          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <?php foreach ($stores as $store) { ?>
                    <tr>
                      <td class="text-left"><?php echo $store['name']; ?></td>
                      <td class="text-left"><select name="category_layout[<?php echo $store['store_id']; ?>]" class="form-control">
                          <option value=""></option>
                          <?php foreach ($layouts as $layout) { ?>
                          <?php if (isset($category_layout[$store['store_id']]) && $category_layout[$store['store_id']] == $layout['layout_id']) { ?>
                          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane" id="tab-banner">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-banner"><?php echo $entry_banner; ?></label>
                <div class="col-sm-10">
                  <select name="banner_id" id="input-banner" class="form-control">
                    <option value="0" selected="selected"><?php echo $text_none; ?></option>
                    <?php foreach ($banners as $banner) { ?>
                    <?php if ($banner['banner_id'] == $banner_id) { ?>
                    <option value="<?php echo $banner['banner_id']; ?>" selected="selected"><?php echo $banner['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $banner['banner_id']; ?>"><?php echo $banner['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-width"><?php echo $entry_width; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="width" value="<?php echo $width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-width" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-height"><?php echo $entry_height; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="height" value="<?php echo $height; ?>" placeholder="<?php echo $entry_height; ?>" id="input-height" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="banner_status" id="input-banner-status" class="form-control">
                    <?php if ($banner_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
  <?php if ($ckeditor) { ?>
    <?php foreach ($languages as $language) { ?>
        ckeditorInit('input-description<?php echo $language['language_id']; ?>', getURLVar('token'));
    <?php } ?>
  <?php } ?>
  //--></script>
  <script type="text/javascript"><!--
$('input[name=\'path\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					category_id: 0,
					name: '<?php echo $text_none; ?>'
				});

				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['category_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'path\']').val(item['label']);
		$('input[name=\'parent_id\']').val(item['value']);
	}
});
//--></script>
  <script type="text/javascript"><!--
$('input[name=\'filter\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/filter/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['filter_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter\']').val('');

		$('#category-filter' + item['value']).remove();

		$('#category-filter').append('<div id="category-filter' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="category_filter[]" value="' + item['value'] + '" /></div>');
	}
});

$('#category-filter').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
//--></script>
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>
