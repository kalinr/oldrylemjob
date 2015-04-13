<?php
function totalSales($start,$end,$field)
{
	$query = "SELECT SHIPPING, SUBTOTAL, TAX, TOTAL FROM orders WHERE STATUSID!='3' AND '$start'<=DATETIME AND DATETIME<='$end'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	while($row = mysql_fetch_array($result))
	{
		$subtotal += $row['SUBTOTAL'];
		$tax += $row['TAX'];
		$total += $row['TOTAL'];
		$shipping += $row['SHIPPING'];
	}
	if($field == "subtotal")
		return money_format('%i',$subtotal);
	else if($field == "tax")
		return money_format('%i',$tax);
	else if($field == "total")
		return money_format('%i',$total);
	else if($field == "shipping")
		return money_format('%i',$shipping);
}
function totalaccounting_orders($start,$end,$statusid)
{
	if($statusid == 1) //INACTIVE - DRAFT
		$query = "SELECT SUM(TOTAL) AS TOTAL FROM orders WHERE STATUSID!='3' AND '$start'<=DATETIME AND DATETIME<='$end'";
	else if($statusid == 7) //PAID
		$query = "SELECT SUM(TOTAL) AS TOTAL FROM orders WHERE STATUSID!='3' AND '$start'<=DATETIME AND DATETIME<='$end'";
	else //NOT PAID, AUTOBILL OR BALANCE REMAINS
		$query = "SELECT SUM(TOTAL) AS TOTAL FROM orders WHERE STATUSID!='3' AND '$start'<=DATETIME AND DATETIME<='$end'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['TOTAL'];
}
function totalaccounting_ordersCount($start,$end,$statusid)
{
	if($statusid == 1) //INACTIVE
		$query = "SELECT COUNT(TOTAL) AS COUNT FROM orders WHERE STATUSID!='3' AND '$start'<=DATETIME AND DATETIME<='$end'";
	else if($statusid == 7)
		$query = "SELECT COUNT(TOTAL) AS COUNT FROM orders WHERE STATUSID!='3' AND '$start'<=DATETIME AND DATETIME<='$end'";
	else
		$query = "SELECT COUNT(TOTAL) AS COUNT FROM orders WHERE STATUSID!='3' AND '$start'<=DATETIME AND DATETIME<='$end'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['COUNT'];
}
function totalServiceSales($start,$end,$name)
{
	$total = 0;
	$query = "SELECT orders_details.RATE, orders_details.QUANTITY FROM orders, orders_details WHERE STATUSID!='3' AND '$start'<=orders.DATETIME AND orders.DATETIME<='$end' AND orders.ID=orders_details.ORDERID AND orders_details.NAME LIKE '$name'";
	$result = mysql_query($query) or die ("error12" . mysql_error());
	while($row = mysql_fetch_array($result))
		$total += $row['QUANTITY'] * $row['RATE'];
	return money_format('%i',$total);
}
function totalServiceOccurance($start,$end,$name)
{
	$count = 0;
	$query = "SELECT orders_details.QUANTITY FROM orders, orders_details WHERE STATUSID!='3' AND '$start'<=orders.DATETIME AND orders.DATETIME<='$end' AND orders.ID=orders_details.ORDERID AND orders_details.NAME LIKE '$name'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	while($row = mysql_fetch_array($result))
		$count += $row['QUANTITY'];
	return $count;
}
function serviceLastDate($start,$end,$name)
{
	$count = 0;
	$query = "SELECT orders.DATETIME FROM orders, orders_details WHERE STATUSID!='3' AND '$start'<=orders.DATETIME AND orders.DATETIME<='$end' AND orders.ID=orders_details.ORDERID AND orders_details.NAME LIKE '$name' ORDER BY DATETIME DESC";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['DATETIME'];
}
function totalorders($start,$end,$statusid)
{
	if($statusid == 1) //INACTIVE
		$query = "SELECT SUM(TOTAL) AS TOTAL FROM orders WHERE STATUSID!='3' AND '$start'<=DATETIME AND DATETIME<='$end'";
	else if($statusid == 7)
		$query = "SELECT SUM(TOTAL) AS TOTAL FROM orders WHERE STATUSID!='3' AND '$start'<=DATETIME AND DATETIME<='$end'";
	else
		$query = "SELECT SUM(TOTAL) AS TOTAL FROM orders WHERE STATUSID!='3' AND '$start'<=DATETIME AND DATETIME<='$end'";
		
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
	return $row['TOTAL'];
}
function merchantHasShippingTax($start,$end)
{
	$query = "SELECT ID FROM orders WHERE STATUSID!='3' AND '$start'<=DATETIME AND DATETIME<='$end' AND STATE='WA' AND TAX!='0.00'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
	if($row['ID'] == "")
		return false;
	else
		return true;
}
function monthSalesAverage($month,$year,$all="no")
{
	if($month <= 9)
		$month = "0".$month;
	$total = 0;
	$start = "$year-$month-01";
	$end = "$year-$month-31";
	if($all == "yes")
		$query = "SELECT SUM(TOTAL) AS TOTAL FROM orders WHERE STATUSID!='3' AND '$start'<=DATETIME AND DATETIME<='$end'";
	else
		$query = "SELECT SUM(TOTAL) AS TOTAL FROM orders WHERE STATUSID!='3' AND '$start'<=DATETIME AND DATETIME<='$end'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
	return $row['TOTAL'];
}
?>