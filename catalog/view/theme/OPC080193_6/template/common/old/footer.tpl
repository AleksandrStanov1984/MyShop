<footer class="footer">
    <div class="wrapper">
	<div class="col">
	    <div class="logo"><a href="<?php echo $home ?>"><img src="catalog/view/theme/<?php echo $mytemplate; ?>/images/SZlogo.svg" alt="" /></a></div>
	    <div class="copyright"><?php echo $powered; ?> </div>
	</div>
	<div class="col col-links">
	    <ul>
		<li><a href="<?php echo $home ?>"><?php echo $text_home ?></a></li>
            <?php foreach ($informations as $information) { ?>
          <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
          <?php } ?>
		
	    </ul>
	</div>
	<div class="col">
<?php echo $footerbottom; ?>
	</div>
	<div class="col col-phones">
	    <a href="tel:0503002277" class="tel-mts tel-msg">(050) 300 22 77</a><br/>
	    <a href="tel:<?php echo $telephone ?>" class="tel-kyiv"><?php echo $telephone ?></a><br/>
		<a href="tel:0931705688" class="tel-life">(093) 170 56 88</a><br/>
	    <a href="tel:<?php echo $fax ?>" class="tel-city"><?php echo $fax ?></a><br/>
	    <a href="mailto:<?php echo $email; ?>" class="link-mail"><?php echo $email; ?></a>
	</div>
	<div class="col">
	    <?php echo $footerright; ?>
	</div>
    </div>
</footer>

<div class="mobile-bg"></div>
<div class="mobile-menu">
    <div class="mob-top">
	<a href="<?php echo $checkout ?>" class="mob-cart cart">Корзина (<i><?php echo $countcart; ?></i>)</a>
	<div class="mob-lang">
<?php echo $language ?>
	    <?php /*<a href="#" class="active">Укр</a>
	    <a href="#">Рус</a>
	    <a href="#">Eng</a>*/?>
	</div>
    </div>
    <div class="mob-nav">
	<ul>
		<li><a href="<?php echo $home ?>"><?php echo $text_home ?></a></li>
            <?php foreach ($informations as $information) { ?>
          <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
          <?php } ?>
	</ul>
    </div>
    <div class="phones">
	<a href="tel:050 300 22 77" class="tel tel-mts">(050) 300 22 77</a><br/>
	    <a href="tel:<?php echo $telephone ?>" class="tel-kyiv"><?php echo $telephone ?></a><br/>
		<a href="tel:0931705688" class="tel-life">(093) 170 56 88</a><br/>
	    <a href="tel:<?php echo $fax ?>" class="tel-city"><?php echo $fax ?></a><br/>
    </div>
    <div class="callback">
	<a href="#" data-remodal-target="modal-callback" class="btn btn-mob-modal"><?php echo $text_callback3 ?></a>
    </div>
</div>

<div class="remodal modal-callback" data-remodal-id="modal-callback" id="modal-callback" data-remodal-options="hashTracking: false">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="modal-head">
    </div>
    <div class="modal-body">
	<form method="POST" id="callback-form">
		<p><?php echo $text_callback1; ?></p>
	    <input type="tel" name="phone" placeholder="<?php echo $text_callback2; ?>" />
	    <button type="button" onclick="callback1()" class="btn"><?php echo $text_send; ?></button>
	</form>
    </div>
</div>

<div class="remodal modal-cart" data-remodal-id="modal-cart" id="modal-cart" data-remodal-options="hashTracking: false">
<button data-remodal-action="close" class="remodal-close"></button>
<div id="cart" class="btn-group btn-block">
    <?php echo $cart; ?>
</div>
</div>

<script type="text/javascript">
  (function(d, w, s) {
	var widgetHash = '5o4z7wy795qvnzz9skax', gcw = d.createElement(s); gcw.type = 'text/javascript'; gcw.async = true;
	gcw.src = '//widgets.binotel.com/getcall/widgets/'+ widgetHash +'.js';
	var sn = d.getElementsByTagName(s)[0]; sn.parentNode.insertBefore(gcw, sn);
  })(document, window, 'script');
</script>

</body>
</html>


<?php /*<?php echo $parallax; ?>
<footer>
  <div id="footer-top"> 
  <div class="content_footer_top container"><?php echo $footertop; ?> </div>
  </div>
  <div id="footer" class="container">
     <div class="row">
	 
	 <?php ?><div class="col-sm-3 column">
	 <div class="content_footer_left"><?php echo $footerleft; ?> </div>
	 </div><?php ?>
	
 
    	
 <?php ?><div class="col-sm-3 column" style="text-align: right"><?php echo $footerright; ?></div><?php ?>
	  
      <?php ?><div class="col-sm-3 column"><?php echo $footerbottom; ?>
	  
        <!--h5><?php echo $text_account; ?></h5>
        <ul class="list-unstyled">
                    <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
        </ul-->
      </div><?php ?>
	  
	  	
	        <?php if ($informations) { ?>
      <div class="col-sm-3 column" style="text-align: right;">
        <!--h5><?php echo $text_information; ?></h5>
        <ul class="list-unstyled" style="text-align: right;">
          <?php foreach ($informations as $information) { ?>
          <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
          <?php } ?>
		  <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
          <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
          <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
        </ul-->
		<?php echo $footercolumn; ?>
      </div>
      <?php } ?>
	
	  <div class="content_footer_right"></div>
	  
    </div>
    <div class="footer-bottom">
	
	<div class="copy-right">
	
	<div id="bottom-footer">
	<!--ul class="list-unstyled">
		<li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
		<li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
		<li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
		<li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>

		<li class="contact"><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
	</ul-->
	</div>
	</div>
	
    <div class="row"><div class="powerd col-sm-3"> <?php echo $powered; ?> </div></div>
	<div class="content_footer_bottom"> </div>
	</div>
  </div>

  

</footer>

<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//--> 

<!-- Theme created by Welford Media for OpenCart 2.0 www.welfordmedia.co.uk -->
<script type="text/javascript">
  (function(d, w, s) {
	var widgetHash = '5o4z7wy795qvnzz9skax', gcw = d.createElement(s); gcw.type = 'text/javascript'; gcw.async = true;
	gcw.src = '//widgets.binotel.com/getcall/widgets/'+ widgetHash +'.js';
	var sn = d.getElementsByTagName(s)[0]; sn.parentNode.insertBefore(gcw, sn);
  })(document, window, 'script');
</script>

</body></html>*/?>