<?php

$responseArray = array();

if(isset($_REQUEST['phone']))
{
    $phone=$_REQUEST['phone'];

    $url= "http://pulse-adminv2.local/api4/phone_number_validation.php?phone=$phone";
}

else{
    $responseArray['status'] = "failed";
    $responseArray['code'] = "2";
    $responseArray['message'] = "Do not send";
}

echo json_encode($responseArray);
?>