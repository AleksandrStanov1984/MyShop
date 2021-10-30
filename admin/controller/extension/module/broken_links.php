<?php
class ControllerExtensionModuleBrokenLinks extends Controller {
	private $error = array();
	private $data;
	private $version = '2.3.1';
    public function __construct($registry) {
        parent::__construct($registry);
        $this->_moduleName = "Broken Links";
        $this->_moduleSysName = "broken_links";
    }

	public function index() {
		$this->language->load('extension/module/' . $this->_moduleSysName);
		$this->data = $this->language->all();
		$this->document->setTitle($this->language->get('heading_title_raw'));		
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('setting/setting');
			$this->model_setting_setting->editSetting($this->_moduleSysName, $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
						
      if( isset($this->request->get['apply'])) {
          $this->response->redirect($this->url->link('extension/module/' . $this->_moduleSysName, 'token=' . $this->session->data['token'], true));
      } else {
          $this->response->redirect($this->url->link('extension/extension/', 'type=module&token=' . $this->session->data['token'], true));
      }
		}

    if (isset($this->error['warning'])) {
        $this->data['error_warning'] = $this->error['warning'];
    } else {
        $this->data['error_warning'] = '';
    }

		$this->data['action'] = $this->url->link('extension/module/' . $this->_moduleSysName, 'token=' . $this->session->data['token'], true);

		$this->data['cancel'] = $this->url->link('extension/extension', 'type=module&token=' . $this->session->data['token'], true);
        $this->data['clear'] = $this->url->link('extension/module/' . $this->_moduleSysName . '/clear', 'token=' . $this->session->data['token'], true);
    $this->data['save'] = $this->url->link('extension/module/' . $this->_moduleSysName, 'token=' . $this->session->data['token'] . "&apply=1", true);
    $this->data['save_and_quit'] = $this->url->link('extension/extension', 'type=module&token=' . $this->session->data['token'], true);
		$this->data['view_log'] = $this->url->link('extension/module/' . $this->_moduleSysName . '/view_log', 'token=' . $this->session->data['token'], true);
		$this->data['view_redirect'] = $this->url->link('extension/module/' . $this->_moduleSysName . '/view_redirect', 'token=' . $this->session->data['token'], true);

		$this->data['total_banners'] = $this->registry->get('model_extension_module_' . $this->_moduleSysName )->getTotalBannerLinks();

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		}
		
		$this->data['breadcrumbs'] = array();

 		$this->data['breadcrumbs'][] = array(
     		'text'      => $this->language->get('text_home'),
		'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
 		);

 		$this->data['breadcrumbs'][] = array(
     		'text'      => $this->language->get('text_module'),
		'href'      => $this->url->link('extension/extension/', 'type=module&token=' . $this->session->data['token'], true),
 		);
	
 		$this->data['breadcrumbs'][] = array(
     		'text'      => $this->language->get('heading_title'),
		'href'      => $this->url->link('extension/module/' . $this->_moduleSysName, 'token=' . $this->session->data['token'], true),
 		);


		if (isset($this->request->post[$this->_moduleSysName . '_enable'])) {
			$this->data[$this->_moduleSysName . '_enable'] = $this->request->post[$this->_moduleSysName . '_enable'];
		} else {
			$this->data[$this->_moduleSysName . '_enable'] = $this->config->get($this->_moduleSysName . '_enable');
		}
		if (isset($this->request->post[$this->_moduleSysName . '_redirect'])) {
			$this->data[$this->_moduleSysName . '_redirect'] = $this->request->post[$this->_moduleSysName . '_redirect'];
		} else {
			$this->data[$this->_moduleSysName . '_redirect'] = $this->config->get($this->_moduleSysName . '_redirect');
		}

