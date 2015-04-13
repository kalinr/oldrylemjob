<form id="myform" action="/<? echo $content['MOD_NAME']; ?>" method="post">


<?
if (accountIsRetail($account['ID'])) { $iswholesale = 0; }
else { $iswholesale = 1; }

// retail customers
if ($iswholesale==0) {

  echo '<p><strong>Shipping Method</strong></p>';
  $query = "SELECT * FROM shipping_methods WHERE ACTIVE='1'";
  $result = mysql_query($query) or die ("error1" . mysql_error());

  while($row = mysql_fetch_array($result)) {

    if($_SESSION['SHIPPING_METHOD'] == $row['NAME']) {
      $checked = " checked";
    }
    else {
      $checked = "";
      $cost = UPSshippingCalculation($lbs,$shipping_state,$shipping_zip, $row['ZONE_COLUMN']);
      echo '<p><input type="radio" name="SHIPPING_METHOD" value="'.stripslashes($row['NAME']).'"'.$checked.' /> '.stripslashes($row['NAME']).' $'.$cost.'</p>';
    }
  
  }
  
  echo '<input type="hidden" name="SHIP_PARTIAL" value="Ship complete" />';

}	

// non-retail customers
else {

  echo '<p><strong>Shipping &amp; Handling</strong></p>';
  echo '<p><input type="radio" name="SHIPPING_METHOD" checked value="TBD" style="display:none" />';
  echo 'Shipping charges to be determined at time of order fulfillment.</p>';
  echo '<p style="font-size: 14pt;">If you have special instructions such as a UPS collect account number or other information to provide to us, please enter it in the box on the &ldquo;Checkout: Review&rdquo; page before submitting your order.</p>';
  echo '<br />';
  echo '<p><input type="hidden" name="WHLSLE" value="1" style="display:none" />';

  echo '<p><strong>Shipping Options</strong></p>';
  echo '<p><input type="radio" name="SHIP_PARTIAL" value="Ship complete"'; 
  if ($ship_partial == "Ship complete") { echo ' checked'; } 
  echo ' /> Ship complete</p>';
  echo '<p><input type="radio" name="SHIP_PARTIAL" value="OK to ship partial order"'; 
  if ($ship_partial == "OK to ship partial order") { echo ' checked'; } 
  echo ' /> OK to ship partial order</p>';

  echo '<p>&nbsp;</p>';
  echo '<p><strong>Name of person entering this order</strong></p>';
  echo '<p><input type="text" onfocus="this.select()" name="personordering" maxlength="80" /></p>';

}
?>

<p><input type="submit" name="BUTTON" value="Continue" /></p>
</form>