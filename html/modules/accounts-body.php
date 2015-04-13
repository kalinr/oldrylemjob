<form action="/<? echo $content['MOD_NAME']; ?>" method="post" id="myform">
<p>Search: <input type="text" name="SEARCH" value="<? echo stripslashes($search); ?>" style="display:inline;" />&nbsp;&nbsp;<input type="submit" name="BUTTON" value="Search" style="width:90px" /> <input type="button" onclick="javascript:window.location='/admin/customers/profile/edit'" value="Create" style="width:90px" /></p>
</form>
<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:100%">
<tr>
	<th>Contact Name</th>
	<th>Company</th>
	<th>Location</th>
	<th>Account Type</th>
</tr>
<?
	$current_result = $qa[1];
	if($current_result == "" or $current_result < 1)
		$current_result = 1;
	$limit = ($current_result-1)*DISPLAY_RESULTS.','.DISPLAY_RESULTS;
	
	$filter = "";
	if($search != '')
	{
		$terms = explode(' ', addslashes($search));
		foreach ($terms as $term)
			if ($term != '')
				$filter .= " AND CONCAT(FIRST,'|||',LAST,'|||',ORGANIZATION,'|||') LIKE '%$term%'";
	}
			
	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM accounts WHERE accounts.TYPEID<6 or accounts.TYPEID=8  $filter ORDER BY LAST, FIRST LIMIT $limit";
	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM accounts WHERE ID>0  $filter ORDER BY LAST, FIRST LIMIT $limit";
	$results = mysql_query($query) or die(mysql_error());
	$countquery = "SELECT FOUND_ROWS() AS FOUND";
	$countresults = mysql_fetch_array(mysql_query($countquery));
	$totalcount = $countresults['FOUND'];
	$count2 = mysql_num_rows($results);
	while($row = mysql_fetch_array($results))
	{
?>
<tr>
	<td class="leftcell"><a href="/admin/customers/profile/<? echo $row['ID']; ?>"><? echo stripslashes($row['LAST'].', '.$row['FIRST']); ?></a></td>
	<td><a href="/admin/customers/profile/<? echo $row['ID']; ?>"><? echo stripslashes($row['ORGANIZATION']); ?></a></td>
	<td><? echo stripslashes($row['CITY']).', '.$row['STATE']; ?></td>
	<td><? echo accountTypeName($row['TYPEID']); ?></td>
</tr>
<?
	}
?>
</table>
	<?
	if($count2 == 0)
		echo '<p>No results.</p>';
	else
		include("global/results-footer.php");
	?>
<div style="clear: both;"></div>