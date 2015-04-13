<?
include("modules/reports-daterange-body.php"); 

?>

<h3>Top 25 Customers Based On Total Dollars</h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="resultstable">
		<tr>
				<th>Customer</th>
				<th style="width:70px;"><div align="center">Invoices</div></th>
				<th style="width:80px;"><div align="right">Total</div></th>
		</tr>
		<?php
$count = 0;
$gtotal = 0;
$query = "SELECT ACCOUNTID, SUM(TOTAL) as the_total, COUNT(ID) as theCount FROM orders WHERE STATUSID!='3' AND '$start'<=DATETIME AND DATETIME<='$end' GROUP BY ACCOUNTID ORDER BY the_total DESC LIMIT 25";
$result = mysql_query($query) or die (mysql_error());
while($row = mysql_fetch_array($result))
{
	$count++;
		
		$contactid = $row['CONTACTID'];
		$total = $row['the_total'];
		$invoice_count = $row['theCount'];
?>
		<tr>
				<td class="leftcell"><? echo accountFirstLastName($row['ACCOUNTID']); ?></td>
				<td><div align="center"><?php echo number_format($invoice_count); ?></div></td>
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
<h3>Top 25 Customers Based on Frequency of Invoices</h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="resultstable">
		<tr>
				<th class="leftcell">Customer</th>
				<th style="width:70px;"><div align="center">Invoices</div></th>
				<th style="width:80px;"><div align="right">Total</div></th>
		</tr>
		<?php
$count = 0;
$gtotal = 0;
$query = "SELECT ACCOUNTID, SUM(TOTAL) as the_total, COUNT(ID) as theCount FROM orders WHERE STATUSID!='3' AND DATETIME BETWEEN '$start' AND '$end' GROUP BY ACCOUNTID ORDER BY theCount DESC LIMIT 25";
$result = mysql_query($query) or die (mysql_error());
while($row = mysql_fetch_array($result))
{
	$count++;
		
		$contactid = $row['CONTACTID'];
		$total = $row['the_total'];
		$invoice_count = $row['theCount'];
?>
		<tr>
				<td class="leftcell"><? echo accountFirstLastName($row['ACCOUNTID']); ?></td>
				<td align="center"><?php echo number_format($invoice_count); ?></td>
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
<DIV class="clr"></DIV>