<div class="remodal-overlay remodal-is-opened" style="display: block;"></div>
<div class="remodal-wrapper remodal-is-opened" style="display: block;">
<?php foreach($categories as $category){ ?>

<div class="remodal modal-catalog remodal-is-initialized remodal-is-opened" data-remodal-id="modal-catalog<?php echo $category['category_id'] ?>" id="modal-catalog">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="modal-catalog-list">
        <?php foreach($category['products'] as $product){ ?>
        <div class="item">
            <div class="text-center image" >
                <a href="<?php echo $product['href'] ?>"><img src="<?php echo $product['thumb'] ?>" alt="<?php echo $product['name'] ?>" title="<?php echo $product['name'] ?>" class="img-thumbnail"></a>
            </div>
            <div class="text-left name">
                <a href="<?php echo $product['href'] ?>">
                    <div class="size-mobile"><?php echo $product['height'] ?>x<?php echo $product['width'] ?>x<?php echo $product['length'] ?></div> 
                    <div class="shelf-mobile"><span class="shelf_txt"><span class="shelf_qty"><?php echo $product['quantity_shelves']; ?></span><?php if (in_array($product['quantity_shelves'], array( 2, 3, 4))) { ?> полки <?php } elseif ($product['quantity_shelves'] == '1') {?> полкa <?php } else {?> полок <?php } ?> </b></span> </div> 
                    <div class="shelf-mobile3"><span class="shelf_txt">На одну полку: </span> <span class="shelf_qty"><?php echo $product['maximum_weight']; ?></span><span class="shelf_txt">&nbsp;кг</span></div>
                    <div class="shelf-mobile3"><span class="shelf_txt">Цвет: <b><?php echo $product['color_shelves']; ?></b></span></div> 
                    <div class="shelf-mobile2"><span class="shelf_txt">Модель: <b><?php echo $product['model'] ?></b></span></div>
                </a>
            </div>
            <div class="text-right total">
                <?php if($product['quantity'] > 0){ ?>
                <div class="price-list">
                    <?php if($product['special']){ ?>
                    <div class="price-old"><b><?php echo $product['price'] ?></b></div>
                    <div class="price-new"><b><?php echo $product['special'] ?></b></div>
                    <?php }else{ ?>
                    <div class="price-regular"><b><?php echo $product['price'] ?></b></div>
                    <?php } ?>
                </div>
                <?php }else{ ?>
                <div class="price-list">
                    <?php if($product['special']){ ?>
                    <div class="price-old"><b><?php echo $product['price'] ?></b></div>
                    <div class="price-new"><b><?php echo $product['special'] ?></b></div>
                    <?php }else{ ?>
                    <div class="price-regular outofstock"><b><?php echo $product['price'] ?></b></div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
            <div class="text-right button">
                <?php if($product['quantity'] > 0){ ?>
                <a href="#" onclick="cart.add('<?php echo $product['product_id'] ?>')" class="btn btn-buy"><?php echo $text_buy ?></a>
                <?php }else{ ?>
                <span class="outofstock btn btn-off"><?php echo $outofstock; ?></span>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>
<?php } ?> 
</div>