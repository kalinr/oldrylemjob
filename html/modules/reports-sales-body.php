<? 
include("modules/reports-daterange-body.php");

	
?>
		<p style="background:#ddd;font-weight:bold;padding:6px;">Days included in report: <?php echo $days; ?></p>
		<p><strong>Completed Transactions Sales:</strong></p>
		<table id="salesreporttable">
				<tr>
						<td>Subtotal:</td>
						<td>$
										<?php $subtotal = number_format(totalSales($start,$end,"subtotal"),2); echo $subtotal; ?></td>
				</tr>
				<tr>
						<td>Sales Tax: </td>
						<td>$
										<?php $tax = number_format(totalSales($start,$end,"tax"),2); echo $tax; ?></td>
				</tr>
				<tr>
						<td>Shipping:</td>
						<td>$
										<?php $shipping = number_format(totalSales($start,$end,"shipping"),2); echo $shipping; ?></td>
						
				</tr>
				<tr>
						<td>Total:</td>
						<td>$
										<?php $total = number_format(totalSales($start,$end,"total"),2); echo $total; ?></td>
						<?php $total00 = totalSales($start,$end,"total"); ?>
				</tr>
		</table>
		
<?php
	//if($totalcount > 0)
	{
?>
		<p style="font-weight:bold;color:#455705"><br />Breakdown by Service (completed transactions):</p>
		<table id="salesreporttable" style="background:#eee;">
				<tr>
						<td style="font-weight:bold">Service/Product</td>
						<td style="width:80px;font-weight:bold"><div align="right">Total</div></td>
						<td style="width:80px;font-weight:bold"><div align="center">Count</div></td>
						<td style="width:95px;font-weight:bold"><div align="center">Last Occurrence</div></td>
				</tr>
<?php
	$count = 0;
	$gtotal = 0;
	$goccurance = 0;
	$query = "SELECT orders_details.NAME FROM orders, orders_details WHERE STATUSID!='3' AND '$start' <= orders.DATETIME AND orders.DATETIME <= '$end' AND orders.ID=orders_details.ORDERID GROUP BY orders_details.NAME ORDER BY orders_details.NAME";
	//ECHO $query;
	$result = mysql_query($query) or die (mysql_error());
	while($row = mysql_fetch_array($result))
	{
		$name = addslashes($row['NAME']);
		//echo $query;
		//if(strtolower($name) != strtolower($previous))
		{
			$previous = $name;
			$totalq = totalServiceSales($start,$end,$name);
			$occurance = totalServiceOccurance($start,$end,$name);
			$goccurance += $occurance;
			$gtotal += $totalq;
			$lastorder = dateformat(serviceLastDate($start,$end,$name));
			$totalq = number_format($totalq,2);
			//if($totalq != 0 OR $occurance != 0)
			{
				$count++;
?>
				<tr>
						<td><?php echo stripslashes($name); ?></td>
						<td align="right">$<?php echo $totalq; ?></td>
						<td><div align="center"><?php echo $occurance; ?></div></td>
						<td><div align="center"><?php echo $lastorder; ?></div></td>
				</tr>
				<?php
			}
		}
	}
	$count = number_format($count);
	$goccurance = number_format($goccurance);
?>
				<tr>
						<td style="padding:10px 0;color:#455705;background:#ddd;"><em><strong>&nbsp;&nbsp;<?php echo $count; ?> services or product<?php if($count != 1){ echo "s"; } ?></strong></em></td>
						<td style="padding:10px 0;background:#ddd;" align="right"><em><strong>$<?php echo number_format($gtotal,2); ?></strong></em></td>
						<td style="padding:10px 0;background:#ddd;"><div align="center"><em><strong><?php echo $goccurance; ?></strong></em></div></td>
						<td style="padding:10px 0;background:#ddd;">&nbsp;</td>
				</tr>
		</table>
		<!-- <p><br />Above amounts do not include sales tax. </p> -->
<?php
}

?>
		<p><b>Note:</b>&nbsp; Does not include sales tax or shipping costs.</p>
<?php
if(merchantHasShippingTax($start,$end))
{
	$total_tax = 0;
?>
		<p><strong>Sales Tax Breakdown by City (shipped orders):</strong><br /><em>Washington State requires that you charge sales tax based on the point of destination, not the point of origin for deliveries. This means you charge the sales tax rate of your customers zip code. This is apart of the tax calculation above.</em><BR />
<?php
	$query = "SELECT CITY, STATE, TAX_CODE FROM orders WHERE STATUSID!='3' AND '$start'<=DATETIME AND DATETIME<='$end' AND STATE='WA' AND TAX!='0.00' GROUP BY TAX_CODE";
	//echo $query;
	$result = mysql_query($query) or die (mysql_error());
	while($row = mysql_fetch_array($result))
	{
		$shipping_city = $row['CITY'];
		$shipping_state = $row['STATE'];
		$tax_code = $row['TAX_CODE'];
		if($tax_code != $previous_tax_code)
		{
			$previous_tax_code = $row['TAX_CODE'];
			$count = 0;
			$tax = 0;
			$query2 = "SELECT TAX FROM orders WHERE STATUSID!='3' AND '$start'<=DATETIME AND DATETIME<='$end' AND TAX_CODE='$tax_code'";
			$result2 = mysql_query($query2) or die (mysql_error());
			while($row2 = mysql_fetch_array($result2))
			{
				$count++;
				$tax += $row2['TAX'];
				$total_tax = $row2['TAX'];
			}
			echo "<br />&nbsp;&nbsp;&nbsp;&bull;&nbsp;$shipping_city, $shipping_state (TAX CODE: ".$tax_code.") (".number_format($count).") - $".money_format('%i',$tax);
		}
?>
		
<?php
	}
?>
	</p>
     
          <?php
}
?>
<p><a href="javascript:window.print()">Print</a></p>