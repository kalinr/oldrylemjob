<? if($qa[0] == "edit"){ ?>
<form action="/<? echo $content['MOD_NAME']; ?>/edit/<? echo $qa[1]; ?>" method="post" id="myform" style="margin-left: 15px;">
<div class="longfieldFull" style="margin-bottom:14px;">Name<br /><input type="text" name="NAME" value="<? echo stripslashes($name); ?>" /></div>
<div class="leftFieldHalf" style="margin-bottom:14px;">Code<br /><input type="text" name="CODE" value="<? echo stripslashes($code); ?>" /></div>
<div class="clr">&nbsp;</div>
<div style="float: left; width: 120px;margin-bottom:14px">Expiration<br /><select name="MONTH" style="width: 110px;">
<option value="00">--Month--</option>
<?
	$query = "SELECT * FROM months ORDER BY ID";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	while($row = mysql_fetch_array($result))
	{
		if($month == changeTwoNum($row['ID']))
			$selected = " selected";
		else
			$selected = "";
		echo '<option value="'.changeTwoNum($row['ID']).'"'.$selected.'>'.stripslashes($row['FULLNAME']).'</option>';		
	}
?>
</select>
</div>
<div style="float: left; width: 120px;"><br /><select name="DAY" style="width: 110px;">
<option value="00">--Day--</option>
<?
	$count = 1;
	while($count <= 31)
	{
		if(changeTwoNum($count) == $day)
			$selected = " selected";
		else
			$selected = "";
		echo '<option value="'.changeTwoNum($count).'"'.$selected.'>'.$count.'</option>';
		$count++;
	}
?>
</select>
</div>
<div style="float: left; width: 120px;"><br /><select name="YEAR" style="width: 110px;">
<option value="0000">--Year--</option>
<?
	$yearopened = 2012;
	$count = date("Y") + 7;
	while($count >= $yearopened)
	{
		if($count == $year)
			$selected = " selected";
		else
			$selected = "";
		echo '<option value="'.$count.'"'.$selected.'>'.$count.'</option>';
		$count--;
	}
?>
</select>
</div>
<div class="clr"></div>
<div style="width: 120px; float: left;">Flat Rate Discount<br /><input type="text" name="FLATRATE" value="$<? echo number_format($flatrate,2); ?>" style="width: 90px;" /></div>
<div style="float: left; width: 70px; text-align: center;"><br /><strong>OR</strong> </div>
<div style="width: 120px; float: left;">Percentage<br /><input type="text" name="PERCENTAGE" value="<? echo number_format($percentage,2); ?>%" style="width: 90px;" /></div>
<div class="clr"></div>
<? /* ?>
<div><input type="checkbox" name="RECURRING"  value="1"<? if($recurring){ echo ' checked'; } ?> /> Recurring (allow your customer to use the promo code again on a future order or renewal)</div>
<? */ ?>
<div class="space15"></div>

<div class="submitspace" style="margin-top:20px"><input type="submit" name="BUTTON" style="width:150px" value="Save" /><? if($qa[1] != ""){ ?> <input type="button" name="BUTTON" value="Delete" style="width:150px" onclick="javascript:confirmDelete()" /><? } ?></div>
</form>
<? }else{ ?>
<?
$search = mysqlClean(addslashes(stripslashes($_POST['SEARCH'])));
$current_result = $_GET['current_result'];
if($current_result == "" or $current_result < 1)
	$current_result = 1;
?>
<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:98%">
<tr>
	<th class="leftcell">Name</th>
	<th style="width: 100px;">Code</th>
	<th style="width: 90px; text-align: center;">Expiration</th>
	<th style="width: 90px; text-align: center;">Discount</th>
</tr>
<?
$count = 0;
$terms = explode(' ', $search);
$filter = "";
foreach ($terms as $term)
	if ($term != '')
		$filter .= " AND CONCAT('|||',NAME) LIKE '%$term%'";

$limit = ($current_result-1)*DISPLAY_RESULTS.','.DISPLAY_RESULTS;
$query = "SELECT SQL_CALC_FOUND_ROWS * FROM promocodes WHERE ID>0$filter ORDER BY NAME";// LIMIT $limit";
$results = mysql_query($query) or die(mysql_error());
$countquery = "SELECT FOUND_ROWS() AS FOUND";
$countresults = mysql_fetch_array(mysql_query($countquery));
$totalcount = $countresults['FOUND'];
$count2 = mysql_num_rows($results);
while($row = unCleanArray(mysql_fetch_array($results)))
{
	$count++;
	
	if($row['FLATRATE'] == 0)
	{
		$discount = $row['PERCENTAGE'] * 100;
		$discount .="%";
	}
	else
		$discount = '$'.$row['FLATRATE'];

?>
	<tr>
		<td class="leftcell"><a href="/<? echo $content['MOD_NAME']; ?>/edit/<? echo $row['ID']; ?>" title="Edit Promocode"><? echo stripslashes($row['NAME']); ?></a></td>
		<td><? echo stripslashes($row['CODE']); ?></td>
		<td class="<? echo $bgcolor; ?>"  align="center"><? echo dateformat($row['EXPIRATION']); ?></td>
		<td align="center"><? echo $discount; ?></td>
	</tr>
<?
}
if($count == 0){ ?>
	<tr><td class="leftcell" colspan="4">No promo codes found.</td></tr>
<? }else if(1==2){ ?>
	<tr>
		<td colspan="4" class="leftcell"><? //include("../global/table-footer.php"); ?></td>
	</tr>
<? }?>
</table>
<p><a href="/admin/promo-codes/edit">Create Promo Code</a></p>
<? } ?>