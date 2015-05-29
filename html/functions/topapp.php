<?
/*
define("SMTP_HOST","host.realtimepriority.com");
define("SMTP_USERNAME","smtp@imaginecrafts.com");
define("SMTP_PASSWORD","dm9dmR1T[Wuv");
define("SITE_EMAIL","orders@imaginecrafts.com");
define("SMTP_PORT",25);
*/
define("SMTP_HOST","realtimepriority.com");
define("SMTP_USERNAME","smtp@imaginecrafts.com");
define("SMTP_PASSWORD","1Dq70QCW7AA0");
define("SITE_EMAIL","orders@imaginecrafts.com");
define("SMTP_PORT",25); //One of the following: 25, 80, 3535

define("SITE_NAME","Imagine Crafts");
define("TITLE","Imagine Crafts");
define("DISPLAY_RESULTS",50); //50
define("DISPLAY_RESULTS_PUBLIC",20); //20
define("SITE_URL","www.imaginecrafts.com");

define("ARGOFIRE_USERNAME","tubu2362");
define("ARGOFIRE_PASSWORD","V81886hY");

$mod_array = explode("/",$_GET['mod_name']);
$cart_array = $_SESSION['CART'];
//echo $_GET['mod_name'];
$mod = '';
$query_array = '';
$count = 0;
$count2 = 0;
$mod_toggle = false;

if ($mod_array[0] == 'search') {

  $mod = 'search';
  $mod_toggle = true;
  $qa = array();
  if (!empty($mod_array[1])) {
    $qa[0] = $mod_array[1];
  }

}

else {

  foreach($mod_array as $i) {
	$i = mysqlClean($i);
	if(!$mod_toggle && $i != "results" && $i != "view-grid" && $i != "view-single" && $i != "view-display" && $i != "no-view" && $i != "color-swatch" && $i != "delete-image" &&  $i != "view" && $i != "update" && $i != "edit" && $i != "reset" && $i != "delete" && $i != "medium" && $i != "aesthetic" && $i != "brand" && $i != "season" && $i != "type" && $i != "delete-medium" && $i != "delete-aesthetic" && $i != "delete-season" && $i != "delete-brand" && $i != "delete-type" && $i != "update-medium" && $i != "update-aesthetic" && $i != "update-season" && $i != "update-type" && $i != "update-brand" && ereg_replace("[^a-z-]","",$i) != '')
	{
		if($mod == '')
			$mod .= $i;
		else
			$mod .= '/'.$i;
	}
	else
	{
		$query_array[$count] = $i;
		$count++;
		$mod_toggle = true;
	}
	$count2++;
  }
  $qa = $query_array;

}

// PAGE INFO
$query = "SELECT * FROM content WHERE MOD_NAME='$mod'";
$result = mysql_query($query) or die ("error2" . mysql_error());
$content = mysql_fetch_array($result);
	
if($content['ID'] == '')
{
		$query = "SELECT * FROM content_301redirects WHERE ORIGINAL_MOD_NAME='$mod' LIMIT 1";
		$result = mysql_query($query) or die ("error2" . mysql_error());
		$row = mysql_fetch_array($result);
		if($row['ORIGINAL_MOD_NAME'] != "")
			httpRedirect("/".$row['NEW_MOD_NAME']);
		else
		{
			header("Status: 404 Not Found");
			$content['META_TITLE'] = 'Page Not Found';
		}
}
if($content['ID'] == '')
	$content['META_TITLE'] = 'Page Not Found';

if($content['SSL_MODE']) {
        // nonSSL(SITE_URL,$content['MOD_NAME']);
	checkSSL(SITE_URL,$content['MOD_NAME']);
} else
{
        checkSSL(SITE_URL,$content['MOD_NAME']);
	// nonSSL(SITE_URL,$content['MOD_NAME']);
	// updateContentStats($content['ID'],$content['HITS'],$content['ROBOT_HITS']);
}

if($_SESSION['USERID'] != '')
{
	$query = "SELECT * FROM accounts WHERE ID='".$_SESSION['USERID']."'";
	$result = mysql_query($query) or die ("error2" . mysql_error());
	$account = mysql_fetch_array($result);
	
	if((2 <= $account['TYPEID'] && $account['TYPEID'] <= 5) || $account['TYPEID'] == 9)
		$account['WHOLESALE'] = 1;
	else
		$account['WHOLESALE'] = 0;
}
if($content['TYPEID'] == 2 or $content['TYPEID'] == 3)
{
	if($account['ID'] == '')
		httpRedirect("/login");
	else
	{
		//CHECK ACCESS RIGHTS CODE HERE
	}
}
if($content['MODULE_PROCESSING'] != '')
	require_once("modules/".$content['MODULE_PROCESSING']);

$_POST = CleanArray($_POST); //ADDS ALL SLASHES - addslashes()
recoverCookieCart($content['MOD_NAME']);
//print_r($_COOKIE);
?>