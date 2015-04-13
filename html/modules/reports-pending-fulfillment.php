<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:100%">
<tr>
	<th style="text-align: center; width: 60px;">Order #</th>
	<th style="width: 90px;">Date</th>
	<th>Customer Name</th>
	<th style="text-align: right; margin-right: 2px; width: 60px;">Amount</th>
	<th style="text-align: center; width: 60px;">Fulfilled</th>
</tr>
<?

	$current_result = $qa[1];
	if($current_result == "" or $current_result < 1)
		$current_result = 1;
		
	$filter = "";
		$filter = "";
	if($search != '')
	{
		$terms = explode(' ', mysqlClean($search));
		foreach ($terms as $term)
			if ($term != '')
				$filter .= " AND UPPER(CONCAT(FIRST,'|||',LAST,'|||',ORGANIZATION,'|||',SHIPPING_ORGANIZATION,'|||',CAST(ID as CHAR),'|||',CAST(TOTAL as CHAR))) LIKE UPPER('%$term%')";
	}
	if(!$searchall)
		$filter .= " AND FULFILLED='0'";
	if($content['MOD_NAME'] == "myaccount/orders")
		$filter .= " AND ACCOUNTID='".$account['ID']."'";
	else if($content['MOD_NAME'] == "admin/customers/profile")
		$filter .= " AND ACCOUNTID='".$qa[0]."'";
		
	$limit = ($current_result-1)*DISPLAY_RESULTS.','.DISPLAY_RESULTS;
	if($content['MOD_NAME'] == "admin/customers/profile" OR $content['MOD_NAME'] == "myaccount/orders")
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM orders WHERE ID>0 $filter ORDER BY DATETIME DESC LIMIT $limit";
	else
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM orders WHERE ID>0 $filter ORDER BY DATETIME DESC LIMIT $limit";
	$results = mysql_query($query) or die(mysql_error());
	$countquery = "SELECT FOUND_ROWS() AS FOUND";
	$countresults = mysql_fetch_array(mysql_query($countquery));
	$totalcount = $countresults['FOUND'];
	$count2 = mysql_num_rows($results);
	while($row = mysql_fetch_array($results))
	{
		if($row['ORGANIZATION'] != "")
			$customer_name = $row['ORGANIZATION'];
		else
			$customer_name = $row['FIRST'].' '.$row['LAST'];
		
			$url ="admin/orders/".$row['ID'];
?>
<tr>
	<td style="text-align: center;" class="leftcell"><a href="/<? echo $url; ?>"><? echo $row['ID']; ?></a></td>
	<td><? echo dateformat($row['DATETIME']); ?></td>
	<td><? echo $customer_name; ?></td>
	<td style="text-align: right; margin-right: 2px;">$<? echo $row['TOTAL']; ?></td>
	<td style="text-align: center;"><? if($row['FULFILLED']){ echo '&#10004;'; }else{ echo '&#215;'; } ?></td>
</tr>
<?
	}
?>
</table>
<p><a href="javascript:window.print()">Print</a></p>