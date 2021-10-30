<?php
//	@copyright	OC-HELP.com 2015 - 2017.
//	@website	https://oc-help.com
//	@support	support@oc-help.com
// 	@developer	Alexander Vakhovskiy (aka AlexWaha, Waha)

final class Smscua extends SmsGate {
	public function send() {
		//Sms Log
		$sms_log = new Log('sms_log.log');

		$client = new SoapClient('https://smsc.ua/sys/soap.php?wsdl');

		if ($this->username && $this->password) {
			$credentials = Array ( 
				'login' => $this->username, 
				'psw' => $this->password 
			);

			$balance = $client->get_balance($credentials);
		
			$sms_log->write('(SMSC.ua) Balance: ' . $balance->balanceresult->balance . ' Error: ' . $balance->balanceresult->error); 

			if($this->to && $this->copy){
				$numbers = $this->prepPhone($this->to . ',' . $this->copy);
			}elseif($this->to){
				$numbers = $this->prepPhone($this->to);
			}else{
				$numbers = false;
				$sms_log->write('(SMSC.ua) Error: Phone destination not found!');
			}

			if($this->from){
				$sender = $this->from;
			}else{
				$sender = '';
				$sms_log->write('(SMSC.ua) Notice: Default Sender set! Please input real Sender');
			}

			if($balance->balanceresult->balance && $numbers){
				$sms = Array ( 
					'login'  => $this->username, 
					'psw' 	 => $this->password,
					'phones' => $numbers, 
					'mes' 	 => $this->message,
					'sender' => $sender,
					'time'	 => 0
				); 

				$result = $client->send_sms($sms);
				
				if($result->sendresult->cnt){
					$sms_log->write('(SMSC.ua) SMS send: ' . $result->sendresult->cnt . ' Cost: ' . $result->sendresult->cost);
				}
				
				return $result;
			}

		}else{
			$sms_log->write('(SMSC.ua) Error: SMSC.ua Authentication failed!');
		}
	}

    public function prepPhone($phone) {

        $result = preg_replace('/[^0-9,]/', '', $phone);

        return $result;

    }
}
?>