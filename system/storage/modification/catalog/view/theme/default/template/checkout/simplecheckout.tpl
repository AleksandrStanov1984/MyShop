<?php if (!$ajax && !$popup && !$as_module) { ?>
<?php
$simple_page = 'simplecheckout';
$heading_title .= $display_weight ? '&nbsp;(<span id="weight">'. $weight . '</span>)' : '';
include $simple_header;
?>
<style>
    <?php if ($left_column_width) { ?>
        .simplecheckout-left-column {
            width: <?php echo $left_column_width ?>%;
        }
        @media only screen and (max-width:1024px) {
            .simplecheckout-left-column {
                width: 100%;
            }
        }
    <?php } ?>
    <?php if ($right_column_width) { ?>
        .simplecheckout-right-column {
            width: <?php echo $right_column_width ?>%;
        }
        @media only screen and (max-width:1024px) {
            .simplecheckout-right-column {
                width: 100%;
            }
        }
    <?php } ?>
    <?php if ($customer_with_payment_address) { ?>
        #simplecheckout_customer {
            margin-bottom: 0;
        }
        #simplecheckout_customer .simplecheckout-block-content {
            border-bottom-width: 0;
            padding-bottom: 0;
        }
        #simplecheckout_payment_address div.checkout-heading {
            display: none;
        }
        #simplecheckout_payment_address .simplecheckout-block-content {
            border-top-width: 0;
            padding-top: 0;
        }
    <?php } ?>
    <?php if ($customer_with_shipping_address) { ?>
        #simplecheckout_customer {
            margin-bottom: 0;
        }
        #simplecheckout_customer .simplecheckout-block-content {
            border-bottom-width: 0;
            padding-bottom: 0;
        }
        #simplecheckout_shipping_address div.checkout-heading {
            display: none;
        }
        #simplecheckout_shipping_address .simplecheckout-block-content {
            border-top-width: 0;
            padding-top: 0;
        }
    <?php } ?>
