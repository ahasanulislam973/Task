<?php
function foo(&$var)
{

    $var++;
}

$a=5;
foo($a);
echo $a;
exit;

$string=$_GET['input'];
$a="red";
$array=explode(' ',$string);
array_splice($array,3,0,$a);
print_r($array);