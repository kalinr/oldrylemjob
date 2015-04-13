<?
if($_POST['BUTTON'] == "Save")
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
	else if($country != "United States" && accountIsRetail($account['ID']))	
		$error = "We currently only ship to the United States.";
	else
	{
		if($qa[0] == "" or $qa[0] == 0)
			accounts_shippingCreate($account['ID'], $name, $address1, $address2, $city, $state, $zip, $country, $instructions);
		else
			accounts_shippingUpdate($qa[0], $account['ID'], $name, $address1, $address2, $city, $state, $zip, $country, $instructions);
		httpRedirect("/".$content['MOD_NAME']);
	}
}
else if($qa[1] == "delete")
{
	deleteAccountShipping($qa[0],$account['ID']);
	httpRedirect("/".$content['MOD_NAME']);
}
else if($qa[0] > 0)
{
	$query = "SELECT * FROM accounts_shipping WHERE ID='".$qa[0]."' AND ACCOUNTID='".$account['ID']."' LIMIT 1";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	if($row['ID'] == "")
	{
		//echo $query;
		//$_SESSION['SH]
		httpRedirect("/".$content['MOD_NAME']);
	}
	$name = $row['NAME'];
	$address1 = $row['ADDRESS1'];
	$address2 = $row['ADDRESS2'];
	$city = $row['CITY'];
	$state = $row['STATE'];
	$zip = $row['ZIP'];
	$country = $row['COUNTRY'];
	$instructions = $row['INSTRUCTIONS'];
}
?>