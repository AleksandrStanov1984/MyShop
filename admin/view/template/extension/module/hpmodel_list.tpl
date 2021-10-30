<div class="tab-pane hpm-series hpm-list" id="tab-hpmodel">
  <legend>
    <h2><?php echo $name_kit;?></h2>
    <button form="help_modals" class="pull-right hm-help btn btn-primary btn-sm" data-toggle="modal" data-target="#hpm-modal">
    <i class="fa fa-info" aria-hidden="true"></i> - <?php echo $help_name; ?>
    </button>
  </legend>
  <table class='table table-hover table-bordered table-responsive' id='hpm-search'>
    <thead>
      <tr>
        <div id='ajax-response'></div>
          <td>
              <label class="control-label">
                <span data-toggle="tooltip" title="" data-original-title="<?php echo $col_name_search;?>">
                  <?php echo $col_name_search;?>
                </span>
              </label>
          </td>
        <td>
          <label class="control-label">
          <span data-toggle="tooltip" title="" data-original-title="<?php echo $col_sku_search;?>">
          <?php echo $col_sku_search;?>
          </span>
          </label>
        </td>
        <td class="text-center status">
          <label class="control-label">
          <span data-toggle="tooltip" title="" data-original-title="<?php echo $col_add;?>">
          <i class="fa fa-check-square-o" aria-hidden="true"></i>
          </span>
          </label>
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><input type="text" id="hpmodel-search-prd" placeholder="<?php echo $add_name_product;?>" class="form-control"></td>
        <td><input type="text" id="hpmodel-search-sku" placeholder="<?php echo $add_sku_product;?>" class="form-control"></td>
        <td class="text-center"><button id="save-hpmodel" class='btn btn-success' data-toggle="tooltip" title="" data-original-title="<?php echo $col_add;?>"><i class='fa fa-check-square-o'></i></button></td>
      </tr>
    </tbody>
  </table>
  <input type="hidden" name="parent_id" value='<?php echo $parent_id;?>'>
  <input type="hidden" name="product_id" value='<?php echo $product_id;?>'>
  <table class="table table-hover table-bordered table-responsive" id="hpmodel-prd-list">
    <thead>
      <tr>
        <td class="text-center"><label class="control-label">ID</label></td>        
        <td class="text-center status">
            <label class="control-label">
                <span data-toggle="tooltip" title="" data-original-title="<?php echo $parent_product;?>">
                    <i class="fa fa-dot-circle-o"></i>
                </span>
            </label>
        </td>
        <td class="text-center hpm-list-sku">
          <label class="control-label">
          <span data-toggle="tooltip" title="" data-original-title="<?php echo $sku;?>">
          SKU
          </span>
          </label>
        </td>
        <td class="text-center hpm-list-img">
          <label class="control-label">
          <span data-toggle="tooltip" title="" data-original-title="<?php echo $img_edit;?>">
          <i class="fa fa-picture-o"></i>
          </span>
          </label>
        </td>
        <td>
          <label class="control-label">
          <span data-toggle="tooltip" title="" data-original-title="<?php echo $name;?>">
          <?php echo $name;?>
          </span>
          </label>
        </td>
        <td><label class="control-label"><?php echo $entry_model; ?></label></td>
        <td><label class="control-label"><?php echo $entry_manufacturer; ?></label></td>
        <td><label class="control-label"><?php echo $entry_category; ?></label></td>
        <td class="text-center"><label class="control-label"><?php echo $entry_price; ?></label></td>
        <td class="text-center status">
          <label class="control-label">
          <span data-toggle="tooltip" title="" data-original-title="<?php echo $entry_quantity; ?>">
          <i class='fa fa-signal fa-1x'></i>
          </span>
          </label>
        </td>
        <td class="text-center status">
          <label class="control-label">
          <span data-toggle="tooltip" title="" data-original-title="<?php echo $col_sort; ?>">
          <i class='fa fa-sort fa-1x'></i>
          </span>
          </label>
        </td>
        <td class="text-center status">
          <label class="control-label">
          <span data-toggle="tooltip" title="" data-original-title="<?php echo $button_remove;?>">
          <i class='fa fa-trash-o fa-1x'></i>
          </span>
          </label>
        </td>
      </tr>
    </thead>
    <tbody>
      <?php foreach($childs as $product) { ?>
      <tr class="<?php echo $product["id"] == $parent_id ? 'active' : ''; ?>">
        <td class="text-center"><?php echo $product['id'];?></td>
        <td class="text-center hpm-main-product"><input type="radio" name="hpm_main_product" <?php echo $product["id"] == $parent_id ? 'checked="checked"' : ''; ?> value="<?php echo $product["id"];?>" /></td>
        <td class="text-center"><?php echo $product['sku'];?></td>
        <td class="text-center hpm-list-img">
          <a href="" id="thumb-hpm-image-<?php echo $product["id"];?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $product['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $product['product_image']; ?>" /></a><input type="hidden" name="products[<?php echo $product["id"];?>][image]" value="<?php echo $product['image']; ?>" id="input-hpm-image-<?php echo $product["id"];?>" />
        </td>
        <td><input type='hidden' name='products[<?php echo $product["id"];?>][id]' value='<?php echo $product["id"];?>'><a href="<?php echo $product['edit'];?>" target="_blank"><i class="fa fa-link"></i> <?php echo $product['name'];?></a></td>
        <td class="text-left"><?php echo $product['model'];?></td>
        <td class="text-left"><?php echo $product['manufacturer'];?></td>
        <td class="text-left">
          <?php foreach($categories as $category) { ?>
          <?php if (in_array($category['category_id'], $product['category'])) { ?>
          <div><?php echo $category['name']; ?></div>
          <?php } ?>
          <?php } ?>
        </td>
        <td class="text-right"><?php echo $product['price'];?></td>
        <td class="text-right"><?php echo $product['quantity'];?></td>
        <td><input type='text' name='products[<?php echo $product["id"];?>][sort]' value="<?php echo $product['sort'];?>" class='form-control'></td>
        <td class="text-center"><button id='' class='btn btn-danger remove' data-toggle="tooltip" title="" data-original-title="<?php echo $button_remove;?>"><i class='fa fa-trash-o'></i></button></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel-heading text-center copy">
        <button form="help_modals" class="hm-info btn btn-primary btn-sm" data-toggle="modal" data-target="#hpm-authors-modal">
        <?php echo $desc_author_start; ?>
        </button>
      </div>
    </div>
  </div>
</div>

<div class="hpm-series modal fade" id="hpm-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-cogs"></i> <?php echo $help_name_kit; ?></h4>
      </div>
      <div class="modal-body">
        <div class="help-text"><?php echo $top_kit_text; ?></div>
        <hr>
        <div class="text-center"><?php echo $help_first_kit; ?></div>
        <div class="help-text"><?php echo $help_second_kit; ?>5</div>
          <div class="text-center"><?php echo $help_third_kit; ?></div>
          <div class="help-text"><?php echo $help_fourth_kit; ?></div>
        <hr>
        <div class="help-text"><?php echo $bottom_kit_text; ?></div>
      </div>
      <div class="modal-footer">
        <div class="text-center"><?php echo $copy_label; ?></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="hpm-authors-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-copyright"></i> <?php echo $desc_author; ?></h4>
      </div>
      <div class="modal-body authors">
        <legend class="text-center"><?php echo $desc_copy; ?></legend>
        <div class="text-center"><?php echo $desc_author_copy; ?></div>
        <br>
      </div>
      <div class="modal-footer">
        <div class="text-center"><?php echo $copy_label; ?></div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {
    $('#hpmodel-search-sku').autocomplete({'source': hpm_autocomplete_source_model,'select': hpm_autocomplete_select});
    $('#hpmodel-search-prd').autocomplete({'source': hpm_autocomplete_source,'select': hpm_autocomplete_select});

    $('#hpmodel-prd-list').on('click', 'td .remove', function () {
        $(this).parents('tr').remove();
        hpm_update_parent();
        return false;
    });

    $('#save-hpmodel').on('click', function () {
        $.ajax({
            url: 'index.php?route=extension/module/hpmodel/save&token=<?php echo $token; ?>',
            method: 'POST',
            data: $('#tab-hpmodel input[type="hidden"], #tab-hpmodel input[type="text"]'),
            success: function (json) {
                if (json['error']) {
                    $('#tab-hpmodel #ajax-response').html('<div class=\'alert alert-danger\'>' + json['error'] + '</div>')
                } else if (json['success']) {
                    $('#tab-hpmodel #ajax-response').html('<div class=\'alert alert-success\'>' + json['success'] + '</div>')
                }
            }
        });
        return false;
    });
    
    $('.hpm-series').on('change', '.hpm-main-product input[type="radio"]', function() {
        if ($(this).closest('tr').hasClass('active')) $(this).prop('checked', false);
        $('.hpm-series tbody tr.active').removeClass('active');
        hpm_update_parent();
    }).on('click', 'tr.active input[type="radio"]:checked', function(e) {
        $(this).trigger('change');
    }).on('click', '.hpm-main-product', function(e) {
        if (e.target.localName != 'td') return;
        $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
    });
});

