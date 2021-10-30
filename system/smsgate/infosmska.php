<?php
//	@copyright	OC-HELP.com 2015 - 2017.
//	@website	https://oc-help.com
//	@support	support@oc-help.com
// 	@developer	Alexander Vakhovskiy (aka AlexWaha, Waha)

final class Infosmska extends SmsGate {
    public function send() {
        //Sms Log
        $sms_log = new Log('sms_log.log');

       if ($this->username && $this->password) {

			if($this->to && $this->copy){
				$numbers = $this->prepPhone($this->to . ',' . $this->copy);
			}elseif($this->to){
				$numbers = $this->prepPhone($this->to);
			}else{
				$sms_log->write('(Infosmska) Error: Phone destination not found!');
				$numbers = false;
			}

            $sms_id = $this->sendSMS($this->username, $this->password, $numbers, $this->message, $this->from);

            $sms_log->write('(Infosmska) :' . $sms_id);

        } else {
            $sms_log->write('(Infosmska) Error: Please set correct login/password!');
        }
    }

    //SendSMS
    public function sendSMS($login, $password, $phone, $text, $sender) {
        $host = "api.infosmska.ru";
        $fp = fsockopen($host, 80);
        fwrite($fp, "GET /interfaces/SendMessages.ashx" .
            "?login=" . rawurlencode($login) .
            "&pwd=" . rawurlencode($password) .
            "&phones=" . rawurlencode($phone) .
            "&message=" . rawurlencode($text) .
            "&sender=" . rawurlencode($sender) .
            " HTTP/1.1\r\nHost: $host\r\nConnection: Close\r\n\r\n");
        fwrite($fp, "Host: " . $host . "\r\n");
        fwrite($fp, "\n");
        $response = "";
        while (!feof($fp)) {
            $response .= fread($fp, 1);
        }
        fclose($fp);
        list($other, $responseBody) = explode("\r\n\r\n", $response, 2);
        list($other, $ids_str) = explode(":", $responseBody, 2);
        list($sms_id, $other) = explode(";", $ids_str, 2);

        return $sms_id;
    }

    public function prepPhone($phone) {
        $result = preg_replace('/[^0-9,]/', '', $phone);
        return $result;
    }
}

?>