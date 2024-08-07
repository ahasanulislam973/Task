<?php
require_once './Configuration/Config.php';

function connectDB()
{

    global $servername;
    global $username;
    global $dbpassword;
    global $database;

    $conn = mysqli_connect($servername, $username, $dbpassword, $database); //sql connection

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        return $conn;
    }
    return $conn;
}

?>