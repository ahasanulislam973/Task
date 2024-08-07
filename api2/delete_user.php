<?php
require_once './lib/function.php';
require_once './Configuration/Config.php';
require_once './lib/Common.php';


$responseArray = array();
date_default_timezone_set('Asia/Dhaka'); //time zone
header('Content-Type: application/json');
$filename = "DELETE_FILE_" . (string)date("Y_m_d_A", time()) . ".txt";
$current_time = date("y-m-d h:i:s");

if (isset($_REQUEST['id'])) {
    $givenId = $_REQUEST['id'];
    $conn = connectDB();

    $showquery = "SELECT * FROM `input` WHERE id='$givenId'";
    $result = mysqli_query($conn, $showquery);
    $newResult = mysqli_fetch_assoc($result);


    if (!isset($newResult)) {

        $responseArray['status'] = "failed";
        $responseArray['code'] = "3";
        $responseArray['message'] = "Id not found";

    } else {
        $last_id = mysqli_insert_id($conn);
        $sql = "SELECT * FROM `input` where id=$givenId";
        $getValue = mysqli_query($conn, $sql);
        $showValue = mysqli_fetch_assoc($getValue);

        $logTxt = json_encode($current_time, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $logTxt .= json_encode($showValue, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        logWrite($filename, $logTxt);

        $deletequery = "delete from input where id =$givenId";

        if (mysqli_query($conn, $deletequery))
        {
            $responseArray['status'] = "success";
            $responseArray['code'] = "7";
            $responseArray['message'] = "Data delete and deleted information insert into the delete file successfully";

        } else {
            $responseArray['status'] = "failed";
            $responseArray['code'] = "8";
            $responseArray['message'] = "Do not delete";
        }
    }

    ClosedDBConnection($conn);
} else {

    $responseArray['status'] = "failed";
    $responseArray['code'] = "4";
    $responseArray['message'] = "Id not set";
}

echo json_encode($responseArray);

?>