function hpm_update_parent() {
    var $cb = $('.hpm-main-product input[type="radio"]:checked');
    if ($cb.length) {
        $cb.closest('tr').addClass('active');
        $('.hpm-series input[name="parent_id"]').val($cb.val());
    } else {
        $('.hpm-series input[name="parent_id"]').val(<?php echo $product_id; ?>);
    }
}

function hpm_autocomplete_source_model(request, response) {
    $.ajax({
        url: 'index.php?route=extension/module/hpmodel/autocomplete&token=<?php echo $token; ?>&filter_model=' + encodeURIComponent(request),
        dataType: 'json',
        success: function (json) {
            response($.map(json, function (item) {
                return {
                    label: item['name'] + ' (' + item['model'] + ')',
                    value: item['product_id'],
                    sku: item['sku'],
                    model: item['model'],
                    quantity: item['quantity'],
                    manufacturer: item['manufacturer'],
                    product_category: item['product_category'],
                    price: item['price'],
                    name: item['name'],
                    image: item['image'],
                    product_id: item['product_id'],
                }
            }));
        }
    });
}
function hpm_autocomplete_source(request, response) {
    $.ajax({
        url: 'index.php?route=extension/module/hpmodel/autocomplete&token=<?php echo $token; ?>&filter_name=' + encodeURIComponent(request),
        dataType: 'json',
        success: function (json) {
            response($.map(json, function (item) {
                return {
                    label: item['name'] + ' (' + item['model'] + ')',
                    value: item['product_id'],
                    sku: item['sku'],
                    model: item['model'],
                    quantity: item['quantity'],
                    manufacturer: item['manufacturer'],
                    product_category: item['product_category'],
                    price: item['price'],
                    name: item['name'],
                    image: item['image'],
                    product_id: item['product_id'],
                }
            }));
        }
    });
}
function hpm_autocomplete_select(item) {
    html  = '<tr>';
    html += '  <td class="text-center">' + item.product_id + '</td>';
    html += '  <td class="text-center hpm-main-product"><input type="radio" name="hpm_main_product" value="' + item.product_id + '" /></td>';
    html += '  <td class="text-center">' + item.sku + '</td>';
    html += '  <td class="text-center hpm-list-img"><a href="" id="thumb-hpm-image-' + item.product_id + '"data-toggle="image" class="img-thumbnail"><img src="' + item.image+ '" alt="" title="" data-placeholder="' + item.image+ '" /></a><input type="hidden" name="products[' + item.product_id + '][image]" value="" id="input-hpm-image-' + item.product_id + '" /></td>';
    html += '  <td><input type="hidden" name="products[' + item.product_id + '][id]" value="' + item.product_id + '" >' + item.name + '</td>';
    html += '  <td class="text-left">' + item.model + '</td>';
    html += '  <td class="text-left">' + item.manufacturer + '</td>';
    html += '  <td class="text-left">' + item.product_category + '</td>';
    html += '  <td class="text-center">' + item.price + '</td>';
    html += '  <td class="text-center">' + item.quantity + '</td>';
    html += '  <td><input type="text" name="products[' + item.product_id + '][sort]" value="1" class="form-control"></td>';
    html += '  <td class="text-center"><button class="btn btn-danger remove"><i class="fa fa-trash-o"></i></button></td>';
    html += '</tr>';        
    $('#hpmodel-prd-list tbody').append(html);
}
</script>