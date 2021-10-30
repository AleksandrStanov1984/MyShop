<?php echo $header; ?><?php echo $column_left; ?>
<div id="content" class="hpm-series hpm-one">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?><span>by AM</span></h1>
        <div class="version" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?php echo $hpm_version;?>"><span>v</span><?php echo $version_numb;?></div>
        <div form="help_modals" class="btn-help" data-toggle="modal" data-target="#Hpmodel_Modal">
        <div class="btn-helpers" data-toggle="tooltip" title="Info" data-placement="bottom">
          <i class="fa fa-info-circle"></i>
        </div>
      </div>
      <div class="pull-right">
        <a target="_blank" href="https://open-cart.dev" class="btn btn-sm btn-success hpm-mods"><i class="fa fa-puzzle-piece fa-fw"></i> <?php echo $url_module; ?></a>
        <a href="<?php echo $cancel; ?>" data-placement="bottom" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-sm btn-default"><i class="fa fa-reply"></i></a>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if(!$lincense) { ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title red-color"><i class="fa fa-exclamation-triangle"></i> <?php echo $key_name; ?></h3>
            <button form="help_modals" class="pull-right hm-info btn btn-danger btn-sm" data-toggle="modal" data-target="#hpmodel_key">
                <i class="fa fa-info"></i> <b>KEY HELPER</b>
            </button>
        </div>
        <div class="panel-body">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-featured" class="form-horizontal">
                <div class="form-group has-error hpm-key">
                    <label class="col-sm-12 control-label"></label>
                    <div class="col-sm-6">
                        <p class="bg-info">
                            <img class="img-responsive" src="https://awaro.ru/image/catalog/component/a-m/hpm/hpm.jpg">
                            <?php echo $desc_name_key; ?>
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <input type="text" name="hpmodel_key" value="<?php echo $hpmodel_key;?>" placeholder="<?php echo $name_key; ?>" class='form-control'>
                            <span class="input-group-btn">
                            <button type="submit" form="form-hpmodel-add-type"  class="btn btn-info"><?php echo $btn_save_key; ?> <i class="fa fa-key"></i></button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <p class="bg-danger">
                            <b><?php echo $desc_warning_key; ?></b>
                            <?php echo $warning_start_key; ?>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php } ?>
    <?php if($lincense) { ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $name_kit_series;?></h3>
        <button form="help_modals" class="pull-right hm-info btn btn-primary btn-sm" data-toggle="modal" data-target="#Hpmodel_Hpm">
        <i class="fa fa-info"></i> <b>HELPER</b>
        </button>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-featured" class="form-horizontal">

          <table class='table table-hover table-bordered table-responsive'>
            <thead>
              <tr>
                <td class="name-start">
                  <label class="control-label">
                  <span data-toggle="tooltip" title="" data-original-title="<?php echo $text_name;?>">
                  <?php echo $text_name;?>
                  </span>
                  </label>
                </td>
                <td>
                  <label class="control-label">
                  <span data-toggle="tooltip" title="" data-original-title="<?php echo $text_comment;?>">
                  <?php echo $text_comment;?>
                  </span>
                  </label>
                </td>
                <td class="text-center status">
                  <label class="control-label">
                  <span data-toggle="tooltip" title="" data-original-title="<?php echo $text_edit;?>">
                  <i class="fa fa-cogs"></i>
                  </span>
                  </label>
                </td>
                <td class="text-center status">
                  <label class="control-label">
                  <span data-toggle="tooltip" title="" data-original-title="<?php echo $button_on_off;?>">
                  <i class="fa fa-power-off"></i>
                  </span>
                  </label>
                </td>
                <td class="text-center status">
                  <label class="control-label">
                  <span data-toggle="tooltip" title="" data-original-title="<?php echo $button_add_remove;?>">
                  <b style="line-height: 0; font-size: 18px;">±</b>
                  </span>
                  </label>
                </td>
              </tr>
            </thead>
            <tbody>
              <?php foreach($types as $type) { ?>
              <tr>
                <td>
                  <?php echo $type['name']; ?>
                </td>
                <td><?php echo $type['description'];?></td>
                <td class="text-center"><a  class='btn btn-sm btn-primary' href="<?php echo $link_del_type;?><?php echo $type['id'];?>"><i class="fa fa-pencil"></i></a></td>
                <td class="text-center switcher-edits">
                  <!-- Тут включение выключение Типа - ели выключено то нет и в карточке товара -->
                  <input disabled class="bootstrap-switcher" type="checkbox" value="1" name="accumulative_discount[<?php //echo $accumulative_discounts_counter; ?>][status]" data-size="small" data-on-color="success"
                    <?php if($type['status']){ echo 'checked';}?> >
                </td>
                <td class="text-center"><a class="btn btn-sm btn-danger remove-type" data-action="<?php echo $link_edit_type;?><?php echo $type['id'];?>"><i class="fa fa-remove"></i></a></td>
              </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="4"></td>
                <td class="text-center">
                  <a class="btn btn-sm btn-success" href="<?php echo $link_add_new_series;?>"><i class="fa fa-plus"></i></a>
                </td>
              </tr>
            </tfoot>
          </table>
        </form>
        <b><?php echo $activation_key_name; ?>:</b> <?php echo $hpmodel_key; ?>
      </div>
    </div>
    <?php } ?>
    <div class="row">
      <div class="col-sm-12">
        <div class="panel-heading text-center copy">
          <button form="help_modals" class="hm-info btn btn-primary btn-sm" data-toggle="modal" data-target="#Authors_Modal">
          <?php echo $desc_author_start; ?>
          </button>
        </div>
      </div>
    </div>
    <?php echo $footer; ?>
  </div>
</div>

<div class="modal fade" id="Hpmodel_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-sitemap fa-rotate-90"></i> HYPER PRODUCT MODELS</h4>
      </div>
      <div class="modal-body">
        <div class="help-text"><?php echo $help_first_kit_series; ?></div>
      </div>
      <div class="modal-footer">
        <div class="text-center"><?php echo $copy_label; ?></div>
      </div>
    </div>
  </div>
</div>

<?php if(!$lincense) { ?>
<div class="modal fade" id="hpmodel_key" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-cogs"></i> <?php echo $help_text_key; ?></h4>
            </div>
            <div class="modal-body">
                <div class="text-center"><?php echo $help_second_key; ?></div>
                <div class="help-text"><?php echo $help_third_key; ?></div>
            </div>
            <div class="modal-footer">
                <div class="text-center"><?php echo $copy_label; ?></div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<div class="modal fade" id="Hpmodel_Hpm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-cogs"></i> <?php echo $name_kit_series; ?></h4>
      </div>
      <div class="modal-body">
        <div class="text-center"><?php echo $help_second_kit_series; ?></div>
        <div class="help-text"><?php echo $help_third_kit_series; ?></div>
      </div>
      <div class="modal-footer">
        <div class="text-center"><?php echo $copy_label; ?></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="Authors_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-copyright"></i> <?php echo $desc_author; ?></h4>
      </div>
      <div class="modal-body authors">
        <legend class="text-center"><?php echo $desc_copy; ?></legend>
        <div class="text-center"><?php echo $desc_author_copy; ?></div>
        <br>
      </div>
      <div class="modal-footer">
        <div class="text-center"><?php echo $copy_label; ?></div>
      </div>
    </div>
  </div>
</div>

<script>
$('.bootstrap-switcher').bootstrapSwitch();
 
$('.remove-type').on('click', function() {
    if (confirm('Вы уверены?')) {
        if ($(this).data('action')) location = $(this).data('action');
    } else {
        return false;
    }
});
</script>