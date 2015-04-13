<?
function enewsCreate($first, $last, $organization, $address, $city, $state, $zip, $country, $phone, $email, $usage, $customer_type)
{
	$first = mysqlClean($first);
	$last = mysqlClean($last);
	$organization = mysqlClean($organization);
	$address = mysqlClean($address);
	$city = mysqlClean($city);
	$state = mysqlClean($state);
	$zip = mysqlClean($zip);
	$country = mysqlClean($country);
	$phone = mysqlClean($phone);
	$email = mysqlClean($email);
	$usage = mysqlClean($usage);
	$customer_type = mysqlClean($customer_type);
	$created = currentDateTime();

	mysql_query("INSERT INTO enews(FIRST, LAST, ORGANIZATION, ADDRESS, CITY, STATE, ZIP, COUNTRY, PHONE, EMAIL, USAGE_TYPE, CUSTOMER_TYPE, CREATED) VALUES ('$first', '$last', '$organization', '$address', '$city', '$state', '$zip', '$country', '$phone', '$email', '$usage', '$customer_type', '$created')") or die(mysql_error());
	return mysql_insert_id();
}
function enewsUpdate($id, $first, $last, $organization, $address, $city, $state, $country, $phone, $email, $usage, $customer_type)
{
	$first = mysqlClean($first);
	$last = mysqlClean($last);
	$organization = mysqlClean($organization);
	$address = mysqlClean($address);
	$city = mysqlClean($city);
	$state = mysqlClean($state);
	$country = mysqlClean($country);
	$phone = mysqlClean($phone);
	$email = mysqlClean($email);
	$usage = mysqlClean($usage);
	$customer_type = mysqlClean($customer_type);

	mysql_query("UPDATE enews SET FIRST='$first', LAST='$last', ORGANIZATION='$organization', ADDRESS='$address', CITY='$city', STATE='$state', COUNTRY='$country', PHONE='$phone', EMAIL='$email', USAGE='$usage', CUSTOMER_TYPE='$customer_type' WHERE ID=$id") or die(mysql_error());
}
function enewsDelete($id)
{
	mysql_query("DELETE enews WHERE ID=$id") or die(mysql_error());
}
?>