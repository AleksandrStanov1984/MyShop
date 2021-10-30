<?php echo $header; ?>
<?php if(isset($microdata_breadcrumbs) && $microdata_breadcrumbs) echo $microdata_breadcrumbs; ?>
<?php if(isset($microdata) && $microdata) echo $microdata; ?>
<script>
    (function ($) {
        $(document).ready(function () {
            dataLayer.push({
                'event': 'view_item',
                'value':
                    <?php echo $special ? preg_replace("/[^0-9]/", '', $special) : preg_replace("/[^0-9]/", '', $price); ?>,
        'items' : [{
	        'id': '
            <?php echo $product_id; ?>',
        'google_business_vertical': 'retail'
	      }]
	    });
	  });
	})( jQuery );
</script>

<?php if($in_stock){ ?>

<div class="product_sticky_panel">

    <div class="wrapper">

        <div class="sticky_panel_image hidden-xs hidden-sm"><img src="<?php echo $sticky_img_mini; ?>"
                                                                 title="<?php echo $heading_title; ?>"
                                                                 alt="<?php echo $heading_title; ?>"></div>

        <div class="sticky_panel_name hidden-xs hidden-sm"><?php echo $heading_title; ?></div>

        <div class="sticky_panel_price">

            <?php if($special){ ?>

            <div class="sticky-old-price"><?php echo $price; ?></div>

            <div class="sticky-new-price"><?php echo $special; ?></div>

            <?php }else{ ?>

            <div class="sticky-new-price"><?php echo $price; ?></div>

            <?php } ?>

        </div>

        <?php if ($reward) { ?>

        <div class="product_reward sticky_panel_reward hidden-xs hidden-sm hidden-md"><span class="reward_amount"><span
                        class="reward_amount__content">+<?php echo $reward; ?> <span
                            class="reward_amount__currency">грн</span></span></span><span
                    class="reward_label"> <?php echo $text_reward; ?></span></div>

        <?php } ?>

        <button type="button" class="btn-main button-cart"><img
                    src="catalog/view/theme/OPC080193_6/images/page_product/cart.svg"
                    alt="button cart"><?php echo $text_buy ?></button>

        <div class="button-bar">

            <button type="button" tooltip="<?php echo $wishlist ? $button_inwishlist : $button_wishlist; ?>"
                    class="wishlist-in-product" title="" onclick="wishlist.add('<?php echo $product_id; ?>');">
                <span><?php echo $wishlist ? '<img src="catalog/view/theme/OPC080193_6/images/page_product/heart.svg" alt="wishlist">
                    ' : '<img src="catalog/view/theme/OPC080193_6/images/page_product/heart-o.svg" alt="wishlist">'; ?></span>
            </button>

            <button type="button" data-toggle="tooltip" style="display: none" class="hidden-md"
                    title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product_id; ?>');"><img
                        src="catalog/view/theme/OPC080193_6/images/page_product/compare.svg" alt="wishlist"></button>

        </div>


    </div>

</div>

<?php } ?>

