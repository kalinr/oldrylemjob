<?
if($_POST['BUTTON'] == "Upload")
{
	if(!fileUpload("documents/", $_FILES['FILE']['name'], "FILE"))
	{
	//	$error = "There was a problem uploading the file.";
	}
}
else if($qa[1] == "delete" && $qa[2] != "")
{
	$filename = "documents/".$qa[2];
	if(file_exists($filename))
		unlink($filename);
}
?>