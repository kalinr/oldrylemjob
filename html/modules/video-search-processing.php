<?
if($_POST['BUTTON'] == "Search")
{
	$_SESSION['VIDEO']['SEARCH'] = mysqlClean($_POST['SEARCH']);
	httpRedirect("/".$content['MOD_NAME']."/1");
}
if($qa[0] == "reset")
{
	unset($_SESSION['VIDEO']['SEARCH']);
	httpRedirect("/".$content['MOD_NAME']);
}
include("modules/videos-categories-processing.php");
?>