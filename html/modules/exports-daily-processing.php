<?
	$start = formatPostDate($_POST['YEAR'],$_POST['MONTH'],$_POST['DAY']);
	$end = formatPostDate($_POST['YEAR2'],$_POST['MONTH2'],$_POST['DAY2']);
	
	if(!isset($_POST['YEAR']))
	{
		$start = date("Y")."-01-01";
		$end = date("Y-m-d");
	}
	else
	{
		header('Content-type: text/csv');
	header("Cache-Control: must-revalidate");
	header("Pragma: must-revalidate");
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename=daily-report.csv');
	$sep = ",";	
	echo "Order Date,Web Order Number,Customer Account Number,Company Name,Sales Rep First Last,Customer First Last,Phone,Items,Net Total\n";
	$start = timezoneReverse("$start 00:00:00");
	$end = timezoneReverse("$end 23:59:59");
	$query = "SELECT * FROM orders WHERE DATETIME BETWEEN '$start' AND '$end' ORDER BY DATETIME";
	$result = mysql_query($query) or die (mysql_error());
	while($row = mysql_fetch_array($result))
	{
		//CUSTOMER ACCOUNT INFORMATION
		$query2 = "SELECT * FROM accounts WHERE ID='".$row['ACCOUNTID']."' LIMIT 1";
		$result2 = mysql_query($query2) or die (mysql_error());
		$customer = mysql_fetch_array($result2);
	
		//SALES REP
		$query2 = "SELECT * FROM accounts WHERE ID='".$customer['SALESREP_ID']."' LIMIT 1";
		$result2 = mysql_query($query2) or die (mysql_error());
		$sales = mysql_fetch_array($result2);
		
		//ITEMS
		$count = 0;
		$items = "";
		$query2 = "SELECT * FROM orders_details WHERE ORDERID='".$row['ID']."'";
		$result2 = mysql_query($query2) or die (mysql_error());
		while($row2 = mysql_fetch_array($result2))
		{
			if($count > 0)
				$items .= "\n";
			$items .= $row2['QUANTITY']." x ".$row2['SKU']." ".$row2['NAME'];
			$count++;
		}
		
		echo csvExportReady(datetimeformat($row['DATETIME'])).$sep.csvExportReady($row['ID']).$sep.csvExportReady($customer['ACCOUNT_NUMBER']).$sep.csvExportReady($row['ORGANIZATION']).$sep.csvExportReady($sales['FIRST'].' '.$sales['LAST']).$sep.csvExportReady($row['FIRST'].' '.$row['LAST']).$sep.csvExportReady($row['PHONE']).$sep.csvExportReady($items).$sep.csvExportReady($row['SUBTOTAL'])."\n";	
	}
	
	exit();
		//httpRedirect("/admin/exports/0/daily/$start/$end");
	}
	$year = $start{0}.$start{1}.$start{2}.$start{3};
	$month = $start{5}.$start{6};
	$day = $start{8}.$start{9};
	
	$year2 = $end{0}.$end{1}.$end{2}.$end{3};
	$month2 = $end{5}.$end{6};
	$day2 = $end{8}.$end{9};
?>