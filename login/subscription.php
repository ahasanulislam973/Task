<?php

$response = file_get_contents('php://input');
$json = json_decode($response, true);

$toStatus = $json['toStatus'];
$msisdn = $json['userInfo']['msisdn'];
$operator = $json['userInfo']['operator'];
$status1 = "registered";
$status2 = "deregistered";
$status3 = "Suspended";

if ($toStatus == 'Active') {
    $mobile_number = $msisdn;
    $status = $status1;
    subscription($mobile_number, $status);

} elseif ($toStatus == 'Deactive') {
    $mobile_number = $msisdn;
    $status = $status2;
    subscription($mobile_number, $status);
} else {
    $mobile_number = $msisdn;
    $status = $status3;
    subscription($mobile_number, $status);
}

function subscription($mobile_number, $status)
{
    require_once 'connection2.php';
    $responseArray = array();
    $sql = "INSERT INTO `subscriber`(mobile_number,status)
    VALUES('$mobile_number','$status')";
    if (mysqli_query($conn, $sql)) {

        $responseArray['status'] = "success";
        $responseArray['code'] = "1";
        $responseArray['message'] = "Insert successfully";

    } else {
        $responseArray['status'] = "Fail";
        $responseArray['code'] = "0";
        $responseArray['message'] = "Do not insert";
    }
    echo json_encode($responseArray);
    /*    print "<pre>";
        print_r($responseArray);
        print "</pre>";*/

    mysqli_close($conn);

}

?>





