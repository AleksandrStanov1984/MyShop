<div class="remodal-overlay remodal-is-opened" style="display: block;" id="overlay-popup4"></div>
<div class="remodal-wrapper remodal-is-opened" style="display: block;" id="wraper-popup4">
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('#close-popup4').click(function () {
                document.getElementById('overlay-popup4').remove();
                document.getElementById('wraper-popup4').remove();
            });
        });

    </script>
    <?php foreach ($categories as $category) { ?>
        <div class="remodal modal-catalog remodal-is-initialized remodal-is-opened"
             data-remodal-id="modal-catalog<?php echo $category['category_id'] ?>" id="modal-catalog">
            <button data-remodal-action="close" class="remodal-close close-filterprod" id="close-popup4"></button>
            <div class="rezult__head">
                <div class="rezult_name"><?php echo $category['name']; ?></div>
                <div class="rezult__title"><?php echo $category['series_name']; ?></div>
                <?php if (isset($category['products'][0])) { ?>
                <div class="size-mobile"><span
                        class="units-product">В:</span> <?php echo $category['products'][0]['height'] ?> <span
                        class="units-product"> Ш:</span> <?php echo $category['products'][0]['width'] ?> <span
                        class="units-product"> Г:</span> <?php echo $category['products'][0]['length'] ?></div>
                <?php } ?>
                <div class="rezult__total"><?php echo $text_rezult . count($category['products']) ?>
                    <span>
                <?php if (in_array(count($category['products']), array(2, 3, 4))) {
                    echo $text_rezult_shelf_for;
                } elseif (count($category['products']) == '1') {
                    echo $text_rezult_shelf;
                } else {
                    echo $text_rezult_shelfs;
                } ?></span>
                </div>
            </div>
            <div class="modal-catalog-list">
                <?php
                if (count($category['products'])>0) { foreach ($category['products'] as $product) { ?>
                        <div class="rezult__item">
                            <div class="rezult__image">
                                <a href="<?php echo $product['href'] ?>"><img src="<?php echo $product['thumb'] ?>"
                                                                              alt="<?php echo $product['name'] ?>"
                                                                              title="<?php echo $product['name'] ?>"
                                                                              class="img-thumbnail"></a>
                            </div>
                            <div class="rezult__content">
                                <div class="rezult__name">
                                    <a href="<?php echo $product['href'] ?>">
                                        <?php if ($category['parent_id'] == 20) { ?>
                                            <div>
                                                <div class="shelf-mobile">
                                                    <span
                                                        class="shelf_qty"><?php echo $product['quantity_shelves']; ?> </span>
                                                    <div class="shelf_txt">
                                                        <?php if (in_array($product['quantity_shelves'], array(2, 3, 4))) {
                                                            echo $text_filter_shelf_for;
                                                        } elseif ($product['quantity_shelves'] == '1') {
                                                            echo $text_filter_shelf;
                                                        } else {
                                                            echo $text_filter_shelfs;
                                                        } ?>
                                                    </div>
                                                </div>
                                                <div class="shelf-mobile4"></div>
                                                <div class="shelf-mobile3">
                                                    <span
                                                        class="shelf_qty"><?php echo $product['maximum_weight']; ?></span>
                                                    <span class="shelf_txt">кг</span>
                                                    <div class="shelf_txt"><?php echo $text_max_min_weight; ?> </div>
                                                </div>
                                                <div class="shelf-mobile4"></div>
                                                <div class="shelf-mobile3">
                                                    <span
                                                        class="shelf_qty"><?php echo $product['maximum_weight_all']; ?></span>
                                                    <span class="shelf_txt">кг</span>
                                                    <div class="shelf_txt"><?php echo $text_max_min_weight_all; ?></div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if (isset($color_popup_status) && $color_popup_status == 1 && !empty($product['color_shelves'])) { ?>
                                            <div class="shelf-mobile2"><span
                                                    class="shelf_txt"><?php echo $text_shelfs_color; ?>
                                                    <b><?php echo $product['color_shelves']; ?></b></span></div>
                                        <?php } ?>
                                        <?php if (isset($material_popup_status) && $material_popup_status == 1 && !empty($product['material_shelves'])) { ?>
                                            <div class="shelf-mobile2"><span
                                                    class="shelf_txt"><?php echo $text_shelfs_material; ?>
                                                    <b><?php echo $product['material_shelves']; ?></b></span></div>
                                        <?php } ?>
                                        <?php if (isset($brand_popup_status) && $brand_popup_status == 1 && !empty($product['brand'])) { ?>
                                            <div class="shelf-mobile2"><span
                                                    class="shelf_txt"><?php echo $text_filter_brand; ?>
                                                    <b><?php echo $product['brand']; ?></b></span></div>
                                        <?php } ?>
                                        <?php if (isset($series_popup_status) && $series_popup_status == 1 && !empty($product['series'])) { ?>
                                            <div class="shelf-mobile2"><span
                                                    class="shelf_txt"><?php echo $text_filter_series; ?>
                                                    <b><?php echo $product['series']; ?></b></span></div>
                                        <?php } ?>
                                        <?php if (isset($type_popup_status) && $type_popup_status == 1 && !empty($product['type'])) { ?>
                                            <div class="shelf-mobile2"><span
                                                    class="shelf_txt"><?php echo $text_filter_type; ?>
                                                    <b><?php echo $product['type']; ?></b></span></div>
                                        <?php } ?>
                                        <?php if (isset($thickness_popup_status) && $thickness_popup_status == 1 && $product['metal_thickness'] > 0) { ?>
                                            <div class="shelf-mobile2"><span
                                                    class="shelf_txt"><?php echo $text_filter_thickness; ?>
                                                    : <b><?php echo $product['metal_thickness']; ?> мм</b></span></div>
                                        <?php } ?>
                                        <?php if (isset($model_popup_status) && $model_popup_status == 1 && !empty($product['model_selection'])) { ?>
                                            <div class="shelf-mobile2"><span
                                                    class="shelf_txt"><?php echo $text_shelfs_model; ?>
                                                    <b><?php echo $product['model_selection']; ?></b></span></div>
                                        <?php } ?>

                                        <div class="shelf-mobile2"><span
                                                class="shelf_txt"><?php echo $text_filter_prod_model; ?>
                                                <b><?php echo $product['model'] ?></b></span></div>
                                    </a>
                                </div>
                                <div class="product-panel">
                                    <div class="price">
                                        <?php if ($product['quantity'] > 0) { ?>
                                            <?php if ($product['special']) { ?>
                                                <div class="price-old"><b><?php echo $product['price'] ?></b></div>
                                                <div class="price-new"><b><?php echo $product['special'] ?></b></div>
                                            <?php } else { ?>
                                                <div class="price-regular"><b><?php echo $product['price'] ?></b></div>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <?php if ($product['special']) { ?>
                                                <div class="price-old"><b><?php echo $product['price'] ?></b></div>
                                                <div class="price-new"><b><?php echo $product['special'] ?></b></div>
                                            <?php } else { ?>
                                                <div class="price-regular outofstock">
                                                    <b><?php echo $product['price'] ?></b></div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                    <div class="button">
                                        <?php if ($product['quantity'] > 0) { ?>
                                            <a href="javascript:void(0);"
                                               onclick="cart.add('<?php echo $product['product_id'] ?>'); setTimeout(function(){$('.close-filterprod').trigger('click')}, 1000);"
                                               class="btn btn-buy"><?php echo $text_buy ?></a>
                                        <?php } else { ?>
                                            <span class="outofstock btn btn-off"><?php echo $outofstock; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }  } else { ?>
                    <div style="height: 150px; width: 100%">
                        <div class="shelf_txt"><p
                                style="text-align: center;"></br></br><?php echo $text_incompatible_combination_sizes; ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

</div>
