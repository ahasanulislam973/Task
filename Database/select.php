<?php
require_once 'database.php';

$sql= "SELECT * FROM `employees` WHERE id=4";
$result=mysqli_query($conn, $sql);

$newResult=mysqli_fetch_assoc($result);

echo "Name:".$newResult["name"].' '."Email:".$newResult["email"].' '."Phone:".$newResult["phone"].' '."DOB:".$newResult["dob"];
