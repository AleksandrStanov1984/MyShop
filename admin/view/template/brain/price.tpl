<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <h1>Log Brain Корректировка</h1>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-import" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-exclamation-triangle"></i>Загрузка Файла Обновление Цен Brain API</h3>
            </div>
            <div class="panel-body">
                <div class="col-sm-3">
                    <input type="file" name="import_file" accept=".csv" value="" class="form-control">
                </div>
            </div>
            <div class="container-fluid">
                <div class="pull-right">
                    <a onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-import').submit() : false;"
                       class="btn btn-primary" style="margin-bottom: 15px;">Выполнить</a>
                </div>
            </div>
        </form>

        <form action="<?php echo $action_zagluhka; ?>" method="post" enctype="multipart/form-data" id="form-zagluhka" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-exclamation-triangle"></i>Загрузка Файла Выключение Продуктов Brain API</h3>
            </div>
            <div class="panel-body">
                <div class="col-sm-3">
                    <input type="file" name="zagluhka_file" accept=".csv" value="" class="form-control">
                </div>
            </div>
            <div class="container-fluid">
                <div class="pull-right">
                    <a onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-zagluhka').submit() : false;"
                       class="btn btn-primary" style="margin-bottom: 15px;">Выполнить</a>
                </div>
            </div>
        </form>
    </div>
</div>
<?php echo $footer; ?>