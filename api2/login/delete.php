<?php
session_start();
include("connection.php");
include("functions.php");
$user_data = check_login($con);

$id = $_REQUEST['id'];
$sql = "DELETE FROM users WHERE id=$id";
if (mysqli_query($con, $sql)) {
    header("Location:index.php");

} else {
    echo "Error deleting record: " . mysqli_error($con);
}
?>