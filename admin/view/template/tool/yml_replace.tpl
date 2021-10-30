<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <a onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-yml').submit() : false;"
                   class="btn btn-primary" style="margin-bottom: 15px;">Выполнить</a>
            </div>
            <h1>Структура YML</h1>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-yml" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-exclamation-triangle"></i>Загрузка Файла</h3>
            </div>
            <div class="panel-body">
                <div class="col-sm-3">
                    <input type="file" name="file" value="" class="form-control">
                </div>
            </div>
            <div class="panel-body">
            <div class="tab-pane" id="tab-string_replece">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <td class="text-left">Найти</td>
                        <td class="text-left">Заменить</td>
                        <td class="text-left"></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $recurring_row = 0; ?>
                    <tfoot>
                    <tr>
                        <td colspan="2"></td>
                        <td class="text-left"><button type="button" onclick="add()" data-toggle="tooltip" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        </div>
        </form>
    </form>
</div>

<script type="text/javascript"><!--
    var recurring_row = <?php echo $recurring_row; ?>;
    function add() {
        html  = '<tr id="recurring-row' + recurring_row + '">';
        html += '  <td class="left">';
        html += '    <input name="string_replece[' + recurring_row + '][from]" value="" class="form-control">';
        html += '  </td>';
        html += '  <td class="left">';
        html += '    <input name="string_replece[' + recurring_row + '][to]" value="" class="form-control">';
        html += '  </td>';
        html += '  <td class="left">';
        html += '    <a onclick="$(\'#recurring-row' + recurring_row + '\').remove()" data-toggle="tooltip"  class="btn btn-danger"><i class="fa fa-minus-circle"></i></a>';
        html += '  </td>';
        html += '</tr>';

        $('#tab-string_replece table tbody').append(html);

        recurring_row++;
    }
//--></script>


<?php echo $footer; ?>