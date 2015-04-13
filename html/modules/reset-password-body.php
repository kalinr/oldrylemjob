<?
if($reset_password){ ?>
<p>Please type in your new password.</p>
<form action="/<? echo $content['MOD_NAME']; ?>/<? echo $qa[0]; ?>/<? echo $qa[1]; ?>" method="post" id="myform">
<p>New Password<br /><input type="password" name="PASSWORD" /></p>
<p>Retype Password<br /><input type="password" name="PASSWORD2" /></p>
<p><input type="submit" name="BUTTON" value="Reset Password" /></p>
</form>
<?
}
else
	echo '<p>We\'re sorry, but your password link is either expired or invalid. Please reset a new password link from the <a href="/login">login</a> page.</p>';
?>