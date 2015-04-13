
<?php 

if (isset($_POST['submitted']) && $_POST['submitted'] == 'y') {

  if (!empty($successMsg)) {
  
    echo '<p style="font-weight:bold; background: #eee; border: 1px solid #ccc; padding: 8px; font-size: 16px">', $successMsg, '</p>';
  
  }  

}

?>

<h2>Brand: <?php echo $brandData['NAME']; ?></h2>
<form id="myform" action="/admin/product-sorting/<?php echo $qa[0]; ?>" method="post">
<table cellpadding="0" cellspacing="0" border="0" class="dataTbl">
<thead>
<tr>
  <th scope="col">SKU</th>
  <th scope="col">Name</th>
  <th scope="col">Sort Order</th>
</tr>
</thead>
<tbody>

<?php 

while ($data = mysql_fetch_assoc($productRes)) {

  if (empty($data['PRODUCTSORT']) || !is_numeric($data['PRODUCTSORT'])) { $sortOrder = 0; }
  else { $sortOrder = $data['PRODUCTSORT']; }

  echo '<tr>';
  echo '<td>', $data['SKU'], '</td>';
  echo '<td>', $data['NAME'], '</td>';
  echo '<td><input type="text" class="qtyFld" size="3" name="sortingOrder[]" value="', $sortOrder, '" />';
  echo '<input type="hidden" name="theProducts[]" value="', $data['PRODUCTID'], '" />'; 
  echo '</td>';
  echo '</tr>';
  
}

?>

</tbody>
</table>


<p>
<input type="submit" value="Update" />
<input type="hidden" name="submitted" value="y" />
<input type="hidden" name="theBrand" value="<?php echo $qa[0]; ?>" />
</p>

</form>
