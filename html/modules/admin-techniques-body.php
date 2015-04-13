<?php

function brandList() {

  global $info;
  
  $qry = "SELECT * FROM brands WHERE ACTIVE=1 ORDER BY NAME ASC";
  $res = mysql_query($qry) or die(mysql_error());  
  while ($data = mysql_fetch_assoc($res)) {
    
    echo '<option value="', $data['ID'], '"';
    if (isset($info) && !empty($info) && $info['BRAND_ID'] == $data['ID']) { echo ' selected="selected"'; } 
    echo '>', $data['NAME'], '</option>';  
  
  }
  
}

if ($qa[0] != "") {

  include_once("js/ckeditor/ckeditor.php");
  include_once('js/ckfinder/ckfinder.php');

  $CKEditor = new CKEditor();
  $CKEditor->basePath = '/js/ckeditor/';
  CKFinder::SetupCKEditor($CKEditor, '/js/ckfinder/');

  if ($qa[0] == 0) {

    echo '<h2>Create Technique</h2>';
    
  }

  else {

    echo '<h2>Update Technique</h2>';
  
  }

?>

<form action="/<?php echo $content['MOD_NAME']; ?>/<?php echo $qa[0]; ?>" method="post" id="myform" enctype="multipart/form-data">
<p>Brand: <select style="display:inline; width:auto;" name="BRAND_ID"><?php brandList(); ?></select></p>
<p>Technique Name: <input style="width:600px" type="text" name="TECHNIQUE_TITLE" value="<?php echo stripslashes($techniqueTitle); ?>" /></p>
<p>Technique Summary: <?php $CKEditor->editor("TECHNIQUE_SUMMARY", $techniqueSummary); ?></p>
<?php

  $pathToImg = 'images/techniques/' . $techniqueID . '/' . $techniquePhoto;
  if (!empty($techniquePhoto) && file_exists($pathToImg)) {  
    echo '<p>Primary Technique Photo (shown in technique listings and on detail page above technique details; max width is 1040 pixels):<br /> <img src="/', $pathToImg, '" style="max-width:760px;" alt="Photo of technique" /><br />';
    echo '<a href="/admin/techniques/', $qa[0], '/remove-photo">Delete Photo</a></p>';
  }

?>
<p>Upload Primary Technique Photo: <input type="file" name="TECHNIQUE_PHOTO" size="30" /></p>
<p>Technique Video (takes the place of primary photo on detail page; max width is 1040 pixels): <textarea style="width:600px" rows="6" cols="60" name="TECHNIQUE_VIDEO"><?php echo stripslashes($techniqueVideo); ?></textarea></p>
<p>Technique Content: <?php $CKEditor->editor("TECHNIQUE_TEXT", $techniqueText); ?></p>
<p>Technique Keywords: <textarea style="width:600px" rows="6" cols="60" name="TECHNIQUE_KEYWORDS"><?php echo stripslashes($techniqueKeywords); ?></textarea></p>
<div class="buttonheight"><input type="submit" name="BUTTON" value="Save" /> 
<?php

  if ($qa[0] > 0) {
  
    echo ' <input type="button" onclick="javascript:confirmDelete()" value="Delete" />';
  
  }

?>
</div></div>
</form>
 
<?php } else { ?>

<h1>Techniques</h1>
<p><a href="/admin/techniques/0">Create Technique</a></p>

<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:100%">
<thead>
<tr>
  <th scope="col">Name</th>
  <th scope="col">Brand</th>
  <th scope="col">Created</th>  
</tr>
</thead>
<tbody>
<?php

  $qry = "SELECT * FROM technique JOIN brands ON technique.BRAND_ID=brands.ID WHERE technique.ACTIVE=1 ORDER BY technique.TECHNIQUE_TITLE ASC";
  $res = mysql_query($qry) or die(mysql_error());
  $path = '/admin/techniques/';
  
  while($row = mysql_fetch_array($res)) {
  
    $formattedDateTime = date('M d, Y g:i A', $row['TECHNIQUE_CREATED']);
  
    echo <<<_DTBL_
    <tr>
      <td><a href="{$path}{$row['TECHNIQUE_ID']}">{$row['TECHNIQUE_TITLE']}</a></td>
      <td>{$row['NAME']}</td>
      <td>{$formattedDateTime}</td>
    </tr>
_DTBL_;

  }
  
?>
</tbody>
</table>
<div class="clr"></div>
<p><a href="/admin/techniques/0">Create Technique</a></p>
<?php } ?>