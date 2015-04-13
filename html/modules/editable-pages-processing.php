<?
if($qa[0] > 0)
{
	$query = "SELECT * FROM content WHERE ID='".$qa[0]."' AND EDITABLE='1'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$content_edit = mysql_fetch_array($result);
	if($content_edit['ID'] == "")
		httpRedirect("/".$content['MOD_NAME']);
}
if($_POST['BUTTON'] == "Save")
{
	$title = trim($_POST['TITLE']);
	$meta_title = trim($_POST['META_TITLE']);
	$meta_keywords = trim($_POST['META_KEYWORDS']);
	$meta_description = trim($_POST['META_DESCRIPTION']);
	$button_title = "";
	$body = $_POST['BODY'];
	$top_order = 0;
	$active = $_POST['ACTIVE'];
	
	if($title == "")
		$error = "Please enter a title for this page.";
	else if($body == "")
		$errir = "Please enter body text.";
	else
	{
		if($meta_title == "")
			$meta_title = $title;
		if($qa[0] == 0)
			$qa[0] = contentCreate($title, $meta_title, $meta_description, $meta_keywords, $button_title, $body, $top_order, $active);
		else
			contentUpdate($qa[0], $title, $meta_title, $meta_description, $meta_keywords, $button_title, $body, $top_order, $active, $content_edit['EDITABLE'], $content_edit['DELETABLE']);
		
		httpRedirect("/".$content['MOD_NAME']);
	}
}
else if($qa[1] == "delete")
{
	contentDelete($qa[0]);
	httpRedirect("/".$content['MOD_NAME']);
}
else if($qa[0] != "")
{
	$title = $content_edit['TITLE'];
	$meta_title = $content_edit['META_TITLE'];
	$meta_keywords = $content_edit['META_KEYWORDS'];
	$meta_description = $content_edit['META_DESCRIPTION'];
	$body = $content_edit['BODY'];
	$active = $content_edit['ACTIVE'];
}
else
{
	$active = 1;
}
?>