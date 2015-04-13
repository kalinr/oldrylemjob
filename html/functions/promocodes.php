<?
function promocodesCreate($accountid, $name, $code, $flatrate, $percentage, $expiration, $recurring)
{
	$name = mysqlClean($name);
	$code = mysqlClean($code);
	$flatrate = mysqlClean($flatrate);
	$percentage = mysqlClean($percentage);
	$expiration = mysqlClean($expiration);

	mysql_query("INSERT INTO promocodes(ACCOUNTID, NAME, CODE, FLATRATE, PERCENTAGE, EXPIRATION, RECURRING) VALUES ('$accountid', '$name', '$code', '$flatrate', '$percentage', '$expiration', '$recurring')") or die(mysql_error());
	return mysql_insert_id();
}
function promocodesUpdate($id, $name, $code, $flatrate, $percentage, $expiration, $recurring)
{
	$name = mysqlClean($name);
	$code = mysqlClean($code);
	$flatrate = mysqlClean($flatrate);
	$percentage = mysqlClean($percentage);
	$expiration = mysqlClean($expiration);

	mysql_query("UPDATE promocodes SET NAME='$name', CODE='$code', FLATRATE='$flatrate', PERCENTAGE='$percentage', EXPIRATION='$expiration', RECURRING='$recurring' WHERE ID=$id") or die(mysql_error());
}
function promocodesDelete($id)
{
	mysql_query("DELETE FROM promocodes WHERE ID='$id'") or die(mysql_error());
}
function promocodeUnique($id, $accountid, $name)
{
	$query = "SELECT ID FROM promocodes WHERE ID!='$id' AND NAME='$name' LIMIT 1";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	if($row['ID'] == "")
		return true;
	else
		return false;
}
function validPromoCode($promo_code)
{
	$promo_code = strtolower(trim(mysqlClean($promo_code)));
	$query = "SELECT ID FROM promocodes WHERE CODE='$promo_code' AND EXPIRATION>='".date("Y-m-d")."' LIMIT 1";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	if($row['ID'] == "")
		return false;
	else
		return true;
}
function calculatePromoDiscount($promo_code, $subtotal)
{
	$promo_code = strtolower(trim(mysqlClean($promo_code)));
	$query = "SELECT * FROM promocodes WHERE CODE='$promo_code' AND EXPIRATION>='".date("Y-m-d")."' LIMIT 1";
	
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	if($row['ID'] == "")
		return 0;
	else
	{
		if($row['FLATRATE'] > 0)
			$discount = $row['FLATRATE'];
		else
			$discount = $subtotal * $row['PERCENTAGE'];
		if($discount < 0)
			return $subtotal;
		else
			return $discount;
	}
}
function promocodeName($promo_code)
{
	$query = "SELECT * FROM promocodes WHERE CODE='$promo_code' LIMIT 1";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['NAME'];
}
?>