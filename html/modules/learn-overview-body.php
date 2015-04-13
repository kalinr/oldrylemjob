<?php

switch($content['MOD_NAME']) {

  case 'learn-fabric-overview' :
  
    $mod = 'fabric';
    break;
    
  case 'learn-paper-overview' :
  
    $mod = 'paper';
    break;

  case 'learn-mixed-media-overview' :
  
    $mod = 'mixed-media';
    break;

  case 'learn-tools-overview' :
  
    $mod = 'crafting-tools';
    break;

}

$qry = "SELECT * FROM categories WHERE MOD_NAME='" . $mod . "'";
$res = mysql_query($qry) or die(mysql_error());
$categoryData = mysql_fetch_assoc($res);

$qry = "SELECT brands.* FROM brands JOIN learn ON brands.ID=learn.BRAND_ID WHERE brands.ACTIVE=1 AND learn.ACTIVE=1 AND brands.CATEGORYID='" . $categoryData['ID'] . "' ORDER BY brands.NAME ASC";
$res = mysql_query($qry) or die(mysql_error());

while ($data = mysql_fetch_assoc($res)) {

  $qry = "SELECT * FROM brands_products JOIN products ON brands_products.PRODUCTID=products.ID WHERE brands_products.BRANDID='" . $data['ID'] . "' AND products.ACTIVE='1' ORDER BY products.ID DESC LIMIT 1";
  $prodRes = mysql_query($qry) or die(mysql_error());
  $prodArr = mysql_fetch_assoc($prodRes);
  
  echo '<div class="latestProduct"><div>';
  
  if (!file_exists("images/products/" . $prodArr['ID']. ".jpg")) {
    $img_filename = "0.jpg";
  }
  else {
    $img_filename = $prodArr['ID'] . ".jpg";
  }
  
  echo '<a href="/learn-', $data['MOD_NAME'], '"><img src="images/products/', $img_filename, '" alt="', $data['MOD_NAME'], '" />',
       '</div>', $data['NAME'], '</a>';
  
  echo '</div>';
       
}

echo '<div class="clr"></div>';

?>