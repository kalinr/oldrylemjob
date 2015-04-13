<?php

// images
$qry = "SELECT * FROM landing_pages WHERE LANDING_PAGE_ID=1";
$res = mysql_query($qry) or die(mysql_error());
$lpData = mysql_fetch_assoc($res);

// fabric
$qry = "SELECT brands.NAME, brands.ID, brands.MOD_NAME FROM brands JOIN learn ON learn.BRAND_ID=brands.ID WHERE brands.CATEGORYID=1 AND brands.ACTIVE=1 AND learn.ACTIVE=1 ORDER BY brands.NAME ASC";
$fabricRes = mysql_query($qry) or die(mysql_error());

// selected fabric
$qry = "SELECT * FROM brands_products JOIN products ON products.ID=brands_products.PRODUCTID WHERE brands_products.BRANDID='" . $lpData['FEATURED_LEARN_FABRIC'] . "' LIMIT 1";
$res = mysql_query($qry) or die(mysql_error());
$fabricPhoto = mysql_fetch_assoc($res);

// paper
$qry = "SELECT brands.NAME, brands.ID, brands.MOD_NAME FROM brands JOIN learn ON learn.BRAND_ID=brands.ID WHERE brands.CATEGORYID=15 AND brands.ACTIVE=1 AND learn.ACTIVE=1 ORDER BY brands.NAME ASC";
$paperRes = mysql_query($qry) or die(mysql_error());

// selected paper
$qry = "SELECT * FROM brands_products JOIN products ON products.ID=brands_products.PRODUCTID WHERE brands_products.BRANDID='" . $lpData['FEATURED_LEARN_PAPER'] . "' LIMIT 1";
$res = mysql_query($qry) or die(mysql_error());
$paperPhoto = mysql_fetch_assoc($res);

// mixed media
$qry = "SELECT brands.NAME, brands.ID, brands.MOD_NAME FROM brands JOIN learn ON learn.BRAND_ID=brands.ID WHERE brands.CATEGORYID=16 AND brands.ACTIVE=1 AND learn.ACTIVE=1 ORDER BY brands.NAME ASC";
$mixedmediaRes = mysql_query($qry) or die(mysql_error());

// selected mixed media
$qry = "SELECT * FROM brands_products JOIN products ON products.ID=brands_products.PRODUCTID WHERE brands_products.BRANDID='" . $lpData['FEATURED_LEARN_MIXEDMEDIA'] . "' LIMIT 1";
$res = mysql_query($qry) or die(mysql_error());
$mixedmediaPhoto = mysql_fetch_assoc($res);

// tools
$qry = "SELECT brands.NAME, brands.ID, brands.MOD_NAME FROM brands JOIN learn ON learn.BRAND_ID=brands.ID WHERE brands.CATEGORYID=14 AND brands.ACTIVE=1 AND learn.ACTIVE=1 ORDER BY brands.NAME ASC";
$toolRes = mysql_query($qry) or die(mysql_error());

// selected tools
$qry = "SELECT * FROM brands_products JOIN products ON products.ID=brands_products.PRODUCTID WHERE brands_products.BRANDID='" . $lpData['FEATURED_LEARN_TOOL'] . "' LIMIT 1";
$res = mysql_query($qry) or die(mysql_error());
$toolPhoto = mysql_fetch_assoc($res);


echo '<img src="images/learn/' . $lpData['LEARN_IMG'] . '" width="1040" alt="Learn" />';

echo '<div id="learnPagePromos">',
     '<a class="compatChart" target="_blank" href="documents/Surface-Compatibility-Chart.pdf">Download Surface Compatibility Chart</a>',
     '<div class="clr"></div>';

echo '<div class="learnCol"><a class="learnFeature" href="/learn-fabric-overview"><img src="images/products/', $fabricPhoto['ID'], '.jpg" alt="', $fabricPhoto['NAME'], '" /><span class="featureTxt">Fabric</span></a>';
echo '<ul>';
while ($data = mysql_fetch_assoc($fabricRes)) {
  echo '<li><a href="/learn-', $data['MOD_NAME'], '">', $data['NAME'], '</a></li>';
}
echo '</ul>';
echo '</div>';

echo '<div class="learnCol"><a class="learnFeature" href="/learn-paper-overview"><img src="images/products/', $paperPhoto['ID'], '.jpg" alt="', $paperPhoto['NAME'], '" /><span class="featureTxt">Paper</span></a>';
echo '<ul>';
while ($data = mysql_fetch_assoc($paperRes)) {
  echo '<li><a href="/learn-', $data['MOD_NAME'], '">', $data['NAME'], '</a></li>';
}
echo '</ul>';
echo '</div>';

echo '<div class="learnCol"><a class="learnFeature" href="/learn-mixed-media-overview"><img src="images/products/', $mixedmediaPhoto['ID'], '.jpg" alt="', $mixedmediaPhoto['NAME'], '" /><span class="featureTxt">Mixed Media</span></a>';
echo '<ul>';
while ($data = mysql_fetch_assoc($mixedmediaRes)) {
  echo '<li><a href="/learn-', $data['MOD_NAME'], '">', $data['NAME'], '</a></li>';
}
echo '</ul>';
echo '</div>';

echo '<div class="learnCol lastCol"><a class="learnFeature" href="/learn-tools-overview"><img src="images/products/', $toolPhoto['ID'], '.jpg" alt="', $toolPhoto['NAME'], '" /><span class="featureTxt">Tools</span></a>';
echo '<ul>';
while ($data = mysql_fetch_assoc($toolRes)) {
  echo '<li><a href="/learn-', $data['MOD_NAME'], '">', $data['NAME'], '</a></li>';
}
echo '</ul>';
echo '</div>';

echo '</div>';

echo '<div class="clr"></div>';

?>