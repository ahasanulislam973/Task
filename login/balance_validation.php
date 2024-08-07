<?php
$responseArray=array();
require_once 'connection.php';
$id=$_REQUEST['id'];
$amount=$_REQUEST['amount'];

$query="select balance from users where id=$id";

$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) > 0) {
    $newResult = mysqli_fetch_assoc($result);
    $user_balance=$newResult['balance'];

    if($amount<=$user_balance)
    {
        $responseArray['status']='success';
        $responseArray['code']='52';
        $responseArray['status']='Sufficient balance';

        $new_user_balance=$user_balance-$amount;

        $updatequery = "UPDATE users SET balance='$new_user_balance' WHERE id= '$id'";
        mysqli_query($con, $updatequery);
    }

    else{
        $responseArray['status']='Fail';
        $responseArray['code']='53';
        $responseArray['message']='InSufficient balance';
    }
}

echo json_encode($responseArray);