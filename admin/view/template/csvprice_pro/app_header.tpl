<?php if  ($error_system_test): ?>
<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> &nbsp; <?php echo $error_text_system_test; ?> <button type="button" class="close" data-dismiss="alert">×</button></div>
<?php endif;?>

<?php if ($mod_demo) { ?>
<p><?php echo $mdemo_title; ?></p>
<?php } ?>
<h4><?php echo $csvprice_pro_heading_title; ?></h4>
<p class="csvpricepro-main_menu">
<?php foreach( $top_menu as $menu_item ) { ?>
	<?php if ($menu_item['active'] == 1) { ?>
	<a href="<?php echo $menu_item['url'];?>" class="btn btn-info active"><?php echo $menu_item['text'];?></a>
	<?php } else { ?>
	<a href="<?php echo $menu_item['url'];?>" class="btn btn-info"><?php echo $menu_item['text'];?></a>
	<?php } ?>
<?php } ?>
</p>