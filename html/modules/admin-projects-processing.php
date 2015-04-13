<?php

function buildFacets($projectID) {

  // medium
  $allMediums = count($_POST['medium']);
  for ($i=0; $i<$allMediums; $i++) {      
    $facID = $_POST['medium'][$i];
    $qry = "INSERT INTO project_facet VALUES(NULL, '$projectID', 1, '$facID')";
    mysql_query($qry) or die(mysql_error());      
  }
    
  // aesthetics
  $allAesthetics = count($_POST['aesthetic']);
  for ($i=0; $i<$allAesthetics; $i++) {
    $facID = $_POST['aesthetic'][$i];
    $qry = "INSERT INTO project_facet VALUES(NULL, '$projectID', 3, '$facID')";
    mysql_query($qry) or die(mysql_error());
  }

  // brands
  $allBrands = count($_POST['brand']);
  for ($i=0; $i<$allBrands; $i++) {
    $facID = $_POST['brand'][$i];
    $qry = "INSERT INTO project_facet VALUES(NULL, '$projectID', 2, '$facID')";
    mysql_query($qry) or die(mysql_error());
  } 

  // season
  $allSeasons = count($_POST['season']);
  for ($i=0; $i<$allSeasons; $i++) {      
    $facID = $_POST['season'][$i];
    $qry = "INSERT INTO project_facet VALUES(NULL, '$projectID', 4, '$facID')";
    mysql_query($qry) or die(mysql_error());
  }

  // project type
  $allTypes = count($_POST['type']);
  for ($i=0; $i<$allTypes; $i++) {      
    $facID = $_POST['type'][$i];
    $qry = "INSERT INTO project_facet VALUES(NULL, '$projectID', 5, '$facID')";
    mysql_query($qry) or die(mysql_error());
  }

}


// defaults for creation
$projectTitle = '';
$projectArtist = '';
$projectSummary = '';
$projectPhoto = '';
$projectVideo = '';
$projectText = '';
$projectKeywords = '';
$projectDifficulty = '';
$projectTime = '';
$projectMaterials = '';


// update
if (isset($qa[0]) && $qa[0] > 0) {

  // existing values for update
  $query = "SELECT * FROM project WHERE PROJECT_ID='" . $qa[0] . "' AND ACTIVE='1'";
  $result = mysql_query($query) or die ("error1" . mysql_error());
  $info = mysql_fetch_assoc($result);

  $projectID = $info['PROJECT_ID'];    
  $projectTitle = $info['PROJECT_TITLE'];
  $projectArtist = $info['PROJECT_ARTIST'];
  $projectSummary = $info['PROJECT_SUMMARY'];
  $projectPhoto = $info['PROJECT_PHOTO'];
  $projectVideo = $info['PROJECT_VIDEO'];
  $projectText = $info['PROJECT_TEXT'];
  $projectKeywords = $info['PROJECT_KEYWORDS'];
  $projectDifficulty = $info['PROJECT_DIFFICULTY'];
  $projectTime = $info['PROJECT_TIME'];
  $projectMaterials = $info['PROJECT_MATERIALS'];

  if (isset($qa[1]) && $qa[1] == "delete") {
  
    $qry = "UPDATE project SET ACTIVE=0 WHERE PROJECT_ID='" . $qa[0] . "'";
    mysql_query($qry) or die(mysql_error());
    
    $qry = "DELETE FROM project_facet WHERE PROJECT_ID='" . $qa[0] . "'";
    mysql_query($qry) or die(mysql_error());
    
    httpRedirect("/" . $content['MOD_NAME']);
    
  }

  if (isset($qa[1]) && $qa[1] == "remove-photo") {
  
    $qry = "UPDATE project SET PROJECT_PHOTO='' WHERE PROJECT_ID='" . $qa[0] . "'";
    mysql_query($qry) or die(mysql_error());
    
    // delete file
    unlink('images/projects/' . $qa[0] . '/' . $projectPhoto);
 
    httpRedirect("/" . $content['MOD_NAME']);
    
  }
  
  if ($_POST['BUTTON'] == "Save") {

    $projectTitle = mysql_real_escape_string($_POST['PROJECT_TITLE']);
    $projectArtist = mysql_real_escape_string($_POST['PROJECT_ARTIST']);
    $projectSummary = mysql_real_escape_string($_POST['PROJECT_SUMMARY']);
    $projectVideo = mysql_real_escape_string($_POST['PROJECT_VIDEO']);
    $projectText = mysql_real_escape_string($_POST['PROJECT_TEXT']);
    $projectKeywords = mysql_real_escape_string($_POST['PROJECT_KEYWORDS']);  
    $projectDifficulty = mysql_real_escape_string($_POST['PROJECT_DIFFICULTY']);
    $projectTime = mysql_real_escape_string($_POST['PROJECT_TIME']);
    $projectMaterials = mysql_real_escape_string($_POST['PROJECT_MATERIALS']);
  
    $qry = "UPDATE project SET PROJECT_TITLE='" . $projectTitle . "',";
    $qry .= "PROJECT_ARTIST='" . $projectArtist . "',";
    $qry .= "PROJECT_SUMMARY='" . $projectSummary . "',";
    $qry .= "PROJECT_VIDEO='" . $projectVideo . "',";
    $qry .= "PROJECT_TEXT='" . $projectText . "',";
    $qry .= "PROJECT_KEYWORDS='" . $projectKeywords . "',";
    $qry .= "PROJECT_DIFFICULTY='" . $projectDifficulty . "',";
    $qry .= "PROJECT_TIME='" . $projectTime . "',";
    $qry .= "PROJECT_MATERIALS='" . $projectMaterials . "' ";
    $qry .= "WHERE PROJECT_ID='" . $qa[0] . "'";
    $res = mysql_query($qry) or die(mysql_error());   
    
    if (!empty($_FILES) && $_FILES['PROJECT_PHOTO']['error'] == 0) {

      $fileName = $_FILES['PROJECT_PHOTO']['name'];
      fileUpload('images/projects/' . $qa[0] . '/', $fileName, "PROJECT_PHOTO");
      $qry = "UPDATE project SET PROJECT_PHOTO='" . $fileName . "' WHERE PROJECT_ID='" . $qa[0] . "'";
      mysql_query($qry) or die(mysql_error());

    }
    
    // wipe all saved facets
    $qry = "DELETE FROM project_facet WHERE PROJECT_ID='" . $qa[0] . "'";
    mysql_query($qry) or die(mysql_error()); 

    buildFacets($qa[0]);    

    httpRedirect("/" . $content['MOD_NAME']);
 
  }
  
}

