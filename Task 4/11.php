<?php
/*$number=array(1,2,3,4,4,4,4,5);
 function remove_duplicate_list($number){
     $NewNumber=array_unique(($number));
     return $NewNumber;

 }

 print_r(remove_duplicate_list($number));*/
/*$number="12345";

function RemoveDuplicate($number){
    $result=' ';
    for($i=0;$i<strlen($number);$i++){
        $new=$number[$i];
        if($new!==$new){
            $result.=$new;
        }
    }

}
echo(RemoveDuplicate($number));*/


$string = "1,2,3,4,5,6,7,8,9,5,6,4,3,8,8,8,8,8,8,8,8,8";
$result = '';
$temp = array();
$array = explode(',', $string);
foreach ($array as $value) {
        $temp[$value] = $value;
}

foreach ($temp as $value2) {
    if ($value2 !== $array) {
        $result .= $value2;
    }
}
echo $result;




#############

/*$arr = array(3,5,2,5,3,9);
$temp_array = array();

foreach($arr as $val)
{
    if(isset($temp_array[$val]))
    {
        $temp_array[$val] = $val;
    }else{
        $temp_array[$val] = 0;
    }
}

foreach($temp_array as $val2)
{
    if($val2 > 0)
    {
        echo $val2 . ', ';
    }
}*/