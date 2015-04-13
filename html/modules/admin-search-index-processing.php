<?php

if (!empty($_POST) && isset($_POST['BUTTON']) && $_POST['BUTTON'] == "Regenerate Search Index") {

  // empty the index
  $qry = "TRUNCATE TABLE search";
  mysql_query($qry) or die(mysql_error());
  
  // creation time for this index
  $dbCreation = time();

  // learn pages
  $qry = "SELECT learn.*, content.CREATED, content.MOD_NAME AS content_url, brands.NAME FROM learn JOIN brands ON learn.BRAND_ID=brands.ID JOIN content ON content.ID=learn.CONTENT_ID WHERE learn.ACTIVE=1 AND brands.ACTIVE=1";
  $res = mysql_query($qry) or die(mysql_error());

  while ($data = mysql_fetch_assoc($res)) {

    $qry2 = "SELECT * FROM brands_products JOIN products ON products.ID=brands_products.PRODUCTID WHERE brands_products.BRANDID='" . $data['BRAND_ID'] . "' ORDER BY products.ID DESC LIMIT 1";
    $res2 = mysql_query($qry2) or die(mysql_error());
    $prodArr = mysql_fetch_assoc($res2);

    if (!file_exists("images/products/" . $prodArr['ID']. ".jpg")) {
      $img_filename = "0.jpg";
    }
    else {
      $img_filename = $prodArr['ID'] . ".jpg";
    }
  
    $contentType = 1;
    $urlPath = mysql_real_escape_string('/' . $data['content_url']);
    $imgPath = mysql_real_escape_string('images/products/' . $img_filename);
    $matchText = mysql_real_escape_string($data['NAME'] . ' ' . $data['LEARN_HEADING'] . ' ' . $data['LEARN_TEXT']);
    if (!empty($data['LEARN_HEADING'])) { 
      $titleResults = mysql_real_escape_string($data['LEARN_HEADING']);
    }
    else {
      $titleResults = mysql_real_escape_string($data['NAME']);    
    }        
    $summaryResults = '';
    if (!empty($data['LEARN_VIDEO'])) { $hasVideo = 1; }
    else { $hasVideo = 0; }
    $itemCreated = strtotime($data['CREATED']);
    
    $qry = "INSERT INTO search VALUES(NULL, $contentType, '$urlPath', '$imgPath', '$matchText', '$titleResults', '$summaryResults', $hasVideo, $itemCreated, $dbCreation)";
    mysql_query($qry) or die(mysql_error());
    
  }
  
  
  // technique pages
  $qry = "SELECT * FROM technique JOIN brands ON technique.BRAND_ID=brands.ID WHERE technique.ACTIVE=1 AND brands.ACTIVE=1";
  $res = mysql_query($qry) or die(mysql_error());

  while ($data = mysql_fetch_assoc($res)) {
  
    $contentType = 2;
    $urlPath = mysql_real_escape_string('/technique-details/' . $data['TECHNIQUE_ID']);
    $imgPath = mysql_real_escape_string('images/techniques/' . $data['TECHNIQUE_ID'] . '/' . $data['TECHNIQUE_PHOTO']);
    $matchText = mysql_real_escape_string($data['NAME'] . ' ' . $data['TECHNIQUE_TITLE'] . ' ' . $data['TECHNIQUE_SUMMARY'] . ' ' . $data['TECHNIQUE_TEXT'] . ' ' . $data['TECHNIQUE_KEYWORDS']);
    if (!empty($data['TECHNIQUE_TITLE'])) { 
      $titleResults = mysql_real_escape_string($data['TECHNIQUE_TITLE']);
    }
    else {
      $titleResults = mysql_real_escape_string($data['NAME']);    
    }        
    $summaryResults = $data['TECHNIQUE_SUMMARY'];
    if (!empty($data['TECHNIQUE_VIDEO'])) { $hasVideo = 1; }
    else { $hasVideo = 0; }
    $itemCreated = $data['TECHNIQUE_CREATED'];
    
    $qry = "INSERT INTO search VALUES(NULL, $contentType, '$urlPath', '$imgPath', '$matchText', '$titleResults', '$summaryResults', $hasVideo, $itemCreated, $dbCreation)";
    mysql_query($qry) or die(mysql_error());
    
  }
  
  
  // project pages
  $qry = "SELECT * FROM project WHERE ACTIVE=1";
  $res = mysql_query($qry) or die(mysql_error());

  while ($data = mysql_fetch_assoc($res)) {

    $facetTxt = '';
  
    $qry2 = "SELECT * FROM project_facet WHERE PROJECT_ID=" . $data['PROJECT_ID'];
    $res2 = mysql_query($qry2) or die(mysql_error());
    
    while ($info = mysql_fetch_assoc($res2)) {
    
      switch($info['FACET_TYPE']) {
      
        case '1' :
        
          $qry3 = "SELECT * FROM medium WHERE ACTIVE=1 AND MEDIUM_ID=" . $info['FACET_ID'];
          $res3 = mysql_query($qry3) or die(mysql_error());
          $facetInfo = mysql_fetch_assoc($res3);
          $facetTxt .= $facetInfo['MEDIUM_TITLE'] . ' ';
          break;

        case '2' :
        
          $qry3 = "SELECT * FROM project_brand JOIN brands ON project_brand.BRAND_ID=brands.ID WHERE project_brand.ACTIVE=1 AND project_brand.PROJECT_BRAND_ID=" . $info['FACET_ID'];
          $res3 = mysql_query($qry3) or die(mysql_error());
          $facetInfo = mysql_fetch_assoc($res3);
          $facetTxt .= $facetInfo['NAME'] . ' ';
          break;    

        case '3' :
        
          $qry3 = "SELECT * FROM aesthetic WHERE ACTIVE=1 AND AESTHETIC_ID=" . $info['FACET_ID'];
          $res3 = mysql_query($qry3) or die(mysql_error());
          $facetInfo = mysql_fetch_assoc($res3);
          $facetTxt .= $facetInfo['AESTHETIC_TITLE'] . ' ';
          break;        

        case '4' :
        
          $qry3 = "SELECT * FROM season WHERE ACTIVE=1 AND SEASON_ID=" . $info['FACET_ID'];
          $res3 = mysql_query($qry3) or die(mysql_error());
          $facetInfo = mysql_fetch_assoc($res3);
          $facetTxt .= $facetInfo['SEASON_TITLE'] . ' ';
          break;

        case '5' :
        
          $qry3 = "SELECT * FROM project_type WHERE ACTIVE=1 AND TYPE_ID=" . $info['FACET_ID'];
          $res3 = mysql_query($qry3) or die(mysql_error());
          $facetInfo = mysql_fetch_assoc($res3);
          $facetTxt .= $facetInfo['TYPE_TITLE'] . ' ';
          break;
      
      }
    
    }
  
    $contentType = 3;
    $urlPath = mysql_real_escape_string('/project-details/' . $data['PROJECT_ID'] . '/0.0');
    $imgPath = mysql_real_escape_string('images/projects/' . $data['PROJECT_ID'] . '/' . $data['PROJECT_PHOTO']);
    $matchText = mysql_real_escape_string($data['PROJECT_TITLE'] . ' ' . $data['PROJECT_ARTIST'] . ' ' . $data['PROJECT_SUMMARY'] . ' ' . $data['PROJECT_TEXT'] . ' ' . $data['PROJECT_KEYWORDS'] . ' ' . $data['PROJECT_DIFFICULTY'] . ' ' . $data['PROJECT_TIME'] . ' ' . $data['PROJECT_MATERIALS'] . ' ' . $facetTxt);
    $titleResults = mysql_real_escape_string($data['PROJECT_TITLE']);
    $summaryResults = $data['PROJECT_SUMMARY'];
    if (!empty($data['PROJECT_VIDEO'])) { $hasVideo = 1; }
    else { $hasVideo = 0; }
    $itemCreated = $data['PROJECT_CREATED'];
    
    $qry = "INSERT INTO search VALUES(NULL, $contentType, '$urlPath', '$imgPath', '$matchText', '$titleResults', '$summaryResults', $hasVideo, $itemCreated, $dbCreation)";
    mysql_query($qry) or die(mysql_error());
    
  }
  
  
  // product pages
  $qry = "SELECT * FROM products WHERE ACTIVE=1";
  $res = mysql_query($qry) or die(mysql_error());

  while ($data = mysql_fetch_assoc($res)) {

    if (!file_exists("images/products/" . $data['ID'] . '.jpg')) {
      $img_filename = '0.jpg';
    }
    else {
      $img_filename = $data['ID'] . '.jpg';
    }
  
    $contentType = 4;
    $urlPath = '/' . productModName($data['ID']);
    $imgPath = mysql_real_escape_string('images/products/' . $img_filename);
    $matchText = mysql_real_escape_string($data['NAME'] . ' ' . $data['DESCRIPTION'] . ' ' . $data['SEARCH_KEYWORDS'] . ' ' . $data['BULLET_FEATURE1'] . ' ' . $data['BULLET_FEATURE2'] . ' ' . $data['BULLET_FEATURE3'] . ' ' . $data['BULLET_FEATURE4'] . ' ' . $data['BULLET_FEATURE5'] . ' ' . $facetTxt);
    $titleResults = mysql_real_escape_string($data['NAME']);
    $summaryResults = $data['DESCRIPTION'];
    $hasVideo = 0;
    $itemCreated = strtotime($data['CREATED']);
    
    $qry = "INSERT INTO search VALUES(NULL, $contentType, '$urlPath', '$imgPath', '$matchText', '$titleResults', '$summaryResults', $hasVideo, $itemCreated, $dbCreation)";
    mysql_query($qry) or die(mysql_error());
    
  }  
    
  httpRedirect("/" . $content['MOD_NAME']);

}

?>