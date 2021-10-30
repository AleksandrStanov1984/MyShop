<?php
class ControllerExtensionModuleCategoryWall extends Controller {

    public function index() {
        /*gulp add */
        //$this->document->addStyle('catalog/view/theme/OPC080193_6/css/owlcarousel/owl.carousel.min.css');
        //$this->document->addStyle('catalog/view/theme/OPC080193_6/css/owlcarousel/owl.theme.default.min.css');
        //$this->document->addScript('catalog/view/theme/OPC080193_6/js/owlcarousel/owl.carousel.min.js');
        //$this->document->addStyle('catalog/view/theme/OPC080193_6/stylesheet/category_wall.css');
        $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/owl.carousel.min.css');
        $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/owl.theme.default.min.css');
        $this->document->addScript('catalog/view/theme/OPC080193_6/assets/owl.carousel.min.js');
        $this->document->addStyle('catalog/view/theme/OPC080193_6/assets/category_wall.css');
        /*gulp add */
        $this->load->language('extension/module/category_wall');


        $data['heading_title'] = $this->language->get('heading_title');

        if (isset($this->request->get['path'])) {
            $parts = explode('_', (string) $this->request->get['path']);
        } else {
            $parts = array();
        }

        if (isset($parts[0])) {
            $data['category_id'] = $parts[0];
        } else {
            $data['category_id'] = 0;
        }

        if (isset($parts[1])) {
            $data['child_id'] = $parts[1];
        } else {
            $data['child_id'] = 0;
        }

        $this->load->model('catalog/category');

        $this->load->model('catalog/product');

        $data['categories'] = array();

        /*$data['categories'] = array();
                $categories = $this->model_catalog_category->getCategories(0);

        foreach ($categories as $category) {
            $children_data = array();

            $children = $this->model_catalog_category->getCategories($category['category_id']);

            foreach ($children as $child) {
                $filter_data = array(
                    'filter_category_id'  => $child['category_id'],
                    'filter_sub_category' => true
                );
                 if ($child['image']) {
                $image = $this->model_tool_image->resize($child['image'], $this->config->get('category_wall_width'), $this->config->get('category_wall_height'));
            } else {
                $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('category_wall_width'), $this->config->get('category_wall_height'));
            }

                $children_data[] = array(
                    'category_id' => $child['category_id'],
                    'image' => $image,
                    'name'        => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                    'href'        => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
                );
            }

            $filter_data = array(
                'filter_category_id'  => $category['category_id'],
                'filter_sub_category' => true
            );


            $data['categories'][] = array(
                'category_id' => $category['category_id'],
                'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                'children'    => $children_data,
                'image' => $image,
                'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
            );
        }
*/
        $categories = $this->model_catalog_category->getCategories(0);

        $this->load->model('tool/image');
        foreach ($categories as $category) {
            if ($category['top']) {

            if ($category['image']) {
                $image = $this->model_tool_image->resize($category['image'], $this->config->get('category_wall_width'), $this->config->get('category_wall_height'));
            } else {
                $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('category_wall_width'), $this->config->get('category_wall_height'));
            }

            $data['categories'][] = array(
		'category_id' => $category['category_id'],
                'description' => $category['description'],
                'name' => $category['name'],
                'image' => $image,
                'href' => $this->url->link('product/category', 'path=' . $category['category_id'])
                );
            }
        }
		return $this->load->view('extension/module/category_wall', $data);


    }
}
