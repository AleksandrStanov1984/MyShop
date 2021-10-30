<?php // for Centos correct file association ?>
<script>

//////////////////////////////////////////////////////////////////////////////
// COMMON
//////////////////////////////////////////////////////////////////////////////


// Config
var test_mode = '<?= $test_mode ?>';


// Category Tree
$('.categories-selector .has-children').each(function() {
	$(this).children('ul').hide();
});

$('.categories-selector .toggle-item').each(function() {
	$(this).click(function(){
		if($(this).hasClass('closed')) {
			$(this).html('-');
			$(this).removeClass('closed');
			$(this).parent('.has-children').children('ul').show(100);
		} else {
			$(this).html('+');
			$(this).addClass('closed');
			$(this).parent('.has-children').children('ul').hide(100);
		}
	});
});

$('body').on('click', '.categories-selector .all-subcategories-selector', function(e){
  if('notchecked' == $(this).attr('data-status')) {
    $(this).attr('data-status', 'checked');
    $(this).prev('label').children('input').prop('checked', true);
    $(this).prev('label').parent('.has-children').find(':checkbox:not(:disabled)').prop('checked', true);
    $(this).prev('label').parent('.has-children').find(':checkbox:not(:disabled)').trigger('change');
    $(this).prev('label').parent('.has-children').find('.all-subcategories-selector').attr('data-status', 'checked');
  } else {
    $(this).attr('data-status', 'notchecked');
    $(this).prev('label').children('input').prop('checked', false);
    $(this).prev('label').parent('.has-children').find(':checkbox:not(:disabled)').prop('checked', false);
    $(this).prev('label').parent('.has-children').find(':checkbox:not(:disabled)').trigger('change');
    $(this).prev('label').parent('.has-children').find('.all-subcategories-selector').attr('data-status', 'notchecked');
  }
});




//////////////////////////////////////////////////////////////////////////////
// FILTER
//////////////////////////////////////////////////////////////////////////////


// Filter Manufacturer
$('input[name=\'mass_filter_manufaturer_input\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=extension/module/handy_product_manager/autocompleteManufacturer&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['manufacturer_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'mass_filter_manufaturer_input\']').val('');
		$('#mass-filter__manufacturer' + item['value']).remove();
		$('#mass-filter__manufacturer').append('<div id="mass-filter__manufacturer' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="mass_filter[manufacturer][]" value="' + item['value'] + '" /></div>');
	}
});

$('#mass-filter__manufacturer').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});


// Filter Attribute
$('body').on('change', '.mass-filter__attribute-select', function() {
	massGetAttributeValues($(this).val(), $(this).attr('data-row'));
});

function massGetAttributeValues(attributeId, row) {
	var target = '#mass-filter__attribute-value-' + row;
	var html = '';

	$.ajax({
		url: 'index.php?route=extension/module/handy_product_manager/getAttributeValues&token=<?=$token?>&attribute_id=' + attributeId,
		type: 'GET',
		dataType: 'json',
		success: function(json) {
			if ('success' === json['status']) {
				var data = json['data'];

				if (test_mode) {
					console.debug(data);
				}

				var i = 0;
				for (var key in data) {
					html += '<option value="' + data[key]['text'] + '">' + data[key]['text'] + '</option>';
					i++;
				}
				if(0 === i) {
					html += '<option value=""><?= $hpm_text_attribute_values_empty ?></option>';
				} else {
					html = '<option value=""><?= $hpm_text_attribute_values_select ?></option>' + html;
				}

				$(target).html(html);

			} else {
				if (test_mode) {
					console.log('error on attribute selector get attribute values: ' + target );
				}
			}
		},
		error: function( jqXHR, textStatus, errorThrown ){
			// Error ajax query
			console.log('AJAX query Error on ' + target + ': ' + textStatus );
		},
	});
}

