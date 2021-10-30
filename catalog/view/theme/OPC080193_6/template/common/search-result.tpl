<section class="block-result" id="search_result">
    <div class="wrapper">
        <div class="list-products catalog-mobile">
            <?php foreach ($category['products'] as $product) { ?>
            <div class="item block-products">
                <div class="image"><a href="<?php echo $product['href'] ?>">
                    <?php if($product['special']){ ?><div class="image_action">Акция</div><?php }; ?>
                    <img src="<?php echo $product['thumb'] ?>" alt="" /></a></div>
                <div class="size"><?php echo $product['height'] ?>x<?php echo $product['width'] ?>x<?php echo $product['length'] ?></div>
                <a class="model" href="<?php echo $product['href'] ?>"><b><?php echo $product['model'] ?></b></a>
                <a class="name" href="<?php echo $product['href'] ?>"><?php echo $product['name'] ?></a>                                
                
                <?php if($product['quantity'] > 0){ ?>
                <div class="product-panel">
                    <div class="price">
                        <?php if($product['special']){ ?>
                        <div class="price-old"><?php echo $product['price'] ?></div>
                        <div class="price-new"><?php echo $product['special'] ?></div>
                        <?php }else{ ?>
                        <div class="price-regular"><?php echo $product['price'] ?></div>
                        <?php } ?>
                    </div>
                    <?php }else{ ?>
                    <div class="price outofstock">
                        <?php if($product['special']){ ?>
                        <div class="price-old"><?php echo $product['price'] ?></div>
                        <div class="price-new"><?php echo $product['special'] ?></div>
                        <?php }else{ ?>
                        <div class="price-regular outofstock"><?php echo $product['price'] ?></div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                    <?php if($product['quantity'] > 0){ ?>
                    <div class="button"><a href="#" onclick="cart.add('<?php echo $product['product_id'] ?>')" class="btn btn-buy"><?php echo $text_buy ?></a></div>
                    <?php }else{ ?>
                    <div class="button"><span class="outofstock btn btn-off"><?php echo $outofstock; ?></span></div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>
        <ul class="pagination">
            <li class="pagination_arrow pagination_prev"><a href="https://opencart23.webdevelop.in.ua/index.php?route=product/search&amp;search=a&amp;description=true&amp;page=2"></a></li>
            <li class="pagination_item active"><span>1</span></li>
            <li class="pagination_item"><a href="https://opencart23.webdevelop.in.ua/index.php?route=product/search&amp;search=a&amp;description=true&amp;page=2">2</a></li>            
            <li class="pagination_arrow pagination_next"><a href="https://opencart23.webdevelop.in.ua/index.php?route=product/search&amp;search=a&amp;description=true&amp;page=2"></a></li>
        </ul>
    </div>
</section>