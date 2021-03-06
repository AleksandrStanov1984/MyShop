<?php echo $header; ?>



<section class="page-product" id="product">
    <div class="wrapper">
	<div class="content">
	    <div class="product-images">
		<div class="main-image">
		    <?php foreach($images as $image){ ?>
		    <div><a data-fancybox="main-image" href="<?php echo $image['popup'] ?>"><img src="<?php echo $image['thumb'] ?>" alt="" /></a></div>
		    <?php } ?>
		</div>
		<div class="thumb-images">
		    <?php foreach($images as $image){ ?>
		    <div><img src="<?php echo $image['thumb'] ?>" alt="" /></div>
		    <?php } ?>
		</div>
	    </div>

	    <div class="product-buy">
		<h1><?php echo $heading_title ?></h1>
		<div class="size"><?php if((int)$height > 0) {echo (int)$height . 'x'; } ?><?php echo (int)$width; ?>x<?php echo (int)$length; ?></div>
		<div class="product-buy-top">
			<?php if($qty > 0){ ?>
				<div class="status"><?php echo $stock; ?></div>
			<?php }else{ ?>
				<div class="status out-stock"><?php echo $stock; ?></div>
			<?php } ?>
		    <div class="model"><?php echo $text_model; ?> <b><?php echo $model; ?></b></div>
		    <div class="price">
			<?php if($special){ ?>
			<div class="old-price"><?php echo $price; ?></div>
			<div class="new-price"><?php echo $special; ?></div>
			<?php }else{ ?>
			<div class="new-price"><?php echo $price; ?></div>
			<?php } ?>
		    </div>
            <?php if ($discounts) { ?>
		    <div class="opt-price">
        		<?php foreach ($discounts as $discount) { ?>
        		    <span><i><?php echo $discount['quantity']; ?></i><?php echo $text_discount; ?></span><b><?php echo $discount['price']; ?></b><br/>
    			<?php } ?>
		    </div>
            <?php } ?>
		</div>
		<div class="product-buy-bottom">
		    <?php if($jan){ ?>
		    <div class="timer">
			<div class="text"><?php echo $text_discount_time; ?>:</div>
			<script src="<?php echo $jan; ?>"></script>
		    </div>
		    <?php } ?>
		    <?php if($qty > 0){ ?>
		    <div class="buy">
			<div class="count spinbox">
			    <span><?php echo $text_quantity ?>:</span>
			    <a href="javascript:void(0)" class="count-minus spin-minus"></a>
			    <div class="count-input"><input type="text" name="quantity" value="1" /></div>
			    <a href="javascript:void(0)" class="count-plus spin-plus"></a>
<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
			</div>
			<div class="buttons">
			    <a href="javascript:void(0)" class="btn btn-big" id="button-cart"><?php echo $text_buy ?></a>
			    <a href="#" data-remodal-target="modal-callback" class="buy-one-click"><?php echo $text_oneclick ?></a>
			</div>
		    </div>
		    <?php }else{ ?>
			<div class="buttons">
				<span class="outofstock btn btn-off"><?php echo $outofstock; ?></span>
			</div>
		    <?php } ?>
		</div>
	    </div>

	    <div class="product-info">
<?php echo $column_left; ?>
		<?php /*<div class="product-info-item benefits">
		    <div class="item item-1">???????? ?? 1080 ??</div>
		    <div class="item item-3">???????? 2 ????</div>
		    <div class="item item-2">??????? 180x90x45 ??</div>
		    <!--<div class="item item-4">???????????? ?????? ?????</div>-->
		</div>
		<div class="product-info-item delivery">
		    <div class="name">????????</div>
		    <div class="info-item">????? ?????</div>
		    <span>- ?? ?????????: <b>100 ???</b></span>
		    <span>- ?? ??????: <b>120 ???</b></span>
		</div>
		<div class="product-info-item payment">
		    <div class="name">??????</div>
		    <div class="info-item item-1">??????24</div>
		    <span><b>???????? 1%</b></span>
		    <div class="info-item item-2">?????????? ??????</div>
		    <span><b>35 ???</b></span>
		</div>
		<div class="button"><a href="#" class="more-link">????????? ? ???????? ? ??????</a></div>
*/?>
	    </div>
	</div>
    </div>
</section>

<section class="product-tabs">
    <div class="wrapper">
	<div class="present-mobile-col">
	    <?php /*<div class="present">
		<div class="name">
		    <b>? ???????</b>
		    ????? ??? ?????? ? ???????
		</div>
		<div class="list">
		    <div class="item item-1">???????? - <i>1 ????</i></div>
		    <div class="item item-2">????????? - <i>1 ??.</i></div>
		    <div class="item item-3">???????? ????????????</div>
		    <div class="item item-4">?????? (???? + ?????-???????) ??? ?????????? ????????? ????? ????? - <i>4 ?????????</i></div>
		    <div class="item item-5">??????-?????? 8?60 (??? ????????? ????? ???????? ? ??????? ?????? ? ?????) - <i>2 ??.</i></div>
		    <div class="item item-6">?????????? - <i>1 ??.</i></div>
		</div>
	    </div>*/?>
	    	<?php echo $column_right; ?>

	</div>
	<div class="tabs">
	    <div class="tabs-header">
		<?php /*<a href="#tab1"><?php echo $tab_review ?></a>*/ ?>
		<a href="#tab2"><?php echo $tab_description ?></a>
	    </div>
	    <div class="tabs-body">
		<?php /*<div class="tab" id="tab1">
		    <div class="product-reviews" id="review">
		    </div>
		</div>*/ ?>
		<div class="tab" id="tab2">
		    <div class="content-box">
			<?php echo $description ?>
		    </div>