$('body').on('click', '.mass-filter__btn-add-attribute-row', function() {
	var row = $(this).attr('data-target-row');
	var html = '';
	html +='<div class="row" id="mass-filter__attribute-row-' + row + '">';

	html +='<div class="col-sm-5">';
	html +='<label class="control-label" for="mass-filter__attribute-' + row + '"><?= $mass_entry_attribute ?></label>';
	html +='<select name="mass_filter[attribute][' + row + ']" id="mass-filter__attribute-' + row + '" class="form-control mass-filter__attribute-select" data-row="' + row + '">';
	html +='<option value="*"><?= $mass_text_none ?></option>';
	<?php foreach($attributes as $attribue) { ?>
	html +='<option value="<?= $attribue['attribute_id'] ?>"><?= $attribue['attribute_group'] ?> -- <?= $attribue['name'] ?></option>';
	<?php } ?>
	html +='</select>';
	html +='</div>';

	html +='<div class="col-sm-5">';
	html +='<label class="control-label" for="mass-filter__attribute-value-' + row + '"><?= $mass_entry_attribute_value ?></label>';
	html +='<select name="mass_filter[attribute_value][' + row + ']" id="mass-filter__attribute-value-' + row + '" class="form-control">';
	html +='<option value="*"><?= $mass_text_none ?></option>';
	html +='</select>';
	html +='</div>';

	html +='<div class="col-sm-2">';
	html +='<a type="button" class="mass-filter__btn-remove-attribute-row" data-parent-row="' + row + '" data-toggle="tooltip" title="<?= $button_remove ?>"><i class="fa fa-close"></i></a>';
	html +='</div>';

	html +='</div>';

	// append
	$('#mass-filter__attributes').append(html);

	$(this).attr('data-target-row', Number(row) + 1);

});

$('body').on('click', '.mass-filter__btn-remove-attribute-row', function() {
	$('#mass-filter__attribute-row-' + $(this).data('parent-row')).remove();
});


// Filter Option
// Данный массив всегда актуален, пока мы не добавляем новые опции прямо во время редактирования товара.
// При реализации редактирования товара можно просто пополнять данный массив значениями.

var optionsExist = JSON.parse('<?= $optionsExist ?>');
var optionValuesExist = [];

$.ajax({
  url: 'index.php?route=extension/module/handy_product_manager/getAllOptionValues&token=<?=$token?>',
  type: 'GET',
  dataType: 'json',
  async: false,
  success: function(json) {
    if ('success' === json['status']) {
      optionValuesExist = json['data'];
    } else {
      alert('error on extension/module/handy_product_manager/getAllOptionValues');
    }
  },
  error: function( jqXHR, textStatus, errorThrown ){
    // Error ajax query
    console.log('AJAX query Error: ' + textStatus );
  },
});


$('body').on('click', '.mass-filter__btn-add-option-row', function() {
	var row = $(this).attr('data-target-row');
	var html = '';

	html +='<div class="row" id="mass-filter__option-row-' + row + '">';

	html +='<div class="col-sm-10">';
	html +='<label class="control-label" for="mass-filter__input-option-' + row + '"><?= $mass_entry_option ?></label>';
	html +='<select name="mass_filter[option][' + row + ']" id="mass-filter__input-option-' + row + '" class="form-control mass-filter__option-select" data-row="' + row + '">';
	html +='<option value="*"><?= $mass_text_none ?></option>';
	<?php foreach($options as $option) { ?>
	html +='<option value="<?= $option['option_id'] ?>"><?= $option['name'] ?></option>';
	<?php } ?>
	html +='</select>';
	html +='</div>';
	html +='<div class="col-sm-2">';
	html +='<a type="button" class="mass-filter__btn-remove-option-row" data-parent-row="' + row + '" data-toggle="tooltip" title="<?= $button_remove ?>"><i class="fa fa-close"></i></a>';
	html +='</div>';

	html +='</div>';

	// append
	$('#mass-filter__options').append(html);

	$(this).attr('data-target-row', Number(row) + 1);
});

