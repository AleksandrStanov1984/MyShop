<?php
class ControllerExtensionModuleOwlCarousel extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('extension/module/owlcarousel');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('extension/module');
        $this->load->model('catalog/category');

        $module_version = '4.0.2';

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            if (!isset($this->request->get['module_id'])) {
                $this->model_extension_module->addModule('owlcarousel', $this->request->post['owlcarousel_module']);
            } else {
                $this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post['owlcarousel_module']);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->cache->delete('owlcarousel');

            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
        }

        $data['heading_title']          = $this->language->get('heading_title') . ' v.' . $module_version;
        $data['add_tab_module']         = $this->language->get('add_tab_module');
        $data['text_enabled']           = $this->language->get('text_enabled');
        $data['text_disabled']          = $this->language->get('text_disabled');
        $data['text_content_top']       = $this->language->get('text_content_top');
        $data['text_content_bottom']    = $this->language->get('text_content_bottom');
        $data['text_column_left']       = $this->language->get('text_column_left');
        $data['text_column_right']      = $this->language->get('text_column_right');
        $data['text_all_product']       = $this->language->get('text_all_product');
        $data['text_all_manufacturers'] = $this->language->get('text_all_manufacturers');
        $data['text_featured']          = $this->language->get('text_featured');
        $data['text_viewed']            = $this->language->get('text_viewed');
        $data['text_hide_module']       = $this->language->get('text_hide_module');
        $data['text_yes']               = $this->language->get('text_yes');
        $data['text_no']                = $this->language->get('text_no');
        $data['text_sort_date_added']   = $this->language->get('text_sort_date_added');
        $data['text_sort_rating']       = $this->language->get('text_sort_rating');
        $data['text_sort_viewed']       = $this->language->get('text_sort_viewed');
        $data['text_sort_bestseller']   = $this->language->get('text_sort_bestseller');
        $data['text_sort_special']      = $this->language->get('text_sort_special');
        $data['text_sort_order']        = $this->language->get('text_sort_order');

        $data['entry_main']             = $this->language->get('entry_main');
        $data['entry_product']          = $this->language->get('entry_product');
        $data['entry_additional']       = $this->language->get('entry_additional');
        $data['entry_display']          = $this->language->get('entry_display');
        $data['entry_tab_options']      = $this->language->get('entry_tab_options');
        $data['entry_product_options']  = $this->language->get('entry_product_options');
        $data['entry_add_block_name']   = $this->language->get('entry_add_block_name');
        $data['entry_sort']             = $this->language->get('entry_sort');
        $data['entry_limit']            = $this->language->get('entry_limit');
        $data['entry_image']            = $this->language->get('entry_image');
        $data['entry_description']      = $this->language->get('entry_description');
        $data['entry_source']           = $this->language->get('entry_source');
        $data['entry_manufacturer']     = $this->language->get('entry_manufacturer');
        $data['entry_category']         = $this->language->get('entry_category');
        $data['entry_title']            = $this->language->get('entry_title');
        $data['entry_type']             = $this->language->get('entry_type');
        $data['entry_count']            = $this->language->get('entry_count');
        $data['entry_visible']          = $this->language->get('entry_visible');
        $data['entry_visible_1000']     = $this->language->get('entry_visible_1000');
        $data['entry_visible_900']      = $this->language->get('entry_visible_900');
        $data['entry_visible_600']      = $this->language->get('entry_visible_600');
        $data['entry_visible_479']      = $this->language->get('entry_visible_479');
        $data['entry_slide_speed']      = $this->language->get('entry_slide_speed');
        $data['entry_pagination_speed'] = $this->language->get('entry_pagination_speed');
        $data['entry_rewind_speed']     = $this->language->get('entry_rewind_speed');
        $data['entry_autoscroll']       = $this->language->get('entry_autoscroll');
        $data['entry_item_prev_next']   = $this->language->get('entry_item_prev_next');
        $data['entry_per_page']         = $this->language->get('entry_per_page');
        $data['entry_random_item']      = $this->language->get('entry_random_item');
        $data['entry_status']           = $this->language->get('entry_status');
        $data['entry_add_class_name']   = $this->language->get('entry_add_class_name');
        $data['entry_show_title']       = $this->language->get('entry_show_title');
        $data['entry_show_name']        = $this->language->get('entry_show_name');
        $data['entry_show_desc']        = $this->language->get('entry_show_desc');
        $data['entry_show_price']       = $this->language->get('entry_show_price');
        $data['entry_show_rate']        = $this->language->get('entry_show_rate');
        $data['entry_show_cart']        = $this->language->get('entry_show_cart');
        $data['entry_show_wishlist']    = $this->language->get('entry_show_wishlist');
        $data['entry_show_compare']     = $this->language->get('entry_show_compare');
        $data['entry_show_page']        = $this->language->get('entry_show_page');
        $data['entry_show_nav']         = $this->language->get('entry_show_nav');
        $data['entry_show_lazy_load']   = $this->language->get('entry_show_lazy_load');
        $data['entry_show_mouse_drag']  = $this->language->get('entry_show_mouse_drag');
        $data['entry_show_touch_drag']  = $this->language->get('entry_show_touch_drag');
        $data['entry_stop_on_hover']    = $this->language->get('entry_stop_on_hover');
        $data['entry_show_tabs']        = $this->language->get('entry_show_tabs');
        $data['entry_stock']            = $this->language->get('entry_stock');
        $data['entry_current_category'] = $this->language->get('entry_current_category');
        $data['entry_current_product']  = $this->language->get('entry_current_product');
        $data['entry_hide_module']      = $this->language->get('entry_hide_module');
        $data['entry_use_cache']        = $this->language->get('entry_use_cache');

        $data['help_category']          = $this->language->get('help_category');
        $data['help_count']             = $this->language->get('help_count');
        $data['help_visible']           = $this->language->get('help_visible');
        $data['help_visible_1000']      = $this->language->get('help_visible_1000');
        $data['help_visible_900']       = $this->language->get('help_visible_900');
        $data['help_visible_600']       = $this->language->get('help_visible_600');
        $data['help_visible_479']       = $this->language->get('help_visible_479');
        $data['help_slide_speed']       = $this->language->get('help_slide_speed');
        $data['help_pagination_speed']  = $this->language->get('help_pagination_speed');
        $data['help_rewind_speed']      = $this->language->get('help_rewind_speed');
        $data['help_autoscroll']        = $this->language->get('help_autoscroll');
        $data['help_item_prev_next']    = $this->language->get('help_item_prev_next');
        $data['help_per_page']          = $this->language->get('help_per_page');
        $data['help_current_category']  = $this->language->get('help_current_category');
        $data['help_current_product']   = $this->language->get('help_current_product');
        $data['help_hide_module']       = $this->language->get('help_hide_module');

        $data['button_save']            = $this->language->get('button_save');
        $data['button_cancel']          = $this->language->get('button_cancel');
        $data['button_add_module']      = $this->language->get('button_add_module');
        $data['button_remove']          = $this->language->get('button_remove');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true)
        );

        if (!isset($this->request->get['module_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/owlcarousel', 'token=' . $this->session->data['token'], true)
            );
        } else {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('extension/module/owlcarousel', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true)
            );
        }

        if (!isset($this->request->get['module_id'])) {
            $data['action'] = $this->url->link('extension/module/owlcarousel', 'token=' . $this->session->data['token'], true);
        } else {
            $data['action'] = $this->url->link('extension/module/owlcarousel', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
        }

        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true);
        $data['token'] = $this->session->data['token'];

        if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $data['module'] = $this->model_extension_module->getModule($this->request->get['module_id']);
        } elseif ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $data['module'] = $this->request->post['owlcarousel_module'];
        } else {
            $data['module'] = array(
                'name'                  => '',
                'title'                 => array(),
                'add_block_name'        => '',
                'status'                => false,
                'sort_order'            => '0',
                'add_class_name'        => '',
                'rewind_speed'          => '',
                'autoscroll'            => '',
                'item_prev_next'        => '',
                'category_id'           => '',
                'featured'              => '',
                'viewed'                => '',
                'manufacturer_id'       => '',
                'sort'                  => '',
                'image_width'           => '200',
                'image_height'          => '200',
                'description'           => '100',
                'count'                 => '12',
                'visible'               => '4',
                'visible_1000'          => '4',
                'visible_900'           => '3',
                'visible_600'           => '2',
                'visible_479'           => '1',
                'slide_speed'           => '200',
                'pagination_speed'      => '800',
                'show_per_page'         => false,
                'show_random_item'      => false,
                'show_stock'            => false,
                'hide_module'           => false,
                'show_current_category' => false,
                'show_current_product'  => false,
                'show_title'            => true,
                'show_name'             => true,
                'template'              => 'default',
                'show_desc'             => true,
                'show_price'            => true,
                'show_rate'             => true,
                'show_cart'             => true,
                'show_wishlist'         => true,
                'show_compare'          => true,
                'show_page'             => true,
                'show_loop'             => true,
                'show_nav'              => true,
                'show_lazy_load'        => true,
                'show_mouse_drag'       => true,
                'show_touch_drag'       => true,
                'show_stop_on_hover'    => true,
                'show_tabs'             => false,
                'display_with'          => array()
            );
        }

        $this->load->model('design/layout');
        $data['layouts'] = $this->model_design_layout->getLayouts();

        $this->load->model('catalog/manufacturer');
        $results = $this->model_catalog_manufacturer->getManufacturers();

        foreach ($results as $result) {
            $data['manufacturers'][] = array(
                'manufacturer_id' => $result['manufacturer_id'],
                'name'        => $result['name']
            );
        }

        $data['rootcats'] = $this->model_catalog_category->getCategories(0);

        $this->load->model('catalog/product');

        $data['products'] = array();

        $i = 1;

        $products = explode(',', $data['module']['featured']);

        foreach ($products as $product_id) {
            $product_info = $this->model_catalog_product->getProduct($product_id);

            if ($product_info) {
                $data['products'][] = array(
                    'module_id' => $i,
                    'product_id' => $product_info['product_id'],
                    'name'       => $product_info['name']
                );
            }
        }

        $this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages();

        $this->load->model('extension/extension');

        $this->load->model('extension/module');

        $data['other_modules'] = array();

        $modules = $this->model_extension_module->getModulesByCode('owlcarousel');

        foreach ($modules as $module) {
            if (isset($this->request->get['module_id']) && $module['module_id'] == $this->request->get['module_id']) {
                continue;
            }

            $data['other_modules'][] = array(
                'id' => $module['module_id'],
                'name'      => strip_tags($module['name'])
            );
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/owlcarousel.tpl', $data));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/owlcarousel')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!trim($this->request->post['owlcarousel_module']['name'])) {
            $this->error['warning'] = $this->language->get('error_name');
        }

        foreach($this->request->post['owlcarousel_module']['title'] as $title) {
            if(!trim($title)) {
                $this->error['warning'] = $this->language->get('error_title');
                break;
            }
        }

        if (!$this->request->post['owlcarousel_module']['count'] || $this->request->post['owlcarousel_module']['count'] < 1) {
            $this->error['warning'] = $this->language->get('error_count');
        }

        if ((!$this->request->post['owlcarousel_module']['image_width'] || !$this->request->post['owlcarousel_module']['image_height'])||(($this->request->post['owlcarousel_module']['image_height']< 1) || ($this->request->post['owlcarousel_module']['image_width'] < 1))) {
            $this->error['warning'] = $this->language->get('error_image');
        }

        if (!$this->request->post['owlcarousel_module']['visible'] || $this->request->post['owlcarousel_module']['visible'] < 1) {
            $this->error['warning'] = $this->language->get('error_visible');
        }

        if (!$this->request->post['owlcarousel_module']['visible_1000'] || $this->request->post['owlcarousel_module']['visible_1000'] < 1) {
            $this->error['warning'] = $this->language->get('error_visible_1000');
        }

        if (!$this->request->post['owlcarousel_module']['visible_900'] || $this->request->post['owlcarousel_module']['visible_900'] < 1) {
            $this->error['warning'] = $this->language->get('error_visible_900');
        }

        if (!$this->request->post['owlcarousel_module']['visible_600'] || $this->request->post['owlcarousel_module']['visible_600'] < 1) {
            $this->error['warning'] = $this->language->get('error_visible_600');
        }

        if (!$this->request->post['owlcarousel_module']['visible_479'] || $this->request->post['owlcarousel_module']['visible_479'] < 1) {
            $this->error['warning'] = $this->language->get('error_visible_479');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}
?>
