
<?php 

if (isset($_POST['submitted']) && $_POST['submitted'] == 'y') {

  if (!empty($displayError)) {
  
    echo '<p style="font-weight:bold; background: #eee; border: 1px solid #ccc; padding: 8px; color: red; font-size: 16px">', $displayError, '</p>';
  
  }

  if (!empty($successMsg)) {
  
    echo '<p style="font-weight:bold; background: #eee; border: 1px solid #ccc; padding: 8px; font-size: 16px">', $successMsg, '</p>';
  
  }  

}

?>

<h2>Brand: <?php echo $brandData['NAME']; ?></h2>
<form id="myform" action="/admin/featured-product/<?php echo $qa[0]; ?>" method="post">
<table cellpadding="0" cellspacing="0" border="0" class="dataTbl">
<thead>
<tr>
  <th scope="col">Photo</th>
  <th scope="col">Select</th>
</tr>
</thead>
<tbody>

<?php 

$i=0;

while ($data = mysql_fetch_assoc($productRes)) {

  if (!file_exists("images/products/".$data['ID'].".jpg")) { $img_filename = '/images/products/0.jpg'; }
  else { $img_filename = '/images/products/' . $data['ID'] . '.jpg'; }
  
  $altTxt = stripslashes($data['NAME']);

  echo '<tr>';
  echo '<td><label for="fphoto', $i, '"><img src="', $img_filename, '" alt="', $altTxt, '" /></label></td>';
  echo '<td style="text-align:center"><input id="fphoto', $i, '" type="radio" name="selectedProductID" value="', $data['ID'], '"';
  if ($data['ID'] == $brandData['FEATURED_PRODUCT']) { echo ' checked="checked"'; }
  echo ' /></td>';
  echo '</tr>';

  $i++;
  
}

?>

</tbody>
</table>


<p>
<input type="submit" value="Submit" />
<input type="hidden" name="submitted" value="y" />
<input type="hidden" name="theBrand" value="<?php echo $qa[0]; ?>" />
</p>

</form>
