<?php
// $string=$_GET['input'];
// $string="cash in tk 1,020.00 from 01755654142 successful. fee tk 0.00. balance tk 138,698.49. trxid 7121591740 at 27/04/2017 16:58";
$string="cash in tk 1,020.00 from 01755654142 successful. fee tk 0.00. balance tk 138,698.49. trxid 7121591740 at 27/04/2017 16:58";


echo "The main string message is:"."<br>".$string;

$newstring=explode(' ',$string);
echo "<pre>";
print_r ($newstring);

$transaction_amount="transaction_amount:".$newstring[3].' '.$newstring[2]; 
 $from_account_number="from:".$newstring[5]; 
 $to_account_number="to_account_number:"."N/A";
 $transaction_fee="transaction_fee:".$newstring[9].' '.$newstring[8]; 
$account_balance="account_balance:".$newstring[12].' '.$newstring[11]; 
$transaction_id="transaction_id:".$newstring[14];
$transaction_date_time="transaction_date_time:".$newstring[16].' '.$newstring[17]; 
$created_date_time="created_date_time:"."N/A";
$transaction_type="transaction_type:".$newstring[0].' '.$newstring[1]; 
$message="message:"."N/A";




// $cash=$newstring[0];
// $in=$newstring[1];
// $amount=$newstring[3];
// $fee=$newstring[9];
// $from=$newstring[4];
// $number=$newstring[5];
// $balance=$newstring[10];
// $balancetk=$newstring[11];
// $balanceammount=$newstring[12];
// $TrxID=$newstring[13];
// $TrxIDnumber=$newstring[14];
// $date=$newstring[16];



echo "The variables are:"."<br>";
print_r($transaction_amount."<br>". $from_account_number."<br>".$transaction_fee."<br>".$to_account_number."<br>".$account_balance."<br>".$transaction_id."<br>".$transaction_date_time."<br>".$created_date_time."<br>".$transaction_type."<br>".$message);
// print_r ($cash.$in.' ' . $amount."<br>".$from.' '.$number."<br>".$balance.$balancetk.' '.$balanceammount."<br>".$TrxID.' '.$TrxIDnumber."<br>".$date."<br>".$fee);
echo "\n";