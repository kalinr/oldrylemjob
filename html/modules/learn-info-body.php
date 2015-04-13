<?php

// technique count
$qry2 = "SELECT TECHNIQUE_ID FROM technique WHERE BRAND_ID='" . $pageInfo['BRAND_ID'] . "' AND ACTIVE=1";
$res2 = mysql_query($qry2) or die(mysql_error());
$techniqueCount = mysql_num_rows($res2);

// project count
$qry3 = "SELECT project_facet.PROJECT_FACET_ID FROM project_facet JOIN project_brand ON project_brand.PROJECT_BRAND_ID=project_facet.FACET_ID JOIN project ON project.PROJECT_ID=project_facet.PROJECT_ID WHERE project.ACTIVE=1 AND project_brand.ACTIVE=1 AND project_brand.BRAND_ID='" . $pageInfo['BRAND_ID'] . "' AND project_facet.FACET_TYPE=2";
$res3 = mysql_query($qry3) or die(mysql_error());
$projectCount = mysql_num_rows($res3);

echo '<img class="learnBanner" src="images/learn-banners/', $pageInfo['LEARN_ID'], '/', $pageInfo['LEARN_PHOTO'], '" alt="', $brandInfo['NAME'], '" />';

if (!empty($pageInfo['LEARN_HEADING'])) {

  echo '<h1>', $pageInfo['LEARN_HEADING'], '</h1>';

}

if (!empty($pageInfo['LEARN_VIDEO'])) {

  echo '<div class="videoEmbed">', $pageInfo['LEARN_VIDEO'], '</div>';

}

echo '<div class="learnContentArea">', $pageInfo['LEARN_TEXT'], '</div>';

echo '<div class="learnSeeAlso">';

if ($pageInfo['SHOW_TECHNIQUES_LINK'] == '1') {

  echo '<a href="browse-techniques/', $brandInfo['ID'], '">View ', $techniqueCount, ' ', $brandInfo['NAME'], ' Technique(s)</a><br /><br />'; 

}

if ($pageInfo['SHOW_PROJECTS_LINK'] == '1') {

  echo '<a href="browse-project-brand/', $brandInfo['ID'], '">View ', $projectCount, ' ', $brandInfo['NAME'], ' Project(s)</a><br /><br />'; 

}

if ($pageInfo['SHOW_SHOP_LINK'] == '1') {

  echo '<a href="/', $brandInfo['MOD_NAME'], '">View in Shop</a><br /><br />'; 

}

echo '</div>';

echo '<div class="clr"></div>';

?>