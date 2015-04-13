					<table border="0" id="shoppingcarttable" cellpadding="0" cellspacing="0">
				<tr class="headrow">
					<td class="col1 skucol">SKU</td>
					<td class="w55">Qty</td>
					<td>Product</td>
					<td class="center">Price</td>
					<td class="center">Total</td>
				</tr>
<?
	$subtotal = 0;
	foreach($cart_array as $q)
	{
		$productid = $q['id'];
		$quantity = $q['quantity'];
		$query = "SELECT * FROM products WHERE ID='$productid' LIMIT 1";
		$result = mysql_query($query) or die ("error1" . mysql_error());
		$product = mysql_fetch_array($result);
		if(!$product['ACTIVE'])
			$quantity = 0;
		if($product['COLOR'] != "")
			$product['NAME'] = $product['NAME'].' - '.$product['COLOR'];
		if(2 <= $account['TYPEID'] && $account['TYPEID'] <= 5)
			$product['PRICE'] = $product['WHOLESALE_COST'];
		else
			$product['PRICE'] = $product['RETAIL_COST'];
		$product['PRETOTAL'] = $product['PRICE'] * $quantity;
		$subtotal += $product['PRETOTAL'];
?>
				<tr>
					<td class="col1"><a href="/<? echo productModName($productid); ?>"><? echo stripslashes($product['SKU']); ?></a></td>
					<td class="w55" style="text-align: center;">
					<? echo $quantity; ?>
					</td>
					<td><? echo stripslashes($product['NAME']); ?></a>
					</td>
					<td class="center">$<? echo money_format('%2i',$product['PRICE']); ?></td>
					<td class="center">$<? echo money_format('%2i',$product['PRETOTAL']); ?></td>
				</tr>

<?
	}
	$_SESSION['SUBTOTAL'] = $subtotal;
	//CALCULATE SALES TAX
		if(($account['TYPEID'] == 1 OR $account['TYPEID'] > 5 OR $account['TAX']) && $shipping['STATE'] == "WA")
		{
			/*
			if($shipping['STATE'] == "WA")
			{
				$state = $account['STATE'];
				$city = $account['CITY'];
				$zip = $account['ZIP'];
				$address = $account['ADDRESS1'];
			}
			else*/
			//{
				$state = $shipping['STATE'];
				$city = $shipping['CITY'];
				$zip = $shipping['ZIP'];
				$address = $shipping['ADDRESS1'];
			//}
			$result = getTax($city, $state, $zip, $address);
			$tax_rate = $result['Rate'];
			$tax_code = $result['LocationCode'];
			$taxable_amount = $subtotal + $shipping_cost - $discount_customer - $discount_promo;
			$tax = money_format('%i',($taxable_amount * $tax_rate));
		}
		else
		{
			//TAX EXCEPT OR OUT OF STATE
			$tax_code = 0;
			$tax_rate = 0;
			$tax = 0;
		}
	
?>
			</table>
			<p class="totalrow" style="text-align: right;">Order Subtotal (USD): &nbsp;$<? echo money_format('%2i',$subtotal); ?>
			<? if($_SESSION['PROMO_CODE'] != ""){
				$discount_promo = calculatePromoDiscount($_SESSION['PROMO_CODE'], $subtotal);
				if($discount_promo != 0)
					echo '<br />Promo Discount: $-'.money_format('%2i',$discount_promo); ?>
			<? } ?>
			<? if($account['DISCOUNT'] != "" && $account['DISCOUNT'] != 0)
			{
				$customer_discount = $account['DISCOUNT'] * 100;
				$discount = money_format('%2i',($subtotal * $account['DISCOUNT']));
				$_SESSION['CUSTOMER_DISCOUNT'] = $discount;
				if($customer_discount != 0)
					echo '<br />Preferred Customer Discount: $-'.$discount; } 
			
				if($shipping > 0)
					echo '<br />Shipping: $'.money_format('%i',$shipping['COST']);
				if($tax > 0)
					echo '<br />Sales Tax: $'.money_format('%i',$tax);
				$_SESSION['TAX'] = $tax;
				//echo "Discount: ".$discount_promo." xx";
				if($discount_promo == "")
					$discount_promo = 0;
				//echo $customer_discount;
				//echo " $subtotal + $tax + $shipping_cost - $discount_promo - $discount";
				//$total = $subtotal + $tax + $shipping['COST'] - $discount;
				$total = $subtotal + $tax + $shipping['COST'] - $discount_promo - $discount;
				$_SESSION['TOTAL'] = $total;
				echo '<br />Order Total: $'.money_format('%i',$total);
				?>
			</p>


		<?
		if($_SESSION['PROMO_CODE'] != "")
			echo '<p>Promo Code: '.stripslashes($_SESSION['PROMO_CODE']).'</p>';
		
		?>
		<div style="clear: both;"></div>