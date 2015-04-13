<? if($qa[0] == "edit"){ ?>
<form action="/<? echo $content['MOD_NAME']; ?>/edit/<? echo $qa[1]; ?>" method="post" id="myform" enctype="multipart/form-data">
<fieldset>
<legend>Product</legend>
<p style="float:left;margin-right:5px;margin-top:0">Name<br /><input type="text" name="NAME" value="<? echo stripslashes($name); ?>" /></p>
<p style="float:left;margin-top:0">SKU<br /><input type="text" name="SKU" value="<? echo stripslashes($sku); ?>" /></p>
<p style="clear:both;float:left;margin-right:5px;margin-top:0">Barcode<br /><input type="text" name="BARCODE" value="<? echo stripslashes($barcode); ?>" /></p>
<p style="float:left;margin-top:0">Tariff Code<br /><input type="text" name="TARIFF_CODE" value="<? echo stripslashes($tariff_code); ?>" /></p>

<p style="float:left;margin-right:5px;clear:both;margin-top:0">Color<br /><input type="text" name="COLOR" value="<? echo stripslashes($color); ?>" /></p>
<p style="float:left;margin-top:0">HEX Color<br /><input type="text" name="HEX_COLOR" value="<? echo stripslashes($hex_color); ?>" /></p>
<div id="tinycolor" style="float:left;width:30px;height:30px;margin-top:18px;background:#<? echo stripslashes($hex_color); ?>"></div>

<p style="clear:both">Country of Origin<br /><input type="text" name="COUNTRY_ORIGIN" value="<? echo stripslashes($country_origin); ?>" /></p>
</fieldset>

<fieldset>
<legend>Pricing</legend>
<div style="float: left; margin-right: 10px;">Retail<br /><input type="text" name="RETAIL_COST" value="$<? echo number_format($retail_cost,2); ?>" style="width: 100px;" /></div>
<div style="float: left; margin-right: 10px;">Wholesale<br /><input type="text" name="WHOLESALE_COST" value="$<? echo number_format($wholesale_cost,2); ?>" style="width: 100px;" /></div>
</fieldset>
<fieldset>
<legend>Product Minimums</legend>
<div style="float: left; margin-right: 10px;">Retail<br /><input type="text" name="RETAIL_MINIMUM" value="<? echo $retail_minimum; ?>" style="width: 100px;" /></div>
<div style="float: left; margin-right: 10px;">Prof. Crafters<br /><input type="text" name="PROF_MINIMUM" value="<? echo $prof_minimum; ?>" style="width: 100px;" /></div>
<div style="float: left; margin-right: 10px;">Fabric Only - Wholesale<br /><input type="text" name="WHOLESALE_MINIMUM_FABRIC" value="<? echo $wholesale_minimum_fabric; ?>" style="width: 100px;" /></div>
<div style="float: left; margin-right: 10px;">Non-Fabric Wholesale<br /><input type="text" name="WHOLESALE_MINIMUM" value="<? echo $wholesale_minimum; ?>" style="width: 100px;" /></div>
<div style="float: left; margin-right: 10px;">Distributor<br /><input type="text" name="DISTRIBUTOR_MINIMUM" value="<? echo $distributor_minimum; ?>" style="width: 100px;" /></div>
</fieldset>
<fieldset>
<legend>Piece Specifications</legend>
<div style="float: left; margin-right: 10px;">Weight (oz)<br /><input type="text" name="PIECE_SPECS_WEIGHT_OZ" value="<? echo stripslashes($piece_specs_weight_oz); ?>" style="width: 100px;" /></div>
<div style="float: left; margin-right: 10px;">Length<br /><input type="text" name="PIECE_SPECS_LENGTH" value="<? echo stripslashes($piece_specs_length); ?>" style="width: 100px;" /></div>
<div style="float: left; margin-right: 10px;">Width<br /><input type="text" name="PIECE_SPECS_WIDTH" value="<? echo stripslashes($piece_specs_width); ?>" style="width: 100px;" /></div>
<div style="float: left;">Height<br /><input type="text" name="PIECE_SPECS_HEIGHT" value="<? echo stripslashes($piece_specs_height); ?>" style="width: 100px;" /></div>
</fieldset>
<fieldset>
<legend>Inner Carton Specifications</legend>
<div style="float: left; margin-right: 10px;">Pieces<br /><input type="text" name="INNER_CARTON_PCS" value="<? echo stripslashes($inner_carton_pcs); ?>" style="width: 100px;" /></div>
<div style="float: left; margin-right: 10px;">Weight (oz)<br /><input type="text" name="INNER_CARTON_OZ" value="<? echo stripslashes($inner_carton_oz); ?>" style="width: 100px;" /></div>
<div style="float: left; margin-right: 10px;">Length<br /><input type="text" name="INNER_CARTON_LENGTH" value="<? echo stripslashes($inner_carton_length); ?>" style="width: 100px;" /></div>
<div style="float: left; margin-right: 10px;">Width<br /><input type="text" name="INNER_CARTON_WIDTH" value="<? echo stripslashes($inner_carton_width); ?>" style="width: 100px;" /></div>
<div style="float: left; margin-right: 10px;">Height<br /><input type="text" name="INNER_CARTON_HEIGHT" value="<? echo stripslashes($inner_carton_height); ?>" style="width: 100px;" /></div>
</fieldset>
<fieldset>
<legend>Master Carton Specifications</legend>
<div style="float: left; margin-right: 10px;">Pieces<br /><input type="text" name="MASTER_CARTON_PCS" value="<? echo stripslashes($master_carton_pcs); ?>" style="width: 100px;" /></div>
<div style="float: left; margin-right: 10px;">Weight (oz)<br /><input type="text" name="MASTER_CARTON_WEIGHT_OZ" value="<? echo stripslashes($master_carton_weight_oz); ?>" style="width: 100px;" /></div>
<div style="float: left; margin-right: 10px;">Length<br /><input type="text" name="MASTER_CARTON_LENGTH" value="<? echo stripslashes($master_carton_length); ?>" style="width: 100px;" /></div>
<div style="float: left; margin-right: 10px;">Width<br /><input type="text" name="MASTER_CARTON_WIDTH" value="<? echo stripslashes($master_carton_width); ?>" style="width: 100px;" /></div>
<div style="float: left; margin-right: 10px;">Height<br /><input type="text" name="MASTER_CARTON_HEIGHT" value="<? echo stripslashes($master_carton_height); ?>" style="width: 100px;" /></div>
</fieldset>
<p>Description<br /><textarea name="DESCRIPTION" style="width: 735px; height 110px;" id="editor1"><? echo stripslashes($description); ?></textarea></p>

<!--
<p>Bullet Feature 1<br /><textarea name="BULLET_FEATURE1" style="width: 735px;height:60px"><? echo stripslashes($bullet_feature1); ?></textarea></p>
<p>Bullet Feature 2<br /><textarea name="BULLET_FEATURE2" style="width: 735px;height:60px"><? echo stripslashes($bullet_feature2); ?></textarea></p>
<p>Bullet Feature 3<br /><textarea name="BULLET_FEATURE3" style="width: 735px;height:60px"><? echo stripslashes($bullet_feature3); ?></textarea></p>
<p>Bullet Feature 4<br /><textarea name="BULLET_FEATURE4" style="width: 735px;height:60px"><? echo stripslashes($bullet_feature4); ?></textarea></p>
<p>Bullet Feature 5<br /><textarea name="BULLET_FEATURE5" style="width: 735px;height:60px"><? echo stripslashes($bullet_feature5); ?></textarea></p>
-->
<p>Site Search Keywords<br /><textarea name="SEARCHKEYWORDS" style="width: 735px; height 110px;"><? echo stripslashes($skeywords); ?></textarea></p>


<p>Layout 1<br /><select name="LAYOUTID">
<option value="0">---unassigned---</option>
<?
$query = "SELECT * FROM layouts ORDER BY ID";
$result = mysql_query($query) or die ("error1" . mysql_error());
while($row = mysql_fetch_array($result))
{
	if($layoutid == $row['ID'])
		$selected = " selected";
	else
		$selected = "";
	echo '<option value="'.$row['ID'].'"'.$selected.'>'.stripslashes($row['NAME']).'</option>';
}
?>
</select></p>
<p>Layout 2<br /><select name="LAYOUTID2">
<option value="0">---unassigned---</option>
<?
$query = "SELECT * FROM layouts ORDER BY ID";
$result = mysql_query($query) or die ("error1" . mysql_error());
while($row = mysql_fetch_array($result))
{
	if($layoutid2 == $row['ID'])
		$selected = " selected";
	else
		$selected = "";
	echo '<option value="'.$row['ID'].'"'.$selected.'>'.stripslashes($row['NAME']).'</option>';
}
?>
</select></p>
<? if($qa[1] != ""){ ?>
<fieldset>
<legend>Included in the following sets or packs</legend>
<?
$count = 0;
$query = "SELECT * FROM products, brands_products WHERE ID=PRODUCTID AND PACK='1' ORDER BY NAME";
$result = mysql_query($query) or die ("error1" . mysql_error());
while($row = mysql_fetch_array($result))
{
	if($pack_array[0] != "" && in_array($row['ID'],$pack_array))
		$checked = " checked";
	else
		$checked = "";
	if($row['COLOR'] != "")
		$row['NAME'] = $row['NAME'].' - '.$row['COLOR'];

	if(is_array($brand_array) && in_array($row['BRANDID'],$brand_array))
		echo '<div><input type="checkbox" name="PACK_ARRAY[]" value="'.$row['ID'].'"'.$checked.'><strong>'.stripslashes($row['SKU']).'</strong> '.stripslashes($row['NAME']).'</div>';
	$count++;
}
?>
<? 
if($count == 2)
	echo '<p><em>No related possible products found.</em></p>';
?>

</fieldset>
<? }else{ ?>
<p><em>Included in the following packs hidden. Save product and return to this section to assign.</em></p>
<? } ?>
<fieldset>
<legend>Displayed In</legend>
<?
$query = "SELECT * FROM brands ORDER BY ID";
$result = mysql_query($query) or die ("error1" . mysql_error());
while($row = mysql_fetch_array($result))
{
	if($brand_array != "" && in_array($row['ID'],$brand_array))
		$checked = " checked";
	else
		$checked = "";
	echo '<div style="float: left; width: 200px; margin-right: 15px;"><input type="checkbox" name="BRAND_ARRAY[]" value="'.$row['ID'].'"'.$checked.' />'.stripslashes($row['NAME']).'</div>';
}
?>
</fieldset>
<fieldset>
<legend>Image</legend>
<?
if(file_exists("images/products/".$qa[1].".jpg") && $qa[1] != "")
	echo '<p><img src="/images/products/'.$qa[1].'.jpg" border="0" /><br /><a href="javascript:confirmDeleteImage()">delete image</a></p>';
else
	echo '<p style="color: gray">No image uploaded</p>';
?>
<p>Upload JPG, PNG, or GIF<br /><input type="file" name="IMAGE" style="width: 300px;" /></p>
</fieldset>
<p><input type="checkbox" name="WHOLESALEONLY" value="1"<? if($wholesaleonly){ echo ' checked'; } ?> /> Display 
to non-retail customers only?</p>
<p><input type="checkbox" name="DISCOUNT" value="1"<? if($discount){ echo ' checked'; } ?> /> Allow Discount</p>
<p><input type="checkbox" name="PACK" value="1"<? if($pack){ echo ' checked'; } ?> /> Pack</p>
<p><input type="checkbox" name="ACTIVE" value="1"<? if($active){ echo ' checked'; } ?> /> Active (display on website)</p>
<p><input type="checkbox" name="DISPLAY" value="1"<? if($display){ echo ' checked'; } ?> /> This is a display</p>
<? if($qa[1] != "" && $name != ""){ ?>
<p><input type="checkbox" name="UPDATEALL" value="1"<? if($updateall){ echo ' checked'; } ?> /> Update all products with this information having the name '<? echo stripslashes($name); ?>'. <br /><br />Use 
&quot;Update all&quot; wisely, this cannot be undone. Will not bulk update SKU, Barcode, Color, Hex Code 
or Display to non-retail.</p>

<? } ?>
<p><input type="submit" name="BUTTON" value="Save" style="width:120px" /><? if($qa[1] != ""){ ?> <input type="button" name="BUTTON" style="width:120px" value="Delete" onclick="javascript:confirmDelete()" /><? } ?></p>
</form>
<? }else{ ?>
<form action="/<? echo $content['MOD_NAME']; ?>" method="post" id="myform">
<p>Search: <input type="text" onfocus="this.select()" name="SEARCH" value="<? echo stripslashes($_SESSION['ADMIN']['PRODUCTS']['SEARCH']); ?>" style="display:inline;" />&nbsp;&nbsp;<input type="submit" name="BUTTON" value="Search" style="width:90px" /> <input type="button" onclick="javascript:window.location='/admin/products/reset'" value="Reset" style="width:90px" /> <input type="button" onclick="javascript:window.location='/admin/products/edit'" value="Create" style="width:90px" /></p>
</form>
<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:100%">
<tr>
	<th style="width: 85px;">Product SKU</th>
	<th>Brand</th>
	<th>Product Name</th>
	<th>Color</th>
	<th style="text-align: center; width: 40px;">Active</th>
</tr>
<?
	if($_SESSION['ADMIN']['PRODUCTS']['CURRENT_RESULT'] != "")
		$current_result = $_SESSION['ADMIN']['PRODUCTS']['CURRENT_RESULT'];
	else
		$current_result = $qa[1];
	if($_SESSION['ADMIN']['PRODUCTS']['SEARCH'] != "")
		$search = $_SESSION['ADMIN']['PRODUCTS']['SEARCH'];
	
	if($current_result == "" or $current_result < 1)
		$current_result = 1;
	$limit = ($current_result-1)*DISPLAY_RESULTS.','.DISPLAY_RESULTS;
	
	$filter = "";
	if($search != '')
	{
		$terms = explode(' ', $search);
		foreach ($terms as $term)
			if ($term != '')
				//$filter .= " AND CONCAT(SKU,'|||',NAME,'|||',DESCRIPTION,'|||',COLOR,'|||') LIKE '%$term%'";
				$filter .= " AND CONCAT(SKU,'|||',NAME,'|||',COLOR,'|||') LIKE '%$term%'";
	}
			
	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM products WHERE ID>1 $filter ORDER BY NAME LIMIT $limit";
	//echo $query;
	$results = mysql_query($query) or die(mysql_error());
	$countquery = "SELECT FOUND_ROWS() AS FOUND";
	$countresults = mysql_fetch_array(mysql_query($countquery));
	$totalcount = $countresults['FOUND'];
	$count2 = mysql_num_rows($results);
	while($row = mysql_fetch_array($results))
	{
		if($row['NAME'] == "")
			$row['NAME'] = "(no name)";
?>
<tr>
	<td class="leftcell"><a href="/admin/products/edit/<? echo $row['ID']; ?>"><? echo stripslashes($row['SKU']); ?></a></td>
	<td><? echo stripslashes(brandName($row['ID'])); ?></td>
	<td><a href="/admin/products/edit/<? echo $row['ID']; ?>"><? echo stripslashes($row['NAME']); ?></a></td>
	<td><? echo stripslashes($row['COLOR']); ?><div id="tinycolor" style="background:#<? echo stripslashes($row['HEX_COLOR']); ?>"></td>
	<td align="center"><? if($row['ACTIVE']){ echo '&#10004;'; } ?></td>
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
<? } ?>