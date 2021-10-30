<?php // for Centos correct file association ?>
<script>

/* Dynamic Content by Ajax
----------------------------------------------------------------------------- */

// Если не блокировать всю страницу, а только место, где должна появлятсья таблица.
// Использовалось
// При ожидании первичной загрузки динамического контента
// Фильтрация товаров
// При добавлении новых рядов товара - фильтрация товаров
// При удалении товаров


/*
function dynamicContentloaderOn() {
  //$('.dynamic-content-load-bar').fadeOut('normal').html('');
  $('.dynamic-content-load-bar').addClass('_active');
	//$('.dynamic-content-load-bar').fadeIn('normal');
}

function dynamicContentloaderOff() {
	//$('.dynamic-content-load-bar').fadeOut('normal', function() {
	//	$('.dynamic-content-load-bar').removeClass('_active');
	//});
	$('.dynamic-content-load-bar').removeClass('_active');
}
*/

function dynamicUpdate(url){
	//dynamicContentloaderOn();
	loaderOn();

	// https://habr.com/sandbox/43096/

	$.get(url, function(data) {
		//$('#dynamic-content').fadeOut('normal'); // если использовать отельную иконку dynamicContentloader
		$('#dynamic-content').html(data);
		//$('#dynamic-content').fadeIn('normal'); // если использовать отельную иконку dynamicContentloader

		initImageSorting(false);
		initDrugNDrop();
		//initLiveUpdateOnHoverOut();
		initCategoryTree();
		initButtonCalendar();

//		$('.tinymce').each(function() {
//			tinyMCE.execCommand('mceRemoveEditor', false, $(this).attr('id'));
//		});
//
//		setTimeout(function() {
//				tinyMCEInit();
//		}, 300);

		initAttributeValueSelectors();
		liveUpdateAttributeValueSelector();
		initArrows();

		scrollCurrentProductId = largest_product_id; // for scroll arrows

		//dynamicContentloaderOff();

		loaderOff();
	});
}

$(document).ready(function() {
	filtering();
});




/* Filter
----------------------------------------------------------------------------- */
$('#button-filter').click(function() {
  filtering();
});

function filtering(flag, pageTo) {
	if (undefined === flag) {
		flag = false;
	}

	if (undefined === pageTo) {
		pageTo = false;
	}

	var urlQueryString = 'index.php?route=extension/module/handy_product_manager/productList&token=<?=$token?>';
	var urlLoad = 'index.php?route=extension/module/handy_product_manager/productListDynamicContent&token=<?=$token?>';
	var urlParams = '';

	if ('reset_filter' != flag) {
		var filter_name = $('input[name=\'filter_name\']').val();
		if (filter_name) {
			urlParams += '&filter_name=' + encodeURIComponent(filter_name);
		}

		var filter_product_id = $('input[name=\'filter_product_id\']').val();
		if (filter_product_id) {
			urlParams += '&filter_product_id=' + encodeURIComponent(filter_product_id);
		}

		var filter_sku = $('input[name=\'filter_sku\']').val();
		if (filter_sku) {
			urlParams += '&filter_sku=' + encodeURIComponent(filter_sku);
		}

		var filter_model = $('input[name=\'filter_model\']').val();
		if (filter_model) {
			urlParams += '&filter_model=' + encodeURIComponent(filter_model);
		}

		var filter_keyword = $('input[name=\'filter_keyword\']').val();
		if (filter_keyword) {
			urlParams += '&filter_keyword=' + encodeURIComponent(filter_keyword);
		}

		<?php if ($has_main_category_column) { ?>
		var filter_category_main = $('select[name=\'filter_category_main\']').val();
		if (filter_category_main != '*') {
			urlParams += '&filter_category_main=' + encodeURIComponent(filter_category_main);
		}
		<?php } ?>

		var filter_category = $('select[name=\'filter_category\']').val();
		if (filter_category != '*') {
			urlParams += '&filter_category=' + encodeURIComponent(filter_category);
		}

		var filter_manufacturer = $('select[name=\'filter_manufacturer\']').val();
		if (filter_manufacturer != '*') {
			urlParams += '&filter_manufacturer=' + encodeURIComponent(filter_manufacturer);
		}

		var filter_price_min = $('input[name=\'filter_price_min\']').val();
		if (filter_price_min) {
			urlParams += '&filter_price_min=' + encodeURIComponent(filter_price_min);
		}

		var filter_price_max = $('input[name=\'filter_price_max\']').val();
		if (filter_price_max) {
			urlParams += '&filter_price_max=' + encodeURIComponent(filter_price_max);
		}

		var filter_quantity_min = $('input[name=\'filter_quantity_min\']').val();
		if (filter_quantity_min) {
			urlParams += '&filter_quantity_min=' + encodeURIComponent(filter_quantity_min);
		}

		var filter_quantity_max = $('input[name=\'filter_quantity_max\']').val();
		if (filter_quantity_max) {
			urlParams += '&filter_quantity_max=' + encodeURIComponent(filter_quantity_max);
		}

		var filter_attribute = $('select[name=\'filter_attribute\']').val();
		if (filter_attribute != '*') {
			urlParams += '&filter_attribute=' + encodeURIComponent(filter_attribute);
		}

		var filter_attribute_value = $('select[name=\'filter_attribute_value\']').val();
		if (filter_attribute_value != '*' && flag != 'remove_filter_attribute_value') {
			urlParams += '&filter_attribute_value=' + encodeURIComponent(filter_attribute_value);
		}

		var filter_status = $('select[name=\'filter_status\']').val();
		if (filter_status != '*') {
			urlParams += '&filter_status=' + encodeURIComponent(filter_status);
		}

		var filter_image = $('select[name=\'filter_image\']').val();
		if (filter_image != '*') {
			urlParams += '&filter_image=' + encodeURIComponent(filter_image);
		}
	} else {
		// Сбросить все параметры фильтров, ведь это будет стартовая страница фильтра
		$('.filter-container input').each(function() {
			$(this).val('');
		});

		$('.filter-container select').each(function() {
			$(this).val($(this).children('option:first').val());
		});
	}

	// При вызове filter() всегда нужно подменять страницу до 1
	// Исключение - переход по пейджинации

	//urlParams += '&page=1';

	if ('changePageByPagination' == flag && pageTo) {
		if (test_mode) {
			console.log('filtering() : сработало if (\'changePageByPagination\' == flag && pageTo)');
		}
		urlParams += '&page=' + pageTo;
	}

	if (test_mode) {
		console.log('filtering() urlParams : ' + urlParams);
	}

	// Подменяем action при удалении
	$('#form-product').attr('action', '<?=HTTPS_SERVER?>index.php?route=extension/module/handy_product_manager/delete&token=<?=$token?>' + urlParams);
	$('#btn-copy').attr('formaction', '<?=HTTPS_SERVER?>index.php?route=extension/module/handy_product_manager/copy&token=<?=$token?>' + urlParams);



	// Ждем, чтобы автозаполнение успело примениться - при клике на предложенный вариант
	setTimeout(function () {
		try {
			history.replaceState(null, null, location.href); // Q-A - а зачем тогда это нужно?
			history.pushState(null, null, urlQueryString + urlParams);
		} catch(e) {
			alert('Some problem with URL history.pushState');
		}

		<?php if(!$output) { ?>
		  dynamicUpdate(urlLoad + urlParams);
		<?php } ?>
	}, 200); // Задержка

};


