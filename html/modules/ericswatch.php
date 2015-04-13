<div id="swatchwrapper">
<?
	$current_result = $mod[1];
	if($current_result == "" or $current_result < 1)
		$current_result = 1;
	$limit = ($current_result-1)*DISPLAY_RESULTS.','.DISPLAY_RESULTS;
	
	$filter = "";
	if($search != '')
	{
		$terms = explode(' ', $search);
		foreach ($terms as $term)
			if ($term != '')
				$filter .= " AND CONCAT(FIRST,'|||',LAST,'|||',ORGANIZATION,'|||') LIKE '%$term%'";
	}
			
	$query = "SELECT COLOR, HEX_COLOR FROM `import` WHERE HEX_COLOR > ''  group by HEX_COLOR";
	$results = mysql_query($query) or die(mysql_error());
	$countquery = "SELECT FOUND_ROWS() AS FOUND";
	$countresults = mysql_fetch_array(mysql_query($countquery));
	$totalcount = $countresults['FOUND'];
	$count2 = mysql_num_rows($results);
	while($row = mysql_fetch_array($results))
	{
?>
	<a href="javascript:void(0)" class="tooltip" title="<? echo stripslashes($row['COLOR']); ?>">
	<div id="swatchcolor" style="background:#<? echo stripslashes($row['HEX_COLOR']);  ?>">
	</div>
	</a>
<?
	}
?>
</div>
	
<div style="clear: both;"></div>

<script src="/js/jquery.js" type="text/javascript"></script>
<script src="/js/main.js" type="text/javascript"></script>