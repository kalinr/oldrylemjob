<?
function ordersCreate($accountid, $first, $last, $personordering, $organization, $address, $address2, $city, $state, $zip, $country, $shipping_organization, $shipping_address, $shipping_address2, $shipping_city, $shipping_state, $shipping_zip, $shipping_country, $shipping_method, $phone, $email, $email2, $subtotal, $discount_customer, $discount_promo, $tax, $tax_rate, $tax_code, $shipping, $total, $balance, $paid, $promo_code, $promo_description, $statusid, $transactionid, $cctype, $last4cc, $ponumber, $comments, $cart_array, $account, $ship_partial)
{
	$customerid = mysql_real_escape_string($customerid);
	$datetime = currentDateTime();
	
	$first = mysql_real_escape_string($first);
	$last = mysql_real_escape_string($last);
	
	$personordering = mysql_real_escape_string($personordering);
	
	$organization = mysql_real_escape_string($organization);
	$address = mysql_real_escape_string($address);
	$address2 = mysql_real_escape_string($address2);
	$city = mysql_real_escape_string($city);
	$state = mysql_real_escape_string($state);
	$zip = mysql_real_escape_string($zip);
	$country = mysql_real_escape_string($country);
	$shipping_first = mysql_real_escape_string($shipping_first);
	$shipping_last = mysql_real_escape_string($shipping_last);
	$shipping_organization = mysql_real_escape_string($shipping_organization);
	$shipping_address = mysql_real_escape_string($shipping_address);
	$shipping_address2 = mysql_real_escape_string($shipping_address2);
	$shipping_city = mysql_real_escape_string($shipping_city);
	$shipping_state = mysql_real_escape_string($shipping_state);
	$shipping_zip = mysql_real_escape_string($shipping_zip);
	$shipping_country = mysql_real_escape_string($shipping_country);
	$shipping_method = mysql_real_escape_string($shipping_method);
	$phone = mysql_real_escape_string($phone);
	$email = mysql_real_escape_string($email);
	$email2 = mysql_real_escape_string($email2);

	$subtotal = mysql_real_escape_string($subtotal);
	$tax = mysql_real_escape_string($tax);
	$tax_rate = mysql_real_escape_string($tax_rate);
	$tax_code = mysql_real_escape_string($tax_code);
	$promo_code = mysql_real_escape_string($promo_code);
	$promo_description = mysql_real_escape_string($promo_description);
	$transactionid = mysql_real_escape_string($transactionid);
	$ponumber = mysql_real_escape_string($ponumber);
	$comments = mysql_real_escape_string($comments);
	$created = currentDateTime();

	mysql_query("INSERT INTO orders(ACCOUNTID, DATETIME, FIRST, LAST, PERSON_ORDERING, ORGANIZATION, ADDRESS, ADDRESS2, CITY, STATE, ZIP, COUNTRY, SHIPPING_ORGANIZATION, SHIPPING_ADDRESS, SHIPPING_ADDRESS2, SHIPPING_CITY, SHIPPING_STATE, SHIPPING_ZIP, SHIPPING_COUNTRY, SHIPPING_METHOD, PHONE, EMAIL, EMAIL2, SUBTOTAL, DISCOUNT_CUSTOMER, DISCOUNT_PROMO, TAX, TAX_RATE, TAX_CODE, SHIPPING, TOTAL, BALANCE, PAID, PROMO_CODE, PROMO_DESCRIPTION, STATUSID, TRANSACTIONID, CCTYPE, LAST4CC, PONUMBER, COMMENTS, SHIP_PARTIAL, CREATED) VALUES ('$accountid', '$datetime', '$first', '$last', '$personordering', '$organization', '$address', '$address2', '$city', '$state', '$zip', '$country', '$shipping_organization', '$shipping_address', '$shipping_address2', '$shipping_city', '$shipping_state', '$shipping_zip', '$shipping_country', '$shipping_method', '$phone', '$email', $email2, '$subtotal', '$discount_customer','$discount_promo', '$tax', '$tax_rate', '$tax_code', '$shipping', '$total', '$balance', '$paid', '$promo_code', '$promo_description', '$statusid', '$transactionid', '$cctype', '$last4cc', '$ponumber', '$comments', '$ship_partial', '$created')") or die(mysql_error());
	$orderid = mysql_insert_id();

	foreach($cart_array as $i)
	{
		$productid = $i['id'];
		$quantity = $i['quantity'];
		
		$query = "SELECT * FROM products WHERE ID='".$i['id']."'";
		$result = mysql_query($query) or die ("error1" . mysql_error());
		$row = mysql_fetch_array($result);
		if($row['COLOR'] != "")
			$row['NAME'].' - '.$row['COLOR'];
			
		if(2 <= $account['TYPEID'] && $account['TYPEID'] <= 5)
			{
			//$row['PRICE'] = $row['WHOLESALE_COST'];
			$row['PRICE'] = getDiscountedCost($row['WHOLESALE_COST'],$productid,$account['DISCOUNT']);
			}
		else
			{
			$row['PRICE'] = $row['RETAIL_COST'];
			}
			
		orders_detailsCreate($orderid, $row['SKU'], $row['NAME'], $row['SUMMARY'], $quantity, $row['PRICE'], $productid, 1, $row['SIZE_NAME']);
	}
	return $orderid;
}
function orders_detailsCreate($orderid, $sku, $name, $description, $quantity, $rate, $productid, $taxable, $unit="")
{
	$sku = mysql_real_escape_string($sku);
	$name = mysql_real_escape_string($name);
	$description = mysql_real_escape_string($description);
	$quantity = mysql_real_escape_string($quantity);
	$rate = mysql_real_escape_string($rate);
	$productid = mysql_real_escape_string($productid);
	$taxable = mysql_real_escape_string($taxable);
	$unit = mysql_real_escape_string($unit);
	
	$line_total = $quantity * $rate;

	mysql_query("INSERT INTO orders_details(ORDERID, SKU, NAME, DESCRIPTION, QUANTITY, RATE, PRODUCTID, TAXABLE, UNIT, LINE_TOTAL) VALUES ('$orderid', '$sku', '$name', '$description', '$quantity', '$rate', '$productid', '$taxable', '$unit', '$line_total')");
	return mysql_insert_id();
}
function orders_detailsUpdate($id, $sku, $orderid, $name, $description, $quantity, $rate, $productid, $taxable, $unit="")
{
	$sku = mysql_real_escape_string($sku);
	$name = mysql_real_escape_string($name);
	$description = mysql_real_escape_string($description);
	$quantity = mysql_real_escape_string($quantity);
	$rate = mysql_real_escape_string($rate);
	$productid = mysql_real_escape_string($productid);
	$taxable = mysql_real_escape_string($taxable);
	$unit = mysql_real_escape_string($unit);

	mysql_query("UPDATE orders_details SET ORDERID='$orderid', SKU='$sku', NAME='$name', DESCRIPTION='$description', QUANTITY='$quantity', RATE='$rate', PRODUCTID='$productid', TAXABLE='$taxable', UNIT='$unit' WHERE ID=$id");
}
function orders_detailsDelete($id)
{
	mysql_query("DELETE FROM orders WHERE ID='$id'");
	mysql_query("DELETE FROM orders_details WHERE ORDERID='$id'");
}
function orders_deleteVoid($id,$skipIfFulfilled=false)
{
	if($skipIfFulfilled)
		mysql_query("UPDATE orders SET STATUSID='3' WHERE ID=$id");
	else
		mysql_query("UPDATE orders SET STATUSID='3' WHERE ID=$id AND FULFILLED=0");
}
function customerOrderCount($customerid)
{
	$query = "SELECT COUNT(ID) AS COUNT FROM orders WHERE CUSTOMERID='".$customerid."'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['COUNT'];
}
function getTax($city, $state, $zip, $address)
{
	if($state == "WA")
		$result = getLiveWATax($zip, $city, $address,"yes");
	else if($state = "ID")
	{
		$result['Rate'] = 0;
		$result['LocationCode'] ='';
	}
	return $result;
}
function getLiveWATax($zip, $city = "", $address = "",$locationCode="no")
{
	$request = "http://dor.wa.gov/AddressRates.aspx?output=text&addr=" . urlencode($address) . "&city=" . urlencode($city) . "&zip=" . urlencode($zip);

	$session  = curl_init($request); // create a curl session

	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string - not to std out
	
	$response = curl_exec($session);                     // send the request
	curl_close($session);

	$keyvalues = explode(" ", $response);  
	$values = array();
	
	foreach($keyvalues as $pair)
	{
		$pair = explode("=", $pair, 2);
		$values[$pair[0]] = $pair[1];
	}
	if($locationCode == "yes")
		return $values;
	else if ($values['ResultCode'] <= 2)
		return $values['Rate'];
	else
		return "error";
}
?>