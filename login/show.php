<?php
$responseArray = array();
require_once 'connection.php';
$id = $_REQUEST['id'];

$sql = "SELECT * FROM users WHERE id= $id";
$result = mysqli_query($con, $sql);
$newResult = mysqli_fetch_assoc($result);

$responseArray['id'] = $newResult['id'];
$responseArray['user_id'] = $newResult['user_id'];
$responseArray['user_name'] = $newResult['user_name'];
$responseArray['password'] = $newResult['password'];
$responseArray['date'] = date('y-m-d h:i:s',strtotime($newResult['date']));

echo json_encode($responseArray);
mysqli_close($con);
?>