// if push Back after filtering()
addEventListener("popstate",function(e){
	// По факту не обновляет страницу, а только меняет URL
	// window.history.back(); Переводит прям на первую естественным образом открытую страницу, без параметров фильтрации, к-ые были заданы в history.replaceState // Q-A

	location.href = location.href; // Редирект - застравляет загрузить страницу заново, а не просто подменить URL

	//filtering(); // Обновляет только динамический контент стало быть не вписывает в фильтре данных из $_GET...
}, false);



// Autocomplete

// Autocomplete Customized */
(function($) {
	$.fn.autocomplete2 = function(option) {
		return this.each(function() {
			var $this = $(this);
			var $dropdown = $('<ul class="dropdown-menu" />');

			this.timer = null;
			this.items = [];

			$.extend(this, option);

			$this.attr('autocomplete', 'off');

			// Focus
			$this.on('focus', function() {
				//this.request();
			});

			// Blur
			$this.on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);
			});

			// Keydown
			$this.on('keydown', function(event) {
				switch(event.keyCode) {
					case 27: // escape
						this.hide();
						break;
					default:
						this.request();
						break;
				}
			});

			// Click
			this.click = function(event) {
				event.preventDefault();

				var value = $(event.target).parent().attr('data-value');

				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}

			// Show
			this.show = function() {
				var pos = $this.position();

				$dropdown.css({
					top: pos.top + $this.outerHeight(),
					left: pos.left
				});

				$dropdown.show();
			}

			// Hide
			this.hide = function() {
				$dropdown.hide();
			}

			// Request
			this.request = function() {
				clearTimeout(this.timer);

				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}

			// Response
			this.response = function(json) {
				var html = '';
				var category = {};
				var name;
				var i = 0, j = 0;

				if (json.length) {
					for (i = 0; i < json.length; i++) {
						// update element items
						this.items[json[i]['value']] = json[i];

						if (!json[i]['category']) {
							// ungrouped items
							html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
						} else {
							// grouped items
							name = json[i]['category'];
							if (!category[name]) {
								category[name] = [];
							}

							category[name].push(json[i]);
						}
					}

					for (name in category) {
						html += '<li class="dropdown-header">' + name + '</li>';

						for (j = 0; j < category[name].length; j++) {
							html += '<li data-value="' + category[name][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[name][j]['label'] + '</a></li>';
						}
					}
				}

				if (html) {
					this.show();
				} else {
					this.hide();
				}

				$dropdown.html(html);
			}

			$dropdown.on('click', '> li > a', $.proxy(this.click, this));
			$this.after($dropdown);
		});
	}
})(window.jQuery);

/*
$('input[name=\'filter_name\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=extension/module/handy_product_manager/productAutocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_name\']').val(item['label']);
	}
});
*/

