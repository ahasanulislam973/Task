<?php
require_once './lib/function.php';
require_once './Configuration/Config.php';
require_once './lib/Common.php';
//$givenId = $_REQUEST['id'];


function show_user($givenId)
{
    $responseArray = array();
    date_default_timezone_set('Asia/Dhaka'); //time zone
    $filename = "SHOW_FILE_" . date('d-m-y') . ".txt"; // create file n

    if (isset($givenId)) {
//        $givenId = $_REQUEST['id'];
        $sql = "SELECT * FROM `input` WHERE id='$givenId'";

        $conn = connectDB();
        $result = mysqli_query($conn, $sql);
        $newResult = mysqli_fetch_assoc($result);


        if (!isset($newResult)) {

            $responseArray['status'] = "failed";
            $responseArray['code'] = "3";
            $responseArray['message'] = "Id not found";
        } else {

            $name = $newResult['name'];
            $email = $newResult['email'];
            $password = $newResult['password'];

            $userInfo = "Name:" . $name . "\n" . "Email:" . $email . "\n" . "Password:" . $password . "\n";
            create_file($filename, $userInfo);
            echo json_encode($newResult) . "<br><br>";

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
}

?>


