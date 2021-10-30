<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
       <h1>Обновить URL</h1>
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
                  <td class="text-left">Производители</td>
                  <td class="text-right">
					Всего производителей: <?php echo $my_manufacturers; ?><br>
					URL: <?php echo $url_manufacturers; ?><br>
				  </td>
                  <td class="text-right">
						<a href="<?php echo $action_manufacturer; ?>" data-toggle="tooltip" title="обновить" class="btn btn-primary">
						<i class="fa fa-refresh"></i></a></td>
                </tr>
               <tr>
                  <td class="text-left">Категории</td>
                  <td class="text-right">
					Всего категорий: <?php echo $my_categories; ?><br>
					URL: <?php echo $url_categories; ?><br>
				  </td>
                  <td class="text-right">
						<a href="<?php echo $action_category; ?>" data-toggle="tooltip" title="обновить" class="btn btn-primary">
						<i class="fa fa-refresh"></i></a></td>
                </tr>
                <tr>
                  <td class="text-left">Товары</td>
                  <td class="text-right">
					Всего товаров: <?php echo $my_products; ?><br>
					URL: <?php echo $url_products; ?><br>
				  </td>
                  <td class="text-right">
						<a href="<?php echo $action_product; ?>" data-toggle="tooltip" title="обновить" class="btn btn-primary">
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