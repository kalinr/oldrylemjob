<?
if($qa[1] != "")
{
	$query = "SELECT * FROM brands WHERE ID='".$qa[1]."'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	$categoryid = $row['CATEGORYID'];
	$name = $row['NAME'];
	$description = $row['DESCRIPTION'];
	$banner = $row['BANNER'];
	$active = $row['ACTIVE'];
	
	if($qa[2] == "collections")
	{
		$count = 0;
		$collections_array[0]= "";
		$top_order_array[0] = "";
		$display_title_array[0] = "";
		$query = "SELECT * FROM brands_collections WHERE BRANDID='".$qa[1]."' ORDER BY ID DESC";
		$result = mysql_query($query) or die ("error1" . mysql_error());
		while($row = mysql_fetch_array($result))
		{
			$collections_array[$count] = $row['PRODUCTID'];
			$top_order_array[$count] = $row['TOP_ORDER'];
			$display_title_array[$count] = $row['DISPLAY_TITLE'];
			$count++;
		}
		$collections_array = array_reverse($collections_array);
	}
	else if($qa[2] == "related")
	{
		$count = 0;
		$products_array[0]= "";
		$top_order_array[0] = "";
		$display_title_array[0] = "";
		$query = "SELECT * FROM brands_related WHERE BRANDID='".$qa[1]."' ORDER BY ID DESC";
		$result = mysql_query($query) or die ("error1" . mysql_error());
		while($row = mysql_fetch_array($result))
		{
			$products_array[$count] = $row['PRODUCTID'];
			$top_order_array[$count] = $row['TOP_ORDER'];
			$display_title_array[$count] = $row['DISPLAY_TITLE'];
			$count++;
		}
		//$products_array = array_reverse($products_array);
	}
}
else
	unset($row);

