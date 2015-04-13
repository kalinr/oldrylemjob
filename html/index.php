<? require_once("functions/start.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="/css/main.css" />
<?php 

  if ($content['MODULE_META'] != '') {

    include("modules/".$content['MODULE_META']); 
 
  }

  else {

    echo '<title>', stripslashes($content['META_TITLE']), ' | ', stripslashes(SITE_NAME), '</title>';
    echo '<meta name="description" content="', stripslashes($content['META_DESCRIPTION']), '" />';
    echo '<meta name="keywords" content="', stripslashes($content['META_KEYWORDS']), '" />';

  }

  if ($content['MODULE_HEAD'] != '') {

    include("modules/".$content['MODULE_HEAD']); 
 
  }

  if (!stristr($content['MOD_NAME'], 'admin')) {

?>

<script type="text/javascript">

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-54832707-2', 'auto');
  ga('send', 'pageview');

</script>
<?php

}

else {

  echo '<meta name="robots" content="noindex" />';

  if ($content['MODULE_HEAD'] != '') {
  
    include("modules/" . $content['MODULE_HEAD']);
  
  }

}

?>
</head>

<body onload="<?php if ($ckeditor) { echo 'setupEditor();'; } ?>">

<div id="utilityNav"><?php 
  
if ($_SESSION['USERID'] > 0) {
  
  echo '<a href="/myaccount/orders">My Account</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="/search">Search</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';

}

else {
 
  echo '<a href="/login">Account Login</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="/search">Search</a> &nbsp;&nbsp;|&nbsp;&nbsp; ';

}

$return_array = cartStats($account['TYPEID'],$account['DISCOUNT']);

if ($return_array['quantity'] == '0') {

  echo 'Shopping Cart: 0 Items';

}

else {
  
  if ($return_array['quantity'] > 1) { $qtxt = 'items'; } else { $qtxt = 'item'; }
  echo '<a href="/cart">View Cart: ', $return_array['quantity'], ' ', $qtxt, '&nbsp; $', number_format($return_array['subtotal'],2), '</a>';

}

?>
</div>

<?php 

  if ((empty($content['MOD_NAME']) && !empty($content['ID'])) || $content['MODULE_BODY'] == 'learn-body.php') { 

    echo '<div id="logoTopnav" style="border:0">';

  }
  
  else {
   
    echo '<div id="logoTopnav">';
    
  }
  ?>
  
  <div id="logoSpc"><a href="/"><img src="/images/ic-logo.png" width="255" height="101" alt="Imagine Crafts" /></a></div>  
  <div id="tNav">
  
  <?php 

    if ($content['MODULE_BODY'] == 'learn-body.php' || $content['MODULE_BODY'] == 'learn-info-body.php' || $content['MODULE_BODY'] == 'learn-overview-body.php' || $content['MODULE_BODY'] == 'browse-techniques-body.php' || $content['MODULE_BODY'] == 'technique-details-body.php') {
    
      echo '<a class="currentTopNav" href="/learn">Learn</a>';
    
    }
  
    else {
    
      echo '<a href="/learn">Learn</a>';
    
    }

    if ($content['MODULE_BODY'] == 'browse-projects-body.php' || $content['MODULE_BODY'] == 'browse-projects-brand-body.php' || $content['MODULE_BODY'] == 'project-details-body.php') {
    
      echo '<a class="currentTopNav" href="/browse-projects">Make</a>';
    
    }
  
    else {
    
      echo '<a href="/browse-projects">Make</a>';
    
    }

    if ($content['MODULE_BODY'] == 'community-body.php' || $content['MODULE_BODY'] == 'artist-details-body.php' || $content['MODULE_BODY'] == 'staff-body.php' ||  $content['MOD_NAME'] == 'about-us' || $content['MOD_NAME'] == 'contact-us') {
    
      echo '<a class="currentTopNav" href="/community">Community</a>';
    
    }
  
    else {
    
      echo  '<a href="/community">Community</a>';
    
    }

  
    if ($content['MODULE_BODY'] && ($content['MODULE_BODY'] == 'product-body.php' || $content['MODULE_BODY'] == 'product-category-body.php' || $content['MOD_NAME'] == 'shop')) {
    
      echo  '<a class="currentTopNav" href="/shop">Shop</a>';
    
    }
  
    else {
    
      echo  '<a href="/shop">Shop</a>';
    
    }
  
  ?>
  </div>
</div>

<?php 

  if ($content['ID'] == '') {

    echo '<div id="frame"><div class="insidecontent" style="width:100%; float: none;">',
         '<h1>Page Not Found</h1>',
         '<p>We\'re sorry, but the page you\'ve attempted to access was not found.</p>',
         '<p><a href="/">Return To Homepage</a></p>',
         '</div>';

  }

  // home
  elseif (empty($content['MOD_NAME'])) {
  
    $qry = "SELECT * FROM landing_pages WHERE LANDING_PAGE_ID=1";
    $res = mysql_query($qry) or die(mysql_error());
    $homeData = mysql_fetch_assoc($res);
    
    $qry = "SELECT * FROM brands_products JOIN products ON products.ID=brands_products.PRODUCTID WHERE brands_products.BRANDID='" . $homeData['FEATURED_BRAND_ID'] . "' LIMIT 1";
    $res = mysql_query($qry) or die(mysql_error());
    $productData = mysql_fetch_assoc($res);
  
    $qry = "SELECT * FROM brands WHERE ID='" . $homeData['FEATURED_BRAND_ID'] . "'";
    $res = mysql_query($qry) or die(mysql_error());
    $brandData = mysql_fetch_assoc($res);
    
    $qry = "SELECT * FROM artists JOIN content ON artists.CONTENT_ID=content.ID WHERE artists.ARTIST_ID='" . $homeData['FEATURED_ARTIST_ID'] . "'";
    $res = mysql_query($qry) or die(mysql_error());
    $artistData = mysql_fetch_assoc($res);
    
    $qry = "SELECT * FROM technique WHERE ACTIVE=1 ORDER BY TECHNIQUE_CREATED DESC LIMIT 1";
    $res = mysql_query($qry) or die(mysql_error());
    $techniqueData = mysql_fetch_assoc($res);

    $qry = "SELECT * FROM project WHERE ACTIVE=1 ORDER BY PROJECT_CREATED DESC LIMIT 1";
    $res = mysql_query($qry) or die(mysql_error());
    $projectData = mysql_fetch_assoc($res);    
  
    echo '<div id="homeframe">',
         '<img id="homeImg" src="images/home/', $homeData['HOME_IMG'], '" width="1280" alt="Home Page Banner" />',
         '</div>';
    
    echo '<div id="frame">',
         '<a href="/', $brandData['MOD_NAME'], '" class="homeFeature"><img src="images/products/', $productData['ID'], '.jpg" alt="', $productData['NAME'], '" />',
         '<span class="featureTxt">featured product</span></a>';

    echo '<a href="/technique-details/', $techniqueData['TECHNIQUE_ID'], '" class="homeFeature"><img src="images/techniques/', $techniqueData['TECHNIQUE_ID'], '/', $techniqueData['TECHNIQUE_PHOTO'], '" alt="', $techniqueData['TECHNIQUE_TITLE'], '" />',
         '<span class="featureTxt">latest technique</span></a>';

    echo '<a href="/project-details/', $projectData['PROJECT_ID'], '" class="homeFeature"><img src="images/projects/', $projectData['PROJECT_ID'], '/', $projectData['PROJECT_PHOTO'], '" alt="', $projectData['PROJECT_TITLE'], '" />',
         '<span class="featureTxt">latest project</span></a>';

    echo '<a href="/', $artistData['MOD_NAME'], '" class="homeFeature lastHomeFeature"><img src="images/artists/', $artistData['ARTIST_ID'], '/', $artistData['ARTIST_PHOTO'], '" alt="', $artistData['COMPLETE_NAME'], '" />',
         '<span class="featureTxt">featured artist</span></a>';
         
  }
  
  // all else
  else {

    echo '<div id="frame">';

    include ('leftmenu.php');
  
    echo '<div class="insidecontent" ';
    
    if (!$hasSidebar) { echo 'style="width:100%; float: none;"'; }
  
    echo '>';  

    if ($content['ID'] == '219') {

      echo '<div id="shopIntro"><h1>Welcome to the IMAGINE Crafts Store</h1><p>IMAGINE Crafts supports our retailers, and we encourage you to shop at the businesses in your community or your favorite online stores. However, we know sometimes the products you want might not be available. That\'s why we created our ecommerce site: To provide you with the products you\'re looking for when you need them.</p><p>Please note: At this time, we ship to <abbr title="United States">US</abbr> addresses only.</p></div>';

    }
    
    if ($content['DISPLAY_TITLE']) {
    
      if (!empty($content['TITLE'])) {
        
        echo '<h1>' . stripslashes($content['TITLE']) . '</h1>';
      
      }
 
    }

    if ($error != "" or isset($_SESSION['STATUS'])) {

      if ($error == '' && isset($_SESSION['STATUS'])) {
       
        $error = $_SESSION['STATUS'];
        unset($_SESSION['STATUS']);

      }
       
      echo '<p id="errordiv">' . stripslashes($error) . '</p>'; //error status notice
   
    }

    if ($content['SECTIONID'] != 5) { echo stripslashes($content['BODY']); }

    if ($content['MODULE_BODY']) { include("modules/" . $content['MODULE_BODY']); }

    echo '</div>';
  
  }
    
?>
  
  <div class="clr"></div>

</div>

<div class="clr"></div>

<div id="footerArea">

  <div id="copyright">&copy; <?php echo date('Y'); ?> Imagine Crafts, All Rights Reserved</div>
  
  <div id="mailingList"><a href="/mailing-list2">Sign up for our newsletter</a></div>
  
  <div id="socialMedia">
  <a href="http://www.facebook.com/pages/Imagine-Crafts-Tsukineko/242875492467397"><img src="/images/social/facebook.png" width="10" height="19" alt="Facebook" /></a>
  <a href="http://www.pinterest.com/imaginecrafts/"><img src="/images/social/pinterest.png" width="16" height="19" alt="Pinterest" /></a>  
  <a href="https://www.twitter.com/Imagine_Crafts"><img src="/images/social/twitter.png" width="22" height="17" alt="Twitter" /></a> 
  <a href="http://www.youtube.com/user/ImagineCraftsvideos"><img src="/images/social/youtube.png" width="17" height="20" alt="YouTube" /></a> 
  <a href="https://vimeo.com/imaginecrafts/"><img src="/images/social/vimeo.png" width="20" height="18" alt="Vimeo" /></a> 
  </div>

</div>

<?php

  // echo '<div style="position:fixed; top: 0; right: 0; z-index: 1000; background: #fff; color: #000; width: 200px; white-space:pre;">', var_dump($_SESSION), '</div>';

  if ($conn != '') { mysql_close($conn); }

?>
</body>
</html>