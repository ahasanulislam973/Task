<?php
$x="Hello world";
$y=strpos($x,"world"); // Find the position of the searching word from the given string. This is case-sensitive.
//$y=stripos($x,"world");// Find the position of the searching word from the given string. This is case-insensitive.
echo $y;