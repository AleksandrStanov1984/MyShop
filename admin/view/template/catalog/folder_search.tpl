<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
		<?php if ($error_warning) { ?>
		<?php foreach($error_warning as $error) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
				<?php echo '<b>'.$error['target'] . '</b>['.$languages[$error['language_id']]['name'].'] id:' . $error['product_id'] . ', '. $error['name']; ?>,
		*недопустимые символы. Добавьте их в таблицу аналогов.
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php } ?>
		
      
		
    
      <div class="pull-right">
        <span class="msg" style="margin-right: 100px;font-weight: bold;color: #002924;"></span>
        <a href="javascript:;" data-toggle="tooltip" title="" class="btn btn-info refresh" data-original-title="Проиндексировать"><i class="fa fa-refresh"></i></a>
        <button type="submit" form="form-attribute" data-toggle="tooltip" title="Сохранить" class="btn btn-primary"><i class="fa fa-save"></i></button>
        </div>
      <h1>Фонетический поиск</h1>
      
    </div>
  </div>
  
  <script>
        var count = 1;
        $(document).on('click', '.refresh', function(){
            $.ajax({
              url: '/admin/index.php?route=catalog/folder_search/clear_table&token=<?php echo $token; ?>',
              type: 'get',
              dataType: 'text',
              success: function (json) {
                console.log('start'+ json);
                setTimeout(function(){reload_product();},200);
              },
            });
        });
        
        function reload_product(){
          $.ajax({
            url: '/admin/index.php?route=catalog/folder_search/reload_product&token=<?php echo $token; ?>',
            type: 'get',
            dataType: 'text',
            success: function (json) {
             //console.log(json);
              if(json == ''){
                count = count + 100;
                //console.log(count);
                $('.msg').html('Обработано - ' + count);
                setTimeout(function(){reload_product();},50);
              }else{
                $('.msg').html(json);
                console.log(json);
              }
              
              
              
            },
          });
        }
        
      </script>
  
  <div class="container-fluid">

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> Настройки индексации</h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-attribute" class="form-horizontal">

		<div class="col-sm-4">
          <div class="form-group">
            <label class="col-sm-10 control-label" for="input-active">Включить поиск</label>
            <div class="col-sm-2">
				<?php if($active){ ?>
                    <input type="checkbox" name="active" value="1" checked="checked" id="input-active"/>
				<?php }else{ ?>
					<input type="checkbox" name="active" value="1"  id="input-active"/>
				<?php } ?>
            </div>
          </div>

           <div class="form-group">
            <label class="col-sm-10 control-label" for="input-name">Искать в имени</label>
            <div class="col-sm-2">
				<?php if($name){ ?>
                    <input type="checkbox" name="name" value="1" checked="checked"  id="input-name"/>
				<?php }else{ ?>
					<input type="checkbox" name="name" value="1"  id="input-name"/>
				<?php } ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-10 control-label" for="input-description">Искать в описаниях</label>
            <div class="col-sm-2">
				<?php if($description){ ?>
                    <input type="checkbox" name="description" value="1" checked="checked"  id="input-description"/>
				<?php }else{ ?>
					<input type="checkbox" name="description" value="1"  id="input-description"/>
				<?php } ?>
            </div>
          </div>

         <div class="form-group">
            <label class="col-sm-10 control-label" for="input-tag">Искать в Тегах</label>
            <div class="col-sm-2">
				<?php if($tag){ ?>
                    <input type="checkbox" name="tag" value="1" checked="checked"  id="input-tag"/>
				<?php }else{ ?>
					<input type="checkbox" name="tag" value="1"  id="input-tag"/>
				<?php } ?>
            </div>
          </div>

         <div class="form-group">
            <label class="col-sm-10 control-label" for="input-meta_title">Искать в meta_title</label>
            <div class="col-sm-2">
				<?php if($meta_title){ ?>
                    <input type="checkbox" name="meta_title" value="1" checked="checked"  id="input-meta_title"/>
				<?php }else{ ?>
					<input type="checkbox" name="meta_title" value="1"  id="input-meta_title"/>
				<?php } ?>
            </div>
          </div>

         <div class="form-group">
            <label class="col-sm-10 control-label" for="input-meta_description">Искать в meta_description</label>
            <div class="col-sm-2">
				<?php if($meta_description){ ?>
                    <input type="checkbox" name="meta_description" value="1" checked="checked"  id="input-meta_description"/>
				<?php }else{ ?>
					<input type="checkbox" name="meta_description" value="1"  id="input-meta_description"/>
				<?php } ?>
            </div>
          </div>

         <div class="form-group">
            <label class="col-sm-10 control-label" for="input-meta_keyword">Искать в meta_keyword</label>
            <div class="col-sm-2">
				<?php if($meta_keyword){ ?>
                    <input type="checkbox" name="meta_keyword" value="1" checked="checked" id="input-meta_keyword"/>
				<?php }else{ ?>
					<input type="checkbox" name="meta_keyword" value="1" id="input-meta_keyword"/>
				<?php } ?>
            </div>
          </div>
		</div>
		<div class="col-sm-2">&nbsp;</div>
		<div class="col-sm-6">
			<label class="col-sm-12 control-label" for="input-meta_keyword">Таблица аналогов сомвола в латинском звучании</label>
			
			<?php $count = 0; ?>
			<table id="language" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left">Найти</td>
                      <td class="text-left">Заменить</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
					
			<?php foreach($language as $index => $row){ ?>
				
				<tr id="language-row<?php echo $count; ?>">
				  <td class="text-left" style="width: 40%;">
					<input type="text" name="language[<?php echo $count; ?>][ru]" value="<?php echo $row['ru']; ?>" class="form-control" />
				  </td>
				  <td class="text-left" style="width: 40%;">
					<input type="text" name="language[<?php echo $count; ?>][en]" value="<?php echo $row['en']; ?>" class="form-control" />
				  </td>
				  <td class="text-left"><button type="button" onclick="$('#language-row<?php echo $count; ?>').remove();" data-toggle="tooltip" title="Удалить" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
				</tr>
		
			<?php $count++; ?>
			<?php } ?>
			
			</tbody>
			<tfoot>
			  <tr>
				<td colspan="2"></td>
				<td class="text-left"><button type="button" onclick="addLanguage();" data-toggle="tooltip" title="Добавить строку" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
			  </tr>
			</tfoot>
		  </table>
		</div>

        </form>
      </div>
    </div>
	<small><a href="https://skillcode.ru" target="_blank">Phonetic search (c) Folder (AKA) Kotlyarov Sergey</a></small>
  </div>
  
</div>

  <script type="text/javascript"><!--
var count = <?php echo $count; ?>;

function addLanguage() {
    html  = '<tr id="language-row' + count + '">';
	html += '  <td class="text-left" style="width: 40%;"><input type="text" name="language[' + count + '][ru]" value="" class="form-control" /></td>';
	html += '  <td class="text-left" style="width: 40%;"><input type="text" name="language[' + count + '][en]" value="" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#language-row' + count + '\').remove();" data-toggle="tooltip" title="Удалить" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
    html += '</tr>';

	$('#language tbody').append(html);

	//attributeautocomplete(attribute_row);

	count++;
}
  </script>

<?php echo $footer; ?>

