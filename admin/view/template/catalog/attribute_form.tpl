
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <div class="counter btn btn-primary submit"></div>
                <button type="button" form="form-attribute" data-toggle="tooltip" title="<?php echo $button_save; ?>"
                        class="btn btn-primary submit"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
                   class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-attribute"
                      class="form-horizontal">

                    <input type="hidden" name="product_rows" id="product_rows" value='1000'>
                    <input type="hidden" name="product_slice" id="product_slice" value='0'>

                    <div class="form-group required">
                        <label class="col-sm-2 control-label"><?php echo $entry_name; ?></label>
                        <div class="col-sm-10">
                            <?php foreach ($languages as $language) { ?>
                            <div class="input-group"><span class="input-group-addon"><img
                                            src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png"
                                            title="<?php echo $language['name']; ?>"/></span>
                                <input type="text"
                                       name="attribute_description[<?php echo $language['language_id']; ?>][name]"
                                       value="<?php echo isset($attribute_description[$language['language_id']]) ? $attribute_description[$language['language_id']]['name'] : ''; ?>"
                                       placeholder="<?php echo $entry_name; ?>" class="form-control"/>
                            </div>
                            <?php if (isset($error_name[$language['language_id']])) { ?>
                            <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                            <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="input-attribute-group"><?php echo $entry_attribute_group; ?></label>
                        <div class="col-sm-10">
                            <select name="attribute_group_id" id="input-attribute-group" class="form-control">
                                <option value="0"></option>
                                <?php foreach ($attribute_groups as $attribute_group) { ?>
                                <?php if ($attribute_group['attribute_group_id'] == $attribute_group_id) { ?>
                                <option value="<?php echo $attribute_group['attribute_group_id']; ?>"
                                        selected="selected"><?php echo $attribute_group['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $attribute_group['attribute_group_id']; ?>"><?php echo $attribute_group['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <?php if ($error_attribute_group) { ?>
                            <div class="text-danger"><?php echo $error_attribute_group; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="sort_order" value="<?php echo $sort_order; ?>"
                                   placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order"
                                   class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-10 control-label">Заполнить пустышки русскими значениями <span
                                    class="count"></span></label>
                        <div class="col-sm-2">
                            <a href="javascript:;" data-toggle="tooltip" title="проставить для Укр - Рус значения"
                               class="btn btn-default upload_values"><i class="fa fa-download"
                                                                        aria-hidden="true"></i></a>
                            <a   title="Обновить атрибуты" id="update_attribute"
                                class="btn btn-warning update_attribute"><i class="fa fa-retweet"
                                                           aria-hidden="true"></i></a>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php $count = 1; ?>
                        <?php foreach($attribute_values as $key => $value){ ?>
                        <label class="col-sm-2 control-label">[<?php echo $count++; ?>] Значение<br>(для удаления -
                            пустое поле)</label>
                        <div class="col-sm-9" style="margin-bottom: 15px;">
                            <?php $none = false; ?>
                            <?php $name = ''; ?>
                            <?php foreach($languages as $language){ ?>
                            <div class="input-group"><span class="input-group-addon"><img
                                            src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png"
                                            title="<?php echo $language['name']; ?>"/></span>
                                <input type="text"
                                       name="attribute_value[<?php echo $key; ?>][<?php echo $language['language_id']; ?>]"
                                       data-key="<?php echo $key; ?>"
                                       data-lang="<?php echo $language['language_id']; ?>"
                                       value="<?php echo $value[$language['language_id']] ? $value[$language['language_id']] : ''; ?>"
                                       class="form-control"/>
                            </div>
                            <?php if(!isset($value[$language['language_id']])) $value[$language['language_id']] = ''; ?>
                            <?php if($name == $value[$language['language_id']]) $none = true; ?>
                            <?php $name = $value[$language['language_id']]; ?>
                            <?php } ?>
                        </div>

                        <?php if($none){ ?>
                        <label class="col-sm-1 control-label text-center" style="background-color: #FF8989;">!</label>
                        <?php }else{ ?>
                        <label class="col-sm-1 control-label"></label>
                        <?php } ?>
                        <?php } ?>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .counter {
        display: none;
    }
</style>
<script>


    $(document).on('click', '.upload_values', function () {
        var count = 1;

        $("input").each(function (index) {
            var name = $(this).attr('name');

            if (name.indexOf('attribute_value') + 1) {
                var key = $(this).data('key');
                var rus = $('input[name="attribute_value[' + key + '][1]"]').val();
                var ukr = $('input[name="attribute_value[' + key + '][3]"]').val();

                if (rus == '' && ukr != '') {
                    rus = ukr;
                } else if (ukr == '' && rus != '') {
                    ukr = rus;
                }

                $('.count').html(count);
                count = count + 1;

                $('input[name="attribute_value[' + key + '][1]"]').val(rus);
                $('input[name="attribute_value[' + key + '][3]"]').val(ukr);
            }
        });
    });


    $(document).on('click', '.submit', function () {
        $('.counter').html('Starting...');
        $('.counter').show();
   //     check_values(); //new
        reset_values();
     //   location.reload();
    });

    function reset_values() {
        var slice = $('#product_slice').val();
 //       let countes = 0; //new
        $.ajax({
            url: '/admin/index.php?route=catalog/attribute/edit&token=<?php echo $_GET['token']; ?>&attribute_id=<?php echo $_GET['attribute_id']; ?>&json=true',
            type: 'post',
            data: $('#form-attribute').serialize(),
            dataType: 'json',
            success: function (json) {
                 console.log(json);

                $('.counter').html(json['END'] + ' / ' + json['total']);
                $('#product_slice').val(json['slice']);

                if (json['END'] != 'END') {
                    setTimeout(function (){reset_values()}, 100);
                }
                // if (json['END'] == (json['total'] / 10)){  //new-->
                //     check_values();
                // }else if (json['END'] == (json['total'] / 5)){
                //     check_values();
                // }else if (json['END'] == (json['total'] / 2)){
                //     check_values();
                // }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + " " + xhr.statusText + " " + xhr.responseText);
                setTimeout(function (){reset_values()}, 3000);
            }
        });
    }

    function check_values() {
        var count = 1;

        $("input").each(function (index) {
            var name = $(this).attr('name');

            if (name.indexOf('attribute_value') + 1) {
                var key = $(this).data('key');
                var rus = $('input[name="attribute_value[' + key + '][1]"]').val();
                var ukr = $('input[name="attribute_value[' + key + '][3]"]').val();

                if (rus == '' && ukr != '') {
                    rus = ukr;
                } else if (ukr == '' && rus != '') {
                    ukr = rus;
                }
                $('.count').html(count);
                count = count + 1;

                $('input[name="attribute_value[' + key + '][1]"]').val(rus);
                $('input[name="attribute_value[' + key + '][3]"]').val(ukr);

                console.log('check_values');
            }
        });
    }

    $("input").on("focus", function () {
        var count = 1;
        var name = $(this).attr('name');

        if (name.indexOf('attribute_value') + 1) {
            var key = $(this).data('key');
            var rus = $('input[name="attribute_value[' + key + '][1]"]').val();
            var ukr = $('input[name="attribute_value[' + key + '][3]"]').val();

            if ((ukr === '' && rus !== '') || (ukr !== rus)) {
                ukr = rus;
            }
            $('.count').html(count);
            count = count + 1;
            $('input[name="attribute_value[' + key + '][1]"]').val(rus);
            $('input[name="attribute_value[' + key + '][3]"]').val(ukr);
            console.log('What a F...K ');
        }
    });

    function del_atr(){
        $.ajax({
            url: '/admin/index.php?route=catalog/attribute/removingNonProductSpecificAttribute&token=<?php echo $_GET['token']; ?>',
            type: 'post',
            dataType: 'json',
            success: function (data) {
                console.log(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                 console.log(thrownError + " " + xhr.statusText + " " + xhr.responseText);
            }
        });
    }

    $(document).on('click', '.update_attribute', function () {
        check_values();
        del_atr();
    });

</script>

<?php echo $footer; ?>
