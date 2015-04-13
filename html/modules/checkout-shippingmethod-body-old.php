<form id="myform" action="/<? echo $content['MOD_NAME']; ?>" method="post">


<?
if (accountIsRetail($account['ID']))
	$iswholesale = 0;
else
	$iswholesale = 1;

if ($iswholesale==0)
{
	echo '<p><strong>Shipping Method</strong></p>';
	$query = "SELECT * FROM shipping_methods WHERE ACTIVE='1'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	while($row = mysql_fetch_array($result))
	{
		if($_SESSION['SHIPPING_METHOD'] == $row['NAME'])
			$checked = " checked";
		else
			$checked = "";
		$cost = UPSshippingCalculation($lbs,$shipping_state,$shipping_zip, $row['ZONE_COLUMN']);
		echo '<p><input type="radio" name="SHIPPING_METHOD" value="'.stripslashes($row['NAME']).'"'.$checked.' /> '.stripslashes($row['NAME']).' $'.$cost.'</p>';
	}
}	
else
{
		echo '<p><strong>Shipping &amp; Handling</strong></p>';
		echo '<p><input type="radio" name="SHIPPING_METHOD" checked value="TBD" style="display:none" />';
		echo 'Shipping charges to be determined at time of order fulfillment.</p><br />';
		echo '<p><input type="hidden" name="WHLSLE" value="1" style="display:none" />';
}
?>

<p><strong>Shipping Options</strong></p>
<p><input type="radio" name="SHIP_PARTIAL" value="Ship complete"<? if($ship_partial == "Ship complete"){ echo ' checked'; } ?> /> Ship complete</p>
<p><input type="radio" name="SHIP_PARTIAL" value="OK to ship partial order"<? if($ship_partial == "OK to ship partial order"){ echo ' checked'; } ?> /> OK to ship partial order</p>

<p>&nbsp;</p>


<?
// If non-retail only
//if (!accountIsRetail($_SESSION['USERID']))
if ($iswholesale==1)
{
?>
<p><strong>Name of person entering this order</strong></p>
<p><input type="text" onfocus="this.select()" name="personordering" maxlength="80" /></p>
<?
}
?>


<p><input type="submit" name="BUTTON" value="Continue" /></p>
</form>