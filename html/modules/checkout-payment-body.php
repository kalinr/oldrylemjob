<p>Please continue with your order below. For credit card 
					orders, you will have an opportunity to review your order 
					before it is processed.</p>

					<div id="creditcardbox">
						<form id="myform" method="post" action="/<? echo $content['MOD_NAME']; ?>">
							<p><strong>Credit Card</strong></p>
							<p><img src="/images/visa.png" />
							<img src="/images/master.png" /></p>
	
							<p>Credit Card Number<input type="text" name="CCNUM" value="<? echo format_creditcard($ccnum); ?>" /></p>
							<p style="float:left;margin-right:9px;">Expiration Month<br /><select size="1" name="CCMONTH" style="width:85px;">
							<?php
             	$count = 1;
             	while($count < 13)
             	{
             		$month = $count;
             		if($month < 10)
             			$month = "0" . $month;
             		if($ccmonth == $month)
             			$selected = "selected";
             		else
             			$selected = "";	
                    echo "<option $selected>$month</option>";
                   	$count++;
                }
             ?></select></p> <p style="float:left;margin-right:9px;">Expiration Year<br /><select size="1" name="CCYEAR" style="width:85px"><?php
	$year = date("Y");
	$count =0;
	while($count < 10)
	{
		if($ccyear == $year)
			$selected = "selected";
		else
			$selected = "";
		echo "<option $selected>$year</option>";
		$year++;
		$count++;
	}                      
?></select> </p>
							<p style="float:left;">Security Code<br /><input type="text" id="CCVER" name="CCVER" value="<?php echo stripslashes($ccver); ?>" style="width:60px;padding:7px" /></p>
							<div style="clear: both;"></div>
							<p style="float: left;">Billing Zip Code
							<input type="text" id="CCZIP" name="CCZIP" maxlength="10" value="<?php echo stripslashes($cczip); ?>" style="width:90px;" /></p>
							<? if(!accountIsRetail($account['ID'])){ ?>
							<p style="float: left;">Attach Ref PO # (optional)
							<input type="text" id="PONUMBER" name="PONUMBER" value="<?php echo stripslashes($ponumber); ?>" style="width:90px;" /></p>
							<? } ?>
							<p style="clear:both">
							<input type="submit" NAME="BUTTON" value="Continue with Credit Card" style="width:210px" /></p>
						</form>
			
			</div>
			<? 
			//Eric update 8/30/12  -  No PO option for terms of "Prepaid"
			if(!accountIsRetail($account['ID']) && $account['TERMS_ID']!= '1'  ){ ?>
			
			
			<div id="purchaseorderbox">
				
				<form id="myform" action="/<? echo $content['MOD_NAME']; ?>" method="post">
				<p><strong>Purchase Order</strong> &nbsp;(TERMS: <? echo termsName($account['TERMS_ID']); ?>)</p>
					<p>PO Number<br />
					<input type="text" name="PONUMBER" style="width: 170px;" value="<? echo $ponumber; ?>" /></p>
					<p>
					<input type="submit" NAME="BUTTON" value="Continue with Purchase Order" style="width:210px" /></p>
				</form>
			</div>
			<? } ?>
			<div class="clr"></div>