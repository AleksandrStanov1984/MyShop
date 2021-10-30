<div class="pull-right">
  <form id="privatbank_paymentparts_pp_checkout" role="form" class="form-inline">
    <div class="form-group">
      <label for="partsCount_pp"><?php echo $text_label_partsCount; ?></label>
	  <span class="form-element" id="paymentsCount2cart"></span>, на
      <select id="termInput2" name="partsCount_pp" class="form-control">
		<?php for($i=1;$i<=$partsCounts;$i++){ ?>
		<option><?php echo $i; ?></option>
		<?php } ?>
      </select> <?php echo $text_mounth; ?> по <span id="ppResultValue">0</span> <span class="result-additional-data-phys"></span>
	  <input type="hidden" pattern="\d*" id="priceInput2" value="<?php echo $total; ?>">
    </div>
	<div class="buttons">
	  <div class="pull-right">
		<input type="submit" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" data-loading-text="<?php echo $text_loading; ?>" />
	  </div>
	</div>
  </form>
</div> 
<div id="activatescript"></div>
<script type="text/javascript" src="catalog/view/javascript/jquery/pp_calculator/calculator.js"></script>
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
$("#termInput2").val(<?php echo $partsCountSel; ?>).trigger('change');
<?php } ?>
</script>
<script type="text/javascript">
$(document).ready(function(){
	if (window.location.href.indexOf("simple") > -1) { 
		$('#privatbank_paymentparts_pp_checkout .btn-group').hide();
		$('#privatbank_paymentparts_pp_checkout .form-group').hide(); 
	}
    $("#privatbank_paymentparts_pp_checkout").submit(function(){
        var error = false;
        partsCounArr = {partsCount: parseInt($('#termInput2').val())+1};       
        
        $.ajax({
            type: 'POST',
            url: '<?php echo $action; ?>',
            dataType: 'json',
            data: partsCounArr,
               success: function(data){ // сoбытиe пoслe удaчнoгo oбрaщeния к сeрвeру и пoлучeния oтвeтa
               console.log(data['state']);
                    switch(data['state']){
                        case 'SUCCESS':
                            window.location = 'https://payparts2.privatbank.ua/ipp/v2/payment?token='+data['token'];
                            break;
                        case 'FAIL':
                            $('#privatbank_paymentparts_pp_checkout').prepend('<div class="alert alert-warning">' + data['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
							$('.simplecheckout-button-block').prepend('<div class="alert alert-warning">' + data['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                          break;
                        case 'sys_error':
                            $('#privatbank_paymentparts_pp_checkout').prepend('<div class="alert alert-warning">' + data['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');                                          
							$('.simplecheckout-button-block').prepend('<div class="alert alert-warning">' + data['message'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                        break;
                    }                               
               }
        });
        
        return false;    
    });    
});    
</script>
