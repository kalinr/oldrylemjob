<p>Please omit the &ldquo;#&rdquo; sign when entering item numbers.</p><br />
<form action="/<? echo $content['MOD_NAME']; ?>" method="post" id="myform">
<div style="float: left; width: 350px; margin-right: 20px; margin-bottom: 5px;">
<div style="float: left; width: 40px; text-align: center;">&nbsp;</div>
<div style="float: left; width: 60px; text-align: center;">Qty</div>
<div style="float: left; width: 150px; text-align: center;">Item Number<br /><small>Ex. ME-000-900</small></div>
</div>
<div style="float: left; width: 350px; margin-right: 20px; margin-bottom: 5px;">
<div style="float: left; width: 40px; text-align: center;">&nbsp;</div>
<div style="float: left; width: 60px; text-align: center;">Qty</div>
<div style="float: left; width: 150px; text-align: center;">Item Number<br /><small>Ex. ME-000-900</small></div>
</div>
<?
$count = 0;
// if(sizeof($cart_array) > 50)
//	$max = sizeof($cart_array) + 6;
// else
//	$max = 50;
//$count2 = 0;
//if(sizeof($cart_array) > 0)
//{
//	foreach($cart_array as $i)
//	{
//		$c_array[$count2]['id'] = $i['id'];
//		$c_array[$count2]['quantity'] = $i['quantity'];
//		$c_array[$count2]['sku'] = $i['sku'];
//		$count2++;
//	}
//}
//while($count < $max)

while ($count < 50) {
	// if($c_array[$count]['id'] > 0)
	//	$product_sku = productSku($c_array[$count]['id']);
	// else if($c_array[$count]['sku'] != "")
	//	$product_sku = $c_array[$count]['sku'];
	// else
	//	$product_sku = "";
	// $quantity = $c_array[$count]['quantity'];
		
	echo '<div style="float: left; width: 350px; margin-right: 20px; margin-bottom: 5px;">';
	echo '<div style="float: left; width: 40px; text-align: center;">'.($count+1).'</div>';
	// echo '<div style="float: left; width: 60px; margin-right: 10px;"><input type="text" name="QUANTITY[]" value="'.$quantity.'" style="width: 50px;" /></div>';
	// echo '<div style="float: left; width:150px;"><input type="text" name="SKU[]" style="width: 140px;" value="'.$product_sku.'" /></div>';
	echo '<div style="float: left; width: 60px; margin-right: 10px;"><input type="text" name="QUANTITY[]" style="width: 50px;" /></div>';
	echo '<div style="float: left; width:150px;"><input type="text" name="SKU[]" style="width: 140px;" /></div>';
	echo '</div>';
	$count++;
}
?>
<div style="clear: both;"></div>
<div style="margin-left: 40px; margin-top: 10px;"><input type="submit" name="BUTTON" value="Add To Cart" /></div>
</form>
<p>You may also order from the <a href="/order-form">full order form</a>.</p>