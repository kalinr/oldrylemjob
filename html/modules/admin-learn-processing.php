<?php

// update
if (isset($qa[0]) && $qa[0] > 0) {

  // existing values for update
  $query = "SELECT * FROM learn JOIN brands ON learn.BRAND_ID=brands.ID WHERE learn.LEARN_ID='" . $qa[0] . "' AND learn.ACTIVE=1";
  $result = mysql_query($query) or die ("error1" . mysql_error());
  $info = mysql_fetch_assoc($result);

  $learnID = $qa[0];    
  $learnHeading = $info['LEARN_HEADING'];
  $learnVideo = $info['LEARN_VIDEO'];
  $learnPhoto = $info['LEARN_PHOTO'];
  $learnText = $info['LEARN_TEXT'];
  $showTechniques = $info['SHOW_TECHNIQUES_LINK'];
  $showProjects = $info['SHOW_PROJECTS_LINK'];
  $showShop = $info['SHOW_SHOP_LINK'];
  $brandName = $info['NAME']; 

  if (isset($qa[1]) && $qa[1] == "remove-banner") {
 
    $qry = "UPDATE learn SET LEARN_PHOTO='' WHERE LEARN_ID='" . $qa[0] . "'";
    mysql_query($qry) or die(mysql_error());
    
    // delete file
    unlink('images/learn-banners/' . $qa[0] . '/' . $learnPhoto);
 
    httpRedirect("/" . $content['MOD_NAME']);
    
  }
  
  if ($_POST['BUTTON'] == "Save") {

    $learnHeading = mysql_real_escape_string($_POST['LEARN_HEADING']);
    $learnVideo = mysql_real_escape_string($_POST['LEARN_VIDEO']);
    $learnText = mysql_real_escape_string($_POST['LEARN_TEXT']);
    
    if (isset($_POST['SHOW_TECHNIQUES_LINK']) && $_POST['SHOW_TECHNIQUES_LINK'] == '1') {
      $showTechniques = 1;
    }
    else {
      $showTechniques = 0;
    }

    if (isset($_POST['SHOW_PROJECTS_LINK']) && $_POST['SHOW_PROJECTS_LINK'] == '1') {
      $showProjects = 1;
    }
    else {
      $showProjects = 0;
    }
    
    if (isset($_POST['SHOW_SHOP_LINK']) && $_POST['SHOW_SHOP_LINK'] == '1') {
      $showShop = 1;
    }
    else {
      $showShop = 0;
    }
  
    $qry = "UPDATE learn SET LEARN_HEADING='" . $learnHeading . "',";
    $qry .= "LEARN_VIDEO='" . $learnVideo . "',";
    $qry .= "LEARN_TEXT='" . $learnText . "',";
    $qry .= "SHOW_TECHNIQUES_LINK='" . $showTechniques . "',";
    $qry .= "SHOW_PROJECTS_LINK='" . $showProjects . "',";
    $qry .= "SHOW_SHOP_LINK='" . $showShop . "' ";
    $qry .= "WHERE LEARN_ID='" . $qa[0] . "'";
    mysql_query($qry) or die(mysql_error());

    if (!empty($_FILES) && $_FILES['LEARN_PHOTO']['error'] == 0) {

      $theDirPath = 'images/learn-banners/' . $qa[0];
      
      if (!file_exists($theDirPath)) {
        mkdir($theDirPath, 0777);
        chmod($theDirPath, 0777);
      }

      $fileName = $_FILES['LEARN_PHOTO']['name'];
      fileUpload($theDirPath . '/', $fileName, "LEARN_PHOTO");
      $qry = "UPDATE learn SET LEARN_PHOTO='" . $fileName . "' WHERE LEARN_ID='" . $qa[0] . "'";
      mysql_query($qry) or die(mysql_error());

    }
    
    httpRedirect("/" . $content['MOD_NAME']);
 
  }

}  
?>