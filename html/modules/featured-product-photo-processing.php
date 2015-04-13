<?php

$successMsg = '';
$displayError = '';

if (isset($_POST['submitted']) && $_POST['submitted'] == 'y') {

  if (!isset($_POST['selectedProductID'])) {
  
    $displayError = 'Please select a photo.';
     
  }
  
  else {

    $successMsg = 'Photo has been selected.';
  
  }
  
  $updtQry = "UPDATE brands SET FEATURED_PRODUCT='" . $_POST['selectedProductID'] . "' WHERE ID='" . $qa[0] . "'";
  mysql_query($updtQry) or die(mysql_error());
  
}

$brandQry = "SELECT * FROM brands WHERE ID='" . $qa[0] . "'"; 
$brandRes = mysql_query($brandQry) or die(mysql_error()); 
$brandData = mysql_fetch_assoc($brandRes);

$productQry = "SELECT products.ID, products.NAME FROM brands_products JOIN products ON products.ID=brands_products.PRODUCTID WHERE brands_products.BRANDID='" . $qa[0] . "' ORDER BY brands_products.PRODUCTSORT ASC";
$productRes = mysql_query($productQry) or die(mysql_error());

?>