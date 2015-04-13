<form id="myform" method="post" action="/<? echo $content['MOD_NAME']; ?>">
					<table id="salesreporttable" style="margin-bottom:0px;width:100%">
						<tr>
						<td><strong>Report Start Date</strong><br />
										<select size="1" name="MONTH" id="MONTH" style="width: 80px; display: inline;">
												<?php
						$query = "SELECT ID, NAME FROM months";
						$result = mysql_query($query) or die (mysql_error());
						while($row = mysql_fetch_array($result))
						{
							$monthq = $row['ID'];
							$monthname = $row['NAME'];
							if($month == $monthq)
								$selected = " selected";
							else
								$selected = "";
							echo "<option value=\"$monthq\"$selected>$monthname</option>";
						}
?>
										</select>
										<select size="1" name="DAY" id="DAY" style="width:65px; display: inline;">
												<?php
									$day_count = 1;
									while($day_count <= 31)
									{
										if($day == $day_count)
											$selected = "selected";
										else 
											$selected = "";
										echo "<option $selected>$day_count</option>";
										$day_count++;
									}
?>
										</select>
								
								<select size="1" name="YEAR" id="YEAR" style="width: 80px; display: inline;">
										<?php
									$yearq = date("Y");
									while($yearq >= 2008)
									{
										if($year == $yearq)
											$selected = " selected";
										else
											$selected = "";
										echo "<option$selected>$yearq</option>";
										$yearq--;
									}
?>
								</select></td>
						
						<td><strong>Report End Date</strong><br />
										<select name="MONTH2" size="1" id="MONTH2" style="width: 80px; display: inline;">
												<?php
						$query = "SELECT ID, NAME FROM months";
						$result = mysql_query($query) or die ("error1" . mysql_error());
						while($row = mysql_fetch_array($result))
						{
							$monthq = $row['ID'];
							$monthname = $row['NAME'];
							if($month2 == $monthq)
								$selected = " selected";
							else
								$selected = "";
							echo "<option value=\"$monthq\"$selected>$monthname</option>";
						}
?>
										</select>
										<select name="DAY2" size="1" id="DAY2" style="width:65px;  display: inline;">
												<?php
									$day_count = 1;
									while($day_count <= 31)
									{
										if($day2 == $day_count)
											$selected = "selected";
										else 
											$selected = "";
										echo "<option $selected>$day_count</option>";
										$day_count++;
									}
?>
										</select>
								
								<select name="YEAR2" size="1" id="YEAR2" style="width: 80px; display: inline;">
										<?php
									$yearq = date("Y");
									while($yearq >= 2008)
									{
										if($year2 == $yearq)
											$selected = " selected";
										else
											$selected = "";
										echo "<option$selected>$yearq</option>";
										$yearq--;
									}
?>
								</select></td>
				</tr>
				<tr><td colspan="2"><input name="BUTTON" type="submit" id="BUTTON" value=" Run Report " style="width: 100px;" /></td></tr>
		</table>
	</form>
<?
$days = number_format(daysDuration($start,$end));
	$start = timezonereverse($start.' 00:00:00');
	
	$end = timeZoneReverse($end." 23:59:59");
	//echo '<br />'.$end;
?>