<div class="page-product" id="product">


    <div class="wrapper">

        <ul class="breadcrumb__list">

            <?php $pop_breadcrs = array_pop($breadcrumbs); foreach ($breadcrumbs as $breadcrumb) { ?>

            <li class="breadcrumb__item"><a
                        href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>

            <?php } ?>

        </ul>

        <div class="row">

            <div class="col-9">

                <h1 class="page-product__title"><?php echo $heading_title; ?></h1>

            </div>

            <div class="col-3 text-right">
                <?php if(isset($manufacturer_img)) { ?>
                <div class="product_brand">
                    <img class="img-responsive" src="<?php echo $manufacturer_img; ?>"
                         alt="<?php echo $manufacturer; ?>" title="<?php echo $manufacturer; ?>">
                </div>
                <?php } ?>


            </div>

        </div>

        <div class="block_over_image">

            <?php if ($review_status) { ?>

            <div class="rating">

                <p style="margin-bottom: 0px;">

                    <?php for ($i = 1; $i <= 5; $i++) { ?>

                    <?php if ($rating < $i) { ?>

                    <img src="catalog/view/theme/OPC080193_6/images/page_product/star_filled.svg" alt="rating">

                    <?php } else { ?>

                    <img src="catalog/view/theme/OPC080193_6/images/page_product/star_empty.svg" alt="rating">

                    <?php } ?>

                    <?php } ?>

                    <a class="btn-link link_rating" href=""
                       onclick="$('a[href=\'#tab-review\']').trigger('click'); return false;"><?php echo $reviews; ?></a>
                </p>

            </div>


            <?php } ?>

            <div class="page-product__sku"><?php echo $text_sku; ?> <span class="sku_number"><?php echo $sku; ?></span>
            </div>

        </div>

    </div>

    <div class="tab-panel">

        <div class="wrapper">

            <div class="tabs-header">

                <a href="#tab2" class="selected"><?php echo $tab_description ?></a>

                <?php if ($attribute_groups) { ?>

                <a href="#tab-specification" data-toggle="tab"><?php echo $tab_attribute; ?></a>

                <?php } ?>

                <?php if($videos){?>

                <a href="#tab3"><?php echo $tab_video; ?></a>

                <?php } ?>

                <a href="#tab_photos"><?php echo $tab_photos; ?></a>

            </div>

        </div>

    </div>


    <div class="wrapper">

        <div class="product-tabs">

            <div class="tabs">


                <div class="tabs-body" style="display: block">


                    <div class="tab" id="tab2">

                        <div class="row all_about_prod_top">

                            <div class="col-lg-6 col-md-6 product-images">

                                <div class="product-images__sticky">

                                    <div class="product-photo">

                                        <div class="product-photo2">

                                            <?php if($stickers_new || $stickers_top){ ?>

                                            <div class="prod_stickers">

                                                <?php if($stickers_new){ ?>

                                                <div>
                                                    <span class="prod_stickers_new"><?php echo $text_sticker_new; ?></span>
                                                </div>

                                                <?php } ?>

                                                <?php if($stickers_top){ ?>

                                                <div>
                                                    <span class="prod_stickers_top"><?php echo $text_sticker_top; ?></span>
                                                </div>

                                                <?php } ?>

                                            </div>

                                            <?php }?>

                                            <?php if($stickers_free){ ?>

                                            <div class="sticker_free_envelop"><span class="prod_stickers_free"><img
                                                            src="catalog/view/theme/OPC080193_6/image/stickers/sticker_free.svg"
                                                            alt="stickers free"> <span><?php echo $text_sticker_free; ?></span></span>
                                            </div>

                                            <?php }?>

                                            <div class="main-image">

                                                <div class="main-img-item"><a href="<?php echo $popup; ?>" class=""><img
                                                                src="<?php echo $thumb; ?>" id="productZoom"
                                                                class="img-responsive"
                                                                data-zoom-image="<?php echo $thumb; ?>"
                                                                alt="<?php echo $heading_title; ?>"
                                                                title="<?php echo $heading_title; ?>"/></a></div>

                                            </div>

                                            <div class="thumb-images">

                                                <?php if($videos){ ?>

                                                <?php foreach ($videos as $video){ ?>

                                                <div class="thumb-images-item"><a class="thumb-link-youtube"
                                                                                  href="<?php echo $video['video']; ?>"><span
                                                                class="thumb-images-youbute"><span
                                                                    class="button_youtube_play"><img
                                                                        src="catalog/view/theme/OPC080193_6/images/page_product/mdi_play_arrow.svg"
                                                                        alt="mdi_play_arrow"></span></span></a></div>

                                                <?php } ?>

                                                <?php } ?>

                                                <?php foreach($images as $key => $image){ ?>

                                                <div class="thumb-images-item"><a
                                                            href="<?php echo $image['popup'] ?>"><img
                                                                class="img-responsive miniature <?php echo $key == 0 ? "
                                                                active" : ""; ?>"
                                                        data-src="<?php echo $image['thumb'] ?>"
                                                        src="<?php echo $image['mini'] ?>"
                                                        alt="<?php echo $heading_title; ?> -
                                                        Фото <?php echo $key + 1; ?>"
                                                        title="<?php echo $heading_title; ?> -
                                                        Фото <?php echo $key + 1; ?>" /></a></div>

                                                <?php } ?>

                                            </div>

                                            <?php if($videos){ ?>

                                            <div class="video_view">

                                                <div class="video_view_stickers <?php echo count($videos) > 1 ? 'few-video-youtube' : 'one-video-youtube'; ?>">

                                                    <img src="catalog/view/theme/OPC080193_6/images/page_product/video_view.svg"
                                                         alt="video">

                                                </div>

                                                <div class="video_stiker_text"><?php echo $tab_video; ?></div>

                                            </div>

                                            <?php } ?>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-lg-6 col-md-6 card-right <?php echo $in_stock ? '' : 'out_of_stock'  ?>">

                                <div class="row card-right__top">

                                    <?php if((int)$height > 0 || (int)$width > 0 || (int)$length > 0 ||
                                    (int)$diameter_of_pot > 0){ ?>

                                    <div class="col-xl-4 col-lg-5 md-6 page-product__size">
                                        <div class="lettering_element"><?php echo $lettering_detail; ?></div>
                                        <div class="size"><?php if((int)$height >
                                            0) {echo '<span class="units-product" itemprop="name">' . $unit_h . ':</span><span itemprop="value"> '. (int)$height . '</span>'; }
                                            ?><?php if((int)$width > 0) { echo '<span class="units-product"
                                                                                      itemprop="name">'.$unit_w.':</span>
                                            <span itemprop="value">'.(int)$width . '</span>'; }
                                            ?><?php if((int)$length >
                                            0) {echo '<span class="units-product" itemprop="name">'.$unit_l.':</span> <span itemprop="value">'.(int)$length.'</span>'; }
                                            ?><?php if((int)$diameter_of_pot >
                                            0) {echo '<img src="catalog/view/theme/OPC080193_6/images/diameter_of_pot.svg" class="img-diameter-of-pot img-icon-pot" alt="diameter"> '.(int)$diameter_of_pot .' '. $unit; }
                                            ?><?php if((int)$diameter_of_pot >
                                            0) {echo ' <img src="catalog/view/theme/OPC080193_6/images/depth_of_pot.svg" class="img-depth-of-pot img-icon-pot" alt="depth"> '.(int)$depth_of_pot .' '. $unit; }
                                            ?>
                                        </div>
                                    </div>

                                    <?php }?>

                                    <div class="col-xl-4 col-lg-5 md-6">

                                        <?php if($in_stock > 0){ ?>

                                        <div class="page-product__status status_instock"><?php echo $stock; ?></div>

                                        <?php }else{ ?>

                                        <div class="page-product__status status_out_stock"><?php echo $stock; ?></div>

                                        <?php } ?>

                                    </div>

                                </div>

                                <!-- не удалять этот блок-->

                                <div class="col-md-12 block_for_hpm">


                                </div>

                                <!-- не удалять этот блок-->


                                <div class="dividing_line dividing_line_first"
                                <?php echo ((int)$height > 0 || (int)$width > 0 || (int)$length > 0 ||
                                (int)$diameter_of_pot > 0) ? 'style="display: block"' : ''; ?>>
                            </div>

                            <div class="card-right__middle">

                                <div class="row price-reward-wishlist">

                                    <div class="col-md-6 col-lg-4 col-6">

                                        <div class="price">
                                            <div class="lettering_element"><?php echo $text_price; ?></div>

                                            <?php if($special){ ?>

                                            <div class="old-price"><?php echo $price; ?></div>

                                            <div class="new-price"><?php echo $special; ?></div>

                                            <?php }else{ ?>

                                            <div class="new-price"><?php echo $price; ?></div>

                                            <?php } ?>

                                        </div>

                                    </div>

                                    <?php if ($reward) { ?>

                                    <div class="col-md-6 col-lg-4 col-6">

                                        <div class="product_reward"><span class="reward_amount"><span
                                                        class="reward_amount__content">+<?php echo $reward; ?> <span
                                                            class="reward_amount__currency">грн</span></span></span><span
                                                    class="reward_label"> <?php echo $text_reward; ?></span></div>

                                    </div>

                                    <?php } ?>

                                    <div class="col-md-6 col-lg-4 <?php echo $reward ? 'text-right' : ''; ?> button-bar">

                                        <div class="">

                                            <button type="button"
                                                    tooltip="<?php echo $wishlist ? $button_inwishlist : $button_wishlist; ?>"
                                                    class="wishlist-in-product" title=""
                                                    onclick="wishlist.add('<?php echo $product_id; ?>');">
                                                <span><?php echo $wishlist ? '<img src="catalog/view/theme/OPC080193_6/images/page_product/heart.svg" alt="wishlist">
                                                    ' : '<img
                                                            src="catalog/view/theme/OPC080193_6/images/page_product/heart-o.svg"
                                                            alt="wishlist">'; ?></span></button>

                                            <button type="button" data-toggle="tooltip" style="display: none"
                                                    title="<?php echo $button_compare; ?>"
                                                    onclick="compare.add('<?php echo $product_id; ?>');"><img
                                                        src="catalog/view/theme/OPC080193_6/images/page_product/compare.svg"
                                                        alt="wishlist"></button>

                                        </div>


                                    </div>

                                </div>

                                <?php if ($discounts) { ?>

                                <div class="opt-price">

                                    <?php foreach ($discounts as $discount) { ?>

                                    <span><i><?php echo $discount['quantity']; ?></i><?php echo $text_discount; ?> </span>
                                    <b><?php echo $discount['price']; ?></b><br/>

                                    <?php } ?>

                                </div>

                                <?php } ?>

                                <?php if($in_stock){ ?>

                                <div class="count spinbox hidden">

                                    <span><?php echo $text_quantity ?>:</span>

                                    <a href="javascript:void(0)" class="count-minus spin-minus"></a>

                                    <div class="count-input"><input type="text" name="quantity" value="1"/></div>

                                    <a href="javascript:void(0)" class="count-plus spin-plus"></a>

                                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>"/>

                                </div>

                                <div class="buttons block_btn">

                                    <button type="button" class="btn-main button-cart"><img
                                                src="catalog/view/theme/OPC080193_6/images/page_product/cart.svg"
                                                alt="button cart"><?php echo $text_buy ?></button>

                                    <div class="buy-one-click">

                                        <form method="POST">

                                            <p class="oneclick_label"><?php echo $text_oneclick ?></p>

                                            <div class="one-click-field">

                                                <input type="tel" name="phone" placeholder="+38 (___) ___-__-__">

                                                <button type="button" class="button_one_click">Ок</button>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                                <?php }else{ ?>

                                <div class="buttons buttons-off">

                                    <button type="button" class="btn-disabled button-cart"
                                            disabled><?php echo $outofstock; ?></button>

                                    <div class="buy-one-click">

                                        <form method="POST">

                                            <p class="oneclick_label"><?php echo $text_oneclick ?></p>

                                            <div class="one-click-field">

                                                <input type="tel" name="phone" placeholder="+38 (___) ___-__-__">

                                                <button type="button" class="button_one_click">Ok</button>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                                <?php } ?>

                            </div>

                            <div class="dividing_line dividing_line_second"></div>

                            <div class="product_delivery product_wrap_block">

                                <div class="product_delivery__header">

                                    <div class="product_wrap_title"><?php echo $text_shipping; ?></div>

                                    <?php if (($ip_info??false) && ($ip_info['info']??false)) { ?>

                                    <div class="ip-info"><span
                                                class="ip-info__label"><?php echo $text_your_city; ?></span><span
                                                id="product_city" class="ip-info__city"
                                                data-remodal-target="modal-city"><?php print $ip_info['info']; ?></span>
                                    </div>

                                    <?php } ?>

                                    <div class="clearfix"></div>

                                </div>
                                <?php if($deliveries) { ?>
                                <table class="product_delivery_table">
                                    <?php foreach ($deliveries as $delivery) { ?>
                                    <tr class="product_delivery_item">
                                        <td class="delivery-first-col delivery_types <?php echo $delivery['class']; ?>">
                                            <div class="delivery_types__content"><?php echo $delivery['name_shiping']; ?></div>
                                        </td>
                                        <td class="delivery_cost">
                                            <span class="delivery_cost__amount"><?php echo $delivery['price']; ?></span>

                                            <?php if($delivery['day_delivery'] !== '') { ?><span
                                                    class="delivary_date"><?php echo $delivery['day_delivery']; ?></span><?php } ?>

                                        </td>
                                        <td class="question_mark"></td>
                                    </tr>
                                    <?php } ?>

                                </table>
                                <?php } ?>
                            </div>

                            <div class="row">

                                <div class="col-lg-12 col-xl-6">

                                    <div class="product_wrap_block block_payment">

                                        <div class="product_wrap_title"><?php echo $text_payment; ?></div>

                                        <div class="product_wrap_content"><?php echo $text_payment_types; ?></div>

                                        <a href="<?php echo $payment_information_link; ?>"
                                           class="btn-link "><?php echo $text_more_link; ?></a>

                                    </div>

                                </div>

                                <div class="col-lg-12 col-xl-6">

                                    <div class="product_wrap_block block_guarantee">

                                        <div class="product_wrap_title"><?php echo $text_guarantee; ?></div>

                                        <div class="product_wrap_content"><?php echo $text_guarantee_info; ?></div>

                                        <a href="#" class="btn-link"
                                           style="display: none"><?php echo $text_more_link; ?></a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <?php if($description){ ?>

                    <!--seo_text_start-->

                    <div class="content-box description short-description-prod">
                        <div class="content-box__title">
                            <?php echo $tab_description2 ?>
                        </div>
                        <?php echo str_replace("<p>&nbsp;</p>",'',$description); ?>
                        <div class="option-gradient"></div>
                    </div>

                    <!--seo_text_end-->

                    <a class="btn-all-description hidden"
                       href="javascript:void(0);"><?php echo $text_expand_specifications; ?></a>

                    <?php } ?>

                </div>

                <?php if ($attribute_groups) { ?>

                <div class="tab short-specification <?php echo $description ? 'desctiption_exist' : ''; ?>"
                     id="tab-specification">

                    <div class="content-box">

                        <div class="content-box__title"><?php echo $tab_attribute; ?></div>

                        <table class="table_specification">

                            <?php foreach ($attribute_groups as $attribute_group) { ?>

                            <tr class="attribute_group__header">

                                <td colspan="2"><?php echo $attribute_group['name']; ?>:</td>

                            </tr>

                            <?php foreach ($attribute_group['attribute'] as $attribute) { ?>

                            <tr class="specification-item">

                                <td class="td-attribute">
                                    <div><span><?php echo $attribute['name']; ?>: </span></div>
                                </td>

                                <td class="td-attribute-value">
                                    <p><?php echo str_replace(';', '; ', $attribute['text']); ?></p></td>

                            </tr>

                            <?php } ?>


                            <?php } ?>

                        </table>

                        <?php if($count_row_attribute > 9){ ?>

                        <button type="button"
                                class="specifications__all-link  <?php echo $count_row_attribute; ?>"><?php echo $text_specification_all?></button>

                        <?php } ?>

                    </div>

                </div>

                <?php } ?>

                <?php if($videos){?>

                <div class="tab" id="tab3">

                <div class="content-box">

                <div class="row video_youtube_row" >

                <?php foreach ($videos as $key => $video) { ?>

                <?php if($key == 0) { ?>

                <div class="col-md-12 video_youtube_item video_youtube_main">

                <div class="video_youtube_title"><?php echo $video['name']; ?></div>

                <div class="youtube-embed-wrapper" style="position:relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden"><iframe allow=";" allowfullscreen="" frameborder="0" height="1280" src="<?php echo $video['video']; ?>" style="position:absolute;top:0;left:0;width:100%;height:100%" width="720"></iframe></div>

                </div>

                <?php }else{ ?>

                <div class="col-xl-3 col-lg-4 col-md-4 video_youtube_item">

                    <div class="video_youtube_title"><?php echo $video['name']; ?></div>

                    <div class="youtube-embed-wrapper"
                         style="position:relative;padding-bottom:56.25%;padding-top:30px;height:0;overflow:hidden">
                        <iframe allow=";" allowfullscreen="" frameborder="0" height="1280"
                                src="<?php echo $video['video']; ?>"
                                style="position:absolute;top:0;left:0;width:100%;height:100%" width="720"></iframe>
                    </div>

                </div>

                <?php } ?>

                <?php } ?>

            </div>

        </div>

    </div>

    <?php } ?>

    <div class="tab" id="tab_photos">

        <div class="content-box">

            <div class="content-box__title"><?php echo $tab_photos_title; ?></div>

            <?php foreach($images as $key => $image){ ?>

            <div class="tab_photos_image"><img class="img-responsive" src="<?php echo $image['popup']; ?>"
                                               alt="<?php echo $heading_title; ?> - Фото <?php echo $key + 1; ?>"
                                               title="<?php echo $heading_title; ?> - Фото <?php echo $key + 1; ?>"/>
            </div>

            <?php } ?>

        </div>

    </div>

    <div class="sticky-block hidden card-right <?php echo $in_stock ? '' : 'out_of_stock'  ?>">

        <div class="sticky-block_inside">

            <div class="sticky-block__top">


                <img src="<?php echo $sticky_img; ?>" class="img-responsive" alt="<?php echo $heading_title; ?>"
                     title="<?php echo $heading_title; ?>">


                <div>

                    <div class="sticky-block__top_title"><?php echo $heading_title; ?></div>

                    <?php if($in_stock > 0){ ?>

                    <div class="page-product__status status_instock"><?php echo $stock; ?></div>

                    <?php }else{ ?>

                    <div class="page-product__status status_out_stock"><?php echo $stock; ?></div>

                    <?php } ?>


                </div>


            </div>

            <div class="dividing_line"></div>

            <div class="card-right__middle">

                <div class="row price-reward-wishlist">

                    <div class="col-md-6">

                        <div class="price">
                            <div class="lettering_element"><?php echo $text_price; ?></div>

                            <?php if($special){ ?>

                            <div class="old-price"><?php echo $price; ?></div>

                            <div class="new-price"><?php echo $special; ?></div>

                            <?php }else{ ?>

                            <div class="new-price"><?php echo $price; ?></div>

                            <?php } ?>

                        </div>

                    </div>

                    <?php if ($reward) { ?>

                    <div class="col-md-6">

                        <div class="product_reward"><span class="reward_amount"><span
                                        class="reward_amount__content">+<?php echo $reward; ?> <span
                                            class="reward_amount__currency">грн</span></span></span><span
                                    class="reward_label"> <?php echo $text_reward; ?></span></div>

                    </div>

                    <?php } ?>

                    <div class="col-md-6 button-bar">

                        <div class="">

                            <button type="button"
                                    tooltip="<?php echo $wishlist ? $button_inwishlist : $button_wishlist; ?>"
                                    class="wishlist-in-product" title=""
                                    onclick="wishlist.add('<?php echo $product_id; ?>');">
                            <span><?php echo $wishlist ? '<img src="catalog/view/theme/OPC080193_6/images/page_product/heart.svg" alt="wishlist">
                                ' : '<img src="catalog/view/theme/OPC080193_6/images/page_product/heart-o.svg"
                                          alt="wishlist">'; ?></span></button>

                            <button type="button" data-toggle="tooltip" style="display: none"
                                    title="<?php echo $button_compare; ?>"
                                    onclick="compare.add('<?php echo $product_id; ?>');"><img
                                        src="catalog/view/theme/OPC080193_6/images/page_product/compare.svg"
                                        alt="wishlist">
                            </button>

                        </div>


                    </div>

                </div>

                <?php if($in_stock){ ?>

                <div class="buttons block_btn">

                    <button type="button" class="btn-main button-cart"><img
                                src="catalog/view/theme/OPC080193_6/images/page_product/cart.svg"
                                alt="button cart"><?php echo $text_buy ?></button>

                    <div class="buy-one-click">

                        <form method="POST">

                            <p class="oneclick_label"><?php echo $text_oneclick ?></p>

                            <div class="one-click-field">

                                <input type="tel" name="phone" placeholder="+38 (___) ___-__-__">

                                <button type="button" class="button_one_click">Ok</button>

                            </div>

                        </form>

                    </div>

                </div>

                <?php }else{ ?>

                <div class="buttons buttons-off">

                    <button type="button" class="btn-disabled button-cart" disabled><?php echo $outofstock; ?></button>

                    <div class="buy-one-click">

                        <form method="POST">

                            <p class="oneclick_label"><?php echo $text_oneclick ?></p>

                            <div class="one-click-field">

                                <input type="tel" name="phone" placeholder="+38 (___) ___-__-__">

                                <button type="button" class="button_one_click">Ok</button>

                            </div>

                        </form>

                    </div>

                </div>

                <?php } ?>

            </div>

            <div class="dividing_line dividing_line_second"></div>

            <div class="product_delivery product_wrap_block">

                <div class="product_delivery__header">

                    <div class="product_wrap_title"><?php echo $text_shipping; ?></div>

                </div>

                <div class="product_delivery__content content_inside">

                    <div class="clearfix"></div>

                    <?php if(isset($deliveries) && $deliveries) { ?>
                    <table class="product_delivery_table">
                        <?php foreach ($deliveries as $delivery) { ?>
                        <tr class="product_delivery_item">
                            <td class="delivery-first-col delivery_types  delivery_types_np">
                                <div class="delivery_types__content"><?php echo $delivery['name_shiping']; ?></div>
                            </td>
                            <td class="delivery_cost">
                                <span class="delivery_cost__amount"><?php echo $delivery['price']; ?></span>

                                <?php if($delivery['day_delivery'] !== '') { ?><span
                                        class="delivary_date"><?php echo $delivery['day_delivery']; ?></span><?php } ?>

                            </td>
                            <td class="question_mark"></td>
                        </tr>
                        <?php } ?>
                    </table>
                    <?php } ?>
                </div>


            </div>

            <div class="row">

                <div class="col-12">

                    <div class="product_wrap_block block_payment">

                        <div class="product_wrap_title"><?php echo $text_payment; ?></div>

                        <div class="product_wrap_content content_inside hidden"><?php echo $text_payment_types; ?>

                            <a href="<?php echo $payment_information_link; ?>"
                               class="btn-link "><?php echo $text_more_link; ?></a>

                        </div>


                    </div>

                </div>

                <div class="col-12">

                    <div class="product_wrap_block block_guarantee">

                        <div class="product_wrap_title"><?php echo $text_guarantee; ?></div>

                        <div class="product_wrap_content content_inside hidden"><?php echo $text_guarantee_info; ?>

                            <a href="#" style="display: none" class="btn-link"><?php echo $text_more_link; ?></a>

                        </div>


                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="clearfix"></div>


    <?php if ($review_status) { ?><?php } ?>

</div>

</div>


</div>

<div class="" style="margin-bottom: 60px">


    <?php if ($products) { ?>

    <div class="box related">

        <div class="box-content">

            <div id="products-related" class="related-products block-products catalog-mobile">

                <div class="h2-title title-carousel-product"><?php echo $text_related; ?></div>

                <div id="slider-products-related"
                     class="owl-carousel owl-moneymaker2 slider-popular cat__slider-products">

                    <?php foreach ($products as $product) { ?>

                    <div class="item"
                         style="height: 100%;<?php echo (isset($product['in_stock'])&&$product['in_stock'])? '' : 'opacity: 0.5' ?>"
                    ">

                    <div class="image"><a href="<?php echo $product['href'] ?>"><img src="image/loader-gray.gif"
                                                                                     data-src="<?php echo $product['thumb'] ?>"
                                                                                     class="img-responsive lazy-sz"
                                                                                     alt="<?php echo $product['name'] ?>"/></a>
                    </div>

                    <div class="model"><a href="<?php echo $product['href'] ?>"><b><?php //echo $product['model'] ?></b></a>
                    </div>

                    <div class="size"><?php if ($product['height']){ ?>

                        <span class="units-product"><?php echo $unit_h; ?>:</span>
                        <span><?php echo $product['height'] ?></span><?php } ?><?php if ($product['width']){ ?> <span
                                class="units-product"> <?php echo $unit_w; ?>:</span>
                        <span><?php echo $product['width'] ?></span><?php } ?> <?php if ($product['height']){ ?><span
                                class="units-product"> <?php echo $unit_l; ?>:</span>
                        <span><?php echo $product['length'] ?></span><?php } ?>

                        <?php if ($product['diameter_of_pot']){ ?>

                        <img src="catalog/view/theme/OPC080193_6/images/diameter_of_pot.svg"
                             class="img-diameter-of-pot img-icon-pot"
                             alt="diameter"> <?php echo $product['diameter_of_pot'];?> <?php echo $unit; ?> <?php } ?><?php if ($product['depth_of_pot']){ ?>
                        <img src="catalog/view/theme/OPC080193_6/images/depth_of_pot.svg"
                             class="img-depth-of-pot img-icon-pot"
                             alt="depth"><?php echo $product['depth_of_pot'];?> <?php echo $unit; ?><?php } ?>

                    </div>

                    <a class="name" href="<?php echo $product['href'] ?>"><?php echo $product['name'] ?></a>

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

                            <div class="price-new"><b><?php echo $product['special'] ?></b></div>

                            <?php }else{ ?>

                            <div class="price-regular outofstock"><?php echo $product['price'] ?></div>

                            <?php } ?>

                        </div>

                        <?php } ?>

                    </div>

                </div>

                <?php } ?>

            </div>

        </div>

    </div>

