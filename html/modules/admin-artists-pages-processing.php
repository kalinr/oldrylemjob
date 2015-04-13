<?php

// defaults for creation
$firstName = '';
$lastName = '';
$completeName = '';
$details = '';
$artistPhoto = '';
$project1Photo = '';
$project2Photo = '';
$project3Photo = '';
$title = '';
$meta_title = '';
$meta_description = '';
$meta_keywords = '';

// update
if (isset($qa[0]) && $qa[0] > 0) {

  // existing values for update
  $query = "SELECT * FROM artists WHERE ARTIST_ID='" . $qa[0] . "' AND ACTIVE='1'";
  $result = mysql_query($query) or die ("error1" . mysql_error());
  $info = mysql_fetch_assoc($result);
  
  $qry2 = "SELECT * FROM content WHERE ID='" . $info['CONTENT_ID'] . "'";
  $res = mysql_query($qry2) or die ("error1" . mysql_error());
  $contentInfo = mysql_fetch_assoc($res);
  
  $firstName = $info['FIRST_NAME'];
  $lastName = $info['LAST_NAME'];
  $completeName = $info['COMPLETE_NAME'];
  $details = $info['DETAILS'];
  $artistPhoto = $info['ARTIST_PHOTO'];
  $project1Photo = $info['PROJECT1_PHOTO'];
  $project2Photo = $info['PROJECT2_PHOTO'];
  $project3Photo = $info['PROJECT3_PHOTO'];
  $artistID = $info['ARTIST_ID'];
  $contentID = $info['CONTENT_ID'];
  $title = $contentInfo['TITLE'];
  $meta_title = $contentInfo['META_TITLE'];
  $meta_description = $contentInfo['META_DESCRIPTION'];
  $meta_keywords = $contentInfo['META_KEYWORDS'];

  if (isset($qa[1]) && $qa[1] == "delete") {
  
    // artists table
    $qry = "UPDATE artists SET ACTIVE=0 WHERE ARTIST_ID='" . $qa[0] . "'";
    mysql_query($qry) or die(mysql_error());
  
    // content table
    $qry = "UPDATE content SET ACTIVE=0 WHERE ID='" . $contentID . "'";
    mysql_query($qry) or die(mysql_error());    
    
    httpRedirect("/" . $content['MOD_NAME']);
    
  }

  if (isset($qa[1]) && $qa[1] == "remove-project1") {
  
    // artists table
    $qry = "UPDATE artists SET PROJECT1_PHOTO='' WHERE ARTIST_ID='" . $qa[0] . "'";
    mysql_query($qry) or die(mysql_error());
    
    // delete file
    unlink('images/artists/' . $qa[0] . '/project1/' . $project1Photo);
 
    httpRedirect("/" . $content['MOD_NAME']);
    
  }

  if (isset($qa[1]) && $qa[1] == "remove-project2") {
  
    // artists table
    $qry = "UPDATE artists SET PROJECT2_PHOTO='' WHERE ARTIST_ID='" . $qa[0] . "'";
    mysql_query($qry) or die(mysql_error());
    
    // delete file
    unlink('images/artists/' . $qa[0] . '/project2/' . $project2Photo);
 
    httpRedirect("/" . $content['MOD_NAME']);
    
  }

  if (isset($qa[1]) && $qa[1] == "remove-project3") {
  
    // artists table
    $qry = "UPDATE artists SET PROJECT2_PHOTO='' WHERE ARTIST_ID='" . $qa[0] . "'";
    mysql_query($qry) or die(mysql_error());
    
    // delete file
    unlink('images/artists/' . $qa[0] . '/project3/' . $project3Photo);
 
    httpRedirect("/" . $content['MOD_NAME']);
    
  }
  
  if ($_POST['BUTTON'] == "Save") {

    $firstName = mysql_real_escape_string($_POST['FIRST_NAME']);
    $lastName = mysql_real_escape_string($_POST['LAST_NAME']);
    $completeName = $firstName . ' ' . $lastName;
    $details = mysql_real_escape_string($_POST['DETAILS']);
    $title = mysql_real_escape_string($_POST['TITLE']);
    $meta_title = mysql_real_escape_string($_POST['META_TITLE']);
    $meta_description = mysql_real_escape_string($_POST['META_DESCRIPTION']);
    $meta_keywords = mysql_real_escape_string($_POST['META_KEYWORDS']);
  
    $qry = "UPDATE artists SET FIRST_NAME='" . $firstName . "',";
    $qry .= "LAST_NAME='" . $lastName . "',";
    $qry .= "COMPLETE_NAME='" . $completeName . "',";
    $qry .= "DETAILS='" . $details . "' ";
    $qry .= "WHERE ARTIST_ID='" . $qa[0] . "'";
    $res = mysql_query($qry) or die(mysql_error());
    
    $qry = "UPDATE content SET TITLE='" . $title . "',";
    $qry .= "META_TITLE='" . $meta_title . "',";
    $qry .= "META_DESCRIPTION='" . $meta_description . "',";
    $qry .= "META_KEYWORDS='" . $meta_keywords . "' ";
    $qry .= "WHERE ID='" . $contentID . "'";
    $res = mysql_query($qry) or die(mysql_error());    
    
    if (!empty($_FILES) && $_FILES['ARTIST_PHOTO']['error'] == 0) {

      $fileName = $_FILES['ARTIST_PHOTO']['name'];
      fileUpload('images/artists/' . $qa[0] . '/', $fileName, "ARTIST_PHOTO");
      $qry = "UPDATE artists SET ARTIST_PHOTO='" . $fileName . "' WHERE ARTIST_ID='" . $qa[0] . "'";
      mysql_query($qry) or die(mysql_error());

    }

    if (!empty($_FILES) && $_FILES['PROJECT1_PHOTO']['error'] == 0) {

      $fileName = $_FILES['PROJECT1_PHOTO']['name'];
      fileUpload('images/artists/' . $qa[0] . '/project1/', $fileName, "PROJECT1_PHOTO");
      $qry = "UPDATE artists SET PROJECT1_PHOTO='" . $fileName . "' WHERE ARTIST_ID='" . $qa[0] . "'";
      mysql_query($qry) or die(mysql_error());

    }

    if (!empty($_FILES) && $_FILES['PROJECT2_PHOTO']['error'] == 0) {

      $fileName = $_FILES['PROJECT2_PHOTO']['name'];
      fileUpload('images/artists/' . $qa[0] . '/project2/', $fileName, "PROJECT2_PHOTO");
      $qry = "UPDATE artists SET PROJECT2_PHOTO='" . $fileName . "' WHERE ARTIST_ID='" . $qa[0] . "'";
      mysql_query($qry) or die(mysql_error());

    }

    if (!empty($_FILES) && $_FILES['PROJECT3_PHOTO']['error'] == 0) {

      $fileName = $_FILES['PROJECT3_PHOTO']['name'];
      fileUpload('images/artists/' . $qa[0] . '/project3/', $fileName, "PROJECT3_PHOTO");
      $qry = "UPDATE artists SET PROJECT3_PHOTO='" . $fileName . "' WHERE ARTIST_ID='" . $qa[0] . "'";
      mysql_query($qry) or die(mysql_error());

    }
    
    httpRedirect("/" . $content['MOD_NAME']);
 
  }
  
}

