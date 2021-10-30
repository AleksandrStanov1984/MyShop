<?php
class ControllerModuleReferrer extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('module/referrer');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('module/referrer');

        $this->getList();
    }

    public function update() {
        $this->load->language('module/referrer');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('module/referrer');

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

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_module_referrer->updateRecord($this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
        }
        $this->response->redirect($this->url->link('module/referrer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    }

    public function delete() {
        $this->load->language('module/referrer');
        $this->load->model('module/referrer');
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

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $pattern_id) {
                $this->model_module_referrer->deleteRecord($pattern_id);
            }
            $this->session->data['success'] = $this->language->get('text_success');
        }

        $this->response->redirect($this->url->link('module/referrer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    }

    private function getList() {
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'ua.query';
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

        $data = array(
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );
		
		$data['patterns'] = array();
        $patterns_total = $this->model_module_referrer->getRecordsCount();
        $results = $this->model_module_referrer->getRecords($data);
        foreach ($results as $result) {
            $data['patterns'][] = array(
                'pattern_id' => $result['pattern_id'],
                'name' => $result['name'],
                'url_mask' => $result['url_mask'],
                'url_param' => $result['url_param'],
                'selected' => isset($this->request->post['selected']) && in_array($result['pattern_id'], $this->request->post['selected']),
                'action_text' => $this->language->get('text_edit')
            );
        }

        $data['heading_title'] = $this->language->get('heading_title');
		
		$data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/referrer', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['insert'] = $this->url->link('module/referrer/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['delete'] = $this->url->link('module/referrer/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $data['save'] = $this->url->link('module/referrer/update', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

        $data['text_no_results'] = $this->language->get('text_no_results');

        $data['text_name'] = $this->language->get('text_name');
        $data['text_url_mask'] = $this->language->get('text_url_mask');
        $data['text_url_param'] = $this->language->get('text_url_param');

        $data['column_name'] = $this->language->get('column_name');
        $data['column_url_mask'] = $this->language->get('column_url_mask');
        $data['column_url_param'] = $this->language->get('column_url_param');
        $data['column_action'] = $this->language->get('column_action');

        $data['button_insert'] = $this->language->get('button_insert');
        $data['button_delete'] = $this->language->get('button_delete');
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

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

        $url = '';

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_name'] = $this->url->link('module/referrer', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        $data['sort_url_param'] = $this->url->link('module/referrer', 'token=' . $this->session->data['token'] . '&sort=url_mask' . $url, 'SSL');
        $data['sort_url_mask'] = $this->url->link('module/referrer', 'token=' . $this->session->data['token'] . '&sort=url_param' . $url, 'SSL');

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $patterns_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('module/referrer', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $data['pagination'] = $pagination->render();

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        
        $this->response->setOutput($this->load->view('module/referrer.tpl', $data));

    }

    private function validateForm() {
        if (!$this->user->hasPermission('modify', 'module/referrer')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    private function validateDelete() {
        if (!$this->user->hasPermission('modify', 'module/referrer')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function install() {
        $this->load->model('module/referrer');
        $this->model_module_referrer->install();

    }

    public function uninstall() {
        $this->load->model('module/referrer');
        $this->model_module_referrer->uninstall();
    }

}
?>
