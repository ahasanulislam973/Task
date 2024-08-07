<?php
// $string=$_GET['input'];
$string="send money tk 3,000.00 to 01611272324 successful. ref technobd. fee tk 5.00. balance tk 145,722.60. trxid 7161422330 at 02/05/2017 23:34";


echo "The main string message is:"."<br>".$string;

$newstring=explode(' ',$string);
echo "<pre>";
print_r ($newstring);
$transaction_amount="transaction_amount:".$newstring[3].' '.$newstring[2]; 
$from_account_number="from_account_number:"."N/A";
$to_account_number="to_account_number:".$newstring[5];
$transaction_fee="transaction_fee:".$newstring[11].' '.$newstring[10]; 
$account_balance="account_balance:".$newstring[14].' '.$newstring[13]; 
$transaction_id="transaction_id:".$newstring[16];
$transaction_date_time="transaction_date_time:".$newstring[18].' '.$newstring[19]; 
$created_date_time="created_date_time:"."N/A";
$transaction_type="transaction_type:".$newstring[0].$newstring[1]; 
$message="message:"."N/A";

echo "The variables are:"."<br>";
print_r($transaction_amount."<br>". $from_account_number."<br>".$transaction_fee."<br>".$to_account_number."<br>".$account_balance."<br>".$transaction_id."<br>".$transaction_date_time."<br>".$created_date_time."<br>".$transaction_type."<br>".$message);
echo "\n";