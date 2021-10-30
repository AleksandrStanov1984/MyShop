<?php
class ControllerExtensionModuleBanner extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		$this->document->addStyle('catalog/view/theme/OPC080193_6/assets/owl.carousel.min.css');
		$this->document->addStyle('catalog/view/theme/OPC080193_6/assets/owl.transitions.css');
		$this->document->addScript('catalog/view/theme/OPC080193_6/assets/owl.carousel.min.js');
		$data['banners'] = array();

		$results = $this->model_design_banner->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if ($result['image'] && $result['hide'] == 0) {
				$data['banners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		}

		$data['module'] = $module++;

		return $this->load->view('extension/module/banner', $data);
	}
}
