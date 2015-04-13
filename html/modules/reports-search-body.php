<? if($qa[1] != ""){ ?>
<?
	$query = "SELECT * FROM search_queries WHERE KEYWORD='".addslashes($qa[1])."'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	$search_array = unserialize($row['SEARCH_DATA']);
	echo '<p style="font-size:16px">DISPLAYING RESULTS FOR:<b> '.stripslashes($row['KEYWORD']).'</b></p>';
?>
	<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:100%">
	<tr>
		<th>Website User</th>
		<th style="text-align: center; width: 60px;">Searches</th>
		<th>Last Search</th>
		<th>Last IP</th>
	</tr>
<?
	if(sizeof($search_array)>0)
	{
		foreach($search_array as $i)
		{
			if($i['accountid'] > 0)
				$i['account_name'] = accountFirstLastName($i['accountid']);
			else
				$i['account_name'] = "<em>not logged in</em>";
?>
	<tr>
		<td class="leftcell"><? if($i['accountid'] > 0){ ?><a href="/admin/customers/profile/<? echo $i['accountid']; ?>"><? } ?><? echo $i['account_name']; ?><? if($i['accountid'] > 0){ ?></a><? } ?></td>
		<td align="center"><? echo number_format($i['occurrences']); ?></td>
		<td><? echo datetimeformat($i['last_search']); ?></td>
		<td><a href="http://api.hostip.info/get_html.php?ip=<? echo $i['ip_address']; ?>&position=true" target="_blank"><? echo $i['ip_address']; ?></a></td>
	</tr>
<?
		}	
	}
?>
	</table>	
<?
	echo '<p><strong>Total Searches:</strong> '.number_format($row['TOTAL_SEARCHES']).'</p>';
	echo '<p><strong>Latest Search:</strong> '.datetimeformat($row['LAST_USE']).'</p>';
?>

<? }else{ ?>
<p>Click on a search term to view a break down of search term statistics.</p>
<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:100%">
<tr>
	<th>Search Term</th>
	<th style="text-align: center; width: 60px;">Searches</th>
	<th>Last Search</th>
	<th>Last IP</th>
</tr>
<?	
	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM search_queries ORDER BY LAST_USE DESC";
	$results = mysql_query($query) or die(mysql_error());
	$countquery = "SELECT FOUND_ROWS() AS FOUND";
	$countresults = mysql_fetch_array(mysql_query($countquery));
	$totalcount = $countresults['FOUND'];
	$count2 = mysql_num_rows($results);
	while($row = mysql_fetch_array($results))
	{
?>
<tr>
	<td class="leftcell"><a href="/<? echo $content['MOD_NAME']; ?>/0/<? echo $row['KEYWORD']; ?>"><? echo stripslashes($row['KEYWORD']); ?></a></td>
	<td align="center"><? echo number_format($row['TOTAL_SEARCHES']); ?></td>
	<td><? echo datetimeformat($row['LAST_USE']); ?></td>
	<td><a href="http://api.hostip.info/get_html.php?ip=<? echo $row['LAST_IP']; ?>&position=true" target="_blank"><? echo $row['LAST_IP']; ?></a></td>
</tr>
<?
	}
?>
</table>
<p><a href="/admin/exports/0/keyword-search">Export CSV</a></p>
	<?
	if($count2 == 0)
		echo '<p>No results.</p>';
	//else
		//include("global/results-footer.php");
	?>
<? } ?>
<div style="clear: both;"></div>