<?php

$qry = "SELECT * FROM wholesale_preauth";
$res = mysql_query($qry) or die(mysql_error());
$data = mysql_fetch_assoc($res);
$below1000 = $data['below_1000'];
$above1000 = $data['above_1000'];

if (isset($_POST['submitted']) && $_POST['submitted'] == 'y') {

  $cleanedBelow = str_replace('$', '', $_POST['below1000']);
  $cleanedAbove = str_replace('$', '', $_POST['above1000']);  
  
  if (empty($cleanedBelow) || !is_numeric($cleanedBelow)) { $cleanedBelow = 0; }
  if (empty($cleanedAbove) || !is_numeric($cleanedAbove)) { $cleanedAbove = 0; }

  // set values
  $qry = "UPDATE wholesale_preauth SET below_1000='" . $cleanedBelow . "', above_1000='" . $cleanedAbove . "' WHERE wholesale_preauth_id=1";
  mysql_query($qry) or die(mysql_error());

  $successMsg = 'Preauthorization totals have been updated. Invalid amounts set to zero.';

  // pull updated values
  $qry = "SELECT * FROM wholesale_preauth";
  $res = mysql_query($qry) or die(mysql_error());
  $data = mysql_fetch_assoc($res);
  $below1000 = $data['below_1000'];
  $above1000 = $data['above_1000'];
  
}

?>