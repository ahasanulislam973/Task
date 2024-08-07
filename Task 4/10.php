<?php
$string="Nine Four Five Zero One Three";
$result=' ';
$array=explode(' ',$string);
foreach($array as $value){
    switch(trim($value)){
        case 'Zero':
            $result .='0';
            break;
        case 'One':
            $result .='1';
            break;
        case 'Two':
            $result .='2';
            break;
        case 'Three':
            $result .='3';
            break;
        case 'Four':
            $result .='4';
            break;
        case 'Five':
            $result .='5';
            break;
        case 'Six':
            $result .='6';
            break;
        case 'Seven':
            $result .='7';
            break;
        case 'Eight':
            $result .='8';
            break;
        case 'Nine':
            $result .='9';
            break;
        default:
            $result="None";

    }

}
echo $result;