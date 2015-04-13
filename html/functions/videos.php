<?
//videos
function videosCreate($contentid, $vimeo_embed, $thumb_filename, $title, $meta_description, $meta_keywords, $body, $active, $categories_array)
{
	$contentid = mysqlClean($contentid);
	$vimeo_embed = mysqlClean($vimeo_embed);
	$thumb_filename = mysqlClean($thumb_filename);
	$active = mysqlClean($active);
	
	$mod_name = generateModName2(0,"videos/".$title);
	$contentid = contentCreate2(1, 5, $mod_name, $title, $title, $meta_description, $meta_keywords, "", $body, "video-processing.php", "", "video-body.php", 0, ".20", 1, $active);

	mysql_query("INSERT INTO videos(CONTENTID, VIMEO_EMBED, THUMB_FILENAME) VALUES ('$contentid', '$vimeo_embed', '$thumb_filename')") or die(mysql_error());
	$id = mysql_insert_id();
	//categories
	mysql_query("DELETE FROM videos_categories_affiliations WHERE VIDEOID='$id'") or die(mysql_error());
	if(sizeof($categories_array) > 0)
	{
		foreach($categories_array as $categoryid)
		{
			mysql_query("INSERT INTO videos_categories_affiliations(VIDEOID, CATEGORYID) VALUES ('$id','$categoryid')");
		}
	}
	return $id;
}
function videosUpdate($id, $contentid, $vimeo_embed, $thumb_filename, $title, $meta_description, $meta_keywords, $body, $active, $categories_array)
{
	$contentid = mysqlClean($contentid);
	$vimeo_embed = mysqlClean($vimeo_embed);
	$thumb_filename = mysqlClean($thumb_filename);
	
	contentUpdate2($contentid, 1, 5, $title, $title, $meta_description, $meta_keywords, "", $body, "video-processing.php", "", "video-body.php", 0, ".20", 1, $active);

	mysql_query("UPDATE videos SET VIMEO_EMBED='$vimeo_embed', THUMB_FILENAME='$thumb_filename' WHERE ID='$id'") or die(mysql_error());

	//categories
	mysql_query("DELETE FROM videos_categories_affiliations WHERE VIDEOID='$id'") or die(mysql_error());
	if(sizeof($categories_array) > 0)
	{
		foreach($categories_array as $categoryid)
		{
			mysql_query("INSERT INTO videos_categories_affiliations(VIDEOID, CATEGORYID) VALUES ('$id','$categoryid')") or die(mysql_error());
		}
	}
}
function videosDelete($id)
{
	$query = "SELECT * FROM videos WHERE ID='$id' LIMIT 1";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	$contentid = $row['CONTENTID'];
	contentDelete2($contentid);
	$filename = "images/videos/".$row['THUMB_FILENAME'];
	if($row['THUMB_FILENAME'] != '' && file_exists($filename))
		unlink($filename);
	mysql_query("DELETE FROM videos WHERE ID='$id'") or die(mysql_error());
	mysql_query("DELETE FROM videos_categories_affiliations WHERE VIDEOID='$id'") or die(mysql_error());
}
function videosDeleteImage($id)
{
	$query = "SELECT * FROM videos WHERE ID='$id' LIMIT 1";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	$filename = "images/videos/".$row['THUMB_FILENAME'];
	if($row['THUMB_FILENAME'] != '' && file_exists($filename))
		unlink($filename);
	mysql_query("UPDATE videos SET THUMB_FILENAME='' WHERE ID='$id'") or die(mysql_error());
}
function countVideoCategories($id)
{
	$query = "SELECT COUNT(VIDEOID) AS COUNT FROM videos_categories_affiliations WHERE VIDEOID='$id'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['COUNT'];
}
//categories
function videos_categoriesCreate($contentid, $name)
{
	$name = mysqlClean($name);

	mysql_query("INSERT INTO videos_categories(CONTENTID, NAME) VALUES ('$contentid', '$name')") or die(mysql_error());
	return mysql_insert_id();
}
function videoCategoryContentIDToCategoryID($contentid)
{
	$query = "SELECT ID FROM videos_categories WHERE CONTENTID='$contentid' LIMIT 1";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['ID'];
}
/*
function videos_categoriesUpdate($id, $name)
{
	$name = mysqlClean($name);

	mysql_query("UPDATE videos_categories SET NAME='$name' WHERE ID=$id") or die(mysql_error());
}
*/
?>