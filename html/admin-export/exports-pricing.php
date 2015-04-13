<?php

  require_once("../functions/db.php");  

  header('Content-Type: application/csv');
  header('Content-Disposition: attachment; filename="price-export.csv";');  
  header('Pragma: public');
  header('Expires: 0');
  header('Cache-Control: must-revalidate');

  function encloseDataCommas($str) {
    $str = str_replace(',','","',$str);
    return $str;
  }

  $query = "SELECT SKU,NAME,WHOLESALE_COST,RETAIL_COST FROM products WHERE SKU !=''";
  $result = mysql_query($query) or die (mysql_error());

  $headers = array('SKU', 'Product Name', 'Retail Cost', 'Wholesale Cost');

  $fh = fopen('php://output', 'w');
  fputcsv($fh, $headers);
  
  while ($data = mysql_fetch_assoc($result)) {

    $arr = array();
    $arr[]= encloseDataCommas($data['SKU']);
    $arr[]= encloseDataCommas($data['NAME']);
    $retail = number_format($data['RETAIL_COST'], 2);
    $wholesale = number_format($data['WHOLESALE_COST'], 2);
    $arr[]= encloseDataCommas($retail);
    $arr[]= encloseDataCommas($wholesale);
    fputcsv($fh, $arr, ',', '"');
    
  }

  fclose($fh);

?>