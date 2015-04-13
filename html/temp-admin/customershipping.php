<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>New Page 1</title>
<link rel="stylesheet" type="text/css" href="../css/forms.css" />
<link rel="stylesheet" type="text/css" href="../css/styles.css" />
<link rel="stylesheet" type="text/css" href="../css/tables.css" />
</head>

<style>
#customerinfo {
	width:550px;
	margin-left:10px;
	margin:0 auto 0 auto;
}
</style>
<body>

<div id="customerinfo">
	<form id="myform">
		<table id="mytable" class="cust">
			<tr>
				<td colspan="2" style="font-weight:bold;color:#004669;font-size:1.2em;">
				Shipping Information</td>
			</tr>
			<tr>
				<td colspan="2">
				<div id="errordiv">
					Please enter a zip code.</div>
				</td>
			</tr>
			<tr>
				<td class="leftcell" style="width:110px">Address</td>
				<td><input name="SHIPPINGADDRESS1" type="text" /></td>
			</tr>
			<tr>
				<td class="leftcell">Address 2</td>
				<td><input name="SHIPPINGADDRESS2" type="text" /></td>
			</tr>
			<tr>
				<td class="leftcell">City</td>
				<td><input name="SHIPPINGCITY" type="text" /></td>
			</tr>
			<tr>
				<td class="leftcell">State</td>
				<td><select name="SHIPPINGSTATE" size="1" class="thestate">
				<option selected value="0">-- Make a Selection --</option>
				<option value="AL">Alabama</option>
				<option value="AK">Alaska</option>
				</select></td>
			</tr>
			<tr>
				<td class="leftcell">Zip Code</td>
				<td>
				<input name="SHIPPINGZIPCODE" type="text" style="width:90px" /></td>
			</tr>
			<tr>
				<td class="leftcell">Country</td>
				<td><select name="SHIPPINGCOUNTRY" size="1">
				<option selected value="0">-- Make a Selection --</option>
				<option value="US">United States</option>
				<option value="CA">Canada</option>
				</select></td>
			</tr>
			<tr>
				<td class="leftcell" style="vertical-align:top">Special Instructions</td>
				<td>
				<textarea rows="2" name="SPECIALINSTRUCTIONS" style="vertical-align:top"></textarea></td>
			</tr>
			<tr>
				<td class="leftcell">Tax</td>
				<td><input type="radio" value="0" name="TAX" checked /> No&nbsp;
				<input type="radio" value="1" name="TAX" /> Yes&nbsp; </td>
			</tr>
			<tr>
				<td class="leftcell">Email</td>
				<td><input name="EMAIL" type="text" /></td>
			</tr>
			<tr>
				<td class="leftcell">Phone 1</td>
				<td><input name="PHONE" type="text" size="1" /></td>
			</tr>
			<tr>
				<td class="leftcell">Phone 2</td>
				<td><input name="PHONE0" type="text" size="1" /></td>
			</tr>
			<tr>
				<td class="leftcell">Fax</td>
				<td><input name="FAX" type="text" size="1" /></td>
			</tr>
			<tr>
				<td class="leftcell">URL</td>
				<td><input name="URL" type="text" size="1" /></td>
			</tr>
			<tr>
				<td class="leftcell" style="vertical-align:top">Account Notes</td>
				<td>
				<textarea rows="2" name="SPECIALINSTRUCTIONS" style="vertical-align:top;width:300px;"></textarea></td>
			</tr>
			<tr>
				<td class="leftcell">&nbsp;</td>
				<td><input type="submit" name="submit" value="Save" />
				<input type="submit" name="submit" value="Add Another Shipping Address &gt;&gt;" />
				</td>
			</tr>
		</table>
	</form>
</div>

</body>

</html>
