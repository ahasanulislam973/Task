<?php
include("connection.php");
$id = $_REQUEST['id'];

$sql = "SELECT * FROM users WHERE id= $id";
$result = mysqli_query($con, $sql);
$rows = mysqli_fetch_assoc($result);

$user_id=$rows['user_id'];
$user_name=$rows['user_name'];
$password=$rows['password'];
$date=$rows['date'];



?>




