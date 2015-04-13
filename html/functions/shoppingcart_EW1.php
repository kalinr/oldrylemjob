<?
function cartStats($account_typeid)
{
	$cart_array = $_SESSION['CART'];
	$subtotal = 0;
	$total_quantity = 0;
	if(sizeof($cart_array) > 0)
	{
		foreach($cart_array as $q)
		{
			$productid = $q['id'];
			$quantity = $q['quantity'];
			$query = "SELECT RETAIL_COST, WHOLESALE_COST FROM products WHERE ID='$productid' LIMIT 1";
			$result = mysql_query($query) or die ("error1" . mysql_error());
			$product = mysql_fetch_array($result);
			if(2 <= $account_typeid && $account_typeid <= 5)
				$product['PRICE'] = $product['WHOLESALE_COST'];
			else
				$product['PRICE'] = $product['RETAIL_COST'];
			$product['PRETOTAL'] = $product['PRICE'] * $quantity;
			$subtotal += $product['PRETOTAL'];
			$total_quantity += $quantity;
		}
	}
	$return_array['subtotal'] = $subtotal;
	$return_array['quantity'] = $total_quantity;
	return $return_array;
}
?>