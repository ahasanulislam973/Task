<?php
//$string=$_GET['input'];
//$array=explode(' ',$string);
/*$reverse=array_reverse($array);
echo "The reverse array is:"."<br>";
print_r($reverse);*/
$array=array("red","green","blue");
for($i=0;$i<count($array);$i--){
    print_r($array($i));
}