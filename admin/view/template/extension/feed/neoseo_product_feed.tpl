<?php echo $header; ?><?php echo $column_left; ?>

<?php
require_once(DIR_SYSTEM . '/engine/neoseo_view.php' );
$widgets = new NeoSeoWidgets('neoseo_product_feed_',$params);
$widgets->text_select_all = $text_select_all;
$widgets->text_unselect_all = $text_unselect_all;
?>

    <div id="content">

        <div class="page-header">
            <div class="container-fluid">
                <div class="pull-right">
                    <?php if( !isset($license_error) ) { ?>
                        <button type="submit" name="action" value="save" form="form" data-toggle="tooltip"
                                title="<?php echo $button_save; ?>" class="btn btn-primary"><i
                                    class="fa fa-save"></i> <?php echo $button_save; ?></button>
                        <button type="submit" name="action" value="save_and_close" form="form" data-toggle="tooltip"
                                title="<?php echo $button_save_and_close; ?>" class="btn btn-default"><i
                                    class="fa fa-save"></i> <?php echo $button_save_and_close; ?></button>
                    <?php } else { ?>
                        <a href="<?php echo $recheck; ?>" data-toggle="tooltip" title="<?php echo $button_recheck; ?>"
                           class="btn btn-primary"/><i class="fa fa-check"></i> <?php echo $button_recheck; ?></a>
                    <?php } ?>
                    <a href="<?php echo $close; ?>" data-toggle="tooltip" title="<?php echo $button_close; ?>"
                       class="btn btn-default"><i class="fa fa-close"></i> <?php echo $button_close; ?></a>
                </div>
                <img width="36" height="36" style="float:left" src="view/image/neoseo.png" alt=""/>
                <h1><?php echo $heading_title_raw . " " . $text_module_version; ?></h1>
                <ul class="breadcrumb">
                    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <div class="container-fluid">
            <?php if ($error_warning) { ?>
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php } ?>
            <?php if (isset($success) && $success) { ?>
                <div class="alert alert-success">
                    <i class="fa fa-check-circle"></i>
                    <?php echo $success; ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php } ?>
            <div class="panel panel-default">
                <div class="panel-body">

                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
                        <?php if( !isset($license_error) ) { ?>
                            <li id="title_tab_feeds"><a id="href_tab_feeds" href="#tab-feeds"
                                                        data-toggle="tab"><?php echo $tab_feeds; ?></a></li>
                        <?php } ?>
                        <?php if( !isset($license_error) ) { ?>
                            <li id="title_tab_formats"><a id="href_tab_formats" href="#tab-formats"
                                                          data-toggle="tab"><?php echo $tab_formats; ?></a></li>
                        <?php } ?>
                        <?php if( !isset($license_error) ) { ?>
                            <li><a href="#tab-fields" data-toggle="tab"><?php echo $tab_fields; ?></a></li>
                        <?php } ?>
                        <?php if( !isset($license_error) ) { ?>
                            <li><a href="#tab-logs" data-toggle="tab"><?php echo $tab_logs; ?></a></li>
                        <?php } ?>
                        <li><a href="#tab-support" data-toggle="tab"><?php echo $tab_support; ?></a></li>
                        <li><a href="#tab-license" data-toggle="tab"><?php echo $tab_license; ?></a></li>
                    </ul>

                    <form action="<?php echo $save; ?>" method="post" enctype="multipart/form-data" id="form">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-general">
                                <?php if( !isset($license_error) ) { ?>

                                    <?php $widgets->dropdown('status',array( 0 => $text_disabled, 1 => $text_enabled)); ?>
                                    <?php $widgets->dropdown('type',array( 0 => $text_link, 1 => $text_cron)); ?>
                                    <?php $widgets->text('cron'); ?>

                                <?php } else { ?>

                                    <?php echo $license_error; ?>

                                <?php } ?>
                            </div>


                            <?php if (!isset($license_error)) { ?>
                                <div class="tab-pane" id="tab-feeds">
                                    <div class="table-responsive">
                                        <div class="form-group pull-right">
                                            <a href="<?php echo $add; ?>" data-toggle="tooltip"
                                               title="<?php echo $button_add; ?>" class="btn btn-primary"><i
                                                        class="fa fa-plus"></i></a>
                                        </div>
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <td class="text-center"><?php echo $entry_feed_name; ?></td>
                                                <td class="text-center"><?php echo $entry_feed_format_name; ?></td>
                                                <td class="text-center"><?php echo $entry_feed_status; ?></td>
                                                <td class="text-center"><?php echo $entry_feed_demand; ?></td>
                                                <td class="text-center"><?php echo $entry_generate; ?></td>
                                                <td class="text-center"><?php echo $entry_feed_action; ?></td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if (isset($feeds)) { ?>
                                                <?php foreach ($feeds as $feed) { ?>
                                                    <tr>
                                                        <td class="text-left"><?php echo $feed['feed_name']; ?></td>
                                                        <td class="text-left"><?php echo (isset($array_formats[$feed['id_format']])) ? $array_formats[$feed['id_format']] : ''; ?></td>
                                                        <td class="text-left"><?php echo ($feed['status'] == 1) ? 'Включено' : 'Отключено'; ?></td>
                                                        <td class="text-left">
                                                            <a target="_blank" class="by_demand"
                                                               href="<?php echo $feed['feed_demand']; ?>"><?php echo $feed['feed_demand']; ?></a>
                                                            <div class="by_cron">
                                                                <?php if( isset($feed['feed_cron_date']) ) { ?>
                                                                    <p><a target="_blank"
                                                                          href="<?php echo $feed['feed_cron']; ?>"><?php echo $feed['feed_cron']; ?></a>
                                                                    </p>
                                                                    <p style="color:green">Последнее
                                                                        изменение: <?php echo $feed['feed_cron_date']; ?></p>
                                                                <?php } else { ?>
                                                                    <p><?php echo $feed['feed_cron']; ?></p>
                                                                    <p style="color:red">файл еще не создан</p>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <a onclick="generate('#progress-<?php echo $feed['product_feed_id']; ?>', <?php echo $feed['image_width']; ?> , <?php echo $feed['image_height']; ?> ); return false;"
                                                               title="<?php echo $button_generate; ?>" class="btn btn-primary"><i
                                                                        class="fa fa-cog"></i> <?php echo $button_generate; ?></a>
                                                            <div id="progress-<?php echo $feed['product_feed_id']; ?>" class="progress" style="margin-top:20px; display:none">
                                                                <div class="progress-bar progress-bar-success progress-bar-striped"
                                                                     role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                                     aria-valuemax="100" style="width:0%">0%
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="<?php echo $feed['edit']; ?>" data-toggle="tooltip"
                                                               title="<?php echo $button_edit; ?>" class="btn btn-primary"><i
                                                                        class="fa fa-pencil"></i></a>
                                                            <a onclick="deleteItem('<?php echo $feed['delete']; ?>')"
                                                               data-toggle="tooltip" title="<?php echo $button_delete; ?>"
                                                               class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td class="text-center" colspan="9"><?php echo $text_no_results; ?></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                                        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if (!isset($license_error)) { ?>
                                <div class="tab-pane" id="tab-formats">
                                    <div class="table-responsive">
                                        <div class="form-group pull-right">
                                            <a href="<?php echo $add_formats; ?>" data-toggle="tooltip"
                                               title="<?php echo $button_add; ?>" class="btn btn-primary"><i
                                                        class="fa fa-plus"></i></a>
                                        </div>
                                        <table class="table table-bordered table-hover table-condensed">
                                            <thead>
                                            <tr>
                                                <td class="text-center"><?php echo $entry_feed_format_name; ?></td>
                                                <td class="text-center"><?php echo $entry_format_xml; ?></td>
                                                <td class="text-center"><?php echo $entry_feed_action; ?></td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if ($list_formats) { ?>
                                                <?php foreach ($list_formats as $format) { ?>
                                                    <tr>
                                                        <td class="text-left"
                                                            style="width: 289px;"><?php echo $format['feed_format_name']; ?></td>
                                                        <td class="text-left">
                                                            <pre style="padding: 0; height:200px; width: 600px; overflow:auto;"><?php echo $format['format_xml']; ?></pre>
                                                        </td>
                                                        <td class="text-center" style="width: 150px;">
                                                            <a href="<?php echo $format['edit']; ?>" data-toggle="tooltip"
                                                               title="<?php echo $button_edit; ?>" class="btn btn-primary"><i
                                                                        class="fa fa-pencil"></i></a>
                                                            <a onclick="deleteItem('<?php echo $format['delete']; ?>')"
                                                               data-toggle="tooltip" title="<?php echo $button_delete; ?>"
                                                               class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td class="text-center" colspan="9"><?php echo $text_no_results; ?></td>
                                                </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 text-left"><?php echo $pagination_formats; ?></div>
                                        <div class="col-sm-6 text-right"><?php echo $results_formats; ?></div>
                                    </div>

                                </div>
                            <?php } ?>

                            <?php if( !isset($license_error) ) { ?>
                                <div class="tab-pane" id="tab-fields">
                                    <table class="table table-bordered table-hover" id="items-table" width="50%">
                                        <thead>
                                        <tr>
                                            <td width="200px" class="left"><?php echo $entry_field_list_name; ?></td>
                                            <td><?php echo $entry_field_list_desc; ?></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach( $fields as $field_name => $field_desc ) { ?>
                                            <tr>
                                                <td class="left">{<?php echo $field_name ?>}</td>
                                                <td><?php echo $field_desc ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>

                            <?php if( !isset($license_error) ) { ?>
                                <div class="tab-pane" id="tab-logs">
                                    <?php $widgets->debug_download_logs('debug',array( 0 => $text_disabled, 1 => $text_enabled), $clear, $download, $button_clear_log, $button_download_log); ?>
                                    <textarea style="width: 100%; height: 300px; padding: 5px; border: 1px solid #CCCCCC; background: #FFFFFF; overflow: scroll;"><?php echo $logs; ?></textarea>
                                </div>
                            <?php } ?>

                            <div class="tab-pane" id="tab-support">
                                <?php echo $mail_support; ?>
                            </div>

                            <div class="tab-pane" id="tab-license">
                                <?php echo $module_licence; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        if (window.location.hash.indexOf('#tab') == 0 && $("[href=" + window.location.hash + "]").length) {
            $(".panel-body > .nav-tabs li").removeClass("active");
            $("[href=" + window.location.hash + "]").parents('li').addClass("active");
            $(".panel-body:first .tab-content:first .tab-pane:first").removeClass("active");
            $(window.location.hash).addClass("active");
        }
        $(".nav-tabs li a").click(function () {
            var url = $(this).prop('href');
            window.location.hash = url.substring(url.indexOf('#'));
        });
        // Специальный фикс системной функции, поскольку даниель понятия не имеет о том что в url может быть еще и hash
        // и по итогу этот hash становится частью token
        function getURLVar(key) {
            var value = [];

            var url = String(document.location);
            if (url.indexOf('#') != -1) {
                url = url.substring(0, url.indexOf('#'));
            }
            var query = url.split('?');

            if (query[1]) {
                var part = query[1].split('&');

                for (i = 0; i < part.length; i++) {
                    var data = part[i].split('=');

                    if (data[0] && data[1]) {
                        value[data[0]] = data[1];
                    }
                }

                if (value[key]) {
                    return value[key];
                } else {
                    return '';
                }
            }
        }

    </script>
    <script type="text/javascript"><!--
        function deleteItem(href) {
            if(confirm('Удалить?')){
                location = href;
            }else{
                return false;
            }
        }

        <?php
        if (!isset($license_error)) {
        ?>
        $("#neoseo_product_feed_type").change(function () {

            if (Number($(this).val()) == 1) {
                $("#field_cron").show();
                $(".by_demand").hide();
                $(".by_cron").show();
            } else {
                $("#field_cron").hide();
                $(".by_demand").show();
                $(".by_cron").hide();
            }
        });
        $("#neoseo_product_feed_type").trigger("change");

        var products = <?php echo json_encode($ids); ?>;
        var productsCurrent = [];
        var generateProgressId = 0;
        var generateWidth = 600;
        var generateHeight = 600;

        function generateNext() {
            var product = productsCurrent.shift();
            if (!product) {
                $(generateProgressId).hide();
                return;
            }
            var index = products.length - productsCurrent.length;
            var total = products.length;
            var percent = Number(index * 100 / total).toFixed(0);
            $(generateProgressId + " .progress-bar").prop("aria-valuenow", percent);
            $(generateProgressId + " .progress-bar").css("width", percent + "%");
            $(generateProgressId + " .progress-bar").html(index + " из " + total);
            $.ajax({
                url: '<?php echo str_replace("&amp;", "&", $generate_url); ?>',
                data: {id: product, width: generateWidth, height: generateHeight},
                dataType: 'json'
            }).done(function () {
                generateNext();
            });
        }

        function generate(progressId, width, height) {
            productsCurrent = products.slice(0);
            generateProgressId = progressId;
            generateWidth = width;
            generateHeight = height;
            $(generateProgressId).show();
            generateNext();
        }
	
        function updateProductFeed(feed_id){
	
            token = '<?php echo $token; ?>';
	
            $.ajax({
                url: 'index.php?route=feed/neoseo_product_feed/updateProductFeedCategories&token='+token,
                type: 'post',
                data: 'feed_id=' + feed_id,
                dataType: 'json',
                success: function (json) {
                    $('.alert').remove();

                    if (json['error']) {
                        $('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                    }

                    if (json['success']) {
                        $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                    }
                },
                error: function (request, status, error) {
                    alert(request.responseText);
                }
            });
        }
        <?php } ?>

        //--></script>
    <script type="text/javascript">
        if (window.location.hash.indexOf('#tab') == 0 && $("[href=" + window.location.hash + "]").length) {
            $(".panel-body > .nav-tabs li").removeClass("active");
            $("[href=" + window.location.hash + "]").parents('li').addClass("active");
            $(".panel-body:first .tab-content:first .tab-pane:first").removeClass("active");
            $(window.location.hash).addClass("active");
        }
        $(".nav-tabs li a").click(function () {
            var url = $(this).prop('href');
            window.location.hash = url.substring(url.indexOf('#'));
        });
    </script>
<?php echo $footer; ?>