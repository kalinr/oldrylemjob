<!--
function up(inobj)
{
var obj = document.getElementById(inobj);
if (obj.value=='0') 
	{
	val=1;
	}
	else
	{
	val = parseInt(obj.value);
	val = val + 1;
	if (val > 999) {val = '0';}	
	}
	
obj.value = val;	
}

function down(inobj)
{
var obj = document.getElementById(inobj);
if (obj.value=='')
	{
	val='0';
	}
	else
	{
	val = parseInt(obj.value);
	val = val - 1;
	if (val < 0 || val==0) {val = '0';}	
	}

	obj.value = val;

}
//-->