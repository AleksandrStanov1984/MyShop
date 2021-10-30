<?php if (count($modules) > 1) { ?>
  <div id="products-tabs-content" class="tab-content-carousel" style="padding-top: 14px">
<?php }else{ ?>
    <?php foreach ($modules as $key => $m) { ?>
      <?php if ($m['products']) { ?>
        <div class="owl-one-carousel">
      <?php }?>
    <?php }?>
<?php }?>
<?php foreach ($modules as $key => $m) { ?>
    <?php if ($m['products']) { ?>
      <div class="tab-pane-carousel <?php echo $key?> <?php echo $key == 0 ? 'active': ''; ?> catalog-mobile block-products" id="tab-carousel-<?php echo $m['module']; ?>">
            <div class="">
            <?php $is_first_tab = true; ?>
            <?php if ($m['show_title'] == 1) { ?>
            <div class="title-feature-carousel"> <?php echo $m['heading_title']; ?>

              <!--  <?php if (count($modules) > 1) { ?><span class="popular-title-tab title-first-cell hidden-sm hidden-md hidden-lg"><?php echo $m['subtitle'] ? $m['subtitle'].' /' : ''; ?></span><?php }?><span class="title-second-cell"> </span><?php if($m['link_see_all']){ ?><a class=" show-full" href="<?php echo $m['link_see_all']; ?>"><?php echo $text_see_all; ?></a><?php } ?>-->
                </div>


            <?php } ?>
                <div id="owl-<?php echo $m['module']; ?>" class="owl-carousel slider-popular cat__slider-products" style="display: flex;">
                  <?php foreach ($m['products'] as $product) { ?>
                    <div class="item">

                      <div class="image"><a href="<?php echo $product['href']; ?>" data-hpm-href="1"><img  src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $product['thumb']; ?>" class="lazy-sz" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
                      <a class="name" href="<?php echo $product['href']; ?>" data-hpm-href="1"><?php echo $product['name']; ?></a>

        <?php echo !empty($product['hpm_block']) ? $product['hpm_block'] : ''; ?>
      
                      <div class="all-info-product">
                        <div class="size"><?php if ($product['height']){ ?>
                         <span class="units-product"><?php echo $unit_h; ?>:</span> <?php echo $product['height'] ?><?php } ?><?php if ($product['width']){ ?> <span class="units-product"> <?php echo $unit_w; ?>:</span> <?php echo $product['width'] ?><?php } ?> <?php if ($product['height']){ ?><span class="units-product"> <?php echo $unit_l; ?>:</span> <?php echo $product['length'] ?><?php } ?>
                         <?php if ($product['diameter_of_pot']){ ?>
                         <img src="catalog/view/theme/OPC080193_6/images/diameter_of_pot.svg" class="img-diameter-of-pot img-icon-pot" alt="diameter"> <?php echo $product['diameter_of_pot'];?> <?php echo $unit; ?> <?php } ?><?php if ($product['depth_of_pot']){ ?> <img src="catalog/view/theme/OPC080193_6/images/depth_of_pot.svg" class="img-depth-of-pot img-icon-pot" alt="depth"><?php echo $product['depth_of_pot'];?> <?php echo $unit; ?><?php } ?>
                         </div>
                          <?php if ($product['rating']) { ?>
                          <div class="rating">
                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <?php if ($product['rating'] < $i) { ?>
                            <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                            <?php } else { ?>
                            <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                            <?php } ?>
                            <?php } ?>
                          </div>
                        <?php } ?>
                        <div class="product-panel">
                        <?php if ($product['price']) { ?>
                        <div class="price">
                          <?php if($product['special']){ ?>
                          <div class="price-old"><?php echo $product['price'] ?></div>
                            <div class="price-new"><?php echo $product['special'] ?></div>
                            <?php }else{ ?>
                            <div class="price-regular"><?php echo $product['price'] ?></div>
                            <?php } ?>
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                    </div>
                    <!--<div class="item for-account" style="height: 100%">
                      <div class="image">
                        <a class="lazy-link" href="<?php echo $product['href']; ?>" data-hpm-href="1"><img  style="width: 150px"  data-src="<?php echo $product['thumb'] ? $product['thumb'] : HTTP_SERVER . 'image/no_image.png' ; ?>" src="image/loader-gray.gif" alt="<?php echo $product['name']; ?>" class="img-responsive lazy-sz"/></a>
                      </div>
                      <div class="size"><?php if ($product['height']){ ?>
                        <span class="units-product"><?php echo $unit_h; ?>:</span> <?php echo $product['height'] ?><?php } ?><?php if ($product['width']){ ?> <span class="units-product"> <?php echo $unit_w; ?>:</span> <?php echo $product['width'] ?><?php } ?> <?php if ($product['height']){ ?><span class="units-product"> <?php echo $unit_l; ?>:</span> <?php echo $product['length'] ?><?php } ?>
                        <?php if ($product['diameter_of_pot']){ ?>
                        <img src="catalog/view/theme/OPC080193_6/images/diameter_of_pot.svg" class="img-diameter-of-pot img-icon-pot" alt="diameter"> <?php echo $product['diameter_of_pot'];?> <?php echo $unit; ?> <?php } ?><?php if ($product['depth_of_pot']){ ?> <img src="catalog/view/theme/OPC080193_6/images/depth_of_pot.svg" class="img-depth-of-pot img-icon-pot" alt="depth"><?php echo $product['depth_of_pot'];?> <?php echo $unit; ?><?php } ?>
                      </div>
                      <?php if ($m['show_name'] == 1) { ?>
                      <a class="name" href="<?php echo $product['href']; ?>" data-hpm-href="1"><?php echo $product['name']; ?></a>
                      <?php } ?>

                      <div class="product-panel">
                        <?php if ($product['price'] && $m['show_price'] == 1) { ?>
                        <div class="price">
                        <?php if($product['special']){ ?>
                          <div class="price-new"><?php echo $product['special'] ?></div>
                          <div class="price-old"><?php echo $product['price'] ?></div>
                        <?php }else{ ?>
                          <div class="price-regular"><?php echo $product['price'] ?></div>
                        <?php } ?>
                          </div>
                      <?php } ?>
                      </div>
                    </div>-->
                  <?php } ?>
                  </div>

            <script>$(document).ready(function() {function random(owlSelector){owlSelector.children().sort(function(){return Math.round(Math.random()) - 0.5;}).each(function(){$(this).appendTo(owlSelector);});}var owl = $("#owl-<?php echo $m['module']; ?>");
                owl.owlCarousel({
                    dots:false,
                    navText: ['<i id="prev_carousel_account"></i>','<i id="next_carousel_account"></i>'],
                    <?php if ($m['show_nav'] == 1) { ?>nav: true,<?php } ?>
                    responsiveClass:true,
                    responsive:{
                            0:{
                                loop:false,
                                mouseDrag: false,
                                touchDrag: false,
                                autoWidth: false,
                                items: 2.5,
                                nav: false,
                            },
                            375:{
                                loop:false,
                                items: 2.7,
                                autoWidth: false,
                                //nav: false,
                                //items: 2
                            },
                            479:{
                                loop:false,
                                items: 2.9,
                                autoWidth: false,
                                //nav: false,
                                //items: 2
                            },
                             500:{
                                loop:false,
                                items: 3.2,
                                autoWidth: false,
                                nav: false
                            },
                            600:{
                                loop:false,
                                items: 3.8,
                                autoWidth: false,
                                nav: false
                            },
                            768:{
                                mouseDrag: true,
                                touchDrag: true,
                                //autoWidth: true,
                                nav: true,
                                <?php echo $m['add_class_name'] == 'viewed-products' ? 'loop:false,' : 'loop:true,'; ?>
                                items: 2
                            },
                            900:{
                                mouseDrag: true,
                                <?php echo $m['add_class_name'] == 'viewed-products' ? 'loop:false,' : 'loop:true,'; ?>
                                touchDrag: true,
                                //autoWidth: true,
                                nav: true,
                                items: 3
                            },
                            1150:{
                                nav:true,
                                <?php echo $m['add_class_name'] == 'viewed-products' ? 'loop:false,' : 'loop:true,'; ?>
                                //autoWidth: true
                                items: 4
                            },
                            1260:{
                                nav:true,
                                <?php echo $m['add_class_name'] == 'viewed-products' ? 'loop:false,' : 'loop:true,'; ?>
                                items: 5
                                //autoWidth: true
                            },
                            1390:{
                                nav:true,
                                <?php echo $m['add_class_name'] == 'viewed-products' ? 'loop:false,' : 'loop:true,'; ?>
                                items: 6
                                //autoWidth: true
                            },
                        },
                    <?php if ($m['show_random_item'] == 1) { ?>beforeInit : function(elem){random(elem);},<?php } ?>
                    });
                /*owl.owlCarousel({items : <?php echo $m['visible']; ?>,itemsDesktop : [1000,<?php echo $m['visible_1000']; ?>],itemsDesktopSmall : [900,<?php echo $m['visible_900']; ?>],itemsTablet: [600,<?php echo $m['visible_600']; ?>],itemsMobile : [479,<?php echo $m['visible_479']; ?>],<?php if ($m['show_random_item'] == 1) { ?>beforeInit : function(elem){random(elem);},<?php } ?><?php if ($m['show_nav'] == 1) { ?>navigation: true,<?php } ?><?php if ($m['slide_speed']) { ?>slideSpeed: <?php echo $m['slide_speed']; ?>,<?php } ?><?php if ($m['pagination_speed']) { ?>paginationSpeed: <?php echo $m['pagination_speed']; ?>,<?php } ?><?php if ($m['autoscroll']) { ?>autoPlay: <?php echo $m['autoscroll']; ?>,<?php } ?><?php if ($m['show_stop_on_hover'] == 1) { ?>stopOnHover: true,<?php } ?><?php if ($m['rewind_speed']) { ?>rewindSpeed: <?php echo $m['rewind_speed']; ?>,<?php } ?><?php if ($m['show_lazy_load'] == 1) { ?>lazyLoad : true,<?php } ?><?php if ($m['show_mouse_drag'] == 0) { ?>mouseDrag: false,<?php } ?><?php if ($m['show_touch_drag'] == 1) { ?>touchDrag: true,<?php } ?><?php if ($m['show_page'] == 0) { ?>pagination: false,<?php } ?><?php if ($m['show_per_page'] == 1) { ?>scrollPerPage: true,<?php } ?><?php if ($m['item_prev_next'] && $m['show_per_page'] == 0) { ?>slideItems: <?php echo $m['item_prev_next']; ?>,<?php } ?>navigationText: ['', ''],});
                <?php if (count($modules) > 1) { ?>$('#nav-owl-<?php echo $module; ?> a:first').tab('show');$('#nav-owl-<?php echo $module; ?> a').click(function (e) {e.preventDefault();$(this).tab('show');})<?php } ?>*/});
            </script>

        </div>
        <?php $is_first_tab = false; ?>

  </div>
    <?php } ?>
<?php } ?>

