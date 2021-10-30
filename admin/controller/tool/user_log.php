<?php
class ControllerToolUserLog extends Controller {
	private $error = array();
	private $data = array();
	
	public function clear() {
		if ($this->validate()) {
			$this->load->model('extension/module/user_log');
			$this->load->language('extension/module/user_log');
			$this->session->data['success'] = $this->language->get('text_clear');
			$this->model_extension_module_user_log->clear();
		}
		$this->response->redirect($this->url->link('tool/user_log', 'token=' . $this->session->data['token'], true));
	}
	
	public function delete() {
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('extension/module/user_log');
			$this->load->language('extension/module/user_log');
			if (isset($this->request->post['selected'])) {
				
				foreach ($this->request->post['selected'] as $record) {
					$this->model_extension_module_user_log->deleteRecord($record);
	  			}
				$count = count($this->request->post['selected']);
	  			$this->user->addLog(array(
					'action' 	=> 'delete record (' . $count . ')', 
					'result' 	=> 1)
				);
				$this->session->data['success'] = $this->language->get('text_delete') . $count;
			}
		}
		$url = '';
		if (isset($this->request->get['filter_action'])) {
			$url .= '&filter_action=' . $this->request->get['filter_action'];
		}
		if (isset($this->request->get['filter_start'])) {
			$url .= '&filter_start=' . $this->request->get['filter_start'];
		}
		if (isset($this->request->get['filter_end'])) {
			$url .= '&filter_end=' . $this->request->get['filter_end'];
		}
		if (isset($this->request->get['filter_user_id'])) {
			$url .= '&filter_user_id=' . $this->request->get['filter_user_id'];
		}
		if (isset($this->request->get['filter_url'])) {
			$url .= '&filter_url=' . $this->request->get['filter_url'];
		}
	
