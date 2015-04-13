<p>IMAGINE Crafts is pleased to offer our wholesale partners the widest 
selection of high quality ink products, accessories, and embellishments in the 
arts and crafts industry. Your use and promotion of IMAGINE Crafts and Tsukineko 
products is extremely important to us and we would like to help make it easier 
for you to order our products.<br /><br />
<b>Existing Wholesale Customers</b>: Because this is a completely new website, all existing IMAGINE Crafts wholesale customers will need to create a new online account. 
We apologize to our long-standing customers for the inconvenience. The good news 
is that this process is very simple and quick to complete. Once we have received 
your completed information we will finish the process. Please note that 
wholesale customers must log in to their accounts to have appropriate pricing 
visible while shopping.<br /><br />
<b>New Wholesale Account Requirements</b>: Wholesale pricing is extended to qualifying 
retail partners who meet the criteria listed below. The first step of this 
process is to complete the Wholesale Account Application along with submitting a 
copy of your current business license and tax information. Once we have received 
all of this information you will be notified of the status of your wholesale 
account. When your application has been approved you will then be able to place 
your order online with wholesale discounts.<br />
<ul>
<li>Opening order of $75 with a minimum quantity of 2 each per item/color except 
for filled displays and bulk items</li>
<li>Minimum re-orders of $75 with same quantity requirements listed above</li>
<li>Copy of business license and or tax ID number is required prior to finishing 
the set-up process and prior to your first order sent to us via email or by fax 
to (425) 883-7418.</li>
<li>Prepaid with VISA or MASTERCARD. Opening orders may also be prepaid with 
cashiers check or money orders. Orders paid with personal or company checks will 
ship after the check has cleared (approximately five business days).</li>
</ul>
<p>For a complete listing of our Wholesale Requirements please refer to IMAGINE 
Crafts' <a href="/terms-of-use">Terms of Use</a>.</p>
<form action="/<? echo $content['MOD_NAME']; ?>" method="post" id="myform">
<p>Company<br /><input type="text" name="COMPANY" value="<? echo stripslashes($company); ?>" /></p>
<p>Contact Name<br /><input type="text" name="CONTACT_NAME" value="<? echo stripslashes($contact_name); ?>" /></p>
<p>Email<br /><input type="text" name="EMAIL" value="<? echo stripslashes($email); ?>" /></p>
<p>Additional Emails<br /><input type="text" name="EMAIL2" value="<? echo stripslashes($email2); ?>" /></p>
<p>Phone<br /><input type="text" name="PHONE" value="<? echo stripslashes($phone); ?>" /></p>
<p>Fax<br /><input type="text" name="FAX" value="<? echo stripslashes($fax); ?>" /></p>
<p>Resale ID<br /><input type="text" name="RESALE_ID" value="<? echo stripslashes($resale_id); ?>" /></p>
<p>Address<br /><input type="text" name="ADDRESS" value="<? echo stripslashes($address); ?>" /></p>
<p>Apt / Suite #<br /><input type="text" name="APARTMENT" value="<? echo stripslashes($apartment); ?>" /></p>
<p>City<br /><input type="text" name="CITY" value="<? echo stripslashes($city); ?>" /></p>
<p>State/Province<br /><input type="text" name="STATE" value="<? echo stripslashes($state); ?>" /></p>
<p>Zip/Postal Code<br /><input type="text" name="ZIP" value="<? echo stripslashes($zip); ?>" /></p>
<p>Country:<br /><select name="COUNTRY" size="1">		
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
			</select></p>
<p>URL<br /><input type="text" name="URL" value="<? echo stripslashes($url); ?>" /></p>
<p>Mailing Lists<br />
<label><input name="craft_project_ideas" type="checkbox" checked="checked" value="1" /> Receive wonderful craft project ideas through our blog</label><br />
<label><input name="product_announcements" type="checkbox" checked="checked" value="1" /> Receive important new product announcements and information</label></p>

<fieldset>
<legend>Interest</legend>
<p><input type="checkbox" name="SCRAPBOOKING" value="1"<? if($scrapbooking){ echo ' checked'; } ?> /> Scrapbooking</p>
<p><input type="checkbox" name="RUBBER_STAMPING" value="1"<? if($rubber_stamping){ echo ' checked'; } ?> /> Rubber Stamping</p>
<p><input type="checkbox" name="FABRIC_ARTS" value="1"<? if($fabric_arts){ echo ' checked'; } ?> /> Fabric Arts</p>
<p><input type="checkbox" name="GIFT_TOY" value="1"<? if($gift_toy){ echo ' checked'; } ?> /> Gift Toy</p>
<p><input type="checkbox" name="CHAIN_STORE" value="1"<? if($chain_store){ echo ' checked'; } ?> /> Chain Store</p>
<p>Other: <input type="text" name="OTHER" value="<? echo stripslashes($other); ?>" /></p>
</fieldset>
<p>Verification <span style="color: grey">- type the numbers in the box below</span><br />
	<img src="/global/captcha.php" border="1" alt="CAPTCHA" /><br />
    <input name="VERIFICATION" type="text" style="width: 100px; margin-top:8px;" /></p>
<p><input type="submit" name="BUTTON" value="Submit" /></p>
</form>