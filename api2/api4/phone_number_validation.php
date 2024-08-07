<?php
require_once './lib/Common.php';
$phone_number=$_REQUEST['phone'] ?? "";

$responseArray = array();

if(!empty($phone_number))
{

    $conn = connectDB();

    $sql = "INSERT INTO phone_number_db(phone_number)
    VALUES('$phone_number')";

    if (mysqli_query($conn, $sql)){

        $responseArray['status'] = "success";
        $responseArray['code'] = "1";
        $responseArray['message'] = "phone number insert successfully";
    }

    else{
        $responseArray['status'] = "failed";
        $responseArray['code'] = "0";
        $responseArray['message'] = "Phone number do not insert";
    }




}
echo json_encode($responseArray);
?>