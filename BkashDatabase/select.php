<?php
require_once 'database.php';

$sql= "SELECT * FROM `bkashsmsdb` WHERE id=33";
$result=mysqli_query($conn, $sql);

$newResult=mysqli_fetch_assoc($result);

echo "transaction_amount=".$newResult["transaction_amount"]."<br>" ."from_account_number=".$newResult["from_account_number"]."<br>"."to_account_number=".$newResult["to_account_number"]."<br>"."transaction_fee=".$newResult["transaction_fee"]."<br>"."account_balance=".$newResult['account_balance']."<br>"."transaction_id=".$newResult['transaction_id']."<br>"."transaction_date_time=".$newResult['transaction_date_time']."<br>"."transaction_type=".$newResult['transaction_type']."<br>"."message=".$newResult['message'];
