<?php
// $string=$_GET['input'];
$string="your bkash buy airtime request of tk 300.00 for 01750000327 was successful.";


echo "The main string message is:"."<br>".$string;

$newstring=explode(' ',$string);
echo "<pre>";
print_r ($newstring);
$=$newstring[0];
$sendamount=$newstring[3];
$to=$newstring[4];
$number=$newstring[5];
$fee=$newstring[9];
$feeammount=$newstring[11];
$balance=$newstring[12];
$balanceammount=$newstring[14];
$Trx=$newstring[15];
$TrxID=$newstring[16];
$date=$newstring[18];

echo "The variables are:"."<br>";
print_r ($send.' '.$sendamount."<br>".$to.' '.$number."<br>".$fee.' '.$feeammount."<br>".$balance.' '.$balanceammount."<br>".$Trx.''.$TrxID."<br>".$date);
echo "\n";