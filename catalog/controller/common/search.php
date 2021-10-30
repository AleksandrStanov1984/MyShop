<?php
class ControllerCommonSearch extends Controller {
	public function index() {
		$this->load->language('common/search');
		$data['route'] = $this->request->get['route'];

		$data['text_search'] = $this->language->get('text_search');
		$data['mytemplate'] = $this->config->get('theme_default_directory');

		if (isset($this->request->get['search'])) {
			$data['search'] = $this->request->get['search'];
		} else {
			$data['search'] = '';
		}

		return $this->load->view('common/search', $data);
	}
}