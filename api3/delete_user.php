<?php
require_once './lib/function.php';
require_once './Configuration/Config.php';
require_once './lib/Common.php';


function delete_user($givenId)
{
    $responseArray = array();
    date_default_timezone_set('Asia/Dhaka'); //time zone
    $filename = "DELETE_FILE_" . date('d-m-y') . ".txt"; // create file n
    if (isset($givenId)) {
//        $givenId = $_REQUEST['id'];
        $conn = connectDB();

        $showquery = "SELECT * FROM `input` WHERE id='$givenId'";
        $result = mysqli_query($conn, $showquery);
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

            $deletequery = "delete from input where id =$givenId";

            if (mysqli_query($conn, $deletequery)) {

                $responseArray['status'] = "success";
                $responseArray['code'] = "7";
                $responseArray['message'] = "Data delete and deleted information insert into the delete file successfully";

            } else {
                $responseArray['status'] = "failed";
                $responseArray['code'] = "8";
                $responseArray['message'] = "Do not delete";
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



