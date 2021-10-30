<?php
/*
 *  Cache Module
 */
if(!defined("SEOSHIELD_ROOT_PATH"))define("SEOSHIELD_ROOT_PATH",rtrim(realpath(dirname(__FILE__)),"/"));

class SeoShieldModule_bot_cache extends SeoShieldModule
{
    private $cacheDir = SEOSHIELD_ROOT_PATH.'/data/html_cache/';
    private $cacheFilePath = '';
    private $createCache = false;
    private $userAgents = array('chrome-lighthouse', 'bot');
    private $maxCacheLifetime = 108000;

    public function __construct()
    {
        if (isset($GLOBALS['SEOSHIELD_CONFIG']['bot_cache'])){
            if (isset($GLOBALS['SEOSHIELD_CONFIG']['bot_cache']['user_agent_selectors']) && is_array($GLOBALS['SEOSHIELD_CONFIG']['bot_cache']['user_agent_selectors']) && !empty($GLOBALS['SEOSHIELD_CONFIG']['bot_cache']['user_agent_selectors'])){
                $this->$userAgents = $GLOBALS['SEOSHIELD_CONFIG']['bot_cache']['user_agent_selectors'];
            }
            if (isset($GLOBALS['SEOSHIELD_CONFIG']['bot_cache']['cache_dir']) && is_array($GLOBALS['SEOSHIELD_CONFIG']['bot_cache']['cache_dir']) && !empty($GLOBALS['SEOSHIELD_CONFIG']['bot_cache']['cache_dir'])){
                $this->$cacheDir = $GLOBALS['SEOSHIELD_CONFIG']['bot_cache']['cache_dir'];
            }
            if (isset($GLOBALS['SEOSHIELD_CONFIG']['bot_cache']['max_cache_lifetime']) && is_array($GLOBALS['SEOSHIELD_CONFIG']['bot_cache']['cache_dir']) && !empty($GLOBALS['SEOSHIELD_CONFIG']['bot_cache']['max_cache_lifetime'])){
                $this->$maxCacheLifetime = $GLOBALS['SEOSHIELD_CONFIG']['bot_cache']['max_cache_lifetime'];
            }
        }
    }

    function start_cms()
    {
        $user_agent = mb_strtolower($_SERVER["HTTP_USER_AGENT"], 'utf-8');
        if (preg_match('#('.implode('|', $this->userAgents).')#', $user_agent) && (!isset($_SERVER['HTTP_CF_IPCOUNTRY']) || (isset($_SERVER['HTTP_CF_IPCOUNTRY']) && $_SERVER['HTTP_CF_IPCOUNTRY'] != 'UA'))){
            $cachePath = $this->createCachePath($_SERVER["REQUEST_URI"]);
            $cacheFilePath = $this->cacheDir . $cachePath;
            if (file_exists($cacheFilePath) && time() - filemtime($cacheFilePath) < $this->maxCacheLifetime){
                $cacheContent = file_get_contents($cacheFilePath);
                $cacheContent = str_replace('</body>', '<!--ss_cached_page--></body>', $cacheContent);
                echo $cacheContent;
                exit();
            } else {
                $cacheDir = dirname($cacheFilePath);
                if (!is_dir($cacheDir)){
                    mkdir($cacheDir, 0777, true);
                }
                $this->cacheFilePath = $cacheFilePath;
                $this->createCache = true;
            }
        }
    }

    function html_out_buffer($out_html)
    {
        if ($this->createCache && !empty($this->cacheFilePath) && !$this->isBlockedByRobotsTxt($out_html)){
            file_put_contents($this->cacheFilePath, $out_html);
        }

        return $out_html;
    }

    private function isBlockedByRobotsTxt($out_html)
    {
        preg_match_all('#<meta[^>]*?name=[\'"]?robots[\'"]?[^>]+?>#s', $out_html, $robots_matches);
        if (isset($robots_matches[0]) && isset($robots_matches[0][0])) {
            $robots_tag = $robots_matches[0][0];
            preg_match('#content=[\'"]([^\'"]+)[\'"]#s', $robots_tag, $robots_content);
            if (isset($robots_content[1])) {
                if (strpos('noindex', $robots_content[1]) !== false){
                    return true;
                }
            }
        }
        return false;
    }

    private function createCachePath($uri){
        $md5 = md5($uri);
        $cachePath = implode('/', array(substr($md5, -6, -4), substr($md5, -4, -2), substr($md5, -2), $md5)).'.cache.gz';
        return $cachePath;
    }
}