$('body').on('click', '.mass-filter__btn-remove-option-row', function() {
	$('#mass-filter__option-row-' + $(this).data('parent-row')).remove();
});


// remove-filter
$('body').on('click', '.remove-filter', function() {
	if ('' != $('input[name="mass_filter\[' + $(this).data('target') + '\]"]').val()) {
    $('input[name="mass_filter\[' + $(this).data('target') + '\]"]').val('');
  }
});





//////////////////////////////////////////////////////////////////////////////
// EDITOR
//////////////////////////////////////////////////////////////////////////////



// Editor Discount
$('body').on('click', '.btn-remove-discount', function(e) {
  $($(this).data('target')).remove();
});

$('body').on('click', '.btn-add-discount', function(e) {
  if(test_mode) {
    console.log('.btn-add-discount click() is called');
  }

  var discountRow = $(this).data("discount-row");
  var identifierRow = 'discount-row' + '-' + discountRow;

  if(test_mode) {
    console.log('discountRow : ' + discountRow);
    console.log('identifierRow : ' + identifierRow);
  }

  // todo
  // Получаем productDiscountId
  // Добавляем форму для редактирования скидки

  var html = '';
  html += '<div id="discount-row-' + discountRow + '" class="discount-row" data-discount-row="' + discountRow + '">';
  html += '<div class="pull-right"><a type="button" class="btn-remove-discount" data-target="#discount-row-' + discountRow + '" data-toggle="tooltip" title="<?= $button_remove ?>"><i class="fa fa-close"></i></a></div>';
  html += '<div class="le-row">';
  html += '<span class="le-label _customer-group"><?= $hpm_entry_customer_group ?>:</span>';
  html += '<select name="discount[' + discountRow + '][customer_group_id]" class="le-value _discount-value le-selector discount-customer-group">';
  <?php foreach ($customer_groups as $customer_group) { ?>
  html += '<option value="<?= $customer_group['customer_group_id'] ?>"><?= $customer_group['name'] ?></option>';
  <?php } ?>
  html += '</select>';
  html += '</div>';
	html += '<div class="le-row">';
  html += '<span class="le-label _quantity"><?= $entry_quantity ?></span>';
  html += '<input type="text" name="discount[' + discountRow + '][quantity]" value="" placeholder="<?= $entry_quantity ?>" class="le-value _discount-value discount-quantity" />';
  html += '</div>';
  html += '<div class="le-row">';
  html += '<span class="le-label _priority"><?= $entry_priority ?></span>';
  html += '<input type="text" name="discount[' + discountRow + '][priority]" value="" placeholder="<?= $entry_priority ?>" class="le-value _discount-value discount-priority" />';
  html += '</div>';
  html += '<div class="le-row">';
  html += '<span class="le-label"><?= $entry_price ?></span>';
  html += '<input type="text" name="discount[' + discountRow + '][price]" value="" placeholder="<?= $entry_price ?>" class="le-value _discount-value discount-price" />';
  html += '</div>';
  html += '<div class="le-row _date">';
  html += '<span class="le-label _date"><?= $hpm_entry_date_start ?>:</span>';
  html += '<div class="date">';
  html += '<input type="text" name="discount[' + discountRow + '][date_start]"  value="" placeholder="<?= $hpm_entry_date_start ?>" data-date-format="YYYY-MM-DD" class="le-value _discount-value _date  discount-date-start" />';
  html += '<span class="input-group-btn">';
  html += '<button class="btn-calendar" type="button"><i class="fa fa-calendar"></i></button>';
  html += '</span></div>';
  html += '</div>';
  html += '<div class="le-row _date">';
  html += '<span class="le-label _date"><?= $hpm_entry_date_end ?>:</span>';
  html += '<div class="date">';
  html += '<input type="text" name="discount[' + discountRow + '][date_end]" value="" placeholder="<?= $hpm_entry_date_end ?>" data-date-format="YYYY-MM-DD" class="le-value _discount-value _date discount-date-end" />';
  html += '<span class="input-group-btn">';
  html += '<button class="btn-calendar" type="button"><i class="fa fa-calendar"></i></button>';
  html += '</span></div>';
  html += '</div>';
  html += '</div>';

  $('#discount-container').append(html);

  $(this).data("discount-row", discountRow + 1); // Сохраняем порядковый номер ряда

  setTimeout(function () {
    initButtonCalendar();
  }, 100);
});


