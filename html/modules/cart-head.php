<script type="text/javascript">
function confirmRemove(productid)
{
	if(confirm("Are you sure you want to remove this product?"))
		window.location= "/cart/"+escape(productid)+"/remove";
}
function submitform()
{
  document.getElementById('cart').submit();
}
function checkout2()
{
	if(document.getElementById('AGREE').checked)
		window.location = "/cart/0/checkout2";
	else
		alert("You must check the box that you agree to the terms of agreement before you can continue checkout.");
}
function checkout3()
{
	<? if($hasorder){ ?>
	alert("Your account requires has a minimum order of $<? echo $minimum_dollar; ?> in order to checkout.");
	<? }else{ ?>
	alert("Your account requires has a minimum order of $<? echo $minimum_dollar; ?> on your first order to checkout.");
	<? } ?>
}
function confirmSaveCart()
{
	if(confirm("Are you sure you want to save your cart? This will allow you to keep the items you have in your cart and resume shopping at your next login."))
		window.location = "/<? echo $content['MOD_NAME']; ?>/0/save-cart";
}
function emptyCart() {
  var prompt = confirm("This will clear your cart of all items. Continue?");
  if (prompt) {
    window.location= "/cart/0/wipecart";
  }  
}
</script>
<script src="/js/checknumerics2.js" type="text/javascript"></script>