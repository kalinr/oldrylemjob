<?

function outputPack($packItemRow) {

  global $theSortedArr, $allTheGridItems, $i, $groupCounter, $sumCounter, $alreadyDisplayedItems, $cart_array, $account;

  $groupCounter = 0;
  $row = $packItemRow;
  $alreadyDisplayedItems[]= $row['ID'];
  $packItemId = $row['ID'];
  
  $query = "SELECT * FROM products_inpack WHERE PACK_PRODUCTID=" . $packItemId;
  $result = mysql_query($query) or die ("error1" . mysql_error());
  $packItemsIds = array();
  while ($data = mysql_fetch_assoc($result)) {
    $packItemsIds[]= $data['PRODUCTID'];  
  }

  echo '<div class="clr"></div>';

  // first output the parent item
  if(!file_exists("images/products/".$row['ID'].".jpg")) { $img_filename = "0.jpg"; }
  else { $img_filename = $row['ID'].".jpg"; }

  $i = $i + 1;
  $descr = stripslashes($row['DESCRIPTION']);
  $pic = "'/images/products/".$img_filename."'";
  $pic = $pic." style='width:50px;float:left;margin-right:15px;margin-bottom:20px'";
  $text0 = "".$pic." />";
  $text1 = $descr;
  $itempopup = "<img src=".$pic." >".$text1;		
  $itempopup = str_replace("<p>","",$itempopup);
  $itempopup = str_replace("</p>","<br />",$itempopup);
  
  if($row['COLOR'] != "") { $itempopup .= "<br /><b>COLOR: &nbsp;".$row['COLOR']."</b>"; }
  
  $qty = 0;
  $productid = $row['ID'];
  if ($cart_array[$productid]['quantity'] != "") { $qty = $cart_array[$productid]['quantity']; }
  else { $qty = 0; }

  echo '<div class="productStyle2">',      
       '<div class="productImgHldr">',
       '<a class="tooltip2" title="', stripslashes($itempopup), '"><img src="/images/products/', $img_filename, '" alt="', stripslashes($row['NAME']), '" /></a></div>',
       '<span class="productname">', stripslashes($row['NAME']), '</span>';
       
       if ($row['COLOR'] != ""){ 
         echo '<br /><span class="productclr">'.$row['COLOR'] . '</span>'; 
       }
  
  echo '<br /><span class="skustyle">', stripslashes($row['SKU']), '</span>',
       '<br /><span class="pricestyle">$';
       
       if (2<=$account['TYPEID'] AND $account['TYPEID'] <= 5) { 
         
         echo number_format(getDiscountedCost($row['WHOLESALE_COST'],$productid,$account['DISCOUNT']),2); 
       
       }
       
       else { echo number_format($row['RETAIL_COST'],2); } 
   
  echo ' each</span>';

  echo '<div class="qtyblock">',      
        '<div class="quantityarea">',
        '<input maxlength="3" class="qtybox" name="QUANTITY[]" id="qty', $i, '" onfocus="this.select()" onkeypress="return goodchars(event,\'0123456789\')" type="text" value="', $qty, '" />
        <input type="hidden" name="PRODUCTID[]" value="', $row['ID'], '" /></div>',
        '<div style="float:left;"><a href="javascript:void(0)"><img alt="Increase Quantity" onclick="up(\'qty', $i, '\')" src="/images/uparrow.png" style="margin-bottom:2px" /></a><br /><a href="javascript:void(0)"><img onclick="down(\'qty', $i, '\')" alt="Reduce Quantity" src="/images/downarrow.png" /></a></div></div></div>';
	
   $sumCounter++;

   // loop through and pull out the individual items        
   for ($x=0; $x<$allTheGridItems; $x++) {

      $row = $theSortedArr[$x];
      $alreadyDisplayedItems[]= $row['ID'];
      
      if (!in_array($row['ID'], $packItemsIds)) { continue; }
  
      if(!file_exists("images/products/".$row['ID'].".jpg")) { $img_filename = "0.jpg"; }
      else { $img_filename = $row['ID'].".jpg"; }

      $i = $i + 1;
      $descr = stripslashes($row['DESCRIPTION']);
      $pic = "'/images/products/".$img_filename."'";
      $pic = $pic." style='width:50px;float:left;margin-right:15px;margin-bottom:20px'";
      $text0 = "".$pic." />";
      $text1 = $descr;
      $itempopup = "<img src=".$pic." >".$text1;		
      $itempopup = str_replace("<p>","",$itempopup);
      $itempopup = str_replace("</p>","<br />",$itempopup);
  
      if($row['COLOR'] != "") { $itempopup .= "<br /><b>COLOR: &nbsp;".$row['COLOR']."</b>"; }
  
      $qty = 0;
      $productid = $row['ID'];
      if ($cart_array[$productid]['quantity'] != "") { $qty = $cart_array[$productid][  'quantity']; }
      else { $qty = 0; }

      echo '<div class="productStyle2">',      
           '<div class="productImgHldr">',
           '<a class="tooltip2" title="', stripslashes($itempopup), '"><img src="/images/products/', $img_filename, '" alt="', stripslashes($row['NAME']), '" /></a></div>',
           '<span class="productname">', stripslashes($row['NAME']), '</span>';
       
           if ($row['COLOR'] != ""){ 
             echo '<br /><span class="productclr">'.$row['COLOR'] . '</span>'; 
           }
  
      echo '<br /><span class="skustyle">', stripslashes($row['SKU']), '</span>',
           '<br /><span class="pricestyle">$';
       
           if (2<=$account['TYPEID'] AND $account['TYPEID'] <= 5) { 
         
             echo number_format(getDiscountedCost($row['WHOLESALE_COST'],$productid,$account['DISCOUNT']),2); 
       
           }
       
           else { echo number_format($row['RETAIL_COST'],2); } 
   
         echo ' each</span>';

         echo '<div class="qtyblock">',      
          '<div class="quantityarea">',
          '<input maxlength="3" class="qtybox" name="QUANTITY[]" id="qty', $i, '" onfocus="this.select()" onkeypress="return goodchars(event,\'0123456789\')" type="text" value="', $qty, '" />
          <input type="hidden" name="PRODUCTID[]" value="', $row['ID'], '" /></div>',
          '<div style="float:left;"><a href="javascript:void(0)"><img alt="Increase Quantity" onclick="up(\'qty', $i, '\')" src="/images/uparrow.png" style="margin-bottom:2px" /></a><br /><a href="javascript:void(0)"><img onclick="down(\'qty', $i, '\')" alt="Reduce Quantity" src="/images/downarrow.png" /></a></div></div></div>';
	
      $sumCounter++;  
  
  }
  
  $groupCounter = 0;
    
  echo '<div class="clr"></div><p class="rt" style="margin-bottom:55px;border-bottom:0"><input type="image" src="/images/add-to-cart.png" name="BUTTON" alt="Submit Form" /></p>';

}


