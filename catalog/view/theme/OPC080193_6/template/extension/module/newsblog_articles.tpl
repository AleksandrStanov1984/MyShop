<section class="latest-news">
    <?php if ($heading_title) { ?>

    <!--seo_text_start-->

    <!--seo_text_end-->

    <h2 class="h2-title tilte-blog-home"><?php echo $heading_title; ?></h2>
    <?php } ?>
    <?php if ($html) { ?>
    <?php echo $html; ?>
    <?php } ?>
    <div class="slick-news">
        <?php foreach ($articles as $article) { ?>
        <div class="news__item">
            <?php if ($article['thumb']) { ?>
            <div class="news__img"><a href="<?php echo $article['href']; ?>"><img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="<?php echo $article['thumb']; ?>" alt="<?php echo $article['name']; ?>" title="<?php echo $article['name']; ?>" class="img-responsive lazy-sz" /></a></div>
            <?php } ?>
            <div class="news__caption">
                <a class="news__title" href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a>
                <div class="news_description">
                    <?php echo $article['preview']; ?></div>
            </div>
            <div class="button-group mr-auto">
                <button onclick="location.href = ('<?php echo $article['href']; ?>');" data-toggle="tooltip" title="<?php echo $text_more; ?>"><span class="news__more"><?php echo $text_more; ?></span></button>
            </div>
        </div>
        <?php } ?>
    </div>

</section>
