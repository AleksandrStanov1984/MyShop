<?php

class ControllerFilterOcfilter extends Controller{
    private $error = array();

    public function index(){

        $this->load->model('catalog/ocfilter');
        $this->load->model('catalog/attribute');
        $data = $this->load->language('filter/ocfilter');

        $this->load->model('setting/setting');

        $this->document->setTitle($this->language->get('heading_title'));

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['token'] = $this->session->data['token'];

        $filter_data = array(
            'sort'        => 'name',
            'order'       => 'ASC'
        );

        $data['options'] = array();

        $results  = $this->model_catalog_ocfilter->getOptions($filter_data);

        foreach ($results as $result) {

            $categories = '';

            foreach ($result['categories'] as $category) {
                $categories .= '->' . $category['name'];
            }

            $data['options'][] = array(
                'option_id'     => $result['option_id'],
                'category_name' => $categories,
                'name'          => $result['name']
            );
        }

        $results = $this->model_catalog_attribute->getAttributes($filter_data);

        $data['attributes'] = array();

        foreach ($results as $result) {
            $data['attributes'][] = array(
                'attribute_id'    => $result['attribute_id'],
                'name'            => $result['name']
                );
        }


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('filter/ocfilter_copy', $data));
    }

    public function copyFilters()
    {
        $json = array();

        $this->load->language('filter/ocfilter');
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $this->load->model('filter/ocfilter');
            $this->model_filter_ocfilter->copyFilter($this->request->post);
            $json['success'] = $this->language->get('text_complete');
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    protected function validate(){
        if (!$this->user->hasPermission('modify', 'filter/ocfilter')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }
}