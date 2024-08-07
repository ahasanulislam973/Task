<?php
$string="techstudy";
$c=0;
//$a=substr_count($string,"t");
//echo "The count number of 't' from 'techstudy' is:".' '.$a;

for($i=0;$i<strlen($string);$i++){
    if($string[$i]=="t"){
        $c+=1;
    }

}
echo "The total amount of 't'  in the string is:".' '. $c;