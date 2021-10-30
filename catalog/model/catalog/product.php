<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/dump.php'); //for debug only

class ModelCatalogProduct extends Model
{
    public function updateViewed($product_id)
    {
        $this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = (viewed + 1) WHERE product_id = '" . (int)$product_id . "'");
    }

    public function getProductVideos($product_id) {
        $product_video_data = array();

        $product_video_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_video WHERE product_id = '" . (int)$product_id . "' AND language_id = '".(int)$this->config->get('config_language_id')."' ORDER BY sort_order ASC");

        foreach ($product_video_query->rows as $product_video) {
            $product_video_data[] = array(
                'name'        => $product_video['name'],
                'video'       => $product_video['video']
            );
        }

        return $product_video_data;
    }

    public function getProduct($product_id) {
        $query = $this->db->query("SELECT DISTINCT *, cd.name AS category_name, IF(" . (int)$this->config->get('config_language_id') . " = 1, p.model, p.ukr_model) as model, pd.name AS name, p.image, p.brain_id,
		(SELECT md.name FROM " . DB_PREFIX . "manufacturer_description md WHERE md.manufacturer_id = p.manufacturer_id AND md.language_id = '" . (int)$this->config->get('config_language_id') . "') AS manufacturer,
		(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special,
		(SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') AS reward,
		(SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status,p.sort_order
		FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (p.product_id = p2c.product_id) LEFT JOIN " . DB_PREFIX . "category c ON (c.category_id = p2c.category_id)
		LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id)
		LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
		LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id)
		WHERE p.product_id = '" . (int)$product_id . "'
		AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'
		AND p.status = '1'
		AND p.date_available <= NOW()");

        if ($query->num_rows) {
            return array(
                'product_id' => $query->row['product_id'],
                'brain_id' => $query->row['brain_id'],
                'category_id' => $query->row['category_id'],
                'category_name' => $query->row['category_name'],
                'name' => $query->row['name'],
                'description' => $query->row['description'],
                'meta_title' => $query->row['meta_title'],
                'meta_h1' => $query->row['meta_h1'],
                'meta_description' => $query->row['meta_description'],
                'meta_keyword' => $query->row['meta_keyword'],
                'tag' => $query->row['tag'],
                'model' => $query->row['model'],
                'sku' => $query->row['sku'],
                'mpn' => $query->row['mpn'],
                'location' => $query->row['location'],
                'video' => $query->row['video'],
                'quantity' => $query->row['quantity'],
                'stock_status_id' => $query->row['stock_status_id'],
                'stock_status' => $query->row['stock_status'],
                'image' => $query->row['image'],
                'image_dod' => $query->row['image_dod'],
                'day_delivery' => $query->row['day_delivery'],
                'manufacturer_id' => $query->row['manufacturer_id'],
                'manufacturer' => $query->row['manufacturer'],
                'price_base' => $query->row['price_base'],
                'price' => $query->row['price'],
                'special' => $query->row['special'],
                'reward' => $query->row['reward'],
                'points' => $query->row['points'],
                'tax_class_id' => $query->row['tax_class_id'],
                'date_available' => $query->row['date_available'],
                'weight' => $query->row['weight'],
                'length' => $query->row['length'],
                'width' => $query->row['width'],
                'height' => $query->row['height'],
                'diameter_of_pot' => $query->row['diameter_of_pot'],
                'depth_of_pot' => $query->row['depth_of_pot'],
                'quantity_shelves' => $query->row['quantity_shelves'],
                'maximum_weight' => $query->row['maximum_weight'],
                'maximum_weight_all' => $query->row['maximum_weight_all'],
                'subtract' => $query->row['subtract'],
                'rating' => round($query->row['rating']),
                'reviews' => $query->row['reviews'] ? $query->row['reviews'] : 0,
                'minimum' => $query->row['minimum'],
                'sort_order' => $query->row['sort_order'],
                'visible_carusel' => $query->row['visible_carusel'],
                'status' => $query->row['status'],
                'date_added' => $query->row['date_added'],
                'date_modified' => $query->row['date_modified'],
                'viewed' => $query->row['viewed'],
                'pickup' => $query->row['pickup'],
                'courier' => $query->row['courier'],
            );
        } else {
            return false;
        }
    }

    public function getImageProductHeader($product_id){
        $query = $this->db->query("SELECT image FROM " . DB_PREFIX . "product WHERE product_id = '". (int)$product_id."'");
        if (isset($query->row['image'])){
            return $query->row['image'];
        }else{
            return false;
        }
    }

    public function searchProducts($data = [], $get_total_count = false)
    {

        $product_limit = 10;
        $limit = 10;

        $description_table = 'product_description';
        if ((int)$this->config->get('config_folder_search_active') and isset($data['config_folder_search_active'])) {
            $description_table = 'product_description_search';
        }
        /* Поиск с тремя Брендами!
        $sql = 'SELECT distinct(X.product_id), X.manufacturer_id, category_id, manuf FROM
                ( SELECT p.product_id, p.manufacturer_id, p.sku, p2c.category_id,
                        pd.name,
                        pd.description,
                        pd.tag,
                        pd.meta_title,
                        pd.meta_description,
                        pd.meta_keyword,
                        RANK()OVER(PARTITION BY p.manufacturer_id ORDER BY p.product_id) manuf
                FROM '.DB_PREFIX.'product p
                LEFT JOIN '.DB_PREFIX.'product_to_category p2c ON p2c.product_id = p.product_id AND p2c.main_category = 1
                LEFT JOIN '.DB_PREFIX.''.$description_table.' pd ON p.product_id = pd.product_id
                WHERE p.status = 1  #search_sql#
                ) X

                WHERE manuf <= '.$product_limit.' LIMIT '.$limit;
        */

        /* Запрос с категориями и брендами
        $sql = 'SELECT distinct(X.product_id), category_id, categ FROM
                ( SELECT p.product_id,
                        p.sku,
                        p2c.category_id,
                        pd.name,
                        pd.description,
                        pd.tag,
                        pd.meta_title,
                        pd.meta_description,
                        pd.meta_keyword,
                        RANK()OVER(PARTITION BY p2c.category_id ORDER BY p.product_id) categ
                FROM '.DB_PREFIX.'product p
                LEFT JOIN '.DB_PREFIX.'product_to_category p2c ON p2c.product_id = p.product_id AND p2c.main_category = 1
                LEFT JOIN '.DB_PREFIX.''.$description_table.' pd ON p.product_id = pd.product_id
                WHERE p.status = 1  #search_sql#
                ORDER BY p.sort_search DESC, pd.name
                ) X

                WHERE categ <= '.$product_limit.' LIMIT '.$limit;
        */

        $sql = 'SELECT distinct(p.product_id)
					FROM ' . DB_PREFIX . 'product p
					LEFT JOIN ' . DB_PREFIX . '' . $description_table . ' pd ON p.product_id = pd.product_id
					WHERE p.status = 1  #search_sql#
					ORDER BY p.sort_search DESC, pd.name
					LIMIT ' . $limit;


        $search_sql = '';

        if (!empty($data['filter_name'])) {
            if ((int)$this->config->get('config_folder_search_active') and isset($data['config_folder_search_active'])) {

                $this->load->model('catalog/folder_search');

                if ((int)$this->config->get('config_folder_search_name')) {
                    $search_sql .= " OR pd.name LIKE '" . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                    $search_sql .= " OR pd.name LIKE '% " . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                }
                if ((int)$this->config->get('config_folder_search_description')) {
                    $search_sql .= " OR pd.description LIKE '" . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                    $search_sql .= " OR pd.description LIKE '% " . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                }
                if ((int)$this->config->get('config_folder_search_tag')) {
                    $search_sql .= " OR pd.tag LIKE '" . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                    $search_sql .= " OR pd.tag LIKE '% " . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                }
                if ((int)$this->config->get('config_folder_search_meta_title')) {
                    $search_sql .= " OR pd.meta_title LIKE '" . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                    $search_sql .= " OR pd.meta_title LIKE '% " . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                }
                if ((int)$this->config->get('config_folder_search_meta_description')) {
                    $search_sql .= " OR pd.meta_description LIKE '" . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                    $search_sql .= " OR pd.meta_description LIKE '% " . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                }
                if ((int)$this->config->get('config_folder_search_meta_keyword')) {
                    $search_sql .= " OR pd.meta_keyword LIKE '" . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                    $search_sql .= " OR pd.meta_keyword LIKE '% " . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                }
            } else {

                if (is_numeric($data['filter_name'])) {
                    $search_sql .= " OR LCASE(p.sku) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                } else {
                    //$search_sql .= " OR LCASE(p.sku) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";

                    $search_sql .= " OR LCASE(pd.name) LIKE '%-" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
                    $search_sql .= " OR LCASE(pd.name) LIKE '% " . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
                    $search_sql .= " OR LCASE(pd.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";

                    $search_sql .= " OR LCASE(pd.tag) LIKE '% " . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
                    $search_sql .= " OR LCASE(pd.tag) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
                    $search_sql .= " OR LCASE(pd.tag) LIKE '%;" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
                }
            }
        }


        $sql = str_replace("#search_sql#", ' AND (' . ltrim($search_sql, ' OR') . ')', $sql);

        if ($get_total_count) {
            $cacheid = "catalog.product.search.count." . md5($sql) . '.' . (int)$this->config->get('config_language_id');
            $result = $this->cache->get($cacheid);
            if (!$result) {
                $query = $this->db->query($sql);
                $result = $query->num_rows;
                $this->cache->set($cacheid, $result);
            }
            return $result;
        }

        $cacheid = "catalog.product.search." . md5($sql . $limit) . '.' . (int)$this->config->get('config_language_id');
        $product_data = $this->cache->get($cacheid);

        if (!$product_data) {
            $product_data = array();
            $query = $this->db->query($sql);

            foreach ($query->rows as $result) {

                $product_info = $this->getProduct($result['product_id']);

                //Заменим главную категорию из категории поиска
                //$product_info['category_id'] = $result['category_id'];
                //$product_info['category_name'] = $this->getCategoryName($result['category_id']);

                $product_data[] = $product_info;
            }
            $this->cache->set($cacheid, $product_data);
        }
        return $product_data;

    }

    public function getCategoryName($category_id)
    {
        $query = $this->db->query("SELECT name FROM " . DB_PREFIX . "category_description cd
									WHERE cd.category_id = '" . (int)$category_id . "' AND
									cd.language_id = '" . (int)$this->config->get('config_language_id') . "'
									LIMIT 1");

        if ($query->num_rows > 0) {
            return $query->row['name'];
        } else {
            return '- - -';
        }
    }

    public function searchProducts1($data = [], $get_total_count = false)
    {
        $tps = [
            'dbp' => DB_PREFIX,
            'config_customer_group_id' => (int)$this->config->get('config_customer_group_id'),
            'config_language_id' => (int)$this->config->get('config_language_id'),
            'config_store_id' => (int)$this->config->get('config_store_id'),
        ];
//        $query = "
//			SELECT
//				p.product_id,
//				(	SELECT AVG(rating) AS total
//					FROM #dbp#review r1
//					WHERE r1.product_id = p.product_id AND r1.status = '1'
//					GROUP BY r1.product_id
//				) AS rating,
////				(	SELECT price
////					FROM #dbp#product_discount pd2
////					WHERE pd2.product_id = p.product_id
////						AND pd2.customer_group_id = '#config_customer_group_id#'
////						AND pd2.quantity = '1'
////						AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW())
////							AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())
////						)
////					ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1
////				) AS discount,
//				(	SELECT price
//					FROM #dbp#product_special ps
//					WHERE ps.product_id = p.product_id
//						AND ps.customer_group_id = '#config_customer_group_id#'
//						AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW())
//							AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())
//						)
//					ORDER BY ps.priority ASC, ps.price ASC LIMIT 1
//				) AS special
//				FROM #dbp#product p
//				LEFT JOIN #dbp#product_description pd ON (p.product_id = pd.product_id)
//				LEFT JOIN #dbp#product_to_store p2s ON (p.product_id = p2s.product_id)
//				LEFT JOIN #dbp#product_description_search pds ON (p.product_id = pds.product_id)
//				WHERE pd.language_id = '#config_language_id#' AND p.status = '1'
//					AND p.date_available <= NOW()
//					AND p2s.store_id = '#config_store_id#'
//					#where#
//				GROUP BY #groupby#
//				ORDER BY #orderby#
//";

        $query = "
			SELECT
				p.product_id,
				(	SELECT AVG(rating) AS total
					FROM #dbp#review r1
					WHERE r1.product_id = p.product_id AND r1.status = '1'
					GROUP BY r1.product_id
				) AS rating,
				(	SELECT price
					FROM #dbp#product_special ps
					WHERE ps.product_id = p.product_id
						AND ps.customer_group_id = '#config_customer_group_id#'
						AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW())
							AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())
						)
					ORDER BY ps.priority ASC, ps.price ASC LIMIT 1
				) AS special
				FROM #dbp#product p
				LEFT JOIN #dbp#product_description pd ON (p.product_id = pd.product_id)
				LEFT JOIN #dbp#product_to_store p2s ON (p.product_id = p2s.product_id)
				LEFT JOIN #dbp#product_description_search pds ON (p.product_id = pds.product_id)
				WHERE pd.language_id = '#config_language_id#' AND p.status = '1'
					AND p.date_available <= NOW()
					AND p2s.store_id = '#config_store_id#'
					#where#
				GROUP BY #groupby#
				ORDER BY #orderby#
";
        $where = "";
        $orderby = "";
        $groupby = "p.product_id";

        $this->load->model('catalog/folder_search');

        $sort_data = array(
            'pd.name',
            'p.model',
            'p.quantity',
            'p.price',
            'rating',
            'p.viewed',
            'p.sort_order',
            'p.date_added'
        );
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
                $orderby .= " LCASE(" . $data['sort'] . ")";
            } elseif ($data['sort'] == 'p.price') {
                $orderby .= " (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
            } else {
                $orderby .= " " . $data['sort'];
            }
        } else {
            $orderby .= " p.sort_order";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $orderby .= " DESC, LCASE(pd.name) DESC";
        } else {
            $orderby .= " ASC, LCASE(pd.name) ASC";
        }

        if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
            $filter_tag = "";
            $filter_name = "";
            $where .= " AND (";
            if (!empty($data['filter_name'])) {
                $implode = array();

                $words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

                foreach ($words as $word) {
                    $implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
                }
                if ($implode) {
                    $filter_name .= " " . implode(" AND ", $implode) . "";
                }
            }
            if (!empty($data['filter_tag'])) {
                $implode = array();

                $words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

                foreach ($words as $word) {
                    $implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
                }

                if ($implode) {
                    $filter_tag .= " " . implode(" AND ", $implode) . "";
                }
            }

            if (!empty($data['filter_name'])) {
                if ((int)$this->config->get('config_folder_search_active') and isset($data['config_folder_search_active'])) {

                    $this->load->model('catalog/folder_search');

                    if ((int)$this->config->get('config_folder_search_name')) {
                        $search_sql .= " OR pd.name LIKE '" . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                        $search_sql .= " OR pd.name LIKE '% " . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                    }
                    if ((int)$this->config->get('config_folder_search_description')) {
                        $search_sql .= " OR pd.description LIKE '" . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                        $search_sql .= " OR pd.description LIKE '% " . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                    }
                    if ((int)$this->config->get('config_folder_search_tag')) {
                        $search_sql .= " OR pd.tag LIKE '" . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                        $search_sql .= " OR pd.tag LIKE '% " . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                    }
                    if ((int)$this->config->get('config_folder_search_meta_title')) {
                        $search_sql .= " OR pd.meta_title LIKE '" . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                        $search_sql .= " OR pd.meta_title LIKE '% " . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                    }
                    if ((int)$this->config->get('config_folder_search_meta_description')) {
                        $search_sql .= " OR pd.meta_description LIKE '" . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                        $search_sql .= " OR pd.meta_description LIKE '% " . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                    }
                    if ((int)$this->config->get('config_folder_search_meta_keyword')) {
                        $search_sql .= " OR pd.meta_keyword LIKE '" . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                        $search_sql .= " OR pd.meta_keyword LIKE '% " . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%'";
                    }
                } else {

                    if (is_numeric($data['filter_name'])) {
                        $search_sql .= " OR LCASE(p.sku) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                    } else {
                        //$search_sql .= " OR LCASE(p.sku) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";

                        $search_sql .= " OR LCASE(pd.name) LIKE '% " . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
                        $search_sql .= " OR LCASE(pd.name) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";

                        $search_sql .= " OR LCASE(pd.tag) LIKE '% " . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
                        $search_sql .= " OR LCASE(pd.tag) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
                    }
                }
            }
            if (!empty($data['filter_description'])) {
                $filter_name .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
            }


            if ($filter_name && $filter_tag) {
                if (($data['filter_name'] === $data['filter_tag']) && (preg_replace('/[^\d*]/', '', $data['filter_tag']) === $data['filter_tag'])) {
                    $where .= " LCASE(p.sku) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
                    $orderby = "LENGTH(p.sku) ASC, p.sku ASC";
                } else {
                    $where .= "{$filter_name} OR {$filter_tag}";
                }
            }
            $where .= ") ";
        }
        $limit = "";
        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 1020;
            }

            $limit .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }


        $tps += compact('where', 'groupby', 'orderby');
        foreach ($tps as $key => $val) {
            $query = str_replace("#{$key}#", $val, $query);
        }


        if ($get_total_count) {
            $cacheid = "catalog.product.search." . md5($query) . '.' . (int)$this->config->get('config_language_id');
            $result = $this->cache->get($cacheid);
            if (!$result) {
                $query = $this->db->query($query);
                $result = $query->num_rows;
                $this->cache->set($cacheid, $result);
            }
            return $result;
        }

        $cacheid = "catalog.product.search." . md5($query . $limit) . '.' . (int)$this->config->get('config_language_id');
        $product_data = false;//$this->cache->get($cacheid);

        if (!$product_data) {
            $product_data = array();
            $query = $this->db->query($query . $limit);

            foreach ($query->rows as $result) {
                $product_data[] = $this->getProduct($result['product_id']);
            }
            $this->cache->set($cacheid, $product_data);
        }
        return $product_data;

    }

    public function getProducts($data = array())
    {
        $sql = "SELECT " . (empty($data['filter_name']) && empty($data['filter_ocfilter']) ? "IF(hpl.parent_id IS NOT NULL AND h2s.store_id IS NOT NULL AND hph.pid IS NOT NULL, hpl.parent_id, p.product_id) AS product_id" : "p.product_id") . ", (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' ORDER BY pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' ORDER BY ps.price ASC LIMIT 1) AS special";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
            } else {
                $sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
            }

            if (!empty($data['filter_filter'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
            } else {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
            }
        } else {
            $sql .= " FROM " . DB_PREFIX . "product p";
        }


        // OCFilter start
        if (!empty($data['filter_ocfilter'])) {
            $this->load->model('catalog/ocfilter');
            $ocfilter_product_sql = $this->model_catalog_ocfilter->getSearchSQL($data['filter_ocfilter']);
        } else {
            $ocfilter_product_sql = false;
        }

        if ($ocfilter_product_sql && $ocfilter_product_sql->join) {
            $sql .= $ocfilter_product_sql->join;
        }
        // OCFilter end

        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "hpmodel_product_hidden hph ON (p.product_id = hph.pid) LEFT JOIN " . DB_PREFIX . "hpmodel_links hpl ON (p.product_id = hpl.product_id) LEFT JOIN " . DB_PREFIX . "hpmodel_to_store h2s ON (hpl.type_id = h2s.type_id AND h2s.store_id = '" . (int)$this->config->get('config_store_id') . "') WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW()";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
            } else {
                $sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
            }

            if (!empty($data['filter_filter'])) {
                $implode = array();

                $filters = explode(',', $data['filter_filter']);

                foreach ($filters as $filter_id) {
                    $implode[] = (int)$filter_id;
                }

                $sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
            }
        }

        if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
            $sql .= " AND (";

            if (is_numeric($data['filter_name'])) {

                $sql .= "LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";

            } else {

                if (!empty($data['filter_name'])) {

                    $implode = array();

                    $words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

                    foreach ($words as $word) {
                        $implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
                    }

                    if ($implode) {
                        $sql .= " " . implode(" AND ", $implode) . "";
                    }

                    if (!empty($data['filter_description'])) {
                        $sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
                    }
                }

                if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
                    $sql .= " OR ";
                }

                if (!empty($data['filter_tag'])) {
                    $implode = array();

                    $words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

                    foreach ($words as $word) {
                        $implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
                    }

                    if ($implode) {
                        $sql .= " " . implode(" AND ", $implode) . "";
                    }
                }

                if (!empty($data['filter_name'])) {
                    $sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                    $sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                }

            }

            $sql .= ")";
        }

        // OCFilter start
        if (!empty($ocfilter_product_sql) && $ocfilter_product_sql->where) {
            $sql .= $ocfilter_product_sql->where;
        }
        // OCFilter end

        if (!empty($data['filter_manufacturer_id'])) {
            $sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
        }

        $sql .= " GROUP BY IF(hpl.parent_id IS NOT NULL AND h2s.store_id IS NOT NULL AND hph.pid IS NOT NULL, hpl.parent_id, p.product_id)";

        $sort_data = array(
            'pd.name',
            'p.model',
            'p.quantity',
            'p.price',
            'p.viewed',
            'p.sort_order',
            'p.date_added'
        );
