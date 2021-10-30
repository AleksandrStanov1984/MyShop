<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
<script>
  dataLayer = [];
</script>

<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>

<link rel="apple-touch-icon" sizes="57x57" href="/image/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/image/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/image/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/image/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/image/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/image/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/image/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/image/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/image/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/image/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/image/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/image/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/image/favicon/favicon-16x16.png">

<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/image/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

    <!-- Адаптируем страницу для мобильных устройств -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Подключаем файлы стилей -->
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $mytemplate; ?>/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $mytemplate; ?>/css/slick.css" />
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $mytemplate; ?>/css/animate.css" />
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $mytemplate; ?>/js/fancy/jquery.fancybox.css" />
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $mytemplate; ?>/css/remodal.css" />
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $mytemplate; ?>/css/remodal-default-theme.css" />
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $mytemplate; ?>/css/style.css" />

<script type="text/javascript" src="catalog/view/theme/<?php echo $mytemplate; ?>/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="catalog/view/theme/<?php echo $mytemplate; ?>/js/slick.js"></script>
    <script type="text/javascript" src="catalog/view/theme/<?php echo $mytemplate; ?>/js/wow.js"></script>
    <script type="text/javascript" src="catalog/view/theme/<?php echo $mytemplate; ?>/js/remodal.js"></script>
    <script type="text/javascript" src="catalog/view/theme/<?php echo $mytemplate; ?>/js/maskedinput.js"></script>
    <script type="text/javascript" src="catalog/view/theme/<?php echo $mytemplate; ?>/js/jquery.sticky.js"></script>
    <script type="text/javascript" src="catalog/view/theme/<?php echo $mytemplate; ?>/js/nicescroll.min.js"></script>
    <script type="text/javascript" src="catalog/view/theme/<?php echo $mytemplate; ?>/js/fancy/jquery.fancybox.min.js"></script>
	<script type="text/javascript" src="catalog/view/javascript/megnor/bootstrap-notify.min.js"></script>
    <script type="text/javascript" src="catalog/view/theme/<?php echo $mytemplate; ?>/js/scripts.js"></script>

<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/common.js" type="text/javascript"></script>
	<?php foreach ($links as $link) { ?>
	<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
	<?php } ?>

<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php foreach ($analytics as $analytic) { ?>
<?php echo $analytic; ?>
<?php } ?>



</head>

<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P8S53LR"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<header class="header">
    <div class="wrapper">
	<div class="toggle-menu">
			<span></span>
		</div>

	<div class="logo"><a href="<?php echo $home ?>"><img src="catalog/view/theme/<?php echo $mytemplate; ?>/images/SZlogo.svg" alt="" /></a></div>
	
	<div class="nav">
	    <ul>
		<li><a href="<?php echo $home ?>"><?php echo $text_home ?></a></li>
			<?php foreach ($informations as $information) { ?>
				  <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
				  <?php } ?>
				  <?php /*<li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>*/?>
	    </ul>
	</div>
	<div class="phones">
	    <a href="tel:050 300 22 77" class="tel tel-mts">(050) 300 22 77</a>
	    <a href="tel:<?php echo $telephone; ?>" class="tel tel-kyiv"><?php echo $telephone; ?></a>
	    <a href="tel:<?php echo $fax; ?>" class="tel tel-city"><?php echo $fax; ?></a>
	</div>
	<div class="callback">
	    <a href="#" data-remodal-target="modal-callback" class="btn"><?php echo $text_callback3 ?></a>
	</div>
<?php echo $language; ?>

	<div class="cart" data-remodal-target="modal-cart">
	    <i><?php echo $countcart; ?></i>
	</div>
    </div>
</header>

<div class="header-mob" id="header-mob">
	<div class="wrapper">
		<div class="toggle-menu">
			<span></span>
		</div>
		<div class="phone"><a href="tel:<?php echo $telephone; ?>" class="tel tel-phone"><?php echo $telephone; ?></a></div>
		<a href="/#block-catalog" id="catbat" class="go_to link-catalog"><?php echo $catalog; ?></a>

		<div class="cart" data-remodal-target="modal-cart">
			<i><?php echo $countcart; ?></i>
		</div>
	</div>