function outputCollection($row) {

  global $i, $cart_array, $account, $wholesaleonlyfilter;

  // first output the parent item
  if(!file_exists("images/products/".$row['ID'].".jpg")) { $img_filename = "0.jpg"; }
  else { $img_filename = $row['ID'].".jpg"; }

  $i = $i + 1;
  $descr = stripslashes($row['DESCRIPTION']);
  $pic = "'/images/products/".$img_filename."'";
  $pic = $pic." style='width:50px;float:left;margin-right:15px;margin-bottom:20px'";
  $text0 = "".$pic." />";
  $text1 = $descr;
  $itempopup = "<img src=".$pic." >".$text1;		
  $itempopup = str_replace("<p>","",$itempopup);
  $itempopup = str_replace("</p>","<br />",$itempopup);
  
  if($row['COLOR'] != "") { $itempopup .= "<br /><b>COLOR: &nbsp;".$row['COLOR']."</b>"; }
  
  $qty = 0;
  $productid = $row['ID'];
  if ($cart_array[$productid]['quantity'] != "") { $qty = $cart_array[$productid]['quantity']; }
  else { $qty = 0; }

  echo '<div class="productStyle2">',      
       '<div class="productImgHldr">',
       '<a class="tooltip2" title="', stripslashes($itempopup), '"><img src="/images/products/', $img_filename, '" alt="', stripslashes($row['NAME']), '" /></a></div>',
       '<span class="productname">', stripslashes($row['NAME']), '</span>';
       
       if ($row['COLOR'] != ""){ 
         echo '<br /><span class="productclr">'.$row['COLOR'] . '</span>'; 
       }
  
  echo '<br /><span class="skustyle">', stripslashes($row['SKU']), '</span>',
       '<br /><span class="pricestyle">$';
       
       if (2<=$account['TYPEID'] AND $account['TYPEID'] <= 5) { 
         
         echo number_format(getDiscountedCost($row['WHOLESALE_COST'],$productid,$account['DISCOUNT']),2); 
       
       }
       
       else { echo number_format($row['RETAIL_COST'],2); } 
   
  echo ' each</span>';

  echo '<div class="qtyblock">',      
        '<div class="quantityarea">',
        '<input maxlength="3" class="qtybox" name="QUANTITY[]" id="qty', $i, '" onfocus="this.select()" onkeypress="return goodchars(event,\'0123456789\')" type="text" value="', $qty, '" />
        <input type="hidden" name="PRODUCTID[]" value="', $row['ID'], '" /></div>',
        '<div style="float:left;"><a href="javascript:void(0)"><img alt="Increase Quantity" onclick="up(\'qty', $i, '\')" src="/images/uparrow.png" style="margin-bottom:2px" /></a><br /><a href="javascript:void(0)"><img onclick="down(\'qty', $i, '\')" alt="Reduce Quantity" src="/images/downarrow.png" /></a></div></div></div>';
    
  // pack content
  $query = "SELECT * FROM products_inpack JOIN brands_products ON brands_products.PRODUCTID=products_inpack.PRODUCTID WHERE products_inpack.PACK_PRODUCTID='" . $row['ID'] . "' ORDER BY brands_products.PRODUCTSORT ASC";
  $result = mysql_query($query) or die ("error1" . mysql_error());
  while ($data = mysql_fetch_assoc($result)) {

    $packItemQry = "SELECT * FROM products, brands_products WHERE (LAYOUTID='2' OR LAYOUTID2='2') AND products.ID=brands_products.PRODUCTID AND products.ACTIVE='1'" . $wholesaleonlyfilter . " AND products.ID='" . $data['PRODUCTID'] . "'";
    $packItemRes = mysql_query($packItemQry);
    $row = mysql_fetch_assoc($packItemRes); 
    
    if(!file_exists("images/products/".$row['ID'].".jpg")) { $img_filename = "0.jpg"; }
    else { $img_filename = $row['ID'].".jpg"; }

    $i = $i + 1;
    $descr = stripslashes($row['DESCRIPTION']);
    $pic = "'/images/products/".$img_filename."'";
    $pic = $pic." style='width:50px;float:left;margin-right:15px;margin-bottom:20px'";
    $text0 = "".$pic." />";
    $text1 = $descr;
    $itempopup = "<img src=".$pic." >".$text1;		
    $itempopup = str_replace("<p>","",$itempopup);
    $itempopup = str_replace("</p>","<br />",$itempopup);
  
    if($row['COLOR'] != "") { $itempopup .= "<br /><b>COLOR: &nbsp;".$row['COLOR']."</b>"; }
  
    $qty = 0;
    $productid = $row['ID'];
    if ($cart_array[$productid]['quantity'] != "") { $qty = $cart_array[$productid][  'quantity']; }
    else { $qty = 0; }

    echo '<div class="productStyle2">',      
         '<div class="productImgHldr">',
         '<a class="tooltip2" title="', stripslashes($itempopup), '"><img src="/images/products/', $img_filename, '" alt="', stripslashes($row['NAME']), '" /></a></div>',
         '<span class="productname">', stripslashes($row['NAME']), '</span>';
       
         if ($row['COLOR'] != ""){ 
           echo '<br /><span class="productclr">'.$row['COLOR'] . '</span>'; 
         }
  
    echo '<br /><span class="skustyle">', stripslashes($row['SKU']), '</span>',
         '<br /><span class="pricestyle">$';
       
         if (2<=$account['TYPEID'] AND $account['TYPEID'] <= 5) { 
         
           echo number_format(getDiscountedCost($row['WHOLESALE_COST'],$productid,$account['DISCOUNT']),2); 
       
         }
       
         else { echo number_format($row['RETAIL_COST'],2); } 
   
   echo ' each</span>';

   echo '<div class="qtyblock">',      
        '<div class="quantityarea">',
        '<input maxlength="3" class="qtybox" name="QUANTITY[]" id="qty', $i, '" onfocus="this.select()" onkeypress="return goodchars(event,\'0123456789\')" type="text" value="', $qty, '" />
        <input type="hidden" name="PRODUCTID[]" value="', $row['ID'], '" /></div>',
        '<div style="float:left;"><a href="javascript:void(0)"><img alt="Increase Quantity" onclick="up(\'qty', $i, '\')" src="/images/uparrow.png" style="margin-bottom:2px" /></a><br /><a href="javascript:void(0)"><img onclick="down(\'qty', $i, '\')" alt="Reduce Quantity" src="/images/downarrow.png" /></a></div></div></div>';
  
  }
    
  echo '<div class="clr"></div><p class="rt" style="margin-bottom:55px;border-bottom:0"><input type="image" src="/images/add-to-cart.png" name="BUTTON" alt="Submit Form" /></p>';

}


