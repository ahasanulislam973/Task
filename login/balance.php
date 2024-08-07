<?php
$responseArray = array();
require_once 'connection2.php';
$mobile_number=$_REQUEST['mobile_number'];
$status=$_REQUEST['status'];

$sql = "INSERT INTO subscriber(mobile_number,status)
    VALUES('$mobile_number','$status')";
if (mysqli_query($conn, $sql)) {

    $responseArray['status'] = "Success";
    $responseArray['code'] = "62";
    $responseArray['message'] = "Successfully insert into subscriber table";
}

else{
    $responseArray['status'] = "Failed";
    $responseArray['code'] = "63";
    $responseArray['message'] = "Do not insert into subscriber table";
}

echo json_encode($responseArray);

?>