<?php
require_once 'connection2.php';

if (isset($_REQUEST['mobile_number'])) {
    $mobile_number = $_REQUEST['mobile_number'];
    $subscriberInfoArray = array();
    $sql = "SELECT * FROM subscriber where mobile_number=$mobile_number";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result)) {
        while ($rows = mysqli_fetch_assoc($result)) {

            $subscriberInfoArray[] = [
                'mobile_number' => $rows['mobile_number'],
                'status' => $rows['status'],
                'created_at' => $rows['created_at'],
                'updated_at' => $rows['updated_at'],
                'registration_date' => $rows['registration_date'],
                'deregistration_date' => $rows['deregistration_date']

            ];
        }

        echo json_encode($subscriberInfoArray);


    }
} else {

    $subscriberInfoArray = array();
    $sql = "SELECT * FROM subscriber";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result)) {
        while ($rows = mysqli_fetch_assoc($result)) {

            $subscriberInfoArray[] = [
                'mobile_number' => $rows['mobile_number'],
                'status' => $rows['status'],
                'created_at' => $rows['created_at'],
                'updated_at' => $rows['updated_at'],
                'registration_date' => $rows['registration_date'],
                'deregistration_date' => $rows['deregistration_date']

            ];
        }

        echo json_encode($subscriberInfoArray);


    }
}

?>
