<? if($qa[0] != ''){ ?>
<form action="/<? echo $content['MOD_NAME']; ?>/<? echo $qa[0]; ?>" method="post" enctype="multipart/form-data" id="myform">
<p>Title<input type="text" name="TITLE" value="<? echo stripslashes($title); ?>" /></p>
<p>Summary<input type="text" name="META_DESCRIPTION" value="<? echo stripslashes($meta_description); ?>" /></p>
<p>Keywords<input type="text" name="META_KEYWORDS" value="<? echo stripslashes($meta_keywords); ?>" /></p>
<? /* <p>Body of Page<textarea name="BODY"><? echo stripslashes($body); ?></textarea></p> */ ?>
<p><? $CKEditor->editor("BODY", $body); ?></p>
<p>Embed Code from Vimeo<textarea name="VIMEO_EMBED"><? echo stripslashes($vimeo_embed); ?></textarea></p>
<fieldset>
<legend>Video Thumbnail</legend>
<?
	if($thumb_filename != "" && file_exists("images/videos/".$thumb_filename))
	{
		echo '<p><img src="/images/videos/'.$thumb_filename.'" /><br /><a href="javascript:confirmDeleteImage()">delete image</a></p>';
	}
?>
<div>Image Upload (JPG, PNG, GIF)<br /><input type="file" name="IMAGE" /></div>
</fieldset>
<fieldset>
<legend>Categories</legend>
<?
$query = "SELECT * FROM videos_categories ORDER BY NAME";
$result = mysql_query($query) or die ("error1" . mysql_error());
while($row = mysql_fetch_array($result))
{
	if(is_array($categories_array) && in_array($row['ID'],$categories_array))
		$checked = " checked";
	else
		$checked= "";
	echo '<div style="width: 240px; float: left;"><input type="checkbox" name="CATEGORIES_ARRAY[]" value="'.$row['ID'].'" value="1"'.$checked.' /> '.stripslashes($row['NAME']).'</div>';
}
?>
</fieldset>
<p><input type="checkbox" name="ACTIVE" value="1"<? if($active){ echo ' checked'; } ?> /> Active (display on website)</p>
<p><input type="submit" name="BUTTON" value="Save" /><? if($qa[0] > 0){ ?> <input type="button" name="BUTTON" value="Delete" onclick="javaascript:confirmDelete()" /><? } ?></p>
</form>
<? }else{ ?>
<form action="/<? echo $content['MOD_NAME']; ?>" method="post" id="myform">
<p>Search: <input type="text" onfocus="this.select()" name="SEARCH" value="<? echo stripslashes($_SESSION['ADMIN']['VIDEOS']['SEARCH']); ?>" style="display:inline;" />&nbsp;&nbsp;<input type="submit" name="BUTTON" value="Search" style="width:90px" /> <input type="button" onclick="javascript:window.location='/<? echo $content['MOD_NAME']; ?>/0'" value="Create" style="width:90px" /></p>
</form>
<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:100%">
<tr>
	<th>Video Title</th>
	<th style="width: 50px; text-align: center;">Categories</th>
	<th style="text-align: center; width: 40px;">Active</th>
</tr>
<?
	if($_SESSION['ADMIN']['VIDEO']['CURRENT_RESULT'] != "")
		$current_result = $_SESSION['ADMIN']['VIDEO']['CURRENT_RESULT'];
	else
		$current_result = $qa[0];
	if($_SESSION['ADMIN']['VIDEO']['SEARCH'] != "")
		$search = $_SESSION['ADMIN']['VIDEO']['SEARCH'];
	
	if($current_result == "" or $current_result < 1)
		$current_result = 1;
	$limit = ($current_result-1)*DISPLAY_RESULTS.','.DISPLAY_RESULTS;
	
	$filter = "";
	if($search != '')
	{
		$terms = explode(' ', $search);
		foreach ($terms as $term)
			if ($term != '')
				$filter .= " AND CONCAT('|||',TITLE,'|||',BODY,'|||',META_DESCRIPTION,'|||') LIKE '%$term%'";
	}
			
	$query = "SELECT SQL_CALC_FOUND_ROWS videos.ID, content.TITLE, content.ACTIVE FROM videos, content WHERE videos.CONTENTID=content.ID $filter ORDER BY TITLE LIMIT $limit";
	$results = mysql_query($query) or die(mysql_error());
	$countquery = "SELECT FOUND_ROWS() AS FOUND";
	$countresults = mysql_fetch_array(mysql_query($countquery));
	$totalcount = $countresults['FOUND'];
	$count2 = mysql_num_rows($results);
	while($row = mysql_fetch_array($results))
	{
		$videoid = $row['ID'];
?>
<tr>
	<td class="leftcell"><a href="/<? echo $content['MOD_NAME']; ?>/<? echo $row['ID']; ?>"><? echo stripslashes($row['TITLE']); ?></a></td>
	<td align="center"><? echo countVideoCategories($videoid); ?></td>
	<td align="center"><? if($row['ACTIVE']){ echo '&#10004;'; }else{ echo '&#215;'; } ?></td>
</tr>
<?
	}
?>
</table>
	<?
	if($count2 == 0)
		echo '<p>No results.</p>';
	else
		include("global/results-footer.php");
	?>
<div class="clr"></div>
<? } ?>