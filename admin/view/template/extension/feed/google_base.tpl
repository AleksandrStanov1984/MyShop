<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="button" id="button-import" data-toggle="tooltip" title="<?php echo $button_import; ?>" class="btn btn-success"><i class="fa fa fa-upload"></i></button>
        <button type="submit" form="form-google-base" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_import; ?> <button type="button" class="close" data-dismiss="alert">×</button></div>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-google-base" class="form-horizontal">
            <div id="category"></div>
            <br />
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-data-feed"><?php echo $entry_google_category; ?></label>
              <div class="col-sm-10">
                  <input type="text" name="google_base_category" value="" placeholder="<?php echo $entry_google_category; ?>" id="input-google-category" class="form-control" />
                  <input type="hidden" name="google_base_category_id" value="" />
                  <div class="input-group">
                    <input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />
                    <input type="hidden" name="category_id" value="" />
                    <span class="input-group-btn"><button type="button" id="button-category-add" data-toggle="tooltip" title="<?php echo $button_category_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></button></span>
                  </div>
              </div>
            </div>
            <div id="category_sz"></div>
            <br />
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-data-feed">Категории сайта для google</label>
              <div class="col-sm-10">
                  <input type="text" name="google_base_category_sz" value="" placeholder="<?php echo $entry_google_category; ?>" id="input-google-category-sz" class="form-control" />
                  <input type="hidden" name="google_base_category_id_sz" value="" />
                  <div class="input-group">
                    <input type="text" name="category_sz" value="" placeholder="<?php echo $entry_category; ?>" id="input-category-sz" class="form-control" />
                    <input type="hidden" name="category_id_sz" value="" />
                    <span class="input-group-btn"><button type="button" id="button-category-add-sz" data-toggle="tooltip" title="<?php echo $button_category_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></button></span>
                  </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-field">Категории</label>
            
              <div class="col-sm-10">
                <?php $class = 'odd'; ?>
                <?php foreach ($categories as $category) { ?>
                <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                <div class="<?php echo $class; ?>">
                  <?php if (in_array($category['category_id'], $google_base_categories)) { ?>
                  <input type="checkbox" name="google_base_categories[]" value="<?php echo $category['category_id']; ?>" checked="checked" class="form-control" style="display: inline-block; margin-right: 10px;" />
                  <?php echo $category['name']; ?>
                  <?php } else { ?>
                  <input type="checkbox" name="google_base_categories[]" value="<?php echo $category['category_id']; ?>" class="form-control" style="display: inline-block; margin-right: 10px;" />
                  <?php echo $category['name']; ?>
                  <?php } ?>
                </div>
                <?php } ?>
                <br>
                <a class="btn btn-primary" onclick="$(this).parent().find(':checkbox').attr('checked', true);">Выделить все</a>
                <a class="btn btn-primary" onclick="$(this).parent().find(':checkbox').attr('checked', false);">Снять выделение</a></td>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-data-feed"><?php echo $entry_data_feed; ?></label>
              <div class="col-sm-10">
                <textarea rows="5" id="input-data-feed" class="form-control" readonly><?php echo $data_feed; ?></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
              <div class="col-sm-10">
                <select name="google_base_status" id="input-status" class="form-control">
                  <?php if ($google_base_status) { ?>
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
  <script type="text/javascript"><!--
// Google Category
$('input[name=\'google_base_category\']').autocomplete({
    'source': function(request, response) {
      $.ajax({
        url: 'index.php?route=extension/feed/google_base/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {
          response($.map(json, function(item) {
            return {
              label: item['name'],
              value: item['google_base_category_id']
            }
          }));
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      });
    },
    'select': function(item) {
      $(this).val(item['label']);
      $('input[name=\'google_base_category_id\']').val(item['value']);
  }
});

// SZ Category for Google
$('input[name=\'google_base_category_sz\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/category/autocomplete&sz&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['category_id']
          }
        }));
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  },
  'select': function(item) {
      $(this).val(item['label']);
      $('input[name=\'google_base_category_id_sz\']').val(item['value']);
  }

});

// Category
$('input[name=\'category\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['category_id']
					}
				}));
			},
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
	},
	'select': function(item) {
      $(this).val(item['label']);
      $('input[name="category_id"]').val(item['value']);
    }
});

$('#category').delegate('.pagination a', 'click', function(e) {
	e.preventDefault();

	$('#category').load(this.href);
});

