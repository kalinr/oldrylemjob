<?
if($_POST['BUTTON'] == "Save")
{
	$first = $_POST['FIRST'];
	$last = $_POST['LAST'];
	$organization = $_POST['ORGANIZATION'];
	$address1 = $_POST['ADDRESS1'];
	$address2 = $_POST['ADDRESS2'];
	$city = $_POST['CITY'];
	$state = $_POST['STATE'];
	$zip = $_POST['ZIP'];
	$country = $_POST['COUNTRY'];
	$phone1 = $_POST['PHONE1'];
	$phone2 = $_POST['PHONE2'];
	$email = $_POST['EMAIL'];
	$fax = $_POST['FAX'];
	$url = $_POST['URL'];
	
	if($first == "" or $last == "" or $organization == "")
		$error = "Please enter first and last or organization name.";
	if($email == "" or !validEmail($email))
		$error = "Please enter a valid email address.";
	else if(!uniqueEmailAccount($account['ID'],$email))
		$error = "The email $email is in use by another customer or account.";
	else
	{
		if($account['EMAIL'] != $email)
			emailChangeNotification($account['ID'],$account['EMAIL'],$email);
		accountsUpdate($account['ID'], $account['TYPEID'], $account['ACCOUNT_NUMBER'], $account['SEARCH_ID'], $first, $last, $organization, $address1, $address2, $city, $state, $zip, $country, $phone1, $phone2, $email, $password, $fax, $url, $account['DISCOUNT'], $account['TERMS_ID'], $account['SALESREP_ID'], $account['NOTES'], $account['TAX'], $account['BYPASS_INITIAL_MINIMUM']);
		
		$_SESSION['STATUS'] = "Account information has been saved.";
		httpRedirect("/".$content['MOD_NAME']);
	}
}
else if($account['ID'] != "")
{
	$first = $account['FIRST'];
	$last = $account['LAST'];
	$organization = $account['ORGANIZATION'];
	$address1 = $account['ADDRESS1'];
	$address2 = $account['ADDRESS2'];
	$city = $account['CITY'];
	$state = $account['STATE'];
	$zip = $account['ZIP'];
	$country = $account['COUNTRY'];
	$phone1 = $account['PHONE1'];
	$phone2 = $account['PHONE2'];
	$email = $account['EMAIL'];
	$fax = $account['FAX'];
	$url = $account['URL'];
}
else
	$country = "United States";
?>