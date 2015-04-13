<?
function boldHotText($text, $words)
{
	$new_words = str_replace($text,"<strong><span style='color:#000;'>".$text."</span></strong>",$words);
	return trim($new_words);
}
?>