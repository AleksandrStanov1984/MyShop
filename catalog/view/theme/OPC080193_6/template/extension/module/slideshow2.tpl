<?php if($template == 'column'){?>
<div>
<div id="aner-column" class="aner-column">
<?php foreach ($banners as $banner) { ?>
<?php if($banner['link']) { ?>
<div class="aner-column-col">
<a href="<?php echo $banner['link']; ?>" class="small-image-zoom-container"><img data-src="<?php echo $banner['image']; ?>" src="catalog/view/theme/OPC080193_6/images/goods-picture.svg" class="img-responsive small-image-zoom lazy-sz" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">

</a></div>
<?php } else { ?>
<div class="aner-column-col" >
    <div class="small-image-zoom-container">
        <img data-src="<?php echo $banner['image']; ?>" src="catalog/view/theme/OPC080193_6/images/goods-picture.svg" class="img-responsive small-image-zoom lazy-sz"  alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" >
    </div></div>
<?php } ?>

<?php } ?>
</div>


</div>
<?php }else if($template == 'one_plus_four'){ ?>
<div class="hidden-xs hidden-sm">
    <div class="banners-bottom">

        <?php foreach ($banners as $key => $banner) { ?>
        <?php if($key == 2 || ($key !==0 && $key !== 3 && $key % 3 == 0)) { ?>
    </div><div class="banners-bottom">
        <?php } ?>
        <?php if($key == 0  || $key == 6 ) { ?>
        <?php if($banner['link']) { ?>
        <div class="banner780x280">
            <a href="<?php echo $banner['link']; ?>" class="small-image-zoom-container"><img data-src="<?php echo $banner['image']; ?>" src="catalog/view/theme/OPC080193_6/images/goods-picture.svg" class="img-responsive small-image-zoom lazy-sz" title="<?php echo $banner['title']; ?>" alt="<?php echo $banner['title']; ?>">
            </a>
        </div>
        <?php } else { ?>
        <div class="banner780x280">
            <div class="small-image-zoom-container">
                <img data-src="<?php echo $banner['image']; ?>" src="catalog/view/theme/OPC080193_6/images/medium-anner.svg" class="img-responsive small-image-zoom lazy-sz"  alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" >
            </div>
        </div>
        <?php } ?>
        <?php }else{ ?>
        <?php if($banner['link']) { ?>
        <div class="banner380x280">
            <a href="<?php echo $banner['link']; ?>" class="small-image-zoom-container"><img data-src="<?php echo $banner['image']; ?>" src="catalog/view/theme/OPC080193_6/images/goods-picture.svg" class="img-responsive small-image-zoom lazy-sz"  alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
            </a>
        </div>
        <?php } else { ?>
        <div class="banner380x280">
            <div class="small-image-zoom-container">
                <img data-src="<?php echo $banner['image']; ?>" src="catalog/view/theme/OPC080193_6/images/medium-anner.svg" class="img-responsive small-image-zoom lazy-sz" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
            </div>
        </div>
        <?php } ?>
        <?php } ?>
        <?php } ?>
    </div>


</div>
<?php }else if($template == 'small_three_in_arow'){ ?>
<div class="hidden-xs hidden-sm">
    <div class="banners-bottom">
        <?php foreach ($banners as $key => $banner) { ?>
        <?php if($banner['link']) { ?>
        <div class="banner380x280">
            <a href="<?php echo $banner['link']; ?>" class="small-image-zoom-container"><img data-src="<?php echo $banner['image']; ?>" src="catalog/view/theme/OPC080193_6/images/goods-picture.svg" class="img-responsive small-image-zoom lazy-sz" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
            </a>
        </div>
        <?php } else { ?>
        <div class="banner380x280">
            <div class="small-image-zoom-container">
                <img data-src="<?php echo $banner['image']; ?>" src="catalog/view/theme/OPC080193_6/images/medium-anner.svg" class="img-responsive small-image-zoom lazy-sz" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
            </div>
        </div>
        <?php } ?>
        <?php } ?>
    </div>


</div>
<?php }else if($template == 'slide_wide'){ ?>
<div class="hidden-xs hidden-sm">
    <div class="home__slider packing_slide_wide">
        <?php foreach ($banners as $banner) { ?>
        <?php if($banner['link']) { ?>
        <div class="item-slick">
            <div class="banners-zones">
                <img src="<?php echo $banner['image']; ?>" class="home_slider_item slide_wide img-responsive" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
                <a href="<?php echo $banner['link']; ?>" class="item-slick-a">
                </a></div>
            <!--<a href="<?php echo $banner['link']; ?>" class="item-slick-a"><div class="banners-zones" style="background-image: url(<?php echo $banner['image']; ?>);    background-position:center center;
 background-size:cover;"></a>-->


        </div>


    </div>
    <?php } else { ?>
    <div class="item-slick">
        <div class="banners-zones"><img src="<?php echo $banner['image']; ?>" class="home_slider_item slide_wide img-responsive" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">


        </div></div>
    <?php } ?>

    <?php } ?>
</div>
<ul class="front-slider-counter" style="display: none">
    <li><span class="front-count-slides-wrap"><span class="front-count-slides-current">1</span></span></li><li><span class="front-count-slides-total"></span></li>
</ul>
</div>
<!-- slide show 2 # -->
<script>
    $(document).ready(function(){
        $('.home__slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            cssEase:'linear',
            arrow: false,
            speed: 300,
            autoplay: true,
            autoplaySpeed: 5000,
            dots: true,
            //appendDots: $('.main-slider-dots'),
            responsive: [{
                breakpoint: 767,
                settings: {
                    fade: false,
                }
            }, ]
        });

        $('.home__slider').on("afterChange", function(event, slick, currentSlide){

            $('.front-count-slides-current').text(currentSlide+1);
        });
        var countSlider = $(".home__slider").slick("getSlick").slideCount;
        if (countSlider == 1){
            $('.front-slider-counter').addClass('hidden');
        }
        $('.front-count-slides-total').text('/'+ countSlider);
        var widthSlider = $('.slick-dots').width();
        var widthDots = widthSlider/countSlider-8+'px';
        $('.slick-dots li button').css("max-width", widthDots);
        $(window).resize(function() {
            var widthSlider = $('.slick-dots').width();
            var widthDots = widthSlider/countSlider-8+'px';
            $('.slick-dots li button').css("max-width", widthDots);

        });
    });
