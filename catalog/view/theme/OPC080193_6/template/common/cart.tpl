<div class="cart-body" id="cart">
    <?php if ($products || $vouchers) { ?>
	<div class="modal-cart-list">
		<?php foreach ($products as $product) { ?>
		<div class="item" id="product<?php echo $product['cart_id'] ?>">
      <div class="item_top_content">
        <div class="text-center image">
  				<?php if ($product['thumb']) { ?>
  					<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a>
  				<?php } ?>
  			</div>
        <div class="name">
          <a class="text-left" href="<?php echo $product['href']; ?>">
            <div class="product-size"> <?php if ($product['height']){ ?>
              <span class="units-product"><?php echo $unit_h; ?>:</span> <?php echo $product['height'] ?><?php } ?><?php if ($product['width']){ ?> <span class="units-product"> <?php echo $unit_w; ?>:</span> <?php echo $product['width'] ?><?php } ?> <?php if ($product['height']){ ?><span class="units-product"> <?php echo $unit_l; ?>:</span> <?php echo $product['length'] ?><?php } ?>
              <?php if ($product['diameter_of_pot']){ ?>
              <img src="catalog/view/theme/OPC080193_6/images/diameter_of_pot.svg" class="img-diameter-of-pot img-icon-pot" alt="diameter"> <?php echo $product['diameter_of_pot'];?> <?php echo $unit; ?> <?php } ?><?php if ($product['depth_of_pot']){ ?> <img src="catalog/view/theme/OPC080193_6/images/depth_of_pot.svg" class="img-depth-of-pot img-icon-pot" alt="depth"><?php echo $product['depth_of_pot'];?> <?php echo $unit; ?><?php } ?></div>
            <div class="product-name"><?php echo $product['name']; ?></div>
            <!--<div class="product-model"><?php echo $product['model']; ?></div>-->
          </a>
        </div>
        <div class="col-qnt">
          <div class="quantity spinbox">
            <a href="javascript:void(0)" class="quantity-minus spin-minus" onclick="cart.updateCart('<?php echo $product['id']; ?>', '<?php echo $product['cart_id']; ?>', '-')">&#8211;</a>
            <input class="quantity-input" type="text" name="<?php echo $product['cart_id']; ?>" value="<?php echo $product['quantity']; ?>" onchange="cart.updateCart('<?php echo $product['id']; ?>', '<?php echo $product['cart_id']; ?>')">
            <?php if (!$product['stock']) { ?>
              <?php if ($product['quantity'] < $product['maximum']) { ?>
                <a href="javascript:void(0)" class="quantity-plus spin-plus" onclick="cart.updateCart('<?php echo $product['id']; ?>', '<?php echo $product['cart_id']; ?>', '+')">+</a>
              <?php } else { ?>
                <a href="javascript:void(0)" class="quantity-plus spin-plus" style="opacity:0.5; cursor:default">+</a>
              <?php } ?>
            <?php } else { ?>
              <a href="javascript:void(0)" class="quantity-plus spin-plus" onclick="cart.updateCart('<?php echo $product['id']; ?>', '<?php echo $product['cart_id']; ?>', '+')">+</a>
            <?php } ?>
          </div>
        </div>
        <div class="text-right total">
          <div class="total_base_price"><?php echo $product['total_base_price']; ?></div>
          <div class="total_special_price"><?php echo $product['total']; ?></div>
        </div>
      </div>
		  <div class="remove">
          <button type="button" id="button_wishlist<?php echo $product['id']; ?>" class="wishlist-in-cart <?php echo $product['wish'] ? 'added_to_wishlist' : '' ?>" onclick="wishlist.add('<?php echo $product['id']; ?>');">
            <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.0515 1.74868C12.4103 1.01996 11.5208 0.618652 10.5469 0.618652C9.1771 0.618652 8.30988 1.43806 7.8236 2.12548C7.69744 2.30386 7.59011 2.48272 7.5 2.65103C7.40989 2.48272 7.30259 2.30386 7.1764 2.12548C6.69012 1.43806 5.8229 0.618652 4.45313 0.618652C3.47919 0.618652 2.58968 1.01999 1.94847 1.74871C1.33686 2.44386 1 3.37486 1 4.37021C1 5.45367 1.42232 6.4614 2.32907 7.54154C3.13946 8.50693 4.30533 9.50202 5.65537 10.6543C6.15844 11.0837 6.67866 11.5277 7.23251 12.0131L7.24914 12.0277C7.32095 12.0907 7.41047 12.1221 7.5 12.1221C7.58953 12.1221 7.67906 12.0906 7.75086 12.0277L7.76749 12.0131C8.32134 11.5277 8.84157 11.0837 9.34471 10.6543C10.6947 9.50204 11.8605 8.50695 12.6709 7.54154C13.5777 6.46138 14 5.45367 14 4.37021C14 3.37486 13.6631 2.44386 13.0515 1.74868Z" stroke="<?php echo $product['wish'] ? '#6F38AB' : '#959595' ?>" stroke-width="0.5"/></svg>
            <span><?php echo $product['wish'] ? $text_in_wishlist : $text_add_wishlist; ?></span></button>
          <button type="button" onclick="cart.remove('<?php echo $product['cart_id']; ?>', '<?php echo $product['id']; ?>');" title="<?php echo $button_remove; ?>" class="btn-remove"><img src="catalog/view/theme/OPC080193_6/images/close.svg" alt="remove"><?php echo $button_remove; ?></button></div>

      </div>
    <?php } ?>
	</div>
  <div class="modal-cart-total">
          <?php foreach ($totals as $total) { ?>
          <div class="line row">
          <div class="col-md-6 free_shipping_block">
            <div class="free_shipping_title">
              Бесплатная доставка от 2000 грн
            </div>
            <progress id="free_shipping_progress" max="100" value="70"> 70% </progress>
            <div class="free_shipping_data">
              До бесплатной доставки еще 500 грн
            </div>
            <a class="free_shipping_link" href="#">Условия бесплатной доставки</a>
          </div>
          <div class="col-md-12 text-right">
            <div class="block_total">
              <span class="total_title"><?php echo $total['title']; ?>: </span>
              <span class="data_total"><?php echo $total['text']; ?></span>
            </div>

          </div>
          </div>
          <?php } ?>
        <div class="text-right button-container btn-cart-popup"><a href="javascript: void(0);" data-remodal-action="close" class="btn-xl btn-secondary"><?php echo $button_continue; ?></a><a href="<?php echo $checkout; ?>" class="btn-xl btn-main"><?php echo $text_checkout; ?></a></div>
        <div class="clear"></div>
      </div>
    <?php } else { ?>
      <p class="text-center text-empty"><?php echo $text_empty; ?></p>
    <?php } ?>
  </div>

