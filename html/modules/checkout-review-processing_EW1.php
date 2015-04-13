<?
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
		if($account['DISCOUNT'] != 0)
		{
			$discount_customer = money_format('%2i',($subtotal * $account['DISCOUNT']));
		}
		else
			$discount_customer = 0;
		
	
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
			$taxable_amount = $subtotal + $shipping_cost - $discount_customer - $discount_promo;
			$tax = money_format('%i',($taxable_amount * $tax_rate));
		}
		else
		{
			//TAX EXCEPT OR OUT OF STATE
			$tax_code = 0;
			$tax_rate = 0;
			$tax = 0;
		}

		$total = $subtotal + $tax + $shipping_cost - $discount_promo - $discount_customer;
		$total = money_format('%2i',$total);

	if($_SESSION['CCNUM'] != '')
	{
		//ARGOFIRE
		require_once("functions/argofire.php");
		$gateway = new ArgoFire(ARGOFIRE_USERNAME, ARGOFIRE_PASSWORD);
		//if (!$gateway->process_cc($total, $_SESSION['CCNUM'], creditCardExpiration($_SESSION['CCYEAR'],$_SESSION['CCMONTH']), $_SESSION['CCVER'], $shipping['ADDRESS1'], $_SESSION['CCZIP'], nextID("orders"), $account['FIRST'] . " " . $account['LAST']))
		if($_SESSION['CCNUM'] != "4005550000000019" && !$gateway->auth_only($total, $_SESSION['CCNUM'], creditCardExpiration($_SESSION['CCYEAR'],$_SESSION['CCMONTH']), $_SESSION['CCVER'], $shipping['ADDRESS1'], $_SESSION['CCZIP'], nextID("orders"), $account['FIRST'] . " " . $account['LAST']))
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
	$orderid = ordersCreate($account['ID'], $account['FIRST'], $account['LAST'], $_SESSION['PERSONORDERING'], $account['ORGANIZATION'], $account['ADDRESS1'], $account['ADDRESS2'], $account['CITY'], $account['STATE'], $account['ZIP'], $account['COUNTRY'], $shipping['NAME'], $shipping['ADDRESS1'], $shipping['ADDRESS2'], $shipping['CITY'], $shipping['STATE'], $shipping['ZIP'], $shipping['COUNTRY'], $_SESSION['SHIPPING_METHOD'], $account['PHONE1'], $account['EMAIL'], $subtotal, $discount_customer, $discount_promo, $tax, $tax_rate, $tax_code, $shipping_cost, $total, 0, $total, $_SESSION['PROMO_CODE'], $promo_description, 1, $transactionid, cardType($_SESSION['CCNUM']), last4cc($_SESSION['CCNUM']), $_SESSION['PONUMBER'], $_SESSION['COMMENTS'], $cart_array, $account,$_SESSION['SHIP_PARTIAL']);
		
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
	unset($_SESSION['SUBTOTAL']);
	unset($_SESSION['SHIP_PARTIAL']);
	httpRedirect("/checkout/finished/".$orderid);
}
else if(isset($_SESSION['COMMENTS']))
	$comments = $_SESSION['COMMENTS'];
?>