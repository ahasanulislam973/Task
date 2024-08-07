<?php
//$string="He is a bad boy";
$string=$_GET['input'];
$findstring="payment";
$pos=strpos($string,$findstring);

if($pos!==false){
    echo "Found";
}
else{
    echo "Not Found";
}
?>