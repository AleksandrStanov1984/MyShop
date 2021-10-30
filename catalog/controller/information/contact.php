<?php
class ControllerInformationContact extends Controller {
	private $error = array();


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

		$this->load->language('information/contact');
        /* gulp add */
		//$this->document->addStyle('catalog/view/theme/OPC080193_6/stylesheet/page_contact.css?ver1.1');
        $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/page_contact.css');
        /* gulp add */
        /* gulp add */
		//$this->document->addStyle('catalog/view/theme/OPC080193_6/stylesheet/info_page.css');
        $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/info_page.css');
        /* gulp add */
		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
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
        		$mail->setReplyTo($this->request->post['email']);
			$mail->setSender(html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['name']), ENT_QUOTES, 'UTF-8'));
			$mail->setText($this->request->post['enquiry']);
			$mail->send();

			$this->response->redirect($this->url->link('information/contact/success'));
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/contact')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_location'] = $this->language->get('text_location');
		$data['text_store'] = $this->language->get('text_store');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_address'] = $this->language->get('text_address');
		$data['text_telephone'] = $this->language->get('text_telephone');
		$data['text_fax'] = $this->language->get('text_fax');
		$data['text_open'] = $this->language->get('text_open');
		$data['text_email'] = $this->language->get('text_email');
		$data['text_delivery_from_stock'] = $this->language->get('text_delivery_from_stock');
		$data['entry_delivery_from_stock'] = $this->language->get('entry_delivery_from_stock');
		$data[''] = $this->language->get('entry_delivery_from_stock');
		$data['entry_delivery_from_stock'] = $this->language->get('entry_delivery_from_stock');
		$data['text_go_from_akademgorodoc'] = $this->language->get('text_go_from_akademgorodoc');
		$data['text_go_from_center'] = $this->language->get('text_go_from_center');
		$data['text_detailed_driving_directions'] = $this->language->get('text_detailed_driving_directions');
		$data['text_comment'] = $this->language->get('text_comment');
		$data['text_tab_about'] = $this->language->get('text_tab_about');
		$data['text_tab_contact'] = $this->language->get('text_tab_contact');
		$data['about'] = $this->url->link('information/about');
		$data['garantiya_link'] = $this->url->link('information/information', 'information_id=21');
		$data['payment_link'] = $this->url->link('information/information', 'information_id=19');
		$data['policy_link'] = $this->url->link('information/information', 'information_id=22');
		$data['shipping_link'] = $this->url->link('information/information', 'information_id=13');
		$data['return_link'] = $this->url->link('account/return/add');



		$data['text_tab_oplata'] = $this->language->get('text_tab_oplata');
		$data['text_tab_dostavka'] = $this->language->get('text_tab_dostavka');
		$data['text_tab_garantiya'] = $this->language->get('text_tab_garantiya');
		$data['text_tab_policy'] = $this->language->get('text_tab_policy');
		$data['text_tab_return'] = $this->language->get('text_tab_return');

		$data['text_placeholder_name'] = $this->language->get('text_placeholder_name');
		$data['text_placeholder_email'] = $this->language->get('text_placeholder_email');
		$data['text_placeholder_enquiry'] = $this->language->get('text_placeholder_enquiry');
		$data['text_welcome_d'] = $this->language->get('text_welcome_d');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_enquiry'] = $this->language->get('entry_enquiry');

		$data['button_map'] = $this->language->get('button_map');

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['enquiry'])) {
			$data['error_enquiry'] = $this->error['enquiry'];
		} else {
			$data['error_enquiry'] = '';
		}

		$data['button_submit'] = $this->language->get('button_submit');

		$data['action'] = $this->url->link('information/contact', '', true);

		$this->load->model('tool/image');

		if ($this->config->get('config_image')) {
			$data['image'] = $this->model_tool_image->resize($this->config->get('config_image'), $this->config->get($this->config->get('config_theme') . '_image_location_width'), $this->config->get($this->config->get('config_theme') . '_image_location_height'));
		} else {
			$data['image'] = false;
		}

		$data['store'] = $this->config->get('config_name');
		$data['address'] = nl2br($this->config->get('config_address'));
		$data['geocode'] = $this->config->get('config_geocode');
		$data['geocode_hl'] = $this->config->get('config_language');
		$data['telephone'] = $this->config->get('config_telephone');
		$data['fax'] = $this->config->get('config_fax');
		$data['email'] = $this->config->get('config_email');
		$data['open'] = nl2br($this->config->get('config_open'));
		$data['comment'] = $this->config->get('config_comment');

		$data['locations'] = array();

		$this->load->model('localisation/location');

		foreach((array)$this->config->get('config_location') as $location_id) {
			$location_info = $this->model_localisation_location->getLocation($location_id);

			if ($location_info) {
				if ($location_info['image']) {
					$image = $this->model_tool_image->resize($location_info['image'], $this->config->get($this->config->get('config_theme') . '_image_location_width'), $this->config->get($this->config->get('config_theme') . '_image_location_height'));
				} else {
					$image = false;
				}

				$data['locations'][] = array(
					'location_id' => $location_info['location_id'],
					'name'        => $location_info['name'],
					'address'     => nl2br($location_info['address']),
					'geocode'     => $location_info['geocode'],
					'telephone'   => $location_info['telephone'],
					'fax'         => $location_info['fax'],
					'email'         => $location_info['mail'],
					'image'       => $image,
					'open'        => nl2br($location_info['open']),
					'comment'     => $location_info['comment']
				);
			}
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} else {
			$data['name'] = $this->customer->getFirstName();
		}

		if (isset($this->request->post['mail'])) {
			$data['mail'] = $this->request->post['mail'];
		} else {
			$data['mail'] = $this->customer->getEmail();
		}

		if (isset($this->request->post['enquiry'])) {
			$data['enquiry'] = $this->request->post['enquiry'];
		} else {
			$data['enquiry'] = '';
		}

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
			$data['captcha'] = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha'), $this->error);
		} else {
			$data['captcha'] = '';
		}

		$data['microdata'] = $this->microdataContacts();
		$data['microdata_breadcrumbs'] = $this->microdataBreadcrumbs($data['breadcrumbs']);

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		$this->response->setOutput($this->load->view('information/contact', $data));
	}

	public function microdataContacts(){
    $json = array();
    $json['@context'] = 'http://schema.org';
    $json['@type'] = 'Organization';
    $json['url'] = HTTPS_SERVER;
    $json['logo'] = HTTPS_SERVER.'catalog/view/theme/OPC080193_6/images/logo.svg';
    $json['name'] = $this->language->get('company_name');
    $json['email'] = $this->config->get('config_email');

    $json['address'] = array(
        '@type' => 'PostalAddress',
        'streetAddress' => $this->language->get('address_street'),
        'addressLocality' => $this->language->get('address_location'),
        'addressCountry'	=> $this->language->get('address_country')
    );

    $json['contactPoint'][] = array(
        '@type' => 'ContactPoint',
        'telephone' => '0 800 33 09 53',
        'contactType' => 'customer service'
    );

    $json['contactPoint'][] = array(
        '@type' => 'ContactPoint',
        'telephone' => '+38 067 54 41 728',
        'contactType' => 'customer service'
    );

    $json['contactPoint'][] = array(
        '@type' => 'ContactPoint',
        'telephone' => '+38 093 02 04 021',
        'contactType' => 'customer service'
    );

    $json['contactPoint'][] = array(
        '@type' => 'ContactPoint',
        'telephone' => '+38 044 499 76 68',
        'contactType' => 'customer service'
    );

    $json['contactPoint'][] = array(
        '@type' => 'ContactPoint',
        'telephone' => '+38 050 30 01 667',
        'contactType' => 'customer service'
    );

    $json['sameAs'] = array('https://www.facebook.com/www.sz.ua', 'https://www.instagram.com/sz.ua_/');

    $output = '<script type="application/ld+json">'.json_encode($json).'</script>'."\n";

    return $output;

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
          'name'	=> $breadcrumb['text'],
          'item' => $breadcrumb['href']
      );
      $i++;
    }


    $output = '<script type="application/ld+json">'.json_encode($json).'</script>'."\n";

    return $output;

  }


	public function asdf(){

		$json = array();
		//print_r($this->request->post);


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
        		$mail->setReplyTo($this->request->post['email']);
			$mail->setSender(html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8'));
			$mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['name']), ENT_QUOTES, 'UTF-8'));
			$mail->setText($this->request->post['enquiry']);
			$mail->send();
	}

	protected function validate() {
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!preg_match($this->config->get('config_mail_regexp'), $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ((utf8_strlen($this->request->post['enquiry']) < 10) || (utf8_strlen($this->request->post['enquiry']) > 3000)) {
			$this->error['enquiry'] = $this->language->get('error_enquiry');
		}

		// Captcha
		if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('contact', (array)$this->config->get('config_captcha_page'))) {
			$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');

			if ($captcha) {
				$this->error['captcha'] = $captcha;
			}
		}

		return !$this->error;
	}

	public function success() {
		$this->load->language('information/contact');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/contact')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_message'] = $this->language->get('text_success');

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('common/success', $data));
	}
}
