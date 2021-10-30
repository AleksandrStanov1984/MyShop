<?php
class ControllerToolYMLReplace extends Controller {
	private $error = array();

	public function index() {		
		$this->load->language('tool/log');
		
		$this->document->setTitle('Структура YML');

		$data['heading_title'] = 'Структура YML';
		
		$data['text_list'] = 'Структура YML';
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

        $data['action'] = $this->url->link('tool/yml_replace/str_replace', 'token=' . $this->session->data['token'], true);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('tool/yml_replace', $data));
	}


    public function str_replace()
    {
        $url = '';
        $tmpFilename = $_FILES['file']['tmp_name'];

        $xmlstr = file_get_contents($tmpFilename);

        if (isset($this->request->post)) {

            foreach ($this->request->post['string_replece'] as $string_replece) {
                $xmlstr = strtr($xmlstr, array(
                    '<' . $string_replece['from'] . '>' => '<' . $string_replece['to'] . '>'
                ));
            }

            foreach ($this->request->post['string_replece'] as $string_replece) {
                $xmlstr = strtr($xmlstr, array(
                    '</' . $string_replece['from'] . '>' => '</' . $string_replece['to'] . '>'
                ));
            }


            $output = $xmlstr;
            $dom_xml = new DomDocument();
            $dom_xml->loadXML($output);
            $path = DIR_DOWNLOAD . $_FILES['file']['name'];
            $dom_xml->save($path);
            $this->session->data['success'] = 'Выполнено ' . DIR_DOWNLOAD . $_FILES['file']['name'];
        }
        $this->response->redirect($this->url->link('tool/yml_replace', 'token=' . $this->session->data['token'] . $url, true));
    }

}