<!-- s -->

 <?php if ($products) { ?>
	  <div class="box related">

	   <div class="box-heading related-heading"><?php echo $text_related; ?></div>
	   <div class="box-content">
			<div id="products-related" class="related-products">
			<?php
				$sliderFor = 5;
				$productCount = sizeof($products);
			?>



				<div class="box-product <?php if ($productCount >= $sliderFor){?>product-carousel<?php }else{?>productbox-grid<?php }?>" id="<?php if ($productCount >= $sliderFor){?>related-carousel<?php }else{?>related-grid<?php }?>">

      		  <?php foreach ($products as $product) { ?>
				<div class="<?php if ($productCount >= $sliderFor){?>slider-item<?php }else{?>product-items<?php }?>">
					 <div class="product-block product-thumb transition">
	  					<div class="product-block-inner">
							<div class="image">
				<?php if ($product['thumb_swap']) { ?>
				<a href="<?php echo $product['href']; ?>">
				<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
				
				</a>
				<?php } else {?>
				<a href="<?php echo $product['href']; ?>">
				<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
				</a>
				<?php } ?>

							<?php if (!$product['special']) { ?>
							<?php } else { ?>
							<div class="saleback">
							<span class="saleicon sale">Sale</span>
							</div>
							<?php } ?>


							</div>
					<div class="product-details">

					<div class="caption">
                <!--div class="rating">
                  <?php for ($j = 1; $j <= 5; $j++) { ?>
       				<?php if ($product['rating'] < $j) { ?>
			  <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i></span>
			  <?php } else { ?>
			  <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star fa-stack-1x"></i></span>
                  <?php } ?>
                  <?php } ?>
                </div-->
					  <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
					<?php ?>  <p><?php // echo $product['description']; ?></p><?php ?>

					  <?php if ($product['price']) { ?>
					  <p class="price new-price-related">
						<?php if (!$product['special']) { ?>
						<?php echo $product['price']; ?>
						<?php } else { ?>
						<span class="price-old"><?php echo $product['price']; ?></span><span class="price-new"><?php echo $product['special']; ?></span>
						<?php } ?>
						<?php if ($product['tax']) { ?>
						<span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
						<?php } ?>
					  </p>
					  <?php } ?>
					</div>
					<div class="button">
					<button type="button" class="btn btn-buy" onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');"><?php echo $button_cart; ?></button>

					 
					</div>
					</div>
				  		<span class="related_default_width" style="display:none; visibility:hidden"></span>
					<!-- Megnor Related Products Start -->
				  </div>
				  </div>
				</div>
				<?php } ?>
				</div>
				<?php if ($productCount >= $sliderFor): ?>
					<div class="customNavigation">
						<a class="fa prev fa-angle-left">&nbsp;</a>
						<a class="fa next fa-angle-right">&nbsp;</a>
					</div>
				<?php endif; ?>
		</div>
		</div>
	  </div>
	 <?php } ?>			
<!-- e -->
	 
		</div>
	    </div>
	</div>
<?php /*	<div class="present-col">
	    <div class="present">
		<div class="name">
		    <b>? ???????</b>
		    ????? ??? ?????? ? ???????
		</div>
		<div class="list">
		    <div class="item item-1">???????? - <i>1 ????</i></div>
		    <div class="item item-2">????????? - <i>1 ??.</i></div>
		    <div class="item item-3">???????? ????????????</div>
		    <div class="item item-4">?????? (???? + ?????-???????) ??? ?????????? ????????? ????? ????? - <i>4 ?????????</i></div>
		    <div class="item item-5">??????-?????? 8?60 (??? ????????? ????? ???????? ? ??????? ?????? ? ?????) - <i>2 ??.</i></div>
		    <div class="item item-6">?????????? - <i>1 ??.</i></div>
		</div>
	    </div>
	</div>*/?>
		<div class="present-col">
		<?php echo $column_right; ?>
		</div>
    </div>
</section>





<script type="text/javascript"><!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
	$.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});
//--></script>
<script type="text/javascript"><!--
$('#button-cart').on('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		beforeSend: function() {
			//$('#button-cart').button('loading');
		},
		complete: function() {
			//$('#button-cart').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().before('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.before('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}

				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}

			if (json['success']) {
			//console.log(json);
				$.notify({
					message: json['success'],
					target: '_blank'
				},{
					// settings
					element: 'body',
					position: null,
					type: "info",
					allow_dismiss: true,
					newest_on_top: false,
					placement: {
						from: "top",
						align: "center"
					},
					offset: 0,
					spacing: 10,
					z_index: 2031,
					delay: 5000,
					timer: 1000,
					url_target: '_blank',
					mouse_over: null,
					animate: {
						enter: 'animated fadeInDown',
						exit: 'animated fadeOutUp'
					},
					onShow: null,
					onShown: null,
					onClose: null,
					onClosed: null,
					icon_type: 'class',
					/*template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-success" role="alert">' +
						'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">&nbsp;&times;</button>' +
						'<span data-notify="message"><i class="fa fa-check-circle"></i>&nbsp; {2}</span>' +
						'<div class="progress" data-notify="progressbar">' +
							'<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
						'</div>' +
						'<a href="{3}" target="{4}" data-notify="url"></a>' +
					'</div>'*/
					template: '<div class="remodal remodal-success" data-remodal-id="modal-success">' +
								'<button data-notify="dismiss" class="remodal-close"></button>' +
								'<div>{2}</div>' +
							'</div>',
				});

				//$('#cart > button').html('<i class="fa fa-shopping-cart"></i><span id="cart-total">' + json['total'] + '</span>' );

				//$('html, body').animate({ scrollTop: 0 }, 'slow');

				//$('#cart > ul').load('index.php?route=common/cart/info ul li');
				//console.log(json);
				location = 'index.php?route=checkout/cart';
				$('#cart').load('index.php?route=common/cart/info');
				$('.cart > i').html(json['total']);
			}
		}
	});
});
//--></script>
<script type="text/javascript"><!--
/*$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});*/

$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;

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
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').val(json['code']);
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
<script type="text/javascript"><!--
$('#review').delegate('.pagination a', 'click', function(e) {
  e.preventDefault();

    $('#review').fadeOut('slow');

    $('#review').load(this.href);

    $('#review').fadeIn('slow');
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: $("#form-review").serialize(),
		beforeSend: function() {
			$('#button-review').button('loading');
		},
		complete: function() {
			$('#button-review').button('reset');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();

			if (json['error']) {
				$('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
			}
		}
	});
});

