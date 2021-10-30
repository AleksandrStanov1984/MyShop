<?php
class ControllerInformationAbout extends Controller {
	public function index() {
		$this->load->language('information/about');
		$this->document->addStyle('catalog/view/theme/OPC080193_6/stylesheet/page_about.css?ver1.1');
		$this->document->addStyle('catalog/view/theme/OPC080193_6/stylesheet/info_page.css?ver1.1');

		$this->document->setTitle($this->language->get('heading_title'));


		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('information/about')
		);

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_advantages'] = $this->language->get('text_advantages');
		$data['text_title_advantage_1'] = $this->language->get('text_title_advantage_1');
		$data['text_title_advantage_2'] = $this->language->get('text_title_advantage_2');
		$data['text_title_advantage_3'] = $this->language->get('text_title_advantage_3');
		$data['text_title_advantage_4'] = $this->language->get('text_title_advantage_4');
		$data['text_adv_num_1'] = $this->language->get('text_adv_num_1');
		$data['text_adv_num_2'] = $this->language->get('text_adv_num_2');
		$data['text_adv_num_3'] = $this->language->get('text_adv_num_3');
		$data['text_adv_num_4'] = $this->language->get('text_adv_num_4');
		$data['text_adv_description_1'] = $this->language->get('text_adv_description_1');
		$data['text_adv_description_2'] = $this->language->get('text_adv_description_2');
		$data['text_adv_description_3'] = $this->language->get('text_adv_description_3');
		$data['text_adv_description_4'] = $this->language->get('text_adv_description_4');
		$data['text_tab_about'] = $this->language->get('text_tab_about');
		$data['text_tab_contact'] = $this->language->get('text_tab_contact');
		$data['text_welcom_t'] = $this->language->get('text_welcom_t');
		$data['text_welcom_d'] = $this->language->get('text_welcom_d');
		$data['text_tab_oplata'] = $this->language->get('text_tab_oplata');
		$data['text_tab_dostavka'] = $this->language->get('text_tab_dostavka');
		$data['text_tab_garantiya'] = $this->language->get('text_tab_garantiya');
		$data['text_tab_policy'] = $this->language->get('text_tab_policy');
		$data['text_tab_return'] = $this->language->get('text_tab_return');

		$data['contact'] = $this->url->link('information/contact');
		$data['garantiya_link'] = $this->url->link('information/information', 'information_id=21');
		$data['payment_link'] = $this->url->link('information/information', 'information_id=19');
		$data['policy_link'] = $this->url->link('information/information', 'information_id=22');
		$data['shipping_link'] = $this->url->link('information/information', 'information_id=13');
		$data['return_link'] = $this->url->link('account/return/add');


		$data['microdata'] = $this->microdataStore();
		$data['microdata_breadcrumbs'] = $this->microdataBreadcrumbs($data['breadcrumbs']);

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');


		$this->response->setOutput($this->load->view('information/about', $data));
	}

	public function microdataStore(){
    $json = array();
    $json['@context'] = 'http://schema.org';
    $json['@type'] = 'Store';
    $json['image'] = HTTPS_SERVER.'catalog/view/theme/OPC080193_6/images/logo.svg';
    $json['name'] = $this->language->get('store_name');
    $json['telephone'] = '0 800 33 09 53';

    $work_days = explode(',', $this->language->get('work_days'));
    $weekend_days = explode(',', $this->language->get('weekend_days'));
    $json['openingHoursSpecification'][] = array(
        '@type' => 'OpeningHoursSpecification',
        'dayOfWeek' => $work_days,
        'opens' => '09:00',
        'closes'=> '21:00'
    );

    $json['openingHoursSpecification'][] = array(
        '@type' => 'OpeningHoursSpecification',
        'dayOfWeek' => $weekend_days,
        'opens' => '09:00',
        'closes'=> '21:00'
    );

    $json['address'] = array(
        '@type' => 'PostalAddress',
        'streetAddress' => $this->language->get('address_street'),
        'addressLocality' => $this->language->get('address_location'),
        'addressCountry'	=> $this->language->get('address_country')
    );

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


}
