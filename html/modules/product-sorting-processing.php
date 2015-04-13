<?php

if (isset($_POST['submitted']) && $_POST['submitted'] == 'y') {

  $allSortItems = count($_POST['sortingOrder']);
  
  for ($i=0; $i<$allSortItems; $i++) {

    if (!empty($_POST['theProducts'][$i])) {
    
      if (empty($_POST['sortingOrder'][$i]) || !is_numeric($_POST['sortingOrder'][$i])) { $sortVal = 0; }
      else { $sortVal = $_POST['sortingOrder'][$i]; }
    
      $updtQry = "UPDATE brands_products SET PRODUCTSORT='" . $sortVal . "' WHERE BRANDID='" . $_POST['theBrand'] . "' AND PRODUCTID='" . $_POST['theProducts'][$i] . "'";
      mysql_query($updtQry) or die(mysql_error());
    
    } 

  }

  $successMsg = 'Sort order has been updated.';
  
}

$brandQry = "SELECT NAME FROM brands WHERE ID='" . $qa[0] . "'"; 
$brandRes = mysql_query($brandQry) or die(mysql_error()); 
$brandData = mysql_fetch_assoc($brandRes);

$productQry = "SELECT products.NAME, products.SKU, brands_products.* FROM brands_products JOIN products ON products.ID=brands_products.PRODUCTID WHERE brands_products.BRANDID='" . $qa[0] . "' ORDER BY brands_products.PRODUCTSORT ASC";
$productRes = mysql_query($productQry) or die(mysql_error());

?>