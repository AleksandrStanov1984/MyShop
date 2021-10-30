<?php echo $header; ?>
<div class="content_category_lev2">
<div class="wrapper wrapper-wide">
  <div class="all-inline-category hidden-xs hidden-sm">
    <ul class="maincatalog-list-1">
      <!--<li class="maincatalog-menu-item"><a href="#">Все категории</a></li>-->
      <?php foreach($categories as $category) { ?>
      <li class="maincatalog-menu-item <?php echo $category['children'] ? 'item-has-children': ''; ?>" data-menu-id="<?php echo $category['category_id']; ?>"><a class="inline-category-item" href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
      <!--vstavka-sokraschennogo-menu-->
        <?php if($category['children']) { ?>
        <ul class="dropdown-with-children">
          <?php foreach($category['children'] as $key => $child) { ?>
          <li class="">
            <a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
          </li>
          <?php } ?>
        </ul>
        <?php } ?>
        <!--end-vstavka-sokraschennogo-menu-->
      </li>
      <?php } ?>
    </ul>
    <div class="maincatalog-horizont-menu-open">
      <div class="maincatalog-menu-back-2">
        <ul class="maincatalog-list-2">
          <?php foreach($categories as $category) { ?>
          <li class="j-menu-level2-item" data-menu-vertical-id="<?php echo $category['category_id']; ?>">
            <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
          </li>
           <?php } ?>
        </ul>
      </div>
      <?php foreach($categories as $category) { ?>
      <div class="maincatalog-menu-back-3" data-menu-id="<?php echo $category['category_id']; ?>" style="">
        <?php if($category['children']) { ?>
        <div class="j_fiels_submenu" style="margin-left: -15px; margin-right: -15px;">
          <ul class="maincatalog-list-3">
            <?php foreach($category['children'] as $key => $child) { ?>
            <li class="">
              <a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
            </li>
            <?php } ?>
          </ul>
      </div>
      <?php } ?>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
<?php echo $content_top; ?>

<h1></h1>

<div class="wrapper-1180 content-bottom-category"><?php echo $content_bottom; ?></div>
</div>

<!--seo_text_start-->

<!--seo_text_end-->

<?php echo $footer; ?>
