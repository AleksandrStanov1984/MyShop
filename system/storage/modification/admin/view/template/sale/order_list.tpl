<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">

		<?php if ($aqe_enabled) { ?><label for="batch_edit" class="hidden" id="batch-edit-container"><input type="checkbox" id="batch-edit"<?php echo ($batch_edit) ? ' checked' : ''; ?>> <?php echo $text_batch_edit; ?></label><?php } ?>
			
        <button type="submit" id="button-shipping" form="form-order" formaction="<?php echo $shipping; ?>" formtarget="_blank" data-toggle="tooltip" title="<?php echo $button_shipping_print; ?>" class="btn btn-info"><i class="fa fa-truck"></i></button>
        <button type="submit" id="button-invoice" form="form-order" formaction="<?php echo $invoice; ?>" formtarget="_blank" data-toggle="tooltip" title="<?php echo $button_invoice_print; ?>" class="btn btn-info"><i class="fa fa-print"></i></button>
        <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" id="button-delete" form="form-order" formaction="<?php echo $delete; ?>" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
      </div>
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

		<?php if ($aqe_enabled) { ?>
  <div class="alerts">
    <div class="container-fluid" id="alerts">
    </div>
  </div>
		<?php } ?>
			
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-order-id"><?php echo $entry_order_id; ?></label>
                <input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" placeholder="<?php echo $entry_order_id; ?>" id="input-order-id" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-customer"><?php echo $entry_customer; ?></label>
                <input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
                <select name="filter_order_status" id="input-order-status" class="form-control">
                  <option value="*"></option>
                  <?php if ($filter_order_status == '0') { ?>
                  <option value="0" selected="selected"><?php echo $text_missing; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_missing; ?></option>
                  <?php } ?>
                  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $filter_order_status) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-total"><?php echo $entry_total; ?></label>
                <input type="text" name="filter_total" value="<?php echo $filter_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-date-modified"><?php echo $entry_date_modified; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_modified" value="<?php echo $filter_date_modified; ?>" placeholder="<?php echo $entry_date_modified; ?>" data-date-format="YYYY-MM-DD" id="input-date-modified" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <form method="post" action="" enctype="multipart/form-data" id="form-order">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked).trigger('change');" /></td>
                  <td class="text-right"><?php if ($sort == 'o.order_id') { ?>
                    <a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_order; ?>"><?php echo $column_order_id; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'customer') { ?>
                    <a href="<?php echo $sort_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_customer; ?>"><?php echo $column_customer; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'order_status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php if ($sort == 'o.total') { ?>
                    <a href="<?php echo $sort_total; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_total; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_total; ?>"><?php echo $column_total; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'o.date_added') { ?>
                    <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'o.date_modified') { ?>
                    <a href="<?php echo $sort_date_modified; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_modified; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_modified; ?>"><?php echo $column_date_modified; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($orders) { ?>
                <?php foreach ($orders as $order) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($order['order_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" />
                    <?php } ?>
                    <input type="hidden" name="shipping_code[]" value="<?php echo $order['shipping_code']; ?>" /></td>
                  <td class="text-right"><?php echo $order['order_id']; ?></td>
                  <td class="text-left"><?php echo $order['customer']; ?></td>
                  <?php if ($aqe_enabled) { ?>
		<td class="<?php echo $column_info["status"]['align']; ?><?php echo ($column_info["status"]['qe_status']) ? ' ' . $column_info["status"]['type'] : ''; ?>" id="<?php echo "status-" . $order['order_id']; ?>"><?php echo $order["order_status"]; ?></td>
		<?php } else { ?>
		<td class="text-left"><?php echo $order['order_status']; ?></td>
		<?php } ?>
                  <td class="text-right"><?php echo $order['total']; ?></td>
                  <td class="text-left"><?php echo $order['date_added']; ?></td>
                  <td class="text-left"><?php echo $order['date_modified']; ?></td>
                  <td class="text-right"><a href="<?php echo $order['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a> <a href="<?php echo $order['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
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
    </div>
  </div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	url = 'index.php?route=sale/order&token=<?php echo $token; ?>';

	var filter_order_id = $('input[name=\'filter_order_id\']').val();

	if (filter_order_id) {
		url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
	}

	var filter_customer = $('input[name=\'filter_customer\']').val();

	if (filter_customer) {
		url += '&filter_customer=' + encodeURIComponent(filter_customer);
	}

	var filter_order_status = $('select[name=\'filter_order_status\']').val();

	if (filter_order_status != '*') {
		url += '&filter_order_status=' + encodeURIComponent(filter_order_status);
	}

	var filter_total = $('input[name=\'filter_total\']').val();

	if (filter_total) {
		url += '&filter_total=' + encodeURIComponent(filter_total);
	}

	var filter_date_added = $('input[name=\'filter_date_added\']').val();

	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}

	var filter_date_modified = $('input[name=\'filter_date_modified\']').val();

	if (filter_date_modified) {
		url += '&filter_date_modified=' + encodeURIComponent(filter_date_modified);
	}

	location = url;
});
//--></script>
  <script type="text/javascript"><!--
$('input[name=\'filter_customer\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=customer/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['customer_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_customer\']').val(item['label']);
	}
});
//--></script>
  <script type="text/javascript"><!--
