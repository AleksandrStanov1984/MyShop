$('body').on('click', '#activatescript', function(){
    initLocale();
    // calculation is performed when any slider or .numeric-input changes it's value
    initElements();
    calcChange(); // initial calculation
});
var initLocale = function () {
        //var curLoc = window.navigator.language || navigator.language;
        if (lang[curLang] == undefined) {
            curLang = 'RU';
        }
        $("#stPpTitle").html(lang[curLang].stpp_title);
        $("#ipTitle").html(lang[curLang].ip_title);
        $("#ppdpTitle").html(lang[curLang].ppdp_title);
        $("#ppTitle").html(lang[curLang].pp_title);

        $(".holder-phys").find('span').html(lang[curLang].amount);
        $(".holder-jur").find('span').html(lang[curLang].compensation);

        $(".result-additional-data-phys").text(lang[curLang].hrn_per_month);
        $(".result-additional-data-jur").text(lang[curLang].hrn);

        var term = $("#term");
        term.find(".legend").html(lang[curLang].term);
        term.find(".additional-data").html(lang[curLang].month);

        var term = $("#term2");
        term.find(".legend").html(lang[curLang].term);
        term.find(".additional-data2").html(lang[curLang].month);

        $("#paymentsCount").html("2");
        $(".payments").html(lang[curLang].payments);
		$(".ppcost").html(lang[curLang].ppcost);

        var price = $("#price");
        price.find(".legend").html(lang[curLang].price);
        price.find(".additional-data").html(lang[curLang].hrn);
        $(".showRateSheet").html(lang[curLang].showTariff);
        $("#printRateSheet").html(lang[curLang].printRateSheet);
};

initElements = function () {
    // term slider
    initTermSlider();
	initTermSlider2();

    // price slider
    initPriceSlider();

    // inputs
    $(".numeric-input").keypress(function (evt) {
        var theEvent = evt || window.event;
        var code = theEvent.keyCode || theEvent.which;
        if(code == 37 || code == 39 || code == 8) {
            return;
        }
        var key = String.fromCharCode( code );
        var regex = /[0-9]/;
        if(!regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
        }

    });
    $(".numeric-input").keyup(function () {
            $(this).trigger('update');

    });


    initTermInput();
	initTermInput2();

    initPriceInput();
	initPriceInput2();
},

initTermSlider = function () {
    $("#termSlider").slider({
        value: constants.termMin,
        max: constants.termMax,
        min: constants.termMin,
        step: constants.termStep,
        slide: function (event, ui) {
            sliderMoved($(this), $("#termInput"), $("#termProgress"), ui.value);
        }
    });
},

initTermSlider2 = function () {
    $("#termSlider2").slider({
        value: constants.termMin2,
        max: constants.termMax2,
        min: constants.termMin2,
        step: constants.termStep2,
        slide: function (event, ui) {
            sliderMoved($(this), $("#termInput2"), $("#termProgress2"), ui.value);
        }
    });
},

initPriceSlider = function () {
    $("#priceSlider").slider({
        value: constants.priceMin,
        max: constants.priceMax,
        min: constants.priceMin,
        step: constants.priceStep,
        slide: function (event, ui) {
            sliderMoved($(this), $("#priceInput"), $("#priceProgress"), ui.value);
        }
    });
},

initTermInput = function () {
    var $inp = $("#termInput");
    $inp.attr("min", constants.termMin);
    $inp.attr("max", constants.termMax);
    $inp.val(constants.termMin);

    $inp.on('change', function () {
        inputChanged($inp, $("#termSlider"), $("#termProgress"));
		
		partsCounArr = {partsCount: $('#termInput').val()};        
        $.ajax({
            type: 'POST',
            url: 'index.php?route=extension/payment/privatbank_paymentparts_ii/setPrivatType',
            dataType: 'json',
            data: partsCounArr,

			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}		     
        });
        return false;  
    });

},

initTermInput2 = function () {
    var $inp = $("#termInput2");
    $inp.attr("min", constants.termMin2);
    $inp.attr("max", constants.termMax2);
    $inp.val(constants.termMin2);

    $inp.on('change', function () {
        inputChanged($inp, $("#termSlider2"), $("#termProgress2"));
		
		partsCounArr = {partsCount: $('#termInput2').val()};        
        $.ajax({
            type: 'POST',
            url: 'index.php?route=extension/payment/privatbank_paymentparts_pp/setPrivatType',
            dataType: 'json',
            data: partsCounArr,

			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}		     
        });
        return false;
    });
},

