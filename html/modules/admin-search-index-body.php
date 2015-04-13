<?php

$qry = "SELECT DB_CREATED FROM search LIMIT 1";
$res = mysql_query($qry) or die(mysql_error());
$createArr = mysql_fetch_assoc($res);

?>

<form action="/<?php echo $content['MOD_NAME']; ?>" method="post" id="myform">
<p>Index last built: 
<?php

  if (!empty($createArr)) {
  
    echo date('l, F jS g:i a T', $createArr['DB_CREATED']);
  
  }

?>
</p>
<div class="buttonheight"><input type="submit" name="BUTTON" value="Regenerate Search Index" style="width:240px" /></div></div>
</form>
 