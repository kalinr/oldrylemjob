<? if($qa[0] == "edit"){ ?>
<script type="text/javascript">
function confirmDelete()
{
	if(confirm("Are you sure you want to delete this product?"))
		window.location = "/<? echo $content['MOD_NAME']; ?>/delete/<? echo $qa[1]; ?>";
}
function confirmDeleteImage()
{
	if(confirm("Are you sure you want to delete this image?"))
		window.location = "/<? echo $content['MOD_NAME']; ?>/delete-image/<? echo $qa[1]; ?>";
}
</script>
<? $ckeditor = true; ?>
<script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/js/ckfinder/ckfinder.js"></script>
<script type="text/javascript">
function setupEditor()
{
    CKEDITOR.replace( 'editor1',
    {
        filebrowserBrowseUrl : '/js/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images',
        filebrowserFlashBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Flash',
        filebrowserUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
        height:140
    });
    <? /* ?>
     CKEDITOR.replace( 'editor2',
    {
        filebrowserBrowseUrl : '/js/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images',
        filebrowserFlashBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Flash',
        filebrowserUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    });
    CKEDITOR.replace( 'editor3',
    {
        filebrowserBrowseUrl : '/js/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images',
        filebrowserFlashBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Flash',
        filebrowserUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    });
	CKEDITOR.replace( 'editor4',
    {
        filebrowserBrowseUrl : '/js/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images',
        filebrowserFlashBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Flash',
        filebrowserUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    });
	CKEDITOR.replace( 'editor5',
    {
        filebrowserBrowseUrl : '/js/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images',
        filebrowserFlashBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Flash',
        filebrowserUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    });
	CKEDITOR.replace( 'editor0',
    {
        filebrowserBrowseUrl : '/js/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Images',
        filebrowserFlashBrowseUrl : '/js/ckfinder/ckfinder.html?Type=Flash',
        filebrowserUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl : '/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    });
	<? */ ?>
    console.log("test");
}
</script>
<? }else{ ?>

<? } ?>