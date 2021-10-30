function pop(item) {
    console.log(item);
}
function getURLVar(key) {
    console.log(key); return false;
    var value = [];

    var query = String(document.location).split('?');

    if (query[1]) {
        var part = query[1].split('&');

        for (i = 0; i < part.length; i++) {
            var data = part[i].split('=');

            if (data[0] && data[1]) {
                value[data[0]] = data[1];
            }
        }

        if (value[key]) {
            return value[key];
        } else {
            return '';
        }
    }
}

default_display = 'grid';
if (window.matchMedia('(min-width: 768px)').matches)  default_display = 'grid';

$(document).ready(function () {

    // Highlight any found errors
    $('.text-danger').each(function () {
        var element = $(this).parent().parent();

        if (element.hasClass('form-group')) {
            element.addClass('has-error');
        }
    });

    /*$('.scheme-link').on('click', function(e) {
        e.preventDefault();
        $('.scheme-item').show();
    });

    $('.scheme-link-up').on('click', function(e) {
        e.preventDefault();
        $('.scheme-item').hide();
    });*/

    // Currency
    $('#form-currency .currency-select').on('click', function (e) {
        e.preventDefault();

        $('#form-currency input[name=\'code\']').val($(this).attr('name'));

        $('#form-currency').submit();
    });

    // Language
    $('#form-language a').on('click', function (e) {
        e.preventDefault();

        $('#form-language input[name=\'code\']').val($(this).data('code'));

        $('#form-language').submit();
    });
    /*
            $('#search input[name=\'search\']').parent().find('button').on('click', function() {
            var url = $('base').attr('href') + 'index.php?route=product/search';

            var value = $('.header-search #search input[name=\'search\']').val();

            console.log(value);
            if (value) {
                url += '&search=' + encodeURIComponent(value);
                location = url;
            }



        });

        $('#search input[name=\'search\']').on('keydown', function (e) {
            var url = $('base').attr('href') + 'index.php?route=product/search';

            if (e.keyCode == 13) {
                var value = $('.header-search input[name=\'search\']').val();

                if (value) {
                    url += '&search=' + encodeURIComponent(value);
                    location = url;
                }

            }
        });
        */

    // Menu
    $('#menu .dropdown-menu').each(function () {
        var menu = $('#menu').offset();
        var dropdown = $(this).parent().offset();

        var i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu').outerWidth());

        if (i > 0) {
            $(this).css('margin-left', '-' + (i + 10) + 'px');
        }
    });
    if (!sessionStorage.getItem('display')) {
        sessionStorage.setItem('display', default_display);
        $(`#view-${default_display}-fake, #${default_display}-view`).addClass('active');
    }
    var $viewPickers = $('#grid-view, #list-view, #photo-view, #view-foto-fake, #view-list-fake, #view-grid-fake');
    // Product List
    $('#list-view').click(function () {
        sessionStorage.setItem('display', 'list');
        $('#content .product-grid > .clearfix').remove();

        //$('#content .product-layout').attr('class', 'product-layout product-list col-xs-12');
        // ����� ������� � ���� (������������ ������� !������� ��� �������)
        $('#content .row > .product-layout').attr('class', 'product-layout product-photo col-12');

        $viewPickers.removeClass('active');
        $('#list-view, #view-list-fake').addClass('active');

        if (window.matchMedia('(max-width: 767px)').matches) {
            $('.panel-sfv-catalogs .view .img-view-prod').attr('src', 'catalog/view/theme/OPC080193_6/images/page_category/view-list.svg');
            $('.panel-sfv-catalogs .view').attr('id', 'view-list-fake');
            $('#modal-view-product .view-ul li').removeClass('active');
            $('#view-list-fake').addClass('active');
        }
    });

    // Product Grid
    $('#grid-view').click(function () {
        sessionStorage.setItem('display', 'grid');
        // What a shame bootstrap does not take into account dynamically loaded columns
        var cols = $('#column-right, #column-left').length;

        if (cols == 2) {
            $('#content .product-layout').attr('class', 'product-layout product-grid col-lg-6 col-md-6 col-sm-4 col-12');
        } else if (cols == 1) {
            $('#content .product-layout').attr('class', 'product-layout product-grid col-xl-3 col-lg-4 col-md-3 col-sm-4 col-6');
        } else {
            $('#content .product-layout').attr('class', 'product-layout product-grid col-lg-2 col-md-3 col-sm-4 col-6');
        }

        $viewPickers.removeClass('active');
        $('#grid-view, #view-grid-fake').addClass('active');

        if (window.matchMedia('(max-width: 767px)').matches) {
            $('.panel-sfv-catalogs .view .img-view-prod').attr('src', 'catalog/view/theme/OPC080193_6/images/page_category/view-grid.svg');
            $('.panel-sfv-catalogs .view').attr('id', 'view-grid-fake');
            $('#modal-view-product .view-ul li').removeClass('active');
            $('#modal-view-product #view-grid-fake').addClass('active');
        }
    });
    // Product Photo
    $('#photo-view').click(function () {
        sessionStorage.setItem('display', 'photo');
        $('#content .product-grid > .clearfix').remove();

        // ����� ������� � ���� (������������ ������� !������� ��� �������)
        $('#content .row > .product-layout').attr('class', 'product-layout product-list col-12');

        $viewPickers.removeClass('active');
        $('#photo-view, #view-foto-fake').addClass('active');

        if (window.matchMedia('(max-width: 767px)').matches) {
            $('.panel-sfv-catalogs .view .img-view-prod').attr('src', 'catalog/view/theme/OPC080193_6/images/page_category/view-foto.svg');
            $('.panel-sfv-catalogs .view').attr('id', 'view-foto-fake');
            $('#modal-view-product .view-ul li').removeClass('active');
            $('#modal-view-product #view-foto-fake').addClass('active');
        }
    });
    // $('#modal-view-product #view-foto-fake, #modal-view-product #view-list-fake, #modal-view-product #view-grid-fake')
    //     .addClass('active');
    switch(sessionStorage.getItem('display')) {
        case 'list':
            if (window.matchMedia('(max-width: 767px)').matches) {
                $('.panel-sfv-catalogs .view .img-view-prod').attr('src', 'catalog/view/theme/OPC080193_6/images/page_category/view-foto.svg');
                $('.panel-sfv-catalogs .view').attr('id', 'view-foto-fake');
                $('.panel-sfv-catalogs .view .img-view-prod').css('display', 'block');
            }
            $('#list-view').trigger('click');
            break;
        case 'photo':
            if (window.matchMedia('(max-width: 767px)').matches) {
                $('.panel-sfv-catalogs .view .img-view-prod').css('display', 'block');

            }
            $('#photo-view').trigger('click');
            break;
        default:
            if (window.matchMedia('(max-width: 767px)').matches) {
                $('.panel-sfv-catalogs .view .img-view-prod').attr('src', 'catalog/view/theme/OPC080193_6/images/page_category/view-grid.svg');
                $('.panel-sfv-catalogs .view').attr('id', 'view-grid-fake');
                $('.panel-sfv-catalogs .view .img-view-prod').css('display', 'block');
            }
            $('#grid-view').trigger('click');
            break;
    }


    // Checkout
    $(document).on('keydown', '#collapse-checkout-option input[name=\'email\'], #collapse-checkout-option input[name=\'password\']', function (e) {
        if (e.keyCode == 13) {
            $('#collapse-checkout-option #button-login').trigger('click');
        }
    });

    // tooltips on hover
    /*$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});*/

    // Makes tooltips work on ajax generated content
    $(document).ajaxStop(function () {
        //$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});
    });
});

