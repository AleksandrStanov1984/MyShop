<?php
class ControllerCommonHome extends Controller {
    public function index() {

    	$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));
		if (isset($this->request->get['route'])) {
			
       $this->document->addLink($this->url->link('common/home')
    , 'canonical');
		}

		$data['microdata'] = $this->microdataOrganization();

		$data['text_reviews1'] = $this->language->get('text_reviews1');
		$data['text_reviews2'] = $this->language->get('text_reviews2');
		$data['text_name'] = $this->language->get('text_name');
		$data['text_phone'] = $this->language->get('text_phone');
		$data['text_send'] = $this->language->get('text_send');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('common/home', $data));
	}

	public function microdataOrganization(){
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
}
