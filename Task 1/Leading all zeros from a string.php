<?php

$string="00000458728";
//$newstring=trim($string,"0");//remove first and last zero
$newstring=ltrim($string,"0");//remove first zero
//$newstring=rtrim($string,"0");//remove right zero
echo $newstring;
//echo str_replace("75088","7588","75088");//remove middle zero

?>