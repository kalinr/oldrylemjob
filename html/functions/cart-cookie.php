<?
function cart_cookiesCreate($ip_address, $sessionid, $accountid, $cart_key, $cart_data)
{
	$ip_address = mysqlClean($ip_address);
	$sessionid = mysqlClean($sessionid);
	$accountid = mysqlClean($accountid);
	$date = date("Y-m-d");
	$cart_data = (serialize($cart_data));
	
	mysql_query("INSERT INTO cart_cookies(IP_ADDRESS, SESSIONID, ACCOUNTID, CART_KEY, DATE, CART_DATA) VALUES ('$ip_address', '$sessionid', '$accountid', '$cart_key', '$date', '$cart_data')");
}
function cart_cookiesUpdate($cart_key, $ip_address, $sessionid, $accountid, $cart_data)
{
	$ip_address = mysqlClean($ip_address);
	$sessionid = mysqlClean($sessionid);
	$accountid = mysqlClean($accountid);
	$date = date("Y-m-d");
	$cart_data = (serialize($cart_data));
	mysql_query("UPDATE cart_cookies SET DATE='$date', CART_DATA='$cart_data' WHERE CART_KEY='$cart_key'") or die(mysql_error());
}
function cart_cookiesDelete()
{
	if(isset($_COOKIE['cookiecart']))
	{
		$cart_key = $_COOKIE['cookiecart'];
		mysql_query("DELETE FROM cart_cookies WHERE CART_KEY='$cart_key'");
		setcookie("cookiecart",$value, time()-3600*24*14);
	}
}
function cronDeleteOldCartCookies()
{
	//DELETES CART COOKIES AFTER 14 DAYS
	$date = dateDaySubtract(date("Y-m-d"), 14);
	mysql_query("DELETE FROM cart_cookies WHERE DATE='$date'");
}
function saveCookieCart()
{
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$sessionid = $_COOKIE['PHPSESSID'];
	//first check and see if they have a previous session cookie
	if(isset($_COOKIE['cookiecart']) && validCartCookie($_COOKIE['cookiecart']))
	{
		$cart_key = $_COOKIE['cookiecart'];
		cart_cookiesUpdate($cart_key, $ip_address, $sessionid, $_SESSION['USERID'], $_SESSION['CART']);
	}
	else
	{
		$cart_key = $ip_address.'-'.$sessionid;
		if(setcookie("cookiecart",$cart_key, time()+3600*24*14))
			cart_cookiesCreate($ip_address, $sessionid, $_SESSION['USERID'], $cart_key, $_SESSION['CART']);
	}
}
function recoverCookieCart($mod_name)
{
	if(isset($_COOKIE['cookiecart']) && sizeof($_SESSION['CART']) == 0)
	{
		$query = "SELECT CART_DATA FROM cart_cookies WHERE CART_KEY='".$_COOKIE['cookiecart']."'";
		$result = mysql_query($query) or die ("error1" . mysql_error());
		$row = mysql_fetch_array($result);
		if($row['CART_DATA'] != "" && sizeof(unserialize($row['CART_DATA'])))
		{
			$_SESSION['CART'] = unserialize($row['CART_DATA']);
			httpRedirect("/".$mod_name);
		}
	}
	
}
function validCartCookie($cart_key)
{
	$query = "SELECT * FROM cart_cookies WHERE CART_KEY='".$cart_key."'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	if($row['IP_ADDRESS'] != "")
		return true;
	else
		return false;
}
?>