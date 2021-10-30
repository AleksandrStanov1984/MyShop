<?php
class ControllerExtensionModuleSlideshow extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->model('design/banner');
		$this->load->model('tool/image');

        $this->document->addStyle('catalog/view/theme/OPC080193_6/stylesheet/slideshow.css');
        $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/owl.carousel.min.css');
        $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/owl.transitions.css');
        $this->document->addScript('catalog/view/theme/OPC080193_6/assets/owl.carousel.min.js');
        $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/slideshow.css');

		$data['banners'] = array();

		$data['text_gallery'] = $this->language->get('text_gallery');

		$results = $this->model_design_banner->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image']) && $result['hide'] == 0) {
				$data['banners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'width'  => $setting['width'],
					'height' => $setting['height'],
                    'popup' => HTTP_SERVER . 'image/' . $result['image'],
                    'image' => HTTP_SERVER . 'image/' . $result['image'],
				);
			}
		}

		$data['module'] = $module++;

		return $this->load->view('extension/module/slideshow', $data);
	}
}
