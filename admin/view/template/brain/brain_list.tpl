<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a class="btn btn-info" href="<?php echo $createtable; ?>">Создать таблицу</a>
        <a class="btn btn-info" href="<?php echo $getprice; ?>">Перерасчет PRODUCT PRICE</a>
        <a class="btn btn-info" href="<?php echo $add_special; ?>">Создание Зачеркнутых Цен</a>
        <a class="btn btn-info" href="<?php echo $delete_special_table; ?>">Удаление Зачеркнутых Цен согластно таблицы</a>
        <a class="btn btn-info" href="<?php echo $update_price; ?>">Обновление Цен продуктов</a>
        <a class="btn btn-info" href="<?php echo $delete_special; ?>">Удаление Всех Зачеркнутых цен Brain</a>
        <a class="btn btn-info" href="<?php echo $oldpriceproduct; ?>">Откат цен продуктов</a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-provider').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
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
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">

        <div class="well">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-product_id">Product ID</label>
                <input type="text" name="filter_product_id" value="<?php echo $filter_product_id;?>"  id="input-product_id" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-sku">Sku</label>
                <input type="text" name="filter_sku" value="<?php echo $filter_sku;?>" id="input-sku" class="form-control" />
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> Поиск</button>
            </div>
          </div>
        </div>


        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-provider">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left">Продукт ID</td>
                  <td class="text-left">Продукт SKU</td>
                  <td class="text-right">price_1_file</td>
                  <td class="text-right">price_2_file</td>
                  <td class="text-right">stock_status_id</td>
                  <td class="text-right">price_base</td>
                  <td class="text-right">price_rrc</td>
                  <td class="text-right">price_1</td>
                  <td class="text-right">price_2</td>
                  <td class="text-right">price</td>
                  <td class="text-right">special</td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($brains) { ?>
                <?php foreach ($brains as $brain) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($brain['id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $brain['id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $brain['id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $brain['product_id']; ?></td>
                  <td class="text-left"><?php echo $brain['sku']; ?></td>
                  <td class="text-left"><?php echo $brain['price_1_file']; ?></td>
                  <td class="text-left"><?php echo $brain['price_2_file']; ?></td>
                  <td class="text-left"><?php echo $brain['stock_status_id']; ?></td>
                  <td class="text-left"><?php echo $brain['price_base']; ?></td>
                  <td class="text-left"><?php echo $brain['price_rrc']; ?></td>
                  <td class="text-left"><?php echo $brain['price_1']; ?></td>
                  <td class="text-left"><?php echo $brain['price_2']; ?></td>
                  <td class="text-left"><?php echo $brain['price']; ?></td>
                  <td class="text-right"><?php echo $brain['special']; ?></td>
                  <td class="text-right"><a href="<?php echo $brain['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="14"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
  $('#button-filter').on('click', function() {
    var url = 'index.php?route=brain/brain_result&token=<?php echo $token; ?>';

    var filter_product_id = $('input[name=\'filter_product_id\']').val();

    if (filter_product_id) {
      url += '&filter_product_id=' + encodeURIComponent(filter_product_id);
    }

    var filter_sku = $('input[name=\'filter_sku\']').val();

    if (filter_sku) {
      url += '&filter_sku=' + encodeURIComponent(filter_sku);
    }

    location = url;
  });
  //--></script>
<?php echo $footer; ?>