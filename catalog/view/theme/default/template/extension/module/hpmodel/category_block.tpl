<?php if (!empty($products)) { ?>
<div class="hpm-cat-box" <?php echo !empty($thumb) && !empty($replace_image) ? 'data-thumb="'.$thumb.'"': ''; ?>>
  <?php if (!empty($title)) { ?><div class="hpm-cat-title"><?php echo $title; ?></div><?php } ?>
  <div class="hpm-cat-content">
    <?php foreach ($products as $product) { ?>
    <div class="hpm-cat-item<?php echo $product['product_id'] == $product_id ? ' active' : ''; ?>" data-id="<?php echo $product['product_id']; ?>" data-href="<?php echo $product['href']; ?>" <?php if (!empty($replace_h1)) { ?>data-name="<?php echo $product['name']; ?>"<?php } ?> <?php echo !empty($product['thumb']) && !empty($replace_image) ? 'data-thumb="'.$product['thumb'].'"': ''; ?> <?php echo $product['price'] ? 'data-price="'.$product['price'].'"': ''; ?> <?php echo $product['special'] ? 'data-special="'.$product['special'].'"': ''; ?> data-qty="<?php echo $product['quantity']; ?>">
      <?php foreach ($product['view'] as $column => $value) { ?>
      <div class="hpm-col-<?php echo $column; ?>">
        <?php echo $value; ?>
      </div>
      <?php } ?>
    </div>
    <?php } ?>
  </div>
</div>
<?php } ?>
