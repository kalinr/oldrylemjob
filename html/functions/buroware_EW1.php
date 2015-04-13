<?
/*

þSKZþBELþUEBERþJþPROTþJþVARTþ0þBELDATERGþJþaaþ0þabþNþacþAþjhþ07þaeþ13400þþcsþdummytestþalþAnchor Paper COþamþ123 AnywhereþanþSuite 123þajþ50322þ1þCAþakþNowhereþjpþGail SmithþioþUSAþipþNowhereþ1þCAþjqþ50322þaoþ651-298-testþþ18þShipping test nameþ19þshipping test add 1þ20þshipping test  add 2þ21þshipping city testþ22þtsþ23þ99999þ24þUSAþjzþtsþiwþmluksetich@tsukineko.comþixþ425-555-9999þlxþ425-556-5647þ
 
 
þSKZþPOSþUEBERþJþPROTþJþVARTþ0þPOSDATERGþJþaaþ0þabþNþacþAþafþ#BD-100-001þazþ1.00þbjþ18.00
 
 
þSKZþPOSþUEBERþJþPROTþJþVARTþ0þPOSDATERGþJþaaþ0þabþNþacþAþafþ#SZ-000-031þazþ2.00þbjþ15.00
 
 
þSKZþBNOTþUEBERþJþPROTþJþVARTþ0þaaþ0þabþNþacþAþaeþ5514-5555-1234-6666, 10/10, CVC,Invoice must be faxed to 763-550-0511 Attn: Andrea, no backorders allowed This is the transaction note text

*/
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
		$query = "SELECT * FROM orders WHERE '$date_start' <= DATETIME AND DATETIME <= '$date_end'";
	$result = mysql_query($query) or die (mysql_error());
	while($row = mysql_fetch_array($result))
	{
		$query2 = "SELECT * FROM accounts WHERE ID='".$row['ACCOUNTID']."' ORDER BY ID";
		$result2 = mysql_query($query2) or die (mysql_error());
		$customer = mysql_fetch_array($result2);
		
		if($customer['TYPE'] == 1 OR $customer['TYPEID'] > 6)
			$customer['ACCOUNT_NUMBER'] = 65000;
		$output = 'þSKZþBELþUEBERþJþPROTþJþVARTþ0þBELDATERGþJþaaþ0þabþNþacþAþjhþ07þaeþ'.stripslashes($customer['ACCOUNT_NUMBER']).'þþcsþ'.stripslashes($row['PONUMBER']).'þalþ'.stripslashes($row['ORGANIZATION']).'þamþ'.stripslashes($row['ADDRESS']).'þanþ'.stripslashes($row['ADDRESS2']).'þajþ'.stripslashes($row['ZIP']).'þ1þ'.stripslashes($row['STATE']).'þakþ'.stripslashes($row['CITY']).'þjpþ'.stripslashes($row['FIRST']).' '.stripslashes($row['LAST']).'þioþ'.countryAbbriviation($row['COUNTRY']).'þipþ'.stripslashes($row['CITY']).'þ1þ'.$row['STATE'].'þjqþ'.stripslashes($row['ZIP']).'þaoþ651-298-testþþ18þ'.stripslashes($row['SHIPPING_ORGANIZATION']).'þ19þ'.stripslashes($row['SHIPPING_ADDRESS']).'þ20þ'.stripslashes($row['SHIPPING_ADDRESS2']).'þ21þ'.stripslashes($row['SHIPPING_CITY']).'þ22þ'.stripslashes($row['SHIPPING_STATE']).'þ23þ'.stripslashes($row['SHPPING_ZIP']).'þ24þ'.countryAbbriviation($row['SHIPPING_COUNTRY']).'þjzþtsþ'.stripslashes($row['EMAIL']).'þixþ'.stripslashes($customer['PHONE1']).'þlxþ'.stripslashes($customer['PHONE2']);
		if($email)
		{
			$stringData = $output;
			fwrite($fh, $stringData);
		}
		else
			echo $output;

		if($customer['TYPE'] == 1 OR $customer['TYPEID'] > 6)
		{
			$output = 'þbfþ'.$row['SHIPPING'].'þbgþ'.$row['TAX'].'þ';
			if($email)
			{
				$stringData = $output;
				fwrite($fh, $stringData);
			}
			else
				echo $output;
		}
		$output = 'þgpþ'.$order['ID'];
		if($email)
		{
			$stringData = $output;
			fwrite($fh, $stringData);
		}
		else
			echo $output;
		
		$query2 = "SELECT * FROM orders_details WHERE ORDERID='".$row['ID']."' ORDER BY ID";
		$result2 = mysql_query($query2) or die (mysql_error());
		while($row2 = mysql_fetch_array($result2))
		{
			$output =  'þSKZþPOSþUEBERþJþPROTþJþVARTþ0þPOSDATERGþJþaaþ0þabþNþacþAþafþ#'.stripslashes($row2['SKU']).'þazþ'.$row2['QUANTITY'].'þbjþ'.$row2['RATE'];
			
			if($email)
			{
				$stringData = $output;
				fwrite($fh, $stringData);
			}
			else
				echo $output;
		}
		$count++;
		$output = 'þSKZþBNOTþUEBERþJþPROTþJþVARTþ0þaaþ0þabþNþacþAþaeþOrder Comments: '.stripslashes($row['COMMENTS']);
		$query2 = "SELECT * FROM accounts_shipping WHERE ACCOUNTID='".$row['ACCOUNTID']."' AND ADDRESS1='".$row['SHIPPING_ADDRESS']."' LIMIT 1";
		$result2 = mysql_query($query2) or die (mysql_error());
		$accounts_shipping = mysql_fetch_array($result2);
		if($accounts_shipping['INSTRUCTIONS'] != '')
			$output .= ', Shipping Instructions: '.stripslashes($accounts_shipping['INSTRUCTIONS']).', ';
		if($row['SHIP_PARTIAL'] != '')
			$output .= $row['SHIP_PARTIAL'];
		if($email)
		{
			$stringData = $output;
			fwrite($fh, $stringData);
		}
		else
			echo $output;
	}
	if($email)
	{
		mysql_query("UPDATE orders SET BUROWARE_EXPORTED='1'") or die(mysql_error());
		
		fclose($fh);
		if($count > 0)
		{
			smtpEmail("sales@imaginecrafts.com","Buroware Export for ".dateformat(date("Y-m-d")),"Attached is the daily buroware export file.","Imagine Crafts",$filename);
			//smtpEmail("matthew@es-interactive.com","Buroware Export for ".dateformat(date("Y-m-d")),"Attached is the daily buroware export file.","Imagine Crafts",$filename);
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
	return $row2['ISO3'];
}
?>