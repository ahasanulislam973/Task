<?php
$phone = $_REQUEST['input'];

/*$tenDigitPhone = substr($phone, '-10'); // last 10 digit of a inputed phone number

$FirstTwoDigit = substr($tenDigitPhone, 0, 2);//first 2 digit of 10 digit phone number

$operateorCodeArray = array("17", "18", "19", "13", "14", "15");//array for BD operator code

if (in_array($FirstTwoDigit, $operateorCodeArray)) { //search BD phone number from array

    echo "valid phone number";
} else {
    echo "Not a valid number";
}*/



if(strlen($phone)==13||strlen($phone)==11){

    $tenDigitPhone = substr($phone, '-10'); // last 10 digit of a inputed phone number

    $FirstTwoDigit = substr($tenDigitPhone, 0, 2);//first 2 digit of 10 digit phone number

    $operateorCodeArray = array("17", "18", "19", "13", "14", "15");//array for BD operator code

    if (in_array($FirstTwoDigit, $operateorCodeArray)) { //search BD phone number from array

        echo "valid phone number";
    } else {
        echo "Not a valid number";
    }

}
else{
    echo "invalid";
}


