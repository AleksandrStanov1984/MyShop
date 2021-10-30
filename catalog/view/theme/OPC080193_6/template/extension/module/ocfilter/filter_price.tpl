<?php if ($show_price) { ?>
<div class="ocfilter-option list-group-item ocfilter-option-price">
  <div class="form-inline block-price-ocfilter">
    <div class="ocf-option-name"> <?php echo $text_price; ?>:</div>
    <div class="envelop-inputs_price">
      <div class="form-group input-price-ocfitler">
        <input name="price[min]" value="<?php echo $min_price_get; ?>" type="text" class="form-control input-sm price" id="min-price-value" />
      </div>
      <div class="form-group tire-price-ocfilter" style="
      display: inline-block;"></div>
      <div class="form-group input-price-ocfitler">
        <input name="price[max]" value="<?php echo $max_price_get; ?>" type="text" class="form-control input-sm price" id="max-price-value" />
      </div>
      <div id="ocfilter-button-price">
        <button class="btn-main btn-ok-price disabled">Ок</button>
      </div>
    </div>

  </div>
  <div class="ocf-option-name ocf-option-name-price">
    Сумма:&nbsp;<?php echo $symbol_left; ?>
    <span id="price-from"><?php echo $min_price_get; ?></span>&nbsp;-&nbsp;<span id="price-to"><?php echo $max_price_get; ?></span><?php echo $symbol_right; ?>
  </div>

  <div class="ocf-option-values">
    <div id="scale-price" class="scale ocf-target" data-option-id="p"
      data-start-min="<?php echo $min_price_get; ?>"
      data-start-max="<?php echo $max_price_get; ?>"
      data-range-min="<?php echo $min_price; ?>"
      data-range-max="<?php echo $max_price; ?>"
      data-element-min="#price-from"
      data-element-max="#price-to"
      data-control-min="#min-price-value"
      data-control-max="#max-price-value"
    ></div>
  </div>
</div>
<?php } ?>
