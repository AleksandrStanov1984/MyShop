<?php
/**
 * iScroller 1.2.1, September 20, 2017
 * Copyright 2014-2017 Igor Bukin / egozza88@gmail.com
 * License: Commercial. Reselling of this software or its derivatives is not allowed. You may use this software for one website ONLY including all its subdomains if the top level domain belongs to you and all subdomains are parts of the same OpenCart store.
 * Support: oc.iscroller@gmail.com
 */
class ControllerExtensionModuleIscroller extends Controller 
{
    private $_data = array('error_warning' => false, 'success' => false);

    private $_defaultSettings = array(
        'infScroll' => array(
            'enabled' => 1,
            'showSeparator' => 1,
            'minDistToBottom' => 100,
            'containerSelector' => '#content .row:nth-last-of-type(2)',
            'paginatorSelector' => '#content .row:nth-last-of-type(1)',
            'itemSelector' => '.product-layout',
            'debugMode' => 0,
            'loadingMode' => 'auto',
            'animation' => 0,
            'statefulScroll' => 1,
            'show_btn_after' => 3,
            'customJsCode' => '',
            'customCssCode' => '',
            'domObserverEnabled' => 1,
        ),
        'scrollTop' => array(
            'enabled' => 0,
            'position' => 'left',
            'fitTo' => '',
            'barColor' => 'rgba(198, 198, 198, 0.25)',
            'arrowColor' => 'rgba(49, 49, 49, 0.8)',
            'speed' => 500,
            'minWidthToShow' => 0,
            'minWidthToShowAsBar' => 0,
        ),
    );
    
