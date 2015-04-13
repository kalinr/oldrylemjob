<?
if($_POST['BUTTON_x'] != "")
{
	$products_qty_array = $_POST['QUANTITY'];
	$products_id_array = $_POST['PRODUCTID'];
	
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
		//maybe add some code to put in minimum qtys?
		unset($cart_array);
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
$brandid = productBrandModNametoId($content['MOD_NAME']);
	$has_products = true;
if($qa[0] == "")
{
	//first check for color swatch
	$query = "SELECT * FROM products, brands_products WHERE products.ID=brands_products.PRODUCTID AND brands_products.BRANDID='$brandid' AND (LAYOUTID='1' OR LAYOUTID2='1') AND HEX_COLOR!='' ORDER BY ID LIMIT 1";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$product = mysql_fetch_array($result);

	if($product['HEX_COLOR'] != "" && $product['ID'] != "")
	{
		$qa[0] = "color-swatch";
		$qa[1] = strtoupper($product['HEX_COLOR']);
	}
	else
	{
		$query = "SELECT * FROM products, brands_products WHERE products.ID=brands_products.PRODUCTID AND brands_products.BRANDID='$brandid' AND (LAYOUTID>1 OR LAYOUTID=0) AND (LAYOUTID2>1 OR LAYOUTID2=0) ORDER BY LAYOUTID, LAYOUTID2 LIMIT 1";
		$result = mysql_query($query) or die ("error1" . mysql_error());
		$product = mysql_fetch_array($result);
		if($product['LAYOUTID'] > 1)
		{
			if($product['LAYOUTID'] == 2)
				httpRedirect("/".$content['MOD_NAME']."/view-grid/".$product['ID']);
			else if($product['LAYOUTID'] == 3)
				httpRedirect("/".$content['MOD_NAME']."/no-view/".$product['ID']);
			else if($product['LAYOUTID'] == 4)
				httpRedirect("/".$content['MOD_NAME']."/view-single/".$product['ID']);
			else if($product['LAYOUTID'] == 5)
				httpRedirect("/".$content['MOD_NAME']."/view-display/".$product['ID']);
		}
		else if($product['LAYOUTID2'] > 1)
		{
			if($product['LAYOUTID2'] == 2)
				httpRedirect("/".$content['MOD_NAME']."/view-grid/".$product['ID']);
			else if($product['LAYOUTID2'] == 3)
				httpRedirect("/".$content['MOD_NAME']."/no-view/".$product['ID']);
			else if($product['LAYOUTID2'] == 4)
				httpRedirect("/".$content['MOD_NAME']."/view-single/".$product['ID']);
			else if($product['LAYOUTID2'] == 5)
				httpRedirect("/".$content['MOD_NAME']."/view-display/".$product['ID']);
		}
		else
			$has_products = false;
	}
	//if(($product['LAYOUTID'] == 3 OR $product['LAYOUTID2'] == 3) AND $qa[0] == "")
	//	$qa[0] = "no-view";
}
if($qa[0] == "view-grid")
{
	$query = "SELECT * FROM products WHERE ID='".$qa[1]."'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$product = mysql_fetch_array($result);
}
else if($qa[0] == "view-single")
{
	$query = "SELECT * FROM products WHERE ID='".$qa[1]."'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$product = mysql_fetch_array($result);
	$display = $row['DISPLAY'];
}
else if($qa[0] == "no-view")
{

}
?>