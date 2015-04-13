<script type="text/javascript">
function confirmDelete(id)
{
	if(confirm("Are you sure you want to delete this category? This will delete the brands under it?"))
		window.location = "/<? echo $content['MOD_NAME']; ?>/delete/"+id;
}
</script>