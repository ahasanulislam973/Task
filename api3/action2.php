<?php
$misd="FIFA-ON";
$responseArray = array();

if (isset($_REQUEST['phone'])) {
    $msisdn = $_REQUEST['phone'];

//    $url = "http://pulse-adminv2.local/api4/phone_number_validation.php?phone=$msisdn";

   echo $url="http://localhost/api4/phone_number_validation.php?phone=$msisdn";

    $response = file_get_contents($url);
    $decoded = json_decode($response);
    $code = $decoded->code;

    if ($code == 1) {
        $responseArray['code'] = "1";
        $responseArray['message'] = "success";
    }
     else {
        $responseArray['code'] = "0";
        $responseArray['message'] = "Fail";
    }
}

else {
    $responseArray['status'] = "failed";
    $responseArray['code'] = "2";
    $responseArray['message'] = "Do not set phone number";
}

/*if(!empty($misd)){

    $url = "http://pulse-adminv2.local/api4/message_validation.php?message=$misd";
}*/

echo json_encode($responseArray);
?>
