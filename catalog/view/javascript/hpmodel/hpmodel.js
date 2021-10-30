$(document).ready(function(){
    $(document).on('mouseenter', '.hpm-cat-item', function(){
        var $t = $(this); var $c = $t.closest('.product-thumb, .product, .item');
        if ($t.data('thumb')) {
            $c.find('.image img').attr('src', $t.data('thumb'));
        }
    });
    $(document).on('mouseleave', '.hpm-cat-box', function(){
        var $t = $(this); var $c = $t.closest('.product-thumb, .product, .item');
        var $a = $c.find('.hpm-cat-item.active');
        var $hc = $c.find('.hpm-cat-box');
        if ($a.length && $a.data('thumb')) {
            $c.find('.image img').attr('src', $a.data('thumb'));
        } else if ($hc.length && $hc.data('thumb')) {
            $c.find('.image img').attr('src', $hc.data('thumb'));
        }
    });
    $(document).on('click', '.hpm-cat-item', function(){
        var pp = $('.currency-value').eq(0).text();
        var $t = $(this); var $c = $t.closest('.product-thumb, .product, .item');
        $c.find('.hpm-cat-item').removeClass('active');
        $t.addClass('active');
        $c.find('[onclick*="cart.add("]').attr('onclick', 'cart.add('+$t.data('id')+',1)');
        $c.find('[onclick*="wishlist.add("]').attr('onclick', 'wishlist.add('+$t.data('id')+')');
        $c.find('[onclick*="compare.add"]').attr('onclick', 'compare.add('+$t.data('id')+')');
        $c.find('.hpm-cat-item').parents('.item').attr('data-product-id',  $t.data('id'));

        // wishlist heart
        $.ajax({
            url: 'index.php?route=account/wishlist/get',
            type: 'post',
            data: 'product_id=' + $t.data('id'),
            dataType: 'json',
            success: function (json) {

                var favoriveButtons = $('[data-product-id="' + $t.data('id') + '"] .btn-wishlist i, [data-product-id="' + $t.data('id') + '"] .product-panel .btn-wishlist-incatalog i, .wishlist-in-product .btn-wishlist-incatalog i');
                var favoriveButtons2 = $('[data-product-id="' + $t.data('id') + '"] .btn-wishlist, [data-product-id="' + $t.data('id') + '"] .product-panel .btn-wishlist-incatalog, .wishlist-in-product .btn-wishlist-incatalog');
                if (json['in_wishlist']) {
                    favoriveButtons.removeClass('fa-heart-o').addClass('fa-heart');
                    if( !$('[data-product-id="' + $t.data('id') + '"]').parent().hasClass("owl-item") ) {
                        favoriveButtons2.attr("tooltip", $('#text-inwishlist').val());
                    }

                } else {
                    favoriveButtons.addClass('fa-heart-o').removeClass('fa-heart');
                    if( !$('[data-product-id="' + $t.data('id') + '"]').parent().hasClass("owl-item") ) {
                        favoriveButtons2.attr("tooltip", $('#text-wishlist').val());
                    }
                }

            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });

        if ($t.data('price')) {
            var ph = '<div class="price-regular">'+$t.data('price').replace(/\D+/g,"")+'<span class="currency-value">'+pp+'</span></div>';
            if($('.sort_select').length) {
                if ($t.data('special')) ph = '<div class="price-old">'+$t.data('price').replace(/\D+/g,"")+'<span class="currency-value">'+pp+'</span></div><div class="price-new">'+$t.data('special').replace(/\D+/g,"")+'<span class="currency-value">'+pp+'</span></div>';
            } else {
                if ($t.data('special')) ph = '<div class="price-new">'+$t.data('special').replace(/\D+/g,"")+'<span class="currency-value">'+pp+'</span></div> <div class="price-old">'+$t.data('price').replace(/\D+/g,"")+'<span class="currency-value">'+pp+'</span></div>';
            }

            $c.find('.price').html(ph);
        }
        $c.find('a[data-hpm-href="1"]').attr('href', $t.data('href'));
        if ($t.data('name')) {
            //$c.find('.all-info-product a[data-hpm-href="1"]').text($t.data('name'));
            $c.find('.name').text($t.data('name'));
            $c.find('a[data-hpm-href="1"] img').attr('alt', $t.data('name')).attr('title', $t.data('name'));
        }
        if ($t.data('thumb')) {
            $c.find('.image img').attr('src', $t.data('thumb'));
        }
    });
    /*
    function hpm_onload() {
        //$('.hpm-cat-box').each(function(){if (!$(this).find('.hpm-cat-item.active').length)$(this).find('.hpm-cat-item').first().trigger('click');});
    }
    $(document).ready(function(){
        hpm_onload();
    });
    $(document).ajaxComplete(function(){
        hpm_onload();
    });
    */
}(jQuery));
