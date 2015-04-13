<?
function exportBurowareOrders($date_start, $date_end, $email=0)
{
	$count =0;
	if(!$email)
	{
		header('Content-type: text');
		header("Cache-Control: must-revalidate");
		header("Pragma: must-revalidate");
	/*header("Content-type: application/vnd.ms-excel");*/
		header('Content-Disposition: attachment; filename='.$date_start.'-'.$date_end.'buroware.txt');
	}
	else
	{
		$filename = date("Y-m-d")."buroware.txt";
		$fh = fopen($filename, 'w') or die("can't open file");
		//fclose($handle);
	}
	if($email) //export all non-exported
		$query = "SELECT * FROM orders WHERE BUROWARE_EXPORTED='0' ORDER BY ID";
	else
		$query = "SELECT * FROM orders WHERE DATETIME >= '$date_start' AND DATETIME <= '$date_end'";
	$result = mysql_query($query) or die (mysql_error());
	while($row = mysql_fetch_array($result))
	{
		$query2 = "SELECT * FROM accounts WHERE ID='".$row['ACCOUNTID']."' ORDER BY ID";
		$result2 = mysql_query($query2) or die (mysql_error());
		$customer = mysql_fetch_array($result2);
		
		if($customer['TYPEID'] == 1 || $customer['TYPEID'] >= 6)
			$customer['ACCOUNT_NUMBER'] = 65000;

		$output = 'þSKZþBELþUEBERþNþIMMERUEBERþJþPROTþJþVARTþ0þBELDATERGþJþaaþ0þabþNþacþAþjhþ07';
		$output = $output .'þaeþ'.stripslashes($customer['ACCOUNT_NUMBER']);

		if($customer['TYPEID'] == 1 || $customer['TYPEID'] >= 6)
			{
				//nothing
			}
			else
			{
				$output = $output .'þcsþ'.stripslashes($row['PONUMBER']);
			}

		$output = $output .'þalþ'.stripslashes($row['ORGANIZATION']);
		$output = $output .'þjpþ'.stripslashes($row['FIRST']).' '.stripslashes($row['LAST']);
		$output = $output .'þamþ'.stripslashes($row['ADDRESS']);
		$output = $output .'þanþ'.stripslashes($row['ADDRESS2']);
		$output = $output .'þakþ'.stripslashes($row['CITY']);
		$output = $output .'þ01þ'.stripslashes($row['STATE']);
		$output = $output .'þajþ'.stripslashes($row['ZIP']);
		$output = $output .'þ17þ'.countryAbbriviation($row['COUNTRY']);

		$output = $output .'þ18þ'.stripslashes($row['SHIPPING_ORGANIZATION']);
		$output = $output .'þ19þ'.stripslashes($row['SHIPPING_ADDRESS']);
		$output = $output .'þ20þ'.stripslashes($row['SHIPPING_ADDRESS2']);
		$output = $output .'þ21þ'.stripslashes($row['SHIPPING_CITY']);
		$output = $output .'þ22þ'.stripslashes($row['SHIPPING_STATE']);
		$output = $output .'þ23þ'.stripslashes($row['SHIPPING_ZIP']);
		$output = $output .'þ24þ'.countryAbbriviation($row['SHIPPING_COUNTRY']);

		$output = $output .'þ41þ'.stripslashes($row['PHONE']);
		$output = $output .'þ43þ'.stripslashes($row['EMAIL']);
		$output = $output .'þ42þ'.stripslashes($customer['FAX']);

		//$output = $output .'þipþ'.stripslashes($row['CITY']);
		//$output = $output .'þ1þ'.$row['STATE'];
		//$output = $output .'þjqþ'.stripslashes($row['ZIP']);
		//$output = $output .'þaoþ651-298-test';

		//$output = $output .'þjzþtsþ'.stripslashes($row['EMAIL']);
		//$output = $output .'þixþ'.stripslashes($customer['PHONE1']);
		//$output = $output .'þlxþ'.stripslashes($customer['PHONE2']);

		if($email)
		{
			$stringData = $output;
			fwrite($fh, $stringData);
		}
		else
			echo $output;

		if($customer['TYPEID'] == 1 || $customer['TYPEID'] >= 6)
		{

			$shipvalue = "4";  
			if ($row['SHIPPING_METHOD'] != "UPS Ground")
				$shipvalue = "2";  


			$output = 'þchþ'.$shipvalue.'þbfþ'.$row['SHIPPING'].'þbgþ'.$row['TAX'].'þ';
			if($email)
			{
				$stringData = $output;
				fwrite($fh, $stringData);
			}
			else
				echo $output;
		}
		
		//$output = 'þgpþW'.$row['ID'];
		$output = 'þgpþ'.$row['ID'];
		if($email)
		{
			$stringData = $output;
			fwrite($fh, $stringData);
		}
		else
			echo $output;
		//new line
		$output = "\r\n";
		if($email)
		{
			fwrite($fh,$output);
			$eric=1;
		}
		else
		{
			echo $output;
			$eric=1;
		}
		//end new line
		$query2 = "SELECT * FROM orders_details WHERE ORDERID='".$row['ID']."' ORDER BY ID";
		$result2 = mysql_query($query2) or die (mysql_error());
		while($row2 = mysql_fetch_array($result2))
		{
			$output =  'þSKZþPOSþUEBERþNþIMMERUEBERþJþPROTþJþVARTþ2þPOSDATERGþJþaaþ0þabþNþacþA';
			$output = $output .'þafþ#'.stripslashes($row2['SKU']);
			$output = $output .'þazþ'.$row2['QUANTITY'];
			if($customer['TYPEID'] == 1 || $customer['TYPEID'] >= 6)
				$output = $output .'þbjþ'.$row2['RATE'];
			//$output = $output .'þPOSDATERGþJ';
			
			if($email)
			{
				$stringData = $output;
				fwrite($fh, $stringData);
			}
			else
				echo $output;
			//new line
			$output = "\r\n";
			if($email)
			{
				fwrite($fh,$output);
				$eric=1;
			}
			else
			{
				echo $output;
				$eric=1;
			}
			//end new line
		}
		$count++;
		$output = 'þSKZþBNOTþUEBERþNþIMMERUEBERþJþPROTþJþVARTþ2þJþaaþ0þabþNþacþAþjhþ35þaeþOrder Comments: '.stripslashes($row['COMMENTS']);
		$query2 = "SELECT * FROM accounts_shipping WHERE ACCOUNTID='".$row['ACCOUNTID']."' AND ADDRESS1='".$row['SHIPPING_ADDRESS']."' LIMIT 1";
		$result2 = mysql_query($query2) or die (mysql_error());
		$accounts_shipping = mysql_fetch_array($result2);
		if($accounts_shipping['INSTRUCTIONS'] != '')
			$output .= ' '.stripslashes($accounts_shipping['INSTRUCTIONS']).', ';
		if($row['SHIP_PARTIAL'] != '')
			$output .= $row['SHIP_PARTIAL'];

		//Next line:  Eric Shipping method - uncomment after launch
		//$output .= " - ".$row['SHIPPING_METHOD'];	

		if($email)
		{
			$stringData = $output;
			fwrite($fh, $stringData);
		}
		else
			echo $output;

		//new line
		$output = "\r\n";
		if($email)
		{
			fwrite($fh,$output);
			$eric=1;
		}
		else
		{
			echo $output;
			$eric=1;
		}
		//end new line
		
	}
	if($email)
	{
		mysql_query("UPDATE orders SET BUROWARE_EXPORTED='1'") or die(mysql_error());
		
		fclose($fh);
		if($count > 0)
		{
			smtpEmail("sales@imaginecrafts.com","Buroware Export for ".dateformat(date("Y-m-d")),"Attached is the daily buroware export file.","Imagine Crafts",$filename);
			//smtpEmail("michellel@imaginecrafts.com","Buroware Export for ".dateformat(date("Y-m-d")),"Attached is the daily buroware export file.","Imagine Crafts",$filename);
		}
		if($filename != "")
			unlink($filename);
	}
	else
		exit();
}
function formatBurowareDate($date)
{
	return $date{5}.$date{6}.'.'.$date{8}.$date{9}.'.'.$date{0}.$date{1}.$date{2}.$date{3};
}
function countryAbbriviation($country)
{
	$query2 = "SELECT * FROM countries WHERE NAME='$country' LIMIT 1";
	$result2 = mysql_query($query2) or die (mysql_error());
	$row2 = mysql_fetch_array($result2);
	return $row2['ISO'];
}
?>