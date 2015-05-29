<?php

$hasSidebar = true;

// ADMINISTRATIVE NAV
if ($content['TYPEID'] == 3 || $content['TYPEID'] == 4) {

  echo '<div class="Lsidebar"><div class="nav"><ul>';

   if ($content['MOD_NAME'] == 'admin/artists') {
     echo '<li><a class="currentLeftNav" href="/admin/artists">Artists</a></li>';
   }    
   else {
     echo '<li><a href="/admin/artists">Artists</a></li>';
   }

   if ($content['MOD_NAME'] == 'admin/brands') {
     echo '<li><a class="currentLeftNav" href="/admin/brands">Brands</a></li>';
   }
   else {
     echo '<li><a href="/admin/brands">Brands</a></li>';
   }

   if ($content['MOD_NAME'] == 'admin/customers') {
     echo '<li><a class="currentLeftNav" href="/admin/customers">Customers</a></li>';
   }
   else {
     echo '<li><a href="/admin/customers">Customers</a></li>';
   }

   if ($content['MOD_NAME'] == 'admin/document-manager') {
     echo '<li><a class="currentLeftNav" href="/admin/document-manager">Document Manager</a></li>';
   }    
   else {
     echo '<li><a href="/admin/document-manager">Document Manager</a></li>';
   }

   if ($content['MOD_NAME'] == 'admin/editable-pages') {
     echo '<li><a class="currentLeftNav" href="/admin/editable-pages">Editable Pages</a></li>';
   }    
   else {
     echo '<li><a href="/admin/editable-pages">Editable Pages</a></li>';
   }
 
   if ($content['MOD_NAME'] == 'admin/exports') {
     echo '<li><a class="currentLeftNav" href="/admin/exports">Exports</a></li>';
   }      
   else {
     echo '<li><a href="/admin/exports">Exports</a></li>';
   } 

   if ($content['MOD_NAME'] == 'admin/landing-pages') {
     echo '<li><a class="currentLeftNav" href="/admin/landing-pages">Landing Pages</a></li>';
   }    
   else {
     echo '<li><a href="/admin/landing-pages">Landing Pages</a></li>';
   }

   if ($content['MOD_NAME'] == 'admin/learn') {
     echo '<li><a class="currentLeftNav" href="/admin/learn">Learn Pages</a></li>';
   }    
   else {
     echo '<li><a href="/admin/learn">Learn Pages</a></li>';
   }

 
   if ($content['MOD_NAME'] == 'admin/orders') {
     echo '<li><a class="currentLeftNav" href="/admin/orders">Orders</a></li>';
   }
   else {
     echo '<li><a href="/admin/orders">Orders</a></li>';
   }

   if ($content['MOD_NAME'] == 'admin/update-products') {
     echo '<li><a class="currentLeftNav" href="/admin/update-products">Price &amp; Specs Updates</a></li>';
   }
   else {
     echo '<li><a href="/admin/update-products">Price &amp; Specs Updates</a></li>';
   }

   if ($content['MOD_NAME'] == 'admin/products') {
     echo '<li><a class="currentLeftNav" href="/admin/products">Products</a></li>';
   }
   else {
     echo '<li><a href="/admin/products">Products</a></li>';
   }

   if ($content['MOD_NAME'] == 'admin/categories') {
     echo '<li><a class="currentLeftNav" href="/admin/categories">Product Categories</a></li>';
   }
   else {
     echo '<li><a href="/admin/categories">Product Categories</a></li>';
   }

   if ($content['MOD_NAME'] == 'admin/project-facets') {
     echo '<li><a class="currentLeftNav" href="/admin/project-facets">Project Facets</a></li>';
   }
   else {
     echo '<li><a href="/admin/project-facets">Project Facets</a></li>';
   }

   if ($content['MOD_NAME'] == 'admin/projects') {
     echo '<li><a class="currentLeftNav" href="/admin/projects">Projects</a></li>';
   }
   else {
     echo '<li><a href="/admin/projects">Projects</a></li>';
   }

   if ($content['MOD_NAME'] == 'admin/promo-codes') {
     echo '<li><a class="currentLeftNav" href="/admin/promo-codes">Promo Codes</a></li>';
   }
   else {
     echo '<li><a href="/admin/promo-codes">Promo Codes</a></li>';
   }

   if ($content['MOD_NAME'] == 'admin/reports') {
     echo '<li><a class="currentLeftNav" href="/admin/reports">Reports</a></li>';
   }   
   else {
     echo '<li><a href="/admin/reports">Reports</a></li>';
   }

   if ($content['MOD_NAME'] == 'admin/search-index') {
     echo '<li><a class="currentLeftNav" href="/admin/search-index">Search Index</a></li>';
   }    
   else {
     echo '<li><a href="/admin/search-index">Search Index</a></li>';
   }

   if ($content['MOD_NAME'] == 'admin/update-shipping-prices') {
     echo '<li><a class="currentLeftNav" href="/admin/update-shipping-prices">Shipping Prices</a></li>';
   }    
   else {
     echo '<li><a href="/admin/update-shipping-prices">Shipping Prices</a></li>';
   }

   if ($content['MOD_NAME'] == 'admin/staff') {
     echo '<li><a class="currentLeftNav" href="/admin/staff">Staff Members</a></li>';
   }    
   else {
     echo '<li><a href="/admin/staff">Staff Members</a></li>';
   }

   if ($content['MOD_NAME'] == 'admin/techniques') {
     echo '<li><a class="currentLeftNav" href="/admin/techniques">Techniques</a></li>';
   }    
   else {
     echo '<li><a href="/admin/techniques">Techniques</a></li>';
   }

   if ($content['MOD_NAME'] == 'admin/wholesaler-preauth') {
     echo '<li><a class="currentLeftNav" href="/admin/wholesaler-preauth">Wholesaler Preauth</a></li>';
   }    
   else {
     echo '<li><a href="/admin/wholesaler-preauth">Wholesaler Preauth</a></li>';
   }

   echo '<li style="border-top: 1px dotted #ccc; padding-top: 15px; margin-top: 15px;"><a href="/myaccount/orders">My Account</a></li>';

   if ($content['MOD_NAME'] == 'logout') {
     echo '<li><a class="currentLeftNav" href="/logout">Logout</a></li>';
   }  
   else {
     echo '<li><a href="/logout">Logout</a></li>';
   }

  echo '</ul></div></div>';

}

