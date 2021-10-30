<?php if (count($modules) > 1) { ?>
    <ul class="nav nav-tabs" id="nav-owl-<?php echo $module; ?>">
    	<?php $is_first_tab = true; ?>
        <?php foreach ($modules as $m) {?>
            <?php if ($m['products']) { ?>
                <li><a href="#tab-owl-<?php echo $m['module']; ?>"><?php echo $m['heading_title']; ?></a></li>
                <?php $is_first_tab = false; ?>
            <?php } ?>
        <?php } ?>
    </ul>
<?php } ?>

<?php if (count($modules) > 1) { ?>
    <div id="products-tabs-content" class="tab-content">
<?php } ?>

<?php foreach ($modules as $m) { ?>
    <?php if ($m['products']) { ?>
        <?php $is_first_tab = true; ?>
        <div class="tab-pane" id="tab-owl-<?php echo $m['module']; ?>">
            <?php if ($m['show_title'] == 1) { ?>
                <h3><?php echo $m['heading_title']; ?></h3>
            <?php } ?>
            <div class="row product-layout <?php echo $m['add_class_name']; ?>">
                <div id="owl-<?php echo $m['module']; ?>" class="owl-carousel owl-moneymaker2 owl-moneymaker2-products">
                    <?php foreach ($m['products'] as $product) { ?>
                    <div class="col-lg-12 item">
                        <div class="product-thumb transition">
                            <?php if ($product['thumb']) { ?>
                                <div class="image">
                                    <a href="<?php echo $product['href']; ?>" data-hpm-href="1"><img <?php if ($m['show_lazy_load'] == 1) { ?>data-<?php } ?>src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" class="img-responsive <?php if ($m['show_lazy_load'] == 1) { ?>lazyOwl<?php } ?>"/></a>
                                </div>
                            <?php } ?>
                            <div class="caption">
                                <?php if ($m['show_name'] == 1) { ?>
                                    <h4><a href="<?php echo $product['href']; ?>" data-hpm-href="1"><?php echo $product['name']; ?></a></h4>
                                <?php } ?>
                                <?php if ($m['show_desc'] == 1) { ?>
                                    <p><?php echo $product['description']; ?></p>
                                <?php } ?>
                                <?php if ($product['rating'] && $m['show_rate'] == 1) { ?>
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
                                <?php if ($product['price'] && $m['show_price'] == 1) { ?>
                                    <div class="price">
                                        <?php if (!$product['special']) { ?>
                                            <?php echo $product['price']; ?>
                                        <?php } else { ?>
                                            <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                                        <?php } ?>
                                    </div>
                                    <?php if ($product['tax']) { ?>
                                        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <?php if ($m['show_cart'] == 1 || $m['show_wishlist'] == 1 || $m['show_compare'] == 1) { ?>
                                <div class="button-group">
                                    <?php if ($m['show_cart'] == 1) { ?>
                                        <button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
                                    <?php } ?>
                                    <?php if ($m['show_wishlist'] == 1 ) { ?>
                                        <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                                    <?php } ?>
                                    <?php if ($m['show_compare'] == 1) { ?>
                                        <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <script type="text/javascript">$(document).ready(function() {function random(owlSelector){owlSelector.children().sort(function(){return Math.round(Math.random()) - 0.5;}).each(function(){$(this).appendTo(owlSelector);});}var owl = $("#owl-<?php echo $m['module']; ?>");owl.owlCarousel({items : <?php echo $m['visible']; ?>,itemsDesktop : [1000,<?php echo $m['visible_1000']; ?>],itemsDesktopSmall : [900,<?php echo $m['visible_900']; ?>],itemsTablet: [600,<?php echo $m['visible_600']; ?>],itemsMobile : [479,<?php echo $m['visible_479']; ?>],<?php if ($m['show_random_item'] == 1) { ?>beforeInit : function(elem){random(elem);},<?php } ?><?php if ($m['show_nav'] == 1) { ?>navigation: true,<?php } ?><?php if ($m['slide_speed']) { ?>slideSpeed: <?php echo $m['slide_speed']; ?>,<?php } ?><?php if ($m['pagination_speed']) { ?>paginationSpeed: <?php echo $m['pagination_speed']; ?>,<?php } ?><?php if ($m['autoscroll']) { ?>autoPlay: <?php echo $m['autoscroll']; ?>,<?php } ?><?php if ($m['show_stop_on_hover'] == 1) { ?>stopOnHover: true,<?php } ?><?php if ($m['rewind_speed']) { ?>rewindSpeed: <?php echo $m['rewind_speed']; ?>,<?php } ?><?php if ($m['show_lazy_load'] == 1) { ?>lazyLoad : true,<?php } ?><?php if ($m['show_mouse_drag'] == 0) { ?>mouseDrag: false,<?php } ?><?php if ($m['show_touch_drag'] == 1) { ?>touchDrag: true,<?php } ?><?php if ($m['show_page'] == 0) { ?>pagination: false,<?php } ?><?php if ($m['show_per_page'] == 1) { ?>scrollPerPage: true,<?php } ?><?php if ($m['item_prev_next'] && $m['show_per_page'] == 0) { ?>slideItems: <?php echo $m['item_prev_next']; ?>,<?php } ?>navigationText: ['', ''],});<?php if (count($modules) > 1) { ?>$('#nav-owl-<?php echo $module; ?> a:first').tab('show');$('#nav-owl-<?php echo $module; ?> a').click(function (e) {e.preventDefault();$(this).tab('show');})<?php } ?>});
            </script>
            <style type="text/css">.product-layout .owl-wrapper-outer {border:none;border-radius:0;box-shadow: none}.product-layout .owl-carousel .owl-buttons .owl-prev {left:0}.product-layout .owl-carousel .owl-buttons .owl-next {right:0}.product-layout .owl-carousel .product-thumb .caption {min-height:auto}</style>
        </div>
        <?php $is_first_tab = false; ?>
    <?php } ?>
<?php } ?>

<?php if (count($modules) > 1) { ?>
</div>
<?php } ?>