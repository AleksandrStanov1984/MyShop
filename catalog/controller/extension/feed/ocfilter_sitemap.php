<?php

class ControllerExtensionFeedOcfilterSitemap extends Controller
{
    public function index()
    {
        set_time_limit(0);
        //$count_url = 0;
        if ($this->config->get('ocfilter_sitemap_status')) {

            $output = '<?xml version="1.0" encoding="UTF-8"?>';
            $output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

            $url_filters = array();

            $query_category = $this->db->query("SELECT * FROM " . DB_PREFIX . "ocfilter_option_to_category WHERE 1");

            if($query_category->rows){
                foreach ($query_category->rows as $category){
                    $query_option = $this->db->query("SELECT keyword FROM " . DB_PREFIX . "ocfilter_option WHERE option_id = '". (int)$category['option_id'] ."'");
                    $url_filters[] = array(
                      'category_id'  => $category['category_id'],
                      'option_id'    => $category['option_id'],
                      'keyword'      => $query_option->row['keyword']
                    );
                }
            }

            foreach ($url_filters as $page) {
                $link = rtrim($this->url->link('product/category', 'path=' . $page['category_id']), '/');

                if ($page['keyword']) {
                    $link .= '/'. $page['keyword'];
                }

                $query_options = $this->db->query("SELECT * FROM " . DB_PREFIX . "ocfilter_option_value WHERE option_id = '". $page['option_id'] ."'");
                if($query_options->rows) {
                    foreach ($query_options->rows as $option) {
                          if(strlen($option['keyword']) > 0) {
                              $output .= '<url>';
                              $output .= '<loc>' . $link . '/' . $option['keyword'] . '/' . '</loc>';
                              $output .= '<changefreq>weekly</changefreq>';
                              $output .= '<priority>0.7</priority>';
                              $output .= '</url>';
                              //$count_url++;
                          }
                    }
                }
            }
            $output .= '</urlset>';
            //echo $count_url;
            $this->response->addHeader('Content-Type: application/xml');
            $this->response->setOutput($output);
        }
    }
}