</div>

<?php } ?>

<?php echo $content_bottom; ?>


</div>

</div>

</div>

<div class="remodal remodal-dark modal-one-click" data-remodal-id="modal-one-click" id="modal-one-click"
     data-remodal-options="hashTracking: false">

    <button data-remodal-action="close" class="remodal-close"></button>

    <div class="modal-body">


    </div>

</div>


<script><!--

    $('select[name=\'recurring_id\'], input[name="quantity"]').change(function () {

        $.ajax({

            url: 'index.php?route=product/product/getRecurringDescription',

            type: 'post',

            data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),

            dataType: 'json',

            beforeSend: function () {

                $('#recurring-description').html('');

            },

            success: function (json) {

                $('.alert, .text-danger').remove();


                if (json['success']) {

                    $('#recurring-description').html(json['success']);

                }

            }

        });

    });

    //--></script>

<script><!--

    $('.button-cart').on('click', function () {


        $.ajax({

            url: 'index.php?route=checkout/cart/add',

            type: 'post',

            data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),

            dataType: 'json',

            beforeSend: function () {

                //$('#button-cart').button('loading');

            },

            complete: function () {

                //$('#button-cart').button('reset');

            },

            success: function (json) {

                $('.alert, .text-danger').remove();

                $('.form-group').removeClass('has-error');


                if (json['error']) {

                    if (json['error']['option']) {

                        for (i in json['error']['option']) {

                            var element = $('#input-option' + i.replace('_', '-'));


                            if (element.parent().hasClass('input-group')) {

                                element.parent().before('<div class="text-danger">' + json['error']['option'][i] + '</div>');

                            } else {

                                element.before('<div class="text-danger">' + json['error']['option'][i] + '</div>');

                            }

                        }

                    }


                    if (json['error']['recurring']) {

                        $('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');

                    }


                    // Highlight any found errors

                    $('.text-danger').parent().addClass('has-error');

                }


                if (json['success']) {

                    $('#cart').load('index.php?route=common/cart/info');

                    $('.cart > i').html(json['total']);

                    $('#header-mob .cart').trigger('click');

                }

            }

        });

    });

    //--></script>