// Editor Special
$('body').on('click', '.btn-remove-special', function(e) {
  $($(this).data('target')).remove();
});

$('body').on('click', '.btn-add-special', function(e) {
  if(test_mode) {
    console.log('.btn-add-special click() is called');
  }

  var specialRow = $(this).data("special-row");
  var identifierRow = 'special-row' + '-' + specialRow;

  if(test_mode) {
    console.log('specialRow : ' + specialRow);
    console.log('identifierRow : ' + identifierRow);
  }

  // todo
  // Получаем productSpecialId
  // Добавляем форму для редактирования скидки

  var html = '';
  html += '<div id="special-row-' + specialRow + '" class="special-row" data-special-row="' + specialRow + '">';
  html += '<div class="pull-right"><a type="button" class="btn-remove-special" data-target="#special-row-' + specialRow + '" data-toggle="tooltip" title="<?= $button_remove ?>"><i class="fa fa-close"></i></a></div>';
  html += '<div class="le-row">';
  html += '<span class="le-label _customer-group"><?= $hpm_entry_customer_group ?>:</span>';
  html += '<select name="special[' + specialRow + '][customer_group_id]" class="le-value _special-value le-selector special-customer-group">';
  <?php foreach ($customer_groups as $customer_group) { ?>
  html += '<option value="<?= $customer_group['customer_group_id'] ?>"><?= $customer_group['name'] ?></option>';
  <?php } ?>
  html += '</select>';
  html += '</div>';
  html += '<div class="le-row">';
  html += '<span class="le-label _priority"><?= $entry_priority ?></span>';
  html += '<input type="text" name="special[' + specialRow + '][priority]" value="" placeholder="<?= $entry_priority ?>" class="le-value _special-value special-priority" />';
  html += '</div>';
  html += '<div class="le-row">';
  html += '<span class="le-label"><?= $entry_price ?></span>';
  html += '<input type="text" name="special[' + specialRow + '][price]" value="" placeholder="<?= $entry_price ?>" class="le-value _special-value special-price" />';
  html += '</div>';
  html += '<div class="le-row _date">';
  html += '<span class="le-label _date"><?= $hpm_entry_date_start ?>:</span>';
  html += '<div class="date">';
  html += '<input type="text" name="special[' + specialRow + '][date_start]"  value="" placeholder="<?= $hpm_entry_date_start ?>" data-date-format="YYYY-MM-DD" class="le-value _special-value _date  special-date-start" />';
  html += '<span class="input-group-btn">';
  html += '<button class="btn-calendar" type="button"><i class="fa fa-calendar"></i></button>';
  html += '</span></div>';
  html += '</div>';
  html += '<div class="le-row _date">';
  html += '<span class="le-label _date"><?= $hpm_entry_date_end ?>:</span>';
  html += '<div class="date">';
  html += '<input type="text" name="special[' + specialRow + '][date_end]" value="" placeholder="<?= $hpm_entry_date_end ?>" data-date-format="YYYY-MM-DD" class="le-value _special-value _date special-date-end" />';
  html += '<span class="input-group-btn">';
  html += '<button class="btn-calendar" type="button"><i class="fa fa-calendar"></i></button>';
  html += '</span></div>';
  html += '</div>';
  html += '</div>';

  $('#special-container').append(html);

  $(this).data("special-row", specialRow + 1); // Сохраняем порядковый номер ряда

  setTimeout(function () {
    initButtonCalendar();
  }, 100);
});


