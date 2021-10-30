<?php if ($reviews) { ?>
<?php $i=0;foreach ($reviews as $review) { ?>
<div class="item">
                            <div class="photos">
                                <div class="screen"><a data-fancybox="reviews<?php echo $i ?>" href="<?php echo $review['image1']['popup'] ?>"><img src="<?php echo $review['image1']['thumb'] ?>" alt="" /></a></div>
                                <div class="screen"><a data-fancybox="reviews<?php echo $i ?>" href="<?php echo $review['image2']['popup'] ?>"><img src="<?php echo $review['image2']['thumb'] ?>" alt="" /></a></div>
                            </div>
                            <div class="info">
                                <div class="name"><?php echo $review['author'] ?></div>
                                <div class="date"><?php echo $review['date_added'] ?></div>

                                <div class="option">Модель: <b><?php echo $review['model'] ?></b></div>
                                <div class="option">Куда: <b><?php echo $review['dest'] ?></b></div>

                                <div class="text">
                            	    <?php echo $review['text'] ?>
                                </div>
                            </div>
                        </div>
<?php $i++;} ?>
<div class="text-right"><?php echo $pagination; ?></div>
<?php } else { ?>
<p><?php echo $text_no_reviews; ?></p>
<?php } ?>