if (!accountIsRetail($account['ID']))
	{
	//echo "TRACE - Customer is not retail<br>";
	$wholesaleonlyfilter = "";	
	}
	else
	{
	//echo "TRACE - Customer is Retail<br>";	
	$wholesaleonlyfilter = " AND WHOLESALEONLY='0'";
	}

$query = "SELECT * FROM brands WHERE ID='$brandid'";
$result = mysql_query($query) or die ("error1" . mysql_error());
$brand = mysql_fetch_array($result);
if($brand['BANNER'] != "" && file_exists("images/brands/".$brand['BANNER']))
	{
	//echo '<p><img style="width:590px" src="/images/brands/'.$brand['BANNER'].'" alt="'.stripslashes($brand['NAME']).'" /><a title="VIDEOS" href="/videos/'.$brand['MOD_NAME'].'"><img src="/images/video-symbol.gif" style="margin-left:65px;" /></a></p>';
	echo '<p><img style="width:590px" src="/images/brands/'.$brand['BANNER'].'" alt="'.stripslashes($brand['NAME']).'" /></p>';	
	}
else
	{
	//echo '<h1 style="height:79px">'.stripslashes($brand['NAME']).'<a title="VIDEOS" href="/videos/'.$brand['MOD_NAME'].'"><img src="/images/video-symbol.gif" style="float:right;margin-top:-10px" /></a></h1>';
	echo '<h1>'.stripslashes($brand['NAME']).'</h1>';
	}
if($brand['DESCRIPTION'] != "")
	echo '<p>'.stripslashes(nl2br($brand['DESCRIPTION'])).'</p>';
if(!$has_products)
	echo '<p>There are currently no products assigned to '.stripslashes($brand['NAME']).'. Please check back again soon.</p>';
