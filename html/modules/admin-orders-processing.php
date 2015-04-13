<?
if($_POST['BUTTON'] == "Search")
{
	$search = trim(mysqlClean($_POST['SEARCH']));
	$searchall = $_POST['SEARCHALL'];
	$_SESSION['ADMIN']['ORDER']['SEARCH'] = $search;
	$_SESSION['ADMIN']['ORDER']['SEARCHALL'] = $searchall;
	httpRedirect("/".$content['MOD_NAME']."/results/1");
}
else if($qa[0] == "reset")
{
	unset($_SESSION['ADMIN']['ORDER']['SEARCH']);
	unset($_SESSION['ADMIN']['ORDER']['SEARCHALL']);
	httpRedirect("/".$content['MOD_NAME']);
}
else if($qa[0] == "results" or $qa[0] == "")
{
	$search = $_SESSION['ADMIN']['ORDER']['SEARCH'];
	$searchall = $_SESSION['ADMIN']['ORDER']['SEARCHALL'];
}
else if($qa[0] != "") //view order
{
	if($content['MOD_NAME'] == "myaccount/orders")
		$query = "SELECT * FROM orders WHERE ACCOUNTID='".$account['ID']."' AND ID='".$qa[0]."' LIMIT 1";
	else
		$query = "SELECT * FROM orders WHERE ID='".$qa[0]."' LIMIT 1";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$order = mysql_fetch_array($result);
	if($order['ID'] == "")
		httpRedirect("/".$content['MOD_NAME']);
}
if($_POST['BUTTON'] == "Finalize Order")
{
	$shipping_tracking = $_POST['SHIPPING_TRACKING'];
	$send_email = $_POST['SEND_EMAIL'];
	$shipping = ereg_replace("[^0-9.]","",$_POST['SHIPPING']);
	$bypasscc = $_POST['BYPASSCC'];
	if($order['TAX_RATE'] > 0)
	{
		$tax = $order['TAX_RATE'] * (($order['SUBTOTAL'] + $order['SHIPPING']) - $order['DISCOUNT_CUSTOMER'] - $order['DISCOUNT_PROMO']);
		$total = $tax + $order['SUBTOTAL'] + $shipping;
		mysql_query("UPDATE orders SET SHIPPING_TRACKING='$shipping_tracking',TAX='$tax',SHIPPING='$shipping',TOTAL='$total' WHERE ID='".$qa[0]."'") or die(mysql_error());
	}
	else
	{
		$total = $order['SUBTOTAL'] + $shipping - $order['DISCOUNT_CUSTOMER'] - $order['DISCOUNT_PROMO'];
		mysql_query("UPDATE orders SET SHIPPING_TRACKING='$shipping_tracking',SHIPPING='$shipping',TOTAL='$total' WHERE ID='".$qa[0]."'") or die(mysql_error());
	}

	//capture authorized funds
	if($order['TRANSACTIONID'] > 0 && $bypasscc == '')
	{
		require_once("functions/argofire.php");
		$gateway = new ArgoFire(ARGOFIRE_USERNAME, ARGOFIRE_PASSWORD);
		if(!$gateway->post_auth($order['TRANSACTIONID'], $total))
		{
			$paymentSuccess = false;
			$paymentMessage = $gateway->getError();
			$_SESSION['STATUS'] = "Credit card failed funds capture. ".$paymentMessage;
			httpRedirect("/".$content['MOD_NAME']."/".$qa[0]);
		}
		else
		{
			$paymentSuccess = true;
			$paymentMessage = $gateway->transactionMsg();
			$transactionid = $gateway->transactionId();
		}
	}
	else
	{
		$transactionid = $order['TRANSACTIONID'];
	}
	mysql_query("UPDATE orders SET FULFILLED='1',TRANSACTIONID='$transactionid',PAID='$total' WHERE ID='".$qa[0]."'") or die(mysql_error());
	//end capture authorized funds
	if($send_email)
		sendOrderShippedNotification($qa[0]);
		
	httpRedirect("/".$content['MOD_NAME']);
}
else
	$shipping = $order['SHIPPING'];
if($qa[1] == "recreate")
{
	$count = 0;
	if(isset($new_cart_array))
		unlink($new_cart_array);
	//recreates order, stores in session and sends user to cart
	$query = "SELECT * FROM orders_details WHERE ORDERID='".$order['ID']."'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	while($order_items = mysql_fetch_array($result))
	{
		$productid = $order_items['PRODUCTID'];
		if(productIsActive($order_items['PRODUCTID']))
		{
			$productid = $order_items['PRODUCTID'];
			$new_cart_array[$productid]['id'] = $order_items['PRODUCTID'];
			$new_cart_array[$productid]['quantity'] = $order_items['QUANTITY'];
		}
		else
		{
			$count++;
		}
	}
	if($count > 0)
	{
		$_SESSION['STATUS'] = $count." of your ordered item(s) could not be reloaded into the cart because they are no longer in inventory.";
	}
	$_SESSION['CART'] = $new_cart_array;
	httpRedirect("/cart");
}
?>