// MY ACCOUNT NAV
elseif ($content['TYPEID'] == 2) {

  echo '<div class="Lsidebar"><div class="nav"><ul>';

   if ($content['MOD_NAME'] == 'myaccount/orders') {
     echo '<li><a class="currentLeftNav" href="/myaccount/orders">Orders</a></li>';
   } 
   else {
     echo '<li><a href="/myaccount/orders">Orders</a></li>';
   }
   
   if ($content['MOD_NAME'] == 'myaccount/details') {
     echo '<li><a class="currentLeftNav" href="/myaccount/details">Account Details</a></li>';
   } 
   else {
     echo '<li><a href="/myaccount/details">Account Details</a></li>';
   }   

   if ($content['MOD_NAME'] == 'myaccount/shipping') {
     echo '<li><a class="currentLeftNav" href="/myaccount/shipping">Shipping Addresses</a></li>';
   } 
   else {
     echo '<li><a href="/myaccount/shipping">Shipping Addresses</a></li>';
   }  

   if ($content['MOD_NAME'] == 'myaccount/password') {
     echo '<li><a class="currentLeftNav" href="/myaccount/password">Change Password</a></li>';
   } 
   else {
     echo '<li><a href="/myaccount/password">Change Password</a></li>';
   }  

  // if ($account['TYPEID'] == 1 or 1==1) echo '<li><a href="/myaccount/wholesaler-app">WHOLESALER APP</a></li>';
  if ($account['TYPEID'] > 5 && $account['TYPEID'] < 9) {
    echo '<li><a href="/admin/orders">Administrative</a></li>';
  }

  echo <<<_ACCTITEMS_
  <li><a href="/logout">Logout</a></li>
</ul>
</div>
</div>
_ACCTITEMS_;

} 

