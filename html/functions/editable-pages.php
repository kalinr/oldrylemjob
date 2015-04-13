<?
function contentCreate($title, $meta_title, $meta_description, $meta_keywords, $button_title, $body, $top_order, $active)
{
	$typeid = 1;
	$sectionid = 3;
	$parentid = 0;
	$mod_name = generateModName2(0,$title);
	$title = mysqlClean($title);
	$meta_title = mysqlClean($meta_title);
	$meta_description = mysqlClean($meta_description);
	$meta_keywords = mysqlClean($meta_keywords);
	$body = mysqlClean($body);
	$sitemap = 1;
	$active = 1;
	$display_title = 1;
	$ssl_mode = 0;
	$editable = 1;
	$deletable = 1;
	$lastupdated = currentDateTime();
	$created = currentDateTime();

	mysql_query("INSERT INTO content(TYPEID, SECTIONID, MOD_NAME, TITLE, META_TITLE, META_DESCRIPTION, META_KEYWORDS, BUTTON_TITLE, BODY, BODY_SIDE, MODULE_PROCESSING, MODULE_META, MODULE_HEAD, MODULE_BODY, MODULE_SIDE, TOP_ORDER, HITS_UNIQUE, HITS_REPEAT, ROBOT_HITS, LASTVIEWED, ROBOT_LASTVIEWED, PRIORITY, SITEMAP, ACTIVE, DISPLAY_TITLE, SSL_MODE, EDITABLE, DELETABLE, LASTUPDATED, CREATED) VALUES ('$typeid', '$sectionid', '$mod_name', '$title', '$meta_title', '$meta_description', '$meta_keywords', '$button_title', '$body', '$body_side', '$module_processing', '$module_meta', '$module_head', '$module_body', '$module_side', '$top_order', '$hits_unique', '$hits_repeat', '$robot_hits', '$lastviewed', '$robot_lastviewed', '$priority', '$sitemap', '$active', '$display_title', '$ssl_mode', '$editable', '$deletable', '$lastupdated', '$created')") or die(mysql_error());
	return mysql_insert_id();
}
function contentUpdate($id, $title, $meta_title, $meta_description, $meta_keywords, $button_title, $body, $top_order, $active, $editable, $deletable)
{
	$typeid = 1;
	$sectionid = 3;
	$parentid = 0;
	$title = mysqlClean($title);
	$meta_title = mysqlClean($meta_title);
	$meta_description = mysqlClean($meta_description);
	$meta_keywords = mysqlClean($meta_keywords);
	$body = mysqlClean($body);
	$sitemap = 1;
	$active = 1;
	$display_title = 1;
	$ssl_mode = 0;
	$lastupdated = currentDateTime();

	mysql_query("UPDATE content SET TYPEID='$typeid', SECTIONID='$sectionid', TITLE='$title', META_TITLE='$meta_title', META_DESCRIPTION='$meta_description', META_KEYWORDS='$meta_keywords', BODY='$body', ACTIVE='$active', EDITABLE='$editable', DELETABLE='$deletable', LASTUPDATED='$lastupdated' WHERE ID='$id'") or die(mysql_error());
}
function contentDelete($id)
{
	mysql_query("DELETE FROM content WHERE ID='$id' AND DELETABLE='1'");
}
?>