<?php
function currentDate()
{
	return gmdate("Y-m-d");
}
function currentTime()
{
	return gmdate("H:i:s");	
}
function currentDateTime()
{
	return date("Y-m-d H:i:s");
}
function leapyear($year)
{
	if(date('L'))
		return true;
	else
		return false;
}
function timeZone($datetime)
{	
	if(isset($_SESSION['USERID']))
	{
		$query = "SELECT * FROM accounts WHERE ID='".$_SESSION['USERID']."'";
		$result = mysql_query($query) or die ("error1" . mysql_error());
		$row = mysql_fetch_array($result);
		$gmt = $row['GMT'];
		$state = $row['STATE'];
	}
	else
	{
		$state = "WA";
		$gmt = -8;
	}
	$year = $datetime{0} . $datetime{1} . $datetime{2} . $datetime{3};
	$month = $datetime{5} . $datetime{6};
	$day = $datetime{8}.$datetime{9};
	$hour = $datetime{11}.$datetime{12};
	$min = $datetime{14}.$datetime{15};
	$sec = $datetime{17}.$datetime{18};
	$hour = $hour + $gmt;
	//check daylight savings time
	$day_start = daySavingStart();
	$day_end = daySavingEnd();
	$day_current = currentDate();
	if($hour == "")
		$datetime = $datetime.' 12:00:00';

	 	if($state != "AZ" AND $state != "HI" AND date("I", strtotime($year."-".$month."-".$day." ".$hour.":".$min.":".$sec)))
			$hour++;
		if($hour < 0)
		{
			$hour = 24 + $hour;
			$day--;
			if($day == 0)
			{
				$month--;
				if($month == 0)
				{
					$month = 12;
					$year--;
				}
				if($month < 10)
					$month = "0".$month;	
				$day = cal_days_in_month(CAL_GREGORIAN,$month,$year);
			}
		}
		else if($hour > 24 AND 0 <= $gmt)
		{
			$hour = $hour - 24;
				$day++;
		}
	
	$day = formatDateString($day);
	$hour = formatDateString($hour);
	$datetime = $year."-".$month."-".$day." ".$hour.":".$min.":".$sec;
	return $datetime;
}
function timeZoneReverse($datetime)
{
	return ConvertLocalTimezoneToGMT($datetime.'.000','PST');
}

function timezone_diff($tz_from, $tz_to, $time_str = 'now')
{
    $dt = new DateTime($time_str, new DateTimeZone($tz_from));
    $offset_from = $dt->getOffset();
    $timestamp = $dt->getTimestamp();
    $offset_to = $dt->setTimezone(new DateTimezone($tz_to))->setTimestamp($timestamp)->getOffset();
    return $offset_to - $offset_from;
}

function time_translate($tz_from, $tz_to, $time_str = 'now', $format = 'Y-m-d H:i:s')
{
    $dt = new DateTime($time_str, new DateTimezone($tz_from));
    $timestamp = $dt->getTimestamp();
    return $dt->setTimezone(new DateTimezone($tz_to))->setTimestamp($timestamp)->format($format);
}


