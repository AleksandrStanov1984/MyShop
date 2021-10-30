<div class="box">
 <ul class="list-account <?php echo $route; ?>">
  <!--<?php if (!$logged) { ?>
  <li class="list-account-item">
  <a href="<?php echo $login; ?>" ><?php echo $text_login; ?></a> <a href="<?php echo $register; ?>" class="list-account-item"><?php echo $text_register; ?></a> <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
  </li>
  <?php } ?>
  <li class="list-account-item">
  <a href="<?php echo $account; ?>"><?php echo $text_account; ?></a>
  </li>-->
  <?php if ($logged) { ?>

  <li class="list-account-item accoun-item-logged <?php echo $route == "account/edit" || $route == "account/login"  ? 'active' : ''; ?>">
    <a href="<?php echo $edit; ?>">
      <?php echo $text_edit; ?></a>
  </li>
  <!--<li class="list-account-item <?php echo $route == "account/password" ? 'active' : ''; ?>">
    <a href="<?php echo $password; ?>"><?php echo $text_password; ?></a>
  </li> -->

  <li class="list-account-item accoun-item-logged  <?php echo $route == "account/order" ? 'active' : ''; ?>">
  <a href="<?php echo $order; ?>"><?php echo $text_order; ?></a>
  </li>
  <?php } ?>
  <li class="list-account-item <?php echo $logged ? 'accoun-item-logged' : 'accoun-item-no-logged' ?>" data-remodal-target="modal-cart">
    <a href="#" ><?php echo $text_cart; ?> (<?php echo $countcart; ?>)</a>
  </li>
  <li class="list-account-item <?php echo $logged ? 'accoun-item-logged' : 'accoun-item-no-logged' ?> <?php echo $route == "account/wishlist" ? 'active' : ''; ?>">
    <a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a>
  </li>

  <!--
 <li class="list-account-item <?php echo $route == "account/address" ? 'active' : ''; ?>">
    <a href="<?php echo $address; ?>"><?php echo $text_address; ?></a>
  </li>
    <a href="<?php echo $download; ?>" class="list-account-item"><?php echo $text_download; ?></a>-->
  <!--<li class="list-account-item <?php echo $route == "account/order" ? 'active' : ''; ?>">
    <a href="<?php echo $recurring; ?>"><?php echo $text_recurring; ?></a>
  </li>
  <li class="list-account-item <?php echo $route == "account/reward" ? 'active' : ''; ?>">
    <a href="<?php echo $reward; ?>"><?php echo $text_reward; ?></a>
  </li>
  <li class="list-account-item <?php echo $route == "account/return" ? 'active' : ''; ?>">
  <a href="<?php echo $return; ?>" ><?php echo $text_return; ?></a>
  </li>
  <li class="list-account-item <?php echo $route == "account/transaction" ? 'active' : ''; ?>">
  <a href="<?php echo $transaction; ?>" ><?php echo $text_transaction; ?></a>
  </li>
  <li class="list-account-item <?php echo $route == "account/newsletter" ? 'active' : ''; ?>" >
  <a href="<?php echo $newsletter; ?>" ><?php echo $text_newsletter; ?></a>
  </li>
  <?php if ($logged) { ?>
  <li class="list-account-item">
  <a href="<?php echo $logout; ?>" ><?php echo $text_logout; ?></a>
  </li>
  <?php } ?>
  -->
</ul>

</div>
