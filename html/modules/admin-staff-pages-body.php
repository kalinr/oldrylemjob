<?php

if ($qa[0] != "") {

  if ($qa[0] == 0) {

    echo '<h2>Create Staff Member</h2>';
    
  }

  else {

    echo '<h2>Update Staff Member</h2>';
  
  }

?>

<form action="/<?php echo $content['MOD_NAME']; ?>/<?php echo $qa[0]; ?>" method="post" id="myform" enctype="multipart/form-data">
<p><em>Please limit photos to 200 pixels wide.</em></p>
<p>Name: <input type="text" name="STAFF_NAME" value="<?php echo stripslashes($staffName); ?>" /></p>
<p>Title: <input type="text" name="STAFF_TITLE" value="<?php echo stripslashes($staffTitle); ?>" /></p>
<p>Email: <input type="text" name="STAFF_EMAIL" value="<?php echo stripslashes($staffEmail); ?>" /></p>
<?php
  $pathToImg = 'images/staff/' . $staffID . '/' . $staffPhoto;
  if (!empty($staffPhoto) && file_exists($pathToImg)) {
  
    echo '<p>Photo: <img src="/', $pathToImg, '" style="vertical-align: top; max-width: 200px;" alt="Photo of ', $staffName, '" /></p>';
  
  }
?>
<p>Upload Photo: <input type="file" name="PHOTO" size="30" /></p>
<p>Hobbies: <textarea cols="30" rows="5"  name="STAFF_HOBBIES"><?php echo stripslashes($staffHobbies); ?></textarea></p>
<p>Display Order: <input type="text" style="vertical-align: top;" name="DISPLAY_ORDER" value="<?php echo stripslashes($displayOrder); ?>" /></p>
<div class="buttonheight"><input type="submit" name="BUTTON" value="Save" /> 
<?php

  if ($qa[0] > 0) {
  
    echo ' <input type="button" onclick="javascript:confirmDelete()" value="Delete" />';
  
  }

?>
</div></div>
</form>
 
<?php } else { ?>

<p><a href="/admin/staff/0">Create Staff Member</a></p>

<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:100%">
<thead>
<tr>
  <th scope="col">Name</th>
  <th scope="col">Title</th>
  <th scope="col">Email</th>
  <th scope="col">Display Order</th>
</tr>
</thead>
<tbody>
<?php

  $qry = "SELECT * FROM staff WHERE active=1 ORDER BY DISPLAY_ORDER ASC";
  $res = mysql_query($qry) or die(mysql_error());
  $path = '/admin/staff/';
  
  while($row = mysql_fetch_array($res)) {
  
    echo <<<_DTBL_
    <tr>
      <td><a href="{$path}{$row['STAFF_ID']}">{$row['STAFF_NAME']}</a></td>
      <td>{$row['STAFF_TITLE']}</td>    
      <td><a href="mailto:{$row['STAFF_EMAIL']}">{$row['STAFF_EMAIL']}</a></td>
      <td>{$row['DISPLAY_ORDER']}</td>
    </tr>
_DTBL_;

  }
  
?>
</tbody>
</table>
<div class="clr"></div>
<p><a href="/admin/staff/0">Create Staff Member</a></p>
<?php } ?>