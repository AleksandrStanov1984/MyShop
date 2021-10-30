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
              <div class="title-carousel-product h2-title title-section-mob <?php echo count($modules) > 1 ? 'tilte-tab-home' : 'tilte-view-home'; ?> ">

                <?php if (count($modules) > 1) { ?><span class="popular-title-tab title-first-cell hidden-sm hidden-md hidden-lg"><?php echo $m['subtitle'] ? $m['subtitle'].' /' : ''; ?></span><?php }?><span class="title-second-cell"> <?php echo $m['heading_title']; ?></span><?php if($m['link_see_all']){ ?><a class=" show-full" href="<?php echo $m['link_see_all']; ?>"><?php echo $text_see_all; ?></a><?php } ?>
                </div>


            <?php } ?>
                <div id="owl-<?php echo $m['module']; ?>" class="owl-carousel owl-moneymaker2 slider-popular cat__slider-products" >
                  <?php foreach ($m['products'] as $product) { ?>
                    <div class="item" style="height: 100%;" >
                      <div class="image">
                        <a href="<?php echo $product['href']; ?>" data-hpm-href="1"><img  style="width: 162px" src="<?php echo $product['image'] ? $product['image'] : HTTP_SERVER . 'image/no_image.png' ; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive lazy-sz"/></a>
                      </div>
                      <div class="size"><?php if ($product['height']){ ?>
                        <span class="units-product"><?php echo $unit_h; ?>:</span> <span><?php echo $product['height'] ?></span><?php } ?><?php if ($product['width']){ ?><span class="units-product"><?php echo $unit_w; ?>:</span> <span><?php echo $product['width'] ?></span><?php } ?> <?php if ($product['height']){ ?><span class="units-product"><?php echo $unit_l; ?>:</span> <span><?php echo $product['length'] ?></span><?php } ?>
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
                          <div class="price-old"><?php echo $product['price'] ?><span class="currency-value"> грн</span></div>
                          <div class="price-new"><?php echo $product['special'] ?><span class="currency-value"> грн</span></div>
                          <?php }else{ ?>
                          <div class="price-regular"><?php echo $product['price'] ?><span class="currency-value"> грн</span></div>
                        <?php } ?>
                          </div>
                      <?php } ?>
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