    public function index()
    {
        $this->load->model('extension/module');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->request->post = $this->specialCharsFix($this->request->post);
            $post = $this->request->post['iscroller_module'];
			if (!isset($this->request->get['module_id']) || empty($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('iscroller', $post);
                $moduleId = $this->db->getLastId();
			} else {
                $moduleId = $this->request->get['module_id'];
				$this->model_extension_module->editModule($moduleId, $post);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			if ($this->request->post['action'] == 'apply') {
                $this->response->redirect($this->url->link('extension/module/iscroller', 'token=' . $this->session->data['token'] . '&module_id=' . $moduleId, 'SSL'));
            } else {
                $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
            }
		}
        if (isset($this->session->data['success'])) {
			$this->_data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		}
        
        $isMijoShop = class_exists('MijoShop') && defined('JPATH_MIJOSHOP_OC');
        if ($isMijoShop) {
            MijoShop::get('base')->addHeader(JPATH_MIJOSHOP_OC . 'view/javascript/tinycolor.js', false);
            MijoShop::get('base')->addHeader(JPATH_MIJOSHOP_OC . 'view/javascript/bootstrap.colorpickersliders.min.js', false);
        } else {
            $this->document->addScript('view/javascript/tinycolor.js');
            $this->document->addScript('view/javascript/bootstrap.colorpickersliders.min.js');
        }
        $this->document->addStyle('view/stylesheet/bootstrap.colorpickersliders.min.css');
        
        $this->_defaultSettings = $this->adjustSettingsForTheme($this->_defaultSettings);
        
        if (isset($this->request->post['iscroller'])) {
            $this->_data['settings'] = $this->request->post['iscroller'];
        } elseif (isset($this->request->get['module_id'])) {
            $this->_data['settings'] = $this->model_extension_module->getModule($this->request->get['module_id']);
        } else {
            $this->_data['settings'] = $this->_defaultSettings;
        }
        $this->_data['settings'] = $this->mergeSettings($this->_data['settings'], $this->_defaultSettings);
        
        $lang = $this->load->language('extension/module/iscroller');
        $this->document->setTitle($this->language->get('heading_title_adv'));
        if (count($lang)) {
            foreach ($lang as $var => $val) {
                $this->_data['lang_' . $var] = $val;
            }
        }
        $this->_data['text_yes'] = $this->language->get('text_yes');
        $this->_data['text_no']  = $this->language->get('text_no');
        $this->_data['button_cancel'] = $this->language->get('button_cancel');
        
        
        $this->_data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->_data['breadcrumbs'][] = array(
			'text' => $this->language->get('modules'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->_data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title_adv'),
			'href' => $this->url->link('extension/module/iscroller', 'token=' . $this->session->data['token'], 'SSL')
		);
        $this->_data['moduleId'] = isset($this->request->get['module_id']) ? $this->request->get['module_id'] : 0;

		$this->_data['action'] = $this->url->link('extension/module/iscroller', 'token=' . $this->session->data['token'] . '&module_id=' . $this->_data['moduleId'], 'SSL');

		$this->_data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL');
        
		$this->_data['mod_refresh_action'] = $this->url->link('module/iscroller/modRefreshTrigger', 'token=' . $this->session->data['token'], 'SSL');
        
		$this->_data['filemanager_route'] = $this->url->link('common/filemanager', 'token=' . $this->session->data['token'] . '&target=loader-img&thumb=thumb-image', 'SSL');
        $this->_data['catalog'] = $this->config->get('config_secure') ? HTTPS_CATALOG : HTTP_CATALOG;
        
        $this->load->model('localisation/language');
		
		$this->_data['languages'] = $this->model_localisation_language->getLanguages();
        
        $this->_data['header'] = $this->load->controller('common/header');
		$this->_data['column_left'] = $this->load->controller('common/column_left');
		$this->_data['footer'] = $this->load->controller('common/footer');
        
        $this->response->setOutput($this->load->view('extension/module/iscroller.tpl', $this->_data));
    }
    
	protected function validate() {
        $this->load->language('extension/module/iscroller');
        $hasAccess = $this->user->hasPermission('modify', 'extension/module/iscroller');
		if (!$hasAccess) {
			$this->_data['error_warning'] = $this->language->get('error_permission');
		}
		return $hasAccess;
	}
    
    protected function mergeSettings($set, $defSet) {
        if (!isset($set['infScroll'])) {
            $set['infScroll'] = array();
        }
        if (!isset($set['scrollTop'])) {
            $set['scrollTop'] = array();
        }
        foreach ($defSet['infScroll'] as $k => $v) {
            if (!isset($set['infScroll'][$k])) {
                $set['infScroll'][$k] = $v;
            }
        }
        foreach ($defSet['scrollTop'] as $k => $v) {
            if (!isset($set['scrollTop'][$k])) {
                $set['scrollTop'][$k] = $v;
            }
        }
        return $set;
    }
    protected function specialCharsFix($param) {
        if (is_array($param)) {
            foreach ($param as $k => $v) {
                $param[$k] = $this->specialCharsFix($v);
            }
            return $param;
        } else {
            return htmlspecialchars_decode($param);
        }
    }
    
    protected function adjustSettingsForTheme($settings) {
        if ( preg_match('/^journal/i', $this->config->get('config_template')) ) {
            $settings['infScroll']['containerSelector'] = '.main-products.product-list, .main-products.product-grid';
            $settings['infScroll']['paginatorSelector'] = '.pagination';
            $settings['infScroll']['itemSelector'] = '.main-products.product-list>div, .main-products.product-grid>div';
        } elseif ( preg_match('/^megashop/i', $this->config->get('config_template')) ) {
            $settings['infScroll']['containerSelector'] = '.products-block ';
            $settings['infScroll']['paginatorSelector'] = '.paginations';
            $settings['infScroll']['itemSelector'] = '.products-block > .row';
        }
        
        return $settings;
    }
    
    public function install()
    {
        // automatic installation of OCMOD modification
        $this->_uninstallModification();
        $this->_installModification();
    }
    
    public function uninstall()
    {
        $this->_uninstallModification();
    }
    
    /**
     * enable/disable OCMOD modification
     * The method triggers the refresh function (extension/modification/refresh)
     * 
     */
    public function modRefreshTrigger()
    {
        $this->load->model('extension/modification');
		if (method_exists($this->model_extension_modification, 'getModificationByCode')) {
            $mod = $this->model_extension_modification->getModificationByCode('iScroller');
        } else {
            $mod = $this->_getModificationByName('iScroller');
        }
        $enable = $this->request->post['enable'] === 'true';
        if ($mod && (bool)$mod['status'] !== $enable) {
            $modId = $mod['modification_id'];
            if ($enable) {
                $this->model_extension_modification->enableModification($modId);
            } else {
                $this->model_extension_modification->disableModification($modId);
            }
            $this->response->redirect($this->url->link('extension/modification/refresh', 'token=' . $this->session->data['token'], 'SSL'));
        }
    }
    
    protected function _installModification()
    {
        $author  = 'Igor Bukin';
        $extName = 'iScroller';
        
        $xml = '<?xml version="1.0" encoding="utf-8"?>'
             . '<modification>'
             . '<id>' . $extName . '</id>'
             . '<name>' . $extName . '</name>'
             . '<code>19864</code>'
             . '<version>1.2.1</version>'
             . '<author>' . $author . '</author>'
             . '<file path="catalog/controller/product/{category,manufacturer,search,special}*.php">'
             . '<operation>'
             . '<search><![CDATA[$product_total =]]></search>'
             . '<add position="before">'
             . '<![CDATA['
             . '/* iScroller modification start */' . "\n"
             . 'if (isset($this->request->get["xpage"])) {' . "\n"
             . '$filter_data["start"] = 0;' . "\n"
             . '$filter_data["limit"] = $limit * $this->request->get["xpage"];' . "\n"
             . '}' . "\n"
             . '/* iScroller modification end */'
             . ']]>'
             . '</add>'
             . '</operation>'
             . '</file>'
             . '</modification>';
        
        $data = array(
            'name' => $extName,
            'code' => VERSION === '2.0.0.0' ? $xml : $extName,
            'author' => $author,
            'version' => '1.2.1',
            'xml' => $xml,
            'link' => '',
            'status' => '0',
        );
        
        $this->load->model('extension/modification');
        $this->model_extension_modification->addModification($data);
    }
    
    protected function _uninstallModification()
    {
        $this->load->model('extension/modification');
        if (method_exists($this->model_extension_modification, 'getModificationByCode')) {
            $mod = $this->model_extension_modification->getModificationByCode('iScroller');
        } else {
            $mod = $this->_getModificationByName('iScroller');
        }
        if (isset($mod['modification_id'])) {
            $this->model_extension_modification->deleteModification($mod['modification_id']);
        }
    }
    
    /**
     * The method is designed for compatibility with OpenCart 2.0.0.0
     * 
     * @param string $code
     * @return mixed
     */
    public function _getModificationByName($name) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "modification WHERE name = '" . $this->db->escape($name) . "'");

		return $query->row;
	}	
}