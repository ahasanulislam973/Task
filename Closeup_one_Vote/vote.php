<?php
require_once './lib/Common.php';
require_once './lib/function.php';
$responseArray = array();
$voteInfoArray=array();
$mobile_number = $_REQUEST['mobile_number'] ?? "";
$message = $_REQUEST['message'] ?? "";
$con=connectDB();
date_default_timezone_set('Asia/Dhaka'); //time zone
header('Content-Type: application/json');
$filename = "VOTE_INFO_" . (string)date("Y_m_d_A", time()) . ".txt";
$current_time = date("y-m-d h:i:s");


if ($message != "vote A" && $message != "vote B" && $message != "vote C" && $message != "vote D" && $message != "vote E"
    && $message != "vote F" && $message != "vote G" && $message != "vote H" && $message != "vote I" && $message != "vote J") {

    $responseArray['status'] = "failed";
    $responseArray['code'] = "2";
    $responseArray['message'] = "This name there is no perticipate";
} else {
    $sql = "SELECT mobile_number FROM `votinginfo` WHERE mobile_number='$mobile_number'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {

        $responseArray['status'] = "failed";
        $responseArray['code'] = "2";
        $responseArray['message'] = "Phone number Already Exist";
    } else {
        $sql = "INSERT INTO `votinginfo`(mobile_number,message)
    VALUES('$mobile_number','$message')";
        if (mysqli_query($con, $sql)) {
            $responseArray['status'] = "Success";
            $responseArray['code'] = "1";
            $responseArray['message'] = "Insert Successfully";

            $voteInfoArray=[
                'mobile_number'=>$mobile_number,
                'message'=>$message
            ];

            $logTxt = json_encode($current_time, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            $logTxt .= json_encode($voteInfoArray, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            logWrite($filename, $logTxt);
        } else {
            $responseArray['status'] = "failed";
            $responseArray['code'] = "0";
            $responseArray['message'] = "Do not insert";
        }
    }


}

echo json_encode($responseArray);
ClosedDBConnection($con);
