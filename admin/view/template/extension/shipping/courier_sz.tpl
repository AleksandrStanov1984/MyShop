<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-weight" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-weight" class="form-horizontal">
          <div class="row">
            <div class="col-sm-12">
              <div class="tab-content">
                <div class="tab-pane active" id="tab-general">
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-category">Город</label>
                    <div class="col-sm-10">
                      <div class="well well-sm" style="min-height: 150px;max-height: 500px;overflow: auto;">
                        <?php foreach ($citys as $city) { ?>
                        <div class="checkbox">
                          <?php if (in_array($city['name'], $courier_sz_product_city)) { ?>
                          <label>
                            <input type="checkbox" name="courier_sz_product_city[]" value="<?php echo $city['name']; ?>" checked/>
                            <?php echo $city['name']; ?>
                          </label>
                          <?php }else{ ?>
                          <label>
                            <input type="checkbox" name="courier_sz_product_city[]" value="<?php echo $city['name']; ?>" />
                            <?php echo $city['name']; ?>
                          </label>
                          <?php } ?>
                        </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-status-courier_sz"><?php echo $entry_status; ?></label>
                    <div class="col-sm-10">
                      <select name="courier_sz_status" id="input-status-courier_sz" class="form-control">
                        <?php if ($courier_sz_status) { ?>
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
                    <label class="col-sm-2 control-label" for="input-sort-order-courier_sz"><?php echo $entry_sort_order; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="courier_sz_sort_order" value="<?php echo $courier_sz_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order-courier_sz" class="form-control" />
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
<?php echo $footer; ?> 