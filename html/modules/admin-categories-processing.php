<?
if($_POST['BUTTON'] == "Save")
{
	$name = TRIM($_POST['NAME']);
	$top_order = ereg_replace("[^0-9]","",$_POST['TOP_ORDER']);
	
	if($name == "")
		$error = "Please type in a name for this category.";
	else
	{
		if($qa[1] == "")
			$qa[1] = categoriesCreate($name, $top_order);
		else
			categoriesUpdate($qa[1], $name, $top_order);
		httpRedirect("/".$content['MOD_NAME']);
	}
}
else if($qa[0] == "delete")
{
	categoriesDelete($qa[1]);
	httpRedirect("/".$content['MOD_NAME']);
}
else if($qa[1] != "")
{
	$query = "SELECT * FROM categories WHERE ID='".$qa[1]."'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	$name = $row['NAME'];
	$top_order = $row['TOP_ORDER'];
}
else if($qa[0] == "edit")
{
	$top_order = 1;
}
?>