<?php
class ControllerExtensionPaymentPrivatbankPaymentpartsIi extends Controller {

	public function index() {        
		$this->language->load('extension/payment/privatbank_paymentparts_ii');

		$data['button_confirm'] = $this->language->get('button_confirm');
        $data['text_label_partsCount'] = $this->language->get('text_label_partsCount');
		$data['text_mounth'] = $this->language->get('text_mounth');
		$data['language'] = str_replace('ua', 'uk', substr($this->session->data['language'], 0 ,2));
		$data['text_loading'] = $this->language->get('text_loading');
		
        $partsCount = 24;
		foreach ($this->cart->getProducts() as $cart) {
			$privat_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_privat WHERE product_id = '" . (int)$cart['product_id'] . "'");
			if ($privat_query->row) {
				if ($privat_query->row['partscount_ii'] <= $partsCount && $privat_query->row['partscount_ii'] !=0) {
					$partsCount = (int)$privat_query->row['partscount_ii'];
				}
			}
		}
		if ($partsCount == 24) {
			$partsCount = $this->config->get('privatbank_paymentparts_ii_paymentquantity');
		}
		
        $data['partsCounts'] = $partsCount;
		
		if (isset ($this->session->data['privatbank_paymentparts_ii_sel'])) {
			$data['partsCountSel'] = $this->session->data['privatbank_paymentparts_ii_sel'];
		} else {
			$data['partsCountSel'] = '';
		}	

		// Totals
		$this->load->model('extension/extension');

		$totals = array();
		$taxes = $this->cart->getTaxes();
		$total = 0;

		// Because __call can not keep var references so we put them into an array.
		$total_data = array(
			'totals' => &$totals,
			'taxes'  => &$taxes,
			'total'  => &$total
		);
			
		// Display prices
		if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
			$sort_order = array();

			$results = $this->model_extension_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('extension/total/' . $result['code']);

					// We have to put the totals in an array so that they pass by reference.
					$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
				}
			}

			$sort_order = array();

			foreach ($totals as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $totals);
		}

		$replace_array = array($this->currency->getSymbolLeft($this->session->data['currency']),$this->currency->getSymbolRight($this->session->data['currency']),$this->language->get('thousand_point'));

		$data['total'] = str_replace($replace_array,"",$this->currency->format($this->tax->calculate($total, $this->config->get('tax_class_id'), $this->config->get('config_tax')), $this->session->data['currency']));
		
        $data['action'] = $this->url->link('extension/payment/privatbank_paymentparts_ii/sendDataDeal', '', 'SSL');

		return $this->load->view('extension/payment/privatbank_paymentparts_ii', $data);
	}
    
    private function generateAnswerSignature ($dataAnsweArr){
        
        $passwordStore = $this->config->get('privatbank_paymentparts_ii_shop_password');
        $storeId = $this->config->get('privatbank_paymentparts_ii_shop_id');
        
        $signatureAnswerStr = $passwordStore.
                              $storeId.
                              $dataAnsweArr['orderId'].
                              $dataAnsweArr['paymentState'].
                              $dataAnsweArr['message'].
                              $passwordStore;
                              
        $signatureAnswer = base64_encode(SHA1($signatureAnswerStr, true));
		
        return $signatureAnswer;                               
        
    }               
    
    private function generateSignature ($dataArr){
        $productsString = '';
        $signatureStr = '';
        $amountStr ='';
        $passwordStore ='';
        $signature ='';
        $decimalSeparatorArr = array(",", ".");
        foreach ($dataArr['products'] as $key_product=>$val_product) {
              if(!fmod(round($val_product['price'],2),1)){
                $valProductPrice = round($val_product['price'],2).'00';  
              }else{
                $valProductPrice = round($val_product['price'],2);
                $valProductPriceRateArr = explode('.', $valProductPrice);  
                if(strlen($valProductPriceRateArr[1])==1){
                   $valProductPrice = $valProductPrice.'0'; 
                }
              }              
              $productPrice = str_replace($decimalSeparatorArr,'',$valProductPrice);            

              $productsString .= $val_product['name'].$val_product['count'].$productPrice;              
        }
        
        if(!fmod(round($dataArr['amount'],2),1)){
            $dataArrAmount = round($dataArr['amount'],2).'00';
        }else{
             $dataArrAmount = round($dataArr['amount'],2);
             $dataArrAmountRateArr = explode('.', $dataArrAmount);  
             if(strlen($dataArrAmountRateArr[1])==1){
                $dataArrAmount = $dataArrAmount.'0'; 
             }             
        }
        $amountStr = str_replace($decimalSeparatorArr,'',$dataArrAmount);
        $passwordStore = $this->config->get('privatbank_paymentparts_ii_shop_password');
                        
        $signatureStr = $passwordStore.
                        $dataArr['storeId'].
                        $dataArr['orderId'].
                        $amountStr.
 //                       $dataArr['currency'].
                        $dataArr['partsCount'].
                        $dataArr['merchantType'].
                        $dataArr['responseUrl'].
                        $dataArr['redirectUrl'].
                        $productsString.
                        $passwordStore;                        

		$signature = base64_encode ( SHA1 ($signatureStr, true)); 						

        return $signature;       
    }
    
    private function generateOrderId($orderId,$length = 64){
      $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
      $numChars = strlen($chars);
      $string = '';
      for ($i = 0; $i < $length; $i++) {
        $string .= substr($chars, rand(1, $numChars) - 1, 1);
      }
      
      $stringRes = substr($string,0,(int)strlen($string)-(int)strlen('_'.$orderId)).'_'.$orderId;
      
      return $stringRes;
    }
    
    private function curlPostWithData($url, $request)
    {
    try{
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json','Accept-Encoding: UTF-8','Content-Type: application/json; charset=UTF-8'));
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        //execute curl
        $response = curl_exec($curl);
        
        //get execute result
        $curl_errno = curl_errno($curl);
        $curl_error = curl_error($curl);
        $aInfo = @curl_getinfo($curl);            
        //close curl
        curl_close($curl);          
        //analysis of the information received
        $this->language->load('payment/privatbank_paymentparts_ii');    
        if($curl_errno!=0){
            $this->log->write('PRIVATBANK_PAYMENTPARTS_II :: CURL failed ' . $curl_error . '(' . $curl_errno . ')');  
            return $this->language->get('error_curl');
        } 
        if($aInfo["http_code"]!='200'){
            $this->log->write('PRIVATBANK_PAYMENTPARTS_II :: HTTP failed ' . $aInfo["http_code"] . '(' . $response . ')');  
            return $this->language->get('error_curl');
        } 
              
           
        return json_decode($response,true);
       
    } catch(Exception $e){
        return false;
    }
    }
    
    private function clearCartOnSuccess($order_id){
        
        if (isset($this->session->data['order_id'])) {
            $this->cart->clear();

            // Add to activity log
            $this->load->model('account/activity');

            if ($this->customer->isLogged()) {
                $activity_data = array(
                    'customer_id' => $this->customer->getId(),
                    'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName(),
                    'order_id'    => $this->session->data['order_id']
                );

                $this->model_account_activity->addActivity('order_account', $activity_data);
            } else {
                $activity_data = array(
                    'name'     => $this->session->data['guest']['firstname'] . ' ' . $this->session->data['guest']['lastname'],
                    'order_id' => $this->session->data['order_id']
                );

                $this->model_account_activity->addActivity('order_guest', $activity_data);
            }

            unset($this->session->data['shipping_method']);
            unset($this->session->data['shipping_methods']);
            unset($this->session->data['payment_method']);
            unset($this->session->data['payment_methods']);
            unset($this->session->data['guest']);
            unset($this->session->data['comment']);
            unset($this->session->data['order_id']);
            unset($this->session->data['coupon']);
            unset($this->session->data['reward']);
            unset($this->session->data['voucher']);
            unset($this->session->data['vouchers']);
            unset($this->session->data['totals']);
        } 
    }       
    
	public function setPrivatType(){
		$json = array();
		$this->session->data['payment_method']['code'] = 'privatbank_paymentparts_ii';
		setcookie('payment_method', 'privatbank_paymentparts_ii', time() + 60 * 60 * 24 * 30);
		$this->session->data['privatbank_paymentparts_ii_sel'] = $this->request->post['partsCount'];        
        $json['success'] = TRUE;
 
		if ($this->request->get['route'] != 'checkout/checkout') {
           $json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
       }       

	   $this->response->setOutput(json_encode($json));
	}
	
    public function sendDataDeal(){
   
        //create arr to request Deal
        $this->load->model('checkout/order');

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
           
        if ($order_info) {
            $data_deal['storeId'] = $this->config->get('privatbank_paymentparts_ii_shop_id');
            $data_deal['orderId'] = $this->generateOrderId($order_info['order_id']);
//			$data_deal['amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);           
            $data_deal['partsCount'] = $this->request->post['partsCount'];
            $data_deal['merchantType'] = 'II';
            $data_deal['products'] = array();
			
			// Totals
			$this->load->model('extension/extension');

			$totals = array();
			$taxes = $this->cart->getTaxes();
			$total = 0;

			// Because __call can not keep var references so we put them into an array.
			$total_data = array(
				'totals' => &$totals,
				'taxes'  => &$taxes,
				'total'  => &$total
			);
				
			// Display prices
			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$sort_order = array();

				$results = $this->model_extension_extension->getExtensions('total');

				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}

				array_multisort($sort_order, SORT_ASC, $results);

				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('extension/total/' . $result['code']);

						// We have to put the totals in an array so that they pass by reference.
						$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
					}
				}

				$sort_order = array();

				foreach ($totals as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $totals);
			}

			$sumtotal =0;
			$discount = 0;

			foreach ($totals as $total) {
				if (($total['code'] != 'sub_total') && ($total['code'] != 'total')) {
					if ($total['value'] > 0) {
						$data_deal['products'][] = array(
							'name' => $total['title'],
							'count' => 1,
							'price'    => $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'], false)
						);
						$sumtotal += $this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'], false);
					} else {
						$discount += abs($this->currency->format($total['value'], $order_info['currency_code'], $order_info['currency_value'], false));
					}
				}
			}

			$productquantity = $this->cart->countProducts();
			$minus = $discount / $productquantity;

            foreach ($this->cart->getProducts() as $product) {
				if (($this->currency->format($product['price'], $order_info['currency_code'], $order_info['currency_value'], false) - $minus) <= 0) {
					$productquantity = $productquantity - $product['quantity'];
					$data_deal['products'][] = array(
						'name'     => htmlspecialchars(trim($product['name'])),
						'count' => $product['quantity'],
						'price'    => $this->currency->format($product['price'], $order_info['currency_code'], $order_info['currency_value'], false)
					);
					$sumtotal += $this->currency->format($product['price'], $order_info['currency_code'], $order_info['currency_value'], false) * $product['quantity'];
				}
            }
			$minus = $discount / $productquantity;
            foreach ($this->cart->getProducts() as $product) {
				if (($this->currency->format($product['price'], $order_info['currency_code'], $order_info['currency_value'], false) - $minus) > 0) {
					$data_deal['products'][] = array(
						'name'     => htmlspecialchars(trim($product['name'])),
						'count' => $product['quantity'],
						'price'    => $this->currency->format($product['price'], $order_info['currency_code'], $order_info['currency_value'], false) - $minus
					);
					$sumtotal += ($this->currency->format($product['price'], $order_info['currency_code'], $order_info['currency_value'], false) - $minus) * $product['quantity'];
				}
            }	
			
			$data_deal['amount'] = $sumtotal;


            $data_deal['responseUrl'] = $this->url->link('extension/payment/privatbank_paymentparts_ii/callback', '', 'SSL');
            $data_deal['redirectUrl'] = $this->url->link('checkout/checkout');
            $data_deal['signature'] = $this->generateSignature($data_deal);
        }

        $requestDial = json_encode($data_deal);       
		if ($this->config->get('privatbank_paymentparts_ii_hold')) {
			$url = 'https://payparts2.privatbank.ua/ipp/v2/payment/hold';
		} else {
			$url = 'https://payparts2.privatbank.ua/ipp/v2/payment/create';
		}     
     
        $responseResDeal = $this->curlPostWithData($url,$requestDial);

        if(is_array($responseResDeal)){
            if(strcmp($responseResDeal['state'], 'FAIL') == 0){
                $this->log->write('PRIVATBANK_PAYMENTPARTS_II :: DATA DEAL failed: ' . json_encode($responseResDeal));                
            }            
            echo  json_encode($responseResDeal);         
        } else {
            echo json_encode(array('state'=>'sys_error','message'=>$responseResDeal));
        }

    }    

	public function callback() {
        
        $requestPostRaw = file_get_contents('php://input');        
        $requestArr = json_decode(trim($requestPostRaw),true);

		$this->load->model('checkout/order');

		$orderIdArr = explode('_',$requestArr['orderId']);
        $order_id = $orderIdArr[1];
		$privat_order_id = $requestArr['orderId'];
		$privat_order_status = $requestArr['paymentState'];
        $comment = $requestArr['message'];
        $localAnswerSignature = $this->generateAnswerSignature ($requestArr);
        $order_info = $this->model_checkout_order->getOrder($order_id);
        
        if ($order_info) {        
            if (strcmp($requestArr['signature'], $localAnswerSignature) == 0) {
                switch($requestArr['paymentState']) {
                  case 'SUCCESS':
                      $order_status_id = $this->config->get('privatbank_paymentparts_ii_completed_status_id');
                      $this->clearCartOnSuccess($order_id);
                      break;
                  case 'LOCKED':
                      $order_status_id = $this->config->get('privatbank_paymentparts_ii_created_status_id');
                      $this->clearCartOnSuccess($order_id);
                      break;
                  case 'CANCELED':
                      $order_status_id = $this->config->get('privatbank_paymentparts_ii_canceled_status_id');
                      break;
                  case 'FAIL':
                      $order_status_id = $this->config->get('privatbank_paymentparts_ii_failed_status_id');
                      $this->log->write('PRIVATBANK_PAYMENTPARTS_II :: PAYMENT FAIL!  ORDER_ID:'.$order_id .' MESSAGE:'. $requestArr['message']);
                      break;
                  case 'REJECTED':
                      $order_status_id = $this->config->get('privatbank_paymentparts_ii_rejected_status_id');
                      $this->log->write('PRIVATBANK_PAYMENTPARTS_II :: PAYMENT REJECTED!  ORDER_ID:'.$order_id .' MESSAGE:'. $requestArr['message']);
                      break;                                                            
                }
				$this->model_checkout_order->setPrivatOrderId($order_id, $privat_order_id, $privat_order_status);
                $this->model_checkout_order->addOrderHistory($order_id, $order_status_id, $comment);                
                
            } else {
                $this->log->write('PRIVATBANK_PAYMENTPARTS_II :: RECEIVED SIGNATURE MISMATCH!  ORDER_ID:'.$order_id .' RECEIVED SIGNATURE:'. $requestArr['signature']);
                $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('config_order_status_id'));
            } 
        }
		
	}
}