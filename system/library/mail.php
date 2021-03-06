<?php
class Mail {
	protected $to;
	protected $from;
	protected $sender;
	protected $reply_to;
	protected $subject;
	protected $text;
	protected $html;
	protected $attachments = array();
	public $protocol = 'mail';
	public $smtp_hostname;
	public $smtp_username;
	public $smtp_password;
	public $smtp_port = 25;
	public $smtp_timeout = 5;
	public $verp = false;
	public $parameter = '';

	public function __construct($config = array()) {
		foreach ($config as $key => $value) {
			$this->$key = $value;
		}
	}

	public function setTo($to) {
		$this->to = $to;
	}

	public function setFrom($from) {
		$this->from = $from;
	}

	public function setSender($sender) {
		$this->sender = $sender;
	}

	public function setReplyTo($reply_to) {
		$this->reply_to = $reply_to;
	}

	public function setSubject($subject) {
		$this->subject = $subject;
	}

	public function setText($text) {
		$this->text = $text;
	}

	public function setHtml($html) {
		$this->html = $html;
	}

	public function addAttachment($filename) {
		$this->attachments[] = $filename;
	}

	private function get_data($handle)  {
		$data="";
		while($str = fgets($handle,515)) 
		{
		$data .= $str;
		if(substr($str,3,1) == " ") { break; }
		}
		return $data;
	}