<?php /*
<div id="cart" class="btn-group btn-block">
  <button type="button" data-toggle="dropdown" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-inverse btn-block btn-lg dropdown-toggle"><i class="fa fa-shopping-cart"></i> <span id="cart-total"><?php echo $text_items; ?></span></button>
  <ul class="dropdown-menu pull-right cart-menu">
    <?php if ($products || $vouchers) { ?>
    <li>
      <table class="table table-striped">
        <?php foreach ($products as $product) { ?>
        <tr>
          <td class="text-center"><?php if ($product['thumb']) { ?>
            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
            <?php } ?></td>
          <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
            <?php if ($product['option']) { ?>
            <?php foreach ($product['option'] as $option) { ?>
            <br />
            - <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small>
            <?php } ?>
            <?php } ?>
            <?php if ($product['recurring']) { ?>
            <br />
            - <small><?php echo $text_recurring; ?> <?php echo $product['recurring']; ?></small>
            <?php } ?></td>
          <td class="text-right">x <?php echo $product['quantity']; ?></td>
          <td class="text-right"><?php echo $product['total']; ?></td>
          <td class="text-center"><button type="button" onclick="cart.remove('<?php echo $product['cart_id']; ?>');" title="<?php echo $button_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></td>
        </tr>
        <?php } ?>
        <?php foreach ($vouchers as $voucher) { ?>
        <tr>
          <td class="text-center"></td>
          <td class="text-left"><?php echo $voucher['description']; ?></td>
          <td class="text-right">x&nbsp;1</td>
          <td class="text-right"><?php echo $voucher['amount']; ?></td>
          <td class="text-center text-danger"><button type="button" onclick="voucher.remove('<?php echo $voucher['key']; ?>');" title="<?php echo $button_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></td>
        </tr>
        <?php } ?>
      </table>
    </li>
    <li>
      <div>
        <table class="table table-bordered">
          <?php foreach ($totals as $total) { ?>
          <tr>
            <td class="text-right"><strong><?php echo $total['title']; ?></strong></td>
            <td class="text-right"><?php echo $total['text']; ?></td>
          </tr>
          <?php } ?>
        </table>
        <div class="button-container"><a href="<?php echo $checkout; ?>" class="checkout"><strong><?php echo $text_checkout; ?></strong></a></div>
      </div>
    </li>
    <?php } else { ?>
    <li>
      <p class="text-center"><?php echo $text_empty; ?></p>
    </li>
    <?php } ?>
  </ul>
</div>
*/ ?>
