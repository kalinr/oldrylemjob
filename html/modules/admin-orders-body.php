<?
if($qa[0] != "" && $content['MOD_NAME'] != "admin/customers/profile" && $qa[0] != "results")
{
	echo '<h2 style="margin-bottom:0">Order #'.$order['ID'].'</h2>';
?>
<div style="float: left; width: 300px;">
			<?
			
			$query = "SELECT ACCOUNT_NUMBER FROM accounts WHERE ID=".$order['ACCOUNTID'];
			$result = mysql_query($query) or die ("error1" . mysql_error());
			$acct = mysql_fetch_array($result);			
			
			if($acct['ACCOUNT_NUMBER'] != '')
				echo '<p style="color:navy;font-size:16px;background:yellow"><b>Customer Account Number: '.stripslashes($acct['ACCOUNT_NUMBER']).'</b></p>';			
			
			echo '<p><strong>Billing Information</strong><br />'.stripslashes($order['FIRST']).' '.stripslashes($order['LAST']);
			if($order['ORGANIZATION'] != '')
				echo '<br />'.stripslashes($order['ORGANIZATION']);
			echo '<br />'.stripslashes($order['ADDRESS']);
			if($order['ADDRESS2'] != '')
				echo '<br />'.stripslashes($order['ADDRESS2']);
			echo '<br />'.stripslashes($order['CITY']).', '.stripslashes($order['STATE']).' '.$order['ZIP'];
			echo '<br />'.stripslashes($order['COUNTRY']).'</p>';
			echo '<p>Phone: '.$order['PHONE'];
			echo '<br />Email: <a href="mailto:'.$order['EMAIL'].'">'.$order['EMAIL'].'</a></p>';
			
			?>
			</div>
			<div style="float: left; width: 300px;">
			<?
			
			if($acct['ACCOUNT_NUMBER'] != '')   //keep alignment with first column
				echo '<p style="color:navy;font-size:16px;">&nbsp;</p>';				
			
			echo '<p><strong>Shipping Information</strong><br />'.stripslashes($order['SHIPPING_ORGANIZATION']);
			echo '<br />'.stripslashes($order['SHIPPING_ADDRESS']);
			if($order['SHIPPING_ADDRESS2'] != '')
				echo '<br />'.stripslashes($order['SHIPPING_ADDRESS2']);
			echo '<br />'.stripslashes($order['SHIPPING_CITY']).', '.stripslashes($order['SHIPPING_STATE']).' '.$order['SHIPPING_ZIP'];
			echo '<br />'.stripslashes($order['SHIPPING_COUNTRY']).'</p>';
			echo '<p><strong>Payment Method</strong>';
			if($order['CCTYPE'] != '')
			{
				echo '<br />'.$order['CCTYPE'].' xxxx-xxxx-xxxx-'.last4cc($order['LAST4CC']);
				if($order['PONUMBER'] != ''){ echo ' (REF PO # '.stripslashes($order['PONUMBER']).')'; }
			}
			else
				echo '<br />PO Number: '.$order['PONUMBER'];
			echo '<br /><strong>Shipping Method:</strong> '.$order['SHIPPING_METHOD'];
			echo '<br />'.stripslashes($order['SHIP_PARTIAL']);
			echo '</p>';
			?>
			</div>
			<div style="clear: both;"></div>
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


		$query = "SELECT * FROM orders_details WHERE ORDERID='".$order['ID']."' ORDER BY ID DESC";
		$result = mysql_query($query) or die ("error1" . mysql_error());
		while($product = mysql_fetch_array($result))
		{
			$productid = $product['ID'];    // Matt - This is not valid.  "ID" is not a product ID here. It is the auto increment field for the orders_details table
			$quantity = $product['QUANTITY'];

			// ------- ADDED BY ERIC.  6/30/2012 --- Code for $product['COLOR'] was incorrect as COLOR is not returned from orders_details ---
			$query2 = "SELECT * FROM products WHERE SKU='".$product['SKU']."'";
			$result2 = mysql_query($query2) or die ("error1" . mysql_error());
			$colorrow = mysql_fetch_array($result2);

			if($colorrow['COLOR'] != "")
				$product['NAME'] = $product['NAME'].' - '.$colorrow['COLOR'];
			// --------------------------------------------------------------------	
		
			$product['PRETOTAL'] = $product['RATE'] * $quantity;
?>
				<tr>
					<td class="col1"><? echo stripslashes($product['SKU']); ?></td>
					<td class="w55" style="text-align: center;">
					<? echo $quantity; ?>
					</td>
					<td><? echo stripslashes($product['NAME']); ?></a>
					</td>
					<td class="center">$<? echo money_format('%2i',$product['RATE']); ?></td>
					<td class="center">$<? echo money_format('%2i',$product['PRETOTAL']); ?></td>
				</tr>

<?
	}
?>
			</table>
			<p class="totalrow" style="text-align: right;">Order Subtotal (USD): &nbsp;$<? echo money_format('%2i',$order['SUBTOTAL']); ?><br />
			<? if($order['DISCOUNT_PROMO'] != 0)
				echo '<br />Promo Discount: $-'.money_format('%2i',$order['DISCOUNT_PROMO']); ?>
			<? if($order['DISCOUNT_CUSTOMER'] != 0)
			{
				echo '<br />'.$customer_discount.'Preferred Customer Discount: $-'.money_format('%2i',$order['DISCOUNT_CUSTOMER']); } 
				if($order['SHIPPING'] > 0)
					echo '<br />Shipping: $'.money_format('%i',$order['SHIPPING']);
				if($order['TAX'] > 0)
					echo '<br />Sales Tax: $'.money_format('%i',$order['TAX']);
				echo '<br />Order Total: $'.$order['TOTAL'];
				?>
			</p>


		<?
		if($order['PROMO_CODE'] != "")
			echo '<p>Promo Code: '.stripslashes($order['PROMO_CODE']).' - '.stripslashes($order['PROMO_DESCRIPTION']).'</p>';
		
		?>
		<div style="clear: both;"></div>
		<?
		if($order['COMMENTS'] != "")
			echo '<p>'.stripslashes(nl2br($order['COMMENTS'])).'</p>';
		?>
		<?
		if($content['MOD_NAME'] == "admin/orders")
		{ 
			if(!$order['FULFILLED'])
			{
			
				if ($order['PERSON_ORDERING']!='')
				{
				echo '<p style="font-weight:bold;padding:10px;background:#EEE;border:1px solid #999;margin:5px 15px 5px 20px">This order was entered by: '.$order['PERSON_ORDERING'].'</p>';
				}			
				echo '<h3>Finalize Order</h3>';
				echo '<form action="/'.$content['MOD_NAME'].'/'.$qa[0].'" method="post" id="myform">';
				echo '<p>Shipping Cost<input type="text" name="SHIPPING" value="$'.$shipping.'" /></p>';
				echo '<p>Shipping Tracking Number<input type="text" name="SHIPPING_TRACKING" value="'.$shipping_tracking.'" /></p>';
				if($send_email)
					$checked = " checked";
				else
					$checked = "";
				echo '<p><input type="checkbox" name="SEND_EMAIL" value="1"'.$checked.' /> Send Email Notification</p>';
				if($order['TRANSACTIONID'] != "")
					echo '<p><input type="checkbox" name="BYPASSCC" value="1" /> Bypass credit card capture</p>';
				echo '<p><input type="submit" name="BUTTON" value="Finalize Order" />';
				echo '</form>';
			}
			else
			{
				if ($order['PERSON_ORDERING']!='')
				{
				echo '<p style="font-weight:bold;padding:10px;background:#EEE;border:1px solid #999;margin:5px 15px 5px 20px">This order was entered by: '.$order['PERSON_ORDERING'].'</p>';
				}
				
				echo '<p>This order has been finalized.</p>';
				if($order['SHIPPING_TRACKING'] != "")
					echo '<p>Tracking #: '.$order['SHIPPING_TRACKING'].'</p>';
			}
		} ?>
		<p><a href="javascript:window.print()">Print</a> | <a href="/<? echo $content['MOD_NAME']; ?>/<? echo $order['ID']; ?>/recreate">Load Order To Cart</a></p>
<?
}
else
{
	if($content['MOD_NAME'] == "admin/orders")
	{
?>
<form action="/admin/orders" method="post" id="myform">
<p>Search<br /><input type="text" name="SEARCH" value="<? echo stripslashes($search); ?>" style="display:inline;" /> <input type="checkbox" name="SEARCHALL" value="1"<? if($searchall){ echo ' checked'; } ?> /> Search All&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="BUTTON" value="Search" style="width: 100px;" /> <input type="button" name="BUTTON" value="Reset" onclick="javascript:window.location='/<? echo $content['MOD_NAME']; ?>/reset'" style="width: 100px;" /></p>
</form>
<?
	}
?>
<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:100%">
<tr>
	<th style="text-align: center; width: 60px;">Order #</th>
	<th style="width: 90px;">Date</th>
	<th>Customer Name</th>
	<th style="text-align: right; margin-right: 2px; width: 60px;">Amount</th>
	<th style="text-align: center; width: 60px;">Fulfilled</th>
</tr>
<?

	$current_result = $qa[1];
	if($current_result == "" or $current_result < 1)
		$current_result = 1;
		
	$filter = "";
		$filter = "";
	if($search != '')
	{
		$terms = explode(' ', mysqlClean($search));
		foreach ($terms as $term)
			if ($term != '')
				$filter .= " AND UPPER(CONCAT(FIRST,'|||',LAST,'|||',ORGANIZATION,'|||',SHIPPING_ORGANIZATION,'|||',CAST(ID as CHAR),'|||',CAST(TOTAL as CHAR))) LIKE UPPER('%$term%')";
	}
	
	
	// Added by Eric. Bug found where customer would only see unfulfilled orders.  Next line fixes this
	if($content['MOD_NAME'] == "myaccount/orders") {$searchall=true;}
	
	if(!$searchall)
		$filter .= " AND FULFILLED='0'";
	if($content['MOD_NAME'] == "myaccount/orders")
		$filter .= " AND ACCOUNTID='".$account['ID']."'";
	else if($content['MOD_NAME'] == "admin/customers/profile")
		$filter .= " AND ACCOUNTID='".$qa[0]."'";
		
	$limit = ($current_result-1)*DISPLAY_RESULTS.','.DISPLAY_RESULTS;
	if($content['MOD_NAME'] == "admin/customers/profile" OR $content['MOD_NAME'] == "myaccount/orders")
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM orders WHERE ID>0 $filter ORDER BY DATETIME DESC LIMIT $limit";
	else
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM orders WHERE ID>0 $filter ORDER BY DATETIME DESC LIMIT $limit";
	$results = mysql_query($query) or die(mysql_error());
	$countquery = "SELECT FOUND_ROWS() AS FOUND";
	$countresults = mysql_fetch_array(mysql_query($countquery));
	$totalcount = $countresults['FOUND'];
	$count2 = mysql_num_rows($results);
	while($row = mysql_fetch_array($results))
	{
		if($row['ORGANIZATION'] != "")
			$customer_name = $row['ORGANIZATION'];
		else
			$customer_name = $row['FIRST'].' '.$row['LAST'];
		
		if($content['MOD_NAME'] == "myaccount/orders")
			$url = "myaccount/orders/".$row['ID'];
		else if($content['MOD_NAME'] == "admin/customers/profile")
			$url = "admin/orders/".$row['ID'];
		else
			$url = $content['MOD_NAME']."/".$row['ID'];
?>
<tr>
	<td style="text-align: center;" class="leftcell"><a href="/<? echo $url; ?>"><? echo $row['ID']; ?></a></td>
	<td><? echo dateformat($row['DATETIME']); ?></td>
	<td><? echo $customer_name; ?></td>
	<td style="text-align: right; margin-right: 2px;">$<? echo $row['TOTAL']; ?></td>
	<td style="text-align: center;"><? if($row['FULFILLED']){ echo '&#10004;'; }else{ echo '&#215;'; } ?></td>
</tr>
<?
	}
?>
</table>
<?
	if($count2 == 0)
		echo '<p>No orders have been placed.</p>';
	else
		include("global/results-footer.php");
	?>
<div class="clr"></div>
<? } ?>