<?php echo $header; ?>
<div class="wrapper">
    <!--<div class="breadcrumb">
  <ul class="breadcrumb__list">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li class="breadcrumb__item"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
      <?php } ?>
    </ul>
  </div>-->
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row account-box account-box-wishlist"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <?php if ($products) { ?>
        <div style="margin-bottom: 15px">
          <h1 class="title-page-wishlist"><?php echo $heading_title; ?></h1>
              <?php if(!$loged) { ?>
            <div class="hidden-sm hidden-md hidden-lg">
                <p class="info-save-wishlist"><?php echo $info_save_wishlist; ?></p>
            </div>

              <a href="<?php echo $login_link; ?>" title="<?php echo $text_btn_save_wishlist; ?>" class="btn-save-wishlist"><?php echo $text_btn_save_wishlist; ?></a>
            <?php } ?>
            <div class="clear"></div>
            <div class="row wishlist-product">
              <?php foreach ($products as $product) { ?>
              <div class="product-layout col-wishlist col-xl-3 col-lg-3 col-md-4 col-sm-4 col-6">
                <div class="item" <?php echo $product['quantity'] == 0 || $product['stock_status_id'] == 5 ? 'style="opacity: 0.5"' : ''; ?>>
                  <button class="remove-in-wishlist" onclick="wishlist.remove_p('<?php echo $product['product_id']; ?>');" data-href="<?php echo $product['remove']; ?>" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"></button>
                  <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" class="img-responsive" title="<?php echo $product['name']; ?>"/></a></div>
                    <a class="name" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                    <div class="all-info-product">
                      <div class="size">
                        <?php if ($product['height']){ ?>
                        <span class="units-product"><?php echo $unit_h; ?>:</span> <?php echo $product['height'] ?><?php } ?><?php if ($product['width']){ ?> <span class="units-product"> <?php echo $unit_w; ?>:</span> <?php echo $product['width'] ?><?php } ?> <?php if ($product['height']){ ?><span class="units-product"> <?php echo $unit_l; ?>:</span> <?php echo $product['length'] ?><?php } ?>
                          <?php if ($product['diameter_of_pot']){ ?>
                            <img src="catalog/view/theme/OPC080193_6/images/diameter_of_pot.svg" class="img-diameter-of-pot img-icon-pot" alt="diameter"> <?php echo $product['diameter_of_pot'];?> <?php echo $unit; ?> <?php } ?><?php if ($product['depth_of_pot']){ ?> <img src="catalog/view/theme/OPC080193_6/images/depth_of_pot.svg" class="img-depth-of-pot img-icon-pot" alt="depth"><?php echo $product['depth_of_pot'];?> <?php echo $unit; ?><?php } ?>
                      </div>
                      <!--<a class="model" href="<?php echo $product['href'] ?>"><b><?php echo $product['model'] ?></b></a>-->
                      <div class="product-panel">
                        <?php if ($product['price']) { ?>
                        <div class="price">
                          <?php if ($product['special']) { ?>
                          <div class="price-old"><?php echo $product['price'] ?></div>
                            <div class="price-new"><?php echo $product['special'] ?></div>
                          <?php } else { ?>
                            <div class="price-regular"><?php echo $product['price'] ?></div>
                          <?php } ?>
                        </div>
                        <?php } ?>
                        <div class="button">
                          <a href="javascript:void(0);" <?php if($product['quantity'] > 0){ ?>onclick="cart.add('<?php echo $product['product_id']; ?>');" data-toggle="tooltip" class="btn-buy" title="<?php echo $button_cart; ?><?php }else{?>class="btn-buy btn-off" <?php }?> " ><img src="catalog/view/theme/OPC080193_6/images/cart-with-wheels.svg" alt="add cart"><span class="btn-buy-text"><?php echo $button_cart; ?></span></a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php if($product['quantity'] < 1){ ?>
                  <div class="popup-outstock"><?php echo $text_stock_out; ?><a href="<?php echo $product['category_url'] ?>"><?php echo $text_look_alike; ?></a>
                    <svg class="hidden-lg hidden-md hidden-sm" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.2" d="M13.5483 11.3442C14.1506 11.9508 14.1506 12.9374 13.5483 13.5445C12.9508 14.1459 11.9713 14.1558 11.3639 13.5445L7.05173 9.19931L2.63607 13.5451C2.03386 14.1516 1.05437 14.1516 0.451654 13.5451C-0.150551 12.9385 -0.150551 11.9518 0.451654 11.3447L4.76489 7L0.451654 2.6553C-0.150551 2.04818 -0.150551 1.06155 0.451654 0.45495C1.05437 -0.151649 2.03386 -0.151649 2.63607 0.45495L7.05173 4.80069L11.3639 0.45495C11.9651 -0.150613 12.9446 -0.152686 13.5483 0.45495C14.1506 1.06155 14.1506 2.04818 13.5483 2.6553L9.23511 7L13.5483 11.3442Z" fill="#333333"/>
                    </svg>
                  </div>
                  <?php } ?>
                </div>
                <?php } ?>
              <?php if(count($products) > 12){ ?>
              <div class='clear'></div>
              <div class="load-all-wishlist " onclick=""><img src="catalog/view/theme/OPC080193_6/images/reload-wishlist.svg" alt="load"><?php echo $load_all_wishlist; ?></div>
              <?php } ?>
              </div>
            </div>
            <?php if(!$loged) { ?>
              <p class="info-save-wishlist hidden-xs"><?php echo $info_save_wishlist; ?></p>
            <?php } ?>
<script>
  $(document).ready(function(){
    $('.load-all-wishlist').click(function(){
      $('.account-box-wishlist .product-layout').css('display', 'block');
      $(this).addClass('hidden');
    });
})
</script>
      <?php } else { ?>
        <div>
            <h1 class="title-page-wishlist"><?php echo $heading_title; ?></h1>
            <div class="clear"></div>
            <p class="text-empty-wishlist"><?php echo $text_empty; ?></p>
    <?php echo $content_bottom; ?></div>
      <?php } ?>
      <input id="text-empty" type="hidden" value="<?php echo $text_empty; ?>">
      <!--<div class="buttons clearfix buttons-wishlist">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary wishlist-continue"><?php echo $button_continue; ?></a></div>
      </div>-->
      </div>
    <?php echo $column_right; ?></div>
</div>
<script>
  $(document).ready(function(){
    $('.popup-outstock svg').click(function(){
      $(this).parents('.popup-outstock').removeClass('active');
    });
    $('.btn-off').mouseenter(function(){
      $(this).parents('.col-wishlist').find('.popup-outstock').addClass('active');
    });
  $('.col-wishlist').mouseleave(function(){
    $(this).find('.popup-outstock').removeClass('active');
  });
  })
</script>
<?php echo $footer; ?>