// Editor Attribute
$('body').on('change', '.attribute-select', function() {
	<?php foreach ($languages as $language) { ?>
	getAttributeValues($(this).val(), $(this).attr('data-row'), <?=$language['language_id']?>);
	<?php } ?>
});

function getAttributeValues(attributeId, row, languageId) {
	var target = '#input-attribute-value-' + languageId + '-' + row;
	var html = '';

	$.ajax({
		url: 'index.php?route=extension/module/handy_product_manager/getAttributeValues&token=<?=$token?>&attribute_id=' + attributeId + '&language_id=' + languageId,
		type: 'GET',
		dataType: 'json',
		success: function(json) {
			if ('success' === json['status']) {
				var data = json['data'];

				if (test_mode) {
					console.debug(data);
				}

				var i = 0;
				for (var key in data) {
					html += '<option value="' + data[key]['text'] + '">' + data[key]['text'] + '</option>';
					i++;
				}
				if(0 === i) {
					html += '<option value=""><?= $hpm_text_attribute_values_empty ?></option>';
				} else {
					html = '<option value=""><?= $hpm_text_attribute_values_select ?></option>' + html;
				}

				$(target).html(html);

			} else {
				if (test_mode) {
					console.log('error on attribute selector get attribute values: ' + target );
				}
			}
		},
		error: function( jqXHR, textStatus, errorThrown ){
			// Error ajax query
			console.log('AJAX query Error on ' + target + ': ' + textStatus );
		},
	});
}

// .btn-add-attribute
$('body').on('click', '.btn-add-attribute', function() {
	var row = $(this).attr('data-target-row');

	var html = '';
	html +='<div class="le-row" id="attribute-row-' + row + '" style="position: relative; margin-bottom: 10px;">';

	html +='<div style="position: absolute; top: 0; right: 0;"><a type="button" class="btn-remove-attribute-row" data-parent-row="' + row + '" data-toggle="tooltip" title="<?= $button_remove ?>"><i class="fa fa-close"></i></a></div>';
	html +='<div style="width: 32%; float: left; ">';
	html +='<label class="control-label" for="input-attribute-' + row + '"><?= $mass_entry_attribute ?></label><br>';
	html +='<select name="attribute[' + row + ']" id="input-attribute-' + row + '" class="le-value le-selector attribute-select" data-row="' + row + '" style="width: 100%;">';
	html +='<option value="*"><?= $mass_text_none ?></option>';
	<?php foreach($attributes as $attribue) { ?>
	html +='<option value="<?= $attribue['attribute_id'] ?>"><?= $attribue['attribute_group'] ?> -- <?= $attribue['name'] ?></option>';
	<?php } ?>
	html +='</select>';
	html +='</div>';
	<?php foreach($languages as $language) { ?>
	html +='<div style="width: 32%; float: right; ">';
	html +='<label class="control-label" for="input-attribute-value-' + row + '"><?= $entry_attribute_value ?></label><br>';
	html +='<select name="attribute_value[<?= $language['language_id'] ?>][' + row + ']" id="input-attribute-value-<?= $language['language_id'] ?>-' + row + '" class="le-value le-selector" style="width: 100%;">';
	html +='<option value="*"><?= $mass_text_none ?></option>';
	html +='</select>';
	html +='</div>';
	<?php } ?>

	html +='</div>';

	// append
	$('#attributes-container').append(html);

	$(this).attr('data-target-row', Number(row) + 1);
});

$('body').on('click', '.btn-remove-attribute-row', function() {
	$('#attribute-row-' + $(this).data('parent-row')).remove();
});


