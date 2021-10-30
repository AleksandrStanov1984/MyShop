<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
					<a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo $action_settings; ?>" data-original-title="<?php echo $button_settings; ?>"><i class="fa fa-cog"></i></a>
					<a class="btn btn-warning" title="" data-toggle="tooltip" href="<?php echo $clear_action; ?>" data-original-title="<?php echo $button_clear; ?>"><i class="fa fa-eraser"></i></a>
					<button onclick="confirm('<?php echo $text_confirm; ?>') ? $('#records').submit() : false;" class="btn btn-danger" title="" data-toggle="tooltip" type="button" data-original-title="<?php echo $button_delete; ?>"><i class="fa fa-trash-o"></i></button>					
      </div>
      <h1><?php echo $heading_log; ?></h1>
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
	<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
		<button type="button" class="close" data-dismiss="alert">&times;</button>
	</div>
	<?php } ?>
  
	<div class="panel panel-body">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_action_list;?></h3>
		</div>  

		<form action="<?php echo $delete_action; ?>" method="post" id="records">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-sx-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<div class="pull-right" style="margin-bottom:20px">
								<a class="btn btn-info" id="clear_filters"><i class="fa fa-remove"></i> <?php echo $text_clear_filtres; ?></a>
								<a class="btn btn-primary" id="apply_filters"><i class="fa fa-refresh"></i> <?php echo $text_apply_filtres; ?></a>
							</div>
							<thead>
								<tr class="active">
									<td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
									<td class="left"><?php echo $column_user; ?></td>
									<td class="left"><?php echo $column_action; ?></td>
									<td class="left"><?php echo $column_result; ?></td>
									<td class="left"><?php echo $column_url; ?></td>
									<td class="left">Действие</td>
									<td class="left"><?php echo $column_ip; ?></td>
									<td class="left"><?php echo $column_date; ?></td>
								</tr>
								<tr class="info filter">
									<td></td>
									<td><select name="filter_user_id" class="form-control">
											<option value=""></option>
											<?php foreach ($users as $user) { ?>
											<option value="<?php echo $user['user_id'];?>"<?php echo ($filter_user_id == $user['user_id'])? ' selected="selected"':''; ?>><?php echo $user['username']; ?></option>
											<?php } ?>
                                    </select></td>
									<td></td>
									<td><select name="filter_action" class="form-control">
										<option value=""></option>
                                            <option value="1"<?php echo ($filter_action == '1')? ' selected="selected"':''; ?>>Good</option>
                                            <option value="0"<?php echo ($filter_action == '0')? ' selected="selected"':''; ?>>Failed</option>
                                    </select></td>
									<td><input name="filter_url" class="form-control" value="<?php echo $filter_url; ?>" /></td>
									<td></td>
									<td></td>
									<td>
                                        <div class="input-horizontal input-group date">
											<input type="text" class="form-control" data-format="YYYY-MM-DD" placeholder="YYYY-MM-DD" name="filter_start" value="<?php echo $filter_start; ?>">
											<span class="input-group-btn">
												<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
											</span>
										</div>
                                        <div class="input-horizontal">
											&nbsp;to&nbsp;
										</div>
										<div class="input-horizontal input-group date">
											<input type="text" class="form-control" data-format="YYYY-MM-DD" placeholder="YYYY-MM-DD" name="filter_end" value="<?php echo $filter_end; ?>">
											<span class="input-group-btn">
												<button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
											</span>
										</div>
									</td>
								</tr>								
							</thead>
							<?php if ($records) { ?>
							<tbody>
								<?php foreach ($records as $record) { ?>
									<?php $class = $record['result']? '': 'class="failed"'; ?>
								<tr <?php echo $class; ?>>
									<td style="text-align: center;"><input type="checkbox" name="selected[]" value="<?php echo $record['user_log_id']; ?>" /></td>
									<td class="left"><a href="<?php echo $record['user']; ?>" target="_blank"><?php echo $record['user_name']; ?></a></td>
									<td class="left"><?php echo $record['action']; ?></td>
									<td class="left"><?php echo $record['result']; ?></td>
									<td class="left"><?php echo $record['url']; ?></td>
									<td class="left"><?php echo $record['action_descr']; ?></td>
						            <td class="left"><?php echo $record['ip']; ?></td>
									<td class="left"><?php echo date("Y-m-d H:i:s", strtotime($record['date'])); ?></td>
								</tr>
								<?php } ?>
							<?php } else { ?>
								<tr>
									<td class="center" colspan="7"><?php echo $text_no_results; ?></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</form>
		<div class="row">
			<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
			<div class="col-sm-6 text-right"><?php echo $result; ?></div>
		</div>		
	</div>
  </div>
</div>
<script type="text/javascript"><!--
function get_filters() {
	var result = [];
	if ($('select[name="filter_user_id"]').val() != "") {
		result.push("filter_user_id=" + $('select[name="filter_user_id"]').val());
	}
	if ($('select[name="filter_action"]').val() != "") {
		result.push("filter_action=" + $('select[name="filter_action"]').val());
	}
	if ($('input[name="filter_start"]').val() != "") {
		result.push("filter_start=" + $('input[name="filter_start"]').val());
	}

	if ($('input[name="filter_url"]').val() != "") {
		result.push("filter_url=" + $('input[name="filter_url"]').val());
	}

	if ($('input[name="filter_end"]').val() != "") {
		result.push("filter_end=" + $('input[name="filter_end"]').val());
	}
	return result.length ? '&' + result.join('&') : '';
}
function clear_filters(callback){
	$('.filter select, .filter input').val('');
	location = '?route=tool/user_log&token=<?php echo $token; ?>';
//	if (callback) callback();
}
$('#apply_filters').click(function(e) {
	e.preventDefault();
	e.stopPropagation();
	var href = '?route=tool/user_log&token=<?php echo $token; ?>' + get_filters();
	location = href;
});
$('#clear_filters').click(function(e) {
	e.preventDefault();
	e.stopPropagation();
	clear_filters()
});
	
//--></script>
			
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false,
	format: 'YYYY-MM-DD'
});
//--></script>
<?php echo $footer; ?>