<?php
$array1=array("volvo","toyota","BMW");
$array2=array("red","green","blue");
$array3=array();

for($i=0;$i<count($array1);$i++){
    $array3[$array1[$i]]=$array2[$i];

}

//$array3=array_merge($array1,$array2);
print_r($array3);