<?
$dir_list = dirList ("documents");
if(sizeof($dir_list) > 0)
{
?>
<table cellpadding="0" cellspacing="0" border="0" id="resultstable" style="width:100%">
<tr>
	<th>Filename</th>
	<th>Link</th>
	<th style="width: 60px;">&nbsp;</th>
</tr>
<? foreach($dir_list as $i){ ?>
<tr>
	<td class="leftcell"><a href="/documents/<? echo $i; ?>"><? echo $i; ?></a></td>
	<td>/documents/<? echo $i; ?></td>
	<td style="text-align: center;"><a href="javascript:confirmDelete('<? echo $i; ?>')">delete</a></td>
</tr>

<?
	}
	?>
	</table>
<?
}
?>
<form action="/<? echo $content['MOD_NAME']; ?>" method="post" id="myform" enctype="multipart/form-data">
<p><strong>Upload A Document</strong><br /></p>
<p><input type="file" name="FILE" /></p>
<p><input type="submit" name="BUTTON" value="Upload" /></p>
<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
</form>