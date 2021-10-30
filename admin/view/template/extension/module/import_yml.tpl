<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
  <div class="container-fluid">
  <div class="row">
  <div class="col-md-8">
      <h1><i class="fa fa-exchange"></i> <?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
  </div>
  <div class="col-md-4" style="text-align: right;">
    <a onclick="$('#form_product_import').submit()" class="btn btn-primary"><span><i class="fa fa-upload"></i> <?php echo $button_import; ?></span></a>
  </div>
  </div>
    </div>
  </div>

  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" form="form-backup" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-exchange"></i> <?php echo $heading_title; ?></h3>
      </div>
      <div class="panel-body">
         <form id="form_product_import" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab-general" data-toggle="tab">Настройки</a></li>
              <li><a href="#tab-info" data-toggle="tab">Инфо</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab-general">
                <div id="wrap_profile_export" class="well well-sm">
                  <div id="form_profile_import" class="form-horizontal">
                    <div class="form-group">
                      <div class="col-sm-12 text-center">Profile ID = <b><?php echo $id; ?></b></div>
                      <div class="col-sm-12 text-center">Ссылка для запуска обновления цен и наличия <a target="_blank" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/import_yml_cron.php?profile_id=<?php echo $id; ?>&cron_key=fiykT3jwki">https://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/import_yml_cron.php?profile_id=<?php echo $id; ?>&cron_key=fiykT3jwki</a></div>
                    </div>
                    <div class="form-group form-group-sm">
                      <label class="col-sm-4 control-label" data-prop_id="33"><span class="f-icon-helper" aria-hidden="true">Загрузить профиль</span></label>
                      <div class="col-sm-8">
                        <div class="input-group">
                          <select name="profile_import_select" id="profile_import_select" class="form-control input-sm">
                            <option value="0">Deafult Profile</option>
                            <?php if($profiles) { ?>
                              <?php foreach ($profiles as $profile) { ?>
                                <option value="<?php echo $profile['id']; ?>" <?php if($id == $profile['id']) echo 'selected="selected"'; ?>><?php echo $profile['name']; ?></option>
                              <?php } ?>
                            <?php } ?>
                          </select>
                          <span class="input-group-btn">
                          <a onclick="loadProfile('profile_import');" data-toggle="tooltip" title="" class="btn btn-info btn-sm" data-original-title="Загрузить"><i class="fa fa-refresh"></i></a>
                          <a onclick="updateProfile('profile_import', <?php echo $id; ?>);" data-toggle="tooltip" title="" class="btn btn-primary btn-sm" data-original-title="Сохранить"><i class="fa fa-save"></i></a>
                          <a onclick="deleteProfile('profile_import');" data-toggle="tooltip" title="" class="btn btn-warning btn-sm" data-original-title="Удалить"><i class="fa fa-trash-o"></i></a>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group form-group-sm">
                      <label class="col-sm-4 control-label">Создать новый профиль</label>
                      <div class="col-sm-8">
                        <div class="input-group">
                          <input type="text" name="profile_import_name" id="profile_import_name" value="" class="form-control input-sm">
                          <span class="input-group-btn">
                          <a onclick="createProfile('profile_import')" data-toggle="tooltip" title="" class="btn btn-success btn-sm" data-original-title="Добавить"><i class="fa fa-plus-circle"></i></a>
                          <span style="margin-right:57px;"></span>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <input type="hidden" name="import_yml_profile_name" value="<?php echo isset($profile_name) ? $profile_name : ''; ?>"/>
                <input type="hidden" name="profile_id" value="<?php echo $id; ?>"/>
                <table class="form">
                  <tr>
                    <td colspan="2"><?php echo $entry_description; ?></td>
                  </tr>
                  <tr>
                    <td width="25%"><?php echo $entry_restore; ?></td>
                    <td><input type="file" name="import_yml_upload" /></td>
                  </tr>
                  <tr>
                    <td width="25%"><?php echo $entry_url; ?></td>
                    <td><input type="text" name="import_yml_url" size="50" value="<?php echo isset($settings['import_yml_url']) ? $settings['import_yml_url'] : ''; ?>"/></td>
                  </tr>
                  <tr>
                    <td width="25%">Префикс поставщика <span style="color:red;">*</span></td>
                    <td><input required type="text" name="import_yml_prefix" value="<?php echo isset($settings['import_yml_prefix']) ? $settings['import_yml_prefix'] : ''; ?>"/></td>
                  </tr>
                  <tr>
                    <td width="25%"><?php echo $entry_update; ?></td>
                    <td>
                      <input type="checkbox" name="import_yml_name" <?php if (isset($settings['import_yml_name']) && $settings['import_yml_name'] == 'on') { echo 'checked="checked"'; } ?>/><?php echo $entry_field_name; ?><br />
                      <input type="checkbox" name="import_yml_description" <?php if (isset($settings['import_yml_description']) && $settings['import_yml_description'] == 'on') { echo 'checked="checked"'; } ?>/><?php echo $entry_field_description; ?><br />
                      <input type="checkbox" name="import_yml_category" <?php if (isset($settings['import_yml_category']) && $settings['import_yml_category'] == 'on') { echo 'checked="checked"'; } ?>/><?php echo $entry_field_category; ?><br />
                      <input type="checkbox" name="import_yml_price" <?php if (isset($settings['import_yml_price']) && $settings['import_yml_price'] == 'on') { echo 'checked="checked"'; } ?>/><?php echo $entry_field_price; ?><br />
                      <input type="checkbox" name="import_yml_quantity" <?php if (isset($settings['import_yml_quantity']) && $settings['import_yml_quantity'] == 'on') { echo 'checked="checked"'; } ?>/>Количество<br />
                      <input type="checkbox" name="import_yml_image" <?php if (isset($settings['import_yml_image']) && $settings['import_yml_image'] == 'on') { echo 'checked="checked"'; } ?>/><?php echo $entry_field_image; ?><br />
                      <input type="checkbox" name="import_yml_manufacturer" <?php if (isset($settings['import_yml_manufacturer']) && $settings['import_yml_manufacturer'] == 'on') { echo 'checked="checked"'; } ?>/><?php echo $entry_field_manufacturer; ?><br />
                      <input type="checkbox" name="import_yml_attributes" <?php if (isset($settings['import_yml_attributes']) && $settings['import_yml_attributes'] == 'on') { echo 'checked="checked"'; } ?>/><?php echo $entry_field_attribute; ?><br />
                      <input type="checkbox" name="import_yml_load_image" <?php if (isset($settings['import_yml_load_image']) && $settings['import_yml_load_image'] == 'on') { echo 'checked="checked"'; } ?>/>Загрузить только изображения<br />
                    </td>
                  </tr>
                  <tr>
                    <td width="25%">Запуск по крону</td>
                    <td><input type="checkbox" name="import_yml_cron" <?php if (isset($settings['import_yml_cron']) && $settings['import_yml_cron'] == 'on') { echo 'checked="checked"'; } ?>/></td>
                  </tr>
                  <tr>
                    <td width="25%">Разбить импорт на части</td>
                    <td>
                      <input type="text" name="import_yml_separate_start" value="<?php echo isset($settings['import_yml_separate_start']) ? $settings['import_yml_separate_start'] : 0; ?>"/>
                      <input type="text" name="import_yml_separate_end" value="<?php echo isset($settings['import_yml_separate_end']) ? $settings['import_yml_separate_end'] : 0; ?>"/>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="tab-pane" id="tab-info">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Профиль</th>
                      <th>Ссылка на xml</th>
                      <th>Крон</th>
                      <th>Ссылка крон</th>
                      <th>Время обновления</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($profiles as $profile) { ?>
                    <?php $setting = json_decode($profile['setting'], true); ?>
                    <tr>
                      <td><?php echo $profile['id']; ?></td>
                      <td><?php echo $profile['name']; ?></td>
                      <td><?php echo $setting['import_yml_url'] ? '<a style="word-break: break-all;display: block;max-width: 100%;" href="'.$setting['import_yml_url'].'" target="_blank">'.$setting['import_yml_url'].'</a>' : ''; ?></td>
                      <td><?php echo isset($setting['import_yml_cron']) && $setting['import_yml_cron'] == 'on' ? '<span style="color:green">'.$setting['import_yml_cron'].'</span>' : '<span style="color:red">off</span>'; ?></td>
                      <td><a target="_blank" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/import_yml_cron.php?profile_id=<?php echo $profile['id']; ?>&cron_key=fiykT3jwki">https://<?php echo $_SERVER['HTTP_HOST']; ?>/admin/import_yml_cron.php?profile_id=<?php echo $profile['id']; ?>&cron_key=fiykT3jwki</a></td>
                      <td><?php echo $profile['date_update'] != '0000-00-00 00:00:00' ? date("Y-m-d H:i:s", strtotime($profile['date_update'])) : ''; ?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>
<script>

  function startImport(key) {
    var s = '#' + key + '_select';
    var id = $( s +' option:selected').val();
    var data = $("#form_product_import").serialize();

    $.ajax({
      type: "POST",
      url: '<?php echo $action; ?>&profile_id='+id,
      data: data,
      datatype: 'json',
      success: function(json){

        if(json['success']) {
          $('#form_product_import').before('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> ' + json['success'] + '</div>');
        }

      }
    });
    return false;
  }

  function deleteProfile(key) {
    if (!confirm('Удаление невозможно отменить! Вы уверены, что хотите это сделать?')) return false;
    var s = '#' + key + '_select';
    if($(s).get(0).options.length == 0) {
      return;
    }
    var id = $( s +' option:selected').val();
    $.ajax({
      type: "POST",
      url: '<?php echo $delete_profile; ?>',
      data: {profile_id: id},
      success: function(json){
        // редирект на дефолтный профиль
        var url = '<?php echo $action; ?>';
        url = url.replace( /\&amp;/g, '&' );
        window.location.href = url;
      }
    });
    return false;
  }
  function loadProfile(key, profile_id = false) {
    var s = '#' + key + '_select';
    if($(s).get(0).options.length == 0) {
      return;
    }
    if(!profile_id) {
      var profile_id = $( '#' + key + '_select' + ' option:selected').val();
    }

    var url = '<?php echo $action; ?>&profile_type=' + key +'&profile_id=' + profile_id;
    url = url.replace( /\&amp;/g, '&' );
    window.location.href = url;

  }
  function createProfile(key) {
    if($('#' + key + '_name').val() == '') return false;
    var data;

    if( key == 'profile_import' ){
      data = $("#form_product_import, #form_profile_import").serialize();
    } else if( key == 'profile_export' ){
      data = $("#form_product_export, #form_profile_export").serialize();
    } else {
      return false;
    }

    $.ajax({
      type: "POST",
      url: '<?php echo $add_profile; ?> ',
      data: data,
      datatype: 'json',
      success: function(json){

        if(json['success']) {
          $('#form_product_import').before('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> ' + json['success'] + '</div>');

          loadProfile(key, json['profile_id']);
        }

      }
    });
    return false;
  }
  function updateProfile(key, id = false) {

    var s = '#' + key + '_select';
    if($(s).get(0).options.length == 0) {
      return;
    }
    if(!id) {
      var id = $( '#' + key + '_select' + ' option:selected').val();
    }

    if( key == 'profile_import' ){
      data = $("#form_product_import, #form_profile_import").serialize();
    } else if( key == 'profile_export' ){
      data = $("#form_product_export, #form_profile_export").serialize();
    } else if( key == 'profile_setting' ){
      data = $("#form_profile_setting, #form_product_setting").serialize();
    } else if( key == 'profile_fields' ){
      data = $("#form_profile_fields, #form_product_fields").serialize();
    } else {
      return false;
    }

    $.ajax({
      type: "POST",
      url: '<?php echo $update_profile; ?>&profile_id='+id,
      data: data,
      datatype: 'json',
      success: function(json){
        if(json['success']) {
          //$('#form_product_import').before('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> ' + json['success'] + '</div>');
          $//('#' + key + '_name').val('');
          loadProfile(key, id);
        }
      }
    });
    return false;
  }
</script>
<?php echo $footer; ?>