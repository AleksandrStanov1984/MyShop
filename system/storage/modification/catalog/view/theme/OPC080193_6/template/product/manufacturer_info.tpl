<?php echo $header; ?>
<?php if(isset($microdata_breadcrumbs) && $microdata_breadcrumbs) echo $microdata_breadcrumbs; ?>
<?php if(isset($microdata) && $microdata) echo $microdata; ?>
<div class="wrapper">  <?php if(!$is_mobile){  ?> <?php echo $content_top; ?> <?php } ?>
      <ul class="breadcrumb__list" <?php echo $content_top ? 'style="margin-top:10px"' : ''; ?>>
        <?php $pop_breadcrs = array_pop($breadcrumbs); foreach ($breadcrumbs as $breadcrumb) { ?>
          <li class="breadcrumb__item"><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
    <li><?php echo $pop_breadcrs['text']; ?></li>
      </ul>
</div>
<div class="panel-sfv-catalogs visible-xs">
  <div class="wrapper">
    <div class="ul-sfv-catalogs">
      <div class="sort-panel"><img src="catalog/view/theme/OPC080193_6/images/page_category/sort.svg" alt="sort">Сортировка
      </div>
      <div class="view view-check-grid" id="view-list-fake"><img src="catalog/view/theme/OPC080193_6/images/page_category/view-list.svg" class="img-view-prod" alt="view">
      </div>
    </div>
  </div>
</div>
<div class="wrapper">
  <div class="row"><?php echo $column_left; ?>
  <?php if ($column_left && $column_right) { ?>
  <?php $class = 'col-sm-6'; ?>
  <?php } elseif ($column_left || $column_right) { ?>
  <?php $class = 'col-md-9'; ?>
  <?php } else { ?>
  <?php $class = 'col-sm-12'; ?>
  <?php } ?>
    <div id="content" class="<?php echo $class; ?> product-category" data-url="<?php echo $categ_url; ?>" data-limit="<?php echo $limit_per_page; ?>">
      <h1 class="title-page-category"><?php echo $heading_title; ?></h1>
      <?php if ($products) { ?>
      <div class="row">
        <div class="col-md-2 col-sm-6 hidden">
          <div class="btn-group btn-group-sm">
            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
            <button type="button" id="photo-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_foto; ?>"><i class="fa fa-image"></i></button>
          </div>
        </div>
        <div class="col-sm-12 col-xs-6 i-sort hidden-xs">
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
        <div class="product-layout <?php echo $is_mobile ? 'product-list' : 'product-grid' ?> <?php if ($column_left || $column_right) {echo 'col-xl-3 col-lg-4 col-md-4 col-sm-6 col-6';}elseif($column_left && $column_right){echo 'col-lg-6 col-md-6 col-sm-12 col-12';} else{echo 'col-lg-2 col-md-3 col-sm-6 col-6';} ?> <?php echo $product['hpm_block_model_id']; ?>" <?php echo !empty($product['hpm_block']) ? 'data-exist="exist-hpm"': ''?> <?php echo !empty($product['hpm_block_model_id']) ? 'data-model_id="model_id_'.$product['hpm_block_model_id'].'"': ''?> <?php echo (isset($product['in_stock'])&&$product['in_stock'])? '' : 'style="opacity: 0.5"' ?>>
          <!--product_in_listingEX-->
          <div data-product-id="<?php echo $product['product_id']; ?>" class="item ">
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
           <div><span class="stickers_free"><img src="catalog/view/theme/OPC080193_6/image/stickers/sticker_free.svg" alt=""> <span>Бесплатная доставка</span></span></div>
           <?php }?>
           <?php }?>
       </div>
     <?php }?>
     <div class="couple_btn">
      <button type="button" class="btn-wishlist btn-wishlist-incatalog <?php echo $product['wish'] ? 'added_alredy' : ''; ?>"  data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><img src="<?php echo $product['wish'] ? 'catalog/view/theme/OPC080193_6/images/page_product/heart.svg' : 'catalog/view/theme/OPC080193_6/images/page_category/favorites.svg'; ?>" alt="wishlist"></button>
        <button type="button" data-toggle="tooltip" title="В сравнение" onclick="compare.add('94902');"><img src="catalog/view/theme/OPC080193_6/images/page_category/compare_gray.svg" alt="compare"></button>
      </div>
     <div class="image"><a href="<?php echo $product['href']; ?>" data-hpm-href="1">
                <img src="image/loader-gray.gif" data-src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" class="img-responsive lazy-sz" title="<?php echo $product['name']; ?>"/></a></div>

        <?php echo !empty($product['hpm_block']) ? $product['hpm_block'] : ''; ?>
      
            <div class="all-info-product">
              <div class="size">
                <?php if ($product['height']){ ?>
                <span class="units-product"><?php echo $unit_h; ?>:</span> <span><?php echo $product['height'] ?></span><?php } ?><?php if ($product['width']){ ?><span class="units-product"><?php echo $unit_w; ?>:</span> <span><?php echo $product['width'] ?></span><?php } ?><?php if ($product['height']){ ?><span class="units-product"><?php echo $unit_l; ?>:</span> <span><?php echo $product['length'] ?></span><?php } ?>
                <?php if ($product['diameter_of_pot']){ ?>
                <img src="catalog/view/theme/OPC080193_6/images/diameter_of_pot.svg" class="img-diameter-of-pot img-icon-pot" alt="diameter"> <?php echo $product['diameter_of_pot'];?> <?php echo $unit; ?> <?php } ?><?php if ($product['depth_of_pot']){ ?> <img src="catalog/view/theme/OPC080193_6/images/depth_of_pot.svg" class="img-depth-of-pot img-icon-pot" alt="depth"><?php echo $product['depth_of_pot'];?> <?php echo $unit; ?><?php } ?>
              </div>
              <a class="name" href="<?php echo $product['href']; ?>" data-hpm-href="1"><?php echo $product['name']; ?></a>
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
                  <a href="javascript:void(0);" onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');" class="btn-buy <?php echo $product['incart'] ? 'added_to_cart' : ''; ?>"><span class="card-img <?php echo $product['incart'] ? 'basket_done' : 'basket_empty'; ?>"></span><span class="btn-buy-text"><?php echo $button_cart; ?></span>
                  </a>
                </div>
              </div>
              <div class="stock_status"><?php echo $product['stock_status'] ?></div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><?php //echo $pagination; ?><div class="pagination"></div></div>
          <!--<div class="col-sm-6 text-right"><?php echo $results; ?></div>-->
      </div>
      <?php } ?>
      <?php if (!$products) { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
          <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>

      <?php echo $column_right; ?>
    </div>
  </div>

</div>
 <?php if(!$is_mobile ){  ?>
<div class="wrapper-1180 content-bottom-category"><?php echo $content_bottom; ?></div>
  <?php } ?>
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
<script>
$(document).ready(function () {
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
      'name': '<?php echo $product['name']; ?>',
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

<?php echo $footer; ?>
