

<?php foreach($attribute_info as $attribute_id => $attribute_info){?>
  <div class="attribute_group_item">
    <span><?php echo $attribute_info['name']; ?></span>
    <?php foreach($attribute_variants['attribute-'.$attribute_id] as $value){?>
      <div class="attribute_value">
        <?php echo $value; ?>
      </div>
    <?php } ?>    
  </div>
<?php } ?>

<?php if($products) { ?>
<div id="hpmodel" class="form-group">
  <?php if($name_as_title){ ?>
  <div class="hpm-mame"><?php echo $title_name;?> <span class="after_title"></span></div>
  <?php } ?>
  <div class='hpmodel_type_images text-center'>
    <?php foreach($products as &$product) { ?>
    <div class='hpm-item hpm-item-<?php echo $product['product_id']; ?> <?php echo $product['product_id'] == $selected_product_id ? 'active' : ''; ?> text-center pull-left thumbnail hidden-of-next<?php echo $product['product_id'];?> <?php if ($product['quantity'] > 0) { echo ' stock-on ';} else { echo ' stock-off ';} ?>'>
      <input type='hidden' data-title="<?php echo $product['after_title'];?>" data-hash="<?php echo preg_replace('/[\s,.+\-]+/','-',$product['product_id']); ?>" name='series_product_id' value="<?php echo $product['product_id'];?>">
 
      
      <?php foreach ($product['view'] as $column => $value) { ?>
      <div class="hpm-col-<?php echo $column; ?>">
        <?php echo $value; ?> ***
      </div>
      <div class="clearfix top10"></div>
      <?php } ?>
    </div>
    <?php } ?>
  </div>
</div>
<?php echo $config; ?>
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
function hpmodel_rri(r, ri) {
    for (s in r) { $(s).html(r[s]); }
    for (s in ri) { $i = $(s).val(ri[s]); v = hpmodel.input[s]; if (v) $i.trigger(v); }
    if (typeof hmodel_onchange === 'function') hmodel_onchange();
    if (typeof autocalc_init === 'function') autocalc_init();
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
            var $d=$(h); var r = []; var ri = [];
            <?php if ($replace_h1) { ?>document.title=$d.filter('title').text();<?php } ?>
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