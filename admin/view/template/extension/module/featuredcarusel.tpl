<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-featuredcarusel" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-featuredcarusel" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-displaytitle"><?php echo $entry_displaytitle; ?></label>
            <div class="col-sm-10">
              <select name="displaytitle" id="input-displaytitle" class="form-control">
                <?php if ($displaytitle) { ?>
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
            <div class="col-sm-2">
              <label class="control-label"><?php echo $entry_display; ?></label><br />
              <label for="tab1" data="products" class="tab"><input name="tab[]" type="radio" value="1" id="tab1"<?php if ($tab == '1') { echo ' checked="checked"'; } ?> /><?php echo $tab_product; ?></label><br />
              <label for="tab2" data="categories" class="tab"><input name="tab[]" type="radio" value="2" id="tab2"<?php if ($tab == '2') { echo ' checked="checked"'; } ?> /><?php echo $tab_category; ?></label>
            </div>

            <div class="col-sm-10 bl-display<?php if ($tab == '1') { echo ' active'; } ?>" id="products">
              <input type="text" name="product" value="" placeholder="<?php echo $entry_product; ?>" id="input-product" class="form-control" />
              <div id="featuredcarusel-product" class="well well-sm" style="height: 150px; overflow: auto;">
                <?php foreach ($products as $product) { ?>
                  <div id="featuredcarusel-product<?php echo $product['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product['name']; ?>
                    <input type="hidden" name="product[]" value="<?php echo $product['product_id']; ?>" />
                  </div>
                <?php } ?>
              </div>
            </div>

            <div class="col-sm-10 bl-display<?php if ($tab == '2') { echo ' active'; } ?>" id="categories">
              <select name="category" class="form-control">
                <option value="0">Категория товара</option>
                <?php foreach ($categories as $category) { ?>
                <?php if ($category['category_id']==$scategory) { ?>
                  <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                <?php } else { ?>
                  <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option> 
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>








          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-limit"><?php echo $entry_limit; ?></label>
            <div class="col-sm-10">
              <input type="text" name="limit" value="<?php echo $limit; ?>" placeholder="<?php echo $entry_limit; ?>" id="input-limit" class="form-control" />
            </div>
          </div>
           <div class="form-group">
            <label class="col-sm-2 control-label" for="input-items"><?php echo $entry_items; ?></label>
            <div class="col-sm-10">
              <input type="text" name="items" value="<?php echo $items; ?>" placeholder="<?php echo $entry_items; ?>" id="input-items" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-width"><?php echo $entry_width; ?></label>
            <div class="col-sm-10">
              <input type="text" name="width" value="<?php echo $width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-width" class="form-control" />
              <?php if ($error_width) { ?>
              <div class="text-danger"><?php echo $error_width; ?></div>
              <?php } ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-height"><?php echo $entry_height; ?></label>
            <div class="col-sm-10">
              <input type="text" name="height" value="<?php echo $height; ?>" placeholder="<?php echo $entry_height; ?>" id="input-height" class="form-control" />
              <?php if ($error_height) { ?>
              <div class="text-danger"><?php echo $error_height; ?></div>
              <?php } ?>
            </div>
          </div>
          

      

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-prodview"><?php echo $entry_prodview; ?></label>
            <div class="col-sm-10">
              <select name="prodview" id="input-prodview" class="form-control">
                <?php if ($prodview == 2) { ?>
                <option value="0"><?php echo $text_pstandart; ?></option>
                <option value="1"><?php echo $text_nodeskmore; ?></option>
                <option value="2" selected="selected"><?php echo $text_nodesc; ?></option>
                <option value="3"><?php echo $text_deskmore; ?></option>
                <?php } else if ($prodview == 1) { ?>
                <option value="0"><?php echo $text_pstandart; ?></option>
                <option value="1" selected="selected"><?php echo $text_nodeskmore; ?></option>
                <option value="2"><?php echo $text_nodesc; ?></option>
                <option value="3"><?php echo $text_deskmore; ?></option>
                 <?php } else if ($prodview == 3) { ?>
                <option value="0"><?php echo $text_pstandart; ?></option>
                <option value="1"><?php echo $text_nodeskmore; ?></option>
                <option value="2"><?php echo $text_nodesc; ?></option>
                <option value="3" selected="selected"><?php echo $text_deskmore; ?></option>
                <?php } else  { ?>
                <option value="0" selected="selected"><?php echo $text_pstandart; ?></option>
                <option value="1"><?php echo $text_nodeskmore; ?></option>
                <option value="2"><?php echo $text_nodesc; ?></option>
                <option value="3"><?php echo $text_deskmore; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

           <div class="form-group">
            <label class="col-sm-2 control-label" for="input-class"><?php echo $text_class; ?></label>
            <div class="col-sm-10">
              <input type="text" name="class" value="<?php echo $class; ?>" placeholder="<?php echo $text_class; ?>" id="input-class" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <style>
    .bl-display {display: none;}
    .bl-display.active {display: block;}
  </style>
  <script type="text/javascript"><!--
$('input[name=\'product\']').autocomplete({
	source: function(request, response) {
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
	select: function(item) {
		$('input[name=\'product\']').val('');
		
		$('#featuredcarusel-product' + item['value']).remove();
		
		$('#featuredcarusel-product').append('<div id="featuredcarusel-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product[]" value="' + item['value'] + '" /></div>');	
	}
});
	
$('#featuredcarusel-product').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});

$('.tab').on('click', function() {
  var dispid = $(this).attr('data');
  $('.bl-display').removeClass('active');
  $('#'+dispid).addClass('active');

});
//--></script></div>
<?php echo $footer; ?>