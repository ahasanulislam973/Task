<?php
// $string=$_GET['input'];
$string="You have received payment Tk 200.00 from 01818723483. Ref inv104335. Counter 1. Fee Tk 0.00. Balance Tk 1,250.00. TrxID 4EN44X4ALW at 23/05/2017 13:54";


echo "The main string message is:"."<br>".$string;

$newstring=explode(' ',$string);
echo "<pre>";
print_r ($newstring);
$pay=$newstring[3];
$Tk=$newstring[4]; 
$amount=$newstring[5];
$from=$newstring[6];
$Balance=$newstring[15];
$TrxID=$newstring[18];
$number=$newstring[7];
$balanceamunt=$newstring[17];
$TrxIDnumber=$newstring[19];
$date=$newstring[21];
echo "The variables are:"."<br>";
// echo $Tk .' '. $amount."<br>".;
print_r ($pay."<br>".$Tk .' '. $amount."<br>".$from.' '.$number."<br>".$Balance.' '.$balanceamunt."<br>".$TrxID.' '.$TrxIDnumber."<br>".$date);
echo "\n";


// echo "Search:"."<br>";

// $pay= array_search("payment",$newstring);
// print_r($newstring[$pay]);
// echo"<br>";
// // $phone=$string;
// $pattern= "/[0-9]{3}[\-][0-9]{6}|[0-9]{3}[\s][0-9]{6}|[0-9]{3}[\s][0-9]{3}[\s][0-9]{4}|[0-9]{11}|[0-9]{3}[\-][0-9]{3}[\-][0-9]{4}/";
// if(preg_match_all($pattern,$string,$matches)){
    
//     print_r($matches);
// }



?>