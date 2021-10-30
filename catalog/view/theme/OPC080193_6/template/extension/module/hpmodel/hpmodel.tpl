<?php if($products) { ?>
<div id="hpmodel" class="form-group">
  <?php if($name_as_title){ ?>
  <div class="hpm-mame lettering_element"><?php echo $title_name;?> <span class="after_title"></span></div>
<?php } ?>
  <div class='hpmodel_type_images text-center'>
    <div class="box_product_hpm">
    <?php foreach($products as &$product) { ?>
    <a href="<?php echo $product['href']; ?>" class='hpm-item hpm-item-<?php echo $product['product_id']; ?> <?php echo $product['product_id'] == $selected_product_id ? 'active' : ''; ?> text-center pull-left thumbnail hidden-of-next<?php echo $product['product_id'];?> <?php if ($product['quantity'] > 0) { echo ' stock-on ';} else { echo ' stock-off ';} ?>'>     
      <?php foreach ($product['view'] as $column => $value) { ?>
      <div class="hpm-col-<?php echo $column; ?>">
        <?php echo $value; ?>
      </div>
      <div class="clearfix top10"></div>
      <?php } ?>
    </a>
    <?php } ?>
  </div></div>
</div>
<?php echo $config; ?>

<?php if ($custom_css) { ?><style><?php echo $custom_css; ?></style><?php } ?>
<?php if ($custom_js) { ?><script><?php echo $custom_js; ?></script><?php } ?>
<?php } ?>
<script>
  $(document).ready(function(){
    $('#hpmodel').show();
  });