		$this->data['module_name'] = $this->_moduleSysName;
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->data['header'] = $this->load->controller('common/header');
		$this->data['column_left'] = $this->load->controller('common/column_left');
		$this->data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('extension/module/' . $this->_moduleSysName, $this->data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/' . $this->_moduleSysName)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

	protected function validate_() {
		if (!$this->user->hasPermission('access', 'extension/module/' . $this->_moduleSysName)) {
			$this->error['warning'] = $this->language->get('error_permission_view');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}

  public function view_log() {
		$this->language->load('extension/module/' . $this->_moduleSysName);
		$this->data = $this->language->all();
		$this->document->setTitle($this->language->get('heading_log'));		
		
		if ($this->validate_()) {

			$this->data['token'] = $this->session->data['token'];
			$this->data['clear'] = $this->url->link('extension/module/' . $this->_moduleSysName . '/clear', 'token=' . $this->session->data['token'], true);
			$this->data['settings'] = $this->url->link('extension/module/' . $this->_moduleSysName , 'token=' . $this->session->data['token'], true);
			$this->data['export'] 	 = $this->url->link('extension/module/' . $this->_moduleSysName . '/export', 'token=' . $this->session->data['token'],true);

			$this->data['breadcrumbs'] = array();
	
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
			);
			
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_view_log'),
				'href'      => $this->url->link('extension/module/' . $this->_moduleSysName . '/view_log', 'token=' . $this->session->data['token'], true),
			);
	
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}
			
			$limit = ($this->config->get('config_admin_limit'))?$this->config->get('config_admin_limit'):50;
			$filer_data = array(
				'limit' => $limit,
				'page' => $page,
				'start'  => ($page - 1) * $limit,
			);
			$this->load->model('extension/module/' . $this->_moduleSysName);
			
			$total = $this->registry->get('model_extension_module_' . $this->_moduleSysName )->getTotalRecords($filer_data);
				
			$this->data['results'] = $this->registry->get('model_extension_module_' . $this->_moduleSysName )->getRecords($filer_data);
			
			$url = '';
	
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
	
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->error['warning'])) {
				$this->data['error_warning'] = $this->error['warning'];
			} else {
				$this->data['error_warning'] = '';
			}

			$this->data['token'] = $this->session->data['token'];

			$this->data['total_banners'] = $this->registry->get('model_extension_module_' . $this->_moduleSysName )->getTotalBannerLinks();

			$pagination = new Pagination();
			$pagination->total = $total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('extension/module/'. $this->_moduleSysName . '/view_log', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);
			$this->data['pagination'] = $pagination->render();
			$this->data['result'] = sprintf($this->language->get('text_pagination'), ($total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($total - $limit)) ? $total : ((($page - 1) * $limit) + $limit), $total, ceil($total / $limit));
		
			$this->data['header'] = $this->load->controller('common/header');
			$this->data['column_left'] = $this->load->controller('common/column_left');
			$this->data['footer'] = $this->load->controller('common/footer');
			$this->response->setOutput($this->load->view('tool/' . $this->_moduleSysName, $this->data));
		} else {
			$this->response->redirect($this->url->link('extension/module/' . $this->_moduleSysName, 'token=' . $this->session->data['token'], true));
		}
	}
	
  public function delete_rule() {
		$this->language->load('extension/module/' . $this->_moduleSysName);
		if ($this->validate()) {
			
			$this->response->redirect($this->url->link('extension/module/' . $this->_moduleSysName . '/view_redirect', 'token=' . $this->session->data['token'], true));
		}
	}

  public function view_redirect() {
		$this->language->load('extension/module/' . $this->_moduleSysName);
		$this->data = $this->language->all();
		$this->document->setTitle($this->language->get('heading_redirect'));		
		
		if ($this->validate_()) {

			$this->data['token'] = $this->session->data['token'];
			$this->data['delete'] = $this->url->link('extension/module/' . $this->_moduleSysName . '/delete_rule', 'token=' . $this->session->data['token'], true);
			$this->data['settings'] = $this->url->link('extension/module/' . $this->_moduleSysName , 'token=' . $this->session->data['token'], true);

			$this->data['breadcrumbs'] = array();
	
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
			);
			
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_view_log'),
				'href'      => $this->url->link('extension/module/' . $this->_moduleSysName . '/view_redirect', 'token=' . $this->session->data['token'], true),
			);
	
			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}
			
			$limit = ($this->config->get('config_admin_limit'))?$this->config->get('config_admin_limit'):50;
			$filer_data = array(
				'limit' => $limit,
				'page' => $page,
				'start'  => ($page - 1) * $limit,
			);
			$this->load->model('extension/module/' . $this->_moduleSysName);
			
			$total = $this->registry->get('model_extension_module_' . $this->_moduleSysName )->getTotalRules($filer_data);
				
			$this->data['results'] = $this->registry->get('model_extension_module_' . $this->_moduleSysName )->getRules($filer_data);
			
			$url = '';
	
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
	
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->error['warning'])) {
				$this->data['error_warning'] = $this->error['warning'];
			} else {
				$this->data['error_warning'] = '';
			}

			$pagination = new Pagination();
			$pagination->total = $total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('extension/module/'. $this->_moduleSysName . '/view_log', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);
			$this->data['pagination'] = $pagination->render();
			$this->data['result'] = sprintf($this->language->get('text_pagination'), ($total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($total - $limit)) ? $total : ((($page - 1) * $limit) + $limit), $total, ceil($total / $limit));
		
			$this->data['header'] = $this->load->controller('common/header');
			$this->data['column_left'] = $this->load->controller('common/column_left');
			$this->data['footer'] = $this->load->controller('common/footer');
			$this->response->setOutput($this->load->view('tool/' . $this->_moduleSysName . '_redirect.tpl', $this->data));
		} else {
			$this->response->redirect($this->url->link('extension/module/' . $this->_moduleSysName, 'token=' . $this->session->data['token'], true));
		}
	}
	
  public function clear() {
      $this->load->model('extension/module/' . $this->_moduleSysName);
      $this->registry->get("model_extension_module_" . $this->_moduleSysName )->clear();
			$this->response->redirect($this->url->link('extension/module/' . $this->_moduleSysName . '/view_log', 'token=' . $this->session->data['token'], true));
  } 

  public function checkBanners() {
  	$json = array();
  	$this->language->load('extension/module/' . $this->_moduleSysName);
  	$this->load->model('extension/module/' . $this->_moduleSysName);

  	if (isset($this->request->get['start'])) { 
  		$start = $this->request->get['start'];
  	} else {
  		$start = 0;
  	}

  	if (isset($this->request->get['limit'])) { 
  		$limit = $this->request->get['limit'];
  	} else {
  		$limit = 50;
  	}

  	$json['results'] = $this->registry->get('model_extension_module_' . $this->_moduleSysName )->getBannerLinks($start, $limit);

  	$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
  }

	public function export() {
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate_()) {
			$this->load->model('extension/module/' . $this->_moduleSysName);
			
			$total = $this->registry->get('model_extension_module_' . $this->_moduleSysName )->getTotalRecords();
			$filer_data = array(
				'limit' => $total,
				'page' => 0,
				'start'  => 0,
			);
				
			$this->data['results'] = $this->registry->get('model_extension_module_' . $this->_moduleSysName )->getRecords($filer_data);
			
			header("Content-Type: text/csv");
			header("Content-Disposition: attachment; filename=not_found-".date('d-m-Y').".csv");
			header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
			header("Pragma: no-cache"); // HTTP 1.0
			header("Expires: 0"); // Proxies
		 	$output = fopen("php://output", "w"); 
			foreach($this->data['results']as $csv_data) {
				$csv = array(
					'ip' 			=> $csv_data['ip'],
					'browser' 		=> $csv_data['browser'],
					'request_uri' 	=> $csv_data['request_uri'],
					'referer' 		=> $csv_data['referer'],
					'date_record' 	=> $csv_data['date_record'],
				);
				fputcsv($output, $csv, ';', '"'); // here you can change delimiter/enclosure
			}
			fclose($output);
		} 
	}

  public function install(){
      $this->load->model('extension/module/' . $this->_moduleSysName);
      $this->registry->get('model_extension_module_' . $this->_moduleSysName)->install();
  }

  public function uninstall(){
      $this->load->model('extension/module/' . $this->_moduleSysName);
      $this->registry->get('model_extension_module_' . $this->_moduleSysName)->uninstall();
  }

}
