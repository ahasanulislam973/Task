<?php
require_once './lib/function.php';
require_once './Configuration/Config.php';
require_once './lib/Common.php';

function update_user($givenId, $name, $email, $password)
{

    date_default_timezone_set('Asia/Dhaka'); //time zone
    $filename = "UPDATE_FILE_" . date('d-m-y') . ".txt"; // create file n
    $responseArray = array();

    if (isset($givenId)) {
        $conn = connectDB();
        $showquery = "SELECT * FROM `input` WHERE id='$givenId'";
        $result = mysqli_query($conn, $showquery);
        $newResult = mysqli_fetch_assoc($result);

        if (!isset($newResult)) {
            $responseArray['status'] = "failed";
            $responseArray['code'] = "3";
            $responseArray['message'] = "Id not found";
        } else {
            if (isset($name) || isset($email) || isset($password)) {

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

                        echo json_encode($newResult);

                        $userInfo = "Name:" . $newResult['name'] . "\n" . "Email:" . $newResult['email'] . "\n" . "Password:" . $newResult['password'] . "\n";
                        create_file($filename, $userInfo);

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

}


?>

