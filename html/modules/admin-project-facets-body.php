<?php

function brandList() {

  $qry = "SELECT * FROM brands WHERE ACTIVE=1 ORDER BY NAME ASC";
  $res = mysql_query($qry) or die(mysql_error());
  
  while ($data = mysql_fetch_assoc($res)) {

    echo '<option value="', $data['ID'], '">', $data['NAME'], '</option>';  
  
  }
  
}

if (($qa[0] == "medium" || $qa[0] == "aesthetic" || $qa[0] == "season" || $qa[0] == "type" || $qa[0] == "brand") && $qa[1] != "") {

  $cleanType = mysql_real_escape_string($qa[0]);
  $cleanID = mysql_real_escape_string($qa[1]);
  $formToUse = 2;

  switch ($cleanType) {
  
    case 'medium' :
    
      $qry = "SELECT * FROM medium WHERE MEDIUM_ID=" . $cleanID;
      $res = mysql_query($qry) or die(mysql_error());
      $data = mysql_fetch_assoc($res);
      $editName = stripslashes($data['MEDIUM_TITLE']);
      $displayOrder = stripslashes($data['DISPLAY_ORDER']);
      $facetName = 'Medium';
      $path = 'update-medium';
      $formToUse = 1;
      break;
  
    case 'aesthetic' :
    
      $qry = "SELECT * FROM aesthetic WHERE AESTHETIC_ID=" . $cleanID;
      $res = mysql_query($qry) or die(mysql_error());
      $data = mysql_fetch_assoc($res);
      $editName = stripslashes($data['AESTHETIC_TITLE']);
      $displayOrder = stripslashes($data['DISPLAY_ORDER']);
      $facetName = 'Aesthetic';
      $path = 'update-aesthetic';
      $formToUse = 1;
      break;

    case 'season' :
    
      $qry = "SELECT * FROM season WHERE SEASON_ID=" . $cleanID;
      $res = mysql_query($qry) or die(mysql_error());
      $data = mysql_fetch_assoc($res);
      $editName = stripslashes($data['SEASON_TITLE']);
      $displayOrder = stripslashes($data['DISPLAY_ORDER']);
      $facetName = 'Season';
      $path = 'update-season';
      $formToUse = 1;
      break;

    case 'type' :
    
      $qry = "SELECT * FROM project_type WHERE TYPE_ID=" . $cleanID;
      $res = mysql_query($qry) or die(mysql_error());
      $data = mysql_fetch_assoc($res);
      $editName = stripslashes($data['TYPE_TITLE']);
      $displayOrder = stripslashes($data['DISPLAY_ORDER']);
      $facetName = 'Project Type';
      $path = 'update-type';
      $formToUse = 1;
      break;

    case 'brand' :
    
      $qry = "SELECT * FROM project_brand JOIN brands ON project_brand.BRAND_ID=brands.ID WHERE project_brand.PROJECT_BRAND_ID=" . $cleanID;
      $res = mysql_query($qry) or die(mysql_error());
      $data = mysql_fetch_assoc($res);
      $displayOrder = stripslashes($data['DISPLAY_ORDER']);
      $brandName = stripslashes($data['NAME']);
      $formToUse = 2;
      break;
  
  }

  if ($formToUse == 1) {

  echo <<<_FORMINFO_
<h2>Modify {$facetName} Facet</h2>
<form action="/{$content['MOD_NAME']}/{$path}/{$qa[1]}" method="post" class="myForm">
<p><label>{$facetName} Name: <input type="text" name="TITLE" value="{$editName}" /></label></p>
<p><label>Display Order: (items sort from lower numbers to higher numbers) <input type="text" name="ORDER" value="{$displayOrder}" /></label></p>
<p class="buttonheight"><input type="submit" name="BUTTON" value="Update {$facetName}" style="width:auto"  /></p>
</form>
_FORMINFO_;

  }
  
  else {
  
  echo <<<_FORMINFO_
<h2>Modify Brand Facet</h2>
<form action="/{$content['MOD_NAME']}/update-brand/{$qa[1]}" method="post" class="myForm">
<p>Brand: {$brandName}</p>
<p><label>Display Order: (items sort from lower numbers to higher numbers) <input type="text" name="ORDER" value="{$displayOrder}" /></label></p>
<p class="buttonheight"><input type="submit" name="BUTTON" value="Update Brand" style="width:auto"  /></p>
</form>
_FORMINFO_;

  }
  
} else { ?>

<h1>Project Facets</h1>

<fieldset>
<legend>Mediums</legend>
<form action="/<?php echo $content['MOD_NAME']; ?>" method="post" class="myForm">
<p>Medium Name: <input style="display:inline" type="text" name="TITLE" /> <span class="buttonheight"><input type="submit" name="BUTTON" value="Add Medium" /></span></p>
</form>
<ul class="projList">
<?php

  $qry = "SELECT * FROM medium WHERE ACTIVE=1 ORDER BY DISPLAY_ORDER ASC";
  $res = mysql_query($qry) or die(mysql_error());
  
  while($row = mysql_fetch_array($res)) {
    echo '<li><a href="/', $content['MOD_NAME'], '/medium/', $row['MEDIUM_ID'], '">', $row['MEDIUM_TITLE'], '</a>';
    echo ' &nbsp; [<a title="Delete" href="/', $content['MOD_NAME'], '/delete-medium/', $row['MEDIUM_ID'], '" onclick="return confirmDelete(this);"> x </a>]';
    echo '</li>';
  }
  
?>
</ul>
</fieldset>

<br />

<fieldset>
<legend>Aesthetics</legend>
<form action="/<?php echo $content['MOD_NAME']; ?>" method="post" class="myForm">
<p>Aesthetic Name: <input style="display:inline" type="text" name="TITLE" /> <span class="buttonheight"><input type="submit" name="BUTTON" value="Add Aesthetic" /></span></p>
</form>
<ul class="projList">
<?php

  $qry = "SELECT * FROM aesthetic WHERE ACTIVE=1 ORDER BY DISPLAY_ORDER ASC";
  $res = mysql_query($qry) or die(mysql_error());
  
  while($row = mysql_fetch_array($res)) {
    echo '<li><a href="/', $content['MOD_NAME'], '/aesthetic/', $row['AESTHETIC_ID'], '">', $row['AESTHETIC_TITLE'], '</a>';
    echo ' &nbsp; [<a title="Delete" href="/', $content['MOD_NAME'], '/delete-aesthetic/', $row['AESTHETIC_ID'], '" onclick="return confirmDelete(this);"> x </a>]';
    echo '</li>';
  }
  
?>
</ul>
</fieldset>

<br />

<fieldset>
<legend>Brands</legend>
<form action="/<?php echo $content['MOD_NAME']; ?>" method="post" class="myForm">
<p>Brand: <select style="display:inline" name="BRAND_ID"><?php brandList(); ?></select> <span class="buttonheight"><input type="submit" name="BUTTON" value="Add Brand" /></span></p>
</form>
<ul class="projList">
<?php

  $qry = "SELECT * FROM project_brand JOIN brands ON project_brand.BRAND_ID=brands.ID WHERE project_brand.ACTIVE=1 AND brands.ACTIVE=1 ORDER BY project_brand.DISPLAY_ORDER ASC";
  $res = mysql_query($qry) or die(mysql_error());
  
  while($row = mysql_fetch_array($res)) {
    echo '<li><a href="/', $content['MOD_NAME'], '/brand/', $row['PROJECT_BRAND_ID'], '">', $row['NAME'], '</a>';
    echo ' &nbsp; [<a title="Delete" href="/', $content['MOD_NAME'], '/delete-brand/', $row['PROJECT_BRAND_ID'], '" onclick="return confirmDelete(this);"> x </a>]';
    echo '</li>';
  }
  
?>
</ul>
</fieldset>

<br />

<fieldset>
<legend>Seasons / Occasions</legend>
<form action="/<?php echo $content['MOD_NAME']; ?>" method="post" class="myForm">
<p>Season / Occasion Name: <input style="display:inline" type="text" name="TITLE" /> <span class="buttonheight"><input type="submit" name="BUTTON" value="Add Season / Occasion" style="width:200px;" /></span></p>
</form>
<ul class="projList">
<?php

  $qry = "SELECT * FROM season WHERE ACTIVE=1 ORDER BY DISPLAY_ORDER ASC";
  $res = mysql_query($qry) or die(mysql_error());
  
  while($row = mysql_fetch_array($res)) {
    echo '<li><a href="/', $content['MOD_NAME'], '/season/', $row['SEASON_ID'], '">', $row['SEASON_TITLE'], '</a>';
    echo ' &nbsp; [<a title="Delete" href="/', $content['MOD_NAME'], '/delete-season/', $row['SEASON_ID'], '" onclick="return confirmDelete(this);"> x </a>]';
    echo '</li>';
  }
  
?>
</ul>
</fieldset>

<br />

<fieldset>
<legend>Project Type</legend>
<form action="/<?php echo $content['MOD_NAME']; ?>" method="post" class="myForm">
<p>Project Type Name: <input style="display:inline" type="text" name="TITLE" /> <span class="buttonheight"><input type="submit" name="BUTTON" value="Add Project Type" /></span></p>
</form>
<ul class="projList">
<?php

  $qry = "SELECT * FROM project_type WHERE ACTIVE=1 ORDER BY DISPLAY_ORDER ASC";
  $res = mysql_query($qry) or die(mysql_error());
  
  while($row = mysql_fetch_array($res)) {
    echo '<li><a href="/', $content['MOD_NAME'], '/type/', $row['TYPE_ID'], '">', $row['TYPE_TITLE'], '</a>';
    echo ' &nbsp; [<a title="Delete" href="/', $content['MOD_NAME'], '/delete-type/', $row['TYPE_ID'], '" onclick="return confirmDelete(this);"> x </a>]';
    echo '</li>';
  }
  
?>
</ul>
</fieldset>

<?php } ?>