<?php if (count($modules) > 1) { ?>
</div>
<?php } else{ ?>
    <?php foreach ($modules as $key => $m) { ?>
      <?php if ($m['products']) { ?>
        </div>
      <?php }?>
    <?php }?>
<?php } ?>
<?php foreach ($modules as $key => $m) { ?>
    <?php if (isset($m['microdata']) && $m['microdata']) echo $m['microdata']; ?>
<?php } ?>
<?php if (count($modules) > 1) { ?>
        <div class="novelties-tab-container">
    <div class="tabs-carousel" id="nav-carousel-<?php echo $module; ?>">
        <div class="item j-novelties-switcher">
        <?php $is_first_tab = true; ?>
        <?php foreach ($modules as $key => $m) {?>
            <?php if ($m['products']) { ?>
                <div class="j-tab-switcher <?php echo $key == 0 ? 'active': ''; ?>"><a href="#tab-carousel-<?php echo $m['module']; ?>"><?php echo $m['heading_title']; ?></a></div>
                <?php $is_first_tab = false; ?>
            <?php } ?>
        <?php } ?>
    </div></div></div>

    <script>
    $(document).ready(function(){
        $('.j-tab-switcher').on('click', function (e){
            e.preventDefault();
            $('.j-tab-switcher.active').removeClass('active');
            $(this).addClass('active');
            var tab = $(this).find('a').attr('href');
            $('.tab-content-carousel .tab-pane-carousel.active').removeClass('active')
            $(tab).addClass('active loading-tab-carousel');


            setTimeout(function(){$(tab).removeClass('loading-tab-carousel');}, 700);


        })
    })
</script>
<?php } ?>
