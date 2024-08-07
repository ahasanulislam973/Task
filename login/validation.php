<?php
require_once 'connection2.php';
$responseArray = array();

$payment_code = $_REQUEST['payment_code'];

$sql = "SELECT code FROM codes WHERE code=$payment_code AND status='unused'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $newResult = mysqli_fetch_assoc($result);

    $responseArray['status'] = "Success";
    $responseArray['code'] = "20";
    $responseArray['message'] = "Valid";

    $status = "used";
    $updatequery = "UPDATE codes SET status='$status' WHERE code= '$payment_code'";
    mysqli_query($conn, $updatequery);

} else {

    $responseArray['status'] = "Failed";
    $responseArray['code'] = "0";
    $responseArray['message'] = "Invalid";
}

echo json_encode($responseArray);
?>


