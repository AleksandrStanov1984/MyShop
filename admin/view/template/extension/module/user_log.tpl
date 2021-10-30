<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
			<a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo $view_log; ?>" data-original-title="<?php echo $button_view_log; ?>"><i class="fa fa-eye"></i></a>
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
	<?php if (isset($success)) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
	<?php } ?>
    <div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
		</div>
		<div class="panel-body">
			<ul class="nav nav-tabs" id="user_log_tabs">
				<li><a href="#tab-settings" data-toggle="tab"><?php echo $tab_settings; ?></a></li>
				<li><a href="#tab-help" data-toggle="tab"><?php echo $tab_help; ?></a></li>
			</ul>
            <div class="tab-content">
				<div class="tab-pane" id="tab-settings">
					<form action="<?php echo $action; ?>" method="post" id="form" class="form-horizontal">
						<div class="buttons">
							<button onclick="$('#form').attr('action', '<?php echo $action_apply; ?>'); $('#form').submit();" class="btn btn-primary" title="<?php echo $button_save; ?>" type="submit" data-original-title="<?php echo $button_save; ?>"><i class="fa fa-refresh"></i></button>
							<button onclick="$('#form').submit();"class="btn btn-primary" title="<?php echo $button_save_quit; ?>" type="submit" data-toggle="tooltip" data-original-title="<?php echo $button_save_quit; ?>"><i class="fa fa-save"></i></button>
							<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
						</div>
						<?php $enabled_disabled = array(
							0 => $text_disabled,
							1 => $text_enabled,
						); ?>
						<div class="form-group">
							<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $entry_user_log_enable_help; ?>"><?php echo $entry_user_log_enable; ?></span></label>
							<div class="col-sm-10">
								<select name="user_log_enable" class="form-control">
									<?php foreach ($enabled_disabled as $key => $value) { ?>
										<option value="<?php echo $key; ?>" <?php echo ($key == $user_log_enable)? 'selected="selected"':'' ?>><?php echo $value; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $entry_user_log_login_help; ?>"><?php echo $entry_user_log_login; ?></span></label>
							<div class="col-sm-10">
								<select name="user_log_login" class="form-control">
									<?php foreach ($enabled_disabled as $key => $value) { ?>
										<option value="<?php echo $key; ?>" <?php echo ($key == $user_log_login)? 'selected="selected"':'' ?>><?php echo $value; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $entry_user_log_logout_help; ?>"><?php echo $entry_user_log_logout; ?></span></label>
							<div class="col-sm-10">
								<select name="user_log_logout" class="form-control">
									<?php foreach ($enabled_disabled as $key => $value) { ?>
										<option value="<?php echo $key; ?>" <?php echo ($key == $user_log_logout)? 'selected="selected"':'' ?>><?php echo $value; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $entry_user_log_failedlog_help; ?>"><?php echo $entry_user_log_failedlog; ?></span></label>
							
							<div class="col-sm-10">
								<select name="user_log_failed" class="form-control">
									<?php foreach ($enabled_disabled as $key => $value) { ?>
										<option value="<?php echo $key; ?>" <?php echo ($key == $user_log_failed)? 'selected="selected"':'' ?>><?php echo $value; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $entry_user_log_access_help; ?>"><?php echo $entry_user_log_access; ?></span></label>
							<div class="col-sm-10">
								<div class="col-sm-5">
								<select name="user_log_access" class="form-control">
									<?php foreach ($enabled_disabled as $key => $value) { ?>
										<option value="<?php echo $key; ?>" <?php echo ($key == $user_log_access)? 'selected="selected"':'' ?>><?php echo $value; ?></option>
									<?php } ?>
								</select>
								</div>
								<div class="col-sm-5">
								<div class="well well-sm" style="height: 150px; overflow: auto;">
									<?php foreach ($users as $user) { ?>
									<div>
									<label>
										<?php if (in_array($user['user_id'], $user_log_access_list)) { ?>
										<input type="checkbox" name="user_log_access_list[]" value="<?php echo $user['user_id']; ?>" checked="checked" />
										<?php } else { ?>
										<input type="checkbox" name="user_log_access_list[]" value="<?php echo $user['user_id']; ?>" />
										<?php } ?>
										<?php echo $user['username']; ?>
									</label>
									</div>
									<?php } ?>
								</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $entry_user_log_modify_help; ?>"><?php echo $entry_user_log_modify; ?></span></label>
							<div class="col-sm-10">
								<div class="col-sm-5">
								<select name="user_log_modify" class="form-control">
									<?php foreach ($enabled_disabled as $key => $value) { ?>
										<option value="<?php echo $key; ?>" <?php echo ($key == $user_log_modify)? 'selected="selected"':'' ?>><?php echo $value; ?></option>
									<?php } ?>
								</select>
								</div>
								<div class="col-sm-5">
								<div class="well well-sm" style="height: 150px; overflow: auto;">
									<?php foreach ($users as $user) { ?>
									<div>
									<label>
										<?php if (in_array($user['user_id'], $user_log_modify_list)) { ?>
										<input type="checkbox" name="user_log_modify_list[]" value="<?php echo $user['user_id']; ?>" checked="checked" />
										<?php } else { ?>
										<input type="checkbox" name="user_log_modify_list[]" value="<?php echo $user['user_id']; ?>" />
										<?php } ?>
										<?php echo $user['username']; ?>
									</label>
									</div>
									<?php } ?>
								</div>
								</div>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-2 control-label"><?php echo $entry_user_log_display; ?></label>
							<div class="col-sm-10">
								<input type="text" name="user_log_display" class="form-control"  value="<?php echo $user_log_display; ?>" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"><?php echo $entry_log_day; ?></label>
							<div class="col-sm-10">
								<input type="text" name="user_log_day" class="form-control"  value="<?php echo $user_log_day; ?>" />
							</div>
						</div>
					</form>
				</div>
				<div class="tab-pane" id="tab-help">

					<div><? echo $text_help; ?></div>
					<div>
							<? echo $text_description; ?>
					</div>
				</div>
				
			</div>
		</div>
	</div>
  </div>
  <script type="text/javascript"><!--
$('#user_log_tabs a:first').tab('show');
//--></script></div>

<?php echo $footer; ?>