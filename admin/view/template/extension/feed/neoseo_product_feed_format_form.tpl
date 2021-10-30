<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-attribute" data-toggle="tooltip" title="<?php echo $button_save; ?>"
                        class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
                   class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <img width="36" height="36" style="float:left" src="view/image/neoseo.png" alt="">
            <h1><?php echo $heading_title_raw; ?></h1>
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-attribute"
                      class="form-horizontal">

                    <div class="form-group">
                        <label class="col-sm-2"><?php echo $entry_feed_format_name; ?></label>
                        <div class="col-sm-10">
                            <input name="format[feed_format_name]" class="form-control"
                                   value="<?php echo $format['feed_format_name']?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2"><?php echo $entry_format_xml; ?></label>
                        <div class="col-sm-10">
                            <textarea name="format[format_xml]" class="form-control"
                                      rows='20'><?php echo $format['format_xml'];?></textarea>
                        </div>
                    </div>

                    <input type="hidden"
                           name="<?php echo isset($format['product_feed_format_id'])? 'format[product_feed_format_id]': '';?>"
                           value="<?php echo isset($format['product_feed_format_id'])?$format['product_feed_format_id']: '';?>"/>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>
