<?
if($qa[1] == "confirmation")
{
	?>
	<p>Thank you! You have been added to the mailing list.</p>
	<p><a href="/">Return to homepage</a></p>
	<?
}
else
{
?>
	<p style="font-size:1.2em">Please use the form below to receive the IMAGINE Crafts educational and informational emails.</p>
		<form id="eform" method="post" action="/<? echo $content['MOD_NAME']; ?>">
		First Name: <input type="text" onfocus="this.select()" name="FIRST" value="<? echo stripslashes($first); ?>" />
		Last Name: <input type="text" onfocus="this.select()" name="LAST" value="<? echo stripslashes($last); ?>" />
		Email: <input type="text" onfocus="this.select()" name="EMAIL" value="<? echo stripslashes($email); ?>" />
		Zip/Postal Code: <input type="text" onfocus="this.select()" name="ZIP" value="<? echo $zip; ?>" />
		State/Province: <input type="text" onfocus="this.select()" name="STATE" value="<? echo stripslashes($state); ?>" />
		Country:<br /><select name="COUNTRY" size="1">		
				<?
				$query = "SELECT * FROM countries ORDER BY NAME";
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
			</select>
		
		<br />
		Use: 
		<input type="radio" value="Paper Arts" name="USAGE"<? if($usage == "Paper Arts"){ echo ' checked'; } ?> /> Paper Arts
		<input type="radio" value="Fabric Arts" name="USAGE" style="margin-left:20px;"<? if($usage == "Fabric Arts"){ echo ' checked'; } ?> /> Fabric Arts<br /><br />		
		Customer Type: <input type="radio" value="Retail" name="CUSTOMER_TYPE" onclick="checkbiz(this)"<? if($customer_type == "Retail"){ echo ' checked'; } ?> /> Consumer
		<input type="radio" value="Wholesale" name="CUSTOMER_TYPE" style="margin-left:20px;" onclick="checkbiz(this)"<? if($customer_type == "Wholesale"){ echo ' checked'; } ?> /> Wholesale
		<div id="businessname">
		Business Name:<input type="text" onfocus="this.select()" name="ORGANIZATION" value="<? echo stripslashes($organization); ?>" />
		</div>
		<input type="submit" name="BUTTON" value="Sign Me Up!" style="width:170px" />
		</form>
		
<?
}
?>