<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="Обьединить атрибуты" class="btn btn-success" onclick="confirm('Обьединить выбранные атрибуты?') ? group() : false;"><i class="fa fa-object-group"></i></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-attribute').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">


        <div class="well">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group col-sm-6">
                <label class="control-label" for="input-name">Поиск по имени атрибута (разделите слова && если вам нужно найти несколько разных атрибутов)</label>
                <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="Название атрибута" id="input-name" class="form-control" />
              </div>
              
              <div class="form-group col-sm-6 text-left">
                <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> <?php echo $button_filter; ?></button>
              </div>
            </div>
          </div>
        </div>
        
        
        
        
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-attribute">
        <input type="hidden" name="group" id="group" value='0'>
        <span class="row" style="margin-bottom: 10px;color: red;">
          <input type="checkbox" name="delete_product_value"/> Удалить атрибуты и удалить их значения у товаров
        </span>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center main-chkb"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'ad.name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'attribute_group') { ?>
                    <a href="<?php echo $sort_attribute_group; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_attribute_group; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_attribute_group; ?>"><?php echo $column_attribute_group; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php if ($sort == 'a.sort_order') { ?>
                    <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($attributes) { ?>
                <?php foreach ($attributes as $attribute) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($attribute['attribute_id'], $selected)) { ?>
                    <input data-name="<?php echo $attribute['name']; ?>" type="checkbox" name="selected[]" value="<?php echo $attribute['attribute_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input data-name="<?php echo $attribute['name']; ?>" type="checkbox" name="selected[]" value="<?php echo $attribute['attribute_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $attribute['name']; ?></td>
                  <td class="text-left"><?php echo $attribute['attribute_group']; ?></td>
                  <td class="text-right"><?php echo $attribute['sort_order']; ?></td>
                  <td class="text-right"><a href="<?php echo $attribute['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="5"><?php echo $text_no_results; ?></td>
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
</div>
<script>
  
  function group(){
    
    $( "input[type='checkbox']:checked" ).each(function( index ) {
    //console.log( $( this ).val() + ": " + $( this ).data('name') );
    
      $('.main-chkb').css('width', '100px');
    
      if(parseInt($( this ).val()) > 0){
        $(this).parent('td').append('<button class="btn btn-success" onclick="group_action('+$( this ).val() + ');" title="Я главный! Все в меня!"><i class="fa fa-link" aria-hidden="true"></i></button>');
      }
    });
  }
  function group_action(attribute_id){
    $('#group').val(attribute_id);
    $('#form-attribute').submit();
  }
  
  $('#button-filter').on('click', function() {
	var url = 'index.php?route=catalog/attribute&token=<?php echo $token; ?>';

	var filter_name = $('input[name=\'filter_name\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}


	location = url;
});
</script>
<?php echo $footer; ?>
