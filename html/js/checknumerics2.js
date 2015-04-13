<!--
function goodchars(e, goods)
{
var key, keychar;
key = getkey(e);
if (key == null) return true;

// get character
keychar = String.fromCharCode(key);
keychar = keychar.toLowerCase();
goods = goods.toLowerCase();

// check goodkeys
if (goods.indexOf(keychar) != -1)
	return true;

// control keys
if ( key==null || key==0 || key==8 || key==9 || key==27 || key==32)
   return true;

//Enter
if ( key==13 || key==8 )
{
   alert ("Enter key not allowed. To submit information, please make sure all required fields are completed and then click the \'Continue\' button below.");
   //document.forms(0).submit();
   return false;
}

// else return false
return false;
}


function getkey(e)
{
if (window.event)
   return window.event.keyCode;
else if (e)
   return e.which;
else
   return null;
}

function zeroit(inobj)
{

var obj1 = eval("document.Form1." + inobj);

if (obj1.value=="" || obj1.value=="0" || obj1.value=="00" || obj1.value=="000" || obj1.value=="0000")
	{
	alert ("You cannot have a blank quantity or a quantity of 0. If you would like to remove an item from the cart, please use the delete option.\n\nThe selected item quantity has been reset to 1.");
	obj1.value="1";
	obj1.focus();
	return false;
	}
	
decallowed = 0;  // how many decimals are allowed?

fieldValue = obj1.value;
fieldName = obj1;

if (isNaN(fieldValue) || fieldValue == "") {
alert("The number entered is invalid.  Please try again.");
fieldName.select();
fieldName.focus();
return false;
}
else {
if (fieldValue.indexOf('.') == -1) fieldValue += ".";
dectext = fieldValue.substring(fieldValue.indexOf('.')+1, fieldValue.length);

if (dectext.length > decallowed)
{
alert ("You may only enter a number with up to " + decallowed + " decimal places.  Please try again.");
fieldName.select();
fieldName.focus();
return false;
      }
else {
// alert ("That number validated successfully.");
      }
   }
	
}
//-->
