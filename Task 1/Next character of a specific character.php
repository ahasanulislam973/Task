<?php
$character='a';
$character=$_GET['input'];
//echo $character;


$next_character=++$character;

if(strlen($next_character)>1)
{
    $next_character=$next_character[0];
    
}
echo $next_character;


?>