var cart = {
    'add': function (product_id, quantity) {
        $.ajax({
            url: 'index.php?route=checkout/cart/add',
            type: 'post',
            data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
            dataType: 'json',
            success: function (json) {
                $('.alert, .text-danger').remove();

                if (json['redirect']) {
                    location = json['redirect'];
                }

                if (json['success']) {
                    $('.envelop_header').after('<div class="alert alert-success"><img src="catalog/view/theme/OPC080193_6/images/page_category/basket_done.svg" alt="basket">' + json['success'] + '</div>');
                    setTimeout(function(){$('.alert').remove();}, 3000);
                    //$('[data-product-id="' + product_id + '"] .product-panel .btn-buy img').attr("src","catalog/view/theme/OPC080193_6/images/page_category/basket_done.svg").parent().addClass('added_to_cart');
                    if($('[data-product-id="' + product_id + '"] .product-panel .btn-buy .card-img').hasClass('basket_empty')){
                        $('[data-product-id="' + product_id + '"] .product-panel .btn-buy .card-img').removeClass('basket_empty').addClass('basket_done').parent().addClass('added_to_cart');
                    }
                    $('[data-product-id="' + product_id + '"] .product-panel .btn-buy').not('.button-page-category .btn-buy').attr("tooltip", $('#button-incart').val());


                    $('#cart').load('index.php?route=common/cart/info');
                    $('.cart-packing > i').html(json['total']);
                    //$('#header-mob .cart').trigger('click');

                }
            }
        });
    },
    'updateCart': function (product_id, key, flag) {

        var totalQnty = parseFloat($('.cart-packing > i').text());
        var input = $('input[name=\'' + key + '\']');

        if (flag == '+') {
            input.val(parseFloat(input.val()) + 1);
            totalQnty++;
        }

        if (flag == '-') {
            if(parseFloat(input.val()) > 1){
                input.val(parseFloat(input.val()) - 1);
                totalQnty--;
            }else{
                return;
            }

        }
        var qnty = parseFloat(input.val());

        console.log(qnty);

        if (qnty === '') {
            return;
        }


        $.ajax({
            type: 'post',
            data: 'quantity[' + key + ']=' + qnty,
            url: 'index.php?route=checkout/cart/edit',
            dataType: 'html',
            success: function (data) {

                $('#cart').load('index.php?route=common/cart/info #cart > *');
                $('.cart-packing').load('index.php?route=common/header/info .cart-packing > *');
                //$('.cart-packing > i').html(totalQnty);
                if(qnty < 1) {
                    $('[data-product-id="' + product_id + '"] .product-panel .btn-buy img').attr("src","catalog/view/theme/OPC080193_6/images/cart-with-wheels.svg");
                    $('[data-product-id="' + product_id + '"] .product-panel .btn-buy').not('.button-page-category .btn-buy').attr("tooltip", $('#button-cart-add').val());
                } else {
                    $('[data-product-id="' + product_id + '"] .product-panel .btn-buy img').attr("src","catalog/view/theme/OPC080193_6/images/incart-with-wheels.svg");
                    $('[data-product-id="' + product_id + '"] .product-panel .btn-buy').not('.button-page-category .btn-buy').attr("tooltip", $('#button-incart').val());
                }


                if ($('[data-onchange="changeProductQuantity"]').length > 0) {
                    $('[data-onchange="changeProductQuantity"]').val(qnty).trigger("change");
                }


            }
        });

    },
    'remove': function (key, product_id = '') {
        $.ajax({
            url: 'index.php?route=checkout/cart/remove',
            type: 'post',
            data: 'key=' + key,
            dataType: 'json',
            beforeSend: function () {
            },
            complete: function () {
            },
            success: function (json) {

                $('#product' + json['cart_id']).fadeOut(function () {
                    $('#product' + json['cart_id']).remove();
                });

                $('#cart').load('index.php?route=common/cart/info');
                $('.cart-packing > i').html(json['total']);

                if(product_id != '') {
                    console.log("log");
                    $('[data-product-id="' + product_id + '"] .product-panel .btn-buy img').attr("src","catalog/view/theme/OPC080193_6/images/cart-with-wheels.svg");
                    $('[data-product-id="' + product_id + '"] .product-panel .btn-buy').not('.button-page-category .btn-buy').attr("tooltip", $('#button-cart-add').val());
                }

            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
}

var voucher = {
    'add': function () {

    },
    'remove': function (key) {
        $.ajax({
            url: 'index.php?route=checkout/cart/remove',
            type: 'post',
            data: 'key=' + key,
            dataType: 'json',
            beforeSend: function () {
                $('#cart > button').button('loading');
            },
            complete: function () {
                $('#cart > button').button('reset');
            },
            success: function (json) {
                // Need to set timeout otherwise it wont update the total
                setTimeout(function () {
                    $('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');
                }, 100);

                if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') {
                    location = 'index.php?route=checkout/cart';
                } else {
                    $('#cart > ul').load('index.php?route=common/cart/info ul li');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
}


var wishlist = {

    'add': function (product_id) {
        $.ajax({
            url: 'index.php?route=account/wishlist/add',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            success: function (json) {

                console.log(json);
                //var favoriveButtons = $('[data-product-id="' + product_id + '"] .btn-wishlist i, [data-product-id="' + product_id + '"] .product-panel .btn-wishlist-incatalog i, .wishlist-in-product .btn-wishlist-incatalog i');
                var favoriveButtons = $('[data-product-id="' + product_id + '"] .btn-wishlist img');
                var favoriveButtons2 = $('[data-product-id="' + product_id + '"] .btn-wishlist, [data-product-id="' + product_id + '"] .product-panel .btn-wishlist-incatalog, .wishlist-in-product .btn-wishlist-incatalog');
                if (json['success'] === 'add') {
                    $('.envelop_header').after('<div class="alert alert-success"><img src="catalog/view/theme/OPC080193_6/images/page_product/heart.svg">' + json['success_message'] + '</div>');
                    setTimeout(function(){$('.alert').remove();}, 3000);
                    $('.wishlist-in-product img').attr('src', 'catalog/view/theme/OPC080193_6/images/page_product/heart.svg');
                    $('#button_wishlist'+ product_id + ' span').text($('#text-inwishlist').val());
                    $('#button_wishlist'+ product_id + ' path').attr('stroke', '#6F38AB');
                    $('#button_wishlist'+ product_id).addClass('added_to_wishlist');
                    favoriveButtons.attr('src', 'catalog/view/theme/OPC080193_6/images/page_product/heart.svg').parent().addClass('added_alredy');
                    if( !$('[data-product-id="' + product_id + '"]').parent().hasClass("owl-item") ) {
                        favoriveButtons2.attr("tooltip", $('#text-inwishlist').val());
                    }

                } else {
                    $('.envelop_header').after('<div class="alert alert-success"><img src="catalog/view/theme/OPC080193_6/images/page_product/heart.svg">' + json['success_message'] + '</div>');
                    setTimeout(function(){$('.alert').remove();}, 3000);
                    $('.wishlist-in-product img').attr('src', 'catalog/view/theme/OPC080193_6/images/page_product/heart-o.svg');
                    $('#button_wishlist'+ product_id + ' span').text($('#text-wishlist').val());
                    $('#button_wishlist'+ product_id + ' path').attr('stroke', '#959595');
                    $('#button_wishlist'+ product_id).removeClass('added_to_wishlist');
                    favoriveButtons.attr('src', 'catalog/view/theme/OPC080193_6/images/page_category/favorites.svg').parent().removeClass('added_alredy');
                    if( !$('[data-product-id="' + product_id + '"]').parent().hasClass("owl-item") ) {
                        favoriveButtons2.attr("tooltip", $('#text-wishlist').val());
                    }
                }

                $('#wishlist-total span').html(json['total']);
                $('#wishlist-total').attr('title', json['text_total']);

            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    },
    'get': function (product_id) {
        $.ajax({
            url: 'index.php?route=account/wishlist/get',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            success: function (json) {

                /*if(json['in_wishlist']) {
                    console.log("yes");
                }*/
                var favoriveButtons = $('[data-product-id="' + product_id + '"] .btn-wishlist i, [data-product-id="' + product_id + '"] .product-panel .btn-wishlist-incatalog i, .wishlist-in-product .btn-wishlist-incatalog i');
                var favoriveButtons2 = $('[data-product-id="' + product_id + '"] .btn-wishlist, [data-product-id="' + product_id + '"] .product-panel .btn-wishlist-incatalog, .wishlist-in-product .btn-wishlist-incatalog');
                if (json['in_wishlist']) {
                    favoriveButtons.removeClass('fa-heart-o').addClass('fa-heart');
                    if( !$('[data-product-id="' + product_id + '"]').parent().hasClass("owl-item") ) {
                        favoriveButtons2.attr("tooltip", $('#text-inwishlist').val());
                    }

                } else {
                    favoriveButtons.addClass('fa-heart-o').removeClass('fa-heart');
                    if( !$('[data-product-id="' + product_id + '"]').parent().hasClass("owl-item") ) {
                        favoriveButtons2.attr("tooltip", $('#text-wishlist').val());
                    }
                }

                //$('#wishlist-total span').html(json['total']);
                //$('#wishlist-total').attr('title', json['text_total']);

            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    },
    'remove': function () {
        $('#wishlist-total span').html(json['total']);
        $('#wishlist-total').attr('title', json['text_total']);
    },
    'remove_p': function (product_id) {
        $.ajax({
            url: '/wishlist/?remove='+product_id,
            type: 'get',
            success: function () {

                $('[data-product-id="' + product_id + '"]').parent(".product-layout").remove();
                wishVal = parseInt($('#wishlist-total span').text()) - 1;
                $('#wishlist-total span').html(wishVal);
                $('#wishlist-total').attr('title', wishVal);

                if(wishVal < 1) {
                    var textEmpty = $('#text-empty').val();
                    $('.header-simplecheckout-cart').after('<p>'+textEmpty+'</p>');
                    location = '/';
                }
                if($('.account-box-wishlist .product-layout').length < 13 && !$('.load-all-wishlist').hasClass('hidden')){
                    $('.load-all-wishlist').addClass('hidden');

                }

            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });

    }
}

var compare = {
    'add': function (product_id) {
        $.ajax({
            url: 'index.php?route=product/compare/add',
            type: 'post',
            data: 'product_id=' + product_id,
            dataType: 'json',
            success: function (json) {
                if (json['success']) {
                    /*$.notify({
                        message: json['success'],
                        target: '_blank'
                    }, {
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
                        z_index: 9999999,
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
                        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-success" role="alert">' +
                            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">&nbsp;&times;</button>' +
                            '<span data-notify="message"><i class="fa fa-check-circle"></i>&nbsp; {2}</span>' +
                            '<div class="progress" data-notify="progressbar">' +
                            '<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                            '</div>' +
                            '<a href="{3}" target="{4}" data-notify="url"></a>' +
                            '</div>'
                    });*/

                    $('#compare-total').html(json['total']);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    },
    'remove': function () {

    }
}

/* Agree to Terms */
$(document).delegate('.agree', 'click', function (e) {
    e.preventDefault();

    $('#modal-agree').remove();

    var element = this;

    $.ajax({
        url: $(element).attr('href'),
        type: 'get',
        dataType: 'html',
        success: function (data) {
            html = '<div id="modal-agree" class="modal">';
            html += '  <div class="modal-dialog">';
            html += '    <div class="modal-content">';
            html += '      <div class="modal-header">';
            html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
            html += '        <h4 class="modal-title">' + $(element).text() + '</h4>';
            html += '      </div>';
            html += '      <div class="modal-body">' + data + '</div>';
            html += '    </div';
            html += '  </div>';
            html += '</div>';

            $('body').append(html);

            $('#modal-agree').modal('show');
        }
    });
});

// Autocomplete */
(function ($) {
    $.fn.autocomplete = function (option) {
        return this.each(function () {
            this.timer = null;
            this.items = new Array();

            $.extend(this, option);

            $(this).attr('autocomplete', 'off');

            // Focus
            $(this).on('focus', function () {
                this.request();
            });

            // Blur
            $(this).on('blur', function () {
                setTimeout(function (object) {
                    object.hide();
                }, 200, this);
            });

            // Keydown
            $(this).on('keydown', function (event) {
                switch (event.keyCode) {
                    case 27: // escape
                        this.hide();
                        break;
                    default:
                        this.request();
                        break;
                }
            });

            // Click
            this.click = function (event) {
                event.preventDefault();

                value = $(event.target).parent().attr('data-value');

                if (value && this.items[value]) {
                    this.select(this.items[value]);
                }
            }

            // Show
            this.show = function () {
                var pos = $(this).position();

                $(this).siblings('ul.dropdown-menu').css({
                    top: pos.top + $(this).outerHeight(),
                    left: pos.left
                });

                $(this).siblings('ul.dropdown-menu').show();
            }

            // Hide
            this.hide = function () {
                $(this).siblings('ul.dropdown-menu').hide();
            }

            // Request
            this.request = function () {
                clearTimeout(this.timer);

                this.timer = setTimeout(function (object) {
                    object.source($(object).val(), $.proxy(object.response, object));
                }, 200, this);
            }

            // Response
            this.response = function (json) {
                html = '';

                if (json.length) {
                    for (i = 0; i < json.length; i++) {
                        this.items[json[i]['value']] = json[i];
                    }

                    for (i = 0; i < json.length; i++) {
                        if (!json[i]['category']) {
                            html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
                        }
                    }

                    // Get all the ones with a categories
                    var category = new Array();

                    for (i = 0; i < json.length; i++) {
                        if (json[i]['category']) {
                            if (!category[json[i]['category']]) {
                                category[json[i]['category']] = new Array();
                                category[json[i]['category']]['name'] = json[i]['category'];
                                category[json[i]['category']]['item'] = new Array();
                            }

                            category[json[i]['category']]['item'].push(json[i]);
                        }
                    }

                    for (i in category) {
                        html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';

                        for (j = 0; j < category[i]['item'].length; j++) {
                            html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
                        }
                    }
                }

                if (html) {
                    this.show();
                } else {
                    this.hide();
                }

                $(this).siblings('ul.dropdown-menu').html(html);
            }

            $(this).after('<ul class="dropdown-menu"></ul>');
            $(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));

        });
    }
})(window.jQuery);