// Editor Option
$('body').on('click', '.btn-add-option', function() {
	var row = $(this).attr('data-target-row');

	var html = '';

	html +='<div class="option-row" id="option-row-' + row + '" data-option-id="0" data-option-row="' + row + '">';

	html +='<div class="pull-right"><a type="button" class="btn-remove-option-row" data-parent-row="' + row + '" data-toggle="tooltip" title="<?= $button_remove ?>"><i class="fa fa-close"></i></a></div>';
	html +='<div class="le-row">';
//	html +='<label class="control-label" for="input-option-' + row + '"><?= $mass_entry_option ?></label>';
	html +='<select name="option[' + row + ']" id="input-option-' + row + '" class="le-selector option-selector" data-row="' + row + '">';
	html += '<option value=""><?= $hpm_text_option_select ?></option>';
	html +='<option value="*"><?= $mass_text_none ?></option>';
	<?php foreach($options as $option) { ?>
	html +='<option value="<?= $option['option_id'] ?>"><?= $option['name'] ?></option>';
	<?php } ?>
	html +='</select>';
	html +='</div>';

	html +='</div>';

	// append
	$('#options-container').append(html);
	$(this).attr('data-target-row', Number(row) + 1);
});

$('body').on('change', '.option-selector', function() {
	var row = $(this).attr('data-row');
	var optionId = $(this).val();

	var html = '';
	html +='<div class="le-row">';

	html +='<div class="pull-right">';
	html +='<a type="button" class="btn-remove-option-row" data-parent-row="' + row + '" data-toggle="tooltip" title="<?= $button_remove ?>"><i class="fa fa-close"></i></a>';
	html +='</div>';

	html += '<div class="le-label name"><a class="option-link" href="index.php?route=catalog/option/edit&token=<?= $token ?>&option_id=' + optionId + '" target="_blank" data-toggle="tooltip" title="<?= $hpm_text_option_edit ?>">' + $(this).children('option:selected').text() + '</a></div>';

	html += '<!-- hidden Option Id -->';
	html += '<input type="hidden" name="option[' + row + '][option_id]" value="' + optionId + '" />';

	html += '<!-- reqiure -->';
	html += '<div class="option-require le-row" style="padding-left: 0; padding-top:5px;">';
	html += '<label class="le-label _left" style="text-align: left;" for="input-required-' + row + '"><?= $entry_required ?></label>';
	html += '<select name="option[' + row + '][option_require]" id="input-required-' + row + '" class="le-value _simple-value le-selector _right">';
	html += '<option value="1" selected="selected"><?= $text_yes ?></option>';
	html += '<option value="0"><?= $text_no ?></option>';
	html += '</select>';
	html += '</div>';

	if ('text' == optionsExist[optionId]['type']) {
		html += '<div class="row">';
		html += '<label class="control-label col-sm-12" for="input-value-' + row + '"><?= $entry_option_value ?></label>';
		html += '<div class="col-sm-12">';
		html += '<input type="text" name="option[' + row + '][option_value]" value="" placeholder="<?= $entry_option_value ?>" id="input-value-' + row + '" class="form-control" />';
		html += '</div>';
		html += '</div>';
	}

	if ('textarea' == optionsExist[optionId]['type']) {
		html += '<div class="row">';
		html += '<label class="control-label col-sm-12" for="input-value-' + row + '"><?= $entry_option_value ?></label>';
		html += '<div class="col-sm-12">';
		html += '<textarea name=" name="option[' + row + '][option_value]" rows="5" placeholder="<?= $entry_option_value ?>" id="input-value-' + row + '" class="form-control"></textarea>';
		html += '</div>';
		html += '</div>';
	}

	if ('select' == optionsExist[optionId]['type'] || 'radio' == optionsExist[optionId]['type'] || 'checkbox' == optionsExist[optionId]['type'] || 'image' == optionsExist[optionId]['type']) {
		html += '<div id="option-values-' + row + '" class="option-values">';
		html += '</div>';
    html += '<button type="button" data-toggle="tooltip" data-target="#option-values-' + row + '" title="<?= $button_option_value_add ?>" class="btn btn-sm btn-primary btn-add-option-value" data-option-value-row="0"><i class="fa fa-plus-circle"></i></button>';
	}

	html +='</div>';

	$('#option-row-' + row).attr('data-option-id', optionId);

	$('#option-row-' + row).html(html);
});

