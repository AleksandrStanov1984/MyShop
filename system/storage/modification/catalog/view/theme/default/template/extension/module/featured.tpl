<!--section class="block-products" id="block-products">
        <h2 class="title"><?php echo $text_home_products; ?></h2>

        <div class="list-products">
        <?php foreach($products as $product){ ?>
            <div class="item wow fadeInUp">
                <div class="image"><a href="<?php echo $product['href'] ?>"><img src="<?php echo $product['thumb'] ?>" alt="" /></a></div>
                <div class="name"><a href="<?php echo $product['href'] ?>"><?php echo $product['name'] ?></a></div>
                <div class="size"><?php echo $product['height'] ?>x<?php echo $product['width'] ?>x<?php echo $product['length'] ?></div>
                <?php /*<div class="triggers">
                    <div class="trigger trigger-1"><?php echo $text_trigger1; ?></div>
                    <div class="trigger trigger-2"><?php echo $text_trigger2; ?></div>
                    <div class="trigger trigger-3"><?php echo $text_trigger3; ?></div>
                </div>*/ ?>
                <div class="price">
                <?php if($product['special']){ ?>
                    <div class="price-old"><b><?php echo $product['price'] ?></b></div>
                    <div class="price-new"><b><?php echo $product['special'] ?></b></div>
                <?php }else{ ?>
                    <div class="price-new"><b><?php echo $product['price'] ?></b></div>
                <?php } ?>
                </div>
                <?php if($product['quantity'] > 0){ ?>
                    <div class="button"><a href="#" onclick="cart.add('<?php echo $product['product_id'] ?>')" class="btn btn-buy"><?php echo $text_buy ?></a></div>
                <?php }else{ ?>
                   <div class="button"><span class="outofstock btn btn-off"><?php echo $outofstock; ?></span></div>
                <?php } ?>
            </div>
        <?php } ?>

        </div>
    </div>
</section-->


