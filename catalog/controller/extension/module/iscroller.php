<?php
/**
 * iScroller 1.2.1, September 20, 2017
 * Copyright 2014-2017 Igor Bukin / egozza88@gmail.com
 * License: Commercial. Reselling of this software or its derivatives is not allowed. You may use this software for one website ONLY including all its subdomains if the top level domain belongs to you and all subdomains are parts of the same OpenCart store.
 * Support: oc.iscroller@gmail.com
 */
class ControllerExtensionModuleIscroller extends Controller 
{
    protected $_data = array();
    
    public function index($settings) 
    {
        $isMijoShop = class_exists('MijoShop') && defined('JPATH_MIJOSHOP_OC');
        
        $jsPath = 'catalog/view/javascript/';
        
        if ($isMijoShop) {
            $jsPath = JPATH_MIJOSHOP_OC . '/' . $jsPath;
            MijoShop::get('base')->addHeader($jsPath . "oc-iscroller.js", false);
        } else {
            $this->document->addScript($jsPath . 'oc-iscroller.js');
        }
        if(file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/oc-iscroller.css')) {
        	$theme = $this->config->get('config_template');
    	}else{
    		$theme = 'default';
    	}
        $this->document->addStyle("catalog/view/theme/$theme/stylesheet/oc-iscroller.css");
        
        $lang = $this->session->data['language'];
        
        $settings['infScroll']['buttonLabel'] = $settings['infScroll']['buttonLabel'][$lang];
        $settings['infScroll']['loadingMsg'] = $settings['infScroll']['loadingMsg'][$lang];
        $settings['infScroll']['finishMsg'] = $settings['infScroll']['finishMsg'][$lang];
        
        $settings['infScroll']['curPage'] = isset($this->request->get['xpage']) ? $this->request->get['xpage'] : 1;
        $settings['infScroll']['offsetTop'] = isset($this->request->get['xoffset']) ? $this->request->get['xoffset'] : 0;
        if (!empty($settings['infScroll']['customGif'])) {
            $configUrl = $this->config->get($this->request->server['HTTPS'] ? 'config_ssl' : 'config_url');
            $settings['infScroll']['customGif'] = $configUrl . 'image/' . $settings['infScroll']['customGif'];
        }
        
        $this->_data['settings'] = $settings;
        
        if (version_compare(VERSION, '2.2.0.0', '>=')) {
            return $this->load->view('extension/module/iscroller', $this->_data);
        } else {
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/extension/module/iscroller.tpl')) {
                return $this->load->view($this->config->get('config_template') . '/template/extension/module/iscroller.tpl', $this->_data);
            } else {
                return $this->load->view('default/template/extension/module/iscroller.tpl', $this->_data);
            }
        }
    }
}