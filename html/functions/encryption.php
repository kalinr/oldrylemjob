<?php
/*
 * Functions for securely storing data
 */


/**
 * Encrypt $message with sha1($key) using AES 256 bit algorithm
 * For best practice do not store $key, use the user's plaintext password
 * Returns the encrypted message
 * Usage: $secure = encrypt($key, $data);
 */
function encrypt($key, $message)
{
	if ($message == "")
		return "";
	
	srand((double)microtime()*1000000 );
	$td = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CFB, '');
	$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
	$ks = mcrypt_enc_get_key_size($td);
	$key2 = substr(sha1($key), 0, $ks);
	
	mcrypt_generic_init($td, $key2, $iv);
	$message = mcrypt_generic($td, $message);
	mcrypt_generic_deinit($td);
	
	mcrypt_module_close($td);
	
	return base64_encode($iv)."|".base64_encode($message);
}

/**
 * Decrypt $message with sha1($key) using AES 256 bit algorithm
 * For best practice do not store $key, use the user's plaintext password
 * Returns the plaintext message
 * Usage: $data = decrypt($key, $secure);
 */
function decrypt($key, $secure_message)
{
	if ($secure_message == "")
		return "";

	$secure_message = explode("|", $secure_message);
	$iv = base64_decode($secure_message[0]);
	$secure_message = base64_decode($secure_message[1]);
		
	srand((double)microtime()*1000000 );
	$td = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CFB, '');
	//$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
	$ks = mcrypt_enc_get_key_size($td);
	$key2 = substr(sha1($key), 0, $ks);
	
	mcrypt_generic_init($td, $key2, $iv);
	$message = mdecrypt_generic($td, $secure_message);
	mcrypt_generic_deinit($td);
	
	mcrypt_module_close($td);
	
	return $message;
}

/**
 * Encrypt $message using the preset key
 */
function encryptPreset($message)
{
	//return encrypt(apache_getenv('ENCKey'), $message);
	return encrypt("jd38Hf42", $message);
}

/**
 * Decrypt $message using the preset key
 */
function decryptPreset($message)
{
	//return decrypt(apache_getenv('ENCKey'), $message);
	return decrypt("jd38Hf42", $message);
}

/**
 * Re-encrypt everything using the user's new password
 */
function change_encryption_keys($oldkey, $newkey, $accountid)
{
	$new_enc = encrypt_gpg($newkey);

	$result = mysql_query("SELECT ACCOUTID, STATUS FROM accounts_recovery WHERE ACCOUNTID=$accountid");
	if (mysql_num_rows($result) == 0)
		mysql_query("INSERT INTO accounts_recovery (ACCOUNTID, ENC_PW, STATUS) VALUES ($accountid, '$new_enc', 'current')");
	else
		mysql_query("UPDATE accounts_recovery SET ENC_PW='$new_enc', STATUS='current' WHERE ACCOUNTID=$accountid");
	
	// Employee EINSSN
	$result = mysql_query("SELECT ID, EINSSN FROM accounting_employees WHERE ACCOUNTID='$accountid' AND EINSSN<>''");
	while ($employee = mysql_fetch_object($result))
	{
		$new_enc = encrypt($newkey, decrypt($oldkey, $employee->EINSSN));
		mysql_query("UPDATE accounting_employees SET EINSSN='$new_enc' WHERE ACCOUNTID='$accountid' AND ID=".$employee->ID);
	}
}

/**
 * GPG encrypt message 
 */
function encrypt_gpg($message)
{
	//$message = base64_encode($message);
	$recipient = 'beyondthedesk@gmail.com';
	$message = base64_encode($message);
	
	srand((double)microtime()*1000000 );
	$path = "/var/www/html/scripts/temp/";
	$file = rand();
	
	$cmd = "echo '$message' | /usr/local/bin/gpg --batch -e -r $recipient -o $path$file";
	
	putenv("GNUPGHOME=/home/www/.gnupg");
    system($cmd);
	$encrypted_message = base64_encode(file_get_contents($path.$file));
	
	//echo "Encrypted Message: ".$encrypted_message;
	
	unlink($path.$file);
	
	return $encrypted_message;
}

/**
 * GPG decrypt message 
 */
function decrypt_gpg($passphrase, $message)
{
	$message = base64_decode($message);
	
	srand((double)microtime()*1000000 );
	$path = "/var/www/html/scripts/temp/";
	$file = rand();
	$file2 = rand();
	
	$fp = fopen($path.$file, "w");
	if (!$fp)
		die("Unable to open file");
	fwrite($fp, $message);
	fclose($fp);
	
	$cmd = "echo $passphrase | /usr/local/bin/gpg --batch --passphrase-fd 0 -o $path$file2 -d $path$file";
	putenv("GNUPGHOME=/home/www/.gnupg");
	$ret = "";
	system($cmd, &$ret);
	
	$decrypted_message = base64_decode(file_get_contents($path.$file2));
	
	unlink($path.$file);
	unlink($path.$file2);
	
	
	return $decrypted_message;
}

/**
 * Make sure the user's password is stored in $_SESSION['password'] for use in encrypting data
 */
function encryption_ready()
{
	$userid = $_SESSION['USERID'];
	if (!isset($_SESSION['PASSWORD']))
		return false;
	$password = md5($_SESSION['PASSWORD']);
	
	$result = mysql_query("SELECT ID FROM accounts WHERE ID=".$_SESSION['USERID']." AND PASSWORD='$password'");
	if (mysql_num_rows($result) < 1)
		return false;
	
	return true;
}

?>