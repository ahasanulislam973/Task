
<?php
$str = "Hello World";
echo $str . "<br>";
echo trim($str,"Hello!")."<br>"; //The trim() function removes whitespace and other predefined characters from both sides of a string.
echo ltrim($str,'He')."<br>"; //The ltrim() function removes whitespace or other predefined characters from the left side of a string.
echo rtrim($str,'world'); //The rtrim() function removes whitespace or other predefined characters from the right side of a string.
?>