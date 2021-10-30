<?php
class ControllerConfirmStatus extends Controller {
	public function index($order_id) {

  $this->load->model('checkout/confirm_status');
                                                    
  $results = $this->model_confirm_status->ConfirmStatus($order_id);

 }

}
