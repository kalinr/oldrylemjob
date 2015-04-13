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
	if(direct_email($address,$subject,$message,TITLE,sendTo()))
		return true;
	else
		return false;
}
function smtpEmail($address,$subject,$message,$recipient_name="",$attachment="")
{	
 			
	require_once("functions/PHPMailer_5.2.1/class.phpmailer.php");
	$mail = new PHPMailer();	
	$mail->IsSMTP();                                   // send via SMTP

	$mail->Host     = SMTP_HOST; // SMTP servers
	$mail->SMTPAuth = true;     // turn on SMTP authentication
	$mail->Username = SMTP_USERNAME;  // SMTP username
	$mail->Password = SMTP_PASSWORD; // SMTP password
	$mail->From     = SITE_EMAIL;
	$mail->FromName = SITE_NAME;
		
	$mail->AddAddress($address,$recipient_name);
	//$mail->AddAddress("ellen@site.com");               // optional name
	$mail->AddReplyTo($site_email,$smtp_name);

	$mail->WordWrap = 50;                              // set word wrap
	if($attachment != "") //used for buroware exports only
		$mail->AddAttachment($attachment);      // attachment
	//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");
	$mail->IsHTML(true);                               // send as HTML

	$mail->Subject  =  $subject;
	$mail->Body     =  nl2br($message);
	$mail->AltBody  =  strip_tags($message);
	if(!$mail->Send())
	{
		 $mail->ErrorInfo;
		print_r($mail);
		/*
		if(direct_email($address,$subject,$message,$smtp_name,$smtp_email))
			return true;
		else
   			return false;
   		*/
	}
	else
		return true;
}
function direct_email($address,$subject,$message,$sender_name,$sender_email)
{
	if($sender_name == "")
		$sender_name = $sender_email;
	//if($sender_email == "" and isset($_SESSION['USERID']))
	//	$sender_email = accountEmail($_SESSION['USERID']);
	$message = lineToBR($message);
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: $sender_name <$sender_email>" . "\r\n";
	
	// added the rest of the headers for spam experiment
	$headers .= "X-Sender: $sender_email\n";
	$headers .= "X-Mailer: PHP\n";
	$headers .= "X-Priority: 3\n";
	$headers .= "Return-Path: $sender_email\n";
	$headers .= "Reply-To: $sender_email\n";
	//$headers .= "Bcc: matthew@matthewfleming.com\n";	
	
	$message = stripslashes($message);
	$message = wordwrap($message,200);
	if($address == sendTo())
		$message .= "<br /><br />Users IP Address: ".$_SERVER['REMOTE_ADDR'];
	if(strpos($message, "[url=") === false)
	{
		if(mail($address,stripslashes($subject),$message,$headers))
			return true;
		else
			return false;
	}
}
function emailChangeNotification($accountid,$origemail,$email)
{
	$message = "Your email has been changed on ".SITE_NAME." from $origemail to $email. This new email is effective immediately. If this was not changed by you, please contact $site_name immediately as this could be a security risk to your account.";
	smtpEmail($origemail,SITE_NAME." - Alert! Email Change",$message,accountFirstLastName($accountid));
}
function passwordChangeNotification($accountid, $email,$password)
{
	$subject = "$site_name - ALERT! Account Password change";
	$message = "Your password has been changed.<br /><br />This new password is effective immediately. If this was not changed by you, please contact ".SITE_NAME." immediately as this could be a security risk to your account.";
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
	smtpEmail($address,SITE_NAME." Password Reset",$message,$receipt_name);

}
function sendOrderEmail($orderid)
{
	$query = "SELECT * FROM orders WHERE ID='".$orderid."'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
		
	$message = '<img src="http://www.imaginecrafts.com/images/email-logo.png" /><br /><br />Thank you for placing your order with IMAGINE Crafts '.$row['FIRST'].' '.$row['LAST'].'!';
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
		$message .= '<br />Preferred Customer Discount: $'.$row['DISCOUNT_CUSTOMER'];
	if($row['DISCOUNT_PROMO'] != 0)
		$message .= '<br />Promo Discount: $'.$row['DISCOUNT_PROMO'].' '.$row['PROMO_DESCRIPTION'];
	$message .= '<br />Shipping: $'.$row['SHIPPING'];
	if($row['TAX'] > 0)
		$message .= '<br />Sales Tax: $'.$row['TAX'];
	$message .= '<br />Order Total: $'.$row['TOTAL'];
	if($row['CCTYPE'] != "")
		$message .= "<br /><br />Paid via card: ".$row['CCTYPE']." xxxx-xxxx-xxxx-".$row['LAST4CC'];
	else	
		$message .= "<br /><br />Paid via PO NUMBER: ".$row['PONUMBER'];
 	$message .= '<br /><br />For questions regarding your order, please <a href="http://www.imaginecrafts.com/contact">contact Customer Service via email</a> anytime or (800) 769-6633 Monday-Friday 8:30am to 4pm PST';
 	
 	smtpEmail(accountEmail($row['ACCOUNTID']),"Order #".$row['ID']." Confirmation",$message,"Imagine Crafts");
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
	$message .= '<br />'.$row['SHIPPING_CITY'].', '.$row['SHIPPING_STATE'].' '.$row['SHIPPING_ZIP'].'<BR />'.$row['SHIPPING_COUNTRY'];
	$message .= '<br /><br />Your order is being shipped by '.$row['SHIPPING_METHOD'];
	if($row['SHIPPING_TRACKING'] != "")
		$message .= ' and tracking # '.$row['SHIPPING_TRACKING'];
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
		$message .= '<br />Preferred Customer Discount: $'.$row['DISCOUNT_CUSTOMER'];
	if($row['DISCOUNT_PROMO'] != 0)
		$message .= '<br />Promo Discount: $'.$row['DISCOUNT_PROMO'].' '.$row['PROMO_DESCRIPTION'];
	$message .= '<br />Shipping: $'.$row['SHIPPING'];
	if($row['TAX'] > 0)
		$message .= '<br />Sales Tax: $'.$row['TAX'];
	$message .= '<br />Order Total: $'.$row['TOTAL'];
	if($row['CCTYPE'] != "")
		$message .= "<br /><br />Paid via card: ".$row['CCTYPE']." xxxx-xxxx-xxxx-".$row['LAST4CC'];
	else	
		$message .= "<br /><br />Paid via PO NUMBER: ".$row['PONUMBER'];
	$message .= '<br /><br />For questions regarding your order, please <a href="http://www.imaginecrafts.com/contact">contact Customer Service via email</a> anytime or (800) 769-6633 Monday-Friday 8:30am to 4pm PST';

	smtpEmail(accountEmail($row['ACCOUNTID']),"Order #".$row['ID']." Shipped",$message,"Imagine Crafts");
}
?>