		$this->response->redirect($this->url->link('tool/user_log', 'token=' . $this->session->data['token'] . $url, true));
	}
	
	public function index() {
		$this->load->language('extension/module/user_log');
		$this->load->model('extension/module/user_log');
		$this->document->addStyle('view/stylesheet/user_log.css?ver=1');

		$this->document->setTitle(strip_tags($this->language->get('heading_log')));

		$this->load->model('setting/setting');
		if (isset($this->session->data['success'])) {
			$this->data['success'] =  $this->session->data['success'];
			unset($this->session->data['success']);
		}
		if (isset($this->session->data['warnibsuccess'])) {
			$this->data['success'] =  $this->session->data['success'];
			unset($this->session->data['success']);
		}
		$this->data = $this->language->all();
/*		
		$this->data['heading_log'] = $this->language->get('heading_log');

		$this->data['button_clear'] = $this->language->get('button_clear');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_setting'] = $this->language->get('button_setting');
		$this->data['action_setting'] = $this->language->get('action_setting');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_user'] = $this->language->get('column_user');
		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['column_result'] = $this->language->get('column_result');
		$this->data['column_url'] = $this->language->get('column_url');
		$this->data['column_ip'] = $this->language->get('column_ip');
		$this->data['column_date'] = $this->language->get('column_date');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
*/
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$this->data['records'] = array();
		
		$limit = $this->config->get('user_log_display')?$this->config->get('user_log_display'):$this->config->get('config_admin_limit');
		
		
		
		
		$data_filters['start'] = ($page - 1) * $limit;
		$data_filters['limit'] = $limit;
		if (isset($this->request->get['filter_user_id'])) {
			$data_filters['filter_user_id'] = $this->request->get['filter_user_id'];
			$this->data['filter_user_id'] = $this->request->get['filter_user_id'];
		} else {
			$this->data['filter_user_id'] = '';
		}
		if (isset($this->request->get['filter_action'])) {
			$data_filters['filter_action'] = $this->request->get['filter_action'];
			$this->data['filter_action'] = $this->request->get['filter_action'];
		} else {
			$this->data['filter_action'] = '';
		}
		
		if (isset($this->request->get['filter_start'])) {
			$data_filters['filter_start'] = $this->request->get['filter_start'];
			$this->data['filter_start'] = $this->request->get['filter_start'];
		} else {
			$this->data['filter_start'] = '';
		}
		
		if (isset($this->request->get['filter_end'])) {
			$data_filters['filter_end'] = $this->request->get['filter_end'];
			$this->data['filter_end'] = $this->request->get['filter_end'];
		} else {
			$this->data['filter_end'] = '';
		}

		if (isset($this->request->get['filter_url'])) {
			$data_filters['filter_url'] = $this->request->get['filter_url'];
			$this->data['filter_url'] = $this->request->get['filter_url'];
		} else {
			$this->data['filter_url'] = '';
		}
		
		$records_total = $this->model_extension_module_user_log->getTotalRecords($data_filters);
  		$records = $this->model_extension_module_user_log->getRecords($data_filters);

		foreach ($records as $record) {
			$action_descr = '';
			if (preg_match('#(edit|delete|insert|add)#',$record['url'],$matches)) {
				$action_descr = $matches[0];
				if ($record['action'] == 'modify - save') {$action_descr .= '&amp;save';}
			}
      		$this->data['records'][] = array(
      			'user_log_id'	=> $record['user_log_id'],
      			'user'		=> $this->url->link('user/user/edit', 'token=' . $this->session->data['token'] . '&user_id=' . $record['user_id'], true),
      			'user_name'	=> $record['user_name'],
				'action'	=> $record['action'],
				'result'	=> $record['result'],
				'url'		=> $record['url'],
				'action_descr' => $action_descr,
				'ip'		=> $record['ip'],
				'date'		=> $record['date'],
			);
    	}
		$url = '';
		if (isset($this->request->get['filter_action'])) {
			$url .= '&filter_action=' . $this->request->get['filter_action'];
		}
		if (isset($this->request->get['filter_start'])) {
			$url .= '&filter_start=' . $this->request->get['filter_start'];
		}
		if (isset($this->request->get['filter_end'])) {
			$url .= '&filter_end=' . $this->request->get['filter_end'];
		}
		if (isset($this->request->get['filter_user_id'])) {
			$url .= '&filter_user_id=' . $this->request->get['filter_user_id'];
		}
		if (isset($this->request->get['filter_url'])) {
			$url .= '&filter_url=' . $this->request->get['filter_url'];
		}
		
		
		$this->load->model('user/user');
		$this->data['users'] = $this->model_user_user->getUsers();
		$this->data['token'] = $this->session->data['token'];
		$pagination = new Pagination();
		$pagination->total = $records_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('tool/user_log', 'token=' . $this->session->data['token'] . '&page={page}' . $url, true);

		$this->data['pagination'] = $pagination->render();

		$this->data['result'] = sprintf(
		$this->language->get('text_pagination'), ($records_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($records_total - $limit)) ? $records_total : ((($page - 1) * $limit) + $limit), $records_total, ceil($records_total / $limit));

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/module/user_log', 'token=' . $this->session->data['token'], true),
      		'separator' => ' :: '
   		);

		$this->data['button_settings'] = $this->language->get('heading_title');
		$this->data['action_settings'] = $this->url->link('extension/module/user_log', 'token=' . $this->session->data['token'], true);
		$this->data['action_setting'] = $this->url->link('extension/module/user_log', 'token=' . $this->session->data['token'], true);
		$this->data['clear_action'] = $this->url->link('tool/user_log/clear', 'token=' . $this->session->data['token'], true);
		$this->data['delete_action'] = $this->url->link('tool/user_log/delete', 'token=' . $this->session->data['token'] . $url, true);

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['header'] = $this->load->controller('common/header');
		$this->data['column_left'] = $this->load->controller('common/column_left');
		$this->data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('tool/user_log', $this->data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'tool/user_log')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	

}
?>