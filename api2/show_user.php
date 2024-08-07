<?php
require_once './lib/function.php';
require_once './Configuration/Config.php';
require_once './lib/Common.php';

$responseArray = array();
date_default_timezone_set('Asia/Dhaka'); //time zone
$current_time = date("y-m-d h:i:s");
header('Content-Type: application/json');
$filename = "SHOW_FILE_" . (string)date("Y_m_d_A", time()) . ".txt";
//$filename = "SHOW_FILE_" . date('d-m-y') . ".txt"; // create file n

if (isset($_REQUEST['id'])) {
    $givenId = $_REQUEST['id'];
    $sql = "SELECT * FROM `input` WHERE id='$givenId'";

    $conn = connectDB();
    $result = mysqli_query($conn, $sql);
    $newResult = mysqli_fetch_assoc($result);


    if (!isset($newResult)) {

        $responseArray['status'] = "failed";
        $responseArray['code'] = "3";
        $responseArray['message'] = "Id not found";
    } else {

        $logTxt = json_encode($current_time, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $logTxt .= json_encode($newResult, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        logWrite($filename, $logTxt);
//            echo json_encode($newResult) . "<br><br>";

        $responseArray['status'] = "success";
        $responseArray['code'] = "6";
        $responseArray['message'] = "Data insert into the file successfully";

    }
} else {

    $responseArray['status'] = "failed";
    $responseArray['code'] = "4";
    $responseArray['message'] = "Id not set";
}


echo json_encode($responseArray);


?>


