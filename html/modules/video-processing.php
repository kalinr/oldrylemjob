<?
if($qa[0] == "reset" or $qa[1] == "reset")
{
	unset($_SESSION['VIDEO']['SEARCH']);
	httpRedirect("/".$content['MOD_NAME']);
}
$query = "SELECT * FROM videos WHERE CONTENTID='".$content['ID']."' LIMIT 1";
$result = mysql_query($query) or die ("error1" . mysql_error());
$video = mysql_fetch_array($result);
?>