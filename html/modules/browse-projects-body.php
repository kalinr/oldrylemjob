<?php

function buildPagination($num) {

  global $qa;
    
  $maxPages = ceil($num / 10);
  
  if ($maxPages == 1 && $num > 10 && $num < 20) { $maxPages = 2; }
  
  // no page number or invalid page number
  if (!isset($qa[1]) || !is_numeric($qa[1])) {
    $qa[1] = 1;
  }

  $pgPath = '/browse-projects/' . $qa[0] . '/';
  
  $currentPg = $qa[1];

  if ($currentPg > 1) {  
    $previousPg = $currentPg - 1;
    echo '<a href="', $pgPath . $previousPg, '">&lt; PREV</a> ';  
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

if (!isset($qa[0]) || !is_numeric($qa[0])) {
  $qa[0] = '0.0';
}

// break apart the GET data
$urlPth = explode('.', $qa[0]);

switch ($urlPth[0]) {

  case '1' : 
  
    // all
    if (!isset($urlPth[1]) || !is_numeric($urlPth[1]) || $urlPth[1] == '0') {
    
      $qry = "SELECT project.* FROM project JOIN project_facet ON project.PROJECT_ID=project_facet.PROJECT_ID JOIN medium ON medium.MEDIUM_ID=project_facet.FACET_ID WHERE project_facet.FACET_TYPE=1 AND project.ACTIVE=1 AND medium.ACTIVE=1 GROUP BY project.PROJECT_ID ORDER BY project.PROJECT_CREATED DESC";    
      $pageHdr = 'Projects By Medium';
    
    }
    
    // drill down
    else {
     
      $cleanedFacetID = mysql_real_escape_string($urlPth[1]);
      $qry = "SELECT project.* FROM project JOIN project_facet ON project.PROJECT_ID=project_facet.PROJECT_ID JOIN medium ON medium.MEDIUM_ID=project_facet.FACET_ID WHERE project_facet.FACET_TYPE=1 AND project.ACTIVE=1 AND medium.ACTIVE=1 AND project_facet.FACET_ID='" . $cleanedFacetID . "' GROUP BY project.PROJECT_ID ORDER BY project.PROJECT_CREATED DESC";
      
      $qry2 = "SELECT * FROM medium WHERE MEDIUM_ID='" . $cleanedFacetID . "' AND ACTIVE=1";
      $res2 = mysql_query($qry2) or die(mysql_error());
      $facetArr = mysql_fetch_assoc($res2);
      $pageHdr = $facetArr['MEDIUM_TITLE'] . ' Projects';
    
    }
    
    break;

  case '2' : 

    // all
    if (!isset($urlPth[1]) || !is_numeric($urlPth[1]) || $urlPth[1] == '0') {
    
      $qry = "SELECT project.* FROM project JOIN project_facet ON project.PROJECT_ID=project_facet.PROJECT_ID JOIN project_brand ON project_brand.PROJECT_BRAND_ID=project_facet.FACET_ID WHERE project_facet.FACET_TYPE=2 AND project.ACTIVE=1 AND project_brand.ACTIVE=1 GROUP BY project.PROJECT_ID ORDER BY project.PROJECT_CREATED DESC";
      $pageHdr = 'Projects By Product';

    }
    
    // drill down
    else {

      $cleanedFacetID = mysql_real_escape_string($urlPth[1]);    
      $qry = "SELECT project.* FROM project JOIN project_facet ON project.PROJECT_ID=project_facet.PROJECT_ID JOIN project_brand ON project_brand.PROJECT_BRAND_ID=project_facet.FACET_ID WHERE project_facet.FACET_TYPE=2 AND project.ACTIVE=1 AND project_brand.ACTIVE=1 AND project_facet.FACET_ID='" . $cleanedFacetID . "' GROUP BY project.PROJECT_ID ORDER BY project.PROJECT_CREATED DESC";  

      $qry2 = "SELECT * FROM project_brand JOIN brands ON brands.ID=project_brand.BRAND_ID WHERE project_brand.PROJECT_BRAND_ID='" . $cleanedFacetID . "' AND brands.ACTIVE=1 AND project_brand.ACTIVE=1";
      $res2 = mysql_query($qry2) or die(mysql_error());
      $facetArr = mysql_fetch_assoc($res2);
      $pageHdr = $facetArr['NAME'];
    
    }
    
    break;   
  
  case '3' : 
  
    // all
    if (!isset($urlPth[1]) || !is_numeric($urlPth[1]) || $urlPth[1] == '0') {

      $qry = "SELECT project.* FROM project JOIN project_facet ON project.PROJECT_ID=project_facet.PROJECT_ID JOIN aesthetic ON aesthetic.AESTHETIC_ID=project_facet.FACET_ID WHERE project_facet.FACET_TYPE=3 AND project.ACTIVE=1 AND aesthetic.ACTIVE=1 GROUP BY project.PROJECT_ID ORDER BY project.PROJECT_CREATED DESC";
      $pageHdr = 'Projects By Aesthetic';

    }
    
    // drill down
    else {
    
      $cleanedFacetID = mysql_real_escape_string($urlPth[1]);    
      $qry = "SELECT project.* FROM project JOIN project_facet ON project.PROJECT_ID=project_facet.PROJECT_ID JOIN aesthetic ON aesthetic.AESTHETIC_ID=project_facet.FACET_ID WHERE project_facet.FACET_TYPE=3 AND project.ACTIVE=1 AND aesthetic.ACTIVE=1 AND project_facet.FACET_ID='" . $cleanedFacetID . "' GROUP BY project.PROJECT_ID ORDER BY project.PROJECT_CREATED DESC";

      $qry2 = "SELECT * FROM aesthetic WHERE AESTHETIC_ID='" . $cleanedFacetID . "' AND ACTIVE=1";
      $res2 = mysql_query($qry2) or die(mysql_error());
      $facetArr = mysql_fetch_assoc($res2);
      $pageHdr = $facetArr['AESTHETIC_TITLE'] . ' Projects';
    
    }
    
    break;
  
  case '4' : 
  
    // all
    if (!isset($urlPth[1]) || !is_numeric($urlPth[1]) || $urlPth[1] == '0') {

      $qry = "SELECT project.* FROM project JOIN project_facet ON project.PROJECT_ID=project_facet.PROJECT_ID JOIN season ON season.SEASON_ID=project_facet.FACET_ID WHERE project_facet.FACET_TYPE=4 AND project.ACTIVE=1 AND season.ACTIVE=1 GROUP BY project.PROJECT_ID ORDER BY project.PROJECT_CREATED DESC";
      $pageHdr = 'Projects By Season/Occasion';

    }
    
    // drill down
    else {

      $cleanedFacetID = mysql_real_escape_string($urlPth[1]);    
      $qry = "SELECT project.* FROM project JOIN project_facet ON project.PROJECT_ID=project_facet.PROJECT_ID JOIN season ON season.SEASON_ID=project_facet.FACET_ID WHERE project_facet.FACET_TYPE=4 AND project.ACTIVE=1 AND season.ACTIVE=1 AND project_facet.FACET_ID='" . $cleanedFacetID . "' GROUP BY project.PROJECT_ID ORDER BY project.PROJECT_CREATED DESC";

      $qry2 = "SELECT * FROM season WHERE SEASON_ID='" . $cleanedFacetID . "' AND ACTIVE=1";
      $res2 = mysql_query($qry2) or die(mysql_error());
      $facetArr = mysql_fetch_assoc($res2);
      $pageHdr = $facetArr['SEASON_TITLE'] . ' Projects';
      
    }
    
    break;
  
  case '5' : 
  
    // all
    if (!isset($urlPth[1]) || !is_numeric($urlPth[1]) || $urlPth[1] == '0') {
  
      $qry = "SELECT project.* FROM project JOIN project_facet ON project.PROJECT_ID=project_facet.PROJECT_ID JOIN project_type ON project_type.TYPE_ID=project_facet.FACET_ID WHERE project_facet.FACET_TYPE=5 AND project.ACTIVE=1 AND project_type.ACTIVE=1 GROUP BY project.PROJECT_ID ORDER BY project.PROJECT_CREATED DESC";
      $pageHdr = 'Projects By Type';

    }
    
    // drill down
    else {  

      $cleanedFacetID = mysql_real_escape_string($urlPth[1]);
      $qry = "SELECT project.* FROM project JOIN project_facet ON project.PROJECT_ID=project_facet.PROJECT_ID JOIN project_type ON project_type.TYPE_ID=project_facet.FACET_ID WHERE project_facet.FACET_TYPE=5 AND project.ACTIVE=1 AND project_type.ACTIVE=1 AND project_facet.FACET_ID='" . $cleanedFacetID . "' GROUP BY project.PROJECT_ID ORDER BY project.PROJECT_CREATED DESC";

      $qry2 = "SELECT * FROM project_type WHERE TYPE_ID='" . $cleanedFacetID . "' AND ACTIVE=1";
      $res2 = mysql_query($qry2) or die(mysql_error());
      $facetArr = mysql_fetch_assoc($res2);
      $pageHdr = $facetArr['TYPE_TITLE'] . ' Projects';
      
    }
  
    break;
  
  default : 
    
    $qry = "SELECT * FROM project WHERE ACTIVE=1 ORDER BY PROJECT_CREATED DESC";
    $pageHdr = 'All Projects';
  
}

$res = mysql_query($qry) or die(mysql_error());
$projectCount = mysql_num_rows($res);

if (!isset($qa[1]) || (is_numeric($qa[1]) && $qa[1] > 0)) {

  if (!isset($qa[1]) || $qa[1] == '1') { $limitStart = 0; }
  else { 
    $cleanedMultiplier = mysql_real_escape_string($qa[1]) - 1;
    $limitStart = $cleanedMultiplier * 10;
  }
    
  $qry .= " LIMIT " . $limitStart . ",10";
 
}

// finally query for the data
$res = mysql_query($qry) or die(mysql_error());

if ($projectCount > 1 || $projectCount == 0) { $projTxt = ' projects'; }
else { $projTxt = ' project'; }

// page header, item count, pagination
echo '<div id="browseHdr"><h1>', $pageHdr, '</h1>',
     '<div id="itemCount">', $projectCount, $projTxt, ' found</div>',
     '<div id="pagination">';
  
if ($projectCount > 10) {
  buildPagination($projectCount);
}
  
echo '</div>',
     '</div>';
  
  
// left nav - cannot use leftmenu.php because of code sequencing differences
echo '<div class="Lsidebar"><div class="nav"><ul>';

if ($urlPth[0] == '1') {

  echo '<li style="margin-top:0"><a class="currentLeftNav" href="/browse-projects/1.0">Choose Medium</a>';

  $query2 = "SELECT * FROM medium WHERE ACTIVE=1 ORDER BY DISPLAY_ORDER ASC";
  $result2 = mysql_query($query2) or die (mysql_error());
  if (mysql_num_rows($result2) > 0) {
    
    echo '<ul style="margin-top: 0">';
    
    while ($data = mysql_fetch_assoc($result2)) {

      $cleanedLabel = str_replace('&', '&amp;', $data['MEDIUM_TITLE']);
      $cleanedLabel = stripslashes($cleanedLabel);    

      if (isset($urlPth[1]) && $urlPth[1] == $data['MEDIUM_ID']) {

        echo '<li><a class="currentLeftNav" href="/browse-projects/1.' . $data['MEDIUM_ID'] . '">' . $cleanedLabel . '</a></li>';

      }
          
      else {

        echo '<li><a href="/browse-projects/1.' . $data['MEDIUM_ID'] . '">' . $cleanedLabel . '</a></li>';
          
      }
         
    }
       
    echo '</ul>';

  }

}

else {

  echo '<li style="margin-top:0"><a href="/browse-projects/1.0">Choose Medium</a>';

}

echo '</li>';


if ($urlPth[0] == '2') {

  echo '<li><a class="currentLeftNav" href="/browse-projects/2.0">Choose Product</a>';

  $query2 = "SELECT * FROM project_brand JOIN brands ON brands.ID=project_brand.BRAND_ID WHERE project_brand.ACTIVE=1 AND brands.ACTIVE=1 ORDER BY project_brand.DISPLAY_ORDER ASC";
  $result2 = mysql_query($query2) or die (mysql_error());
  if (mysql_num_rows($result2) > 0) {
    
    echo '<ul style="margin-top: 0">';
    
    while ($data = mysql_fetch_assoc($result2)) {

      $cleanedLabel = str_replace('&', '&amp;', $data['NAME']);
      $cleanedLabel = stripslashes($cleanedLabel);    

      if (isset($urlPth[1]) && $urlPth[1] == $data['PROJECT_BRAND_ID']) {

        echo '<li><a class="currentLeftNav" href="/browse-projects/2.' . $data['PROJECT_BRAND_ID'] . '">' . $cleanedLabel . '</a></li>';

      }
          
      else {

        echo '<li><a href="/browse-projects/2.' . $data['PROJECT_BRAND_ID'] . '">' . $cleanedLabel . '</a></li>';
          
      }
          
    }
       
    echo '</ul>';

  }

}    

else {

  echo '<li><a href="/browse-projects/2.0">Choose Product</a>';

}

echo '</li>';


if ($urlPth[0] == '3') {

  echo '<li><a class="currentLeftNav" href="/browse-projects/3.0">Choose Aesthetic</a>';

  $query2 = "SELECT * FROM aesthetic WHERE ACTIVE=1 ORDER BY DISPLAY_ORDER ASC";
  $result2 = mysql_query($query2) or die (mysql_error());

  if (mysql_num_rows($result2) > 0) {
    
    echo '<ul style="margin-top: 0">';
    
    while ($data = mysql_fetch_assoc($result2)) {

      $cleanedLabel = str_replace('&', '&amp;', $data['AESTHETIC_TITLE']);
      $cleanedLabel = stripslashes($cleanedLabel);    

      if (isset($urlPth[1]) && $urlPth[1] == $data['AESTHETIC_ID']) {

        echo '<li><a class="currentLeftNav" href="/browse-projects/3.' . $data['AESTHETIC_ID'] . '">' . $cleanedLabel . '</a></li>';

      }
          
      else {

        echo '<li><a href="/browse-projects/3.' . $data['AESTHETIC_ID'] . '">' . $cleanedLabel . '</a></li>';
          
      }
          
    }
         
    echo '</ul>';

  }

}    

else {

  echo '<li><a href="/browse-projects/3.0">Choose Aesthetic</a>';

}

echo '</li>';


if ($urlPth[0] == '4') {

  echo '<li><a class="currentLeftNav" href="/browse-projects/4.0">Choose Season/Occasion</a>';

  $query2 = "SELECT * FROM season WHERE ACTIVE=1 ORDER BY DISPLAY_ORDER ASC";
  $result2 = mysql_query($query2) or die (mysql_error());

  if (mysql_num_rows($result2) > 0) {
    
    echo '<ul style="margin-top: 0">';
    
    while ($data = mysql_fetch_assoc($result2)) {

      $cleanedLabel = str_replace('&', '&amp;', $data['SEASON_TITLE']);
      $cleanedLabel = stripslashes($cleanedLabel);    
 
      if (isset($urlPth[1]) && $urlPth[1] == $data['SEASON_ID']) {

        echo '<li><a class="currentLeftNav" href="/browse-projects/4.' . $data['SEASON_ID'] . '">' . $cleanedLabel . '</a></li>';

      }
          
      else {

        echo '<li><a href="/browse-projects/4.' . $data['SEASON_ID'] . '">' . $cleanedLabel . '</a></li>';
            
      }
         
    }
       
    echo '</ul>';
 
  }

}    

else {

  echo '<li><a href="/browse-projects/4.0">Choose Season/Occasion</a>';

}

echo '</li>';


if ($urlPth[0] == '5') {

  echo '<li><a class="currentLeftNav" href="/browse-projects/5.0">Choose Project Type</a>';

  $query2 = "SELECT * FROM project_type WHERE ACTIVE=1 ORDER BY DISPLAY_ORDER ASC";
  $result2 = mysql_query($query2) or die (mysql_error());

  if (mysql_num_rows($result2) > 0) {
    
    echo '<ul style="margin-top: 0">';
    
    while ($data = mysql_fetch_assoc($result2)) {

      $cleanedLabel = str_replace('&', '&amp;', $data['TYPE_TITLE']);
      $cleanedLabel = stripslashes($cleanedLabel);    

      if (isset($urlPth[1]) && $urlPth[1] == $data['TYPE_ID']) {

        echo '<li><a class="currentLeftNav" href="/browse-projects/5.' . $data['TYPE_ID'] . '">' . $cleanedLabel . '</a></li>';

      }
          
      else {

        echo '<li><a href="/browse-projects/5.' . $data['TYPE_ID'] . '">' . $cleanedLabel . '</a></li>';
          
      }
         
    }
       
    echo '</ul>';

  }

}    

else {

  echo '<li><a href="/browse-projects/5.0">Choose Project Type</a>';

}

echo '</li>';

echo '</ul></div></div>';


// content area
echo '<div id="browsingArea">';

while ($data = mysql_fetch_assoc($res)) {
  
  $urlAddendum = '/' . $qa[0];
  
  echo '<div class="browsePhoto">',
       '<a href="/project-details/', $data['PROJECT_ID'], $urlAddendum, '"><img src="/images/projects/', $data['PROJECT_ID'], '/', $data['PROJECT_PHOTO'], '" alt="', $data['PROJECT_TITLE'], '" /></a>',
       '</div>',
       '<div class="browseDesc abbrev">',
       '<h2><a href="/project-details/', $data['PROJECT_ID'], $urlAddendum, '">', $data['PROJECT_TITLE'], '</a></h2>',
       $data['PROJECT_SUMMARY'],
       '</div>',
       '<div class="clr"></div>';

}

echo '</div>';

echo '<div class="clr"></div>';

?>