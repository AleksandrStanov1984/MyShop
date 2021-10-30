<?php echo $header; ?>
<section class="page-404">
	<div class="wrapper">
		<div class="row">
			<div class="col-md-5 col-lg-5 col-xl-4">
				<div class="before_error_title"><?php echo $before_heading_title; ?></div>
				<h1 class="error_title"><?php echo $heading_title; ?></h1>
					<p class="error_useful_links"><?php echo $text_useful_links; ?></p>
					<ul class="error_link">
						<li><a href="<?php echo $continue; ?>"><?php echo $text_home; ?></a></li>
						<?php foreach ($informations as $information) { ?>
						<li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
						<?php } ?>
						<li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
					</ul>
			</div>
			<div class="col-md-6 offset-md-1 col-lg-6 offset-lg-1 col-xl-7 offset-xl-1">
				<img src="catalog/view/theme/OPC080193_6/images/404.svg" class="img-responsive error_img" alt="404">
			</div>
		</div>
	</div>
</section>
<?php echo $footer; ?>
