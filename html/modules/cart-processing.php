<?
$cart_array = $_SESSION['CART'];
if($qa[1] == "checkout" or $qa[1] == "update")
{
	$quantity_array = $_POST['QUANTITY'];
	$count = 0;
	if(sizeof($cart_array) > 0)
	{
	foreach($cart_array as $i)
	{
		$productid = $i['id'];
		$post_quantity = $quantity_array[$count];
		if($post_quantity > 0)
		{
			$new_cart_array[$productid]['id'] = $productid;
			$new_cart_array[$productid]['quantity'] = $post_quantity;
		}
		$count++;
	}
	}
	$_SESSION['CART'] = $new_cart_array;
	if($count == 0)
	{
		mysql_query("UPDATE accounts SET SAVED_CART='' WHERE ID='".$account['ID']."'") or die(mysql_error());
		if(isset($_SESSION['PROMO_CODE']))
			unset($_SESSION['PROMO_CODE']);
		cart_cookiesDelete();
	}	
	else
		saveCookieCart();
	if($qa[1] == "checkout")
	{
		httpRedirect("/cart/0/checkout2");
	}
	else
		httpRedirect("/".$content['MOD_NAME']);
}
else if($qa[1] == "checkout2")
{
	if(sizeof($cart_array) > 0)
	{
		if($account['ID'] != "")
			httpRedirect("/checkout/shipping");
		else
			httpRedirect("/checkout");
	}
	else
	{
		$_SESSION['STATUS'] = "You must have at least one product in your shopping cart before you can checkout.";
		httpRedirect("/cart");
	}
}
else if($qa[1] == "save-cart")
{
	if($_SESSION['USERID'] == "")
	{
		$_SESSION['STATUS'] = "You must login or create an account in order to save your cart.";
		$_SESSION['LOGIN_REDIRECT'] = "cart/0/save-cart";
		httpRedirect("/login");
	}
	else
	{
		$cart = serialize($cart_array);
		mysql_query("UPDATE accounts SET SAVED_CART='$cart' WHERE ID='".$account['ID']."'") or die(mysql_error());
		$_SESSION['STATUS'] = "Thank you! Your cart has been saved and it will be loaded next time to login to Imagine Crafts. You may continue shopping or continue at a later time.";
		httpRedirect("/cart");
	}
}
else if($qa[1] == "promocode")
{
	$promo_code = strtolower(trim(mysqlClean($_POST['PROMO_CODE'])));
	if($promo_code == "")
		$error = "Please type in a promo code.";
	else if(!validPromoCode($promo_code))
		$error = "The promo code code you typed in is not valid or is expired.";
	else
	{
		$_SESSION['STATUS'] = "Promo code applied.";
		$_SESSION['PROMO_CODE'] = $promo_code;
		httpRedirect("/".$content['MOD_NAME']);
	}
}
else if($qa[1] == "remove")
{
	$count = 0;
	if(sizeof($cart_array) > 0)
	{
		foreach($cart_array as $i)
		{
			if($qa[0] != $i['id'] && $i['quantity'] > 0)
			{
				$id = $i['id'];
				$new_cart_array[$id]['id'] = $i['id'];
				$new_cart_array[$id]['quantity'] = $i['quantity'];
				$count++;
			}
		}
	}
	$_SESSION['CART'] = $new_cart_array;
	if($count == 0)
	{	
		mysql_query("UPDATE accounts SET SAVED_CART='' WHERE ID='".$account['ID']."'") or die(mysql_error());
		if(isset($_SESSION['PROMO_CODE']))
			unset($_SESSION['PROMO_CODE']);
		cart_cookiesDelete();
	}
	else
		saveCookieCart();
	httpRedirect("/".$content['MOD_NAME']);	
}
else if ($qa[1] == "wipecart") {

  mysql_query("UPDATE accounts SET SAVED_CART='' WHERE ID='".$account['ID']."'") or die(mysql_error());
  if(isset($_SESSION['PROMO_CODE'])) { unset($_SESSION['PROMO_CODE']); }
  cart_cookiesDelete();
  unset($_SESSION['CART']);
  httpRedirect("/cart");
  
}

//check product minimums
$minimum_upgrade = false;
if(sizeof($cart_array) > 0)
{
	$count = 0;
	foreach($cart_array as $p)
	{
		$productid = $p['id'];
		$quantity = $p['quantity'];
		$query = "SELECT * FROM products WHERE ID='$productid' LIMIT 1";
		$result = mysql_query($query) or die ("error1" . mysql_error());
		$product = mysql_fetch_array($result);
		if($account['TYPEID'] == 2) //wholesale fabric
		{
			if($quantity < $product['WHOLESALE_MINIMUM_FABRIC'])
			{
				$cart_array[$productid]['quantity'] = $product['WHOLESALE_MINIMUM_FABRIC'];
				$cart_array[$productid]['minimum_upgrade'] = true;
				$minimum_upgrade = true;
				$count++;			
			}
		}
		else if($account['TYPEID'] == 3) //wholesale non-fabric
		{
			if($quantity < $product['WHOLESALE_MINIMUM'])
			{
				$cart_array[$productid]['quantity'] = $product['WHOLESALE_MINIMUM'];
				$cart_array[$productid]['minimum_upgrade'] = true;
				$minimum_upgrade = true;
				$count++;			
			}
		}
		else if($account['TYPEID'] == 4) //distributor
		{
			if($quantity < $product['DISTRIBUTOR_MINIMUM'])
			{
				$cart_array[$productid]['quantity'] = $product['DISTRIBUTOR_MINIMUM'];
				$cart_array[$productid]['minimum_upgrade'] = true;
				$minimum_upgrade = true;
				$count++;				
			}
		}
		else if($account['TYPEID'] == 5) //professional
		{
			if($quantity < $product['PROF_MINIMUM'])
			{
				$cart_array[$productid]['quantity'] = $product['PROF_MINIMUM'];
				$cart_array[$productid]['minimum_upgrade'] = true;
				$minimum_upgrade = true;
				$count++;			
			}
		}
		else //retail
		{
			if($quantity < $product['RETAIL_MINIMUM'])
			{
				$cart_array[$productid]['quantity'] = $product['RETAIL_MINIMUM'];
				$cart_array[$productid]['minimum_upgrade'] = true;
				$minimum_upgrade = true;
				$count++;			
			}			
		}
		if($minimum_upgrade)
		{
			$_SESSION['STATUS'] = "$count of the products in your cart did not meet the minimum order quantity for your account type. Products below minimum quantity have been increased automatically and are noted below.";
			$_SESSION['CART'] = $cart_array;
		}
	}
	//dollar value
	$hasorder = accountHasOrder($account['ID']);
	$query = "SELECT * FROM accounts_types WHERE ID='".$account['TYPEID']."' LIMIT 1";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$account_type = mysql_fetch_array($result);

	if($hasorder)
		$minimum_dollar = $account_type['MINIMUM_ORDER'];
	else if(!$account['BYPASS_INITIAL_MINIMUM'])
		$minimum_dollar = $account_type['MINIMUM_INITIAL'];
	else
		$minimum_dollar = $account_type['MINIMUM_ORDER'];

	//end dollar value
}
//end check product minimums
?>