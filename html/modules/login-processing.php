<?
if($_POST['BUTTON'] == "Login")
{
	$email = mysqlclean(strtolower(trim($_POST['EMAIL'])));
	$password = mysqlclean(strtolower($_POST['PASSWORD']));
	
	if($email == "" or !validEmail($email))
		$error = "Please type in a valid email address.";
	else if($password == "")
		$error = "Please type in a valid password.";
	else
	{
		$query = "SELECT * FROM accounts WHERE EMAIL='$email'";
		$result = mysql_query($query) or die (mysql_error());
		$row = mysql_fetch_array($result);
		$accountid = $row['ID'];
	
		if($accountid == "")
			$error = "Your email address was not found in the database.";
		else if($password != $row['PASSWORD'] && md5($password) != $row['PASSWORD'])
			$error = "Sorry, your password is incorrect.";
		else if($row['TYPEID'] == 8)
			$error = "Thank you for setting up your account. We will notify you when our new website is launched.";
		else
		{
			$_SESSION['USERID'] = $accountid;
			$redirect = $_SESSION['LOGIN_REDIRECT'];
			unset($_SESSION['LOGIN_REDIRECT']);
			processLogin($accountid);
			if($content['ID'] == 79)
				httpRedirect("/cart");
			else if($account['TYPE'] == 6)
				httpRedirect("/admin/orders");
			else if($row['SAVED_CART'] != "")
			{
				$_SESSION['STATUS'] = "Welcome back! Your saved cart has been automatically loaded.";
				$_SESSION['CART'] = unserialize($row['SAVED_CART']);
			
				httpRedirect("/cart");
			}
			else if($redirect != "")
			{	
				httpRedirect("/".$redirect);
			}
			else
				httpRedirect("/cart");
		}
	}
}
else if($_POST['BUTTON'] == "Send Password")
{
	$email = mysqlclean(trim($_POST['EMAIL']));
	
	if($email == '' or !validEmail($email))
		$error = "Please type in a valid $email address.";
	else
	{
		$query = "SELECT * FROM accounts WHERE EMAIL='$email'";
		$result = mysql_query($query) or die ("error1" . mysql_error());
		$row = mysql_fetch_array($result);
		
		if($row['ID'] == '')
			$error = "No accounts were found using $email.";
		else if($row['RESET_TOKEN_EXPIRES'] > currentDateTime())
			$error = "A reset email has already been issued in the last 24 hours. Please check your spam or bulk email folder. If you have not received a reset email to $email, please contact customer service.";
		else
		{
			resetPasswordLink($row['ID'],$row['EMAIL'],$row['FIRST'].' '.$row['LAST']);
			$_SESSION['STATUS'] = "Thank you. Your password request has been sent and should arrive within 10 minutes. Be sure to check your bulk email folder as sometimes these types of emails are flagged as junk email. If you still can't login, please contact us and we would be happy to assist you.";
			if($_SESSION['LOGIN_REDIRECT'] != "")
			{
				$after_login = $_SESSION['LOGIN_REDIRECT'];
				unset($_SESSION['LOGIN_REDIRECT']);
				httpRedirect("/".$after_login);
			}
			else
				httpRedirect("/login");
		}
	}
}
else if($_SESSION['USERID'] !="" && $content['ID'] == 79)
{
	httpRedirect("/checkout/shipping");
}
else if($account['TYPEID'] == 6 OR $account['TYPEID'] == 7)
	httpRedirect("/admin/customers");
?>