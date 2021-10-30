<?php
class Url {
    private $url;
    private $ssl;

	// SEO langmark vars
	private $langmark_registry = Array();
	// End of SEO langmark vars
    

	// SEO CMS vars
	private $sc_registry = Array();
	// End of SEO CMS vars
    
    private $rewrite = array();

    // fix prefix url

    public function __construct($url, $ssl = '') {
		// SEO langmark code
		if (is_callable(array($this->langmark_registry, 'get')) && $this->langmark_registry->get('controller_record_langmark')) {
			$url = $this->langmark_registry->get('controller_record_langmark')->after($url);
		}
		// End SEO langmark code
        if (is_bool($url)) { // opencart 2.2
            $this->url = '';
            $this->ssl = $url;
        } else {
            $this->url = $url;
            $this->ssl = $ssl;
        }
    }


 	// SEO CMS function
 	public function seocms_setRegistry($registry) {
		$this->sc_registry = $registry;
	}
	// End of SEO CMS function
    

 	// SEO langmark function
 	public function langmark_setRegistry($registry) {
		$this->langmark_registry = $registry;
	}
	// End of SEO langmark function
    
    public function addRewrite($rewrite) {
		// SEO CMS code
		if (is_callable(array($this->sc_registry, 'get'))) {
			$this->sc_registry->get('controller_record_url')->before($rewrite);
		}
		// End of SEO CMS code
        $this->rewrite[] = $rewrite;
    }

    public function link($route, $args = '', $connection = '') {
        // SIMPLE START
        global $config;

        if (!empty($config) && method_exists($config, 'get') && $config->get('simple_settings')) {
            $get_route = isset($_GET['route']) ? $_GET['route'] : (isset($_GET['_route_']) ? $_GET['_route_'] : '');

            if ($config->get('simple_replace_cart') && $route == 'checkout/cart' && $get_route != 'checkout/cart') {
                $connection = 'SSL';
                $route = 'checkout/simplecheckout';
            }

            if ($config->get('simple_replace_checkout') && $route == 'checkout/checkout' && $get_route != 'checkout/checkout') {
                $route = 'checkout/simplecheckout';
            }

            if ($config->get('simple_replace_register') && $route == 'account/register' && $get_route != 'account/register') {
                $route = 'account/simpleregister';
            }

            if ($config->get('simple_replace_edit') && $route == 'account/edit' && $get_route != 'account/edit') {
                $route = 'account/simpleedit';
            }

            if ($config->get('simple_replace_address') && $route == 'account/address/update' && $get_route != 'account/address/update') {
                $route = 'account/simpleaddress/update';
            }

            if ($config->get('simple_replace_address') && $route == 'account/address/insert' && $get_route != 'account/address/insert') {
                $route = 'account/simpleaddress/insert';
            }

            if ($config->get('simple_replace_address') && $route == 'account/address/edit' && $get_route != 'account/address/edit') {
                $route = 'account/simpleaddress/update';
            }

            if ($config->get('simple_replace_address') && $route == 'account/address/add' && $get_route != 'account/address/add') {
                $route = 'account/simpleaddress/insert';
            }
        }
        // SIMPLE END

        if (empty($this->url)) {
            if ($this->ssl && $connection) {
                $url = 'https://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/.\\') . '/index.php?route=' . $route;
            } else {
                $url = 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/.\\') . '/index.php?route=' . $route;
            }
        } else {
            if ($this->ssl && $connection) {
                $url = $this->ssl;
            } else {
                $url = $this->url;
            }

            $url .= 'index.php?route=' . $route;
        }

        if ($args) {
            if (is_array($args)) {
                $url .= '&amp;' . http_build_query($args);
            } else {
                $url .= str_replace('&', '&amp;', '&' . ltrim($args, '&'));
            }
        }

        foreach ($this->rewrite as $rewrite) {
          $url = $rewrite->rewrite($url);
        }


		// SEO CMS code
		if (is_callable(array($this->sc_registry, 'get'))) {
			$url = $this->sc_registry->get('controller_record_url')->after($url);
		}
		//End of SEO CMS code
    

		// SEO langmark code
		if (is_callable(array($this->langmark_registry, 'get')) && $this->langmark_registry->get('controller_record_langmark')) {
			$url = $this->langmark_registry->get('controller_record_langmark')->after($url);
		}
		//End of SEO langmark code
    
        return $url;
    }
}
?>