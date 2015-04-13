<p>If you don't have an account, <a href="/customer-entry/profile/<? echo $content['ID']; ?>">click here</a> to create one.</p>
      	<h3>Existing Accounts</h3>
      	<form action="/<? echo $content['MOD_NAME']; ?>" method="post" id="myform">
      	<p>Email Address<br /><input type="text" name="EMAIL" value="<?php echo stripslashes($email); ?>" /></p>
      	<p>Password<br /><input type="password" name="PASSWORD" value="" /></p>
      	<p><input type="submit" name="BUTTON" value="Login" /></p>
      	</form>
      	<br />
      	<h3>Reset Password</h3>
		<p>If you have forgotten your password, please enter your email address and a password reset link will be emailed to you.</p>
		<form action="/<? echo $content['MOD_NAME']; ?>" id="myform" method="post">
      	<p>Email Address<br /><input type="text" name="EMAIL" value="<?php echo stripslashes($username); ?>" /></p>
      	<p><input type="submit" name="BUTTON" value="Send Password" /></p>
      	</form>
</div>
<div style="float: left; width: 99%">

