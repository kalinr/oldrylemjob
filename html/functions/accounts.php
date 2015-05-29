<?
function accountsCreate($typeid, $account_number, $search_id, $first, $last, $organization, $address1, $address2, $city, $state, $zip, $country, $phone1, $phone2, $email, $email2, $fax, $url, $discount, $terms_id, $salesrep_id, $notes, $tax, $bypass_initial_minimum)
{
	$account_number = mysqlClean($account_number);
	$search_id = mysqlClean($search_id);
	$first = mysqlClean($first);
	$last = mysqlClean($last);
	$organization = mysqlClean($organization);
	$address1 = mysqlClean($address1);
	$address2 = mysqlClean($address2);
	$city = mysqlClean($city);
	$state = mysqlClean($state);
	$zip = mysqlClean($zip);
	$country = mysqlClean($country);
	$phone1 = mysqlClean($phone1);
	$phone2 = mysqlClean($phone2);
	$email = mysqlClean($email);
	$email2 = mysqlClean($email2);
	$password = createPassword();
	$fax = mysqlClean($fax);
	$url = mysqlClean($url);
	$discount = mysqlClean($discount);
	$terms_id = mysqlClean($terms_id);
	$salesrep_id = mysqlClean($salesrep_id);
	$notes = mysqlClean($notes);
	$tax = mysqlClean($tax);
	$lastupdated = currentDateTime();
	$created = currentDateTime();

	mysql_query("INSERT INTO accounts(TYPEID, ACCOUNT_NUMBER, SEARCH_ID, FIRST, LAST, ORGANIZATION, ADDRESS1, ADDRESS2, CITY, STATE, ZIP, COUNTRY, PHONE1, PHONE2, EMAIL, EMAIL2, PASSWORD, FAX, URL, DISCOUNT, TERMS_ID, SALESREP_ID, NOTES, BYPASS_INITIAL_MINIMUM, TAX, LOGINS, LASTLOGIN, LASTLOGIN_IP, RESET_TOKEN, RESET_TOKEN_EXPIRES, LASTUPDATED, CREATED) VALUES ('$typeid', '$account_number', '$search_id', '$first', '$last', '$organization', '$address1', '$address2', '$city', '$state', '$zip', '$country', '$phone1', '$phone2', '$email', '$email2', '$password', '$fax', '$url', '$discount', '$terms_id', '$salesrep_id', '$notes', '$tax', ', $bypass_initial_minimum', '$logins', '$lastlogin', '$lastlogin_ip', '$reset_token', '$reset_token_expires', '$lastupdated', '$created')") or die(mysql_error());
	return mysql_insert_id();
}
function accountsUpdate($id, $typeid, $account_number, $search_id, $first, $last, $organization, $address1, $address2, $city, $state, $zip, $country, $phone1, $phone2, $email, $email2, $password, $fax, $url, $discount, $terms_id, $salesrep_id, $notes, $tax, $bypass_initial_minimum)
{
	$account_number = mysqlClean($account_number);
	$search_id = mysqlClean($search_id);
	$first = mysqlClean($first);
	$last = mysqlClean($last);
	$organization = mysqlClean($organization);
	$address1 = mysqlClean($address1);
	$address2 = mysqlClean($address2);
	$city = mysqlClean($city);
	$state = mysqlClean($state);
	$zip = mysqlClean($zip);
	$country = mysqlClean($country);
	$phone1 = mysqlClean($phone1);
	$phone2 = mysqlClean($phone2);
	$email = mysqlClean($email);
	$email2 = mysqlClean($email2);
	$fax = mysqlClean($fax);
	$url = mysqlClean($url);
	$discount = mysqlClean($discount);
	$terms_id = mysqlClean($terms_id);
	$salesrep_id = mysqlClean($salesrep_id);
	$notes = mysqlClean($notes);
	$tax = mysqlClean($tax);
	$lastupdated = currentDateTime();

	mysql_query("UPDATE accounts SET TYPEID='$typeid',ACCOUNT_NUMBER='$account_number', SEARCH_ID='$search_id', FIRST='$first', LAST='$last', ORGANIZATION='$organization', ADDRESS1='$address1', ADDRESS2='$address2', CITY='$city', STATE='$state', ZIP='$zip', COUNTRY='$country', PHONE1='$phone1', PHONE2='$phone2', EMAIL='$email', EMAIL2='$email2', FAX='$fax', URL='$url', DISCOUNT='$discount', TERMS_ID='$terms_id', SALESREP_ID='$salesrep_id', NOTES='$notes', TAX='$tax', BYPASS_INITIAL_MINIMUM='$bypass_initial_minimum', LOGINS='$logins', LASTLOGIN='$lastlogin', LASTLOGIN_IP='$lastlogin_ip', RESET_TOKEN='$reset_token', RESET_TOKEN_EXPIRES='$reset_token_expires', LASTUPDATED='$lastupdated', CREATED='$created' WHERE ID=$id") or die(mysql_error());
}
function accounts_shippingCreate($accountid, $name, $address1, $address2, $city, $state, $zip, $country, $instructions)
{
	$name = mysqlClean($name);
	$address1 = mysqlClean($address1);
	$address2 = mysqlClean($address2);
	$city = mysqlClean($city);
	$state = mysqlClean($state);
	$zip = mysqlClean($zip);
	$country = mysqlClean($country);
	$instructions = mysqlClean($instructions);
	$lastupdated = currentDateTime();
	$created = currentDateTime();

	mysql_query("INSERT INTO accounts_shipping(ACCOUNTID, NAME, ADDRESS1, ADDRESS2, CITY, STATE, ZIP, COUNTRY, INSTRUCTIONS, LASTUPDATED, CREATED) VALUES ('$accountid', '$name', '$address1', '$address2', '$city', '$state', '$zip', '$country', '$instructions', '$lastupdated', '$created')") or die(mysql_error());
	return mysql_insert_id();
}
function accounts_shippingUpdate($id, $accountid, $name, $address1, $address2, $city, $state, $zip, $country, $instructions)
{
	$name = mysqlClean($name);
	$address1 = mysqlClean($address1);
	$address2 = mysqlClean($address2);
	$city = mysqlClean($city);
	$state = mysqlClean($state);
	$zip = mysqlClean($zip);
	$country = mysqlClean($country);
	$instructions = mysqlClean($instructions);
	$lastupdated = currentDateTime();

	mysql_query("UPDATE accounts_shipping SET NAME='$name', ADDRESS1='$address1', ADDRESS2='$address2', CITY='$city', STATE='$state', ZIP='$zip', COUNTRY='$country', INSTRUCTIONS='$instructions', LASTUPDATED='$lastupdated' WHERE ID='$id' AND ACCOUNTID='$accountid'") or die(mysql_error());
}