// creation
else {

  if ($_POST['BUTTON'] == "Save") {

    $projectTitle = mysql_real_escape_string($_POST['PROJECT_TITLE']);
    $projectArtist = mysql_real_escape_string($_POST['PROJECT_ARTIST']);
    $projectSummary = mysql_real_escape_string($_POST['PROJECT_SUMMARY']);
    $projectVideo = mysql_real_escape_string($_POST['PROJECT_VIDEO']);
    $projectText = mysql_real_escape_string($_POST['PROJECT_TEXT']);
    $projectKeywords = mysql_real_escape_string($_POST['PROJECT_KEYWORDS']);  
    $projectDifficulty = mysql_real_escape_string($_POST['PROJECT_DIFFICULTY']);
    $projectTime = mysql_real_escape_string($_POST['PROJECT_TIME']);
    $projectMaterials = mysql_real_escape_string($_POST['PROJECT_MATERIALS']);
    $creationTime = time();

    $qry = "INSERT INTO project VALUES(NULL, '$projectTitle', '$projectArtist', '$projectSummary', '', '$projectVideo', '$projectText', '$projectKeywords', '$projectDifficulty', '$projectTime', '$projectMaterials', '$creationTime', 1)";
    mysql_query($qry) or die(mysql_error());
    $theProjectID = mysql_insert_id();
 
    $theNewDirPath = 'images/projects/' . $theProjectID;
    if (!file_exists($theNewDirPath)) {
      mkdir($theNewDirPath, 0777);
      chmod($theNewDirPath, 0777);
    }  

    if (!empty($_FILES) && $_FILES['PROJECT_PHOTO']['error'] == 0) {

      $fileName = $_FILES['PROJECT_PHOTO']['name'];
      fileUpload($theNewDirPath . '/', $fileName, "PROJECT_PHOTO");
      $qry = "UPDATE project SET PROJECT_PHOTO='" . $fileName . "' WHERE PROJECT_ID='" . $theProjectID . "'";
      mysql_query($qry) or die(mysql_error());

    }
    
    buildFacets($theProjectID);
    
    httpRedirect("/" . $content['MOD_NAME']);
  
  }

}  
?>