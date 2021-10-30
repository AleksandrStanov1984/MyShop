<?php
class ControllerErrorNotFound extends Controller {
	public function index() {
		$this->load->language('error/not_found');
		$this->document->addStyle('catalog/view/theme/OPC080193_6/assets/404.css');
		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['route'])) {
			$url_data = $this->request->get;

			unset($url_data['_route_']);

			$route = $url_data['route'];

			unset($url_data['route']);

			$url = '';

			if ($url_data) {
				$url = '&' . urldecode(http_build_query($url_data, '', '&'));
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link($route, $url, isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1')))
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['before_heading_title'] = $this->language->get('before_heading_title');
		$data['text_useful_links'] = $this->language->get('text_useful_links');
		$data['link_pickup'] = $this->url->link('information/information', 'information_id=13');

		$data['text_error'] = $this->language->get('text_error');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['text_home'] = $this->language->get('text_home');
		$data['text_pickup'] = $this->language->get('text_pickup');
		$data['text_catalog'] = $this->language->get('text_catalog');
		$data['text_contact'] = $this->language->get('text_contact');

		$data['continue'] = $this->url->link('common/home');
		$data['contact'] = $this->url->link('information/contact');

		$this->load->model('catalog/information');
		$data['informations'] = array();

				foreach ($this->model_catalog_information->getInformations() as $result) {
					if ($result['bottom']) {
						$data['informations'][] = array(
							'title' => $result['title'],
							'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
						);
					}
				}
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

		$this->response->setOutput($this->load->view('error/not_found', $data));
	}
}
