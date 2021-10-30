<?php
//	@copyright	OC-HELP.com 2015 - 2017.
//	@website	https://oc-help.com
//	@support	support@oc-help.com
// 	@developer	Alexander Vakhovskiy (aka AlexWaha, Waha)

final class Smsru extends SmsGate {
    public function send() {
        //Sms Log
        $sms_log = new Log('sms_log.log');

        if ($this->username) {
            $credentials = Array(
                'api_id' => $this->username,
                'json' => '1',
            );

            $auth = file_get_contents("https://sms.ru/auth/check?" . http_build_query($credentials));

            $auth_result = json_decode($auth);

            $sms_log->write('(SMS.ru) Authentication: Status = ' . $auth_result->status);

            if ($auth_result->status == 'OK') {

                $balance = file_get_contents("https://sms.ru/my/balance?" . http_build_query($credentials));

                $balance_result = json_decode($balance);

                $sms_log->write('(SMS.ru) Balance: Status = ' . $balance_result->status . ' Balance: ' . $balance_result->balance);

                if ($this->to && $this->copy) {
                    $numbers = $this->prepPhone($this->to . ',' . $this->copy);
                } elseif ($this->to) {
                    $numbers = $this->prepPhone($this->to);
                } else {
                    $numbers = false;
                    $sms_log->write('(SMS.ru) Error: Phone destination not found!');
                }

                if ($this->from) {
                    $sender = $this->from;
                } else {
                    $sender = '';
                    $sms_log->write('(SMS.ru) Notice: Default Sender set! Please input real Sender');
                }

                if ($balance_result->balance && $numbers) {
                    $sms = Array(
                        'api_id' => $this->username,
                        'to'     => $numbers,
                        'msg'    => $this->message,
                        'from'   => $sender,
                        'time'   => 0,
                        'json' => '1'
                    );

                    $result = file_get_contents("https://sms.ru/sms/send?" . http_build_query($sms));

                    $send_result = json_decode($result);

                    if ($send_result->status == 'OK') {
                        $sms_log->write('(SMS.ru) SMS send: ' . $send_result->status . ' Balance: ' . $send_result->balance);
                    }

                    return $result;
                }
            } else {
               $sms_log->write('(SMS.ru) Error: SMS.ru Authentication failed!');
            }

        } else {
            $sms_log->write('(SMS.ru) Error: Please enter valid api_id in login(username) field!');
        }
    }

    public function prepPhone($phone) {

        $result = preg_replace('/[^0-9,]/', '', $phone);

        return $result;

    }
}
?>