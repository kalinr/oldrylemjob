<?
$orderid = $_SESSION['ORDERID'];
unset($_SESSION['ORDERID']);
if($orderid == "")
	$orderid = $qa[0];
?>