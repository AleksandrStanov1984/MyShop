<?php
$this->load->language('product/category');

$this->load->model('catalog/category');

$this->load->model('catalog/product');

$this->load->model('tool/image');


if (isset($this->request->get['filter'])) {
    $filter = $this->request->get['filter'];
} else {
    $filter = '';
}

if (isset($this->request->get['sort'])) {
    $sort = $this->request->get['sort'];
} else {
    $sort = 'p.viewed';

}

if (isset($this->request->get['order'])) {
    $order = $this->request->get['order'];
} else {
    $order = 'DESC';
}

if (isset($this->request->get['page'])) {
    $page = $this->request->get['page'];
} else {
    $page = 1;
}

if (isset($this->request->get['limit'])) {
    $limit = (int)$this->request->get['limit'];
} else {
    $limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
}

$data['limit_per_page'] = $limit;

$data['hide_subcategory_shortcut'] = false;
if (isset($this->request->get['filter']) || isset($this->request->get['filter_ocfilter'])) {
    $data['hide_subcategory_shortcut'] = true;
}

// OCFilter start
if (isset($this->request->get['filter_ocfilter'])) {
    $filter_ocfilter = $this->request->get['filter_ocfilter'];
} else {
    $filter_ocfilter = '';
}
// OCFilter end

$data['breadcrumbs'] = array();

$data['breadcrumbs'][] = array(
    'text' => $this->language->get('text_home'),
    'href' => $this->url->link('common/home')
);

if (isset($this->request->get['path'])) {
    $url = '';

    if (isset($this->request->get['sort'])) {
        $url .= '&sort=' . $this->request->get['sort'];
    }

    if (isset($this->request->get['order'])) {
        $url .= '&order=' . $this->request->get['order'];
    }

    if (isset($this->request->get['limit'])) {
        $url .= '&limit=' . $this->request->get['limit'];
    }

    $path = '';

    $parts = explode('_', (string)$this->request->get['path']);
    $count_parts = count($parts);
    $data['count_parts'] = $count_parts;
    $category_id = (int)array_pop($parts);
    $data['categ_id'] = $category_id;

    foreach ($parts as $path_id) {
        if (!$path) {
            $path = (int)$path_id;
        } else {
            $path .= '_' . (int)$path_id;
        }

        $category_info = $this->model_catalog_category->getCategory($path_id);

        if ($category_info) {
            $data['show_whl'] = $category_info['show_whl'];
            $data['breadcrumbs'][] = array(
                'text' => $category_info['name'],
                'href' => $this->url->link('product/category', 'path=' . $path . $url)
            );
        }
    }
} else {
    $category_id = 0;
}

$category_info = $this->model_catalog_category->getCategory($category_id);
// proverka nalichie filtra v makete
$this->load->model('design/layout');
$path = explode('_', (string)$this->request->get['path']);
$layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));
if (!$layout_id) {
    $layout_id = $this->model_design_layout->getLayout($this->request->get['path']);
}
$modules = $this->model_design_layout->getLayoutModules($layout_id, 'column_left');
$data['filter_connected'] = false;
foreach ($modules as $module) {
    if ($module['code'] == 'ocfilter') {
        $data['filter_connected'] = true;
        break;
    }
}

