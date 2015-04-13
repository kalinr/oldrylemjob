<script>
function showit(b)
{
var rows = document.getElementById('grp-' + b);
	if (rows.style.display == '')  rows.style.display = 'none';
	else rows.style.display = '';
}
</script>
<?
if($account['WHOLESALE'])
	echo '<p>Wholesale pricing displayed.</p>';
?>
<form action="/<? echo $content['MOD_NAME']; ?>" method="post" id="myform">
<input type="hidden" name="SUBMITTER" value="1" />
<?
	$query = "SELECT * FROM brands WHERE ACTIVE='1' AND NAME !='(unknown brand name)' ORDER BY NAME";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$b=-1;
	while($row = mysql_fetch_array($result))
	{
		$b=$b+1;
		$brandid = $row['ID'];
		$categoryid = $row['CATAEGORYID'];
?>
<div style="clear:both;background-color:#B1E6FD; font-weight: bold; font-size: 16px;padding:10px 5px;font-size:14px;border-bottom:1px dotted #666;margin-left:15px;">
<a style="color:#666;font-size:12px;font-weight:normal;" href="javascript:showit(<? echo $b; ?>)">show/hide</a>&nbsp;&nbsp;&nbsp;&nbsp;<? echo stripslashes($row['NAME']); ?>
</div>
<div id="grp-<? echo $b; ?>" style="display:none;padding:8px 0;font-size:12px">
<?
		$query2 = "SELECT * FROM products, brands_products WHERE products.ID=brands_products.PRODUCTID AND brands_products.BRANDID='$brandid' AND ACTIVE='1' ORDER BY SKU, NAME";
		$result2 = mysql_query($query2) or die ("error1" . mysql_error());
		$r = -1;
		while($row2 = mysql_fetch_array($result2))
		{
			$r=$r+1;
			$productid = $row2['ID'];
			//need to add in code to figure out if they are retail or wholesale pricing.
			if($account['WHOLESALE'])
				$row2['PRICE'] = $row2['WHOLESALE_COST'];
			else
				$row2['PRICE'] = $row2['RETAIL_COST'];
			
			//check to see if already in cart
			$quantity = $cart_array[$productid]['quantity'];
?>

	<div style="clear:both;float:left;width: 50px; text-align: center;margin-left:15px;"><input type="hidden" name="PRODUCTS_ID[]" value="<? echo $row2['ID']; ?>" />
		<input type="text" name="PRODUCTS_QTY[]" value="<? echo $quantity; ?>" style="width: 30px;font-size:12px;margin-bottom:10px" onfocus="this.select()" />
	</div>
	<div style="float:left;text-align: center; width: 110px; "><? echo stripslashes($row2['SKU']); ?></div>
	<div style="float:left;width:330px;"><? echo stripslashes($row2['NAME']); ?></div>
	<div style="float:left;width:180px"><? echo stripslashes($row2['COLOR']); ?> 
		<div id="tinycolor" style="background:#<? echo stripslashes($row2['HEX_COLOR']); ?>">
		</div>
	</div>
	<div style="float:left;width: 90px; text-align: right; margin-left: 4px;">$<? echo $row2['PRICE']; ?></div>


<? 
		}
?>
	</div>
<?		
	}
 ?>
<br  clear="all" />
<p style="margin-top:20px"><input type="submit" name="BUTTON" value="Add To Cart" style="width:120px" /></p>
</form>