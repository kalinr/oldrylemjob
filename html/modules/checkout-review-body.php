<?
if($_POST['BUTTON'] == "Process Order")
{
	echo '<p>Please wait while we process your order.<br /><br /><strong>Do not click back or refresh at this time.</strong> &nbsp;You will be automatically redirected once the order process is complete.</p>';
}
else
{ 
?>
	<p>The contents of your shopping cart is below. &nbsp;Simply click on "Process Order" to purchase your items.</p>
			<div style="float: left; width: 300px;">
			<?
			echo '<p><strong>Billing Information</strong><br />'.stripslashes($account['FIRST']).' '.stripslashes($account['LAST']);
			if($account['ORGANIZATION'] != '')
				echo '<br />'.stripslashes($account['ORGANIZATION']);
			echo '<br />'.stripslashes($account['ADDRESS1']);
			if($account['ADDRESS2'] != '')
				echo '<br />'.stripslashes($account['ADDRESS2']);
			echo '<br />'.stripslashes($account['CITY']).', '.stripslashes($account['STATE']).' '.$account['ZIP'];
			echo '<br />'.stripslashes($account['COUNTRY']).'</p>';
			echo '<p>Phone: '.$account['PHONE1'];
			echo '<br />Email: <a href="mailto:'.$account['EMAIL'].'">'.$account['EMAIL'].'</a></p>';
			
			?>
			</div>
			<div style="float: left; width: 300px;">
			<?
			echo '<p><strong>Shipping Information</strong><br />'.stripslashes($shipping['NAME']);
			echo '<br />'.stripslashes($shipping['ADDRESS1']);
			if($shipping['ADDRESS2'] != '')
				echo '<br />'.stripslashes($shipping['ADDRESS2']);
			echo '<br />'.stripslashes($shipping['CITY']).', '.stripslashes($shipping['STATE']).' '.$shipping['ZIP'];
			echo '<br />'.stripslashes($shipping['COUNTRY']).'</p>';
			echo '<p><strong>Payment Method</strong>';
			if($_SESSION['CCNUM'] != '')
			{
				echo '<br />'.cardType($_SESSION['CCNUM']).' xxxx-xxxx-xxxx-'.last4cc($_SESSION['CCNUM']);
				if($_SESSION['PONUMBER'] != ''){ echo ' (REF PO # '.stripslashes($_SESSION['PONUMBER']).')'; }
			}
			else
				echo '<br />PO Number: '.$_SESSION['PONUMBER'];
			echo '<br /><strong>Shipping Method:</strong> '.$_SESSION['SHIPPING_METHOD'];
			echo '<br />'.$_SESSION['SHIP_PARTIAL'];
			echo '</p>';
			?>
			</div>
			<div style="clear: both;"></div>
			<? include("modules/order-review-body.php"); ?>
		
			<form action="/<? echo $content['MOD_NAME']; ?>/0/process" method="post" id="myform">
			<? if(2 <= $account['TYPEID'] AND $account['TYPEID'] <= 5){ ?>
			<p>Questions, comments, or special instructions:<br /><textarea style="width: 80%; height: 100px;" name="COMMENTS"><? echo stripslashes($comments); ?></textarea></p>
			<? } ?>
			<p align="right"><input type="submit" name="BUTTON" value="Process Order"<? /* onclick="this.disabled='disabled'; document.myform.submit();" */ ?> /></p>
			<p align="right"><em>Only click once to prevent duplicate orders.</em></p>
			
			<table width="100%">
 			<tr>
 			  <td width="100%">&nbsp;</td>
 			  <td nowrap="nowrap">
 			  <label><input name="product_announcements" type="checkbox" checked="checked" value="1" /> Receive important new product announcements and information</label><br />
 			  <label><input name="craft_project_ideas" type="checkbox" checked="checked" value="1" /> Receive wonderful craft project ideas through our blog</label>
                          </td>
                        </tr>
                        </table>
			
			</form>
<?
}
?>