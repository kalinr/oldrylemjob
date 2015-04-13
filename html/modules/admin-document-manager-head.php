<script type="text/javascript">
function confirmDelete(filename)
{
	if(confirm("Are you sure you want to delete?"))
		window.location = "/<? echo $content['MOD_NAME']; ?>/0/delete/"+escape(filename);
}
</script>