</style>
<div class="simple-content">
<?php } ?>
    <?php if (!$ajax || ($ajax && $popup)) { ?>
    <script type="text/javascript">
        var startSimpleInterval_<?php echo $group ?> = window.setInterval(function(){
            if (typeof jQuery !== 'undefined' && typeof Simplecheckout === "function" && jQuery.isReady) {
                window.clearInterval(startSimpleInterval_<?php echo $group ?>);

                window.simplecheckout_<?php echo $group ?> = new Simplecheckout({
                    mainRoute: "checkout/simplecheckout",
                    additionalParams: "<?php echo $additional_params ?>",
                    additionalPath: "<?php echo $additional_path ?>",
                    mainUrl: "<?php echo $action; ?>",
                    mainContainer: "#simplecheckout_form_<?php echo $group ?>",
                    currentTheme: "<?php echo $current_theme ?>",
                    loginBoxBefore: "<?php echo $login_type == 'flat' ? '#simplecheckout_customer .simplecheckout-block-content:first' : '' ?>",
                    displayProceedText: <?php echo $display_proceed_text ? 1 : 0 ?>,
                    scrollToError: <?php echo $scroll_to_error ? 1 : 0 ?>,
                    scrollToPaymentForm: <?php echo $scroll_to_payment_form ? 1 : 0 ?>,
                    notificationDefault: <?php echo $notification_default ? 1 : 0 ?>,
                    notificationToasts: <?php echo $notification_toasts ? 1 : 0 ?>,
                    notificationCheckForm: <?php echo $notification_check_form ? 1 : 0 ?>,
                    notificationCheckFormText: "<?php echo $notification_check_form_text ?>",
                    useAutocomplete: <?php echo $use_autocomplete ? 1 : 0 ?>,
                    useGoogleApi: <?php echo $use_google_api ? 1 : 0 ?>,
                    useStorage: <?php echo $use_storage ? 1 : 0 ?>,
                    popup: <?php echo ($popup || $as_module) ? 1 : 0 ?>,
                    agreementCheckboxStep: <?php echo $agreement_checkbox_step ? $agreement_checkbox_step : '0' ?>,
                    enableAutoReloaingOfPaymentFrom: <?php echo $enable_reloading_of_payment_form ? 1 : 0 ?>,
                    javascriptCallback: function() {try{<?php echo $javascript_callback ?>} catch (e) {console.log(e)}},
                    stepButtons: <?php echo $step_buttons ?>,
                    menuType: <?php echo $menu_type ? $menu_type : '1' ?>
                });

                if (typeof toastr !== 'undefined') {
                    toastr.options.positionClass = "<?php echo $notification_position ? $notification_position : 'toast-top-right' ?>";
                    toastr.options.timeOut = "<?php echo $notification_timeout ? $notification_timeout : '5000' ?>";
                    toastr.options.progressBar = true;
                }

                jQuery(document).ajaxComplete(function(e, xhr, settings) {
                    if (settings.url.indexOf("route=module/cart&remove") > 0 || (settings.url.indexOf("route=module/cart") > 0 && settings.type == "POST") || settings.url.indexOf("route=checkout/cart/add") > 0 || settings.url.indexOf("route=checkout/cart/remove") > 0) {
                        window.resetSimpleQuantity = true;
                        simplecheckout_<?php echo $group ?>.reloadAll();
                    }
                });

                jQuery(document).ajaxSend(function(e, xhr, settings) {
                    if (settings.url.indexOf("checkout/simplecheckout&group") > 0 && typeof window.resetSimpleQuantity !== "undefined" && window.resetSimpleQuantity) {
                        settings.data = settings.data.replace(/quantity.+?&/g,"");
                        window.resetSimpleQuantity = false;
                    }
                });

                simplecheckout_<?php echo $group ?>.init();
            }
        },0);
    </script>
    <?php } ?>
    <div id="simplecheckout_form_<?php echo $group ?>" <?php echo $display_error && $has_error ? 'data-error="true"' : '' ?> <?php echo $logged ? 'data-logged="true"' : '' ?>>
        <div class="simplecheckout">
            <?php if (!$cart_empty) { ?>
                <?php if ($steps_count > 1) { ?>
                    <?php if ($menu_type == '2') { ?>
                        <div id="simplecheckout_step_menu" class="simplecheckout-vertical-menu simplecheckout-top-menu">
                            <?php for ($i=1;$i<=$steps_count;$i++) { ?>
                                <div class="checkout-heading simple-step-vertical" style="display:none" data-onclick="gotoStep" data-step="<?php echo $i; ?>"><h4 class="panel-title"><?php echo $step_names[$i-1] ?></h4></div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div id="simplecheckout_step_menu">
                            <?php for ($i=1;$i<=$steps_count;$i++) { ?><span class="simple-step" data-onclick="gotoStep" data-step="<?php echo $i; ?>"><?php echo $step_names[$i-1] ?></span><?php if ($i < $steps_count) { ?><span class="simple-step-delimiter" data-step="<?php echo $i+1; ?>"><img src="<?php echo $additional_path ?>catalog/view/image/next_gray.png"></span><?php } ?><?php } ?>
                        </div>
                    <?php } ?>
                <?php } ?>

                <?php if ($steps_count > 1 && $menu_type == '2') { ?>
                    <div class="simplecheckout-steps-wrapper">
                <?php } ?>

                <?php
                    $replace = array(
                        '{three_column}'     => '<div class="simplecheckout-three-column">',
                        '{/three_column}'    => '</div>',
                        '{left_column}'      => '<div class="simplecheckout-left-column">',
                        '{/left_column}'     => '</div>',
                        '{right_column}'     => '<div class="simplecheckout-right-column">',
                        '{/right_column}'    => '</div>',
                        '{step}'             => '<div class="simplecheckout-step">',
                        '{/step}'            => '</div>',
                        '{clear_both}'       => '<div style="width:100%;clear:both;height:1px"></div>',
                        '{customer}'         => $simple_blocks['customer'],
                        '{payment_address}'  => $simple_blocks['payment_address'],
                        '{shipping_address}' => $simple_blocks['shipping_address'],
                        '{cart}'             => $simple_blocks['cart'],
                        '{shipping}'         => $simple_blocks['shipping'],
                        '{payment}'          => $simple_blocks['payment'],
                        '{agreement}'        => $simple_blocks['agreement'],
                        '{help}'             => $simple_blocks['help'],
                        '{summary}'          => $simple_blocks['summary'],
                        '{comment}'          => $simple_blocks['comment'],
                        '{payment_form}'     => '<div class="simplecheckout-block" id="simplecheckout_payment_form">'.$simple_blocks['payment_form'].'</div>'
                    );

                    $find = array(
                        '{three_column}',
                        '{/three_column}',
                        '{left_column}',
                        '{/left_column}',
                        '{right_column}',
                        '{/right_column}',
                        '{step}',
                        '{/step}',
                        '{clear_both}',
                        '{customer}',
                        '{payment_address}',
                        '{shipping_address}',
                        '{cart}',
                        '{shipping}',
                        '{payment}',
                        '{agreement}',
                        '{help}',
                        '{summary}',
                        '{comment}',
                        '{payment_form}'
                    );

                    foreach ($simple_blocks as $key => $value) {
                        $key_clear = $key;
                        $key = '{'.$key.'}';
                        if (!array_key_exists($key, $replace)) {
                            $find[] = $key;
                            $replace[$key] = '<div class="simplecheckout-block" id="'.$key_clear.'">'.$value.'</div>';
                        }
                    }

                    echo trim(str_replace($find, $replace, $simple_template));
                ?>
                <div id="simplecheckout_bottom" style="width:100%;height:1px;clear:both;"></div>
                <div class="simplecheckout-proceed-payment" id="simplecheckout_proceed_payment"><?php echo $text_proceed_payment ?></div>
               
                <?php if ($display_agreement_checkbox) { ?>
                    <div class="alert alert-danger simplecheckout-warning-block" id="agreement_warning" <?php if ($display_error && $has_error) { ?>data-error="true"<?php } else { ?>style="display:none;"<?php } ?>>
                        <div class="agreement_all">
                            <?php foreach ($error_warning_agreement as $agreement_id => $warning_agreement) { ?>
                                <div class="agreement_<?php echo $agreement_id ?>"><?php echo $warning_agreement ?></div>
                            <?php } ?>
                        </div>                    
                    </div>
                <?php } ?>

                <div class="simplecheckout-button-block buttons" id="buttons">
                    <div class="simplecheckout-button-right">
                        <?php if ($display_agreement_checkbox) { ?>
                            <span id="agreement_checkbox">
                                <?php foreach ($text_agreements as $agreement_id => $text_agreement) { ?>
                                    <div class="checkbox"><label><input type="checkbox" name="agreements[]" value="<?php echo $agreement_id ?>" <?php echo in_array($agreement_id, $agreements) ? 'checked="checked"' : '' ?> /><?php echo $text_agreement; ?></label></div>
                                <?php } ?>
                            </span>
                        <?php } ?>
                        <?php if ($steps_count > 1) { ?>
                            <a class="button btn-primary button_oc btn" data-onclick="nextStep" id="simplecheckout_button_next"><span><?php echo $button_next; ?></span></a>
                        <?php } ?>
                        <a class="button btn-primary button_oc btn" <?php echo $block_order ? 'disabled' : '' ?> data-onclick="createOrder" id="simplecheckout_button_confirm"><span><?php echo $button_order; ?></span></a>
                    </div>
                    <div class="simplecheckout-button-left">
                        <?php if ($display_back_button) { ?>
                            <a class="button btn-primary button_oc btn" data-onclick="backHistory" id="simplecheckout_button_back"><span><?php echo $button_back; ?></span></a>
                        <?php } ?>
                        <?php if ($steps_count > 1) { ?>
                            <a class="button btn-primary button_oc btn" data-onclick="previousStep" id="simplecheckout_button_prev"><span><?php echo $button_prev; ?></span></a>
                        <?php } ?>
                    </div>
                </div>  
                
                <?php if ($steps_count > 1 && $menu_type == '2') { ?>
                    </div>
                <?php } ?>
                
                <?php if ($steps_count > 1 && $menu_type == '2') { ?>
                    <div id="simplecheckout_step_menu" class="simplecheckout-vertical-menu simplecheckout-bottom-menu">
                        <?php for ($i=1;$i<=$steps_count;$i++) { ?>
                            <div class="checkout-heading simple-step-vertical" style="display:none" data-onclick="gotoStep" data-step="<?php echo $i; ?>"><h4 class="panel-title"><?php echo $step_names[$i-1] ?></h4></div>
                        <?php } ?>
                    </div>
                <?php } ?>              
            <?php } else { ?>
                <div class="content"><?php echo $text_error; ?></div>
                <div style="display:none;" id="simplecheckout_cart_total"><?php echo $cart_total ?></div>
                <?php if ($display_weight) { ?>
                    <div style="display:none;" id="simplecheckout_cart_weight"><?php echo $weight ?></div>
                <?php } ?>
                <div class="simplecheckout-button-block buttons">
                    <div class="simplecheckout-button-right right"><a href="<?php echo $continue; ?>" class="button btn-primary button_oc btn"><span><?php echo $button_continue; ?></span></a></div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php if (!$ajax && !$popup && !$as_module) { ?>
</div>

					<!-- START Shipping Data -->
					<script type="text/javascript"><!--
						// Autocomplete for shipping addresses
						(function ($) {
							var methods = {
								init: function (options) {
									return this.each(function () {
										var $this = $(this);
										var data = $this.data('autocompleteAddress');

										// If the plugin is not yet initialized
										if (!data) {
											$this.timer = null;
											$this.items = new Array();

											$.extend($this, options);

											$this.attr('autocomplete', 'new-password');

											// Focus
											$this.on('focus.autocompleteAddress', function () {
												$this.request('');
											} );

											// Blur
											$this.on('blur.autocompleteAddress', function () {
												setTimeout(function (object) {
													object.hide();
												}, 200, $this);
											} );

											// Keydown
											$this.on('keydown.autocompleteAddress', function (event) {
												switch (event.keyCode) {
													case 27: // escape
														$this.hide();
														break;
													default:
														$this.request();
														break;
												}
											} );

											// Click
											$this.click = function (event) {
												event.preventDefault();

												var value = $(event.target).parent().attr('data-value');

												if (value && $this.items[value]) {
													$this.select($this.items[value]);
												}
											}

											// Show
											$this.show = function () {
												var pos = $this.position();

												$this.siblings('ul.' + $this.class).css({
													'top': pos.top + $this.outerHeight(),
													'left': pos.left
												});

												$this.siblings('ul.' + $this.class).show();
											}

											// Hide
											$this.hide = function () {
												$this.siblings('ul.' + $this.class).hide();
											}

											// Request
											$this.request = function (search) {
												clearTimeout($this.timer);

												$this.timer = setTimeout(function (object) {
													search = (typeof(search) === 'undefined') ? object.val() : search;

													object.source(search, $.proxy(object.response, object));
												}, 200, $this);
											}

											// Response
											$this.response = function (json) {
												var html = '';

												if (json.length) {
													for (i = 0; i < json.length; i++) {
														this.items[json[i]['value']] = json[i];

														html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
													}
												}

												if (html && $this.is(':focus')) {
													$this.show();
												} else {
													$this.hide();
												}

												$this.siblings('ul.' + $this.class).html(html);
											}

											$this.after('<ul class="' + $this.class + '"></ul>');
											$this.siblings('ul.' + $this.class).delegate('a', 'click', $.proxy($this.click, $this));
											$this.data('autocompleteAddress', true);
										}
									} );
								},
								destroy: function () {
									return this.each(function () {
										var $this = $(this);

										$this.removeData('autocompleteAddress');

										$this.off('.autocompleteAddress');
									} );
								}
							};

							$.fn.autocompleteAddress = function (method) {
								if (methods[method]) {
									return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
								} else if (typeof (method) === 'object' || !method) {
									return methods.init.apply(this, arguments);
								} else {
									$.error('Method "' + method + '" does not exist for jQuery.autocompleteAddress');
								}
							}
						} )(window.jQuery);

						// ShippingData object
						function ShippingData() {
							var self = this;
							var src, method, lang;

							self.methods_city = [
								'novaposhta.warehouse',
								'novaposhta.doors',
                                'courier_sz.courier_sz'
							];

							self.methods_address = [
								'novaposhta.warehouse',
                                'courier_sz.courier_sz'
							];

							self.setProp = function () {
								self.method = $('input[name="shipping_method"]:checked').val() || $('select[name="shipping_method"]').val();

								self.lang =  $('html').attr('lang');
							}

							self.handlerChanges = function (name, value) {
								if ($.inArray(self.method, self.methods_city.concat(self.methods_address)) != - 1) {
									if (name.match(/zone/i)) {
										$('input[name*="city"]:visible').val('');
										$('input[name*="address_1"]:visible').val('');
									} else if (name.match(/city/i)) {
										$('input[name*="address_1"]:visible').val('');
									} else if (name.match(/shipping\_method/i)) {
										$('input[name*="city"]:visible').autocompleteAddress('destroy');
										$('input[name*="address_1"]:visible').val('').autocompleteAddress('destroy');

										self.method = value;
									}
								} else if ($.inArray(value, self.methods_city.concat(self.methods_address)) != - 1) {
									if (name.match(/shipping\_method/i)) {
										$('input[name*="city"]:visible').val('');
										$('input[name*="address_1"]:visible').val('');

										self.method = value;
									}
								}
							}

							self.getAddress = function (element, search) {
								var filter, action;

								if (element[0].name.match(/city/i)) {
									action = 'getCities';
									filter = $('[name*="zone"]:visible').val() || '';
								} else if (element[0].name.match(/address_1/i)) {
									action = 'getWarehouses';
									filter = $('[name*="city"]:visible').val();
								}

								if (!search) {
									search = element[0].value;
								}

								return $.ajax( {
									url: 'index.php?route=extension/module/shippingdata/getShippingData',
									type: 'POST',
									data: 'shipping=' + self.method + '&action=' + action + '&filter=' + encodeURIComponent(filter) + '&search=' + encodeURIComponent(search),
									dataType: 'json',
									global: false,
									success: function (json) {
										self.src = json;
									}
								} );
							}
						}

						// DOOM loaded
						$(function () {
							var shippingData = new ShippingData();

							// Settings properties after DOOM load
							shippingData.setProp();

							// Settings properties after ajaxStop
							$(document).ajaxStop(function () {
								shippingData.setProp();

								//Simple checkout fix
								$('.simplecheckout-block-content').css('overflow', 'visible');
							} );

							// Check changes
							$(document).on('change', '[name*="zone"]:visible, [name*="city"]:visible, [name*="shipping_method"]', function (e) {
								shippingData.handlerChanges(e.target.name, e.target.value);
							});

							// Add autocomplete for address
							$('body').on('focus', 'input[name*="city"]:visible, input[name*="address_1"]:visible', function () {
								if (this.name.match(/city/i) && $.inArray(shippingData.method, shippingData.methods_city) != - 1 || this.name.match(/address_1/i) && $.inArray(shippingData.method, shippingData.methods_address) != - 1) {
									$(this).autocompleteAddress( {
										source: function (request, response) {
											shippingData.getAddress(this, request).done(function () {
												response($.map(shippingData.src, function (item) {
													return {
														label: item['Description'],
														value: item['Description']
													}
												} ));
											} );
										},
										select: function (e) {
											if (e.value != this.val()) {
												this.val(e.value);

												this.trigger('change');
											}
										},
										class: 'dropdown-address'
									} );
								}
							} );
						} );
					//--></script>
					<!-- END Shipping Data -->
        		
<?php include $simple_footer ?>
<?php } ?>