//$(document).ready(function() {
//	$('.thumbnails').magnificPopup({
//		type:'image',
//		delegate: 'a',
//		gallery: {
//			enabled:true
//		}
//	});
//});


/*$(document).ready(function() {
if ($(window).width() > 767) {
		$("#tmzoom").elevateZoom({

				gallery:'additional-carousel',
				//inner zoom

				zoomType : "inner",
				cursor: "crosshair"



			});
		var z_index = 0;

     			    		$(document).on('click', '.thumbnail', function () {
     			    		  $('.thumbnails').magnificPopup('open', z_index);
     			    		  return false;
     			    		});

     			    		$('.additional-carousel a').click(function() {
     			    			var smallImage = $(this).attr('data-image');
     			    			var largeImage = $(this).attr('data-zoom-image');
     			    			var ez =   $('#tmzoom').data('elevateZoom');
     			    			$('.thumbnail').attr('href', largeImage);
     			    			ez.swaptheimage(smallImage, largeImage);
     			    			z_index = $(this).index('.additional-carousel a');
     			    			return false;
     			    		});

	}else{
		$(document).on('click', '.thumbnail', function () {
		$('.thumbnails').magnificPopup('open', 0);
		return false;
		});
	}
});*/
/*$(document).ready(function() {
	$('.thumbnails').magnificPopup({
		delegate: 'a.elevatezoom-gallery',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-with-zoom',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			titleSrc: function(item) {
				return item.el.attr('title');
			}
		}
	});
});*/

$('#tabs a').tabs();
$('#custom_tab a').tabs();

//--></script>

<script type="text/javascript"><!--
function price_format(price)
{ 
    c = <?php echo (empty($autocalc_currency['decimals']) ? "0" : $autocalc_currency['decimals'] ); ?>;
    d = '<?php echo $autocalc_currency['decimal_point']; ?>'; // decimal separator
    t = '<?php echo $autocalc_currency['thousand_point']; ?>'; // thousands separator
    s_left = '<?php echo str_replace("'", "\'", $autocalc_currency['symbol_left']); ?>';
    s_right = '<?php echo str_replace("'", "\'", $autocalc_currency['symbol_right']); ?>';
    n = price * <?php echo $autocalc_currency['value']; ?>;
    i = parseInt(n = Math.abs(n).toFixed(c)) + ''; 
    j = ((j = i.length) > 3) ? j % 3 : 0; 
    price_text = s_left + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : '') + s_right; 
    
    <?php if (!empty($autocalc_currency2)) { ?>
    c = <?php echo (empty($autocalc_currency2['decimals']) ? "0" : $autocalc_currency2['decimals'] ); ?>;
    d = '<?php echo $autocalc_currency2['decimal_point']; ?>'; // decimal separator
    t = '<?php echo $autocalc_currency2['thousand_point']; ?>'; // thousands separator
    s_left = '<?php echo str_replace("'", "\'", $autocalc_currency2['symbol_left']); ?>';
    s_right = '<?php echo str_replace("'", "\'", $autocalc_currency2['symbol_right']); ?>';
    n = price * <?php echo $autocalc_currency2['value']; ?>;
    i = parseInt(n = Math.abs(n).toFixed(c)) + ''; 
    j = ((j = i.length) > 3) ? j % 3 : 0; 
    price_text += '  <span class="currency2">(' + s_left + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : '') + s_right + ')</span>'; 
    <?php } ?>
    
    return price_text;
}

function calculate_tax(price)
{
    <?php // Process Tax Rates
      if (isset($tax_rates) && $tax) {
         foreach ($tax_rates as $tax_rate) {
           if ($tax_rate['type'] == 'F') {
             echo 'price += '.$tax_rate['rate'].';';
           } elseif ($tax_rate['type'] == 'P') {
             echo 'price += (price * '.$tax_rate['rate'].') / 100.0;';
           }
         }
      }
    ?>
    return price;
}

function process_discounts(price, quantity)
{
    <?php
      foreach ($dicounts_unf as $discount) {
        echo 'if ((quantity >= '.$discount['quantity'].') && ('.$discount['price'].' < price)) price = '.$discount['price'].';'."\n";
      }
    ?>
    return price;
}


animate_delay = 20;

main_price_final = calculate_tax(<?php echo $price_value; ?>);
main_price_start = calculate_tax(<?php echo $price_value; ?>);
main_step = 0;
main_timeout_id = 0;

function animateMainPrice_callback() {
    main_price_start += main_step;
    
    if ((main_step > 0) && (main_price_start > main_price_final)){
        main_price_start = main_price_final;
    } else if ((main_step < 0) && (main_price_start < main_price_final)) {
        main_price_start = main_price_final;
    } else if (main_step == 0) {
        main_price_start = main_price_final;
    }
    
    $('.autocalc-product-price').html( price_format(main_price_start) );
    
    if (main_price_start != main_price_final) {
        main_timeout_id = setTimeout(animateMainPrice_callback, animate_delay);
    }
}

function animateMainPrice(price) {
    main_price_start = main_price_final;
    main_price_final = price;
    main_step = (main_price_final - main_price_start) / 10;
    
    clearTimeout(main_timeout_id);
    main_timeout_id = setTimeout(animateMainPrice_callback, animate_delay);
}


<?php if ($special) { ?>
special_price_final = calculate_tax(<?php echo $special_value; ?>);
special_price_start = calculate_tax(<?php echo $special_value; ?>);
special_step = 0;
special_timeout_id = 0;

function animateSpecialPrice_callback() {
    special_price_start += special_step;
    
    if ((special_step > 0) && (special_price_start > special_price_final)){
        special_price_start = special_price_final;
    } else if ((special_step < 0) && (special_price_start < special_price_final)) {
        special_price_start = special_price_final;
    } else if (special_step == 0) {
        special_price_start = special_price_final;
    }
    
    $('.autocalc-product-special').html( price_format(special_price_start) );
    
    if (special_price_start != special_price_final) {
        special_timeout_id = setTimeout(animateSpecialPrice_callback, animate_delay);
    }
}

function animateSpecialPrice(price) {
    special_price_start = special_price_final;
    special_price_final = price;
    special_step = (special_price_final - special_price_start) / 10;
    
    clearTimeout(special_timeout_id);
    special_timeout_id = setTimeout(animateSpecialPrice_callback, animate_delay);
}
<?php } ?>