$('body').on('click', '.btn-remove-option-row', function() {
	$('#option-row-' + $(this).data('parent-row')).remove();
});

$('body').on('click', '.btn-add-option-value', function(e) {
	var optionRow = $(this).closest('.option-row').attr('data-option-row'); // this row ! not all rows!
	var optionValueRow = $(this).attr('data-option-value-row');
  var optionId = $(this).closest('.option-row').attr('data-option-id');
	var thisOptionValues = optionValuesExist[optionId];
	var optionValueId = thisOptionValues[0]['option_value_id'];

	$('#option-row-' + optionRow).attr('data-option-id', optionId);

	// check countity of options values
	if ($($(this).data('target') + ' .option-value').length >= thisOptionValues.length) {
		alert('This option have only ' + thisOptionValues.length + ' values and ' + $($(this).data('target') + ' .option-value').length + ' is already required to this product. You can\'t add more!');
		return false;
	}

  var html = '';

	html += '<div id="option-value-' + optionRow + '-' + optionValueRow + '" class="option-value le-row">';
	html += '<span class="fa fa-close btn-remove-option-value" data-toggle="tooltip" title="<?= $button_remove ?>"></span>';

	html += '<div class="le-row">';
	html += '<label class="le-label _left" for="input-product-option-value-' + optionRow + '-' + optionValueRow + '"><?= $entry_option_value ?></label>';
	html += '<select name="option[' + optionRow + '][option_value][' + optionValueRow + ']" id="input-product-option-value-' + optionRow + '-' + optionValueRow + '" class="le-value _simple-value-2 le-selector _right" data-field="option_value_id">';
	var i = 0;
	var selected;
	thisOptionValues.forEach(function(item) {
		if (0 == i) selected = ' selected="selected"';
		else selected = '';
    html += '<option value="' + item['option_value_id'] + '"' + selected + '>' + item['name'] + '</option>';
		i++;
  });
  html += '</select>';
	html += '</div>';

	html += '<div class="le-row">';
	html += '<label class="le-label _left" for="input-quantity-' + optionRow + '-' + optionValueRow + '"><?= $entry_quantity ?></label>';
	html += '<input type="text" name="option[' + optionRow + '][quantity][' + optionValueRow + ']" id="input-quantity-' + optionRow + '-' + optionValueRow + '" name="" value="" placeholder="<?= $entry_quantity ?>" class="le-value _simple-value-2 _right" data-field="quantity" />';
	html += '</div>';

	html += '<div class="le-row">';
	html += '<label class="le-label _left" for="input-subtract-' + optionRow + '-' + optionValueRow + '" style="padding-top: none;"><?= $entry_subtract ?></label>';
	html += '<select name="option[' + optionRow + '][subtract][' + optionValueRow + ']" id="input-subtract-' + optionRow + '-' + optionValueRow + '" class="le-value _simple-value-2 le-selector _right">';
	html += '<option value="1" selected="selected"><?= $text_yes ?></option>';
	html += '<option value="0"><?= $text_no ?></option>';
	html += '</select>';
	html += '</div>';

	html += '<div class="le-row">';
	html += '<label class="le-label _left"><?= $entry_price ?></label>';
	html += '<input type="text" name="option[' + optionRow + '][price][' + optionValueRow + ']" id="input-price-' + optionRow + '-' + optionValueRow + '" value="" placeholder="<?= $entry_price ?>" class="le-value _simple-value-2 _right-half" />';
	html += '<select name="option[' + optionRow + '][price_prefix][' + optionValueRow + '] id="input-price-prefix-' + optionRow + '-' + optionValueRow + '" class="le-value _simple-value-2 le-selector _right-half" data-field="price_prefix">';
	html += '<option value="+" selected="selected">+</option>';
	html += '<option value="-">-</option>';
	html += '</select>';
	html += '</div>';

	html += '<div class="le-row">';
	html += '<label class="le-label _left"><?= $entry_option_points ?></label>';
	html += '<input type="text" name="option[' + optionRow + '][points][' + optionValueRow + ']" id="input-points-' + optionRow + '-' + optionValueRow + '"value="" placeholder="<?= $entry_option_points ?>" class="le-value _simple-value-2 _right-half" data-field="points" />';
	html += '<select name="option[' + optionRow + '][points_prefix][' + optionValueRow + '] id="input-points-prefix-' + optionRow + '-' + optionValueRow + '" class="le-value _simple-value-2 le-selector _right-half">';
	html += '<option value="+" selected="selected">+</option>';
	html += '<option value="-">-</option>';
	html += '</select>';
	html += '</div>';

	html += '<div class="le-row">';
	html += '<label class="le-label _left"><?= $entry_weight ?></label>';
	html += '<input type="text" name="option[' + optionRow + '][weight][' + optionValueRow + ']" id="input-weight-' + optionRow + '-' + optionValueRow + '" value="" placeholder="<?= $entry_weight ?>" class="le-value _simple-value-2 _right-half" />';
	html += '<select name="option[' + optionRow + '][weight_prefix][' + optionValueRow + '] id="input-weight-prefix-' + optionRow + '-' + optionValueRow + '" class="le-value _simple-value-2 le-selector _right-half">';
	html += '<option value="+" selected="selected">+</option>';
	html += '<option value="-">-</option>';
	html += '</select>';
	html += '</div>';

	html += '</div>';

  $($(this).data('target')).append(html);

	optionValueRow = Number(optionValueRow) + 1;
	$(this).attr('data-option-value-row', optionValueRow);
});

