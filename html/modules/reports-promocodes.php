<?
include("modules/reports-daterange-body.php"); 

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="resultstable">
		<tr>
				<th>Promo Code</th>
				<th>Promo Name</th>
				<th style="width:70px;"><div align="center">Usage</div></th>
				<th style="width:80px;"><div align="right">Discounts</div></th>
		</tr>
		<?php
$count = 0;
$gtotal = 0;
$query = "SELECT PROMO_CODE, PROMO_DESCRIPTION, SUM(DISCOUNT_PROMO) as the_total, COUNT(ID) as USED2  FROM orders WHERE STATUSID!='3' AND PROMO_CODE != '' AND '$start'<=DATETIME AND DATETIME<='$end' GROUP BY PROMO_CODE ORDER BY USED2 DESC";
$result = mysql_query($query) or die (mysql_error());
while($row = mysql_fetch_array($result))
{
	$count++;
		
		$total = $row['the_total'];
		$usage = $row['USED2'];
?>
		<tr>
				<td class="leftcell"><? echo $row['PROMO_CODE']; ?></td>
				<td><? echo stripslashes($row['PROMO_DESCRIPTION']); ?></td>
				<td><div align="center"><?php echo number_format($usage); ?></div></td>
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