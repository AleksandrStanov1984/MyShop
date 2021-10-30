<?php

class ModelToolHome extends Model
{

    public function getInformations()
    {
        $query = $this->db->query("SELECT id.title, id.information_id, i.bottom FROM " . DB_PREFIX . "information i 
                       LEFT JOIN " . DB_PREFIX . "information_description id ON (i.information_id = id.information_id) 
                       LEFT JOIN " . DB_PREFIX . "information_to_store i2s ON (i.information_id = i2s.information_id) 
                       WHERE id.language_id = '" . (int)$this->config->get('config_language_id') . "' 
                       AND i2s.store_id = '" . (int)$this->config->get('config_store_id') . "' 
                       AND i.status = '1' ORDER BY i.sort_order, LCASE(id.title) ASC");
        return $query->rows;
    }

    public function getCategories($parent_id = 0)
    {
        $query = $this->db->query("SELECT cd.series_name, c.image, c.category_id, c.column, c.top FROM " . DB_PREFIX . "category c 
            LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) 
            LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) 
            WHERE c.parent_id = '" . (int)$parent_id . "' 
            AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
            AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  
            AND c.status = '1' 
            ORDER BY c.sort_order, LCASE(cd.name)");
        return $query->rows;
    }

    public function getBannerCategory($category_id)
    {
        $query = $this->db->query("SELECT banner_id, banner_status, width, height FROM " . DB_PREFIX . "category_banners WHERE  category_id = '" . (int)$category_id . "' LIMIT 1");

        if (isset($query->row)) {
            return $query->row;
        } else {
            return false;
        }
    }

    public function getBanner($banner_id)
    {
        $query = $this->db->query("SELECT title, image, link FROM " . DB_PREFIX . "banner b 
        LEFT JOIN " . DB_PREFIX . "banner_image bi ON (b.banner_id = bi.banner_id) 
        WHERE b.banner_id = '" . (int)$banner_id . "' 
        AND b.status = '1' 
        AND bi.hide != '1' 
        AND bi.language_id = '" . (int)$this->config->get('config_language_id') . "' LIMIT 1");
        return $query->rows;
    }

    public function getCategoriesBlog($parent_id = 0)
    {
        $query = $this->db->query("SELECT cd.name, c.settings, c.category_id FROM " . DB_PREFIX . "newsblog_category c
		LEFT JOIN " . DB_PREFIX . "newsblog_category_description cd ON (c.category_id = cd.category_id)
		LEFT JOIN " . DB_PREFIX . "newsblog_category_to_store c2s ON (c.category_id = c2s.category_id)
		WHERE c.parent_id = '" . (int)$parent_id . "'
		AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'
		AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'
		AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");
        return $query->rows;
    }


    public function getArticle($article_id)
    {
        $query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image,
		p.sort_order

		FROM " . DB_PREFIX . "newsblog_article p
		LEFT JOIN " . DB_PREFIX . "newsblog_article_description pd ON (p.article_id = pd.article_id)
		LEFT JOIN " . DB_PREFIX . "newsblog_article_to_store p2s ON (p.article_id = p2s.article_id)

		WHERE p.article_id = '" . (int)$article_id . "' AND
		pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND
		p.status = '1' AND
		p.date_available <= NOW() AND
		p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

        if ($query->num_rows) {
            return array(
                'article_id' => $query->row['article_id'],
                'name' => $query->row['name'],
                'preview' => $query->row['preview'],
                'description' => $query->row['description'],
                'meta_title' => $query->row['meta_title'],
                'meta_h1' => $query->row['meta_h1'],
                'meta_description' => $query->row['meta_description'],
                'meta_keyword' => $query->row['meta_keyword'],
                'tag' => $query->row['tag'],
                'image' => $query->row['image'],
                'date_available' => $query->row['date_available'],
                'sort_order' => $query->row['sort_order'],
                'status' => $query->row['status'],
                'date_modified' => $query->row['date_modified'],
                'viewed' => $query->row['viewed'],
                'attributes' => $this->getArticleAttributes($article_id)
            );
        } else {
            return false;
        }
    }

    public function getArticles($data = array())
    {
        $sql = "SELECT a.article_id";

        if (!empty($data['filter_category_id']) || !empty($data['filter_categories'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " FROM " . DB_PREFIX . "newsblog_category_path cp LEFT JOIN " . DB_PREFIX . "newsblog_article_to_category a2c ON (cp.category_id = a2c.category_id)";
            } else {
                $sql .= " FROM " . DB_PREFIX . "newsblog_article_to_category a2c";
            }

            $sql .= " LEFT JOIN " . DB_PREFIX . "newsblog_article a ON (a2c.article_id = a.article_id)";

        } else {
            $sql .= " FROM " . DB_PREFIX . "newsblog_article a";
        }

        $sql .= " LEFT JOIN " . DB_PREFIX . "newsblog_article_description ad ON (a.article_id = ad.article_id)
		LEFT JOIN " . DB_PREFIX . "newsblog_article_to_store a2s ON (a.article_id = a2s.article_id)

		WHERE ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND
		a.status = '1' AND
		a.date_available <= NOW() AND
		a2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
            } else {
                $sql .= " AND a2c.category_id = '" . (int)$data['filter_category_id'] . "'";
            }
        }

        if (!empty($data['filter_categories'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " AND cp.path_id in (" . implode(',', $data['filter_categories']) . ")";
            } else {
                $sql .= " AND a2c.category_id in (" . implode(',', $data['filter_categories']) . ")";
            }
        }

        $sql .= " GROUP BY a.article_id";

        if (isset($data['sort'])) {
            if ($data['sort'] == 'ad.name') {
                $sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
            } else {
                $sql .= " ORDER BY " . $data['sort'];
            }
        } else {
            $sql .= " ORDER BY a.sort_order";
        }

        if (isset($data['order'])) {
            $sql .= " " . $data['order'];
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 10;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        $article_data = array();

        $query = $this->db->query($sql);

        foreach ($query->rows as $result) {
            $article_data[$result['article_id']] = $this->getArticle($result['article_id']);
        }

        return $article_data;
    }

    public function getImageProductHeader($product_id)
    {
        $query = $this->db->query("SELECT image FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
        if (isset($query->row['image'])) {
            return $query->row['image'];
        } else {
            return false;
        }
    }

    public function getMainCategory($product_id)
    {
        $query = $this->db->query("SELECT c.category_id, c.parent_id FROM " . DB_PREFIX . "product_to_category p2c 
        LEFT JOIN " . DB_PREFIX . "category c ON(p2c.category_id = c.category_id) WHERE 
        product_id = '" . (int)$product_id . "'");

        foreach ($query->rows as $result) {
            if ($result['parent_id'] != 0) return $result['parent_id']; else return $result['category_id'];
        }
    }
}