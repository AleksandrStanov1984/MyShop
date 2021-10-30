<div class="home__banner home__slider">
    <?php foreach ($banners as $key => $banner) { ?>
    <?php if($banner['link']) { ?>
    <div class="item-slick">
        <img <?php echo $key==0 ? 'src': 'data-lazy'; ?>="<?php echo $banner['image']; ?>" class="img-responsive home_slider_item small-image-zoom" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
        <a href="<?php echo $banner['link']; ?>" class="item-slick-a">
        </a></div>
    <?php } else { ?>
    <div class="item-slick">
        <img <?php echo $key==0 ? 'src': 'data-lazy'; ?>="<?php echo $banner['image']; ?>" class="img-responsive home_slider_without_a small-image-zoom" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>">
    </div>
    <?php } ?>

    <?php } ?>
</div>