</script>
<!-- slide show 2 # -->
<?php } else if($template == 'two_half'){?>
<div>
<div class="aner-column owl-carousel">
<?php foreach ($banners as $banner) { ?>
<?php if($banner['link']) { ?>
<div class="aner-column-col">
<a href="<?php echo $banner['link']; ?>"><img data-src="<?php echo $banner['image']; ?>" src="catalog/view/theme/OPC080193_6/images/goods-picture.svg" class="img-responsive lazy-sz" style="margin-top: 10px" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">

</a></div>
<?php } else { ?>
<div class="aner-column-col">
    <img data-src="<?php echo $banner['image']; ?>" src="catalog/view/theme/OPC080193_6/images/goods-picture.svg" class="img-responsive lazy-sz" style="margin-top: 10px" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
</div>
<?php } ?>

<?php } ?>
</div>


</div>

<?php }else if($template == 'medium'){ ?>
<div class="anner-medium" style="margin-bottom: 24px; margin-top: 24px">
    <div class="row">
        <?php foreach ($banners as $banner) { ?>
        <?php if($banner['link']) { ?>
        <div class="col-md-6">
            <a href="<?php echo $banner['link']; ?>" class="small-image-zoom-container"><img data-src="<?php echo $banner['image']; ?>" src="catalog/view/theme/OPC080193_6/images/goods-picture.svg" class="img-responsive small-image-zoom lazy-sz" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
            </a>
        </div>
        <?php } else { ?>
        <div class="col-md-6">
            <div class="small-image-zoom-container">
                <img data-src="<?php echo $banner['image']; ?>" src="catalog/view/theme/OPC080193_6/images/medium-anner.svg" class="img-responsive small-image-zoom lazy-sz" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
            </div>
        </div>
        <?php } ?>

        <?php } ?>
    </div>


</div>
<?php }else if($template == 'hight_banner'){ ?>
<div class="hidden-xs hidden-sm">
    <div class="banners-left">
        <?php foreach ($banners as $banner) { ?>
        <?php if($banner['link']) { ?>
        <div class="banner380x580">
            <a href="<?php echo $banner['link']; ?>" class="small-image-zoom-container"><img data-src="<?php echo $banner['image']; ?>" src="catalog/view/theme/OPC080193_6/images/goods-picture.svg" class="img-responsive small-image-zoom lazy-sz" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
            </a>
        </div>
        <?php } else { ?>
        <div class="banner380x580">
            <div class="small-image-zoom-container">
                <img data-src="<?php echo $banner['image']; ?>" src="catalog/view/theme/OPC080193_6/images/medium-anner.svg" class="img-responsive small-image-zoom lazy-sz" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" >
            </div>
        </div>
        <?php } ?>

        <?php } ?>
    </div>


</div>
<?php }else if($template == 'four'){ ?>
<div class="anner-quartet">

    <div class="row row-anner-quarter">
        <?php foreach ($banners as $banner) { ?>
        <?php if($banner['link']) { ?>
        <div class="col-xl-3 col-lg-3 col-sm-6 col-md-6 col-6 col-anner-quarter">
            <a href="<?php echo $banner['link']; ?>" class="small-image-zoom-container"><img src="<?php echo $banner['image']; ?>" class="img-responsive anner-quartet-img small-image-zoom" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
            </a></div>
        <?php } else { ?>
        <div class="col-xl-3 col-lg-3 col-sm-3 col-6 col-sm-6 col-anner-quarter">
            <div class="small-image-zoom-container">
                <img src="<?php echo $banner['image']; ?>" class="img-responsive anner-quartet-img small-image-zoom" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" >
            </div></div>
        <?php } ?>

        <?php } ?>
    </div>

</div>
<?php }else if($template == 'slide'){ ?>
<div class="anner-slide hidden-md hidden-lg hidden-sm owl-carousel">
    <?php foreach ($banners as $key => $banner) { ?>
    <?php if($banner['link']) { ?>
    <div>
        <a href="<?php echo $banner['link']; ?>"><img <?php echo $key==0 ? 'src': 'data-src'; ?>="<?php echo $banner['image']; ?>" class="img-responsive img-with-radius anner-slide-img <?php echo $key==0 ? '': 'owl-lazy'; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
        </a></div>
    <?php } else { ?>
    <div>
        <img <?php echo $key==0 ? 'src': 'data-src'; ?>="<?php echo $banner['image']; ?>" class="img-responsive img-with-radius anner-slide-img <?php echo $key==0 ? '': 'owl-lazy'; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" >
    </div>
    <?php } ?>

    <?php } ?>


</div>
<?php }else if($template == 'slider-in-sidebar'){ ?>

<div class="slider-in-sidebar">

    <?php foreach ($banners as $banner) { ?>
    <?php if($banner['link']) { ?>
    <div>
        <div class="title-slider-in-sidebar"><?php echo $title_slider_account_sidebar; ?></div>
        <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" class="img-responsive" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
        </a></div>
    <?php } else { ?>
    <div>
        <div class="title-slider-in-sidebar"><?php echo $title_slider_account_sidebar; ?></div>
        <img src="<?php echo $banner['image']; ?>" class="img-responsive" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" >
    </div>
    <?php } ?>

    <?php } ?>


</div>
<!-- slide show 2 #1 -->
<script>
    $(document).ready(function(){
        $('.slider-in-sidebar').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            cssEase:'linear',
            arrows: false,
            speed: 300,
            autoplay: true,
            autoplaySpeed: 5000,
            dots: true,
            responsive: [{
                breakpoint: 767,
                settings: {
                    fade: false,
                }
            }, ]
        });
    });
