<?php
class ControllerBrainBrainResult extends Controller {
	private $error = array();
    private $login = 'sm@sz.ua';
    private $password = '03330333';
    private $key = '';

	public function index() {
		$this->load->language('brain/brain_result');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('brain/brain');

		$this->getList();
	}

	public function edit() {
		$this->load->language('brain/brain_result');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('brain/brain');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->model_brain_brain->editProductPrice($this->request->get['id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('brain/brain_result', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('brain/brain_result');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('brain/brain');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $id) {
				$this->model_brain_brain->deleteProductPrice($id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('brain/brain_result', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {

        if (isset($this->request->get['filter_product_id'])) {
            $filter_product_id = $this->request->get['filter_product_id'];
        } else {
            $filter_product_id = null;
        }

        if (isset($this->request->get['filter_sku'])) {
            $filter_sku = $this->request->get['filter_sku'];
        } else {
            $filter_sku = null;
        }

        $url = '';

        if (isset($this->request->get['filter_product_id'])) {
            $url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
        }

        if (isset($this->request->get['filter_sku'])) {
            $url .= '&filter_sku=' . $this->request->get['filter_sku'];
        }

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}


		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

        if (isset($this->request->get['filter_product_id'])) {
            $url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
        }

        if (isset($this->request->get['filter_sku'])) {
            $url .= '&filter_sku=' . $this->request->get['filter_sku'];
        }

        $data['token'] = $this->session->data['token'];

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('brain/brain_result', 'token=' . $this->session->data['token'] . $url, true)
		);


        $data['add_special'] = $this->url->link('brain/brain_result/add_special', 'token=' . $this->session->data['token'] . $url, true);
        $data['delete_special_table'] = $this->url->link('brain/brain_result/delete_special_table', 'token=' . $this->session->data['token'] . $url, true);
        $data['update_price'] = $this->url->link('brain/brain_result/update_price', 'token=' . $this->session->data['token'] . $url, true);
        $data['delete_special'] = $this->url->link('brain/brain_result/delete_special', 'token=' . $this->session->data['token'] . $url, true);
        $data['oldpriceproduct'] = $this->url->link('brain/brain_result/oldpriceproduct', 'token=' . $this->session->data['token'] . $url, true);
        $data['getprice'] = $this->url->link('brain/brain_result/getPrice', 'token=' . $this->session->data['token'] . $url, true);
        $data['createtable'] = $this->url->link('brain/brain_result/createtable', 'token=' . $this->session->data['token'] . $url, true);

		$data['delete'] = $this->url->link('brain/brain_result/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['brains'] = array();

		$filter_data = array(
		    'filter_product_id'   => $filter_product_id,
            'filter_sku'          => $filter_sku,
			'start'               => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'               => $this->config->get('config_limit_admin')
		);

		$brain_total = $this->model_brain_brain->getTotalProductPrisecs();

		$results = $this->model_brain_brain->getProductPrisecs($filter_data);

		foreach ($results as $result) {
			$data['brains'][] = array(
				'id'              => $result['id'],
				'product_id'      => $result['product_id'],
                'sku'             => $result['sku'],
                'price_1_file'    => $result['price_1_file'],
                'price_2_file'    => $result['price_2_file'],
                'stock_status_id' => $result['stock_status_id'],
                'price_base'      => $result['price_base'],
                'price_rrc'       => $result['price_rrc'],
                'price_1'         => $result['price_1'],
                'price_2'         => $result['price_2'],
                'price'           => $result['price'],
                'special'         => $result['special'],
				'edit'            => $this->url->link('brain/brain_result/edit', 'token=' . $this->session->data['token'] . '&id=' . $result['id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_action'] = $this->language->get('column_action');

		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');

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

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

        if (isset($this->request->get['filter_product_id'])) {
            $url .= '&filter_product_id=' . $this->request->get['filter_product_id'];
        }

        if (isset($this->request->get['filter_sku'])) {
            $url .= '&filter_sku=' . $this->request->get['filter_sku'];
        }

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$url = '';

		$pagination = new Pagination();
		$pagination->total = $brain_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('brain/brain_result', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($brain_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($brain_total - $this->config->get('config_limit_admin'))) ? $brain_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $brain_total, ceil($brain_total / $this->config->get('config_limit_admin')));

        $data['filter_product_id'] = $filter_product_id;
        $data['filter_sku'] = $filter_sku;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('brain/brain_list', $data));
	}

	protected function getForm() {

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_form'] = $this->language->get('text_edit');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('brain/brain_result', 'token=' . $this->session->data['token'] . $url, true)
		);


		$data['action'] = $this->url->link('brain/brain_result/edit', 'token=' . $this->session->data['token'] . '&id=' . $this->request->get['id'] . $url, true);
		$data['cancel'] = $this->url->link('brain/brain_result', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$info = $this->model_brain_brain->getProductPrice($this->request->get['id']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['price_1_file'])) {
			$data['price_1_file'] = $this->request->post['price_1_file'];
		} elseif (!empty($info)) {
			$data['price_1_file'] = $info['price_1_file'];
		} else {
			$data['price_1_file'] = '';
		}

        if (isset($this->request->post['price_2_file'])) {
            $data['price_2_file'] = $this->request->post['price_2_file'];
        } elseif (!empty($info)) {
            $data['price_2_file'] = $info['price_2_file'];
        } else {
            $data['price_2_file'] = '';
        }

        if (isset($this->request->post['price_base'])) {
            $data['price_base'] = $this->request->post['price_base'];
        } elseif (!empty($info)) {
            $data['price_base'] = $info['price_base'];
        } else {
            $data['price_base'] = '';
        }

        if (isset($this->request->post['price_rrc'])) {
            $data['price_rrc'] = $this->request->post['price_rrc'];
        } elseif (!empty($info)) {
            $data['price_rrc'] = $info['price_rrc'];
        } else {
            $data['price_rrc'] = '';
        }

        if (isset($this->request->post['price_1'])) {
            $data['price_1'] = $this->request->post['price_1'];
        } elseif (!empty($info)) {
            $data['price_1'] = $info['price_1'];
        } else {
            $data['price_1'] = '';
        }

        if (isset($this->request->post['price_2'])) {
            $data['price_2'] = $this->request->post['price_2'];
        } elseif (!empty($info)) {
            $data['price_2'] = $info['price_2'];
        } else {
            $data['price_2'] = '';
        }

        if (isset($this->request->post['price'])) {
            $data['price'] = $this->request->post['price'];
        } elseif (!empty($info)) {
            $data['price'] = $info['price'];
        } else {
            $data['price'] = '';
        }

        if (isset($this->request->post['special'])) {
            $data['special'] = $this->request->post['special'];
        } elseif (!empty($info)) {
            $data['special'] = $info['special'];
        } else {
            $data['special'] = '';
        }

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('brain/brain_form', $data));
	}

    public function add_special(){
        set_time_limit(0);
        $url = '';
        $this->load->model('brain/brain');
        $this->getLogsBrain('brain_price_update.txt', 'Создаем Зачеркнутые Цены');
        $results_special = $this->model_brain_brain->getSelectSpecial();
        $count_add = 0;
        $count_update = 0;
        if ($results_special) {
            foreach ($results_special as $result_special) {
                $special_product_id = $this->model_brain_brain->getSearchSpecialProduct($result_special['product_id']);
                if ($special_product_id) {
                    $this->model_brain_brain->getUpdateSpecialProduct($result_special['product_id'], $result_special['special']);
                    $count_update++;
                } else {
                    $this->model_brain_brain->getAddSpecialProduct($result_special['product_id'], $result_special['special']);
                    $count_add++;
                }
                $this->getLogsBrain('brain_price_update.txt', 'Создано записей ' . $count_add);
                $this->getLogsBrain('brain_price_update.txt', 'Обновлено записей ' . $count_update);
                $this->getLogsBrain('brain_price_update.txt', 'Выполнено создание Зачеркнутых цен');
                $this->session->data['success'] = 'Выполнено ' . 'Обновлено записей ' . $count_update . ' Создано записей ' . $count_add;
            }
        }
        $this->response->redirect($this->url->link('brain/brain_result', 'token=' . $this->session->data['token'] . $url, true));
    }

    public function delete_special_table(){
        set_time_limit(0);
        $url = '';
        $this->load->model('brain/brain');
        $this->getLogsBrain('brain_price_update.txt', 'Удаление Зачеркнутых Цен');
        $results_special = $this->model_brain_brain->getSelectSpecial();
        $count_delete = 0;
        if($results_special) {
            foreach ($results_special as $result_special) {
                $this->model_brain_brain->deleteSpecial($result_special['product_id']);
                $count_delete++;
            }
            $this->getLogsBrain('brain_price_update.txt', 'Удалено Зачеркнутых Цен ' . $count_delete);
            $this->getLogsBrain('brain_price_update.txt', 'Выполнено Удаление Зачеркнутых Цен');
            $this->session->data['success'] = 'Удалено Зачеркнутых Цен ' . $count_delete;
        }
        $this->response->redirect($this->url->link('brain/brain_result', 'token=' . $this->session->data['token'] . $url, true));
    }

    public function update_price(){
        set_time_limit(0);
        $url = '';
        $this->load->model('brain/brain');
        $this->getLogsBrain('brain_price_update.txt', 'Обновление цен продуктов');
        $count_update = 0;
        $results_product = $this->model_brain_brain->getProductPrices();
        if($results_product) {
            foreach ($results_product as $product) {
                $this->model_brain_brain->getUpdateProductPrices($product['product_id'],$product['price'], $product['stock_status_id']);
                $count_update++;
            }
            $this->getLogsBrain('brain_price_update.txt', 'Обновлено цен ' . $count_update);
            $this->getLogsBrain('brain_price_update.txt', 'Выполнено Обновление цен');
            $this->session->data['success'] = 'Обновлено цен ' . $count_update;
        }
        $this->response->redirect($this->url->link('brain/brain_result', 'token=' . $this->session->data['token'] . $url, true));
    }

    public function delete_special(){
        set_time_limit(0);
        $url = '';
        $this->load->model('brain/brain');
        $this->getLogsBrain('brain_price_update.txt', 'Удаление Зачеркнутых Цен');
        $results_special = $this->model_brain_brain->getSelectSpecial();
        $count_delete = 0;
        if($results_special) {
            foreach ($results_special as $result_special) {
                $this->model_brain_brain->deleteSpecial($result_special['product_id']);
                $count_delete++;
            }
            $this->getLogsBrain('brain_price_update.txt', 'Удалено Зачеркнутых Цен ' . $count_delete);
            $this->getLogsBrain('brain_price_update.txt', 'Выполнено Удаление Зачеркнутых Цен');
            $this->session->data['success'] = 'Удалено Зачеркнутых Цен ' . $count_delete;
        }
        $this->response->redirect($this->url->link('brain/brain_result', 'token=' . $this->session->data['token'] . $url, true));
    }

    public function oldpriceproduct(){
        set_time_limit(0);
        $url = '';
        $this->load->model('brain/brain');
        $this->getLogsBrain('brain_price_update.txt', 'Откат цен продуктов');
        $count_update = 0;
        $results_product = $this->model_brain_brain->getProductPricesOld();
        if($results_product) {
            foreach ($results_product as $product) {
                $this->model_brain_brain->getUpdateProductPrices($product['product_id'],$product['price_rrc']);
                $count_update++;
            }
            $this->getLogsBrain('brain_price_update.txt', 'Откат цен количество ' . $count_update);
            $this->getLogsBrain('brain_price_update.txt', 'Выполнен откат цен');
            $this->session->data['success'] = 'Выполнено обновлено цен ' . $count_update;
        }
        $this->response->redirect($this->url->link('brain/brain_result', 'token=' . $this->session->data['token'] . $url, true));
    }

    public function getPrice(){
        set_time_limit(0);
        $url = '';
        $this->load->model('brain/brain');
        $this->model_brain_brain->getRestPrice();
        $results_product = $this->model_brain_brain->getPriceProduct();
        $count_string = 0;
        if ($results_product) {
            foreach ($results_product as $product) {
                $this->model_brain_brain->getPriceProductUpdate($product['product_id']);

                $result_product = $this->model_brain_brain->getSearch($product['product_id']);
                if (isset($result_product['product_id'])) {
                    $price_1_file = $result_product['price_1_file'];
                    $price_2_file = $result_product['price_2_file'];
                    $price_rrc = $result_product['price_rrc'];
                    $price_base = $result_product['price_base'];
                    $stock_status_id = 0;
                    $price = 0;
                    $special = 0;

                    //если PRISE_2_FILE * PRISE_RRC < 100
                    $pr = $price_2_file * $price_rrc;
                    if ($pr < 100) {
                        $price_2 = $price_2_file * $price_rrc;
                    } else {
                        //если PRISE_2_FILE * PRISE_RRC > 10000
                        $pr2 = $price_2_file * $price_rrc;
                        if ($pr2 > 10000) {
                            //то PRISE_2 = округление до сотой (PRISE_2_FILE * PRISE_RRC) - 10
                            $price_2 = round(($price_2_file * $price_rrc), -2) - 1;
                        } else {
                            //иначе PRISE_2 = округление до десятой (PRISE_2_FILE * PRISE_RRC) - 1
                            $price_2 = round(($price_2_file * $price_rrc), -1) - 1;
                        }
                    }
                    //PRISE_1 = PRISE_1_FILE * PRISE_2
                    $price_1 = round(($price_1_file * $price_2), 0);
                    //если PRISE_2 < PRISE_BASE
                    if ($price_2 < $price_base) {
                        //STOCK_STATUS_ID = 5
                        $stock_status_id = 5;
                    } else {
                        if ($price_1 == 0) {
                            $special = null;
                            $price = $price_2;
                        } else {
                            $special = $price_2;
                            $price = $price_1;
                        }
                    }

                    if($stock_status_id == 5){
                        $price = $price_rrc;
                        $special = 0.0000;
                    }

                    $this->model_brain_brain->updProductPrice($result_product['product_id'], $stock_status_id, $price_1, $price_2, $price, $special);
                    $count_string++;
                }


            }
            $this->session->data['success'] = 'Выполнено обновлено цен ' . $count_string;
        }
        $this->response->redirect($this->url->link('brain/brain_result', 'token=' . $this->session->data['token'] . $url, true));
    }

    public function createtable(){
        set_time_limit(0);
        $url = '';
        $this->load->model('brain/brain');
        $this->model_brain_brain->getDeleteVse();
        $results_product = $this->model_brain_brain->getVse();
        $count_string = 0;
        if ($results_product) {
            if($this->GetBrainKey()) {
                foreach ($results_product as $product) {
                    $url = "http://api.brain.com.ua/product/" . $product['brain_id'] . "/" . $this->key;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    $output = curl_exec($ch);
                    curl_close($ch);
                    $arr = json_decode($output, true);
                    $this->model_brain_brain->addProductVW($product['sku'], $arr['result']['volume'], $arr['result']['weight']);
                    $count_string++;
                }
            }
            $this->session->data['success'] = 'Создано записей ' . $count_string;
        }
        $this->response->redirect($this->url->link('brain/brain_result', 'token=' . $this->session->data['token'] . $url, true));
    }

    public function GetBrainKey() {
        if($this->key != ''){
            return true;
        }
        $url = "http://api.brain.com.ua/auth";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array (
            'login' => $this->login,
            'password' => md5($this->password),
        ));
        curl_setopt($ch, CURLOPT_URL, $url);
        $output = curl_exec($ch);
        curl_close($ch);
        $arr = json_decode($output, true);
        if(isset($arr['result']) and isset($arr['status']) AND $arr['status'] == 1){
            $this->key = $arr['result'];
            return true;
        }
        return false;
    }

    public function getLogsBrain($file, $message){
        $filename = $file;
        $handle = fopen(DIR_LOGS . $filename, 'a');
        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . print_r($message, true) . "\n");
        fclose($handle);
    }
}