<?php
require_once './lib/function.php';
require_once './Configuration/Config.php';
require_once './lib/Common.php';
require_once 'action.php';

/*function create_user($name, $email, $password)
{*/


$name=$_REQUEST['name'] ?? "";
$email=$_REQUEST['email'] ?? "";
$password=$_REQUEST['password'] ?? "";

    $responseArray = array();
    date_default_timezone_set('Asia/Dhaka'); //time zone
    $filename = "CREATE_FILE_" . date('d-m-y') . ".txt"; // create file n


//    if (isset($name) && isset($email) && isset($password)) {

        // insart data

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
                    $userInfo = "Name:" . $name . "\n" . "Email:" . $email . "\n" . "Password:" . $password . "\n";
                    create_file($filename, $userInfo);

                    $responseArray['status'] = "success";
                    $responseArray['code'] = "1";
                    $responseArray['message'] = "Successfully insert";
                }
                mysqli_close($conn);
            }
        } else {
            $responseArray['code'] = "0";
            $responseArray['message'] = "Fail";
        }

/*    } else {

        $responseArray['status'] = "failed";
        $responseArray['code'] = "4";
        $responseArray['message'] = "Do not set all the field";
    }*/


     echo json_encode($responseArray);
//return 0;
//}

?>