$(document).ready(function(){

	$('input[name=phone]').mask("+38 (999) 999-9999");

	$(document).on('click', '.scroll-link', function(){
		event.preventDefault();

        var id  = $(this).attr('href'),
            top = $(id).offset().top;
        $('body,html').animate({scrollTop: top}, 1500);
	})
	$(document).on('click', '.navigation a', function(){
		event.preventDefault();

        var id  = $(this).attr('href'),
            top = $(id).offset().top;
        $('body,html').animate({scrollTop: top}, 1500);
	})

	$(document).on('click', '.btn', function(){
		var remodal = $(this).data('remodal-target'),
		dataFrom = $(this).data('from');
		if(remodal){
			$('#'+remodal).find('input[name=from]').val(dataFrom);
		}
	})

	if($(window).width() <= 450){
		$("#header-mob").sticky({
			topSpacing: 0,
			zIndex: 900,
		});
	}

	$('.slider-gallery').slick({
		slidesToShow: 4,
		responsive: [
		{
		  breakpoint: 860,
		  settings: {
			slidesToShow: 3,
		  }
		},
		{
		  breakpoint: 650,
		  settings: {
			slidesToShow: 2,
		  }
		},
		{
		  breakpoint: 551,
		  settings: {
			slidesToShow: 2,
			arrows: false,
			dots: true,
		  }
		},
		]
	})

	$('.slider-kollazh').slick({
		dots: true,
		responsive: [
		{
		  breakpoint: 550,
		  settings: {
			arrows: false,
		  }
		},
		]
	})

	$('.slider-reviews').slick({
		slidesToShow: 4,
		responsive: [
		{
		  breakpoint: 860,
		  settings: {
			slidesToShow: 3,
		  }
		},
		{
		  breakpoint: 650,
		  settings: {
			slidesToShow: 2,
		  }
		},
		{
		  breakpoint: 551,
		  settings: {
			slidesToShow: 2,
			arrows: false,
			dots: true,
		  }
		},
		{
		  breakpoint: 451,
		  settings: {
			slidesToShow: 1,
			arrows: false,
			dots: true,
		  }
		},
		]
	})

	$('.slider-products').slick({
		slidesToShow: 4,
		responsive: [
		{
		  breakpoint: 860,
		  settings: {
			slidesToShow: 3,
		  }
		},
		{
		  breakpoint: 650,
		  settings: {
			slidesToShow: 2,
		  }
		},
		{
		  breakpoint: 551,
		  settings: {
			slidesToShow: 2,
			arrows: true,
			dots: false,
		  }
		},
		{
		  breakpoint: 451,
		  settings: {
			slidesToShow: 1,
			arrows: true,
			dots: false,
		  }
		},
		]
	});


	//$('.tabs-header a').tabs();

	$('.product-images .main-image').slick({
		asNavFor: '.thumb-images',
		arrows: false,
	})
	$('.product-images .thumb-images').slick({
		asNavFor: '.main-image',
		slidesToShow: 3,
		arrows: false,
		focusOnSelect: true
	})

	$('.tabs-header a').tabs();

	new WOW({
		mobile: false,
	}).init();

	$('.toggle-menu').on('click', function (){
		toggleMenu();
	})
	$('.mobile-bg').on('click', function (){
		toggleMenu();
	})
	$('.btn-mob-modal').on('click', function(){
		toggleMenu();
	})

	$('.point-wrap .item .scheme-link').on('click', function(){
		var item = $(this).closest('.item');
		item.find('.scheme-item').slideToggle(500);

		$(this).toggleClass('open');

		if($(this).hasClass('open')){
			$(this).text('Свернуть схему проезда');
		}else{
			$(this).text('Смотреть схему проезда');
		}
	})

	$('.scheme-item .scheme-link-up').on('click', function(){
		var item = $(this).closest('.scheme-item');
		var itemWrap = $(this).closest('.item');
		var linkShow = itemWrap.find('.scheme-link');
		item.slideToggle(500);
		linkShow.text('Смотреть схему проезда');
		linkShow.toggleClass('open');
	})

	$('.catalog-tabs-head a').tabsSlider();

	$('.catalog-mobile .catalog-item-toggle').on('click', function(e){
		e.preventDefault();
		var item = $(this).closest('.catalog-item');
		item.toggleClass('open');
		if($(this).hasClass('open')){
			$('.list-toggle2').show();
		}else{

		}
		var hiddenList = item.find('.hidden');
		hiddenList.slideToggle(200);
	});

	$.fn.extend({
			toggleText: function (a, b){
				var isClicked = false;
				var that = this;
				this.click(function (){
					if (isClicked) { that.text(a); isClicked = false; }
					else { that.text(b); isClicked = true; }
				});
				return this;
			}
		});

	$('.catalog-mobile .catalog-item-toggle').toggleText("БЫСТРЫЙ ПОИСК", "БЫСТРЫЙ ПОИСК");


	// Neon slider fix 18102018
	$('.catalog-mobile .catalog-item-toggle').on('click', function() {
		$('.slider-products').not('.slick-initialized').slick({
		slidesToShow: 4,
		responsive: [
		{
		  breakpoint: 860,
		  settings: {
			slidesToShow: 3,
		  }
		},
		{
		  breakpoint: 650,
		  settings: {
			slidesToShow: 2,
		  }
		},
		{
		  breakpoint: 551,
		  settings: {
			slidesToShow: 2,
			arrows: true,
			dots: false,
		  }
		},
		{
		  breakpoint: 451,
		  settings: {
			slidesToShow: 1,
			arrows: true,
			dots: false,
		  }
		},
		]
		});
		$('.slider-products').slick('setPosition');
	});

	var hash = window.location.hash;
	if(hash) {
		$(hash).addClass('open');
		var hiddenList = $(hash).find('.hidden');
		hiddenList.slideDown(200);
	}

	$('a[href=#]').click(function(e){ e.preventDefault(); });

	$(document).on('click','.spin-minus:not(.disabled)',function(){
        if($(this).hasClass('disabled')) return false;
        var inp = $(this).closest('.spinbox').find('input[name=quantity]');
        var v = parseInt(inp.val());
        if (v>1){
            v--;
            inp.val(v);
            inp.blur()
        }
        return false;
    });
    $(document).on('click','.spin-plus:not(.disabled)',function(){
//console.log(1);
        if($(this).hasClass('disabled')) return false;
        var inp = $(this).closest('.spinbox').find('input[name=quantity]');
        var v = parseInt(inp.val());
        v++;
        inp.val(v);
        inp.blur()
        return false;
    });
    $(document).on('blur','.spinbox input[name=quantity]',function(){
        //var product_id = $('input[name=\'product_id\']').attr('value');
        var product_id = $(this).data('product_id');
        var qty = $(this).val();
        if(qty < 1){
            qty = 1;
            $(this).val(qty);

        }
    });

});

