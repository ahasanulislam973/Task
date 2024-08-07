<?php

require_once './configuration/config.php';

function connectDB()
{

    global $dbhost;
    global $dbuser;
    global $dbpass;
    global $dbname;

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname); //sql connection

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        return $conn;
    }
    return $conn;
}

function ClosedDBConnection($conn)
{

    mysqli_close($conn);
}