<script><!--

    $('button[id^=\'button-upload\']').on('click', function () {

        var node = this;


        $('#form-upload').remove();


        $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');


        $('#form-upload input[name=\'file\']').trigger('click');


        if (typeof timer != 'undefined') {

            clearInterval(timer);

        }


        timer = setInterval(function () {

            if ($('#form-upload input[name=\'file\']').val() != '') {

                clearInterval(timer);


                $.ajax({

                    url: 'index.php?route=tool/upload',

                    type: 'post',

                    dataType: 'json',

                    data: new FormData($('#form-upload')[0]),

                    cache: false,

                    contentType: false,

                    processData: false,

                    beforeSend: function () {

                        $(node).button('loading');

                    },

                    complete: function () {

                        $(node).button('reset');

                    },

                    success: function (json) {

                        $('.text-danger').remove();


                        if (json['error']) {

                            $(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');

                        }


                        if (json['success']) {

                            alert(json['success']);


                            $(node).parent().find('input').val(json['code']);

                        }

                    },

                    error: function (xhr, ajaxOptions, thrownError) {

                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);

                    }

                });

            }

        }, 500);

    });

    //--></script>

<script><!--

    $('#review').delegate('.pagination a', 'click', function (e) {

        e.preventDefault();


        $('#review').fadeOut('slow');


        $('#review').load(this.href);


        $('#review').fadeIn('slow');

    });


    $('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');


    $('#button-review').on('click', function () {

        $.ajax({

            url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',

            type: 'post',

            dataType: 'json',

            data: $("#form-review").serialize(),

            beforeSend: function () {

                $('#button-review').button('loading');

            },

            complete: function () {

                $('#button-review').button('reset');

            },

            success: function (json) {

                $('.alert-success, .alert-danger').remove();


                if (json['error']) {

                    $('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');

                }


                if (json['success']) {

                    $('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');


                    $('input[name=\'name\']').val('');

                    $('textarea[name=\'text\']').val('');

                    $('input[name=\'rating\']:checked').prop('checked', false);

                }

            }

        });

    });


    $('#tabs a').tabs();

    $('#custom_tab a').tabs();


    //--></script>


