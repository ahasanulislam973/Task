<?php
$string=$_GET['input'];
$array=explode(' ',$string);
$arrayLength=array_map('strlen',$array);
//$short=min($arrayLength);
//print_r($short);
echo "The shortest lenth is:".min($arrayLength)."<br>";
echo"The longest lenth is:".max($arrayLength);