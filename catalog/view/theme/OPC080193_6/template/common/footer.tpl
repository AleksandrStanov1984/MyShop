<footer class="footer">
  <div class="wrapper">
    <div class="row">
      <div class="col-xl-3 col-lg-3 col-md-3 footer-col__contact">
        <div class="tab-wrap footer-contacts">
          <div class="tab-title footer-subtitle"><?php echo $subtitle_contact; ?></div>
          <div class="tab-content tab-contact">
            <div class="callback-footer">
              <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0)">
                  <path d="M9.73759 7.71557L7.71356 6.36577C7.4567 6.19586 7.11239 6.25177 6.9225 6.49425L6.33292 7.2523C6.25715 7.35221 6.11942 7.38119 6.0098 7.3203L5.89765 7.25847C5.52587 7.05583 5.06328 6.80354 4.13126 5.87118C3.19923 4.93882 2.94643 4.47588 2.74379 4.10478L2.68229 3.99263C2.62056 3.88304 2.64899 3.74472 2.74894 3.66834L3.50648 3.07894C3.74887 2.88902 3.80486 2.54482 3.63514 2.28788L2.28534 0.263849C2.1114 0.00220808 1.76243 -0.0763349 1.49315 0.0855355L0.646773 0.593956C0.380836 0.7503 0.185728 1.0035 0.102361 1.30051C-0.202418 2.41101 0.0268647 4.32756 2.85012 7.15114C5.09596 9.39681 6.76788 10.0007 7.91704 10.0007C8.18151 10.0019 8.44495 9.96745 8.70026 9.89841C8.99733 9.81514 9.25057 9.62002 9.40682 9.354L9.91575 8.50813C10.0779 8.2388 9.99935 7.88961 9.73759 7.71557Z" fill="#9F97B8"/>
                </g></svg>
              <span class="icon-callback-footer"></span>
              <a href="#" onClick="window.BinotelGetCall['33479'].openPassiveForm('<h4>Замовити дзвінок</h4><label>Номер телефону</label>');" class="callback_link_footer">
                <?php echo $text_callback_footer ?></a>
            </div>
            <div class="footer-phones">
              <a href="tel:<?php echo str_replace(' ', '', $telephone); ?>" class="tel tel-universal-footer binct-phone-number-1" rel="nofollow">
                <?php echo $telephone; ?></a>
              <a href="tel:0660204021" class="tel tel-mts tel-msg binct-phone-number-2" rel="nofollow">066 02 04 021</a>
              <a href="tel:0980204021" class="tel tel-kyiv binct-phone-number-3" rel="nofollow">098 02 04 021</a>
              <a href="tel:093 02 04 021" class="tel tel-life"><!--<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="catalog/view/theme/<?php echo $mytemplate; ?>/images/phone-life-black.svg" alt="phone" class="black-phone-life lazy-sz">-->093 02 04 021</a>
              <a href="tel:044 499 76 68" class="tel tel-city"><!--<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="catalog/view/theme/<?php echo $mytemplate; ?>/images/phone-city-black.svg" class="black-phone-city lazy-sz" alt="phone">-->044 499 76 68</a>
              <a href="mailto:<?php echo $email; ?>" class="link-mail" rel="nofollow">
                <span class="icon-link-mail"></span>  <?php echo $subtitle_write_to_us; ?><br><?php echo $email; ?></a>
            </div>
            <div><a class="footer__sitemap" href="<?php echo $sitemap; ?>">
                <?php echo $text_sitemap; ?></a></div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-3 col-md-5 footer-col__schedule">
        <div class="tab-wrap footer-contacts">
          <div class="tab-title footer-subtitle"><?php echo $text_open_right_footer;?></div>
          <div class="tab-content tab-contact">
            <div class="footer-worktime">
              <span class="icon-footer-worktime"></span><?php echo $text_taking_orders; ?>
              <br>
              <?php echo $open; ?>
            </div>
            <div class="delivery-from-stock">
              <span class="icon-delivery-from-stock"></span><?php echo $text_delivery_from_stock; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 offset-xl-1 col-lg-2 col-md-4 footer-col__customers">
        <div class="footer-links tab-wrap">
          <div class="tab-title  footer-subtitle"><?php echo $subtitle_for_customers; ?></div>
          <div class="tab-content">
            <ul>
              <li><a href="<?php echo $about ?>"><?php echo $text_about; ?></a></li>
              <?php foreach ($informations as $information) { ?>
              <li><a href="<?php echo $information['href']; ?>">
                  <?php echo $information['title']; ?></a></li>
              <?php } ?>
              <li><a href="<?php echo $return; ?>">
                  <?php echo $text_return; ?></a></li>
              <li><a href="<?php echo $policy; ?>">
                  <?php echo $text_policy; ?></a></li>
              <li><a href="<?php echo $contact; ?>">
                  <?php echo $text_contact; ?></a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-xl-2 col-lg-2 col-md-6 footer-col__social">
        <div class="tab-wrap">
          <div class="tab-title footer-subtitle"><?php echo $subtitle_we_in_soc; ?></div>
          <div class="tab-content">
            <div class="social"><!--<a href="https://www.instagram.com/smart_zone.ua/" class="footer-soc-viber" rel="nofollow" target="_blank"></a>--><a href="https://www.facebook.com/www.sz.ua" class="footer-soc-fb" rel="nofollow" target="_blank" >Facebook</a><a href="https://www.instagram.com/sz.ua_/" class="footer-soc-inst" rel="nofollow" target="_blank">Instagram</a></div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="footer_text__about hidden-xs">
        <?php echo $text_short_about_footer; ?>
        <div>
          <?php echo $powered; ?>
        </div>
      </div>

      <div class="footer_payment">
        <img src="catalog/view/theme/OPC080193_6/images/mastercard.svg" alt="mastercard" title="mastercard">
        <img src="catalog/view/theme/OPC080193_6/images/visa.svg" alt="visa" title="visa">
        <img src="catalog/view/theme/OPC080193_6/images/apple-pay-seeklogo.svg" alt="apple-pay" title="apple-pay">
      </div>


    </div>
  </div>
