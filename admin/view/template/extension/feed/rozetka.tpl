<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">	

		
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="input-field"><span data-toggle="tooltip" title=""><?php echo $entry_status; ?></span></label>
				 <div class="col-sm-10">
				 <select name="rozetka_status" id="input-status" class="form-control">
					<?php if ($rozetka_status) { ?>
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
				<label class="col-sm-2 control-label" for="input-field"><span data-toggle="tooltip" title=""><?php echo $entry_shopname; ?></span></label>
				<div class="col-sm-10">
				<input name="rozetka_shopname" type="text" value="<?php echo $rozetka_shopname; ?>" maxlength="20" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="input-field"><span data-toggle="tooltip" title="<?php echo $entry_company; ?>"><?php echo $entry_company; ?></span></label>
				 <div class="col-sm-10">
				 <input name="rozetka_company" type="text" value="<?php echo $rozetka_company; ?>" class="form-control"  />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="input-field"><span data-toggle="tooltip" title="<?php echo $help_delivery_name; ?>"><?php echo $entry_delivery_name; ?></span></label>
				<div class="col-sm-10">
				<input name="rozetka_delivery_desc" type="text" value="<?php echo $rozetka_delivery_desc; ?>" maxlength="160" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="input-field"><span data-toggle="tooltip" title=""><?php echo $entry_category; ?></span></label>
			
				<div class="col-sm-10">
					<?php $class = 'odd'; ?>
					<?php foreach ($categories as $category) { ?>
					<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
					<div class="<?php echo $class; ?>">
						<?php if (in_array($category['category_id'], $rozetka_categories)) { ?>
						<input type="checkbox" name="rozetka_categories[]" value="<?php echo $category['category_id']; ?>" checked="checked" class="form-control" style="display: inline-block; margin-right: 10px;" />
						<?php echo $category['name']; ?>
						<?php } else { ?>
						<input type="checkbox" name="rozetka_categories[]" value="<?php echo $category['category_id']; ?>" class="form-control" style="display: inline-block; margin-right: 10px;" />
						<?php echo $category['name']; ?>
						<?php } ?>
					</div>
					<?php } ?>
					<br>
					<a class="btn btn-primary" onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a>
					<a class="btn btn-primary" onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a></td>
				</div>
			</div>
			<div class="form-group" style="display: none;">
				<label class="col-sm-2 control-label" for="input-field"><span data-toggle="tooltip" title=""><?php echo $entry_currency; ?></span></label>
				<div class="col-sm-10">
				<select name="rozetka_currency" class="form-control">
					<?php foreach ($currencies as $currency) { ?>
					<?php if ($currency['code'] == $rozetka_currency) { ?>
					<option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo '(' . $currency['code'] . ') ' . $currency['title']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $currency['code']; ?>"><?php echo '(' . $currency['code'] . ') ' . $currency['title']; ?></option>
					<?php } ?>
					<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="input-field"><span data-toggle="tooltip" title=""><?php echo $entry_in_stock; ?></span></label>
                <div class="col-sm-10">
				<select name="rozetka_in_stock" class="form-control">
                    <?php foreach ($stock_statuses as $stock_status) { ?>
                    <?php if ($stock_status['stock_status_id'] == $rozetka_in_stock) { ?>
                    <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                    </select>
               </div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="input-field"><span data-toggle="tooltip" title=""><?php echo $entry_out_of_stock; ?></span></label>
                 <div class="col-sm-10">
				<select name="rozetka_out_of_stock" class="form-control">
                    <?php foreach ($stock_statuses as $stock_status) { ?>
                    <?php if ($stock_status['stock_status_id'] == $rozetka_out_of_stock) { ?>
                    <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                    </select>
                 </div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="input-field"><span data-toggle="tooltip" title=""><?php echo $entry_data_feed; ?></span></label>
				 <div class="col-sm-10">
				<a target="blank" href="<?php echo $data_feed; ?>" style="top: 10px;position: relative;"><?php echo $data_feed; ?></a>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="input-field"><span data-toggle="tooltip" title=""><?php echo $entry_data_prom_feed; ?></span></label>
				 <div class="col-sm-10">
				<a target="blank" href="<?php echo $data_prom_feed; ?>" style="top: 10px;position: relative;"><?php echo $data_prom_feed; ?></a>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="rozetka_percent_markup">
					<span data-toggle="tooltip" title="<?php echo $hint_rozetka_percent_markup; ?>"><?php echo $entry_rozetka_percent_markup; ?></span>
				</label>
				<div class="col-sm-10">
					<input class="form-control" type="number" step="0.001" min="0" id="rozetka_percent_markup" name="rozetka_percent_markup" value="<?php echo $rozetka_percent_markup; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="rozetka_percent_special_markup">
					<span data-toggle="tooltip" title="<?php echo $hint_rozetka_percent_special_markup; ?>"><?php echo $entry_rozetka_percent_special_markup; ?></span>
				</label>
				<div class="col-sm-10">
					<input class="form-control" type="number" step="0.001" min="0" id="rozetka_percent_special_markup" name="rozetka_percent_special_markup" value="<?php echo $rozetka_percent_special_markup; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="rozetka_markup_round_decimals">
					<span data-toggle="tooltip" title="<?php echo $hint_rozetka_markup_round_decimals; ?>"><?php echo $entry_rozetka_markup_round_decimals; ?></span>
				</label>
				<div class="col-sm-10">
					<input class="form-control" type="number" step="1" min="0" id="rozetka_markup_round_decimals" name="rozetka_markup_round_decimals" value="<?php echo $rozetka_markup_round_decimals; ?>">
				</div>
			</div>
				</form><div class="alert alert-info"><i class="fa fa-opencart"></i><em> Еще больше модулей для Opencart <?php echo VERSION; ?> на нашем сайте <a href="https://ocmod.net/?utm_source=module&utm_medium=admin&utm_campaign=<?php echo $heading_title; ?>" target="_blank">https://ocmod.net</a></em><button type="button" class="close" data-dismiss="alert">×</button></div>
		</div>
	</div>
</div>
</div>
<?php echo $footer; ?>