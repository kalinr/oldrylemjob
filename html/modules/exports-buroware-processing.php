<?
	$start = formatPostDate($_POST['YEAR'],$_POST['MONTH'],$_POST['DAY']);
	$end = formatPostDate($_POST['YEAR2'],$_POST['MONTH2'],$_POST['DAY2']);
	$endAdjusted = formatPostDateEndOfDay($_POST['YEAR2'],$_POST['MONTH2'],$_POST['DAY2']);
	
	if(!isset($_POST['YEAR']))
	{
		$start = date("Y")."-01-01";
		$end = date("Y-m-d");
	}
	else
	{
		exportBurowareOrders($start, $end, $endAdjusted);
		//httpRedirect("/admin/exports/0/daily/$start/$end");
	}
	$year = $start{0}.$start{1}.$start{2}.$start{3};
	$month = $start{5}.$start{6};
	$day = $start{8}.$start{9};
	
	$year2 = $end{0}.$end{1}.$end{2}.$end{3};
	$month2 = $end{5}.$end{6};
	$day2 = $end{8}.$end{9};
?>