<div class="categories hidden-lg hidden-md">
    <div class="category-wall-heading-title"><?php echo $heading_title; ?></div>
        <div class="categories__wrap owl-carousel">
            <?php foreach ($categories as $key => $category) { ?>
            <?php if($key < 3) { ?>
            <div class="categories__item item">
                <a href="<?php echo $category['href']; ?>" class="categories__Link">
                    <img class="categories__image img-responsive" src="<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>" title="<?php echo $category['name']; ?>" />
                    <div class="category-wall-title categories__title"><?php echo $category['name']; ?></div>
                </a>
            </div>
            <?php }else{ ?>
                 <div class="categories__item item">
                    <a href="<?php echo $category['href']; ?>" class="categories__Link">
                    <img class="categories__image img-responsive lazy-sz" src="image/loader-gray.gif" data-src="<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>" title="<?php echo $category['name']; ?>" />

                    <div class="category-wall-title categories__title"><?php echo $category['name']; ?></div>
                </a>
            </div>
            <?php } ?>
            <?php } ?>
        </div>
    </div>
