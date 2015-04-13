<?
if($qa[0] != ""){
include_once("js/ckeditor/ckeditor.php");
	include_once('js/ckfinder/ckfinder.php');
	$CKEditor = new CKEditor();
	
	// Create a class instance.
	//$CKEditor = new CKEditor(); //no need to do this twice

	// Path to the CKEditor directory.
	$CKEditor->basePath = '/js/ckeditor/';
	
	// Set up CKFinder
	CKFinder::SetupCKEditor($CKEditor, '/js/ckfinder/');
	
	if($qa[0]==0 or $qa[0] == "")
		echo '<h2>Create Page</h2>';
	else
	{
		echo '<h2>Update Page</h2>';
		//$url = 'http://anonymous-redirect.com/?u='.urlencode(');
		$url = 'https://www.imaginecrafts.com/'.$content_edit['MOD_NAME'];
		echo '<p>Site URL: <a target="_blank" href="'.$url.'">www.imaginecrafts.com/'.$content_edit['MOD_NAME'].'</a></p>';
	}
?>
<form action="/<? echo $content['MOD_NAME']; ?>/<? echo $qa[0]; ?>" method="post" id="myform">
<p class="longfieldFull">Page Title<br /><input type="text" name="TITLE" value="<? echo stripslashes($title); ?>" /></p>
<p><? $CKEditor->editor("BODY", $body); ?></p>

<fieldset>
<legend>Page &amp; SEO Attributes</legend>
<div class="longfieldFull">Title On Search Engines<br /><input type="text" name="META_TITLE" value="<? echo stripslashes($meta_title); ?>" /></div>
<div class="longfieldFull">Search Engine Summary<br /><input type="text" name="META_DESCRIPTION" value="<? echo stripslashes($meta_description); ?>" /></div>
<div class="longfieldFull">Search Engine Keywords (separated by commas)<br /><input type="text" name="META_KEYWORDS" value="<? echo stripslashes($meta_keywords); ?>" /></div>
<div style="buttonheight"><input type="checkbox" name="ACTIVE" value="1"<? if($active){ echo ' checked'; } ?> /> Active (display on website)</div>
</fieldset>
<div class="buttonheight"><input type="submit" name="BUTTON" value="Save" /><? if($content_edit['DELETABLE'] == 1){ ?> <input type="button" onclick="javascript:confirmDelete()" value="Delete" /></div><? } ?></div>
</form>

<? }else{ ?>
<p>Click on a page you wish to edit.</p>
<form action="/<? echo $content['MOD_NAME']; ?>/<? echo $qa[0]; ?>" method="post" id="myform">
<p>Search: <input type="text" name="SEARCH" value="<? echo stripslashes($_POST['SEARCH']); ?>" style="display:inline;" />&nbsp;&nbsp;<input type="submit" name="BUTTON" value="Search" style="width:90px" /> <input type="button" onclick="javascript:window.location='/admin/editable-pages/0'" value="Create" style="width:90px" /></p>
</form>
<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:100%">
<tr>
	<th>Page Title</th>
	<th style="width: 130px;">Last Updated</th>
	<th style="width: 50px; text-align: center;">Active</th>
</tr>
<?
	$search = $_POST['SEARCH'];
	$current_result = $qa[1];
	if($current_result == "" or $current_result < 1)
		$current_result = 1;
	$limit = ($current_result-1)*DISPLAY_RESULTS.','.DISPLAY_RESULTS;
	
	$filter = "";
	if($search != '')
	{
		$terms = explode(' ', $search);
		foreach ($terms as $term)
			if ($term != '')
				$filter .= " AND CONCAT(TITLE,'|||',META_DESCRIPTION,'|||',BODY,'|||',META_KEYWORDS,'|||') LIKE '%$term%'";
	}
			
	$query = "SELECT SQL_CALC_FOUND_ROWS * FROM content WHERE EDITABLE='1' $filter ORDER BY TITLE LIMIT $limit";
	$results = mysql_query($query) or die(mysql_error());
	$countquery = "SELECT FOUND_ROWS() AS FOUND";
	$countresults = mysql_fetch_array(mysql_query($countquery));
	$totalcount = $countresults['FOUND'];
	$count2 = mysql_num_rows($results);
	while($row = mysql_fetch_array($results))
	{
?>
<tr>
	<td class="leftcell"><a href="/admin/editable-pages/<? echo $row['ID']; ?>"><? echo stripslashes($row['TITLE']); ?></a></td>
	<td><? echo datetimeformat($row['LASTUPDATED']); ?></td>
	<td style="text-align: center;"><? if($row['ACTIVE']){ echo '&#10004;'; } ?></td>
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
<div style="clear: both;"></div>
<p><a href="/admin/editable-pages/0">Create Page</a></p>
<? } ?>