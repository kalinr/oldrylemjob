<?php

if (!isset($qa[0]) || empty($qa[0]) || !is_numeric($qa[0])) {

  $qry = "SELECT * FROM technique JOIN brands ON technique.BRAND_ID=brands.ID WHERE technique.ACTIVE=1 ORDER BY technique.TECHNIQUE_ID DESC LIMIT 1";
  $res = mysql_query($qry) or die(mysql_error());
  $techArr = mysql_fetch_assoc($res);  
  
}

else {

  $theTechniqueID = mysql_real_escape_string($qa[0]);

  // technique details
  $qry = "SELECT * FROM technique JOIN brands ON technique.BRAND_ID=brands.ID WHERE technique.TECHNIQUE_ID='" . $theTechniqueID . "' AND technique.ACTIVE=1";
  $res = mysql_query($qry) or die(mysql_error());
  $techArr = mysql_fetch_assoc($res);

}

// navigation
echo '<p class="breadcrumbTrail"><a href="/browse-techniques/' . $techArr['BRAND_ID'] . '">' . strtolower($techArr['NAME']) . ' techniques' . '</a> / ';
echo '<a href="/technique-details/' . $techArr['TECHNIQUE_ID'] . '">' . strtolower($techArr['TECHNIQUE_TITLE']) . '</a></p>';


if (!empty($techArr['TECHNIQUE_TITLE'])) {

  echo '<h1>', $techArr['TECHNIQUE_TITLE'], '</h1>';

}

else {

  echo '<h1>Technique Not Found</h1>';  

}

if (!empty($techArr['TECHNIQUE_SUMMARY'])) {

  echo $techArr['TECHNIQUE_SUMMARY'];
  echo '<br />';

}

if (!empty($techArr['TECHNIQUE_VIDEO'])) {

  echo '<div class="videoEmbed">', $techArr['TECHNIQUE_VIDEO'], '</div>';

}

elseif (!empty($techArr['TECHNIQUE_PHOTO'])) {
 
  echo '<p><img src="/images/techniques/' . $techArr['TECHNIQUE_ID'] . '/' . $techArr['TECHNIQUE_PHOTO'] . '" alt="' . $techArr['TECHNIQUE_TITLE'] . '" style="max-width: 100%" /></p>';

}

echo $techArr['TECHNIQUE_TEXT'];

echo '<div class="clr"></div>';

?>