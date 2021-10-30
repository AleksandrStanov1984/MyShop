<table class="table table-bordered">
  <thead>
    <tr>
      <td class="text-left">Категория для гугла</td>
      <td class="text-left"><?php echo $column_category; ?></td>
      <td class="text-right"><?php echo $column_action; ?></td>
    </tr>
  </thead>
  <tbody>
    <?php if ($google_base_categories_sz) { ?>
    <?php foreach ($google_base_categories_sz as $google_base_category) { ?>
    <tr>
      <td class="text-left"><?php echo $google_base_category['google_base_category_sz']; ?></td>
      <td class="text-left"><?php echo $google_base_category['category']; ?></td>
      <td class="text-right"><button type="button" value="<?php echo $google_base_category['category_id_sz']; ?>" data-loading-text="<?php echo $text_loading; ?>" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
    </tr>
    <?php } ?>
    <?php } else { ?>
    <tr>
      <td class="text-center" colspan="3"><?php echo $text_no_results; ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<div class="row">
  <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
  <div class="col-sm-6 text-right"><?php echo $results; ?></div>
</div>