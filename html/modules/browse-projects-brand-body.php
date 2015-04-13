<?php

function buildPagination($num) {

  global $qa;
  
  $pgPath = '/browse-project-brand/' . $qa[0] . '/';
  
  $maxPages = floor($num / 10);
  
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

  $qry = "SELECT * FROM project JOIN project_facet ON project.PROJECT_ID=project_facet.PROJECT_ID JOIN project_brand ON project_brand.PROJECT_BRAND_ID=project_facet.FACET_ID WHERE project_facet.FACET_TYPE=2 AND project_brand.BRAND_ID='" . $cleanedBrandID . "' AND project.ACTIVE=1 AND project_brand.ACTIVE=1 ORDER BY project.PROJECT_CREATED DESC";
  $res = mysql_query($qry) or die(mysql_error());
  $projectCount = mysql_num_rows($res);

  if (!isset($qa[1]) || (is_numeric($qa[1]) && $qa[1] > 0)) {

    if (!isset($qa[1]) || $qa[1] == '1') { $limitStart = 0; }
    else { 
      $cleanedMultiplier = mysql_real_escape_string($qa[1]) - 1;
      $limitStart = $cleanedMultiplier * 10;
    }
    
    $qry = "SELECT * FROM project JOIN project_facet ON project.PROJECT_ID=project_facet.PROJECT_ID JOIN project_brand ON project_brand.PROJECT_BRAND_ID=project_facet.FACET_ID WHERE project_facet.FACET_TYPE=2 AND project_brand.BRAND_ID='" . $cleanedBrandID . "' AND project.ACTIVE=1 AND project_brand.ACTIVE=1 ORDER BY project.PROJECT_CREATED DESC LIMIT " . $limitStart . ",10";
    $res = mysql_query($qry) or die(mysql_error());
  
  }
  
  echo '<div id="browseHdr"><h1>', $brandInfo['NAME'], ' Projects</h1>',
       '<div id="itemCount">', $projectCount, ' projects found</div>',
       '<div id="pagination">';
  
  if ($projectCount > 10) {
    buildPagination($projectCount);
  }
  
  echo '</div>',
       '</div>';
  
  while ($data = mysql_fetch_assoc($res)) {
  
    echo '<div class="browsePhoto">',
         '<a href="/project-details/', $data['PROJECT_ID'], '"><img src="/images/projects/', $data['PROJECT_ID'], '/', $data['PROJECT_PHOTO'], '" alt="', $data['PROJECT_TITLE'], '" /></a>',
         '</div>',
         '<div class="browseDesc">',
         '<h2><a href="/project-details/', $data['PROJECT_ID'], '">', $data['PROJECT_TITLE'], '</a></h2>',
         $data['PROJECT_SUMMARY'],
         '</div>',
         '<div class="clr"></div>';
   
  }

  echo '<div class="clr"></div>';

}

?>