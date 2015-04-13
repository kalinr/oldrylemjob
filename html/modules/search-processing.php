<?php 

if ($qa[0] == "reset") {

  unset($_SESSION['query']);
  httpRedirect("/".$content['MOD_NAME']);

}

if (!empty($qa[0])) {
  
  $search_query = mysqlClean(trim(strtolower($qa[0])));
  $search_query = mysql_real_escape_string($search_query);
  $query = "SELECT * FROM search_queries WHERE KEYWORD='$search_query' LIMIT 1";
  $result = mysql_query($query) or die ("error1" . mysql_error());
  $row = mysql_fetch_array($result);

  if($row['SEARCH_DATA'] != "") {

    $search_data_array = unserialize($row['SEARCH_DATA']);
    $sizeof = sizeof($search_data) + 1;
    $count = 0;

    foreach($search_data_array as $i) {
    
      if($search_data_array[$count]['ip_address'] == $_SERVER['REMOTE_ADDR'] && $search_data_array[$count]['name'] == $account['FIRST'].' '.$account['LAST']) {
        $occurences = $search_data_array[$count]['occurrences'];
	break;
      }
      else {
	$count++;
      }
    
    }

    if($occurences != "") {
      $sizeof = $count;
      $occurences++;
    }
    else {
      $occurences = 1;
    }

  }

  else {
    $occurences = 1; 
    $sizeof = 0;
  }
  
  $search_data_array[$sizeof]['accountid'] = $account['ID'];
  $search_data_array[$sizeof]['name'] = $account['FIRST'].' '.$account['LAST'];
  $search_data_array[$sizeof]['occurrences'] = $occurences;
  $search_data_array[$sizeof]['last_search'] = currentDateTime();
  $search_data_array[$sizeof]['ip_address'] = $_SERVER['REMOTE_ADDR'];

  $search_data = serialize($search_data_array);
  $total_searches = $row['TOTAL_SEARCHES'] + 1;
      
  if($row['KEYWORD'] == "") {
    $query = "INSERT INTO search_queries(KEYWORD, SEARCH_DATA, LAST_USE, LAST_IP) VALUES ('$search_query','$search_data','".currentDateTime()."','".$_SERVER['REMOTE_ADDR']."')";
  }
  else {
    $query = "UPDATE search_queries SET SEARCH_DATA='$search_data',TOTAL_SEARCHES='$total_searches',LAST_USE='".currentDateTime()."',LAST_IP='".$_SERVER['REMOTE_ADDR']."' WHERE KEYWORD='$search_query'";
  }
  mysql_query($query) or die ("error1" . mysql_error());
  
  $decodedQuery = urldecode($qa[0]);
  $_SESSION['query'] = mysql_real_escape_string($decodedQuery);

}

?>