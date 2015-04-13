<?php

function showFacets($facetType) {

  global $info;

  // pull all of type
  switch ($facetType) {
  
    case '1' :
    
      $qry = "SELECT * FROM medium WHERE ACTIVE=1 ORDER BY DISPLAY_ORDER ASC";
      $varName = 'medium[]';
      $primaryKey = 'MEDIUM_ID';
      $theTitle = 'MEDIUM_TITLE';
      break;
      
    case '2' :
     
      $qry = "SELECT * FROM project_brand JOIN brands ON project_brand.BRAND_ID=brands.ID WHERE project_brand.ACTIVE=1 ORDER BY project_brand.DISPLAY_ORDER ASC";
      $varName = 'brand[]';
      $primaryKey = 'PROJECT_BRAND_ID';
      $theTitle = 'NAME';
      break;
  
    case '3' :
     
      $qry = "SELECT * FROM aesthetic WHERE ACTIVE=1 ORDER BY DISPLAY_ORDER ASC";
      $varName = 'aesthetic[]';
      $primaryKey = 'AESTHETIC_ID';
      $theTitle = 'AESTHETIC_TITLE';
      break;

    case '4' :
     
      $qry = "SELECT * FROM season WHERE ACTIVE=1 ORDER BY DISPLAY_ORDER ASC";
      $varName = 'season[]';
      $primaryKey = 'SEASON_ID';
      $theTitle = 'SEASON_TITLE';
      break;

    case '5' :
     
      $qry = "SELECT * FROM project_type WHERE ACTIVE=1 ORDER BY DISPLAY_ORDER ASC";
      $varName = 'type[]';
      $primaryKey = 'TYPE_ID';
      $theTitle = 'TYPE_TITLE';
      break;
  
  }
  
  $res = mysql_query($qry) or die(mysql_error());
  $facetArr = array();
  while ($data = mysql_fetch_assoc($res)) {
    $facetArr[]= $data;
  }

  // pull currently selected
  $matchingFacets = array();
  if (isset($info) & !empty($info)) {        
    $qry = "SELECT FACET_ID FROM project_facet WHERE FACET_TYPE=" . $facetType . " AND PROJECT_ID=" . $info['PROJECT_ID'];
    $res = mysql_query($qry) or die(mysql_error());  
    while ($data = mysql_fetch_assoc($res)) {
      $matchingFacets[]= $data['FACET_ID'];
    }  
  }
  
  // output the checkboxes
  $allFacets = count($facetArr);
  echo '<ul class="facetCols">';
  for ($i=0; $i<$allFacets; $i++) {
    echo '<li><label><input type="checkbox" name="', $varName, '" value="', $facetArr[$i][$primaryKey], '"';
    if (in_array($facetArr[$i][$primaryKey], $matchingFacets)) { echo ' checked="checked"'; }
    echo ' /> ', $facetArr[$i][$theTitle], '</label></li>';
  }
  echo '</ul>';

}

