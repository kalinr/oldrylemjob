<?
if($_POST['BUTTON'] == "Sign Up!")
{
	$first = $_POST['FIRST'];
	$last = $_POST['LAST'];
	$organization = $_POST['ORGANIZATION'];
	$address = $_POST['ADDRESS'];
	$city = $_POST['CITY'];
	$state = $_POST['STATE'];
	$zip = $_POST['ZIP'];
	$country = $_POST['COUNTRY'];
	$usage = $_POST['USAGE'];
	$customer_type = $_POST['CUSTOMER_TYPE'];
	$email = $_POST['EMAIL'];
	
	if($first == "")
		$error = "Please enter a first name.";
	else if($last == "")
		$error = "Please ender a last name.";
	else if($state == "")
		$error = "Please enter a state/province.";
	else if($zip == "")
		$error = "Please enter a zip/postal code.";
	else if($email == "" or !validEmail($email))
		$error = "Please enter a valid email address";
	else
	{
		enewsCreate($first, $last, $organization, $address, $city, $state, $zip, $country, $phone, $email, $usage, $customer_type);
		
		$message = "$first $last<br />$organization<br />Email: $email<br />Zip Code: $zip<br />Country: $country<br />Use: $usage<br />Customer Type: $customer_type";
		//smtpEmail("amyh@imaginecrafts.com","Mailing List Sign Up - $first $last",$message);
		smtpEmail("rias@imaginecrafts.com","Mailing List Sign Up - $first $last",$message);
		//smtpEmail("erics121@comcast.net","Mailing List Sign Up - $first $last",$message);
			
		httpRedirect("/".$content['MOD_NAME']."/0/confirmation");
	}
}
else
{
	$country = "United States";
	$customer_type = "Retail";
	$usage = "Paper Arts";
}
?>