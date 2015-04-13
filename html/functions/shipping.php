<?
function UPSshippingCalculation($lbs,$state,$zip, $shipping_method)
{
	/*
	$shipping method options are
	- 2DAY_AIR
	- GROUND
	*/
	if($shipping_method != "GROUND" && $shipping_method != "2DAY_AIR")
		return 0;
	if($lbs == 0)
		return 0;
	$zip = ereg_replace("[^0-9]","",$zip);
	$lbs = ereg_replace("[^0-9]","",$lbs);
	$zip3 = $zip{0}.$zip{1}.$zip{2};
	//$query = "SELECT $shipping_method FROM shipping_upszones WHERE STATE='' AND ZIP_START<='$zip3' AND '$zip3'<=ZIP_END";
	$query = "SELECT $shipping_method FROM shipping_upszones WHERE STATE='' AND '$zip3'>=ZIP_START AND '$zip3'<=ZIP_END";	
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);	
	$zone = $row[$shipping_method];
	
	// zones for alaska and hawaii
	if($zone == "" or $zone == 0) {
	
	  if($shipping_method == "GROUND") {
	    $zone = 8;
	  }
	  else {
	    $zone = 208;
	  }
	  
	}
	
	// determine rate
	if($shipping_method == "GROUND") {
	
	  $query = "SELECT ZONE".$zone." AS RATE FROM shipping_ground WHERE LBS='$lbs' LIMIT 1";
	
	} 
	else {
	
	  $query = "SELECT ZONE".$zone." AS RATE FROM shipping_2day WHERE LBS='$lbs' LIMIT 1";
	
	}
	
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
	$rate = $row['RATE'];

        // default rate
	if($rate == 0 or $rate == "") {	
	  $rate = 18.50;
	}
	
	// lookup overweight charge
	if($lbs > 150) {
	  
	  if ($shipping_method == "GROUND") {
	  
	    $overQry = "SELECT ZONE" . $zone . " AS OVERWEIGHT_RATE FROM shipping_ground_over150 LIMIT 1";
	  
	  }
	  
	  else {
	  
	    $overQry = "SELECT ZONE" . $zone . " AS OVERWEIGHT_RATE FROM shipping_2day_over150 LIMIT 1";    	  

	  }    

	  $overRes = mysql_query($overQry) or die (mysql_error());
	  $overArr = mysql_fetch_assoc($overRes);
	  $overVal = $overArr['OVERWEIGHT_RATE'];
	  	  
	  $rate = $overVal * $lbs;
	  
	}	
		
	$rate = ($rate * 1.05); //5% fuel charge
	//$rate += 1; //box + packing supplies
	return money_format('%i',$rate);
}
?>