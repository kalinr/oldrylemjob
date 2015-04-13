<? 
	//	echo "Account ID: ".$query_array[0]; 

		if (!accountIsRetail($query_array[0]))
			{
			$wholesaleaccount = true;
			$statelabel = "State/Province";
			$ziplabel = "Zip/Postal Code";			
			}
		else
			{	
			$wholesaleaccount = false;
			$statelabel = "State";			
			$ziplabel = "Zip Code";						
			}
			
?>

<form action="/<? echo $content['MOD_NAME']; ?>/<? echo $query_array[0]; ?>/<? echo $query_array[1]; ?>" method="post" id="myform">
<table id="mytable" class="cust">
<tr>
			<td colspan="2" style="font-weight:bold;color:#004669;font-size:1.2em;"><? if($query_array[1] == ''){ echo 'Create Shipping Address'; }else{ echo 'Edit Shipping Address'; } ?></td>
		</tr>
		<tr>
			<td class="leftcell" style="width:110px">Ship To Name</td>
			<td><input name="NAME" type="text" maxlength="50" value="<? echo stripslashes($name); ?>" /></td>
		</tr>
		<tr>
			<td class="leftcell">Address</td>
			<td><input name="ADDRESS1" maxlength="80" type="text" value="<? echo stripslashes($address1); ?>" /></td>
		</tr>				
		<tr>
			<td class="leftcell">Address 2</td>
			<td><input name="ADDRESS2" maxlength="80" type="text" value="<? echo stripslashes($address2); ?>" /></td>
		</tr>		
		<tr>
			<td class="leftcell">City</td>
			<td><input name="CITY" type="text" maxlength="50" value="<? echo stripslashes($city); ?>" /></td>
		</tr>		
		<tr>
			<td class="leftcell"><? echo $statelabel; ?></td>
			<td>
				<select name="STATE" size="1" class="thestate">
				<option selected value="">-- Make a Selection --</option>			
				<?
				$query = "SELECT * FROM states WHERE COUNTRY='United States' ORDER BY STATENAME";
				$result = mysql_query($query) or die (mysql_error());
				while($row = mysql_fetch_array($result))
				{
					if($state == $row['STATE'])
						$selected = " selected";
					else
						$selected = "";
					echo '<option value="'.$row['STATE'].'"'.$selected.'>'.stripslashes($row['STATENAME']).'</option>';
				}
				
				if ($wholesaleaccount)
				{
				$query = "SELECT * FROM statescanada ORDER BY STATENAME";
				$result = mysql_query($query) or die (mysql_error());
				while($row = mysql_fetch_array($result))
				{
					if($state == $row['STATE'])
						$selected = " selected";
					else
						$selected = "";
					echo '<option value="'.$row['STATE'].'"'.$selected.'>'.stripslashes($row['STATENAME']).'</option>';
				}
				}				
				
				?>			
			</select></td>
		</tr>		
		<tr>
			<td class="leftcell"><? echo $ziplabel; ?></td>
			<td><input name="ZIP" maxlength="10" type="text" style="width:90px" value="<? echo $zip; ?>" /></td>
		</tr>	
		<tr>
			<td class="leftcell">Country</td>
			<td>
				<select name="COUNTRY" size="1">		
				<?
				if ($wholesaleaccount)
					$query = "SELECT * FROM countries WHERE NAME='United States' or NAME='Canada' ORDER BY NAME desc";
				else
					$query = "SELECT * FROM countries WHERE NAME='United States' ORDER BY NAME";

				$result = mysql_query($query) or die ("error1" . mysql_error());
				while($row = mysql_fetch_array($result))
				{
					if($country == $row['NAME'])
						$selected = " selected";
					else
						$selected = "";
					echo '<option value="'.$row['NAME'].'"'.$selected.'>'.stripslashes($row['NAME']).'</option>';
				}
				?>
			</select></td>
		</tr>
		<? //echo accountIsRetail($_SESSION['USERID']); ?>
		<?
		//if (!accountIsRetail($_SESSION['USERID']))
		if ($wholesaleaccount)
		{
		?>
		<tr>
			<td class="leftcell" style="vertical-align:top">Instructions</td>
			<td><textarea name="INSTRUCTIONS" style="vertical-align:top"><? echo stripslashes($instructions); ?></textarea></td>
		</tr>
		<?
		}
		?>
		
		
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="BUTTON" value="<? if($content['ID'] == 77){ ?>Continue<? }else{ ?>Save<? } ?>" style="width: 90px;" /><? if($query_array[1] != ""){ ?> <input type="button" NAME="BUTTON" onclick="javascript:confirmDelete()" value="Delete" style="width: 90px;" /><? } ?></td>
		</tr>
		</table>

</form>
<? if($content['ID'] != 77){ ?>
<p>
<a href="/<? echo str_replace("/shipping","",$content['MOD_NAME']); ?>/<? echo $query_array[0]; ?>">Back To Profile</a></p>
<? } ?>