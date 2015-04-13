<?
/*

þSKZþBELþUEBERþJþPROTþJþVARTþ0þBELDATERGþJþaaþ0þabþNþacþAþjhþ07þaeþ13400þþcsþdummytestþalþAnchor Paper COþamþ123 AnywhereþanþSuite 123þajþ50322þ1þCAþakþNowhereþjpþGail SmithþioþUSAþipþNowhereþ1þCAþjqþ50322þaoþ651-298-testþþ18þShipping test nameþ19þshipping test add 1þ20þshipping test  add 2þ21þshipping city testþ22þtsþ23þ99999þ24þUSAþjzþtsþiwþmluksetich@tsukineko.comþixþ425-555-9999þlxþ425-556-5647þ
 
 
þSKZþPOSþUEBERþJþPROTþJþVARTþ0þPOSDATERGþJþaaþ0þabþNþacþAþafþ#BD-100-001þazþ1.00þbjþ18.00
 
 
þSKZþPOSþUEBERþJþPROTþJþVARTþ0þPOSDATERGþJþaaþ0þabþNþacþAþafþ#SZ-000-031þazþ2.00þbjþ15.00
 
 
þSKZþBNOTþUEBERþJþPROTþJþVARTþ0þaaþ0þabþNþacþAþaeþ5514-5555-1234-6666, 10/10, CVC,Invoice must be faxed to 763-550-0511 Attn: Andrea, no backorders allowed This is the transaction note text

*/
function exportBurowareOrders($date_start, $date_end)
{
	header('Content-type: text');
	header("Cache-Control: must-revalidate");
	header("Pragma: must-revalidate");
	/*header("Content-type: application/vnd.ms-excel");*/
	header('Content-Disposition: attachment; filename='.$date_start.'-'.$date_end.'buroware.txt');

	
	$query = "SELECT * FROM orders WHERE '$date_start' <= DATETIME AND DATETIME <= '$date_end'";
	$result = mysql_query($query) or die (mysql_error());
	while($row = mysql_fetch_array($result))
	{
		$query2 = "SELECT * FROM accounts WHERE ID='".$row['ACCOUNTID']."' ORDER BY ID";
		$result2 = mysql_query($query2) or die (mysql_error());
		$customer = mysql_fetch_array($result2);
		
		if($customer['TYPE'] == 1 OR $customer['TYPEID'] > 6)
			$customer['ACCOUNT_NUMBER'] = 65000;
		echo 'þSKZþBELþUEBERþJþPROTþJþVARTþ0þBELDATERGþJþaaþ0þabþNþacþAþjhþ07þaeþ'.stripslashes($customer['ACCOUNT_NUMBER']).'þþcsþ'.stripslashes($row['PONUMBER']).'þalþ'.stripslashes($row['ORGANIZATION']).'þamþ'.stripslashes($row['ADDRESS']).'þanþ'.stripslashes($row['ADDRESS2']).'þajþ'.stripslashes($row['ZIP']).'þ1þ'.stripslashes($row['STATE']).'þakþ'.stripslashes($row['CITY']).'þjpþ'.stripslashes($row['FIRST']).' '.stripslashes($row['LAST']).'þioþ'.countryAbbriviation($row['COUNTRY']).'þipþ'.stripslashes($row['CITY']).'þ1þ'.$row['STATE'].'þjqþ'.stripslashes($row['ZIP']).'þaoþ651-298-testþþ18 þ'.stripslashes($row['SHIPPING_ORGANIZATION']).'þ19 þ'.stripslashes($row['SHIPPING_ADDRESS']).'þ20 þ'.stripslashes($row['SHIPPING_ADDRESS2']).'þ21 þ'.stripslashes($row['SHIPPING_CITY']).'þ22 þ'.stripslashes($row['SHIPPING_STATE']).'þ23 þ'.stripslashes($row['SHPPING_ZIP']).'þ24þ'.countryAbbriviation($row['SHIPPING_COUNTRY']).'þjzþtsþ'.stripslashes($row['EMAIL']).'þixþ'.stripslashes($customer['PHONE1']).'þlxþ'.stripslashes($customer['PHONE2']);
		if($customer['TYPE'] == 1 OR $customer['TYPEID'] > 6))
			echo 'þbfþ'.$row['SHIPPING'].'þbgþ'.$row['TAX'].'þ';
		echo 'þgpþ'.$order['ID'];
		
		$query2 = "SELECT * FROM orders_details WHERE ORDERID='".$row['ID']."' ORDER BY ID";
		$result2 = mysql_query($query2) or die (mysql_error());
		while($row2 = mysql_fetch_array($result2))
		{
			echo 'þSKZþPOSþUEBERþJþPROTþJþVARTþ0þPOSDATERGþJþaaþ0þabþNþacþAþafþ#'.stripslashes($row2['SKU']).'þazþ'.$row2['QUANTITY'].'þbjþ'.$row2['RATE'];
		}
		echo 'þSKZþBNOTþUEBERþJþPROTþJþVARTþ0þaaþ0þabþNþacþAþaeþOrder Comments: '.stripslashes($row['COMMENTS']);
		$query2 = "SELECT * FROM accounts_shipping WHERE ACCOUNTID='".$row['ACCOUNTID']."' AND ADDRESS='".$row['SHIPPING_ADDRESS']."' LIMIT 1";
		$result2 = mysql_query($query2) or die (mysql_error());
		$accounts_shipping = mysql_fetch_array($result2);
		if($accounts_shipping['INSTRUCTIONS'] != '')
			echo ', Shipping Instructions: '.stripslashes($accounts_shipping['INSTRUCTIONS']);
	}
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