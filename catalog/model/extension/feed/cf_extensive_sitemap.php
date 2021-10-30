<?php

/**
 * Class ModelExtensionFeedCfExtensiveSitemap
 * @property DB db
 * @property Cache cache
 */
class ModelExtensionFeedCfExtensiveSitemap extends Model
{
    public function getCountProducts()
    {
        $count = $this->cache->get('cfes.count_products');
        if (!$count) {
            $count = (int)$this->db->query("
                SELECT COUNT(product_id) as `count`
                FROM oc_product op 
                WHERE op.date_available <= NOW()
                AND op.status = 1
            ")->row['count'];
            $this->cache->set('cfes.count_products', $count);
        }
        return $count;
    }

    public function getProductsPool(int $limit = null, int $page = null)
    {
        $pool = $this->cache->get("cfes.products_pool.{$limit}.{$page}");
        if (!$pool) {
            if (!is_null($limit)) {
                $limit = "LIMIT {$limit}";
            }
            $offset = "";
            if (!is_null($page)) {
                $offset = $page * $limit;
                $offset = "OFFSET {$offset}";
            }
            $pool = $this->db->query("
                SELECT op.product_id, op.date_modified
                FROM oc_product op 
                WHERE op.date_available <= NOW()
                AND op.status = 1
                {$limit} {$offset}
            ")->rows;
            $this->cache->set("cfes.products_pool.{$limit}.{$page}", $pool);
        }
        $product_id = array_column($pool, "product_id");
        array_multisort($product_id, SORT_ASC|SORT_NATURAL, $pool);
        return $pool;
    }
}