</div>
<div id="fixed_PC_head">
<header class="header">
    <div class="wrapper">
	<div class="toggle-menu">
			<span></span>
		</div>

        <div class="logo"><a href="<?php echo $home ?>"><img width="55" height="20" src="catalog/view/theme/<?php echo $mytemplate; ?>/images/SZlogo.svg" alt="" /></a></div>
	
	<div class="nav">
	    <ul>
		<li><a href="<?php echo $home ?>"><?php echo $text_home ?></a></li>
			<?php foreach ($informations as $information) { ?>
				  <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
				  <?php } ?>
				  <?php /*<li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>*/?>
	    </ul>
	</div>
	<div class="phones">
	    <a href="tel:050 300 22 77" class="tel tel-mts">(050) 300 22 77</a>
	    <a href="tel:<?php echo $telephone; ?>" class="tel tel-kyiv"><?php echo $telephone; ?></a>
	    <a href="tel:<?php echo $fax; ?>" class="tel tel-city"><?php echo $fax; ?></a>
	</div>
        <a href="/#block-catalog"  id="catbat" class="go_to link-catalog PC_fixed"><?php echo $catalog; ?></a>
	<div class="callback">
	    <a href="#" data-remodal-target="modal-callback" class="btnc"><?php echo $text_callback3 ?></a>
	</div>


	<div class="cart" data-remodal-target="modal-cart">
	    <i><?php echo $countcart; ?></i>
	</div>
    </div>
</header>
</div>
<script type="text/javascript">
   jQuery(document).ready(function() {
     if(window.location.pathname=='/'){
     var new_link = '#block-catalog';
     $('.go_to').attr('href', new_link);
     }    
        
     window.hashName = window.location.hash;
     window.location.hash = '';

  $(window).load(function () {
    /*  if ($(window).width() > 450) { */
      $('html, body').animate({ 
          scrollTop: $(window.hashName).offset().top
      }, 1000);
   /*   } else { 
         $('html, body').animate({ 
          scrollTop: $(window.hashName).offset().top - 50 
      }, 1000); */
    /*  } */
      });
    
    }); 


