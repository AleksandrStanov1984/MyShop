<div class="features-new-block">
<div class="title-feature-carousel"><?php echo $heading_title; ?></div>
  <div class="feature-carousel">
    <?php foreach ($products as $product) { ?>
    <div class="item">

      <div class="image"><a href="<?php echo $product['href']; ?>"><img  src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $product['thumb']; ?>" class="lazy-sz" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
      <a class="name" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
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
          <div class="price-old"><?php echo $product['price'] ?></div>
            <div class="price-new"><?php echo $product['special'] ?></div>
            <?php }else{ ?>
            <div class="price-regular"><?php echo $product['price'] ?></div>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
    </div>
    </div>

  <?php } ?>
</div>



</div>
<script>
  $(document).ready(function(){
    $('.feature-carousel').not('.slick-initialized').slick({
            slidesToShow: 5,
            responsive: [
                {
                    breakpoint: 1360,
                    settings: {
                        slidesToShow: 4,
                    }
                },
                 {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 700,
                    settings: {
                        slidesToShow: 2,
                        arrows: true,
                        dots: false,
                    }
                },
                /*{
                    breakpoint: 500,
                    settings: {
                        slidesToShow: 1,
                        arrows: true,
                        dots: false,
                    }
                },*/
            ]
        });
        $('.slider-products').slick('setPosition');

  })
</script>
