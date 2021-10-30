<?php echo $header; ?>
<?php if(isset($microdata_breadcrumbs) && $microdata_breadcrumbs) echo $microdata_breadcrumbs; ?>
<?php if(isset($microdata) && $microdata) echo $microdata; ?>
<section class="block-result" id="search_result">
      <div class="wrapper" id="content">
      <h1><?php echo $heading_title; ?></h1>
      <?php if ($products) { ?>
        <div class="catalog-mobile">
        <div class="block-products" style="margin-bottom: 15px">
        <div class="row row-margin-5">
            <?php $ppos = 0; foreach ($products as $product) { $ppos++; ?>
              <div <?php echo $product['product_id'] ? '' : 'style="display:none"'; ?> class="product-layout <?php echo $is_mobile ? 'product-list' : 'product-grid' ?> <?php if ($column_left || $column_right) {echo 'col-xl-3 col-lg-4 col-md-3 col-sm-4 col-6';}elseif($column_left && $column_right){echo 'col-lg-6 col-md-6 col-sm-4 col-12';} else{echo 'col-lg-2 col-md-3 col-sm-4 col-6';} ?> <?php echo $product['hpm_block_model_id']; ?>" <?php echo !empty($product['hpm_block']) ? 'data-exist="exist-hpm"': ''?> <?php echo !empty($product['hpm_block_model_id']) ? 'data-model_id="model_id_'.$product['hpm_block_model_id'].'"': ''?>  <?php echo (isset($product['in_stock'])&&$product['in_stock'])? '' : 'data-stock="card_out_stock"' ?>>
                <div class="item">
            <div class="couple_btn">
            <button type="button" class="btn-wishlist btn-wishlist-incatalog <?php echo $product['wish'] ? 'added_alredy' : ''; ?>"  data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><img src="<?php echo $product['wish'] ? 'catalog/view/theme/OPC080193_6/images/page_product/heart.svg' : 'catalog/view/theme/OPC080193_6/images/page_category/favorites.svg'; ?>" alt="wishlist"></button>
              <button type="button" data-toggle="tooltip" title="В сравнение" style="display: none;" onclick="compare.add('94902');"><img src="catalog/view/theme/OPC080193_6/images/page_category/compare_gray.svg" alt="compare"></button>
            </div>
            <div class="image"><a href="<?php echo $product['href']; ?>">
                      <img src="image/loader-gray.gif" data-src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" class="img-responsive lazy-sz" title="<?php echo $product['name']; ?>"/></a></div>
                  <div class="all-info-product">
                    <div class="size">
                      <?php if ($product['height']){ ?>
                      <span class="units-product"><?php echo $unit_h; ?>:</span> <span><?php echo $product['height'] ?></span><?php } ?><?php if ($product['width']){ ?><span class="units-product"><?php echo $unit_w; ?>:</span> <span><?php echo $product['width'] ?></span><?php } ?><?php if ($product['height']){ ?><span class="units-product"><?php echo $unit_l; ?>:</span> <span><?php echo $product['length'] ?></span><?php } ?>
                      <?php if ($product['diameter_of_pot']){ ?>
                      <img src="catalog/view/theme/OPC080193_6/images/diameter_of_pot.svg" class="img-diameter-of-pot img-icon-pot" alt="diameter"> <?php echo $product['diameter_of_pot'];?> <?php echo $unit; ?> <?php } ?><?php if ($product['depth_of_pot']){ ?> <img src="catalog/view/theme/OPC080193_6/images/depth_of_pot.svg" class="img-depth-of-pot img-icon-pot" alt="depth"><?php echo $product['depth_of_pot'];?> <?php echo $unit; ?><?php } ?>
                    </div>
                    <a class="name" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                    <!--<a class="model" href="<?php echo $product['href'] ?>"><b><?php echo $product['model'] ?></b></a>-->
                    <div class="product-panel">
                      <?php if ($product['price']) { ?>
                      <div class="price">
                        <?php if ($product['special']) { ?>
                          <div class="price-old"><?php echo $product['price'] ?></div>
                          <div class="price-new"><?php echo $product['special'] ?></div>
                        <?php } else { ?>
                          <div class="price-old" style="height: 15px"></div>
                          <div class="price-regular"><?php echo $product['price'] ?></div>
                      <?php } ?>
                      </div>
                      <?php } ?>
                      <?php if ($product['rating']) { ?>
                      <div class="rating">
                      <?php for ($i = 1; $i <= 5; $i++) { ?>
                          <?php if ($product['rating'] < $i) { ?>
                          <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                          <?php } else { ?> <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                          <?php } ?>
                      <?php } ?>
                      </div>
                      <?php } ?>
                      <div class="button button-page-category">
                        <button <?php echo (isset($product['in_stock'])&&$product['in_stock'])? '' : 'disabled' ?> onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');" class="btn-buy <?php echo $product['incart'] ? 'added_to_cart' : ''; ?>"><span class="card-img <?php echo $product['incart'] ? 'basket_done' : 'basket_empty'; ?>"></span><span class="btn-buy-text"><?php echo $button_cart; ?></span>
                        </button>
                      </div>
                    </div>
                    <div class="stock_status <?php echo ($product['stock_status_id'] == 7 || $product['stock_status_id'] == 8) ? 'in_stock_status' : 'out_stock_status'?>"><?php echo $product['stock_status'] ?></div>
                  </div>
                </div>
              </div>
            <?php } ?>
        </div></div></div>
        <div class="pagination-wrapper">
          <div class="col-sm-12 text-left page-link"><?php echo $pagination; ?></div>
        </div>
      <?php } else { ?>
        <p><?php echo $text_empty; ?></p>
      <?php } ?>
    </div>
</section>
<?php echo $footer; ?>
