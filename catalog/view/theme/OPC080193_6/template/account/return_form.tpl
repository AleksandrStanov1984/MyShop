<?php echo $header; ?>
<div class="wrapper">
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="row">
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?> info_page"><?php echo $content_top; ?>
    <div class="tab_bar add_scroll">
      <a href="<?php echo $about; ?>"><?php echo $text_tab_about; ?></a>
      <a href="<?php echo $payment_link; ?>"><?php echo $text_tab_oplata; ?></a>
      <a  href="<?php echo $shipping_link; ?>"><?php echo $text_tab_dostavka; ?></a>
      <a href="<?php echo $garantiya_link; ?>"><?php echo $text_tab_garantiya; ?></a>
      <a href="javascript: void(0);" class="selected"><?php echo $text_tab_return; ?></a>
      <a href="<?php echo $policy_link; ?>"><?php echo $text_tab_policy; ?></a>
      <a  href="<?php echo $contact; ?>"><?php echo $text_tab_contact; ?></a>
    </div>
    <div id="tab_return">
        <div class="row">
        <div class="col-lg-3">
          <div class="tab-leftbar">
                <a class="selected" href="javascript: void(0);"><?php echo $text_request_return; ?></a>
                <a href="<?php echo $link_term_return; ?>"><?php echo $text_conditions_return; ?></a>
                <a href="<?php echo $link_manual_return; ?>"><?php echo $text_conditions_instruction; ?></a>
                <a href="<?php echo $question_answer_return; ?>"><?php echo $text_question_answer; ?> Вопросы и ответы</a>
              </div>
        </div>
        <div class="col-lg-9 tab_bar_col">
          <div class="tab_bar__body">
        <div id="request_return">
        <h1><img src="catalog/view/theme/OPC080193_6/images/info_page/nova_pochta_logo.svg" alt="nova pochta logo"><span><?php echo $text_send_requisites; ?></span></h1>
        <p><span><?php echo $text_recipient; ?></span> <span style="color:#666666"><?php echo $text_recipient_value; ?></span></p>
        <p><span><?php echo $text_delivery_type; ?></span> <span style="color:#666666"><?php echo $text_delivery_type_value; ?></span></p>
        <p><span><?php echo $text_address; ?></span>  <span style="color:#666666"><?php echo $text_address_value; ?></span></p>
        <p><span><?php echo $text_services; ?></span> <span style="color:#666666"><?php echo $text_services_value; ?></span></p>
        <p class="important-block_short"><?php echo $text_description; ?></p>
        <div class="tab_info__order hidden-xs hidden-sm">
          <div>
            <div class="info_order__title">Номер заказа:</div>
            <div class="info_order__value">РОЗ038290746</div>
          </div>
          <div>
            <div class="info_order__title">Наименование товара:</div>
            <div class="info_order__value">Виски Jameson Irish Whiskey 0.7 л 40% (5011007003005)</div>
          </div>
          <div>
            <div class="info_order__title">Серийный номер товара:</div>
            <div class="info_order__value">$EP823939</div>
          </div>
        </div>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
          <fieldset>
            <!--<legend><?php echo $text_order; ?></legend>-->
            <div class="outlined-text-form required">
              <label class="ch_label" for="input-firstname"><?php echo $entry_firstname; ?></label>
              <div>
                <input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="<?php echo $entry_firstname; ?>" id="input-firstname" class="ch-input" />
                <?php if ($error_firstname) { ?>
                <div class="text-danger"><?php echo $error_firstname; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="outlined-text-form required">
              <label class="ch_label" for="input-lastname"><?php echo $entry_lastname; ?></label>
              <div>
                <input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="<?php echo $entry_lastname; ?>" id="input-lastname" class="ch-input" />
                <?php if ($error_lastname) { ?>
                <div class="text-danger"><?php echo $error_lastname; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="outlined-text-form required">
              <label class="ch_label" for="input-email"><?php echo $entry_email; ?></label>
              <div>
                <input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $entry_email; ?>" id="input-email" class="ch-input" />
                <?php if ($error_email) { ?>
                <div class="text-danger"><?php echo $error_email; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="outlined-text-form required">
              <label class="ch_label" for="input-telephone"><?php echo $entry_telephone; ?></label>
              <div>
                <input type="text" name="telephone" value="<?php echo $telephone; ?>" placeholder="<?php echo $entry_telephone; ?>" id="input-telephone" class="ch-input" />
                <?php if ($error_telephone) { ?>
                <div class="text-danger"><?php echo $error_telephone; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="outlined-text-form required">
              <label class="ch_label" for="input-order-id"><?php echo $entry_order_id; ?></label>
              <div>
                <input type="text" name="order_id" value="<?php echo $order_id; ?>" placeholder="<?php echo $entry_order_id; ?>" id="input-order-id" class="ch-input" />
                <?php if ($error_order_id) { ?>
                <div class="text-danger"><?php echo $error_order_id; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="outlined-text-form">
              <label class="ch_label" for="input-date-ordered"><?php echo $entry_date_ordered; ?></label>
              <div>
                <div class="input-group date"><input type="text" name="date_ordered" value="<?php echo $date_ordered; ?>" placeholder="<?php echo $entry_date_ordered; ?>" data-date-format="YYYY-MM-DD" id="input-date-ordered" class="ch-input" /></div>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <!--<legend><?php echo $text_product; ?></legend>-->
            <div class="outlined-text-form required">
              <label class="ch_label" for="input-product"><?php echo $entry_product; ?></label>
              <div>
                <!--<input type="text" name="product" value="<?php echo $product; ?>" placeholder="<?php echo $entry_product; ?>" id="input-product" class="ch-input" />-->
                <textarea name="product" rows="3" placeholder="<?php echo $entry_product; ?>" id="input-product" class="ch-textarea"><?php echo $product; ?></textarea>
                <?php if ($error_product) { ?>
                <div class="text-danger"><?php echo $error_product; ?></div>
                <?php } ?>
              </div>
            </div>
            <!--div class="form-group required">
              <label class="col-sm-2 ch_label" for="input-model"><?php echo $entry_model; ?></label>
              <div class="col-sm-10">
                <input type="text" name="model" value="<?php echo $model; ?>" placeholder="<?php echo $entry_model; ?>" id="input-model" class="form-control" />
                <?php if ($error_model) { ?>
                <div class="text-danger"><?php echo $error_model; ?></div>
                <?php } ?>
              </div>
            </div-->
            <div class="outlined-text-form">
              <label class="ch_label" for="input-quantity"><?php echo $entry_quantity; ?></label>
              <div>
                <input type="text" name="quantity" value="<?php echo $quantity; ?>" placeholder="<?php echo $entry_quantity; ?>" id="input-quantity" class="ch-input" />
              </div>
            </div>
            <div class="outlined-text-form required">
              <label class="ch_label"><?php echo $entry_reason; ?></label>
              <div>
                <?php foreach ($return_reasons as $return_reason) { ?>
                <?php if ($return_reason['return_reason_id'] == $return_reason_id) { ?>
                <div class="radio ch-radio">
                  <label class="ch-radiu__label">
                    <input type="radio" name="return_reason_id" value="<?php echo $return_reason['return_reason_id']; ?>" class="old-simple-radio" checked="checked" />
                    <span class="radio-custom"></span>
                    <span class="rario-title-simple"><?php echo $return_reason['name']; ?></span>
                    </label>
                </div>
                <?php } else { ?>
                <div class="radio ch-radio">
                  <label class="ch-radiu__label">
                    <input type="radio" name="return_reason_id" class="old-simple-radio" value="<?php echo $return_reason['return_reason_id']; ?>" />
                    <span class="radio-custom"></span>
                    <span class="rario-title-simple"><?php echo $return_reason['name']; ?></span>
                    </label>
                </div>
                <?php  } ?>
                <?php  } ?>
                <?php if ($error_reason) { ?>
                <div class="text-danger"><?php echo $error_reason; ?></div>
                <?php } ?>
              </div>
            </div>
            <div class="outlined-text-form required">
              <label class="ch_label"><?php echo $entry_opened; ?></label>
              <div>
                <label class="radio-inline ch-radiu__label">
                  <?php if ($opened) { ?>
                  <input type="radio" class="old-simple-radio" name="opened" value="1" checked="checked" />
                  <span class="radio-custom"></span>
                  <?php } else { ?>
                  <input type="radio" class="old-simple-radio" name="opened" value="1" />
                  <span class="radio-custom"></span>
                  <?php } ?>
                  <?php echo $text_yes; ?></label>
                <label class="radio-inline ch-radiu__label">
                  <?php if (!$opened) { ?>
                  <input type="radio" class="old-simple-radio" name="opened" value="0" checked="checked" />
                  <span class="radio-custom"></span>
                  <?php } else { ?>
                  <input type="radio" class="old-simple-radio" name="opened" value="0" />
                    <span class="radio-custom"></span>
                  <?php } ?>
                  <?php echo $text_no; ?></label>
              </div>
            </div>
            <div class="">
              <label class="ch_label" for="input-comment"><?php echo $entry_fault_detail; ?></label>
              <div>
                <textarea name="comment" rows="3" placeholder="<?php echo $entry_fault_detail; ?>" id="input-comment" class="ch-textarea"><?php echo $comment; ?></textarea>
              </div>
            </div>
            <?php echo $captcha; ?>
          </fieldset>
          <?php if ($text_agree) { ?>
          <div class="buttons clearfix">
            <div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-danger"><?php echo $button_back; ?></a></div>
            <div class="pull-right"><?php echo $text_agree; ?>
              <?php if ($agree) { ?>
              <input type="checkbox" name="agree" value="1" checked="checked" />
              <?php } else { ?>
              <input type="checkbox" name="agree" value="1" />
              <?php } ?>
              <input type="submit" value="<?php echo $button_submit; ?>" class="btn btn-primary" />
            </div>
          </div>
          <?php } else { ?>
          <div class="buttons clearfix">
            <div class="pull-right">
              <input type="submit" value="<?php echo $button_submit; ?>" class="btn-main" />
            </div>
          </div>
          <?php } ?>
        </form>
        </div>

        </div>
        </div>
        </div>
        </div>


      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script>
<script>
  $(document).ready(function(){
    $('.accardion_items__title').click(function(){
      $(this).parent().toggleClass('open');
    });
    $('#tab_shipping .tab-leftbar a').tabs();
    $('#tab_return .tab-leftbar a').tabs();
    $('#tab_guarantee .tab-leftbar a').tabs();

  })
</script>
<?php echo $footer; ?>
