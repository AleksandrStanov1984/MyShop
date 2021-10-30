<?php
//	@copyright	OC-HELP.com 2015 - 2017.
//	@website	https://oc-help.com
//	@support	support@oc-help.com
// 	@developer	Alexander Vakhovskiy (aka AlexWaha, Waha)

final class Turbosms extends SmsGate {
	public function send() {
		//Sms Log
		$sms_log = new Log('sms_log.log');

		$client = new SoapClient ('http://turbosms.in.ua/api/wsdl.html');

		$credentials = Array (
			'login' => $this->username,
			'password' => $this->password
		);

		$auth = $client->Auth($credentials);

		$sms_log->write('(Turbo SMS) ' . $auth->AuthResult);

		$balance = $client->GetCreditBalance();

		$sms_log->write('(Turbo SMS) Balance:' . $balance->GetCreditBalanceResult);
		
		if($this->to && $this->copy){
			$numbers = $this->to . ',' . $this->copy;
		}elseif($this->to){
			$numbers = $this->to;
		}else{
			$sms_log->write('(Turbo SMS) Error: Turbo SMS Phone destination not found!');
			$numbers = false;
		}


		if($this->from){
			$sender = $this->from;
		}else{
			$sender = 'Msg';
			$sms_log->write('(Turbo SMS) Notice: Default Sender set! Please input real Sender');
		}

		if($auth && $numbers){
			$sms = Array (
				'sender' => $sender,
				'destination' => $numbers,
				'text' => $this->message
			);

			$result = $client->SendSMS($sms);

			if($result){
				//$neonFullResults = print_r($result->SendSMSResult, true);
				$neonFullResults = print_r($numbers, true);
				//$sms_log->write('(Turbo SMS) ' . $result->SendSMSResult->ResultArray[0]);
				$sms_log->write('(Tu3rbo SMS) ' . $neonFullResults);
			}

		return $result;

		}else{
			$sms_log->write('(Turbo SMS) Error: Turbo SMS Authentication failed!');
		}
	}
}
?>