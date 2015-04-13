<?php

if (!isset($qa[0]) || empty($qa[0]) || !is_numeric($qa[0])) {

  $qry = "SELECT * FROM project WHERE ACTIVE=1 ORDER BY PROJECT_CREATED DESC LIMIT 1";
  $res = mysql_query($qry) or die(mysql_error());
  $projArr = mysql_fetch_assoc($res);  
  
}

else {

  $theProjectID = mysql_real_escape_string($qa[0]);

  // project details
  $qry = "SELECT * FROM project WHERE PROJECT_ID='" . $theProjectID . "' AND ACTIVE=1";
  $res = mysql_query($qry) or die(mysql_error());
  $projArr = mysql_fetch_assoc($res);

}

// navigation
if (!isset($qa[1])) {

  $parentFacet = ' <a href="/browse-projects/2.0">by product</a> / ';
  $childFacet = '';
  $currentPth = '';

}

else {

  $urlPth = explode('.', $qa[1]);
  $childFacet = '';
  $currentPth = '/' . $qa[1];

  switch($urlPth[0]) {
  
    case '1' :
    
      $parentFacet = '<a href="/browse-projects/1.0">by medium</a> / ';
      if ($urlPth[1] > 0) {
      
        $cleanedParam = mysql_real_escape_string($urlPth[1]);
        $qry = "SELECT * FROM medium WHERE MEDIUM_ID='" . $cleanedParam . "'";
        $res = mysql_query($qry) or die(mysql_error());
        $facetData = mysql_fetch_assoc($res);
        $childFacet = ' <a href="/browse-projects/1.' . $cleanedParam . '">' . strtolower($facetData['MEDIUM_TITLE']) . '</a> / ';
      
      }
      break;

    case '2' :
    
      $parentFacet = '<a href="/browse-projects/2.0">by product</a> / '; 
      if ($urlPth[1] > 0) {
      
        $cleanedParam = mysql_real_escape_string($urlPth[1]);
        $qry = "SELECT * FROM project_brand JOIN brands ON brands.ID=project_brand.BRAND_ID WHERE project_brand.PROJECT_BRAND_ID='" . $cleanedParam . "'";
        $res = mysql_query($qry) or die(mysql_error());
        $facetData = mysql_fetch_assoc($res);
        $childFacet = ' <a href="/browse-projects/2.' . $cleanedParam . '">' . strtolower($facetData['NAME']) . '</a> / ';
      
      }
      break;

    case '3' :
    
      $parentFacet = '<a href="/browse-projects/3.0">by aesthetic</a> / '; 
      if ($urlPth[1] > 0) {
      
        $cleanedParam = mysql_real_escape_string($urlPth[1]);
        $qry = "SELECT * FROM aesthetic WHERE AESTHETIC_ID='" . $cleanedParam . "'";
        $res = mysql_query($qry) or die(mysql_error());
        $facetData = mysql_fetch_assoc($res);
        $childFacet = ' <a href="/browse-projects/3.' . $cleanedParam . '">' . strtolower($facetData['AESTHETIC_TITLE']) . '</a> / ';
      
      }
      break;

    case '4' :
    
      $parentFacet = '<a href="/browse-projects/4.0">by season/occasion</a> / '; 
      if ($urlPth[1] > 0) {
      
        $cleanedParam = mysql_real_escape_string($urlPth[1]);
        $qry = "SELECT * FROM season WHERE SEASON_ID='" . $cleanedParam . "'";
        $res = mysql_query($qry) or die(mysql_error());
        $facetData = mysql_fetch_assoc($res);
        $childFacet = ' <a href="/browse-projects/4.' . $cleanedParam . '">' . strtolower($facetData['SEASON_TITLE']) . '</a> / ';
      
      }
      break;

    case '5' :
    
      $parentFacet = '<a href="/browse-projects/5.0">by project type</a> / ';
      if ($urlPth[1] > 0) {
      
        $cleanedParam = mysql_real_escape_string($urlPth[1]);
        $qry = "SELECT * FROM project_type WHERE TYPE_ID='" . $cleanedParam . "'";
        $res = mysql_query($qry) or die(mysql_error());
        $facetData = mysql_fetch_assoc($res);
        $childFacet = ' <a href="/browse-projects/5.' . $cleanedParam . '">' . strtolower($facetData['TYPE_TITLE']) . '</a> / ';
      
      }
      break;
  
  }

}


echo '<p class="breadcrumbTrail">',
     '<a href="/browse-projects">make</a> / ',
     $parentFacet,
     $childFacet,
     '<a href="/project-details/' . $projArr['PROJECT_ID'] . $currentPth . '">' . strtolower($projArr['PROJECT_TITLE']) . '</a></p>';



if (!empty($projArr['PROJECT_TITLE'])) {

  echo '<h1>', $projArr['PROJECT_TITLE'], '</h1>';

}

else {

  echo '<h1>Project Not Found</h1>';  

}

if (!empty($projArr['PROJECT_SUMMARY'])) {

  echo $projArr['PROJECT_SUMMARY'];
  echo '<br />';

}

echo '<div id="projectContent">';

if (!empty($projArr['PROJECT_VIDEO'])) {

  echo '<div class="projectVideoEmbed">', $projArr['PROJECT_VIDEO'], '</div>';

}

elseif (!empty($projArr['PROJECT_PHOTO'])) {
 
  echo '<div class="projectPhotoArea"><img src="/images/projects/' . $projArr['PROJECT_ID'] . '/' . $projArr['PROJECT_PHOTO'] . '" alt="' . $projArr['PROJECT_TITLE'] . '" style="max-width: 700px" /></div>';

}

echo $projArr['PROJECT_TEXT'];

echo '</div>'; // closing projectContent div

echo '<div id="projectSidebar">';

if (!empty($projArr['PROJECT_ARTIST'])) {

  echo 'by ', $projArr['PROJECT_ARTIST'],
       '<br /><br />';
  
}

if (!empty($projArr['PROJECT_DIFFICULTY'])) {

  echo '<h3>Difficulty</h3>',
       $projArr['PROJECT_DIFFICULTY'],
       '<br /><br />';
  
}

if (!empty($projArr['PROJECT_TIME'])) {

  echo '<h3>Time</h3>',
       $projArr['PROJECT_TIME'],
       '<br /><br />';
  
}

if (!empty($projArr['PROJECT_MATERIALS'])) {

  echo '<h3>Materials Needed</h3>',
       $projArr['PROJECT_MATERIALS'],
       '<br /><br />';
  
}

echo '</div>'; // closing projectSidebar div

echo '<div class="clr"></div>';

?>