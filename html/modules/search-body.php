<noscript><p><strong>JavaScript support is required to use search.</strong></p></noscript>

<?php

if (empty($qa[0])) {

echo <<<_BLANKFORM_
<h1>Search</h1>
<form action="/search" id="myform" method="post">
<p><input type="text" name="query" value="{$_SESSION['query']}" onfocus="this.select()" style="display:inline; width: 350px;" /> <input type="submit" value="Search" style="width:90px;" /></p>
</form>
<br /><br /><br /><br />
_BLANKFORM_;

}

else {

  if (empty($_SESSION['query'])) {
    $decodedQuery = urldecode($qa[0]);
    $cleanedQuery = mysql_real_escape_string($decodedQuery);
  }
  else {
    $cleanedQuery = $_SESSION['query'];
  }
  $qry = "SELECT * FROM search WHERE MATCH_TEXT LIKE '%" . $cleanedQuery . "%' GROUP BY URL_PATH ORDER BY CONTENT_TYPE ASC";
  $res = mysql_query($qry) or die(mysql_error());
  $allResults = mysql_num_rows($res);
  
  if ($allResults > 0) {
  
    $dataArr = array();
    $productArr = array();
    $projectArr = array();
    $videoArr = array();
    $allProducts = 0;
    $allProjects = 0;
    $allVideos = 0;
    
    // master array of all matches
    while ($data = mysql_fetch_assoc($res)) {  
      $dataArr[]= $data;  
    }
  
    // products
    for ($i=0; $i<$allResults; $i++) {
    
      if ($dataArr[$i]['CONTENT_TYPE'] == '1' || $dataArr[$i]['CONTENT_TYPE'] == '2' || $dataArr[$i]['CONTENT_TYPE'] == '4') {  
        $productArr[] = $dataArr[$i];  
      }
  
    }
    $allProducts = count($productArr);
  
    // projects
    for ($i=0; $i<$allResults; $i++) {

      if ($dataArr[$i]['CONTENT_TYPE'] == '3') {  
        $projectArr[] = $dataArr[$i];    
      }
  
    }
    $allProjects = count($projectArr);
  
    // videos
    for ($i=0; $i<$allResults; $i++) {

      if ($dataArr[$i]['HAS_VIDEO'] == '1') {  
        $videoArr[] = $dataArr[$i];  
      }
  
    }
    $allVideos = count($videoArr);

    echo '<h1>Search Results for &ldquo;', urldecode($qa[0]), '&rdquo;</h1>';
    
    if ($allResults == 1) { $resultTxt = 'result'; }
    else { $resultTxt = 'results'; }  
    
    echo '<p class="searchCount">', $allResults, ' ', $resultTxt, ' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href="/search/reset">New search</a></p>';
  
    echo '<div id="tabRow">',
         '<a href="#" id="productsTab" class="currentTab">Products (', $allProducts, ')</a>',
         '<a href="#" id="projectsTab">Projects (', $allProjects, ')</a>',         
         '<a href="#" id="videosTab">Videos (', $allVideos, ')</a>',
         '</div>';

    echo '<div id="productsResults"><div class="paginationBlock" id="productPagination"></div><ul class="searchList">';

    if ($allProducts == 0) {
    
      echo '<li>No products match this search.</li>';
    
    }

    for ($i=0; $i<$allProducts; $i++) {
    
      echo '<li>';
      
      if (file_exists($productArr[$i]['IMAGE_PATH'])) {
      
        echo '<div class="floatImg"><a href="', $productArr[$i]['URL_PATH'], '"><img src="../', $productArr[$i]['IMAGE_PATH'], '" alt="', $productArr[$i]['TITLE_RESULTS'], '" /></a></div>';
            
      }
      
      echo '<div class="floatData"><a href="', $productArr[$i]['URL_PATH'], '">', $productArr[$i]['TITLE_RESULTS'], '</a><br />';
      
      if (!empty($productArr[$i]['SUMMARY_RESULTS'])) {
      
        echo strip_tags($productArr[$i]['SUMMARY_RESULTS']);
      
      }  
      
      echo '</li>';
    
    }    
    echo '</ul></div>';

    echo '<div id="projectsResults"><div class="paginationBlock" id="projectPagination"></div><ul class="searchList">';

    if ($allProjects == 0) {
    
      echo '<li>No projects match this search.</li>';
    
    }

    for ($i=0; $i<$allProjects; $i++) {
    
      echo '<li>';
      
      if (file_exists($projectArr[$i]['IMAGE_PATH'])) {
      
        echo '<div class="floatImg"><a href="', $projectArr[$i]['URL_PATH'], '"><img src="../', $projectArr[$i]['IMAGE_PATH'], '" alt="', $projectArr[$i]['TITLE_RESULTS'], '" /></a></div>';
            
      }
      
      echo '<div class="floatData"><a href="', $projectArr[$i]['URL_PATH'], '">', $projectArr[$i]['TITLE_RESULTS'], '</a><br />';
      
      if (!empty($projectArr[$i]['SUMMARY_RESULTS'])) {
      
        echo strip_tags($projectArr[$i]['SUMMARY_RESULTS']);
      
      }  
      
      echo '</li>';
    
    }    
    echo '</ul></div>';

    echo '<div id="videosResults"><div class="paginationBlock" id="videoPagination"></div><ul class="searchList">';

    if ($allVideos == 0) {
    
      echo '<li>No videos match this search.</li>';
    
    }

    for ($i=0; $i<$allVideos; $i++) {
    
      echo '<li>';
      
      if (file_exists($videoArr[$i]['IMAGE_PATH'])) {
      
        echo '<div class="floatImg"><a href="', $videoArr[$i]['URL_PATH'], '"><img src="../', $videoArr[$i]['IMAGE_PATH'], '" alt="', $videoArr[$i]['TITLE_RESULTS'], '" /></a></div>';
            
      }
      
      echo '<div class="floatData"><a href="', $videoArr[$i]['URL_PATH'], '">', $videoArr[$i]['TITLE_RESULTS'], '</a><br />';
      
      if (!empty($videoArr[$i]['SUMMARY_RESULTS'])) {
      
        echo strip_tags($videoArr[$i]['SUMMARY_RESULTS']);
      
      }  
      
      echo '</li>';
    
    }
    echo '</ul></div>';

  }
  
  else {
  
    echo '<h1>Search Results for &ldquo;', urldecode($qa[0]), '&rdquo;</h1>';
  
    echo '<p>No results were found. Please try another search.';

    echo <<<_BLANKFORM_
<form action="search" id="myform" method="get">
<p><input type="text" name="query" onfocus="this.select()" style="display:inline; width: 350px;" /> <input type="submit" value="Search" style="width:90px;" /></p>
</form>
_BLANKFORM_;
  
  }

}

?>
<div class="clr"></div>