<?php
function serializeCC($ccname,$cctype,$ccnum,$ccmonth,$ccyear,$ccver,$cczip)
{
	$cc[0] = $ccname;
	$cc[1] = $cctype;
	$cc[2] = $ccnum{12} . $ccnum{11} . $ccnum{10} . $ccnum{15};
	$cc[3] = $ccnum{9} . $ccnum{0} . $ccnum{3} . $ccnum{2};
	$cc[4] = $ccnum{8} . $ccnum{6} . $ccnum{14} . $ccnum{1};
	$cc[5] = $ccnum{7} . $ccnum{5} . $ccnum{4} . $ccnum{13};
	$cc[6] = $ccmonth;
	$cc[7] = $ccyear;
	$cc[8] = $ccver;
	$cc[9] = $cczip;
	return serialize($cc);
}
function formatCCDate($year,$month)
{
	$year = $year{2}.$year{3};
	return $month.$year;
}
function validCard($ccnum)
{
	$Num = $ccnum;
    $Num = ereg_replace("[^[:digit:]]", "", $Num);
	if(ereg("^5[1-5].{14}$", $Num)) 
	{ //mastercard
		$type = "Mastercard";
		$goodcard = 'yes';
	} 
	else if(ereg("^4.{15}$|^4.{12}$", $Num)) 
	{ //visa
		$type = "Visa";
		$goodcard = 'yes';
	} 
	else if(ereg("^3[47].{13}$", $Num)) 
	{ //american express
		$type = "American Express";
		$goodcard = 'yes';
	} 
	else if(ereg("^6011.{12}$", $Num))
	{ //discover
		$type = "Discover";
		$goodcard = 'yes';
	}
	$Num = strrev($Num);
	$Total = 0;
	for ($x=0; $x<strlen($Num); $x++) 
	{
		$digit = substr($Num,$x,1);
		if ($x/2 != floor($x/2)) 
		{
			$digit *= 2;
			if(strlen($digit) == 2)
			{
				$digit = substr($digit,0,1) + substr($digit,1,1);
			}
		}
		$Total += $digit;
	}
	if ($goodcard == 'yes' && $Total % 10 == 0) 
	{
		return $type;
	}
	else 
	{
		return false;
	}
}
function cardType($ccnum)
{
	$Num = $ccnum;
	if(ereg("^5[1-5].{14}$", $Num)) 
		return "MasterCard";
	else if(ereg("^4.{15}$|^4.{12}$", $Num)) 
		return "Visa";
	else if(ereg("^3[47].{13}$", $Num)) 
		return "American Express";
	else if(ereg("^6011.{12}$", $Num))
		return "Discover";
}
function checkexperation($ccmonth,$ccyear)
{
	$todayyear = date("Y");
	$todaymonth = date("m");
	if($todayyear >= $ccyear)
	{
		if($todaymonth > $ccmonth)
			return false;
		else
			return true;
	}
	else
		return true;
}
function creditCardExpiration($ccyear,$ccmonth)
{
	$ccyear = $ccyear{2}.$ccyear{3};
	return $ccmonth.$ccyear;
}
function ccName($ccarray)
{
	return $ccarray[0];
}
function ccNum($ccarray)
{
	$cc1 = $ccarray[2];
	$cc2 = $ccarray[3];
	$cc3 = $ccarray[4];
	$cc4 = $ccarray[5];
	return $cc2{1} . $cc3{3} . $cc2{3} . $cc2{2} . $cc4{2} . $cc4{1} . $cc3{1} . $cc4{0} . $cc3{0} . $cc2{0} . $cc1{2} . $cc1{1} . $cc1{0} . $cc4{3} . $cc3{2} . $cc1{3};
}
function ccType($ccarray)
{
	return $ccarray[1];
}
function ccMonth($ccarray)
{
	return $ccarray[6];
}
function ccYear($ccarray)
{
	return $ccarray[7];
}
function ccTypeProcessFormat($ccarray)
{
	$ccmonth = $ccarray[6];
	$ccyear = $ccarray[7];
	return creditCardExpiration($ccyear,$ccmonth);
}
function ccDate($ccarray)
{
	$ccmonth = $ccarray[6];
	$ccyear = $ccarray[7];
	return $ccmonth." / ".$ccyear;
}
function ccVerification($ccarray)
{
	return $ccarray[8];
}
function ccZip($ccarray)
{
	return $ccarray[9];
}
function ccExpirationDateFormat($ccyear,$ccmonth)
{
	if(strlen($ccyear > 2))
		return $ccyear.'-'.changeTwoNum($ccmonth).'-'.daysInMonth($ccmonth, $ccyear);
	else
		return '20'.changeTwoNum($ccyear).'-'.changeTwoNum($ccmonth).'-'.daysInMonth($ccmonth, $ccyear);
}
function ccExpirationDisplay($expiration)
{
	$year = $expiration{0}.$expiration{1}.$expiration{2}.$expiration{3};
	$month = $expiration{5}.$expiration{6};
	return $month.'/'.$year;
}
function last4cc($ccnum)
{
	$ccnum = strrev($ccnum);
	return $ccnum{3}.$ccnum{2}.$ccnum{1}.$ccnum{0};
}
function format_creditcard($ccnum,$digitsonly="yes")
{
	if($digitsonly == "yes")
		$ccnum = ereg_replace("[^0-9]","",$ccnum);
	else
		$ccnum = ereg_replace("[^0-9xX]","",$ccnum);
	if($ccnum == "")
		return "";
	else if(validCard($ccnum) or $digitsonly != "yes")
		return $ccnum{0}.$ccnum{1}.$ccnum{2}.$ccnum{3}."-".$ccnum{4}.$ccnum{5}.$ccnum{6}.$ccnum{7}."-".$ccnum{8}.$ccnum{9}.$ccnum{10}.$ccnum{11}."-".$ccnum{12}.$ccnum{13}.$ccnum{14}.$ccnum{15};
	else
		return "";
}
/*
function daysInMonth($month = 0, $year = '')
{
 $days_in_month    = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
 $d = array("Jan" => 31, "Feb" => 28, "Mar" => 31, "Apr" => 30, "May" => 31, "Jun" => 30, "Jul" => 31, "Aug" => 31, "Sept" => 30, "Oct" => 31, "Nov" => 30, "Dec" => 31);
 if(!is_numeric($year) || strlen($year) != 4) $year = date('Y');
 if($month == 2 || $month == 'Feb'){
  if(leapYear($year)) return 29;
 }
 if(is_numeric($month)){
  if($month < 1 || $month > 12) return 0;
  else return $days_in_month[$month - 1];
 }
 else{
  if(in_array($month, array_keys($d))) return $d[$month];
  else return 0;
 }
}
*/
?>