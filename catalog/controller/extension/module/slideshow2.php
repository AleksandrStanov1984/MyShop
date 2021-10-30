<?php
class ControllerExtensionModuleSlideshow2 extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->model('design/banner');
		$this->load->model('tool/image');
		$this->load->language('extension/module/slideshow2');
       $this->document->addStyle('catalog/view/theme/OPC080193_6/stylesheet/slideshow.css?ver1.3');

        $this->document->addStyle('catalog/view/theme/OPC080193_6/js/fancy/jquery.fancybox.css', 'footer');
        $this->document->addScript('catalog/view/theme/OPC080193_6/js/fancy/jquery.fancybox.min.js', 'footer');
        $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/slideshow.css');
        $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/owl.carousel.min.css');
        $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/owl.transitions.css');
        $this->document->addScript('catalog/view/theme/OPC080193_6/assets/owl.carousel.min.js');

		$data['banners'] = array();

		$data['text_gallery'] = $this->language->get('text_gallery');
		$data['title_stock_of_day'] = $this->language->get('title_stock_of_day');
		$data['title_foto_gallery'] = $this->language->get('title_foto_gallery');
		$data['title_slider_account_sidebar'] = $this->language->get('title_slider_account_sidebar');

		$results = $this->model_design_banner->getBanner($setting['banner_id']);
		$data['template'] = $setting['template'];

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image']) && $result['hide'] == 0) {
				$data['banners'][] = array(
					'title'  => $result['title'],
					'link'   => $result['link'],
					'width'  => $setting['width'],
					'height' => $setting['height'],
					'popup'  => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']),
                    'image'  => HTTP_SERVER . 'image/' . $result['image'],
                );
			}
		}

		$data['module'] = $module++;

		return $this->load->view('extension/module/slideshow2', $data);
	}
}
