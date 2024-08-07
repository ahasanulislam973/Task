<?php
require_once 'connection2.php';
$responseArray = array();
$mobile_number = $_REQUEST['mobile_number'];
$amount = $_REQUEST['amount'];
$payment_code = $_REQUEST['payment_code'];
$transaction_id = $_REQUEST['transaction_id'];
$status = "success";

$sql = "INSERT INTO transaction_history(transaction_id,mobile_number,amount,status)
    VALUES('$transaction_id','$mobile_number','$amount','$status')";
if (mysqli_query($conn, $sql)) {
    $responseArray['status'] = "Success";
    $responseArray['code'] = "1";
    $responseArray['message'] = "Yes";
} else {
    $responseArray['status'] = "Failed";
    $responseArray['code'] = "2";
    $responseArray['message'] = "No";
}

echo json_encode($responseArray);

?>