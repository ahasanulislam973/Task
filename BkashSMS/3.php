<?php
// $string=$_GET['input'];
$string="payment tk 50,000.00 to 01713131327 successful. ref loan2. counter 1. fee tk 0.00. balance tk 90,528.49. trxid 7188191193 at 06/05/2017 17:34";


echo "The main string message is:"."<br>".$string;

$newstring=explode(' ',$string);
echo "<pre>";
print_r ($newstring);


$transaction_amount="transaction_amount:".$newstring[2].' '.$newstring[1]; 
 $from_account_number="from_account_number:"."N/A";
 $to_account_number="to_account_number:".$newstring[4];
 $transaction_fee="transaction_fee:".$newstring[11].' '.$newstring[12]; 
$account_balance="account_balance:".$newstring[15].' '.$newstring[14]; 
$transaction_id="transaction_id:".$newstring[17];
$transaction_date_time="transaction_date_time:".$newstring[19].' '.$newstring[20]; 
$created_date_time="created_date_time:"."N/A";
$transaction_type="transaction_type:".$newstring[0]; 
$message="message:"."N/A";

echo "The variables are:"."<br>";
print_r($transaction_amount."<br>". $from_account_number."<br>".$transaction_fee."<br>".$to_account_number."<br>".$account_balance."<br>".$transaction_id."<br>".$transaction_date_time."<br>".$created_date_time."<br>".$transaction_type."<br>".$message);
echo "\n";