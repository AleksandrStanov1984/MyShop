<?php

/**
 * Class ControllerExtensionFeedCfExtensiveSitemap
 * @property Url url
 * @property Cache extensiveCache
 * @property Config config
 * @property Loader load
 * @property Request request
 * @property Response response
 * @property ModelExtensionFeedCfExtensiveSitemap model_extension_feed_cf_extensive_sitemap
 */
class ControllerExtensionFeedCfExtensiveSitemap extends Controller
{
    const DEFAULT_CHANGE_FREQ = "always";
    const DEFAULT_CHUNK_SIZE = 10000;
    protected $_changeFreq = null;
    protected $_chunkSize = null;
    protected $_siteindexNS = "xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
        xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd\"
        xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"";
    protected $_sitemapNS = "xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
         xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\"
         xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"";

    public function __construct($registry)
    {
        parent::__construct($registry);
        try {
            $this->debugState = isset($this->request->get['debug']);
            if (is_null($this->_changeFreq = $this->config->get(
                'cf_extensive_sitemap_change_freq'))) {
                $this->_changeFreq = static::DEFAULT_CHANGE_FREQ;
            }
            if (is_null($this->_chunkSize = $this->config->get('cf_extensive_sitemap_chunksize'))) {
                $this->_chunkSize = static::DEFAULT_CHUNK_SIZE;
            }
            $registry->set(
                'extensiveCache', new \Cache(
                    $this->config->get('cache_type'), (int)$this->config->get('cache_expire') * 5
                )
            );
            $this->load->model('extension/feed/cf_extensive_sitemap');
        } catch (\Throwable $e) {

            $this->response->addHeader('HTTP/1.1 503 Service Unavailable');
            $this->response->setOutput($e->getMessage());
            return false;
        }
    }

    public function index()
    {
        $output = $this->extensiveCache->get('cfes.sitemap.index-map');
        if (!$output) {
            if ((
                $count = $this->model_extension_feed_cf_extensive_sitemap->getCountProducts()
                ) > ceil($this->_chunkSize * 1.5)) {
                $output = $this->_chunks($count);
            } else {
                $output = $this->_pages();
            }
        }
        $this->response->addHeader('Content-Type: application/xml');
        $this->response->setOutput($output);
        return $output;
    }

    public function chunk()
    {
        try {
            $chunk = $this->request->get['chunk'];
            $size = $this->request->get['size'];
        } catch (\Throwable $e) {
            $this->response->addHeader('HTTP/1.1 400 Bad Request');
            $this->response->setOutput($e->getMessage());
            return false;
        }
        $output = $this->extensiveCache->get("cfes.sitemap.{$size}.{$chunk}");
        if (!$output) {
            $output = $this->_pages($size, $chunk);
            $this->extensiveCache->set("cfes.sitemap.{$size}.{$chunk}", $output);
        }
        $this->response->addHeader('Content-Type: application/xml');
        $this->response->setOutput($output);
        return $output;
    }

    /** Preparer */
    protected function _cleanUrl($url)
    {
        return $url;
    }

    protected function _chunks($count)
    {
        $sitemaps = [];
        for ($i = 1; $i <= ceil($count / $this->_chunkSize); $i++) {
            $pool = $this->extensiveCache->get("cfes.products_pool.{$i}");
            if (!$pool) {
                $pool = [
                    'product_ids' => array_column($this->model_extension_feed_cf_extensive_sitemap
                        ->getProductsPool($this->_chunkSize, $i), "product_id"),
                    'last_modify' => date('c'),
                ];
                $this->extensiveCache->get("cfes.products_pool.{$i}", $pool);
            }
            $sitemaps[] = [
                "loc" => $this->_cleanUrl($this->url->link(
                    'extension/feed/cf_extensive_sitemap/chunk',
                    "chunk={$i}&size={$this->_chunkSize}", true
                )),
                "lastmod" => $pool['last_modify'],
            ];
        }

        foreach ($sitemaps as $sitemap) {
            $output[] = "<sitemap><loc>{$sitemap['loc']}</loc><lastmod>{$sitemap['lastmod']}</lastmod></sitemap>";
        }
        $output = implode($output);
        return "<?xml version=\"1.0\" encoding=\"UTF-8\"?><sitemapindex {$this->_siteindexNS}>{$output}</sitemapindex>";
    }

    protected function _pages($size = null, $page = null)
    {
        $pool = $this->model_extension_feed_cf_extensive_sitemap->getProductsPool($size, $page);
        $output = [];
        foreach ($pool as $product) {
            $url = implode([
                "<loc>{$this->_cleanUrl(
                    $this->url->link("product/product", "product_id={$product["product_id"]}", true)
                )}</loc>",
                "<lastmod>".date("c", strtotime($product["date_modified"]))."</lastmod>",
                "<changefreq>{$this->_changeFreq}</changefreq>",
                "<priority>0.5</priority>",
            ]);
            $output[] = "<url>{$url}</url>";
        }
        $output = implode($output);
        return "<?xml version=\"1.0\" encoding=\"UTF-8\"?><urlset {$this->_sitemapNS}>{$output}</urlset>";
    }

    /** Generator */
    protected $debugState = false;

    protected function _debug(...$args)
    {
        if ($this->debugState) {
            print "<code><pre>";
            foreach ($args as $arg) {
                var_dump($arg);
            }
            print "</pre></code>";
        }
    }
}