if($_POST['BUTTON'] == "Save Collections")
{
	unset($collections_array);
	unset($top_order_array);
	unset($display_title_array);
	$collections_array = $_POST['COLLECTIONS'];
	$top_order_array = $_POST['TOP_ORDER'];
	$display_title_array = $_POST['DISPLAY_TITLE'];
	
	//clean arrays
	//clean arrays
	$count = 0;
	if(sizeof($top_order_array))
	{
		foreach($top_order_array as $i)
		{
			if(trim($i) != "")
			{
				$top_order_array2[$count] = trim($i);
				$count++;
			}
		}
	}
	if(sizeof($top_order_array2) > 0)
	{
		$top_order_array = array_reverse($top_order_array2);
		//$top_order_array = $top_order_array2;
	}
	else
		unset($top_order_array);
	$count = 0;
	if(sizeof($display_title_array))
	{
		foreach($display_title_array as $i)
		{
			if(trim($i) != "")
			{
				$display_title_array2[$count] = trim($i);
				$count++;
			}
		}
	}
	if(sizeof($display_title_array2) > 0)
	{
		$display_title_array = array_reverse($display_title_array2);
		//$display_title_array = $display_title_array2;
	}
	else
		unset($display_title_array);
	if(sizeof($collections_array) > 0)
	{
		$collections_array = array_reverse($collections_array);
		//$collections_array = $collections_array;
	}
	else
		unset($products_array);
	$size_compare = sizeof($collections_array);
	if($size_compare != sizeof($top_order_array))// OR $size_compare != sizeof($display_title_array))
		$error = "Make sure that all of your fields are typed in that you have checked.";
	else
	{
		$count = 0;
		mysql_query("DELETE FROM brands_collections WHERE BRANDID='".$qa[1]."'");
		if(sizeof($collections_array) > 0)
		{
			foreach($collections_array as $productid)
			{
				$top_order = $top_order_array[$count];
				$display_title = $display_title_array[$count];
	
				mysql_query("INSERT INTO brands_collections(BRANDID,PRODUCTID,DISPLAY_TITLE,TOP_ORDER) VALUES ('".$qa[1]."',$productid,'$display_title','$top_order')") or die(mysql_error());
				$count++;
			}
		}
		httpRedirect("/".$content['MOD_NAME']."/edit/".$qa[1]);
	}
}
if($_POST['BUTTON'] == "Save Related Products")
{
	unset($products_array);
	unset($top_order_array);
	unset($display_title_array);
	$products_array = $_POST['PRODUCTS'];
	$top_order_array = $_POST['TOP_ORDER'];
	$display_title_array = $_POST['DISPLAY_TITLE'];

	//clean arrays
	$count = 0;
	if(sizeof($top_order_array))
	{
		foreach($top_order_array as $i)
		{
			if(trim($i) != "")
			{
				$top_order_array2[$count] = trim($i);
				$count++;
			}
		}
	}
	if(sizeof($top_order_array2) > 0)
	{
		//$top_order_array = array_reverse($top_order_array2);
		$top_order_array = $top_order_array2;
	}
	else
		unset($top_order_array);
	$count = 0;
	if(sizeof($display_title_array))
	{
		foreach($display_title_array as $i)
		{
			if(trim($i) != "")
			{
				$display_title_array2[$count] = trim($i);
				$count++;
			}
		}
	}
	if(sizeof($display_title_array2) > 0)
	{
		$display_title_array = array_reverse($display_title_array2);
		//$display_title_array = $display_title_array2;
	}
	else
		unset($display_title_array);
	if(sizeof($products_array) > 0)
	{
		//$products_array = array_reverse($products_array);
		$products_array = $products_array;
	}
	else
		unset($products_array);
	//echo '<pre>';
	//print_r($products_array);
	//print_r($top_order_array);
	
	$size_compare = sizeof($products_array);
	if($size_compare != sizeof($top_order_array))// OR $size_compare != sizeof($display_title_array))
		$error = "Make sure that all of your fields are typed in that you have checked.";
	else
	{
		$count = 0;
		mysql_query("DELETE FROM brands_related WHERE BRANDID='".$qa[1]."'");
		if(sizeof($products_array) > 0)
		{
			$top_order_array = array_reverse($top_order_array);
			$display_title = array_reverse($display_title_array);
			$products_array = array_reverse($products_array);
			
			foreach($products_array as $productid)
			{
				$top_order = $top_order_array[$count];
				$display_title = $display_title_array[$count];

				mysql_query("INSERT INTO brands_related(BRANDID,PRODUCTID,DISPLAY_TITLE,TOP_ORDER) VALUES ('".$qa[1]."',$productid,'$display_title','$top_order')") or die(mysql_error());
				$count++;
			}
		}
		httpRedirect("/".$content['MOD_NAME']."/edit/".$qa[1]);
	}
}
else if($_POST['BUTTON'] == "Save")
{
	$categoryid = $_POST['CATEGORYID'];
	$name = $_POST['NAME'];
	$description = $_POST['DESCRIPTION'];
	$banner = $_POST['BANNER'];
	$active = $_POST['ACTIVE'];
	
	$banner = $_FILES['FILE']['name'];
	if($banner != '')
	{
		if(file_exists("images/brands/".$row['BANNER']) && $row['FILENAME'] != '')
			unlink("images/brands/".$row['BANNER']);
		mysql_query("UPDATE brands SET BANNER='' WHERE ID='".$qa[1]."'") or die(mysql_error());

		if(!fileUpload("images/brands/", $banner, "FILE"));
			$error = "There was a problem uploading the file.";
		$filename = $banner;
	}
	else
		$filename = $row['BANNER'];
	
	if($name == "")
		$error = "Please type in a name for this category.";
	else if($categoryid == "")
		$error = "Please select a category.";
	else if(!brandsNameUnique($qa[1],$name))
		$error = "$name is in use by another brand.";
	else
	{
		if($qa[1] == "")
			$qa[1] = brandsCreate($categoryid, $name, $description, $filename, $active);
		else
			brandsUpdate($qa[1], $categoryid, $name, $description, $filename, $active);
		httpRedirect("/".$content['MOD_NAME']);
	}
}
else if($qa[0] == "delete-image")
{
	if($banner != "")
	{
		if(file_exists("images/brands/".$banner))
			unlink("images/brands/".$banner);
	}
	mysql_query("UPDATE brands SET BANNER='' WHERE ID='".$qa[1]."'") or die(mysql_error());
	httpRedirect("/".$content['MOD_NAME']."/edit/".$qa[1]);
}
else if($qa[0] == "delete")
{
	brandsDelete($qa[1]);
	httpRedirect("/".$content['MOD_NAME']);
}
else if($qa[0] == "edit")
{
	$active = 1;
}
?>