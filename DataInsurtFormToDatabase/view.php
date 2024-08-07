<?php
require_once 'database.php';
/*$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$dob = $_POST['dob'];*/
$flag=1;
extract($_POST);

/*if(isset($submit)){
    if(empty($name)){
        echo "Name required";
        $flag=0;
    }

    if(empty($email)){
        echo "Emai required";
        $flag=0;
    }

    if(empty($phone)){
        echo "Phone is required";
        $flag=0;
    }

    if(empty($dob)){
        echo "DOB required";
        $flag=0;
    }


}

if($flag=0){
    echo "Do not submit";
}


else{
    $sql="INSERT INTO employees (name,email,phone,dob)
    VALUES('$name','$email','$phone','$dob')";
}*/

if(empty($name)||empty($email)||empty($phone)||empty($dob)){
    echo "Please fillup all the field"."<br>";
    $flag=0;
    exit;
}

if(strlen($name)>5)
{
    echo "Name is too long";

    $flag = 0;
    exit;
}

else{
    $flag = 1;
}
if(strpos($email,'@'))
{
//    echo "Valid email";
    $flag= 1;
}

else{
    echo "Invalid Email"."<br>";
    $flag= 0;
}
if($flag==0){

    echo "Do not insert";
}


else {
        $sql = "INSERT INTO employees (name,email,phone,dob)
    VALUES('$name','$email','$phone','$dob')";
        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
        }
    }








//////////////////////////////////////////////////////////////////////
/*$uploadOk = 1;
//if (isset($submit)) {
//    echo "submitted";

    if (empty($name)) {
        echo "Name is required" . "<br>";
        $uploadOk = 0;

    } else {
//    echo "Name is:" . $name . "<br>";
        $name;
        $uploadOk = 1;
    }

    if (empty($email)) {
        echo "Email is required" . "<br>";
        $uploadOk = 0;

    }

    else {
        $email;
        $uploadOk = 1;

       if (strpos($email, '@') == true) {
//             echo "Email is:" . $email . "<br>";
              $email;
             $uploadOk = 1;
         } else {
             echo "This is not a valid email" . "<br>";
             $uploadOk = 0;

         }

    }

    if (empty($phone)) {
        echo "Phone number is required" . "<br>";
        $uploadOk = 0;

    } else {
//    echo "Phone is:" . $phone . "<br>";
        $phone;
        $uploadOk = 1;

    }

    if (empty($dob)) {
        echo "DOB is required" . "<br>";
        $uploadOk = 0;

    } else {
//    echo "Dob is:" . $dob;
        $dob;
        $uploadOk = 1;

    }


if ($uploadOk == 0) {
    echo "Do not insert";
} else {
    $sql = "INSERT INTO employees (name,email,phone,dob)
    VALUES('$name','$email','$phone','$dob')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    }
}*/


/////////////////////////////////////////////////////
//$newdob=date('Y-m-d', strtotime($dob));
/*$sql="INSERT INTO employees (name,email,phone,dob)
    VALUES('$name','$email','$phone','$dob')";
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}*/

//echo $name.$email.$phone;