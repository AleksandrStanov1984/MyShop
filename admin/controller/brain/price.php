<?php
class ControllerBrainPrice extends Controller {
	private $error = array();

	public function index() {		
		$this->load->language('tool/log');
		
		$this->document->setTitle('Brain Корректировка Цен');

		$data['heading_title'] = 'Brain Корректировка Цен';
		
		$data['text_list'] = 'Brain Корректировка Цен';
		$data['text_confirm'] = $this->language->get('text_confirm');

		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
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

        $data['action'] = $this->url->link('brain/price/import', 'token=' . $this->session->data['token'], true);
        $data['action_zagluhka'] = $this->url->link('brain/price/zagluhka', 'token=' . $this->session->data['token'], true);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('brain/price', $data));
	}

    public function import(){
        set_time_limit(0);
        $url = '';
        $this->load->model('brain/brain');
        $this->model_brain_brain->delete_product_price();
        $count_string = 0;
        $this->getLogsPrice('brain_update.txt', 'Обновление Цен Brain');
        $tmpFilename = $_FILES['import_file']['tmp_name'];
        $f = fopen($tmpFilename, "rt") or die("Ошибка!");
        for ($i = 0; ($data = fgetcsv($f, 1000, ";")) !== false; $i++) {
            $num = count($data);
            for ($c = 0; $c < $num; $c++) {
                $stock_status_id = 0;
                $string = explode(',"', $data[$c]);
                $sku = trim($string[0]);
                $string[1] = trim($string[1]);
                $string[2] = trim($string[2]);
                $string[1] = str_replace(',', '.', $string[1]);
                $string[2] = str_replace(',', '.', $string[2]);

                $price_1_file = round($string[1], 3);
                $price_2_file = round($string[2], 3);

                $result_product = $this->model_brain_brain->getSearchProduct($sku);
                if (isset($result_product['product_id'])) {

                    if ($result_product) {
                        $price_rrc = $result_product['price_rrc'];
                        $price_base = $result_product['price_base'];
                    } else {
                        $price_rrc = 0.0000;
                        $price_base = 0.0000;
                    }

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

                    $this->model_brain_brain->addProductPrice($result_product['product_id'], $sku, $price_1_file, $price_2_file, $stock_status_id ,$price_base, $price_rrc, $price_1, $price_2, $price, $special);
                    $count_string++;
                }
            }
        }
        $this->getLogsPrice('brain_price_update.txt', 'Создано записей ' . $count_string);
        $this->getLogsPrice('brain_price_update.txt', 'Выполнено Обновление Цен Brain');
        fclose($f);
        $this->session->data['success'] = 'Выполнено!!!';
        $this->response->redirect($this->url->link('brain/price', 'token=' . $this->session->data['token'] . $url, true));
    }


    public function zagluhka(){
        set_time_limit(0);
        $url = '';
        $this->load->model('brain/brain');
        $count_string = 0;
        $this->getLogsPrice('brain_price_update.txt', 'Отключение обновление продуктов');
        $tmpFilename = $_FILES['zagluhka_file']['tmp_name'];
        $f = fopen($tmpFilename, "rt") or die("Ошибка!");
        for ($i = 0; ($data = fgetcsv($f, 1000, ";")) !== false; $i++) {
            $num = count($data);
            for ($c = 0; $c < $num; $c++) {
                $this->model_brain_brain->getUpdateProductStatus(trim($data[$c]));
                $count_string++;
            }
        }
        $this->getLogsPrice('brain_price_update.txt', 'Количество отключенных продуктов ' . $count_string);
        $this->getLogsPrice('brain_price_update.txt', 'Выполнено отключение продуктов');
        fclose($f);
        $this->session->data['success'] = 'Выполнено!!!';
        $this->response->redirect($this->url->link('brain/price', 'token=' . $this->session->data['token'] . $url, true));
    }

    public function getLogsPrice($file, $message){
        $filename = $file;
        $handle = fopen(DIR_LOGS . $filename, 'a');
        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . print_r($message, true) . "\n");
        fclose($handle);
    }
}