<script>

    $(document).ready(function () {


        // Change price

        $('.count-plus, .count-minus').on('click', function () {

            $('.count-input input[name=\'quantity\']').trigger('change');

        });


        $(".btn-all-description").click(function () {

            if ($('.content-box').hasClass('short-description-prod')) {

                $(".tab .content-box").toggleClass("short-description-prod");

                $(".content-box .option-gradient").toggleClass("hide");

                $(this).text('<?php echo $text_collapse_specifications; ?>');

            } else {

                var top = $('.content-box').offset().top;

                $('body, html').animate({scrollTop: top - 102}, 1500);

                $(".tab .content-box").toggleClass("short-description-prod");

                $(".content-box .option-gradient").toggleClass("hide");

                $(this).text('<?php echo $text_expand_specifications; ?>');


            }


        });

        $('#tab-specification').on('click', '.specifications__all-link', function () {


            var positionTabs = $('.tabs').offset();

            if (window.matchMedia('(max-width: 767px)').matches) {

                $('body,html').animate({scrollTop: 0}, 200);

            } else {

                $('body,html').animate({scrollTop: 0}, 200);

            }

            setTimeout(function (){$('a[href=\'#tab-specification\']').trigger('click');}, 400);

        });


    });

</script>

<script>

    $(document).ready(function () {

        $('#slider-products-related').owlCarousel({

            dots: false,

            navText: ['<i></i>', '<i></i>'],

            responsiveClass: true,

            responsive: {

                0: {

                    loop: false,

                    mouseDrag: false,

                    touchDrag: false,

                    autoWidth: false,

                    items: 2.5,

                    margin: 18,

                    nav: false,

                },

                375: {

                    loop: false,

                    items: 2.7,

                    margin: 18,

                    autoWidth: false,

                    //nav: false,

                    //items: 2

                },

                479: {

                    loop: false,

                    items: 2.9,

                    autoWidth: false,

                    margin: 18,

                    //nav: false,

                    //items: 2

                },

                500: {

                    loop: false,

                    items: 3.2,

                    margin: 18,

                    autoWidth: false,

                    nav: false

                },

                600: {

                    loop: false,

                    items: 3.8,

                    margin: 18,

                    autoWidth: false,

                    nav: false

                },

                768: {

                    mouseDrag: true,

                    touchDrag: true,

                    //autoWidth: true,

                    nav: true,


                    items: 2

                },

                900: {

                    mouseDrag: true,


                    touchDrag: true,

                    //autoWidth: true,

                    nav: true,

                    items: 2

                },

                992: {

                    nav: true,


                    //autoWidth: true

                    items: 3

                },

                1199: {

                    nav: true,


                    items: 5

                    //autoWidth: true

                },

            },


        });

    });


