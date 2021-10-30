<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <h1><?php echo $category_mgr_heading_title; ?></h1>
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
        <div id="main-panel" class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $category_mgr_heading_title; ?></h3>
            </div>
            <div class="panel-body">
                <div class="container-fluid">
                    <div id="left-pane" style="float: left; width: 354px; height: 100%; margin-right: 10px;">
                        <div id="left-pane-toolbar" style="height: 40px; width: 100%; padding-right: 6px;">
                            <button id="btnCategoryView" onclick="onCategoryView(); return false;" type="button" data-toggle="tooltip" class="btn btn-sm btn-default" title="<?php echo $button_category_view; ?>"><i class="fa fa-shopping-cart""></i></button>
                            <button onclick="daemifkq(); return false;" type="button" data-toggle="tooltip" title="<?php echo $button_category_add; ?>" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button>
                            <button id="zggjlw" onclick="hxfbyjqw(); return false;" type="button" data-toggle="tooltip" class="btn btn-sm btn-primary" title="<?php echo $button_category_edit; ?>"><i class="fa fa-pencil"></i></button>
                            <button id="hokffmsz" onclick="vuefpy(); return false;" type="button" data-toggle="tooltip" class="btn btn-sm btn-default" title="<?php echo $button_category_copy; ?>"><i class="fa fa-copy"></i></button>
                            <button id="fqnobj" onclick="$('#importCategoriesListModal').modal('show'); return false;" type="button" data-toggle="tooltip" class="btn btn-sm btn-default" title="<?php echo $text_create_categories_from_list; ?>"><i class="fa fa-list"></i></button>
                            <button id="upufusyh" type="button" data-toggle="tooltip" style="margin-left:10px;" title="<?php echo $button_category_delete; ?>" class="btn btn-sm btn-danger" onclick="confirm('<?php echo $text_confirm_delete_category; ?>') ? oesdfy() : false;"><i class="fa fa-trash-o"></i></button>
                            <button id="xdvihy" onclick="cokvvbaz(); return false;" type="button" style="margin-left:10px;" data-toggle="tooltip" title="<?php echo $button_category_enable; ?>" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button>
                            <button id="ggavbuxs" onclick="msrpee(); return false;" type="button" data-toggle="tooltip" title="<?php echo $button_category_disable; ?>" class="btn btn-sm btn-success"><i class="fa fa-eye-slash"></i></button>
                            <button onclick="ohxuhu(); return false;" type="button" style="float: right;" data-toggle="tooltip" class="btn btn-sm btn-primary" title="<?php echo $button_category_collapse; ?>"><i class="fa fa-angle-double-up"></i></button>
                            <button onclick="iyjpiemb(); return false;" type="button" style="float: right; margin-right: 6px;" data-toggle="tooltip" class="btn btn-sm btn-primary" title="<?php echo $button_category_expand; ?>"><i class="fa fa-angle-double-down"></i></button>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class = "col-lg-12">
                                <div class="input-group input-group-sm">
                                    <input class="form-control" type="text" id="search-category"/>
                            <span class = "input-group-btn">
                                <button id="btnCategorySearch" onclick="$('#jstree').jstree(true).search($('#search-category').val()); return false;" type="button" data-toggle="tooltip" class="btn btn-sm btn-default" title="<?php echo $button_category_search; ?>"><i class="fa fa-search"></i></button>
                                <button id="btnCategoryFilter" type="button" data-toggle="dropdown" class="btn btn-default btn-sm dropdown-toggle" title="<?php echo $button_category_filter; ?>"><i class="fa fa-filter"></i></button>
                                <ul class="dropdown-menu">
                                    <li class="disabled"><a onclick="return false;" style="text-decoration: none;" class="large" href="#"><?php echo $text_menu_category_filter_header; ?></a></li>
                                    <?php foreach ($stores as $store) { ?>
                                    <li><a href="#" class="large" style="text-decoration: none;" data-value="<?php echo $store['id']; ?>" tabIndex="-1"><input type="checkbox"/>&nbsp;<?php echo $store['caption']; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </span>
                                </div>
                            </div>
                        </div>
                        <div style="overflow: auto; overflow-y: hidden;" id="jstree"></div>
                    </div>
                    <div id="products-list" style="overflow:hidden;">
                        <div id="products-toolbar" style="margin-left: 14px; margin-top: -1px;">
                            <button type="button" class="btn btn-warning" data-toggle="popover" title="Support" data-content="<?php echo $acm_support; ?>"><i class="fa fa-support"></i></button>
                            <div id="drag-drop-toolbar" style="float: left; margin-left: 20px; margin-right: 20px">
                                <button id="upffazqq" onclick="ezcvhj(); return false;" type="button" data-toggle="tooltip" title="<?php echo $text_button_toolbar_copy; ?>" class="btn btn-default"><?php echo $button_toolbar_copy; ?></button>
                                <button id="emhodz" onclick="egezdgig(); return false;" type="button" data-toggle="tooltip" title="<?php echo $text_button_toolbar_cut; ?>" class="btn btn-default"><?php echo $button_toolbar_cut; ?></button>
                                <button id="pmyclvfv" onclick="ncosfq(); return false;" type="button" data-toggle="tooltip" title="<?php echo $text_button_toolbar_paste; ?>" class="btn btn-default"><?php echo $button_toolbar_paste; ?></button>
                                <button id="fvados" onclick="bdqsqiqv(); return false;" type="button" data-toggle="tooltip" title="<?php echo $text_button_toolbar_cancel; ?>" class="btn btn-default"><?php echo $button_toolbar_cancel; ?></button>
                            </div>
                            <button onclick="fugrfvwl(); return false;" type="button" data-toggle="tooltip" class="btn btn-primary" title="<?php echo $button_product_add; ?>"><i class="fa fa-plus"></i></button>
                            <button id="unxmgv" onclick="yqugzmdw(); return false;" type="button" data-toggle="tooltip" class="btn btn-primary" title="<?php echo $button_product_edit; ?>"><i class="fa fa-pencil"></i></button>
                            <button id="xzkldajj" onclick="vzbtfvma(); return false;" data-toggle="tooltip" class="btn btn-default" title="<?php echo $button_products_copy; ?>"><i class="fa fa-copy"></i></button>
                            <button id="iwpibz" style="margin-left:5px;" onclick="fhqive(); return false;" data-toggle="tooltip" class="btn btn-default" title="<?php echo $button_products_clone_to_parent_category; ?>"><i class="fa fa-arrow-circle-up"></i></button>
                            <div style="margin-left:15px;" class="btn-group">
                                <button id="aykytuaz" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-external-link"></i>&nbsp;&nbsp;<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a style="text-decoration: none;" href="#" onclick="gpewmvay(0); return false;"><?php echo $button_products_remove_category; ?></a></li>
                                    <li><a style="text-decoration: none;" href="#" onclick="gpewmvay(1); return false;"><?php echo $button_products_remove_category_except; ?></a></li>
                                </ul>
                            </div>                            <button id="jcfhkn" onclick="diyeoq(); return false;" type="button" data-toggle="tooltip" class="btn btn-danger" title="<?php echo $button_product_delete; ?>"><i class="fa fa-trash-o"></i></button>
                            <button id="rsgfvpjx" onclick="xnooikdc(1); return false;" type="button" data-toggle="tooltip" style="margin-left:10px;" class="btn btn-success" title="<?php echo $button_product_enable; ?>"><i class="fa fa-eye"></i></button>
                            <button id="nrnygc" onclick="xnooikdc(0); return false;" type="button" data-toggle="tooltip" class="btn btn-success" title="<?php echo $button_product_disable; ?>"><i class="fa fa-eye-slash"></i></button>
                        </div>
                        <?php if ($new_version) { ?>
                        <div class="alert alert-info" role="alert"><?php echo $new_version; ?><a href="#" class="close" data-dismiss="alert">&times;</a></div>
                        <?php } ?>
                        <?php if ($ca_permissions) { ?>
                        <div class="alert alert-danger" role="alert"><?php echo $ca_permissions; ?><a href="#" class="close" data-dismiss="alert">&times;</a></div>
                        <?php } ?>
                        <?php if ($cm_permissions) { ?>
                        <div class="alert alert-warning" role="alert"><?php echo $cm_permissions; ?><a href="#" class="close" data-dismiss="alert">&times;</a></div>
                        <?php } ?>
                        <?php if ($pa_permissions) { ?>
                        <div class="alert alert-danger" role="alert"><?php echo $pa_permissions; ?><a href="#" class="close" data-dismiss="alert">&times;</a></div>
                        <?php } ?>
                        <?php if ($pm_permissions) { ?>
                        <div class="alert alert-warning" role="alert"><?php echo $pm_permissions; ?><a href="#" class="close" data-dismiss="alert">&times;</a></div>
                        <?php } ?>
                        <table id="products-table"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="importCategoriesListModal" tabindex="-1" role="dialog" aria-labelledby="importCategoriesListModalLabel" aria-hidden="true">
    <form id="import_subcategories_list_form" method="post" action="/import_cat_list">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo $txt_close; ?>"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="importCategoriesListModalLabel"><?php echo $text_create_categories_from_list; ?></h4>
                </div>
                <div class="modal-body">
                    <div id="parent_caption" class="form-group"></div>
                    <div class="form-group">
                        <label for="message-text" class="control-label"><?php echo $text_category; ?>:</label>
                        <textarea rows="25" class="form-control" id="categories-text"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $txt_close; ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo $button_create; ?></button>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript"><!--
const MIN_W = 320;
const MIN_H = 240;
var options = eval("<?php echo $show_stores_option; ?>");
window.shift_down = false;
window.drop_state = false;
window.toolbar_dd_mode = 0;
$(document).ready(function() {
    eval("<?php echo $smart_toolbar; ?>");
    options.forEach(function(value) {
        $('.dropdown-menu [data-value="'+value+'"]').find('input').prop('checked', true);
    });
    $('#btnCategoryFilter').tooltip();
    $.ajax({
        url: "view/javascript/category_mgr/libs/jquery-ui.min.js",
        async: false,
        dataType:"script"
    });
    $(document)
            .ajaxStart(function () {
                $("html").addClass('busy');
            })
            .ajaxStop(function () {
                $("html").removeClass('busy');
            });
    $(document).bind('keydown', function (event) {
        if (event.ctrlKey && window.drop_state) {
            if (!window.root_node) {
                $('tr').draggable( "option", "cursor", "crosshair" );
                $('body').css("cursor", "crosshair");
            }
            window.shift_down = true;
            stqkmz();
        }
    });
    $(document).bind('keyup', function (event) {
        if (!event.ctrlKey && window.drop_state) {
            $('tr').draggable( "option", "cursor", "pointer" );
            $('body').css("cursor", "pointer");
            window.shift_down = false;
            stqkmz();
        }
    });
    $(document).on('click.bs.toggle', 'div[data-toggle^=toggle]', function (e) {
        var div = $(this);
        var checkbox = $(this).find('input[type=checkbox]');
        var new_val = 1 - ($(checkbox).prop('checked') ? 1 : 0);
        var product_id = $(checkbox).data('product-id');
        $.ajax({
                    url:  'index.php?route=catalog/category_mgr/quick_edit&<?php echo $token; ?>',
                    cache:  false,
                    data:  { 'id': product_id, 'field': 'status', 'value': new_val},
                    type: 'POST',
                    fail: function () {
                        zcfbjgrw(true);
                    },
                    success: function (data) {
                        if (typeof data.ret != 'undefined') {
                            if (data.ret == 'fail')
                                zcfbjgrw(true);
                            else {
                                if (new_val) {
                                    div.removeClass("off");
                                    $(checkbox).prop("checked", true);
                                }
                                else {
                                    div.addClass("off");
                                    $(checkbox).prop("checked", false);
                                }
                                aztlme(product_id);
                            }
                        }
                    }
                }
        )
    });

    var input_to = false;
    var last_ks = '';

    $("#search-category").keyup(function() {
        if(input_to) {
            clearTimeout(input_to);
        }
        input_to = setTimeout(function () {
            var is = $("#search-category").val();
            if (is != last_ks) {
                last_ks = is;
                $('#jstree').jstree(true).search(is);
            }
        }, 499);
    });

    $('#importCategoriesListModal').on('show.bs.modal', function () {
        $('#parent_caption').empty();
        var selectedNode = $('#jstree').jstree(true).get_selected(false);
        if (selectedNode.length == 1 && selectedNode[0] != "0" )
            $('#parent_caption').html("<h4><?php echo $text_parent_category; ?>: "+$('#jstree').jstree(true).get_text(selectedNode)+"</h4>");
    }).
    on('shown.bs.modal', function () {
        $('#categories-text').focus();
    });
    $('[data-toggle="popover"]').popover({placement : 'bottom', container: 'body', html: true });

    $('#import_subcategories_list_form').on('submit', function(e){
        $('#category-warn').remove();
        e.preventDefault();
        var selectedNodes = $('#jstree').jstree(true).get_selected(false);
        var node = (selectedNodes.length == 1) ? node = selectedNodes[0] : 0;
        $.ajax({
            type:  'POST',
            cache:  false ,
            url:  'index.php?route=catalog/category_mgr/import_categories_list&<?php echo $token; ?>',
            data:  { 'id': node, 'list': $('#categories-text').val()},
            success: function(data) {
                $('#importCategoriesListModal').modal('hide');
                if (typeof data.ret != 'undefined') {
                    if (data.ret == 'fail') {
                        alert('<?php echo $category_mgr_error_modify_permission; ?>');
                    } else
                    {
                        if (data.message != '')
                            $('#jstree').before('<div id="category-warn" class="alert alert-danger" role="alert"><a href="#" class="close" data-dismiss="alert">&times;</a>'+data.message+'</div>');
                        if (data.created > 0) {
                            $('#categories-text').val('');
                            $('#jstree').jstree("refresh");
                        }
                    }
                }
            }
        });
    });

    if (typeof($('#jstree').jstree) != 'function') {
        error = '<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $no_license; ?><button type="button" class="close" data-dismiss="alert">&times;</button></div>';
        $('#main-panel').prepend(error);
    }
    else
    $('#jstree')
            .jstree({
                'core' : {
                    'check_callback' : function(operation, node, node_parent, node_position, more) {
                        if (operation === 'move_node') {
                            if (node_parent.parent == null || "<?php echo $cm_permissions; ?>" != "") return false;
                            return true;
                        }
                        if (operation === 'rename_node' && node.id != 0 && "<?php echo $cm_permissions; ?>" == "") {
                            if (node.id) {
                                $.ajax({
                                    type:  'POST',
                                    cache:  false ,
                                    url:  'index.php?route=catalog/category_mgr/rename_category&<?php echo $token; ?>',
                                    data:  { 'id': node.id, 'val': node_position},
                                    success: function(data) {
                                        if (typeof data.ret != 'undefined') {
                                            if (data.ret == 'fail') {
                                                alert('<?php echo $category_mgr_error_modify_permission; ?>');
                                                return false;
                                            }
                                        }
                                    }
                                });
                                return true;
                            }
                        }
                        return false;
                    },
                    'force_text' : true,
                    'multiple' : true,
                    'data' : {
                        'url' : 'index.php?route=catalog/category_mgr/tree&<?php echo $token; ?>',
                        'data' : function (node) {
                            return { 'id' : node.id, 'operation' : 'get_node' };
                        },
                        "success": function (x) {
                            if (typeof x.ret != 'undefined') {
                                if (x.ret == 'fail') alert('<?php echo $category_mgr_error_access_permission; ?>');
                            }
                        }
                    }},
                'plugins' : ['<?php echo $category_mgr_script; ?>','search','wholerow', 'contextmenu'],
                'search': {
                    'show_only_matches': true,
                    'show_only_matches_children' : true,
                    'ajax': {
                        'url': 'index.php?route=catalog/category_mgr/tree_search&<?php echo $token; ?>'
                    }
                },
                'contextmenu': {
                    'items': function ($node) {
                        var selectedNode = $('#jstree').jstree(true).get_selected(false);
                        if (!selectedNode.length) return { };

                        if (selectedNode.length > 1) {
                            return {
                                'DisableEmpty': {
                                    'label': '<?php echo $text_menu_disable_empty_catagories; ?>',
                                    'action': function () {
                                        agaxkdmu(1);
                                    }

                                },
                                'EnableNotEmpty': {
                                    'label': '<?php echo $text_menu_enable_not_empty_catagories; ?>',
                                    'action': function () {
                                        agaxkdmu(0);
                                    }

                                },
                                'Top': {
                                    'separator_after': true,
                                    '_disabled': $node.id == "0",
                                    'label': "<?php echo $text_top_menu; ?>",
                                    'action': false,
                                    'submenu' :{
                                        'enable_top_menu' : {
                                            "label" : "<?php echo strip_tags($text_enabled); ?>",
                                            'action': function () {
                                                rkihaeaf(true);
                                            }
                                        },
                                        'disable_top_menu' : {
                                            "label" : "<?php echo strip_tags($text_disabled); ?>",
                                            'action': function () {
                                                rkihaeaf(false);
                                            }
                                        }

                                    }
                                },
                                'Delete': {
                                    '_disabled': $node.id == "0",
                                    'shortcut': 46,
                                    'shortcut_label': 'delete',
                                    'label': '<?php echo $button_category_delete; ?>',
                                    'action': function () {
                                        confirm('<?php echo $text_confirm_delete_category; ?>') ? oesdfy() : false;
                                    }
                                }
                            }
                        };

                        return {
                            'View' : {
                                'label': '<?php echo $button_category_view; ?>',
                                'action': function () {
                                    onCategoryView();
                                }
                            },
                            'New': {
                                'separator_after': true,
                                'label': '<?php echo $button_category_add; ?>',
                                'action': function () {
                                    daemifkq();
                                }
                            },
                            'Import': {
                                'separator_after': true,
                                'label': '<?php echo $text_create_categories_from_list; ?>',
                                'action': function () {
                                    $('#importCategoriesListModal').modal('show');

                                }
                            },
                            'DisableEmpty': {
                                'label': '<?php echo $text_menu_disable_empty_catagories; ?>',
                                'action': function () {
                                    agaxkdmu(1);
                                }

                            },
                            'EnableNotEmpty': {
                                'separator_after': true,
                                'label': '<?php echo $text_menu_enable_not_empty_catagories; ?>',
                                'action': function () {
                                    agaxkdmu(0);
                                }

                            },
                            'Rename': {
                                '_disabled': ($node.id == "0" || "<?php echo $multiple_lang_warning; ?>" != "" || "<?php echo $cm_permissions; ?>" != ""),
                                'shortcut': 113,
                                'shortcut_label': 'F2',
                                'label': '<?php echo $button_category_rename; ?>',
                                'action': function () {
                                    $('#jstree').jstree('edit', $node);
                                }

                            },
                            'Edit': {
                                'separator_after': true,
                                '_disabled': $node.id == "0",
                                'label': '<?php echo $button_category_edit; ?>',
                                'action': function () {
                                    hxfbyjqw();
                                }
                            },
                            'Clone': {
                                'separator_after': true,
                                '_disabled': $node.id == "0",
                                'label': '<?php echo $button_category_copy; ?>',
                                'action': function () {
                                    vuefpy();
                                }
                            },
                            'Top': {
                                'separator_after': true,
                                '_disabled': $node.id == "0",
                                'label': "<?php echo $text_top_menu; ?>",
                                'action': false,
                                'submenu' :{
                                    'enable_top_menu' : {
                                        "label" : "<?php echo strip_tags($text_enabled); ?>",
                                        'action': function () {
                                            rkihaeaf(true);
                                        }
                                    },
                                    'disable_top_menu' : {
                                        "label" : "<?php echo strip_tags($text_disabled); ?>",
                                        'action': function () {
                                            rkihaeaf(false);
                                        }
                                    }

                                }
                            },
                            'Delete': {
                                '_disabled': $node.id == "0",
                                'shortcut': 46,
                                'shortcut_label': 'delete',
                                'label': '<?php echo $button_category_delete; ?>',
                                'action': function () {
                                    confirm('<?php echo $text_confirm_delete_category; ?>') ? oesdfy() : false;
                                }
                            }
                        };
                    }
                },
                'dnd' : { 'inside_pos': 0 }
            }
    )
            .on('move_node.jstree', function (e, data) {
                $.get('index.php?route=catalog/category_mgr/tree&<?php echo $token; ?>', { 'operation': 'move_node', 'id' : data.node.id, 'parent' : data.parent, 'position' : data.position })
                        .fail(function () {
                            data.instance.refresh();
                        });
            })
            .on('refresh.jstree', function () {
                if (window.open_node) {
                    window.open_node = false;
                    var selectedNode = $('#jstree').jstree(true).get_selected(false);
                    if (selectedNode.length == 1)
                        $('#jstree').jstree("open_node", selectedNode);
                }
                if (window.delete_node) {
                    window.delete_node = false;
                    $('#jstree').jstree("select_node", window.delete_parent);
                }
                uyyqtr();

            })
            .on('open_all.jstree', function (node) {
                uyyqtr();
            })
            .on('ready.jstree', function () {
                $('#jstree').jstree("open_node", "0");
                $('#jstree').jstree("select_node", "0");
            })
            .on("changed.jstree", function (e, data) {

                var obj = null;
                var root = true;
                if (data.node !== undefined) {
                    obj = data.node.data;
                    root = data.node.id == "0";
                }
                erwghu(obj, data.selected.length, root);
                if (obj != null && data.selected.length == 1) {
                    zcfbjgrw(true);
                }
            })
    ;

    $('#products-table').bootstrapTable({
        pagination: true,
        sidePagination: 'server',
        method: 'get',
        url: 'index.php?route=catalog/category_mgr/products&<?php echo $token; ?>',
        filter_url: 'index.php?route=catalog/category_mgr/products_filter&<?php echo $token; ?>',
        queryParams: function (p) {
            var selectedNodes = $('#jstree').jstree(true).get_selected(false);
            var node = (selectedNodes.length == 1) ? node = selectedNodes[0] : 0;
            window.selected_category = node;
            var real_offset = p.offset;
            if (window.reset_offset) {
                real_offset = 0;
                window.reset_offset = false;
            }
            return {
                id: node,
                order: p.order,
                sort: p.sort,
                limit: p.limit,
                offset: real_offset
            };
        },
        idField: 'product_id',
        cache: false,
        height: 773,
        oumzesfl: 'oumzesfl',
        sortName: 'name',
        sortOrder: 'asc',
        toolbar: '#products-toolbar',
        toolbarAlign: 'right',
        striped: false,
        showToggle: false,
        showRefresh: true,
        showFilter: true,
        showColumns: true,
        minimumCountColumns: 0,
        pageSize: 10,
        pageList: [10, 20, 50, 100, 1E3, 1E4],
        columns: [{
            field: 'state',
            checkbox: true
        }, {
            field: 'product_id',
            title: 'ID',
            valign: 'middle',
            visible: "<?php echo $cdata['product_id']['visible']; ?>",
            filtrable: true,
            sortable: true
        },
            {
                field: 'status',
                visible: false
            },{
                width: 70,
                field: 'image',
                class: 'img_thumb',
                title: '<?php echo $column_image; ?>',
                align: 'center',
                valign: 'middle',
                visible: "<?php echo $cdata['image']['visible']; ?>",
                filtrable: true,
                filtrableList: true,
                sortable: true,
                formatter: ofmxbwnx
            }, {
                field: 'name',
                title: '<?php echo $column_name; ?>',
                valign: 'middle',
                switchable: false,
                filtrable: true,
                align: 'left',
                formatter: ojkzye,
                sortable: true
            }, {
                field: 'categories',
                title: '<?php echo $column_categories; ?>',
                valign: 'top',
                visible: "<?php echo $cdata['categories']['visible']; ?>",
                switchable: true,
                filtrable: false,
                align: 'left',
                sortable: false
            }, {
                field: 'model',
                title: '<?php echo $column_model; ?>',
                valign: 'middle',
                filtrable: true,
                searchable: true,
                editable: {
                    'clear': false,
                    'disabled': ("<?php echo $pm_permissions; ?>" != ""),
                    'validate': function(value) {
                        if($.trim(value) == '') {
                            return '<?php echo $error_req_field; ?>';
                        }
                    }
                },
                sortable: true,
                visible: "<?php echo $cdata['model']['visible']; ?>",
                align: 'left'
            }, {
                field: 'sku',
                title: '<?php echo $column_sku; ?>',
                valign: 'middle',
                filtrable: true,
                searchable: true,
                editable: {
                    'clear': false,
                    'disabled': ("<?php echo $pm_permissions; ?>" != "")
                },
                sortable: true,
                visible: "<?php echo $cdata['sku']['visible']; ?>",
                align: 'left'
            }, {
                field: 'isbn',
                title: '<?php echo $column_isbn; ?>',
                valign: 'middle',
                filtrable: true,
                searchable: true,
                editable: {
                    'clear': false,
                    'disabled': ("<?php echo $pm_permissions; ?>" != "")
                },
                sortable: true,
                visible: "<?php echo $cdata['isbn']['visible']; ?>",
                align: 'left'
            }, {
                field: 'mpn',
                title: '<?php echo $column_mpn; ?>',
                valign: 'middle',
                filtrable: true,
                searchable: true,
                editable: {
                    'clear': false,
                    'disabled': ("<?php echo $pm_permissions; ?>" != "")
                },
                sortable: true,
                visible: "<?php echo $cdata['mpn']['visible']; ?>",
                align: 'left'
            }, {
                field: 'location',
                title: '<?php echo $column_location; ?>',
                valign: 'middle',
                filtrable: true,
                searchable: true,
                editable: {
                    'clear': false,
                    'disabled': ("<?php echo $pm_permissions; ?>" != "")
                },
                sortable: true,
                visible: "<?php echo $cdata['location']['visible']; ?>",
                align: 'left'
            }, {
                field: 'upc',
                title: '<?php echo $column_upc; ?>',
                valign: 'middle',
                filtrable: true,
                searchable: true,
                editable: {
                    'clear': false,
                    'disabled': ("<?php echo $pm_permissions; ?>" != "")
                },
                sortable: true,
                visible: "<?php echo $cdata['upc']['visible']; ?>",
                align: 'left'
            }, {
                field: 'ean',
                title: '<?php echo $column_ean; ?>',
                valign: 'middle',
                filtrable: true,
                searchable: true,
                editable: {
                    'clear': false,
                    'disabled': ("<?php echo $pm_permissions; ?>" != "")
                },
                sortable: true,
                visible: "<?php echo $cdata['ean']['visible']; ?>",
                align: 'left'
            }, {
                field: 'm_id',
                title: '<?php echo $column_manufacturer; ?>',
                valign: 'middle',
                visible: "<?php echo $cdata['m_name']['visible']; ?>",
                filtrable: true,
                filtrableList: true,
                sortable: true,
                editable: {
                    'disabled': ("<?php echo $pm_permissions; ?>" != ""),
                    'type': 'select',
                    'source': 'index.php?route=catalog/category_mgr/manufactures&<?php echo $token; ?>'
                },
                align: 'left'
            }, {
                field: 'stock_status_id',
                title: '<?php echo $column_stock_status; ?>',
                valign: 'middle',
                visible: "<?php echo $cdata['stock_status_id']['visible']; ?>",
                filtrable: true,
                filtrableList: true,
                sortable: true,
                editable: {
                    'disabled': ("<?php echo $pm_permissions; ?>" != ""),
                    'type': 'select',
                    'source': 'index.php?route=catalog/category_mgr/stockStatuses&<?php echo $token; ?>'
                },
                align: 'left'
            }, {
                width: 80,
                field: 'price',
                title: '<?php echo $column_price; ?>',
                align: 'left',
                valign: 'middle',
                searchable: true,
                editable: {
                    'clear': false,
                    'disabled': ("<?php echo $pm_permissions; ?>" != ""),
                    'validate': function(value) {
                        if($.trim(value) == '' || !$.isNumeric(value) ) {
                            return '<?php echo $error_req_price_field; ?>';
                        }
                    },
                    'display': function(value) {
                        var pk = $(this).data('pk');
                        var row = $.grep($('#products-table').bootstrapTable('getData'), function(e){
                            return e.product_id == pk;
                        })[0];
                        var d = value;
                        if (row.special) {
                            d = '<span style="text-decoration: line-through;">'+row.price+'</span><br/><span style="color: #b00;">'+row.special+'</span>';
                        }
                        $(this).html(d);
                    }
                },
                filtrable: true,
                visible: "<?php echo $cdata['price']['visible']; ?>",
                sortable: true
            }, {
                width: 85,
                field: 'quantity',
                title: '<?php echo $column_quantity; ?>',
                sortable: true,
                editable: {
                    'clear': false,
                    'type': 'number',
                    'disabled': ("<?php echo $pm_permissions; ?>" != ""),
                    'validate': function(value) {
                        if($.trim(value) == '' || !(Math.floor(value) == value && $.isNumeric(value)) ) {
                            return '<?php echo $error_req_int_field; ?>';
                        }
                    },
                    'display': function(value) {
                        var cls;
                        if (value <= 0) cls = "label-danger";
                        else if (value <= 5) cls = "label-warning";
                        else cls = "label-success";
                        $(this).html('<h5><span class="label '+cls+'">'+ value + '</span></h5>');
                    }
                },
                filtrable: true,
                visible: "<?php echo $cdata['quantity']['visible']; ?>",
                valign: 'middle',
                align: 'right'
            }, {
                field: 'dim',
                title: '<?php echo $column_dim; ?>',
                valign: 'middle',
                visible: "<?php echo $cdata['dim']['visible']; ?>",
                switchable: true,
                filtrable: false,
                align: 'left',
                sortable: false
            }, {
                field: 'weight',
                title: '<?php echo $column_weight; ?>',
                valign: 'middle',
                visible: "<?php echo $cdata['weight']['visible']; ?>",
                switchable: true,
                filtrable: false,
                align: 'left',
                sortable: false
            }, {
                width: 60,
                field: 'sort_order',
                title: '<?php echo $column_sort_order; ?>',
                sortable: true,
                editable: {
                    'clear': false,
                    'type': 'number',
                    'disabled': ("<?php echo $pm_permissions; ?>" != ""),
                    'validate': function(value) {
                        if($.trim(value) == '' || !(Math.floor(value) == value && $.isNumeric(value)) ) {
                            return '<?php echo $error_req_int_field; ?>';
                        }
                    }
                },
                visible: "<?php echo $cdata['sort_order']['visible'];?>",
                valign: 'left',
                align: 'right'
            }, {
                width: 110,
                field: 'status',
                title: '<?php echo $column_status; ?>',
                visible: "<?php echo $cdata['status_text']['visible']; ?>",
                filtrable: true,
                filtrableList: true,
                valign: 'middle',
                sortable: true,
                align: 'left',
                formatter: xmfoid
            }, {
                width: 80,
                field: 'date_added',
                title: '<?php echo $column_date_added; ?>',
                visible: "<?php echo $cdata['date_added']['visible']; ?>",
                filtrable: false,
                valign: 'middle',
                sortable: true,
                align: 'left'
            }, {
                width: 80,
                field: 'date_modified',
                class: 'td_date_modified',
                title: '<?php echo $column_date_modified; ?>',
                visible: "<?php echo $cdata['date_modified']['visible']; ?>",
                filtrable: false,
                valign: 'middle',
                sortable: true,
                align: 'left'
            }, {
                width: 135,
                field: 'action',
                title: '<?php echo $column_action; ?>',
                switchable: false,
                valign: 'middle',
                align: 'right',
                formatter: gezyxl
            }]
    }).on('all.bs.table', function (e, name, args) {
        uyyqtr();
        vfxbggxz();
        $('.editable-name').editable({
            container: 'body',
            success: function(response, newValue) {
                updateDateModified(response.row.product_id, response.row.date_modified);
            },
            error: function(response, newValue) {
                if(response.status === 400)
                    return response.responseText;
            }
        });
    }).on('click-row.bs.table', function (e, row, $element) {
        window.selected_products = [row.product_id];

    }).on('load-success.bs.table', function (data) {
        if (typeof arguments[1].ret != 'undefined') {
            if (arguments[1].ret == 'fail') alert('<?php echo $products_mgr_error_access_permission; ?>');
        }
    }).on('editable-save.bs.table', function (e, field, row) {
        irhqtj(field, row);
    }).on('column-switch.bs.table', function (e, field, checked) {
        $.ajax({
            type:  'POST',
            cache:  false ,
            url:  'index.php?route=catalog/category_mgr/product_columns&<?php echo $token; ?>',
            data:  { 'col': field, 'val': checked},
            success: function(data) {
                if (field == 'categories' && checked) zcfbjgrw(false);
            }
        });
    });

    var selectedNode = $('#jstree').jstree(true).get_selected(false);
    erwghu(null, selectedNode.length, true);

});

$(window).resize(function () {
    $('#products-table').bootstrapTable('resetView');
});

function iexhnw() {
    $('.jstree-anchor').droppable({
        tolerance: "pointer",
        accept: "tr",
        out: function( event, ui ) {
            var target = $(this);
            target.removeClass("accepted-drop");
        },
        over: function( event, ui ) {
            var target = $(this);
            var node = $('#jstree').jstree(true).get_node(target);
            if (node === undefined || node.id == "0" || node.id == window.selected_category) return;
            target.addClass("accepted-drop");
        },
        drop: function( event, ui ) {
            var target = $(this);
            var source = $(ui.draggable);
            var node = $('#jstree').jstree(true).get_node(target);
            window.drop_state = false;
            $('body').css("cursor", "default");
            if (node.id == "0" || window.selected_category == node.id) return;
            mnattkfp(window.selected_category, node.id);
            window.shift_down = false;
        },
        deactivate: function (event, ui) {
            window.drop_state = false;
            var dropItem = $(this);
            $('body').css("cursor", "default");
            dropItem.removeClass("accepted-drop");
        }
    });
}

function mnattkfp(source, target) {
    var copy = window.shift_down;
    var product_ids = window.selected_products;
    $.ajax({
        type:  'POST',
        cache:  false ,
        url:  'index.php?route=catalog/category_mgr/move_product&<?php echo $token; ?>',
        data:  { 'ids': product_ids, 'source': source, 'target': target, 'copy': copy},
        success: function() {
            zcfbjgrw(!copy);
        }
    });
}

function uyyqtr() {
    if ($('#drag-drop-toolbar').is(":visible")) return;
    if ("<?php echo $pm_permissions; ?>" != "") {
        return;
    }
    iexhnw();
    $('tr').draggable({
                cursorAt: { left: -16, top: 5 },
                helper: function (event) {
                    var selProducts = $('#products-table').bootstrapTable('getSelections');
                    if (selProducts.length > 1) {
                        $("tr" ).draggable("option", "opacity", 0.85);
                        return $('<button class="btn btn-primary" type="button"><?php echo $text_selected_products; ?>&nbsp;<span class="badge">'+selProducts.length+'</span>&nbsp;<span class="label label-default" id="operation"></span></button>');
                    }
                    else {
                        var ret = $(this).find('td.img_thumb').clone();
                        ret.append('&nbsp;<h5><span class="label label-default" id="operation"></span></button></h5>');
                        return ret;
                    }
                },
                start: function( event, ui ) {

                    var selectedNodes = $('#jstree').jstree(true).get_selected(false);
                    var node = (selectedNodes.length == 1) ? node = selectedNodes[0] : 0;
                    if (node == "0") window.root_node = true;

                    iexhnw();
                    var selProducts = $('#products-table').bootstrapTable('getSelections');
                    if (selProducts.length) {
                        window.selected_products = [];
                        selProducts.forEach(function(value) {
                            window.selected_products.push(value.product_id);
                        });


                    }
                    else {
                        var data = $("#products-table").bootstrapTable('getData');
                        var indx = $(this).attr('data-index');
                        window.selected_products = [data[indx].product_id];
                    }

                    window.drop_state = true;
                    stqkmz();
                },
                stop: function( event, ui ) {
                    window.drop_state = false;
                    window.root_node = false;
                },

                opacity: 0.5,
                appendTo: "body",
                cursor: "pointer"}
    );


}
function zcfbjgrw(reset_offset) {
    if (reset_offset) window.reset_offset = true;
    $("#products-table").bootstrapTable('refresh', {silent: true});
}

function oumzesfl(row, index) {
    if (row.status == "0")
        return {
            classes: 'active'
        };
    return {
        classes: ''
    };
}

function xcflap(product_id, image_url) {
    if (image_url != '') {
        $.ajax({
            type:  'POST',
            cache:  false ,
            url:  'index.php?route=catalog/category_mgr/change_img&<?php echo $token; ?>',
            data:  { 'id': product_id, 'img': image_url},
            success: function(data) {
                if (typeof data.ret != 'undefined') {
                    if (data.ret == 'fail') alert('<?php echo $products_mgr_error_modify_permission; ?>'); else {
                        $('#img_'+product_id).attr("src", data.thumb);
                    }
                }
            }
        });
    }
}

function bjrcjhjg(product_id) {
    $('#modal-image').remove();
    $.ajax({
        url: 'index.php?route=common/filemanager&<?php echo $token; ?>&thumb=dummy&target=img-'+product_id,
        dataType: 'html',
        product: product_id,
        success: function(html) {
            var product_id = this.product;
            $('body').append('<div id="modal-image" class="modal">' + html + '</div>');
            $('#modal-image').modal('show').on('hide.bs.modal', function () {
                var el = $('#img-'+product_id);
                xcflap(product_id, el.val());
                el.val('');
            })
        }
    });
}

function ojkzye (value, row) {
    ret = "";
    url = 'index.php?route=catalog/category_mgr/quick_edit&<?php echo $token; ?>';
    row.names.forEach(function(value) {
        pk = '{product_id: '+row.product_id+', language_id: '+value.language_id+'}';
        ret += '<div style="margin: 2px;"><img style="'+value.style+'margin: 4px 10px 6px 4px;" src="'+value.img+'"><a href="javascript:void(0)" class="editable-name editable editable-click" data-name="name" data-type="text" data-pk="'+pk+'" data-url="'+url+'" data-title="<?php echo $column_name; ?>" data-value="'+value.name+'">'+value.name+'</a></div>';
    });
    return ret;
}

function ofmxbwnx(value, row) {
    return '<input type="hidden" value="" id="img-'+row.product_id+'" /><a href="" onclick="bjrcjhjg('+row.product_id+'); return false;" class="img-thumbnail"><img id="img_'+row.product_id+'" src="'+value+'" alt="" title="" ></a>';
}

function xmfoid(value, row) {
    var checked = (value == "1") ? "checked" : "";
    if (value == "1")
        return '<div class="toggle btn btn-xs btn-success" data-toggle="toggle" style="width: 100%; height: 10px;"><input data-product-id="'+row.product_id+'" data-size="small" data-toggle="toggle" type="checkbox" checked><div class="toggle-group"><label class="btn btn-success btn-xs toggle-on"><?php echo strip_tags($text_enabled); ?></label><label class="btn btn-default btn-xs active toggle-off"><?php echo strip_tags($text_disabled); ?></label><span class="toggle-handle btn btn-default btn-xs"></span></div></div>';
    else
        return '<div class="toggle btn btn-xs btn-success off" data-toggle="toggle" style="width: 100%; height: 20px;"><input data-product-id="'+row.product_id+'" data-size="small" data-toggle="toggle" type="checkbox"><div class="toggle-group"><label class="btn btn-success btn-xs toggle-on"><?php echo strip_tags($text_enabled); ?></label><label class="btn btn-default btn-xs active toggle-off"><?php echo strip_tags($text_disabled); ?></label><span class="toggle-handle btn btn-default btn-xs"></span></div></div>';
}

function gezyxl(value, row) {
    var ico;
    var tooltip;
    if (row.status !== "0") {
        ico = 'fa-eye-slash';
        tooltip = '<?php echo $button_product_disable; ?>';
    }
    else {
        ico = 'fa-eye';
        tooltip = '<?php echo $button_product_enable; ?>';
    }
    var store_url = '<?php echo $store_front; ?>index.php?route=product/product&product_id='+row.product_id;
    var show_button = '<button title="<?php echo $button_show_in_store; ?>" onclick="window.open(\''+store_url+'\',\'_blank\');" class="btn btn-xs btn-default"><i class="fa fa-shopping-cart"></i></button>&nbsp;';
    var copy_button = '<button onclick="ywdlgc(['+row.product_id+']); return false;" class="btn btn-xs btn-default" title="<?php echo $button_product_copy; ?>"><i class="fa fa-copy"></i></button>';
    return show_button + '<button onclick="tabssb('+row.product_id+'); return false;" type="button" class="btn btn-xs btn-primary" title="<?php echo $button_product_edit; ?>"><i class="fa fa-pencil"></i></button>&nbsp;'+
            copy_button + '&nbsp;'+
            '<button onclick="xpfrgx(true, ['+row.product_id+']); return false;" type="button" class="btn btn-xs btn-danger" title="<?php echo $button_product_delete; ?>"><i class="fa fa-trash-o"></i></button>';
}

function fugrfvwl() {
    tabssb(-1);
}
function diyeoq() {
    var selProducts = $('#products-table').bootstrapTable('getSelections');
    if (selProducts.length) {
        if (confirm('<?php echo $text_confirm_delete_products; ?>')) {
            var arr = [];
            selProducts.forEach(function(value) {
                arr.push(value.product_id);
            });
            xpfrgx(false, arr);
        }
    }
}

function yqugzmdw() {
    var selProducts = $('#products-table').bootstrapTable('getSelections');
    if (selProducts.length == 1) {
        tabssb(selProducts[0].product_id)
    }
}

function xnooikdc(state) {
    var selProducts = $('#products-table').bootstrapTable('getSelections');
    if (selProducts.length) {
        var arr = [];
        selProducts.forEach(function(value) {
            arr.push(value.product_id);
        });
        zkzhresl(arr, state)
    }
}

function xpfrgx(ask_confirmation, product_ids) {
    if (!ask_confirmation || (confirm('<?php echo $text_confirm_delete_product; ?>'))) {
        $.ajax({
            type:  'POST',
            cache:  false ,
            url:  'index.php?route=catalog/category_mgr/delete_product&<?php echo $token; ?>',
            data:  { 'ids': product_ids},
            success: function(data) {
                if (typeof data.ret != 'undefined') {
                    if (data.ret == 'fail') alert('<?php echo $products_mgr_error_modify_permission; ?>'); else zcfbjgrw(true);
                }
            }
        });
    }
}

function zkzhresl(product_ids, state) {
    $.ajax({
        type:  'POST',
        cache:  false ,
        url:  'index.php?route=catalog/category_mgr/state_product&<?php echo $token; ?>',
        data:  { 'state' : state, 'ids': product_ids},
        success: function(data) {
            if (typeof data.ret != 'undefined') {
                if (data.ret == 'fail') alert('<?php echo $products_mgr_error_modify_permission; ?>'); else zcfbjgrw(true);
            }
        }
    });
}

function tabssb(product_id) {
    $('#dialog').remove();
    var window_w = $(window).width();
    var window_h = $(window).height();
    var h = Math.max(window_h * parseFloat("<?php echo $window_ratio; ?>"), MIN_H) | 0;
    var w = Math.max(window_w * parseFloat("<?php echo $window_ratio; ?>"), MIN_W) | 0;
    var url;
    if (product_id == -1)
        url = 'index.php?route=catalog/product/add&<?php echo $token; ?>';
    else
        url = 'index.php?route=catalog/product/edit&<?php echo $token; ?>&product_id=' + product_id;
    $('#content').append('<div id="dialog" style="background: gray; padding: 10px;"><iframe id="productFormIframe" src="'+url+'" style="padding: 0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
    $('#dialog').dialog({
        title: '',
        width: w,
        height: h,
        resizable: true,
        modal: true
    });
    $(".ui-dialog").css("z-index", "2995");
    $('#productFormIframe').load(function() {
        var cnt = $('#productFormIframe').contents();
        if (product_id == -1) {
            // Setup category
            var selectedNode = $('#jstree').jstree(true).get_selected(false);
            if (selectedNode.length == 1) {
                var full = "";
                var ids = $('#jstree').jstree(true).get_path(selectedNode, '', true);
                ids.shift();
                cnt.find("select[name='main_category_id']").val(selectedNode);

                cnt.find('#product-category div:odd').attr('class', 'odd');
                cnt.find('#product-category div:even').attr('class', 'even');
                cnt.find('#product-category').empty();

                var i = 0;
                var add_subcat = <?php echo $add_subcategories; ?>;

                ids.forEach(function(value) {
                    if (add_subcat || i == ids.length - 1)
                        cnt.find("input[name='product_category[]'][value='"+value+"']").prop('checked', true);
                    var part = $('#jstree').jstree(true).get_text(value);
                    if (full === "")
                        full = part;
                    else
                        full = full + " > " + part;

                    var elem = '<div id="product-category' + value + '"><i class="fa fa-minus-circle"></i>' + full + '<input type="hidden" name="product_category[]" value="' + value + '" /></div>';

                    if (add_subcat || i == ids.length - 1)
                        cnt.find('#product-category').append(elem);
                    i++;

                });

            }
        }
        var saved = cnt.find('div.alert.alert-success').length;
        if (!saved) {
            cnt.find('.breadcrumb').hide();
            cnt.find('#footer').hide();
            cnt.find('#column-left').remove();
            cnt.find('#header').hide();
            var cancel = cnt.find('a[href*="catalog/product"]');
            cancel.removeAttr("href");
            cancel.click(function(){ parent.njxuyh(0); } );
        }
        else {
            parent.njxuyh(1);
        }

    })
}

function ccqalwam(ok) {
    $('#dialog').dialog('close');
    if (ok) {
        window.open_node = true;
        $('#jstree').jstree("refresh");
    }
}

function njxuyh(ok) {
    $('#dialog').dialog('close');
    if (ok) {
        $("#products-table").bootstrapTable('refresh');
    }
}

function iyjpiemb() {
    $('#jstree').jstree("open_all");
}

function ohxuhu() {
    $('#jstree').jstree("close_all");
    $('#jstree').jstree("deselect_all", true);
    $('#jstree').jstree("select_node", "0");
}

function hxfbyjqw() {
    var selectedNode= $('#jstree').jstree(true).get_selected(false);
    if (selectedNode.length == 1) {
        fonfth(selectedNode);
    }
}

function oesdfy() {
    var selectedNodes = $('#jstree').jstree(true).get_selected(false);
    if (selectedNodes.length) {
        var parent = selectedNodes.length > 1 ? "0" : $('#jstree').jstree(true).get_parent(selectedNodes);
        ugbiureu(selectedNodes, parent);
    }
}

function cokvvbaz() {
    var selectedNodes = $('#jstree').jstree(true).get_selected(false);
    if (selectedNodes.length) {
        jzzpww(1, selectedNodes);
    }
}

function msrpee() {
    var selectedNodes = $('#jstree').jstree(true).get_selected(false);
    if (selectedNodes.length) {
        jzzpww(0, selectedNodes);
    }
}

function hsdsdttb(selector, state) {
    if (state) {
        $(selector).removeClass('disabled').addClass('active');
    }
    else {
        $(selector).removeClass('active').addClass('disabled');
    }
}
function erwghu(data, selectedCount, root) {
    vfxbggxz();
    if (root) {
        hsdsdttb('#xdvihy', false);
        hsdsdttb('#ggavbuxs', false);
        hsdsdttb('#zggjlw', false);
        hsdsdttb('#upufusyh', false);
        hsdsdttb('#hokffmsz', false);
        hsdsdttb('#btnCategoryView', false);
        return;
    }
    var status = 0;
    if (data != null)
        status = parseInt(data.status);
    hsdsdttb('#xdvihy', selectedCount > 1 || (selectedCount == 1 && status == 0));
    hsdsdttb('#ggavbuxs', selectedCount > 1 || (selectedCount == 1 && status == 1));
    hsdsdttb('#zggjlw', selectedCount == 1);
    hsdsdttb('#btnCategoryView', selectedCount == 1);
    hsdsdttb('#hokffmsz', selectedCount == 1);
    hsdsdttb('#fqnobj', selectedCount == 1);
    hsdsdttb('#upufusyh', selectedCount > 0);
}

function vfxbggxz() {
    var selProducts = $('#products-table').bootstrapTable('getSelections').length;
    hsdsdttb('#jcfhkn', selProducts > 0);
    hsdsdttb('#xzkldajj', selProducts > 0);
    hsdsdttb('#rsgfvpjx', selProducts > 0);
    hsdsdttb('#nrnygc', selProducts > 0);
    hsdsdttb('#unxmgv', selProducts == 1);

    var selectedNodes = $('#jstree').jstree(true).get_selected(false);
    hsdsdttb('#aykytuaz', selProducts > 0 && selectedNodes.length == 1 && selectedNodes[0] != '0');

    var toolbar_dd_mode = window.toolbar_dd_mode > 0;
    var root_node = false;
    var selCats = $('#jstree').jstree(true).get_selected(false);
    var node = (selCats.length == 1) ? node = selCats[0] : 0;
    if (node == "0") root_node = true;
    var same_cat = node == window.toolbar_dd_source;

    hsdsdttb('#iwpibz', selCats.length == 1 && selProducts > 0 && !root_node);

    hsdsdttb('#upffazqq', !toolbar_dd_mode && selProducts > 0);
    hsdsdttb('#emhodz', !toolbar_dd_mode && selProducts > 0);
    hsdsdttb('#pmyclvfv', toolbar_dd_mode && !root_node && !same_cat);
    hsdsdttb('#fvados', toolbar_dd_mode);
}

function oncfvkgw(operation) {
    var selCats = $('#jstree').jstree(true).get_selected(false);
    var node = (selCats.length == 1) ? node = selCats[0] : 0;
    window.toolbar_dd_mode = operation;
    window.toolbar_dd_source = node;
    window.selected_products = [];
    var selProducts = $('#products-table').bootstrapTable('getSelections');
    if (selProducts.length) {
        selProducts.forEach(function(value) {
            window.selected_products.push(value.product_id);
        });
    }
    vfxbggxz();
}

function ezcvhj() {
    return oncfvkgw(1);
}

function egezdgig() {
    return oncfvkgw(2);
}

function ncosfq() {
    if (!window.toolbar_dd_mode) return;
    var selCats = $('#jstree').jstree(true).get_selected(false);
    var target = (selCats.length == 1) ? node = selCats[0] : 0;
    if (!target) return;
    var copy = window.toolbar_dd_mode == 1;

    var product_ids = window.selected_products;

    $.ajax({
        type:  'POST',
        cache:  false ,
        url:  'index.php?route=catalog/category_mgr/move_product&<?php echo $token; ?>',
        data:  { 'ids': product_ids, 'source': window.toolbar_dd_source, 'target': target, 'copy': copy},
        success: function() {
            window.toolbar_dd_mode = 0;
            window.toolbar_dd_source = 0;
            zcfbjgrw(true);
        }
    });
}

function bdqsqiqv() {
    window.toolbar_dd_mode = 0;
    window.toolbar_dd_source = 0;
    window.selected_products = [];
    vfxbggxz();
}

function xwpmvj(value){
    if (value) {
        return jQuery('<div/>').html(value).text();
    } else {
        return '';
    }
}

function twkvgcdc(url, parent_id, parent_path) {
    var window_w = $(window).width();
    var window_h = $(window).height();
    var h = Math.max(window_h * parseFloat("<?php echo $window_ratio; ?>"), MIN_H) | 0;
    var w = Math.max(window_w * parseFloat("<?php echo $window_ratio; ?>"), MIN_W) | 0;
    $('#dialog').remove();
    $('#content').append('<div id="dialog" style="background:gray; padding:10px;"><iframe id="categoryFormIframe" src="'+url+'" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="yes" scrolling="auto"></iframe></div>');
    $('#dialog').dialog({
        title: '',
        width: w,
        height: h,
        resizable: true,
        modal: true
    });
    $(".ui-dialog").css("z-index", "2995");
    $('#categoryFormIframe').load(function() {
        var cnt = $('#categoryFormIframe').contents();
        if (parent_id) {
            cnt.find("select[name='parent_id']").val(parent_id);
            cnt.find("input[name='parent_id']").val(parent_id);
            var path = cnt.find("input[name='path']");
            if (path.length) {
                path.val(xwpmvj(parent_path));
            }
        }
        var saved = cnt.find('div.alert.alert-success').length;
        if (!saved) {
            cnt.find('.breadcrumb').hide();
            cnt.find('#footer').hide();
            cnt.find('#header').hide();
            cnt.find('#column-left').remove();
            var cancel = cnt.find('a[href*="catalog/category"]');
            cancel.removeAttr("href");
            cancel.click(function(){ parent.ccqalwam(0); });
        }
        else {
            parent.ccqalwam(1);
        }

    })
}

function jzzpww(state, category_ids) {
    $.ajax({
        type:  'POST',
        cache:  false ,
        url:  'index.php?route=catalog/category_mgr/state&<?php echo $token; ?>',
        data:  { 'state' : state, 'ids': category_ids},
        success: function(data) {
            if (typeof data.ret != 'undefined') {
                if (data.ret == 'fail') alert('<?php echo $category_mgr_error_modify_permission; ?>'); else $('#jstree').jstree("refresh");
            }
        }
    });
}

function ugbiureu(category_ids, parent) {
    $.ajax({
        type:  'POST',
        cache:  false ,
        url:  'index.php?route=catalog/category_mgr/delete&<?php echo $token; ?>',
        data:  { 'ids': category_ids},
        success: function(data) {
            if (typeof data.ret != 'undefined') {
                if (data.ret == 'fail') alert('<?php echo $category_mgr_error_modify_permission; ?>');
                else {
                    window.delete_node = true;
                    window.delete_parent = parent;
                    $('#jstree').jstree("refresh");
                }
            }
        }
    });
}

function fonfth(category_id) {
    twkvgcdc('index.php?route=catalog/category/edit&category_id='+category_id+'&<?php echo $token; ?>', 0, '');
}

function daemifkq() {
    var selectedNode = $('#jstree').jstree(true).get_selected(false);
    var id = 0;
    var path = "";
    if (selectedNode.length) {
        id = selectedNode[0];
        path = (id == "0") ? "" : $('#jstree').jstree(true).get_path(selectedNode, ' > ', false);
        var indx = path.indexOf('>');
        if (indx > 0) {
            path = path.substring(indx + 2);
        }
    }
    twkvgcdc('index.php?route=catalog/category/add&<?php echo $token; ?>', id, path);
}

function stqkmz() {
    var txt = (window.shift_down && !window.root_node) ? "<?php echo $text_operation_copy; ?>" : "<?php echo $text_operation_move; ?>";
    $('#operation').text(txt);
}

function vzbtfvma() {
    var selProducts = $('#products-table').bootstrapTable('getSelections');
    if (selProducts.length) {
        var arr = [];
        selProducts.forEach(function(value) {
            arr.push(value.product_id);
        });
        ywdlgc(arr);
    }
}

function ywdlgc(product_id) {
    if ("<?php echo $pm_permissions; ?>" != "") {
        alert('<?php echo $pm_permissions; ?>');
        return;
    }
    var formData = new FormData();
    product_id.forEach(function(value) {
        formData.append('selected[]', value);
    });
    $.ajax({
                url: 'index.php?route=catalog/product/copy&<?php echo $token; ?>',
                data: formData,
                processData: false,
                type: 'POST',
                contentType: false,
                mimeType: 'multipart/form-data',
                success: function () {
                    zcfbjgrw(true);
                }
            }
    )
}

function aztlme(product_id) {
    var dta = $('#products-table').bootstrapTable('getData');
    var indx = -1;
    for (var i = 0, len = dta.length; i < len; i++) {
        if (dta[i]['product_id'] == product_id) {
            indx = i;
            break;
        }
    }
    if (indx >= 0) {
        var changed_row = $('tr[data-index="'+indx+'"]');
        if (changed_row)
            changed_row.toggleClass("active");
    }
}

function irhqtj(field, row) {
    $.ajax({
                url:  'index.php?route=catalog/category_mgr/quick_edit&<?php echo $token; ?>',
                cache:  false,
                data:  { 'id': row['product_id'], 'field': field, 'value': row[field]},
                type: 'POST',
                fail: function () {
                    zcfbjgrw(true);
                },
                success: function (data) {
                    if (typeof data.ret != 'undefined') {
                        if (data.ret == 'fail')
                            zcfbjgrw(true);
                        else {
                            if (field == 'status') {
                                aztlme(row['product_id']);
                            }
                                updateDateModified(data.row.product_id, data.row.date_modified);
                        }
                    }
                }
            }
    )
}

function gpewmvay(mode) {
    var selProducts = $('#products-table').bootstrapTable('getSelections');
    var selectedNode= $('#jstree').jstree(true).get_selected(false);

    if (selectedNode.length == 1 && selProducts.length) {
        var arr = [];
        selProducts.forEach(function(value) {
            arr.push(value.product_id);
        });
        $.ajax({
            type:  'POST',
            cache:  false,
            url:  'index.php?route=catalog/category_mgr/remove_product_category&<?php echo $token; ?>',
            data:  { 'ids': arr, 'category_id': selectedNode[0], 'mode': mode},
            success: function(data) {
                if (typeof data.ret != 'undefined') {
                    if (data.ret == 'fail') alert('<?php echo $products_mgr_error_modify_permission; ?>'); else
                    {
                        zcfbjgrw(false);
                    }
                }
            }
        });
    }
}

function fhqive() {
    var selProducts = $('#products-table').bootstrapTable('getSelections');
    var selectedNode= $('#jstree').jstree(true).get_selected(false);

    if (selectedNode.length == 1 && selProducts.length) {
        var arr = [];
        selProducts.forEach(function(value) {
            arr.push(value.product_id);
        });

        $.ajax({
            type:  'POST',
            cache:  false ,
            url:  'index.php?route=catalog/category_mgr/clone_products_to_parent_category&<?php echo $token; ?>',
            data:  { 'ids' : arr, 'category_id' : selectedNode[0] },
            success: function(data) {
                if (typeof data.ret != 'undefined') {
                    if (data.ret == 'fail') alert('<?php echo $products_mgr_error_modify_permission; ?>');
                }
            }
        });
    }
}

function vuefpy() {
    var selectedNode= $('#jstree').jstree(true).get_selected(false);
    if (selectedNode.length == 1) {
        $.ajax({
            type:  'POST',
            cache:  false ,
            url:  'index.php?route=catalog/category_mgr/clone_category&<?php echo $token; ?>',
            data:  { 'id' : selectedNode[0]},
            success: function(data) {
                if (typeof data.ret != 'undefined') {
                    if (data.ret == 'fail') alert('<?php echo $category_mgr_error_modify_permission; ?>'); else $('#jstree').jstree("refresh");
                }
            }
        });
    }
}
function rkihaeaf(enabled) {
    var selectedNode= $('#jstree').jstree(true).get_selected(false);
    if (selectedNode.length) {
        $.ajax({
            type:  'POST',
            cache:  false ,
            url:  'index.php?route=catalog/category_mgr/top_category&<?php echo $token; ?>',
            data:  { 'ids' : selectedNode, 'val': enabled ? 1 : 0},
            success: function(data) {
                if (typeof data.ret != 'undefined') {
                    if (data.ret == 'fail') alert('<?php echo $category_mgr_error_modify_permission; ?>'); else $('#jstree').jstree("refresh");
                }
            }
        });
    }
}

function agaxkdmu(disable) {
    var selectedNode= $('#jstree').jstree(true).get_selected(false);
    if (selectedNode.length) {
        $.ajax({
            type:  'POST',
            cache:  false ,
            url:  'index.php?route=catalog/category_mgr/disable_empty_categories&<?php echo $token; ?>',
            data:  { 'ids' : selectedNode, 'disable' : disable},
            success: function(data) {
                if (typeof data.ret != 'undefined') {
                    if (data.ret == 'fail') alert('<?php echo $category_mgr_error_modify_permission; ?>'); else $('#jstree').jstree("refresh");
                }
            }
        });
    }
}
function isTouch() {
 return (('ontouchstart' in window) || (navigator.msMaxTouchPoints > 0));
}
$( '.dropdown-menu a[data-value]' ).on( 'click', function( event ) {

    var $target = $( event.currentTarget ),
            val = parseInt($target.attr( 'data-value' )),
            $inp = $target.find( 'input' ),
            idx;

    if ( ( idx = options.indexOf( val ) ) > -1 ) {
        options.splice( idx, 1 );
        setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
    } else {
        options.push( val );
        setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
    }

    $( event.target ).blur();

    $.ajax({
        type:  'POST',
        cache:  false ,
        url:  'index.php?route=catalog/category_mgr/store_filter&<?php echo $token; ?>',
        data:  { 'options' : options},
        success: function(data) {
            if (typeof data.ret != 'undefined') {
                if (data.ret == 'fail') alert('<?php echo $category_mgr_error_modify_permission; ?>'); else {
                    window.open_node = true;
                    $('#jstree').jstree("refresh");
                }
            }
        }

    });

    return false;
});

function onCategoryView() {
    var selectedNode= $('#jstree').jstree(true).get_selected(false);
    if (selectedNode.length == 1) {
        var store_url = '<?php echo $store_front; ?>index.php?route=product/category&path='+selectedNode;
        window.open(store_url,'_blank');
    }
}

function updateDateModified(product_id, date_modified) {
    var dta = $('#products-table').bootstrapTable('getData');
    var indx = -1;
    for (var i = 0, len = dta.length; i < len; i++) {
        if (dta[i]['product_id'] == product_id) {
            indx = i;
            break;
        }
    }
    if (indx >= 0) {
        $('tr[data-index="'+indx+'"]').find('td.td_date_modified').html(date_modified);

        $('#products-table').bootstrapTable('updateRow', {
            index: indx,
            row: {
                id: product_id,
                date_modified: date_modified
            }
        });

    }

}

//--></script>
<?php echo $footer; ?>