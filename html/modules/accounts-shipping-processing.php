<?
if($content['ID'] == 11 && $_SESSION['CUSTOMERID'] == "")
	httpRedirect("/customer-entry");
else if($content['ID'] == 11)
	$query_array[0] = $_SESSION['CUSTOMERID'];
if($query_array[0] == "" && $content['ID'] == 11)
	httpRedirect("/customer-entry/profile");
if($query_array[0] == "")
	httpRedirect("/admin/customers");
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
		$error = "Please enter a name for this shipping address.";
	else if($address1 == "")
		$error = "Please enter an address.";
	else if($city == "")
		$error = "Please enter a city.";
	else if($state == "")
		$error = "Please select a state.";
	else if($zip == "")
		$error = "Please enter a zip code.";
	else if((addressIsPOBOX($address1) or addressIsPOBOX($address2)))
		$error = "Shipping to a PO BOX is not allowed. Please provide an alternate shipping address.";
	else if($country != "United States" && accountIsRetail($query_array[0]))
		$error = "We currently only ship to the United States.";
	else
	{
		if($query_array[1] == "")
			accounts_shippingCreate($query_array[0], $name, $address1, $address2, $city, $state, $zip, $country, $instructions);
		else
			accounts_shippingUpdate($query_array[1], $query_array[0], $name, $address1, $address2, $city, $state, $zip, $country, $instructions);
		if($content['ID'] == 11)
			httpRedirect("/customer-entry/profile/".$query_array[0]);
		else
			httpRedirect("/admin/customers/profile/".$query_array[0]);
	}
}
else if($query_array[2] == "delete")
{
	deleteAccountShipping($query_array[1],$query_array[0]);
	httpRedirect("/".str_replace("/shipping","",$content['MOD_NAME'])."/".$query_array[0]);
}
else if($query_array[1] != '')
{
	$query = "SELECT * FROM accounts_shipping WHERE ID='".$query_array[1]."' AND ACCOUNTID='".$query_array[0]."'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	if($row['ID'] == "")
		httpRedirect("/admin/customers/profile/".$query_array[0]);
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