<?php
class ModelConfirmStatus extends Model {


public function ConfirmStatus($order_id) 
{
$this->db->query("UPDATE " . DB_PREFIX . "order SET confirm_status = '1' WHERE order_id = '" . (int)$order_id . "'");     

}

}