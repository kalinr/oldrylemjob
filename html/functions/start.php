<?
session_start();

require_once("functions/db.php");
require_once("functions/accounts.php");
require_once("functions/general.php");
require_once("functions/formatting.php");
require_once("functions/outgoingemail.php");
require_once("functions/sitemap.php");
require_once("functions/validation.php");
require_once("functions/cms.php");
require_once("functions/useragent.php");
require_once("functions/datetime.php");
require_once("functions/cron.php");
require_once("functions/creditcards.php");
require_once("functions/Mail.php");
require_once("functions/site.php");
require_once("functions/fileimage.php");
require_once("functions/encryption.php");
require_once("functions/categories.php");
require_once("functions/promocodes.php");
require_once("functions/hottext.php");
require_once("functions/products.php");
require_once("functions/mailing-list.php");
require_once("functions/shoppingcart.php");
require_once("functions/cart-cookie.php");
require_once("functions/checkout.php");
require_once("functions/orders.php");
require_once("functions/editable-pages.php");
require_once("functions/shipping.php");
require_once("functions/videos.php");
require_once("functions/reporting.php");
require_once("functions/buroware.php");


if (!isset($_SESSION['CREATED']))
    {
	// do nothing
	//$_SESSION['CREATED'] = time();
	}
else if (time() - $_SESSION['CREATED'] > 3600 && isset($_SESSION['USERID']))       // session started more than 60 (3600 SECONDS) minutes ago with no activity
{
	unset($_SESSION['USERID']);
	//session_destroy();
	//session_start();
	$_SESSION['STATUS'] = "Your session has expired due to inactivity.  You may log in and continue shopping now.";
	//httpRedirect("/login?e=1");
	httpRedirect("/login");
}

//echo time() - $_SESSION['CREATED'];
$_SESSION['CREATED'] = time();

if(currentFile() != ".")
	require_once("functions/topapp.php");
?>