// SHOP NAV
elseif ($content['MODULE_BODY'] == 'product-body.php' || $content['MOD_NAME'] == 'quick-order' ||
$content['MOD_NAME'] == 'placing-an-order' || $content['MOD_NAME'] == 'privacy-policy' || $content['MOD_NAME'] == 'terms-of-use' || $content['MOD_NAME'] == 'order-form' || $content['MOD_NAME'] == 'shop' || $content['MODULE_BODY'] == 'product-category-body.php') {

  $query = "SELECT * FROM categories ORDER BY TOP_ORDER";
  $result = mysql_query($query) or die ("error1" . mysql_error());

  echo '<div class="Lsidebar"><div class="nav"><ul class="productNav">';
  while ($row = mysql_fetch_array($result)) {
    
    $cleanedLabel = str_replace('&', '&amp;', $row['NAME']);

    // check to see if top level item needs to be highlighted
    $topQry = "SELECT * FROM brands WHERE ACTIVE='1' AND CATEGORYID='" . $row['ID'] . "' AND MOD_NAME='" . $content['MOD_NAME'] . "' ORDER BY NAME";
    $topRes = mysql_query($topQry) or die ("error1" . mysql_error());
    $topMatch = mysql_num_rows($topRes);
    
    // output top-level nav item
    if ($content['MOD_NAME'] == $row['MOD_NAME'] || $topMatch == 1) {
    
      echo '<li><a class="currentLeftNav" href="/' . stripslashes($row['MOD_NAME']) . '">' . stripslashes($cleanedLabel).'</a>';
    
    }
    
    else {

      echo '<li><a href="/' . stripslashes($row['MOD_NAME']) . '">' . stripslashes($cleanedLabel).'</a>';    
    
    }
    
    // need to determine if children should be shown (if in that local navbar)
    $qry = "SELECT * FROM brands WHERE ACTIVE='1' AND CATEGORYID='" . $row['ID'] . "' AND MOD_NAME='" . $content['MOD_NAME'] . "'";
    $res = mysql_query($qry) or die(mysql_error());
    if (mysql_num_rows($res) > 0 || $content['MOD_NAME'] == $row['MOD_NAME']) {
    
      // output children
      $query2 = "SELECT * FROM brands WHERE ACTIVE='1' AND CATEGORYID='".$row['ID']."' ORDER BY NAME";
      $result2 = mysql_query($query2) or die ("error1" . mysql_error());
    
      if (mysql_num_rows($result2) > 0) {
    
        echo '<ul>';
      
        while ($row2 = mysql_fetch_array($result2)) {

          if ($content['MOD_NAME'] == $row2['MOD_NAME']) {

            echo '<li><a class="currentLeftNav" href="/' . $row2['MOD_NAME'] . '">' . stripslashes($row2['NAME']) . '</a></li>';

          }
          
          else {

            echo '<li><a href="/' . $row2['MOD_NAME'] . '">' . stripslashes($row2['NAME']) . '</a></li>';
          
          }
         
         }
       
         echo '</ul>';

       }
     
     }
     
     echo '</li>';
    
   }
   
   echo '</ul><br /><ul class="productNav">';

   if ($content['MOD_NAME'] == 'quick-order') {
     echo '<li><a class="currentLeftNav" href="/quick-order">Quick Order</a></li>';
   }
   else {
     echo '<li><a class="darkerNav" href="/quick-order">Quick Order</a></li>';
   }

   if ($content['MOD_NAME'] == 'placing-an-order') {
     echo '<li><a class="currentLeftNav" href="/placing-an-order">Placing an Order</a></li>';
   }
   else {
     echo '<li><a href="/placing-an-order">Placing an Order</a></li>';
   }
   
   if ($content['MOD_NAME'] == 'privacy-policy') {
     echo '<li><a class="currentLeftNav" href="/privacy-policy">Privacy Policy</a></li>';
   }
   else {
     echo '<li><a href="/privacy-policy">Privacy Policy</a></li>';
   }   

   if ($content['MOD_NAME'] == 'terms-of-use') {
     echo '<li><a class="currentLeftNav" href="/terms-of-use">Terms of Use</a></li>';
   }
   else {
     echo '<li><a href="/terms-of-use">Terms of Use</a></li>';
   }  
     
   echo '</ul></div></div>';
   
}

