<?php if (count($languages) > 1) { ?>
<div class="lang">
    <?php foreach ($languages as $language) { ?>
    	<?php if($code == $language['code']){ ?>
    	<span class="lang-item <?php echo $code == $language['code'] ? 'active' : ''; ?>"><?php echo $language['name']; ?></span>
    	<?php }else{ ?>
	<a href="<?php echo $language['code']; ?>" class="lang-item"><?php echo $language['name']; ?></a>
    	 <?php } ?>
    <?php } ?>
</div>
<?php } ?>

