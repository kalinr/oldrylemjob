<?
function runCrontab()
{
	cronDeleteOldCartCookies();
	exportBurowareOrders("", "", 1);
}
?>