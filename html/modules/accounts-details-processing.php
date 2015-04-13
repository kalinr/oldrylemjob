<?
if($content['ID'] == 10 && $_SESSION['CUSTOMERID'] == "")
{
	if($account['ID'] != "")
		httpRedirect("/login");
	$query_array[0] = "edit";
}
if($content['ID'] == 10)
{
	$query_array[1] = $_SESSION['CUSTOMERID'];
}
if($_POST['BUTTON'] == "Save" or $_POST['BUTTON'] == "Continue" or $_POST['BUTTON'] == "Save and Add Shipping Address >>" or $_POST['BUTTON'] == "Submit")
{
	$typeid = $_POST['TYPEID'];
	if($content['ID'] == 10)
		$typeid = 1;
	$account_number = trim($_POST['ACCOUNT_NUMBER']);
	$search_id = trim($_POST['SEARCH_ID']);
	$first = trim($_POST['FIRST']);
	$last = trim($_POST['LAST']);
	$organization = trim($_POST['ORGANIZATION']);
	$address1 = trim($_POST['ADDRESS1']);
	$address2 = trim($_POST['ADDRESS2']);
	$city = trim($_POST['CITY']);
	$state = trim($_POST['STATE']);
	$zip = trim($_POST['ZIP']);
	$country = $_POST['COUNTRY'];
	$phone1 = trim($_POST['PHONE1']);
	$phone2 = trim($_POST['PHONE2']);
	$email = trim(mysqlClean(strtolower($_POST['EMAIL'])));
	$fax = trim($_POST['FAX']);
	$url = trim($_POST['URL']);
	$discount = ereg_replace("[^0-9.-]","",$_POST['DISCOUNT']);
	$terms_id = $_POST['TERMS_ID'];
	$salesrep_id = $_POST['SALESREP_ID'];
	$notes = $_POST['NOTES'];
	$tax = $_POST['TAX'];
	$bypass_initial_minimum = $_POST['BYPASS_INITIAL_MINIMUM'];
	
	if(($first == "" OR $last == "") && $organization == "")
		$error = "Please enter first and last or organization name.";
	else if($content['ID'] != 4 && $address1 == "")
		$error = "Please enter an address.";
	else if($content['ID'] != 4 && $city == "")
		$error = "Please enter a city.";
	else if($content['ID'] != 4 && $state == "")
		$error = "Please enter a state.";
	else if($content['ID'] != 4 && $zip == "")
		$error = "Please enter a zip code.";
	else if($content['ID'] != 4 && ($phone1 == "" && $phone2 == ""))
		$error = "Please enter a phone number.";
	else if($email == "" or !validEmail($email))
		$error = "Please enter a valid email address.";
	else if(!uniqueEmailAccount($query_array[1],$email))
		$error = "The email $email is in use by another customer or account.";
	else
	{
	
                // mailchimp integration
                $triggerChimp = false;
                $craftIdeas = false;
                $productNews = false;
                
                if (isset($_POST['craft_project_ideas']) && !empty($_POST['craft_project_ideas']) && $_POST['craft_project_ideas'] == '1') {
                  $triggerChimp = true;
                  $craftIdeas = true;
                }
                                
                if (isset($_POST['product_announcements']) && !empty($_POST['product_announcements']) && $_POST['product_announcements'] == '1') {
                  $triggerChimp = true;
                  $productNews = true;                
                }
                                      
                if ($triggerChimp) {
                
                  require 'mc/Mailchimp.php';                  
                  $chimpSubscriptionArr = array();
                                    
                  if ($craftIdeas) {
                    $chimpSubscriptionArr[]= 'Receive wonderful craft project ideas through our blog';
                  }
                  if ($productNews) {
                    $chimpSubscriptionArr[]= 'Receive important new product announcements and information';
                  }                 
                                    
                  $chimpy = new Mailchimp('9e5b4ea162e40db1d3dda178a9de8082-us7');
                  $chimpArr = array();
                  $chimpArr["apikey"] = "9e5b4ea162e40db1d3dda178a9de8082-us7";
                  $chimpArr["id"] = "157580261d";
                  $chimpArr["email"] = array();
                  $chimpArr["email"]["email"] = $email;
                  $chimpArr["merge_vars"] = array();                  
                  $chimpArr["merge_vars"]["groupings"] = array();
                  $custTypeArr = array();
                  $custTypeArr["name"] = "Customer type";
                  $custTypeArr["groups"] = array("Consumer");
                  $subscribeArr = array();
                  $subscribeArr["name"] = "Subscription Options";
                  $subscribeArr["groups"] = $chimpSubscriptionArr;                     
                  $chimpArr["merge_vars"]["groupings"][]= $custTypeArr;          
                  $chimpArr["merge_vars"]["groupings"][]= $subscribeArr;
                  $chimpArr["merge_vars"]["FIRSTNAME"] = $first;
                  $chimpArr["merge_vars"]["LASTNAME"] = $last;                  
                  $theChimpSays = $chimpy->call("/lists/subscribe", $chimpArr);
                                                      
                }

		$discount = $discount / 100;
		if($query_array[1] == '')
		{
			if($content['ID'] == 10)
				$bypass_initial_minimum = 1;
			$accountid = accountsCreate($typeid, $account_number, $search_id, $first, $last, $organization, $address1, $address2, $city, $state, $zip, $country, $phone1, $phone2, $email, $fax, $url, $discount, $terms_id, $salesrep_id, $notes, $tax, $bypass_initial_minimum);
			if($content['ID'] == 10) {

                          // $message = "Here is the Imagine Crafts password that has been automatically generated for you:<b> ".accountPassword($accountid)."</b>";

                          $message = '<img src="http://www.imaginecrafts.com/images/email-logo.png" /><br /><br />';
                          $message .= 'Welcome to IMAGINE Crafts! Thank you for creating an account. Here is your automatically generated password: <b>' . accountPassword($accountid) . "</b><br /><br />";
                          $message .= 'Visit <a href="http://www.imaginecrafts.com">www.imaginecrafts.com</a> to change your password or complete your order.';
                          $message .= "<br /><br /><br />";
                          $message .= '<a href="http://www.imaginecrafts.com/mailing-list">Sign up for our mailing list</a> for the latest projects, giveaway news, and more.';

			  smtpEmail($email,"Imagine Crafts Password",$message);
			  //smtpEmail("sales@imaginecrafts.com","Imagine Crafts Password",$message);
				
			  $newcustemail = "<b>New Customer Signup Alert:</b><br><br>".$first." ".$last."<br>".$email;
			  // smtpEmail("sales@imaginecrafts.com","STAFF COPY, NEW CUSTOMER - Imagine Crafts Password",$newcustemail);
				
			  $_SESSION['STATUS'] = "Thank you! An account password has been emailed to you. Please complete at least one shipping address for your account using the form below.";
			  $_SESSION['CUSTOMERID'] = $accountid;
			  $_SESSION['USERID'] = $accountid;
			
			        if($qa[0] == 79)
					httpRedirect("/checkout/shipping");
				else
					httpRedirect("/customer-entry/profile/shipping/".$accountid);
			}	
			else
				httpRedirect("/admin/customers/profile/shipping/".$accountid);
		}
		else
		{
			accountsUpdate($query_array[1], $typeid, $account_number, $search_id, $first, $last, $organization, $address1, $address2, $city, $state, $zip, $country, $phone1, $phone2, $email, $password, $fax, $url, $discount, $terms_id, $salesrep_id, $notes, $tax,$bypass_initial_minimum);
			httpRedirect("/".$content['MOD_NAME']."/".$query_array[1]);
		}	
		
	}
}
else if(ereg_replace("[^0-9]","",$query_array[0] != '') || ereg_replace("[^0-9]","",$query_array[1] != ''))
{
	if($query_array[0] == "edit")
		$query = "SELECT * FROM accounts WHERE ID='".$query_array[1]."'";
	else
		$query = "SELECT * FROM accounts WHERE ID='".$query_array[0]."'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	$typeid = $row['TYPEID'];
	$account_number = $row['ACCOUNT_NUMBER'];
	$search_id = $row['SEARCH_ID'];
	$first = $row['FIRST'];
	$last = $row['LAST'];
	$organization = $row['ORGANIZATION'];
	$address1 = $row['ADDRESS1'];
	$address2 = $row['ADDRESS2'];
	$city = $row['CITY'];
	$state = $row['STATE'];
	$zip = $row['ZIP'];
	$country = $row['COUNTRY'];
	$phone1 = $row['PHONE1'];
	$phone2 = $row['PHONE2'];
	$email = $row['EMAIL'];
	$password = $row['PASSWORD'];
	$fax = $row['FAX'];
	$url = $row['URL'];
	$discount = $row['DISCOUNT'] * 100;
	$terms_id = $row['TERMS_ID'];
	$salesrep_id = $row['SALESREP_ID'];
	$notes = $row['NOTES'];
	$tax = $row['TAX'];
	$bypass_initial_minimum = $row['BYPASS_INITIAL_MINIMUM'];
	$logins = $row['LOGINS'];
	$lastlogin = $row['LASTLOGIN'];
	$lastlogin_ip = $row['LASTLOGIN_IP'];
	$reset_token = $row['RESET_TOKEN'];
	$reset_token_expires = $row['RESET_TOKEN_EXPIRES'];
	$lastupdated = $row['LASTUPDATED'];
	$created = $row['CREATED'];
}
else if($content['ID'] == 10)
{
	$tax = 0;
	
}
if($country == "")
	$country = "United States";
?>