<?php

function recursive($number){
    $newNumber='';
    for($i=$number; $i>=1;$i--){
        $newNumber.=$i."\n";
    }
    return $newNumber;
}
echo recursive(10);
