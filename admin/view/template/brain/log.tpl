<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <a href="<?php echo $update_price; ?>" data-toggle="tooltip" title="Обновление Цен"
                   class="btn btn-primary" target="_blank">Обновление Цен</a>
                <a href="<?php echo $update_down_table; ?>" data-toggle="tooltip" title="Загрузка в временную таблицу"
                   class="btn btn-primary" target="_blank">Загрузка в временную таблицу</a>
                <a href="<?php echo $update_status; ?>" data-toggle="tooltip" title="Изменения Статуса Продукта"
                   class="btn btn-primary" target="_blank">Изменения Статуса Продукта</a>
            </div>
            <h1>Log Обновления Цен</h1>
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
                <h3 class="panel-title"><i class="fa fa-exclamation-triangle"></i>Log Записей</h3>
            </div>
            <div class="panel-body">
                <textarea wrap="off" rows="15" readonly class="form-control"><?php echo $log; ?></textarea>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>