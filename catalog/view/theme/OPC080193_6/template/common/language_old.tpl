<?php if (count($languages) > 1) { ?>
<div class="lang">
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-language">
      <?php foreach ($languages as $language) { ?>
      	<?php if($code == $language['code']){ ?>
      	<span data-code="<?php echo $language['code']; ?>" class="lang-item <?php echo $code == $language['code'] ? 'active' : ''; ?>"><?php echo $language['name']; ?></span>
      	<?php }else{ ?>
		<a href="javascript:void(0);" <?php echo $code == $language['code'] ? 'onclick="javascript:stopLink()"' : ''; ?> data-code="<?php echo $language['code']; ?>" class="lang-item"><?php echo $language['name']; ?></a>
      	 <?php } ?>
      <?php } ?>
  <input type="hidden" name="code" value="" />
  <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
</form>
</div>
<?php } ?>