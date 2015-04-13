<?
if($_POST['BUTTON'] == "Search")
{
	$search = trim(mysqlclean($_POST['SEARCH']));
	unset($_SESSION['ADMIN']['ACCOUNTS']['SEARCH']);
}
else if($qa[0] == "reset")
{
	unset($_SESSION['ADMIN']['ACCOUNTS']['SEARCH']);
	httpRedirect("/".$content['MOD_NAME']);
}
?>