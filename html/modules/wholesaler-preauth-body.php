
<?php 

if (isset($_POST['submitted']) && $_POST['submitted'] == 'y') {

  if (!empty($successMsg)) {
  
    echo '<p style="font-weight:bold; background: #eee; border: 1px solid #ccc; padding: 8px; font-size: 16px">', $successMsg, '</p>';
  
  }  

}

?>

<form id="myform" action="wholesaler-preauth" method="post"><div>
<p>Add to Orders Below $1000: 
   <input type="text" value="<?php echo $below1000; ?>" name="below1000" size="6" /></p>
<p>Add to Orders $1000 and Above: 
   <input type="text" value="<?php echo $above1000; ?>" name="above1000" size="6" /></p>
<p><input type="submit" value="Submit" /></p>
<input type="hidden" name="submitted" value="y" />
</div></form>