// COMMUNITY NAV
elseif ($content['MODULE_BODY'] == 'community-body.php' || $content['MODULE_BODY'] == 'artist-details-body.php' || $content['MOD_NAME'] == 'about-us' || $content['MOD_NAME'] == 'contact-us' || $content['MODULE_BODY'] == 'staff-body.php') {

  echo '<div class="Lsidebar"><div class="nav"><ul class="productNav">';
  
  if ($content['MODULE_BODY'] == 'artist-details-body.php') {

    echo '<li><a class="currentLeftNav" href="/community#airHdr">Artists in Residence</a>';

    $query = "SELECT * FROM artists JOIN content ON artists.CONTENT_ID=content.ID WHERE artists.ACTIVE=1 ORDER BY artists.LAST_NAME ASC, artists.FIRST_NAME ASC";
    $result = mysql_query($query) or die ("error1" . mysql_error());
    
    echo '<ul class="artistsSub">';
    while ($data = mysql_fetch_assoc($result)) {
    
      echo '<li><a href="/', $data['MOD_NAME'], '"';
      if ($content['ID'] == $data['CONTENT_ID']) { echo ' class="currentLeftNav"'; }
      echo '>', $data['COMPLETE_NAME'], '</a></li>';  
    
    }
    echo '</ul>';

  }
  
  else {
  
    echo '<li><a href="/community#airHdr">Artists in Residence</a>';
  
  }
      
  echo '</li>',
       '<li><a href="http://imaginecraftsblog.com">IMAGINE Crafts Blog</a></li>',       
       '<li><a href="/community#stayConnectedHdr">Stay Connected</a></li>';

  if ($content['MOD_NAME'] == 'about-us' || $content['MOD_NAME'] == 'meet-our-staff') {
    echo '<li><a class="currentLeftNav" href="/about-us">About Us</a>';
  }
  else {
    echo '<li><a href="/about-us">About Us</a>';
  }  

  if ($content['MOD_NAME'] == 'meet-our-staff') {  
  
    echo '<ul class="staffSub"><li><a class="currentLeftNav" href="/meet-our-staff">Meet Our Staff</a></li></ul>';
  
  }
  
  elseif ($content['MOD_NAME'] == 'about-us') {
  
    echo '<ul class="staffSub"><li><a href="/meet-our-staff">Meet Our Staff</a></li></ul>';    
  
  }
  
  echo '</li>';

  if ($content['MOD_NAME'] == 'contact-us') {
    echo '<li><a class="currentLeftNav" href="/contact-us">Contact Us</a></li>';
  }
  else {
    echo '<li><a href="/contact-us">Contact Us</a></li>';
  }  

  echo '</ul></div></div>';

}

