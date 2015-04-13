<?php

// defaults for creation
$staffName = '';
$staffTitle = '';
$staffEmail = '';
$staffPhoto = '';
$staffHobbies = '';
$displayOrder = '1';

// update
if (isset($qa[0]) && $qa[0] > 0) {

  // existing values for update
  $query = "SELECT * FROM staff WHERE STAFF_ID='" . $qa[0] . "' AND ACTIVE='1'";
  $result = mysql_query($query) or die ("error1" . mysql_error());
  $info = mysql_fetch_assoc($result);
  
  $staffName = $info['STAFF_NAME'];
  $staffTitle = $info['STAFF_TITLE'];
  $staffEmail = $info['STAFF_EMAIL'];
  $staffPhoto = $info['STAFF_IMG'];
  $staffHobbies = $info['STAFF_HOBBIES'];
  $displayOrder = $info['DISPLAY_ORDER'];
  $staffID = $info['STAFF_ID'];

  if (isset($qa[1]) && $qa[1] == "delete") {
  
    $qry = "UPDATE staff SET ACTIVE=0 WHERE STAFF_ID='" . $qa[0] . "'";
    mysql_query($qry) or die(mysql_error());
    httpRedirect("/" . $content['MOD_NAME']);

  }
  
  if ($_POST['BUTTON'] == "Save") {
  
    $cleanedName = mysql_real_escape_string($_POST['STAFF_NAME']);
    $cleanedTitle = mysql_real_escape_string($_POST['STAFF_TITLE']);
    $cleanedEmail = mysql_real_escape_string($_POST['STAFF_EMAIL']);  
    $cleanedHobbies = mysql_real_escape_string($_POST['STAFF_HOBBIES']);  
    $cleanedOrder = mysql_real_escape_string($_POST['DISPLAY_ORDER']);

    $qry = "UPDATE staff SET STAFF_NAME='" . $cleanedName . "',";
    $qry .= "STAFF_TITLE='" . $cleanedTitle . "',";
    $qry .= "STAFF_EMAIL='" . $cleanedEmail . "',";
    $qry .= "STAFF_HOBBIES='" . $cleanedHobbies . "',";
    $qry .= "DISPLAY_ORDER='" . $cleanedOrder . "' ";
    $qry .= "WHERE STAFF_ID='" . $qa[0] . "'";
    $res = mysql_query($qry) or die(mysql_error());
    
    if (!empty($_FILES) && $_FILES['PHOTO']['error'] == 0) {

      $fileName = $_FILES['PHOTO']['name'];
      fileUpload('images/staff/' . $qa[0] . '/', $fileName, "PHOTO");
      $qry = "UPDATE staff SET STAFF_IMG='" . $fileName . "' WHERE STAFF_ID='" . $qa[0] . "'";
      mysql_query($qry) or die(mysql_error());

    }
    
    httpRedirect("/" . $content['MOD_NAME']);
 
  }
  
}

// creation
else {

  if ($_POST['BUTTON'] == "Save") {

    $cleanedName = mysql_real_escape_string($_POST['STAFF_NAME']);
    $cleanedTitle = mysql_real_escape_string($_POST['STAFF_TITLE']);
    $cleanedEmail = mysql_real_escape_string($_POST['STAFF_EMAIL']);  
    $cleanedHobbies = mysql_real_escape_string($_POST['STAFF_HOBBIES']);  
    $cleanedOrder = mysql_real_escape_string($_POST['DISPLAY_ORDER']);  

    $qry = "INSERT INTO staff VALUES(NULL, '', '$cleanedName', '$cleanedTitle', '$cleanedEmail', '$cleanedHobbies', '$cleanedOrder', 1)";
    $res = mysql_query($qry) or die(mysql_error());
    $theStaffID = mysql_insert_id();
 
    $theNewDirPath = 'images/staff/' . $theStaffID;
    if (!file_exists($theNewDirPath)) {
      mkdir($theNewDirPath, 0777);
      chmod($theNewDirPath, 0777);
    }

    if (!empty($_FILES) && $_FILES['PHOTO']['error'] == 0) {

      $fileName = $_FILES['PHOTO']['name'];
      fileUpload($theNewDirPath . '/', $fileName, "PHOTO");
      $qry = "UPDATE staff SET STAFF_IMG='" . $fileName . "' WHERE STAFF_ID='" . $theStaffID . "'";
      mysql_query($qry) or die(mysql_error());

    }
    
    httpRedirect("/" . $content['MOD_NAME']);
  
  }

}  
?>