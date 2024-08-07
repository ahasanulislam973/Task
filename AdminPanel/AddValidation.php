<?php
require_once "database.php";

$flag = 1;

extract($_POST);

if (isset($submit)) {

    if (empty($name) || empty($email) || empty($phone) || empty($dob)) {
        echo "Please fillup all the field" . "<br>";
        include('add.php');
        exit;
    } else {
        $flag = 1;
    }

    if (strlen($name) < 4) {
        echo "Enter a valid Name" . "<br>";
        include('add.php');
        exit;
    } else {
        $flag = 1;
    }
    if (!strpos($email, "@")) //    if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i",$email))
    {
        echo "Enter a valid Email" . "<br>";
        include('add.php');
        exit;
    } else {
        $flag = 1;
    }

    if (strlen($phone) == 13 || strlen($phone) == 11) {
        $tenDigitPhone = substr($phone, '-10'); // last 10 digit of a inputed phone number

        $FirstTwoDigit = substr($tenDigitPhone, 0, 2);//first 2 digit of 10 digit phone number

        $operateorCodeArray = array("17", "18", "19", "13", "14", "15");//array for BD operator code

        if (in_array($FirstTwoDigit, $operateorCodeArray)) { //search BD phone number from array
            $flag = 1;
        } else {
            echo "Not a valid number";
            include('add.php');
            exit;
        }
    } else {
        echo "Invalid Phone number" . "<br>";
        include('add.php');
        exit;
    }
//    }
}

if ($flag == 1) {

    $sql = "INSERT INTO user (Name,email,phone,dob)
    VALUES('$name','$email','$phone','$dob')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
        include('AdminHomePage.php');
    }
}

