<?php
require_once './lib/function.php';
require_once './Configuration/Config.php';
require_once './lib/Common.php';


date_default_timezone_set('Asia/Dhaka'); //time zone
//$filename = "UPDATE_FILE_" . date('d-m-y') . ".txt"; // create file n
$filename = "UPDATE_FILE_" . (string)date("Y_m_d_A", time()) . ".txt";
$current_time = date("y-m-d h:i:s");

$responseArray = array();

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
        if (isset($_REQUEST['name']) || isset($_REQUEST['email']) || isset($_REQUEST['password'])) {

            $name = $_REQUEST['name'];
            $email = $_REQUEST['email'];
            $password = $_REQUEST['password'];

            $sql = "SELECT email FROM `input` WHERE email='$email'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {

                $responseArray['status'] = "failed";
                $responseArray['code'] = "2";
                $responseArray['message'] = "Email Already Exist";
            } else {
                $updatequery = "UPDATE input SET name='$name',email='$email',password='$password' WHERE id= '$givenId'";


                if (mysqli_query($conn, $updatequery)) {

                    $Aftershowquery = "SELECT * FROM `input` WHERE id='$givenId'";
                    $result = mysqli_query($conn, $Aftershowquery);
                    $newResult = mysqli_fetch_assoc($result);


                    $logTxt = json_encode($current_time, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                    $logTxt .= json_encode($newResult, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
                    logWrite($filename, $logTxt);

                    $responseArray['status'] = "success";
                    $responseArray['code'] = "7";
                    $responseArray['message'] = "Data update and updated information insert into the update file successfully";

                } else {
                    $responseArray['status'] = "failed";
                    $responseArray['code'] = "8";
                    $responseArray['message'] = "Do not update";
                }
            }
        }

    }

} else {

    $responseArray['status'] = "failed";
    $responseArray['code'] = "4";
    $responseArray['message'] = "Id not set";
}

echo json_encode($responseArray);


?>

