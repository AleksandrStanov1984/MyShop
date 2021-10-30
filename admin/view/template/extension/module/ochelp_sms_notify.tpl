<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-sms-notify" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
					<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-sms-notify" class="form-horizontal">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab-sms" data-toggle="tab"><?php echo $tab_sms; ?></a></li>
							<li><a href="#tab-template" data-toggle="tab"><?php echo $tab_template; ?></a></li>
							<li><a href="#tab-setting" data-toggle="tab"><?php echo $tab_setting; ?></a></li>
							<li><a href="#tab-gate-setting" data-toggle="tab"><?php echo $tab_gate_setting; ?></a></li>
							<li><a href="#tab-log" data-toggle="tab"><?php echo $tab_log; ?></a></li>
							<li><a href="#tab-support" data-toggle="tab"><?php echo $tab_support; ?></a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab-sms">
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-client-phone"><span data-toggle="tooltip" title="<?php echo $help_phone; ?>"><?php echo $entry_client_phone; ?></span></label>
									<div class="col-sm-10">
										<input type="text" name="custom_client_phone" id="input-custom-client-phone" class="form-control" value="" placeholder="<?php echo $text_phone_placeholder; ?>" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-client-template"><?php echo $entry_client_sms; ?></label>
									<div class="col-sm-10">
										<input  type="text" name="custom_client_sms" id="input-custom-client-sms" class="form-control" value="" />
									</div>
								</div>
								<?php if($sms_template) { ?>
								<div class="col-sm-12 well well-lg">
									<?php echo $sms_template; ?>
								</div>
								<?php } ?>
								<div class="form-group">
									<div class="col-sm-12 text-right">
										<button type="button" id="button-send" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-paper-plane"></i> <?php echo $button_send; ?></button>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab-template">
								<div class="col-sm-12">
									<h3><?php echo $entry_admin_template; ?></h3>
								</div>
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<td></td>
											<td><?php echo $entry_template; ?></td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<div class="well well-lg">
													<?php echo $help_admin_template; ?>
												</div>
											</td>
											<td> <textarea name="sms_notify_admin_template" id="input-admin-template" class="form-control" cols="80" rows="3"><?php echo $admin_template ? $admin_template : ''; ?></textarea></td>
										</tr>
									</tbody>
								</table>
								<div class="col-sm-12">
									<h3><?php echo $entry_client_template; ?></h3>
								</div>
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<td></td>
											<td><?php echo $entry_template; ?></td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<div class="well well-lg">
													<?php echo $help_client_template; ?>
												</div>
											</td>
											<td> <textarea name="sms_notify_client_template" id="input-client-template" class="form-control" cols="80" rows="3"><?php echo $client_template ? $client_template : ''; ?></textarea></td>
										</tr>
									</tbody>
								</table>
								<div class="col-sm-12">
									<h3><?php echo $entry_order_status_template; ?></h3>
									<div class="well well-lg">
										<?php echo $help_template; ?>
									</div>
								</div>
								<?php if ($order_statuses) { ?>
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<td><?php echo $entry_order_status; ?></td>
											<td><?php echo $entry_template; ?></td>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($order_statuses as $order_status) { ?>
											<?php if ($order_status && $order_status_template && isset($order_status_template[$order_status['order_status_id']])) { ?>
											<tr>
												<td><?php echo $order_status['name']; ?></td>
												<td><textarea name="sms_notify_status_template[<?php echo $order_status['order_status_id']; ?>]" id="input-order-status-template<?php echo $order_status['order_status_id']; ?>" class="form-control" cols="80" rows="3"><?php echo $order_status_template[$order_status['order_status_id']]; ?></textarea></td>
											</tr>
											<?php }else{ ?>
											<tr>
												<td><?php echo $order_status['name']; ?></td>
												<td><textarea name="sms_notify_status_template[<?php echo $order_status['order_status_id']; ?>]" id="input-order-status-template<?php echo $order_status['order_status_id']; ?>" class="form-control" cols="80" rows="3"></textarea></td>
											</tr>
											<?php } ?>
										<?php } ?>
									</tbody>
								</table>
								<?php } ?>
							</div>
							<div class="tab-pane" id="tab-setting">
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-admin-alert"><?php echo $entry_admin_alert; ?></label>
									<div class="col-sm-10">
										<select name="sms_notify_admin_alert" id="input-admin-alert" class="form-control">
											<?php if ($admin_alert) { ?>
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
									<label class="col-sm-2 control-label" for="input-client-alert"><?php echo $entry_client_alert; ?></label>
									<div class="col-sm-10">
										<select name="sms_notify_client_alert" id="input-client-alert" class="form-control">
											<?php if ($client_alert) { ?>
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
									<label class="col-sm-2 control-label" for="input-order-alert"><?php echo $entry_order_alert; ?></label>
									<div class="col-sm-10">
										<select name="sms_notify_order_alert" id="input-order-alert" class="form-control">
											<?php if ($order_alert) { ?>
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
									<label class="col-sm-2 control-label" for="input-sms-notify-order-status"><span data-toggle="tooltip" title="<?php echo $help_order_status; ?>"><?php echo $entry_order_status; ?></span></label>
									<div class="col-sm-10">
										<div class="well well-sm" style="height: 150px; overflow: auto;">
											<?php foreach ($order_statuses as $order_status) { ?>
											<div class="checkbox">
												<label>
													<?php if (in_array($order_status['order_status_id'], $sms_order_status)) { ?>
													<input type="checkbox" name="sms_notify_order_status[]" value="<?php echo $order_status['order_status_id']; ?>" checked="checked" />
													<?php echo $order_status['name']; ?>
													<?php } else { ?>
													<input type="checkbox" name="sms_notify_order_status[]" value="<?php echo $order_status['order_status_id']; ?>" />
													<?php echo $order_status['name']; ?>
													<?php } ?>
												</label>
											</div>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-sms-template"><?php echo $entry_sms_template; ?></label>
									<div class="col-sm-10">
										<textarea name="sms_notify_sms_template" id="input-sms-template" class="form-control" cols="80" rows="5"><?php echo $sms_template ? $sms_template : ''; ?></textarea>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab-gate-setting">
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-template"><?php echo $entry_sms_gatename; ?></label>
									<div class="col-sm-10">
										<select name="sms_notify_gatename" id="input-template" class="form-control">
											<?php foreach ($sms_gatenames as $sms_gatename) { ?>
											<?php if ($sms_notify_gatename == $sms_gatename) { ?>
											<option value="<?php echo $sms_gatename; ?>" selected="selected"><?php echo $sms_gatename; ?></option>
											<?php } else { ?>
											<option value="<?php echo $sms_gatename; ?>"><?php echo $sms_gatename; ?></option>
											<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-sms-notify-from"><span data-toggle="tooltip" title="<?php echo $help_sms_from; ?>"><?php echo $entry_sms_from; ?></span></label>
									<div class="col-sm-10">
										<input type="text" name="sms_notify_from" value="<?php echo $sms_notify_from; ?>" placeholder="<?php echo $entry_sms_from; ?>" id="input-sms-notify-from" class="form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-sms-notify-to"><span data-toggle="tooltip" title="<?php echo $help_phone; ?>"><?php echo $entry_sms_to; ?></span></label>
									<div class="col-sm-10">
										<input type="text" name="sms_notify_to" value="<?php echo $sms_notify_to; ?>" placeholder="<?php echo $entry_sms_to; ?>" id="input-sms-notify-to" class="form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-sms-notify-copy"><span data-toggle="tooltip" title="<?php echo $help_sms_copy; ?>"><?php echo $entry_sms_copy; ?></span></label>
									<div class="col-sm-10">
										<textarea name="sms_notify_copy" rows="5" placeholder="<?php echo $entry_sms_copy; ?>" id="input-sms-notify-copy" class="form-control"><?php echo $sms_notify_copy; ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-sms-gate-username"><?php echo $entry_sms_gate_username; ?></label>
									<div class="col-sm-10">
										<input type="text" name="sms_notify_gate_username" value="<?php echo $sms_notify_gate_username; ?>" placeholder="<?php echo $entry_sms_gate_username; ?>" id="input-sms-gate-username" class="form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="input-sms-notify-gate-password"><?php echo $entry_sms_gate_password; ?></label>
									<div class="col-sm-10">
										<input type="password" name="sms_notify_gate_password" value="<?php echo $sms_notify_gate_password; ?>" placeholder="<?php echo $entry_sms_gate_password; ?>" id="input-sms-notify-gate-password" class="form-control" />
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tab-log">
								<fieldset>
									<div class="form-group">
										<label class="col-sm-2 control-label" for="input-sms-log"><?php echo $entry_sms_log; ?></label>
										<div class="col-sm-4">
											<select name="sms_notify_log" id="input-sms-log" class="form-control">
												<?php if ($sms_notify_log) { ?>
												<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
												<option value="0"><?php echo $text_disabled; ?></option>
												<?php } else { ?>
												<option value="1"><?php echo $text_enabled; ?></option>
												<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-sm-4">
											<button type="button" id="button-clear-log" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger"><i class="fa fa-eraser"></i> <?php echo $button_clear; ?></button>
										</div>
									</div>
									<div class="panel-body">
										<textarea wrap="off" rows="15" readonly class="form-control"><?php echo $sms_log; ?></textarea>
									</div>
								</fieldset>
							</div>
							<div class="tab-pane" id="tab-support">
									<div class="panel-body">
										<?php echo $help_support; ?>
									</div>
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
$('#button-send').on('click', function() {
  $.ajax({
    url: 'index.php?route=extension/module/ochelp_sms_notify/sendSms&token=<?php echo $token; ?>',
    type: 'post',
    data: 'sms_message=' + $('#input-custom-client-sms').val() + '&phone=' + $('#input-custom-client-phone').val(),
    dataType: 'json',
    crossDomain: true,
    beforeSend: function() {
    $('#button-send').button('loading');
    },
    complete: function() {
    $('#button-send').button('reset');
    },
    success: function(json) {
    $('.success, .warning').remove();

    if (json['error']) {
    $('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    }

    if (json['success']) {
    $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    }
    },
    error: function(xhr, ajaxOptions, thrownError) {
    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});

$('#button-clear-log').on('click', function() {
  $.ajax({
    url: 'index.php?route=extension/module/ochelp_sms_notify/clearLog&token=<?php echo $token; ?>',
    dataType: 'json',
    crossDomain: true,
    beforeSend: function() {
    $('#button-clear-log').button('loading');
    },
    complete: function() {
    $('#button-clear-log').button('reset');
    },
    success: function(json) {
    $('.success, .warning').remove();

    if (json['error']) {
    $('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    }

    if (json['success']) {
    $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

      location.reload();  
    }
    },
    error: function(xhr, ajaxOptions, thrownError) {
    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});
//-->
</script>
<?php if ($ckeditor) { ?>
<script type="text/javascript"><!--
ckeditorInit('input-sms-template', '<?php echo $token; ?>');
//-->
</script>
<?php } else { ?>
  <script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
  <link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
  <script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>
  <script type="text/javascript"><!--
  $('#input-sms-template').summernote({
    height: 150,
      lang:'<?php echo $lang; ?>'
  });
  //-->
</script>
<?php } ?>
<?php echo $footer; ?>