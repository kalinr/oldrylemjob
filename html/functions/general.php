<?php
function mysqlClean($string)
{
	return mysql_real_escape_string($string);
}
function checkSSL($url,$mod_name) 
{
    if($_SERVER['HTTPS'] == '')
    {
    	if($mod_name == '')
       		httpRedirect('https://'.$url);
       	else
       		httpRedirect('https://'.$url.'/'.$mod_name);
    }
}
function nonSSL($url,$mod_name)
{
	if($_SERVER['HTTPS'] == '')
    {
    
    }
    else
    {
    	if($mod_name == '')
       		httpRedirect('http://'.$url);
       	else
       		httpRedirect('http://'.$url.'/'.$mod_name);
    }
}
function csvExportReady($value)
{
	$value = stripslashes($value);
	return ereg_replace("[^0-9A-Za-z!@#$%^&*()_+ =.:]","",$value);	
}
function currentPage($append = 'no',$erase = 'no') {
    $url = $_SERVER['PHP_SELF'];
    $url = str_replace("/","",$url);
    $query_string = $_SERVER['QUERY_STRING'];
    if($erase != 'no' && $query_string != '') {
        $query_array = explode('&',$query_string);
        $erase_array = explode('&',$erase);
        foreach($query_array as $ind_query) {
            if(!in_array($ind_query,$erase_array)) {
                if($new_query_string == '') {
                    $new_query_string = '';
                } else {
                    $new_query_string .= '&';
                }
                $new_query_string .= $ind_query;
            }
        }
    } else {
        $new_query_string = $_SERVER['QUERY_STRING'];
    }
    if($append != 'no' && $new_query_string == '') {
        $url = $url.'?'.$append;
    } elseif($append != 'no' && $new_query_string != '') {
        $url = $url.'?'.$new_query_string.'&'.$append;
    } elseif($append == 'no' && $new_query_string == '') {
        $url = $url;
    } elseif($append == 'no' && $new_query_string != '') {
        $url = $url.'?'.$new_query_string;
    }
    return $url;
}
function lineToBR($string)
{
	return nl2br($string);
	//return str_replace("\n","<br />",$string);
}
function exists($string) {
	if(isset($string) && !empty($string)) {
		return true;
	} else {
		return false;
	}
}
function isAjax()
{
	$filename = currentFile();
	$file = $filename{0}.$filename{1}.$filename{2}.$filename{3};
	if($file == "ajax")
		return true;
	else
		return false;
}
function pageFileFirstThree()
{
	$filename = currentFile();
	$file = $filename{0}.$filename{1}.$filename{2};
	if($file == "")
		return "index.php";
	else
		return $file;
}
function pageFileFirstFive($filename="")
{
	if($filename == "")
		$filename = currentFile();
	$file = $filename{0}.$filename{1}.$filename{2}.$filename{3}.$filename{4};
	if($file == "")
		return "index.php";
	else
		return $file;
}
function pageFileFirstTen()
{
	$filename = currentFile();
	$file = $filename{0}.$filename{1}.$filename{2}.$filename{3}.$filename{4}.$filename{5}.$filename{6}.$filename{7}.$filename{8}.$filename{9};
	return $file;
}
function pageSection($file="")
{
	if($file == "")
		$file = currentfile();
	$file = str_replace(".php","",$file);
	$filename_array = explode("_",$file);
	return $filename_array{0}."_".$filename_array{1}.".php";
}
function cleanString($value)
{
	$value = stripslashes($value);
	$value = str_replace("/","*_*",$value);
	$value = ereg_replace("[^[:space:]a-zA-Z0-9*!@#$%^&*()+=:;'{}<>?_.,-]","", $value);
	$value = str_replace("*_*","/",$value);
	$value = addslashes($value);
	return $value;
}
function httpRedirect($url,$redirect = "",$allowredirect="yes")
{
	if($redirect != "")
		$_SESSION['REDIRECT'] = $redirect;
	else if($allowredirect == "yes")
	{
		$redirectq = $_SESSION['REDIRECT'];
		unset($_SESSION['REDIRECT']);
	}
	if($redirectq != "" AND $allowredirect == "yes")
		$url = $redirectq;
	if (!headers_sent())
	{
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $url");
		exit();
	}
	else
	{
		echo "<META http-equiv=\"Refresh\" content=\"0;url=$url\">";
		exit();
	}
}
function currentMainDomain()
{
	$url = selfURL();
	$url_array = explode("/",str_replace("www.","",$url));
	return $url_array[2];
}
function selfURL()
{	
	$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
	$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
	$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
	return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
}
function currentFile()
{
	$url = selfURL();
	$url_array = explode("/",$url);
	$url_array = array_reverse($url_array);
	$url = $url_array[0];
	$url_array = explode("?",$url);
	return $url_array[0];
}
function currentFullFile()
{
	$url = selfURL();
	$url_array = explode("/",$url);
	$url_array = array_reverse($url_array);
	$url_array = explode("?",$url_array[0]);
	$url_array = explode("&",$url_array[1]);
	
	return currentFile()."?".$url_array[1];
}
function arrayAverage($a)
{
  return array_sum($a)/count($a) ;
}
function strleft($s1, $s2)
{
	return substr($s1, 0, strpos($s1, $s2));
}
function shorten($string,$maxcharacters)
{
	if(strlen($string) <= $maxcharacters)
		return $string;
	else
		return substr($string,0,($maxcharacters))."...";
}
function cleanURL2($url)
{
	$url = str_replace("http://","",$url);
	$url = str_replace("https://","",$url);
	//$url = str_replace("www","",$url);
    //$url = preg_replace('~[^\\pL0-9._]+~u', '-', $url); // substitutes anything but letters, numbers and '_' with separator
   // $url = trim($url, "");
    $url = strtolower($url);
    //$url = preg_replace('~[^-a-z0-9._]+~', '', $url); // keep only letters, numbers, '_' and separator
    return $url;
}
function shortenWords($string,$maxwords)
{
	$string_array = explode(" ",$string);
	if($string_array[0] != "")
	{
		$count = 0;
		foreach($string_array as $word)
		{
			if($count == 0)
				$return_string = $word;
			else if($count < $maxwords)
				$return_string = $return_string." ".$word;
			$count++;
		}
		if($maxwords < sizeof($string_array))
			$return_string = $return_string."... ";
	}
	return $return_string;
}
function cleanURL($url)
{
	$url = strtolower($url);
	$url = str_replace("http://","",$url);
	$url = str_replace("https://","",$url);
	$url = str_replace("www.","",$url);
	return $url;
}
function currentDomain()
{
	$url = strtolower($_SERVER['SERVER_NAME']);
	$url_array = explode(".",$url);
	$url_array = array_reverse($url_array);
	return $url_array[1].".".$url_array[0];
	return $url;
}
function countryFullNameToISO($country)
{
	$query = "SELECT ISO FROM countries WHERE PRINTABLE_NAME='$country'";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$row = mysql_fetch_array($result);
	return $row['ISO'];
}
function nextID($table)
{
	$count = 0;
	$qShowStatus = "SHOW TABLE STATUS LIKE '$table'";
	$qShowStatusResult = mysql_query($qShowStatus) or die ( "Query failed: " . mysql_error() . "<br/>" . $qShowStatus );
	$row = mysql_fetch_assoc($qShowStatusResult);
	$count = $row['Auto_increment'];
	return $count;
}
function notAuthorized()
{
	httpRedirect(currentFile());
}
function CleanArray($array)
{
	if (!is_array($array))
		return $array;
	
	foreach ($array as $key => $value)
	{ 
		if (is_array($value))
			$array[$key] = CleanArray($value);
		else
			$array[$key] = addslashes($value); 
	} 
	return $array; 
}
function unCleanArray($array)
{
	if (!is_array($array))
		return $array;
	foreach ($array as $key => $value)
	{
		if (is_array($value))
			$array[$key] = unCleanArray($value);
		else
			$array[$key] = stripslashes($value); 
	} 
	return $array; 
	//to use: $row = unCleanArray(mysql_fetch_array($result));
}
function dirName2()
{
	$path = dirname($_SERVER['PHP_SELF']);
	$path_array = array_reverse(explode("/",$path));
	return $path_array[0];
}
function get_file_extension($filename) 
{
	return substr(strrchr($filename,'.'),1);
}
function prevPage()
{
	$count = 0;
	$page = "";
	if($_SERVER['HTTP_REFERER'] != "")
	{
		$page_array = explode("/",$_SERVER['HTTP_REFERER']);
		if(sizeof($page_array) > 0)
		{
			foreach($page_array as $i)
			{
				if($count > 2 && $i != "")
				{
					if($page == "")
						$page = $i;
					else
						$page .= "/".$i;
				}
				$count++;
			}
		}
	}
	return $page;
}
?>