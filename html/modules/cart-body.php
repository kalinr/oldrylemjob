<?php
if(sizeof($cart_array) > 0)
{
?>
<p>The contents of your shopping cart are listed below. Simply click on "Checkout" to purchase your items.  To change quantities of any item(s), just enter the new quantity and click on "Update Cart". You can also <a href="javascript:emptyCart()">clear your cart</a>.</p>
		<form action="/<?php echo $content['MOD_NAME']; ?>/0/update" method="post" id="cart">
			<table border="0" id="shoppingcarttable" cellpadding="0" cellspacing="0">
				<tr class="headrow">
					<td class="col1 skucol">SKU</td>
					<td class="w55">Qty</td>
					<td>Product</td>
					<td class="cost">Price</td>
					<td class="cost">Total</td>
					<td class="w55">Remove</td>
				</tr>
<?php
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
			{
			//$product['PRICE'] = $product['WHOLESALE_COST'];
			$product['PRICE'] = getDiscountedCost($product['WHOLESALE_COST'],$productid,$account['DISCOUNT']);
			}
		else
			{		
			$product['PRICE'] = $product['RETAIL_COST'];
			}
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
					<td><?php echo stripslashes($product['NAME']); ?></a>
					<?php if($cart_array[$productid]['minimum_upgrade']){ echo '<br /><strong style="color: red;">Quantity automatically increased</strong>'; } ?>
					<?php if(!$product['ACTIVE']){ echo '<br /><strong style="color: red;">Product is no longer available. Quantity set to 0.</strong>'; } ?>
					</td>
					<td class="cost">$<?php echo money_format('%2i',$product['PRICE']); ?></td>
					<td class="cost">$<?php echo money_format('%2i',$product['PRETOTAL']); ?></td>
					<td class="w55"><a href="javascript:confirmRemove(<?php echo $productid; ?>)" 
					title="Remove this product from the cart"><img border="0" src="/images/removefromcart.gif" width="30" height="30"></a></td>
				</tr>

<?php
		}
		$cart_array[$productid]['minimum_upgrade'] = false;
	}

	$showPreauthCharge = false;
        
	if (accountCheckForWholesalerStatus($account['ID'])) {
	
	  $preauthQry = "SELECT * FROM wholesale_preauth";
          $preauthRes = mysql_query($preauthQry) or die(mysql_error());
          $preauthData = mysql_fetch_assoc($preauthRes);
          $below1000 = $preauthData['below_1000'];
          $above1000 = $preauthData['above_1000'];
          
          if ($subtotal < 1000) {
            // $subtotal += $below1000;
            $preauthAmt = $below1000;
          }
          
          if ($subtotal >= 1000) {
            // $subtotal += $above1000;
            $preauthAmt = $above1000;
          }
          
          $showPreauthCharge = true;
	
	}
	
	$_SESSION['CART'] = $cart_array;
?>
			</table>
			<p class="totalrow" style="text-align: right;">
			<?php

			// if ($showPreauthCharge) {
			
			//  echo 'Wholesaler Additional Preauthorization (USD): &nbsp;$', money_format('%2i',$preauthAmt), '<br />';
			
			// }

			?>
			Order Total (USD): &nbsp;$<? echo money_format('%2i',$subtotal); ?>
			<?php if($_SESSION['PROMO_CODE'] != "")
				echo '<br />Promo Discount: -'.money_format('%2i',calculatePromoDiscount($_SESSION['PROMO_CODE'], $subtotal)); ?>
			<?php if($account['DISCOUNT'] != "" && $account['DISCOUNT'] != 0)
			{
				//$customer_discount = $account['DISCOUNT'] * 100;
				//echo '<br />Preferred Customer Discount: -'.money_format('%2i',($subtotal * $account['DISCOUNT'])); 
				$customer_discount = 0;
			} ?>
			</p>

			<p style="clear:both;float:right;margin-top:12px;font-size:11px; width: 500px;"><input type="checkbox" id="AGREE" value="1" /> By clicking "Checkout", you are indicating that you understand and agree to our <a href="terms-of-use" target="_blank">Terms and Conditions of Sale</a>.</p>
			
			<p style="clear:both" class="checkoutOptions"><a href="javascript:checkout<? if($minimum_dollar > $subtotal) { echo '3'; }else{ echo '2'; } ?>()">
			<img border="0" src="/images/btncheckout.gif" width="120" height="37" alt="Checkout" /></a> &nbsp; 
			<input type="image" src="/images/btnupdatecart.gif" width="120" height="37" border="0" alt="Update Cart" name="BUTTON_UPDATE" /> &nbsp; 
			<a href="javascript:confirmSaveCart()"><img src="/images/btn-save-cart.png" alt="Save Cart" width="120" height="37" /></a>
			<?php if(prevPage() != "" && prevPage() != "login" && prevPage() != $content['MOD_NAME']){ ?>
 			 &nbsp; <a href="/<?php echo prevPage(); ?>"><img src="/images/btn-continue-shopping.png" alt="Continue Shopping" width="120" height="37" /></a>
 			<?php } ?>
			</p>
		</form>
		<?php
		if (1==2)
		{
		?>
		<div style="margin-top: -25px; width: 270px;">
		<form action="/<? echo $content['MOD_NAME']; ?>/0/promocode" method="post" id="myform">
		<p>Promo Code<br /><input type="text" name="PROMO_CODE" value="<? echo stripslashes($_SESSION['PROMO_CODE']); ?>" style="display:inline; width: 90px;" /> <input type="submit" name="BUTTON" value="Add" style="width: 90px;" /></p>		
		</form>
		</div>
		<?php
		}
		 ?>
		<div style="clear: both;"></div>
<?php 
}
else if($_SESSION['USERID'] != "")
	echo '<p style="margin: 30px 0;">There are no products in your shopping cart. You can find products under <a href="/shop">shop</a> or go to <a href="/myaccount/orders">manage your account</a>.</p>';
else
	echo '<p style="margin: 30px 0;">There are no products in your shopping cart. Please proceed to the <a href="/shop">shop</a> section to find our products.</strong></p>';
?>