$('input[name=\'filter_name\']').autocomplete2({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=extension/module/handy_product_manager/productAutocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_name\']').val(item['label']);
		$('input[name=\'filter_name\']').trigger('change');
	}
});

$('input[name=\'filter_model\']').autocomplete2({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=extension/module/handy_product_manager/productAutocomplete&token=<?php echo $token; ?>&filter_model=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['model'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_model\']').val(item['label']);
    $('input[name=\'filter_model\']').trigger('change');

	}
});

$('input[name=\'filter_sku\']').autocomplete2({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=extension/module/handy_product_manager/productAutocomplete&token=<?php echo $token; ?>&filter_sku=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['sku'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_sku\']').val(item['label']);
    $('input[name=\'filter_sku\']').trigger('change');
	}
});


// Filter On Change

/*
$('input[name=\'filter_name\']').on('keyup', function(e){
  filtering();
});
*/
/*
$('input[name=\'filter_name\']').on('change', function(e){
  filtering();
});

$('input[name=\'filter_model\']').on('change', function(e){
  $('input[name=\'filter_name\']').val('');
  $('input[name=\'filter_sku\']').val('');
  $('input[name=\'filter_keyword\']').val('');

  filtering();
});

$('input[name=\'filter_sku\']').on('change', function(e){
  $('input[name=\'filter_name\']').val('');
  $('input[name=\'filter_model\']').val('');
  $('input[name=\'filter_keyword\']').val('');

  filtering();
});

$('input[name=\'filter_keyword\']').on('change', function(e){
  $('input[name=\'filter_name\']').val('');
  $('input[name=\'filter_sku\']').val('');
  $('input[name=\'filter_model\']').val('');

  filtering();
});

$('select[name=\'filter_category_main\']').on('change', function(e){
  filtering();
});
*/

$('.filter-field').on('change', function(e){
  var name = $(this).attr('name');

  if ('filter_name' == name || 'filter_product_id' == name || 'filter_sku' == name || 'filter_model' == name || 'filter_keyword' == name) {
    if ('filter_name' != name) $('input[name=\'filter_name\']').val('');
    if ('filter_product_id' != name) $('input[name=\'filter_product_id\']').val('');
    if ('filter_sku' != name) $('input[name=\'filter_sku\']').val('');
    if ('filter_model' != name) $('input[name=\'filter_model\']').val('');
    if ('filter_keyword' != name) $('input[name=\'filter_keyword\']').val('');
  }

	//filtering();

});


// Btn Remove Filter Value
$('body').on('click', '.remove-filter', function(e) {
  if ('' != $('input[name=\'filter_' + $(this).data('target') + '\']').val()) {
    $('input[name=\'filter_' + $(this).data('target') + '\']').val('');

    //filtering();
  }
});


// Attributes for filter
$(function() {
  var filterAttributeId = $('#input-attribute').val();

	if (test_mode) {
		console.log('filterAttributeId : ' + filterAttributeId);
	}

	if ('*' != filterAttributeId && 'notset' != filterAttributeId) {
		getAttributeValuedForFilter(filterAttributeId, $('#input-attribute-value').data('filter-attribut-value'));
	}
});

$('body').on('change', '#input-attribute', function() {
	var attributeId = $(this).val();

	getAttributeValuedForFilter(attributeId, false);

	//filtering('remove_filter_attribute_value');
});

function getAttributeValuedForFilter(attributeId, filterAttributeValue) {
	if (test_mode) {
		console.log('getAttributeValuedForFilter() filterAttributeValue : ' + filterAttributeValue);
	}

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
					selected = '';
					selected = filterAttributeValue == data[key]['text'] ? 'selected="selected"' : '';
					html += '<option value="' + data[key]['text'] + '"' + selected +'>' + data[key]['text'] + '</option>';
					i++;
				}
				if(0 === i) {
					html += '<option value=""><?=$hpm_text_attribute_values_empty?></option>';
				} else {
					html = '<option value=""><?=$hpm_text_attribute_values_select?></option>' + html;
				}

				$('#input-attribute-value').html(html);

			} else {
				if (test_mode) {
					console.log('error on attribute selector get attribute values: ' + '#input-attribute');
				}
			}
		},
		error: function( jqXHR, textStatus, errorThrown ){
			// Error ajax query
			console.log('AJAX query Error on #input-attribute: ' + textStatus );
		},
	});
}



/* Pagination
----------------------------------------------------------------------------- */
$('body').on('click', '.hpm-pagination .pagination a', function(e){
	e.preventDefault();

	var pageTo = false;
	var link = $(this).attr('href');
	var pos = link.indexOf('page=');

	if (-1 != pos) {
		pos = pos + 5;
		pageTo = Number(link.substring(pos));
	} else {
		pageTo = 1;
	}

	console.log('.hpm-pagination  .pagination a click() pageTo : ' + pageTo);

	$('html, body').animate({ scrollTop: $('#content').offset().top}, 0); // scroll to top on pagination

	filtering('changePageByPagination', pageTo);
});

</script>
