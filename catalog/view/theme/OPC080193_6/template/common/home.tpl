<?php echo $header; ?>
<?php if(isset($microdata) && $microdata) echo $microdata; ?>
<div class="wrapper mob-wrapper-home wrapper-home">
    <?php echo $content_top; ?>
<div class="row" style="margin-left: 0px; margin-right: 0px" >
	<?php if ($column_left && $column_right) { ?>
    <?php $class = 'main-column-home'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'main-column-home'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div class="<?php echo $class; ?>">
		<?php echo $content_bottom; ?>
	</div>

	<?php echo $column_right; ?>

</div>
<?php echo $column_left; ?>
</div>


<!--seo_text_start-->

<!--seo_text_end-->
<h1></h1>


<?php echo $footer; ?>