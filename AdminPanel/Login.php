<?php

require_once "database.php";

//$username = $_POST['username'];
//$password = $_POST['password'];

$sql = "SELECT * FROM `admin` WHERE id=0";
$result = mysqli_query($conn, $sql);
$newResult = mysqli_fetch_assoc($result);

if (empty($_POST['username']) || empty($_POST['password'])) {

    echo "Please fillup all the field" . "<br><br>";
    echo "<a href='Index.php'><h1>Login</h1></a>";
} else {

    if ($_POST['username'] == $newResult["Username"] && $_POST['password']== $newResult["Password"]) {

//        echo "Login successful";

//        include('AdminHomePage.php');
        session_start();
        $_SESSION['username']=$_POST['username'];
//        $_SESSION['password']=$_POST['password'];

        header("Location:AdminHomePage.php");
    } else {

        header("Location:Index.php");
    }
}