function question(){
	$.ajax({
            url: 'index.php?route=information/information/question',
            type: 'post',
            data: $('#question-form').serialize(),
            dataType: 'json',
            beforeSend: function(){
        	$('#question-form input').removeClass('error');
            },
            success: function(json) {
        	if(json['error_firstname']){
		    $('#question-form input[name=\'firstname\']').addClass('error');
		}
        	if(json['error_phone']){
		    $('#question-form input[name=\'phone\']').addClass('error');
		}
        	if(json['success']){
		    $('#question-form').html('<div class="success">'+json['success']+'</div>');
		}

            },
	    error:function(xhr,ajaxOptions,thrownError){
                console.log(thrownError+"\r\n"+xhr.statusText+"\r\n"+xhr.responseText);
            }
        });
	
	dataLayer.push({'event': 'question'});
}
function callback1(){
	$.ajax({
            url: 'index.php?route=information/information/callback',
            type: 'post',
            data: $('#callback-form').serialize(),
            dataType: 'json',
            beforeSend: function(){
        	$('#callback-form input').removeClass('error');
            },
            success: function(json) {
        	if(json['error_firstname']){
		    $('#callback-form input[name=\'firstname\']').addClass('error');
		}
        	if(json['error_phone']){
		    $('#callback-form input[name=\'phone\']').addClass('error');
		}
        	if(json['success']){
		    $('#callback-form').html('<div class="success">'+json['success']+'</div>');
		}

            },
	    error:function(xhr,ajaxOptions,thrownError){
                console.log(thrownError+"\r\n"+xhr.statusText+"\r\n"+xhr.responseText);
            }
        });
	dataLayer.push({'event': 'ordercall'});
}

function toggleMenu(){
	$('.toggle-menu').toggleClass('open');
	$('.mobile-menu').toggleClass('open');
	$('.header').toggleClass('open');
	$('.header-mob').toggleClass('open');
	$('.mobile-bg').fadeToggle(200);
	$('html').toggleClass('remodal-is-locked');
}

$.fn.tabs = function() {
	var selector = this;
	this.each(function() {
		var obj = $(this);

		$(obj.attr('href')).hide();
		obj.click(function() {
			$(selector).removeClass('selected');

			$(this).addClass('selected');

			$($(this).attr('href')).fadeIn();
			$(selector).not(this).each(function(i, element) {
				$($(element).attr('href')).hide();
			});
			return false;

		});
	});
	$(this).show();
	$(this).first().click();
};

$.fn.tabsSlider = function() {
        var selector = this;
        this.each(function() {
                var obj = $(this);

                $(obj.attr('href')).hide();
                //console.log(1123);
                obj.click(function() {
                        $(selector).removeClass('selected');

                        $(this).addClass('selected');

                        $($(this).attr('href')).fadeIn();
                        //console.log($($(this).attr('href')).attr('id'));

                        var $catalog = $($(this).attr('href') + ' .list-products');

						$catalog.slick({
                            slidesToShow: 4,
		responsive: [
		{
		  breakpoint: 860,
		  settings: {
			slidesToShow: 3,
		  }
		},
		{
		  breakpoint: 650,
		  settings: {
			slidesToShow: 2,
		  }
		},
		{
		  breakpoint: 551,
		  settings: {
			slidesToShow: 2,
			arrows: true,
			dots: false,
		  }
		},
		{
		  breakpoint: 451,
		  settings: {
			slidesToShow: 1,
			arrows: true,
			dots: false,
		  }
							},
							]
                        });


                        $(selector).not(this).each(function(i, element) {
                                $($(element).attr('href')).hide();

                                if($($(element).attr('href') + ' .list-products').hasClass('slick-initialized')){
									$($(element).attr('href') + ' .list-products').slick('unslick');
									//console.log(2);
								};
                        });
                        return false;

                });
        });
        $(this).show();
        $(this).first().click();
};