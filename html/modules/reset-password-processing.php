<?
$mod = explode("/",$_GET['mod_name']);
$token = $qa[1];
$reset_password = false;
if($token != '')
{
	//$token_array = explode("-",$token);
	$id = mysqlClean($qa[0]);
	$reset_token = mysqlClean($qa[1]);
	$query = "SELECT * FROM accounts WHERE ID='$id' AND RESET_TOKEN='$reset_token' AND RESET_TOKEN_EXPIRES>='".currentDate()."'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
	if($row['ID'] == '' or $id == '' or $reset_token == '')
		$reset_password = false;
	else
	{
		$reset_password = true;
		if($_POST['BUTTON'] == "Reset Password")
		{
			$password = strtolower(trim($_POST['PASSWORD']));
			$password2 = strtolower(trim($_POST['PASSWORD2']));
			
			if($password == '')
				$error = "Please type in a password.";
			else if($password != $password2)
				$error = "Your passwords do not match. Please try again.";
			else
			{
				mysql_query("UPDATE accounts SET PASSWORD='$password', RESET_TOKEN='', RESET_TOKEN_EXPIRES='0000-00-00 00:00:00' WHERE ID='".$row['ID']."'") or die(mysql_error());
				$_SESSION['STATUS'] = "Your password has been reset. Please login.";
				httpRedirect("/login");
			}
		}
	}
}
?>