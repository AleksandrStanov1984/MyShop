<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-rememberme" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-rememberme" class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-rememberme_enable"><?php echo $entry_status; ?></label>
								<div class="col-sm-10">
								<?php $checked = ($rememberme_enable)? 'checked="checked"':''; ?>
									<label class="switcher" title="<?php echo $entry_status; ?>">
									<input name="rememberme_enable" value="1" type="checkbox" <?php echo $checked; ?>>
									<span><span></span></span></label>							
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-rememberme_expires"><?php echo $entry_expires; ?></label>
								<div class="col-sm-10">
									<input name="rememberme_expires" value="<?php echo $rememberme_expires; ?>" type="text" class="form-control"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-rememberme_default"><?php echo $entry_default; ?></label>
								<div class="col-sm-10">
								<?php $checked = ($rememberme_default)? 'checked="checked"':''; ?>
									<label class="switcher" title="<?php echo $entry_default; ?>">
									<input name="rememberme_default" value="1" type="checkbox" <?php echo $checked; ?>>
									<span><span></span></span></label>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label" for="input-rememberme_shadow"><?php echo $entry_shadow; ?></label>
								<div class="col-sm-10">
								<?php $checked = ($rememberme_shadow)? 'checked="checked"':''; ?>
									<label class="switcher" title="<?php echo $entry_shadow; ?>">
									<input name="rememberme_shadow" value="1" type="checkbox" <?php echo $checked; ?>>
									<span><span></span></span></label>
								<div><?php echo $help_shadow; ?></div>
								</div>
								
							</div>
				</form>
			</div>
		</div>
	</div>
</div>
<style>
label.switcher input[type="checkbox"] {display:none}
label.switcher input[type="checkbox"] + span {position:relative;display:inline-block;vertical-align:middle;width:36px;height:17px;margin:0 5px 0 0;background:#ccc;border:solid 1px #999;border-radius:10px;box-shadow:inset 0 1px 2px #999;cursor:pointer;transition:all ease-in-out .2s;}
label.switcher input[type="checkbox"]:checked + span {background:#8fbb6c;border:solid 1px #7da35e;}
label.switcher input[type="checkbox"]:checked + span span {right:0;left:auto}
label.switcher span span{position:absolute;background:white;height:17px;width:17px;display:inlaine-box;left:0;top:-1px;border-radius:50%}
</style>
<script>

$('[data-insert-pattern]').on('click', function() {
	var data_id = $(this).attr('data-id');
	var data_insert_pattern = $(this).attr('data-insert-pattern');
	$('#' + data_id).val($('#'+ data_id).val() + data_insert_pattern);
});
</script>

<?php echo $footer; ?>