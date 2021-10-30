<?php if($product_id != 80137){ ?>
<style>
  .attribute_group_item{
    /*display: none;*/
  }
</style>
<?php } ?>


<div class="attr_prod_link" style="display: none;">
<?php foreach($attribute_in_product_nc as $value){?>
  <input type="hidden" value="<?php echo $value; ?>" class="<?php echo $value; ?>">
<?php } ?>
</div>

<div class="attribute_wrapper">
  <?php $attr_level = 1; ?>
<?php foreach($attribute_info as $attribute_id => $attribute_info){?>
  <div class="attribute_group_item attribute-<?php echo $attribute_id; ?>">
    <h4><?php echo $attribute_info['name']; ?></h4>
    <?php foreach($attribute_variants['attribute-'.$attribute_id] as $value){?>

      <?php if($attribute_id == 15){ ?>


        <div class="attribute_value attr_level_<?php echo $attr_level;?> <?php echo 'attribute-'.$attribute_id; ?>" data-attr="<?php echo 'attribute-'.$attribute_id; ?>" data-key="<?php echo $attribute_variants_key['attribute-'.$attribute_id][$value]; ?>"
            <?php echo (isset($attribute_colors[trim($value)]) ? $attribute_colors[trim($value)] : ''); ?>>
          <?php echo $value; ?>
        </div>
      <?php }else{ ?>
        <div class="attribute_value attr_level_<?php echo $attr_level;?> <?php echo 'attribute-'.$attribute_id; ?>" data-attr="<?php echo 'attribute-'.$attribute_id; ?>" data-key="<?php echo $attribute_variants_key['attribute-'.$attribute_id][$value]; ?>">
          <?php echo $value; ?>
        </div>
      <?php } ?>
    <?php } ?>
  </div>
  <div style="clear: both;"></div>
  <?php $attr_level++; ?>
<?php } ?>
</div>

<style>
  #hpmodel{
    display: none !important;
  }
  .attribute_value{
    float: left;
    padding: 10px;
    border: 1px solid;
    cursor: pointer;
    margin-left: 10px;
  }
  .attribute_value:hover{
    color: white;
    background-color: black;
  }
  .attribute_group_item .active{
    background-color: #666666;
  }
  .attribute_group_item span{
    width: 100%;
  }
  .attribute_group_item{
    margin-top: 10px;
  }
  .non_active{
    opacity: 0.5;
    cursor: not-allowed;
  }
</style>
<script>
  $(document).on('click', '.attribute_value', function(){

    if($(this).hasClass('non_active')){
      return false;
    }

    $(this).parent('div').children('.attribute_value').removeClass('active');
    $(this).addClass('active');

    var key = $(this).data('key');
    var attr = $(this).data('attr');
    var elem = '';
    var links = '';

    $( ".attribute_group_item .active" ).each(function( index ) {
      elem = elem + '.'+ $( this ).data('key') ;
    });

    $( ".attr_prod_link ."+key).each(function( index ) {
      links += $( this ).val();
    });

    links = $.trim(links);
    links = links.split(' ');

    $( ".attribute_wrapper .attribute_value" ).each(function( index ) {
      if($(this).hasClass(attr)){

      }else{
        $(this).addClass('non_active');

        target = $(this);

        $( links ).each(function( i, row ) {

          if(target.data('key') == row){
            target.removeClass('non_active');
          }
          //$(this).addClass('non_active')
          //$(this).addClass('non_active');
        });
      }
    });

    $('.attr_level_1').removeClass('non_active');
    $(elem).trigger('click');


  });
</script>



