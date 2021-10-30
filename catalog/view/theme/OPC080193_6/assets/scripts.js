/** styles */
function currentUrl() {
    var currentLoc = window.location.origin;
    var currentPath = window.location.pathname;
    return currentLoc + currentPath;
}

_slick = jQuery.fn.slick;
jQuery.fn.slick = function() {
    args = Array.prototype.slice.call(arguments);
    if (args[0] && typeof args[0] === 'object' && args[0].constructor === Object) {
        args[0].prevArrow = args[0].prevArrow || `<div class="slick-prev slick-arrow" role="button"></button>`;
        args[0].nextArrow = args[0].nextArrow || `<div class="slick-next slick-arrow" role="button"></button>`;
    }
    return _slick.apply(this, args);
};

$(document).ready(function() {
    /*===call button animation====*/
    if($( window ).width()>1199){
        setTimeout(function(){
            $( ".callbtn" ).removeClass('callbtn-show');
            phone_anim();
        }, 61000);
    };
    $(window).resize(function(){
        if($( window ).width()>1199){
            phone_anim();
        };
    });
    function phone_anim(){
        $( window ).scroll(function() {
            if(!$('.callbtn').hasClass('bounce')){
                $( ".callbtn" ).addClass('bounce');
                setTimeout(function(){
                    $( ".callbtn" ).removeClass('bounce');
                }, 1000);
            }
        });
    }
    /*=== magnitnaya shapka ====*/
    var mywindow = $(window);
    var mypos = mywindow.scrollTop();
    var up = false;
    var newscroll;
    function scrollPage() {
        if(mywindow.width() > 992){
            if (mywindow.scrollTop() > 56) {
                $('.inline-category ').hide();
                $('body').addClass('short-header');
                $('.header-mob').removeClass('high-header');
            } else {
                $('body').removeClass('short-header');
                $('.inline-category ').show();
                $('.header-mob').addClass('high-header');
            }
        } else {
            if (mywindow.scrollTop() > 67) {
                $('body').addClass('short-header');
            } else {
                $('body').removeClass('short-header');
            }
        }
    }
    mywindow.scroll(scrollPage);
    scrollPage();
    /*=== end magnitnaya shapka ====*/
    /*== phone input mask ==*/
    $('input[name=phone]').mask("+38 (999) 999-99-99", {completed:function(){if(this.hasClass('error')){this.removeClass('error')};}});
    /*==end phone input mask ==*/
    $(document).on('click', '.navigation a', function() {
        event.preventDefault();
        var id = $(this).attr('href'),
            top = $(id).offset().top;
        $('body,html').animate({ scrollTop: top }, 1500);
    })
    $(document).on('click', '.btn', function() {
        var remodal = $(this).data('remodal-target'),
            dataFrom = $(this).data('from');
        if (remodal) {
            $('#' + remodal).find('input[name=from]').val(dataFrom);
        }
    })
    jQuery('#close-popup-mob').click(function() {
        $('#overlay-popup2').hide();
        $('#wraper-popup2').hide();
    });

    /* tabs accordion footer*/
    $('.tab-title').on('click', function(){
        $(this).parents('.tab-wrap').toggleClass('tab-open');
    });
    /* end tabs accordion footer*/
    /*=========catalog accordion========*/
    $(document).on('behavior.catalog-accordeon', function() {
        /*tab page product*/
        $('.tabs-header a').tabs();
        /*end tab page product*/
        $('.toggle-menu').on('click', function() {
            toggleMenu();
            $('.panel-sfv-catalogs').removeClass('panel-sfv-catalogs-fixed');
        })
        /*mobile menu*/
        $('.back-button-menu').on('click', function(e) {
            var thisElemnt = $(this);
            $(this).parent().parent().removeClass('open');
            e.preventDefault();
            var linkOpen = $(this).attr('href');
            if (linkOpen !=='#start'){
                $(linkOpen).removeClass('sub-open').addClass('open');
            }else{
                $(linkOpen).removeClass('sub-open');
            }
            setTimeout(function(){
                thisElemnt.parent().parent().addClass('hidden');
            }, 600)
        })
        $(document).mouseup(function (e) {
            var div = $(".mobile-menu");
            if (!div.is(e.target) && div.has(e.target).length === 0) {
                $('.mobile-menu-main').removeClass('open');
                setTimeout(function(){$('.mobile-menu').removeClass('open').removeClass('sub-open'); $('.mobile-menu:not(.mm-1-mobibe-menu)').addClass('hidden');}, 400);
                $('.mobile-bg').css('display', 'none');
                $('html').removeClass('remodal-is-locked scroll-disabled');
                $('body').removeClass('scroll-disabled');
            }
        })
        $('#link-menu-category').on('click', function() {
            $('#mm-1').removeClass('hidden');
            setTimeout(function(){
                $('#mm-1').addClass('open');
                $('#start').removeClass('open').addClass('sub-open');}, 100);

        })
        $('.category-has-child').on('click', function(e) {
            e.preventDefault();
            var thisElemnt = $(this);
            var linkSub = $(this).attr('href');
            $(linkSub).removeClass('hidden');
            setTimeout(function(){thisElemnt.parent().parent().removeClass('open').addClass('sub-open');
                $(linkSub).addClass('open');},100);

        })
        $('.btn-mob-modal').on('click', function() {
            toggleMenu();
        })
        /*end mobile menu*/
        $.fn.extend({
            toggleText: function(a, b) {
                var isClicked = false;
                var that = this;
                this.click(function() {
                    if (isClicked) { that.text(a);
                        isClicked = false; } else { that.text(b);
                        isClicked = true; }
                });
                return this;
            }
        });

        var hash = window.location.hash;
        if (hash) {
            $(hash).addClass('open');
            var hiddenList = $(hash).find('.hidden');
            hiddenList.slideDown(200);
        }

        $('a[href=#]').click(function(e) { e.preventDefault(); });
        /*button plus/minus qnt*/

        $(document).on('click', '.spin-minus:not(.disabled)', function() {
            if ($(this).hasClass('disabled')) {return false};
            var inp = $(this).closest('.spinbox').find('input[name=quantity]');
            var v = parseInt(inp.val());
            if (v > 1) {
                v--;
                inp.val(v);
                inp.blur()
            }
            return false;
        });
        $(document).on('click', '.spin-plus:not(.disabled)', function() {
            if ($(this).hasClass('disabled')) {return false};
            var inp = $(this).closest('.spinbox').find('input[name=quantity]');
            var v = parseInt(inp.val());
            v++;
            inp.val(v);
            inp.blur()
            return false;
        });
        $(document).on('blur', '.spinbox input[name=quantity]', function() {
            var product_id = $(this).data('product_id');
            var qty = $(this).val();
            if (qty < 1) {
                qty = 1;
                $(this).val(qty);
            }
        });
        /* end button plus/minus qnt*/
    }).trigger('behavior.catalog-accordeon')
});
/*mobile menu*/
function toggleMenu() {
    $('#mm-1').toggleClass('open');
    $('.mobile-menu-main').toggleClass('open');
    $('.mobile-bg').fadeToggle(200);
    $('html').toggleClass('remodal-is-locked scroll-disabled');
    $('body').toggleClass('scroll-disabled');
}
/*end mobile menu*/
$.fn.tabs = function() {
    var selector = this;
    this.each(function() {
        var obj = $(this);
        //  $(obj.attr('href')).hide();
        obj.click(function() {
            if (window.matchMedia('(max-width: 767px)').matches) {
                $('body,html').animate({scrollTop: 0}, 200);
            }else{
                $('body,html').animate({scrollTop: 0}, 200);
            }
            setTimeout(function(){

            }, 200)
            $(selector).removeClass('selected');

            $(this).addClass('selected');

            $($(this).attr('href')).fadeIn();

            $(selector).not(this).each(function(i, element) {
                $($(element).attr('href')).hide();
            });
            if($('body').hasClass('product-product')){
                if($(this).attr('href') == '#tab2'){
                    $('.product-images .thumb-images').slick('refresh');
                    $('body').removeClass('not_main_tab_active');
                    $('#tab-specification').fadeIn();
                    $('#tab-specification').addClass('short-specification');
                    $('.zoomContainer').css('display', 'block');
                    if (window.matchMedia('(min-width: 992px)').matches) {
                        if(!$('.sticky-block').hasClass('hidden')){
                            $('.sticky-block').addClass('hidden');
                        }
                        $('.tabs-body').css('display', 'block');
                    }
                } else if($(this).attr('href') == '#tab-specification'){
                    $('#tab-specification').removeClass('short-specification');
                    $('body').addClass('not_main_tab_active');
                    $('.zoomContainer').css('display', 'none');
                    if (window.matchMedia('(min-width: 992px)').matches) {
                        if($('.sticky-block').hasClass('hidden')){
                            $('.sticky-block').removeClass('hidden');
                        }
                        $('.tabs-body').css('display', 'flex');
                    }
                }else{
                    $('.zoomContainer').css('display', 'none');
                    $('body').addClass('not_main_tab_active');
                    if (window.matchMedia('(min-width: 992px)').matches) {
                        if($('.sticky-block').hasClass('hidden')){
                            $('.sticky-block').removeClass('hidden');
                        }
                        $('.tabs-body').css('display', 'flex');
                    }
                }
            }
            return false;
        });
    });
    $(this).show();
    $('#tab-specification').fadeIn();
};