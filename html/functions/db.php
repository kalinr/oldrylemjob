<?php

$conn2 = mysql_connect("localhost", "imaginec_produsr", "HoardMynahsRoastSauces65") or die ("Could not connect to server");
mysql_select_db("imaginec_prod_db", $conn2) or die ("Database Connection: " . mysql_error());

?>