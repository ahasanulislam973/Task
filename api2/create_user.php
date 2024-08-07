<?php
require_once './lib/function.php';
require_once './Configuration/Config.php';
require_once './lib/Common.php';

$name = $_REQUEST['name'] ?? "";
$email = $_REQUEST['email'] ?? "";
$password = $_REQUEST['password'] ?? "";


$responseArray = array();
date_default_timezone_set('Asia/Dhaka'); //time zone
header('Content-Type: application/json');
$filename = "CREATE_FILE_" . (string)date("Y_m_d_A", time()) . ".txt";
$current_time = date("y-m-d h:i:s");

    if (!empty($name) && !empty($email) && !empty($password)) {

        $conn = connectDB();
        $sql = "SELECT email FROM `input` WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {

            $responseArray['status'] = "failed";
            $responseArray['code'] = "2";
            $responseArray['message'] = "Email Already Exist";
        } else {


            $sql = "INSERT INTO `input`(name,email,password)
    VALUES('$name','$email','$password')";
            if (mysqli_query($conn, $sql)) {
                $last_id = mysqli_insert_id($conn);
                $sql = "SELECT * FROM `input` where id=$last_id";
                $getValue = mysqli_query($conn, $sql);
                $showValue = mysqli_fetch_assoc($getValue);

                $logTxt = json_encode($current_time, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                $logTxt .= json_encode($showValue, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
                logWrite($filename, $logTxt);

                $responseArray['status'] = "success";
                $responseArray['code'] = "1";
                $responseArray['message'] = "Successfully insert";

            }

        }
        ClosedDBConnection($conn);
    } else {
        $responseArray['code'] = "0";
        $responseArray['message'] = "Fail";
    }

echo json_encode($responseArray);
?>