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
              <label class="col-sm-2 control-label" for="input-product">Продукт</label>
              <div class="col-sm-10">
                <input type="text" name="product_name" value="<?php echo $product_name; ?>" placeholder="Продукт" id="input-product" class="form-control" />
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
              </div>
            </div>



            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-delivery">Поставщик</label>
              <div class="col-sm-10">
                <div class="well well-sm" style="min-height: 150px;max-height: 500px;overflow: auto;">
                  <?php foreach ($providers as $provider) { ?>
                  <div class="checkbox">
                    <?php if($id_provider == $provider['id_provider']){ ?>
                    <label>
                      <input type="radio" name="id_provider" value="<?php echo $provider['id_provider']; ?>" checked/>
                      <?php echo $provider['name']; ?>
                    </label>
                    <?php }else{ ?>
                    <label>
                      <input type="radio" name="id_provider" value="<?php echo $provider['id_provider']; ?>" />
                      <?php echo $provider['name']; ?>
                    </label>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
              </div>
            </div>


            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-ship">Метод Доставки</label>
              <div class="col-sm-10">
                <div class="well well-sm" style="min-height: 150px;max-height: 500px;overflow: auto;">
                  <?php foreach ($shippings as $shipping) { ?>
                  <div class="checkbox">
                    <?php if ($id_shiping == $shipping['id']) { ?>
                    <label>
                      <input type="radio" name="id_shiping" value="<?php echo $shipping['id']; ?>" checked/>
                      <?php echo $shipping['name']; ?>
                    </label>
                    <?php }else{ ?>
                    <label>
                      <input type="radio" name="id_shiping" value="<?php echo $shipping['id']; ?>" />
                      <?php echo $shipping['name']; ?>
                    </label>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">Доступность</label>
              <div class="col-sm-10">
                <label class="radio-inline">
                  <?php if ($status_ship) { ?>
                  <input type="radio" name="status_ship" value="1" checked="checked" />
                   Включен для Всей Украины
                  <?php } else { ?>
                  <input type="radio" name="status_ship" value="1" />
                  Отключен для Всей Украины
                  <?php } ?>
                </label>
                <label class="radio-inline">
                  <?php if (!$status_ship) { ?>
                  <input type="radio" name="status_ship" value="0" checked="checked" />
                  Включен для Всей Украины
                  <?php } else { ?>
                  <input type="radio" name="status_ship" value="0" />
                  Отключен для Всей Украины
                  <?php } ?>
                </label>
              </div>
            </div>




            <div class="form-group">
              <label class="col-sm-2 control-label">Статус</label>
              <div class="col-sm-10">
                <label class="radio-inline">
                  <?php if ($status) { ?>
                  <input type="radio" name="status" value="1" checked="checked" />
                  Включен
                  <?php } else { ?>
                  <input type="radio" name="status" value="1" />
                  Включен
                  <?php } ?>
                </label>
                <label class="radio-inline">
                  <?php if (!$status) { ?>
                  <input type="radio" name="status" value="0" checked="checked" />
                  Выключен
                  <?php } else { ?>
                  <input type="radio" name="status" value="0" />
                  Выключен
                  <?php } ?>
                </label>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-city">Город</label>
              <div class="col-sm-10">
                <div class="well well-sm" style="min-height: 150px;max-height: 500px;overflow: auto;">
                  <?php foreach ($citys as $city) { ?>
                  <div class="checkbox">
                    <?php if (in_array($city['name'], $city_delivery)) { ?>
                    <label>
                      <input type="checkbox" name="city_delivery[]" value="<?php echo $city['name']; ?>" checked/>
                      <?php echo $city['name']; ?>
                    </label>
                    <?php }else{ ?>
                    <label>
                      <input type="checkbox" name="city_delivery[]" value="<?php echo $city['name']; ?>" />
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
            <label class="col-sm-2 control-label" for="input-day-delivery">Количество дней</label>
            <div class="col-sm-10">
              <input type="text" name="day_delivery" value="<?php echo $day_delivery; ?>" placeholder="Количество дней" id="input-day-delivery" class="form-control" />
            </div>
          </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-time-delivery">Время Отброжения Даты</label>
              <div class="col-sm-10">
                <input type="text" name="time_delivery" value="<?php echo $time_delivery; ?>" placeholder="Время Отброжения Даты" id="input-time-delivery" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-weekend">Выходные дни<br>
              0 - Пн - Пт<br>
              1 - Пн - Сб<br>
              2 - Пн - Вс
              </label>
              <div class="col-sm-10">
                <input type="text" name="weekend" value="<?php echo $weekend; ?>" placeholder="Время Отброжения Даты" id="input-weekend" class="form-control" />
              </div>
            </div>


            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-day">Пользовательский параммерт</label>
              <div class="col-sm-10">
                <input type="text" name="day" value="<?php echo $day; ?>" placeholder="Пользовательский параммерт" id="input-day" class="form-control" />
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-price">Стоимость Доставки</label>
              <div class="col-sm-10">
                <input type="text" name="price" value="<?php echo $price; ?>" placeholder="Стоимость Доставки" id="input-price" class="form-control" />
              </div>
            </div>


        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
    $('input[name=\'product_name\']').autocomplete({
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
        $('input[name=\'product_name\']').val(item['label']);
        $('input[name=\'product_id\']').val(item['value']);
      }
    });
    //--></script>
</div>
</div>
<?php echo $footer; ?>
