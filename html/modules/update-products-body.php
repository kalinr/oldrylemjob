
<ol>
  <li><p><a href="../templates/product-update-template.csv">Download the template to use for price and specifications changes</a></p></li>
  <li><p>Make changes to the template file.</p>
      <ul>
        <li>Only the fields supplied for a product will be updated. If a field or fields are omitted the existing values will not be changed.</li>
        <li>The fields must be in the order shown in the template or data will go into the wrong location.</li>
        <li>The SKU is used to look up the product so it needs to match exactly.</li>
      </ul>
  <li><p>Upload the CSV file using the form on this page.</p></li>
</ol>

<hr />

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

<form id="myform" action="update-products" enctype="multipart/form-data" method="post"><div>
<p><input type="file" name="products" size="60" /></p>
<p><input type="submit" name="BUTTON" value="Upload File" /></p>
<input type="hidden" name="submitted" value="y" />
</div></form>