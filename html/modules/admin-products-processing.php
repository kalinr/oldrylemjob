<?
$brands_array[0] = "";
$pack_array[0] = "";
if($qa[1] != "" && $qa[0] != "results")
{
	$query = "SELECT * FROM products WHERE ID='".$qa[1]."'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$product = mysql_fetch_array($result);
	$size_name = $product['SIZE_NAME'];
	$layoutid = $product['LAYOUTID'];
	$layoutid2 = $product['LAYOUTID2'];
	$pack = $product['PACK'];
	$sku = $product['SKU'];
	$name = $product['NAME'];
	$color = $product['COLOR'];
	$barcode = $product['BARCODE'];
	$country_origin = $product['COUNTRY_ORIGIN'];
	$piece_specs_weight_oz = $product['PIECE_SPECS_WEIGHT_OZ'];
	$piece_specs_length = $product['PIECE_SPECS_LENGTH'];
	$piece_specs_width = $product['PIECE_SPECS_WIDTH'];
	$piece_specs_height = $product['PIECE_SPECS_HEIGHT'];
	$inner_carton_pcs = $product['INNER_CARTON_PCS'];
	$inner_carton_oz = $product['INNER_CARTON_OZ'];
	$inner_carton_length = $product['INNER_CARTON_LENGTH'];
	$inner_carton_width = $product['INNER_CARTON_WIDTH'];
	$inner_carton_height = $product['INNER_CARTON_HEIGHT'];
	$master_carton_pcs = $product['MASTER_CARTON_PCS'];
	$master_carton_weight_oz = $product['MASTER_CARTON_WEIGHT_OZ'];
	$master_carton_length = $product['MASTER_CARTON_LENGTH'];
	$master_carton_width = $product['MASTER_CARTON_WIDTH'];
	$master_carton_height = $product['MASTER_CARTON_HEIGHT'];
	$tariff_code = $product['TARIFF_CODE'];
	$wholesale_cost = $product['WHOLESALE_COST'];
	$retail_cost = $product['RETAIL_COST'];
	$retail_minimum = $product['RETAIL_MINIMUM'];
	$prof_minimum = $product['PROF_MINIMUM'];
	$wholesale_minimum = $product['WHOLESALE_MINIMUM'];
	$wholesale_minimum_fabric = $product['WHOLESALE_MINIMUM_FABRIC'];
	$distributor_minimum = $product['DISTRIBUTOR_MINIMUM'];
	$discount = $product['DISCOUNT'];
	$description = $product['DESCRIPTION'];
	$skeywords = $product['SEARCH_KEYWORDS'];	
	//$bullet_feature1 = $product['BULLET_FEATURE1'];
	//$bullet_feature2 = $product['BULLET_FEATURE2'];
	//$bullet_feature3 = $product['BULLET_FEATURE3'];
	//$bullet_feature4 = $product['BULLET_FEATURE4'];
	//$bullet_feature5 = $product['BULLET_FEATURE5'];
	$hex_color = $product['HEX_COLOR'];
	$active = $product['ACTIVE'];
	$display = $product['DISPLAY'];
	$wholesaleonly = $product['WHOLESALEONLY'];	
	$lastupdated = $product['LASTUPDATED'];
	$created = $product['CREATED'];
	
	$count = 0;
	$query = "SELECT * FROM brands_products WHERE PRODUCTID='".$qa[1]."'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	while($row = mysql_fetch_array($result))
	{
		$brand_array[$count] = $row['BRANDID'];
		$count++;
	}
	
	$count = 0;
	$query = "SELECT * FROM products_inpack WHERE PRODUCTID='".$qa[1]."'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	while($row = mysql_fetch_array($result))
	{
		$pack_array[$count] = $row['PACK_PRODUCTID'];
		$count++;
	}
}
if($_POST['BUTTON'] == "Search")
{
	$search = trim(mysqlclean($_POST['SEARCH']));
	$_SESSION['ADMIN']['PRODUCTS']['SEARCH'] = $search;
	unset($_SESSION['ADMIN']['PRODUCTS']['CURRENT_RESULT']);
}
else if($_POST['BUTTON'] == "Save")
{
	$size_name = $_POST['SIZE_NAME'];
	$layoutid = $_POST['LAYOUTID'];
	$layoutid2 = $_POST['LAYOUTID2'];
	$pack = $_POST['PACK'];
	$sku = $_POST['SKU'];
	$name = $_POST['NAME'];
	$color = $_POST['COLOR'];
	$barcode = $_POST['BARCODE'];
	$country_origin = $_POST['COUNTRY_ORIGIN'];
	$piece_specs_weight_oz = $_POST['PIECE_SPECS_WEIGHT_OZ'];
	$piece_specs_length = $_POST['PIECE_SPECS_LENGTH'];
	$piece_specs_width = $_POST['PIECE_SPECS_WIDTH'];
	$piece_specs_height = $_POST['PIECE_SPECS_HEIGHT'];
	$inner_carton_pcs = $_POST['INNER_CARTON_PCS'];
	$inner_carton_oz = $_POST['INNER_CARTON_OZ'];
	$inner_carton_length = $_POST['INNER_CARTON_LENGTH'];
	$inner_carton_width = $_POST['INNER_CARTON_WIDTH'];
	$inner_carton_height = $_POST['INNER_CARTON_HEIGHT'];
	$master_carton_pcs = $_POST['MASTER_CARTON_PCS'];
	$master_carton_weight_oz = $_POST['MASTER_CARTON_WEIGHT_OZ'];
	$master_carton_length = $_POST['MASTER_CARTON_LENGTH'];
	$master_carton_width = $_POST['MASTER_CARTON_WIDTH'];
	$master_carton_height = $_POST['MASTER_CARTON_HEIGHT'];
	$tariff_code = $_POST['TARIFF_CODE'];
	$wholesale_cost = ereg_replace("[^0-9.]","",$_POST['WHOLESALE_COST']);
	$retail_cost = ereg_replace("[^0-9.]","",$_POST['RETAIL_COST']);
	$retail_minimum = $_POST['RETAIL_MINIMUM'];
	$prof_minimum = $_POST['PROF_MINIMUM'];
	$wholesale_minimum = $_POST['WHOLESALE_MINIMUM'];
	$wholesale_minimum_fabric = $_POST['WHOLESALE_MINIMUM_FABRIC'];
	$distributor_minimum = $_POST['DISTRIBUTOR_MINIMUM'];
	$discount = $_POST['DISCOUNT'];
	$description = $_POST['DESCRIPTION'];
	$skeywords = $_POST['SEARCHKEYWORDS'];	
	//$bullet_feature1 = $_POST['BULLET_FEATURE1'];
	//$bullet_feature2 = $_POST['BULLET_FEATURE2'];
	//$bullet_feature3 = $_POST['BULLET_FEATURE3'];
	//$bullet_feature4 = $_POST['BULLET_FEATURE4'];
	//$bullet_feature5 = $_POST['BULLET_FEATURE5'];
	$hex_color = ereg_replace("[^0-9A-Za-z]","",$_POST['HEX_COLOR']);
	$active = $_POST['ACTIVE'];
	$display = $_POST['DISPLAY'];
	$wholesaleonly = $_POST['WHOLESALEONLY'];	
	
	$pack_array = $_POST['PACK_ARRAY'];
	$brand_array = $_POST['BRAND_ARRAY'];
	
	$updateall = $_POST['UPDATEALL'];
	
	if($_FILES['IMAGE']['name'] != "")
	{
		if($qa[1] == "")
			$id = nextId("products");
		else
			$id = $qa[1];
		productDeleteImage($id);
		$error = imageUpload(500,"images/products/",$id.".jpg");
	}
	if($error != "")
		$error = $error;
	if($name == "")
		$error = "Please type in the name of the product.";
	else
	{
		if($updateall)
			$updateall = $product['NAME'];
		else
			$updateall = "";
		
		if($qa[1] == "")
			{
			// $qa[1] = productsCreate($size_name, $layoutid, $layoutid2, $pack, $sku, $name, $color, $barcode, $country_origin, $piece_specs_weight_oz, $piece_specs_length, $piece_specs_width, $piece_specs_height, $inner_carton_pcs, $inner_carton_oz, $inner_carton_length, $inner_carton_width, $inner_carton_height, $master_carton_pcs, $master_carton_weight_oz, $master_carton_length, $master_carton_width, $master_carton_height, $tariff_code, $wholesale_cost, $retail_cost, $retail_minimum, $prof_minimum, $wholesale_minimum, $wholesale_minimum_fabric, $distributor_minimum, $discount, $description, $bullet_feature1, $bullet_feature2, $bullet_feature3, $bullet_feature4, $bullet_feature5, $hex_color, $active, $display);
			$qa[1] = productsCreate($size_name, $layoutid, $layoutid2, $pack, $sku, $name, $color, $barcode, $country_origin, $piece_specs_weight_oz, $piece_specs_length, $piece_specs_width, $piece_specs_height, $inner_carton_pcs, $inner_carton_oz, $inner_carton_length, $inner_carton_width, $inner_carton_height, $master_carton_pcs, $master_carton_weight_oz, $master_carton_length, $master_carton_width, $master_carton_height, $tariff_code, $wholesale_cost, $retail_cost, $retail_minimum, $prof_minimum, $wholesale_minimum, $wholesale_minimum_fabric, $distributor_minimum, $discount, $description, $skeywords, $hex_color, $active, $display, $wholesaleonly);			
			}
		else
			{
			// productsUpdate($qa[1], $size_name, $layoutid, $layoutid2, $pack, $sku, $name, $color, $barcode, $country_origin, $piece_specs_weight_oz, $piece_specs_length, $piece_specs_width, $piece_specs_height, $inner_carton_pcs, $inner_carton_oz, $inner_carton_length, $inner_carton_width, $inner_carton_height, $master_carton_pcs, $master_carton_weight_oz, $master_carton_length, $master_carton_width, $master_carton_height, $tariff_code, $wholesale_cost, $retail_cost, $retail_minimum, $prof_minimum, $wholesale_minimum, $wholesale_minimum_fabric, $distributor_minimum, $discount, $description, $bullet_feature1, $bullet_feature2, $bullet_feature3, $bullet_feature4, $bullet_feature5, $hex_color, $active, $display, $updateall);			
			productsUpdate($qa[1], $size_name, $layoutid, $layoutid2, $pack, $sku, $name, $color, $barcode, $country_origin, $piece_specs_weight_oz, $piece_specs_length, $piece_specs_width, $piece_specs_height, $inner_carton_pcs, $inner_carton_oz, $inner_carton_length, $inner_carton_width, $inner_carton_height, $master_carton_pcs, $master_carton_weight_oz, $master_carton_length, $master_carton_width, $master_carton_height, $tariff_code, $wholesale_cost, $retail_cost, $retail_minimum, $prof_minimum, $wholesale_minimum, $wholesale_minimum_fabric, $distributor_minimum, $discount, $description, $skeywords, $hex_color, $active, $display, $wholesaleonly, $updateall);
			}
			
		//brand array
		mysql_query("DELETE FROM brands_products WHERE PRODUCTID='".$qa[1]."'") or die("Delete".mysql_error());
		if(sizeof($brand_array) > 0)
		{
			foreach($brand_array as $brandid)
			{
				mysql_query("INSERT INTO brands_products(BRANDID, PRODUCTID) VALUES ('$brandid','".$qa[1]."')") or die(mysql_error());
			}
		}
		//PACK array
		mysql_query("DELETE FROM products_inpack WHERE PRODUCTID='".$qa[1]."'") or die("Delete".mysql_error());
		if(sizeof($pack_array) > 0)
		{
			foreach($pack_array as $q)
			{
				mysql_query("INSERT INTO products_inpack(PACK_PRODUCTID, PRODUCTID) VALUES ('$q','".$qa[1]."')") or die(mysql_error());
			}
		}
		//end brand array
	
		httpRedirect("/".$content['MOD_NAME']);
	}

}
else if($qa[0] == "delete")
{
	productsDelete($qa[1]);
	httpRedirect("/".$content['MOD_NAME']);	
}
else if($qa[0] == "delete-image" && $qa[1] != "")
{
	productDeleteImage($qa[1]);
	httpRedirect("/admin/products/edit/".$qa[1]);
}
else if($qa[0] == "results")
{
	$_SESSION['ADMIN']['PRODUCTS']['CURRENT_RESULT'] = $qa[1];
}
else if($qa[0] == "reset")
{
	unset($_SESSION['ADMIN']['PRODUCTS']['SEARCH']);
	unset($_SESSION['ADMIN']['PRODUCTS']['CURRENT_RESULT']);
	httpRedirect("/".$content['MOD_NAME']);
}
else
{
	$search = $_SESSION['ADMIN']['PRODUCTS']['SEARCH'];
	$current_result = $_SESSION['ADMIN']['PRODUCTS']['CURRENT_RESULT'];
	if($current_result != "" && $qa[1] == "")
		httpRedirect("/".$content['MOD_NAME']."/results/".$current_result);
}
?>