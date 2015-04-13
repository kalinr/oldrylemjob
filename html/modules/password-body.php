<form action="/<? echo stripslashes($content['MOD_NAME']); ?>"  method="post" id="myform">
<p>Password<br /><input type="password" name="PASSWORD" value="<? echo stripslashes($password); ?>" /></p>
<p>Retype Password<br /><input type="password" name="PASSWORD2" value="<? echo stripslashes($password2); ?>" /></p>
<p><input type="submit" value="Change Password" name="BUTTON" style="width: 150px;" /></p>
</form>