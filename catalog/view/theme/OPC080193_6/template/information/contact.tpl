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
          <a href="<?php echo $about; ?>"><?php echo $text_tab_about; ?></a>
          <a href="<?php echo $payment_link; ?>"><?php echo $text_tab_oplata; ?></a>
          <a  href="<?php echo $shipping_link; ?>"><?php echo $text_tab_dostavka; ?></a>
          <a href="<?php echo $garantiya_link; ?>"><?php echo $text_tab_garantiya; ?></a>
          <a href="<?php echo $return_link; ?>"><?php echo $text_tab_return; ?></a>
          <a href="<?php echo $policy_link; ?>"><?php echo $text_tab_policy; ?></a>
          <a class="selected" href="javascript: void(0)"><?php echo $text_tab_contact; ?></a></div>
      <div class="white_bg">
        <h1 class="h2-title hidden-xs"><?php echo $heading_title; ?></h1>
        <div class="contact_welcome">
          <div class="contact_welcome__t">SMARTZONE</div>
          <div class="contact_welcome__d"><?php echo $text_welcome_d; ?></div>
        </div>
        <div class="row">
          <div class="col-lg-6 co-left-part">
            <div class="co-location">
                <h4 class="co-title"><span class="hidden-xs"><?php echo $text_location; ?></span></h3>
                <div class="co-description"><?php echo $address; ?></div>
            </div>
            <div class="co-phone">
                <h4 class="co-title"><span class="hidden-xs"><?php echo $text_telephone; ?></span></h3>
                <div class="">
                  <a href="tel:<?php echo str_replace(' ', '', $telephone); ?>" class="tel-universal-contact binct-phone-number-1" rel="nofollow">
                    <?php echo $telephone; ?></a>
                    <div class="tel-contact">
                      <div>
                        <a href="tel:0660204021" class="tel tel-mts binct-phone-number-2" rel="nofollow">066 02 04 021</a>
                        <a href="tel:0980204021" class="tel tel-kyiv binct-phone-number-3" rel="nofollow">098 02 04 021</a>
                      </div>
                      <div>
                        <a href="javascript:void(0)" class="tel tel-life"><img src="catalog/view/theme/OPC080193_6/images/contact/0930204021.svg" alt="phone" class="black-phone-life"></a>
                        <a href="javascript:void(0)" class="tel tel-city"><img src="catalog/view/theme/OPC080193_6/images/contact/0444997668.svg" class="black-phone-city" alt="phone"></a>
                      </div>
                    </div>
                </div>
            </div>
            <div class="co-email">
                <h4 class="co-title"><span class="hidden-xs"><?php echo $text_email; ?></span></h3>
                <a href="mailto:<?php echo $email; ?>" class="btn-link" rel="nofollow"><?php echo $email; ?></a>
            </div>
            <div class="co-schedule hidden-xs">
                <h4 class="co-title"><?php echo $text_open; ?></h3>
                  <?php if ($open) { ?>
                  <div class="co-description"><?php echo $open; ?></div>
                  <?php } ?>
            </div>
            <div class="co-warehouse hidden-xs">
                <h4 class="co-title"><?php echo $entry_delivery_from_stock; ?></h3>
                  <div class="co-description"><?php echo $text_delivery_from_stock; ?></div>

            </div>
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="contact-info">
              <div class="left">
                <div class="address-detail">
                  </div>
            <div class="comment">
                    <?php if ($comment) { ?>
              <i class="fa fa-bullhorn"></i>
                    <strong><?php echo $text_comment; ?></strong>
                    <address><?php echo $comment; ?></address>
                    <?php } ?>
                  </div>
            </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 hidden-xs">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
              <fieldset>
                <h3 class="title_contact_form"><?php echo $text_contact; ?></h3>
                <div class="outlined-text-form  required">
                  <label class="ch_label" for="input-name"><?php echo $entry_name; ?></label>
                  <div class="">
                    <input type="text" name="name" placeholder="<?php echo $text_placeholder_name; ?>" value="<?php echo $name; ?>" id="input-name" class="ch-input" />
                    <?php if ($error_name) { ?>
                    <div class="text-danger"><?php echo $error_name; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="outlined-text-form  required">
                  <label class="ch_label" for="input-email"><?php echo $entry_email; ?></label>
                  <div class="">
                    <input type="text" placeholder="<?php echo $text_placeholder_email; ?>" name="email" value="<?php echo $email; ?>" id="input-email" class="ch-input" />
                    <?php if ($error_email) { ?>
                    <div class="text-danger"><?php echo $error_email; ?></div>
                    <?php } ?>
                  </div>
                </div>
                <div class="outlined-text-form  required">
                  <label class="ch_label" for="input-enquiry"><?php echo $entry_enquiry; ?></label>
                  <div class="">
                    <textarea name="enquiry" placeholder="<?php echo $text_placeholder_enquiry; ?>" rows="6" id="input-enquiry" class="ch-textarea"><?php echo $enquiry; ?></textarea>
                    <?php if ($error_enquiry) { ?>
                    <div class="text-danger"><?php echo $error_enquiry; ?></div>
                    <?php } ?>
                  </div>
                </div>
               <?php echo $captcha; ?>
              </fieldset>
              <div class="buttons">
                <div class="pull-right">
                  <input class="btn-main btn-xl" type="submit" value="<?php echo $button_submit; ?>" />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="white_bg conact_maps">

<div class="row contact_location_row">
<div class="col-xl-6">
  <div class="map_container chaiki_warehouse">
    <picture> <source media="(max-width: 767px)" srcset="catalog/view/theme/OPC080193_6/images/info_page/chaiki_warehouse_767.jpg" /> <source media="(min-width: 767px)" srcset="catalog/view/theme/OPC080193_6/images/info_page/chaiki_warehouse.jpg" /> <img alt="map" class="img-responsive" src="catalog/view/theme/OPC080193_6/images/info_page/chaiki_warehouse.jpg"/> </picture>
  </div>
</div>
<div class="col-xl-6 driving-directions">
<div class="driving-directions_item">
<div class="co-title-map"><?php echo $text_go_from_akademgorodoc; ?></div>

<div class="map_container map_from_zhitomirska"><picture> <source media="(max-width: 767px)" srcset="catalog/view/theme/OPC080193_6/images/info_page/from_akademgorodok_767.jpg" /> <source media="(min-width: 767px)" srcset="catalog/view/theme/OPC080193_6/images/info_page/from_akademgorodok_640.jpg" /> <img alt="<?php echo $text_go_from_akademgorodoc; ?>" title="<?php echo $text_go_from_akademgorodoc; ?>" class="img-responsive" src="catalog/view/theme/OPC080193_6/images/info_page/from_akademgorodok_640.jpg"/> </picture></div>
</div>
</div>
</div>
<div>
  <div class="co-title-map">Google карта</div>

  <div class="frame_container">
  <div class="map_container">
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1068.4714487239987!2d30.30962468389199!3d50.43611419791558!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb9311bb000273718!2zU01BUlRaT05FIC0g0L7QvdC70LDQudC9INCz0LjQv9C10YDQvNCw0YDQutC10YI!5e0!3m2!1sru!2sua!4v1614243609452!5m2!1sru!2sua" style="width:100%;" allowfullscreen="" loading="lazy"></iframe>
  </div>
  </div>
</div>
</div>



      <!--<?php if ($locations) { ?>
      <h3><?php echo $text_store; ?></h3>
      <div class="panel-group" id="accordion">
        <?php foreach ($locations as $location) { ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-title"><a href="#collapse-location<?php echo $location['location_id']; ?>" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"><?php echo $location['name']; ?> <i class="fa fa-caret-down"></i></a></h4>
          </div>
          <div class="panel-collapse collapse" id="collapse-location<?php echo $location['location_id']; ?>">
            <div class="panel-body">
              <div class="row">
                <?php if ($location['image']) { ?>
                <div class="col-sm-3"><img src="<?php echo $location['image']; ?>" alt="<?php echo $location['name']; ?>" title="<?php echo $location['name']; ?>" class="img-thumbnail" /></div>
                <?php } ?>
                <div class="col-sm-3"><strong><?php echo $location['name']; ?></strong><br />
                  <address>
                  <?php echo $location['address']; ?>
                  </address>
                  <?php if ($location['geocode']) { ?>
                  	<a href="https://maps.google.com/maps?q=<?php echo urlencode($location['geocode']); ?>&hl=<?php echo $geocode_hl; ?>&t=m&z=15" target="_blank" class="btn btn-info"><i class="fa fa-map-marker"></i> <?php echo $button_map; ?></a>
                  <?php } ?>
                </div>

                <div class="col-sm-3"><strong><?php echo $text_telephone; ?></strong><br>
                  <?php echo $location['telephone']; ?><br />
                  <br />
                  <?php if ($location['fax']) { ?>
                  <strong><?php echo $text_telephone; ?></strong><br>
                  <?php echo $location['fax']; ?>
                  <?php } ?>
                </div>
                <div class="col-sm-3">
                  <?php if ($location['open']) { ?>
                  <strong><?php echo $text_open; ?></strong><br />
                  <?php echo $location['open']; ?><br />
                  <br />
                  <?php } ?>
				  <?php if ($location['email']) { ?>
                  <strong><?php echo $text_email; ?></strong><br />
                  <?php echo $location['email']; ?><br />
                  <br />
                  <?php } ?>
                  <?php if ($location['comment']) { ?>
                  <strong><?php echo $text_comment; ?></strong><br />
                  <?php echo $location['comment']; ?>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    <?php } ?>-->

      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>

<?php echo $footer; ?>
