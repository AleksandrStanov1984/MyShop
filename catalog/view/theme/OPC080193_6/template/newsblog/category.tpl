<?php echo $header; ?>
<div class="wrapper">
  <div class="breadcrumb">
      <ul class="breadcrumb__list">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li class="breadcrumb__item"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul> 
  </div>
  
  <div class="row">
    <div id="content" class="content col-12">
      <h1 class="h2-title mt-3 mb-4">
        <?php echo $heading_title; ?>
      </h1>
      
      <?php if ($articles) { ?>
        <div class="secton-with-news">
        <?php foreach ($articles as $article) { ?>
        <div class="news__item_on_page_blog">
          <?php if ($article['thumb']) { ?>
            <a class="news__img" href="<?php echo $article['href']; ?>">
              <img src="<?php echo $article['thumb']; ?>" alt="<?php echo $article['name']; ?>" title="<?php echo $article['name']; ?>" class="img-responsive" />
            </a>
          <?php } ?>
            <div class="news__caption_on_page_blog">
              <a class="news__title" href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a>
              <p class="news_description"><?php echo $article['preview']; ?></p>

              <?php if ($article['attributes']) { ?>
                <h5><?php echo $text_attributes;?></h5>
                <?php foreach ($article['attributes'] as $attribute_group) { ?>
                	<?php foreach ($attribute_group['attribute'] as $attribute_item) { ?>
                     	<b><?php echo $attribute_item['name'];?>:</b> <?php echo $attribute_item['text'];?><br />
                	<?php } ?>
                <?php } ?>
              <?php } ?>
              <a class="news__more" href="<?php echo $article['href']; ?>">Читать всю статью</a>
            </div>
        </div>
        <?php } ?>
      </div>
      <div class="row content__footer">
        <div class="col-sm-6 text-left pagination"><?php echo $pagination; ?></div>
      </div>


      <!--seo_text_start-->

      <!--seo_text_end-->


      <?php } ?>

      <?php if (!$categories && !$articles) { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>
      <?php if ($comments_vk) { ?>
      <div class="row">
        <div class="col-md-12">
			<div id="vk_comments"></div>
			<script type="text/javascript">
			VK.init({apiId: <?php echo $comments_vk; ?>, onlyWidgets: true});
			VK.Widgets.Comments("vk_comments", {limit: 10, attach: "*"});
			</script>
        </div>
      </div>
      <?php } ?>

      <?php if ($comments_fb) { ?>
      <div class="row">
        <div class="col-md-12">
            <div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.10";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			<div class="fb-comments" data-href="<?php echo $canonical; ?>" data-width="100%" data-numposts="10"></div>
        </div>
      </div>
      <?php } ?>

      <?php if ($comments_dq) { ?>
      <div class="row">
        <div class="col-md-12">
        	<div id="disqus_thread"></div>
			<script>
			var disqus_config = function () {
				this.page.url = "<?php echo $canonical; ?>";
			};

			(function() { // DON'T EDIT BELOW THIS LINE
			var d = document, s = d.createElement('script');
			s.src = 'https://<?php echo $comments_dq; ?>.disqus.com/embed.js';
			s.setAttribute('data-timestamp', +new Date());
			(d.head || d.body).appendChild(s);
			})();
			</script>
			<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
        </div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>