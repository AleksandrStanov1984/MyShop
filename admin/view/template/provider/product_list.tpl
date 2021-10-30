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
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-provider">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-right">Поставщик</td>
                  <td class="text-right">Код поставщика</td>
                  <td class="text-right">ID продукта поставщика</td>
                  <td class="text-right">Код продукта поставщика</td>
                  <td class="text-right">Название продукта поставщика</td>
                  <td class="text-right">Старая Базавая Цена</td>
                  <td class="text-right">Старая Цена RRC</td>
                  <td class="text-right">Базавая Цена</td>
                  <td class="text-right">Цена RRC</td>
                  <td class="text-right">Статус N Цены</td>
                  <td class="text-right">Статус</td>
                  <td class="text-right">isImport</td>
                  <td class="text-right">Дата добавления</td>
                  <td class="text-right">Дата изменений</td>
                  <td class="text-right">Дата закупки</td>
                  <td class="text-center"></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($provider_products) { ?>
                <?php foreach ($provider_products as $provider_product) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($provider_product['id_nomer'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $provider_product['id_nomer']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $provider_product['id_nomer']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $provider_product['name_provider']; ?></td>
                  <td class="text-right"><?php echo $provider_product['code_provider']; ?></td>
                  <td class="text-right"><?php echo $provider_product['id_provider_product']; ?></td>
                  <td class="text-right"><?php echo $provider_product['code_provider_product']; ?></td>
                  <td class="text-right"><?php echo $provider_product['name_provider_product']; ?></td>
                  <td class="text-right"><?php echo $provider_product['old_price_base']; ?></td>
                  <td class="text-right"><?php echo $provider_product['old_price_rrc']; ?></td>
                  <td class="text-right"><?php echo $provider_product['price_base']; ?></td>
                  <td class="text-right"><?php echo $provider_product['price_rrc']; ?></td>
                  <td class="text-right"><?php echo $provider_product['status_n_price']; ?></td>
                  <td class="text-right"><?php echo $provider_product['status_n']; ?></td>
                  <td class="text-right"><?php echo $provider_product['isimport']; ?></td>
                  <td class="text-right"><?php echo $provider_product['date_added']; ?></td>
                  <td class="text-right"><?php echo $provider_product['date_modified']; ?></td>
                  <td class="text-right"><?php echo $provider_product['date_zakup']; ?></td>
                  <td class="text-right"><a href="<?php echo $provider_product['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
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
<?php echo $footer; ?>