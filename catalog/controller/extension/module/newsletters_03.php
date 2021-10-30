<?php
class ControllerExtensionModuleNewsletters extends Controller {
	public function index() {
		$this->load->language('extension/module/newsletter');
		$this->load->model('extension/module/newsletters');
		
		$this->model_extension_module_newsletters->createNewsletter();

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_brands'] = $this->language->get('text_brands');
		$data['text_index'] = $this->language->get('text_index');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['text_button'] = $this->language->get('text_button');
		
		$data['brands'] = array();
		
		
		
		
		return $this->load->view('extension/module/newsletters', $data); 
	}
	public function news()
	{
		$this->load->model('extension/module/newsletters');
		
		$json = array();
		$json['message'] = $this->model_extension_module_newsletters->subscribes($this->request->post);
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		
	}
	
}
