<?
/*
echo '<pre>';
print_r($collections_array);
print_r($top_order_array);
print_r($display_title_array);
echo '</pre>';
*/
?>
<? if($qa[0] == "edit" && $qa[2] == ""){ ?>
<form action="/<? echo $content['MOD_NAME']; ?>/edit/<? echo $qa[1]; ?>" method="post" id="myform" enctype="multipart/form-data">
<p><select name="CATEGORYID">
<option value="">---CHOOSE CATEGORY---</option>
<?
	$query = "SELECT * FROM categories ORDER BY TOP_ORDER";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	while($row = mysql_fetch_array($result))
	{
		if($categoryid == $row['ID'])
			$selected = " selected";
		else
			$selected = "";
		echo '<option value="'.$row['ID'].'"'.$selected.'>'.stripslashes($row['NAME']).'</option>';
	}
?>
</select></p>
<p>Name<br /><input type="text" name="NAME" value="<? echo stripslashes($name); ?>" /></p>
<p>Description<br /><textarea style="width:600px;height:160px" name="DESCRIPTION"><? echo stripslashes($description); ?></textarea></p>
<?
if($banner != "")
{
	$banner = "images/brands/".$banner;
	if(file_exists($banner))
		echo '<p><img src="/'.$banner.'" border="0" /><br /><a href="javascript:confirmDeleteImage()">delete image</a></p>';
}
?>
<p>Upload Banner File<br /><input type="file" NAME="FILE" /></p>
<p><input type="checkbox" name="ACTIVE" value="1"<? if($active){ echo ' checked'; } ?> /> Active (display on website)</p>
<p><input type="submit" name="BUTTON" value="Save" style="width:100px" /><? if($qa[1] != ""){ ?> <input type="button" name="BUTTON" value="Delete" style="width:100px" onclick="javascript:confirmDelete(<? echo $qa[1]; ?>)" /><? } ?></p>
<p><a href="/<? echo $content['MOD_NAME']; ?>">Back to Categories</a> | <a href="/<? echo $content['MOD_NAME']; ?>/edit/<? echo $qa[1]; ?>/collections">Collections</a> | <a href="/<? echo $content['MOD_NAME']; ?>/edit/<? echo $qa[1]; ?>/related">Related Products</a></p>
<? }else if($qa[2] == "related"){ ?>
<h2><? echo stripslashes($name); ?> Related Products</h2>
<p>Important: Make sure to remove top order fields and display titles from unchecked products.</p>
<form action="/<? echo $content['MOD_NAME']; ?>/edit/<? echo $qa[1]; ?>/related" method="post" id="myform">
<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:100%">
<tr>
	<th style="width: 30px; text-align: center;">&nbsp;</th>
	<th style="width: 60px; text-align: center;">Top Order</th>
	<th style="width: 240px;">Display Title</th>
	<th>Product Name</th>
	<th style="width: 60px; text-align: center;">Display</th>
</tr>
<?
$count = 0;
$query = "SELECT * FROM products GROUP BY NAME ORDER BY NAME";
$result = mysql_query($query) or die ("error1" . mysql_error());
while($row = mysql_fetch_array($result))
{
	if($products_array[0] != "" && in_array($row['ID'],$products_array))
	{
		$checked = " checked";
		$display_title = $display_title_array[$count];
		$top_order = $top_order_array[$count];
		$count++;
	}
	else
	{
		$checked = "";
		$display_title = "";
		$top_order = "";
	}
?>
<tr>
	<td style=" text-align: center;"><input type="checkbox" name="PRODUCTS[]" value="<? echo $row['ID']; ?>"<? echo $checked; ?> /></td>
	<td align="center"><input type="text" name="TOP_ORDER[]" value="<? echo stripslashes($top_order); ?>" style="width: 30px;" /></td>
	<td align="center"><input type="text" name="DISPLAY_TITLE[]" value="<? echo stripslashes($display_title); ?>" style="width: 250px;" /></td>
	<td><? echo stripslashes($row['NAME']); ?></td>
	<td align="center"><? if($row['DISPLAY']){ echo '&#10004;'; }else{ echo '&nbsp;'; } ?></td>
</tr>
<?
}
?>
</table>
<p><input type="submit" name="BUTTON" value="Save Related Products" /></p>
</form>
<? }else if($qa[2] == "collections"){ ?>
<h2><? echo stripslashes($name); ?> Collections</h2>
<p>Important: Make sure to remove top order fields and display titles from unchecked products.</p>
<form action="/<? echo $content['MOD_NAME']; ?>/edit/<? echo $qa[1]; ?>/collections" method="post" id="myform">
<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:100%">
<tr>
	<th style="width: 30px; text-align: center;">&nbsp;</th>
	<th style="width: 60px; text-align: center;">Top Order</th>
	<th style="width: 240px;">Display Title</th>
	<th>Product Name</th>
	<th style="width: 60px; text-align: center;">Display</th>
</tr>
<?
$count = 0;
$query = "SELECT * FROM products GROUP BY NAME ORDER BY NAME";
$result = mysql_query($query) or die ("error1" . mysql_error());
while($row = mysql_fetch_array($result))
{
	if($collections_array[0] != "" && in_array($row['ID'],$collections_array))
	{
		$checked = " checked";
		$display_title = $display_title_array[$count];
		$top_order = $top_order_array[$count];
		$count++;
	}
	else
	{
		$checked = "";
		$display_title = "";
		$top_order = "";
	}
?>
<tr>
	<td style=" text-align: center;"><input type="checkbox" name="COLLECTIONS[]" value="<? echo $row['ID']; ?>"<? echo $checked; ?> /></td>
	<td align="center"><input type="text" name="TOP_ORDER[]" value="<? echo stripslashes($top_order); ?>" style="width: 30px;" /></td>
	<td align="center"><input type="text" name="DISPLAY_TITLE[]" value="<? echo stripslashes($display_title); ?>" style="width: 250px;" /></td>
	<td><? echo $row['ID'].' '.stripslashes($row['NAME']); ?></td>
	<td align="center"><? if($row['DISPLAY']){ echo '&#10004;'; }else{ echo '&nbsp;'; } ?></td>
</tr>
<?
}
?>
</table>
<p><input type="submit" name="BUTTON" value="Save Collections" /></p>
</form>
<? }else{ ?>
<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:100%">
<tr>
	<th>Brand Name</th>
	<th>Category</th>
	<th>Featured Product Photo</th>
	<th style="text-align: center; width: 100px;">Sort Products</th>
	<th style="text-align: center; width: 60px;">Active</th>
	<th style="text-align: center; width: 60px;">Delete</th>
</tr>
<?	
	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM brands ORDER BY NAME";
	$results = mysql_query($query) or die(mysql_error());
	$countquery = "SELECT FOUND_ROWS() AS FOUND";
	$countresults = mysql_fetch_array(mysql_query($countquery));
	$totalcount = $countresults['FOUND'];
	$count2 = mysql_num_rows($results);
	while($row = mysql_fetch_array($results)) {
	
	  if ($row['FEATURED_PRODUCT'] == '0') {
	    $prodNm = 'Not Chosen';
	  }
	  else {
	    $prodNameQry = "SELECT NAME FROM products WHERE ID='" . $row['FEATURED_PRODUCT'] . "'";
	    $prodNameRes = mysql_query($prodNameQry) or die(mysql_error());
	    $prodNameData = mysql_fetch_assoc($prodNameRes);
	    $prodNm = $prodNameData['NAME'];
	    if (empty($prodNm)) { $prodNm = 'Not Chosen'; }
	  }
	  	
?>
<tr>
	<td class="leftcell"><a href="/admin/brands/edit/<? echo $row['ID']; ?>"><? echo stripslashes($row['NAME']); ?></a></td>
	<td><a href="/admin/categories/edit/<? echo $row['CATEGORYID']; ?>"><? echo stripslashes(categoryName($row['CATEGORYID'])) ?></a></td>
	<td><a href="/admin/featured-product/<? echo $row['ID']; ?>"><?php echo $prodNm; ?></a></td>
	<td align="center"><a href="/admin/product-sorting/<? echo $row['ID']; ?>"><? echo brandCategoryCount($row['ID']); ?></a></td>
	<td align="center"><? if($row['ACTIVE']){ echo '&#10004;'; } ?></td>
	<td align="center"><a href="javascript:confirmDelete(<? echo $row['ID']; ?>)">delete</a></td>
</tr>
<?
	}
?>
</table>
<p><a href="/admin/brands/edit">Create Brand</a></p>
	<?
	if($count2 == 0)
		echo '<p>No results.</p>';
	//else
		//include("global/results-footer.php");
	?>
<div style="clear: both;"></div>
<? } ?>