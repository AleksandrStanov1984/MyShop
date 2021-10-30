<?php
class ControllerInformationInformation extends Controller {
	public function index() {

        if ($this->config->get('ts_google_analytics_status') && $this->config->get('ts_google_analytics_settings')['ecommerce']['status'] && $this->config->get('ts_google_analytics_settings')['ecommerce']['actionType']['view']) {
            if (isset($this->session->data['ts_ga_ecommerce_view']) && !is_null($this->session->data['ts_ga_ecommerce_view'])) {

                $this->load->model('catalog/product');

                $product_list = array();
                foreach ($this->session->data['ts_ga_ecommerce_view'] as $pid => $product_view) {

                    $product_list[$pid] = $this->model_catalog_product->getProduct($product_view['product_id']);
                    if ($product_list[$pid]) {
                        $product_list[$pid] = array_merge($product_list[$pid], $product_view);
                    }
                }
                unset($this->session->data['ts_ga_ecommerce_view']);

                $this->load->controller('extension/analytics/ts_google_analytics/writeecommerce', array('products'=>$product_list, 'actionType'=>'view'));
            }
        }

		$this->load->language('information/information');

        /* gulp add */
		//$this->document->addStyle('catalog/view/theme/OPC080193_6/stylesheet/info_page.css');
        $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/info_page.css?ver2.1');
        /* gulp add */

        /* gulp add */
		//$this->document->addStyle('catalog/view/theme/OPC080193_6/stylesheet/hint.css');
        $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/hint.css');
        /* gulp add */

		$this->load->model('catalog/information');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}
		$data['information_id'] = $information_id;
		$information_info = $this->model_catalog_information->getInformation($information_id);

		if ($information_info) {

			if ($information_info['meta_title']) {
				$this->document->setTitle($information_info['meta_title']);
			} else {
				$this->document->setTitle($information_info['title']);
			}

			$this->document->setDescription($information_info['meta_description']);
			$this->document->setKeywords($information_info['meta_keyword']);

			$data['breadcrumbs'][] = array(
				'text' => $information_info['title'],
				'href' => $this->url->link('information/information', 'information_id=' .  $information_id)
			);

			if ($information_info['meta_h1']) {
				$data['heading_title'] = $information_info['meta_h1'];
			} else {
				$data['heading_title'] = $information_info['title'];
			}

			$data['button_continue'] = $this->language->get('button_continue');

			$data['description'] = html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8');

			$data['continue'] = $this->url->link('common/home');

      $data['microdata_breadcrumbs'] = $this->microdataBreadcrumbs($data['breadcrumbs']);

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$template = 'information/information';

      // Custom template module
      $this->load->model('setting/setting');

      $customer_group_id = $this->customer->getGroupId();

      if ($this->config->get('config_theme') == 'theme_default') {
          $directory = $this->config->get('theme_default_directory');
      } else {
          $directory = $this->config->get('config_theme');
      }

      $custom_template_module = $this->model_setting_setting->getSetting('custom_template_module');
      if(!empty($custom_template_module['custom_template_module'])){
          foreach ($custom_template_module['custom_template_module'] as $key => $module) {
              if (($module['type'] == 2) && !empty($module['informations'])) {
                  if ((isset($module['customer_groups']) && in_array($customer_group_id, $module['customer_groups'])) || !isset($module['customer_groups']) || empty($module['customer_groups'])){

                      if (in_array($information_id, $module['informations'])) {
                          if (file_exists(DIR_TEMPLATE . $directory . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . $module['template_name'] . '.tpl')) {
                              $template = $module['template_name'];
                          }
                      }

                  } // customer groups

              }
          }
      }

      $template = str_replace('\\', '/', $template);

      $this->response->setOutput($this->load->view($template, $data));
      // Custom template module
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('information/information', 'information_id=' . $information_id)
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
		}
	}

  public function microdataBreadcrumbs($breadcrumbs){
    $json = array();
    $json['@context'] = 'http://schema.org';
    $json['@type'] = 'BreadcrumbList';
    $json['itemListElement'] = array();
    $i=1;
    foreach($breadcrumbs as $breadcrumb) {
      $json['itemListElement'][] = array(
          '@type' => 'ListItem',
          'position' => $i,
          'name'  => $breadcrumb['text'],
          'item' => $breadcrumb['href']
      );
      $i++;
    }


    $output = '<script type="application/ld+json">'.json_encode($json).'</script>'."\n";

    return $output;

  }

	public function question(){

                $json = array();

                $this->load->language('information/contact');
                //print_r($this->request->post);

                if(empty($this->request->post['firstname'])){
            	    $json['error_firstname'] = true;
                }
                if(empty($this->request->post['phone'])){
            	    $json['error_phone'] = true;
                }

		if(!$json){
			$text = '';
			$text .= 'Имя: ' . $this->request->post['firstname'] . "\n";
			$text .= 'Телефон: ' . $this->request->post['phone'] . "\n";

                        $mail = new Mail();
                        $mail->protocol = $this->config->get('config_mail_protocol');
                        $mail->parameter = $this->config->get('config_mail_parameter');
                        $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
                        $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                        $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                        $mail->smtp_port = $this->config->get('config_mail_smtp_port');
                        $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

                        $mail->setTo($this->config->get('config_email'));
                        $mail->setFrom($this->config->get('config_email'));
                        $mail->setSender(html_entity_decode($this->request->post['firstname'], ENT_QUOTES, 'UTF-8'));
                        $mail->setSubject('Вопрос с сайта '.HTTP_SERVER);
                        $mail->setText($text);
                        $mail->send();

                        $json['success'] = $this->language->get('text_success');

                }
                echo json_encode($json);
        }
	public function callback(){

                $json = array();

                $this->load->language('information/contact');
                //print_r($this->request->post);

                /*if(empty($this->request->post['firstname'])){
            	    $json['error_firstname'] = true;
                }*/
                if(empty($this->request->post['phone']) || utf8_strlen(preg_replace('/[^0-9]/','',$this->request->post['phone'])) < 12){
            	    $json['error_phone'] = true;
                }

		if(!$json){
			$text = '';
			//$text .= 'Имя: ' . $this->request->post['firstname'] . "\n";
			$text .= 'Телефон: ' . $this->request->post['phone'] . "\n";

                        $mail = new Mail();
                        $mail->protocol = $this->config->get('config_mail_protocol');
                        $mail->parameter = $this->config->get('config_mail_parameter');
                        $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
                        $mail->smtp_username = $this->config->get('config_mail_smtp_username');
                        $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
                        $mail->smtp_port = $this->config->get('config_mail_smtp_port');
                        $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

                      	$mail->setTo($this->config->get('config_email'));
												//$mail->setTo('vitasamohina89@gmail.com');
                        $mail->setFrom($this->config->get('config_email'));
                        $mail->setSender(html_entity_decode(HTTP_SERVER, ENT_QUOTES, 'UTF-8'));
                        $mail->setSubject('Обратный звонок с сайта '.HTTP_SERVER);
                        $mail->setText($text);
                        $mail->send();

                        $json['success'] = $this->language->get('text_success');

                }
                echo json_encode($json);
        }

	public function agree() {
		$this->load->model('catalog/information');

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}

		$output = '';

		$information_info = $this->model_catalog_information->getInformation($information_id);

		if ($information_info) {
			$output .= html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
		}

		$this->response->setOutput($output);
	}
}
