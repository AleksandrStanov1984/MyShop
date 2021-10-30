<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
					<a class="btn btn-primary" title="" data-toggle="tooltip" href="<?php echo $settings; ?>" data-original-title="<?php echo $button_settings; ?>"><i class="fa fa-cog"></i></a>
					<a class="btn btn-warning" title="" data-toggle="tooltip" href="<?php echo $clear; ?>" data-original-title="<?php echo $button_clear; ?>"><i class="fa fa-eraser"></i></a>
					<button onclick="$('#form').submit();" class="btn btn-primary" title="<?php echo $button_export; ?>" type="submit" data-original-title="<?php echo $button_export; ?>"><i class="fa fa-refresh"></i></button>
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
			<form action="<?php echo $export; ?>" method="post" id="form" class="form-horizontal"></form>
			<ul class="nav nav-tabs">
        <li class="active"><a href="#tab-general" data-toggle="tab">Все битые ссылки</a></li>
        <li><a href="#tab-banners" data-toggle="tab">Битые ссылки баннеров</a></li>
      </ul>
      <div class="tab-content">
      	<div class="tab-pane active" id="tab-general">
      		<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-sx-12">
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<thead>
										<tr class="active">
											<td class="text-left"><?php echo $column_time; ?></td>
											<td class="text-left"><?php echo $column_ip; ?></td>
											<td style="max-width:300px;" class="text-left"><?php echo $column_browser; ?></td>
											<td style="max-width:200px;" class="text-left"><?php echo $column_referer; ?></td>
											<td class="text-left"><?php echo $column_request; ?></td>
										</tr>
									</thead>
									<tbody>
									<?php if ($results) { ?>

										<?php foreach ($results as $row) { ?>
											<tr>
												<td class="text-left"><?php echo $row['date_record']; ?></td>
												<td class="text-left"><?php echo $row['ip']; ?></td>
												<td style="max-width:300px;" class="text-left"><?php echo $row['browser']; ?></td>
												<td style="max-width:200px; word-break: break-all;" class="text-left">
												
												<?php 				
												$row['referer'] = strip_tags($row['referer']);
												if (mb_strlen($row['referer'], 'utf-8') > 120) {
													$length = mb_strlen($row['referer'], 'utf-8');
													$short_referer = mb_substr($row['referer'], 0, 60, 'utf-8') . ' ... ' . mb_substr($row['referer'], ($length - 60/2), $length, 'utf-8');
												} else {
													$short_referer = $row['referer'];
												}
												?>
												<?php if ($short_referer != 'Referer not detected') { ?>
												<a href="<?php echo $row['referer']; ?>" target="_blank"><?php echo $short_referer; ?></a>
												<?php } else { ?>
												<?php echo $short_referer; ?>
												<?php } ?>
												
												
												</td>
												<td class="text-left"><?php echo $row['request_uri']; ?></td>
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
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
						<div class="col-sm-6 text-right"><?php echo $result; ?></div>
					</div>
      	</div>
      	<div class="tab-pane" id="tab-banners">
      		<div class="well">Всего ссылок для проверки <span style="font-weight:bold" id="total"><?php echo $total_banners; ?></span></div>
      		<div style="margin-bottom:15px"><button type="button" class="btn btn-primary" data-start="0" data-limit="25" data-total="<?php echo $total_banners; ?>" id="check-links">Проверить ссылки</button></div>
      		<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-sx-12">
							<div id="results"></div>
						</div>
					</div>
      	</div>
      </div>
					
	</div>
  </div>
</div>
<script>
	$(document).ready(function() {

		isFirstTime = true;
		checkComplete = false;
		totalBanners = $('#check-links').attr("data-total");
		totalCounter = $('#total').text();

		function sendRequest() {

			var startValue = $('#check-links').attr("data-start");
			var limitValue = $('#check-links').attr("data-limit");

			$.ajax({
				url: 'index.php?route=extension/module/broken_links/checkBanners&token=<?php echo $token; ?>&start=' +  encodeURIComponent(startValue) + '&limit=' +  encodeURIComponent(limitValue),
				type: 'get',
				cache: false,
				dataType: 'json',
				beforeSend: function() {
					$('#check-links').text('Идет проверка...');
				},
				complete: function() {
					if(checkComplete) {
						$('#check-links').text('Проверить ссылки');
					}
				},
				success: function(json) {

					var html = '';

					if(isFirstTime) {

						html = '<div class="table-responsive">';
						html +=		'<table class="table table-bordered table-hover">';
						html +=		'<thead><tr><th>ID баннера</th><th>Название баннера</th><th>Битая ссылка</th></tr></thead>';
						html +=		'<tbody class="results-data">';

						if (json['results']) {

							$.each( json['results'], function( key, data ) {
								
								if(+key != 0) {
									$.each( data, function( index, data2 ) {
											html += '<tr><td>'+key+'</td>';
											$.each( data2, function( name, link ) {
												html += '<td><a target="_blank" href="index.php?route=design/banner/edit&token=<?php echo $token; ?>&banner_id='+key+'">'+name+'</a></td><td><a target="_blank" href="'+link+'">'+link+'</a></td>';
											});	
											html += '</tr>';																	
									});
								}
								
							});
							
						} else {
							html += '<tr><td colspan="3">Битые ссылки не обнаружены</td></tr>';
						}

						html += '</tbody>';
						html += '	 </table>';
						html += '</div>';

						isFirstTime = false;

						$('#results').append(html);

					} else {

						if (json['results']) {

							$.each( json['results'], function( key, data ) {
								if(+key != 0) {
									$.each( data, function( index, data2 ) {
											html += '<tr><td>'+key+'</td>';
											$.each( data2, function( name, link ) {
												html += '<td><a target="_blank" href="index.php?route=design/banner/edit&token=<?php echo $token; ?>&banner_id='+key+'">'+name+'</a></td><td><a target="_blank" href="'+link+'">'+link+'</a></td>';
											});	
											html += '</tr>';																	
									});
								}
								
							});

							if($('.results-data').length) {
								$('.results-data').append(html);
							} else {
								$('#results').append(html);
							}
							
							
						}

					}

					startValue = +startValue + +limitValue;
					$('#total').html(+totalCounter - startValue);
					$('#check-links').attr("data-start", startValue);

					// отправляем пока есть результаты
					if (json['results'] && (startValue <= totalBanners)) {
						setTimeout(function() {
							sendRequest();
						}, 2000);
					} else {
						checkComplete = true;
						$('#check-links').text("Проверка завершена");
						alert("Проверка завершена");
					}
					

				},
				error: function (jqXHR, exception) {
		        var msg = '';
		        if (jqXHR.status === 0) {
		            msg = 'Not connect.\n Verify Network.';
		        } else if (jqXHR.status == 404) {
		            msg = 'Requested page not found. [404]';
		        } else if (jqXHR.status == 500) {
		            msg = 'Internal Server Error [500].';
		        } else if (exception === 'parsererror') {
		            msg = 'Requested JSON parse failed.';
		        } else if (exception === 'timeout') {
		            msg = 'Time out error.';
		        } else if (exception === 'abort') {
		            msg = 'Ajax request aborted.';
		        } else {
		            msg = 'Uncaught Error.\n' + jqXHR.responseText;
		        }
		        console.log(msg);
		    }
			});

		}

		$('body').on('click', '#check-links', function(e) {
			e.preventDefault();

			sendRequest();

			/*if (isFirstTime) {
          sendRequest();
          isFirstTime = false;
      } else {
          setTimeout(function () {
              sendForm();
          }, 1000);
      }
      return false;*/

		});

	});
	
</script>
<?php echo $footer; ?>