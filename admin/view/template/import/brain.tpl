<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
       <h1>API Brain</h1>
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
        <h3 class="panel-title"><i class="fa fa-list"></i> Операции</h3>
      </div>
      <div class="panel-body">
        <form action="" method="post" enctype="multipart/form-data" id="form-attribute-group">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-left">Обновление</td>
                  <td class="text-right">Статус</td>
                  <td class="text-right"></td>
                </tr>
              </thead>
              <tbody>
              <tr>
                  <td class="text-left">Информация</td>
                  <td class="text-right">
                      Дата последнего прайса: <?php echo $prices_row['date']; ?><br>
                      Всего позиций: <?php echo $total_prices; ?><br>
                      Обработано: <?php echo $total_prices_updated; ?> (<?php echo $total_prices_updated_procent; ?>%)<br>
                  </td>
                  <td class="text-right"></td>
                </tr>
                
                <tr>
                  <td class="text-left">Производители</td>
                  <td class="text-right">
					В базе: <?php echo $my_manufacturers; ?><br>
					Получено по API: <?php echo $import_brain_manufacturers; ?><br>
					Добавленно: <?php echo $import_brain_manufacturers_added; ?><br>
				  </td>
                  <td class="text-right">
						<a href="<?php echo $import_manufacturer; ?>" data-toggle="tooltip" title="обновить" class="btn btn-primary">
						<i class="fa fa-refresh"></i></a></td>
                </tr>
                
               <tr>
                  <td class="text-left">Категории</td>
                  <td class="text-right">
					В базе: <?php echo $my_categories; ?><br>
					Получено по API: <?php echo $import_brain_categories; ?><br>
					Добавленно: <?php echo $import_brain_categories_added; ?><br>
				  </td>
                  <td class="text-right">
						<a href="<?php echo $import_category; ?>" data-toggle="tooltip" title="обновить" class="btn btn-primary">
						<i class="fa fa-refresh"></i></a></td>
                </tr>
                <tr>
                  <td class="text-left">Товары</td>
                  <td class="text-right">
					В базе: <?php echo $my_products; ?><br>
					Получено по API: <?php echo $import_brain_products; ?><br>
					Добавленно: <?php echo $import_brain_products_added; ?><br>
				  </td>
                  <td class="text-right">
						<a href="<?php echo $import_product; ?>" data-toggle="tooltip" title="обновить" class="btn btn-primary">
						<i class="fa fa-refresh"></i></a></td>
                </tr>
                <tr>
                  <td class="text-left">Удалить отсутствующие товары</td>
                  <td class="text-right"></td>
                  <td class="text-right">
						<a href="<?php echo $delete_product; ?>" data-toggle="tooltip" title="обновить" class="btn btn-primary">
						<i class="fa fa-refresh"></i></a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>