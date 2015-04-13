<?php if($current_result > 1) { ?>
<div id="prevlabel_table">

<a href="/<? echo $content['MOD_NAME']; ?>/results/<?php echo $current_result-1; ?>"><?php echo '<< Previous'; ?></a>
</div>
<?php } ?>
<div id="pagecount_table">Displaying #
	<?php if($count2 > 0) { echo number_format(DISPLAY_RESULTS*($current_result-1)+1); } else { echo 0; } ?> through <?php echo number_format($count2 + DISPLAY_RESULTS*($current_result-1)); ?> of <?php echo number_format($totalcount); ?>
</div>
<div id="nextlabel_table">
<?php if(DISPLAY_RESULTS*($current_result-1)+$count2 < $totalcount) { ?>
<a href="/<? echo $content['MOD_NAME']; ?>/results/<?php echo $current_result+1; ?>"><?php echo 'Next >>';  ?></a>
<?php } ?>
</div>