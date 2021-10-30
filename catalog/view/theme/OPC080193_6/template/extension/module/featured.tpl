<section class="block-catalog category_blocks hi" id="block-catalog">
    <div class="wrapper">
        <h2 class="h2-title"><?php echo $heading_title; ?></h2>
        <div class="h3-title"><?php echo $text_select_category; ?></div>
         <div class="catalog-mobile">
            <?php foreach($categories as $category){ ?>
            <div class="catalog-item" id="catalog-item-<?php echo $category['category_id'] ?>">
                <div class="cat_header_mobile">
                    <img class="cat__image" src="<?php echo $category['thumb']; ?>" alt="<?php echo $category['series_name']?>">

                    <?php if($category['series_name'] && $category['additional_input2']) {?>
                    <div class="mob2-head-text"><?php echo $category['additional_input2']; ?></div>
                    <div class="mob-head-right">
                        <h3><?php echo $category['series_name'] .
                            '<span class="info_catalog_block" id="info-block-' . $category['category_id'] . '"info-block-id="' . $category['category_id'] . '"></span>'; ?>
                        </h3>
                    </div>
                    <div class="mob-head-left">
                        <?php if ($category['additional_input']) { ?>
                        <div class="catalog-additional_input" ><?php echo $category['additional_input']; ?></div>
                        <div class="text_max_min_weight" ><?php echo $text_max_min_weight; ?></div><?php } ?>
                    </div>

                    <?php } elseif ($category['additional_input2']) { ?>
                    <div class="mob-head-right">
                        <h3><?php echo $category['additional_input2'] .
                            '<span class="info_catalog_block" id="info-block-' . $category['category_id'] . '" info-block-id="' . $category['category_id'] . '"></span>'; ?>
                        </h3>
                    </div>
                    <?php }; ?>

                    <div class="clearfix"></div>
                    <div class="cat__arrow"></div>

                </div>
                <div class="cat__content cat__content-first">

                    <div class="filter-attr-block" style="padding-top: 7px;">
                        <div class="select_size_header">
                            <div class="text_select_size"><?php echo $text_select_size; ?></div>
                            <div title="<?php echo $text_filter_reset; ?>" class="sd_reset" reset-cat-id="<?php echo $category['category_id'] ?>" id="reset-cat-id-<?php echo $category['category_id'] ?>"><?php echo $text_filter_reset; ?></div>
                        </div>

                        <div class="selector_block">
                            <div class="selector_item">
                                <select disabled="disabled" data-param="height" data-selector-get-cat-id="<?php echo $category['category_id'] ?>" id="data-get-height-id-<?php echo $category['category_id'] ?>" class="select-parameter__selector">
                                    <option value=""> — </option>
                                    <?php foreach($category['aHeight'] as $Height){ ?>
                                    <option value="<?php echo $Height; ?>"><?php echo $Height; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="metrix-text matrix-required"><?php echo $text_filter_height; ?></span>
                            </div>
                            <div class="selector_item">
                                <select disabled="disabled" data-param="width" data-selector-get-cat-id="<?php echo $category['category_id'] ?>" id="data-get-width-id-<?php echo $category['category_id'] ?>" class="select-parameter__selector">
                                    <option value=""> — </option>
                                    <?php foreach($category['aWidth'] as $Width){ ?>
                                    <option value="<?php echo $Width; ?>"><?php echo $Width; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="metrix-text matrix-required"><?php echo $text_filter_width; ?></span>
                            </div>
                            <div class="selector_item">
                                <select disabled="disabled" data-param="slength" data-selector-get-cat-id="<?php echo $category['category_id'] ?>" id="data-get-slength-id-<?php echo $category['category_id'] ?>"  class="select-parameter__selector">
                                    <option value=""> — </option>
                                    <?php foreach($category['aLength'] as $Length){ ?>
                                    <option value="<?php echo $Length; ?>"><?php echo $Length; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="metrix-text matrix-required"><?php echo $text_filter_length; ?></span>
                            </div>
                            <div class="select_more <?php echo ($category['more_filter_visible']) ? 'show' : 'hide'; ?>"><?php echo $text_select_more; ?> <span  class="select_options"><?php echo $text_more_options; ?></span></div>
                        </div>
                        <?php if($category['more_filter_visible']) { ?>
                        <div class="selector_block additional-selectors hide">
                            <?php if( !empty($category['aMaterial']) ) { ?>
                            <div class="selector_item">
                                <select disabled="disabled" data-param="material" data-selector-get-cat-id="<?php echo $category['category_id'] ?>" id="data-get-material-id-<?php echo $category['category_id'] ?>" class="select-parameter__selector">
                                    <option value=""> — </option>
                                    <?php foreach($category['aMaterial'] as $material){ ?>
                                    <option value="<?php echo $material; ?>"><?php echo $material; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="metrix-text"><?php echo $text_filter_material; ?></span>
                            </div>
                            <?php } ?>
                            <?php if( !empty($category['aModel']) ) { ?>
                            <div class="selector_item">
                                <select disabled="disabled" data-param="model" data-selector-get-cat-id="<?php echo $category['category_id'] ?>" id="data-get-model-id-<?php echo $category['category_id'] ?>" class="select-parameter__selector">
                                    <option value=""> — </option>
                                    <?php foreach($category['aModel'] as $model){ ?>
                                    <option value="<?php echo $model; ?>"><?php echo $model; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="metrix-text"><?php echo $text_filter_model; ?></span>
                            </div>
                            <?php } ?>
                            <?php if( !empty($category['aColor']) ) { ?>
                            <div class="selector_item">
                                <select disabled="disabled" data-param="color" data-selector-get-cat-id="<?php echo $category['category_id'] ?>" id="data-get-color-id-<?php echo $category['category_id'] ?>" class="select-parameter__selector">
                                    <option value=""> — </option>
                                    <?php foreach($category['aColor'] as $color){ ?>
                                    <option value="<?php echo $color; ?>"><?php echo $color; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="metrix-text"><?php echo $text_filter_color; ?></span>
                            </div>
                            <?php } ?>
                            <?php if( !empty($category['aWeight']) ) { ?>
                            <div class="selector_item">
                                <select disabled="disabled" data-param="weight" data-selector-get-cat-id="<?php echo $category['category_id'] ?>" id="data-get-weight-id-<?php echo $category['category_id'] ?>" class="select-parameter__selector">
                                    <option value=""> — </option>
                                    <?php foreach($category['aWeight'] as $weight){ ?>
                                    <option value="<?php echo $weight; ?>"><?php echo $weight; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="metrix-text"><?php echo $text_filter_weight; ?></span>
                            </div>
                            <?php } ?>
                            <?php if( !empty($category['aThickness']) ) { ?>
                            <div class="selector_item">
                                <select disabled="disabled" data-param="thickness" data-selector-get-cat-id="<?php echo $category['category_id'] ?>" id="data-get-thickness-id-<?php echo $category['category_id'] ?>" class="select-parameter__selector">
                                    <option value=""> — </option>
                                    <?php foreach($category['aThickness'] as $thickness){ ?>
                                    <option value="<?php echo $thickness; ?>"><?php echo $thickness; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="metrix-text"><?php echo $text_filter_thickness; ?></span>
                            </div>
                            <?php } ?>
                            <?php if( !empty($category['aQntShelv']) ) { ?>
                            <div class="selector_item">
                                <select disabled="disabled" data-param="quantity_shelves" data-selector-get-cat-id="<?php echo $category['category_id'] ?>" id="data-get-quantity_shelves-id-<?php echo $category['category_id'] ?>" class="select-parameter__selector">
                                    <option value=""> — </option>
                                    <?php foreach($category['aQntShelv'] as $qnt_shelv){ ?>
                                    <option value="<?php echo $qnt_shelv; ?>"><?php echo $qnt_shelv; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="metrix-text"><?php echo $text_filter_qnt_shelv; ?></span>
                            </div>
                            <?php } ?>
                            <?php if( !empty($category['aType']) ) { ?>
                            <div class="selector_item">
                                <select disabled="disabled" data-param="type" data-selector-get-cat-id="<?php echo $category['category_id'] ?>" id="data-get-type-id-<?php echo $category['category_id'] ?>" class="select-parameter__selector">
                                    <option value=""> — </option>
                                    <?php foreach($category['aType'] as $type){ ?>
                                    <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="metrix-text"><?php echo $text_filter_type; ?></span>
                            </div>
                            <?php } ?>
                            <?php if( !empty($category['aSeries']) ) { ?>
                            <div class="selector_item">
                                <select disabled="disabled" data-param="series" data-selector-get-cat-id="<?php echo $category['category_id'] ?>" id="data-get-series-id-<?php echo $category['category_id'] ?>" class="select-parameter__selector">
                                    <option value=""> — </option>
                                    <?php foreach($category['aSeries'] as $series){ ?>
                                    <option value="<?php echo $series; ?>"><?php echo $series; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="metrix-text"><?php echo $text_filter_series; ?></span>
                            </div>
                            <?php } ?>
                            <?php if( !empty($category['aBrand']) ) { ?>
                            <div class="selector_item">
                                <select disabled="disabled" data-param="brand" data-selector-get-cat-id="<?php echo $category['category_id'] ?>" id="data-get-brand-id-<?php echo $category['category_id'] ?>" class="select-parameter__selector">
                                    <option value=""> — </option>
                                    <?php foreach($category['aBrand'] as $brand){ ?>
                                    <option value="<?php echo $brand; ?>"><?php echo $brand; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="metrix-text"><?php echo $text_filter_brand; ?></span>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                        <div class="podbor podbor_disabled">
                            <div data-get-id="<?php echo $category['category_id'] ?>" active_btn="0" id="filter-btn-id-<?php echo $category['category_id'] ?>" class="link-catalog-filter" ><?php echo $text_select_filter_start; ?></div>
                            <div class="podbor_hint"><?php echo $podbor_hint ?> <span style="color: #F00;">*</span></div>
                            <div class="cearfix"></div>
                        </div>
                    </div>
                    <div class="popular_models_mobile">
                        <div class="popular__arrow  popular__arrow-left"></div>
                        <div style="text-transform: lowercase;"><?php echo $text_popular_size; ?></div>
                        <div class="popular__arrow popular__arrow-right"></div>
                    </div>
                    <div class="block-products">
                        <div class="">
                            <?php if($category['products']){ ?>

                            <div class="slider-products cat__slider-products">
                                <?php foreach ($category['products'] as $product) { ?>
                                <div>
                                    <div class="item">
                                        <div class="image"><a href="<?php echo $product['href'] ?>">
                                            <?php if($product['special']){ ?><div class="image_action">Акция</div><?php }; ?>
                                            <img src="<?php echo $product['thumb'] ?>" alt="" /></a></div>
                                    <div class="all-info-product">
                                      <div class="size"><span class="units-product"><?php echo $unit_h; ?>:</span> <?php echo $product['height'] ?> <span class="units-product"> <?php echo $unit_w; ?>:</span> <?php echo $product['width'] ?> <span class="units-product"> <?php echo $unit_l; ?>:</span> <?php echo $product['length'] ?> </div>
                                        <a class="name" href="<?php echo $product['href'] ?>"><?php echo $product['name'] ?></a>
                                        <a class="model" href="<?php echo $product['href'] ?>"><b><?php echo $product['model'] ?></b></a>

                                        <div class="product-panel">
                                            <?php if($product['quantity'] > 0){ ?>
                                            <div class="price">
                                                <?php if($product['special']){ ?>
                                                <div class="price-old"><?php echo $product['price'] ?></div>
                                                <div class="price-new"><?php echo $product['special'] ?></div>
                                                <?php }else{ ?>
                                                <div class="price-regular"><?php echo $product['price'] ?></div>
                                                <?php } ?>
                                            </div>
                                            <?php }else{ ?>
                                            <div class="price outofstock">
                                                <?php if($product['special']){ ?>
                                                <div class="price-old"><?php echo $product['price'] ?></div>
                                                <div class="price-new"><?php echo $product['special'] ?></div>
                                                <?php }else{ ?>
                                                <div class="price-regular outofstock"><?php echo $product['price'] ?></div>
                                                <?php } ?>
                                            </div>
                                            <?php } ?>
                                            <?php if($product['quantity'] > 0){ ?>
                                            <div class="button"><a href="javascript:void(0);" onclick="cart.add('<?php echo $product['product_id'] ?>')" class="btn btn-buy"><?php echo $text_buy ?></a></div>
                                            <?php }else{ ?>
                                            <div class="button"><span class="outofstock btn btn-off"><?php echo $outofstock; ?></span></div>
                                            <?php } ?>
                                        </div>

                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                            <?php } ?>
                        </div>
                    </div>
                </div>

            </div>
            <?php } ?>
        </div>
    </div>
</section>
<div id="product_summary"></div>
<div id="ajax_preloader">
    <div class="remodal-overlay remodal-is-opened" style="display: block;" id="overlay-popup"></div>
    <div class="remodal-wrapper remodal-is-opened" style="display: block;" id="wraper-popup">
        <div class="ajax_block"><img width="50" height="50" src="image/loader_new.gif"/></div>
    </div>
</div>
