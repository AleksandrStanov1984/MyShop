<?php
class Response {
    private $headers = array();
    private $level = 0;
    private $output;

	//Jet Cache vars
	private $sc_registry = Array();
	//End of Jet Cache vars
    


 	public function seocms_setRegistry($registry) {
		$this->sc_registry = $registry;
	}

 	public function seocms_getHeaders() {
		return $this->headers;
	}
 	public function seocms_getOutput() {
		return $this->output;
	}
    
	public function addHeader($header) {
		$this->headers[] = $header;
	}

	public function redirect($url, $status = 302) {
		header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url), true, $status);
		exit();
	}

	public function setCompression($level) {
		$this->level = $level;
	}

	public function getOutput() {
		return $this->output;
	}

	public function setOutput($output) {
		$this->output = $output;
	}
  //new webp
    /*
    public function setOutput($output) {
        if( strpos( $_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false ) {
            $output = preg_replace('/\b.jpg\b/u', '.webp', $output);
            $output = preg_replace('/\b.png\b/u', '.webp', $output);
            $output = preg_replace('/\b.jpeg\b/u', '.webp', $output);
        }
        $this->output = $output;
    }
    */
    //new webp

	private function compress($data, $level = 0) {
		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false)) {
			$encoding = 'gzip';
		}

		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false)) {
			$encoding = 'x-gzip';
		}

		if (!isset($encoding) || ($level < -1 || $level > 9)) {
			return $data;
		}

		if (!extension_loaded('zlib') || ini_get('zlib.output_compression')) {
			return $data;
		}

		if (headers_sent()) {
			return $data;
		}

		if (connection_status()) {
			return $data;
		}

		$this->addHeader('Content-Encoding: ' . $encoding);

		return gzencode($data, (int)$level);
	}

	public function output() {

			if (is_callable(array($this->sc_registry, 'get')) && $this->output) {
            	if (defined('DIR_CATALOG')) {
            	} else {
	           		if (function_exists('agoo_cont')) {
		           		agoo_cont('record/pagination', $this->sc_registry);
						$this->output = $this->sc_registry->get('controller_record_pagination')->setPagination($this->output);
						unset($this->controller_record_pagintation);

	            		if ($this->sc_registry->get('config')->get('google_sitemap_blog_status')) {
		            		if (isset($this->sc_registry) && $this->sc_registry) {
		            			agoo_cont('record/google_sitemap_blog', $this->sc_registry);
		                		$this->output = $this->sc_registry->get('controller_record_google_sitemap_blog')->setSitemap($this->output);
		                	}
	                	}
                	}
                }
			}
    

		if (function_exists('agoo_cont') && is_callable(array($this->sc_registry, 'get')) && $this->output) {
            if (!defined('DIR_CATALOG')) {
            	$ascp_settings = $this->sc_registry->get('config')->get('ascp_settings');
				if (isset($ascp_settings) && $ascp_settings && $ascp_settings['langmark_widget_status']) {
		           	agoo_cont('record/langmark', $this->sc_registry);
					$this->output = $this->sc_registry->get('controller_record_langmark')->set_agoo_hreflang($this->output);
					$this->output = $this->sc_registry->get('controller_record_langmark')->shortcodes($this->output);
					unset($this->controller_record_langmark);
            	}
            }
		}
    
        if ($this->output) {
            if(isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/admin') === false && $_SERVER['REQUEST_METHOD'] === 'GET'){
                if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) || (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')){
                    if(file_exists('seoshield-client/main.php'))
                    {
                        include_once('seoshield-client/main.php');
                        if(function_exists('seo_shield_start_cms'))
                            seo_shield_start_cms();
                        if(function_exists('seo_shield_out_buffer'))
                            $this->output = seo_shield_out_buffer($this->output);
                    }
                }
            }

            if ($this->level) {
                $output = $this->compress($this->output, $this->level);
            } else {
                $output = $this->output;
            }

            if (!headers_sent()) {
                foreach ($this->headers as $header) {
                    header($header, true);
                }
            }

            echo $output;
        }
	}
}
