<?
if($qa[1] != "")
{
	$query = "SELECT * FROM promocodes WHERE ID='".$qa[1]."'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$promocode = mysql_fetch_array($result);
	if($promocode['ID'] == "")
		httpRedirect("/".$content['MOD_NAME']);
}
if($_POST['BUTTON'] == "Save")
{
	$name = mysqlClean($_POST['NAME']);
	$code = strtolower(mysqlClean($_POST['CODE']));
	$month = $_POST['MONTH'];
	$year = $_POST['YEAR'];
	$day = $_POST['DAY'];
	$flatrate = ereg_replace("[^0-9.]","",$_POST['FLATRATE']);
	$percentage = ereg_replace("[^0-9.]","",$_POST['PERCENTAGE']);
	$recurring = $_POST['RECURRING'];
	
	if($name == "")
		$error = "Please type in a name for this promo code.";
	else if($code == "")
		$error = "Please type in a promo code that users will use on your website.";
	else if($qa[1] != "" && !promocodeUnique($qa[1], 0, $name))
		$error = "The code $code is in use by another promo code.";
	else if($year != "0000" && $month != "00" && $day != "00" && !checkdate($month, $day, $year))
		$error = "The expiration date you selected is not a valid date.";
	else if(($percentage == 0 or $percentage == "") AND ($flatrate == "" and $flatrate == 0))
		$error = "Please specify a the type of discount you would like to give (flat rate or percentage).";
	else if($percentage > 0 && $flatrate > 0)
		$error = "You cannot have both flat rate and percentage discounts. Please one blank or set to 0.";
	else if($percentage > 100)
		$error = "You cannot give a discount greater than 100%.";
	else
	{
		if($percentage != "")
			$percentage = $percentage / 100;
		if($year != "" && $month != "" && $day != "")
				$expiration = formatPostDate($_POST['YEAR'],$_POST['MONTH'],$_POST['DAY']);
			else
				$expiration = "0000-00-00";
		if($qa[1] == "")
			$qa[1] = promocodesCreate(0, $name, $code, $flatrate, $percentage, $expiration, $recurring);
		else
			promocodesUpdate($qa[1], $name, $code, $flatrate, $percentage, $expiration, $recurring);
		httpRedirect("/".$content['MOD_NAME']);
	}
}
else if($qa[0] == "delete")
{
	promocodesDelete($qa[1]);
	httpRedirect("/".$content['MOD_NAME']);
}
else if($qa[0] == "edit" && $qa[1] != "")
{
	$name = $promocode['NAME'];
	$code = $promocode['CODE'];
	$flatrate = $promocode['FLATRATE'];
	$percentage = $promocode['PERCENTAGE'] * 100;
	$recurring = $promocode['RECURRING'];
	$date_extract = extractYearMonthDayTime($promocode['EXPIRATION']);
	$year = $date_extract['year'];
	$month = $date_extract['month'];
	$day = $date_extract['day'];
}
else if($qa[0] == "reset")
{
	unset($_SESSION['PROMOCODES']['CURRENT_RESULT']);
	unset($_SESSION['PROMOCODES']['SEARCH']);
	httpRedirect("/".$content['MOD_NAME']);
}
?>