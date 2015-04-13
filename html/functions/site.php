<?
function siteEmail($siteid)
{
	$query = "SELECT * FROM sites WHERE ID='$siteid'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
	return $row['EMAIL'];
}
?>