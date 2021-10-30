<?php echo $header; ?>
<?php if(isset($microdata_breadcrumbs) && $microdata_breadcrumbs) echo $microdata_breadcrumbs; ?>
<?php if(isset($microdata) && $microdata) echo $microdata; ?>
<div class="wrapper">  <?php if(!(($count_parts ==1) && ($is_mobile ) )){  ?> <?php echo $content_top; ?> <?php } ?>
      <ul class="breadcrumb__list" <?php echo $content_top ? 'style="margin-top:10px"' : ''; ?>>
        <?php $pop_breadcrs = array_pop($breadcrumbs); foreach ($breadcrumbs as $breadcrumb) { ?>
          <li class="breadcrumb__item"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
  <li><?php echo $pop_breadcrs['text']; ?></li>
      </ul>
</div>
<div class="panel-sfv-catalogs visible-xs visible-sm">
  <div class="wrapper">
    <div class="ul-sfv-catalogs">
      <div class="sort-panel"><img src="catalog/view/theme/OPC080193_6/images/page_category/sort.svg" alt="sort">Сортировка
      </div>
      <?php if ($filter_connected){ ?>
      <div class="filter-panel">
          <button id="button-filter">
            <span class="scoreboard_oc_filter" id="product_total_filter" style="display: none;"></span>
            <img src="catalog/view/theme/OPC080193_6/images/page_category/funnel.svg" alt="filter">Фильтр
          </button>
      </div>
      <?php } ?>
      <div class="view view-check-grid hidden-sm" id="view-list-fake"><img src="catalog/view/theme/OPC080193_6/images/page_category/view-list.svg" class="img-view-prod" alt="view">
      </div>
      <div class="view_button">
      <div id="view-list-fake_sm"><img src="catalog/view/theme/OPC080193_6/images/page_category/view-list.svg" alt="view">
      </div>
      <div id="view-grid-fake_sm"><img src="catalog/view/theme/OPC080193_6/images/page_category/view-grid.svg" alt="view" style="display: block;">
      </div>
      <div id="view-foto-fake_sm"><img src="catalog/view/theme/OPC080193_6/images/page_category/view-foto.svg" alt="view" style="display: block;">
      </div>
      </div>
    </div>
  </div>
</div>
<div class="wrapper">
  <div class="row"><?php echo $column_left; ?>
  <?php if ($column_left && $column_right) { ?>
  <?php $class = 'col-sm-6'; ?>
  <?php } elseif ($column_left || $column_right) { ?>
  <?php $class = 'col-lg-9'; ?>
  <?php } else { ?>
  <?php $class = 'col-sm-12'; ?>
  <?php } ?>
    <div id="content" class="<?php echo $class; ?>" data-url="<?php echo $categ_url; ?>" data-limit="<?php echo $limit_per_page; ?>" data-total="<?php echo $product_total; ?>" data-showed="<?php echo $total_showed; ?>">
      <h1 class="title-page-category"><?php echo $categ_id == 1493 ? $series_name : $heading_title; ?></h1>
      <?php if ($categories) { ?>
      <?php if (!($hide_subcategory_shortcut ?? false)) { ?>
      <?php if (count($categories) <= 5) { ?>
      <div class="row row-margin-5 block-subcategory">
        <?php foreach ($categories as $category) { ?>
        <div class="col-xs-6 col-sm-6 col-sm-3 col-md-4 <?php echo $column_left ? 'col-lg-3' : 'col-lg-2'; ?>  col-sub-category col-padding-5">
          <a  class="item-sum-category border-right-bottom" href="<?php echo $category['href']; ?>">
            <img class="img-responsive img-sub-category" src="<?php echo $category['image']; ?>" alt="<?php echo $category['series_name']; ?>" title="<?php echo $category['series_name']; ?>"/>
            <div class="title-category-sub"><?php echo $category['series_name']; ?></div>
          </a>
        </div>
        <?php } ?>
      </div>
      <?php } else { ?>
      <div class="row row-margin-5 block-subcategory">
        <?php foreach (array_chunk($categories, ceil(count($categories) / 4)) as $categories) { ?>
        <?php foreach ($categories as $category) { ?>
        <div class="col-md-4 <?php echo $column_left ? 'col-lg-3' : 'col-lg-2'; ?> col-sm-4 col-xs-6  col-sub-category col-padding-5">
          <a class="item-sum-category border-right-bottom" href="<?php echo $category['href']; ?>">
          <img class="img-responsive img-sub-category" src="<?php echo $category['image']; ?>" alt="<?php echo $category['series_name']; ?>"
                  title="<?php echo $category['series_name']; ?>"/>
          <div class="title-category-sub"><?php echo !empty($category['series_name']) ? $category['series_name'] : $category['name']; ?></div>
          </a>
        </div>
        <?php } ?>
        <?php } ?>
      </div>
      <?php } ?>
      <?php } ?>
      <?php } ?>
      <?php if ($products) { ?>
      <div class="row">
        <div class="col-md-2 col-sm-6 hidden">
          <div class="btn-group btn-group-sm">
            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
            <button type="button" id="photo-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_foto; ?>"><i class="fa fa-image"></i></button>
          </div>
        </div>
        <div class="col-sm-12 col-xs-6 i-sort hidden-xs hidden-sm">
          <span class="hidden-sm i-sort_label"><?php echo $text_sort; ?></span>
          <?php foreach ($sorts as $s) { ?>
          <?php if ($s['value'] == $sort . '-' . $order) { ?>
          <a class='sort_select' href="<?php echo $s['href']; ?>"><span><?php echo $s['text']; ?></span></a>
          <?php } else { ?>
          <a href="<?php echo $s['href']; ?>"><span><?php echo $s['text']; ?></span></a>
          <?php } ?>
          <?php } ?>
        </div>
      </div>
      <div class="row catalog-mobile block-products row-products">
        <!--isset_listing_page-->
        <?php $ppos = 0; foreach ($products as $product) { $ppos++; ?>
        <div <?php echo $product['product_id'] ? '' : 'style="display:none"'; ?> class="product-layout <?php echo $is_mobile ? 'product-list' : 'product-grid' ?> <?php if ($column_left || $column_right) {echo 'col-xl-3 col-lg-4 col-md-3 col-sm-4 col-6';}elseif($column_left && $column_right){echo 'col-lg-6 col-md-6 col-sm-4 col-12';} else{echo 'col-lg-2 col-md-3 col-sm-4 col-6';} ?> <?php echo $product['hpm_block_model_id']; ?>" <?php echo !empty($product['hpm_block']) ? 'data-exist="exist-hpm"': ''?> <?php echo !empty($product['hpm_block_model_id']) ? 'data-model_id="model_id_'.$product['hpm_block_model_id'].'"': ''?>  <?php echo (isset($product['in_stock'])&&$product['in_stock'])? '' : 'data-stock="card_out_stock"' ?>>
          <!--product_in_listingEX-->
          <div class="item">
            <?php if($product['stickers']){?>
           <div class="stickers">
           <?php foreach ($product['stickers'] as $sticker) { ?>
           <?php if($sticker == '3'){?>
             <div><span class="stickers_new">Новинки</span></div>
           <?php }?>
           <?php if($sticker == '2'){?>
             <div><span class="stickers_top">Топ продаж</span></div>
           <?php } ?>
           <?php if($sticker == '1'){?>
           <div><span class="stickers_free"><img src="catalog/view/theme/OPC080193_6/image/stickers/sticker_free.svg" alt="sticker free"> <span>Бесплатная доставка</span></span></div>
           <?php }?>
           <?php }?>
       </div>
     <?php }?>
     <div class="couple_btn">
      <button type="button" class="btn-wishlist btn-wishlist-incatalog <?php echo $product['wish'] ? 'added_alredy' : ''; ?>"  data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><img src="<?php echo $product['wish'] ? 'catalog/view/theme/OPC080193_6/images/page_product/heart.svg' : 'catalog/view/theme/OPC080193_6/images/page_category/favorites.svg'; ?>" alt="wishlist"></button>
        <button type="button" data-toggle="tooltip" title="В сравнение" style="display: none;" onclick="compare.add('94902');"><img src="catalog/view/theme/OPC080193_6/images/page_category/compare_gray.svg" alt="compare"></button>
      </div>
     <div class="image"><a href="<?php echo $product['href']; ?>">
                <img src="image/loader-gray.gif" data-src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" class="img-responsive lazy-sz" title="<?php echo $product['name']; ?>"/></a></div>
            <div class="all-info-product">
              <?php if(!$show_whl) { ?>
              <div class="size">
                <?php if ($product['height']){ ?>
                <span class="units-product"><?php echo $unit_h; ?>:</span> <span><?php echo $product['height'] ?></span><?php } ?><?php if ($product['width']){ ?><span class="units-product"><?php echo $unit_w; ?>:</span> <span><?php echo $product['width'] ?></span><?php } ?><?php if ($product['height']){ ?><span class="units-product"><?php echo $unit_l; ?>:</span> <span><?php echo $product['length'] ?></span><?php } ?>
                <?php if ($product['diameter_of_pot']){ ?>
                <img src="catalog/view/theme/OPC080193_6/images/diameter_of_pot.svg" class="img-diameter-of-pot img-icon-pot" alt="diameter"> <?php echo $product['diameter_of_pot'];?> <?php echo $unit; ?> <?php } ?><?php if ($product['depth_of_pot']){ ?> <img src="catalog/view/theme/OPC080193_6/images/depth_of_pot.svg" class="img-depth-of-pot img-icon-pot" alt="depth"><?php echo $product['depth_of_pot'];?> <?php echo $unit; ?><?php } ?>
              </div>
              <?php } ?>
              <a class="name" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
              <!--<a class="model" href="<?php echo $product['href'] ?>"><b><?php echo $product['model'] ?></b></a>-->
              <div class="product-panel">
                <?php if ($product['price']) { ?>
                <div class="price">
                  <?php if ($product['special']) { ?>
                    <div class="price-old"><?php echo $product['price'] ?></div>
                    <div class="price-new"><?php echo $product['special'] ?></div>
                  <?php } else { ?>
                    <div class="price-old" style="height: 15px"></div>
                    <div class="price-regular"><?php echo $product['price'] ?></div>
                <?php } ?>
                </div>
                <?php } ?>
                <?php if ($product['rating']) { ?>
                <div class="rating">
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                    <?php if ($product['rating'] < $i) { ?>
                    <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                    <?php } else { ?> <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                    <?php } ?>
                <?php } ?>
                </div>
                <?php } ?>
                <div class="button button-page-category">
                  <button <?php echo (isset($product['in_stock'])&&$product['in_stock'])? '' : 'disabled' ?> onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');" class="btn-buy <?php echo $product['incart'] ? 'added_to_cart' : ''; ?>"><span class="card-img <?php echo $product['incart'] ? 'basket_done' : 'basket_empty'; ?>"></span><span class="btn-buy-text"><?php echo $button_cart; ?></span>
                  </button>
                </div>
              </div>
              <div class="stock_status <?php echo ($product['stock_status_id'] == 7 || $product['stock_status_id'] == 8) ? 'in_stock_status' : 'out_stock_status'?>"><?php echo $product['stock_status'] ?></div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <div class="row" style="position: relative;">
        <div style ="position: absolute;z-index: -1;visibility: hidden;" class="col-sm-6 text-left"><?php //echo $pagination; ?><div class="pagination"></div></div>
      </div>
      <!--seo_text_start-->

      <!--seo_text_end-->
      <?php } ?>
      <?php if (!$categories && !$products) { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
          <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>
      <?php if(!(($count_parts ==1) && ($is_mobile ) )){  ?>
      <div class="content-bottom-category"><?php echo $content_bottom; ?></div>

      <!--seo_text_start-->

      <!--seo_text_end-->

      <?php } ?>

      <?php if (isset($description)&&$description&&$show_desc){ ?>
      <div class="category_description"><?php echo $description; ?></div>
    <?php } ?>
      <?php echo $column_right; ?>
    </div>
  </div>

</div>

  <div class="remodal remodal-dark modal-callback" data-remodal-id="modal-view-product" id="modal-view-product" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="modal-body">
      <ul class="view-ul">
        <li id="view-list-fake">Список</li>
        <li id="view-grid-fake">Плитка</li>
        <li id="view-foto-fake">Фото</li>
      </ul>
    </div>
  </div>
  <div class="" id="sort-product">
    <div class="panel-heading"><img src="catalog/view/theme/OPC080193_6/images/page_category/sort.svg" alt="sort">Сортировка
    <button class="button-sort-close"><img src="catalog/view/theme/OPC080193_6/images/close_button.svg" alt="close"></button>
    </div>
      <ul class="sort-ul">
      <?php foreach ($sorts as $s) { ?>
      <?php if ($s['value'] == $sort . '-' . $order) { ?>
        <li class='selected_sort'><a href="<?php echo $s['href']; ?>"><span><?php echo $s['text']; ?></span></a></li>
      <?php } else { ?>
        <li><a href="<?php echo $s['href']; ?>"><?php echo $s['text']; ?></a></li>
      <?php } ?>
      <?php } ?>
      </ul>
  </div>
<script>
  $(document).ready(function () {
    $(window).scroll(function () {
      67 < $(document).scrollTop() ? $(".panel-sfv-catalogs").addClass('panel-sfv-catalogs-fixed') : $(".panel-sfv-catalogs").removeClass('panel-sfv-catalogs-fixed')
    });
  });
</script>
<script>
$(document).ready(function () {
  $('#button-filter').click(function () {
  $('.ocfilter-mobile-handle button').trigger('click');
  })
  });
  </script>
<!--<script>
      $(document).ready(function(){
        var textSort = $('#modal-sort-product .selected_sort').text();
        $('.sort-panel').text(textSort);

    });
</script>-->
<script>
$(document).ready(function () {
  if (window.matchMedia('(max-width: 767px)').matches) {
  $('.ul-sfv-catalogs').on('click', '#view-list-fake', function () {
    $('#grid-view').trigger('click');
    //$('#modal-view-product .remodal-close').trigger('click');
  });
  $('.ul-sfv-catalogs').on('click', '#view-grid-fake', function () {
    $('#photo-view').trigger('click');
    //$('#modal-view-product .remodal-close').trigger('click');
  });
  $('.ul-sfv-catalogs').on('click', '#view-foto-fake', function () {
    $('#list-view').trigger('click');
    //$('#modal-view-product .remodal-close').trigger('click');
  });
} else if(window.matchMedia('(min-width: 768px) and (max-width: 991px)').matches){
  $('#view-grid-fake_sm').click(function () {
    $('#grid-view').trigger('click');
  });
  $('#view-foto-fake_sm').click(function () {
    $('#photo-view').trigger('click');
  });
  $('#view-list-fake_sm').click(function () {
    $('#list-view').trigger('click');
  });
}
  $('.sort-panel').click(function(){
    $('#sort-product').toggleClass('active');
  });
  $('.button-sort-close').click(function(){
    $('#sort-product').removeClass('active');
  })

});
</script>
<script>
window.dataLayer = window.dataLayer || [];
dataLayer.push({
 'ecommerce': {
   'currencyCode': '<?php echo $currency_product; ?>',
   'impressions': [
     <?php foreach ($products as $key => $product) { ?>
    {
      'name': "<?php echo $product['name']; ?>",
      'id': '<?php echo $product['product_id']; ?>',
      'price': '<?php echo rtrim(preg_replace("/[^0-9\.]/", "", ($product['special'] ? $product['special'] : $product['price'])), '.'); ?>',
      'brand': '<?php echo $product['manufacturer']; ?>',
      'category': '<?php echo $heading_title; ?>',
      'position': <?php echo $key+1; ?>
    },
  <?php } ?>
  ]
 },
 'event': 'gtm-ee-event',
 'gtm-ee-event-category': 'Enhanced Ecommerce',
 'gtm-ee-event-action': 'Product Impressions',
 'gtm-ee-event-non-interaction': 'True',
});
</script>
<!--<script>
    $(document).ready(function(){
        $(".maincatalog-menu-back-2").mouseover(function(){
            leftHeight();
        });

        function leftHeight(){
            var m = $(".maincatalog-menu-back-2").outerHeight() - 21;
            $(".maincatalog-menu-back-3").css('min-height', m);
        }
        leftHeight();
        $('.main-category-block').hover(function(){
            $(this).addClass('hover-main-category');
        },
        function(){
            $(this).removeClass('hover-main-category');
        });
        $('.main-category-block').mouseenter(function(){
            var thiscategoryblock1 = $(this);
            if(thiscategoryblock1.hasClass('hover-main-category')){
                 $("body").addClass('pushy-active');
            $('.maincatalog-menu-back-2').addClass('dropdown-category-hover');
            $('.catalog-board-arrow').addClass('catalog-arrow-active');
            $('.button-link-catalog').addClass('button-link-catalog-active');
            $('.submenu').removeClass('submenu-open');
        }
        });

           $('.all-inline-category').mouseleave(function(e){
            var thiscategoryblock = $('.main-category-block');
                if(!thiscategoryblock.hasClass('hover-main-category')){
                $("body").removeClass('pushy-active');
                $('.maincatalog-menu-back-2').removeClass('dropdown-category-hover');
                $('.button-link-catalog').removeClass('button-link-catalog-active');
                $('.catalog-board-arrow').removeClass('catalog-arrow-active');}
        });
        $('.js_drop_height').mouseenter(function(){
            var elem=$(this).parent();
            var a=elem.children('a');
            a.addClass('right_dropdown_hovered');
            a.find('.arrow-category').addClass('arrow_howered');
        });
        $('.js_drop_height').mouseleave(function(){
            var elem=$(this).parent();
            var a=elem.children('a');
            a.removeClass('right_dropdown_hovered');
             a.find('.arrow-category').removeClass('arrow_howered');
        });
         $('.maincatalog-list-2 .j-menu-level2-item').hover(function(){
            //$(this).addClass('hover');
        },
            function(){
                //$(this).removeClass('hover');
        });

          // Присваиваем координаты для предыдущей позиции курсора
    var x2 = 0;
    var y2 = 0;

    // Известные координаты нижних углов треугольника
    var x1 = 278;
    var y1 = 0;
    var x3 = 278;
    var y3 = 530;

    // Присваиваем зничение вспомогательной переменной
    var in_delta = false;

    // При наведении на меню так же присваиваем ей false
    /*$('.submenu').mouseenter(function() {
        in_delta = false;
    });*/
    $('.j_fiels_submenu').mouseenter(function() {
        in_delta = false;
    });

    // Ну и теперь самое главное событие
    $('.maincatalog-list-2 .j-menu-level2-item').mousemove(function(e) {
        var parentOffset = $(this).parent().offset();

        // Берем текущие координаты курсора
        var x0 = e.pageX - parentOffset.left;
        var y0 = e.pageY - parentOffset.top;

        // Ну и теперь простая формула для определения находится ли курсор в треугольнике
        var z1 = (x1 - x0) * (y2 - y1) - (x2 - x1) * (y1 - y0);
        var z2 = (x2 - x0) * (y3 - y2) - (x3 - x2) * (y2 - y0);
        var z3 = (x3 - x0) * (y1 - y3) - (x1 - x3) * (y3 - y0);
        if ((z1 > 0 && z2 > 0 && z3 > 0) || (z1 < 0 && z2 < 0 && z3 < 0)) {
            in_delta = true;
        } else {
            // Здесь непосредственно нужный нам код для показа меню
              var b=$(this).data('menu-vertical-id');
        $('.maincatalog-menu-item[data-menu-id ='+ b+']').trigger('mouseenter');

            /*$('.submenu').removeClass('submenu-open');
            $(this).children('.submenu').addClass('submenu-open');*/

            // И сразу же присваиваем значение нашей переменной
            in_delta = false;
        }

        // Ну и обязательно присваиваем значения координатам для "предыдущего значения положения" для следущего события
        x2 = e.pageX - parentOffset.left;
        y2 = e.pageY - parentOffset.top;
    }).mouseleave(function() {
        if (!in_delta) {
           $(this).removeClass('submenu-open')
        }
    });

    });
//menu wildberries

 $('.maincatalog-menu-item').hover(function(){
    $('.j-menu-level2-item').removeClass('hover');
    var a=$(this).data('menu-id');
    $(this).addClass('over');
     $('.j-menu-level2-item[data-menu-vertical-id ='+ a+']').addClass('hover');
   }, function(){
     var a=$(this).data('menu-id');
    $(this).removeClass('over');

   })

   $('.maincatalog-menu-item').hover(
        function(e){
            var thisElement=$(this);
            var a=$(this).data('menu-id');
            if($('.maincatalog-menu-back-3').hasClass('active') || $('.maincatalog-menu-back-2').hasClass('dropdown-category-hover')){
                $('.maincatalog-menu-item').removeClass('hover');
                $('.maincatalog-menu-back-3').removeClass('active');
                $(this).addClass('hover');
                $('.maincatalog-menu-back-3[data-menu-id ='+ a+']').addClass('active');

                //$('.maincatalog-menu-back-2').addClass('dropdown-category-hover');
            }else{
               setTimeout(function(){
                if(thisElement.hasClass('over')){


                     thisElement.addClass('hover');
                     $('.maincatalog-menu-back-3[data-menu-id ='+ a+']').addClass('active');
                     $('.maincatalog-menu-back-2').addClass('dropdown-category-hover');
                    $('.catalog-board-arrow').addClass('catalog-arrow-active');
                         $("body").addClass('pushy-active');

                 }

            }, 800)
            }
});

     $('.all-inline-category').mouseleave(function(e){
        $('.maincatalog-menu-item').removeClass('hover');
        $('.maincatalog-menu-back-3').removeClass('active');
        $('.maincatalog-menu-back-2').removeClass('dropdown-category-hover');
        $('.j-menu-level2-item').removeClass('hover');
        $('.catalog-board-arrow').removeClass('catalog-arrow-active');


    })

</script>-->
<script>
/*$(document).ready(function(){
  $('.product-layout.product-grid').each(function(){
    $(this).css('height', $(this).height());
  })
})*/
</script>
<script>
  $(document).ready(function () {
    $('.scoreboard_oc_filter').hide();
    var total = $('.remove_filter-parameter.btn-danger').length;
    if(total != 0 ) {
      $('.scoreboard_oc_filter').show();
      $('.scoreboard_oc_filter').html(total);
    }
  });
</script>
<?php echo $footer; ?>
