<div class="box">
  <div class="box-heading sidemenu-title"><a href="<?php echo $parent_category_href; ?>"><?php echo $parent_category_name; ?></a></div>
  <div class="box-content ">
    <ul class="box-category sidemenu" style="max-height: 255px; overflow: hidden;">
      <?php foreach ($categories as $category) { ?>
      <?php if ($category['category_id'] == $cat_id) { ?>
      <li class="active">
        <?php echo $category['name']; ?>

        <!--<?php if ($category['children']) { ?>
        <ul style="margin-left: 10px">
          <?php foreach ($category['children'] as $child) { ?>
          <li>
            <?php if ($child['category_id'] == $child_id) { ?>
            <a href="<?php echo $child['href']; ?>" class="active"><?php echo $child['name']; ?></a>
            <?php } else { ?>
            <a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
            <?php } ?>
          </li>
          <?php } ?>
        </ul>
        <?php } ?>-->
      </li>
    <?php } else { ?>
      <li>
        <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
        <?php } ?>
      <?php } ?>
    </ul>
  </div>
</div>
<script>
  $(document).ready(function() {
    $('.box-category').mCustomScrollbar({
        theme: 'dark',
    });
  });
</script>
