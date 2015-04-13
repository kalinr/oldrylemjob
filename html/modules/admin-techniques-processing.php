<?php

// defaults for creation
$techniqueTitle = '';
$techniqueSummary = '';
$techniquePhoto = '';
$techniqueVideo = '';
$techniqueText = '';
$techniqueKeywords = '';

// update
if (isset($qa[0]) && $qa[0] > 0) {

  // existing values for update
  $query = "SELECT * FROM technique WHERE TECHNIQUE_ID='" . $qa[0] . "' AND ACTIVE='1'";
  $result = mysql_query($query) or die ("error1" . mysql_error());
  $info = mysql_fetch_assoc($result);

  $techniqueID = $info['TECHNIQUE_ID'];    
  $techniqueTitle = $info['TECHNIQUE_TITLE'];
  $techniqueSummary = $info['TECHNIQUE_SUMMARY'];
  $techniquePhoto = $info['TECHNIQUE_PHOTO'];
  $techniqueVideo = $info['TECHNIQUE_VIDEO'];
  $techniqueText = $info['TECHNIQUE_TEXT'];
  $techniqueKeywords = $info['TECHNIQUE_KEYWORDS'];

  if (isset($qa[1]) && $qa[1] == "delete") {
  
    $qry = "UPDATE technique SET ACTIVE=0 WHERE TECHNIQUE_ID='" . $qa[0] . "'";
    mysql_query($qry) or die(mysql_error());
    
    httpRedirect("/" . $content['MOD_NAME']);
    
  }

  if (isset($qa[1]) && $qa[1] == "remove-photo") {
  
    $qry = "UPDATE technique SET TECHNIQUE_PHOTO='' WHERE TECHNIQUE_ID='" . $qa[0] . "'";
    mysql_query($qry) or die(mysql_error());
    
    // delete file
    unlink('images/techniques/' . $qa[0] . '/' . $techniquePhoto);
 
    httpRedirect("/" . $content['MOD_NAME']);
    
  }
  
  if ($_POST['BUTTON'] == "Save") {

    $brandID = mysql_real_escape_string($_POST['BRAND_ID']);
    $techniqueTitle = mysql_real_escape_string($_POST['TECHNIQUE_TITLE']);
    $techniqueSummary = mysql_real_escape_string($_POST['TECHNIQUE_SUMMARY']);
    $techniqueVideo = mysql_real_escape_string($_POST['TECHNIQUE_VIDEO']);
    $techniqueText = mysql_real_escape_string($_POST['TECHNIQUE_TEXT']);
    $techniqueKeywords = mysql_real_escape_string($_POST['TECHNIQUE_KEYWORDS']);  
  
    $qry = "UPDATE technique SET TECHNIQUE_TITLE='" . $techniqueTitle . "',";
    $qry .= "BRAND_ID='" . $brandID . "',";
    $qry .= "TECHNIQUE_SUMMARY='" . $techniqueSummary . "',";
    $qry .= "TECHNIQUE_VIDEO='" . $techniqueVideo . "',";
    $qry .= "TECHNIQUE_TEXT='" . $techniqueText . "',";
    $qry .= "TECHNIQUE_KEYWORDS='" . $techniqueKeywords . "' ";
    $qry .= "WHERE TECHNIQUE_ID='" . $qa[0] . "'";
    $res = mysql_query($qry) or die(mysql_error());   
    
    if (!empty($_FILES) && $_FILES['TECHNIQUE_PHOTO']['error'] == 0) {

      $fileName = $_FILES['TECHNIQUE_PHOTO']['name'];
      fileUpload('images/techniques/' . $qa[0] . '/', $fileName, "TECHNIQUE_PHOTO");
      $qry = "UPDATE technique SET TECHNIQUE_PHOTO='" . $fileName . "' WHERE TECHNIQUE_ID='" . $qa[0] . "'";
      mysql_query($qry) or die(mysql_error());

    }

    httpRedirect("/" . $content['MOD_NAME']);
 
  }
  
}

// creation
else {

  if ($_POST['BUTTON'] == "Save") {

    $brandID = mysql_real_escape_string($_POST['BRAND_ID']);
    $techniqueTitle = mysql_real_escape_string($_POST['TECHNIQUE_TITLE']);
    $techniqueSummary = mysql_real_escape_string($_POST['TECHNIQUE_SUMMARY']);
    $techniqueVideo = mysql_real_escape_string($_POST['TECHNIQUE_VIDEO']);
    $techniqueText = mysql_real_escape_string($_POST['TECHNIQUE_TEXT']);
    $techniqueKeywords = mysql_real_escape_string($_POST['TECHNIQUE_KEYWORDS']);
    $creationTime = time();

    $qry = "INSERT INTO technique VALUES(NULL, '$brandID', '$techniqueTitle', '$techniqueSummary', '', '$techniqueVideo', '$techniqueText', '$techniqueKeywords', '$creationTime', 1)";
    mysql_query($qry) or die(mysql_error());
    $theTechniqueID = mysql_insert_id();
 
    $theNewDirPath = 'images/techniques/' . $theTechniqueID;
    if (!file_exists($theNewDirPath)) {
      mkdir($theNewDirPath, 0777);
      chmod($theNewDirPath, 0777);
    }  

    if (!empty($_FILES) && $_FILES['TECHNIQUE_PHOTO']['error'] == 0) {

      $fileName = $_FILES['TECHNIQUE_PHOTO']['name'];
      fileUpload($theNewDirPath . '/', $fileName, "TECHNIQUE_PHOTO");
      $qry = "UPDATE technique SET TECHNIQUE_PHOTO='" . $fileName . "' WHERE TECHNIQUE_ID='" . $theTechniqueID . "'";
      mysql_query($qry) or die(mysql_error());

    }
    
    httpRedirect("/" . $content['MOD_NAME']);
  
  }

}  
?>