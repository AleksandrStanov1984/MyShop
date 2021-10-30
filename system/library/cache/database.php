<?php
namespace Cache;
class Database {
    private static $_db;
    private $expire;
     
    /**
     * Constructor
     *
     * @param timestamp $expire Caching time in seconds
     */
    public function __construct($expire) {
        $this->expire = $expire;
        $this->initDbInstance();
    }
 
    /**
     * Helper method to create DB instance
     */
    private function initDbInstance() {
        if (is_null(static::$_db)) {
            static::$_db = new \DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
        }
    }
     
    /**
     * Fetch the value stored in cache by key
     *
     * @param string $key Cache Key
     *
     * @return mixed Value of cache key if found, boolean false otherwise  
     */
    public function get($key) {
        $query = static::$_db->query("SELECT * FROM `" . DB_PREFIX . "dbcache` WHERE `key` = '" . $key . "' AND `expire` >= '" . time() ."'");
         
        if ($query->num_rows) {
            return unserialize($query->row['value']);
        }
         
        return false;
    }
 
    /**
     * Set the cache value by key
     *
     * @param string $key    Cache Key
     * @param mixed  $value  Cache value
     */
    public function set($key, $value) {
        $this->delete($key);
        static::$_db->query("INSERT INTO " . DB_PREFIX . "dbcache SET `key` = '" . $key . "', `value` = '" . mysql_escape_string(serialize($value)) . "', `expire` = '" . (time() + $this->expire) . "'");
    }
 
    /**
     * Delete the value stored in cache by key
     *
     * @param string $key    Cache Key
     */
    public function delete($key) {
        static::$_db->query("DELETE FROM " . DB_PREFIX . "dbcache WHERE `key` = '".$key."'");
    }
}