else
{
?>
<form action="/<? echo $content['MOD_NAME']; ?>" method="post">
<? if($qa[0] == "view-display"){ ?>
<?
//this should look like Grid 2
	$query = "SELECT * FROM products, brands_products WHERE (LAYOUTID='5' OR LAYOUTID2='5') AND products.ID=brands_products.PRODUCTID AND brands_products.BRANDID='$brandid' AND products.ACTIVE='1'" . $wholesaleonlyfilter . " ORDER BY brands_products.PRODUCTSORT ASC";
	
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$i=0;
	while($row = mysql_fetch_array($result))
	{
		if(!file_exists("images/products/".$row['ID'].".jpg"))
			$img_filename = "0.jpg";
		else
			$img_filename = $row['ID'].".jpg";
			
		//Test size 
		$stylecode = " style='height:110px;margin-bottom:15px;' ";
		$theimage = "images/products/".$img_filename;
		
		//echo width2($theimage);
		//echo " | ".height2($theimage);
		if ($img_filename!="0.jpg")
		{
		if (width2($theimage) > 235)
			{
				$stylecode = " style='width:250px;margin-bottom:15px;' ";
			}
			else
			{
				if (height2($theimage) < 350)
					{
						$stylecode = " style='height:180px;margin-bottom:15px;' ";
					}
			}
		}	
?>
<div id="holderDiv">

  <div style="clear:both;min-height:220px;margin-left:15px;margin-bottom:50px;">
	
  <div style="float:left;margin-right:15px;width:250px;">
    <img class="ctrImg" src="/images/products/<? echo $img_filename; ?>" alt="<? echo stripslashes($row['NAME']), '" ', $stylecode; ?> />
  </div>
	
  <div style="float:left;width:485px;">
  <span class="productname" style="font-weight:bold"><? echo stripslashes($row['NAME']); ?></span><br />
  <? 
	echo stripslashes($row['DESCRIPTION']);
	$qty = 0;
	$productid = $row['ID'];
	if($cart_array[$productid]['quantity'] != "")
		$qty = $cart_array[$productid]['quantity'];	
  ?>
	
    <div style="margin-top: 12px; margin-left:20px; width:240px; text-align:center;">
    <span class="productname" style="font-weight:normal"><? echo stripslashes($row['NAME']); ?></span>
    <? if($row['COLOR'] != ""){ echo '<br /><span class="productclr">' . $row['COLOR'] . '</span>'; } ?>
    <br /><span class="skustyle"><? echo stripslashes($row['SKU']); ?></span>
    <br /><span class="pricestyle">$<? if(2<=$account['TYPEID'] AND $account['TYPEID'] <= 5){ echo number_format(getDiscountedCost($row['WHOLESALE_COST'],$productid,$account['DISCOUNT']),2); }else{ echo number_format($row['RETAIL_COST'],2); } ?> each</span>
    <br />

      <div class="qtyblock">
    
        <div class="quantityarea">
        <input maxlength="3" class="qtybox" name="QUANTITY[]" id="qty<? echo $i; ?>" onfocus="this.select()" onkeypress="return goodchars(event,'0123456789')"  type="text" value="<? echo $qty; ?>" />
	<input type="hidden" name="PRODUCTID[]" value="<? echo $row['ID']; ?>" />
        </div>

        <div style="float:left">			
        <a href="javascript:void(0)"><img alt="Increase Quantity" onclick="up('qty<? echo $i; ?>')" src="/images/uparrow.png" style="margin-bottom:2px" /></a><br />
	<a href="javascript:void(0)"><img onclick="down('qty<? echo $i; ?>')" alt="Reduce Quantity" src="/images/downarrow.png" /></a>	
        </div>

      </div>

      <p><input type="image" src="/images/add-to-cart.png" name="BUTTON" alt="Add to Cart" /></p><br /><br />
	  
    </div>

  </div>

 </div>
	
</div>
<? 
$i=$i+1;
} ?>
<div class="clr"></div>
<? } else if($qa[0] == "view-single") { ?>
<?
//this should look like Grid 2
	$query = "SELECT * FROM products, brands_products WHERE (LAYOUTID='4' OR LAYOUTID2='4') AND products.ID=brands_products.PRODUCTID AND brands_products.BRANDID='$brandid' AND products.ACTIVE='1'" . $wholesaleonlyfilter . " ORDER BY brands_products.PRODUCTSORT ASC";
	//echo $query;
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$i=0;
	while($row = mysql_fetch_array($result))
	{
		if(!file_exists("images/products/".$row['ID'].".jpg"))
			$img_filename = "0.jpg";
		else
			$img_filename = $row['ID'].".jpg";
			
		//Test size 
		$stylecode = " style='height:110px;margin-bottom:15px;' ";
		$theimage = "images/products/".$img_filename;
		
		//echo width2($theimage);
		//echo " | ".height2($theimage);
		if ($img_filename!="0.jpg")
		{
		if (width2($theimage) > 235)
			{
				$stylecode = " style='width:250px;margin-bottom:15px;' ";
			}
			else
			{
				if (height2($theimage) < 350)
					{
						$stylecode = " style='height:180px;margin-bottom:15px;' ";
					}
			}
		}	
?>
<div id="holderDiv">
  
  <div style="clear:both;min-height:220px;margin-left:15px;margin-bottom:50px;">
  
    <div style="float:left;margin-right:15px;width:250px;">
    <img class="ctrImg" src="/images/products/<? echo $img_filename; ?>" alt="<? echo stripslashes($row['NAME']), '" ', $stylecode; ?> />
    </div>

    <div style="float:left;width:485px;">
    <span class="productname" style="font-weight:bold"><? echo stripslashes($row['NAME']); ?></span><br />
    <? 
    echo stripslashes($row['DESCRIPTION']);
    $qty = 0;
    $productid = $row['ID'];
    if($cart_array[$productid]['quantity'] != "")
	$qty = $cart_array[$productid]['quantity'];	
    ?>
    
     <div style="margin-top: 12px; margin-left:20px; width:240px; text-align: center;">
     <span class="productname" style="font-weight:normal"><? echo stripslashes($row['NAME']); ?></span>
     <? if($row['COLOR'] != ""){ echo '<br /><span class="productclr">' . $row['COLOR'] . '</span>'; } ?>
     <br /><span class="skustyle"><? echo stripslashes($row['SKU']); ?></span>
     <br /><span class="pricestyle">$<? if(2<=$account['TYPEID'] AND $account['TYPEID'] <= 5){ echo number_format(getDiscountedCost($row['WHOLESALE_COST'],$productid,$account['DISCOUNT']),2); }else{ echo number_format($row['RETAIL_COST'],2); } ?> each</span>
     <br />

      <div class="qtyblock">

        <div class="quantityarea">
        <input maxlength="3" class="qtybox" name="QUANTITY[]" id="qty<? echo $i; ?>" onfocus="this.select()" onkeypress="return goodchars(event,'0123456789')" type="text" value="<? echo $qty; ?>" />
        <input type="hidden" name="PRODUCTID[]" value="<? echo $row['ID']; ?>" />			
        </div>

        <div style="float:left">			
        <a href="javascript:void(0)"><img alt="Increase Quantity" onclick="up('qty<? echo $i; ?>')" src="/images/uparrow.png" style="margin-bottom:2px" /></a><br />
        <a href="javascript:void(0)"><img onclick="down('qty<? echo $i; ?>')" alt="Reduce Quantity" src="/images/downarrow.png" /></a>
        </div>

      </div>
    
      <p><input type="image" src="/images/add-to-cart.png" name="BUTTON" alt="Add to Cart" /></p><br /><br />

     </div>

    </div>
     
  </div>

</div>
<? 
$i=$i+1;
} ?>
<div class="clr"></div>
<? } else if($qa[0] == "no-view") { ?>
<?
	$query = "SELECT * FROM products, brands_products WHERE (LAYOUTID='3' OR LAYOUTID2='3') AND products.ID=brands_products.PRODUCTID AND brands_products.BRANDID='$brandid' AND products.ACTIVE='1'" . $wholesaleonlyfilter . " ORDER BY brands_products.PRODUCTSORT ASC";
	$result = mysql_query($query) or die ("error1" . mysql_error());
	$i=0;
	while($row = mysql_fetch_array($result))
	{
		if(!file_exists("images/products/".$row['ID'].".jpg"))
			$img_filename = "0.jpg";
		else
			$img_filename = $row['ID'].".jpg";
			
		$descr = stripslashes($row['DESCRIPTION']);
		$pic = "'/images/products/".$img_filename."'";
		$pic = $pic." style='width:50px;float:left;margin-right:15px'";
		$text0 = "".$pic." />";
		//$text1 = $descr."<br /><br /><strong>".stripslashes($row['NAME']). " Quick Facts</strong><br />".$row['BULLET_FEATURE1'];
		$text1 = $descr;		
		//$text2 = $row['BULLET_FEATURE2'];
		//$text3 = $row['BULLET_FEATURE3'];
		//$text4 = $row['BULLET_FEATURE4'];
		//$text5 = $row['BULLET_FEATURE5'];
		//$itempopup = "<img src=".$pic." >".$text1."&nbsp;".$text2."&nbsp;".$text3."&nbsp;".$text4."&nbsp;".$text5;	
		$itempopup = "<img src=".$pic." >".$text1;		
		$itempopup = str_replace("<p>","",$itempopup);
		$itempopup = str_replace("</p>","<br /><br />",$itempopup);		
		
	$qty = 0;
	$productid = $row['ID'];
	if($cart_array[$productid]['quantity'] != "")
		$qty = $cart_array[$productid]['quantity'];			
?>
<div class="productStyle1">
	<a class="tooltip2" title="<? echo stripslashes($itempopup); ?>"><img src="/images/products/<? echo $img_filename; ?>" alt="<? echo stripslashes($row['NAME']); ?>" <?php $imgSize = getimagesize('images/products/' . $img_filename); if ($imgSize[0] > 400) { echo 'style="width: 235px; max-width: 235px;"'; } ?> /></a>
	<p>
	<span class="productname"><? echo stripslashes($row['NAME']); ?></span>
	<? if($row['COLOR'] != ""){ echo '<br /><span class="productclr">' . $row['COLOR'] . '</span>'; } ?>
	<br /><span class="skustyle"><? echo stripslashes($row['SKU']); ?></span>
	<br /><span class="pricestyle">$<? if(2<=$account['TYPEID'] AND $account['TYPEID'] <= 5){ echo number_format(getDiscountedCost($row['WHOLESALE_COST'],$productid,$account['DISCOUNT']),2); }else{ echo number_format($row['RETAIL_COST'],2); } ?> each</span>
	<br />
	</p>

	  <div class="qtyblock">
		<div class="quantityarea">
			<input maxlength="3" class="qtybox" name="QUANTITY[]" id="qty<? echo $i; ?>" onfocus="this.select()" onkeypress="return goodchars(event,'0123456789')"  type="text" value="<? echo $qty; ?>" />
			<input type="hidden" name="PRODUCTID[]" value="<? echo $row['ID']; ?>" />
		</div>

		<div style="float:left;">			
			<a href="javascript:void(0)"><img alt="Increase Quantity" onclick="up('qty<? echo $i; ?>')" src="/images/uparrow.png" style="margin-bottom:2px" /></a><br />
			<a href="javascript:void(0)">
			<img onclick="down('qty<? echo $i; ?>')" alt="Reduce Quantity" src="/images/downarrow.png" /></a>	
		</div>
	  </div>
	</div>
<? 
	$i=$i+1;
	}
?>
<div class="clr"></div>
<p class="rt"><input type="image" src="/images/add-to-cart.png" name="BUTTON" alt="Submit Form" /></p>
<? } else if ($qa[0] == "view-grid") {

  $i=0;

  // if dealing with a collection path differently
  if (isset($qa[1]) && !empty($qa[1])) {

    $nameQry = "SELECT NAME FROM products WHERE ID=" . $qa[1];
    $nameRes = mysql_query($nameQry);
    $nameData = mysql_fetch_assoc($nameRes);  
  
    $packQry = "SELECT * FROM products, brands_products WHERE (LAYOUTID='2' OR LAYOUTID2='2') AND products.ID=brands_products.PRODUCTID AND brands_products.BRANDID='$brandid' AND products.ACTIVE='1'" . $wholesaleonlyfilter . " AND products.NAME LIKE '%" . $nameData['NAME'] . "%' AND products.PACK=1 ORDER BY brands_products.PRODUCTSORT ASC";  
    $packRes = mysql_query($packQry);
    $allThePacks = mysql_num_rows($packRes);
  
    while ($row = mysql_fetch_assoc($packRes)) {  
      outputCollection($row);
    }
  
  }
  
  else {

    $query = "SELECT * FROM products, brands_products WHERE (LAYOUTID='2' OR LAYOUTID2='2') AND products.ID=brands_products.PRODUCTID AND brands_products.BRANDID='$brandid' AND products.ACTIVE='1'" . $wholesaleonlyfilter . " ORDER BY brands_products.PRODUCTSORT ASC";

    $result = mysql_query($query) or die ("error1" . mysql_error());

    $combinedArr = array();

    // build an array with all the products
    while ($row = mysql_fetch_assoc($result)) {
      $combinedArr[]= $row;
    }

    $theSortedArr = array_orderby($combinedArr, 'PRODUCTSORT', SORT_NUMERIC);
    $groupCounter = 0;
    $sumCounter = 0;
    $allTheGridItems = count($theSortedArr);
    $alreadyDisplayedItems = array();
    
    for ($x=0; $x<$allTheGridItems; $x++) {

      $row = $theSortedArr[$x];
  
      // check to see if it is a pack
      if ($row['PACK'] == '1') {
      
        outputPack($row);
        continue;

      }
  
      // prevent items shown with packs from outputting individually
      if (in_array($row['ID'], $alreadyDisplayedItems)) { continue; }

      if(!file_exists("images/products/".$row['ID'].".jpg")) { $img_filename = "0.jpg"; }
      else { $img_filename = $row['ID'].".jpg"; }

      $i = $i + 1;
      $descr = stripslashes($row['DESCRIPTION']);
      $pic = "'/images/products/".$img_filename."'";
      $pic = $pic." style='width:50px;float:left;margin-right:15px;margin-bottom:20px'";
      $text0 = "".$pic." />";
      $text1 = $descr;
      $itempopup = "<img src=".$pic." >".$text1;		
      $itempopup = str_replace("<p>","",$itempopup);
      $itempopup = str_replace("</p>","<br />",$itempopup);
  
      if($row['COLOR'] != "") { $itempopup .= "<br /><b>COLOR: &nbsp;".$row['COLOR']."</b>"; }
  
      $qty = 0;
      $productid = $row['ID'];
      if ($cart_array[$productid]['quantity'] != "") { $qty = $cart_array[$productid]['quantity']; }
      else { $qty = 0; }

?>

    <div class="productStyle2">
      
      <div class="productImgHldr">
      <a class="tooltip2" title="<? echo stripslashes($itempopup); ?>"><img src="/images/products/<? echo $img_filename; ?>" alt="<? echo stripslashes($row['NAME']); ?>" /></a>
      </div>

      <span class="productname"><? echo stripslashes($row['NAME']); ?></span>
      <? if($row['COLOR'] != ""){ echo '<br /><span class="productclr">'.$row['COLOR'] . '</span>'; } ?>
      <br /><span class="skustyle"><? echo stripslashes($row['SKU']); ?></span>
      <? /*  First parent  product in row */ ?>
      <br /><span class="pricestyle">$<? if(2<=$account['TYPEID'] AND $account['TYPEID'] <= 5){ echo number_format(getDiscountedCost($row['WHOLESALE_COST'],$productid,$account['DISCOUNT']),2); }else{ echo number_format($row['RETAIL_COST'],2); } ?> each</span>      

      <div class="qtyblock">
      
        <div class="quantityarea">
        <input maxlength="3" class="qtybox" name="QUANTITY[]" id="qty<? echo $i; ?>" onfocus="this.select()" onkeypress="return goodchars(event,'0123456789')" type="text" value="<? echo $qty; ?>" />
        <input type="hidden" name="PRODUCTID[]" value="<? echo $row['ID']; ?>" />
        </div>

        <div style="float:left;">			
        <a href="javascript:void(0)"><img alt="Increase Quantity" onclick="up('qty<? echo $i; ?>')" src="/images/uparrow.png" style="margin-bottom:2px" /></a><br /><a href="javascript:void(0)"><img onclick="down('qty<? echo $i; ?>')" alt="Reduce Quantity" src="/images/downarrow.png" /></a>	
        </div>
     
     </div>
   
   </div>  

<?php
	
      $groupCounter++;
      $sumCounter++;
  
      if ($groupCounter == 6 || $sumCounter == $allTheGridItems) {
  
        $groupCounter = 0;
        
        echo '<div class="clr"></div><p class="rt" style="margin-bottom:55px;border-bottom:0"><input type="image" src="/images/add-to-cart.png" name="BUTTON" alt="Submit Form" /></p>';
  
      }	

      $alreadyDisplayedItems[]= $row['ID'];

     }
  
  }

} else { ?>
<? if($qa[0] == "color-swatch"){ ?>
<a name="swatch"></a>
<div class="individualcolorswrapper">
<?
/*
1.       full size pad
2.       dewdrop or 1" cube
3.       Inker
4.       Marker
*/
$i=0;
$count = 0;
$inline_array[0] = "";
//kit
$query = "SELECT products.*,brands_products.* FROM products, brands_products WHERE products.ID=brands_products.PRODUCTID AND brands_products.BRANDID='$brandid' AND (products.LAYOUTID='1' OR products.LAYOUTID2='1') AND products.HEX_COLOR LIKE '".strtoupper($qa[1])."' AND (products.NAME LIKE '%kit%' || products.NAME LIKE '%pad%' || products.DESCRIPTION LIKE '%dewdrop%' || products.NAME LIKE '%dew drop%' || products.NAME LIKE '%inker%' || products.NAME LIKE '%ink%' || products.NAME LIKE '%marker%' || products.NAME LIKE '%bottle%' || products.NAME LIKE '%jar%' || products.NAME LIKE '%spray%' || products.NAME LIKE '%embellish%' || products.NAME LIKE '%stazon%') AND products.ACTIVE='1'" . $wholesaleonlyfilter . " ORDER BY brands_products.PRODUCTSORT ASC";
$result = mysql_query($query) or die ("error 1" . mysql_error());
while($row = mysql_fetch_array($result))
{
	if($row['ID'] != "")
	{
		$inline_array[$count] = $row;
		$count++;
	}
}

if($count == 0) ///still needs to be addressed (see below)
{
	$query = "SELECT * FROM products, brands_products WHERE products.ID=brands_products.PRODUCTID AND brands_products.BRANDID='$brandid' AND products.HEX_COLOR LIKE '".strtoupper($qa[1])."' AND products.ACTIVE='1'" . $wholesaleonlyfilter . " ORDER BY brands_products.PRODUCTSORT ASC";
$result = mysql_query($query) or die ("error1" . mysql_error());
$row = mysql_fetch_array($result);
if($row['ID'] != "")
{
	if($row['ID'] != "" && !productInView($row['ID'],$inline_array))
	{
		$inline_array[$count] = $row;
		$count++;
	}
}
}
//echo '<pre>';
//print_r($inline_array);
//echo '</pre>';
if($count > 0) {

  $theSortedArr = array_orderby($inline_array, 'PRODUCTSORT', SORT_NUMERIC);

  foreach($theSortedArr as $row) {

	$i=$i+1;
	
	if(file_exists("images/products/".$row['ID'].".jpg"))
		$img_filename = $row['ID'].".jpg";
	else
		$img_filename = "0.jpg";
	
	$descr = stripslashes($row['DESCRIPTION']);
	$pic = "'/images/products/".$img_filename."'";
	$pic = $pic." style='width:50px;float:left;margin-right:15px'";
	$text0 = "".$pic." />";
	$text1 = $descr;
	$itempopup = "<img src=".$pic." >".$text1;
	$itempopup = str_replace("<p>","",$itempopup);
	$itempopup = str_replace("</p>","<br /><br />",$itempopup);
	
	$qty = 0;
	$productid = $row['ID'];
	if($cart_array[$productid]['quantity'] != "")
		$qty = $cart_array[$productid]['quantity'];	
		
	//SWATCH	
	if($row['COLOR'] != "")
		$itempopup .= "<b>COLOR: &nbsp;".stripslashes($row['COLOR'])."</b>";
		
?>
	
	<div class="productrow">
	<a class="tooltip2" title="<? echo stripslashes($itempopup); ?>">
	<img class="ctrImg" src="/images/products/<? echo $img_filename; ?>" 
	alt="<? echo stripslashes($row['NAME']); ?>" /></a>
	<br />
	<span class="productname"><? echo stripslashes($row['NAME']); ?></span>
	<? if($row['COLOR'] != ""){ echo '<br /><span class="productclr">'.stripslashes($row['COLOR']) . '</span>'; } ?>
	<br /><span class="skustyle"><? echo stripslashes($row['SKU']); ?></span>
	<br /><span class="pricestyle">$<? if(2<=$account['TYPEID'] AND $account['TYPEID'] <= 5){ echo number_format(getDiscountedCost($row['WHOLESALE_COST'],$productid,$account['DISCOUNT']),2); }else{ echo number_format($row['RETAIL_COST'],2); } ?> each</span>
	<br />

	  <div class="qtyblock">
		<div class="quantityarea">
			<input maxlength="3" class="qtybox" name="QUANTITY[]" id="qty<? echo $i; ?>" onfocus="this.select()" onkeypress="return goodchars(event,'0123456789')" type="text" value="<? echo $qty; ?>" />
			<input type="hidden" name="PRODUCTID[]" value="<? echo $row['ID']; ?>" />

		</div>

		<div style="float:left;">			
			<a href="javascript:void(0)"><img alt="Increase Quantity" onclick="up('qty<? echo $i; ?>')" src="/images/uparrow.png" style="margin-bottom:2px" /></a><br />
			<a href="javascript:void(0)">
			<img onclick="down('qty<? echo $i; ?>')" alt="Reduce Quantity" src="/images/downarrow.png" /></a>	
		</div>
	  </div>
	
	</div>

<? } } ?>
<div class="clr"></div>
	<p class="rt"><input type="image" src="/images/add-to-cart.png" name="BUTTON" alt="Submit Form" /></p>
</div>
<? } ?>
<div class="swatchwrapper">
<?
$query = "SELECT * FROM products, brands_products WHERE products.ID=brands_products.PRODUCTID AND brands_products.BRANDID='$brandid' AND products.HEX_COLOR != '' AND (products.LAYOUTID='1' OR products.LAYOUTID='2' OR products.LAYOUTID2='1' OR products.LAYOUTID2='2') AND products.ACTIVE='1'".$wholesaleonlyfilter." GROUP BY HEX_COLOR";
$result = mysql_query($query) or die ("error1" . mysql_error());
while($row = mysql_fetch_array($result))
{
	$displaycolorpopup = stripslashes($row['COLOR'])." - ".substr($row['SKU'], -3);
	echo '<a href="/'.$content['MOD_NAME'].'/color-swatch/'.$row['HEX_COLOR'].'#swatch" class="tooltip" title="'.$displaycolorpopup.'">';
	echo '<span class="swatchcolor" style="background:#'.stripslashes($row['HEX_COLOR']).'">';
	echo '</span>';
	echo '</a>';
}
?>
</div>
<div class="clr"></div>
<?php if (productHasCollection($product['ID'], $brandid)) { 

  $query = "SELECT products.*, brands_collections.DISPLAY_TITLE FROM products, brands_collections WHERE '$brandid'=brands_collections.BRANDID AND brands_collections.PRODUCTID=products.ID  AND ACTIVE='1'".$wholesaleonlyfilter." ORDER BY TOP_ORDER";
  $result = mysql_query($query) or die ("error1" . mysql_error());
  
  if (mysql_num_rows($result) > 0) {

    echo '<div class="productSeparator"></div>', "\n";
    echo '<h2 class="collectionshead">', $content['TITLE'], ' Collections</h2>', "\n";
    echo '<div class="individualcolorswrapper">', "\n";
  
  }

  while ($row = mysql_fetch_array($result)) {

    if(!file_exists("images/products/".$row['ID'].".jpg")) { $img_filename = "0.jpg"; }
    else { $img_filename = $row['ID'].".jpg"; }
			
    if($row['LAYOUTID'] == 5 or $row['LAYOUTID2'] == 5) { //view single
      $url = "/".productBrandIdToMod($row['ID'])."/view-display/".$row['ID'];
    }
    else if ($row['LAYOUTID'] == 4 or $row['LAYOUTID2'] == 4) { //view single
      $url = "/".$content['MOD_NAME']."/view-single/".$row['ID'];
    }
    else if($row['LAYOUTID'] == 3 OR $row['LAYOUTID2'] == 3) { //no group or view
      $url = "/".$content['MOD_NAME']."/no-view/".$row['ID'];
    }
    else if($qa[0] != "color-swatch" && ($row['LAYOUTID'] == 1 OR $row['LAYOUTID2'] == 1)) { //swatch
      $url = "/".productBrandIdToMod($row['ID']);
    }
    else { //inline display
      $url = "/".$content['MOD_NAME']."/view-grid/".$row['ID']; 
    }

    echo '<div class="collectionsrow"><a href="', $url, '" class="collectionslink">';
    echo '<img class="ctrImg" src="/images/products/', $img_filename, '" alt="', stripslashes($row['DISPLAY_TITLE']), '" height="110" /><br />';
    echo '<span class="productname">', stripslashes($row['DISPLAY_TITLE']), '</span></a></div>';
	
  } 

  if (mysql_num_rows($result) > 0) {

    echo "\n", '</div>', "\n";
    echo '<div class="clr"></div>', "\n";
  
  }

}

}

if(productHasRelatedProducts($product['ID'], $brandid)){ ?>

<div class="productSeparator"></div>
<h2 class="collectionshead" style="margin-top:0">Related Products</h2>
<div class="individualcolorswrapper">
<?
$query = "SELECT products.*, brands_related.DISPLAY_TITLE FROM products, brands_related WHERE '$brandid'=brands_related.BRANDID AND brands_related.PRODUCTID=products.ID  AND ACTIVE='1'".$wholesaleonlyfilter." ORDER BY TOP_ORDER";
$result = mysql_query($query) or die ("error1" . mysql_error());
while($row = mysql_fetch_array($result))
{
	if(!file_exists("images/products/".$row['ID'].".jpg"))
		$img_filename = "0.jpg";
	else
		$img_filename = $row['ID'].".jpg";
			
	//echo "A".$row['LAYOUTID'];
	if($row['LAYOUTID'] == 5 or $row['LAYOUTID2'] == 5) //view single
		$url = "/".productBrandIdToMod($row['ID'])."/view-display/".$row['ID'];
	else if($row['LAYOUTID'] == 4 or $row['LAYOUTID2'] == 4) //view single
		$url = "/".productBrandIdToMod($row['ID'])."/view-single/".$row['ID'];
	else if($row['LAYOUTID'] == 3 OR $row['LAYOUTID2'] == 3) //no group or view
		$url = "/".productBrandIdToMod($row['ID'])."/no-view/".$row['ID'];
	else if($row['LAYOUTID'] == 1 OR $row['LAYOUTID2'] == 1) //swatch
		$url = "/".productBrandIdToMod($row['ID']);
	else //inline display
		$url = "/".productBrandIdToMod($row['ID'])."/view-grid/".$row['ID']; 
?>

	<div class="collectionsrow">
	<a href="<? echo $url; ?>" class="collectionslink">	
	<img class="ctrImg" src="/images/products/<? echo $img_filename; ?>" alt="<? echo stripslashes($row['DISPLAY_TITLE']); ?>" height="110" /><br />
	<span class="productname"><? echo stripslashes($row['DISPLAY_TITLE']); ?></span>
	</a>
	</div>
	
<? } ?>
</div>
<div style="clear: both;"></div>
<? } ?>
</form>
<?
}
?>