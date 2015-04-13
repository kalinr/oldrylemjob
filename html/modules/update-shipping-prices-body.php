
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

<form id="myform" action="update-shipping-prices" method="post" enctype="multipart/form-data"><div>
<p><strong>Instructions:</strong> Download and complete the CSV template(s), uploading one or more. All values must be supplied for each template.</p>
<p>Two Day Shipping (<a href="../templates/two-day-shipping.csv" title="Two Day Shipping CSV Template">CSV Template</a>): 
   <input type="file" name="two_day" size="30" /></p>
<p>Ground Shipping (<a href="../templates/ground-shipping.csv" title="Ground Shipping CSV Template">CSV Template</a>): 
   <input type="file" name="ground" size="30" /></p>
<p>Over 150 Pounds Two Day Shipping (<a href="../templates/over-150-lbs-two-day-shipping.csv" title="Over 150 Pounds Two Day Shipping CSV Template">CSV Template</a>): 
   <input type="file" name="over150_two_day" size="30" /></p>
<p>Over 150 Pounds Ground Shipping (<a href="../templates/over-150-lbs-ground-shipping.csv" title="Over 150 Pounds Ground Shipping CSV Template">CSV Template</a>): 
   <input type="file" name="over150_ground" size="30" /></p>
<p><input type="submit" value="Upload File(s)" /></p>
<input type="hidden" name="submitted" value="y" />
</div></form>

<br />
<hr />
<br />

<h2>Current Values: Two Day Shipping</h2>
<table class="dataTbl" cellspacing="0">
<thead>
<tr>
  <th scope="col"><abbr title="Pounds">LBS</abbr></th>
  <th scope="col">ZONE202</th>
  <th scope="col">ZONE203</th>  
  <th scope="col">ZONE204</th>  
  <th scope="col">ZONE205</th>
  <th scope="col">ZONE206</th>
  <th scope="col">ZONE207</th>
  <th scope="col">ZONE208</th>
  <th scope="col">ZONE224</th>
  <th scope="col">ZONE225</th>
  <th scope="col">ZONE226</th>
</tr>
</thead>
<tfoot>
<tr>
  <th><abbr title="Pounds">LBS</abbr></th>
  <th>ZONE202</th>
  <th>ZONE203</th>  
  <th>ZONE204</th>  
  <th>ZONE205</th>
  <th>ZONE206</th>
  <th>ZONE207</th>
  <th>ZONE208</th>
  <th>ZONE224</th>
  <th>ZONE225</th>
  <th>ZONE226</th>
</tr>
</tfoot>
<tbody>
<?php

$rowCounter = 1;

while ($data = mysql_fetch_array($twoDayRes, MYSQL_NUM)) {

  $allCols = count($data);
  
  echo '<tr>';

  for ($i=0; $i<$allCols; $i++) {
  
    echo '<td>', $data[$i], '</td>';

  }

  echo '</tr>';

  if ($rowCounter % 20 == 0) {
  
    echo '<tr><th><abbr title="Pounds">LBS</abbr></th><th>ZONE202</th><th>ZONE203</th><th>ZONE204</th><th>ZONE205</th><th>ZONE206</th><th>ZONE207</th><th>ZONE208</th><th>ZONE224</th><th>ZONE225</th><th>ZONE226</th></tr>';
  
  }
  
  $rowCounter++;

}

?>
</tbody>
</table>

<br /><br /><h2>Current Values: Ground Shipping</h2>
<table class="dataTbl" cellspacing="0">
<thead>
<tr>
  <th scope="col"><abbr title="Pounds">LBS</abbr></th>
  <th scope="col">ZONE2</th>
  <th scope="col">ZONE3</th>  
  <th scope="col">ZONE4</th>  
  <th scope="col">ZONE5</th>
  <th scope="col">ZONE6</th>
  <th scope="col">ZONE7</th>
  <th scope="col">ZONE8</th>
  <th scope="col">ZONE44</th>
  <th scope="col">ZONE45</th>
  <th scope="col">ZONE46</th>
</tr>
</thead>
<tfoot>
<tr>
  <th><abbr title="Pounds">LBS</abbr></th>
  <th>ZONE2</th>
  <th>ZONE3</th>  
  <th>ZONE4</th>  
  <th>ZONE5</th>
  <th>ZONE6</th>
  <th>ZONE7</th>
  <th>ZONE8</th>
  <th>ZONE44</th>
  <th>ZONE45</th>
  <th>ZONE46</th>
</tr>
</tfoot>
<tbody>
<?php

$rowCounter = 1;

while ($data = mysql_fetch_array($groundRes, MYSQL_NUM)) {

  $allCols = count($data);

  echo '<tr>';

  for ($i=0; $i<$allCols; $i++) {
  
    echo '<td>', $data[$i], '</td>';

  }

  echo '</tr>';

  if ($rowCounter % 20 == 0) {
  
    echo '<tr><th><abbr title="Pounds">LBS</abbr></th><th>ZONE2</th><th>ZONE3</th><th>ZONE4</th><th>ZONE5</th><th>ZONE6</th><th>ZONE7</th><th>ZONE8</th><th>ZONE44</th><th>ZONE45</th><th>ZONE46</th></tr>';
  
  }
  
  $rowCounter++;

}

?>
</tbody>
</table>

<br /><br /><h2>Current Values: Two Day Shipping Per Pound Over 150 Pounds</h2>
<table class="dataTbl" cellspacing="0">
<thead>
<tr>
  <th scope="col">ZONE202</th>
  <th scope="col">ZONE203</th>  
  <th scope="col">ZONE204</th>  
  <th scope="col">ZONE205</th>
  <th scope="col">ZONE206</th>
  <th scope="col">ZONE207</th>
  <th scope="col">ZONE208</th>
  <th scope="col">ZONE224</th>
  <th scope="col">ZONE225</th>
  <th scope="col">ZONE226</th>
</tr>
</thead>
<tbody>
<?php

while ($data = mysql_fetch_array($over150twoDayRes, MYSQL_NUM)) {

  $allCols = count($data);

  echo '<tr>';

  for ($i=1; $i<$allCols; $i++) {
  
    echo '<td>', $data[$i], '</td>';

  }

  echo '</tr>';

}

?>
</tbody>
</table>

<br /><br /><h2>Current Values: Ground Shipping Per Pound Over 150 Pounds</h2>
<table class="dataTbl" cellspacing="0">
<thead>
<tr>
  <th scope="col">ZONE2</th>
  <th scope="col">ZONE3</th>  
  <th scope="col">ZONE4</th>  
  <th scope="col">ZONE5</th>
  <th scope="col">ZONE6</th>
  <th scope="col">ZONE7</th>
  <th scope="col">ZONE8</th>
  <th scope="col">ZONE44</th>
  <th scope="col">ZONE45</th>
  <th scope="col">ZONE46</th>
</tr>
</thead>
<tbody>
<?php

while ($data = mysql_fetch_array($over150groundRes, MYSQL_NUM)) {

  $allCols = count($data);

  echo '<tr>';

  for ($i=1; $i<$allCols; $i++) {
  
    echo '<td>', $data[$i], '</td>';

  }

  echo '</tr>';

}

?>
</tbody>
</table>