<form id="myform" method="post" action="/<? echo stripslashes($content['MOD_NAME']); ?>">
	<table id="mytable" class="cust">
		<?
		if(!accountIsRetail($account['ID']))
		{ 
		?>
		<tr>
			<td class="leftcell" style="font-weight:bold">Account Number</td>
			<td style="font-weight:bold"><? echo $account['ACCOUNT_NUMBER']; ?></td>
		</tr>	
		<?
		}
		?>
		<tr>
			<td class="leftcell">First Name</td>
			<td><input name="FIRST" type="text" value="<? echo stripslashes($first); ?>" /></td>
		</tr>
		<tr>
			<td class="leftcell">Last Name</td>
			<td><input name="LAST" type="text" value="<? echo stripslashes($last); ?>" /></td>
		</tr>
		<tr>
			<td class="leftcell">Company Name</td>
			<td><input name="ORGANIZATION" type="text" value="<? echo stripslashes($organization); ?>" /></td>
		</tr>				
		<tr>
			<td class="leftcell">Address</td>
			<td><input name="ADDRESS1" type="text" value="<? echo stripslashes($address1); ?>" /></td>
		</tr>				
		<tr>
			<td class="leftcell">Address 2</td>
			<td><input name="ADDRESS2" type="text" value="<? echo stripslashes($address2); ?>" /></td>
		</tr>		
		<tr>
			<td class="leftcell">City</td>
			<td><input name="CITY" type="text" value="<? echo stripslashes($city); ?>" /></td>
		</tr>		
		<tr>
			<td class="leftcell">State/Province</td>
			<td><? /* ?><input name="STATE" type="text" value="<? echo stripslashes($state); ?>" /><? */ ?>
			
				<select name="STATE" size="1" class="thestate">
				<option selected value="">-- Make a Selection --</option>			
				<?
				$query = "SELECT * FROM states ORDER BY COUNTRY desc, STATENAME";
				$result = mysql_query($query) or die (mysql_error());
				while($row = mysql_fetch_array($result))
				{
					if($state == $row['STATE'])
						$selected = " selected";
					else
						$selected = "";
					echo '<option value="'.$row['STATE'].'"'.$selected.'>'.stripslashes($row['STATENAME']).'</option>';
				}
				
				?>			
			</select></td>
		</tr>		
		<tr>
			<td class="leftcell">Zip/Postal Code</td>
			<td><input name="ZIP" type="text" style="width:90px" value="<? echo $zip; ?>" /></td>
		</tr>	
		<tr>
			<td class="leftcell">Country</td>
			<td>
				<select name="COUNTRY" size="1">		
				<option selected value="United States">United States</option>
				<?
				//Matt - I am forcing US to appear first so I inserted the line above and updated the query below
				$query = "SELECT * FROM countries where NAME <> 'United States' ORDER BY NAME";
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
		<tr>
			<td class="leftcell">Phone 1</td>
			<td><input name="PHONE1" type="text" value="<? echo stripslashes($phone1); ?>" /></td>
		</tr>
		<tr>
			<td class="leftcell">Phone 2</td>
			<td><input name="PHONE2" type="text" value="<? echo stripslashes($phone2); ?>" /></td>
		</tr>
		<tr>
			<td class="leftcell">Email Address</td>
			<td><input name="EMAIL" type="text" value="<? echo stripslashes($email); ?>" /></td>
		</tr>
		<tr>
			<td class="leftcell">Additional Emails</td>
			<td><input name="EMAIL2" type="text" value="<? echo stripslashes($email2); ?>" /></td>
		</tr>
		<tr>
			<td class="leftcell">FAX</td>
			<td><input name="FAX" type="text" value="<? echo stripslashes($fax); ?>" /></td>
		</tr>
		<tr>
			<td class="leftcell">URL</td>
			<td><input name="URL" type="text" value="<? echo stripslashes($url); ?>" /></td>
		</tr>
			<tr>
			<? 
			// DO NOT ALLOW EDITING OF NON-RETAIL ACCOUNT BY CUSTOMER. ADMIN MUST MAKE UPDATES TO CUSTOMER BILLING IF NOT RETAIL
			if(accountIsRetail($account['ID'])){ ?>
			<td>&nbsp;</td>
			<td>
			<input type="submit" name="BUTTON" value="Save" style="width: 100px;" />
			</td>
			<?
			}
			else
			{
				echo '<td colspan="2" class="leftcell"><strong>Your account type requires an ImagineCRAFTS customer service representative to make changes to your account information. For assistance, please <a href="/contact">contact us</a>.</strong></td>';
			}
			?> 
			
		</tr>																	
	</table>
</form>