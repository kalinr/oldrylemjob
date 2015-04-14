<?
if($content['ID'] == 147)
	$query_array[1] = $_SESSION['USERID'];
	
if($query_array[0] != "edit")
{
	echo '<div id="leftprofile">';

	echo '<p style="margin-top:0"><strong>Account Number: '.stripslashes($account_number);
	echo '<br />Search ID: '.stripslashes($search_id).'</strong>';

	echo '<br />'.stripslashes($first).' '.stripslashes($last);
	if($organization != "")
		echo '<br />'.stripslashes($organization);
	echo '<br />'.stripslashes($address1);
	echo '<br />'.stripslashes($address2);
	echo '<br />'.stripslashes($city).', '.stripslashes($state).' '.$zip;
	echo '<br />'.stripslashes($country);
	if($phone1 != "")
		echo '<br />Phone 1: '.stripslashes($phone1);
	if($phone2 != "")
		echo '<br />Phone 2: '.stripslashes($phone2);
	if($fax != "")
		echo '<br />Fax: '.$fax;
	echo '</p>';


	echo '</div>';

	echo '<div id="rightprofile">';

	echo '<p style="font-size:1.1em;padding:0;margin-top:0;margin-bottom:0"><strong>Account Type: '.accountTypeName($typeid).'</strong></p>';	

	echo '<br />Email: <a href="mailto:'.$email.'">'.$email.'</a>';
	if($url != "")
		echo '<br />Website: <a target="_blank" href="http://'.cleanURL($url).'">'.$url.'</a>';

	if($discount != 0)
		echo '<br />Discount: '.number_format($discount,2).'%';
	if($terms_id > 0)
		echo '<br />Terms: '.termsName($terms_id);
	if($salesrep_id > 0)
		echo '<br />Sales Rep: '.accountFirstLastName($salesrep_id);
	if($tax)
		echo '<br />Sales Tax: YES';
	else
		echo '<br />Sales Tax: NO';
	if($bypass_initial_minimum)
		echo '<br />Bypass Initial Minimum: YES';
	else
		echo '<br />Bypass Initial Minimum: NO';
	echo '</p>';

	
	echo '</div>';
		
	if($notes != "")
		{
		echo '<p style="clear:both;"><strong>Account Notes: </strong>'.stripslashes(nl2br($notes)).'</p>';
		}
	echo '<p style="clear:both;margin-top:20px"><a href="/'.$content['MOD_NAME'].'/edit/'.$query_array[0].'"><img src="/images/btn_editprofile.png" border="0" alt="Edit Profile" /></a></p>';
	echo '<h3 style="padding-top:12px;border-top:1px dotted #555;">Shipping Addresses (click to edit existing)</h3>';
	$count = 0;
	$query = "SELECT * FROM accounts_shipping WHERE ACCOUNTID='".$query_array[0]."'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	
	while($address = mysql_fetch_array($result))
	{
		if($content['ID'] == 10)
			echo '<a style="color:#333;" href="/customer-entry/profile/shipping/'.$address['ACCOUNTID'].'/'.$address['ID'].'">';

		else
			echo '<a style="color:#333;" href="/admin/customers/profile/shipping/'.$address['ACCOUNTID'].'/'.$address['ID'].'">';
	?>
		<div 
		onmouseover="this.style.background='#00ADEF';this.style.color='#fff'"
		onmouseout="this.style.background='#C4E5F3';this.style.color='#333'"		
		style="float:left;width:230px;background:#C4E5F3;margin-left:15px;margin-bottom:15px;min-height:105px;" id="sbox">
	<?	
		echo '<p>'.stripslashes($address['NAME']).'<br />'.stripslashes($address['ADDRESS1']);
		if($address['ADDRESS2'] != '')
			echo '<br />'.stripslashes($address['ADDRESS2']);
		echo '<br />'.stripslashes($address['CITY']).', '.$address['STATE'].' &nbsp;'.$address['ZIP'].'</p>';
		if($address['INSTRUCTIONS'] != '')
			{
			//echo '<p>'.stripslashes($address['INSTRUCTIONS']).'</p>';
			}
		// echo '<p><a href="/admin/customers/profile/shipping/'.$address['ACCOUNTID'].'/'.$address['ID'].'">Edit</a></p>';
		echo '</div></a>';
		$count++;
	}
	if($content['ID'] == 10)
		echo '<p style="clear:both"><a href="/customer-entry/profile/shipping/'.$query_array[0].'"><img src="/images/btn_addshippingaddress.png" border="0" alt="Shipping Address" /></a></p>';
	else
		echo '<p style="clear:both"><a href="/admin/customers/profile/shipping/'.$query_array[0].'"><img src="/images/btn_addshippingaddress.png" border="0" alt="Shipping Address" /></a></p>';
	if($content['MOD_NAME'] != "customer-entry/profile")
	{
		echo '<h3 style="padding-top:12px;border-top:1px dotted #555;">Past Orders</h3>';
		include("modules/admin-orders-body.php");
	}
}
else
{
?>
<p>Please complete the following form and click 'Submit'.</p>
<p>To our wholesale customers: wholesale prices and shipping information will be displayed after your Website account has been converted to wholesale. Please contact us at 425-883-7733 or email
<a href="mailto:sales@imaginecrafts.com">sales@imaginecrafts.com</a> for wholesale account conversion. Wholesale orders will not display properly prior to account conversion.</p>
<form id="myform" method="post" action="/<? echo stripslashes($content['MOD_NAME']); ?>/<? echo $qa[0]; ?>/<? echo $qa[1]; ?>">
	<table id="mytable" class="cust" style="width: 700px">
	<? if($content['ID'] != 10){ ?>
			<tr>
			<td colspan="2" style="font-weight:bold;color:#004669;font-size:1.2em;"><? if($account['ID'] == ''){ echo 'Create Customer'; }else{ echo 'Edit Customer'; } ?></td>
		</tr>
		<? } ?>
		<? if($content['ID'] != 10){ ?>
		<tr>
			<td class="leftcell">Account Type</td>
			<td>
				<select name="TYPEID" size="1">
				<option selected value="">-- Make a Selection --</option>			
				<?
				$query = "SELECT * FROM accounts_types ORDER BY ID";
				$result = mysql_query($query) or die ("error1" . mysql_error());
				while($row = mysql_fetch_array($result))
				{
					if($typeid == $row['ID'])
						$selected = " selected";
					else
						$selected = "";
					echo '<option value="'.$row['ID'].'"'.$selected.'>'.stripslashes($row['NAME']).'</option>';
				}
				?>
			</select>
			</td>
		</tr>
		<tr>
			<td class="leftcell" style="width:110px">B/W Acct No.</td>
			<td><input name="ACCOUNT_NUMBER" type="text" value="<? echo stripslashes($account_number); ?>" /></td>
		</tr>
		<tr>
			<td class="leftcell">Search ID</td>
			<td><input name="SEARCH_ID" type="text" value="<? echo stripslashes($search_id); ?>" /></td>
		</tr>
		<? } ?>
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
				<option style="color:#777777;" value="NA">Non-US / Non-Canada</option>		
				
				<option style="background:yellow;font-weight:bold" value="">-- United States --</option>	
		
				<?
				// UNITED STATES
				$query = "SELECT * FROM states where country = 'United States' ORDER BY STATENAME";
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
				
				<option style="background:yellow;font-weight:bold" value="">-- Canada --</option>					
				
				<?
				// CANADA
				$query = "SELECT * FROM states where country = 'Canada' ORDER BY STATENAME";
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
				
	
			</select>
			
			</td>
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
		<tr valign="top">
			<td class="leftcell">Mailing Lists</td>
			<td>
			  <label><input name="craft_project_ideas" type="checkbox" checked="checked" value="1" /> Receive wonderful craft project ideas through our blog</label><br />
			  <label><input name="product_announcements" type="checkbox" checked="checked" value="1" /> Receive important new product announcements and information</label>
			</td>
		</tr>
		<? if($content['ID'] != 10){ ?>		
		<tr>
			<td class="leftcell">Discount</td>
			<td><input name="DISCOUNT" type="text" style="width:70px;display:inline" value="<? echo number_format($discount,2); ?>%" /></td>
		</tr>
		<tr>
			<td class="leftcell">Terms</td>
			<td>
				<select name="TERMS_ID" size="1">
				<option selected value="0">-- Make a Selection --</option>					
				<?
				$query = "SELECT * FROM accounts_terms ORDER BY ID";
				$result = mysql_query($query) or die ("error1" . mysql_error());
				while($row = mysql_fetch_array($result))
				{
					if($terms_id == $row['ID'])
						$selected = " selected";
					else
						$selected = "";
					echo '<option value="'.$row['ID'].'"'.$selected.'>'.stripslashes($row['NAME']).'</option>';
				}
				?>											
			</select></td>
		</tr>	
		<tr>
			<td class="leftcell">Sales Rep</td>
			<td>
			<select name="SALESREP_ID" size="1">
			<option value="0">-- No Sales Rep --</option>
			<?
				$query = "SELECT * FROM accounts WHERE TYPEID='7' ORDER BY LAST, FIRST";
				$result = mysql_query($query) or die ("error1" . mysql_error());
				while($row = mysql_fetch_array($result))
				{
					if($salesrep_id == $row['ID'])
						$selected = " selected";
					else
						$selected = "";
					echo '<option value="'.$row['ID'].'"'.$selected.'>'.stripslashes($row['LAST']).', '.stripslashes($row['FIRST']).'</option>';
				}
				?></select>
			</td>
		</tr>
		<tr>
			<td class="leftcell">Notes</td>
			<td><textarea name="NOTES"><? echo stripslashes($notes); ?></textarea></td>
		</tr>
			<? } ?>
	<? if($content['MOD_NAME'] != "customer-entry/profile"){ ?>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="TAX" value="1"<? if($tax){ echo ' checked'; } ?> /> Charge Sales Tax</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="BYPASS_INITIAL_MINIMUM" value="1"<? if($bypass_initial_minimum){ echo ' checked'; } ?> /> Bypass Initial Minimum</td>
		</tr>
		<? } ?>
		<tr>
			<td class="leftcell">&nbsp;</td>
			<td>
			<? if($qa[0] == 79){ ?>
			<input type="submit" name="BUTTON" value="Continue" />
			<? }else if($query_array[1] == ""){ ?>
			<input type="submit" name="BUTTON" style="width:250px;" value="Save and Add Shipping Address >>" />
			<? }else{ ?>
			<input type="submit" name="BUTTON" value="Save" />
			<? } ?>
			</td>
		</tr>																	
	</table>
</form>
<?
}
?>