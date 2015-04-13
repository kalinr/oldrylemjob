<?php
    
  // pull data for all landing pages
  $qry = "SELECT * FROM landing_pages WHERE LANDING_PAGE_ID=1";
  $res = mysql_query($qry) or die(mysql_error());
  $lpData = mysql_fetch_assoc($res);
  
?>


<!-- Home -->
<h1>Landing Pages</h1>
<form action="/<? echo $content['MOD_NAME']; ?>" method="post" id="myform" enctype="multipart/form-data">
<fieldset>
  <legend>Home Page</legend>
  <?php
  
  if (!empty($lpData['HOME_IMG']) && file_exists('images/home/' . $lpData['HOME_IMG'])) {
    
    echo '<img src="/images/home/' . $lpData['HOME_IMG'] . '" style="max-width:650px; height: auto;" alt="Home Page Banner Image" />';
    
  }  
  
  ?>
  <p>Upload home page photo (width is 1280 pixels):<br /><input type="file" name="FILE" /></p>
  <p>Featured brand: <select name="BRAND">
  <?php
  
    $qry = "SELECT NAME,ID FROM brands WHERE ACTIVE='1' ORDER BY NAME ASC";
    $res = mysql_query($qry) or die(mysql_error());
    
    while ($data = mysql_fetch_assoc($res)) {
    
      echo '<option value="', $data['ID'], '"';
      if ($data['ID'] == $lpData['FEATURED_BRAND_ID']) { echo ' selected="selected"'; } 
      echo '>', $data['NAME'], '</option>';
    
    }
  
  ?>
  </select></p>
  <p>Featured artist: <select name="ARTIST">
  <?php
  
    $qry = "SELECT COMPLETE_NAME,ARTIST_ID FROM artists WHERE ACTIVE='1' ORDER BY LAST_NAME ASC, FIRST_NAME ASC";
    $res = mysql_query($qry) or die(mysql_error());
    
    while ($data = mysql_fetch_assoc($res)) {
    
      echo '<option value="', $data['ARTIST_ID'], '"';
      if ($data['ARTIST_ID'] == $lpData['FEATURED_ARTIST_ID']) { echo ' selected="selected"'; } 
      echo '>', $data['COMPLETE_NAME'], '</option>';
    
    }
  
  ?>
  </select></p>  
  <p><input style="width:auto" type="submit" name="BUTTON" value="Save Home Page Changes" />
  <input type="hidden" name="MAX_FILE_SIZE" value="10000000" /></p>
</fieldset>
</form>

<br />

<!-- Learn -->
<form action="/<? echo $content['MOD_NAME']; ?>" method="post" id="myform" enctype="multipart/form-data">
<fieldset>
  <legend>Learn Page</legend>
  <?php
        
    if (!empty($lpData['LEARN_IMG']) && file_exists('images/learn/' . $lpData['LEARN_IMG'])) {
    
      echo '<img src="/images/learn/' . $lpData['LEARN_IMG'] . '" style="max-width:650px; height: auto;" alt="Learn Page Banner Image" />';
    
    }
  
  ?>
  <p>Upload learn page photo (width is 1040 pixels):<br /><input type="file" name="FILE" /></p>
  <p>Featured fabric brand: <select name="FABRIC">
  <?php

    $qry = "SELECT brands.NAME, brands.ID FROM brands JOIN learn ON brands.ID=learn.BRAND_ID WHERE brands.CATEGORYID=1 AND brands.ACTIVE=1 AND learn.ACTIVE=1 ORDER BY brands.NAME ASC";
    $res = mysql_query($qry) or die(mysql_error());
    
    while ($data = mysql_fetch_assoc($res)) {
    
      echo '<option value="', $data['ID'], '"';
      if ($data['ID'] == $lpData['FEATURED_LEARN_FABRIC']) { echo ' selected="selected"'; } 
      echo '>', $data['NAME'], '</option>';
    
    }
  
  ?>
  </select></p>
  <p>Featured paper brand: <select name="PAPER">
  <?php

    $qry = "SELECT brands.NAME, brands.ID FROM brands JOIN learn ON brands.ID=learn.BRAND_ID WHERE brands.CATEGORYID=15 AND brands.ACTIVE=1 AND learn.ACTIVE=1 ORDER BY brands.NAME ASC";
    $res = mysql_query($qry) or die(mysql_error());
    
    while ($data = mysql_fetch_assoc($res)) {
    
      echo '<option value="', $data['ID'], '"';
      if ($data['ID'] == $lpData['FEATURED_LEARN_PAPER']) { echo ' selected="selected"'; } 
      echo '>', $data['NAME'], '</option>';
    
    }
  
  ?>
  </select></p>
  <p>Featured mixed media brand: <select name="MEDIA">
  <?php

    $qry = "SELECT brands.NAME, brands.ID FROM brands JOIN learn ON brands.ID=learn.BRAND_ID WHERE brands.CATEGORYID=16 AND brands.ACTIVE=1 AND learn.ACTIVE=1 ORDER BY brands.NAME ASC";
    $res = mysql_query($qry) or die(mysql_error());
    
    while ($data = mysql_fetch_assoc($res)) {
    
      echo '<option value="', $data['ID'], '"';
      if ($data['ID'] == $lpData['FEATURED_LEARN_MIXEDMEDIA']) { echo ' selected="selected"'; } 
      echo '>', $data['NAME'], '</option>';
    
    }
  
  ?>
  </select></p>
  <p>Featured brushes &amp; tools brand: <select name="TOOL">
  <?php
  
    $qry = "SELECT brands.NAME, brands.ID FROM brands JOIN learn ON brands.ID=learn.BRAND_ID WHERE brands.CATEGORYID=14 AND brands.ACTIVE=1 AND learn.ACTIVE=1 ORDER BY brands.NAME ASC";
    $res = mysql_query($qry) or die(mysql_error());
    
    while ($data = mysql_fetch_assoc($res)) {
    
      echo '<option value="', $data['ID'], '"';
      if ($data['ID'] == $lpData['FEATURED_LEARN_TOOL']) { echo ' selected="selected"'; } 
      echo '>', $data['NAME'], '</option>';
    
    }
  
  ?>
  </select></p>
  <p><input style="width:auto" type="submit" name="BUTTON" value="Save Learn Page Changes" />
  <input type="hidden" name="MAX_FILE_SIZE" value="10000000" /></p>
</fieldset>
</form>