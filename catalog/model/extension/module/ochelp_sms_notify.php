<?php
class ModelExtensionModuleOchelpSmsNotify extends Model {
    public function sendOrderStatusSms($order_id, $order_status_id, $comment = false, $sendsms) {
        $this->load->model('checkout/order');
        //SMS send with order status
        if ($this->config->get('sms_notify_order_alert') && $this->config->get('sms_notify_order_status') && in_array($order_status_id, $this->config->get('sms_notify_order_status'))) {

            $order_info = $this->model_checkout_order->getOrder($order_id);
            if ($order_info['order_status_id'] && $order_status_id && $sendsms) {

                $orderstatus_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int) $order_status_id . "' AND language_id = '" . (int) $order_info['language_id'] . "'");

                if ($orderstatus_query->num_rows) {
                    $sms_order_status = $orderstatus_query->row['name'];
                } else {
                    $sms_order_status = false;
                }

                $phone = preg_replace("/[^0-9]/", '', $order_info['telephone']);
                $sms_status_template = $this->config->get('sms_notify_status_template');
                if ($sms_order_status) {
                    $options = array(
                        'to' => $phone,
                        'from' => $this->config->get('sms_notify_from'),
                        'username' => $this->config->get('sms_notify_gate_username'),
                        'password' => $this->config->get('sms_notify_gate_password'),
                        'message' => str_replace(array('{ID}', '{DATE}', '{TIME}', '{SUM}', '{PHONE}', '{COMMENT}', '{STATUS}'),
                            array($order_id, date('d.m.Y'), date('H:i'), $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']), $order_info['telephone'], $comment, $sms_order_status), $sms_status_template[$order_status_id]),
                    );

					$sms = new Sms($this->config->get('sms_notify_gatename'), $options);
                    $sms->send();
                }
            }
        }else{
            $this->log->write('OCHELP.com SMS Notify: Please set orders statuses for sms messaging');
        }
    }

    public function sendServiceSms($order_id) {
        $this->load->model('checkout/order');

        $order_info = $this->model_checkout_order->getOrder($order_id);

        if($order_info){
            // Send Client SMS if configure
            if ($this->config->get('sms_notify_client_alert')) {
                $client_phone = preg_replace("/[^0-9]/", '', $order_info['telephone']);
                $options = array(
                    'to'       => $client_phone,
                    'from'     => $this->config->get('sms_notify_from'),
                    'username' => $this->config->get('sms_notify_gate_username'),
                    'password' => $this->config->get('sms_notify_gate_password'),
                    'message'  => str_replace(array('{ID}', '{DATE}', '{TIME}', '{SUM}', '{PHONE}'),
                        array($order_id, date('d.m.Y'), date('H:i'), $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']), $order_info['telephone']),
                        $this->config->get('sms_notify_client_template'))
                );

                $sms = new Sms($this->config->get('sms_notify_gatename'), $options);
                $sms->send();
            }

            // Send Admin SMS if configure
            if ($this->config->get('sms_notify_admin_alert')) {
                $admin_phone = preg_replace("/[^0-9]/", '', $this->config->get('sms_notify_to'));
                $options = array(
                    'to'       => $admin_phone,
                    'from'     => $this->config->get('sms_notify_from'),
                    'copy'     => $this->config->get('sms_notify_copy'),
                    'username' => $this->config->get('sms_notify_gate_username'),
                    'password' => $this->config->get('sms_notify_gate_password'),
                    'message'  => str_replace(array('{ID}', '{DATE}', '{TIME}', '{SUM}', '{PHONE}'),
                        array($order_id, date('d.m.Y'), date('H:i'), $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']), $order_info['telephone']),
                        $this->config->get('sms_notify_admin_template'))
                );

                $sms = new Sms($this->config->get('sms_notify_gatename'), $options);
                $sms->send();
            }
        }
    }
}