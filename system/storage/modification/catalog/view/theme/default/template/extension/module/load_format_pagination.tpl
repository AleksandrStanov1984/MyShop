<?php foreach ($products as $product) { ?>
<?php if( strcasecmp($display, 'grid') == 0 && $cols == 2) { ?>
<div class="product-layout product-<?= $display; ?> col-lg-6 col-md-6 col-sm-12 col-xs-12"> <?php }
elseif( strcasecmp($display, 'grid') == 0 && $cols == 1) { ?>
<div class="product-layout product-<?= $display; ?> col-lg-4 col-md-4 col-sm-6 col-xs-12"> <?php }
elseif( strcasecmp($display, 'grid') == 0 && $cols != 1 && $cols != 2) { ?>
<div class="product-layout product-<?= $display; ?> col-lg-3 col-md-3 col-sm-6 col-xs-12"> <?php } ?>
<?php if( strcasecmp($display, 'list') == 0 ) { ?>
<div class="product-layout product-<?= $display; ?> col-xs-12"> <?php } ?>
  <div class="product-thumb">
    <div class="image"><a href="<?php echo $product['href']; ?>" data-hpm-href="1"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
    <div>
      <div class="caption">
        <h4><a href="<?php echo $product['href']; ?>" data-hpm-href="1"><?php echo $product['name']; ?></a></h4>
        <p><?php echo $product['description']; ?></p>
        <?php if ($product['price']) { ?>
        <p class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
          <?php } ?>
          <?php if ($product['tax']) { ?>
          <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
          <?php } ?>
        </p>
        <?php } ?>
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
      </div>
      <div class="button-group">
        <button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
      </div>
    </div>
  </div>
</div>
<?php } ?>