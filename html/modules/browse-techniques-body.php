<?php

function buildPagination($num) {

  global $qa;
  
  $pgPath = '/browse-techniques/' . $qa[0] . '/';
  
  $maxPages = ceil($num / 10);
  
  if ($maxPages == 1 && $num > 10 && $num < 20) { $maxPages = 2; }
  
  // no page number or invalid page number
  if (!isset($qa[1]) || !is_numeric($qa[1])) {
    $qa[1] = 1;
  }
  
  $currentPg = $qa[1];

  if ($currentPg > 1) {  
    $previousPg = $currentPg - 1;
    echo '<a href="', $pgPath, $previousPg, '">&lt; PREV</a> ';  
  }

  if (($currentPg - 3) > 0) {
    echo ' ... ';
  }
  
  $shownRange = '';
  
  // visible range
  if (($currentPg - 2) > 0) {     
    $thePg = $currentPg - 2;
    $shownRange .= '<a href="' . $pgPath . $thePg . '">' . $thePg . '</a> ';  
  }
  if (($currentPg - 1) > 0) {     
    $thePg = $currentPg - 1;
    $shownRange .= '<a href="' . $pgPath . $thePg . '">' . $thePg . '</a> ';  
  }
  if ($currentPg > 0) {  
    $shownRange .= $currentPg . ' ';
  }
  if (($currentPg + 1) <= $maxPages) {     
    $thePg = $currentPg + 1;
    $shownRange .= '<a href="' . $pgPath . $thePg . '">' . $thePg . '</a> ';  
  }  
  if (($currentPg + 2) <= $maxPages) {     
    $thePg = $currentPg + 2;
    $shownRange .= '<a href="' . $pgPath . $thePg . '">' . $thePg . '</a> ';  
  }

  echo $shownRange;
  
  if (($currentPg + 3) < $maxPages) {     
    echo ' ... ';
  }  
  
  if ($currentPg < $maxPages) {
    $nextPg = $currentPg + 1;
    echo ' <a href="', $pgPath, $nextPg, '">NEXT &gt;</a>';
  }
  
  echo ' &nbsp; | &nbsp; <a href="', $pgPath, '0">View all</a>';
  
}

if (!isset($qa[0]) || empty($qa[0]) || !is_numeric($qa[0])) {
  $qa[0] = 1;
}

$cleanedBrandID = mysql_real_escape_string($qa[0]);

// brand details
$qry = "SELECT * FROM brands WHERE ID='" . $cleanedBrandID . "' AND ACTIVE=1";
$res = mysql_query($qry) or die(mysql_error());
$brandInfo = mysql_fetch_assoc($res);

if (count($brandInfo) == 0) {

  echo '<div id="browseHdr"><h1>Brand Not Found</h1></div>';
  
}

else {

  $qry = "SELECT * FROM technique WHERE BRAND_ID='" . $cleanedBrandID . "' AND ACTIVE=1 ORDER BY TECHNIQUE_CREATED DESC";
  $res = mysql_query($qry) or die(mysql_error());
  $techniqueCount = mysql_num_rows($res);

  if (!isset($qa[1]) || (is_numeric($qa[1]) && $qa[1] > 0)) {

    if (!isset($qa[1]) || $qa[1] == '1') { $limitStart = 0; }
    else { 
      $cleanedMultiplier = mysql_real_escape_string($qa[1]) - 1;
      $limitStart = $cleanedMultiplier * 10;
    }
    
    $qry = "SELECT * FROM technique WHERE BRAND_ID='" . $cleanedBrandID . "' AND ACTIVE=1 ORDER BY TECHNIQUE_CREATED DESC LIMIT " . $limitStart . ",10";
    $res = mysql_query($qry) or die(mysql_error());
  
  }
  
  if ($techniqueCount > 1 || $techniqueCount == 0) { $projTxt = ' techniques'; }
  else { $projTxt = ' technique'; }  
  
  echo '<div id="browseHdr"><h1>', $brandInfo['NAME'], ' Techniques</h1>',
       '<div id="itemCount">', $techniqueCount, ' technique(s) found</div>',
       '<div id="pagination">';
  
  if ($techniqueCount > 10) {
    buildPagination($techniqueCount);
  }
  
  echo '</div>',
       '</div>';
  
  while ($data = mysql_fetch_assoc($res)) {
  
    echo '<div class="browsePhoto">',
         '<a href="/technique-details/', $data['TECHNIQUE_ID'], '"><img src="/images/techniques/', $data['TECHNIQUE_ID'], '/', $data['TECHNIQUE_PHOTO'], '" alt="', $data['TECHNIQUE_TITLE'], '" /></a>',
         '</div>',
         '<div class="browseDesc">',
         '<h2><a href="/technique-details/', $data['TECHNIQUE_ID'], '">', $data['TECHNIQUE_TITLE'], '</a></h2>',
         $data['TECHNIQUE_SUMMARY'],
         '</div>',
         '<div class="clr"></div>';
   
  }

  echo '<div class="clr"></div>';

}

?>