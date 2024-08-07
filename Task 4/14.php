<?php
$number="123";

function sumEachNumber($number){
    $sum=0;
    for($i=0;$i<strlen($number);$i++){

        $sum=$sum+$number[$i];
    }
    return $sum;
}
echo sumEachNumber($number);