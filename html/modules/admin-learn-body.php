<?php

if ($qa[0] != "") {

  include_once("js/ckeditor/ckeditor.php");
  include_once('js/ckfinder/ckfinder.php');

  $CKEditor = new CKEditor();
  $CKEditor->basePath = '/js/ckeditor/';
  CKFinder::SetupCKEditor($CKEditor, '/js/ckfinder/');

  echo "<h2>Modify Learn Page: {$brandName}</h2>";

?>

<form action="/<?php echo $content['MOD_NAME']; ?>/<?php echo $qa[0]; ?>" method="post" id="myform" enctype="multipart/form-data">
<?php
  $pathToImg = 'images/learn-banners/' . $learnID . '/' . $learnPhoto;
  if (!empty($learnPhoto) && file_exists($pathToImg)) {
  
    echo '<p>Banner: <img src="/', $pathToImg, '" style="vertical-align: top; max-width: 610px;" alt="Banner Photo" />',
         '<br /><a href="/', $content['MOD_NAME'], '/', $qa[0], '/remove-banner">Remove Banner Image</a></p>';
         
  }
?>
<p>Upload Banner Image (max width 765 pixels): <input type="file" name="LEARN_PHOTO" size="30" /></p>
<p>Heading Above Video: <input style="width:600px" type="text" name="LEARN_HEADING" value="<?php echo stripslashes($learnHeading); ?>" /></p>
<p>Video Code (use a width of 765 pixels for full-width videos): <textarea  style="width:600px" rows="6" cols="60" name="LEARN_VIDEO"><?php echo stripslashes($learnVideo); ?></textarea></p>
<p>Left-Hand Column Text:</p>
<p><?php $CKEditor->editor("LEARN_TEXT", $learnText); ?></p>
<p>Show Techniques Link: <input type="checkbox" name="SHOW_TECHNIQUES_LINK" value="1" <?php if ($showTechniques == '1') { echo 'checked="checked"'; } ?> /></p>
<p>Show Projects Link: <input type="checkbox" name="SHOW_PROJECTS_LINK" value="1" <?php if ($showProjects == '1') { echo 'checked="checked"'; } ?> /></p>
<p>Show Shop Link: <input type="checkbox" name="SHOW_SHOP_LINK" value="1" <?php if ($showShop == '1') { echo 'checked="checked"'; } ?> /></p>
<div class="buttonheight"><input type="submit" name="BUTTON" value="Save" /> 

</div></div>
</form>
 
<?php } else { ?>

<h1>Active Learn Pages</h1>

<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:100%">
<thead>
<tr>
  <th scope="col">Brand</th>
  <th scope="col">Category</th>
  <th scope="col">Techniques Link</th>
  <th scope="col">Projects Link</th>
  <th scope="col">Shop Link</th>
  <th scope="col">Delete</th>  
</tr>
</thead>
<tbody>
<?php

  $qry = "SELECT learn.*, brands.NAME as brandname, categories.NAME as categoryname FROM learn JOIN brands ON brands.ID=learn.BRAND_ID JOIN categories ON categories.ID=brands.CATEGORYID WHERE learn.ACTIVE=1 AND brands.ACTIVE=1 ORDER BY brands.NAME ASC";
  $res = mysql_query($qry) or die(mysql_error());
  $path = '/admin/learn/';
  $delPath = '/admin/delete-learn-page/';
  $rebuildPath = '/admin/rebuild-learn-page/';
  
  while($row = mysql_fetch_array($res)) {
  
    $techniques = ($row['SHOW_TECHNIQUES_LINK'] == 0) ? 'Not Shown' : 'Shown';
    $projects = ($row['SHOW_PROJECTS_LINK'] == 0) ? 'Not Shown' : 'Shown';
    $shop = ($row['SHOW_SHOP_LINK'] == 0) ? 'Not Shown' : 'Shown';
  
    echo <<<_DTBL_
    <tr>
      <td><a href="{$path}{$row['LEARN_ID']}">{$row['brandname']}</a></td>
      <td>{$row['categoryname']}</td>    
      <td>{$techniques}</td>    
      <td>{$projects}</td>
      <td>{$shop}</td>
      <td><a href="{$delPath}{$row['LEARN_ID']}">Delete</a></td>
    </tr>
_DTBL_;

  }
  
?>
</tbody>
</table>
<div class="clr"></div>

<h1>Deleted Learn Pages</h1>

<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:100%">
<thead>
<tr>
  <th scope="col">Brand</th>
  <th scope="col">Category</th>
  <th scope="col">Techniques Link</th>
  <th scope="col">Projects Link</th>
  <th scope="col">Shop Link</th>
  <th scope="col">Rebuild</th>  
</tr>
</thead>
<tbody>
<?php

  $qry = "SELECT learn.*, brands.NAME as brandname, categories.NAME as categoryname FROM learn JOIN brands ON brands.ID=learn.BRAND_ID JOIN categories ON categories.ID=brands.CATEGORYID WHERE learn.ACTIVE=0 AND brands.ACTIVE=1 ORDER BY brands.NAME ASC";
  $res = mysql_query($qry) or die(mysql_error());
  $path = '/admin/learn/';
  
  while($row = mysql_fetch_array($res)) {
  
    $techniques = ($row['SHOW_TECHNIQUES_LINK'] == 0) ? 'Not Shown' : 'Shown';
    $projects = ($row['SHOW_PROJECTS_LINK'] == 0) ? 'Not Shown' : 'Shown';
    $shop = ($row['SHOW_SHOP_LINK'] == 0) ? 'Not Shown' : 'Shown';
  
    echo <<<_DTBL_
    <tr>
      <td>{$row['brandname']}</td>
      <td>{$row['categoryname']}</td>    
      <td>{$techniques}</td>    
      <td>{$projects}</td>
      <td>{$shop}</td>    
      <td><a href="{$rebuildPath}{$row['LEARN_ID']}">Rebuild</a></td>
    </tr>
_DTBL_;

  }
  
?>
</tbody>
</table>
<div class="clr"></div>

<?php } ?>