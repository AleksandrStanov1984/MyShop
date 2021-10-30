<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a class="btn btn-success" onclick="$('#save').val('stay');$('#form-load-format-pagination').submit();"><i class="fa fa-check"></i> <?php echo $button_stay; ?></a>
        <button type="submit" form="form-load-format-pagination" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <?php if ($success) { ?>
      <div class="alert alert-success"><i class="fa fa-check"></i> <?php echo $success; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-load-format-pagination" class="form-horizontal">
          <input type="hidden" name="save" id="save" value="0">

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
              <div class="col-sm-10">
                <input type="text" name="load_format_pagination_name" value="<?php echo $load_format_pagination_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
                <?php if ($error_name) { ?>
                <div class="text-danger"><?php echo $error_name; ?></div>
                <?php } ?>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-width"><?php echo $border_style; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <label class="col-sm-2 control-label" for="input-borderwidth"><?php echo $input_borderwidth; ?></label>
                  <div class="col-sm-2">
                    <input type="text" name="load_format_pagination_borderwidth" value="<?php echo $load_format_pagination_borderwidth; ?>"  id="load-pagination-borderwidth" size="6" class="form-control" placeholder="<?php echo $text_borderwidth; ?>"/>
                  </div>
                  <label class="col-sm-2 control-label" for="input-borderround"><?php echo $input_borderround; ?></label>
                  <div class="col-sm-2">
                    <input type="text" name="load_format_pagination_borderround" value="<?php echo $load_format_pagination_borderround; ?>" id="load-pagination-borderround" size="6" class="form-control" placeholder="<?php echo $text_borderround; ?>" />
                  </div>
                  <label class="col-sm-2 control-label" for="input-bordercolor"><?php echo $input_bordercolor; ?></label>
                  <div class="col-sm-2">
                    <input type="text" name="load_format_pagination_bordercolor" value="<?php echo $load_format_pagination_bordercolor; ?>"  id="load-pagination-bordercolor" size="6" class="jscolor {required:false,hash:true} form-control"  />
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-width"><?php echo $button_style; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <label class="col-sm-2 control-label" for="input-borderwidth"><?php echo $input_buttoncolor; ?></label>
                  <div class="col-sm-2">
                    <input type="text" name="load_format_pagination_buttoncolor" value="<?php echo $load_format_pagination_buttoncolor; ?>"  id="load-pagination-buttoncolor" size="6" class="jscolor {required:false,hash:true} form-control"  />
                  </div>
                  <label class="col-sm-2 control-label" for="input-borderwidth"><?php echo $input_button_backgroundcolor; ?></label>
                  <div class="col-sm-2">
                    <input type="text" name="load_format_pagination_backgroundcolor" value="<?php echo $load_format_pagination_backgroundcolor; ?>"  id="load-pagination-backgroundcolor" size="6" class="jscolor {required:false,hash:true} form-control"  />
                  </div>
                  <div class="col-sm-offset-4">
                </div>
              </div>
            </div>
          </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-width"><?php echo $hover_button_style; ?></label>
              <div class="col-sm-10">
                <div class="row">
                  <label class="col-sm-2 control-label" for="load-pagination-buttoncolor"><?php echo $hover_input_buttoncolor; ?></label>
                      <div class="col-sm-2">
                        <input type="text" name="load_format_pagination_hover_buttoncolor" value="<?php echo $load_format_pagination_hover_buttoncolor; ?>"  id="load-pagination-buttoncolor" size="6" class="jscolor {required:false,hash:true} form-control"  />
                      </div>
                      <label class="col-sm-2 control-label" for="load-pagination-backgroundcolor"><?php echo $hover_input_button_backgroundcolor; ?></label>
                      <div class="col-sm-2">
                        <input type="text" name="load_format_pagination_hover_backgroundcolor" value="<?php echo $load_format_pagination_hover_backgroundcolor; ?>"  id="load-pagination-backgroundcolor" size="6" class="jscolor {required:false,hash:true} form-control"  />
                      </div>
                      <div class="col-sm-offset-4">
                    </div>
                </div>
              </div>
            </div>


            <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="load_format_pagination_status" id="input-status" class="form-control">
                <?php if ($load_format_pagination_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="view/javascript/jscolor.js"></script>
</div>
<?php echo $footer; ?>