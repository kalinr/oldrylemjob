<?
if($qa[0] == "reset" or $qa[1] == "reset")
{
	unset($_SESSION['VIDEO']['SEARCH']);
	httpRedirect("/".$content['MOD_NAME']);
}
?>