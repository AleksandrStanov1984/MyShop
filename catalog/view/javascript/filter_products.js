jQuery(document).ready(function () {
    // разблокируем select
    $('.catalog-item select:disabled').prop('disabled', false);
    // показываем доп параметры по клику на еще
    jQuery('.select_more').on('click', function () {
        $(this).toggleClass("select_more_open");
        $(this).parents('.filter-attr-block').find('.additional-selectors').slideToggle(300);
    });

    // очистить фильтра по клику на кнопку очистить
    jQuery('.sd_reset').click(function () {

        var sd_reset = 1;
        var sd_cat_id = jQuery(this).attr('reset-cat-id');

        ResetSelector(sd_cat_id, sd_reset);

    });
    jQuery('.link-catalog-filter').click(function () {


        var s_cat_id = jQuery(this).attr('data-get-id');

        if ($('#filter-btn-id-' + s_cat_id).attr('active_btn') != 3) {
            return false;
        }

        var sd_cat_id = s_cat_id;
        var s_length = jQuery('#data-get-slength-id-' + s_cat_id).val();
        var s_width = jQuery('#data-get-width-id-' + s_cat_id).val();
        var s_height = jQuery('#data-get-height-id-' + s_cat_id).val();

        if ($('#data-get-material-id-' + s_cat_id).length > 0) {
            var s_material = jQuery('#data-get-material-id-' + s_cat_id).val();
        } else {
            var s_material = 0;
        }

        if ($('#data-get-model-id-' + s_cat_id).length > 0) {
            var s_model = jQuery('#data-get-model-id-' + s_cat_id).val();
        } else {
            var s_model = 0;
        }

        if ($('#data-get-color-id-' + s_cat_id).length > 0) {
            var s_color = jQuery('#data-get-color-id-' + s_cat_id).val();
        } else {
            var s_color = 0;
        }

        if ($('#data-get-weight-id-' + s_cat_id).length > 0) {
            var s_weight = jQuery('#data-get-weight-id-' + s_cat_id).val();
        } else {
            var s_weight = 0;
        }

        if ($('#data-get-thickness-id-' + s_cat_id).length > 0) {
            var s_thickness = jQuery('#data-get-thickness-id-' + s_cat_id).val();
        } else {
            var s_thickness = 0;
        }

        if ($('#data-get-type-id-' + s_cat_id).length > 0) {
            var s_type = jQuery('#data-get-type-id-' + s_cat_id).val();
        } else {
            var s_type = 0;
        }

        if ($('#data-get-series-id-' + s_cat_id).length > 0) {
            var s_series = jQuery('#data-get-series-id-' + s_cat_id).val();
        } else {
            var s_series = 0;
        }

        if ($('#data-get-brand-id-' + s_cat_id).length > 0) {
            var s_brand = jQuery('#data-get-brand-id-' + s_cat_id).val();
        } else {
            var s_brand = 0;
        }

        if ($('#data-get-quantity_shelves-id-' + s_cat_id).length > 0) {
            var s_qnt_shelv = jQuery('#data-get-quantity_shelves-id-' + s_cat_id).val();
        } else {
            var s_qnt_shelv = 0;
        }

        var sd_reset = 1;

        if ($(window).width() < 800) {
            $('#ajax_preloader').show();
        }

        $.ajax({
            type: 'post',
            url: $('base').attr('href') + 'index.php?route=extension/module/featured/getProds',
            dataType: 'html',
            data: jQuery.param({
                's_cat_id': s_cat_id,
                's_height': s_height,
                's_width': s_width,
                's_length': s_length,
                's_material': s_material,
                's_model': s_model,
                's_color': s_color,
                's_weight': s_weight,
                's_thickness': s_thickness,
                's_type': s_type,
                's_series': s_series,
                's_brand': s_brand,
                's_qnt_shelv': s_qnt_shelv
            }),
            beforeSend: function () {
            },
            success: function (htmlText) {
                $('#ajax_preloader').hide();
                $('#product_summary').html(htmlText);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });

        $('.catalog-item').each(function (indx, element) {
            sd_cat_id_full = $(element).attr('id');
            cat_id = sd_cat_id_full.replace(/[^0-9]/g, '');
            ResetSelector(cat_id, 1);
        });
    });

    jQuery('.info_catalog_block').click(function (e) {
        e.stopPropagation();


        var cat_info_id = jQuery(this).attr('info-block-id');

        if ($(window).width() < 800) {
            $('#ajax_preloader').show();
        }

        $.ajax({
            type: 'post',
            url: $('base').attr('href') + 'index.php?route=extension/module/featured/getCatDescriptions',
            dataType: 'html',
            data: jQuery.param({'category_id': cat_info_id}),
            beforeSend: function () {
            },
            success: function (htmlText) {
                $('#ajax_preloader').hide();
                $('#product_summary').html(htmlText);
                $('html').addClass('remodal-is-locked');
                $('.close-popup3').click(function () {
                    $('#overlay-popup3').remove();
                    $('#wraper-popup3').remove();
                    $('html').removeClass('remodal-is-locked');
                });

            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }

        });

    });


    // изменения select
    $('.select-parameter__selector').on('change', function (e) {

        var sd_cat_id = jQuery(this).attr('data-selector-get-cat-id');
        var Param = jQuery(this).attr('data-param');
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;

        console.log(valueSelected);
        var sd_reset = 0;
        var count_sel = $('#filter-btn-id-' + sd_cat_id).attr('active_btn');

        // получаем все выбранные фильтра
        $(this).parents('.filter-attr-block').find('select').each(function (indx, element) {
            var paramSelect = $(element).attr('data-param');
            var optionValueSelected = $(element).find('option:selected').val();

            // проверить
            if (optionValueSelected != '') {
                if (paramSelect == 'width') {
                    setWidth = optionValueSelected;
                }
                if (paramSelect == 'height') {
                    setHeight = optionValueSelected;
                }
                if (paramSelect == 'slength') {
                    setLength = optionValueSelected;
                }
                if (paramSelect == 'material') {
                    setMaterial = optionValueSelected;
                }
                if (paramSelect == 'model') {
                    setModel = optionValueSelected;
                }
                if (paramSelect == 'color') {
                    setColor = optionValueSelected;
                }
                if (paramSelect == 'weight') {
                    setWeight = optionValueSelected;
                }
                if (paramSelect == 'thickness') {
                    setThickness = optionValueSelected;
                }
                if (paramSelect == 'type') {
                    setType = optionValueSelected;
                }
                if (paramSelect == 'series') {
                    setSeries = optionValueSelected;
                }
                if (paramSelect == 'brand') {
                    setBrand = optionValueSelected;
                }
                if (paramSelect == 'quantity_shelves') {
                    setQntShelv = optionValueSelected;
                }
            }

        });

        // очищаем другие фильтра
        $('.catalog-item').each(function (indx, element) {
            sd_cat_id_full = $(element).attr('id');
            cat_id = sd_cat_id_full.replace(/[^0-9]/g, '');
            if (cat_id !== sd_cat_id) {
                ResetSelector(cat_id, 1);
            }
        });

        additionalFilterBlock = $(this).parents('.selector_block').hasClass('additional-selectors');

        if (count_sel == 0 && !additionalFilterBlock) {
            $('#filter-btn-id-' + sd_cat_id).attr("active_btn", "1");
        }

        if (count_sel == 1 && !additionalFilterBlock) {
            $('#filter-btn-id-' + sd_cat_id).attr("active_btn", "2");
        }

        if (count_sel == 2 && !additionalFilterBlock) {
            $('#filter-btn-id-' + sd_cat_id).attr("active_btn", "3");
        }


        // делаем активной кнопку
        if ($('#filter-btn-id-' + sd_cat_id).attr('active_btn') == 3) {

            $('#filter-btn-id-' + sd_cat_id).parents('.podbor').removeClass('podbor_disabled');
            $('#filter-btn-id-' + sd_cat_id).css("background-color", "#fbad25");
            $('#filter-btn-id-' + sd_cat_id).removeAttr("background-image");
            $('#data-get-' + Param + '-id-' + sd_cat_id).addClass("select-parameter__selector sel_disabled");
            $('#data-get-' + Param + '-id-' + sd_cat_id).attr("disabled", "disabled");
            $('#reset-cat-id-' + sd_cat_id).css("display", "inline-block");

            return false;

        }

        $('#data-get-' + Param + '-id-' + sd_cat_id).addClass("select-parameter__selector sel_disabled");
        $('#data-get-' + Param + '-id-' + sd_cat_id).attr("disabled", "disabled");
        $('#reset-cat-id-' + sd_cat_id).css("display", "inline-block");

        // if ($(window).width() < 800) {
            $('#ajax_preloader').show();
        // }

        $.ajax({
            type: 'post',
            url: $('base').attr('href') + 'index.php?route=extension/module/featured/getFilterProducts',
            dataType: 'json',
            data: {
                sd_cat_id: sd_cat_id,
                sd_param: Param,
                sdWidth: (typeof(setWidth) != 'undefined' ? setWidth : 0),
                sdHeight: (typeof(setHeight) != 'undefined' ? setHeight : 0),
                sdLength: (typeof(setLength) != 'undefined' ? setLength : 0),
                sdMaterial: (typeof(setMaterial) != 'undefined' ? setMaterial : 0),
                sdModel: (typeof(setModel) != 'undefined' ? setModel : 0),
                sdColor: (typeof(setColor) != 'undefined' ? setColor : 0),
                sdWeight: (typeof(setWeight) != 'undefined' ? setWeight : 0),
                sdThickness: (typeof(setThickness) != 'undefined' ? setThickness : 0),
                sdType: (typeof(setType) != 'undefined' ? setType : 0),
                sdSeries: (typeof(setSeries) != 'undefined' ? setSeries : 0),
                sdBrand: (typeof(setBrand) != 'undefined' ? setBrand : 0),
                sdQntShelv: (typeof(setQntShelv) != 'undefined' ? setQntShelv : 0),
                sd_value: valueSelected,
                sd_reset: sd_reset
            },
            beforeSend: function () {
            },
            success: function (data) {
                $('#ajax_preloader').hide();

                var $height = $('#data-get-height-id-' + sd_cat_id);
                var $width = $('#data-get-width-id-' + sd_cat_id);
                var $length = $('#data-get-slength-id-' + sd_cat_id);
                console.log(data);

                // проверяем доступные варианты
                availableParam($length, data.aLengthFull, data.aLength, 'slength', Param, valueSelected);
                availableParam($width, data.aWidthFull, data.aWidth, 'width', Param, valueSelected);
                availableParam($height, data.aHeightFull, data.aHeight, 'height', Param, valueSelected);

                if ($('#data-get-material-id-' + sd_cat_id).length > 0) {
                    var $material = $('#data-get-material-id-' + sd_cat_id);
                    availableParam($material, data.aMaterialFull, data.aMaterial, 'material', Param, valueSelected);
                }
                if ($('#data-get-model-id-' + sd_cat_id).length > 0) {
                    var $model = $('#data-get-model-id-' + sd_cat_id);
                    availableParam($model, data.aModelFull, data.aModel, 'model', Param, valueSelected);
                }
                if ($('#data-get-color-id-' + sd_cat_id).length > 0) {
                    var $color = $('#data-get-color-id-' + sd_cat_id);
                    availableParam($color, data.aColorFull, data.aColor, 'color', Param, valueSelected);
                }
                if ($('#data-get-weight-id-' + sd_cat_id).length > 0) {
                    var $weight = $('#data-get-weight-id-' + sd_cat_id);
                    availableParam($weight, data.aWeightFull, data.aWeight, 'weight', Param, valueSelected);
                }
                if ($('#data-get-thickness-id-' + sd_cat_id).length > 0) {
                    var $thickness = $('#data-get-thickness-id-' + sd_cat_id);
                    availableParam($thickness, data.aThicknessFull, data.aThickness, 'thickness', Param, valueSelected);
                }
                if ($('#data-get-type-id-' + sd_cat_id).length > 0) {
                    var $type = $('#data-get-type-id-' + sd_cat_id);
                    availableParam($type, data.aTypeFull, data.aType, 'type', Param, valueSelected);
                }
                if ($('#data-get-series-id-' + sd_cat_id).length > 0) {
                    var $series = $('#data-get-series-id-' + sd_cat_id);
                    availableParam($series, data.aSeriesFull, data.aSeries, 'series', Param, valueSelected);
                }
                if ($('#data-get-brand-id-' + sd_cat_id).length > 0) {
                    var $brand = $('#data-get-brand-id-' + sd_cat_id);
                    availableParam($brand, data.aBrandFull, data.aBrand, 'brand', Param, valueSelected);
                }
                if ($('#data-get-quantity_shelves-id-' + sd_cat_id).length > 0) {
                    var $qnt_shelv = $('#data-get-quantity_shelves-id-' + sd_cat_id);
                    availableParam($qnt_shelv, data.aQntShelvFull, data.aQntShelv, 'quantity_shelves', Param, valueSelected);
                }

            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });


    });

});

function availableParam($param, aParamFull, aParam, attrParam, sendParam, sendValue) {

    if (attrParam !== sendParam) {

        $param.empty();

        for (i in aParamFull) {

            var item = aParamFull[i];
            var flag = false;

            for (j in aParam) {
                var pattern = aParam[j];
                if (item == pattern) {
                    flag = true;
                    break;
                }
            }

            if (flag) {
                $param.append('<option  value=\"' + item + '\">' + item + '</option>');
            } else {
                $param.append('<option style="color: #CCC" disabled="disabled">' + item + '</option>');
            }

        }

        if (!$param.hasClass("sel_disabled")) {
            $param.prepend('<option value="" selected="selected"> — </option>');
        }

    }

}

function ResetSelector(sd_cat_id, sd_reset) {

    // очистка по кнопке очистить
    if (sd_cat_id != 0) {
        $('#data-get-height-id-' + sd_cat_id).removeAttr("disabled").removeAttr("class");
        $('#data-get-width-id-' + sd_cat_id).removeAttr("disabled").removeAttr("class");
        $('#data-get-slength-id-' + sd_cat_id).removeAttr("disabled").removeAttr("class");

        $('#data-get-height-id-' + sd_cat_id).addClass("select-parameter__selector");
        $('#data-get-width-id-' + sd_cat_id).addClass("select-parameter__selector");
        $('#data-get-slength-id-' + sd_cat_id).addClass("select-parameter__selector");

        if ($('#data-get-material-id-' + sd_cat_id).length > 0) {
            $('#data-get-material-id-' + sd_cat_id).removeAttr("disabled").removeAttr("class");
            $('#data-get-material-id-' + sd_cat_id).addClass("select-parameter__selector");
        }

        if ($('#data-get-model-id-' + sd_cat_id).length > 0) {
            $('#data-get-model-id-' + sd_cat_id).removeAttr("disabled").removeAttr("class");
            $('#data-get-model-id-' + sd_cat_id).addClass("select-parameter__selector");
        }

        if ($('#data-get-color-id-' + sd_cat_id).length > 0) {
            $('#data-get-color-id-' + sd_cat_id).removeAttr("disabled").removeAttr("class");
            $('#data-get-color-id-' + sd_cat_id).addClass("select-parameter__selector");
        }

        if ($('#data-get-weight-id-' + sd_cat_id).length > 0) {
            $('#data-get-weight-id-' + sd_cat_id).removeAttr("disabled").removeAttr("class");
            $('#data-get-weight-id-' + sd_cat_id).addClass("select-parameter__selector");
        }

        if ($('#data-get-thickness-id-' + sd_cat_id).length > 0) {
            $('#data-get-thickness-id-' + sd_cat_id).removeAttr("disabled").removeAttr("class");
            $('#data-get-thickness-id-' + sd_cat_id).addClass("select-parameter__selector");
        }

        if ($('#data-get-type-id-' + sd_cat_id).length > 0) {
            $('#data-get-type-id-' + sd_cat_id).removeAttr("disabled").removeAttr("class");
            $('#data-get-type-id-' + sd_cat_id).addClass("select-parameter__selector");
        }

        if ($('#data-get-series-id-' + sd_cat_id).length > 0) {
            $('#data-get-series-id-' + sd_cat_id).removeAttr("disabled").removeAttr("class");
            $('#data-get-series-id-' + sd_cat_id).addClass("select-parameter__selector");
        }

        if ($('#data-get-brand-id-' + sd_cat_id).length > 0) {
            $('#data-get-brand-id-' + sd_cat_id).removeAttr("disabled").removeAttr("class");
            $('#data-get-brand-id-' + sd_cat_id).addClass("select-parameter__selector");
        }

        if ($('#data-get-quantity_shelves-id-' + sd_cat_id).length > 0) {
            $('#data-get-quantity_shelves-id-' + sd_cat_id).removeAttr("disabled").removeAttr("class");
            $('#data-get-quantity_shelves-id-' + sd_cat_id).addClass("select-parameter__selector");
        }

        $('#filter-btn-id-' + sd_cat_id).parents('.podbor').addClass('podbor_disabled');
        $('#filter-btn-id-' + sd_cat_id).css("background-color", "#CCCCCC");
        $('#filter-btn-id-' + sd_cat_id).attr("active_btn", "0");
    }

    // очистка селекторов
    $.ajax({
        type: 'post',
        url: $('base').attr('href') + 'index.php?route=extension/module/featured/getFilterProducts',
        dataType: 'json',
        data: jQuery.param({'sd_reset': sd_reset, 'sd_cat_id': sd_cat_id}),
        beforeSend: function () {
        },
        success: function (data) {
            $("#reset-cat-id-" + sd_cat_id).hide();
            var $height = $('#data-get-height-id-' + sd_cat_id);
            var $width = $('#data-get-width-id-' + sd_cat_id);
            var $length = $('#data-get-slength-id-' + sd_cat_id);

            if ($('#data-get-material-id-' + sd_cat_id).length > 0) {
                var $material = $('#data-get-material-id-' + sd_cat_id);
                var aMaterialFull = data.aMaterialFull;
            }
            if ($('#data-get-model-id-' + sd_cat_id).length > 0) {
                var $model = $('#data-get-model-id-' + sd_cat_id);
                var aModelFull = data.aModelFull;
            }
            if ($('#data-get-color-id-' + sd_cat_id).length > 0) {
                var $color = $('#data-get-color-id-' + sd_cat_id);
                var aColorFull = data.aColorFull;
            }
            if ($('#data-get-weight-id-' + sd_cat_id).length > 0) {
                var $weight = $('#data-get-weight-id-' + sd_cat_id);
                var aWeightFull = data.aWeightFull;
            }
            if ($('#data-get-thickness-id-' + sd_cat_id).length > 0) {
                var $thickness = $('#data-get-thickness-id-' + sd_cat_id);
                var aThicknessFull = data.aThicknessFull;
            }
            if ($('#data-get-type-id-' + sd_cat_id).length > 0) {
                var $type = $('#data-get-type-id-' + sd_cat_id);
                var aTypeFull = data.aTypeFull;
            }
            if ($('#data-get-series-id-' + sd_cat_id).length > 0) {
                var $series = $('#data-get-series-id-' + sd_cat_id);
                var aSeriesFull = data.aSeriesFull;
            }
            if ($('#data-get-brand-id-' + sd_cat_id).length > 0) {
                var $brand = $('#data-get-brand-id-' + sd_cat_id);
                var aBrandFull = data.aBrandFull;
            }
            if ($('#data-get-quantity_shelves-id-' + sd_cat_id).length > 0) {
                var $qnt_shelv = $('#data-get-quantity_shelves-id-' + sd_cat_id);
                var aQntShelvFull = data.aQntShelvFull;
            }

            var aHeightFull = data.aHeightFull;
            var aWidthFull = data.aWidthFull;
            var aLengthFull = data.aLengthFull;
            var Param_sended = data.Param_sended;

            $height.empty();
            $width.empty();
            $length.empty();

            $.each(aHeightFull, function (key, val) {
                $height.append('<option value=\"' + val + '\">' + val + '</option>');
            });
            $.each(aWidthFull, function (key, val) {
                $width.append('<option  value=\"' + val + '\">' + val + '</option>');
            });
            $.each(aLengthFull, function (key, val) {
                $length.append('<option value=\"' + val + '\">' + val + '</option>');
            });

            $('#data-get-height-id-' + sd_cat_id).prepend('<option value="" selected="selected"> — </option>');
            $('#data-get-width-id-' + sd_cat_id).prepend('<option value="" selected="selected"> — </option>');
            $('#data-get-slength-id-' + sd_cat_id).prepend('<option value="" selected="selected"> — </option>');

            if ($('#data-get-material-id-' + sd_cat_id).length > 0) {
                $material.empty();
                $.each(aMaterialFull, function (key, val) {
                    $material.append('<option value=\"' + val + '\">' + val + '</option>');
                });
                $('#data-get-material-id-' + sd_cat_id).prepend('<option value="" selected="selected"> — </option>');
            }
            if ($('#data-get-model-id-' + sd_cat_id).length > 0) {
                $model.empty();
                $.each(aModelFull, function (key, val) {
                    $model.append('<option value=\"' + val + '\">' + val + '</option>');
                });
                $('#data-get-model-id-' + sd_cat_id).prepend('<option value="" selected="selected"> — </option>');
            }
            if ($('#data-get-color-id-' + sd_cat_id).length > 0) {
                $color.empty();
                $.each(aColorFull, function (key, val) {
                    $color.append('<option value=\"' + val + '\">' + val + '</option>');
                });
                $('#data-get-color-id-' + sd_cat_id).prepend('<option value="" selected="selected"> — </option>');
            }
            if ($('#data-get-weight-id-' + sd_cat_id).length > 0) {
                $weight.empty();
                $.each(aWeightFull, function (key, val) {
                    $weight.append('<option value=\"' + val + '\">' + val + '</option>');
                });
                $('#data-get-weight-id-' + sd_cat_id).prepend('<option value="" selected="selected"> — </option>');
            }
            if ($('#data-get-thickness-id-' + sd_cat_id).length > 0) {
                $thickness.empty();
                $.each(aThicknessFull, function (key, val) {
                    $thickness.append('<option value=\"' + val + '\">' + val + '</option>');
                });
                $('#data-get-thickness-id-' + sd_cat_id).prepend('<option value="" selected="selected"> — </option>');
            }

            if ($('#data-get-type-id-' + sd_cat_id).length > 0) {
                $type.empty();
                $.each(aTypeFull, function (key, val) {
                    $type.append('<option value=\"' + val + '\">' + val + '</option>');
                });
                $('#data-get-type-id-' + sd_cat_id).prepend('<option value="" selected="selected"> — </option>');
            }

            if ($('#data-get-series-id-' + sd_cat_id).length > 0) {
                $series.empty();
                $.each(aSeriesFull, function (key, val) {
                    $series.append('<option value=\"' + val + '\">' + val + '</option>');
                });
                $('#data-get-series-id-' + sd_cat_id).prepend('<option value="" selected="selected"> — </option>');
            }

            if ($('#data-get-brand-id-' + sd_cat_id).length > 0) {
                $brand.empty();
                $.each(aBrandFull, function (key, val) {
                    $brand.append('<option value=\"' + val + '\">' + val + '</option>');
                });
                $('#data-get-brand-id-' + sd_cat_id).prepend('<option value="" selected="selected"> — </option>');
            }

            if ($('#data-get-quantity_shelves-id-' + sd_cat_id).length > 0) {
                $qnt_shelv.empty();
                $.each(aQntShelvFull, function (key, val) {
                    $qnt_shelv.append('<option value=\"' + val + '\">' + val + '</option>');
                });
                $('#data-get-quantity_shelves-id-' + sd_cat_id).prepend('<option value="" selected="selected"> — </option>');
            }

            $(this).parents('.filter-attr-block').find('.additional-selectors').hide(300);

            if (typeof(setWidth) != 'undefined') {
                setWidth = null;
            }
            if (typeof(setHeight) != 'undefined') {
                setHeight = null;
            }
            if (typeof(setLength) != 'undefined') {
                setLength = null;
            }
            if (typeof(setMaterial) != 'undefined') {
                setMaterial = null;
            }
            if (typeof(setModel) != 'undefined') {
                setModel = null;
            }
            if (typeof(setColor) != 'undefined') {
                setColor = null;
            }
            if (typeof(setWeight) != 'undefined') {
                setWeight = null;
            }
            if (typeof(setThickness) != 'undefined') {
                setThickness = null;
            }
            if (typeof(setType) != 'undefined') {
                setType = null;
            }
            if (typeof(setSeries) != 'undefined') {
                setSeries = null;
            }
            if (typeof(setBrand) != 'undefined') {
                setBrand = null;
            }
            if (typeof(setQntShelv) != 'undefined') {
                setQntShelv = null;
            }
            if (typeof(additionalFilterBlock) != 'undefined') {
                additionalFilterBlock = null;
            }
        }
    });
}
