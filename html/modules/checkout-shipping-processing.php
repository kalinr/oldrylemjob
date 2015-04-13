<?
validateCheckout($content['MOD_NAME'], $account['ID']);
if($qa[0] == $_SESSION['USERID'] && $qa[1] == 0)
{
	if($_POST['BUTTON'] == "Continue")
	{
		$name = $_POST['NAME'];
		$address1 = $_POST['ADDRESS1'];
		$address2 = $_POST['ADDRESS2'];
		$city = $_POST['CITY'];
		$state = $_POST['STATE'];
		$zip = $_POST['ZIP'];
		$country = $_POST['COUNTRY'];
		$instructions = $_POST['INSTRUCTIONS'];
	
		if($name == "")
			$error = "Please type in a name for this shipping address.";
		else if($address1 == "")
			$error = "Please type in an address.";
		else if($city == "")
			$error = "Please type in a city.";
		else if($state == "")
			$error = "Please select a state.";
		else if($zip == "")
			$error = "Please type in a zip code.";
		else if((addressIsPOBOX($address1) or addressIsPOBOX($address2)))
			$error = "Shipping to a PO BOX is not allowed. Please provide an alternate shipping address.";
		else
		{
			$_SESSION['SHIPPINGID'] = accounts_shippingCreate($_SESSION['USERID'], $name, $address1, $address2, $city, $state, $zip, $country, $instructions);
			httpRedirect("/checkout/shipping-method");
		}
	}
}
else if($qa[0] == $_SESSION['USERID'] && $qa[1] != "")
{
	if(validShippingAddress($account['ID'], $qa[1]))
	{
		$_SESSION['SHIPPINGID'] = $qa[1];
		httpRedirect("/checkout/shipping-method");
	}
	else
		$error = "Invalid shipping address.";
}
?>