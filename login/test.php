<?php

$jsonData= '[{"mobile_number":"01774382608","status":"registered","created_at":"2022-12-21 15:34:47","updated_at":"2022-12-21 15:34:53","registration_date":"2022-12-21 15:34:55","deregistration_date":"2022-12-21 15:34:59"},{"mobile_number":"01309605438","status":"registered","created_at":"2022-12-21 16:58:58","updated_at":"2022-12-21 16:58:58","registration_date":"2022-12-21 16:58:58","deregistration_date":"2022-12-21 16:58:58"}]'; // put here your json object
$arrayData = json_decode($jsonData, true);
if (isset($arrayData['data']))
{
foreach ($arrayData['data'] as $data)
{
echo 'mobile_number='.$data['mobile_number'].', status='.$data['status'].'<br>';
}
}

?>