<?php echo $header; ?>
<?php if(isset($microdata_breadcrumbs) && $microdata_breadcrumbs) echo $microdata_breadcrumbs; ?>
<div class="wrapper ">
  <div class="row site-map"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1 class="site-map_title"><?php echo $heading_title; ?></h1>
        <div>
          <ul>
            <li class="link_home link_level_1"><a class="" href="<?php echo $link_home; ?>"><?php echo $text_home; ?></a></li>
            <?php foreach ($categories as $category_1) { ?>
            <li class="level1 link_level_1"><a class="" href="<?php echo $category_1['href']; ?>"><?php echo $category_1['name']; ?></a>
              <?php if ($category_1['children']) { ?>
              <ul class="row row_level_2">
                <?php foreach ($category_1['children'] as $key => $category_2) { ?>
                <li class="col-md-4 col-xl-3 link_level_2"><a class="" href="<?php echo $category_2['href']; ?>"><?php echo  $key+1 .'. '.$category_2['name']; ?></a>
                  <?php if ($category_2['children']) { ?>
                  <ul class="list_level_3">
                    <?php foreach ($category_2['children'] as $category_3) { ?>
                    <li class="link_level_3"><a  href="<?php echo $category_3['href']; ?>"><?php echo $category_3['name']; ?></a></li>
                    <?php } ?>
                  </ul>
                  <?php } ?>
                </li>
                <?php } ?>
              </ul>
              <?php } ?>
            </li>
            <?php } ?>
          </ul>
        </div>
        <!--<div class="col-sm-6 sitemap-right">
          <ul>
            <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
            <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a>
              <ul>
                <li><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
                <li><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
                <li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
                <li><a href="<?php echo $history; ?>"><?php echo $text_history; ?></a></li>
                <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
              </ul>
            </li>
            <li><a href="<?php echo $cart; ?>"><?php echo $text_cart; ?></a></li>
            <li><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></li>
            <li><a href="<?php echo $search; ?>"><?php echo $text_search; ?></a></li>
            <?php foreach ($newsblog_categories as $category) { ?>
            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
              <?php if ($category['children']) { ?>
              <ul>
                <?php foreach ($category['children'] as $article) { ?>
                <li><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></li>
                <?php } ?>
              </ul>
              <?php } ?>
            </li>
            <?php } ?>
            <li><?php echo $text_information; ?>
              <ul>
                <?php foreach ($informations as $information) { ?>
                <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
                <?php } ?>
                <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
              </ul>
            </li>
          </ul>
        </div>-->

      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