initPriceInput = function () {
    var $inp = $("#priceInput");
    $inp.attr("min", constants.priceMin);
    $inp.attr("max", constants.priceMax);
    $inp.val(constants.priceInitial);

    $inp.on('update', function () {
        inputChanged($inp, $("#priceSlider"), $("#priceProgress"));
    });

},
initPriceInput2 = function () {
    var $inp = $("#priceInput2");
    $inp.attr("min", constants.priceMin2);
    $inp.attr("max", constants.priceMax2);
    $inp.val(constants.priceInitial2);

    $inp.on('update', function () {
        inputChanged($inp, $("#priceSlider2"), $("#priceProgress2"));
    });

},
/////////////
sliderMoved = function (slider, inputToChange, progressToChange, newValue) {
    var sMax = slider.slider("option", "max");
    var sMin = slider.slider("option", "min");
    inputToChange.val(newValue);

    var progress = (newValue - sMin) * 100 / ( sMax - sMin );
    progressToChange.css('width', progress + "%");
    calcChange();
},

inputChanged = function (input, slider, progressToChange) {
    validateInput(input);
    var newVal = input.val();
    slider.slider("value", newVal);
    var sMax = slider.slider("option", "max");
    var sMin = slider.slider("option", "min");
    var progress = (newVal - sMin) * 100 / ( sMax - sMin );
    progressToChange.css('width', progress + "%");
    calcChange();
},

validateInput = function (input) {
    var min = parseInt(input.attr("min"), 10);
    var max = parseInt(input.attr("max"), 10);
    var val = parseInt(input.val(), 10);
    if (val < 1) input.val(min); // or client won't have a chance to enter number < 10
    if (val > max) input.val(max);
},

