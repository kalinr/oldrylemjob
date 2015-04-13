<?php
/*
 			$gateway = new ArgoFire($apilogin, $transactionkey);
			if (!$gateway->process_cc($amount, $ccnum, creditCardExpiration($ccyear,$ccmonth), $cvv2, $shipping_address, $cczip, $invoicenum, $first . " " . $last))
			{
				$paymentSuccess = false;
				$paymentMessage = $gateway->getError();
			}
			else
			{
				$paymentSuccess = true;
				$paymentMessage = $gateway->transactionMsg();
				$paymentTransaction = $gateway->transactionId();
			}
 */
class ArgoFire
{
	/* RedFin authentication variables */
	private $username;
	private $password;
	private $vendorKey;
	
	private $test;
	private $response;
	private $status;
	private $processed;
	
	private $mode = "post";
	
	
	function __construct($username, $password, $vendorKey = "") //, $test = false)
	{
		/*if ($test)
		{
			$this->username = "gobl1196";
			$this->password = "1196Gobl";
		}
		else*/
		//{
			$this->username = $username;
			$this->password = $password;
			$this->vendorKey = $vendorKey;
		//}
		
		$this->test = false; // $test;
		
		$this->response = "";
		$this->status = "";
		$this->processed = false;
	}
	
	public function transactionId()
	{
		if ($this->processed)
			return (string)$this->response->PNRef;
	}
	
	public function transactionMsg()
	{
		if ($this->processed)
			return (string)$this->response->Message;
	}
	
	public function getError()
	{
		return $this->status;
	}
	
	public function getResponseField($field)
	{
		return $this->response->$field;
	}
	
	public function process_cc($amount, $card_num, $exp_date, $cvv2, $street, $zip, $invoicenum = "", $nameOnCard = "")
	{
		return $this->process("Sale",$amount, $card_num, $exp_date, $cvv2, $street, $zip, $invoicenum, $nameOnCard);
	}
	
	public function auth_only($amount, $card_num, $exp_date, $cvv2, $street, $zip, $invoicenum = "", $nameOnCard = "")
	{
		return $this->process("Auth",$amount, $card_num, $exp_date, $cvv2, $street, $zip, $invoicenum, $nameOnCard);
	}
	
	private function process($transactionType, $amount, $card_num, $exp_date, $cvv2, $street, $zip, $invoicenum, $nameOnCard)
	{
		//$street = substr($street, 0, 20);
		$card_num = ereg_replace("[^0-9]", "", $card_num);
		$exp_date = ereg_replace("[^0-9]", "", $exp_date);
		$cvv2 = ereg_replace("[^0-9]", "", $cvv2);
		
		
   		$vars['TransType'] = $transactionType;
		$vars['CardNum'] = $card_num;
		$vars['ExpDate'] = $exp_date;
		$vars['NameOnCard'] = $nameOnCard;
		$vars['Amount'] = $amount;
		$vars['InvNum'] = $invoicenum;
		$vars['Zip'] = $zip;
		$vars['Street'] = $street;
		$vars['CVNum'] = $cvv2;
		
		$vars['MagData'] = "";
		$vars['PNRef'] = "";
		$vars['ExtData'] = "";
		
		
		return $this->send_receive($vars);
	}
	
	public function post_auth($pnref, $amount)
	{
		$vars['TransType'] = "Force"; //$vars['TransType'] = "Auth";
		$vars['Amount'] = $amount;
		$vars['PNRef'] = $pnref;
		
		$vars['CardNum'] = "";
		$vars['ExpDate'] = "";
		$vars['NameOnCard'] = "";
		$vars['CVNum'] = "";
		$vars['Street'] = "";
		$vars['Zip'] = "";
		$vars['InvNum'] = "";
		$vars['MagData'] = "";
		$vars['ExtData'] = "";
				
		return $this->send_receive($vars);
	}
	
	/*public function credit($amount, $card_num, $exp_date, $nameOnCard) //what about PNRef??
	{
		$card_num = ereg_replace("[^0-9]", "", $card_num);
		$exp_date = ereg_replace("[^0-9]", "", $exp_date);
		//$cvv2 = ereg_replace("[^0-9]", "", $cvv2);
		
   		$vars['TransType'] = "Return";
		$vars['CardNum'] = $card_num;
		$vars['ExpDate'] = $exp_date;
		$vars['NameOnCard'] = $nameOnCard;
		$vars['Amount'] = $amount;
		
		$vars['CVNum'] = "";
		$vars['Street'] = "";
		$vars['Zip'] = "";
		$vars['InvNum'] = "";
		$vars['MagData'] = "";
		$vars['PNRef'] = "";
		$vars['ExtData'] = "";
		
		
		return $this->send_receive($vars);
	}*/
	
	public function credit($pnref, $amount)
	{
		$vars['TransType'] = "Return";
		$vars['Amount'] = $amount;
		$vars['PNRef'] = $pnref;
		
		$vars['CardNum'] = "";
		$vars['ExpDate'] = "";
		$vars['NameOnCard'] = "";
		$vars['CVNum'] = "";
		$vars['Street'] = "";
		$vars['Zip'] = "";
		$vars['InvNum'] = "";
		$vars['MagData'] = "";
		$vars['ExtData'] = "";
				
		return $this->send_receive($vars);
	}
	
	public function void($pnref)
	{
		$vars['TransType'] = "Void";
		$vars['PNRef'] = $pnref;
		
		$vars['CardNum'] = "";
		$vars['ExpDate'] = "";
		$vars['NameOnCard'] = "";
		$vars['Amount'] = "";
		
		$vars['CVNum'] = "";
		$vars['Street'] = "";
		$vars['Zip'] = "";
		$vars['InvNum'] = "";
		$vars['MagData'] = "";
		$vars['ExtData'] = "";
		
		return $this->send_receive($vars);
	}
	
	
	public function addCustomer($customerId, $customerName, $first="", $last="", $email="")
	{
		return $this->manageCustomer("ADD", $customerId, $customerName, $first, $last, $email);
	}
	