</script>


<script>


    $(document).ready(function () {

        $('#video_carousel').owlCarousel({

            dots: false,

            navText: ['<i></i>', '<i></i>'],

            responsiveClass: true,

            touchDrag: true,

            margin: 40,

            responsive: {

                0: {

                    loop: false,

                    items: 1.3,

                    nav: true,

                    margin: 18

                },

                768: {

                    mouseDrag: true,

                    touchDrag: true,

                    //autoWidth: true,

                    nav: true,

                    loop: false,

                    items: 1.8

                },


                1199: {

                    nav: true,

                    loop: true,

                    items: 2.3,


                    //autoWidth: true

                },

            },


        });


        $('#productZoom, .thumb-link-youtube').click(function (event) {

            event.preventDefault();

        });

        if (window.matchMedia('(min-width: 768px)').matches) {

            $('#productZoom').elevateZoom({

                zoomType: "inner",

                cursor: "crosshair"

            });

        }
        ;

        $('#productZoom, .thumb-link-youtube').click(function () {

            $.fancybox.open($('.thumb-images-item a'), {

                touch: false

            });

        });


        $('.thumb-images-item a').not('.thumb-link-youtube').click(function (event) {

            event.preventDefault();

            var a = $(this).find('img').data('src');


            var b = $(this).find('img').data('src');

            $('.thumb-images-item img').removeClass('active');

            $(this).find('img').addClass('active');

            $('#productZoom').attr('src', b);

            $('.zoomWindow').css('background-image', 'url(' + a + ')');

        });

        $('.thumb-images-item a').not('.thumb-link-youtube').mouseenter(function (event) {

            $(this).trigger('click');


        });


    });

