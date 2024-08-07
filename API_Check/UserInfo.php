<?php
require_once "./lib/Function.php";
require_once "./Configuration/Config.php";

$request=$_SERVER['REQUEST_METHOD'];

if($request=='POST'){
    $flag=1;
    $data= json_decode(file_get_contents('php://input'), true);
    $name=$data['name'];
    $email=$data['email'];
    $dob=$data['dob'];
    $phone=$data['phone'];

    if (strlen($name)<4){
        echo "Inter valid name";
        exit;
    }
    else{
        $flag=1;
    }

    if (!strpos($email, "@"))
    {
        echo "Enter a valid Email" . "<br>";
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
            exit;
        }
    } else {
        echo "Invalid Phone number" . "<br>";
        exit;
    }

    if ($flag == 1) {

        postMethod();
    }

}

if($request=='GET'){
    getMethod();

}

