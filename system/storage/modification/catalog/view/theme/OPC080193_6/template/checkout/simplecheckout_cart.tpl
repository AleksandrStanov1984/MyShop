<div class="simplecheckout-block" id="simplecheckout_cart" <?php echo $hide ? 'data-hide="true"' : '' ?> <?php echo $has_error ? 'data-error="true"' : '' ?>>
<?php if ($display_header) { ?>
    <div class="checkout-heading panel-heading"><?php echo $text_cart ?></div>
<?php } ?>
<?php if ($attention) { ?>
    <div class="alert alert-danger simplecheckout-warning-block"><?php echo $attention; ?></div>
<?php } ?>
<?php if ($error_warning) { ?>
    <div class="alert alert-danger simplecheckout-warning-block"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="header-simplecheckout-cart"><?php echo $text_title_simplecart; ?></div>
    <div class="table-responsive table-simple-cart">
        <table class="simplecheckout-cart">
            <colgroup>
                <col class="image">
                <col class="name">
                <col class="size">
                <col class="model">
                <col class="quantity">
                <col class="price">
                <col class="total">
                <col class="remove">
            </colgroup>
            <thead>
                <tr>
                    <th class="image"></th>
                    <th class="name"><?php echo $column_name; ?></th>
                    <th class="size-column"><?php echo $column_size; ?></th>
                    <th class="model"><?php echo $column_model; ?></th>
					<th class="quantity"><?php echo $column_quantity; ?></th>
                    <th class="price"><?php echo $column_price; ?></th>
                    <th class="total"><?php echo $column_total; ?></th>
                    <th class="remove"></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product) { ?>
                <?php if (!empty($product['recurring'])) { ?>
                    <tr>
                        <td class="simplecheckout-recurring-product" style="border:none;"><img src="<?php echo $additional_path ?>catalog/view/theme/default/image/reorder.png" alt="" title="" style="float:left;" />
                            <span style="float:left;line-height:18px; margin-left:10px;">
                            <strong><?php echo $text_recurring_item ?></strong>
                            <?php echo $product['profile_description'] ?>
                            </span>
                        </td>
                    </tr>
                <?php } ?>
                <tr class="tr-simple-cart">
                    <td class="image">
                        <?php if ($product['thumb']) { ?>
                            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
                        <?php } ?>
                    </td>
                    <td class="name">
                        <?php if ($product['thumb']) { ?>
                            <div class="image">
                                <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
                            </div>
                        <?php } ?>
                        <a href="<?php echo $product['href']; ?>" class="simple-name-product"><!--<?php echo $product['model']; ?>--> <?php echo $product['name']; ?></a>
                        <!--<div class="simple-block-model">
                            <?php echo $product['model']; ?>
                        </div>-->
                        <div class="size-column-mob">
                        <?php if ($product['height']){ ?>
                        <span class="units-product"><?php echo $unit_h; ?>:</span> <?php echo $product['height'] ?><?php } ?><?php if ($product['width']){ ?> <span class="units-product"> <?php echo $unit_w; ?>:</span> <?php echo $product['width'] ?><?php } ?> <?php if ($product['height']){ ?><span class="units-product"> <?php echo $unit_l; ?>:</span> <?php echo $product['length'] ?><?php } ?>
                        <?php if ($product['diameter_of_pot']){ ?>
                        <img src="catalog/view/theme/OPC080193_6/images/diameter_of_pot.svg" class="img-diameter-of-pot img-icon-pot" alt="diameter"> <?php echo $product['diameter_of_pot'];?> <?php echo $unit; ?> <?php } ?><?php if ($product['depth_of_pot']){ ?> <img src="catalog/view/theme/OPC080193_6/images/depth_of_pot.svg" class="img-depth-of-pot img-icon-pot" alt="depth"><?php echo $product['depth_of_pot'];?> <?php echo $unit; ?><?php } ?>

                        </div>
                        <?php if (!$product['stock'] && ($config_stock_warning || !$config_stock_checkout)) { ?>
                            <span class="product-warning">***</span>
                        <?php } ?>
                        <div class="options">
                        <?php foreach ($product['option'] as $option) { ?>
                        &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small><br />
                        <?php } ?>
                        <?php if (!empty($product['recurring'])) { ?>
                        - <small><?php echo $text_payment_profile ?>: <?php echo $product['profile_name'] ?></small>
                        <?php } ?>
                        </div>
                        <?php if ($product['reward']) { ?>
                        <small><?php echo $product['reward']; ?></small>
                        <?php } ?>
                    </td>
                     <td class="size-column">
                        <?php if ($product['height']){ ?>
                        <span class="units-product"><?php echo $unit_h; ?>:</span> <?php echo $product['height'] ?><?php } ?><?php if ($product['width']){ ?> <span class="units-product"> <?php echo $unit_w; ?>:</span> <?php echo $product['width'] ?><?php } ?> <?php if ($product['height']){ ?><span class="units-product"> <?php echo $unit_l; ?>:</span> <?php echo $product['length'] ?><?php } ?>
                        <?php if ($product['diameter_of_pot']){ ?>
                        <img src="catalog/view/theme/OPC080193_6/images/diameter_of_pot.svg" class="img-diameter-of-pot img-icon-pot" alt="diameter"> <?php echo $product['diameter_of_pot'];?> <?php echo $unit; ?> <?php } ?><?php if ($product['depth_of_pot']){ ?> <img src="catalog/view/theme/OPC080193_6/images/depth_of_pot.svg" class="img-depth-of-pot img-icon-pot" alt="depth"><?php echo $product['depth_of_pot'];?> <?php echo $unit; ?><?php } ?> </td>
                    <td class="model"></td>
					<td class="quantity">
                        <div class="input-group btn-block" style="max-width: 200px;">
                            <span class="input-group-btn">
                                <button class="count-minus" data-onclick="decreaseProductQuantity" data-toggle="tooltip" type="submit">&#8211;
                                </button>
                            </span>
                            <input class="form-control input-qnt-simle" type="text" data-onchange="changeProductQuantity" <?php echo $quantity_step_as_minimum ? 'onfocus="$(this).blur()" data-minimum="' . $product['minimum'] . '"' : '' ?> name="quantity[<?php echo !empty($product['cart_id']) ? $product['cart_id'] : $product['key']; ?>]" value="<?php echo $product['quantity']; ?>" size="1" />
                            <span class="input-group-btn">
                                <button class="count-plus" data-onclick="increaseProductQuantity" data-toggle="tooltip" type="submit">+
                                </button>

                            </span>
                        </div>
                    </td>
                    <td class="price">
                <?php if (isset($product['base_price'])&&$product['base_price']) { ?><del><?php echo $product['base_price']; ?></del><br><?php } ?>
                <span class="price-new-simple"><?php echo $product['price']; ?></span></td>
                    <td class="total"><?php echo $product['total']; ?></td>
                    <td class="remove">
						<button class="btn-remove-simple" data-onclick="removeProduct" data-product-key="<?php echo !empty($product['cart_id']) ? $product['cart_id'] : $product['key'] ?>" data-toggle="tooltip" type="button">
                        </button>
					</td>
                    <div class="clear"></div>
                </tr>
                <?php } ?>
                <?php foreach ($vouchers as $voucher_info) { ?>
                    <tr>
                        <td class="image"></td>
                        <td class="name"><?php echo $voucher_info['description']; ?></td>
                        <td class="model"></td>
                        <td class="quantity">
                            <div class="input-group btn-block" style="max-width: 200px;">
                                <input class="form-control" type="text" value="1" disabled size="1" />
                                <span class="input-group-btn">
                                    <button class="btn btn-danger" data-onclick="removeGift" data-gift-key="<?php echo $voucher_info['key']; ?>" type="button">
                                        <i class="fa fa-times-circle"></i>
                                    </button>
                                </span>
                            </div>
                        </td>
                        <td class="price"><?php echo $voucher_info['amount']; ?></td>
                        <td class="total"><?php echo $voucher_info['amount']; ?></td>
                        <td class="remove"></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<div class="table-simple-cart-under">
<div class="crw-and-undate">
<div class="block-simple-crw">
    <?php /* if (isset($modules['coupon'])) { ?>
    <div class="simplecheckout-cart-total block-simple-coupon">
        <span class="inputs"><span class="label-counon-simple"><?php echo $entry_coupon; ?>&nbsp;</span><input class="form-control form-control-simple" type="text" data-onchange="reloadAll" name="coupon" value="<?php echo $coupon; ?>" placeholder="<?php echo $placeholder_cupon; ?>" /></span>
    </div>
<?php } */ ?>
<?php if (isset($modules['reward']) && $points > 0) { ?>
    <div class="simplecheckout-cart-total">
        <span class="inputs"><?php echo $entry_reward; ?>&nbsp;<input class="form-control form-control-simple" type="text" name="reward" data-onchange="reloadAll" value="<?php echo $reward; ?>" /></span>
    </div>
<?php } ?>
<?php if (isset($modules['voucher'])) { ?>
    <div class="simplecheckout-cart-total">
        <span class="inputs"><?php echo $entry_voucher; ?>&nbsp;<input class="form-control form-control-simple" type="text" name="voucher" data-onchange="reloadAll" value="<?php echo $voucher; ?>" /></span>
    </div>
<?php } ?>


</div>
<?php if ((isset($modules['reward']) && $points > 0) || isset($modules['voucher'])) { ?>
    <div class="simplecheckout-cart-total simplecheckout-cart-buttons block-update-crw">
      <span class="inputs buttons"><a id="simplecheckout_button_cart" data-onclick="reloadAll" class="btn"><?php echo $button_update; ?></a></span>
    </div>
<?php } ?>
</div>
<div class="right-block-with-totals">

<?php foreach ($totals as $total) { ?>
    <div class="simplecheckout-cart-total block-simple-total" id="total_<?php echo $total['code']; ?>">
        <span class="label-simple-total"><span><?php echo $total['title']; ?>:</span></span>
        <span class="simplecheckout-cart-total-value"><span><?php echo $total['text']; ?></span></span>
        <span class="simplecheckout-cart-total-remove" style="display: none;">
            <?php if ($total['code'] == 'coupon') { ?>
                <i data-onclick="removeCoupon" title="<?php echo $button_remove; ?>" class="fa fa-times-circle"></i>
            <?php } ?>
            <?php if ($total['code'] == 'voucher') { ?>
                <i data-onclick="removeVoucher" title="<?php echo $button_remove; ?>" class="fa fa-times-circle"></i>
            <?php } ?>
            <?php if ($total['code'] == 'reward') { ?>
                <i data-onclick="removeReward" title="<?php echo $button_remove; ?>" class="fa fa-times-circle"></i>
            <?php } ?>
        </span>
    </div>
<?php } ?>
</div>
</div>


<input type="hidden" name="remove" value="" id="simplecheckout_remove">
<div style="display:none;" id="simplecheckout_cart_total"><?php echo $cart_total ?></div>
<?php if ($display_weight) { ?>
    <div style="display:none;" id="simplecheckout_cart_weight"><?php echo $weight ?></div>
<?php } ?>
<?php if (!$display_model) { ?>
    <style>
    .simplecheckout-cart col.model,
    .simplecheckout-cart th.model,
    .simplecheckout-cart td.model {
        display: none;
    }
    </style>
<?php } ?>
</div>
