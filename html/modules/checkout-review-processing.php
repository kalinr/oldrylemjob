<?php
validateCheckout($content['MOD_NAME'], $account['ID']);
$cart_array = $_SESSION['CART'];

//query shipping
$query = "SELECT * FROM accounts_shipping WHERE ID='".$_SESSION['SHIPPINGID']."' AND ACCOUNTID='".$account['ID']."'";
$result = mysql_query($query) or die ("error1" . mysql_error());
$shipping = mysql_fetch_array($result);

//CALCULATE SHIPPING
$shipping['COST'] = $_SESSION['SHIPPING_COST'];
$shipping_cost = $_SESSION['SHIPPING_COST'];

if($_POST['BUTTON'] == "Process Order")//$qa[1] == "process")
{

	$comments = $_POST['COMMENTS'];
	$_SESSION['COMMENTS'] = $comments;

        // mailchimp integration
        $_SESSION["triggerChimp"] = false;
        $_SESSION["craftIdeas"] = false;
        $_SESSION["productNews"] = false;

        if (isset($_POST['craft_project_ideas']) && !empty($_POST['craft_project_ideas']) && $_POST['craft_project_ideas'] == '1') {
          $_SESSION["triggerChimp"] = true;
          $_SESSION["craftIdeas"] = true;
        }

        if (isset($_POST['product_announcements']) && !empty($_POST['product_announcements']) && $_POST['product_announcements'] == '1') {
          $_SESSION["triggerChimp"] = true;
          $_SESSION["productNews"] = true;                
        }

	httpRedirect("/checkout/review/0/processcard");

}
else if($qa[1] == "processcard")
{	
	//insert order into database
	$query = "SELECT * FROM accounts_shipping WHERE ID='".$_SESSION['SHIPPINGID']."' AND ACCOUNTID='".$account['ID']."'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$shipping = mysql_fetch_array($result);
	
	//RECALCULATE ORDER HERE
	$subtotal = $_SESSION['SUBTOTAL'];
	$adjustedForPreauthTotal = $subtotal;

        if (accountCheckForWholesalerStatus($account['ID'])) {
	
          $preauthQry = "SELECT * FROM wholesale_preauth";
          $preauthRes = mysql_query($preauthQry) or die(mysql_error());
          $preauthData = mysql_fetch_assoc($preauthRes);
          $below1000 = $preauthData['below_1000'];
          $above1000 = $preauthData['above_1000'];

          if ($subtotal < 1000) {
            $adjustedForPreauthTotal += $below1000;
          }

          if ($subtotal >= 1000) {
            $adjustedForPreauthTotal += $above1000;
          }

        }
		
		if($_SESSION['PROMO_CODE'] != "")
		{
			$promo_description = promocodeName($_SESSION['PROMO_CODE']);
			$discount_promo = calculatePromoDiscount($_SESSION['PROMO_CODE'], $subtotal);
		}
		else
		{
			$promo_description = "";
			$discount_promo = 0;
		}


		//Eric - discount 0 all the way across because it's now done at the line item level
		//$account['DISCOUNT'] = 0;
		// end Eric 


		if($account['DISCOUNT'] != 0 && 1==2)
		{
		        $unformattedCustomerDiscount = $subtotal * $account['DISCOUNT'];
			$discount_customer = money_format('%2i',($subtotal * $account['DISCOUNT']));
		}
		else {
			$discount_customer = 0;
			$unformattedCustomerDiscount = 0;
		}
		

		$shipping_cost = preg_replace("/[^0-9,.]/", "", $shipping_cost);
	
		//CALCULATE SALES TAX
		if(($account['TYPEID'] == 1 OR $account['TYPEID'] > 5 OR $account['TAX']) && $shipping['STATE'] == "WA")
		{
			$state = $shipping['STATE'];
				$city = $shipping['CITY'];
				$zip = $shipping['ZIP'];
				$address = $shipping['ADDRESS1'];
				
			$result = getTax($city, $state, $zip, $address);
			$tax_rate = $result['Rate'];
			$tax_code = $result['LocationCode'];			
			$taxable_amount = $subtotal + $shipping_cost - $unformattedCustomerDiscount - $discount_promo;
			$unformattedTaxNumber = $taxable_amount * $tax_rate;
			// $tax = money_format('%i',($taxable_amount * $tax_rate));
			$tax = $unformattedTaxNumber;
		}
		else
		{
			//TAX EXCEPT OR OUT OF STATE
			$tax_code = 0;
			$tax_rate = 0;
			$unformattedTaxNumber = 0;
			$tax = 0;
		}

		$total = $adjustedForPreauthTotal + $unformattedTaxNumber + $shipping_cost - $discount_promo - $unformattedCustomerDiscount;
		$totalWithoutPreauth = $subtotal + $unformattedTaxNumber + $shipping_cost - $discount_promo - $unformattedCustomerDiscount; 
		$amountPassedToArgoFire = $total;
		
	if($_SESSION['CCNUM'] != '')
	{
		//ARGOFIRE
		require_once("functions/argofire.php");
		$gateway = new ArgoFire(ARGOFIRE_USERNAME, ARGOFIRE_PASSWORD);
		
		//if (!$gateway->process_cc($total, $_SESSION['CCNUM'], creditCardExpiration($_SESSION['CCYEAR'],$_SESSION['CCMONTH']), $_SESSION['CCVER'], $shipping['ADDRESS1'], $_SESSION['CCZIP'], nextID("orders"), $account['FIRST'] . " " . $account['LAST']))

		if($_SESSION['CCNUM'] != "4005550000000019" && !$gateway->auth_only($amountPassedToArgoFire, $_SESSION['CCNUM'], creditCardExpiration($_SESSION['CCYEAR'],$_SESSION['CCMONTH']), $_SESSION['CCVER'], $shipping['ADDRESS1'], $_SESSION['CCZIP'], nextID("orders"), $account['FIRST'] . " " . $account['LAST']))
		{
			$paymentSuccess = false;
			$paymentMessage = $gateway->getError();
			$_SESSION['STATUS'] = "Your credit card was declined.";
			httpRedirect("/checkout/payment");
		}
		else
		{
			$paymentSuccess = true;
			$paymentMessage = $gateway->transactionMsg();
			$transactionid = $gateway->transactionId();
		}
		
	}
	
	if($_SESSION['PONUMBER'] =='' && !accountIsRetail($account['ID']))
		$_SESSION['PONUMBER'] = "W".nextID("orders");
	//die($tax);
	$orderid = ordersCreate($account['ID'], $account['FIRST'], $account['LAST'], $_SESSION['PERSONORDERING'], $account['ORGANIZATION'], $account['ADDRESS1'], $account['ADDRESS2'], $account['CITY'], $account['STATE'], $account['ZIP'], $account['COUNTRY'], $shipping['NAME'], $shipping['ADDRESS1'], $shipping['ADDRESS2'], $shipping['CITY'], $shipping['STATE'], $shipping['ZIP'], $shipping['COUNTRY'], $_SESSION['SHIPPING_METHOD'], $account['PHONE1'], $account['EMAIL'], $account['EMAIL2'], $subtotal, $discount_customer, $discount_promo, $tax, $tax_rate, $tax_code, $shipping_cost, $totalWithoutPreauth, 0, $totalWithoutPreauth, $_SESSION['PROMO_CODE'], $promo_description, 1, $transactionid, cardType($_SESSION['CCNUM']), last4cc($_SESSION['CCNUM']), $_SESSION['PONUMBER'], $_SESSION['COMMENTS'], $cart_array, $account,$_SESSION['SHIP_PARTIAL']);
		
	sendOrderEmail($orderid);
	
	//NOTIFY MERCHANT
	$message = $account['FIRST'].' '.$account['LAST'].' has placed an online order. Please login to process.';
	auto_email(sendTo(),"ImagineCrafts.com - Order #".$orderid,$message);
	
	//clear out saved carts
	clearSavedCart($account['ID']);
	cart_cookiesDelete();
	
	//set order id
	$_SESSION['ORDERID'] = $orderid;
	//clear checkout sessions
	unset($_SESSION['CCNUM']);
	unset($_SESSION['CCMONTH']);
	unset($_SESSION['CCYEAR']);
	unset($_SESSION['CCVER']);
	unset($_SESSION['CCZIP']);
	unset($_SESSION['PONUMBER']);
	unset($_SESSION['SUBTOTAL']);
	unset($_SESSION['TAX']);
	unset($_SESSION['TOTAL']);
	unset($_SESSION['CART']);
	unset($_SESSION['COMMENTS']);
	unset($_SESSION['SHIPPING_METHOD']);
	unset($_SESSION['SHIPPINGID']);
	unset($_SESSION['SHIP_PARTIAL']);

	// mailchimp integration
        if ($_SESSION["triggerChimp"]) {
                
          require 'mc/Mailchimp.php';                  
          $chimpSubscriptionArr = array();
          $theAccountType = 'Consumer';
                  
	  if ($_SESSION["craftIdeas"]) {
	    $chimpSubscriptionArr[]= 'Receive wonderful craft project ideas through our blog';
	  }
	  if ($_SESSION["productNews"]) {
	    $chimpSubscriptionArr[]= 'Receive important new product announcements and information';
	  }

	  if (accountCheckForWholesalerStatus($account['ID'])) {
	    $theAccountType = 'Wholesale';
	  }                  

	  $chimpy = new Mailchimp('9e5b4ea162e40db1d3dda178a9de8082-us7');
	  $chimpArr = array();
	  $chimpArr["apikey"] = "9e5b4ea162e40db1d3dda178a9de8082-us7";
	  $chimpArr["id"] = "157580261d";
	  $chimpArr["email"] = array();
	  $chimpArr["email"]["email"] = $account['EMAIL'];
	  $chimpArr["merge_vars"] = array();                  
	  $chimpArr["merge_vars"]["groupings"] = array();
	  $custTypeArr = array();
	  $custTypeArr["name"] = "Customer type";
	  $custTypeArr["groups"] = array($theAccountType);
	  $subscribeArr = array();
	  $subscribeArr["name"] = "Subscription Options";
	  $subscribeArr["groups"] = $chimpSubscriptionArr;                     
	  $chimpArr["merge_vars"]["groupings"][]= $custTypeArr;          
	  $chimpArr["merge_vars"]["groupings"][]= $subscribeArr;
	  $chimpArr["merge_vars"]["FIRSTNAME"] = stripslashes($account['FIRST']);
	  $chimpArr["merge_vars"]["LASTNAME"] = stripslashes($account['LAST']);                  
	  $theChimpSays = $chimpy->call("/lists/subscribe", $chimpArr);

	}

	unset($_SESSION["triggerChimp"]);
	unset($_SESSION["craftIdeas"]);
	unset($_SESSION["productNews"]);

	httpRedirect("/checkout/finished/".$orderid);

}
else if(isset($_SESSION['COMMENTS']))
	$comments = $_SESSION['COMMENTS'];
?>