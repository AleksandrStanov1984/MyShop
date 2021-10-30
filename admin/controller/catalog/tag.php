<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

class ControllerCatalogTag extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('catalog/tag');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tag');

		$this->getList();
	}

	public function gettag() {
		$this->load->language('catalog/tag');

		$this->load->model('catalog/tag');
		$json = '';
		
		if ($this->request->get['tag_id']) {
			$json = $this->model_catalog_tag->getTag($this->request->get['tag_id']);
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function add() {
		$this->load->language('catalog/tag');

		$this->load->model('catalog/tag');
		$this->load->model('catalog/folder_search');
		$json = '';
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->request->post['code'] = $this->model_catalog_folder_search->codeString($this->request->post['tag']);
			
			$this->request->get['tag_id'] = $this->model_catalog_tag->addTag($this->request->post);
			
			$this->gettag();
			$json['success'] = $this->language->get('text_success');

		}
	}

	public function edit() {
		$this->load->language('catalog/tag');

		$this->load->model('catalog/tag');
		$this->load->model('catalog/folder_search');
		$json = '';
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			
			$this->request->post['code'] = $this->model_catalog_folder_search->codeString($this->request->post['tag']);
		
			$this->model_catalog_tag->editTag($this->request->get['tag_id'], $this->request->post);
			
			$this->gettag();
			$json = $this->language->get('text_success');

		}
	}

	public function delete() {
		$this->load->language('catalog/tag');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/tag');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $tag_id) {
				$this->model_catalog_tag->deleteTag($tag_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/tag', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'tag';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/tag', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/tag/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/tag/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['tags'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$tag_total = $this->model_catalog_tag->getTotalTags();

		$results = $this->model_catalog_tag->getTags($filter_data);

		foreach ($results as $result) {
			$data['tags'][] = array(
				'tag_id' => $result['tag_id'],
				'tag'               => $result['tag'],
				'search'               => $result['search'],
				'view'               => $result['view'],
				'sort_order'         => $result['sort_order'],
				'status'         => $result['status'],
				'date_added'         => $result['date_added'],
				'date_modified'         => $result['date_modified'],
				'edit'               => $this->url->link('catalog/tag/edit', 'token=' . $this->session->data['token'] . '&tag_id=' . $result['tag_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');
		$data['text_edit'] = $this->language->get('text_edit');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_tag'] = $this->url->link('catalog/tag', 'token=' . $this->session->data['token'] . '&sort=tag' . $url, true);
		$data['sort_search'] = $this->url->link('catalog/tag', 'token=' . $this->session->data['token'] . '&sort=search' . $url, true);
		$data['sort_view'] = $this->url->link('catalog/tag', 'token=' . $this->session->data['token'] . '&sort=view' . $url, true);
		$data['sort_status'] = $this->url->link('catalog/tag', 'token=' . $this->session->data['token'] . '&sort=status' . $url, true);
		$data['sort_date_added'] = $this->url->link('catalog/tag', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, true);
		$data['sort_date_modified'] = $this->url->link('catalog/tag', 'token=' . $this->session->data['token'] . '&sort=date_modified' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/tag', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $tag_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/tag', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($tag_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($tag_total - $this->config->get('config_limit_admin'))) ? $tag_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $tag_total, ceil($tag_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['token'] = $this->session->data['token'];
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/tag_list', $data));
	}


	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/tag')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/tag')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}