</script>
<!-- slide show 2 #1 -->
<?php }else if($template == 'slide_half'){ ?>
<div class="section-stock-of-day" id="section-stock-of-day">
    <div class="title-section-mob tilte-stock-day"><?php echo $title_stock_of_day; ?></div>
    <div class="anner-slide-half owl-carousel">

        <?php foreach ($banners as $banner) { ?>
        <?php if($banner['link']) { ?>
        <div class="owl-slade-half">
            <a href="<?php echo $banner['link']; ?>"><img src="catalog/view/theme/OPC080193_6/images/medium-anner.svg" data-src="<?php echo $banner['image']; ?>" class="img-responsive anner-quartet-half-img lazy-sz" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
            </a></div>
        <?php } else { ?>
        <div class="owl-slade-half">
            <img src="catalog/view/theme/OPC080193_6/images/medium-anner.svg" data-src="<?php echo $banner['image']; ?>" class="img-responsive anner-quartet-half-img lazy-sz" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
        </div>
        <?php } ?>

        <?php } ?>


    </div>
</div>

<?php }else if($template == 'slider_with_bg'){ ?>
<div class="section-slider_with_bg " id="slider_with_bg">
    <div class="slider_with_bg owl-carousel">
        <?php foreach ($banners as $banner) { ?>
        <?php if($banner['link']) { ?>
        <div class="item-slide-with-bg">
            <a href="<?php echo $banner['link']; ?>">
                <img src="catalog/view/theme/OPC080193_6/images/anner-with-bg.svg" data-src="<?php echo $banner['image']; ?>" class="img-responsive img-slide-with-bg lazy-sz" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
            </a></div>
        <?php } else { ?>
        <div class="item-slide-with-bg">
            <img src="catalog/view/theme/OPC080193_6/images/anner-with-bg.svg" data-src="<?php echo $banner['image']; ?>" class="img-responsive img-slide-with-bg lazy-sz" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
        </div>
        <?php } ?>

        <?php } ?>
    </div>
</div>
<?php }else if($template == 'foto_galery'){ ?>
<div class="section-foto-gallery">
    <div class="title-section-mob title-home-gallery"><?php echo $title_foto_gallery; ?></div>
    <div class="foto-gallery owl-carousel">

        <?php foreach ($banners as $banner) { ?>
        <?php if($banner['link']) { ?>
        <div class="owl-foto-gallery">
            <a href="<?php echo $banner['link']; ?>"><img src="image/loader-gray.gif" data-src="<?php echo $banner['image']; ?>" class="img-responsive img-with-radius lazy-sz" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
            </a></div>
        <?php } else { ?>
        <div class="owl-foto-gallery">
            <img src="image/loader-gray.gif" data-src="<?php echo $banner['image']; ?>" class="img-responsive img-with-radius lazy-sz" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" >
        </div>
        <?php } ?>

        <?php } ?>


    </div>
</div>
<!-- slide show 2 #5 -->

<!-- slide show 2 #5 -->
<?php }else if($template == 'foto_galery_black'){ ?>
<div class="section-foto_galery_black">
    <div class="fashion-list row">
        <div class="carousel-controls col-md-2 col-lg-3 col-xl-2">
            <div class="carousel-title-foto-galery"><?php echo $title_foto_gallery; ?></div>
        </div>
        <div class="fashion-list-carousel col-md-10 col-lg-9  col-xl-10">
            <div class="foto_galery_black owl-carousel">
                <?php foreach ($banners as $banner) { ?>
                <div class="owl-foto_galery_black">
                    <a href="<?php echo $banner['image']; ?>" data-fancybox="gallery" class="grouped_elements_gallery"><img data-src="<?php echo $banner['popup']; ?>" class="img-responsive img-with-radius lazy-sz" src="image/loader-gray.gif" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
                    </a>
                </div>

                <?php } ?>

            </div>
        </div>
    </div>
</div>
<!-- slide show 2 #6 -->

<!-- slide show 2 #6 -->
<?php } else{ ?>
<div style="margin-bottom: 24px; margin-top: 24px">

    <?php foreach ($banners as $banner) { ?>
    <?php if($banner['link']) { ?>

    <a href="<?php echo $banner['link']; ?>" class="small-image-zoom-container"><img data-src="<?php echo $banner['image']; ?>" src="catalog/view/theme/OPC080193_6/images/solo-anner.svg" class="img-responsive small-image-zoom lazy-sz" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">

    </a>
    <?php } else { ?>
    <div class="small-image-zoom-container">
        <img data-src="<?php echo $banner['image']; ?>" src="catalog/view/theme/OPC080193_6/images/solo-anner.svg" class="img-responsive small-image-zoom lazy-sz" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" >
    </div>
    <?php } ?>

    <?php } ?>


</div>
<?php }?>
