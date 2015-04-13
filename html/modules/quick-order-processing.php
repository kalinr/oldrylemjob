<?
if($_SESSION['USERID'] == "")
{
	$_SESSION['STATUS'] = "You must be logged in to access the quick order form.";
	$_SESSION['LOGIN_REDIRECT'] = $content['MOD_NAME'];
	httpRedirect("/login");
}
if($_POST['BUTTON'] == "Add To Cart" OR $_POST['SUBMITTER'] == 1)
{
	$products_id_array = $_POST['PRODUCTS_ID'];
	$products_qty_array = $_POST['PRODUCTS_QTY'];
	
	$count = 0;
	if(sizeof($products_qty_array) > 0)
	{
		foreach($products_qty_array as $q)
		{
			if($q > 0 && $q != "")
				$count++;
		}
	}

	if($count == 0)
		$error = "You must specify at least one product to add to the cart.";
	else
	{
		
		$count = 0;
		$cart_array = $_SESSION['CART'];
	
		foreach($products_id_array as $productid)
		{
			$quantity = $products_qty_array[$count];
			if($quantity > 0 && $quantity != "")
			{
				$cart_array[$productid]['id'] = $productid;
				$cart_array[$productid]['quantity'] = $quantity;
			}
			$count++;
		}
		$_SESSION['CART'] = $cart_array;
		saveCookieCart();
		httpRedirect("/cart");
	}
}
?>