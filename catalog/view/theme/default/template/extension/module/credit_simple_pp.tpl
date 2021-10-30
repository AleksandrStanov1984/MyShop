<form id="privatbank_paymentparts_pp_checkout" class="form-inline" style="margin-left: 10px;">  
  <div class="form-group">
  <span class="form-element" id="paymentsCount2cart"></span>, на
    <select id="termInput2" name="partsCount_pp" style="width:auto;" class="form-control">
	  <?php for($i=1;$i<=$partsCounts;$i++){ ?>
		<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
	  <?php } ?>
    </select> <?php echo $text_mounth; ?> по <span id="ppResultValue">0</span> <span class="result-additional-data-phys"></span>
  <input type="hidden" pattern="\d*" id="priceInput2" value="<?php echo $total; ?>">
  </div>
</form>
<div style="margin: 5px 0;display:none;">
	<div id="termSlider2">
        <div id="termProgressBar" class="progress progress-striped">
            <div id="termProgress2" class="progress-bar progress-bar-success" role="progressbar" style="width: 0;"></div>
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
$('#termInput2').val(<?php echo $partsCountSel; ?>).trigger('change');
<?php } ?>
</script>