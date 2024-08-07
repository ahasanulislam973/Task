<?php

include("connection.php");
include("functions.php");
$responseArray = array();
$id = $_REQUEST['id'] ?? "";
$update_user_id = $_POST['user_id'];
$update_user_name = $_POST['user_name'];
$update_password = $_POST['password'];
$update_date = $_POST['date'];
$newupdate_date=strtotime($update_date);
$newdate=date('y-m-d h:i:s',$newupdate_date);

$sql = "UPDATE users SET user_id='$update_user_id',user_name='$update_user_name',password='$update_password',date='$newdate' WHERE id= '$id'";


if (empty($update_user_id) || empty($update_user_name) || empty($update_password) || empty($newdate)) {

    $responseArray['status'] = "fail";
    $responseArray['code'] = "2";
    $responseArray['message'] = "Fillup all the field";
} else {
    if (mysqli_query($con, $sql)) {
        $responseArray['status'] = "success";
        $responseArray['code'] = "1";
        $responseArray['message'] = "update successfully";


    } else {
        $responseArray['status'] = "failed";
        $responseArray['code'] = "0";
        $responseArray['message'] = "Do not update";

    }
}
echo json_encode($responseArray);
mysqli_close($con);
?>