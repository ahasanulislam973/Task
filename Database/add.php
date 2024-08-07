<?php
//date_default_timezone_set('Asia/Dhaka');
require_once 'database.php';
//extract($_REQUEST);
$name=$_REQUEST['name'];
$email=$_REQUEST['email'];
$phone=$_REQUEST['phone'];
$dob=$_REQUEST['dob'];
$newdob=date('Y-m-d', strtotime($dob));
$sql = "INSERT INTO `employees`(name,email,phone,dob)
    VALUES('$name','$email','$phone','$newdob')";
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
