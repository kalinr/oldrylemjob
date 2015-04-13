<?
include("../functions/start.php");
$count = 0;
$file = "shipping-2day.csv";

$fp = fopen($file, "r");

$header = fgetcsv($fp);
while (!feof($fp))
{
	$row = fgetcsv($fp);
	foreach ($row as $key => $value)
		$row[$key] = addslashes($value);
	
/*
	//GROUND SHIPPING
	$lbs = $row[0];
	$zone2 = $row[1];
	$zone3 = $row[2];
	$zone4 = $row[3];
	$zone5 = $row[4];
	$zone6 = $row[5];
	$zone7 = $row[6];
	$zone8 = $row[7];
	$zone44 = $row[8];
	$zone45 = $row[9];
	$zone46 = $row[10];
	
	mysql_query("INSERT INTO shipping_ground(LBS,ZONE2,ZONE3,ZONE4,ZONE5,ZONE6,ZONE7,ZONE8,ZONE44,ZONE45,ZONE46) VALUES ('$lbs','$zone2','$zone3','$zone4','$zone5','$zone6','$zone7','$zone8','$zone44','$zone45','$zone46')") or die(mysql_error());
*/
	/*
//SHIPPING 2 DAY
	$lbs = $row[0];
	$zone202 = $row[1];
	$zone203 = $row[2];
	$zone204 = $row[3];
	$zone205 = $row[4];
	$zone206 = $row[5];
	$zone207 = $row[6];
	$zone208 = $row[7];
	$zone224 = $row[8];
	$zone225 = $row[9];
	$zone226 = $row[10];
	
	mysql_query("INSERT INTO shipping_2day(LBS,ZONE202,ZONE203,ZONE204,ZONE205,ZONE206,ZONE207,ZONE208,ZONE224,ZONE225,ZONE226) VALUES ('$lbs','$zone202','$zone203','$zone204','$zone205','$zone206','$zone207','$zone208','$zone224','$zone225','$zone226')") or die(mysql_error());
	*/
	$count++;

}

echo '<br />'.$count;
?>