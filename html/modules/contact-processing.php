<?
if($go == "process" or $_POST['BUTTON'] == "Send Message" or $_POST['BUTTON_x'] != "")
{
	$first = mysqlClean($_POST['FIRST']);
	$last = mysqlClean($_POST['LAST']);
	$email = strtolower(trim($_POST['EMAIL']));
	$phone = mysqlClean($_POST['PHONE']);
	$message = mysqlClean($_POST['MESSAGE']);
	$subject = mysqlClean($_POST['SUBJECT']);
	
	if($first == "")
		$error = "Please enter a first name.";
	else if($last == '')
		$error = "Please enter a last name.";
	else if($email == '' or !validEmail($email))
		$error = "Please enter a valid email address.";
	else if($phone == '')
		$error = "Please enter a phone number.";
	else if($subject == '')
		$error = "Please enter a reason / subject.";
	else if($message == '')
		$error = "Please enter a message.";
	else if($_POST['VERIFICATION'] != $_SESSION['digit'])
		$error = "The validation numbers you typed in do not match. Please try again.";
	else
	{
		$message = "<strong>Message from Imagine Crafts.</strong><br /><br />Name: $first $last<br />Phone: ".$phone."<br />Email: $email<br /><br />$message";
		if(direct_email(sendTo(),SITE_NAME." - ".$subject,$message,$first." ".$last,$email))
		{	
			$_SESSION['STATUS'] = "Thank you! Your message has been sent.";
			httpRedirect(currentFile());
		}
		else
			$error = "There was an error while trying to send your message. Please try again.";
	}
}
?>