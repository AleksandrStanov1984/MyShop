<?php echo $header; ?>
<div class="wrapper">
  <!--<ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>-->
  <div class="row account-box account-box-order"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <div>
      <h1><?php echo $heading_title; ?></h1>
      <?php if ($orders) { ?>
      <div class="table-responsive">
        <table class="table-bordered table-hover table-my-order-history">
          <thead class="hidden-xs">
            <tr>
              <td class="text-left colomn-order-id"><?php echo $column_order_id; ?></td>
              <!--<td class="text-left"><?php echo $column_customer; ?></td>-->
              <td class="text-left"><?php echo $column_name; ?></td>
              <td class="text-left"><?php echo $column_status; ?></td>
              <td class="text-left"><?php echo $column_total; ?></td>
              <!--<td class="text-left"><?php echo $column_date_added; ?></td>-->
            </tr>
          </thead>
          <tbody>
            
            <?php foreach ($orders as $order) { ?>
            <tr>
              <td class="text-left td-first-order">
                <div class="date-order-history"><?php echo $order['date_added']; ?></div>
                <div class="id-order-history">
                  № <?php echo $order['order_id']; ?>
                </div>
              </td>
              <!--<td class="text-left"><?php echo $order['name']; ?></td>-->
              <td class="text-left td-second-order"><div class="visible-xs list-product-order"><?php echo $order['products_qnt_mob']; ?></div>  <?php foreach ($order['products'] as $product) { ?>
                <div class="name-order-history">&ndash;<?php echo $product['name']; ?></div>
              <?php } ?></td>
              <td class="text-left td-third-order"><div class="visible-xs label-status-order"><?php echo $column_status; ?></div><span class="status-order-history" style="color: <?php if ($order['status_id'] == 1){
 echo '#163955'; } else if($order['status_id'] == 7){
 echo '#FBAD25'; }else if($order['status_id'] == 14){
 echo '#27AE60'; }else{ echo '#163955'; }; ?>"><?php echo $order['status']; ?></span>
            </td>
            <td class="text-left td-fourth-order">
                <div class="qnt-text-order hidden-xs"><?php echo $order['products_qnt']; ?></div>
                <div class="total-order-history"><?php echo $order['total']; ?></div></td>

              <!--<td class="text-right"><?php if (!empty($order['ocstore_payeer_onpay'])) { ?><a rel="nofollow" onclick="location='<?php echo $order['ocstore_payeer_onpay']; ?>'" data-toggle="tooltip" title="<?php echo $button_ocstore_payeer_onpay; ?>" class="btn btn-info"><i class="fa fa-usd"></i></a>&nbsp;&nbsp;<?php } ?><?php if (!empty($order['ocstore_yk_onpay'])) { ?><a rel="nofollow" onclick="location='<?php echo $order['ocstore_yk_onpay']; ?>'" data-toggle="tooltip" title="<?php echo $button_ocstore_yk_onpay; ?>" class="btn btn-info" ><i class="fa fa-usd"></i></a>&nbsp;&nbsp;<?php } ?><a href="<?php echo $order['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a></td>-->
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <!--<div class="col-sm-6 text-right"><?php echo $results; ?></div>-->
      </div>
      <?php } else { ?>
      <p class="text-empty-order"><?php echo $text_empty; ?></p>
      <?php } ?>
      <!--<div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>-->
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