function recalculateprice()
{
    var main_price = <?php echo (float)$price_value; ?>;
    var input_quantity = Number($('input[name="quantity"]').val());
    var special = <?php echo (float)$special_value; ?>;
    var tax = 0;
    discount_coefficient = 1;
    
    if (isNaN(input_quantity)) input_quantity = 0;
    
    <?php if ($special) { ?>
        special_coefficient = <?php echo ((float)$price_value/(float)$special_value); ?>;
    <?php } else { ?>
        <?php if (empty($autocalc_option_discount)) { ?>
            main_price = process_discounts(main_price, input_quantity);
            tax = process_discounts(tax, input_quantity);
        <?php } else { ?>
            if (main_price) discount_coefficient = process_discounts(main_price, input_quantity) / main_price;
        <?php } ?>
    <?php } ?>
    
    
    var option_price = 0;
    
    <?php if ($points) { ?>
      var points = <?php echo (float)$points_value; ?>;
      $('input:checked,option:selected').each(function() {
          if ($(this).data('points')) points += Number($(this).data('points'));
      });
      $('.autocalc-product-points').html(points);
    <?php } ?>
    
    $('input:checked,option:selected').each(function() {
      if ($(this).data('prefix') == '=') {
        option_price += Number($(this).data('price'));
        main_price = 0;
        special = 0;
      }
    });
    
    $('input:checked,option:selected').each(function() {
      if ($(this).data('prefix') == '+') {
        option_price += Number($(this).data('price'));
      }
      if ($(this).data('prefix') == '-') {
        option_price -= Number($(this).data('price'));
      }
      if ($(this).data('prefix') == 'u') {
        pcnt = 1.0 + (Number($(this).data('price')) / 100.0);
        option_price *= pcnt;
        main_price *= pcnt;
        special *= pcnt;
      }
      if ($(this).data('prefix') == 'd') {
        pcnt = 1.0 - (Number($(this).data('price')) / 100.0);
        option_price *= pcnt;
        main_price *= pcnt;
        special *= pcnt;
      }
      if ($(this).data('prefix') == '*') {
        option_price *= Number($(this).data('price'));
        main_price *= Number($(this).data('price'));
        special *= Number($(this).data('price'));
      }
      if ($(this).data('prefix') == '/') {
        option_price /= Number($(this).data('price'));
        main_price /= Number($(this).data('price'));
        special /= Number($(this).data('price'));
      }
    });
    
    special += option_price;
    main_price += option_price;

    <?php if ($special) { ?>
      <?php if (empty($autocalc_option_special))  { ?>
        main_price = special * special_coefficient;
      <?php } else { ?>
        special = main_price / special_coefficient;
      <?php } ?>
      tax = special;
    <?php } else { ?>
      <?php if (!empty($autocalc_option_discount)) { ?>
          main_price *= discount_coefficient;
      <?php } ?>
      tax = main_price;
    <?php } ?>
    
    // Process TAX.
    main_price = calculate_tax(main_price);
    special = calculate_tax(special);
    
    <?php if (!$autocalc_not_mul_qty) { ?>
    if (input_quantity > 0) {
      main_price *= input_quantity;
      special *= input_quantity;
      tax *= input_quantity;
    }
    <?php } ?>

    // Display Main Price
    animateMainPrice(main_price);
      
    <?php if ($special) { ?>
      animateSpecialPrice(special);
    <?php } ?>
}

$(document).ready(function() {
    $('input[type="checkbox"]').bind('change', function() { recalculateprice(); });
    $('input[type="radio"]').bind('change', function() { recalculateprice(); });
    $('select').bind('change', function() { recalculateprice(); });
    
    $quantity = $('input[name="quantity"]');
    $quantity.data('val', $quantity.val());
    (function() {
        if ($quantity.val() != $quantity.data('val')){
            $quantity.data('val',$quantity.val());
            recalculateprice();
        }
        setTimeout(arguments.callee, 250);
    })();

    <?php if ($autocalc_select_first) { ?>
    $('select[name^="option"] option[value=""]').remove();
    last_name = '';
    $('input[type="radio"][name^="option"]').each(function(){
        if ($(this).attr('name') != last_name) $(this).prop('checked', true);
        last_name = $(this).attr('name');
    });
    <?php } ?>
    
    recalculateprice();
});

//--></script>
      

<script type="text/javascript"><!--
function price_format(price)
{ 
    c = <?php echo (empty($autocalc_currency['decimals']) ? "0" : $autocalc_currency['decimals'] ); ?>;
    d = '<?php echo $autocalc_currency['decimal_point']; ?>'; // decimal separator
    t = '<?php echo $autocalc_currency['thousand_point']; ?>'; // thousands separator
    s_left = '<?php echo str_replace("'", "\'", $autocalc_currency['symbol_left']); ?>';
    s_right = '<?php echo str_replace("'", "\'", $autocalc_currency['symbol_right']); ?>';
    n = price * <?php echo $autocalc_currency['value']; ?>;
    i = parseInt(n = Math.abs(n).toFixed(c)) + ''; 
    j = ((j = i.length) > 3) ? j % 3 : 0; 
    price_text = s_left + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : '') + s_right; 
    
    <?php if (!empty($autocalc_currency2)) { ?>
    c = <?php echo (empty($autocalc_currency2['decimals']) ? "0" : $autocalc_currency2['decimals'] ); ?>;
    d = '<?php echo $autocalc_currency2['decimal_point']; ?>'; // decimal separator
    t = '<?php echo $autocalc_currency2['thousand_point']; ?>'; // thousands separator
    s_left = '<?php echo str_replace("'", "\'", $autocalc_currency2['symbol_left']); ?>';
    s_right = '<?php echo str_replace("'", "\'", $autocalc_currency2['symbol_right']); ?>';
    n = price * <?php echo $autocalc_currency2['value']; ?>;
    i = parseInt(n = Math.abs(n).toFixed(c)) + ''; 
    j = ((j = i.length) > 3) ? j % 3 : 0; 
    price_text += '  <span class="currency2">(' + s_left + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : '') + s_right + ')</span>'; 
    <?php } ?>
    
    return price_text;
}

