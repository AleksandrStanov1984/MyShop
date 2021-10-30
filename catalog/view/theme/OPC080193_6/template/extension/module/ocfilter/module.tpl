<?php $rozetka_style = true; ?>
<?php if ($options || $show_price) { ?>
<div class="ocf-offcanvas ocfilter-mobile hidden-md hidden-lg">
  <div class="ocfilter-mobile-handle hidden">
    <button type="button" class="btn btn-primary" data-toggle="offcanvas"><i class="fa fa-filter"></i></button>
  </div>
  <div class="ocf-offcanvas-body"></div>
</div>

<div class="panel ocfilter panel-default" id="ocfilter">
  <div class="panel-heading"><span><?php echo $heading_title; ?></span><button class="button-filter-close visible-xs visible-sm" style="float: left"><img src="catalog/view/theme/OPC080193_6/images/close_button.svg" alt="close"></button></div>
  <div class="hidden" id="ocfilter-button">
    <button class="btn-main btn-show-bottom-panel disabled" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Загрузка.."></button>
  </div>
  <div class="list-group">


    <?php include 'selected_filter.tpl'; ?>
  <?php include 'filter_price.tpl'; ?>
    <?php include 'filter_list.tpl'; ?>


  </div>
  <div class="ocfilter-option-selector ocfilter-mob-bottom-panel">
    <button type="button" onclick="location = '<?php echo $link; ?>';" class="btn-secondary btn-dump-bottom-panel"><?php echo $text_cancel_all; ?></button>
  <span class="pick-selected">
      <button class="btn-main btn-show-bottom-panel" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Загрузка.." disabled="disabled" onclick="return false;">Показать</button>
  </span>
  </div>
</div>

<script><!--
$(function() {
  $('body').append($('.ocfilter-mobile').remove().get(0).outerHTML);

var options = {
    rozetka_style: <?php print $rozetka_style?"true":"false"; ?>,
    mobile: $('.ocfilter-mobile').is(':visible'),
    php: {
      searchButton : <?php echo $search_button; ?>,
      showPrice    : <?php echo $show_price; ?>,
      showCounter  : <?php echo $show_counter; ?>,
      manualPrice  : <?php echo $manual_price; ?>,
      link         : '<?php echo $link; ?>',
      path         : '<?php echo $path; ?>',
      params       : '<?php echo $params; ?>',
      index        : '<?php echo $index; ?>'
    },
    text: {
      show_all: '<?php echo $text_show_all; ?>',
      hide    : '<?php echo $text_hide; ?>',
      load    : '<?php echo $text_load; ?>',
      any     : '<?php echo $text_any; ?>',
      select  : '<?php echo $button_select; ?>'
    }
  };

  if (options.mobile) {
    $('.ocf-offcanvas-body').html($('#ocfilter').remove().get(0).outerHTML);
  }

  $('[data-toggle="offcanvas"]').on('click', function(e) {
    $(this).toggleClass('active');
    $('body').toggleClass('modal-open');
    $('.ocfilter-mobile').toggleClass('active');
  });

  setTimeout(function() {
    $('#ocfilter').ocfilter(options);
  }, 1);
});
//--></script>
<script>
  $(document).ready(function(){
    $('.ocf-option-name').on('click', function(){
      if($(this).next('.ocf-option-values').is(':hidden')){
        $(this).next('.ocf-option-values').slideToggle();
        $(this).parent().removeClass('ocfilter-option-close');
        $(this).children('.icon-chevron-down').css('transform','rotate(180deg)');
        $(this).removeClass('ocf-option-name-close');
       }else{
         $(this).next('.ocf-option-values').slideUp();
         $(this).parent().addClass('ocfilter-option-close');
         $(this).addClass('ocf-option-name-close');
         $(this).children('.icon-chevron-down').removeClass('transform-down');
          $(this).children('.icon-chevron-down').css('transform','rotate(0deg)');
       }


    });
    $('.mobile-bg').mouseup(function (e) {
            var div = $(".ocfilter-mobile");
           if (div.hasClass('active')) {
            $('.button-filter-close').trigger( "click" );
            }
          })
        if (window.matchMedia('(max-width: 767px)').matches) {
          $('.ocfilter-option:not(.ocfilter-option-price)').find('.ocf-option-values').slideUp();
          $('.ocfilter-option:not(.ocfilter-option-price)').find('.ocf-option-name').addClass('ocf-option-name-close');
          $('.ocfilter-option:not(.ocfilter-option-price)').addClass('ocfilter-option-close');
          $('.ocfilter-option:not(.ocfilter-option-price)').find('.icon-chevron-down').removeClass('transform-down').css('transform','rotate(0deg)');
        }
  })
</script>
<script>
  $(document).ready(function(){
     $('.button-filter-close').click(function(){
      $('.ocfilter-mobile-handle button').trigger('click');
     })
});
</script>
<style>
  .wrap-ocf-filter-values {
    max-height: 260px;
    overflow: hidden;
  }
</style>
<script>
  $(document).ready(function() {
    $('.wrap-ocf-filter-values').mCustomScrollbar({
        theme: 'dark',
    });
  });
</script>

<?php } ?>
