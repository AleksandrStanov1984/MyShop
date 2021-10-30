<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <a href="<?php echo $download; ?>" data-toggle="tooltip" title="<?php echo $button_download; ?>"
                   class="btn btn-primary"><i class="fa fa-download"></i></a>
                <a onclick="confirm('<?php echo $text_confirm; ?>') ? location.href='<?php echo $clear; ?>' : false;"
                   data-toggle="tooltip" title="<?php echo $button_clear; ?>" class="btn btn-danger"><i
                            class="fa fa-eraser"></i></a>
            </div>
            <h1>Тарифы доставки</h1>
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
                <h3 class="panel-title"><i class="fa fa-exclamation-triangle"></i> Log Записей</h3>
            </div>
            <div class="panel-body">
                <textarea wrap="off" rows="15" readonly class="form-control"><?php echo $log; ?></textarea>
            </div>
        </div>

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-delivery" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-exclamation-triangle"></i>Загрузка Файла</h3>
            </div>
            <div class="panel-body">
                <div class="col-sm-3">
                    <input type="file" name="import_file" accept=".csv" value="" class="form-control">
                </div>
            </div>
            <div class="container-fluid">
                <div class="pull-right">
                    <a onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-delivery').submit() : false;"
                       class="btn btn-primary" style="margin-bottom: 15px;">Выполнить</a>
                </div>
            </div>
        </form>
    </div>
</div>
<?php echo $footer; ?>