<?
function updateContentStats($id,$hits,$robot_hits,$trackmultiple="no")
{
	$pages_visited = $_SESSION['PAGES_VISITED'];
	if(sizeof($pages_visited) == 0)
		$pages_visited[0] = '';
	$robot_hits++;
	$hits++;
	if(get_user_browser() == '')//assumed bot
		$query2 = "UPDATE content SET ROBOT_HITS='".$robot_hits."',ROBOT_LASTVIEWED='".currentDateTime()."' WHERE ID='".$id."'";
	else if(!in_array($id,$pages_visited))
		$query2 = "UPDATE content SET HITS_UNIQUE='".$hits."',HITS_REPEAT='$hits',LASTVIEWED='".currentDateTime()."' WHERE ID='".$id."'";
	else
		$query2 = "UPDATE content SET HITS_REPEAT='$hits',LASTVIEWED='".currentDateTime()."' WHERE ID='".$id."'";
	$result2 = mysql_query($query2) or die (mysql_error());
	array_push($pages_visited, $id);
	$_SESSION['PAGES_VISITED'] = $pages_visited;
}
function pageName($id)
{
	$query = "SELECT * FROM content WHERE ID='$id'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return stripslashes($row['TITLE']);
}
function subPagesCount($id)
{
	$query = "SELECT COUNT(ID) AS COUNT FROM content WHERE PARENTID='$id'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['COUNT'];
}
//mod names
function generateModName($id,$name, $table)
{
	//clean category
	$name = ereg_replace("[^a-z0-9]"," ",strtolower($name));
	$name = mysqlclean($name);
	
	$name = str_replace(" ","-",$name);
	$name = str_replace("----","-",$name);
	$name = str_replace("---","-",$name);
	$name = str_replace("--","-",$name);

	if(modeNameUnique($id,$name, $table))
		return $name;
	else
	{
		$count = 2;
		$mod_name = $name.$count;
		while(!modeNameUnique($id,$mod_name, $table))
		{
			$count++;
			$mod_name = $name.$count;
		}
		return $mod_name;
	}
}
function generateModName2($id,$name)
{
	//clean category
	$name = ereg_replace("[^a-z0-9/ ]"," ",strtolower($name));
	$name = mysqlclean($name);
	
	$name = str_replace(" ","-",$name);
	$name = str_replace("----","-",$name);
	$name = str_replace("---","-",$name);
	$name = str_replace("--","-",$name);

	if(modeNameUnique2($id,$name))
		return $name;
	else
	{
		$count = 2;
		$mod_name = $name.$count;
		while(!modeNameUnique2($id,$mod_name))
		{
			$count++;
			$mod_name = $name.$count;
		}
		return $mod_name;
	}
}
function modeNameUnique($id,$name, $table)
{
	if($table != "brands")
	{
		$query = "SELECT * FROM brands WHERE ID!='$id' AND MOD_NAME='$name'";
		$result = mysql_query($query) or die (mysql_error());
		$row = mysql_fetch_array($result);
		if($row['ID'] != "")
			return false;
		else
		{
			$query = "SELECT * FROM $table WHERE ID!='$id' AND MOD_NAME='$name'";
			$result = mysql_query($query) or die (mysql_error());
			$row = mysql_fetch_array($result);
			if($row['ID'] == '')
				return true;
			else
				return false;
		}
	}
	else
		return true;
}
function modeNameUnique2($id,$name)
{

	$query = "SELECT * FROM content WHERE ID!='$id' AND MOD_NAME='$name'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
	if($row['ID'] == '')
		return true;
	else
		return false;
}


function contentCreate2($typeid, $sectionid, $mod_name, $title, $meta_title, $meta_description, $meta_keywords, $button_title, $body, $module_processing, $module_head, $module_body, $top_order, $priority, $sitemap, $active)
{
	$typeid = mysqlClean($typeid);
	$sectionid = mysqlClean($sectionid);
	if($mod_name == "")
		$mod_name = modeNameUnique2(0,$title);
	$mod_name = mysqlClean($mod_name);
	$title = mysqlClean($title);
	$meta_title = mysqlClean($meta_title);
	$meta_description = mysqlClean($meta_description);
	$meta_keywords = mysqlClean($meta_keywords);
	$button_title = mysqlClean($button_title);
	$body = mysqlClean($body);
	$module_processing = mysqlClean($module_processing);
	$module_head = mysqlClean($module_head);
	$module_body = mysqlClean($module_body);
	$top_order = mysqlClean($top_order);
	$priority = mysqlClean($priority);
	$sitemap = mysqlClean($sitemap);
	$active = mysqlClean($active);
	$display_title = mysqlClean($display_title);
	$lastupdated = currentDateTime();
	$created = currentDateTime();

	mysql_query("INSERT INTO content(TYPEID, SECTIONID, MOD_NAME, TITLE, META_TITLE, META_DESCRIPTION, META_KEYWORDS, BUTTON_TITLE, BODY, MODULE_PROCESSING, MODULE_HEAD, MODULE_BODY, TOP_ORDER, PRIORITY, SITEMAP, ACTIVE, LASTUPDATED, CREATED) VALUES ('$typeid', '$sectionid', '$mod_name', '$title', '$meta_title', '$meta_description', '$meta_keywords', '$button_title', '$body', '$module_processing', '$module_head', '$module_body', '$top_order', '$priority', '$sitemap', '$active', '$lastupdated', '$created')") or die(mysql_error());
	return mysql_insert_id();
}
function contentUpdate2($id, $typeid, $sectionid, $title, $meta_title, $meta_description, $meta_keywords, $button_title, $body, $module_processing, $module_head, $module_body, $top_order, $priority, $sitemap, $active)
{
	$typeid = mysqlClean($typeid);
	$sectionid = mysqlClean($sectionid);
	$title = mysqlClean($title);
	$meta_title = mysqlClean($meta_title);
	$meta_description = mysqlClean($meta_description);
	$meta_keywords = mysqlClean($meta_keywords);
	$button_title = mysqlClean($button_title);
	$body = mysqlClean($body);
	$module_processing = mysqlClean($module_processing);
	$module_head = mysqlClean($module_head);
	$module_body = mysqlClean($module_body);
	$top_order = mysqlClean($top_order);
	$priority = mysqlClean($priority);
	$sitemap = mysqlClean($sitemap);
	$active = mysqlClean($active);
	$display_title = mysqlClean($display_title);
	$lastupdated = currentDateTime();

	mysql_query("UPDATE content SET TYPEID='$typeid', SECTIONID='$sectionid', TITLE='$title', META_TITLE='$meta_title', META_DESCRIPTION='$meta_description', META_KEYWORDS='$meta_keywords', BUTTON_TITLE='$button_title', BODY='$body', MODULE_PROCESSING='$module_processing',  MODULE_HEAD='$module_head', MODULE_BODY='$module_body', TOP_ORDER='$top_order', PRIORITY='$priority', SITEMAP='$sitemap', ACTIVE='$active', LASTUPDATED='$lastupdated' WHERE ID='$id'") or die(mysql_error());
}
function contentDelete2($id)
{
	mysql_query("DELETE FROM content WHERE ID='$id'") or die(mysql_error());
}
?>