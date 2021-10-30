<?php


require_once($_SERVER['DOCUMENT_ROOT'] . '/dump.php' ); //for debug only


class ControllerOmega extends Controller {
    private $error = array();
    private $login = 'tov@sz.ua';
    private $password = 'sz3330sz';

    private $ip_adr = '49.12.34.170';
    private $key = 'WrblqlQhMFIcKXZXCv6jfpj9yPRZRUed';

    public function index() {
        $this->load->language('brain/brain_result');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('brain/brain');

        $this->getList();
    }
}
