<?php

//include("connection.php");
$responseArray = array();
//$id=$_REQUEST['id'] ?? "";
$user_id=$_REQUEST['user_id'] ?? "";
$user_name=$_REQUEST['user_name'] ?? "";
$password=$_REQUEST['password'] ?? "";
$date=$_REQUEST['date'] ?? "";

$responseArray['code'] =901;
$responseArray['result'] = $user_name;

echo json_encode($responseArray);
?>