<? if($qa[0] == "edit"){ ?>
<form action="/<? echo $content['MOD_NAME']; ?>/edit/<? echo $qa[1]; ?>" method="post" id="myform">
<p>Name<br /><input type="text" name="NAME" value="<? echo stripslashes($name); ?>" /></p>
<p>Order from Top<br /><input type="text" name="TOP_ORDER" value="<? echo stripslashes($top_order); ?>" /></p>
<p><input type="submit" name="BUTTON" value="Save" style="width:100px" /><? if($qa[1] != ""){ ?> <input style="width:100px" type="button" name="BUTTON" value="Delete" onclick="javascript:confirmDelete(<? echo $qa[1]; ?>)" /><? } ?></p>
<p><a href="/<? echo $content['MOD_NAME']; ?>">Back to Categories</a></p>
<? }else{ ?>
<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:100%">
<tr>
	<th>Category Name</th>
	<th style="text-align: center; width: 100px;">Order from Top</th>
	<th style="text-align: center; width: 90px;">Brands</th>
	<th style="text-align: center; width: 60px;">Edit</th>
	<th style="text-align: center; width: 60px;">Delete</th>
</tr>
<?	
	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM categories ORDER BY TOP_ORDER";
	$results = mysql_query($query) or die(mysql_error());
	$countquery = "SELECT FOUND_ROWS() AS FOUND";
	$countresults = mysql_fetch_array(mysql_query($countquery));
	$totalcount = $countresults['FOUND'];
	$count2 = mysql_num_rows($results);
	while($row = mysql_fetch_array($results))
	{
?>
<tr>
	<td class="leftcell"><a href="/admin/categories/edit/<? echo $row['ID']; ?>"><? echo stripslashes($row['NAME']); ?></a></td>
	<td align="center"><? echo $row['TOP_ORDER']; ?></td>
	<td align="center"><? echo categoryBrandCount($row['ID']); ?></td>
	<td align="center"><a href="/admin/categories/edit/<? echo $row['ID']; ?>">edit</a></td>
	<td align="center"><a href="javascript:confirmDelete(<? echo $row['ID']; ?>)">delete</a></td>
</tr>
<?
	}
?>
</table>
<p><a href="/admin/categories/edit">Create Category</a></p>
	<?
	if($count2 == 0)
		echo '<p>No results.</p>';
	//else
		//include("global/results-footer.php");
	?>
<div style="clear: both;"></div>
<? } ?>