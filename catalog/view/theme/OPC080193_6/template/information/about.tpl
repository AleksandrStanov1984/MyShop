<?php echo $header; ?>
<?php if(isset($microdata_breadcrumbs) && $microdata_breadcrumbs) echo $microdata_breadcrumbs; ?>
<?php if(isset($microdata) && $microdata) echo $microdata; ?>
<div class="wrapper">
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
    <div class="tab_bar add_scroll">
      <a class="selected" href="javascript: void(0)"><?php echo $text_tab_about; ?></a>
      <a href="<?php echo $payment_link; ?>"><?php echo $text_tab_oplata; ?></a>
      <a  href="<?php echo $shipping_link; ?>"><?php echo $text_tab_dostavka; ?></a>
      <a href="<?php echo $garantiya_link; ?>"><?php echo $text_tab_garantiya; ?></a>
      <a href="<?php echo $return_link; ?>"><?php echo $text_tab_return; ?></a>
      <a href="<?php echo $policy_link; ?>"><?php echo $text_tab_policy; ?></a>
      <a  href="<?php echo $contact; ?>"><?php echo $text_tab_contact; ?></a>
    </div>
    <h1 class="title_about"><?php echo $heading_title; ?></h1>
    <div class="about_main_img">
      <picture>
      <source media="(max-width: 767px)" srcset="catalog/view/theme/OPC080193_6/images/about/aboutban_mob.jpg">
      <source media="(min-width: 768px) and (max-width: 991px)" srcset="catalog/view/theme/OPC080193_6/images/about/aboutban_tablet.jpg">
      <source media="(min-width: 992px)" srcset="catalog/view/theme/OPC080193_6/images/about/aboutban_pc.jpg">
      <img class="img-responsive" src="catalog/view/theme/OPC080193_6/images/about/aboutban_pc.jpg" alt="<?php echo $heading_title; ?>">
      </picture>
      <div class="welcom_content">
        <div class="welcom_content__t"><?php echo $text_welcom_t; ?></div>
        <div class="welcom_content__d"><?php echo $text_welcom_d; ?></div>

      </div>
    </div>

    <h2 class="title_section_adv"><?php echo $text_advantages; ?></h2>
    <div class="row adv_row">
      <div class="col-lg-3 col-6">
        <div class="advantage_item">
          <div class="advantage_wh_cart">
            <div class="advantage_title">
            <?php echo $text_title_advantage_1; ?>
            </div>
              <img src="catalog/view/theme/OPC080193_6/images/about/img_advantage_1.svg" class="img-responsive" alt="<?php echo $text_title_advantage_1; ?>" title="<?php echo $text_title_advantage_1; ?>">
          </div>
          <div class="advantage_bottom">
            <div class="advantage_num"><?php echo $text_adv_num_1; ?></div>
            <div class="advantage_description"><?php echo $text_adv_description_1; ?></div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="advantage_item">
          <div class="advantage_wh_cart">
            <div class="advantage_title">
            <?php echo $text_title_advantage_2; ?>
            </div>
              <img src="catalog/view/theme/OPC080193_6/images/about/img_advantage_2.svg" class="img-responsive" alt="<?php echo $text_title_advantage_2; ?>" title="<?php echo $text_title_advantage_2; ?>">
          </div>
          <div class="advantage_bottom">
            <div class="advantage_num"><?php echo $text_adv_num_2; ?></div>
            <div class="advantage_description"><?php echo $text_adv_description_2; ?></div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="advantage_item">
          <div class="advantage_wh_cart">
            <div class="advantage_title">
            <?php echo $text_title_advantage_3; ?>
            </div>
              <img src="catalog/view/theme/OPC080193_6/images/about/img_advantage_3.svg" class="img-responsive" alt="<?php echo $text_title_advantage_3; ?>" title="<?php echo $text_title_advantage_3; ?>">
          </div>
          <div class="advantage_bottom">
            <div class="advantage_num"><?php echo $text_adv_num_3; ?></div>
            <div class="advantage_description"><?php echo $text_adv_description_3; ?></div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="advantage_item">
          <div class="advantage_wh_cart">
            <div class="advantage_title">
            <?php echo $text_title_advantage_4; ?>
            </div>
              <img src="catalog/view/theme/OPC080193_6/images/about/img_advantage_4.svg" class="img-responsive" alt="<?php echo $text_title_advantage_4; ?>" title="<?php echo $text_title_advantage_4; ?>">
          </div>
          <div class="advantage_bottom">
            <div class="advantage_num"><?php echo $text_adv_num_4; ?></div>
            <div class="advantage_description"><?php echo $text_adv_description_4; ?></div>
          </div>
        </div>
      </div>
    </div>

      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
