<?php

function getMethod(){
    require_once './Database/database.php';
    $sql= "SELECT * FROM userinfo ";
    $result=mysqli_query($conn, $sql);

    if(mysqli_num_rows($result)>0){
        $rows=array();
        while($r=mysqli_fetch_assoc($result)){
            $rows["result"][]=$r;
        }
        echo json_encode($rows);
    }
    mysqli_close($conn);
}

function deleteMethod(){
  require_once './Database/database.php';

    $sql = "DELETE FROM userinfo WHERE user_id= 0";
    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

function updateMethod(){
    require_once './Database/database.php';

    $sql = "UPDATE userinfo SET email='ahasanul@gmail.com' WHERE user_id= 0";

    if (mysqli_query($conn, $sql)) {
        echo "Update successfully";
    } else {
        echo "Do not update";
    }
    mysqli_close($conn);
}

function postMethod($data){
    require_once './Database/database.php';

    $name=$data['user_name'];
    $email=$data['user_email'];


    $sql = "INSERT INTO userinfo (user_name,user_email)
    VALUES('$name','$email')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);

}