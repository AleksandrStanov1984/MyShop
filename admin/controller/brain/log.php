<?php
class ControllerBrainLog extends Controller {
	private $error = array();

	public function index() {		
		$this->load->language('tool/log');
		
		$this->document->setTitle('Log Обновления Цен');
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$file_log = 'brain_price_update.txt';

		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

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

		$data['update_price'] = HTTPS_CATALOG .'index.php?route=import/brain_update';
        $data['update_down_table'] = HTTPS_CATALOG .'index.php?route=import/brain_update/UpdateStockStatusIdAdd';
        $data['update_status'] = HTTPS_CATALOG .'index.php?route=import/brain_update/UpdateStatusProduct';

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('brain/log', $data));
	}
}
