<?php
class ControllerExtensionFeedFassetFilter extends Controller {

	public function index() {

		if(!isset($this->request->get['key']) || $this->request->get['key'] != 'secure27u56') exit("access denied");
		if ($this->config->get('fasset_filter_status')) {


			$file = 'anyqueryfacets.csv';
			$output = '';
			if (file_exists($file)) {
				$output .= preg_replace('/(?<=^|;)"(.+)"(?=;)/','$1',file_get_contents($file));
			}

			$this->response->addHeader('Content-Type: text/csv');
			$this->response->addHeader('Content-Disposition: attachment; filename="anyqueryfacets.csv"');
			$this->response->addHeader('Pragma: no-cache');
			$this->response->addHeader('Expires: 0');
			$this->response->setOutput($output);

		}
	}

}
