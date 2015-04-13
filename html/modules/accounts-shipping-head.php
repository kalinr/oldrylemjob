<script type="text/javascript">
function confirmDelete()
{
	if(confirm("Are you sure you want to delete this address?"))
		window.location = "/<? echo $content['MOD_NAME']; ?>/<? echo $query_array[0].'/'.$query_array[1]; ?>/delete";
}
</script>