<?php if($setting_name == 'Рекомендуемые на главной странице'){ ?>
<section class="block-catalog" id="block-catalog">
    <div class="wrapper">
        <div class="catalog-tabs">
            <h2 class="title"><?php echo $catalog ?></h2>
            <div class="catalog-tabs-head">

                <?php foreach($categories as $category){ ?>
                <a href="#catalog-<?php echo $category['category_id'] ?>">
                    <b><?php echo $category['name'] ?></b>
                    <span data-remodal-target="modal-catalog<?php echo $category['category_id'] ?>"><?php echo $viewall ?></span>
                </a>
                <?php } ?>
            </div>
            <div class="catalog-tabs-body">
                <?php foreach($categories as $category){ ?>
                <div class="catalog-tab" id="catalog-<?php echo $category['category_id'] ?>">
                    <div class="list-products">
                        <?php foreach($category['products'] as $product){ ?>
                        <div>
                            <div class="item">
                                <div class="image"><a href="<?php echo $product['href'] ?>"><img src="<?php echo $product['thumb'] ?>" alt="" /></a></div>
                                <div class="model"><a href="<?php echo $product['href'] ?>"><b><?php echo $product['model'] ?></b></a></div>
                                <div class="name"><a href="<?php echo $product['href'] ?>"><?php echo $product['name'] ?></a></div>
                                <div class="size"><?php echo (int)$product['height']; ?>x<?php echo (int)$product['width']; ?>x<?php echo (int)$product['length']; ?></div>
                                <!--div class="triggers">
                                        <?php /*<div class="trigger trigger-1"><?php echo $text_trigger1; ?></div>*/?>
                                        <div class="trigger trigger-2"><?php echo $text_trigger2; ?></div>
                                        <div class="trigger trigger-3"><?php echo $text_trigger3; ?></div>
                                </div-->
                                <?php if($product['quantity'] > 0){ ?>
                                <div class="price">
                                    <?php if($product['special']){ ?>
                                    <div class="price-old"><b><?php echo $product['price'] ?></b></div>
                                    <div class="price-new"><b><?php echo $product['special'] ?></b></div>
                                    <?php }else{ ?>
                                    <div class="price-regular"><b><?php echo $product['price'] ?></b></div>
                                    <?php } ?>
                                </div>
                                <?php }else{ ?>
                                <div class="price outofstock">
                                    <?php if($product['special']){ ?>
                                    <div class="price-old"><b><?php echo $product['price'] ?></b></div>
                                    <div class="price-new"><b><?php echo $product['special'] ?></b></div>
                                    <?php }else{ ?>
                                    <div class="price-regular outofstock"><b><?php echo $product['price'] ?></b></div>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                                <?php if($product['quantity'] > 0){ ?>
                                <div class="button"><a href="#" onclick="cart.add('<?php echo $product['product_id'] ?>')" class="btn btn-buy"><?php echo $text_buy ?></a></div>
                                <?php }else{ ?>
                                <div class="button"><span class="outofstock btn btn-off"><?php echo $outofstock; ?></span></div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>

        <div class="catalog-mobile" id="block-catalog">
            <h2 class="title"><b><?php echo $catalogmobile ?></b></h2>
            <div class="block-btn"> 
                <?php foreach($categories as $category){ ?>
                <a href="/#catalog-item-<?php echo $category['category_id'] ?>" class="catalog-new">
                    <div class="catalog-panel">

                        <div id="btn-<?php echo $category['category_id'] ?>">  
                            <?php if ($category['series_name'] && $category['description'] && $category['additional_input']) { ?>
                            <div style="position: relative; display: block; float: left; width: 49%;">
                                <?php if ($category['series_name']) { ?><div class="catalog-series-name" ><?php echo $category['series_name']; ?></div><?php } ?>
                                <div class="description_catalog_text" ><?php if ($category['description']) {echo $category['description'];  } ?></div>
                            </div>
                            <div style="position: relative; display: block; float: right; width: 49%;">
                                <?php if ($category['additional_input']) { ?><div class="catalog-additional_input" ><?php echo $category['additional_input']; ?></div>
                                <div class="text_max_min_weight" ><?php echo $text_max_min_weight; ?></div><?php } ?>
                            </div> <?php } else { ?> 
                            <div class="catalog-name-one">
                                <?php echo $category['name']; ?>
                            </div> <?php } ?>

                        </div>

                    </div>
                </a>
                <?php } ?>
                <!--<a href="/#catalog-item-26" class="btn-category"><?php echo $category1; ?></a>
                <a href="/#catalog-item-27" class="btn-category"><?php echo $category2; ?></a>
                <a href="/#catalog-item-60" class="btn-category"><?php echo $category3; ?></a> -->
                <!--div class="btn-category off" title="<?php echo $off; ?>"><?php echo $category3; ?></div-->
            </div>
            <?php foreach($categories as $category){ ?>
            <div class="catalog-item" id="catalog-item-<?php echo $category['category_id'] ?>">
                <h1><?php echo '<span style="color: #fdac14;">' . $category['series_name'] . '</span> ' . $category['description'] ?></h1>
                <div style="display: inline-block; margin: 5px 5px 5px 12px;"><span class="metrix-text">Высота, см:</span>   
                    <select data-param="height" id="data-get-height-id-<?php echo $category['category_id'] ?>" class="select-parameter__selector">
                        <?php foreach($category['aHeight'] as $Height){ ?>
                        <option value="<?php echo $Height; ?>"><?php echo $Height; ?></option>
                        <?php } ?>

                    </select></div>
                <div style="display: inline-block; margin: 5px;"><span class="metrix-text">Ширина, см:</span>  												
                    <select data-param="width" id="data-get-width-id-<?php echo $category['category_id'] ?>" class="select-parameter__selector">
                        <?php foreach($category['aWidth'] as $Width){ ?>
                        <option value="<?php echo $Width; ?>"><?php echo $Width; ?></option>
                        <?php } ?>
                    </select></div>
                <div style="display: inline-block; margin: 5px;"><span class="metrix-text">Глубина, см:</span> 
                    <select data-param="length" id="data-get-length-id-<?php echo $category['category_id'] ?>"  class="select-parameter__selector">
                        <?php foreach($category['aLength'] as $Length){ ?>
                        <option value="<?php echo $Length; ?>"><?php echo $Length; ?></option>
                        <?php } ?>
                    </select></div>
                <div data-get-id="<?php echo $category['category_id'] ?>" class="link-catalog-filter" >Подбор</div>
                <div class="ccc_line"></div>
                <!-- <a class="catalog-item-toggle" data-remodal-target="modal-catalog<?php echo $category['category_id'] ?>"><?php echo $viewallsizes; ?></a>   --> 

                <section class="block-products">
                    <div class="wrapper">

                        <div class="slider-products">
                            <?php foreach ($category['products'] as $product) { ?>
                            <div class="item">
                                <div class="image"><a href="<?php echo $product['href'] ?>"><img src="<?php echo $product['thumb'] ?>" alt="" /></a></div>
                                <div class="model"><a href="<?php echo $product['href'] ?>"><b><?php echo $product['model'] ?></b></a></div>
                                <div class="name"><a href="<?php echo $product['href'] ?>"><?php echo $product['name'] ?></a></div>
                                <div class="size"><?php echo $product['height'] ?>x<?php echo $product['width'] ?>x<?php echo $product['length'] ?></div>
                                <?php if($product['quantity'] > 0){ ?>
                                <div class="price">
                                    <?php if($product['special']){ ?>
                                    <div class="price-old"><b><?php echo $product['price'] ?></b></div>
                                    <div class="price-new"><b><?php echo $product['special'] ?></b></div>
                                    <?php }else{ ?>
                                    <div class="price-regular"><b><?php echo $product['price'] ?></b></div>
                                    <?php } ?>
                                </div>
                                <?php }else{ ?>
                                <div class="price outofstock">
                                    <?php if($product['special']){ ?>
                                    <div class="price-old"><b><?php echo $product['price'] ?></b></div>
                                    <div class="price-new"><b><?php echo $product['special'] ?></b></div>
                                    <?php }else{ ?>
                                    <div class="price-regular outofstock"><b><?php echo $product['price'] ?></b></div>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                                <?php if($product['quantity'] > 0){ ?>
                                <div class="button"><a href="#" onclick="cart.add('<?php echo $product['product_id'] ?>')" class="btn btn-buy"><?php echo $text_buy ?></a></div>
                                <?php }else{ ?>
                                <div class="button"><span class="outofstock btn btn-off"><?php echo $outofstock; ?></span></div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </section>

            </div>
            <?php } ?>
        </div>
    </div>
</section>

                         <div id="product_summary"></div> 
<?php foreach($categories as $category){ ?>

<div class="remodal modal-catalog" data-remodal-id="modal-catalog<?php echo $category['category_id'] ?>" id="modal-catalog">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="modal-catalog-list">
        <?php foreach($category['products'] as $product){ ?>
        <div class="item">
            <div class="text-center image" >
                <a href="<?php echo $product['href'] ?>"><img src="<?php echo $product['thumb'] ?>" alt="<?php echo $product['name'] ?>" title="<?php echo $product['name'] ?>" class="img-thumbnail"></a>
            </div>
            <div class="text-left name">
                <a href="<?php echo $product['href'] ?>">
                    <div class="size-mobile"><?php echo $product['height'] ?>x<?php echo $product['width'] ?>x<?php echo $product['length'] ?></div> 
                    <div class="shelf-mobile"><span class="shelf_txt"><span class="shelf_qty"><?php echo $product['quantity_shelves']; ?></span><?php if (in_array($product['quantity_shelves'], array( 2, 3, 4))) { ?> полки <?php } elseif ($product['quantity_shelves'] == '1') {?> полкa <?php } else {?> полок <?php } ?> </b></span> </div> 
                    <div class="shelf-mobile2"><span class="shelf_txt">На одну полку: </span> <span class="shelf_qty"><?php echo $product['maximum_weight']; ?></span><span class="shelf_txt">&nbsp;кг</span></div>
                    <div class="shelf-mobile2"><span class="shelf_txt">Цвет: <b><?php echo $product['color_shelves']; ?></b></span></div> 
                    <div class="shelf-mobile2"><span class="shelf_txt">Модель: <b><?php echo $product['model'] ?></b></span></div>
                </a>
            </div>
            <div class="text-right total">
                <?php if($product['quantity'] > 0){ ?>
                <div class="price-list">
                    <?php if($product['special']){ ?>
                    <div class="price-old"><b><?php echo $product['price'] ?></b></div>
                    <div class="price-new"><b><?php echo $product['special'] ?></b></div>
                    <?php }else{ ?>
                    <div class="price-regular"><b><?php echo $product['price'] ?></b></div>
                    <?php } ?>
                </div>
                <?php }else{ ?>
                <div class="price-list">
                    <?php if($product['special']){ ?>
                    <div class="price-old"><b><?php echo $product['price'] ?></b></div>
                    <div class="price-new"><b><?php echo $product['special'] ?></b></div>
                    <?php }else{ ?>
                    <div class="price-regular outofstock"><b><?php echo $product['price'] ?></b></div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
            <div class="text-right button">
                <?php if($product['quantity'] > 0){ ?>
                <a href="#" onclick="cart.add('<?php echo $product['product_id'] ?>')" class="btn btn-buy"><?php echo $text_buy ?></a>
                <?php }else{ ?>
                <span class="outofstock btn btn-off"><?php echo $outofstock; ?></span>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>
<?php } ?>



<?php /*<div class="box">
<!--div class="box-heading"><?php echo $heading_title; ?></div-->
<div class="box-content">
    <?php
    $sliderFor = 5;
    $productCount = sizeof($products);
    ?>
    <?php if ($productCount >= $sliderFor): ?>
    <div class="customNavigation">
        <a class="fa prev fa-arrow-left">&nbsp;</a>
        <a class="fa next fa-arrow-right">&nbsp;</a>
    </div>
    <?php endif; ?>

    <div class="box-product <?php if ($productCount >= $sliderFor){?>product-carousel<?php }else{?>productbox-grid<?php }?>  item-<?php echo $productCount ?>" id="<?php if ($productCount >= $sliderFor){?>featured-carousel<?php }else{?>featured-grid<?php }?>">
        <?php foreach ($products as $product) { ?>
        <div class="<?php if ($productCount >= $sliderFor){?>slider-item<?php }else{?>product-items<?php }?>">
            <div class="product-block product-thumb transition">
                <div class="product-block-inner">
                    <div class="image">
                        <?php if ($product['thumb_swap']) { ?>
                        <a href="<?php echo $product['href']; ?>" data-hpm-href="1">
                            <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
                            <img class="img-responsive hover-image" src="<?php echo $product['thumb_swap']; ?>" alt="<?php echo $product['name']; ?>"/>
                        </a>
                        <?php } else {?>
				<a href="<?php echo $product['href']; ?>" data-hpm-href="1">
				<img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" />
				</a>
				<?php } ?>
                        <?php if (!$product['special']) { ?>
                        <?php } else { ?>
                        <span class="saleicon sale"><?php echo $label_sale; ?></span>
                        <?php } ?>

                    </div>
                    <div class="product-details">

                        <div class="caption">
                            <h4>
                                <a href="<?php echo $product['href']; ?>" data-hpm-href="1">
                                    <?php echo $product['name']; ?>
                                    <?php if($product['height'] > 0) {?>
							<span class="size"> <?php echo $product['height'].'x'.$product['width'].'x'.$product['length']; ?></span>
						<?php }?>
                                </a>
                            </h4>
                            <?php if ($product['rating']) { ?>
                            <div class="rating">
                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                <?php if ($product['rating'] < $i) { ?>
                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i></span>
                                <?php } else { ?>
                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star fa-stack-1x"></i></span>
                                <?php } ?>
                                <?php } ?>
                            </div>
                            <?php } ?>

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

                        <div class="button-group">
                            <button type="button" class="addtocart" onclick="cart.add('<?php echo $product['product_id']; ?>');"><?php echo $button_cart; ?></button>
                            <button class="wishlist_button" type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                            <button class="compare_button" type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php } ?>
    </div>
</div>
</div>
<span class="featured_default_width" style="display:none; visibility:hidden"></span>
*/?>