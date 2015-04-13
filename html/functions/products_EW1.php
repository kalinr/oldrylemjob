<?
function brandName($id)
{
	$query = "SELECT NAME FROM brands, brands_products WHERE brands_products.PRODUCTID='".$id."' AND brands_products.BRANDID=brands.ID LIMIT 1";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['NAME'];
}
function productsCreate($size_name, $layoutid, $layoutid2, $pack, $sku, $name, $color, $barcode, $country_origin, $piece_specs_weight_oz, $piece_specs_length, $piece_specs_width, $piece_specs_height, $inner_carton_pcs, $inner_carton_oz, $inner_carton_length, $inner_carton_width, $inner_carton_height, $master_carton_pcs, $master_carton_weight_oz, $master_carton_length, $master_carton_width, $master_carton_height, $tariff_code, $wholesale_cost, $retail_cost, $retail_minimum, $prof_minimum, $wholesale_minimum, $wholesale_minimum_fabric, $distributor_minimum, $discount, $description, $bullet_feature1, $bullet_feature2, $bullet_feature3, $bullet_feature4, $bullet_feature5, $hex_color, $active, $display)
{
	//$mod_name = generateModName(0,mysqlClean($name), "products");
	$size_name = mysqlClean($size_name);
	$layoutid = mysqlClean($layoutid);
	$layoutid2 = mysqlClean($layoutid2);
	$pack = mysqlClean($pack);
	$sku = mysqlClean($sku);
	$name = mysqlClean($name);
	$color = mysqlClean($color);
	$barcode = mysqlClean($barcode);
	$country_origin = mysqlClean($country_origin);
	$piece_specs_weight_oz = mysqlClean($piece_specs_weight_oz);
	$piece_specs_length = mysqlClean($piece_specs_length);
	$piece_specs_width = mysqlClean($piece_specs_width);
	$piece_specs_height = mysqlClean($piece_specs_height);
	$inner_carton_pcs = mysqlClean($inner_carton_pcs);
	$inner_carton_oz = mysqlClean($inner_carton_oz);
	$inner_carton_length = mysqlClean($inner_carton_length);
	$inner_carton_width = mysqlClean($inner_carton_width);
	$inner_carton_height = mysqlClean($inner_carton_height);
	$master_carton_pcs = mysqlClean($master_carton_pcs);
	$master_carton_weight_oz = mysqlClean($master_carton_weight_oz);
	$master_carton_length = mysqlClean($master_carton_length);
	$master_carton_width = mysqlClean($master_carton_width);
	$master_carton_height = mysqlClean($master_carton_height);
	$tariff_code = mysqlClean($tariff_code);
	$wholesale_cost = mysqlClean($wholesale_cost);
	$retail_cost = mysqlClean($retail_cost);
	$retail_minimum = mysqlClean($retail_minimum);
	$prof_minimum = mysqlClean($prof_minimum);
	$wholesale_minimum = mysqlClean($wholesale_minimum);
	$wholesale_minimum_fabric = mysqlClean($wholesale_minimum_fabric);
	$distributor_minimum = mysqlClean($distributor_minimum);
	$discount = mysqlClean($discount);
	$description = mysqlClean($description);
	$bullet_feature1 = mysqlClean($bullet_feature1);
	$bullet_feature2 = mysqlClean($bullet_feature2);
	$bullet_feature3 = mysqlClean($bullet_feature3);
	$bullet_feature4 = mysqlClean($bullet_feature4);
	$bullet_feature5 = mysqlClean($bullet_feature5);
	$hex_color = mysqlClean($hex_color);
	$active = mysqlClean($active);
	$lastupdated = currentDateTime();
	$created = currentDateTime();

	mysql_query("INSERT INTO products(MOD_NAME, SIZE_NAME, LAYOUTID, LAYOUTID2, PACK, SKU, NAME, COLOR, BARCODE, COUNTRY_ORIGIN, PIECE_SPECS_WEIGHT_OZ, PIECE_SPECS_LENGTH, PIECE_SPECS_WIDTH, PIECE_SPECS_HEIGHT, INNER_CARTON_PCS, INNER_CARTON_OZ, INNER_CARTON_LENGTH, INNER_CARTON_WIDTH, INNER_CARTON_HEIGHT, MASTER_CARTON_PCS, MASTER_CARTON_WEIGHT_OZ, MASTER_CARTON_LENGTH, MASTER_CARTON_WIDTH, MASTER_CARTON_HEIGHT, TARIFF_CODE, WHOLESALE_COST, RETAIL_COST, RETAIL_MINIMUM, PROF_MINIMUM, WHOLESALE_MINIMUM, WHOLESALE_MINIMUM_FABRIC,  DISTRIBUTOR_MINIMUM, DISCOUNT, DESCRIPTION, BULLET_FEATURE1, BULLET_FEATURE2, BULLET_FEATURE3, BULLET_FEATURE4, BULLET_FEATURE5, HEX_COLOR, ACTIVE, DISPLAY, LASTUPDATED, CREATED) VALUES ('$mod_name', '$size_name', '$layoutid', '$layoutid2', '$pack', '$sku', '$name', '$color', '$barcode', '$country_origin', '$piece_specs_weight_oz', '$piece_specs_length', '$piece_specs_width', '$piece_specs_height', '$inner_carton_pcs', '$inner_carton_oz', '$inner_carton_length', '$inner_carton_width', '$inner_carton_height', '$master_carton_pcs', '$master_carton_weight_oz', '$master_carton_length', '$master_carton_width', '$master_carton_height', '$tariff_code', '$wholesale_cost', '$retail_cost', '$retail_minimum', '$prof_minimum', '$wholesale_minimum', '$wholesale_minimum_fabric', '$distributor_minimum', '$discount', '$description', '$bullet_feature1', '$bullet_feature2', '$bullet_feature3', '$bullet_feature4', '$bullet_feature5', '$hex_color', '$active', '$display', '$lastupdated', '$created')") or die(mysql_error());
	return mysql_insert_id();
}
function productsUpdate($id, $size_name, $layoutid, $layoutid2, $pack, $sku, $name, $color, $barcode, $country_origin, $piece_specs_weight_oz, $piece_specs_length, $piece_specs_width, $piece_specs_height, $inner_carton_pcs, $inner_carton_oz, $inner_carton_length, $inner_carton_width, $inner_carton_height, $master_carton_pcs, $master_carton_weight_oz, $master_carton_length, $master_carton_width, $master_carton_height, $tariff_code, $wholesale_cost, $retail_cost, $retail_minimum, $prof_minimum, $wholesale_minimum, $wholesale_minimum_fabric, $distributor_minimum, $discount, $description, $bullet_feature1, $bullet_feature2, $bullet_feature3, $bullet_feature4, $bullet_feature5, $hex_color, $active, $display, $updateall)
{
	//$mod_name = generateModName($id,mysqlClean($name), "products");
	$size_name = mysqlClean($size_name);
	$layoutid = mysqlClean($layoutid);
	$layoutid2 = mysqlClean($layoutid2);
	$pack = mysqlClean($pack);
	$sku = mysqlClean($sku);
	$name = mysqlClean($name);
	$color = mysqlClean($color);
	$barcode = mysqlClean($barcode);
	$country_origin = mysqlClean($country_origin);
	$piece_specs_weight_oz = mysqlClean($piece_specs_weight_oz);
	$piece_specs_length = mysqlClean($piece_specs_length);
	$piece_specs_width = mysqlClean($piece_specs_width);
	$piece_specs_height = mysqlClean($piece_specs_height);
	$inner_carton_pcs = mysqlClean($inner_carton_pcs);
	$inner_carton_oz = mysqlClean($inner_carton_oz);
	$inner_carton_length = mysqlClean($inner_carton_length);
	$inner_carton_width = mysqlClean($inner_carton_width);
	$inner_carton_height = mysqlClean($inner_carton_height);
	$master_carton_pcs = mysqlClean($master_carton_pcs);
	$master_carton_weight_oz = mysqlClean($master_carton_weight_oz);
	$master_carton_length = mysqlClean($master_carton_length);
	$master_carton_width = mysqlClean($master_carton_width);
	$master_carton_height = mysqlClean($master_carton_height);
	$tariff_code = mysqlClean($tariff_code);
	$wholesale_cost = mysqlClean($wholesale_cost);
	$retail_cost = mysqlClean($retail_cost);
	$retail_minimum = mysqlClean($retail_minimum);
	$prof_minimum = mysqlClean($prof_minimum);
	$wholesale_minimum = mysqlClean($wholesale_minimum);
	$wholesale_minimum_fabric = mysqlClean($wholesale_minimum_fabric);
	$distributor_minimum = mysqlClean($distributor_minimum);
	$discount = mysqlClean($discount);
	$description = mysqlClean($description);
	$bullet_feature1 = mysqlClean($bullet_feature1);
	$bullet_feature2 = mysqlClean($bullet_feature2);
	$bullet_feature3 = mysqlClean($bullet_feature3);
	$bullet_feature4 = mysqlClean($bullet_feature4);
	$bullet_feature5 = mysqlClean($bullet_feature5);
	$hex_color = mysqlClean($hex_color);
	$active = mysqlClean($active);
	$updateall = mysqlClean($updateall);
	$lastupdated = currentDateTime();
	$created = mysqlClean($created);
	
	if($updateall != "")
	{
		$query = "UPDATE products SET SIZE_NAME='$size_name', LAYOUTID='$layoutid', LAYOUTID2='$layoutid2', PACK='$pack',NAME='$name', COUNTRY_ORIGIN='$country_origin', PIECE_SPECS_WEIGHT_OZ='$piece_specs_weight_oz', PIECE_SPECS_LENGTH='$piece_specs_length', PIECE_SPECS_WIDTH='$piece_specs_width', PIECE_SPECS_HEIGHT='$piece_specs_height', INNER_CARTON_PCS='$inner_carton_pcs', INNER_CARTON_OZ='$inner_carton_oz', INNER_CARTON_LENGTH='$inner_carton_length', INNER_CARTON_WIDTH='$inner_carton_width', INNER_CARTON_HEIGHT='$inner_carton_height', MASTER_CARTON_PCS='$master_carton_pcs', MASTER_CARTON_WEIGHT_OZ='$master_carton_weight_oz', MASTER_CARTON_LENGTH='$master_carton_length', MASTER_CARTON_WIDTH='$master_carton_width', MASTER_CARTON_HEIGHT='$master_carton_height', WHOLESALE_COST='$wholesale_cost', RETAIL_COST='$retail_cost', RETAIL_MINIMUM='$retail_minimum', TARIFF_CODE='$tariff_code', PROF_MINIMUM='$prof_minimum', WHOLESALE_MINIMUM='$wholesale_minimum', WHOLESALE_MINIMUM_FABRIC='$wholesale_minimum_fabric', DISTRIBUTOR_MINIMUM='$distributor_minimum', DISCOUNT='$discount', DESCRIPTION='$description', BULLET_FEATURE1='$bullet_feature1', BULLET_FEATURE2='$bullet_feature2', BULLET_FEATURE3='$bullet_feature3', BULLET_FEATURE4='$bullet_feature4', BULLET_FEATURE5='$bullet_feature5', ACTIVE='$active', DISPLAY='$display', LASTUPDATED='$lastupdated' WHERE NAME='$updateall'";
		mysql_query($query) or die(mysql_error());
	}
	else
	{
		$query = "UPDATE products SET SIZE_NAME='$size_name', LAYOUTID='$layoutid', LAYOUTID2='$layoutid2', PACK='$pack', SKU='$sku', NAME='$name', COLOR='$color', BARCODE='$barcode', COUNTRY_ORIGIN='$country_origin', PIECE_SPECS_WEIGHT_OZ='$piece_specs_weight_oz', PIECE_SPECS_LENGTH='$piece_specs_length', PIECE_SPECS_WIDTH='$piece_specs_width', PIECE_SPECS_HEIGHT='$piece_specs_height', INNER_CARTON_PCS='$inner_carton_pcs', INNER_CARTON_OZ='$inner_carton_oz', INNER_CARTON_LENGTH='$inner_carton_length', INNER_CARTON_WIDTH='$inner_carton_width', INNER_CARTON_HEIGHT='$inner_carton_height', MASTER_CARTON_PCS='$master_carton_pcs', MASTER_CARTON_WEIGHT_OZ='$master_carton_weight_oz', MASTER_CARTON_LENGTH='$master_carton_length', MASTER_CARTON_WIDTH='$master_carton_width', MASTER_CARTON_HEIGHT='$master_carton_height', TARIFF_CODE='$tariff_code', WHOLESALE_COST='$wholesale_cost', RETAIL_COST='$retail_cost', RETAIL_MINIMUM='$retail_minimum', PROF_MINIMUM='$prof_minimum', WHOLESALE_MINIMUM='$wholesale_minimum', WHOLESALE_MINIMUM_FABRIC='$wholesale_minimum_fabric', DISTRIBUTOR_MINIMUM='$distributor_minimum', DISCOUNT='$discount', DESCRIPTION='$description', BULLET_FEATURE1='$bullet_feature1', BULLET_FEATURE2='$bullet_feature2', BULLET_FEATURE3='$bullet_feature3', BULLET_FEATURE4='$bullet_feature4', BULLET_FEATURE5='$bullet_feature5', HEX_COLOR='$hex_color', ACTIVE='$active', DISPLAY='$display', LASTUPDATED='$lastupdated' WHERE ID=$id";
		mysql_query($query) or die(mysql_error());
	}
}
function productsDelete($id)
{
	mysql_query("DELETE FROM brands_products WHERE PRODUCTID='".$id."'");
	mysql_query("DELETE FROM products WHERE ID='".$qa[1]."'");
	productDeleteImage($id);
}
function productDeleteImage($id)
{
	$image = "images/products/".$id.".jpg";
	if($image != "images/products/" && file_exists($image))
		unlink($image);
}
function products_inpackCount($productid)
{
	$query = "SELECT COUNT(PRODUCTID) AS COUNT FROM products_inpack WHERE PRODUCTID='$productid'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['PRODUCTID'];
}
function productHasCollection($productid, $brandid)
{
	$query = "SELECT * FROM products, brands_collections WHERE '$brandid'=brands_collections.BRANDID AND brands_collections.PRODUCTID=products.ID";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	if($row['ID'] == "")
		return false;
	else
		return true;
}
function productHasRelatedProducts($productid, $brandid)
{
	$query = "SELECT * FROM products, brands_related WHERE '$brandid'=brands_related.BRANDID AND brands_related.PRODUCTID=products.ID";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	if($row['ID'] == "")
		return false;
	else
		return true;
}
?>