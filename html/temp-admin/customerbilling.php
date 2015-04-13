<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>New Page 1</title>
<link rel="stylesheet" type="text/css" href="../css/forms.css">
<link rel="stylesheet" type="text/css" href="../css/styles.css">
<link rel="stylesheet" type="text/css" href="../css/tables.css">
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
<form id="myform" method="post" action="customershipping.php">
	<table id="mytable" class="cust">
		<tr>
			<td colspan="2">
			<div id="errordiv">Please enter an account number.</div>
			</td>
		</tr>		
		<tr>
			<td colspan="2" style="font-weight:bold;color:#004669;font-size:1.2em;">Customer Information</td>
		</tr>		
		<tr>
			<td class="leftcell" style="width:110px">Account No.</td>
			<td><input name="ACCTNUM" type="text" /></td>
		</tr>
		<tr>
			<td class="leftcell">Customer Name</td>
			<td><input name="CUSTNAME" type="text" /></td>
		</tr>	
		<tr>
			<td class="leftcell">Search ID</td>
			<td><input name="SEARCHID" type="text" /></td>
		</tr>	
				
		<tr>
			<td class="leftcell">Account Type</td>
			<td>
				<select name="ACCTTYPE" size="1">
				<option selected value="0">-- Make a Selection --</option>			
				<option value="1">Retail</option>
				<option value="2">Wholesale</option>
				<option value="3">Professional Crafter</option>
				<option value="4">Distributor</option>
			</select>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="font-weight:bold;color:#004669;font-size:1.2em;padding-top:25px">Billing Information</td>
		</tr>		
		<tr>
			<td class="leftcell">Address</td>
			<td><input name="BILLINGADDRESS1" type="text" /></td>
		</tr>				
		<tr>
			<td class="leftcell">Address 2</td>
			<td><input name="BILLINGADDRESS2" type="text" /></td>
		</tr>		
		<tr>
			<td class="leftcell">City</td>
			<td><input name="BILLINGCITY" type="text" /></td>
		</tr>		
		<tr>
			<td class="leftcell">State</td>
			<td>
				<!-- MATT:  Please populate full table -->
				<select name="BILLINGSTATE" size="1" class="thestate">
				<option selected value="0">-- Make a Selection --</option>			
				<option value="AL">Alabama</option>
				<option value="AK">Alaska</option>				
			</select></td>
		</tr>		
		<tr>
			<td class="leftcell">Zip Code</td>
			<td><input name="BILLINGZIPCODE" type="text" style="width:90px" /></td>
		</tr>	
		<tr>
			<td class="leftcell">Country</td>
			<td>
				<!-- MATT:  Please populate full table -->
				<select name="BILLINGCOUNTRY" size="1">
				<option selected value="0">-- Make a Selection --</option>			
				<option value="US">United States</option>
				<option value="CA">Canada</option>				
			</select></td>
		</tr>	
		<tr>
			<td class="leftcell">Contact Name</td>
			<td><input name="CONTACTNAME" type="text" /></td>
		</tr>	
		<tr>
			<td class="leftcell">Discount</td>
			<td><input name="DISCOUNT" type="text" style="width:50px;display:inline" /> %.&nbsp; 
			Do not enter &quot;%&quot;</td>
		</tr>	
		<tr>
			<td class="leftcell">Terms</td>
			<td>
			<!-- MATT:  Value should equal the actual ID they use. So I filled them in. You will probably want to add this to the DB -->
				<select name="BILLINGTERMS" size="1">
				<option selected value="0">-- Make a Selection --</option>			
				<option value="1">12: Prepaid</option>
				<option value="13">13: Net 1st of Month</option>				
				<option value="14">14: Net 10th of Month</option>								
				<option value="15">15: Net 20th of Month</option>
				<option value="16">16: Net 100 Days</option>	
				<option value="17">17: 1% 30 Net 60</option>			
				<option value="18">18: 2% 30 Net 60</option>
				<option value="19">19: 2% 30 Net 45</option>				
				<option value="20">20: Net 75</option>				
				<option value="21">21: 2% 30 Net 90</option>				
				<option value="22">22: 2% Net 60</option>
				<option value="23">23: 1% 30 Net 31</option>
				<option value="24">24: 1% 30 Net 90</option>
				<option value="26">26: 4% 30 Net 40</option>
				<option value="28">28: 2% 30 Net 31</option>												
			</select></td>
		</tr>	
		<tr>
			<td class="leftcell">Sales Rep</td>
			<td><input name="SALESREP" type="text" /></td>
		</tr>	
		<tr>
			<td class="leftcell">&nbsp;</td>
			<td><input type="submit" name="submit" value="Save &amp; Continue to Shipping >>" />
			<input type="submit" name="submit" value="Add Another Shipping Address >>" />
			</td>
		</tr>																	
	</table>
</form>
</div>
</body>

</html>
