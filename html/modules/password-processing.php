<?
if($_POST['BUTTON'] == "Change Password")
{
	$password = strtolower(mysqlClean(trim($_POST['PASSWORD'])));
	$password2 = strtolower(mysqlClean(trim($_POST['PASSWORD2'])));
	
	if($password == '')
		$error = "Please type in a password.";
	else if($password != $password2)
		$error = "Passwords do not match.";
	else if(strlen($password) < 6)
		$error = "Password must be at least 6 characters.";
	else
	{
		passwordChangeNotification($account['ID'], $account['EMAIL'],$password);
		mysql_query("UPDATE accounts SET PASSWORD='$password' WHERE ID='".$account['ID']."'") or die(mysql_error());
		$_SESSION['STATUS'] = "Your password has been changed.";
		httpRedirect("/".$content['MOD_NAME']);
	}
}
?>