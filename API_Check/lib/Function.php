<?php

function postMethod(){
    require_once 'Common.php';

/*    $name=$data['name'];
    $email=$data['email'];
    $dob=$data['dob'];
    $phone=$data['phone'];*/

global $name;
global $email;
global $dob;
global $phone;
    $cn=connectDB();

    $sql = "INSERT INTO userinfo (name,email,dob,phone)
    VALUES('$name','$email','$dob','$phone')";
    if (mysqli_query($cn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($cn);
    }

    mysqli_close($cn);

}


function getMethod(){
    require_once 'Common.php';
   $cn=connectDB();

    $sql= "SELECT * FROM userinfo ";
    $result=mysqli_query($cn, $sql);

    if(mysqli_num_rows($result)>0){
        $rows=array();
        while($r=mysqli_fetch_assoc($result)){
            $rows["result"][]=$r;
        }
        echo json_encode($rows);
    }
    mysqli_close($cn);
}