// LEARN NAV
elseif ($content['MODULE_BODY'] == 'learn-overview-body.php' || $content['MODULE_BODY'] == 'learn-info-body.php') {

  if ($content['MODULE_BODY'] == 'learn-info-body.php') {
    
    // pull the page info
    $qry = "SELECT * FROM learn WHERE CONTENT_ID=" . $content['ID'];
    $res = mysql_query($qry) or die(mysql_error());
    $pageInfo = mysql_fetch_assoc($res); 

    // pull the brand info
    $qry = "SELECT * FROM brands WHERE ID=" . $pageInfo['BRAND_ID'];
    $res = mysql_query($qry) or die(mysql_error());
    $brandInfo = mysql_fetch_assoc($res); 
  
  }

  echo '<div class="Lsidebar"><div class="nav"><ul class="productNav">';
  
  if ($content['MOD_NAME'] == 'learn-fabric-overview' || (!empty($brandInfo) && $brandInfo['CATEGORYID'] == 1)) {
  
    echo '<li><a class="currentLeftNav" href="/learn-fabric-overview">Fabric</a>';
  
  }
  
  else {
  
    echo '<li><a href="/learn-fabric-overview">Fabric</a>';
  
  }

  if ($content['MOD_NAME'] == 'learn-fabric-overview' || (!empty($brandInfo) && $brandInfo['CATEGORYID'] == 1)) {

    $qry = "SELECT brands.* FROM brands JOIN learn ON learn.BRAND_ID=brands.ID WHERE brands.ACTIVE=1 AND learn.ACTIVE=1 AND brands.CATEGORYID=1 ORDER BY NAME";
    $res = mysql_query($qry) or die ("error1" . mysql_error());

    echo '<ul>';

    while ($row = mysql_fetch_array($res)) {
        
      $cleanedLabel = str_replace('&', '&amp;', $row['NAME']);
    
      if (!empty($brandInfo) && $brandInfo['MOD_NAME'] == $row['MOD_NAME']) {
    
        echo '<li><a class="currentLeftNav" href="/learn-' . stripslashes($row['MOD_NAME']) . '">' . stripslashes($cleanedLabel).'</a>';
    
      }
    
      else {

        echo '<li><a href="/learn-' . stripslashes($row['MOD_NAME']) . '">' . stripslashes($cleanedLabel).'</a>';    
    
      }
    
    }
  
    echo '</ul>';
  
  }
  
  echo '</li>';
  
  if ($content['MOD_NAME'] == 'learn-paper-overview' || (!empty($brandInfo) && $brandInfo['CATEGORYID'] == 15)) {
  
    echo '<li><a class="currentLeftNav" href="/learn-paper-overview">Paper</a>';
  
  }
  
  else {
  
    echo '<li><a href="/learn-paper-overview">Paper</a>';
  
  }

  if ($content['MOD_NAME'] == 'learn-paper-overview' || (!empty($brandInfo) && $brandInfo['CATEGORYID'] == 15)) {

    $qry = "SELECT brands.* FROM brands JOIN learn ON learn.BRAND_ID=brands.ID WHERE brands.ACTIVE=1 AND learn.ACTIVE=1 AND brands.CATEGORYID=15 ORDER BY NAME";
    $res = mysql_query($qry) or die ("error1" . mysql_error());

    echo '<ul>';

    while ($row = mysql_fetch_array($res)) {
        
      $cleanedLabel = str_replace('&', '&amp;', $row['NAME']);
   
      if (!empty($brandInfo) && $brandInfo['MOD_NAME'] == $row['MOD_NAME']) {
    
        echo '<li><a class="currentLeftNav" href="/learn-' . stripslashes($row['MOD_NAME']) . '">' . stripslashes($cleanedLabel).'</a>';
    
      }
    
      else {

        echo '<li><a href="/learn-' . stripslashes($row['MOD_NAME']) . '">' . stripslashes($cleanedLabel).'</a>';    
    
      }
    
    }
  
    echo '</ul>';

  }
  
  echo '</li>';  

  if ($content['MOD_NAME'] == 'learn-mixed-media-overview' || (!empty($brandInfo) && $brandInfo['CATEGORYID'] == 16)) {
  
    echo '<li><a class="currentLeftNav" href="/learn-mixed-media-overview">Mixed Media</a>';
  
  }
  
  else {
  
    echo '<li><a href="/learn-mixed-media-overview">Mixed Media</a>';
  
  }

  if ($content['MOD_NAME'] == 'learn-mixed-media-overview' || (!empty($brandInfo) && $brandInfo['CATEGORYID'] == 16)) {

    $qry = "SELECT brands.* FROM brands JOIN learn ON learn.BRAND_ID=brands.ID WHERE brands.ACTIVE=1 AND learn.ACTIVE=1 AND brands.CATEGORYID=16 ORDER BY NAME";
    $res = mysql_query($qry) or die ("error1" . mysql_error());

    echo '<ul>';

    while ($row = mysql_fetch_array($res)) {
        
      $cleanedLabel = str_replace('&', '&amp;', $row['NAME']);
    
      if (!empty($brandInfo) && $brandInfo['MOD_NAME'] == $row['MOD_NAME']) {
    
        echo '<li><a class="currentLeftNav" href="/learn-' . stripslashes($row['MOD_NAME']) . '">' . stripslashes($cleanedLabel).'</a>';
    
      }
    
      else {

        echo '<li><a href="/learn-' . stripslashes($row['MOD_NAME']) . '">' . stripslashes($cleanedLabel).'</a>';    
    
      }
    
    }
  
    echo '</ul>';
  
  }
  
  echo '</li>';

  if ($content['MOD_NAME'] == 'learn-tools-overview' || (!empty($brandInfo) && $brandInfo['CATEGORYID'] == 14)) {
  
    echo '<li><a class="currentLeftNav" href="/learn-tools-overview">Brushes &amp; Tools</a>';
  
  }
  
  else {
  
    echo '<li><a href="/learn-tools-overview">Brushes &amp; Tools</a>';
  
  }

  if ($content['MOD_NAME'] == 'learn-tools-overview' || (!empty($brandInfo) && $brandInfo['CATEGORYID'] == 14)) {
  
    $qry = "SELECT brands.* FROM brands JOIN learn ON learn.BRAND_ID=brands.ID WHERE brands.ACTIVE=1 AND learn.ACTIVE=1 AND brands.CATEGORYID=14 ORDER BY NAME";
    $res = mysql_query($qry) or die ("error1" . mysql_error());

    echo '<ul>';

    while ($row = mysql_fetch_array($res)) {
        
      $cleanedLabel = str_replace('&', '&amp;', $row['NAME']);
    
      if (!empty($brandInfo) && $brandInfo['MOD_NAME'] == $row['MOD_NAME']) {
    
        echo '<li><a class="currentLeftNav" href="/learn-' . stripslashes($row['MOD_NAME']) . '">' . stripslashes($cleanedLabel).'</a>';
    
      }
    
      else {

        echo '<li><a href="/learn-' . stripslashes($row['MOD_NAME']) . '">' . stripslashes($cleanedLabel).'</a>';    
    
      }
    
    }
  
    echo '</ul>';
  
  }
  
  echo '</li>';
   
  echo '</ul></div></div>';
   
}

else {

  $hasSidebar = false;

}

?>