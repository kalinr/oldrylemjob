<? if($qa[0] > 0){ ?>
<script type="text/javascript">
function confirmDelete()
{
	if(confirm("Are you sure you want to delete this video?"))
		window.location = "/<? echo $content['MOD_NAME']; ?>/<? echo $qa[0]; ?>/delete";
}
function confirmDeleteImage()
{
	if(confirm("Are you sure you want to delete this image?"))
		window.location = "/<? echo $content['MOD_NAME']; ?>/<? echo $qa[0]; ?>/delete-image";
}
</script>


<? } ?>

<?
if($qa[0] != "")
{
	include_once("js/ckeditor/ckeditor.php");
	include_once('js/ckfinder/ckfinder.php');
	$CKEditor = new CKEditor();
	
	// Create a class instance.
	//$CKEditor = new CKEditor(); //no need to do this twice

	// Path to the CKEditor directory.
	$CKEditor->basePath = '/js/ckeditor/';
	
	// Set up CKFinder
	CKFinder::SetupCKEditor($CKEditor, '/js/ckfinder/');
}
?>