function calculate_tax(price)
{
    <?php // Process Tax Rates
      if (isset($tax_rates) && $tax) {
         foreach ($tax_rates as $tax_rate) {
           if ($tax_rate['type'] == 'F') {
             echo 'price += '.$tax_rate['rate'].';';
           } elseif ($tax_rate['type'] == 'P') {
             echo 'price += (price * '.$tax_rate['rate'].') / 100.0;';
           }
         }
      }
    ?>
    return price;
}

function process_discounts(price, quantity)
{
    <?php
      foreach ($dicounts_unf as $discount) {
        echo 'if ((quantity >= '.$discount['quantity'].') && ('.$discount['price'].' < price)) price = '.$discount['price'].';'."\n";
      }
    ?>
    return price;
}


animate_delay = 20;

main_price_final = calculate_tax(<?php echo $price_value; ?>);
main_price_start = calculate_tax(<?php echo $price_value; ?>);
main_step = 0;
main_timeout_id = 0;

function animateMainPrice_callback() {
    main_price_start += main_step;
    
    if ((main_step > 0) && (main_price_start > main_price_final)){
        main_price_start = main_price_final;
    } else if ((main_step < 0) && (main_price_start < main_price_final)) {
        main_price_start = main_price_final;
    } else if (main_step == 0) {
        main_price_start = main_price_final;
    }
    
    $('.autocalc-product-price').html( price_format(main_price_start) );
    
    if (main_price_start != main_price_final) {
        main_timeout_id = setTimeout(animateMainPrice_callback, animate_delay);
    }
}

function animateMainPrice(price) {
    main_price_start = main_price_final;
    main_price_final = price;
    main_step = (main_price_final - main_price_start) / 10;
    
    clearTimeout(main_timeout_id);
    main_timeout_id = setTimeout(animateMainPrice_callback, animate_delay);
}


<?php if ($special) { ?>
special_price_final = calculate_tax(<?php echo $special_value; ?>);
special_price_start = calculate_tax(<?php echo $special_value; ?>);
special_step = 0;
special_timeout_id = 0;

function animateSpecialPrice_callback() {
    special_price_start += special_step;
    
    if ((special_step > 0) && (special_price_start > special_price_final)){
        special_price_start = special_price_final;
    } else if ((special_step < 0) && (special_price_start < special_price_final)) {
        special_price_start = special_price_final;
    } else if (special_step == 0) {
        special_price_start = special_price_final;
    }
    
    $('.autocalc-product-special').html( price_format(special_price_start) );
    
    if (special_price_start != special_price_final) {
        special_timeout_id = setTimeout(animateSpecialPrice_callback, animate_delay);
    }
}

function animateSpecialPrice(price) {
    special_price_start = special_price_final;
    special_price_final = price;
    special_step = (special_price_final - special_price_start) / 10;
    
    clearTimeout(special_timeout_id);
    special_timeout_id = setTimeout(animateSpecialPrice_callback, animate_delay);
}
<?php } ?>


function recalculateprice()
{
    var main_price = <?php echo (float)$price_value; ?>;
    var input_quantity = Number($('input[name="quantity"]').val());
    var special = <?php echo (float)$special_value; ?>;
    var tax = 0;
    discount_coefficient = 1;
    
    if (isNaN(input_quantity)) input_quantity = 0;
    
    <?php if ($special) { ?>
        special_coefficient = <?php echo ((float)$price_value/(float)$special_value); ?>;
    <?php } else { ?>
        <?php if (empty($autocalc_option_discount)) { ?>
            main_price = process_discounts(main_price, input_quantity);
            tax = process_discounts(tax, input_quantity);
        <?php } else { ?>
            if (main_price) discount_coefficient = process_discounts(main_price, input_quantity) / main_price;
        <?php } ?>
    <?php } ?>
    
    
    var option_price = 0;
    
    <?php if ($points) { ?>
      var points = <?php echo (float)$points_value; ?>;
      $('input:checked,option:selected').each(function() {
          if ($(this).data('points')) points += Number($(this).data('points'));
      });
      $('.autocalc-product-points').html(points);
    <?php } ?>
    
    $('input:checked,option:selected').each(function() {
      if ($(this).data('prefix') == '=') {
        option_price += Number($(this).data('price'));
        main_price = 0;
        special = 0;
      }
    });
    
    $('input:checked,option:selected').each(function() {
      if ($(this).data('prefix') == '+') {
        option_price += Number($(this).data('price'));
      }
      if ($(this).data('prefix') == '-') {
        option_price -= Number($(this).data('price'));
      }
      if ($(this).data('prefix') == 'u') {
        pcnt = 1.0 + (Number($(this).data('price')) / 100.0);
        option_price *= pcnt;
        main_price *= pcnt;
        special *= pcnt;
      }
      if ($(this).data('prefix') == 'd') {
        pcnt = 1.0 - (Number($(this).data('price')) / 100.0);
        option_price *= pcnt;
        main_price *= pcnt;
        special *= pcnt;
      }
      if ($(this).data('prefix') == '*') {
        option_price *= Number($(this).data('price'));
        main_price *= Number($(this).data('price'));
        special *= Number($(this).data('price'));
      }
      if ($(this).data('prefix') == '/') {
        option_price /= Number($(this).data('price'));
        main_price /= Number($(this).data('price'));
        special /= Number($(this).data('price'));
      }
    });
    
    special += option_price;
    main_price += option_price;

    <?php if ($special) { ?>
      <?php if (empty($autocalc_option_special))  { ?>
        main_price = special * special_coefficient;
      <?php } else { ?>
        special = main_price / special_coefficient;
      <?php } ?>
      tax = special;
    <?php } else { ?>
      <?php if (!empty($autocalc_option_discount)) { ?>
          main_price *= discount_coefficient;
      <?php } ?>
      tax = main_price;
    <?php } ?>
    
    // Process TAX.
    main_price = calculate_tax(main_price);
    special = calculate_tax(special);
    
    <?php if (!$autocalc_not_mul_qty) { ?>
    if (input_quantity > 0) {
      main_price *= input_quantity;
      special *= input_quantity;
      tax *= input_quantity;
    }
    <?php } ?>

    // Display Main Price
    animateMainPrice(main_price);
      
    <?php if ($special) { ?>
      animateSpecialPrice(special);
    <?php } ?>
}

