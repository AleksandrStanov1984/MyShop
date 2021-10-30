<?php
/**
 * @author Shubin Sergei <is.captain.fail@gmail.com>
 * @license MIT
 * 17.08.2020 2020
 * @property \DB db
 */
class ControllerEventSZCustomEvent extends Controller {
    public function track_order($route, $data, $orderId) {
        if ($route === 'checkout/order/addOrder') {
            $orderId = (int)$orderId;
            $clientId = $this->db->escape($this->request->cookie['_ga_ga']);
            $this->db->query("UPDATE oc_order SET ga_client_id = '{$clientId}' WHERE order_id = '{$orderId}'");
            $log = new \Log("szcustomevent.track_order.log");
            $log->write("Order[{$orderId}]: {$clientId}");
        }
    }
}