// creation
else {

  if ($_POST['BUTTON'] == "Save") {

    $firstName = mysql_real_escape_string($_POST['FIRST_NAME']);
    $lastName = mysql_real_escape_string($_POST['LAST_NAME']);
    $completeName = $firstName . ' ' . $lastName;
    $cleanupCharacters = array("'", '"', '-');
    $adjustedFirst = str_replace($cleanupCharacters, "", $_POST['FIRST_NAME']);
    $adjustedFirst = strtolower($adjustedFirst);
    $adjustedLast = str_replace($cleanupCharacters, "", $_POST['LAST_NAME']);
    $adjustedLast = strtolower($adjustedLast);
    $mod_name = $adjustedFirst . '-' . $adjustedLast; 
    $details = mysql_real_escape_string($_POST['DETAILS']);
    $title = mysql_real_escape_string($_POST['TITLE']);
    $meta_title = mysql_real_escape_string($_POST['META_TITLE']);
    $meta_description = mysql_real_escape_string($_POST['META_DESCRIPTION']);
    $meta_keywords = mysql_real_escape_string($_POST['META_KEYWORDS']);
    $button_title = "";
    $top_order = 0;
    $active = 1;
    $mod_head = 'artist-details-head.php';
    $mod_body = 'artist-details-body.php';
    
    // content table
    $theContentID = contentCreate($title, $meta_title, $meta_description, $meta_keywords, $button_title, $details, $top_order, $active);
    $qry = "UPDATE content SET SECTIONID=5, TITLE='', EDITABLE=0, MODULE_HEAD='" . $mod_head . "', MODULE_BODY='" . $mod_body . "', MOD_NAME='" . $mod_name . "' WHERE ID='" . $theContentID . "'";
    $res = mysql_query($qry) or die(mysql_error());

    // artists table
    $qry = "INSERT INTO artists VALUES(NULL, '$theContentID', '$firstName', '$lastName', '$completeName', '$details', '', '', '', '', 1)";
    $res = mysql_query($qry) or die(mysql_error());
    $theArtistID = mysql_insert_id();
 
    $theNewDirPath = 'images/artists/' . $theArtistID;
    if (!file_exists($theNewDirPath)) {
      mkdir($theNewDirPath, 0777);
      chmod($theNewDirPath, 0777);
    }
    if (!file_exists($theNewDirPath . '/project1')) {
      mkdir($theNewDirPath . '/project1', 0777);
      chmod($theNewDirPath . '/project1', 0777);
    }    
    if (!file_exists($theNewDirPath . '/project2')) {
      mkdir($theNewDirPath . '/project2', 0777);
      chmod($theNewDirPath . '/project2', 0777);
    }   
    if (!file_exists($theNewDirPath . '/project3')) {
      mkdir($theNewDirPath . '/project3', 0777);
      chmod($theNewDirPath . '/project3', 0777);
    }   

    if (!empty($_FILES) && $_FILES['ARTIST_PHOTO']['error'] == 0) {

      $fileName = $_FILES['ARTIST_PHOTO']['name'];
      fileUpload($theNewDirPath . '/', $fileName, "ARTIST_PHOTO");
      $qry = "UPDATE artists SET ARTIST_PHOTO='" . $fileName . "' WHERE ARTIST_ID='" . $theArtistID . "'";
      mysql_query($qry) or die(mysql_error());

    }

    if (!empty($_FILES) && $_FILES['PROJECT1_PHOTO']['error'] == 0) {

      $fileName = $_FILES['PROJECT1_PHOTO']['name'];
      fileUpload($theNewDirPath . '/project1/', $fileName, "PROJECT1_PHOTO");
      $qry = "UPDATE artists SET PROJECT1_PHOTO='" . $fileName . "' WHERE ARTIST_ID='" . $theArtistID . "'";
      mysql_query($qry) or die(mysql_error());

    }

    if (!empty($_FILES) && $_FILES['PROJECT2_PHOTO']['error'] == 0) {

      $fileName = $_FILES['PROJECT2_PHOTO']['name'];
      fileUpload($theNewDirPath . '/project2/', $fileName, "PROJECT2_PHOTO");
      $qry = "UPDATE artists SET PROJECT2_PHOTO='" . $fileName . "' WHERE ARTIST_ID='" . $theArtistID . "'";
      mysql_query($qry) or die(mysql_error());

    }

    if (!empty($_FILES) && $_FILES['PROJECT3_PHOTO']['error'] == 0) {

      $fileName = $_FILES['PROJECT3_PHOTO']['name'];
      fileUpload($theNewDirPath . '/project3/', $fileName, "PROJECT3_PHOTO");
      $qry = "UPDATE artists SET PROJECT3_PHOTO='" . $fileName . "' WHERE ARTIST_ID='" . $theArtistID . "'";
      mysql_query($qry) or die(mysql_error());

    }
    
    httpRedirect("/" . $content['MOD_NAME']);
  
  }

}  
?>