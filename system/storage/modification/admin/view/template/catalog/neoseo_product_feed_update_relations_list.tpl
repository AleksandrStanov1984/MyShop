<?php echo $header; ?><?php echo $column_left; ?>
    <div id="content">
        <div class="page-header">
            <div class="container-fluid">
                <img width="36" height="36" style="float:left" src="view/image/neoseo.png" alt=""/>
                <h1><?php echo $heading_title . " " . $text_module_version  . " " .$heading_title_raw; ?></h1>
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
                <div class="panel-heading" style="height: 56px;">
                    <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
                    <div class="form-group pull-right" style="padding-top: 0px;">
                        <div class="col-sm-2">
                            <label class="control-label" for="input-feed-name" style="padding-top: 10px;"><?php echo $entry_feed;?></label> </div>
                        <div class="col-sm-10">
                            <select name="product_feed_id" style='width: 350px' class="form-control">
                                <?php foreach ($listFeeds as $feed_id => $feed) { ?>
                                    <option value="<?php echo $feed_id; ?>"  <?php if($activeFeed['product_feed_id']==$feed_id) echo 'selected="selected"'; ?>><?php echo $feed['feed_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <?php if(count($listFeeds)>0) { ?>
                    <div class='well'>
                        <div class="row text-right">
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <label class="control-label"> <?php echo $entry_update_all; ?></label>
                                </div>
                            </div>
                            <div class="col-sm-5" style="padding-left: 50px;">
                                <div class="form-group">
                                    <select name="all_feed_category_id" id="input-status" style='width: 340px' class="form-control">
                                        <option value="0"><?php echo $text_none;?></option>
                                        <?php foreach($feedCategories as $category) { ?>
                                            <option value="<?php echo $category['category_id'] ?>" ><?php echo $category['name'] ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="well">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                                    <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="input-price"><?php echo $entry_price; ?></label>
                                    <input type="text" name="filter_price" value="<?php echo $filter_price; ?>" placeholder="<?php echo $entry_price; ?>" id="input-price" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="input-status"><?php echo $column_category; ?></label>
                                    <select name="filter_category" id="input-status" class="form-control">
                                        <option value="*"></option>
                                        <?php foreach ($categories as $category) { ?>
                                            <?php if ($category['category_id']==$filter_category) { ?>
                                                <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                            <?php } else { ?>
                                                <option value="<?php echo $category['category_id']; ?>">&nbsp;&nbsp;<?php echo $category['name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
                            </div>
                        </div>
                    </div>

                    <form action="<?php echo $action?>" method="post" enctype="multipart/form-data" id="form-product">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked).trigger('change');" /></td>
                                    <td class="text-center"><?php echo $column_image; ?></td>
                                    <td class="text-left"><?php if ($sort == 'pd.name') { ?>
                                            <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                                        <?php } else { ?>
                                            <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                                        <?php } ?></td>
                                    <td class="text-right"><?php if ($sort == 'p.price') { ?>
                                            <a href="<?php echo $sort_price; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_price; ?></a>
                                        <?php } else { ?>
                                            <a href="<?php echo $sort_price; ?>"><?php echo $column_price; ?></a>
                                        <?php } ?></td>
                                    <td class="text-center"><?php echo $column_category; ?></td>
                                    <td class="center">
                                        <?php echo $column_feed_category.' '.$activeFeed['feed_name']; ?>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($products) { ?>
                                    <?php foreach ($products as $product) { ?>
                                        <tr>
                                            <td class="text-center"><?php if (in_array($product['product_id'], $selected)) { ?>
                                                    <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" checked="checked" />
                                                <?php } else { ?>
                                                    <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" />
                                                <?php } ?></td>
                                            <td class="text-center"><?php if ($product['image']) { ?>
                                                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="img-thumbnail" />
                                                <?php } else { ?>
                                                    <span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span>
                                                <?php } ?></td>
                                            <td class="text-left"><?php echo $product['name']; ?></td>
                                            <td class="text-right"><?php echo $product['price']; ?></td>
                                            <td class="text-center">
                                                <?php foreach ($categories as $category) { ?>
                                                    <?php if (in_array($category['category_id'], $product['category'])) { ?>
                                                        <?php echo $category['name'];?><br>
                                                    <?php } ?>
                                                <?php } ?></td>
                                            <td class="text-center">
                                                <select name="feed_category_id" style="width: 350px;" onchange="updateProductToFeedCategory($(this).val(), <?php echo $product['product_id']; ?> )" class="form-control">
                                                    <option value="0"><?php echo $text_none;?></option>
                                                    <?php foreach($feedCategories as $category) { ?>
                                                        <option value="<?php echo $category['category_id'] ?>" <?php if($product['feed_category_id'] == $category['category_id']) echo 'selected="selected"'; ?>><?php echo $category['name'] ?></option>
                                                    <?php }?>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
                    </div>
                </div>
                <?php } else { ?>
                    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_empty_feed; ?></div>
                <?php } ?>
            </div>
        </div>
        <?php if(count($listFeeds)>0) { ?>
            <script type="text/javascript"><!--
                $('#button-filter').on('click', function() {
                    var url = 'index.php?route=catalog/neoseo_product_feed_update_relations&token=<?php echo $token; ?>';
                    var filter_name = $('input[name=\'filter_name\']').val();
                    if (filter_name) {
                        url += '&filter_name=' + encodeURIComponent(filter_name);
                    }

                    var filter_price = $('input[name=\'filter_price\']').val();
                    if (filter_price) {
                        url += '&filter_price=' + encodeURIComponent(filter_price);
                    }

                    var filter_category = $('select[name=\'filter_category\']').val();
                    if (filter_category != '*') {
                        url += '&filter_category=' + encodeURIComponent(filter_category);
                    }
                    url += '&feed_id=' + encodeURIComponent($('select[name=\product_feed_id\]').val());
       
                    location = url;
                });
//--></script>
            <script type="text/javascript"><!--
                $('input[name=\'filter_name\']').autocomplete({
                    'source': function(request, response) {
                        $.ajax({
                            url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
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
                        $('input[name=\'filter_name\']').val(item['label']);
                    }
                });
//--></script>
            <script>
                $('select[name=\product_feed_id\]').bind("change", function() {
                    var form_attr = $('#form-product').attr('action');
                    $('#form-product').attr('action',form_attr+'&feed_id='+$(this).val());
                    $('#form-product').submit();
                });
                $('select[name=\all_feed_category_id\]').bind("change", function() {
                    var products_id = [];
                    $("input[name^='selected']").each(function() {
                        if ($(this).is(':checked')) {
                            products_id.push($(this).val());
                        }
                    });
                    updateProductToFeedCategory($(this).val(), products_id)
                });

                function updateProductToFeedCategory(category_id, product_id) {
                    $.ajax({
                        url: 'index.php?route=catalog/neoseo_product_feed_update_relations/updateProductToFeedCategory&token=<?php echo $token; ?>',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            'category_id': category_id,
                            'feed_id': <?php echo $activeFeed['product_feed_id'] ?>,
                            'products_id': product_id
                        },
                        success: function(json) {
                            $('.alert').remove();
                            if (json['error']) {
                                $('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                            }

                            if (json['success']) {
                                location.reload();
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
            </script>
        <?php } ?>
    </div>
<?php echo $footer; ?>