<?
function validateCheckout($mod_name, $accountid)
{
	$cart_array = $_SESSION['CART'];
	if(sizeof($cart_array) == 0)
	{
			httpRedirect("/cart");
	}
	if($mod_name == "checkout/shipping" OR $mod_name == "checkout/shipping-method" OR $mod_name == "checkout/payment" OR $mod_name == "checkout/review")
	{
		if($_SESSION['USERID'] == "")
			httpRedirect("/checkout");
	}
	if($mod_name == "checkout/shipping-method" OR $mod_name == "checkout/payment" OR $mod_name == "checkout/review")
	{
		if($_SESSION['SHIPPINGID'] == "" or !validShippingAddress($accountid, $_SESSION['SHIPPINGID']))
			httpRedirect("/checkout/shipping");
	}
	if($mod_name == "checkout/payment" or $mod_name == "checkout/review")
	{
		if($_SESSION['SHIPPING_METHOD'] == "")
			httpRedirect("/checkout/shipping-method");
	}
	if($mod_name == "checkout/review")
	{
		if($_SESSION['CCNUM'] == "" && $_SESSION['PONUMBER'] == "")
			httpRedirect("/checkout/payment");
	}
}
function validShippingAddress($accountid, $id)
{
	$query = "SELECT * FROM accounts_shipping WHERE ID='$id' AND ACCOUNTID='$accountid'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	if($row['ID'] != "")
		return true;
	else
		return false;
}
function calculateCartWeight($cart_array)
{
	if(!is_array($cart_array))
		return 0;
	$lbs = 0;
	$oz = 0;
	foreach($cart_array as $q)
	{
		$productid = $q['id'];
		$quantity = $q['quantity'];
		$query = "SELECT * FROM products WHERE ID='$productid' LIMIT 1";
		$result = mysql_query($query) or die ("error1" . mysql_error());
		$product = mysql_fetch_array($result);
		$oz += $product['PIECE_SPECS_WEIGHT_OZ'] * $quantity;
	}
	$lbs = convertTolbs($oz);
	if($lbs < 1)
		$lbs = 1;
	return ceil($lbs);
}
function convertTolbs($oz)
{
	return ceil($oz/16);
}
?>