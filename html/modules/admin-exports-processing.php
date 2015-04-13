<?
if($qa[1] == "mailing-list")
{
	header('Content-type: text/csv');
	header("Cache-Control: must-revalidate");
	header("Pragma: must-revalidate");
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename='.date("Y-m-d").'enews.csv');
	$sep = ",";	
	echo "First,Last,Organization,State,Zip,Country,Email,Usage Type,Customer Type,Created\n";
	$query = "SELECT * FROM enews ORDER BY CREATED";
	$result = mysql_query($query) or die (mysql_error());
	while($row = mysql_fetch_array($result))
	{
		//echo csvExportReady($row['FIRST']).$sep.csvExportReady($row['LAST']).$sep.csvExportReady($row['ORGANIZATION']).$sep.csvExportReady($row['ADDRESS']).$sep.csvExportReady($row['CITY']).$sep.csvExportReady($row['STATE']).$sep.csvExportReady($row['ZIP']).$sep.csvExportReady($row['COUNTRY']).$sep.csvExportReady($row['PHONE']).$sep.csvExportReady($row['EMAIL']).$sep.csvExportReady($row['USAGE_TYPE']).$sep.csvExportReady($row['CUSTOMER_TYPE']).$sep.csvExportReady(datetimeformat($row['CREATED']))."\n";
		echo csvExportReady($row['FIRST']).$sep.csvExportReady($row['LAST']).$sep.csvExportReady($row['ORGANIZATION']).$sep.csvExportReady($row['STATE']).$sep.csvExportReady($row['ZIP']).$sep.csvExportReady($row['COUNTRY']).$sep.csvExportReady($row['EMAIL']).$sep.csvExportReady($row['USAGE_TYPE']).$sep.csvExportReady($row['CUSTOMER_TYPE']).$sep.csvExportReady(datetimeformat($row['CREATED']))."\n";
	}
	exit();
}
else if($qa[1] == "keyword-search")
{
	header('Content-type: text/csv');
	header("Cache-Control: must-revalidate");
	header("Pragma: must-revalidate");
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename='.date("Y-m-d").'enews.csv');
	$sep = ",";	
	echo "Search Term,Total Searches,Last IP Address,Last Occurance\n";
	
	$query = "SELECT * FROM search_queries ORDER BY TOTAL_SEARCHES";
	$result = mysql_query($query) or die (mysql_error());
	while($row = mysql_fetch_array($result))
	{
		echo csvExportReady(stripslashes($row['KEYWORD'])).$sep.csvExportReady($row['TOTAL_SEARCHES']).$sep.csvExportReady($row['LAST_IP']).$sep.csvExportReady(datetimeformat($row['LAST_USE']))."\n";	
	}
	exit();
}
else if($qa[1] == "daily")
{
	
}
else if($qa[1] == "buroware")
{
	
}
?>