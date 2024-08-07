<?php
require_once './lib/function.php';
require_once './Configuration/Config.php';
require_once './lib/Common.php';
$responseArray = array();

date_default_timezone_set("Asia/Dhaka");
header('Content-Type: application/json');
$filename = "TOKEN_NUMBER_" . (string)date("Y_m_d_A", time()) . ".txt";

if (isset($_REQUEST['tokenemail']) && isset($_REQUEST['tokenpassword'])) {
    $email = $_REQUEST['tokenemail'];
    $password = $_REQUEST['tokenpassword'];

    $conn = connectDB();
    $sql = "SELECT * FROM `input`";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($newResult = mysqli_fetch_assoc($result)) {

            if ($email == $newResult['email'] && $password == $newResult['password']) {

                $token_number = time() . rand(1111, 4444);
                $token_generate_date_time = date('y-m-d h:i:s');
                $newtime = strtotime($token_generate_date_time);
                $extendtime = $newtime + (300);
                $expire_time = date("y-m-d h:i:s", $extendtime);

                $sql = "INSERT INTO tokendb (token_number,token_generate_time,token_expire_time)
    VALUES('$token_number','$token_generate_date_time','$expire_time')";
                if (mysqli_query($conn, $sql)) {

                    $last_id = mysqli_insert_id($conn);
                    $sql = "SELECT * FROM `tokendb` where id=$last_id-1";
                    $result = mysqli_query($conn, $sql);
                    $newResult = mysqli_fetch_assoc($result);

                    $token = $newResult['token_number'];
                    $responseArray['token'] = $token;

                    $responseArray['status'] = "Success";
                    $responseArray['tokencode'] = "1";
                    $responseArray['tokenmessage'] = "Token generate successfully";



                    $sql = "SELECT * FROM `tokendb` where id=$last_id";
                    $tokenresult = mysqli_query($conn, $sql);
                    $tokennewResult = mysqli_fetch_assoc($tokenresult);

                    $logTxt = json_encode($token_generate_date_time, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                    $logTxt .= json_encode($tokennewResult, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
                    logWrite($filename, $logTxt);
                }

            } else {
                $responseArray['status'] = "Fail";
                $responseArray['tokencode'] = "0";
                $responseArray['tokenmessage'] = "Token do not generate";
            }
        }
    }
    ClosedDBConnection($conn);

} else {
    $responseArray['status'] = "Fail";
    $responseArray['tokencode'] = "2";
    $responseArray['tokenmessage'] = "Do not set all the field";
}


echo json_encode($responseArray);
?>