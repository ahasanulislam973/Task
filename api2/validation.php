<?php
require_once './lib/Common.php';
$token = $_REQUEST['token'] ?? "";

date_default_timezone_set('Asia/Dhaka'); //time zone
header('Content-Type: application/json');

$responseArray = array();
$conn = connectDB();
$sql = "SELECT token_expire_time FROM `tokendb` where token_number=$token";
$result = mysqli_query($conn, $sql);
$newResult = mysqli_fetch_assoc($result);

$token_expire_time = $newResult['token_expire_time'];
$ModifyTokenExpireTime = strtotime($token_expire_time);
$newTokenExpireTime = date("y-m-d h:i:s", $ModifyTokenExpireTime);

$current_time = date("y-m-d h:i:s");
$ModifyCurrentTime = strtotime($current_time);
$newCurrentTime = date("y-m-d h:i:s", $ModifyCurrentTime);


if ($newCurrentTime <= $newTokenExpireTime)
{
    $responseArray['status'] = "Success";
    $responseArray['Tokenvalidcode'] = "30";
    $responseArray['Tokenvalidmessage'] = "Token valid";
}

else{
    $responseArray['status'] = "Fail";
    $responseArray['Tokenvalidcode'] = "31";
    $responseArray['Tokenvalidmessage'] = "Time expire";
}
ClosedDBConnection($conn);
echo json_encode($responseArray);

?>