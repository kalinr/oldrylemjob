<?
if($_POST['BUTTON'] == "Continue with Credit Card")
{
	$ccnum = ereg_replace("[^0-9]","",$_POST['CCNUM']);
	$ccmonth = $_POST['CCMONTH'];
	$ccyear = $_POST['CCYEAR'];
	$ccver = ereg_replace("[^0-9]","",$_POST['CCVER']);
	$cczip = ereg_replace("[^0-9]","",$_POST['CCZIP']);
	$ponumber = $_POST['PONUMBER'];
	
	if(($ccnum == "" OR !validCard($ccnum)))
		$error = "Your credit card number is not valid.";
	else if(!checkexperation($ccmonth,$ccyear))
		$error = "Your credit card is expired.";
	else if($ccver == '')
		$error = "Please enter your credit card verification number. This is the 3 digit number on the back of your credit card.";
	else if($cczip == '')
		$error = "Please enter the credit card billing zip code.";
	else
	{
		$_SESSION['CCNUM'] = $ccnum;
		$_SESSION['CCMONTH'] = $ccmonth;
		$_SESSION['CCYEAR'] = $ccyear;
		$_SESSION['CCVER'] = $ccver;
		$_SESSION['CCZIP'] = $cczip;
		$_SESSION['PONUMBER'] = $ponumber;
		httpRedirect("/checkout/review");
	}
}
else if($_POST['BUTTON'] == "Continue with Purchase Order")
{
	$ponumber = $_POST['PONUMBER'];
	if($ponumber == '')
		$error = "PO number is required.";
	else
	{
		$_SESSION['PONUMBER'] = $ponumber;
		httpRedirect("/checkout/review");
	}
}
else if(isset($_SESSION['PONUMBER']))
{
	$ponumber = $_SESSION['PONUMBER'];
	unset($_SESSION['CCNUM']);
	unset($_SESSION['CCMONTH']);
	unset($_SESSION['CCYEAR']);
	unset($_SESSION['CCVER']);
	unset($_SESSION['CCZIP']);
	unset($_SESSION['PONUMBER']);
}
else if(isset($_SESSION['CCNUM']))
{
	$ccnum = $_SESSION['CCNUM'];
	$ccmonth = $_SESSION['CCMONTH'];
	$ccyear = $_SESSION['CCYEAR'];
	$ccver = $_SESSION['CCVER'];
	$cczip = $_SESSION['CCZIP'];
	unset($_SESSION['CCNUM']);
	unset($_SESSION['CCMONTH']);
	unset($_SESSION['CCYEAR']);
	unset($_SESSION['CCVER']);
	unset($_SESSION['CCZIP']);
	unset($_SESSION['PONUMBER']);
}
else if($account['ZIP'] != "")
	$cczip = $account['ZIP'];
?>