function accountChangePassword($id,$password)
{
	$lastupdated = currentDateTime();
	mysql_query("UPDATE accounts SET PASSWORD='$password', LASTUPDATED='$lastupdated' WHERE ID=$id") or die(mysql_error());	
}
function deleteAccount($accountid)
{
	mysql_query("DELETE FROM accounts WHERE ID='$accountid'");
	mysql_query("DELETE FROM accounts_shipping WHERE ACCOUNTID='$accountid'");	
}
function deleteAccountShipping($id,$accountid)
{
	mysql_query("DELETE FROM accounts_shipping WHERE ID='$id' AND ACCOUNTID='$accountid'");
}
function uniqueEmailAccount($accountid,$email)
{
	$query = "SELECT ID FROM accounts WHERE ID!='$accountid' AND EMAIL='$email'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	if($row['ID'] == '')
		return true;
	else
		return false;
}
function accountEmails($accountid)
{
	$query = "SELECT EMAIL, EMAIL2 FROM accounts WHERE ID='$accountid'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row;
}
function validEmail2 ($email2){
	if($email2 == ""){
		return true;
	}

	$aEmail2 = explode(" ", $email2);

	$l = count($aEmail2);
	for($i = 0; $i < $l; $i++){
		if(!validEmail($aEmail2[$i])){
			return false;
		}
	}

	return true;
}
function createPassword($totalChar="")
{
	if($totalChar == "")
		$totalChar = 8; // number of chars in the password
	$salt = "abcdefghijklmnpqrstuvwxyz123456789";  // salt to select chars from
	srand((double)microtime()*1000000); // start the random generator
	$password=""; // set the inital variable
	for ($i=0;$i<$totalChar;$i++)  // loop and create password
        $password = $password . substr ($salt, rand() % strlen($salt), 1);
    return $password;
}
function processLogin($accountid)
{
	$datetime = currentDateTime();
	$query = "SELECT * FROM accounts WHERE ID='$accountid'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
	$logins = $row['LOGINS'];
	$logins++;
	$ip = $_SERVER['REMOTE_ADDR'];
	$query = "UPDATE accounts SET LOGINS='$logins',LASTLOGIN='$datetime',LASTLOGIN_IP='$ip' WHERE ID='$accountid'";
	$result = mysql_query($query) or die (mysql_error());
}
function accountFirstLastName($accountid)
{
	$query = "SELECT FIRST, LAST, ORGANIZATION FROM accounts WHERE ID='$accountid'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
	//if($row['ORGANIZATION'] != '')
	//	return $row['ORGANIZATION'];
	//else
		return $row['FIRST'].' '.$row['LAST'];
}
function accountName2($accountid)
{
	$query = "SELECT FIRST, LAST, ORGANIZATION FROM accounts WHERE ID='$accountid'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
	if($row['ORGANIZATION'] != '')
		return $row['ORGANIZATION'].' ('.$row['FIRST'].' '.$row['LAST'].')';
	else
		return $row['FIRST'].' '.$row['LAST'];
}
function termsName($id)
{
	$query = "SELECT NAME FROM accounts_terms WHERE ID='$id'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['NAME'];
}
function accountTypeName($id)
{
	$query = "SELECT NAME FROM accounts_types WHERE ID='$id'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['NAME'];
}
function accountIsRetail($id)
{
	$query = "SELECT TYPEID FROM accounts WHERE ID='$id'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	if(($row['TYPEID']>=2 && $row['TYPEID'] <= 5) || $row['TYPEID'] == 9)
		return false;
	else
		return true;
}
function accountCheckForWholesalerStatus($id)
{
	$query = "SELECT TYPEID FROM accounts WHERE ID='$id'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);

	if($row['TYPEID'] == 2 || $row['TYPEID'] == 3 || $row['TYPEID'] == 4 || $row['TYPEID'] == 9)
		return true;
	else
		return false;
}
function accountPassword($id)
{
	$query = "SELECT PASSWORD FROM accounts WHERE ID='$id'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['PASSWORD'];
}
function accountHasOrder($accountid)
{
	$query = "SELECT ID FROM orders WHERE ACCOUNTID='$accountid'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	if($row['ID'] == "")
		return false;
	else
		return true;
}
function clearSavedCart($accountid)
{
	$query = "UPDATE accounts SET SAVED_CART='' WHERE ID='$accountid'";
	$result = mysql_query($query) or die (mysql_error());
}
?>