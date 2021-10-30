<form id="privatbank_paymentparts_ii_checkout" class="form-inline" style="margin-left: 10px;">  
  <div class="form-group">
  <span class="form-element" id="paymentsCountcart"></span>, на
	<select id="termInput" name="partsCount_ii" style="width:auto;" class="form-control">
	  <?php for($i=1;$i<=$partsCounts;$i++){ ?>
		<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
	  <?php } ?>
    </select> <?php echo $text_mounth; ?> по <span id="ipResultValue">0</span> <span class="result-additional-data-phys"></span>
  <input type="hidden" pattern="\d*" id="priceInput" value="<?php echo $total; ?>">
  </div>
</form>
<div style="margin: 5px 0;display:none;">
	<div id="termSlider">
        <div id="termProgressBar" class="progress progress-striped">
            <div id="termProgress" class="progress-bar progress-bar-success" role="progressbar" style="width: 0;"></div>
        </div>
    </div>
</div>
<script src="catalog/view/javascript/jquery/pp_calculator/calculator.js" type="text/javascript"></script>
<div id="activatescript"></div>
<script>
var curLang="<?php echo $language; ?>"
var constants = {
    'priceMax': 100000,
	'priceInitial': <?php echo $total; ?>,
	'priceInitial2': <?php echo $total; ?>,
    'termMax': <?php echo $partsCounts; ?>,
	'termMax2': <?php echo $partsCounts; ?>,
    'termMin': <?php echo ($partsCountSel ? $partsCountSel : '1'); ?>,
	'termMin2': <?php echo ($partsCountSel ? $partsCountSel : '1'); ?>,
    'termStep': 1,
	'termStep2': 1
};
$('#activatescript').trigger('click');
<?php if ($partsCountSel) { ?>
$("#termInput").val(<?php echo $partsCountSel; ?>).trigger('change');
<?php } ?>
</script>