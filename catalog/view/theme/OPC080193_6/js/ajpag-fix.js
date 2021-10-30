String.prototype.numScan = function () {

    var data = this.split(/ /),

        numbers = [];

    for(var c, i = 0, il = data.length; i<il; i++) {

        c = data[i].replace(/^(|)$/g);

        if (!isNaN(c)) {

            numbers.push(c);

            data[i] = '%';

        }

    }

    return {

        string: data.join(' '),

        numbers: numbers

    };

};



var $document = $document || $(document),

    $window = $window || $(window),

    autoscroller = autoscroller || {};

$document.ready(function () {

    var defaults = {

        //setting

        hidePagination: 1,

        autoScroll: 0,

        catcher: '#endless',

        delay: 1000,

        disable_item_navigation: 1,

        loading: 0,

        catcher_label: "Показать еще",



        //setting

    },

    autoscroller = $.extend({}, defaults, autoscroller);

    $pagination = $('.pagination'),

    //limit_per_page = $('.block-products>.row>.product-layout').length,

     //limit_per_page = $('.block-products>.product-layout').length,
     limit_per_page = $('#content').data('limit'),
     total_products = $('#content').data('total'),
     showed_total = $('#content').data('showed'),
     counter_products = parseInt(total_products) - parseInt(showed_total),

     //total_products = $('#content').data('limit'),

    catcher = function() {

        return $(autoscroller.catcher);

    };





    $('#ajpag-fix').before(`<style>${autoscroller.catcher} {

        margin: 15px auto;

        padding: 10px;

        width: 100%;

        text-align: center;

        max-width: 360px;

    }</style>`);



    $pagination.parent().attr('class', 'col-sm-12 text-center').next().attr('class', 'col-sm-12 text-center');

    $pagination.children('li>a').each(function () {

        $(this).off('click.ajpag').on('click.ajpag', function () {

            if (autoscroller.disable_item_navigation) return false;

        });

    });

    $window.scroll(function () {


        if (inWindow(autoscroller.catcher) && !autoscroller.loading && autoscroller.autoScroll) {



            autoscroller.loading = true;

            catcher().find('.fa-refresh').addClass('fa-spin');



            setTimeout(function () {



                catcher().trigger('click');



            }, autoscroller.delay);



        }



    });



    if (autoscroller.hidePagination) {

        $pagination.hide();

    }

    if (limit_per_page < total_products) {


        //if ($pagination.length && !$pagination.children('li:last-child').hasClass('active')) {



            var inProgress = false;

            var page = 2;

            $pagination.closest('.row')

                .prepend(`<div class="col-sm-12 text-center"><button class="btn-main" id="endless"><img src="/catalog/view/theme/OPC080193_6/images/page_category/load_more.svg" alt="loader"><i>${autoscroller.catcher_label} (${limit_per_page})</i></button></div>`);


            function ajpag_handler(e) {

                var lastProduct = $('#content').find('.product-layout:last-child');


                //var nextPage = $('ul.pagination>li.active').last().next().find('a:first-child');

                if(!inProgress) {

                $.ajax({

                  //url: $(nextPage).attr('href'),

                   url: $('#content').data('url')+ '&page='+ page,

                    beforeSend: function () {

                        catcher().find('.fa-refresh').addClass('fa-spin');

                        $('#endless img').addClass('loader_moves');

                         inProgress = true;

                    },

                    success: function (data) {


                        var products = $(data).find('.product-layout');

                        if (products.length > 0) {

                        total_products = $(data).find('#content').data('total');
                        $('#content').data('total', total_products);


                        console.log('total pd'+total_products);
                        inProgress = false;

                        page += 1;

                        lastProduct.after(products);

                        switch ((localStorage.getItem('display')||sessionStorage.getItem('display'))) {

                            case 'grid':

                                var cols = $('#column-right, #column-left').length;



                                if (cols == 2) {

                                    $(products).attr('class', 'product-layout product-grid col-lg-6 col-md-6 col-sm-12 col-6');

                                } else if (cols == 1) {

                                    $(products).attr('class', 'product-layout product-grid col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6');

                                } else {

                                    $(products).attr('class', 'product-layout product-grid col-lg-2 col-md-3 col-sm-6 col-6');

                                }

                                break;

                            case 'list':

                                $(products).attr('class', 'product-layout product-photo col-12');

                                break;

                            case 'photo':

                                $(products).attr('class', 'product-layout product-list col-12');

                                break;

                        }

                        $('body,html').animate({

                        scrollTop: lastProduct.offset().top

                        }, 0);



                        /*$pagination.html($(data).find('.pagination > *'));

                        $pagination.find('li.active').prevAll().addClass('active');



                        nextPage = $('ul.pagination li.active').next().find('a:first-child');



                        var scan = $(data).find('.pagination').parent().next().text().numScan();

                        scan.string = scan.string.replace('%', 1);

                        for (var i = 1, il = scan.numbers.length; i<il; i++) {

                            scan.string = scan.string.replace('%', scan.numbers[i]);

                        }

                        $pagination.parent().next().text(scan.string);





                        if (nextPage.length == 0) {

                          //  catcher().remove();

                        } else {



                        }*/

                        catcher().find('.fa-refresh').removeClass('fa-spin');

                        $('#endless img').removeClass('loader_moves');

                        autoscroller.loading = 0;

                        lazyLoadFunction();

                        if(limit_per_page >= total_products) {
                            catcher().remove();

                        }

                      } else{

                          catcher().remove();

                      }

                    }

                });

                }



                return false;

            }

            catcher().off('click.ajpag').on('click.ajpag', ajpag_handler);



        //}

    }





    function inWindow(el) {

        if ($(el).length) {

            var scrollTop = $(window).scrollTop();

            var windowHeight = $(window).height();

            var offset = $(el).offset();



            if (scrollTop <= offset.top && ($(el).height() + offset.top) < (scrollTop + windowHeight))

                return true;

        }



        return false;

    }

    function lazyLoadFunction(){

    var lazyImages = [].slice.call(document.querySelectorAll("img.lazy-sz"));



    if ("IntersectionObserver" in window) {

    let lazyImageObserver = new IntersectionObserver(function(entries, observer) {

      entries.forEach(function(entry) {

        if (entry.isIntersecting) {

          let lazyImage = entry.target;

          lazyImage.src = lazyImage.dataset.src;

          //lazyImage.srcset = lazyImage.dataset.srcset;

          lazyImage.classList.remove("lazy-sz");

          lazyImage.classList.remove("lazy-sz");

          lazyImageObserver.unobserve(lazyImage);

          /*$('.product-layout.product-grid').each(function(){

            $(this).css('height', $(this).height());

          });*/

        }

      });

    });



    lazyImages.forEach(function(lazyImage) {

      lazyImageObserver.observe(lazyImage);

    });

  }}



});

