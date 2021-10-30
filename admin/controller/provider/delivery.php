<?php
class ControllerProviderDelivery extends Controller {
	private $error = array();

	public function index() {		
		$this->load->language('tool/log');
		
		$this->document->setTitle('Загрузка файла Тарифов доставки');

		$data['heading_title'] = 'Загрузка файла Тарифов доставки';
		
		$data['text_list'] = 'Brain Корректировка';
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['button_download'] = $this->language->get('button_download');
		$data['button_clear'] = $this->language->get('button_clear');

		$file_log = 'delivery_update.txt';

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

        if (isset($this->session->data['error_file'])) {
            $data['error_file'] = $this->session->data['error_file'];
            unset($this->session->data['error_file']);
        } else {
            $data['error_file'] = '';
        }

		$data['download'] = $this->url->link('provider/delivery/download', 'token=' . $this->session->data['token'], true);
		$data['clear'] = $this->url->link('provider/delivery/clear', 'token=' . $this->session->data['token'], true);
        $data['action'] = $this->url->link('provider/delivery/import', 'token=' . $this->session->data['token'], true);

        $data['log'] = '';

		$file = DIR_LOGS . $file_log;

		if (file_exists($file)) {
			$size = filesize($file);

			if ($size >= 5242880) {
				$suffix = array(
					'B',
					'KB',
					'MB',
					'GB',
					'TB',
					'PB',
					'EB',
					'ZB',
					'YB'
				);

				$i = 0;

				while (($size / 1024) > 1) {
					$size = $size / 1024;
					$i++;
				}

				$data['error_warning'] = sprintf($this->language->get('error_warning'), basename($file), round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i]);
			} else {
				$data['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
			}
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('provider/delivery', $data));
	}

	public function download() {
		$this->load->language('tool/log');

		$file = DIR_LOGS . 'delivery_update.txt';

		if (file_exists($file) && filesize($file) > 0) {
			$this->response->addheader('Pragma: public');
			$this->response->addheader('Expires: 0');
			$this->response->addheader('Content-Description: File Transfer');
			$this->response->addheader('Content-Type: application/octet-stream');
			$this->response->addheader('Content-Disposition: attachment; filename="' . $this->config->get('config_name') . '_' . date('Y-m-d_H-i-s', time()) . '.log"');
			$this->response->addheader('Content-Transfer-Encoding: binary');

			$this->response->setOutput(file_get_contents($file, FILE_USE_INCLUDE_PATH, null));
		} else {
			$this->session->data['error'] = sprintf($this->language->get('error_warning'), basename($file), '0B');

			$this->response->redirect($this->url->link('provider/delivery', 'token=' . $this->session->data['token'], true));
		}
	}

	public function clear() {
		$this->load->language('tool/log');

		if (!$this->user->hasPermission('modify', 'provider/delivery')) {
			$this->session->data['error'] = $this->language->get('error_permission');
		} else {
			$file = DIR_LOGS . 'delivery_update.txt';

			$handle = fopen($file, 'w+');

			fclose($handle);

			$this->session->data['success'] = $this->language->get('text_success');
		}

		$this->response->redirect($this->url->link('provider/delivery', 'token=' . $this->session->data['token'], true));
	}

    public function import(){
        set_time_limit(0);
        $url = '';
        if(!isset($_FILES['import_file']['tmp_name'])){
            $this->session->data['error_file'] = 'Файл не выбран!!!';
        }else {
            $count_string = 0;
            $this->getLogsDelivery('delivery_update.txt','Началась Обработка Файла');
            $tmpFilename = $_FILES['import_file']['tmp_name'];
            $f = fopen($tmpFilename, "rt") or die("Ошибка!");
            for ($i = 0; ($data = fgetcsv($f, 1000, ";")) !== false; $i++) {
                $num = count($data);
                for ($c = 0; $c < $num; $c++) {
                  $string = explode(',',$data[$c]);
                  if(strlen($string[0]) > 0 ){
                      $this->db->query("UPDATE " . DB_PREFIX . "product SET 
                      np_branch = '" . (float)trim($string['1']) . "', 
                      np_courier = '" . (float)trim($string['2']) . "',
                      np_sz_courier = '" . (float)trim($string['3']) . "'
                      WHERE sku = '" . trim($string[0]) . "'");
                      $count_string++;
                  }
                }
            }
            $this->getLogsDelivery('delivery_update.txt','Количество строк в файле '. $count_string);
            $this->getLogsDelivery('delivery_update.txt','Завершение обработки файла');
            fclose($f);
        }
        $this->response->redirect($this->url->link('provider/delivery', 'token=' . $this->session->data['token'] . $url, true));
    }

    public function getLogsDelivery($file, $message){
        $filename = $file;
        $handle = fopen(DIR_LOGS . $filename, 'a');
        fwrite($handle, date('Y-m-d G:i:s') . ' - ' . print_r($message, true) . "\n");
        fclose($handle);
    }
}
