<div id="addcredit-popup" class="white-popup mfp-with-anim">
<?php if ($status_pp && $status_ii) { ?>
<?php $class = 'col-sm-6'; ?>
<?php } elseif ($status_pp || $status_ii) { ?>
<?php $class = 'col-sm-12'; ?>
<?php } else { ?>
<?php $class = 'hidden'; ?>
<?php } ?>
<link href="catalog/view/javascript/jquery/pp_calculator/calculator.css" rel="stylesheet" type="text/css">
	<div class="container" style="width:100%;">
                <div id="countedResults">
                    <div class="row">
                        <form class="result <?php echo $class; ?>" id="ppResult" <?php echo ($status_pp?'':'style="display:none"') ?>>
                            <div class="logo">
                                <img class="centered" src="catalog/view/javascript/jquery/pp_calculator/img/pp_logo.png"/><span id="ppTitle" class="text-center bold"></span>
								<div id="controlElements">
									<div id="term" class="control-element">
										<div class="row">
											<div class="col-xs-2 text-center">
												<div class="additional-data form-element"></div>
												<div class="payments form-element"></div>
											</div>
											<div class="col-xs-4">
												<select id="termInput2" name="selectpp" class="form-control">
												 <?php for($i=1;$i<=$partsCountpp;$i++){ ?>
												  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
												 <?php } ?>
												</select>
												<div class="form-element" id="paymentsCount2"></div>
											</div>
										</div>
									</div>
								</div>
								<div id="termSlider2">
                                    <div id="termProgressBar" class="progress progress-striped">
                                        <div id="termProgress2" class="progress-bar progress-bar-success" role="progressbar" style="width: 0;"></div>
                                    </div>
                                </div>
                                <span class="ppcost"></span>
								<input type="text" class="form-control text-center numeric-input"
                                id="priceInput2" value="<?php echo round($total*$markuppp); ?>">
                            </div>
                            <div class="result-holder holder-phys">
                                <span></span>
                                <div class="result-data">
                                    <div class="result-value bold" id="ppResultValue">0</div>
                                </div>
                                <div class="result-additional-data-phys"></div>
								<input id="privat_type-button" type="submit" value="<?php echo $button_continue; ?>" class="btn btn-lg btn-block btn-success" />
                            </div>
                        </form>
                        <form class="result <?php echo $class; ?>" id="ipResult" <?php echo ($status_ii?'':'style="display:none"') ?>>
                            <div class="logo">
                                <img class="centered" src="catalog/view/javascript/jquery/pp_calculator/img/ip_logo.png"/><span id="ipTitle" class="text-center bold"></span>
								<div id="controlElements">
									<div id="term2" class="control-element">
										<div class="row">
											<div class="col-xs-2 text-center">
												<div class="additional-data2 form-element"></div>
												<div class="payments form-element"></div>
											</div>
											<div class="col-xs-4">
												<select id="termInput" name="selectii" class="form-control">
												 <?php for($i=1;$i<=$partsCountii;$i++){ ?>
												  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
												 <?php } ?>
												</select>
												<div class="form-element" id="paymentsCount"></div>
											</div>
										</div>
									</div>
								</div>
								<div id="termSlider">
                                    <div id="termProgressBar" class="progress progress-striped">
                                        <div id="termProgress" class="progress-bar progress-bar-success" role="progressbar" style="width: 0;"></div>
                                    </div>
                                </div>
                                <span class="ppcost"></span>
								<input type="text" class="form-control text-center numeric-input"
                                id="priceInput" value="<?php echo round($total*$markupii); ?>">
                            </div>
                            <div class="result-holder holder-phys">
								<span></span>
                                <div class="result-data">
                                    <div class="result-value bold" id="ipResultValue">0</div>
                                </div>
                                <div class="result-additional-data-phys"></div>
								<input id="privat_type-button2" type="submit" value="<?php echo $button_continue; ?>" class="btn btn-lg btn-block btn-success" />
                            </div>
                        </form>
                    </div>
                </div>
    </div>
	<div class="pr_info text-center"><?php echo $credit_text; ?></div>
	<div id="activatescript"></div>
<script type="text/javascript" src="catalog/view/javascript/jquery/pp_calculator/calculator.js"></script>
<script>
var curLang="<?php echo $language; ?>"
var constants = {
    'priceMax': 100000,
	'priceInitial': <?php echo round($total*$markupii, 2); ?>,
	'priceInitial2': <?php echo round($total*$markuppp, 2); ?>,
    'termMax': <?php echo $partsCountii; ?>,
    'termMin': 1,
    'termStep': 1,
	'termMax2': <?php echo $partsCountpp; ?>,
    'termMin2': 1,
    'termStep2': 1
};		
$('#activatescript').trigger('click');
</script>
<script type="text/javascript">
    $("#ppResult").submit(function(){
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
			dataType: 'json',
			beforeSend: function() {
				$('#privat_type-button').attr('disabled', true);
			},			
			success: function(json) {
				if (json['success']) {
					$('#cart-total').html(json['total']);
				}	
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}	
		});	
	
        var error = false;
        partsCounArr = {partsCount: $('#termInput2').val()};        
        $.ajax({
            type: 'POST',
            url: 'index.php?route=extension/payment/privatbank_paymentparts_pp/setPrivatType',
            dataType: 'json',
            data: partsCounArr,
			success: function(json) {
				if (json['redirect']) {
					location = json['redirect'];
				}   
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}		     
        });
        return false;    
    });
	
    $("#ipResult").submit(function(){
		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
			dataType: 'json',
			beforeSend: function() {
				$('#privat_type-button2').attr('disabled', true);
			},			
			success: function(json) {
				if (json['success']) {
					$('#cart-total').html(json['total']);
				}	
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}	
		});	
		
        var error = false;
        partsCounArr = {partsCount: $('#termInput').val()};        
        $.ajax({
            type: 'POST',
            url: 'index.php?route=extension/payment/privatbank_paymentparts_ii/setPrivatType',
            dataType: 'json',
            data: partsCounArr,
			success: function(json) {
				if (json['redirect']) {
					location = json['redirect'];
				}   
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}		     
        });
        return false;    
    });
</script>
</div>