<?php
require_once 'database.php';
$id = $_REQUEST['id'];
$name = $_POST['updatename'];
$email = $_POST['updateemail'];
$phone = $_POST['updatephone'];
$dob = $_POST['updatedob'];
$flag = 1;
$sql = "UPDATE user SET Name='$name',email='$email',phone='$phone',dob='$dob' WHERE id= '$id'";

if (empty($name) || empty($email) || empty($phone) || empty($dob)) {

    echo "Please fillup all the field" . "<br>";
    include('update.php');
    exit;
} else {
    $flag = 1;
}

if (strlen($name) < 4) {
    echo "Enter a valid Name" . "<br>";
    include('update.php');
    exit;
} else {
    $flag = 1;
}
if (!strpos($email, "@")) //    if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i",$email))
{
    echo "Enter a valid Email" . "<br>";
    include('update.php');
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
        include('update.php');
        exit;
    }
} else {
    echo "Invalid Phone number" . "<br>";
    include('update.php');
    exit;
}

if ($flag == 1) {

    if (mysqli_query($conn, $sql)) {
        echo "Update successfully";

        header("Location:AdminHomePage.php");
    } else {
        echo "Do not update";

    }
}

mysqli_close($conn);
?>