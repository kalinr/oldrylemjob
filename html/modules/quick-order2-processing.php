<?
if($_SESSION['USERID'] == "")
{
	$_SESSION['STATUS'] = "You must be logged in to access the quick order form.";
	$_SESSION['LOGIN_REDIRECT'] = $content['MOD_NAME'];
	httpRedirect("/login");
}
$cart_array = $_SESSION['CART'];
if($_POST['BUTTON'] == "Add To Cart")
{
	$products_sku_array = $_POST['SKU'];
	$products_qty_array = $_POST['QUANTITY'];
	$count = 0;
	$count2 = 0;
	if(sizeof($products_qty_array) > 0)
	{
		foreach($products_qty_array as $q)
		{
			if($q > 0 && $q != "" && $products_sku_array[$count2] != "")
				$count++;
			$count2++;
		}
	}
	if($count == 0)
		$error = "You must specify at least one product to add to the cart.";
	else
	{
		$count = 0;
		$count2 = 0;
		foreach($products_sku_array as $sku)
		{
			$sku = strtoupper(trim($sku));
			$productid = productSkutoID($sku,1);
			$quantity = $products_qty_array[$count];
			if($quantity == "" or $quantity < 1)
				$quantity = 1;
			if($productid > 0)
			{
				$cart_array[$productid]['id'] = $productid;
				$cart_array[$productid]['quantity'] = $quantity;
			}
			else if($sku != "")
			{
				$invalid_sku[$count2] = $sku;
				$count2++;
			}
			$count++;
		}
		$_SESSION['CART'] = $cart_array;
		if($count2 == 0)
		{
			saveCookieCart();
			httpRedirect("/cart");
		}
		else
		{
			unset($cart_array);
			$error = "The following items are discontinued or invalid: ";
			$count = 0;
			foreach($invalid_sku as $sku)
			{
				if($count > 0)
					$error .= ", ".$sku;
				else
					$error .= $sku;
				$count++;
			}
			//assemble original array
			$count = 0;
			foreach($products_sku_array as $sku)
			{
				if($sku != "")
				{
					$cart_array[$count]['sku'] = $sku;
					$cart_array[$count]['quantity'] = $products_qty_array[$count];
					$count++;
				}
			}
		}
	}
}
?>