calcChange = function(){
    if( $('#stPpResult').html() )
        return calcJur();
    else
        return calcPhys();
},
declOfNum = function(number, titles) {  
    cases = [2, 0, 1, 1, 1, 2];  
    return titles[ (number%100>7 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];  
},
calcPhys = function(){
    var resCalc = PP_CALCULATOR.calculatePhys($('#termInput').val(), $('#priceInput').val());
	var resCalc2 = PP_CALCULATOR.calculatePhys($('#termInput2').val(), $('#priceInput2').val());
	
    if (resCalc != undefined) {
		$('#paymentsCount').html(resCalc.payCount);
		$('#paymentsCountcart').html(resCalc.payCount + ' ' + declOfNum(resCalc.payCount,lang[curLang].paymentscart));
		$('#ipResultValue').html(resCalc.ipValue);
	}

	if (resCalc2 != undefined) {
		$('#paymentsCount2').html(resCalc2.payCount);
		$('#paymentsCount2cart').html(resCalc2.payCount + ' ' + declOfNum(resCalc2.payCount,lang[curLang].paymentscart));
		$('#ppResultValue').html(resCalc2.ppValue);
	}
},

calcJur = function(){
    var resCalc = PP_CALCULATOR.calculateJur($('#termInput').val(), $('#priceInput').val());
	var resCalc2 = PP_CALCULATOR.calculateJur($('#termInput2').val(), $('#priceInput2').val());

    if(resCalc.ppValue == 0.00 && resCalc.ppValueHint == '0.00')
        $('#ppResult').addClass("disabled");
    else
        $('#ppResult').removeClass("disabled");

    $('#ppResultHint').html(resCalc.ppValueHint);
    $('#stPpResultValue').html(resCalc.stPpValue);
    $('#paymentsCount').html(resCalc.payCount);
    $('#ipResultValue').html(resCalc.ipValue);
    $('#ppResultValue').html(resCalc2.ppValue);
},
lang = {
    ru: {
        stpp_title: 'Оплата частями<br/>(стандартная)',
        ppdp_title: 'Оплата частями<br/>(деньги в периоде)',
        pp_title: '«Оплата частями»',
        ip_title: '«Мгновенная рассрочка»',
        amount: 'Сумма платежа',
        hrn_per_month: 'грн/мес',
        term: 'Срок кредитования',
        price: 'Стоимость товара',
		ppcost: 'Стоимость товара',
        month: 'месяцев',
        payments: 'платежей',
		paymentscart: ['платеж','платежа','платежей'],
        hrn: 'гривен',
        compensation: 'Сумма возмещения',
        showTariff: 'Посмотреть тарифную сетку',
        printRateSheet: 'Распечатать'
    },
    uk: {
        stpp_title: 'Оплата частинами<br/>(стандартна)',
        ppdp_title: 'Оплата частинами<br/>(гроші в періоді)',
        pp_title: '«Оплата частинами»',
        ip_title: '«Миттєва розстрочка»',
        amount: 'Сума платежу',
        hrn_per_month: 'грн/міс',
        term: 'Строк кредитування',
        price: 'Вартість товару',
		ppcost: 'Вартість товару',
        month: 'місяців',
        payments: 'платежів',
		paymentscart: ['платіж','платежі','платежів'],
        hrn: 'Гривень',
        compensation: 'Сума відшкодування',
        showTariff: 'Переглянути тарифи',
        printRateSheet: 'Роздрукувати'
    },
    ua: {
        stpp_title: 'Оплата частинами<br/>(стандартна)',
        ppdp_title: 'Оплата частинами<br/>(гроші в періоді)',
        pp_title: '«Оплата частинами»',
        ip_title: '«Миттєва розстрочка»',
        amount: 'Сума платежу',
        hrn_per_month: 'грн/міс',
        term: 'Строк кредитування',
        price: 'Вартість товару',
		ppcost: 'Вартість товару',
        month: 'місяців',
        payments: 'платежів',
		paymentscart: ['платіж','платежі','платежів'],
        hrn: 'Гривень',
        compensation: 'Сума відшкодування',
        showTariff: 'Переглянути тарифи',
        printRateSheet: 'Роздрукувати'
    }
},
PP_CALCULATOR = (function () {
    var my = {};
    var commissions = {
        ipCommission: 2.9,
        acqCommission: 0.02,
        ppCommission: 0.015
    };
    function privParseInt(num) {
        return parseInt(num, 10)
    }
    function getValByTerm(term) {
        var commissions = {
            1: 0.015,
            2: 0.025,
            3: 0.045,
            4: 0.07,
            5: 0.09,
            6: 0.115,
            7: 0.135,
            8: 0.155,
            9: 0.165,
            10: 0.17,
            11: 0.175,
            12: 0.19,
            13: 0.205,
            14: 0.22,
            15: 0.235,
            16: 0.245,
            17: 0.26,
            18: 0.27,
            19: 0.285,
            20: 0.295,
            21: 0.31,
            22: 0.32,
            23: 0.33,
            24: 0.345
        };
        return commissions[term];
    }
    function ipagetValByTerm(term) {
        var ipacommissions = {
            1: 0.015,
            2: 0.025,
            3: 0.045,
            4: 0.064,
            5: 0.076,
            6: 0.082,
            7: 0.087,
            8: 0.097,
            9: 0.106,
            10: 0.116,
            11: 0.122,
            12: 0.125,
            13: 0.128,
            14: 0.131,
            15: 0.134,
            16: 0.137,
            17: 0.14,
            18: 0.143,
            19: 0.147,
            20: 0.155,
            21: 0.162,
            22: 0.17,
            23: 0.176,
            24: 0.183
        };
        return ipacommissions[term];
    }
    my.calculatePhys = function (paymentsCount, price) {
        if (isNaN(paymentsCount) || isNaN(price)) return;
        paymentsCount = privParseInt(paymentsCount) + 1;
        price = privParseInt(price);
        var ip = price / paymentsCount + price * (commissions.ipCommission / 100);
        var pp = price / paymentsCount;
        var ipa = (price / paymentsCount) + (price * 0.99 / 100);
        return ({
            payCount: paymentsCount,
            ipValue: ip.toFixed(2),
            ipaValue: ipa.toFixed(2),
            ppValue: pp.toFixed(2)
        });
    };
    my.calculateJur = function (paymentsCount, price) {
        if (isNaN(paymentsCount) || isNaN(price)) return;
        paymentsCount = privParseInt(paymentsCount) + 1;
        price = privParseInt(price);
        var tabVal = getValByTerm(paymentsCount - 1);
        var stpp = price * (1 - (tabVal + commissions.acqCommission));
        var ipaTabVal = ipagetValByTerm(paymentsCount - 1);
        var ipa = price - (price * ipaTabVal + price * 0.02);
        var pp = 0;
        var ppValHint = '0.00';
        var singlePayment = price / paymentsCount;
        var ppFirst = singlePayment - price * (commissions.acqCommission + commissions.ppCommission);
        var ppSecond = singlePayment;
        var ppOther = (paymentsCount - 1) * ppSecond;
        pp = ppFirst + ppOther;
        ppValHint = ppFirst.toFixed(2) + " + " + (paymentsCount - 1) + "*" + ppSecond.toFixed(2);
        var ip = price * (1 - commissions.acqCommission);
        return ({
            payCount: paymentsCount,
            stPpValue: stpp.toFixed(2),
            ipaValue: ipa.toFixed(2),
            ipValue: ip.toFixed(2),
            ppValue: pp.toFixed(2),
            ppValueHint: ppValHint
        });
    };
    return my;
}());