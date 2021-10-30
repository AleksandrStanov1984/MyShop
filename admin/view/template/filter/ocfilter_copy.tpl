<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <h1><?php echo $heading_title; ?></h1>
        </div>
    </div>

    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <?php if ($success) { ?>
        <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <form action="" method="post" enctype="multipart/form-data" id="form-ocfilter" class="form-horizontal">
                    <div role="tabs">
                        <div class="tab-content">
                            <div id="tab-copy" class="tab-pane active">

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-category"><?php echo $entry_category; ?></label>
                                    <div class="col-sm-10">
                                        <div class="well well-sm" style="min-height: 150px;max-height: 500px;overflow: auto;">
                                                <?php foreach ($options as $option) { ?>
                                                <div class="checkbox">
                                                        <label>
                                                               <input type="radio" name="option_id" value="<?php echo $option['option_id']; ?>" />
                                                            <?php echo $option['name']; ?> (<?php echo $option['option_id']; ?>)
                                                        </label>
                                                    </div>
                                                <?php } ?>
                                        </div>
                                        </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-category"><?php echo $entry_attribute; ?></label>
                                    <div class="col-sm-10">
                                        <div class="well well-sm" style="min-height: 150px;max-height: 500px;overflow: auto;">
                                            <?php foreach ($attributes as $attribute) { ?>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="radio" name="attribute" value="<?php echo $attribute['attribute_id']; ?>" />
                                                    <?php echo $attribute['name']; ?> (<?php echo $attribute['attribute_id']; ?>)
                                                </label>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>


                               <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                               <button type="button" class="btn btn-lg btn-primary" id="button-copy-filter" data-loading-text="<?php echo $text_loading; ?>" data-complete-text="<?php echo $text_complete; ?>"><i class="fa fa-copy"></i> <?php echo $button_copy; ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    $(function () {
        $('[data-toggle="trigger"][onclick]').trigger('click');
    });

    var timer;

    $('#button-copy-filter').on('click', function (e) {
        clearTimeout(timer);

        $('#tab-copy > .alert').remove();

        var button = $(this).button('loading');

        $.post('index.php?route=filter/ocfilter/copyFilters&token=<?php echo $token; ?>', $('#form-ocfilter').serialize(), function (response) {
            if (response['error']) {
                button.button('reset');

                $('#tab-copy').prepend('<div class="alert alert-danger" role="alert">' + response['error'] + '</div>');
            }

            if (response['success']) {
                button.button('complete');

                $('#tab-copy').prepend('<div class="alert alert-success" role="alert">' + response['success'] + '</div>');

                timer = setTimeout(function () {
                    button.button('reset');
                }, 10 * 1000);
            }
        }, 'json');
    });
    //--></script>
<?php echo $footer; ?>