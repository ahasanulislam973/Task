<?php
$number=$_GET['input'];

function ArmstrongNumber($number){
$length=strlen($number);
$sum=0;
    for($i=0;$i<$length;$i++){
        $sum += pow($number[$i],$length);
    }

    return $sum;
}

echo ArmstrongNumber($number);