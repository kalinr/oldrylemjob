<?php

$qry = "SELECT * FROM categories WHERE MOD_NAME='" . $content['MOD_NAME'] . "'";
$res = mysql_query($qry) or die(mysql_error());
$categoryData = mysql_fetch_assoc($res);

$qry = "SELECT * FROM brands WHERE ACTIVE='1' AND CATEGORYID='" . $categoryData['ID'] . "' ORDER BY NAME ASC";
$res = mysql_query($qry) or die(mysql_error());

while ($data = mysql_fetch_assoc($res)) {

  $qry = "SELECT * FROM brands_products JOIN products ON brands_products.PRODUCTID=products.ID WHERE brands_products.BRANDID='" . $data['ID'] . "' AND products.ACTIVE='1' ORDER BY products.ID DESC LIMIT 1";
  $prodRes = mysql_query($qry) or die(mysql_error());
  $prodArr = mysql_fetch_assoc($prodRes);
  
  echo '<div class="latestProduct"><div>';
  
  // featured product photo chosen
  if ($data['FEATURED_PRODUCT'] > 0) {
  
    if (!file_exists("images/products/" . $data['FEATURED_PRODUCT']. ".jpg")) {
      $img_filename = "0.jpg";
    }
    else {
      $img_filename = $data['FEATURED_PRODUCT'] . ".jpg";
    }    
  
  }
  
  // featured product photo not selected
  else {
  
    if (!file_exists("images/products/" . $prodArr['ID']. ".jpg")) {
      $img_filename = "0.jpg";
    }
    else {
      $img_filename = $prodArr['ID'] . ".jpg";
    }
    
  }
  
  echo '<a href="/', $data['MOD_NAME'], '"><img src="images/products/', $img_filename, '" alt="', $data['MOD_NAME'], '" />',
       '</div>', $data['NAME'], '</a>';
  
  echo '</div>';
       
}

echo '<div class="clr"></div>';

?>