	private function manageCustomer($transType, $customerId, $customerName, $first, $last, $email)
	{
		$vars['TransType'] = $transType;
		$vars['Vendor'] = $this->vendorKey;
		$vars['CustomerKey'] = "";
		$vars['CustomerID'] = $customerId;
		$vars['CustomerName'] = $customerName;
		$vars['FirstName'] = $first;
		$vars['LastName'] = $last;
		$vars['Title'] = "";
		$vars['Department'] = "";
		$vars['Street1'] = "";
		$vars['Street2'] = "";
		$vars['Street3'] = "";
		$vars['City'] = "";
		$vars['StateID'] = "";
		$vars['Province'] = "";
		$vars['Zip'] = "";
		$vars['CountryID'] = "";
		$vars['DayPhone'] = "";
		$vars['NightPhone'] = "";
		$vars['Fax'] = "";
		$vars['Email'] = $email;
		$vars['Mobile'] = "";
		$vars['Status'] = "";
		
		$vars['ExtData'] = "";
		
		return $this->send_receive($vars, "ManageCustomer", "stored");
	}
	
	public function addCreditCard($customerKey, $ccNum, $ccExp, $ccName, $ccStreet, $ccZip)
	{
		return $this->manageCreditCard("ADD", $customerKey, $ccNum, $ccExp, $ccName, $ccStreet, $ccZip);
	}
	
	private function manageCreditCard($transType, $customerKey, $ccNum, $ccExp, $ccName, $ccStreet, $ccZip)
	{
		$vars['TransType'] = $transType;
		$vars['Vendor'] = $this->vendorKey;
		$vars['CustomerKey'] = $customerKey;
		$vars['CardInfoKey'] = "";
		$vars['CcAccountNum'] = $ccNum;
		$vars['CcExpDate'] = $ccExp;
		$vars['CcNameonCard'] = $ccName;
		$vars['CcStreet'] = $ccStreet;
		$vars['CcZip'] = $ccZip;
		
		$vars['ExtData'] = "";
		
		return $this->send_receive($vars, "ManageCreditCardInfo", "stored");
	}
	
	public function processStoredCC($ccInfoKey, $amount, $invoiceNumber)
	{
		$vars['Vendor'] = $this->vendorKey;
		$vars['CcInfoKey'] = $ccInfoKey;
		$vars['Amount'] = $amount;
		$vars['InvNum'] = $invoiceNumber;
		
		$vars['ExtData'] = "";
		
		return $this->send_receive($vars, "ProcessCreditCard", "stored");
	}
	
	
	private function send_receive($vars, $operation = "ProcessCreditCard", $type = "credit")
	{
		if ($type == "credit")
		{
			//$operation = "ProcessCreditCard";
			//$url = "https://secure.ftipgw.com/ArgoFire/transact.asmx?op=$operation";
			$url = "https://secure.ftipgw.com/ArgoFire/transact.asmx/$operation?";
		}
		else if ($type == "stored")
		{
			//$operation = "ManageCreditCardInfo";
			$url = "https://secure.ftipgw.com/admin/ws/recurring.asmx/$operation?";
		}
		
		
		//Account Info
		$commonVars['UserName'] = $this->username;
		$commonVars['Password'] = $this->password;
		
		$vars = $commonVars + $vars;
		$request = "";
		
		if ($this->mode == "post" || $this->mode == "get")
		{
			foreach ($vars as $key => $value)
			{
				$request =  $request . "&$key=". urlencode($value);
			}
			$request = ltrim($request, "&");
		}
		else if ($this->mode == "xml")
		{
			foreach ($vars as $key => $value)
			{
				$request = $request . "<$key>$value</$key>";
			}
		}
		
		if ($this->mode == "get")
			$url .= "&$request";
		
		//if ($type == "check")
		//	echo $request;
		//echo $url . "<br />\n\n";
		
		//Construct CURL Request
		$session  = curl_init();                       // create a curl session
		curl_setopt($session, CURLOPT_URL, $url);
		if ($this->mode == "post" || $this->mode == "xml")
		{
			curl_setopt($session, CURLOPT_POST, true);              // POST request type
			curl_setopt($session, CURLOPT_POSTFIELDS, $request); // set the body of the POST
		}
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string - not to std out
		curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);
		/*$headers = array(
		  'Content-Type: text/xml;charset=utf-8',
		);
		curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    //set headers using the above array of headers
		*/
		$response = curl_exec($session);                     // send the request
		curl_close($session);
		
		//echo $response;
		
		try {
			@ $xml = new SimpleXMLElement($response);
			$this->response = $xml;
		}
		catch (Exception $e)
		{
			$this->status = "Unable to parse the xml response. $response";
			return false;
		}
		
		if ($type == "credit")
		{
			if (!isset($this->response->Result) || (int)$this->response->Result != 0)
			{
				$this->status = "Error " . $this->response->Result . " occured while trying to process your card: " . $this->response->RespMSG; // . " | $response"; // . ", " . $this->response->Message;
				return false;
			}
		}
		else if ($type == "stored")
		{
			if ((!isset($this->response->code) || (string)$this->response->code != "OK") || (isset($this->response->error) && (string)$this->response->error != "APPROVED"))
			{
				$this->status = "Error " . $this->response->error . " occured while trying to {$vars['TransType']} stored card information." . " | $response";
				return false;
			}
		}
		
		$this->processed = true;
		
		return true;
	}
}

?>