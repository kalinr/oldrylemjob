<?php

// delete
if (($qa[0] == "delete-medium" || $qa[0] == "delete-aesthetic" || $qa[0] == "delete-season" || $qa[0] == "delete-brand" || $qa[0] == "delete-type") && $qa[1] != "") {

  $cleanType = mysql_real_escape_string($qa[0]);
  $cleanID = mysql_real_escape_string($qa[1]);
  
  switch ($cleanType) {
  
    case 'delete-medium' :
    
      $qry = "UPDATE medium SET ACTIVE=0 WHERE MEDIUM_ID=" . $cleanID;
      mysql_query($qry) or die(mysql_error());
      break;
  
    case 'delete-aesthetic' :
    
      $qry = "UPDATE aesthetic SET ACTIVE=0 WHERE AESTHETIC_ID=" . $cleanID;
      mysql_query($qry) or die(mysql_error());
      break;

    case 'delete-season' :
    
      $qry = "UPDATE season SET ACTIVE=0 WHERE SEASON_ID=" . $cleanID;
      mysql_query($qry) or die(mysql_error());
      break;

    case 'delete-type' :
    
      $qry = "UPDATE project_type SET ACTIVE=0 WHERE TYPE_ID=" . $cleanID;
      mysql_query($qry) or die(mysql_error());
      break;

    case 'delete-brand' :
    
      $qry = "UPDATE project_brand SET ACTIVE=0 WHERE PROJECT_BRAND_ID=" . $cleanID;
      mysql_query($qry) or die(mysql_error());
      break;
  
  }

  httpRedirect("/" . $content['MOD_NAME']);

}

// update non-brand items
elseif (($qa[0] == "update-medium" || $qa[0] == "update-aesthetic" || $qa[0] == "update-season" || $qa[0] == "update-type") && $qa[1] != "" && isset($_POST['TITLE']) && !empty($_POST['TITLE'])) {

  $cleanType = mysql_real_escape_string($qa[0]);
  $cleanID = mysql_real_escape_string($qa[1]);
  $cleanTitle = mysql_real_escape_string($_POST['TITLE']);
  $cleanOrder = mysql_real_escape_string($_POST['ORDER']);
  
  switch ($cleanType) {
  
    case 'update-medium' :
    
      $qry = "UPDATE medium SET MEDIUM_TITLE='" . $cleanTitle . "', DISPLAY_ORDER='" . $cleanOrder . "' WHERE MEDIUM_ID=" . $cleanID;
      mysql_query($qry) or die(mysql_error());
      break;
  
    case 'update-aesthetic' :
    
      $qry = "UPDATE aesthetic SET AESTHETIC_TITLE='" . $cleanTitle . "', DISPLAY_ORDER='" . $cleanOrder . "' WHERE AESTHETIC_ID=" . $cleanID;
      mysql_query($qry) or die(mysql_error());
      break;

    case 'update-season' :
    
      $qry = "UPDATE season SET SEASON_TITLE='" . $cleanTitle . "', DISPLAY_ORDER='" . $cleanOrder . "' WHERE SEASON_ID=" . $cleanID;
      mysql_query($qry) or die(mysql_error());
      break;

    case 'update-type' :
    
      $qry = "UPDATE project_type SET TYPE_TITLE='" . $cleanTitle . "', DISPLAY_ORDER='" . $cleanOrder . "' WHERE TYPE_ID=" . $cleanID;
      mysql_query($qry) or die(mysql_error());
      break;
  
  }

  httpRedirect("/" . $content['MOD_NAME']);

}

// update brand items
elseif ($qa[0] == "update-brand" && $qa[1] != "" && isset($_POST['ORDER'])) {

  $cleanID = mysql_real_escape_string($qa[1]);
  $cleanOrder = mysql_real_escape_string($_POST['ORDER']);
  
  $qry = "UPDATE project_brand SET DISPLAY_ORDER='" . $cleanOrder . "' WHERE PROJECT_BRAND_ID=" . $cleanID;
  mysql_query($qry) or die(mysql_error());

  httpRedirect("/" . $content['MOD_NAME']);

}

// create
elseif (!empty($_POST) && !isset($qa[0])) {

  if (isset($_POST['BUTTON']) && (!empty($_POST['TITLE']) || !empty($_POST['BRAND_ID']))) {
  
    $cleanBtn = mysql_real_escape_string($_POST['BUTTON']);
      
    switch ($cleanBtn) {
    
      case 'Add Medium' :
    
        $cleanTitle = mysql_real_escape_string($_POST['TITLE']);
        $qry = "INSERT INTO medium VALUES(NULL, '$cleanTitle', 10, 1)";
        mysql_query($qry) or die(mysql_error());
        break;
  
      case 'Add Aesthetic' :

        $cleanTitle = mysql_real_escape_string($_POST['TITLE']);     
        $qry = "INSERT INTO aesthetic VALUES(NULL, '$cleanTitle', 10, 1)";
        mysql_query($qry) or die(mysql_error());
        break;

      case 'Add Brand' :

        $cleanBrand = mysql_real_escape_string($_POST['BRAND_ID']);     
        $qry = "INSERT INTO project_brand VALUES(NULL, '$cleanBrand', 10, 1)";
        mysql_query($qry) or die(mysql_error());      
        break;

      case 'Add Season / Occasion' :

        $cleanTitle = mysql_real_escape_string($_POST['TITLE']);    
        $qry = "INSERT INTO season VALUES(NULL, '$cleanTitle', 10, 1)";
        mysql_query($qry) or die(mysql_error());
        break;

      case 'Add Project Type' :
    
        $cleanTitle = mysql_real_escape_string($_POST['TITLE']);
        $qry = "INSERT INTO project_type VALUES(NULL, '$cleanTitle', 10, 1)";
        mysql_query($qry) or die(mysql_error());
        break;      
    
    }
  
    httpRedirect("/" . $content['MOD_NAME']);
  
  }

}
  
?>