$(document).ready(function(){
$("a[href*=#]").on("click", function(e){
var anchor = $(this);
if ($(window).width() > 450) {
$('html, body').stop().animate({
scrollTop: $(anchor.attr('href')).offset().top - 120
}, 777);
} else {
$('html, body').stop().animate({
scrollTop: $(anchor.attr('href')).offset().top - 50
}, 777);    
}
e.preventDefault();
return false;
});
});
     


   
jQuery(document).ready(function() {
    ResetSelector(0,3);    

   
$(window).scroll(function (event) {
    var top = $(window).scrollTop();
    if ($(window).width() > 450){
     if(top >= 100 && document.documentElement.clientWidth > 450){
       $('.nav').hide();  
     $('#fixed_PC_head').show();
     } else {
      $('#fixed_PC_head').hide();
      $('.nav').show();  
     }
 }
});    
    

jQuery('.link-catalog-filter').click(function() {
 
      
 var s_cat_id = jQuery(this).attr('data-get-id');

 if ($('#filter-btn-id-'+ s_cat_id).attr('active_btn') != 3) {
    return false;
 }         
 var sd_cat_id = s_cat_id; 
 var s_length = jQuery('#data-get-length-id-' + s_cat_id).val();
 var s_width = jQuery('#data-get-width-id-' + s_cat_id).val();
 var s_height = jQuery('#data-get-height-id-' + s_cat_id).val();
 var sd_reset = 1;

		$.ajax({
                        type: 'post',
			url: $('base').attr('href') + 'index.php?route=extension/module/featured/getProds',
			dataType: 'html',
                        
                        data: jQuery.param({'s_cat_id': s_cat_id, 's_height': s_height, 's_width': s_width, 's_length': s_length}) ,
                        //contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
			beforeSend: function () {
			},
			success: function(htmlText) {
                          $('#product_summary').html(htmlText);
                        },
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
  ResetSelector(sd_cat_id, sd_reset);  
});




  
 jQuery('.sd_reset').click(function(){
    
     var sd_reset = 1;
     var sd_cat_id = jQuery(this).attr('reset-cat-id');
     
     ResetSelector(sd_cat_id, sd_reset);

});
 
  function ResetSelector(sd_cat_id, sd_reset) {
     
     if (sd_cat_id != 0) {  
     $('#data-get-height-id-' + sd_cat_id).removeAttr("disabled").removeAttr("class");
     $('#data-get-width-id-' + sd_cat_id).removeAttr("disabled").removeAttr("class");
     $('#data-get-length-id-' + sd_cat_id).removeAttr("disabled").removeAttr("class");
     
     $('#data-get-height-id-' + sd_cat_id).addClass( "select-parameter__selector" );
     $('#data-get-width-id-' + sd_cat_id).addClass( "select-parameter__selector" );
     $('#data-get-length-id-' + sd_cat_id).addClass( "select-parameter__selector" );

     
     $('#filter-btn-id-'+ sd_cat_id).css("background-color", "#CCCCCC");
     $('#filter-btn-id-'+ sd_cat_id).attr("active_btn", "0");

        } else { 
          var  sd_reset = 3;
          var sd_cat_id = 0;
      }
        $.ajax({
            type: 'post',
            url: $('base').attr('href') + 'index.php?route=extension/module/featured/getAsizes',
            dataType: 'json',
            data: jQuery.param({'sd_reset': sd_reset, 'sd_cat_id': sd_cat_id }),
            //contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            beforeSend: function () {
            },
            success: function(data) {
            $( "#reset-cat-id-" + sd_cat_id ).hide();
            var $height = $('#data-get-height-id-' + sd_cat_id);
            var $width = $('#data-get-width-id-' + sd_cat_id);
            var $length = $('#data-get-length-id-' + sd_cat_id);
            var aHeightFull = data.aHeightFull;
            var aWidthFull = data.aWidthFull;
            var aLengthFull = data.aLengthFull;
            var Param_sended = data.Param_sended; 
                   $height.empty();
                   $width.empty();
                   $length.empty();
                   $.each( aHeightFull, function( key,  val ) { 
                     $height.append('<option value=' + val + '>' + val + '</option>');
                   });   
                   $.each( aWidthFull, function( key,  val ) { 
                     $width.append('<option  value=' + val + '>' + val + '</option>');
                   });
                    $.each( aLengthFull, function( key,  val ) { 
                     $length.append('<option value=' + val + '>' + val + '</option>');
                   });  
               $('#data-get-height-id-' + sd_cat_id).prepend( '<option value="" selected="selected"> — </option>' );
     $('#data-get-width-id-' + sd_cat_id).prepend( '<option value="" selected="selected"> — </option>' );
     $('#data-get-length-id-' + sd_cat_id).prepend( '<option value="" selected="selected"> — </option>' );
                   
         }
 });  
  }
 
 $('.select-parameter__selector').on('change', function (e) {
      
 var sd_cat_id = jQuery(this).attr('data-selector-get-cat-id');
 var Param = jQuery(this).attr('data-param');
 var optionSelected = $("option:selected", this);
 var valueSelected = this.value;
 var sd_reset = 0;
 var count_sel = $('#filter-btn-id-'+ sd_cat_id).attr('active_btn');

   if (count_sel == 0) {
  $('#filter-btn-id-'+ sd_cat_id).attr("active_btn", "1");
   } 
   if (count_sel == 1) {
  $('#filter-btn-id-'+ sd_cat_id).attr("active_btn", "2");
   }
   if (count_sel == 2) {
     $('#filter-btn-id-'+ sd_cat_id).attr("active_btn", "3");
   }
   
   if ($('#filter-btn-id-'+ sd_cat_id).attr('active_btn') == 3) {
     
     $('#filter-btn-id-'+ sd_cat_id).css("background-color", "#fbad25");
    
     $('#filter-btn-id-'+ sd_cat_id).removeAttr("background-image");
      $('#data-get-' + Param + '-id-' + sd_cat_id).addClass( "select-parameter__selector sel_disabled" );
      $('#data-get-' + Param + '-id-' + sd_cat_id).attr("disabled", "disabled");
      $('#reset-cat-id-' + sd_cat_id).css("display", "inline-block");
      return false;
   }
   
  /*   */
  
  $('#data-get-' + Param + '-id-' + sd_cat_id).addClass( "select-parameter__selector sel_disabled" );
  $('#data-get-' + Param + '-id-' + sd_cat_id).attr("disabled", "disabled");
  $('#reset-cat-id-' + sd_cat_id).css("display", "inline-block");

 // alert('category =' + sd_cat_id + ' ' + Param + ' = ' + valueSelected);
 

 
 	$.ajax({
                        type: 'post',
			url: $('base').attr('href') + 'index.php?route=extension/module/featured/getAsizes',
			dataType: 'json',
                        
                        data: jQuery.param({'sd_cat_id': sd_cat_id, 'sd_param': Param, 'sd_value': valueSelected, 'sd_reset': sd_reset}) ,
                        //contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
			beforeSend: function () {
			},
			success: function(data) {
                         //  $('#product_summary').html(htmlText);
            
            var $height = $('#data-get-height-id-' + sd_cat_id);
            var $width = $('#data-get-width-id-' + sd_cat_id);
            var $length = $('#data-get-length-id-' + sd_cat_id);
            var aHeight = data.aHeight;
            var aWidth = data.aWidth;
            var aLength = data.aLength;
            var aHeightFull = data.aHeightFull;
            var aWidthFull = data.aWidthFull;
            var aLengthFull = data.aLengthFull;
            var Param_sended = data.Param_sended;
            var aLengthFull2 = [];
            aLengthFull = Object.values(aLengthFull).sort(function(a,b){
                return aLengthFull[a]- aLengthFull[b]
            });
             
            switch(Param_sended) {
                case 'height':
                    
                    $width.empty();
                    $length.empty();
  
            for (i in aLengthFull) {
            var item = aLengthFull[i];
            var flag = false;
            for (j in aLength) {
                var pattern = aLength[j];
                if (item == pattern) {
                    flag = true;
                    break;
                }
            }
            if (flag) {
                $length.append('<option  value=' + item + '>' + item + '</option>');
            } else {
                $length.append('<option style="color: #CCC" disabled="disabled">' + item + '</option>');     
            }
        }
                
                
                
                for (i in aWidthFull) {
            var item = aWidthFull[i];
            var flag = false;
            for (j in aWidth) {
                var pattern = aWidth[j];
                if (item == pattern) {
                    flag = true;
                    break;
                }
            }
            if (flag) {
                $width.append('<option  value=' + item + '>' + item + '</option>');
            } else {
                $width.append('<option style="color: #CCC" disabled="disabled">' + item + '</option>');     
            }
        }
                    
                   
                    $('#data-get-length-id-' + sd_cat_id).prepend( '<option value="" selected="selected"> — </option>' );
                    $('#data-get-width-id-' + sd_cat_id).prepend( '<option value="" selected="selected"> — </option>' );
                  break;
                  
                case 'width':
                   $height.empty();
                   $length.empty();
                  for (i in aHeightFull) {
            var item = aHeightFull[i];
            var flag = false;
            for (j in aHeight) {
                var pattern = aHeight[j];
                if (item == pattern) {
                    flag = true;
                    break;
                }
            }
            if (flag) {
                $height.append('<option  value=' + item + '>' + item + '</option>');
            } else {
                $height.append('<option style="color: #CCC" disabled="disabled">' + item + '</option>');     
            }
        }
                   for (i in aLengthFull) {
            var item = aLengthFull[i];
            var flag = false;
            for (j in aLength) {
                var pattern = aLength[j];
                if (item == pattern) {
                    flag = true;
                    break;
                }
            }
            if (flag) {
                $length.append('<option  value=' + item + '>' + item + '</option>');
            } else {
                $length.append('<option style="color: #CCC" disabled="disabled">' + item + '</option>');     
            }
        }
                   $('#data-get-height-id-' + sd_cat_id).prepend( '<option value="" selected="selected"> — </option>' );
                   $('#data-get-length-id-' + sd_cat_id).prepend( '<option value="" selected="selected"> — </option>' );
                  break;
                  
                case 'length':
                   $height.empty();
                   $width.empty();
              
                  for (i in aHeightFull) {
            var item = aHeightFull[i];
            var flag = false;
            for (j in aHeight) {
                var pattern = aHeight[j];
                if (item == pattern) {
                    flag = true;
                    break;
                }
            }
            if (flag) {
                $height.append('<option  value=' + item + '>' + item + '</option>');
            } else {
                $height.append('<option style="color: #CCC" disabled="disabled">' + item + '</option>');     
            }
        }

                    for (i in aWidthFull) {
            var item = aWidthFull[i];
            var flag = false;
            for (j in aWidth) {
                var pattern = aWidth[j];
                if (item == pattern) {
                    flag = true;
                    break;
                }
            }
            if (flag) {
                $width.append('<option  value=' + item + '>' + item + '</option>');
            } else {
                $width.append('<option style="color: #CCC" disabled="disabled">' + item + '</option>');     
            }
        }
                   $('#data-get-width-id-' + sd_cat_id).prepend( '<option value="" selected="selected"> — </option>' );
                   $('#data-get-height-id-' + sd_cat_id).prepend( '<option value="" selected="selected"> — </option>' );
                   
                   break;
                   
                case 'hw':
                    $length.empty();
                  for (i in aLengthFull) {
            var item = aLengthFull[i];
            var flag = false;
            for (j in aLength) {
                var pattern = aLength[j];
                if (item == pattern) {
                    flag = true;
                    break;
                }
            }
            if (flag) {
                $length.append('<option  value=' + item + '>' + item + '</option>');
            } else {
                $length.append('<option style="color: #CCC" disabled="disabled">' + item + '</option>');     
            }
        }
                   $('#data-get-length-id-' + sd_cat_id).prepend( '<option value="" selected="selected"> — </option>' );
                   break;
                   
                case 'wl':
                    $height.empty();
            for (i in aHeightFull) {
            var item = aHeightFull[i];
            var flag = false;
            for (j in aHeight) {
                var pattern = aHeight[j];
                if (item == pattern) {
                    flag = true;
                    break;
                }
            }
            if (flag) {
                $height.append('<option  value=' + item + '>' + item + '</option>');
            } else {
                $height.append('<option style="color: #CCC" disabled="disabled">' + item + '</option>');     
            }
        }
                   $('#data-get-height-id-' + sd_cat_id).prepend( '<option value="" selected="selected"> — </option>' );
                   break;
                case 'lh':
                   $width.empty();  
                for (i in aWidthFull) {
            var item = aWidthFull[i];
            var flag = false;
            for (j in aWidth) {
                var pattern = aWidth[j];
                if (item == pattern) {
                    flag = true;
                    break;
                }
            }
            if (flag) {
                $width.append('<option  value=' + item + '>' + item + '</option>');
            } else {
                $width.append('<option style="color: #CCC" disabled="disabled">' + item + '</option>');     
            }
        }
                   $('#data-get-width-id-' + sd_cat_id).prepend( '<option value="" selected="selected"> — </option>' );
                   break;
                
                   
                default:
                 return false;
              }
 
                        },
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
 
 });   
 
});    
</script> 