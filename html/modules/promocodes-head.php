<? if($qa[1] != ""){ ?>
<script type="text/javascript">
function confirmDelete()
{
	if(confirm("Are you sure you want to delete this promo code?"))
		window.location = "/<? echo $content['MOD_NAME']; ?>/delete/<? echo $qa[1]; ?>";
}
</script>
<? }else{ ?>
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/prototype/1.6.0.3/prototype.js'></script>
<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/scriptaculous/1.8.2/scriptaculous.js'></script>
<script type="text/javascript">
var ajaxWorking = false;
function viewPromocodes()
{
	if(ajaxWorking) {
		clearTimeout(ajaxWorking);
	}
	ajaxWorking = setTimeout(function() {
		$('myform2').request({
			onSuccess:function(transport) {
				var response = transport.responseText;
				$('displayq').update(response);
			}
		});
	},200);
	return false;
}
function changePage(current_result) 
{
	$('myform2').action = '/ajax/promocodes.php?current_result='+current_result;
	viewPromocodes();
	return false;
}
function resetSearch(currentFile) 
{
	window.location = escape(currentFile);
}
</script>
<? } ?>