$('body').on('click', '.btn-remove-option-value', function(e) {
  $(this).tooltip('destroy');
  $(this).parent('.option-value').remove();
});




//////////////////////////////////////////////////////////////////////////////
// AJAX
//////////////////////////////////////////////////////////////////////////////


$('#mass-edit-submit').click(function(e){
	e.preventDefault();
	console.clear();

	// defaults
	stop     = false;
	stepPE   = 1;
	stepsAll = 1;

	$('#request-answer').addClass('alert alert-info');
	$('#request-answer').html('<p><?= $text_processing ?></p>');

	$('#mass-edit-submit').attr('disabled', 'disabled');

	$('#mass-edit-submit' + ' .load-bar').css('display', 'block');

	var dataObj = $('#form-mass-edit').serialize();

	console.debug(dataObj);

	do {
		console.log('---------------------------------------------------');

		$.ajax({
			url: 'index.php?route=extension/module/handy_product_manager/massEditProcessing&token=<?= $token ?>',
			dataType: 'json',
			type: "POST",
			data: dataObj += '&step=' + stepPE, // A!
			async: false, // !important
			success: function(json) {
				console.log('AJAX Return Success!');

				if (!json.error) {
					stepsAll = json.steps_all;

					$('#request-answer').empty();
					$('#request-answer').html('<p class="text-success">' + json.answer + '</p>');

					if (stepPE >= stepsAll) {
						stop = true;
					}

					console.log('stepPE : ' + stepPE);
					console.log('stepsAll : ' + stepsAll);
				} else {
					stop = true;

					$('#generate-empty-seo-url-product .load-bar').css('display', 'none');
					$('#request-answer').empty();
					$('#request-answer').html('<p class="text-danger">' + json.answer + '</p>');
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				stop = true;
				$('#generate-empty-seo-url-product .load-bar').css('display', 'none');
				$('#request-answer').empty();
				$('#request-answer').html('<p class="text-danger"><?= $error_ajax_response ?></p>');

				console.log('response: ' + xhr.status); // пoкaжeм oтвeт сeрвeрa
				console.log('error description: ' + thrownError); // и тeкст oшибки

			}
		});

		// final
		stepPE++;

		if (stop) {
			$('#mass-edit-submit').removeAttr('disabled');

			$('#mass-edit-submit' +' .load-bar').css('display', 'none');

		}

	} while (stop === false);

});

</script>
