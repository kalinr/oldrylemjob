	<script>
	function checkbiz(inobj)
	{
	if (inobj.value=="Retail")
		{
		document.getElementById('businessname').value="";
		document.getElementById('businessname').style.visibility="hidden";
		}
		else
		{
		document.getElementById('businessname').style.visibility="visible";		
		}
	}
	</script>