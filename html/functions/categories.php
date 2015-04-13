<?
//categories
function categoriesCreate($name, $top_order)
{
	$name = mysqlClean($name);
	$mod_name = generateModName(0, $name, "categories");
	mysql_query("INSERT INTO categories(NAME, MOD_NAME, TOP_ORDER) VALUES ('$name', '$mod_name', '$top_order')") or die(mysql_error());
	return mysql_insert_id();
}
function categoriesUpdate($id, $name, $top_order)
{
	$name = mysqlClean($name);
	$mod_name = generateModName($id, $name, "categories");
	mysql_query("UPDATE categories SET MOD_NAME='$mod_name', NAME='$name', TOP_ORDER='$top_order' WHERE ID=$id") or die(mysql_error());
}
function categoriesDelete($id)
{
	mysql_query("DELETE FROM categories WHERE ID='$id'");
	//DELETE BRANDS
	$query = "SELECT * FROM brands WHERE CATEGORYID='$id'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	while($row = mysql_fetch_array($result))
	{
		brandsDelete($row['ID']);
	}
}
function categoryBrandCount($id)
{
	$query = "SELECT COUNT(ID) AS COUNT FROM brands WHERE CATEGORYID='$id'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['COUNT'];
}
function categoryName($id)
{
	$query = "SELECT NAME FROM categories WHERE ID='$id'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['NAME'];
}
//BRANDS
function brandsCreate($categoryid, $name, $description, $banner, $active)
{
	$name = mysqlClean($name);
	$description = mysqlClean($description);
	$banner = mysqlClean($banner);
	$mod_name = generateModName(0, $name, "brands");

	mysql_query("INSERT INTO brands(CATEGORYID, MOD_NAME, NAME, DESCRIPTION, BANNER, FEATURED_PRODUCT, ACTIVE) VALUES ('$categoryid', '$mod_name', '$name', '$description', '$banner', '0', '$active')") or die(mysql_error());
	$brandid = mysql_insert_id();
	
	mysql_query("INSERT INTO content(TYPEID, MOD_NAME, TITLE, META_TITLE, MODULE_PROCESSING, MODULE_HEAD, MODULE_BODY, LASTUPDATED, CREATED, DISPLAY_TITLE) VALUES ('1', '$mod_name', '$name', '$name', 'product-processing.php', 'product-head.php', 'product-body.php', '".currentDateTime()."', '".currentDateTime()."','0')") or die(mysql_error());
	$theContentID = mysql_insert_id();
	
        // only create a learn record and a learn content page if category is fabric, paper, mixed media, or brushes & tools
        if ($categoryid == 1 || $categoryid == 15 || $categoryid == 16 || $categoryid == 14) {

          $pageName = 'learn-' . $mod_name;
          $metaTitle = 'Learn - ' . $name;
          $qry = "INSERT INTO content VALUES(NULL, 1, 0, '$pageName', '', '$metaTitle', '', '', '', '', '', '', '', 'learn-info-head.php', 'learn-info-body.php', '', 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0.70, 1, 1, 0, 0, 0, 0, '2013-10-31 00:00:00', '2013-10-31 00:00:00')";
          mysql_query($qry) or die(mysql_error());
          $theContentID = mysql_insert_id();

          $qry = "INSERT INTO learn VALUES(NULL, '$brandid', '$theContentID', '', '', '', '', 1, 1, 1, 1)";
          mysql_query($qry) or die(mysql_error());

        }
	
	return $brandid;
}

function brandsUpdate($id, $categoryid, $name, $description, $banner, $active)
{
	$name = mysqlClean($name);
	$description = mysqlClean($description);
	$banner = mysqlClean($banner);
	$mod_name = generateModName($id, $name, "brands");

	mysql_query("UPDATE brands SET CATEGORYID='$categoryid',NAME='$name', DESCRIPTION='$description', BANNER='$banner', ACTIVE='$active' WHERE ID=$id") or die(mysql_error());
}
function brandsDelete($id)
{
	$query = "SELECT BANNER FROM brands WHERE ID='$id'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	if($row['BANNER'] != "")
	{
		$banner = "images/brands/".$row['BANNER'];
		if(file_exists($banner))
			unlink($banner);
	}
	mysql_query("DELETE FROM brands WHERE ID='$id'");
	mysql_query("DELETE FROM brands_products WHERE BRANDID='$id'");
	mysql_query("DELETE FROM learn WHERE BRAND_ID='$id'");
}
function brandsNameUnique($id,$name)
{
	$query = "SELECT ID FROM brands WHERE ID!='$id' AND NAME='$name'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	if($row['ID'] == "")
		return true;
	else
		return false;
}
function brandCategoryCount($id)
{
	$query = "SELECT COUNT(PRODUCTID) AS COUNT FROM brands_products WHERE BRANDID='$id'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['COUNT'];
}
function createBrandProductAffiliation($brandid,$productid)
{
	mysql_query("INSERT INTO brands_products(BRANDID, PRODUCTID, PRODUCTSORT) VALUES ('$brandid','$productid', 0)") or die(mysql_error());
}
function productBrandModNametoId($mod_name)
{
	$query = "SELECT * FROM brands WHERE MOD_NAME='$mod_name'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['ID'];
}
function productBrandIdToMod($id)
{
	$query = "SELECT brands.MOD_NAME FROM brands, brands_products WHERE '$id'=brands_products.PRODUCTID AND brands_products.BRANDID=brands.ID";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['MOD_NAME'];
}
function productBrandIdToMod2($id)
{
	$query = "SELECT brands.MOD_NAME FROM brands, brands_products WHERE '$id'=brands_products.PRODUCTID AND brands_products.BRANDID=brands.ID";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['MOD_NAME'];
}
?>