<?php if($products) { ?>
<div id="hpmodel" class="form-group">
  <?php if($name_as_title){ ?>
  <div class="hpm-mame"><?php echo $title_name;?> <span class="after_title"></span></div>
  <?php } ?>
  <?php if(count($products)>7){?>
    <button class="prev-hpm-product arrow-hpm-product hidden-xs hidden-sm" disabled><i class="fa fa-chevron-left"></i></button>
    <?php } ?>
  <div class='hpmodel_type_images text-center'>
    <div class="box_product_hpm">

     <?php $selected_key = ''; ?>
    <?php foreach($products as &$product) { ?>
     <?php $key = ''; ?>
      <?php foreach ($product['view'] as $column => $value) { ?>
        <?php
          $level1 = explode(';', trim($value, ';'));
            foreach($level1 as $level2){
              $level3 = explode(';', $level2);
              foreach($level3 as $row){
               $key .= ' '. md5($column.'_'.$row);
              }
            }
        ?>
      <?php } ?>
      <?php if((int)$product['product_id'] == (int)$selected_product_id){
        $selected_key = $key;
      } ?>


    <div class='<?php echo $key; ?> hpm-item hpm-item-<?php echo $product['product_id']; ?> <?php if($product['product_id'] == $selected_product_id){ echo 'active';} ?> text-center pull-left thumbnail hidden-of-next<?php echo $product['product_id'];?> <?php if ($product['quantity'] > 0) { echo ' stock-on ';} else { echo ' stock-off ';} ?>'>
      <input type='hidden' data-title="<?php echo $product['after_title'];?>" data-hash="<?php echo preg_replace('/[\s,.+\-]+/','-',$product['product_id']); ?>" name='series_product_id' value="<?php echo $product['product_id'];?>">
      <?php foreach ($product['view'] as $column => $value) { ?>

      <div class="hpm-col-<?php echo $column; ?>">
        <?php echo $value; ?>
      </div>
      <div class="clearfix top10"></div>
      <?php } ?>
    </div>
    <?php } ?>
  </div></div>
  <?php if(count($products)>7){?>
    <button class="arrow-hpm-product next-hpm-product hidden-xs hidden-sm"><i class="fa fa-chevron-right"></i></button>
    <?php } ?>
</div>
<?php echo $config; ?>
<script>
  $(document).ready(function(){
    var element = '<?php echo $selected_key; ?>';
    element = element.trim();
    var element = element.split(' ');
    $(element).each(function( index, row ) {
      $( "div[data-key='"+row+"']" ).addClass('active');
    });



   var bottomLim = (<?php echo count($products); ?> - 7)*70;
    $('.prev-hpm-product').click(function(){


      $(this).parent('#hpmodel').find('.box_product_hpm').css('left', (parseFloat($(this).parent('#hpmodel').find('.box_product_hpm').css('left')) + 70));
     //console.log(parseFloat($(this).parent('.hpm-cat-box').find('.hpm-cat-content').css('top')));

       var thisElement = $(this);
      if(parseFloat($(this).parent('#hpmodel').find('.box_product_hpm').css('left')) == 0){
      thisElement.attr('disabled', 'disabled');
      } else if(parseFloat($(this).parent('#hpmodel').find('.box_product_hpm').css('left')) > - bottomLim){
        $('.next-hpm-product').removeAttr('disabled');
      }
    });


    $('.next-hpm-product').click(function(){
        console.log(parseFloat($(this).parent('#hpmodel').find('.box_product_hpm').css('left')));
      $(this).parent('#hpmodel').find('.box_product_hpm').css('left', (parseFloat($(this).parent('#hpmodel').find('.box_product_hpm').css('left')) - 70));
      var thisElement = $(this);

       console.log(parseFloat($(this).parent('#hpmodel').find('.box_product_hpm').css('left')));
        if(parseFloat($(this).parent('#hpmodel').find('.box_product_hpm').css('left')) == - bottomLim ){

       thisElement.attr('disabled', 'disabled');
     } else if(parseFloat($(this).parent('#hpmodel').find('.box_product_hpm').css('left')) !== 0){
         $('.prev-hpm-product').removeAttr('disabled');
       }


    })
  })
</script>
<script>
function hashchange() {
    var sf = false;
    <?php if (!empty($hash)) { ?>
    var hash = location.hash.replace('#','');
    if (hash) {
        hash = hash.split('-')[0];
        var elem = $('[data-hash="'+hash+'"]').closest('.hpm-item');
        if (elem.length) {
            elem.trigger('click');
            sf = true;
        }
    } else {
        if ($('#hpmodel .hpm-item-<?php echo $selected_product_id; ?>').length) {
            $('#hpmodel .hpm-item-<?php echo $selected_product_id; ?>').trigger('click');
            sf = true;
        }
    }
    <?php } else { ?>
        if ($('#hpmodel .hpm-item-<?php echo $selected_product_id; ?>').length) {
            $('#hpmodel .hpm-item-<?php echo $selected_product_id; ?>').trigger('click');
            sf = true;
        }
    <?php } ?>
    if (!sf) {
        $('#hpmodel .hpm-item').first().trigger('click');
    }
}
function numberWithSpaces(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
}
function hpmodel_rri(r, ri) {
    for (s in r) { $(s).html(r[s]); }
    for (s in ri) { $i = $(s).val(ri[s]); v = hpmodel.input[s]; if (v) $i.trigger(v); }
    if (typeof hmodel_onchange === 'function') hmodel_onchange();
    if (typeof autocalc_init === 'function') autocalc_init();
}
function setLocation(curLoc){
    try {
      history.pushState(null, null, curLoc);
      return;
    } catch(e) {}
    location.hash = '#' + curLoc;
}
$(document).on('click', '.hpm-item', function() {
    $('.hpm-item').removeClass('active');
    var $i = $(this).find('input[name="series_product_id"]');
    product_id = $i.val();
    $('#hpmodel .hpm-item-'+product_id).addClass('active');
    $('body').removeClass('hpm-no-active').addClass('hpm-has-active');

    <?php if (!empty($hash)) { ?>
    var name = $(this).text(); name = name.trim(' ').toLowerCase().replace(/\s\s+/g, '-').replace(' ', '-');
    var hash = $(this).find('[data-hash]').data('hash') + (name ? '-' + name : '');
    var loc = location.href;
    if (location.hash) {
        loc = loc.replace(/(#.*)/, '#' + hash);
    } else {
        loc = loc + '#'+ hash;
    }
    window.history.replaceState(null,null, loc);
    <?php } ?>
    $('#hpmodel .after_title').html($i.data('title'));

    if (typeof hmodel_before === 'function') hmodel_before();
    $.ajax({
        url: 'index.php?route=product/product&product_id='+product_id+'&path=<?php echo $path; ?>',
        type: 'post',
        data: 'hpmodel_orig=1',
        dataType: 'html',
        success: function(h){

            //console.log(h);

            var $d=$(h); var r = []; var ri = [];
            setLocation($d.find('meta[itemprop="url"]').attr('content'));
            // Product sku
            if($d.find('.sku b').length) {
                $('.sku b').text($d.find('.sku b').text());
            }

            // Main Image
            if($d.find('.main-image .main-img-item').length) {
                var popupImg = $d.find('.main-image .main-img-item').eq(0).children('a').attr("href");
                var smallImg = $d.find('.main-image .main-img-item').eq(0).find('img').attr("src");
                $('.main-image .main-img-item').eq(0).children('a').attr("href", popupImg);
                $('.main-image .main-img-item').eq(0).find('img').attr("src", smallImg);
            }

            // Additional Image
            if($d.find('.thumb-images .thumb-images-item').length) {
                var smallAddImg = $d.find('.thumb-images .thumb-images-item').eq(0).find('img').attr("src");
                $('.thumb-images .thumb-images-item').eq(0).find('img').attr("src", smallAddImg);
            }

            // Product Price
            if($d.find('.new-price').length) {
                var pp = $('.new-price i').text();
                //var np = $d.find('.new-price').text().replace(/\D+/g,"").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                var np = $d.find('.new-price').text().replace(/\D+/g,"");
                $('.new-price').html(np + '<i>' + pp + '</i>');
                if($d.find('.price .old-price').length <= 0 && $('.old-price').length) {
                    $('.old-price').remove();
                }
            }

            if($d.find('.price .old-price').length) {
                var ppo = $d.find('.price .old-price i').text();
                //var onp = $d.find('.old-price').text().replace(/\D+/g,"").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
                var onp = $d.find('.old-price').text().replace(/\D+/g,"");
                if($('.old-price').length) {
                    $('.old-price').html(onp + '<i>' + ppo + '</i>');
                } else {
                    $('.new-price').before('<div class="old-price">'+onp + '<i>' + ppo + '</i></div>');
                }

            }

            $('.count-input input[name="quantity"]').val(1);

            // Wishlist
            $('[onclick*="wishlist.add("]').attr('onclick', 'wishlist.add('+product_id+')');

            wishlist.get(product_id);

            // Add Cart
            $('input[name="product_id"]').val(product_id);

            // Description
            /*if($('#tab2').length) {
                $('#tab2').html($($d).find('#tab2').html());
            }*/
            if($('.description').length) {
              $('.description').html($($d).find('.description').html());
            }




            <?php //if ($replace_h1) { ?>
                $('h1').text($d.find('h1').text());
                document.title=$d.filter('title').text();
            <?php //} ?>
            for (s in hpmodel.rest) { r[s] = $(s).html(); };
            for (s in hpmodel.input) { ri[s] = $(s).val();  };
            var cc = 0;
            for (s in hpmodel.copy) { cc++; $h = $d.find(s); var $i = $h.find('img'); var ic = $i.length; if (ic == 0) { $(s).html($h.html()); cc--; } else { (function(ic, $i, s, $h){ $i.each(function(){ $ii = $('<img src="'+$(this).attr('src')+'" style="width:1px;height:1px;" />').load(function(){ ic--; if (ic == 0) { $(s).html($h.html()); cc--; if (cc == 0) hpmodel_rri(r, ri); }}).error(function(){ ic--; if (ic == 0) { $(s).html($h.html()); cc--; if (cc == 0) hpmodel_rri(r, ri); }});});})(ic, $i, s, $h);}};
            if (cc == 0) hpmodel_rri(r, ri);
        }
    });
})
$(document).ready(function () {
    <?php if (!empty($selector) && !empty($position)) { ?>$('#hpmodel').<?php echo $position;?>('<?php echo $selector;?>');<?php } ?>
    $('#hpmodel').show();
    if ($('#hpmodel .hpm-item-<?php echo $selected_product_id; ?>').length) {
        $('#hpmodel .hpm-item-<?php echo $selected_product_id; ?>').addClass('active');
        $('body').addClass('hpm-has-active');
    } else {
        <?php /* $('#hpmodel .hpm-item').first().addClass('active'); */ ?>
        $('body').addClass('hpm-no-active');
    }
    hashchange();
});
</script>

<?php if ($custom_css) { ?><style><?php echo $custom_css; ?></style><?php } ?>
<?php if ($custom_js) { ?><script><?php echo $custom_js; ?></script><?php } ?>
<?php } ?>
