<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $title; ?></title>
<style>
small {display: none;}
</style>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000;">
<div style="">
  <table width="680" align="center" cellpadding="0" cellspacing="0" style="border-collapse: collapse; background: url(https://www.sz.ua/image/bg_order_letter.png);">
  <tr>
  <td style="text-align: center;">
  <a href="<?php echo $store_url; ?>" title="<?php echo $store_name; ?>">
  <img src="https://www.sz.ua/image/logo_order_letter.png" alt="<?php echo $store_name; ?>" style="margin: 20px; border: none;max-width: 100%;
    height: auto;" />
  </a>
  </td>
  </tr>
  </table>
  <table width="680" align="center" cellpadding="0" cellspacing="0">
  <tr>
  <td>
    <p style="margin-top: 20px; margin-bottom: 20px; font-size: 18px;"><b><?php echo $text_greeting; ?> <span style="color: #6F38AB;"><?php echo $order_status; ?></span><br /></p>
  <?php if ($customer_id) { ?>
  <p style="margin-top: 0px; margin-bottom: 20px;"><?php echo $text_link; ?></p>
  <p style="margin-top: 0px; margin-bottom: 20px;"><a href="<?php echo $link; ?>"><?php echo $link; ?></a></p>
  <?php } ?>
  <?php if ($download) { ?>
  <p style="margin-top: 0px; margin-bottom: 20px;"><?php echo $text_download; ?></p>
  <p style="margin-top: 0px; margin-bottom: 20px;"><a href="<?php echo $download; ?>"><?php echo $download; ?></a></p>
  <?php } ?>
  </td>
  </tr>
  </table>
  <table width="680" align="center" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
      <tr>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;" colspan="2"><img src="https://www.sz.ua/image/catalog/icons/galochka.png" style="width: 10px;"><?php echo $order_status; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="font-size: 20px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
		  <?php echo $text_order_id; ?> <?php echo $order_id; ?></td>
        <td style="font-size: 20px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
		  <?php echo $date_added; ?><br />
		</td>
      </tr>
    </tbody>
  </table>
  <table width="680" align="center" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
      <tr>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $text_product; ?></td>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?php echo $text_price; ?></td>
		<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?php echo $text_quantity; ?></td>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?php echo $text_total; ?></td>
      </tr>
    </thead>
    <tbody>
    <?php $ppos = 0; foreach ($products as $product) { $ppos++; ?>
	    <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: center; padding: 7px; width: 25%;" rowspan="2">
			<img src="<?php echo $product['image_link']; ?>" style="vertical-align: middle;">
          <?php foreach ($product['option'] as $option) { ?>
          <br />
          &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
          <?php } ?></td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;" colspan="3"><span style="vertical-align: middle;color: #03A9F4;font-weight: 600;font-size: 14px;"><?php echo $product['model']; ?> <?php echo $product['name']; ?></span></td>

      </tr>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;font-weight: bold;"><?php echo $product['price']; ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;font-weight: bold;"><?php echo $product['quantity']; ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;font-weight: bold;"><?php echo $product['total']; ?></td>
      </tr>
      <?php } ?>
      <?php foreach ($vouchers as $voucher) { ?>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $voucher['description']; ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">1</td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $voucher['amount']; ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $voucher['amount']; ?></td>
      </tr>
      <?php } ?>
	  <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;" colspan="3"><b><?php echo $text_model; ?></b></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><b><?php echo $neon_sub_total; ?></b></td>
      </tr>
	  		<tr>
				<?php if ($shipping_address) { ?>
			<td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px; color: #222222;"><?php echo $text_shipping_address; ?></td>
				<?php } ?>
				<?php if ($shipping_address) { ?>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;" colspan="3">
				<?php if ($shipping_method) { ?>
				<b style="color: #920f0f;"><?php echo $shipping_method; ?></b><br />
				<img src="https://www.sz.ua/image/catalog/icons/map.png" style="width: 12px;">
				<span><?php echo $neon_region; ?></span> <br /><span style="padding-left: 16px;"><?php echo $neon_city; ?></span><br /><span style="padding-left: 16px;"><?php echo $neon_address; ?></span>
				<?php } ?>
			</td>
			<?php } ?>
			<!--td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><b><?php // echo $neon_shipping; ?></b></td-->
		</tr>
				<tr>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $text_payment_method; ?></td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;" colspan="3"><?php echo $payment_method; ?></td>
		</tr>
		<tr>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $text_order_detail; ?></td>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;" colspan="3"><?php echo $neon_fio; ?>, <?php echo $telephone; ?></td>
		</tr>
		<tr>
			<td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $text_email; ?></td>
			<td style="font-size: 25px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;" colspan="3"><?php echo $store_name; ?></td>
		</tr>
		<?php if (isset($neon_coupon)) { ?>
	  <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;" colspan="3"><b><?php echo $neon_coupon_title; ?></b></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><b><?php echo $neon_coupon; ?></b></td>
      </tr>
	   <?php } ?>
    </tbody>
	<tfoot>
      <tr>
        <td style="font-size: 16px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;" colspan="3"><b><?php echo $text_order_total; ?></b></td>
        <td style="font-size: 16px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><b><?php //echo $neon_total; ?><?php echo $neon_sub_total; ?></b></td>
      </tr>
    </tfoot>
    <!--tfoot>
      <?php foreach ($totals as $total) { ?>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;" colspan="3"><b><?php echo $total['title']; ?>:</b></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;"><?php echo $total['text']; ?></td>
      </tr>
      <?php } ?>
    </tfoot-->
  </table>
  <?php if ($comment_client) { ?>
    <table width="680" align="center" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
      <tr>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $text_comment_client; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $comment_client; ?></td>
      </tr>
    </tbody>
  </table>
 <?php } ?>
    <?php if ($comment) { ?>
  <table width="680" align="center" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
      <tr>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $text_instruction; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $comment; ?></td>
      </tr>
    </tbody>
  </table>
  <?php } ?>
    <table width="680" align="center" cellpadding="0" cellspacing="0" style="border-bottom: 1px solid #ddd; padding-bottom: 20px; font-weight: 100;">
	<tr>
	<td width="65"><img src="https://www.sz.ua/image/catalog/icons/phone2_order_letter.png" style="width: 65px;">
</td>
	<td style="padding-left: 20px; padding-top: 10px; font-size: 14px; line-height: 1.5;">
	<?php echo $text_telephone; ?><br/>
     <b>0 800 33 10 32</b>
	 </td>
	 </tr>
  </table>



  <?php if (isset($qr)) {?>
  	<table width="680" align="center" cellpadding="0" cellspacing="0" style="margin-top: 0px; margin-bottom: 20px; vertical-align: middle;">
	  <tbody>
	   <tr>
		<td style="text-align: center; color: #920f0f;"><b><?php echo $text_ip; ?></b></td>
		<td style="text-align: right;"><img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=https%3A%2F%2Fwww.sz.ua%2Frd%2F<?php echo $qr; ?>&choe=UTF-8" title="SZ.UA" /></td>
	   </tr>
	  </tbody>
	</table>
  <?php } ?>
    <table width="680" align="center" cellpadding="0" cellspacing="0" style="border-collapse: collapse; border-top: 2px solid #4B2079;">
<tr>
<td>
  <p style="margin-top: 0px; margin-bottom: 20px;text-align: center; padding: 20px 0;"><?php echo $text_footer; ?></p>
  </td></tr></table>
</div>
</body>
</html>
