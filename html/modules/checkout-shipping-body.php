<?
if($qa[1] == "")
{
$count = 0;
	$query = "SELECT * FROM accounts_shipping WHERE ACCOUNTID='".$_SESSION['USERID']."'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	while($address = mysql_fetch_array($result))
	{
		if($count == 0)
			{
			echo '<p>Click on the shipping address you would like ship to.  You may also create a new shipping address below.<br />';
			echo '<b>Please Note:  Orders will be shipped via UPS. We do not ship to PO boxes.</b></p>';
			}
			echo '<a style="color:#333;" href="/checkout/shipping/'.$address['ACCOUNTID'].'/'.$address['ID'].'">';
			//echo '<a style="color:#333;" href="/myaccount/shipping/'.$address['ACCOUNTID'].'/'.$address['ID'].'">';
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
		echo '</div></a>';
		$count++;
	}
	if($count > 0)
	{
		echo '<div class="clr"></div>';
		//echo '<p style="clear:both"><a href="/checkout/shipping/0/add-shipping-address"><img src="/images/btn_addshippingaddress.png" border="0" alt="Shipping Address" /></a></p>';
	}
}

		//no shipping addresses on file, display form.
		$query_array[0] = $_SESSION['USERID'];
		$query_array[1] = 0;
		include("modules/accounts-shipping-body.php");

?>