//		if ($order_sku) {
//			$sql .= " ORDER BY LENGTH(p.sku), p.sku";
//		} else
        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
                $sql .= " ORDER BY (p.price <> 0) DESC, p.price <> 0 DESC, LCASE(" . $data['sort'] . ")";
            } elseif ($data['sort'] == 'p.price') {
                // $sql .= " ORDER BY (p.price <> 0) DESC, p.price <> 0 DESC, (p.sort_order > 100) ASC, (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
                $sql .= " ORDER BY (p.price <> 0) DESC, p.price <> 0 DESC, (p.sort_order > 100) ASC, (CASE WHEN special IS NOT NULL THEN special ELSE p.price END)";
            } elseif ($data['sort'] == 'p.viewed') {
                $sql .= " ORDER BY (p.price <> 0) DESC, p.price <> 0 DESC, p.sort_order ASC, p.viewed";
            } else {
                $sql .= " ORDER BY (p.price <> 0) DESC, p.price <> 0 DESC, (p.sort_order > 100) ASC, " . $data['sort'];
            }

            /*} elseif ($data['sort'] == 'p.price') {
                $sql .= " ORDER BY (p.price <> 0) DESC, p.price <> 0 DESC, (p.sort_order > 100) ASC, (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
            } elseif($data['sort'] == 'p.viewed') {
                $sql .= " ORDER BY (p.price <> 0) DESC, p.price <> 0 DESC, p.sort_order ASC, p.viewed";
            } else {
                $sql .= " ORDER BY (p.price <> 0) DESC, p.price <> 0 DESC, (p.sort_order > 100) ASC, " . $data['sort'];
            }*/
        } else {
            $sql .= " ORDER BY p.sort_order";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC, LCASE(pd.name) DESC";
        } else {
            $sql .= " ASC, LCASE(pd.name) ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $product_data = array();
//die( '<hr>'.$sql);
        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
        }

        return $product_data;
    }


    public function getProducts1($data = array())
    {
        $sql = "SELECT " . (empty($data['filter_name']) && empty($data['filter_ocfilter']) ? "IF(hpl.parent_id IS NOT NULL AND h2s.store_id IS NOT NULL AND hph.pid IS NOT NULL, hpl.parent_id, p.product_id) AS product_id" : "p.product_id") . ", (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";
        // $sql = "SELECT " . (empty($data['filter_name']) && empty($data['filter_ocfilter']) ? "IF(hpl.parent_id IS NOT NULL AND h2s.store_id IS NOT NULL AND hph.pid IS NOT NULL, hpl.parent_id, p.product_id) AS product_id" : "p.product_id") . ", (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";
        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
            } else {
                $sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
            }

            if (!empty($data['filter_filter'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
            } else {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
            }
        } else {
            $sql .= " FROM " . DB_PREFIX . "product p";
        }
        $this->load->model('catalog/folder_search');
        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description_search pds ON (p.product_id = pds.product_id) ";

        // OCFilter start
        if (!empty($data['filter_ocfilter'])) {
            $this->load->model('catalog/ocfilter');

            $ocfilter_product_sql = $this->model_catalog_ocfilter->getSearchSQL($data['filter_ocfilter']);
        } else {
            $ocfilter_product_sql = false;
        }

        if ($ocfilter_product_sql && $ocfilter_product_sql->join) {
            $sql .= $ocfilter_product_sql->join;
        }
        // OCFilter end

        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "hpmodel_product_hidden hph ON (p.product_id = hph.pid) LEFT JOIN " . DB_PREFIX . "hpmodel_links hpl ON (p.product_id = hpl.product_id) LEFT JOIN " . DB_PREFIX . "hpmodel_to_store h2s ON (hpl.type_id = h2s.type_id AND h2s.store_id = '" . (int)$this->config->get('config_store_id') . "') WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

        if (isset($data['visible_carusel'])) {
            $sql .= " AND p.visible_carusel = '1' ";
        }

        if (isset($data['filter_sd_param']) && isset($data['filter_sd_value'])) {
            if ($data['filter_sd_param'] == 'slength') {
                $sql .= " AND p.length = '" . $data['filter_sd_value'] . "'";
            } elseif ($data['filter_sd_param'] == 'material') {
                $sql .= " AND p.material_shelves = '" . $data['filter_sd_value'] . "'";
            } elseif ($data['filter_sd_param'] == 'model') {
                $sql .= " AND p.model_selection = '" . $data['filter_sd_value'] . "'";
            } elseif ($data['filter_sd_param'] == 'color') {
                $sql .= " AND p.color_shelves = '" . $data['filter_sd_value'] . "'";
            } elseif ($data['filter_sd_param'] == 'weight') {
                $sql .= " AND p.maximum_weight = '" . $data['filter_sd_value'] . "'";
            } elseif ($data['filter_sd_param'] == 'thickness') {
                $sql .= " AND p.metal_thickness = '" . $data['filter_sd_value'] . "'";
            } elseif ($data['filter_sd_param'] == 'type') {
                $sql .= " AND p.type = '" . $data['filter_sd_value'] . "'";
            } elseif ($data['filter_sd_param'] == 'series') {
                $sql .= " AND p.series = '" . $data['filter_sd_value'] . "'";
            } elseif ($data['filter_sd_param'] == 'brand') {
                $sql .= " AND p.brand = '" . $data['filter_sd_value'] . "'";
            } elseif ($data['filter_sd_param'] == 'quantity_shelves') {
                $sql .= " AND p.quantity_shelves = '" . $data['filter_sd_value'] . "'";
            } else {
                $sql .= " AND p." . $data['filter_sd_param'] . " = '" . $data['filter_sd_value'] . "'";
            }

        }

        if (isset($data['height']) && $data['height'] != 0) {
            $sql .= " AND p.height = '" . (int)$data['height'] . "'";
        }

        if (isset($data['width']) && $data['width'] != 0) {
            $sql .= " AND p.width = '" . (int)$data['width'] . "'";
        }

        if (isset($data['length']) && $data['length'] != 0) {
            $sql .= " AND p.length = '" . (int)$data['length'] . "'";
        }

        if (isset($data['material_shelves']) && $data['material_shelves'] != '0') {
            $sql .= " AND p.material_shelves = '" . $data['material_shelves'] . "'";
        }

        if (isset($data['model_selection']) && $data['model_selection'] != '0') {
            $sql .= " AND p.model_selection = '" . $data['model_selection'] . "'";
        }

        if (isset($data['color_shelves']) && $data['color_shelves'] != '0') {
            $sql .= " AND p.color_shelves LIKE '" . $data['color_shelves'] . "'";
        }

        if (isset($data['maximum_weight']) && $data['maximum_weight'] != '0') {
            $sql .= " AND p.maximum_weight = '" . $data['maximum_weight'] . "'";
        }

        if (isset($data['metal_thickness']) && $data['metal_thickness'] != '0') {
            $sql .= " AND p.metal_thickness = '" . $data['metal_thickness'] . "'";
        }

        if (isset($data['type']) && $data['type'] != '0') {
            $sql .= " AND p.type = '" . $data['type'] . "'";
        }

        if (isset($data['series']) && $data['series'] != '0') {
            $sql .= " AND p.series = '" . $data['series'] . "'";
        }

        if (isset($data['brand']) && $data['brand'] != '0') {
            $sql .= " AND p.brand = '" . $data['brand'] . "'";
        }

        if (isset($data['quantity_shelves']) && $data['quantity_shelves'] != '0') {
            $sql .= " AND p.quantity_shelves = '" . $data['quantity_shelves'] . "'";
        }

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
            } else {
                $sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
            }

            if (!empty($data['filter_filter'])) {
                $implode = array();

                $filters = explode(',', $data['filter_filter']);

                foreach ($filters as $filter_id) {
                    $implode[] = (int)$filter_id;
                }

                $sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
            }
        }

        if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
            $sql .= " AND (";

            if (!empty($data['filter_name'])) {
                $implode = array();

                $words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

                foreach ($words as $word) {
                    $implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
                }

                if ($implode) {
                    if ((int)$this->config->get('config_folder_search_active')) {

                        if (!isset($data['config_folder_search_active'])) {
                            $sql .= "  " . implode(" AND ", $implode) . " ";
                        } else {

                            if ((int)$this->config->get('config_folder_search_name')) {
                                $sql .= " pds.name LIKE '%" . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%' OR";
                            }
                            if ((int)$this->config->get('config_folder_search_description')) {
                                $sql .= " pds.description LIKE '%" . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%' OR";
                            }
                            if ((int)$this->config->get('config_folder_search_tag')) {
                                $sql .= " pds.tag LIKE '%" . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%' OR";
                            }
                            if ((int)$this->config->get('config_folder_search_meta_title')) {
                                $sql .= " pds.meta_title LIKE '%" . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%' OR";
                            }
                            if ((int)$this->config->get('config_folder_search_meta_description')) {
                                $sql .= " pds.meta_description LIKE '%" . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%' OR";
                            }
                            if ((int)$this->config->get('config_folder_search_meta_keyword')) {
                                $sql .= " pds.meta_keyword LIKE '%" . implode('%', $this->model_catalog_folder_search->codeString($data['filter_name'])) . "%' OR";
                            }

                            $sql = trim($sql, 'OR');
                        }
                    } else {
                        $sql .= "  " . implode(" AND ", $implode) . " ";
                    }
                }

                if (!empty($data['filter_description'])) {
                    $sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
                }
            }

            if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
                $sql .= " OR ";
            }

            if (!empty($data['filter_tag'])) {
                $implode = array();

                $words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

                foreach ($words as $word) {
                    $implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
                }

                if ($implode) {
                    $sql .= "  " . implode(" AND ", $implode) . " ";
                }
            }

            if (!empty($data['filter_name'])) {
                $sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
            }

            $sql .= ")";
        }

        if (!empty($data['filter_manufacturer_id'])) {
            $sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
        }


        $sql .= " GROUP BY IF(hpl.parent_id IS NOT NULL AND h2s.store_id IS NOT NULL AND hph.pid IS NOT NULL, hpl.parent_id, p.product_id)";

        $sort_data = array(
            'pd.name',
            'p.model',
            'p.quantity',
            'p.price',
            'rating',
            'p.viewed',
            'p.sort_order',
            'p.date_added'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
                $sql .= " ORDER BY p.sort_order ASC, LCASE(" . $data['sort'] . ")";
            } elseif ($data['sort'] == 'p.price') {
//                $sql .= " ORDER BY p.sort_order ASC, (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
                $sql .= " ORDER BY p.sort_order ASC, (CASE WHEN special IS NOT NULL THEN special ELSE p.price END)";
            } else {
                $sql .= " ORDER BY p.sort_order ASC, " . $data['sort'];
            }
        } else {
            $sql .= " ORDER BY p.sort_order ASC, p.height ASC, p.width ASC, p.length ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }


        $product_data = array();

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
        }

        return $product_data;
    }

    public function getProductSpecials($data = array())
    {
        $sql = "SELECT DISTINCT ps.product_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = ps.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "hpmodel_product_hidden hph ON (p.product_id = hph.pid) LEFT JOIN " . DB_PREFIX . "hpmodel_links hpl ON (p.product_id = hpl.product_id) LEFT JOIN " . DB_PREFIX . "hpmodel_to_store h2s ON (hpl.type_id = h2s.type_id AND h2s.store_id = '" . (int)$this->config->get('config_store_id') . "') WHERE (hpl.parent_id IS NULL OR h2s.store_id IS NULL OR hph.pid IS NULL) AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))";

