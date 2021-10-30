function scroll_to(clicked_element) {

    var element_to_scroll = $(clicked_element).attr('data-scroll');

    if($(element_to_scroll).length > 0) {
        $('html, body').animate({
            scrollTop: $(element_to_scroll).offset().top-45
        }, 777);
    } else {
        location = $(clicked_element).attr('data-href');
    }

}
  //=====category nav=======
    $('.nav__separ').on('click', function(){
        $(this).toggleClass('nav__separ-open');
        $('.category-nav__sublist').toggleClass('category-nav__sublist-open');
    });
$(document).ready(function() {
  
    //=========main catalogy slider=========
     $('.main-slider').on('init', function(){
        $(this).addClass('main-slider-init');
    });
    $('.main-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        cssEase:'linear',
        speed: 300,
        autoplay: true,
        autoplaySpeed: 5000,
        dots: true,
        appendDots: $('.main-slider-dots'),
        responsive: [{
            breakpoint: 767,
            settings: {
                fade: false,
            }
        }, ]
    });
        $('.scroll-link').on('click touch touchstart',function(event) {
        event.preventDefault();
        scroll_to(this);
    return false;
    });
   var sliderProductOptions = {
        slidesToShow: 5,
        responsive: [{
                breakpoint: 1025,
                settings: {
                    slidesToShow: 3,
                    arrows: true,
                    dots: false,
                }
            },
            {
                breakpoint: 700,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 1,
                }
            },
        ],
    };

    $('.slider-products').slick(sliderProductOptions)
    .on('init', function(){
        alert('init');
        $('.cat__content').hide();
    });
    $('.popular__arrow-left').on('click', function(){
        $(this).parents('.cat__content').find('.slider-products').slick('slickPrev');
    });
    $('.popular__arrow-right').on('click', function(){
        $(this).parents('.cat__content').find('.slider-products').slick('slickNext');
    });

 });
   $('.cat_header_mobile').off('click.catalog-accordeon').on('click.catalog-accordeon', function(){
            $(this).next('.cat__content').toggleClass('cat__content_active');

            $(this).toggleClass('cat_header_mobile-active');
        });


    // $('.main-slider').on('init', function(e, slick) {
    //     var $firstAnimatingElements = $('.main-slider .slick-slide:first-child');
    //     doAnimations($firstAnimatingElements);
    // });
    // $('.main-slider').on('beforeChange', function(e, slick, currentSlide, nextSlide) {
    //           var $animatingPrevElements = $('.main-slider .slick-slide[data-slick-index="' + currentSlide + '"]');
    //           var $animatingElements = $('.main-slider .slick-slide[data-slick-index="' + nextSlide + '"]');
    //           doAnimations($animatingElements);
    //           doAnimations($animatingPrevElements);
    // });
    // function doAnimations(elements) {
    //     var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
    //     elements.each(function() {
    //         var $this = $(this);
    //         var $animationDelay = $this.data('delay');
    //         var $animationType = 'animated ' + $this.data('animation');
    //         $this.css({
    //             'animation-delay': $animationDelay,
    //             '-webkit-animation-delay': $animationDelay
    //         });
    //         $this.addClass($animationType).one(animationEndEvents, function() {
    //             $this.removeClass($animationType);
    //         });
    //     });
    // };

    //  $(document).on('click', '.scroll-link', function(){
    //      event.preventDefault();
    //
    //        var id  = $(this).attr('href'),
    //            top = $(id).offset().top;
    //        $('body,html').animate({scrollTop: top}, 1500);
    //  })

    // $('#call_mob_sellect').click(function() {
    //   $('#wraper-popup2').show();
    //   $('#overlay-popup2').show();
    // });


    // if ($(window).width() < 1024) {
    //     $('#fixed_PC_head').hide();
    // }



    /*$("a[href*=#]").on("click", function(e) {

        var anchor = $(this);

        if ($(window).width() > 750) {

            $('html, body').stop().animate({
                scrollTop: $(anchor.attr('href')).offset().top - 45
            }, 777);

        } else {

            $('html, body').stop().animate({
                scrollTop: $(anchor.attr('href')).offset().top - 45
            }, 777);

        }

        e.preventDefault();
        return false;
    });*/

    // $("#header").sticky({
    //     topSpacing: 0,
    //     zIndex: 900,
    // });

    // $("#header-mob").sticky({
    //     topSpacing: 0,
    //     zIndex: 900,
    // });

    $('.slider-gallery').slick({
        slidesToShow: 4,
        responsive: [{
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
        responsive: [{
            breakpoint: 550,
            settings: {
                arrows: false,
            }
        }, ]
    })

    $('.slider-reviews').slick({
        slidesToShow: 4,
        dots: false,
        responsive: [{
                breakpoint: 1025,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 700,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 1,

                }
            },
        ]
    })
    function question() {
    $.ajax({
        url: 'index.php?route=information/information/question',
        type: 'post',
        data: $('#question-form').serialize(),
        dataType: 'json',
        beforeSend: function() {
            $('#question-form input').removeClass('error');
        },
        success: function(json) {
            if (json['error_firstname']) {
                $('#question-form input[name=\'firstname\']').addClass('error');
            }
            if (json['error_phone']) {
                $('#question-form input[name=\'phone\']').addClass('error');
            }
            if (json['success']) {
                $('#question-form').html('<div class="success">' + json['success'] + '</div>');
            }

        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });

    dataLayer.push({ 'event': 'question' });
}
    $('.close-mob-menu').on('click', function() {
        $('.mobile-menu-main').removeClass('open');
        $('.mobile-bg').fadeOut(200);
        $('html').removeClass('remodal-is-locked');
    })
 $('.catalog-tabs-head a').tabsSlider();

        $('.catalog-mobile .catalog-item-toggle').on('click', function(e) {
            e.preventDefault();
            var item = $(this).closest('.catalog-item');
            item.toggleClass('open');
            if ($(this).hasClass('open')) {
                $('.list-toggle2').show();
            } else {

            }
            var hiddenList = item.find('.hidden');
            hiddenList.slideToggle(200);
        });

        $('.catalog-mobile .catalog-item-toggle').toggleText("БЫСТРЫЙ ПОИСК", "БЫСТРЫЙ ПОИСК");


        // Neon slider fix 18102018
        $('.catalog-mobile .catalog-item-toggle').on('click', function() {
            $('.slider-products').not('.slick-initialized').slick({
                slidesToShow: 4,
                responsive: [{
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
                    }
                ]
            });
            $('.slider-products').slick('setPosition');
        });

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
                responsive: [{
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

                if ($($(element).attr('href') + ' .list-products').hasClass('slick-initialized')) {
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


