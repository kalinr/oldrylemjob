<?
if($qa[0] != "")
{
	if($qa[0] > 0)
	{
		$query = "SELECT videos.CONTENTID, videos.VIMEO_EMBED, videos.THUMB_FILENAME, content.* FROM videos, content WHERE videos.CONTENTID=content.ID AND videos.ID='".$qa[0]."' LIMIT 1";
		$result = mysql_query($query) or die ("error1" . mysql_error());
		$row = mysql_fetch_array($result);
		$contentid = $row['CONTENTID'];
		$title = $row['TITLE'];
		$meta_description = $row['META_DESCRIPTION'];
		$meta_keywords = $row['META_KEYWORDS'];
		$body = $row['BODY'];
		$active = $row['ACTIVE'];
		$vimeo_embed = $row['VIMEO_EMBED'];
		$thumb_filename = $row['THUMB_FILENAME'];
		
		$count = 0;
		$query = "SELECT CATEGORYID FROM videos_categories_affiliations WHERE VIDEOID='".$qa[0]."'";
		$result = mysql_query($query) or die ("error1" . mysql_error());
		while($row = mysql_fetch_array($result))
		{
			$categories_array[$count] = $row['CATEGORYID'];
			$count++;
		}
	}
	if($_POST['BUTTON'] == "Save")
	{
		$vimeo_embed = $_POST['VIMEO_EMBED'];
		$title = $_POST['TITLE'];
		$meta_description = $_POST['META_DESCRIPTION'];
		$meta_keywords = $_POST['META_KEYWORDS'];
		$body = $_POST['BODY'];
		$active = $_POST['ACTIVE'];
		$categories_array = $_POST['CATEGORIES_ARRAY'];
		
		if($title == "")
			$error = "Please enter a title.";
		else if($vimeo_embed == "")
			$error = "Please enter vimeo embed code.";
		else if(sizeof($categories_array) == 0)
			$error = "Please select at least one category.";
		else
		{
			if($_FILES['IMAGE']['name'] != "")
			{
				if($thumb_filename != "" && file_exists("images/videos/".$thumb_filename))
				{
					if($thumb_filename != "" && file_exists("images/videos/".$thumb_filename))
						unlink("images/videos/".$thumb_filename);
					mysql_query("UPDATE videos SET THUMB_FILENAME='' WHERE ID='".$qa[0]."'") or die(mysql_error());
				}
				if($qa[0] == 0)
					$filename = nextID("videos").$_FILES['IMAGE']['name'];
				else
					$filename = $qa[0].$_FILES['IMAGE']['name'];
				$thumb_filename = cleanFilename($filename);
				//moveUploadedImage("IMAGE");
				//$size_array = getimagesize("uploads/".$_FILES['PHOTO']['name']);
				imageUpload(800,"images/videos/",$thumb_filename);
				imageThumbCropper("images/videos/".$thumb_filename, 125, 125);
				/*
				if($size_array[0] > 250 or $size_array[1] > 250)
				{
					include_once("functions/image-sizer.php");
					$image = new SimpleImage();
					$image->load("uploads/".$_FILES['IMAGE']['name']);
  					$image->resize(125,125);
   					//$image->resizeToWidth(125);
   					$image->save("images/videos/".$thumb_filename);
   					unlink("uploads/".$_FILES['IMAGE']['name']);
   				}
   				else
   					moveUploadedDocument("images/videos/",$_FILES['IMAGE']['name'],$thumb_filename);
   				*/
			}


			if($qa[0] == 0)
				videosCreate($contentid, $vimeo_embed, $thumb_filename, $title, $meta_description, $meta_keywords, $body, $active, $categories_array);
			else
				videosUpdate($qa[0], $contentid, $vimeo_embed, $thumb_filename, $title, $meta_description, $meta_keywords, $body, $active, $categories_array);
				
			httpRedirect("/".$content['MOD_NAME']);
		}
	}
	else if($qa[1] == "delete")
	{
		videosDelete($qa[0]);
		httpRedirect("/".$content['MOD_NAME']);
	}
	else if($qa[1] == "delete-image")
	{
		if($thumb_filename != "" && file_exists("images/videos/".$thumb_filename))
			unlink("images/videos/".$thumb_filename);
		mysql_query("UPDATE videos SET THUMB_FILENAME='' WHERE ID='".$qa[0]."'") or die(mysql_error());
		httpRedirect("/".$content['MOD_NAME']."/".$qa[0]);
	}
	else if($qa[0] == 0)
	{
		$active = 1;
	}
}
?>