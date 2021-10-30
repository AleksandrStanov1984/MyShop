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
            <div class="title-feature-carousel"> <?php echo $m['heading_title']; ?></div>

            <?php } ?>
                <div id="owl-<?php echo $m['module']; ?>" class="owl-carousel slider-popular cat__slider-products" style="display: flex;">
                  <?php foreach ($m['products'] as $product) { ?>
                    <div class="item">

                      <div class="image"><a href="<?php echo $product['href']; ?>" data-hpm-href="1"><img  src="<?php echo $product['image'] ? $product['image'] : HTTP_SERVER . 'image/no_image.png' ; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
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
                          <div class="price-old"><?php echo $product['price'] ?><span class="currency-value"> грн</span></div>
                            <div class="price-new"><?php echo $product['special'] ?><span class="currency-value"> грн</span></div>
                            <?php }else{ ?>
                            <div class="price-regular"><?php echo $product['price'] ?><span class="currency-value"> грн</span></div>
                            <?php } ?>
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                    </div>
                  <?php } ?>
                  </div>

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
<?php } ?>
