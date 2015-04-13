<?
if($_POST['BUTTON'] == "Submit")
{
	$company = $_POST['COMPANY'];
	$contact_name = trim($_POST['CONTACT_NAME']);
	$nameArr = explode(" ", $contact_name);
	$first = $nameArr[0];
	$last = $nameArr[1];
	$email = trim($_POST['EMAIL']);
	$phone = $_POST['PHONE'];
	$fax = $_POST['FAX'];
	$resale_id = $_POST['RESALE_ID'];
	$address = $_POST['ADDRESS'];
	$apartment = $_POST['APARTMENT'];
	$city = $_POST['CITY'];
	$state = $_POST['STATE'];
	$zip = $_POST['ZIP'];
	$country = $_POST['COUNTRY'];
	$url = $_POST['URL'];
	$scrapbooking = $_POST['SCRAPBOOKING'];
	$rubber_stamping = $_POST['RUBBER_STAMPING'];
	$fabric_arts = $_POST['FABRIC_ARTS'];
	$gift_toy = $_POST['GIFT_TOY'];
	$chain_store = $_POST['CHAIN_STORE'];
	$other = $_POST['OTHER'];
	
	if($company == "")
		$error = "Please enter a company name.";
	else if($contact_name == "")
		$error = "Please enter a contact name.";
	else if($email == "" or !validEmail($email))
		$error = "Please enter a valid email address.";
	else if($address == "")
		$error = "Please enter an address.";
	else if($city == "")
		$error = "Please enter a city.";
	else if($state == "")
		$error = "Please enter a state.";
	else if($zip == "" && $country == "United States")
		$error = "Please enter a zip code.";
	else if($_POST['VERIFICATION'] != $_SESSION['digit'])
		$error = "The validation numbers you typed in do not match. Please try again.";
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
                  $custTypeArr["groups"] = array("Wholesale");
                  $subscribeArr = array();
                  $subscribeArr["name"] = "Subscription Options";
                  $subscribeArr["groups"] = $chimpSubscriptionArr;                     
                  $chimpArr["merge_vars"]["groupings"][]= $custTypeArr;          
                  $chimpArr["merge_vars"]["groupings"][]= $subscribeArr;
                  $chimpArr["merge_vars"]["FIRSTNAME"] = $first;
                  $chimpArr["merge_vars"]["LASTNAME"] = $last;                  
                  $theChimpSays = $chimpy->call("/lists/subscribe", $chimpArr);
                                                      
                }

		$message = '<font face="Arial" size="3">Company: '.$company.'<br />Name: '.$contact_name.'<br />Email Address: '.$email.'<br />Phone: '.$phone.'<br />Fax: '.$fax.'<br /><br />Resale ID: '.$resale_id.'<br /><br />Address: '.$address;
		if($apartment != "")
			$message .= '<br />Address 2: '.$apartment;
		$message .= '<br />'.$city.', '.$state.' '.$zip.'<br />'.$country.'<br /><br />URL: '.$url;
		$message .= '<br /><br />Interest:';
		if($scrapbooking)
			$message .= '<br />- Scrapbooking';
		if($rubber_stamping)
			$message .= '<br />- Rubber Stamping';
		if($fabric_arts)
			$message .= '<br />- Fabric Arts';
		if($gift_toy)
			$message .= '<br />- Gift Toy';
		if($chain_store)
			$message .= '<br />- Chain Store';
		if($other != "")
			$message .= '<br />- '.$other;
		//$message .= '<br /><br />Submitted '.datetimeformat(currentDateTime());
		
		// auto_email("sales@imaginecrafts.com","Imagine Crafts: Wholesaler Application",$message);
		// auto_email("rias@imaginecrafts.com","Imagine Crafts: Wholesaler Application",$message);

		
		$_SESSION['STATUS'] = "Thank you! Your application has been submitted and will be reviewed shortly.";
		httpRedirect("/".$content['MOD_NAME']);
	}
}
else
{
	$contact_name = $account['FIRST'].' '.$account['LAST'];
	$company = $account['ORGANIZATION'];
	$email = $account['EMAIL'];
	$phone = $account['PHONE1'];
	$fax = $account['FAX'];
	$resale_id = $account['RESALE_ID'];
	$address = $account['ADDRESS1'];
	$apartment = $account['ADDRESS2'];
	$city = $account['CITY'];
	$state = $account['STATE'];
	$zip = $account['ZIP'];
	$country = $account['COUNTRY'];
}
?>