<?php

if (isset($_POST['submitted']) && $_POST['submitted'] == 'y') {

  $displayError = '';
  $successMsg = '';

  if ($_FILES['products']['error'] > 0) {

    switch($_FILES['products']['error']) {

      case 1 : $displayError = 'File upload is too large'; break;
      case 2 : $displayError = 'File upload is too large'; break;
      case 3 : $displayError = 'File only partially uploaded'; break;
      case 4 : $displayError = 'Please select a file to upload'; break;
      case 5 : $displayError = 'A file upload error has occurred'; break;
      case 6 : $displayError = 'Temporary folder is missing'; break;
      case 7 : $displayError = 'Could not save file'; break;
      case 8 : $displayError = 'A file upload error has occurred'; break;

    }

  }

  elseif ($_FILES["products"]["type"] != 'text/x-comma-separated-values' && $_FILES["products"]["type"] != 'text/comma-separated-values' && $_FILES["products"]["type"] != 'application/octet-stream' && $_FILES["products"]["type"] != 'application/vnd.ms-excel' && $_FILES["products"]["type"] != 'text/csv' && $_FILES["products"]["type"] != 'text/plain' && $_FILES["products"]["type"] != 'application/csv' && $_FILES["products"]["type"] != 'application/excel' && $_FILES["products"]["type"] != 'application/vnd.msexcel') {

    $displayError = 'Please upload a supported file type.';

  }

  else {

    $dataFile = fopen($_FILES["products"]["tmp_name"], 'r') or die('could not access file');
    $count = 0;

    while (($data = fgetcsv($dataFile, 0, ",")) !== FALSE) {

      // skip the headers row
      if (trim($data[0]) == 'SKU') { continue; }

      $trimmedSKU = trim($data[0]);

      // skip empty rows
      if ($trimmedSKU == '') { continue; }

      $trimmedRetail = trim($data[1]);
      $trimmedRetail = str_replace('$', '', $trimmedRetail);
      $trimmedWholesale = trim($data[2]);
      $trimmedWholesale = str_replace('$', '', $trimmedWholesale);
      $trimmedWeight = trim($data[3]);
      $trimmedLength = trim($data[4]);
      $trimmedWidth = trim($data[5]);
      $trimmedHeight = trim($data[6]);

      // retail
      if ($trimmedRetail != '') {
    
        $qry = "UPDATE products SET RETAIL_COST='" . $trimmedRetail . "' WHERE SKU='" . $trimmedSKU . "'";
        mysql_query($qry) or die(mysql_error());    
    
      }

      // wholesale
      if ($trimmedWholesale != '') {
      
        $qry = "UPDATE products SET WHOLESALE_COST='" . $trimmedWholesale . "' WHERE SKU='" . $trimmedSKU . "'";
        mysql_query($qry) or die(mysql_error());    
    
      }

      // weight
      if ($trimmedWeight != '') {
    
        $qry = "UPDATE products SET PIECE_SPECS_WEIGHT_OZ='" . $trimmedWeight . "' WHERE SKU='" . $trimmedSKU . "'";
        mysql_query($qry) or die(mysql_error());    
    
      }
 
      // length
      if ($trimmedLength != '') {
    
        $qry = "UPDATE products SET PIECE_SPECS_LENGTH='" . $trimmedLength . "' WHERE SKU='" . $trimmedSKU . "'";
        mysql_query($qry) or die(mysql_error());    
    
      }

      // width
      if ($trimmedWidth != '') {
    
        $qry = "UPDATE products SET PIECE_SPECS_WIDTH='" . $trimmedWidth . "' WHERE SKU='" . $trimmedSKU . "'";
        mysql_query($qry) or die(mysql_error());    
    
      }

      // height
      if ($trimmedHeight != '') {
    
        $qry = "UPDATE products SET PIECE_SPECS_HEIGHT='" . $trimmedHeight . "' WHERE SKU='" . $trimmedSKU . "'";
        mysql_query($qry) or die(mysql_error());    
    
      }
    
      $count++;

    }
 
    $successMsg = 'File upload has been processed. ' . $count . ' products were modified.';
 
  }
  
}

?>