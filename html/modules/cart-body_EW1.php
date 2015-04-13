<?
if(sizeof($cart_array) > 0)
{
?>
<p>The contents of your shopping cart is listed below.  Simply click on "Checkout" to purchase your items.  To change quantities of any item(s), just enter the new quantity and click on "Update Cart".</p>
		<form action="/<? echo $content['MOD_NAME']; ?>/0/update" method="post" id="cart">
			<table border="0" id="shoppingcarttable" cellpadding="0" cellspacing="0">
				<tr class="headrow">
					<td class="col1 skucol">SKU</td>
					<td class="w55">Qty</td>
					<td>Product</td>
					<td class="cost">Price</td>
					<td class="cost">Total</td>
					<td class="w55">Remove</td>
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
		
		if($productid == '')
			$productid = 0;
		if($product['NAME'] != '')
		{
?>
				<tr>
					<td class="col1"><a href="/<? echo productModName($productid); ?>"><? echo stripslashes($product['SKU']); ?></a></td>
					<td class="w55">
					<input onfocus="this.select()" class="qtyfield" name="QUANTITY[]" value="<? echo $quantity; ?>" maxlength="3" onkeypress="return goodchars(event,'0123456789')" />
					</td>
					<td><? echo stripslashes($product['NAME']); ?></a>
					<? if($cart_array[$productid]['minimum_upgrade']){ echo '<br /><strong style="color: red;">Quantity automatically increased</strong>'; } ?>
					<? if(!$product['ACTIVE']){ echo '<br /><strong style="color: red;">Product is no longer available. Quantity set to 0.</strong>'; } ?>
					</td>
					<td class="cost">$<? echo money_format('%2i',$product['PRICE']); ?></td>
					<td class="cost">$<? echo money_format('%2i',$product['PRETOTAL']); ?></td>
					<td class="w55"><a href="javascript:confirmRemove(<? echo $productid; ?>)" 
					title="Remove this product from the cart"><img border="0" src="/images/removefromcart.gif" width="30" height="30"></a></td>
				</tr>

<?
		}
		$cart_array[$productid]['minimum_upgrade'] = false;
	}
	$_SESSION['CART'] = $cart_array;
?>
			</table>
			<p class="totalrow" style="text-align: right;">Order Total (USD): &nbsp;$<? echo money_format('%2i',$subtotal); ?>
			<? if($_SESSION['PROMO_CODE'] != "")
				echo '<br />Promo Discount: -'.money_format('%2i',calculatePromoDiscount($_SESSION['PROMO_CODE'], $subtotal)); ?>
			<? if($account['DISCOUNT'] != "" && $account['DISCOUNT'] != 0)
			{
				$customer_discount = $account['DISCOUNT'] * 100;
				echo '<br />Preferred Customer Discount: -'.money_format('%2i',($subtotal * $account['DISCOUNT'])); } ?>
			</p>
			
			<p style="clear:both"><a href="javascript:checkout<? if($minimum_dollar > $subtotal) { echo '3'; }else{ echo '2'; } ?>()">
			<img border="0" src="/images/btncheckout.gif" width="120" height="37" alt="Checkout" style="float:right;margin-left:10px" /></a>
			<input type="image" src="/images/btnupdatecart.gif" width="120" height="37" border="0" alt="Update Cart" name="BUTTON_UPDATE" style="float:right; margin-left:10px">
			 <a href="javascript:confirmSaveCart()"><img src="/images/btn-save-cart.png" alt="Save Cart" width="120" height="37" style="float:right;margin-left:10px" /></a>
			 <? if(prevPage() != "" && prevPage() != "login" && prevPage() != $content['MOD_NAME']){ ?>
 			 <a href="/<? echo prevPage(); ?>"><img src="/images/btn-continue-shopping.png" alt="Continue Shopping" width="120" height="37" style="float:right" /></a>
 			 <? } ?>
			</p>
			<p style="clear:both;float:right;margin-top:12px;font-size:11px; width: 300px;"><input type="checkbox" id="AGREE" value="1" /> By clicking "Checkout" below, you are indicating that you understand and agree to our <a href="/documents/IMAGINECRAFTS_TERMS_AND_CONDITIONS_OF_SALE.pdf" target="_blank">Terms and Conditions of Sale</a>.</p>
		</form>
		<? 
		if (1==2)
		{
		?>
		<div style="margin-top: -25px; width: 270px;">
		<form action="/<? echo $content['MOD_NAME']; ?>/0/promocode" method="post" id="myform">
		<p>Promo Code<br /><input type="text" name="PROMO_CODE" value="<? echo stripslashes($_SESSION['PROMO_CODE']); ?>" style="display:inline; width: 90px;" /> <input type="submit" name="BUTTON" value="Add" style="width: 90px;" /></p>		
		</form>
		</div>
		<?
		}
		 ?>
		<div style="clear: both;"></div>
<? 
}
else if($_SESSION['USERID'] != "")
	echo '<p style="margin-top: 50px;" class="gray"><strong>There are no products in your shopping cart. Please use the navigation bar to the left to shop or you can also <a href="/myaccount/orders">manage your account</a>.</strong></p>';
else
	echo '<p style="margin-top: 50px;" class="gray"><strong>There are no products in your shopping cart. Please use the navigation bar to the left to shop.</strong></p>';
?>