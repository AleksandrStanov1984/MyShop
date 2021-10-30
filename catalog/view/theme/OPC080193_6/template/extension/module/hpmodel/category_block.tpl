<?php if($_GET['_route_'] == 'search/' AND $_GET['search'] == 'Aral BlueTronic 10W-40 1л.'){ ?>

<?php }else{ ?>
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
  <div class="attribute_group_item attribute-<?php echo $attribute_id; ?> blog-attribute-<?php echo $attribute_id; ?>">
    <?php if($attribute_id != 15){ ?>
      <h4><?php echo $attribute_info['name']; ?></h4>
    <?php } ?>
    <?php foreach($attribute_variants['attribute-'.$attribute_id] as $value){?>
    
      <?php if($attribute_id == 15){ ?>

      
        <div title="<?php echo $value; ?>" class="attribute_value attr_level_<?php echo $attr_level;?> <?php echo 'attribute-'.$attribute_id; ?>" data-attr="<?php echo 'attribute-'.$attribute_id; ?>" data-key="<?php echo $attribute_variants_key['attribute-'.$attribute_id][$value]; ?>"
            <?php echo (isset($attribute_colors[trim($value)]) ? $attribute_colors[trim($value)] : ''); ?>>
          <?php //echo $value; ?>
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
  .blog-attribute-15{
    position: absolute;
    z-index: 10000;
    top: 0;
    width: 35px;
    left: -10px;
  }
  .blog-attribute-15 div{
    margin-bottom: 3px;
    width: 35px;
    height: 10px;
    border-radius: 5px;
  }
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

<?php if (!empty($products)) { ?>
<div class="hpm-cat-box hidden-xs model_id_<?php echo $model_id; ?>" <?php echo !empty($thumb) && !empty($replace_image) ? 'data-thumb="'.$thumb.'"': ''; ?> data-count-hpm="<?php echo count($products); ?>">
  <!--<?php if (!empty($title)) { ?><div class="hpm-cat-title"><?php echo $title; ?></div><?php } ?><?php if(count($products)>7){?>
    <button class="prev-hpm-item arrow-hpm-cat" disabled><i class="fa fa-chevron-up"></i></button>
    <?php } ?>-->
  <div class="hpm-cat-box-2">
  <div class="hpm-cat-content">

    <?php foreach ($products as $key => $product) { ?>
    
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
    
    
    <div <?php echo ($model_id == 3) ? 'style="width: calc(100%/'.count($products).' - 4px)"': ''; ?> class="<?php echo $key; ?> <?php echo count($products); ?>  hpm-cat-item<?php echo $product['product_id'] == $product_id ? ' active' : ''; ?>" data-id="<?php echo $product['product_id']; ?>" data-href="<?php echo $product['href']; ?>" <?php if (!empty($replace_h1)) { ?>data-name="<?php echo $product['name']; ?>"<?php } ?> <?php echo !empty($product['thumb']) && !empty($replace_image) ? 'data-thumb="'.$product['thumb'].'"': ''; ?> <?php echo $product['price'] ? 'data-price="'.$product['price'].'"': ''; ?> <?php echo $product['special'] ? 'data-special="'.$product['special'].'"': ''; ?> data-qty="<?php echo $product['quantity']; ?>">
      <?php foreach ($product['view'] as $column => $value) { ?>
      
      <?php if($column != 'attribute-15'){ ?>
      <div class="hpm-col-<?php echo $column; ?>">
        <?php echo $value; ?>
      </div>
      <?php } ?>
      
      
      
      <?php } ?>
    </div>
    <?php } ?>

  </div>
</div>
<!--<?php if(count($products)>7){?>
    <button class="arrow-hpm-cat next-hpm-item"><i class="fa fa-chevron-down"></i></button>
  <?php } ?>-->
</div>
<?php } ?>
<script>
  $(document).ready(function(){
    <?php if(count($products)>6){?>
$('#model_id_6 .hpm-cat-content').slick({
    //asNavFor: '.main-image',
    slidesToShow: 6,
    vertical: true,
    verticalSwiping: true,
    arrows: true,
    infinite: false,
    //variableWidth: true,
    //focusOnSelect: true
})
<?php } ?>

   /*var bottomLim = (<?php echo count($products); ?> - 7)*47;
   $('.prev-hpm-item').click(function(){


      $(this).parent('.hpm-cat-box').find('.hpm-cat-content').css('top', (parseFloat($(this).parent('.hpm-cat-box').find('.hpm-cat-content').css('top')) + 47));
     console.log(parseFloat($(this).parent('.hpm-cat-box').find('.hpm-cat-content').css('top')));

       var thisElement = $(this);
      if(parseFloat($(this).parent('.hpm-cat-box').find('.hpm-cat-content').css('top')) == 0){
      thisElement.attr('disabled', 'disabled');
      } else if(parseFloat($(this).parent('.hpm-cat-box').find('.hpm-cat-content').css('top')) > - bottomLim){
        $('.next-hpm-item').removeAttr('disabled');
      }
    });


    $('.next-hpm-item').click(function(){
      $(this).parent('.hpm-cat-box').find('.hpm-cat-content').css('top', (parseFloat($(this).parent('.hpm-cat-box').find('.hpm-cat-content').css('top')) - 47));
      var thisElement = $(this);


        if(parseFloat($(this).parent('.hpm-cat-box').find('.hpm-cat-content').css('top')) == - bottomLim ){

       thisElement.attr('disabled', 'disabled');
     } else if(parseFloat($(this).parent('.hpm-cat-box').find('.hpm-cat-content').css('top')) !== 0){
         $('.prev-hpm-item').removeAttr('disabled');
       }


    })*/
  })
</script>
