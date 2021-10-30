<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
	  
		  <div class="form-group">
			<label class="col-sm-2 control-label text-right" for="input-status"><?php echo $entry_status; ?></label>
			<div class="col-sm-10">
			  <select name="ts_google_analytics_status" id="input-status" class="form-control">
				<?php if ($ts_google_analytics_status) { ?>
				<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
				<option value="0"><?php echo $text_disabled; ?></option>
				<?php } else { ?>
				<option value="1"><?php echo $text_enabled; ?></option>
				<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
				<?php } ?>
			  </select>
			</div>
		  </div>
		  <br>
		
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-main-settings" data-toggle="tab"><?php echo $tab_main_settings; ?></a></li>
            <li><a href="#tab-userParams" data-toggle="tab"><?php echo $tab_userParams; ?></a></li>
            <li><a href="#tab-ecommerce" data-toggle="tab"><?php echo $tab_ecommerce; ?></a></li>
            <li><a href="#tab-goals" data-toggle="tab"><?php echo $tab_goals; ?></a></li>
            <li><a href="#tab-help" data-toggle="tab"><i class="fa fa-question-circle" style="color:#1e91cf;"></i> <?php echo $tab_help; ?></a></li>
          </ul>
	      <div class="tab-content">
		  	
			<div class="tab-pane active" id="tab-main-settings">
                <div class="form-group required">
                  <label class="col-sm-2 control-label" for="input-counter-counter-id"><span data-toggle="tooltip" title="<?php echo $help_counter['counter_id']; ?>"><?php echo $entry_counter['counter_id']; ?></span></label>
                  <div class="col-sm-10">
				  <input type="text" name="ts_google_analytics_settings[counter][counter_id]" value="<?php echo $ts_google_analytics_settings['counter']['counter_id']; ?>" placeholder="<?php echo $entry_counter['counter_id']; ?>" id="input-counter-counter-id" class="form-control" />
				  <?php if ($error_counter_id) { ?>
				  <div class="text-danger"><?php echo $error_counter_id; ?></div>
				  <?php } ?>
                  </div>
                </div>
				<br>
				
              <fieldset>
                <legend><?php echo $text_title['counter']; ?></legend>
				
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_counter['type']; ?>"><?php echo $entry_counter['type']; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[counter][type]" value="analytics" <?php if ($ts_google_analytics_settings['counter']['type'] == 'analytics') { ?>checked="checked"<?php } ?> />
                      <?php echo $text_counter['analytics']; ?>
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[counter][type]" value="gtag" <?php if ($ts_google_analytics_settings['counter']['type'] == 'gtag') { ?>checked="checked"<?php } ?> />
                      <?php echo $text_counter['gtag']; ?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_counter['mode']; ?>"><?php echo $entry_counter['mode']; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[counter][mode]" value="0" <?php if (!$ts_google_analytics_settings['counter']['mode']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_counter['default']; ?>
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[counter][mode]" value="1" <?php if ($ts_google_analytics_settings['counter']['mode']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_counter['asynch']; ?>
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_counter['pageview']; ?>"><?php echo $entry_counter['pageview']; ?></span></label>
                  <div class="col-sm-9">
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[counter][pageview][status]" value="1" <?php if ($ts_google_analytics_settings['counter']['pageview']['status']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_yes; ?>
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[counter][pageview][status]" value="0" <?php if (!$ts_google_analytics_settings['counter']['pageview']['status']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_no; ?>
                    </label>
                  </div>
                  <label class="col-sm-1 counter-option-chevron" data-params="counter-pageview-params"><span <?php if ($ts_google_analytics_settings['counter']['pageview']['status']) { ?>class="rotate"<?php } ?>></span></label>
                </div>
				<div class="form-group counter-option-params" id="counter-pageview-params" <?php if (!$ts_google_analytics_settings['counter']['pageview']['status']) { ?>style="display:none;"<?php } ?>>
					<div class="col-sm-12 counter-option-param">
						<div class="form-group">
						  <label class="col-sm-1"></label>
						  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_counter['pageview_title']; ?>"><?php echo $entry_counter['pageview_title']; ?></span></label>
						  <div class="col-sm-9">
							<label class="radio-inline">
							  <input type="radio" name="ts_google_analytics_settings[counter][pageview][title]" value="1" <?php if ($ts_google_analytics_settings['counter']['pageview']['title']) { ?>checked="checked"<?php } ?> />
							  <?php echo $text_yes; ?>
							</label>
							<label class="radio-inline">
							  <input type="radio" name="ts_google_analytics_settings[counter][pageview][title]" value="0" <?php if (!$ts_google_analytics_settings['counter']['pageview']['title']) { ?>checked="checked"<?php } ?> />
							  <?php echo $text_no; ?>
							</label>
						  </div>
						</div>
					</div>
					<div class="col-sm-12 counter-option-param">
						<div class="form-group">
						  <label class="col-sm-1"></label>
						  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_counter['pageview_path']; ?>"><?php echo $entry_counter['pageview_path']; ?></span></label>
						  <div class="col-sm-9">
							<label class="radio-inline">
							  <input type="radio" name="ts_google_analytics_settings[counter][pageview][path]" value="1" <?php if ($ts_google_analytics_settings['counter']['pageview']['path']) { ?>checked="checked"<?php } ?> />
							  <?php echo $text_yes; ?>
							</label>
							<label class="radio-inline">
							  <input type="radio" name="ts_google_analytics_settings[counter][pageview][path]" value="0" <?php if (!$ts_google_analytics_settings['counter']['pageview']['path']) { ?>checked="checked"<?php } ?> />
							  <?php echo $text_no; ?>
							</label>
						  </div>
						</div>
					</div>
					<div class="col-sm-12 counter-option-param">
						<div class="form-group">
						  <label class="col-sm-1"></label>
						  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_counter['pageview_location']; ?>"><?php echo $entry_counter['pageview_location']; ?></span></label>
						  <div class="col-sm-9">
							<label class="radio-inline">
							  <input type="radio" name="ts_google_analytics_settings[counter][pageview][location]" value="1" <?php if ($ts_google_analytics_settings['counter']['pageview']['location']) { ?>checked="checked"<?php } ?> />
							  <?php echo $text_yes; ?>
							</label>
							<label class="radio-inline">
							  <input type="radio" name="ts_google_analytics_settings[counter][pageview][location]" value="0" <?php if (!$ts_google_analytics_settings['counter']['pageview']['location']) { ?>checked="checked"<?php } ?> />
							  <?php echo $text_no; ?>
							</label>
						  </div>
						</div>
					</div>
				</div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_counter['timing']; ?>"><?php echo $entry_counter['timing']; ?></span></label>
                  <div class="col-sm-9">
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[counter][timing][status]" value="1" <?php if ($ts_google_analytics_settings['counter']['timing']['status']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_yes; ?>
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[counter][timing][status]" value="0" <?php if (!$ts_google_analytics_settings['counter']['timing']['status']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_no; ?>
                    </label>
                  </div>
                  <label class="col-sm-1 counter-option-chevron" data-params="counter-timing-params"><span <?php if ($ts_google_analytics_settings['counter']['timing']['status']) { ?>class="rotate"<?php } ?>></span></label>
                </div>
				<div class="form-group counter-option-params" id="counter-timing-params" <?php if (!$ts_google_analytics_settings['counter']['timing']['status']) { ?>style="display:none;"<?php } ?>>
					<div class="col-sm-12 counter-option-param">
						<div class="form-group required">
						  <label class="col-sm-1"></label>
						  <label class="col-sm-2 control-label" for="input-counter-timing-name"><span data-toggle="tooltip" title="<?php echo $help_counter['timing_name']; ?>"><?php echo $entry_counter['timing_name']; ?></span></label>
						  <div class="col-sm-9">
						  <input type="text" name="ts_google_analytics_settings[counter][timing][name]" value="<?php echo $ts_google_analytics_settings['counter']['timing']['name']; ?>" placeholder="<?php echo $entry_counter['timing_name']; ?>" id="input-counter-timing-name" class="form-control" />
						  <?php if ($error_timing_name) { ?>
						  <div class="text-danger"><?php echo $error_timing_name; ?></div>
						  <?php } ?>
						  </div>
						</div>
					</div>
					<div class="col-sm-12 counter-option-param">
						<div class="form-group">
						  <label class="col-sm-1"></label>
						  <label class="col-sm-2 control-label" for="input-counter-timing-category"><span data-toggle="tooltip" title="<?php echo $help_counter['timing_category']; ?>"><?php echo $entry_counter['timing_category']; ?></span></label>
						  <div class="col-sm-9">
						  <input type="text" name="ts_google_analytics_settings[counter][timing][category]" value="<?php echo $ts_google_analytics_settings['counter']['timing']['category']; ?>" placeholder="<?php echo $entry_counter['timing_category']; ?>" id="input-counter-timing-category" class="form-control" />
						  <?php if ($error_timing_category) { ?>
						  <div class="text-danger"><?php echo $error_timing_category; ?></div>
						  <?php } ?>
						  </div>
						</div>
					</div>
					<div class="col-sm-12 counter-option-param">
						<div class="form-group">
						  <label class="col-sm-1"></label>
						  <label class="col-sm-2 control-label" for="input-counter-timing-label"><span data-toggle="tooltip" title="<?php echo $help_counter['timing_label']; ?>"><?php echo $entry_counter['timing_label']; ?></span></label>
						  <div class="col-sm-9">
						  <input type="text" name="ts_google_analytics_settings[counter][timing][label]" value="<?php echo $ts_google_analytics_settings['counter']['timing']['label']; ?>" placeholder="<?php echo $entry_counter['timing_label']; ?>" id="input-counter-timing-label" class="form-control" />
						  <?php if ($error_timing_label) { ?>
						  <div class="text-danger"><?php echo $error_timing_label; ?></div>
						  <?php } ?>
						  </div>
						</div>
					</div>
				</div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_counter['link_attr']; ?>"><?php echo $entry_counter['link_attr']; ?></span></label>
                  <div class="col-sm-9">
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[counter][link_attr][status]" value="1" <?php if ($ts_google_analytics_settings['counter']['link_attr']['status']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_yes; ?>
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[counter][link_attr][status]" value="0" <?php if (!$ts_google_analytics_settings['counter']['link_attr']['status']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_no; ?>
                    </label>
                  </div>
                  <label class="col-sm-1 counter-option-chevron" data-params="counter-link-attr-params"><span <?php if ($ts_google_analytics_settings['counter']['link_attr']['status']) { ?>class="rotate"<?php } ?>></span></label>
                </div>
				<div class="form-group counter-option-params" id="counter-link-attr-params" <?php if (!$ts_google_analytics_settings['counter']['link_attr']['status']) { ?>style="display:none;"<?php } ?>>
					<div class="col-sm-12 counter-option-param">
						<div class="form-group required">
						  <label class="col-sm-1"></label>
						  <label class="col-sm-2 control-label" for="input-counter-link-attr-name"><span data-toggle="tooltip" title="<?php echo $help_counter['link_attr_name']; ?>"><?php echo $entry_counter['link_attr_name']; ?></span></label>
						  <div class="col-sm-9">
						  <input type="text" name="ts_google_analytics_settings[counter][link_attr][name]" value="<?php echo $ts_google_analytics_settings['counter']['link_attr']['name']; ?>" placeholder="<?php echo $entry_counter['link_attr_name']; ?>" id="input-counter-link-attr-name" class="form-control" />
						  <?php if ($error_link_attr_name) { ?>
						  <div class="text-danger"><?php echo $error_link_attr_name; ?></div>
						  <?php } ?>
						  </div>
						</div>
					</div>
					<div class="col-sm-12 counter-option-param">
						<div class="form-group">
						  <label class="col-sm-1"></label>
						  <label class="col-sm-2 control-label" for="input-counter-link-attr-expires"><span data-toggle="tooltip" title="<?php echo $help_counter['link_attr_expires']; ?>"><?php echo $entry_counter['link_attr_expires']; ?></span></label>
						  <div class="col-sm-9">
						  <input type="text" name="ts_google_analytics_settings[counter][link_attr][expires]" value="<?php echo $ts_google_analytics_settings['counter']['link_attr']['expires']; ?>" placeholder="<?php echo $entry_counter['link_attr_expires']; ?>" id="input-counter-link-attr-expires" class="form-control" />
						  <?php if ($error_link_attr_expires) { ?>
						  <div class="text-danger"><?php echo $error_link_attr_expires; ?></div>
						  <?php } ?>
						  </div>
						</div>
					</div>
				</div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_counter['linker']; ?>"><?php echo $entry_counter['linker']; ?></span></label>
                  <div class="col-sm-9">
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[counter][linker][status]" value="1" <?php if ($ts_google_analytics_settings['counter']['linker']['status']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_yes; ?>
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[counter][linker][status]" value="0" <?php if (!$ts_google_analytics_settings['counter']['linker']['status']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_no; ?>
                    </label>
                  </div>
                  <label class="col-sm-1 counter-option-chevron" data-params="counter-linker-params"><span <?php if ($ts_google_analytics_settings['counter']['linker']['status']) { ?>class="rotate"<?php } ?>></span></label>
                </div>
				<div class="form-group counter-option-params" id="counter-linker-params" <?php if (!$ts_google_analytics_settings['counter']['linker']['status']) { ?>style="display:none;"<?php } ?>>
					<div class="col-sm-12 counter-option-param">
						<div class="form-group">
						  <label class="col-sm-1"></label>
						  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_counter['linker_incoming']; ?>"><?php echo $entry_counter['linker_incoming']; ?></span></label>
						  <div class="col-sm-9">
							<label class="radio-inline">
							  <input type="radio" name="ts_google_analytics_settings[counter][linker][incoming]" value="1" <?php if ($ts_google_analytics_settings['counter']['linker']['incoming']) { ?>checked="checked"<?php } ?> />
							  <?php echo $text_yes; ?>
							</label>
							<label class="radio-inline">
							  <input type="radio" name="ts_google_analytics_settings[counter][linker][incoming]" value="0" <?php if (!$ts_google_analytics_settings['counter']['linker']['incoming']) { ?>checked="checked"<?php } ?> />
							  <?php echo $text_no; ?>
							</label>
						  </div>
						</div>
					</div>
					<div class="col-sm-12 counter-option-param" id="counter-linker-domains">
						<?php foreach ($ts_google_analytics_settings['counter']['linker']['domains'] as $did => $domain) { ?>
						<div class="form-group" id="counter-linker-domain-<?php echo $did; ?>">
						  <label class="col-sm-1"></label>
						  <?php if ($did == 0) { ?>
						  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_counter['linker_domains']; ?>"><?php echo $entry_counter['linker_domains']; ?></span></label>
						  <?php } else { ?>
						  <label class="col-sm-2"></label>
						  <?php } ?>
						  <div class="col-sm-8">
						  <input type="text" name="ts_google_analytics_settings[counter][linker][domains][]" value="<?php echo $domain; ?>" placeholder="<?php echo $entry_counter['linker_domain']; ?>" id="input-counter-linker-domains-<?php echo $did; ?>" class="form-control" />
						  <?php if (isset($error_linker_domains[$did]) && $error_linker_domains[$did]) { ?>
						  <div class="text-danger"><?php echo $error_linker_domains[$did]; ?></div>
						  <?php } ?>
						  </div>
						  <?php if ($did == 0) { ?>
						  <label class="col-sm-1"><button type="button" onclick="addLinkerDomain();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></label>
						  <?php } else { ?>
						  <label class="col-sm-1"><button type="button" onclick="removeLinkerDomain(<?php echo $did; ?>);" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></label>
						  <?php } ?>
						</div>
						<?php } ?>
					</div>
				</div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_counter['ad_features']; ?>"><?php echo $entry_counter['ad_features']; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[counter][ad_features]" value="1" <?php if ($ts_google_analytics_settings['counter']['ad_features']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_yes; ?>
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[counter][ad_features]" value="0" <?php if (!$ts_google_analytics_settings['counter']['ad_features']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_no; ?>
                    </label>
                  </div>
                </div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-counter-country"><span data-toggle="tooltip" title="<?php echo $help_counter['country']; ?>"><?php echo $entry_counter['country']; ?></span></label>
				  <div class="col-sm-10">
					<select name="ts_google_analytics_settings[counter][country]" id="input-counter-country" class="form-control">
					  <?php foreach ($countries as $country) { ?>
					  <option value="<?php echo $country['iso_code_2']; ?>" <?php if ($country['iso_code_2'] == $ts_google_analytics_settings['counter']['country']) { ?>selected="selected"<?php } ?>><?php echo $country['iso_code_2']; ?> - <?php echo $country['name']; ?></option>
					  <?php } ?>
					</select>
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-counter-currency"><span data-toggle="tooltip" title="<?php echo $help_counter['currency']; ?>"><?php echo $entry_counter['currency']; ?></span></label>
				  <div class="col-sm-10">
					<select name="ts_google_analytics_settings[counter][currency]" id="input-counter-currency" class="form-control">
					  <?php foreach ($currencies as $currency) { ?>
					  <option value="<?php echo $currency; ?>" <?php if ($currency == $ts_google_analytics_settings['counter']['currency']) { ?>selected="selected"<?php } ?>><?php echo $currency; ?></option>
					  <?php } ?>
					</select>
				  </div>
				</div>
				
			  </fieldset>
			  <br>
			  
			</div>

			
			<div class="tab-pane" id="tab-userParams">
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-userParams-status"><span data-toggle="tooltip" title="<?php echo $help_userParams['status']; ?>"><?php echo $entry_userParams['status']; ?></span></label>
				  <div class="col-sm-10">
					<select name="ts_google_analytics_settings[userParams][status]" id="input-userParams-status" class="form-control">
					  <?php if ($ts_google_analytics_settings['userParams']['status']) { ?>
					  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					  <option value="0"><?php echo $text_disabled; ?></option>
					  <?php } else { ?>
					  <option value="1"><?php echo $text_enabled; ?></option>
					  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					  <?php } ?>
					</select>
				  </div>
				</div>
				<br>
				
              <fieldset>
                <legend><?php echo $text_title['userCookies']; ?></legend>
				
				<div class="form-group required">
				  <label class="col-sm-2 control-label" for="input-counter-userCookies-name"><span data-toggle="tooltip" title="<?php echo $help_counter['cookie_name']; ?>"><?php echo $entry_counter['cookie_name']; ?></span></label>
				  <div class="col-sm-10">
				  <input type="text" name="ts_google_analytics_settings[counter][userCookies][name]" value="<?php echo $ts_google_analytics_settings['counter']['userCookies']['name']; ?>" placeholder="<?php echo $entry_counter['cookie_name']; ?>" id="input-counter-userCookies-name" class="form-control" />
				  <?php if ($error_cookie_name) { ?>
				  <div class="text-danger"><?php echo $error_cookie_name; ?></div>
				  <?php } ?>
				  </div>
				</div>
				<div class="form-group required">
				  <label class="col-sm-2 control-label" for="input-counter-userCookies-domain"><span data-toggle="tooltip" title="<?php echo $help_counter['cookie_domain']; ?>"><?php echo $entry_counter['cookie_domain']; ?></span></label>
				  <div class="col-sm-10">
				  <input type="text" name="ts_google_analytics_settings[counter][userCookies][domain]" value="<?php echo $ts_google_analytics_settings['counter']['userCookies']['domain']; ?>" placeholder="<?php echo $entry_counter['cookie_domain']; ?>" id="input-counter-userCookies-domain" class="form-control" />
				  <?php if ($error_cookie_domain) { ?>
				  <div class="text-danger"><?php echo $error_cookie_domain; ?></div>
				  <?php } ?>
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-counter-userCookies-expires"><span data-toggle="tooltip" title="<?php echo $help_counter['cookie_expires']; ?>"><?php echo $entry_counter['cookie_expires']; ?></span></label>
				  <div class="col-sm-10">
				  <input type="text" name="ts_google_analytics_settings[counter][userCookies][expires]" value="<?php echo $ts_google_analytics_settings['counter']['userCookies']['expires']; ?>" placeholder="<?php echo $entry_counter['cookie_expires']; ?>" id="input-counter-userCookies-expires" class="form-control" />
				  <?php if ($error_cookie_expires) { ?>
				  <div class="text-danger"><?php echo $error_cookie_expires; ?></div>
				  <?php } ?>
				  </div>
				</div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_counter['cookie_update']; ?>"><?php echo $entry_counter['cookie_update']; ?></span></label>
                  <div class="col-sm-10">
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[counter][userCookies][update]" value="1" <?php if ($ts_google_analytics_settings['counter']['userCookies']['update']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_yes; ?>
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[counter][userCookies][update]" value="0" <?php if (!$ts_google_analytics_settings['counter']['userCookies']['update']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_no; ?>
                    </label>
                  </div>
                </div>
			
              </fieldset>
			  <br>
			  <br>
				
              <fieldset>
                <legend><?php echo $text_title['userParams']; ?></legend>
				
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_userParams['userId']; ?>"><?php echo $entry_userParams['userId']; ?></span></label>
                  <div class="col-sm-6"><br>&mdash;</div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_id']; ?>" data-copy="dimension1"></i> dimension1
                  </div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_name']; ?>" data-copy="userId"></i> userId
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_userParams['type']; ?>"><?php echo $entry_userParams['type']; ?></span></label>
                  <div class="col-sm-6">
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[userParams][type]" value="1" <?php if ($ts_google_analytics_settings['userParams']['type']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_yes; ?>
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[userParams][type]" value="0" <?php if (!$ts_google_analytics_settings['userParams']['type']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_no; ?>
                    </label>
                  </div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_id']; ?>" data-copy="dimension2"></i> dimension2
                  </div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_name']; ?>" data-copy="type"></i> type
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_userParams['group']; ?>"><?php echo $entry_userParams['group']; ?></span></label>
                  <div class="col-sm-6">
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[userParams][group]" value="1" <?php if ($ts_google_analytics_settings['userParams']['group']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_yes; ?>
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[userParams][group]" value="0" <?php if (!$ts_google_analytics_settings['userParams']['group']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_no; ?>
                    </label>
                  </div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_id']; ?>" data-copy="dimension3"></i> dimension3
                  </div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_name']; ?>" data-copy="group"></i> group
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_userParams['date_added']; ?>"><?php echo $entry_userParams['date_added']; ?></span></label>
                  <div class="col-sm-6">
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[userParams][date_added]" value="1" <?php if ($ts_google_analytics_settings['userParams']['date_added']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_yes; ?>
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[userParams][date_added]" value="0" <?php if (!$ts_google_analytics_settings['userParams']['date_added']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_no; ?>
                    </label>
                  </div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_id']; ?>" data-copy="dimension4"></i> dimension4
                  </div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_name']; ?>" data-copy="date_added"></i> date_added
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_userParams['safe']; ?>"><?php echo $entry_userParams['safe']; ?></span></label>
                  <div class="col-sm-6">
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[userParams][safe]" value="1" <?php if ($ts_google_analytics_settings['userParams']['safe']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_yes; ?>
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[userParams][safe]" value="0" <?php if (!$ts_google_analytics_settings['userParams']['safe']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_no; ?>
                    </label>
                  </div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_id']; ?>" data-copy="dimension5"></i> dimension5
                  </div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_name']; ?>" data-copy="safe"></i> safe
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_userParams['newsletter']; ?>"><?php echo $entry_userParams['newsletter']; ?></span></label>
                  <div class="col-sm-6">
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[userParams][newsletter]" value="1" <?php if ($ts_google_analytics_settings['userParams']['newsletter']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_yes; ?>
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[userParams][newsletter]" value="0" <?php if (!$ts_google_analytics_settings['userParams']['newsletter']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_no; ?>
                    </label>
                  </div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_id']; ?>" data-copy="dimension6"></i> dimension6
                  </div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_name']; ?>" data-copy="newsletter"></i> newsletter
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_userParams['country']; ?>"><?php echo $entry_userParams['country']; ?></span></label>
                  <div class="col-sm-6">
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[userParams][country]" value="1" <?php if ($ts_google_analytics_settings['userParams']['country']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_yes; ?>
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[userParams][country]" value="0" <?php if (!$ts_google_analytics_settings['userParams']['country']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_no; ?>
                    </label>
                  </div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_id']; ?>" data-copy="dimension7"></i> dimension7
                  </div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_name']; ?>" data-copy="country"></i> country
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_userParams['zone']; ?>"><?php echo $entry_userParams['zone']; ?></span></label>
                  <div class="col-sm-6">
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[userParams][zone]" value="1" <?php if ($ts_google_analytics_settings['userParams']['zone']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_yes; ?>
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[userParams][zone]" value="0" <?php if (!$ts_google_analytics_settings['userParams']['zone']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_no; ?>
                    </label>
                  </div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_id']; ?>" data-copy="dimension8"></i> dimension8
                  </div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_name']; ?>" data-copy="zone"></i> zone
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_userParams['city']; ?>"><?php echo $entry_userParams['city']; ?></span></label>
                  <div class="col-sm-6">
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[userParams][city]" value="1" <?php if ($ts_google_analytics_settings['userParams']['city']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_yes; ?>
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[userParams][city]" value="0" <?php if (!$ts_google_analytics_settings['userParams']['city']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_no; ?>
                    </label>
                  </div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_id']; ?>" data-copy="dimension9"></i> dimension9
                  </div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_name']; ?>" data-copy="city"></i> city
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_userParams['postcode']; ?>"><?php echo $entry_userParams['postcode']; ?></span></label>
                  <div class="col-sm-6">
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[userParams][postcode]" value="1" <?php if ($ts_google_analytics_settings['userParams']['postcode']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_yes; ?>
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[userParams][postcode]" value="0" <?php if (!$ts_google_analytics_settings['userParams']['postcode']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_no; ?>
                    </label>
                  </div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_id']; ?>" data-copy="dimension10"></i> dimension10
                  </div>
                  <div class="col-sm-2 copy-userParams">
					<i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_name']; ?>" data-copy="postcode"></i> postcode
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_userParams['custom_field']; ?>"><?php echo $entry_userParams['custom_field']; ?></span></label>
                  <div class="col-sm-10">
					<div class="well well-sm">
					  <table class="table">
						<?php foreach ($custom_fields as $custom_field) { ?>
						<tr>
						  <td class="checkbox">
							<label>
							  <input type="checkbox" name="ts_google_analytics_settings[userParams][custom_fields][]" value="<?php echo $custom_field['custom_field_id']; ?>" <?php if (isset($ts_google_analytics_settings['userParams']['custom_fields']) && in_array($custom_field['custom_field_id'], $ts_google_analytics_settings['userParams']['custom_fields'])) { ?>checked="checked"<?php } ?> />
							  <?php echo $custom_field['name']; ?>
							</label>
						  </td>
						  <td><?php echo $custom_field['type']; ?></td>
						  <td><?php echo $custom_field['status'] ? $text_enabled : $text_disabled; ?></td>
						  <td><i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_id']; ?>" data-copy="<?php echo $custom_field['param_id']; ?>"></i> <?php echo $custom_field['param_id']; ?></td>
						  <td><i class="fa fa-files-o copy-to-clipboard" data-toggle="tooltip" title="<?php echo $text_copy_to_clipboard['param_name']; ?>" data-copy="<?php echo $custom_field['param_name']; ?>"></i> <?php echo $custom_field['param_name']; ?></td>
						</tr>
						<?php } ?>
					  </table>
					</div>
					<a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / 
					<a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a>
                  </div>
                </div>
				
			  </fieldset>
			  <br>				
			
			</div>
			
			
			<div class="tab-pane" id="tab-ecommerce">
			
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-ecommerce-status"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['status']; ?>"><?php echo $entry_ecommerce['status']; ?></span></label>
				  <div class="col-sm-10">
					<select name="ts_google_analytics_settings[ecommerce][status]" id="input-ecommerce-status" class="form-control">
					  <?php if ($ts_google_analytics_settings['ecommerce']['status']) { ?>
					  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					  <option value="0"><?php echo $text_disabled; ?></option>
					  <?php } else { ?>
					  <option value="1"><?php echo $text_enabled; ?></option>
					  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					  <?php } ?>
					</select>
				  </div>
				</div>
				<br>
				
              <fieldset>
                <legend><?php echo $text_title['ecommerce_actions']; ?></legend>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['view']; ?>"><?php echo $entry_ecommerce['view']; ?></span></label>
				  <div class="col-sm-9">
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionType][view]" value="1" <?php if ($ts_google_analytics_settings['ecommerce']['actionType']['view']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_yes; ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionType][view]" value="0" <?php if (!$ts_google_analytics_settings['ecommerce']['actionType']['view']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_no; ?>
					</label>
				  </div>
                </div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['click']; ?>"><?php echo $entry_ecommerce['click']; ?></span></label>
				  <div class="col-sm-9">
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionType][click]" value="1" <?php if ($ts_google_analytics_settings['ecommerce']['actionType']['click']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_yes; ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionType][click]" value="0" <?php if (!$ts_google_analytics_settings['ecommerce']['actionType']['click']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_no; ?>
					</label>
				  </div>
                </div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['detail']; ?>"><?php echo $entry_ecommerce['detail']; ?></span></label>
				  <div class="col-sm-10">
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionType][detail]" value="1" <?php if ($ts_google_analytics_settings['ecommerce']['actionType']['detail']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_yes; ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionType][detail]" value="0" <?php if (!$ts_google_analytics_settings['ecommerce']['actionType']['detail']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_no; ?>
					</label>
				  </div>
                </div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['add']; ?>"><?php echo $entry_ecommerce['add']; ?></span></label>
				  <div class="col-sm-10">
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionType][add]" value="1" <?php if ($ts_google_analytics_settings['ecommerce']['actionType']['add']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_yes; ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionType][add]" value="0" <?php if (!$ts_google_analytics_settings['ecommerce']['actionType']['add']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_no; ?>
					</label>
				  </div>
                </div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['remove']; ?>"><?php echo $entry_ecommerce['remove']; ?></span></label>
				  <div class="col-sm-10">
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionType][remove]" value="1" <?php if ($ts_google_analytics_settings['ecommerce']['actionType']['remove']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_yes; ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionType][remove]" value="0" <?php if (!$ts_google_analytics_settings['ecommerce']['actionType']['remove']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_no; ?>
					</label>
				  </div>
                </div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['checkout']; ?>"><?php echo $entry_ecommerce['checkout']; ?></span></label>
				  <div class="col-sm-10">
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionType][checkout]" value="1" <?php if ($ts_google_analytics_settings['ecommerce']['actionType']['checkout']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_yes; ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionType][checkout]" value="0" <?php if (!$ts_google_analytics_settings['ecommerce']['actionType']['checkout']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_no; ?>
					</label>
				  </div>
                </div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['purchase']; ?>"><?php echo $entry_ecommerce['purchase']; ?></span></label>
				  <div class="col-sm-10">
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionType][purchase]" value="1" <?php if ($ts_google_analytics_settings['ecommerce']['actionType']['purchase']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_yes; ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionType][purchase]" value="0" <?php if (!$ts_google_analytics_settings['ecommerce']['actionType']['purchase']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_no; ?>
					</label>
				  </div>
                </div>
				
			  </fieldset>
			  <br>
			  <br>
				
              <fieldset>
                <legend><?php echo $text_title['ecommerce_products']; ?></legend>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-ecommerce-brand"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['brand']; ?>"><?php echo $entry_ecommerce['brand']; ?></span></label>
				  <div class="col-sm-10">
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][products][brand]" value="1" <?php if ($ts_google_analytics_settings['ecommerce']['products']['brand']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_yes; ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][products][brand]" value="0" <?php if (!$ts_google_analytics_settings['ecommerce']['products']['brand']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_no; ?>
					</label>
				  </div>
                </div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-ecommerce-category"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['category']; ?>"><?php echo $entry_ecommerce['category']; ?></span></label>
				  <div class="col-sm-10">
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][products][category]" value="1" <?php if ($ts_google_analytics_settings['ecommerce']['products']['category']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_yes; ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][products][category]" value="0" <?php if (!$ts_google_analytics_settings['ecommerce']['products']['category']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_no; ?>
					</label>
				  </div>
                </div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-ecommerce-list-name"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['list_name']; ?>"><?php echo $entry_ecommerce['list_name']; ?></span></label>
				  <div class="col-sm-10">
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][products][list_name]" value="1" <?php if ($ts_google_analytics_settings['ecommerce']['products']['list_name']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_yes; ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][products][list_name]" value="0" <?php if (!$ts_google_analytics_settings['ecommerce']['products']['list_name']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_no; ?>
					</label>
				  </div>
                </div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-ecommerce-position"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['position']; ?>"><?php echo $entry_ecommerce['position']; ?></span></label>
				  <div class="col-sm-10">
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][products][position]" value="1" <?php if ($ts_google_analytics_settings['ecommerce']['products']['position']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_yes; ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][products][position]" value="0" <?php if (!$ts_google_analytics_settings['ecommerce']['products']['position']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_no; ?>
					</label>
				  </div>
                </div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-ecommerce-price"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['price']; ?>"><?php echo $entry_ecommerce['price']; ?></span></label>
				  <div class="col-sm-10">
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][products][price]" value="1" <?php if ($ts_google_analytics_settings['ecommerce']['products']['price']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_yes; ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][products][price]" value="0" <?php if (!$ts_google_analytics_settings['ecommerce']['products']['price']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_no; ?>
					</label>
				  </div>
                </div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-ecommerce-quantity"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['quantity']; ?>"><?php echo $entry_ecommerce['quantity']; ?></span></label>
				  <div class="col-sm-10">
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][products][quantity]" value="1" <?php if ($ts_google_analytics_settings['ecommerce']['products']['quantity']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_yes; ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][products][quantity]" value="0" <?php if (!$ts_google_analytics_settings['ecommerce']['products']['quantity']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_no; ?>
					</label>
				  </div>
                </div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-ecommerce-variant"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['variant']; ?>"><?php echo $entry_ecommerce['variant']; ?></span></label>
				  <div class="col-sm-10">
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][products][variant]" value="1" <?php if ($ts_google_analytics_settings['ecommerce']['products']['variant']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_yes; ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][products][variant]" value="0" <?php if (!$ts_google_analytics_settings['ecommerce']['products']['variant']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_no; ?>
					</label>
				  </div>
                </div>
				
			  </fieldset>
			  <br>
			  <br>
				
              <fieldset>
                <legend><?php echo $text_title['ecommerce_purchase']; ?></legend>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-ecommerce-affiliation"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['affiliation']; ?>"><?php echo $entry_ecommerce['affiliation']; ?></span></label>
				  <div class="col-sm-10">
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionField][affiliation]" value="1" <?php if ($ts_google_analytics_settings['ecommerce']['actionField']['affiliation']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_yes; ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionField][affiliation]" value="0" <?php if (!$ts_google_analytics_settings['ecommerce']['actionField']['affiliation']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_no; ?>
					</label>
				  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['revenue']; ?>"><?php echo $entry_ecommerce['revenue']; ?></span></label>
                  <div class="col-sm-9">
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[ecommerce][actionField][revenue][status]" value="1" <?php if ($ts_google_analytics_settings['ecommerce']['actionField']['revenue']['status']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_yes; ?>
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="ts_google_analytics_settings[ecommerce][actionField][revenue][status]" value="0" <?php if (!$ts_google_analytics_settings['ecommerce']['actionField']['revenue']['status']) { ?>checked="checked"<?php } ?> />
                      <?php echo $text_no; ?>
                    </label>
                  </div>
                  <label class="col-sm-1 ecommerce-option-chevron" data-params="ecommerce-revenue-params"><span <?php if ($ts_google_analytics_settings['ecommerce']['actionField']['revenue']['status']) { ?>class="rotate"<?php } ?>></span></label>
                </div>
				<div class="form-group ecommerce-option-params" id="ecommerce-revenue-params" <?php if (!$ts_google_analytics_settings['ecommerce']['actionField']['revenue']['status']) { ?>style="display:none;"<?php } ?>>
					<div class="col-sm-12 ecommerce-option-param">
						<div class="form-group">
						  <label class="col-sm-1"></label>
						  <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['revenue_codes']; ?>"><?php echo $entry_ecommerce['revenue_codes']; ?></span></label>
						  <div class="col-sm-9">
							<div class="well well-sm">
							  <table class="table">
								<?php foreach ($total_codes as $total_code) { ?>
								<tr>
								  <td class="checkbox">
									<label>
									  <input type="checkbox" name="ts_google_analytics_settings[ecommerce][actionField][revenue][total_codes][]" value="<?php echo $total_code['code']; ?>" <?php if (isset($ts_google_analytics_settings['ecommerce']['actionField']['revenue']['codes']) && in_array($total_code['code'], $ts_google_analytics_settings['ecommerce']['actionField']['revenue']['codes'])) { ?>checked="checked"<?php } ?> />
									  <?php echo $total_code['name']; ?>
									</label>
								  </td>
								</tr>
								<?php } ?>
							  </table>
							</div>
							<a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / 
							<a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a>
						  </div>
						</div>
					</div>
					<div class="col-sm-12 ecommerce-option-param">
						<div class="form-group">
						  <label class="col-sm-1"></label>
						  <label class="col-sm-2 control-label" for="input-ecommerce-revenue-tax"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['revenue_tax']; ?>"><?php echo $entry_ecommerce['revenue_tax']; ?></span></label>
						  <div class="col-sm-9">
							<div class="input-group">
							  <span class="input-group-addon"><b>%</b></span>
							  <input type="text" name="ts_google_analytics_settings[ecommerce][actionField][revenue][tax]" value="<?php echo $ts_google_analytics_settings['ecommerce']['actionField']['revenue']['tax']; ?>" placeholder="<?php echo $entry_ecommerce['revenue_tax']; ?>" id="input-ecommerce-revenue-tax" class="form-control" />
							</div>
							<?php if ($error_ecommerce_revenue_tax) { ?>
							<div class="text-danger"><?php echo $error_ecommerce_revenue_tax; ?></div>
							<?php } ?>
						  </div>
						</div>
					</div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-ecommerce-tax"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['tax']; ?>"><?php echo $entry_ecommerce['tax']; ?></span></label>
				  <div class="col-sm-10">
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionField][tax]" value="1" <?php if ($ts_google_analytics_settings['ecommerce']['actionField']['tax']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_yes; ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionField][tax]" value="0" <?php if (!$ts_google_analytics_settings['ecommerce']['actionField']['tax']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_no; ?>
					</label>
				  </div>
                </div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-ecommerce-shipping"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['shipping']; ?>"><?php echo $entry_ecommerce['shipping']; ?></span></label>
				  <div class="col-sm-10">
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionField][shipping]" value="1" <?php if ($ts_google_analytics_settings['ecommerce']['actionField']['shipping']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_yes; ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionField][shipping]" value="0" <?php if (!$ts_google_analytics_settings['ecommerce']['actionField']['shipping']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_no; ?>
					</label>
				  </div>
                </div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-ecommerce-coupon"><span data-toggle="tooltip" title="<?php echo $help_ecommerce['coupon']; ?>"><?php echo $entry_ecommerce['coupon']; ?></span></label>
				  <div class="col-sm-10">
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionField][coupon]" value="1" <?php if ($ts_google_analytics_settings['ecommerce']['actionField']['coupon']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_yes; ?>
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ts_google_analytics_settings[ecommerce][actionField][coupon]" value="0" <?php if (!$ts_google_analytics_settings['ecommerce']['actionField']['coupon']) { ?>checked="checked"<?php } ?> />
					  <?php echo $text_no; ?>
					</label>
				  </div>
                </div>

				
			  </fieldset>
			  <br>
				
 			</div>
			
			
			<div class="tab-pane" id="tab-goals">
			
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-goal-status"><span data-toggle="tooltip" title="<?php echo $help_goal['status']; ?>"><?php echo $entry_goal['status']; ?></span></label>
				  <div class="col-sm-10">
					<select name="ts_google_analytics_settings[goal][status]" id="input-goal-status" class="form-control">
					  <?php if ($ts_google_analytics_settings['goal']['status']) { ?>
					  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					  <option value="0"><?php echo $text_disabled; ?></option>
					  <?php } else { ?>
					  <option value="1"><?php echo $text_enabled; ?></option>
					  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					  <?php } ?>
					</select>
				  </div>
				</div>
				<br>
				
              <fieldset>
                <legend><?php echo $text_title['goal_action']; ?></legend>
				<div id="goalsList"></div>
              </fieldset>
			  <br>
			  
			</div>
			
			
			<div class="tab-pane" id="tab-help">
				<div class="form-group">
					<div class="col-sm-12">
						<? echo $text_help; ?>
					</div>
				</div>
				<div class="form-group text-left">
					<div class="col-sm-12">
						<? echo $text_author; ?>
					</div>
				</div>
			</div>
	  
		</div>
		</form>
	  </div>
	</div>
  </div>
</div>
<div class="modal fade" id="modal-goal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Title</h4>
      </div>
      <div class="modal-body form-horizontal">
		<fieldset>
			<legend><?php echo $text_goal_modal['goal_title']; ?></legend>
			<div class="form-group">
				<label class="col-sm-4 control-label">
					<span data-toggle="tooltip" title="<?php echo $help_goal['label']; ?>"><?php echo $entry_goal['label']; ?></span>
				</label>
				<div class="col-sm-8">
					<input type="text" name="label" id="goal_label" value="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label">
					<span data-toggle="tooltip" title="<?php echo $help_goal['category']; ?>"><?php echo $entry_goal['category']; ?></span>
				</label>
				<div class="col-sm-8">
					<input type="text" name="category" id="goal_category" value="" class="form-control">
				</div>
			</div>
			<div class="form-group required">
				<label class="col-sm-4 control-label">
					<span data-toggle="tooltip" title="<?php echo $help_goal['action']; ?>"><?php echo $entry_goal['action']; ?></span>
				</label>
				<div class="col-sm-8">
					<input type="text" name="action" id="goal_action" value="" class="form-control">
				</div>
			</div>
			<div class="form-group required">
				<label class="col-sm-4 control-label">
					<span data-toggle="tooltip" title="<?php echo $help_goal['element']; ?>"><?php echo $entry_goal['element']; ?></span>
				</label>
				<div class="col-sm-8">
					<input type="text" name="element" id="goal_element" value="" class="form-control">
				</div>
			</div>
			<div class="form-group required">
				<label class="col-sm-4 control-label">
					<span data-toggle="tooltip" title="<?php echo $help_goal['event']; ?>"><?php echo $entry_goal['event']; ?></span>
				</label>
				<div class="col-sm-8">
					<select name="event" id="goal_event" class="form-control">
						<optgroup label="<?php echo $text_goal_event['mouse']; ?>">
							<option value="click">click</option>
							<option value="dblclick">dblclick</option>
							<option value="mousedown">mousedown</option>
							<option value="mouseup">mouseup</option>
							<option value="mouseout">mouseout</option>
							<option value="mousemove">mousemove</option>
							<option value="mouseover">mouseover</option>
							<option value="mousewheel">mousewheel</option>
							<option value="contextmenu">contextmenu</option>
						</optgroup>
						<optgroup label="<?php echo $text_goal_event['touch']; ?>">
							<option value="touchstart">touchstart</option>
							<option value="touchmove">touchmove</option>
							<option value="touchend">touchend</option>
							<option value="touchcancel">touchcancel</option>
						</optgroup>
						<optgroup label="<?php echo $text_goal_event['keyboard']; ?>">
							<option value="keypress">keypress</option>
							<option value="keydown">keydown</option>
							<option value="keyup">keyup</option>
						</optgroup>
						<optgroup label="<?php echo $text_goal_event['form']; ?>">
							<option value="submit">submit</option>
							<option value="change">change</option>
							<option value="focus">focus</option>
							<option value="blur">blur</option>
						</optgroup>
						<optgroup label="<?php echo $text_goal_event['window']; ?>">
							<option value="load">load</option>
							<option value="unload">unload</option>
							<option value="scroll">scroll</option>
							<option value="resize">resize</option>
							<option value="hashchange">hashchange</option>
						</optgroup>
					</select>
				</div>
			</div>
		</fieldset>
		<fieldset>
			<legend><?php echo $text_goal_modal['value_title']; ?></legend>
			<div class="form-group">
				<label class="col-sm-4 control-label">
					<span data-toggle="tooltip" title="<?php echo $help_goal['value']; ?>"><?php echo $entry_goal['value']; ?></span>
				</label>
				<div class="col-sm-8">
					<input type="text" name="value" id="goal_value" value="" class="form-control">
				</div>
			</div>
		</fieldset>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="goal_submit" data-goal-id="" data-goal-action="">Button</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
	<?php if (isset($token)) { ?>
	var token = '<?php echo $token; ?>';
	var user_token = '';
	<?php } else { ?>
	var token = '';
	var user_token = '<?php echo $user_token; ?>';
	<?php } ?>
	var modal_goal_text = {
		title_add: '<?php echo $text_goal_modal['title_add']; ?>',
		title_edit: '<?php echo $text_goal_modal['title_edit']; ?>',
		button_add: '<?php echo $button_add; ?>',
		button_edit: '<?php echo $button_save; ?>',
	};
	
	var linker_domain_row = <?php echo count($ts_google_analytics_settings['counter']['linker']['domains']); ?>;

	function addLinkerDomain() {
		if (linker_domain_row == 10) {
			return false;
		}
		html  = '<div class="form-group" id="counter-linker-domain-' + linker_domain_row + '">';
		html += '  <label class="col-sm-1"></label>';
		html += '  <label class="col-sm-2"></label>';
		html += '  <div class="col-sm-8">';
		html += '  <input type="text" name="ts_google_analytics_settings[counter][linker][domains][]" value="" placeholder="<?php echo $entry_counter['linker_domain']; ?>" id="input-counter-linker-domains-' + linker_domain_row + '" class="form-control" />';
		html += '  </div>';
		html += '  <label class="col-sm-1"><button type="button" onclick="removeLinkerDomain(' + linker_domain_row + ')" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></label>';
		html += '</div>';
		
		$('#counter-linker-domains').append(html);
		
		linker_domain_row++;
	}
	function removeLinkerDomain(domain_id) {
		$('#counter-linker-domain-' + domain_id).remove();
		linker_domain_row--; 
	}
	
	$('.counter-option-chevron, .ecommerce-option-chevron').closest('div.form-group').find('input[type=radio]').change(function() {
		var chevron = $(this).closest('div.form-group').find('.counter-option-chevron, .ecommerce-option-chevron');
		if (parseInt($(this).val()) > 0) {
			$('#' + chevron.data('params') ).slideDown(250);
			chevron.find('span').addClass('rotate');
		} else {
			$('#' + chevron.data('params') ).slideUp(250);
			chevron.find('span').removeClass('rotate');
		}
	});
//--></script>
<style>
	#counter-linker-domains .btn {
		width: 100%;
	}
	#counter-linker-domains .form-group+.form-group {
		border: none;
		padding-top: 0;
	}
	.counter-option-chevron,
	.ecommerce-option-chevron {
		height: 44px;
		margin: 0;
	}
	.counter-option-chevron span,
	.ecommerce-option-chevron span {
		display: inline-block;
		width: 100%;
	}
	.counter-option-chevron span:before,
	.ecommerce-option-chevron span:before {
		display: block;
		width: 100%;
		font-family: "FontAwesome";
		content: '\f105';
		font-size: 36px;
		line-height: 42px;
		text-align: center;
		color: #bbb;
		-webkit-transition: all 0.25s ease 0s;
		-moz-transition: all 0.25s ease 0s;
		-o-transition: all 0.25s ease 0s;
		transition: all 0.25s ease 0s;
	}
	.counter-option-chevron span.rotate:before,
	.ecommerce-option-chevron span.rotate:before {
		-webkit-transform: rotate(90deg);
		-moz-transform: rotate(90deg);
		-o-transform: rotate(90deg);
		transform: rotate(90deg);
	}
	.counter-option-params,
	.ecommerce-option-params {
		background: linear-gradient(to bottom, #fff, #fbfbfb);
	}
	#tab-userParams .copy-userParams {
		padding-top: 9px;
	}
	#tab-userParams .copy-to-clipboard {
		color: #1e91cf;
		cursor: pointer;
		padding: 0 5px;
	}
	#tab-userParams .well {
		height: 205px;
		margin-bottom: 0;
		overflow-y: scroll;
	}
	#tab-userParams .well .table {
		margin-bottom: 0;
	}
	#tab-userParams .well .table tr td {
		display: table-cell;
	}
	#tab-userParams .well .table tr td:nth-child(2),
	#tab-userParams .well .table tr td:nth-child(3) {
		width: 150px;
	}    
	#tab-userParams .well .table tr td:nth-child(4) {
		width: 175px;
	}    
	#tab-userParams .well .table tr td:nth-child(5) {
		width: 130px;
	}    
	#tab-userParams .well .table tr td input[type="checkbox"] {
		vertical-align: top;
	}
	.modal .modal-title,
	.modal .modal-footer button {
		font-weight: bold;
	}
	.modal .modal-body fieldset legend {
		margin-bottom: 0;
		padding-top: 10px;
	}
	.modal .modal-body fieldset:first-child legend {
		padding-top: 0;
	}
	.modal .modal-body .form-group {
		padding-top: 10px;
		padding-bottom: 10px;
	}
	#goalsList .table tr td:nth-child(5) > span,
	#goalsList .table tr td:nth-child(6) > span {
		width: 100px;
	}
	#goalsList .table tr td:nth-child(7) {
		width: 100px;
	}
	#goalsList .table tr td > span {
		width: 150px;
		display: inline-block;
		white-space: nowrap;
		text-overflow: ellipsis;
		overflow: hidden;
	}
	#goalsList .table tr td .copy-to-clipboard {
		color: #1e91cf;
		cursor: pointer;
		padding: 0 5px;
	}
	#goalsList .table tr td .goals-results {
		float: right;
		width: auto;
		margin: 10px;
	}
	#goalsList .table tr td nav {
		float: left;
	}
</style>
<?php echo $footer; ?>