// proverka nalichie filtra v makete end
if ($category_info) {
    $data['show_whl'] = $category_info['show_whl'];
    $this->document->setTitle($category_info['meta_title']);
    $this->document->setName($category_info['name']);
    $this->document->setOgImage($category_info['image']);
    $this->document->setDescription($category_info['meta_description']);
    $this->document->setKeywords($category_info['meta_keyword']);

    $data['heading_title'] = $category_info['name'];
    $data['series_name'] = $category_info['series_name'];
    $data['text_refine'] = $this->language->get('text_refine');
    $data['text_empty'] = $this->language->get('text_empty');
    $data['text_quantity'] = $this->language->get('text_quantity');
    $data['text_manufacturer'] = $this->language->get('text_manufacturer');
    $data['text_model'] = $this->language->get('text_model');
    $data['text_price'] = $this->language->get('text_price');
    $data['text_tax'] = $this->language->get('text_tax');
    $data['text_points'] = $this->language->get('text_points');
    $data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
    $data['text_sort'] = $this->language->get('text_sort');
    $data['text_limit'] = $this->language->get('text_limit');
    $data['unit_h'] = $this->language->get('unit_h');
    $data['unit_w'] = $this->language->get('unit_w');
    $data['unit_l'] = $this->language->get('unit_l');
    $data['unit'] = $this->language->get('unit');
    $data['button_product_absent'] = $this->language->get('button_product_absent');
    $data['button_cart'] = $this->language->get('button_cart');
    $data['button_wishlist'] = $this->language->get('button_wishlist');
    $data['button_inwishlist'] = $this->language->get('button_inwishlist');
    $data['button_cart_add'] = $this->language->get('button_cart_add');
    $data['button_incart'] = $this->language->get('button_incart');
    $data['button_wishlist'] = $this->language->get('button_wishlist');
    $data['button_compare'] = $this->language->get('button_compare');
    $data['button_continue'] = $this->language->get('button_continue');
    $data['button_list'] = $this->language->get('button_list');
    $data['button_grid'] = $this->language->get('button_grid');
    $data['button_foto'] = $this->language->get('button_foto');
    $data['label_sale'] = $this->language->get('label_sale');

    // Set the last category breadcrumb
    $data['breadcrumbs'][] = array(
        'text' => $category_info['name'],
        'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'])
    );

    if ($category_info['image']) {
        $data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get($this->config->get('config_theme') . '_image_category_width'), $this->config->get($this->config->get('config_theme') . '_image_category_height'));
    } else {
        $data['thumb'] = '';
    }
    $data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
    $data['show_desc'] = $category_info['show_desc'];

    $data['compare'] = $this->url->link('product/compare');

    $url = '';

    // OCFilter start
    if (isset($this->request->get['filter_ocfilter'])) {
        $url .= '&filter_ocfilter=' . $this->request->get['filter_ocfilter'];
    }
    // OCFilter end

    if (isset($this->request->get['filter'])) {
        $url .= '&filter=' . $this->request->get['filter'];
    }

    if (isset($this->request->get['sort'])) {
        $url .= '&sort=' . $this->request->get['sort'];
    }

    if (isset($this->request->get['order'])) {
        $url .= '&order=' . $this->request->get['order'];
    }

    if (isset($this->request->get['limit'])) {
        $url .= '&limit=' . $this->request->get['limit'];
    }

    $data['categories'] = array();

    $results = $this->model_catalog_category->getCategories($category_id);

    foreach ($results as $result) {
        $filter_data = array(
            'filter_category_id' => $result['category_id'],
            'filter_sub_category' => true
        );
        $children_data = array();

        $children = $this->model_catalog_category->getCategories($result['category_id']);

        foreach ($children as $child) {
            $filter_data = array(
                'filter_category_id' => $child['category_id'],
                'filter_sub_category' => true
            );

            /* 2 Level Sub Categories END */
            if ($child['image']) {
                $imagechild = $this->model_tool_image->resize($child['image'], 300, 300);
            } else {
                $imagechild = $this->model_tool_image->resize('placeholder.png', 300, 300);
            }
            $children_data[] = array(
                'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                //'childs' => $childs_data,
                'image' => $imagechild,
                //'column'   => $child['column'] ? $child['column'] : 1,
                'href' => $this->url->link('product/category', 'path=' . $result['category_id'] . '_' . $child['category_id'])
            );
        }
        if ($result['image']) {
            $image = $this->model_tool_image->resize($result['image'], 240, 240);
        } else {
            $image = $this->model_tool_image->resize('placeholder.png', 240, 240);
        }

        $data['categories'][] = array(
            'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
            'image' => $image,
            'category_id' => $result['category_id'],
            'children' => $children_data,
            'series_name' => $result['series_name'],
            'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)
        );
    }

    $data['categ_url'] = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url);

    $data['products'] = array();

    $filter_data = array(
        'filter_category_id' => $category_id,
        'filter_sub_category' => true,
        'filter_filter' => $filter,
        'sort' => $sort,
        'order' => $order,
        'start' => ($page - 1) * $limit,
        'limit' => $limit + 1
    );

    // OCFilter start
    $filter_data['filter_ocfilter'] = $filter_ocfilter;
    // OCFilter end

    //$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

    $data['total_showed'] = $page * $limit;

    $results = $this->model_catalog_product->getProducts($filter_data);

    $data['product_total'] = count($results);

    $product_total = $data['product_total'];

    if ($data['product_total'] > $limit) array_pop($results);

    foreach ($results as $result) {

        //task 3d715b6d281f 28/12/2020
        if ($result['image_dod']) {
            $image = $this->model_tool_image->resize($result['image_dod'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
        } else {
            if ($result['image']) {
                $image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
            } else {
                $image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
            }
        }
        //task 3d715b6d281f 28/12/2020

        //added for image swap
        $images = $this->model_catalog_product->getProductImages($result['product_id']);

        if (isset($images[0]['image']) && !empty($images)) {
            $images = $images[0]['image'];
        } else {
            $images = $image;
        }

        if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
            $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
        } else {
            $price = false;
        }

        if ((float)$result['special']) {
            $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
        } else {
            $special = false;
        }

        if ($this->config->get('config_tax')) {
            $tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
        } else {
            $tax = false;
        }

        if ($this->config->get('config_review_status')) {
            $rating = (int)$result['rating'];
        } else {
            $rating = false;
        }
        if ($result['mpn']) {
            $stickers = explode(',', $result['mpn']);
            //$stickers=$result['stickers'];
        } else {
            $stickers = false;
        }

        $this->load->model('account/wishlist');

        if (!$this->customer->isLogged() && isset($this->session->data['wishlist'])) {
            $wishlist_pd = $this->session->data['wishlist'];
        } else {
            $wishlist_pd = $this->model_account_wishlist->getWishlist();
        }

        $wish_pd = false;

        if (!empty($wishlist_pd)) {
            foreach ($wishlist_pd as $product_id) {
                if ($product_id == $result['product_id']) {
                    $wish_pd = true;
                }
            }
        }

        // Cart
        $incart = false;

        if ($this->cart->hasProducts()) {
            $products_cart = $this->cart->getProducts();
            foreach ($products_cart as $product) {
                if ($product['product_id'] == $result['product_id']) {
                    $incart = true;
                }
            }
        }


        if (in_array($result['stock_status_id'], array(7, 8))) {
            $stock_status = $this->language->get('text_instock');
        } else {
            $stock_status = $result['stock_status'];
        }

        $data['products'][] = array(
            'in_stock' => (in_array($result['stock_status_id'], array(7, 8)) ? 1 : 0),
            'stock_status_id' => (int)$result['stock_status_id'],
            'product_id' => $result['product_id'],
            'date_added' => $result['date_added'],
            'viewed' => $result['viewed'],
            'thumb' => $image,
            'thumb_swap' => $this->model_tool_image->resize($images, $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height')),
            'name' => $result['name'],
            'height' => round($result['height'], 0),
            'length' => round($result['length'], 0),
            'width' => round($result['width'], 0),
            'diameter_of_pot' => round($result['diameter_of_pot'], 0),
            'depth_of_pot' => round($result['depth_of_pot'], 0),
            'model' => $result['model'],
            'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
            'price' => $price,
            'incart' => $incart,
            'wish' => $wish_pd,
            'stickers' => $stickers,
            'special' => $special,
            'manufacturer' => $result['manufacturer'],
            'tax' => $tax,
            'stock_status' => $stock_status,
            'minimum' => $result['minimum'] > 0 ? $result['minimum'] : 1,
            'rating' => $result['rating'],
            'href' => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url)
        );
    }

    $url = '';

    // OCFilter start
    if (isset($this->request->get['filter_ocfilter'])) {
        $url .= '&filter_ocfilter=' . $this->request->get['filter_ocfilter'];
    }
    // OCFilter end

    if (isset($this->request->get['filter'])) {
        $url .= '&filter=' . $this->request->get['filter'];
    }

    if (isset($this->request->get['limit'])) {
        $url .= '&limit=' . $this->request->get['limit'];
    }

    $data['microdata'] = $this->microdataProducts($data['products']);

    $data['sorts'] = array();

    /*$data['sorts'][] = array(
        'text'  => $this->language->get('text_default'),
        'value' => 'p.sort_order-ASC',
        'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url)
    );

    $data['sorts'][] = array(
        'text'  => $this->language->get('text_name_asc'),
        'value' => 'pd.name-ASC',
        'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url)
    );

    $data['sorts'][] = array(
        'text'  => $this->language->get('text_name_desc'),
        'value' => 'pd.name-DESC',
        'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url)
    );*/
    $data['sorts'][] = array(
        'text' => $this->language->get('text_views'),
        'value' => 'p.viewed-DESC',
        'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.viewed&order=DESC' . $url)
    );

    $data['sorts'][] = array(
        'text' => $this->language->get('text_price_asc'),
        'value' => 'p.price-ASC',
        'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
    );

    $data['sorts'][] = array(
        'text' => $this->language->get('text_price_desc'),
        'value' => 'p.price-DESC',
        'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
    );

    /*if ($this->config->get('config_review_status')) {
        $data['sorts'][] = array(
            'text'  => $this->language->get('text_rating_desc'),
            'value' => 'rating-DESC',
            'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url)
        );

        $data['sorts'][] = array(
            'text'  => $this->language->get('text_rating_asc'),
            'value' => 'rating-ASC',
            'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url)
        );
    }

    $data['sorts'][] = array(
        'text'  => $this->language->get('text_model_asc'),
        'value' => 'p.model-ASC',
        'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url)
    );

    $data['sorts'][] = array(
        'text'  => $this->language->get('text_model_desc'),
        'value' => 'p.model-DESC',
        'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url)
    );*/

    $data['sorts']['p.date_added-DESC'] = array(
        'text' => $this->language->get('text_date_added'),
        'value' => 'p.date_added-DESC',
        'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.date_added&order=DESC' . $url)
    );


    $url = '';

    // OCFilter start
    if (isset($this->request->get['filter_ocfilter'])) {
        $url .= '&filter_ocfilter=' . $this->request->get['filter_ocfilter'];
    }
    // OCFilter end

    if (isset($this->request->get['filter'])) {
        $url .= '&filter=' . $this->request->get['filter'];
    }

    if (isset($this->request->get['sort'])) {
        $url .= '&sort=' . $this->request->get['sort'];
    }

    if (isset($this->request->get['order'])) {
        $url .= '&order=' . $this->request->get['order'];
    }

    $data['limits'] = array();

    $limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));

    sort($limits);

    foreach ($limits as $value) {
        $data['limits'][] = array(
            'text' => $value,
            'value' => $value,
            'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
        );
    }

    $url = '';

    // OCFilter start
    if (isset($this->request->get['filter_ocfilter'])) {
        $url .= '&filter_ocfilter=' . $this->request->get['filter_ocfilter'];
    }
    // OCFilter end

    if (isset($this->request->get['filter'])) {
        $url .= '&filter=' . $this->request->get['filter'];
    }

    if (isset($this->request->get['sort'])) {
        $url .= '&sort=' . $this->request->get['sort'];
    }

    if (isset($this->request->get['order'])) {
        $url .= '&order=' . $this->request->get['order'];
    }

    if (isset($this->request->get['limit'])) {
        $url .= '&limit=' . $this->request->get['limit'];
    }

    $pagination = new Pagination();
    $pagination->total = $product_total;
    $pagination->page = $page;
    $pagination->limit = $limit;
    $pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');

    $data['pagination'] = $pagination->render();

    $data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

    // http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
    if ($page == 1) {
        $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], true), 'canonical');
    } elseif ($page == 2) {
        $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], true), 'prev');
    } else {
        $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page=' . ($page - 1), true), 'prev');
    }

    if ($limit && ceil($product_total / $limit) > $page) {
        $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page=' . ($page + 1), true), 'next');
    }

    $data['sort'] = $sort;
    $data['order'] = $order;
    $data['limit'] = $limit;

    // OCFilter Start
    if (isset($this->request->get['filter_ocfilter'])) {

        if (!$product_total) {
            $this->response->redirect($this->url->link('product/category', 'path=' . $this->request->get['path']));
        }

        $data['description'] = '';

        $this->document->deleteLink('canonical');
    }

    $ocfilter_page_info = $this->load->controller('extension/module/ocfilter/getPageInfo');

    if ($ocfilter_page_info) {
        $this->document->setTitle($ocfilter_page_info['meta_title']);

        if ($ocfilter_page_info['meta_description']) {
            $this->document->setDescription($ocfilter_page_info['meta_description']);
        }

        if ($ocfilter_page_info['meta_keyword']) {
            $this->document->setKeywords($ocfilter_page_info['meta_keyword']);
        }

        $data['heading_title'] = $ocfilter_page_info['title'];

        if ($ocfilter_page_info['description'] && !isset($this->request->get['page']) && !isset($this->request->get['sort']) && !isset($this->request->get['order']) && !isset($this->request->get['search']) && !isset($this->request->get['limit'])) {
            $data['description'] = html_entity_decode($ocfilter_page_info['description'], ENT_QUOTES, 'UTF-8');
        }

        $data['breadcrumbs'][] = array(
            'text' => $ocfilter_page_info['title'],
            'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url)
        );
    } else {
        $meta_title = $this->document->getTitle();
        $meta_description = $this->document->getDescription();
        $meta_keyword = $this->document->getKeywords();

        $filter_title = $this->load->controller('extension/module/ocfilter/getSelectedsFilterTitle');

        if ($filter_title) {
            if (false !== strpos($meta_title, '{filter}')) {
                $meta_title = trim(str_replace('{filter}', $filter_title, $meta_title));
            } else {
                $meta_title .= ' ' . $filter_title;
            }

            $this->document->setTitle($meta_title);

            if ($meta_description) {
                if (false !== strpos($meta_description, '{filter}')) {
                    $meta_description = trim(str_replace('{filter}', $filter_title, $meta_description));
                } else {
                    $meta_description .= ' ' . $filter_title;
                }

                $this->document->setDescription($meta_description);
            }

            if ($meta_keyword) {
                if (false !== strpos($meta_keyword, '{filter}')) {
                    $meta_keyword = trim(str_replace('{filter}', $filter_title, $meta_keyword));
                } else {
                    $meta_keyword .= ' ' . $filter_title;
                }

                $this->document->setKeywords($meta_keyword);
            }

            $heading_title = $data['heading_title'];

            if (false !== strpos($heading_title, '{filter}')) {
                $heading_title = trim(str_replace('{filter}', $filter_title, $heading_title));
            } else {
                $heading_title .= ' ' . $filter_title;
            }

            $data['heading_title'] = $heading_title;

            $data['description'] = '';

            $data['breadcrumbs'][] = array(
                //'text' => (utf8_strlen($heading_title) > 30 ? utf8_substr($heading_title, 0, 30) . '..' : $heading_title),
                'text' => $heading_title,
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url)
            );
        } else {
            $this->document->setTitle(trim(str_replace('{filter}', '', $meta_title)));
            $this->document->setDescription(trim(str_replace('{filter}', '', $meta_description)));
            $this->document->setKeywords(trim(str_replace('{filter}', '', $meta_keyword)));

            $data['heading_title'] = trim(str_replace('{filter}', '', $data['heading_title']));
        }
    }
    // OCFilter End

    $data['microdata_breadcrumbs'] = $this->microdataBreadcrumbs($data['breadcrumbs']);

    $data['continue'] = $this->url->link('common/home');

    $data['column_left'] = $this->load->controller('common/column_left');
    $data['column_right'] = $this->load->controller('common/column_right');
    $data['content_top'] = $this->load->controller('common/content_top');
    $data['content_bottom'] = $this->load->controller('common/content_bottom');
    $data['footer'] = $this->load->controller('common/footer');
    $data['header'] = $this->load->controller('common/header');

    if (($count_parts == 1) && (!$data['is_mobile'])) {
        $this->response->setOutput($this->load->view('product/category_lev1', $data));
    } else {
        $template = 'product/category';

        // Custom template module
        $this->load->model('setting/setting');

        $custom_template_module = $this->model_setting_setting->getSetting('custom_template_module');

        $customer_group_id = $this->customer->getGroupId();

        if ($this->config->get('config_theme') == 'theme_default') {
            $directory = $this->config->get('theme_default_directory');
        } else {
            $directory = $this->config->get('config_theme');
        }

        if (!empty($custom_template_module['custom_template_module'])) {
            foreach ($custom_template_module['custom_template_module'] as $key => $module) {
                if (($module['type'] == 0) && !empty($module['categories'])) {
                    if ((isset($module['customer_groups']) && in_array($customer_group_id, $module['customer_groups'])) || !isset($module['customer_groups']) || empty($module['customer_groups'])) {

                        if (in_array($category_id, $module['categories'])) {
                            if (file_exists(DIR_TEMPLATE . $directory . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . $module['template_name'] . '.tpl')) {
                                $template = $module['template_name'];
                            }
                        }

                    } // customer groups

                }
            }
        }

        $template = str_replace('\\', '/', $template);

        $this->response->setOutput($this->load->view($template, $data));
    }

} else {
    $url = '';

    if (isset($this->request->get['path'])) {
        $url .= '&path=' . $this->request->get['path'];
    }

    // OCFilter start
    if (isset($this->request->get['filter_ocfilter'])) {
        $url .= '&filter_ocfilter=' . $this->request->get['filter_ocfilter'];
    }
    // OCFilter end

    if (isset($this->request->get['filter'])) {
        $url .= '&filter=' . $this->request->get['filter'];
    }

    if (isset($this->request->get['sort'])) {
        $url .= '&sort=' . $this->request->get['sort'];
    }

    if (isset($this->request->get['order'])) {
        $url .= '&order=' . $this->request->get['order'];
    }

    if (isset($this->request->get['page'])) {
        $url .= '&page=' . $this->request->get['page'];
    }

    if (isset($this->request->get['limit'])) {
        $url .= '&limit=' . $this->request->get['limit'];
    }

    $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_error'),
        'href' => $this->url->link('product/category', $url)
    );

    $this->document->setTitle($this->language->get('text_error'));

    $data['heading_title'] = $this->language->get('text_error');

    $data['text_error'] = $this->language->get('text_error');

    $data['button_continue'] = $this->language->get('button_continue');

    $data['continue'] = $this->url->link('common/home');

    $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

    $data['column_left'] = $this->load->controller('common/column_left');
    $data['column_right'] = $this->load->controller('common/column_right');
    $data['content_top'] = $this->load->controller('common/content_top');
    $data['content_bottom'] = $this->load->controller('common/content_bottom');
    $data['footer'] = $this->load->controller('common/footer');
    $data['header'] = $this->load->controller('common/header');

    $this->response->setOutput($this->load->view('error/not_found', $data));