<?php
require_once "database.php";
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM user";
$result = mysqli_query($conn, $sql);
$newResult = mysqli_fetch_assoc($result);

if (empty($username) || empty($password)) {

    echo "Please fillup all the field" . "<br><br>";
    echo "<a href='Index.php'><h1>Login</h1></a>";
} else {

    if ($username == $newResult["Username"] && $password == $newResult["Password"]) {

//        echo "Login successful";

//        include('AdminHomePage.php');
        header("Location:AdminHomePage.php");
    } else {

        header("Location:Index.php");
    }
}