$('input[name^=\'selected\']').on('change', function() {
	$('#button-shipping, #button-invoice').prop('disabled', true);

	var selected = $('input[name^=\'selected\']:checked');

	if (selected.length) {
		$('#button-invoice').prop('disabled', false);
	}

	for (i = 0; i < selected.length; i++) {
		if ($(selected[i]).parent().find('input[name^=\'shipping_code\']').val()) {
			$('#button-shipping').prop('disabled', false);

			break;
		}
	}
});

$('#button-shipping, #button-invoice').prop('disabled', true);

$('input[name^=\'selected\']:first').trigger('change');

// IE and Edge fix!
$('#button-shipping, #button-invoice').on('click', function(e) {
	$('#form-order').attr('action', this.getAttribute('formAction'));
});

$('#button-delete').on('click', function(e) {
	$('#form-order').attr('action', this.getAttribute('formAction'));

	if (confirm('<?php echo $text_confirm; ?>')) {
		$('#form-order').submit();
	} else {
		return false;
	}
});
//--></script> 
  <script src="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <link href="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div>

		<?php if ($aqe_enabled) { ?>
		<script type="text/javascript"><!--
		!function(t,e){t.batch_edit=parseInt("<?php echo (int)$batch_edit; ?>"),t.texts=e.extend({},t.texts,{error_ajax_request:"<?php echo addslashes($error_ajax_request); ?>"}),e(function(){e(".status_qe").editable(function(i,o){var a=e("#notify",this).is(":checked")?1:0,n={notify:a};return t.quick_update(this,i,o,"<?php echo $update_url; ?>",n).done(e.proxy(t.update_finished,{column:e(this).attr("id").split("-")[0]})).fail(e.proxy(t.update_failed,this)),o.indicator},{type:"status_edit",data:"<?php echo trim($status_select); ?>",indicator:"<?php echo $text_saving; ?>",tooltip:"<?php echo $aqe_tooltip; ?>",event:"<?php echo $aqe_quick_edit_on; ?>",onblur:"cancel",notify_customer_text:"<?php echo $text_notify_customer; ?>",notify_customer:parseInt("<?php echo (int)$notify_customer; ?>")})})}(window.bull5i=window.bull5i||{},jQuery);
		//--></script>
		<?php } ?>
			

					<!-- START Shipping Data -->
					<style>
						.btn-novaposhta {
							color: #333;
							background-color: #ff392e;
							border-color: #ccc;
						}
						.btn-light-novaposhta {
							color: #333;
							background-color: #fff;
							border-color: #ff392e;
						}
						.btn-ukrposhta {
							color: #333;
							background-color: #ffce2f;
							border-color: #ccc;
						}
						.btn-light-ukrposhta {
							color: #333;
							background-color: #fff;
							border-color: #ffce2f;
						}
					</style>
					<!-- START Modal assignment CN to order -->
					<div class="modal fade" id="assignment-cn-to-order" tabindex="-1" role="dialog" aria-labelledby="assignment-cn-to-order-label">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="assignment-cn-to-order-label"><?php echo $heading_cn; ?></h4>
								</div>
								<div class="modal-body">
									<div class="form-group clearfix">
										<input type="hidden" name="cn_order_id" value="" id="cn_order_id" />
										<input type="hidden" name="cn_shipping_method" value="" id="cn_shipping_method" />
										<label class="col-sm-2 control-label" for="cn_number"><?php echo $entry_cn_number; ?></label>
										<div class="col-sm-10">
											<input type="text" name="cn_number" value="" placeholder="<?php echo $entry_cn_number; ?>" id="cn_number" class="form-control" />
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary" onclick="assignmentCN();"><i class="fa fa-check"></i></button>
									<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i></button>
								</div>
							</div>
						</div>
					</div>
					<!-- END Modal assignment CN to order -->

					<script type="text/javascript"><!--
						function deleteCN(self, shipping_method) {
							var post_data = 'order_id=' + $(self).parents('tr').find('input[name^="selected"]').val();

							$.ajax( {
								url: 'index.php?route=extension/shipping/' + shipping_method + '/deleteCNFromOrder&token=<?php echo $token; ?>',
								type: 'POST',
								data: post_data,
								dataType: 'json',
								beforeSend: function () {
									$('body').fadeTo('fast', 0.7).prepend('<div id="ocmax-loader" style="position: fixed; top: 50%;	left: 50%; z-index: 9999;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
								},
								complete: function () {
									var $alerts = $('.alert-danger, .alert-success');

									if ($alerts.length !== 0) {
										setTimeout(function() { $alerts.fadeOut() }, 5000);
									}

									$('body').fadeTo('fast', 1)
									$('#ocmax-loader').remove();
								},
								success: function(json) {
									if(json['error']) {
										$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
									}

									if (json['success']) {
										$('.container-fluid:eq(1)').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

										setTimeout(function() {
												location.reload();
											},
											2000
										);
									}

									$('html, body').animate({ scrollTop: 0 }, 'slow');
								},
								error: function (jqXHR, textStatus, errorThrown) {
									console.log(textStatus);
								}
							} );
						}

						function assignmentCN(self, shipping_method) {
							if (typeof(self) !== 'undefined') {
								$('#cn_order_id').val($(self).parents('tr').find('input[name^="selected"]').val());
							}

							if (shipping_method) {
								$('#cn_shipping_method').val(shipping_method);
							}

							if ($('#assignment-cn-to-order').is(':hidden')) {
								$('#assignment-cn-to-order').modal('show');
							} else {
								var post_data = 'order_id=' + $('#cn_order_id').val() + '&cn_number=' + $('#cn_number').val();

								$.ajax( {
									url: 'index.php?route=extension/shipping/' + $('#cn_shipping_method').val() + '/addCNToOrder&token=<?php echo $token; ?>',
									type: 'POST',
									data: post_data,
									dataType: 'json',
									beforeSend: function () {
										$('body').fadeTo('fast', 0.7).prepend('<div id="ocmax-loader" style="position: fixed; top: 50%;	left: 50%; z-index: 9999;"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
									},
									complete: function () {
										var $alerts = $('.alert-danger, .alert-success');

										if ($alerts.length !== 0) {
											setTimeout(function() { $alerts.fadeOut() }, 5000);
										}

										$('body').fadeTo('fast', 1)
										$('#ocmax-loader').remove();
									},
									success: function(json) {
										if(json['error']) {
											$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
										}

										if (json['success']) {
											$('.container-fluid:eq(1)').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

											setTimeout(function() {
													location.reload();
												},
												2000
											);
										}

										$('html, body').animate({ scrollTop: 0 }, 'slow');
									},
									error: function (jqXHR, textStatus, errorThrown) {
										console.log(textStatus);
									}
								} );

								$('#assignment-cn-to-order').modal('hide');
							}
						}

						$(function() {
							var post_data = $('input[name^="selected"]');

							$.ajax( {
								url: 'index.php?route=sale/order/getShippingData&token=<?php echo $token; ?>',
								type: 'POST',
								data: post_data,
								dataType: 'json',
								success: function(json) {
									if(json['error']) {
										$('.container-fluid:eq(1)').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

										$('html, body').animate({ scrollTop: 0 }, 'slow');
									}

									if (json instanceof Object) {
										if (json['shipping_methods']) {
											var btn_l = '<div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-list-ul"></i> <span class="caret"></span></button><ul class="dropdown-menu dropdown-menu-right">';

											for (var i in json['shipping_methods']) {
												btn_l += '<li class="dropdown-header">' + json['shipping_methods'][i]['heading'] + '</li>';

												if (json['shipping_methods'][i]['cn_list']) {
													btn_l += '<li><a href="' + json['shipping_methods'][i]['cn_list']['href'] + '">' + json['shipping_methods'][i]['cn_list']['text'] + '</a></li>';
												}

												btn_l += '<li role="separator" class="divider"></li>';
											}

											btn_l += '</ul></div> ';

											$('div.container-fluid div.pull-right:last').prepend(btn_l);
										}

										for (var i in json['orders']) {
											var
												c       = 0,
												f       = false,
												b_class = '',
												btn_o   = '<div class="btn-group"><button type="button" id="button-cn-' + i + '" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span class="caret"></span></button><ul class="dropdown-menu dropdown-menu-right">';

											btn_o += '<li class="dropdown-header">' + json['heading_cn'] + '</li>';
											btn_o += '<li role="separator" class="divider"></li>';

											for (var ii in json['orders'][i]) {
												c++;

												btn_o += '<li class="dropdown-header">' + json['shipping_methods'][ii]['heading'] + '</li>';

												if (json['orders'][i][ii]['create']) {
													btn_o += '<li><a href="' + json['orders'][i][ii]['create']['href'] + '">' + json['orders'][i][ii]['create']['text'] + '</a></li>';
												}

												if (json['orders'][i][ii]['edit']) {
													f = true;
													btn_o += '<li><a href="' + json['orders'][i][ii]['edit']['href'] + '">' + json['orders'][i][ii]['edit']['text'] + '</a></li>';
												}

												if (json['orders'][i][ii]['delete']) {
													f = true;
													btn_o += '<li><a style="cursor: pointer;" onclick="deleteCN(this, \'' + ii + '\');">' + json['orders'][i][ii]['delete']['text'] + '</a></li>';
												}

												if (json['orders'][i][ii]['assignment']) {
													btn_o += '<li><a style="cursor: pointer;" onclick="assignmentCN(this, \'' + ii + '\');">' + json['orders'][i][ii]['assignment']['text'] + '</a></li>';
												}

												btn_o += '<li role="separator" class="divider"></li>';

												if (f) {
													b_class = 'btn-' + ii;

													continue;
												} else {
													b_class = 'btn-light-' + ii;
												}
											}

											btn_o += '</ul></div> ';

											$('input[value="' + i + '"]').parents('tr').find('td:last').prepend(btn_o);

											if (c != 1) {
												if (f) {
													b_class = 'btn-info';
												} else {
													b_class = 'btn-default';
												}
											}

											$('input[value="' + i + '"]').parents('tr').find('[id^="button-cn"]').addClass(b_class);
										}
									}
								},
								error: function (jqXHR, textStatus, errorThrown) {
									console.log(textStatus);
								}
							} );
						} );
					//--></script>
					<!-- END Shipping Data -->
    			
<?php echo $footer; ?>