$(document).ready(function() {
    $('input[type="checkbox"]').bind('change', function() { recalculateprice(); });
    $('input[type="radio"]').bind('change', function() { recalculateprice(); });
    $('select').bind('change', function() { recalculateprice(); });
    
    $quantity = $('input[name="quantity"]');
    $quantity.data('val', $quantity.val());
    (function() {
        if ($quantity.val() != $quantity.data('val')){
            $quantity.data('val',$quantity.val());
            recalculateprice();
        }
        setTimeout(arguments.callee, 250);
    })();

    <?php if ($autocalc_select_first) { ?>
    $('select[name^="option"] option[value=""]').remove();
    last_name = '';
    $('input[type="radio"][name^="option"]').each(function(){
        if ($(this).attr('name') != last_name) $(this).prop('checked', true);
        last_name = $(this).attr('name');
    });
    <?php } ?>
    
    recalculateprice();
});

//--></script>
      
<?php echo $footer; ?>

<?php /*<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="productpage <?php echo $class; ?>"><?php echo $content_top; ?>
      <div class="row">
        <!--h2 class="page-title"><?php echo $heading_title; ?></h2-->

		<?php if ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-6 product-left'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-6 product-left'; ?>
        <?php } ?>

		<div class="<?php echo $class; ?>">
		<div class="product-info">
         <?php if ($thumb || $images) { ?>



    <div class="left product-image thumbnails">
      <?php if ($thumb) { ?>
	  <!-- Megnor Cloud-Zoom Image Effect Start -->
	  	<div class="image"><a class="thumbnail" href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>"><img id="tmzoom" src="<?php echo $thumb; ?>" data-zoom-image="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></div>
      <?php } ?>
      <?php if ($images) { ?>
	  	 <?php
			$sliderFor = 3;
			$imageCount = sizeof($images);
		 ?>
		 <div class="additional-carousel">
		  <?php if ($imageCount >= $sliderFor): ?>
		  	<div class="customNavigation">
				<span class="fa prev fa-caret-up">&nbsp;</span>
			<span class="fa next fa-caret-down">&nbsp;</span>
			</div>
		  <?php endif; ?>
		  <div id="additional-carousel" class="image-additional <?php if ($imageCount >= $sliderFor){?>product-carousel<?php }?>">

			<div class="slider-item">
				<div class="product-block">
					<a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="elevatezoom-gallery" data-image="<?php echo $thumb; ?>" data-zoom-image="<?php echo $popup; ?>"><img src="<?php echo $thumb; ?>" width="105" height="130" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>

				</div>
				</div>

			<?php foreach ($images as $image) { ?>
				<div class="slider-item">
				<div class="product-block">
        			<a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="elevatezoom-gallery" data-image="<?php echo $image['thumb']; ?>" data-zoom-image="<?php echo $image['popup']; ?>" ><img src="<?php echo $image['thumb']; ?>" width="105" height="130" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
				</div>
				</div>
	        <?php } ?>
    	  </div>
		  <span class="additional_default_width" style="display:none; visibility:hidden"></span>
		  </div>
		<?php } ?>


	<!-- Megnor Cloud-Zoom Image Effect End-->
    </div>
    <?php } ?>
	</div>
        </div>

        <?php if ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-6 product-right'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-6 product-right'; ?>
        <?php } ?>
        <div class="<?php echo $class; ?>">
          <h1 class="product-title">
		  	<?php echo $heading_title; ?>
			<?php if($width > 0) {?>
		  		<span><?php echo round($height,2). "x" . round($width,2). "x" . round($length,2); ?></span>
			<?php }?>
		  </h1>
		  <?php if ($review_status) { ?>
          <div class="rating-wrapper">
              <?php for ($i = 1; $i <= 5; $i++) { ?>
              <?php if ($rating < $i) { ?>
			  <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i></span>
			  <?php } else { ?>
			  <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star fa-stack-1x"></i></span>
              <?php } ?>
              <?php } ?>
              <a class="review-count" href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;"><?php echo $reviews; ?></a><a class="write-review" href="" onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;"><i class="fa fa-pencil"></i> <?php echo $text_write; ?></a>
		  </div>
          <?php } ?>

          <ul class="list-unstyled">
            <?php if ($manufacturer) { ?>
            <li><span class="desc"><?php echo $text_manufacturer; ?></span><a href="<?php echo $manufacturers; ?>"><?php echo $manufacturer; ?></a></li>
            <?php } ?>
            <li><span class="desc"><?php echo $text_model; ?></span><?php echo $model; ?></li>
            <?php if ($reward) { ?>
            <li><span class="desc"><?php echo $text_reward; ?></span><?php echo $reward; ?></li>
            <?php } ?>
            <li><span class="desc"><?php echo $text_stock; ?></span><?php echo $stock; ?></li>
			<!--li><span class="desc"><?php //echo $text_height; ?></span><?php //echo round($height,2); ?><?php //echo round($width,2); ?><?php// echo round($length,2); ?></li-->

          </ul>
          <?php if ($price) { ?>
          <ul class="list-unstyled">
            <?php if (!$special) { ?>
            <li>
              <h4 class="product-price"><?php echo $price; ?></h4>
            </li>
            <?php } else { ?>
            <li>
			<span class="old-price" style="text-decoration: line-through;"><?php echo $price; ?></span>
            <h4 class="special-price"><?php echo $special; ?></h4>
            </li>
            <?php } ?>
            <?php if ($tax) { ?>
            <li class="price-tax"><?php echo $text_tax; ?><span><?php echo $tax; ?></span></li>
            <?php } ?>
            <?php if ($points) { ?>
            <li class="rewardpoint"><?php echo $text_points; ?> <?php echo $points; ?></li>
            <?php } ?>
            <?php if ($discounts) { ?>
            <li>
            </li>
            <?php foreach ($discounts as $discount) { ?>
            <li class="discount"><?php echo $discount['quantity']; ?><?php echo $text_discount; ?><?php echo $discount['price']; ?></li>
            <?php } ?>
            <?php } ?>
          </ul>
          <?php } ?>
		  <div class="price-economy"></div>
          <div id="product">
            <?php if ($options) { ?>

            <h3 class="product-option"><?php echo $text_option; ?></h3>
            <?php foreach ($options as $option) { ?>
            <?php if ($option['type'] == 'select') { ?>
            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control">
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                <option value="<?php echo $option_value['product_option_value_id']; ?>" data-points="<?php echo (isset($option_value['points_value']) ? $option_value['points_value'] : 0); ?>" data-prefix="<?php echo $option_value['price_prefix']; ?>" data-price="<?php echo $option_value['price_value']; ?>" data-points="<?php echo (isset($option_value['points_value']) ? $option_value['points_value'] : 0); ?>" data-prefix="<?php echo $option_value['price_prefix']; ?>" data-price="<?php echo $option_value['price_value']; ?>"><?php echo $option_value['name']; ?>
                <?php if ($option_value['price']) { ?>
                (<?php echo ($option_value['price_prefix'] == '+' || $option_value['price_prefix'] == '-' ? $option_value['price_prefix'] : '') . $option_value['price']; ?>)
                <?php } ?>
                </option>
                <?php } ?>
              </select>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'radio') { ?>
            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label"><?php echo $option['name']; ?></label>
              <div id="input-option<?php echo $option['product_option_id']; ?>">
                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                <div class="radio">
                  <label>
                    <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" data-points="<?php echo (isset($option_value['points_value']) ? $option_value['points_value'] : 0); ?>" data-prefix="<?php echo $option_value['price_prefix']; ?>" data-price="<?php echo $option_value['price_value']; ?>" data-points="<?php echo (isset($option_value['points_value']) ? $option_value['points_value'] : 0); ?>" data-prefix="<?php echo $option_value['price_prefix']; ?>" data-price="<?php echo $option_value['price_value']; ?>" />
                    <?php if ($option_value['image']) { ?>
                    <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" data-toggle="tooltip" data-original-title="<?php echo $option_value['name']; ?>"/>
                    <?php } ?>
                    <?php //echo $option_value['name']; ?>
                    <?php if ($option_value['price']) { ?>
                    (<?php echo ($option_value['price_prefix'] == '+' || $option_value['price_prefix'] == '-' ? $option_value['price_prefix'] : '') . $option_value['price']; ?>)
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'checkbox') { ?>
            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label"><?php echo $option['name']; ?></label>
              <div id="input-option<?php echo $option['product_option_id']; ?>">
                <?php foreach ($option['product_option_value'] as $option_value) { ?>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" data-points="<?php echo (isset($option_value['points_value']) ? $option_value['points_value'] : 0); ?>" data-prefix="<?php echo $option_value['price_prefix']; ?>" data-price="<?php echo $option_value['price_value']; ?>" data-points="<?php echo (isset($option_value['points_value']) ? $option_value['points_value'] : 0); ?>" data-prefix="<?php echo $option_value['price_prefix']; ?>" data-price="<?php echo $option_value['price_value']; ?>" />
                    <?php if ($option_value['image']) { ?>
                    <img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" />
                    <?php } ?>
                    <?php echo $option_value['name']; ?>
                    <?php if ($option_value['price']) { ?>
                    (<?php echo ($option_value['price_prefix'] == '+' || $option_value['price_prefix'] == '-' ? $option_value['price_prefix'] : '') . $option_value['price']; ?>)
                    <?php } ?>
                  </label>
                </div>
                <?php } ?>
              </div>
            </div>
            <?php } ?>

            <?php if ($option['type'] == 'text') { ?>
            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'textarea') { ?>
            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'file') { ?>
            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label"><?php echo $option['name']; ?></label>
              <button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
              <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'date') { ?>
            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <div class="input-group date">
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'datetime') { ?>
            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <div class="input-group datetime">
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
            <?php } ?>
            <?php if ($option['type'] == 'time') { ?>
            <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
              <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
              <div class="input-group time">
                <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
            </div>
            <?php } ?>
            <?php } ?>
            <?php } ?>
            <?php if ($recurrings) { ?>
            <hr>
            <h3><?php echo $text_payment_recurring; ?></h3>
            <div class="form-group required">
              <select name="recurring_id" class="form-control">
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach ($recurrings as $recurring) { ?>
                <option value="<?php echo $recurring['recurring_id']; ?>"><?php echo $recurring['name']; ?></option>
                <?php } ?>
              </select>
              <div class="help-block" id="recurring-description"></div>
            </div>
            <?php } ?>
            <div class="form-group">
              <label class="control-label qty" for="input-quantity"><?php echo $entry_qty; ?></label>
              <input type="text" name="quantity" value="<?php echo $minimum; ?>" size="2" id="input-quantity" class="form-control" />
              <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />

              <button type="button" id="button-cart" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg btn-block"><?php echo $button_cart; ?></button>
			  <a href="javascript:void(0)" class="bingc-action-open-passive-form"
					data-getcall-title-in-working-hours="<?php echo $text_oneclick_text; ?>" data-getcall-description="
					 1  {{item.title}}."><?php echo $text_oneclick; ?></a>
            </div>
            <?php if ($minimum > 1) { ?>
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_minimum; ?></div>
            <?php } ?>
          </div>

		  <!--div class="btn-group wish-comp">
            <button type="button"  class="btn btn-default wishlist" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product_id; ?>');"><i class="fa fa-heart"></i><?php echo $button_wishlist; ?></button>
            <button type="button"  class="btn btn-default compare" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product_id; ?>');"><i class="fa fa-bar-chart"></i><?php echo $button_compare; ?></button>
          </div-->


            <!-- AddThis Button BEGIN -->
            <!--div class="addthis_toolbox addthis_default_style" data-url="<?php echo $share; ?>"><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a> <a class="addthis_counter addthis_pill_style"></a></div-->
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>
            <!-- AddThis Button END -->
			<div class="content_product_block"><?php echo $productblock; ?> </div>

        </div>
		<?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        <div class="<?php echo $class; ?>" id="tabs_info">
		   <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-description"  data-toggle="tab"><?php echo $tab_description; ?></a></li>
            <?php if ($attribute_groups) { ?>
            <li><a href="#tab-specification" data-toggle="tab"><?php echo $tab_attribute; ?></a></li>
            <?php } ?>
            <?php if ($review_status) { ?>
            <li><a href="#tab-review" data-toggle="tab"><?php echo $tab_review; ?></a></li>
            <?php } ?>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-description"><?php echo $description; ?></div>
            <?php if ($attribute_groups) { ?>
            <div class="tab-pane" id="tab-specification">
              <table class="table table-bordered">
                <?php foreach ($attribute_groups as $attribute_group) { ?>
                <thead>
                  <tr>
                    <td colspan="2"><strong><?php echo $attribute_group['name']; ?></strong></td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                  <tr>
                    <td><?php echo $attribute['name']; ?></td>
                    <td><?php echo $attribute['text']; ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
                <?php } ?>
              </table>
            </div>
            <?php } ?>
            <?php if ($review_status) { ?>
            <div class="tab-pane" id="tab-review">
              <form class="form-horizontal" id="form-review">
                <div id="review"></div>
                <h4><?php echo $text_write; ?></h4>
				<?php if ($review_guest) { ?>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                    <input type="text" name="name" value="<?php echo $customer_name; ?>" id="input-name" class="form-control" />
                  </div>
                </div>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label" for="input-review"><?php echo $entry_review; ?></label>
                    <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
                    <div class="help-block"><?php echo $text_note; ?></div>
                  </div>
                </div>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label"><?php echo $entry_rating; ?></label>
                    &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
                    <input type="radio" name="rating" value="1" />
                    &nbsp;
                    <input type="radio" name="rating" value="2" />
                    &nbsp;
                    <input type="radio" name="rating" value="3" />
                    &nbsp;
                    <input type="radio" name="rating" value="4" />
                    &nbsp;
                    <input type="radio" name="rating" value="5" />
                    &nbsp;<?php echo $entry_good; ?></div>
                </div>
                <?php echo $captcha; ?>

                <div class="buttons clearfix">
                  <div class="pull-right">
                    <button type="button" id="button-review" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_continue; ?></button>
                  </div>
                </div>
				 <?php } else { ?>
                <?php echo $text_login; ?>
                <?php } ?>
              </form>
            </div>
            <?php } ?>
          </div>
		</div>
<?php if ($products) { ?>
	  <div class="box related">

	   <div class="box-heading"><?php echo $text_related; ?></div>
	   <div class="box-content">
			<div id="products-related" class="related-products">
			<?php
				$sliderFor = 5;
				$productCount = sizeof($products);
			?>



				<div class="box-product <?php if ($productCount >= $sliderFor){?>product-carousel<?php }else{?>productbox-grid<?php }?>" id="<?php if ($productCount >= $sliderFor){?>related-carousel<?php }else{?>related-grid<?php }?>">

      		  <?php foreach ($products as $product) { ?>
				<div class="<?php if ($productCount >= $sliderFor){?>slider-item<?php }else{?>product-items<?php }?>">
					 <div class="product-block product-thumb transition">
	  					<div class="product-block-inner">
							<div class="image">
				<?php if ($product['thumb_swap']) { ?>
				<a href="<?php echo $product['href']; ?>">
				<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
				<img class="img-responsive hover-image" src="<?php echo $product['thumb_swap']; ?>" alt="<?php echo $product['name']; ?>"/>
				</a>
				<?php } else {?>
				<a href="<?php echo $product['href']; ?>">
				<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
				</a>
				<?php } ?>

							<?php if (!$product['special']) { ?>
							<?php } else { ?>
							<div class="saleback">
							<span class="saleicon sale">Sale</span>
							</div>
							<?php } ?>

					<div class="button-group">
					<button type="button" class="addtocart" onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');"><?php echo $button_cart; ?></button>

					  <button type="button" class="compare_button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
					  <button type="button" class="wishlist_button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
					</div>
							</div>
					<div class="product-details">

					<div class="caption">
                <!--div class="rating">
                  <?php for ($j = 1; $j <= 5; $j++) { ?>
       				<?php if ($product['rating'] < $j) { ?>
			  <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i></span>
			  <?php } else { ?>
			  <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star fa-stack-1x"></i></span>
                  <?php } ?>
                  <?php } ?>
                </div-->
					  <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
					<?php ?>  <p><?php echo $product['description']; ?></p><?php ?>

					  <?php if ($product['price']) { ?>
					  <p class="price">
						<?php if (!$product['special']) { ?>
						<?php echo $product['price']; ?>
						<?php } else { ?>
						<span class="price-old"><?php echo $product['price']; ?></span><span class="price-new"><?php echo $product['special']; ?></span>
						<?php } ?>
						<?php if ($product['tax']) { ?>
						<span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
						<?php } ?>
					  </p>
					  <?php } ?>
					</div>

					</div>
				  		<span class="related_default_width" style="display:none; visibility:hidden"></span>
					<!-- Megnor Related Products Start -->
				  </div>
				  </div>
				</div>
				<?php } ?>
				</div>
				<?php if ($productCount >= $sliderFor): ?>
					<div class="customNavigation">
						<a class="fa prev fa-angle-left">&nbsp;</a>
						<a class="fa next fa-angle-right">&nbsp;</a>
					</div>
				<?php endif; ?>
		</div>
		</div>
	  </div>
	 <?php } ?>


	  <?php if ($tags) { ?>
      <div class="product-tag"><b><?php echo $text_tags; ?></b>
        <?php for ($i = 0; $i < count($tags); $i++) { ?>
        <?php if ($i < (count($tags) - 1)) { ?>
        <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
        <?php } else { ?>
        <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
        <?php } ?>
        <?php } ?>
      </div>
      <?php } ?>
	  </div>

    <?php echo $column_right; ?></div>
	<?php echo $content_bottom; ?>
</div>*/?>