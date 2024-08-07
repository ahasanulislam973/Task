<?php
$servername="localhost";
$username="root";
$password="";
$database="api";

$conn=mysqli_connect($servername,$username,$password,$database);

if(!$conn)
{
    echo "Connection Faild";
}

 ?>