	public function send() {
		if (!$this->to) {
			throw new \Exception('Error: E-Mail to required!');
		}

		if (!$this->from) {
			throw new \Exception('Error: E-Mail from required!');
		}

		if (!$this->sender) {
			throw new \Exception('Error: E-Mail sender required!');
		}

		if (!$this->subject) {
			throw new \Exception('Error: E-Mail subject required!');
		}

		if ((!$this->text) && (!$this->html)) {
			throw new \Exception('Error: E-Mail message required!');
		}

		if (is_array($this->to)) {
			$to = implode(',', $this->to);
		} else {
			$to = $this->to;
		}

		$boundary = '----=_NextPart_' . md5(time());

		$header = 'MIME-Version: 1.0' . PHP_EOL;

		if ($this->protocol != 'mail') {
			$header .= 'To: <' . $to . '>' . PHP_EOL;
			$header .= 'Subject: =?UTF-8?B?' . base64_encode($this->subject) . '?=' . PHP_EOL;
		}

		$header .= 'Date: ' . date('D, d M Y H:i:s O') . PHP_EOL;
		$header .= 'From: =?UTF-8?B?' . base64_encode($this->sender) . '?= <' . $this->from . '>' . PHP_EOL;
		
		if (!$this->reply_to) {
			$header .= 'Reply-To: =?UTF-8?B?' . base64_encode($this->sender) . '?= <' . $this->from . '>' . PHP_EOL;
		} else {
			$header .= 'Reply-To: =?UTF-8?B?' . base64_encode($this->reply_to) . '?= <' . $this->reply_to . '>' . PHP_EOL;
		}
		
		$header .= 'Return-Path: ' . $this->from . PHP_EOL;
		$header .= 'X-Mailer: PHP/' . phpversion() . PHP_EOL;
		$header .= 'Content-Type: multipart/mixed; boundary="' . $boundary . '"' . PHP_EOL . PHP_EOL;

		if (!$this->html) {
			$message  = '--' . $boundary . PHP_EOL;
			$message .= 'Content-Type: text/plain; charset="utf-8"' . PHP_EOL;
			$message .= 'Content-Transfer-Encoding: 8bit' . PHP_EOL . PHP_EOL;
			$message .= $this->text . PHP_EOL;
		} else {
			$message  = '--' . $boundary . PHP_EOL;
			$message .= 'Content-Type: multipart/alternative; boundary="' . $boundary . '_alt"' . PHP_EOL . PHP_EOL;
			$message .= '--' . $boundary . '_alt' . PHP_EOL;
			$message .= 'Content-Type: text/plain; charset="utf-8"' . PHP_EOL;
			$message .= 'Content-Transfer-Encoding: 8bit' . PHP_EOL . PHP_EOL;

			if ($this->text) {
				$message .= $this->text . PHP_EOL;
			} else {
				$message .= 'This is a HTML email and your email client software does not support HTML email!' . PHP_EOL;
			}

			$message .= '--' . $boundary . '_alt' . PHP_EOL;
			$message .= 'Content-Type: text/html; charset="utf-8"' . PHP_EOL;
			$message .= 'Content-Transfer-Encoding: 8bit' . PHP_EOL . PHP_EOL;
			$message .= $this->html . PHP_EOL;
			$message .= '--' . $boundary . '_alt--' . PHP_EOL;
		}

		foreach ($this->attachments as $attachment) {
			if (file_exists($attachment)) {
				$handle = fopen($attachment, 'r');

				$content = fread($handle, filesize($attachment));

				fclose($handle);

				$message .= '--' . $boundary . PHP_EOL;
				$message .= 'Content-Type: application/octet-stream; name="' . basename($attachment) . '"' . PHP_EOL;
				$message .= 'Content-Transfer-Encoding: base64' . PHP_EOL;
				$message .= 'Content-Disposition: attachment; filename="' . basename($attachment) . '"' . PHP_EOL;
				$message .= 'Content-ID: <' . urlencode(basename($attachment)) . '>' . PHP_EOL;
				$message .= 'X-Attachment-Id: ' . urlencode(basename($attachment)) . PHP_EOL . PHP_EOL;
				$message .= chunk_split(base64_encode($content));
			}
		}

		$message .= '--' . $boundary . '--' . PHP_EOL;

		if ($this->protocol == 'mail') {
			ini_set('sendmail_from', $this->from);

			if ($this->parameter) {
				mail($to, '=?UTF-8?B?' . base64_encode($this->subject) . '?=', $message, $header, $this->parameter);
			} else {
				mail($to, '=?UTF-8?B?' . base64_encode($this->subject) . '?=', $message, $header);
			}
		} elseif ($this->protocol == 'smtp') {

			if (substr($this->smtp_hostname, 0, 3) == 'tls') {
				$hostname = substr($this->smtp_hostname, 6);
			} else {
				$hostname = $this->smtp_hostname;
			}

			$handle = fsockopen($hostname, $this->smtp_port, $errno, $errstr, $this->smtp_timeout);

			if (!$handle) {
				throw new \Exception('Error: ' . $errstr . ' (' . $errno . ')');
			} else { 

				if (substr(PHP_OS, 0, 3) != 'WIN') {
					socket_set_timeout($handle, $this->smtp_timeout, 0);
				}

				$data = $this->get_data($handle);
				fputs($handle,"EHLO ".getenv('SERVER_NAME')."\r\n"); // ???????????????? ??????????????????????.
				$code = substr($this->get_data($handle),0,3); // ??????????????????, ???? ?????????????????? ???? ???????????? ????????????.
				if($code != 250) {throw new \Exception("???????????? ???????????????????? EHLO"); fclose($handle); exit;}

				if (!empty($this->smtp_username)  && !empty($this->smtp_password)) {
					fputs($handle,"AUTH LOGIN\r\n"); // ???????????????? ?????????????????? ??????????????????????.
					$code = substr($this->get_data($handle),0,3);
					if($code != 334) {throw new \Exception("???????????? ???? ???????????????? ???????????? ??????????????????????"); fclose($handle); exit;}

					fputs($handle,base64_encode($this->smtp_username)."\r\n"); // ???????????????????? ?????????????? ?????????? ???? ?????????????????? ?????????? (???? ???????????????? "??????????????" ???? ?????????????????? ?? ???????????? ?????????????????? ??????????).
					$code = substr($this->get_data($handle),0,3);
					if($code != 334) {throw new \Exception("???????????? ?????????????? ?? ???????????? ??????????"); fclose($handle); exit;}

					fputs($handle,base64_encode($this->smtp_password)."\r\n");       // ???????????????????? ?????????????? ????????????.
					$code = substr($this->get_data($handle),0,3);                 
					if($code != 235) {throw new \Exception("???????????????????????? ????????????"); fclose($handle); exit;}
				}
				
				if ($this->verp) {
					fputs($handle,"MAIL FROM:<".$this->smtp_username.">XVERP". PHP_EOL); // ???????????????????? ?????????????? ???????????????? MAIL FROM.
					$code = substr($this->get_data($handle),0,3);
					if($code != 250) {throw new \Exception("???????????? ?????????????? ?? ?????????????? MAIL FROM"); fclose($handle); exit;}
				} else {
					fputs($handle,"MAIL FROM:<".$this->smtp_username.">"."\r\n"); // ???????????????????? ?????????????? ???????????????? MAIL FROM.
					$code = substr($this->get_data($handle),0,3);
					if($code != 250) {throw new \Exception("???????????? ?????????????? ?? ?????????????? MAIL FROM"); fclose($handle); exit;}
				}
				
				if (!is_array($this->to)) {
					fputs($handle,"RCPT TO:".$this->to."\r\n"); // ???????????????????? ?????????????? ?????????? ????????????????????.
					$code = substr($this->get_data($handle),0,3);
					if($code != 250 AND $code != 251) {throw new \Exception("???????????? ???? ???????????? ?????????????? RCPT TO"); fclose($handle); exit;}
				} else {
					foreach ($this->to as $recipient) {
						fputs($handle,"RCPT TO:".$recipient."\r\n"); // ???????????????????? ?????????????? ?????????? ????????????????????.
						$code = substr($this->get_data($handle),0,3);
						if($code != 250 AND $code != 251) {throw new \Exception("???????????? ???? ???????????? ?????????????? RCPT TO"); fclose($handle); exit;}
					}
				}

				fputs($handle,"DATA\r\n"); // ???????????????????? ?????????????? DATA.
				$code = substr($this->get_data($handle),0,3);
				if($code != 354) {throw new \Exception("???????????? ???? ???????????? DATA"); fclose($handle); exit;}

				// According to rfc 821 we should not send more than 1000 including the CRLF
				$message = str_replace("\r\n", "\n", $header . $message);
				$message = str_replace("\r", "\n", $message);

				$lines = explode("\n", $message);

				foreach ($lines as $line) {
					$results = str_split($line, 998);

					foreach ($results as $result) {
						if (substr(PHP_OS, 0, 3) != 'WIN') {
							fputs($handle, $result . "\r\n");
						} else {
							fputs($handle, str_replace("\n", "\r\n", $result) . "\r\n");
						}
					}
				}

				fputs($handle, '.' . "\r\n");

				//fputs($handle,$header."\r\n".$message."\r\n.\r\n"); // ???????????????????? ???????? ????????????.
				$code = substr($this->get_data($handle),0,3);
				if($code != 250) {throw new \Exception("???????????? ???????????????? ????????????"); fclose($handle); exit;}

				fputs($handle,"QUIT\r\n");   // ?????????????????? ???????????????? ???????????????? QUIT.
				fclose($handle); // ?????????????????? ????????????????????.
			}
		}
	}
}
