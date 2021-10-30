<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>

  <div class="container-fluid">
    <?php if ($error) { ?>
    <?php foreach($error as $err) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $err; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php } ?>
    <?php if ($success) { ?>
    <?php foreach($success as $succe) { ?>
    <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $succe; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product" class="form-horizontal">
          <div class="tab-content">
            <div class="form-group">
                <label class="col-sm-2 control-label">
                  <span data-toggle="tooltip">Выгрузить фаил</span></label>
                <div class="col-sm-2">
                  <input type="submit" name="export" value="Получить фаил" class="form-control">
                </div>
                
                <label class="col-sm-1 control-label"></label>
				
                <label class="col-sm-2 control-label">
                  <span data-toggle="tooltip" >Импортировать фаил</span></label>
                <div class="col-sm-3">
                  <input type="file" name="import_file" value="" class="form-control">
                </div>
                 <div class="col-sm-2">
                  <input type="submit" name="import" value="Импортировать фаил" class="form-control">
                </div>
              </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-category">Выгрузить категории</label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="min-height: 150px;max-height: 500px;overflow: auto;">
                    <table class="table table-striped">
                    <?php foreach ($categories as $category) { ?>
                    <tr>
                      <td class="checkbox">
                        <label>
                          <?php if (in_array($category['category_id'], $product_category)) { ?>
                          <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
                          <?php echo $category['name']; ?>
                          <?php } else { ?>
                          <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" />
                          <?php echo $category['name']; ?>
                          <?php } ?>
                        </label>
                      </td>
                    </tr>
                    <?php } ?>
                    </table>
                  </div>
                  <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a></div>
            </div>
          
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-category">Применить выбор аттрибутов (до 20 шт)</label>
                <div class="col-sm-10">
                  <input type="checkbox" name="filter_attributes" value="1" />
                </div>
            </div>
              
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-category">Выгрузить атрибуты</label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="min-height: 150px;max-height: 500px;overflow: auto;">
                    <table class="table table-striped">
                    <?php foreach ($attr_list as $attr) { ?>
                    <tr>
                      <td class="checkbox">
                        <label>
                          <?php if (in_array($attr['attribute_id'], $product_attributes) OR count($product_attributes) == 0) { ?>
                          <input type="checkbox" name="product_attributes[]" value="<?php echo $attr['attribute_id']; ?>" checked="checked" />
                          <?php echo $attr['name']; ?>
                          <?php } else { ?>
                          <input type="checkbox" name="product_attributes[]" value="<?php echo $attr['attribute_id']; ?>" />
                          <?php echo $attr['name']; ?>
                          <?php } ?>
                        </label>
                      </td>
                    </tr>
                    <?php } ?>
                    </table>
                  </div>
                  <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a></div>
            </div>
              
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
