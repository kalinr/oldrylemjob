<?
include("modules/reports-daterange-body.php"); 

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="resultstable">
		<tr>
				<th>SKU</th>
				<th>Product Name</th>
				<th style="width:70px;"><div align="center">Units</div></th>
				<th style="width:80px;"><div align="right">Sales</div></th>
		</tr>
		<?php
$count = 0;
$gtotal = 0;
$query = "SELECT orders_details.PRODUCTID, orders_details.NAME, orders_details.SKU, SUM(orders_details.LINE_TOTAL) as the_total, SUM(orders_details.QUANTITY) as UNITS FROM orders, orders_details WHERE orders_details.ORDERID=orders.ID AND orders.STATUSID!='3' AND DATETIME>='$start' AND DATETIME<='$end' GROUP BY orders_details.PRODUCTID ORDER BY UNITS DESC, LINE_TOTAL DESC";
$result = mysql_query($query) or die (mysql_error());
while($row = mysql_fetch_array($result))
{
	$count++;
		
		$contactid = $row['CONTACTID'];
		$total = $row['the_total'];
		$units = $row['UNITS'];
?>
		<tr>
				<td class="leftcell"><a href="/admin/products/edit/<? echo $row['PRODUCTID']; ?>"><? echo $row['SKU']; ?></a></td>
				<td><? echo stripslashes($row['NAME']); ?> <? echo getColor($row['PRODUCTID']); ?></td>
				<td><div align="center"><?php echo number_format($units); ?></div></td>
				<td align="right">$<?php echo number_format($total,2); ?></td>
		</tr>
		<?php
}
if($count == 0)
{
?>
<tr>
				<td class="noResultsTable" colspan="3"><span class="greytext">No Results Within Specified Date Range</span></td>
				
		</tr>
<?php
}
?>
</table>

<p><a href="javascript:window.print()">Print</a></p>
<div class="clr"></div>