</script>

<script>

    $(document).ready(function () {

        $('.video_view_stickers').click(function () {

            if ($(this).hasClass('few-video-youtube')) {

                $('a[href=\'#tab3\']').trigger('click');

                var positionTabs = $('.tabs').offset();

                if (window.matchMedia('(max-width: 767px)').matches) {

                    $('body,html').animate({scrollTop: positionTabs.top - 70}, 2000);

                    return false;

                } else {

                    $('body,html').animate({scrollTop: positionTabs.top - 100}, 2000);

                    return false;

                }


            } else {

                $.fancybox.open($('.thumb-images-item a'), {

                    touch: false

                });

            }

        });

        $('.product_wrap_title').click(function () {

            $(this).toggleClass('content_inside_open');

            $(this).parents('.product_wrap_block').find('.content_inside').toggleClass('hidden');

        })

    });

</script>

<script>

    $(document).ready(function () {

        $('.button_one_click').click(function () {

            var buttonCallback = $(this);

            $.ajax({

                url: 'index.php?route=information/information/callback',

                type: 'post',

                data: $(this).parents('form').serialize(),

                dataType: 'json',

                beforeSend: function () {

                    buttonCallback.siblings('input').removeClass('error');

                },

                success: function (json) {

                    if (json['error_firstname']) {

                        buttonCallback.siblings('input[name=\'firstname\']').addClass('error');

                    }

                    if (json['error_phone']) {

                        buttonCallback.siblings('input[name=\'phone\']').addClass('error');


                    }

                    if (json['success']) {

                        $('#modal-one-click .modal-body').html('<div class="success">' + json['success'] + '</div>');

                        var inst = $('[data-remodal-id=modal-one-click]').remodal();

                        /*Открываем модальное окно*/

                        inst.open();

                    }


                },

                error: function (xhr, ajaxOptions, thrownError) {

                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);

                    $('#modal-one-click .modal-body').html('<div class="success">' + thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText + '</div>');

                    var inst = $('[data-remodal-id=modal-one-click]').remodal();

                }

            });

        })

    });

