<?php

// HOME
if ($_POST['BUTTON'] == "Save Home Page Changes") {

  if (!empty($_FILES) && $_FILES['FILE']['error'] == 0) {

    $fileName = $_FILES['FILE']['name'];
    fileUpload("images/home/", $fileName, "FILE");
    $qry = "UPDATE landing_pages SET HOME_IMG='" . $fileName . "', FEATURED_BRAND_ID='" . $_POST['BRAND'] . "' WHERE LANDING_PAGE_ID=1";

  }
  
  else {
  
    $qry = "UPDATE landing_pages SET FEATURED_BRAND_ID='" . $_POST['BRAND'] . "', FEATURED_ARTIST_ID='" . $_POST['ARTIST'] . "' WHERE LANDING_PAGE_ID=1";
  
  }
  
  mysql_query($qry) or die(mysql_error());

}


// LEARN
if ($_POST['BUTTON'] == "Save Learn Page Changes") {

  if (!empty($_FILES) && $_FILES['FILE']['error'] == 0) {

    $fileName = $_FILES['FILE']['name'];
    fileUpload("images/learn/", $fileName, "FILE");
    $qry = "UPDATE landing_pages SET LEARN_IMG='" . $fileName . "', FEATURED_LEARN_FABRIC='" . $_POST['FABRIC'] . "', FEATURED_LEARN_PAPER='" . $_POST['PAPER'] . "', FEATURED_LEARN_MIXEDMEDIA='" . $_POST['MEDIA'] . "', FEATURED_LEARN_TOOL='" . $_POST['TOOL'] . "' WHERE LANDING_PAGE_ID=1";

  }
  
  else {
  
    $qry = "UPDATE landing_pages SET FEATURED_LEARN_FABRIC='" . $_POST['FABRIC'] . "', FEATURED_LEARN_PAPER='" . $_POST['PAPER'] . "', FEATURED_LEARN_MIXEDMEDIA='" . $_POST['MEDIA'] . "', FEATURED_LEARN_TOOL='" . $_POST['TOOL'] . "' WHERE LANDING_PAGE_ID=1";
  
  }
  
  mysql_query($qry) or die(mysql_error());

}

?>