$('#category').load('index.php?route=extension/feed/google_base/category&token=<?php echo $token; ?>');

$('#button-category-add').on('click', function() {
	$.ajax({
		url: 'index.php?route=extension/feed/google_base/addcategory&token=<?php echo $token; ?>',
		type: 'post',
		dataType: 'json',
		data: 'google_base_category_id=' + $('input[name=\'google_base_category_id\']').val() + '&category_id=' + $('input[name=\'category_id\']').val(),
		beforeSend: function() {
			$('#button-category-add').button('loading');
		},
		complete: function() {
			$('#button-category-add').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#category').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('#category').load('index.php?route=extension/feed/google_base/category&token=<?php echo $token; ?>');

				$('#category').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('input[name=\'category\']').val('');
          $('input[name=\'category_id\']').val('');
          $('input[name=\'google_base_category\']').val('');
          $('input[name=\'google_base_category_id\']').val('');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#category').delegate('.btn-danger', 'click', function() {
	var node = this;

	$.ajax({
		url: 'index.php?route=extension/feed/google_base/removecategory&token=<?php echo $token; ?>',
		type: 'post',
		data: 'category_id=' + encodeURIComponent(this.value),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$(node).button('loading');
		},
		complete: function() {
			$(node).button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			// Check for errors
			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

      if (json['success']) {
				$('#category').load('index.php?route=extension/feed/google_base/category&token=<?php echo $token; ?>');

				$('#category').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

// Category SZ
$('input[name=\'category_sz\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/category/autocomplete&sz&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['category_id']
          }
        }));
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  },
  'select': function(item) {
      $(this).val(item['label']);
      $('input[name="category_id_sz"]').val(item['value']);
    }
});

$('#category_sz').delegate('.pagination a', 'click', function(e) {
  e.preventDefault();

  $('#category_sz').load(this.href);
});

$('#category_sz').load('index.php?route=extension/feed/google_base/categorysz&token=<?php echo $token; ?>');

$('#button-category-add-sz').on('click', function() {
  $.ajax({
    url: 'index.php?route=extension/feed/google_base/addcategory&token=<?php echo $token; ?>',
    type: 'post',
    dataType: 'json',
    data: 'google_base_category_id=' + $('input[name=\'google_base_category_id_sz\']').val() + '&sz=1&category_id=' + $('input[name=\'category_id_sz\']').val(),
    beforeSend: function() {
      $('#button-category-add-sz').button('loading');
      console.log($('input[name=\'google_base_category_id_sz\']').val());
      console.log($('input[name=\'category_id_sz\']').val());
    },
    complete: function() {
      $('#button-category-add-sz').button('reset');
    },
    success: function(json) {
      $('.alert').remove();

      if (json['error']) {
        $('#category_sz').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
      }

      if (json['success']) {
        $('#category_sz').load('index.php?route=extension/feed/google_base/categorysz&token=<?php echo $token; ?>');

        $('#category_sz').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

        $('input[name=\'category_sz\']').val('');
          $('input[name=\'category_id_sz\']').val('');
          $('input[name=\'google_base_category_sz\']').val('');
          $('input[name=\'google_base_category_id_sz\']').val('');
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});

$('#category_sz').delegate('.btn-danger', 'click', function() {
  var node = this;

  $.ajax({
    url: 'index.php?route=extension/feed/google_base/removecategory&sz&token=<?php echo $token; ?>',
    type: 'post',
    data: 'category_id=' + encodeURIComponent(this.value),
    dataType: 'json',
    crossDomain: true,
    beforeSend: function() {
      $(node).button('loading');
    },
    complete: function() {
      $(node).button('reset');
    },
    success: function(json) {
      $('.alert').remove();

      // Check for errors
      if (json['error']) {
        $('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
      }

      if (json['success']) {
        $('#category_sz').load('index.php?route=extension/feed/google_base/categorysz&token=<?php echo $token; ?>');

        $('#category_sz').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});

$('#button-import').on('click', function() {
	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=extension/feed/google_base/import&token=<?php echo $token; ?>',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('#button-import').button('loading');
				},
				complete: function() {
					$('#button-import').button('reset');
				},
				success: function(json) {
					$('.alert').remove();

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
		}
	}, 500);
});
//--></script>
</div>
<?php echo $footer; ?>
