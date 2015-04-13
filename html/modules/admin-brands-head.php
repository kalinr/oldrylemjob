<script type="text/javascript">
function confirmDelete(id)
{
	if(confirm("Are you sure you want to delete this Brand?"))
		window.location = "/<? echo $content['MOD_NAME']; ?>/delete/"+id;
}
function confirmDeleteImage()
{
	if(confirm("Are you sure you want to delete this image?"))
		window.location = "/<? echo $content['MOD_NAME']; ?>/delete-image/<? echo $qa[1]; ?>";
}
</script>