</script>


<script>


    $(document).ready(function () {

        $('.product-images .thumb-images').slick({

            //asNavFor: '.main-image',

            arrows: true,

            slidesToShow: 5,

            vertical: true,

            infinite: false,

            responsive: [

                {

                    breakpoint: 1368,

                    settings: {

                        slidesToShow: 4,


                        vertical: true,

                    }

                },

                {

                    breakpoint: 1200,

                    settings: {

                        slidesToShow: 7,


                        vertical: false,

                    }

                },

                {

                    breakpoint: 1023,

                    settings: {

                        slidesToShow: 6,


                        vertical: false,

                    }

                },

                {

                    breakpoint: 992,

                    settings: {

                        slidesToShow: 5,


                        vertical: false,

                    }

                },

                {

                    breakpoint: 768,

                    settings: {

                        slidesToShow: 10,


                        vertical: false,

                    }

                },

                {

                    breakpoint: 700,

                    settings: {

                        slidesToShow: 9,

                        vertical: false,

                    }

                },

                {

                    breakpoint: 640,

                    settings: {

                        slidesToShow: 8,

                        vertical: false,

                    }

                },

                {

                    breakpoint: 580,

                    settings: {

                        slidesToShow: 7,

                        vertical: false,

                    }

                },

                {

                    breakpoint: 481,

                    settings: {

                        slidesToShow: 6,

                        vertical: false,

                    }

                },

                {

                    breakpoint: 400,

                    settings: {

                        slidesToShow: 5,

                        vertical: false,

                    }

                }


            ]

        });

    });

</script>

<script>

    $(document).ready(function () {

        $('a[href=#tab2]').click(function () {

            //	setTimeout(function(){$('.product-images .thumb-images').slick('refresh'); }, 100);


        });

        $('.product-images .thumb-images').on('init', function (event, slick, direction) {

            console.log('edge was hit')

        });

    });

</script>

<script>

    window.onload = () => {

        let stickyPanel = document.querySelector('.product_sticky_panel');


// настройки

        let options = {

            root: null,

            rootMargin: '5px',

            threshold: [0, 1]

        }


// функция обратного вызова


        let callback1 = function (entries, observer1) {

            entries.forEach(entry => {

                console.log(entry.intersectionRatio);

                if (entry.intersectionRatio == 0) {

                    stickyPanel.classList.add('sticky_panel_active');


                } else {

                    stickyPanel.classList.remove('sticky_panel_active');

                }

            })

        }

        let callback2 = function (entries, observer2) {

            entries.forEach(entry => {


                if (entry.intersectionRatio == 0) {

                    stickyPanel.classList.add('sticky_panel_active2');


                } else {

                    stickyPanel.classList.remove('sticky_panel_active2');

                }

            })

        }

// наблюдатель

        let observer1 = new IntersectionObserver(callback1, options);

        let target1 = document.querySelector('#tab2 .block_btn');

        observer1.observe(target1);

        let observer2 = new IntersectionObserver(callback2, options);

        let target2 = document.querySelector('.sticky-block .block_btn');

        observer2.observe(target2);

    }

</script>

<script>
    /*
        $(document).ready(function () {
            var view_pickup = <?php echo $view_pickup; ?>;
            if(view_pickup == 1){
                $('.view_pickup').show();
            }else{
                $('.view_pickup').hide();
            }

            var view_courier = <?php echo $view_courier; ?>;
            if(view_courier == 1){
                $('.view_sz_courier').show();
            }else{
                $('.view_sz_courier').hide();
            }
        });
        */
    //--></script>
<script><!--
    $('.button-cart').after('<?php echo $credit; ?>');
    $('.button-credit').on('click', function () {
        $.ajax({
            url: 'index.php?route=extension/module/creditprivat/checkoptions',
            type: 'post',
            data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
            dataType: 'json',
            success: function (json) {
                $('.alert, .text-danger').remove();
                $('.form-group').removeClass('has-error');

                if (json['error']) {
                    if (json['error']['option']) {
                        for (i in json['error']['option']) {
                            var element = $('#input-option' + i.replace('_', '-'));

                            if (element.parent().hasClass('input-group')) {
                                element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                            } else {
                                element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                            }
                        }
                    }

                    if (json['error']['recurring']) {
                        $('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
                    }

                    // Highlight any found errors
                    $('.text-danger').parent().addClass('has-error');
                }

                if (json['success']) {
                    $.magnificPopup.open({
                        //	type:'ajax',
                        tLoading: '',
                        tLoading: '<img src="catalog/view/javascript/jquery/pp_calculator/img/pp_logo.png" />',
                        removalDelay: 300,
                        callbacks: {
                            beforeOpen: function () {
                                this.st.mainClass = 'mfp-zoom-in';
                            }
                        },
                        items: {
                            type: 'ajax',
                            src: 'index.php?route=extension/module/creditprivat/loadpopup'
                        },
                        ajax: {
                            settings: {
                                type: 'GET',
                                data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
                            }
                        }
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
    //--></script>
<?php echo $footer; ?>
