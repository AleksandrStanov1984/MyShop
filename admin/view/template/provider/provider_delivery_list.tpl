<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
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
                <label class="control-label" for="input-name">Продукт Название</label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="Продукт Название" id="input-name" class="form-control" />
                <input type="hidden" name="filter_name_id" value="<?php echo $filter_name_id; ?>" />
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
                  <td class="text-left">Продукт</td>
                  <td class="text-right">Поставщик</td>
                  <td class="text-right">Метод Доставки</td>
                  <td class="text-right">Доступен Украина</td>
                  <td class="text-right">Статус</td>
                  <td class="text-right">Города</td>
                  <td class="text-right">Количество дней</td>
                  <td class="text-right">Время Отброжения Даты</td>
                  <td class="text-right">Выходные дни</td>
                  <td class="text-right">Пользовательский параммерт</td>
                  <td class="text-right">Стоимость Доставки</td>
                  <td class="text-center"></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($provider_ships) { ?>
                <?php foreach ($provider_ships as $provider_ship) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($provider_ship['id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $provider_ship['id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $provider_ship['id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $provider_ship['name_product']; ?></td>
                  <td class="text-right"><?php echo $provider_ship['name_provider']; ?></td>
                  <td class="text-right"><?php echo $provider_ship['name_shiping']; ?></td>
                  <td class="text-right"><?php echo $provider_ship['ship']; ?></td>
                  <td class="text-right"><?php echo $provider_ship['status']; ?></td>
                  <td class="text-right"><?php echo $provider_ship['city']; ?></td>
                  <td class="text-right"><?php echo $provider_ship['day_delivery']; ?></td>
                  <td class="text-right"><?php echo $provider_ship['time_delivery']; ?></td>
                  <td class="text-right"><?php echo $provider_ship['weekend']; ?></td>
                  <td class="text-right"><?php echo $provider_ship['day']; ?></td>
                  <td class="text-right"><?php echo $provider_ship['price']; ?></td>
                  <td class="text-right"><a href="<?php echo $provider_ship['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="20"><?php echo $text_no_results; ?></td>
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
          $('input[name=\'filter_name\']').autocomplete({
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
              $('input[name=\'filter_name\']').val(item['label']);
              $('input[name=\'filter_name_id\']').val(item['value']);
            }
          });
  //--></script>
<script type="text/javascript"><!--
  $('#button-filter').on('click', function() {
    var url = 'index.php?route=provider/provider_delivery&token=<?php echo $token; ?>';

    var filter_name = $('input[name=\'filter_name\']').val();

    if (filter_name) {
      url += '&filter_name=' + encodeURIComponent(filter_name);
    }

    var filter_name_id = $('input[name=\'filter_name_id\']').val();

    if (filter_name_id) {
      url += '&filter_name_id=' + encodeURIComponent(filter_name_id);
    }

    location = url;
  });
  //--></script>


<?php echo $footer; ?>