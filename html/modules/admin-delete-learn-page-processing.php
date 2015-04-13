<?php

if (isset($qa[0]) && !empty($qa[0])) {

  $qry = "SELECT * FROM learn WHERE LEARN_ID=" . $qa[0];
  $res = mysql_query($qry) or die(mysql_error());
  $learnData = mysql_fetch_assoc($res);
  
  if (mysql_num_rows($res) > 0) {
  
    $updateQry = "UPDATE content SET ACTIVE=0 WHERE ID=" . $learnData['CONTENT_ID'];
    mysql_query($updateQry) or die(mysql_error());

    $updateQry = "UPDATE learn SET ACTIVE=0 WHERE LEARN_ID=" . $qa[0];
    mysql_query($updateQry) or die(mysql_error());

  }

}

httpRedirect("/admin/learn");

?>