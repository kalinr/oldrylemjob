<?
validateCheckout($content['MOD_NAME'], $account['ID']);
//GET SHIPPING_STATE
$query = "SELECT * FROM accounts_shipping WHERE ID='".$_SESSION['SHIPPINGID']."'";
$result = mysql_query($query) or die ("error1" . mysql_error());
$row = mysql_fetch_array($result);
$shipping_state = $row['STATE'];
$shipping_zip = $row['ZIP'];

//CALCULATE WEIGHT IN CART
$lbs = calculateCartWeight($_SESSION['CART']);
if($_POST['BUTTON'] == "Continue")
{
	$shipping_method = $_POST['SHIPPING_METHOD'];
	$ship_partial = $_POST['SHIP_PARTIAL'];	
	
	// person ordering by Eric  8/30/12
	$personordering = $_POST['personordering'];		
	
	if($shipping_method == "")
		$error = "Please specify a shipping method.";
	else
	{
		$query = "SELECT * FROM shipping_methods WHERE NAME='".$shipping_method."'";
		$result = mysql_query($query) or die ("error1" . mysql_error());
		$row = mysql_fetch_array($result);

		$_SESSION['SHIPPING_METHOD'] = $shipping_method;
		$_SESSION['SHIPPING_COST'] = UPSshippingCalculation($lbs,$shipping_state,$shipping_zip, $row['ZONE_COLUMN']);
		$_SESSION['SHIP_PARTIAL'] = $ship_partial;
		
		// Eric - 8/30/12
		$_SESSION['PERSONORDERING'] = $personordering;		
		
		
		httpRedirect("/checkout/payment");
	}
}
else
{
	$ship_partial = "OK to ship partial order";
}
?>