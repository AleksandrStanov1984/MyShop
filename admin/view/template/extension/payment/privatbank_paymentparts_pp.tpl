<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-privat-payparts" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-privat-payparts" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-status" data-toggle="tab"><?php echo $tab_order_status; ?></a></li>
          </ul> 
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-id"><?php echo $entry_shop_id; ?></label>
                <div class="col-sm-10">
                  <?php echo $text_paymentparts_url;?>
                  <input type="text" name="privatbank_paymentparts_pp_shop_id" value="<?php echo $privatbank_paymentparts_pp_shop_id; ?>" placeholder="<?php echo $entry_shop_id; ?>" id="input-shop-id" class="form-control"/>
                  <?php if ($error_shop_id) { ?>
                  <div class="text-danger"><?php echo $error_shop_id; ?></div>
                  <?php } ?>                  
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-shop-password"><?php echo $entry_shop_password; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="privatbank_paymentparts_pp_shop_password" value="<?php echo $privatbank_paymentparts_pp_shop_password; ?>" placeholder="<?php echo $entry_shop_password; ?>" id="input-shop-password" class="form-control"/>
                  <?php if ($error_shop_password) { ?>
                  <div class="text-danger"><?php echo $error_shop_password; ?></div>
                  <?php } ?>                   
                </div>                
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_payment_type; ?>"><?php echo $entry_payment_type; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($privatbank_paymentparts_pp_hold) { ?>
                    <input type="radio" name="privatbank_paymentparts_pp_hold" value="1" checked="checked" />
                    <?php echo $entry_payment_type_hold; ?>
                    <?php } else { ?>
                    <input type="radio" name="privatbank_paymentparts_pp_hold" value="1" />
                    <?php echo $entry_payment_type_hold; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$privatbank_paymentparts_pp_hold) { ?>
                    <input type="radio" name="privatbank_paymentparts_pp_hold" value="0" checked="checked" />
                    <?php echo $entry_payment_type_standart; ?>
                    <?php } else { ?>
                    <input type="radio" name="privatbank_paymentparts_pp_hold" value="0" />
                    <?php echo $entry_payment_type_standart; ?>
                    <?php } ?>
                  </label>
                </div>
              </div>
              <div class="form-group required">                
                <label class="col-sm-2 control-label" for="input-ii-paymentquantity"><span data-toggle="tooltip" title="<?php echo $help_paymentquantity; ?>"><?php echo $entry_paymentquantity; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="privatbank_paymentparts_pp_paymentquantity" value="<?php echo $privatbank_paymentparts_pp_paymentquantity; ?>" placeholder="<?php echo $entry_paymentquantity; ?>" id="input-ii-paymentquantity" class="form-control"/>
                  <?php if ($error_paymentquantity) { ?>
                  <div class="text-danger"><?php echo $error_paymentquantity; ?></div>
                  <?php } ?>        
                </div>
              </div>                
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-privatbank_paymentparts_pp_min_total"><span data-toggle="tooltip" title="<?php echo $help_min_total; ?>"><?php echo $entry_min_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="privatbank_paymentparts_pp_min_total" value="<?php echo $privatbank_paymentparts_pp_min_total; ?>" placeholder="<?php echo $entry_min_total; ?>" id="input-privatbank_paymentparts_pp_min_total" class="form-control"/>
                </div>
              </div>          
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-privatbank_paymentparts_pp_max_total"><span data-toggle="tooltip" title="<?php echo $help_max_total; ?>"><?php echo $entry_max_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="privatbank_paymentparts_pp_max_total" value="<?php echo $privatbank_paymentparts_pp_max_total; ?>" placeholder="<?php echo $entry_max_total; ?>" id="input-privatbank_paymentparts_pp_max_total" class="form-control"/>
                </div>
              </div>     		
              <div class="form-group">                
                <label class="col-sm-2 control-label" for="input-privatbank_paymentparts_pp_markup"><span data-toggle="tooltip" title="<?php echo $help_markup; ?>"><?php echo $entry_markup; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="privatbank_paymentparts_pp_markup" value="<?php echo $privatbank_paymentparts_pp_markup; ?>" placeholder="<?php echo $entry_markup; ?>" id="input-privatbank_paymentparts_pp_markup" class="form-control"/>
                </div>
              </div> 
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-10">
                  <select name="privatbank_paymentparts_pp_geo_zone_id" id="input-geo-zone" class="form-control">
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                    <?php if ($geo_zone['geo_zone_id'] == $privatbank_paymentparts_pp_geo_zone_id) { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>     
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="privatbank_paymentparts_pp_status" id="input-status" class="form-control">
                    <?php if ($privatbank_paymentparts_pp_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">                  
                <label class="col-sm-2 control-label" for="input-sort_order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="privatbank_paymentparts_pp_sort_order" value="<?php echo $privatbank_paymentparts_pp_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort_order" class="form-control"/>
                </div>
              </div>			  
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-allowed"><span data-toggle="tooltip" title="<?php echo $help_enabled; ?>"><?php echo $entry_enabled; ?></span></label>
                <div class="col-sm-10">
                  <label class="radio-inline">
                    <?php if ($privatbank_paymentparts_pp_enabled) { ?>
                    <input type="radio" id="enabled_all" name="privatbank_paymentparts_pp_enabled" value="1" checked="checked" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_all" name="privatbank_paymentparts_pp_enabled" value="1" />
                    <?php echo $entry_enabled_productcard; ?>
                    <?php } ?>
                  </label>
                  <label class="radio-inline">
                    <?php if (!$privatbank_paymentparts_pp_enabled) { ?>
                    <input type="radio" id="enabled_selected" name="privatbank_paymentparts_pp_enabled" value="0" checked="checked" />
                    <?php echo $entry_enabled_all; ?>
                    <?php } else { ?>
                    <input type="radio" id="enabled_selected" name="privatbank_paymentparts_pp_enabled" value="0" <?php echo $privatbank_paymentparts_pp_products_allowed?'disabled':''; ?>/>
                    <?php echo $entry_enabled_all; ?>
                    <?php } ?>
                  </div>
              </div>
			  <div class="form-group">
				<label class="col-sm-2"></label>
				<div class="col-sm-10">
					<input type="text" name="allowed" value="" placeholder="<?php echo $entry_enabled; ?>" id="input-allowed" class="form-control" />
					<input type="text" name="category_allowed" value="" placeholder="<?php echo $entry_enabled_cat; ?>" class="form-control" />
					<div id="product-allowed" class="well well-sm" style="height: 300px; overflow: auto;">
					<?php foreach ($privatbank_paymentparts_pp_products_allowed as $product_allowed) { ?>
					<div id="product-allowed<?php echo $product_allowed['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_allowed['name']; ?>
					<input type="hidden" name="privatbank_paymentparts_pp_product_allowed[]" value="<?php echo $product_allowed['product_id']; ?>" />
					</div> 
					<?php } ?>
				  </div>
				</div>
			  </div>		  			  
            </div>
            <div class="tab-pane" id="tab-status">
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_completed_status; ?></label>
                <div class="col-sm-10">
                  <select name="privatbank_paymentparts_pp_completed_status_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $privatbank_paymentparts_pp_completed_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_canceled_status; ?></label>
                <div class="col-sm-10">
                  <select name="privatbank_paymentparts_pp_canceled_status_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $privatbank_paymentparts_pp_canceled_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div> 
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_clientwait_status; ?></label>
                <div class="col-sm-10">
                  <select name="privatbank_paymentparts_pp_clientwait_status_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $privatbank_paymentparts_pp_clientwait_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div> 
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_created_status; ?></label>
                <div class="col-sm-10">
                  <select name="privatbank_paymentparts_pp_created_status_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $privatbank_paymentparts_pp_created_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>                                                     
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_failed_status; ?></label>
                <div class="col-sm-10">
                  <select name="privatbank_paymentparts_pp_failed_status_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $privatbank_paymentparts_pp_failed_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div> 
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_rejected_status; ?></label>
                <div class="col-sm-10">
                  <select name="privatbank_paymentparts_pp_rejected_status_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $privatbank_paymentparts_pp_rejected_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
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
$('input[name=\'category_allowed\']').autocomplete({
    source: function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {		
          response($.map(json, function(item) {
            return {
              label: item['name'],
						  value: item['category_id']
            }
          }));
        }
      });
    }, 
    select: function(item) {
      $.ajax({
        url: 'index.php?route=catalog/category/productsAutocomplete&token=<?php echo $token; ?>&filter_category_id=' +  encodeURIComponent(item['value']),
        dataType: 'json',
        success: function(data) {          
          $.each(data, function(index, item) {
            $('#product-allowed' + item.product_id).remove();
            $('#product-allowed').append('<div id="product-allowed' + item.product_id + '"><i class="fa fa-minus-circle"></i> ' + item.name + '<input type="hidden" name="privatbank_paymentparts_pp_product_allowed[]" value="' + item.product_id + '" /></div>');
			
			$('#enabled_selected').prop('disabled',true);
			$('#enabled_all').attr('checked', 'checked');
			$('#enabled_all').parent().trigger('click');
          });  
        }
      });
      return false;
    },
    focus: function(event, ui) {
        return false;
    }
});
$('input[name=\'allowed\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
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
		$('input[name=\'allowed\']').val('');
		$('#product-allowed' + item['value']).remove();
		$('#product-allowed').append('<div id="product-allowed' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="privatbank_paymentparts_pp_product_allowed[]" value="' + item['value'] + '" /></div>');
		
		$('#enabled_selected').prop('disabled',true);
		$('#enabled_all').attr('checked', 'checked');
		$('#enabled_all').parent().trigger('click');
	}
});
$('#product-allowed').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
	
	if ($('#product-allowed').html().trim() === '') {
		$('#enabled_selected').prop('disabled',false);
	}
});
//--></script>
<?php echo $footer; ?>