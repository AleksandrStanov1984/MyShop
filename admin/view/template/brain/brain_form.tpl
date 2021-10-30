<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-manufacturer" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-provider" class="form-horizontal">
          <div class="tab-content">
            <div class="form-group">
            <label class="col-sm-2 control-label" for="input-price_1_file">price_1_file</label>
            <div class="col-sm-10">
              <input type="text" name="price_1_file" value="<?php echo $price_1_file; ?>" id="input-price_1_file" class="form-control" />
            </div>
          </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-price_2_file">price_2_file</label>
              <div class="col-sm-10">
                <input type="text" name="price_2_file" value="<?php echo $price_2_file; ?>" id="input-price_2_file" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-price_base">price_base</label>
              <div class="col-sm-10">
                <input type="text" name="price_base" value="<?php echo $price_base; ?>" id="input-price_base" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-price_rrc">price_rrc</label>
              <div class="col-sm-10">
                <input type="text" name="price_rrc" value="<?php echo $price_rrc; ?>" id="input-price_rrc" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-price_1">price_1</label>
              <div class="col-sm-10">
                <input type="text" name="price_1" value="<?php echo $price_1; ?>" id="input-price_1" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-sort-order">price_2</label>
              <div class="col-sm-10">
                <input type="text" name="price_2" value="<?php echo $price_2; ?>" id="input-price_2" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-price">price</label>
              <div class="col-sm-10">
                <input type="text" name="price" value="<?php echo $price; ?>" id="input-price" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-special">special</label>
              <div class="col-sm-10">
                <input type="text" name="special" value="<?php echo $special; ?>" id="input-special" class="form-control" />
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<?php echo $footer; ?>
