<?php

if ($qa[0] != "") {

  include_once("js/ckeditor/ckeditor.php");
  include_once('js/ckfinder/ckfinder.php');

  $CKEditor = new CKEditor();
  $CKEditor->basePath = '/js/ckeditor/';
  CKFinder::SetupCKEditor($CKEditor, '/js/ckfinder/');

  if ($qa[0] == 0) {

    echo '<h2>Create Artist</h2>';
    
  }

  else {

    echo '<h2>Update Artist</h2>';
  
  }

?>

<form action="/<?php echo $content['MOD_NAME']; ?>/<?php echo $qa[0]; ?>" method="post" id="myform" enctype="multipart/form-data">
<p><em>Please limit project and artist photos to 245 pixels wide.</em></p>
<p>First Name: <input type="text" name="FIRST_NAME" value="<?php echo stripslashes($firstName); ?>" /></p>
<p>Last Name: <input type="text" name="LAST_NAME" value="<?php echo stripslashes($lastName); ?>" /></p>
<p><? $CKEditor->editor("DETAILS", $details); ?></p>

<?php
  $pathToImg = 'images/artists/' . $artistID . '/' . $artistPhoto;
  if (!empty($artistPhoto) && file_exists($pathToImg)) {
  
    echo '<p>Photo: <img src="/', $pathToImg, '" style="vertical-align: top; max-width: 245px;" alt="Photo of ', $firstName, ' ', $lastName, '" /></p>';
  
  }
?>
<p>Upload Artist Photo: <input type="file" name="ARTIST_PHOTO" size="30" /></p>


<?php
  $pathToImg = 'images/artists/' . $artistID . '/project1/' . $project1Photo;
  if (!empty($project1Photo) && file_exists($pathToImg)) {
  
    echo '<p>Project 1 Photo: <img src="/', $pathToImg, '" style="vertical-align: top; max-width: 245px;" alt="Project 1 Photo" />',
         ' &nbsp; <a href="/', $content['MOD_NAME'], '/', $qa[0], '/remove-project1">Remove Photo</a></p>';
  
  }
?>
<p>Upload Project 1 Photo: <input type="file" name="PROJECT1_PHOTO" size="30" /></p>


<?php
  $pathToImg = 'images/artists/' . $artistID . '/project2/' . $project2Photo;
  if (!empty($project2Photo) && file_exists($pathToImg)) {
  
    echo '<p>Project 2 Photo: <img src="/', $pathToImg, '" style="vertical-align: top; max-width: 245px;" alt="Project 2 Photo" />',
         ' &nbsp; <a href="/', $content['MOD_NAME'], '/', $qa[0], '/remove-project2">Remove Photo</a></p>';
  
  }
?>
<p>Upload Project 2 Photo: <input type="file" name="PROJECT2_PHOTO" size="30" /></p>


<?php
  $pathToImg = 'images/artists/' . $artistID . '/project3/' . $project3Photo;
  if (!empty($project3Photo) && file_exists($pathToImg)) {
  
    echo '<p>Project 3 Photo: <img src="/', $pathToImg, '" style="vertical-align: top; max-width: 245px;" alt="Project 3 Photo" />',
         ' &nbsp; <a href="/', $content['MOD_NAME'], '/', $qa[0], '/remove-project3">Remove Photo</a></p>';
  
  }
?>
<p>Upload Project 3 Photo: <input type="file" name="PROJECT3_PHOTO" size="30" /></p>

<fieldset>
<legend>Page &amp; SEO Attributes</legend>
<div class="longfieldFull">Page Title<br /><input type="text" name="TITLE" value="<? echo stripslashes($title); ?>" /></div>
<div class="longfieldFull">Title On Search Engines<br /><input type="text" name="META_TITLE" value="<? echo stripslashes($meta_title); ?>" /></div>
<div class="longfieldFull">Search Engine Summary<br /><input type="text" name="META_DESCRIPTION" value="<? echo stripslashes($meta_description); ?>" /></div>
<div class="longfieldFull">Search Engine Keywords (separated by commas)<br /><input type="text" name="META_KEYWORDS" value="<? echo stripslashes($meta_keywords); ?>" /></div>
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

<h1>Artists</h1>
<p><a href="/admin/artists/0">Create Artist</a></p>

<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:100%">
<thead>
<tr>
  <th scope="col">Name</th>
  <th scope="col">Artist Photo</th>
  <th scope="col">Project 1 Photo</th>
  <th scope="col">Project 2 Photo</th>
  <th scope="col">Project 3 Photo</th>
</tr>
</thead>
<tbody>
<?php

  $qry = "SELECT * FROM artists WHERE ACTIVE=1 ORDER BY LAST_NAME ASC, FIRST_NAME ASC";
  $res = mysql_query($qry) or die(mysql_error());
  $path = '/admin/artists/';
  
  while($row = mysql_fetch_array($res)) {
  
    $artistPic = empty($row['ARTIST_PHOTO']) ? 'No' : 'Yes';
    $photo1Pic = empty($row['PROJECT1_PHOTO']) ? 'No' : 'Yes';
    $photo2Pic = empty($row['PROJECT2_PHOTO']) ? 'No' : 'Yes';
    $photo3Pic = empty($row['PROJECT3_PHOTO']) ? 'No' : 'Yes';
  
    echo <<<_DTBL_
    <tr>
      <td><a href="{$path}{$row['ARTIST_ID']}">{$row['COMPLETE_NAME']}</a></td>
      <td>{$artistPic}</td>    
      <td>{$photo1Pic}</td>    
      <td>{$photo2Pic}</td>
      <td>{$photo3Pic}</td>    
    </tr>
_DTBL_;

  }
  
?>
</tbody>
</table>
<div class="clr"></div>
<p><a href="/admin/artists/0">Create Artist</a></p>
<?php } ?>