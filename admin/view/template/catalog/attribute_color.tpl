<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        
    	   
	<link rel="stylesheet" type="text/css" href="<?php echo HTTPS_SERVER; ?>../system/library/spectrum/spectrum.css">
    <script type="text/javascript" src="<?php echo HTTPS_SERVER; ?>../system/library/spectrum/spectrum.js"></script>
	<script type="text/javascript" src="<?php echo HTTPS_SERVER; ?>../system/library/spectrum/i18n/jquery.spectrum-fi.js"></script>
  
	   
	   
	    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-attribute">
        <input type="hidden" name="group" id="group" value='0'>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center main-chkb">ColorID</td>
                  <td class="text-left" colspan="2">Цвет</td>
				  <td class="text-left" style="min-width: 150px;">Пример</td>
                  <td class="text-left" style="max-width: 250px;">Значение</td>
                </tr>
              </thead>
              <tbody>
                <?php if ($attributes) { ?>
                <?php foreach ($attributes as $attribute) { ?>
                <tr>
                  <td class="text-center attribute_color_id"><?php if(isset($attribute['color']['attribute_color_id'])){ echo $attribute['color']['attribute_color_id']; }else{ echo '0'; } ?></td>
                  <td class="text-left"><input type="text" class="color" value="<?php if(isset($attribute['color']['color'])){ echo trim($attribute['color']['color'],';').';'; }else{ echo ''; } ?>"></td>
                  <td><input type='color' name='color2' value='<?php if(isset($attribute['color']['color'])){ echo ''.trim($attribute['color']['color'],';').''; }else{ echo ''; } ?>' />
					<a href="javascript:;" data-toggle="tooltip" title="Заменить цвет" class="btn btn-default edit_color" data-original-title="Исправить"><i class="fa fa-refresh"></i></a>
					<a href="javascript:;" data-toggle="tooltip" title="Добавить цвет" class="btn btn-primary add_color" data-original-title="Добавить"><i class="fa fa-plus"></i></a>
				  </td>
				  <td
					<?php if(isset($attribute['color']['color'])){
						$color = explode(';',trim($attribute['color']['color'], ';'));
						
						if(count($color) > 1){
							$gradient = array();
							$step = (int)(100/count($color));
							$count = 0;
							
							foreach($color as $col){
								$gradient[] = $col.' '.(($count++)*$step).'%';
								$gradient[] = $col.' '.(($count)*$step).'%';
							}
							echo 'style="background: linear-gradient(90deg, '.implode(',',$gradient).');"';
						}else{
							echo 'style="background-color:'.$color[0].';"';
						}
						
					} ?>
				  ></td>
                  <td class="text-left text"><?php echo $attribute['text']; ?></td>
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
  
	$(document).on('click', '.add_color', function(){
		
		var color = $(this).parent('td').children('input').val();
		input = $(this).parent('td').parent('tr').find('.color');
		var old_color = input.val();
		input.val(old_color+color+';');
		
		input.trigger('change');
		
	});
	
	$(document).on('click', '.edit_color', function(){
		
		var color = $(this).parent('td').children('input').val();
		input = $(this).parent('td').parent('tr').find('.color');
		var old_color = input.val();
		input.val(color+';');

		input.trigger('change');

	});
	
	$(document).on('change', '.color', function(){
		var attribute_id = 15;
		var color = $(this).val();
		var text = $(this).parent('td').parent('tr').find('.text').html();
		row = $(this).parent('td').parent('tr');
		
		row.css('background-color','#95a876');
		setTimeout(function(){row.css('background-color','#fff');},1000);
		
		$.ajax({
			url: 'index.php?route=catalog/attribute_color/save&token=<?php echo $token; ?>&attribute_id=' +  encodeURIComponent(attribute_id)+'&color=' +  encodeURIComponent(color)+'&text=' +  encodeURIComponent(text),
			type: 'get',
			dataType: 'html',
			success: function (json) {
				console.log(json);
			},
		});
		
		console.log(color);
		console.log(text);
	});
</script>
<?php echo $footer; ?>
