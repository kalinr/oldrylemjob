<?php
function validEmail($email) 
{
	if (!ereg("[^@]{1,64}@[^@]{1,255}", $email)) 
	{
       	return false;
       }
       $email_array = explode("@", $email);
       $local_array = explode(".", $email_array[0]);

      for ($i = 0; $i < sizeof($local_array); $i++)
       {
       	if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i]))
       	{
     			return false;
     		}
    	}
     	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1]))
     	{
     		$domain_array = explode(".", $email_array[1]);
     		if (sizeof($domain_array) < 2)
     		{
    			return false;
     		}
     		for ($i = 0; $i < sizeof($domain_array); $i++)
     		{
     			if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i]))
     			{
     				return false;
     			}
   			}
 		}
 		return true;
}
function validPhone($phone)
{
	$phone = ereg_replace("[^0-9]","",$phone);
	if($phone{9} == "" OR $phone{10} != "")
		return false;
	else
		return true;
}
function urlVerification($url)
{
	$url = stripslashes(trim($url));
	$old = ini_set('default_socket_timeout', 4);
	
	if (preg_match("'^(http://|https://)'", strtolower($url)) == 0)
		return false;
	else if (@!fopen($url, "r"))
		return false;
	else
		return true;
}

function addressIsPOBOX($address) {

  $matchExists = false;
  if (preg_match('/^P\.O\./i', $address)) { $matchExists = true; }
  if (preg_match('/^PO\s/i', $address)) { $matchExists = true; }
  if (preg_match('/^P\.O\. Box/i', $address)) { $matchExists = true; }
  if (preg_match('/^P\.O\. Bx/i', $address)) { $matchExists = true; }
  if (preg_match('/^PO Bx/i', $address)) { $matchExists = true; }
  if (preg_match('/^Post Office Box/i', $address)) { $matchExists = true; }
  if (preg_match('/^A\.P\.O\./i', $address)) { $matchExists = true; }
  if (preg_match('/^F\.P\.O\./i', $address)) { $matchExists = true; }
  if (preg_match('/^APO\s/i', $address)) { $matchExists = true; }
  if (preg_match('/^FPO\s/i', $address)) { $matchExists = true; }
  if (preg_match('/^Box\s\d/i', $address)) { $matchExists = true; }
  if (preg_match('/^Box\d/i', $address)) { $matchExists = true; }

  return $matchExists;

  //$address_check = ereg_replace("[^A-Za-z]", "",strtolower($address));
  //$po_check = $address_check{0}.$address_check{1};//.$address_check{2}.$address_check{3}.$address_check{4};
  //if($po_check == "po")
  // return true;
  // else
  // return false;

}

?>