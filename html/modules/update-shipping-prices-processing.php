<?php

if (isset($_POST['submitted']) && $_POST['submitted'] == 'y') {

  $displayError = '';
  $successMsg = '';

  // two day shipping  
  if (!empty($_FILES["two_day"]["name"])) {
  
    if ($_FILES['two_day']['error'] > 0) {

      switch($_FILES['two_day']['error']) {

        case 1 : $displayError .= 'File upload is too large for two day shipping.<br />'; break;
        case 2 : $displayError .= 'File upload is too large for two day shipping.<br />'; break;
        case 3 : $displayError .= 'File only partially uploaded for two day shipping.<br />'; break;
        case 4 : $displayError .= 'Please select a file to upload for two day shipping.<br />'; break;
        case 5 : $displayError .= 'A file upload error has occurred for two day shipping.<br />'; break;
        case 6 : $displayError .= 'Temporary folder is missing for two day shipping.<br />'; break;
        case 7 : $displayError .= 'Could not save file for two day shipping.<br />'; break;
        case 8 : $displayError .= 'A file upload error has occurred for two day shipping.<br />'; break;

      }

    }

    elseif ($_FILES["two_day"]["type"] != 'text/x-comma-separated-values' && $_FILES["two_day"]["type"] != 'text/comma-separated-values' && $_FILES["two_day"]["type"] != 'application/octet-stream' && $_FILES["two_day"]["type"] != 'application/vnd.ms-excel' && $_FILES["two_day"]["type"] != 'text/csv' && $_FILES["two_day"]["type"] != 'text/plain' && $_FILES["two_day"]["type"] != 'application/csv' && $_FILES["two_day"]["type"] != 'application/excel' && $_FILES["two_day"]["type"] != 'application/vnd.msexcel') {

      $displayError .= 'Please upload a supported file type for two day shipping.<br />';

    }

    else {

      $dataFile = fopen($_FILES["two_day"]["tmp_name"], 'r') or die('could not access file');

      while (($data = fgetcsv($dataFile, 0, ",")) !== FALSE) {

        // skip the headers row, invalid rows, and empty rows
        $trimmedNumber = trim($data[0]);      
        if ($trimmedNumber == 'Zones' || !is_numeric($trimmedNumber) || $trimmedNumber == '') { continue; }
     
        $trimmed202 = trim($data[1]);
        $trimmed203 = trim($data[2]);
        $trimmed204 = trim($data[3]);
        $trimmed205 = trim($data[4]);
        $trimmed206 = trim($data[5]);
        $trimmed207 = trim($data[6]);
        $trimmed208 = trim($data[7]);
        $trimmed224 = trim($data[8]);
        $trimmed225 = trim($data[9]);
        $trimmed226 = trim($data[10]);
    
        $qry = "UPDATE shipping_2day SET ";
        $qry .= "ZONE202='" . $trimmed202 . "',";
        $qry .= "ZONE203='" . $trimmed203 . "',";
        $qry .= "ZONE204='" . $trimmed204 . "',";
        $qry .= "ZONE205='" . $trimmed205 . "',";      
        $qry .= "ZONE206='" . $trimmed206 . "',";
        $qry .= "ZONE207='" . $trimmed207 . "',";      
        $qry .= "ZONE208='" . $trimmed208 . "',";      
        $qry .= "ZONE224='" . $trimmed224 . "',";
        $qry .= "ZONE225='" . $trimmed225 . "',";       
        $qry .= "ZONE226='" . $trimmed226 . "' ";       
        $qry .= "WHERE LBS='" . $trimmedNumber . "'";
        mysql_query($qry) or die(mysql_error());

      }
  
      $successMsg .= 'Two day shipping file upload has been processed.<br />';
 
    }
  
  }


  // ground shipping  
  if (!empty($_FILES["ground"]["name"])) {
  
    if ($_FILES['ground']['error'] > 0) {

      switch($_FILES['ground']['error']) {

        case 1 : $displayError .= 'File upload is too large for ground shipping.<br />'; break;
        case 2 : $displayError .= 'File upload is too large for ground shipping.<br />'; break;
        case 3 : $displayError .= 'File only partially uploaded for ground shipping.<br />'; break;
        case 4 : $displayError .= 'Please select a file to upload for ground shipping.<br />'; break;
        case 5 : $displayError .= 'A file upload error has occurred for ground shipping.<br />'; break;
        case 6 : $displayError .= 'Temporary folder is missing for ground shipping.<br />'; break;
        case 7 : $displayError .= 'Could not save file for ground shipping.<br />'; break;
        case 8 : $displayError .= 'A file upload error has occurred for ground shipping.<br />'; break;

      }

    }

    elseif ($_FILES["ground"]["type"] != 'text/x-comma-separated-values' && $_FILES["ground"]["type"] != 'text/comma-separated-values' && $_FILES["ground"]["type"] != 'application/octet-stream' && $_FILES["ground"]["type"] != 'application/vnd.ms-excel' && $_FILES["ground"]["type"] != 'text/csv' && $_FILES["ground"]["type"] != 'text/plain' && $_FILES["ground"]["type"] != 'application/csv' && $_FILES["ground"]["type"] != 'application/excel' && $_FILES["ground"]["type"] != 'application/vnd.msexcel') {

      $displayError .= 'Please upload a supported file type for ground shipping.<br />';

    }

    else {

      $dataFile = fopen($_FILES["ground"]["tmp_name"], 'r') or die('could not access file');

      while (($data = fgetcsv($dataFile, 0, ",")) !== FALSE) {

        // skip the headers row, invalid rows, and empty rows
        $trimmedNumber = trim($data[0]);      
        if ($trimmedNumber == 'Zones' || !is_numeric($trimmedNumber) || $trimmedNumber == '') { continue; }
     
        $trimmed2 = trim($data[1]);
        $trimmed3 = trim($data[2]);
        $trimmed4 = trim($data[3]);
        $trimmed5 = trim($data[4]);
        $trimmed6 = trim($data[5]);
        $trimmed7 = trim($data[6]);
        $trimmed8 = trim($data[7]);
        $trimmed44 = trim($data[8]);
        $trimmed45 = trim($data[9]);
        $trimmed46 = trim($data[10]);
    
        $qry = "UPDATE shipping_ground SET ";
        $qry .= "ZONE2='" . $trimmed2 . "',";
        $qry .= "ZONE3='" . $trimmed3 . "',";
        $qry .= "ZONE4='" . $trimmed4 . "',";
        $qry .= "ZONE5='" . $trimmed5 . "',";      
        $qry .= "ZONE6='" . $trimmed6 . "',";
        $qry .= "ZONE7='" . $trimmed7 . "',";      
        $qry .= "ZONE8='" . $trimmed8 . "',";      
        $qry .= "ZONE44='" . $trimmed44 . "',";
        $qry .= "ZONE45='" . $trimmed45 . "',";       
        $qry .= "ZONE46='" . $trimmed46 . "' ";       
        $qry .= "WHERE LBS='" . $trimmedNumber . "'";
        mysql_query($qry) or die(mysql_error());

      }
  
      $successMsg .= 'Ground shipping file upload has been processed.<br />';
 
    }
  
  }


  // two day shipping over 150 pounds
  if (!empty($_FILES["over150_two_day"]["name"])) {
  
    if ($_FILES['over150_two_day']['error'] > 0) {

      switch($_FILES['over150_two_day']['error']) {

        case 1 : $displayError .= 'File upload is too large for over 150 pound two day shipping.<br />'; break;
        case 2 : $displayError .= 'File upload is too large for over 150 pound two day shipping.<br />'; break;
        case 3 : $displayError .= 'File only partially uploaded for over 150 pound two day shipping.<br />'; break;
        case 4 : $displayError .= 'Please select a file to upload for over 150 pound two day shipping.<br />'; break;
        case 5 : $displayError .= 'A file upload error has occurred for over 150 pound two day shipping.<br />'; break;
        case 6 : $displayError .= 'Temporary folder is missing for over 150 pound two day shipping.<br />'; break;
        case 7 : $displayError .= 'Could not save file for over 150 pound two day shipping.<br />'; break;
        case 8 : $displayError .= 'A file upload error has occurred for over 150 pound two day shipping.<br />'; break;

      }

    }

    elseif ($_FILES["over150_two_day"]["type"] != 'text/x-comma-separated-values' && $_FILES["over150_two_day"]["type"] != 'text/comma-separated-values' && $_FILES["over150_two_day"]["type"] != 'application/octet-stream' && $_FILES["over150_two_day"]["type"] != 'application/vnd.ms-excel' && $_FILES["over150_two_day"]["type"] != 'text/csv' && $_FILES["over150_two_day"]["type"] != 'text/plain' && $_FILES["over150_two_day"]["type"] != 'application/csv' && $_FILES["over150_two_day"]["type"] != 'application/excel' && $_FILES["over150_two_day"]["type"] != 'application/vnd.msexcel') {

      $displayError .= 'Please upload a supported file type for two day shipping.<br />';

    }

    else {

      $dataFile = fopen($_FILES["over150_two_day"]["tmp_name"], 'r') or die('could not access file');
      $count = 0;

      while (($data = fgetcsv($dataFile, 0, ",")) !== FALSE) {

        $count++;
        if ($count == 1) { continue; }

        // skip the headers row, invalid rows, and empty rows
        $trimmedNumber = trim($data[0]);      
     
        $trimmed202 = trim($data[0]);
        $trimmed203 = trim($data[1]);
        $trimmed204 = trim($data[2]);
        $trimmed205 = trim($data[3]);
        $trimmed206 = trim($data[4]);
        $trimmed207 = trim($data[5]);
        $trimmed208 = trim($data[6]);
        $trimmed224 = trim($data[7]);
        $trimmed225 = trim($data[8]);
        $trimmed226 = trim($data[9]);
    
        $qry = "UPDATE shipping_2day_over150 SET ";
        $qry .= "ZONE202='" . $trimmed202 . "',";
        $qry .= "ZONE203='" . $trimmed203 . "',";
        $qry .= "ZONE204='" . $trimmed204 . "',";
        $qry .= "ZONE205='" . $trimmed205 . "',";      
        $qry .= "ZONE206='" . $trimmed206 . "',";
        $qry .= "ZONE207='" . $trimmed207 . "',";      
        $qry .= "ZONE208='" . $trimmed208 . "',";      
        $qry .= "ZONE224='" . $trimmed224 . "',";
        $qry .= "ZONE225='" . $trimmed225 . "',";       
        $qry .= "ZONE226='" . $trimmed226 . "' ";       
        $qry .= "WHERE SHIP_2DAY_OVERWEIGHT_ID=1";
        mysql_query($qry) or die(mysql_error());

      }
  
      $successMsg .= 'Over 150 pounds two day shipping file upload has been processed.<br />';
 
    }
  
  }


  // ground shipping over 150 pounds
  if (!empty($_FILES["over150_ground"]["name"])) {
  
    if ($_FILES['over150_ground']['error'] > 0) {

      switch($_FILES['over150_ground']['error']) {

        case 1 : $displayError .= 'File upload is too large for over 150 pound ground shipping.'; break;
        case 2 : $displayError .= 'File upload is too large for over 150 pound ground shipping.'; break;
        case 3 : $displayError .= 'File only partially uploaded for over 150 pound ground shipping.'; break;
        case 4 : $displayError .= 'Please select a file to upload for over 150 pound ground shipping.'; break;
        case 5 : $displayError .= 'A file upload error has occurred for over 150 pound ground shipping.'; break;
        case 6 : $displayError .= 'Temporary folder is missing for over 150 pound ground shipping.'; break;
        case 7 : $displayError .= 'Could not save file for over 150 pound ground shipping.'; break;
        case 8 : $displayError .= 'A file upload error has occurred for over 150 pound ground shipping.'; break;

      }

    }

    elseif ($_FILES["over150_ground"]["type"] != 'text/x-comma-separated-values' && $_FILES["over150_ground"]["type"] != 'text/comma-separated-values' && $_FILES["over150_ground"]["type"] != 'application/octet-stream' && $_FILES["over150_ground"]["type"] != 'application/vnd.ms-excel' && $_FILES["over150_ground"]["type"] != 'text/csv' && $_FILES["over150_ground"]["type"] != 'text/plain' && $_FILES["over150_ground"]["type"] != 'application/csv' && $_FILES["over150_ground"]["type"] != 'application/excel' && $_FILES["over150_ground"]["type"] != 'application/vnd.msexcel') {

      $displayError .= 'Please upload a supported file type for over 150 pound ground shipping.';

    }

    else {

      $dataFile = fopen($_FILES["over150_ground"]["tmp_name"], 'r') or die('could not access file');
      $count = 0;

      while (($data = fgetcsv($dataFile, 0, ",")) !== FALSE) {

        $count++;
        if ($count == 1) { continue; }

        // skip the headers row, invalid rows, and empty rows
        $trimmedNumber = trim($data[0]);
     
        $trimmed2 = trim($data[0]);
        $trimmed3 = trim($data[1]);
        $trimmed4 = trim($data[2]);
        $trimmed5 = trim($data[3]);
        $trimmed6 = trim($data[4]);
        $trimmed7 = trim($data[5]);
        $trimmed8 = trim($data[6]);
        $trimmed44 = trim($data[7]);
        $trimmed45 = trim($data[8]);
        $trimmed46 = trim($data[9]);
    
        $qry = "UPDATE shipping_ground_over150 SET ";
        $qry .= "ZONE2='" . $trimmed2 . "',";
        $qry .= "ZONE3='" . $trimmed3 . "',";
        $qry .= "ZONE4='" . $trimmed4 . "',";
        $qry .= "ZONE5='" . $trimmed5 . "',";      
        $qry .= "ZONE6='" . $trimmed6 . "',";
        $qry .= "ZONE7='" . $trimmed7 . "',";      
        $qry .= "ZONE8='" . $trimmed8 . "',";      
        $qry .= "ZONE44='" . $trimmed44 . "',";
        $qry .= "ZONE45='" . $trimmed45 . "',";       
        $qry .= "ZONE46='" . $trimmed46 . "' ";       
        $qry .= "WHERE SHIP_GROUND_OVERWEIGHT_ID=1";
        mysql_query($qry) or die(mysql_error());

      }
  
      $successMsg .= 'Over 150 pounds ground shipping file upload has been processed.';
 
    }
  
  }
  
}

$twoDayQry = "SELECT * FROM shipping_2day";
$twoDayRes = mysql_query($twoDayQry) or die(mysql_error());

$groundQry = "SELECT * FROM shipping_ground";
$groundRes = mysql_query($groundQry) or die(mysql_error());

$over150twoDayQry = "SELECT * FROM shipping_2day_over150";
$over150twoDayRes = mysql_query($over150twoDayQry) or die(mysql_error());

$over150groundQry = "SELECT * FROM shipping_ground_over150";
$over150groundRes = mysql_query($over150groundQry) or die(mysql_error());

?>