if ($qa[0] != "") {

  include_once("js/ckeditor/ckeditor.php");
  include_once('js/ckfinder/ckfinder.php');

  $CKEditor = new CKEditor();
  $CKEditor->basePath = '/js/ckeditor/';
  CKFinder::SetupCKEditor($CKEditor, '/js/ckfinder/');

  if ($qa[0] == 0) {

    echo '<h2>Create Project</h2>';
    
  }

  else {

    echo '<h2>Update Project</h2>';
  
  }

?>

<form action="/<?php echo $content['MOD_NAME']; ?>/<?php echo $qa[0]; ?>" method="post" id="myform" enctype="multipart/form-data">
<p>Project Name: <input style="width:600px" type="text" name="PROJECT_TITLE" value="<?php echo stripslashes($projectTitle); ?>" /></p>
<p>Artist Name: <input style="width:600px" type="text" name="PROJECT_ARTIST" value="<?php echo stripslashes($projectArtist); ?>" /></p>
<p>Project Summary: <?php $CKEditor->editor("PROJECT_SUMMARY", $projectSummary); ?></p>
<?php

  $pathToImg = 'images/projects/' . $projectID . '/' . $projectPhoto;
  if (!empty($projectPhoto) && file_exists($pathToImg)) {  
    echo '<p>Primary Project Photo (shown in project listings and on detail page; max width 700 pixels):<br /> <img src="/', $pathToImg, '" style="max-width:760px;" alt="Photo of project" /><br />';
    echo '<a href="/admin/projects/', $qa[0], '/remove-photo">Delete Photo</a></p>';
  }

?>
<p>Upload Primary Project Photo: <input type="file" name="PROJECT_PHOTO" size="30" /></p>
<p>Project Video (max width is 730 pixels; takes the place of primary photo on detail page): <textarea style="width:600px" rows="6" cols="60" name="PROJECT_VIDEO"><?php echo stripslashes($projectVideo); ?></textarea></p>
<p>Project Content: <?php $CKEditor->editor("PROJECT_TEXT", $projectText); ?></p>
<p>Project Difficulty: <input style="width:600px" type="text" name="PROJECT_DIFFICULTY" value="<?php echo stripslashes($projectDifficulty); ?>" /></p>
<p>Project Time Required: <input style="width:600px" type="text" name="PROJECT_TIME" value="<?php echo stripslashes($projectTime); ?>" /></p>
<p>Project Materials Needed: <?php $CKEditor->editor("PROJECT_MATERIALS", $projectMaterials); ?></p>
<p>Project Keywords: <textarea style="width:600px" rows="6" cols="60" name="PROJECT_KEYWORDS"><?php echo stripslashes($projectKeywords); ?></textarea></p>

<fieldset>
<legend>Mediums</legend>
<?php showFacets(1); ?>
</fieldset>

<br />

<fieldset>
<legend>Aesthetics</legend>
<?php showFacets(3); ?>
</fieldset>

<br />

<fieldset>
<legend>Brands</legend>
<?php showFacets(2); ?>
</fieldset>

<br />

<fieldset>
<legend>Seasons/Occasions</legend>
<?php showFacets(4); ?>
</fieldset>

<br />

<fieldset>
<legend>Project Types</legend>
<?php showFacets(5); ?>
</fieldset>

<div class="buttonheight"><input type="submit" name="BUTTON" value="Save" /> 
<?php

  if ($qa[0] > 0) {
  
    echo ' <input type="button" onclick="javascript:confirmDelete()" value="Delete" />';
  
  }

?>
</div></div>
</form>
 
<?php } else { ?>

<h1>Projects</h1>
<p><a href="/admin/projects/0">Create Project</a></p>

<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:100%">
<thead>
<tr>
  <th scope="col">Name</th>
  <th scope="col">Created</th>  
</tr>
</thead>
<tbody>
<?php

  $qry = "SELECT * FROM project WHERE ACTIVE=1 ORDER BY PROJECT_TITLE ASC";
  $res = mysql_query($qry) or die(mysql_error());
  $path = '/admin/projects/';
  
  while($row = mysql_fetch_array($res)) {
  
    $formattedDateTime = date('M d, Y g:i A', $row['PROJECT_CREATED']);
  
    if (!empty($row['PROJECT_TITLE'])) {
  
      echo <<<_DTBL_
    <tr>
      <td><a href="{$path}{$row['PROJECT_ID']}">{$row['PROJECT_TITLE']}</a></td>
      <td>{$formattedDateTime}</td>
    </tr>
_DTBL_;

    }
    
    else {
    
      echo <<<_DTBL_
    <tr>
      <td><a href="{$path}{$row['PROJECT_ID']}">Untitled Project</a></td>
      <td>{$formattedDateTime}</td>
    </tr>
_DTBL_;
    
    }

  }
  
?>
</tbody>
</table>
<div class="clr"></div>
<p><a href="/admin/projects/0">Create Project</a></p>
<?php } ?>