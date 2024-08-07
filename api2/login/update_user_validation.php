<?php
session_start();
include("connection.php");
include("functions.php");
$user_data = check_login($con);

$id = $_REQUEST['id'] ?? "";
$update_user_id = $_POST['update_user_id'];
$update_user_name = $_POST['update_user_name'];
$update_password = $_POST['update_password'];
$update_date = $_POST['update_date'];

$sql = "UPDATE users SET user_id='$update_user_id',user_name='$update_user_name',password='$update_password',date='$update_date' WHERE id= '$id'";


if (empty($update_user_id) || empty($update_user_name) || empty($update_password) || empty($update_date)) {

    echo "Please fillup all the field" . "<br>";
//    header("Location:update.php");

} else {
    if (mysqli_query($con, $sql)) {
        echo "Update successfully";

        header("Location:index.php");
    } else {
        echo "Do not update";

    }
}

mysqli_close($con);
?>