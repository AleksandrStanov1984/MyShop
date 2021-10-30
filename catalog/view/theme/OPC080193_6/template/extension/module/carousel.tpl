<section class="block-reviews">
    <div class="wrapper">
	<h2 class="h2-title"><?php echo $text_reviews; ?></h2>
	<div class="title-link"><a href="#">Читати відгуки у соц-мережах</a></div>
	
	<div class="slider-reviews">
	    <?php foreach ($banners as $banner) { ?>
	    <div>
		<div class="item"><img src="<?php echo $banner['image']; ?>" alt="" /></div>
	    </div>
	    <?php } ?>
	</div>
    </div>
</section>

<?php /*<div id="carousel-<?php echo $module; ?>" class="banners-slider-carousel">
	<div class="customNavigation">
		<a class="prev fa fa-angle-left">&nbsp;</a>
		<a class="next fa fa-angle-right">&nbsp;</a>
	</div>
  <div class="product-carousel" id="module-<?php echo $module; ?>-carousel">
    <?php foreach ($banners as $banner) { ?>
    	<div class="slider-item">
		<div class="product-block">
		<div class="product-block-inner">
			<?php if ($banner['link']) { ?>
   <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" /></a>
    <?php } else { ?>
    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
    <?php } ?>
		</div></div></div>
    <?php } ?>
  </div>
</div>
<span class="module_default_width" style="display:none; visibility:hidden"></span>*/?>