//        $sort_data = array(
//            'pd.name',
//            'p.model',
//            'ps.price',
//            'rating',
//            'p.sort_order'
//        );
//
//        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
//            if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
//                $sql .= " ORDER BY " . $data['sort'] ;
//            } else {
//                $sql .= " ORDER BY " . $data['sort'];
//            }
//        } else {
//            $sql .= " ORDER BY p.sort_order";
//        }
        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " ORDER BY ps.product_id DESC";
        } else {
            $sql .= " ORDER BY ps.product_id ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $product_data = array();
        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
        }
        return $product_data;
    }

    public function getLatestProducts($limit)
    {
        $product_data = $this->cache->get('product.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

        if (!$product_data) {
            $query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "hpmodel_product_hidden hph ON (p.product_id = hph.pid) LEFT JOIN " . DB_PREFIX . "hpmodel_links hpl ON (p.product_id = hpl.product_id) LEFT JOIN " . DB_PREFIX . "hpmodel_to_store h2s ON (hpl.type_id = h2s.type_id AND h2s.store_id = '" . (int)$this->config->get('config_store_id') . "') WHERE (hpl.parent_id IS NULL OR h2s.store_id IS NULL OR hph.pid IS NULL) AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);

            foreach ($query->rows as $result) {
                $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
            }

            $this->cache->set('product.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $product_data);
        }

        return $product_data;
    }

    public function getPopularProducts($limit)
    {
        $product_data = $this->cache->get('product.popular.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

        if (!$product_data) {
            $query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "hpmodel_product_hidden hph ON (p.product_id = hph.pid) LEFT JOIN " . DB_PREFIX . "hpmodel_links hpl ON (p.product_id = hpl.product_id) LEFT JOIN " . DB_PREFIX . "hpmodel_to_store h2s ON (hpl.type_id = h2s.type_id AND h2s.store_id = '" . (int)$this->config->get('config_store_id') . "') WHERE (hpl.parent_id IS NULL OR h2s.store_id IS NULL OR hph.pid IS NULL) AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC, p.date_added DESC LIMIT " . (int)$limit);

            foreach ($query->rows as $result) {
                $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
            }

            $this->cache->set('product.popular.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $product_data);
        }

        return $product_data;
    }

    public function getBestSellerProducts($limit)
    {
        $product_data = $this->cache->get('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

        if (!$product_data) {
            $product_data = array();

            $query = $this->db->query("SELECT op.product_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "hpmodel_product_hidden hph ON (p.product_id = hph.pid) LEFT JOIN " . DB_PREFIX . "hpmodel_links hpl ON (p.product_id = hpl.product_id) LEFT JOIN " . DB_PREFIX . "hpmodel_to_store h2s ON (hpl.type_id = h2s.type_id AND h2s.store_id = '" . (int)$this->config->get('config_store_id') . "') WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit);

            foreach ($query->rows as $result) {
                $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
            }

            $this->cache->set('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $product_data);
        }

        return $product_data;
    }

    public function getProductAttributes($product_id)
    {
        $product_attribute_group_data = array();

        $product_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.product_id = '" . (int)$product_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");

        foreach ($product_attribute_group_query->rows as $product_attribute_group) {
            $product_attribute_data = array();

            $product_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' AND a.attribute_group_id = '" . (int)$product_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");

            foreach ($product_attribute_query->rows as $product_attribute) {
                $product_attribute_data[] = array(
                    'attribute_id' => $product_attribute['attribute_id'],
                    'name' => $product_attribute['name'],
                    'text' => $product_attribute['text']
                );
            }

            $product_attribute_group_data[] = array(
                'attribute_group_id' => $product_attribute_group['attribute_group_id'],
                'name' => $product_attribute_group['name'],
                'attribute' => $product_attribute_data
            );
        }

        return $product_attribute_group_data;
    }

    public function getProductOptions($product_id)
    {
        $product_option_data = array();

        $product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

        foreach ($product_option_query->rows as $product_option) {
            $product_option_value_data = array();

            $product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

            foreach ($product_option_value_query->rows as $product_option_value) {
                $product_option_value_data[] = array(
                    'product_option_value_id' => $product_option_value['product_option_value_id'],
                    'option_value_id' => $product_option_value['option_value_id'],
                    'name' => $product_option_value['name'],
                    'image' => $product_option_value['image'],
                    'quantity' => $product_option_value['quantity'],
                    'subtract' => $product_option_value['subtract'],
                    'price' => $product_option_value['price'],
                    'price_prefix' => $product_option_value['price_prefix'],

                    'points' => $product_option_value['points'],
                    'points_prefix' => $product_option_value['points_prefix'],

                    'weight' => $product_option_value['weight'],
                    'weight_prefix' => $product_option_value['weight_prefix']
                );
            }

            $product_option_data[] = array(
                'product_option_id' => $product_option['product_option_id'],
                'product_option_value' => $product_option_value_data,
                'option_id' => $product_option['option_id'],
                'name' => $product_option['name'],
                'type' => $product_option['type'],
                'value' => $product_option['value'],
                'required' => $product_option['required']
            );
        }

        return $product_option_data;
    }

    public function getProductDiscounts($product_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");

        return $query->rows;
    }

    public function getProductImages($product_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");

        return $query->rows;
    }

    public function getProductRelated($product_id)
    {
        $product_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related pr LEFT JOIN " . DB_PREFIX . "product p ON (pr.related_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "hpmodel_product_hidden hph ON (p.product_id = hph.pid) LEFT JOIN " . DB_PREFIX . "hpmodel_links hpl ON (p.product_id = hpl.product_id) LEFT JOIN " . DB_PREFIX . "hpmodel_to_store h2s ON (hpl.type_id = h2s.type_id AND h2s.store_id = '" . (int)$this->config->get('config_store_id') . "') WHERE pr.product_id = '" . (int)$product_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

        foreach ($query->rows as $result) {
            $product_data[$result['related_id']] = $this->getProduct($result['related_id']);
        }

        return $product_data;
    }

    public function getProductLayoutId($product_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

        if ($query->num_rows) {
            return $query->row['layout_id'];
        } else {
            return 0;
        }
    }

    public function getCategories($product_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

        return $query->rows;
    }

    public function getGeneralCategorie($product_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "' AND main_category ='1'");
        return $query->rows;
    }

    public function getMainCategory($product_id)
    {
        $query = $this->db->query("SELECT c.category_id, c.parent_id FROM " . DB_PREFIX . "product_to_category p2c LEFT JOIN " . DB_PREFIX . "category c ON(p2c.category_id = c.category_id) WHERE product_id = '" . (int)$product_id . "'");

        foreach ($query->rows as $result) {
            if ($result['parent_id'] != 0) return $result['parent_id']; else return $result['category_id'];
        }
    }

    public function getTotalProducts($data = array())
    {

        $sql = "SELECT COUNT(DISTINCT IF(hpl.parent_id IS NOT NULL AND h2s.store_id IS NOT NULL AND hph.pid IS NOT NULL, hpl.parent_id, p.product_id)) AS total";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
            } else {
                $sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
            }

            if (!empty($data['filter_filter'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
            } else {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
            }
        } else {
            $sql .= " FROM " . DB_PREFIX . "product p";
        }

        // OCFilter start
        if (!empty($data['filter_ocfilter'])) {
            $this->load->model('catalog/ocfilter');

            $ocfilter_product_sql = $this->model_catalog_ocfilter->getSearchSQL($data['filter_ocfilter']);
        } else {
            $ocfilter_product_sql = false;
        }

        if ($ocfilter_product_sql && $ocfilter_product_sql->join) {
            $sql .= $ocfilter_product_sql->join;
        }
        // OCFilter end

        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "hpmodel_product_hidden hph ON (p.product_id = hph.pid) LEFT JOIN " . DB_PREFIX . "hpmodel_links hpl ON (p.product_id = hpl.product_id) LEFT JOIN " . DB_PREFIX . "hpmodel_to_store h2s ON (hpl.type_id = h2s.type_id AND h2s.store_id = '" . (int)$this->config->get('config_store_id') . "') WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW()";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
            } else {
                $sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
            }

            if (!empty($data['filter_filter'])) {
                $implode = array();

                $filters = explode(',', $data['filter_filter']);

                foreach ($filters as $filter_id) {
                    $implode[] = (int)$filter_id;
                }

                $sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
            }
        }

        // OCFilter start
        if (!empty($ocfilter_product_sql) && $ocfilter_product_sql->where) {
            $sql .= $ocfilter_product_sql->where;
        }
        // OCFilter end

        if (!empty($data['filter_manufacturer_id'])) {
            $sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
        }

        $query = $this->db->query($sql);
        return $query->row['total'];


    }

    public function getProfile($product_id, $recurring_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "recurring r JOIN " . DB_PREFIX . "product_recurring pr ON (pr.recurring_id = r.recurring_id AND pr.product_id = '" . (int)$product_id . "') WHERE pr.recurring_id = '" . (int)$recurring_id . "' AND status = '1' AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

        return $query->row;
    }

    public function getProfiles($product_id)
    {
        $query = $this->db->query("SELECT rd.* FROM " . DB_PREFIX . "product_recurring pr JOIN " . DB_PREFIX . "recurring_description rd ON (rd.language_id = " . (int)$this->config->get('config_language_id') . " AND rd.recurring_id = pr.recurring_id) JOIN " . DB_PREFIX . "recurring r ON r.recurring_id = rd.recurring_id WHERE pr.product_id = " . (int)$product_id . " AND status = '1' AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' ORDER BY sort_order ASC");

        return $query->rows;
    }

    public function getProductPrivat($product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_privat WHERE product_id = '" . (int)$product_id . "'");

        return $query->row;
    }

    public function getTotalProductSpecials()
    {
        $query = $this->db->query("SELECT COUNT(DISTINCT IF(hpl.parent_id IS NOT NULL AND h2s.store_id IS NOT NULL AND hph.pid IS NOT NULL, hpl.parent_id, ps.product_id)) AS total FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "hpmodel_product_hidden hph ON (p.product_id = hph.pid) LEFT JOIN " . DB_PREFIX . "hpmodel_links hpl ON (p.product_id = hpl.product_id) LEFT JOIN " . DB_PREFIX . "hpmodel_to_store h2s ON (hpl.type_id = h2s.type_id AND h2s.store_id = '" . (int)$this->config->get('config_store_id') . "') WHERE (hpl.parent_id IS NULL OR h2s.store_id IS NULL OR hph.pid IS NULL) AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))");

        if (isset($query->row['total'])) {
            return $query->row['total'];
        } else {
            return 0;
        }
    }

    public function getGeoListProduct($name)
    {
        $sql = "SELECT DescriptionRu FROM " . DB_PREFIX . "novaposhta_cities WHERE DescriptionRu LIKE '" . $this->db->escape($name) . "%' LIMIT 25";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getProductPickupCity($product_id)
    {
        $sql = "SELECT city FROM " . DB_PREFIX . "product_pickup_city WHERE product_id = '" . (int)$product_id . "'";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getProductCourierCity($product_id)
    {
        $sql = "SELECT city FROM " . DB_PREFIX . "product_courier_city WHERE product_id = '" . (int)$product_id . "'";
        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function getProviderProduct($product_id, $status_n)
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "provider_product WHERE product_id = '" . (int)$product_id . "' AND status_n = '" . $status_n . "'";
        $providers = $this->db->query($sql);
        return $providers->rows;
    }

    public function getProductDelivery($product_id, $city, $status)
    {
        $sql = "SELECT * FROM " . DB_PREFIX . "provider_delivery WHERE product_id = '" . (int)$product_id . "' AND city = '" . $city . "' AND status = '" . $status . "'";
        $delivery = $this->db->query($sql);
        return $delivery->rows;
    }

//    public function getCityByProduct($product_id)
//    {
//        $sql = "SELECT * FROM " . DB_PREFIX . "product_cities WHERE product_id = '" . (int)$product_id . "'";
//        $delivery = $this->db->query($sql);
//        return $delivery->rows;
//    }
}
