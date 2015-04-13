<?
function sendTo()
{
	return "sales@imaginecrafts.com"; //SITE_EMAIL; originally erics121@comcast.net
}
function sendToAdmin()
{
	return "sales@imaginecrafts.com";
}
function auto_email($address,$subject,$message)
{
        if($address == sendTo())
                $message .= "<br /><br />Users IP Address: ".$_SERVER['REMOTE_ADDR'];
//      if(direct_email($address,$subject,$message,TITLE,sendTo()))
        if(smtpEmail($address,$subject,$message,TITLE,sendTo()))
                return true;
        else
                return false;
}
function smtpEmail($address,$subject,$message,$recipient_name="",$attachment="", $cc)
{
	require_once("functions/PHPMailer_5.2.1/class.phpmailer.php");
	$mail = new PHPMailer();
		
	$mail->AddAddress($address,$recipient_name);
	$mail->SetFrom('customerservice@imaginecrafts.com', 'IMAGINE Crafts');
	$mail->AddReplyTo("customerservice@imaginecrafts.com", "IMAGINE Crafts");

	$mail->WordWrap = 50;                              // set word wrap
	if($attachment != "") //used for buroware exports only
		$mail->AddAttachment($attachment);      // attachment
	$mail->IsHTML(true);                               // send as HTML

	if(!empty($cc)){
		$cc = explode(", " $cc);

		$l = count($cc);
		for($i = 0; $i < $l; $i++){
			$mail.addCC($cc[$i]);
		}
	}

	$mail->Subject  =  $subject;
	$mail->Body     =  nl2br($message);
	$mail->AltBody  =  strip_tags($message);
	if(!$mail->Send())
	{
		 $mail->ErrorInfo;
		
		if(direct_email($address,$subject,$message,$smtp_name,$smtp_email))
			return true;
		else
   			return false;
	}
	else
		return true;
}
function direct_email($address,$subject,$message,$sender_name,$sender_email)
{
	if($sender_name == "")
		$sender_name = $sender_email;

	$message = lineToBR($message);
	
	$message = stripslashes($message);
	$message = wordwrap($message,200);
	if($address == sendTo())
		$message .= "<br /><br />Users IP Address: ".$_SERVER['REMOTE_ADDR'];
	if(strpos($message, "[url=") === false)
	{
		if(mail($address,stripslashes($subject),$message,$headerStr))
			return true;
		else
			return false;
	}
}
function emailChangeNotification($accountid,$origemail,$email)
{
	$message = "Your email has been changed on ".SITE_NAME." from $origemail to $email. This new email is effective immediately. If this was not changed by you, please contact $site_name immediately as this could be a security risk to your account.";
	$message .= "<br /><br /><br />";
	$message .= '<a href="http://www.imaginecrafts.com/mailing-list">Sign up for our mailing list</a> for the latest projects, giveaway news, and more.';
	smtpEmail($origemail,SITE_NAME." - Alert! Email Change",$message,accountFirstLastName($accountid));
}
function passwordChangeNotification($accountid, $email,$password)
{
	$subject = "$site_name - ALERT! Account Password change";
	$message = "Your password has been changed.<br /><br />This new password is effective immediately. If this was not changed by you, please contact ".SITE_NAME." immediately as this could be a security risk to your account.";
	$message .= "<br /><br /><br />";
	$message .= '<a href="http://www.imaginecrafts.com/mailing-list">Sign up for our mailing list</a> for the latest projects, giveaway news, and more.';
	smtpEmail($email,SITE_NAME." - Alert! Email Change",$message,accountFirstLastName($accountid));
}
function resetPasswordLink($id,$address,$receipt_name)
{
	$reset_token = strtoupper(createPassword(12));
	$reset_token_expires = calcDayInfuture(1,1)." ".currentTime();
	mysql_query("UPDATE accounts SET RESET_TOKEN='$reset_token',RESET_TOKEN_EXPIRES='$reset_token_expires' WHERE ID=$id") or die(mysql_error());
	
	$message = "A password reset for your account was requested on ".dateformat(currentDate())." from ".$_SERVER['REMOTE_ADDR'].". Please click the link below to reset your password. Link will be valid for 24 hours.";
	$message .= "<br /><br />https://www.imaginecrafts.com/reset-password/$id/$reset_token";
	$message .= "<br /><br />If you have any questions, please contact customer service.";
	$message .= "<br /><br /><br />";
	$message .= '<a href="http://www.imaginecrafts.com/mailing-list">Sign up for our mailing list</a> for the latest projects, giveaway news, and more.';
	smtpEmail($address,SITE_NAME." Password Reset",$message,$receipt_name);

}
function sendOrderEmail($orderid)
{
	$query = "SELECT * FROM orders WHERE ID='".$orderid."'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
		
	//$message = '<img src="http://www.imaginecrafts.com/images/email-logo.png" /><br /><br />Thank you for placing your order with IMAGINE Crafts '.$row['FIRST'].' '.$row['LAST'].'!';
	$message = '<img src="http://www.imaginecrafts.com/images/email-logo.png" /><br /><br /><font face="Arial" size="2">Thank you for placing your order with IMAGINE Crafts. Your order will ship as soon as possible.';	
	$message .= '<br /><br /><strong>Billing Information:</strong><br />'.$row['FIRST'].' '.$row['LAST'];
	if($row['ORGANIZATION'] != "")
		$message .= '<br />'.$row['ORGANIZATION'];
	if($row['ADDRESS'] != "")
		$message .= '<br />'.$row['ADDRESS'];
	if($row['ADDRESS2'] != "")
		$message .= '<br />'.$row['ADDRESS2'];
	$message .= '<br />'.$row['CITY'].', '.$row['STATE'].' '.$row['ZIP'];
	$message .= '<br />'.$row['COUNTRY'];
	$message .= '<br /><br /><strong>Shipping Information:</strong>';
	$message .= '<br />'.$row['SHIPPING_ORGANIZATION'];
	if($row['SHIPPING_ADDRESS'] != "")
		$message .= '<br />'.$row['SHIPPING_ADDRESS'];
	if($row['SHIPPING_ADDRESS2'] != "")
		$message .= '<br />'.$row['SHIPPING_ADDRESS2'];
	$message .= '<br />'.$row['SHIPPING_CITY'].', '.$row['SHIPPING_STATE'].' '.$row['SHIPPING_ZIP'];
	$message .= '<br />'.$row['SHIPPING_COUNTRY'];
	$message .= '<br /><br /><strong>Order Information</strong><br /><br />';
	$query2 = "SELECT * FROM orders_details WHERE ORDERID='".$orderid."'";
	$result2 = mysql_query($query2) or die (mysql_error());
	
	$message .= '<table border="0" width="800" cellspacing="0" cellpadding="3" style="font-family:arial;font-size:12px">';
	$message .= '<tr>';
	$message .= '<td><b>SKU</b></td>';
	$message .= '<td><b>Item</b></td>';
	$message .= '<td align="center"><b>Price</b></td>';
	$message .= '<td align="center"><b>Qty</b></td>';
	$message .= '<td align="right"><b>Total</b></td>';
	$message .= '</tr>';	
	
	$lineTotalSum = 0;
	
	while($row2 = mysql_fetch_array($result2)) {
	
		$query3 = "SELECT COLOR FROM products WHERE SKU='".$row2['SKU']."'";
		$result3 = mysql_query($query3) or die (mysql_error());
		$color = mysql_fetch_array($result3);
		$itemcolor = "";
		if ($color['COLOR'] != '')
			$itemcolor = ' - '.$color['COLOR'];
	
		$message .= '<tr>';
		$message .= '<td width="120">'.$row2['SKU'].'</td>';
		$message .= '<td width="310">'.$row2['NAME'].$itemcolor.'</td>';		
		$message .= '<td align="center">'.$row2['RATE'].'</td>';		
		$message .= '<td align="center">'.$row2['QUANTITY'].'</td>';
		$message .= '<td align="right">'.$row2['LINE_TOTAL'].'</td>';
		$message .= '</tr>';
		
		$lineTotalSum += $row2['LINE_TOTAL'];
		
		//$message .= '<br /><br />'.$row2['QUANTITY'].' x '.$row2['SKU'].'<br/ >'.$row2['NAME'];
		//if($row2['DESCRIPTION'] != "")
		//	$message .= $row2['DESCRIPTION'];
	}
        		
	//$message .= '<br /><br />Subtotal: $'.$row['SUBTOTAL'];	
	$message .= '<tr>';
	$message .= '<td colspan="4" align="right">Subtotal:</td>';
	$message .= '<td align="right">'.$row['SUBTOTAL'].'</td>';
	$message .= '</tr>';
	
	if($row['DISCOUNT_CUSTOMER'] != 0)
		{
		//$message .= '<br />Preferred Customer Discount: -$'.$row['DISCOUNT_CUSTOMER'];
		$message .= '<tr>';
		$message .= '<td colspan="4" align="right">Discount:</td>';
		$message .= '<td align="right">-'.$row['DISCOUNT_CUSTOMER'].'</td>';
		$message .= '</tr>';		
		}
		
	if($row['DISCOUNT_PROMO'] != 0)
		{
		//$message .= '<br />Promo Discount: $'.$row['DISCOUNT_PROMO'].' '.$row['PROMO_DESCRIPTION'];
		$message .= '<tr>';
		$message .= '<td colspan="4" align="right">Promo Discount:</td>';
		$message .= '<td align="right">-'.$row['DISCOUNT_PROMO'].'</td>';
		$message .= '</tr>';			
		}

	if($row['SHIPPING'] > 0)
	{
	//$message .= '<br />Shipping: $'.$row['SHIPPING'];
	$message .= '<tr>';
	$message .= '<td colspan="4" align="right">Shipping:</td>';
	$message .= '<td align="right">'.$row['SHIPPING'].'</td>';
	$message .= '</tr>';		
	}
	
	if($row['TAX'] > 0)
		{
		//$message .= '<br />Sales Tax: $'.$row['TAX'];
		$message .= '<tr>';
		$message .= '<td colspan="4" align="right">Sales Tax:</td>';
		$message .= '<td align="right">'.$row['TAX'].'</td>';
		$message .= '</tr>';		
		}
		
	//$message .= '<br />Order Total: $'.$row['TOTAL'];
	$message .= '<tr>';
	$message .= '<td colspan="4" align="right"><b>Order Total:</b></td>';
	$message .= '<td align="right"><b>$'.$row['TOTAL'].'</b></td>';
	$message .= '</tr>';		
	
	$message .= '</table>';	
		
	if($row['CCTYPE'] != "")
	{
		$message .= "<br /><br />Paid via card: ".$row['CCTYPE']." xxxx-xxxx-xxxx-".$row['LAST4CC'];
		if($row['PONUMBER'] != '')
			$message .= ' (REF PO # '.stripslashes($row['PONUMBER']).')';		
	}
	else	
		$message .= "<br /><br />Purchase Order: ".$row['PONUMBER'];
	
	if ($row['SHIPPING_METHOD']!="TBD")
		$message .= '<br /><br /><b>Shipping Method:</b> '.$row['SHIPPING_METHOD'];
	else	
		$message .= '<br /><br /><b>Shipping and Handling to be determined at time of fulfillment</b>';	
	
	$message .= '<br /><br />We will send you another email once your order has shipped.';	
 	$message .= '<br /><br />For questions regarding your order, please <a href="http://www.imaginecrafts.com/contact">contact customer service</a> anytime or call (800) 769-6633 Monday-Friday 8:30am to 4pm PST';
	$message .= "<br /><br /><br />";
	$message .= '<a href="http://www.imaginecrafts.com/mailing-list">Sign up for our mailing list</a> for the latest projects, giveaway news, and more.';

	$accountEmails = accountEmails($row['ACCOUNTID']);
 	smtpEmail($accountEmails["EMAIL"],"Order #".$row['ID']." Confirmation",$message,"ImagineCRAFTS",$accountEmails["EMAIL2"]);

	smtpEmail("michellel@imaginecrafts.com","Michelle Copy - Order #".$row['ID']." Confirmation",$message,"ImagineCRAFTS");
 	smtpEmail("sales@imaginecrafts.com","Sales Copy - Order #".$row['ID']." Confirmation",$message,"ImagineCRAFTS");
	// smtpEmail("erics121@comcast.net","Eric Copy - Order #".$row['ID']." Confirmation",$message,"ImagineCRAFTS"); 	
}
function sendOrderShippedNotification($orderid)
{
	$query = "SELECT * FROM orders WHERE ID='".$orderid."'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
	
	$message = '<img src="http://www.imaginecrafts.com/images/email-logo.png" /><br /><br />';
	$message .= $row['FIRST'].' - Thank you again for shopping with IMAGINE Crafts, featuring products from Tsukineko! Your order has shipped.<br /><br />Your order has been shipped to:<br /><br />';
	$message .= $row['SHIPPING_ORGANIZATION'].'<br />'.$row['SHIPPING_ADDRESS'];
	if($row['SHIPPING_ADDRESS2'] != "")
		$message .= '<br />'.$row['SHIPPING_ADDRESS2'];
	$message .= '<br />'.$row['SHIPPING_CITY'].', '.$row['SHIPPING_STATE'].' '.$row['SHIPPING_ZIP'].'<br />'.$row['SHIPPING_COUNTRY'];
	
	if ($row['SHIPPING_METHOD']!="TBD")
	{
	$message .= '<br /><br />Your order is being shipped by '.$row['SHIPPING_METHOD'];
	if($row['SHIPPING_TRACKING'] != "")
		$message .= ' and your tracking number is '.$row['SHIPPING_TRACKING'];
	}
	else
	{
		if($row['SHIPPING_TRACKING'] != "")
			$message .= '<br /><br />Your tracking number is: '.$row['SHIPPING_TRACKING'];
	}
	
	
	$message .= '<br /><br /><strong>Order Information</strong>';
	$query2 = "SELECT * FROM orders_details WHERE ORDERID='".$orderid."'";
	$result2 = mysql_query($query2) or die (mysql_error());
	while($row2 = mysql_fetch_array($result2))
	{
		$message .= '<br />'.$row2['QUANTITY'].' x '.$row2['SKU'].'<br/ >'.$row2['NAME'];
		if($row2['DESCRIPTION'] != "")
			$message .= $row2['DESCRIPTION'];
	}
	$message .= '<br /><br />Subtotal: $'.$row['SUBTOTAL'];
	if($row['DISCOUNT_CUSTOMER'] != 0)
		$message .= '<br />Preferred Customer Discount: -$'.$row['DISCOUNT_CUSTOMER'];
	if($row['DISCOUNT_PROMO'] != 0)
		$message .= '<br />Promo Discount: -$'.$row['DISCOUNT_PROMO'].' '.$row['PROMO_DESCRIPTION'];
	$message .= '<br />Shipping: $'.$row['SHIPPING'];
	if($row['TAX'] > 0)
		$message .= '<br />Sales Tax: $'.$row['TAX'];
	$message .= '<br />Order Total: $'.$row['TOTAL'];
	if($row['CCTYPE'] != "")
	{
		$message .= "<br /><br />Paid via card: ".$row['CCTYPE']." xxxx-xxxx-xxxx-".$row['LAST4CC'];
		if($row['PONUMBER'] != '')
			$message .= ' (REF PO # '.stripslashes($row['PONUMBER']).')';		
	}
	else	
		$message .= "<br /><br />Paid via PO NUMBER: ".$row['PONUMBER'];
	$message .= '<br /><br />For questions regarding your order, please <a href="http://www.imaginecrafts.com/contact">contact Customer Service via email</a> anytime or (800) 769-6633 Monday-Friday 8:30am to 4pm PST';
	$message .= "<br /><br /><br />";
	$message .= '<a href="http://www.imaginecrafts.com/mailing-list">Sign up for our mailing list</a> for the latest projects, giveaway news, and more.';

	$accountEmails = accountEmails($row['ACCOUNTID']);
	smtpEmail($accountEmails["EMAIL"],"Order #".$row['ID']." Confirmation",$message,"ImagineCRAFTS",$accountEmails["EMAIL2"]);
}
?>
