<?php

$qry = "SELECT * FROM staff WHERE ACTIVE='1' ORDER BY DISPLAY_ORDER ASC";
$res = mysql_query($qry) or die(mysql_error());
$counter = 0;

while ($data = mysql_fetch_assoc($res)) {
  
  echo '<div class="staffMember">';
  
  $imgPath = "images/staff/" . $data['STAFF_ID'] . '/' . $data['STAFF_IMG'];
  if (file_exists($imgPath)) {
    echo '<img src="', $imgPath, '" alt="', $data['STAFF_NAME'], '" /><br />'; 
  }

  if (!empty($data['STAFF_NAME'])) {
    echo '<span class="staffName">', $data['STAFF_NAME'], '</span><br />';
  }
  
  if (!empty($data['STAFF_TITLE'])) {
    echo $data['STAFF_TITLE'], '<br />';
  }

  if (!empty($data['STAFF_EMAIL'])) {
    echo '<a href="mailto:', $data['STAFF_EMAIL'], '">', $data['STAFF_EMAIL'], '</a><br />';
  }  

  if (!empty($data['STAFF_HOBBIES'])) {
    echo 'Hobbies: ', $data['STAFF_HOBBIES'];
  }
  
  echo '</div>';
  
  $counter++;
  
  if ($counter == 3) {
  
    echo '<div class="clr"></div>';
    $counter = 0;
  
  }
       
}

echo '<div class="clr"></div>';

?>