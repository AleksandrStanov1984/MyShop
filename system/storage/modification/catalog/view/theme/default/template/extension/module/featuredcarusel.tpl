  <?php if ($heading_title) { ?>
<h3><?php echo $heading_title; ?></h3>
  <?php } ?>
<div id="prodcarousel<?php echo $module; ?>" class="owl-carousel productcarusel view<?php echo $prodview; ?> <?php echo $class; ?>">
  <?php foreach ($products as $product) { ?>
  <div class="item text-center product-layout">
   <div class="product-thumb transition">
      <div class="image"><a href="<?php echo $product['href']; ?>" data-hpm-href="1"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
      <div class="caption">
        <h4><a href="<?php echo $product['href']; ?>" data-hpm-href="1"><?php echo $product['name']; ?></a></h4>
<?php if ($prodview !=1 && $prodview !=2) { ?>
        <p><?php echo $product['description']; ?></p>
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
      </div>
      <div class="button-group">
      <?php if ($prodview !=1 && $prodview !=3) { ?>
        <button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
        <?php } else { ?>
<a href="<?php echo $product['href']; ?>" data-hpm-href="1"><i class="fa fa-arrow-circle-right"></i>
<span class="hidden-xs hidden-sm hidden-md"><?php echo $text_more; ?></span></a>
<?php } ?>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>

      </div>

    </div>
  </div>
  <?php } ?>
</div>
<script type="text/javascript"><!--
$('#prodcarousel<?php echo $module; ?>').owlCarousel({
  items: <?php echo $items; ?>,
  autoPlay: 3000,
  navigation: true,
  navigationText: ['<i class="fa fa-chevron-left fa-5x"></i>', '<i class="fa fa-chevron-right fa-5x"></i>'],
  pagination: false
});
--></script>