<?php
// $string=$_GET['input'];
$string="you have received tk 750.00 from 01816297770. ref inv001248. fee tk 0.00. balance tk 144,142.60. trxid 7127209752 at 28/04/2017 12:36";


echo "The main string message is:"."<br>".$string;

$newstring=explode(' ',$string);
echo "<pre>";
print_r ($newstring);


$transaction_amount="transaction_amount:".$newstring[4].' '.$newstring[3]; 
 $from_account_number="from_account_number:".$newstring[6];
 $to_account_number="to_account_number:"."N/A";
 $transaction_fee="transaction_fee:".$newstring[11].' '.$newstring[10]; 
$account_balance="account_balance:".$newstring[14].' '.$newstring[13]; 
$transaction_id="transaction_id:".$newstring[16];
$transaction_date_time="transaction_date_time:".$newstring[18].' '.$newstring[19]; 
$created_date_time="created_date_time:"."N/A";
$transaction_type="transaction_type:".$newstring[2]; 
$message="message:"."N/A";

echo "The variables are:"."<br>";
print_r($transaction_amount."<br>". $from_account_number."<br>".$transaction_fee."<br>".$to_account_number."<br>".$account_balance."<br>".$transaction_id."<br>".$transaction_date_time."<br>".$created_date_time."<br>".$transaction_type."<br>".$message);
echo "\n";