function ConvertOneTimezoneToAnotherTimezone($time,$currentTimezone,$timezoneRequired)
{
    $system_timezone = date_default_timezone_get();
    $local_timezone = $currentTimezone;
    date_default_timezone_set($local_timezone);
    $local = date("Y-m-d H:i:s A");
 
    date_default_timezone_set("GMT");
    $gmt = date("Y-m-d H:i:s A");
 
    $require_timezone = $timezoneRequired;
    date_default_timezone_set($require_timezone);
    $required = date("Y-m-d h:i:s A");
 
    date_default_timezone_set($system_timezone);

    $diff1 = (strtotime($gmt) - strtotime($local));
    $diff2 = (strtotime($required) - strtotime($gmt));

    $date = new DateTime($time);
    $date->modify("+$diff1 seconds");
    $date->modify("+$diff2 seconds");
    $timestamp = $date->format("Y-m-d h:i:s");
    return $timestamp;
}
function ConvertLocalTimezoneToGMT($gmttime,$timezoneRequired)
{
    $system_timezone = date_default_timezone_get();
 
    $local_timezone = $timezoneRequired;
    date_default_timezone_set($local_timezone);
    $local = date("Y-m-d h:i:s A");
 
    date_default_timezone_set("GMT");
    $gmt = date("Y-m-d h:i:s A");
 
    date_default_timezone_set($system_timezone);
    $diff = (strtotime($gmt) - strtotime($local));
 
    $date = new DateTime($gmttime);
    $date->modify("+$diff seconds");
    $timestamp = $date->format("Y-m-d h:i:s");
    return $timestamp;
}
function timezoneOffset($includeDST = true)
{	
	if(isset($_SESSION['USERID']))
	{
		$query = "SELECT * FROM accounts WHERE ID='".$_SESSION['USERID']."'";
		$result = mysql_query($query) or die ("error1" . mysql_error());
		$row = mysql_fetch_array($result);
		$gmt = $row['GMT'];
		$state = $row['STATE'];
	}
	else
	{
		$gmt = -8;
		$state = $row['STATE'];
	}
	if ($includeDST)
	{
		//check daylight savings time
		$day_start = daySavingStart();
		$day_end = daySavingEnd();
		$day_current = currentDate();
		if($state != "AZ" AND date("I", time())) //maybe here
			$gmt++;
	}
	return $gmt;
}
function daySavingStart()
{
	$thisYear = gmdate("Y");
	$AprilDate = ((2+6 * $thisYear - round($thisYear / 4) ) % 7 + 1)+1;
 	$MarchDate = (14 - (round(1 + $thisYear * 5 / 4) % 7))+1;
	if($thisYear > 2006)
 		return "$thisYear-03-".$MarchDate;
 	else
 		return "$thisYear-04-0".$AprilDate;
}
function daySavingEnd()
{
	$thisYear = gmdate("Y");
 	$OctoberDate = ((31-( round($thisYear * 5 / 4) + 1) % 7))+1;
 	$NovemberDate = (7 - (round(1 + $thisYear * 5 / 4) % 7))+1;
 	if($thisYear > 2006)
 		return "$thisYear-11-0".$NovemberDate;
 	else
 		return "$thisYear-10-".$OctoberDate;
}
function dateformat($date)
{
	if(dateextract($date) == "0000-00-00" OR $date == "")
		return "--";
	
	//if($date{13} == "")
		//$date .= " 19:00:00";
	if($date{13} != "")
		$date = timeZone($date);
	//echo '<br />'.$date;
	$year = $date{0} . $date{1} . $date{2} . $date{3};
	$month = $date{5} . $date{6};
	$day = $date{8} . $date{9};
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
	$date = $month . " " . $day . ", " . $year;
	if($date == "00 0-, 0000")
		return "--";
	else
		return $date;
}
function formatDay($date)
{
	$day = $date{8} . $date{9};	
	if($day{1} == 1 AND $day != 11)
		$ext = "st";
	else if($day{1} == 2)
		$ext = "nd";
	else if($day{1} == 3 AND $day != 13)
		$ext = "rd";
	else
		$ext = "th";
	if($day{0} == 0)
		$day = $day{1};
	$day = $day.$ext;
	return $day;
}
function formatMonthYear($date)
{
	$year = $date{0} . $date{1} . $date{2} . $date{3};
	$month = $date{5} . $date{6};

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
		$month = "Sepember";
	else if($month == "10")
		$month = "October";
	else if($month == "11")
		$month = "November";
	else if($month == "12")
		$month = "December";
	$date = $month." ".$year;
	if($date == "00 00, 0000")
		return "--";
	else
		return $date;
}
function timeExtractAMPM($hour)
{
	if($hour <= 11)
		return "AM";
	else
		return "PM";
}
function datetimeformat($datetime)
{
	if($datetime == "0000-00-00 00:00:00" OR $datetime == "")
		return "--";
	$date = dateformat(timezone($datetime));
	$datetime = timeZone($datetime);
	$hour = $datetime{11}.$datetime{12};
	$min = $datetime{14}.$datetime{15};


	if($hour >= 12)
	{
		$ampm = "PM";
		$hour = $hour - 12;
	}
	else
	{
		$hour = $hour - 0;
		$ampm = "AM";
	}
	if($hour == 0)
		$hour = 12;
	$return = $date." ".$hour.":".$min." ".$ampm.$timer;
	if($return == "00 0-, 0000 1::0 AM")
		return "--";
	else
		return $return;
}
function formatMonth($month)
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
		$month = "Sepember";
	else if($month == "10")
		$month = "October";
	else if($month == "11")
		$month = "November";
	else if($month == "12")
		$month = "December";
	else if($month == 0)
		$month = "";
	return $month;
}
function formatSortMonthYear($datetime)
{
	$year = $datetime{0}.$datetime{1}.$datetime{2}.$datetime{3};
	$month =$datetime{5}.$datetime{6};

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
	$date = $month." ".$year;
	return $date;
}
function formatMonthDay($date)
{
	$month = $date{5}.$date{6};
	$day = $date{8}.$date{9};
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
	else if($month == 0)
		$month = "";
	return $month." ".$day;
}
function milteryToStandard($hour)
{
	if($hour > 11)
	{
		if($hour > 12)
			$hour = $hour - 12;
		$hour = $hour.":00PM";
	}
	else
	{
		if($hour == 0)
			$hour = 12;
		$hour = $hour.":00AM";
	}
	return $hour;
}
function milteryToStandard2($hour,$minutes)
{
	if($hour > 11)
	{
		if($hour > 12)
			$hour = $hour - 12;
		$time = $hour.":$minutes PM";
	}
	else
	{
		if($hour == 0)
			$hour = 12;
		$time = $hour.":$minutes AM";
	}
	return $time;
}
function dateExtract($datetime)
{
	$year = $datetime{0} . $datetime{1} . $datetime{2} . $datetime{3};
	$month = $datetime{5} . $datetime{6};
	$day = $datetime{8} . $datetime{9};
	return $year."-".$month."-".$day;
}
function dateMonthExtract($date)
{
	return $date{5}.$date{6};
}
function dateOfWeek($date)
{
	$year = $date{0} . $date{1} . $date{2} . $date{3};
	$month = $date{5} . $date{6};
	$day = $date{8} . $date{9};
	return jddayofweek(cal_to_jd(CAL_GREGORIAN,$month,$day,$year),1);
}
function numberEnd($number)
{
	if($number > 9)
	{
		$number = strrev($number);
		$number = $number{0};
	}
	if($number == 1 and $number != 11)
		return "st";
	else if($number == 2 and $number != 12)
		return "nd";
	else if($number == 3 and $number !=13)
		return "rd";
	else
		return "th";	
}
function timeExtract($datetime)
{
	$hour = $datetime{11}.$datetime{12};
	$minutes = $datetime{14}.$datetime{15};
	$time = milteryToStandard2($hour,$minutes);
	return $time;
}
function daysDuration($date1,$date2)
{
	$days = (strtotime($date1) - strtotime($date2)) / (60 * 60 * 24);
	return round(abs($days));
}
function dateDayofWeekMonthNumberFormat($date)
{
	$dayofweek = dateOfWeek($date);
	$year = $date{0} . $date{1} . $date{2} . $date{3};
	$month = $date{5} . $date{6};
	$day = $date{8} . $date{9};
	$day *= 1;
	$month = getFullMonth($month);
	return $dayofweek." ".$month." ".$day.numberEnd($day);
}
function calcDayInfuture($days,$gmt="")
{
	if($gmt == "")
		return date('Y-m-d', strtotime($days.' days'));
	else
		return gmdate('Y-m-d', strtotime($days.' days'));
}
function calcDayInPast($days)
{
	return date('Y-m-d', strtotime('-'.$days.' days'));
}
function calcMonth($months)
{
	return date('Y-m-d', strtotime($months.' months'));
}
function dateDaySubtract($date, $days)
{
	$time = strtotime($date);
	$time = mktime(1,1,1,date("m", $time), date("d", $time)-$days, date("Y", $time));
	return date("Y-m-d", $time);
}
function dateDayAddition($date, $days)
{
	$time = strtotime($date);
	$time = mktime(1,1,1,date("m", $time), date("d", $time)+$days, date("Y", $time));
	return date("Y-m-d", $time);
}
function dateMonthSubtract($date, $months = 1)
{
	$time = strtotime($date);
	$time = mktime(1,1,1,date("m", $time)-$months, date("d", $time), date("Y", $time));
	return date("Y-m-d", $time);
}
function dateMonthAddition($date, $months = 1)
{
	$time = strtotime($date);
	$time = mktime(1,1,1,date("m", $time)+$months, date("d", $time), date("Y", $time));
	return date("Y-m-d", $time);
}
function formatShortTime($date)
{
	$output = "";
	if (!is_numeric($date))
		$time = strtotime($date);
	else
		$time = $date;
	
	$output .= date("g", $time);
	$min = date("i", $time);
	
	if ($min != 0)
		$output .= ":$min";
		
	if (date("a", $time) == "am")
		$output .= "a";
	else
		$output .= "p";
	
	return $output;
}
function formattedMonthExtract($date)
{
	return $date{0}.$date{1}.$date{2};
}
function formatMinutes($minutes)
{
	if($minutes == 1)
		return $minutes." minute";
	else if($minutes < 60)
		return $minutes." minutes";
	else
	{
		$hours = floor($minutes / 60);
		$minutes = $minutes % 60;
		if($hours > 1)
			$return = $hours." hours";
		else if($hours == 1)
			$return = "1 hour";
		if($minutes == 1)
			$return2 = " ".$minutes." minute";
		else if($minutes > 1)
			$return2 = " ".$minutes." minutes";
		return $return.$return2;
	}
}
function formatMinutesToHours($mins)
{
	 if ($mins < 0) 
	 { 
        $min = Abs($mins); 
            } else { 
                $min = $mins; 
            } 
            $H = Floor($min / 60); 
            $M = ($min - ($H * 60)) / 100; 
            $hours = $H +  $M; 
            if ($mins < 0) { 
                $hours = $hours * (-1); 
            } 
            $expl = explode(".", $hours); 
            $H = $expl[0]; 
            if (empty($expl[1])) { 
                $expl[1] = 00; 
            } 
            $M = $expl[1]; 
            if (strlen($M) < 2) { 
                $M = $M . 0; 
            }
			if($H < 10)
				$H = "0".$H;
			if($M{1} == "")
				$M = "0".$M; 
            $hours = $H . ":" . $M .":00"; 
            return $hours; 
}
function formatTime($time)
{
	$hour = $time{0}.$time{1};
	$min = $time{3}.$time{4};
	
	if($hour >= 12)
	{
		$ampm = "PM";
		$hour = $hour - 12;
	}
	else
	{
		$hour = $hour - 0;
		$ampm = "AM";
	}
	if($hour == 0)
		$hour = 12;
	$return = $date." ".$hour.":".$min." ".$ampm.$timer;
	if($return == "00 0-, 0000 1::0 AM")
		return "--";
	else
		return $return;
}
function dayOfWeekName($id,$fullname="no")
{
	$query = "SELECT * FROM agenda_appts_dayofweek WHERE ID='$id'";
	$result = mysql_query($query) or die (mysql_error());
	$row = mysql_fetch_array($result);
	if($fullname == "no")
		return $row['APPR_NAME'];
	else
		return $row['FULL_NAME'];
}
function getAge($dob_date)
{
	$year = $dob_date{0}.$dob_date{1}.$dob_date{2}.$dob_date{3};
	$month = $dob_date{5}.$dob_date{6};
	$day = $dob_date{8}.$dob_date{9};
    $dob_date = $year.$month.$day;
    $age = floor((date("Ymd")-intval($dob_date))/10000);
	
    if (($age < 0) or ($age > 114))
    	return false;
    else
    	return $age;
}
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
//FORMATTING
function extractYearMonthDayTime($datetime)
{
	$e_array['year'] = $datetime{0}.$datetime{1}.$datetime{2}.$datetime{3};
	$e_array['month'] = $datetime{5}.$datetime{6};
	$e_array['day'] = $datetime{8}.$datetime{9};
	$e_array['hour'] = $datetime{11}.$datetime{12};
	$e_array['minute'] = $datetime{14}.$datetime{15};
	$e_array['minutes'] = $datetime{14}.$datetime{15};
	$e_array['second'] = $datetime{17}.$datetime{18};
	$e_array['seconds'] = $datetime{17}.$datetime{18};
	return $e_array;
}

?>