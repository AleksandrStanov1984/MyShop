<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
		<a href="javascript:;" title="<?php echo $button_add; ?>" class="btn btn-primary show_tag"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger"
		onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-tag').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-tag">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
					<td style="width: 1px;" class="text-center">
						<input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked).trigger('change');" />
					</td>
					<td class="text-left">
						<?php if ($sort == 'tag') { ?>
							<a href="<?php echo $sort_tag; ?>" class="<?php echo strtolower($order); ?>">Покажем клиенту</a>
						<?php } else { ?>
							<a href="<?php echo $sort_tag; ?>">Покажем клиенту</a>
						<?php } ?>
					</td>
					<td class="text-left">
						<?php if ($sort == 'search') { ?>
							<a href="<?php echo $sort_search; ?>" class="<?php echo strtolower($order); ?>"><Tag>Будем искать</a>
						<?php } else { ?>
							<a href="<?php echo $sort_search; ?>">Будем искать</a>
						<?php } ?>
					</td>
					<td class="text-left">
						<?php if ($sort == 'view') { ?>
							<a href="<?php echo $sort_view; ?>" class="<?php echo strtolower($order); ?>">View</a>
						<?php } else { ?>
							<a href="<?php echo $sort_view; ?>">View</a>
						<?php } ?>
					</td>
					<td class="text-left">
						<?php if ($sort == 'sort_order') { ?>
						  <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>">Sort</a>
						<?php } else { ?>
							<a href="<?php echo $sort_sort_order; ?>">Sort</a>
						<?php } ?>
					</td>
					<td class="text-left">
						<?php if ($sort == 'status') { ?>
						  <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>">St</a>
						<?php } else { ?>
							<a href="<?php echo $sort_status; ?>">St</a>
						<?php } ?>
					</td>
					<td class="text-left">
						<?php if ($sort == 'date_added') { ?>
						  <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>">Add</a>
						<?php } else { ?>
							<a href="<?php echo $sort_date_added; ?>">Add</a>
						<?php } ?>
					</td>
					<td class="text-left">
						<?php if ($sort == 'date_modified') { ?>
						  <a href="<?php echo $sort_date_modified; ?>" class="<?php echo strtolower($order); ?>">Mdf</a>
						<?php } else { ?>
							<a href="<?php echo $sort_date_modified; ?>">Mdf</a>
						<?php } ?>
					</td>
					<td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($tags) { ?>
                <?php foreach ($tags as $tag) { ?>
                <tr id="tag<?php echo $tag['tag_id']; ?>">
                  <td class="text-center"><?php if (in_array($tag['tag_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $tag['tag_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $tag['tag_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $tag['tag']; ?></td>
                  <td class="text-left"><?php echo $tag['search']; ?></td>
                  <td class="text-left"><?php echo $tag['view']; ?></td>
                  <td class="text-left"><?php echo $tag['sort_order']; ?></td>
                  <td class="text-left"><?php echo $tag['status']; ?></td>
                  <td class="text-left"><?php echo $tag['date_added']; ?></td>
                  <td class="text-left"><?php echo $tag['date_modified']; ?></td>
                  <td class="text-right">
					<a href="javascript:;" onClick="editTag('<?php echo $tag['tag_id']; ?>');" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary edit_row"><i class="fa fa-pencil"></i></a>
				  </td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="7"><?php echo $text_no_results; ?></td>
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


	<div class="panel-back"></div>
	<div class="panel panel-default edit_form">
		<div class="panel-heading">
		  <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
		</div>
		<div class="panel-body">
		  <form action="" method="post" enctype="multipart/form-data" id="form_tag" class="form-horizontal">
			
			<input type="hidden" name="tag_id" id="tag_id" value=""/>
			
			<div class="form-group required">
			  <label class="col-sm-2 control-label" for="input-tag">Покажем клиенту</label>
			  <div class="col-sm-10">
				<input type="text" name="tag" value="" placeholder="" id="input-tag" class="form-control" />
			  </div>
			</div>
			
			<div class="form-group required">
			  <label class="col-sm-2 control-label" for="input-search">Будем искать</label>
			  <div class="col-sm-10">
				<input type="text" name="search" value="" placeholder="" id="input-search" class="form-control" />
			  </div>
			</div>
			
			<div class="form-group">
			  <label class="col-sm-2 control-label" for="input-view">View</label>
			  <div class="col-sm-10">
				<input type="text" name="view" value="" placeholder="" id="input-view" class="form-control" />
			  </div>
			</div>
			
			<div class="form-group">
			  <label class="col-sm-2 control-label" for="input-sort_order">Sort</label>
			  <div class="col-sm-10">
				<input type="text" name="sort_order" value="" placeholder="" id="input-sort_order" class="form-control" />
			  </div>
			</div>
			
			<div class="form-group">
			  <label class="col-sm-2 control-label" for="input-status">St</label>
			  <div class="col-sm-10">
				 <label class="radio-inline">
              <input type="checkbox" name="status" id="input-status" value="1" /> Включено
					</label>
			  </div>
			</div>
			
			<div class="form-group col-sm-12">
				<div class="col-sm-4 pull-right">
					<a href="javascript:;" title="<?php echo $button_add; ?>" class="btn btn-primary add_tag"><i class="fa fa-plus"></i> <?php echo $button_add; ?></a>
				</div>
				<div class="col-sm-4 pull-left">
					<a href="javascript:;" title="<?php echo $button_edit; ?>" class="btn btn-primary edit_tag"><i class="fa fa-pencil"></i> <?php echo $button_edit; ?></a>
				</div>
			</div>
		  </form>
		</div>
    </div>

	<script>
		function popup_show(){
			$('.panel-back').show();
			$('.edit_form').show();
		}
		function popup_hide(){
			$('.panel-back').hide();
			$('.edit_form').hide();
		}
		
		$(document).on('click', '.show_tag', function(){
			$('input[name="tag_id"]').val(0);
      $('#input-status').attr('checked', 'checked');
      $('#input-tag').val('');
		  $('#input-search').val('');
			$('#input-view').val('0');
			$('#input-sort_order').val('0');
				
			popup_show();
		});
		$(document).on('click', '.panel-back', function(){
			popup_hide();
		});
		

		function editTag(tag_id){
			$.ajax({
				url: 'index.php?route=catalog/tag/gettag&tag_id='+tag_id+'&token=<?php echo $token; ?>',
				type: 'get',
				dataType: 'json',
				success: function (json) {
					
					$('#input-tag').val(json['tag']);
					$('#input-search').val(json['search']);
					$('#input-view').val(json['view']);
					$('#input-sort_order').val(json['sort_order']);
					$('#tag_id').val(json['tag_id']);
					
          if(json['status'] == '1'){
            $('#input-status').attr('checked', 'checked');
          }else{
            $('#input-status').removeAttr('checked');
          }
						
					console.log('1');
					
					popup_show();
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(thrownError + " " + xhr.statusText + " " + xhr.responseText);
				}
			});
		}
	    
    
		$(document).on('click', '.add_tag', function(){
      console.log('add');
      
			$.ajax({
				url: 'index.php?route=catalog/tag/add&token=<?php echo $token; ?>',
				type: 'post',
				data: $('#form_tag').serialize(),
				dataType: 'json',
				success: function (json) {
          
          console.log(json);
          
          if(json.tag_id){
            
            html = '<tr id="tag'+json.tag_id+'"><td class="text-center"><input type="checkbox" name="selected[]" value="1"></td>';
            html += '<td class="text-left">' + json.tag + '</td>';
            html += '<td class="text-left">' + json.search + '</td>';
            html += '<td class="text-left">' + json.view + '</td>';
            html += '<td class="text-left">' + json.sort_order + '</td>';
            html += '<td class="text-left">' + json.status + '</td>';
            html += '<td class="text-left">' + json.date_added + '</td>';
            html += '<td class="text-left">' + json.date_modified + '</td>';
            html += '<td class="text-right">';
            html += '<a href="javascript:;" onclick="editTag(\''+json.tag_id+'\');" data-toggle="tooltip" title="" class="btn btn-primary edit_row" data-original-title="Редактировать"><i class="fa fa-pencil"></i></a>';
            html += '</td></tr>';
            $('table thead').append(html);
          }
          popup_hide();
					
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(thrownError + " " + xhr.statusText + " " + xhr.responseText);
				}
			});
		});

	$(document).on('click', '.edit_tag', function(){
      
      var tag_id = $('#tag_id').val();
			
      $.ajax({
				url: 'index.php?route=catalog/tag/edit&tag_id='+tag_id+'&token=<?php echo $token; ?>',
				type: 'post',
				data: $('#form_tag').serialize(),
				dataType: 'json',
				success: function (json) {
					console.log(json);
          
            html = '<td class="text-center"><input type="checkbox" name="selected[]" value="1"></td>';
            html += '<td class="text-left">' + json.tag + '</td>';
            html += '<td class="text-left">' + json.search + '</td>';
            html += '<td class="text-left">' + json.view + '</td>';
            html += '<td class="text-left">' + json.sort_order + '</td>';
            html += '<td class="text-left">' + json.status + '</td>';
            html += '<td class="text-left">' + json.date_added + '</td>';
            html += '<td class="text-left">' + json.date_modified + '</td>';
            html += '<td class="text-right">';
            html += '<a href="javascript:;" onclick="editTag(\''+json.tag_id+'\');" data-toggle="tooltip" title="" class="btn btn-primary edit_row" data-original-title="Редактировать"><i class="fa fa-pencil"></i></a>';
            html += '</td>';
            $('#tag'+tag_id+'').html(html);
          
          popup_hide();
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(thrownError + " " + xhr.statusText + " " + xhr.responseText);
				}
			});
		});


		
	</script>

	<style>
		.edit_form{
      display: none;
			width: 60%;
			background: #3c3c3c;
			color: white;
			border-radius: 1em;
			padding: 1em;
			position: fixed;
			top: 50%;
			left: 50%;
			margin-right: -50%;
			transform: translate(-50%, -50%);
			z-index: 1001;
		}
		.panel-back{
      display: none;
			width: 100vw;
			height: 100vh;
			position: fixed;
			top: 0;
			left: 0;
			z-index: 1000;
			background-color: black;
			opacity: 0.5;
		}
	</style>
	

<?php echo $footer; ?>
