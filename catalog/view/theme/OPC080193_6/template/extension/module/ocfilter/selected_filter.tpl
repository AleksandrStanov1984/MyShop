<?php if ($selecteds) { ?>
<div class="list-group-item selected-options">
  <div class="selected-options-header">
    <div class="ocf-option-name">Выбранный фильтр:</div>
    <?php $count = count($selecteds); $selected = $selecteds; $first = array_shift($selected); ?>
    <?php if ($count > 1 || count($first['values']) > 1) { ?>
    <button type="button" onclick="location = '<?php echo $link; ?>';" class="btn-danger"><?php echo $text_cancel_all; ?></button>
    <?php } ?>
  </div>

  <?php foreach ($selecteds as $option) { ?>
  <div class="selected-options-item">
    <span><?php echo $option['name']; ?>:</span>
    <?php foreach ($option['values'] as $value) { ?>
    <button type="button" onclick="location = '<?php echo $value['href']; ?>';" class="remove_filter-parameter btn-danger"><span><?php echo $value['name']; ?></span><img src="catalog/view/theme/OPC080193_6/images/page_category/remove_red.svg" alt="remove"></button>
    <?php } ?>
  </div>
  <?php } ?>

</div>
<?php } ?>