</footer>
<?php if($is_mobile){ ?>
<div class="mobile-bg"></div>
<div class="mobile-menu-main">
  <div class="mobile-menu mm-1-mobibe-menu" id="mm-1">
    <div class="mob-top-logo">
      <div class="lang-in-burger">
        <?php echo $language; ?>
      </div>
      <?php if (!$is_home) { ?><a href="<?php echo $home ?>"><?php } ?>
        <div class="logo-in-burger">
          <img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="catalog/view/theme/<?php echo $mytemplate; ?>/images/logo.svg" class="lazy-sz logo-burger-menu" alt="SMARTZONE" title="SMARTZONE" />
        </div>
        <?php if (!$is_home) { ?></a><?php } ?>
      <div class="account-in-burger">
        <a href="<?php echo $account; ?>"><svg width="12" height="13.6" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.584473 16.5003C0.584468 16.5725 0.60004 16.6437 0.63012 16.7092C0.660199 16.7748 0.704075 16.833 0.758736 16.8799C0.907169 17.0073 4.44616 20 9.06992 20C13.6937 20 17.2327 17.0073 17.3811 16.8799C17.4358 16.833 17.4796 16.7748 17.5097 16.7092C17.5398 16.6437 17.5554 16.5725 17.5554 16.5003C17.5554 12.6308 14.9598 9.35729 11.4214 8.33345C12.2551 7.82048 12.8987 7.04891 13.2546 6.13603C13.6104 5.22314 13.659 4.21885 13.3929 3.27579C13.1268 2.33274 12.5605 1.50248 11.7803 0.911215C11 0.319948 10.0483 0 9.06992 0C8.0915 0 7.13984 0.319948 6.35956 0.911215C5.57929 1.50248 5.01307 2.33274 4.74696 3.27579C4.48086 4.21885 4.52942 5.22314 4.88527 6.13603C5.24111 7.04891 5.88478 7.82048 6.71845 8.33345C3.18002 9.35729 0.584473 12.6308 0.584473 16.5003Z" fill="white"></path>
          </svg><?php echo $text_account; ?></a>
      </div>
    </div>
    <div class="glad-to-introduce">
      <?php echo $text_glad_to_introduce; ?>
    </div>
    <div class="content-menu-category">
      <?php $i=1;  foreach($categories as $category) { $i++; ?>
      <a href="#mm-<?php echo $category['category_id']; ?>" class="href-category-menu <?php echo $category['children'] ? 'category-has-child' : ''; ?>">
        <div class="item-menu-caterory-mob">
          <div class="pictury-menu-category">
            <img src="catalog/view/theme/OPC080193_6/images/goods-picture.svg" data-src="<?php echo $category['image']; ?>" class="img-responsive lazy-sz" alt="<?php echo $category['name']; ?>" title="<?php echo $category['name']; ?>">
          </div>
          <div class="name-menu-category"><?php echo $category['name']; ?></div>
        </div> <?php if($category['children']) { ?><svg class="arrow-category" width="6" height="10" viewBox="0 0 6 10" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M5.57321 4.72641L0.955602 0.116262C0.802734 -0.0311371 0.559138 -0.0269051 0.411501 0.125716C0.267471 0.2746 0.267471 0.510623 0.411501 0.659485L4.75705 4.99802L0.411501 9.33656C0.261271 9.48657 0.261271 9.72977 0.411501 9.87978C0.561776 10.0298 0.80535 10.0298 0.955602 9.87978L5.57321 5.26963C5.72344 5.1196 5.72344 4.87642 5.57321 4.72641Z" fill="#6F38AB"/>
        </svg><?php } ?>
      </a>
      <?php } ?>
    </div>
    <div class="mob-nav">
      <?php if($route != "common/home" && 0) { ?>
      <a class="start-menu-item" href="<?php echo $home ?>"><?php echo $text_home ?></a>
      <?php } ?>
      <?php foreach ($informations as $information) { ?>
      <a class="start-menu-item" href="<?php echo $information['href']; ?>">
        <?php echo $information['title']; ?></a>
      <?php } ?>
      <div class="callback-in-burger">
        <a href="#" onClick="window.BinotelGetCall['33479'].openPassiveForm('<h4>Замовити дзвінок</h4><label>Номер телефону</label>');" class="btn-mob-modal">
          <i class="icon-colback-in-burger"></i><?php echo $text_callback3 ?></a>
      </div>
    </div>
    <div class="phones">
      <a href="tel:<?php echo str_replace(' ', '', $telephone); ?>" class="tel-universal tel-universal-in-burger binct-phone-number-1" rel="nofollow">
        <?php echo $telephone; ?></a>
      <a href="tel:0660204021" class="tel tel-mts binct-phone-number-2" rel="nofollow">066 02 04 021</a>
      <a href="tel:0980204021" class="tel tel-kyiv binct-phone-number-3" rel="nofollow">
        098 02 04 021</a>
      <a href="tel:0930204021" class="tel tel-life"><!--<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="catalog/view/theme/<?php echo $mytemplate; ?>/images/icon/0930204021.svg" class="lazy-sz" alt="phone">-->093 02 04 021</a>
      <a href="tel:0444997668" class="tel tel-city"><!--<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="catalog/view/theme/<?php echo $mytemplate; ?>/images/icon/0444497686.svg" class="lazy-sz" alt="phone">-->044 499 76 68</a>
      <div class="open-sz-burger">
        <span><?php echo $text_taking_orders; ?></span><br>
        <span><?php echo $open; ?></span>
      </div>
      <div class="delivery-from-stock-burger">
        <span class="icon-delivery-from-stock-burger"></span><?php echo $text_delivery_from_stock; ?>
      </div>
    </div>

  </div>
  <?php $i=1; foreach($categories as $category) { $i++; ?><div class="mobile-menu hidden" id="<?php echo 'mm-'.$category['category_id']; ?>">
    <div class="mob-top">
      <a href="#mm-1" class="back-button-menu"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129" width="14px" fill="#ffffff" class="arrow-back-start"><g><path d="m40.4,121.3c-0.8,0.8-1.8,1.2-2.9,1.2s-2.1-0.4-2.9-1.2c-1.6-1.6-1.6-4.2 0-5.8l51-51-51-51c-1.6-1.6-1.6-4.2 0-5.8 1.6-1.6 4.2-1.6 5.8,0l53.9,53.9c1.6,1.6 1.6,4.2 0,5.8l-53.9,53.9z"></path></g></svg>
        <div class="cell-top-mob">
          <?php echo $category['name']; ?></div></a>
    </div>
    <div class="content-menu-category">
      <a href="<?php echo $category['href']; ?>" class="href-category-all"><?php echo $text_show_all_category; ?></a>
      <?php if($category['children']) { ?>
      <?php foreach($category['children'] as $child) { ?>
      <a href="<?php echo $child['childs'] ? '#mm-'.$child['category_id'] : $child['href']; ?>" class="href-category-menu <?php echo $child['childs'] ? 'category-has-child' : ''; ?>">
        <div class="item-menu-caterory-mob">
          <div class="pictury-menu-category">
            <img src="catalog/view/theme/OPC080193_6/images/goods-picture.svg" class="img-responsive lazy-sz" data-src="<?php echo $child['image']; ?>" alt="<?php echo $child['name']; ?>" title="<?php echo $child['name']; ?>">
          </div>
          <div class="name-menu-category"><?php echo $child['name']; ?></div>
        </div>
        <?php if($child['childs']) { ?><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129" width="14px" fill="#182e81;" class="arrow-category"><g><path d="m40.4,121.3c-0.8,0.8-1.8,1.2-2.9,1.2s-2.1-0.4-2.9-1.2c-1.6-1.6-1.6-4.2 0-5.8l51-51-51-51c-1.6-1.6-1.6-4.2 0-5.8 1.6-1.6 4.2-1.6 5.8,0l53.9,53.9c1.6,1.6 1.6,4.2 0,5.8l-53.9,53.9z"></path></g></svg><?php } ?>
      </a>
      <?php } ?>
      <?php } ?>
    </div>
  </div>
  <?php foreach($category['children'] as $child) { ?>
  <?php if($child['childs']) { ?>
  <!--3 level-->
  <div class="mobile-menu hidden" id="<?php echo 'mm-'.$child['category_id']; ?>">
    <div class="mob-top">
      <a href="<?php echo '#mm-'.$category['category_id']; ?>" class="back-button-menu"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129" width="14px" fill="#ffffff" class="arrow-back-start"><g><path d="m40.4,121.3c-0.8,0.8-1.8,1.2-2.9,1.2s-2.1-0.4-2.9-1.2c-1.6-1.6-1.6-4.2 0-5.8l51-51-51-51c-1.6-1.6-1.6-4.2 0-5.8 1.6-1.6 4.2-1.6 5.8,0l53.9,53.9c1.6,1.6 1.6,4.2 0,5.8l-53.9,53.9z"></path></g></svg>
        <div class="cell-top-mob">
          <?php echo $child['name']; ?></div>
      </a>
    </div>
    <div class="content-menu-category">
      <a href="<?php echo $child['href']; ?>" class="href-category-all"><?php echo $text_show_all_category; ?></a>
      <?php if($child['childs']) { ?>
      <?php foreach($child['childs'] as $grandchild) { ?>
      <a href="<?php echo $grandchild['children'] ? '#mm-'.$grandchild['category_id'] : $grandchild['href']; ?>" class="href-category-menu <?php echo $grandchild['children'] ? 'category-has-child' : ''; ?>">
        <div class="item-menu-caterory-mob">
          <div class="pictury-menu-category">
            <img src="catalog/view/theme/OPC080193_6/images/goods-picture.svg" class="img-responsive lazy-sz" data-src="<?php echo $grandchild['image']; ?>" alt="<?php echo $grandchild['name']; ?>" title="<?php echo $grandchild['name']; ?>">
          </div>
          <div class="name-menu-category"><?php echo $grandchild['name']; ?></div>
        </div>
        <?php if($grandchild['children']) { ?><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129" width="14px" fill="#182e81;" class="arrow-category"><g><path d="m40.4,121.3c-0.8,0.8-1.8,1.2-2.9,1.2s-2.1-0.4-2.9-1.2c-1.6-1.6-1.6-4.2 0-5.8l51-51-51-51c-1.6-1.6-1.6-4.2 0-5.8 1.6-1.6 4.2-1.6 5.8,0l53.9,53.9c1.6,1.6 1.6,4.2 0,5.8l-53.9,53.9z"></path></g></svg><?php } ?>
      </a>
      <?php } ?>
      <?php } ?>
    </div>
  </div>

  <!--4 level-->
  <?php foreach($child['childs'] as $grandchild) { ?>
  <?php if($grandchild['children']) { ?>
  <div class="mobile-menu hidden" id="<?php echo 'mm-'.$grandchild['category_id']; ?>">
    <div class="mob-top">
      <a href="<?php echo '#mm-'.$child['category_id']; ?>" class="back-button-menu"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129" width="14px" fill="#ffffff" class="arrow-back-start"><g><path d="m40.4,121.3c-0.8,0.8-1.8,1.2-2.9,1.2s-2.1-0.4-2.9-1.2c-1.6-1.6-1.6-4.2 0-5.8l51-51-51-51c-1.6-1.6-1.6-4.2 0-5.8 1.6-1.6 4.2-1.6 5.8,0l53.9,53.9c1.6,1.6 1.6,4.2 0,5.8l-53.9,53.9z"></path></g></svg>
        <div class="cell-top-mob">
          <?php echo $grandchild['name']; ?></div>
      </a>
    </div>
    <div class="content-menu-category">
      <a href="<?php echo $child['href']; ?>" class="href-category-all"><?php echo $text_show_all_category; ?></a>
      <?php if($grandchild['children']) { ?>
      <?php foreach($grandchild['children'] as $grandchild) { ?>
      <a href="<?php echo $grandchild['href']; ?>" class="href-category-menu">
        <div class="item-menu-caterory-mob">
          <div class="pictury-menu-category">
            <img src="catalog/view/theme/OPC080193_6/images/goods-picture.svg" class="img-responsive lazy-sz" data-src="<?php echo $grandchild['image']; ?>" alt="<?php echo $grandchild['name']; ?>" title="<?php echo $grandchild['name']; ?>">
          </div>
          <div class="name-menu-category"><?php echo $grandchild['name']; ?></div>
        </div>
      </a>
      <?php } ?>
      <?php } ?>
    </div>
  </div>
  <?php } ?>
  <?php } ?>
  <!--end 4 level-->
  <?php } ?>
  <?php } ?>
  <!--end 3 level-->
  <?php } ?>
</div>
<?php } ?>
<div class="remodal remodal-light  modal-cart" data-remodal-id="modal-cart" id="modal-cart" data-remodal-options="hashTracking: false">
  <div class="modal-head">
    <p class="remodal_title">Корзина</p>
  </div>
  <button data-remodal-action="close" class="remodal-close"></button>
  <div class="modal-body">
    <div id="cart-block" class="btn-group btn-block">
      <?php echo $cart; ?>
    </div>
  </div>
</div>

<!-- Text for Wishlist Not Remove -->
<input id="text-wishlist" type="hidden" value="<?php echo $button_wishlist; ?>">
<input id="text-inwishlist" type="hidden" value="<?php echo $button_inwishlist; ?>">
<input id="button-cart-add" type="hidden" value="<?php echo $button_cart_add; ?>">
<input id="button-incart" type="hidden" value="<?php echo $button_incart; ?>">
<!-- End text for wishlist -->


<!-- Text for Wishlist Not Remove -->
<input id="text-wishlist" type="hidden" value="<?php echo $button_wishlist; ?>">
<input id="text-inwishlist" type="hidden" value="<?php echo $button_inwishlist; ?>">
<input id="button-cart-add" type="hidden" value="<?php echo $button_cart_add; ?>">
<input id="button-incart" type="hidden" value="<?php echo $button_incart; ?>">
<!-- End text for wishlist -->


<!-- Text for Wishlist Not Remove -->
<input id="text-wishlist" type="hidden" value="<?php echo $button_wishlist; ?>">
<input id="text-inwishlist" type="hidden" value="<?php echo $button_inwishlist; ?>">
<input id="button-cart-add" type="hidden" value="<?php echo $button_cart_add; ?>">
<input id="button-incart" type="hidden" value="<?php echo $button_incart; ?>">
<!-- End text for wishlist -->

<div id="scroll-top"><svg width="22" height="12" viewBox="0 0 22 12" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M11.6027 0.322027L21.7614 10.4808C22.0862 10.8171 22.0769 11.353 21.7406 11.6778C21.4125 11.9946 20.8924 11.9946 20.5644 11.6778L11.0042 2.11756L1.44393 11.6778C1.11338 12.0083 0.577465 12.0083 0.24691 11.6778C-0.0835972 11.3472 -0.0835972 10.8113 0.24691 10.4808L10.4056 0.322027C10.7362 -0.00847958 11.2721 -0.0084796 11.6027 0.322027Z" fill="white"/>
  </svg>
</div>
<div class="remodal remodal-light modal-city" data-remodal-id="modal-city" id="modal-city" data-remodal-options="hashTracking: false">
  <button data-remodal-action="close" class="remodal-close"></button>
  <div class="modal-title"><?php echo $text_pickup_city_select; ?></div>
  <div class="modal-body">
    <div class="city-body">
      <ul class="region__popular-cities">
        <li id="s_1" <?php echo ($ip_info['info'] == $text_pickup_city_1) ? 'class="active"' :''; ?> ><a href="javascript:void(0);" onclick="setcity('<?php echo $text_pickup_city_1; ?>', 's_1');" class="popular-cities active"><?php echo $text_pickup_city_1; ?></a></li>
        <li id="s_2" <?php echo ($ip_info['info'] == $text_pickup_city_2) ? 'class="active"' :''; ?> ><a href="javascript:void(0);" onclick="setcity('<?php echo $text_pickup_city_2; ?>', 's_2');" class="popular-cities"><?php echo $text_pickup_city_2; ?></a></li>
        <li id="s_3" <?php echo ($ip_info['info'] == $text_pickup_city_3) ? 'class="active"' :''; ?>><a href="javascript:void(0);" onclick="setcity('<?php echo $text_pickup_city_3; ?>', 's_3');" class="popular-cities"><?php echo $text_pickup_city_3; ?></a></li>
        <li id="s_4" <?php echo ($ip_info['info'] == $text_pickup_city_4) ? 'class="active"' :''; ?>><a href="javascript:void(0);" onclick="setcity('<?php echo $text_pickup_city_4; ?>', 's_4');" class="popular-cities"><?php echo $text_pickup_city_4; ?></a></li>
        <li id="s_5" <?php echo ($ip_info['info'] == $text_pickup_city_5) ? 'class="active"' :''; ?>><a href="javascript:void(0);" onclick="setcity('<?php echo $text_pickup_city_5; ?>', 's_5');" class="popular-cities"><?php echo $text_pickup_city_5; ?></a></li>
        <li id="s_6" <?php echo ($ip_info['info'] == $text_pickup_city_6) ? 'class="active"' :''; ?>><a href="javascript:void(0);" onclick="setcity('<?php echo $text_pickup_city_6; ?>', 's_6');" class="popular-cities"><?php echo $text_pickup_city_6; ?></a></li>
      </ul>
      <div class="form_popup">
        <label class="ch_label" for="product_city"><?php echo $text_pickup_city_input; ?></label>
        <input class="form-control ch-input" type="text" name="city_pop" id="product_city" value="" placeholder="Ваш город" data-onchange="reloadAllPop" autocomplete="new-city">
      </div>
    </div>
  </div>
</div>
<!-- 1 -->
<script>
    $(document).ready(function() {
        $('#button-cart').on('click', function() {
            setTimeout(function(){
                $.ajax({
                    type: 'post',
                    url: 'index.php?route=checkout/cart/info',
                    dataType: 'json',
                    success: function (json) {
                        dataLayer.push({
                            'event': 'add_to_cart',
                            'value': json['total'],
                            'items' : json['items']
                        });

                    }
                });
            }, 1000);

        });
    });
</script>
<!-- 1 -->
<!-- 2 -->
<script>
    $(document).ready(function () {
        $('.phones-board').on('mouseenter', function () {
            $('.all-phone').addClass('all-phone-visible');
            $(this).addClass('phones-board-shadow');
            $('.phone-board-arrow').addClass('phone-board-arrow-up');

        });
        $('.phones').on('mouseleave', function () {
            $('.all-phone').removeClass('all-phone-visible');
            $('.phones-board').removeClass('phones-board-shadow');
            $('.phone-board-arrow').removeClass('phone-board-arrow-up');
        });
    });
</script>
<!-- 2 -->

<!-- 3 -->
<?php if(!$is_mobile){ ?>
<script>
    $(document).ready(function(){
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
                $('.dropdown-category').addClass('dropdown-category-hover');
                $('.catalog-board-arrow').addClass('catalog-arrow-active');
                $('.button-link-catalog').addClass('button-link-catalog-active');
                $('.submenu').removeClass('submenu-open');
            }
        });
        $('.all-inline-category').mouseleave(function(e){
            var thiscategoryblock = $('.main-category-block');
            if(!thiscategoryblock.hasClass('hover-main-category')){
                $("body").removeClass('pushy-active');
                $('.dropdown-category').removeClass('dropdown-category-hover');
                $('.button-link-catalog').removeClass('button-link-catalog-active');
                $('.catalog-board-arrow').removeClass('catalog-arrow-active');}
        });
        $('.js_drop_height').mouseenter(function(){
            var elem=$(this).parent();
            var a=elem.children('a');
            a.addClass('right_dropdown_hovered');
            a.find('.arrow-category').addClass('arrow_howered');
            $(".dropdown-category").css("border-radius", "3px 0px 0px 3px");
        });
        $('.js_drop_height').mouseleave(function(){
            var elem=$(this).parent();
            var a=elem.children('a');
            a.removeClass('right_dropdown_hovered');
            a.find('.arrow-category').removeClass('arrow_howered');
            $(".dropdown-category").css("border-radius", "3px");
        });
        $('.main-menu .item-category').hover(function(){
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
        $('.j_fiels_submenu').mouseenter(function() {
            in_delta = false;
        });
        // Ну и теперь самое главное событие
        $('.main-menu .item-category').mousemove(function(e) {
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
                $('.topmenus-item[data-menu-id ='+ b+']').trigger('mouseenter');
                $('.high-header .j-all-categories').css({'box-shadow': 'none', 'border-radius': '8px 0px 0px 8px'});
                $('.short-header .j-all-categories').css({'box-shadow': 'none', 'border-radius': '0px 0px 0px 8px'});
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
    $('.topmenus-item').hover(function(){
        $('.vertical-item-categore').removeClass('hover');
        var a=$(this).data('menu-id');
        $(this).addClass('over');
        $('.vertical-item-categore[data-menu-vertical-id ='+ a+']').addClass('hover');
    }, function(){
        var a=$(this).data('menu-id');
        $(this).removeClass('over');

    })
    $('.topmenus-item').hover(
        function(e){
            var thisElement=$(this);
            var a=$(this).data('menu-id');
            if($('.j-dropdown-item').hasClass('active') || $('.j-all-categories').hasClass('dropdown-category-hover')){
                $('.topmenus-item').removeClass('hover');
                $('.j-dropdown-item').removeClass('active');
                $(this).addClass('hover');
                $('.j-dropdown-item[data-menu-id ='+ a+']').addClass('active');
                $('.j-all-categories').css({'box-shadow':'none', 'border-radius': '8px 0px 0px 8px'});
            }else{
                setTimeout(function(){
                    if(thisElement.hasClass('over')){
                        thisElement.addClass('hover');
                        $('.j-dropdown-item[data-menu-id ='+ a+']').addClass('active');
                        $('.j-all-categories').addClass('dropdown-category-hover');
                        $('.j-all-categories').css({'box-shadow': 'none', 'border-radius': '8px 0px 0px 8px'});
                        $('.catalog-board-arrow').addClass('catalog-arrow-active');
                        $("body").addClass('pushy-active');
                    }
                }, 560)
            }
        });
    $('.all-inline-category').mouseleave(function(e){
        $('.topmenus-item').removeClass('hover');
        $('.j-dropdown-item').removeClass('active');
        $('.j-all-categories').removeClass('dropdown-category-hover');
        $('.vertical-item-categore').removeClass('hover');
        $('.catalog-board-arrow').removeClass('catalog-arrow-active');
        $('.j-all-categories').css({'box-shadow': 'none', 'border-radius': '0px 0px 8px 8px'});
    })
</script>
<script>
    $(document).ready(function(){
        setTimeout(function(){$('header .phones ').addClass('animate-phones')}, 11000);
    })
</script>
<?php } ?>
<!-- 3 -->
<script>
$(document).ready(function() {
  function random(owlSelector){owlSelector.children().sort(function(){return Math.round(Math.random()) - 0.5;}).each(function(){$(this).appendTo(owlSelector);});}
  var owl = $(".owl-carousel.owl-moneymaker2");
  owl.owlCarousel({
      dots:false,
      loop: true,
      navText: ['<i></i>','<i></i>'],
      nav: true,
      responsiveClass:true,
        responsive:{
          0:{
            loop:false,
            mouseDrag: false,
            touchDrag: false,
            autoWidth: false,
            items: 2.5,
            margin: 18,
            nav: false
          },
          375:{
            loop:false,
            items: 2.7,
            autoWidth: false,
            margin: 18,
            nav: false
          },
          479:{
            loop:false,
            items: 2.9,
            autoWidth: false,
            margin: 18,
          },
          500:{
            loop:false,
            items: 3.2,
            margin: 18,
            autoWidth: false,
            nav: false
          },
          600:{
              loop:false,
              items: 3.8,
              autoWidth: false,
              nav: false,
              margin: 18,
          },
          768:{
              mouseDrag: true,
              touchDrag: true,
              nav: true,
              items: 2
          },
          900:{
            mouseDrag: true,
            touchDrag: true,
            nav: true,
            items: 2
          },
          992:{
            nav:true,
            items: 3
          },
          1199:{
            nav:true,
            items: 4
          },
          1420:{
            nav:true,
            items: 5
            }
          },
        });
        });
      </script>
      <!-- owlcarusel-->
<script>
          $(document).ready(function(){
              $('.j-tab-switcher').on('click', function (e){
                  e.preventDefault();
                  $('.j-tab-switcher.active').removeClass('active');
                  $(this).addClass('active');
                  var tab = $(this).find('a').attr('href');
                  $('.tab-content-carousel .tab-pane-carousel.active').removeClass('active')
                  $(tab).addClass('active loading-tab-carousel');
                  setTimeout(function(){$(tab).removeClass('loading-tab-carousel');}, 700);
              });
          });
</script>
      <!-- owlcarusel-->
<?php if($is_home){ ?>
      <!-- newblog_artikle -->
      <script>
          $(document).ready(function(){
              $('.slick-news').not('.slick-initialized').slick({
                  slidesToShow: 3,
                  responsive: [
                      {
                          breakpoint: 768,
                          settings: {
                              slidesToShow: 2,
                          }
                      },
                      {
                          breakpoint: 481,
                          settings: {
                              slidesToShow: 1,
                              arrows: true,
                              dots: false,
                          }
                      },
                  ]
              });
              $('.slider-products').slick('setPosition');

          })
      </script>
      <!-- newblog_artikle -->
      <script>
      $(document).ready(function(){
        $(".categories__wrap").owlCarousel({
          items: 1,
          dots: false,
          /*autoWidth: true,*/
          responsive:{
                      0:{
                          mouseDrag: false,
                          touchDrag: false,
                          items: 2.5
                      },
                       480:{
                          mouseDrag: true,
                          touchDrag: true,
                          items: 3.4
                      },
                      768:{
                          mouseDrag: true,
                          touchDrag: true,
                           items: 3.4
                      }
            }}
          );
      });
      </script>

      <!-- slide show 2 #3 -->
      <script>
          $(document).ready(function(){
              $('.anner-slide-half').owlCarousel({
                      loop: false,
                      dots: false,
                      responsive:{
                          0:{
                              mouseDrag: false,
                              touchDrag: false,
                              autoWidth: true,
                          },
                          560:{
                              mouseDrag: true,
                              touchDrag: true,
                              autoWidth: false,
                              items: 1.9
                          },
                          992:{
                              mouseDrag: true,
                              touchDrag: true,
                              autoWidth: false,
                              items: 2.7
                          }
                      }
                  }
              );
          });
      </script>
      <!-- slide show 2 #2 -->
      <script>
          $(document).ready(function(){
              $('.scroll-stock-link').on('click', function(event){
                  event.preventDefault();
                  var id=$(this).attr('href'), top=$(id).offset().top;
                  $('body, html').animate({scrollTop: top - 52}, 1500);

              })
          })
      </script>
      <!-- slide show 2 #2 -->
      <!-- slide show 2 #4 -->
      <script>
          $(document).ready(function(){
              $('.slider_with_bg').owlCarousel({
                      dots: false,
                      autoWidth: false,
                      items: 1.2,
                      responsive:{
                          0:{
                              mouseDrag: false,
                              touchDrag: false,
                          },
                          768:{
                              mouseDrag: true,
                              touchDrag: true,
                          }
                      }
                  }
              );
          });
      </script>
      <!-- slide show 2 #4 -->
      <!-- slide show 2 #0 -->
      <script>
          $(document).ready(function(){
              if (window.matchMedia('(max-width: 767px)').matches) {
                  $('.aner-column').owlCarousel({
                          dots: false,
                          autoWidth: true,
                          responsive:{
                              0:{
                                  mouseDrag: false,
                                  touchDrag: false,
                              },
                              768:{
                                  mouseDrag: true,
                                  touchDrag: true,
                              }
                          }

                      }
                  );
              }
          });
      </script>
      <!-- slide show 2 #0 -->
      <script>
          $(document).ready(function(){
              $('.anner-slide').owlCarousel({
                  items: 1,
                  lazyLoad:true
              });
              var countSlider = <?php echo count($banners);?>;
              var widthSlider = $('.anner-slide .owl-dots').width();
              var widthDots = widthSlider/countSlider-8+'px';
              $('.owl-dots button').css("max-width", widthDots);
              $(window).resize(function() {
                  var widthSlider = $('.anner-slide .owl-dots').width();
                  var widthDots = widthSlider/countSlider-8+'px';
                  $('.owl-dots button').css("max-width", widthDots);});


          });
      </script>
<?php } ?>
<?php if($is_home || $route=='product/category'){ ?>
  <!-- slide show -->
<script>
    $(document).ready(function(){
        $('.home__slider').slick({
            slidesToShow: 1,
            lazyLoad: 'ondemand',
            slidesToScroll: 1,
            cssEase:'linear',
            arrow: false,
            speed: 300,
            autoplay: true,
            autoplaySpeed: 5000,
            dots: true,
            responsive: [{
                breakpoint: 767,
                settings: {
                    fade: false,
                }
            }, ]
        });
        $('.home__slider').on("afterChange", function(event, slick, currentSlide){
            $('.front-count-slides-current').text(currentSlide+1);
        });
        var countSlider = $(".home__slider").slick("getSlick").slideCount;
        if (countSlider == 1){
            $('.front-slider-counter').addClass('hidden');
        }
        $('.front-count-slides-total').text('/'+ countSlider);
        var widthSlider = $('.slick-dots').width();
        var widthDots = widthSlider/countSlider-8+'px';
        $('.slick-dots li button').css("max-width", widthDots);
        $(window).resize(function() {
            var widthSlider = $('.slick-dots').width();
            var widthDots = widthSlider/countSlider-8+'px';
            $('.slick-dots li button').css("max-width", widthDots);

        });
        setTimeout(function(){$('.home__banner .item-slick').addClass('small-image-zoom-container'); }, 100)
    });
</script>
<!-- slide show -->
<?php } ?>
<?php if($is_home || $route=='product/category'){ ?>
<script>
    $(document).ready(function(){
        $('.foto-gallery').owlCarousel({
            dots: false,

            responsive:{
                0:{
                    mouseDrag: false,
                    touchDrag: false,
                    autoWidth: true,
                },
                768:{
                    mouseDrag: false,
                    touchDrag: false,
                    autoWidth: false,
                    items: 3.5,
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function(){
        var owl = $('.foto_galery_black');

        $('.foto_galery_black').owlCarousel({
                dots: false,

                navText: ['<i id="prev_foto_gallery"></i>','<i id="next_foto_gallery"></i>'],
                nav: true,
                responsive:{
                    768:{
                        items: 5,
                    },
                    991:{
                        items: 5,
                    },
                    1200:{
                        items: 6,
                    }

                },
                onInitialize : function(element){
                    owl.children().sort(function(){
                        return Math.round(Math.random()) - 0.5;
                    }).each(function(){
                        $(this).appendTo(owl);
                    });
                },

            }
        );

    });
</script>
<?php } ?>
<script type="text/javascript">
  var digiScript = document.createElement('script');
  digiScript.src = '//cdn.diginetica.net/1486/client.js?ts=' + Date.now();
  digiScript.defer = true;
  digiScript.async = true;
  setTimeout(function(){document.body.appendChild(digiScript); }, 4000);
</script>
<link rel="stylesheet" href="catalog/view/theme/<?php echo $mytemplate; ?>/assets/remodal-default-theme.css"/>
<script defer src="catalog/view/theme/OPC080193_6/assets/maskedinput.js"></script>
<script defer src="catalog/view/theme/<?php echo $mytemplate; ?>/assets/remodal.js"></script>
<!-- footer scripts -->
<?php foreach ($scripts as $script) { ?>
<script defer src="<?php echo $script; ?>"></script>
<?php } ?>
<!-- end footer scripts -->
<script>
  $(document).ready(function(){
    if (window.matchMedia('(min-width: 768px)').matches) {
      $(function () {
        $(window).scroll(function () {
          if ($(this).scrollTop() > 300) {
            $('#scroll-top').fadeIn();
          } else {
            $('#scroll-top').fadeOut();
          }
        });
        $('#scroll-top').click(function () {
          $('body,html').animate({scrollTop: 0}, 800);
          return false;
        });
      });
    }});
</script>
<!--zakritie-mob-menu-dvizheniem-palca-->
<script>
  $(document).ready(function(){
    var touch_position;
    var touch_position_y; // Координата нажатия

    function turn_start(event) {
      // При начальном нажатии получить координаты
      event.stopPropagation();
      touch_position = event.touches[0].pageX;
      touch_position_y = event.touches[0].pageY;

    }
    function turn_page(event) {
      event.stopPropagation();
      // При движении нажатия отслеживать направление движения
      var tmp_move = touch_position-event.touches[0].pageX;
      var tmp_move_y = touch_position_y-event.touches[0].pageY;
      console.log(tmp_move_y);
      if (Math.abs(tmp_move)<60) { return false; }
      if (tmp_move_y<-10 || tmp_move_y>10  ) { return false; }
      if (tmp_move<0) {
      }
      else {
        $('.mobile-menu-main').removeClass('open');
        setTimeout(function(){$('.mobile-menu').removeClass('open').removeClass('sub-open'); $('.mobile-menu:not(.mm-1-mobibe-menu)').addClass('hidden');}, 400);
        $('.mobile-bg').fadeOut(200);
        $('html').removeClass('remodal-is-locked scroll-disabled');
        $('body').removeClass('scroll-disabled');
      }
    }

    $('.mobile-menu-main').on('touchstart', function(){
      turn_start(event);
    });
    $('.mobile-menu-main').on('touchmove', function(){
      turn_page(event);

    });
    $('.mobile-bg').on('touchstart', function(){
      turn_start(event);
    });
    $('.mobile-bg').on('touchmove', function(){
      turn_page(event);

    });
  })
</script>
<!--end-zakritie-mob-menu-dvizheniem-palca-->
<!--otlozhenaya-zagryzka-izobrazhenii-->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var lazyImages = [].slice.call(document.querySelectorAll("img.lazy-sz"));
    if ("IntersectionObserver" in window) {
      let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) {
            let lazyImage = entry.target;
            lazyImage.src = lazyImage.dataset.src;
            lazyImage.classList.remove("lazy-sz");
            lazyImage.classList.remove("lazy-sz");
            lazyImageObserver.unobserve(lazyImage);
          }
        });
      });
      lazyImages.forEach(function(lazyImage) {
        lazyImageObserver.observe(lazyImage);
      });
    }
  });
</script>
<!--end-otlozhenaya-zagryzka-izobrazhenii-->
<!-- Jivosite -->
<script>
  (function() {
    var h = function() {
      var s = document.createElement('script');
      s.src = '//code.jivosite.com/script/widget/7iTpEJdqJF';
      s.async = true;
      document.body.append(s);
    };
    (document.readyState==='complete')&&h();
    (['loading','interactive'].indexOf(document.readyState)>-1)&&document.addEventListener('DOMContentLoaded', function(e) {setTimeout(h,  10000)});
  })()
</script>
<!-- End Jivosite -->
<script>
  (function(d, w, s) {
    var widgetHash = '5o4z7wy795qvnzz9skax', gcw = d.createElement(s); gcw.type = 'text/javascript'; gcw.async = true;
    //gcw.src = '//widgets.binotel.com/getcall/widgets/'+ widgetHash +'.js';
    gcw.src = 'https://sz.ua/externalstaticjs/5o4z7wy795qvnzz9skax.js';
    var sn = d.getElementsByTagName(s)[0]; sn.parentNode.insertBefore(gcw, sn);
  })(document, window, 'script');
</script>
<link rel="stylesheet" href="catalog/view/theme/<?php echo $mytemplate; ?>/assets/get_call.css"/>
<link rel="stylesheet" href="catalog/view/theme/<?php echo $mytemplate; ?>/assets/footer.css?ver2.1"/>
<script><!--
  if($(location).attr('pathname') == '/simplecheckout/') {
    $(document).on('change', 'input[name=\'shipping_address[city]\']', function(){
      shipping_city($('#shipping_address_city').val());
    });
  }

  $('input[name=\'city_pop\']').autocomplete({
    'source': function (request, response) {
      $.ajax({
        url: 'index.php?route=product/product/autocomplete&name=' + encodeURIComponent(request),
        dataType: 'json',
        success: function (json) {
          response($.map(json, function (item) {
            return {
              label: item.DescriptionRu,
              value: item.DescriptionRu
            }
          }));
        }
      });
    },
    'select': function (item) {
      $('#product_city').html(item['value']);
      $('#header_city').html(item['value']);
      $('#city-possible__name').html(item['value']);
      $('input[name=\'city_pop\']').val(item['value']);
      var inst = $('[data-remodal-id=modal-city]').remodal();
      inst.close();
      shipping_city(item['value']);

      if($('input[name=\'product_id\']')) {
        var product_id = $('input[name=\'product_id\']').val();
      }else{
        var product_id = 0;
      }

      // change delivery data
      if($('#product').length) {
        changeDataDelivery(item['value'], product_id);
      }

      $('.view_pickup').hide();
      $('.view_sz_courier').hide();
    }
  });

  function changeDataDelivery(city, productId) {
    $.ajax({
      url: 'index.php?route=product/product/change_delivery',
      type: 'post',
      data: 'shipping_city=' + encodeURIComponent(city) + '&product_id=' + productId,
      dataType: 'json',
      success: function (json) {
        if (json['success']) {

          if(json['deliveries']){

            html = '';

            $.each(json['deliveries'], function( index, delivery ) {

              deliveryClass = '';
              nameSipping = '';
              deliveryPrice = '';
              dayDelivery = '';

              $.each(delivery, function( key, value ) {

                if(key == 'class') {deliveryClass = value;}
                  if(key == 'name_shiping') {nameSipping = value;}
                    if(key == 'price') {deliveryPrice = value;}
                      if(key == 'day_delivery') {dayDelivery = value;}

                              });

              html += '<tr class ="product_delivery_item">';
              html += '<td class="delivery-first-col delivery_types ' + deliveryClass + '"><div class="delivery_types__content">' + nameSipping + '</div></td>';
              html += '<td class="delivery_cost">';
              html += '<span class="delivery_cost__amount">' + deliveryPrice + '</span>';

              if(dayDelivery !== '') {
                html += '<span class="delivary_date">' + dayDelivery + '</span>';
              }

              html += '</td>';
              html += '<td class="question_mark"></td>';

              html += '</tr>';

            });

            if($('.product_delivery_table').length) {
              $('.product_delivery_table').html(html);
            }

          }

        } else if(json['error']) {
          console.log(json['error']);
        }
      }
    });
  }

  function setcity(city,key){
    $('#product_city').html(city);
    $('#header_city').html(city);
    $('#city-possible__name').html(city);
    var inst = $('[data-remodal-id=modal-city]').remodal();
    inst.close();

    $('#s_1').removeClass('active');
    $('#s_2').removeClass('active');
    $('#s_3').removeClass('active');
    $('#s_4').removeClass('active');
    $('#s_5').removeClass('active');
    $('#s_6').removeClass('active');

    $('#' + key).addClass('active');

    if($('input[name=\'product_id\']')) {
      var product_id = $('input[name=\'product_id\']').val();
    }else{
      var product_id = 0;
    }

    $('.view_pickup').hide();
    $('.view_sz_courier').hide();

    shipping_city(city);
    // change delivery data
    if($('#product').length) {
      changeDataDelivery(city, product_id);
    }

  }

  function shipping_city(city){
    $.ajax({
      url: 'index.php?route=product/product/shipping_city',
      type: 'post',
      data: 'shipping_city=' + encodeURIComponent(city),
      dataType: 'json',
      success: function (json) {
        if (json['success']) {
          $('#shipping_address_city').val(json['success']);
          if($(location).attr('pathname') == '/checkout/') {
            $('#checkout_city').val(city);
          }
        }
      }
    });
  }
  //--></script>
<!-- Start Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
          j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
          'https://sz.ua/externalstaticjs/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
          })(window,document,'script','dataLayer','GTM-WZN8BFK');
</script>
<!-- End Google Tag Manager -->
<!-- ts_google_analytics_counter -->
<?php if (!empty($ts_google_analytics_counter)) { ?>
<?php if ($ts_google_analytics_counter_type == 'gtag') { ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $ts_google_analytics_counter_id; ?>"></script>
<script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);}</script>
<?php } else { ?>
<?php if ($ts_google_analytics_counter_mode) { ?>
<script>window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;</script>
<script async src='https://sz.ua/externalstaticjs/analytics.js'></script>
<?php } else { ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://sz.ua/externalstaticjs/analytics.js','ga');
</script>
<?php } ?>
<?php } ?>
<script>$(document).TSGoogleAnalytics(JSON.parse('<?php echo $ts_google_analytics_counter; ?>'));</script>
<?php } ?>
<!-- ts_google_analytics_counter -->
<!-- ts_google_analytics_ecommerce -->
<?php if (!empty($ts_google_analytics_ecommerce)) { ?>
<script>
  <?php foreach ($ts_google_analytics_ecommerce as $ecommerce) {?>
          $(document).TSGoogleAnalytics(JSON.parse('<?php echo json_encode($ecommerce); ?>'));
          <?php } ?>
</script>
<?php } ?>
<!-- ts_google_analytics_ecommerce -->
<?php if(isset($city_product_session)){ ?>
<script><!--
  $(document).ready(function () {
    var city_product = '<?php echo $city_product_session; ?>';
    $('#shipping_address_city').val(city_product);
  });
  //-->
  </script>
<?php } ?>
<script>
  $(document).ready(function(){
    $('.city-possible__yes').click(function(){
      $('.city-possible').addClass('hidden');
    });

    $('.city-possible__show').click(function(){
      $('.city-possible').addClass('hidden');
    });
    $(document).mouseup(function (e) {
      var div = $(".city-possible");
      if (!div.is(e.target) && div.has(e.target).length === 0) {
        div.addClass('hidden');
      }
    })
  })
</script>


<script><!--
  $(document).ready(function () {
    if($(location).attr('pathname') == '/simplecheckout/'){
      $(".dropdown-menu").remove();
    }
  });
  //-->
  </script>
  <script>
  	/* $(document).ready(function(){ */

    /*$('.search-input').on('focus', function(event) {
      if (window.matchMedia('(max-width: 767px)').matches) {
          if (!$('.header-mob').hasClass('search-form-open')) {
              //event.preventDefault();
              $('.header-mob').addClass('search-form-open');
              $('.search-input').focus();
              var lenghSearch = $(this).val();
              console.log(lenghSearch);
              return false;
          }}else{

          };
      });*/

    /*$('.search-input').on('keyup', function (){
      var lenghSearch = $(this).val();
      if(lenghSearch == ''){
        $('.search-close').trigger('click');
      }
    });
     $('.search-input').on('focus', function (){
     $('.search-btn').addClass('search-btn-focus');
      });
      $('.search-input').on('blur', function (){
      $('.search-btn').removeClass('search-btn-focus');
    });
  }); */

  </script>
</body>
</html>
