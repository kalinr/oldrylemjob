<p>Below are your video selections. Simply click on any video title or thumbnail to play.  You may use the search box to easily locate videos based on title, description or product line.</p>
<form action="/videos" method="post" id="myform">
<p>Search<br /><input type="text" name="SEARCH" onfocus="this.select()" value="<? echo stripslashes($_SESSION['VIDEO']['SEARCH']); ?>" style="display:inline;" /> <input type="submit" name="BUTTON" value="Search" style="width: 100px;" /><? if($_SESSION['VIDEO']['SEARCH'] != ''){ ?> <input type="button" name="BUTTON" value="Clear" style="width: 100px;" onclick="javascript:window.location='/<? echo $content['MOD_NAME']; ?>/<? echo $content['ID']; ?>/reset'" /><? } ?></p>
</form>
<?
	$current_result = $qa[0];
	if($current_result == "" or $current_result < 1)
		$current_result = 1;
	$limit = ($current_result-1)*DISPLAY_RESULTS.','.DISPLAY_RESULTS;

if($content['SECTIONID'] == 4)
{
	$categoryid = videoCategoryContentIDToCategoryID($content['ID']);
	$query = "SELECT SQL_CALC_FOUND_ROWS videos.THUMB_FILENAME, content.* FROM content, videos, videos_categories_affiliations WHERE videos.CONTENTID=content.ID AND videos.ID=videos_categories_affiliations.VIDEOID AND videos_categories_affiliations.CATEGORYID='$categoryid' AND ACTIVE='1' ORDER BY content.CREATED DESC LIMIT $limit";
}
else
{
	$search = $_SESSION['VIDEO']['SEARCH'];	
	$filter = "";
	if($search != '')
	{
		$terms = explode(' ', $search);
		foreach ($terms as $term)
			if ($term != '')
				$filter .= " AND CONCAT('|||',TITLE,'|||',BODY,'|||',META_DESCRIPTION,'|||',META_KEYWORDS,'|||') LIKE '%$term%'";
	}
	if($_SESSION['VIDEO']['SEARCH'] != '')
		$query = "SELECT SQL_CALC_FOUND_ROWS videos.THUMB_FILENAME, content.* FROM content, videos WHERE videos.CONTENTID=content.ID AND ACTIVE='1' $filter ORDER BY content.TITLE LIMIT $limit";
	else
		$query = "SELECT SQL_CALC_FOUND_ROWS videos.THUMB_FILENAME, content.* FROM content, videos WHERE videos.CONTENTID=content.ID AND ACTIVE='1' $filter ORDER BY content.CREATED DESC LIMIT $limit";
}
$results = mysql_query($query) or die(mysql_error());
$countquery = "SELECT FOUND_ROWS() AS FOUND";
$countresults = mysql_fetch_array(mysql_query($countquery));
$totalcount = $countresults['FOUND'];
$count2 = mysql_num_rows($results);

while($row = mysql_fetch_array($results))
{

	if($row['THUMB_FILENAME'] == '')
		$row['THUMB_FILENAME'] = 'nothumbnail.png';
		
	if($content['ID'] == 21) //search and main videos page
	{
		echo '<div id="mainvideobox">';
		echo '<a href="/'.$row['MOD_NAME'].'"><img src="/images/videos/'.stripslashes($row['THUMB_FILENAME']).'" border="0" />';
		echo '<a href="/'.$row['MOD_NAME'].'">'.stripslashes($row['TITLE']).'</a>';
		if($row['META_DESCRIPTION'] != '')
			echo '<br />'.stripslashes($row['META_DESCRIPTION']);
		echo '</div>';
	}
	else //categories
	{
		echo '<div id="catvideobox">';
		echo '<a href="/'.$row['MOD_NAME'].'"><img src="/images/videos/'.stripslashes($row['THUMB_FILENAME']).'" border="0" />';
		echo '<strong><a href="/'.$row['MOD_NAME'].'">'.stripslashes($row['TITLE']).'</a></strong>';
		if($row['META_DESCRIPTION'] != '')
			echo '<br />'.stripslashes($row['META_DESCRIPTION']);
		echo '</div>';
	}
}
?>
<div class="clr"></div>
<?
	if($count2 == 0)
		echo '<p style="font-size:1.3em;font-weight:bold">There are no videos on file based on your selection.</p>';
	else
		include("global/results-footer.php");
	?>
<div class="clr"></div>