<?php
function removeBeginningAndEndParagraph($content)
{
	$first3 = $content{0}.$content{1}.$content{2};
	if($first3 == "<p>")
	{
		$content{0} = '`';
		$content{1} = '`';
		$content{2} = '`';
	}
	$content = strrev($content);
	$last4 = $content{0}.$content{1}.$content{2}.$content{3};
	if($last4 == ">p/<")
	{
		$content{0} = '`';
		$content{1} = '`';
		$content{2} = '`';
		$content{3} = '`';
	}
	return str_replace("`","",strrev($content));
}
function upperCaseEachFirstLetter($string)
{
	$string_exploded = explode(" ",$string);
	$count = 0;
	foreach($string_exploded as $word)
	{
		if($count == 0)
			$string = ucfirst($word);
		else
			$string .= ' '.ucfirst($word);
		$count++;
	}
	return $string;
}
function upperCaseFirstName($word)
{
	return ucfirst($word);
}
function firstNameLastInitial($first,$last)
{
	$last_initial = $last{0};
	return $first.' '.$last_initial.'.';
}
function format_phone($phone)
{
	$phone = ereg_replace("[^0-9]","",$phone);
	if(validPhone($phone)) //PHONE DISPLAY FORMATTING
		$phone = $phone{0} . $phone{1} . $phone{2} . "-" . $phone{3} . $phone{4} . $phone{5} . "-" . $phone{6} . $phone{7} . $phone{8} . $phone{9};
	else if($phone{9} != "")
		$phone = $phone{0} . $phone{1} . $phone{2} . "-" . $phone{3} . $phone{4} . $phone{5} . "-" . $phone{6} . $phone{7} . $phone{8} . $phone{9}."&nbsp;x".$phone{10}.$phone{11}.
$phone{12}.$phone{13};	
	else if($phone{6} != "")
		$phone = $phone{0} . $phone{1} . $phone{2} . "-" . $phone{3} . $phone{4} . $phone{5} .$phone{6}." ".$phone{7}.$phone{8};
	return $phone;
}
function formatPostDate($year,$month,$day)
{
	if($day < 10)
		$day = "0".$day;
	if($month < 10)
		$month = "0".$month;
	$date = $year . "-" . $month . "-" . $day;
	if($date != "--" AND $date != "-0-0")
		return $date;
}
function formatPostDateEndOfDay($year,$month,$day)
{
        $day = $day + 1;
	if($day < 10)
		$day = "0".$day;
	if($month < 10)
		$month = "0".$month;
	$date = $year . "-" . $month . "-" . $day;
	if($date != "--" AND $date != "-0-0")
		return $date;
}
function timeFormat($datetime)
{
	$hours = $datetime{11}.$datetime{12};
	$minutes = $datetime{14}.$datetime{15};
	if($hours >= 12)
	{
		$hours -= 12;
		$ampm = "PM";
	}
	else
	{
		$ampm = "AM";
		if($hours == 0)
			$hours = 12;
	}
	$date = $hours.":".$minutes." ".$ampm;
	return $date;
}
function formatPostDateTime($date,$hour,$minute,$ampm)
{
	if($ampm == "PM" AND $hour != 12)
		$hour += 12;
	$datetime = $date." ".$hour.":".$minute.":00";
	return $datetime;
}
function formatDateString($number)
{
	$number = $number * 1;
	if($number < 10)
		$number = "0".$number;
	return $number;
}
function getFullMonth($month)
{
	if($month == "01")
		$month = "January";
	else if($month == "02")
		$month = "February";
	else if($month == "03")
		$month = "March";
	else if($month == "04")
		$month = "April";
	else if($month == "05")
		$month = "May";
	else if($month == "06")
		$month = "June";
	else if($month == "07")
		$month = "July";
	else if($month == "08")
		$month = "August";
	else if($month == "09")
		$month = "September";
	else if($month == "10")
		$month = "October";
	else if($month == "11")
		$month = "November";
	else if($month == "12")
		$month = "December";
	return $month;
}
function getMonth($month)
{
	if($month == "01")
		$month = "Jan";
	else if($month == "02")
		$month = "Feb";
	else if($month == "03")
		$month = "Mar";
	else if($month == "04")
		$month = "Apr";
	else if($month == "05")
		$month = "May";
	else if($month == "06")
		$month = "Jun";
	else if($month == "07")
		$month = "Jul";
	else if($month == "08")
		$month = "Aug";
	else if($month == "09")
		$month = "Sep";

else if($month == "10")
		$month = "Oct";
	else if($month == "11")
		$month = "Nov";
	else if($month == "12")
		$month = "Dec";
	return $month;
}
function dateformatStandard($date)
{
	$year = $date{0} . $date{1} . $date{2} . $date{3};
	$month = $date{5} . $date{6};
	$day = $date{8} . $date{9};
	$month = getMonth($month);
	$date = $month . " " . $day . ", " . $year;
	if($date == "00 00, 0000")
		return "--";
	else
		return $date;
}
function monthDay($date)
{
	$month = $date{5} . $date{6};
	$day = $date{8} . $date{9};
	$month = getMonth($month);
	$date = $month . " " . $day;
	if($date == "00 00")
		return "--";
	else
		return $date;
}
function formatBytes($value,$type,$round)
{
	if($type == "KB")
  		$value = ($value / 1024 * 100) / 100;
	else if($type == "MB")
  		$value = ($value / 1048576 * 100) / 100;
	else if($type == "GB")
  		$value = ($value / 1073741824 * 100) / 100;
	else
 		return "error";
	return round($value,$round);
}
function billingCycle($billing_cycle)
{
	if($billing_cycle == 1)
		return "Monthly";
	else if($billing_cycle == 3)
		return "Quarterly";
	else if($billing_cylce == 6)
		return "Semi-Annually";
	else if($billing_cycle == 12)
		return "Annually";
}
function correctRecognizableDateFormatting($date)
{
	$date_array = explode("/",ereg_replace("[^0-9/]","",$date));
	$year = $date_array[2];
	$month = $date_array[0];
	$day = $date_array[1];
	if(noLeadZero($month))
		$month = changeTwoNum($month);
	if(noLeadZero($day))
		$day = changeTwoNum($day);
	if($month != "" or $days != "")
		return $month."/".$day."/".$year;
	else
		return "";
}
function isDigits ($digits) {
	return !preg_match ("/[^0-9]/", $digits);
}
function confirmNumberOfDigits($string)
{
	$string = ereg_replace("[^0-9]","",$string);
	if($string{7} == "")
		return false;
	else
		return true;
}
function correctDateFormat($date) {
	$mon = $date{0}.$date{1};
	$day = $date{3}.$date{4};
	$year = $date{6}.$date{7}.$date{8}.$date{9};
	$new_date = $year.'-'.$mon.'-'.$day;
	return $new_date;
}
function recognizableDate($date) {
	$mon = $date{5}.$date{6};
	$day = $date{8}.$date{9};
	$year = $date{0}.$date{1}.$date{2}.$date{3};
	$new_date = $mon.'/'.$day.'/'.$year;
	return $new_date;
}
function check_date($date) {
	$pattern = "^([0-9]{4})-([0-9]{2})-([0-9]{2})$";
	if(eregi($pattern, $date)) {
		$date = explode('-',$date);
		if(checkdate($date['1'],$date['2'],$date['0'])) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}
function movedate($date, $fulldays, $direction) {
	$days = 1;
	$date = explode('-', $date);
	$days_in_month = days_in_month($date['1'], $date['0']);
	if($direction == '-') {
		$new_day = $date['2'] - $days;
	} elseif ($direction == '+') {
		$new_day = $date['2'] + $days;
	}
	if($new_day > $days_in_month) {
		if($date['1'] == '12') {
			$new_month = '1';
			$new_year = $date['0'] + 1;
		} else {
			$new_month = $date['1'] + 1;
			$new_year = $date['0'];
		}
		$new_day = $new_day - $days_in_month;
	} elseif($new_day < '1') {
		if($date['1'] == '1') {
			$new_month = '12';
			$new_year = $date['0'] - 1;
		} else {
			$new_month = $date['1'] - 1;
			$new_year = $date['0'];
		}
		$old_days_in_month = days_in_month($new_month, $new_year);
		$new_day = $new_day + $old_days_in_month;
	} else {
		$new_month = $date['1'];
		$new_year = $date['0'];
	}
	$new_date = $new_year.'-'.changeTwoNum($new_month).'-'.changeTwoNum($new_day);
	$fulldays = $fulldays - 1;
//	echo $new_date.' ::::::::: '.$fulldays.'<br />';
	if($fulldays > 0) {
		return movedate($new_date,$fulldays,$direction);
	} else {
		return $new_date;
	}
}
function days_in_month($month, $year) {
return cal_days_in_month(CAL_GREGORIAN, $month, $year);
}
function changeTwoNum($day) 
{
	$day = str_split($day);
	if(count($day) == '1') {
		$day = '0'.$day['0'];
	} else {
		$day = $day['0'].$day['1'];
	}
	return $day;
}
function noLeadZero($str) 
{
	if($str{0} == 0)
		$str = substr($str,1,(strlen($str)-1));
	return $str;
}

?>